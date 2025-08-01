 <?php

$query =  "SELECT * FROM `zw_journal` where id = $uid";
$data = mysqli_query($con , $query);
$res = mysqli_fetch_assoc($data);


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $date = $_POST["date"];
    $title = $_POST["title"];
    $refrence = $_POST["refrence"];
    $notes = $_POST["notes"];
    $currency = $_POST["currency"];
    $total = $_POST["total"];
    
    $sql = "UPDATE `zw_journal` SET title='$title', date='$date', refrence='$refrence', notes='$notes', currency='$currency', total='$total' WHERE id='$uid'";
    mysqli_query($con,"DELETE FROM zw_journal_items WHERE journal_id='$uid'");
    
    if (mysqli_query($con, $sql)) {alert("Journal Edited successfully.");} else {alert("Error: " . mysqli_error($con));}
   
    $journal_id = $uid;

    $r_ids = $_POST["my_id"];
    $r_accounts = $_POST["account_id"];
    $r_desc = $_POST["desc"];
    $r_contacts = $_POST["contact_id"];
    $r_debits = $_POST["debit"];
    $r_credits = $_POST["credit"];
    
    for ($i = 0; $i < count($r_accounts); $i++) {
        $r_id = $r_ids[$i];
        $r_account = $r_accounts[$i];
        $r_des = $r_desc[$i];
        $r_contact = $r_contacts[$i];
        $r_debit = $r_debits[$i];
        $r_credit = $r_credits[$i];
        
        
        $sqlItems="INSERT INTO `zw_journal_items` (`id`, `journal_id`, `account_id`, `description`, `contact`, `debit`, `credit`, `time_str`) VALUES (NULL, '$uid', '$r_account', '$r_des', '$r_contact', '$r_debit', '$r_credit', current_timestamp())";
        
        if (mysqli_query($con, $sqlItems)) {
          redirect("manage.php?t=journal");
          
        } else {
            alert("Error: " . mysqli_error($con));
        }
    }

}

?>
<style>    .form-group { width: 100%;  margin-bottom: 14px;    }.total_table th,.total_table td {border: none;}</style>

<h2>New Journal</h2>

<form action="" method="post" style=''>
            <div class="row">
                <div class="col-sm-12">

                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label" style='color:red;'>Date *</label>
                        <div class="col-sm-5">
                            <input type='date' class='form-control' name='date' value="<?php echo $res['date']; ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Journal</label>
                        <div class="col-sm-5">
                            <input id="title" name='title' placeholder="Journal-001" value="<?php echo $res['title']; ?>" class='form-control' required>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Refrence</label>
                        <div class="col-sm-5">
                            <input id="po_id" class='form-control' value="<?php echo $res['refrence']; ?>" name="refrence">
                        </div>
                    </div>

                    
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label" style='color:red;'>Notes</label>
                        <div class="col-sm-5">
                            <textarea name='notes' class='form-control' rows='3' required> <?php echo $res['notes']; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Currency</label>
                        <div class="col-sm-5">
                            <select class="form-control" name='currency'>
                                <option value='INR'>INR</option>
                                <option value='INR'>USD</option>
                                <option value='EUR'>EUR</option>
                            </select>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="col-sm-12 mt-5 p-0">
                            <?php
                            
                            $sqlItems = "select  * FROM zw_journal_items WHERE journal_id = $uid";
                            $dataItems = mysqli_query($con , $sqlItems);
                            if ($dataItems) {
                                while ($resItems = mysqli_fetch_assoc($dataItems)) { ?>

                        <table class="table table-bordered table_row" width="100%">
                            <tr>
                                <th>Account</th>
                                <th>Description</th>
                                <th>Contact </th>
                                <th>Debits</th>
                                <th>Credits</th>
                            </tr>

                            <tr>
                                <td><select class="account-select" name="account_id[]" required>
                                    <option disabled value="">Select Account</option>
                                    <option disabled></option>
                                    <?php acOptions($atype=$resItems['account_id']); ?>
                                </select><input type="number" class="d-none my_id" name="my_id[]" value="<?php echo $resItems['id']; ?>" placeholder="Id"></td>
                                <td><textarea class="col-12 description" name="desc[]" placeholder="Description"><?php echo $resItems['description']; ?></textarea></td>
                                <td><select class="customer-select" name="contact_id[]" required>
                                    <option disabled value="">Select Contact</option>
                                    <?php optionPrintAdv("zw_customers", "id", "customer_display_name", $resItems['contact']); ?>
                                </select></td>
                                <td><input type="number" class="col-md-5 debit" name="debit[]" value="<?php echo $resItems['debit']; ?>"  placeholder="Debit"></td>
                                <td><input type="number" class="col-md-5 credit" name="credit[]" value="<?php echo $resItems['credit']; ?>"  placeholder="Credit" ></td>
                                <td><button class="btn text-danger delete" title='Delete' style='border:0;'><i class='mi-x-circle1'></i></button></td>
                            </tr>
                            
                        </table>
                            <?php }} ?>
                    </div>
                    
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="d-flex flex-column p-0">
                                <div class="col-sm-12 p-0">
                                    <button class="btn btn-muted" type="button" id="addItem">Add another line</button>
                                </div> 
                            </div> 
                        </div>
                        <div class="col-sm-6">
                            <table class="table table-borderless total_table" width="100%">
                                <tr width="100%">
                                    <th width="33%">Sub Total</th>
                                    <td width="33%" id="totalDebit"></td>
                                    <td width="33%" id="totalCredit"></td>
                                </tr>
                                <tr width="100%">
                                    <th width="33%" style='color:royalblue;font-size:176%;'>Total</th>
                                    <td width="21%"><input type="hidden" name="total" class="subTotal2" value="0"></td>
                                    <td width="34%" class="text-right" style='color:royalblue;font-size:176%;' id="subTotal">0.00</td>
                                </tr>
                                <tr width="100%" >
                                    <td width="45%"style="color:red">Difference</td><td width="45%"style="color:red" id='difference'></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class= "row">
                        <div class = "col-md-2"><input type = "submit" id='submitBtn' name = "submit" class = "submit" value ="Submit"></div>
                        <div class = "col-md-1"><input type = "reset" name = "reset" class = "reset" value ="Reset"></div>
                    </div>
                </div>
            </div>
           
        </form>
<script>
    // Function to calculate subtotal
    function calculateSubTotal() {
        let subTotal = 0;
        let totalDebit = 0;
        let totalCredit = 0;

        $('.table_row').each(function () {
            var row = $(this);
            var debit = parseFloat(row.find('.debit').val()) || 0;
            var credit = parseFloat(row.find('.credit').val()) || 0;

            totalDebit += debit;
            totalCredit += credit;

            subTotal += debit - credit;
        });

        $('#totalDebit').text(totalDebit.toFixed(2));
        $('#totalCredit').text(totalCredit.toFixed(2));
        $('#difference').text((totalDebit - totalCredit).toFixed(2));
        
        // Show or hide the delete buttons based on row count
        if ($('.table_row').length >= 2) {
            $('.delete').show();
        } else {
            $('.delete').hide();
        }
        
        if (totalCredit == totalDebit) {
            $('.subTotal2').val(totalDebit);
            $('#submitBtn').prop('disabled', false);
        } else {
            $('#subTotal').text(totalDebit.toFixed(2));
            $('#submitBtn').prop('disabled', true);
        }

    }

    // Attach change event handler using event delegation
    $(document).on('change', '.debit, .credit', function () {
        calculateSubTotal();
        
    });

    $(document).ready(function () {
        // Function to add a new row
        function addNewRow() {
            var newRow = $('.table_row:first').clone();
            newRow.find('select, input').val('');
            newRow.find('.lineItemAmount').text('0.00');
            newRow.insertAfter('.table_row:last');
            calculateSubTotal();
        }
        
        
        // Handle the "Add another line" button click
        $('#addItem').on('click', function () {
            addNewRow();$('thead').hide();$('.table_row:first').find('thead').show();
        });

        // Handle delete buttons
        $(document).on('click', '.delete', function () {
            $(this).closest('.table_row').remove();
            calculateSubTotal();
            $('thead').hide();$('.table_row:first').find('thead').show();
        });

        // Initial calculation of subtotal
        calculateSubTotal();
    });
</script>



</body>
</html>
</body>
</html>