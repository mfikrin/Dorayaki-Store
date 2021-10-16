<?php
function checkExt()
{
    if (isset($_FILES['addimage'])) {
        $tmp = explode('.', $_FILES['addimage']['name']);
        $imgext = strtolower(end($tmp));
        $allowedext = array("png", "jpg", "jpeg");
        if (in_array($imgext, $allowedext) === false) {
            echo '<span style="color:#C4161C;">Failed. Allowed Extensions : png, jpg, jpeg</span>';
        }
    }
}

function submitImg($isNew)
{
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
                    move_uploaded_file($imgtmp, "../img/" . $imgname);
                    echo '<span style="color:#33b864;">Success. Variant Edited</span>';
                }
            }
            
        }
    }
}
?>