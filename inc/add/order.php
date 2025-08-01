<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
     //echo "<pre>";print_r($_POST);die;
    $customer_id = $_POST["customer_id"];
    $po_id = $_POST["po_no"]; 
    $po_date = $_POST["po_date"];
    
    $terms = $_POST["terms"];

    $total_amount = $_POST['total_amount'];
    $file = uploadImage("epr_po", "uploads/epr_po");
  
   $sqlInvoice = "INSERT INTO zw_epr_po (customer_id, po_id, po_date, subTotal, terms, file_src)
            VALUES ('$customer_id', '$po_id', '$po_date', '$total_amount', '$terms', '$file')";
  
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
    $item_descs = $_POST["item_desc"];
    $rates = $_POST["rate"];
    $gsts = $_POST["gst"];
    $states = $_POST["states"];
    $categorys = $_POST["category"];
    
    for ($i = 0; $i < count($itemIds); $i++) {
        $itemId = $itemIds[$i];
        $item_desc = $item_descs[$i];
        $quantity = $quantities[$i];
        $rate = $rates[$i];
        $gst = $gsts[$i];
        
        $category = $categorys[$i];
        
        $states = $states[$i];

        $sqlItems = "INSERT INTO zw_epr_po_items (invoice_id, item_id, description, quantity, rate,gst, states, category)
                VALUES ('$invoice_id', '$itemId','$item_desc', '$quantity', '$rate', '$gst', '$states', '$category')";
        
        if (mysqli_query($con, $sqlItems)) {
          
        } else {
            alert("Error: " . mysqli_error($con));
        }
    }
  redirect("manage.php?t=orders");
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
    .form-control,.form-select,.item-select,input[type=text], input[type=number], textarea{
      background: #fff !important;
      color:#000 !important;
    }

</style>
<h2><i class="mi-mi-list"></i> New EPR P.O.</h2>
<hr/>
<form action="" method="post"  enctype="multipart/form-data">
            <div class="row">
            	<div class="col-sm-12" style="background:#e9e9e9; padding-top:15px;">
            	     <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Customer Name</label>
                        <div class="col-sm-6">
                            
                            <select id="customer_id" class='form-select' name="customer_id" required>
                                <option value="" disabled selected>Select Customer</option>
                                <?php optionPrintAdv("zw_customers WHERE customer_type='epr' AND status='1'", "id", "customer_display_name"); ?>
                            </select>
                        </div>
                    </div>
            	</div>
                <div class="col-sm-12">
                    
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">PO#</label>
                        <div class="col-sm-4">
                            <input type="text" id="po_no" name ="po_no" class="form-control" placeholder="000-111" required>
                        </div>
                    </div>
                   
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">PO Date</label>
                        <div class="col-sm-3">
                            <input type='date' class='form-control' name='po_date' required>
                        </div>
                        <label for="" class="col-sm-2 col-form-label">Payment Terms</label>
                        <div class="col-sm-3">
                            <select class="form-control" name="terms">
                                <option value="Due on receipt">Due on receipt</option>
                             	  <option value="Net 15">Net 15</option>
                             	  <option value="Net 30">Net 30</option>
                             	  <option value="Net 45">Net 45</option>
                            </select>
                        </div>
                        
                    </div>
                    <hr>
                   
                    <div class="col-sm-12 mt-5 p-0">
                        <!-- <h6 class="text-right text-primary">Bulk Update Line Items</h6> -->
                        <table class="table table-bordered table_row" width="100%">
                            <thead>
                                <th width= '25%' style="color:#0c7a3f;">Item</th>
                                <th width= '15%' style="color:#0c7a3f;">Category</th>
                                <th width= '15%' style="color:#0c7a3f;">State</th>
                                <th width= '10%' style="color:#0c7a3f;">Quantity</th>
                                <th width= '10%' style="color:#0c7a3f;">Rate</th>
                                <th width= '10%' style="color:#0c7a3f;">GST%</th>
                                <th width= '10%' style="color:#0c7a3f;">Amount</th>
                                <th width= '5%' style="color:#0c7a3f;"></th>
                            </thead>
                            <tr>
                                <td width= '25%'><select class="item-select" name="item_id[]" required>
                                    <option selected disabled value="">Select an item</option>
                                    <?php optionPrintAdv("zw_items", "id", "name"); ?>
                                </select>
                                <textarea name="item_desc[]" placeholder="Description"></textarea>
                                </td>
                                <td width= '15%'><select class="form-control" name="category[]" required >
                                <option selected disabled value="">Select category</option>
                                <?php optionPrintAdv("zw_pickup_categories", "title", "title"); ?>
                                
                            	</select></td>
                            	<td width= '15%'>
		                   <select class="form-control" name="states[]" required >
		                   	<option selected disabled value="">Select state</option>
		                        <?php optionPrintAdv("zw_states WHERE name IN(SELECT state FROM zw_ulb)", "name", "name"); ?>
		                    </select>
                                </td>
                                <td width= '10%'><input type="text" class="col-md-12 quantity" name="quantity[]" placeholder="Quantity" required>
                                </td>
                                
                                <td width= '10%'><input type="text" class="col-md-12 rate" name="rate[]" placeholder="Rate" required></td>
                                <td width= '10%'><input type="text" class="col-md-12 gst" name="gst[]" placeholder="GST" required>
                                </td>
                                <td width= '10%' class="lineItemAmount" style="text-align:center;">0.0</td>
                                
                                <td width= '5%'><button class="btn text-danger delete"><i class='mi-x-circle'></i></button></td> 
                            </tr>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="d-flex flex-column p-0">
                                <div class="col-sm-12 p-0"><button class="btn btn-muted" style="background: #0c7a3f;" type="button" id="addItem">Add item line</button></div> 
                               
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <table class="table table-borderless total_table" width="100%">
                                  <tr width="100%">
                                    <th width="33%">Total</th>
                                    <td width="33%"><input type="hidden" name = "total_amount" class ="total_amount"></td>
                                    <td width="34%" class="text-right" id="total_amount">0.00</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                    	<div class="col-sm-8"></div>
                    	<div class="col-sm-4">
                        <table class="table table-bordered" width="100%">
                            <tr>
                                
                                <td width="50%">
                                    <div>
                                        <h6>Attach P.O.</h6>
                                        <input type="file" name="epr_po" class="form-control">
                                        <h6><small>You can upload maximum 10 files, 5MB each</small></h6>
                                    </div>
                                </td>
                            </tr>

                        </table>
                        </div>
                    </div>
                    <div class= "row">
                        <div class = "col-md-2"><input type = "submit" style="background: #0c7a3f;color: #fff;" name = "submit" class = "submit btn btn-green" value ="Submit"></div>
                        <div class = "col-md-1"><input type = "reset" style="background: #a30000;color: #fff;" name = "reset" class = "reset btn" value ="Reset"></div>
                    </div>
                </div>
            </div>
           
        </form>
<script>
    // Function to calculate subtotal
    function calculateSubTotal() {
        let subTotal = 0;
let total_discount = 0;
let amount_without_discount = 0;
        $('.table_row').each(function() {
            var row = $(this);
            var quantityValue = parseFloat(row.find('.quantity').val()) || 0;
            var rateValue = parseFloat(row.find('.rate').val()) || 0;
            var gstValue = parseFloat(row.find('.gst').val()) || 0;

		lineItemAmount = rateValue * quantityValue;

	   row.find('.lineItemAmount').text(lineItemAmount);
		amount_without_discount += lineItemAmount;
            
            subTotal += (quantityValue * rateValue);
        });
       
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
    $(document).on('change', '.quantity, .rate', function() {
        calculateSubTotal();
    });

    $(document).ready(function() {
        // Function to add a new row
        function addNewRow() {
            var newRow = $('.table_row:first').clone();
            newRow.find('select, input').val('');
            newRow.find('.lineItemAmount').text('0.00');
            newRow.insertAfter('.table_row:last');
            calculateSubTotal();
        }

        // Handle the "Add another line" button click
        $('#addItem').on('click', function() {
            addNewRow();
            $('thead').hide();  $('.table_row:first').find('thead').show();
        });

        // Handle delete buttons
        $(document).on('click', '.delete', function() {
            $(this).closest('.table_row').remove();
            calculateSubTotal();
            $('thead').hide();  $('.table_row:first').find('thead').show();
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
  </script>


</body>
</html>
</body>
</html>