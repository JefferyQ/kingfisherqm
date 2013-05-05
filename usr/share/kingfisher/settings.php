<?php

session_start();

require_once('./inc/common.inc.php');

logged();

$tmplang = new Lang();

$page = new Page(1);

$page->content = '';

if(get_GET('form') === 'form1') {

    $price_gray = get_POST('price_gray');
    $price_color = get_POST('price_color');

    if(!preg_match('/\d{1,6}\.\d{4}/', $price_gray)) { 
		$page->message('error','Invalid Format of price gray');
    }
    elseif(!preg_match('/\d{1,6}\.\d{4}/', $price_color)) {
		$page->message('error', 'Invalid Format of price color!');
    }
    else {
		$conn = new TSql('update');
		$conn->sqlquery = "update settings set price_gray=$price_gray , price_color=$price_color";
		$conn->exec();
    }
}
elseif(get_GET('form') === 'form2') {

    $language = get_POST('language');

    $conn = new TSql('update');
	$conn->sqlquery = "update settings set language='$language'";
	$conn->exec();

}


$page->content .= '<div id="titlemain">'.$tmplang->lang['settings'].'</div><br /><br />';

$page->content .= '<script language="javascript">
    function mascara(o,f){
    	v_obj=o
    	v_fun=f
    	setTimeout("execmascara()",1)
    }

    function execmascara(){
    	v_obj.value=v_fun(v_obj.value)
    }

    function numbersanddot(v) {

	v=v.replace(/[^\d.]/g, \'\');	

	return v;

    }


</script>';

$conn =  new TSql('select');
$conn->sqlquery = "select price_gray, price_color, language from settings";
foreach($conn->exec() as $row);

$page->content .= '<span class="topictitle">'.$tmplang->lang['page_price'].':</span><br /><br />';
$page->content .= '<form action="settings.php?form=form1" method="post" ><table id="search">
	<tr><td>'.$tmplang->lang['price_gray'].': </td><td><input type="text" value="'.$row['price_gray'].'" name="price_gray" OnKeyPress="mascara(this, numbersanddot);" size="9" /><i> (99.9999)</i></td></tr>
	<tr><td>'.$tmplang->lang['price_color'].': </td><td><input type="text" value="'.$row['price_color'].'" name="price_color" OnKeyPress="mascara(this, numbersanddot);" size="9" /><i> (99.9999)</i></td></tr>
	<tr><td>&nbsp;</td><td><input type="submit" value="'.$tmplang->lang['send'].'" /></td></tr>
     </table></form>';

$page->content .= '<br /><br /><br /><span class="topictitle">'.$tmplang->lang['language'].':<br /><br /><form action="settings.php?form=form2" method="post" ><select name="language"><option value="en_US" ';

if($row['language'] == 'en_US') $page->content .= 'selected'; 
$page->content .= '>English (US)</option><option value="pt_BR"';

if($row['language'] == 'pt_BR') $page->content .= 'selected';
$page->content .= '>Português (BR)</option></select>&nbsp;<input type="submit" value="'.$tmplang->lang['send'].'" /></form></span><br /><br />';

echo $page->show();

?>

