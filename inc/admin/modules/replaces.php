<?php
/**
 * @package: Dadi Cookie Consent Lite
 * Replaces
 */

if( ! defined( 'DADICC_ALLOW' ) ) {
    exit();
}

/**
 * Load replace module
 *
 */
function dadicc_get_module_replaces( $options ) { 
    
    $cookie_page_exists  = intval( $options['select_cookie_page'] ) > 0 ? '<code>{cookie_page}</code>' : '';
    $privacy_page_exists = '';
    $sep = '';
    if( dadicc_is_full_version() ) {
        $privacy_page_exists  = intval( $options['select_privacy_page'] ) > 0 ? '<code>{privacy_page}</code>' : '';
        if( $cookie_page_exists !== '' && $privacy_page_exists !== '' ) {
            $sep = ', ';
        }
    }
    $alias_available = ( $cookie_page_exists . $sep . $privacy_page_exists );
    if( $alias_available === '' ) {
        $alias_available = __('no alias available. Select almost once policy page.', DADICC_DOMAIN );
    }

    ?>
    
    <!-- Replace items -->

    <h3 class="legend"><?php esc_html_e('Replacing Action', DADICC_DOMAIN ); ?></h3>
    <p>
        <input type="checkbox" id="replace-instead-remove" name="dadicc_options[replace_instead_remove]" value="1" <?php checked( $options['replace_instead_remove'], 1 ); ?> />
        <label for="replace-instead-remove"><?php esc_html_e( 'Replace the removed items with a short custom message (only for visible elements)', DADICC_DOMAIN ); ?></label>
        <span class="dadicc-infos dashicons-before dashicons-info"><?php esc_html_e('If the replacement is not set, iframes will not be displayed.', DADICC_DOMAIN ); ?></span>
    </p>
    
    <!-- Box replace -->
    
    <h3 class="legend"><?php esc_html_e('Replacing Messages', DADICC_DOMAIN ); ?></h3>
    <p>
        <label for="replace-text"><?php esc_html_e('Main replacement message', DADICC_DOMAIN ); ?></label><br />
        <input type="text" id="replace-text" name="dadicc_options[replace_text]" value="<?php echo esc_attr( $options['replace_text']); ?>" /><br />
        <label for="replace-text-footer"><?php esc_html_e('Footer replacement "more info"', DADICC_DOMAIN ); ?></label><br />
        <input type="text" id="replace-text-footer" name="dadicc_options[replace_text_footer]" value="<?php echo esc_attr( $options['replace_text_footer']); ?>" /><br />
        <span class="dadicc-idea dashicons-before dashicons-lightbulb"><?php
            printf( esc_html__( 'Aliases available for "more info": %s', DADICC_DOMAIN ), $alias_available ); ?>
        </span>
    </p>
    
    
<?php }

add_action( 'dadicc_replaces_module', 'dadicc_get_module_replaces');

