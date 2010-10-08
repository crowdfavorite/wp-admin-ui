<?php
if (!class_exists('CF_Admin')) {

	if (!defined('CF_ADMIN_DIR')) {
		$plugin_dir = basename( dirname( dirname(__FILE__)));
		if ($plugin_dir == basename(WP_PLUGIN_DIR)) {
			define('CF_ADMIN_DIR', 'cf-admin/');
		}
		else {
			define('CF_ADMIN_DIR', trailingslashit(basename( dirname( dirname(__FILE__)))).'cf-admin/');		
		}
	}

	load_plugin_textdomain('cf-wpplugin-admin-ui', false, 'CF_ADMIN_DIR');

	Class CF_Admin {
				
		function path_to_adminui() {
			return trailingslashit(WP_PLUGIN_URL) . CF_ADMIN_DIR;
		}
		
		function url_to_adminui() {
			return trailingslashit(WP_PLUGIN_URL) . CF_ADMIN_DIR;
		}
		
		function admin_header($title, $plugin_name, $plugin_version, $textdomain) {
			if (isset($_GET['message'])) {
				echo ('
<div class="cf-updated updated inline">
	<p>'.esc_html($_GET['message']).'</p>
</div>
				');
			} 
			else if (isset($_GET['updated']) && $_GET['updated']) {
				echo ('
<div class="cf-updated updated inline">
	<p>'.__('Options Updated.', $textdomain).'</p>
</div>
				');				
			}
			echo '<h2>'.esc_html($title).' '.self::get_support_button($plugin_name, $plugin_version).'</h2>';
		}
		
		function admin_tabs($titles) {
			if (count($titles)) {
				echo '<ul id="cf-nav" class="cf-clearfix">';
				
				$i = 1;
				foreach ($titles as $title) {
					echo '<li id="cf-tab-'.$i.'" class="cf-tab"><a href="#">'.esc_html($title).'</a></li>';
					$i++;
				}
				echo '</ul>';
			}
		}
		
		function plugin_action_links($links, $file, $plugin_php_file, $textdomain) {
			$plugin_file = basename($plugin_php_file);
			if (basename($file) == $plugin_file) {
				$settings_link = '<a href="'. admin_url('options-general.php?page='.$plugin_file).'">'.__('Settings', $textdomain).'</a>';
				array_unshift($links, $settings_link);
			}
			return $links;
		}
		
		function callouts($textdomain) {
			$img_dir_url = self::url_to_adminui() . 'img/';
		
			echo '<div id="cf-callouts">';
			include 'includes/cf-callout.php';
			include 'includes/wphc-callout.php';
			echo '</div><!-- #cf-callouts -->';
		}
				
		function get_support_button($plugin_name, $plugin_version) {
			return '<script type="text/javascript">var WPHC_AFF_ID = "14303"; var WPHC_POSITION = "c1"; var WPHC_PRODUCT = "'.esc_js($product).' '.esc_js($plugin_version).'"; var WPHC_WP_VERSION = "'.esc_js($wp_version).'";</script><script type="text/javascript" src="http://cloud.wphelpcenter.com/support-form/0001/deliver-a.js"></script>';
		}
		
		function support_button($plugin_name, $plugin_version) {
			echo get_support_button($plugin_name, $plugin_version);
		}
				
		function start_form($plugin_slug) {
			include 'includes/cf-start-form.php';
		}
		
		function end_form_submit($plugin_slug, $text_domain) {
			include 'includes/cf-end-form-submit.php';
		}
		
		function settings_form($settings, $plugin_slug, $text_domain) {
			self::start_form($plugin_slug);
			echo '<fieldset class="cf-lbl-pos-left">';
			self::display_settings($settings);
			echo '</fieldset>';
			self::end_form_submit($plugin_slug, $text_domain);
		}
		
		function load_css() {
			$css_url = self::url_to_adminui() . 'css/';
			wp_enqueue_style('cf_styles', $css_url . 'styles.css');
			wp_enqueue_style('cf_form_elements', $css_url . 'form-elements.css');
			wp_enqueue_style('cf_utility', $css_url . 'utility.css');
		}
		
		function load_js() {
			$js_url = self::url_to_adminui() . 'js/';
			wp_enqueue_script('cf_admin_cookie_js', $js_url .'jquery.cookie.js', array('jquery'));
			wp_enqueue_script('cf_js_script', $js_url.'scripts.js', array('jquery'));
		}
		
		function display_settings($settings) {
			foreach ($settings as $key => $config) {
				$value = get_option($key);
				if (empty($value)) {
					$value = $settings[$key]['default'];
				}
				if (is_array($value)) {
					$value = implode("\n", $value);
				}
				echo self::settings_field($key, $config, $value);
			}
		}

		function settings_field($key, $config, $value) {
			$help = $config['help'];
			
			empty($config['label_class']) ? $label_class = '' :  $label_class = ' '.$config['label_class'];
			empty($config['input_class']) ? $input_class = '' : $input_class = ' '.$config['input_class'];
			empty($config['help_class']) ? $help_class = '' :  $help_class = ' '.$config['help_class'];
			empty($config['div_class']) ? $div_class = '' : $div_class = ' '.$config['div_class'];
			if ($config['type'] == 'radio' || $config['type'] == 'checkbox') {
				$div_class .= ' cf-has-'.$config['type'];
			}
			
			$output = '<div class="cf-elm-block'.$div_class.'">';
			switch ($config['type']) {
				case 'select': // handles single option selection only
					$label = '<label for="'.$key.'" class="cf-lbl-select">'.$config['label'].'</label>';
					$output .= $label.'<select name="'.$key.'" id="'.$key.'" class="cf-elm-select">';
					foreach ($config['options'] as $sel_key => $sel_val) {
						$output .= '<option value="'.$sel_key.'"'.selected($value, $sel_key, false).'>'.$sel_val.'</option>';
					}
					$output .= '</select>';
					break;
				case 'textarea':
					$label = '<label for="'.$key.'" class="cf-lbl-textarea'.$label_class.'">'.$config['label'].'</label>';
					$output .= $label.'<textarea name="'.$key.'" id="'.$key.'" class="cf-elm-textarea'.$input_class.'" rows="8" cols="40">'.htmlspecialchars($value).'</textarea>';
					break;
				case 'radio':
					$output .= '<p class="cf-lbl-radio-group">'.$config['label'].'</p>';
					$output .= '<ul>';
					foreach ($config['options'] as $opt_key => $opt_val) {
						$output .= '<li>';
						$output .= '<input id="'.$opt_key.'-'.$opt_val.'" type="radio" class="cf-elm-radio" name="'.$opt_key.'" value="'.$opt_key.'"'.checked( $value, $opt_key).' />';
						$output .= '<label for="'.$opt_key.'-'.$opt_val.'" class="cf-lbl-radio"> '.$opt_val.'</label>';
						$output .= '</li>';
					}
					$output .= '</ul>';
					break;
				case 'checkbox':
					$output .= '<label class="cf-lbl-text'.$label_class.'">'.$config['label'].'</label>';
					$values = explode(',',$value);
					foreach ($config['options'] as $check_key => $check_val) {
						$checked = '';
						if (in_array($check_key, $values)) {
							$checked = ' checked';
						}
						$label = '<label for="'.$check_val.'" class="cf-lbl-checkbox">'.$check_val.'</label>';
						$output .= '<input id="'.$check_val.'" type="checkbox" class="cf-elm-checkbox" value="'.$check_key.'"'.$checked.' />'.$label;
					}						
					break;
				case 'string':
				case 'int':
				default:
					$label = '<label for="'.$key.'" class="cf-lbl-text'.$label_class.'">'.$config['label'].'</label>';
					$output .= $label.'<input type="text" name="'.$key.'" id="'.$key.'" value="'.esc_attr($value).'" class="cf-elm-text'.$input_class.'" />';
					break;
			}
			return $output.'<span class="cf-elm-help'.$help_class.'">'.$help.'</span></div>';
		}
		
		function update_settings($settings) {
			foreach ($settings as $key => $option) {
				$value = '';
				switch ($option['type']) {
					case 'int':
						$value = intval($_POST[$key]);
						break;
					case 'select': // handles single option selection only
						$test = stripslashes($_POST[$key]);
						if (isset($option['options'][$test])) {
							$value = $test;
						}
						break;
					case 'checkbox':
						$value = stripslashes(implode(',',$_POST[$key]));
						break;
					case 'radio':
					case 'string':
					case 'textarea':
					default:
						$value = stripslashes($_POST[$key]);
						break;
				}
				update_option($key, $value);
			}
		}
		
//Multisite
		function is_multisite() {
			return function_exists('is_multisite') && is_multisite();
		}
		
		function network_activation() {
			return isset($_GET['networkwide']) && ($_GET['networkwide'] == 1);
		}
		
//The wp get_blog_list function was deprecated in 3.0 without a replacement
		function get_site_blogs() {
			global $wpdb;
			if ($wpdb->query("SHOW TABLES LIKE $wpdb->blogs")) {			
				return $wpdb->get_col("
					SELECT blog_id
					FROM $wpdb->blogs
					WHERE site_id = '{$wpdb->siteid}'
					AND deleted = 0
				");	
			}
			return;
		}
		
		function activate_for_network($single_activation) {
			$blogs = self::get_site_blogs();
			foreach ($blogs as $blog_id) {
				switch_to_blog($blog_id);
				if (function_exists($single_activation)) {
					call_user_func($single_activation);
				}
				restore_current_blog();
			}
			return;
		}
		
// rename method -  activate plugin on blog creation?
		function activate_for_new_blog($file, $blog_id, $single_activation) {
			if (function_exists('is_plugin_active_for_network') && is_plugin_active_for_network(plugin_basename($file))) {
				switch_to_blog($blog_id);
				if (function_exists($single_activation)) {
					call_user_func($single_activation);
				}
				restore_current_blog();
			}		
		}
	}
}
?>