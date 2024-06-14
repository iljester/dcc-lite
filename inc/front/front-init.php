<?php
/**
 * @package: Dadi Cookie Consent Lite
 * Front Init
 */

if( ! defined( 'DADICC_ALLOW' ) ) {
    exit();
}

/**
 * Load scripts and styles in frontend
 *
 */
function dadicc_add_scripts_and_styles() {
    
    global $post, $dadicc_options;
    
    // styles
    $web_font = apply_filters( 'dadicc_banner_web_font', $font_url = 'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,700italic,400,700,300' );
    wp_enqueue_style( 'dadicc-web-font', esc_url( $web_font ) );
    wp_enqueue_style( 'dadicc-fontello', dadicc_base_url() . 'css/fontello/css/fontello.css');
    wp_enqueue_style( DADICC_FRONT_STYLE, dadicc_base_url() . 'css/dadicc-front.css' );
    
    // scripts
    $js_front = apply_filters( 'dadicc_js_front', $js_front = dadicc_base_url() . 'js/dadicc-front-lite.js' );
    wp_enqueue_script( DADICC_FRONT_JS, esc_url( $js_front ), array( 'jquery' ) );

    $cookie_page_id = $dadicc_options['select_cookie_page'];
    
    $cookie_consent_vars = array(
        'CookiePidCookie'       => absint( $cookie_page_id ),
        'CookieIsPageCookie'    => absint( is_page( $cookie_page_id ) ),
        'CookiePageCookieLink'  => esc_url( get_permalink( $cookie_page_id ) ),
        'CookieGlobalCk'        => DADICC_GLOBAL_CK,
        'CookieDisplayBanner'   => esc_html( $dadicc_options['show_banners'] ),
        'CookieBanners'         => stripslashes( dadicc_get_banners() ),
        'CookieSite'  		=> esc_url( home_url( '/' ) ),
        'CookiePlugin' 		=> esc_url( dadicc_base_url() ),
        'CookieBlockClass'      => DADICC_BLOCK_CLASS,
        'CookieOnScroll'	=> esc_js( $dadicc_options['on_scroll'] ),
        'CookieOnNav'           => esc_js( $dadicc_options['on_navigation'] ),
        'CookieAjaxUrl'         => admin_url( 'admin-ajax.php' ),
        'CookieReplace'         => absint( $dadicc_options['replace_instead_remove'] ),
        'CookieMessageReplace'  => dadicc_generate_replace_box(),
        'CookieLife'            => absint( $dadicc_options['cookie_life'] ),
        'CookieMsgAddCons'      => esc_html__( 'Consent Granted', DADICC_DOMAIN ),
        'CookieMsgRemoveCons'   => esc_html__( 'Consent Revoked', DADICC_DOMAIN ),
        'CookieAlertContent'    => esc_html__( 'The content could not be loaded!', DADICC_DOMAIN )
    );
    
    $cookie_consent_vars = apply_filters( 'dadicc_consent_vars', $cookie_consent_vars );

    wp_localize_script( DADICC_FRONT_JS, DADICC_COOKIE_CONSENT_VARS, $cookie_consent_vars );
    
    $dadicc_options['cookie_consent_vars'] = $cookie_consent_vars;
    update_option( DADICC_OPT, $dadicc_options );
    
}

add_action( 'wp_enqueue_scripts', 'dadicc_add_scripts_and_styles' );

/**
 * Clean premium shortcodes if switch to lite version in content and widgets
 * For others places, you have to provide for yourself.
 *
 */
function dadicc_strip_shortcodes( $content ) {
    
    $pattern = '/\[(dadicc-block|dadicc-html|dadicc-bypass)(.*?)\](.*?)\[\/?(dadicc-block|dadicc-html|dadicc-bypass)\]/ms';
    
    preg_match_all( $pattern, $content, $match );
    
    $shortcodes = array();
    $oembed = array();
    foreach( $match[0] as $m ) {
        $shortcodes[] = trim( $m );
        $filtered = preg_replace( '/\[\/?(dadicc-block|dadicc-html|dadicc-bypass)(.*?)\]/ms', '', $m );
        if( false !== wp_oembed_get( $filtered ) ) {
            $oembed[] = wp_oembed_get( $filtered );
        } else {
            $oembed[] = $filtered;
        }
    }
    
    $content = str_replace( $shortcodes, $oembed, $content );
       
    return $content;
    
}
add_filter('the_content', 'dadicc_strip_shortcodes');
add_filter('widget_text', 'dadicc_strip_shortcodes');