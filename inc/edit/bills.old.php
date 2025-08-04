    <?php
        ini_set ('display_errors', 1);  
ini_set ('display_startup_errors', 1);  
error_reporting (E_ALL); 
$query = "SELECT * FROM `zw_Bill` where id = $uid";
$data = mysqli_query($con, $query);
$res = mysqli_fetch_assoc($data);
$sqlItems = "SELECT * FROM zw_Bill_items WHERE bill_id = {$res['id']}";
$dataItems = mysqli_query($con, $sqlItems);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $customer_id = $_POST["customer_id"];
    $subject = $_POST["subject"];
    $invoice_date = $_POST["invoice_date"];
    $due_date = $_POST["due_date"];
    //$terms = $_POST["terms"];
    $sales_person = $_POST["sales_person"];
    $remarks = $_POST["remarks"];
    $toc = $_POST["toc"];
    $mail_to = $_POST["mail_to"];
     $subTotal = $_POST['subTotal'];
    $sqlInvoice = "UPDATE zw_Bill
              SET customer_id = '$customer_id',
                  subject = '$subject',
                  bill_date = '$invoice_date',
                  due_date = '$due_date',
                  terms = '$terms',
                  sales_person = '$sales_person',
                  remarks = '$remarks',
                  toc = '$toc',
                  mail_to = '$mail_to' ,
                  subTotal = '$subTotal' 
              WHERE id = $uid";

    
    if (mysqli_query($con, $sqlInvoice)) {
         alert("Bill Updated successfully.");
    } else {
        alert("Error: " . mysqli_error($con));
    }

    $invoice_id = mysqli_insert_id($con);

    $itemIds = $_POST["item_id"];
    $quantities = $_POST["quantity"];
    $rates = $_POST["rate"];
    $discounts = $_POST["discount"];

    for ($i = 0; $i < count($itemIds); $i++) {
        $itemId = $itemIds[$i];
        $quantity = $quantities[$i];
        $rate = $rates[$i];
        $discount = $discounts[$i];

        $sqlItems = "UPDATE zw_Bill_items
            SET quantity = '$quantity',
                rate = '$rate',
                discount = '$discount'
            WHERE bill_id = '$invoice_id' AND item_name = '$itemId'";

        
        if (mysqli_query($con, $sqlItems)) {
        } else {
            alert("Error: " . mysqli_error($con));
        }
        header('Location: https://employee.tidyrabbit.com/sub/epr/manage.php?t=bill');
    }
}
?>
    <h2>Update Bill</h2>
    <form method="post" class="row" action="">
        <div class='col-md-3'>
            <label for="customer_id">Select Vendor</label>
            <select id="customer_id" class='form-select' name="customer_id" required>
                <option value="" disabled>Select Vendor</option>
                <?php optionPrintAdv("zw_company","id","company_name" , $res['customer_id']); ?>
            </select>
        </div>
        <div class='col-md-3'>
            <label for="subject">Subject</label>
            <input type='text' class='form-control' name='subject' value = "<?php echo $res['subject']?>" required>
        </div>
        <div class='col-md-3'>
            <label for="invoice_date">Bill Date</label>
            <input type='date' class='form-control' name='invoice_date' value = "<?php echo $res['bill_date']?>" required>
        </div>
        <div class='col-md-3'>
            <label for="due_date">Due Date</label>
            <input type='date' class='form-control' name='due_date' value = "<?php echo $res['due_date']?>" required>
        </div>
        <div class='col-md-6'>
            <label for="mail_to">Mail To (BCC Email)</label>
            <input type='email' class='form-control' name='mail_to' value = "<?php echo $res['mail_to']?>">
        </div>
        <div class='col-md-6'>
            <label for="sales_person">Select Salesperson</label>
            <select id="sales_person" class='form-select' name="sales_person" required>
                <option value="" disabled>Select Salesperson</option>
                <?php optionPrintAdv("zw_user WHERE user_role='4'","id","username" , $res['sales_person']); ?>
            </select>
        </div>
        <div class='col-md-6'>
            <label for="remarks">Remarks</label>
            <textarea class='form-control' name='remarks' rows='3'><?php echo $res['remarks']?></textarea>
        </div>
        <div class='col-md-6'>
            <label for="toc">TOC</label>
            <textarea class='form-control' name='toc' rows='3'><?php echo $res['toc']?></textarea>
        </div>
        <div class='col-md-3'>
            <label for="toc">Sub Total</label>
            <input type='text' class='form-control' name='subTotal' id="subTotal" readonly>
        </div>
        
        <style>input[type='text'],select{padding:10px 21px;border:1px solid gray;border-radius:8px;transform:scale(0.96);}</style>
        
        <h3>Invoice Items:</h3>
        <div id="items">
            <!-- Create the first item select with options from zw_items table -->
         
          <?php if(mysqli_num_rows($dataItems) >= 1){
           foreach($resItmes as $itemData) { ?>
            <div class="item-group row table_row">
               <!-- <select class="col-md-3 item-select " name="item_id[]" required>
                    <option  disabled value="">Select an item</option>
                    <?php optionPrintAdv("zw_items","id","name" , $itemData['item_name']); ?>
                </select> -->
             <input type="text" class="col-md-3 itemName" name="item_id[]" value = "<?php echo $itemData['item_name']?>"  placeholder="Item Name" required>
                <input type="text" class="col-md-3 quantity" name="quantity[]" placeholder="Quantity" value = "<?php echo $itemData['quantity']?>" required>
                <input type="text" class="col-md-3 rate" name="rate[]" placeholder="Rate" value = "<?php echo $itemData['rate']?>" required>
                <input type="text" class="col-md-3 productDiscount" name="discount[]" value = "<?php echo $itemData['discount']?>" placeholder="Discount">
            </div>
            <?php }} else { ?>
            <div class="item-group row table_row">
                <!--<select class="col-md-3 item-select" name="item_id[]" required>
                    <option  disabled value="">Select an item</option>
                    <?php optionPrintAdv("zw_items","id","name"); ?>-->
                </select>
                <input type="text" class="col-md-3 itemName" name="item_id[]"  placeholder="Item Name" required>
                <input type="text" class="col-md-3 quantity" name="quantity[]" placeholder="Quantity" required>
                <input type="text" class="col-md-3 rate" name="rate[]" placeholder="Rate" required>
                <input type="text" class="col-md-3 productDiscount" name="discount[]" placeholder="Discount">
            </div>
            <?php }?>
            
        </div>
        <button type="button" id="addItem">Add Item</button>
        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
</div>
   <!-- Add this JavaScript code inside your <script> tag -->
<script>
  // Function to calculate subtotal
  function calculateSubTotal() {
      console.log("Function Call");
    let subTotal = 0;
    $('.table_row').each(function() {
      var row = $(this);
      var quantityValue = parseFloat(row.find('.quantity').val()) || 0;
      var rateValue = parseFloat(row.find('.rate').val()) || 0;
      var productDiscountValue = parseFloat(row.find('.productDiscount').val()) || 0;
      subTotal += (quantityValue * rateValue) - productDiscountValue;
    });
    $('#subTotal').val(subTotal.toFixed(2)); // Display with 2 decimal places
  }

  // Attach change event handler using event delegation
  $(document).on('change', '.quantity, .rate, .productDiscount', function() {
    calculateSubTotal();
  });

  document.addEventListener('DOMContentLoaded', function() {
    const addItemButton = document.getElementById('addItem');
    const itemsContainer = document.getElementById('items');
	
    addItemButton.addEventListener('click', function() {
      // Create a new item input group
      const itemGroup = document.createElement('div');
      itemGroup.classList.add('row');
      itemGroup.classList.add('item-group', 'row', 'table_row');

      // Clone the first item select with options
      const itemSelect = document.querySelector('.itemName').cloneNode(true);

      // Reset the cloned item select to its default value
      itemSelect.selectedIndex = 0;

      // Append the cloned item select to the item group
      itemGroup.appendChild(itemSelect);

      // Create quantity, rate, and discount inputs
      const quantityInput = document.createElement('input');
      quantityInput.type = 'text';
      quantityInput.name = 'quantity[]';
      quantityInput.placeholder = 'Quantity';
      quantityInput.required = true;
      quantityInput.classList.add('col-md-3', 'quantity');

      const rateInput = document.createElement('input');
      rateInput.type = 'text';
      rateInput.name = 'rate[]';
      rateInput.placeholder = 'Rate';
      rateInput.required = true;
      rateInput.classList.add('col-md-3', 'rate');

      const discountInput = document.createElement('input');
      discountInput.type = 'text';
      discountInput.name = 'discount[]';
      discountInput.placeholder = 'Discount (in INR)';
      discountInput.classList.add('col-md-2', 'productDiscount');

      // Create a delete button
      const deleteButton = document.createElement('button');
      deleteButton.textContent = 'Delete';
      deleteButton.classList.add('col-md-1', 'btn', 'btn-danger', 'delete');
      deleteButton.addEventListener('click', function() {
        // Remove the item group when the delete button is clicked
        itemsContainer.removeChild(itemGroup);
        calculateSubTotal(); // Recalculate subtotal after item is deleted
      });

      // Append the inputs and delete button to the item group
      itemGroup.appendChild(quantityInput);
      itemGroup.appendChild(rateInput);
      itemGroup.appendChild(discountInput);
      itemGroup.appendChild(deleteButton);

      // Add the item group to the items container
      itemsContainer.appendChild(itemGroup);
    });
  });
</script>

</body>
</html>