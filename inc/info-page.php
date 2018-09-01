<?php
/**
 * The informational page for this plugin.
 *
 * This is available to everyone who can edit posts, because they'll need this info if they're creating new child pages for embed using the shortcode or plugin.
 */

namespace INN\PymShortcode\Info;

/**
 * Create the option page
 *
 * @since 1.3.2.1
 */
function register_options_page() {
	add_submenu_page(
		'tools.php',
		__( 'Pym Plugin Info', 'pym-shortcode' ), // title of page
		__( 'Pym Plugin Info', 'pym-shortcode' ), // menu text
		'edit_posts', // capability required
		'pym-shortcode-info', // menu slug
		__NAMESPACE__ . '\options_page_callback' // callback for options page display
	);
}
add_action( 'admin_menu', __NAMESPACE__ . '\register_options_page' );

/**
 * Options page display callback
 *
 * @since 1.3.2.1
 * @link https://developer.wordpress.org/plugins/settings/custom-settings-page/
 */
function options_page_callback() {
	printf(
		'<h1>%1$s</h1>',
		esc_html( get_admin_page_title() )
	);

	printf(
		'<p>%1$s</p>',
		wp_kses_post( __( 'For information on how to use the block and shortcode provided by the Pym plugin, read the plugin\'s documentation <a href="https://github.com/INN/pym-shortcode/tree/master/docs">on GitHub</a>.', 'pym-shortcode' ) )
	);

	printf(
		'<label for="local_url">%1$s</label>',
		esc_html__( 'The URL for the copy of Pym.js hosted on this site is:', 'pym-shortcode' )
	);

	// copying how qz.com does their share links
	printf(
		'<input id="local_url" type="text" readonly value="%1$s" style="clear:both; width: 100%%; display: block;"/>',
		esc_attr( pym_pymsrc_local_url() )
	);
}
