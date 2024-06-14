<?php
/**
 * @package: Dadi Cookie Consent
 * Commons
 */

if( ! defined( 'DADICC_ALLOW' ) ) {
    exit();
}

/**
 * Validate data
 *
 */
function dadicc_validate_intbool( $input ) {
    
    if ( ! isset( $input ) ) $input = null;
    $input = ( absint( $input ) === 1 ? 1 : 0 );
    
    return $input;
    
}

/**
 * Sanitize key.
 * Replace unallowed chars with underscore
 */
function dadicc_sanitize_key( $key = '', $inbuilt = false ) {
    
    if( strlen( $key ) === 0 ) return $key;
    
    $unallowed = apply_filters('dadicc_unallowed_sanitize_key', $unallowed = array( 
       'www',
       'http',
       'https'  
    ) );
    
    $key = str_replace( $unallowed, '', $key );
    
    if( (bool) $inbuilt === false ) {
        $key = preg_replace( '/[^a-z0-9_]/', '_', $key );
        $key = preg_replace( '/_+/', '_', $key );
        $key = trim( $key, '_' );
    } else {
        $key = sanitize_key( $key );
    }
    
    return $key;
    
}

/**
 * Remove script tag
 */
function dadicc_strip_script( $string ) {
    
    $str = preg_replace('/<\/?(script(.*?))>/ms', '', $string );
    
    return trim($str);
    
}

/**
 * Sanitize cname
 *
 */
function dadicc_sanitize_cname( $cname ) {
    
    $unfiltered = $cname;
    
    $cname = dadicc_sanitize_key( $cname );
    
    $cname = apply_filters( 'dadicc_sanitize_cname', $cname, $unfiltered );
    
    return $cname;
}

/**
 * Filter input
 *
 */
function dadicc_filter_val( $value = '', $type = 'textfield', $callback = 'sanitize_text_field' ) {
    
    if( strlen( $value ) === 0 ) {
        return '';
    }
    
    if( strlen( $type) === 0 ) {
        $type = 'textfield';
    }
    
    $type = dadicc_sanitize_key( $type );
    $callback = dadicc_sanitize_key( $callback );
    
    switch( $type ) {
        case 'textfield'    : $validation = sanitize_text_field( $value ); break;
        case 'absint'       : $validation = absint( $value ); break;
        case 'int'          : $validation = filter_var( $value, FILTER_VALIDATE_INT ); break;
        case 'email'        : $validation = filter_var( sanitize_email( $value ), FILTER_VALIDATE_EMAIL ); break;
        case 'post'         : $validation = wp_kses_post( $value ); break;
        case 'textarea'     : $validation = sanitize_textarea_field( $value ); break;
        case 'array'        : $validation = array_map( $callback, $value ); break;
        case 'intbool'      : $validation = dadicc_validate_intbool( $value ); break;
        case 'bool'         : $validation = filter_var( $value, FILTER_VALIDATE_BOOLEAN ); break;
        case 'title'        : $validation = sanitize_title( $value ); break;
        case 'key'          : $validation = dadicc_sanitize_key( $value ); break;
        case 'striptags'    : $validation = strip_tags( $value ); break;
        case 'stripscript'  : $validation = dadicc_strip_script( $value ); break;
        case 'url'          : $validation = esc_url_raw( $value ); break;
        default: $validation = sanitize_text_field( $value );
    }
    
    return $validation;
    
}

/**
 * Array sanitize
 */
function dadicc_array_sanitize( $value = null, $callback = 'sanitize_text_field') {
    
    if( !isset( $value) ) {
        return array();
    } else {
        if( !is_array( $value ) ) {
            $value = (array) $value;
        }
        return dadicc_filter_val( $value, 'array', $callback );
    }
}

/**
 * Remove prefix
 */
function dadicc_remove_domain( $cname = '' ) {
    
    if( strlen( $cname ) === 0 ) return '';
    
    if( strpos( $cname, DADICC_DOMAIN ) !== FALSE ) {
        $cname = implode( '', array_filter( explode( DADICC_DOMAIN, $cname ) ) );
        return dadicc_sanitize_key( $cname );
    } else {
        return dadicc_sanitize_key( $cname );
    }
    
}

/**
 * Sanitize nonce
 *
 */
function dadicc_build_nonce( $value ) {
    
    $sanitize_value  = filter_var( $value, FILTER_SANITIZE_STRING );
    $sanitize_by_wp  = sanitize_title( $sanitize_value );
    $sanitize_dcc    = str_replace( '-', '_', $sanitize_by_wp );
    
    return crypt( $sanitize_dcc, NONCE_SALT );
    
}

/**
 * Unwrap shortcode content
 * @see: https://stackoverflow.com/questions/33133953/strip-shortcode-keep-content-in-between
 */
function unwrap_shortcode( $shortcode ) {
    
    $content = preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $shortcode );
    
    return $content;
    
}

/**
 * Get site domain
 *
 */
function dadicc_get_site_domain() {
    
    $domain = preg_replace( '/https?:\/\/(www.)*/i', '', get_site_url() );
    
    return $domain;
    
}

/**
 * Build array
 */
function dadicc_block_class_css() {
    return '.' . DADICC_BLOCK_CLASS;
}

/**
 * Allowed tags
 *
 */
function dadicc_allowed_tags() {
    
    $allowed = array(
        'a' => array(
            'class' => array(),
            'id' => array(),
            'href' => array(),
            'target' => array(),
            'style' => array(),
            'title' => array()
        ),
        'strong' => array(),
        'em' => array(),
        'u' => array(),
        'span' => array(
            'class' => array(),
            'id' => array(),
            'style' => array(),
            'title' => array()
        ),
        'div' => array(
            'class' => array(),
            'id' => array(),
            'style' => array(),
            'title' => array()
        ),
        'p' => array(
            'class' => array(),
            'id' => array(),
            'style' => array(),
            'title' => array()
        ),
        'ul' => array(
            'class' => array(),
            'id' => array(),
            'style' => array(),
            'title' => array()
        ),
        'ol' => array(
            'class' => array(),
            'id' => array(),
            'style' => array(),
            'title' => array()
        ),
        'li' => array(
            'class' => array(),
            'id' => array(),
            'style' => array(),
            'title' => array()
        ),
        'img' => array(
            'class' => array(),
            'id' => array(),
            'style' => array(),
            'alt' => array(),
            'src' => array(),
            'title' => array()
        )
    );
    
    $heads = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6');
    foreach( $heads as $head ) {
        $allowed[$head] = array(
            'class' => array(),
            'id' => array(),
            'style' => array(),
            'title' => array()
        );
    }

    return apply_filters( 'dadicc_allowed_tags', $allowed );
    
}

/*
 * Check if the visitor is a bot. If is a bot ignore
 * source: http://stackoverflow.com/questions/677419/how-to-detect-search-engine-bots-with-php
 */
function dadicc_is_bot_detected() {

  if( filter_has_var( INPUT_SERVER, 'HTTP_USER_AGENT' ) && preg_match('/bot|crawl|slurp|spider/i', filter_input( INPUT_SERVER, 'HTTP_USER_AGENT' ) ) ) {
      return TRUE;
  } else {
      return FALSE;
  }

}

/**
 * Check if block is active or not
 *
 */
function dadicc_disable_blocking_lite() {
    
    if( is_admin() )
        return true;
    
    if( dadicc_is_bot_detected() )
        return true;
    
    if( (bool) dadicc_get_options('disable_php_block') === true )
        return true;
    
    return false;    
    
}

/**
 * Check allowed extensions
 *
 */
function dadicc_allowed_files( $path = '', $allowed = array() ) {
    
    if( (string) $path === '' ) {
        return false;
    }
    
    if( ! is_array( $allowed ) ) {
        (array) $allowed;
    }
        
    $ext = pathinfo( $path, PATHINFO_EXTENSION );

    if( !in_array( $ext, $allowed ) ) {
        return false;
    } else {
        return $path;
    }

}

/**
 * Check if WP Supercache is installed and retrieve type of cache (simple or advanced)
 * This function can be use only in admin panel
 *
 */
function dadicc_supercache_exists( $check = '' ) {
    
    /**
     * Class and methods below belong to the plugin below detailed and to his author
     * @plugin: Wp Supercache
     * @version: 1.6.4
     * @license: GPL2+
     * @author: Automattic
     */
    
    if( ! class_exists( 'WP_Super_Cache_Rest_Get_Settings') ) {
        return false;
    }
    
    $wscs = new WP_Super_Cache_Rest_Get_Settings();
    
    if( !method_exists( $wscs, 'get_cache_type' ) ) {
        return false;
    }
    
    if( strlen( $check ) === 0 ) {
        if( is_plugin_active( DADICC_WPSUPERCACHE_ACTIVE ) ) {
            return true;
        } 
        return false;
    } else {
        if( is_plugin_active( DADICC_WPSUPERCACHE_ACTIVE ) && (string) $wscs->get_cache_type() === (string) $check ) {
            return true;
        }
        return false;
    }

}

/**
 * Check if is active W3TC
 *
 */
function dadicc_w3tc_exists() {
    
    if( is_plugin_active( DADICC_W3TC_ACTIVE ) ) {
        return true;
    }
    return false;

}

/**
 * Check if is active Fastest Cache
 *
 */
function dadicc_fastest_cache_exists() {
    
    if( is_plugin_active( DADICC_FASTEST_ACTIVE ) ) {
        return true;
    }
    return false;
    
}

/**
 * Check if is active Cache Enabler
 *
 */
function dadicc_cache_enabler_exists() {
    
    if( is_plugin_active( DADICC_CACHE_ENABLER_ACTIVE ) ) {
        return true;
    }
    return false;
    
}

/**
 * Check if is active LiteSpeed Cache
 *
 */
function dadicc_litespeed_cache_exists() {
    
    if( is_plugin_active( DADICC_CACHE_LITE_SPEED_ACTIVE ) ) {
        return true;
    }
    return false;
    
}

/**
 * Retrieve an array of scripts url to enqueued
 *
 */
function dadicc_get_url_scripts( $array = true, $handle = null ) {
    
    global $wp_scripts;
    
    if( false === (bool) $array ) {
        
        if( !isset( $handle ) ) 
            return FALSE;
        
        if( !in_array( $handle, $wp_scripts->queue ) )
            return FALSE;
        
        if( $handle === 'jquery' ) {
            $url = apply_filters( 'dadicc_jquery', $jquery = includes_url('js/jquery/jquery.js') );
        } else {
            $obj = $wp_scripts->registered[$handle];
            $src = $obj->src;
            $url = $wp_scripts->base_url . $src;
        }
        
        if( filter_var( $url, FILTER_VALIDATE_URL ) === FALSE ) {
            return FALSE;
        }
        
        return $url;
        
    }
    
    $registered = array();
    foreach( $wp_scripts->queue as $handle ) {
        
        if( $handle === 'jquery' ) {
            $url = apply_filters( 'dadicc_jquery', $jquery = includes_url('js/jquery/jquery.js') );
        }
        else {
            $obj = $wp_scripts->registered[$handle];
            $src = $obj->src;
            
            if( filter_var( $src, FILTER_VALIDATE_URL ) === FALSE ) {
                $url = $wp_scripts->base_url . $src;
            } else {
                $url = $src;
            }
        }
        
        
        if( filter_var( $url, FILTER_VALIDATE_URL ) === FALSE ) {
            return FALSE;
        }
        
        $registered[$handle] = $url;
        
    }
    
    /**
     * Add oEmbed script
     */
    if( !is_admin() ) {
        $registered['wp-embed'] = apply_filters( 'dadicc_wp_embed', $embed = includes_url('js/wp-embed.min.js') );
    }
    
    return apply_filters( 'dadicc_registered_scripts', $registered );
    
    
}

/**
 * Retrieve an array of localize scripts by handle
 *
 */
function dadicc_get_localize_scripts( $array = true, $handle = null ) {
    
    global $wp_scripts;
    
    if( false === (bool) $array ) {
        
        if( !isset( $handle ) ) 
            return FALSE;
        
        if( !in_array( $handle, $wp_scripts->queue ) )
            return FALSE;
        
        $catch = $wp_scripts->get_data( $handle, 'data');
        
        return $catch;
        
    }
    
    $localize = array();
    foreach( $wp_scripts->queue as $handle ) {
    
        $catch = $wp_scripts->get_data( $handle, 'data');
        
        if( false !== $catch ) {
            $localize[$handle] = $catch;
        }
        
    }
    
    return apply_filters( 'dadicc_localize_scripts', $localize );
    
}

/**
 * Get Options
 * decode only for single value
 *
 */
function dadicc_get_options( $name, $decode = false ) {
    
    global $dadicc_options;
	
    $defaults = dadicc_default_options();

    if( !in_array( $name, array_keys( $defaults ) ) ) 
        return false;
    
    if( (bool) $decode === true && !is_array( $dadicc_options[$name] ) ) {
        return base64_decode( $dadicc_options[$name] );
    }

    return $dadicc_options[$name];

}

/**
 * Get Cookie Life
 *
 */
function dadicc_get_cookie_life() {
    
    $how_days = dadicc_get_options( 'cookie_life' );
    
    // session
    if( absint( $how_days ) === 0 ) {
        return 0;
    }
    
    $days = ( absint( $how_days ) * DADICC_DAY );
    
    $life = ( time() + $days );
    
    return $life;
    
}

/**
 * Return true if request premium features
 *
 */
function dadicc_is_premium_features() {
    
    global $dadicc_options_admin;
    
    if( !isset( $dadicc_options_admin['show_premium_features'] ) ) 
        return false;
    
    if( (bool) $dadicc_options_admin['show_premium_features'] === true ) {
        return true;
    }
    return false;
}

/**
 * Display premium message
 *
 */
function dadicc_display_premium_message( $message = '' ) {
    
    if( strlen( $message ) === 0 ) {
        $message = __('Only premium version.', DADICC_DOMAIN );
    }
    
    if( (bool) dadicc_is_premium_features() === true ) : ?>
        
        <span class="dadicc-infos dashicons-before dashicons-store dadicc-premium">
            <?php echo esc_html( $message ); ?>
        </span>
        
    <?php endif;
    
}

/**
 * Check if full plugin is active
 *
 */
function dadicc_is_full_version() {
    
    if( defined( 'DADICC_IS_PREMIUM_PLUGIN' ) && is_plugin_active( 'dadi-cookie-consent-ext/cookie-consent-ext.php' ) ) {
        return true;
    }
    return false;
    
}


/**
 * Dadicc kod
 *
 */
function dadicc_kod() {
    
    if( func_num_args() === 1 ) {
        return false;
    }
    
    $funcs = func_get_args();

    $tab = array();
    foreach( $funcs as $target ) {
     
        $tab[$target] = ['button' => '', 'tab' => ''];  
        if( $target = $funcs[0] ) {
             $tab[$target] = ['button' => ' current-button', 'tab' => ' current-tabber'];   
        }
        
    }
    
    return $tab;
    
}