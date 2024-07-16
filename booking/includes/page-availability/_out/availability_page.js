"use strict";

/**
 * Request Object
 * Here we can  define Search parameters and Update it later,  when  some parameter was changed
 *
 */
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
var wpbc_ajx_availability = function (obj, $) {
  // Secure parameters for Ajax	------------------------------------------------------------------------------------
  var p_secure = obj.security_obj = obj.security_obj || {
    user_id: 0,
    nonce: '',
    locale: ''
  };
  obj.set_secure_param = function (param_key, param_val) {
    p_secure[param_key] = param_val;
  };
  obj.get_secure_param = function (param_key) {
    return p_secure[param_key];
  };

  // Listing Search parameters	------------------------------------------------------------------------------------
  var p_listing = obj.search_request_obj = obj.search_request_obj || {
    // sort            : "booking_id",
    // sort_type       : "DESC",
    // page_num        : 1,
    // page_items_count: 10,
    // create_date     : "",
    // keyword         : "",
    // source          : ""
  };
  obj.search_set_all_params = function (request_param_obj) {
    p_listing = request_param_obj;
  };
  obj.search_get_all_params = function () {
    return p_listing;
  };
  obj.search_get_param = function (param_key) {
    return p_listing[param_key];
  };
  obj.search_set_param = function (param_key, param_val) {
    // if ( Array.isArray( param_val ) ){
    // 	param_val = JSON.stringify( param_val );
    // }
    p_listing[param_key] = param_val;
  };
  obj.search_set_params_arr = function (params_arr) {
    _.each(params_arr, function (p_val, p_key, p_data) {
      // Define different Search  parameters for request
      this.search_set_param(p_key, p_val);
    });
  };

  // Other parameters 			------------------------------------------------------------------------------------
  var p_other = obj.other_obj = obj.other_obj || {};
  obj.set_other_param = function (param_key, param_val) {
    p_other[param_key] = param_val;
  };
  obj.get_other_param = function (param_key) {
    return p_other[param_key];
  };
  return obj;
}(wpbc_ajx_availability || {}, jQuery);
var wpbc_ajx_bookings = [];

/**
 *   Show Content  ---------------------------------------------------------------------------------------------- */

/**
 * Show Content - Calendar and UI elements
 *
 * @param ajx_data_arr
 * @param ajx_search_params
 * @param ajx_cleaned_params
 */
function wpbc_ajx_availability__page_content__show(ajx_data_arr, ajx_search_params, ajx_cleaned_params) {
  var template__availability_main_page_content = wp.template('wpbc_ajx_availability_main_page_content');

  // Content
  jQuery(wpbc_ajx_availability.get_other_param('listing_container')).html(template__availability_main_page_content({
    'ajx_data': ajx_data_arr,
    'ajx_search_params': ajx_search_params,
    // $_REQUEST[ 'search_params' ]
    'ajx_cleaned_params': ajx_cleaned_params
  }));
  jQuery('.wpbc_processing.wpbc_spin').parent().parent().parent().parent('[id^="wpbc_notice_"]').hide();
  // Load calendar
  wpbc_ajx_availability__calendar__show({
    'resource_id': ajx_cleaned_params.resource_id,
    'ajx_nonce_calendar': ajx_data_arr.ajx_nonce_calendar,
    'ajx_data_arr': ajx_data_arr,
    'ajx_cleaned_params': ajx_cleaned_params
  });

  /**
   * Trigger for dates selection in the booking form
   *
   * jQuery( wpbc_ajx_availability.get_other_param( 'listing_container' ) ).on('wpbc_page_content_loaded', function(event, ajx_data_arr, ajx_search_params , ajx_cleaned_params) { ... } );
   */
  jQuery(wpbc_ajx_availability.get_other_param('listing_container')).trigger('wpbc_page_content_loaded', [ajx_data_arr, ajx_search_params, ajx_cleaned_params]);
}

/**
 * Show inline month view calendar              with all predefined CSS (sizes and check in/out,  times containers)
 * @param {obj} calendar_params_arr
			{
				'resource_id'       	: ajx_cleaned_params.resource_id,
				'ajx_nonce_calendar'	: ajx_data_arr.ajx_nonce_calendar,
				'ajx_data_arr'          : ajx_data_arr = { ajx_booking_resources:[], booked_dates: {}, resource_unavailable_dates:[], season_availability:{},.... }
				'ajx_cleaned_params'    : {
											calendar__days_selection_mode: "dynamic"
											calendar__start_week_day: "0"
											calendar__timeslot_day_bg_as_available: ""
											calendar__view__cell_height: ""
											calendar__view__months_in_row: 4
											calendar__view__visible_months: 12
											calendar__view__width: "100%"

											dates_availability: "unavailable"
											dates_selection: "2023-03-14 ~ 2023-03-16"
											do_action: "set_availability"
											resource_id: 1
											ui_clicked_element_id: "wpbc_availability_apply_btn"
											ui_usr__availability_selected_toolbar: "info"
								  		 }
			}
*/
function wpbc_ajx_availability__calendar__show(calendar_params_arr) {
  // Update nonce
  jQuery('#ajx_nonce_calendar_section').html(calendar_params_arr.ajx_nonce_calendar);

  //------------------------------------------------------------------------------------------------------------------
  // Update bookings
  if ('undefined' == typeof wpbc_ajx_bookings[calendar_params_arr.resource_id]) {
    wpbc_ajx_bookings[calendar_params_arr.resource_id] = [];
  }
  wpbc_ajx_bookings[calendar_params_arr.resource_id] = calendar_params_arr['ajx_data_arr']['booked_dates'];

  //------------------------------------------------------------------------------------------------------------------
  /**
   * Define showing mouse over tooltip on unavailable dates
   * It's defined, when calendar REFRESHED (change months or days selection) loaded in jquery.datepick.wpbc.9.0.js :
   * 		$( 'body' ).trigger( 'wpbc_datepick_inline_calendar_refresh', ...		//FixIn: 9.4.4.13
   */
  jQuery('body').on('wpbc_datepick_inline_calendar_refresh', function (event, resource_id, inst) {
    // inst.dpDiv  it's:  <div class="datepick-inline datepick-multi" style="width: 17712px;">....</div>
    inst.dpDiv.find('.season_unavailable,.before_after_unavailable,.weekdays_unavailable').on('mouseover', function (this_event) {
      // also available these vars: 	resource_id, jCalContainer, inst
      var jCell = jQuery(this_event.currentTarget);
      wpbc_avy__show_tooltip__for_element(jCell, calendar_params_arr['ajx_data_arr']['popover_hints']);
    });
  });

  //------------------------------------------------------------------------------------------------------------------
  /**
   * Define height of the calendar  cells, 	and  mouse over tooltips at  some unavailable dates
   * It's defined, when calendar loaded in jquery.datepick.wpbc.9.0.js :
   * 		$( 'body' ).trigger( 'wpbc_datepick_inline_calendar_loaded', ...		//FixIn: 9.4.4.12
   */
  jQuery('body').on('wpbc_datepick_inline_calendar_loaded', function (event, resource_id, jCalContainer, inst) {
    // Remove highlight day for today  date
    jQuery('.datepick-days-cell.datepick-today.datepick-days-cell-over').removeClass('datepick-days-cell-over');

    // Set height of calendar  cells if defined this option
    if ('' !== calendar_params_arr.ajx_cleaned_params.calendar__view__cell_height) {
      jQuery('head').append('<style type="text/css">' + '.hasDatepick .datepick-inline .datepick-title-row th, ' + '.hasDatepick .datepick-inline .datepick-days-cell {' + 'height: ' + calendar_params_arr.ajx_cleaned_params.calendar__view__cell_height + ' !important;' + '}' + '</style>');
    }

    // Define showing mouse over tooltip on unavailable dates
    jCalContainer.find('.season_unavailable,.before_after_unavailable,.weekdays_unavailable').on('mouseover', function (this_event) {
      // also available these vars: 	resource_id, jCalContainer, inst
      var jCell = jQuery(this_event.currentTarget);
      wpbc_avy__show_tooltip__for_element(jCell, calendar_params_arr['ajx_data_arr']['popover_hints']);
    });
  });

  //------------------------------------------------------------------------------------------------------------------
  // Define width of entire calendar
  var width = 'width:' + calendar_params_arr.ajx_cleaned_params.calendar__view__width + ';'; // var width = 'width:100%;max-width:100%;';

  if (undefined != calendar_params_arr.ajx_cleaned_params.calendar__view__max_width && '' != calendar_params_arr.ajx_cleaned_params.calendar__view__max_width) {
    width += 'max-width:' + calendar_params_arr.ajx_cleaned_params.calendar__view__max_width + ';';
  } else {
    width += 'max-width:' + calendar_params_arr.ajx_cleaned_params.calendar__view__months_in_row * 341 + 'px;';
  }

  //------------------------------------------------------------------------------------------------------------------
  // Add calendar container: "Calendar is loading..."  and textarea
  jQuery('.wpbc_ajx_avy__calendar').html('<div class="' + ' bk_calendar_frame' + ' months_num_in_row_' + calendar_params_arr.ajx_cleaned_params.calendar__view__months_in_row + ' cal_month_num_' + calendar_params_arr.ajx_cleaned_params.calendar__view__visible_months + ' ' + calendar_params_arr.ajx_cleaned_params.calendar__timeslot_day_bg_as_available // 'wpbc_timeslot_day_bg_as_available' || ''
  + '" ' + 'style="' + width + '">' + '<div id="calendar_booking' + calendar_params_arr.resource_id + '">' + 'Calendar is loading...' + '</div>' + '</div>' + '<textarea      id="date_booking' + calendar_params_arr.resource_id + '"' + ' name="date_booking' + calendar_params_arr.resource_id + '"' + ' autocomplete="off"' + ' style="display:none;width:100%;height:10em;margin:2em 0 0;"></textarea>');

  //------------------------------------------------------------------------------------------------------------------
  var cal_param_arr = {
    'html_id': 'calendar_booking' + calendar_params_arr.ajx_cleaned_params.resource_id,
    'text_id': 'date_booking' + calendar_params_arr.ajx_cleaned_params.resource_id,
    'calendar__start_week_day': calendar_params_arr.ajx_cleaned_params.calendar__start_week_day,
    'calendar__view__visible_months': calendar_params_arr.ajx_cleaned_params.calendar__view__visible_months,
    'calendar__days_selection_mode': calendar_params_arr.ajx_cleaned_params.calendar__days_selection_mode,
    'resource_id': calendar_params_arr.ajx_cleaned_params.resource_id,
    'ajx_nonce_calendar': calendar_params_arr.ajx_data_arr.ajx_nonce_calendar,
    'booked_dates': calendar_params_arr.ajx_data_arr.booked_dates,
    'season_availability': calendar_params_arr.ajx_data_arr.season_availability,
    'resource_unavailable_dates': calendar_params_arr.ajx_data_arr.resource_unavailable_dates,
    'popover_hints': calendar_params_arr['ajx_data_arr']['popover_hints'] // {'season_unavailable':'...','weekdays_unavailable':'...','before_after_unavailable':'...',}
  };
  wpbc_show_inline_booking_calendar(cal_param_arr);

  //------------------------------------------------------------------------------------------------------------------
  /**
   * On click AVAILABLE |  UNAVAILABLE button  in widget	-	need to  change help dates text
   */
  jQuery('.wpbc_radio__set_days_availability').on('change', function (event, resource_id, inst) {
    wpbc__inline_booking_calendar__on_days_select(jQuery('#' + cal_param_arr.text_id).val(), cal_param_arr);
  });

  // Show 	'Select days  in calendar then select Available  /  Unavailable status and click Apply availability button.'
  jQuery('#wpbc_toolbar_dates_hint').html('<div class="ui_element"><span class="wpbc_ui_control wpbc_ui_addon wpbc_help_text" >' + cal_param_arr.popover_hints.toolbar_text + '</span></div>');
}

/**
 * 	Load Datepick Inline calendar
 *
 * @param calendar_params_arr		example:{
											'html_id'           : 'calendar_booking' + calendar_params_arr.ajx_cleaned_params.resource_id,
											'text_id'           : 'date_booking' + calendar_params_arr.ajx_cleaned_params.resource_id,

											'calendar__start_week_day': 	  calendar_params_arr.ajx_cleaned_params.calendar__start_week_day,
											'calendar__view__visible_months': calendar_params_arr.ajx_cleaned_params.calendar__view__visible_months,
											'calendar__days_selection_mode':  calendar_params_arr.ajx_cleaned_params.calendar__days_selection_mode,

											'resource_id'        : calendar_params_arr.ajx_cleaned_params.resource_id,
											'ajx_nonce_calendar' : calendar_params_arr.ajx_data_arr.ajx_nonce_calendar,
											'booked_dates'       : calendar_params_arr.ajx_data_arr.booked_dates,
											'season_availability': calendar_params_arr.ajx_data_arr.season_availability,

											'resource_unavailable_dates' : calendar_params_arr.ajx_data_arr.resource_unavailable_dates
										}
 * @returns {boolean}
 */
function wpbc_show_inline_booking_calendar(calendar_params_arr) {
  if (0 === jQuery('#' + calendar_params_arr.html_id).length // If calendar DOM element not exist then exist
  || true === jQuery('#' + calendar_params_arr.html_id).hasClass('hasDatepick') // If the calendar with the same Booking resource already  has been activated, then exist.
  ) {
    return false;
  }

  //------------------------------------------------------------------------------------------------------------------
  // Configure and show calendar
  jQuery('#' + calendar_params_arr.html_id).text('');
  jQuery('#' + calendar_params_arr.html_id).datepick({
    beforeShowDay: function beforeShowDay(date) {
      return wpbc__inline_booking_calendar__apply_css_to_days(date, calendar_params_arr, this);
    },
    onSelect: function onSelect(date) {
      jQuery('#' + calendar_params_arr.text_id).val(date);
      //wpbc_blink_element('.wpbc_widget_available_unavailable', 3, 220);
      return wpbc__inline_booking_calendar__on_days_select(date, calendar_params_arr, this);
    },
    onHover: function onHover(value, date) {
      //wpbc_avy__prepare_tooltip__in_calendar( value, date, calendar_params_arr, this );

      return wpbc__inline_booking_calendar__on_days_hover(value, date, calendar_params_arr, this);
    },
    onChangeMonthYear: null,
    showOn: 'both',
    numberOfMonths: calendar_params_arr.calendar__view__visible_months,
    stepMonths: 1,
    prevText: '&laquo;',
    nextText: '&raquo;',
    dateFormat: 'yy-mm-dd',
    // 'dd.mm.yy',
    changeMonth: false,
    changeYear: false,
    minDate: 0,
    //null,  //Scroll as long as you need
    maxDate: '10y',
    // minDate: new Date(2020, 2, 1), maxDate: new Date(2020, 9, 31), 	// Ability to set any  start and end date in calendar
    showStatus: false,
    closeAtTop: false,
    firstDay: calendar_params_arr.calendar__start_week_day,
    gotoCurrent: false,
    hideIfNoPrevNext: true,
    multiSeparator: ', ',
    multiSelect: 'dynamic' == calendar_params_arr.calendar__days_selection_mode ? 0 : 365,
    // Maximum number of selectable dates:	 Single day = 0,  multi days = 365
    rangeSelect: 'dynamic' == calendar_params_arr.calendar__days_selection_mode,
    rangeSeparator: ' ~ ',
    //' - ',
    // showWeeks: true,
    useThemeRoller: false
  });
  return true;
}

/**
 * Apply CSS to calendar date cells
 *
 * @param date					-  JavaScript Date Obj:  		Mon Dec 11 2023 00:00:00 GMT+0200 (Eastern European Standard Time)
 * @param calendar_params_arr	-  Calendar Settings Object:  	{
																  "html_id": "calendar_booking4",
																  "text_id": "date_booking4",
																  "calendar__start_week_day": 1,
																  "calendar__view__visible_months": 12,
																  "resource_id": 4,
																  "ajx_nonce_calendar": "<input type=\"hidden\" ... />",
																  "booked_dates": {
																	"12-28-2022": [
																	  {
																		"booking_date": "2022-12-28 00:00:00",
																		"approved": "1",
																		"booking_id": "26"
																	  }
																	], ...
																	}
																	'season_availability':{
																		"2023-01-09": true,
																		"2023-01-10": true,
																		"2023-01-11": true, ...
																	}
																  }
																}
 * @param datepick_this			- this of datepick Obj
 *
 * @returns [boolean,string]	- [ {true -available | false - unavailable}, 'CSS classes for calendar day cell' ]
 */
function wpbc__inline_booking_calendar__apply_css_to_days(date, calendar_params_arr, datepick_this) {
  var today_date = new Date(_wpbc.get_other_param('today_arr')[0], parseInt(_wpbc.get_other_param('today_arr')[1]) - 1, _wpbc.get_other_param('today_arr')[2], 0, 0, 0);
  var class_day = date.getMonth() + 1 + '-' + date.getDate() + '-' + date.getFullYear(); // '1-9-2023'
  var sql_class_day = wpbc__get__sql_class_date(date); // '2023-01-09'

  var css_date__standard = 'cal4date-' + class_day;
  var css_date__additional = ' wpbc_weekday_' + date.getDay() + ' ';

  //--------------------------------------------------------------------------------------------------------------

  // WEEKDAYS :: Set unavailable week days from - Settings General page in "Availability" section
  for (var i = 0; i < _wpbc.get_other_param('availability__week_days_unavailable').length; i++) {
    if (date.getDay() == _wpbc.get_other_param('availability__week_days_unavailable')[i]) {
      return [!!false, css_date__standard + ' date_user_unavailable' + ' weekdays_unavailable'];
    }
  }

  // BEFORE_AFTER :: Set unavailable days Before / After the Today date
  if (wpbc_dates__days_between(date, today_date) < parseInt(_wpbc.get_other_param('availability__unavailable_from_today')) || parseInt('0' + parseInt(_wpbc.get_other_param('availability__available_from_today'))) > 0 && wpbc_dates__days_between(date, today_date) > parseInt('0' + parseInt(_wpbc.get_other_param('availability__available_from_today')))) {
    return [!!false, css_date__standard + ' date_user_unavailable' + ' before_after_unavailable'];
  }

  // SEASONS ::  					Booking > Resources > Availability page
  var is_date_available = calendar_params_arr.season_availability[sql_class_day];
  if (false === is_date_available) {
    //FixIn: 9.5.4.4
    return [!!false, css_date__standard + ' date_user_unavailable' + ' season_unavailable'];
  }

  // RESOURCE_UNAVAILABLE ::   	Booking > Availability page
  if (wpdev_in_array(calendar_params_arr.resource_unavailable_dates, sql_class_day)) {
    is_date_available = false;
  }
  if (false === is_date_available) {
    //FixIn: 9.5.4.4
    return [!false, css_date__standard + ' date_user_unavailable' + ' resource_unavailable'];
  }

  //--------------------------------------------------------------------------------------------------------------

  //--------------------------------------------------------------------------------------------------------------

  // Is any bookings in this date ?
  if ('undefined' !== typeof calendar_params_arr.booked_dates[class_day]) {
    var bookings_in_date = calendar_params_arr.booked_dates[class_day];
    if ('undefined' !== typeof bookings_in_date['sec_0']) {
      // "Full day" booking  -> (seconds == 0)

      css_date__additional += '0' === bookings_in_date['sec_0'].approved ? ' date2approve ' : ' date_approved '; // Pending = '0' |  Approved = '1'
      css_date__additional += ' full_day_booking';
      return [!false, css_date__standard + css_date__additional];
    } else if (Object.keys(bookings_in_date).length > 0) {
      // "Time slots" Bookings

      var is_approved = true;
      _.each(bookings_in_date, function (p_val, p_key, p_data) {
        if (!parseInt(p_val.approved)) {
          is_approved = false;
        }
        var ts = p_val.booking_date.substring(p_val.booking_date.length - 1);
        if (true === _wpbc.get_other_param('is_enabled_change_over')) {
          if (ts == '1') {
            css_date__additional += ' check_in_time' + (parseInt(p_val.approved) ? ' check_in_time_date_approved' : ' check_in_time_date2approve');
          }
          if (ts == '2') {
            css_date__additional += ' check_out_time' + (parseInt(p_val.approved) ? ' check_out_time_date_approved' : ' check_out_time_date2approve');
          }
        }
      });
      if (!is_approved) {
        css_date__additional += ' date2approve timespartly';
      } else {
        css_date__additional += ' date_approved timespartly';
      }
      if (!_wpbc.get_other_param('is_enabled_change_over')) {
        css_date__additional += ' times_clock';
      }
    }
  }

  //--------------------------------------------------------------------------------------------------------------

  return [true, css_date__standard + css_date__additional + ' date_available'];
}

/**
 * Apply some CSS classes, when we mouse over specific dates in calendar
 * @param value
 * @param date					-  JavaScript Date Obj:  		Mon Dec 11 2023 00:00:00 GMT+0200 (Eastern European Standard Time)
 * @param calendar_params_arr	-  Calendar Settings Object:  	{
																  "html_id": "calendar_booking4",
																  "text_id": "date_booking4",
																  "calendar__start_week_day": 1,
																  "calendar__view__visible_months": 12,
																  "resource_id": 4,
																  "ajx_nonce_calendar": "<input type=\"hidden\" ... />",
																  "booked_dates": {
																	"12-28-2022": [
																	  {
																		"booking_date": "2022-12-28 00:00:00",
																		"approved": "1",
																		"booking_id": "26"
																	  }
																	], ...
																	}
																	'season_availability':{
																		"2023-01-09": true,
																		"2023-01-10": true,
																		"2023-01-11": true, ...
																	}
																  }
																}
 * @param datepick_this			- this of datepick Obj
 *
 * @returns {boolean}
 */
function wpbc__inline_booking_calendar__on_days_hover(value, date, calendar_params_arr, datepick_this) {
  if (null === date) {
    jQuery('.datepick-days-cell-over').removeClass('datepick-days-cell-over'); // clear all highlight days selections
    return false;
  }
  var inst = jQuery.datepick._getInst(document.getElementById('calendar_booking' + calendar_params_arr.resource_id));
  if (1 == inst.dates.length // If we have one selected date
  && 'dynamic' === calendar_params_arr.calendar__days_selection_mode // while have range days selection mode
  ) {
    var td_class;
    var td_overs = [];
    var is_check = true;
    var selceted_first_day = new Date();
    selceted_first_day.setFullYear(inst.dates[0].getFullYear(), inst.dates[0].getMonth(), inst.dates[0].getDate()); //Get first Date

    while (is_check) {
      td_class = selceted_first_day.getMonth() + 1 + '-' + selceted_first_day.getDate() + '-' + selceted_first_day.getFullYear();
      td_overs[td_overs.length] = '#calendar_booking' + calendar_params_arr.resource_id + ' .cal4date-' + td_class; // add to array for later make selection by class

      if (date.getMonth() == selceted_first_day.getMonth() && date.getDate() == selceted_first_day.getDate() && date.getFullYear() == selceted_first_day.getFullYear() || selceted_first_day > date) {
        is_check = false;
      }
      selceted_first_day.setFullYear(selceted_first_day.getFullYear(), selceted_first_day.getMonth(), selceted_first_day.getDate() + 1);
    }

    // Highlight Days
    for (var i = 0; i < td_overs.length; i++) {
      // add class to all elements
      jQuery(td_overs[i]).addClass('datepick-days-cell-over');
    }
    return true;
  }
  return true;
}

/**
 * On DAYs selection in calendar
 *
 * @param dates_selection		-  string:			 '2023-03-07 ~ 2023-03-07' or '2023-04-10, 2023-04-12, 2023-04-02, 2023-04-04'
 * @param calendar_params_arr	-  Calendar Settings Object:  	{
																  "html_id": "calendar_booking4",
																  "text_id": "date_booking4",
																  "calendar__start_week_day": 1,
																  "calendar__view__visible_months": 12,
																  "resource_id": 4,
																  "ajx_nonce_calendar": "<input type=\"hidden\" ... />",
																  "booked_dates": {
																	"12-28-2022": [
																	  {
																		"booking_date": "2022-12-28 00:00:00",
																		"approved": "1",
																		"booking_id": "26"
																	  }
																	], ...
																	}
																	'season_availability':{
																		"2023-01-09": true,
																		"2023-01-10": true,
																		"2023-01-11": true, ...
																	}
																  }
																}
 * @param datepick_this			- this of datepick Obj
 *
 * @returns boolean
 */
function wpbc__inline_booking_calendar__on_days_select(dates_selection, calendar_params_arr) {
  var datepick_this = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;
  var inst = jQuery.datepick._getInst(document.getElementById('calendar_booking' + calendar_params_arr.resource_id));
  var dates_arr = []; //  [ "2023-04-09", "2023-04-10", "2023-04-11" ]

  if (-1 !== dates_selection.indexOf('~')) {
    // Range Days

    dates_arr = wpbc_get_dates_arr__from_dates_range_js({
      'dates_separator': ' ~ ',
      //  ' ~ '
      'dates': dates_selection // '2023-04-04 ~ 2023-04-07'
    });
  } else {
    // Multiple Days
    dates_arr = wpbc_get_dates_arr__from_dates_comma_separated_js({
      'dates_separator': ', ',
      //  ', '
      'dates': dates_selection // '2023-04-10, 2023-04-12, 2023-04-02, 2023-04-04'
    });
  }
  wpbc_avy_after_days_selection__show_help_info({
    'calendar__days_selection_mode': calendar_params_arr.calendar__days_selection_mode,
    'dates_arr': dates_arr,
    'dates_click_num': inst.dates.length,
    'popover_hints': calendar_params_arr.popover_hints
  });
  return true;
}

/**
 * Show help info at the top  toolbar about selected dates and future actions
 *
 * @param params
 * 					Example 1:  {
									calendar__days_selection_mode: "dynamic",
									dates_arr:  [ "2023-04-03" ],
									dates_click_num: 1
									'popover_hints'					: calendar_params_arr.popover_hints
								}
 * 					Example 2:  {
									calendar__days_selection_mode: "dynamic"
									dates_arr: Array(10) [ "2023-04-03", "2023-04-04", "2023-04-05", … ]
									dates_click_num: 2
									'popover_hints'					: calendar_params_arr.popover_hints
								}
 */
function wpbc_avy_after_days_selection__show_help_info(params) {
  // console.log( params );	//		[ "2023-04-09", "2023-04-10", "2023-04-11" ]

  var message, color;
  if (jQuery('#ui_btn_avy__set_days_availability__available').is(':checked')) {
    message = params.popover_hints.toolbar_text_available; //'Set dates _DATES_ as _HTML_ available.';
    color = '#11be4c';
  } else {
    message = params.popover_hints.toolbar_text_unavailable; //'Set dates _DATES_ as _HTML_ unavailable.';
    color = '#e43939';
  }
  message = '<span>' + message + '</span>';
  var first_date = params['dates_arr'][0];
  var last_date = 'dynamic' == params.calendar__days_selection_mode ? params['dates_arr'][params['dates_arr'].length - 1] : params['dates_arr'].length > 1 ? params['dates_arr'][1] : '';
  first_date = jQuery.datepick.formatDate('dd M, yy', new Date(first_date + 'T00:00:00'));
  last_date = jQuery.datepick.formatDate('dd M, yy', new Date(last_date + 'T00:00:00'));
  if ('dynamic' == params.calendar__days_selection_mode) {
    if (1 == params.dates_click_num) {
      last_date = '___________';
    } else {
      if ('first_time' == jQuery('.wpbc_ajx_availability_container').attr('wpbc_loaded')) {
        jQuery('.wpbc_ajx_availability_container').attr('wpbc_loaded', 'done');
        wpbc_blink_element('.wpbc_widget_available_unavailable', 3, 220);
      }
    }
    message = message.replace('_DATES_', '</span>'
    //+ '<div>' + 'from' + '</div>'
    + '<span class="wpbc_big_date">' + first_date + '</span>' + '<span>' + '-' + '</span>' + '<span class="wpbc_big_date">' + last_date + '</span>' + '<span>');
  } else {
    // if ( params[ 'dates_arr' ].length > 1 ){
    // 	last_date = ', ' + last_date;
    // 	last_date += ( params[ 'dates_arr' ].length > 2 ) ? ', ...' : '';
    // } else {
    // 	last_date='';
    // }
    var dates_arr = [];
    for (var i = 0; i < params['dates_arr'].length; i++) {
      dates_arr.push(jQuery.datepick.formatDate('dd M yy', new Date(params['dates_arr'][i] + 'T00:00:00')));
    }
    first_date = dates_arr.join(', ');
    message = message.replace('_DATES_', '</span>' + '<span class="wpbc_big_date">' + first_date + '</span>' + '<span>');
  }
  message = message.replace('_HTML_', '</span><span class="wpbc_big_text" style="color:' + color + ';">') + '<span>';

  //message += ' <div style="margin-left: 1em;">' + ' Click on Apply button to apply availability.' + '</div>';

  message = '<div class="wpbc_toolbar_dates_hints">' + message + '</div>';
  jQuery('.wpbc_help_text').html(message);
}

/**
 *   Parse dates  ------------------------------------------------------------------------------------------- */

/**
 * Get dates array,  from comma separated dates
 *
 * @param params       = {
									* 'dates_separator' => ', ',                                        // Dates separator
									* 'dates'           => '2023-04-04, 2023-04-07, 2023-04-05'         // Dates in 'Y-m-d' format: '2023-01-31'
						 }
 *
 * @return array      = [
									* [0] => 2023-04-04
									* [1] => 2023-04-05
									* [2] => 2023-04-06
									* [3] => 2023-04-07
						]
 *
 * Example #1:  wpbc_get_dates_arr__from_dates_comma_separated_js(  {  'dates_separator' : ', ', 'dates' : '2023-04-04, 2023-04-07, 2023-04-05'  }  );
 */
function wpbc_get_dates_arr__from_dates_comma_separated_js(params) {
  var dates_arr = [];
  if ('' !== params['dates']) {
    dates_arr = params['dates'].split(params['dates_separator']);
    dates_arr.sort();
  }
  return dates_arr;
}

/**
 * Get dates array,  from range days selection
 *
 * @param params       =  {
									* 'dates_separator' => ' ~ ',                         // Dates separator
									* 'dates'           => '2023-04-04 ~ 2023-04-07'      // Dates in 'Y-m-d' format: '2023-01-31'
						  }
 *
 * @return array        = [
									* [0] => 2023-04-04
									* [1] => 2023-04-05
									* [2] => 2023-04-06
									* [3] => 2023-04-07
						  ]
 *
 * Example #1:  wpbc_get_dates_arr__from_dates_range_js(  {  'dates_separator' : ' ~ ', 'dates' : '2023-04-04 ~ 2023-04-07'  }  );
 * Example #2:  wpbc_get_dates_arr__from_dates_range_js(  {  'dates_separator' : ' - ', 'dates' : '2023-04-04 - 2023-04-07'  }  );
 */
function wpbc_get_dates_arr__from_dates_range_js(params) {
  var dates_arr = [];
  if ('' !== params['dates']) {
    dates_arr = params['dates'].split(params['dates_separator']);
    var check_in_date_ymd = dates_arr[0];
    var check_out_date_ymd = dates_arr[1];
    if ('' !== check_in_date_ymd && '' !== check_out_date_ymd) {
      dates_arr = wpbc_get_dates_array_from_start_end_days_js(check_in_date_ymd, check_out_date_ymd);
    }
  }
  return dates_arr;
}

/**
 * Get dates array based on start and end dates.
 *
 * @param string sStartDate - start date: 2023-04-09
 * @param string sEndDate   - end date:   2023-04-11
 * @return array             - [ "2023-04-09", "2023-04-10", "2023-04-11" ]
 */
function wpbc_get_dates_array_from_start_end_days_js(sStartDate, sEndDate) {
  sStartDate = new Date(sStartDate + 'T00:00:00');
  sEndDate = new Date(sEndDate + 'T00:00:00');
  var aDays = [];

  // Start the variable off with the start date
  aDays.push(sStartDate.getTime());

  // Set a 'temp' variable, sCurrentDate, with the start date - before beginning the loop
  var sCurrentDate = new Date(sStartDate.getTime());
  var one_day_duration = 24 * 60 * 60 * 1000;

  // While the current date is less than the end date
  while (sCurrentDate < sEndDate) {
    // Add a day to the current date "+1 day"
    sCurrentDate.setTime(sCurrentDate.getTime() + one_day_duration);

    // Add this new day to the aDays array
    aDays.push(sCurrentDate.getTime());
  }
  for (var i = 0; i < aDays.length; i++) {
    aDays[i] = new Date(aDays[i]);
    aDays[i] = aDays[i].getFullYear() + '-' + (aDays[i].getMonth() + 1 < 10 ? '0' : '') + (aDays[i].getMonth() + 1) + '-' + (aDays[i].getDate() < 10 ? '0' : '') + aDays[i].getDate();
  }
  // Once the loop has finished, return the array of days.
  return aDays;
}

/**
 *   Tooltips  ---------------------------------------------------------------------------------------------- */

/**
 * Define showing tooltip,  when  mouse over on  SELECTABLE (available, pending, approved, resource unavailable),  days
 * Can be called directly  from  datepick init function.
 *
 * @param value
 * @param date
 * @param calendar_params_arr
 * @param datepick_this
 * @returns {boolean}
 */
function wpbc_avy__prepare_tooltip__in_calendar(value, date, calendar_params_arr, datepick_this) {
  if (null == date) {
    return false;
  }
  var td_class = date.getMonth() + 1 + '-' + date.getDate() + '-' + date.getFullYear();
  var jCell = jQuery('#calendar_booking' + calendar_params_arr.resource_id + ' td.cal4date-' + td_class);
  wpbc_avy__show_tooltip__for_element(jCell, calendar_params_arr['popover_hints']);
  return true;
}

/**
 * Define tooltip  for showing on UNAVAILABLE days (season, weekday, today_depends unavailable)
 *
 * @param jCell					jQuery of specific day cell
 * @param popover_hints		    Array with tooltip hint texts	 : {'season_unavailable':'...','weekdays_unavailable':'...','before_after_unavailable':'...',}
 */
function wpbc_avy__show_tooltip__for_element(jCell, popover_hints) {
  var tooltip_time = '';
  if (jCell.hasClass('season_unavailable')) {
    tooltip_time = popover_hints['season_unavailable'];
  } else if (jCell.hasClass('weekdays_unavailable')) {
    tooltip_time = popover_hints['weekdays_unavailable'];
  } else if (jCell.hasClass('before_after_unavailable')) {
    tooltip_time = popover_hints['before_after_unavailable'];
  } else if (jCell.hasClass('date2approve')) {} else if (jCell.hasClass('date_approved')) {} else {}
  jCell.attr('data-content', tooltip_time);
  var td_el = jCell.get(0); //jQuery( '#calendar_booking' + calendar_params_arr.resource_id + ' td.cal4date-' + td_class ).get(0);

  if (undefined == td_el._tippy && '' != tooltip_time) {
    wpbc_tippy(td_el, {
      content: function content(reference) {
        var popover_content = reference.getAttribute('data-content');
        return '<div class="popover popover_tippy">' + '<div class="popover-content">' + popover_content + '</div>' + '</div>';
      },
      allowHTML: true,
      trigger: 'mouseenter focus',
      interactive: !true,
      hideOnClick: true,
      interactiveBorder: 10,
      maxWidth: 550,
      theme: 'wpbc-tippy-times',
      placement: 'top',
      delay: [400, 0],
      //FixIn: 9.4.2.2
      ignoreAttributes: true,
      touch: true,
      //['hold', 500], // 500ms delay			//FixIn: 9.2.1.5
      appendTo: function appendTo() {
        return document.body;
      }
    });
  }
}

/**
 *   Ajax  ------------------------------------------------------------------------------------------------------ */

/**
 * Send Ajax show request
 */
function wpbc_ajx_availability__ajax_request() {
  console.groupCollapsed('WPBC_AJX_AVAILABILITY');
  console.log(' == Before Ajax Send - search_get_all_params() == ', wpbc_ajx_availability.search_get_all_params());
  wpbc_availability_reload_button__spin_start();

  // Start Ajax
  jQuery.post(wpbc_url_ajax, {
    action: 'WPBC_AJX_AVAILABILITY',
    wpbc_ajx_user_id: wpbc_ajx_availability.get_secure_param('user_id'),
    nonce: wpbc_ajx_availability.get_secure_param('nonce'),
    wpbc_ajx_locale: wpbc_ajx_availability.get_secure_param('locale'),
    search_params: wpbc_ajx_availability.search_get_all_params()
  },
  /**
   * S u c c e s s
   *
   * @param response_data		-	its object returned from  Ajax - class-live-searcg.php
   * @param textStatus		-	'success'
   * @param jqXHR				-	Object
   */
  function (response_data, textStatus, jqXHR) {
    console.log(' == Response WPBC_AJX_AVAILABILITY == ', response_data);
    console.groupEnd();

    // Probably Error
    if (_typeof(response_data) !== 'object' || response_data === null) {
      wpbc_ajx_availability__show_message(response_data);
      return;
    }

    // Reload page, after filter toolbar has been reset
    if (undefined != response_data['ajx_cleaned_params'] && 'reset_done' === response_data['ajx_cleaned_params']['do_action']) {
      location.reload();
      return;
    }

    // Show listing
    wpbc_ajx_availability__page_content__show(response_data['ajx_data'], response_data['ajx_search_params'], response_data['ajx_cleaned_params']);

    //wpbc_ajx_availability__define_ui_hooks();						// Redefine Hooks, because we show new DOM elements
    if ('' != response_data['ajx_data']['ajx_after_action_message'].replace(/\n/g, "<br />")) {
      wpbc_admin_show_message(response_data['ajx_data']['ajx_after_action_message'].replace(/\n/g, "<br />"), '1' == response_data['ajx_data']['ajx_after_action_result'] ? 'success' : 'error', 10000);
    }
    wpbc_availability_reload_button__spin_pause();
    // Remove spin icon from  button and Enable this button.
    wpbc_button__remove_spin(response_data['ajx_cleaned_params']['ui_clicked_element_id']);
    jQuery('#ajax_respond').html(response_data); // For ability to show response, add such DIV element to page
  }).fail(function (jqXHR, textStatus, errorThrown) {
    if (window.console && window.console.log) {
      console.log('Ajax_Error', jqXHR, textStatus, errorThrown);
    }
    var error_message = '<strong>' + 'Error!' + '</strong> ' + errorThrown;
    if (jqXHR.status) {
      error_message += ' (<b>' + jqXHR.status + '</b>)';
      if (403 == jqXHR.status) {
        error_message += ' Probably nonce for this page has been expired. Please <a href="javascript:void(0)" onclick="javascript:location.reload();">reload the page</a>.';
      }
    }
    if (jqXHR.responseText) {
      error_message += ' ' + jqXHR.responseText;
    }
    error_message = error_message.replace(/\n/g, "<br />");
    wpbc_ajx_availability__show_message(error_message);
  })
  // .done(   function ( data, textStatus, jqXHR ) {   if ( window.console && window.console.log ){ console.log( 'second success', data, textStatus, jqXHR ); }    })
  // .always( function ( data_jqXHR, textStatus, jqXHR_errorThrown ) {   if ( window.console && window.console.log ){ console.log( 'always finished', data_jqXHR, textStatus, jqXHR_errorThrown ); }     })
  ; // End Ajax
}

/**
 *   H o o k s  -  its Action/Times when need to re-Render Views  ----------------------------------------------- */

/**
 * Send Ajax Search Request after Updating search request parameters
 *
 * @param params_arr
 */
function wpbc_ajx_availability__send_request_with_params(params_arr) {
  // Define different Search  parameters for request
  _.each(params_arr, function (p_val, p_key, p_data) {
    //console.log( 'Request for: ', p_key, p_val );
    wpbc_ajx_availability.search_set_param(p_key, p_val);
  });

  // Send Ajax Request
  wpbc_ajx_availability__ajax_request();
}

/**
 * Search request for "Page Number"
 * @param page_number	int
 */
function wpbc_ajx_availability__pagination_click(page_number) {
  wpbc_ajx_availability__send_request_with_params({
    'page_num': page_number
  });
}

/**
 *   Show / Hide Content  --------------------------------------------------------------------------------------- */

/**
 *  Show Listing Content 	- 	Sending Ajax Request	-	with parameters that  we early  defined
 */
function wpbc_ajx_availability__actual_content__show() {
  wpbc_ajx_availability__ajax_request(); // Send Ajax Request	-	with parameters that  we early  defined in "wpbc_ajx_booking_listing" Obj.
}

/**
 * Hide Listing Content
 */
function wpbc_ajx_availability__actual_content__hide() {
  jQuery(wpbc_ajx_availability.get_other_param('listing_container')).html('');
}

/**
 *   M e s s a g e  --------------------------------------------------------------------------------------------- */

/**
 * Show just message instead of content
 */
function wpbc_ajx_availability__show_message(message) {
  wpbc_ajx_availability__actual_content__hide();
  jQuery(wpbc_ajx_availability.get_other_param('listing_container')).html('<div class="wpbc-settings-notice notice-warning" style="text-align:left">' + message + '</div>');
}

/**
 *   Support Functions - Spin Icon in Buttons  ------------------------------------------------------------------ */

/**
 * Spin button in Filter toolbar  -  Start
 */
function wpbc_availability_reload_button__spin_start() {
  jQuery('#wpbc_availability_reload_button .menu_icon.wpbc_spin').removeClass('wpbc_animation_pause');
}

/**
 * Spin button in Filter toolbar  -  Pause
 */
function wpbc_availability_reload_button__spin_pause() {
  jQuery('#wpbc_availability_reload_button .menu_icon.wpbc_spin').addClass('wpbc_animation_pause');
}

/**
 * Spin button in Filter toolbar  -  is Spinning ?
 *
 * @returns {boolean}
 */
function wpbc_availability_reload_button__is_spin() {
  if (jQuery('#wpbc_availability_reload_button .menu_icon.wpbc_spin').hasClass('wpbc_animation_pause')) {
    return true;
  } else {
    return false;
  }
}
//# sourceMappingURL=data:application/json;charset=utf8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiaW5jbHVkZXMvcGFnZS1hdmFpbGFiaWxpdHkvX291dC9hdmFpbGFiaWxpdHlfcGFnZS5qcyIsIm5hbWVzIjpbIl90eXBlb2YiLCJvYmoiLCJTeW1ib2wiLCJpdGVyYXRvciIsImNvbnN0cnVjdG9yIiwicHJvdG90eXBlIiwid3BiY19hanhfYXZhaWxhYmlsaXR5IiwiJCIsInBfc2VjdXJlIiwic2VjdXJpdHlfb2JqIiwidXNlcl9pZCIsIm5vbmNlIiwibG9jYWxlIiwic2V0X3NlY3VyZV9wYXJhbSIsInBhcmFtX2tleSIsInBhcmFtX3ZhbCIsImdldF9zZWN1cmVfcGFyYW0iLCJwX2xpc3RpbmciLCJzZWFyY2hfcmVxdWVzdF9vYmoiLCJzZWFyY2hfc2V0X2FsbF9wYXJhbXMiLCJyZXF1ZXN0X3BhcmFtX29iaiIsInNlYXJjaF9nZXRfYWxsX3BhcmFtcyIsInNlYXJjaF9nZXRfcGFyYW0iLCJzZWFyY2hfc2V0X3BhcmFtIiwic2VhcmNoX3NldF9wYXJhbXNfYXJyIiwicGFyYW1zX2FyciIsIl8iLCJlYWNoIiwicF92YWwiLCJwX2tleSIsInBfZGF0YSIsInBfb3RoZXIiLCJvdGhlcl9vYmoiLCJzZXRfb3RoZXJfcGFyYW0iLCJnZXRfb3RoZXJfcGFyYW0iLCJqUXVlcnkiLCJ3cGJjX2FqeF9ib29raW5ncyIsIndwYmNfYWp4X2F2YWlsYWJpbGl0eV9fcGFnZV9jb250ZW50X19zaG93IiwiYWp4X2RhdGFfYXJyIiwiYWp4X3NlYXJjaF9wYXJhbXMiLCJhanhfY2xlYW5lZF9wYXJhbXMiLCJ0ZW1wbGF0ZV9fYXZhaWxhYmlsaXR5X21haW5fcGFnZV9jb250ZW50Iiwid3AiLCJ0ZW1wbGF0ZSIsImh0bWwiLCJwYXJlbnQiLCJoaWRlIiwid3BiY19hanhfYXZhaWxhYmlsaXR5X19jYWxlbmRhcl9fc2hvdyIsInJlc291cmNlX2lkIiwiYWp4X25vbmNlX2NhbGVuZGFyIiwidHJpZ2dlciIsImNhbGVuZGFyX3BhcmFtc19hcnIiLCJvbiIsImV2ZW50IiwiaW5zdCIsImRwRGl2IiwiZmluZCIsInRoaXNfZXZlbnQiLCJqQ2VsbCIsImN1cnJlbnRUYXJnZXQiLCJ3cGJjX2F2eV9fc2hvd190b29sdGlwX19mb3JfZWxlbWVudCIsImpDYWxDb250YWluZXIiLCJyZW1vdmVDbGFzcyIsImNhbGVuZGFyX192aWV3X19jZWxsX2hlaWdodCIsImFwcGVuZCIsIndpZHRoIiwiY2FsZW5kYXJfX3ZpZXdfX3dpZHRoIiwidW5kZWZpbmVkIiwiY2FsZW5kYXJfX3ZpZXdfX21heF93aWR0aCIsImNhbGVuZGFyX192aWV3X19tb250aHNfaW5fcm93IiwiY2FsZW5kYXJfX3ZpZXdfX3Zpc2libGVfbW9udGhzIiwiY2FsZW5kYXJfX3RpbWVzbG90X2RheV9iZ19hc19hdmFpbGFibGUiLCJjYWxfcGFyYW1fYXJyIiwiY2FsZW5kYXJfX3N0YXJ0X3dlZWtfZGF5IiwiY2FsZW5kYXJfX2RheXNfc2VsZWN0aW9uX21vZGUiLCJib29rZWRfZGF0ZXMiLCJzZWFzb25fYXZhaWxhYmlsaXR5IiwicmVzb3VyY2VfdW5hdmFpbGFibGVfZGF0ZXMiLCJ3cGJjX3Nob3dfaW5saW5lX2Jvb2tpbmdfY2FsZW5kYXIiLCJ3cGJjX19pbmxpbmVfYm9va2luZ19jYWxlbmRhcl9fb25fZGF5c19zZWxlY3QiLCJ0ZXh0X2lkIiwidmFsIiwicG9wb3Zlcl9oaW50cyIsInRvb2xiYXJfdGV4dCIsImh0bWxfaWQiLCJsZW5ndGgiLCJoYXNDbGFzcyIsInRleHQiLCJkYXRlcGljayIsImJlZm9yZVNob3dEYXkiLCJkYXRlIiwid3BiY19faW5saW5lX2Jvb2tpbmdfY2FsZW5kYXJfX2FwcGx5X2Nzc190b19kYXlzIiwib25TZWxlY3QiLCJvbkhvdmVyIiwidmFsdWUiLCJ3cGJjX19pbmxpbmVfYm9va2luZ19jYWxlbmRhcl9fb25fZGF5c19ob3ZlciIsIm9uQ2hhbmdlTW9udGhZZWFyIiwic2hvd09uIiwibnVtYmVyT2ZNb250aHMiLCJzdGVwTW9udGhzIiwicHJldlRleHQiLCJuZXh0VGV4dCIsImRhdGVGb3JtYXQiLCJjaGFuZ2VNb250aCIsImNoYW5nZVllYXIiLCJtaW5EYXRlIiwibWF4RGF0ZSIsInNob3dTdGF0dXMiLCJjbG9zZUF0VG9wIiwiZmlyc3REYXkiLCJnb3RvQ3VycmVudCIsImhpZGVJZk5vUHJldk5leHQiLCJtdWx0aVNlcGFyYXRvciIsIm11bHRpU2VsZWN0IiwicmFuZ2VTZWxlY3QiLCJyYW5nZVNlcGFyYXRvciIsInVzZVRoZW1lUm9sbGVyIiwiZGF0ZXBpY2tfdGhpcyIsInRvZGF5X2RhdGUiLCJEYXRlIiwiX3dwYmMiLCJwYXJzZUludCIsImNsYXNzX2RheSIsImdldE1vbnRoIiwiZ2V0RGF0ZSIsImdldEZ1bGxZZWFyIiwic3FsX2NsYXNzX2RheSIsIndwYmNfX2dldF9fc3FsX2NsYXNzX2RhdGUiLCJjc3NfZGF0ZV9fc3RhbmRhcmQiLCJjc3NfZGF0ZV9fYWRkaXRpb25hbCIsImdldERheSIsImkiLCJ3cGJjX2RhdGVzX19kYXlzX2JldHdlZW4iLCJpc19kYXRlX2F2YWlsYWJsZSIsIndwZGV2X2luX2FycmF5IiwiYm9va2luZ3NfaW5fZGF0ZSIsImFwcHJvdmVkIiwiT2JqZWN0Iiwia2V5cyIsImlzX2FwcHJvdmVkIiwidHMiLCJib29raW5nX2RhdGUiLCJzdWJzdHJpbmciLCJfZ2V0SW5zdCIsImRvY3VtZW50IiwiZ2V0RWxlbWVudEJ5SWQiLCJkYXRlcyIsInRkX2NsYXNzIiwidGRfb3ZlcnMiLCJpc19jaGVjayIsInNlbGNldGVkX2ZpcnN0X2RheSIsInNldEZ1bGxZZWFyIiwiYWRkQ2xhc3MiLCJkYXRlc19zZWxlY3Rpb24iLCJhcmd1bWVudHMiLCJkYXRlc19hcnIiLCJpbmRleE9mIiwid3BiY19nZXRfZGF0ZXNfYXJyX19mcm9tX2RhdGVzX3JhbmdlX2pzIiwid3BiY19nZXRfZGF0ZXNfYXJyX19mcm9tX2RhdGVzX2NvbW1hX3NlcGFyYXRlZF9qcyIsIndwYmNfYXZ5X2FmdGVyX2RheXNfc2VsZWN0aW9uX19zaG93X2hlbHBfaW5mbyIsInBhcmFtcyIsIm1lc3NhZ2UiLCJjb2xvciIsImlzIiwidG9vbGJhcl90ZXh0X2F2YWlsYWJsZSIsInRvb2xiYXJfdGV4dF91bmF2YWlsYWJsZSIsImZpcnN0X2RhdGUiLCJsYXN0X2RhdGUiLCJmb3JtYXREYXRlIiwiZGF0ZXNfY2xpY2tfbnVtIiwiYXR0ciIsIndwYmNfYmxpbmtfZWxlbWVudCIsInJlcGxhY2UiLCJwdXNoIiwiam9pbiIsInNwbGl0Iiwic29ydCIsImNoZWNrX2luX2RhdGVfeW1kIiwiY2hlY2tfb3V0X2RhdGVfeW1kIiwid3BiY19nZXRfZGF0ZXNfYXJyYXlfZnJvbV9zdGFydF9lbmRfZGF5c19qcyIsInNTdGFydERhdGUiLCJzRW5kRGF0ZSIsImFEYXlzIiwiZ2V0VGltZSIsInNDdXJyZW50RGF0ZSIsIm9uZV9kYXlfZHVyYXRpb24iLCJzZXRUaW1lIiwid3BiY19hdnlfX3ByZXBhcmVfdG9vbHRpcF9faW5fY2FsZW5kYXIiLCJ0b29sdGlwX3RpbWUiLCJ0ZF9lbCIsImdldCIsIl90aXBweSIsIndwYmNfdGlwcHkiLCJjb250ZW50IiwicmVmZXJlbmNlIiwicG9wb3Zlcl9jb250ZW50IiwiZ2V0QXR0cmlidXRlIiwiYWxsb3dIVE1MIiwiaW50ZXJhY3RpdmUiLCJoaWRlT25DbGljayIsImludGVyYWN0aXZlQm9yZGVyIiwibWF4V2lkdGgiLCJ0aGVtZSIsInBsYWNlbWVudCIsImRlbGF5IiwiaWdub3JlQXR0cmlidXRlcyIsInRvdWNoIiwiYXBwZW5kVG8iLCJib2R5Iiwid3BiY19hanhfYXZhaWxhYmlsaXR5X19hamF4X3JlcXVlc3QiLCJjb25zb2xlIiwiZ3JvdXBDb2xsYXBzZWQiLCJsb2ciLCJ3cGJjX2F2YWlsYWJpbGl0eV9yZWxvYWRfYnV0dG9uX19zcGluX3N0YXJ0IiwicG9zdCIsIndwYmNfdXJsX2FqYXgiLCJhY3Rpb24iLCJ3cGJjX2FqeF91c2VyX2lkIiwid3BiY19hanhfbG9jYWxlIiwic2VhcmNoX3BhcmFtcyIsInJlc3BvbnNlX2RhdGEiLCJ0ZXh0U3RhdHVzIiwianFYSFIiLCJncm91cEVuZCIsIndwYmNfYWp4X2F2YWlsYWJpbGl0eV9fc2hvd19tZXNzYWdlIiwibG9jYXRpb24iLCJyZWxvYWQiLCJ3cGJjX2FkbWluX3Nob3dfbWVzc2FnZSIsIndwYmNfYXZhaWxhYmlsaXR5X3JlbG9hZF9idXR0b25fX3NwaW5fcGF1c2UiLCJ3cGJjX2J1dHRvbl9fcmVtb3ZlX3NwaW4iLCJmYWlsIiwiZXJyb3JUaHJvd24iLCJ3aW5kb3ciLCJlcnJvcl9tZXNzYWdlIiwic3RhdHVzIiwicmVzcG9uc2VUZXh0Iiwid3BiY19hanhfYXZhaWxhYmlsaXR5X19zZW5kX3JlcXVlc3Rfd2l0aF9wYXJhbXMiLCJ3cGJjX2FqeF9hdmFpbGFiaWxpdHlfX3BhZ2luYXRpb25fY2xpY2siLCJwYWdlX251bWJlciIsIndwYmNfYWp4X2F2YWlsYWJpbGl0eV9fYWN0dWFsX2NvbnRlbnRfX3Nob3ciLCJ3cGJjX2FqeF9hdmFpbGFiaWxpdHlfX2FjdHVhbF9jb250ZW50X19oaWRlIiwid3BiY19hdmFpbGFiaWxpdHlfcmVsb2FkX2J1dHRvbl9faXNfc3BpbiJdLCJzb3VyY2VzIjpbImluY2x1ZGVzL3BhZ2UtYXZhaWxhYmlsaXR5L19zcmMvYXZhaWxhYmlsaXR5X3BhZ2UuanMiXSwic291cmNlc0NvbnRlbnQiOlsiXCJ1c2Ugc3RyaWN0XCI7XHJcblxyXG4vKipcclxuICogUmVxdWVzdCBPYmplY3RcclxuICogSGVyZSB3ZSBjYW4gIGRlZmluZSBTZWFyY2ggcGFyYW1ldGVycyBhbmQgVXBkYXRlIGl0IGxhdGVyLCAgd2hlbiAgc29tZSBwYXJhbWV0ZXIgd2FzIGNoYW5nZWRcclxuICpcclxuICovXHJcblxyXG52YXIgd3BiY19hanhfYXZhaWxhYmlsaXR5ID0gKGZ1bmN0aW9uICggb2JqLCAkKSB7XHJcblxyXG5cdC8vIFNlY3VyZSBwYXJhbWV0ZXJzIGZvciBBamF4XHQtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHR2YXIgcF9zZWN1cmUgPSBvYmouc2VjdXJpdHlfb2JqID0gb2JqLnNlY3VyaXR5X29iaiB8fCB7XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdHVzZXJfaWQ6IDAsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdG5vbmNlICA6ICcnLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRsb2NhbGUgOiAnJ1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0ICB9O1xyXG5cclxuXHRvYmouc2V0X3NlY3VyZV9wYXJhbSA9IGZ1bmN0aW9uICggcGFyYW1fa2V5LCBwYXJhbV92YWwgKSB7XHJcblx0XHRwX3NlY3VyZVsgcGFyYW1fa2V5IF0gPSBwYXJhbV92YWw7XHJcblx0fTtcclxuXHJcblx0b2JqLmdldF9zZWN1cmVfcGFyYW0gPSBmdW5jdGlvbiAoIHBhcmFtX2tleSApIHtcclxuXHRcdHJldHVybiBwX3NlY3VyZVsgcGFyYW1fa2V5IF07XHJcblx0fTtcclxuXHJcblxyXG5cdC8vIExpc3RpbmcgU2VhcmNoIHBhcmFtZXRlcnNcdC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cdHZhciBwX2xpc3RpbmcgPSBvYmouc2VhcmNoX3JlcXVlc3Rfb2JqID0gb2JqLnNlYXJjaF9yZXF1ZXN0X29iaiB8fCB7XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdC8vIHNvcnQgICAgICAgICAgICA6IFwiYm9va2luZ19pZFwiLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQvLyBzb3J0X3R5cGUgICAgICAgOiBcIkRFU0NcIixcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0Ly8gcGFnZV9udW0gICAgICAgIDogMSxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0Ly8gcGFnZV9pdGVtc19jb3VudDogMTAsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdC8vIGNyZWF0ZV9kYXRlICAgICA6IFwiXCIsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdC8vIGtleXdvcmQgICAgICAgICA6IFwiXCIsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdC8vIHNvdXJjZSAgICAgICAgICA6IFwiXCJcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdH07XHJcblxyXG5cdG9iai5zZWFyY2hfc2V0X2FsbF9wYXJhbXMgPSBmdW5jdGlvbiAoIHJlcXVlc3RfcGFyYW1fb2JqICkge1xyXG5cdFx0cF9saXN0aW5nID0gcmVxdWVzdF9wYXJhbV9vYmo7XHJcblx0fTtcclxuXHJcblx0b2JqLnNlYXJjaF9nZXRfYWxsX3BhcmFtcyA9IGZ1bmN0aW9uICgpIHtcclxuXHRcdHJldHVybiBwX2xpc3Rpbmc7XHJcblx0fTtcclxuXHJcblx0b2JqLnNlYXJjaF9nZXRfcGFyYW0gPSBmdW5jdGlvbiAoIHBhcmFtX2tleSApIHtcclxuXHRcdHJldHVybiBwX2xpc3RpbmdbIHBhcmFtX2tleSBdO1xyXG5cdH07XHJcblxyXG5cdG9iai5zZWFyY2hfc2V0X3BhcmFtID0gZnVuY3Rpb24gKCBwYXJhbV9rZXksIHBhcmFtX3ZhbCApIHtcclxuXHRcdC8vIGlmICggQXJyYXkuaXNBcnJheSggcGFyYW1fdmFsICkgKXtcclxuXHRcdC8vIFx0cGFyYW1fdmFsID0gSlNPTi5zdHJpbmdpZnkoIHBhcmFtX3ZhbCApO1xyXG5cdFx0Ly8gfVxyXG5cdFx0cF9saXN0aW5nWyBwYXJhbV9rZXkgXSA9IHBhcmFtX3ZhbDtcclxuXHR9O1xyXG5cclxuXHRvYmouc2VhcmNoX3NldF9wYXJhbXNfYXJyID0gZnVuY3Rpb24oIHBhcmFtc19hcnIgKXtcclxuXHRcdF8uZWFjaCggcGFyYW1zX2FyciwgZnVuY3Rpb24gKCBwX3ZhbCwgcF9rZXksIHBfZGF0YSApe1x0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdC8vIERlZmluZSBkaWZmZXJlbnQgU2VhcmNoICBwYXJhbWV0ZXJzIGZvciByZXF1ZXN0XHJcblx0XHRcdHRoaXMuc2VhcmNoX3NldF9wYXJhbSggcF9rZXksIHBfdmFsICk7XHJcblx0XHR9ICk7XHJcblx0fVxyXG5cclxuXHJcblx0Ly8gT3RoZXIgcGFyYW1ldGVycyBcdFx0XHQtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHR2YXIgcF9vdGhlciA9IG9iai5vdGhlcl9vYmogPSBvYmoub3RoZXJfb2JqIHx8IHsgfTtcclxuXHJcblx0b2JqLnNldF9vdGhlcl9wYXJhbSA9IGZ1bmN0aW9uICggcGFyYW1fa2V5LCBwYXJhbV92YWwgKSB7XHJcblx0XHRwX290aGVyWyBwYXJhbV9rZXkgXSA9IHBhcmFtX3ZhbDtcclxuXHR9O1xyXG5cclxuXHRvYmouZ2V0X290aGVyX3BhcmFtID0gZnVuY3Rpb24gKCBwYXJhbV9rZXkgKSB7XHJcblx0XHRyZXR1cm4gcF9vdGhlclsgcGFyYW1fa2V5IF07XHJcblx0fTtcclxuXHJcblxyXG5cdHJldHVybiBvYmo7XHJcbn0oIHdwYmNfYWp4X2F2YWlsYWJpbGl0eSB8fCB7fSwgalF1ZXJ5ICkpO1xyXG5cclxudmFyIHdwYmNfYWp4X2Jvb2tpbmdzID0gW107XHJcblxyXG4vKipcclxuICogICBTaG93IENvbnRlbnQgIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0gKi9cclxuXHJcbi8qKlxyXG4gKiBTaG93IENvbnRlbnQgLSBDYWxlbmRhciBhbmQgVUkgZWxlbWVudHNcclxuICpcclxuICogQHBhcmFtIGFqeF9kYXRhX2FyclxyXG4gKiBAcGFyYW0gYWp4X3NlYXJjaF9wYXJhbXNcclxuICogQHBhcmFtIGFqeF9jbGVhbmVkX3BhcmFtc1xyXG4gKi9cclxuZnVuY3Rpb24gd3BiY19hanhfYXZhaWxhYmlsaXR5X19wYWdlX2NvbnRlbnRfX3Nob3coIGFqeF9kYXRhX2FyciwgYWp4X3NlYXJjaF9wYXJhbXMgLCBhanhfY2xlYW5lZF9wYXJhbXMgKXtcclxuXHJcblx0dmFyIHRlbXBsYXRlX19hdmFpbGFiaWxpdHlfbWFpbl9wYWdlX2NvbnRlbnQgPSB3cC50ZW1wbGF0ZSggJ3dwYmNfYWp4X2F2YWlsYWJpbGl0eV9tYWluX3BhZ2VfY29udGVudCcgKTtcclxuXHJcblx0Ly8gQ29udGVudFxyXG5cdGpRdWVyeSggd3BiY19hanhfYXZhaWxhYmlsaXR5LmdldF9vdGhlcl9wYXJhbSggJ2xpc3RpbmdfY29udGFpbmVyJyApICkuaHRtbCggdGVtcGxhdGVfX2F2YWlsYWJpbGl0eV9tYWluX3BhZ2VfY29udGVudCgge1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCdhanhfZGF0YScgICAgICAgICAgICAgIDogYWp4X2RhdGFfYXJyLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCdhanhfc2VhcmNoX3BhcmFtcycgICAgIDogYWp4X3NlYXJjaF9wYXJhbXMsXHRcdFx0XHRcdFx0XHRcdC8vICRfUkVRVUVTVFsgJ3NlYXJjaF9wYXJhbXMnIF1cclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnYWp4X2NsZWFuZWRfcGFyYW1zJyAgICA6IGFqeF9jbGVhbmVkX3BhcmFtc1xyXG5cdFx0XHRcdFx0XHRcdFx0XHR9ICkgKTtcclxuXHJcblx0alF1ZXJ5KCAnLndwYmNfcHJvY2Vzc2luZy53cGJjX3NwaW4nKS5wYXJlbnQoKS5wYXJlbnQoKS5wYXJlbnQoKS5wYXJlbnQoICdbaWRePVwid3BiY19ub3RpY2VfXCJdJyApLmhpZGUoKTtcclxuXHQvLyBMb2FkIGNhbGVuZGFyXHJcblx0d3BiY19hanhfYXZhaWxhYmlsaXR5X19jYWxlbmRhcl9fc2hvdygge1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0J3Jlc291cmNlX2lkJyAgICAgICA6IGFqeF9jbGVhbmVkX3BhcmFtcy5yZXNvdXJjZV9pZCxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdCdhanhfbm9uY2VfY2FsZW5kYXInOiBhanhfZGF0YV9hcnIuYWp4X25vbmNlX2NhbGVuZGFyLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0J2FqeF9kYXRhX2FycicgICAgICAgICAgOiBhanhfZGF0YV9hcnIsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnYWp4X2NsZWFuZWRfcGFyYW1zJyAgICA6IGFqeF9jbGVhbmVkX3BhcmFtc1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdH0gKTtcclxuXHJcblxyXG5cdC8qKlxyXG5cdCAqIFRyaWdnZXIgZm9yIGRhdGVzIHNlbGVjdGlvbiBpbiB0aGUgYm9va2luZyBmb3JtXHJcblx0ICpcclxuXHQgKiBqUXVlcnkoIHdwYmNfYWp4X2F2YWlsYWJpbGl0eS5nZXRfb3RoZXJfcGFyYW0oICdsaXN0aW5nX2NvbnRhaW5lcicgKSApLm9uKCd3cGJjX3BhZ2VfY29udGVudF9sb2FkZWQnLCBmdW5jdGlvbihldmVudCwgYWp4X2RhdGFfYXJyLCBhanhfc2VhcmNoX3BhcmFtcyAsIGFqeF9jbGVhbmVkX3BhcmFtcykgeyAuLi4gfSApO1xyXG5cdCAqL1xyXG5cdGpRdWVyeSggd3BiY19hanhfYXZhaWxhYmlsaXR5LmdldF9vdGhlcl9wYXJhbSggJ2xpc3RpbmdfY29udGFpbmVyJyApICkudHJpZ2dlciggJ3dwYmNfcGFnZV9jb250ZW50X2xvYWRlZCcsIFsgYWp4X2RhdGFfYXJyLCBhanhfc2VhcmNoX3BhcmFtcyAsIGFqeF9jbGVhbmVkX3BhcmFtcyBdICk7XHJcbn1cclxuXHJcblxyXG4vKipcclxuICogU2hvdyBpbmxpbmUgbW9udGggdmlldyBjYWxlbmRhciAgICAgICAgICAgICAgd2l0aCBhbGwgcHJlZGVmaW5lZCBDU1MgKHNpemVzIGFuZCBjaGVjayBpbi9vdXQsICB0aW1lcyBjb250YWluZXJzKVxyXG4gKiBAcGFyYW0ge29ian0gY2FsZW5kYXJfcGFyYW1zX2FyclxyXG5cdFx0XHR7XHJcblx0XHRcdFx0J3Jlc291cmNlX2lkJyAgICAgICBcdDogYWp4X2NsZWFuZWRfcGFyYW1zLnJlc291cmNlX2lkLFxyXG5cdFx0XHRcdCdhanhfbm9uY2VfY2FsZW5kYXInXHQ6IGFqeF9kYXRhX2Fyci5hanhfbm9uY2VfY2FsZW5kYXIsXHJcblx0XHRcdFx0J2FqeF9kYXRhX2FycicgICAgICAgICAgOiBhanhfZGF0YV9hcnIgPSB7IGFqeF9ib29raW5nX3Jlc291cmNlczpbXSwgYm9va2VkX2RhdGVzOiB7fSwgcmVzb3VyY2VfdW5hdmFpbGFibGVfZGF0ZXM6W10sIHNlYXNvbl9hdmFpbGFiaWxpdHk6e30sLi4uLiB9XHJcblx0XHRcdFx0J2FqeF9jbGVhbmVkX3BhcmFtcycgICAgOiB7XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRjYWxlbmRhcl9fZGF5c19zZWxlY3Rpb25fbW9kZTogXCJkeW5hbWljXCJcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdGNhbGVuZGFyX19zdGFydF93ZWVrX2RheTogXCIwXCJcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdGNhbGVuZGFyX190aW1lc2xvdF9kYXlfYmdfYXNfYXZhaWxhYmxlOiBcIlwiXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRjYWxlbmRhcl9fdmlld19fY2VsbF9oZWlnaHQ6IFwiXCJcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdGNhbGVuZGFyX192aWV3X19tb250aHNfaW5fcm93OiA0XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRjYWxlbmRhcl9fdmlld19fdmlzaWJsZV9tb250aHM6IDEyXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRjYWxlbmRhcl9fdmlld19fd2lkdGg6IFwiMTAwJVwiXHJcblxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0ZGF0ZXNfYXZhaWxhYmlsaXR5OiBcInVuYXZhaWxhYmxlXCJcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdGRhdGVzX3NlbGVjdGlvbjogXCIyMDIzLTAzLTE0IH4gMjAyMy0wMy0xNlwiXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRkb19hY3Rpb246IFwic2V0X2F2YWlsYWJpbGl0eVwiXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRyZXNvdXJjZV9pZDogMVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0dWlfY2xpY2tlZF9lbGVtZW50X2lkOiBcIndwYmNfYXZhaWxhYmlsaXR5X2FwcGx5X2J0blwiXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHR1aV91c3JfX2F2YWlsYWJpbGl0eV9zZWxlY3RlZF90b29sYmFyOiBcImluZm9cIlxyXG5cdFx0XHRcdFx0XHRcdFx0ICBcdFx0IH1cclxuXHRcdFx0fVxyXG4qL1xyXG5mdW5jdGlvbiB3cGJjX2FqeF9hdmFpbGFiaWxpdHlfX2NhbGVuZGFyX19zaG93KCBjYWxlbmRhcl9wYXJhbXNfYXJyICl7XHJcblxyXG5cdC8vIFVwZGF0ZSBub25jZVxyXG5cdGpRdWVyeSggJyNhanhfbm9uY2VfY2FsZW5kYXJfc2VjdGlvbicgKS5odG1sKCBjYWxlbmRhcl9wYXJhbXNfYXJyLmFqeF9ub25jZV9jYWxlbmRhciApO1xyXG5cclxuXHQvLy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cdC8vIFVwZGF0ZSBib29raW5nc1xyXG5cdGlmICggJ3VuZGVmaW5lZCcgPT0gdHlwZW9mICh3cGJjX2FqeF9ib29raW5nc1sgY2FsZW5kYXJfcGFyYW1zX2Fyci5yZXNvdXJjZV9pZCBdKSApeyB3cGJjX2FqeF9ib29raW5nc1sgY2FsZW5kYXJfcGFyYW1zX2Fyci5yZXNvdXJjZV9pZCBdID0gW107IH1cclxuXHR3cGJjX2FqeF9ib29raW5nc1sgY2FsZW5kYXJfcGFyYW1zX2Fyci5yZXNvdXJjZV9pZCBdID0gY2FsZW5kYXJfcGFyYW1zX2FyclsgJ2FqeF9kYXRhX2FycicgXVsgJ2Jvb2tlZF9kYXRlcycgXTtcclxuXHJcblxyXG5cdC8vLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblx0LyoqXHJcblx0ICogRGVmaW5lIHNob3dpbmcgbW91c2Ugb3ZlciB0b29sdGlwIG9uIHVuYXZhaWxhYmxlIGRhdGVzXHJcblx0ICogSXQncyBkZWZpbmVkLCB3aGVuIGNhbGVuZGFyIFJFRlJFU0hFRCAoY2hhbmdlIG1vbnRocyBvciBkYXlzIHNlbGVjdGlvbikgbG9hZGVkIGluIGpxdWVyeS5kYXRlcGljay53cGJjLjkuMC5qcyA6XHJcblx0ICogXHRcdCQoICdib2R5JyApLnRyaWdnZXIoICd3cGJjX2RhdGVwaWNrX2lubGluZV9jYWxlbmRhcl9yZWZyZXNoJywgLi4uXHRcdC8vRml4SW46IDkuNC40LjEzXHJcblx0ICovXHJcblx0alF1ZXJ5KCAnYm9keScgKS5vbiggJ3dwYmNfZGF0ZXBpY2tfaW5saW5lX2NhbGVuZGFyX3JlZnJlc2gnLCBmdW5jdGlvbiAoIGV2ZW50LCByZXNvdXJjZV9pZCwgaW5zdCApe1xyXG5cdFx0Ly8gaW5zdC5kcERpdiAgaXQnczogIDxkaXYgY2xhc3M9XCJkYXRlcGljay1pbmxpbmUgZGF0ZXBpY2stbXVsdGlcIiBzdHlsZT1cIndpZHRoOiAxNzcxMnB4O1wiPi4uLi48L2Rpdj5cclxuXHRcdGluc3QuZHBEaXYuZmluZCggJy5zZWFzb25fdW5hdmFpbGFibGUsLmJlZm9yZV9hZnRlcl91bmF2YWlsYWJsZSwud2Vla2RheXNfdW5hdmFpbGFibGUnICkub24oICdtb3VzZW92ZXInLCBmdW5jdGlvbiAoIHRoaXNfZXZlbnQgKXtcclxuXHRcdFx0Ly8gYWxzbyBhdmFpbGFibGUgdGhlc2UgdmFyczogXHRyZXNvdXJjZV9pZCwgakNhbENvbnRhaW5lciwgaW5zdFxyXG5cdFx0XHR2YXIgakNlbGwgPSBqUXVlcnkoIHRoaXNfZXZlbnQuY3VycmVudFRhcmdldCApO1xyXG5cdFx0XHR3cGJjX2F2eV9fc2hvd190b29sdGlwX19mb3JfZWxlbWVudCggakNlbGwsIGNhbGVuZGFyX3BhcmFtc19hcnJbICdhanhfZGF0YV9hcnInIF1bJ3BvcG92ZXJfaGludHMnXSApO1xyXG5cdFx0fSk7XHJcblxyXG5cdH1cdCk7XHJcblxyXG5cdC8vLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblx0LyoqXHJcblx0ICogRGVmaW5lIGhlaWdodCBvZiB0aGUgY2FsZW5kYXIgIGNlbGxzLCBcdGFuZCAgbW91c2Ugb3ZlciB0b29sdGlwcyBhdCAgc29tZSB1bmF2YWlsYWJsZSBkYXRlc1xyXG5cdCAqIEl0J3MgZGVmaW5lZCwgd2hlbiBjYWxlbmRhciBsb2FkZWQgaW4ganF1ZXJ5LmRhdGVwaWNrLndwYmMuOS4wLmpzIDpcclxuXHQgKiBcdFx0JCggJ2JvZHknICkudHJpZ2dlciggJ3dwYmNfZGF0ZXBpY2tfaW5saW5lX2NhbGVuZGFyX2xvYWRlZCcsIC4uLlx0XHQvL0ZpeEluOiA5LjQuNC4xMlxyXG5cdCAqL1xyXG5cdGpRdWVyeSggJ2JvZHknICkub24oICd3cGJjX2RhdGVwaWNrX2lubGluZV9jYWxlbmRhcl9sb2FkZWQnLCBmdW5jdGlvbiAoIGV2ZW50LCByZXNvdXJjZV9pZCwgakNhbENvbnRhaW5lciwgaW5zdCApe1xyXG5cclxuXHRcdC8vIFJlbW92ZSBoaWdobGlnaHQgZGF5IGZvciB0b2RheSAgZGF0ZVxyXG5cdFx0alF1ZXJ5KCAnLmRhdGVwaWNrLWRheXMtY2VsbC5kYXRlcGljay10b2RheS5kYXRlcGljay1kYXlzLWNlbGwtb3ZlcicgKS5yZW1vdmVDbGFzcyggJ2RhdGVwaWNrLWRheXMtY2VsbC1vdmVyJyApO1xyXG5cclxuXHRcdC8vIFNldCBoZWlnaHQgb2YgY2FsZW5kYXIgIGNlbGxzIGlmIGRlZmluZWQgdGhpcyBvcHRpb25cclxuXHRcdGlmICggJycgIT09IGNhbGVuZGFyX3BhcmFtc19hcnIuYWp4X2NsZWFuZWRfcGFyYW1zLmNhbGVuZGFyX192aWV3X19jZWxsX2hlaWdodCApe1xyXG5cdFx0XHRqUXVlcnkoICdoZWFkJyApLmFwcGVuZCggJzxzdHlsZSB0eXBlPVwidGV4dC9jc3NcIj4nXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0KyAnLmhhc0RhdGVwaWNrIC5kYXRlcGljay1pbmxpbmUgLmRhdGVwaWNrLXRpdGxlLXJvdyB0aCwgJ1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdCsgJy5oYXNEYXRlcGljayAuZGF0ZXBpY2staW5saW5lIC5kYXRlcGljay1kYXlzLWNlbGwgeydcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdCsgJ2hlaWdodDogJyArIGNhbGVuZGFyX3BhcmFtc19hcnIuYWp4X2NsZWFuZWRfcGFyYW1zLmNhbGVuZGFyX192aWV3X19jZWxsX2hlaWdodCArICcgIWltcG9ydGFudDsnXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0KyAnfSdcclxuXHRcdFx0XHRcdFx0XHRcdFx0Kyc8L3N0eWxlPicgKTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBEZWZpbmUgc2hvd2luZyBtb3VzZSBvdmVyIHRvb2x0aXAgb24gdW5hdmFpbGFibGUgZGF0ZXNcclxuXHRcdGpDYWxDb250YWluZXIuZmluZCggJy5zZWFzb25fdW5hdmFpbGFibGUsLmJlZm9yZV9hZnRlcl91bmF2YWlsYWJsZSwud2Vla2RheXNfdW5hdmFpbGFibGUnICkub24oICdtb3VzZW92ZXInLCBmdW5jdGlvbiAoIHRoaXNfZXZlbnQgKXtcclxuXHRcdFx0Ly8gYWxzbyBhdmFpbGFibGUgdGhlc2UgdmFyczogXHRyZXNvdXJjZV9pZCwgakNhbENvbnRhaW5lciwgaW5zdFxyXG5cdFx0XHR2YXIgakNlbGwgPSBqUXVlcnkoIHRoaXNfZXZlbnQuY3VycmVudFRhcmdldCApO1xyXG5cdFx0XHR3cGJjX2F2eV9fc2hvd190b29sdGlwX19mb3JfZWxlbWVudCggakNlbGwsIGNhbGVuZGFyX3BhcmFtc19hcnJbICdhanhfZGF0YV9hcnInIF1bJ3BvcG92ZXJfaGludHMnXSApO1xyXG5cdFx0fSk7XHJcblx0fSApO1xyXG5cclxuXHQvLy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cdC8vIERlZmluZSB3aWR0aCBvZiBlbnRpcmUgY2FsZW5kYXJcclxuXHR2YXIgd2lkdGggPSAgICd3aWR0aDonXHRcdCsgICBjYWxlbmRhcl9wYXJhbXNfYXJyLmFqeF9jbGVhbmVkX3BhcmFtcy5jYWxlbmRhcl9fdmlld19fd2lkdGggKyAnOyc7XHRcdFx0XHRcdC8vIHZhciB3aWR0aCA9ICd3aWR0aDoxMDAlO21heC13aWR0aDoxMDAlOyc7XHJcblxyXG5cdGlmICggICAoIHVuZGVmaW5lZCAhPSBjYWxlbmRhcl9wYXJhbXNfYXJyLmFqeF9jbGVhbmVkX3BhcmFtcy5jYWxlbmRhcl9fdmlld19fbWF4X3dpZHRoIClcclxuXHRcdCYmICggJycgIT0gY2FsZW5kYXJfcGFyYW1zX2Fyci5hanhfY2xlYW5lZF9wYXJhbXMuY2FsZW5kYXJfX3ZpZXdfX21heF93aWR0aCApXHJcblx0KXtcclxuXHRcdHdpZHRoICs9ICdtYXgtd2lkdGg6JyBcdCsgY2FsZW5kYXJfcGFyYW1zX2Fyci5hanhfY2xlYW5lZF9wYXJhbXMuY2FsZW5kYXJfX3ZpZXdfX21heF93aWR0aCArICc7JztcclxuXHR9IGVsc2Uge1xyXG5cdFx0d2lkdGggKz0gJ21heC13aWR0aDonIFx0KyAoIGNhbGVuZGFyX3BhcmFtc19hcnIuYWp4X2NsZWFuZWRfcGFyYW1zLmNhbGVuZGFyX192aWV3X19tb250aHNfaW5fcm93ICogMzQxICkgKyAncHg7JztcclxuXHR9XHJcblxyXG5cdC8vLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblx0Ly8gQWRkIGNhbGVuZGFyIGNvbnRhaW5lcjogXCJDYWxlbmRhciBpcyBsb2FkaW5nLi4uXCIgIGFuZCB0ZXh0YXJlYVxyXG5cdGpRdWVyeSggJy53cGJjX2FqeF9hdnlfX2NhbGVuZGFyJyApLmh0bWwoXHJcblxyXG5cdFx0JzxkaXYgY2xhc3M9XCInXHQrICcgYmtfY2FsZW5kYXJfZnJhbWUnXHJcblx0XHRcdFx0XHRcdCsgJyBtb250aHNfbnVtX2luX3Jvd18nICsgY2FsZW5kYXJfcGFyYW1zX2Fyci5hanhfY2xlYW5lZF9wYXJhbXMuY2FsZW5kYXJfX3ZpZXdfX21vbnRoc19pbl9yb3dcclxuXHRcdFx0XHRcdFx0KyAnIGNhbF9tb250aF9udW1fJyBcdCsgY2FsZW5kYXJfcGFyYW1zX2Fyci5hanhfY2xlYW5lZF9wYXJhbXMuY2FsZW5kYXJfX3ZpZXdfX3Zpc2libGVfbW9udGhzXHJcblx0XHRcdFx0XHRcdCsgJyAnIFx0XHRcdFx0XHQrIGNhbGVuZGFyX3BhcmFtc19hcnIuYWp4X2NsZWFuZWRfcGFyYW1zLmNhbGVuZGFyX190aW1lc2xvdF9kYXlfYmdfYXNfYXZhaWxhYmxlIFx0XHRcdFx0Ly8gJ3dwYmNfdGltZXNsb3RfZGF5X2JnX2FzX2F2YWlsYWJsZScgfHwgJydcclxuXHRcdFx0XHQrICdcIiAnXHJcblx0XHRcdCsgJ3N0eWxlPVwiJyArIHdpZHRoICsgJ1wiPidcclxuXHJcblx0XHRcdFx0KyAnPGRpdiBpZD1cImNhbGVuZGFyX2Jvb2tpbmcnICsgY2FsZW5kYXJfcGFyYW1zX2Fyci5yZXNvdXJjZV9pZCArICdcIj4nICsgJ0NhbGVuZGFyIGlzIGxvYWRpbmcuLi4nICsgJzwvZGl2PidcclxuXHJcblx0XHQrICc8L2Rpdj4nXHJcblxyXG5cdFx0KyAnPHRleHRhcmVhICAgICAgaWQ9XCJkYXRlX2Jvb2tpbmcnICsgY2FsZW5kYXJfcGFyYW1zX2Fyci5yZXNvdXJjZV9pZCArICdcIidcclxuXHRcdFx0XHRcdCsgJyBuYW1lPVwiZGF0ZV9ib29raW5nJyArIGNhbGVuZGFyX3BhcmFtc19hcnIucmVzb3VyY2VfaWQgKyAnXCInXHJcblx0XHRcdFx0XHQrICcgYXV0b2NvbXBsZXRlPVwib2ZmXCInXHJcblx0XHRcdFx0XHQrICcgc3R5bGU9XCJkaXNwbGF5Om5vbmU7d2lkdGg6MTAwJTtoZWlnaHQ6MTBlbTttYXJnaW46MmVtIDAgMDtcIj48L3RleHRhcmVhPidcclxuXHQpO1xyXG5cclxuXHQvLy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cdHZhciBjYWxfcGFyYW1fYXJyID0ge1xyXG5cdFx0XHRcdFx0XHRcdCdodG1sX2lkJyAgICAgICAgICAgOiAnY2FsZW5kYXJfYm9va2luZycgKyBjYWxlbmRhcl9wYXJhbXNfYXJyLmFqeF9jbGVhbmVkX3BhcmFtcy5yZXNvdXJjZV9pZCxcclxuXHRcdFx0XHRcdFx0XHQndGV4dF9pZCcgICAgICAgICAgIDogJ2RhdGVfYm9va2luZycgKyBjYWxlbmRhcl9wYXJhbXNfYXJyLmFqeF9jbGVhbmVkX3BhcmFtcy5yZXNvdXJjZV9pZCxcclxuXHJcblx0XHRcdFx0XHRcdFx0J2NhbGVuZGFyX19zdGFydF93ZWVrX2RheSc6IFx0ICBjYWxlbmRhcl9wYXJhbXNfYXJyLmFqeF9jbGVhbmVkX3BhcmFtcy5jYWxlbmRhcl9fc3RhcnRfd2Vla19kYXksXHJcblx0XHRcdFx0XHRcdFx0J2NhbGVuZGFyX192aWV3X192aXNpYmxlX21vbnRocyc6IGNhbGVuZGFyX3BhcmFtc19hcnIuYWp4X2NsZWFuZWRfcGFyYW1zLmNhbGVuZGFyX192aWV3X192aXNpYmxlX21vbnRocyxcclxuXHRcdFx0XHRcdFx0XHQnY2FsZW5kYXJfX2RheXNfc2VsZWN0aW9uX21vZGUnOiAgY2FsZW5kYXJfcGFyYW1zX2Fyci5hanhfY2xlYW5lZF9wYXJhbXMuY2FsZW5kYXJfX2RheXNfc2VsZWN0aW9uX21vZGUsXHJcblxyXG5cdFx0XHRcdFx0XHRcdCdyZXNvdXJjZV9pZCcgICAgICAgIDogY2FsZW5kYXJfcGFyYW1zX2Fyci5hanhfY2xlYW5lZF9wYXJhbXMucmVzb3VyY2VfaWQsXHJcblx0XHRcdFx0XHRcdFx0J2FqeF9ub25jZV9jYWxlbmRhcicgOiBjYWxlbmRhcl9wYXJhbXNfYXJyLmFqeF9kYXRhX2Fyci5hanhfbm9uY2VfY2FsZW5kYXIsXHJcblx0XHRcdFx0XHRcdFx0J2Jvb2tlZF9kYXRlcycgICAgICAgOiBjYWxlbmRhcl9wYXJhbXNfYXJyLmFqeF9kYXRhX2Fyci5ib29rZWRfZGF0ZXMsXHJcblx0XHRcdFx0XHRcdFx0J3NlYXNvbl9hdmFpbGFiaWxpdHknOiBjYWxlbmRhcl9wYXJhbXNfYXJyLmFqeF9kYXRhX2Fyci5zZWFzb25fYXZhaWxhYmlsaXR5LFxyXG5cclxuXHRcdFx0XHRcdFx0XHQncmVzb3VyY2VfdW5hdmFpbGFibGVfZGF0ZXMnIDogY2FsZW5kYXJfcGFyYW1zX2Fyci5hanhfZGF0YV9hcnIucmVzb3VyY2VfdW5hdmFpbGFibGVfZGF0ZXMsXHJcblxyXG5cdFx0XHRcdFx0XHRcdCdwb3BvdmVyX2hpbnRzJzogY2FsZW5kYXJfcGFyYW1zX2FyclsgJ2FqeF9kYXRhX2FycicgXVsncG9wb3Zlcl9oaW50cyddXHRcdC8vIHsnc2Vhc29uX3VuYXZhaWxhYmxlJzonLi4uJywnd2Vla2RheXNfdW5hdmFpbGFibGUnOicuLi4nLCdiZWZvcmVfYWZ0ZXJfdW5hdmFpbGFibGUnOicuLi4nLH1cclxuXHRcdFx0XHRcdFx0fTtcclxuXHR3cGJjX3Nob3dfaW5saW5lX2Jvb2tpbmdfY2FsZW5kYXIoIGNhbF9wYXJhbV9hcnIgKTtcclxuXHJcblx0Ly8tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHQvKipcclxuXHQgKiBPbiBjbGljayBBVkFJTEFCTEUgfCAgVU5BVkFJTEFCTEUgYnV0dG9uICBpbiB3aWRnZXRcdC1cdG5lZWQgdG8gIGNoYW5nZSBoZWxwIGRhdGVzIHRleHRcclxuXHQgKi9cclxuXHRqUXVlcnkoICcud3BiY19yYWRpb19fc2V0X2RheXNfYXZhaWxhYmlsaXR5JyApLm9uKCdjaGFuZ2UnLCBmdW5jdGlvbiAoIGV2ZW50LCByZXNvdXJjZV9pZCwgaW5zdCApe1xyXG5cdFx0d3BiY19faW5saW5lX2Jvb2tpbmdfY2FsZW5kYXJfX29uX2RheXNfc2VsZWN0KCBqUXVlcnkoICcjJyArIGNhbF9wYXJhbV9hcnIudGV4dF9pZCApLnZhbCgpICwgY2FsX3BhcmFtX2FyciApO1xyXG5cdH0pO1xyXG5cclxuXHQvLyBTaG93IFx0J1NlbGVjdCBkYXlzICBpbiBjYWxlbmRhciB0aGVuIHNlbGVjdCBBdmFpbGFibGUgIC8gIFVuYXZhaWxhYmxlIHN0YXR1cyBhbmQgY2xpY2sgQXBwbHkgYXZhaWxhYmlsaXR5IGJ1dHRvbi4nXHJcblx0alF1ZXJ5KCAnI3dwYmNfdG9vbGJhcl9kYXRlc19oaW50JykuaHRtbCggICAgICc8ZGl2IGNsYXNzPVwidWlfZWxlbWVudFwiPjxzcGFuIGNsYXNzPVwid3BiY191aV9jb250cm9sIHdwYmNfdWlfYWRkb24gd3BiY19oZWxwX3RleHRcIiA+J1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCsgY2FsX3BhcmFtX2Fyci5wb3BvdmVyX2hpbnRzLnRvb2xiYXJfdGV4dFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQrICc8L3NwYW4+PC9kaXY+J1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0KTtcclxufVxyXG5cclxuXHJcbi8qKlxyXG4gKiBcdExvYWQgRGF0ZXBpY2sgSW5saW5lIGNhbGVuZGFyXHJcbiAqXHJcbiAqIEBwYXJhbSBjYWxlbmRhcl9wYXJhbXNfYXJyXHRcdGV4YW1wbGU6e1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0J2h0bWxfaWQnICAgICAgICAgICA6ICdjYWxlbmRhcl9ib29raW5nJyArIGNhbGVuZGFyX3BhcmFtc19hcnIuYWp4X2NsZWFuZWRfcGFyYW1zLnJlc291cmNlX2lkLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0J3RleHRfaWQnICAgICAgICAgICA6ICdkYXRlX2Jvb2tpbmcnICsgY2FsZW5kYXJfcGFyYW1zX2Fyci5hanhfY2xlYW5lZF9wYXJhbXMucmVzb3VyY2VfaWQsXHJcblxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0J2NhbGVuZGFyX19zdGFydF93ZWVrX2RheSc6IFx0ICBjYWxlbmRhcl9wYXJhbXNfYXJyLmFqeF9jbGVhbmVkX3BhcmFtcy5jYWxlbmRhcl9fc3RhcnRfd2Vla19kYXksXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnY2FsZW5kYXJfX3ZpZXdfX3Zpc2libGVfbW9udGhzJzogY2FsZW5kYXJfcGFyYW1zX2Fyci5hanhfY2xlYW5lZF9wYXJhbXMuY2FsZW5kYXJfX3ZpZXdfX3Zpc2libGVfbW9udGhzLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0J2NhbGVuZGFyX19kYXlzX3NlbGVjdGlvbl9tb2RlJzogIGNhbGVuZGFyX3BhcmFtc19hcnIuYWp4X2NsZWFuZWRfcGFyYW1zLmNhbGVuZGFyX19kYXlzX3NlbGVjdGlvbl9tb2RlLFxyXG5cclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdCdyZXNvdXJjZV9pZCcgICAgICAgIDogY2FsZW5kYXJfcGFyYW1zX2Fyci5hanhfY2xlYW5lZF9wYXJhbXMucmVzb3VyY2VfaWQsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnYWp4X25vbmNlX2NhbGVuZGFyJyA6IGNhbGVuZGFyX3BhcmFtc19hcnIuYWp4X2RhdGFfYXJyLmFqeF9ub25jZV9jYWxlbmRhcixcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdCdib29rZWRfZGF0ZXMnICAgICAgIDogY2FsZW5kYXJfcGFyYW1zX2Fyci5hanhfZGF0YV9hcnIuYm9va2VkX2RhdGVzLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0J3NlYXNvbl9hdmFpbGFiaWxpdHknOiBjYWxlbmRhcl9wYXJhbXNfYXJyLmFqeF9kYXRhX2Fyci5zZWFzb25fYXZhaWxhYmlsaXR5LFxyXG5cclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdCdyZXNvdXJjZV91bmF2YWlsYWJsZV9kYXRlcycgOiBjYWxlbmRhcl9wYXJhbXNfYXJyLmFqeF9kYXRhX2Fyci5yZXNvdXJjZV91bmF2YWlsYWJsZV9kYXRlc1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdH1cclxuICogQHJldHVybnMge2Jvb2xlYW59XHJcbiAqL1xyXG5mdW5jdGlvbiB3cGJjX3Nob3dfaW5saW5lX2Jvb2tpbmdfY2FsZW5kYXIoIGNhbGVuZGFyX3BhcmFtc19hcnIgKXtcclxuXHJcblx0aWYgKFxyXG5cdFx0ICAgKCAwID09PSBqUXVlcnkoICcjJyArIGNhbGVuZGFyX3BhcmFtc19hcnIuaHRtbF9pZCApLmxlbmd0aCApXHRcdFx0XHRcdFx0XHQvLyBJZiBjYWxlbmRhciBET00gZWxlbWVudCBub3QgZXhpc3QgdGhlbiBleGlzdFxyXG5cdFx0fHwgKCB0cnVlID09PSBqUXVlcnkoICcjJyArIGNhbGVuZGFyX3BhcmFtc19hcnIuaHRtbF9pZCApLmhhc0NsYXNzKCAnaGFzRGF0ZXBpY2snICkgKVx0Ly8gSWYgdGhlIGNhbGVuZGFyIHdpdGggdGhlIHNhbWUgQm9va2luZyByZXNvdXJjZSBhbHJlYWR5ICBoYXMgYmVlbiBhY3RpdmF0ZWQsIHRoZW4gZXhpc3QuXHJcblx0KXtcclxuXHQgICByZXR1cm4gZmFsc2U7XHJcblx0fVxyXG5cclxuXHQvLy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cdC8vIENvbmZpZ3VyZSBhbmQgc2hvdyBjYWxlbmRhclxyXG5cdGpRdWVyeSggJyMnICsgY2FsZW5kYXJfcGFyYW1zX2Fyci5odG1sX2lkICkudGV4dCggJycgKTtcclxuXHRqUXVlcnkoICcjJyArIGNhbGVuZGFyX3BhcmFtc19hcnIuaHRtbF9pZCApLmRhdGVwaWNrKHtcclxuXHRcdFx0XHRcdGJlZm9yZVNob3dEYXk6IFx0ZnVuY3Rpb24gKCBkYXRlICl7XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0cmV0dXJuIHdwYmNfX2lubGluZV9ib29raW5nX2NhbGVuZGFyX19hcHBseV9jc3NfdG9fZGF5cyggZGF0ZSwgY2FsZW5kYXJfcGFyYW1zX2FyciwgdGhpcyApO1xyXG5cdFx0XHRcdFx0XHRcdFx0XHR9LFxyXG4gICAgICAgICAgICAgICAgICAgIG9uU2VsZWN0OiBcdCAgXHRmdW5jdGlvbiAoIGRhdGUgKXtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRqUXVlcnkoICcjJyArIGNhbGVuZGFyX3BhcmFtc19hcnIudGV4dF9pZCApLnZhbCggZGF0ZSApO1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdC8vd3BiY19ibGlua19lbGVtZW50KCcud3BiY193aWRnZXRfYXZhaWxhYmxlX3VuYXZhaWxhYmxlJywgMywgMjIwKTtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRyZXR1cm4gd3BiY19faW5saW5lX2Jvb2tpbmdfY2FsZW5kYXJfX29uX2RheXNfc2VsZWN0KCBkYXRlLCBjYWxlbmRhcl9wYXJhbXNfYXJyLCB0aGlzICk7XHJcblx0XHRcdFx0XHRcdFx0XHRcdH0sXHJcbiAgICAgICAgICAgICAgICAgICAgb25Ib3ZlcjogXHRcdGZ1bmN0aW9uICggdmFsdWUsIGRhdGUgKXtcclxuXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0Ly93cGJjX2F2eV9fcHJlcGFyZV90b29sdGlwX19pbl9jYWxlbmRhciggdmFsdWUsIGRhdGUsIGNhbGVuZGFyX3BhcmFtc19hcnIsIHRoaXMgKTtcclxuXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0cmV0dXJuIHdwYmNfX2lubGluZV9ib29raW5nX2NhbGVuZGFyX19vbl9kYXlzX2hvdmVyKCB2YWx1ZSwgZGF0ZSwgY2FsZW5kYXJfcGFyYW1zX2FyciwgdGhpcyApO1xyXG5cdFx0XHRcdFx0XHRcdFx0XHR9LFxyXG4gICAgICAgICAgICAgICAgICAgIG9uQ2hhbmdlTW9udGhZZWFyOlx0bnVsbCxcclxuICAgICAgICAgICAgICAgICAgICBzaG93T246IFx0XHRcdCdib3RoJyxcclxuICAgICAgICAgICAgICAgICAgICBudW1iZXJPZk1vbnRoczogXHRjYWxlbmRhcl9wYXJhbXNfYXJyLmNhbGVuZGFyX192aWV3X192aXNpYmxlX21vbnRocyxcclxuICAgICAgICAgICAgICAgICAgICBzdGVwTW9udGhzOlx0XHRcdDEsXHJcbiAgICAgICAgICAgICAgICAgICAgcHJldlRleHQ6IFx0XHRcdCcmbGFxdW87JyxcclxuICAgICAgICAgICAgICAgICAgICBuZXh0VGV4dDogXHRcdFx0JyZyYXF1bzsnLFxyXG4gICAgICAgICAgICAgICAgICAgIGRhdGVGb3JtYXQ6IFx0XHQneXktbW0tZGQnLC8vICdkZC5tbS55eScsXHJcbiAgICAgICAgICAgICAgICAgICAgY2hhbmdlTW9udGg6IFx0XHRmYWxzZSxcclxuICAgICAgICAgICAgICAgICAgICBjaGFuZ2VZZWFyOiBcdFx0ZmFsc2UsXHJcbiAgICAgICAgICAgICAgICAgICAgbWluRGF0ZTogXHRcdFx0XHRcdCAwLFx0XHQvL251bGwsICAvL1Njcm9sbCBhcyBsb25nIGFzIHlvdSBuZWVkXHJcblx0XHRcdFx0XHRtYXhEYXRlOiBcdFx0XHRcdFx0JzEweScsXHQvLyBtaW5EYXRlOiBuZXcgRGF0ZSgyMDIwLCAyLCAxKSwgbWF4RGF0ZTogbmV3IERhdGUoMjAyMCwgOSwgMzEpLCBcdC8vIEFiaWxpdHkgdG8gc2V0IGFueSAgc3RhcnQgYW5kIGVuZCBkYXRlIGluIGNhbGVuZGFyXHJcbiAgICAgICAgICAgICAgICAgICAgc2hvd1N0YXR1czogXHRcdGZhbHNlLFxyXG4gICAgICAgICAgICAgICAgICAgIGNsb3NlQXRUb3A6IFx0XHRmYWxzZSxcclxuICAgICAgICAgICAgICAgICAgICBmaXJzdERheTpcdFx0XHRjYWxlbmRhcl9wYXJhbXNfYXJyLmNhbGVuZGFyX19zdGFydF93ZWVrX2RheSxcclxuICAgICAgICAgICAgICAgICAgICBnb3RvQ3VycmVudDogXHRcdGZhbHNlLFxyXG4gICAgICAgICAgICAgICAgICAgIGhpZGVJZk5vUHJldk5leHQ6XHR0cnVlLFxyXG4gICAgICAgICAgICAgICAgICAgIG11bHRpU2VwYXJhdG9yOiBcdCcsICcsXHJcblx0XHRcdFx0XHRtdWx0aVNlbGVjdDogKCgnZHluYW1pYycgPT0gY2FsZW5kYXJfcGFyYW1zX2Fyci5jYWxlbmRhcl9fZGF5c19zZWxlY3Rpb25fbW9kZSkgPyAwIDogMzY1KSxcdFx0XHQvLyBNYXhpbXVtIG51bWJlciBvZiBzZWxlY3RhYmxlIGRhdGVzOlx0IFNpbmdsZSBkYXkgPSAwLCAgbXVsdGkgZGF5cyA9IDM2NVxyXG5cdFx0XHRcdFx0cmFuZ2VTZWxlY3Q6ICAoJ2R5bmFtaWMnID09IGNhbGVuZGFyX3BhcmFtc19hcnIuY2FsZW5kYXJfX2RheXNfc2VsZWN0aW9uX21vZGUpLFxyXG5cdFx0XHRcdFx0cmFuZ2VTZXBhcmF0b3I6IFx0JyB+ICcsXHRcdFx0XHRcdC8vJyAtICcsXHJcbiAgICAgICAgICAgICAgICAgICAgLy8gc2hvd1dlZWtzOiB0cnVlLFxyXG4gICAgICAgICAgICAgICAgICAgIHVzZVRoZW1lUm9sbGVyOlx0XHRmYWxzZVxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICk7XHJcblxyXG5cdHJldHVybiAgdHJ1ZTtcclxufVxyXG5cclxuXHJcblx0LyoqXHJcblx0ICogQXBwbHkgQ1NTIHRvIGNhbGVuZGFyIGRhdGUgY2VsbHNcclxuXHQgKlxyXG5cdCAqIEBwYXJhbSBkYXRlXHRcdFx0XHRcdC0gIEphdmFTY3JpcHQgRGF0ZSBPYmo6ICBcdFx0TW9uIERlYyAxMSAyMDIzIDAwOjAwOjAwIEdNVCswMjAwIChFYXN0ZXJuIEV1cm9wZWFuIFN0YW5kYXJkIFRpbWUpXHJcblx0ICogQHBhcmFtIGNhbGVuZGFyX3BhcmFtc19hcnJcdC0gIENhbGVuZGFyIFNldHRpbmdzIE9iamVjdDogIFx0e1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0ICBcImh0bWxfaWRcIjogXCJjYWxlbmRhcl9ib29raW5nNFwiLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0ICBcInRleHRfaWRcIjogXCJkYXRlX2Jvb2tpbmc0XCIsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQgIFwiY2FsZW5kYXJfX3N0YXJ0X3dlZWtfZGF5XCI6IDEsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQgIFwiY2FsZW5kYXJfX3ZpZXdfX3Zpc2libGVfbW9udGhzXCI6IDEyLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0ICBcInJlc291cmNlX2lkXCI6IDQsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQgIFwiYWp4X25vbmNlX2NhbGVuZGFyXCI6IFwiPGlucHV0IHR5cGU9XFxcImhpZGRlblxcXCIgLi4uIC8+XCIsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQgIFwiYm9va2VkX2RhdGVzXCI6IHtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XCIxMi0yOC0yMDIyXCI6IFtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0ICB7XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XCJib29raW5nX2RhdGVcIjogXCIyMDIyLTEyLTI4IDAwOjAwOjAwXCIsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XCJhcHByb3ZlZFwiOiBcIjFcIixcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcImJvb2tpbmdfaWRcIjogXCIyNlwiXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCAgfVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRdLCAuLi5cclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnc2Vhc29uX2F2YWlsYWJpbGl0eSc6e1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFwiMjAyMy0wMS0wOVwiOiB0cnVlLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFwiMjAyMy0wMS0xMFwiOiB0cnVlLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFwiMjAyMy0wMS0xMVwiOiB0cnVlLCAuLi5cclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0ICB9XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHR9XHJcblx0ICogQHBhcmFtIGRhdGVwaWNrX3RoaXNcdFx0XHQtIHRoaXMgb2YgZGF0ZXBpY2sgT2JqXHJcblx0ICpcclxuXHQgKiBAcmV0dXJucyBbYm9vbGVhbixzdHJpbmddXHQtIFsge3RydWUgLWF2YWlsYWJsZSB8IGZhbHNlIC0gdW5hdmFpbGFibGV9LCAnQ1NTIGNsYXNzZXMgZm9yIGNhbGVuZGFyIGRheSBjZWxsJyBdXHJcblx0ICovXHJcblx0ZnVuY3Rpb24gd3BiY19faW5saW5lX2Jvb2tpbmdfY2FsZW5kYXJfX2FwcGx5X2Nzc190b19kYXlzKCBkYXRlLCBjYWxlbmRhcl9wYXJhbXNfYXJyLCBkYXRlcGlja190aGlzICl7XHJcblxyXG5cdFx0dmFyIHRvZGF5X2RhdGUgPSBuZXcgRGF0ZSggX3dwYmMuZ2V0X290aGVyX3BhcmFtKCAndG9kYXlfYXJyJyApWyAwIF0sIChwYXJzZUludCggX3dwYmMuZ2V0X290aGVyX3BhcmFtKCAndG9kYXlfYXJyJyApWyAxIF0gKSAtIDEpLCBfd3BiYy5nZXRfb3RoZXJfcGFyYW0oICd0b2RheV9hcnInIClbIDIgXSwgMCwgMCwgMCApO1xyXG5cclxuXHRcdHZhciBjbGFzc19kYXkgID0gKCBkYXRlLmdldE1vbnRoKCkgKyAxICkgKyAnLScgKyBkYXRlLmdldERhdGUoKSArICctJyArIGRhdGUuZ2V0RnVsbFllYXIoKTtcdFx0XHRcdFx0XHQvLyAnMS05LTIwMjMnXHJcblx0XHR2YXIgc3FsX2NsYXNzX2RheSA9IHdwYmNfX2dldF9fc3FsX2NsYXNzX2RhdGUoIGRhdGUgKTtcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdC8vICcyMDIzLTAxLTA5J1xyXG5cclxuXHRcdHZhciBjc3NfZGF0ZV9fc3RhbmRhcmQgICA9ICAnY2FsNGRhdGUtJyArIGNsYXNzX2RheTtcclxuXHRcdHZhciBjc3NfZGF0ZV9fYWRkaXRpb25hbCA9ICcgd3BiY193ZWVrZGF5XycgKyBkYXRlLmdldERheSgpICsgJyAnO1xyXG5cclxuXHRcdC8vLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHJcblx0XHQvLyBXRUVLREFZUyA6OiBTZXQgdW5hdmFpbGFibGUgd2VlayBkYXlzIGZyb20gLSBTZXR0aW5ncyBHZW5lcmFsIHBhZ2UgaW4gXCJBdmFpbGFiaWxpdHlcIiBzZWN0aW9uXHJcblx0XHRmb3IgKCB2YXIgaSA9IDA7IGkgPCBfd3BiYy5nZXRfb3RoZXJfcGFyYW0oICdhdmFpbGFiaWxpdHlfX3dlZWtfZGF5c191bmF2YWlsYWJsZScgKS5sZW5ndGg7IGkrKyApe1xyXG5cdFx0XHRpZiAoIGRhdGUuZ2V0RGF5KCkgPT0gX3dwYmMuZ2V0X290aGVyX3BhcmFtKCAnYXZhaWxhYmlsaXR5X193ZWVrX2RheXNfdW5hdmFpbGFibGUnIClbIGkgXSApIHtcclxuXHRcdFx0XHRyZXR1cm4gWyAhIWZhbHNlLCBjc3NfZGF0ZV9fc3RhbmRhcmQgKyAnIGRhdGVfdXNlcl91bmF2YWlsYWJsZScgXHQrICcgd2Vla2RheXNfdW5hdmFpbGFibGUnIF07XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHJcblx0XHQvLyBCRUZPUkVfQUZURVIgOjogU2V0IHVuYXZhaWxhYmxlIGRheXMgQmVmb3JlIC8gQWZ0ZXIgdGhlIFRvZGF5IGRhdGVcclxuXHRcdGlmICggXHQoICh3cGJjX2RhdGVzX19kYXlzX2JldHdlZW4oIGRhdGUsIHRvZGF5X2RhdGUgKSkgPCBwYXJzZUludChfd3BiYy5nZXRfb3RoZXJfcGFyYW0oICdhdmFpbGFiaWxpdHlfX3VuYXZhaWxhYmxlX2Zyb21fdG9kYXknICkpIClcclxuXHRcdFx0IHx8IChcclxuXHRcdFx0XHQgICAoIHBhcnNlSW50KCAnMCcgKyBwYXJzZUludCggX3dwYmMuZ2V0X290aGVyX3BhcmFtKCAnYXZhaWxhYmlsaXR5X19hdmFpbGFibGVfZnJvbV90b2RheScgKSApICkgPiAwIClcclxuXHRcdFx0XHQmJiAoIHdwYmNfZGF0ZXNfX2RheXNfYmV0d2VlbiggZGF0ZSwgdG9kYXlfZGF0ZSApID4gcGFyc2VJbnQoICcwJyArIHBhcnNlSW50KCBfd3BiYy5nZXRfb3RoZXJfcGFyYW0oICdhdmFpbGFiaWxpdHlfX2F2YWlsYWJsZV9mcm9tX3RvZGF5JyApICkgKSApXHJcblx0XHRcdFx0KVxyXG5cdFx0KXtcclxuXHRcdFx0cmV0dXJuIFsgISFmYWxzZSwgY3NzX2RhdGVfX3N0YW5kYXJkICsgJyBkYXRlX3VzZXJfdW5hdmFpbGFibGUnIFx0XHQrICcgYmVmb3JlX2FmdGVyX3VuYXZhaWxhYmxlJyBdO1xyXG5cdFx0fVxyXG5cclxuXHRcdC8vIFNFQVNPTlMgOjogIFx0XHRcdFx0XHRCb29raW5nID4gUmVzb3VyY2VzID4gQXZhaWxhYmlsaXR5IHBhZ2VcclxuXHRcdHZhciAgICBpc19kYXRlX2F2YWlsYWJsZSA9IGNhbGVuZGFyX3BhcmFtc19hcnIuc2Vhc29uX2F2YWlsYWJpbGl0eVsgc3FsX2NsYXNzX2RheSBdO1xyXG5cdFx0aWYgKCBmYWxzZSA9PT0gaXNfZGF0ZV9hdmFpbGFibGUgKXtcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0Ly9GaXhJbjogOS41LjQuNFxyXG5cdFx0XHRyZXR1cm4gWyAhIWZhbHNlLCBjc3NfZGF0ZV9fc3RhbmRhcmQgKyAnIGRhdGVfdXNlcl91bmF2YWlsYWJsZSdcdFx0KyAnIHNlYXNvbl91bmF2YWlsYWJsZScgXTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBSRVNPVVJDRV9VTkFWQUlMQUJMRSA6OiAgIFx0Qm9va2luZyA+IEF2YWlsYWJpbGl0eSBwYWdlXHJcblx0XHRpZiAoIHdwZGV2X2luX2FycmF5KGNhbGVuZGFyX3BhcmFtc19hcnIucmVzb3VyY2VfdW5hdmFpbGFibGVfZGF0ZXMsIHNxbF9jbGFzc19kYXkgKSApe1xyXG5cdFx0XHRpc19kYXRlX2F2YWlsYWJsZSA9IGZhbHNlO1xyXG5cdFx0fVxyXG5cdFx0aWYgKCAgZmFsc2UgPT09IGlzX2RhdGVfYXZhaWxhYmxlICl7XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQvL0ZpeEluOiA5LjUuNC40XHJcblx0XHRcdHJldHVybiBbICFmYWxzZSwgY3NzX2RhdGVfX3N0YW5kYXJkICsgJyBkYXRlX3VzZXJfdW5hdmFpbGFibGUnXHRcdCsgJyByZXNvdXJjZV91bmF2YWlsYWJsZScgXTtcclxuXHRcdH1cclxuXHJcblx0XHQvLy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblxyXG5cdFx0Ly8tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cclxuXHJcblx0XHQvLyBJcyBhbnkgYm9va2luZ3MgaW4gdGhpcyBkYXRlID9cclxuXHRcdGlmICggJ3VuZGVmaW5lZCcgIT09IHR5cGVvZiggY2FsZW5kYXJfcGFyYW1zX2Fyci5ib29rZWRfZGF0ZXNbIGNsYXNzX2RheSBdICkgKSB7XHJcblxyXG5cdFx0XHR2YXIgYm9va2luZ3NfaW5fZGF0ZSA9IGNhbGVuZGFyX3BhcmFtc19hcnIuYm9va2VkX2RhdGVzWyBjbGFzc19kYXkgXTtcclxuXHJcblxyXG5cdFx0XHRpZiAoICd1bmRlZmluZWQnICE9PSB0eXBlb2YoIGJvb2tpbmdzX2luX2RhdGVbICdzZWNfMCcgXSApICkge1x0XHRcdC8vIFwiRnVsbCBkYXlcIiBib29raW5nICAtPiAoc2Vjb25kcyA9PSAwKVxyXG5cclxuXHRcdFx0XHRjc3NfZGF0ZV9fYWRkaXRpb25hbCArPSAoICcwJyA9PT0gYm9va2luZ3NfaW5fZGF0ZVsgJ3NlY18wJyBdLmFwcHJvdmVkICkgPyAnIGRhdGUyYXBwcm92ZSAnIDogJyBkYXRlX2FwcHJvdmVkICc7XHRcdFx0XHQvLyBQZW5kaW5nID0gJzAnIHwgIEFwcHJvdmVkID0gJzEnXHJcblx0XHRcdFx0Y3NzX2RhdGVfX2FkZGl0aW9uYWwgKz0gJyBmdWxsX2RheV9ib29raW5nJztcclxuXHJcblx0XHRcdFx0cmV0dXJuIFsgIWZhbHNlLCBjc3NfZGF0ZV9fc3RhbmRhcmQgKyBjc3NfZGF0ZV9fYWRkaXRpb25hbCBdO1xyXG5cclxuXHRcdFx0fSBlbHNlIGlmICggT2JqZWN0LmtleXMoIGJvb2tpbmdzX2luX2RhdGUgKS5sZW5ndGggPiAwICl7XHRcdFx0XHQvLyBcIlRpbWUgc2xvdHNcIiBCb29raW5nc1xyXG5cclxuXHRcdFx0XHR2YXIgaXNfYXBwcm92ZWQgPSB0cnVlO1xyXG5cclxuXHRcdFx0XHRfLmVhY2goIGJvb2tpbmdzX2luX2RhdGUsIGZ1bmN0aW9uICggcF92YWwsIHBfa2V5LCBwX2RhdGEgKSB7XHJcblx0XHRcdFx0XHRpZiAoICFwYXJzZUludCggcF92YWwuYXBwcm92ZWQgKSApe1xyXG5cdFx0XHRcdFx0XHRpc19hcHByb3ZlZCA9IGZhbHNlO1xyXG5cdFx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0dmFyIHRzID0gcF92YWwuYm9va2luZ19kYXRlLnN1YnN0cmluZyggcF92YWwuYm9va2luZ19kYXRlLmxlbmd0aCAtIDEgKTtcclxuXHRcdFx0XHRcdGlmICggdHJ1ZSA9PT0gX3dwYmMuZ2V0X290aGVyX3BhcmFtKCAnaXNfZW5hYmxlZF9jaGFuZ2Vfb3ZlcicgKSApe1xyXG5cdFx0XHRcdFx0XHRpZiAoIHRzID09ICcxJyApIHsgY3NzX2RhdGVfX2FkZGl0aW9uYWwgKz0gJyBjaGVja19pbl90aW1lJyArICgocGFyc2VJbnQocF92YWwuYXBwcm92ZWQpKSA/ICcgY2hlY2tfaW5fdGltZV9kYXRlX2FwcHJvdmVkJyA6ICcgY2hlY2tfaW5fdGltZV9kYXRlMmFwcHJvdmUnKTsgfVxyXG5cdFx0XHRcdFx0XHRpZiAoIHRzID09ICcyJyApIHsgY3NzX2RhdGVfX2FkZGl0aW9uYWwgKz0gJyBjaGVja19vdXRfdGltZScgKyAoKHBhcnNlSW50KHBfdmFsLmFwcHJvdmVkKSkgPyAnIGNoZWNrX291dF90aW1lX2RhdGVfYXBwcm92ZWQnIDogJyBjaGVja19vdXRfdGltZV9kYXRlMmFwcHJvdmUnKTsgfVxyXG5cdFx0XHRcdFx0fVxyXG5cclxuXHRcdFx0XHR9KTtcclxuXHJcblx0XHRcdFx0aWYgKCAhIGlzX2FwcHJvdmVkICl7XHJcblx0XHRcdFx0XHRjc3NfZGF0ZV9fYWRkaXRpb25hbCArPSAnIGRhdGUyYXBwcm92ZSB0aW1lc3BhcnRseSdcclxuXHRcdFx0XHR9IGVsc2Uge1xyXG5cdFx0XHRcdFx0Y3NzX2RhdGVfX2FkZGl0aW9uYWwgKz0gJyBkYXRlX2FwcHJvdmVkIHRpbWVzcGFydGx5J1xyXG5cdFx0XHRcdH1cclxuXHJcblx0XHRcdFx0aWYgKCAhIF93cGJjLmdldF9vdGhlcl9wYXJhbSggJ2lzX2VuYWJsZWRfY2hhbmdlX292ZXInICkgKXtcclxuXHRcdFx0XHRcdGNzc19kYXRlX19hZGRpdGlvbmFsICs9ICcgdGltZXNfY2xvY2snXHJcblx0XHRcdFx0fVxyXG5cclxuXHRcdFx0fVxyXG5cclxuXHRcdH1cclxuXHJcblx0XHQvLy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblxyXG5cdFx0cmV0dXJuIFsgdHJ1ZSwgY3NzX2RhdGVfX3N0YW5kYXJkICsgY3NzX2RhdGVfX2FkZGl0aW9uYWwgKyAnIGRhdGVfYXZhaWxhYmxlJyBdO1xyXG5cdH1cclxuXHJcblxyXG5cdC8qKlxyXG5cdCAqIEFwcGx5IHNvbWUgQ1NTIGNsYXNzZXMsIHdoZW4gd2UgbW91c2Ugb3ZlciBzcGVjaWZpYyBkYXRlcyBpbiBjYWxlbmRhclxyXG5cdCAqIEBwYXJhbSB2YWx1ZVxyXG5cdCAqIEBwYXJhbSBkYXRlXHRcdFx0XHRcdC0gIEphdmFTY3JpcHQgRGF0ZSBPYmo6ICBcdFx0TW9uIERlYyAxMSAyMDIzIDAwOjAwOjAwIEdNVCswMjAwIChFYXN0ZXJuIEV1cm9wZWFuIFN0YW5kYXJkIFRpbWUpXHJcblx0ICogQHBhcmFtIGNhbGVuZGFyX3BhcmFtc19hcnJcdC0gIENhbGVuZGFyIFNldHRpbmdzIE9iamVjdDogIFx0e1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0ICBcImh0bWxfaWRcIjogXCJjYWxlbmRhcl9ib29raW5nNFwiLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0ICBcInRleHRfaWRcIjogXCJkYXRlX2Jvb2tpbmc0XCIsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQgIFwiY2FsZW5kYXJfX3N0YXJ0X3dlZWtfZGF5XCI6IDEsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQgIFwiY2FsZW5kYXJfX3ZpZXdfX3Zpc2libGVfbW9udGhzXCI6IDEyLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0ICBcInJlc291cmNlX2lkXCI6IDQsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQgIFwiYWp4X25vbmNlX2NhbGVuZGFyXCI6IFwiPGlucHV0IHR5cGU9XFxcImhpZGRlblxcXCIgLi4uIC8+XCIsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQgIFwiYm9va2VkX2RhdGVzXCI6IHtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XCIxMi0yOC0yMDIyXCI6IFtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0ICB7XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XCJib29raW5nX2RhdGVcIjogXCIyMDIyLTEyLTI4IDAwOjAwOjAwXCIsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XCJhcHByb3ZlZFwiOiBcIjFcIixcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcImJvb2tpbmdfaWRcIjogXCIyNlwiXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCAgfVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRdLCAuLi5cclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnc2Vhc29uX2F2YWlsYWJpbGl0eSc6e1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFwiMjAyMy0wMS0wOVwiOiB0cnVlLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFwiMjAyMy0wMS0xMFwiOiB0cnVlLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFwiMjAyMy0wMS0xMVwiOiB0cnVlLCAuLi5cclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0ICB9XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHR9XHJcblx0ICogQHBhcmFtIGRhdGVwaWNrX3RoaXNcdFx0XHQtIHRoaXMgb2YgZGF0ZXBpY2sgT2JqXHJcblx0ICpcclxuXHQgKiBAcmV0dXJucyB7Ym9vbGVhbn1cclxuXHQgKi9cclxuXHRmdW5jdGlvbiB3cGJjX19pbmxpbmVfYm9va2luZ19jYWxlbmRhcl9fb25fZGF5c19ob3ZlciggdmFsdWUsIGRhdGUsIGNhbGVuZGFyX3BhcmFtc19hcnIsIGRhdGVwaWNrX3RoaXMgKXtcclxuXHJcblx0XHRpZiAoIG51bGwgPT09IGRhdGUgKXtcclxuXHRcdFx0alF1ZXJ5KCAnLmRhdGVwaWNrLWRheXMtY2VsbC1vdmVyJyApLnJlbW92ZUNsYXNzKCAnZGF0ZXBpY2stZGF5cy1jZWxsLW92ZXInICk7ICAgXHQgICAgICAgICAgICAgICAgICAgICAgICAvLyBjbGVhciBhbGwgaGlnaGxpZ2h0IGRheXMgc2VsZWN0aW9uc1xyXG5cdFx0XHRyZXR1cm4gZmFsc2U7XHJcblx0XHR9XHJcblxyXG5cdFx0dmFyIGluc3QgPSBqUXVlcnkuZGF0ZXBpY2suX2dldEluc3QoIGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCAnY2FsZW5kYXJfYm9va2luZycgKyBjYWxlbmRhcl9wYXJhbXNfYXJyLnJlc291cmNlX2lkICkgKTtcclxuXHJcblx0XHRpZiAoXHJcblx0XHRcdCAgICggMSA9PSBpbnN0LmRhdGVzLmxlbmd0aClcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQvLyBJZiB3ZSBoYXZlIG9uZSBzZWxlY3RlZCBkYXRlXHJcblx0XHRcdCYmICgnZHluYW1pYycgPT09IGNhbGVuZGFyX3BhcmFtc19hcnIuY2FsZW5kYXJfX2RheXNfc2VsZWN0aW9uX21vZGUpIFx0XHRcdFx0XHQvLyB3aGlsZSBoYXZlIHJhbmdlIGRheXMgc2VsZWN0aW9uIG1vZGVcclxuXHRcdCl7XHJcblxyXG5cdFx0XHR2YXIgdGRfY2xhc3M7XHJcblx0XHRcdHZhciB0ZF9vdmVycyA9IFtdO1xyXG5cdFx0XHR2YXIgaXNfY2hlY2sgPSB0cnVlO1xyXG4gICAgICAgICAgICB2YXIgc2VsY2V0ZWRfZmlyc3RfZGF5ID0gbmV3IERhdGUoKTtcclxuICAgICAgICAgICAgc2VsY2V0ZWRfZmlyc3RfZGF5LnNldEZ1bGxZZWFyKGluc3QuZGF0ZXNbMF0uZ2V0RnVsbFllYXIoKSwoaW5zdC5kYXRlc1swXS5nZXRNb250aCgpKSwgKGluc3QuZGF0ZXNbMF0uZ2V0RGF0ZSgpICkgKTsgLy9HZXQgZmlyc3QgRGF0ZVxyXG5cclxuICAgICAgICAgICAgd2hpbGUoICBpc19jaGVjayApe1xyXG5cclxuXHRcdFx0XHR0ZF9jbGFzcyA9IChzZWxjZXRlZF9maXJzdF9kYXkuZ2V0TW9udGgoKSArIDEpICsgJy0nICsgc2VsY2V0ZWRfZmlyc3RfZGF5LmdldERhdGUoKSArICctJyArIHNlbGNldGVkX2ZpcnN0X2RheS5nZXRGdWxsWWVhcigpO1xyXG5cclxuXHRcdFx0XHR0ZF9vdmVyc1sgdGRfb3ZlcnMubGVuZ3RoIF0gPSAnI2NhbGVuZGFyX2Jvb2tpbmcnICsgY2FsZW5kYXJfcGFyYW1zX2Fyci5yZXNvdXJjZV9pZCArICcgLmNhbDRkYXRlLScgKyB0ZF9jbGFzczsgICAgICAgICAgICAgIC8vIGFkZCB0byBhcnJheSBmb3IgbGF0ZXIgbWFrZSBzZWxlY3Rpb24gYnkgY2xhc3NcclxuXHJcbiAgICAgICAgICAgICAgICBpZiAoXHJcblx0XHRcdFx0XHQoICAoIGRhdGUuZ2V0TW9udGgoKSA9PSBzZWxjZXRlZF9maXJzdF9kYXkuZ2V0TW9udGgoKSApICAmJlxyXG4gICAgICAgICAgICAgICAgICAgICAgICggZGF0ZS5nZXREYXRlKCkgPT0gc2VsY2V0ZWRfZmlyc3RfZGF5LmdldERhdGUoKSApICAmJlxyXG4gICAgICAgICAgICAgICAgICAgICAgICggZGF0ZS5nZXRGdWxsWWVhcigpID09IHNlbGNldGVkX2ZpcnN0X2RheS5nZXRGdWxsWWVhcigpIClcclxuXHRcdFx0XHRcdCkgfHwgKCBzZWxjZXRlZF9maXJzdF9kYXkgPiBkYXRlIClcclxuXHRcdFx0XHQpe1xyXG5cdFx0XHRcdFx0aXNfY2hlY2sgPSAgZmFsc2U7XHJcblx0XHRcdFx0fVxyXG5cclxuXHRcdFx0XHRzZWxjZXRlZF9maXJzdF9kYXkuc2V0RnVsbFllYXIoIHNlbGNldGVkX2ZpcnN0X2RheS5nZXRGdWxsWWVhcigpLCAoc2VsY2V0ZWRfZmlyc3RfZGF5LmdldE1vbnRoKCkpLCAoc2VsY2V0ZWRfZmlyc3RfZGF5LmdldERhdGUoKSArIDEpICk7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdC8vIEhpZ2hsaWdodCBEYXlzXHJcblx0XHRcdGZvciAoIHZhciBpPTA7IGkgPCB0ZF9vdmVycy5sZW5ndGggOyBpKyspIHsgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgLy8gYWRkIGNsYXNzIHRvIGFsbCBlbGVtZW50c1xyXG5cdFx0XHRcdGpRdWVyeSggdGRfb3ZlcnNbaV0gKS5hZGRDbGFzcygnZGF0ZXBpY2stZGF5cy1jZWxsLW92ZXInKTtcclxuXHRcdFx0fVxyXG5cdFx0XHRyZXR1cm4gdHJ1ZTtcclxuXHJcblx0XHR9XHJcblxyXG5cdCAgICByZXR1cm4gdHJ1ZTtcclxuXHR9XHJcblxyXG5cclxuXHQvKipcclxuXHQgKiBPbiBEQVlzIHNlbGVjdGlvbiBpbiBjYWxlbmRhclxyXG5cdCAqXHJcblx0ICogQHBhcmFtIGRhdGVzX3NlbGVjdGlvblx0XHQtICBzdHJpbmc6XHRcdFx0ICcyMDIzLTAzLTA3IH4gMjAyMy0wMy0wNycgb3IgJzIwMjMtMDQtMTAsIDIwMjMtMDQtMTIsIDIwMjMtMDQtMDIsIDIwMjMtMDQtMDQnXHJcblx0ICogQHBhcmFtIGNhbGVuZGFyX3BhcmFtc19hcnJcdC0gIENhbGVuZGFyIFNldHRpbmdzIE9iamVjdDogIFx0e1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0ICBcImh0bWxfaWRcIjogXCJjYWxlbmRhcl9ib29raW5nNFwiLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0ICBcInRleHRfaWRcIjogXCJkYXRlX2Jvb2tpbmc0XCIsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQgIFwiY2FsZW5kYXJfX3N0YXJ0X3dlZWtfZGF5XCI6IDEsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQgIFwiY2FsZW5kYXJfX3ZpZXdfX3Zpc2libGVfbW9udGhzXCI6IDEyLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0ICBcInJlc291cmNlX2lkXCI6IDQsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQgIFwiYWp4X25vbmNlX2NhbGVuZGFyXCI6IFwiPGlucHV0IHR5cGU9XFxcImhpZGRlblxcXCIgLi4uIC8+XCIsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQgIFwiYm9va2VkX2RhdGVzXCI6IHtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XCIxMi0yOC0yMDIyXCI6IFtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0ICB7XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XCJib29raW5nX2RhdGVcIjogXCIyMDIyLTEyLTI4IDAwOjAwOjAwXCIsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XCJhcHByb3ZlZFwiOiBcIjFcIixcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcImJvb2tpbmdfaWRcIjogXCIyNlwiXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCAgfVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRdLCAuLi5cclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnc2Vhc29uX2F2YWlsYWJpbGl0eSc6e1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFwiMjAyMy0wMS0wOVwiOiB0cnVlLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFwiMjAyMy0wMS0xMFwiOiB0cnVlLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFwiMjAyMy0wMS0xMVwiOiB0cnVlLCAuLi5cclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0ICB9XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHR9XHJcblx0ICogQHBhcmFtIGRhdGVwaWNrX3RoaXNcdFx0XHQtIHRoaXMgb2YgZGF0ZXBpY2sgT2JqXHJcblx0ICpcclxuXHQgKiBAcmV0dXJucyBib29sZWFuXHJcblx0ICovXHJcblx0ZnVuY3Rpb24gd3BiY19faW5saW5lX2Jvb2tpbmdfY2FsZW5kYXJfX29uX2RheXNfc2VsZWN0KCBkYXRlc19zZWxlY3Rpb24sIGNhbGVuZGFyX3BhcmFtc19hcnIsIGRhdGVwaWNrX3RoaXMgPSBudWxsICl7XHJcblxyXG5cdFx0dmFyIGluc3QgPSBqUXVlcnkuZGF0ZXBpY2suX2dldEluc3QoIGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCAnY2FsZW5kYXJfYm9va2luZycgKyBjYWxlbmRhcl9wYXJhbXNfYXJyLnJlc291cmNlX2lkICkgKTtcclxuXHJcblx0XHR2YXIgZGF0ZXNfYXJyID0gW107XHQvLyAgWyBcIjIwMjMtMDQtMDlcIiwgXCIyMDIzLTA0LTEwXCIsIFwiMjAyMy0wNC0xMVwiIF1cclxuXHJcblx0XHRpZiAoIC0xICE9PSBkYXRlc19zZWxlY3Rpb24uaW5kZXhPZiggJ34nICkgKSB7ICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIC8vIFJhbmdlIERheXNcclxuXHJcblx0XHRcdGRhdGVzX2FyciA9IHdwYmNfZ2V0X2RhdGVzX2Fycl9fZnJvbV9kYXRlc19yYW5nZV9qcygge1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J2RhdGVzX3NlcGFyYXRvcicgOiAnIH4gJywgICAgICAgICAgICAgICAgICAgICAgICAgLy8gICcgfiAnXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnZGF0ZXMnICAgICAgICAgICA6IGRhdGVzX3NlbGVjdGlvbiwgICAgXHRcdCAgIC8vICcyMDIzLTA0LTA0IH4gMjAyMy0wNC0wNydcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHR9ICk7XHJcblxyXG5cdFx0fSBlbHNlIHsgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIC8vIE11bHRpcGxlIERheXNcclxuXHRcdFx0ZGF0ZXNfYXJyID0gd3BiY19nZXRfZGF0ZXNfYXJyX19mcm9tX2RhdGVzX2NvbW1hX3NlcGFyYXRlZF9qcygge1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J2RhdGVzX3NlcGFyYXRvcicgOiAnLCAnLCAgICAgICAgICAgICAgICAgICAgICAgICBcdC8vICAnLCAnXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnZGF0ZXMnICAgICAgICAgICA6IGRhdGVzX3NlbGVjdGlvbiwgICAgXHRcdFx0Ly8gJzIwMjMtMDQtMTAsIDIwMjMtMDQtMTIsIDIwMjMtMDQtMDIsIDIwMjMtMDQtMDQnXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0fSApO1xyXG5cdFx0fVxyXG5cclxuXHRcdHdwYmNfYXZ5X2FmdGVyX2RheXNfc2VsZWN0aW9uX19zaG93X2hlbHBfaW5mbyh7XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnY2FsZW5kYXJfX2RheXNfc2VsZWN0aW9uX21vZGUnOiBjYWxlbmRhcl9wYXJhbXNfYXJyLmNhbGVuZGFyX19kYXlzX3NlbGVjdGlvbl9tb2RlLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J2RhdGVzX2FycicgICAgICAgICAgICAgICAgICAgIDogZGF0ZXNfYXJyLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J2RhdGVzX2NsaWNrX251bScgICAgICAgICAgICAgIDogaW5zdC5kYXRlcy5sZW5ndGgsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQncG9wb3Zlcl9oaW50cydcdFx0XHRcdFx0OiBjYWxlbmRhcl9wYXJhbXNfYXJyLnBvcG92ZXJfaGludHNcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHR9ICk7XHJcblx0XHRyZXR1cm4gdHJ1ZTtcclxuXHR9XHJcblxyXG5cdFx0LyoqXHJcblx0XHQgKiBTaG93IGhlbHAgaW5mbyBhdCB0aGUgdG9wICB0b29sYmFyIGFib3V0IHNlbGVjdGVkIGRhdGVzIGFuZCBmdXR1cmUgYWN0aW9uc1xyXG5cdFx0ICpcclxuXHRcdCAqIEBwYXJhbSBwYXJhbXNcclxuXHRcdCAqIFx0XHRcdFx0XHRFeGFtcGxlIDE6ICB7XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRjYWxlbmRhcl9fZGF5c19zZWxlY3Rpb25fbW9kZTogXCJkeW5hbWljXCIsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRkYXRlc19hcnI6ICBbIFwiMjAyMy0wNC0wM1wiIF0sXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRkYXRlc19jbGlja19udW06IDFcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdCdwb3BvdmVyX2hpbnRzJ1x0XHRcdFx0XHQ6IGNhbGVuZGFyX3BhcmFtc19hcnIucG9wb3Zlcl9oaW50c1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdH1cclxuXHRcdCAqIFx0XHRcdFx0XHRFeGFtcGxlIDI6ICB7XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRjYWxlbmRhcl9fZGF5c19zZWxlY3Rpb25fbW9kZTogXCJkeW5hbWljXCJcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdGRhdGVzX2FycjogQXJyYXkoMTApIFsgXCIyMDIzLTA0LTAzXCIsIFwiMjAyMy0wNC0wNFwiLCBcIjIwMjMtMDQtMDVcIiwg4oCmIF1cclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdGRhdGVzX2NsaWNrX251bTogMlxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0J3BvcG92ZXJfaGludHMnXHRcdFx0XHRcdDogY2FsZW5kYXJfcGFyYW1zX2Fyci5wb3BvdmVyX2hpbnRzXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0fVxyXG5cdFx0ICovXHJcblx0XHRmdW5jdGlvbiB3cGJjX2F2eV9hZnRlcl9kYXlzX3NlbGVjdGlvbl9fc2hvd19oZWxwX2luZm8oIHBhcmFtcyApe1xyXG4vLyBjb25zb2xlLmxvZyggcGFyYW1zICk7XHQvL1x0XHRbIFwiMjAyMy0wNC0wOVwiLCBcIjIwMjMtMDQtMTBcIiwgXCIyMDIzLTA0LTExXCIgXVxyXG5cclxuXHRcdFx0dmFyIG1lc3NhZ2UsIGNvbG9yO1xyXG5cdFx0XHRpZiAoalF1ZXJ5KCAnI3VpX2J0bl9hdnlfX3NldF9kYXlzX2F2YWlsYWJpbGl0eV9fYXZhaWxhYmxlJykuaXMoJzpjaGVja2VkJykpe1xyXG5cdFx0XHRcdCBtZXNzYWdlID0gcGFyYW1zLnBvcG92ZXJfaGludHMudG9vbGJhcl90ZXh0X2F2YWlsYWJsZTsvLydTZXQgZGF0ZXMgX0RBVEVTXyBhcyBfSFRNTF8gYXZhaWxhYmxlLic7XHJcblx0XHRcdFx0IGNvbG9yID0gJyMxMWJlNGMnO1xyXG5cdFx0XHR9IGVsc2Uge1xyXG5cdFx0XHRcdG1lc3NhZ2UgPSBwYXJhbXMucG9wb3Zlcl9oaW50cy50b29sYmFyX3RleHRfdW5hdmFpbGFibGU7Ly8nU2V0IGRhdGVzIF9EQVRFU18gYXMgX0hUTUxfIHVuYXZhaWxhYmxlLic7XHJcblx0XHRcdFx0Y29sb3IgPSAnI2U0MzkzOSc7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdG1lc3NhZ2UgPSAnPHNwYW4+JyArIG1lc3NhZ2UgKyAnPC9zcGFuPic7XHJcblxyXG5cdFx0XHR2YXIgZmlyc3RfZGF0ZSA9IHBhcmFtc1sgJ2RhdGVzX2FycicgXVsgMCBdO1xyXG5cdFx0XHR2YXIgbGFzdF9kYXRlICA9ICggJ2R5bmFtaWMnID09IHBhcmFtcy5jYWxlbmRhcl9fZGF5c19zZWxlY3Rpb25fbW9kZSApXHJcblx0XHRcdFx0XHRcdFx0PyBwYXJhbXNbICdkYXRlc19hcnInIF1bIChwYXJhbXNbICdkYXRlc19hcnInIF0ubGVuZ3RoIC0gMSkgXVxyXG5cdFx0XHRcdFx0XHRcdDogKCBwYXJhbXNbICdkYXRlc19hcnInIF0ubGVuZ3RoID4gMSApID8gcGFyYW1zWyAnZGF0ZXNfYXJyJyBdWyAxIF0gOiAnJztcclxuXHJcblx0XHRcdGZpcnN0X2RhdGUgPSBqUXVlcnkuZGF0ZXBpY2suZm9ybWF0RGF0ZSggJ2RkIE0sIHl5JywgbmV3IERhdGUoIGZpcnN0X2RhdGUgKyAnVDAwOjAwOjAwJyApICk7XHJcblx0XHRcdGxhc3RfZGF0ZSA9IGpRdWVyeS5kYXRlcGljay5mb3JtYXREYXRlKCAnZGQgTSwgeXknLCAgbmV3IERhdGUoIGxhc3RfZGF0ZSArICdUMDA6MDA6MDAnICkgKTtcclxuXHJcblxyXG5cdFx0XHRpZiAoICdkeW5hbWljJyA9PSBwYXJhbXMuY2FsZW5kYXJfX2RheXNfc2VsZWN0aW9uX21vZGUgKXtcclxuXHRcdFx0XHRpZiAoIDEgPT0gcGFyYW1zLmRhdGVzX2NsaWNrX251bSApe1xyXG5cdFx0XHRcdFx0bGFzdF9kYXRlID0gJ19fX19fX19fX19fJ1xyXG5cdFx0XHRcdH0gZWxzZSB7XHJcblx0XHRcdFx0XHRpZiAoICdmaXJzdF90aW1lJyA9PSBqUXVlcnkoICcud3BiY19hanhfYXZhaWxhYmlsaXR5X2NvbnRhaW5lcicgKS5hdHRyKCAnd3BiY19sb2FkZWQnICkgKXtcclxuXHRcdFx0XHRcdFx0alF1ZXJ5KCAnLndwYmNfYWp4X2F2YWlsYWJpbGl0eV9jb250YWluZXInICkuYXR0ciggJ3dwYmNfbG9hZGVkJywgJ2RvbmUnIClcclxuXHRcdFx0XHRcdFx0d3BiY19ibGlua19lbGVtZW50KCAnLndwYmNfd2lkZ2V0X2F2YWlsYWJsZV91bmF2YWlsYWJsZScsIDMsIDIyMCApO1xyXG5cdFx0XHRcdFx0fVxyXG5cdFx0XHRcdH1cclxuXHRcdFx0XHRtZXNzYWdlID0gbWVzc2FnZS5yZXBsYWNlKCAnX0RBVEVTXycsICAgICc8L3NwYW4+J1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0Ly8rICc8ZGl2PicgKyAnZnJvbScgKyAnPC9kaXY+J1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0KyAnPHNwYW4gY2xhc3M9XCJ3cGJjX2JpZ19kYXRlXCI+JyArIGZpcnN0X2RhdGUgKyAnPC9zcGFuPidcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCsgJzxzcGFuPicgKyAnLScgKyAnPC9zcGFuPidcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCsgJzxzcGFuIGNsYXNzPVwid3BiY19iaWdfZGF0ZVwiPicgKyBsYXN0X2RhdGUgKyAnPC9zcGFuPidcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCsgJzxzcGFuPicgKTtcclxuXHRcdFx0fSBlbHNlIHtcclxuXHRcdFx0XHQvLyBpZiAoIHBhcmFtc1sgJ2RhdGVzX2FycicgXS5sZW5ndGggPiAxICl7XHJcblx0XHRcdFx0Ly8gXHRsYXN0X2RhdGUgPSAnLCAnICsgbGFzdF9kYXRlO1xyXG5cdFx0XHRcdC8vIFx0bGFzdF9kYXRlICs9ICggcGFyYW1zWyAnZGF0ZXNfYXJyJyBdLmxlbmd0aCA+IDIgKSA/ICcsIC4uLicgOiAnJztcclxuXHRcdFx0XHQvLyB9IGVsc2Uge1xyXG5cdFx0XHRcdC8vIFx0bGFzdF9kYXRlPScnO1xyXG5cdFx0XHRcdC8vIH1cclxuXHRcdFx0XHR2YXIgZGF0ZXNfYXJyID0gW107XHJcblx0XHRcdFx0Zm9yKCB2YXIgaSA9IDA7IGkgPCBwYXJhbXNbICdkYXRlc19hcnInIF0ubGVuZ3RoOyBpKysgKXtcclxuXHRcdFx0XHRcdGRhdGVzX2Fyci5wdXNoKCAgalF1ZXJ5LmRhdGVwaWNrLmZvcm1hdERhdGUoICdkZCBNIHl5JywgIG5ldyBEYXRlKCBwYXJhbXNbICdkYXRlc19hcnInIF1bIGkgXSArICdUMDA6MDA6MDAnICkgKSAgKTtcclxuXHRcdFx0XHR9XHJcblx0XHRcdFx0Zmlyc3RfZGF0ZSA9IGRhdGVzX2Fyci5qb2luKCAnLCAnICk7XHJcblx0XHRcdFx0bWVzc2FnZSA9IG1lc3NhZ2UucmVwbGFjZSggJ19EQVRFU18nLCAgICAnPC9zcGFuPidcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCsgJzxzcGFuIGNsYXNzPVwid3BiY19iaWdfZGF0ZVwiPicgKyBmaXJzdF9kYXRlICsgJzwvc3Bhbj4nXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQrICc8c3Bhbj4nICk7XHJcblx0XHRcdH1cclxuXHRcdFx0bWVzc2FnZSA9IG1lc3NhZ2UucmVwbGFjZSggJ19IVE1MXycgLCAnPC9zcGFuPjxzcGFuIGNsYXNzPVwid3BiY19iaWdfdGV4dFwiIHN0eWxlPVwiY29sb3I6Jytjb2xvcisnO1wiPicpICsgJzxzcGFuPic7XHJcblxyXG5cdFx0XHQvL21lc3NhZ2UgKz0gJyA8ZGl2IHN0eWxlPVwibWFyZ2luLWxlZnQ6IDFlbTtcIj4nICsgJyBDbGljayBvbiBBcHBseSBidXR0b24gdG8gYXBwbHkgYXZhaWxhYmlsaXR5LicgKyAnPC9kaXY+JztcclxuXHJcblx0XHRcdG1lc3NhZ2UgPSAnPGRpdiBjbGFzcz1cIndwYmNfdG9vbGJhcl9kYXRlc19oaW50c1wiPicgKyBtZXNzYWdlICsgJzwvZGl2Pic7XHJcblxyXG5cdFx0XHRqUXVlcnkoICcud3BiY19oZWxwX3RleHQnICkuaHRtbChcdG1lc3NhZ2UgKTtcclxuXHRcdH1cclxuXHJcblx0LyoqXHJcblx0ICogICBQYXJzZSBkYXRlcyAgLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLSAqL1xyXG5cclxuXHRcdC8qKlxyXG5cdFx0ICogR2V0IGRhdGVzIGFycmF5LCAgZnJvbSBjb21tYSBzZXBhcmF0ZWQgZGF0ZXNcclxuXHRcdCAqXHJcblx0XHQgKiBAcGFyYW0gcGFyYW1zICAgICAgID0ge1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0KiAnZGF0ZXNfc2VwYXJhdG9yJyA9PiAnLCAnLCAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAvLyBEYXRlcyBzZXBhcmF0b3JcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdCogJ2RhdGVzJyAgICAgICAgICAgPT4gJzIwMjMtMDQtMDQsIDIwMjMtMDQtMDcsIDIwMjMtMDQtMDUnICAgICAgICAgLy8gRGF0ZXMgaW4gJ1ktbS1kJyBmb3JtYXQ6ICcyMDIzLTAxLTMxJ1xyXG5cdFx0XHRcdFx0XHRcdFx0IH1cclxuXHRcdCAqXHJcblx0XHQgKiBAcmV0dXJuIGFycmF5ICAgICAgPSBbXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHQqIFswXSA9PiAyMDIzLTA0LTA0XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHQqIFsxXSA9PiAyMDIzLTA0LTA1XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHQqIFsyXSA9PiAyMDIzLTA0LTA2XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHQqIFszXSA9PiAyMDIzLTA0LTA3XHJcblx0XHRcdFx0XHRcdFx0XHRdXHJcblx0XHQgKlxyXG5cdFx0ICogRXhhbXBsZSAjMTogIHdwYmNfZ2V0X2RhdGVzX2Fycl9fZnJvbV9kYXRlc19jb21tYV9zZXBhcmF0ZWRfanMoICB7ICAnZGF0ZXNfc2VwYXJhdG9yJyA6ICcsICcsICdkYXRlcycgOiAnMjAyMy0wNC0wNCwgMjAyMy0wNC0wNywgMjAyMy0wNC0wNScgIH0gICk7XHJcblx0XHQgKi9cclxuXHRcdGZ1bmN0aW9uIHdwYmNfZ2V0X2RhdGVzX2Fycl9fZnJvbV9kYXRlc19jb21tYV9zZXBhcmF0ZWRfanMoIHBhcmFtcyApe1xyXG5cclxuXHRcdFx0dmFyIGRhdGVzX2FyciA9IFtdO1xyXG5cclxuXHRcdFx0aWYgKCAnJyAhPT0gcGFyYW1zWyAnZGF0ZXMnIF0gKXtcclxuXHJcblx0XHRcdFx0ZGF0ZXNfYXJyID0gcGFyYW1zWyAnZGF0ZXMnIF0uc3BsaXQoIHBhcmFtc1sgJ2RhdGVzX3NlcGFyYXRvcicgXSApO1xyXG5cclxuXHRcdFx0XHRkYXRlc19hcnIuc29ydCgpO1xyXG5cdFx0XHR9XHJcblx0XHRcdHJldHVybiBkYXRlc19hcnI7XHJcblx0XHR9XHJcblxyXG5cdFx0LyoqXHJcblx0XHQgKiBHZXQgZGF0ZXMgYXJyYXksICBmcm9tIHJhbmdlIGRheXMgc2VsZWN0aW9uXHJcblx0XHQgKlxyXG5cdFx0ICogQHBhcmFtIHBhcmFtcyAgICAgICA9ICB7XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHQqICdkYXRlc19zZXBhcmF0b3InID0+ICcgfiAnLCAgICAgICAgICAgICAgICAgICAgICAgICAvLyBEYXRlcyBzZXBhcmF0b3JcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdCogJ2RhdGVzJyAgICAgICAgICAgPT4gJzIwMjMtMDQtMDQgfiAyMDIzLTA0LTA3JyAgICAgIC8vIERhdGVzIGluICdZLW0tZCcgZm9ybWF0OiAnMjAyMy0wMS0zMSdcclxuXHRcdFx0XHRcdFx0XHRcdCAgfVxyXG5cdFx0ICpcclxuXHRcdCAqIEByZXR1cm4gYXJyYXkgICAgICAgID0gW1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0KiBbMF0gPT4gMjAyMy0wNC0wNFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0KiBbMV0gPT4gMjAyMy0wNC0wNVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0KiBbMl0gPT4gMjAyMy0wNC0wNlxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0KiBbM10gPT4gMjAyMy0wNC0wN1xyXG5cdFx0XHRcdFx0XHRcdFx0ICBdXHJcblx0XHQgKlxyXG5cdFx0ICogRXhhbXBsZSAjMTogIHdwYmNfZ2V0X2RhdGVzX2Fycl9fZnJvbV9kYXRlc19yYW5nZV9qcyggIHsgICdkYXRlc19zZXBhcmF0b3InIDogJyB+ICcsICdkYXRlcycgOiAnMjAyMy0wNC0wNCB+IDIwMjMtMDQtMDcnICB9ICApO1xyXG5cdFx0ICogRXhhbXBsZSAjMjogIHdwYmNfZ2V0X2RhdGVzX2Fycl9fZnJvbV9kYXRlc19yYW5nZV9qcyggIHsgICdkYXRlc19zZXBhcmF0b3InIDogJyAtICcsICdkYXRlcycgOiAnMjAyMy0wNC0wNCAtIDIwMjMtMDQtMDcnICB9ICApO1xyXG5cdFx0ICovXHJcblx0XHRmdW5jdGlvbiB3cGJjX2dldF9kYXRlc19hcnJfX2Zyb21fZGF0ZXNfcmFuZ2VfanMoIHBhcmFtcyApe1xyXG5cclxuXHRcdFx0dmFyIGRhdGVzX2FyciA9IFtdO1xyXG5cclxuXHRcdFx0aWYgKCAnJyAhPT0gcGFyYW1zWydkYXRlcyddICkge1xyXG5cclxuXHRcdFx0XHRkYXRlc19hcnIgPSBwYXJhbXNbICdkYXRlcycgXS5zcGxpdCggcGFyYW1zWyAnZGF0ZXNfc2VwYXJhdG9yJyBdICk7XHJcblx0XHRcdFx0dmFyIGNoZWNrX2luX2RhdGVfeW1kICA9IGRhdGVzX2FyclswXTtcclxuXHRcdFx0XHR2YXIgY2hlY2tfb3V0X2RhdGVfeW1kID0gZGF0ZXNfYXJyWzFdO1xyXG5cclxuXHRcdFx0XHRpZiAoICgnJyAhPT0gY2hlY2tfaW5fZGF0ZV95bWQpICYmICgnJyAhPT0gY2hlY2tfb3V0X2RhdGVfeW1kKSApe1xyXG5cclxuXHRcdFx0XHRcdGRhdGVzX2FyciA9IHdwYmNfZ2V0X2RhdGVzX2FycmF5X2Zyb21fc3RhcnRfZW5kX2RheXNfanMoIGNoZWNrX2luX2RhdGVfeW1kLCBjaGVja19vdXRfZGF0ZV95bWQgKTtcclxuXHRcdFx0XHR9XHJcblx0XHRcdH1cclxuXHRcdFx0cmV0dXJuIGRhdGVzX2FycjtcclxuXHRcdH1cclxuXHJcblx0XHRcdC8qKlxyXG5cdFx0XHQgKiBHZXQgZGF0ZXMgYXJyYXkgYmFzZWQgb24gc3RhcnQgYW5kIGVuZCBkYXRlcy5cclxuXHRcdFx0ICpcclxuXHRcdFx0ICogQHBhcmFtIHN0cmluZyBzU3RhcnREYXRlIC0gc3RhcnQgZGF0ZTogMjAyMy0wNC0wOVxyXG5cdFx0XHQgKiBAcGFyYW0gc3RyaW5nIHNFbmREYXRlICAgLSBlbmQgZGF0ZTogICAyMDIzLTA0LTExXHJcblx0XHRcdCAqIEByZXR1cm4gYXJyYXkgICAgICAgICAgICAgLSBbIFwiMjAyMy0wNC0wOVwiLCBcIjIwMjMtMDQtMTBcIiwgXCIyMDIzLTA0LTExXCIgXVxyXG5cdFx0XHQgKi9cclxuXHRcdFx0ZnVuY3Rpb24gd3BiY19nZXRfZGF0ZXNfYXJyYXlfZnJvbV9zdGFydF9lbmRfZGF5c19qcyggc1N0YXJ0RGF0ZSwgc0VuZERhdGUgKXtcclxuXHJcblx0XHRcdFx0c1N0YXJ0RGF0ZSA9IG5ldyBEYXRlKCBzU3RhcnREYXRlICsgJ1QwMDowMDowMCcgKTtcclxuXHRcdFx0XHRzRW5kRGF0ZSA9IG5ldyBEYXRlKCBzRW5kRGF0ZSArICdUMDA6MDA6MDAnICk7XHJcblxyXG5cdFx0XHRcdHZhciBhRGF5cz1bXTtcclxuXHJcblx0XHRcdFx0Ly8gU3RhcnQgdGhlIHZhcmlhYmxlIG9mZiB3aXRoIHRoZSBzdGFydCBkYXRlXHJcblx0XHRcdFx0YURheXMucHVzaCggc1N0YXJ0RGF0ZS5nZXRUaW1lKCkgKTtcclxuXHJcblx0XHRcdFx0Ly8gU2V0IGEgJ3RlbXAnIHZhcmlhYmxlLCBzQ3VycmVudERhdGUsIHdpdGggdGhlIHN0YXJ0IGRhdGUgLSBiZWZvcmUgYmVnaW5uaW5nIHRoZSBsb29wXHJcblx0XHRcdFx0dmFyIHNDdXJyZW50RGF0ZSA9IG5ldyBEYXRlKCBzU3RhcnREYXRlLmdldFRpbWUoKSApO1xyXG5cdFx0XHRcdHZhciBvbmVfZGF5X2R1cmF0aW9uID0gMjQqNjAqNjAqMTAwMDtcclxuXHJcblx0XHRcdFx0Ly8gV2hpbGUgdGhlIGN1cnJlbnQgZGF0ZSBpcyBsZXNzIHRoYW4gdGhlIGVuZCBkYXRlXHJcblx0XHRcdFx0d2hpbGUoc0N1cnJlbnREYXRlIDwgc0VuZERhdGUpe1xyXG5cdFx0XHRcdFx0Ly8gQWRkIGEgZGF5IHRvIHRoZSBjdXJyZW50IGRhdGUgXCIrMSBkYXlcIlxyXG5cdFx0XHRcdFx0c0N1cnJlbnREYXRlLnNldFRpbWUoIHNDdXJyZW50RGF0ZS5nZXRUaW1lKCkgKyBvbmVfZGF5X2R1cmF0aW9uICk7XHJcblxyXG5cdFx0XHRcdFx0Ly8gQWRkIHRoaXMgbmV3IGRheSB0byB0aGUgYURheXMgYXJyYXlcclxuXHRcdFx0XHRcdGFEYXlzLnB1c2goIHNDdXJyZW50RGF0ZS5nZXRUaW1lKCkgKTtcclxuXHRcdFx0XHR9XHJcblxyXG5cdFx0XHRcdGZvciAobGV0IGkgPSAwOyBpIDwgYURheXMubGVuZ3RoOyBpKyspIHtcclxuXHRcdFx0XHRcdGFEYXlzWyBpIF0gPSBuZXcgRGF0ZSggYURheXNbaV0gKTtcclxuXHRcdFx0XHRcdGFEYXlzWyBpIF0gPSBhRGF5c1sgaSBdLmdldEZ1bGxZZWFyKClcclxuXHRcdFx0XHRcdFx0XHRcdCsgJy0nICsgKCggKGFEYXlzWyBpIF0uZ2V0TW9udGgoKSArIDEpIDwgMTApID8gJzAnIDogJycpICsgKGFEYXlzWyBpIF0uZ2V0TW9udGgoKSArIDEpXHJcblx0XHRcdFx0XHRcdFx0XHQrICctJyArICgoICAgICAgICBhRGF5c1sgaSBdLmdldERhdGUoKSA8IDEwKSA/ICcwJyA6ICcnKSArICBhRGF5c1sgaSBdLmdldERhdGUoKTtcclxuXHRcdFx0XHR9XHJcblx0XHRcdFx0Ly8gT25jZSB0aGUgbG9vcCBoYXMgZmluaXNoZWQsIHJldHVybiB0aGUgYXJyYXkgb2YgZGF5cy5cclxuXHRcdFx0XHRyZXR1cm4gYURheXM7XHJcblx0XHRcdH1cclxuXHJcblxyXG5cclxuXHQvKipcclxuXHQgKiAgIFRvb2x0aXBzICAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tICovXHJcblxyXG5cdC8qKlxyXG5cdCAqIERlZmluZSBzaG93aW5nIHRvb2x0aXAsICB3aGVuICBtb3VzZSBvdmVyIG9uICBTRUxFQ1RBQkxFIChhdmFpbGFibGUsIHBlbmRpbmcsIGFwcHJvdmVkLCByZXNvdXJjZSB1bmF2YWlsYWJsZSksICBkYXlzXHJcblx0ICogQ2FuIGJlIGNhbGxlZCBkaXJlY3RseSAgZnJvbSAgZGF0ZXBpY2sgaW5pdCBmdW5jdGlvbi5cclxuXHQgKlxyXG5cdCAqIEBwYXJhbSB2YWx1ZVxyXG5cdCAqIEBwYXJhbSBkYXRlXHJcblx0ICogQHBhcmFtIGNhbGVuZGFyX3BhcmFtc19hcnJcclxuXHQgKiBAcGFyYW0gZGF0ZXBpY2tfdGhpc1xyXG5cdCAqIEByZXR1cm5zIHtib29sZWFufVxyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfYXZ5X19wcmVwYXJlX3Rvb2x0aXBfX2luX2NhbGVuZGFyKCB2YWx1ZSwgZGF0ZSwgY2FsZW5kYXJfcGFyYW1zX2FyciwgZGF0ZXBpY2tfdGhpcyApe1xyXG5cclxuXHRcdGlmICggbnVsbCA9PSBkYXRlICl7ICByZXR1cm4gZmFsc2U7ICB9XHJcblxyXG5cdFx0dmFyIHRkX2NsYXNzID0gKCBkYXRlLmdldE1vbnRoKCkgKyAxICkgKyAnLScgKyBkYXRlLmdldERhdGUoKSArICctJyArIGRhdGUuZ2V0RnVsbFllYXIoKTtcclxuXHJcblx0XHR2YXIgakNlbGwgPSBqUXVlcnkoICcjY2FsZW5kYXJfYm9va2luZycgKyBjYWxlbmRhcl9wYXJhbXNfYXJyLnJlc291cmNlX2lkICsgJyB0ZC5jYWw0ZGF0ZS0nICsgdGRfY2xhc3MgKTtcclxuXHJcblx0XHR3cGJjX2F2eV9fc2hvd190b29sdGlwX19mb3JfZWxlbWVudCggakNlbGwsIGNhbGVuZGFyX3BhcmFtc19hcnJbICdwb3BvdmVyX2hpbnRzJyBdICk7XHJcblx0XHRyZXR1cm4gdHJ1ZTtcclxuXHR9XHJcblxyXG5cclxuXHQvKipcclxuXHQgKiBEZWZpbmUgdG9vbHRpcCAgZm9yIHNob3dpbmcgb24gVU5BVkFJTEFCTEUgZGF5cyAoc2Vhc29uLCB3ZWVrZGF5LCB0b2RheV9kZXBlbmRzIHVuYXZhaWxhYmxlKVxyXG5cdCAqXHJcblx0ICogQHBhcmFtIGpDZWxsXHRcdFx0XHRcdGpRdWVyeSBvZiBzcGVjaWZpYyBkYXkgY2VsbFxyXG5cdCAqIEBwYXJhbSBwb3BvdmVyX2hpbnRzXHRcdCAgICBBcnJheSB3aXRoIHRvb2x0aXAgaGludCB0ZXh0c1x0IDogeydzZWFzb25fdW5hdmFpbGFibGUnOicuLi4nLCd3ZWVrZGF5c191bmF2YWlsYWJsZSc6Jy4uLicsJ2JlZm9yZV9hZnRlcl91bmF2YWlsYWJsZSc6Jy4uLicsfVxyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfYXZ5X19zaG93X3Rvb2x0aXBfX2Zvcl9lbGVtZW50KCBqQ2VsbCwgcG9wb3Zlcl9oaW50cyApe1xyXG5cclxuXHRcdHZhciB0b29sdGlwX3RpbWUgPSAnJztcclxuXHJcblx0XHRpZiAoIGpDZWxsLmhhc0NsYXNzKCAnc2Vhc29uX3VuYXZhaWxhYmxlJyApICl7XHJcblx0XHRcdHRvb2x0aXBfdGltZSA9IHBvcG92ZXJfaGludHNbICdzZWFzb25fdW5hdmFpbGFibGUnIF07XHJcblx0XHR9IGVsc2UgaWYgKCBqQ2VsbC5oYXNDbGFzcyggJ3dlZWtkYXlzX3VuYXZhaWxhYmxlJyApICl7XHJcblx0XHRcdHRvb2x0aXBfdGltZSA9IHBvcG92ZXJfaGludHNbICd3ZWVrZGF5c191bmF2YWlsYWJsZScgXTtcclxuXHRcdH0gZWxzZSBpZiAoIGpDZWxsLmhhc0NsYXNzKCAnYmVmb3JlX2FmdGVyX3VuYXZhaWxhYmxlJyApICl7XHJcblx0XHRcdHRvb2x0aXBfdGltZSA9IHBvcG92ZXJfaGludHNbICdiZWZvcmVfYWZ0ZXJfdW5hdmFpbGFibGUnIF07XHJcblx0XHR9IGVsc2UgaWYgKCBqQ2VsbC5oYXNDbGFzcyggJ2RhdGUyYXBwcm92ZScgKSApe1xyXG5cclxuXHRcdH0gZWxzZSBpZiAoIGpDZWxsLmhhc0NsYXNzKCAnZGF0ZV9hcHByb3ZlZCcgKSApe1xyXG5cclxuXHRcdH0gZWxzZSB7XHJcblxyXG5cdFx0fVxyXG5cclxuXHRcdGpDZWxsLmF0dHIoICdkYXRhLWNvbnRlbnQnLCB0b29sdGlwX3RpbWUgKTtcclxuXHJcblx0XHR2YXIgdGRfZWwgPSBqQ2VsbC5nZXQoMCk7XHQvL2pRdWVyeSggJyNjYWxlbmRhcl9ib29raW5nJyArIGNhbGVuZGFyX3BhcmFtc19hcnIucmVzb3VyY2VfaWQgKyAnIHRkLmNhbDRkYXRlLScgKyB0ZF9jbGFzcyApLmdldCgwKTtcclxuXHJcblx0XHRpZiAoICggdW5kZWZpbmVkID09IHRkX2VsLl90aXBweSApICYmICggJycgIT0gdG9vbHRpcF90aW1lICkgKXtcclxuXHJcblx0XHRcdFx0d3BiY190aXBweSggdGRfZWwgLCB7XHJcblx0XHRcdFx0XHRjb250ZW50KCByZWZlcmVuY2UgKXtcclxuXHJcblx0XHRcdFx0XHRcdHZhciBwb3BvdmVyX2NvbnRlbnQgPSByZWZlcmVuY2UuZ2V0QXR0cmlidXRlKCAnZGF0YS1jb250ZW50JyApO1xyXG5cclxuXHRcdFx0XHRcdFx0cmV0dXJuICc8ZGl2IGNsYXNzPVwicG9wb3ZlciBwb3BvdmVyX3RpcHB5XCI+J1xyXG5cdFx0XHRcdFx0XHRcdFx0XHQrICc8ZGl2IGNsYXNzPVwicG9wb3Zlci1jb250ZW50XCI+J1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdCsgcG9wb3Zlcl9jb250ZW50XHJcblx0XHRcdFx0XHRcdFx0XHRcdCsgJzwvZGl2PidcclxuXHRcdFx0XHRcdFx0XHQgKyAnPC9kaXY+JztcclxuXHRcdFx0XHRcdH0sXHJcblx0XHRcdFx0XHRhbGxvd0hUTUwgICAgICAgIDogdHJ1ZSxcclxuXHRcdFx0XHRcdHRyaWdnZXJcdFx0XHQgOiAnbW91c2VlbnRlciBmb2N1cycsXHJcblx0XHRcdFx0XHRpbnRlcmFjdGl2ZSAgICAgIDogISB0cnVlLFxyXG5cdFx0XHRcdFx0aGlkZU9uQ2xpY2sgICAgICA6IHRydWUsXHJcblx0XHRcdFx0XHRpbnRlcmFjdGl2ZUJvcmRlcjogMTAsXHJcblx0XHRcdFx0XHRtYXhXaWR0aCAgICAgICAgIDogNTUwLFxyXG5cdFx0XHRcdFx0dGhlbWUgICAgICAgICAgICA6ICd3cGJjLXRpcHB5LXRpbWVzJyxcclxuXHRcdFx0XHRcdHBsYWNlbWVudCAgICAgICAgOiAndG9wJyxcclxuXHRcdFx0XHRcdGRlbGF5XHRcdFx0IDogWzQwMCwgMF0sXHRcdFx0Ly9GaXhJbjogOS40LjIuMlxyXG5cdFx0XHRcdFx0aWdub3JlQXR0cmlidXRlcyA6IHRydWUsXHJcblx0XHRcdFx0XHR0b3VjaFx0XHRcdCA6IHRydWUsXHRcdFx0XHQvL1snaG9sZCcsIDUwMF0sIC8vIDUwMG1zIGRlbGF5XHRcdFx0Ly9GaXhJbjogOS4yLjEuNVxyXG5cdFx0XHRcdFx0YXBwZW5kVG86ICgpID0+IGRvY3VtZW50LmJvZHksXHJcblx0XHRcdFx0fSk7XHJcblx0XHR9XHJcblx0fVxyXG5cclxuXHJcblxyXG5cclxuXHJcbi8qKlxyXG4gKiAgIEFqYXggIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLSAqL1xyXG5cclxuLyoqXHJcbiAqIFNlbmQgQWpheCBzaG93IHJlcXVlc3RcclxuICovXHJcbmZ1bmN0aW9uIHdwYmNfYWp4X2F2YWlsYWJpbGl0eV9fYWpheF9yZXF1ZXN0KCl7XHJcblxyXG5jb25zb2xlLmdyb3VwQ29sbGFwc2VkKCAnV1BCQ19BSlhfQVZBSUxBQklMSVRZJyApOyBjb25zb2xlLmxvZyggJyA9PSBCZWZvcmUgQWpheCBTZW5kIC0gc2VhcmNoX2dldF9hbGxfcGFyYW1zKCkgPT0gJyAsIHdwYmNfYWp4X2F2YWlsYWJpbGl0eS5zZWFyY2hfZ2V0X2FsbF9wYXJhbXMoKSApO1xyXG5cclxuXHR3cGJjX2F2YWlsYWJpbGl0eV9yZWxvYWRfYnV0dG9uX19zcGluX3N0YXJ0KCk7XHJcblxyXG5cdC8vIFN0YXJ0IEFqYXhcclxuXHRqUXVlcnkucG9zdCggd3BiY191cmxfYWpheCxcclxuXHRcdFx0XHR7XHJcblx0XHRcdFx0XHRhY3Rpb24gICAgICAgICAgOiAnV1BCQ19BSlhfQVZBSUxBQklMSVRZJyxcclxuXHRcdFx0XHRcdHdwYmNfYWp4X3VzZXJfaWQ6IHdwYmNfYWp4X2F2YWlsYWJpbGl0eS5nZXRfc2VjdXJlX3BhcmFtKCAndXNlcl9pZCcgKSxcclxuXHRcdFx0XHRcdG5vbmNlICAgICAgICAgICA6IHdwYmNfYWp4X2F2YWlsYWJpbGl0eS5nZXRfc2VjdXJlX3BhcmFtKCAnbm9uY2UnICksXHJcblx0XHRcdFx0XHR3cGJjX2FqeF9sb2NhbGUgOiB3cGJjX2FqeF9hdmFpbGFiaWxpdHkuZ2V0X3NlY3VyZV9wYXJhbSggJ2xvY2FsZScgKSxcclxuXHJcblx0XHRcdFx0XHRzZWFyY2hfcGFyYW1zXHQ6IHdwYmNfYWp4X2F2YWlsYWJpbGl0eS5zZWFyY2hfZ2V0X2FsbF9wYXJhbXMoKVxyXG5cdFx0XHRcdH0sXHJcblx0XHRcdFx0LyoqXHJcblx0XHRcdFx0ICogUyB1IGMgYyBlIHMgc1xyXG5cdFx0XHRcdCAqXHJcblx0XHRcdFx0ICogQHBhcmFtIHJlc3BvbnNlX2RhdGFcdFx0LVx0aXRzIG9iamVjdCByZXR1cm5lZCBmcm9tICBBamF4IC0gY2xhc3MtbGl2ZS1zZWFyY2cucGhwXHJcblx0XHRcdFx0ICogQHBhcmFtIHRleHRTdGF0dXNcdFx0LVx0J3N1Y2Nlc3MnXHJcblx0XHRcdFx0ICogQHBhcmFtIGpxWEhSXHRcdFx0XHQtXHRPYmplY3RcclxuXHRcdFx0XHQgKi9cclxuXHRcdFx0XHRmdW5jdGlvbiAoIHJlc3BvbnNlX2RhdGEsIHRleHRTdGF0dXMsIGpxWEhSICkge1xyXG5cclxuY29uc29sZS5sb2coICcgPT0gUmVzcG9uc2UgV1BCQ19BSlhfQVZBSUxBQklMSVRZID09ICcsIHJlc3BvbnNlX2RhdGEgKTsgY29uc29sZS5ncm91cEVuZCgpO1xyXG5cclxuXHRcdFx0XHRcdC8vIFByb2JhYmx5IEVycm9yXHJcblx0XHRcdFx0XHRpZiAoICh0eXBlb2YgcmVzcG9uc2VfZGF0YSAhPT0gJ29iamVjdCcpIHx8IChyZXNwb25zZV9kYXRhID09PSBudWxsKSApe1xyXG5cclxuXHRcdFx0XHRcdFx0d3BiY19hanhfYXZhaWxhYmlsaXR5X19zaG93X21lc3NhZ2UoIHJlc3BvbnNlX2RhdGEgKTtcclxuXHJcblx0XHRcdFx0XHRcdHJldHVybjtcclxuXHRcdFx0XHRcdH1cclxuXHJcblx0XHRcdFx0XHQvLyBSZWxvYWQgcGFnZSwgYWZ0ZXIgZmlsdGVyIHRvb2xiYXIgaGFzIGJlZW4gcmVzZXRcclxuXHRcdFx0XHRcdGlmICggICAgICAgKCAgICAgdW5kZWZpbmVkICE9IHJlc3BvbnNlX2RhdGFbICdhanhfY2xlYW5lZF9wYXJhbXMnIF0pXHJcblx0XHRcdFx0XHRcdFx0JiYgKCAncmVzZXRfZG9uZScgPT09IHJlc3BvbnNlX2RhdGFbICdhanhfY2xlYW5lZF9wYXJhbXMnIF1bICdkb19hY3Rpb24nIF0pXHJcblx0XHRcdFx0XHQpe1xyXG5cdFx0XHRcdFx0XHRsb2NhdGlvbi5yZWxvYWQoKTtcclxuXHRcdFx0XHRcdFx0cmV0dXJuO1xyXG5cdFx0XHRcdFx0fVxyXG5cclxuXHRcdFx0XHRcdC8vIFNob3cgbGlzdGluZ1xyXG5cdFx0XHRcdFx0d3BiY19hanhfYXZhaWxhYmlsaXR5X19wYWdlX2NvbnRlbnRfX3Nob3coIHJlc3BvbnNlX2RhdGFbICdhanhfZGF0YScgXSwgcmVzcG9uc2VfZGF0YVsgJ2FqeF9zZWFyY2hfcGFyYW1zJyBdICwgcmVzcG9uc2VfZGF0YVsgJ2FqeF9jbGVhbmVkX3BhcmFtcycgXSApO1xyXG5cclxuXHRcdFx0XHRcdC8vd3BiY19hanhfYXZhaWxhYmlsaXR5X19kZWZpbmVfdWlfaG9va3MoKTtcdFx0XHRcdFx0XHQvLyBSZWRlZmluZSBIb29rcywgYmVjYXVzZSB3ZSBzaG93IG5ldyBET00gZWxlbWVudHNcclxuXHRcdFx0XHRcdGlmICggJycgIT0gcmVzcG9uc2VfZGF0YVsgJ2FqeF9kYXRhJyBdWyAnYWp4X2FmdGVyX2FjdGlvbl9tZXNzYWdlJyBdLnJlcGxhY2UoIC9cXG4vZywgXCI8YnIgLz5cIiApICl7XHJcblx0XHRcdFx0XHRcdHdwYmNfYWRtaW5fc2hvd19tZXNzYWdlKFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCAgcmVzcG9uc2VfZGF0YVsgJ2FqeF9kYXRhJyBdWyAnYWp4X2FmdGVyX2FjdGlvbl9tZXNzYWdlJyBdLnJlcGxhY2UoIC9cXG4vZywgXCI8YnIgLz5cIiApXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0LCAoICcxJyA9PSByZXNwb25zZV9kYXRhWyAnYWp4X2RhdGEnIF1bICdhanhfYWZ0ZXJfYWN0aW9uX3Jlc3VsdCcgXSApID8gJ3N1Y2Nlc3MnIDogJ2Vycm9yJ1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCwgMTAwMDBcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0KTtcclxuXHRcdFx0XHRcdH1cclxuXHJcblx0XHRcdFx0XHR3cGJjX2F2YWlsYWJpbGl0eV9yZWxvYWRfYnV0dG9uX19zcGluX3BhdXNlKCk7XHJcblx0XHRcdFx0XHQvLyBSZW1vdmUgc3BpbiBpY29uIGZyb20gIGJ1dHRvbiBhbmQgRW5hYmxlIHRoaXMgYnV0dG9uLlxyXG5cdFx0XHRcdFx0d3BiY19idXR0b25fX3JlbW92ZV9zcGluKCByZXNwb25zZV9kYXRhWyAnYWp4X2NsZWFuZWRfcGFyYW1zJyBdWyAndWlfY2xpY2tlZF9lbGVtZW50X2lkJyBdIClcclxuXHJcblx0XHRcdFx0XHRqUXVlcnkoICcjYWpheF9yZXNwb25kJyApLmh0bWwoIHJlc3BvbnNlX2RhdGEgKTtcdFx0Ly8gRm9yIGFiaWxpdHkgdG8gc2hvdyByZXNwb25zZSwgYWRkIHN1Y2ggRElWIGVsZW1lbnQgdG8gcGFnZVxyXG5cdFx0XHRcdH1cclxuXHRcdFx0ICApLmZhaWwoIGZ1bmN0aW9uICgganFYSFIsIHRleHRTdGF0dXMsIGVycm9yVGhyb3duICkgeyAgICBpZiAoIHdpbmRvdy5jb25zb2xlICYmIHdpbmRvdy5jb25zb2xlLmxvZyApeyBjb25zb2xlLmxvZyggJ0FqYXhfRXJyb3InLCBqcVhIUiwgdGV4dFN0YXR1cywgZXJyb3JUaHJvd24gKTsgfVxyXG5cclxuXHRcdFx0XHRcdHZhciBlcnJvcl9tZXNzYWdlID0gJzxzdHJvbmc+JyArICdFcnJvciEnICsgJzwvc3Ryb25nPiAnICsgZXJyb3JUaHJvd24gO1xyXG5cdFx0XHRcdFx0aWYgKCBqcVhIUi5zdGF0dXMgKXtcclxuXHRcdFx0XHRcdFx0ZXJyb3JfbWVzc2FnZSArPSAnICg8Yj4nICsganFYSFIuc3RhdHVzICsgJzwvYj4pJztcclxuXHRcdFx0XHRcdFx0aWYgKDQwMyA9PSBqcVhIUi5zdGF0dXMgKXtcclxuXHRcdFx0XHRcdFx0XHRlcnJvcl9tZXNzYWdlICs9ICcgUHJvYmFibHkgbm9uY2UgZm9yIHRoaXMgcGFnZSBoYXMgYmVlbiBleHBpcmVkLiBQbGVhc2UgPGEgaHJlZj1cImphdmFzY3JpcHQ6dm9pZCgwKVwiIG9uY2xpY2s9XCJqYXZhc2NyaXB0OmxvY2F0aW9uLnJlbG9hZCgpO1wiPnJlbG9hZCB0aGUgcGFnZTwvYT4uJztcclxuXHRcdFx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0aWYgKCBqcVhIUi5yZXNwb25zZVRleHQgKXtcclxuXHRcdFx0XHRcdFx0ZXJyb3JfbWVzc2FnZSArPSAnICcgKyBqcVhIUi5yZXNwb25zZVRleHQ7XHJcblx0XHRcdFx0XHR9XHJcblx0XHRcdFx0XHRlcnJvcl9tZXNzYWdlID0gZXJyb3JfbWVzc2FnZS5yZXBsYWNlKCAvXFxuL2csIFwiPGJyIC8+XCIgKTtcclxuXHJcblx0XHRcdFx0XHR3cGJjX2FqeF9hdmFpbGFiaWxpdHlfX3Nob3dfbWVzc2FnZSggZXJyb3JfbWVzc2FnZSApO1xyXG5cdFx0XHQgIH0pXHJcblx0ICAgICAgICAgIC8vIC5kb25lKCAgIGZ1bmN0aW9uICggZGF0YSwgdGV4dFN0YXR1cywganFYSFIgKSB7ICAgaWYgKCB3aW5kb3cuY29uc29sZSAmJiB3aW5kb3cuY29uc29sZS5sb2cgKXsgY29uc29sZS5sb2coICdzZWNvbmQgc3VjY2VzcycsIGRhdGEsIHRleHRTdGF0dXMsIGpxWEhSICk7IH0gICAgfSlcclxuXHRcdFx0ICAvLyAuYWx3YXlzKCBmdW5jdGlvbiAoIGRhdGFfanFYSFIsIHRleHRTdGF0dXMsIGpxWEhSX2Vycm9yVGhyb3duICkgeyAgIGlmICggd2luZG93LmNvbnNvbGUgJiYgd2luZG93LmNvbnNvbGUubG9nICl7IGNvbnNvbGUubG9nKCAnYWx3YXlzIGZpbmlzaGVkJywgZGF0YV9qcVhIUiwgdGV4dFN0YXR1cywganFYSFJfZXJyb3JUaHJvd24gKTsgfSAgICAgfSlcclxuXHRcdFx0ICA7ICAvLyBFbmQgQWpheFxyXG5cclxufVxyXG5cclxuXHJcblxyXG4vKipcclxuICogICBIIG8gbyBrIHMgIC0gIGl0cyBBY3Rpb24vVGltZXMgd2hlbiBuZWVkIHRvIHJlLVJlbmRlciBWaWV3cyAgLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0gKi9cclxuXHJcbi8qKlxyXG4gKiBTZW5kIEFqYXggU2VhcmNoIFJlcXVlc3QgYWZ0ZXIgVXBkYXRpbmcgc2VhcmNoIHJlcXVlc3QgcGFyYW1ldGVyc1xyXG4gKlxyXG4gKiBAcGFyYW0gcGFyYW1zX2FyclxyXG4gKi9cclxuZnVuY3Rpb24gd3BiY19hanhfYXZhaWxhYmlsaXR5X19zZW5kX3JlcXVlc3Rfd2l0aF9wYXJhbXMgKCBwYXJhbXNfYXJyICl7XHJcblxyXG5cdC8vIERlZmluZSBkaWZmZXJlbnQgU2VhcmNoICBwYXJhbWV0ZXJzIGZvciByZXF1ZXN0XHJcblx0Xy5lYWNoKCBwYXJhbXNfYXJyLCBmdW5jdGlvbiAoIHBfdmFsLCBwX2tleSwgcF9kYXRhICkge1xyXG5cdFx0Ly9jb25zb2xlLmxvZyggJ1JlcXVlc3QgZm9yOiAnLCBwX2tleSwgcF92YWwgKTtcclxuXHRcdHdwYmNfYWp4X2F2YWlsYWJpbGl0eS5zZWFyY2hfc2V0X3BhcmFtKCBwX2tleSwgcF92YWwgKTtcclxuXHR9KTtcclxuXHJcblx0Ly8gU2VuZCBBamF4IFJlcXVlc3RcclxuXHR3cGJjX2FqeF9hdmFpbGFiaWxpdHlfX2FqYXhfcmVxdWVzdCgpO1xyXG59XHJcblxyXG5cclxuXHQvKipcclxuXHQgKiBTZWFyY2ggcmVxdWVzdCBmb3IgXCJQYWdlIE51bWJlclwiXHJcblx0ICogQHBhcmFtIHBhZ2VfbnVtYmVyXHRpbnRcclxuXHQgKi9cclxuXHRmdW5jdGlvbiB3cGJjX2FqeF9hdmFpbGFiaWxpdHlfX3BhZ2luYXRpb25fY2xpY2soIHBhZ2VfbnVtYmVyICl7XHJcblxyXG5cdFx0d3BiY19hanhfYXZhaWxhYmlsaXR5X19zZW5kX3JlcXVlc3Rfd2l0aF9wYXJhbXMoIHtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdCdwYWdlX251bSc6IHBhZ2VfbnVtYmVyXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0fSApO1xyXG5cdH1cclxuXHJcblxyXG5cclxuLyoqXHJcbiAqICAgU2hvdyAvIEhpZGUgQ29udGVudCAgLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tICovXHJcblxyXG4vKipcclxuICogIFNob3cgTGlzdGluZyBDb250ZW50IFx0LSBcdFNlbmRpbmcgQWpheCBSZXF1ZXN0XHQtXHR3aXRoIHBhcmFtZXRlcnMgdGhhdCAgd2UgZWFybHkgIGRlZmluZWRcclxuICovXHJcbmZ1bmN0aW9uIHdwYmNfYWp4X2F2YWlsYWJpbGl0eV9fYWN0dWFsX2NvbnRlbnRfX3Nob3coKXtcclxuXHJcblx0d3BiY19hanhfYXZhaWxhYmlsaXR5X19hamF4X3JlcXVlc3QoKTtcdFx0XHQvLyBTZW5kIEFqYXggUmVxdWVzdFx0LVx0d2l0aCBwYXJhbWV0ZXJzIHRoYXQgIHdlIGVhcmx5ICBkZWZpbmVkIGluIFwid3BiY19hanhfYm9va2luZ19saXN0aW5nXCIgT2JqLlxyXG59XHJcblxyXG4vKipcclxuICogSGlkZSBMaXN0aW5nIENvbnRlbnRcclxuICovXHJcbmZ1bmN0aW9uIHdwYmNfYWp4X2F2YWlsYWJpbGl0eV9fYWN0dWFsX2NvbnRlbnRfX2hpZGUoKXtcclxuXHJcblx0alF1ZXJ5KCAgd3BiY19hanhfYXZhaWxhYmlsaXR5LmdldF9vdGhlcl9wYXJhbSggJ2xpc3RpbmdfY29udGFpbmVyJyApICApLmh0bWwoICcnICk7XHJcbn1cclxuXHJcblxyXG5cclxuLyoqXHJcbiAqICAgTSBlIHMgcyBhIGcgZSAgLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tICovXHJcblxyXG4vKipcclxuICogU2hvdyBqdXN0IG1lc3NhZ2UgaW5zdGVhZCBvZiBjb250ZW50XHJcbiAqL1xyXG5mdW5jdGlvbiB3cGJjX2FqeF9hdmFpbGFiaWxpdHlfX3Nob3dfbWVzc2FnZSggbWVzc2FnZSApe1xyXG5cclxuXHR3cGJjX2FqeF9hdmFpbGFiaWxpdHlfX2FjdHVhbF9jb250ZW50X19oaWRlKCk7XHJcblxyXG5cdGpRdWVyeSggd3BiY19hanhfYXZhaWxhYmlsaXR5LmdldF9vdGhlcl9wYXJhbSggJ2xpc3RpbmdfY29udGFpbmVyJyApICkuaHRtbChcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0JzxkaXYgY2xhc3M9XCJ3cGJjLXNldHRpbmdzLW5vdGljZSBub3RpY2Utd2FybmluZ1wiIHN0eWxlPVwidGV4dC1hbGlnbjpsZWZ0XCI+JyArXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0bWVzc2FnZSArXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCc8L2Rpdj4nXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0KTtcclxufVxyXG5cclxuXHJcblxyXG4vKipcclxuICogICBTdXBwb3J0IEZ1bmN0aW9ucyAtIFNwaW4gSWNvbiBpbiBCdXR0b25zICAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0gKi9cclxuXHJcbi8qKlxyXG4gKiBTcGluIGJ1dHRvbiBpbiBGaWx0ZXIgdG9vbGJhciAgLSAgU3RhcnRcclxuICovXHJcbmZ1bmN0aW9uIHdwYmNfYXZhaWxhYmlsaXR5X3JlbG9hZF9idXR0b25fX3NwaW5fc3RhcnQoKXtcclxuXHRqUXVlcnkoICcjd3BiY19hdmFpbGFiaWxpdHlfcmVsb2FkX2J1dHRvbiAubWVudV9pY29uLndwYmNfc3BpbicpLnJlbW92ZUNsYXNzKCAnd3BiY19hbmltYXRpb25fcGF1c2UnICk7XHJcbn1cclxuXHJcbi8qKlxyXG4gKiBTcGluIGJ1dHRvbiBpbiBGaWx0ZXIgdG9vbGJhciAgLSAgUGF1c2VcclxuICovXHJcbmZ1bmN0aW9uIHdwYmNfYXZhaWxhYmlsaXR5X3JlbG9hZF9idXR0b25fX3NwaW5fcGF1c2UoKXtcclxuXHRqUXVlcnkoICcjd3BiY19hdmFpbGFiaWxpdHlfcmVsb2FkX2J1dHRvbiAubWVudV9pY29uLndwYmNfc3BpbicgKS5hZGRDbGFzcyggJ3dwYmNfYW5pbWF0aW9uX3BhdXNlJyApO1xyXG59XHJcblxyXG4vKipcclxuICogU3BpbiBidXR0b24gaW4gRmlsdGVyIHRvb2xiYXIgIC0gIGlzIFNwaW5uaW5nID9cclxuICpcclxuICogQHJldHVybnMge2Jvb2xlYW59XHJcbiAqL1xyXG5mdW5jdGlvbiB3cGJjX2F2YWlsYWJpbGl0eV9yZWxvYWRfYnV0dG9uX19pc19zcGluKCl7XHJcbiAgICBpZiAoIGpRdWVyeSggJyN3cGJjX2F2YWlsYWJpbGl0eV9yZWxvYWRfYnV0dG9uIC5tZW51X2ljb24ud3BiY19zcGluJyApLmhhc0NsYXNzKCAnd3BiY19hbmltYXRpb25fcGF1c2UnICkgKXtcclxuXHRcdHJldHVybiB0cnVlO1xyXG5cdH0gZWxzZSB7XHJcblx0XHRyZXR1cm4gZmFsc2U7XHJcblx0fVxyXG59XHJcbiJdLCJtYXBwaW5ncyI6IkFBQUEsWUFBWTs7QUFFWjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBSkEsU0FBQUEsUUFBQUMsR0FBQSxzQ0FBQUQsT0FBQSx3QkFBQUUsTUFBQSx1QkFBQUEsTUFBQSxDQUFBQyxRQUFBLGFBQUFGLEdBQUEsa0JBQUFBLEdBQUEsZ0JBQUFBLEdBQUEsV0FBQUEsR0FBQSx5QkFBQUMsTUFBQSxJQUFBRCxHQUFBLENBQUFHLFdBQUEsS0FBQUYsTUFBQSxJQUFBRCxHQUFBLEtBQUFDLE1BQUEsQ0FBQUcsU0FBQSxxQkFBQUosR0FBQSxLQUFBRCxPQUFBLENBQUFDLEdBQUE7QUFNQSxJQUFJSyxxQkFBcUIsR0FBSSxVQUFXTCxHQUFHLEVBQUVNLENBQUMsRUFBRTtFQUUvQztFQUNBLElBQUlDLFFBQVEsR0FBR1AsR0FBRyxDQUFDUSxZQUFZLEdBQUdSLEdBQUcsQ0FBQ1EsWUFBWSxJQUFJO0lBQ3hDQyxPQUFPLEVBQUUsQ0FBQztJQUNWQyxLQUFLLEVBQUksRUFBRTtJQUNYQyxNQUFNLEVBQUc7RUFDUixDQUFDO0VBRWhCWCxHQUFHLENBQUNZLGdCQUFnQixHQUFHLFVBQVdDLFNBQVMsRUFBRUMsU0FBUyxFQUFHO0lBQ3hEUCxRQUFRLENBQUVNLFNBQVMsQ0FBRSxHQUFH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
