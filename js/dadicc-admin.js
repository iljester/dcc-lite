/**
 * @package: Dadi Cookie Consent
 * Js Compilation for Dadi Cookie Consent Plugin Admin Side
 */

/**
 * Jquery area
 */
(function($) {
   
    $('.tabber').each( function(k, v) {
        var key = (k+1);
        $(this).attr('id', 'tabber-' + key );
    });
    
    $('.tabber-button').each( function( k, v ) {
        var key = (k+1);
        $(this).attr('data-tab', 'tabber-' + key );
        var arr = new Array();
        $(this).click(function() {

            $(this).closest('.tabbers').children('.tabber').removeClass('current-tabber');
            
            var dataTab = $(this).attr('data-tab');
            $(this).closest('.tabbers').children('#' + dataTab ).addClass('current-tabber');
            
            $(this).parent().children('.tabber-button').removeClass('current-button');
            $(this).addClass('current-button');
            
            var dataOpen = $(this).attr('data-open');
            
            $.post( 
                ajaxurl,
                { 
                    action: 'dadiccKeepOpenBoxDt',
                    data_open : dataOpen,
                    wp_nonce: $('#wp_nonce').val()
                },
                function(data, response) {
                    
                }
            );
           
        });
    });
    
    $('.button-primary').each( function() {
        $(this).click( function() {
            var data_id = $(this).attr('data-id');
            $('#keep-open-onsave').val(data_id);
        });
    });

    $('.head-box').click(function() {
        
        var this_box = $(this).next();
        var box_hide = $('.box-hide');
        var is_checked = $('.box-banner').is(':checked');

        if( box_hide.is(':visible') ) {
            box_hide.slideUp();
        }

        if( ! this_box.is(':visible') ) {
            this_box.slideDown();
        } else {
            $.post( 
                ajaxurl,
                { 
                    action: 'dadiccRemoveOpenBox',
                    remove : 1,
                    wp_nonce: $('#wp_nonce').val()
                },
                function(data, response) {
                    
                }
            );
        }

    });
    
    $('.dadicc-is-removible').each( function() {
        $(this).click(function() {
            $.post( 
                ajaxurl,
                { 
                    action: 'dadiccRemoveNotice',
                    notice_id : $(this).attr('data-remove'),
                    wp_nonce: $(this).attr('data-nonce')
                },
                function(data, response) {
					console.log(data);
                    $(this).parent().fadeOut(200).remove();
                }
            );
        });
        
    });
    
    $('.dadicc-table-hide-check').each( function() {
        $(this).change(function() {
            if( $(this).is(':checked') ) {
                $(this).parent().children('.dadicc-table-hide').slideDown(200).css('display', 'block');
            }
            else {
                $(this).parent().children('.dadicc-table-hide').slideUp(200);
            }
        });
    });
    
    $('.dadicc-table-hide-radio').each( function() {
        $(this).change(function() {
            if( $(this).is(':checked') && $(this).val() == $(this).parent().attr('data-table-hide') ) {
                $(this).parent().children('.dadicc-table-hide').slideDown(200).css('display', 'block');
            }
            else {
                $(this).parent().children('.dadicc-table-hide').slideUp(200);
            }
        });
    });
    
    $('.dadicc-table-hide-button').each( function() {
        $(this).click(function() {
            $(this).closest('.dadicc-wrap-table-hide').children('.dadicc-table-hide').slideToggle(200);
            if( $(this).closest('.dadicc-wrap-table-hide').children('.dadicc-table-hide').is(':visible') ) {
                $(this).closest('.dadicc-wrap-table-hide').children('.dadicc-table-hide').css('display', 'block');
            }
        });
    });
    
    $('#cookie-policy-url').change(function() {
        if( $(this).val() > 0 ) {
            $('.danger-cookie-policy-url').slideDown(200).css('display', 'block');
        } else {
            $('.danger-cookie-policy-url').slideUp(200);
        }
    });
    
    $('#reset-request').click(function(e) {
        e.preventDefault();
        $('#dadicc-reset-popup, .is-telo-popup').fadeIn();
    });
    
    $('#remove-iframes').change(function() {
        if( ! $(this).is(':checked') ) {
            $('#keep-frontend-iframes').prop('disabled', true );
        } else {
            $('#keep-frontend-iframes').prop('disabled', false );
        }

    });

    $('.dadicc-hide, .is-telo-popup').click(function() {
        $('#dadicc-reset-popup, .is-telo-popup').fadeOut();
    });

    $(document).on('click', '#dadicc-confirm-reset-yes', function() {
        $('.is-telo-popup .ajax-loader').fadeIn();
        $.post( 
            ajaxurl,
            { 
                action: 'dadiccResetAction',
                reset_action: 'true',
                wp_nonce: $('#wp_nonce').val()
            },
            function(data, response) {
                if( response == 'success' ) {
                    $('#dadicc-reset-popup, .is-telo-popup, .is-telo-popup .ajax-loader').fadeOut();
                    location.reload(true);
                } else {
                    console.log(data);
                }

            }
        );
    });
    
    $(document).on('click', '.display-premium-features', function() {
        var response = $(this).attr('data-value');
        $.post( 
            ajaxurl,
            { 
                action: 'dadiccShowPremiumFeatures',
                premium_features: response,
                wp_nonce: $('#wp_nonce').val()
            },
            function(data, response) {
                if( response == 'success' ) {
                    location.reload(true);
                } else {
                    console.log(data);
                }

            }
        );
    });
    
    $('#keep-all-options').change( function() {
        var value = $(this).is(':checked') ? 1 : 0;
        $('#kob-loader').css('display', 'initial');
        $('#kob-ok').css('display', 'none');
        $.post( 
            ajaxurl,
            { 
                action: 'dadiccKeepAllOptions',
                keep_all_options: value,
                wp_nonce: $('#wp_nonce').val()
            },
            function(data, response) {
                $('#kob-loader').css('display','none');
                $('#kob-ok').fadeIn().fadeOut(1000);
            }
        );
    });

})(jQuery);