<?php include('inc/function.php'); if (session_status() === PHP_SESSION_NONE) {
    session_start();
}; checklogin();?>

<!DOCTYPE html>
<html lang="en hn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role Information Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class='row'>
    <?php include('inc/views/header.php'); ?>
    <?php
if(isset($_SESSION['role_error'])){
    echo $_SESSION['role_error'] ;
    unset($_SESSION['role_error'] );
}?>
    <div class="container mt-4" style ="margin-left: 236px;
    width: 73%;">
        <h2 class="text-center mb-4">Role Add Form</h2>
        <form method="post" action="">
            <div class="mb-3">
                <label class="form-label">Role Title</label>
                <input class="form-control" type="text" name="title">
            </div>
            <div class="mb-3">
                <label class="form-label">Role Description</label>
                <textarea class="form-control" type="number" name="desc"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <div class='row'>
                    <div class="form-check col">
                        <input class="form-check-input" type="radio" name="status" value="1" id="status-active">
                        <label class="form-check-label" for="status-active">Active</label>
                    </div>
                    <div class="form-check col">
                        <input class="form-check-input" type="radio" name="status" value="0" id="status-inactive">
                        <label class="form-check-label" for="status-inactive">Inactive</label>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary" type="submit"  name="submit">Submit</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
