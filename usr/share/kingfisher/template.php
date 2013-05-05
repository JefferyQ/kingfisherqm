<?php

session_start();

require_once('./inc/common.inc.php');

logged();

$tmplang = new Lang();

$page = new Page(1);

$page->content = '';

echo $page->show();

?>

