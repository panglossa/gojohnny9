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


class TElement {
	var $type = 'element'; 
	var $properties = [
		'id' => '', 
		'class' => '',  
		'style' => []
		];
	var $items = [];
	var $shorttag = false;
	var $gjversion = '9.0';
	var $x = 0;
	var $str_properties = '';
	
	/*******************************/
	function __construct(){
		if (func_num_args()>0){
			//add to items anything passed on creation
			foreach(func_get_args() as $arg){
				$this->add($arg);
				}
			}
		}
	/*******************************/
	function __call($method = '', $arg = []){
		if (trim($method)!='') {
			if (count($arg)>0) {
				$this->properties[$method] = $arg[0];//$arg is supposed to be always a single item
				}
			}
		return $this;
		}
	/*******************************/
	function add(){
		if (func_num_args()>0){
			foreach(func_get_args() as $arg){
				$this->items[] = $arg;
				}
			}
		return $this;
		}
	/*******************************/
	function content(){
		if (func_num_args()>0){
			foreach(func_get_args() as $arg){
				$this->items[] = $arg;
				}
			}
		return $this;
		}
	/*******************************/
	function style($key = null, $val = null) {
		if (is_array($key)) {
			foreach($key as $subkey => $subval) {
				$this->properties['style'][$subkey] = $subval;
				}
			} else if ((!is_null($key))&&(!is_null($val))) {
			$this->properties['style'][$key] = $val;
			}
		return $this;
		}
	/*******************************/
	function getproperties(){
		if (trim($this->str_properties)=='') {
			// $this->properties["debug_{$this->x}"] = $this->x;
			// if ($this->x == 1) {
			// 	echo "[[[x = {$this->x}; " . (new \Exception)->getTraceAsString() . "]]]\n\n";
			// 	}
			// $this->x += 1;
			foreach($this->properties as $key => $value){
				if (!is_null($value)){
					if($key=='style'){
						$style = '';
						foreach($value as $stylekey => $styleval) {
							$style .= "{$stylekey}:{$styleval};";
							}
						$value = $style;
						}
					if($value!==''){
						if($value===true){
							$this->str_properties .= " {$key}";
							}else{
							$value = trim($value);
							if($value!=''){
								$this->str_properties .= " {$key}=\"{$value}\"";
								}
							}
						}
					}
				}
			}
		return $this->str_properties;
		}
	/*******************************/
	function getprefix(){
		if ($this->type=='textarea') {
			if (!isset($this->properties['name'])) {
				if (isset($this->properties['id'])) {
					$this->properties['name'] = $this->properties['id'];
					}
				}
			}
		$res = '<' . $this->type . $this->getproperties();
		if($this->shorttag!=true){
			$res .= ">";
			}
		return $res;
		}
	/*******************************/
	function getcontent(){
		$res = '';
		if(!$this->shorttag){
			foreach ($this->items as $item){
				if (is_array($item)){
					foreach ($item as $subitem){
						$res .= $subitem;
						}
					}else{
					if($item!=null){
						$res .= $item;
						}
					}
				}
			}
		//$this->items = [];
		return $res;
		}
	/*******************************/
	function getsuffix(){
		if($this->shorttag){
			return ' />';
			}else{
			return "</{$this->type}>\n";
			}
		}
	/*******************************/
	function show(){
		$res = $this->getprefix()
			. $this->getcontent()
			. $this->getsuffix();
			/*
		$config = array(
            'indent'         => true,
            'output-xml'     => true,
            'input-xml'     => true,
            'wrap'         => '1000');

		// Tidy
		if (class_exists('tidy')) {
			$tidy = new tidy();
			$tidy->parseString($res, $config, 'utf8');
			$tidy->cleanRepair();
			return tidy_get_output($tidy);
			} else {
			return $res;
			}
			*/
		return $res;
		}
	/*******************************/
	function render(){
		echo $this->show();
		}
	/*******************************/
	function __toString(){
		return $this->show();
		}
	/*******************************/

	}