<?php
session_start();
require '../util/loginAuth.php';
include('../util/hist_util.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/history.css">
    <script src=""></script>
    <title>Pending Requests</title>
</head>

<body>
    <?php include('../util/header.php'); ?>
    <div class="container">
        <div class="histitle">
            <h2>Pending Requests</h2>
        </div>
            <?php reqTable();?>
    </div>
