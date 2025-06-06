<?php
require_once('element.php');
class TInput extends TElement {
	var $type = 'input';
	var $shorttag = true;
	var $labeltext = '';
	var $text = '';//for checkboxes
	var $properties = [
		'type' => 'text',
		'value' => '', 
		'text' => ''
		];
	/*******************************/
	function __construct($c = ''){
		$this->properties['type'] = 'text';
		$this->add($c);
		}
	/*******************************/
	function getproperties() {
		$this->properties['value'] .= implode(' ', $this->items);
		if (!isset($this->properties['name'])) {
			if (isset($this->properties['id'])) {
				$this->properties['name'] = $this->properties['id'];
				}
			}
		return parent::getproperties();
		}
	/*******************************/
	function getprefix() {
		$res = '';
		if (isset($this->properties['text'])) {
			$this->text = $this->properties['text'];
			$this->properties['text'] = '';
			}
		if (trim($this->labeltext)!='') {
			$labelfor = '';
			if ((isset($this->properties['id']))&&(trim($this->properties['id'])!='')) {
				$labelfor = " for=\"{$this->properties['id']}\"";
				}
			$res = "<label{$labelfor}>{$this->labeltext}</label>";
			}
		return $res . parent::getprefix();
		}
	/*******************************/
	function show() {
		//echo "[{$this->properties['id']}]";
		return parent::show() . $this->text;
		}
	/*******************************/
	function label($s) {
		$this->labeltext = $s;
		return $this;
		}
	/*******************************/
	}