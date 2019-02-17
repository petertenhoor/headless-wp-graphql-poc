<?php

	use WPGraphQLExtra\Type\ThemeMod\ThemeModQuery;
	use GraphQL\Error\Debug; 

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://axistaylor.com
 * @since      0.0.1
 *
 * @package    Wp_Graphql_Extra_Options
 * @subpackage Wp_Graphql_Extra_Options/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Graphql_Extra_Options
 * @subpackage Wp_Graphql_Extra_Options/admin
 * @author     Geoff Taylor <geoffrey.taylor@outlook.com>
 */
class Wp_Graphql_Extra_Options_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.0.1
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.0.1
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The options name to be used in this plugin
	 *
	 * @since  	0.0.1
	 * @access 	private
	 * @var  	string 		$option_name 	Option name of this plugin
	 */
	private $option_name = 'wp_graphql_extra_options';

	/**
	 * The delimiter
	 *
	 * @since  	0.0.1
	 * @access 	private
	 * @var  	string 		$delimiter
	 */
	private $delimiter = '<->';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.0.1
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    0.0.1
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Graphql_Extra_Options_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Graphql_Extra_Options_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-graphql-extra-options-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    0.0.1
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Graphql_Extra_Options_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Graphql_Extra_Options_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-graphql-extra-options-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add an options page under the Settings submenu
	 *
	 * @since  0.0.1
	 */
	public function add_options_page() {
	
		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'WPGraphQL Extra Options Settings', 'wp-graphql-extra-options' ),
			__( 'WPGraphQL Extra Options', 'wp-graphql-extra-options' ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_options_page' )
		);
	
	}

	/**
	 * Render the options page for plugin
	 *
	 * @since  0.0.1
	 */
	public function display_options_page() {

		include_once 'partials/wp-graphql-extra-options-admin-display.php';
	
	}

	/**
	 * Register option page sections
	 *
	 * @since  0.1.0
	 */
	public function register_setting() {

		// Add a General section
		add_settings_section(
			$this->option_name . '_general',
			__( 'General', 'wp-graphql-extra-options' ),
			array( $this, $this->option_name . '_general_cb' ),
			$this->plugin_name
		);

		add_settings_field(
			$this->option_name . '_endpoint',
			__( 'WPGraphQL Endpoint', 'wp-graphql-extra-options' ),
			array( $this, $this->option_name . '_endpoint_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_endpoint' )
		);

		add_settings_field(
			$this->option_name . '_selected',
			__( 'Selected Settings', 'wp-graphql-extra-options' ),
			array( $this, $this->option_name . '_selected_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_selected' )
		);

		add_settings_field(
			$this->option_name . '_theme_mods',
			__( 'Theme Mods', 'wp-graphql-extra-options' ),
			array( $this, $this->option_name . '_theme_mods_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_theme_mods' )
		);

		add_settings_field(
			$this->option_name . '_filter_mods',
			__( 'Filter Theme Mods', 'wp-graphql-extra-options' ),
			array( $this, $this->option_name . '_filter_mods_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_filter_mods' )
		);

		register_setting(
			$this->plugin_name,
			$this->option_name . '_endpoint',
			array( $this, $this->option_name . '_sanitize_endpoint' )
		);

		register_setting(
			$this->plugin_name,
			$this->option_name . '_selected',
			array( $this, $this->option_name . '_sanitize_selected' )
		);

		register_setting(
			$this->plugin_name,
			$this->option_name . '_theme_mods',
			array( $this, $this->option_name . '_sanitize_theme_mods' )
		);

		register_setting(
			$this->plugin_name,
			$this->option_name . '_filter_mods',
			array( $this, $this->option_name . '_sanitize_filter_mods' )
		);

	}

	/**
	 * Magic function
	 * @since  				0.1.0
	 * @return mixed 	class member
	 */
	public function __get( $name ) {
		
		if (! isset( $this->$name )) {
			switch( $name ) {

				case '_selected':
				case '_filter_mods':
					$this->$name = json_decode( get_option( $this->option_name . $name, '' ), true );
					break;

				case '_endpoint':
					$this->$name = get_option( $this->option_name . $name, '' );
					$this->$name !== '' ?: $this->$name = 'graphql'; 
					break;
				
				default:
					$this->$name = get_option( $this->option_name . $name, false );
					break;

			}
		}

		return $this->$name;

	}

	/**
	 * Changes graphql endpoint
	 * @since  				0.2.0
	 * @return array 	filtered graphql endpoint
	 */
	public function graphql_endpoint( $route ) {
		
		$endpoint = esc_textarea( $this->_endpoint );
		if ( false === $endpoint ) return $route;
		return $endpoint;

	}

	/**
	 * Add selected settings to allSettings type schema
	 * @since  				0.1.0
	 * @return array 	filtered args
	 */
	public function graphql_settings_fields( $fields ) {

		$settings = $this->_selected;
		if ( ! is_array( $settings ) ) return $fields;

		$field_keys = array_keys( $fields );
		foreach( $settings as $key => $value ) {
			if ( ! in_array( $key, $field_keys )) {
				/**
				 * Add field
				 */
				$name = str_replace( '_', '', lcfirst( ucwords( esc_textarea( $key ), '_' ) ) );
				$type = esc_textarea( $value[ 'type' ] );
				$description = esc_textarea( $value[ 'description' ] );
				$fields[ $name ] = [
					'type' => \WPGraphQL\Types::get_type( $type ),
					'description' => $description,

					/**
					 *  Dynamic resolver function copied from WPGraphQL plugin's Settings type
					 */
					'resolve' => function() use ( $value, $key) {
						
						$option = ! empty( $key ) ? get_option( $key ) : null;

						switch ( $value['type'] ) {
							case 'integer':
								$option = absint( $option );
								break;
							case 'string':
								$option = (string) $option;
								break;
							case 'boolean':
								$option = (boolean) $option;
								break;
							case 'number':
								$option = (float) $option;
								break;
						}

						return $option;
					},
				];
			}
		}

		return $fields;

	}

	/**
	 * Modify theme_mods type schema acquired to _filter_mods field 
	 * @since  				0.1.0
	 * @return array 	filtered $fields
	 */
	public function graphql_themeMods_fields( $fields ) {
		if ( ! $this->_theme_mods ) return $fields;

		/**
		 * Validate _filter_mods
		 */
		$filter_mods = $this->_filter_mods;
		if ( ! is_array( $filter_mods ) ) return $fields;

		/**
		 * Setup fields according to data in _filter_mods
		 */
		foreach( $filter_mods as $key => $value ) {
	
			// camelcase $key for $field name
			$name = lcfirst( str_replace( '_', '', ucwords( esc_textarea( $key ), '_' ) ) );
			if ( is_array( $value ) && ! empty( $fields [ $name ] ) ) {


				if ( ! empty( $value[ 'type' ] ) ) {
					$type = esc_textarea( $value[ 'type' ] );
					$fields[ $name ][ 'type' ] = \WPGraphQL\Types::get_type( $type );
				}

				if ( ! empty( $value[ 'description' ] ) ) {
					$fields[ $name ][ 'description' ] = esc_textarea( $value[ 'description' ] );
				}

				/**
				 * Resolve function for redefined field. Returns string or json-encoded string. 
				 * Not very robust at the moment.
				 */
				$fields[ $name ][ 'resolve' ] = function() use( $key, $type ) {

					/**
					 * Retrieve theme modification.
					 */
					$mod = get_theme_mod( $key, 'none' );

					/**
					 * Case to specified type
					 */
					if ( ! is_array( $mod ) ) {
						switch( $type ) {
							
							case 'integer':
								$mod = absint( $mod );
								break;
							case 'boolean':
								$mod = (boolean) $mod;
								break;
							case 'number':
								$mod = (float) $mod;
								break;

						}
					} else {
						// Encode array.
						$mod = json_encode( $mod );
					}
					return $mod;
				};
				

			} elseif ( ! empty( $fields[ $name ] ) ) {

				unset( $fields[ $name ] );

			}

		}

		return $fields;
	}

	/**
	 * Add themeMods to root type schema
	 * @since  				0.1.0
	 * @return array 	filtered fields
	 */
	public function graphql_root_queries($fields) {
		if ( ! $this->_theme_mods ) {
			return $fields;
		}

		$fields[ 'themeMods' ] = ThemeModQuery::root_query();
		
		return $fields;
	}

	/**
	 * Render the text for the general section
	 *
	 * @since  0.0.1
	 */
	public function wp_graphql_extra_options_general_cb() {

	}

	/**
	 * Render text field for _endpoint field
	 *
	 * @since  1.2.0
	 */
	public function wp_graphql_extra_options_endpoint_cb() {
		$endpoint = $this->_endpoint;
		$siteurl = get_option( 'siteurl', false );

		if ( $siteurl ) echo $siteurl . '/';
		?>		
			<input type="text" placeholder="<?php echo esc_textarea( $endpoint ) ?>" value="<?php echo esc_textarea( $endpoint ) ?>"name="<?php echo $this->option_name . '_endpoint' ?>" id="<?php echo $this->option_name . '_endpoint' ?>" />
			<br>
			<span class="description">
				<?php _e( 'Change graphql endpoint', 'wp-graphql-extra-options' ) ?>
			</span>
		<?php
	}

	/**
	 * Render the textarea field for selected option
	 *
	 * @since  0.1.0
	 */
	public function wp_graphql_extra_options_selected_cb() {
		$settings = $this->_selected;
		?>		
			<textarea class="wpgeo-textarea" name="<?php echo $this->option_name . '_selected' ?>" id="<?php echo $this->option_name . '_selected' ?>"><?php
				if( is_array( $settings ) ) {
					foreach( $settings as $key => $value ) {
						$name = esc_textarea( $key );
						$type = esc_textarea( $value[ 'type' ] );
						$description = esc_textarea( $value[ 'description' ] );
						echo "{$name}{$this->delimiter}{$type}{$this->delimiter}{$description}\r\n";
					}
				}
			?></textarea>
			<br>
			<span class="description">
				<?php echo "Enter slug of desired settings in \"name{$this->delimiter}type{$this->delimiter}description\" format, separated by a new line." ?>
				<br />
				<?php echo "Ex. \"page_on_front{$this->delimiter}integer{$this->delimiter}static page used as home page" ?>
				<br />
				<?php echo "page_for_posts{$this->delimiter}integer{$this->delimiter}page used to display blog posts\"." ?>
				<br />
				<?php echo '<a href="https://codex.wordpress.org/Option_Reference" target="_blank">Option Reference</a>' ?>
			</span>
		<?php
	}

	/**
	 * Render checkbox for _theme_mods field
	 *
	 * @since  0.0.1
	 */
	public function wp_graphql_extra_options_theme_mods_cb() {
		$checked = ( $this->_theme_mods ) ? 'checked': '';
		?>		
			<input type="checkbox" <?php echo $checked ?> name="<?php echo $this->option_name . '_theme_mods' ?>" id="<?php echo $this->option_name . '_theme_mods' ?>" />
			<br>
			<span class="description">
				<?php _e( 'Check to add theme modification to WPGraphQL Types schema', 'wp-graphql-extra-options' ) ?>
			</span>
		<?php
	}

	/**
	 * Render _filter_mods textarea
	 *
	 * @since  0.1.0
	 */
	public function wp_graphql_extra_options_filter_mods_cb() {
		$filter_mods = $this->_filter_mods;
		?>		
			<textarea class="wpgeo-textarea" name="<?php echo $this->option_name . '_filter_mods' ?>" id="<?php echo $this->option_name . '_filter_mods' ?>"><?php
				if( is_array( $filter_mods ) ) {
					foreach( $filter_mods as $name => $value ) {

						if ( false === $value ) {
							
							echo '!' . esc_textarea( $name ) . PHP_EOL;

						} elseif ( is_array( $value ) ) {
							
							$name = esc_textarea( $name );
							$type = esc_textarea( $value[ 'type' ] );
							$description = esc_textarea( $value[ 'description' ] );
							echo "{$name}{$this->delimiter}{$type}{$this->delimiter}{$description}" . PHP_EOL;
						
						}

					}
				}
			?></textarea>
			<br>
			<span class="description">
				<?php echo "Modify ThemeModType schema with simpleExclude a mod a simple script" ?>
				<br />
				<?php echo "Exclude a mod: \"!mod_name\"" ?>
				<br />
				<?php echo "Redefine mod: \"mod_name{$this->delimiter}type{$this->delimiter}description\"" ?>
				<br />
				<?php echo 'The current valid types are "integer, "boolean", "number", "string"' ?>
			</span>
		<?php
	}

	/**
	 * Sanitize the _endpoint value before being saved to database
	 *
	 * @param  string	$endpoint $_POST value
	 * @since  				1.2.0
	 * @return string Sanitized value
	 */
	public function wp_graphql_extra_options_sanitize_endpoint( $endpoint ) {

		return sanitize_text_field( $endpoint );

	}

	/**
	 * Sanitize the selected value before being saved to database
	 *
	 * @param  string	$selected $_POST value
	 * @since  				0.1.1
	 * @return string Sanitized value
	 */
	public function wp_graphql_extra_options_sanitize_selected( $selected ) {

		if ( false === $selected ) return $selected;

		$lines = explode( PHP_EOL, $selected);
		$settings = array();
		foreach( $lines as $line ) {
			
			/**
			 * Validate and sanitize line
			 */
			$parts = explode( $this->delimiter, $line );
			
			$length = count ( $parts );
			if ( $length < 2 || $length > 3 ) {
				// TODO - throw invalid number of arguments error
				continue;
			}

			if ( false === $parts[0] || in_array( $parts[0], $settings ) ) {
				// TODO - throw invalid setting name error
				continue;
			}
			$name = sanitize_text_field( $parts[0] );
			$settings[ $name ] = [];
	
			if ( false === $parts[1] ) {
				// TODO - throw invalid setting type error
				continue;
			}
			$settings[ $name ][ 'type' ] = sanitize_text_field( $parts[1] );

			if ( false !== $parts[2] ) {
				$settings[ $name ][ 'description' ] = sanitize_text_field( $parts[2] );
			}
		}

		/**
		 * Get all registered settings
		 */
		$registered_keys = array_keys( wp_load_alloptions() );
		
		/**
		 * Validate user input
		 */
		$valid = array();
		foreach( $settings as $name => $value) {
			// Skip non-existing or duplicates
			if ( ! in_array( $name, $registered_keys, true ) || in_array( $name, $valid ) ) {
				// TODO: and error output for invalid entries
				continue;
			}

			$valid[$name] = $value;
		}

		if ( ! empty( $valid )) {

			$selected = json_encode( $valid );
		
		}	else {
			
			$selected = '';

		}
		
		return $selected;

	}

	/**
	 * Sanitize the _theme_mods value before being saved to database
	 *
	 * @param  string	$theme_mods $_POST value
	 * @since  				0.1.0
	 * @return string Sanitized value
	 */
	public function wp_graphql_extra_options_sanitize_theme_mods( $theme_mods ) {

		if ( $theme_mods ) return true;
		return false;

	}

	/**
	 * Sanitize the filter_mods value before being saved to database
	 *
	 * @param  string	$filter_mods $_POST value
	 * @since  				0.1.1
	 * @return string Sanitized value
	 */
	public function wp_graphql_extra_options_sanitize_filter_mods( $filter_mods ) {

		if ( false === $filter_mods ) return $filter_mods;

		$entries = explode( PHP_EOL, $filter_mods);
		$filter_array = [];
		foreach( $entries as $entry ) {
			
			if ( '!' === $entry[0] ) {
				$filter_array[ substr( $entry, 1 ) ] = false;
				continue;
			}

			/**
			 * Validate and sanitize line
			 */
			$parts = explode( $this->delimiter, $entry );
			
			/**
			 * Confirm part count and name or skip
			 */
			$length = count ( $parts );
			if ( $length < 2 || $length > 3 ) {
				// TODO - throw invalid number of arguments error
				continue;
			}

			if ( false === $parts[0] || in_array( $parts[0], $entry ) ) {
				// TODO - throw invalid setting name error
				continue;
			}

			/**
			 * Sanitize input and build filter
			 */
			$name = sanitize_text_field( $parts[0] );
			$filter_array[ $name ] = [];
	
			if ( false === $parts[1] ) {
				// TODO - throw invalid setting type error
				continue;
			}
			$filter_array[ $name ][ 'type' ] = sanitize_text_field( $parts[1] );

			if ( false !== $parts[2] ) {
				$filter_array[ $name ][ 'description' ] = sanitize_text_field( $parts[2] );
			}

		}

		if ( ! empty( $filter_array )) {

			$filter_mods = json_encode( $filter_array );
		
		}	else {
			
			$filter_mods = '';

		}
		
		return $filter_mods;

	}

}
