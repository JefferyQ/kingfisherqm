<?php

session_start();

require_once('../inc/common.inc.php');

logged();

$type = get_GET('type');
$id = strtolower(get_GET('id'));

if($type === 'sector') {

	# Insert Sector
	$conn = new TSql('delete');
	$conn->sqlquery = 'delete from sectors where id='.$id;
	$conn->exec();

	echo 'Sector deleted with success.';

}
elseif($type === 'costcenter') {

	# Insert CostCenter
	$conn = new TSql('delete');
	$conn->sqlquery = 'delete from costscenter where id='.$id;
	$conn->exec();

	echo 'CostCenter deleted with success.';

}

?>
