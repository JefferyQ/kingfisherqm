<?php

session_start();

require_once('./inc/common.inc.php');

logged();

$tmplang = new Lang();

$page = new Page(1);

$page->content = '';


$costcentername = get_GET('costcentername');
$id = get_GET('id');

if(empty($costcentername)) $costcentername = 'default';
if(empty($id)) $id = 1;


$page->content .= '

<script type="text/javascript" src="./js/jquery.js" ></script>
<script type="text/javascript" src="./js/costscenter_orphans_childrens.js" ></script>

<script language="javascript">

    function add_costcenter() {

		var x = document.getElementById(\'aux\');

        x.innerHTML = \'<div style="padding: 10px; font-weight: bold; color: #214478; border: 1px solid #214478;">'.$tmplang->lang['new_costcenter_name'].':<br /><form OnSubmit="return send_costcenter(this.costcentername.value);"><input type="text" name="costcentername"><br /><br /><input type="submit" value="'.$tmplang->lang['send'].'" /></form></div>\';

		$("input#costcentername").focus();

    }

    function send_costcenter(costcentername) {

			$.ajax({
	
				type: "GET",
				url: "./ajax/add_sectors_costscenter.php",
				dataType: "html",
				data: "costcentername=" + costcentername + "&type=costcenter",
				success: function(html) {
					alert(html);
					window.location.reload();
				}
			});

			return false;

    }


		function delete_costcenter(id) {

			$.ajax({
	
				type: "GET",
				url: "./ajax/delete_sectors_costscenter.php",
				dataType: "html",
				data: "id=" + id + "&type=costcenter",
				success: function(html) {
					alert(html);
					window.location = "tables_costscenter.php";
				}
			});

		}

</script>';


# list of costscenter - leftmenu
$page->content .= '<div id="leftmenu"><ul>';

$conn = new TSql('select');
$conn->sqlquery = 'select id, costcentername from costscenter order by costcentername';
foreach($conn->exec() as $row) {
	$page->content .= '<li><a href="tables_costscenter.php?id='.$row['id'].'&costcentername='.$row['costcentername'].'">'.$row['costcentername'].'</a></li>';
}

$page->content .= '</ul></div>';

$page->content .= '<div id="rightspace" style="float: left; padding-left: 30px; padding-bottom: 30px; width: 79%;"><div id="titlemain">'.$tmplang->lang['costcenter'].': '.$costcentername.'</div><br /><br />';


$page->content .= '<table id="menulocal"><tr>';
$page->content .= '<td><a href="#" OnClick="add_costcenter();">'.$tmplang->lang['add_new_costcenter'].'</a></td>';
if($id != 1) $page->content .= '<td><a href="#" OnClick="delete_costcenter('.$id.');">'.$tmplang->lang['delete_this_costcenter'].'</a></td>';
$page->content .= '</tr></table>';

$page->content .= '<br /><div id="aux"></div><br /><br />';


if($id != 1) {
    $page->content .= '<script src="./js/orphans_childrens.js"></script>';

    $page->content .= '<input type="hidden" id="costcenter" name="costcenter" value="'.$id.'">';

    $page->content .= '<div class="groups" id="orphans"><span style="font-weight: bold; color: #214478;">'.$tmplang->lang['costcenter'].': default</span><div class="groups_data" id="orphans_data"></div></div>
	  <div class="groups" id="childrens"><span style="font-weight: bold; color: #214478;">'.$tmplang->lang['costcenter'].': '.$costcentername.'</span><div class="groups_data" id="childrens_data"></div></div>';

    $page->content .= '<script language="javascript"> get_orphans_costscenter(); get_childrens_costscenter(); </script>';
}

$page->content .= '</div>';


echo $page->show();

?>

