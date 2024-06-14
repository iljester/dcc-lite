<?php
/**
 * @package: Dadi Cookie Consent Lite
 * Consent Module
 */

if( ! defined( 'DADICC_ALLOW' ) ) {
    exit();
}

/**
 * load consent module
 *
 */
function dadicc_get_module_advanced( $options ) {
    
    ?>
    <!-- customize javascript -->
    
    <h3 class="legend"><?php esc_html_e('Custom Javascript', DADICC_DOMAIN ); ?></h3>
    <p>
        <?php dadicc_display_premium_message(); ?>
        <label for="dadicc-custom-js-disabled"><?php printf( esc_html__( 'Enter your custom javascript code here (without %s) to perform events on blocking actions or bypass blocking.', DADICC_DOMAIN ), '<code>' . esc_html( '<script></script>' ) . '</code>' ); ?></label><br />
        <textarea id="dadicc-custom-js" name="" disabled></textarea>
        <span class="dadicc-idea dashicons-before dashicons-lightbulb">
            <?php esc_html_e('For usage, see documentation in official blog.', DADICC_DOMAIN ); ?>
        </span>
    </p>
    
    <!-- customize javascript in header -->
    
    <h3 class="legend"><?php esc_html_e( 'Custom Javascript in Head', DADICC_DOMAIN ); ?></h3>
    <p>
        <?php dadicc_display_premium_message(); ?>
        <label for="custom-block-header"><?php printf( esc_html__('Enter your content in head (like javascript) and create your block action, using the shortcode %s, or bypass blocking using the shortcode %s', DADICC_DOMAIN ), '<code>[dadicc-html]</code>', '<code>[dadicc-bypass]</code>' ); ?></label><br />
        <textarea id="head-block-disabled" name="" disabled></textarea>
        <span class="dadicc-idea dashicons-before dashicons-lightbulb">
            <?php esc_html_e('For usage, see documentation in official blog.', DADICC_DOMAIN ); ?>
        </span>
    </p>
    
    <!-- customize javascript in footer -->
    
    <h3 class="legend"><?php esc_html_e( 'Custom Javascript in Footer', DADICC_DOMAIN ); ?></h3>
    <p>
        <?php dadicc_display_premium_message(); ?>
        <label for="custom-block-header"><?php printf( esc_html__('Enter your inline content, append in footer and create your block action, using the shortcode %s, or bypass blocking using the shortcode %s', DADICC_DOMAIN ), '<code>[dadicc-html]</code>', '<code>[dadicc-bypass]</code>' ); ?></label><br />
        <textarea id="footer-block-disabled" name="" disabled></textarea>
        <span class="dadicc-idea dashicons-before dashicons-lightbulb">
            <?php esc_html_e('For usage, see documentation in official blog.', DADICC_DOMAIN ); ?>
        </span>
    </p>
    <?php
    

}

add_action( 'dadicc_advanced_module', 'dadicc_get_module_advanced' );