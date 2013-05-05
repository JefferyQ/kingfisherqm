<?php

session_start();

require_once('./inc/common.inc.php');

logged();

$tmplang = new Lang();

$page = new Page(1);

$page->content = '';

if(get_GET('form') === 'form1') {

    $fields = array_keys($_POST);

    foreach($fields as $row) {
		$value = get_POST($row);
		$tmp = explode('_', $row);
		$id = $tmp[2];

		$conn = new TSql('select');
		$conn->sqlquery = "update paperformats set page_price_percent=$value where id=$id";
	    $conn->exec();	

    }
    
}

$page->content .= '<div id="titlemain">'.$tmplang->lang['paperformats'].'</div><br /><br />';

$page->content .= '<span class="topictitle">'.$tmplang->lang['add_page_price'].':</span><br /><br />';

$page->content .= '<table><form action="tables_paperformats.php?form=form1" method="post">';

try {
	$dbh = new PDO(DSN, DBUSER, DBPASS);

    foreach($dbh->query('select id, paperformatname from paperformats order by paperformatname') as $row) {
	    $resq = $dbh->query('select page_price_percent from paperformats where id='.$row['id']);
	    $row2 = $resq->FetchAll();
	    $page->content .= '<tr><td><b>'.$row['paperformatname'].':</b></td><td><input type="text" name="paper_id_'.$row['id'].'" value="'.$row2[0]['page_price_percent'].'" size="3" /> % </td>';
    }

	$page->content .= '<tr><td></td><td><input type="submit" value="'.$tmplang->lang['send'].'" /></td></tr>';
	$page->content .= '</form></table>';

    $dbh = null;} catch (PDOException $e) {
	print "Error!: " . $e->getMessage() . '<br />';
    die();
}


echo $page->show();

?>

