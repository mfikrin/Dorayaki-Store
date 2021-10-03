<?php
    $_SESSION["username"] = "Fikri";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dashboard.css">
    <script src=""></script>
    <title>Stand With Dorayaki</title>
</head>

<body>
    <header>
            <h1>MO<span style="color:rgb(55, 141, 180)">BI</span>TAA</h1>  <!-- mobita bisa diganti nanti -->
            <nav>
                <ul>
                    <li><a href="dashboard.html">Home</a></li>
                    <li><a href="">Purchase List</a></li>
                    <li><a href="">Logout</a></li>
                    <li><div class = "nama"><?php echo $_SESSION["username"] ?></div></li>
                </ul>
            </nav>
    </header>
    
</body>

<script>

</script>

</html>