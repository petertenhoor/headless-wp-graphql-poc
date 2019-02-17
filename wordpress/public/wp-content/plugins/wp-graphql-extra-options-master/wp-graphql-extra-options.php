<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://axistaylor.com
 * @since             0.0.1
 * @package           Wp_Graphql_Extra_Options
 *
 * @wordpress-plugin
 * Plugin Name:       WP GraphQL Extra Options
 * Plugin URI:        https://github.com/kidunot89/wp-graphql-extra-options
 * Description:       Allow addition of wordpress options that don't use the Settings API
 * Version:           0.2.1
 * Author:            Geoff Taylor
 * Author URI:        https://axistaylor.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-graphql-extra-options
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! defined( 'WPGRAPHQL_EXTRA_VERSION' ) ) {
	define( 'WPGRAPHQL_EXTRA_VERSION', '0.4.0' );
}

if ( ! defined( 'WPGRAPHQL_EXTRA_PLUGIN_DIR' ) ) {
	define( 'WPGRAPHQL_EXTRA_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-graphql-extra-options-activator.php
 */
function activate_wp_graphql_extra_options() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-graphql-extra-options-activator.php';
	Wp_Graphql_Extra_Options_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-graphql-extra-options-deactivator.php
 */
function deactivate_wp_graphql_extra_options() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-graphql-extra-options-deactivator.php';
	Wp_Graphql_Extra_Options_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_graphql_extra_options' );
register_deactivation_hook( __FILE__, 'deactivate_wp_graphql_extra_options' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-graphql-extra-options.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.0.1
 */
function run_wp_graphql_extra_options() {

	$plugin = new Wp_Graphql_Extra_Options();
	$plugin->run();

}
run_wp_graphql_extra_options();
