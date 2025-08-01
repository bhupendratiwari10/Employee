<?php
include('inc/function.php'); if (session_status() === PHP_SESSION_NONE) {
    session_start();
}; checklogin();
?>
<?php
if (isset($_POST['submit'])) {

    $roleTitle = $_POST['role-title'];
    $roleValue = $_POST['role-value'];
    $status = $_POST['status'];
if($status == 'active'){
$status =1;
}
else{
$status = 0;
}

    // Check if role value already exists
    $checkQuery = "SELECT * FROM zw_user_roles WHERE role_id = '$roleValue'";
// echo "yes";die;
    $result = mysqli_query($con, $checkQuery);
print_r( $result);
    if (mysqli_num_rows($result)> 0) {
        $_SESSION['role_error'] = "Role value already exists. Please choose a different value.";
    } else {
        // Insert data into the database

        $insertQuery = "INSERT INTO zw_user_roles (title, role_id, status) VALUES ('$roleTitle', '$roleValue', '$status')";
$insert = mysqli_query($con, $insertQuery);
        if ($insert == TRUE) {
            echo "New role added successfully.";
        } else {
            echo "Error: " . $insertQuery . "<br>" ;
        }
    }

    
}
?>
