<?php

 ini_set ('display_errors', 1); ini_set ('display_startup_errors', 1);  error_reporting (E_ALL); 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $customer_id = $_POST["customer_id"];
    $subject = $_POST["subject"];
    $invoice_date = $_POST["invoice_date"];
    $due_date = $_POST["due_date"];
    //$toc = $_POST["toc"];
    $remarks = $_POST["remarks"];
    $toc = $_POST["toc"];
    $mail_to = $_POST["mail_to"];
    $subTotal = $_POST['total_amount'];
    $file = uploadImage("bill_receipt", "uploads/bill_receipt");
    
    $sqlInvoice = "INSERT INTO zw_Bill (customer_id, subject, bill_date, subTotal, due_date, remarks, toc, mail_to, file_src)
            VALUES ('$customer_id', '$subject', '$invoice_date','$subTotal', '$due_date', '$remarks', '$toc', '$mail_to', '$file')";
    
    if (mysqli_query($con, $sqlInvoice)) {
         //alert("Bill inserted successfully.");
    } else {
        alert("Error: " . mysqli_error($con));
    }

    $invoice_id = mysqli_insert_id($con);

    $itemIds = $_POST["item_id"];
    $itAccs = $_POST["item_account"];
    $quantities = $_POST["quantity"];
    $rates = $_POST["rate"];
    $discounts = $_POST["discount"];

    for ($i = 0; $i < count($itemIds); $i++) {
        $itemName = $itemIds[$i];
        $quantity = $quantities[$i];
        $itAcc = $itAccs[$i];
        $rate = $rates[$i];
        $discount = $discounts[$i];

        $sqlItems = "INSERT INTO zw_Bill_items (bill_id, item_name, item_account, quantity, rate, discount)
                VALUES ('$invoice_id', '$itemName', '$itAcc', '$quantity', '$rate', '$discount')";
        
        if (mysqli_query($con, $sqlItems)) {
            alert("Bill Added"); redirect("manage.php?t=bill&g=prc");
        } else {
            alert("Error: " . mysqli_error($con));
        }
    }
}

?>



<style>
    .form-group {
        width: 100%;
  margin-bottom: 14px;
    }

    .total_table th,
    .total_table td {
        border: none;
    }
    
    .col-form-label{
    	color: #000 !important;
    }
    
    .form-control:focus ,input:focus{border: 1px solid #000!important;color:green!important;}
    .form-control,.form-select,.item-select,input[type=text], input[type=number], input[type=email]{
      background: #fff !important;
      color:#000 !important;
    }

</style>
<h2>New Bill</h2>
<form action="" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Select Vendor</label>
                        <div class="col-sm-6">
                            
                            <select id="customer_id" class='form-select' name="customer_id" required>
                                <option value="" disabled selected>Select Vendor</option>
                                <?php optionPrintAdv("zw_company" ,"id","company_name"); ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Subject</label>
                        <div class="col-sm-6">
		                    <input type='text' class='form-control' name='subject' required>
		                </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Date</label>
                        <div class="col-sm-3">
                            <input type='date' class='form-control' name='invoice_date' id='invoice_date' required>
                        </div>
                        <label for="" class="col-sm-1 col-form-label">Terms</label>
                        <div class="col-sm-2">
                            <select class="form-control" id="terms" name="terms">
                                <option value="Due on receipt">Due on receipt</option>
                             	  <option value="Net 15">Net 15</option>
                             	  <option value="Net 30">Net 30</option>
                             	  <option value="Net 45">Net 45</option>
                            </select>
                        </div>
                        <label for="" class="col-sm-1 col-form-label">Due Date</label>
                        <div class="col-sm-2">
                            <input type='date' class='form-control' id="due_date" name='due_date' required>
                        </div>
                    </div>
                    
                    
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Mail to (Optional)</label>
                        <div class="col-sm-6">
		                    <input type='email' class='form-control' name='mail_to' required>
		                </div>
                    </div>
                    
                    <hr>
                   
                    <div class="col-sm-12 mt-5 p-0">
                        <!-- <h6 class="text-right text-primary">Bulk Update Line Items</h6> -->
                        <table class="table table-bordered table_row" width="100%">
                            <thead>
                                <th width= '38%'>Item Detail</th>
                                <th width= '17%'>Accounts</th>
                                <th width= '10%'>Quantity</th>
                                <th width= '10%'>Rate</th>
                                <th width= '10%'>GST%</th>
                                <th width= '10%'>Discount</th>
                                <th width= '10%'>Amount</th>
                                <th width= '5%'></th>
                            </thead>
                            <tr>
                                <td width= '38%'><input type="text" class="col-md-12" name="item_id[]" placeholder="Item Name" value=""> </td>
                                <td width= '17%'><select class="col-md-12 item_account" style='background-color:#fff!important;' name="item_account[]">
                                    <?php acOptionsAdv('bills'); ?>
                                </select> </td>
                                <td  width= '10%'><input type="text" class="col-md-12 quantity" name="quantity[]" placeholder="Quantity" required></td>
                                
                                <td width= '10%'><input type="text" class="col-md-12 rate" name="rate[]" placeholder="Rate" required></td>
                                <td width= '10%'><input type="number" class="col-md-12 gst" onfocusout="validateInput(this)" name="gst[]" placeholder="GST"></td>
                                <td width= '10%'><input type="text" class="col-md-12 discount" name="discount[]" placeholder="IN (INR)" required></td>
                                
                                <td width= '10%' class="lineItemAmount">0.0</td>
                                
                                <td width= '5%'><button class="btn text-danger delete" title='Remove This Line'><i class='mi-x-circle'></i></button></td>
                            </tr>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="d-flex flex-column p-0">
                                <div class="col-sm-12 p-0"><button class="btn btn-muted" style="background: #fdb40054;" type="button" id="addItem">Add another
                                        line</button></div> 
                                <div class="col-sm-12 p-0" style="margin-top: 170px;">
                                    <h4>Remarks</h4>
                                    <textarea class="form-control" type="text"
                                        placeholder="Thanks for your business" name='remarks'></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <table class="table table-borderless total_table" width="100%">
                                <tr width="100%">
                                    <th width="33%">Sub Total</th>
                                    <td width="33%"><input type="hidden" name = "total_amount" class ="total_amount"></td>
                                    <td class="text-right" width="34%"id="subTotal"></td>
                                </tr>
                                <tr width="100%">
                                    <th width="33%">Discount</th>
                                    
                                    <td width="33%"><input type="hidden" name = "discount-total" class ="total_discount"></td>
                                    <td width="34%" class="text-right" id = "discount-total" ></td>
                                </tr>
                                <tr width="100%">
                                    <th width="33%">Adjustments</th>
                                    <td width="33%"></td>
                                    <td width="30%" class="text-right"  ><input type = "number"  id ="shipping-Charges"  name ="shipping-Charges" class="col-md-8" min=0></td>
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
                                            placeholder="Enter terms and condiions of your business." name ="toc"></textarea>
                                    </div>
                                </td>
                                <td width="50%">
                                    <div>
                                        <h6>Attached Receipt for Bills</h6>
                                        <input type="file" name='bill_receipt' class="form-control">
                                        <h6><small>You can upload maximum 10 files, 5MB each</small></h6>
                                    </div>
                                </td>
                            </tr>

                        </table>
                    </div>
                    <div class= "row">
                        <div class = "col-md-2"><input type = "submit" style="background: #0c7a3f;color: #fff;" name = "submit" class = "submit btn btn-green" value ="Submit"></div>
                        <div class = "col-md-1"><input type = "reset" style="background: #a30000;color: #fff;" name = "reset" class = "reset btn" value ="Reset"></div>
                    </div>
                </div>
            </div>
           
        </form>
        
        
        <!-- The Modal -->
<div class="modal" id="dateModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Date Range Selector</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
        <!-- Date Form -->
        <form action="process_dates.php" method="post">
          <label for="fromDate">From Date:</label>
          <input type="date" id="fromDate" name="fromDate" class="form-control" required>

          <label for="toDate">To Date:</label>
          <input type="date" id="toDate" name="toDate" class="form-control" required>

          <br>

          <!-- Submit Button -->
          <button type="button" id="date_confirmed" class="btn btn-primary">Submit</button>
        </form>
      </div>

    </div>
  </div>
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
        });

        // Handle delete buttons
        $(document).on('click', '.delete', function() {
            $(this).closest('.table_row').remove();
            $('.table_row:first').find('thead').show();
            calculateSubTotal();
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