<?php
/**
 * The Gutenberg block for Pym.js embeds
 *
 * @package pym-embeds
 */

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * @see https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type/#enqueuing-block-scripts
 */
function pym_block_init() {
	if ( ! function_exists( 'register_block_type' ) ) {
		// Gutenberg is not active.
		return false;
	}

	$dir = dirname( dirname( __FILE__ ) );

	$block_js = 'js/block.js';
	wp_register_script(
		'pym-block-editor',
		plugins_url( $block_js, dirname( __FILE__ ) ),
		array(
			'wp-blocks',
			'wp-i18n',
			'wp-element',
			'wp-editor',
			'wp-components',
		),
		filemtime( "$dir/$block_js" )
	);

	$editor_css = 'css/editor.css';
	wp_register_style(
		'pym-block-editor',
		plugins_url( $editor_css, dirname( __FILE__ ) ),
		array(
			'wp-blocks',
		),
		filemtime( "$dir/$editor_css" )
	);

	register_block_type( 'pym-shortcode/pym', array(
		'attributes'    => array(
			'src' => array(
				'type' => 'string',
			),
			'pymsrc' => array(
				'type' => 'string',
			),
			'pymoptions' => array(
				'type' => 'string',
			),
			'id' => array(
				'type' => 'string',
			),
			'className' => array(
				'type' => 'string',
			),
			'align' => array(
				'type' => 'string',
			),
		),
		'editor_script'   => 'pym-block-editor',
		'editor_style'    => 'pym-block-editor',
		'style'           => 'pym-block',
		'render_callback' => 'pym_shortcode',
	) );
}
add_action( 'init', 'pym_block_init' );
