<?php
require_once(get_template_directory(). '/ReobwueinWP/postRestrictor/postMetaBoxes/UserRestrictPostMetaBoxVO.php');

class PostRestrictor{

	private $userRestriction = array();
	private $inheritRestriction = array();
	private $loginRestriction = array();
	private $metaFactory = "";

	function __construct($postMetaBoxFactory){
		$this->metaFactory = $postMetaBoxFactory;
		//add_filter( 'wp_insert_post_data' , array($this, 'filter_post_data') , '99', 2 );
		if(!current_user_can('edit_pages')){
			add_filter( 'posts_where' , array($this, 'posts_where' ));
			add_filter('posts_join', array($this, 'join'));
			add_filter('posts_groupby', array($this, 'group'), 20, 1 );
		}
	//	add_filter( 'posts_clauses', array($this, 'intercept_query_clauses'), 20, 1 );
	}

	public function userRestrict($postType){

		if(!in_array($postType, $this->userRestriction)){

			array_push($this->userRestriction, $postType);

			$prPostMetaBox = new UserRestrictPostMetaBoxVO();
			$prPostMetaBox->postType = $postType;
			$this->metaFactory->addBox($prPostMetaBox);
		}
	}

	public function inheritRestrict($postType, $parentPostType){
		if(!in_array($postType, $this->userRestriction)){
			array_push($this->userRestriction, $postType);
			array_push($this->inheritRestriction, $postType);
		}
	}

	public function loggedinRestrict($postType){
		if(!in_array($postType, $this->loginRestriction)){
			array_push($this->loginRestriction, $postType);
		}
	}

	/*public function filter_post_data( $data , $postarr ) {

		if(in_array($data['post_type'], $this->userRestriction)){
			echo "user restricted";
		}
		if(in_array($data['post_type'], $this->inheritRestriction)){
			echo "parent restricted";
		}
		if( current_user_can('administrator') ) {
			return $data;
		}

		if(in_array($data['post_type'], $this->inheritRestriction)){
			echo "user restricted";
		}

		//$data['post_title'] .= '_suffix';
		return $data;
	}*/



//( (wp_postmeta.meta_key = 'color' AND CAST(wp_postmeta.meta_value AS CHAR) IN ('blue') ) )
	public function posts_where( $where ) {
		global $wpdb;

		$postTypes = $this->getPostTypeFromWhereString($where);

		$postTypeString = " AND ( ";
		foreach ($postTypes as $postType){
			if(strlen($postTypeString) > 10) $postTypeString .= " OR ";
			$postTypeString .= "( ".$wpdb->prefix."posts.post_type = '".$postType."'";

			if(in_array($postType, $this->userRestriction)){
				$postTypeString .= " AND ( (".$wpdb->prefix."postmeta.meta_key = 'pr:users' AND ( CAST(".$wpdb->prefix."postmeta.meta_value AS CHAR) LIKE '%:".get_current_user_id( ).":%') OR ( CAST(".$wpdb->prefix."postmeta.meta_value AS CHAR) LIKE '%:*:%') ) )";
			}

			if(in_array($postType, $this->loginRestriction)){
				if(get_current_user_id( ) != 0){
					$postTypeString .= " AND (((".$wpdb->prefix."postmeta.meta_key = 'pr:logged' AND CAST(".$wpdb->prefix."postmeta.meta_value AS CHAR) != '1')))";
				}
			}

			$postTypeString .= " ) ";
		};
		$postTypeString .= ") ";

		$newWhere = $postTypeString. $this->getWhereStringNoPostType($where);

		return $newWhere;
	}

	public function join($join) {
		global $wpdb;


		$join = $join. "INNER JOIN ".$wpdb->prefix."postmeta ON (".$wpdb->prefix."posts.ID = ".$wpdb->prefix."postmeta.post_id)";


		return $join;
	}

	public function group($group) {
		global $wpdb;

		$group = "".$wpdb->prefix."posts.ID";

		return $group;
	}



	public function intercept_query_clauses( $pieces )
	{
		var_dump($pieces);

		return $pieces;
	}

	private function getPostTypeFromWhereString($where){
		global $wpdb;
		$clean = strstr($where, $wpdb->prefix.'posts.post_type');
		$clean = strstr($clean,' ');
		if(strpos($clean, 'AND')) $clean = strstr($clean,'AND', true);
		$clean = str_replace(array("IN", " ", "(",")","'","="), "", $clean);
		$clean = explode(",", $clean);
		return $clean;
	}

	private function getWhereStringNoPostType($where){
		global $wpdb;

		$before = strstr($where, $wpdb->prefix.'posts.post_type', true);
		$before = substr($before, 0, strlen($before)-4);

		$after  = strstr($where, $wpdb->prefix.'posts.post_type');
		if(strpos($after, 'AND')){
			$after = strstr($after,'AND');
		}else{
			$after = "";
		}

		return $before.$after;;
	}
}