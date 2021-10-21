<?php
session_start();
require '../util/loginAuth.php';
if(!$_SESSION['is_admin']){
    header("Location: dashboard.php");
}
include('../util/hist_util.php');
include('../util/item_util.php');

?>
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
    <link rel="stylesheet" href="../css/history.css">
    <script src=""></script>
    <title>Product Transactions History</title>
</head>

<body>
    <?php include('../util/header.php'); ?>
    <?php if($found){?>
    <div class="container">
        <div class="histitle">
            <h2><?php echo $item_info[0]["nama"] ?> History</h2>
        </div>
            <?php prodTable($dora_id);?>
    </div>
    <?php }
        else{
            echo '<h3 style="font-size:x-large">Page not Found</h3>';
        }
        ?>
</body>