<?php


    $prevFirstName = namebyAid($uid, "first_name", "zw_user");
    $prevLastName = namebyAid($uid, "last_name", "zw_user");
    $prevUsername = namebyAid($uid, "username", "zw_user");
    $prevEmail = namebyAid($uid, "email", "zw_user");
    $prevPhoneNo = namebyAid($uid, "phone_no", "zw_user");
    
    $userRole = namebyAid($uid, "user_role", "zw_user");
   

    if (isset($_POST['firstName'])) {
        
        $firstName = mysqli_real_escape_string($con, $_POST["firstName"]);
        $lastName = mysqli_real_escape_string($con, $_POST["lastName"]);
        $username = mysqli_real_escape_string($con, $_POST["username"]);
        $email = mysqli_real_escape_string($con, $_POST["email"]);
        $phoneNo = mysqli_real_escape_string($con, $_POST["phoneNo"]);
        $password = mysqli_real_escape_string($con, $_POST["password"]);
        $user_role = mysqli_real_escape_string($con, $_POST["role"]);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $updateQuery = "UPDATE zw_user SET ";
        
        $updateData = array();
        if (!empty($firstName) && $firstName !== $prevFirstName) {
            $updateData[] = "first_name = '$firstName'";
        }
        if (!empty($lastName) && $lastName !== $prevLastName) {
            $updateData[] = "last_name = '$lastName'";
        }
        if (!empty($username) && $username !== $prevUsername) {
            $updateData[] = "username = '$username'";
        }
        if (!empty($email) && $email !== $prevEmail) {
            $updateData[] = "email = '$email'";
        }
        if (!empty($phoneNo) && $phoneNo !== $prevPhoneNo) {
            $updateData[] = "phone_no = '$phoneNo'";
        }
        
        if (!empty($pass)) {
            $updateData[] = "password = '$hashedPassword'";
        }

         if (!empty($user_role)) {
            $updateData[] = "user_role = '$user_role'";
        }
        
        if (!empty($updateData)) {
            $updateQuery .= implode(', ', $updateData);
            $updateQuery .= " WHERE id = $uid";
            
            if(mysqli_query($con, $updateQuery)){
                echo "<script>window.location.href = 'manage.php?t=user&g=usr';</script>";
            }
        }
    }

?>

    <h2>Edit User</h2>
        <form method="POST" action="">
        
            <div class='row'>
                <div class="mb-3 col-md-6">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $prevFirstName; ?>" required>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $prevLastName; ?>" required>
                </div>
            </div>
            <div class='row'>
                <div class="mb-3 col-md-6">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $prevUsername; ?>" required>
                </div>    
                <div class="mb-3 col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $prevEmail; ?>" required>
                </div>
            </div>
            <div class='row'>
                <div class="mb-3 col-md-4">
                    <label for="phoneNo" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="phoneNo" name="phoneNo" value="<?php echo $prevPhoneNo; ?>" required>
                </div>
                <div class="mb-3 col-md-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Leave it Empty if you don't want to change it">
                </div>
                <div class="col-md-4">
                    <label for="phoneNo" class="form-label">User Role</label>
                    <select class='form-select' name='role' required>
                        <option value="" disabled selected>Select a Role</option>
                        <?php optionPrintAdv("zw_user_roles","id","title" , $userRole); ?>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
</div>



?>