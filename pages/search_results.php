<?php
    session_start();
    require '../util/loginAuth.php';
    
    define('MAX_DORAYAKI', 10); // max_dorayaki pada result
    
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
        $no_keyword = '<div class = results_dorayaki>'. "<span style='color:#33b864;'>Please input keyword of dorayaki's name </span> </div>";
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

    <?php if (isset($no_keyword)):?>
        <div class="container">
            <?php echo $no_keyword; ?>
        </div>
    <?php endif;?>

    <?php if (isset($dorayaki_result) && count($dorayaki_result) > 0):?>
        <div class="pagination">
            <?php 
                define('total_number',3);
                // $tot_pagination = ceil($total_page/MAX_PAGE);
                // $k = 1;

                $total_pagination = ceil($total_page / total_number); // banyak pagination klw ada 5 page berarti 5/3 = 2
                $idx = ceil($curr_page/3); # 1 misal di 5/3 =idx nya jd 2
                $start_number = total_number*$idx - 2; # rumus = 3k-2 klw idx = 2 berarti 3*2 - 2 = 4 (kan jd page 4 5 6) => 4 5
                
                $end_number = $start_number + total_number - 1;
                if ($idx == $total_pagination) {
                    if($total_page < $end_number){
                        $end_number = $total_page;
                    }
                }
            ?>

            <a href = "?search=<?php echo $nama_dorayaki?>&page=1">
                First
            </a>

            <?php 
                if($curr_page > 1) :?>
                    <a href="?search=<?php echo $nama_dorayaki?>&page=<?php echo $curr_page -1;?>">&laquo;</a>
                <?php else:?>
                    <a href="#">&laquo;</a>
            <?php endif; ?>
            


            <?php for($i = $start_number;$i <= $end_number;$i++): ?>
                <?php if($i == $curr_page): ?>
                    <a href="?search=<?php echo $nama_dorayaki?>&page=<?php echo $i?>" class ="active"><?php echo $i ?></a>
                <?php else :?>
                    <a href="?search=<?php echo $nama_dorayaki?>&page=<?php echo $i?>"><?php echo $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if($curr_page < $total_page) :?>
                <a href="?search=<?php echo $nama_dorayaki?>&page=<?php echo $curr_page + 1;?>">&raquo;</a>
                <?php else:?>
                <a href="?search=<?php echo $nama_dorayaki?>&page=<?php echo $total_page;?>">&raquo;</a>
            <?php endif; ?>

            <a href = "?search=<?php echo $nama_dorayaki?>&page=<?php echo $total_page;?>">
                Last
            </a>        
    </div>
    <?php endif;?>
 
    
    
    <div class = "container">

            <?php


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
                                    <a href="details.php?id_dorayaki=<?php echo $dorayaki["id_dorayaki"]?>">
                                        <img src="<?php echo $path_img;?>">
                                    </a>
                                </div>
                            
                                <a href="details.php?id_dorayaki=<?php echo $dorayaki["id_dorayaki"]?>" class="dorayaki-name">
                                    <div class="body-title"><?php echo ucwords($dorayaki["nama"]);?> </div>
                                </a>
                
                                <p class ="body-text" style="font-weight: bold;color:#C4161C">Rp<?php echo number_format($dorayaki["price"]);?> </p>
                                <p class ="body-text">Stock : <?php echo $dorayaki["amount"];?> </p>
                                <a class ="button" href="details.php?id_dorayaki=<?php echo $dorayaki["id_dorayaki"]?>">Detail</a>
                            </div>
                            <?php endforeach;

                        }
                 
                    }
            ?>
    </div>

</body>