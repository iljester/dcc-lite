<?php
/**
 * @package: Dadi Cookie Consent Lite
 * Banners and Popups
 */

if( ! defined( 'DADICC_ALLOW' ) ) {
    exit();
}

/**
 * Generate small and big banner
 *
 */
function dadicc_get_banners() {
    
    global $dadicc_options;
    
    if( !is_array( $dadicc_options ) || empty( $dadicc_options ) ) {
        return;
    }
    
    if( dadicc_disable_blocking_lite() === true ) {
        return;
    }
    
    $post_id             = get_permalink( get_queried_object_id() );
    $archive_url         = get_post_type_archive_link( get_post_type() );
    $class_neutral       = ' dadicc-' . $dadicc_options['use_neutral_color'];
    $link_cookie_policy  = dadicc_get_cookie_policy_link( true, $dadicc_options );
    
    /**
     * Big Banner
     */
    $big_banner  = '<div id="dadiccCookieAlert" class="dadicc-cookie-banner dadicc-cookie-banner-lite dadicc-default dadicc-hide-big-banner ' . esc_attr(  $class_neutral ) . '">';
    $big_banner .= '<div class="dadicc-wrap-banner">';
    
    // message
    $big_banner .= '<div class="dadicc-wrap-text-banner dadicc-no-editor">';
    $big_banner .= '<p>' . esc_html( $dadicc_options['message_banner'] ) . '</p>';
    $big_banner .= '</div>';

    // footer
    $big_banner .= '<div class="dadicc-footer-cookie-alert">';
    $big_banner .= wp_nonce_field( dadicc_build_nonce( dirname( __FILE__ ) ), 'wp_nonce', true, false );
    $big_banner .= '<span class="dadicc-agree">' . esc_html( $dadicc_options['button_consent'] ) . '</span>';
    $big_banner .= $link_cookie_policy;
    $big_banner .= '<span class="dadicc-hide" title="' . esc_attr__( 'Close', DADICC_DOMAIN ) . '"><i class="icon-dadicc-cancel"></i></span>';
    
    $big_banner .= '</div>';
    
    $big_banner .= '</div>';
    $big_banner .= '</div>';
    
    /**
     * Small banner
     */
    $small_banner  = '<div id="dadiccCookieAlertSmall" class="dadicc-cookie-banner dadicc-cookie-banner-lite-small dadicc-default' . esc_attr( $class_neutral ) . '">';
    $small_banner .= '<div class="dadicc-wrap-banner">';
    $small_banner .= '<p>';
    $small_banner .= '<span class="dadicc-wrap-small-banner-text">' . esc_html( $dadicc_options['message_banner_small'] ) . '</span>';
    $small_banner .= '<span class="dadicc-more-info">' . esc_html( $dadicc_options['button_more_info_minimal'] ) . '</span>';
    if( (bool) $dadicc_options['show_btc_mini_banner'] === true ) {
        $small_banner .= '<span class="dadicc-agree">' . esc_html( $dadicc_options['button_consent'] ) . '</span>';
    }
    $small_banner .= '</p>';
    $small_banner .= '</div>';
    $small_banner .= '</div>';
    
    $banners = '';
    if( (bool) $dadicc_options['show_banners'] === true ) {
        $banners = ( $big_banner . $small_banner );
    }
    
    return $banners;
    
}