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
			include 'includes/wphc_callout.php';
			include 'includes/cf_callout.php';
			echo '</div><!-- #cf-callouts -->';
		}
		
		function cf_banner() {
			include 'includes/cf_banner.php';
		}
		
		function cf_settings_form() {
			
		}
		function cf_load_css()
		{
			
		}
		function cf_load_js()
		{
			
		}
	}
}
?>