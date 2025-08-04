<?php
// Only show errors in development mode
if (defined('DEBUG_MODE') && DEBUG_MODE) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Secure the ID parameter
$uid = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$uid) {
    header('Location: ' . PROJECT_URL . 'sub/epr/manage.php?t=invoice');
    exit();
}

// Get invoice data with prepared statement
$query = "SELECT * FROM `zw_invoices` WHERE id = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $uid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$res = mysqli_fetch_assoc($result);

if (!$res) {
    echo "<script>alert('Invoice not found');</script>";
    echo "<script>window.location.href = '" . PROJECT_URL . "sub/epr/manage.php?t=invoice';</script>";
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Start transaction
    mysqli_begin_transaction($con);
    
    try {
        // Delete existing items
        $deleteQuery = "DELETE FROM zw_invoice_items WHERE invoice_id = ?";
        $stmtDelete = mysqli_prepare($con, $deleteQuery);
        mysqli_stmt_bind_param($stmtDelete, "i", $uid);
        mysqli_stmt_execute($stmtDelete);

        // Update invoice details with prepared statement
        $customer_id = intval($_POST["customer_id"]);
        $po_id = mysqli_real_escape_string($con, $_POST["po_id"]);
        $subject = mysqli_real_escape_string($con, $_POST["subject"]);
        $invoice_date = mysqli_real_escape_string($con, $_POST["invoice_date"]);
        $due_date = mysqli_real_escape_string($con, $_POST["due_date"]);
        $sales_person = intval($_POST["sales_person"]);
        $remarks = mysqli_real_escape_string($con, $_POST["remarks"]);
        $toc = mysqli_real_escape_string($con, $_POST["toc"]);
        $mail_to = mysqli_real_escape_string($con, $_POST["mail_to"]);
        $subTotal = floatval($_POST['subTotal']);
        $inv_discount = floatval($_POST['inv_discount']);
        
        $updateQuery = "UPDATE zw_invoices SET 
            customer_id = ?, 
            po_id = ?,
            subject = ?, 
            invoice_date = ?, 
            due_date = ?, 
            sales_person = ?, 
            remarks = ?, 
            toc = ?, 
            mail_to = ?,
            subTotal = ?,
            inv_discount = ?
            WHERE id = ?";
        
        $stmtUpdate = mysqli_prepare($con, $updateQuery);
        mysqli_stmt_bind_param($stmtUpdate, "issssisssddi", 
            $customer_id, $po_id, $subject, $invoice_date, $due_date, 
            $sales_person, $remarks, $toc, $mail_to, $subTotal, $inv_discount, $uid
        );
        mysqli_stmt_execute($stmtUpdate);

        // Insert new items
        if (isset($_POST["item_id"]) && is_array($_POST["item_id"])) {
            $itemIds = $_POST["item_id"];
            $quantities = $_POST["quantity"];
            $rates = $_POST["rate"];
            $discounts = $_POST["discount"];
            
            $insertQuery = "INSERT INTO zw_invoice_items (invoice_id, item_id, quantity, rate, discount) VALUES (?, ?, ?, ?, ?)";
            $stmtInsert = mysqli_prepare($con, $insertQuery);
            
            for ($i = 0; $i < count($itemIds); $i++) {
                $itemId = intval($itemIds[$i]);
                $quantity = floatval($quantities[$i]);
                $rate = floatval($rates[$i]);
                $discount = floatval($discounts[$i]);
                
                mysqli_stmt_bind_param($stmtInsert, "iiddd", $uid, $itemId, $quantity, $rate, $discount);
                mysqli_stmt_execute($stmtInsert);
            }
        }
        
        // Commit transaction
        mysqli_commit($con);
        
        echo "<script>alert('Invoice updated successfully!');</script>";
        echo "<script>window.location.href = '" . PROJECT_URL . "sub/epr/manage.php?t=invoice';</script>";
        exit();
        
    } catch (Exception $e) {
        // Rollback on error
        mysqli_rollback($con);
        echo "<script>alert('Error updating invoice: " . addslashes($e->getMessage()) . "');</script>";
    }
}

// Get invoice items
$sqlItems = "SELECT * FROM zw_invoice_items WHERE invoice_id = ?";
$stmtItems = mysqli_prepare($con, $sqlItems);
mysqli_stmt_bind_param($stmtItems, "i", $uid);
mysqli_stmt_execute($stmtItems);
$dataItems = mysqli_stmt_get_result($stmtItems);
?>

<style>
    .form-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .item-group {
        background-color: #f8f9fa;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 8px;
        align-items: center;
    }
    
    input[type='text'], input[type='email'], input[type='date'], input[type='number'], select, textarea {
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        width: 100%;
        transition: border-color 0.3s;
    }
    
    input[type='text']:focus, input[type='email']:focus, input[type='date']:focus, 
    input[type='number']:focus, select:focus, textarea:focus {
        border-color: #007bff;
        outline: none;
    }
    
    button[type="submit"], #addItem {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        margin-top: 15px;
        transition: background-color 0.3s;
    }
    
    button[type="submit"]:hover, #addItem:hover {
        background-color: #0056b3;
    }
    
    .delete {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        cursor: pointer;
    }
    
    .delete:hover {
        background-color: #c82333;
    }
    
    h2, h3 {
        margin-bottom: 20px;
        color: #333;
    }
    
    label {
        font-weight: 600;
        margin-bottom: 5px;
        display: block;
    }
    
    #subTotal {
        background-color: #e9ecef;
        font-weight: bold;
    }
    
    .btn-secondary {
        background-color: #6c757d;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        text-decoration: none;
        display: inline-block;
        margin-left: 10px;
    }
</style>

<div class="form-container">
    <h2>Update Invoice</h2>
    <form method="post" class="row g-3" action="">
        <div class='col-md-3'>
            <label for="customer_id">Select Customer</label>
            <select id="customer_id" class='form-select' name="customer_id" required>
                <option value="" disabled>Select Customer</option>
                <?php optionPrintAdv("zw_customers WHERE customer_type!='ulb'", "id", "customer_display_name", $res['customer_id']); ?>
            </select>
        </div>
        
        <div class='col-md-3'>
            <label for="po_id">Purchase Order #</label>
            <input type="text" id="po_id" class='form-control' name="po_id" 
                   value="<?php echo htmlspecialchars($res['po_id']); ?>">
        </div>
        
        <div class='col-md-3'>
            <label for="mail_to">Mail To (BCC Email)</label>
            <input type='email' class='form-control' id="mail_to" name='mail_to' 
                   value="<?php echo htmlspecialchars($res['mail_to']); ?>">
        </div>
        
        <div class='col-md-3'>
            <label for="sales_person">Select Salesperson</label>
            <select id="sales_person" class='form-select' name="sales_person">
                <option value="" disabled>Select Salesperson</option>
                <?php optionPrintAdv("zw_user WHERE user_role='4'", "id", "username", $res['sales_person']); ?>
            </select>
        </div>
        
        <div class='col-md-3'>
            <label for="invoice_date">Invoice Date</label>
            <input type='date' class='form-control' id="invoice_date" name='invoice_date' 
                   value="<?php echo htmlspecialchars($res['invoice_date']); ?>" required>
        </div>
        
        <div class='col-md-3'>
            <label for="due_date">Due Date</label>
            <input type='date' class='form-control' id="due_date" name='due_date' 
                   value="<?php echo htmlspecialchars($res['due_date']); ?>" required>
        </div>
        
        <div class='col-md-3'>
            <label for="subject">Subject</label>
            <input type='text' class='form-control' id="subject" name='subject' 
                   value="<?php echo htmlspecialchars($res['subject']); ?>" required>
        </div>
        
        <div class='col-md-3'>
            <label for="inv_discount">Discount (in INR)</label>
            <input type='number' class='form-control' id="inv_discount" name='inv_discount' 
                   placeholder='0.00' value="<?php echo htmlspecialchars($res['inv_discount']); ?>" 
                   step="0.01" min="0">
        </div>
        
        <div class='col-md-6'>
            <label for="remarks">Remarks</label>
            <textarea class='form-control' id="remarks" name='remarks' rows='3'><?php echo htmlspecialchars($res['remarks']); ?></textarea>
        </div>
        
        <div class='col-md-6'>
            <label for="toc">Terms and Conditions</label>
            <textarea class='form-control' id="toc" name='toc' rows='3'><?php echo htmlspecialchars($res['toc']); ?></textarea>
        </div>
        
        <div class='col-md-3'>
            <label for="subTotal">Sub Total</label>
            <input type='text' class='form-control' name='subTotal' id="subTotal" readonly>
        </div>
        
        <div class="col-12">
            <h3 style='margin-top:21px;'>Invoice Items:</h3>
            <div id="items">
                <?php 
                if ($dataItems && mysqli_num_rows($dataItems) > 0) {
                    while ($resItems = mysqli_fetch_assoc($dataItems)) { ?>
                        <div class="item-group row table_row">
                            <div class="col-md-3">
                                <select class="form-control item-select" name="item_id[]" required>
                                    <option value="" disabled>Select an item</option>
                                    <?php optionPrintAdv("zw_items", "id", "name", $resItems['item_id']); ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="number" class="form-control quantity" name="quantity[]" 
                                       placeholder="Quantity" value="<?php echo htmlspecialchars($resItems['quantity']); ?>" 
                                       step="0.01" min="0" required>
                            </div>
                            <div class="col-md-3">
                                <input type="number" class="form-control rate" name="rate[]" 
                                       placeholder="Rate" value="<?php echo htmlspecialchars($resItems['rate']); ?>" 
                                       step="0.01" min="0" required>
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control productDiscount" name="discount[]" 
                                       value="<?php echo htmlspecialchars($resItems['discount']); ?>" 
                                       placeholder="Discount" step="0.01" min="0">
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger delete">Delete</button>
                            </div>
                        </div>
                    <?php }
                } else { ?>
                    <div class="item-group row table_row">
                        <div class="col-md-3">
                            <select class="form-control item-select" name="item_id[]" required>
                                <option value="" disabled selected>Select an item</option>
                                <?php optionPrintAdv("zw_items", "id", "name"); ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="number" class="form-control quantity" name="quantity[]" 
                                   placeholder="Quantity" step="0.01" min="0" required>
                        </div>
                        <div class="col-md-3">
                            <input type="number" class="form-control rate" name="rate[]" 
                                   placeholder="Rate" step="0.01" min="0" required>
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control productDiscount" name="discount[]" 
                                   placeholder="Discount" step="0.01" min="0">
                        </div>
                    </div>
                <?php } ?>
            </div>
            
            <button type="button" class="btn btn-secondary" id="addItem">Add Item</button>
        </div>
        
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Update Invoice</button>
            <a href="<?php echo PROJECT_URL; ?>sub/epr/manage.php?t=invoice" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<script>
$(document).ready(function() {
    // Function to calculate subtotal
    function calculateSubTotal() {
        let subTotal = 0;
        $('.table_row').each(function() {
            var row = $(this);
            var quantityValue = parseFloat(row.find('.quantity').val()) || 0;
            var rateValue = parseFloat(row.find('.rate').val()) || 0;
            var productDiscountValue = parseFloat(row.find('.productDiscount').val()) || 0;
            var lineTotal = (quantityValue * rateValue) - productDiscountValue;
            subTotal += lineTotal;
        });
        
        // Apply invoice level discount if any
        var invDiscount = parseFloat($('#inv_discount').val()) || 0;
        subTotal -= invDiscount;
        
        $('#subTotal').val(subTotal.toFixed(2));
    }

    // Calculate on page load
    calculateSubTotal();

    // Attach event handlers
    $(document).on('input change', '.quantity, .rate, .productDiscount, #inv_discount', function() {
        calculateSubTotal();
    });

    // Delete button handler
    $(document).on('click', '.delete', function() {
        if ($('.table_row').length > 1 || confirm('Are you sure you want to remove all items?')) {
            $(this).closest('.item-group').remove();
            calculateSubTotal();
        }
    });

    // Add item button
    $('#addItem').on('click', function() {
        // Clone the first select to get all options
        var firstSelect = $('.item-select').first().clone();
        firstSelect.val(''); // Reset value
        
        const newItemGroup = $('<div class="item-group row table_row">');
        
        // Add select
        const selectCol = $('<div class="col-md-3">').append(firstSelect);
        newItemGroup.append(selectCol);
        
        // Add other inputs
        newItemGroup.append(`
            <div class="col-md-3">
                <input type="number" class="form-control quantity" name="quantity[]" 
                       placeholder="Quantity" step="0.01" min="0" required>
            </div>
            <div class="col-md-3">
                <input type="number" class="form-control rate" name="rate[]" 
                       placeholder="Rate" step="0.01" min="0" required>
            </div>
            <div class="col-md-2">
                <input type="number" class="form-control productDiscount" name="discount[]" 
                       placeholder="Discount" step="0.01" min="0">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger delete">Delete</button>
            </div>
        `);
        
        $('#items').append(newItemGroup);
    });

    // Form validation
    $('form').on('submit', function(e) {
        let isValid = true;
        
        // Check if at least one item exists
        if ($('.table_row').length === 0) {
            alert('Please add at least one item');
            isValid = false;
        }
        
        // Validate dates
        const invoiceDate = new Date($('#invoice_date').val());
        const dueDate = new Date($('#due_date').val());
        
        if (dueDate < invoiceDate) {
            alert('Due date cannot be before invoice date');
            isValid = false;
        }
        
        // Check for duplicate items
        let itemIds = [];
        let hasDuplicates = false;
        $('.item-select').each(function() {
            let val = $(this).val();
            if (val && itemIds.includes(val)) {
                hasDuplicates = true;
            }
            itemIds.push(val);
        });
        
        if (hasDuplicates) {
            alert('Duplicate items found. Please remove duplicate items.');
            isValid = false;
        }
        
        if (!isValid) {
            e.preventDefault();
        }
    });
});
</script>

</body>
</html>