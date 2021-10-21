<?php
session_start();
require '../util/loginAuth.php';
if(!$_SESSION['is_admin']){
    header("Location: dashboard.php");
}
include('../util/item_util.php')?>
<!-- Validation Soon -->
<!-- Dorayaki Variant Adder -->
<?php
    if (isset($_GET['id_dorayaki'])) {
        $dora_id = htmlspecialchars(trim($_GET['id_dorayaki']));
        if(filter_var($dora_id, FILTER_VALIDATE_INT) or $dora_id == 0){
            $item_info = getItem($dora_id);
            if(!empty($item_info)){
                $found = true;
            }
            else{
                $found = false;
            }
        }
        else{
            $found = false;
        }
    } else {
        $found = false;
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/addvariant.css">
    <script src=""></script>
    <title>Edit Dorayaki Variant</title>
</head>

<body>
    <?php include('../util/header.php'); ?>
    <?php if($found){?>
    <div class="container">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="adderform">
                <h2>Edit Dorayaki Variant</h2>
                <label>Name</label>
                <input class="textinput" value="<?php echo $item_info[0]["nama"];?>" name="addname" required>
                <label>Price</label>
                <input class="textinput" type="number" min="0" style="-moz-appearance:textfield;" value="<?php echo $item_info[0]["price"];?>" name="addprice" required>
                <label>Initial Amount</label>
                <input class="textinput" type="number" min="0" style="-moz-appearance:textfield;" value="<?php echo $item_info[0]["amount"];?>" name="initstock" required>
                <label>Description</label>
                <textarea class="textinput" rows="5" cols="30" placeholder="<?php echo $item_info[0]["description"];?>" name="adddesc" style="resize:none;overflow:hidden" required></textarea>
                <label>Image</label>
                <input class="imginput" type="file" name="addimage" required>
                <?php checkExt() ?>
                <div class ="inFlex">
                    <a href="../pages/details.php?id_dorayaki=<?php echo $dora_id;?>"><button class="butmit" type="button" id="canBut">Cancel</button></a>
                    <button class="butmit" name="AddVar" id="edVar" type="submit">Submit</button>
                </div>
                <?php submitImg(false) ?>
            </div>
        </form>
    </div>
    <?php }
        else{
            echo '<h3 style="font-size:x-large">Page not Found</h3>';
        }
    ?>

</body>