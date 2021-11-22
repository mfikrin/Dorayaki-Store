<?php
    function getItem($itemid)
    {
        $db = new SQLite3('../db/basdat.db');
        // $sql = "SELECT t.id_dorayaki,sum(total_buy) as total_buy,nama,d.price, description,amount,img_source FROM transactions t inner join dorayaki d ON t.id_dorayaki = d.id_dorayaki WHERE t.id_dorayaki =$itemid group by t.id_dorayaki order by total_buy desc";
        // $sql = "SELECT d.id_dorayaki,sum(total_buy) as total_buy, nama, d.price, description,amount,img_source from dorayaki d left outer join transactions t ON t.id_dorayaki = d.id_dorayaki WHERE d.id_dorayaki =$itemid group by t.id_dorayaki order by total_buy desc";
        $sql = "SELECT id_dorayaki, nama, price, description, amount,img_source from dorayaki WHERE id_dorayaki = $itemid";
        $dorayakis = [];
        $results = $db->query($sql);
        while ($res = $results->fetchArray(1)) {
            array_push($dorayakis, $res);
        }
        if(!empty($dorayakis)){
            $dorayakis[0]["total_buy"] = getAmountSold($itemid);
        }
        $db->close();
        return $dorayakis;
    }

    function buttonAdder($id)
    {
        if ($_SESSION['is_admin']) {
            echo '<a href="edit_amount.php?id_dorayaki='. $id . '"><button class="prod-edit" onclick="" style="cursor:pointer">Change Amount</button></a>';
            echo '<a href="edit_variant.php?id_dorayaki='. $id . '"><button class="prod-edit" id="editvar" onclick="" style="cursor:pointer">Edit Variant</button></a>';
            echo '<a href="prod_history.php?id_dorayaki='. $id . '"><button class="prod-edit" id="hist" onclick="" style="cursor:pointer">History</button></a>';
            echo '<button class="prod-delete" onclick="deletePrompt('.$id.');" style="cursor:pointer">Delete Variant</button>';
        } else if (!$_SESSION['is_admin']) {    
            echo '<a href="edit_amount.php?id_dorayaki='. $id . '"><button class="prod-buy" onclick="" style="cursor:pointer">Buy</button></a>';
        }
    }
    
    function buyAdder($id){
        if ($_SESSION['is_admin']) {
            echo '<button class="butbuy" name="buyProd" type="submit">Buy</button>';
        } else if (!$_SESSION['is_admin']) {
            echo '<button class="butbuy" name="buyProd" type="submit">Buy</button>';
        }
    }

    function buttonBuy(){
        $id = $_GET['id_dorayaki'];
        if(!$_SESSION['is_admin']){
            echo'<form action="" method="POST" enctype="multipart/form-data"><div class="buy-button">
                <button class="edit-stock" type="button" id="krg" style=""> - </button>
                <input class="buy-inp" type="number" id="qty" name="qty" min="1" max="" style="-moz-appearance:textfield;" required>
                <button class="edit-stock" type="button" id="tmb" style="float:right"> + </button>
                </div>'
            ;
            echo '<div><div class="inFlex"><a href="../pages/details.php?id_dorayaki='. $id . '"><button class="butmit" type="button" id="canBut">Cancel</button></a>';
            echo '<button class="butmit" name="buyItem" id="subBut" type="submit">Buy Above Amount</button></div></div>';
            submitBuy();
            echo '</form>';
        }
        else{
            echo'<form action="" method="POST" enctype="multipart/form-data"><div class="buy-button">
                <button class="edit-stock" type="button" id="krg" style=""> - </button>
                <input class="buy-inp" type="number" id="qty" name="qty" style="-moz-appearance:textfield;" required>
                <button class="edit-stock" type="button" id="tmb" style="float:right"> + </button>
                </div>'
            ;
            echo '<div><div class="inFlex"><a href="../pages/details.php?id_dorayaki='. $id . '"><button class="butmit" type="button" id="canBut">Cancel</button></a>';
            echo '<button class="butmit" name="buyItem" id="subBut" type="submit">Commit Above Changes</button></div></div>';
            submitChangeSOAP();
            echo '</form>';
        }
    }

    function buyProduct($id){
        if (isset($_POST['buyProd'])) {
            $db = new SQLite3('../db/basdat.db');
            $sql = "UPDATE dorayaki SET amount = amount-1 WHERE id_dorayaki=$id";
            $ret = $db->exec($sql);
            $db->close();
        }
    }

    function getAmountSold($itemid){
        $db = new SQLite3('../db/basdat.db');
        $sql = "SELECT id_dorayaki from transactions WHERE id_dorayaki = $itemid";
        $transaction = [];
        $results = $db->query($sql);
        while ($res = $results->fetchArray(1)) {
            array_push($transaction, $res);
        }
        $db->close();
        $sold = count($transaction);
        return $sold;

    }

    function checkExt(){
    if (isset($_FILES['addimage'])) {
        $tmp = explode('.', $_FILES['addimage']['name']);
        $imgext = strtolower(end($tmp));
        $allowedext = array("png", "jpg", "jpeg");
        if (in_array($imgext, $allowedext) === false) {
            echo '<span style="color:#C4161C;">Failed. Allowed Extensions : png, jpg, jpeg</span>';
        }
    }
}
    function submitBuy(){
        if(isset($_POST['buyItem']) and isset($_POST['qty'])){
            $id = $_GET['id_dorayaki'];
            $db = new SQLite3('../db/basdat.db');
            $uname = $_SESSION['usernameEmail'];
            $removed = $_POST['qty']; 
            $iteminfo = getItem($id);
            if($removed > $iteminfo[0]['amount']){
                $db->close();
                echo '<span style="color:#C4161C;">Buy Amount Cannot Exceed Product Stock</span>';
            }
            else{
                date_default_timezone_set('Asia/Jakarta');
                $dt = date("Y-m-d h:i:sa");
                $price = $iteminfo[0]["price"] * $removed;
                $sql = "UPDATE dorayaki SET amount = amount - $removed WHERE id_dorayaki = $id";
                $res = $db->exec($sql);
                $sql2 = "INSERT INTO `transactions`(username,id_dorayaki,total_buy,total_price,trans_time)  VALUES (:uname,:idora,:remov,:prc,:dt);";
                $stmt = $db->prepare($sql2);
                $stmt->bindParam(":uname",$uname);
                $stmt->bindParam(":idora",$id);
                $stmt->bindParam(":remov",$removed);
                $stmt->bindParam(":prc",$price);
                $stmt->bindParam(":dt",$dt);
                $stmt->execute();
                $db->close();
                echo '<span style="color:#33b864;">Success. Product Bought</span>';
            }
        }
    }

    function submitChange(){ //deprecated
        if(isset($_POST['buyItem']) and isset($_POST['qty'])){
            $id = $_GET['id_dorayaki'];
            $db = new SQLite3('../db/basdat.db');
            $uname = $_SESSION['usernameEmail'];
            $added = $_POST['qty']; 
            $iteminfo = getItem($id);
            if($iteminfo[0]['amount'] + $added < 0){
                $db->close();
                echo '<span style="color:#C4161C;">Final Amount Cannot be Negative</span>';
            }
            else{
                date_default_timezone_set('Asia/Jakarta');
                $dt = date("Y-m-d h:i:sa");
                $price = 0;
                $sql = "UPDATE dorayaki SET amount = amount + $added WHERE id_dorayaki = $id";
                $res = $db->exec($sql);
                $sql2 = "INSERT INTO `transactions`(username,id_dorayaki,total_buy,total_price,trans_time)  VALUES (:uname,:idora,:remov,:prc,:dt);";
                $stmt = $db->prepare($sql2);
                $stmt->bindParam(":uname",$uname);
                $stmt->bindParam(":idora",$id);
                $stmt->bindParam(":remov",$added);
                $stmt->bindParam(":prc",$price);
                $stmt->bindParam(":dt",$dt);
                $stmt->execute();
                $db->close();
                echo '<span style="color:#33b864;">Success. Stock Updated</span>';
            }
        }
    }
    function submitImg($isNew){
        if (isset($_POST['AddVar'])) {
            $name = $_POST['addname'];
            $price = $_POST['addprice'];
            $initstock = $_POST['initstock'];
            $desc = $_POST['adddesc'];
            if (isset($_FILES['addimage'])) {
                $errors = array();
                $imgname = $_FILES['addimage']['name'];
                $imgtmp = $_FILES['addimage']['tmp_name'];
                $imgtype = $_FILES['addimage']['type'];
                $tmp = explode('.', $_FILES['addimage']['name']);
                $imgext = strtolower(end($tmp));
                $allowedext = array("png", "jpg", "jpeg");
                if (in_array($imgext, $allowedext) === false) {
                    $errors[] = "Failed";
                }

                if (empty($errors) == true) {
                    $db = new SQLite3('../db/basdat.db');
                    $query = "SELECT `nama` FROM `dorayaki` WHERE  `nama` ='". $name . "';";
                    $res = $db->query($query);
                    $rws = $res->fetchArray();
                    if($isNew){
                        if(!$rws){
                            $imgpath = "img/" . $imgname;
                            $sql = "INSERT INTO dorayaki(nama,price,amount,description,img_source) VALUES (:name,:price,:initstock,:desc,:imgname);"; 
                            $stmt = $db->prepare($sql);
                            $stmt->bindParam(":name",$name);
                            $stmt->bindParam(":price",$price);
                            $stmt->bindParam(":initstock",$initstock);
                            $stmt->bindParam(":desc",$desc);
                            $stmt->bindParam(":imgname",$imgpath);
                            $stmt->execute();
                            $stmt->close();
                            move_uploaded_file($imgtmp, "../img/" . $imgname);
                            echo '<span style="color:#33b864;">Success. Variant Added</span>';
                        }
                        else{
                            echo '<span style="color:#C4161C;">Failed. Duplicate Product Name.</span>';
                        }
                    }
                    else{
                        $curr_id = $_GET['id_dorayaki'];
                        $imgpath = "img/" . $imgname;
                        $sql = "UPDATE dorayaki SET nama = :name, price = :price, amount = :initstock, description = :desc,img_source = :imgname WHERE `id_dorayaki` = '". $curr_id ."';";
                        $stmt = $db->prepare($sql);
                        $stmt->bindParam(":name",$name);
                        $stmt->bindParam(":price",$price);
                        $stmt->bindParam(":initstock",$initstock);
                        $stmt->bindParam(":desc",$desc);
                        $stmt->bindParam(":imgname",$imgpath);
                        $stmt->execute();
                        $stmt->close();
                        move_uploaded_file($imgtmp, "../img/" . $imgname);
                        echo '<span style="color:#33b864;">Success. Variant Edited</span>';
                    }
                }
                
            }
        }
    }

    function submitChangeSOAP(){
        if(isset($_POST['buyItem']) and isset($_POST['qty'])){
            $id = $_GET['id_dorayaki'];
            $db = new SQLite3('../db/basdat.db');
            $uname = $_SESSION['usernameEmail'];
            $added = $_POST['qty']; 
            $iteminfo = getItem($id);
            if($iteminfo[0]['amount'] + $added < 0){
                $db->close();
                echo '<span style="color:#C4161C;">Final Amount Cannot be Negative</span>';
            }
            else{
                date_default_timezone_set('Asia/Jakarta');
                $dt = date("Y-m-d h:i:sa");
                try{
                    $client = new SoapClient("http://localhost:8080/DoraSupp/ws/req?wsdl");
                    $resp = $client->insertRequest($id,$added,"http://localhost:8000",$dt,"request");
                }
                catch(SoapFault $e){
                    echo $e->getMessage();
                }
                $sts = 'pending';
                $query = "INSERT INTO `request` (id_dorayaki,qty,status,trans_time) VALUES ('$id','$added','$sts','$dt')";
                $exc = $db->exec($query);
                // $price = 0;
                // $sql = "UPDATE dorayaki SET amount = amount + $added WHERE id_dorayaki = $id";
                // $res = $db->exec($sql);
                // $sql2 = "INSERT INTO `transactions`(username,id_dorayaki,total_buy,total_price,trans_time)  VALUES (:uname,:idora,:remov,:prc,:dt);";
                // $stmt = $db->prepare($sql2);
                // $stmt->bindParam(":uname",$uname);
                // $stmt->bindParam(":idora",$id);
                // $stmt->bindParam(":remov",$added);
                // $stmt->bindParam(":prc",$price);
                // $stmt->bindParam(":dt",$dt);
                // $stmt->execute();
                $db->close();
                echo '<span style="color:#33b864;">Request Sent.</span>';
            }
        }
    }

 ?>