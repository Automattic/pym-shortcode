<?php
/*
Plugin Name: Pym Shortcode
Plugin URI: https://github.com/INN/pym-shortcode
Description: Adds a [pym src=""] shortcode to simplify use of NPR's Pym.js
Version: 1.3.2
Author: The INN Nerds
Author URI: http://nerds.inn.org/
License: GPL Version 2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: pym_shortcode
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$includes = array(
	'/inc/block.php',
	'/inc/shortcode.php',
	'/inc/class-pymsrc-output.php',
);
foreach ( $includes as $include ) {
	if ( 0 === validate_file( dirname( __FILE__ ) . $include ) ) {
		require_once( dirname( __FILE__ ) . $include );
	}
}
