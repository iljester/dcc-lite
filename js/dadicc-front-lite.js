/**
 * @package: Dadi Cookie Consent Lite
 * Js Compilation for Dadi Cookie Consent Plugin
 *
 */

// cookie policy page
var pid_cookie_policy       = CookieConsentVars.CookiePidCookie;
var is_page_cookie_policy   = CookieConsentVars.CookieIsPageCookie;
var link_cookie_policy      = CookieConsentVars.CookiePageCookieLink;
var dadicc_global_ck        = CookieConsentVars.CookieGlobalCk;
var display_banner          = CookieConsentVars.CookieDisplayBanner;
var banners                 = CookieConsentVars.CookieBanners;
var url_site                = CookieConsentVars.CookieSite;
var url_plugin              = CookieConsentVars.CookiePlugin;
var ajaxurl                 = CookieConsentVars.CookieAjaxUrl;
var missing_content_alert   = CookieConsentVars.CookieAlertContent;
var cookie_life             = CookieConsentVars.CookieLife;
var block_class             = CookieConsentVars.CookieBlockClass;
var on_scroll               = CookieConsentVars.CookieOnScroll;
var on_nav                  = CookieConsentVars.CookieOnNav;
var msg_remove_consent      = CookieConsentVars.CookieMsgRemoveCons;
var msg_add_consent         = CookieConsentVars.CookieMsgAddCons;
var is_replace              = CookieConsentVars.CookieReplace;
var msg_replace             = CookieConsentVars.CookieMessageReplace;

/**
 * Check if cookie exists 
 *
 */
function dadiccIsCookieExists( name ) {
    
    var cookies = document.cookie.split(';');
    
    var cnames = new Array();
    for( var i = 0; i < cookies.length; i++ ) {
        var cookie = cookies[i].trim();
        var parts = cookie.split('=');
        cnames[i] = parts[0].trim();
    }
    
    if( cnames.indexOf(name) !== -1 ) {
        return true
    }
    return false;

}

/**
 * JQuery area
 *
 */
jQuery(function($) {

        /**
         * Remove p after insert box replace
         */
        $('.dadicc-msg-replace').each( function() {
            if( $(this).prev('p').is(':empty') ) {
                $(this).prev('p').remove();
            }

            if( $(this).next('p').is(':empty') ) {
                $(this).next('p').remove();
            }
        });

        /**
         * Append banner if global cookie consent not exists
         * or remove it if global cookie consent is generated
         */
        if( ! dadiccIsCookieExists( dadicc_global_ck ) ) {

            // no append cookie banner cookie policy page
            if( parseInt( is_page_cookie_policy ) === 0 ) {

                $('body').append(banners);

                $('#dadiccCookieAlertSmall .dadicc-more-info').click( function() {
                    $('#dadiccCookieAlert').slideToggle(400);
                    $('#dadiccCookieAlertSmall').addClass('dadicc-hide-small-banner');
                    if( $('#dadiccCookieAlertSmall').hasClass('dadicc-hide-small-banner') ) {
                        $('#dadiccCookieAlertSmall').fadeOut();
                    }
                });

                $('#dadiccCookieAlert .dadicc-hide').click( function() {
                    $('#dadiccCookieAlert').fadeOut();
                    $('#dadiccCookieAlertSmall').fadeIn();
                });

            }

        } else {

            /**
            * If we are on the Cookie Policy page, we hide the banner.
            * If we have generated the cookie global cookie consent we check the box on the Cookie Policy page (if it is present)
            */

            $('.dadicc-cookie-banner').remove();
            $('#dadicc_agree' ).prop( 'checked', true );

        } 

        /**********************************************************
         * 
         * ACTIONS
         * 
         *********************************************************/

        /**
         * Generate cookie "dadicc_agree" when you click on the "I agree" button in the banner
         */
        if( ! dadiccIsCookieExists( dadicc_global_ck ) ) {

            if( on_nav === 1 ) {
                var consent_class = '.dadicc-agree, a';
                var target = $(consent_class).not('a.read-policy');
            } else {
                var consent_class = '.dadicc-agree';
                var target = $(consent_class);
            }

            target.click(function() {

                $.post( 
                    ajaxurl,
                    { 
                        action: 'dadiccAjaxCookieAll',
                        current_cookie: dadicc_global_ck,
                        type: 'click',
                        checked: 1,
                        wp_nonce: $('#wp_nonce').val()
                    },
                    function(data, response) {

                        if( response === 'success' ) {
                            $('.dadicc-cookie-banner').remove();
                            location.reload(true);
                        } else {
                            console.log( data );
                        }

                    }
                );

            });

        }

        /**
         * Generate cookie global when you scroll the page
         * No GDPR
         */
        if( ! dadiccIsCookieExists( dadicc_global_ck ) && parseInt( on_scroll ) === 1 && parseInt( is_page_cookie_policy ) === 0 ) {
            $(window).on('mousewheel DOMMouseScroll', function(ev) {
                ev.preventDefault();
                
                $.post( 
                    ajaxurl,
                    { 
                        action: 'dadiccAjaxCookieAll',
                        current_cookie : dadicc_global_ck,
                        type: 'scroll',
                        checked: 1,
                        wp_nonce: $('#wp_nonce').val()
                    },
                    function(data, response) {

                        if( parseInt( data ) === 1 ) {
                            $('.dadicc-cookie-banner').remove();
                            location.reload(true);
                        } else {
                            console.log( data );
                        }

                    }
                );

            });
        }

        /**
         * Generate or remove the global cookie when we use the checkbox on the Cookie Policy page
         */
        $( document ).on( 'change', '#dadicc_agree', function() {

            var is_checked = 0;
            if( $(this).is(':checked') ) {
                is_checked = 1;
            }

            $.post( 
                ajaxurl,
                { 
                    action: 'dadiccAjaxCookieAll',
                    current_cookie : dadicc_global_ck,
                    type: 'checkbox',
                    checked: is_checked,
                    wp_nonce: $('#wp_nonce').val()
                },
                function(data, response) {

                    if( parseInt( data ) === 1 ) {
                        location.reload(true);
                    } else {
                        console.log( data );
                    }

                }
            );

        });


        /**
         * If Consent enalbe/disabled show popup
         */
        $("input.dadicc-show-popup").change(function() {
            if ( $(this).is(":checked") ) {
                $('body').append( '<div class="dadicc-enable-service">' + msg_add_consent + '</div>' );
                $('.dadicc-enable-service').fadeOut(5000);
                $('.dadicc-disable-service').remove();
            }
            else {
                $('body').append( '<div class="dadicc-disable-service">' + msg_remove_consent + '</div>' );
                $('.dadicc-disable-service').fadeOut(5000);
                $('.dadicc-enable-service').remove();
            }
        });

});