<?php

session_start();

require_once('./inc/common.inc.php');

logged();

$tmplang = new Lang();

$page = new Page(1);

$page->content = '<div id="titlemain">'.$tmplang->lang['search_jobs'].'</div><br /><br />';

# Search Form
$page->content .= '<form action="reports_search_jobs.php" method="get"><table id="search">
	<tr><td>&nbsp;</td><td>'.$tmplang->lang['year'].'</td><td>'.$tmplang->lang['month'].'</td><td>'.$tmplang->lang['day'].'</td><td>'.$tmplang->lang['time'].'</td><td>'.$tmplang->lang['user'].'</td><td>'.$tmplang->lang['printer'].'</td><td>'.$tmplang->lang['paperformat'].'</td></tr>
        <tr><td>'.$tmplang->lang['begin'].':</td><td>';

# BEGIN DATE
# Year
$page->content .= '<select name="byear">
	<option selected></option>';

$conn = new TSql('select');
$conn->sqlquery = 'select distinct * from (select extract(year from job_date) as year from printlogs) as printlogs_years';
foreach($conn->exec() as $row) {
	$page->content .= '<option value="'.$row['year'].'">'.$row['year'].'</option>';}

$page->content .= '</select></td><td>
      <select name="bmonth">
	<option></option>';

	for($i = 1; $i <= 12; $i++) $page->content .= '<option value="'.sprintf("%02d", $i).'">'.sprintf("%02d", $i).'</option>';

$page->content .= '</select></td><td>
      <select name="bday">
	<option></option>';

	for($i = 1; $i <= 31; $i++) $page->content .= '<option value="'.sprintf("%02d", $i).'">'.sprintf("%02d", $i).'</option>';

$page->content .= '</select></td><td>
      <select name="bhour">
	<option></option>';

	for($i = 0; $i <= 23; $i++) $page->content .= '<option value="'.sprintf("%02d", $i).'">'.sprintf("%02d", $i).'</option>';

$page->content .= '</select></td>';

# USER
$page->content .= '<td><select name="users"><option selected></option>';

$conn = new TSql('select');
$conn->sqlquery = "select id, username from users";
foreach($conn->exec() as $row) {
$page->content .= '<option value="'.$row['id'].'">'.$row['username'].'</option>';
}

$page->content .= '</select></td>';

# PRINTER
$page->content .= '<td><select name="printers"><option selected></option>';

$conn = new TSql('select');
$conn->sqlquery = "select id, printername from printers";
foreach($conn->exec() as $row) {
$page->content .= '<option value="'.$row['id'].'">'.$row['printername'].'</option>';
}

$page->content .= '</select></td>';

# TYPE OF PAPER
$page->content .= '<td><select name="paperformats"><option selected></option>';
 
$conn = new TSql('select');
$conn->sqlquery = "select id, paperformatname from paperformats";
foreach($conn->exec() as $row) {
$page->content .= '<option value="'.$row['id'].'">'.$row['paperformatname'].'</option>';
}

$page->content .= '</select></td>';

$page->content .= '</tr>
        <tr><td>'.$tmplang->lang['end'].':</td><td>';


# END DATE
# Year
$page->content .= '<select name="eyear">
	<option selected></option>';

$conn = new TSql('select');
$conn->sqlquery = 'select distinct * from (select extract(year from job_date) as year from printlogs) as printlogs_years';
foreach($conn->exec() as $row) {
$page->content .= '<option value="'.$row['year'].'">'.$row['year'].'</option>';
}

$page->content .= '</select></td><td>
      <select name="emonth">
	<option></option>';

	for($i = 1; $i <= 12; $i++) $page->content .= '<option value="'.sprintf("%02d", $i).'">'.sprintf("%02d", $i).'</option>';

$page->content .= '</select></td><td>
      <select name="eday">
	<option></option>';

	for($i = 1; $i <= 31; $i++) $page->content .= '<option value="'.sprintf("%02d", $i).'">'.sprintf("%02d", $i).'</option>';

$page->content .= '</select></td><td>
      <select name="ehour">
	<option></option>';

	for($i = 0; $i <= 23; $i++) $page->content .= '<option value="'.sprintf("%02d", $i).'">'.sprintf("%02d", $i).'</option>';

$page->content .= '</select></td>';

$page->content .= '</tr><tr><td>&nbsp</td><td><input type="hidden" name="commit" value="on" /><input type="submit" value="'.$tmplang->lang['search'].'" /></td></tr>
      </table></form>';

if(get_GET('commit') === 'on') {
    $byear = get_GET('byear');
    $bmonth = get_GET('bmonth');
    $bday = get_GET('bday');
    $bhour = get_GET('bhour');
    $user = get_GET('users');
    $printer = get_GET('printers');
    $paperformat = get_GET('paperformats');
    $eyear = get_GET('eyear');
    $emonth = get_GET('emonth');
    $eday = get_GET('eday');
    $ehour = get_GET('ehour');

    # User
    if(!empty($user)) $query = ' and users.id='.$user.' ';

    # Printer
    if(!empty($printer)) $query .= ' and printers.id='.$printer.' ';

    # Type of Paper
    if(!empty($paperformat)) $query .= ' and paperformats.id='.$paperformat.' ';

    # Formatting Date - Begin 
    if(!empty($byear)) {
	if(!empty($bmonth)) {
	    if(!empty($bday)) {
		$bdate = $byear.'-'.$bmonth.'-'.$bday;
		if(!empty($bhour)) {
		    $btime = $bhour.':00:00';
		}
		else {
		    $btime = '00:00:00';
		}
	    }
	    else {
		$bdate = $byear.'-'.$bmonth.'-01';
		$btime = '00:00:00';
	    }
  	}
	else {
	    $bdate = $byear.'-01-01';
	    $btime = '00:00:00';
	}
    }
    else {
	$bdate = '0001-01-01';
	$btime = '00:00:00';
    }

    # Formatting Date - End
    if(!empty($eyear)) {
	if(!empty($emonth)) {
	    if(!empty($eday)) {
		$edate = $eyear.'-'.$emonth.'-'.$eday;
		if(!empty($ehour)) {
		    $etime = $ehour.':59:59';
		}
		else {
		    $etime = '23:59:59';
		}
	    }
	    else {
		$edate = $eyear.'-'.$emonth.'-31';
		$etime = '23:59:59';
	    }
  	}
	else {
	    $edate = $eyear.'-12-31';
	    $etime = '23:59:59';
	}
    }
    else {
	$edate = date("Y-m-d");
	$etime = '23:59:59';
    }

    # Date
    $query .= " and job_date between '$bdate' and '$edate' ";

    # Time
    $query .= " and job_time between '$btime' and '$etime' ";

    $page->content .= '<br /><br />';


	$page->content .= '<div id="datadiv"><table id="datatable" cellspacing="0">';
	$page->content .= '<tr class="dtheader"><td>'.$tmplang->lang['date'].'</td><td>'.$tmplang->lang['time'].'</td><td>'.$tmplang->lang['user'].'</td><td>'.$tmplang->lang['title'].'</td><td>'.$tmplang->lang['printer'].'</td><td>'.$tmplang->lang['paperformat'].'</td><td>'.$tmplang->lang['job_size'].'</td><td>'.$tmplang->lang['copies'].'</td><td>'.$tmplang->lang['number_of_pages'].'</td><td>'.$tmplang->lang['total_pages'].'</td></tr>';

	$conn = new TSql('select');
	$conn->sqlquery = 'SELECT count(job_date) as num from printlogs, users, printers, paperformats where printlogs.users_id=users.id and printlogs.printers_id=printers.id and printlogs.paperformats_id=paperformats.id '.$query;
	foreach($conn->exec() as $row);

	if($row['num'] > 0) {
		$conn = new TSql('select');
		$conn->sqlquery = 'SELECT job_date, job_time, username, users.id as users_id, title, printername, printers.id as printers_id, paperformatname, paperformats.id as paperformats_id, job_size, copies, number_of_pages, total_pages from printlogs, users, printers, paperformats where printlogs.users_id=users.id and printlogs.printers_id=printers.id and printlogs.paperformats_id=paperformats.id '.$query.' order by job_date desc, job_time desc '.get_limit();
		foreach($conn->exec() as $row) {

			$date = explode('-', $row['job_date']);

			$page->content .= '<tr class="dtbody" OnMouseOver="className=\'dthighlight\'" OnMouseOut="className=\'dtbody\'"><td><a href="reports_search_jobs.php?byear='.$date[0].'&bmonth='.$date[1].'&bday='.$date[2].'&eyear='.$date[0].'&emonth='.$date[1].'&eday='.$date[2].'&commit=on">'.$row['job_date'].'</a></td><td>'.$row['job_time'].'</td><td><a href="reports_search_jobs.php?users='.$row['users_id'].'&commit=on">'.$row['username'].'</a></td><td>'.utf8_decode($row['title']).'</td><td><a href="reports_search_jobs.php?printers='.$row['printers_id'].'&commit=on">'.$row['printername'].'</a></td><td><a href="reports_search_jobs.php?paperformats='.$row['paperformats_id'].'&commit=on">'.$row['paperformatname'].'</a></td><td>'.$row['job_size'].'</td><td>'.$row['copies'].'</td><td>'.$row['number_of_pages'].'</td><td>'.$row['total_pages'].'</td></tr>';

		}
	}

	$page->content .= '</table></div>';

    $page->content .= make_link_page('SELECT count(job_date) as rowcount from printlogs, users, printers, paperformats where printlogs.users_id=users.id and printlogs.printers_id=printers.id and printlogs.paperformats_id=paperformats.id '.$query);

}

echo $page->show();

?>

