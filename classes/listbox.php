<?php
require_once('select.php');
class TListBox extends TSelect {
	/*******************************/
	function __construct(){
		$this->properties['size'] = 5;
		parent::__construct();
		}
	}