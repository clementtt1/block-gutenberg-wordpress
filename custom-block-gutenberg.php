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


const WP_BLOCK_GUTENBERG_PLUGIN_FILE_PATH = __FILE__;

wp_block_gutenberg_setup();

/**
 * @since 1.0.0
 *
 * @return void
 */
function wp_block_gutenberg_setup() {
	try {
		wp_block_gutenberg_require_once();
        $wp_block_gutenberg_setup = new WP_block_gutenberg_Setup();
		$wp_block_gutenberg_setup->init();
		$wp_block_gutenberg_option = new WP_block_gutenberg_Options();
		$wp_block_gutenberg_option->init();
	}
    catch(Exception $e){
        exit($e->getMessage());
    }
}

/**
 * @since 1.0.0
 *
 * @return void
 */
function wp_block_gutenberg_require_once(): void {
	$plugin_dir_path = plugin_dir_path( WP_BLOCK_GUTENBERG_PLUGIN_FILE_PATH );
	require_once $plugin_dir_path . 'includes/WP_block_gutenberg_Setup.php';
	require_once $plugin_dir_path . 'admin/WP_block_gutenberg_Options.php';
}
