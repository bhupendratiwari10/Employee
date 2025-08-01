<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (isset($_POST['title'])) {
    $title = $_POST["title"] ?? $_POST["title"];
    $desc = $_POST["desc"] ?? $_POST["desc"];
    $status = $_POST["status"] ?? $_POST["status"];
    // $order = $_POST["order"] ? $_POST["order"] : null;
    $page_permissions = $_POST["permissionArray"] ?? $_POST["permissionArray"];

    // Include your database connection here
    // $con = mysqli_connect("localhost", "username", "password", "database_name");

    // Check if connection is successful
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepared statement to prevent SQL injection
    $query = "INSERT INTO zw_user_roles (title, des, status , page_permissions) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $query);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ssis", $title, $desc, $status,  $page_permissions);


    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
         alert("Role Added");
         redirect('manage.php?t=roles&g=usr');
    } else {
         alert("Role Entry Failed");
    }

    // Close statement
    mysqli_stmt_close($stmt);

    // Close connection
    mysqli_close($con);
}
?>
<h2>Add Role</h2>
<form method="post" action "" id="permission_form">
    <div class="mb-3">
        <label class="form-label">Role Title</label>
        <input class="form-control" type="text" name="title" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Role Description</label>
        <textarea class="form-control" type="textarea" name="desc" required></textarea>
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
    <!-- <div class="mb-3">
                <label class="form-label">Role Order</label>
                <input class="form-control" type="number" name="order">
            </div> -->



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
<button class="btn btn-primary" type="submit" name="submit" id="add_button">Submit</button>


<script>
    $(document).ready(function() {
        // Event handler for the full_access checkbox
        $('.full_access input[type="checkbox"]').change(function() {
            // Find the closest row and select all checkboxes within that row
            $(this).closest('tr').find('.permission input[type="checkbox"]').prop('checked', $(this).prop('checked'));
        });
    });
    $('#add_button').click(function(e) {
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