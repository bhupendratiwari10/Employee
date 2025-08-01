<?php

include "inc/function.php";

// Check if the user is logged in

// Delete the session and user session record from the database
$session_id = $_COOKIE["session"]; $con = dbCon();





// Delete the session record from the database      
//$deleteQuery = "DELETE FROM zw_user_sessions WHERE session_id = '$session_id'"; //mysqli_query($con, $deleteQuery);


// (Never delete it from database because that's the login record. Try This instead ~ Ritesh)
//$deleteQuery = "UPDATE zw_user_sessions SET login_status='0' WHERE session_id = '$session_id'"; //mysqli_query($con, $deleteQuery);


// Clear the cookies independently // setcookie("session", "", time() - 3600);      setcookie("username", "", time() - 3600); (Good - but Doesn't work unless on main domain )

// Destroy the session
session_destroy();

?>


<script>
    // Function to clear all cookies
function clearAllCookies() {
    var cookies = document.cookie.split("; ");
    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        var eqPos = cookie.indexOf("=");
        var cookieName = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        document.cookie = cookieName + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/sub/epr";
        document.cookie = cookieName + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";
    }
}

// Call the function to clear all cookies
clearAllCookies();

// Redirect to login page
window.location.replace("login.php");

</script>