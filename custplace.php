<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://Custplace.com
 * @since             1.0.0
 * @package           Custplace
 *
 * @wordpress-plugin
 * Plugin Name:       Custpalce
 * Plugin URI:        http://wordpress.org/plugins/export-orders-for-woocommerce/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Custplace.com
 * Author URI:        http://Custplace.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       custplace
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
define( 'CUSTPLACE_VERSION', '1.0.0' );

!defined('CUSTPLACE_PATH') && define('CUSTPLACE_PATH', plugin_dir_path( __FILE__ )); 

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-custplace-activator.php
 */
function activate_custplace() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-custplace-activator.php';
	Custplace_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-custplace-deactivator.php
 */
function deactivate_custplace() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-custplace-deactivator.php';
	Custplace_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_custplace' );
register_deactivation_hook( __FILE__, 'deactivate_custplace' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-custplace.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_custplace() {

	$plugin = new Custplace();
	$plugin->run();

}
run_custplace();



