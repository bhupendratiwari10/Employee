

<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// echo "<pre>";
// print_r($_POST);
// echo "</pre>"; die;
 $query =  "SELECT * FROM `zw_invoices` where id = $uid";
$data = mysqli_query($con , $query);
$res = mysqli_fetch_assoc($data);
$sqlItems = "select  * FROM zw_invoice_items WHERE invoice_id = $uid";
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
$deleteItemsQuery = "DELETE FROM zw_invoice_items WHERE invoice_id = $uid";
mysqli_query($con, $deleteItemsQuery);

// Update invoice details
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
$sqlInvoice = "UPDATE zw_invoices SET 
    customer_id = '$customer_id', 
    subject = '$subject', 
    invoice_date = '$invoice_date', 
    due_date = '$due_date', 
    sales_person ='$sales_person', 
    remarks ='$customerNotes', 
    toc ='$terms_cond', 
    subTotal = '$total_amount' ,
    shippingCharges = '$shipping_Charges',
    discount_total = '$discount_total'
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

    $sqlItems = "INSERT INTO zw_invoice_items (invoice_id, item_id, quantity, rate, discount)
                 VALUES ('$uid', '$itemId', '$quantity', '$rate', '$discount')";

    if (mysqli_query($con, $sqlItems)) {
        // Item inserted successfully
    } else {
        echo "Error: " . mysqli_error($con);
    }
}


  header('Location: https://employee.tidyrabbit.com/sub/epr/manage.php?t=invoice');
 
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
    <h2>Update Invoice</h2>
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
                        <label for="" class="col-sm-2 col-form-label">Invoice</label>
                        <div class="col-sm-4">
                            <input id="po_id" placeholder="" class='form-control' name="po_id"  value= "<?php echo $res['p_o']?>" style="margin: -3px 0px;" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Order Number</label>
                        <div class="col-sm-4">
                            <input type="text" id="order_no" class="form-control" placeholder="000-111" name = "order_id" value = "<?php echo $res['order_id']?>" readonly required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Invoice Date</label>
                        <div class="col-sm-3">
                            <input type='date' class='form-control' name='invoice_date' value = "<?php echo $res['invoice_date']?>" required>
                        </div>
                        <label for="" class="col-sm-1 col-form-label">Terms</label>
                        <div class="col-sm-2">
                            <select class="form-control">
                                <option>Due on receipt</option>
                             
                            </select>
                        </div>
                        <label for="" class="col-sm-1 col-form-label">Due Date</label>
                        <div class="col-sm-2">
                            <input type='date' class='form-control' name='due_date' value = "<?php echo $res['due_date']?>" required>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Salesperson</label>
                        <div class="col-sm-4">
                            
                          <select id="sales_person"  class='form-select' name="sales_person">
                <option value="" disabled selected>Select Salesperson</option>
                <?php optionPrintAdv("zw_user WHERE user_role='4'","id","username" , $res['sales_person']); ?>
            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Subject</label>
                        <div class="col-sm-6">
                            <textarea id="" class="form-control" name='subject' rows="1" placeholder="000-111" value ="" required><?php echo $res['subject']?></textarea>
                            
                        </div>
                    </div>
                    <div class="col-sm-12 mt-5 p-0">
                        <!-- <h6 class="text-right text-primary">Bulk Update Line Items</h6> -->
                        <table class="table table-bordered table_row" width="100%">
                            <tr>
                                <th>Item Detail</th>
                                <th>Quantity</th>
                                <th>Rate</th>
                                <th>Amount</th>
                                <th>Disocunt</th>
                            </tr>
                            <?php foreach($resItmes as $resItmes){
                           
                            ?>
                            <tr>
                                <td><select class="item-select" name="item_id[]" required>
                                    <option selected disabled value="">Select an item</option>
                                    <?php optionPrintAdv("zw_items", "id", "name" , $resItmes['item_id']); ?>
                                </select></td>
                                <td><input type="text" class="col-md-5 quantity" name="quantity[]" placeholder="Quantity" value = "<?php echo $resItmes['quantity']?>" required>
                                </td>
                                <td><input type="text" class="col-md-5 rate" name="rate[]" placeholder="Rate" value = "<?php echo $resItmes['rate']?>" required></td>
                                <td class="lineItemAmount">0.0</td>
                                <td><input type="text" class="col-md-5 productDiscount" name="discount[]" value = "<?php echo $resItmes['discount']?>" placeholder="Discount (in INR)" value="0"></td>
                                <!--<td><button class="btn btn-danger delete">Delete</button></td> -->
                            </tr>
                            <?php }?>
                        </table>
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
            var rateValue = parseFloat(row.find('.rate').val()) || 0;
            var productDiscountValue = parseFloat(row.find('.productDiscount').val()) || 0;
		lineItemAmount = rateValue * quantityValue;

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
    $(document).on('change', '.quantity, .rate, .productDiscount , #shipping-Charges', function() {
        calculateSubTotal();
    });

    $(document).ready(function() {
        // Function to add a new row
        // function addNewRow() {
        //     var newRow = $('.table_row:first').clone();
        //     newRow.find('select, input').val('');
        //     newRow.find('.lineItemAmount').text('0.00');
        //     newRow.insertAfter('.table_row:last');
        //     calculateSubTotal();
        // }

        // // Handle the "Add another line" button click
        // $('#addItem').on('click', function() {
        //     addNewRow();
        // });

        // // Handle delete buttons
        // $(document).on('click', '.delete', function() {
        //     $(this).closest('.table_row').remove();
        //     calculateSubTotal();
        // });

        // Initial calculation of subtotal
        // calculateSubTotal();
    });
</script>
</body>
</html>
