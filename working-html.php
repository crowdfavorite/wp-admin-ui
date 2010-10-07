<?php

// move out of trunk

/*
Plugin Name: Admin UI
Plugin URI: 
Description: Working HTML template to be used as reference on Crowd Favorite WordPress plugins.
Version: 0.1
Author: Crowd Favorite
Author URI: http://crowdfavorite.com
*/ 

add_action('admin_menu', 'my_plugin_menu');
add_action('admin_head', 'my_plugin_css');
add_action('admin_head', 'my_plugin_js');

function my_plugin_css() {
    $cf_styles = site_url('/wp-content/plugins/admin-ui/css/styles.css');
    $cf_utility_styles = site_url('/wp-content/plugins/admin-ui/css/utility.css');
    $cf_form_styles = site_url('/wp-content/plugins/admin-ui/css/form-elements.css');
    echo '<link rel="stylesheet" type="text/css" href="' . $cf_styles . '" />';
    echo '<link rel="stylesheet" type="text/css" href="' . $cf_utility_styles . '" />';
    echo '<link rel="stylesheet" type="text/css" href="' . $cf_form_styles . '" />';
}
function my_plugin_js() {
    $cf_scripts = site_url('/wp-content/plugins/admin-ui/js/scripts.js');
    $cf_cookie = site_url('/wp-content/plugins/admin-ui/js/jquery.cookie.js');
    echo '<script type="text/javascript" src="' . $cf_scripts . '"></script>';
    echo '<script type="text/javascript" src="' . $cf_cookie . '"></script>';
}

function my_plugin_menu() {
  add_options_page('Admin UI Options', 'Admin UI', 'manage_options', 'admin-ui', 'my_plugin_options');
}

function my_plugin_options() {
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
	include 'includes/content.php';
}

?>