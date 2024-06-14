<?php
/**
 * @package: Dadi Cookie Consent Lite
 * Manage Policies
 */

if( ! defined( 'DADICC_ALLOW' ) ) {
    exit();
}

/**
 * Build Cookie Policy
 *
 */
function dadicc_get_cookie_policy_link( $html = true, $dadicc_options = array() ) {
    
    if( ! is_array( $dadicc_options ) || empty( $dadicc_options ) ) {
        return '';
    }
        
    $cookie_page_id = $dadicc_options['select_cookie_page'];
    $label_cookie_page  = $dadicc_options['button_cookie_policy'] == '' ? get_the_title( $cookie_page_id ) : $dadicc_options['button_cookie_policy'];
    
    $uri_cookie_page = '';
    if( intval( $cookie_page_id ) > 0 ) {
        $uri_cookie_page = get_permalink( $cookie_page_id );
    } else {
		return '';
	}

    if( (bool) $html === true ) {

        $link =  $uri_cookie_page !== '' ? '<a target="_blank" href="' . esc_url( $uri_cookie_page ) . '" class="dadicc-read-cookie_policy dadicc-more-info" data-policy="cookie_policy">' . esc_attr( $label_cookie_page ) . '</a>' : esc_html__('Cookie Policy', DADICC_DOMAIN );
        return $link;
        
    } else {
        
        return $cookie_page_id;
        
    }
    
}

/**
 * Add data-policy to allowed tags when we use kses_post filter
 *
 */
function dadicc_filter_allowed_data_policy( $allowed_tags, $context ){
 
    if ( is_array( $context ) ) {
        return $allowed_tags;
    }

    if ( (string) $context === 'post' ) {
        $allowed_tags['a']['data-policy'] = true;
    }

    return $allowed_tags;
}
add_filter( 'wp_kses_allowed_html', 'dadicc_filter_allowed_data_policy', 10, 2 );