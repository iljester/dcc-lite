<?php
/**
 * @package: Dadi Cookie Consent Lite
 * Inizialize options and create options page
 */

if( ! defined( 'DADICC_ALLOW' ) ) {
    exit();
}

/**
 * Create Options Page
 *
 */
function dadicc_add_option_page() {
    add_menu_page(
        DADICC_PLUGIN_NAME_ABB,
        DADICC_PLUGIN_NAME_ABB,
        'administrator',
        'dadicc-options-page',
        'dadicc_the_form',
        'dashicons-welcome-view-site',
        82
    );
}
add_action('admin_menu', 'dadicc_add_option_page');

/**
 * Register page options
 *
 */
function dadicc_register_options_group() {
    register_setting(
        DADICC_OPT . '_group', 
        DADICC_OPT, 
        array( 'sanitize_callback' => 'dadicc_validate_options' )
    );
}
add_action ('admin_init', 'dadicc_register_options_group');

/**
 * Sanitize and validate options in page
 *
 */
function dadicc_validate_options( $input ) {
    
    $defaults   = dadicc_default_options();
	
    return apply_filters( 'dadicc_input', $input, $defaults );
	
}

/**
 * Register scripts
 *
 */
function dadicc_register_scripts() {
    
    if ( 'toplevel_page_dadicc-options-page' !== get_current_screen()->id ) {
        return;
    }
    
    wp_enqueue_style( DADICC_ADMIN_STYLE, dadicc_base_url( 'css/dadicc-admin.css' ) );
    wp_enqueue_script( DADICC_ADMIN_JS, dadicc_base_url( 'js/dadicc-admin.js' ), array('jquery'), false, true );
    
}
add_action('admin_enqueue_scripts', 'dadicc_register_scripts' );

/**
 * The form settings
 *
 */
function dadicc_the_form() {
    
    do_action( 'dadicc_the_form' );
    
}

/**
 * Enter here global scripts and styles
 * To use into and outside DCC Page
 *
 */
function dadicc_global_scripts_styles() {
?>
<style>
    .dadicc-update,
    .dadicc-error {
        position: relative;
        padding-right: 44px;
    }
    
    .dadicc-update, .dadicc-error p {
        font-size: 1.1em;
    }

    .dadicc-dismiss-this {
        position: absolute;
        top: 25%;
        right: 13px;
        border: 0;
        padding: 0;
        background-color: transparent;
        cursor: pointer;
    }
</style>

<script>
    jQuery(function($) {
        $('.dadicc-dismiss-this').click(function() {
            $(this).parent().fadeOut(400);
        });
    });
</script>
    
<?php }
add_action('admin_head', 'dadicc_global_scripts_styles');

/**
 * Setup Global Message
 *
 */
function dadicc_global_msg() {
    
    $nags = apply_filters('dadicc_global_msg', $nags = array() );
    $allowed = dadicc_allowed_tags();
    
    $defaults = array(
        'message' => '',
        'remove' => false
    );    
    
    $is_removible = '';
    $data_removible = '';
    $data_nonce = '';
    foreach( $nags as $k => $v ) : 
        
        $transient = $k . '_no_nag';
        
        if( absint( get_transient( $transient ) ) === 1 ) {
            
            continue;
            
        } else {
        
            $v = wp_parse_args( $v, $defaults );

            if( (bool) $v['remove'] === true ) {
                $is_removible = ' dadicc-is-removible';
                $data_removible = ' data-remove="' . esc_attr( $transient ) . '"';
                $data_nonce = ' data-nonce="' . esc_attr( wp_create_nonce( dadicc_build_nonce( dirname( __FILE__ ) ) ) ) . '"';
            }
            ?>

            <div class="notice notice-error dadicc-error">
                <p><?php echo wp_kses( $v['message'], $allowed ); ?></p>
                <button type="button" class="dadicc-dismiss-this<?php echo esc_attr( $is_removible ); ?>"<?php echo $data_removible . $data_nonce; ?>><span class="dashicons dashicons-dismiss"></span></button>
            </div><?php
        
        }
        
    endforeach;
    
}
add_action('admin_notices', 'dadicc_global_msg');

/**
 * Reset options
 *
 */
function dadicc_reset_settings_link() {
    
    $args = array(
        'page'  => 'dadicc-options-page', 
        'reset' => 'true'
    );
    
    $url = add_query_arg( $args, admin_url( 'admin.php' ) ); ?>
    <a id="reset-request" class="button-reset button" href="<?php echo esc_url( $url ); ?>"><?php esc_html_e('Reset Settings', DADICC_DOMAIN ); ?></a>
    
    <?php
}

/**
 * Add information for this plugin in the privacy policy
 *
 */
function dadicc_add_privacy_policy_content() {
    if ( ! function_exists( 'wp_add_privacy_policy_content' ) ) {
        return;
    }
    
    global $dadicc_options;
    
    $privacy_policy_id = (int) get_option( 'wp_page_for_privacy_policy' );
    
    $content  = sprintf( '%s', '<h3>' . esc_html__( DADICC_PLUGIN_NAME ) . '</h3>' );
    
    $content  .= esc_html__( 'You should include in your privacy policy (and cookie policy), the informations for Dadi Cookie Consent,
            and in particular, what is its purpose and the purpose of cookies that are used
            for its operation, underlining that the cookies of Dadi Cookie Consent do not save
            or use personal data of the user. The text below is only a example
            and may not be sufficient for legal purposes. For any clarification
            we suggest you ask for a professional legal opinion.',
            DADICC_DOMAIN
    );
    
    $content .= '<br /><br />';
 
    $content .= sprintf(
        __( '%1$sExample Text%2$s: "%3$sWhen you accept, clicking on "I agree" in the %4$s banners 
            and in the pages of the Privacy Policy and Cookie Policy, the system saves 
            cookies to remember your consent and allow you to view and use previously 
            blocked content that may generate invasive cookies for your privacy. 
            Dadi Cookie Consent cookies not contain personal data, but only the date of the consent and the word "true". No other information 
            is obtained through the aforementioned cookies. In any case, we do not use 
            the information for other purposes and these are not passed on to third parties.
            
        Cookie used:%8$s
        - %9$s (global consent);%8$s
 
        The %5$s privacy policy is <a href="%6$s">here</a>.%7$s"',
        DADICC_DOMAIN ),
        '<strong>',
        '</strong>',
        '<em>',
        DADICC_PLUGIN_NAME,
        get_bloginfo('name'),
        esc_url( get_permalink( $privacy_policy_id ) ),
        '</em>',
        '<br />',
        DADICC_GLOBAL_CK
    );
 
    wp_add_privacy_policy_content(
        DADICC_PLUGIN_NAME,
        wp_kses_post( wpautop( $content, false ) )
    );
}
add_action( 'admin_init', 'dadicc_add_privacy_policy_content' );

