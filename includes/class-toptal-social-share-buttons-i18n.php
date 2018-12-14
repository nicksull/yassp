<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://nicksullivan.com.au
 * @since      1.0.0
 *
 * @package    Toptal_Social_Share_Buttons
 * @subpackage Toptal_Social_Share_Buttons/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Toptal_Social_Share_Buttons
 * @subpackage Toptal_Social_Share_Buttons/includes
 * @author     Nicholas Sullivan <nick@popsiclestudio.com>
 */
class Toptal_Social_Share_Buttons_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'toptal-social-share-buttons',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
