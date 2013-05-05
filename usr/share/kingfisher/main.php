<?php

session_start();

require_once('./inc/common.inc.php');

logged();

$tmplang = new Lang();

$page = new Page(1);

$page->content = '<div id="titlemain">'.$tmplang->lang['print_queue'].'</div><br /><br />';

$page->content .= '<div id="datadiv"><table id="datatable" cellspacing="0">';
$page->content .= '<tr class="dtheader"><td>'.$tmplang->lang['date'].'</td><td>'.$tmplang->lang['time'].'</td><td>'.$tmplang->lang['user'].'</td><td>'.$tmplang->lang['title'].'</td><td>'.$tmplang->lang['printer'].'</td><td>'.$tmplang->lang['status'].'</td><td>'.$tmplang->lang['job_size'].'</td><td>'.$tmplang->lang['copies'].'</td><td>'.$tmplang->lang['number_of_pages'].'</td><td>'.$tmplang->lang['total_pages'].'</td></tr>';

$conn = new TSql('select');
$conn->sqlquery = "SELECT count(job_date) as num from printqueue";
foreach($conn->exec() as $row);

if($row['num'] > 0) {
	$conn = new TSql('select');
	$conn->sqlquery = "SELECT job_date, job_time, username, title, printername, job_status, job_size, copies, number_of_pages, total_pages from printqueue order by job_date desc, job_time desc limit 20";
	foreach($conn->exec() as $row) {
		$date = explode('-', $row['job_date']);			

		$page->content .= '<tr class="dtbody" OnMouseOver="className=\'dthighlight\'" OnMouseOut="className=\'dtbody\'"><td>'.$row['job_date'].'</td><td>'.$row['job_time'].'</td><td>'.$row['username'].'</td><td>'.$row['title'].'</td><td>'.$row['printername'].'</td><td>'.$row['job_status'].'</td><td>'.$row['job_size'].'</td><td>'.$row['copies'].'</td><td>'.$row['number_of_pages'].'</td><td>'.$row['total_pages'].'</td></tr>';

	}

}
 
$page->content .= '</table></div>';

echo $page->show();

?>

