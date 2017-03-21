<?php
/**
 * Controller WPBase header.
 *
 * @package wpbase
 */

/**
 * //
 */
class WPBase_Header extends WPBase_Config {
	/**
	 * Render header html.
	 */
	public function actionHeader() {
		$template_parts = 'template-parts/header/header.php';
		$this->load_template_part( $template_parts );
	}

	// public function addSettings() {
		
	// }
}
