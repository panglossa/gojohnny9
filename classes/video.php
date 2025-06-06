<?php
require_once('element.php');
class TVideo extends TElement {
	var $type = 'video';
	var $source = [];
	
	/*******************************/
	function __construct(){
		$this->properties['controls'] = true;
		$this->properties['autoplay'] = false;
		$this->properties['disableremoteplayback'] = false;
		$this->properties['loop'] = false;
		$this->properties['muted'] = false;
		
		if (func_num_args()>0){
			foreach(func_get_args() as $arg){
				$this->source[] = $arg;
				}
			}
		}
	/*******************************/
	function add(){
		if (func_num_args()>0){
			foreach(func_get_args() as $arg){
				$this->source[] = $arg;
				}
			}
		return $this;
		}
	/*******************************/
	function content(){
		if (func_num_args()>0){
			foreach(func_get_args() as $arg){
				$this->source[] = $arg;
				}
			}
		return $this;
		}
	/*******************************/
	function src() {
		if (func_num_args()>0){
			foreach(func_get_args() as $arg){
				$this->source[] = $arg;
				}
			}
		return $this;
		}
	/*******************************/
	function getcontent() {
		$res = '';
		foreach($this->source as $s) {
			$res .= "<source src=\"{$s}\" />";
			}
		return $res;
		}
	/*******************************/
	}
