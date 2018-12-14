<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://nicksullivan.com.au
 * @since      1.0.0
 *
 * @package    Toptal_Social_Share_Buttons
 * @subpackage Toptal_Social_Share_Buttons/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Toptal_Social_Share_Buttons
 * @subpackage Toptal_Social_Share_Buttons/public
 * @author     Nicholas Sullivan <nick@popsiclestudio.com>
 */
class Toptal_Social_Share_Buttons_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        $this->social_share_options = get_option($this->plugin_name);

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Toptal_Social_Share_Buttons_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Toptal_Social_Share_Buttons_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/toptal-social-share-buttons-public.css', array(), $this->version, 'all' );

        wp_enqueue_style( $this->plugin_name . '-fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', array(), $this->version, 'all');

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Toptal_Social_Share_Buttons_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Toptal_Social_Share_Buttons_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/toptal-social-share-buttons-public.js', array( 'jquery' ), $this->version, false );

	}

    /**
     * Add in Open Graph to language attribute
     *
     * @since 1.0.0
     */
     public function toptal_add_opengraph_doctype( $output ) {
         return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
     }

     /**
      * Add in Open Graph meta into head
      *
      * @since 1.0.0
      */
      public function toptal_add_opengraph_meta() {

          global $post;
          // Check if it's a post or page
          if ( !is_singular())
              return;
              echo '<meta property="og:title" content="' . get_the_title() . '"/>' . PHP_EOL;
              echo '<meta property="og:type" content="article"/>' . PHP_EOL;
              echo '<meta property="og:url" content="' . get_permalink() . '"/>' . PHP_EOL;
              echo '<meta property="og:site_name" content="'. get_bloginfo('name') .'"/>' . PHP_EOL;

          if ( has_post_thumbnail( $post->ID ) ) {
              $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
              echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '"/>' . PHP_EOL;
          }

      }

    /**
     * Show share buttons after post title
     *
     * @since 1.0.0
     */
    public function show_after_post_title( $content ) {
        /**
         * don't run in the backend
         */
         if( is_admin() ) {
             return $title;
         }

        if ( $this->social_share_options['post_title'] ) {

            return $this->toptal_social_buttons_content( $content, true );

        } else {

            return $content;

        }
    }

    /**
     * Show share buttons floating on left
     *
     * @since 1.0.0
     */
    public function show_floating_left() {
        /**
         * don't run in the backend
         */
         if( is_admin() ) {
             echo '';
         }

        if ( $this->social_share_options['left'] ) {
            echo '<div class="toptal-left-float">';
            echo $this->toptal_social_buttons_content( null );
            echo '</div>';

        }
    }


     /**
      * Show share buttons after post content
      *
      * @since 1.0.0
      */
     public function show_after_post_content( $content ) {
         /**
          * don't run in the backend
          */
          if( is_admin() ) {
              return $content;
          }

        if ( $this->social_share_options['post_content'] ) {

            return $this->toptal_social_buttons_content( $content );

        } else {

            return $content;

        }
    }

    /**
     * Show share buttons in featured image
     *
     * @since 1.0.0
     */
    public function show_featured_image( $html ) {
        /**
         * don't run in the backend
         */
         if( is_admin() ) {
             return $html;
         }

        if ( $this->social_share_options['image'] ) {


            $html = '<div class="toptal-image-wrap">' . $html . $this->toptal_social_buttons_content( null ) . '</div>';

            return $html;

        } else {

            return $html;

        }
    }

    /**
     * Show the social share buttons content
     *
     * @since 1.0.0
     */
     private function toptal_social_buttons_content( $content, $before = false ) {

         $ordered_list = $this->toptal_ordered_buttons();
         $size = $this->social_share_options['btn_size'];
         $custom_colour = $this->social_share_options['custom_colour'];
         $colour = $this->social_share_options['colour'];

         // Include partial file which gives us the HTML
         include( 'partials/toptal-social-share-buttons-public-display.php' );

         $custom_content = ( $before ) ? $html . $content : $content . $html;

         foreach ( $this->toptal_post_types() as $post_type ) {

             if ( $this->social_share_options[$post_type] && is_singular($post_type) ) {

                 $content = $custom_content;

             }
         }

         return $content;
     }

    /**
     * Get all the post post types
     *
     * @since 1.0.0
     */
    private function toptal_post_types() {

        // Add in WP standard post types without attachement etc
        $wp_post_types = array(
         'post' => 'post',
         'page' => 'page'
        );
        // Args for get_post_types() to only include public posts and exclude all built in WP posts to exclude attachment etc
        $args = array(
         'public'   => true,
         '_builtin' => false
        );

        $post_types = array_merge( $wp_post_types, get_post_types( $args ) );

        return $post_types;
    }

    /**
     * Get the saved order of buttons
     *
     * @since 1.0.0
     */
    private function toptal_ordered_buttons() {

        $social_networks = array(
            'social-0' => 'facebook',
            'social-1' => 'twitter',
            'social-2' => 'google-plus',
            'social-3' => 'pinterest',
            'social-4' => 'linkedin',
            'social-5' => 'whatsapp'
        );

        $saved_order = ( $this->social_share_options['order'] ) ? explode( ",", $this->social_share_options['order'] ) : '';

        $ordered = ( $saved_order ) ? array_merge( array_flip( $saved_order ), $social_networks ) : $social_networks;

        return $ordered;
    }

    /**
     * Create share links for each social network
     *
     * @since 1.0.0
     */
    public function toptal_share_links( $network ) {
        // Get url and sanitize
        global $post;
        $title = get_post( $post->ID )->post_title;
        $post_url = get_permalink( $post->ID );
        $desc = rawurlencode( get_post( $post->ID )->post_excerpt );
        $img = get_the_post_thumbnail_url( $post->ID, 'full' );

        switch ( $network ) {
            case 'facebook':
                $url = 'http://www.facebook.com/sharer/sharer.php?u='.urlencode($post_url);
                break;
            case 'twitter':
                $url = 'https://twitter.com/intent/tweet?text='.rawurlencode( $title ).'&url='.urlencode($post_url);
                break;
            case 'google-plus':
                $url = 'https://plus.google.com/share?url='.urlencode($post_url);
                break;
            case 'linkedin':
                $url = 'https://www.linkedin.com/shareArticle?mini=true&url='.urlencode($post_url).'&title='.rawurlencode( $title ).'&summary='.$desc.'&source='.rawurlencode( get_bloginfo('name') );
                break;
            case 'pinterest':
                $url = 'https://www.pinterest.com/pin/create/button/?url='.urlencode( $post_url ).'&media='.urlencode( $img ).'&description='.rawurlencode( $title );
                break;
            case 'whatsapp':
                $url = 'https://api.whatsapp.com/send?text='.urlencode( $title ). ' from ' .urlencode( $post_url );
        }

        return $url;

    }

    /**
     * Add Shortcode [toptal-social-share]
     *
     * @since 1.0.0
     */

    public function toptal_share_shortcode() {
        add_shortcode("toptal-social-share", function() {
            return $this->toptal_social_buttons_content( null );
        });
    }

}
