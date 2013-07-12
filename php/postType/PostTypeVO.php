<?php
class PostTypeVO{

	public $postType = "";
	public $labels = array();
	public $public = true;
	public $exclude_from_search = false;
	public $publicly_queryable = true;
	public $show_ui = true;
	public $show_in_nav_menus = true;
	public $show_in_menu = true;
	public $show_in_admin_bar = true;
	public $menu_position = 5;
	public $menu_icon = "";
	//public $capability_type = "post";
	public $capabilities = "";
	public $map_meta_cap = false;
	public $hierarchical = false;
	public $supports = array('title','editor','author','thumbnail');//,'excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats');
	public $taxonomies = array();
	public $has_archive = false;
	public $permalink_epmask = "";
	public $query_var = true;
	public $can_export = true;
	public $rewrite = "";

	private $_style = "";
	private $_script = "";

	function __construct($args) {

		$this->postType = $args['postType'];

		$this->labels = array(
			'name' => $this->name,
			'singular_name' => $this->singular_name,
			'add_new' => $this->add_new,
			'all_items' => $this->all_items,
			'add_new_item' => $this->add_new_item,
			'edit_item' => $this->edit_item,
			'new_item' => $this->new_item,
			'view_item' => $this->view_item,
			'search_items' => $this->search_items,
			'not_found' => $this->not_found,
			'not_found_in_trash' => $this->not_found_in_trash,
			'parent_item_colon' => $this->parent_item_colon,
			'menu_name' => $this->menu_name
		);
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

	public function setScript($script){
		$patterns = array();
		$patterns[0] = '/\r/';
		$patterns[1] = '/\n/';
		$patterns[2] = '/\t/';
		$patterns[3] = '/  /';
		$this->_script = preg_replace($patterns, "", $script);
	}

	public function getScript(){
		return $this->_script;
	}

}