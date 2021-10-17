<?php
if(!$_SESSION['is_admin']){
    header("Location: dashboard.php");
}
 
include('../util/item_util.php');?>
<!-- Validation Soon -->
<!-- Dorayaki Variant Deleter -->
<?php
    if (isset($_GET['id_dorayaki'])) {
        $dora_id = htmlspecialchars(trim($_GET['id_dorayaki']));
        if(filter_var($dora_id, FILTER_VALIDATE_INT) or $dora_id == 0){
            $item_info = getItem($dora_id);
            if(!empty($item_info)){
                $found = true;
            }
            else{
                $found = false;
            }
        }
        else{
            $found = false;
        }
    } else {
        $found = false;
    }
    if($found){
        $db = new SQLite3('../db/basdat.db');
        $sql = "DELETE FROM dorayaki WHERE id_dorayaki = $dora_id;";
        $db->exec($sql);
        $db->close();
    }
    header("Location: ../index.php");
?>