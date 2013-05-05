<?php

session_start();

require_once('../inc/common.inc.php');

logged();

$id = get_GET('id');
$sector_id = get_GET('sector_id');	

$conn = new TSql('update');
$conn->sqlquery = "update users set sectors_id=$sector_id where users.id=$id";
$conn->exec();

?>
