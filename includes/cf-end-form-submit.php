<?php echo wp_nonce_field($plugin_prefix , $plugin_prefix.'_settings_nonce', true, false).wp_referer_field(false); ?>
		<p class="submit">
			<input type="submit" name="submit" class="button-primary" value="<?php _e('Save Settings', $text_domain); ?>" />
		</p>
	</form>
