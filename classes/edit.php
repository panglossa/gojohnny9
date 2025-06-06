<?php
require_once('input.php');
class TEdit extends TInput {
	var $type = 'input';
	var $shorttag = true;
	/*******************************/
	function __construct($c = ''){
		$this->properties['type'] = 'text';
		$this->add($c);
		}
	/*******************************/
	}