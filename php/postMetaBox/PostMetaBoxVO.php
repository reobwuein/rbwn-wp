<?php
class PostMetaBoxVO{

	public $name = "";
	public $metaName = "";
	public $constructor = "";
	public $prio = "low";
	public $postType = "post";
	public $location = "side";
	public $fields = array();
	private $_style = "";
	private $_scripts = "";

	function __construct($args) {
		$this->name = $args['name'];
		$this->metaName = $args['metaName'];
		$this->constructor = $args['constructor'];
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
		$this->_scripts = preg_replace($patterns, "", $html);
	}

	public function getScript(){
		return $this->_scripts;
	}

}