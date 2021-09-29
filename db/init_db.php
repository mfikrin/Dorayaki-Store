<?php
    $db = new SQLite3('basdat.db');
    if(!$db) {
        echo $db->lastErrorMsg();
     } else {
        echo "Opened database successfully\n";
     }

     $sql ="DROP TABLE IF EXISTS users";

    $ret = $db->exec($sql);
    if(!$ret){
        echo $db->lastErrorMsg();
     } else {
        echo "users Table deleted successfully\n";
     }

    $sql ="
        CREATE TABLE users(
            username VARCHAR(100) PRIMARY KEY,
            email VARCHAR(100) UNIQUE NOT NULL,
            password VARCHAR(100) NOT NULL,
            is_admin BOOLEAN NOT NULL
        )";

    $ret = $db->exec($sql);
    if(!$ret){
        echo $db->lastErrorMsg();
     } else {
        echo "users Table created successfully\n";
     }
     $db->close();
     // Nanti tambahin tabel lain
?>