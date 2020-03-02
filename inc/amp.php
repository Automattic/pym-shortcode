<?php
/**
 * AMP-compatibility for this plugin.
 *
 * @package pym-embeds
 */

namespace INN\PymEmbeds\AMP;

/**
 * Handle pym.js blocks and raw HTML blocks on AMP pages.
 *
 * @since  1.3.2.3
 * @param  string $output HTML block output.
 * @param  array  $block Block attributes and information.
 * @return string HTML block output.
 */
function convert_block_to_ampiframe( $output, $block ) {
	if ( ! is_amp() ) {
		return $output;
	}

	if ( 'core/html' === $block['blockName'] ) {
		$pym_src_regex = '~data-pym-src=[\'"]([^\'"]*)~';
		$is_match      = preg_match( $pym_src_regex, $block['innerHTML'], $matches );
		if ( ! $is_match ) {
			return $output;
		}

		$pym_src = $matches[1];
		return get_pym_ampiframe( $pym_src );
	} elseif ( 'pym-shortcode/pym' === $block['blockName'] ) {
		$pym_src = $block['attrs']['src'];
		return get_pym_ampiframe( $pym_src, $block['attrs'] );		
	}

	return $output;
}
add_action( 'render_block', __NAMESPACE__ . '\convert_block_to_ampiframe', 10, 2 );

/**
 * Handle pym.js shortcode on AMP pages.
 *
 * @since  1.3.2.3
 * @param  string $output HTML shortcode output.
 * @param  string $tag Shortcode tag.
 * @param  array  $attributes Shortcode attributes.
 * @return string HTML shortcode output.
 */
function convert_shortcode_to_ampiframe( $output, $tag, $attributes ) {
	if ( ! is_amp() || 'pym' !== $tag ) {
		return $output;
	}

	if ( empty( $attributes['src'] ) ) {
		return $output;
	}

	return get_pym_ampiframe( $attributes['src'], $attributes );
}
add_action( 'do_shortcode_tag', __NAMESPACE__ . '\convert_shortcode_to_ampiframe', 10, 3 );

/**
 * Build an amp-iframe out of pym.js iframe source. This is a pretty solid solution until native pym.js AMP compatibility.
 *
 * @since  1.3.2.3
 * @see    https://github.com/ampproject/amphtml/issues/22714
 * @param  string $src iframe src.
 * @return string AMP-iframe HTML.
 */
function get_pym_ampiframe( $src, $atts = array() ) {
	$src_domain_parts  = parse_url( $src );
	$site_domain_parts = parse_url( get_site_url() );

	if ( ! $src_domain_parts ) {
		return '';
	}


	/**
	 * Filter pym_shortcode_default_class allows setting the default class on embeds.
	 *
	 * @param String $default
	 * @return String the default class name
	 */
	$default_class   = apply_filters( 'pym_shortcode_default_class', 'pym' );
	$shortcode_class = empty( $atts['class'] ) ? '' : esc_attr( $atts['class'] );
	$gutenberg_class = empty( $atts['className'] ) ? '' : esc_attr( $atts['className'] );
	$align           = empty( $atts['align'] ) ? '' : 'align' . esc_attr( $atts['align'] );
	$actual_classes  = implode( ' ', array(
		$default_class,
		$shortcode_class,
		$gutenberg_class,
		$align,
	) );
	$id              = empty( $atts['id'] ) ? '' : esc_attr( $atts['id'] );

	$sandbox = 'allow-scripts';
	if ( strcasecmp( $src_domain_parts['host'], $site_domain_parts['host'] ) ) {
		$sandbox .= ' allow-same-origin';
	}

	ob_start();
	?>
	<div class='<?php echo esc_attr( $actual_classes ); ?>' id='<?php echo esc_attr( $id ); ?>'>
		<amp-iframe 
			src='<?php echo esc_url( $src ); ?>'
			layout='fixed-height'
			height='200'
			sandbox='<?php echo esc_attr( $sandbox ); ?>'
			frameborder='0'
			resizable
		>
			<div placeholder><?php esc_html_e( 'Interactive graphic', 'pym-embeds' ); ?></div>
			<div 
				overflow 
				tabindex=0 
				aria-label='<?php esc_attr_e( 'Load interactive graphic', 'pym-embeds' ); ?>'
				style='padding: .5em; background:rgba(0,0,0,.7); color:#FFF; font-weight:bold;'
			>
				<?php esc_html_e( 'Load interactive graphic', 'pym-embeds' ); ?>
			</div>
		</amp-iframe>
	</div>
	<?php

	return ob_get_clean();
}

/**
 * Check whether the current page is an AMP page.
 *
 * @since  1.3.2.3
 * @return bool True if AMP page.
 */
function is_amp() {
	return function_exists( 'is_amp_endpoint' ) && is_amp_endpoint();
}
