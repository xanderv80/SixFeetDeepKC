<?php
/**
 * Provide a dashboard view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link http://suitpress.com
 * @since 1.0.0
 *
 * @package Plugin_Name
 * @subpackage Plugin_Name/admin/partials
 */
?>
<div class="wrap">
	<h2><?php _e('Remove Branding for Yoast SEO', $this->plugin_name); ?></h2>
	<form action="options.php" method="post">
		<?php settings_fields($this->plugin_slug . '-group'); ?>
		<?php do_settings_sections($this->plugin_name); ?>
		<?php submit_button(); ?>
	</form>
</div>