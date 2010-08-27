<?php
if ( ! class_exists('CF_Admin_UI')) {
	Class CF_Admin_UI {

		function cf_callouts() {
			// A terrible hack until cloud hosted images or widgets for absolute URLs
			// Bad for testing, works for deployment
								   //dir name	  plugin dir   working-html   includes  cf-callouts
			$this_plugin_dir_name = basename(     dirname(   	 dirname(       dirname(   __FILE__   ))));
			$this_plugin_dir_name = trailingslashit($this_plugin_dir_name);
			if ($this_plugin_dir_name == basename(WP_PLUGIN_DIR)) {
				$this_plugin_dir_name = '';
			}
			$url_to_img_dir = trailingslashit(WP_PLUGIN_URL) . $this_plugin_dir_name . 'working-html/img/';
		
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
		function cf_load_css()
		{
			
		}
		function cf_load_js()
		{
			
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
	}
}

?>