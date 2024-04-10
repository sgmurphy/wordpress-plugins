function cnb_setup_legacy() {
    // Option to Hide Icon is only visible when the full width button is selected
    const radioValue = jQuery("input[name='cnb[appearance]']:checked").val()
    const textValue = jQuery("input[name='cnb[text]']").val()

    if(radioValue !== 'full' && radioValue !== 'tfull') {
        jQuery('#hideIconTR').hide()
    } else if(textValue.length < 1) {
        jQuery('#hideIconTR').hide()
    }

    jQuery('input[name="cnb[appearance]"]').on("change",function(){
        const radioValue = jQuery("input[name='cnb[appearance]']:checked").val()
        const textValue = jQuery("input[name='cnb[text]']").val()
        if(radioValue !== 'full' && radioValue !== 'tfull') {
            jQuery('#hideIconTR').hide()
        } else if(textValue.length > 0 ) {
            jQuery('#hideIconTR').show()
        }
    })

    // JS for the SlideOver (only on small screens)    
    jQuery('aside').prepend('<div class="cnb-aside-background"></div>'); 
    // Injects slideover open button
    jQuery('form').after('<button id="cnb-open-aside" class="cnb-slide-over"><span style="transform: rotate(90deg); margin-top:4px" class="dashicons dashicons-unlock"></span> more features!</button>');
    // Injects slideover close button
    jQuery('.cnb-aside-body').prepend('<div class="cnb-close-button"><button id="cnb-close-aside"><span class="dashicons dashicons-no-alt"></span></button></div>');

    function closeAside() {
        jQuery('aside').removeClass('cnb-aside-open');
        setTimeout(function() {
            jQuery('.cnb-aside-background').css('inset', 'unset');
        }, 350);
    }
                            
    jQuery('#cnb-open-aside').click(function() {
        jQuery('aside').addClass('cnb-aside-open');
        jQuery('.cnb-aside-background').css('inset', '0');
    });
    
    jQuery('#cnb-close-aside').click(function() {
        closeAside();
    });
    
    // JS for the aside tabs (only on big screens)
    jQuery('.cnb-nav-aside').on('click', '.cnb-aside-tab', function(e) {
        e.preventDefault();

        if(jQuery(this).hasClass('cnb-aside-tab-active')) {
            return;
        }

        jQuery('.cnb-aside-tab').removeClass('cnb-aside-tab-active');
        jQuery(this).addClass('cnb-aside-tab-active');

        var tabName = jQuery(this).data('tab-name');
        jQuery('.cnb-content-aside-more, .cnb-content-aside-support').removeClass('cnb-content-aside-active');
        jQuery('.cnb-content-aside-' + tabName).addClass('cnb-content-aside-active');
    });
}

function cnb_setup_banner() {
    jQuery('.welcome-banner-content').slideUp()
    jQuery('#welcome-banner-notice').on("click",function() {
        jQuery('#welcome-banner-notice').remove()
        jQuery('.welcome-banner-content').slideToggle()
    })
}

jQuery( function() {
    cnb_setup_legacy()
    cnb_setup_banner()
})
