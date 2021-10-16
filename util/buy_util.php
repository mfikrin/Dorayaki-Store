<?php
    function getItem($itemid)
    {
        $db = new SQLite3('../db/basdat.db');
        $sql = "SELECT t.id_dorayaki,sum(total_buy) as total_buy,nama,d.price, description,amount,img_source FROM transactions t inner join dorayaki d ON t.id_dorayaki = d.id_dorayaki WHERE t.id_dorayaki =$itemid group by t.id_dorayaki order by total_buy desc";
        $dorayakis = [];
        $results = $db->query($sql);
        while ($res = $results->fetchArray(1)) {
            array_push($dorayakis, $res);
        }
        $db->close();
        return $dorayakis;
    }

    function buttonAdder($id)
    {
        if ($_SESSION['is_admin']) {
            echo '<a href="edit_amount.php?id_dorayaki='. $id . '"><button class="prod-edit" onclick="" style="cursor:pointer">Change Amount</button></a>';
            echo '<a href="edit_variant.php?id_dorayaki='. $id . '"><button class="prod-edit" onclick="" style="cursor:pointer">Edit Variant</button></a>';
            echo '<a href="details.php?id_dorayaki='. $id . '"><button class="prod-delete" onclick="" style="cursor:pointer">Delete Variant</button></a>';
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

    function buyProduct($id){
        if (isset($_POST['buyProd'])) {
            $db = new SQLite3('../db/basdat.db');
            $sql = "UPDATE dorayaki SET amount = amount-1 WHERE id_dorayaki=$id";
            $ret = $db->exec($sql);
            $db->close();
        }
    }

 ?>