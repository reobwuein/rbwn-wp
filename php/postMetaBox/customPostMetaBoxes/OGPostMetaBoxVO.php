<?php
class OGPostMetaBoxVO extends PostMetaBoxVO{

	function __construct(){
		$this->name = "Open graph optimalisation";
		$this->metaName = "ogcrawler";
		$this->setConstructor();
		$this->fields = array("og:title","og:description","og:image");
		$this->setStyle($this->customStyle());
		$this->setScript($this->customScript());
	}
	
	private function setConstructor() {
		$this->constructor = function(){
			global $post;
			$custom = get_post_custom($post->ID);
			$title 			= $custom["og:title"][0];
			$description 	= $custom["og:description"][0];
			$image 			= $custom["og:image"][0];
			?>
			<label>Title<input type="text" value="<?php echo $title ?>" name="og:title" ></label>
			<label>Description<textarea rows="3" name="og:description"><?php echo $description ?></textarea></label>
			<img src="<?php echo $image ?>" alt="og:image" class="preview" />
			<label>Image<input type="text" value="<?php echo $image ?>" name="og:image"></label>
			<?php
		};
	}
	
	private function customStyle(){
		$templatePath = get_bloginfo('template_url', 'raw'); 
return<<<CSS

#ogcrawler h3{
	background:#FFF url($templatePath/ReobwueinWP/assets/img/opengraph.png) no-repeat 7px 0px;
	background-size: 30px auto;
	padding-left:40px;
}

#ogcrawler input, #ogcrawler textarea{
	width:100%;
	margin:5px 0 20px 0;
}
#ogcrawler img.preview{
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