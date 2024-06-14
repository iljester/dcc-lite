<?php
/**
 * @package: Dadi Cookie Consent Lite
 * Premium box module
 */

function dadicc_module_premium_table() { 
    
    if( (bool) dadicc_is_premium_features() === true ) {
        $pf_args = array( 'data-value' => 0, 'label' => __('Hide Premium Features'), 'dashicons' => 'hidden' );
    } else {
        $pf_args = array( 'data-value' => 1, 'label' => __('Show Premium Features'), 'dashicons' => 'visibility' );   
    }
    
    ?>

    <h3 class="legend">Premium Version</h3>
    <p>
        <?php echo esc_html__('Extend the functionality of DCC Lite, by purchasing the premium version.', DADICC_DOMAIN ); ?>
    </p>
    <p>
        <button class="display-premium-features button" data-value="<?php echo esc_attr( $pf_args['data-value']); ?>" type="button">
            <span style="vertical-align:-5px;" class="dashicons dashicons-<?php echo esc_attr( $pf_args['dashicons'] ); ?>"></span>&nbsp;&nbsp;
            <?php echo esc_html( $pf_args['label'] ); ?>
        </button>
    </p>
    <p>
        <?php echo esc_html_e('The premium version is currently under development. For further information, contact the author.'); ?>
    </p>

<?php }

add_action( 'dadicc_premium_table_module', 'dadicc_module_premium_table' ); ?>
