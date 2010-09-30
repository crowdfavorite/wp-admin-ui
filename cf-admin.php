<?php
if ( ! class_exists('CF_Admin')) {
	Class CF_Admin {
				
		function cf_path_to_adminui() {
			if (defined('CF_TEST_DIR')) {
				return trailingslashit(WP_PLUGIN_URL) . trailingslashit(CF_TEST_DIR) . 'cf-admin/';
			}
			$plugin_dir = basename( dirname( dirname(__FILE__)));
			if ($plugin_dir == basename(WP_PLUGIN_DIR)) {
				return trailingslashit(WP_PLUGIN_DIR) . 'admin-ui/';
			}
			else {
				return 	trailingslashit(WP_PLUGIN_DIR) . trailingslashit($plugin_dir) . 'cf-admin/';
			}
		}
		
		function cf_url_to_adminui() {
			if (defined('CF_TEST_DIR')) {
				return trailingslashit(WP_PLUGIN_URL) . trailingslashit(CF_TEST_DIR) . 'cf-admin/';
			}
			$plugin_dir_name = basename( dirname( dirname(__FILE__)));
			if ($plugin_dir_name == basename(WP_PLUGIN_DIR)) {
				return trailingslashit(WP_PLUGIN_URL) . 'admin-ui/';
			}
			else {
				return trailingslashit(WP_PLUGIN_URL) . trailingslashit($plugin_dir_name) . 'cf-admin/';
			}
		}
		
		function cf_admin_header($title = 'Options', $plugin_name, $plugin_version) {
			echo '<h2>'.$title.' '.self::cf_get_support_button($plugin_name, $plugin_version).'</h2>';
		} 
		
		function cf_plugin_action_links($links, $file, $plugin_php_file) {
			$plugin_file = basename($plugin_php_file);
			if (basename($file) == $plugin_file) {
				$settings_link = '<a href="options-general.php?page='.$plugin_file.'">'.__('Settings', 'cf-mobile').'</a>';
				array_unshift($links, $settings_link);
			}
			return $links;
		}
		
		function cf_callouts() {
			$img_dir_url = self::cf_url_to_adminui() . 'img/';
		
			echo '<div id="cf-callouts">';
			include 'includes/cf-callout.php';
			include 'includes/wphc-callout.php';
			echo '</div><!-- #cf-callouts -->';
		}
		
		function cf_banner() {
			include 'includes/cf-banner.php';
		}
		
		function cf_get_support_button($product) {
			return '<script type="text/javascript">var WPHC_AFF_ID = "14303"; var WPHC_POSITION = "c1"; var WPHC_PRODUCT = "'.$product.'"; var WPHC_WP_VERSION = "'.$wp_version.'";</script><script type="text/javascript" src="http://cloud.wphelpcenter.com/support-form/0001/deliver-a.js"></script>';
		}
		
		function cf_support_button($product) {
			echo cf_get_support_button($product);
		}
		
		function cf_display_settings($settings) {
			include 'includes/cf-display-settings.php';
		}
		
		function cf_start_form($plugin_slug) {
			echo '<div id="cf">'; //closed in cf_end_form_submit
			include 'includes/cf-start-form.php';
		}
		
		function cf_end_form_submit($plugin_slug, $text_domain) {
			include 'includes/cf-end-form-submit.php';
			echo '</div>'; // #cf 
		}
		
		function cf_settings_form($settings, $plugin_slug, $text_domain) {
			self::cf_start_form($plugin_slug);
			echo '<fieldset class="lbl-pos-left">';
			self::cf_display_settings($settings);
			echo '</fieldset>';
			self::cf_end_form_submit($plugin_slug, $text_domain);
		}
		
		function cf_load_css() {
			$css_url = self::cf_url_to_adminui() . 'css/';
			wp_enqueue_style('cf_styles', $css_url . 'styles.css');
			wp_enqueue_style('cf_form_elements', $css_url . 'form-elements.css');
		}
		
		function cf_load_js() {
			$js_url = self::cf_url_to_adminui() . 'js/';
			wp_enqueue_script('cf_admin_cookie_js', $js_url .'jquery.cookie.js', array('jquery'));
			wp_enqueue_script('cf_js_script', $js_url.'scripts.js', array('jquery'));
		}
		
		function cf_settings_field($key, $config) {
			$option = get_option($key);
			$label = '<label for="'.$key.'">'.$config['label'].'</label>';
			$help = $config['help'];
			empty($config['label_class']) ? $label_class = '' :  $label_class = ' '.$config['label_class'];
			empty($config['input_class']) ? $input_class = '' : $input_class = ' '.$config['input_class'];
			empty($config['help_class']) ? $help_class = '' :  $help_class = ' '.$config['help_class'];
			empty($config['div_class']) ? $div_class = '' : $div_class = ' '.$config['div_class'];
			
			$output = '<div class="elm-block'. $div_class.'">';
			switch ($config['type']) {
				case 'select':
					$label = '<label for="'.$key.'" class="lbl-select">'.$config['label'].'</label>';
					$output .= $label.'<select name="'.$key.'" id="'.$key.'" class="elm-select">';
					foreach ($config['options'] as $key => $val) {
						$option == $key ? $sel = ' selected="selected"' : $sel = '';
						$output .= '<option value="'.$key.'"'.$sel.'>'.$val.'</option>';
					}
					$output .= '</select><span class="elm-help">' . $help . '</span>';
					break;
				case 'textarea':
					$label = '<label for="'.$key.'" class="lbl-textarea'.$label_class.'">'.$config['label'].'</label>';
					if (is_array($option)) {
						$option = implode("\n", $option);
					}
					$output .= $label.'<textarea name="'.$key.'" id="'.$key.'" class="elm-textarea'.$input_class.'" rows="8" cols="40">'.htmlspecialchars($option).'</textarea>';
					$output .='<span class="elm-help'.$help_class.'">' . $help . '</span>';
					break;
				case 'radio':
					$output .= '<label class="lbl-text'.$label_class.'">'.$config['label'].'</label>';
					foreach ($config['options'] as $opt_key => $opt_val) {
						$option == $opt_key ? $checked = ' checked"' : $checked = '';						
						$output .= '<input type="radio" class="elm-radio" name="'.$key.'" value="'.$opt_key.'"'.$checked.' />';
						$output .= '<label class="lbl-radio">'.$opt_val.'</label>';
					}
					break;
				case 'checkbox':
					$output .= '<label class="lbl-text'.$label_class.'">'.$config['label'].'</label>';
					$options = explode(',',$option);
					foreach ($config['options'] as $checkbox) {
						if (in_array($checkbox, $options)) {
							$checked = 'checked';
						}
						else {
							$checked = '';
						}
						$label = $label = '<label for="'.$checkbox.'" class="lbl-checkbox">'.$checkbox.'</label>';
						$output .= '<input type="checkbox" class="elm-checkbox" value="'.$checkbox.'" '.$checked.' />'.$label;
					}
					
					$output .= '<span class="elm-help '.$help_class.'">' . $help . '</span>';	
					break;
				case 'string':
				case 'int':
				default:
					$label = '<label for="'.$key.'" class="lbl-text'.$label_class.'">'.$config['label'].'</label>';
					$output .= $label.'<input type="text" name="'.$key.'" id="'.$key.'" value="'.esc_html($option).'" class="elm-text'.$input_class.'" />';
					$output .= '<div class="elm-help'.$help_class.'">' . $help . '</div>';
					break;
			}
			return $output.'</div>';
		}
		
		function cf_save_settings($settings) {
			foreach ($settings as $key => $option) {
				$value = '';
				switch ($option['type']) {
					case 'int':
						$value = intval($_POST[$key]);
						break;
					case 'select':
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
				error_log('key ' . $key);
				error_log('value ' . $value);
				update_option($key, $value);
			}
		}
		
		//Multisite
		function cf_is_multisite_and_network_activation() {
			return (function_exists('is_multisite') && is_multisite() &&
				isset($_GET['networkwide']) && ($_GET['networkwide'] == 1));
		}
		
		function cf_get_site_blogs() {
			global $wpdb;
			return $wpdb->get_col("
				SELECT blog_id
				FROM $wpdb->blogs
				WHERE site_id = '{$wpdb->siteid}'
				AND deleted = 0
			");	
		}
		
		function cf_activate_for_network($single_activation) {
			$blogs = self::cf_get_site_blogs();
			foreach ($blogs as $blog_id) {
				switch_to_blog($blog_id);
				if (function_exists($single_activation)) {
					call_user_func($single_activation);
				}
				restore_current_blog();
			}
			return;
		}
		
		function cf_new_blog($file, $blog_id, $single_activation) {
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