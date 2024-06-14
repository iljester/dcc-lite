<?php
/**
 * @package: Dadi Cookie Consent Lite
 * Replace box for blocked elements
 */

if( ! defined( 'DADICC_ALLOW' ) ) {
    exit();
}

/**
 * Generate Replace Box
 *
 */
function dadicc_generate_replace_box() {
    
    global $dadicc_options;
    
    if( empty( $dadicc_options ) || !isset( $dadicc_options ) ) {
        return '';
    }
    
    $html = apply_filters( 'dadicc_replace_box_before', $html = '', $dadicc_options );
    
    if( $html === '' ) {
    
        $label_text = $dadicc_options['replace_text'];        
        $link_cookie_page  = dadicc_get_cookie_policy_link( true, $dadicc_options );

        $more_info = str_replace( 
            array(
                '{cookie_policy}',
            ),
            array(
                $link_cookie_page
            ),
            $dadicc_options['replace_text_footer']
        );

        $html .= '<div class="dadicc-msg-replace dadicc-no-consent-global">';
        $html .= '<p class="dadicc-label">';
        $html .= '<span>' . esc_html( $label_text ) . '</span>';
        $html .= '</p>';
        $html .= '<span class="dadicc-text-footer">' . wp_kses( $more_info, array( 'a' => array( 'href' => array(), 'target' => array(), 'class' => array(), 'data-policy' => array() ) ) ) . '</span>';
        $html .= '</div>';
    
    }
    
    return apply_filters( 'dadicc_replace_box_after', $html, $dadicc_options );

    
}