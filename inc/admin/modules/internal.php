<?php 
/**
 * @package: Dadi Cookie Consent Lite
 * Internal settings
 */

function dadicc_module_internal_settings( $options, $options_admin ) { ?>

    <?php if( (bool) dadicc_is_premium_features() === true ) : ?>

    <!-- Export Settings -->

    <h3 class="legend"><?php esc_html_e('Export Settings', DADICC_DOMAIN ); ?></h3>
    <p> 
        <span class="dadicc-infos dashicons-before dashicons-store dadicc-premium"><?php esc_html_e('Only premium version.', DADICC_DOMAIN ); ?></span>
        <input class="button primary-button disabled" type="submit" value="<?php esc_html_e( 'Export Data', DADICC_DOMAIN ); ?>" />
        <span class="dadicc-infos dashicons-before dashicons-info">
            <?php esc_html_e('Data settings will be export in xml format.', DADICC_DOMAIN ); ?>
        </span>
    </p>
    
    <!-- Import Settings -->

    <h3 class="legend"><?php esc_html_e('Import Settings', DADICC_DOMAIN ); ?></h3>
    <p>
        <span class="dadicc-infos dashicons-before dashicons-store dadicc-premium"><?php esc_html_e('Only premium version.', DADICC_DOMAIN ); ?></span>
        <input type="file" id="import-dcc-data" name="" value="<?php esc_html( 'Upload File', DADICC_DOMAIN ); ?>" disabled />
    </p>
    <p>
        <input class="button primary-button disabled" type="submit" value="<?php esc_html_e( 'Import Data', DADICC_DOMAIN ); ?>" />
        <span class="dadicc-infos dashicons-before dashicons-info recommended">
            <?php esc_html_e('Old values will be overwrite.', DADICC_DOMAIN ); ?>
        </span>
    </p>
    
    <?php endif; ?>
    
    <!-- Reset Settings -->

    <h3 class="legend"><?php esc_html_e('Reset Settings', DADICC_DOMAIN ); ?></h3>
    <p>
        <?php dadicc_reset_settings_link(); ?>
        <span class="dadicc-infos dashicons-before dashicons-info required">
            <?php esc_html_e('The action will reset the values and set them to default.', DADICC_DOMAIN ); ?>
        </span>
    </p> 
    <div id="dadicc-reset-popup" style="display:none;">
        <div class="dadicc-popup-container">
            <span class="dadicc-close dadicc-hide"><span class="dashicons dashicons-no-alt"></span></span>
            <p><?php esc_html_e('Confirm reset?', DADICC_DOMAIN ); ?><span id="dadicc-confirm-reset-yes"><?php esc_html_e('Yes', DADICC_DOMAIN ); ?></span></p>
        </div>
    </div>
    <div class="is-telo-popup" style="display:none;">
        <span class="ajax-loader"><img src="<?php echo esc_url( dadicc_base_url('css/images/ajax-loader.gif') ); ?>" /></span>
    </div>
    
    <!-- Keep All Options -->
    
    <h3 class="legend"><?php esc_html_e('Keep Settings', DADICC_DOMAIN ); ?></h3>
    <p>
        <input type="checkbox" id="keep-all-options" name="" value="1" <?php checked( 1, $options_admin['keep_all_options'] ); ?> />
        <label for="keep-all-options"><?php esc_html_e( 'Keep all settings if uninstall plugin', DADICC_DOMAIN ); ?></label>
        <img  class="mini-loader" id="kob-loader" src="<?php echo esc_url( dadicc_base_url( 'css/images/mini-loader.gif') ); ?>" />
        <span id="kob-ok" class="dashicons dashicons-yes dadicc-green"></span>
    </p>
    
<?php }

add_action( 'dadicc_internal_settings_module', 'dadicc_module_internal_settings', 10, 2 );