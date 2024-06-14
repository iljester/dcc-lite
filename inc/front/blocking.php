<?php 
/**
 * @package: Dadi Cookie Consent Lite
 * Block Actions
 */

if( ! defined( 'DADICC_ALLOW' ) ) {
    exit();
}

/**
 * White List
 * Remove all registered and enqueue scripts when the page load except kept and core
 *
 */
function dadicc_remove_scripts() {
    
    global $dadicc_options;
    
    if( 
        (bool) $dadicc_options['disable_php_block'] === true || 
        is_admin() || 
        filter_has_var( INPUT_COOKIE, DADICC_GLOBAL_CK ) ) {
        return;
    }

    // get all registered scripts
    $scripts = dadicc_get_url_scripts();

    // get core scripts
    $js_core = array( 
        'jquery'            => includes_url( 'js/jquery/jquery.min.js' ), 
        'jquery-migrate'    => includes_url( 'js/jquery/jquery-migrate.min.js' ),
        'admin-bar'         => includes_url( 'js/admin-bar.min.js' ), 
        DADICC_FRONT_JS     => dadicc_base_url( 'js/dadicc-front-lite.js' )
    );

    // deregister scripts that not are core
    foreach( $scripts as $handle => $url ) {
        
        if( ! in_array( $handle, array_keys( $js_core ) ) ) {
            wp_dequeue_script( $handle );
            wp_deregister_script( $handle );
        }
    }
    
    /**
     * Set transient for kept scripts
     */
    set_transient( 'dadicc_scripts_kept', $js_core );

}
add_action( 'wp_print_scripts', 'dadicc_remove_scripts', 1000 );

/**
 * Wash scripts
 * Removes scripts in the string
 *
 */
function dadicc_wash_scripts( $string = '' ) {
    
    if( strlen( $string ) === 0 ) 
        return $string;
    
    $localize = dadicc_get_localize_scripts();
    $localize_scripts[] = array();
    foreach( array_keys( get_transient( 'dadicc_scripts_kept' ) ) as $handle ) {

        if( in_array( $handle, array_keys( $localize ) ) ) {
            $localize_scripts[] = $localize[$handle];
        }

    }

    $kept_scripts = array_values( get_transient( 'dadicc_scripts_kept' ) );
    $white_list     = array_merge( $kept_scripts, $localize_scripts );
    $white_list     = array_values( array_filter( $white_list ) );
    
    preg_match_all( "#<script(.*?)>(.*?)<\/script>#ms", $string, $matches, PREG_SET_ORDER, 0);

    $jss = array();
    foreach( $matches as $match ) {
        $jss[] = trim($match[0]);
    }

    if( !empty( $white_list ) ) {
        foreach( $jss as $k => $js ) {
            
            /**
             * experimental
             * comment with # or // if you have problems
             * only js
             */
            $js = preg_replace( '/\s+/', ' ', $js );

            foreach( $white_list as $handle ) {
                
                /**
                 * experimental
                 * comment with # or // if you have problems
                 * only js
                 */
                $handle = preg_replace( '/\s+/', ' ', $handle );
                
                if( strpos( $js, $handle ) !== false ) {
                    unset( $jss[$k] );
                }
            }
        }
    }

    $string = str_replace( $jss, '', $string );
    
    /**
     * Remove transient for kept scripts
     */
    delete_transient( 'dadicc_scripts_kept' );
    
    return $string;

}

/**
 * Block Iframe
 *
 */
function dadicc_wash_iframe( $string = '', $white_list = array() ) {
    
    global $dadicc_options;
    
    if( strlen( $string ) === 0 ) {
        return $string;
    }
    
    if( !is_array( $white_list ) ) {
        (array) $white_list;
    }
    
    // replaces
    $replace_iframe = '';
    if( (bool) $dadicc_options['replace_instead_remove'] === true ) {
        $replace_iframe = dadicc_generate_replace_box();
    }

    preg_match_all( "#<iframe(.*?)>(.*?)<\/iframe>#ms", $string, $matches, PREG_SET_ORDER, 0);
    
    $iframes = array();
    foreach( $matches as $match ) {
        $iframes[] = trim($match[0]);
    }
    
    if( !empty( $white_list ) ) {
        foreach( $iframes as $k => $iframe ) {

            foreach( $white_list as $handle ) {
                if( strpos( $iframe, $handle ) !== false ) {
                    unset( $iframes[$k] );
                }
            }
        }
    }
    
    $string = str_replace( $iframes, $replace_iframe, $string );
    
    return $string;
    
}

/**
 * Remove local cookies
 *
 */
function dadicc_wash_cookies() {
    
    $cookie_kept = apply_filters( 'dadicc_cookie_wash', $cookie_kept = array() );
    
    $wp_defaults = array(
        AUTH_COOKIE,
        SECURE_AUTH_COOKIE,
        LOGGED_IN_COOKIE,
        DADICC_GLOBAL_CK,
        'wp-settings-' . get_current_user_id(),
        'wp-settings-time-' . get_current_user_id(),
        'wp_cookie_test',
        'wordpress_test_cookie',
        'comment_author_' . COOKIEHASH,
        'comment_author_email_' . COOKIEHASH,
        'comment_author_url_' . COOKIEHASH,
        'wp-postpass_' . COOKIEHASH
    );
    
    $preserved_cookies = array_merge( $wp_defaults, $cookie_kept );
    
    if( filter_has_var( INPUT_SERVER, 'HTTP_COOKIE' ) ) {
        
        $cookies = explode(';', filter_input( INPUT_SERVER, 'HTTP_COOKIE') );
       
        foreach( $cookies as $cookie ) {
            $cstring = explode( '=', $cookie );
            $cname = trim( $cstring[0] );

            if( ! in_array( $cname, $preserved_cookies ) ) {
                setcookie( $cname, '', time()-3600 );
                setcookie( $cname, '', time()-3600, '/' );
                unset( $cookies[$cname] );
                unset( $_COOKIES[$cname] );
            }

        }
        
    }
       
}

/**
 * Block Action
 * Callback function for ob_start()
 * see below
 */
function dadicc_remove_script_callback( $buffer ) {

    global $dadicc_options;

    /*
     * Block Javascript
     */
    $buffer = dadicc_wash_scripts( $buffer );

    /**
     * Block Iframe
     */
    $buffer = dadicc_wash_iframe( $buffer );

    /**
     * Remove cookies
     */
    if( (bool) $dadicc_options['all_blocked_cookies'] === true ) {
        dadicc_wash_cookies();
    }

    return $buffer;
    
}

/**
 * Ob start content
 */
function dadicc_buffer_start() {
    ob_start( 'dadicc_remove_script_callback' );
}
add_action('init', 'dadicc_buffer_start' );

/**
 * Ob end flush
 */
function dadicc_buffer_end() {
    ob_end_flush();
}
add_action('wp_footer', 'dadicc_buffer_end' );

/**
 * Disable blocking
 *
 */
function dadicc_ignore_dadi_cookie_consent_buffer_lite() {
    
    if( filter_has_var( INPUT_COOKIE, DADICC_GLOBAL_CK ) || dadicc_disable_blocking_lite() === true ) {
        remove_action( 'init', 'dadicc_buffer_start' );
        remove_action( 'wp_footer', 'dadicc_buffer_end' );
        remove_action( 'wp_print_scripts', 'dadicc_remove_scripts', 1000 );
    }

}
add_action( 'init', 'dadicc_ignore_dadi_cookie_consent_buffer_lite', 9 );
