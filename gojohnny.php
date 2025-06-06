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
// Report all PHP errors
error_reporting(E_ALL);
function debug($s = '') {
	//echo '[' . __FILE__ . ' line ' . __LINE__ . "]\n";
	$debuginfo = debug_backtrace();
	//print_r(debug_backtrace());
	echo "[{$debuginfo[0]['file']} line {$debuginfo[0]['line']}] {$s}\n";
	}
////////////////////////////////////////////////
////////////////////////////////////////////////
//Some array related functions
if (!function_exists('array_is_list')) {
	function array_is_list(array $arr) {
		if ($arr === []) {
			return true;
			}
		return array_keys($arr) === range(0, count($arr) - 1);
		}
	}
//! Check whether the input is an array whose keys are all integers.
/*!
    \param[in] $InputArray          (array) Input array.
    \return                         (bool) \b true iff the input is an array whose keys are all integers.
*/
function IsArrayAllKeyInt($InputArray) {
    if(!is_array($InputArray)) {
        return false;
    	}

    if(count($InputArray) <= 0) {
        return true;
    	}

    return array_unique(array_map("is_int", array_keys($InputArray))) === array(true);
	}
//! Check whether the input is an array whose keys are all strings.
/*!
    \param[in] $InputArray          (array) Input array.
    \return                         (bool) \b true iff the input is an array whose keys are all strings.
*/
function IsArrayAllKeyString($InputArray) {
    if(!is_array($InputArray))    {
        return false;
    	}

    if(count($InputArray) <= 0)    {
        return true;
    	}

    return array_unique(array_map("is_string", array_keys($InputArray))) === array(true);
	}
//! Check whether the input is an array with at least one key being an integer and at least one key being a string.
/*!
    \param[in] $InputArray          (array) Input array.
    \return                         (bool) \b true iff the input is an array with at least one key being an integer and at least one key being a string.
*/
function IsArraySomeKeyIntAndSomeKeyString($InputArray) {
    if(!is_array($InputArray)) {
        return false;
    	}

    if(count($InputArray) <= 0) {
        return true;
    	}

    return count(array_unique(array_map("is_string", array_keys($InputArray)))) >= 2;
	}
////////////////////////////////////////////////
//you can use a custom options file in your app, and include it before gojohnny.php
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'options.php');

foreach([
	'GJ_CHARSET' => 'utf-8',
	'GJ_DATEFORMAT' => 'Y-m-d',
	'GJ_TIMEFORMAT' => 'H:i:s',
	'GJ_DATETIMEFORMAT' => 'Y-m-d H:i:s',
	'GJ_SENDHEADERS' => true,
	'GJ_USEGJFONTS' => false, //include some nice free fonts
	'GJ_USETIDY' => true,
	'GJ_AUTOCLASS' => false,
	'GJ_AUTOID' => true,
	'GJ_AUTOMAIN' => true,
	'GJ_PAGECONTAINERTYPE' => 'div',
	'GJ_USEMATHML' => false,
	'GJ_SHORTCUTS' => true,
	'GJ_OPENGRAPH_METATAGS' => false,
	'GJ_DEFAULTICON' => 'gojohnny.ico',
	'GJ_DEFAULTFORMMETHOD' => 'POST',
	'GJ_DEFAULTFORMAUTOCOMPLETE' => 'on',
	'GJ_DEFAULTFORMENCTYPE' => 'multipart/form-data',
	'GJ_DEFAULTINPUTTYPE' => 'text',
	'GJ_USEGJCSS' => true,
	'GJ_USEGJJS' => true,
	'GJ_AUTOLOADMODULE' => false,
	'GJ_DEFAULTMODULE' => 'home', 
	'GJ_MODULEPATH' => 'modules' . DIRECTORY_SEPARATOR ,
	'GJ_AUTOSESSION' => true, 
	'GJ_AUTOCONFIG' => false, 
	'GJ_AUTODB' => false, 
	'GJ_DBACCESS' => '0744', 
	'GJ_SCRIPT_AFTER' => 'script_after.js', 
	'GJ_PARSEDOWNPATH' => 'lib' . DIRECTORY_SEPARATOR . 'parsedown' . DIRECTORY_SEPARATOR . 'Parsedown.php'
	] as $name => $val){
	if(!defined($name)){
		define($name, $val);//Define only if not already defined in gojohnny_config.php
		}
	}
//require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'gjclass.php');
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'element.php');
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'db.php');

//a few shortcuts:
foreach([
	'br' => '<br/>',
	'BR' => '<br/>',
	'nl' => "\n", 
	'NL' => "\n", 
	'hr' => '<hr/>',
	'HR' => '<hr/>',
	'sp' => '&#32;',
	'SP' => '&#32;',
	'nbsp' => '&nbsp;',
	'NBSP' => '&nbsp;',
	'NAV' => 'nav', 
	'nav' => 'nav', 
	'HEADER' => 'header', 
	'header' => 'header', 
	'MAIN' => 'main', 
	'main' => 'main', 
	'FOOTER' => 'footer', 
	'footer' => 'footer', 
	] as $name => $val){
	if(!defined($name)){
		define($name, $val); //Define only if not already defined by user
		}
	}




class TGoJohnny {
	
	static function element($type = 'div', $content = '', $args = []) {
		$inputtype = 'text';
		$label = '';
		$selectsize = 5;
		$res = "class [{$type}] not found";
		$type = strtolower(trim($type));
		$cssclass = '';
		if (($type=='checkbox')||($type=='radio')) {
			$label = $content;
			$content = '';
			}
		$inputsubtypes = ['text', 'password', 'button', 'checkbox', 'color', 'date', 'datetime-local', 'email', 'file', 'hidden', 'image', 'month', 'number', 'radio', 'range', 'reset', 'search', 'submit', 'tel', 'time', 'url', 'week'];
		foreach($inputsubtypes as $st) {
			if ($type==$st) {
				$type = 'input';
				$inputtype = $st;
				}
			}
		if ($type=='edit') {
			$type = 'input';
			$inputtype = 'text';
			}
			
		if ($type=='listbox') {
			$type = 'select';
			}
			
		if ($type=='combobox') {
			$type = 'select';
			$selectsize = 1;
			}
			
		if ($type=='memo') {
			$type = 'textarea';
			}
		
		foreach(['info', 'warning', 'error'] as $msgtype) {
			if ($type==$msgtype) {
				$type = 'div';
				$cssclass = $msgtype;
				}
			}
		
		$classfilename = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $type . '.php';
		$classname = "T{$type}";
		if (file_exists($classfilename)) {
			require_once($classfilename);
			$res = new $classname();
			//echo __LINE__ . "[{$content}]";
			$res->add($content);
			if (is_array($args)) {
				foreach($args as $key => $val) {
					$res->properties[$key] = $val;
					}
				} else if (is_string($args)) {
				$res->add($args);
				}
			} else {
			require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'element.php');
			$res = new TElement();
			$res->type = strtolower(trim($type));
			if ((is_string($content))&&(trim($content)!='')) {
				$res->add($content);
				}
			if (is_array($args)) {
				foreach($args as $key => $val) {
					$res->properties[$key] = $val;
					}
				} else if (is_string($args)) {
				$res->add($args);
				}
			}
		if ($type=='input') {
			$res->type($inputtype);
			$res->text($label);
			}
		
		if ($type=='select') {
			$res->size($selectsize);
			}
		if (trim($cssclass)!='') {
			$res->class($cssclass);
			}
		return $res;
		}
	static function __callStatic($method = '', $parameters = []) {
		$content = '';
		$args = [];
		if (isset($parameters[0])) {
			$content = $parameters[0];
			}
		if (isset($parameters[1])) {
			$args = $parameters[1];
			}
		return self::element($method, $content, $args);
		}
	}
//shortcuts, mostly for backwards compatibility
function gj($type = 'div', $content = '', $args = []) {
	return TGoJohnny::element($type, $content, $args);
	}

function TForm($content = '') {
	return TGoJohnny::element('form', $content);
	}

function TTable($content = []) {
	return TGoJohnny::element('table', $content);
	}

function TRowSpan($q = 2, $content = []) {
	return TGoJohnny::element('td', $content)->rowspan($q);
	}

function TColSpan($q = 2, $content = []) {
	return TGoJohnny::element('td', $content)->colspan($q);
	}

function TP($content = []) {
	return TGoJohnny::element('p', $content);
	}

function TDiv($content = []) {
	return TGoJohnny::element('div', $content);
	}

function TSpan($content = []) {
	return TGoJohnny::element('span', $content);
	}

function TList($content = []) {
	return TGoJohnny::element('ul', $content);
	}

function TA($url = '', $text = '') {
	return TGoJohnny::element('a', $text)->href($url);
	}

function TEdit($text = '') {
	return TGoJohnny::element('input', $text)->type('text');
	}

function TPassword($text = '') {
	return TGoJohnny::element('input', $text)->type('password');
	}

function TListBox($items = []) {
	return TGoJohnny::element('select', $items);
	}

function TComboBox($items = []) {
	return TGoJohnny::element('select', $items)->size(1);
	}

function TMemo($text = '') {
	return TGoJohnny::element('textarea', $text);
	}

function TH1($s = '') {
	return TGoJohnny::element('h1', $s);
	}

function TH2($s = '') {
	return TGoJohnny::element('h2', $s);
	}

function TH3($s = '') {
	return TGoJohnny::element('h3', $s);
	}

function TH4($s = '') {
	return TGoJohnny::element('h4', $s);
	}

function TH5($s = '') {
	return TGoJohnny::element('h5', $s);
	}

function TH6($s = '') {
	return TGoJohnny::element('h6', $s);
	}

function TTT($s = '') {
	return TGoJohnny::element('tt', $s);
	}

function TB($s = '') {
	return TGoJohnny::element('b', $s);
	}

function TI($s = '') {
	return TGoJohnny::element('i', $s);
	}

function o($id = '', $object = null, $properties = []) {
	$res = $object;
	$res->id($id);
	return $res;
	}



/////////////////////////////////////////////

function parsedown($s = '') {
	$res = '';
	if (trim($s)!='') {
		if (file_exists(GJ_PARSEDOWNPATH)) {
			require_once(GJ_PARSEDOWNPATH);
			$p = new Parsedown();
			$res = $p->text($s);
			}
		}
	return $res;
	}
