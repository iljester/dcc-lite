<?php
/**
 * @package: Dadi Cookie Consent Lite
 * Defaults Values
 */

if( ! defined( 'DADICC_ALLOW' ) ) {
    exit();
}

/**
 * Set default options
 *
 */
function dadicc_default_options() {
    
    $policy = array(
        'select_cookie_page' => ''
    );
    
    $banners = array(
        'show_banners'              => 1,
        'message_banner_small'      => 'This website uses cookies to give you the best browsing experience',
        'show_btc_mini_banner'      => 0,
        'message_banner'            => 'This site or third-party tools used, use cookies necessary for the operation and useful for the purposes outlined in the cookie policy. If you want to learn more or opt out of all or some cookies, see the cookie policy.
By clicking on the "I agree" link, you consent to the use of cookies.',
        'use_neutral_color'         => 'inherit',
    );
    
    $blocking = array(
        'all_blocked_cookies'       => 0,
        'replace_instead_remove'    => 0,
        'replace_text'              => 'Viewing this element requires cookie consent',
        'replace_text_footer'       => 'Read our {cookie_policy} for more info and consent.',
        'disable_php_block'         => 0,
    );
    
    $consent = array(
        'on_scroll'                 => 0,
        'on_navigation'             => 0,
        'cookie_life'               => 30,
        'disable_cookiesgroup_w3tc' => 0,
        'purge_cache'               => 1
    );
            
    $misc = array(
        'empty_cache_onsave'        => 0,
        'kept_scripts'            => array()
    );
    
    $defaults = array_merge( $policy, $banners, $blocking, $consent, $misc );

    foreach( dadicc_buttons_label() as $k => $v ) {
        $defaults[$k] = $v['value'];
    }

    return apply_filters( 'dadicc_defaults', $defaults );
	
}

/**
 * Defaults Options Admin
 *
 */
function dadicc_default_options_admin() {
    
    $defaults = array();
    
    $defaults['keep_on_save'] = 0;
    $defaults['show_premium_features'] = 0;
    $defaults['keep_all_options'] = 0;
    
    return apply_filters( 'dadicc_defaults_admin', $defaults );
    
}

/**
 * Minimal banner margins
 *
 */
function dadicc_minimal_banner_horizontal_position() {
    
    $margins = array(
        'left'      => esc_html__('Show the Minimal Banner on the left', DADICC_DOMAIN ),
        'right'     => esc_html__('Show the Minimal Banner on the right', DADICC_DOMAIN ),
        'center'    => sprintf( esc_html__('Show the Minimal Banner on the center%s', DADICC_DOMAIN ), '<span class="dadicc-asterisk">*</span>' )
    );
    
    return $margins;
}

/**
 * Banner styles options
 *
 */
function dadicc_banner_color_scheme() {
    
    $style = array(
        'default'   => esc_html__( 'Dark Night', DADICC_DOMAIN ),
        'maroon'    => esc_html__( 'Maroon Brick', DADICC_DOMAIN ),
        'blue'      => esc_html__( 'Blue Sea', DADICC_DOMAIN ),
        'green'     => esc_html__( 'Green Field', DADICC_DOMAIN )
    );
    
    return $style;
    
}

/**
 * Keep neutral bgcolor
 *
 */
function dadicc_banner_keep_neutral_bgcolor() {
    
    $bg = array(
        'bg-inherit'   => esc_html__( 'Auto', DADICC_DOMAIN ),
        'bg-white'     => esc_html__( 'White Background', DADICC_DOMAIN ),
        'bg-black'     => esc_html__( 'Black Background', DADICC_DOMAIN )
    );
    
    return $bg;
    
}

/**
 * Use semi-transparent background
 *
 */
function dadicc_background_transparent() {
    
    $transparent = array(
        'bg_big_tran' => ['value' => 0, 'label' => esc_html__( 'Use the semi-transparent background on the extended banner', DADICC_DOMAIN )],
        'bg_small_tran' => ['value' => 0, 'label' => esc_html__( 'Use the semi-transparent background on the minimal banner', DADICC_DOMAIN )],
        'bg_popup_tran' => ['value' => 0, 'label' => esc_html__( 'Use the semi-transparent background on the popup window', DADICC_DOMAIN )],
    );
    
    return $transparent;

}

/**
 * Buttons label
 *
 */
function dadicc_buttons_label() {
    
    $fields = array(
        'button_more_info_minimal'  => ['value' => 'More Info', 'label' => esc_html__( '"More Info" button (minimal banner)', DADICC_DOMAIN )],
        'button_cookie_policy'      => ['value' => 'Cookie Policy', 'label' => sprintf( esc_html__( '"Cookie Policy" Button Link (extended banner)%s' ), '<span class="dadicc-asterisk">*</span>' )],
        'button_privacy_policy'     => ['value' => 'Privacy Policy', 'label' => sprintf( esc_html__( '"Privacy Policy" button Link (extended banner)%s' ), '<span class="dadicc-asterisk">*</span>' )],
        'button_consent'            => ['value' => 'I agree', 'label' => esc_html__('"Agree" button (minimal and extended banner)', DADICC_DOMAIN )],
    );
    
    return $fields;

}