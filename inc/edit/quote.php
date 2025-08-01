

<?php

 ini_set('display_errors', 1); ini_set('display_startup_errors', 1);  error_reporting(E_ALL);

// echo "<pre>";
// print_r($_POST);
// echo "</pre>"; die;
$query =  "SELECT * FROM `zw_Quote` where id = $uid";
$data = mysqli_query($con , $query);
$res = mysqli_fetch_assoc($data);


        
if ($_SERVER["REQUEST_METHOD"] == "POST") {

// Update invoice details
$customer_id = $_POST["customer_id"];
$subject = $_POST["subject"];
$quote_date = $_POST["quote_date"];
$sales_person = $_POST["sales_person"];
$remarks = $_POST["remarks"];
$toc = $_POST["toc"];
$mail_to = $_POST["mail_to"];
$subTotal = $_POST['total_amount'];
$sqlInvoice = "UPDATE zw_Quote SET 
    customer_id = '$customer_id', 
    subject = '$subject', 
    quote_date = '$quote_date', 
    sales_person ='$sales_person', 
    remarks ='$remarks', 
    toc ='$toc', 
    mail_to ='$mail_to' ,
    subTotal = '$subTotal' 
    WHERE id = $uid";

// Insert new items
$itemIds = $_POST["item_id"];
$quantities = $_POST["quantity"];
$rates = $_POST["rate"];
$discounts = $_POST["discount"];


$deleteItemsQuery = "DELETE FROM zw_Quote_items WHERE quote_id = $uid";
mysqli_query($con, $deleteItemsQuery);

for ($i = 0; $i < count($itemIds); $i++) {
    $itemId = $itemIds[$i];
    $quantity = $quantities[$i];
    $rate = $rates[$i];
    $discount = $discounts[$i];

    $sqlItems = "INSERT INTO zw_Quote_items (quote_id, item_id, quantity, rate, discount)
                 VALUES ('$uid', '$itemId', '$quantity', '$rate', '$discount')";

    if (mysqli_query($con, $sqlItems)) {
    // Item inserted successfully
    } else {
        echo "Error: " . mysqli_error($con);
    }
}


if(mysqli_query($con, $sqlInvoice)){header('Location: manage.php?t=quote');}else{
    alert("We're sorry, There was some error");
}

}

?>
    <div class="d-flex justify-content-between">
    <h2>Update Quote</h2>
    <a href="?type=convert_in_invoice&id=<?php echo $uid; ?>" class="btn btn-primary">Convert to Invoice</a>
    </div>
    <form method="post" class="row" action="">
        <div class='col-md-3'>
            <label for="customer_id">Select Customer</label>
            <select id="customer_id" class='form-select' name="customer_id" required value = "">
                <option value="" disabled>Select Customer</option>
                <?php optionPrintAdv("zw_customers WHERE customer_type!='ulb'","id","customer_display_name"); ?>
            </select>
        </div>
        <div class='col-md-3'>
            <label for="subject">Subject</label>
            <input type='text' class='form-control' name='subject' value= "<?php echo $res['subject']?>" required>
        </div>
        <div class='col-md-3'>
            <label for="quote_date">Quote Date</label>
            <input type='date' class='form-control' name='quote_date' value= "<?php echo $res['quote_date']?>" required>
        </div>
        <div class='col-md-6'>
            <label for="mail_to">Mail To (BCC Email)</label>
            <input type='email' class='form-control' name='mail_to' value= "<?php echo $res['mail_to']?>">
        </div>
        <div class='col-md-6'>
            <label for="sales_person">Select Salesperson</label>
            <select id="sales_person" class='form-select' name="sales_person" required>
                <option value="" disabled >Select Salesperson</option>
                <?php optionPrintAdv("zw_user WHERE user_role='4'","id","username" , $res['sales_person']); ?>
            </select>
        </div>
        <div class='col-md-6'>
            <label for="remarks">Remarks</label>
            <textarea class='form-control' name='remarks' rows='3' ><?php echo $res['remarks']?></textarea>
        </div>
        <div class='col-md-6'>
            <label for="toc">TOC</label>
            <textarea class='form-control' name='toc' rows='3' ><?php echo $res['toc']?></textarea>
        </div>
        
        <style>input[type='text'],select{padding:10px 21px;border:1px solid gray;border-radius:8px;transform:scale(0.96);}</style>
        
        
        
                    <div class="col-sm-12 mt-5 p-0">
                        <!-- <h6 class="text-right text-primary">Bulk Update Line Items</h6> -->
                         <?php  $sqlItems = "SELECT * FROM zw_Quote_items WHERE quote_id = $uid"; $dataItems = mysqli_query($con , $sqlItems);
                            while ($resItem = mysqli_fetch_assoc($dataItems)) { ?>
                        <table class="table table-bordered table_row" width="100%">
                            <thead>
                                <th>Item Detail</th>
                                <th>Quantity</th>
                                <th>Rate</th>
                                <th>Amount</th>
                                <th>Disocunt</th>
                                <th width= '5%'></th>
                            </thead>
                           
                                <tr>
                                    <td>
                                        <select class="item-select" name="item_id[]" required>
                                            <option selected disabled value="">Select an item</option>
                                            <?php optionPrintAdv("zw_items", "id", "name", $resItem['item_id']); ?>
                                        </select>
                                    </td>
                                    <td><input type="text" class="col-md-5 quantity" name="quantity[]" placeholder="Quantity" value="<?php echo $resItem['quantity']; ?>" required></td>
                                    <td><input type="text" class="col-md-5 rate" name="rate[]" placeholder="Rate" value="<?php echo $resItem['rate']; ?>" required></td>
                                    <td class="lineItemAmount">0.0</td>
                                    <td><input type="text" class="col-md-5 discount" name="discount[]" value="<?php echo $resItem['discount']; ?>" placeholder="Discount (in INR)" value="0"></td>
                                    <td width= '5%'><button class="btn text-danger delete" title='Remove This Line'><i class='mi-x-circle'></i></button></td>
                                </tr>
                        </table>
                            <?php } ?>

                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="d-flex flex-column p-0">
                                <div class="col-sm-12 p-0"><button class="btn btn-muted" type="button" id="addItem">Add another
                                        line</button></div> 
                                <div class="col-sm-12 p-0" style="margin-top: 170px;">
                                    <h4>Customer Notes</h4>
                                    <textarea class="form-control" type="text"
                                        placeholder="Thanks for your business" name='customerNotes'><?php echo $res['remarks']?></textarea>
                                    <!--<h6><small class="text-muted">Will be displayed on the invoice</small></h6>-->
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <table class="table table-borderless total_table" width="100%">
                                <tr width="100%">
                                    <th width="33%">Sub Total</th>
                                    <td width="33%"><input type="hidden" name = "total_amount" class ="total_amount" value="<?php echo $res['subTotal']?>"></td>
                                    <td class="text-right" width="34%" id = "subTotal"><?php echo $res['subTotal']?></td>
                                </tr>
                                <tr width="100%">
                                    <th width="33%">Discount</th>
                                    
                                    <td width="33%"><input type="hidden" name = "discount-total" class ="total_discount" value = "<?php echo $res['discount_total']?>"></td>
                                    <td width="34%" class="text-right" id = "discount-total" ></td>
                                </tr>
                                <tr width="100%">
                                    <th width="33%">Adjustments</th>
                                    <td width="33%"></td>
                                    <td width="30%" class="text-right"  ><input type = "number"  id ="shipping-Charges"  name ="shipping-Charges" class="col-md-8" min=0 value = "<?php echo $res['shippingCharges']?>"></td>
                                </tr>
                                                              <tr width="100%">
                                    <th width="33%">Total</th>
                                    <td width="33%"></td>
                                    <td width="34%" class="text-right" id="total_amount">0.00</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-bordered" width="100%">
                            <tr>
                                <td width="50%">
                                    <div>
                                        <h6>Terms and Conditions</h6>
                                        <textarea class="form-control" type="text"
                                            placeholder="Enter terms and condiions of your business." name ="terms_cond"><?php echo $res['toc']?></textarea>
                                    </div>
                                </td>
                                <td width="50%">
                                    <div>
                                        <h6>Attached file to invoice</h6>
                                        <input type="file" class="form-control">
                                        <h6><small>You can upload maximum 10 files, 5MB each</small></h6>
                                    </div>
                                </td>
                            </tr>

                        </table>
                    </div>
                    <div class= "row">
                        <div class = "col-md-2"><input type = "submit" name = "submit" class = "submit" value ="Submit"></div>
                        <div class = "col-md-1"><input type = "reset" name = "reset" class = "reset" value ="Reset"></div>
                    </div>
                </div>
            </div>
           
        </form>
 </div>
      
<script>
    // Function to calculate subtotal
    function calculateSubTotal() {
        let subTotal = 0;
	let total_discount = 0;
	let amount_without_discount = 0;
	let shipping_Charges = $('#shipping-Charges').val();
        
        $('.table_row').each(function() {
            var row = $(this);
            var quantityValue = parseFloat(row.find('.quantity').val()) || 0;
            var discount = parseFloat(row.find('.discount').val()) || 0;
            var rateValue = parseFloat(row.find('.rate').val()) || 0;
            var gstValue = parseFloat(row.find('.gst').val()) || 0;
            var productDiscountValue = parseFloat(row.find('.discount').val()) || 0;
		lineItemAmount = (rateValue * quantityValue) + (gstValue * rateValue * quantityValue)/100;

	   row.find('.lineItemAmount').text(lineItemAmount);
		amount_without_discount += lineItemAmount;
            total_discount += productDiscountValue;
            subTotal += (quantityValue * rateValue) - productDiscountValue;
        });
        
	subTotal = subTotal - shipping_Charges;
        $('#subTotal').text(amount_without_discount.toFixed(2)); // Display with 2 decimal places
        $('#discount-total').text(total_discount.toFixed(2)); // Display with 2 decimal places
        $('.total_discount').val(total_discount.toFixed(2));
	$('#total_amount').text(subTotal);
	$('.total_amount').val(subTotal);
        // Show or hide the delete buttons based on row count
        if ($('.table_row').length >= 2) {
            $('.delete').show();
        } else {
            $('.delete').hide();
        }
    }

    // Attach change event handler using event delegation
    $(document).on('change', '.quantity, .rate, .gst , .discount, #shipping-Charges', function() {
        calculateSubTotal();
    });

    $(document).ready(function() {
        // Function to add a new row
        function addNewRow() {
          var newRow = $('.table_row:first').clone();
          newRow.find('select, input').val('');
          newRow.find('.lineItemAmount').text('0.00');
          newRow.insertAfter('.table_row:last');
        
          // Check if there's at least one table row (including the newly added one)
          if ($('.table_row').length > 1) {
              $('thead').hide(); // Hide thead if there's more than one row
              $('.table_row:first').find('thead').show();
          }
        
          calculateSubTotal();
        }

        // Handle the "Add another line" button click
        $('#addItem').on('click', function() {
            addNewRow();
            $('thead').hide();$('.table_row:first').find('thead').show();
        });

        // Handle delete buttons
        $(document).on('click', '.delete', function() {
            $(this).closest('.table_row').remove();
            calculateSubTotal();
            $('thead').hide();$('.table_row:first').find('thead').show();
        });

        // Initial calculation of subtotal
        calculateSubTotal();
    });
</script>
<script>
    $(document).ready(function() {
      // Remove the "table-dark" class from all tables with the specified class
      $('table.table-dark').removeClass('table-dark');
    });
    
    function validateInput(inputField) {
	  const validValues = [5, 12, 18, 28];
	 
	  const inputValue = parseInt(inputField.value, 10); // Parse the input as an integer

	  if (!isNaN(inputValue) && validValues.includes(inputValue)) {
	    // Input is a valid value
	    inputField.value = inputValue; // Update the input value to the valid value
	    calculateSubTotal();
	  } else {
	    // Input is not a valid value, clear the input field or provide feedback
	    inputField.value = ''; // Clear the input field
	    calculateSubTotal();
	    // You can also provide feedback to the user, e.g., show an error message.
	  }
	}
	
	
  </script>



<script>
    $(document).ready(function () {
        // Attach a change event handler to the date input
        $('#invoice_date').on('change', function () {
            // Your code here
            var selectedDate = $(this).val();
            var selectedTerms = $('#terms').val();
            
            // Convert the date string to a JavaScript Date object
		var originalDate = new Date(selectedDate);
		
		// Add 30 days to the date
		var newDate = new Date(originalDate);
		
		if(selectedTerms === 'Due on receipt'){
			newDate.setDate(newDate.getDate() + 0);
		}else if(selectedTerms === 'Net 15'){
			newDate.setDate(newDate.getDate() + 15);
		}else if(selectedTerms === 'Net 30'){
			newDate.setDate(newDate.getDate() + 30);
		}else if(selectedTerms === 'Net 45'){
			newDate.setDate(newDate.getDate() + 45);
		}
		
		
		// Format the new date as "YYYY-MM-DD"
		var duedate = newDate.toISOString().slice(0, 10);
		
		// Display the result
		console.log(duedate);
            
            $('#due_date').val(duedate);
        });
        
        $('#terms').on('change', function () {
            // Get the selected value of the select box
            var selectedTerms = $('#terms').val();
            var selectedDate = $('#invoice_date').val();
            
            // Convert the date string to a JavaScript Date object
		var originalDate = new Date(selectedDate);
		
		var newDate = new Date(originalDate);
		
		if(selectedTerms === 'Due on receipt'){
			newDate.setDate(newDate.getDate() + 0);
		}else if(selectedTerms === 'Net 15'){
			newDate.setDate(newDate.getDate() + 15);
		}else if(selectedTerms === 'Net 30'){
			newDate.setDate(newDate.getDate() + 30);
		}else if(selectedTerms === 'Net 45'){
			newDate.setDate(newDate.getDate() + 45);
		}
		
		// Format the new date as "YYYY-MM-DD"
		var duedate = newDate.toISOString().slice(0, 10);
		
		// Display the result
		console.log(duedate);
            
            $('#due_date').val(duedate);
        });
    });
</script>