<?php
session_start();
require '../util/loginAuth.php';
if(!$_SESSION['is_admin']){
    header("Location: dashboard.php");
}
include('../util/item_util.php')?>
<!-- Validation Soon -->
<!-- Dorayaki Variant Updater (fromSOAP)-->

<?php 
    $client = new SoapClient("http://localhost:8080/DoraSupp/ws/dora?wsdl");
    $resp = $client->getDorayaki();
    $db = new SQLite3('../db/basdat.db');
    $desc = 'Pandannya Wangy!';
    $img = 'img/dorapandan.jpg';
    foreach($resp as $r){
        foreach($r as $item){
            $sql = "INSERT INTO `dorayaki`(nama,price,amount,description,img_source) VALUES ('$item',0,0,'$desc','$img');";
            $exc = $db->exec($sql);
        }
    }
    header("Location: dashboard.php");
?>