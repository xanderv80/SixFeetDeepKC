<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link http://suitpress.com
 * @since 1.0.0
 * @package Plugin_Name
 *
 * @wordpress-plugin
 * Plugin Name: Remove Branding for Yoast SEO
 * Plugin URI: http://suitpress.com/plugins/remove-branding-for-yoast-seo/
 * Description: Remove the Yoast SEO plugin branding, and hide installed plugins from non-admin users.
 * Version: 1.1.0
 * Author: SuitPress
 * Author URI: http://suitpress.com/
 * License: GPLv2 or later
 * License URI: http://suitpress.com/licenses/
 * Text Domain: wordpress-seo-remove-branding
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

// Makes sure the plugin is defined before trying to use it.
if (!function_exists('is_plugin_inactive')) {
	require_once ABSPATH . '/wp-admin/includes/plugin.php';
}

// Load pluggable functions.
if (!function_exists('wp_get_current_user')) {
	require_once ABSPATH . WPINC . '/pluggable.php';
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_wpseo_remove_branding() {
	require_once plugin_dir_path(__FILE__) . 'includes/class-wordpress-seo-remove-branding-activator.php';
	WPSEO_Remove_Branding_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_wpseo_remove_branding() {
	require_once plugin_dir_path(__FILE__) . 'includes/class-wordpress-seo-remove-branding-deactivator.php';
	WPSEO_Remove_Branding_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_wpseo_remove_branding');
register_deactivation_hook(__FILE__, 'deactivate_wpseo_remove_branding');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require_once plugin_dir_path(__FILE__) . 'includes/class-wordpress-seo-remove-branding.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since 1.0.0
 */
function run_wpseo_remove_branding() {
	$class = new WPSEO_Remove_Branding();
	$class->run();
}

// Automatically deactivate itself if some conditions are not met.
if (defined('WPSEO_VERSION') || is_plugin_active('wordpress-seo/wp-seo.php') || is_plugin_active('wordpress-seo/wp-seo-premium.php') || is_plugin_active('wordpress-seo-premium/wp-seo-premium.php')) {
	run_wpseo_remove_branding();
} else {
	deactivate_plugins(plugin_basename(__FILE__));
}