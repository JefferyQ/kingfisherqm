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

class DDMenuOneLevel {

    public $bgcolor, $bghover, $width, $width_child, $font_color;
    protected $content, $menu;

    public function __construct() {
		$this->bgcolor = '#214478';
		$this->bghover = '#3366ff';
		$this->width = '10em';
		$this->width_child = '10em';
		$this->font_color = '#ffffff';
    }

    public function addNode($node, $name, $link) {
		$this->menu[$node] = array($name, $link, array());
    }

    public function addSubNode($node, $name, $link) {
		array_push($this->menu[$node][2], array($name, $link));
    }

    public function exec() {

	$this->content = '<style type="text/css">

		#nav, #nav ul { /* all lists */
		    padding: 0;
		    margin: 0;
		    list-style: none;
		    line-height: 1;
		}

		#nav a {
            padding: 3px;
		    display: block;
		    width: '.$this->width.';
		    color: '.$this->font_color.';
		    text-decoration: none;
		}

		#nav a:hover {
            padding: 3px;
		    background-color: '.$this->bghover.';
		}

		#nav li { /* all list items */
		    float: left;
		    width: '.$this->width.'; /* width needed or else Opera goes nuts */
		    background: '.$this->bgcolor.';
		}

		#nav li ul { /* second-level lists */
		    position: absolute;
		    background: '.$this->bgcolor.';
		    width: '.$this->width_child.';
		    left: -999em; /* using left instead of display to hide menus because display: none isnt read by screen readers */
		}

		#nav li ul a { width: '.$this->width_child.'; }

		#nav li:hover ul, #nav li.sfhover ul { /* lists nested under hovered list items */
			width: '.$this->width_child.';
            padding: 3px;
		    left: auto;
		}

	</style>

	<script type="text/javascript"><!--//--><![CDATA[//><!--

	sfHover = function() {
	     var sfEls = document.getElementById("nav").getElementsByTagName("li");
	     for (var i=0; i<sfEls.length; i++) {
		    sfEls[i].onmouseover=function() {
			this.className+=" sfhover";
		    }
		    sfEls[i].onmouseout=function() {
			this.className=this.className.replace(new RegExp(" sfhover\\\\b"), "");
		    }
	    }
	}

	if (window.attachEvent) window.attachEvent("onload", sfHover);

	//--><!]]></script>';


	$tmp = "\n\n<ul id=\"nav\">\n\n";

	foreach($this->menu as $node=>$node_fields) {
	    $tmp .= "\t<li><a href=\"".$node_fields[1]."\">".$node_fields[0]."</a>\n\t";
	
		if(!empty($node_fields[2])) $tmp .= "<ul>\n";

	    foreach($node_fields[2] as $subnode) {
		$tmp .= "\t\t".'<li><a href="'.$subnode[1].'">'.$subnode[0].'</a></li>'."\n";
	    }
	    
	    if(!empty($node_fields[2])) $tmp .= "\t</ul>\n\n";

	}
	
	$tmp .= "</ul>\n\n";

	return $this->content.$tmp;

    }

}


?>
