<?php

class WP_block_gutenberg_Options {
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
		add_action( 'admin_menu', array($this, 'setup_submenu_with_page' ) );
	}

	/**
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function setup_submenu_with_page(): void {
		add_submenu_page(
			'options-general.php',
			'WP-block-gutenberg',
			'WP-block-gutenberg',
			'manage_options',
			'wp-block-gutenberg',
			array( $this, 'setup_page' )
		);
	}

	/**
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function setup_page(): void {
		?><h1><?php echo esc_html( get_admin_page_title() ); ?></h1><?php
		$this->setup_settings_form();
	}

	/**
	 * @since 1.0.0
	 *
	 * @return void
	 *
	 * @noinspection HtmlUnknownTarget*
	 */
	protected function setup_settings_form(): void {?>
		<form method="post" action="options.php" >
			<textarea id="formulaire" name="formulaire"><?php echo get_option( 'formulaire' ); ?></textarea>
			<?php
			settings_fields( 'setting_option' );
			do_settings_sections( 'formulaire' );
			submit_button( 'Modifier' );
			?>
		</form>
		<?php
	}
}