<?php
/* 
Plugin Name: Dadi Cookie Consent Lite
Plugin URI: https://www.iljester.com/portfolio/dadi-cookie-consent/
Description: Consent system, based on cookies. It blocks scripts and iframes that can potentially generate profiling cookies
Version: 1.1.5
Author: iljester
Author URI: https://www.iljester.com/

/*  Copyright 2018-2024 IL JESTER (email: thejester72@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*  *********************************************************************
 
    This software does not guarantee full compliance with the EU Cookie Law and GDPR. 
    Before and during the use of this software, please
    request legal advice to verify that your 
    website is in compliance with the Eu Cookie Law and GDPR.

    It is the responsibility of the website administrator to make these legal checks.
    This software simply helps website ammministrator to block 
    cookies and potentially invasive content of user privacy,
    submitting the content to the prior consent.

***********************************************************************/

/**
 * If we are not in the admin panel, exit
 */
if (!function_exists('is_admin')) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit();
}

/**
 * Constants
 */
if( ! defined( 'DADICC_IS_PREMIUM_PLUGIN' ) ) {
    define( 'DADICC_PLUGIN_NAME', 'Dadi Cookie Consent Lite');
    define( 'DADICC_PLUGIN_NAME_ABB', 'DCC Lite' );
    define( 'DADICC_VERSION', '1.1.5');
} else {
    define( 'DADICC_PLUGIN_NAME', 'Dadi Cookie Consent');
    define( 'DADICC_PLUGIN_NAME_ABB', 'DCC' );
    define( 'DADICC_VERSION', '1.0');
}
define( 'DADICC_ALLOW', TRUE );
define( 'DADICC_DOMAIN', 'dadicc' );
define( 'DADICC_PREFIX', 'dadicc_');
define( 'DADICC_OPT', 'dadicc_options' );
define( 'DADICC_OPT_ADMIN', 'dadicc_options_admin' );
define( 'DADICC_FRONT_STYLE', 'dadicc-style');
define( 'DADICC_ADMIN_STYLE', 'dadicc-admin-style');
define( 'DADICC_FRONT_JS', 'dadicc-front-js');
define( 'DADICC_ADMIN_JS', 'dadicc-admin-js');
define( 'DADICC_GLOBAL_CK', 'dadicc_agree');
define( 'DADICC_COOKIE_CONSENT_VARS', 'CookieConsentVars');
define( 'DADICC_DAY', (24*3600) );
define( 'DADICC_ACTIVE', 1 );
define( 'DADICC_WPSUPERCACHE_ACTIVE', 'wp-super-cache/wp-cache.php' );
define( 'DADICC_W3TC_ACTIVE', 'w3-total-cache/w3-total-cache.php');
define( 'DADICC_FASTEST_ACTIVE', 'wp-fastest-cache/wpFastestCache.php');
define( 'DADICC_CACHE_ENABLER_ACTIVE', 'cache-enabler/cache-enabler.php');
define( 'DADICC_CACHE_LITE_SPEED_ACTIVE', 'litespeed-cache/litespeed-cache.php');
define( 'DADICC_BLOCK_CLASS', 'dadicc-block');
define( 'DADICC_BOXES', 8 );
define( 'DADICC_PURCHASE_URL', "https://www.iljester.com/portfolio/dadi-cookie-consent/");

/**
 * Set Absolute Base
 */
function dadicc_base_path( $path = '' ) {
    return plugin_dir_path(__FILE__) . $path;
}

/**
 * Set Base
 */
function dadicc_base_url( $path = '' ) {
    return plugin_dir_url(__FILE__) . $path;
}

/*
 * Set languages directory
 */
function dadicc_load_textdomain() {
    load_plugin_textdomain( DADICC_DOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
}
add_action( 'plugins_loaded', 'dadicc_load_textdomain' );

/**
 * ../inc/admin
 */
require_once dadicc_base_path( 'inc/admin/defaults.php' );
require_once dadicc_base_path( 'inc/admin/admin-init.php' );
require_once dadicc_base_path( 'inc/admin/validation.php' );
require_once dadicc_base_path( 'inc/admin/form.php' );
require_once dadicc_base_path( 'inc/admin/cache-messages.php');
require_once dadicc_base_path( 'inc/admin/ajax-actions.php');

/**
 * ../inc/admin/modules
 */
require_once dadicc_base_path( 'inc/admin/modules/policies.php' );
require_once dadicc_base_path( 'inc/admin/modules/banners.php' );
require_once dadicc_base_path( 'inc/admin/modules/consent.php' );
require_once dadicc_base_path( 'inc/admin/modules/blocking.php' );
require_once dadicc_base_path( 'inc/admin/modules/replaces.php');
require_once dadicc_base_path( 'inc/admin/modules/noscript.php' );
require_once dadicc_base_path( 'inc/admin/modules/advanced.php');
require_once dadicc_base_path( 'inc/admin/modules/services.php');
require_once dadicc_base_path( 'inc/admin/modules/about.php');
require_once dadicc_base_path( 'inc/admin/modules/premium.php');
require_once dadicc_base_path( 'inc/admin/modules/internal.php');
require_once dadicc_base_path( 'inc/admin/modules/sticky-bar.php');


/**
 * ../inc/commons
 */
require_once dadicc_base_path( 'inc/commons/misc.php' );
require_once dadicc_base_path( 'inc/commons/cache.php' );

/**
 * ../inc/front
 */
require_once dadicc_base_path( 'inc/front/front-init.php' );
require_once dadicc_base_path( 'inc/front/banners.php' );
require_once dadicc_base_path( 'inc/front/blocking.php' );
require_once dadicc_base_path( 'inc/front/consent.php' );
require_once dadicc_base_path( 'inc/front/policies.php' );
require_once dadicc_base_path( 'inc/front/shortcodes.php' );
require_once dadicc_base_path( 'inc/front/replace.php');

/**
 * Set Options
 */
function dadicc_set_options() {
    
    if ( ! current_user_can( 'activate_plugins' ) ) 
        return;

    $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
    check_admin_referer( "activate-plugin_{$plugin}" );

    $defaults = dadicc_default_options();
    $defaults_admin =  dadicc_default_options_admin();

    add_option( DADICC_OPT, $defaults );
    add_option( DADICC_OPT_ADMIN, $defaults_admin );

    return true;
        
    
}
register_activation_hook( __FILE__, 'dadicc_set_options');

/**
 * Set globals
 */
function dadicc_set_globals() {
    
    // cookie consent settings
    $defaults = dadicc_default_options();
    $GLOBALS[DADICC_OPT] = get_option(DADICC_OPT, $defaults );
    
    // admin settings
    if( is_admin() ) {
        $defaults_admin = dadicc_default_options_admin();
        $GLOBALS[DADICC_OPT_ADMIN] = get_option( DADICC_OPT_ADMIN, $defaults_admin );
    }
}
add_action('init', 'dadicc_set_globals', 1 );

/**
 * Set page option url
 */
function dadicc_page_options_url() {
    
    return admin_url('admin.php?page=dadicc-options-page');
    
}
