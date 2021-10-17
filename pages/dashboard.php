<?php
session_start();
require '../util/loginAuth.php';

$_SESSION["username"] = "Fikri";
// require '../db/init_sample.php';
$db = new SQLite3('../db/basdat.db');

$sql = "SELECT d.id_dorayaki,sum(total_buy) as total_buy, nama, d.price, description,amount,img_source from dorayaki d left outer join transactions t ON t.id_dorayaki = d.id_dorayaki group by d.id_dorayaki order by total_buy desc";
$dorayakis = [];
$results = $db->query($sql);

while ($res = $results->fetchArray(1)){
    array_push($dorayakis,$res);
}


// var_dump($dorayakis);
// print_r($dorayakis);

$db->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dashboards.css">
    <script src=""></script>
    <title>Stand With Dorayaki</title>
</head>

<body>
    <?php include('../util/header.php'); ?>
    <div class = "container">
            <?php foreach ($dorayakis as $dorayaki) : ?>
            <div class="book-box">
                <div class = "image-base">
                    <?php 
                        $path_img = "../" . $dorayaki["img_source"];
                        // var_dump($path_img);
                    ?>
                    <img src="<?php echo $path_img;?>">
                </div>
            
                <div class="body-title"><?php echo $dorayaki["nama"];?> </div>

                <p class ="body-text">Harga Dorayaki : Rp<?php echo $dorayaki["price"];?> </p>
                <p class ="body-text">Jumlah Dorayaki : <?php echo $dorayaki["amount"];?> </p>
                <a href="details.php?id_dorayaki=<?php echo $dorayaki["id_dorayaki"]?>">Detail</a>
            </div>
            <?php endforeach; ?>
        </div>


</body>

<script>

</script>

</html>