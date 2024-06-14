<?php
/**
 * @package: Dadi Cookie Consent Lite
 * Shortcodes
 */

if( ! defined( 'DADICC_ALLOW' ) ) {
    exit();
}

/**
 * [dadicc-consent-lite] shortcode
 *
 */
function dadicc_input_service_shortcode( $atts ) {
  
	extract(shortcode_atts(array(
		'popup' => "true",
                'label' => '',
                'wrap' => "false"
	), $atts));
        
	$is_popup   = filter_var( $popup, FILTER_VALIDATE_BOOLEAN );
	$show_popup = $is_popup === true ? 'dadicc-show-popup ' : '';

        $checked = '';
	if( filter_has_var( INPUT_COOKIE, DADICC_GLOBAL_CK ) ) {
            $checked = ' checked';
	}

        $id = ' id="' . esc_attr( DADICC_GLOBAL_CK ) . '" ';

	$output   = '<input type="checkbox" class="dadicc-service ' . esc_attr( $show_popup ) . DADICC_GLOBAL_CK . '"' . $id . 'name="' . DADICC_GLOBAL_CK . '" value="1"' . esc_attr( $checked ) . ' />';
        $output  .= $label !== '' ? '<label class="dadicc-label-consent" for="' . DADICC_GLOBAL_CK . '">' . esc_html( $label ) . '</label>' : '';
        
        $html = filter_var( $wrap, FILTER_VALIDATE_BOOLEAN ) === true ? '<span id="dadicc-wrap-input-"' . DADICC_GLOBAL_CK . '" class="dadicc-wrap-input-consent">' . $output . '</span>' : $output;
        
	return $html;
}
add_shortcode( 'dadicc-consent-lite', 'dadicc_input_service_shortcode');

/**
 * [dadicc-block-lite] Block content and replace with box warning
 *
 */
function dadicc_block_lite( $atts, $content = null ) {

    $a = shortcode_atts( array(
        'replace' => 1
    ), $atts );

    /**
     * Get embed
     */
    if( false !== wp_oembed_get( $content ) ) {
        $content = wp_oembed_get( $content );
    }

    /**
     * Return content or replace box
     */
    if( filter_has_var( INPUT_COOKIE, DADICC_GLOBAL_CK ) ) {   
        return $content;
    } else {
        if( (bool) $a['replace'] === true ) {
            return dadicc_generate_replace_box();
        } else {
            return '';
        }
    }
}
add_shortcode( 'dadicc-block-lite', 'dadicc_block_lite');