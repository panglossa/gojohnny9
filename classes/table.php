<?php
require_once('element.php');
class TTable extends TElement {
	var $type = 'table';
	var $headitems = [];
	/*******************************/
	function __construct(){
		$this->add(func_get_args());
		/*
		$args = func_get_args();
		$c = count($args);
		if ($c>0){
			if ($c==1){
				if (!is_array($args[0])) {
					$args[0] = [$args[0]];
					}
				$this->add($args[0]);
				} else {
				//we know we have at least two elements
				$hasrows = false;
				foreach($args as $arg) {
					if (is_array($arg)) {
						$hasrows = true;
						}
					}
				if ($hasrows) {
					foreach($args as $arg) {
						if (!is_array($arg)) {
							$arg = [$arg];
							}
						$this->add($arg);
						}
					} else {
					$this->add($args);
					}
				}
			} */
		}
	/*******************************/
	function add() {
		$data = func_get_args();
		if (count($data)==1) {
			//we have one single item, should be an array
			$ismulti = false;
			foreach($data as $item) {
				if (is_array($item)) {
					$ismulti = true;
					break;
					}
				}
			if ($ismulti) {
				foreach($data as $row) {
					$this->items[] = $row;
					}
				} else{
				$this->items[] = $data;
				}
			} else if (count($data)>1) {
			$this->items[] = $data;
			}
		
		return $this;
		}
	/*******************************/
	function addhead($data = []) {
		if (is_array($data)) {
			$this->headitems[] = $data;
			}
		return $this;
		}
	/*******************************/
	function addheader($data = []) {
		if (!is_array($data)) {
			$data = func_get_args();
			}
		return $this->addhead($data);
		}
	/*******************************/
	function addheaders($data = []) {
		if (!is_array($data)) {
			$data = func_get_args();
			}
		return $this->addhead($data);
		}
	/*******************************/
	function parse($s = '') {
		$rows = explode("\n", $s);
		foreach ($rows as $row) {
			$this->items[] = explode('|', trim($row));
			}
		return $this;
		}
	/*******************************/
	function maketd($s = '') {
		if (is_null($s)) {
			$s = '';
			}
		$alreadytd = false;
		if (is_object($s)) {
			if (property_exists($s, 'gjversion')) {
				if ($s->type == 'td') {
					$alreadytd = true;
					}
				}
			}
		if ($alreadytd) {
			$res = $s;
			} else {
			$res = "<td>{$s}</td>";
			}
		//var_dump($s);
		/*
		if ((str_contains(strtolower($s), '<td'))&&(str_contains(strtolower($s), '</td>'))) {
			//var_dump($s);
			
			} else {
			//var_dump($s);
			
			}*/
		
		return $res;
		}
	/*******************************/
	function maketh($s = '') {
		$res = $s;
		if ((str_contains(strtolower($s), '<th'))&&(str_contains(strtolower($s), '</th>'))) {
			return $s;
			} else {
			return "<th>{$s}</th>";
			}
		
		}
	/*******************************/
	function getcontent() {
		$res = '';
		$res .= '<thead>';
		foreach($this->headitems as $row) {
			$res .= '<tr>';
			foreach($row as $cell) {
				/*
				if (!is_object($cell)) {
					$cell = "<th>{$cell}</th>";
					}
					*/
				$res .= $this->maketh($cell);
				}
			$res .= '</tr>';
			}
		$res .= '</thead>';
		$res .= '<tbody>';
		//print_r($this->items);
		foreach($this->items as $row) {
			if (trim(implode('', $row))!='') {
				$res .= '<tr>';
				foreach($row as $cell) {
					/*
					if (!is_object($cell)) {
						$cell = "<td>{$cell}</td>";
						}
						*/
					//print_r($cell);
					$res .= $this->maketd($cell);
					}
				$res .= '</tr>';
				}
			}
		$res .= '</tbody>';
		//file_put_contents('tabledebug.txt', $res);
		return $res;
		}
	/*******************************/
	}
