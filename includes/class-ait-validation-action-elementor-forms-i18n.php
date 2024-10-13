<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://aitorres.com
 * @since      1.0.0
 *
 * @package    Ait_Validation_Action_Elementor_Forms
 * @subpackage Ait_Validation_Action_Elementor_Forms/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Ait_Validation_Action_Elementor_Forms
 * @subpackage Ait_Validation_Action_Elementor_Forms/includes
 * @author     Andrés Ignacio Torres <dev@aitorres.com>
 */
class Ait_Validation_Action_Elementor_Forms_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'ait-validation-action-elementor-forms',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
