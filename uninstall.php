<?php
/**
 * @package: Dadi Cookie Consent Lite
 * Uninstall action
 **/

if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 
	exit();
    
global $wpdb, $dadicc_options_admin;

if( $dadicc_options_admin['keep_all_options'] === false ) {

    if ( !is_multisite() ) {
        delete_option( DADICC_OPT );
        delete_option( DADICC_OPT_ADMIN );
    }
    else {

        $blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
        $original_blog_id = get_current_blog_id();
        foreach ( $blog_ids as $blog_id ) {
            switch_to_blog( $blog_id );
            delete_option( DADICC_OPT );
            delete_option( DADICC_OPT_ADMIN );
        }
        switch_to_blog( $original_blog_id );
        delete_option( DADICC_OPT );
        delete_option( DADICC_OPT_ADMIN );
    }

}