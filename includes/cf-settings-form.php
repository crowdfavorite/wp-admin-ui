<?php
	echo ('
		<form id="' . $plugin_slug . '_settings_form" name="' . $plugin_slug . '_settings_form" action="'.get_bloginfo('wpurl').'/wp-admin/options-general.php" method="post" class="cf-elm-width-300">
			<input type="hidden" name="cf_action" value="'.$plugin_slug . '_update_settings" />
			<fieldset class="cf-lbl-pos-left">
		');
	foreach ($settings as $key => $config) {
		echo self::cf_settings_field($key, $config);
	}
	echo ('
			</fieldset>
			<p class="submit">
				<input type="submit" name="submit" class="button-primary" value="'.__('Save Settings', $text_domain).'" />
			</p>
			'.wp_nonce_field($plugin_slug , $plugin_slug . '-settings-nonce', true, false).' 
			'.wp_referer_field(false).'
		</form>
		');
?>