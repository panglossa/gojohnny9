<?php
require_once('element.php');
class TForm extends TElement {
	var $type = 'form';
	var $submitlabel = 'OK';
	var $button = null;
	/*******************************/
	function __construct($content = ''){
		$this->properties['action'] = '';
		$this->properties['method'] = 'post';
		$this->properties['autocomplete'] = 'on';
		$this->properties['enctype'] = '';
		$this->add($content);
		}
	/*******************************/
	function getcontent() {
		//echo '[' . __LINE__ . ']';
		if (is_null($this->button)) {
			//echo '[' . __LINE__ . ']';
			$this->button = "<input type=\"submit\" value=\"{$this->submitlabel}\" />";
			}
		$res = parent::getcontent();
		//echo '[' . __LINE__ . ']';
		if (strpos($res, 'type="submit"')===false) {
			//echo '[' . __LINE__ . ']';
			$res .= $this->button;
			}
		return $res;
		}
	/*******************************/
	function submit($s) {
		//echo '[' . __LINE__ . ']';
		if (is_object($s)) {
			//echo '[' . __LINE__ . ']';
			$this->button = $s;
			} else if (is_string($s)) {
			//echo '[' . __LINE__ . ']';
			$this->submitlabel = $s;
			}
		return $this;
		}
	/*******************************/
	}

