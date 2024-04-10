/*globals jQuery */

/**
 * This function reveals any stored link tokens and will reveal new fields when the button is clicked.
 */
function cnb_action_edit_legal_1() {
    const divs = ['#cnb-legal-link01', '#cnb-legal-link02', '#cnb-legal-link03']; // IDs of the divs

    function showDivIfInputHasValue(divId) {
        const $div = jQuery(divId);
        const $inputs = $div.find('input'); // Assuming only input fields for simplicity
        let showDiv = false;

        $inputs.each(function() {
            if (jQuery(this).val() !== '') {
                showDiv = true;
            }
        });

        if (showDiv) {
            $div.show();
        }
    }

    // Initially show divs that have input with values
    jQuery.each(divs, function(index, divId) {
        showDivIfInputHasValue(divId);
    });

    jQuery('#toggleButton').click(function() {
        let allDivsVisible = true;

        jQuery.each(divs, function(index, divId) {
            const $div = jQuery(divId);
            if ($div.is(':hidden')) {
                $div.show(); // Show the next hidden div
                allDivsVisible = false; // Since we found a hidden div, not all divs are visible
                return false; // Break the loop after showing one div
            }
        });

        // If all divs are visible after the click, hide the button
        if (allDivsVisible) {
            jQuery(this).hide();
        }
    });
}

/**
 * This function hides or reveals the legal consent message based on the consent toggle.
 */
function cnb_action_edit_legal_2() {
    jQuery('#cnb-action-chat-legal-enabled').change(function() {
        if(jQuery(this).is(':checked')) {
            jQuery('.cnb-chat-legal-input').show();
        } else {
            jQuery('.cnb-chat-legal-input').hide();
        }
    });
}

function cnb_action_edit_legal_3() {
    // When the read-only textarea is clicked
    jQuery('.cnb-legal-token').click(function() {
        // Get the text from the read-only textarea
        const textToAppend = jQuery(this).val();

        const $targetTextarea = jQuery('#cnb_legal_consent_message');

        // Get the current value of the target textarea
        const currentVal = jQuery($targetTextarea).val();

        // Append the text from the read-only textarea to the target textarea
        jQuery($targetTextarea).val(currentVal + textToAppend);

        // Focus on the target textarea and place the cursor at the end
        $targetTextarea.focus();

        // Modern browsers support setting selection range for textarea to place cursor at the end
        const textLength = $targetTextarea.val().length;
        $targetTextarea[0].setSelectionRange(textLength, textLength);

        // Show tooltip near the textarea
        const $tooltip = jQuery('#cnb-Tooltip');
        $tooltip.css({
            display: 'block'
        });

        // Hide the tooltip after 2 seconds
        setTimeout(function() {
            $tooltip.hide();
        }, 2000);
    });
}

jQuery(() => {
    cnb_action_edit_legal_1()
    cnb_action_edit_legal_2()
    cnb_action_edit_legal_3()
})