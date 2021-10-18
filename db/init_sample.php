<?php
   require 'init_db.php';
   $db = new SQLite3('./basdat.db');
   // if(!$db) {
   //      echo $db->lastErrorMsg();
   //   } else {
   //      echo "Opened database successfully\n";
   // }

   # insert to users table

   $sql =[
      "INSERT INTO `users` VALUES ('admin', 'admin@nidma.id', '" . password_hash('admin', PASSWORD_BCRYPT) . "', 1);",
      "INSERT INTO `users` VALUES ('shev', 'shev@std.itb', '" . password_hash('123', PASSWORD_BCRYPT) . "', 0);",
      "INSERT INTO `users` VALUES ('fik', 'fik@std.itb', '" . password_hash('456', PASSWORD_BCRYPT) . "', 0);",
      "INSERT INTO `users` VALUES ('yah', 'yah@std.itb', '" . password_hash('789', PASSWORD_BCRYPT) . "', 0);",
   ];

    foreach($sql as $que){
        $ret = $db->exec($que);
        if(!$ret){
            // echo $db->lastErrorMsg();
         } else {
            // echo "users Table updated successfully\n";
         }
    }

    # insert to dorayaki table

    $sql =[
      "INSERT INTO `dorayaki` VALUES (0, 'dorayaki1', 20000, 50, 'ini dorayaki 1', 'img/dorayaki.png');",
      "INSERT INTO `dorayaki` VALUES (1, 'dorayaki2', 30000, 60, 'ini dorayaki 2', 'img/dorayaki.png');",
      "INSERT INTO `dorayaki` VALUES (2, 'dorayaki3', 40000, 100, 'ini dorayaki 3', 'img/dorayaki.png');",
      "INSERT INTO `dorayaki` VALUES (3, 'dorayaki4', 50000, 80, 'ini dorayaki 4', 'img/dorayaki.png');",
      "INSERT INTO `dorayaki` VALUES (4, 'dorayaki5', 60000, 80, 'ini dorayaki 5', 'img/dorayaki.png');",
      "INSERT INTO `dorayaki` VALUES (5, 'dorayaki6', 70000, 80, 'ini dorayaki 6', 'img/dorayaki.png');",
      "INSERT INTO `dorayaki` VALUES (6, 'dorayaki7', 80000, 50, 'ini dorayaki 7', 'img/dorayaki.png');",
      "INSERT INTO `dorayaki` VALUES (7, 'dorayaki8', 90000, 30, 'ini dorayaki 8', 'img/dorayaki.png');",
      "INSERT INTO `dorayaki` VALUES (8, 'dorayaki9', 100000, 40, 'ini dorayaki 9', 'img/dorayaki.png');",
      "INSERT INTO `dorayaki` VALUES (9, 'dorayaki10', 110000, 60, 'ini dorayaki 10', 'img/dorayaki.png');",
      "INSERT INTO `dorayaki` VALUES (10, 'dorayaki11', 120000, 70, 'ini dorayaki 11', 'img/dorayaki.png');",
      "INSERT INTO `dorayaki` VALUES (11, 'dorayaki12', 130000, 90, 'ini dorayaki 12', 'img/dorayaki.png');",
      "INSERT INTO `dorayaki` VALUES (12, 'dorayaki13', 140000, 10, 'ini dorayaki 13', 'img/dorayaki.png');",

   ];

   foreach($sql as $que){
      $ret = $db->exec($que);
      if(!$ret){
         //  echo $db->lastErrorMsg();
       } else {
         //  echo "users dorayaki updated successfully\n";
       }
   }

   # insert to transactions table

   $sql =[
      "INSERT INTO `transactions` VALUES (0, 'shev', 0, 2,40000,'2021-01-01 10:00:00');",
      "INSERT INTO `transactions` VALUES (1, 'fik', 1, 3,90000,'2021-01-01 10:00:00');",
      "INSERT INTO `transactions` VALUES (2, 'yah', 2, 4,160000,'2021-01-01 10:00:00');",
      "INSERT INTO `transactions` VALUES (3, 'fik', 0, 10,400000,'2021-10-01 10:00:00');",
      "INSERT INTO `transactions` VALUES (4, 'shev', 1, 6,180000,'2021-10-01 10:00:00');",
      "INSERT INTO `transactions` VALUES (5, 'yah', 2, 4,160000,'2021-10-01 10:00:00');",
      "INSERT INTO `transactions`(username,id_dorayaki,total_buy,total_price,trans_time)  VALUES ('fik', 2, 4,160000,'2021-10-03 10:00:00');",
      "INSERT INTO `transactions`(username,id_dorayaki,total_buy,total_price,trans_time)  VALUES ('fik', 1, 10,300000,'2021-10-05 10:00:00');",
   ];

   foreach($sql as $que){
      $ret = $db->exec($que);
      // if(!$ret){
      //     echo $db->lastErrorMsg();
      //  } else {
      //     echo "users transactions updated successfully\n";
      //  }
   }


   function select_all($table_name,$db){
      $sql = "SELECT * FROM $table_name";

      $data = [];
      $results = $db->query($sql);
      while ($res = $results->fetchArray(1)){
         array_push($data,$res);
      }

      // print_r($data);

      return $data;
   }

   $users = select_all('users',$db);
   $dorayaki = select_all('dorayaki',$db);
   $transactions = select_all('transactions',$db);

   print_r($users);
   print_r($dorayaki);
   print_r($transactions);

   $sql = "SELECT id_dorayaki, sum(total_buy) as total from transactions group by id_dorayaki order by total desc";
   $sql = "SELECT t.id_dorayaki,sum(total_buy) as total_buy, nama, d.price, description,img_source from transactions t inner join dorayaki d ON t.id_dorayaki = d.id_dorayaki group by t.id_dorayaki order by total_buy desc";
   $data = [];
   $results = $db->query($sql);
   while ($res = $results->fetchArray(1)){
         array_push($data,$res);
   }

   print_r($data);

   $db->close();
     // Nanti tambahin tabel lain
?>