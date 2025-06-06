<?php
require_once('element.php');
class TSelect extends TElement {
	var $type = 'select';
	var $selected = '';
	/*******************************/
	function __construct($items = []){
		if (is_array($items)) {
			$this->items = $items;
			} else if (is_string($items)) {
			foreach(explode('|', $items) as $item) {
				if (trim($item)!='') {
					$this->items[$item] = $item;
					}
				}
			}
		}
	/*******************************/
	function getcontent() {
		$res = '';
		foreach($this->items as $key => $val) {
			//no sense in having an empty item
			if ((trim($key)!='')&&(trim($val)!='')) {
				$res .= "<option value=\"{$key}\"";
				if ($this->selected==$key) {
					$res .= ' selected';
					}
				$res .= ">{$val}</option>";
				}
			}
		return $res;
		}
	/*******************************/
	function select($id) {
		$this->selected = $id;
		return $this;
		}
	/*******************************/
	function add() {
				/*
		possible inputs:
		1. a single parameter
			1a. an array
				1a-x. a plain array (['a', 'b', 'c'])
				1a-y. an associative array (['item_a' => 'a', 'item_b' => 'b', 'item_c' => 'c'])
			1b. a string to parse ('a|b|c|d|e|f')
		2. two or more 
			2a. two parameters, interpreted as id and text
			2b. more than two parameters, interpreted as items ('a', 'b'(, 'c', 'd'))
		*/
		$args = func_get_args();
		$c = count($args);
		if ($c>0) {
			if ($c==1) {
				if (is_array($args[0])) {
					//1a
					//does it kave keys?
					if (array_is_list($args[0])) {
						//1a-x
						foreach($args[0] as $item) {
							//items were passed individually, so there is no 
							//given key to use
							if (trim($item)!='') {
								$this->items[$item] = $item;
								}
							}
						} else {
						//1a-y
						foreach($args[0] as $key => $val) {
							$this->items[$key] = $val;
							}
						}
					} else {
					if (is_string($args[0])) {
						//1b
						foreach(explode('|', $args[0]) as $item) {
							if (trim($item)!='') {
								$this->items[$item] = $item;
								}
							}
						}
					}
				} else {
				//$c >= 2
				if (count($args)==2) {
					//2a.
					$this->items[$args[0]] = $args[1];
					} else {
					//2b.
					foreach($args as $item) {
						//items were passed individually, so there is no 
						//given key to use
						if (trim($item)!='') {
							$this->items[$item] = $item;
							}
						}
					}
				}
			}
		}
	/*******************************/
	function getproperties() {
		if (!isset($this->properties['name'])) {
			if (isset($this->properties['id'])) {
				$this->properties['name'] = $this->properties['id'];
				}
			}
		return parent::getproperties();
		}
	/*******************************/
	/*******************************/
	/*******************************/
	}