document.addEventListener("DOMContentLoaded", function() {
    // Check if localStorage is available
    function localStorageAvailable() {
        try {
            var test = "__localStorage_test__";
            localStorage.setItem(test, test);
            localStorage.removeItem(test);
            return true;
        } catch (e) {
            return false;
        }
    }

    var exactTimeGlobal = null;
    if (localStorageAvailable()) {
        // Check if exactTime is already stored in localStorage
        exactTimeGlobal = localStorage.getItem('exactTimeGlobal');
    }

    // Common attributes and styles
    var honeypotAttributes = {
        type: "text",
        name: maspikData.honeypotName,
        id: maspikData.honeypotName,
        placeholder: "Leave this field empty",
        'aria-hidden': "true", // Accessibility
        tabindex: "-1", // Accessibility
        autocomplete: "off", // Prevent browsers from auto-filling
        class: "maspik-hp-field"
    };

    var commonAttributes = {
        'aria-hidden': "true", // Accessibility
        tabindex: "-1", // Accessibility
        autocomplete: "off" // Prevent browsers from auto-filling
    };

    var hiddenFieldStyles = {
        position: "absolute",
        left: "-99999px"
    };

    function createHiddenField(attributes, styles) {
        var field = document.createElement("input");
        for (var attr in attributes) {
            field.setAttribute(attr, attributes[attr]);
        }
        for (var style in styles) {
            field.style[style] = styles[style];
        }
        return field;
    }

    function addHiddenFields(formSelector, fieldClass) {
        document.querySelectorAll(formSelector).forEach(function(form) {
            if (!form.querySelector('input[name="' + maspikData.honeypotName + '"]')) {
                var honeypot = createHiddenField(honeypotAttributes, hiddenFieldStyles);
                honeypot.classList.add(fieldClass);

                var currentYearField = createHiddenField({
                    type: "text",
                    name: "Maspik-currentYear",
                    id: "Maspik-currentYear",
                    class: fieldClass
                }, hiddenFieldStyles);

                var exactTimeField = createHiddenField({
                    type: "text",
                    name: "Maspik-exactTime",
                    id: "Maspik-exactTime",
                    class: fieldClass
                }, hiddenFieldStyles);

                form.appendChild(honeypot);
                form.appendChild(currentYearField);
                form.appendChild(exactTimeField);
            }
        });
    }

    // Add hidden fields to different form types
    addHiddenFields('form.wpcf7-form', 'wpcf7-text');
    addHiddenFields('form.elementor-form', 'elementor-field');
    addHiddenFields('form.wpforms-form', 'wpforms-field');
    addHiddenFields('form.brxe-brf-pro-forms', 'brxe-brf-pro-forms-field-text');
    addHiddenFields('form.frm-fluent-form', 'ff-el-form-control');
    addHiddenFields('form.frm-show-form', 'wpforms-field');
    addHiddenFields('form.forminator-custom-form', 'forminator-input');
    addHiddenFields('.gform_wrapper form', 'gform-input');
    addHiddenFields('.nf-form-wrap form nf-fields-wrap', 'ninja-forms-field nf-element');
    addHiddenFields('.gform_wrapper form', 'gform-input');

    // Add more form types here if needed in the future
    // addHiddenFields('form.new-form-type', 'new-form-class');

    // Set current year and exact time fields
    function setDateFields() {
        var currentYear = new Date().getFullYear();

        // If exactTimeGlobal is not already set in localStorage, set it now
        if (!exactTimeGlobal) {
            exactTimeGlobal = Math.floor(Date.now() / 1000);
            if (localStorageAvailable()) {
                localStorage.setItem('exactTimeGlobal', exactTimeGlobal);
            }
        }

        console.log('UTC Time:', exactTimeGlobal);

        document.querySelectorAll('input[name="Maspik-currentYear"]').forEach(function(input) {
            input.value = currentYear; 
        });

        document.querySelectorAll('input[name="Maspik-exactTime"]').forEach(function(input) {
            input.value = exactTimeGlobal;
        });
    }

    // Initial call to set date fields
    setDateFields();

    // Listen for form submissions and reset hidden fields
    document.querySelectorAll('form').forEach(function(form) {
        form.addEventListener('submit', function(event) {
           // setDateFields();
        });
    });

    // MutationObserver to detect AJAX form reloads and reset hidden fields
    var observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList' && mutation.addedNodes.length) {
                setTimeout(function() { // Slight delay to ensure new form elements are fully loaded
                    setDateFields();
                }, 500);
            }
        });
    });

    observer.observe(document.body, { childList: true, subtree: true });
});
