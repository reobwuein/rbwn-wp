<?php
class TwitterPostMetaBoxVO extends PostMetaBoxVO{

	function __construct(){
		$this->name = "Twitter tweet prefill";
		$this->metaName = "twtPrefill";
		$this->setConstructor();
		$this->fields = array("twt:text","twt:url","twt:@");
		$this->setStyle($this->customStyle());
		$this->setScript($this->customScript());
	}

	private function setConstructor() {
		$this->constructor = function(){
			global $post;
			$custom = get_post_custom($post->ID);
			$text			= $custom["twt:text"][0];
			$url	= $custom["twt:url"][0];
			$at 			= $custom["twt:@"][0];
			?>
			<label>Tweet text<textarea rows="2" name="twt:text"><?php echo $text ?></textarea></label>
			<?php
		};
	}

	private function customStyle(){
		$templatePath = get_bloginfo('template_url', 'raw');
return<<<CSS

#twtPrefill h3{
	background:#FFF url($templatePath/ReobwueinWP/assets/img/twitter.png) no-repeat 7px 0px;
	background-size: 30px auto;
	padding-left:40px;
}

#twtPrefill input, #twtPrefill textarea{
	width:100%;
	margin:5px 0 20px 0;
}
#twtPrefill img.preview{
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