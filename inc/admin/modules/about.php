<?php
/**
 * @package: Dadi Cookie Consent Lite
 * About 
 */

function dadicc_module_about_table() { ?>
          
    <!-- Welcome -->

    <p>
        <span class="dadicc-thankyou-msg"><?php printf( esc_html__('Thank you for installing %s', DADICC_DOMAIN ), DADICC_PLUGIN_NAME ); ?></span>
    </p>

    <!-- What is it for -->

    <h3 class="legend"><?php esc_html_e('What is it for?', DADICC_DOMAIN ); ?></h3>
    <p>
        <?php printf( esc_html__('%s is a plugin that helps you to block scripts and content that may potentially generate invasive privacy cookies. 
The visitor will be shown an information banner with a link to accept the use of cookies.', DADICC_DOMAIN ), DADICC_PLUGIN_NAME ); ?>
    </p>

    <!-- Eu Cookie Law -->

    <h3 class="legend"><?php printf( esc_html__('%s, EU Cookie Law and GDPR', DADICC_DOMAIN ), DADICC_PLUGIN_NAME ); ?></h3>

    <p><?php printf( esc_html__('%s simply helps website ammministrator to block 
cookies and potentially invasive content of user privacy,
submitting the content to the prior consent, but it can not guarantee full compliance with the EU Cookie Law and GDPR. 
For this reason, constantly check that the website complies with the Eu and GDPR cookie law.
It is a task of the website administrator to make these legal checks.'), DADICC_PLUGIN_NAME ); ?>
    </p>

    <!-- Use -->

    <h3 class="legend"><?php esc_html_e('Simply to use', DADICC_DOMAIN ); ?></h3>
    <p>
        <?php printf( esc_html__('%s is easy to use and is customizable.', DADICC_DOMAIN ), DADICC_PLUGIN_NAME ); ?>
    </p>

    <!-- Author -->

    <h3 class="legend"><?php esc_html_e('Plugin Informations', DADICC_DOMAIN ); ?></h3>
    <p>
            <?php printf( esc_html__('Version: %s', DADICC_DOMAIN ), DADICC_VERSION ); ?>
        <br />
            <?php esc_html_e('Author: Il Jester', DADICC_DOMAIN ); ?>
        <br />
            <?php printf( esc_html__('Author Blog: %s', DADICC_DOMAIN ), '<a target="_blank" href="https://www.iljester.com/">Il Jester</a>' ); ?>
        <br />
            <?php printf( esc_html__('DCC Plugin Page: %s', DADICC_DOMAIN ), '<a target="_blank" href="https://www.iljester.com/portfolio/dadi-cookie-consent/">' . DADICC_PLUGIN_NAME . '</a>' ); ?>
        <br />
            <?php printf( esc_html__('Repository Wordpress%s: %s', DADICC_DOMAIN ), ( dadicc_is_full_version() ? '<span class="dadicc-asterisk">*</span>' : '' ), '<a target="_blank" href="https://wordpress.org/plugins/dadi-cookie-consent-lite/">' . DADICC_PLUGIN_NAME . '</a>' ); ?>
        <br />
            <?php printf( esc_html__('On Github%s: %s', DADICC_DOMAIN ), ( dadicc_is_full_version() ? '<span class="dadicc-asterisk">*</span>' : '' ), '<a target="_blank" href="https://github.com/iljester/dcc-lite">' . DADICC_PLUGIN_NAME . '</a>' ); ?>
        
        <?php if( dadicc_is_full_version() ) : ?>
        <span class="dadicc-note dashicons-before dashicons-admin-post"><?php esc_html_e('Only lite version', DADICC_DOMAIN ); ?></span>
        <?php endif; ?>
    </p>
    
    <?php if( (bool) dadicc_is_full_version() === true ) : ?>
    
    <!-- download -->
    
    <h3 class="legend"><?php esc_html_e('Get Dadi Cookie Consent Ext', DADICC_DOMAIN ); ?></h3>
    <form method="post" action="https://www.iljester.com/portfolio/dadi-cookie-consent/">
        <p>
            <label for="license-key"><?php esc_html_e('Insert your purchased license here:', DADICC_DOMAIN ); ?></label><br />
            <input type="text" id="license-key" name="license" value="" />
            <input type="hidden" name="ref" value="<?php echo esc_attr( base64_encode( home_url() ) ); ?>" />
        </p>
        <p>
            <input type="submit" class="button-primary" value="<?php echo esc_html_e('Download', DADICC_DOMAIN ); ?>" />
        </p>
    </form>
    
    <?php endif; ?>

    <!-- Warnings -->

    <h3 class="legend"><?php esc_html_e('Warnings', DADICC_DOMAIN ); ?></h3>
    <p>
        <?php printf( esc_html__('Always remember to back up the database regularly when using %s.', DADICC_DOMAIN ), DADICC_PLUGIN_NAME ); ?>
    </p>
    
<?php }

add_action( 'dadicc_about_table_module', 'dadicc_module_about_table' );