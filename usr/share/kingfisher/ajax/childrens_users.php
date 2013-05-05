<?php

session_start();

require_once('../inc/common.inc.php');

logged();

$id = get_GET('id');
$type = get_GET('type');	


    header('Content-Type: text/xml');
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

	echo '<?xml version="1.0" encoding="UTF-8"?><users>';	

	$conn = new TSql('select');
	$conn->sqlquery = "select id, username from users where ".$type."_id=$id";
	foreach($conn->exec() as $row) {
		echo "\n".'<user><id>'.$row['id'].'</id><name>'.$row['username'].'</name></user>';
	}

    echo '</users>';

?>
