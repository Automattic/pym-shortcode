<?php
/**
 * The [pym] shortcode and related functions
 */

/**
 * A shortcode to simplify the process of embedding articles using pym.js
 *
 * @param Array  $atts    the attributes passed in the shortcode.
 * @param String $content the enclosed content; should be empty for this shortcode.
 * @param String $tag     the shortcode tag.
 */
function pym_shortcode( $atts = array(), $content='', $tag='' ) {

	// generate an ID for this embed; necessary to prevent conflicts.
	global $pym_id;
	if ( ! isset( $pym_id ) ) {
		$pym_id = 0;
	} else {
		++$pym_id;
	}

	// Set us up the vars.
	$pymsrc = empty( $atts['pymsrc'] ) ? plugins_url( '/js/pym.v1.min.js', dirname( __FILE__ ) ) : $atts['pymsrc'];
	$pymoptions = empty( $atts['pymoptions'] ) ? '' : $atts['pymoptions'];
	$id = empty( $atts['id'] ) ? '' : esc_attr( $atts['id'] );
	$actual_id = empty( $id ) ? 'pym_' . $pym_id : $id;

	/**
	 * Filter pym_shortcode_default_class allows setting the default class on embeds
	 *
	 * @param String $default
	 * @return String the default class name
	 */
	$default_class = apply_filters( 'pym_shortcode_default_class', 'pym' );
	$class = empty( $atts['class'] ) ? '' : esc_attr( $atts['class'] );
	$align = empty( $atts['align'] ) ? '' : 'align' . esc_attr( $atts['align'] );
	$actual_classes = $default_class . ' ' . $align . ' ' . $class;

	$src = $atts['src'];

	ob_start();

	printf(
		'<div id="%1$s" class="%2$s"></div>',
		esc_attr( $actual_id ),
		esc_attr( $actual_classes )
	);

	// If this is the first one on the page, output the pym src
	// or if the pymsrc is set, output that.
	if ( 0 === $pym_id || ! empty( $atts['pymsrc'] ) ) {
		echo sprintf(
			'<script src="%s"></script>',
			esc_attr( $pymsrc )
		);
	}

	// Output the parent's scripts.
	echo '<script>';
	echo sprintf(
		'var pym_%1$s = new pym.Parent(\'%2$s\', \'%3$s\', {%4$s})',
		esc_js( $pym_id ),
		esc_js( $actual_id ),
		esc_js( $src ),
		$pymoptions
	);
	echo '</script>';

	// What is output to the page:
	$ret = ob_get_clean();
	return $ret;
}
add_shortcode( 'pym', 'pym_shortcode' );
