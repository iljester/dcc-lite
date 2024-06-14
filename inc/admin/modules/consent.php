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
function dadicc_get_module_consent( $options ) {
    
    global $compatible_system_cache;
    
    ?>

    <!-- Global Consent Mode -->

    <h3 class="legend"><?php esc_html_e('Global Consent Mode', DADICC_DOMAIN ); ?></h3>                           
    <p><?php printf( esc_html__('Normally the user accepts by clicking on the button %s. It is possible to force the user to use the other forms of consent listed below.', DADICC_DOMAIN ), esc_html( $options['button_consent'] ) ); ?></p>
    <p>
        <?php dadicc_display_premium_message(); ?>
        <input type="checkbox" id="on-scroll" name="dadicc_options[on_scroll]" value="1" <?php checked( $options['on_scroll'], 1 ); ?>>
        <label for="on-scroll"><?php printf( esc_html__('It forces the user to accept also with the scroll of the page (javascript only). %sNo GDPR%s.', DADICC_DOMAIN ), '<span class="required">', '</span>' ); ?></label><br />
        <input type="checkbox" id="on-navigation" name="dadicc_options[on_navigation]" value="1" <?php checked( $options['on_navigation'], 1 ); ?>>
        <label for="on-navigation"><?php printf( esc_html__('It forces the user to accept also with the continuation of the navigation (javascript only). %sNo GDPR%s.', DADICC_DOMAIN ), '<span class="required">', '</span>' ); ?></label><br />
        <?php if( (bool) dadicc_is_premium_features() === true ) : ?>
        <input type="checkbox" id="on-close" name="" value="1" disabled>
        <label for="on-close" class="dadicc-premium"><?php printf( esc_html__('It forces the user to accept also with the close extended banner (only if is set "Show only the extended banner"). %sNo GDPR%s.', DADICC_DOMAIN ), '<span class="required">', '</span>' ); ?></label>
        <?php endif; ?>
    </p>   
    
    <?php if( (bool) dadicc_is_premium_features() === true ) : ?>
        
    <!-- Confirm Popup -->

    <h3 class="legend"><?php esc_html_e('Confirmation popup (only with explicit global consent and navigation)', DADICC_DOMAIN ); ?></h3>
    <p>

        <span class="dadicc-infos dashicons-before dashicons-store dadicc-premium"><?php esc_html_e('Only premium version.', DADICC_DOMAIN ); ?></span>
        <input type="checkbox" id="show-popup" name="" value="" disabled />
        <label for="show-popup"><?php printf( esc_html__('Show a confirmation popup when the user clicks on "%s" or on any link%s.'), esc_html( $options['button_consent'] ), '<span class="dadicc-asterisk">*</span>' ); ?></label><br />
        <span class="dadicc-note dashicons-before dashicons-admin-post"><?php esc_html_e( 'For all links, except explicit consent, only if the consent is active with the continuation of navigation.', DADICC_DOMAIN ); ?></span>
        
        <label for="message-popup"><?php esc_html_e( 'Popup Text', DADICC_DOMAIN ); ?></label><br />
        <span class="dadicc-infos dashicons-before dashicons-store dadicc-premium"><?php esc_html_e('Only premium version.', DADICC_DOMAIN ); ?></span>
        <input type="text" id="message-popup" name="" value="" disabled /><br />
        <span class="dadicc-idea dashicons-before dashicons-lightbulb"><?php printf( esc_html__( 'Available alias: %s.', DADICC_DOMAIN ), '<code>{consent}</code>' ); ?></span>
    </p>
    
    <?php endif; ?>
    
    <!-- Shortcode Global Consent -->

    <h3 class="legend"><?php esc_html_e('Shortcode Global Consent', DADICC_DOMAIN ); ?></h3>
    <p>
        <?php esc_html_e('Shortcode to show on the extended information page to allow the user to accept cookies from this page:', DADICC_DOMAIN ); ?><br />
        <code>[dadicc-consent-lite popup="false" label="I consent to the use of cookies"]</code>
        <span class="dadicc-idea dashicons-before dashicons-lightbulb"><?php esc_html_e('Use "label" attribute to set label. Use wrap="true" to display wrap around input consent. To display popup, use popup="true".', DADICC_DOMAIN ); ?></span>
    </p>
    
    <!-- Duration of consent -->
    
    <h3 class="legend"><?php esc_html_e('Duration of consent', DADICC_DOMAIN ); ?></h3>
    <p>
        <label for="cookie-life"><?php esc_html_e('Define the consent duration in days.', DADICC_DOMAIN ); ?></label><br />
        <input type="number" min="0" id="cookie-life" name="dadicc_options[cookie_life]" value="<?php echo sanitize_text_field( $options['cookie_life'] ); ?>" /><br />
        <span class="dadicc-infos dashicons-before dashicons-info"><?php esc_html_e('Once the indicated time has elapsed, the user must again consent to the use of cookies. Default: 30 (days). If set to 0, consent will be given until the user closes the browser (session cookies).', DADICC_DOMAIN ); ?></span>
    </p>
    
    <!-- Cache -->

    <h3 class="legend"><?php esc_html_e('Cache Settings', DADICC_DOMAIN ); ?></h3>
    
    <p>
        <?php dadicc_display_premium_message( __('Others Cache Systems compatibile with premium version: Fastest Cache, Cache Enabler and LiteSpeed Cache.', DADICC_DOMAIN ) ); ?>
        <?php printf( esc_html__('Compatible Cache Systems: %s.', DADICC_DOMAIN ), '<code>' . implode('</code>, <code>', $compatible_system_cache ) . '</code>' ); ?>
    </p>
    
    <?php
    /**
     * Displays messages for each cache system tested with DCC
     */
    do_action( 'dadicc_cache_message' ); ?>
    
    <p>
        <input type="checkbox" id="purge-cache" name="dadicc_options[purge_cache]" value="1" <?php checked( $options['purge_cache'], 1 ); ?>/>
        <label for="purge-cache"><?php printf( esc_html__('Clean up the cache when the user gives consent or removes it %s(recommended)%s.', DADICC_DOMAIN ), '<span class="recommended">', '</span>' ); ?></label>
    </p>
    
    <?php if( (bool) dadicc_is_premium_features() === true ) : ?>
    
    <!-- Ajax consent -->
    
    <h3 class="legend"><?php esc_html_e('Ajax Consent', DADICC_DOMAIN ); ?></h3>
    <p>
        <?php dadicc_display_premium_message( __('You can choose between ajax consent and ajax cleanup cache and reolad (cookies will be generated by javascript)', DADICC_DOMAIN ) ); ?>
        <input type="checkbox" id="ajax-consent" name="" value="1" checked disabled/>
        <label for="ajax-consent"><?php printf( esc_html__('Enable ajax consent %s(recommended)%s', DADICC_DOMAIN ), '<span class="recommended">', '</span>' ); ?></label><br />
        <span class="dadicc-infos dashicons-before dashicons-info"><?php printf( esc_html__('If ajax consent is disabled and cache cleanup is enabled, ajax will only be used to launch the cleanup action and to regenerate the page. '
                . 'if you want to completely remove ajax, you need to disable cache cleanup %s(not recommended)%s.', DADICC_DOMAIN ), '<span class="required">', '</span>' ); ?></span>
    </p>
    
    <?php endif; ?>

<?php }

add_action( 'dadicc_consent_module', 'dadicc_get_module_consent' );
