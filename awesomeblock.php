<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/ericphamhoang
 * @since             1.0.0
 * @package           Awesomeblock
 *
 * @wordpress-plugin
 * Plugin Name:       Awesome Block
 * Plugin URI:        https://github.com/ericphamhoang/awesomeblock
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Eric Pham Hoang
 * Author URI:        https://github.com/ericphamhoang
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       awesomeblock
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-awesomeblock-activator.php
 */
function activate_awesomeblock() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-awesomeblock-activator.php';
	Awesomeblock_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-awesomeblock-deactivator.php
 */
function deactivate_awesomeblock() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-awesomeblock-deactivator.php';
	Awesomeblock_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_awesomeblock' );
register_deactivation_hook( __FILE__, 'deactivate_awesomeblock' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-awesomeblock.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_awesomeblock() {

	$plugin = new Awesomeblock();
	$plugin->run();

}
run_awesomeblock();
