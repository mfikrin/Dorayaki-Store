<?php
session_start();

// Destroy all the sessions
$_SESSION = [];
session_unset();
session_destroy();

// removing if there's active token
$tokenID = $_COOKIE['key'];
$db = new PDO('sqlite:../db/basdat.db');
$sql = "DELETE FROM token WHERE token_id = '$tokenID'";
$queryResult = $db->exec($sql);

// Destroy all the cookies
setcookie('key','', time()-3600, '/');
setcookie('usernameEmail','', time()-3600, '/');

header("Location: login.php");
exit;