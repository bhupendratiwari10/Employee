<?php
ini_set ('display_errors', 1);  
ini_set ('display_startup_errors', 1);  
error_reporting (E_ALL);  
 $id = $_GET['id'];
  $query =  "SELECT * FROM `zw_payment_made` where id = $id";
$data = mysqli_query($con , $query);
$res = mysqli_fetch_assoc($data); 
//echo "<pre>";print_r($res);die;
if ($_SERVER["REQUEST_METHOD"] == "POST") {

// Update invoice details
    $customer_id = $_POST["customer_id"];
    $amount = $_POST["payment-made"];
    $bank_charge = $_POST["bank-charge"];
    $payment_mode = $_POST["payment-mode"];
    $deposit_to = $_POST["deposit_to"];
    $payment_date = $_POST["payment-date"];
    $refrence = $_POST["refrence"];
    $tax_type = $_POST["tax_type"];
    $note = $_POST["note"];
    $selectedInvoices = $_POST["selected_invoices"];
    foreach($selectedInvoices as $inv){ if(!empty($iv)){$iv = $iv.",".$inv;}else{$iv = $inv;}}
	//$paid_through = $_POST['paid-through'];
$sqlInvoice = "UPDATE zw_payment_made SET 
    vendor_id = '$customer_id', 
    payment_made = '$amount', 
    payment_date = '$payment_date', 
    payment_mode ='$payment_mode', 
    
    bank_charge ='$bank_charge',
    deposit_to = '$deposit_to',
    refrence ='$refrence' , 
    note = '$note'
    WHERE id = $id";
if(mysqli_query($con, $sqlInvoice)){foreach($selectedInvoices as $inv){  $qq = mysqli_query($con,"UPDATE zw_invoices SET status=0 WHERE id=$inv"); }
redirect("manage.php?t=payments-received");}else{
    alert("We're sorry, There was some error");
}

}
?>

<h2>Update Payment</h2>
<form method="post" class="row" action="">
    <div class='col-md-4'>
        <label for="customer_id">Select Customer</label>
        <select id="customer_id" class='form-select' name="customer_id" required>
            <option value="" disabled>Select Customer</option>
            <?php optionPrintAdv("zw_customers WHERE status='1'" , "id", "customer_display_name", $res['vendor_id']); ?>
        </select>
    </div>
    
    <div class='col-md-4'>
        <label for="payment-made">Amount Received</label>
        <input id="payment-made" class='form-control' name="payment-made" value= "<?php echo $res['payment_made']?>" style="margin: -3px 0px;" placeholder="INR" required>
    </div>




    <div class='col-md-3'>
        <label for="invoice_date">Bank Charge (If Any)</label>
        <input type='text' class='form-control' name='bank-charge' value= "<?php echo $res['bank_charge']?>">
    </div>
    <div class='col-md-3'>
        <label for="payment-mode">Payment Mode</label>
        <select id="payment-mode" class='form-select' name="payment-mode" >
            <option value="" disabled selected>Select Mode</option>
	<option value="cash" <?php if ($res['payment_mode'] == 'cash') echo 'selected'; ?>>Cash</option>
    <option value="online" <?php if ($res['payment_mode'] == 'online') echo 'selected'; ?>>Online</option>
    <option value="cheque" <?php if ($res['payment_mode'] == 'cheque') echo 'selected'; ?>>Cheque</option>
        </select>
    </div>

    <div class='col-md-3'>
        <label for="deposit-to">Deposit To</label>
        <select id="deposit-to" class='form-select' name="deposit_to" required>
            <option value="" disabled selected>Select Method</option>
            <?php acOptions('received'); ?>
        </select>
    </div>
<div class='col-md-3'>
        <label for="invoice_date">Payment Date</label>
        <input type='date' class='form-control' name='payment-date' value = "<?php echo date('Y-m-d' , strtotime($res['payment_date']))?>" required>
    </div>
    <div class='col-md-3'>
        <label for="refrence">Refrence</label>
        <input type='text' class='form-control' name='refrence' value = "<?php echo $res['refrence']?>" id="refrence" placeholder=''>
    </div>
    
<div class = "row">
          <div class ="col-md-3"> 
           <input class="form-check-input" type="radio" name="tax_type" id="tax_type">
  <label class="form-check-label" for="tax_type">
   No Tax Deducted
  </label>
   
          </div>
          <div class ="col-md-3"> 
    <input class="form-check-input" type="radio" name="tax_type" id="tax_type">
  <label class="form-check-label" for="tax_type">
 Yes, TDS Deducted  
  </label>
    
          </div>
  </div>
          
<div class="row mt-3 m-2">
    <div class="col-md-12">
        <table class="table table-bordered table-data">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Invoice #</th>
                    <!--<th>PO</th>-->
                    <th>Amount</th>
                    <th> </th>
                   <!-- <th>Payment</th> -->
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="6" class="no-data-cell">There are No Bills For This Vendor.</td>
                </tr>
            </tbody>
        </table>
        <hr>
		<div class = "row">
          <div class = "col-md-6"></div>
          <div class = "col-md-6">
           <div class="container">
        <table class="table" id = "data-table">
            <tbody>
                <tr>
                    <th>Total Invoices:</th>
                    <td id="total-invoices"></td> 
                </tr>
                <tr>
                    <th>Total Selected:</th>
                    <td class="total">0.00</td> 
                </tr>
                <tr>
                    <th scope="row">Amount Paid:</th>
                    <td>0.00</td>
                </tr>
                <tr>
                    <th scope="row">Amount Used For Payments:</th>
                    <td>0.00</td>
                </tr>
                 <tr>
                    <th scope="row">Amount Refunded:</th>
                    <td>0.00</td>
                </tr>
                  <tr>
                    <th scope="row">Amount In Excess:</th>
                    <td>0.00</td>
                </tr>
               
            </tbody>
        </table>
    </div>
          </div>
          </div>
             <div class = "row">
             <div class ="col-md-6">
            <label for="note">Notes</label>
            <textarea class='form-control' name='note'  rows='4'><?php echo $res['note']?></textarea> 
              </div>
               <div class ="col-md-6">
            <label for="remarks">Upload File</label>
            <input type = "file" class='form-control' name='file' > 
              </div>
              </row>
               <div>
        <button type="submit">Submit</button>
    </div>
              <div>
        <button type="reset">Cancel</button>
    </div>
</form>
    </div>
</div>



<style>
    input[type='text'],
    select {
        padding: 10px 21px;
        border: 1px solid gray;
        border-radius: 8px;
        transform: scale(0.96);
    }
</style>

</body>

</html>
  <script>
  $('#customer_id').change(function(){
    // Get the selected value from the select element
    var selectedCustomerId = $(this).val();
    console.log(selectedCustomerId);
    // Make an AJAX request
    $.ajax({
        type: 'POST', // You can change this to 'GET' if it's appropriate
        url: 'inc/ajax.php', // Replace with the URL of your PHP script
        data: { customer_id: selectedCustomerId  , customer_type:'customer'}, // Send the selected customer ID as data
        dataType: 'json', // Set the expected data type
        success: function(response) {
           // Clear the table body
            $('.table-data tbody').empty();

            var totalAmount = 0.00;
            var selectedInvoicesCount = 0;
        
            if (response.data.length > 0) {
              // Loop through the response data and append rows to the table
              $.each(response.data, function(index, item) {
                var newRow = '<tr>' +
                  '<td>' + item.bill_date + '</td>' +
                  '<td>' + item.id + '</td>' +
                  '<td>' + item.bill_amount + '</td>' +
                  '<td><input type="checkbox" name="selected_invoices[]" value="'+ item.id +'"></td>' +
                  '</tr>';
        
                // Append the new row to the tbody
                $('.table-data tbody').append(newRow);
              });
        
              $('.table-data tbody input[type="checkbox"]').click(function() {
                totalAmount = 0.00;
                selectedInvoicesCount = 0;
        
                $('.table-data tbody input[type="checkbox"]:checked').each(function() {
                  var invoiceAmount = parseFloat($(this).closest('tr').find('td:nth-child(3)').text()); // Assuming invoice amount is in 4th column
                  totalAmount += invoiceAmount;
                  selectedInvoicesCount++;
                });
        
                $('#payment-made').val(totalAmount.toFixed(2)); // Set value of payment-made
                $('.total').text(totalAmount.toFixed(2));
                $('#total-invoices').text(selectedInvoicesCount);
              });
            } else {
                // Handle the case when no data is returned
                $('.table-data tbody').append('<tr><td colspan="6">No data available for this customer.</td></tr>');
            }
        },
        error: function(xhr, status, error) {
            // Handle errors here
            console.error(xhr.responseText); // Log the error message to the console
        }
    });
});
</script>