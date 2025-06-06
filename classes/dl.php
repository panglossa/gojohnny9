<?php
require_once('element.php');
class TDl extends TElement {
	var $type = 'dl';
	
	/*******************************/
	function __construct($data = []){
		$this->add($data);
		}
	/*******************************/
	function add($data = []){
		if (is_array($data)) {
			foreach($data as $dt => $dd) {
				$this->items[$dt] = $dd;
				}
			}
		return $this;
		}
	/*******************************/
	function content($data = []){
		return $this->add($data);
		}
	/*******************************/
	function getcontent() {
		$res = '';
		foreach($this->items as $dt => $dd) {
			$res .= "<dt>{$dt}</dt><dd>{$dd}</dd>";
			}
		return $res;
		}
	/*******************************/
	}