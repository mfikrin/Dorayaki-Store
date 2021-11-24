<?php
    $db = new SQLite3('./basdat.db');
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

   $sql ="DROP TABLE IF EXISTS token";

    $ret = $db->exec($sql);
    if(!$ret){
      echo $db->lastErrorMsg();
   } else {
      echo "token Table deleted successfully\n";
   }
   $sql ="DROP TABLE IF EXISTS request";

    $ret = $db->exec($sql);
    if(!$ret){
      echo $db->lastErrorMsg();
   } else {
      echo "request Table deleted successfully\n";
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
            id_dorayaki INTEGER PRIMARY KEY AUTOINCREMENT,
            nama VARCHAR(100) UNIQUE NOT NULL,
            price INTEGER NOT NULL,
            amount INTEGER NOT NULL,
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
            id_transaksi INTEGER PRIMARY KEY AUTOINCREMENT,
            username VARCHAR(100),
            id_dorayaki INTEGER,
            total_buy INTEGER NOT NULL,
            total_price INTEGER NOT NULL,
            trans_time DATETIME NOT NULL,
            FOREIGN KEY (username) REFERENCES users(username),
            FOREIGN KEY (id_dorayaki) REFERENCES dorayaki(id_dorayaki)
        )";

    $ret = $db->exec($sql);
    if(!$ret){
        echo $db->lastErrorMsg();
     } else {
        echo "transactions Table created successfully\n";
     }

   $sql = "
   CREATE TABLE token ( 
   token_id VARCHAR(100) NOT NULL,
   username VARCHAR(100) NOT NULL,
   login_time DATETIME NOT NULL,
   expire_time DATETIME NOT NULL,
   PRIMARY KEY (token_id)
    )";

  $ret = $db->exec($sql);
  if(!$ret){
    echo $db->lastErrorMsg();
  } else {
    echo "token Table created successfully\n";
  }

  $sql ="
  CREATE TABLE request(
      request_id INTEGER PRIMARY KEY AUTOINCREMENT,
      id_dorayaki INTEGER,
      qty INTEGER NOT NULL,
      status VARCHAR(100) NOT NULL,
      trans_time DATETIME NOT NULL,
      acv INTEGER NOT NULL,
      FOREIGN KEY (id_dorayaki) REFERENCES dorayaki(id_dorayaki)
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