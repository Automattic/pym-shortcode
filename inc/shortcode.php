<?php
/**
 * The [pym] shortcode and related functions
 *
 * @package pym-embeds
 */

 use INN\PymEmbeds\Settings\option_key;

/**
 * A shortcode to simplify the process of embedding articles using pym.js
 *
 * This function also powers the Pym.js Embed block output in Gutenberg,
 * as the render callback for a dynamic block.
 *
 * @param Array  $atts    the attributes passed in the shortcode.
 * @param String $content the enclosed content; should be empty for this shortcode.
 * @param String $tag     the shortcode tag.
 * @uses pym_shortcode_script_footer_enqueue
 * @uses pym_pymsrc_default_url
 * @uses \INN\PymEmbeds\Settings\option_key()
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
	$pymoptions = empty( $atts['pymoptions'] ) ? array() : pym_shortcode_parse_pymoptions( $atts['pymoptions'] );
	$id = empty( $atts['id'] ) ? '' : esc_attr( $atts['id'] );
	$actual_id = empty( $id ) ? 'pym_' . $pym_id : $id;

	/**
	 * Filter pym_shortcode_default_class allows setting the default class on embeds.
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

	$src = '';
	if ( ! empty( $atts['src'] ) ) {
		$src = esc_url_raw( $atts['src'] );
	}

	ob_start();

	printf(
		'<div id="%1$s" class="%2$s"></div>',
		esc_attr( $actual_id ),
		esc_attr( $actual_classes )
	);

	// What's the pymsrc for this shortcode?
	if (
		pym_maybe_override_pymsrc() // if the box to override has been checked...
		|| empty( $atts['pymsrc'] ) // if there is no specified pymsrc...
		|| ! wp_http_validate_url( $atts['pymsrc'] ) // if the specified pymsrc is not a safe URL...
	) {
		$pymsrc = pym_pymsrc_default_url(); // use the default URL.
	} else {
		$pymsrc = $atts['pymsrc'];
	}

	// If this is the first Pym.js element on the page,
	// register the default pymsrc script tag for output.
	//
	// Or, if the pymsrc is set, register that specific pymsrc for output.
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
 *     - 'pym_id' Which Pym.js embed instance this is on the page, provided for
 *        informational purposes. In this function, the pym_id value is
 *        used as the variable name in `var pym_id = new pym.Parent(...);`
 *     - 'actual_id' the element ID used for the Pym.js container element,
 *        which is at this point set on the page and not changeable from
 *        this function. This is the first argument for `new pym.Parent()`.
 *     - 'src' the URL for the Pym.js child page. This is the second argument
 *        for `new pym.Parent()`.
 *     - 'pymoptions' Associative array of sanitized options to pass as the
 *        third argument to `pym.Parent()`. Only known Pym.js parent options
 *        with primitive values (string/bool/number) are included; see
 *        pym_shortcode_parse_pymoptions() for the allowlist.
 *     - 'actual_classes' The classes used on the Pym.js container element,
 *        provided to this function for informational purposes.
 *     - 'pymsrc' The URL from which Pym.js is to be loaded for this emebed,
 *        based on the shortcode/block options and the plugin settings.
 *
 * @since 1.3.2.1
 */
if ( ! function_exists( 'pym_shortcode_script_footer_enqueue' ) ) {
	function pym_shortcode_script_footer_enqueue( $args = array() ) {
		add_action(
			'wp_footer',
			function() use ( $args ) {
				$options = isset( $args['pymoptions'] ) && is_array( $args['pymoptions'] )
					? $args['pymoptions']
					: array();
				// JSON-encode the options object with flags that make the result
				// safe to embed inside an inline <script> tag without further
				// escaping (no raw `<`, `>`, `&`, `'`, or `"`).
				$options_json = wp_json_encode(
					(object) $options,
					JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
				);
				if ( false === $options_json ) {
					$options_json = '{}';
				}
				// Output the parent's scripts.
				echo '<script>';
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- $options_json is wp_json_encode() output with HTML-tag/amp/quote escapes; other args are esc_js()'d.
				echo sprintf(
					'var pym_%1$s = new pym.Parent(\'%2$s\', \'%3$s\', %4$s)',
					esc_js( (string) $args['pym_id'] ),
					esc_js( $args['actual_id'] ),
					esc_js( $args['src'] ),
					$options_json
				);
				echo '</script>';
				echo PHP_EOL; // for pretty printing of scripts in the footer.
			},
			20 // So that this comes after the pymsrc tag is output at priority 10.
		);
	}
}

/**
 * Whether to force use of the default pymsrc URL.
 *
 * @since 1.3.2.1
 * @uses \INN\PymEmbeds\Settings\option_key()
 * @return bool Whether to force use of the default URL.
 */
function pym_maybe_override_pymsrc() {
	$settings = get_option( \INN\PymEmbeds\Settings\option_key() );
	if ( isset( $settings['override_pymsrc'] ) && 'on' === $settings['override_pymsrc'] ) {
		return true;
	}
	return false;
}

/**
 * The default URL for pymsrc, as defined in plugin settings
 *
 * @since 1.3.2.1
 * @uses pym_pymsrc_local_url
 */
function pym_pymsrc_default_url() {
	$settings = get_option( \INN\PymEmbeds\Settings\option_key() );
	if ( isset ( $settings['default_pymsrc'] ) ) {
		if ( wp_http_validate_url( $settings['default_pymsrc'] ) ) {
			return $settings['default_pymsrc'];
		}
	}
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

/**
 * Parse the user-supplied `pymoptions` attribute into a sanitized array.
 *
 * Historically `pymoptions` accepted a raw JavaScript object body (without the
 * surrounding `{}`), e.g. ` xdomain: '*\.npr\.org' `, and was inlined verbatim
 * into a `<script>` tag. That made the attribute a stored-XSS sink any time a
 * user who can author content also controls a post that reaches a privileged
 * viewer.
 *
 * To preserve the documented attribute syntax while removing the sink, this
 * function tokenises the string into key/value pairs and accepts only known
 * Pym.js Parent options whose values are primitive (string, boolean, number).
 * Anything else is dropped silently. The returned array is JSON-encoded at
 * output time, so the result is always a safe object literal.
 *
 * The allowlist mirrors the Pym.js library's own autoInit type map.
 *
 * @since 1.3.2.5
 * @param string $raw The raw `pymoptions` attribute value.
 * @return array Sanitized options keyed by Pym.js option name.
 */
function pym_shortcode_parse_pymoptions( $raw ) {
	$schema = array(
		'xdomain'         => 'string',
		'title'           => 'string',
		'name'            => 'string',
		'id'              => 'string',
		'sandbox'         => 'string',
		'parenturlparam'  => 'string',
		'parenturlvalue'  => 'string',
		'allowfullscreen' => 'boolean',
		'optionalparams'  => 'boolean',
		'trackscroll'     => 'boolean',
		'scrollwait'      => 'number',
	);

	$raw = trim( (string) $raw );
	if ( '' === $raw ) {
		return array();
	}

	// Tolerate (but do not require) surrounding braces.
	if ( '{' === $raw[0] && '}' === substr( $raw, -1 ) ) {
		$raw = substr( $raw, 1, -1 );
	}

	$pairs       = array();
	$buffer      = '';
	$in_string   = false;
	$string_char = '';
	$len         = strlen( $raw );
	for ( $i = 0; $i < $len; $i++ ) {
		$char = $raw[ $i ];
		if ( $in_string ) {
			$buffer .= $char;
			if ( '\\' === $char && $i + 1 < $len ) {
				$buffer .= $raw[ ++$i ];
				continue;
			}
			if ( $char === $string_char ) {
				$in_string = false;
			}
			continue;
		}
		if ( "'" === $char || '"' === $char ) {
			$in_string   = true;
			$string_char = $char;
			$buffer     .= $char;
			continue;
		}
		if ( ',' === $char ) {
			$pairs[] = $buffer;
			$buffer  = '';
			continue;
		}
		$buffer .= $char;
	}
	if ( '' !== trim( $buffer ) ) {
		$pairs[] = $buffer;
	}

	$out = array();
	foreach ( $pairs as $pair ) {
		// Find the first top-level `:` to split key from value.
		$colon       = -1;
		$in_string   = false;
		$string_char = '';
		$pair_len    = strlen( $pair );
		for ( $j = 0; $j < $pair_len; $j++ ) {
			$char = $pair[ $j ];
			if ( $in_string ) {
				if ( '\\' === $char && $j + 1 < $pair_len ) {
					$j++;
					continue;
				}
				if ( $char === $string_char ) {
					$in_string = false;
				}
				continue;
			}
			if ( "'" === $char || '"' === $char ) {
				$in_string   = true;
				$string_char = $char;
				continue;
			}
			if ( ':' === $char ) {
				$colon = $j;
				break;
			}
		}
		if ( $colon < 0 ) {
			continue;
		}
		$key = trim( substr( $pair, 0, $colon ) );
		$raw_value = trim( substr( $pair, $colon + 1 ) );

		// Strip optional surrounding quotes from the key.
		if ( strlen( $key ) >= 2 ) {
			$first = $key[0];
			$last  = substr( $key, -1 );
			if ( ( "'" === $first && "'" === $last ) || ( '"' === $first && '"' === $last ) ) {
				$key = substr( $key, 1, -1 );
			}
		}

		if ( ! isset( $schema[ $key ] ) ) {
			continue;
		}

		$parsed = pym_shortcode_parse_pymoption_value( $raw_value, $schema[ $key ] );
		if ( null === $parsed ) {
			continue;
		}
		$out[ $key ] = $parsed['value'];
	}
	return $out;
}

/**
 * Parse a single `pymoptions` value token into a typed primitive.
 *
 * @since 1.3.2.5
 * @param string $value    The raw value substring (already trimmed).
 * @param string $expected One of 'string', 'boolean', 'number'.
 * @return array|null `array( 'value' => mixed )` on success, null when the
 *                    value cannot be coerced safely.
 */
function pym_shortcode_parse_pymoption_value( $value, $expected ) {
	if ( '' === $value ) {
		return null;
	}

	if ( 'boolean' === $expected ) {
		if ( 'true' === $value ) {
			return array( 'value' => true );
		}
		if ( 'false' === $value ) {
			return array( 'value' => false );
		}
		return null;
	}

	if ( 'number' === $expected ) {
		if ( ! is_numeric( $value ) ) {
			return null;
		}
		if ( false === strpos( $value, '.' ) ) {
			return array( 'value' => (int) $value );
		}
		return array( 'value' => (float) $value );
	}

	// String: require a quoted literal so we never accept arbitrary JS identifiers.
	if ( strlen( $value ) < 2 ) {
		return null;
	}
	$first = $value[0];
	$last  = substr( $value, -1 );
	if ( ! ( ( "'" === $first && "'" === $last ) || ( '"' === $first && '"' === $last ) ) ) {
		return null;
	}
	$inner = substr( $value, 1, -1 );
	// Decode the JS-style backslash escapes the documentation suggests authors use.
	$inner = str_replace(
		array( '\\\\', '\\\'', '\\"', '\\n', '\\r', '\\t' ),
		array( '\\', '\'', '"', "\n", "\r", "\t" ),
		$inner
	);
	return array( 'value' => $inner );
}
