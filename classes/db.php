<?php
/*
Panglossa go!Johnny PHP library
version 9.0
release 2024-01-08
Please see the readme.txt file that goes with this source.
Licensed under the GPL, please see:
http://www.gnu.org/licenses/gpl-3.0-standalone.html
panglossa@yahoo.com.br
Araçatuba - SP - Brazil - 2021
*/

class TDB {
	var $pdo = null;
	var $properties = [
		'dbtype' => 'sqlite', 
		'hostname' => 'localhost',
		'databasename' => 'gojohnny.sqlite',  
		'username' => '', 
		'password' => '', 
		'charset' => 'utf8mb4', 
		'port' => '3306', 
		'server' => '', //used by informix
		'protocol' => 'onsoctcp', //used by informix
		'pdofetchmode' => PDO::FETCH_ASSOC, 
		];
	var $result = null;
	var $connected = false;
	var $queryparams = [
		'action' => 'select', 
		'cols' => '*', 
		'table' => 'config',
		'join' => '',
		'on' => '',  
		'where' => [],
		'orderby' => '',
		'dir' => '',
		'limit' => 0,
		'data' => [],
		'distinct' => false
		];
	var $defaultconditionconjunction = 'AND';
	var $defaultconditionoperator = '=';
	///////////////////////////////////////////////////////
	public function __construct(
		$adatabase = 'gojohnny.sqlite', /*Corresponds to the file name in SQLite and Firebird, to the database name in other drivers*/
		$atype = 'sqlite', 
		$auser = 'root', /*ignored in sqlite; default value for MySQL*/
		$apassword = '',  /*ignored in sqlite; default value for MySQL*/
		$ahost = 'localhost',  /*ignored in sqlite; default value for MySQL*/
		$aport = 3306, /*ignored in sqlite; default value for MySQL*/
		$aserver = '', /*used by informix*/
		$aprotocol = 'onsoctcp' /*used by informix*/
		) {
		$this->properties['databasename'] = $adatabase;
		$this->properties['dbtype'] = strtolower($atype);
		$this->properties['username'] = $auser;
		$this->properties['password'] = $apassword;
		$this->properties['hostname'] = $ahost;
		$this->properties['port'] = $aport;
		$this->properties['server'] = $aserver;
		$this->properties['protocol'] = $aprotocol;
		$this->connect();
		}
		
	function connect() {
		try {
			switch ($this->properties['dbtype']) {
				case 'sqlite':
					$this->pdo = new PDO("sqlite:{$this->properties['databasename']}");
					$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$this->result = true;
					$this->connected = true;
					break;
				case 'mysql':
					$this->pdo = new PDO("mysql:dbname={$this->properties['databasename']};port={$this->properties['port']};host={$this->properties['hostname']};charset={$this->properties['charset']};", $this->properties['username'], $this->properties['password']);
					$this->pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
					$this->result = true;
					$this->connected = true;
					break;
				case 'cubrid':
					$this->pdo = new PDO("cubrid:host={$this->properties['hostname']};port={$this->properties['port']};dbname={$this->properties['databasename']}", $this->properties['username'], $this->properties['password']);
					$this->result = true;
					$this->connected = true;
					break;
				case 'dblib':
					$this->pdo = new PDO("dblib:host={$this->properties['hostname']}:{$this->properties['port']};dbname={$this->properties['databasename']}", $this->properties['username'], $this->properties['password']);
					$this->result = true;
					$this->connected = true;
					break;
				case 'mssql':
					$this->pdo = new PDO("mssql:host={$this->properties['hostname']};port={$this->properties['port']};dbname={$this->properties['databasename']}", $this->properties['username'], $this->properties['password']);
					$this->result = true;
					$this->connected = true;
					break;
				case 'firebird':
					$this->pdo = new PDO("firebird:dbname={$this->properties['hostname']}:{$this->properties['databasename']}", $this->properties['username'], $this->properties['password']);
					$this->result = true;
					$this->connected = true;
					break;
				case 'ibm':
					$this->pdo = new PDO("odbc:{$this->properties['databasename']}", $this->properties['username'], $this->properties['password']);
					$this->result = true;
					$this->connected = true;
					break;
				case 'informix':
					$this->pdo = new PDO("informix:host={$this->properties['hostname']};service={$this->properties['port']};database={$this->properties['databasename']}; server={$this->properties['server']}; protocol={$this->properties['protocol']};EnableScrollableCursors=1", $this->properties['username'], $this->properties['password']);
					$this->result = true;
					$this->connected = true;
					break;
				case 'oci':
					$this->pdo = new PDO("oci:dbname={$this->properties['databasename']}", $this->properties['username'], $this->properties['password']);
					$this->result = true;
					$this->connected = true;
					break;
				case 'odbc':
					$this->pdo = new PDO("mysql:dbname={$this->properties['databasename']};port={$this->properties['port']};host={$this->properties['hostname']}", $this->properties['username'], $this->properties['password']);
					$this->result = true;
					$this->connected = true;
					break;
				case 'sybase':
					$this->pdo = new PDO("sybase:host={$this->properties['hostname']};dbname={$this->properties['databasename']}, {$this->properties['username']}, {$this->properties['password']}");
					$this->result = true;
					$this->connected = true;
					break;
				case 'memory':
					$this->pdo = new PDO("sqlite::memory:");
					$this->result = true;
					$this->connected = true;
					break;
				}
			}catch(PDOException $e){
			$this->result = $e->getMessage();
			$this->connected = false;
			}
		return $this->connected;
		}
	///////////////////////////////////////////////////////
	function exec($q){
		echo $q;
		if($this->connected){
			return $this->pdo->exec($q);
			} else {
			return false;
			}
		}
	///////////////////////////////////////////////////////
	function action($s = ''){
		$this->queryparams['action'] = $s;
		return $this;
		}
	function cols($s = ''){
		$this->queryparams['cols'] = $s;
		return $this;
		}
	function what($s = ''){
		$this->queryparams['cols'] = $s;
		return $this;
		}
	function table($s = ''){
		$this->queryparams['table'] = $s;
		return $this;
		}
	function join($s = ''){
		$this->queryparams['join'] = $s;
		return $this;
		}
	function on($s = ''){
		$this->queryparams['on'] = $s;
		return $this;
		}
	function where($key = '', $op = '=', $val = '', $conj = ''){
		if(!is_array($this->queryparams['where'])) {
			$this->queryparams['where'] = [];
			}
		$this->queryparams['where'][] = [
			'key' => $key, 'op' => $op, 'val' => $val, 'conj' => $conj];
		return $this;
		}
	function and($key = '', $op = '=', $val = ''){
		return $this->where($key, $op, $val, 'AND');
		}
	function or($key = '', $op = '=', $val = ''){
		return $this->where($key, $op, $val, 'OR');
		}
	function orderby($s = '', $dir = null){
		$this->queryparams['orderby'] = $s;
		if ((strcasecmp($dir, 'asc')==0)||(strcasecmp($dir, 'desc')==0)) {
			$this->queryparams['dir'] = $dir;
			}
		return $this;
		}
	function dir($s = ''){
		if ((strcasecmp($s, 'asc')==0)||(strcasecmp($s, 'desc')==0)) {
			$this->queryparams['dir'] = $s;
			}
		return $this;
		}
	function limit($s = ''){
		if ((trim($s)=='')||(is_numeric($s))) {
			$this->queryparams['limit'] = $s;
			}
		return $this;
		}
	function data($s = []){
		$this->queryparams['data'] = $s;
		return $this;
		}
	///////////////////////////////////////////////////////
	function query($action = 'select'){
		$res = [];
		$parms = [];
		if (trim($action)!=''){
			$this->queryparams['action'] = $action;
			}
		$q = '';
		if (isset($this->queryparams['action'])) {
			$action = $this->queryparams['action'];
			$what = trim($this->queryparams['cols']);
			if ($what=='') {
				$what = '*';
				}
			$table = trim($this->queryparams['table']);
			$join = trim($this->queryparams['join']);
			$on = trim($this->queryparams['on']);
			$where = '';
			$parms = [];
			if (is_array($this->queryparams['where'])){
				foreach ($this->queryparams['where'] as $condition) {
					if ($where=='') {
						$condition['conj'] = '';
						}
					if (strtolower(trim($condition['op']))=='in') {
						$placeholder  = str_repeat('?,', count($condition['val']) - 1) . '?';
						$where .= " {$condition['conj']} {$condition['key']} IN ({$placeholder})";
						foreach($condition['val'] as $v) {
							$parms[] = $v;
							}
						} else {
						$where .= " {$condition['conj']} {$condition['key']} {$condition['op']} ?";
						$parms[] = $condition['val'];
						}
					}
				}else if (is_string($this->queryparams['where'])){
				$where = $this->queryparams['where'];
				}
			$orderby = trim($this->queryparams['orderby']);
			$dir = trim($this->queryparams['dir']);
			$limit = trim($this->queryparams['limit']);
			$data = $this->queryparams['data'];
			$this->resetparams();
			switch(strtolower($action)) {
				case 'select':
				case 'select distinct':
					if ($table!='') {
						if ($join!=''){
							$table .= " JOIN {$join}";
							if ($on!=''){
								$table .= " ON {$on}";
								}
							}
						}
					if ($where!=''){
						$where = " WHERE {$where}";
						}
					if ($orderby!=''){
						$orderby = " ORDER BY {$orderby}";
						if (trim($dir)!=''){
							$orderby .= " {$dir}";
							}
						}
					if ($limit!=''){
						if ($limit==0){
							$limit = '';
							}else{
							$limit = " LIMIT {$limit}";
							}
						}
					$q .= "{$action} {$what} FROM {$table}{$where}{$orderby}{$limit};";
					//echo "[{$q}]\n";
					//print_r($parms);
					return $this->do_query($q, $parms);
					break;
				case 'insert':
					$q = '';
					return $this->insert($table, $data);
					break;
				case 'update':
					$q = '';
					return $this->update($table, $data, $where);
					break;
				case 'delete':
					$q = '';
					return $this->delete($table, $where, $limit);
					break;
				}
			}
		debug();
		return false;
		}
	function resetparams(){
		$this->queryparams = [
			'action' => 'select', 
			'cols' => '*', 
			'table' => 'config',
			'join' => '',
			'on' => '',  
			'where' => '',
			'orderby' => '',
			'dir' => '',
			'limit' => 0, 
			'data' => [],
			'distinct' => false
			];
		}
	///////////////////////////////////////////////////////
	function do_query($s, $parms = []){
		$res = [];
		try{
			//echo "\n<br/>{$s}<br/>\n";
			$tmp = $this->pdo->prepare($s);
			$tmp->execute($parms);
			}catch(PDOException $e){
			return false;
			}
		$i = 0;
		
		if ($tmp!=false){
			while ($row = $tmp->fetch($this->properties['pdofetchmode'])){
				if(count($row)>0){
					if(isset($row['id'])){
						$res[$row['id']] = $row;
						}else{
						$res[$i++] = $row;
						}
					}
				}
			}
		return $res;
		}
	///////////////////////////////////////////////////////
	function rawquery($s, $fetchmode = 'num'){
		switch ($fetchmode) {
			case 'lazy':
				$fetchmode = PDO::FETCH_LAZY;
				break;
			case 'assoc':
				$fetchmode = PDO::FETCH_ASSOC;
				break;
			case 'named':
				$fetchmode = PDO::FETCH_NAMED;
				break;
			case 'props_late':
				$fetchmode = PDO::FETCH_PROPS_LATE;
				break;
			case 'serialize':
				$fetchmode = PDO::FETCH_SERIALIZE;
				break;
			case 'classtype':
				$fetchmode = PDO::FETCH_CLASSTYPE;
				break;
			case 'keypair':
			case 'key_pair':
				$fetchmode = PDO::FETCH_KEY_PAIR;
				break;
			case 'unique':
				$fetchmode = PDO::FETCH_UNIQUE;
				break;
			case 'group':
				$fetchmode = PDO::FETCH_GROUP;
				break;
			case 'into':
				$fetchmode = PDO::FETCH_INTO;
				break;
			case 'func':
				$fetchmode = PDO::FETCH_FUNC;
				break;
			case 'class':
				$fetchmode = PDO::FETCH_CLASS;
				break;
			case 'column':
				$fetchmode = PDO::FETCH_COLUMN;
				break;
			case 'bound':
				$fetchmode = PDO::FETCH_BOUND;
				break;
			case 'obj':
				$fetchmode = PDO::FETCH_OBJ;
				break;
			case 'both':
				$fetchmode = PDO::FETCH_BOTH;
				break;
			default:
				$fetchmode = PDO::FETCH_NUM;
			}
		$res = [];
		try{
			$tmp = $this->pdo->prepare($s);
			$tmp->execute();
			}catch(PDOException $e){
			return false;
			}
		if ($tmp!=false){
			while ($row = $tmp->fetch($fetchmode)){
				$res[] = $row;
				}
			}
		return $res;
		}
	///////////////////////////////////////////////////////
	function select($tablename = '', $what = '*', $conditions = '', $limit = 0, $order = '', $dir = '', $distinct = false){		
		if (is_array('tablename')) {
			foreach(['tablename', 'what', 'conditions', 'limit', 'order', 'dir', 'distinct'] as $key) {
				if (isset($tablename[$key])) {
					$$key = $tablename[$key];
					}
				}
			}
		$this->resetparams();
		$this->queryparams['action'] = 'select'; 
		$this->queryparams['cols'] = $what; 
		$this->queryparams['table'] = $tablename;
		$this->queryparams['where'] = $conditions;
		$this->queryparams['orderby'] = $order;
		$this->queryparams['dir'] = $dir;
		$this->queryparams['limit'] = $limit; 
		$this->queryparams['distinct'] = $distinct;
		//print_r($this->queryparams);
		return $this->query();
		}
	///////////////////////////////////////////////////////
	function max($tablename = '', $what = 'id', $conditions = [], $limit = 0) {
		$res = 0;
		if ($tablename!='') {
			$data = $this->select($tablename, "max({$what})", $conditions, $limit);
			if (count($data)>0){
				$res = $data[0]["max({$what})"];
				}
			}
		return $res;
		}
	///////////////////////////////////////////////////////
	function getmax($tablename = '', $what = 'id', $conditions = [], $limit = 0) {
		return $this->max($tablename, $what, $conditions, $limit);
		}
	///////////////////////////////////////////////////////
	function getrow($tablename = '', $what = '*', $conditions = [], $limit = 1, $order = '', $dir = ''){
		$res = [];
		$data = $this->select($tablename, $what, $conditions, $limit, $order, $dir);
		//var_dump($data);
		foreach($data as $row){
			$res = $row;
			}
		return $res;
		}
	///////////////////////////////////////////////////////
	function getfirstrow($tablename = '', $what = '*', $conditions = [], $order = '', $dir = ''){
		$res = false;
		$data = $this->select($tablename, $what, $conditions, 1, $order, $dir);
		foreach($data as $row){
			if ($res === false){
				$res = $row;
				}
			}
		if ($res==false) {
			$res = [];
			}
		return $res;
		}
	///////////////////////////////////////////////////////
	function getlastrow($tablename = '', $what = '*', $conditions = [], $order = '', $dir = ''){
		$res = [];
		$data = $this->select($tablename, $what, $conditions, 0, $order, $dir);
		foreach($data as $row){
			$res = $row;
			}
		return $res;
		}
	///////////////////////////////////////////////////////
	function getcol($tablename = '', $col = 'id', $conditions = [], $limit = 0, $order = '', $dir = '', $distinct = true){
		$res = [];
		$data = $this->select($tablename, $col, $conditions, $limit, $order, $dir, $distinct);
		foreach($data as $row){
			if (isset($row[$col])){
				$res[] = $row[$col];
				}
			}
		return $res;
		}
	///////////////////////////////////////////////////////
	function getval($tablename = '', $col = 'id', $conditions = []){
		$res = '';
		$data = $this->getrow($tablename, $col, $conditions);
		if (isset($data[$col])) {
			$res = $data[$col];
			}
		return $res;
		}
	///////////////////////////////////////////////////////
	function insert($tablename = '', $data = []){
		//echo "[{$tablename}]";
		//print_r($data);
		$tablename = trim($tablename);
		if ($tablename!=''){
			//echo '[1]';
			//we have a tablename
			if ((is_array($data))&&(count($data)>0)){
				//echo '[2]';
				if((isset($data[0]))&&(is_array($data[0]))){
					//echo '[3]';
					$res = true;
					foreach($data as $row){
						$keys = '';
						$vals = '';
						foreach($row as $key => $val){
							if ($keys!=''){
								$keys .= ', ';
								}
							$keys .= "`{$key}`";
							if ($vals!=''){
								$vals .= ', ';
								}
							$vals .= ":{$key}";
							}
						$res = (($res) && ($this->prepexec("INSERT INTO `{$tablename}` ({$keys}) VALUES ({$vals});", $row)));
						}
					return $res;
					}else{
					//echo '[4]';
					$keys = '';
					$vals = '';
					foreach($data as $key => $val){
						if ($keys!=''){
							$keys .= ', ';
							}
						$keys .= "`{$key}`";
						if ($vals!=''){
							$vals .= ', ';
							}
						$vals .= ":{$key}";
						}
					//print_r("INSERT INTO `{$tablename}` ({$keys}) VALUES ({$vals});");
					//print_r($data);
					//echo "INSERT INTO `{$tablename}` ({$keys}) VALUES ({$vals});";
					return $this->prepexec("INSERT INTO `{$tablename}` ({$keys}) VALUES ({$vals});", $data);
					}
				}else{
				return false;
				}
			//////////////
			}
		}
	///////////////////////////////////////////////////////
	function update($tablename = '', $data = [], $condition = ''){
		if ($condition==''){
			echo '***********WHY THE HELL ARE YOU UPDATING WITHOUT WHERE?????***********';
			}else{
			$vals = [];
			$fields = [];
			foreach($data as $key => $val){
				$fields[] = "{$key} = :{$key}";
				$vals[":{$key}"] = $val;
				}
			$fields = implode(', ', $fields);
			$querystring = "UPDATE {$tablename} SET {$fields} WHERE {$condition};";
			//echo $querystring;
			$prep = $this->pdo->prepare($querystring);
			return $prep->execute($vals);
			}
		}
	///////////////////////////////////////////////////////
	function updateorinsert($tablename = '', $data = [], $condition = ''){
		$row = $this->select($tablename, '*', $condition);
		if(count($row)>0){
			$this->update($tablename, $data, $condition);
			}else{
			$this->insert($tablename, $data);
			}
		}
	///////////////////////////////////////////////////////
	function prepexec($querystring = '', $data = []){
		$prep = $this->pdo->prepare($querystring);
		return $prep->execute($data);
		}
	///////////////////////////////////////////////////////
	function processconditions($conditions = []){
		$where = '';
		if (is_array($conditions)){
			//conditions are passed as an array; process it before using
			$where = '';
			foreach($conditions as $c){
				if (is_array($c)){
					if (count($c)>1){
						//a valid condition must have at least a key and a value
						if ($where!=''){
							//if this is not the first condition, we need a conjunction (AND, OR)
							if(!isset($c['conj'])){
								if(isset($c['conjunction'])){
									$c['conj'] = $c['conjunction'];
									}else{
									//use the default conjunction, which is AND unless the user sets it otherwise
									$c['conj'] = $this->defaultconditionconjunction;
									}
								}
							$where .= " {$c['conj']} ";
							}
						if (
							(isset($c['key']))
							&&
							(isset($c['val']))
							&&
								(
								(isset($c['op']))
								||
								(isset($c['operator']))
								)
							){
							//all fields are set by name
							//make sure the 'op' field holds a valid operator
							if (!isset($c['op'])){
								if(isset($c['operator'])){
									$c['op'] = $c['operator'];
									}else{
									//touch the field
									$c['op'] = '';
									}
								}
							if (trim($c['op'])==''){
								//use the default conditions operator, which is '=' unless the user sets it otherwise
								$c['op'] = $this->defaultconditionoperator;
								}
							$where .= "`{$c['key']}` {$c['op']} '{$c['val']}'";
							}else{
							//at least one field is not set by name; assume the order: [key] [operator] [value]
							if(count($c)>2){
								$where .= "`{$c[0]}` {$c[1]} '{$c[2]}'";
								}else{
								//only two fields; assume order: [key] [value], use a default operator
								$where .= "`{$c[0]}` {$this->defaultconditionoperator} '{$c[1]}'";
								}
							}
						}else{
						//or else we assume it refers to the default 'id' field
						$where .= "`id` {$this->defaultconditionoperator} '{$c[0]}'";
						}
					}else{
					$where .= "`id` {$this->defaultconditionoperator} '{$c}'";
					}
				}
			}else{
			//conditions are passed as a string; use it as is
			$where = $conditions;
			}
		if ((trim($where)=='')||(trim($where)=='*')){
			$where = '1';
			}
		//echo "{$where}\n<br>";
		return trim($where);
		}
	///////////////////////////////////////////////////////
	function delete($tablename = '', $conditions = [], $limit = 0){
		$conditions = $this->processconditions($conditions);
		if ($limit>0){
			$limit = " LIMIT {$limit}";
			}else{
			$limit = '';
			}
		$q = "DELETE FROM {$tablename} WHERE {$conditions}{$limit};";
		$this->pdo->prepare($q)->execute();
		//echo "[{$q}]\n";
		//$this->query($q);
		}
	///////////////////////////////////////////////////////
	function countrows($tablename = '', $what = 'id', $conditions = []) {
		$res = -1;
		if (trim($tablename)!=''){
			if (trim($what)==''){
				$what = '*';
				}
			if (is_array($conditions)){
				if (count($conditions)==0){
					$conditions = '';
					}
				}
			if (is_string($conditions)){
				if (trim($conditions)==''){
					$conditions = '1';
					}
				}
			//echo "select count({$what}) from {$tablename} where {$conditions};";
			//$c3 = $this->query("select count({$what}) from {$tablename} where {$conditions};");
			$c3 = $this->getrow($tablename, "count ({$what})", $conditions);
			//var_dump($c3);
			$res = $c3["count ({$what})"];
			if (trim($res)=='') {
				$res = 0;
				}
			}
		return $res;
		}
	///////////////////////////////////////////////////////
	function rowcount($tablename = '', $what = 'id', $conditions = []){
		return $this->countrows($tablename, $what, $conditions);
		}
	///////////////////////////////////////////////////////
	function count($tablename = '', $field = 'id', $where = '') {
		return $this->countrows($tablename, $field, $where);
		}
	///////////////////////////////////////////////////////
	function createconfigtable() {
		$this->exec('CREATE TABLE IF NOT EXISTS `config` ( `id` INTEGER, `key` TEXT, `val` TEXT, PRIMARY KEY(`id`) );');
		}
	///////////////////////////////////////////////////////
	///////////////////////////////////////////////////////
	}