<?php
/**
 * The [pym] shortcode and related functions
 *
 * @package pym-shortcode
 */

/**
 * A shortcode to simplify the process of embedding articles using pym.js
 *
 * This function also powers the Pym Embed block output.
 *
 * @param Array  $atts    the attributes passed in the shortcode.
 * @param String $content the enclosed content; should be empty for this shortcode.
 * @param String $tag     the shortcode tag.
 * @uses pym_shortcode_script_footer_enqueue
 * @return String the embed HTML
 */
function pym_shortcode( $atts = array(), $content = '', $tag = '' ) {
	// generate an ID for this embed; necessary to prevent conflicts.
	global $pym_id;
	if ( ! isset( $pym_id ) ) {
		$pym_id = 0;
	} else {
		++$pym_id;
	}

	// Set us up the vars.
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
	$shortcode_class = empty( $atts['class'] ) ? '' : esc_attr( $atts['class'] );
	$gutenberg_class = empty( $atts['className'] ) ? '' : esc_attr( $atts['className'] );
	$align = empty( $atts['align'] ) ? '' : 'align' . esc_attr( $atts['align'] );
	$actual_classes = implode( ' ', array(
		$default_class,
		$shortcode_class,
		$gutenberg_class,
		$align,
	) );

	$src = $atts['src'];

	ob_start();

	printf(
		'<div id="%1$s" class="%2$s"></div>',
		esc_attr( $actual_id ),
		esc_attr( $actual_classes )
	);

	// What's the pymsrc for this shortcode?
	$pymsrc = empty( $atts['pymsrc'] ) ? pym_pymsrc_default_url() : $atts['pymsrc'];

	// If this is the first Pym element on the page, output the pymsrc script tag
	// or if the pymsrc is set, output that.
	if ( 0 === $pym_id || ! empty( $atts['pymsrc'] ) ) {
		$pymsrc_output = Pymsrc_Output::get_instance();
		$pymsrc_output->add( $pymsrc );
	}

	// Output the parent's scripts.
	pym_shortcode_script_footer_enqueue( array(
		'pym_id' => $pym_id,
		'actual_id' => $actual_id,
		'src' => $src,
		'pymoptions' => $pymoptions,
		// The following options are not necessary for the default
		// function pym_shortcode_script_footer_enqueue, but are provided
		// in case someone wants to do other things with their own version
		// of this function.
		// @link https://github.com/INN/pym-shortcode/issues/19
		'actual_classes' => $actual_classes,
		'pymsrc' => $pymsrc,
	) );

	// What is output to the page:
	$ret = ob_get_clean();
	return $ret;
}
add_shortcode( 'pym', 'pym_shortcode' );

/**
 * Given the necessary arguments for creating an embed's activation javascript, enqueue that script in the footer
 *
 * This function is pluggable. https://codex.wordpress.org/Pluggable_Functions
 * If your site requires a different activation script than the one provided
 * by this function, create a function in your site's theme or in a plugin
 * with this plugin's name, accepting the arguments passed to this function.
 *
 * @link https://github.com/INN/pym-shortcode/issues/19
 *
 * @param Array $args Has the following indices:
 *     - 'pym_id' Which Pym instance this is on the page, provided for
 *        informational purposes. In this function, the pym_id value is
 *        used as the variable name in `var pym_id = new pym.Parent(...);`
 *     - 'actual_id' the element ID used for the Pym container element,
 *        which is at this point set on the page and not changeable from
 *        this function. This is the first argument for `new pym.Parent()`.
 *     - 'src' the URL for the Pym child page. This is the second argument
 *        for `new pym.Parent()`.
 *     - 'pymoptions' The third argument for `pym.Parent()` See the xdomain
 *        argument in http://blog.apps.npr.org/pym.js/#example-block
 *     - 'actual_classes' The classes used on the Pym container element,
 *        provided to this function for informational purposes.
 *     - 'pymsrc' The URL from which Pym is to be loaded for this emebed,
 *        based on the shortcode/block options and the plugin settings.
 *
 * @since 1.3.2.1
 */
if ( ! function_exists( 'pym_shortcode_script_footer_enqueue' ) ) {
	function pym_shortcode_script_footer_enqueue( $args = array() ) {
		add_action(
			'wp_footer',
			function() use ( $args ) {
				// Output the parent's scripts.
				echo '<script>';
				echo sprintf(
					'var pym_%1$s = new pym.Parent(\'%2$s\', \'%3$s\', {%4$s})',
					esc_js( (string) $args['pym_id'] ),
					esc_js( $args['actual_id'] ),
					esc_js( $args['src'] ),
					$args['pymoptions']
				);
				echo '</script>';
				echo PHP_EOL; // for pretty printing of scripts in the footer.
			},
			20 // So that this comes after the pymsrc tag is output at priority 10.
		);
	}
}

/**
 * The default URL for pymsrc, as defined in plugin settings
 *
 * @since 1.3.2.1
 * @uses pym_pymsrc_local_url
 */
function pym_pymsrc_default_url() {
	return pym_pymsrc_local_url();
}

/**
 * The plugin-provided pymsrc url
 *
 * @since 1.3.2.1
 * @return string The URL for /wp-content/plugins/pym-shortcode/js/pym.v1.min.js
 */
function pym_pymsrc_local_url() {
	return plugins_url( '/js/pym.v1.min.js', dirname( __FILE__ ) );
}
