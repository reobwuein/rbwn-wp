<?php
class PostTypeFactory{

	private $_types = array();
	private $_style = "";
	private $_scripts = "";

	function __construct() {
		add_action('init', array($this, "buildPostType"));
		add_action('admin_head', array($this, "addStyle"));
		add_action('admin_print_footer_scripts', array($this, "addScripts"),99);
	}

	public function buildPostType(){
		foreach ($this->_types as $type){
			$args = array(
				'labels' => $type->labels,
				'public' => $type->public,
				'exclude_from_search' => $type->exclude_from_search,
				'publicly_queryable' => $type->publicly_queryable,
				'show_ui' => $type->show_ui,
				'show_in_nav_menus' => $type->show_in_nav_menus,
				'show_in_menu' => $type->show_in_menu,
				'show_in_admin_bar' => $type->show_in_admin_bar,
				'menu_position' => $type->menu_position,
				//'menu_icon' => $type->menu_icon,
				//'capability_type' => $type->capability_type,
				//'capabilities' => $type->capabilities,
				//'map_meta_cap' => $type->map_meta_cap,
				'hierarchical' => $type->hierarchical,
				'supports' => $type->supports,
				'taxonomies' => $type->taxonomies,
				'has_archive' => $type->has_archive,
				//'permalink_epmask' => $type->permalink_epmask,
				'query_var' => $type->query_var,
				'can_export' => $type->can_export,
				'rewrite' => $type->rewrite
			);
			register_post_type( $type->postType , $args );
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


	public function addType($PostTypeVO){
		if(is_subclass_of ($PostTypeVO, "PostTypeVO") || get_class($PostTypeVO) == "PostTypeVO"){
			if($PostTypeVO->postType != ""){
				array_push($this->_types, $PostTypeVO);
				$this->_style = $this->_style.$PostTypeVO->getStyle();
				$this->_script = $this->_style.$PostTypeVO->getScript();
				return true;
			}else{
				return false;
			}
		}
	}
}
