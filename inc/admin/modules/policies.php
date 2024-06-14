<?php
/**
 * @package: Dadi Cookie Consent Lite
 * Policies
 */

if( ! defined( 'DADICC_ALLOW' ) ) {
    exit();
}

/**
 * Load policies module
 *
 */
function dadicc_get_module_policies( $options ) { ?>

    <!-- Cookie Policy -->

    <?php if( intval( $options['select_cookie_page'] ) <= 0 ) : ?>
    <div class="danger danger-cookie-policy-url"><p><span class="dashicons dashicons-warning"></span> <?php esc_html_e('You must select a page for the Cookie Policy!', DADICC_DOMAIN ); ?></p></div>
    <?php endif; ?>

    <h3 class="legend"><?php esc_html_e('Cookie Policy', DADICC_DOMAIN ); ?></h3>
    <p>
        <label for="cookie-policy-url"><?php printf( esc_html__('Select the "Cookie Policy" page%s %s(required)%s', DADICC_DOMAIN ), '<span class="dadicc-asterisk">*</span>', '<span class="required">', '</span>' ); ?></label><br />
        <select id="cookie-policy-url" name="dadicc_options[select_cookie_page]"> 
            <option value="-1"><?php esc_html_e('None', DADICC_DOMAIN ); ?></option> 
            <?php 
             $pages = get_pages(); 
             foreach ( $pages as $post ) { 
                   setup_postdata( $post );
                   $option = '<option value="' . esc_attr( $post->ID ) . '" ' . selected( $options['select_cookie_page'], $post->ID ) . '>';
                   $option .= esc_html( $post->post_title );
                   $option .= '</option>';
                   echo $option;
             } wp_reset_postdata();
            ?>
        </select>
        <span class="dadicc-note dashicons-before dashicons-admin-post"><?php esc_html_e('You must have previously created it.', DADICC_DOMAIN ); ?></span>
    </p>
    
    <?php if( (bool) dadicc_is_premium_features() === true ) : ?>
    
    <!-- Privacy Policy -->

    <h3 class="legend"><?php esc_html_e('Privacy Policy', DADICC_DOMAIN ); ?></h3>
    <p>
        <label for="privacy-policy-url"><?php printf( esc_html__('Select the "Privacy Policy" page%s %s(recommended)%s', DADICC_DOMAIN ), '<span class="dadicc-asterisk">*</span>', '<span class="recommended">', '</span>' ); ?></label><br />
        <?php dadicc_display_premium_message(); ?>
        <select id="privacy-policy-url" name="" disabled> 
            <option value=""><?php esc_html_e('Privacy Policy', DADICC_DOMAIN ); ?></option> 
        </select>
        <span class="dadicc-note dashicons-before dashicons-admin-post"><?php esc_html_e('You must have previously created it.', DADICC_DOMAIN ); ?></span>
    </p>
    
    <!-- Popup Policies -->
    
    <h3 class="legend"><?php esc_html_e('Policy Popup', DADICC_DOMAIN ); ?></h3>
    <p>
        <?php dadicc_display_premium_message(); ?>
        <input type="checkbox" id="show-policies-popup" name="" value="1" disabled>
        <label for="show-policies-popup"><?php esc_html_e('Show policies in a popup window, when the user clicks on the links in the banner or in the alerts.', DADICC_DOMAIN ); ?></label>
    </p>
    
    <?php endif; ?>

<?php } 

add_action('dadicc_policy_module', 'dadicc_get_module_policies' );