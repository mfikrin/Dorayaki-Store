<?php
function tableMaker(){
    if ($_SESSION['is_admin']) {
        $db = new SQLite3('../db/basdat.db');
        $sql = "SELECT t.username,d.nama,d.price,t.total_buy,t.total_price,t.trans_time FROM dorayaki as d, transactions as t where d.id_dorayaki = t.id_dorayaki ORDER BY trans_time ASC";
        $trans = [];
        $stmt = $db->prepare($sql);
        $results = $stmt->execute();
        while ($res = $results->fetchArray(1)) {
            array_push($trans, $res);
        }
        if(empty($trans)){
            echo '<div class="histitle">
            <h5>No Transaction Recorded.<a href="../pages/dashboard.php">See Items</a></h5>
        </div>';
        }
        else{
            echo "<table>
            <tr>
                <th>Username</th>
                <th>Dorayaki Name</th>
                <th>Amount</th>
                <th>Total Price</th>
                <th>Date Time</th>
            </tr>";
            foreach($trans as $ts){
                $un = $ts["username"];
                $tp = number_format($ts["total_price"]);
                $nm = $ts["nama"];
                $amn = $ts["total_buy"];
                $date = date_create($ts["trans_time"]);
                $dtime = date_format($date,"d M Y H:i:s"); 
                echo "<tr>
                <td>$un</td>
                <td>$nm</td>
                <td>$amn</td>
                <td>$tp</td>
                <td>$dtime</td>
              </tr>";
            }
            echo "</table>";
        }
        echo '<div class="histitle">
        <h3>Admin Transaction History</h3>
    </div>';
        $db = new SQLite3('../db/basdat.db');
        $unem =  $_SESSION['usernameEmail'];
        $sql = "SELECT d.nama,d.price,t.total_buy,t.total_price,t.trans_time FROM dorayaki as d, transactions as t where d.id_dorayaki = t.id_dorayaki AND t.username =:unem ORDER BY trans_time ASC";
        $trans = [];
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":unem",$unem);
        $results = $stmt->execute();
        while ($res = $results->fetchArray(1)) {
            array_push($trans, $res);
        }
        if(empty($trans)){
            echo '<div class="histitle">
            <h5>No Transaction Recorded. <a href="../pages/dashboard.php">See Items</a></h5>
        </div>';
        }
        else{
            echo "<table>
            <tr>
                <th>Dorayaki Name</th>
                <th>Add/Delete Amount</th>
                <th>Date Time</th>
            </tr>";
            foreach($trans as $ts){
                $tp = number_format($ts["total_price"]);
                $nm = $ts["nama"];
                $amn = $ts["total_buy"];
                $date = date_create($ts["trans_time"]);
                $dtime = date_format($date,"d M Y H:i:s"); 
                echo "<tr>
                <td>$nm</td>
                <td>$amn</td>
                <td>$dtime</td>
              </tr>";
            }
            echo "</table>";
        }

    } else if (!$_SESSION['is_admin']) {
        $db = new SQLite3('../db/basdat.db');
        $unem =  $_SESSION['usernameEmail'];
        $sql = "SELECT d.nama,d.price,t.total_buy,t.total_price,t.trans_time FROM dorayaki as d, transactions as t where d.id_dorayaki = t.id_dorayaki AND t.username =:unem ORDER BY trans_time ASC";
        $trans = [];
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":unem",$unem);
        $results = $stmt->execute();
        while ($res = $results->fetchArray(1)) {
            array_push($trans, $res);
        }
        if(empty($trans)){
            echo '<div class="histitle">
            <h5>No Transaction Recorded. <a href="../pages/dashboard.php">Buy Items</a></h5>
        </div>';
        }
        else{
            echo "<table>
            <tr>
                <th>Dorayaki Name</th>
                <th>Buy Amount</th>
                <th>Total Price</th>
                <th>Date Time</th>
            </tr>";
            foreach($trans as $ts){
                $tp = number_format($ts["total_price"]);
                $nm = $ts["nama"];
                $amn = $ts["total_buy"];
                $date = date_create($ts["trans_time"]);
                $dtime = date_format($date,"d M Y H:i:s"); 
                echo "<tr>
                <td>$nm</td>
                <td>$amn</td>
                <td>$tp</td>
                <td>$dtime</td>
              </tr>";
            }
            echo "</table>";
        }
    }

}

function prodTable($id){
    $db = new SQLite3('../db/basdat.db');
    $sql = "SELECT t.username,d.nama,d.price,t.total_buy,t.total_price,t.trans_time FROM dorayaki as d, transactions as t where d.id_dorayaki = t.id_dorayaki AND d.id_dorayaki = $id ORDER BY trans_time ASC";
    $trans = [];
    $stmt = $db->prepare($sql);
    $results = $stmt->execute();
    while ($res = $results->fetchArray(1)) {
        array_push($trans, $res);
    }
    if(empty($trans)){
        echo '<div class="histitle">
        <h5>No Transaction Recorded. <a href="../pages/dashboard.php">See Items</a></h5>
    </div>';
    }
    else{
        echo "<table>
        <tr>
            <th>Username</th>
            <th>Amount</th>
            <th>Total Price</th>
            <th>Date Time</th>
        </tr>";
        foreach($trans as $ts){
            $un = $ts["username"];
            $tp = number_format($ts["total_price"]);
            $amn = $ts["total_buy"];
            $date = date_create($ts["trans_time"]);
            $dtime = date_format($date,"d M Y H:i:s"); 
            echo "<tr>
            <td>$un</td>
            <td>$amn</td>
            <td>$tp</td>
            <td>$dtime</td>
          </tr>";
        }
        echo "</table>";
    }
}

?>