<?php
class UserMetaVO {
	
	public $fields = array();
	public $constructor = array();
	private $_style = "";
	private $_script = "";

	function __construct($args) {
		array_push($this->constructor, $args['constructor']);
		$this->fields = $args['fields'];
	}
	
	public function setStyle($style){
		$patterns = array();
		$patterns[0] = '/\r/';
		$patterns[1] = '/\n/';
		$patterns[2] = '/\t/';
		$patterns[3] = '/  /';
		$this->_style = preg_replace($patterns, "", $style);
	}
	
	public function getStyle(){
		return $this->_style;
	}
	
	public function setScript($html){
		$patterns = array();
		$patterns[0] = '/\r/';
		$patterns[1] = '/\n/';
		$patterns[2] = '/\t/';
		$patterns[3] = '/  /';
		$this->_script = preg_replace($patterns, "", $html);
	}
	
	public function getScript(){
		return $this->_script;
	}

}