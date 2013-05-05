<?php

#
# Kingfisher Quota Manager
#
# (c) 2008 Geovanny Junio <geovanny@eutsiv.com.br>
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.
#

class Page {

    protected $title, $message, $menu, $foot, $tmplang;
    public $content;

    public function __construct($show_menu) {
		$this->title = ':: Eutsiv ::';
		$this->message = '';
		$this->menu = '';
		$this->content = '';
    	$this->foot = '<p>Powered by <a href="http://www.eutsiv.com.br">Eutsiv</a></p>';
		$this->tmplang = new Lang;

		if($show_menu) self::menu(); 

    }

	public function message($type, $message) {
		
		/*if($type === 'error') {
			$bgcolor = '#ff9a9a';
			$border = '#ff5656';
		}

		$this->message = '<div id="warning" style="position: absolute; top: 50%; left: 50%; margin-left: -150px; margin-top: -100px; padding: 20px; width: 300px; height: auto; background-color: '.$bgcolor.'; border: 1px solid '.$border.'; text-align: center; color: #363636;">'.$message.'<br /><br /><input type="button" value="&nbsp;&nbsp;Ok&nbsp;&nbsp;" Onclick="document.getElementById(\'warning\').style.display = \'none\';"></div>';*/

		$this->message = '<script type="text/javascript"> alert("'.$message.'") </script>';

	}

    public function menu() {

		$menu = new DDMenuOneLevel();
		#$menu->bgcolor = '#e01f26';
		#$menu->font_color = '#ffffff';
		#$menu->bghover = '#ff9a9a';
		$menu->width = '9em';
		$menu->width_child = '15em';

		$menu->addNode(001, $this->tmplang->lang['main'], '#');
		$menu->addNode(002, $this->tmplang->lang['tables'], '#');
		$menu->addNode(003, $this->tmplang->lang['reports'], '#');
		$menu->addNode(004, $this->tmplang->lang['graphics'], '#');
		$menu->addNode(005, $this->tmplang->lang['settings'], 'settings.php');
		$menu->addNode(006, $this->tmplang->lang['help'], 'about.php');
		$menu->addNode(007, $this->tmplang->lang['logout'], 'exit.php');

		$menu->addSubNode(001 , $this->tmplang->lang['print_queue'], 'main.php');
		$menu->addSubNode(001 , $this->tmplang->lang['last_jobs'], 'last_jobs.php');
		$menu->addSubNode(002 , $this->tmplang->lang['users'], 'tables_users.php');
		$menu->addSubNode(002 , $this->tmplang->lang['sectors'], 'tables_sectors.php');
		$menu->addSubNode(002 , $this->tmplang->lang['costscenter'], 'tables_costscenter.php');
		$menu->addSubNode(002 , $this->tmplang->lang['printers'], 'tables_printers.php');
		$menu->addSubNode(002 , $this->tmplang->lang['paperformats'], 'tables_paperformats.php');
		$menu->addSubNode(003 , $this->tmplang->lang['list_all_jobs'], 'reports_list_all_jobs.php');
		$menu->addSubNode(003 , $this->tmplang->lang['search_jobs'], 'reports_search_jobs.php');
		$menu->addSubNode(003 , $this->tmplang->lang['total_pages'], 'reports_total_pages.php');
		$menu->addSubNode(003 , $this->tmplang->lang['total_pages_grouped'], 'reports_total_pages_grouped.php');
		$menu->addSubNode(004 , $this->tmplang->lang['top_10_users'], 'graphics.php?type=users&title='.$this->tmplang->lang['top_10_users']);
		$menu->addSubNode(004 , $this->tmplang->lang['top_10_printers'], 'graphics.php?type=printers&title='.$this->tmplang->lang['top_10_printers']);
		$menu->addSubNode(004 , $this->tmplang->lang['top_10_paperformats'], 'graphics.php?type=paperformats&title='.$this->tmplang->lang['top_10_paperformats']);

		$this->menu = '<div id="menu">'.$menu->exec().'</div>';

    }

    public function show() {

		$cont = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-	strict.dtd">

			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<meta http-equiv="content-type" content="text/html; charset=utf-8" />
			<title>'.$this->title.'</title>
			<meta name="keywords" content="" />
			<meta name="description" content="" />
			<link href="./css/default.css" rel="stylesheet" type="text/css" />
			</head>
			<body>
				'.$this->message.'
			<div id="header">';

		if(isset($_SESSION['id_user'])) $cont .= '<p style="position: absolute; top: 5px; left: 5px; color: #214478; font-size: 9px;">'.$this->tmplang->lang['logged_as'].': <span style="font-size: 11px; font-weight: bold;">'.$_SESSION['name'].'</span></p>';

		$cont .= '
			<img src="./images/kingfisher.png" style="position: absolute; top: 15px; left: 195px;" />
				<span style="position: absolute; top: 25px; left: 240px; font-size: 14px; font-weight: bold; color: #214478;">KingFisher (Quota Manager)</span>

    	<a href="http://www.eutsiv.com.br" title="Eutsiv"><img style="position: absolute; top: 10px; right: 20px;" src="./images/eutsiv_logo.jpg" /></a>
			</div>

			'.$this->menu.'

			<div id="main">'.$this->content.'</div>

			<div id="footer"><p>'.$this->foot.'</p></div>

			</body>
			</html>';

	return $cont;

    }

}

?>
