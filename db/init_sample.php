<?php
    $db = new SQLite3('basdat.db');
    if(!$db) {
        echo $db->lastErrorMsg();
     } else {
        echo "Opened database successfully\n";
     }

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
    $db->close();
     // Nanti tambahin tabel lain
?>