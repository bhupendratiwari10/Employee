<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $phoneNo = $_POST["phoneNo"];
    $role = $_POST["role"];
    $registrationIP = userIP();
    $registrationOS = getOS();

    // Hash the password using password_hash() before storing it in the database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO zw_user (first_name, last_name, username, email, password, phone_no, user_role, registration_ip, registration_os, created_at, updated_at) 
              VALUES ('$firstName', '$lastName', '$username', '$email', '$hashedPassword', '$phoneNo', '$role', '$registrationIP', '$registrationOS', current_timestamp(), current_timestamp())";
              
    if (mysqli_query($con, $query)) {
        redirect("manage.php?t=user");
    } else {
        echo "Error: " . mysqli_error($con);
    }
}

?>

        <h2>Create User</h2>
        <form method="POST" action="">
        <div class='col-12 row m-0 p-0'>
                <div class="col-md-6">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="firstName" name="firstName" required>
                </div>
                <div class="col-md-6">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="lastName" name="lastName" required>
                </div>
                
                <div class="col-md-6">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>    
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
    
                <div class="col-md-6">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="col-md-6">
                    <label for="password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="col-md-6">
                    <label for="phoneNo" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="phoneNo" name="phoneNo" required>
                </div>
                <div class="col-md-6">
                    <label for="phoneNo" class="form-label">User Role</label>
                    <select class='form-select' name='role' required>
                        <option value="" disabled selected>Select a Role</option>
                        <?php optionPrintAdv("zw_user_roles","id","title"); ?>
                    </select>
                </div>

        </div>
            <button type="submit" class="btn btn-primary">Signup</button>
        </form>