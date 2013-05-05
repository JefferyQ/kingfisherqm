<?php

session_start();

require_once('./inc/common.inc.php');

logged();

$tmplang = new Lang();

$page = new Page(1);

$page->content = '<div id="titlemain">'.$tmplang->lang['about'].'</div><br /><br />
    <img src="./images/kingfisher_big.png" align="left" />';

echo $page->show();

?>

