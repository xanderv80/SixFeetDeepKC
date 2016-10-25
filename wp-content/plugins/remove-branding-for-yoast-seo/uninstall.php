<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * @link http://suitpress.com
 * @since 1.0.0
 *
 * @package Plugin_Name
 */

// If uninstall not called from WordPress, then exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
	exit;
}

$option_name = 'wordpress_seo_remove_branding';
$options = get_option($option_name);
if (!empty($options['remove_option']) && $options['remove_option'] == 1) {
	// For site options
	delete_option($option_name);

	// For site options in multisite
	delete_site_option($option_name);
}