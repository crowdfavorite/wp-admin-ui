<?php
	// A terrible hack until cloud hosted images or widgets for absolute URLs
	// Bad for testing, works for deployment
						    //dir name	  plugin dir   working-html   includes  cf-callouts
	$this_plugin_dir_name = basename(     dirname(   	 dirname(       dirname(   __FILE__   ))));
	
	if ($this_plugin_dir_name == basename(WP_PLUGIN_DIR)) {
		$this_plugin_dir_name = '';
	}
	$url_to_img_dir = trailingslashit(WP_PLUGIN_URL) . trailingslahsit($this_plugin_dir_name) . 'working-html/img/';

print_r('
		<div id="cf-callouts">
			<div class="cf-callout">
				<div id="cf-callout-credit" class="cf-box">
					<h3 class="cf-box-title">Plugin Developed By</h3>
					<div class="cf-box-content">
						<p class="txt-center"><a href="http://crowdfavorite.com/" title="Crowd Favorite : Elegant WordPress and Web Application Development"><img src="'.$url_to_img_dir.'cf-logo.png" alt="Crowd Favorite"></a></p>
						<p>An independent development firm specializing in WordPress development and integrations, sophisticated web applications, Open Source implementations and user experience consulting. If you need it to work, trust Crowd Favorite to build it.</p>
					</div><!-- .cf-box-content -->
				</div><!-- #cf-callout-credit -->						
			</div>
			<div class="cf-callout">
				<div id="cf-callout-support" class="cf-box">
					<h3 class="cf-box-title">Support Provided By</h3>
					<div class="cf-box-content">
						<p class="txt-center"><a href="http://wphelpcenter.com/" title="WordPress HelpCenter"><img src="'.$url_to_img_dir.'wphc-logo.png" alt="WordPress HelpCenter"></a></p>
						<p>Need help with WordPress right now? That\'s what we\'re here for. We can help with anything from how-to questions to server troubleshooting, theme customization to upgrades and installs. Give us a call and we\'ll get you taken care of - 303-395-1346.</p>
					</div><!-- .cf-box-content -->
				</div><!-- #cf-callout-support -->						
			</div>
		</div><!-- #cf-callouts -->
');