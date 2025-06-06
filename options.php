<?php
//echo 'Hello from the default options file!!!!!!!';

$serverprefix = 'http://';
if (isset($_SERVER['HTTPS'])) {
	if ((!is_null($_SERVER['HTTPS']))&&($_SERVER['HTTPS']!='off')) {
		$serverprefix = 'https://';
		}
	}
if (isset($_SERVER['HTTP_HOST'])) {
	$serverpath = $serverprefix . $_SERVER['HTTP_HOST'];
	$gjwebpath = explode(DIRECTORY_SEPARATOR, dirname(__FILE__));
	$gjwebpath = $serverpath . '/' . $gjwebpath[count($gjwebpath)-1];
	}else{
	$gjwebpath = '.';
	}
//$systempath = dirname(__FILE__);

foreach([
	'GJ_PATH_LOCAL' => dirname(__FILE__), //internal path to the go!Johnny library; used by php
	'GJ_PATH_WEB' => $gjwebpath, //external path to the go!Johnny library; used by css and javascript
	'GJ_CHARSET' => 'utf-8',
	'GJ_DATEFORMAT' => 'Y-m-d',
	'GJ_TIMEFORMAT' => 'H:i:s',
	'GJ_DATETIMEFORMAT' => 'Y-m-d H:i:s',
	'GJ_SENDHEADERS' => true,
	'GJ_USEGJFONTS' => false, //include some nice free fonts
	'GJ_USETIDY' => false,
	'GJ_AUTOCLASS' => false,
	'GJ_AUTOID' => false,
	'GJ_DEFAULTPAGESECTION' => 'main',
	'GJ_PAGECONTAINERTYPE' => 'div',
	'GJ_USEMATHML' => false,
	'GJ_SHORTCUTS' => true,
	'GJ_OPENGRAPH_METATAGS' => false,
	'GJ_DEFAULTICON' => "{$gjwebpath}/media/gj_32.ico",
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
	'GJ_SCRIPT_AFTER' => false, //the path to a .js file to be included at the end of the HTML
	'GJ_ADDNEWLINE' => true, //add a newline after each HTML element; default: true 
	'GJ_INPUTAUTONAME' => true, //automatically set an input's name property 
	'GJ_DEFAULTDBTYPE' => 'sqlite', 
	] as $key => $val){
	if(!defined($key)){
		define($key, $val); //Define only if not already defined by user
		}
	}

foreach([
	'GJ_CLASSPATH' => GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR, 
	'GJ_BASECSS' => GJ_PATH_WEB . '/lib/blueprint/screen.css',
	'GJ_JQUERY' => GJ_PATH_WEB . '/lib/jquery/jquery-3.2.1.min.js',
	'GJ_VUE' => GJ_PATH_WEB . '/lib/vue/vue.min.js', 
	'GJ_JQUERYUI_CSS' => GJ_PATH_WEB . DIRECTORY_SEPARATOR . 'lib/jquery-ui-1.12.1/jquery-ui.css',
	'GJ_JQUERYUI_JS'  => GJ_PATH_WEB . DIRECTORY_SEPARATOR . 'lib/jquery-ui-1.12.1/jquery-ui.js',
	'GJ_PARSEDOWN' => GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'parsedown' . DIRECTORY_SEPARATOR . 'Parsedown.php',
	'GJ_GESHI' => '/usr/share/php-geshi/geshi.php',
	'GJ_PRISM' => GJ_PATH_WEB . '/lib/prism/', 
	'GJ_CODE_HIGHLIGHT' => 'prism' /* possible values: 'pre', 'geshi', 'prism'*/
	
	] as $name => $val){
	if(!defined($name)){
		define($name, $val); //Define only if not already defined by user
		}
	}