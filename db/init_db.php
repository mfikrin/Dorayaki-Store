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

     $sql ="DROP TABLE IF EXISTS dorayaki";

    $ret = $db->exec($sql);
    if(!$ret){
        echo $db->lastErrorMsg();
     } else {
        echo "dorayaki Table deleted successfully\n";
     }

     $sql ="DROP TABLE IF EXISTS transactions";

    $ret = $db->exec($sql);
    if(!$ret){
        echo $db->lastErrorMsg();
     } else {
        echo "transactions Table deleted successfully\n";
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

     // Tabel Dorayaki

     $sql ="
        CREATE TABLE dorayaki(
            id_dorayaki INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            nama VARCHAR(100) UNIQUE NOT NULL,
            price INT NOT NULL,
            amount INT NOT NULL,
            description VARCHAR(100) NOT NULL,
            img_source VARCHAR(255) NOT NULL
        )";

    $ret = $db->exec($sql);
    if(!$ret){
        echo $db->lastErrorMsg();
     } else {
        echo "dorayaki Table created successfully\n";
     }

     // Tabel Transaksi User

     $sql ="
        CREATE TABLE transactions(
            id_transaksi INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(100),
            id_dorayaki VARCHAR(100),
            total INT NOT NULL,
            price INT NOT NULL,
            FOREIGN KEY (username) REFERENCES users(username) on update cascade on delete cascade,
            FOREIGN KEY (id_dorayaki) REFERENCES dorayaki(id_dorayaki) on update cascade on delete cascade
        )";

    $ret = $db->exec($sql);
    if(!$ret){
        echo $db->lastErrorMsg();
     } else {
        echo "transactions Table created successfully\n";
     }


     $db->close();
     // Nanti tambahin tabel lain
?>