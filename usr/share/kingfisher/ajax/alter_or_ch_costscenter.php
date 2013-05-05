<?php

session_start();

require_once('../inc/common.inc.php');

logged();

$id = get_GET('id');
$costcenter_id = get_GET('costcenter_id');	

$conn = new TSql('update');
$conn->sqlquery = "update users set costscenter_id=$costcenter_id where users.id=$id";
$conn->exec();

?>
