<?php
session_start();
require 'util/functions.php';

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
            $_SESSION['is_admin'] = true;
        }
        else{
            $_SESSION['is_admin'] = false;
        }
    }
}

// Check if session exists
if (!isset($_SESSION["login"])) {
    header("Location: pages/login.php");
    exit;
}

header("location:pages/dashboard.php");
exit;
?>