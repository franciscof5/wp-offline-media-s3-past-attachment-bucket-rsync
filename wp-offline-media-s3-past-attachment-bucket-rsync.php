<?php
/**
 * @wordpress-plugin
 * Plugin Name: Wp Offline Media - S3 Past Attachment Rsync
 * Plugin URI: https://
 * Description: With this plugin you don't need to buy premium version of Wp Offline Media, you can use my hack solution.
 * Version: 0.1
 * Author: Francisco Matelli Matulovic
 * Author URI: https://www.franciscomatelli.com.br
 * License: GPL2+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort
if ( ! defined( 'WPINC' ) ) {
	die;
}

//first, rewrite base URL from attachment call function
function right_composed_attachment_url( $url, $attachment_id ) {
    $wrong_base_url = 'https://example.com/wp-content/uploads';
    $uploads_s3_url = "https://YOURBUCKET.s3.sa-east-1.amazonaws.com/wp-content/uploads";
    $custom_upload_has_wrong_base_url = strpos( $url, $wrong_base_url ) !== false;
    //
    if ( $custom_upload_has_wrong_base_url ) {
      return str_replace( $wrong_base_url, $uploads_s3_url, $url );
    }
    return $url;
}
add_filter( 'wp_get_attachment_url', 'right_composed_attachment_url', 10, 2 );

//bad side, but need to disable srcset because it dont filter correctly the css class generator
function wdo_disable_srcset( $sources ) { return false; }
add_filter( 'wp_calculate_image_srcset', 'wdo_disable_srcset' );

?>