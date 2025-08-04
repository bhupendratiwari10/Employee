<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
};

include "inc/function.php";
$con = dbCon();
checkLoggedin();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Hash the password using password_hash() before storing it in the database
    // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


    $query = "SELECT * FROM zw_user WHERE username = '$username' LIMIT 1";
    $result = mysqli_query($con, $query);
    $user = mysqli_fetch_assoc($result);
    $ucount = mysqli_num_rows($result);
    if ($ucount > 0) {
        if (password_verify($password, $user["password"])) {
            $uid = $user["id"];
            $unm = $user["username"];
            $userRole = $user['user_role'];
            $session_id = session_create_id();
            $session_key = substr(base64_encode(md5($uid) . rand(0, 9999)), 0, 16);
            $user_ip = userIP();
            $os = getOS();
            $browser = getBrowser();

            $insertQuery = "INSERT INTO zw_user_sessions (user_id, session_id, session_key, user_ip, user_browser, user_os, user_client, login_status, date_time)
         VALUES ($uid, '$session_id', '$session_key', '$user_ip', '$browser', '$os', 'user_client', 1, current_timestamp())"; //echo $insertQuery;
            if (mysqli_query($con, $insertQuery)) {
                createLogin($uid, $unm, $session_id, $userRole);
            } else {
                alert("session no create");
            }
            exit();
        } else {
        }
    } else {
        alert("User not found");
    }
} else {
    $error_message = "Invalid username or password.";
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/Blog/wp-content/uploads/2024/06/cropped-ZW-Logo-footer-1-1-32x32.png" sizes="32x32" />
    <link rel="icon" href="/Blog/wp-content/uploads/2024/06/cropped-ZW-Logo-footer-1-1-192x192.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="/Blog/wp-content/uploads/2024/06/cropped-ZW-Logo-footer-1-1-180x180.png" />
    <title>Tidy Rabbit | Employee Login</title>
    <link rel="stylesheet" href="index.css" />
    <link href='https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700,800,900' rel='stylesheet'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,700,0,0" />
    <style>
        body {
            position: relative;
            padding: 0;
            margin: 0;
            font-family: 'Montserrat';
        }

        .login-container {
            padding: 40px 50px 100px 50px;
            background-color: white;
            width: fit-content;
            height: fit-content;
            position: absolute;
            top: 0;
            right: 100px;
            box-shadow: 3px 3px 6px #00000029;
            border-radius: 0 0px 30px 30px;
            align-items: center;
            text-align: center;
        }

        .login-container img {
            height: 60px;
            margin-bottom: -21px;
            margin-top: 54px;
        }

        .login-container h1 {
            margin-bottom: 5px;
        }

        .thrilled {
            margin-top: 0;
        }

        .background-image {
            width: 100vw;
            height: 100vh;
            object-fit: cover;
            margin: auto;
        }

        h1 {
            font-weight: 700;
            font-size: 54px;

        }

        p {
            font-size: 11px;
            color: #707070;
        }

        .small-p {
            font-size: 10.5px;
            font-weight: 500;
        }

        form {
            margin-top: 40px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        form input {
            padding: 15px;
            border-radius: 10px;
            border-width: 1px;
        }

        button {
            padding: 15px 0;
            cursor: pointer;
            background-color: black;
            color: white;
            border: none;
            font-size: medium;
            font-weight: 600;
            margin-top: 10px;
            box-shadow: 0px 3px 3px #00000029;
            border-radius: 12px;
        }

        .remember {
            display: flex;
            gap: 2px;
        }

        .remember-forgot {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 30px;
        }

        .copyright {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            width: 100%;
            text-align: center;
        }

        .go-back {
            width: fit-content;
            height: 60px;
            background-color: black;
            position: absolute;
            top: 20px;
            left: 0;
            border-top-right-radius: 30px;
            border-bottom-right-radius: 30px;
            display: flex;
            gap: 20px;
            align-items: center;
            justify-content: space-between;
            color: white;
            padding-right: 5px;
        }

        .go-back p {
            font-size: 18px;
            font-weight: 400;
            color: white;
            padding-left: 20px;
        }



        .symbol-bg {
            background-color: white;
            color: black;
            width: 50px;
            height: 50px;
            padding: 0;
            display: flex;
            border-radius: 50%;
            align-items: center;
            justify-content: center;
            margin: 0;
            object-fit: cover;
            font-weight: 500;
        }

        .material-symbols-outlined {
            padding-left: 8px;
        }


        @media (max-width:768px) {


            .login-container {
                left: 20px;
                right: 20px;
                margin: auto;
                height: fit-content;
                padding: 20px;
            }


            h1 {
                font-size: 40px;
            }

            .go-back {
                visibility: hidden;
            }

            .remember-forgot {
                margin-bottom: 30px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <img src="https://zw.international/assets/ZW-Logo-footer-WbdtosrW.svg" />
        <h1>Welcome !</h1>
        <p class="thrilled">Glad to have you back, valued team member !</p>

        <form action="" method="POST">
            <input type="text" id="username" name="username" placeholder="Username .." />
            <input type="password" id="password" name="password" placeholder="Password .." />
            <button type="submit"> LOGIN </button>
        </form>
        <div class="remember-forgot">
            <div class="remember">
                <input type="checkbox">
                <p class="small-p">Remember Me</p>
            </div>
            <div>
                <p class="small-p">Forgot Password?</p>
            </div>
        </div>
        <p class="copyright small-p">— All rights reserved © Tidy Rabbit International —</p>
    </div>
    <img src="assets/Login%20Page%20-%20Employee.webp" class="background-image" />
    <a href="https://zw.international">
        <div class="go-back">
            <p>Go Back</p>
            <div class="symbol-bg">
                <span class="material-symbols-outlined">
                    arrow_back_ios
                </span>
            </div>
        </div>
    </a>
</body>

</html>