<?php
    session_start();
    date_default_timezone_set("Asia/Jakarta");
    require 'functions.php';
    // Function to check login system
    // 2 : Email/username dan password benar as admin
    // 1 : Email/username dan password benar as customer
    // 0 : Email/username sudah benar tapi password salah
    // -1 : Email/username tidak terdaftar
    // -2 : Ada field yang kosong

    // Get the value
    $usernameEmail = isset($_POST['usernameEmail']) ? $_POST['usernameEmail'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $checkbox = isset($_POST['checkbox']) ? $_POST['checkbox'] : '';

    $validation = true;
    $messages = array();

    if (!isset($usernameEmail) || empty($usernameEmail) ) {
        $validation = false;
        $messages[] = 'Username tidak boleh kosong!';
        $resultValidation = -2;
    }

    if (!isset($password) || empty($password) ) {
        $validation = false;
        $messages[] = 'Password tidak boleh kosong!';
        $resultValidation = -2;
    }

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
            }

            // Check if the input password and passsword in database match
            if ($validation) {
                if(password_verify($password, $result[0]['password'])){
                    // Password verfied
                    
                    if ($result[0]['is_admin']==1){
                        $validation = true;
                        $messages[] = 'Successful login!';
                        $resultValidation = 2;
                        
                        $_SESSION['login'] = true;
                        $_SESSION['usernameEmail'] = $usernameEmail;
                        $_SESSION['is_admin'] = true;
                        setcookie('usernameEmail', $usernameEmail, time()+3600, '/');

                        if ($checkbox == "true") {
                            // setcookie('usernameEmail', $usernameEmail, time()+3600, '/');
                            setcookie('key', hash('sha256',$usernameEmail), time()+3600, '/');
                            // Set token
                            $tokenID = hash('sha256',$usernameEmail);
                            $user = $usernameEmail;
                            $currTime = date("Y-m-d H:i:s");
                            $expireTime = date("Y-m-d H:i:s", strtotime("+30 Minutes"));
                            $sql = "INSERT INTO `token` VALUES ('$tokenID', '$user', '$currTime', '$expireTime')";
                            $queryResult = $db->exec($sql);
                        }
                        
                    } else {
                        $validation = true;
                        $messages[] = 'Successful login!';
                        $resultValidation = 1;

                        $_SESSION['login'] = true;
                        $_SESSION['usernameEmail'] = $usernameEmail;
                        $_SESSION['is_admin'] = false;
                        setcookie('usernameEmail', $usernameEmail, time()+3600, '/');

                        if ($checkbox == "true") {
                            // setcookie('usernameEmail', $usernameEmail, time()+3600, '/');
                            setcookie('key', hash('sha256',$usernameEmail), time()+3600, '/');
                            // Set token
                            $tokenID = hash('sha256',$usernameEmail);
                            $user = $usernameEmail;
                            $currTime = date("Y-m-d H:i:s");
                            $expireTime = date("Y-m-d H:i:s", strtotime("+30 Minutes"));
                            $sql = "INSERT INTO `token` VALUES ('$tokenID', '$user', '$currTime', '$expireTime')";
                            $queryResult = $db->exec($sql);
                        }
                        
                    }
                } else {
                    // Wrong/Invalid password
                    $validation = false;
                    $messages[] = 'Password yang Anda masukan salah, silahkan cek kembali!';
                    $resultValidation = 0;
                }
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