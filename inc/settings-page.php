<?php
/**
 * The settings page for this plugin.
 *
 * @package pym-embeds
 */

namespace INN\PymEmbeds\Settings;

/**
 * Function to return the option group name.
 *
 * @return string The option group name.
 * @since 1.3.2.1
 */
function option_group() {
	return 'pym_embeds';
}

/**
 * Function to return the option key under which this plugin's settings will be stored
 *
 * Don't change this capriciously.
 *
 * @return string The option_key for the wp_options table
 * @since 1.3.2.1
 */
function option_key() {
	return 'pym_embeds';
}

/**
 * Function to return the settings section
 *
 * @since 1.3.2.1
 * @return string The settings_section
 */
function settings_section() {
	return 'pym-embed-settings';
}

/**
 * Function to return the settings page slug
 *
 * @since 1.3.2.1
 * @return string the settings_page
 */
function settings_page() {
	return 'pym-embed-settings';
}
/**
 * Create the option page
 *
 * @since 1.3.2.1
 */
function register_options_page() {
	add_submenu_page(
		'options-general.php',
		__( 'Pym.js Embeds Plugin Settings', 'pym-shortcode' ), // title of page
		__( 'Pym.js Embeds Settings', 'pym-shortcode' ), // menu text
		'manage_options', // capability required
		settings_page(), // menu slug
		__NAMESPACE__ . '\options_page_callback' // callback for options page display.
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
	// check capabilities.
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You do not have sufficient permissions to access the Pym.js Embeds plugin\'s settings.', 'pym-shortcode' ) );
		return;
	}

	settings_errors( 'pym_messages' );

	printf(
		'<h1>%1$s</h1>',
		esc_html( get_admin_page_title() )
	);

	?>
		<form action="options.php" method="post">
			<?php
				settings_fields( option_group() );
				do_settings_sections( settings_section() );
				submit_button( esc_html__( 'Save settings', 'pym-shortcode' ) );
			?>
		</form>
	<?php
}

/**
 * Register our settings
 *
 * @since 1.3.2.1
 */
function admin_init() {
	register_setting(
		option_group(),
		option_key(),
		array(
			'sanitize_callback' => __NAMESPACE__ . '\sanitize_callback',
		)
	);

	add_settings_section(
		settings_section(),
		__( 'Pym.js Source Settings', 'pym-shortcode' ),
		__NAMESPACE__ . '\pym_settings_section_callback',
		settings_page()
	);

	add_settings_field(
		'default_pymsrc',
		__( 'Default pymsrc', 'pym-shortcode' ),
		__NAMESPACE__ . '\field_default_pymsrc',
		settings_page(), // menu slug of this page.
		settings_section(), // settings section slug.
		array(
			'label_for' => 'default_pymsrc',
		)
	);

	add_settings_field(
		'override_pymsrc',
		__( 'Override pymsrc', 'pym-shortcode' ),
		__NAMESPACE__ . '\field_override_pymsrc',
		settings_page(), // menu slug of this page.
		settings_section(), // settings section slug.
		array(
			'label_for' => 'override_pymsrc',
		)
	);
}
add_action( 'admin_init', __NAMESPACE__ . '\admin_init' );

/**
 * Settings section callback
 *
 * Does nothing.
 *
 * @param Array $args Arguments passed to the section callback.
 */
function pym_settings_section_callback( $args ) {
	printf(
		'<p>%1$s</p>',
		__( 'The Pym.js JavaScript library can be provided from many sources. By default, shortcodes and blocks will use a copy of Pym.js hosted on your website to power embeds. For more information about changing the Pym.js source URL, referred to as \'pymsrc\', please <a href="https://github.com/INN/pym-shortcode/blob/master/docs/readme.md">read this plugin\'s documentation</a>.', 'pym-shortcode' )
	);
}

/**
 * Sanitization callback for the option_value.
 *
 * If the default_pymsrc isn't a valid URL or is the pym_pymsrc_local_url, blank it.
 * If the override_pymsrc isn't 'on' indicating it's checked, blank it.
 *
 * @since 1.3.2.1
 * @param Mixed $value The setting.
 * @return Array The sanitized setting
 * @uses pym_pymsrc_local_url
 * @uses pym_plugin_version
 */
function sanitize_callback( $value ) {
	error_log(var_export( $value, true));
	$new_value = array();

	$proposed_pymsrc = wp_http_validate_url( $value['default_pymsrc'] );
	if ( pym_pymsrc_local_url() === $proposed_pymsrc ) {
		$proposed_pymsrc = null;
	}
	$new_value['default_pymsrc'] = ! empty( $proposed_pymsrc ) ? $proposed_pymsrc : null;

	$new_value['override_pymsrc'] = ( isset( $value['override_pymsrc'] ) && 'on' === $value['override_pymsrc'] ) ? 'on': null;

	$new_value['version'] = pym_plugin_version();

	return $new_value;
}

/**
 * The field for the default Pymsrc
 *
 * @param Array $args The arguments passed to the settings field callback.
 */
function field_default_pymsrc( $args ) {
	$settings = get_option( option_key() );
	$id = isset( $args['label_for'] ) ? $args['label_for'] : 'default_pymsrc';
	$id = option_key() . '[' . $id . ']';

	$url = isset( $settings['default_pymsrc'] ) ? $settings['default_pymsrc'] : '';
	printf(
		'<input name="%1$s" style="width: 100%%;" value="%2$s" type="url" />',
		esc_attr( $id ),
		esc_attr( $url )
	);

	printf(
		'<label for="%1$s" style="display:block;clear:both; margin-top:0.5em;">%2$s</label>',
		esc_attr( $id ),
		wp_kses_post( __( 'This URL is where Pym.js will be loaded from for all embeds that do not set a pymsrc in the shortcode attributes or block settings. NPR and the Pym.js Embed plugin maintainers recommend that you use the NPR-provided CDN for this purpose: <code>https://pym.nprapps.org/pym.v1.min.js</code>', 'pym-shortcode' ) )
	);
	printf(
		'<label for="%1$s" style="display:block;clear:both; margin-top:0.5em;">%2$s</label>',
		esc_attr( $id ),
		sprintf(
			// translators: %1$s is a bare URL.
			wp_kses_post( __( 'If no pymsrc URL is set here, then the plugin-provided copy of Pym.js will be used as the default: <code>%1$s</code>', 'pym-shortcode' ) ),
			esc_html( pym_pymsrc_local_url() )
		)
	);
}

/**
 * The checkbox to force all embeds to use the default
 *
 * @param Array $args The arguments passed to the settings field callback.
 */
function field_override_pymsrc( $args ) {
	$settings = get_option( option_key() );
	$id = isset( $args['label_for'] ) ? $args['label_for'] : 'override_pymsrc';
	$id = option_key() . '[' . $id . ']';

	$value = isset( $settings['override_pymsrc'] ) ? $settings['override_pymsrc'] : '';
	printf(
		'<input name="%1$s" style="" %2$s type="checkbox" />',
		esc_attr( $id ),
		checked( $value, 'on', false )
	);

	printf(
		'<label for="%1$s" style="display:block;clear:both; margin-top:0.5em;">%2$s</label>',
		esc_attr( $id ),
		esc_html__( 'Checking this box means that every Pym.js embed will use the default pymsrc URL, ignoring the pymsrc URL set in the embed\'s shortcode attributes or block settings. We recommend that you check this box after setting the default pymsrc URL to the CDN-provided copy of the library.', 'pym-shortcode' )
	);
}
