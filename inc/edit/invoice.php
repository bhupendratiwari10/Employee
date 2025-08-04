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

// Get invoice items
$sqlItems = "SELECT * FROM zw_invoice_items WHERE invoice_id = ?";
$stmtItems = mysqli_prepare($con, $sqlItems);
mysqli_stmt_bind_param($stmtItems, "i", $uid);
mysqli_stmt_execute($stmtItems);
$dataItems = mysqli_stmt_get_result($stmtItems);
$resItmes = mysqli_fetch_all($dataItems, MYSQLI_ASSOC);

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

        // Sanitize and validate inputs
        $customer_id = intval($_POST["customer_id"]);
        $po_id = mysqli_real_escape_string($con, $_POST["po_id"]); 
        $invoice_date = mysqli_real_escape_string($con, $_POST["invoice_date"]);
        $due_date = mysqli_real_escape_string($con, $_POST["due_date"]);
        $subject = mysqli_real_escape_string($con, $_POST["subject"]);
        $sales_person = isset($_POST["sales_person"]) ? intval($_POST["sales_person"]) : null;
        $inv_discount = isset($_POST["inv_discount"]) && $_POST["inv_discount"] != '' ? floatval($_POST["inv_discount"]) : 0;
        $customerNotes = mysqli_real_escape_string($con, $_POST['customerNotes']);
        $order_no = mysqli_real_escape_string($con, $_POST['order_no']);
        $total_amount = floatval($_POST['total_amount']);
        $discount_total = floatval($_POST['discount-total']);
        $shipping_Charges = floatval($_POST['shipping-Charges']);
        $terms_cond = mysqli_real_escape_string($con, $_POST['terms_cond']);
        
        // Update invoice with prepared statement
        $updateQuery = "UPDATE zw_invoices SET 
            customer_id = ?, 
            subject = ?, 
            invoice_date = ?, 
            due_date = ?, 
            sales_person = ?, 
            remarks = ?, 
            toc = ?, 
            subTotal = ?,
            shippingCharges = ?,
            discount_total = ?
            WHERE id = ?";
        
        $stmtUpdate = mysqli_prepare($con, $updateQuery);
        mysqli_stmt_bind_param($stmtUpdate, "isssississdi", 
            $customer_id, $subject, $invoice_date, $due_date, 
            $sales_person, $customerNotes, $terms_cond, $total_amount,
            $shipping_Charges, $discount_total, $uid
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
?>

<style>
    .form-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .form-group {
        width: 100%;
        margin-bottom: 14px;
    }

    .total_table th,
    .total_table td {
        border: none;
    }
    
    .table-bordered {
        border: 1px solid #dee2e6;
    }
    
    .table-bordered th,
    .table-bordered td {
        border: 1px solid #dee2e6;
        padding: 10px;
    }
    
    input[type="submit"], input[type="reset"], .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-right: 10px;
    }
    
    input[type="submit"] {
        background-color: #007bff;
        color: white;
    }
    
    input[type="submit"]:hover {
        background-color: #0056b3;
    }
    
    input[type="reset"] {
        background-color: #6c757d;
        color: white;
    }
    
    .delete {
        background-color: #dc3545;
        color: white;
    }
    
    #addItem {
        background-color: #28a745;
        color: white;
    }
    
    .lineItemAmount {
        font-weight: bold;
    }
    
    select, input[type="text"], input[type="number"], input[type="date"], textarea {
        width: 100%;
        padding: 8px;
        border: 1px solid #ced4da;
        border-radius: 4px;
    }
</style>

<div class="form-container">
    <h2>Update Invoice</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group row">
                    <label for="customer_id" class="col-sm-2 col-form-label">Customer Name</label>
                    <div class="col-sm-6">
                        <select id="customer_id" class='form-select' name="customer_id" required>
                            <option value="" disabled>Select Customer</option>
                            <?php optionPrintAdv("zw_customers WHERE customer_type!='ulb'", "id", "customer_display_name", $res['customer_id']); ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="po_id" class="col-sm-2 col-form-label">Invoice</label>
                    <div class="col-sm-4">
                        <input id="po_id" class='form-control' name="po_id" 
                               value="<?php echo htmlspecialchars($res['p_o']); ?>" readonly>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="order_no" class="col-sm-2 col-form-label">Order Number</label>
                    <div class="col-sm-4">
                        <input type="text" id="order_no" class="form-control" placeholder="000-111" 
                               name="order_no" value="<?php echo htmlspecialchars($res['order_id']); ?>" readonly>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="invoice_date" class="col-sm-2 col-form-label">Invoice Date</label>
                    <div class="col-sm-3">
                        <input type='date' id="invoice_date" class='form-control' name='invoice_date' 
                               value="<?php echo htmlspecialchars($res['invoice_date']); ?>" required>
                    </div>
                    <label class="col-sm-1 col-form-label">Terms</label>
                    <div class="col-sm-2">
                        <select class="form-control" name="terms">
                            <option>Due on receipt</option>
                            <option>Net 15</option>
                            <option>Net 30</option>
                            <option>Net 45</option>
                            <option>Net 60</option>
                        </select>
                    </div>
                    <label for="due_date" class="col-sm-1 col-form-label">Due Date</label>
                    <div class="col-sm-2">
                        <input type='date' id="due_date" class='form-control' name='due_date' 
                               value="<?php echo htmlspecialchars($res['due_date']); ?>" required>
                    </div>
                </div>
                <hr>
                
                <div class="form-group row">
                    <label for="sales_person" class="col-sm-2 col-form-label">Salesperson</label>
                    <div class="col-sm-4">
                        <select id="sales_person" class='form-select' name="sales_person">
                            <option value="">Select Salesperson</option>
                            <?php optionPrintAdv("zw_user WHERE user_role='4'", "id", "username", $res['sales_person']); ?>
                        </select>
                    </div>
                </div>
                <hr>
                
                <div class="form-group row">
                    <label for="subject" class="col-sm-2 col-form-label">Subject</label>
                    <div class="col-sm-6">
                        <textarea id="subject" class="form-control" name='subject' rows="1" 
                                  required><?php echo htmlspecialchars($res['subject']); ?></textarea>
                    </div>
                </div>
                
                <div class="col-sm-12 mt-5 p-0">
                    <table class="table table-bordered" id="items_table" width="100%">
                        <thead>
                            <tr>
                                <th width="35%">Item Detail</th>
                                <th width="15%">Quantity</th>
                                <th width="15%">Rate</th>
                                <th width="15%">Amount</th>
                                <th width="15%">Discount</th>
                                <th width="5%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($resItmes) > 0): ?>
                                <?php foreach($resItmes as $item): ?>
                                <tr class="table_row">
                                    <td>
                                        <select class="form-control item-select" name="item_id[]" required>
                                            <option value="" disabled>Select an item</option>
                                            <?php optionPrintAdv("zw_items", "id", "name", $item['item_id']); ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control quantity" name="quantity[]" 
                                               placeholder="0" value="<?php echo htmlspecialchars($item['quantity']); ?>" 
                                               step="0.01" min="0" required>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control rate" name="rate[]" 
                                               placeholder="0.00" value="<?php echo htmlspecialchars($item['rate']); ?>" 
                                               step="0.01" min="0" required>
                                    </td>
                                    <td class="lineItemAmount">0.00</td>
                                    <td>
                                        <input type="number" class="form-control productDiscount" name="discount[]" 
                                               value="<?php echo htmlspecialchars($item['discount']); ?>" 
                                               placeholder="0.00" step="0.01" min="0">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm delete">Delete</button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr class="table_row">
                                    <td>
                                        <select class="form-control item-select" name="item_id[]" required>
                                            <option value="" disabled selected>Select an item</option>
                                            <?php optionPrintAdv("zw_items", "id", "name"); ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control quantity" name="quantity[]" 
                                               placeholder="0" step="0.01" min="0" required>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control rate" name="rate[]" 
                                               placeholder="0.00" step="0.01" min="0" required>
                                    </td>
                                    <td class="lineItemAmount">0.00</td>
                                    <td>
                                        <input type="number" class="form-control productDiscount" name="discount[]" 
                                               placeholder="0.00" step="0.01" min="0">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm delete" style="display:none;">Delete</button>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="d-flex flex-column p-0">
                            <div class="col-sm-12 p-0">
                                <button class="btn btn-success" type="button" id="addItem">Add another line</button>
                            </div> 
                            <div class="col-sm-12 p-0" style="margin-top: 50px;">
                                <h4>Customer Notes</h4>
                                <textarea class="form-control" placeholder="Thanks for your business" 
                                          name='customerNotes' rows="4"><?php echo htmlspecialchars($res['remarks']); ?></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-6">
                        <table class="table table-borderless total_table" width="100%">
                            <tr>
                                <th width="50%">Sub Total</th>
                                <td width="50%" class="text-right">
                                    <input type="hidden" name="total_amount" class="total_amount" 
                                           value="<?php echo htmlspecialchars($res['subTotal']); ?>">
                                    <span id="subTotal"><?php echo number_format($res['subTotal'], 2); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <th>Discount</th>
                                <td class="text-right">
                                    <input type="hidden" name="discount-total" class="total_discount" 
                                           value="<?php echo htmlspecialchars($res['discount_total']); ?>">
                                    <span id="discount-total"><?php echo number_format($res['discount_total'], 2); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <th>Adjustments</th>
                                <td class="text-right">
                                    <input type="number" id="shipping-Charges" name="shipping-Charges" 
                                           class="form-control" style="width: 120px; display: inline-block;"
                                           min="0" value="<?php echo htmlspecialchars($res['shippingCharges']); ?>" 
                                           step="0.01">
                                </td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td class="text-right">
                                    <strong><span id="total_amount">0.00</span></strong>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-md-6">
                        <h6>Terms and Conditions</h6>
                        <textarea class="form-control" placeholder="Enter terms and conditions of your business." 
                                  name="terms_cond" rows="4"><?php echo htmlspecialchars($res['toc']); ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <h6>Attach file to invoice</h6>
                        <input type="file" class="form-control" name="invoice_attachment">
                        <small class="text-muted">You can upload maximum 10 files, 5MB each</small>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-md-12">
                        <input type="submit" class="btn btn-primary" name="submit" value="Update Invoice">
                        <input type="reset" class="btn btn-secondary" name="reset" value="Reset">
                        <a href="<?php echo PROJECT_URL; ?>sub/epr/manage.php?t=invoice" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
$(document).ready(function() {
    // Function to calculate subtotal
    function calculateSubTotal() {
        let subTotal = 0;
        let total_discount = 0;
        let amount_without_discount = 0;
        let shipping_Charges = parseFloat($('#shipping-Charges').val()) || 0;
        
        $('#items_table tbody tr.table_row').each(function() {
            var row = $(this);
            var quantityValue = parseFloat(row.find('.quantity').val()) || 0;
            var rateValue = parseFloat(row.find('.rate').val()) || 0;
            var productDiscountValue = parseFloat(row.find('.productDiscount').val()) || 0;
            
            let lineItemAmount = quantityValue * rateValue;
            row.find('.lineItemAmount').text(lineItemAmount.toFixed(2));
            
            amount_without_discount += lineItemAmount;
            total_discount += productDiscountValue;
            subTotal += lineItemAmount - productDiscountValue;
        });
        
        // Calculate final total
        let finalTotal = subTotal - shipping_Charges;
        
        $('#subTotal').text(amount_without_discount.toFixed(2));
        $('#discount-total').text(total_discount.toFixed(2));
        $('.total_discount').val(total_discount.toFixed(2));
        $('#total_amount').text(finalTotal.toFixed(2));
        $('.total_amount').val(finalTotal.toFixed(2));
        
        // Show or hide delete buttons
        if ($('#items_table tbody tr.table_row').length > 1) {
            $('.delete').show();
        } else {
            $('.delete').hide();
        }
    }
    
    // Calculate on page load
    calculateSubTotal();
    
    // Attach event handlers
    $(document).on('input change', '.quantity, .rate, .productDiscount, #shipping-Charges', function() {
        calculateSubTotal();
    });
    
    // Add new row
    $('#addItem').on('click', function() {
        // Clone the first row and get select options
        var firstSelect = $('.item-select').first().clone();
        firstSelect.val('');
        
        var newRow = $('<tr class="table_row">');
        newRow.html(`
            <td></td>
            <td>
                <input type="number" class="form-control quantity" name="quantity[]" 
                       placeholder="0" step="0.01" min="0" required>
            </td>
            <td>
                <input type="number" class="form-control rate" name="rate[]" 
                       placeholder="0.00" step="0.01" min="0" required>
            </td>
            <td class="lineItemAmount">0.00</td>
            <td>
                <input type="number" class="form-control productDiscount" name="discount[]" 
                       placeholder="0.00" step="0.01" min="0">
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm delete">Delete</button>
            </td>
        `);
        
        // Add the select to first td
        newRow.find('td:first').append(firstSelect);
        
        $('#items_table tbody').append(newRow);
        calculateSubTotal();
    });
    
    // Delete row
    $(document).on('click', '.delete', function() {
        if ($('#items_table tbody tr.table_row').length > 1) {
            $(this).closest('tr').remove();
            calculateSubTotal();
        }
    });
    
    // Form validation
    $('form').on('submit', function(e) {
        let isValid = true;
        
        // Check if at least one item exists
        if ($('#items_table tbody tr.table_row').length === 0) {
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
        
        if (!isValid) {
            e.preventDefault();
        }
    });
});
</script>

</body>
</html>