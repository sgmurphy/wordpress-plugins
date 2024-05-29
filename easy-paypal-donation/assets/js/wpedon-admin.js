(function( $ ) {
    'use strict';
    $( function() {
        $('.wpedon-stripe-connect-notice, .wpedon-ppcp-connect-notice').on('click', '.notice-dismiss', function(){
            const $notice = $(this).parent('.notice.is-dismissible');
            const dismiss_url = $notice.attr('data-dismiss-url');
            if (dismiss_url) {
                $.get(dismiss_url);
            }
        });

        $('#wpedon-stripe-connect-table').on('change', 'input[name="mode_stripe"]', function(){
            const val = parseInt($(this).val());
            if (val !== 1 && val !== 2) return false;

            $('#stripe-connection-status-html').css({'opacity': 0.5});
            $.post(wpedon.ajaxUrl, {
                action: 'wpedon_stripe_connect_mode_change',
                nonce: wpedon.nonce,
                val: val
            }, function(response){
                if (response.data.statusHtml) {
                    $('#stripe-connection-status-html').html(response.data.statusHtml).css({'opacity': 1});
                }
            });
        });

        $('.wpedon-product-connection-row').on('change', '[name="mode_stripe"]', function(){
            const button_id = parseInt($(this).parents('.wpedon-product-connection-row').attr('data-id'));

            let val = parseInt($(this).val());
            if (val !== 1 && val !== 2) {
                val = 0;
            }

            $('#stripe-connection-status-html').css({'opacity': 0.5});
            $.post(wpedon.ajaxUrl, {
                action: 'wpedon_stripe_connect_mode_change',
                nonce: wpedon.nonce,
                val: val,
                button_id: button_id
            }, function(response){
                if (response.data.statusHtml) {
                    $('#stripe-connection-status-html').html(response.data.statusHtml).css({'opacity': 1});
                }
            });
        });

        function setOnboardingUrl() {
            const country = $('#wpedon-ppcp-country').val(),
                acceptCards = $('#wpedon-ppcp-accept-cards').is(':checked'),
                sandbox = $('#wpedon-ppcp-sandbox').is(':checked'),
                $onboardingStartBtn = $('#wpedon-ppcp-onboarding-start-btn'),
                onboardingUrl = $onboardingStartBtn.attr('href').split('?'),
                onboardingParams = new URLSearchParams(onboardingUrl[1] || ''),
                $paypalMode = $('.wpedon-paypal-mode [name="mode"]');

            onboardingParams.set('country', country);

            if (acceptCards) {
                onboardingParams.set('accept-cards', '1');
            } else {
                onboardingParams.delete('accept-cards');
            }

            if (sandbox) {
                onboardingParams.set('sandbox', '1');
            } else {
                onboardingParams.delete('sandbox');
            }

            $paypalMode.filter('[value="1"]').prop('checked', sandbox);
            $paypalMode.filter('[value="2"]').prop('checked', !sandbox);

            onboardingUrl[1] = onboardingParams.toString();
            $onboardingStartBtn.attr('href', onboardingUrl.join('?'));
        }
        $(document).on('mousedown touchstart', '.wpedon-ppcp-onboarding-start', function(){
            $('#wpedon-ppcp-sandbox').prop('checked', $(this).attr('data-connect-mode') === 'sandbox');
            setOnboardingUrl();
        });
        $(document).on('change', '#wpedon-ppcp-country', function(){
            const val = $(this).val(),
              $acceptCardsInput = $('#wpedon-ppcp-accept-cards'),
              $acceptCardsLabel = $acceptCardsInput.parents('label');

            if (val === 'other') {
                $acceptCardsInput
                  .attr('disabled', 'disabled')
                  .prop('checked', false).change();
                $acceptCardsLabel
                  .addClass('wpedon-ppcp-disabled')
                  .attr('title', $acceptCardsLabel.attr('data-title'));
            } else {
                $acceptCardsInput.removeAttr('disabled');
                $acceptCardsLabel.removeClass('wpedon-ppcp-disabled').removeClass('title');
            }

            setOnboardingUrl();
        });
        $(document).on('change', '#wpedon-ppcp-accept-cards, #wpedon-ppcp-sandbox', function(){
            setOnboardingUrl();
        });
        $(document).on('change', '#wpedon-ppcp-sandbox', function(){
            const mode = $(this).is(':checked') ? 'sandbox' : 'live';
            $('.wpedon-ppcp-button.wpedon-ppcp-onboarding-start').attr('data-connect-mode', mode);
        });
        $(document).on('click', '#wpedon-ppcp-onboarding-start-btn, #wpedon-ppcp-setup-account-close-btn', function(e){
            $(this).parents('#TB_window').find('#TB_closeWindowButton').click();
        });

        $(document).on('click', '#wpedon-ppcp-disconnect', function(e){
            e.preventDefault();

            if (!confirm('Are you sure?')) return false;

            const $this = $(this),
              $ppcpStatusTable = $('#wpedon-ppcp-status-table');

            if ($this.hasClass('processing')) return false;
            $this.addClass('processing');

            $ppcpStatusTable.css({'opacity': 0.5});

            $.post(wpedon.ajaxUrl, {
                action: 'wpedon-ppcp-disconnect',
                nonce: wpedon.nonce,
                button_id: $(this).attr('data-button-id')
            }, function(response) {
                $this.removeClass('processing');
                $ppcpStatusTable.css({'opacity': 1});

                if (response.success) {
                    $ppcpStatusTable.html(response.data.statusHtml);
                } else {
                    const message = response.data && response.data.message ?
                      response.data.message :
                      'An unexpected error occurred. Please reload the page and try again.';
                    alert(message);
                }
            });

            return false;
        });
    });

    $('.wpedon-paypal-mode').on('change', '[name="mode"]', function(){
        let mode = $(this).val() == 1 ? 'sandbox' : ($(this).val() == 2 ? 'live' : $('.wpedon-ppcp-onboarding-start').attr('data-connect-mode-default'));
        $('.wpedon-ppcp-button.wpedon-ppcp-onboarding-start').attr('data-connect-mode', mode);
    });

    /* PayPal order refund */
    $(document).on('click', '#wpedon-free-paypal-order-refund', function(e) {
        e.preventDefault();

        const $btn = $(this),
            $spinner = $btn.siblings('.spinner'),
            $message = $('#wpedon-free-message');

        if ($btn.is('[disabled]') || $spinner.is('.is-active')) {
            return false;
        }
        $spinner.addClass('is-active');

        $.post(wpedon.ajaxUrl, {
            action: 'wpedon-free-ppcp-order-refund',
            nonce: wpedon.nonce,
            order_id: wpedon.order_id
        }, function(response) {
            if (response.success) {
                $message.html("<div class='updated'><p>" + response.data.message + "</p></div>");
                $('#wpedon-free-order-status').html('Refunded');
                $btn.attr('disabled', 'disabled');
            } else {
                const message = response.data && response.data.message ?
                    response.data.message :
                    'An unexpected error occurred. Please reload the page and try again.';
                $message.html("<div class='error'><p>" + message + "</p></div>");
            }
        }).fail(function() {
            $message.html("<div class='error'><p>An unexpected error occurred. Please reload the page and try again.</p></div>");
        }).always(function() {
            $spinner.removeClass('is-active');
        });

        return false;
    });

    $('[name="wpedon_button_price_type"]').on('change', function() {
        $('#wpedon-amount-label').toggle($('[name="wpedon_button_price_type"]:checked').val() === 'manual');
    });
})(jQuery);