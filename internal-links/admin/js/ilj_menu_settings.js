function ilj_dynamicSelect(id, action, searchResults) {
    jQuery(id).ilj_select2({
        width: '50%',
        minimumInputLength: 3,
        templateSelection: function(state) {
            var limit = 20;
            var element = jQuery(id);
            if (element && element.data("iljTitleCharacterLimit")) {
                limit = parseInt(element.data("iljTitleCharacterLimit"));
            }
            var title = state.text.length > limit ? state.text.substring(0, limit) + "..." : state.text;
            return title + " (ID: " + state.id + ")";
        },
        ajax: {
            url: ajaxurl,
            type: "POST",
            data: function(params) {
                return {
                    action: action,
                    search: params.term,
                    per_page: searchResults,
                    page: (params.page || 1)
                }
            },
            processResults: function(data) {
                if (data.length === 0) {
                    return false;
                }
                more = true;
                if (data.length < searchResults) {
                    more = false;
                }
                return data_new = {
                    "results": data,
                    "pagination": {
                        "more": more
                    }
                };
            }
        },
        language: {
            errorLoading: function() {
                return ilj_select2_translation.error_loading;
            },
            inputTooShort: function(args) {
                var remainingChars = args.minimum - args.input.length;
                return ilj_select2_translation.input_too_short + ': ' + remainingChars;
            },
            loadingMore: function() {
                return ilj_select2_translation.loading_more;
            },
            noResults: function() {
                return ilj_select2_translation.no_results;
            },
            searching: function() {
                return ilj_select2_translation.searching;
            }
        }
    });
}

function ilj_menu_settings_inverse_fields(field, inverse_fields, attribute='readonly') {
    ilj_menu_settings_toggle_fields(field.prop('checked'), inverse_fields, attribute)
    field.on('change', function () {
        ilj_menu_settings_toggle_fields(field.prop('checked'), inverse_fields, attribute)
    })
}

function ilj_menu_settings_toggle_fields(toggle, inverse_fields, attribute) {

    if (toggle) {
        inverse_fields.each(function () {
            jQuery(this).prop(attribute, false).closest('tr').find('th').removeClass('inactive');
        })
    } else {
        inverse_fields.each(function () {
            jQuery(this).prop(attribute, true).closest('tr').find('th').addClass('inactive');
        })
    }
}


jQuery(document).ready(function() {
    jQuery('#ilj_settings_field_editor_role, #ilj_settings_field_index_generation, #ilj_settings_field_whitelist, #ilj_settings_field_taxonomy_whitelist,#ilj_settings_field_limit_taxonomy_list, #ilj_settings_field_keyword_order, #ilj_settings_field_no_link_tags, #ilj_settings_field_custom_fields_to_link_post, #ilj_settings_field_custom_fields_to_link_term').ilj_select2({
        minimumResultsForSearch: 10,
        width: '50%'
    });

    ilj_menu_settings_inverse_fields(jQuery('#ilj_settings_field_limit_incoming_links'), jQuery('#ilj_settings_field_max_incoming_links'))

    ilj_dynamicSelect('#ilj_settings_field_blacklist', 'ilj_search_posts', 20);
    ilj_dynamicSelect('#ilj_settings_field_term_blacklist', 'ilj_search_terms', 20);

    jQuery('#ilj_settings_field_multiple_keywords').on('change', function() {
        var $inverse_setting_field = jQuery('#ilj_settings_field_links_per_page, #ilj_settings_field_links_per_target, #ilj_settings_field_limit_incoming_links');
        $inverse_setting_field = jQuery('#ilj_settings_field_links_per_page, #ilj_settings_field_links_per_target, #ilj_settings_field_links_per_paragraph_switch, #ilj_settings_field_links_per_paragraph, #ilj_settings_field_limit_incoming_links');
        if (this.checked) {
            $inverse_setting_field.each(function() {
                jQuery(this).closest('tr').find('th').addClass('inactive');
            });

                        $inverse_setting_field.prop('disabled', true);
            jQuery("#ilj_settings_field_links_per_paragraph_switch").prop("checked", false );
            jQuery("#ilj_settings_field_links_per_paragraph").val("0");
            jQuery("#ilj_settings_field_links_per_page").val("0");
            jQuery("#ilj_settings_field_links_per_target").val("0");
            jQuery('#ilj_settings_field_limit_incoming_links').val('0').prop('checked', false).trigger('change');

                    } else {
            $inverse_setting_field.each(function() {
                jQuery(this).closest('tr').find('th').removeClass('inactive');
            });

            $inverse_setting_field.prop('disabled', false);
            jQuery("#ilj_settings_field_links_per_paragraph").prop('disabled', true);
        }
    });
    jQuery('#ilj_settings_field_links_per_paragraph_switch').on('change', function() {
        var $inverse_setting_field = jQuery('#ilj_settings_field_links_per_paragraph');
        if (!this.checked) {
            $inverse_setting_field.each(function() {
                jQuery(this).closest('tr').find('th').addClass('inactive');
            });

            $inverse_setting_field.prop('disabled', true);
        } else {
            $inverse_setting_field.each(function() {
                jQuery(this).closest('tr').find('th').removeClass('inactive');
            });

            $inverse_setting_field.prop('disabled', false);
        }
    });

        jQuery('#ilj_settings_field_index_generation').on('change', function() {
        var $inverse_setting_field = jQuery('#ilj_settings_field_hide_status_bar');
        if (this.value == "index_mode_none") {
            $inverse_setting_field.each(function() {
                jQuery(this).closest('tr').find('th').addClass('inactive');
            });

            $inverse_setting_field.prop('disabled', true);
        } else {
            $inverse_setting_field.each(function() {
                jQuery(this).closest('tr').find('th').removeClass('inactive');
            });

            $inverse_setting_field.prop('disabled', false);
        }
    });


    var index_generation_mode = jQuery('#ilj_settings_field_index_generation').val();
    if (index_generation_mode == 'index_mode_none') {
        var disable_hide_status_bar_option = jQuery("#ilj_settings_field_hide_status_bar");
        disable_hide_status_bar_option.each(function() {
            jQuery(this).closest('tr').find('th').addClass('inactive');
        });
        disable_hide_status_bar_option.prop('disabled', true);

           }

        jQuery(document).ready(function() {
        var $multiple_keywords = jQuery('#ilj_settings_field_multiple_keywords');
        var $inverse_setting_field = jQuery('#ilj_settings_field_links_per_page, #ilj_settings_field_links_per_target');
        $inverse_setting_field = jQuery('#ilj_settings_field_links_per_page, #ilj_settings_field_links_per_target, #ilj_settings_field_links_per_paragraph_switch, #ilj_settings_field_links_per_paragraph,  #ilj_settings_field_limit_incoming_links');

        if (!$multiple_keywords.length) {
            return;
        }
        if ($multiple_keywords[0].checked) {
            $inverse_setting_field.each(function() {
                jQuery(this).closest('tr').find('th').addClass('inactive');
            });
            $inverse_setting_field.prop('disabled', true);
        } else {
            $inverse_setting_field.prop('disabled', false);
        }

        var $links_per_paragraph_switch = jQuery('#ilj_settings_field_links_per_paragraph_switch');
        if (!$links_per_paragraph_switch.length) {
            return;
        }
        if (!$links_per_paragraph_switch[0].checked) {
            var $inverse_setting_field = jQuery('#ilj_settings_field_links_per_paragraph');
            $inverse_setting_field.each(function() {
                jQuery(this).closest('tr').find('th').addClass('inactive');
            });
            $inverse_setting_field.prop('disabled', true);
        }



    });

    var tipsoConfig = {
            width: '',
            maxWidth: '200',
            useTitle: true,
            delay: 100,
            speed: 500,
            background: '#32373c',
            color: '#eeeeee',
            size: 'small'
        }

    jQuery('.tip').iljtipso(tipsoConfig);

    jQuery(document).on('click', '.button.ilj-cancel-schedules', function(e) {
        e.preventDefault();

		var user_confirmed = confirm(ilj_menu_settings_translation.confirm_cancel_message);

		if (!user_confirmed) {
			return;
		}

	        if (jQuery(this).attr('disabled')) {
            return;
        }
        jQuery(this).after(jQuery('<span id="ilj-cancel-schedule-spinner" class="spinner is-active" style="float:none"></span>'));
        var data = {
            'action': 'ilj_cancel_schedules'
        };
        jQuery.ajax({
            url: ajaxurl,
            type: 'POST',
            data: data,
            statusCode: {
                500: function(xhr) {
                    if (!'responseJSON' in xhr || !['success', 'error'].includes(xhr.responseJSON.status)) {
                        return;
                    }
                    console.log('Error: ' + xhr.responseJSON.message);
                }
            },
            success: function(data, textStatus, xhr) {
                jQuery('#ilj-cancel-schedule-spinner').remove();

				if (jQuery('#ilj-cancel-schedule-feedback').length === 0) {
					var successMessage = '<div id="ilj-cancel-schedule-feedback" class="notice notice-success is-dismissible"><p>'+ ilj_menu_settings_translation.success_message +'</p></div>';
					jQuery(successMessage).insertAfter('.button.ilj-cancel-schedules');

					setTimeout(function() {
						jQuery("#ilj-cancel-schedule-feedback").remove();
					}, 2000);
				}

				             }
        });
    });
});