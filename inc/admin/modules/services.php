<?php
/**
 * @package: Dadi Cookie Consent Lite
 * Consent Service Module
 */

/**
 * Module Service
 *
 */
function dadicc_get_module_services( $options ) { ?>
    
    <h3><?php esc_html_e('Services', DADICC_DOMAIN ); ?></h3>
    
    <p>
        <span class="dadicc-wrap-table-hide">
            <span class="dadicc-idea dashicons-before dashicons-lightbulb">
                <?php printf( esc_html__('For instruction %sclick here%s', DADICC_DOMAIN ), '<span class="dadicc-table-hide-button">', '</span>' ); ?>
            </span>
            <span class="dadicc-table-hide" style="display:none;">
            <?php esc_html_e('Define an ID Name (allowed lowercase letters, numbers, underscore). In targets iframe, you can enter iframe url, name id or class (without # or .) '
                    . 'or any other element useful to grab the iframe, separate by :: (double colons). '
                    . 'In buffer scripts, you can enter scripts url or any element (like a var name) useful to grab script, separate by :: (double colons). '
                    . 'If you create an anonymous service (without targets and scripts in the buffer), you will have to manage blocking and unlocking actions in the "Advanced" section or directly in the code '
                    . 'using apis available in api.php or shortcode.php. '
                    . 'For more info, see documentation.'
                    . '', DADICC_DOMAIN );
            ?>
            </span>
        </span>
    </p>
    
    <div class="clonable empty-form">
        <p>
            <span class="dadicc-infos dashicons-before dashicons-store dadicc-premium"><?php esc_html_e('Only premium version.', DADICC_DOMAIN ); ?></span>
        </p>
        <table width="100%">
                <tr>
                    <td colspan="2">
                        <label for="services-name"><?php esc_html_e( 'Service name', DADICC_DOMAIN ); ?></label><br />
                        <input style="width:40%;" type="text" name="" value="" disabled />
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="services-group">
                            <button type="button" class="button add-target buffer-iframe" disabled>
                                <span class="dashicons dashicons-editor-code"></span>
                                <?php esc_html_e('Add Iframe Targets', DADICC_DOMAIN ); ?>
                            </button>
                        </div>
                        <p class="service-area area-iframe" id="area-iframe-0">
                                <span class="no-service-yet"><?php esc_html_e('No services yet!', DADICC_DOMAIN ); ?></span>
                        </p>
                    </td>
                    <td>
                        <div class="services-group">
                            <button type="button" class="button add-target buffer-script" disabled>
                                <span class="dashicons dashicons-editor-code"></span>
                                <?php esc_html_e('Add Script Targets', DADICC_DOMAIN ); ?>
                            </button>
                        </div>
                        <p class="service-area area-iframe" id="area-script">
                                <span class="no-service-yet"><?php esc_html_e('No services yet!', DADICC_DOMAIN ); ?></span>
                        </p>
                    </td>
                </tr>
        </table>
    </div>
    
    <button type="button" class="button disabled"><?php printf( esc_html__('%s New Service', DADICC_DOMAIN ), '<span style="vertical-align:-5px;" class="dashicons dashicons-plus-alt"></span>' ); ?></button>
    
<?php }
add_action( 'dadicc_consent_service_module', 'dadicc_get_module_services' );