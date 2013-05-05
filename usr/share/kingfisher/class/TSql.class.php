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

/**
* class TSql
* classe para a abstração de conexões SQL
*/
class TSql {
	private $sqltype; // tipo de sql: select, delete, insert ou update
	public $sqlquery; // query a ser executada

	/*
	* método __construct()
	* instancia uma nova query
	* @param $sqltype = query a ser executada
	*/
	public function __construct($sqltype) {
		$this->sqltype = $sqltype;
	}

	/*
	* método exec()
	* executa a query sql
	*/
	public function exec() {
		try {
			$dbh = new PDO(DSN, DBUSER, DBPASS);
			$dbh->query("set names utf8");
			$dbh->query("set character_set utf8");

			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


			if($this->sqltype != 'select') {
				$dbh->beginTransaction();
				$dbh->exec($this->sqlquery);
				if($this->sqltype == 'insert') $result = $dbh->lastInsertId();
				$dbh->commit();

			}
			else {
				foreach($dbh->query($this->sqlquery) as $row) {
					$result[] = $row;
				}
			}
 			

		} catch (Exception $e) {
			$dbh->rollBack();
			echo "Failed: " . $e->getMessage();
			die();
		}
		
		if(($this->sqltype == 'select') or ($this->sqltype == 'insert')) return $result;

	}

}

?>
