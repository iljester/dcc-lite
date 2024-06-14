<?php
/**
 * @package: Dadi Cookie Consent Lite
 * Cache system manager
 */

if( ! defined( 'DADICC_ALLOW' ) ) {
    exit();
}

/**
 * Add cookie consent to wp_supercache config
 * plugin: WP Supercache
 *
 */
function dadicc_add_wpsc_cookie() {
    
    /**
     * Action below belong to the plugin below detailed and to his author
     * @plugin: Wp Supercache
     * @version: 1.6.4
     * @license: GPL2+
     * @author: Automattic
     */
    do_action( 'wpsc_add_cookie', DADICC_GLOBAL_CK );
}
add_action( 'init', 'dadicc_add_wpsc_cookie' );

/**
 * Create cookie group for W3TC
 * Note: this filter not allow to edit group by W3TC panel
 *
 */
function dadicc_add_w3tc_cookie_groups( $groups ) {
    
    $deactivated = dadicc_get_options('disable_cookiesgroup_w3tc');
    
    if( (bool) $deactivated === true ) {
        return $groups;
    }
    
    $groups['value']['dadi_cookie_consent'] = array(
        'enabled' => true,
        'cache' => false,
        'cookies' => array( DADICC_GLOBAL_CK )
    );
    
    return $groups;
    
}
/**
 * Filter below belong to the plugin below detailed and to his author
 * @plugin: W3TC (W3 TOTAL CACHE)
 * @version: 0.9.7
 * @license: GPL2+
 * @author: Frederick Townes
 */
add_filter('w3tc_ui_config_item_pgcache.cookiegroups.groups', 'dadicc_add_w3tc_cookie_groups');

/**
 * Disabled edit group in the W3TC plugin
 *
 */
function dadicc_disable_input_group_cookie() {
    
    $deactivated = dadicc_get_options('disable_cookiesgroup_w3tc');
    
    if( (bool) $deactivated === true ) {
        return $groups;
    }
    
    $current_screen = get_current_screen();
    
    if( $current_screen->id === 'performance_page_w3tc_pgcache_cookiegroups') {
        
        ?>
<style id="cookiegroup-by-dadicc-css">
    #cookie-group-by-dadicc {
        padding: 10px;
        display: block;
        background-color: #dc0505;
        border-radius: 8px 8px 0 0;
        color: #fff;
        font-weight: bold;
        font-size: 1.1em;
    }
</style>
<script id="cookie-group-by-dadicc-js">jQuery(function($) {
    $('#cookiegroup_dadi_cookie_consent').prepend( '<div id="cookie-group-by-dadicc"><?php esc_html_e('This group is added by Dadi Cookie Consent and can not be changed. To remove it, see Dadi Cookie Consent Settings.', DADICC_DOMAIN ); ?></div>');
    $('#cookiegroup_dadi_cookie_consent textarea, #cookiegroup_dadi_cookie_consent input').prop('disabled', true );
    $('#cookiegroup_dadi_cookie_consent input.button.w3tc_cookiegroup_delete, #cookiegroup_dadi_cookie_consent .description').remove();
});
</script><?php
        
    }

}
add_action('admin_head', 'dadicc_disable_input_group_cookie' );

/**
 * Intercept send data when settings saved for W3TC plugin
 *
 */
function dadicc_set_cookie_group( $cookiegroups ) {
    
    $deactivated = dadicc_get_options('disable_cookiesgroup_w3tc');
    
    if( (bool) $deactivated === true ) {
        return $cookiegroups;
    }
    
    $cookiegroups['dadi_cookie_consent'] = array(
        'enabled' => true,
        'cache' => false,
        'cookies' => array( DADICC_GLOBAL_CK )
    );
    
    return $cookiegroups;
    
}
/**
 * Filter below belong to the plugin below detailed and to his author
 * @plugin: W3TC (W3 TOTAL CACHE)
 * @version: 0.9.7
 * @license: GPL2+
 * @author: Frederick Townes
 */
add_filter('w3tc_pgcache_cookiegroups', 'dadicc_set_cookie_group');

/**
 * Purge Cache for some cache plugins
 * It can add new system cache using do action "dadicc_clear_cache"
 *
 */
function dadicc_empty_cache() {

    $blog_id = 0;
    if( is_multisite() ) {
        $blog_id = get_current_blog_id();
    }

    /**
     * Add system clear cache
     */
    do_action( 'dadicc_clear_cache', $blog_id );

    return true;

}

/**
 * Compatible Cache System
 * These are the cache systems of which a total or partial compatibility with DCC
 *
 */
function dadicc_compatible_system_cache() {
    
    if( ! is_admin() ) {
        return;
    }
    
    if( ! isset( $GLOBALS['compatible_system_cache'] ) ) {
        $GLOBALS['compatible_system_cache'] = array();
    }
    
    $compatibles = array(
        'Wp Supercache',
        'W3 Total Cache'
    );
    
    $compatibles = apply_filters( 'dadicc_compatible_system_cache', $compatibles );

    $GLOBALS['compatible_system_cache'] = array_map( 'sanitize_text_field', $compatibles );
    
}
add_action('admin_init', 'dadicc_compatible_system_cache' );

/**
 * When user accept or remove consent 
 * clean supercache cache
 * plugin: WP Supercache
 *
 */
function dadicc_supercache_purge_cache( $blog_id ) {
    
    /**
     * Functions and globals below belong to the plugin below detailed and to his author
     * @plugin: Wp Supercache
     * @version: 1.6.4
     * @license: GPL2+
     * @author: Automattic
     */
    global $supercachedir;
    
    if ( empty( $supercachedir ) && function_exists( 'get_supercache_dir' ) ) {
       $supercachedir = get_supercache_dir();
    }

    if( function_exists( 'wp_cache_clear_cache') ) {
       wp_cache_clear_cache( $blog_id );
    }
    
}
add_action('dadicc_clear_cache', 'dadicc_supercache_purge_cache' );

/**
 * When user accept or remove consent 
 * clean w3tc cache
 *
 */
function dadicc_w3tc_purge_cache() {
    
    /**
     * Functions below belong to the plugin below detailed and to his author
     * @plugin: W3TC (W3 TOTAL CACHE)
     * @version: 0.9.7
     * @license: GPL2+
     * @author: Frederick Townes
     */
    if( function_exists('w3tc_flush_all') ) {
        w3tc_flush_all();
    }
    
}
add_action('dadicc_clear_cache', 'dadicc_w3tc_purge_cache');