<?php

session_start();

require_once('./inc/common.inc.php');

logged();

$tmplang = new Lang();

$page = new Page(1);

$page->content = '<div id="titlemain">'.$tmplang->lang['printers'].'</div><br /><br />';

$page->content .= '<span class="topictitle">'.$tmplang->lang['settings'].':</span><br /><br />';

	
$page->content .= '<table><tr><td>&nbsp;</td><td><b>'.$tmplang->lang['queue_paused'].'</b></td></tr>';

$conn = new TSql('select');
$conn->sqlquery = 'select printername from printers order by printername';
foreach($conn->exec() as $row) {
	$page->content .= '<tr><td><b>'.$row['printername'].':</b></td><td><input type="checkbox" /></td>';
}

$page->content .= '<tr><td></td><td><input type="submit" value="'.$tmplang->lang['send'].'" /></td></tr>';
$page->content .= '</table>';


echo $page->show();

?>

