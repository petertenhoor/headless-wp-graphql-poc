<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://axistaylor.com
 * @since      0.0.1
 *
 * @package    Wp_Graphql_Extra_Options
 * @subpackage Wp_Graphql_Extra_Options/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      0.0.1
 * @package    Wp_Graphql_Extra_Options
 * @subpackage Wp_Graphql_Extra_Options/includes
 * @author     Geoff Taylor <geoffrey.taylor@outlook.com>
 */
class Wp_Graphql_Extra_Options_Deactivator {

	/**
	 * Function to execute when the user deactivates the plugin.
	 *
	 * @since    0.1.1
	 */
	public static function deactivate() {
		flush_rewrite_rules();
		delete_option( 'wp_graphql_eo_version' );
	}

}
