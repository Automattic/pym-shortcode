<?php
/**
 * The informational page for this plugin.
 *
 * This page shows where embeds on this site load Pym.js from. It's available to everyone who can edit posts, so authors can see which copy of Pym.js their embeds use.
 *
 * @package pym-embeds
 */

namespace INN\PymEmbeds\Info;

/**
 * Create the option page
 *
 * @since 1.3.2.1
 */
function register_options_page() {
	add_submenu_page(
		'tools.php',
		__( 'Pym.js Embeds Plugin Information', 'pym-embeds' ), // title of page
		__( 'Pym.js Embeds Info', 'pym-embeds' ), // menu text
		'edit_posts', // capability required
		'pym-embeds-info', // menu slug
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
		wp_kses_post( __( 'For information on how to use the block and shortcode provided by the Pym.js Embeds plugin, read the plugin\'s documentation <a href="https://github.com/INN/pym-shortcode/tree/master/docs">on GitHub</a>.', 'pym-embeds' ) )
	);

	printf(
		'<label for="pymsrc_url">%1$s</label>',
		esc_html__( 'Embeds on this site load Pym.js from:', 'pym-embeds' )
	);

	// A read-only field, so the URL is easy to select and copy.
	printf(
		'<input id="pymsrc_url" type="text" readonly value="%1$s" style="clear:both; width: 100%%; display: block;"/>',
		esc_attr( pym_pymsrc_default_url() )
	);

	printf(
		'<p>%1$s</p>',
		wp_kses_post( __( 'Graphics embedded with Pym.js load their own copy of Pym.js. See <a href="https://blog.apps.npr.org/pym.js/">NPR\'s Pym.js documentation</a> for how to set one up.', 'pym-embeds' ) )
	);
}
