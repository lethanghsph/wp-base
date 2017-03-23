<?php
/**
 * Sidebar feature support for WPBase theme.
 *
 * @package WPBase
 */

/**
 * WPBase Sidebar Class.
 */
final class WPBase_Sidebar {
	/**
	 * //
	 *
	 * @var string
	 */
	protected static $cache_setting = array();

	/**
	 * Conditionally hook into WordPress.
	 */
	public static function init() {
		add_action( 'atfw_init', array( __CLASS__, '_register_metabox' ) );
		add_action( 'atfw_init', array( __CLASS__, '_register_termmeta' ) );
		add_action( 'customize_register', array( __CLASS__, '_register_customizer' ) );
	}

	/**
	 * Get sidebar name in current screen.
	 *
	 * @return string
	 */
	public static function get_sidebar() {
		return static::has_sidebar() ? static::get_setting( 'name' ) : '';
	}

	/**
	 * Get sidebar area in current screen.
	 *
	 * @return string
	 */
	public static function get_sidebar_area() {
		return static::get_setting( 'area' );
	}

	/**
	 * If current screen is no sidebar.
	 *
	 * @return boolean
	 */
	public static function is_no_sidebar() {
		return static::get_setting( 'area' ) === 'none';
	}

	/**
	 * If current screen have a sidebar.
	 *
	 * @return boolean
	 */
	public static function has_sidebar() {
		return static::get_setting( 'area' ) !== 'none';
	}

	/**
	 * Get sidebar setting in current screen.
	 *
	 * @param  string $get Key name to get.
	 * @return string|array
	 */
	public static function get_setting( $get = null ) {
		if ( $setting = static::$cache_setting ) {
			return isset( $setting[ $get ] ) ? $setting[ $get ] : $setting;
		}

		$options = (array) get_option( 'wpbase-sidebar', array() );

		foreach ( static::allowed_pages() as $id => $name ) {
			$_default = array(
				'name' => static::default_sidebar( $id ),
				'area' => static::default_area(),
			);

			if ( isset( $options[ $id ] ) ) {
				$options[ $id ] = wp_parse_args( $options[ $id ], $_default );
			} else {
				$options[ $id ] = $_default;
			}
		}

		if ( is_home() ) {

			$setting = $options['home'];

		} elseif ( function_exists( 'is_shop' ) && is_shop() ) {

			$setting = $options['shop'];

		} elseif ( is_tax() || is_archive() || is_search() ) {
			if ( function_exists( 'is_product_taxonomy' ) && is_product_taxonomy() ) {
				$setting = $options['shop_archive'];
			} else {
				$setting = $options['archive'];
			}

			$_term = get_queried_object();

			// If we in taxonomy page...
			if ( isset( $_term->term_id ) ) {
				$_meta_data = get_term_meta( $_term->term_id, 'wpbase-sidebar', true );

				if ( is_array( $_meta_data ) && ! empty( $_meta_data['is_overwrite'] ) ) {
					unset( $_meta_data['is_overwrite'] );
					$setting = $_meta_data;
				}
			}
		} elseif ( is_single() || is_page() ) {
			if ( function_exists( 'is_product' )  && is_product() && isset( $option['product'] ) ) {
				$setting = $option['product'];
			} else {
				$_key = is_single() ? 'single' : 'page';
				$setting = $options[ $_key ];
			}

			$_meta_data = get_post_meta( get_the_ID(), 'wpbase-sidebar', true );

			if ( is_array( $_meta_data ) && ! empty( $_meta_data['is_overwrite'] ) ) {
				unset( $_meta_data['is_overwrite'] );
				$setting = $_meta_data;
			}
		} else {
			$setting = array(
				'name' => static::default_sidebar(),
				'area' => static::default_area(),
			);
		}

		static::$cache_setting = apply_filters( 'wpbase_get_sidebar_setting', $setting, $options );

		return isset( static::$cache_setting[ $get ] ) ? static::$cache_setting[ $get ] : static::$cache_setting;
	}

	/**
	 * //
	 *
	 * @param string $id Sidebar area name.
	 * @return string
	 */
	public static function default_sidebar( $id = null ) {
		$default_sidebar = 'sidebar-1';

		if ( in_array( $id, array( 'shop', 'shop_archive', 'product' ) ) ) {
			return $default_sidebar = 'shop';
		}

		return apply_filters( 'wpbase_sidebar_default', $default_sidebar );
	}

	/**
	 * //
	 *
	 * @return string
	 */
	public static function default_area() {
		$default_sidebar = 'right';

		return apply_filters( 'wpbase_sidebar_area_default', $default_sidebar );
	}

	/**
	 * Get default sidebar area.
	 *
	 * @return array
	 */
	public static function sidebar_area() {
		$sidebar_area = array(
			'none'  => esc_html__( 'No Sidebar', 'wpbase' ),
			'left'  => esc_html__( 'Sidebar Left', 'wpbase' ),
			'right' => esc_html__( 'Sidebar Right', 'wpbase' ),
		);

		/**
		 * Apply filter and return sidebar area.
		 */
		return apply_filters( 'wpbase_sidebar_area', $sidebar_area );
	}

	/**
	 * Allowed pages can register in customizer.
	 *
	 * @return array
	 */
	protected static function allowed_pages() {
		$pages = array(
			'home'     => esc_html__( 'Blog (Index)', 'wpbase' ),
			'archive'  => esc_html__( 'Archive', 'wpbase' ),
			'page'     => esc_html__( 'Page', 'wpbase' ),
			'single'   => esc_html__( 'Single', 'wpbase' ),
			'shop'     => esc_html__( 'Shop', 'wpbase' ),
			'shop_archive' => esc_html__( 'Shop Archive', 'wpbase' ),
			// 'product'   => esc_html__( 'Product', 'wpbase' ),
		);

		return $pages;
	}

	/**
	 * Add settings to the Customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer object.
	 */
	public static function _register_customizer( $wp_customize ) {
		$wp_customize->add_panel( 'wpbase_sidebar', array(
			'title'          => esc_html__( 'Sidebar', 'wpbase' ),
			'theme_supports' => '',
		) );

		foreach ( static::allowed_pages() as $id => $name ) {
			$id = sanitize_key( $id );
			$section_id = sprintf( 'wpbase_sidebar_%s', $id );

			$sidebar_id = sprintf( 'wpbase-sidebar[%s][name]', $id );
			$sidebar_area_id = sprintf( 'wpbase-sidebar[%s][area]', $id );

			// Add Customizer Section.
			$wp_customize->add_section( $section_id, array(
				'title'  => $name,
				'panel'  => 'wpbase_sidebar',
			) );

			// Add Customizer Settings.
			$wp_customize->add_setting( $sidebar_area_id, array(
				'default'           => static::default_area( $id ),
				'type'              => 'option',
				'sanitize_callback' => array( __CLASS__, 'sanitize_sidebar_area' ),
			) );

			$wp_customize->add_setting( $sidebar_id, array(
				'default'           => static::default_sidebar( $id ),
				'type'              => 'option',
				'sanitize_callback' => array( __CLASS__, 'sanitize_sidebar' ),
			) );

			// Add Customizer Controls.
			$wp_customize->add_control( $sidebar_area_id, array(
				'type'    => 'select',
				'section' => $section_id,
				'label'   => esc_html__( 'Sidebar Area', 'wpbase' ),
				'choices' => static::sidebar_area(),
			) );

			$wp_customize->add_control( $sidebar_id, array(
				'type'    => 'select',
				'section' => $section_id,
				'label'   => esc_html__( 'Sidebar Name', 'wpbase' ),
				'choices' => static::registered_sidebars(),
			) );
		}
	}

	/**
	 * Register sidebar metabox.
	 *
	 * @param  ATFW $atfw ATFW Instance.
	 */
	public static function _register_metabox( ATFW $atfw ) {
		 // Add 'product' if you want single product sidebar active.
		$screen = apply_filters( 'wpbase_sidebar_metabox_screen', array( 'post', 'page', 'product' ) );

		$args = array(
			'title'   => esc_html__( 'Sidebar', 'wpbase' ),
			'screen'  => $screen,
			'fields'  => static::metabox_fields(),
			'context' => 'side',
		);

		$atfw->register_metabox( new ATFW_Metabox( 'wpbase-sidebar', $args ) );
	}

	/**
	 * Register sidebar term meta.
	 *
	 * @param  ATFW $atfw ATFW Instance.
	 */
	public static function _register_termmeta( ATFW $atfw ) {
		$taxonomy = apply_filters( 'wpbase_sidebar_taxonomy', array( 'category', 'post_tag', 'product_cat', 'product_tag' ) );

		$args = array(
			'id'       => 'wpbase-sidebar',
			'title'    => esc_html__( 'Sidebar', 'wpbase' ),
			'taxonomy' => $taxonomy,
		);

		$atfw->register_term_metabox( $args, static::metabox_fields() );
	}

	/**
	 * //
	 *
	 * @return array
	 */
	protected static function metabox_fields() {
		return array(
			array(
				'id'      => 'is_overwrite',
				'type'    => 'checkbox',
				'label'   => esc_html__( 'Use custom sidebar setting?', 'wpbase' ),
				'default' => false,
			),

			array(
				'id'      => 'area',
				'type'    => 'select',
				'title'   => esc_html__( 'Sidebar Area', 'wpbase' ),
				'options' => static::sidebar_area(),
				'default' => static::default_area(),
				'dependency' => array( 'is_overwrite', '==', 'true' ),
			),

			array(
				'id'      => 'name',
				'type'    => 'select',
				'title'   => esc_html__( 'Sidebar Name', 'wpbase' ),
				'options' => static::registered_sidebars(),
				'default' => static::default_sidebar(),
				'dependency' => array( 'is_overwrite|area', '==|!=', 'true|none' ),
			),
		);
	}

	/**
	 * Get WP registered sidebar.
	 *
	 * @return array
	 */
	public static function registered_sidebars() {
		global $wp_registered_sidebars;

		$sidebars = array();

		foreach ( $wp_registered_sidebars as $id => $sidebar ) {
			$sidebars[ $id ] = $sidebar['name'];
		}

		return $sidebars;
	}

	/**
	 * Helper sanitize sidebar name.
	 *
	 * @param  string $sidebar Raw sidebar name.
	 * @return string
	 */
	public static function sanitize_sidebar( $sidebar ) {
		$allowed_sidebars = (array) static::registered_sidebars();

		if ( ! array_key_exists( $sidebar, $allowed_sidebars ) ) {
			$sidebar = static::default_sidebar();
		}

		return $sidebar;
	}

	/**
	 * Helper sanitize sidebar area.
	 *
	 * @param  string $sidebar_area Raw sidebar area.
	 * @return string
	 */
	public static function sanitize_sidebar_area( $sidebar_area ) {
		$allowed_sidebar_area = (array) static::sidebar_area();

		if ( ! array_key_exists( $sidebar_area, $allowed_sidebar_area ) ) {
			$sidebar_area = static::default_area();
		}

		return $sidebar_area;
	}
}
WPBase_Sidebar::init();
