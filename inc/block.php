<?php
/**
 * The Gutenberg block for Pym embeds
 *
 * @package pym-shortcode
 */

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * @see https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type/#enqueuing-block-scripts
 */
function pym_block_init() {
	$dir = dirname( dirname( __FILE__ ) );

	$block_js = 'js/block.js';
	wp_register_script(
		'pym-block-editor',
		plugins_url( $block_js, dirname( __FILE__ ) ),
		array(
			'wp-blocks',
			'wp-i18n',
			'wp-element',
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

	$style_css = 'css/style.css';
	wp_register_style(
		'pym-block',
		plugins_url( $style_css, dirname( __FILE__ ) ),
		array(
			'wp-blocks',
		),
		filemtime( "$dir/$style_css" )
	);

	register_block_type( 'pym-shortcode/pym', array(
		'editor_script' => 'pym-block-editor',
		'editor_style'  => 'pym-block-editor',
		'style'         => 'pym-block',
	) );
}
add_action( 'init', 'pym_block_init' );
