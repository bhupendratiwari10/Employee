<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$prevTitle = namebyAid($uid, "title", "zw_user_roles");
$prevDesc = namebyAid($uid, "des", "zw_user_roles");
$prevStatus = namebyAid($uid, "status", "zw_user_roles");
$permissions = namebyAid($uid, 'page_permissions', 'zw_user_roles');
// $prevOrder = namebyAid($uid, "order_num", "zw_user_roles");

if (isset($_POST['title'])) {
    $title = mysqli_real_escape_string($con, $_POST["title"]);
    $desc = mysqli_real_escape_string($con, $_POST["desc"]);
    $status = mysqli_real_escape_string($con, $_POST["status"]);
    $permissions = mysqli_real_escape_string($con, $_POST["permissionArray"]);
    // $order = mysqli_real_escape_string($con, $_POST["order"]);

    $updateQuery = "UPDATE zw_user_roles SET ";

    $updateData = array();
    if (!empty($title) && $title !== $prevTitle) {
        $updateData[] = "title = '$title'";
    }
    if (!empty($desc) && $desc !== $prevDesc) {
        $updateData[] = "des = '$desc'";
    }
    if (!empty($status) && $status !== $prevStatus) {
        $updateData[] = "status = '$status'";
    }
    if (!empty($permissions)) {
        $updateData[] = "page_permissions = '$permissions'";
    }
    if (!empty($updateData)) {
        $updateQuery .= implode(', ', $updateData);
        $updateQuery .= " WHERE id = $uid";

        if (mysqli_query($con, $updateQuery)) {
            echo "<script>window.location.href = 'manage.php?t=roles&g=usr';</script>";
        }
    }
}


?>

<h2>Edit Role</h2>
<form method="post" action="" id="permission_form">
    <div class="mb-3">
        <label class="form-label">Role Title</label>
        <input class="form-control" type="text" name="title" value="<?php echo $prevTitle; ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Role Description</label>
        <textarea class="form-control" type="number" name="desc" required><?php echo $prevDesc; ?> </textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Status</label>
        <div class='row'>
            <div class="form-check col">
                <input class="form-check-input" type="radio" name="status" value="1" id="status-active" checked>
                <label class="form-check-label" for="status-active">Active</label>
            </div>
            <div class="form-check col">
                <input class="form-check-input" type="radio" name="status" value="0" id="status-inactive">
                <label class="form-check-label" for="status-inactive">Inactive</label>
            </div>
        </div>
    </div>




    <div class="card mb-5">
        <div class="card-header">
            <div class="card-title font-large mb-0">Main Sections</div>
        </div>
        <table class="table table-bordered role-table mb-0">
            <thead>
                <tr>
                    <td> </td>
                    <td class="permission">Full Access</td>
                    <td class="permission text-capitalize">View</td>
                    <td class="permission">Create</td>
                    <td class="permission">Edit</td>
                    <td class="permission">Delete</td>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Items</td>
                    <td class="permission full_access"><input type="checkbox" name="full_access_items"></td>
                    <td class="permission"><input type="checkbox" name="items_view"></td>
                    <td class="permission"><input type="checkbox" name="items_create"></td>
                    <td class="permission"><input type="checkbox" name="items_edit"></td>
                    <td class="permission"><input type="checkbox" name="items_delete"></td>

                </tr>
                <tr>
                    <td>Banking</td>
                    <td class="permission full_access"><input type="checkbox" name="full_access_banking"></td>
                    <td class="permission"><input type="checkbox" name="banking_view"></td>
                    <td class="permission"><input type="checkbox" name="banking_create"></td>
                    <td class="permission"><input type="checkbox" name="banking_edit"></td>
                    <td class="permission"><input type="checkbox" name="banking_delete"></td>

                </tr>

            </tbody>
        </table>
    </div>



    <div class="card mb-5">
        <div class="card-header">
            <div class="card-title font-large mb-0">Sales</div>
        </div>
        <table class="table table-bordered role-table mb-0">
            <thead>
                <tr>
                    <td> </td>
                    <td class="permission">Full Access</td>
                    <td class="permission text-capitalize">View</td>
                    <td class="permission">Create</td>
                    <td class="permission">Edit</td>
                    <td class="permission">Delete</td>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Customers</td>
                    <td class="permission full_access"><input type="checkbox" name="full_access_customer"></td>
                    <td class="permission"><input type="checkbox" name="customer_view"></td>
                    <td class="permission"><input type="checkbox" name="customer_create"></td>
                    <td class="permission"><input type="checkbox" name="customer_edit"></td>
                    <td class="permission"><input type="checkbox" name="customer_delete"></td>

                </tr>
                <tr>
                    <td>Quotes</td>
                    <td class="permission full_access"><input type="checkbox" name="full_access_quote"></td>
                    <td class="permission"><input type="checkbox" name="quote_view"></td>
                    <td class="permission"><input type="checkbox" name="quote_create"></td>
                    <td class="permission"><input type="checkbox" name="quote_edit"></td>
                    <td class="permission"><input type="checkbox" name="quote_delete"></td>

                </tr>
                <tr>
                    <td>Invoices</td>
                    <td class="permission full_access"><input type="checkbox" name="full_access_invoice"></td>
                    <td class="permission"><input type="checkbox" name="invoice_view"></td>
                    <td class="permission"><input type="checkbox" name="invoice_create"></td>
                    <td class="permission"><input type="checkbox" name="invoice_edit"></td>
                    <td class="permission"><input type="checkbox" name="invoice_delete"></td>

                </tr>
                <tr>
                    <td>Payments Received</td>
                    <td class="permission full_access"><input type="checkbox" name="full_access_payments-received"></td>
                    <td class="permission"><input type="checkbox" name="payments-received_view"></td>
                    <td class="permission"><input type="checkbox" name="payments-received_create"></td>
                    <td class="permission"><input type="checkbox" name="payments-received_edit"></td>
                    <td class="permission"><input type="checkbox" name="payments-received_delete"></td>

                </tr>
            </tbody>
        </table>
    </div>

    <div class="card mb-5">
        <div class="card-header">
            <div class="card-title font-large mb-0">Purchases</div>
        </div>
        <table class="table table-bordered role-table mb-0">
            <thead>
                <tr>
                    <td> </td>
                    <td class="permission">Full Access</td>
                    <td class="permission text-capitalize">View</td>
                    <td class="permission">Create</td>
                    <td class="permission">Edit</td>
                    <td class="permission">Delete</td>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Vendors</td>
                    <td class="permission full_access"><input type="checkbox" name="full_access_companies"></td>
                    <td class="permission"><input type="checkbox" name="companies_view"></td>
                    <td class="permission"><input type="checkbox" name="companies_create"></td>
                    <td class="permission"><input type="checkbox" name="companies_edit"></td>
                    <td class="permission"><input type="checkbox" name="companies_delete"></td>

                </tr>
                <tr>
                    <td>Bills</td>
                    <td class="permission full_access"><input type="checkbox" name="full_access_bill"></td>
                    <td class="permission"><input type="checkbox" name="bill_view"></td>
                    <td class="permission"><input type="checkbox" name="bill_create"></td>
                    <td class="permission"><input type="checkbox" name="bill_edit"></td>
                    <td class="permission"><input type="checkbox" name="bill_delete"></td>

                </tr>
                <tr>
                    <td>Expenses</td>
                    <td class="permission full_access"><input type="checkbox" name="full_access_expense"></td>
                    <td class="permission"><input type="checkbox" name="expense_view"></td>
                    <td class="permission"><input type="checkbox" name="expense_create"></td>
                    <td class="permission"><input type="checkbox" name="expense_edit"></td>
                    <td class="permission"><input type="checkbox" name="expense_delete"></td>

                </tr>
                <tr>
                    <td>Payments Made</td>
                    <td class="permission full_access"><input type="checkbox" name="full_access_payments-made"></td>
                    <td class="permission"><input type="checkbox" name="payments-made_view"></td>
                    <td class="permission"><input type="checkbox" name="payments-made_create"></td>
                    <td class="permission"><input type="checkbox" name="payments-made_edit"></td>
                    <td class="permission"><input type="checkbox" name="payments-made_delete"></td>

                </tr>
            </tbody>
        </table>
    </div>

    <div class="card mb-5">
        <div class="card-header">
            <div class="card-title font-large mb-0">Accountant</div>
        </div>
        <table class="table table-bordered role-table mb-0">
            <thead>
                <tr>
                    <td> </td>
                    <td class="permission">Full Access</td>
                    <td class="permission text-capitalize">View</td>
                    <td class="permission">Create</td>
                    <td class="permission">Edit</td>
                    <td class="permission">Delete</td>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Chart Of Accounts</td>
                    <td class="permission full_access"><input type="checkbox" name="full_access_accounts"></td>
                    <td class="permission"><input type="checkbox" name="accounts_view"></td>
                    <td class="permission"><input type="checkbox" name="accounts_create"></td>
                    <td class="permission"><input type="checkbox" name="accounts_edit"></td>
                    <td class="permission"><input type="checkbox" name="accounts_delete"></td>

                </tr>
                <tr>
                    <td>Manual Journal</td>
                    <td class="permission full_access"><input type="checkbox" name="full_access_journal"></td>
                    <td class="permission"><input type="checkbox" name="journal_view"></td>
                    <td class="permission"><input type="checkbox" name="journal_create"></td>
                    <td class="permission"><input type="checkbox" name="journal_edit"></td>
                    <td class="permission"><input type="checkbox" name="journal_delete"></td>

                </tr>

            </tbody>
        </table>
    </div>

    <div class="card mb-5">
        <div class="card-header">
            <div class="card-title font-large mb-0">EPR</div>
        </div>
        <table class="table table-bordered role-table mb-0">
            <thead>
                <tr>
                    <td> </td>
                    <td class="permission">Full Access</td>
                    <td class="permission text-capitalize">View</td>
                    <td class="permission">Create</td>
                    <td class="permission">Edit</td>
                    <td class="permission">Delete</td>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Orders</td>
                    <td class="permission full_access"><input type="checkbox" name="full_access_orders"></td>
                    <td class="permission"><input type="checkbox" name="orders_view"></td>
                    <td class="permission"><input type="checkbox" name="orders_create"></td>
                    <td class="permission"><input type="checkbox" name="orders_edit"></td>
                    <td class="permission"><input type="checkbox" name="orders_delete"></td>

                </tr>
                <tr>
                    <td>Pickup</td>
                    <td class="permission full_access"><input type="checkbox" name="full_access_pickups"></td>
                    <td class="permission"><input type="checkbox" name="pickups_view"></td>
                    <td class="permission"><input type="checkbox" name="pickups_create"></td>
                    <td class="permission"><input type="checkbox" name="pickups_edit"></td>
                    <td class="permission"><input type="checkbox" name="pickups_delete"></td>

                </tr>
                <tr>
                    <td>Invoices</td>
                    <td class="permission full_access"><input type="checkbox" name="full_access_eprinvoice"></td>
                    <td class="permission"><input type="checkbox" name="eprinvoice_view"></td>
                    <td class="permission"><input type="checkbox" name="eprinvoice_create"></td>
                    <td class="permission"><input type="checkbox" name="eprinvoice_edit"></td>
                    <td class="permission"><input type="checkbox" name="eprinvoice_delete"></td>

                </tr>
                <tr>
                    <td>ULB's</td>
                    <td class="permission full_access"><input type="checkbox" name="full_access_ulbs"></td>
                    <td class="permission"><input type="checkbox" name="ulbs_view"></td>
                    <td class="permission"><input type="checkbox" name="ulbs_create"></td>
                    <td class="permission"><input type="checkbox" name="ulbs_edit"></td>
                    <td class="permission"><input type="checkbox" name="ulbs_delete"></td>

                </tr>
                <tr>
                    <td>Categories</td>
                    <td class="permission full_access"><input type="checkbox" name="full_access_categories"></td>
                    <td class="permission"><input type="checkbox" name="categories_view"></td>
                    <td class="permission"><input type="checkbox" name="categories_create"></td>
                    <td class="permission"><input type="checkbox" name="categories_edit"></td>
                    <td class="permission"><input type="checkbox" name="categories_delete"></td>

                </tr>
                <tr>
                    <td>Reports</td>
                    <td class="permission full_access"><input type="checkbox" name="full_access_eprreports"></td>
                    <td class="permission"><input type="checkbox" name="eprreports_view"></td>
                    <td class="permission"></td>
                    <td class="permission"></td>
                    <td class="permission"></td>

                </tr>
            </tbody>
        </table>
    </div>




    <div class="card mb-5">
        <div class="card-header">
            <div class="card-title font-large mb-0">Report</div>
        </div>
        <table class="table table-bordered role-table mb-0">
            <thead>
                <tr>
                    <td> </td>
                    <td class="permission">Full Access</td>
                    <td class="permission text-capitalize">View</td>
                    <td class="permission">Create</td>
                    <td class="permission">Edit</td>
                    <td class="permission">Delete</td>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Profit & Loss</td>
                    <td class="permission full_access">
                        <input type="checkbox" name="full_access_user">
                    </td>
                    <td class="permission"><input type="checkbox" name="profit-loss_view"></td>
                    <td class="permission"><input type="checkbox" name="profit-loss_create"></td>
                    <td class="permission"><input type="checkbox" name="profit-loss_edit"></td>
                    <td class="permission"><input type="checkbox" name="profit-loss_delete"></td>

                </tr>
                <tr>
                    <td>Balance Sheet</td>
                    <td class="permission full_access"><input type="checkbox" name="full_access_roles"></td>
                    <td class="permission"><input type="checkbox" name="balance-sheet_view"></td>
                    <td class="permission"><input type="checkbox" name="balance-sheet_create"></td>
                    <td class="permission"><input type="checkbox" name="balance-sheet_edit"></td>
                    <td class="permission"><input type="checkbox" name="balance-sheet_delete"></td>

                </tr>

                <tr>
                    <td>Cash flow statement</td>
                    <td class="permission full_access"><input type="checkbox" name="full_access_roles"></td>
                    <td class="permission"><input type="checkbox" name="cashflow_view"></td>
                    <td class="permission"><input type="checkbox" name="cashflow_create"></td>
                    <td class="permission"><input type="checkbox" name="cashflow_edit"></td>
                    <td class="permission"><input type="checkbox" name="cashflow_delete"></td>

                </tr>

            </tbody>
        </table>
    </div>






    <div class="card mb-5">
        <div class="card-header">
            <div class="card-title font-large mb-0">Setting</div>
        </div>
        <table class="table table-bordered role-table mb-0">
            <thead>
                <tr>
                    <td> </td>
                    <td class="permission">Full Access</td>
                    <td class="permission text-capitalize">View</td>
                    <td class="permission">Create</td>
                    <td class="permission">Edit</td>
                    <td class="permission">Delete</td>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Users</td>
                    <td class="permission full_access"><input type="checkbox" name="full_access_user"></td>
                    <td class="permission"><input type="checkbox" name="user_view"></td>
                    <td class="permission"><input type="checkbox" name="user_create"></td>
                    <td class="permission"><input type="checkbox" name="user_edit"></td>
                    <td class="permission"><input type="checkbox" name="user_delete"></td>

                </tr>
                <tr>
                    <td>User Role</td>
                    <td class="permission full_access"><input type="checkbox" name="full_access_roles"></td>
                    <td class="permission"><input type="checkbox" name="roles_view"></td>
                    <td class="permission"><input type="checkbox" name="roles_create"></td>
                    <td class="permission"><input type="checkbox" name="roles_edit"></td>
                    <td class="permission"><input type="checkbox" name="roles_delete"></td>

                </tr>

            </tbody>
        </table>
    </div>

</form>
<button class="btn btn-primary" type="submit" name="submit" id="edit_button">Submit</button>


<script>
    $(document).ready(function() {
        // Event handler for the full_access checkbox
        $('.full_access input[type="checkbox"]').change(function() {
            // Find the closest row and select all checkboxes within that row
            $(this).closest('tr').find('.permission input[type="checkbox"]').prop('checked', $(this).prop('checked'));
        });
        let permissions = "<?php echo $permissions ?>";
        if (permissions !== 'undefined' && permissions !== null && permissions.length > 1) {
            let permissionsArray = permissions.split(',');
            permissionsArray.forEach(function(item, index) {
                $('input:checkbox[name="' + item + '"]').prop('checked', true); // Make Checkboxes Checked
            })
        }

        // Select All checkBox



    });
    $('#edit_button').click(function(e) {
        e.preventDefault();
        let permissionArray = [];
        let checkBoxes = $('.permission input[type="checkbox"]:checked');
        checkBoxes.each(function() {
            name = $(this).attr('name');
            if (name !== 'undefined') {
                permissionArray.push(name);
            }
        })

        let permissionArrayJson = JSON.stringify(permissionArray);

        // Append the JSON string as a hidden input field to the form
        $('<input>').attr({
            type: 'hidden',
            name: 'permissionArray', // Change to match your backend key
            value: permissionArray
        }).appendTo('#permission_form');

        // Submit the form
        $('#permission_form').submit();
    });
</script>