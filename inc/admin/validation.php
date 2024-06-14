<?php
/**
 * @package: Dadi Cookie Consent Lite
 * Sanitization and validation data
 */

/**
 * Validate policies input
 *
 */
function dadicc_input_policies( $input ) {

    $input['select_cookie_page'] = dadicc_filter_val( $input['select_cookie_page'], 'int' ) === -1 ? -1 : dadicc_filter_val( $input['select_cookie_page'], 'absint' );
    
    return $input;
    
}
add_filter( 'dadicc_input', 'dadicc_input_policies' );

/**
 * Validate banners input
 *
 */
function dadicc_input_banners( $input, $defaults ) {
    
    // show banners
    $input['show_banners']              = dadicc_filter_val( $input['show_banners'], 'intbool' );
    $input['message_banner'] 			= dadicc_filter_val( $input['message_banner'], 'textfield' );
    $input['message_banner_small'] 		= dadicc_filter_val( $input['message_banner_small'], 'textfield' );
    $input['show_btc_mini_banner']      = dadicc_filter_val( $input['show_btc_mini_banner'], 'intbool' );
    
    $check_labels = array('button_more_info_minimal', 'button_cookie_policy', 'button_consent');
    if( dadicc_is_full_version() === true ) {
        $check_labels[] = 'button_privacy_policy';
    }
    
    foreach( array_keys( dadicc_buttons_label() ) as $v ) {
        $v = dadicc_filter_val( $v, 'key' );
        if( (string) $input[$v] === '' || ( !in_array( $v, $check_labels ) ) ) {
            $input[$v] = $defaults[$v];
        }
        $input[$v] = dadicc_filter_val( $input[$v], 'textfield' );
    }
    
    $neutral_colors = dadicc_banner_keep_neutral_bgcolor();
    if( !in_array( $input['use_neutral_color'], array_keys( $neutral_colors ) ) ) {
        $input['use_neutral_color'] = $defaults['use_neutral_color'];
    }
    $input['use_neutral_color'] = dadicc_filter_val( $input['use_neutral_color'], 'textfield' );
    
    return $input;
    
}
add_filter( 'dadicc_input', 'dadicc_input_banners', 10, 2 );

/**
 * Validate blocking input
 *
 */
function dadicc_input_blocking( $input, $defaults ) {
    
    global $dadicc_options;
    
    $input['all_blocked_cookies']       = dadicc_filter_val( $input['all_blocked_cookies'], 'intbool' );
    $input['disable_php_block']         = dadicc_filter_val( $input['disable_php_block'], 'intbool' );
    $input['replace_instead_remove']    = dadicc_filter_val( $input['replace_instead_remove'], 'intbool' );
    $input['replace_text']              = dadicc_filter_val( $input['replace_text'], 'textfield' );
    $input['replace_text_footer']       = dadicc_filter_val( $input['replace_text_footer'], 'textfield' );
    
    return $input;
    
}
add_filter( 'dadicc_input', 'dadicc_input_blocking', 10, 2 );

/**
 * Validate consent input
 *
 */
function dadicc_input_consent( $input ) {
    
    $input['on_scroll']                 = dadicc_filter_val( $input['on_scroll'], 'intbool' );
    $input['on_navigation']             = dadicc_filter_val( $input['on_navigation'], 'intbool' );
    $input['cookie_life']               = dadicc_filter_val( $input['cookie_life'], 'absint' );
    $input['purge_cache']               = dadicc_filter_val( $input['purge_cache'], 'intbool' );
    $input['disable_cookiesgroup_w3tc'] = dadicc_filter_val( $input['disable_cookiesgroup_w3tc'], 'intbool' );
    
    return $input;
    
}
add_filter( 'dadicc_input', 'dadicc_input_consent' );

/**
 * Validate admins input
 *
 */
function dadicc_input_admin( $input ) {
    
    global $dadicc_options_admin;
    
    $input['empty_cache_onsave'] = dadicc_filter_val( $input['empty_cache_onsave'], 'intbool' );
    if( $input['empty_cache_onsave'] === 1 ) {
        dadicc_empty_cache();
    }
    $input['empty_cache_onsave'] = 0;
    
    $input['keep_on_save'] = dadicc_filter_val( $input['keep_on_save'], 'absint' );
    $dadicc_options_admin['keep_on_save'] = $input['keep_on_save'];
    update_option( DADICC_OPT_ADMIN, $dadicc_options_admin );
    unset( $input['keep_on_save'] );
    
    return $input;
    
}
add_filter( 'dadicc_input', 'dadicc_input_admin' );