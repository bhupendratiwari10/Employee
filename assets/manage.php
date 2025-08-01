<?php if (isset($_GET['file'])) {
    $file = $_GET['file'];
}
error_reporting(E_ALL);
?>

<?php if ($file == 'user') { ?>

    $(document).ready(function() {
    $('#userTable').DataTable({
    "ajax": "api.php?fun=getusers", // Endpoint to fetch user data
    "columns": [
    { "data": "username" },
    { "data": "first_name" },
    { "data": "last_name" },
    { "data": "email" },
    { "data": "phone_no" },
    {
    "data": null,
    "render": function(data, type, row) {
    // Conditionally render the Edit button based on editPermission value
    if (editPermission === true) {
    if (deletePermission === true) {
    // If both editPermission and deletePermission are true, render both buttons
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button class="editBtn" data-id="${data.id}" title='Edit'><i class='mi-edit'></i>&nbsp;&nbsp;Edit</button></li>
            <li><button style="color: #e43116!important;" class="deleteBtn" data-id="${data.id}" title='Delete'><i class='mi-x-circle1'></i>&nbsp;&nbsp;Delete</button></li>
        </ul>
    </div>
    `;
    } else {
    // If editPermission is true but deletePermission is false, render only the Edit button
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button class="editBtn" data-id="${data.id}" title='Edit'><i class='mi-edit'></i>&nbsp;&nbsp;Edit</button></li>
        </ul>
    </div>
    `;
    }
    } else {
    // If editPermission is false, do not render the Edit button
    if (deletePermission === true) {
    // If deletePermission is true, render only the Delete button
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button style="color: #e43116!important;" class="deleteBtn" data-id="${data.id}" title='Delete'><i class='mi-x-circle1'></i>&nbsp;&nbsp;Delete</button></li>
        </ul>
    </div>
    `;
    } else {
    // If both editPermission and deletePermission are false, do not render any buttons
    return '';
    }
    }

    }
    }
    ]
    });

    // Handle edit and delete button clicks
    $('#userTable').on('click', '.editBtn', function() {
    const userId = $(this).data('id');
    // Implement your edit functionality here
    window.location.href = 'edit.php?type=user&id=' + userId;
    });

    $('#userTable').on('click', '.deleteBtn', function() {
    const userId = $(this).data('id');
    if(confirm("Do You Really Want To Delete This Record?"))
    window.location.href = 'delete.php?type=user&id=' + userId;{

    }
    });
    });

<?php } elseif ($file == 'categories') { ?>

    $(document).ready(function() {
    $('#userTable').DataTable({
    "ajax": "api.php?fun=getcategories", // Endpoint to fetch user data
    "columns": [
    { "data": "title" },
    { "data": "description" },
    {
    "data": null,
    "render": function(data, type, row) {
    // Conditionally render the Edit button based on editPermission value
    if (editPermission === true) {
    if (deletePermission === true) {
    // If both editPermission and deletePermission are true, render both buttons
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button class="editBtn" data-id="${data.id}" title='Edit'><i class='mi-edit'></i>&nbsp;&nbsp;Edit</button></li>
            <li><button style="color: #e43116!important;" class="deleteBtn" data-id="${data.id}" title='Delete'><i class='mi-x-circle1'></i>&nbsp;&nbsp;Delete</button></li>
        </ul>
    </div>
    `;
    } else {
    // If editPermission is true but deletePermission is false, render only the Edit button
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button class="editBtn" data-id="${data.id}" title='Edit'><i class='mi-edit'></i>&nbsp;&nbsp;Edit</button></li>
        </ul>
    </div>
    `;
    }
    } else {
    // If editPermission is false, do not render the Edit button
    if (deletePermission === true) {
    // If deletePermission is true, render only the Delete button
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button style="color: #e43116!important;" class="deleteBtn" data-id="${data.id}" title='Delete'><i class='mi-x-circle1'></i>&nbsp;&nbsp;Delete</button></li>
        </ul>
    </div>
    `;
    } else {
    // If both editPermission and deletePermission are false, do not render any buttons
    return '';
    }
    }

    }
    }
    ]
    });
    // Handle edit and delete button clicks
    $('#userTable').on('click', '.editBtn', function() {
    const userId = $(this).data('id');
    // Implement your edit functionality here
    window.location.href = 'edit.php?type=categories&id=' + userId;
    });
    $('#userTable').on('click', '.deleteBtn', function() {
    const userId = $(this).data('id');
    if(confirm("Do You Really Want To Delete This Record?"))
    window.location.href = 'delete.php?type=categories&id=' + userId;{

    }
    });
    });
<?php } elseif ($file == 'company') { ?>

    $(document).ready(function() {
    $('#userTable').DataTable({
    "ajax": "api.php?fun=getcompany", // Endpoint to fetch user data
    "columns": [
    { "data": null,
                "render": function(data, type, row) {
                return `<img src="${data.pfp}" style="width:45px;border:0.6px solid #ddd;border-radius:1000px;aspect-ratio:1/1;object-fit:contain;">`;
            }
            },
    { "data": "vendor_display_name" },
    { "data": "company_email" },
    { "data": "company_phone" },
    { "data": "remarks" },
    {
    "data": null,
    "render": function(data, type, row) {
    // Conditionally render the Edit button based on editPermission value
    if (editPermission === true) {
    if (deletePermission === true) {
    // If both editPermission and deletePermission are true, render both buttons
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button class="editBtn" data-id="${data.id}" title='Edit'><i class='mi-edit'></i>&nbsp;&nbsp;Edit</button></li>
            <li><button style="color: #e43116!important;" class="deleteBtn" data-id="${data.id}" title='Delete'><i class='mi-x-circle1'></i>&nbsp;&nbsp;Delete</button></li>
        </ul>
    </div>
    `;
    } else {
    // If editPermission is true but deletePermission is false, render only the Edit button
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button class="editBtn" data-id="${data.id}" title='Edit'><i class='mi-edit'></i>&nbsp;&nbsp;Edit</button></li>
        </ul>
    </div>
    `;
    }
    } else {
    // If editPermission is false, do not render the Edit button
    if (deletePermission === true) {
    // If deletePermission is true, render only the Delete button
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button style="color: #e43116!important;" class="deleteBtn" data-id="${data.id}" title='Delete'><i class='mi-x-circle1'></i>&nbsp;&nbsp;Delete</button></li>
        </ul>
    </div>
    `;
    } else {
    // If both editPermission and deletePermission are false, do not render any buttons
    return '';
    }
    }

    }
    }
    ]
    });

    // Handle edit and delete button clicks
    $('#userTable').on('click', '.editBtn', function() {
    const userId = $(this).data('id');
    // Implement your edit functionality here
    window.location.href = 'edit.php?type=company&id=' + userId;
    });
    $('#userTable').on('click', '.deleteBtn', function() {
    const userId = $(this).data('id');
    if(confirm("Do You Really Want To Delete This Record?"))
    window.location.href = 'delete.php?type=company&id=' + userId;{

    }
    });
    });
<?php } elseif ($file == 'expense') { ?>
    $(document).ready(function() {
    $('#userTable').DataTable({
    "ajax": "api.php?fun=expense", // Endpoint to fetch user data
    "columns": [
    { "data": "date" },
    { "data": "account" },
    { "data": "paid_throw" },
    { "data": "amount" },
    {
    "data": null,
    "render": function(data, type, row) {
    // Conditionally render the Edit button based on editPermission value
    if (editPermission === true) {
    if (deletePermission === true) {
    // If both editPermission and deletePermission are true, render both buttons
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button class="editBtn" data-id="${data.id}" title='Edit'><i class='mi-edit'></i>&nbsp;&nbsp;Edit</button></li>
            <li><button style="color: #e43116!important;" class="deleteBtn" data-id="${data.id}" title='Delete'><i class='mi-x-circle1'></i>&nbsp;&nbsp;Delete</button></li>
        </ul>
    </div>
    `;
    } else {
    // If editPermission is true but deletePermission is false, render only the Edit button
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button class="editBtn" data-id="${data.id}" title='Edit'><i class='mi-edit'></i>&nbsp;&nbsp;Edit</button></li>
        </ul>
    </div>
    `;
    }
    } else {
    // If editPermission is false, do not render the Edit button
    if (deletePermission === true) {
    // If deletePermission is true, render only the Delete button
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button style="color: #e43116!important;" class="deleteBtn" data-id="${data.id}" title='Delete'><i class='mi-x-circle1'></i>&nbsp;&nbsp;Delete</button></li>
        </ul>
    </div>
    `;
    } else {
    // If both editPermission and deletePermission are false, do not render any buttons
    return '';
    }
    }

    }
    }
    ]
    });
    // Handle edit and delete button clicks
    $('#userTable').on('click', '.editBtn', function() {
    const userId = $(this).data('id');
    // Implement your edit functionality here
    window.location.href = 'edit.php?type=expense&id=' + userId;
    });
    $('#userTable').on('click', '.deleteBtn', function() {
    const userId = $(this).data('id');
    if(confirm("Do You Really Want To Delete This Record?"))
    window.location.href = 'delete.php?type=expense&id=' + userId;{

    }
    });
    });

<?php } elseif ($file == 'customer') { ?>

    $(document).ready(function() {
    $('#userTable').DataTable({
    "ajax": "api.php?fun=getcustomers", // Endpoint to fetch user data
    "columns": [
    { "data": null,
                "render": function(data, type, row) {
                return `<img src="${data.profile_pic}" style="width:45px;border:0.6px solid #ddd;border-radius:1000px;aspect-ratio:1/1;object-fit:contain;">`;
            }
            },
    { "data": "customer_display_name" },
    { "data": "company_name" },
    { "data": "customer_email" },
    { "data": "customer_phone" },
    { "data": "id" },
    {
    "data": null,
    "render": function(data, type, row) {
    // Conditionally render the Edit button based on editPermission value
    if (editPermission === true) {
    if (deletePermission === true) {
    // If both editPermission and deletePermission are true, render both buttons
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button class="editBtn" data-id="${data.id}" title='Edit'><i class='mi-edit'></i>&nbsp;&nbsp;Edit</button></li>
            <li><button style="color: #e43116!important;" class="deleteBtn" data-id="${data.id}" title='Delete'><i class='mi-x-circle1'></i>&nbsp;&nbsp;Delete</button></li>
        </ul>
    </div>
    `;
    } else {
    // If editPermission is true but deletePermission is false, render only the Edit button
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button class="editBtn" data-id="${data.id}" title='Edit'><i class='mi-edit'></i>&nbsp;&nbsp;Edit</button></li>
        </ul>
    </div>
    `;
    }
    } else {
    // If editPermission is false, do not render the Edit button
    if (deletePermission === true) {
    // If deletePermission is true, render only the Delete button
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button style="color: #e43116!important;" class="deleteBtn" data-id="${data.id}" title='Delete'><i class='mi-x-circle1'></i>&nbsp;&nbsp;Delete</button></li>
        </ul>
    </div>
    `;
    } else {
    // If both editPermission and deletePermission are false, do not render any buttons
    return '';
    }
    }

    }
    }
    ]
    });

    // Handle edit and delete button clicks
    $('#userTable').on('click', '.editBtn', function() {
    const userId = $(this).data('id');
    // Implement your edit functionality here
    window.location.href = 'edit.php?type=customer&id=' + userId;
    });

    $('#userTable').on('click', '.deleteBtn', function() {
    const userId = $(this).data('id');
    if(confirm("Do You Really Want To Delete This Record?"))
    window.location.href = 'delete.php?type=customer&id=' + userId;{

    }
    });
    });

<?php } elseif ($file == 'items') { ?>

    $(document).ready(function() {
    $('#userTable').DataTable({
    "ajax": "api.php?fun=getitems", // Endpoint to fetch user data
    "columns": [
    { "data": "name" },
    { "data": "selling_price_description" },
    { "data": "unit" },
    { "data": "selling_price" },
    {
    "data": null,
    "render": function(data, type, row) {
    // Conditionally render the Edit button based on editPermission value
    if (editPermission === true) {
    if (deletePermission === true) {
    // If both editPermission and deletePermission are true, render both buttons
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button class="editBtn" data-id="${data.id}" title='Edit'><i class='mi-edit'></i>&nbsp;&nbsp;Edit</button></li>
            <li><button style="color: #e43116!important;" class="deleteBtn" data-id="${data.id}" title='Delete'><i class='mi-x-circle1'></i>&nbsp;&nbsp;Delete</button></li>
        </ul>
    </div>
    `;
    } else {
    // If editPermission is true but deletePermission is false, render only the Edit button
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button class="editBtn" data-id="${data.id}" title='Edit'><i class='mi-edit'></i>&nbsp;&nbsp;Edit</button></li>
        </ul>
    </div>
    `;
    }
    } else {
    // If editPermission is false, do not render the Edit button
    if (deletePermission === true) {
    // If deletePermission is true, render only the Delete button
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button style="color: #e43116!important;" class="deleteBtn" data-id="${data.id}" title='Delete'><i class='mi-x-circle1'></i>&nbsp;&nbsp;Delete</button></li>
        </ul>
    </div>
    `;
    } else {
    // If both editPermission and deletePermission are false, do not render any buttons
    return '';
    }
    }

    }
    }
    ]
    });

    // Handle edit and delete button clicks
    $('#userTable').on('click', '.editBtn', function() {
    const userId = $(this).data('id');
    window.location.href = 'edit.php?type=items&id=' + userId;
    });

    $('#userTable').on('click', '.deleteBtn', function() {
    const userId = $(this).data('id');
    if(confirm("Do You Really Want To Delete This Record?"))
    window.location.href = 'delete.php?type=items&id=' + userId;{

    }
    });
    });

<?php } elseif ($file == 'price') { ?>

    $(document).ready(function() {
    $('#userTable').DataTable({
    "ajax": "api.php?fun=getprice", // Endpoint to fetch user data
    "columns": [
    { "data": "name" },
    { "data": "description" },
    { "data": "item_rate" },
    {
    "data": null,
    "render": function(data, type, row) {
    // Conditionally render the Edit button based on editPermission value
    if (editPermission === true) {
    if (deletePermission === true) {
    // If both editPermission and deletePermission are true, render both buttons
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button class="editBtn" data-id="${data.id}" title='Edit'><i class='mi-edit'></i>&nbsp;&nbsp;Edit</button></li>
            <li><button style="color: #e43116!important;" class="deleteBtn" data-id="${data.id}" title='Delete'><i class='mi-x-circle1'></i>&nbsp;&nbsp;Delete</button></li>
        </ul>
    </div>
    `;
    } else {
    // If editPermission is true but deletePermission is false, render only the Edit button
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button class="editBtn" data-id="${data.id}" title='Edit'><i class='mi-edit'></i>&nbsp;&nbsp;Edit</button></li>
        </ul>
    </div>
    `;
    }
    } else {
    // If editPermission is false, do not render the Edit button
    if (deletePermission === true) {
    // If deletePermission is true, render only the Delete button
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button style="color: #e43116!important;" class="deleteBtn" data-id="${data.id}" title='Delete'><i class='mi-x-circle1'></i>&nbsp;&nbsp;Delete</button></li>
        </ul>
    </div>
    `;
    } else {
    // If both editPermission and deletePermission are false, do not render any buttons
    return '';
    }
    }

    }
    }
    ]
    });

    // Handle edit and delete button clicks
    $('#userTable').on('click', '.editBtn', function() {
    const userId = $(this).data('id');
    // Implement your edit functionality here
    window.location.href = 'edit.php?type=price&id=' + userId;
    });

    $('#userTable').on('click', '.deleteBtn', function() {
    const userId = $(this).data('id');
    if(confirm("Do You Really Want To Delete This Record?"))
    window.location.href = 'delete.php?type=price&id=' + userId;{

    }
    });
    });

<?php } elseif ($file == 'ulbs') { ?>

    $(document).ready(function() {
    $('#userTable').DataTable({
    "ajax": "api.php?fun=getulbs", // Endpoint to fetch user data
    "columns": [
    { "data": "title" },
    { "data": "district" },
    { "data": "state" },
    { "data": "monthly_waste" },
    {
    "data": null,
    "render": function(data, type, row) {
    // Conditionally render the Edit button based on editPermission value
    if (editPermission === true) {
    if (deletePermission === true) {
    // If both editPermission and deletePermission are true, render both buttons
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button class="editBtn" data-id="${data.id}" title='Edit'><i class='mi-edit'></i>&nbsp;&nbsp;Edit</button></li>
            <li><button style="color: #e43116!important;" class="deleteBtn" data-id="${data.id}" title='Delete'><i class='mi-x-circle1'></i>&nbsp;&nbsp;Delete</button></li>
        </ul>
    </div>
    `;
    } else {
    // If editPermission is true but deletePermission is false, render only the Edit button
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button class="editBtn" data-id="${data.id}" title='Edit'><i class='mi-edit'></i>&nbsp;&nbsp;Edit</button></li>
        </ul>
    </div>
    `;
    }
    } else {
    // If editPermission is false, do not render the Edit button
    if (deletePermission === true) {
    // If deletePermission is true, render only the Delete button
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button style="color: #e43116!important;" class="deleteBtn" data-id="${data.id}" title='Delete'><i class='mi-x-circle1'></i>&nbsp;&nbsp;Delete</button></li>
        </ul>
    </div>
    `;
    } else {
    // If both editPermission and deletePermission are false, do not render any buttons
    return '';
    }
    }

    }
    }
    ]
    });

    // Handle edit and delete button clicks
    $('#userTable').on('click', '.editBtn', function() {
    const userId = $(this).data('id');
    // Implement your edit functionality here
    window.location.href = 'edit.php?type=ulbs&id=' + userId;
    });

    $('#userTable').on('click', '.deleteBtn', function() {
    const userId = $(this).data('id');
    if(confirm("Do You Really Want To Delete This Record?"))
    window.location.href = 'delete.php?type=ulbs&id=' + userId;{

    }
    });
    });

<?php } elseif ($file == 'quote') { ?>

    $(document).ready(function() {
    $('#userTable').DataTable({
    "ajax": "api.php?fun=getQuotes", // Endpoint to fetch user data
    "columns": [
    { "data": "quote_date" },
    { "data": null,
            "render": function(data, type, row) {
            return `<span>#Quote-${data.id}</span>`;}
        },
    { "data": "customer_name" },
    { "data": "subTotal" },
    {
    "data": null,
    "render": function(data, type, row) {
    // Conditionally render the Edit button based on editPermission value
    if (editPermission === true) {
    if (deletePermission === true) {
    // If both editPermission and deletePermission are true, render both buttons
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button class="editBtn" data-id="${data.id}" title='Edit'><i class='mi-edit'></i>&nbsp;&nbsp;Edit</button></li>
            <li><button style="color: #e43116!important;" class="deleteBtn" data-id="${data.id}" title='Delete'><i class='mi-x-circle1'></i>&nbsp;&nbsp;Delete</button></li>
        </ul>
    </div>
    `;
    } else {
    // If editPermission is true but deletePermission is false, render only the Edit button
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button class="editBtn" data-id="${data.id}" title='Edit'><i class='mi-edit'></i>&nbsp;&nbsp;Edit</button></li>
        </ul>
    </div>
    `;
    }
    } else {
    // If editPermission is false, do not render the Edit button
    if (deletePermission === true) {
    // If deletePermission is true, render only the Delete button
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button style="color: #e43116!important;" class="deleteBtn" data-id="${data.id}" title='Delete'><i class='mi-x-circle1'></i>&nbsp;&nbsp;Delete</button></li>
        </ul>
    </div>
    `;
    } else {
    // If both editPermission and deletePermission are false, do not render any buttons
    return '';
    }
    }

    }
    }
    ]
    });

    // Handle edit and delete button clicks
    $('#userTable').on('click', '.editBtn', function() {
    const userId = $(this).data('id');
    // Implement your edit functionality here
    window.location.href = 'edit.php?type=quote&id=' + userId;
    });
    $('#userTable').on('click', '.cnvtBtn', function() {
    const userId = $(this).data('id');
    // Implement your edit functionality here
    window.location.href = 'edit.php?type=convert_in_invoice&id=' + userId;
    });

    $('#userTable').on('click', '.deleteBtn', function() {
    const userId = $(this).data('id');
    if(confirm("Do You Really Want To Delete This Record?"))
    window.location.href = 'delete.php?type=quote&id=' + userId;{

    }
    });

    $('#userTable').on('click', '.viewBtn', function() {
    const userId = $(this).data('id');
    // Implement your edit functionality here
    window.location.href = 'print.php?type=quote&id=' + userId;
    });

    });

<?php } elseif ($file == 'invoice') { ?>

    $(document).ready(function() {
    $('#userTable').DataTable({
    "ajax": "api.php?fun=getInvoice", // Endpoint to fetch user data
    "columns": [
    { "data": "invoice_date" },
    { "data": null,
            "render": function(data, type, row) {
            return `<a href="print.php?type=invoice&id=${data.id}">#ZW-IN-${data.id}</a>`;
        }
        },
    { "data": "customer_name" },
    { "data": "due_date" },
    { "data": null,
            "render": function(data, type, row) {
            if(data.status==1){return `<b>Unpaid</b>`;}
            if(data.status==0){return `<b>Paid</b>`;}
        }
        },
    { "data": "subTotal" },
    {
    "data": null,
    "render": function(data, type, row) {
    // Conditionally render the Edit button based on editPermission value
    if (editPermission === true) {
    if (deletePermission === true) {
    // If both editPermission and deletePermission are true, render both buttons
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button class="editBtn" data-id="${data.id}" title='Edit'><i class='mi-edit'></i>&nbsp;&nbsp;Edit</button></li>
            <li><button style="color: #e43116!important;" class="deleteBtn" data-id="${data.id}" title='Delete'><i class='mi-x-circle1'></i>&nbsp;&nbsp;Delete</button></li>
        </ul>
    </div>
    `;
    } else {
    // If editPermission is true but deletePermission is false, render only the Edit button
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button class="editBtn" data-id="${data.id}" title='Edit'><i class='mi-edit'></i>&nbsp;&nbsp;Edit</button></li>
        </ul>
    </div>
    `;
    }
    } else {
    // If editPermission is false, do not render the Edit button
    if (deletePermission === true) {
    // If deletePermission is true, render only the Delete button
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button style="color: #e43116!important;" class="deleteBtn" data-id="${data.id}" title='Delete'><i class='mi-x-circle1'></i>&nbsp;&nbsp;Delete</button></li>
        </ul>
    </div>
    `;
    } else {
    // If both editPermission and deletePermission are false, do not render any buttons
    return '';
    }
    }

    }
    }
    ]
    });

    // Handle edit and delete button clicks
    $('#userTable').on('click', '.viewBtn', function() {
    const userId = $(this).data('id');
    // Implement your edit functionality here
    window.location.href = 'print.php?type=invoice&id=' + userId;
    });

    // Handle edit and delete button clicks
    $('#userTable').on('click', '.editBtn', function() {
    const userId = $(this).data('id');
    // Implement your edit functionality here
    window.location.href = 'edit.php?type=invoice&id=' + userId;
    });

    // Handle edit and delete button clicks
    $('#userTable').on('click', '.awrdBtn', function() {
    const userId = $(this).data('id');
    window.location.href = 'certificate.php?type=cnc&id=' + userId;
    });

    $('#userTable').on('click', '.deleteBtn', function() {
    const userId = $(this).data('id');
    if(confirm("Do You Really Want To Delete This Record?"))
    window.location.href = 'delete.php?type=invoice&id=' + userId;{

    }
    });
    });

<?php } elseif ($file == 'eprinvoice') { ?>

    $(document).ready(function() {
    $('#eprinvoiceTable').DataTable({
    "ajax": "api.php?fun=getEPRInvoice", // Endpoint to fetch user data
    "columns": [
    { "data" : "invoice_date"},
    { "data": null,
    "render": function(data, type, row) {
    return `<a href="print.php?type=eprinvoice&id=${data.id}">${data.invoice_id}</a>`;
    }
    },
    { "data": "customer_name" },
    { "data": "due_date" },
    { "data": "status" },
    { "data": "subTotal" },

    {
    "data": null,
    "render": function(data, type, row) {
    // Conditionally render the Edit button based on editPermission value
    if (editPermission === true) {
    if (deletePermission === true) {
    // If both editPermission and deletePermission are true, render both buttons
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button class="editBtn" data-id="${data.id}" title='Edit'><i class='mi-edit'></i>&nbsp;&nbsp;Edit</button></li>
            <li><button style="color: #e43116!important;" class="deleteBtn" data-id="${data.id}" title='Delete'><i class='mi-x-circle1'></i>&nbsp;&nbsp;Delete</button></li>
        </ul>
    </div>
    `;
    } else {
    // If editPermission is true but deletePermission is false, render only the Edit button
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button class="editBtn" data-id="${data.id}" title='Edit'><i class='mi-edit'></i>&nbsp;&nbsp;Edit</button></li>
        </ul>
    </div>
    `;
    }
    } else {
    // If editPermission is false, do not render the Edit button
    if (deletePermission === true) {
    // If deletePermission is true, render only the Delete button
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button style="color: #e43116!important;" class="deleteBtn" data-id="${data.id}" title='Delete'><i class='mi-x-circle1'></i>&nbsp;&nbsp;Delete</button></li>
        </ul>
    </div>
    `;
    } else {
    // If both editPermission and deletePermission are false, do not render any buttons
    return '';
    }
    }

    }
    }
    ]
    });

    // Handle edit and delete button clicks
    $('#eprinvoiceTable').on('click', '.viewBtn', function() {
    const userId = $(this).data('id');
    // Implement your edit functionality here
    window.location.href = 'print.php?type=eprinvoice&id=' + userId;
    });

    // Handle edit and delete button clicks
    $('#eprinvoiceTable').on('click', '.editBtn', function() {
    const userId = $(this).data('id');
    // Implement your edit functionality here
    window.location.href = 'edit.php?type=eprinvoice&id=' + userId;
    });

    $('#eprinvoiceTable').on('click', '.deleteBtn', function() {
    const userId = $(this).data('id');
    if(confirm("Do You Really Want To Delete This Record?"))
    window.location.href = 'delete.php?type=eprinvoice&id=' + userId;{

    }
    });
    });

<?php } elseif ($file == 'bill') { ?>

    $(document).ready(function() {
    $('#userTable').DataTable({
    "ajax": "api.php?fun=getBills", // Endpoint to fetch user data
    "columns": [
    { "data": "bill_date" },
    { "data": "id" },
    { "data": "customer_name" },
    { "data": "status" },
    { "data": "due_date" },
    { "data": "subTotal" },
    { "data": "amount_due" },
    {
    "data": null,
    "render": function(data, type, row) {
    // Conditionally render the Edit button based on editPermission value
    if (editPermission === true) {
    if (deletePermission === true) {
    // If both editPermission and deletePermission are true, render both buttons
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button class="editBtn" data-id="${data.id}" title='Edit'><i class='mi-edit'></i>&nbsp;&nbsp;Edit</button></li>
            <li><button style="color: #e43116!important;" class="deleteBtn" data-id="${data.id}" title='Delete'><i class='mi-x-circle1'></i>&nbsp;&nbsp;Delete</button></li>
        </ul>
    </div>
    `;
    } else {
    // If editPermission is true but deletePermission is false, render only the Edit button
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button class="editBtn" data-id="${data.id}" title='Edit'><i class='mi-edit'></i>&nbsp;&nbsp;Edit</button></li>
        </ul>
    </div>
    `;
    }
    } else {
    // If editPermission is false, do not render the Edit button
    if (deletePermission === true) {
    // If deletePermission is true, render only the Delete button
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button style="color: #e43116!important;" class="deleteBtn" data-id="${data.id}" title='Delete'><i class='mi-x-circle1'></i>&nbsp;&nbsp;Delete</button></li>
        </ul>
    </div>
    `;
    } else {
    // If both editPermission and deletePermission are false, do not render any buttons
    return '';
    }
    }

    }
    }
    ]
    });

    // Handle edit and delete button clicks
    $('#userTable').on('click', '.editBtn', function() {
    const userId = $(this).data('id');
    // Implement your edit functionality here
    window.location.href = 'edit.php?type=bill&id=' + userId;
    });

    $('#userTable').on('click', '.deleteBtn', function() {
    const userId = $(this).data('id');
    if(confirm("Do You Really Want To Delete This Record?"))
    window.location.href = 'delete.php?type=bill&id=' + userId;{

    }
    });
    });

<?php } elseif ($file == 'journal') { ?>

    $(document).ready(function() {
    $('#userTable').DataTable({
    "ajax": "api.php?fun=getjournal", // Endpoint to fetch user data
    "columns": [
    { "data": "date" },
        { "data": null,
            "render": function(data, type, row) {
            return `<a href="view.php?type=chartaccount&id=${data.id}">${data.title}</a>`;
        }
        },
    { "data": "refrence" },
    { "data": "total" },
    {
    "data": null,
    "render": function(data, type, row) {
    // Conditionally render the Edit button based on editPermission value
    if (editPermission === true) {
    if (deletePermission === true) {
    // If both editPermission and deletePermission are true, render both buttons
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button class="editBtn" data-id="${data.id}" title='Edit'><i class='mi-edit'></i>&nbsp;&nbsp;Edit</button></li>
            <li><button style="color: #e43116!important;" class="deleteBtn" data-id="${data.id}" title='Delete'><i class='mi-x-circle1'></i>&nbsp;&nbsp;Delete</button></li>
        </ul>
    </div>
    `;
    } else {
    // If editPermission is true but deletePermission is false, render only the Edit button
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button class="editBtn" data-id="${data.id}" title='Edit'><i class='mi-edit'></i>&nbsp;&nbsp;Edit</button></li>
        </ul>
    </div>
    `;
    }
    } else {
    // If editPermission is false, do not render the Edit button
    if (deletePermission === true) {
    // If deletePermission is true, render only the Delete button
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button style="color: #e43116!important;" class="deleteBtn" data-id="${data.id}" title='Delete'><i class='mi-x-circle1'></i>&nbsp;&nbsp;Delete</button></li>
        </ul>
    </div>
    `;
    } else {
    // If both editPermission and deletePermission are false, do not render any buttons
    return '';
    }
    }

    }
    }
    ]
    });
    
    
    // Handle edit and delete button clicks
    $('#userTable').on('click', '.editBtn', function() {
    const userId = $(this).data('id');
    // Implement your edit functionality here
    window.location.href = 'edit.php?type=journal&id=' + userId;
    });

    $('#userTable').on('click', '.deleteBtn', function() {
    const userId = $(this).data('id');
    if(confirm("Do You Really Want To Delete This Record?"))
    window.location.href = 'delete.php?type=journal&id=' + userId;{
    }
    });

    });

<?php } elseif ($file == 'accounts') { ?>

    $(document).ready(function() {
    $('#userTable').DataTable({
    "ajax": "api.php?fun=getAccounts", // Endpoint to fetch user data
    "columns": [
        { "data": null,
            "render": function(data, type, row) {
            return `<a href="view.php?type=chartaccount&id=${data.id}">${data.account_name}</a>`;
        }
        },
    { "data": "account_type" },
    { "data": "closing_balance" },
    {
    "data": null,
    "render": function(data, type, row) {
    // Conditionally render the Edit button based on editPermission value
    if (editPermission === true) {
    if (deletePermission === true) {
    // If both editPermission and deletePermission are true, render both buttons
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button class="editBtn" data-id="${data.id}" title='Edit'><i class='mi-edit'></i>&nbsp;&nbsp;Edit</button></li>
            <li><button style="color: #e43116!important;" class="deleteBtn" data-id="${data.id}" title='Delete'><i class='mi-x-circle1'></i>&nbsp;&nbsp;Delete</button></li>
        </ul>
    </div>
    `;
    } else {
    // If editPermission is true but deletePermission is false, render only the Edit button
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button class="editBtn" data-id="${data.id}" title='Edit'><i class='mi-edit'></i>&nbsp;&nbsp;Edit</button></li>
        </ul>
    </div>
    `;
    }
    } else {
    // If editPermission is false, do not render the Edit button
    if (deletePermission === true) {
    // If deletePermission is true, render only the Delete button
    return `
    <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button style="color: #e43116!important;" class="deleteBtn" data-id="${data.id}" title='Delete'><i class='mi-x-circle1'></i>&nbsp;&nbsp;Delete</button></li>
        </ul>
    </div>
    `;
    } else {
    // If both editPermission and deletePermission are false, do not render any buttons
    return '';
    }
    }

    }
    }
    ]
    });

    // Handle edit and delete button clicks
    $('#userTable').on('click', '.editBtn', function() {
    const userId = $(this).data('id');
    // Implement your edit functionality here
    window.location.href = 'edit.php?type=accounts&id=' + userId;
    });

    $('#userTable').on('click', '.deleteBtn', function() {
    const userId = $(this).data('id');
    if(confirm("Do You Really Want To Delete This Record?"))
    window.location.href = 'delete.php?type=accounts&id=' + userId;{
    }
    });

    });

<?php } elseif ($file == 'accountsx') { ?>

    $(document).ready(function() {
    $('#userTable').DataTable({
        "ajax": "api.php?fun=getAccountsx", // Endpoint to fetch user data
        "columns": [
            { "data": null,
                "render": function(data, type, row) {
                return `<a href="view.php?type=bank&id=${data.id}">${data.account_name}</a>`;
            }
            },
            { "data": "closing_balance" },
            {
                "data": null,
                "render": function(data) {
                    return `
                    <div class="dropdown">
                        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
                        <ul class="dropdown-menu">
                            <li class='d-none'><button class="viewBtn" style='color:orange!important' data-id="${data.id}" title='View'><i class='mi-eye-fill'></i>&nbsp;&nbsp;View</button></li>
                            <li><button class="editBtn" data-id="${data.id}" title='Edit'><i class='mi-edit'></i>&nbsp;&nbsp;Edit</button></li>
                            <li><button style="color: #e43116!important;" class="deleteBtn" data-id="${data.id}" title='Delete'><i class='mi-x-circle1'></i>&nbsp;&nbsp;Delete</button></li>
                        </ul>
                    </div>
                    `;
                }
            }
        ]
        });

        // Handle edit and delete button clicks
        $('#userTable').on('click', '.editBtn', function() {
        const userId = $(this).data('id');
        // Implement your edit functionality here
        window.location.href = 'edit.php?type=accounts&id=' + userId;
        });

        $('#userTable').on('click', '.deleteBtn', function() {
        const userId = $(this).data('id');
        if(confirm("Do You Really Want To Delete This Record?"))
        window.location.href = 'delete.php?type=accounts&id=' + userId;{

        }
        });

        $('#userTable').on('click', '.viewBtn', function() {
        const userId = $(this).data('id');
        // Implement your edit functionality here
        window.location.href = 'view.php?type=bank&id=' + userId;
        });
        });
   

    
<?php } elseif ($file == 'pickups') { ?>
    $(document).ready(function() {
    $('#userTable').DataTable({
    "ajax": "api.php?fun=getPickups", // Endpoint to fetch user data
    "columns": [
    { "data": "pickup_date" },
    { "data": null,
    "render": function(data, type, row) {
    return `<a href="view.php?type=pickups&id=${data.id}">ZW-PK-00${data.id}</a>`;
    }
    },
    { "data": "ulbname" },
    { "data": "states" },
    { "data": "supervisor" },
    {
    "data": null,
    "render": function(data, type, row) {
    if (data.steps <= 7) { return ` <div class="dropdown">
        <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
        <ul class="dropdown-menu">
            <li><button class="editBtn" data-id="${data.id}" title='Edit'><i class='mi-edit'></i>&nbsp;&nbsp;Edit</button></li>
            <li><button style="color: #e43116!important;" class="deleteBtn" data-id="${data.id}" title='Delete'><i class='mi-x-circle1'></i>&nbsp;&nbsp;Delete</button></li>
        </ul>
        </div>
        <button class="completeOrder" data-id="${data.id}" title='Complete Order'><i class='mi-ic_fluent_play_circle_24_filled'></i></button>
        `;
        } else {
        return `
        <div class="dropdown">
            <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
            <ul class="dropdown-menu">
                <li><button class="editBtn" data-id="${data.id}" title='Edit'><i class='mi-edit'></i>&nbsp;&nbsp;Edit</button></li>
                <li><button style="color: #e43116!important;" class="deleteBtn" data-id="${data.id}" title='Delete'><i class='mi-x-circle1'></i>&nbsp;&nbsp;Delete</button></li>
            </ul>
        </div>
        `;
        }
        }
        }
        ]
        });

        // Handle edit and delete button clicks
        $('#userTable').on('click', '.editBtn', function() {
        const userId = $(this).data('id');
        // Implement your edit functionality here
        window.location.href = 'edit.php?type=pickups&id=' + userId;
        });

        $('#userTable').on('click', '.deleteBtn', function() {
        const userId = $(this).data('id');
        if(confirm("Do You Really Want To Delete This Record?"))
        window.location.href = 'delete.php?type=pickups&id=' + userId;{

        }
        });

        $('#userTable').on('click', '.completeOrder', function() {
        const userId = $(this).data('id');
        // Implement your edit functionality here
        window.location.href = 'complete.php?type=pickups&id=' + userId;
        });
        $('#userTable').on('click', '.viewBtn', function() {
        const userId = $(this).data('id');
        // Implement your edit functionality here
        window.location.href = 'view.php?type=pickups&id=' + userId;
        });
        });


    <?php } elseif ($file == 'orders') { ?>
        $(document).ready(function() {
        $('#userTable').DataTable({
        "ajax": "api.php?fun=getOrders", // Endpoint to fetch user data
        "columns": [
        { "data": "po_date" },
        { "data": "po_id" },
        { "data": "customer_id" },
        {
        "data": null,
        "render": function(data, type, row) {
        return `
        <div class="dropdown">
            <button class="btn-default dropdown-toggle" type="button" data-toggle="dropdown"></button>
            <ul class="dropdown-menu">

                <li><button style="" class="editBtn" data-id="${data.id}" title='Edit'><i class='mi-edit'></i>&nbsp;&nbsp;Edit</button></li>
                <li><button style="color: #e43116!important;" class="deleteBtn" data-id="${data.id}" title='Delete'><i class='mi-x-circle1'></i>&nbsp;&nbsp;Delete</button></li>
            </ul>
        </div>
        `;
        }
        }
        ]
        });

        // Handle edit and delete button clicks
        $('#userTable').on('click', '.editBtn', function() {
        const userId = $(this).data('id');
        // Implement your edit functionality here
        window.location.href = 'edit.php?type=orders&id=' + userId;
        });

        $('#userTable').on('click', '.deleteBtn', function() {
        const userId = $(this).data('id');
        // Implement your delete functionality here
        if(confirm("Do You Really Want To Delete This Record?"))
        window.location.href = 'delete.php?type=orders&id=' + userId;{

        }
        });
        });


    <?php }
    ?>