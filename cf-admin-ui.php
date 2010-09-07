<?php
if ( ! class_exists('CF_Admin_UI')) {
	Class CF_Admin_UI {
				
		function cf_path_to_adminui() {
			if (defined('CF_TEST_DIR')) {
				return trailingslashit(WP_PLUGIN_URL) . trailingslashit(CF_TEST_DIR) . 'admin-ui/';
			}
			$plugin_dir = basename( dirname( dirname(__FILE__)));
			if ($plugin_dir == basename(WP_PLUGIN_DIR)) {
				return trailingslashit(WP_PLUGIN_DIR) . 'admin-ui/';
			}
			else {
				return 	trailingslashit(WP_PLUGIN_DIR) . trailingslashit($plugin_dir) . 'admin-ui/';
			}
		}
		
		function cf_url_to_adminui() {
			if (defined('CF_TEST_DIR')) {
				return trailingslashit(WP_PLUGIN_URL) . trailingslashit(CF_TEST_DIR) . 'admin-ui/';
			}
			$plugin_dir_name = basename( dirname( dirname(__FILE__)));
			if ($plugin_dir_name == basename(WP_PLUGIN_DIR)) {
				return trailingslashit(WP_PLUGIN_URL) . 'admin-ui/';
			}
			else {
				return trailingslashit(WP_PLUGIN_URL) . trailingslashit($plugin_dir_name) . 'admin-ui/';
			}
		}
		
		function cf_callouts() {
			$img_dir_url = self::cf_url_to_adminui() . 'img/';
		
			echo '<div id="cf-callouts">';
			include 'includes/wphc-callout.php';
			include 'includes/cf-callout.php';
			echo '</div><!-- #cf-callouts -->';
		}
		
		function cf_banner() {
			include 'includes/cf-banner.php';
		}
		
		function cf_settings_form($settings, $plugin_slug, $text_domain) {
			include 'includes/cf-settings-form.php';
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
			$help = '<span class="help">'.$config['help'].'</span>';
			switch ($config['type']) {
				case 'select':
					$label = '<label for="'.$key.'" class="lbl-select">'.$config['label'].'</label>';
					$output = $label.'<select name="'.$key.'" id="'.$key.'" class="elm-select">';
					foreach ($config['options'] as $val => $display) {
						$option == $val ? $sel = ' selected="selected"' : $sel = '';
						$output .= '<option value="'.$val.'"'.$sel.'>'.$display.'</option>';
					}
					$output .= '</select><span class="elm-help">' . $help . '</span>';
					break;
				case 'textarea':
					$label = '<label for="'.$key.'" class="lbl-textarea">'.$config['label'].'</label>';
					if (is_array($option)) {
						$option = implode("\n", $option);
					}
					$output = $label.'<textarea name="'.$key.'" id="'.$key.'" class="elm-textarea" rows="8" cols="40">'.htmlspecialchars($option).'</textarea><span class="elm-help">' . $help . '</span>';
					break;
				case 'string':
				case 'int':
				default:
					$label = '<label for="'.$key.'">'.$config['label'].'</label>';
					$output = $label.'<input name="'.$key.'" id="'.$key.'" value="'.esc_html($option).'" class="elm-text" /><div class="elm-help">' . $help . '</div>';
					break;
			}
			return '<div class="elm-block elm-width-300">' . $output.'</div>';
		}
		
		function cf_support_button ($product)
		{
			echo '<script type="text/javascript">var WPHC_AFF_ID = "14303"; var WPHC_POSITION = "c1"; var WPHC_PRODUCT = "'.$product.'"; var WPHC_WP_VERSION = "'.$wp_version.'";</script><script type="text/javascript" src="http://cloud.wphelpcenter.com/support-form/0001/deliver-a.js"></script>';
		}	
	}
}
?>