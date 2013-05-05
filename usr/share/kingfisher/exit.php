<?php

// Geovanny Junio - 12/10/2007
//
//

session_start();

require_once('inc/common.inc.php');

unset($_SESSION['id_user']);
unset($_SESSION['login']);
unset($_SESSION['name']);

header("Location: ".URL."/login.php");

?>
