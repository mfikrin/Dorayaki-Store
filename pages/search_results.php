<?php
    session_start();
    require '../util/loginAuth.php';
    
    define('MAX_DORAYAKI', 8); // max_dorayaki pada result
    
    if (isset($_GET['search']) && $_GET['search'] !== ""){
        $nama_dorayaki = htmlspecialchars(trim($_GET['search']));
        $db = new SQLite3('../db/basdat.db');
        $sql = "SELECT * FROM dorayaki WHERE nama LIKE '%$nama_dorayaki%'";
        
        $all_data = select_query($sql,$db);
        $count_data = count($all_data);
        $total_page = ceil($count_data/MAX_DORAYAKI);

        if (isset($_GET["page"])){
            $curr_page = $_GET["page"];
        }else{
            $curr_page = 1;
        }

        $first_data = (MAX_DORAYAKI * $curr_page) - MAX_DORAYAKI;

        $sql = "SELECT * FROM dorayaki WHERE nama LIKE '%$nama_dorayaki%' LIMIT " .$first_data. "," . MAX_DORAYAKI;
    
        $dorayaki_result = [];

        $results = $db->query($sql);
        while ($res = $results->fetchArray(1)){
            array_push($dorayaki_result,$res);
        }

        // print_r($dorayaki_result);

    }else{
        $no_keyword = '<div class = results_dorayaki>'. "<span style='color:#33b864;'>Please input keyword of dorayaki's name </span>" . $_GET['search'] . '</div>';
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dashboards.css">
    <script src=""></script>
    <title>Add Dorayaki Variant</title>
</head>

<body>
    <?php include('../util/header.php'); ?>
    <?php 
    $nama_dorayaki = "dorayaki";
    ?>
    <div class="pagination">
        <?php if($curr_page > 1) :?>
            <a href="?search=<?php $nama_dorayaki?>&page=<?php echo $curr_page -1;?>">&laquo;</a>
        <?php else:?>
            <a href=>&laquo;</a>
        <?php endif; ?>
        <?php for($i = 1;$i <= $total_page;$i++): ?>
            <?php if($i == $curr_page): ?>
                <a href="?search=<?php $nama_dorayaki?>&page=<?php echo $i?>" class ="active"><?php echo $i ?></a>
            <?php else :?>
                <a href="?search=<?php $nama_dorayaki?>&page=<?php echo $i?>"><?php echo $i ?></a>
            <?php endif; ?>
        <?php endfor; ?>
        <?php if($curr_page < $total_page) :?>
            <a href="?search=<?php $nama_dorayaki?>&page=<?php echo $curr_page + 1;?>">&raquo;</a>
        <?php else:?>
            <a href="?search=<?php $nama_dorayaki?>&page=<?php echo $total_page;?>">&raquo;</a>
        <?php endif; ?>
    </div>
    
    <div class = "container">

            <?php

            if (isset($no_keyword)){
                echo $no_keyword;
            }


            if (isset($dorayaki_result)) {
                $len = count($dorayaki_result);

                    if ($len == 0){

                        $html = '<div class = results_dorayaki>'. '<span style="color:#33b864;">No Dorayaki with name </span>' . $_GET['search'] . '</div>';
                        echo $html;
                        
                    }else{
                        foreach ($dorayaki_result as $dorayaki) : ?>
                            <div class="book-box">
                                <div class = "image-base">
                                    <?php
                                        $path_img = "../" . $dorayaki["img_source"];
                                    // var_dump($path_img);
                                    ?>
                                    <img src="<?php echo $path_img; ?>">
                                </div>
                            
                                <div class="body-title"><?php echo $dorayaki["nama"]; ?> </div>
            
                                <p class ="body-text">Harga Dorayaki : Rp<?php echo $dorayaki["price"]; ?> </p>
                                <p class ="body-text">Jumlah Dorayaki : <?php echo $dorayaki["amount"]; ?> </p>
                                <a href="details.php?id_dorayaki=<?php echo $dorayaki["id_dorayaki"]?>">Detail</a>
                            </div>
                            <?php endforeach;
                    }
                 
            }
            ?>
        </div>

</body>