

<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// echo "<pre>";
// print_r($_POST);
// echo "</pre>"; die;
 $query =  "SELECT * FROM `zw_orders` where id = $uid";
$data = mysqli_query($con , $query);
$res = mysqli_fetch_assoc($data);
$sqlItems = "select  * FROM zw_order_items WHERE order_id = $uid";
$dataItems = mysqli_query($con , $sqlItems);
$resItmes = mysqli_fetch_assoc($dataItems);

        
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$deleteItemsQuery = "DELETE FROM zw_order_items WHERE order_id = $uid";
mysqli_query($con, $deleteItemsQuery);

// Update invoice details
$customer_id = $_POST["customer_id"];
$subject = $_POST["subject"];
$order_date = $_POST["order_date"];
$shipment_date = $_POST["shipment_date"];
$sales_person = $_POST["sales_person"];
$remarks = $_POST["remarks"];
$terms = $_POST["terms"];
$mail_to = $_POST["mail_to"];
$subTotal = $_POST['subTotal'];
$sqlInvoice = "UPDATE zw_orders SET 
    customer_id = '$customer_id', 
    subject = '$subject', 
    order_date = '$order_date', 
    shipment_date = '$shipment_date', 
    sales_person ='$sales_person', 
    remarks ='$remarks', 
    terms ='$terms', 
    mail_to ='$mail_to' ,
    
    subTotal = '$subTotal' 
    WHERE id = $uid";

mysqli_query($con, $sqlInvoice);

// Insert new items
$itemIds = $_POST["item_id"];
$quantities = $_POST["quantity"];
$rates = $_POST["rate"];
$discounts = $_POST["discount"];

for ($i = 0; $i < count($itemIds); $i++) {
    $itemId = $itemIds[$i];
    $quantity = $quantities[$i];
    $rate = $rates[$i];
    $discount = $discounts[$i];

    $sqlItems = "INSERT INTO zw_order_items (order_id, item_id, quantity, rate, discount)
                 VALUES ('$uid', '$itemId', '$quantity', '$rate', '$discount')";

    if (mysqli_query($con, $sqlItems)) {
        // Item inserted successfully
    } else {
        echo "Error: " . mysqli_error($con);
    }
}


  header('Location: https://zwindia.in/sub/epr/manage.php?t=orders');
 
}
?>
    <h2>Update Order</h2>
    <form method="post" class="row" action="">
        <div class='col-md-3'>
            <label for="customer_id">Select Customer</label>
            <select id="customer_id" class='form-select' name="customer_id" required>
                <option value="" disabled>Select Customer</option>
                <?php optionPrintAdv("zw_customers WHERE customer_type!='ulb'","id","customer_display_name"); ?>
            </select>
        </div>
        <div class='col-md-3'>
            <label for="subject">Subject</label>
            <input type='text' class='form-control' name='subject' value= "<?php echo $res['subject']?>" required>
        </div>
        <div class='col-md-3'>
            <label for="order_date">Quote Date</label>
            <input type='date' class='form-control' name='order_date' value= "<?php echo $res['order_date']?>" required>
        </div>
        <div class='col-md-3'>
            <label for="shipment_date">Due Date</label>
            <input type='date' class='form-control' name='shipment_date' value= "<?php echo $res['shipment_date']?>" required>
        </div>
        <div class='col-md-6'>
            <label for="mail_to">Mail To (BCC Email)</label>
            <input type='email' class='form-control' name='mail_to' value= "<?php echo $res['mail_to']?>">
        </div>
        <div class='col-md-6'>
            <label for="sales_person">Select Salesperson</label>
            <select id="sales_person" class='form-select' name="sales_person" >
                <option value="" disabled >Select Salesperson</option>
                <?php optionPrintAdv("zw_user WHERE user_role='4'","id","username" , $res['sales_person']); ?>
            </select>
        </div>
        <div class='col-md-6'>
            <label for="remarks">Remarks</label>
            <textarea class='form-control' name='remarks' rows='3' ><?php echo $res['remarks']?></textarea>
        </div>
        <div class='col-md-6'>
            <label for="terms">terms</label>
            <textarea class='form-control' name='terms' rows='3' ><?php echo $res['terms']?></textarea>
        </div>
        <div class='col-md-3'>
            // <label for="terms">Sub Total</label>
            <input type='hidden' class='form-control' name='subTotal' id="subTotal" value= "<?php echo $res['subTotal']?>"  readonly>
        </div>
        
        <style>input[type='text'],select{padding:10px 21px;border:1px solid gray;border-radius:8px;transform:scale(0.96);}</style>
        
        
        <h3 style='margin-top:21px;'>Order Items:</h3>
            <div id="items">
            <!-- Create the item groups based on the data -->
            <?php 
                $sqlItems = "SELECT * FROM zw_order_items WHERE order_id = $uid";
               $dataItems = mysqli_query($con, $sqlItems);
                        // echo "<pre>";
                        // print_r($dataItems);
                        // echo "</pre>";
                if ($dataItems) {
                    while ($resItems = mysqli_fetch_assoc($dataItems)) {
                        // echo "<pre>";
                        // print_r($resItems);
                        // echo "</pre>";
                        $itid = $resItems['item_id']; ?>
               <div class="item-group row table_row" >
                <select class="col-md-3 item-select " name="item_id[]" required>
                    <option  disabled value="">Select an item</option>
                    <?php optionPrintAdv("zw_items","id","name" , $resItems['item_id']); ?>
                </select>
                <input type="text" class="col-md-3 quantity" name="quantity[]" placeholder="Quantity" value = "<?php echo $resItems['quantity']?>" required>
                <input type="text" class="col-md-3 rate"  name="rate[]" placeholder="Rate" value = "<?php echo $resItems['rate']?>" required>
                <input type="text" class="col-md-3 productDiscount" name="discount[]" value = "<?php echo $resItems['discount']?>" placeholder="Discount">
            </div>
            <?php } } ?>
        
            <!-- Create the first item group for adding new items -->
            
        </div>

        <button type="button" id="addItem">Add Item</button>
        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
 </div>
    <script>
              // Function to calculate subtotal
  function calculateSubTotal() {
    let subTotal = 0;
    $('.table_row').each(function() {
      var row = $(this);
      var quantityValue = parseFloat(row.find('.quantity').val()) || 0;
      var rateValue = parseFloat(row.find('.rate').val()) || 0;
      var productDiscountValue = parseFloat(row.find('.productDiscount').val()) || 0;
      subTotal += (quantityValue * rateValue) -  productDiscountValue;
    });
    $('#subTotal').val(subTotal.toFixed(2)); // Display with 2 decimal places
  }

  // Attach change event handler using event delegation
  $(document).on('change', '.quantity, .rate, .productDiscount', function() {
    calculateSubTotal();
  });
 document.addEventListener('DOMContentLoaded', function () {
    const addItemButton = document.getElementById('addItem');
    const itemsContainer = document.getElementById('items');

    addItemButton.addEventListener('click', function () {
        // Create a new item input group
        const itemGroup = document.createElement('div');
        itemGroup.classList.add('row');
        itemGroup.classList.add('item-group' , 'row' , 'table_row');

        // Clone the first item select with options
        const itemSelect = document.querySelector('.item-select').cloneNode(true);

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
        quantityInput.classList.add('col-md-3','quantity');

        const rateInput = document.createElement('input');
        rateInput.type = 'text';
        rateInput.name = 'rate[]';
        rateInput.placeholder = 'Rate';
        rateInput.required = true;
        rateInput.classList.add('col-md-3','rate');

        const discountInput = document.createElement('input');
        discountInput.type = 'text';
        discountInput.name = 'discount[]';
        discountInput.placeholder = 'Discount (in INR)';
        discountInput.classList.add('col-md-2','productDiscount');

        // Create a delete button
        const deleteButton = document.createElement('button');
        deleteButton.textContent = 'Delete';
        deleteButton.classList.add('col-md-1', 'btn', 'btn-danger', 'delete');
        deleteButton.addEventListener('click', function () {
            // Remove the item group when the delete button is clicked
            itemsContainer.removeChild(itemGroup);
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
$(document).on('click' ,'.delete' , function(){
  calculateSubTotal();
})
</script>
</body>
</html>