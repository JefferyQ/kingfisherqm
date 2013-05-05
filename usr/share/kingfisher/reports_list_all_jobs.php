<?php

session_start();

require_once('./inc/common.inc.php');

logged();

$tmplang = new Lang();

$page = new Page(1);

$page->content = '<div id="titlemain">'.$tmplang->lang['list_all_jobs'].'</div><br /><br />';

$page->content .= '<div id="datadiv"><table id="datatable" cellspacing="0">';
$page->content .= '<tr class="dtheader"><td>'.$tmplang->lang['date'].'</td><td>'.$tmplang->lang['time'].'</td><td>'.$tmplang->lang['user'].'</td><td>'.$tmplang->lang['title'].'</td><td>'.$tmplang->lang['printer'].'</td><td>'.$tmplang->lang['paperformat'].'</td><td>'.$tmplang->lang['job_size'].'</td><td>'.$tmplang->lang['copies'].'</td><td>'.$tmplang->lang['number_of_pages'].'</td><td>'.$tmplang->lang['total_pages'].'</td></tr>';

$conn = new TSql('select');
$conn->sqlquery = 'SELECT job_date, job_time, username, users.id as users_id, title, printername, printers.id as printers_id, paperformatname, paperformats.id as paperformats_id, job_size, copies, number_of_pages, total_pages from printlogs, users, printers, paperformats where printlogs.users_id=users.id and printlogs.printers_id=printers.id and printlogs.paperformats_id=paperformats.id order by job_date desc, job_time desc '.get_limit();
foreach($conn->exec() as $row) {

	$date = explode('-', $row['job_date']);

	$page->content .= '<tr class="dtbody" OnMouseOver="className=\'dthighlight\'" OnMouseOut="className=\'dtbody\'"><td><a href="reports_search_jobs.php?byear='.$date[0].'&bmonth='.$date[1].'&bday='.$date[2].'&eyear='.$date[0].'&emonth='.$date[1].'&eday='.$date[2].'&commit=on">'.$row['job_date'].'</a></td><td>'.$row['job_time'].'</td><td><a href="reports_search_jobs.php?users='.$row['users_id'].'&commit=on">'.$row['username'].'</a></td><td>'.utf8_decode($row['title']).'</td><td><a href="reports_search_jobs.php?printers='.$row['printers_id'].'&commit=on">'.$row['printername'].'</a></td><td><a href="reports_search_jobs.php?paperformats='.$row['paperformats_id'].'&commit=on">'.$row['paperformatname'].'</a></td><td>'.$row['job_size'].'</td><td>'.$row['copies'].'</td><td>'.$row['number_of_pages'].'</td><td>'.$row['total_pages'].'</td></tr>';

}

$page->content .= '</table></div>';


$page->content .= make_link_page('SELECT count(job_date) as rowcount from printlogs, users, printers, paperformats where printlogs.users_id=users.id and printlogs.printers_id=printers.id and printlogs.paperformats_id=paperformats.id');

echo $page->show();

?>

