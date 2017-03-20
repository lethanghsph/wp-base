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
	}

	/**
	 * Load options fields
	 */
	public function load_config() {
		get_template_part( 'config/wpbase-config' );
		get_template_part( 'config/wpbase-header' );
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
