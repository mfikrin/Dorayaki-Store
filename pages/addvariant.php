<!-- Validation Soon -->
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

function submitImg()
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
                if(!$rws){
                    $sql = "INSERT INTO dorayaki(nama,price,amount,description,img_source) VALUES (:name,:price,:initstock,:desc,:imgname);"; 
                    $stmt = $db->prepare($sql);
                    $stmt->bindParam(":name",$name);
                    $stmt->bindParam(":price",$price);
                    $stmt->bindParam(":initstock",$initstock);
                    $stmt->bindParam(":desc",$desc);
                    $stmt->bindParam(":imgname",$imgname);
                    $stmt->execute();
                    move_uploaded_file($imgtmp, "../img/" . $imgname);
                    echo '<span style="color:#33b864;">Success. Variant Added</span>';
                }
                else{
                    echo '<span style="color:#C4161C;">Failed. Duplicate Product Name.</span>';
                }
            }
            
        }
    }
}
?>
<!-- Dorayaki Variant Adder -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/addvariant.css">
    <script src=""></script>
    <title>Add Dorayaki Variant</title>
</head>

<body>
    <?php include('../util/header.php'); ?>
    <div class="container">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="adderform">
                <h2>Add Dorayaki Variant</h2>
                <label>Name</label>
                <input class="textinput" placeholder="Enter Product Name" name="addname" autocomplete="off" required>
                <label>Price</label>
                <input class="textinput" type="number" style="-moz-appearance:textfield;" placeholder="Enter Product Price" name="addprice" autocomplete="off" required>
                <label>Initial Amount</label>
                <input class="textinput" type="number" style="-moz-appearance:textfield;" placeholder="Enter Product Amount" name="initstock" autocomplete="off" required>
                <label>Description</label>
                <textarea class="textinput" rows="5" cols="30" placeholder="Enter Product Description" name="adddesc" autocomplete="off" style="resize:none;overflow:hidden" required></textarea>
                <label>Image</label>
                <input class="imginput" type="file" name="addimage" required>
                <?php checkExt() ?>
                <button class="butmit" name="AddVar" type="submit">Submit</button>
                <?php submitImg() ?>
            </div>
        </form>
    </div>

</body>