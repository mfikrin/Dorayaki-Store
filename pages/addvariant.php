<?php
session_start();
require '../util/loginAuth.php';
?>

<?php include('../util/item_util.php')?>
<!-- Validation Soon -->
<!-- Dorayaki Variant Adder -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/addvariant.css">
    <script src=""></script>
    <title>Add Dorayaki Variant</title>
</head>

<body>
    <?php include('../util/header.php'); ?>
    <div class="container">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="adderform">
                <h2>Add Dorayaki Variant</h2>
                <label>Name</label>
                <input class="textinput" placeholder="Enter Product Name" name="addname" autocomplete="off" required>
                <label>Price</label>
                <input class="textinput" type="number" min="0" style="-moz-appearance:textfield;" placeholder="Enter Product Price" name="addprice" autocomplete="off" required>
                <label>Initial Amount</label>
                <input class="textinput" type="number" min="0" style="-moz-appearance:textfield;" placeholder="Enter Product Amount" name="initstock" autocomplete="off" required>
                <label>Description</label>
                <textarea class="textinput" rows="5" cols="30" placeholder="Enter Product Description" name="adddesc" autocomplete="off" style="resize:none;overflow:hidden" required></textarea>
                <label>Image</label>
                <input class="imginput" type="file" name="addimage" required>
                <?php checkExt() ?>
                <button class="butmit" name="AddVar" type="submit">Submit</button>
                <?php submitImg(true) ?>
            </div>
        </form>
    </div>

</body>