<?php

session_start();

require_once('./inc/common.inc.php');

logged();

$tmplang = new Lang();

$page = new Page(1);

$page->content = '';

if(get_GET('form') === 'form1') {

    $sectors_id = get_POST('sector');
    $costscenter_id = get_POST('costcenter');
    $id = get_GET('id');

    $conn = new TSql('update');
	$conn->sqlquery = "update users set sectors_id=$sectors_id , costscenter_id=$costscenter_id where id=".$id;
	$conn->exec();

}
elseif(get_GET('form') === 'form2') {

    $sectors_id = get_POST('sector');
    $id = get_GET('id');

    $conn = new TSql('update');
	$conn->sqlquery = "update printlogs set sectors_id=$sectors_id where users_id=$id and sectors_id=1";
	$conn->exec();

}
elseif(get_GET('form') === 'form3') {

    $costscenter_id = get_POST('costcenter');
    $id = get_GET('id');

    $conn = new TSql('update');
	$conn->sqlquery = "update printlogs set costscenter_id=$costscenter_id where users_id=$id and costscenter_id=1";
	$conn->exec();

}


$username = get_GET('username');
$id = get_GET('id');


# list of users - leftmenu
$page->content .= '<div id="leftmenu"><ul>';

$conn = new TSql('select');
$conn->sqlquery = 'select id, username from users order by username';
foreach($conn->exec() as $row) {
	$page->content .= '<li><a href="tables_users.php?id='.$row['id'].'&username='.$row['username'].'">'.$row['username'].'</a></li>';
}

$page->content .= '</ul></div>';

$page->content .= '<div id="rightspace" style="float: left; padding-left: 30px; padding-bottom: 30px; width: 79%;"><div id="titlemain">'.$tmplang->lang['user'].': '.$username.'</div><br /><br />';

if(!empty($id)) {

	# Sector and CostCenter of user
	$page->content .= '<span class="topictitle">'.$tmplang->lang['user_settings'].':</span><br /><br />';

	$page->content .= '<form action="tables_users.php?form=form1&id='.$id.'&username='.$username.'" method="post" ><table id="search">
		<tr><td>'.$tmplang->lang['sector'].': </td><td><select name="sector">';

	$conn = new TSql('select');
	$conn->sqlquery = 'select sectors_id from users where id='.$id;
	foreach($conn->exec() as $row);

	$temp = $row['sectors_id'];

	$conn = new TSql('select');
	$conn->sqlquery = 'select id, sectorname from sectors order by sectorname';
	foreach($conn->exec() as $row) {
		$page->content .= '<option value="'.$row['id'].'" ';

		if($temp == $row['id']) $page->content .= 'selected';

		$page->content .= '>'.$row['sectorname'].'</option>';

	}

	$page->content .= '</select></td></tr>
		<tr><td>'.$tmplang->lang['costcenter'].': </td><td><select name="costcenter" >';

	$conn = new TSql('select');
	$conn->sqlquery = 'select costscenter_id from users where id='.$id;
	foreach($conn->exec() as $row);

	$temp = $row['costscenter_id'];

	$conn = new TSql('select');
	$conn->sqlquery = 'select id, costcentername from costscenter order by costcentername';
	foreach($conn->exec() as $row) {
		$page->content .= '<option value="'.$row['id'].'"';

		if($temp == $row['id']) $page->content .= 'selected';

		$page->content .= ' >'.$row['costcentername'].'</option>';

	}

	$page->content .= '</select></td></tr>
		<tr><td>&nbsp;</td><td><input type="submit" value="'.$tmplang->lang['send'].'" /></td></tr>
		 </table></form><br /><br />';

	# Jobs in default Sector
	$conn = new TSql('select');
	$conn->sqlquery = 'select count(job_date) as nprints from printlogs, users where printlogs.users_id=users.id and printlogs.sectors_id=1 and users.id='.$id;	
	foreach($conn->exec() as $row);

	if($row['nprints'] > 0) {

		$tsector = '<select name="sector">';

		$conn = new TSql('select');
		$conn->sqlquery = 'select id, sectorname from sectors order by sectorname';
		foreach($conn->exec() as $row) {
			$tsector .= '<option value="'.$row['id'].'" ';

			if($row['id'] == 1) $tsector .= 'selected';

		    $tsector .= '>'.$row['sectorname'].'</option>';

		}

		$tsector .= '</select>';


		$page->content .= '<span class="topictitle">'.$tmplang->lang['jobs_in_default_sector'].':</span><br /><br />';
		$page->content .= '<div id="datadiv"><table id="datatable" cellspacing="0"><form action="tables_users.php?form=form2&id='.$id.'&username='.$username.'" method="post">';
		$page->content .= '<tr class="dtheader"><td>'.$tmplang->lang['user'].'</td><td>'.$tmplang->lang['total_pages'].'</td><td>'.$tmplang->lang['total_price'].'</td><td>'.$tmplang->lang['alter_to_sector'].'</td><td>&nbsp;</td></tr>';

		$conn = new TSql('select');
		$conn->sqlquery = 'select username, sum(total_pages) as total_pages, sum(price) as total_price from printlogs, users where printlogs.users_id=users.id and printlogs.sectors_id=1 and users.id='.$id.' group by username';
		foreach($conn->exec() as $row) {
			$page->content .= '<tr class="dtbody" OnMouseOver="className=\'dthighlight\'" OnMouseOut="className=\'dtbody\'" ><td>'.$row['username'].'</td><td>'.$row['total_pages'].'</td><td>'.price_format($row['total_price']).'</td><td>'.$tsector.'</td><td><input type="submit" value="'.$tmplang->lang['send'].'" /></td></tr>';
		}

		$page->content .= '</form></table></div><br /><br />';

	}

	# Jobs in default CostCenter
	$conn = new TSql('select');
	$conn->sqlquery = 'select count(job_date) as nprints from printlogs, users where printlogs.users_id=users.id and printlogs.costscenter_id=1 and users.id='.$id;	
	foreach($conn->exec() as $row);

	if($row['nprints'] > 0) {

		$tcostcenter = '<select name="costcenter">';

		$conn = new TSql('select');
		$conn->sqlquery = 'select id, costcentername from costscenter order by costcentername';
		foreach($conn->exec() as $row) {

			$tcostcenter .= '<option value="'.$row['id'].'" ';

			if($row['id'] == 1) $tcostcenter .= 'selected';

		    $tcostcenter .= '>'.$row['costcentername'].'</option>';

		}

		$tcostcenter .= '</select>';


		$page->content .= '<span class="topictitle">'.$tmplang->lang['jobs_in_default_costcenter'].':</span><br /><br />';
		$page->content .= '<div id="datadiv"><table id="datatable" cellspacing="0"><form action="tables_users.php?form=form3&id='.$id.'&username='.$username.'" method="post">';
		$page->content .= '<tr class="dtheader"><td>'.$tmplang->lang['user'].'</td><td>'.$tmplang->lang['total_pages'].'</td><td>'.$tmplang->lang['total_price'].'</td><td>'.$tmplang->lang['alter_to_costcenter'].'</td><td>&nbsp;</td></tr>';

		$conn = new TSql('select');
		$conn->sqlquery = 'select username, sum(total_pages) as total_pages, sum(price) as total_price from printlogs, users where printlogs.users_id=users.id and printlogs.costscenter_id=1 and users.id='.$id.' group by username';
		foreach($conn->exec() as $row) {
			$page->content .= '<tr class="dtbody" OnMouseOver="className=\'dthighlight\'" OnMouseOut="className=\'dtbody\'" ><td>'.$row['username'].'</td><td>'.$row['total_pages'].'</td><td>'.price_format($row['total_price']).'</td><td>'.$tcostcenter.'</td><td><input type="submit" value="'.$tmplang->lang['send'].'" /></td></tr>';
		}

		$page->content .= '</form></table></div>';

	}

}

$page->content .= '</div>';

echo $page->show();

?>
