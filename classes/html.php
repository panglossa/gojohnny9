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
////////////////////////////////////////////////
////////////////////////////////////////////////
require_once('htmlhead.php');
require_once('htmlbody.php');
////////////////////////////////////////////////

class THtml extends TElement {
	var $doctype = '<!DOCTYPE html>';
	var $type = 'html';//just a standard library property
	var $head;//a THtmlHead object representing the <head> section of the page
	var $body;//a THtmlBody object representing the <body> section of the page
	var $lang = 'en';
	var $dir='ltr';
	var $id = '';
	var $css = [];//css file(s) to be linked
	var $js = [];//js file(s) to be linked
	var $style = [];//style to be added to the <head> section of the page
	var $script = [];
	var $title = '';//the page title
	var $icon = '';//a 'favicon' to be displayed e.g. in the address bar or in the browser tab
	var $base = '';//base address for the page
	var $target = '';//default target for links
	var $meta = null;
	var $charset = GJ_CHARSET;
	var $application_name = '';
	var $applicationname = '';
	var $author = '';
	var $description = '';
	var $generator = '';
	var $keywords = [];
	var $contentlanguage = '';
	var $contenttype = '';
	var $defaultstyle = '';
	var $refresh = '';
	var $scriptsafter = false;//whether or not to add all js files at the end of the page, to improve loading time
	var $properties = [];
	var $c = [];
	var $parameters = [];
	var $parameters_get = [];
	var $parameters_post = [];
	var $parameters_session = [];
	var $parameters_cookies = [];
	var $content_language = '';
	var $content_type = '';
	var $default_style = '';
	var $db = null;
	var $user = null;
	////////////////////////////////////////////////
	function __construct($title = '', $content = '', $icon = GJ_DEFAULTICON){
		$this->content_language = &$this->contentlanguage;
		$this->content_type = &$this->contenttype;
		$this->default_style = &$this->defaultstyle;
		$this->properties['lang'] = '';
		$this->properties['dir'] = '';
		$this->properties['id'] = '';
		$this->lang = &$this->properties['lang'];
		$this->dir = &$this->properties['dir'];
		$this->id = &$this->properties['id'];
		$this->head = new THtmlHead($title, $icon);
		$this->body = new THtmlBody();
		$this->meta = &$this->head->meta;
		$this->charset = &$this->head->charset;
		$this->title = &$this->head->title;
		$this->icon = &$this->head->icon;
		$this->js = &$this->head->js;
		$this->style = &$this->head->style;
		$this->script = &$this->head->script;
		$this->css = &$this->head->css;
		$this->items = &$this->body->items;
		if ($content!=''){
			$this->add($content);
			}
		$this->getparameters();
		}
	////////////////////////////////////////////////
	function getparameters(){
		foreach($_REQUEST as $key => $val){
			$this->parameters[$key] = $val;
			}
		foreach($_GET as $key => $val){
			$this->parameters_get[$key] = $val;
			}
		foreach($_POST as $key => $val){
			$this->parameters_post[$key] = $val;
			}
		foreach($_SESSION as $key => $val){
			$this->parameters_session[$key] = $val;
			}
		foreach($_COOKIE as $key => $val){
			$this->parameters_cookies[$key] = $val;
			}
		$this->c = [];
		if(isset($this->parameters['c'])){
			$this->c = explode('/', $this->parameters['c']);
			}
		}
	////////////////////////////////////////////////
	function parm($key = '', $default = '') {
		$res = $default;
		if (isset($this->parameters[$key])) {
			$res = $this->parameters[$key];
			}
		return $res;
		}
	////////////////////////////////////////////////
	function getcontent(){
		if ($this->scriptsafter){
			//You can choose to load .js files after the page content has been loaded.
			$this->body->add($this->head->getjs());
			$this->body->add($this->head->getscripts());
			$this->head->js = [];
			$this->head->script = [];
			}
		$res = $this->head . $this->body;
		return $res;
		}
	////////////////////////////////////////////////
	function getprefix(){
		return $this->doctype . "\n<html>\n";
		}
	////////////////////////////////////////////////
	function getsuffix(){
		return "\n</html>\n";
		}
	////////////////////////////////////////////////
	function show(){
		$res = $this->getprefix();
		$res .= $this->head;
		$res .= $this->body;
		$res .= $this->getsuffix();
		
		if ((GJ_USETIDY)&&(class_exists('Tidy'))){
		//if (GJ_USETIDY){
			$config = [
				'char-encoding' => $this->charset,
				'indent' => TRUE,
				'output-xhtml' => true,
				'wrap' => 150, 
				'new-blocklevel-tags' => 'progress meter details summary command header section article footer aside menu' // This option in necessary for enabling HTML5 new elements! 
				];
			//$tidy = tidy_parse_string($res, $config);
			$tidy = new Tidy();
			$tidy->parseString($res, $config, 'utf8');
			$tidy->cleanRepair();
			$res = $tidy;
			}else{
			//$res = str_replace("><", ">\r\n<", $res);
			}
		return $res;
		}
	////////////////////////////////////////////////////////////////////////
	function render(){
		if ((!headers_sent())&&(GJ_SENDHEADERS==true)){
			header('Content-Type:text/html; charset=' . $this->charset);
			}
		echo $this->show();
		}
	////////////////////////////////////////////////////////////////////////
	function output(){
		$this->render();
		}
	////////////////////////////////////////////////////////////////////////
	function title($atitle = ''){
		$this->title = $atitle;
		return $this;
		}
	////////////////////////////////////////////////////////////////////////
	function icon($anicon = ''){
		$this->icon = $anicon;
		return $this;
		}
	////////////////////////////////////////////////////////////////////////
	function css($cssfile = ''){
		if (!is_array($cssfile)){
			$cssfile = [$cssfile];
			}
		foreach($cssfile as $f){
			$this->css[] = $f;
			}
		return $this;
		}
	////////////////////////////////////////////////////////////////////////
	function js($jsfile = ''){
		if (!is_array($jsfile)){
			$jsfile = [$jsfile];
			}
		foreach($jsfile as $f){
			$this->js[] = $f;
			}
		return $this;
		}
	////////////////////////////////////////////////////////////////////////
	function viewport($v) {
		if (trim($v)!='') {
			$this->meta[] = [
				'name' => 'viewport',
				'content' => $v
				];
			}
		return $this;
		}
	////////////////////////////////////////////////////////////////////////
	function keywords($k) {
		if (is_array($k)) {
			$k = implode(', ', $k);
			}
		if (trim($k)!='') {
			$this->meta[] = [
				'name' => 'keywords',
				'content' => $k
				];
			}
		return $this;
		}
	////////////////////////////////////////////////////////////////////////
	function description($s) {
		if (trim($s)!='') {
			$this->meta[] = [
				'name' => 'description',
				'content' => $s
				];
			}
		return $this;
		}
	////////////////////////////////////////////////////////////////////////
	function author($s) {
		if (trim($s)!='') {
			$this->meta[] = [
				'name' => 'author',
				'content' => $s
				];
			}
		return $this;
		}
	////////////////////////////////////////////////////////////////////////
	function refresh($s) {
		if ((trim($s)!='')&&(is_numeric($s))) {
			$this->meta[] = [
				'http-equiv' => 'refresh',
				'content' => $s
				];
			}
		return $this;
		}
	////////////////////////////////////////////////////////////////////////
	function meta($key = '', $val = '') {
		if ((trim($key)!='')&&(trim($val)!='')) {
			$this->meta[] = [
				'name' => $key,
				'content' => $val
				];
			}
		return $this;
		}
	////////////////////////////////////////////////////////////////////////
	function go($url = '') {
		if (trim($url)!='') {
			$this->add("<script>window.location = '{$url}';</script>");
			}
		}
	////////////////////////////////////////////////////////////////////////
	}
////////////////////////////////////////////////
////////////////////////////////////////////////
////////////////////////////////////////////////
////////////////////////////////////////////////
