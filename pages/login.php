<?php
session_start();
require '../util/functions.php';

// Check if cookie exists
if (isset($_COOKIE['usernameEmail']) && isset($_COOKIE['key'])){
    $key = $_COOKIE['key'];
    $userEmail = $_COOKIE['usernameEmail'];
    $isCookieValid = isEmailUsernameExistEncrypt($userEmail, $key);
    if ($isCookieValid>=1){
        // if useremail dan key in cookie is verified, make a session
        $_SESSION['login']= true;
        // Make session for admin, if the associated username is an admin
        if ($isCookieValid==2){
            $_SESSION['isAdmin'] = true;
        }
    }
}

// Check if admin session exists
if(isset($_SESSION["login"])){
    header("Location: ../index.php");
    exit;
}
 

// Session doesn't exist yet
// 2 : Email/username dan password benar as admin
// 1 : Email/username dan password benar as customer
// 0 : Email/username sudah benar tapi password salah
// -1 : Email/username tidak terdaftar
if(isset($_POST["login"])){
    $errorType = 1;
    $error = false;
    $loginValidation = login($_POST);
    if ($loginValidation == 1 || $loginValidation == 2) {
        // Check checkbox remember me
        if (isset($_POST['remember'])){
            setcookie('usernameEmail', $_POST["usernameEmail"], time()+3600);
            setcookie('key', hash('sha256',$_POST["usernameEmail"]), time()+3600);
        }

        // Set new session 
        $_SESSION['login'] = true;
        if ($loginValidation == 2){
            $_SESSION['isAdmin'] = true;
        }
        header("Location: ../index.php");
        exit;
    } else if ($loginValidation == 0) {
        // Email/username sudah benar tapi password salah
        $error = true;
        $errorType = 0;
    } else {
        // Email/username tidak terdaftar
        $error = true;
        $errorType = -1;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<html>
    <head>
        <title>Login-welcome to Stand with Dorayaki</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/LoginRegister.css">
    </head>
</html>
<body>

    <?php if(isset($error) && $error==true) : ?>
        <?php
            if ($loginValidation == 0) {
                // echo "Invalid Password, Check Your Password Again";
                $invalidPrompt = "Invalid Password, Check Your Password Again";
            } else if ($loginValidation == -1) {
                // echo "Email/username Not Registered";
                $invalidPrompt = "Email/Username Not Registered";
            }
        ?>
    <?php endif; ?>

    <div class="box">
        <div class="left-box">
            <h1 class="main-title signin">Login</h1>

            <?php if(isset($error) && $error==true) : ?>
                <h5 class="subtitle prompt"><?=$invalidPrompt?></h5>
            <?php endif; ?>

            <form class="fill-form" action="" method="POST">
                <ul>
                    <li>
                        <input class="input-text" type="text" name="usernameEmail" placeholder="Username/Password" required>
                    </li>
                    <li>
                        <input class="input-text"  type="password" name="password" placeholder="Password" required>
                    </li>
                    <li>
                        <input class="checkbox" type="checkbox" name="remember" id="remember" placeholder="Remember me">
                        <label class="checkbox" for="remember">Remember me</label>
                    </li>
                    <li>
                        <button class="submit btn" type="submit" name="login">Log in</button>
                    </li>
                    <li>
                        <a class="alt" href="signUp.php">Don't have an account? Sign Up</a>
                    </li>
                </ul>
            </form>
        </div>
        <div class="right-box">
            <h1 class="desc-box">Stand with Dorayaki</h1>
        </div>
    </div>

</body>