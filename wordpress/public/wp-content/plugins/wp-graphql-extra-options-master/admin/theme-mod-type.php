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
 * This sets up the theme modification type
 *
 * @since 0.1.0
 * @package WPGraphQLExtra\Type
 */
class ThemeModType extends WPObjectType {

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
	 * Holds the ThemeModSubType fully qualified classname
	 *
	 * @since 0.3.0
	 * @var array $fields
	 * @access private
	 */
	private static $sub_type_class = '\\WPGraphQLExtra\\Type\\ThemeMod\\ThemeModSubType';

	/**
	 * ThemeModType constructor.
	 *
	 * @access public
	 */
	public function __construct() {
		
		self::$type_name = 'ThemeMods';

		$config = [
			'name'        => self::$type_name,
			'fields'      => self::fields(),
			'description' => __( 'All of registered theme modifications', 'wp-graphql-extra-options' ),
		];

    parent::__construct( $config );
    
  }

  /**
	 * This defines the fields for the ThemeMods type
	 *
	 * @param $mods
	 *
	 * @access private
	 * @return \GraphQL\Type\Definition\FieldDefinition|mixed|null
	 */
	private static function fields() {

		/**
		 * Define $fields
		 */
    $fields = [];
		
		/**
		 * Get theme mods keys
		 */
		$theme_mods = array_keys ( get_theme_mods() );

    if ( ! empty( $theme_mods ) && is_array( $theme_mods ) ) {

			/**
			 * Loop through the $theme_mods and build the setting with
			 * proper fields
			 */
      foreach( $theme_mods as $mod ) {

				$type_name = str_replace( '_', '', ucwords( $mod, '_' ) );
        $field_key = lcfirst( $type_name );

				if ( ! empty( $mod ) && ! empty( $field_key ) ) {

					/**
					 * Dynamically build the individual setting and it's fields
					 * then add it to $fields
					 */
					switch( $mod ) {
						
						case 'nav_menu_locations':
							$fields[ $field_key ] = [ 
								'type' 				=> Types::menu(),
								'description'	=> __( 'theme menu locations', 'wp-graphql-extra-options' ),
								'args'				=> [
									'location' => [
										'type'	=> Types::string(),
										'description' => __( 'theme menu location name', 'wp-graphql-extra-options' )
									],
								],
								'resolve'			=> function( $root, $args, AppContext $context, ResolveInfo $info ) use( $mod ) {
									/**
									 * Get nav_menu_locations
									 */
									$nav_menus = get_theme_mod( $mod );
									/**
									 * Retrieve menu
									 */
									if ( ! empty( $args[ 'location' ] ) && ! empty ( $nav_menus ) ) {
										$location = $args[ 'location' ];
										if ( ! empty( $nav_menus[ $location ] ) ) {
											return DataSource::resolve_term_object( $nav_menus[ $location ], 'nav_menu' );
										}
									}
									return null;
								}
							];
							break;

						case 'custom_logo':
							$fields[ $field_key ] = [ 
								'type' 				=> Types::post_object( 'attachment' ),
								'description'	=> __( 'custom theme logo', 'wp-graphql-extra-options' ),
								'resolve'			=> function( $root, $args, AppContext $context, ResolveInfo $info ) use( $mod ) {
									/**
									 * Retrieve attachment.
									 */
									$id = get_theme_mod( $mod, 'none' );
									return ( ! empty( $id ) ) ? Datasource::resolve_post_object( intval( $id ), 'attachment' ) : null;
								}
							];
							break;

						default:
							$fields[ $field_key ] = [ 'type' => Types::get_type( 'string' ) ];
							
					}
					
					$fields[ $field_key ] += [ 'resolve' => function( $root, $args, AppContext $context, ResolveInfo $info ) use( $mod ) {
									
						/**
						 * Retrieve theme modification.
						 */
						$theme_mod = get_theme_mod( $mod, 'none' );
						
						return $theme_mod;

					}];

        }

      }

      /**
       * Pass the fields through a filter to allow for hooking in and adjusting the shape
       * of the type's schema
       */
      self::$fields = self::prepare_fields( $fields, self::$type_name );
    }

    return ! empty( self::$fields ) ? self::$fields : null;

  }

}

