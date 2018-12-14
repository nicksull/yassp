<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://nicksullivan.com.au
 * @since      1.0.0
 *
 * @package    Toptal_Social_Share_Buttons
 * @subpackage Toptal_Social_Share_Buttons/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Toptal_Social_Share_Buttons
 * @subpackage Toptal_Social_Share_Buttons/admin
 * @author     Nicholas Sullivan <nick@popsiclestudio.com>
 */
class Toptal_Social_Share_Buttons_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
        // Enqueue admin styles
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/toptal-social-share-buttons-admin.css', array(), $this->version, 'all' );
        // Enqueue WP colour picker
        wp_enqueue_style( 'wp-color-picker' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

        // Enqueue admin JS
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/toptal-social-share-buttons-admin.js', array( 'jquery' ), $this->version, false );
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script( 'wp-color-picker');

	}

  /**
   * Register the administration menu for this plugin into the WordPress Dashboard menu.
   *
   * @since    1.0.0
   */

   public function add_admin_menu() {
      /*
       * Add a settings page for the plugin under Settings menu
       * Administration Menus: http://codex.wordpress.org/Administration_Menus
       *
       */
       add_options_page( 'Toptal Social Share Buttons', 'Social Share Buttons', 'manage_options', $this->plugin_name, array($this, 'display_setup_page') );
    }

    /**
     * Add settings link next to Activate/Deactivate
     *
     * @since    1.0.0
     */

     public function add_settings_link( $links ) {
       /*
        *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links
        */
        $settings_link = array(
          '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
        );
        return array_merge(  $settings_link, $links );
      }

      /**
       * Load the settings page content
       *
       * @since    1.0.0
       */

       public function display_setup_page() {
         include_once( 'partials/toptal-social-share-buttons-admin-display.php' );
       }

       /**
       *
       * Save/update options settings
       *
       * @since 1.0.0
       */

       public function options_update() {
           register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
       }

        /**
        *
        * Validate input fieldset
        *
        * @since 1.0.0
        */

        public function validate( $input ) {

            $validated = array();

            /**
             * Validate post types so we can validate each checkbox
             */

            $wp_post_types = array(
             'post' => 'post',
             'page' => 'page'
            );

            $args = array(
             'public'   => true,
             '_builtin' => false
            );

            $post_types = array_merge( $wp_post_types, get_post_types( $args ) );

            foreach ( $post_types as $key => $value ) {

                $validated[$key] = ( isset( $input[$key] ) && !empty( $input[$key] ) ) ? 1 : 0;

            }

            /**
             * Validate social network checkboxes
             */

            $social_networks = array( 'facebook', 'twitter', 'google-plus', 'pinterest', 'linkedin', 'whatsapp' );

            foreach ( $social_networks as $network ) {

                $validated[$network] = ( isset( $input[$network] ) && !empty( $input[$network] ) ) ? 1 : 0;

             }

            /**
             * Validate size of buttons option select box
             */

            $validated['btn_size'] = sanitize_key( $input[ 'btn_size' ] );

            /**
             * Validate colour inputs
             */


            $validated['custom_colour'] = ( isset( $input['custom_colour'] ) && !empty( $input['custom_colour'] ) ) ? 1 : 0;
            $validated['colour'] = ( $input['colour'] ) ? sanitize_text_field( $input['colour'] ) : '';

            // Check if entered value starts with a #, otherwise error
            if ( !empty($validated['colour']) && !preg_match( '/^#[a-f0-9]{6}$/i', $validated['colour']  ) ) {
                add_settings_error(
                    'colour',
                    'colour_texterror',
                    'Please enter a valid hex value color',
                    'error'
                );
            }

            /**
             * Validate order
             */

            $validated['order'] = sanitize_text_field( $input['order'] );

             /**
             * Validate position checkboxes
             */
            $positions = array( 'post_title', 'left', 'post_content', 'image' );

            foreach ( $positions as $position ) {
                $validated[$position] = ( isset( $input[$position] ) && !empty( $input[$position] ) ) ? 1 : 0;
            }


            return $validated;

        }

}
