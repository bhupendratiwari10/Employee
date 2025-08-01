

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// echo "<pre>";
// print_r($_POST);
// echo "</pre>"; die;
 $query =  "SELECT * FROM `zw_epr_invoices` where id = $uid";
$data = mysqli_query($con , $query);
$res = mysqli_fetch_assoc($data);
$sqlItems = "select  * FROM zw_epr_invoice_items WHERE invoice_id = $uid";
$dataItems = mysqli_query($con , $sqlItems);
// $resItmes = mysqli_fetch_assoc($dataItems);
$temp_invoiceItems = [];
$num_rows = mysqli_num_rows($dataItems);
if($num_rows >= 1){
    while($row = mysqli_fetch_assoc($dataItems)){
        $resItmes[] = $row;
    }
}
// echo count($resItmes);
    //   echo "<pre>";print_r($resItmes);die;  
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$deleteItemsQuery = "DELETE FROM zw_epr_invoice_items WHERE invoice_id = $uid";
mysqli_query($con, $deleteItemsQuery);

// Update invoice details
    $customer_id = $_POST["customer_id"];
    $po_id = $_POST["po_id"]; 
    $invoice_id = $_POST["invoice_id"];
    $invoice_date = $_POST["invoice_date"];
    $due_date = $_POST["due_date"];
    
 $terms = $_POST["terms"];
  $customerNotes = $_POST['customerNotes'];

  $total_amount = $_POST['total_amount'];
  $discount_total = $_POST['discount-total'];
  $shipping_Charges = !empty($_POST['shipping-Charges']) ? $_POST['shipping-Charges'] : 0;
  $terms_cond = $_POST['terms_cond'];
  
    $sqlInvoice = "UPDATE zw_epr_invoices SET 
    customer_id = '$customer_id', 
    po_id = '$po_id', 
    invoice_id= '".$invoice_id."', 
    invoice_date = '$invoice_date', 
    due_date = '$due_date', 
    remarks ='$customerNotes', 
    toc ='$terms_cond', 
    terms='$terms', 
    subTotal = '$total_amount' ,
    shippingCharges = '$shipping_Charges',
    discount_total = '$discount_total'
    WHERE id = $uid";

mysqli_query($con, $sqlInvoice);

// Insert new items

    $itemIds = $_POST["item_id"];
    $quantities = $_POST["quantity"];
    $rates = $_POST["rate"];
    $gsts = $_POST["gst"];
    $states = $_POST["states"];
    $categorys = $_POST["category"];
    $descriptions = $_POST["description"];

    for ($i = 0; $i < count($itemIds); $i++) {
        $itemId = $itemIds[$i];
        $description = $descriptions[$i];
        $quantity = $quantities[$i];
        $rate = $rates[$i];
        $gst = $gsts[$i];
        
        $category = $categorys[$i];
        
        $state = $states[$i];

        $sqlItems = "INSERT INTO zw_epr_invoice_items (invoice_id, item_id, description, quantity, rate,gst, states, category)
                VALUES ('$uid', '$itemId', '$description', '$quantity', '$rate', '$gst', '$state', '$category')";
        
        if (mysqli_query($con, $sqlItems)) {
          
        } else {
            alert("Error: " . mysqli_error($con));
        }
    }


  redirect('manage.php?t=eprinvoice');
 
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
    .form-control,.form-select,.item-select,input[type=text], input[type=number]{
      background: #fff !important;
      color:#000 !important;
    }

</style>
    <h2>Edit EPR Invoice</h2>
    <form action="" method="post">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Customer Name</label>
                        <div class="col-sm-6">
                            
                            <select id="customer_id" class='form-select' name="customer_id" required>
                                <option value="" disabled selected>Select Customer</option>
                                <?php optionPrintAdv("zw_customers WHERE customer_type!='ulb'", "id", "customer_display_name" , $res['customer_id']); ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">PO#</label>
                        <div class="col-sm-4">
                            <input type="text" id="po_id" class="form-control" placeholder="000-111" name = "po_id" value = "<?php echo $res['po_id']?>" readonly required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Invoice#</label>
                        <div class="col-sm-4">
                            <input id="invoice_id" placeholder="" class='form-control' name="invoice_id"  value= "<?php echo $res['invoice_id']?>" style="margin: -3px 0px;" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Invoice Date</label>
                        <div class="col-sm-3">
                            <input type='date' class='form-control' name='invoice_date' value = "<?php echo $res['invoice_date']?>" required>
                        </div>
                        <label for="" class="col-sm-1 col-form-label">Terms</label>
                        <div class="col-sm-2">
                            <select class="form-control" name="terms">
                                <option value="Due on receipt" <?php if($res['terms'] =='Category 1'){ echo ' selected '; } ?>>Due on receipt</option>
                             	  <option value="Net 15" <?php if($res['terms'] =='Net 15'){ echo ' selected '; } ?>>Net 15</option>
                             	  <option value="Net 30" <?php if($res['terms'] =='Net 30'){ echo ' selected '; } ?>>Net 30</option>
                             	  <option value="Net 45" <?php if($res['terms'] =='Net 45'){ echo ' selected '; } ?>>Net 45</option>
                             
                            </select>
                        </div>
                        <label for="" class="col-sm-1 col-form-label">Due Date</label>
                        <div class="col-sm-2">
                            <input type='date' class='form-control' name='due_date' value = "<?php echo $res['due_date']?>" required>
                        </div>
                    </div>
                    <hr>
                    
                    <div class="col-sm-12 mt-5 p-0">
                        <!-- <h6 class="text-right text-primary">Bulk Update Line Items</h6> -->
                        <table class="table table-bordered table_data" width="100%">
                            <tr>
                                <th width= '20%'>Item Detail</th>
                                <th width= '15%'>Category</th>
                                <th width= '15%'>State</th>
                                <th width= '10%'>Quantity</th>
                                <th width= '10%'>Rate</th>
                                <th width= '10%'>GST%</th>
                                <th width= '20%'>Amount</th>
                            </tr>
                            <?php foreach($resItmes as $resItmes){
                           
                            ?>
                            
                            <tr class="table_row">
                                <td><select class="item-select col-md-12" name="item_id[]" required>
                                    <option  value="EPR Complience Consulting"> EPR Complience Consulting</option>
                                </select><textarea name='description[]' placeholder='Item Description' class='mt-2 col-12'><?php echo $resItmes['description']; ?></textarea>
                                </td>
                                <td><select class="form-control" name="category[]" required >
                                <?php optionPrintAdv("zw_pickup_categories", "id", "title",$resItmes['category']); ?>
                            	</select></td>
                            	<td>
		                   <select class="form-control" name="states[]" required >
		                   	<option selected disabled value="">Select state</option>
		                   	<?php optionPrintAdv("zw_states WHERE name IN(SELECT state FROM zw_ulb)", "name", "name", $resItmes['states']); ?>
		                    </select>
                                </td>
                                <td><input type="text" class="col-md-12 quantity" name="quantity[]" placeholder="Quantity" value = "<?php echo $resItmes['quantity']?>" required>
                                </td>
                                
                                <td><input type="text" class="col-md-12 rate" name="rate[]" placeholder="Rate" value = "<?php echo $resItmes['rate']?>" required></td>
                                <td><input type="text" class="col-md-12 gst" name="gst[]" onfocusout="validateInput(this)" placeholder="GST" value = "<?php echo $resItmes['gst']?>" required>
                                </td>
                                <td class="lineItemAmount">0.0</td>
                                
                                <td><button class="btn text-danger delete"><i class='mi-x-circle'></i></button></td> 
                            </tr>
                            
                            <?php }?>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="d-flex flex-column p-0">
                                <div class="col-sm-12 p-0">
                                <button class="btn btn-muted" style="background: #fdb40054;" type="button" id="addItem">Add another line
                                </button>
                                </div> 
                                <div class="col-sm-12 p-0" style="margin-top: 170px;">
                                    <h4>Customer Notes</h4>
                                    <textarea class="form-control" type="text"
                                        placeholder="Thanks for your business" name='customerNotes'><?php echo $res['remarks']?></textarea>
                                
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <table class="table table-borderless total_table" width="100%">
                                <tr width="100%">
                                    <th width="33%">Sub Total</th>
                                    <td width="33%"><input type="hidden" name = "total_amount" class ="total_amount" value="<?php echo $res['subTotal']?>"></td>
                                    <td class="text-right" width="34%"id="subTotal"><?php echo $res['subTotal']?></td>
                                </tr>
                                <tr width="100%">
                                    <th width="33%">Discount</th>
                                    
                                    <td width="33%"><input type="hidden" name = "discount-total" class ="total_discount" value = "<?php echo $res['discount_total']?>"></td>
                                    <td width="34%" class="text-right" id = "discount-total" ><?php echo $res['discount_total']?></td>
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
                        <div class = "col-md-2"><input type = "submit" style="background: #0c7a3f;color: #fff;" name = "submit" class = "submit btn btn-green" value ="Submit"></div>
                        <div class = "col-md-1"><input type = "reset" style="background: #a30000;color: #fff;" name = "reset" class = "reset btn" value ="Reset"></div>
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
            console.log(row);
            var quantityValue = parseFloat(row.find('.quantity').val()) || 0;
            var rateValue = parseFloat(row.find('.rate').val()) || 0;
            var gstValue = parseFloat(row.find('.gst').val()) || 0;
	    lineItemAmount = (rateValue * quantityValue) + (gstValue * rateValue * quantityValue)/100 ;

	   row.find('.lineItemAmount').text(lineItemAmount);
		amount_without_discount += lineItemAmount;
           
            subTotal += (quantityValue * rateValue);
        });
        
	subTotal = subTotal - shipping_Charges;
        $('#subTotal').text(amount_without_discount.toFixed(2)); // Display with 2 decimal places
       
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
    $(document).on('change', '.quantity, .rate, .gst, #shipping-Charges', function() {
        console.log('calculateSubTotal call');
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
        });
        
        $(document).on('click', '.delete', function() {
            $(this).closest('.table_row').remove();
            calculateSubTotal();$('thead').hide();  $('.table_row:first').find('thead').show();
        });
        
        // Initial calculation of subtotal
        calculateSubTotal();
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
</body>
</html>