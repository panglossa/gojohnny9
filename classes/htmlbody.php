<?php
/*
Panglossa go!Johnny PHP library
version 9.0
release 2024-01-08
Please see the readme.txt file that goes with this source.
Licensed under the GPL, please see:
http://www.gnu.org/licenses/gpl-3.0-standalone.html
panglossa@yahoo.com.br
Araçatuba - SP - Brazil - 2021
*/
class THtmlBody extends TElement{
	var $items = [];
	/*******************************/
	function show(){
		$res = "<body>\n<!-- starting page body section -->\n";
		foreach($this->items as $item){
			$res .= $item;
			}
		$res .= "\n<!-- finishing page body section -->\n</body>\n";
		return $res;
		}
	/*******************************/
	/*******************************/
	}
?>