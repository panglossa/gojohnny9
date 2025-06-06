<?php
require_once('element.php');
//echo '[' . __LINE__ . ']';
class TUl extends TElement {
	var $type = 'ul';
	
	/*******************************/
	function getcontent() {
		$res = '';
		foreach($this->items as $item) {
			if (trim($item)!='') {
				$res .= "<li>{$item}</li>";
				}
			}
		return $res;
		}
	/*******************************/
	function __construct($src = []){
		//echo '[' . __LINE__ . ']';
		$this->add($src);
		}
	/*******************************/
	function add($content = []) {
		//echo '[' . __LINE__ . ']';
		if (is_array($content)) {
			//echo '[' . __LINE__ . ']';
			foreach($content as $item){
				$this->items[] = $item;
				}
			} else {
			//echo '[' . __LINE__ . ']';
			$this->items[] = $content;
			}
		return $this;
		}
	/*******************************/
	function content($data = []){
		return $this->add($data);
		}
	/*******************************/
	}