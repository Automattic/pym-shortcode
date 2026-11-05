<?php
/**
 * Notice for sites that saved settings before 3.0.0, when the settings page was removed.
 *
 * @package pym-embeds
 */

namespace INN\PymEmbeds\Settings;

/**
 * Function to return the option key of this plugin's pre-3.0.0 settings.
 *
 * The 3.0.0 notice reads and deletes this option, and code outside the plugin
 * may read it too. Don't change this capriciously.
 *
 * @return string The option_key for the wp_options table
 * @since 1.3.2.1
 */
function option_key() {
	return 'pym_embeds';
}

/**
 * Function to return the action name used to dismiss the notice.
 *
 * @return string The admin-post action name.
 * @since 3.0.0
 */
function dismiss_action() {
	return 'pym_embeds_dismiss_settings_notice';
}

/**
 * Tell administrators that the saved settings no longer apply.
 *
 * Shows only while the old option still exists in the database. Dismissing the
 * notice deletes the option, so sites that never saved settings never see it.
 *
 * @since 3.0.0
 */
function settings_notice() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$settings = get_option( option_key() );
	if ( false === $settings ) {
		return;
	}

	$url = ( is_array( $settings ) && isset( $settings['default_pymsrc'] ) && is_string( $settings['default_pymsrc'] ) ) ? $settings['default_pymsrc'] : '';

	if ( '' !== $url ) {
		$message = sprintf(
			/* translators: %s is the URL that was saved as the "Default pymsrc" setting. */
			__( '<strong>Pym.js Embeds 3.0.0:</strong> Embeds now load Pym.js from one site-wide URL: this plugin\'s own copy, unless a developer changes it with the <code>pym_shortcode_pymsrc</code> filter. This update removes the plugin\'s settings page, so the "Default pymsrc" URL saved there (<code>%s</code>) no longer applies.', 'pym-embeds' ),
			esc_html( $url )
		);
	} else {
		$message = __( '<strong>Pym.js Embeds 3.0.0:</strong> Embeds now load Pym.js from one site-wide URL: this plugin\'s own copy, unless a developer changes it with the <code>pym_shortcode_pymsrc</code> filter. This update removes the plugin\'s settings page, so the settings saved there no longer apply.', 'pym-embeds' );
	}

	$dismiss_url = wp_nonce_url( admin_url( 'admin-post.php?action=' . dismiss_action() ), dismiss_action() );

	// No is-dismissible class: its X button only hides the notice until the next page load.
	printf(
		'<div class="notice notice-warning"><p>%1$s</p><p><a class="button" href="%2$s">%3$s</a></p></div>',
		wp_kses_post( $message ),
		esc_url( $dismiss_url ),
		esc_html__( 'Dismiss this notice', 'pym-embeds' )
	);
}
add_action( 'admin_notices', __NAMESPACE__ . '\settings_notice' );

/**
 * Delete the old option when an administrator dismisses the notice.
 *
 * @since 3.0.0
 */
function dismiss_settings_notice() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die(
			esc_html__( 'You do not have sufficient permissions to dismiss this notice.', 'pym-embeds' ),
			'',
			array( 'response' => 403 )
		);
	}

	check_admin_referer( dismiss_action() );

	delete_option( option_key() );

	wp_safe_redirect( wp_get_referer() ? wp_get_referer() : admin_url() );
	exit;
}
add_action( 'admin_post_' . dismiss_action(), __NAMESPACE__ . '\dismiss_settings_notice' );
