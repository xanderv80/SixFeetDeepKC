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
class WPSEO_Remove_Branding_Admin_Settings {
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
	}

	/**
	 * Render checkbox content.
	 *
	 * @since 1.0.0
	 */
	public function render_checkbox_field($array) {
		$output = '<fieldset>';

		if (!empty($array['legend'])) {
			$output .= '<legend class="screen-reader-text"><span>' . $array['legend'] . '</span></legend>';
		}

		if (!empty($array['items'])) {
			foreach ($array['items'] as $key => $value) {
				$output .= '<label for="' . $value['id'] . '">';
				$output .= '<input type="checkbox" value="' . $value['value'] . '" id="' . $value['id'] . '" name="' . $value['name'] . '"' . $value['checked'] . ' />';
				$output .= $value['label'];
				$output .= '</label>';
				$output .= '<br>';
			}
		}

		if (!empty($array['description'])) {
				$output .= '<p class="description">' . $array['description'] . '</p>';
		}

		$output .= '</fieldset>';

		return $output;
	}

	/**
	 * Add extra submenus and menu options to the admin panel's menu structure.
	 *
	 * @since 1.0.0
	 */
	public function admin_menu() {
		add_options_page(__('Remove Branding for Yoast SEO', $this->plugin_name), __('Remove Branding for Yoast SEO', $this->plugin_name), 'manage_options', $this->plugin_name, array($this, 'add_options_page'));
	}

	/**
	 * Register a setting and its sanitization callback.
	 *
	 * @since 1.0.0
	 */
	public function register_setting() {
		register_setting($this->plugin_slug . '-group', $this->plugin_slug);

		add_settings_section('general_setting_section', __('General Settings', $this->plugin_name), array($this, 'general_setting_section_callback'), $this->plugin_name);
		add_settings_field('current_hide_plugin_field', __('Hide Plugin', $this->plugin_name), array($this, 'current_hide_plugin_field_callback'), $this->plugin_name, 'general_setting_section');
		add_settings_field('admin_menu_field', __('Remove Admin Menu', $this->plugin_name), array($this, 'admin_menu_field_callback'), $this->plugin_name, 'general_setting_section');
		add_settings_field('admin_bar_field', __('Remove Admin Bar', $this->plugin_name), array($this, 'admin_bar_field_callback'), $this->plugin_name, 'general_setting_section');
		add_settings_field('dashboard_field', __('Remove Dashboard Widget', $this->plugin_name), array($this, 'dashboard_field_callback'), $this->plugin_name, 'general_setting_section');
		add_settings_field('notification_field', __('Remove Notification', $this->plugin_name), array($this, 'notification_field_callback'), $this->plugin_name, 'general_setting_section');
		add_settings_field('meta_box_field', __('Remove SEO Meta Box', $this->plugin_name), array($this, 'meta_box_field_callback'), $this->plugin_name, 'general_setting_section');
		add_settings_field('publish_box_field', __('Remove SEO Traffic Light', $this->plugin_name), array($this, 'publish_box_field_callback'), $this->plugin_name, 'general_setting_section');
		add_settings_field('page_analysis_field', __('Remove SEO Page Analysis', $this->plugin_name), array($this, 'page_analysis_field_callback'), $this->plugin_name, 'general_setting_section');

		add_settings_section('uninstall_setting_section', __('Uninstall Settings', $this->plugin_name), array($this, 'uninstall_setting_section_callback'), $this->plugin_name);
		add_settings_field('remove_option_field', __('Remove options on uninstall', $this->plugin_name), array($this, 'remove_option_field_callback'), $this->plugin_name, 'uninstall_setting_section');
	}

	/**
	 * Add sub menu page to the Settings menu.
	 *
	 * @since 1.0.0
	 */
	public function add_options_page() {
		require_once plugin_dir_path(__FILE__) . 'partials/wordpress-seo-remove-branding-settings.php';
	}

	/**
	 * Function that fills the section with the desired content. The function should echo its output.
	 *
	 * @since 1.0.0
	 */
	public function general_setting_section_callback() {
		//_e("Please check the appropriate box below if there's a post type that you want to include in your site.", $this->plugin_name);
	}

	/**
	 * Function that fills the section with the desired content. The function should echo its output.
	 *
	 * @since 1.0.0
	 */
	public function current_hide_plugin_field_callback() {
		$options = get_option($this->plugin_slug);
		$field = 'current_hide_plugin';
		$value = 1;

		$items[$field]['label'] = __('Enable', $this->plugin_name);
		$items[$field]['id'] = $this->plugin_slug . '_' . $field;
		$items[$field]['name'] = $this->plugin_slug . '[' . $field . ']"';
		$items[$field]['value'] = $value;
		$items[$field]['checked'] = !empty($options[$field]) ? checked($value, $options[$field], 0) : null;

		$output = $this->render_checkbox_field(array(
			'legend' => __('Enable', $this->plugin_name),
			'items' => $items,
			'description' => __('Hide Yoast SEO plugin from WordPress admin plugin list for non admin users.', $this->plugin_name)
		));

		echo $output;
	}

	/**
	 * Function that fills the section with the desired content. The function should echo its output.
	 *
	 * @since 1.0.0
	 */
	public function admin_menu_field_callback() {
		$options = get_option($this->plugin_slug);
		$field = 'admin_menu';
		$value = 1;

		$items[$field]['label'] = __('Enable', $this->plugin_name);
		$items[$field]['id'] = $this->plugin_slug . '_' . $field;
		$items[$field]['name'] = $this->plugin_slug . '[' . $field . ']"';
		$items[$field]['value'] = $value;
		$items[$field]['checked'] = !empty($options[$field]) ? checked($value, $options[$field], 0) : null;

		$output = $this->render_checkbox_field(array(
			'legend' => __('Enable', $this->plugin_name),
			'items' => $items,
			'description' => __('Remove Yoast SEO plugin admin menu for non admin users.', $this->plugin_name)
		));

		echo $output;
	}

	/**
	 * Function that fills the section with the desired content. The function should echo its output.
	 *
	 * @since 1.0.0
	 */
	public function admin_bar_field_callback() {
		$options = get_option($this->plugin_slug);
		$field = 'admin_bar';
		$value = 1;

		$items[$field]['label'] = __('Enable', $this->plugin_name);
		$items[$field]['id'] = $this->plugin_slug . '_' . $field;
		$items[$field]['name'] = $this->plugin_slug . '[' . $field . ']"';
		$items[$field]['value'] = $value;
		$items[$field]['checked'] = !empty($options[$field]) ? checked($value, $options[$field], 0) : null;

		$output = $this->render_checkbox_field(array(
			'legend' => __('Enable', $this->plugin_name),
			'items' => $items,
			'description' => __('Remove Yoast SEO settings from the admin bar for non admin users.', $this->plugin_name)
		));

		echo $output;
	}

	/**
	 * Function that fills the section with the desired content. The function should echo its output.
	 *
	 * @since 1.0.0
	 */
	public function dashboard_field_callback() {
		$options = get_option($this->plugin_slug);
		$field = 'dashboard';
		$value = 1;

		$items[$field]['label'] = __('Enable', $this->plugin_name);
		$items[$field]['id'] = $this->plugin_slug . '_' . $field;
		$items[$field]['name'] = $this->plugin_slug . '[' . $field . ']"';
		$items[$field]['value'] = $value;
		$items[$field]['checked'] = !empty($options[$field]) ? checked($value, $options[$field], 0) : null;

		$output = $this->render_checkbox_field(array(
			'legend' => __('Enable', $this->plugin_name),
			'items' => $items,
			'description' => __('Removes Yoast SEO dashboard widget.', $this->plugin_name)
		));

		echo $output;
	}


	/**
	 * Function that fills the section with the desired content. The function should echo its output.
	 *
	 * @since 1.0.0
	 */
	public function notification_field_callback() {
		$options = get_option($this->plugin_slug);
		$field = 'notification';
		$value = 1;

		$items[$field]['label'] = __('Enable', $this->plugin_name);
		$items[$field]['id'] = $this->plugin_slug . '_' . $field;
		$items[$field]['name'] = $this->plugin_slug . '[' . $field . ']"';
		$items[$field]['value'] = $value;
		$items[$field]['checked'] = !empty($options[$field]) ? checked($value, $options[$field], 0) : null;

		$output = $this->render_checkbox_field(array(
			'legend' => __('Enable', $this->plugin_name),
			'items' => $items,
			'description' => __('Removes Yoast SEO updated notification.', $this->plugin_name)
		));

		echo $output;
	}

	/**
	 * Function that fills the section with the desired content. The function should echo its output.
	 *
	 * @since 1.0.0
	 */
	public function meta_box_field_callback() {
		$options = get_option($this->plugin_slug);
		$field = 'meta_box';
		$value = 1;

		$post_types = get_post_types(array('public' => true), 'objects');
		$excluded_post_types = array('attachment', 'revision', 'nav_menu_item');

		foreach ((array)$post_types as $key => $post_type) {
			if (in_array($post_type->name, $excluded_post_types)) {
				continue;
			}

			$items[$key]['label'] = $post_type->label;
			$items[$key]['id'] = $field . '_' . $post_type->name;
			$items[$key]['name'] = $this->plugin_slug . '[' . $field . '][' . $post_type->name . ']';
			$items[$key]['value'] = $value;
			$items[$key]['checked'] = !empty($options[$field][$post_type->name]) ? checked($value, $options[$field][$post_type->name], 0) : null;
		}

		$output = $this->render_checkbox_field(array(
			'legend' => __('Select Post Types', $this->plugin_name),
			'items' => $items,
			'description' => __('Removes Yoast SEO meta box on edit page.', $this->plugin_name)

		));

		echo $output;
	}

	/**
	 * Function that fills the section with the desired content. The function should echo its output.
	 *
	 * @since 1.0.0
	 */
	public function publish_box_field_callback() {
		$options = get_option($this->plugin_slug);
		$field = 'publish_box';
		$value = 1;

		$post_types = get_post_types(array('public' => true), 'objects');
		$excluded_post_types = array('attachment', 'revision', 'nav_menu_item');

		foreach ((array)$post_types as $key => $post_type) {
			if (in_array($post_type->name, $excluded_post_types)) {
				continue;
			}

			$items[$key]['label'] = $post_type->label;
			$items[$key]['id'] = $field . '_' . $post_type->name;
			$items[$key]['name'] = $this->plugin_slug . '[' . $field . '][' . $post_type->name . ']';
			$items[$key]['value'] = $value;
			$items[$key]['checked'] = !empty($options[$field][$post_type->name]) ? checked($value, $options[$field][$post_type->name], 0) : null;
		}

		$output = $this->render_checkbox_field(array(
			'legend' => __('Select Post Types', $this->plugin_name),
			'items' => $items,
			'description' => __('Removes Yoast SEO score traffic light on edit page.', $this->plugin_name)

		));

		echo $output;
	}

	/**
	 * Function that fills the section with the desired content. The function should echo its output.
	 *
	 * @since 1.0.0
	 */
	public function page_analysis_field_callback() {
		$options = get_option($this->plugin_slug);
		$field = 'page_analysis';
		$value = 1;

		$items[$field]['label'] = __('Enable', $this->plugin_name);
		$items[$field]['id'] = $this->plugin_slug . '_' . $field;
		$items[$field]['name'] = $this->plugin_slug . '[' . $field . ']"';
		$items[$field]['value'] = $value;
		$items[$field]['checked'] = !empty($options[$field]) ? checked($value, $options[$field], 0) : null;

		$output = $this->render_checkbox_field(array(
			'legend' => __('Enable', $this->plugin_name),
			'items' => $items,
			'description' => __('Removes Yoast SEO page analysis columns on the administration screens for post(types).', $this->plugin_name)
		));

		echo $output;
	}

	/**
	 * Function that fills the section with the desired content. The function should echo its output.
	 *
	 * @since 1.0.0
	 */
	public function uninstall_setting_section_callback() {
		//_e("Please check the appropriate box below if there's a post type that you want to include in your site.", $this->plugin_name);
	}

	/**
	 * Function that fills the section with the desired content. The function should echo its output.
	 *
	 * @since 1.0.0
	 */
	public function remove_option_field_callback() {
		$options = get_option($this->plugin_slug);
		$field = 'remove_option';
		$value = 1;

		$items[$field]['label'] = __('Enable', $this->plugin_name);
		$items[$field]['id'] = $this->plugin_slug . '_' . $field;
		$items[$field]['name'] = $this->plugin_slug . '[' . $field . ']"';
		$items[$field]['value'] = $value;
		$items[$field]['checked'] = !empty($options[$field]) ? checked($value, $options[$field], 0) : null;

		$output = $this->render_checkbox_field(array(
			'legend' => __('Enable', $this->plugin_name),
			'items' => $items,
			'description' => __('This tool will delete option when uninstalling via plugins > Delete.', $this->plugin_name)
		));

		echo $output;
	}
}