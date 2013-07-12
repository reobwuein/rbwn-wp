<?php
class WepAppPostMetaBoxVO extends PostMetaBoxVO{

	function __construct(){
		$this->name = "Web App page";
		$this->metaName = "webapp";
		$this->setConstructor();
		$this->fields = array("wa:capable","wa:viewport","wa:57x57","wa:72x72","wa:114x114","wa:144x144","wa:startup");
		$this->setStyle($this->customStyle());
		$this->setScript($this->customScript());
	}
	
	private function setConstructor() {
		$this->constructor = function(){
			global $post;
			$custom 	= get_post_custom($post->ID);
			$switch		= $custom["wa:capable"][0];
			$viewport	= $custom["wa:viewport"][0];
			$s57x57		= $custom["wa:57x57"][0];
			$s72x72		= $custom["wa:72x72"][0];
			$s114x114	= $custom["wa:114x114"][0];
			$s144x144	= $custom["wa:144x144"][0];
			$startup	= $custom["wa:startup"][0];
			?>
			<label>browser chrome<input type="checkbox" <?php checked( $switch, 1); ?>  value='1' name="wa:capable" /></label>
			<label>viewport<input type="text" value="<?php echo $viewport ?>" name="wa:viewport" ></label>
			<label>logo 57x57<input type="text" value="<?php echo $s57x57 ?>" name="wa:57x57" ></label>
			<label>logo 72x72<input type="text" value="<?php echo $s72x72 ?>" name="wa:72x72" ></label>
			<label>logo 114x114<input type="text" value="<?php echo $s114x114 ?>" name="wa:114x114" ></label>
			<label>logo 144x144<input type="text" value="<?php echo $s144x144 ?>" name="wa:144x144" ></label>
			<label>logo start up image<input type="text" value="<?php echo $startup ?>" name="wa:startup" ></label>
			<?php
		};
	}
	
	private function customStyle(){
		$templatePath = get_bloginfo('template_url', 'raw'); 
return<<<CSS

#webapp h3{
	background:#FFF url($templatePath/ReobwueinWP/assets/img/smartphone.jpg) no-repeat 9px 2px;
	background-size: auto 25px;
	padding-left:40px;
}

#webapp input, #webapp textarea{
	display:block;
	width:100%;
	margin:5px 0 20px 0;
}
#webapp img.preview{
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