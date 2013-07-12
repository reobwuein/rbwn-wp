<?php
class UserMetaFactory{
	
	private $_userMeta = array();
	private $_style = "";
	private $_scripts = "";
	private $_saver;
	
	function __construct() {
		$this->_saver = new UserMetaSaver();
		add_action('show_user_profile', array($this, "buildUserMeta"));
		add_action('edit_user_profile', array($this, "buildUserMeta"));
		add_action('personal_options_update', array($this->_saver, "saveUserMeta"));
		add_action('edit_user_profile_update', array($this->_saver, "saveUserMeta"));
		
		add_action('admin_head', array($this, "addStyle"));
		add_action('admin_print_footer_scripts', array($this, "addScripts"),99);
	}
	
	function buildUserMeta($user) {
		foreach ($this->_userMeta as $userMeta){
			$userMeta->constructor[0]($user);
		}
	}
	
	function addUserMeta($UserMetaVO) {
		if(is_subclass_of ($UserMetaVO, "UserMetaVO") || get_class($UserMetaVO) == "UserMetaVO"){
			array_push($this->_userMeta, $UserMetaVO);
			$this->_saver->addFields($UserMetaVO->fields);
			$this->_style = $this->_style.$UserMetaVO->getStyle();
			$this->_script = $this->_style.$UserMetaVO->getScript();
			return true;
		}else{
			return false;
		}
	}
	
	public function addStyle() {
		$open = '<style type="text/css">';
		$close = "</style>";
		
		if($this->_style > 1){
			echo $open.$this->_style.$close;
		}
	}
	
	public function addScripts() {
		echo $this->_scripts;
	}
}

class UserMetaSaver{
	private $_fields = array("save");
	
	public function addFields($fields){
		foreach ($fields as $field){
			array_push($this->_fields, $field);
		}
	}
	public function saveUserMeta($user_id){
		global $post;
		foreach ($this->_fields as $field){
			if(isset($_POST[$field])){
				update_usermeta($user_id, $field, $_POST[$field]);
			}
		}
	}
}
