<?php 
/**
 * @package: Dadi Cookie Consent Lite
 * No script actions
 */

if( ! defined( 'DADICC_ALLOW' ) ) {
    exit();
}

/**
 * load no script module
 *
 */
function dadicc_get_module_noscript( $options ) { ?>

    <!-- No Script -->
    
    <h3 class="legend"><?php esc_html_e('Activate Dadi Cookie Consent No Script', DADICC_DOMAIN ); ?></h3>
    <p>
        <?php dadicc_display_premium_message(); ?>
        <input type="checkbox" id="dcc-no-script" name="" value="1" disabled/>
        <label for="dcc-no-script"><?php esc_html_e('Try to use Dadi Cookie Consent even when Javascript is disabled.', DADICC_DOMAIN ); ?></label><br />
        <span class="dadicc-infos dashicons-before dashicons-info"><?php esc_html_e('Please therefore set it properly or use stand alone function to block scripts, otherwise the block can be completely ineffective.', DADICC_DOMAIN ); ?></span>
    </p>
    
    <!-- No Script Alert -->
    
    <h3 class="legend"><?php esc_html_e('No Javascript Message', DADICC_DOMAIN ); ?></h3>
    <p>
        <?php dadicc_display_premium_message(); ?>
        <input type="checkbox" id="js-msg-disabled" name="" value="" disabled/>
        <label for="js-msg-disabled"><?php printf( esc_html__('Displays the message that warns the user that javascript is disabled %s(recommended)%s.', DADICC_DOMAIN ), '<span class="recommended">', '</span>' ); ?></label>
    </p>
    <p>
        <?php dadicc_display_premium_message(); ?>
        <label for="text-js-disabled"><?php esc_html_e('Customized message.', DADICC_DOMAIN ); ?></label><br />
        <input type="text" id="text-js-disabled" name="" value="" disabled/><br />
        <span class="dadicc-idea dashicons-before dashicons-lightbulb"><?php printf( esc_html__('Available Alias: %s.', DADICC_DOMAIN ), '<code>{site_name}</code>' ); ?></span>
    </p>
    
<?php }

add_action( 'dadicc_noscript_module', 'dadicc_get_module_noscript' );
