<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $customer_id = $_POST["customer_id"];
    $subject = $_POST["subject"];
    $invoice_date = $_POST["invoice_date"];
    $due_date = $_POST["due_date"];
    // $terms = $_POST["terms"];
     $sales_person= null;
    if(isset($_POST["sales_person"])){
    $sales_person = $_POST["sales_person"];
    }
    $address = $_POST["remarks"];
    $toc = $_POST["toc"];
    $mail_to = $_POST["mail_to"];
    
    $sqlInvoice = "INSERT INTO zw_orders (customer_id, `subject`, order_date, shipment_date, sales_person, `address`, remarks, mail_to)
            VALUES ('$customer_id', '$subject', '$invoice_date', '$due_date',  '$sales_person', '$address', '$toc', '$mail_to')";
    
    if (mysqli_query($con, $sqlInvoice)) {
         alert("Order inserted successfully.");
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

        $sqlItems = "INSERT INTO zw_order_items (order_id, item_id, quantity, rate, discount)
                VALUES ('$invoice_id', '$itemId', '$quantity', '$rate', '$discount')";
        
        if (mysqli_query($con, $sqlItems)) {
          redirect("manage.php?t=orders");
          
        } else {
            alert("Error: " . mysqli_error($con));
        }
    }
}
?>

    <h2>Create Order</h2>
    <form method="post" class="row" action="">
        <div class='col-md-3'>
            <label for="customer_id">Select Customer</label>
            <select id="customer_id" class='form-select' name="customer_id" required>
                <option value="" disabled selected>Select Customer</option>
                <?php optionPrintAdv("zw_customers WHERE customer_type ='epr'","id","customer_display_name"); ?>
            </select>
        </div>
        <div class='col-md-3'>
            <label for="subject">Subject</label>
            <input type='text' class='form-control' name='subject' required>
        </div>
        <div class='col-md-3'>
            <label for="invoice_date">Order Date</label>
            <input type='date' class='form-control' name='invoice_date' required>
        </div>
            <input type='hidden' class='form-control' name='due_date' value="<?php echo date('Y-m-d'); ?>">
        
        <div class='col-md-6'>
            <label for="mail_to">Mail To (BCC Email)</label>
            <input type='email' class='form-control' name='mail_to'>
        </div>
        <div class='col-md-6'>
            <label for="sales_person">Select Salesperson</label>
            <select id="sales_person" class='form-select' name="sales_person" >
                <option value="" disabled selected>Select Salesperson</option>
                <?php optionPrintAdv("zw_user WHERE user_role='4'","id","username"); ?>
            </select>
        </div>
        <div class='col-md-6'>
            <label for="remarks">Address</label>
            <textarea class='form-control' name='remarks' rows='3'></textarea>
        </div>
        <div class='col-md-6'>
            <label for="toc">Remarks</label>
            <textarea class='form-control' name='toc' rows='3'></textarea>
        </div>
        
        <style>input[type='text'],select{padding:10px 21px;border:1px solid gray;border-radius:8px;transform:scale(0.96);}</style>
        
        <h3>Order Items:</h3>
        <div id="items">
            <!-- Create the first item select with options from zw_items table -->
            <div class="item-group row">
                <select class="col-md-3 item-select" name="item_id[]" required>
                    <option selected disabled value="">Select an item</option>
                    <?php optionPrintAdv("zw_items","id","name"); ?>
                </select>
                <input type="text" class="col-md-3" name="quantity[]" placeholder="Quantity" required>
                <input type="text" class="col-md-3" name="rate[]" placeholder="Rate" required>
                <input type="text" class="col-md-3" name="discount[]" placeholder="Discount">
            </div>
        </div>
        <button type="button" id="addItem">Add Item</button>
        <div>
            <button type="submit">Submit</button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addItemButton = document.getElementById('addItem');
            const itemsContainer = document.getElementById('items');

            addItemButton.addEventListener('click', function () {
                // Create a new item input group
                const itemGroup = document.createElement('div');
                itemGroup.classList.add('row');
                itemGroup.classList.add('item-group');

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
                quantityInput.classList.add('col-md-3');

                const rateInput = document.createElement('input');
                rateInput.type = 'text';
                rateInput.name = 'rate[]';
                rateInput.placeholder = 'Rate';
                rateInput.required = true;
                rateInput.classList.add('col-md-3');

                const discountInput = document.createElement('input');
                discountInput.type = 'text';
                discountInput.name = 'discount[]';
                discountInput.placeholder = 'Discount';
                discountInput.classList.add('col-md-3');

                // Append the inputs to the item group
                itemGroup.appendChild(quantityInput);
                itemGroup.appendChild(rateInput);
                itemGroup.appendChild(discountInput);

                // Add the item group to the items container
                itemsContainer.appendChild(itemGroup);
            });
        });
    </script>
</body>
</html>