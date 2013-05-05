<?php

session_start();

require_once('./inc/common.inc.php');

logged();

$tmplang = new Lang();

$page = new Page(1);

$page->content = '';

$sectorname = get_GET('sectorname');
$id = get_GET('id');

if(empty($sectorname)) $sectorname = 'default';
if(empty($id)) $id = 1;


# list of sectors - leftmenu
$page->content .= '<div id="leftmenu"><ul>';

$conn = new TSql('select');
$conn->sqlquery = 'select id, sectorname from sectors order by sectorname';
foreach($conn->exec() as $row) {
	$page->content .= '<li><a href="tables_sectors.php?id='.$row['id'].'&sectorname='.$row['sectorname'].'">'.$row['sectorname'].'</a></li>';
}

$page->content .= '</ul></div>';

$page->content .= '<div id="rightspace" style="float: left; padding-left: 30px; padding-bottom: 30px; width: 79%;"><div id="titlemain">'.$tmplang->lang['sector'].': '.$sectorname.'</div><br /><br />';


$page->content .= '

<script type="text/javascript" src="./js/jquery.js" ></script>
<script type="text/javascript" src="./js/sectors_orphans_childrens.js" ></script>

<script language="javascript">

		function add_sector() {

			var x = document.getElementById(\'aux\');

		    x.innerHTML = \'<div style="padding: 10px; font-weight: bold; color: #214478; border: 1px solid #214478;">'.$tmplang->lang['new_sector_name'].':<br /><form OnSubmit="return send_sector(this.sectorname.value);"><input type="text" name="sectorname" id="sectorname" ><br /><br /><input type="submit" value="'.$tmplang->lang['send'].'" /></form></div>\';

			$("input#sectorname").focus();

		}

		function send_sector(sectorname) {

			$.ajax({
	
				type: "GET",
				url: "./ajax/add_sectors_costscenter.php",
				dataType: "html",
				data: "sectorname=" + sectorname + "&type=sector",
				success: function(html) {
					alert(html);
					window.location.reload();
				}
			});

			return false;

		}

		function delete_sector(id) {

			$.ajax({
	
				type: "GET",
				url: "./ajax/delete_sectors_costscenter.php",
				dataType: "html",
				data: "id=" + id + "&type=sector",
				success: function(html) {
					alert(html);
					window.location = "tables_sectors.php";
				}
			});

		}

</script>';



$page->content .= '<table id="menulocal"><tr>';
$page->content .= '<td><a href="#" OnClick="add_sector();">'.$tmplang->lang['add_new_sector'].'</a></td>';
if($id != 1) $page->content .= '<td><a href="#" OnClick="delete_sector('.$id.')">'.$tmplang->lang['delete_this_sector'].'</a></td>';
$page->content .= '</tr></table>';

$page->content .= '<br /><div id="aux"></div><br /><br />';


if($id != 1) {
    $page->content .= '<script src="./js/orphans_childrens.js"></script>';

    $page->content .= '<input type="hidden" id="sector" name="sector" value="'.$id.'">';

    $page->content .= '<div class="groups" id="orphans"><span style="font-weight: bold; color: #214478;">'.$tmplang->lang['sector'].': default</span><div class="groups_data" id="orphans_data"></div></div>
	  <div class="groups" id="childrens"><span style="font-weight: bold; color: #214478;">'.$tmplang->lang['sector'].': '.$sectorname.'</span><div class="groups_data" id="childrens_data"></div></div>';

    $page->content .= '<script language="javascript"> get_orphans_sectors(); get_childrens_sectors(); </script>';

}

$page->content .= '</div>';

echo $page->show();

?>

