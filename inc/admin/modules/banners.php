<?php 
/**
 * @package: Dadi Cookie Consent Lite
 * Banners Module
 */

if( ! defined( 'DADICC_ALLOW' ) ) {
    exit();
}

/**
 * Load banners module
 *
 */
function dadicc_get_module_banners( $options, $options_admin ) { ?>

    <?php if( (bool) dadicc_is_premium_features() === true ) : 
        
        /**
         * Keep tabber opened
         */
        $banner_tabber = dadicc_kod('banner-1', 'banner-2');
        if( $options_admin['keep_open_dt'] === 'banner-2' ) {
           $banner_tabber = dadicc_kod('banner-2', 'banner-1');
        }
        
    ?>
    <div class="buttons-tab">
        <span class="tabber-button b<?php echo esc_attr( $banner_tabber['banner-1']['button'] ); ?>" data-open="banner-1"><?php esc_html_e( 'General Settings', 'dadit' ); ?></span>
        <span class="tabber-button b<?php echo esc_attr( $banner_tabber['banner-2']['button'] ); ?>" data-open="banner-2"><?php esc_html_e( 'Colors and Styles', 'dadit' ); ?></span>
    </div>

    <div class="tabber<?php echo esc_attr( $banner_tabber['banner-1']['tab'] ); ?>">
    <?php endif; ?>
        
    <!-- Display Banner -->

    <h3 class="legend"><?php esc_html_e( 'Show banners?', DADICC_DOMAIN ); ?></h3>  
    <p>
        <?php dadicc_display_premium_message( __('The premium version allows you to choose whether to display the small banner first, or the large banner, or just the big one.', DADICC_DOMAIN ) ); ?>
        <input type="checkbox" id="show-banners" name="dadicc_options[show_banners]" value="1" <?php echo checked( 1, $options['show_banners'] ); ?> />
        <label for="show-banners"><?php esc_html_e('Yes, show banners!', DADICC_DOMAIN ); ?></label>
    </p>

    <!-- Minimal Banner -->

    <h3 class="legend"><?php esc_html_e( 'Minimal banner', DADICC_DOMAIN ); ?></h3>
    <p>
        <label for="message-banner-small"><?php esc_html_e( 'Minimal banner text', DADICC_DOMAIN ); ?></label><br />
        <?php dadicc_display_premium_message( __('The premium version allows you to use this tags: bold, underline and italic.', DADICC_DOMAIN ) ); ?>
        <input type="text" id="message-banner-small" name="dadicc_options[message_banner_small]" value="<?php echo sanitize_text_field( stripslashes( $options['message_banner_small'] ) ); ?>" />
        <span class="dadicc-infos dashicons-before dashicons-info"><?php esc_html_e( 'The minimal banner will be shown by clicking on "X" (close)', DADICC_DOMAIN ); ?></span>
    </p>
    <p>
        <input type="checkbox" id="show-btc-mini-banner" name="dadicc_options[show_btc_mini_banner]" value="1" <?php checked( $options['show_btc_mini_banner'], 1 ); ?>>
        <label for="show-btc-mini-banner"><?php printf( esc_html__('Show the consent button in the minimal banner. %sCaution! It may not conform to the GDPR%s', DADICC_DOMAIN ), '<span class="required">', '</span>' ); ?> </label>
    </p>

    <!-- Extended Banner -->

    <h3 class="legend"><?php esc_html_e( 'Extended banner', DADICC_DOMAIN ); ?></h3>
    <p>
        <?php dadicc_display_premium_message( __('The premium version allows you to use wysiwyg editor.', DADICC_DOMAIN ) ); ?>
        <textarea name="dadicc_options[message_banner]" /><?php echo esc_textarea( $options['message_banner'] ); ?></textarea>
        <span class="dadicc-infos dashicons-before dashicons-info"><?php esc_html_e( 'The extended banner will be shown by clicking on "More Info"', DADICC_DOMAIN ); ?></span>

        <?php if( (bool) dadicc_is_premium_features() === true ) : ?>
        <?php dadicc_display_premium_message(); ?>
        <input type="checkbox" id="hide-footer-banner" class="dadicc-table-hide-check" name="" value="" disabled>
        <label for="hide-footer-banner"><?php esc_html_e('Hide the footer of the extended banner.', DADICC_DOMAIN ); ?> </label>
        <?php endif; ?>
    </p>

    <!-- Buttons Label -->

    <h3 class="legend"><?php esc_html_e( 'Buttons Labels', DADICC_DOMAIN ); ?></h3>
    <p>
        <?php dadicc_display_premium_message( __('Premium version allows you to set Privacy Policy Page.', DADICC_DOMAIN ) ); ?>
        <?php $button_labels = dadicc_buttons_label();

        if( dadicc_is_premium_features() === false ) {
            unset( $button_labels['button_privacy_policy'] );
        }

        foreach( $button_labels as $k => $v ) : ?>
            <?php if( $k === 'button_privacy_policy' ) : ?>
                <label for="<?php echo esc_attr( $k ); ?>" class="dadicc-premium"><?php echo wp_kses( $v['label'], array('span' => array( 'class' => array() ) ) ); ?></label><br />
                <input type="text" id="<?php echo esc_attr( $k ); ?>" style="width:25%" name="" value="<?php esc_html_e('Privacy Policy', DADICC_DOMAIN ); ?>" disabled /><br />
            <?php else : ?>
                <label for="<?php echo esc_attr( $k ); ?>"><?php echo wp_kses( $v['label'], array('span' => array( 'class' => array() ) ) ); ?></label><br />
                <input type="text" id="<?php echo esc_attr( $k ); ?>" style="width:25%" name="dadicc_options[<?php echo esc_attr( $k ); ?>]" value="<?php echo sanitize_text_field( stripslashes( $options[$k] ) ); ?>" /><br />
            <?php endif;
        endforeach; ?>
        <span class="dadicc-note dashicons-before dashicons-admin-post"><?php esc_html_e('The label of the cookie policy can also remain empty. It will be replaced by the title of the related page.', DADICC_DOMAIN ); ?></span>
    </p>

    <?php if( (bool) dadicc_is_premium_features() === true ) : ?>

    <!-- Vertical Banners Position -->

    <h3 class="legend"><?php esc_html_e('Vertical Banners Position', DADICC_DOMAIN ); ?></h3>
    <p>
        <?php dadicc_display_premium_message(); ?>
        <input type="checkbox" id="banners-inverse-position" name="" value="" disabled />
        <label for="banners-inverse-position"><?php esc_html_e('If checked, the extended banner will be placed in the footer and the minimal banner in the header', DADICC_DOMAIN ); ?></label>
    </p>

    <!-- Minimal Banner Horizontal Position -->

    <h3 class="legend"><?php esc_html_e( 'Horizontal positioning of the minimal banner', DADICC_DOMAIN ); ?></h3>
    <p>
        <?php dadicc_display_premium_message(); ?>
        <?php foreach( dadicc_minimal_banner_horizontal_position() as $k => $v ) : ?>
            <input type="radio" id="<?php echo esc_attr( $k ); ?>" name="" value="" <?php checked( $k, 'right' ); ?> disabled />
            <label for="<?php echo esc_attr( $k ); ?>"><?php echo wp_kses( $v, array('span' => array( 'class' => array() ) ) ); ?></label><br />
        <?php endforeach; ?>
        <span class="dadicc-note dashicons-before dashicons-admin-post"><?php esc_html_e('Only for modern browsers', DADICC_DOMAIN ); ?></span>
    </p>

    <?php endif; ?>

    <?php if( (bool) dadicc_is_premium_features() === false ) : ?>

    <!-- Background Color -->

    <h3 class="legend"><?php esc_html_e( 'Background Color', DADICC_DOMAIN ); ?></h3>
    <p>
        <label for="neutral-colors"><?php esc_html_e( 'Choose the background color', DADICC_DOMAIN ); ?></label><br />
        <select id="neutral-colors" name="dadicc_options[use_neutral_color]">
        <?php foreach( dadicc_banner_keep_neutral_bgcolor() as $k => $v ) : ?>
            <option value="<?php echo esc_attr( $k ); ?>" <?php selected( $options['use_neutral_color'], $k ); ?>><?php echo esc_html( $v ); ?></option>
        <?php endforeach; ?>
        </select>
    </p>

    <?php endif; ?>
    
    <?php if( (bool) dadicc_is_premium_features() === true ) : ?>
    </div><!-- /#tabber-1 -->
    
    <div class="tabber<?php echo esc_attr( $banner_tabber['banner-2']['tab'] ); ?>">
    
        <!-- Color Scheme -->

        <h3 class="legend"><?php esc_html_e('Color scheme', DADICC_DOMAIN ); ?></h3>
        <p>
            <label for="banner-style"><?php esc_html_e('Choose a color scheme', DADICC_DOMAIN ); ?></label><br />
            <?php dadicc_display_premium_message(); ?>
            <select id="banner-style" name="" disabled>
            <?php foreach( dadicc_banner_color_scheme() as $k => $v ) : ?>
                <option value=""><?php echo esc_html( $v ); ?></option>
            <?php endforeach; ?>
            </select>
        </p>

        <!-- Background Color -->

        <h3 class="legend"><?php esc_html_e( 'Background Color', DADICC_DOMAIN ); ?></h3>
        <p>
            <label for="neutral-colors"><?php esc_html_e( 'Choose the background color', DADICC_DOMAIN ); ?></label><br />
            <select id="neutral-colors" name="dadicc_options[use_neutral_color]">
            <?php foreach( dadicc_banner_keep_neutral_bgcolor() as $k => $v ) : ?>
                <option value="<?php echo esc_attr( $k ); ?>" <?php selected( $options['use_neutral_color'], $k ); ?>><?php echo esc_html( $v ); ?></option>
            <?php endforeach; ?>
            </select><br />
            <span class="dadicc-infos dashicons-before dashicons-info"><?php esc_html_e( 'If set to "Auto", the background color of the chosen color scheme will be used', DADICC_DOMAIN ); ?></span>
        </p>

        <!-- Semi-Transparency -->

        <h3 class="legend"><?php esc_html_e('Semi-Transparency', DADICC_DOMAIN ); ?></h3>
        <p>
            <?php dadicc_display_premium_message(); ?>
            <?php foreach( dadicc_background_transparent() as $k => $v ) : ?>
                <input type="checkbox" id="<?php echo esc_attr( $k ); ?>" name="" value="1" <?php echo ( $k === 'bg_small_tran' ? 'checked' : '' ); ?> disabled />
                <label for="<?php echo esc_attr( $k ); ?>"><?php echo esc_html( $v['label'] ); ?></label><br />
            <?php endforeach; ?>
        </p>
        
    </div><!-- /#tabber-2 -->
    
    <?php endif; ?>

<?php }

add_action( 'dadicc_banners_module', 'dadicc_get_module_banners', 10, 2 );
