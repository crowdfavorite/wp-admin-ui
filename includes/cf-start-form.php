<form id="<?php echo $plugin_slug; ?>_settings_form" name="<?php echo $plugin_slug; ?>_settings_form" action="<?php echo admin_url('options-general.php'); ?>" method="post" class="cf-form">
	<input type="hidden" name="cf_action" value="<?php echo $plugin_slug; ?>_update_settings" />
