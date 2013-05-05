<?php

require_once('config.inc.php');

# Load Class
function __autoload($class) {
    require_once(DIR."/class/$class.class.php");
}

# Define Language
$conn = new TSql('select');
$conn->sqlquery = 'select language from settings';
foreach($conn->exec() as $row);
require_once(DIR.'/lang/'.$row['language'].'.inc.php');
unset($conn);
unset($row);

# Return GET variables
function get_GET($fieldname) {

	if(isset($_GET[$fieldname])) {
		$value = trim($_GET[$fieldname]);
		if(!get_magic_quotes_gpc()) $value = addslashes($value);
		return $value;
	}
	else {
		return false;
	}

}


# Return POST variables
function get_POST($fieldname) {

	if(isset($_POST[$fieldname])) {
		$value = trim($_POST[$fieldname]);
		if(!get_magic_quotes_gpc()) $value = addslashes($value);
		return $value;
	}
	else {
		return false;
	}

}

# check if logged
function logged() {
	if(!isset($_SESSION['id_user'])) {
	
		$tmp = $_SERVER['PHP_SELF'];
		$tmp = explode('/', $tmp);

		header("Location: ".URL."/login.php?url=".$tmp[(count($tmp) - 1)]);
	}
}


# return a array with allowed modules - module.id_mod, module.name, module.page
function get_modules($id_user) {

	$conn = new TSql('select');
	$conn->sqlquery = "SELECT modules.id as module, modules.page as page, modules.name as name from users_modules, modules WHERE users_modules.id_user='$id_user' AND users_modules.id_mod=modules.id";
	
	$modules = array();
	$i = 0;	
	foreach($conn->exec() as $row) {
		$modules[$i] = $row;
		$i++;
	}

	return $modules;

}


# check if can access a module and display a message
function can_access($id_mod) {
	$i = 0;
	foreach(get_modules($_SESSION['id_user']) as $modules ) {
		if($modules['module'] === $id_mod) $i = 1;
	}
	if($i == 0) {
		echo '<script language="javascript">
			alert(\'Voce nao possui permissao para acessar esta pagina.\');
			history.go(-1);
		</script>';
	}
}


# check if can access a module
function check_can_access($id_mod) {
	$i = 0;
	foreach(get_modules($_SESSION['id_user']) as $modules ) {
		if($modules['module'] === $id_mod) $i = 1;
	}
	if($i == 0) {
		return 0;
	}
	
	return 1;
}


# define limit value for SQL
function get_limit() {
	if(get_GET('page')) {
		$page = get_GET('page');
		if($page == 1) return 'limit 20 offset 0';
		$page--;
		$page *= 20;
		return "limit 20 offset $page";
	}
	else {
		return 'limit 20 offset 0';
	}
}


# make links for pagination
function make_link_page($sql) {

	$conn = new TSql('select');
	$conn->sqlquery = $sql;
	foreach($conn->exec() as $row);
	
	$totpages = ($row['rowcount']/20);
	if($row['rowcount']%20 > 0) $totpages++;
	$page = get_GET('page');

	$query = $_SERVER['QUERY_STRING'];

        if(!empty($page)) $query = substr($query, 6 + strlen($page), strlen($query));

	$cont = '<br /><center>';
	for($i=1;$i<=$totpages;$i++) {
		if($i == $page) {
			$link = "<b>$i</b>&nbsp;&nbsp;";
		}
		else {
			$link = "<a href=\"".$_SERVER['php_self']."?page=$i&".$query."\">$i</a>&nbsp;&nbsp;";
		}

		if($i < 4) {
			$cont .= $link;
		}
		elseif($i == ($page - 1)) {
			$cont .= $link;
			}
			elseif($i == $page) {
				$cont .= $link;
				}
				elseif($i == ($page + 1)) {
					$cont .= $link;
					}
					elseif($i > ($totpages - 3)) {
						$cont .= $link;
					}


	}

	return $cont.'</center>';

}


# Return value with n zeros on left
function left_digits($value, $ndigits) {
    
    $tmp = strlen($value);

    for($i = 0; $i < ($ndigits - $tmp); $i++) {
	$value = '0'.$value;
    }

    return $value;

}


# Show price in format with 4 number after cents
function price_format($price) {

    $fraction = explode('.', $price);
    $cents = substr($fraction[0], (strlen($fraction[0])-2), strlen($fraction[0]));
    $number = substr($fraction[0], 0, (strlen($fraction[0])-2));
    if(strlen($cents) == 1) {
	return number_format($number.'.0'.$cents, 2, ',', '.').'.'.$fraction[1];
    }
    else {
        return number_format($number.'.'.$cents, 2, ',', '.').'.'.$fraction[1];
    }

}

?>
