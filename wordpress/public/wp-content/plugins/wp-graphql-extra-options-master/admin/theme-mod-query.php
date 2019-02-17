<?php

namespace WPGraphQLExtra\Type\ThemeMod;

require_once 'theme-mod-type.php';
require_once 'theme-mod-sub-type.php';

use WPGraphQL\Types;

/**
 * Class ThemeModQuery
 *
 * @since 0.1.0
 * @package WPGraphQL\Type\ThemeMod
 */
class ThemeModQuery {

	/**
	 * Method that returns the root query field definition
	 * for ThemeMod
	 *
	 * @access public
	 *
	 * @return array $root_query
	 */
	public static function root_query() {

		return [
			'type'        => Types::themeMod( '\\WPGraphQLExtra\\Type\\ThemeMod\\ThemeModType' ),
			'resolve'     => function () {
				return true;
			},
		];
	}
}
