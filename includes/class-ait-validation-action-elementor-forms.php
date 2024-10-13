<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://aitorres.com
 * @since      1.0.0
 *
 * @package    Ait_Validation_Action_Elementor_Forms
 * @subpackage Ait_Validation_Action_Elementor_Forms/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Ait_Validation_Action_Elementor_Forms
 * @subpackage Ait_Validation_Action_Elementor_Forms/includes
 * @author     Andrés Ignacio Torres <dev@aitorres.com>
 */
class Ait_Validation_Action_Elementor_Forms {

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Ait_Validation_Action_Elementor_Forms_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct() {
        if ( defined( 'AIT_VALIDATION_ACTION_ELEMENTOR_FORMS_VERSION' ) ) {
            $this->version = AIT_VALIDATION_ACTION_ELEMENTOR_FORMS_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'ait-validation-action-elementor-forms';

        $this->load_dependencies();
        $this->set_locale();

    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Ait_Validation_Action_Elementor_Forms_Loader. Orchestrates the hooks of the plugin.
     * - Ait_Validation_Action_Elementor_Forms_i18n. Defines internationalization functionality.
     * - Ait_Validation_Action_Elementor_Forms_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {

        /**
         * The class responsible for orchestrating the actions of the
         * core plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ait-validation-action-elementor-forms-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ait-validation-action-elementor-forms-i18n.php';

        $this->loader = new Ait_Validation_Action_Elementor_Forms_Loader();

    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Ait_Validation_Action_Elementor_Forms_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale() {

        $plugin_i18n = new Ait_Validation_Action_Elementor_Forms_i18n();

        $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

    }

    public function add_ait_validation_action( $form_actions_registrar ) {

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'actions/class-ait-validation-action.php';

        $form_actions_registrar->register( new \Ait_Validation_Action() );
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {

        $this->loader->add_action(
            'elementor_pro/forms/actions/register',
            $this,
            'add_ait_validation_action'
        );

        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Ait_Validation_Action_Elementor_Forms_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }

}
