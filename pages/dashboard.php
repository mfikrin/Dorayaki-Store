<?php
session_start();
require '../util/loginAuth.php';

// require '../db/init_sample.php';
$db = new SQLite3('../db/basdat.db');

define('MAX_DORAYAKI', 8); // max_dorayaki pada dashboard




// $sql = "SELECT d.id_dorayaki,sum(total_buy) as total_buy, nama, d.price, description,amount,img_source from dorayaki d left outer join transactions t ON t.id_dorayaki = d.id_dorayaki group by d.id_dorayaki order by total_buy desc LIMIT " . MAX_DORAYAKI;
$sql = "SELECT d.id_dorayaki,sum(total_buy) as total_buy, nama, d.price, description,amount,img_source from dorayaki d left outer join transactions t ON t.id_dorayaki = d.id_dorayaki group by d.id_dorayaki order by total_buy desc";

$all_data = select_query($sql,$db);
// print_r($all_data);
$count_data = count($all_data);
$total_page = ceil($count_data/MAX_DORAYAKI);

if (isset($_GET["page"])){
    $curr_page = $_GET["page"];
}else{
    $curr_page = 1;
}

$first_data = (MAX_DORAYAKI * $curr_page) - MAX_DORAYAKI;

$sql = "SELECT d.id_dorayaki,sum(total_buy) as total_buy, nama, d.price, description,amount,img_source from dorayaki d left outer join transactions t ON t.id_dorayaki = d.id_dorayaki group by d.id_dorayaki order by total_buy desc LIMIT " .$first_data. "," . MAX_DORAYAKI;

$dorayakis = [];
$results = $db->query($sql);

while ($res = $results->fetchArray(1)){
    array_push($dorayakis,$res);
}


// var_dump($count_data);
// var_dump($total_page);

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
    <div class="pagination">
        <?php if($curr_page > 1) :?>
            <a href="?page=<?php echo $curr_page -1;?>">&laquo;</a>
        <?php else:?>
            <a href=>&laquo;</a>
        <?php endif; ?>
        <?php for($i = 1;$i <= $total_page;$i++): ?>
            <?php if($i == $curr_page): ?>
                <a href="?page=<?php echo $i?>" class ="active"><?php echo $i ?></a>
            <?php else :?>
                <a href="?page=<?php echo $i?>"><?php echo $i ?></a>
            <?php endif; ?>
        <?php endfor; ?>
        <?php if($curr_page < $total_page) :?>
            <a href="?page=<?php echo $curr_page + 1;?>">&raquo;</a>
        <?php else:?>
            <a href="?page=<?php echo $total_page;?>">&raquo;</a>
        <?php endif; ?>
    </div>

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