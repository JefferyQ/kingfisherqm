<?php

session_start();

require_once('./inc/common.inc.php');

logged();

$tmplang = new Lang();

$page = new Page(1);

$page->content = '<div id="titlemain">'.$tmplang->lang['total_pages'].'</div><br /><br />';

# Search Form
$page->content .= '<form action="reports_total_pages.php" method="get"><table id="search">
	<tr><td>&nbsp;</td><td>'.$tmplang->lang['year'].'</td><td>'.$tmplang->lang['month'].'</td><td>'.$tmplang->lang['day'].'</td><td>'.$tmplang->lang['time'].'</td><td>'.$tmplang->lang['user'].'</td><td>'.$tmplang->lang['sector'].'</td><td>'.$tmplang->lang['costcenter'].'</td><td>'.$tmplang->lang['printer'].'</td><td>'.$tmplang->lang['paperformat'].'</td></tr>
        <tr><td>'.$tmplang->lang['begin'].':</td><td>';


# BEGIN DATE
# Year
$page->content .= '<select name="byear">
	<option selected></option>';

$conn = new TSql('select');
$conn->sqlquery = 'select distinct * from (select extract(year from job_date) as year from printlogs) as printlogs_years';
foreach($conn->exec() as $row) {
$page->content .= '<option value="'.$row['year'].'">'.$row['year'].'</option>';
}

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


$page->content .= '<td><input type="radio" name="type" value="users" checked /></td><td><input type="radio" name="type" value="sectors" /></td><td><input type="radio" name="type" value="costscenter" /></td><td><input type="radio" name="type" value="printers" /></td><td><input type="radio" name="type" value="paperformats" /></td>';

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
    $type = get_GET('type');
    $eyear = get_GET('eyear');
    $emonth = get_GET('emonth');
    $eday = get_GET('eday');
    $ehour = get_GET('ehour');

    if($type == 'users') {
    	$field = 'username';
        $tdtitle = 'user';
    }
    elseif($type == 'sectors') {
    	$field = 'sectorname';
	$tdtitle = 'sector';
    }
    elseif($type == 'costscenter') {
    	$field = 'costcentername';
	$tdtitle = 'costcenter';
    }
    elseif($type == 'printers') {
    	$field = 'printername';
	$tdtitle = 'printer';
    }
    elseif($type == 'paperformats') {
    	$field = 'paperformatname';
	$tdtitle = 'paperformat';
    }

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


    $page->content .= '<br /><br />';


	$page->content .= '<div id="datadiv"><table id="datatable" cellspacing="0">';
	$page->content .= '<tr class="dtheader"><td>'.$tmplang->lang[$tdtitle].'</td><td>'.$tmplang->lang['total_pages'].'</td><td>'.$tmplang->lang['total_price'].'</td></tr>';

	$conn = new TSql('select');
	$conn->sqlquery = "SELECT $field, sum(total_pages) as total_pages, sum(price) as total_price from printlogs, $type where printlogs.".$type."_id=$type.id and job_date between '$bdate' and '$edate' and job_time between '$btime' and '$etime' group by $field  ".get_limit();
	foreach($conn->exec() as $row) {
	    $page->content .= '<tr class="dtbody" OnMouseOver="className=\'dthighlight\'" OnMouseOut="className=\'dtbody\'"><td>'.$row[$field].'</td><td>'.$row['total_pages'].'</td><td>'.price_format($row['total_price']).'</td></tr>';
	}

	$page->content .= '</table></div>';

    $page->content .= make_link_page("SELECT count(result.*) as rowcount from ( SELECT $field, sum(total_pages) as total_pages, sum(price) as total_price from printlogs, $type where printlogs.".$type."_id=$type.id and job_date between '$bdate' and '$edate' and job_time between '$btime' and '$etime' group by $field ) as result");

}

echo $page->show();

?>

