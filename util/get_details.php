<?php
    include("../util/buy_util.php");
    $id = $_REQUEST['id_dorayaki'];
    $items = getItem($id);
    echo json_encode($items,JSON_INVALID_UTF8_IGNORE);
?>