<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://nicksullivan.com.au
 * @since             1.0.0
 * @package           Toptal_Social_Share_Buttons
 *
 * @wordpress-plugin
 * Plugin Name:       Toptal Social Share Buttons
 * Plugin URI:        https://nicksullivan.com.au
 * Description:       Social share buttons for Facebook, Twitter, Google+, Pinterest, LinkedIn and Whatsapp. Allows the user to configure the order of share buttons, choose button sizes & select colour of icons. The buttons can be placed below the post title, floating on the left, after the post content or inside the featured image. Also included is a shortcode to allow the user to include the social share buttons inside a post.
 * Version:           1.0.0
 * Author:            Nicholas Sullivan
 * Author URI:        https://nicksullivan.com.au
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       toptal-social-share-buttons
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-toptal-social-share-buttons-activator.php
 */
function activate_toptal_social_share_buttons() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-toptal-social-share-buttons-activator.php';
	Toptal_Social_Share_Buttons_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-toptal-social-share-buttons-deactivator.php
 */
function deactivate_toptal_social_share_buttons() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-toptal-social-share-buttons-deactivator.php';
	Toptal_Social_Share_Buttons_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_toptal_social_share_buttons' );
register_deactivation_hook( __FILE__, 'deactivate_toptal_social_share_buttons' );

/**
 * The core plugin class that is used to define internationalization,
 * Link: http://mobiledetect.net/
 */
require plugin_dir_path( __FILE__ ) . 'includes/Mobile_Detect.php';

/**
 * Mobile Detection class
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-toptal-social-share-buttons.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_toptal_social_share_buttons() {

	$plugin = new Toptal_Social_Share_Buttons();
	$plugin->run();

}
run_toptal_social_share_buttons();
