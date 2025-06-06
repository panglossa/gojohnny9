<?php
require_once('select.php');
class TComboBox extends TSelect {
	/*******************************/
	function __construct(){
		parent::__construct();
		$this->properties['size'] = 1;
		}
	}