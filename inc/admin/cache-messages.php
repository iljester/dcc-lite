<?php
/**
 * @package: Dadi Cookie Consent
 * cache messages
 */

if( ! defined( 'DADICC_ALLOW' ) ) {
    exit();
}

/**
 * Wp Supercache Consent Message
 *
 */
function dadicc_wp_supercache_consent_message() {
    
    if( (bool) dadicc_supercache_exists() === false ) {
        return;
    }
    
    if( (bool) dadicc_supercache_exists( 'mod_rewrite' ) === true ) { ?>
        <div class="dadicc-info">
            <p>
                <?php 
                esc_html_e('WP Supercache is active. You should set Wp Supercache to "Simple" (recommended) and '
                        . 'you should set the plugin to "Do not serve cache files for known users" (recommended).', DADICC_DOMAIN ); ?>
            </p>
        </div>
    <?php } else { ?>
        <div class="dadicc-info">
            <p>
                <?php 
                printf( esc_html__('WP Supercache is active. %s try to work with this cache plugin.', DADICC_DOMAIN ), DADICC_PLUGIN_NAME ); ?>
            </p>
        </div>
    <?php }
    
}
add_action('dadicc_cache_message', 'dadicc_wp_supercache_consent_message');

/**
 * Wp Supercache Global Message
 *
 */
function dadicc_wp_supercache_global_message( $nags ) {
    
    if( (bool) dadicc_supercache_exists( 'mod_rewrite' ) === false ) 
        return $nags;
    
    $url = dadicc_page_options_url();
    
    $nags['wp_supercache'] = array(
        'message' => sprintf( __('Wp Supercache is installed. Please go to the DCC options page %shere%s, section "Consent" to see notices and settings', DADICC_DOMAIN ), 
            '<a href="' . esc_url( $url ) . '">', '</a>' ),
        'remove' => true
    );
    
    return $nags;
    
}
add_filter('dadicc_global_msg', 'dadicc_wp_supercache_global_message');

/**
 * W3TC Consent Message
 *
 */
function dadicc_w3tc_consent_message() {
    
    if( (bool) dadicc_w3tc_exists() === true ) { ?>
        <div class="dadicc-info">
            <p>
                <?php printf( esc_html__('W3TC is active. %s try to work with this cache plugin.', DADICC_DOMAIN ), DADICC_PLUGIN_NAME ); ?>
            </p>
            <hr />
            <p>
                <input type="checkbox" id="disable-cookiesgroup-w3tc" name="dadicc_options[disable_cookiesgroup_w3tc]" value="1" <?php checked( $options['disable_cookiesgroup_w3tc'] ); ?> />
                <label for="disable-default-cookiesgroup-w3tc"><?php printf( esc_html__('Disable the default %s cookies group set W3TC page settings and create your own %s(not recommended)%s.', DADICC_DOMAIN ), DADICC_PLUGIN_NAME, '<span class="required">', '</span>' ); ?></label>
            </p>
        </div>
    <?php } 
    
}
add_action('dadicc_cache_message', 'dadicc_w3tc_consent_message');

/**
 * W3TC Global Message
 *
 */
function dadicc_w3tc_global_message( $nags ) {
    
    if( (bool) dadicc_w3tc_exists() === false ) 
        return $nags;
    
    $url = dadicc_page_options_url();
    
    $nags['w3tc_cache'] = array(
        'message' => sprintf( __('W3TC is installed. Please go to the %s options page %shere%s, section "Consent", to see notices and settings', DADICC_DOMAIN ), 
            DADICC_PLUGIN_NAME,
            '<a href="' . esc_url( $url ) . '">', '</a>' ),
        'remove' => true
    );
    
    return $nags;
    
}
add_filter('dadicc_global_msg', 'dadicc_w3tc_global_message');

/**
 * Fastest Cache Consent Message
 *
 */
function dadicc_fastest_cache_consent_message() {
    
    if( (bool) dadicc_fastest_cache_exists() === true && (bool) dadicc_is_premium_features() === true ) { ?>
        <div class="dadicc-info">
            <p>
                <span class="dadicc-premium"><?php esc_html_e( 'Fastest Cache is active. Only Premium version is compatible with this cache plugin.', DADICC_DOMAIN ); ?></span>
            </p>
            <hr />
            <p>
                <span class="dadicc-infos dashicons-before dashicons-store dadicc-premium"><?php esc_html_e('Only premium version', DADICC_DOMAIN ); ?></span>
                <input type="checkbox" id="disable-cookiesgroup-fastest" name="" value="1" disabled />
                <label style="display:inline;" for="disable-cookiesgroup-fastest"><?php printf( esc_html__('Disable the default Dadi Cookie Consent cookies group set in Fastest Cache page settings (tab "Exclude") and create your own %s(not recommended)%s.', DADICC_DOMAIN ), '<span class="required">', '</span>' ); ?></label><br />
                <span class="small"><?php esc_html_e('You should delete self-installed cookies from the "Exclude" panel in Fastest Cache.', DADICC_DOMAIN ); ?></span>
            </p>
        </div>
        
    <?php }
    
}
add_action('dadicc_cache_message', 'dadicc_fastest_cache_consent_message');

/**
 * Fastest Cache Global Message
 *
 */
function dadicc_fastest_cache_global_message( $nags ) {
    
    if( (bool) dadicc_fastest_cache_exists() === false || (bool) dadicc_is_premium_features() === false ) 
         return $nags;
    
    $url = dadicc_page_options_url();
    
    $nags['fastest_cache'] = array(
        'message' => sprintf( __('Fastest Cache is installed. Only Premium version is compatible with this cache plugin', DADICC_DOMAIN ), 
            '<a href="' . esc_url( $url ) . '">', '</a>' ),
        'remove' => true
    );
    
    return $nags;
    
}
add_filter('dadicc_global_msg', 'dadicc_fastest_cache_global_message');

/**
 * Cache Enabler Consent Message
 *
 */
function dadicc_cache_enabler_consent_message() {
    
    if( (bool) dadicc_cache_enabler_exists() === true && (bool) dadicc_is_premium_features() === true ) { ?>
        <div class="dadicc-info">
            <p>
                <span class="dadicc-premium">
                <?php esc_html_e( 'Cache Enabler is activated. Only Premium version is compatible with this cache plugin.', DADICC_DOMAIN ); ?>
                </span>
            </p>
        </div>   
    <?php }
    
}
add_action('dadicc_cache_message', 'dadicc_cache_enabler_consent_message');

/**
 * Cache Enabler Global Message
 *
 */
function dadicc_cache_enabler_global_message( $nags ) {
    
    if( (bool) dadicc_cache_enabler_exists() === false || (bool) dadicc_is_premium_features() === false ) 
         return $nags;
    
    $url = dadicc_page_options_url();
    
    $nags['enabler_cache'] = array(
        'message' => sprintf( __('Cache Enabler is installed. Only Premium version is compatible with this cache plugin', DADICC_DOMAIN ), 
            '<a href="' . esc_url( $url ) . '">', '</a>' ),
        'remove' => true
    );
    
    return $nags;
    
}
add_filter('dadicc_global_msg', 'dadicc_cache_enabler_global_message');

/**
 * LiteSpeed Consent Message
 *
 */
function dadicc_litespeed_consent_message() {
    
    if( (bool) dadicc_litespeed_cache_exists() === true && (bool) dadicc_is_premium_features() === true ) { ?>
        
        <div class="dadicc-info">
            <p>
                <span class="dadicc-premium"><?php esc_html_e( 'LiteSpeed Cache is activated. Only Premium version is compatible with this cache plugin.', DADICC_DOMAIN ); ?></span>
            </p>
        </div>   
        
    <?php }
    
}
add_action('dadicc_cache_message', 'dadicc_litespeed_consent_message');

/**
 * LiteSpeed Global Message
 *
 */
function dadicc_litespeed_global_message( $nags ) {
    
    if( (bool) dadicc_litespeed_cache_exists() === false || (bool) dadicc_is_premium_features() === false ) 
         return $nags;
    
    $url = dadicc_page_options_url();
    
    $nags['litespeed_cache'] = array(
        'message' => sprintf( __('LiteSpeed Cache is installed. Only Premium version is compatible with this cache plugin', DADICC_DOMAIN ), 
            '<a href="' . esc_url( $url ) . '">', '</a>' ),
        'remove' => true
    );
    
    return $nags;
    
}
add_filter('dadicc_global_msg', 'dadicc_litespeed_global_message');

/**
 * Unknow Cache System Consent Message
 *
 */
function dadicc_unknow_cache_system_consent_message() {
    
    if( 
        (bool) dadicc_w3tc_exists() === false && 
        (bool) dadicc_litespeed_cache_exists() === false && 
        (bool) dadicc_cache_enabler_exists() === false && 
        (bool) dadicc_fastest_cache_exists() === false && 
        (bool) dadicc_supercache_exists() === false
    ) { ?>
        <div class="dadicc-info">
            <p>
                <?php printf( esc_html__( 'Is active an unknow cache system plugin or no plugin cache. In the first case, %s is not sure that it can work with it.', DADICC_DOMAIN ), DADICC_PLUGIN_NAME ); ?>
            </p>
        </div>
    <?php } 
    
}
add_action('dadicc_cache_message', 'dadicc_unknow_cache_system_consent_message');

/**
 * Unknow Cache System Global Message
 *
 */
function dadicc_unknow_cache_system_global_message( $nags ) {
    
    if( 
        (bool) dadicc_w3tc_exists() === true || 
        (bool) dadicc_supercache_exists() === true ||
        (bool) dadicc_litespeed_cache_exists() === true || 
        (bool) dadicc_cache_enabler_exists() === true || 
        (bool) dadicc_fastest_cache_exists() === true 
    )
        return $nags;
    
    $url = dadicc_page_options_url();
    
    $nags['unknow_cache'] = array(
        'message' => sprintf( esc_html__('An unknow cache system is installed or no plugin cache installed. In the first case, %s is not sure that it can work with it', DADICC_DOMAIN ), DADICC_PLUGIN_NAME ), 
        'remove' => true
    );
    
    return $nags;
    
}
add_filter('dadicc_global_msg', 'dadicc_unknow_cache_system_global_message');


