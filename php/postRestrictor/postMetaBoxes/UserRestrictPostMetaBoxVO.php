<?php
class UserRestrictPostMetaBoxVO extends PostMetaBoxVO{

	function __construct(){
		$this->name = "Restrict the page to the following users";
		$this->metaName = "userRestrict";
		$this->setConstructor();
		$this->fields = array("pr:users");
		$this->setStyle($this->customStyle());
		$this->setScript($this->customScript());
	}

	private function setConstructor() {
		$this->constructor = function(){
			global $post;
			$custom 	= get_post_custom($post->ID);
			$users		= $custom["pr:users"][0];
			?>
			<input type="hidden
			" id="users" value="<?php echo $users ?>" name="pr:users" >
			<ul><label><input class="user-allowed" type="checkbox" name="*"/>Everyone (no restriction)</label>
			<?php
			$blogusers = get_users();
		    foreach ($blogusers as $user) {
		        echo '<label><input class="user-allowed" type="checkbox" name="'.$user->id.'"/>' . $user->display_name . '</label>';
		    }
		    ?></ul><?php 
		};
	}

	private function customStyle(){
		$templatePath = get_bloginfo('template_url', 'raw');
return<<<CSS

#userRestrict h3{
	background:rgba(0,0,0,0) url($templatePath/ReobwueinWP/assets/img/lock.png) no-repeat 7px 2px;
	background-size: auto 25px;
	padding-left:40px;
}
#userRestrict label{
	display:block;
}

CSS;
	}

	private function customScript(){
return<<<JS
<script type="text/javascript">
jQuery(document).ready(function(){

	var users=jQuery("#users").val().split(":");

	jQuery(".user-allowed").each(function(){
		if(users.indexOf(jQuery(this).attr("name"))>0){
			jQuery(this).attr("checked", "checked");
		};
		jQuery(this).on("change", updateUsersAllowed);
	});

	function updateUsersAllowed(){
		if (jQuery(this).is(':checked')) {
			users.push(jQuery(this).attr("name"))
		}else{
			while(users.indexOf(jQuery(this).attr("name"))>-1){
				users.splice(users.indexOf(jQuery(this).attr("name")), 1);
			}
		}
		updateUserField();
	}

	function updateUserField(){
		jQuery("#users").val(users.join(":")+":");
	}
})</script>
JS;
	}

}



?>