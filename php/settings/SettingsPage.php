<?php
class SettingsPage{

	private $name = "";
	private $slug = "";
	private $settings = "";
	private $script = "";
	private $style = "";

	function __construct($args) {

		$this->name = $args['name'];
		$this->slug = $args['slug'] ? $args['slug'] : str_replace(" ", "", $args['name']);
		$this->settings = $args['settings'];

		add_action('admin_init', array($this, 'theme_options_init') );
		add_action('admin_menu', array($this, 'theme_options_add_page') );
		add_action('admin_head', array($this, "addStyle"));
		add_action('admin_print_footer_scripts', array($this, "addScripts"),99);
	}
	public function theme_options_init(){
		register_setting($this->slug."_options", $this->slug);
	}

	public function theme_options_add_page() {
		add_theme_page( __( $this->name, 'reobwuein' ), __( $this->name, 'reobwuein' ), 'edit_theme_options', 'theme_options', array($this, 'theme_options_do_page' ));
	}

	public function theme_options_do_page() {
		global $select_options; if ( ! isset( $_REQUEST['settings-updated'] ) ) $_REQUEST['settings-updated'] = false;?>
		<div>
		<?php screen_icon(); echo "<h2>".$this->name . "</h2>"; ?>
		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div>
		<p><strong><?php _e( 'Options saved', 'customtheme' ); ?></strong></p></div>
		<?php endif; ?>
		<form method="post" action="options.php">
			<?php settings_fields( $this->slug."_options" ); ?>

			<?php $options = get_option( $this->slug ); ?>
			<?php foreach ($this->settings as $setting){
				switch($setting['type']){
					case 'textarea': ?>
						<label><?php echo $setting['name'] ?><textarea rows="3" name="<?php echo $this->slug."[".$setting['tag'] ?>]" ><?php echo $options[$setting['tag']]?></textarea></label>
						<?php break;
					case 'checkbox': ?>
						<label><?php echo $setting['name'] ?><input type="checkbox" value="1" name="<?php echo $this->slug."[".$setting['tag'] ?>]" <?php checked( $options[$setting['tag']], 1); ?>></label>
						<?php break;
					default: ?>
						<label><?php echo $setting['name'] ?><input type="text" value="<?php echo $options[$setting['tag']] ?>" name="<?php echo $this->slug."[".$setting['tag'] ?>]" ></label>
						<?php
				}
			}
			?>
			<p>
				<input type="submit" value="Save options" />
			</p>
		</form>
		</div>
			<?php
	}

	public function addStyle() {
		$open = '<style type="text/css">';
		$close = "</style>";
		if($this->style != ""){
			echo $open.$this->_style.$close;
		}
	}

	public function addScripts() {
		echo $this->_scripts;
	}
}
