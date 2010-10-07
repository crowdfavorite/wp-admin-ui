<?php echo wp_nonce_field($plugin_slug , $plugin_slug . '-settings-nonce', true, false).wp_referer_field(false); ?>
		<p class="submit">
			<input type="submit" name="submit" class="button-primary" value="<?php _e('Save Settings', $text_domain); ?>" />
		</p>
	</form>
