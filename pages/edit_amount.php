<?php
session_start();
require '../util/loginAuth.php';
?>

<?php include('../util/item_util.php');?>
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

<!-- Buy Product (user), Modify Stock (admin) -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/details.css">
    <script src="../util/item_util.js"></script>
    <title>Buy / Edit Dorayaki Amount</title>
</head>
<body>
    <?php include('../util/header.php'); ?>
    <?php if($found){?>
    <div class="details">
        <div class="img-frame">
            <img src="../<?php echo $item_info[0]["img_source"];?>" alt="" class="prod-img">
        </div>
        <div class="text">
            <?php if(!$_SESSION['is_admin']){?>
                <h3 style="font-size:x-large"><?php echo $item_info[0]["nama"];?></h3>
                <h3 style="font-size:large;color: #C4161C ">Rp<?php echo number_format($item_info[0]["price"]);?></h3>
                <p>Amount Remaining : </p>
                <p id="harga">Total Price : <span id="puraisu" style="color: #C4161C ">Rp0</span></p>
                <?php buttonBuy();?>
            <?php }else{?>
                <h3 style="font-size:x-large"><?php echo $item_info[0]["nama"];?></h3>
                <h3 style="font-size:large;color: #C4161C ">Rp<?php echo number_format($item_info[0]["price"]);?></h3>
                <p>Amount Remaining : </p>
                <p>Add Stock (Negative Value to Reduce) : </p>
                <?php buttonBuy();}?>
        </div>
    </div>
    <?php }
        else{
            echo '<h3 style="font-size:x-large">Page not Found</h3>';
        }
        ?>
</body>

<script>
    var id = "<?php echo $dora_id;?>";
    var initPrice = "<?php echo $item_info[0]["price"];?>";
    setInterval(function(){generateAmountRem(id);},1000);
    buttonListeners(initPrice);
</script>

