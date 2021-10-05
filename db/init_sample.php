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
      "INSERT INTO `dorayaki` VALUES (1, 'dorayaki1', 20000, 50, 'ini dorayaki 1', 'img/dorayaki.png');",
      "INSERT INTO `dorayaki` VALUES (2, 'dorayaki2', 30000, 60, 'ini dorayaki 2', 'img/dorayaki.png');",
      "INSERT INTO `dorayaki` VALUES (3, 'dorayaki3', 40000, 100, 'ini dorayaki 3', 'img/dorayaki.png');",
      "INSERT INTO `dorayaki` VALUES (4, 'dorayaki4', 50000, 80, 'ini dorayaki 4', 'img/dorayaki.png');"
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
      "INSERT INTO `transactions` VALUES (1, 'shev', 1, 2,40000);",
      "INSERT INTO `transactions` VALUES (2, 'fik', 2, 3,90000);",
      "INSERT INTO `transactions` VALUES (3, 'yah', 3, 4,160000);",
      "INSERT INTO `transactions` VALUES (NULL, 'fik', 3, 10,400000);",
      "INSERT INTO `transactions` VALUES (NULL, 'shev', 2, 6,180000);",
      "INSERT INTO `transactions` VALUES (NULL, 'yah', 3, 4,160000);",
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

   // print_r($users);
   // print_r($dorayaki);
   // print_r($transactions);

   // $sql = "SELECT id_dorayaki, sum(total_buy) as total from transactions group by id_dorayaki order by total desc";
   // $sql = "SELECT t.id_dorayaki,sum(total_buy) as total_buy, nama, d.price, description,img_source from transactions t inner join dorayaki d ON t.id_dorayaki = d.id_dorayaki group by t.id_dorayaki order by total_buy desc";
   // $data = [];
   // $results = $db->query($sql);
   // while ($res = $results->fetchArray(1)){
   //       array_push($data,$res);
   // }

   // print_r($data);

   $db->close();
     // Nanti tambahin tabel lain
?>