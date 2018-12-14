<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://nicksullivan.com.au
 * @since      1.0.0
 *
 * @package    Toptal_Social_Share_Buttons
 * @subpackage Toptal_Social_Share_Buttons/public/partials
 */

?>

<?php
ob_start();
?>

<div class="<?php echo $this->plugin_name . '-wrapper'; ?>">

    <?php
    // Instantiate the Mobile Detect class
    $detect = new Mobile_Detect;

    foreach ( $ordered_list as $value ) {

        // Check if we're not on a mobile, if so don't show Whatsapp button
        if ( !$detect->isMobile() && $value == 'whatsapp' ) {
            continue;
        }
        // Check if social network has been selected in admin
        if ( $this->social_share_options[$value] ) :

    ?>
        <div class="toptal-share-btn toptal-<?php echo $value; ?> toptal-btn-<?php echo $size;?>" <?php echo ($custom_colour) ? 'style="background-color:'.$colour.';"' : '';?>>

            <a rel="nofollow" target="_blank" href="<?php echo Toptal_Social_Share_Buttons_Public::toptal_share_links( $value );?>">
                <i class="fa fa-<?php echo $value; ?>"></i>
            </a>
        </div>

        <?php endif;

     }
     ?>

</div>

<?php

$html = ob_get_clean();

?>
