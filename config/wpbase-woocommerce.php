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
		add_filter( 'loop_shop_per_page', array( $this, 'custom_ppp' ) );
		add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'add_to_cart_fragments' ) );

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

	/**
	 * WooCommerce cart fragments.
	 *
	 * @param [array] $fragments [fragment].
	 */
	public function add_to_cart_fragments( $fragments ) {
		$fragments['#menu-mincart-link'] = $this->header_minicart_link();
		$fragments['#header-mini-cart'] = $this->header_minicart();
		return $fragments;
	}

	/**
	 * Render header minicart html.
	 */
	public function header_minicart() {
		ob_start();
		echo '<div id="header-mini-cart" aria-labelledby="menu-mincart-link">';
		woocommerce_mini_cart();
		echo '</div>';
		return ob_get_clean();
	}

	/**
	 * Render minicart link html.
	 */
	public function header_minicart_link() {
		global $woocommerce;
		$output = '<span class="thangle"></span>';
		$output .= '<a id="menu-mincart-link" href="' . wc_get_cart_url() . '" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" data-target="#">';
		$output .= '<span class="screen-reader-text">' . esc_html__( 'Cart', 'wpbase' ) . '</span>';
		$output .= '<span class="menu-cart-icon"><i class="fa fa-shopping-bag"></i></span>';
		$output .= '<span class="menu-cart-count count">';
		$output .= WC()->cart->get_cart_contents_count();
		$output .= '</span>';
		$output .= '</a>';
		return $output;
	}
}
if ( class_exists( 'WooCommerce' ) ) {
	WPBase_WooCoomerce::get_instance();
}
