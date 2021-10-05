<?php
    $_SESSION["username"] = "Fikri";
    $_SESSION['is_admin'] = 1;

?>
<?php
    function checkAdmin(){
        if ($_SESSION['is_admin']) {
            echo '<li><a href="">Add Dorayaki</a></li>';
        } else if (!$_SESSION['is_admin']) {
            echo '<li><a href="">Purchase History</a></li>';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/header.css">
    <script src=""></script>
    <title>Stand With Dorayaki</title>
</head>

<body>
    <header>
            <h1>Stand<span style="color:rgb(55, 141, 180)">With</span>Dorayaki</h1>
            <div class ="topbar"> 
                <ul>
                <li><div class="search-bar">
                    <form name="searchbar" action="" method="get">
                        <input class="sbar" type="text" name="search" placeholder="Search Dorayaki" value="" onUnfocus="send()">
                    </form>
                </div></li>  
                    <li><a href="dashboard.php">Home</a></li>
                    <?php checkAdmin() ?>
                    <li><div class = "nama"><?php echo $_SESSION["username"] ?><a href=""> | Logout</a></div></li>
                </ul>

            </div>
    </header>
    
</body>


</html>
