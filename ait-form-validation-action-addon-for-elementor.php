<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://aitorres.com
 * @since             1.0.0
 * @package           Ait_Validation_Action_Elementor_Forms
 *
 * @wordpress-plugin
 * Plugin Name:       Form Validation Action Addon for Elementor
 * Plugin URI:        https://aitorres.com/projects/form-validation-action-addon-for-elementor
 * Description:       Add a custom validation action for Forms to your Elementor installation to run server-side validation for your form fields.
 * Version:           1.0.0
 * Author:            Andrés Ignacio Torres
 * Author URI:        https://aitorres.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ait-form-validation-action-addon-for-elementor
 * Domain Path:       /languages
 *
 * Requires Plugins: elementor
 * Elementor tested up to: 3.24.0
 * Elementor Pro tested up to: 3.24.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'AIT_VALIDATION_ACTION_ELEMENTOR_FORMS_VERSION', '1.0.0' );

/**
 * The core plugin class that is used to define internationalization,
 * and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ait-form-validation-action-addon-for-elementor.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ait_validation_action_elementor_forms() {

    $plugin = new Ait_Validation_Action_Elementor_Forms();
    $plugin->run();

}
run_ait_validation_action_elementor_forms();
