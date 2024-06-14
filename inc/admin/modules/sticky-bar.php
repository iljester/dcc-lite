<?php 
/**
 * @package: Dadi Cookie Consent Lite
 * Sticky Bar 
 */

function dadicc_get_module_sticky_bar() { ?>

    <h3 class="legend"><?php esc_html_e('Rate Plugin', DADICC_DOMAIN ); ?></h3>
    <p>
        <span class="dashicons dashicons-star-filled" style="color: gold;"></span>
        <span class="dashicons dashicons-star-filled" style="color: gold;"></span>
        <span class="dashicons dashicons-star-filled" style="color: gold;"></span>
        <span class="dashicons dashicons-star-filled" style="color: gold;"></span>
        <span class="dashicons dashicons-star-filled" style="color: gold;"></span>
    </p>
    <p>
        <?php printf( esc_html__('Rate this plugin: %s.', DADICC_DOMAIN ), '<a href="https://wordpress.org/plugins/dadi-cookie-consent-lite/">' . DADICC_PLUGIN_NAME . '</a>' ); ?>
    </p>
    <h3 class="legend"><?php esc_html_e('Need Support?', DADICC_DOMAIN ); ?></h3>
    <p>
        <?php printf( esc_html__('You can create a ticket in the %s.', DADICC_DOMAIN ), '<a href="https://wordpress.org/support/plugin/dadi-cookie-consent-lite/">support forum</a>' ); ?>
    </p>
                
<?php } 

add_action( 'dadicc_sticky_admin_module_bar', 'dadicc_get_module_sticky_bar' );
