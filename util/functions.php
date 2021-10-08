<?php

function signUp($data){
    // Function to insert new customer data to database system
    // 1 : Insert berhasil
    // 0 : Password dan confirmation password tidak match
    // -1 : Username sudah ada di database

    // Get the value
    $username = $data["username"];
    $email = $data["email"];
    $password = $data["password"];
    $passwordConfimation = $data["password-confirmation"];
    $passwordHashed = password_hash($password, PASSWORD_BCRYPT);

    // Check if password and password confirmation don't match
    if ($password != $passwordConfimation){
        return 0;
    }
    
    try {
        $db = new PDO('sqlite:../db/basdat.db');

        // Check if the username input already exist in the database
        $sql = "SELECT * FROM users WHERE username='$username'";
        $queryResult = $db->query($sql);
        $result = $queryResult->fetchAll(PDO::FETCH_ASSOC);
        // check if either username or email doesn't exists in the database
        if (count($result)>0){
            return -1;
        }

        // Insert new data into the database
        $sql = "INSERT INTO `users` VALUES ('$username', '$email', '$passwordHashed', 0)";
        $queryResult = $db->exec($sql);
        return 1;
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

function login($data){
    // Function to check login system
    // 2 : Email/username dan password benar as admin
    // 1 : Email/username dan password benar as customer
    // 0 : Email/username sudah benar tapi password salah
    // -1 : Email/username tidak terdaftar

    // Get the value
    $usernameEmail = $data["usernameEmail"];
    $password = $data["password"];

    try {
        $db = new PDO('sqlite:../db/basdat.db');
        $sql = "SELECT * FROM users WHERE username='$usernameEmail' OR email='$usernameEmail'";
        $queryResult = $db->query($sql);

        $result = $queryResult->fetchAll(PDO::FETCH_ASSOC);

        // check if either username or email doesn't exists in the database
        if (count($result)==0){
            return -1;
        }

        // Check if the input password and passsword in database match
        if(password_verify($password, $result[0]['password'])){
            // Password verfied
            if ($result[0]['is_admin']==1){
                return 2;
            } else {
                return 1;
            }
        } else {
            // Wrong/Invalid password
            return 0;
        }

    } catch (PDOException $e) {
        $e->getMessage();
    }
}

function isEmailUsernameExistEncrypt($usernameEmail, $key){
    // Check whether there's cookie saved in the browser
    // 2 : key and usernamae/email match, as admin
    // 1 : key and usernamae/email match, as customer
    // 0 : Cookie doesn't exist or key and username/email don't match
    try {
        $db = new PDO('sqlite:../db/basdat.db');
        $sql = "SELECT * FROM users WHERE username='$usernameEmail' OR email='$usernameEmail'";
        $queryResult = $db->query($sql);

        $result = $queryResult->fetchAll(PDO::FETCH_ASSOC);

        // check if either username or email doesn't exists in the database
        if (count($result) == 0){
            return 0;
        }

        // Check if usernameEmail equals to key
        if ($key === hash('sha256',$usernameEmail)){
            if ($result[0]['is_admin']==1){
                return 2;
            } else {
                return 1;
            }
        } else {
            return 0;
        }


    } catch (PDOException $e) {
        $e->getMessage();
    }
}