<?php
class UserRolePostMetaBoxVO extends PostMetaBoxVO{

	function __construct(){
		$this->name = "Set roles to users";
		$this->metaName = "userRole";
		$this->setConstructor();
		$this->fields = array("ur:users");
		$this->setStyle($this->customStyle());
		$this->setScript($this->customScript());
	}
	
	private function setConstructor() {
		$this->constructor = function(){
			global $post;
			$custom 	= get_post_custom($post->ID);
			$users		= $custom["ur:roles"][0];
			$userToRole		= $custom["ur:userToRole"][0];
			?>
			<label>Comma seperated roles<input type="text" value="<?php echo $users ?>" name="ur:roles" ></label>
			<label>Comma seperated user=role<input type="text" value="<?php echo $userToRole ?>" name="ur:userToRole" ></label>
			<?php
		};
	}
	
	private function customStyle(){
		$templatePath = get_bloginfo('template_url', 'raw'); 
return<<<CSS

#userRestrict h3{
	background:#FFF url($templatePath/ReobwueinWP/assets/img/lock.png) no-repeat 7px 2px;
	background-size: auto 25px;
	padding-left:40px;
}

#userRestrict input, #webapp textarea{
	display:block;
	width:100%;
	margin:5px 0 20px 0;
}
#userRestrict img.preview{
	display:block;
	float:none;
	max-width:100%;
}

CSS;
	}
	
	private function customScript(){
return<<<JS


JS;
	}

}



?>