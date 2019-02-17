<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://axistaylor.com
 * @since      0.0.1
 *
 * @package    Wp_Graphql_Extra_Options
 * @subpackage Wp_Graphql_Extra_Options/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      0.0.1
 * @package    Wp_Graphql_Extra_Options
 * @subpackage Wp_Graphql_Extra_Options/includes
 * @author     Geoff Taylor <geoffrey.taylor@outlook.com>
 */
class Wp_Graphql_Extra_Options_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    0.0.1
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wp-graphql-extra-options',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
