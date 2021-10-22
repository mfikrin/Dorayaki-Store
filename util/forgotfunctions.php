<?php
    session_start();
    require 'functions.php';
    // Function to check login system
    // 1 : Email/username benar
    // 0 : Email/username salah
    // Get the value
    $usernameEmail = isset($_POST['usernameEmail']) ? $_POST['usernameEmail'] : '';

    $validation = true;
    $messages = array();

    if (!isset($usernameEmail) || empty($usernameEmail) ) {
        $validation = false;
        $messages[] = 'Username tidak boleh kosong!';
        $resultValidation = -2;
    }

    // if (!isset($password) || empty($password) ) {
    //     $validation = false;
    //     $messages[] = 'Password tidak boleh kosong!';
    //     $resultValidation = -2;
    // }

    if ($validation) {
        try {
            $db = new PDO('sqlite:../db/basdat.db');
            $sql = "SELECT * FROM users WHERE username='$usernameEmail'";
            $queryResult = $db->query($sql);

            $result = $queryResult->fetchAll(PDO::FETCH_ASSOC);

            // check if either username or email exists in the database
            if (count($result)==0){
                $validation = false;
                $messages[] = 'Username tidak terdaftar!';
                $resultValidation = -1;
            }else{
                $resultValidation = -1;
            }

            
        } catch (PDOException $e) {
            $e->getMessage();
            $validation = false;
        }
    }


    // if ($resultValidation >=1) {
    //     // Check checkbox remember me
    //     if ($checkbox=="true") {
    //         setcookie('usernameEmail', $_POST["usernameEmail"], time()+3600);
    //         setcookie('key', hash('sha256',$_POST["usernameEmail"]), time()+3600);
    //     }

    //     // Set new session 
    //     $_SESSION['login'] = true;
    //     $_SESSION['usernameEmail'] = $_POST["usernameEmail"];
    //     if ($loginValidation == 2){
    //         $_SESSION['is_admin'] = true;
    //     }
    //     header("Location: ../index.php");
    //     exit;
    // }

    echo json_encode(
        array(
            'errorCode' => $resultValidation,
            'validation' => $validation,
            'messages' => $messages
        )
    );

?>