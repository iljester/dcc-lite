<?php
/**
 * @package: Dadi Cookie Consent Lite
 * Ajax actions
 */

if( ! defined( 'DADICC_ALLOW' ) ) {
    exit();
}

/**
 * Remove notices
 *
 */
function dadicc_remove_nags() {
    
    if( filter_has_var( INPUT_POST, 'notice_id' ) ) {
        
        if ( ! filter_has_var( INPUT_POST, 'wp_nonce' ) || ! wp_verify_nonce( filter_input( INPUT_POST, 'wp_nonce', FILTER_SANITIZE_STRING ), dadicc_build_nonce( dirname( __FILE__ ) ) ) ) {
            die( 'Is it a joke?');
        }
        
        $notice_id = filter_input( INPUT_POST, 'notice_id', FILTER_SANITIZE_STRING );
        
		set_transient( $notice_id, 1 );
        
        wp_die('1');
        
    }
    
    wp_die('0');
    
}
add_action( 'wp_ajax_dadiccRemoveNotice', 'dadicc_remove_nags' );

/**
 * Keep Open Box
 *
 */
function dadicc_remove_keep_on_save() {
    
    if( filter_has_var( INPUT_POST, 'remove' ) && filter_input( INPUT_POST, 'remove', FILTER_VALIDATE_INT ) === 1 ) {
        
        if ( ! filter_has_var( INPUT_POST, 'wp_nonce' ) || ! wp_verify_nonce( filter_input( INPUT_POST, 'wp_nonce', FILTER_SANITIZE_STRING ), dadicc_build_nonce( dirname( __FILE__ ) ) ) ) {
            die( 'Is it a joke?');
        }
        
        global $dadicc_options_admin;
        
        $dadicc_options_admin['keep_on_save'] = 0;
        update_option( DADICC_OPT_ADMIN, $dadicc_options_admin );

        wp_die('1');
    
    }
    
    wp_die('0');
    
}
add_action( 'wp_ajax_dadiccRemoveOpenBox', 'dadicc_remove_keep_on_save' );

/**
 * Keep Open Box
 *
 */
function dadicc_keep_on_save_data_tab() {
    
    if( filter_has_var( INPUT_POST, 'data_open' ) && filter_input( INPUT_POST, 'data_open', FILTER_SANITIZE_STRING ) !== '' ) {
        
        if ( ! filter_has_var( INPUT_POST, 'wp_nonce' ) || ! wp_verify_nonce( filter_input( INPUT_POST, 'wp_nonce', FILTER_SANITIZE_STRING ), dadicc_build_nonce( dirname( __FILE__ ) ) ) ) {
            die( 'Is it a joke?');
        }
        
        global $dadicc_options_admin;
        
        $data_open = filter_input( INPUT_POST, 'data_open', FILTER_SANITIZE_STRING );
        $dadicc_options_admin['keep_open_dt'] = $data_open;
        
        update_option( DADICC_OPT_ADMIN, $dadicc_options_admin );

        wp_die('1');
    
    }
    
    wp_die('0');
    
}
add_action( 'wp_ajax_dadiccKeepOpenBoxDt', 'dadicc_keep_on_save_data_tab' );

/**
 * Reset options
 *
 */
function dadicc_reset_action() {
    
    if( filter_has_var( INPUT_POST, 'reset_action' ) && filter_input( INPUT_POST, 'reset_action', FILTER_VALIDATE_BOOLEAN ) === true ) {
        
        if ( ! filter_has_var( INPUT_POST, 'wp_nonce' ) || ! wp_verify_nonce( filter_input( INPUT_POST, 'wp_nonce', FILTER_SANITIZE_STRING ), dadicc_build_nonce( dirname( __FILE__ ) ) ) ) {
            die( 'Is it a joke?');
        }
        
        $defaults = dadicc_default_options();
        update_option( 'dadicc_options', $defaults );

        wp_safe_redirect( add_query_arg( array( 'page' => 'dadicc-options-page' ), admin_url( 'admin.php' ) ) );
        
    }
    
}
add_action( 'wp_ajax_dadiccResetAction', 'dadicc_reset_action' );

/**
 * Show Premium Features
 *
 */
function dadicc_show_premium_features() {
    
    if( filter_has_var( INPUT_POST, 'premium_features' ) ) {
        
        if ( ! filter_has_var( INPUT_POST, 'wp_nonce' ) || ! wp_verify_nonce( filter_input( INPUT_POST, 'wp_nonce', FILTER_SANITIZE_STRING ), dadicc_build_nonce( dirname( __FILE__ ) ) ) ) {
            die( 'Is it a joke?');
        }
        
        global $dadicc_options_admin;

        $options = $dadicc_options_admin;
        
        $value = filter_input( INPUT_POST, 'premium_features', FILTER_VALIDATE_INT );
        
        $options['show_premium_features'] = absint( $value );
        
        update_option( 'dadicc_options_admin', $options );
        
        wp_die('1');
        
    }
    
}
add_action( 'wp_ajax_dadiccShowPremiumFeatures', 'dadicc_show_premium_features' );


/**
 * Keep all options
 *
 */
function dadicc_keep_options_ondelete() {
    
    if( filter_has_var( INPUT_POST, 'keep_all_options' ) ) {
        
        sleep(1);
        
        if ( ! filter_has_var( INPUT_POST, 'wp_nonce' ) || ! wp_verify_nonce( filter_input( INPUT_POST, 'wp_nonce', FILTER_SANITIZE_STRING ), dadicc_build_nonce( dirname( __FILE__ ) ) ) ) {
            die( 'Is it a joke?');
        }
        
        global $dadicc_options_admin;

        $options = $dadicc_options_admin;
        
        $value = filter_input( INPUT_POST, 'keep_all_options', FILTER_VALIDATE_INT );
        
        $options['keep_all_options'] = absint( $value );
        
        update_option( DADICC_OPT_ADMIN, $options );
        
        wp_die('1');
        
    }
    
}
add_action( 'wp_ajax_dadiccKeepAllOptions', 'dadicc_keep_options_ondelete' );