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
                    return `
                        <button class="btn btn-primary editBtn" data-id="${data.id}">Edit</button>
                        <button class="btn btn-danger deleteBtn" data-id="${data.id}">Delete</button>
                    `;
                }
            }
        ]
    });

    // Handle edit and delete button clicks
    $('#userTable').on('click', '.editBtn', function() {
        const userId = $(this).data('id');
        // Implement your edit functionality here
        window.location.href = 'edit_user.php?id=' + userId;
    });

    $('#userTable').on('click', '.deleteBtn', function() {
        const userId = $(this).data('id');
        // Implement your delete functionality here
        window.location.href = 'delete_user.php?id=' + userId;
    });
});