<?php
/**
 * Controller WPBase.
 *
 * @package wpbase
 */

/**
 * //
 */
class WPBase_Config {
	/**
	 * Load template part
	 *
	 * @param  [string|array] $part [template].
	 * @param  array          $args [options].
	 */
	public function load_template_part( $part, array $args = array() ) {
		// Check file exit.
		$template_part = locate_template( $part );
		if ( ! file_exists( $template_part ) ) {
			return;
		}

		if ( ! empty( $args ) ) {
			extract( $args );
		}
		locate_template( $part, true, false );
	}

}
