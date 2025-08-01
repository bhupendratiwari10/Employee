<?php

include "inc/function.php";  $con = dbCon(); if (session_status() === PHP_SESSION_NONE) {
    session_start();
};

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $phoneNo = $_POST["phoneNo"];
    $registrationIP = userIP();
    $registrationOS = getOS();

    // Hash the password using password_hash() before storing it in the database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO zw_user (first_name, last_name, username, email, password, phone_no, registration_ip, registration_os, created_at, updated_at) 
              VALUES ('$firstName', '$lastName', '$username', '$email', '$hashedPassword', '$phoneNo', '$registrationIP', '$registrationOS', current_timestamp(), current_timestamp())";
              
    if (mysqli_query($con, $query)) {
        redirect("login.php");
    } else {
        echo "Error: " . mysqli_error($con);
    }
}

mysqli_close($con);
?>

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Create User</h2>
        <form method="POST" action="">
        <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>    
        <div class="mb-3">
                <label for="firstName" class="form-label">First Name</label>
                <input type="text" class="form-control" id="firstName" name="firstName" required>
            </div>
            <div class="mb-3">
                <label for="lastName" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lastName" name="lastName" required>
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="phoneNo" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phoneNo" name="phoneNo" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Signup</button>
        </form>
    </div>
</body>
</html>