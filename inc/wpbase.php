<?php
/**
 * Controller WPBase.
 *
 * @package wpbase
 */

/**
 * //
 */
final class WPBase {
	/**
	 * Header class.
	 *
	 * @var object
	 */
	public $header = null;
	/**
	 * Instance of WPBase_Config.
	 *
	 * @var [object]
	 */
	public static $_instance;

	/**
	 * Ensures only one instance of WPBase_Config is loaded or can be loaded.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * //
	 */
	public function __construct() {
		$this->load_config();
		$this->header = new WPBase_Header();
		$this->extra = new WPBase_Extra();
		$this->options = new WPBase_Options();
		$this->sidebar = new WPBase_Sidebar();
		$this->post_format = new WPBase_Post_Format();
		$this->post_template = WPBase_Post_Template_Tag::get_instance();
		$this->social = WPBase_Social::get_instance();
	}

	/**
	 * Load options fields
	 */
	public function load_config() {
		get_template_part( 'config/wpbase-config' );
		get_template_part( 'config/wpbase-header' );
		get_template_part( 'config/wpbase-extra' );
		get_template_part( 'config/wpbase-options' );
		get_template_part( 'config/wpbase-sidebar' );
		get_template_part( 'config/wpbase-post-format' );
		get_template_part( 'config/wpbase-social' );
		get_template_part( 'config/wpbase-woocommerce' );
	}
}

/**
 * [WPBase description]
 */
function WPBase() {
	return WPBase::instance();
}

// Global for backwards compatibility.
$GLOBALS['WPBase'] = WPBase();
