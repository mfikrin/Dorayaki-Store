<?php   
    session_start();
    date_default_timezone_set("Asia/Jakarta");
    // Function to insert new customer data to database system
    // 1 : Insert berhasil
    // 0 : Password dan confirmation password tidak match
    // -1 : Username sudah ada di database
    //  -2 : Field ada yang kosong

    // Get the value
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $passwordConfimation = isset($_POST['passwordConfirmation']) ? $_POST['passwordConfirmation'] : '';
    $passwordHashed = password_hash($password, PASSWORD_BCRYPT);

    $validation = true;
    $messages = array();

    if (!isset($username) || empty($username) ) {
        $validation = false;
        $messages[] = 'Username tidak boleh kosong!';
        $resultValidation = -2;
    }

    if (!isset($email) || empty($email) ) {
        $validation = false;
        $messages[] = 'Email tidak boleh kosong!';
        $resultValidation = -2;
    }

    if (!isset($password) || empty($password) ) {
        $validation = false;
        $messages[] = 'Password tidak boleh kosong!';
        $resultValidation = -2;
    }

    if (!isset($passwordConfimation) || empty($passwordConfimation) ) {
        $validation = false;
        $messages[] = 'Konfirmasi password tidak boleh kosong!';
        $resultValidation = -2;
    }
    

    // Check if password and password confirmation don't match
    if ($password != $passwordConfimation){
        $validation = false;
        $messages[] = 'Password yang dimasukkan tidak sama';
        $resultValidation = 0;
    }
    
    if ($validation){
        try {
            $db = new PDO('sqlite:../db/basdat.db');
    
            // Check if the username input already exist in the database
            $sql = "SELECT * FROM users WHERE username='$username'";
            $queryResult = $db->query($sql);
            $result = $queryResult->fetchAll(PDO::FETCH_ASSOC);

            // check if either username or email doesn't exists in the database
            if (count($result)>0){
                $validation = false;
                $messages[] = 'Username sudah terdaftar, silahkan login';
                $resultValidation = -1;
            }
    
            // Insert new data into the database
            if ($validation){
                $sql = "INSERT INTO `users` VALUES ('$username', '$email', '$passwordHashed', 0)";
                $queryResult = $db->exec($sql);
                $validation = true;
                $messages[] = 'Proses pendaftaran berhasil';
                $resultValidation = 1;
                
                // Setting Sessions
                $_SESSION['login'] = true;
                $_SESSION['usernameEmail'] = $username;
                $_SESSION['is_admin'] = false;

                // Setting cookie
                setcookie('usernameEmail', $username, time()+3600, '/');
                setcookie('key', hash('sha256',$username), time()+3600, '/');

                // Set token
                $tokenID = hash('sha256',$username);
                $user = $username;
                $currTime = date("Y-m-d H:i:s");
                $expireTime = date("Y-m-d H:i:s", strtotime("+30 Minutes"));
                $sql = "INSERT INTO `token` VALUES ('$tokenID', '$user', '$currTime', '$expireTime');";
                $queryResult = $db->exec($sql);
            }
        } catch (PDOException $e) {
            $e->getMessage();
            $validation = false;
        }
    }

    echo json_encode(
        array(
            'errorCode' => $resultValidation,
            'validation' => $validation,
            'messages' => $messages
        )
    );
    

?>