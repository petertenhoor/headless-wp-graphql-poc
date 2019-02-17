<?php

/**
 * Fired during plugin activation
 *
 * @link       https://axistaylor.com
 * @since      0.0.1
 *
 * @package    Wp_Graphql_Extra_Options
 * @subpackage Wp_Graphql_Extra_Options/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      0.0.1
 * @package    Wp_Graphql_Extra_Options
 * @subpackage Wp_Graphql_Extra_Options/includes
 * @author     Geoff Taylor <geoffrey.taylor@outlook.com>
 */
class Wp_Graphql_Extra_Options_Activator {

	/**
	 * Function to execute when the user activates the plugin.
	 *
	 * @since    0.4.0
	 */
	public static function activate() {
		flush_rewrite_rules();
		// Save the version of the plugin as an option in order to force actions
		// on upgrade.
		update_option( 'wp_graphql_eo_version', WPGRAPHQL_EXTRA_VERSION, 'no' );
	}

}
