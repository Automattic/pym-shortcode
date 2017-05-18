<?php
/*
Plugin Name: Pym Shortcode
Plugin URI: https://github.com/INN/pym-shortcode
Description: Adds a [pym src=""] shortcode to simplify use of NPR's Pym.js
Version: 1.2.1
Author: The INN Nerds
Author URI: http://nerds.inn.org/
License: GPL Version 2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * A shortcode to simplify the process of embedding articles using pym.js
 */
function pym_shortcode( $atts, $context, $tag ) {

	// generate an ID for this embed, necessary to prevent conflicts
	global $pym_id;
	if ( ! isset( $pym_id ) ) {
		$pym_id = 0;
	} else {
		++$pym_id;
	}

	$pymsrc = empty( $atts['pymsrc'] ) ? plugins_url( '/js/pym.v1.min.js', __FILE__ ) : $atts['pymsrc'];
	$pymoptions = empty( $atts['pymoptions'] ) ? '' : $atts['pymoptions'];

	$src = $atts['src'];

	ob_start();

	echo '<div id="pym_' . $pym_id . '"></div>';

	// If this is the first one on the page, output the pym src
	// or if the pymsrc is set, output that.
	if ( 0 === $pym_id || ! empty( $atts['pymsrc'] ) ) {
		echo sprintf(
			'<script src="%s"></script>',
			$pymsrc
		);
	}

	// Output the parent's scripts
	echo '<script>';
	echo sprintf(
		'var pym_%1$s = new pym.Parent(\'%2$s\', \'%3$s\', {%4$s})',
		$pym_id,
		"pym_$pym_id",
		$src,
		$pymoptions
	);
	echo '</script>';

	// What is output to the page
	$ret = ob_get_clean();
	return $ret;
}
add_shortcode( 'pym', 'pym_shortcode' );
