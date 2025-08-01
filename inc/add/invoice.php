<?php

//ini_set('display_errors', 1);ini_set('display_startup_errors', 1);error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     //echo "<pre>";print_r($_POST);die;
    $customer_id = $_POST["customer_id"];
    $po_id = $_POST["po_id"]; 
    $invoice_date = $_POST["invoice_date"];
    $due_date = $_POST["due_date"];
    $subject = $_POST["subject"];
    $sales_person= null;
    if(isset($_POST["sales_person"])){
    $sales_person = $_POST["sales_person"];
    } 
    $inv_discount=0;
    if(isset($_POST["inv_discount"]) && $_POST["inv_discount"] != ''){
        $inv_discount = $_POST["inv_discount"];
    }
    //$remarks = $_POST["remarks"];
    //$mail_to = $_POST["mail_to"];
    // $type = $_POST["type"];
    //$toc = $_POST["toc"];
    
  //$subTotal = $_POST['subTotal'];
  $customerNotes = $_POST['customerNotes'];
  $order_no = $_POST['order_no'];
  $total_amount = $_POST['total_amount'];
  $discount_total = $_POST['discount-total'];
  $shipping_Charges = $_POST['shipping-Charges'];
  $terms_cond = $_POST['terms_cond'];
    $sqlInvoice = "INSERT INTO zw_invoices (customer_id, subject, order_id , invoice_date, due_date, sales_person,subTotal, remarks, toc,shippingCharges ,discount_total )
            VALUES ('$customer_id', '$subject', $order_no , '$invoice_date', '$due_date', '$sales_person', '$total_amount' , '$customerNotes', '$terms_cond', '$shipping_Charges', '$discount_total')";
  
//   echo "<pre>";print_r($sqlInvoice);echo "</pre>";
//     die();
    if (mysqli_query($con, $sqlInvoice)) {
         alert("Invoice inserted successfully.");
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

        $sqlItems = "INSERT INTO zw_invoice_items (invoice_id, item_id, quantity, rate, discount)
                VALUES ('$invoice_id', '$itemId', '$quantity', '$rate', '$discount')";
        
        if (mysqli_query($con, $sqlItems)) {
          
        } else {
            alert("Error: " . mysqli_error($con));
        }
    }
    
        $adcond = "INSERT INTO zw_payment_made (vendor_id, payment_made, payment_date, payment_mode, payment_type, bank_charge, refrence ,received_date , note , deposit_to , tax_type)
            VALUES ('$customer_id', $total_amount, '$invoice_date', 'Invoice', 'received', '', '' ,'$invoice_date' , '$customerNotes','1' , '0')"; mysqli_query($con,"$adcond");
            
  redirect("manage.php?t=invoice");
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

</style>
<h2>Create Invoice</h2>
<form action="" method="post">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Customer Name</label>
                        <div class="col-sm-6">
                            
                            <select id="customer_id" class='form-select' name="customer_id" required>
                                <option value="" disabled selected>Select Customer</option>
                                <?php optionPrintAdv("zw_customers WHERE customer_type!='epr' AND status='1'", "id", "customer_display_name"); ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Invoice #</label>
                        <div class="col-sm-4">
                            <input id="po_id" placeholder="ZW-IN-123" class='form-control' name="po_id" style="margin: -3px 0px;" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Order Number</label>
                        <div class="col-sm-4">
                            <input type="text" id="order_no" name ="order_no" class="form-control" placeholder="000-111" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Date</label>
                        <div class="col-sm-3">
                            <input type='date' class='form-control' id='invoice_date' name='invoice_date' required>
                        </div>
                        <label for="" class="col-sm-1 col-form-label">Terms</label>
                        <div class="col-sm-2">
                            <select class="form-control" name='terms' id='terms'>
                                <option value="Due on receipt">Due on receipt</option>
                             	  <option value="Net 15">Net 15</option>
                             	  <option value="Net 30">Net 30</option>
                             	  <option value="Net 45">Net 45</option>
                             
                            </select>
                        </div>
                        <label for="" class="col-sm-1 col-form-label">Due Date</label>
                        <div class="col-sm-2">
                            <input type='date' class='form-control' name='due_date' id='due_date' required>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Salesperson</label>
                        <div class="col-sm-4">
                            
                          <select id="sales_person"  class='form-select' name="sales_person">
                                <option value="" selected disabled>Select Salesperson</option>
                                <?php optionPrintAdv("zw_user WHERE user_role='4'","id","username"); ?>
                          </select>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Subject</label>
                        <div class="col-sm-6">
                            <textarea id="" class="form-control" name='subject' rows="1" placeholder="000-111"></textarea>
                            
                        </div>
                    </div>

                    <div class="col-sm-12 mt-5 p-0">
                        <!-- <h6 class="text-right text-primary">Bulk Update Line Items</h6> -->
                        <table class="table table-bordered table_row" width="100%">
                            <thead>
                                <th width= '40%'>Item Detail</th>
                                <th width= '15%'>Quantity</th>
                                <th width= '10%'>Rate</th>
                                <th width= '10%'>GST%</th>
                                <th width= '10%'>Discount</th>
                                <th width= '10%'>Amount</th>
                                <th width= '5%'></th>
                            </thead>
                            <tr>
                                <td width= '40%'><select class="item-select col-12" name="item_id[]" required>
                                    <option selected disabled value="">Select an item</option>
                                    <?php optionPrintAdv("zw_items", "id", "name"); ?>
                                </select></td>
                                <td  width= '15%'><input type="text" class="col-md-12 quantity" name="quantity[]" placeholder="Quantity" required></td>
                                
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