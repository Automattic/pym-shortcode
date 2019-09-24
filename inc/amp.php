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
	} elseif ( 'pym-shortcode/pym' === $block['blockName'] ) {
		$pym_src = $block['attrs']['src'];
	} else {
		return $output;
	}

	return get_pym_ampiframe( $pym_src );
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

	return get_pym_ampiframe( $attributes['src'] );
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
function get_pym_ampiframe( $src ) {
	$src_domain_parts  = parse_url( $src );
	$site_domain_parts = parse_url( get_site_url() );

	if ( ! $src_domain_parts ) {
		return '';
	}

	$sandbox = 'allow-scripts';
	if ( strcasecmp( $src_domain_parts['host'], $site_domain_parts['host'] ) ) {
		$sandbox .= ' allow-same-origin';
	}

	ob_start();
	?>
	<amp-iframe 
		src='<?php echo esc_url( $src ); ?>'
		layout='responsive'
		width='1'
		height='1'
		sandbox='<?php echo esc_attr( $sandbox ); ?>'
		frameborder='0'
		resizable
	>
		<div 
			overflow 
			tabindex=0 
			aria-label='<?php esc_attr_e( 'Load interactive graphic', 'pym-embeds' ); ?>'
			placeholder
			style='width:100%; text-align:center; padding-top:50%; background:rgba(0,0,0,.7); color:#FFF; font-weight:bold'
		>
			<?php esc_html_e( 'Load interactive graphic', 'pym-embeds' ); ?>
		</div>
	</amp-iframe>
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