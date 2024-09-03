(function ($) {
    'use strict';

    /**
     * All of the code for your admin-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     *
     * This enables you to define handlers, for when the DOM is ready:
     *
     * $(function() {
     *
     * });
     *
     * When the window is loaded:
     *
     * $( window ).load(function() {
     *
     * });
     *
     * ...and/or other possibilities.
     *
     * Ideally, it is not considered best practise to attach more than a
     * single DOM-ready or window-load handler for a particular page.
     * Although scripts in the WordPress core, Plugins and Themes may be
     * practising this, we should strive to set a better example in our own work.
     */

     jQuery.fn.aysModal = function(action){
        let jQuerythis = jQuery(this);
        switch(action){
            case 'hide':
                jQuery(this).find('.ays-modal-content').css('animation-name', 'zoomOut');
                setTimeout(function(){
                    jQuery(document.body).removeClass('modal-open');
                    jQuery(document).find('.ays-modal-backdrop').remove();
                    jQuerythis.hide();
                }, 250);
            break;
            case 'show': 
            default:
                jQuerythis.show();
                jQuery(this).find('.ays-modal-content').css('animation-name', 'zoomIn');
                jQuery(document).find('.modal-backdrop').remove();
                jQuery(document.body).append('<div class="ays-modal-backdrop"></div>');
                jQuery(document.body).addClass('modal-open');
            break;
        }
    }

    $.fn.goToNormal = function() {
        $('html, body').animate({
            scrollTop: this.offset().top - 200 + 'px'
        }, 'normal');
        return this; // for chaining...
    }

    $(document).ready(function () {
        $(document).on("input", 'input', function (e) {
            if (e.keyCode == 13) {
                return false;
            }
        });
        $(document).on("keydown", function (e) {
            if (e.target.nodeName == "TEXTAREA") {
                return true;
            }
            if (e.keyCode == 13) {
                return false;
            }
        });

        $(document).on('change', '.ays_toggle_checkbox', function (e) {
            let state = $(this).prop('checked');
            let parent = $(this).parents('.ays_toggle_parent');
            if($(this).hasClass('ays_toggle_slide')){
                switch (state) {
                    case true:
                        parent.find('.ays_toggle_target').slideDown(250);
                        break;
                    case false:
                        parent.find('.ays_toggle_target').slideUp(250);
                        break;
                }
            }else{
                switch (state) {
                    case true:
                        parent.find('.ays_toggle_target').show(250);
                        break;
                    case false:
                        parent.find('.ays_toggle_target').hide(250);
                        break;
                }
            }
        });

        let $_navTabs = $(document).find('.nav-tab'),
            $_navTabContent = $(document).find('.nav-tab-content');
        $(document).find('#sccp_post_types').select2();
        $(document).find('#sccp_post_types_1').select2();
        $(document).find('#sccp_post_types_2').select2();
        $('[id^=ays_users_roles_]').select2();        

        $_navTabs.on('click', function (e) {
            e.preventDefault();
            let active_tab = $(this).attr('data-tab');
            $_navTabs.each(function () {
                $(this).removeClass('nav-tab-active');
            });
            $_navTabContent.each(function () {
                $(this).removeClass('nav-tab-content-active');
            });
            $(this).addClass('nav-tab-active');
            $(document).find('.nav-tab-content' + $(this).attr('href')).addClass('nav-tab-content-active');
            $(document).find("[name='sccp_tab']").val(active_tab);
        });

        $(document).find('.ays-close').on('click', function () {
              $(document).find('.ays-modal').aysModal('hide');
        });

        $(document).find('#blocked_ips').DataTable();

        $('[data-toggle="tooltip"]').tooltip();

        $(document).on('click', '.ays_all', function(){
            var ays_all_checkboxes = $(this).closest('#tab2').find('.modern-checkbox-options');
            if($(this).is(':checked')) {
                ays_all_checkboxes.prop('checked', true);
            } else {
                ays_all_checkboxes.removeAttr('checked');   
                $('.ays_all_mess').removeAttr('checked');
                $('.ays_all_audio').removeAttr('checked');
            }
            ays_all_checkboxes.trigger("change");
        });       

        $(document).on('click', '.ays_all_mess', function(){
            var ays_all_mess_checkboxes = $(this).closest('#tab2').find('.modern_checkbox_mess').not(':disabled');
            if($(this).is(':checked')) {
                ays_all_mess_checkboxes.prop('checked', true);
            } else {
                ays_all_mess_checkboxes.removeAttr('checked');
            }
        });       

        $(document).on('click', '.ays_all_audio', function(){
            var ays_all_audio_checkboxes = $(this).closest('#tab2').find('.modern_checkbox_audio').not(':disabled');
            if($(this).is(':checked')) {
                ays_all_audio_checkboxes.prop('checked', true);
            } else {
                ays_all_audio_checkboxes.removeAttr('checked');
            }
        });

        $(document).find('#sccp_start-date-filter').on('change', function(e) {
            $('#ays_sccp_export_filter').submit();
            e.preventDefault();
        });

        $(document).find('#sccp_end-date-filter').on('change', function(e) {
            $('#ays_sccp_export_filter').submit();
            e.preventDefault();
        });

        $(document).on('change.select2', '#sccp_id-filter', function(e) {
            $('#ays_sccp_export_filter').submit();
            e.preventDefault();
        });
        $(document).find('#ays_sccp_export_filter').on('submit', function(e) {
            e.preventDefault();
            var $this = $('#sccp_export_filters');
            var action = 'ays_sccp_results_export_filter';
            var sccp_id = $('#sccp_id-filter').val();

            var date_from = $('#sccp_start-date-filter').val() || $('#sccp_start-date-filter').attr('min');
            var date_to = $('#sccp_end-date-filter').val() || $('#sccp_end-date-filter').attr('max');
        
            $this.find('div.ays-sccp-preloader').css('display', 'flex');
            $.ajax({
                url: sccp.ajax,
                method: 'post',
                dataType: 'json',
                data: {
                    action: action,
                    sccp_id: sccp_id,
                    date_from: date_from,
                    date_to: date_to

                },
                success: function(response) {
                    $this.find('div.ays-sccp-preloader').css('display', 'none');
                    $this.find(".export_results_count span").text(response.results);
                }
            });
        });

        let sccpSel2;

        $(document).find('.ays-sccp-export-filters').on('click', function(e) {
            let $this = $('#sccp_export_filters');
            $this.find('div.ays-sccp-preloader').css('display', 'flex');
            $this.aysModal('show');
            e.preventDefault();
            let action = 'ays_sccp_show_filters';
            $.ajax({
                url: sccp.ajax,
                method: 'post',
                dataType: 'json',
                data: {
                   action: action
                },
                success: function(res) {
                    $this.find('div.ays-sccp-preloader').css('display', '');
                    let newSccpSelect = "";

                    for (let q in res.shortcode) {
                        newSccpSelect += '<option value="'+ res.shortcode[q].subscribe_id +'">'+ res.shortcode[q].subscribe_id +'</option>';
                    }

                    let sccpSel = $this.find('#sccp_id-filter').html(newSccpSelect);
                    sccpSel2 = sccpSel.select2({
                        dropdownParent: sccpSel.parent(),
                        closeOnSelect: true,
                        allowClear: false
                    });
                    
                    $(document).on('click', '.select2-selection__choice__remove', function(){
                        sccpSel2.select2("close");
                    });
                    
                    $this.find(".export_results_count span").text(res.count);
                    $this.find('.ays-modal-body').show();
                },
                error: function() {
                    swal.fire({
                        type: 'info',
                        html: "<h2>Can't load resource.</h2><br><h6>Maybe something went wrong.</h6>"
                    }).then(function(res){
                        $(document).find('#ays-export-filters div.ays-sccp-preloader').css('display', 'none');
                        $this.aysModal('hide');
                    });
                }
            });
        });

        $(document).on('click', '.ays_sccpid_clear', function(){
            sccpSel2.val(null).trigger('change');
            return false;
        });

        $(document).find('.sccp_results_export-action').on('click', function(e) {
            e.preventDefault();
            let $this = $('#ays-export-filters');
            $this.find('div.ays-sccp-preloader').css('display', 'flex');
            let action = 'ays_sccp_results_export_file';
            let sccp_id = $('#sccp_id-filter').val();
            var type = $(this).data('type');
            var date_from = $('#sccp_start-date-filter').val() || $('#sccp_start-date-filter').attr('min');
            var date_to = $('#sccp_end-date-filter').val() || $('#sccp_end-date-filter').attr('max');
            $.post({
                url: sccp.ajax,
                dataType: 'json',
                data: { 
                    action: action,
                    type: type,
                    sccp_id: sccp_id,
                    date_from: date_from, 
                    date_to: date_to
                },
                success: function(response) {
                    if (response.status) {
                        switch (response.type) {
                            case 'xlsx':
                                var options = {
                                    fileName: "sccp_results_export",
                                    header: true
                                };
                                var tableData = [{
                                    "sheetName": "Sccp results",
                                    "data": response.data
                                }];
                                Jhxlsx.export(tableData, options);
                                break;
                            case 'csv':
                                $('#download').attr({
                                    'href': response.file,
                                    'download': "exported_sccp.csv",
                                })[0].click();
                                break;
                            case 'json':
                                var text = JSON.stringify(response.data);
                                var data = new Blob([text], {type: "application/" + response.type});
                                var fileUrl = window.URL.createObjectURL(data);
                                $('#download').attr({
                                    'href': fileUrl,
                                    'download': "sccp_results_export." + response.type,
                                })[0].click();
                                window.URL.revokeObjectURL(fileUrl);
                                break;
                            default:
                                break;
                        }
                    }
                    $this.find('div.ays-sccp-preloader').css('display', 'none');
                }
            });
        });

        var unread_result_parent = $(document).find(".unread-result").parent().parent();

        if (unread_result_parent != undefined) {
            unread_result_parent.css({"font-weight":"bold"});
        }

        var checkbox = $('.modern-checkbox-options');
        for (var i = 0; i < checkbox.length; i++) {

            var classname = checkbox[i].className.split(' ');
            if (checkbox[i].checked == true) {
                $('.' + classname[1] + '-mess').attr('disabled', false);
                $('.' + classname[1] + '-audio').attr('disabled', false);
            } else {
                $('.' + classname[1] + '-mess').attr('disabled', true);
                $('.' + classname[1] + '-audio').attr('disabled', true);
            }
        }
        checkbox.change(function () {

            var classname = this.className.split(' ');            
            if (this.checked == true) {
                $('.' + classname[1] + '-mess').attr('disabled', false);
                $('.' + classname[1] + '-audio').attr('disabled', false);
            } else {
                $('.' + classname[1] + '-mess').attr('checked', false);
                $('.' + classname[1] + '-mess').attr('disabled', true);
                $('.' + classname[1] + '-audio').attr('checked', false);
                $('.' + classname[1] + '-audio').attr('disabled', true);
            }

        });

        $(document).on('click', '.upload_audio', function (e) {
            openSCCPMusicMediaUploader(e, $(this));
        });        


        let heart_interval = setInterval(function () {
            $(document).find('.ays_heart_beat i.ays_fa').toggleClass('ays_pulse');
        }, 1000);



        //--------------preview
        
        $('#reset_to_default').on('click', function () {
            setTimeout(function(){
                if($(document).find('#sccp_custom_css').length > 0){
                    if(wp.codeEditor){
                        $(document).find('#sccp_custom_css').next('.CodeMirror').remove();
                        $(document).find('#sccp_custom_css').val('');
                        wp.codeEditor.initialize($(document).find('#sccp_custom_css'), cm_settings);
                    }
                }
            }, 100);

            $(document).find('#ays_tooltip').css({
                "background-image": "unset", 
                "padding": "5", 
                "opacity": "1"
            });

            $(document).find('#ays_tooltip_block').css('backdrop-filter', 'blur(0px)');

            $(document).find('#bg_color').val('#ffffff').change();
            $(document).find('#text_color').val('#ff0000').change();
            $(document).find('#border_color').val('#b7b7b7').change();
            $(document).find('#boxshadow_color').val('rgba(0,0,0,0)').change();
            $(document).find('#ays-sccp-bg-img').attr('src', '').change();
            $(document).find('input#ays_sccp_bg_image').val('');
            $(document).find('#sccp_bg_image_container').hide().change();
            $(document).find('#sccp_bg_image').show().change();
            $(document).find('.sccp_opacity_demo_val').val(1).change();
            $(document).find('#sccp_tooltip_bg_blur').val('0').change();
            $(document).find('#font_size').val(12).change();
            $(document).find('#border_width').val(1).change();
            $(document).find('#border_radius').val(3).change();
            $(document).find('#border_style').val('solid').change();
            $(document).find('#tooltip_position').val('mouse').change();
            $(document).find('#ays_sccp_custom_class').val('');
            $(document).find('#sscp_timeout').val(1000);
            $(document).find('#ays_tooltip_padding').val(5);
            $(document).find('#ays_sccp_tooltip_bg_image_position').val('center center').change();
            $(document).find('#ays_sccp_box_shadow_x_offset').val(0).change();
            $(document).find('#ays_sccp_box_shadow_y_offset').val(0).change();
            $(document).find('#ays_sccp_box_shadow_z_offset').val(15).change();
            $(document).find('#ays_sccp_text_shadow_x_offset').val(2).change();
            $(document).find('#ays_sccp_text_shadow_y_offset').val(2).change();
            $(document).find('#ays_sccp_text_shadow_z_offset').val(3).change();
            $(document).find("#ays_sccp_enable_background_gradient").prop('checked' , false).change();
            $(document).find("#ays_sccp_enable_title_text_shadow").prop('checked' , false).change();

            $(document).find("#tab5").goToNormal();
        });

        $('#sub_reset_to_default').on('click', function () {
            $(document).find('#ays_sccp_sub_width').val('').change();
            $(document).find('#sccp_sub_width_by_percentage_px').val('pixels').change();
            $(document).find('#sub_text_color').val('#000').change();
            $(document).find('#sub_bg_color').val('#fff').change();
            $(document).find('#ays-sccp-sub-bg-img').attr('src', '').change();
            $(document).find('input#ays_sccp_sub_bg_image').val('');
            $(document).find('#sccp_sub_bg-image_container').hide().change();
            $(document).find('#sccp_sub_bg_image').show().change();
            $(document).find('#ays_sub_bg_image_position').val('center center').change();
            $(document).find('#sub_desc_text_color').val('#000').change();
            $(document).find('#ays_sub_title_transformation').val('none').change();
            $(document).find('#ays_sccp_sub_cont_border_style').val('solid').change();
            $(document).find('#ays_sccp_sub_cont_border_color').val('#000').change();
            $(document).find('#ays_sccp_sub_cont_border_width').val('1').change();
            $(document).find('#ays_sccp_sub_input_width').val('').change();
            $(document).find('#ays_sccp_sub_button_text').val('Subscribe').change();
            $(document).find('#ays-sccp-sub-img').attr('src', '').change();
            $(document).find('input#ays_sccp_sub_icon_image').val('');
            $(document).find('#sccp_sub_image_container').hide().change();
            $(document).find('#sccp_sub_icon_image').show().change();
            $(document).find('#ays_sccp_sub_email_place_text').val('Type your email address').change();
            $(document).find('#ays_sccp_sub_name_place_text').val('Type your name').change();
            $(document).find('#ays_sccp_sub_title_size').val('18');
            $(document).find('#ays_sccp_sub_desc_size').val('18');
            $(document).find("#ays_sccp_sub_text_alignment_left").prop('checked' , false).change();
            $(document).find("#ays_sccp_sub_text_alignment_center").prop('checked' , true).change();
            $(document).find("#ays_sccp_sub_text_alignment_right").prop('checked' , false).change();
            $(document).find("#ays_sccp_enable_sub_btn_style").prop('checked' , false).change();
            $(document).find('#ays_sccp_sub_btn_color').val('#fff').change();
            $(document).find('#ays_sccp_sub_btn_text_color').val('#000').change();
            $(document).find('#ays_sccp_sub_btn_size').val('14').change();
            $(document).find('#ays_sccp_sub_mobile_btn_size').val('14').change();
            $(document).find('#ays_sccp_sub_btn_radius').val('3').change();
            $(document).find('#ays_sccp_sub_btn_border_width').val('1').change();
            $(document).find('#ays_sccp_sub_btn_border_style').val('solid').change();
            $(document).find('#ays_sccp_sub_btn_border_color').val('#000').change();
            $(document).find('#ays_sub_btn_left_right_padding').val('20').change();
            $(document).find('#ays_sub_btn_top_bottom_padding').val('10').change();

            $(document).find("#tab5").goToNormal();
        });

        $('#bc_reset_to_default').on('click', function () {
            $(document).find('#ays_sccp_bc_width').val('').change();
            $(document).find('#sccp_bc_width_by_percentage_px').val('pixels').change();
            $(document).find('#bc_text_color').val('#000').change();
            $(document).find('#bc_bg_color').val('#fff').change();
            $(document).find('#ays-sccp-bc-bg-img').attr('src', '').change();
            $(document).find('input#ays_sccp_bc_bg_image').val('');
            $(document).find('#sccp_bc_bg-image_container').hide().change();
            $(document).find('#sccp_bc_bg_image').show().change();
            $(document).find('#ays_bc_bg_image_position').val('center center').change();
            $(document).find('#ays_sccp_bc_cont_border_style').val('double').change();
            $(document).find('#ays_sccp_bc_cont_border_color').val('#c5c5c5').change();
            $(document).find('#ays_sccp_bc_cont_border_width').val('4').change();
            $(document).find('#ays_sccp_bc_input_width').val('').change();
            $(document).find('#ays_sccp_bc_button_text').val('Submit').change();
            $(document).find('#ays_sccp_bc_psw_place_text').val('Password').change();
            $(document).find('#ays-sccp-bc-img').attr('src', '').change();
            $(document).find('input#ays_sccp_bc_icon_image').val('');
            $(document).find('#sccp_bc_image_container').hide().change();
            $(document).find('#sccp_bc_icon_image').show().change();
            $(document).find("#ays_sccp_bc_text_alignment_left").prop('checked' , false).change();
            $(document).find("#ays_sccp_bc_text_alignment_center").prop('checked' , true).change();
            $(document).find("#ays_sccp_bc_text_alignment_right").prop('checked' , false).change();
            $(document).find("#ays_sccp_enable_bc_btn_style").prop('checked' , false).change();
            $(document).find('#ays_sccp_bc_btn_color').val('#fff').change();
            $(document).find('#ays_sccp_bc_btn_text_color').val('#000').change();
            $(document).find('#ays_sccp_bc_btn_size').val('14').change();
            $(document).find('#ays_sccp_bc_mobile_btn_size').val('14').change();
            $(document).find('#ays_sccp_bc_btn_radius').val('3').change();
            $(document).find('#ays_sccp_bc_btn_border_width').val('1').change();
            $(document).find('#ays_sccp_bc_btn_border_style').val('solid').change();
            $(document).find('#ays_sccp_bc_btn_border_color').val('#c5c5c5').change();
            $(document).find('#ays_bc_btn_left_right_padding').val('10').change();
            $(document).find('#ays_bc_btn_top_bottom_padding').val('10').change();

            $(document).find("#tab6").goToNormal();
        });
        
        $(document).on('input', '.sccp_opacity_demo_val', function(){
            $(document).find('#ays_tooltip').css('opacity', $(this).val());
        });
        
        $(document).on('input', '.sccp_bg_blur', function(){
            $(document).find('#ays_tooltip_block').css('backdrop-filter', 'blur('+$(this).val()+'px)');
        });

        $('#bg_color').wpColorPicker({
            defaultColor: '#ffffff',
            change: function(event, ui) {
                $('#ays_tooltip').css('background-color', ui.color.toString());
            }
        });
        $('#text_color').wpColorPicker({
            defaultColor: '#ff0000',
            change: function(event, ui) {
                $('#ays_tooltip, #ays_tooltip>*').css('color', ui.color.toString())
            }
        });
        $('#ays_sccp_sub_btn_color').wpColorPicker({
            defaultColor: '#ffffff',
            change: function(event, ui) {
                $('#ays_tooltip, #ays_tooltip>*').css('color', ui.color.toString())
            }
        });
        $('#ays_sccp_bc_btn_color').wpColorPicker({
            defaultColor: '#ffffff',
            change: function(event, ui) {
                $('#ays_tooltip, #ays_tooltip>*').css('color', ui.color.toString())
            }
        });
        $('#ays_sccp_sub_btn_text_color').wpColorPicker({
            defaultColor: '#000000',
            change: function(event, ui) {
                $('#ays_tooltip, #ays_tooltip>*').css('color', ui.color.toString())
            }
        });
        $('#ays_sccp_bc_btn_text_color').wpColorPicker({
            defaultColor: '#000000',
            change: function(event, ui) {
                $('#ays_tooltip, #ays_tooltip>*').css('color', ui.color.toString())
            }
        });
        $('#ays_sccp_sub_btn_border_color').wpColorPicker({
            defaultColor: '#000000',            
        });
        $('#ays_sccp_bc_btn_border_color').wpColorPicker({
            defaultColor: '#c5c5c5',
        });
        $('#ays_sccp_sub_cont_border_color').wpColorPicker({
            defaultColor: '#000000',            
        });
        $('#ays_sccp_bc_cont_border_color').wpColorPicker({
            defaultColor: '#c5c5c5',            
        });
        $('#sub_text_color').wpColorPicker({
            defaultColor: '#000',
        });
        $('#bc_text_color').wpColorPicker({
            defaultColor: '#000',
        });
        $('#sub_bg_color').wpColorPicker({
            defaultColor: '#fff',
        });
        $('#bc_bg_color').wpColorPicker({
            defaultColor: '#fff',
        });
        $('#sub_desc_text_color').wpColorPicker({
            defaultColor: '#000',
        });
        $('#border_color').wpColorPicker({
            defaultColor: '#b7b7b7',
            change: function(event, ui) {
                $('#ays_tooltip').css('border-color', ui.color.toString())
            }
        });
        $('#boxshadow_color').wpColorPicker({
            defaultColor: 'rgba(0,0,0,0)',
            change: function(event, ui) {
                var x_offset = $(document).find('input#ays_sccp_box_shadow_x_offset').val() + "px ";
                var y_offset = $(document).find('input#ays_sccp_box_shadow_y_offset').val() + "px ";
                var z_offset = $(document).find('input#ays_sccp_box_shadow_z_offset').val() + "px ";

                var box_shadow = x_offset + y_offset + z_offset;

                $('#ays_tooltip').css('box-shadow', ui.color.toString() + ' ' + box_shadow + ' 1px ');
            }
        });

        $('#ays_sccp_tooltip_title_text_shadow_color').wpColorPicker({
            defaultColor: 'rgba(255,255,255,0)',
            change: function(event, ui) {
                var x_offset_t = $(document).find('input#ays_sccp_text_shadow_x_offset').val() + "px ";
                var y_offset_t = $(document).find('input#ays_sccp_text_shadow_y_offset').val() + "px ";
                var z_offset_t = $(document).find('input#ays_sccp_text_shadow_z_offset').val() + "px ";

                var text_shadow = x_offset_t + y_offset_t + z_offset_t;

                if($(document).find('#ays_sccp_enable_title_text_shadow').prop('checked') ){
                    $('#ays_tooltip').css('text-shadow', text_shadow + ui.color.toString());
                }else{
                    $('#ays_tooltip').css('text-shadow', 'unset');
                }
            }
        });

        $('#font_size').on('change', function () {
            let val = $(this).val();
            $('#ays_tooltip_block, #ays_tooltip_block > *').css('font-size', val + 'px')
        });
        $('#border_width').on('change', function () {
            let val = $(this).val();
            $('#ays_tooltip').css('border-width', val + 'px')
        });
        $('#border_radius').on('change', function () {
            let val = $(this).val();
            $('#ays_tooltip').css('border-radius', val + 'px')
        });
        $('#border_style').on('change', function () {
            let val = $(this).val();
            $('#ays_tooltip').css('border-style', val)
        });
        $('#ays_tooltip_padding').on('change', function () {
            let val = $(this).val();
            $('#ays_tooltip').css('padding', val)
        });        

        $('#ays_sccp_tooltip_bg_image_position').on('change', function () {
            let val = $(this).val();
            $('#ays_tooltip').css('background-position', val)
        });

        $('#ays_sccp_tooltip_bg_image_object_fit').on('change', function () {
            let val = $(this).val();
            $('#ays_tooltip').css('background-size', val)
        });

        $(document).find('#ays_sccp_box_shadow_x_offset, #ays_sccp_box_shadow_y_offset, #ays_sccp_box_shadow_z_offset').on('change', function () {
           
            var x_offset = $(document).find('input#ays_sccp_box_shadow_x_offset').val() + "px ";
            var y_offset = $(document).find('input#ays_sccp_box_shadow_y_offset').val() + "px ";
            var z_offset = $(document).find('input#ays_sccp_box_shadow_z_offset').val() + "px ";

            var box_shadow = x_offset + y_offset + z_offset;
            $(document).find('#ays_tooltip').css('box-shadow', $(document).find('#boxshadow_color').val() + ' ' + box_shadow + ' 1px ');
           
        });

        $(document).find('#ays_sccp_text_shadow_x_offset, #ays_sccp_text_shadow_y_offset, #ays_sccp_text_shadow_z_offset').on('change', function () {

            var color_t = $(document).find('#ays_sccp_tooltip_title_text_shadow_color').val();

            var x_offset_t = $(document).find('input#ays_sccp_text_shadow_x_offset').val() + "px ";
            var y_offset_t = $(document).find('input#ays_sccp_text_shadow_y_offset').val() + "px ";
            var z_offset_t = $(document).find('input#ays_sccp_text_shadow_z_offset').val() + "px ";

            var text_shadow = x_offset_t + y_offset_t + z_offset_t;
            $(document).find('#ays_tooltip').css('text-shadow', text_shadow + ' ' + color_t );
           
        });

        $(document).find('#ays_sccp_enable_title_text_shadow').on('change', function(){
            var color = $(document).find('#ays_sccp_tooltip_title_text_shadow_color').val();

            var x_offset_t = $(document).find('input#ays_sccp_text_shadow_x_offset').val() + "px ";
            var y_offset_t = $(document).find('input#ays_sccp_text_shadow_y_offset').val() + "px ";
            var z_offset_t = $(document).find('input#ays_sccp_text_shadow_z_offset').val() + "px ";

            var text_shadow = x_offset_t + y_offset_t + z_offset_t;

            if( $(this).prop('checked') ){
                $('#ays_tooltip').css('text-shadow', text_shadow + color);
            }else{
                $('#ays_tooltip').css('text-shadow', 'unset');
            }
        })

        $('#ays_tooltip_block').children().css('font-size', $('#font_size').val() + 'px');
        $('#ays_tooltip').children().css('margin', "0");


        //----------end preview

        function openSCCPMediaUploader(e, element) {
            e.preventDefault();
            let aysUploader = wp.media({
                title: 'Upload',
                button: {
                    text: 'Upload'
                },
                multiple: false
            }).on('select', function () {
                let attachment = aysUploader.state().get('selection').first().toJSON();
                $('.sccp_upload_audio').html('<audio id="sccp_audio" controls><source src="' + attachment.url + '" type="audio/mpeg"></audio>');                
                $('.upload_audio_url').val(attachment.url);
            }).open();

            return false;
        }

        function openSCCPMusicMediaUploader(e, element) {
            e.preventDefault();
            let aysUploader = wp.media({
                title: 'Upload music',
                button: {
                    text: 'Upload'
                },
                library: {
                    type: 'audio'
                },
                multiple: false
            }).on('select', function () {
                let attachment = aysUploader.state().get('selection').first().toJSON();
                $('.sccp_upload_audio').html('<audio id="sccp_audio" controls><source src="' + attachment.url + '" type="audio/mpeg"></audio><button type="button" class="close ays_close" aria-label="Close"><span aria-hidden="true">&times;</span></button>');
                $('.sccp_upload_audio').show();
                $('.upload_audio_url').val(attachment.url);
            }).open();
            return false;
        }

        $(document).on('click', '.ays_close', function () {
            $('#sccp_audio').trigger('pause'); // Stop playing        
            $('.sccp_upload_audio').hide();
            $('.upload_audio_url').val('');

        });
            
        //    AV block content
        $("input[type='text'].sccp_blockcont_shortcode").on("click", function () {
           $(this).select();
        });

        $("label.ays_actDect").on("click", function () {
            var date_id = $(this).find('input[id*="ays-sccp-date-"]').data('id');
            
            $(this).find('#ays-sccp-date-from-' + date_id + ', #ays-sccp-date-to-' + date_id).datetimepicker({
                controlType: 'select',
                oneLine: true,
                dateFormat: "yy-mm-dd",
                timeFormat: "HH:mm:ss"
            });
        });

        $(document).find('.sccp_schedule_date').datetimepicker({
            controlType: 'select',
            oneLine: true,
            dateFormat: "yy-mm-dd",
            timeFormat: "HH:mm:ss"
        });

        let id = $('.all_block_contents').data('last-id');
        $(document).on('click', '.add_new_block_content', function () {
            var last_id = $('.blockcont_one').last().attr('id');
            if (last_id == undefined) {
                last_id = id;
            } else {
                last_id = last_id.substring(7);
            }

            if (id == last_id) {
                id++;
            }
            var content = '';
            for (var key in sccp.bc_user_role) {            
               content += "<option  value='" + key + "' >" + sccp.bc_user_role[key]['name'] + "</option>";              
            }
               
            $('.all_block_contents').prepend(' <div class="blockcont_one" id="blocont' + id + '">\n' +
                '                    <div class="copy_protection_container form-group row ays_bc_row">\n' +
                '                        <div class="col">\n' +
                '                            <label for="sccp_blockcont_shortcode" class="sccp_bc_label">Shortcode</label>\n' +
                '                            <input type="text"  name="sccp_blockcont_shortcode[]" class="ays-text-input sccp_blockcont_shortcode select2_style" value="[ays_block id=\'' + id + '\'] Content [/ays_block]" readonly>\n' +
                '                            <input type="hidden"  name="sccp_blockcont_id[]" value="' + id + '">\n' +
                '                        </div>\n' +
                '                        <div class="col">\n' +
                '                           <div class="input-group bc_count_limit">\n' +
                '                               <div class="bc_count">\n' +
                '                                   <label for="sccp_blockcont_pass" class="sccp_bc_label">Password</label>\n' +
                '                               </div>\n' +
                '                               <div class="bc_limit">\n' +
                '                                   <label for="sccp_blockcont_limit_' + id + '" class="sccp_bc_limit">Limit<a class="ays_help" data-toggle="tooltip"\n' +
                '                                  title="Choose the maximum amount of the usage of the password">\n' +
                '                                    <i class="ays_fa ays_fa_info_circle"></i>\n' +
                '                                </a></label>\n' +
                '                                <input type="number" id="sccp_blockcont_limit_' + id + '" name="bc_pass_limit_' + id + '" >\n' +
                '                               </div>\n' +
                '                           </div>\n' +
                '                               <div class="input-group">\n' +
                '                                   <input type="password"  name="sccp_blockcont_pass[]" class="ays-text-input select2_style form-control">\n' +
                '                                   <div class="input-group-append ays_inp-group">\n' +
                '                                       <span class="input-group-text show_password">\n' +
                '                                           <i class="ays_fa fa-eye" aria-hidden="true"></i>\n' +
                '                                       </span>\n' +                
                '                                   </div>\n' +                
                '                               </div>\n' +                
                '                        </div>\n' +
                '                        <div>\n' +
                '                           <p style="margin-top:60px;">OR</p>\n' +
                '                        </div>\n' +
                '                        <div class="col">\n' +
                '                           <label for="sccp_blockcont_roles" class="sccp_bc_label">Except</label>\n' +
                '                           <div class="input-group">\n' +
                '                                <select name="ays_users_roles_'+id+'[]" class="ays_bc_users_roles" id="ays_users_roles_'+id+'" multiple>\n' +
                                                    content +
                '                                </select>\n' +
                '                            </div>\n' +
                '                       </div>\n' +
                '                       <div class="col">\n' +
                '                           <label for="sccp_blockcont_schedule" style="margin-left: 35px;">Schedule</label>\n' +
                '                           <div class="input-group">\n' +
                '                               <label style="display: flex;" class="ays_actDect"><span style="font-size:small;margin-right: 4px;">From</span>\n' +
                '                                   <input type="text" id="ays-sccp-date-from-'+id+'" data-id="'+id+'" class="ays-text-input ays-text-input-short sccp_schedule_date" name="bc_schedule_from_'+id+'" value="">\n' +
                '                               <div class="input-group-append">\n' +
                '                                       <label for="ays-sccp-date-from-'+id+'" style="height: 34px; padding: 5px 10px;" class="input-group-text">\n' +
                '                                            <span><i class="ays_fa ays_fa_calendar"></i></span>\n' +
                '                                        </label>\n' +
                '                                    </div>\n' +
                '                               </label>\n' +
                '                               <label style="display: flex;" class="ays_actDect"><span style="font-size:small;margin-right: 21px;">To</span>\n' +
                '                                   <input type="text" id="ays-sccp-date-to-'+id+'" data-id="'+id+'" class="ays-text-input ays-text-input-short sccp_schedule_date" name="bc_schedule_to_'+id+'" value="">\n' +
                '                               <div class="input-group-append">\n' +
                '                                       <label for="ays-sccp-date-to-'+id+'" style="height: 34px; padding: 5px 10px;" class="input-group-text">\n' +
                '                                            <span><i class="ays_fa ays_fa_calendar"></i></span>\n' +
                '                                        </label>\n' +
                '                                    </div>\n' +
                '                               </label>\n' +
                '                           </div>\n' +
                '                       </div>\n' +
                '                       <div>\n' +
                '                            <br>\n' +
                '                            <p class="blockcont_delete_icon"><i class="ays_fa fa-trash-o" aria-hidden="true"></i></p>\n' +
                '                        </div>' +
                '                    </div>\n' +
                '                </div>');
            
            id++;
            $('[id^=ays_users_roles_]').select2();            
            $("input[type='text'].sccp_blockcont_shortcode").on("click", function () {
                 $(this).select();
            });

            $("label.ays_actDect").on("click", function () {
                var date_id = $(this).find('input[id*="ays-sccp-date-"]').data('id');
                
                $(this).find('#ays-sccp-date-from-' + date_id + ', #ays-sccp-date-to-' + date_id).datetimepicker({
                    controlType: 'select',
                    oneLine: true,
                    dateFormat: "yy-mm-dd",
                    timeFormat: "HH:mm:ss"
                });
            });

            $(document).find('.sccp_schedule_date').datetimepicker({
                controlType: 'select',
                oneLine: true,
                dateFormat: "yy-mm-dd",
                timeFormat: "HH:mm:ss"
            });
            
        });
        
        // AV Block Subscribe
        $('.sccp_blocksub').on('change', function () {
            if ($(this).prop('checked')) {
                $(this).parent().children('.sccp_blocksub_hid').val('on');
            }else{
                $(this).parent().children('.sccp_blocksub_hid').val('off');
            }
        });
        let sub_id = $('.all_block_subscribes').data('last-id');
        let check_id = $('.ays_data_checker').val();
        $(document).on('click', '.add_new_block_subscribe', function () {
            var last_sub_id = $('.blockcont_one').last().attr('id');
            if (last_sub_id == undefined) {
                last_sub_id = sub_id;
                sub_id = parseInt($('.all_block_subscribes').data('last-id'));
            }
            if(check_id == 'false'){
                sub_id ++;
            }

            $('.all_block_subscribes').prepend(' <div class="blockcont_one" data-block_id="' + sub_id + '" id="blocksub' + sub_id + '">\n' +
                '    <div class="copy_protection_container row ays_bc_row">\n' +
                '        <div class="col sccp_block_sub">\n' +
                '            <div class="sccp_block_sub_label_inp">\n'+
                '               <div class="sccp_block_sub_label">\n'+
                '                   <label for="sccp_block_subscribe_shortcode_' + sub_id + '" class="sccp_bc_label">Shortcode</label>\n' +
                '               </div>\n' +
                '               <div class="sccp_block_sub_inp">\n'+
                '                   <input type="text"  name="sccp_block_subscribe_shortcode[]" id="sccp_block_subscribe_shortcode_' + sub_id + '" class="ays-text-input sccp_blockcont_shortcode select2_style" value="[ays_block_subscribe id=\'' + sub_id + '\'] Content [/ays_block_subscribe]" readonly>\n' +
                '                   <input type="hidden"  name="sccp_blocksub_id[]" value="' + sub_id + '">\n' +
                '               </div>\n' +
                '               <hr>\n'+
                '               <div class="copy_protection_container row">\n'+
                '                  <div class="col-sm-4">\n'+
                '                      <label for="sccp_enable_block_sub_name_field_'+sub_id+'">'+ sccpLangObj.nameField+'</label>\n'+
                '                      <a class="ays_help" data-toggle="tooltip" title="'+sccpLangObj.title+'">\n'+
                '                            <i class="ays_fa ays_fa_info_circle"></i>\n'+
                '                       </a>\n'+
                '                  </div>\n'+
                '                  <div class="col-sm-8">\n'+
                '                      <input type="checkbox" class="modern-checkbox" id="sccp_enable_block_sub_name_field_'+sub_id+'" name="sccp_enable_block_sub_name_field['+sub_id+'][]"  value="true">\n'+
                '                  </div>\n'+
                '               </div> \n'+
                '               <hr>\n'+
                '               <div class="copy_protection_container row block_sub_description">\n'+
                '                  <div class="col-sm-4">\n'+
                '                      <label for="sccp_enable_block_sub_desc_field_'+sub_id+'">'+ sccpLangObj.descField+'</label>\n'+
                '                      <a class="ays_help" data-toggle="tooltip" title="'+sccpLangObj.descTitle+'">\n'+
                '                            <i class="ays_fa ays_fa_info_circle"></i>\n'+
                '                       </a>\n'+
                '                  </div>\n'+
                '                  <div class="col-sm-1">\n'+
                '                      <input type="checkbox" class="modern-checkbox checkbox_show_hide" id="sccp_enable_block_sub_desc_field_'+sub_id+'" name="sccp_enable_block_sub_desc_field['+sub_id+'][]"  value="true">\n'+
                '                  </div>\n'+
                '                  <div class="col-sm-7 if_desc_textarea_'+sub_id+'" style="display: none;">\n'+
                '                      <textarea class="ays-textarea" cols="33" rows="4" id="sccp_enable_block_sub_desc_field_textarea_'+sub_id+'" name="sccp_enable_block_sub_desc_field_textarea_['+sub_id+']"></textarea>\n'+
                '                  </div>\n'+
                '               </div> \n'+
                '            </div>\n' +
                '            <div class="sccp_block_sub_inp_row">\n'+
                '               <div class="sccp_pro" title="This feature will available in PRO version">\n'+
                '                   <div class="pro_features sccp_general_pro">\n'+
                '                       <div>\n'+                
                '                           <a href="https://ays-pro.com/wordpress/secure-copy-content-protection/" target="_blank" class="ays-sccp-new-upgrade-button-link">\n' +
                '                               <div class="ays-sccp-new-upgrade-button-box">\n' +
                '                                   <div>\n' +
                '                                       <img src="'+sccpLangObj.adminUrl+'/images/icons/sccp_locked_24x24.svg">\n' +
                '                                       <img src="'+sccpLangObj.adminUrl+'/images/icons/sccp_unlocked_24x24.svg" class="ays-sccp-new-upgrade-button-hover">\n' +
                '                                   </div>\n' +
                '                                   <div class="ays-sccp-new-upgrade-button">Upgrade</div>\n' +
                '                               </div>\n' +
                '                           </a>\n' +
                '                       </div>\n' +
                '                   </div>\n' +
                '                   <div class="sccp_block_sub_label">\n'+
                '                      <label for="sccp_require_verification_' + sub_id + '" class="sccp_bc_label">Require verification</label>\n' +
                '                   </div>\n' +
                '                   <div class="sccp_block_sub_inp">\n'+
                '                       <input type="checkbox"  name="sccp_subscribe_require_verification[]" id="sccp_require_verification_' + sub_id + '" class="sccp_blocksub select2_style" value="on">\n' +
                '                       <input type="hidden"  name="sub_require_verification[]" class="sccp_blocksub_hid" value="off">\n' +
                '                   </div>\n' +
                '               </div>\n' +
                '            </div>\n' +
                '        </div>\n' +                
                '       <div>\n' +
                '            <br>\n' +
                '            <p class="blockcont_delete_icon"><i class="ays_fa fa-trash-o" aria-hidden="true"></i></p>\n' +
                '        </div>' +
                '    </div>\n' +
                '</div>');
            if(check_id != "false"){
                sub_id++;
            }   

            $('[data-toggle="tooltip"]').tooltip();

            $('.sccp_blocksub').on('change', function () {
                if ($(this).prop('checked')) {
                    $(this).parent().children('.sccp_blocksub_hid').val('on');
                }else{
                    $(this).parent().children('.sccp_blocksub_hid').val('off');
                }
            });

            $("input[type='text'].sccp_blockcont_shortcode").on("click", function () {
               $(this).select();
            });            
            
        });
       
        $(document).on('click', '.blocksub_delete_icon', function () {
            var real_del = confirm('Do you want to delete?');
            if (real_del == true) {
                var id = $(this).closest('.blockcont_one').attr('id');
                if (id == undefined) {
                    id = 0;
                } else {
                    id = id.substring(8); 
                    var lastval = $('.deleted_ids').val().toString();
                    var lastval_check = lastval != '' ? lastval.toString() + ',' : '';
                    var last_val = lastval_check + id.toString();
                    $('.deleted_ids').val(last_val);
                }
                
                $(this).parent().parent().parent().css({
                    'animation-name': 'slideOutLeft',
                    'animation-duration': '.4s', 
                    'box-shadow': '2px 0px 8px #bfb2b2'
                });
                var a = $(this);
                setTimeout(function(){
                    a.parent().parent().parent().remove();
                }, 400);
            }
            
        });
       
        $(document).on('click', '.blockcont_delete_icon', function () {
            var real_del = confirm('Do you want to delete?');
            if (real_del == true) {
                var id = $(this).closest('.blockcont_one').attr('id');
                if (id == undefined) {
                    id = 0;
                } else {
                    id = id.substring(7); 
                    var lastval = $('.deleted_ids').val().toString();
                    lastval = lastval.toString() + ',' + id.toString();
                    $('.deleted_ids').val(lastval);
                }
                
                $(this).parent().parent().parent().css({
                    'animation-name': 'slideOutLeft',
                    'animation-duration': '.4s', 
                    'box-shadow': '2px 0px 8px #bfb2b2'
                });
                var a = $(this);
                setTimeout(function(){
                    a.parent().parent().parent().remove();
                }, 400);
            }
            
        });

        var count = 1;
        $(document).on('click', '.show_password', function () {

            if (count % 2) {
                $(this).parent().parent().find('input').attr('type', 'text');
            } else {
                $(this).parent().parent().find('input').attr('type', 'password');
            }
            count++;
        });        

        //--------------AV end
        
        $(document).on('click', '.ays-edit-sccp-bg-img', function (e) {
            openSccpMediaUploader(e, $(this));
        });

        $(document).on('click', 'a.add-sccp-bg-image', function (e) {
            openSccpMediaUploader(e, $(this));
        });
        
        $(document).on('click', '.ays-edit-sccp-sub-img', function (e) {
            openSccpSubMediaUploader(e, $(this));
        });

        $(document).on('click', 'a.add-sccp-sub-icon-image', function (e) {
            openSccpSubMediaUploader(e, $(this));
        });

        $(document).on('click', 'a.add-sccp-sub-bg-image', function (e) {
            openSccpSubMediaUploader(e, $(this));
        });

        $(document).on('click', '.ays-edit-sccp-sub-bg-img', function (e) {
            openSccpSubMediaUploader(e, $(this));
        });

        $(document).on('click', 'a.add-sccp-bc-bg-image', function (e) {
            openSccpBcMediaUploader(e, $(this));
        });

        $(document).on('click', '.ays-edit-sccp-bc-bg-img', function (e) {
            openSccpBcMediaUploader(e, $(this));
        });

        $(document).on('click', '.ays-edit-sccp-bc-img', function (e) {
            openSccpBcMediaUploader(e, $(this));
        });

        $(document).on('click', 'a.add-sccp-bc-icon-image', function (e) {
            openSccpBcMediaUploader(e, $(this));
        });

        $(document).on('click', '.ays-remove-sccp-bg-img', function () {
            $(this).parent().find('img#ays-sccp-bg-img').attr('src', '');
            $(this).parent().parent().find('input#ays_sccp_bg_image').val('');
            $(this).parent().fadeOut();
            $(this).parent().parent().find('a.add-sccp-bg-image').show();
            $(document).find('#ays_tooltip').css({'background-image': 'none'});
            toggleBackgrounGradient();
        });

        $(document).on('click', '.ays-remove-sccp-sub-img', function () {
            $(this).parent().find('img#ays-sccp-sub-img').attr('src', '');
            $(this).parent().parent().find('input#ays_sccp_sub_icon_image').val('');
            $(this).parent().hide();
            $(this).parent().parent().find('a.add-sccp-sub-icon-image').show();            
        });

        $(document).on('click', '.ays-remove-sccp-bc-img', function () {
            $(this).parent().find('img#ays-sccp-bc-img').attr('src', '');
            $(this).parent().parent().find('input#ays_sccp_bc_icon_image').val('');
            $(this).parent().hide();
            $(this).parent().parent().find('a.add-sccp-bc-icon-image').show();            
        });

        $(document).on('click', '.ays-remove-sccp-sub-bg-img', function () {
            $(this).parent().find('img#ays-sccp-sub-bg-img').attr('src', '');
            $(this).parent().parent().find('input#ays_sccp_sub_bg_image').val('');
            $(this).parent().hide();
            $(this).parent().parent().find('a.add-sccp-sub-bg-image').show();            
        });

        $(document).on('click', '.ays-remove-sccp-bc-bg-img', function () {
            $(this).parent().find('img#ays-sccp-bc-bg-img').attr('src', '');
            $(this).parent().parent().find('input#ays_sccp_bc_bg_image').val('');
            $(this).parent().hide();
            $(this).parent().parent().find('a.add-sccp-bc-bg-image').show();            
        });

        setTimeout(function(){
            if($(document).find('#sccp_custom_css').length > 0){
                if(wp.codeEditor)
                    wp.codeEditor.initialize($(document).find('#sccp_custom_css'), cm_settings);
            }
        }, 500);

        $(document).find('a[href="#tab5"]').on('click', function (e) {        
            setTimeout(function(){
                if($(document).find('#sccp_custom_css').length > 0){
                    if(wp.codeEditor){
                        $(document).find('#sccp_custom_css').next('.CodeMirror').remove();
                        wp.codeEditor.initialize($(document).find('#sccp_custom_css'), cm_settings);
                    }
                }
            }, 500);
        });

        function openSccpMediaUploader(e, element) {
            e.preventDefault();
            let aysUploader = wp.media({
                title: 'Upload',
                button: {
                    text: 'Upload'
                },
                library: {
                    type: 'image'
                },
                multiple: false
            }).on('select', function () {
                let attachment = aysUploader.state().get('selection').first().toJSON();
                if(element.hasClass('add-sccp-bg-image')){
                    element.parent().find('.ays-sccp-bg-image-container').fadeIn();
                    element.parent().find('img#ays-sccp-bg-img').attr('src', attachment.url);
                    element.next().val(attachment.url);
                    $(document).find('.ays-tooltip-live-container').css({'background-image': 'url("'+attachment.url+'")'});
                    element.hide();
                }else if(element.hasClass('ays-edit-sccp-bg-img')){
                    element.parent().find('.ays-sccp-bg-image-container').fadeIn();
                    element.parent().find('img#ays-sccp-bg-img').attr('src', attachment.url);
                    $(document).find('#ays_sccp_bg_image').val(attachment.url);
                    $(document).find('.ays-tooltip-live-container').css({'background-image': 'url("'+attachment.url+'")'});
                }else{
                    element.text('Edit Image');
                    element.parent().parent().find('.ays-sccp-image-container').fadeIn();
                    element.parent().parent().find('img#ays-sccp-img').attr('src', attachment.url);
                    $('input#ays-sccp-image').val(attachment.url);
                }
            }).open();

            return false;
        }

        function openSccpSubMediaUploader(e, element) {
            e.preventDefault();
            let aysUploader = wp.media({
                title: 'Upload',
                button: {
                    text: 'Upload'
                },
                library: {
                    type: 'image'
                },
                multiple: false
            }).on('select', function () {
                let attachment = aysUploader.state().get('selection').first().toJSON();
                if(element.hasClass('add-sccp-sub-icon-image')){
                    element.parent().find('.ays-sccp-sub-image-container').fadeIn();
                    element.hide();
                    element.parent().find('img#ays-sccp-sub-img').attr('src', attachment.url);
                    element.next().val(attachment.url);                    
                }else if(element.hasClass('ays-edit-sccp-sub-img')){
                    element.parent().find('.ays-sccp-sub-image-container').fadeIn();
                    element.parent().find('img#ays-sccp-sub-img').attr('src', attachment.url);
                    $(document).find('#ays_sccp_sub_icon_image').val(attachment.url);                    
                }else if(element.hasClass('add-sccp-sub-bg-image')){
                    element.parent().find('.ays-sccp-sub-bg-image-container').fadeIn();
                    element.hide();
                    element.parent().find('img#ays-sccp-sub-bg-img').attr('src', attachment.url);
                    element.next().val(attachment.url);
                }else if(element.hasClass('ays-edit-sccp-sub-bg-img')){
                    element.parent().find('.ays-sccp-sub-bg-image-container').fadeIn();
                    element.parent().find('img#ays-sccp-sub-bg-img').attr('src', attachment.url);
                    $(document).find('#ays_sccp_sub_bg_image').val(attachment.url);                    
                }
            }).open();

            return false;
        }

        function openSccpBcMediaUploader(e, element) {
            e.preventDefault();
            let aysUploader = wp.media({
                title: 'Upload',
                button: {
                    text: 'Upload'
                },
                library: {
                    type: 'image'
                },
                multiple: false
            }).on('select', function () {
                let attachment = aysUploader.state().get('selection').first().toJSON();
                if(element.hasClass('add-sccp-bc-bg-image')){
                    element.parent().find('.ays-sccp-bc-bg-image-container').fadeIn();
                    element.hide();
                    element.parent().find('img#ays-sccp-bc-bg-img').attr('src', attachment.url);
                    element.next().val(attachment.url);
                }else if(element.hasClass('ays-edit-sccp-bc-bg-img')){
                    element.parent().find('.ays-sccp-bc-bg-image-container').fadeIn();
                    element.parent().find('img#ays-sccp-bc-bg-img').attr('src', attachment.url);
                    $(document).find('#ays_sccp_bc_bg_image').val(attachment.url);                    
                }else if(element.hasClass('add-sccp-bc-icon-image')){
                    element.parent().find('.ays-sccp-bc-image-container').fadeIn();
                    element.hide();
                    element.parent().find('img#ays-sccp-bc-img').attr('src', attachment.url);
                    element.next().val(attachment.url);                    
                }else if(element.hasClass('ays-edit-sccp-bc-img')){
                    element.parent().find('.ays-sccp-bc-image-container').fadeIn();
                    element.parent().find('img#ays-sccp-bc-img').attr('src', attachment.url);
                    $(document).find('#ays_sccp_bc_icon_image').val(attachment.url);
                } 
            }).open();

            return false;
        }

        function submitOnce(subButton){
            var subLoader = subButton.parents('div').find('.ays_sccp_loader_box');
            if ( subLoader.hasClass("display_none") ) {
                subLoader.removeClass("display_none");
            }
            subLoader.css("padding-left" , "8px");
            subLoader.css("display" , "inline-flex");
            setTimeout(function() {
                $(document).find('.ays-sccp-save-comp').attr('disabled', true);
            }, 50);

            setTimeout(function() {
                $(document).find('.ays-sccp-save-comp').attr('disabled', false);
                subButton.parents('div').find('.ays_sccp_loader_box').css('display', 'none');
            }, 5000);
        }

        //Hide results
        $('.if-ays-sccp-hide-results').css("display", "flex").hide();
        if ($('#sccp_access_disable_js').prop('checked')) {
            $('.if-ays-sccp-hide-results').fadeIn();
        }
        $('#sccp_access_disable_js').on('change', function () {
            $('.if-ays-sccp-hide-results').fadeToggle();
        });

        //CSS Selector
        $('.if-ays-sccp-hide-css-input').css("display", "flex").hide();
        if ($('#sccp_exclude_css_selector').prop('checked')) {
            $('.if-ays-sccp-hide-css-input').fadeIn();
        }
        $('#sccp_exclude_css_selector').on('change', function () {
            $('.if-ays-sccp-hide-css-input').fadeToggle();
        });
        
        // Block Subscribe Description
        $(document).on('change', '.checkbox_show_hide', function(e){
            var b_id = $(this).parents('.blockcont_one').data('block_id');
            $('.if_desc_textarea_'+b_id).fadeToggle();
        });

        $(document).on('click', '.ays_confirm_del', function(e){            
            e.preventDefault();
            var confirm = window.confirm('Are you sure you want to delete this report?');
            if(confirm === true){
                window.location.replace($(this).attr('href'));
            }
        });

        // Submit buttons disableing with loader
        $(document).find('.ays-sccp-save-comp').on('click', function () {
            var $this = $(this);
            submitOnce($this);
        });

        $(document).keydown(function(event) {
            var editButton = $(document).find("input.ays-sccp-save-comp");
            if (!(event.which == 83 && event.ctrlKey) && !(event.which == 19)){
                return true;  
            }
            editButton.trigger("click");
            event.preventDefault();
            return false;
        });

        // Notice bar
        var toggle_ddmenu = $(document).find('.toggle_ddmenu');
        toggle_ddmenu.on('click', function () {
            var ddmenu = $(this).next();
            var state = ddmenu.attr('data-expanded');
            switch (state) {
                case 'true':
                    $(this).find('.ays_fa').css({
                        transform: 'rotate(0deg)'
                    });
                    ddmenu.attr('data-expanded', 'false');
                    break;
                case 'false':
                    $(this).find('.ays_fa').css({
                        transform: 'rotate(90deg)'
                    });
                    ddmenu.attr('data-expanded', 'true');
                    break;
            }
        });

        // Tabs 
        if($(document).find('.ays-top-menu').width() <= $(document).find('div.ays-top-tab-wrapper').width()){
            $(document).find('.ays_menu_left,.ays_menu_right').css('display', 'flex');
        }
        $(window).resize(function(){
            if($(document).find('.ays-top-menu').width() < $(document).find('div.ays-top-tab-wrapper').width()){
                $(document).find('.ays_menu_left,.ays_menu_right').css('display', 'flex');
            }else{
                $(document).find('.ays_menu_left,.ays_menu_right').css('display', 'none');
                $(document).find('div.ays-top-tab-wrapper').css('transform', 'translate(0px)');
            }
        });
        var menuItemWidths0 = [];
        var menuItemWidths = [];
        $(document).find('.ays-top-tab-wrapper .nav-tab').each(function(){
            var $this = $(this);
            menuItemWidths0.push($this.outerWidth());
        });

        for(var i = 0; i < menuItemWidths0.length; i+=2){
            if(menuItemWidths0.length <= i+1){
                menuItemWidths.push(menuItemWidths0[i]);
            }else{
                menuItemWidths.push(menuItemWidths0[i]+menuItemWidths0[i+1]);
            }
        }
        var menuItemWidth = 0;
        for(var i = 0; i < menuItemWidths.length; i++){
            menuItemWidth += menuItemWidths[i];
        }
        menuItemWidth = menuItemWidth / menuItemWidths.length;

        $(document).on('click', '.ays_menu_left', function(){
            var scroll = parseInt($(this).attr('data-scroll'));
            scroll -= menuItemWidth;
            if(scroll < 0){
                scroll = 0;
            }
            $(document).find('div.ays-top-tab-wrapper').css('transform', 'translate(-'+scroll+'px)');
            $(this).attr('data-scroll', scroll);
            $(document).find('.ays_menu_right').attr('data-scroll', scroll);
        });
        $(document).on('click', '.ays_menu_right', function(){
            var scroll = parseInt($(this).attr('data-scroll'));
            var howTranslate = $(document).find('div.ays-top-tab-wrapper').width() - $(document).find('.ays-top-menu').width();
            howTranslate += 7;
            if(scroll == -1){
                scroll = menuItemWidth;
            }
            scroll += menuItemWidth;
            if(scroll > howTranslate){
                scroll = Math.abs(howTranslate);
            }
            $(document).find('div.ays-top-tab-wrapper').css('transform', 'translate(-'+scroll+'px)');
            $(this).attr('data-scroll', scroll);
            $(document).find('.ays_menu_left').attr('data-scroll', scroll);
        });


         $(document).find('.nav-tab-wrapper a.nav-tab').on('click', function (e) {
            if(! $(this).hasClass('no-js')){
                let elemenetID = $(this).attr('href');
                let active_tab = $(this).attr('data-tab');
                $(document).find('.nav-tab-wrapper a.nav-tab').each(function () {
                    if ($(this).hasClass('nav-tab-active')) {
                        $(this).removeClass('nav-tab-active');
                    }
                });
                $(this).addClass('nav-tab-active');
                $(document).find('.ays-sccp-tab-content').each(function () {
                    if ($(this).hasClass('ays-sccp-tab-content-active'))
                        $(this).removeClass('ays-sccp-tab-content-active');
                });
                $(document).find("[name='ays_sccp_tab']").val(active_tab);
                $('.ays-sccp-tab-content' + elemenetID).addClass('ays-sccp-tab-content-active');
                e.preventDefault();
            }
        });


        var wp_editor_height = $(document).find('.sccp_wp_editor_height');

        if ( wp_editor_height.length > 0 ) {
            var wp_editor_height_val = wp_editor_height.val();
            if ( wp_editor_height_val != '' && wp_editor_height_val != 0 ) {
                var ays_sccp_wp_editor = setInterval( function() {
                    if (document.readyState === 'complete') {
                        $(document).find('.wp-editor-wrap .wp-editor-container iframe , .wp-editor-container textarea.wp-editor-area').css({
                            "height": wp_editor_height_val + 'px'
                        });
                        clearInterval(ays_sccp_wp_editor);
                    }
                } , 500);
            }
        }

        $(document).find('.ays-sccp-search-users-select').select2({
            placeholder: 'Select users',
            minimumInputLength: 1,
            allowClear: true,
            ajax: {
                url: sccp.ajax,
                dataType: 'json',
                data: function (response) {
                    var checkedUsers = $(document).find('.ays-sccp-search-users-select').val();
                    return {
                        action: 'ays_sccp_reports_user_search',
                        search: response.term,
                        val: checkedUsers,
                    };
                },
            }
        });

        $(document).on('change', '.ays_toggle_checkbox', function (e) {
            var state = $(this).prop('checked');
            var parent = $(this).parents('.ays_toggle_parent');
            
            if($(this).hasClass('ays_toggle_slide')){
                switch (state) {
                    case true:
                        parent.find('.ays_toggle_target').slideDown(250);
                        break;
                    case false:
                        parent.find('.ays_toggle_target').slideUp(250);
                        break;
                }
            }else{
                switch (state) {
                    case true:
                        parent.find('.ays_toggle_target').show(250);
                        break;
                    case false:
                        parent.find('.ays_toggle_target').hide(250);
                        break;
                }
            }
        });
        
        $(document).on('change', '.ays_toggle_select', function (e) {
            var state = $(this).val();
            var toggle = $(this).data('hide');
            var parent = $(this).parents('.ays_toggle_parent');
            
            if($(this).hasClass('ays_toggle_slide')){
                if (toggle == state) {
                    parent.find('.ays_toggle_target').slideUp(250);
                    parent.find('.ays_toggle_target_inverse').slideDown(150);
                }else{
                    parent.find('.ays_toggle_target').slideDown(150);
                    parent.find('.ays_toggle_target_inverse').slideUp(250);
                }
            }else{
                if (toggle == state) {
                    parent.find('.ays_toggle_target').hide(150);
                    parent.find('.ays_toggle_target_inverse').show(250);
                }else{
                    parent.find('.ays_toggle_target').show(250);
                    parent.find('.ays_toggle_target_inverse').hide(150);
                }
            }
        });

        $(document).on('change', '.ays_toggle', function (e) {
            var state = $(this).prop('checked');
            if($(this).hasClass('ays_toggle_slide')){
                switch (state) {
                    case true:
                        $(this).parents().eq(1).find('.ays_toggle_target').slideDown(250);
                        break;
                    case false:
                        $(this).parents().eq(1).find('.ays_toggle_target').slideUp(250);
                        break;
                }
            }else{
                switch (state) {
                    case true:
                        $(this).parents().eq(1).find('.ays_toggle_target').show(250);
                        break;
                    case false:
                        $(this).parents().eq(1).find('.ays_toggle_target').hide(250);
                        break;
                }
            }
        });

        /* 
        ========================================== 
            Background Gradient 
        ========================================== 
        */
        function toggleBackgrounGradient() {
            if($(document).find('input#ays_sccp_bg_image').val() == '') {
                var sccp_gradient_direction = $(document).find('#ays_sccp_gradient_direction').val();
                switch(sccp_gradient_direction) {
                    case "horizontal":
                        sccp_gradient_direction = "to right";
                        break;
                    case "diagonal_left_to_right":
                        sccp_gradient_direction = "to bottom right";
                        break;
                    case "diagonal_right_to_left":
                        sccp_gradient_direction = "to bottom left";
                        break;
                    default:
                        sccp_gradient_direction = "to bottom";
                }
                if($(document).find('input#ays_sccp_enable_background_gradient').prop('checked')){
                    $(document).find('.ays-tooltip-live-container').css({
                        'background-image': "linear-gradient(" + sccp_gradient_direction + ", " + $(document).find('input#ays-sccp-background-gradient-color-1').val() + ", " + $(document).find('input#ays-sccp-background-gradient-color-2').val()+")"
                    });
                }else{
                     $(document).find('.ays-tooltip-live-container').css({
                        'background-image': "none"
                     });
                }
            }
        }

        $(document).find('#ays_sccp_gradient_direction').on('change', function () {
            toggleBackgrounGradient();
        });

        toggleBackgrounGradient();
        $(document).find('input#ays_sccp_enable_background_gradient').on('change', function () {
            toggleBackgrounGradient();
        });


        var ays_sccp_box_gradient_color1_picker = {
            change: function (e) {
                setTimeout(function () {
                    toggleBackgrounGradient();
                }, 1);
            }
        };
        var ays_sccp_box_gradient_color2_picker = {
            change: function (e) {
                setTimeout(function () {
                    toggleBackgrounGradient();
                }, 1);
            }
        };
        

        $(document).find('#ays-sccp-background-gradient-color-1').wpColorPicker(ays_sccp_box_gradient_color1_picker);
        $(document).find('#ays-sccp-background-gradient-color-2').wpColorPicker(ays_sccp_box_gradient_color2_picker);

        var transformation_value = $(document).find('#ays_sccp_tooltip_text_transformation');

        if( transformation_value.val() != '' ){
            $(document).find('.ays_tooltip_container .ays-tooltip-live-container').css({'text-transform': transformation_value.val() });
        }

        $(document).on('change', '#ays_sccp_tooltip_text_transformation', function (e) {
            $(document).find('.ays_tooltip_container .ays-tooltip-live-container').css({'text-transform': $(this).val() });
        });

        $(document).on('mouseover', '.ays-dashicons', function(){
            var allRateStars = $(document).find('.ays-dashicons');
            var index = allRateStars.index(this);
            allRateStars.removeClass('ays-dashicons-star-filled').addClass('ays-dashicons-star-empty');
            for (var i = 0; i <= index; i++) {
                allRateStars.eq(i).removeClass('ays-dashicons-star-empty').addClass('ays-dashicons-star-filled');
            }
        });
        
        $(document).on('mouseleave', '.ays-rated-link', function(){
            $(document).find('.ays-dashicons').removeClass('ays-dashicons-star-filled').addClass('ays-dashicons-star-empty');                
        });

        // Select message vars sccp page | Start
        $(document).find('.ays-sccp-message-vars-icon').on('click', function(e){
            $(this).parents(".ays-sccp-message-vars-box").find(".ays-sccp-message-vars-data").toggle('fast');
        });
        
        $(document).on( "click" , function(e){
            if($(e.target).closest('.ays-sccp-message-vars-box').length != 0){
            } 
            else{
                $(document).find(".ays-sccp-message-vars-box .ays-sccp-message-vars-data").hide('fast');
            }
        });

        $(document).find('.ays-sccp-message-vars-each-data').on('click', function(e){
            var _this  = $(this);
            var parent = _this.parents('.ays-sccp-desc-message-vars-parent');

            var textarea   = parent.find('textarea.ays-textarea');
            var textareaID = textarea.attr('id');

            var messageVar = _this.find(".ays-sccp-message-vars-each-var").val();
            
            if ( parent.find("#wp-"+ textareaID +"-wrap").hasClass("tmce-active") ){
                window.tinyMCE.get(textareaID).setContent( window.tinyMCE.get(textareaID).getContent() + messageVar + " " );
            }else{
                $(document).find('#'+textareaID).append( " " + messageVar + " ");
            }
        });
        /* Select message vars sccp page | End */

        $(document).find('.ays-sccp-accordion-arrow-box').on('click', function(e) {
            var _this = $(this);
            openSccpCloseAccordion( _this );
        });

        function openSccpCloseAccordion( _this ){
            var parent = _this.closest(".ays-sccp-accordion-options-main-container");
            var container = parent.find('.ays-sccp-accordion-options-box');

            if( parent.attr('data-collapsed') === 'true' ){
                setTimeout( function() {
                    container.slideDown();
                    parent.find('.ays-sccp-accordion-arrow-box .ays-sccp-accordion-arrow').removeClass('ays-sccp-accordion-arrow-right').addClass('ays-sccp-accordion-arrow-down');
                    parent.attr('data-collapsed', 'false');
                    parent.find('.ays-sccp-accordion-options-main-container').attr('data-collapsed', 'false');
                }, 150);
            }else{
                setTimeout( function() {
                    container.slideUp();
                    parent.find('.ays-sccp-accordion-arrow-box .ays-sccp-accordion-arrow').removeClass('ays-sccp-accordion-arrow-down').addClass('ays-sccp-accordion-arrow-right');
                    parent.attr('data-collapsed', 'true');
                    parent.find('.ays-sccp-accordion-options-main-container').attr('data-collapsed', 'true');
                }, 150);
            }
        }

        $(document).on("click", "#ays-sccp-dismiss-buttons-content .ays-button, #ays-sccp-dismiss-buttons-content-black-friday .ays-button-black-friday, #ays-sccp-dismiss-buttons-content-helloween .ays-button-helloween", function(e){
            e.preventDefault();

            var $this = $(this);
            var thisParent  = $this.parents("#ays-sccp-dismiss-buttons-content");
            // var thisParent  = $this.parents("#ays-sccp-dismiss-buttons-content-helloween");
            // var thisParent  = $this.parents("#ays-sccp-dismiss-buttons-content-black-friday");
            var mainParent  = $this.parents("div.ays_sccp_dicount_info");
            var closeButton = mainParent.find("button.notice-dismiss");

            var attr_plugin = $this.attr('data-plugin');
            var wp_nonce    = thisParent.find('#secure-copy-content-protection-sale-banner').val();

            var data = {
                action: 'ays_sccp_dismiss_button',
                _ajax_nonce: wp_nonce,
            };

            $.ajax({
                url: sccp.ajax,
                method: 'post',
                dataType: 'json',
                data: data,
                success: function (response) {
                    if( response.status ){
                        closeButton.trigger('click');
                    } else {
                        swal.fire({
                            type: 'info',
                            html: "<h2>"+ sccpBannerLangObj.errorMsg +"</h2><br><h6>"+ sccpBannerLangObj.somethingWentWrong +"</h6>"
                        }).then(function(res) {
                            closeButton.trigger('click');
                        });
                    }
                },
                error: function(){
                    swal.fire({
                        type: 'info',
                        html: "<h2>"+ sccpBannerLangObj.errorMsg +"</h2><br><h6>"+ sccpBannerLangObj.somethingWentWrong +"</h6>"
                    }).then(function(res) {
                        closeButton.trigger('click');
                    });
                }
            });
        });

        $(document).on("click", ".ays-sccp-cards-block .ays-sccp-card__footer button.status-missing", function(e){
            var $this = $(this);
            var thisParent = $this.parents(".ays-sccp-cards-block");

            $this.prop('disabled', true);
            $this.addClass('disabled');

            var loader_html = '<i class="fa fa-spinner fa-spin" aria-hidden="true"></i>';

            $this.html(loader_html);

            var attr_plugin = $this.attr('data-plugin');
            var wp_nonce = thisParent.find('#ays_sccp_ajax_install_plugin_nonce').val();

            var data = {
                action: 'ays_sccp_install_plugin',
                _ajax_nonce: wp_nonce,
                plugin: attr_plugin,
                type: 'plugin'
            };

            $.ajax({
                url: sccp.ajax,
                method: 'post',
                dataType: 'json',
                data: data,
                success: function (response) {
                    if (response.success) {
                        swal.fire({
                            type: 'success',
                            html: "<h4>"+ response['data']['msg'] +"</h4>"
                        }).then( function(res) {
                            if ( $this.hasClass('status-missing') ) {
                                $this.removeClass('status-missing');
                            }
                            $this.text(sccp.activated);
                            $this.addClass('status-active');
                        });
                    }
                    else {
                        swal.fire({
                            type: 'info',
                            html: "<h4>"+ response['data'][0]['message'] +"</h4>"
                        }).then( function(res) {
                            $this.text(sccp.errorMsg);
                        });
                    }
                },
                error: function(){
                    swal.fire({
                        type: 'info',
                        html: "<h2>"+ sccp.loadResource +"</h2><br><h6>"+ sccp.somethingWentWrong +"</h6>"
                    }).then( function(res) {
                        $this.text(sccp.errorMsg);
                    });                
                }
            });
        });

        $(document).on("click", ".ays-sccp-cards-block .ays-sccp-card__footer button.status-installed", function(e){
            var $this = $(this);
            var thisParent = $this.parents(".ays-sccp-cards-block");

            $this.prop('disabled', true);
            $this.addClass('disabled');

            var loader_html = '<i class="fa fa-spinner fa-spin" aria-hidden="true"></i>';

            $this.html(loader_html);

            var attr_plugin = $this.attr('data-plugin');
            var wp_nonce = thisParent.find('#ays_sccp_ajax_install_plugin_nonce').val();

            var data = {
                action: 'ays_sccp_activate_plugin',
                _ajax_nonce: wp_nonce,
                plugin: attr_plugin,
                type: 'plugin'
            };

            $.ajax({
                url: sccp.ajax,
                method: 'post',
                dataType: 'json',
                data: data,
                success: function (response) {
                    if( response.success ){
                        swal.fire({
                            type: 'success',
                            html: "<h4>"+ response['data'] +"</h4>"
                        }).then( function(res) {
                            if ( $this.hasClass('status-installed') ) {
                                $this.removeClass('status-installed');
                            }
                            $this.text(sccp.activated);
                            $this.addClass('status-active disabled');
                        });
                    } else {
                        swal.fire({
                            type: 'info',
                            html: "<h4>"+ response['data'][0]['message'] +"</h4>"
                        });
                    }
                },
                error: function(){
                    swal.fire({
                        type: 'info',
                        html: "<h2>"+ sccp.loadResource +"</h2><br><h6>"+ sccp.somethingWentWrong +"</h6>"
                    }).then( function(res) {
                        $this.text(sccp.errorMsg);
                    });                
                }
            });
        });

    });
})(jQuery);
