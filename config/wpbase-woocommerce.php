<?php
/**
 * Controller WooCommerce.
 *
 * @package wpbase
 */

/**
 * //
 */
class WPBase_WooCoomerce {

	/**
	 * Instance static.
	 *
	 * @var [object].
	 */
	public static $_instance;

	/**
	 * Get instance of static
	 */
	public static function get_instance() {
		if ( null === static::$_instance ) {
			static::$_instance = new static;
		}
		return static::$_instance;
	}

	/**
	 * Initialization.
	 */
	private function __construct() {
		add_filter( 'loop_shop_columns', array( $this, 'custom_column' ) );
		add_filter( 'body_class', array( $this, 'custom_column_class' ) );
		add_filter( 'loop_shop_per_page', array( $this, 'custom_ppp' ), 9999 );
	}
	/**
	 * Custom number of columns to show in archive products.
	 */
	public function custom_column() {
		$return = '';
		$return = WPBase()->options->wpbase_option( 'wc_column' );
		return $return;
	}

	/**
	 * Custom width of columns to show in archvie products.
	 *
	 * @param  [array] $class [class on body].
	 */
	public function custom_column_class( $class ) {
		$return = 'columns-';
		$return .= WPBase()->options->wpbase_option( 'wc_column' );
		$class[] = $return;
		return $class;
	}

	/**
	 * Return the number of products per page.
	 *
	 * @return int Products per page.
	 */
	public function custom_ppp() {

		$post_per_page = get_option( 'posts_per_page' );

		$shop_ppp = ( WPBase()->options->wpbase_option( 'shop_ppp' ) ) ? WPBase()->options->wpbase_option( 'shop_ppp' ) : $post_per_page;

		$shop_ppp = apply_filters( 'wpbase_shop_ppp', $shop_ppp );
		return intval( $shop_ppp );
	}
}
if ( class_exists( 'WooCommerce' ) ) {
	WPBase_WooCoomerce::get_instance();
}
