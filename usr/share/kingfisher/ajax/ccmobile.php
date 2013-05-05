<?php

require_once('../inc/common.inc.php');

try {
    $dbh = new PDO('pgsql:host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASS);

    header('Content-Type: text/xml');
    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

    echo '<?xml version="1.0" encoding="UTF-8"?><costscenter>';

    foreach($dbh->query("select id, costcentername from costscenter order by costcentername") as $row) {
	echo '<name>'.$row['costcentername'].'</name><id>'.$row['id']."</id>\n";
    }

    echo '</costscenter>';

    $dbh = null;

} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

?>

