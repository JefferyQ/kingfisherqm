<?php

session_start();

require_once('./inc/common.inc.php');

logged();

$type = get_GET('type');
$title = get_GET('title');

$tmplang = new Lang();

$page = new Page(1);

$page->content = '<div id="titlemain">'.$title.'</div><br /><br />';

# Search Form
$page->content .= '<form action="graphics.php" method="get"><table id="search">
	<tr><td>&nbsp;</td><td>'.$tmplang->lang['year'].'</td><td>'.$tmplang->lang['month'].'</td><td>'.$tmplang->lang['day'].'</td><td>'.$tmplang->lang['time'].'</td></tr>
        <tr><td>'.$tmplang->lang['begin'].':</td><td>';
# BEGIN DATE
# Year
$page->content .= '<select name="byear">
	<option selected></option>';

$conn = new TSql('select');
$conn->sqlquery = "select distinct * from (select extract(year from job_date) as year from printlogs) as printlogs_years";
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

$page->content .= '</tr>
        <tr><td>'.$tmplang->lang['end'].':</td><td>';


# END DATE
# Year
$page->content .= '<select name="eyear">
	<option selected></option>';

$conn = new TSql('select');
$conn->sqlquery = "select distinct * from (select extract(year from job_date) as year from printlogs) as printlogs_years";
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

$page->content .= '</tr><tr><td>&nbsp</td><td><input type="hidden" name="type" value="'.$type.'" /><input type="hidden" name="title" value="'.$title.'" /><input type="submit" value="'.$tmplang->lang['search'].'" /></td></tr>
      </table></form>';

    $localtime = '';
    foreach(localtime() as $tmp) $localtime .= $tmp;

$page->content .= '<br /><br /><br /><br /><img style="display: block; margin-left: auto; margin-right: auto;" src="/cgi-bin/kingfisher/graphics_render.pl?'.$_SERVER['QUERY_STRING'].'&timestamp='.$localtime.'" />';

echo $page->show();

?>

