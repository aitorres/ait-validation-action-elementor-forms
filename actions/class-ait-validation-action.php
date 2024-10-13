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

        $settings = $record->get( 'form-settings' );

        // Make sure that there are validations to run.
        if ( empty( $settings['ait_form_validations'] ) ) {
            return;
        }

        // Get submitted form data.
		$raw_fields = $record->get( 'fields' );

		// Normalize form data.
		$fields = [];
		foreach ( $raw_fields as $id => $field ) {
			$fields[ $id ] = $field['value'];
		}

        // Iterate over validations to run them
        foreach ( $settings['ait_form_validations'] as $index => $item ) {

            $validation_action = $item['validation_action'];
            $validation_field_id = $item['validation_field_id'];
            $validation_value = $item['validation_value'];

            // Checking if the field exists in the form
            if ( ! isset( $fields[ $validation_field_id ] ) ) {
                continue;
            }

            // Get the field value to validate
            $field_value = $fields[ $validation_field_id ];

            // Run the validation
            switch ( $validation_action ) {
                case 'min_length':
                    if ( strlen( $field_value ) < $validation_value ) {
                        $ajax_handler->add_error( $validation_field_id, sprintf( esc_html__( 'Field must be at least %d characters long.', 'ait-validation-action-elementor-forms' ), $validation_value ) );
                    }
                    break;
                case 'less_than':
                    if ( $field_value >= $validation_value ) {
                        $ajax_handler->add_error( $validation_field_id, sprintf( esc_html__( 'Field must be less than %s.', 'ait-validation-action-elementor-forms' ), $validation_value ) );
                    }
                    break;
                case 'greater_than':
                    if ( $field_value <= $validation_value ) {
                        $ajax_handler->add_error( $validation_field_id, sprintf( esc_html__( 'Field must be greater than %s.', 'ait-validation-action-elementor-forms' ), $validation_value ) );
                    }
                    break;
                case 'starts_with':
                    if ( strpos( $field_value, $validation_value ) !== 0 ) {
                        $ajax_handler->add_error( $validation_field_id, sprintf( esc_html__( 'Field must start with %s.', 'ait-validation-action-elementor-forms' ), $validation_value ) );
                    }
                    break;
                case 'ends_with':
                    if ( substr( $field_value, -strlen( $validation_value ) ) !== $validation_value ) {
                        $ajax_handler->add_error( $validation_field_id, sprintf( esc_html__( 'Field must end with %s.', 'ait-validation-action-elementor-forms' ), $validation_value ) );
                    }
                    break;
                case 'contains':
                    if ( strpos( $field_value, $validation_value ) === false ) {
                        $ajax_handler->add_error( $validation_field_id, sprintf( esc_html__( 'Field must contain %s.', 'ait-validation-action-elementor-forms' ), $validation_value ) );
                    }
                    break;
                case 'regex':
                    if ( ! preg_match( $validation_value, $field_value ) ) {
                        $ajax_handler->add_error( $validation_field_id, esc_html__( 'Field does not match the required pattern', 'ait-validation-action-elementor-forms' ) );
                    }
                    break;
            }
        }

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

        $widget->start_controls_section(
            'section_ait_validation_action',
            [
                'label' => esc_html__( 'AIT Validation Action', 'ait-validation-action-elementor-forms' ),
                'condition' => [
                    'submit_actions' => $this->get_name(),
                ],
            ]
        );

        $widget->add_control(
            'ait_form_validations',
            [
                'label' => esc_html__( 'Form Validations', 'ait-validation-action-elementor-forms' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'validation_action',
                        'label' => esc_html__( 'Validation Action', 'ait-validation-action-elementor-forms' ),
                        'type' => \Elementor\Controls_Manager::SELECT,
                        'options' => [
                            'min_length' => esc_html__( 'Minimum Length', 'ait-validation-action-elementor-forms' ),
                            'less_than' => esc_html__( 'Less Than', 'ait-validation-action-elementor-forms' ),
                            'greater_than' => esc_html__( 'Greater Than', 'ait-validation-action-elementor-forms' ),
                            'starts_with' => esc_html__( 'Starts With', 'ait-validation-action-elementor-forms' ),
                            'ends_with' => esc_html__( 'Ends With', 'ait-validation-action-elementor-forms' ),
                            'contains' => esc_html__( 'Contains', 'ait-validation-action-elementor-forms' ),
                            'regex' => esc_html__( 'Regular Expression', 'ait-validation-action-elementor-forms' ),
                        ],
                        'default' => 'min_length',
                    ],
                    [
                        'name' => 'validation_field_id',
                        'label' => esc_html__( 'Validation Field ID', 'ait-validation-action-elementor-forms' ),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => '',
                    ],
                    [
                        'name' => 'validation_value',
                        'label' => esc_html__( 'Validation Value', 'ait-validation-action-elementor-forms' ),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => '',
                    ]
                ],
                'default' => [],
                'title_field' => '{{{ validation_field }}}',
            ]
        );

        $widget->end_controls_section();

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