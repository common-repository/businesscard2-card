<?php
/*
Plugin Name: BusinessCard2 Card
Plugin URI: http://businesscard2.com/wordpress/
Description: Adds a sidebar widget to display your BusinessCard2 Card.
Version: 1.0.0
Author: BusinessCard2
Author URI: http://www.businesscard2.com/
*/

function card_init() {

	if ( !function_exists('register_sidebar_widget') )
		return;

	function card($args) {

		// "$args is an array of strings that help widgets to conform to
		// the active theme: before_widget, before_title, after_widget,
		// and after_title are the array keys." - These are set up by the theme
		extract($args);

		// These are our own options
		$options = get_option('buisnesscard2');
		$domain = $options['domain'];

        // Output
		print $before_widget ;

		// start
		print '<script type="text/javascript" src="http://businesscard2.com/api_1.php/api/embedScript?customerDomain='.$domain.'.businesscard2.com"></script>';

		// echo widget closing tag
		print $after_widget;
	}

	// Settings form
	function card_control() {

		// Get options
		$options = get_option('buisnesscard2');
		// options exist? if not set defaults
		if ( !is_array($options) )
			$options = array('domain'=>'your_domain');

        // form posted?
		if ( $_POST['businesscard2-submit'] ) {

			// Remember to sanitize and format use input appropriately.
			$options['domain'] = strip_tags(stripslashes($_POST['businesscard2-domain']));
			update_option('buisnesscard2', $options);
		}

		// Get options for form fields to show
		$domain = htmlspecialchars($options['domain'], ENT_QUOTES);

		// The form fields
		echo '<p style="text-align:right;">
				<label for="businesscard2-domain">' . __('Domain:') . '
				<input style="width: 100px;" id="businesscard2-domain" name="businesscard2-domain" type="text" value="'.$domain.'" />.businesscard2.com
				</label></p>';
		echo '<input type="hidden" id="businesscard2-submit" name="businesscard2-submit" value="1" />';
	}


	// Register widget for use
	register_sidebar_widget(array('BusinessCard2', 'widgets'), 'card');

	// Register settings for use, 300x200 pixel form
	register_widget_control(array('BusinessCard2', 'widgets'), 'card_control', 300, 200);
}

// Run code and init
add_action('widgets_init', 'card_init');

?>
