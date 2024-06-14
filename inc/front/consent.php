<?php
/**
 * @package: Dadi Cookie Consent Lite
 * Consent Action
 */

if( ! defined( 'DADICC_ALLOW' ) ) {
    exit();
}

/**
 * Consent global
 *
 */
function dadicc_consent_global() {
    
    if( filter_has_var( INPUT_POST, 'checked') ) {
        
        if ( ! filter_has_var( INPUT_POST, 'wp_nonce' ) || ! wp_verify_nonce( filter_input( INPUT_POST, 'wp_nonce', FILTER_SANITIZE_STRING ), dadicc_build_nonce( dirname( __FILE__ ) ) ) ) {
            die( 'Is it a joke?');
        }
        
        $cname = filter_input( INPUT_POST, 'current_cookie', FILTER_SANITIZE_STRING );
        $type = filter_input( INPUT_POST, 'type', FILTER_SANITIZE_STRING );
        
        if( $cname !== DADICC_GLOBAL_CK ) {

            // clandestine value
            wp_die( '-1');
        }

        $checked         = filter_input( INPUT_POST, 'checked', FILTER_VALIDATE_BOOLEAN );
        $cookie_life     = dadicc_get_cookie_life();
            
        if( TRUE === $checked ) {
            
            $value = 'consent:+true+' . time();
            if( (string) $cname !== '' ) {

                if( !isset( $_COOKIE[$cname] ) ) {
                    setcookie( $cname, $value, $cookie_life, '/' ); 
                }
            
            }
        
        } else {
            
            if( $type === 'scroll' ) {
                // unauthorized action
                wp_die('-2');
            }
            
            if( filter_has_var( INPUT_COOKIE, DADICC_GLOBAL_CK ) ) {
                setcookie( DADICC_GLOBAL_CK, null, time()-3600, '/');
            }
            
        }
        
        if( (bool) dadicc_get_options('purge_cache') === true ) {
               
            dadicc_empty_cache();
        }
        
        // success  
        wp_die('1');
        
    }
    
    // some wrong
    wp_die('0');
    
}

add_action( 'wp_ajax_dadiccAjaxCookieAll', 'dadicc_consent_global');
add_action( 'wp_ajax_nopriv_dadiccAjaxCookieAll', 'dadicc_consent_global');