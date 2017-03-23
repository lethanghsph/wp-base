<?php
/**
 * Options WPBase.
 *
 * @package wpbase
 */

/**
 * //
 */
class WPBase_Options {
	/**
	 * Get options value.
	 *
	 * @param  [string] $name    [Options key].
	 * @param  [string] $default [Default value of option].
	 * @param  [string] $source  [The source to to get data: theme_mod | option ].
	 * @return [type]          [description]
	 */
	public function wpbase_option( $name, $default = null, $source = 'option' ) {
		$name = sanitize_key( $name );

		if ( is_null( $default ) ) {
			$default = $this->wpbase_option_default( $name );
		}

		if ( 'option' === $source ) {
			$option = get_option( $name, $default );
		} else {
			$option = get_theme_mod( $name, $default );
		}

		$option = apply_filters( 'wpbase_option_' . $name, $option );
		$option = apply_filters( 'wpbase_option', $option, $name );

		// Return it.
		return $option;
	}

	/**
	 * Get default options.
	 *
	 * @param  string $name Option key name to get.
	 * @return mixin
	 */
	public function wpbase_option_default( $name ) {
		static $defaults;

		if ( ! $defaults ) {

			$default = array();
			if ( file_exists( STYLESHEETPATH . '/' . 'config/options/defaults.php' ) ) {
				$defaults = require_once( STYLESHEETPATH . '/' . 'config/options/defaults.php');
			}
			$defaults = apply_filters( 'wpbase_option_default', $defaults );

		}

		return isset( $defaults[ $name ] ) ? $defaults[ $name ] : null;
	}

}
