<?php
   require 'init_db.php';
   $db = new SQLite3('./basdat.db');
   if(!$db) {
        echo $db->lastErrorMsg();
     } else {
        echo "Opened database successfully\n";
   }

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
            echo $db->lastErrorMsg();
         } else {
            echo "users Table updated successfully\n";
         }
    }

    # insert to dorayaki table

   //  $sql =[
   //    "INSERT INTO `dorayaki` VALUES (0, 'Dorayaki Placeholder', 20000, 50, 'Pandannya Wangy!', 'img/dorapandan.jpg');",
   // ];

   // foreach($sql as $que){
   //    $ret = $db->exec($que);
   //    if(!$ret){
   //       echo $db->lastErrorMsg();
   //     } else {
   //       echo "users dorayaki updated successfully\n";
   //     }
   // }

   // # insert to transactions table

   // $sql =[
   //    "INSERT INTO `transactions` VALUES (0, 'shev', 0, 2,40000,'2021-01-01 10:00:00');",
   // ];

   // foreach($sql as $que){
   //    $ret = $db->exec($que);
   //    if(!$ret){
   //        echo $db->lastErrorMsg();
   //     } else {
   //        echo "users transactions updated successfully\n";
   //     }
   // }


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

   // $users = select_all('users',$db);
   // $dorayaki = select_all('dorayaki',$db);
   // $transactions = select_all('transactions',$db);

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
   
   date_default_timezone_set("Asia/Jakarta");
   $tokenID = hash('sha256',"HIHIHAHAHA");
   $currTime = date("Y-m-d H:i:s");
   $expireTime = date("Y-m-d H:i:s", strtotime("+30 Minutes"));
   $sql = "INSERT INTO `token` VALUES ('$tokenID', 'HIHIHAHAHA', '$currTime', '$expireTime');";
   $ret = $db->exec($sql);
   // if(!$ret){
   //    echo $db->lastErrorMsg();
   // } else {
   //    echo "users token updated successfully\n";
   // }

   $db->close();
     // Nanti tambahin tabel lain
?>