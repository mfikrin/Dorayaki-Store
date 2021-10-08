<?php
session_start();

// Destroy all the sessions
$_SESSION = [];
session_unset();
session_destroy();

// Destroy all the cookies
setcookie('key','', time()-3600);
setcookie('userEmail','', time()-3600);

header("Location: login.php");
exit;