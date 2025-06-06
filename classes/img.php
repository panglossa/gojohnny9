<?php
require_once('element.php');
//echo '[' . __LINE__ . ']';
class TImg extends TElement {
	var $type = 'img';
	var $shorttag = true;
	/*******************************/
	function __construct($src = null){
		$this->add($src);
		}
	/*******************************/
	function add($src = null) {
		if (!is_null($src)) {
			$this->properties['src'] = $src;
			}
		return $this;
		}
	/*******************************/
	function content($data = []){
		return $this->add($data);
		}
	/*******************************/
	/*******************************/
	}
