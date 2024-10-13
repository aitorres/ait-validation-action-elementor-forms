<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * AIT Validation Action for Elementor Forms.
 *
 * Adds a custom action to Elementor Forms that allows
 * users to set up specific server-side validation
 * for their user fields.
 *
 * @since 1.0.0
 */
class Ait_Validation_Action extends \ElementorPro\Modules\Forms\Classes\Action_Base {

	/**
	 * Get action name.
	 *
	 * Retrieve AIT Validation Action name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string
	 */
	public function get_name() {
		return 'ait-validation-action';
	}

	/**
	 * Get action label.
	 *
	 * Retrieve AIT Validation Action label.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string
	 */
	public function get_label() {
		return esc_html__( 'AIT Validation Action', 'ait-validation-action-elementor-forms' );
	}

	/**
	 * Run action.
	 *
	 * Run custom validations and prevent the form from being submitted
     * and processed in case of validation errors.
     *
     * Report validation errors to the user via the AJAX handler.
	 *
	 * @since 1.0.0
	 * @access public
	 * @param \ElementorPro\Modules\Forms\Classes\Form_Record  $record
	 * @param \ElementorPro\Modules\Forms\Classes\Ajax_Handler $ajax_handler
	 */
	public function run( $record, $ajax_handler ) {

		// TODO: Complete the run method.

	}

	/**
	 * Register action controls.
	 *
	 * AIT Validation Action has no input fields to the form widget.
	 *
	 * @since 1.0.0
	 * @access public
	 * @param \Elementor\Widget_Base $widget
	 */
	public function register_settings_section( $widget ) {

        // TODO: Complete the register_settings_section method.

    }

	/**
	 * On export.
	 *
	 * AIT Validation Action has no fields to clear when exporting.
	 *
	 * @since 1.0.0
	 * @access public
	 * @param array $element
	 */
	public function on_export( $element ) {}

}