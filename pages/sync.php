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
    $client = new SoapClient("http://localhost:8080/DoraSupp/ws/req?wsdl");
    $resp = $client->getStatus("http://localhost:8000");
    $db = new SQLite3('../db/basdat.db');
    $sql = "SELECT r.trans_time FROM dorayaki as d,request as r where d.id_dorayaki = r.id_dorayaki AND r.status ='pending'";
    $trans = [];
    $defname = "admin";
    foreach($resp as $r){
        foreach($r as $s){
            if(gettype($s) == 'array'){
                if($s[1] == "accepted" or $s[1]=="rejected"){
                    $tu = $s[0];
                    $tv = $s[1];
                    $q1 ="SELECT r.id_dorayaki as id,r.qty as qty,d.price*r.qty as prc FROM `dorayaki` as d,`request` as r WHERE d.id_dorayaki = r.id_dorayaki AND r.trans_time ='$tu'";
                    $req = [];
                    $r1 = $db->query($q1);
                    while ($rez = $r1->fetchArray(1)) {
                        array_push($req, $rez);
                    }
                    $idr = $req[0]["id"];
                    $qt = $req[0]["qty"];
                    $tpc = $req[0]["prc"];
                    $q2 = "UPDATE `request` SET status='$tv' WHERE trans_time='$tu'";
                    $r2 = $db->exec($q2);
                    if($t[1] == "accepted"){
                        $q5 = "UPDATE `dorayaki` SET amount = amount + '$qt' WHERE id_dorayaki = '$idr'";
                        $r5 = $db->exec($q5);
                        date_default_timezone_set('Asia/Jakarta');
                        $deto = date("Y-m-d H:i:s");
                        $q3 = "INSERT INTO `transactions` (username,id_dorayaki,total_buy,total_price,trans_time) VALUES ('$defname','$idr','$qt',0,'$deto')";
                        $r3 = $db->exec($q3);
                    }
                }
            }
            else{
                foreach($s as $t){
                    if($t[1] == "accepted" or $t[1]=="rejected"){
                        $tu = $t[0];
                        $tv = $t[1];
                        $q1 ="SELECT r.id_dorayaki as id,r.qty as qty,d.price*r.qty as prc FROM `dorayaki` as d,`request` as r WHERE d.id_dorayaki = r.id_dorayaki AND r.trans_time ='$tu'";
                        $req = [];
                        $r1 = $db->query($q1);
                        while ($rez = $r1->fetchArray(1)) {
                            array_push($req, $rez);
                        }
                        $idr = $req[0]["id"];
                        $qt = $req[0]["qty"];
                        $tpc = $req[0]["prc"];
                        $q2 = "UPDATE `request` SET status='$tv' WHERE trans_time='$tu'";
                        $r2 = $db->exec($q2);
                        if($t[1] == "accepted"){
                            $q5 = "UPDATE `dorayaki` SET amount = amount + '$qt' WHERE id_dorayaki = '$idr'";
                            $r5 = $db->exec($q5);
                            date_default_timezone_set('Asia/Jakarta');
                            $deto = date("Y-m-d H:i:s");
                            $q3 = "INSERT INTO `transactions` (username,id_dorayaki,total_buy,total_price,trans_time) VALUES ('$defname','$idr','$qt',0,'$deto')";
                            $r3 = $db->exec($q3);
                        }
                    }
                }
            }
        }
    }
    $db->close();
    header("Location: request.php");
?>