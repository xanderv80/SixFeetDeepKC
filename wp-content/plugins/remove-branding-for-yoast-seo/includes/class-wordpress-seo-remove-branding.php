<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link http://suitpress.com
 * @since 1.0.0
 *
 * @package Plugin_Name
 * @subpackage Plugin_Name/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since 1.0.0
 * @package Plugin_Name
 * @subpackage Plugin_Name/includes
 * @author SuitPress <developer@suitpress.com>
 */
class WPSEO_Remove_Branding {
	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var Plugin_Name_Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string $plugin_slug The string used to uniquely identify this plugin.
	 */
	protected $plugin_slug;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string $version The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->plugin_slug = 'wordpress_seo_remove_branding';
		$this->plugin_name = 'wordpress-seo-remove-branding';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Plugin_Name_Loader. Orchestrates the hooks of the plugin.
	 * - Plugin_Name_i18n. Defines internationalization functionality.
	 * - Plugin_Name_Admin. Defines all hooks for the admin area.
	 * - Plugin_Name_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function load_dependencies() {
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wordpress-seo-remove-branding-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wordpress-seo-remove-branding-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-wordpress-seo-remove-branding-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-wordpress-seo-remove-branding-public.php';

		$this->loader = new WPSEO_Remove_Branding_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Plugin_Name_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function set_locale() {
		$plugin_i18n = new WPSEO_Remove_Branding_i18n();
		$plugin_i18n->set_domain($this->get_plugin_name());

		$this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function define_admin_hooks() {
		$plugin_admin = new WPSEO_Remove_Branding_Admin($this->get_plugin_slug(), $this->get_plugin_name(), $this->get_version());
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');

		if (current_user_can('manage_options')) {
			$this->loader->add_action('admin_menu', $plugin_admin->settings_page, 'admin_menu');
			$this->loader->add_action('admin_init', $plugin_admin->settings_page, 'register_setting');
		}

		if (!current_user_can('manage_options')) {
			$options = get_option($this->plugin_slug);

			$field = 'current_hide_plugin';
			if (!empty($options[$field])) {
				$this->loader->add_action('pre_current_active_plugins', $plugin_admin, 'wpseo_hide_plugins');
			}

			$field = 'notification';
			if (!empty($options[$field])) {
				$this->loader->add_filter('site_transient_update_plugins', $plugin_admin, 'remove_update_notification');
				$this->loader->add_action('admin_init', $plugin_admin, 'remove_yoast_notifications');
			}

			$field = 'admin_menu';
			if (!empty($options[$field])) {
				$this->loader->add_action('admin_menu', $plugin_admin, 'wpseo_admin_menu');
			}

			$field = 'admin_bar';
			if (!empty($options[$field])) {
				$this->loader->add_action('admin_bar_menu', $plugin_admin, 'wpseo_admin_bar_menu', 96);
			}

			$field = 'dashboard';
			if (!empty($options[$field])) {
				$this->loader->add_action('wp_dashboard_setup', $plugin_admin, 'wpseo_dashboard_setup');
			}

			$field = 'page_analysis';
			if (!empty($options[$field])) {
				$this->loader->add_action('wpseo_use_page_analysis', $plugin_admin, 'wpseo_use_page_analysis');
			}

			$this->loader->add_action('admin_init', $plugin_admin, 'wpseo_ignore_tour', 999);
			$this->loader->add_action('add_meta_boxes', $plugin_admin, 'wpseo_remove_metabox', 11);
			$this->loader->add_action('current_screen', $plugin_admin, 'wpseo_publish_box', 11);
		}
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function define_public_hooks() {
		$plugin_public = new WPSEO_Remove_Branding_Public($this->get_plugin_slug(), $this->get_plugin_name(), $this->get_version());
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
		$this->loader->add_action('template_redirect', $plugin_public, 'wpseo_buffer_start', -1);
		$this->loader->add_action('get_header', $plugin_public, 'wpseo_buffer_start');
		$this->loader->add_action('wp_footer', $plugin_public, 'wpseo_buffer_end', 999);
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since 1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since 1.0.0
	 * @return string The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The slug of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since 1.0.0
	 * @return string The slug of the plugin.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since 1.0.0
	 * @return Plugin_Name_Loader Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since 1.0.0
	 * @return string The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}