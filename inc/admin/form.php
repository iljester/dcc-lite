<?php 
/**
 * @package: Dadi Cookie Consent Lite
 * The Form
 */

if( ! defined( 'DADICC_ALLOW' ) ) {
    exit();
}

/**
 * The form
 *
 */
function dadicc_get_the_form() {

    global $dadicc_options, $dadicc_options_admin;

    // general settings
    $defaults = dadicc_default_options();
    $options  = $dadicc_options;
    
    // admin settings
    $defaults_admin = dadicc_default_options_admin();
    $options_admin = $dadicc_options_admin; ?>

    <div id="dadicc-container" class="wrap">
        
        <!-- settings update -->
        
        <?php if( isset( $_GET['settings-updated'] ) ) : ?>
            <div class="notice notice-success dadicc-update">
                <p><?php esc_html_e('The settings have been updated successfully!', DADICC_DOMAIN ); ?></p>
                <button type="button" id="dadicc-update-msg-remove" class="dadicc-dismiss-this" data-cache="dadicc-reset-empty-cache"><span class="dashicons dashicons-dismiss"></span></button>
            </div>
        <?php endif; ?>
        
        <!-- update success purge cache -->
        
        <div class="notice notice-success dadicc-update update-purge-cache" style="display:none">
            <p><?php esc_html_e('The cache has been emptied!', DADICC_DOMAIN ); ?></p>
            <button type="button" class="dadicc-dismiss-this"><span class="dashicons dashicons-dismiss"></span></button>
        </div>
        
        <!-- cookie policy missing -->
        
        <?php if( intval( $options['select_cookie_page'] ) <= 0 ) : ?>
            <div class="notice notice-error dadicc-update">
                <p><?php esc_html_e('Remember to select a Cookie Policy Page!', DADICC_DOMAIN ); ?></p>
            </div>
        <?php endif; ?>
        
        <!-- The form -->

        <div class="icon32" id="icon-options-general"><br /></div>
        <h2 class="dadicc-title-settings"><span class="dashicons dashicons-welcome-view-site"></span> <?php echo esc_html( DADICC_PLUGIN_NAME ); ?></h2>
        <div class="dadicc-wrap-set-options">
            
            <form id="dadicc-form" method="post" action="options.php">
                    <?php settings_fields( DADICC_OPT . '_group'); ?>
                    <?php do_settings_sections( DADICC_OPT .'_group' ); ?>

                    <!-- Policies -->

                    <div class="wrap-options" id="wrap-options-1">
                        <h2 class="head-box"><span class="dashicons dashicons-info"></span><?php esc_html_e( 'Policies', DADICC_DOMAIN ); ?></h2>
                        <div class="box-option box-hide"<?php echo absint( $options_admin['keep_on_save'] ) === 1 ? ' style="display:block"' : ''; ?>>
                            <?php do_action('dadicc_policy_module', $options, $options_admin ); ?>
                            <!-- Save Options -->
                            <p class="dadicc-save-options">
                                <input type="submit" class="button-primary dadicc-submit" data-id="1" value="<?php esc_html_e( 'Save Settings', DADICC_DOMAIN ); ?>" />
                            </p>
                        </div>
                    </div>

                    <!-- Banners -->

                    <div class="wrap-options" id="wrap-options-2">
                        <h2 class="head-box"><span class="dashicons dashicons-testimonial"></span><?php esc_html_e( 'Banners', DADICC_DOMAIN ); ?></h2>
                        <div class="box-option box-hide tabbers"<?php echo absint( $options_admin['keep_on_save'] ) === 2 ? ' style="display:block"' : ''; ?>>
                            <?php do_action('dadicc_banners_module', $options, $options_admin ); ?>
                            <!-- Save Options -->
                            <p class="dadicc-save-options">
                                <input type="submit" class="button-primary dadicc-submit" data-id="2" value="<?php esc_html_e( 'Save Settings', DADICC_DOMAIN ); ?>" />
                            </p>
                        </div>
                    </div>

                    <!-- Block -->

                    <div class="wrap-options" id="wrap-options-3">
                        <h2 class="head-box"><span class="dashicons dashicons-shield block-actions"></span><?php esc_html_e( 'Blocking', DADICC_DOMAIN ); ?></h2>
                        <div class="box-option box-hide tabbers"<?php echo absint( $options_admin['keep_on_save'] ) === 3 ? ' style="display:block"' : ''; ?>>
                            <?php
                                
                                /**
                                 * Keep tabber opened
                                 */
                                $block_tabber = dadicc_kod('block-1', 'block-2');
                                if( $options_admin['keep_open_dt'] === 'block-2' ) {
                                    $block_tabber = dadicc_kod('block-2', 'block-1');
                                }
                                
                            ?>
                            <div class="buttons-tab">
                                <span class="tabber-button b<?php echo esc_attr( $block_tabber['block-1']['button'] ); ?>" data-open="block-1"><?php esc_html_e( 'Blocking Actions', 'dadit' ); ?></span>
                                <span class="tabber-button b<?php echo esc_attr( $block_tabber['block-2']['button'] ); ?>" data-open="block-2"><?php esc_html_e( 'Replaces', 'dadit' ); ?></span>
                            </div>
                            <div class="tabber<?php echo esc_attr( $block_tabber['block-1']['tab'] ); ?>">
                                <?php do_action( 'dadicc_block_php_module', $options, $options_admin ); ?>
                            </div>
                            <div class="tabber<?php echo esc_attr( $block_tabber['block-2']['tab'] ); ?>">
                                <?php do_action('dadicc_replaces_module', $options, $options_admin ); ?>
                            </div>
                            <!-- Save Options -->
                            <p class="dadicc-save-options">
                                <input type="submit" class="button-primary dadicc-submit" data-id="3 " value="<?php esc_html_e( 'Save Settings', DADICC_DOMAIN ); ?>" />
                            </p>
                        </div>
                    </div>

                    <!-- Consent -->

                    <div class="wrap-options" id="wrap-options-4">
                        <h2 class="head-box"><span class="dashicons dashicons-thumbs-up"></span><?php esc_html_e( 'Consent', DADICC_DOMAIN ); ?></h2>
                        <div class="box-option box-hide tabbers"<?php echo absint( $options_admin['keep_on_save'] ) === 4 ? ' style="display:block"' : ''; ?>>
                            
                            <?php if( (bool) dadicc_is_premium_features() === true || dadicc_is_full_version() === true  ) : 
                            
                                /**
                                 * Keep tabber opened
                                 */
                                $consent_tabber = dadicc_kod('consent-1', 'consent-2');
                                if( $options_admin['keep_open_dt'] === 'consent-2' ) {
                                    $consent_tabber = dadicc_kod('consent-2', 'consent-1');
                                }
                                
                            ?>
                            <div class="buttons-tab">
                                <span class="tabber-button b<?php echo esc_attr( $consent_tabber['consent-1']['button'] ); ?>" data-open="consent-1"><?php esc_html_e( 'General Settings', 'dadit' ); ?></span>
                                <span class="tabber-button b<?php echo esc_attr( $consent_tabber['consent-2']['button'] ); ?>" data-open="consent-2"><?php esc_html_e( 'Consent Services', 'dadit' ); ?></span>
                            </div>

                            <div class="tabber<?php echo esc_attr( $consent_tabber['consent-1']['tab'] ); ?>">
                                <?php do_action('dadicc_consent_module', $options, $options_admin ); ?>
                            </div>
                            <div class="tabber<?php echo esc_attr( $consent_tabber['consent-2']['tab'] ); ?>">
                                <?php do_action( 'dadicc_consent_service_module', $options, $options_admin ); ?>
                            </div>
                            
                            <?php else : 
                                 do_action('dadicc_consent_module', $options, $options_admin );
                            endif; ?>
                            
                            <!-- Save Options -->
                            <p class="dadicc-save-options">
                                <input type="submit" class="button-primary dadicc-submit" data-id="4" value="<?php esc_html_e( 'Save Settings', DADICC_DOMAIN ); ?>" />
                            </p>
                        </div>
                    </div>
                    
                    <?php if( (bool) dadicc_is_premium_features() === true || dadicc_is_full_version() === true ) : ?>
                    
                     <!-- Advanced -->
                    
                    <div class="wrap-options" id="wrap-options-5">
                        <h2 class="head-box"><span class="dashicons dashicons-editor-code"></span><?php esc_html_e( 'Advanced', DADICC_DOMAIN ); ?></h2>
                        <div class="box-option box-hide"<?php echo absint( $options_admin['keep_on_save'] ) === 5 ? ' style="display:block"' : ''; ?>>
                            <?php do_action('dadicc_advanced_module', $options, $options_admin ); ?>
                            <!-- Save Options -->
                            <p class="dadicc-save-options">
                                <input type="submit" class="button-primary dadicc-submit" data-id="5" value="<?php esc_html_e( 'Save Settings', DADICC_DOMAIN ); ?>" />
                            </p>
                        </div>
                    </div>
                    
                    <!-- No script -->

                    <div class="wrap-options" id="wrap-options-6">
                        <h2 class="head-box"><span class="dashicons dashicons-warning"></span><?php esc_html_e( 'Noscript', DADICC_DOMAIN ); ?></h2>
                        <div class="box-option box-hide"<?php echo absint( $options_admin['keep_on_save'] ) === 6 ? ' style="display:block"' : ''; ?>>
                            <?php do_action('dadicc_noscript_module', $options, $options_admin ); ?>
                            <!-- Save Options -->
                            <p class="dadicc-save-options">
                                <input type="submit" class="button-primary dadicc-submit" data-id="6" value="<?php esc_html_e( 'Save Settings', DADICC_DOMAIN ); ?>" />
                            </p>
                        </div>
                    </div>
                    
                    <?php endif; ?>
                    
                    <input type="hidden" id="keep-open-onsave" name="dadicc_options[keep_on_save]" value="0" />
                    <input type="hidden" name="dadicc_options[empty_cache_onsave]" value="1" />
            
            </form>
            
            <hr />

            <div class="dadicc-internal-actions">
                
                <?php wp_nonce_field( dadicc_build_nonce( dirname( __FILE__ ) ), 'wp_nonce' ); ?>
                
                <!-- Internal Actions -->
                
                <div class="wrap-options dadicc-wrap-internal-actions" id="wrap-options-7">
                    <h2 class="head-box"><span class="dashicons dashicons-admin-settings"></span><?php esc_html_e( 'Settings', DADICC_DOMAIN ); ?></h2>
                    <div class="box-option box-hide box-actions">
                        <?php do_action( 'dadicc_internal_settings_module', $options, $options_admin ); ?>
                    </div>
                </div>
                
                <?php if( ! dadicc_is_full_version() ) : ?>
                
                <div class="wrap-options dadicc-premium-version" id="wrap-options-8">
                    <h2 class="head-box"><span class="dashicons dashicons-cart"></span><?php esc_html_e( 'Premium', DADICC_DOMAIN ); ?></h2>
                    <div class="box-option box-hide box-actions">
                        <?php do_action('dadicc_premium_table_module', $options, $options_admin );  ?>
                    </div>
                </div>
                
                <?php endif; ?>
                
                <div class="wrap-options dadicc-credits" id="wrap-options-8">
                    <h2 class="head-box"><span class="dashicons dashicons-universal-access"></span><?php esc_html_e( 'About', DADICC_DOMAIN ); ?></h2>
                    <div class="box-option box-hide box-actions">
                        <?php do_action('dadicc_about_table_module', $options, $options_admin );  ?>
                    </div>
                </div>

            </div>
            
        </div><!-- /.dadicc-wrap-set-options -->
        
        <div class="support-rate-box">
            <div class="wrap-gp">
                <?php do_action('dadicc_sticky_admin_module_bar', $options, $options_admin ); ?>
            </div>
        </div>

    </div><!-- /#dadicc-container -->

<?php }

add_action( 'dadicc_the_form', 'dadicc_get_the_form' );
