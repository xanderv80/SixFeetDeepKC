<?php
/**
 * Handles plugin installation upon activation.
 *
 * @package    WPForms
 * @author     WPForms
 * @since      1.0.0
 * @license    GPL-2.0+
 * @copyright  Copyright (c) 2016, WPForms LLC
*/
class WPForms_Install {

	/**
	 * Primary class constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		// When activated, trigger install method
		register_activation_hook( WPFORMS_PLUGIN_FILE, array( $this, 'install' ) );
	}

	/**
	 * Let's get the party started.
	 *
	 * @since 1.0.0
	 */
	public function install() {

		$wpforms_install             = new stdClass();
		$wpforms_install->preview    = new WPForms_Preview;

		// Form preview
		$wpforms_install->preview->form_preview_check();

		do_action( 'wpforms_install' );

		// Set current version, to be referenced in future updates
		update_option( 'wpforms_version', WPFORMS_VERSION );

		// Store the date when the initial activation was performed
		$type      = class_exists( 'WPForms_Lite' ) ? 'lite' : 'pro';
		$activated = get_option( 'wpforms_activated', array() );
		if ( empty( $activated[$type] ) ) {
			$activated[$type] = time();
			update_option( 'wpforms_activated', $activated );
		}

		// Abort so we only set the transient for single site installs
		if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
			return;
		}

		// Add transiet to trigger redirect to the Welcome screen
		set_transient( 'wpforms_activation_redirect', true, 30 );
	}

}
new WPForms_Install;