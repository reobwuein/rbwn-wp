<?php
class PostMetaBoxFactory{

	private $_boxes = array();
	private $_style = "";
	private $_scripts = "";
	private $_saver;

	function __construct() {
		$this->_saver = new MetaBoxSaver();
		add_action("admin_init", array($this, "buildBoxes"));
		add_action('admin_head', array($this, "addStyle"));
		add_action('admin_head', array($this, "addScripts"));
		add_action('save_post', array($this->_saver, "saveBoxes"));
		add_action('admin_print_footer_scripts', array($this, "addScripts"),99);
	}

	public function buildBoxes(){
		foreach ($this->_boxes as $box){
			add_meta_box(
				$box->metaName,
				$box->name,
				array($this, "buildBox"),
				$box->postType,
				$box->location,
				$box->prio,
				$box->constructor
			);
		}
	}

	public function addStyle() {
		$open = '<style type="text/css">';
		$close = "</style>";

		echo $open.$this->_style.$close;
	}

	public function addScripts() {
		echo $this->_scripts;
	}


	public function addBox($PostMetaBoxVO){
		if(is_subclass_of ($PostMetaBoxVO, "PostMetaBoxVO")){
			if(
				$PostMetaBoxVO->name != "" 			&&
				$PostMetaBoxVO->metaName != "" 		&&
				$PostMetaBoxVO->prio != "" 			&&
				$PostMetaBoxVO->name != ""			&&
				$PostMetaBoxVO->location != ""		&&
				$PostMetaBoxVO->constructor != "" 	&&
				$PostMetaBoxVO->postType != ""
			){
				array_push($this->_boxes, $PostMetaBoxVO);
				$this->_saver->addFields($PostMetaBoxVO->fields);
				$this->_style = $this->_style.$PostMetaBoxVO->getStyle();
				$this->_scripts = $this->_scripts.$PostMetaBoxVO->getScript();
				return true;
			}else{
				return false;

			}
		}
	}

	public function buildBox($post, $box){
		$box["args"]();
	}
}


class MetaBoxSaver{
	private $_fields = array("save");

	public function addFields($fields){
		foreach ($fields as $field){
			array_push($this->_fields, $field);
		}
	}
	public function saveboxes(){
		global $post;
		foreach ($this->_fields as $field){
			if(isset($_POST[$field])){
				$value  = is_array($_POST[$field])? json_encode($_POST[$field], JSON_HEX_QUOT) : $_POST[$field];

				update_post_meta($post->ID, $field, $value);
			}else{
				//echo "!=". $field."<br />";
				update_post_meta($post->ID, $field, "");
			}
		}
	}
}
