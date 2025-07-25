<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ait-form-validation-action-addon-for-elementor-constants.php';

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
        return esc_html__( 'AIT Validation Action', 'ait-form-validation-action-addon-for-elementor' );
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

        $settings = $record->get( 'form_settings' );

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
            $custom_error_message = isset($item['custom_error_message']) && !empty($item['custom_error_message'])
                ? $item['custom_error_message']
                : '';

            // Checking if the field exists in the form
            if ( ! isset( $fields[ $validation_field_id ] ) ) {
                continue;
            }

            // Get the field value to validate
            $field_value = $fields[ $validation_field_id ];

            // Run the validation
            switch ( $validation_action ) {
                case Ait_Validation_Action_Elementor_Forms_Constants::ACTION_MIN_LENGTH:
                    if ( strlen( $field_value ) < $validation_value ) {
                        $this->add_validation_error(
                            $ajax_handler,
                            $validation_field_id,
                            $custom_error_message,
                            'Field must be at least %d characters long.',
                            $validation_value
                        );
                    }
                    break;
                case Ait_Validation_Action_Elementor_Forms_Constants::ACTION_MAX_LENGTH:
                    if ( strlen( $field_value ) > $validation_value ) {
                        $this->add_validation_error(
                            $ajax_handler,
                            $validation_field_id,
                            $custom_error_message,
                            'Field must be at most %d characters long.',
                            $validation_value
                        );
                    }
                    break;
                case Ait_Validation_Action_Elementor_Forms_Constants::ACTION_MIN_WORDS:
                    if ( str_word_count( $field_value ) < $validation_value ) {
                        $this->add_validation_error(
                            $ajax_handler,
                            $validation_field_id,
                            $custom_error_message,
                            'Field must have at least %d words.',
                            $validation_value
                        );
                    }
                    break;
                case Ait_Validation_Action_Elementor_Forms_Constants::ACTION_MAX_WORDS:
                    if ( str_word_count( $field_value ) > $validation_value ) {
                        $this->add_validation_error(
                            $ajax_handler,
                            $validation_field_id,
                            $custom_error_message,
                            'Field must have at most %d words.',
                            $validation_value
                        );
                    }
                    break;
                case Ait_Validation_Action_Elementor_Forms_Constants::ACTION_STARTS_WITH:
                    if ( strpos( $field_value, $validation_value ) !== 0 ) {
                        $this->add_validation_error(
                            $ajax_handler,
                            $validation_field_id,
                            $custom_error_message,
                            'Field must start with %s.',
                            $validation_value
                        );
                    }
                    break;
                case Ait_Validation_Action_Elementor_Forms_Constants::ACTION_ENDS_WITH:
                    if ( substr( $field_value, -strlen( $validation_value ) ) !== $validation_value ) {
                        $this->add_validation_error(
                            $ajax_handler,
                            $validation_field_id,
                            $custom_error_message,
                            'Field must end with %s.',
                            $validation_value
                        );
                    }
                    break;
                case Ait_Validation_Action_Elementor_Forms_Constants::ACTION_CONTAINS:
                    if ( strpos( $field_value, $validation_value ) === false ) {
                        $this->add_validation_error(
                            $ajax_handler,
                            $validation_field_id,
                            $custom_error_message,
                            'Field must contain %s.',
                            $validation_value
                        );
                    }
                    break;
                case Ait_Validation_Action_Elementor_Forms_Constants::ACTION_MATCHES_FIELD:
                    // Checking if the field to match exists in the form
                    if ( ! isset( $fields[ $validation_value ] ) ) {
                        break;
                    }

                    // Get the field value to match
                    $field_to_match = $fields[ $validation_value ];

                    if ( $field_value !== $field_to_match ) {
                        $this->add_validation_error(
                            $ajax_handler,
                            $validation_field_id,
                            $custom_error_message,
                            'Field does not match the required field.'
                        );
                    }
                    break;
                case Ait_Validation_Action_Elementor_Forms_Constants::ACTION_AFTER_THAN:
                    if ( strtotime( $field_value ) <= strtotime( $validation_value ) ) {
                        $this->add_validation_error(
                            $ajax_handler,
                            $validation_field_id,
                            $custom_error_message,
                            'Field must be after %s.',
                            $validation_value
                        );
                    }
                    break;
                case Ait_Validation_Action_Elementor_Forms_Constants::ACTION_BEFORE_THAN:
                    if ( strtotime( $field_value ) >= strtotime( $validation_value ) ) {
                        $this->add_validation_error(
                            $ajax_handler,
                            $validation_field_id,
                            $custom_error_message,
                            'Field must be before %s.',
                            $validation_value
                        );
                    }
                    break;
                case Ait_Validation_Action_Elementor_Forms_Constants::ACTION_AFTER_THAN_FIELD:
                    // Checking if the field to match exists in the form
                    if ( ! isset( $fields[ $validation_value ] ) ) {
                        break;
                    }

                    // Get the field value to match
                    $field_to_match = $fields[ $validation_value ];

                    if ( strtotime( $field_value ) <= strtotime( $field_to_match ) ) {
                        $this->add_validation_error(
                            $ajax_handler,
                            $validation_field_id,
                            $custom_error_message,
                            'Field must be after the required field.'
                        );
                    }
                    break;
                case Ait_Validation_Action_Elementor_Forms_Constants::ACTION_BEFORE_THAN_FIELD:
                    // Checking if the field to match exists in the form
                    if ( ! isset( $fields[ $validation_value ] ) ) {
                        break;
                    }

                    // Get the field value to match
                    $field_to_match = $fields[ $validation_value ];

                    if ( strtotime( $field_value ) >= strtotime( $field_to_match ) ) {
                        $this->add_validation_error(
                            $ajax_handler,
                            $validation_field_id,
                            $custom_error_message,
                            'Field must be before the required field.'
                        );
                    }
                    break;
                case Ait_Validation_Action_Elementor_Forms_Constants::ACTION_MATCHES_REGEX:
                    if ( ! preg_match( $validation_value, $field_value ) ) {
                        $this->add_validation_error(
                            $ajax_handler,
                            $validation_field_id,
                            $custom_error_message,
                            'Field must match the required pattern %s.',
                            $validation_value
                        );
                    }
                    break;
            }
        }

    }

    /**
     * Add validation error with custom or default message.
     *
     * @since 1.0.0
     * @access private
     * @param \ElementorPro\Modules\Forms\Classes\Ajax_Handler $ajax_handler
     * @param string $field_id
     * @param string $custom_message
     * @param string $default_message
     * @param mixed $validation_value
     */
    private function add_validation_error( $ajax_handler, $field_id, $custom_message, $default_message, $validation_value = null ) {
        if ( !empty( $custom_message ) ) {
            $error_message = $validation_value !== null
                ? esc_html( sprintf( $custom_message, $validation_value ) )
                : esc_html( $custom_message );
        } else {
            $error_message = $validation_value !== null
                ? sprintf( esc_html__( $default_message, 'ait-form-validation-action-addon-for-elementor' ), $validation_value )
                : esc_html__( $default_message, 'ait-form-validation-action-addon-for-elementor' );
        }

        $ajax_handler->add_error( $field_id, $error_message );
    }

    /**
     * Register action controls.
     *
     * Allows users to set up a series of validations comprised
     * of action, field ID, and validation value.
     *
     * @since 1.0.0
     * @access public
     * @param \Elementor\Widget_Base $widget
     */
    public function register_settings_section( $widget ) {

        $widget->start_controls_section(
            'section_ait_validation_action',
            [
                'label' => esc_html__( 'AIT Validation Action', 'ait-form-validation-action-addon-for-elementor' ),
                'condition' => [
                    'submit_actions' => $this->get_name(),
                ],
            ]
        );

        $widget->add_control(
            'ait_form_validations',
            [
                'label' => esc_html__( 'Form Validations', 'ait-form-validation-action-addon-for-elementor' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'validation_action',
                        'description' => esc_html__( 'Select the validation action to perform on the field.', 'ait-form-validation-action-addon-for-elementor' ),
                        'label' => esc_html__( 'Validation Action', 'ait-form-validation-action-addon-for-elementor' ),
                        'type' => \Elementor\Controls_Manager::SELECT,
                        'options' => [
                            Ait_Validation_Action_Elementor_Forms_Constants::ACTION_MIN_LENGTH => esc_html__( 'Minimum Length', 'ait-form-validation-action-addon-for-elementor' ),
                            Ait_Validation_Action_Elementor_Forms_Constants::ACTION_MAX_LENGTH => esc_html__( 'Maximum Length', 'ait-form-validation-action-addon-for-elementor' ),
                            Ait_Validation_Action_Elementor_Forms_Constants::ACTION_STARTS_WITH => esc_html__( 'Starts With', 'ait-form-validation-action-addon-for-elementor' ),
                            Ait_Validation_Action_Elementor_Forms_Constants::ACTION_ENDS_WITH => esc_html__( 'Ends With', 'ait-form-validation-action-addon-for-elementor' ),
                            Ait_Validation_Action_Elementor_Forms_Constants::ACTION_CONTAINS => esc_html__( 'Contains', 'ait-form-validation-action-addon-for-elementor' ),
                            Ait_Validation_Action_Elementor_Forms_Constants::ACTION_MATCHES_FIELD => esc_html__( 'Matches Field', 'ait-form-validation-action-addon-for-elementor' ),
                            Ait_Validation_Action_Elementor_Forms_Constants::ACTION_MIN_WORDS => esc_html__( 'Minimum Words', 'ait-form-validation-action-addon-for-elementor' ),
                            Ait_Validation_Action_Elementor_Forms_Constants::ACTION_MAX_WORDS => esc_html__( 'Maximum Words', 'ait-form-validation-action-addon-for-elementor' ),
                            Ait_Validation_Action_Elementor_Forms_Constants::ACTION_AFTER_THAN => esc_html__( 'After Than', 'ait-form-validation-action-addon-for-elementor' ),
                            Ait_Validation_Action_Elementor_Forms_Constants::ACTION_BEFORE_THAN => esc_html__( 'Before Than', 'ait-form-validation-action-addon-for-elementor' ),
                            Ait_Validation_Action_Elementor_Forms_Constants::ACTION_AFTER_THAN_FIELD => esc_html__( 'After Than Field', 'ait-form-validation-action-addon-for-elementor' ),
                            Ait_Validation_Action_Elementor_Forms_Constants::ACTION_BEFORE_THAN_FIELD => esc_html__( 'Before Than Field', 'ait-form-validation-action-addon-for-elementor' ),
                            Ait_Validation_Action_Elementor_Forms_Constants::ACTION_MATCHES_REGEX => esc_html__( 'Matches Regex', 'ait-form-validation-action-addon-for-elementor' ),
                        ],
                        'default' => Ait_Validation_Action_Elementor_Forms_Constants::ACTION_MIN_LENGTH,
                    ],
                    [
                        'name' => 'validation_field_id',
                        'description' => esc_html__( 'Enter the ID of the form field to validate. For optional fields, validation will only run if the field is not empty.', 'ait-form-validation-action-addon-for-elementor' ),
                        'label' => esc_html__( 'Validation Field ID', 'ait-form-validation-action-addon-for-elementor' ),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => '',
                    ],
                    [
                        'name' => 'validation_value',
                        'description' => esc_html__( 'Enter the value to validate against. For `Matches Field`, this should be another form field ID.', 'ait-form-validation-action-addon-for-elementor' ),
                        'label' => esc_html__( 'Validation Value', 'ait-form-validation-action-addon-for-elementor' ),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => '',
                    ],
                    [
                        'name' => 'custom_error_message',
                        'description' => esc_html__( 'Optional custom error message. Use %s as placeholder for the validation value. Leave blank to use the default.', 'ait-form-validation-action-addon-for-elementor' ),
                        'label' => esc_html__( 'Custom Error Message', 'ait-form-validation-action-addon-for-elementor' ),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => '',
                    ]
                ],
                'default' => [],
                'title_field' => '{{{ validation_field_id }}} - {{{ validation_action }}} - {{{ validation_value }}}',
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
