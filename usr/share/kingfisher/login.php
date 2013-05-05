<?php

session_start();

require_once('./inc/common.inc.php');

# Language object
$tmplang = new Lang;

# if not set URL to redirect, set to main.php
if(isset($_GET['url'])) {
	$url = get_GET('url');
}
else {
	$url = 'main.php';
}

# if logged
if(isset($_SESSION['id_user'])) header("Location: ".URL.$url." ");

# get values
$login = get_POST('login');
$password = get_POST('password');


# if commit
if(get_GET('commit') === 'on') {
	# if empty fields
	if(empty($login) || empty($password)) {
		echo '<script language="javascript">
			alert(\'Os campos login e senha precisam ser preenchidos!\');
			location.href=\'login.php\';
		</script>';
	}
	# try authentic
	else {
		
		$password = sha1($password);

		$conn = new TSql('select');
		$conn->sqlquery = "SELECT count(login) as num from users_webadm WHERE login='$login' AND password='$password'";
		foreach($conn->exec() as $row);

		# user not found
	    if($row['num'] == 0) {
			echo '<script language="javascript">alert(\'Login ou senha invalidos!\'); location.href=\'login.php\';</script>';
		}
		else {
			
			$conn = new TSql('select');
			$conn->sqlquery = "SELECT id, login, name, email from users_webadm WHERE login='$login' AND password='$password'";
			foreach($conn->exec() as $row);

			if($row['active'] == 'N') {
				echo '<script language="javascript">alert(\'Usuario temporariamente desativado!\'); location.href=\'login.php\';</script>';

			} 
			else {
			    $_SESSION['id_user'] = $row['id'];
			    $_SESSION['login'] = $row['login'];
			    $_SESSION['name'] = $row['name'];
				$_SESSION['email'] = $row['email'];
			}

			echo '<script language="javascript">location.href=\''.URL.'/'.$url.'\';</script>';
		}
	}
}


$page = new Page(0);

$page->content = '
		
		<script type="text/javascript" src="./js/jquery.js"></script>
		<script type="text/javascript">

			$(document).ready(function() {
				$("input#login").focus();
			});

		</script>


	<br /><br /><br /><br />
		<form name="form1" action="login.php?commit=on&url='.$url.'" method="post" >
			<table style="padding: 8px; background-color: #214478; color: #ffffff; text-align: center; margin-left: auto; margin-right: auto;">		
				<tr><td>'.$tmplang->lang['login'].':</td><td><input type="text" id="login" name="login" size="20" /></td></tr>
				<tr><td>'.$tmplang->lang['password'].':</td><td><input type="password" name="password" size="20" /></td></tr>
				<tr><td colspan="2"><input type="submit" value="'.$tmplang->lang['send'].'" /></td></tr>
			</table>
		</form><br /><br /><br /><br /><br /><br /><br />';

echo $page->show();

?>
