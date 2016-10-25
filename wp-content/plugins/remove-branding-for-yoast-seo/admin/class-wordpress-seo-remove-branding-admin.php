<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link http://suitpress.com
 * @since 1.0.0
 *
 * @package Plugin_Name
 * @subpackage Plugin_Name/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package Plugin_Name
 * @subpackage Plugin_Name/admin
 * @author SuitPress <developer@suitpress.com>
 */
class WPSEO_Remove_Branding_Admin {
	/**
	 * The slug of this plugin.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var string $plugin_slug The slug of this plugin.
	 */
	private $plugin_slug;

	/**
	 * The ID of this plugin.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * The object of this plugin.
	 *
	 * @since 1.0.0
	 * @access public
	 * @var object @settings_page
	 */
	public $settings_page;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 */
	public function __construct($plugin_slug, $plugin_name, $version) {
		$this->plugin_slug = $plugin_slug;
		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->load_dependencies();

		$this->settings_page = new WPSEO_Remove_Branding_Admin_Settings($this->plugin_slug, $this->plugin_name, $this->version);
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
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-wordpress-seo-remove-branding-admin-settings.php';
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_styles() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'assets/css/' . $this->plugin_name . '-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the javascript for the admin area.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_scripts() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		//wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'assets/js/' . $this->plugin_name . '-admin.js', array('jquery'), $this->version, false);
	}

	/**
	 * Get the current post type in the admin area.
	 *
	 * @since 1.0.0
	 */
	public function get_current_post_type() {
		global $post, $typenow, $current_screen;

		if ($post && $post->post_type) {
			return $post->post_type;
		} elseif ($typenow) {
			return $typenow;
		} elseif ($current_screen && $current_screen->post_type) {
			return $current_screen->post_type;
		} elseif (isset($_REQUEST['post_type'])) {
			return sanitize_key($_REQUEST['post_type']);
		} elseif ($_SERVER['REQUEST_URI'] == '/wp-admin/edit.php') {
			return 'post';
		}

		return null;
	}

	/**
	 * Hide plugin from WordPress admin plugin list.
	 *
	 * @since 1.0.0
	 */
	public function pre_current_hide_plugins($plugins) {
		if (!empty($plugins)) {
			global $wp_list_table;

			$plugins = is_array($plugins) ? $plugins : array($plugins);

			foreach ((array)$wp_list_table->items as $key => $val) {
				if (in_array($key, $plugins)) {
					unset($wp_list_table->items[$key]);
				}
			}
		}
	}

	/**
	 * Hide plugin from WordPress admin plugin list.
	 *
	 * @since 1.0.0
	 */
	public function wpseo_hide_plugins() {
		$this->pre_current_hide_plugins('wordpress-seo/wp-seo.php');
		$this->pre_current_hide_plugins('wordpress-seo/wp-seo-premium.php');
		$this->pre_current_hide_plugins('wordpress-seo-premium/wp-seo-premium.php');
		$this->pre_current_hide_plugins(plugin_basename(plugin_dir_path(dirname(__FILE__))) . '/wordpress-seo-remove-branding.php');
	}

	/**
	 * Disable plugin update notifications.
	 *
	 * @since 1.0.0
	 */
	public function remove_update_notification($value) {
		if (isset($value) && is_object($value)) {
			unset($value->response['wordpress-seo/wp-seo.php']);
			unset($value->response['wordpress-seo/wp-seo-premium.php']);
			unset($value->response['wordpress-seo-premium/wp-seo-premium.php']);
			unset($value->response[plugin_basename(plugin_dir_path(dirname(__FILE__))) . '/wordpress-seo-remove-branding.php']);
			return $value;
		}
	}

	/**
	 * Hide annoying notifications after each upgrade of Yoast SEO plugin and others admin notices.
	 *
	 * @since 1.0.0
	 */
	public function remove_yoast_notifications() {
		remove_action('admin_notices', array(Yoast_Notification_Center::get(), 'display_notifications'));
		remove_action('all_admin_notices', array(Yoast_Notification_Center::get(), 'display_notifications'));
	}

	/**
	 * Remove page analysis functionality.
	 *
	 * @since 1.0.0
	 */
	public function wpseo_use_page_analysis() {
		if (function_exists('wpseo_use_page_analysis')) {
			add_filter('wpseo_use_page_analysis', '__return_false');
		}
	}

	/**
	 * Remove admin menu links for the WordPress SEO Plugin.
	 *
	 * @since 1.0.0
	 */
	public function wpseo_admin_menu() {
		remove_menu_page('wpseo_dashboard');
	}

	/**
	 * Remove settings submenu in admin bar.
	 *
	 * @since 1.0.0
	 */
	public function wpseo_admin_bar_menu() {
		global $wp_admin_bar;

		// remove the admin bar menu
		$wp_admin_bar->remove_node('wpseo-menu');

		// remove WordPress SEO Settings
		//$wp_admin_bar->remove_node('wpseo-settings');

		// remove Keyword research information
		//$wp_admin_bar->remove_node('wpseo-kwresearch');
	}

	/**
	 * Remove a widget from the dashboard screen.
	 *
	 * @since 1.0.0
	 */
	public function wpseo_dashboard_setup() {
		remove_meta_box('wpseo-dashboard-overview', 'dashboard', 'side');
	}

	/**
	 * Remove the page analysis score in the publish box.
	 *
	 * @since 1.0.0
	 */
	public function wpseo_publish_box() {
		global $wp_filter;

		$current_screen = get_current_screen();
		$options = get_option($this->plugin_slug);
		$field = 'publish_box';

		if (!empty($options[$field]) && array_key_exists($current_screen->id, $options[$field])) {
			if (isset($wp_filter['post_submitbox_start']['10'])) {
				foreach ($wp_filter['post_submitbox_start']['10'] as $idx => $data) {
					$function = $data['function'][0];
					if (is_object($function) && is_a($function, 'WPSEO_Metabox')) {
						remove_action('post_submitbox_start', array($function, 'publish_box'));
					}
				}
			}
		}
	}

	/**
	 * Removes a meta box or any other element from a particular post edit screen of a given post type.
	 *
	 * @since 1.0.0
	 */
	public function wpseo_remove_metabox() {
		$options = get_option($this->plugin_slug);
		$field = 'meta_box';

		if (!empty($options[$field])) {
			foreach ($options[$field] as $post_type => $value) {
				remove_meta_box('wpseo_meta', $post_type, 'normal');
			}
		}
		/*
		$args = array(
			'public' => true
		);

		$output = 'names';
		$operator = 'and';


		$post_types = get_post_types($args, $output, $operator);

		foreach ($post_types as $post_type) {
			remove_meta_box('wpseo_meta', $post_type, 'normal');
		}
		*/
	}

	/**
	 * Ignore WordPress SEO Tour.
	 *
	 * @since 1.0.0
	 */
	public function wpseo_ignore_tour() {
		update_user_meta(get_current_user_id(), 'wpseo_ignore_tour', true);
	}
}