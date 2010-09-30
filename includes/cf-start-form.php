<?php
echo ('
	<form id="' . $plugin_slug . '_settings_form" name="' . $plugin_slug . '_settings_form" action="'.get_bloginfo('wpurl').'/wp-admin/options-general.php" method="post" class="cf-form">
	<input type="hidden" name="cf_action" value="'.$plugin_slug . '_update_settings" />
	');
?>