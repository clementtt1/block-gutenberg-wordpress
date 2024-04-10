<?php

class WP_block_gutenberg_Setup {
	/**
	 * @since 1.0.0
	 */
	public function __construct() {

	}

	/**
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init(): void {
		try {
			add_option( 'formulaire', 'Mon texte ...', '', 'yes' );
			register_setting( 'setting_option', 'formulaire');
			add_shortcode('tag_shortcode', 'shortcode_show');
			add_action('enqueue_block_editor_assets', array($this, 'custom_block_gutenberg_script_register'));
			$this->wordpress_absolute_path_available();
			register_activation_hook( WP_BLOCK_GUTENBERG_PLUGIN_FILE_PATH, array( $this, 'plugin_activate' ) );
			register_deactivation_hook( WP_BLOCK_GUTENBERG_PLUGIN_FILE_PATH, array( $this, 'plugin_deactivate' ) );
		} catch ( Exception $exception ) {
			exit( $exception->getMessage() );
		}
	}

	/**
	 * @since 1.0.0
	 *
	 * @throws Exception
	 *
	 * @return bool
	 */
	protected function wordpress_absolute_path_available(): bool {
		if( defined( 'ABSPATH' )) {
			return true;
		} else {
			$exception = new Exception( 'WordPress unavailable. Plugin not loaded.' );
			error_log( $exception->getMessage() );
			throw $exception;
		}
	}

	/**
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function plugin_activate(): void {
		add_option('wp_block_gutenberg_just_activated',true );
	}

	/**
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function plugin_deactivate(): void {

	}

	/**
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function shortcode_show($atts = [], $content = null){
		$options = get_option( 'formulaire', false);
		return $options;
	}

	/**
	 * Function doing the Guntenberg block
	 *
	 * @params: void
	 * @return void
	 */
	function custom_block_gutenberg_script_register(){
		wp_enqueue_script('custom-block-gutenberg', plugin_dir_url(__FILE__).'block-gutenberg.js', array('wp-blocks', 'wp-i18n', 'wp-editor'), true, false);
		$data_to_pass = array();
		$valeur = get_option( 'formulaire' );
		$data_to_pass['valeur'] = "$valeur";
		wp_localize_script( 'custom-block-gutenberg', 'php_vars', $data_to_pass );
	}

}