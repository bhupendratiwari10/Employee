<?php

 ini_set ('display_errors', 1);  
ini_set ('display_startup_errors', 1);  
error_reporting (E_ALL);  
$newid = maxId('zw_payment_made')+1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //echo "<pre>";print_r($_POST);die();
    $customer_id = $_POST["customer_id"];
    $amount = $_POST["payment-made"];
    $payment = $_POST["payment"];
    $payment_mode = $_POST["payment-mode"];
    //$deposit_to = $_POST["sales_person"];
    $payment_date = $_POST["payment-date"];
    $refrence = $_POST["refrence"];
    //$tax_type = $_POST["tax_type"];
  	$paid_through = $_POST['paid-through'];
//   	$deposit_to = $_POST['deposit_to'];
	$paid_through = $_POST['paid-through'];
    $received_date = date('y-m-d');
    $note = $_POST["note"];
    $selectedInvoices = $_POST["selected_invoices"];
    foreach($selectedInvoices as $inv){ if(!empty($iv)){$iv = $iv.",".$inv;}else{$iv = $inv;}}
    
    $sqlInvoice = "INSERT INTO zw_payment_made (id, vendor_id, payment_made, payment_date, payment_mode, payment_type, paid_through, refrence , order_id , received_date , note)
            VALUES ($newid, '$customer_id', '$amount', '$payment_date', '$payment_mode', 'made', '$paid_through', '$refrence', '$iv' ,'$received_date' , '$note')";
    
    echo $sqlInvoice;

    if (mysqli_query($con, $sqlInvoice)) {
        foreach($selectedInvoices as $inv){  $qq = mysqli_query($con,"UPDATE zw_Bills SET status=0 WHERE id=$inv"); }
        alert("Payment Updated Successfully.");redirect("manage.php?t=payments-made");
    } else {
        alert("Error: " . mysqli_error($con));
    }

   
    redirect("manage.php?t=payments-made");
}
?>

<h2>Bill Payment</h2>
<form method="post" class="row" action="">
    <div class='col-md-4'>
        <label for="customer_id">Select Vendor</label>
        <select id="customer_id" class='form-select' name="customer_id" required>
            <option value="" disabled selected>Select Vendor</option>
            <?php optionPrintAdv("zw_company" , "id", "company_name"); ?>
        </select>
    </div>
    <div class='col-md-4'>
        <label for="payment">Payment #</label>
        <input id="payment" class='form-control' name="payment" value='ZW-BP-<?php echo $newid; ?>' style="margin: -3px 0px;">

    </div>
    <div class='col-md-4'>
        <label for="payment-made">Amount Paid</label>
        <input id="payment-made" class='form-control' name="payment-made" style="margin: -3px 0px;" placeholder="INR" required>
    </div>




    <div class='col-md-3'>
        <label for="invoice_date">Payment Date</label>
        <input type='date' class='form-control' name='payment-date' required>
    </div>
    <div class='col-md-3'>
        <label for="payment-mode">Payment Mode</label>
        <select id="payment-mode" class='form-select' name="payment-mode" required>
            <option value="" disabled selected>Select Mode</option>

            <option value="cash">Cash</option>
            <option value="online">Online</option>
            <option value="cheque">Cheque</option>
        </select>
    </div>
	 <!--<div class='col-md-3 '>-->
  <!--      <label for="deposit-to">Deposit To</label>-->
  <!--      <select id="deposit-to" class='form-select' name="deposit_to">-->
  <!--          <option value="" disabled selected>Select Method</option>-->
  <!--          <?php //acOptions('made'); ?>-->
  <!--      </select>-->
  <!--  </div>-->
    <div class='col-md-3'>
        <label for="paid-through">Paid Through</label>
        <select id="paid-through" class='form-select' name="paid-through" required>
            <option value="" disabled selected>Select Method</option>
            <?php acOptions(); ?>
        </select>
    </div>

    <div class='col-md-3'>
        <label for="refrence">Refrence</label>
        <input type='text' class='form-control' name='refrence' id="refrence" placeholder='' required>
    </div>
    

<div class="row mt-3 m-2">
    <div class="col-md-12">
        <table class="table table-bordered" id="data-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Bill ID</th>
                    <!--<th>Subject</th>-->
                    <th>Amount</th>
                    <th></th>
                    <!--<th>Amount Due</th>-->
                    <!--<th>Sales Person</th>-->
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
        <table class="table">
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
            <textarea class='form-control' name='note' rows='4'></textarea> 
              </div>
               <div class ="col-md-6">
            <label for="remarks">Upload File</label>
            <input type = "file" class='form-control' name='file' > 
              </div>
              </row>
               <div>
        <button type="submit">Submit</button>
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
    $(document).ready(function() {
        $('#customer_id').change(function() {
            var selectedCustomerId = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'inc/ajax.php', // Replace with the URL of your PHP script
                data: { customer_id: selectedCustomerId, customer_type: 'vendor' },
                dataType: 'json',
                success: function(response) {
                  console.log(response);
                    $('#data-table tbody').empty();
            
                var totalAmount = 0.00;
                var selectedInvoicesCount = 0;
            
            
                  if (response.data.length > 0) {
                        $.each(response.data, function(index, item) {
                            var newRow = '<tr>' +
                                '<td>' + item.bill_date + '</td>' +
                                '<td>' + item.id + '</td>' +
                               
                                '<td>' + item.bill_amount + '</td>' +
                                
                                '<td><input type="checkbox" name="selected_invoices[]" value="'+ item.id +'"></td>' +
                                
                                '</tr>';
                            $('#data-table tbody').append(newRow);
                        });

                     $('#data-table tbody input[type="checkbox"]').click(function() {
                        totalAmount = 0.00;
                        selectedInvoicesCount = 0;
                    
                        $('#data-table tbody input[type="checkbox"]:checked').each(function() {
                            var invoiceAmount = parseFloat($(this).closest('tr').find('td:nth-child(3)').text()); // Assuming invoice amount is in 4th column
                            totalAmount += invoiceAmount;
                            selectedInvoicesCount++;
                        });
                    
                        $('#payment-made').val(totalAmount.toFixed(2)); // Set value of payment-made
                        $('.total').text(totalAmount.toFixed(2));
                        $('#total-invoices').text(selectedInvoicesCount);
                    });

                    } else {
                        // If there are no bills for the selected customer, show a message.
                        var noDataRow = '<tr><td colspan="6" class="no-data-cell">There are No Bills For This Vendor.</td></tr>';
                        $('#data-table tbody').append(noDataRow);
                    }
                    
                },
                error: function(xhr, status, error) {
                  
                }
            });
        });
    });
</script>