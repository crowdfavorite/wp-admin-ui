<?php 
	foreach ($settings as $key => $config) {
		echo self::cf_settings_field($key, $config);
	}
?>