<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://nicksullivan.com.au
 * @since      1.0.0
 *
 * @package    Toptal_Social_Share_Buttons
 * @subpackage Toptal_Social_Share_Buttons/admin/partials
 */

 $social_networks = array(
     'social-0' => 'facebook',
     'social-1' => 'twitter',
     'social-2' => 'google-plus',
     'social-3' => 'pinterest',
     'social-4' => 'linkedin',
     'social-5' => 'whatsapp'
 );

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">

    <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

    <form method="post" id="toptal_social_share_options" name="toptal_social_share_options" action="options.php">

        <?php
        //Grab all options
        $options = get_option($this->plugin_name);

        // Add in WP hidden fields
        settings_fields($this->plugin_name);
        do_settings_sections($this->plugin_name);
        ?>

        <?php
        /**
         * Which post types to display the social share buttons on
         */

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
        ?>

        <fieldset>

            <h4><?php _e( 'Which posts should the social share buttons appear', $this->plugin_name ); ?></h4>

            <legend class="screen-reader-text"><span><?php _e( 'Which post types to display the social share buttons on', $this->plugin_name ); ?></span></legend>

                <?php foreach ( $post_types as $key => $type ) : ?>

                    <p>
                        <label for="<?php echo $this->plugin_name . '-' . $key; ?>">
                            <input type="checkbox" id="<?php echo $this->plugin_name . '-' . $key; ?>" name="<?php echo $this->plugin_name . '[' . $key . ']'; ?>" value="1" <?php checked($options[$key], 1); ?> />
                            <span><?php esc_attr_e( ucfirst( $type ), $this->plugin_name ); ?></span>
                        </label>
                    </p>

                <?php endforeach; ?>

        </fieldset>

        <hr />

        <?php
        /**
         * Which social networks to show on the front endforeach and order of buttons
         */
         $saved_order = ( $options['order'] ) ? explode( ",", $options['order'] ) : '';
         $ordered = ( $saved_order ) ? array_merge( array_flip( $saved_order ), $social_networks ) : $social_networks;
        ?>

         <fieldset>

             <h4><?php _e( 'Which buttons would you like to show and in which order', $this->plugin_name ); ?></h4>
             <small>Drag the items into the order you would like the buttons to display</small>

             <legend class="screen-reader-text"><span><?php _e( 'Which buttons would you like to show and in which order', $this->plugin_name ); ?></span></legend>

             <input type="hidden" id="<?php echo $this->plugin_name . '-order';?>" name="<?php echo $this->plugin_name . '[order]';?>" value=""/>

             <ul class="sortable">

                 <?php foreach ( $ordered as $key => $social_network ) : ?>

                     <li id="<?php echo $key; ?>">
                         <label for="<?php echo $this->plugin_name . '-' . $social_network; ?>">
                             <input type="checkbox" id="<?php echo $this->plugin_name . '-' . $social_network; ?>" name="<?php echo $this->plugin_name . '[' . $social_network . ']'; ?>" value="1" <?php checked($options[$social_network], 1); ?>/>
                             <span><?php ( $social_network == 'google-plus' ) ? _e( 'Google+', $this->plugin_name ) : esc_attr_e( ucfirst( $social_network ), $this->plugin_name ); ?> <?php echo ( $social_network == 'whatsapp' ) ? __('(Will only show on mobile)', $this->plugin_name) : '';?></span>
                         </label>
                         <i class="dashicons dashicons-sort"></i>
                     </li>

                 <?php endforeach; ?>

             </ul>

         </fieldset>

         <hr />

         <?php
         /**
          * Size of buttons
          */
         ?>

          <fieldset>

              <h4><?php _e( 'Choose size of buttons', $this->plugin_name ); ?></h4>

              <legend class="screen-reader-text"><span><?php _e( 'Choose size of buttons', $this->plugin_name ); ?></span></legend>

              <p>
                  <select name="<?php echo $this->plugin_name; ?>[btn_size]">
                      <option value="small" <?php selected($options['btn_size'], 'small'); ?>>
                          <?php _e( 'Small', $this->plugin_name ); ?>
                      </option>
                      <option value="medium" <?php selected($options['btn_size'], 'medium'); ?>>
                          <?php _e( 'Medium', $this->plugin_name ); ?>
                      </option>
                      <option value="large" <?php selected($options['btn_size'], 'large'); ?>>
                          <?php _e( 'Large', $this->plugin_name ); ?>
                      </option>
                  </select>
              </p>

          </fieldset>

          <hr />

          <?php
          /**
           * Custom colour of buttons
           */
          ?>

           <fieldset>

               <h4><?php _e( 'Custom colour of buttons', $this->plugin_name ); ?></h4>
               <small><?php _e( 'This will colour all of the icons with the colour chosen and override their default colours', $this->plugin_name ); ?></small>

               <legend class="screen-reader-text"><span><?php _e( 'Custom colour of buttons', $this->plugin_name ); ?></span></legend>

               <p>
                   <label for="<?php echo $this->plugin_name . '-custom_colour'; ?>">
                       <input type="checkbox" id="<?php echo $this->plugin_name . '-custom_colour'; ?>" name="<?php echo $this->plugin_name . '[custom_colour]'; ?>" value="1" <?php checked($options['custom_colour'], 1); ?>/>
                       <span><?php _e( 'Would you like to use a custom colour?', $this->plugin_name ); ?></span>
                   </label>
               </p>
               <?php
               // Set colour to blank if custom colour checkbox isn't checked
               $colour = ( $options['custom_colour'] == 1 ) ? $options['colour'] : '';
               ?>
               <p id="colour-picker" <?php echo ($options['custom_colour']) ? '' : 'class="hidden"';?>>
                   <label for="<?php echo $this->plugin_name . '-colour'; ?>">
                       <input class="<?php echo $this->plugin_name . '-colour'; ?>" type="text" name="<?php echo $this->plugin_name . '[colour]'; ?>" value="<?php echo $colour;?>"/>
                   </label>
               </p>

           </fieldset>

           <hr />

            <?php
            /**
             * Where should the buttons be displayed on the front end
             */

             $positions = array(
                 'post_title' => 'After Post Title',
                 'left' => 'Floating on the Left',
                 'post_content' => 'After Post Content',
                 'image' => 'Inside Featured Image'
             );

            ?>

            <fieldset>

                <h4><?php _e( 'Where would you like the social share buttons to appear', $this->plugin_name ); ?></h4>

                <legend class="screen-reader-text"><span><?php _e( 'Where would you like the social share buttons to appear', $this->plugin_name ); ?></span></legend>

                    <?php foreach ( $positions as $key => $value ) : ?>

                        <p>
                            <label for="<?php echo $this->plugin_name . '-' . $key; ?>">
                                <input type="checkbox" id="<?php echo $this->plugin_name . '-' . $key; ?>" name="<?php echo $this->plugin_name . '[' . $key . ']'; ?>" value="1" <?php checked($options[$key], 1); ?>/>
                                <span><?php esc_attr_e( ucfirst( $value ), $this->plugin_name ); ?></span>
                            </label>
                        </p>

                    <?php endforeach; ?>

            </fieldset>

            <hr />

        <?php submit_button( __('Save all changes', $this->plugin_name), 'primary','submit', TRUE ); ?>

    </form>

</div>
