<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://twitter.com/bobvnd
 * @since             1.0.0
 * @package           Movie_Info
 *
 * @wordpress-plugin
 * Plugin Name:       Movie Info
 * Plugin URI:        http://www.vakst.com
 * Description:       Movie Taxonomy with corresponding information.
 * Version:           1.0.0
 * Author:            Bob van Donselaar
 * Author URI:        https://twitter.com/bobvnd
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       movie-info
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently pligin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-movie-info-activator.php
 */
function activate_movie_info() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-movie-info-activator.php';
	Movie_Info_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-movie-info-deactivator.php
 */
function deactivate_movie_info() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-movie-info-deactivator.php';
	Movie_Info_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_movie_info' );
register_deactivation_hook( __FILE__, 'deactivate_movie_info' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-movie-info.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_movie_info() {

	$plugin = new Movie_Info();
	$plugin->run();

}
run_movie_info();
