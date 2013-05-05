<?php

session_start();

require_once('../inc/common.inc.php');

logged();

$type = get_GET('type');
$sectorname = strtolower(get_GET('sectorname'));
$costcentername = strtolower(get_GET('costcentername'));

if($type === 'sector') {

	# Insert Sector
	$conn = new TSql('insert');
	$conn->sqlquery = "insert into sectors(sectorname) values('$sectorname')";
	$conn->exec();


	# and CostCenter
	$conn = new TSql('insert');
	$conn->sqlquery = "insert into costscenter(costcentername) values('$sectorname')";
	$conn->exec();

	echo 'Sector '.$sectorname.' added with success.';

}
elseif($type === 'costcenter') {

	# Insert CostCenter
	$conn = new TSql('insert');
	$conn->sqlquery = "insert into costscenter(costcentername) values('$costcentername')";
	$conn->exec();

	echo 'CostCenter '.$costcentername.' added with success.';

}

?>
