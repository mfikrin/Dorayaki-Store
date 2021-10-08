<?php
session_start();
require '../util/functions.php';

// Check if cookie exists
if (isset($_COOKIE['usernameEmail']) && isset($_COOKIE['key'])){
    $key = $_COOKIE['key'];
    $userEmail = $_COOKIE['usernameEmail'];
    $isCookieValid = isEmailUsernameExistEncrypt($userEmail, $key);
    if ($isCookieValid>=1){
        // if useremail dan key in cookie is verified, make a session
        $_SESSION['login']= true;
        // Make session for admin, if the associated username is an admin
        if ($isCookieValid==2){
            $_SESSION['isAdmin'] = true;
        }
    }
}

// Check if session exists
if(!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}


$_SESSION["username"] = "Fikri";
// require '../db/init_sample.php';
$db = new SQLite3('../db/basdat.db');

$sql = "SELECT t.id_dorayaki,sum(total_buy) as total_buy, nama, d.price, description,amount,img_source from transactions t inner join dorayaki d ON t.id_dorayaki = d.id_dorayaki group by t.id_dorayaki order by total_buy desc";
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