<?php

namespace WPGraphQLExtra\Type\ThemeMod;

use GraphQL\Error\UserError;
use GraphQL\Type\Definition\ResolveInfo;
use WPGraphQL\AppContext;
use WPGraphQL\Data\DataSource;
use WPGraphQL\Type\WPObjectType;
use WPGraphQL\Types;

/**
 * Class ThemeModsType
 *
 * This sets up the theme modification sub-types
 * Nav Menu Locations
 * Custom Logo
 *
 * @since 0.3.1
 * @package WPGraphQLExtra\Type
 */
class ThemeModSubType extends WPObjectType {

  /**
	 * Holds the type name
	 *
	 * @var string $type_name
	 */
	private static $type_name;

	/**
	 * Holds the $fields definition for the SettingsType
	 *
	 * @var array $fields
	 * @access private
	 */
	private static $fields;

	/**
	 * ThemeModType constructor.
	 *
	 * @access public
	 */
	public function __construct( $type_name ) {
    /**
		 * Set the type_name
		 *
		 * @since 0.0.1
		 */
		self::$type_name = $type_name;

		$config = [
			'name'        => self::$type_name,
			'fields'      => self::fields( $type_name ),
			'description' => __( 'All of registered theme modifications', 'wp-graphql-extra-options' ),
		];

    parent::__construct( $config );
    
  }

   /**
	 * Retrieve the fields for the ThemeModSubType
	 *
	 * @param $mods
	 *
	 * @access private
	 * @return \GraphQL\Type\Definition\FieldDefinition|mixed|null
	 */
  private static function fields( string $type_name ) {

    /**
     * Dynamically field definitions for specific types
     */
    switch( $type_name ) {
      
      default:
        return null;

    }

  }

}