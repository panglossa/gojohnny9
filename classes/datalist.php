<?php
require_once('element.php');
class TDataList extends TElement {
	var $type = 'datalist';
	
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
		foreach($this->items as $item) {
            if (is_string($item)) {
			    $res .= "<option value=\"{$item}\">";
                }
			}
		return $res;
		}
	/*******************************/
	}
