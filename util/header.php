<?php
    $_SESSION["username"] = "Fikri";
    $_SESSION['is_admin'] = 1;

?>
<?php
    function checkAdmin(){
        if ($_SESSION['is_admin']) {
            echo '<li><a href="/pages/addvariant.php" class="barlink">Add Dorayaki</a></li>';
        } else if (!$_SESSION['is_admin']) {
            echo '<li><a href="" class="barlink">Purchase History</a></li>';
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
</head>

<body>
    <header>
            <h1><a href="/pages/dashboard.php" class = "webname">Stand<span style="color:#C4161C">With</span>Dorayaki</a></h1>
            <div class ="topbar"> 
                <ul>
                <li><div class="search-bar">
                    <form name="searchbar" action="" method="get">
                        <input class="sbar" type="text" name="search" placeholder="Search Dorayaki" value="" onUnfocus="">
                    </form>
                </div></li>  
                    <li><a href="/pages/dashboard.php" class="barlink">Home</a></li>
                    <?php checkAdmin() ?>
                    <li><div class = "nama"><?php echo $_SESSION["username"] ?><a href="" class="barlink"> | Logout</a></div></li>
                </ul>

            </div>
    </header>
    
</body>


</html>
