<?php
/*
 *
 * Plugin Name:       custom-block-gutenberg
 * Plugin URI:        localhost/wordpress/wp-content/plugins/custom-block-gutenberg/
 * Description:       Custom block Gutenberg
 * Version:           1.0
 * Requires PHP:      8.2
 * Author:            Clément Schneider
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       custom-block-gutenberg
 */
add_option( 'formulaire', 'Mon texte ...', '', 'yes' );
register_setting( 'setting_option', 'formulaire');
add_shortcode('tag_shortcode', 'shortcode_show');
add_action( 'admin_menu', 'shortcode_function');
add_action('enqueue_block_editor_assets', 'custom_block_gutenberg_script_register');
if(function_exists('acf_register_block_type')){
	add_action('acf/init', 'register_acf_block_types');
}
//register_acf_block_types();

/*
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

function register_acf_block_types(){
    acf_register_block_type(
            array( 'name' => 'test',
                'title' => __('Test'),
                'description' => __('Test du custom ..'),
                'render_template' => 'bloc-gutenberg.php',
                'icon' => 'editor-paste-text',
                'keywords' => aray('test', 'product')
            )
    );
}

function shortcode_show($atts = [], $content = null){
	$options = get_option( 'formulaire', false);
	return $options;
}


/*
 * Function called during the method "add_shortcode"
 *
 * @params: Array atts, String content
 * @return: content
 */
function shortcode_function($atts = array()) {
		add_menu_page(
			'Formulaire',
			'Formulaire',
			'manage_options',
			'formulaire',
			'page_html_option_shortcode'
		);
}

/*
 * Generate forms page
 *
 * @param: void
 * @return: void
 */
function page_html_option_shortcode() {

	if ( isset( $_GET['settings-updated'] ) ) {
		add_settings_error( 'formulaire_messages', 'formulaire', __( 'Settings sauvegardés', 'formulaire' ), 'updated' );
	}

	// show error/update messages
	settings_errors( 'formulaire_messages' );
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form method="post" action="options.php" >
			<textarea id="formulaire" name="formulaire"><?php echo get_option( 'formulaire' ); ?></textarea>
			<?php
			settings_fields( 'setting_option' );
			do_settings_sections( 'formulaire' );
			submit_button( 'Modifier' );
			?>
		</form>

	</div>
	<?php


}
