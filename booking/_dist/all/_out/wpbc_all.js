"use strict";
/**
 * =====================================================================================================================
 *	includes/__js/wpbc/wpbc.js
 * =====================================================================================================================
 */

/**
 * Deep Clone of object or array
 *
 * @param obj
 * @returns {any}
 */

function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }

function wpbc_clone_obj(obj) {
  return JSON.parse(JSON.stringify(obj));
}
/**
 * Main _wpbc JS object
 */


var _wpbc = function (obj, $) {
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
  }; // Calendars 	----------------------------------------------------------------------------------------------------


  var p_calendars = obj.calendars_obj = obj.calendars_obj || {// sort            : "booking_id",
    // sort_type       : "DESC",
    // page_num        : 1,
    // page_items_count: 10,
    // create_date     : "",
    // keyword         : "",
    // source          : ""
  };
  /**
   *  Check if calendar for specific booking resource defined   ::   true | false
   *
   * @param {string|int} resource_id
   * @returns {boolean}
   */

  obj.calendar__is_defined = function (resource_id) {
    return 'undefined' !== typeof p_calendars['calendar_' + resource_id];
  };
  /**
   *  Create Calendar initializing
   *
   * @param {string|int} resource_id
   */


  obj.calendar__init = function (resource_id) {
    p_calendars['calendar_' + resource_id] = {};
    p_calendars['calendar_' + resource_id]['id'] = resource_id;
    p_calendars['calendar_' + resource_id]['pending_days_selectable'] = false;
  };
  /**
   * Check  if the type of this property  is INT
   * @param property_name
   * @returns {boolean}
   */


  obj.calendar__is_prop_int = function (property_name) {
    //FixIn: 9.9.0.29
    var p_calendar_int_properties = ['dynamic__days_min', 'dynamic__days_max', 'fixed__days_num'];
    var is_include = p_calendar_int_properties.includes(property_name);
    return is_include;
  };
  /**
   * Set params for all  calendars
   *
   * @param {object} calendars_obj		Object { calendar_1: {} }
   * 												 calendar_3: {}, ... }
   */


  obj.calendars_all__set = function (calendars_obj) {
    p_calendars = calendars_obj;
  };
  /**
   * Get bookings in all calendars
   *
   * @returns {object|{}}
   */


  obj.calendars_all__get = function () {
    return p_calendars;
  };
  /**
   * Get calendar object   ::   { id: 1, … }
   *
   * @param {string|int} resource_id				  '2'
   * @returns {object|boolean}					{ id: 2 ,… }
   */


  obj.calendar__get_parameters = function (resource_id) {
    if (obj.calendar__is_defined(resource_id)) {
      return p_calendars['calendar_' + resource_id];
    } else {
      return false;
    }
  };
  /**
   * Set calendar object   ::   { dates:  Object { "2023-07-21": {…}, "2023-07-22": {…}, "2023-07-23": {…}, … }
   *
   * if calendar object  not defined, then  it's will be defined and ID set
   * if calendar exist, then  system set  as new or overwrite only properties from calendar_property_obj parameter,  but other properties will be existed and not overwrite, like 'id'
   *
   * @param {string|int} resource_id				  '2'
   * @param {object} calendar_property_obj					  {  dates:  Object { "2023-07-21": {…}, "2023-07-22": {…}, "2023-07-23": {…}, … }  }
   * @param {boolean} is_complete_overwrite		  if 'true' (default: 'false'),  then  only overwrite or add  new properties in  calendar_property_obj
   * @returns {*}
   *
   * Examples:
   *
   * Common usage in PHP:
   *   			echo "  _wpbc.calendar__set(  " .intval( $resource_id ) . ", { 'dates': " . wp_json_encode( $availability_per_days_arr ) . " } );";
   */


  obj.calendar__set_parameters = function (resource_id, calendar_property_obj) {
    var is_complete_overwrite = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;

    if (!obj.calendar__is_defined(resource_id) || true === is_complete_overwrite) {
      obj.calendar__init(resource_id);
    }

    for (var prop_name in calendar_property_obj) {
      p_calendars['calendar_' + resource_id][prop_name] = calendar_property_obj[prop_name];
    }

    return p_calendars['calendar_' + resource_id];
  };
  /**
   * Set property  to  calendar
   * @param resource_id	"1"
   * @param prop_name		name of property
   * @param prop_value	value of property
   * @returns {*}			calendar object
   */


  obj.calendar__set_param_value = function (resource_id, prop_name, prop_value) {
    if (!obj.calendar__is_defined(resource_id)) {
      obj.calendar__init(resource_id);
    }

    p_calendars['calendar_' + resource_id][prop_name] = prop_value;
    return p_calendars['calendar_' + resource_id];
  };
  /**
   *  Get calendar property value   	::   mixed | null
   *
   * @param {string|int}  resource_id		'1'
   * @param {string} prop_name			'selection_mode'
   * @returns {*|null}					mixed | null
   */


  obj.calendar__get_param_value = function (resource_id, prop_name) {
    if (obj.calendar__is_defined(resource_id) && 'undefined' !== typeof p_calendars['calendar_' + resource_id][prop_name]) {
      //FixIn: 9.9.0.29
      if (obj.calendar__is_prop_int(prop_name)) {
        p_calendars['calendar_' + resource_id][prop_name] = parseInt(p_calendars['calendar_' + resource_id][prop_name]);
      }

      return p_calendars['calendar_' + resource_id][prop_name];
    }

    return null; // If some property not defined, then null;
  }; // -----------------------------------------------------------------------------------------------------------------
  // Bookings 	----------------------------------------------------------------------------------------------------


  var p_bookings = obj.bookings_obj = obj.bookings_obj || {// calendar_1: Object {
    //						   id:     1
    //						 , dates:  Object { "2023-07-21": {…}, "2023-07-22": {…}, "2023-07-23": {…}, …
    // }
  };
  /**
   *  Check if bookings for specific booking resource defined   ::   true | false
   *
   * @param {string|int} resource_id
   * @returns {boolean}
   */

  obj.bookings_in_calendar__is_defined = function (resource_id) {
    return 'undefined' !== typeof p_bookings['calendar_' + resource_id];
  };
  /**
   * Get bookings calendar object   ::   { id: 1 , dates:  Object { "2023-07-21": {…}, "2023-07-22": {…}, "2023-07-23": {…}, … }
   *
   * @param {string|int} resource_id				  '2'
   * @returns {object|boolean}					{ id: 2 , dates:  Object { "2023-07-21": {…}, "2023-07-22": {…}, "2023-07-23": {…}, … }
   */


  obj.bookings_in_calendar__get = function (resource_id) {
    if (obj.bookings_in_calendar__is_defined(resource_id)) {
      return p_bookings['calendar_' + resource_id];
    } else {
      return false;
    }
  };
  /**
   * Set bookings calendar object   ::   { dates:  Object { "2023-07-21": {…}, "2023-07-22": {…}, "2023-07-23": {…}, … }
   *
   * if calendar object  not defined, then  it's will be defined and ID set
   * if calendar exist, then  system set  as new or overwrite only properties from calendar_obj parameter,  but other properties will be existed and not overwrite, like 'id'
   *
   * @param {string|int} resource_id				  '2'
   * @param {object} calendar_obj					  {  dates:  Object { "2023-07-21": {…}, "2023-07-22": {…}, "2023-07-23": {…}, … }  }
   * @returns {*}
   *
   * Examples:
   *
   * Common usage in PHP:
   *   			echo "  _wpbc.bookings_in_calendar__set(  " .intval( $resource_id ) . ", { 'dates': " . wp_json_encode( $availability_per_days_arr ) . " } );";
   */


  obj.bookings_in_calendar__set = function (resource_id, calendar_obj) {
    if (!obj.bookings_in_calendar__is_defined(resource_id)) {
      p_bookings['calendar_' + resource_id] = {};
      p_bookings['calendar_' + resource_id]['id'] = resource_id;
    }

    for (var prop_name in calendar_obj) {
      p_bookings['calendar_' + resource_id][prop_name] = calendar_obj[prop_name];
    }

    return p_bookings['calendar_' + resource_id];
  }; // Dates

  /**
   *  Get bookings data for ALL Dates in calendar   ::   false | { "2023-07-22": {…}, "2023-07-23": {…}, … }
   *
   * @param {string|int} resource_id			'1'
   * @returns {object|boolean}				false | Object {
  															"2023-07-24": Object { ['summary']['status_for_day']: "available", day_availability: 1, max_capacity: 1, … }
  															"2023-07-26": Object { ['summary']['status_for_day']: "full_day_booking", ['summary']['status_for_bookings']: "pending", day_availability: 0, … }
  															"2023-07-29": Object { ['summary']['status_for_day']: "resource_availability", day_availability: 0, max_capacity: 1, … }
  															"2023-07-30": {…}, "2023-07-31": {…}, …
  														}
   */


  obj.bookings_in_calendar__get_dates = function (resource_id) {
    if (obj.bookings_in_calendar__is_defined(resource_id) && 'undefined' !== typeof p_bookings['calendar_' + resource_id]['dates']) {
      return p_bookings['calendar_' + resource_id]['dates'];
    }

    return false; // If some property not defined, then false;
  };
  /**
   * Set bookings dates in calendar object   ::    { "2023-07-21": {…}, "2023-07-22": {…}, "2023-07-23": {…}, … }
   *
   * if calendar object  not defined, then  it's will be defined and 'id', 'dates' set
   * if calendar exist, then system add a  new or overwrite only dates from dates_obj parameter,
   * but other dates not from parameter dates_obj will be existed and not overwrite.
   *
   * @param {string|int} resource_id				  '2'
   * @param {object} dates_obj					  { "2023-07-21": {…}, "2023-07-22": {…}, "2023-07-23": {…}, … }
   * @param {boolean} is_complete_overwrite		  if false,  then  only overwrite or add  dates from 	dates_obj
   * @returns {*}
   *
   * Examples:
   *   			_wpbc.bookings_in_calendar__set_dates( resource_id, { "2023-07-21": {…}, "2023-07-22": {…}, … }  );		<-   overwrite ALL dates
   *   			_wpbc.bookings_in_calendar__set_dates( resource_id, { "2023-07-22": {…} },  false  );					<-   add or overwrite only  	"2023-07-22": {}
   *
   * Common usage in PHP:
   *   			echo "  _wpbc.bookings_in_calendar__set_dates(  " . intval( $resource_id ) . ",  " . wp_json_encode( $availability_per_days_arr ) . "  );  ";
   */


  obj.bookings_in_calendar__set_dates = function (resource_id, dates_obj) {
    var is_complete_overwrite = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : true;

    if (!obj.bookings_in_calendar__is_defined(resource_id)) {
      obj.bookings_in_calendar__set(resource_id, {
        'dates': {}
      });
    }

    if ('undefined' === typeof p_bookings['calendar_' + resource_id]['dates']) {
      p_bookings['calendar_' + resource_id]['dates'] = {};
    }

    if (is_complete_overwrite) {
      // Complete overwrite all  booking dates
      p_bookings['calendar_' + resource_id]['dates'] = dates_obj;
    } else {
      // Add only  new or overwrite exist booking dates from  parameter. Booking dates not from  parameter  will  be without chnanges
      for (var prop_name in dates_obj) {
        p_bookings['calendar_' + resource_id]['dates'][prop_name] = dates_obj[prop_name];
      }
    }

    return p_bookings['calendar_' + resource_id];
  };
  /**
   *  Get bookings data for specific date in calendar   ::   false | { day_availability: 1, ... }
   *
   * @param {string|int} resource_id			'1'
   * @param {string} sql_class_day			'2023-07-21'
   * @returns {object|boolean}				false | {
  														day_availability: 4
  														max_capacity: 4															//  >= Business Large
  														2: Object { is_day_unavailable: false, _day_status: "available" }
  														10: Object { is_day_unavailable: false, _day_status: "available" }		//  >= Business Large ...
  														11: Object { is_day_unavailable: false, _day_status: "available" }
  														12: Object { is_day_unavailable: false, _day_status: "available" }
  													}
   */


  obj.bookings_in_calendar__get_for_date = function (resource_id, sql_class_day) {
    if (obj.bookings_in_calendar__is_defined(resource_id) && 'undefined' !== typeof p_bookings['calendar_' + resource_id]['dates'] && 'undefined' !== typeof p_bookings['calendar_' + resource_id]['dates'][sql_class_day]) {
      return p_bookings['calendar_' + resource_id]['dates'][sql_class_day];
    }

    return false; // If some property not defined, then false;
  }; // Any  PARAMS   in bookings

  /**
   * Set property  to  booking
   * @param resource_id	"1"
   * @param prop_name		name of property
   * @param prop_value	value of property
   * @returns {*}			booking object
   */


  obj.booking__set_param_value = function (resource_id, prop_name, prop_value) {
    if (!obj.bookings_in_calendar__is_defined(resource_id)) {
      p_bookings['calendar_' + resource_id] = {};
      p_bookings['calendar_' + resource_id]['id'] = resource_id;
    }

    p_bookings['calendar_' + resource_id][prop_name] = prop_value;
    return p_bookings['calendar_' + resource_id];
  };
  /**
   *  Get booking property value   	::   mixed | null
   *
   * @param {string|int}  resource_id		'1'
   * @param {string} prop_name			'selection_mode'
   * @returns {*|null}					mixed | null
   */


  obj.booking__get_param_value = function (resource_id, prop_name) {
    if (obj.bookings_in_calendar__is_defined(resource_id) && 'undefined' !== typeof p_bookings['calendar_' + resource_id][prop_name]) {
      return p_bookings['calendar_' + resource_id][prop_name];
    }

    return null; // If some property not defined, then null;
  };
  /**
   * Set bookings for all  calendars
   *
   * @param {object} calendars_obj		Object { calendar_1: { id: 1, dates: Object { "2023-07-22": {…}, "2023-07-23": {…}, "2023-07-24": {…}, … } }
   * 												 calendar_3: {}, ... }
   */


  obj.bookings_in_calendars__set_all = function (calendars_obj) {
    p_bookings = calendars_obj;
  };
  /**
   * Get bookings in all calendars
   *
   * @returns {object|{}}
   */


  obj.bookings_in_calendars__get_all = function () {
    return p_bookings;
  }; // -----------------------------------------------------------------------------------------------------------------
  // Seasons 	----------------------------------------------------------------------------------------------------


  var p_seasons = obj.seasons_obj = obj.seasons_obj || {// calendar_1: Object {
    //						   id:     1
    //						 , dates:  Object { "2023-07-21": {…}, "2023-07-22": {…}, "2023-07-23": {…}, …
    // }
  };
  /**
   * Add season names for dates in calendar object   ::    { "2023-07-21": [ 'wpbc_season_september_2023', 'wpbc_season_september_2024' ], "2023-07-22": [...], ... }
   *
   *
   * @param {string|int} resource_id				  '2'
   * @param {object} dates_obj					  { "2023-07-21": {…}, "2023-07-22": {…}, "2023-07-23": {…}, … }
   * @param {boolean} is_complete_overwrite		  if false,  then  only  add  dates from 	dates_obj
   * @returns {*}
   *
   * Examples:
   *   			_wpbc.seasons__set( resource_id, { "2023-07-21": [ 'wpbc_season_september_2023', 'wpbc_season_september_2024' ], "2023-07-22": [...], ... }  );
   */

  obj.seasons__set = function (resource_id, dates_obj) {
    var is_complete_overwrite = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;

    if ('undefined' === typeof p_seasons['calendar_' + resource_id]) {
      p_seasons['calendar_' + resource_id] = {};
    }

    if (is_complete_overwrite) {
      // Complete overwrite all  season dates
      p_seasons['calendar_' + resource_id] = dates_obj;
    } else {
      // Add only  new or overwrite exist booking dates from  parameter. Booking dates not from  parameter  will  be without chnanges
      for (var prop_name in dates_obj) {
        if ('undefined' === typeof p_seasons['calendar_' + resource_id][prop_name]) {
          p_seasons['calendar_' + resource_id][prop_name] = [];
        }

        for (var season_name_key in dates_obj[prop_name]) {
          p_seasons['calendar_' + resource_id][prop_name].push(dates_obj[prop_name][season_name_key]);
        }
      }
    }

    return p_seasons['calendar_' + resource_id];
  };
  /**
   *  Get bookings data for specific date in calendar   ::   [] | [ 'wpbc_season_september_2023', 'wpbc_season_september_2024' ]
   *
   * @param {string|int} resource_id			'1'
   * @param {string} sql_class_day			'2023-07-21'
   * @returns {object|boolean}				[]  |  [ 'wpbc_season_september_2023', 'wpbc_season_september_2024' ]
   */


  obj.seasons__get_for_date = function (resource_id, sql_class_day) {
    if ('undefined' !== typeof p_seasons['calendar_' + resource_id] && 'undefined' !== typeof p_seasons['calendar_' + resource_id][sql_class_day]) {
      return p_seasons['calendar_' + resource_id][sql_class_day];
    }

    return []; // If not defined, then [];
  }; // Other parameters 			------------------------------------------------------------------------------------


  var p_other = obj.other_obj = obj.other_obj || {};

  obj.set_other_param = function (param_key, param_val) {
    p_other[param_key] = param_val;
  };

  obj.get_other_param = function (param_key) {
    return p_other[param_key];
  };
  /**
   * Get all other params
   *
   * @returns {object|{}}
   */


  obj.get_other_param__all = function () {
    return p_other;
  }; // Messages 			        ------------------------------------------------------------------------------------


  var p_messages = obj.messages_obj = obj.messages_obj || {};

  obj.set_message = function (param_key, param_val) {
    p_messages[param_key] = param_val;
  };

  obj.get_message = function (param_key) {
    return p_messages[param_key];
  };
  /**
   * Get all other params
   *
   * @returns {object|{}}
   */


  obj.get_messages__all = function () {
    return p_messages;
  }; // -----------------------------------------------------------------------------------------------------------------


  return obj;
}(_wpbc || {}, jQuery);
/**
 * Extend _wpbc with  new methods        //FixIn: 9.8.6.2
 *
 * @type {*|{}}
 * @private
 */


_wpbc = function (obj, $) {
  // Load Balancer 	-----------------------------------------------------------------------------------------------
  var p_balancer = obj.balancer_obj = obj.balancer_obj || {
    'max_threads': 2,
    'in_process': [],
    'wait': []
  };
  /**
   * Set  max parallel request  to  load
   *
   * @param max_threads
   */

  obj.balancer__set_max_threads = function (max_threads) {
    p_balancer['max_threads'] = max_threads;
  };
  /**
   *  Check if balancer for specific booking resource defined   ::   true | false
   *
   * @param {string|int} resource_id
   * @returns {boolean}
   */


  obj.balancer__is_defined = function (resource_id) {
    return 'undefined' !== typeof p_balancer['balancer_' + resource_id];
  };
  /**
   *  Create balancer initializing
   *
   * @param {string|int} resource_id
   */


  obj.balancer__init = function (resource_id, function_name) {
    var params = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};
    var balance_obj = {};
    balance_obj['resource_id'] = resource_id;
    balance_obj['priority'] = 1;
    balance_obj['function_name'] = function_name;
    balance_obj['params'] = wpbc_clone_obj(params);

    if (obj.balancer__is_already_run(resource_id, function_name)) {
      return 'run';
    }

    if (obj.balancer__is_already_wait(resource_id, function_name)) {
      return 'wait';
    }

    if (obj.balancer__can_i_run()) {
      obj.balancer__add_to__run(balance_obj);
      return 'run';
    } else {
      obj.balancer__add_to__wait(balance_obj);
      return 'wait';
    }
  };
  /**
   * Can I Run ?
   * @returns {boolean}
   */


  obj.balancer__can_i_run = function () {
    return p_balancer['in_process'].length < p_balancer['max_threads'];
  };
  /**
   * Add to WAIT
   * @param balance_obj
   */


  obj.balancer__add_to__wait = function (balance_obj) {
    p_balancer['wait'].push(balance_obj);
  };
  /**
   * Remove from Wait
   *
   * @param resource_id
   * @param function_name
   * @returns {*|boolean}
   */


  obj.balancer__remove_from__wait_list = function (resource_id, function_name) {
    var removed_el = false;

    if (p_balancer['wait'].length) {
      //FixIn: 9.8.10.1
      for (var i in p_balancer['wait']) {
        if (resource_id === p_balancer['wait'][i]['resource_id'] && function_name === p_balancer['wait'][i]['function_name']) {
          removed_el = p_balancer['wait'].splice(i, 1);
          removed_el = removed_el.pop();
          p_balancer['wait'] = p_balancer['wait'].filter(function (v) {
            return v;
          }); // Reindex array

          return removed_el;
        }
      }
    }

    return removed_el;
  };
  /**
  * Is already WAIT
  *
  * @param resource_id
  * @param function_name
  * @returns {boolean}
  */


  obj.balancer__is_already_wait = function (resource_id, function_name) {
    if (p_balancer['wait'].length) {
      //FixIn: 9.8.10.1
      for (var i in p_balancer['wait']) {
        if (resource_id === p_balancer['wait'][i]['resource_id'] && function_name === p_balancer['wait'][i]['function_name']) {
          return true;
        }
      }
    }

    return false;
  };
  /**
   * Add to RUN
   * @param balance_obj
   */


  obj.balancer__add_to__run = function (balance_obj) {
    p_balancer['in_process'].push(balance_obj);
  };
  /**
  * Remove from RUN list
  *
  * @param resource_id
  * @param function_name
  * @returns {*|boolean}
  */


  obj.balancer__remove_from__run_list = function (resource_id, function_name) {
    var removed_el = false;

    if (p_balancer['in_process'].length) {
      //FixIn: 9.8.10.1
      for (var i in p_balancer['in_process']) {
        if (resource_id === p_balancer['in_process'][i]['resource_id'] && function_name === p_balancer['in_process'][i]['function_name']) {
          removed_el = p_balancer['in_process'].splice(i, 1);
          removed_el = removed_el.pop();
          p_balancer['in_process'] = p_balancer['in_process'].filter(function (v) {
            return v;
          }); // Reindex array

          return removed_el;
        }
      }
    }

    return removed_el;
  };
  /**
  * Is already RUN
  *
  * @param resource_id
  * @param function_name
  * @returns {boolean}
  */


  obj.balancer__is_already_run = function (resource_id, function_name) {
    if (p_balancer['in_process'].length) {
      //FixIn: 9.8.10.1
      for (var i in p_balancer['in_process']) {
        if (resource_id === p_balancer['in_process'][i]['resource_id'] && function_name === p_balancer['in_process'][i]['function_name']) {
          return true;
        }
      }
    }

    return false;
  };

  obj.balancer__run_next = function () {
    // Get 1st from  Wait list
    var removed_el = false;

    if (p_balancer['wait'].length) {
      //FixIn: 9.8.10.1
      for (var i in p_balancer['wait']) {
        removed_el = obj.balancer__remove_from__wait_list(p_balancer['wait'][i]['resource_id'], p_balancer['wait'][i]['function_name']);
        break;
      }
    }

    if (false !== removed_el) {
      // Run
      obj.balancer__run(removed_el);
    }
  };
  /**
   * Run
   * @param balance_obj
   */


  obj.balancer__run = function (balance_obj) {
    switch (balance_obj['function_name']) {
      case 'wpbc_calendar__load_data__ajx':
        // Add to run list
        obj.balancer__add_to__run(balance_obj);
        wpbc_calendar__load_data__ajx(balance_obj['params']);
        break;

      default:
    }
  };

  return obj;
}(_wpbc || {}, jQuery);
/**
 * -- Help functions ----------------------------------------------------------------------------------------------
*/


function wpbc_balancer__is_wait(params, function_name) {
  //console.log('::wpbc_balancer__is_wait',params , function_name );
  if ('undefined' !== typeof params['resource_id']) {
    var balancer_status = _wpbc.balancer__init(params['resource_id'], function_name, params);

    return 'wait' === balancer_status;
  }

  return false;
}

function wpbc_balancer__completed(resource_id, function_name) {
  //console.log('::wpbc_balancer__completed',resource_id , function_name );
  _wpbc.balancer__remove_from__run_list(resource_id, function_name);

  _wpbc.balancer__run_next();
}
/**
 * =====================================================================================================================
 *	includes/__js/cal/wpbc_cal.js
 * =====================================================================================================================
 */

/**
 * Order or child booking resources saved here:  	_wpbc.booking__get_param_value( resource_id, 'resources_id_arr__in_dates' )		[2,10,12,11]
 */

/**
 * How to check  booked times on  specific date: ?
 *
			_wpbc.bookings_in_calendar__get_for_date(2,'2023-08-21');

			console.log(
						_wpbc.bookings_in_calendar__get_for_date(2,'2023-08-21')[2].booked_time_slots.merged_seconds,
						_wpbc.bookings_in_calendar__get_for_date(2,'2023-08-21')[10].booked_time_slots.merged_seconds,
						_wpbc.bookings_in_calendar__get_for_date(2,'2023-08-21')[11].booked_time_slots.merged_seconds,
						_wpbc.bookings_in_calendar__get_for_date(2,'2023-08-21')[12].booked_time_slots.merged_seconds
					);
 *  OR
			console.log(
						_wpbc.bookings_in_calendar__get_for_date(2,'2023-08-21')[2].booked_time_slots.merged_readable,
						_wpbc.bookings_in_calendar__get_for_date(2,'2023-08-21')[10].booked_time_slots.merged_readable,
						_wpbc.bookings_in_calendar__get_for_date(2,'2023-08-21')[11].booked_time_slots.merged_readable,
						_wpbc.bookings_in_calendar__get_for_date(2,'2023-08-21')[12].booked_time_slots.merged_readable
					);
 *
 */

/**
 * Days selection:
 * 					wpbc_calendar__unselect_all_dates( resource_id );
 *
 *					var resource_id = 1;
 * 	Example 1:		var num_selected_days = wpbc_auto_select_dates_in_calendar( resource_id, '2024-05-15', '2024-05-25' );
 * 	Example 2:		var num_selected_days = wpbc_auto_select_dates_in_calendar( resource_id, ['2024-05-09','2024-05-19','2024-05-25'] );
 *
 */

/**
 * C A L E N D A R  ---------------------------------------------------------------------------------------------------
 */

/**
 *  Show WPBC Calendar
 *
 * @param resource_id			- resource ID
 * @returns {boolean}
 */


function wpbc_calendar_show(resource_id) {
  // If no calendar HTML tag,  then  exit
  if (0 === jQuery('#calendar_booking' + resource_id).length) {
    return false;
  } // If the calendar with the same Booking resource is activated already, then exit.


  if (true === jQuery('#calendar_booking' + resource_id).hasClass('hasDatepick')) {
    return false;
  } // -----------------------------------------------------------------------------------------------------------------
  // Days selection
  // -----------------------------------------------------------------------------------------------------------------


  var local__is_range_select = false;
  var local__multi_days_select_num = 365; // multiple | fixed

  if ('dynamic' === _wpbc.calendar__get_param_value(resource_id, 'days_select_mode')) {
    local__is_range_select = true;
    local__multi_days_select_num = 0;
  }

  if ('single' === _wpbc.calendar__get_param_value(resource_id, 'days_select_mode')) {
    local__multi_days_select_num = 0;
  } // -----------------------------------------------------------------------------------------------------------------
  // Min - Max days to scroll/show
  // -----------------------------------------------------------------------------------------------------------------


  var local__min_date = 0;
  local__min_date = new Date(_wpbc.get_other_param('today_arr')[0], parseInt(_wpbc.get_other_param('today_arr')[1]) - 1, _wpbc.get_other_param('today_arr')[2], 0, 0, 0); //FixIn: 9.9.0.17
  //console.log( local__min_date );

  var local__max_date = _wpbc.calendar__get_param_value(resource_id, 'booking_max_monthes_in_calendar'); //local__max_date = new Date(2024, 5, 28);  It is here issue of not selectable dates, but some dates showing in calendar as available, but we can not select it.
  //// Define last day in calendar (as a last day of month (and not date, which is related to actual 'Today' date).
  //// E.g. if today is 2023-09-25, and we set 'Number of months to scroll' as 5 months, then last day will be 2024-02-29 and not the 2024-02-25.
  // var cal_last_day_in_month = jQuery.datepick._determineDate( null, local__max_date, new Date() );
  // cal_last_day_in_month = new Date( cal_last_day_in_month.getFullYear(), cal_last_day_in_month.getMonth() + 1, 0 );
  // local__max_date = cal_last_day_in_month;			//FixIn: 10.0.0.26


  if (location.href.indexOf('page=wpbc-new') != -1 && location.href.indexOf('booking_hash') != -1 // Comment this line for ability to add  booking in past days at  Booking > Add booking page.
  ) {
    local__min_date = null;
    local__max_date = null;
  }

  var local__start_weekday = _wpbc.calendar__get_param_value(resource_id, 'booking_start_day_weeek');

  var local__number_of_months = parseInt(_wpbc.calendar__get_param_value(resource_id, 'calendar_number_of_months'));
  jQuery('#calendar_booking' + resource_id).text(''); // Remove all HTML in calendar tag
  // -----------------------------------------------------------------------------------------------------------------
  // Show calendar
  // -----------------------------------------------------------------------------------------------------------------

  jQuery('#calendar_booking' + resource_id).datepick({
    beforeShowDay: function beforeShowDay(js_date) {
      return wpbc__calendar__apply_css_to_days(js_date, {
        'resource_id': resource_id
      }, this);
    },
    onSelect: function onSelect(string_dates, js_dates_arr) {
      /**
      *	string_dates   =   '23.08.2023 - 26.08.2023'    |    '23.08.2023 - 23.08.2023'    |    '19.09.2023, 24.08.2023, 30.09.2023'
      *  js_dates_arr   =   range: [ Date (Aug 23 2023), Date (Aug 25 2023)]     |     multiple: [ Date(Oct 24 2023), Date(Oct 20 2023), Date(Oct 16 2023) ]
      */
      return wpbc__calendar__on_select_days(string_dates, {
        'resource_id': resource_id
      }, this);
    },
    onHover: function onHover(string_date, js_date) {
      return wpbc__calendar__on_hover_days(string_date, js_date, {
        'resource_id': resource_id
      }, this);
    },
    onChangeMonthYear: function onChangeMonthYear(year, real_month, js_date__1st_day_in_month) {},
    showOn: 'both',
    numberOfMonths: local__number_of_months,
    stepMonths: 1,
    prevText: '&laquo;',
    nextText: '&raquo;',
    dateFormat: 'dd.mm.yy',
    changeMonth: false,
    changeYear: false,
    minDate: local__min_date,
    maxDate: local__max_date,
    // '1Y',
    // minDate: new Date(2020, 2, 1), maxDate: new Date(2020, 9, 31),             	// Ability to set any  start and end date in calendar
    showStatus: false,
    multiSeparator: ', ',
    closeAtTop: false,
    firstDay: local__start_weekday,
    gotoCurrent: false,
    hideIfNoPrevNext: true,
    multiSelect: local__multi_days_select_num,
    rangeSelect: local__is_range_select,
    // showWeeks: true,
    useThemeRoller: false
  }); // -----------------------------------------------------------------------------------------------------------------
  // Clear today date highlighting
  // -----------------------------------------------------------------------------------------------------------------

  setTimeout(function () {
    wpbc_calendars__clear_days_highlighting(resource_id);
  }, 500); //FixIn: 7.1.2.8
  // -----------------------------------------------------------------------------------------------------------------
  // Scroll calendar to  specific month
  // -----------------------------------------------------------------------------------------------------------------

  var start_bk_month = _wpbc.calendar__get_param_value(resource_id, 'calendar_scroll_to');

  if (false !== start_bk_month) {
    wpbc_calendar__scroll_to(resource_id, start_bk_month[0], start_bk_month[1]);
  }
}
/**
 * Apply CSS to calendar date cells
 *
 * @param date										-  JavaScript Date Obj:  		Mon Dec 11 2023 00:00:00 GMT+0200 (Eastern European Standard Time)
 * @param calendar_params_arr						-  Calendar Settings Object:  	{
 *																  						"resource_id": 4
 *																					}
 * @param datepick_this								- this of datepick Obj
 * @returns {(*|string)[]|(boolean|string)[]}		- [ {true -available | false - unavailable}, 'CSS classes for calendar day cell' ]
 */


function wpbc__calendar__apply_css_to_days(date, calendar_params_arr, datepick_this) {
  var today_date = new Date(_wpbc.get_other_param('today_arr')[0], parseInt(_wpbc.get_other_param('today_arr')[1]) - 1, _wpbc.get_other_param('today_arr')[2], 0, 0, 0); // Today JS_Date_Obj.

  var class_day = wpbc__get__td_class_date(date); // '1-9-2023'

  var sql_class_day = wpbc__get__sql_class_date(date); // '2023-01-09'

  var resource_id = 'undefined' !== typeof calendar_params_arr['resource_id'] ? calendar_params_arr['resource_id'] : '1'; // '1'
  // Get Data --------------------------------------------------------------------------------------------------------

  var date_bookings_obj = _wpbc.bookings_in_calendar__get_for_date(resource_id, sql_class_day); // Array with CSS classes for date ---------------------------------------------------------------------------------


  var css_classes__for_date = [];
  css_classes__for_date.push('sql_date_' + sql_class_day); //  'sql_date_2023-07-21'

  css_classes__for_date.push('cal4date-' + class_day); //  'cal4date-7-21-2023'

  css_classes__for_date.push('wpbc_weekday_' + date.getDay()); //  'wpbc_weekday_4'

  var is_day_selectable = false; // If something not defined,  then  this date closed ---------------------------------------------------------------

  if (false === date_bookings_obj) {
    css_classes__for_date.push('date_user_unavailable');
    return [is_day_selectable, css_classes__for_date.join(' ')];
  } // -----------------------------------------------------------------------------------------------------------------
  //   date_bookings_obj  - Defined.            Dates can be selectable.
  // -----------------------------------------------------------------------------------------------------------------
  // -----------------------------------------------------------------------------------------------------------------
  // Add season names to the day CSS classes -- it is required for correct  work  of conditional fields --------------


  var season_names_arr = _wpbc.seasons__get_for_date(resource_id, sql_class_day);

  for (var season_key in season_names_arr) {
    css_classes__for_date.push(season_names_arr[season_key]); //  'wpdevbk_season_september_2023'
  } // -----------------------------------------------------------------------------------------------------------------
  // Cost Rate -------------------------------------------------------------------------------------------------------


  css_classes__for_date.push('rate_' + date_bookings_obj[resource_id]['date_cost_rate'].toString().replace(/[\.\s]/g, '_')); //  'rate_99_00' -> 99.00

  if (parseInt(date_bookings_obj['day_availability']) > 0) {
    is_day_selectable = true;
    css_classes__for_date.push('date_available');
    css_classes__for_date.push('reserved_days_count' + parseInt(date_bookings_obj['max_capacity'] - date_bookings_obj['day_availability']));
  } else {
    is_day_selectable = false;
    css_classes__for_date.push('date_user_unavailable');
  }

  switch (date_bookings_obj['summary']['status_for_day']) {
    case 'available':
      break;

    case 'time_slots_booking':
      css_classes__for_date.push('timespartly', 'times_clock');
      break;

    case 'full_day_booking':
      css_classes__for_date.push('full_day_booking');
      break;

    case 'season_filter':
      css_classes__for_date.push('date_user_unavailable', 'season_unavailable');
      date_bookings_obj['summary']['status_for_bookings'] = ''; // Reset booking status color for possible old bookings on this date

      break;

    case 'resource_availability':
      css_classes__for_date.push('date_user_unavailable', 'resource_unavailable');
      date_bookings_obj['summary']['status_for_bookings'] = ''; // Reset booking status color for possible old bookings on this date

      break;

    case 'weekday_unavailable':
      css_classes__for_date.push('date_user_unavailable', 'weekday_unavailable');
      date_bookings_obj['summary']['status_for_bookings'] = ''; // Reset booking status color for possible old bookings on this date

      break;

    case 'from_today_unavailable':
      css_classes__for_date.push('date_user_unavailable', 'from_today_unavailable');
      date_bookings_obj['summary']['status_for_bookings'] = ''; // Reset booking status color for possible old bookings on this date

      break;

    case 'limit_available_from_today':
      css_classes__for_date.push('date_user_unavailable', 'limit_available_from_today');
      date_bookings_obj['summary']['status_for_bookings'] = ''; // Reset booking status color for possible old bookings on this date

      break;

    case 'change_over':
      /*
       *
      //  check_out_time_date2approve 	 	check_in_time_date2approve
      //  check_out_time_date2approve 	 	check_in_time_date_approved
      //  check_in_time_date2approve 		 	check_out_time_date_approved
      //  check_out_time_date_approved 	 	check_in_time_date_approved
       */
      css_classes__for_date.push('timespartly', 'check_in_time', 'check_out_time'); //FixIn: 10.0.0.2

      if (date_bookings_obj['summary']['status_for_bookings'].indexOf('approved_pending') > -1) {
        css_classes__for_date.push('check_out_time_date_approved', 'check_in_time_date2approve');
      }

      if (date_bookings_obj['summary']['status_for_bookings'].indexOf('pending_approved') > -1) {
        css_classes__for_date.push('check_out_time_date2approve', 'check_in_time_date_approved');
      }

      break;

    case 'check_in':
      css_classes__for_date.push('timespartly', 'check_in_time'); //FixIn: 9.9.0.33

      if (date_bookings_obj['summary']['status_for_bookings'].indexOf('pending') > -1) {
        css_classes__for_date.push('check_in_time_date2approve');
      } else if (date_bookings_obj['summary']['status_for_bookings'].indexOf('approved') > -1) {
        css_classes__for_date.push('check_in_time_date_approved');
      }

      break;

    case 'check_out':
      css_classes__for_date.push('timespartly', 'check_out_time'); //FixIn: 9.9.0.33

      if (date_bookings_obj['summary']['status_for_bookings'].indexOf('pending') > -1) {
        css_classes__for_date.push('check_out_time_date2approve');
      } else if (date_bookings_obj['summary']['status_for_bookings'].indexOf('approved') > -1) {
        css_classes__for_date.push('check_out_time_date_approved');
      }

      break;

    default:
      // mixed statuses: 'change_over check_out' .... variations.... check more in 		function wpbc_get_availability_per_days_arr()
      date_bookings_obj['summary']['status_for_day'] = 'available';
  }

  if ('available' != date_bookings_obj['summary']['status_for_day']) {
    var is_set_pending_days_selectable = _wpbc.calendar__get_param_value(resource_id, 'pending_days_selectable'); // set pending days selectable          //FixIn: 8.6.1.18


    switch (date_bookings_obj['summary']['status_for_bookings']) {
      case '':
        // Usually  it's means that day  is available or unavailable without the bookings
        break;

      case 'pending':
        css_classes__for_date.push('date2approve');
        is_day_selectable = is_day_selectable ? true : is_set_pending_days_selectable;
        break;

      case 'approved':
        css_classes__for_date.push('date_approved');
        break;
      // Situations for "change-over" days: ----------------------------------------------------------------------

      case 'pending_pending':
        css_classes__for_date.push('check_out_time_date2approve', 'check_in_time_date2approve');
        is_day_selectable = is_day_selectable ? true : is_set_pending_days_selectable;
        break;

      case 'pending_approved':
        css_classes__for_date.push('check_out_time_date2approve', 'check_in_time_date_approved');
        is_day_selectable = is_day_selectable ? true : is_set_pending_days_selectable;
        break;

      case 'approved_pending':
        css_classes__for_date.push('check_out_time_date_approved', 'check_in_time_date2approve');
        is_day_selectable = is_day_selectable ? true : is_set_pending_days_selectable;
        break;

      case 'approved_approved':
        css_classes__for_date.push('check_out_time_date_approved', 'check_in_time_date_approved');
        break;

      default:
    }
  }

  return [is_day_selectable, css_classes__for_date.join(' ')];
}
/**
 * Mouseover calendar date cells
 *
 * @param string_date
 * @param date										-  JavaScript Date Obj:  		Mon Dec 11 2023 00:00:00 GMT+0200 (Eastern European Standard Time)
 * @param calendar_params_arr						-  Calendar Settings Object:  	{
 *																  						"resource_id": 4
 *																					}
 * @param datepick_this								- this of datepick Obj
 * @returns {boolean}
 */


function wpbc__calendar__on_hover_days(string_date, date, calendar_params_arr, datepick_this) {
  if (null === date) {
    return false;
  }

  var class_day = wpbc__get__td_class_date(date); // '1-9-2023'

  var sql_class_day = wpbc__get__sql_class_date(date); // '2023-01-09'

  var resource_id = 'undefined' !== typeof calendar_params_arr['resource_id'] ? calendar_params_arr['resource_id'] : '1'; // '1'
  // Get Data --------------------------------------------------------------------------------------------------------

  var date_booking_obj = _wpbc.bookings_in_calendar__get_for_date(resource_id, sql_class_day); // {...}


  if (!date_booking_obj) {
    return false;
  } // T o o l t i p s -------------------------------------------------------------------------------------------------


  var tooltip_text = '';

  if (date_booking_obj['summary']['tooltip_availability'].length > 0) {
    tooltip_text += date_booking_obj['summary']['tooltip_availability'];
  }

  if (date_booking_obj['summary']['tooltip_day_cost'].length > 0) {
    tooltip_text += date_booking_obj['summary']['tooltip_day_cost'];
  }

  if (date_booking_obj['summary']['tooltip_times'].length > 0) {
    tooltip_text += date_booking_obj['summary']['tooltip_times'];
  }

  if (date_booking_obj['summary']['tooltip_booking_details'].length > 0) {
    tooltip_text += date_booking_obj['summary']['tooltip_booking_details'];
  }

  wpbc_set_tooltip___for__calendar_date(tooltip_text, resource_id, class_day); //  U n h o v e r i n g    in    UNSELECTABLE_CALENDAR  ------------------------------------------------------------

  var is_unselectable_calendar = jQuery('#calendar_booking_unselectable' + resource_id).length > 0; //FixIn: 8.0.1.2

  var is_booking_form_exist = jQuery('#booking_form_div' + resource_id).length > 0;

  if (is_unselectable_calendar && !is_booking_form_exist) {
    /**
     *  Un Hover all dates in calendar (without the booking form), if only Availability Calendar here and we do not insert Booking form by mistake.
     */
    wpbc_calendars__clear_days_highlighting(resource_id); // Clear days highlighting

    var css_of_calendar = '.wpbc_only_calendar #calendar_booking' + resource_id;
    jQuery(css_of_calendar + ' .datepick-days-cell, ' + css_of_calendar + ' .datepick-days-cell a').css('cursor', 'default'); // Set cursor to Default

    return false;
  } //  D a y s    H o v e r i n g  ------------------------------------------------------------------------------------


  if (location.href.indexOf('page=wpbc') == -1 || location.href.indexOf('page=wpbc-new') > 0 || location.href.indexOf('page=wpbc-availability') > 0 || location.href.indexOf('page=wpbc-settings') > 0 && location.href.indexOf('&tab=form') > 0) {
    // The same as dates selection,  but for days hovering
    if ('function' == typeof wpbc__calendar__do_days_highlight__bs) {
      wpbc__calendar__do_days_highlight__bs(sql_class_day, date, resource_id);
    }
  }
}
/**
 * Select calendar date cells
 *
 * @param date										-  JavaScript Date Obj:  		Mon Dec 11 2023 00:00:00 GMT+0200 (Eastern European Standard Time)
 * @param calendar_params_arr						-  Calendar Settings Object:  	{
 *																  						"resource_id": 4
 *																					}
 * @param datepick_this								- this of datepick Obj
 *
 */


function wpbc__calendar__on_select_days(date, calendar_params_arr, datepick_this) {
  var resource_id = 'undefined' !== typeof calendar_params_arr['resource_id'] ? calendar_params_arr['resource_id'] : '1'; // '1'
  // Set unselectable,  if only Availability Calendar  here (and we do not insert Booking form by mistake).

  var is_unselectable_calendar = jQuery('#calendar_booking_unselectable' + resource_id).length > 0; //FixIn: 8.0.1.2

  var is_booking_form_exist = jQuery('#booking_form_div' + resource_id).length > 0;

  if (is_unselectable_calendar && !is_booking_form_exist) {
    wpbc_calendar__unselect_all_dates(resource_id); // Unselect Dates

    jQuery('.wpbc_only_calendar .popover_calendar_hover').remove(); // Hide all opened popovers

    return false;
  }

  jQuery('#date_booking' + resource_id).val(date); // Add selected dates to  hidden textarea

  if ('function' === typeof wpbc__calendar__do_days_select__bs) {
    wpbc__calendar__do_days_select__bs(date, resource_id);
  }

  wpbc_disable_time_fields_in_booking_form(resource_id); // Hook -- trigger day selection -----------------------------------------------------------------------------------

  var mouse_clicked_dates = date; // Can be: "05.10.2023 - 07.10.2023"  |  "10.10.2023 - 10.10.2023"  |

  var all_selected_dates_arr = wpbc_get__selected_dates_sql__as_arr(resource_id); // Can be: [ "2023-10-05", "2023-10-06", "2023-10-07", … ]

  jQuery(".booking_form_div").trigger("date_selected", [resource_id, mouse_clicked_dates, all_selected_dates_arr]);
}
/**
 * --  T i m e    F i e l d s     start  --------------------------------------------------------------------------
 */

/**
 * Disable time slots in booking form depend on selected dates and booked dates/times
 *
 * @param resource_id
 */


function wpbc_disable_time_fields_in_booking_form(resource_id) {
  /**
   * 	1. Get all time fields in the booking form as array  of objects
   * 					[
   * 					 	   {	jquery_option:      jQuery_Object {}
   * 								name:               'rangetime2[]'
   * 								times_as_seconds:   [ 21600, 23400 ]
   * 								value_option_24h:   '06:00 - 06:30'
   * 					     }
   * 					  ...
   * 						   {	jquery_option:      jQuery_Object {}
   * 								name:               'starttime2[]'
   * 								times_as_seconds:   [ 21600 ]
   * 								value_option_24h:   '06:00'
   *  					    }
   * 					 ]
   */
  var time_fields_obj_arr = wpbc_get__time_fields__in_booking_form__as_arr(resource_id); // 2. Get all selected dates in  SQL format  like this [ "2023-08-23", "2023-08-24", "2023-08-25", ... ]

  var selected_dates_arr = wpbc_get__selected_dates_sql__as_arr(resource_id); // 3. Get child booking resources  or single booking resource  that  exist  in dates

  var child_resources_arr = wpbc_clone_obj(_wpbc.booking__get_param_value(resource_id, 'resources_id_arr__in_dates'));
  var sql_date;
  var child_resource_id;
  var merged_seconds;
  var time_fields_obj;
  var is_intersect;
  var is_check_in; // 4. Loop  all  time Fields options

  for (var field_key in time_fields_obj_arr) {
    time_fields_obj_arr[field_key].disabled = 0; // By default this time field is not disabled

    time_fields_obj = time_fields_obj_arr[field_key]; // { times_as_seconds: [ 21600, 23400 ], value_option_24h: '06:00 - 06:30', name: 'rangetime2[]', jquery_option: jQuery_Object {}}
    // Loop  all  selected dates

    for (var i = 0; i < selected_dates_arr.length; i++) {
      //FixIn: 9.9.0.31
      if ('Off' === _wpbc.calendar__get_param_value(resource_id, 'booking_recurrent_time') && selected_dates_arr.length > 1) {
        //TODO: skip some fields checking if it's start / end time for mulple dates  selection  mode.
        //TODO: we need to fix situation  for entimes,  when  user  select  several  dates,  and in start  time booked 00:00 - 15:00 , but systsme block untill 15:00 the end time as well,  which  is wrong,  because it 2 or 3 dates selection  and end date can be fullu  available
        if (0 == i && time_fields_obj['name'].indexOf('endtime') >= 0) {
          break;
        }

        if (selected_dates_arr.length - 1 == i && time_fields_obj['name'].indexOf('starttime') >= 0) {
          break;
        }
      } // Get Date: '2023-08-18'


      sql_date = selected_dates_arr[i];
      var how_many_resources_intersected = 0; // Loop all resources ID

      for (var res_key in child_resources_arr) {
        child_resource_id = child_resources_arr[res_key]; // _wpbc.bookings_in_calendar__get_for_date(2,'2023-08-21')[12].booked_time_slots.merged_seconds		= [ "07:00:11 - 07:30:02", "10:00:11 - 00:00:00" ]
        // _wpbc.bookings_in_calendar__get_for_date(2,'2023-08-21')[2].booked_time_slots.merged_seconds			= [  [ 25211, 27002 ], [ 36011, 86400 ]  ]

        if (false !== _wpbc.bookings_in_calendar__get_for_date(resource_id, sql_date)) {
          merged_seconds = _wpbc.bookings_in_calendar__get_for_date(resource_id, sql_date)[child_resource_id].booked_time_slots.merged_seconds; // [  [ 25211, 27002 ], [ 36011, 86400 ]  ]
        } else {
          merged_seconds = [];
        }

        if (time_fields_obj.times_as_seconds.length > 1) {
          is_intersect = wpbc_is_intersect__range_time_interval([[parseInt(time_fields_obj.times_as_seconds[0]) + 20, parseInt(time_fields_obj.times_as_seconds[1]) - 20]], merged_seconds);
        } else {
          is_check_in = -1 !== time_fields_obj.name.indexOf('start');
          is_intersect = wpbc_is_intersect__one_time_interval(is_check_in ? parseInt(time_fields_obj.times_as_seconds) + 20 : parseInt(time_fields_obj.times_as_seconds) - 20, merged_seconds);
        }

        if (is_intersect) {
          how_many_resources_intersected++; // Increase
        }
      }

      if (child_resources_arr.length == how_many_resources_intersected) {
        // All resources intersected,  then  it's means that this time-slot or time must  be  Disabled, and we can  exist  from   selected_dates_arr LOOP
        time_fields_obj_arr[field_key].disabled = 1;
        break; // exist  from   Dates LOOP
      }
    }
  } // 5. Now we can disable time slot in HTML by  using  ( field.disabled == 1 ) property


  wpbc__html__time_field_options__set_disabled(time_fields_obj_arr);
  jQuery(".booking_form_div").trigger('wpbc_hook_timeslots_disabled', [resource_id, selected_dates_arr]); // Trigger hook on disabling timeslots.		Usage: 	jQuery( ".booking_form_div" ).on( 'wpbc_hook_timeslots_disabled', function ( event, bk_type, all_dates ){ ... } );		//FixIn: 8.7.11.9
}
/**
 * Is number inside /intersect  of array of intervals ?
 *
 * @param time_A		     	- 25800
 * @param time_interval_B		- [  [ 25211, 27002 ], [ 36011, 86400 ]  ]
 * @returns {boolean}
 */


function wpbc_is_intersect__one_time_interval(time_A, time_interval_B) {
  for (var j = 0; j < time_interval_B.length; j++) {
    if (parseInt(time_A) > parseInt(time_interval_B[j][0]) && parseInt(time_A) < parseInt(time_interval_B[j][1])) {
      return true;
    } // if ( ( parseInt( time_A ) == parseInt( time_interval_B[ j ][ 0 ] ) ) || ( parseInt( time_A ) == parseInt( time_interval_B[ j ][ 1 ] ) ) ) {
    // 			// Time A just  at  the border of interval
    // }

  }

  return false;
}
/**
 * Is these array of intervals intersected ?
 *
 * @param time_interval_A		- [ [ 21600, 23400 ] ]
 * @param time_interval_B		- [  [ 25211, 27002 ], [ 36011, 86400 ]  ]
 * @returns {boolean}
 */


function wpbc_is_intersect__range_time_interval(time_interval_A, time_interval_B) {
  var is_intersect;

  for (var i = 0; i < time_interval_A.length; i++) {
    for (var j = 0; j < time_interval_B.length; j++) {
      is_intersect = wpbc_intervals__is_intersected(time_interval_A[i], time_interval_B[j]);

      if (is_intersect) {
        return true;
      }
    }
  }

  return false;
}
/**
 * Get all time fields in the booking form as array  of objects
 *
 * @param resource_id
 * @returns []
 *
 * 		Example:
 * 					[
 * 					 	   {
 * 								value_option_24h:   '06:00 - 06:30'
 * 								times_as_seconds:   [ 21600, 23400 ]
 * 					 	   		jquery_option:      jQuery_Object {}
 * 								name:               'rangetime2[]'
 * 					     }
 * 					  ...
 * 						   {
 * 								value_option_24h:   '06:00'
 * 								times_as_seconds:   [ 21600 ]
 * 						   		jquery_option:      jQuery_Object {}
 * 								name:               'starttime2[]'
 *  					    }
 * 					 ]
 */


function wpbc_get__time_fields__in_booking_form__as_arr(resource_id) {
  /**
  * Fields with  []  like this   select[name="rangetime1[]"]
  * it's when we have 'multiple' in shortcode:   [select* rangetime multiple  "06:00 - 06:30" ... ]
  */
  var time_fields_arr = ['select[name="rangetime' + resource_id + '"]', 'select[name="rangetime' + resource_id + '[]"]', 'select[name="starttime' + resource_id + '"]', 'select[name="starttime' + resource_id + '[]"]', 'select[name="endtime' + resource_id + '"]', 'select[name="endtime' + resource_id + '[]"]'];
  var time_fields_obj_arr = []; // Loop all Time Fields

  for (var ctf = 0; ctf < time_fields_arr.length; ctf++) {
    var time_field = time_fields_arr[ctf];
    var time_option = jQuery(time_field + ' option'); // Loop all options in time field

    for (var j = 0; j < time_option.length; j++) {
      var jquery_option = jQuery(time_field + ' option:eq(' + j + ')');
      var value_option_seconds_arr = jquery_option.val().split('-');
      var times_as_seconds = []; // Get time as seconds

      if (value_option_seconds_arr.length) {
        //FixIn: 9.8.10.1
        for (var i = 0; i < value_option_seconds_arr.length; i++) {
          //FixIn: 10.0.0.56
          // value_option_seconds_arr[i] = '14:00 '  | ' 16:00'   (if from 'rangetime') and '16:00'  if (start/end time)
          var start_end_times_arr = value_option_seconds_arr[i].trim().split(':');
          var time_in_seconds = parseInt(start_end_times_arr[0]) * 60 * 60 + parseInt(start_end_times_arr[1]) * 60;
          times_as_seconds.push(time_in_seconds);
        }
      }

      time_fields_obj_arr.push({
        'name': jQuery(time_field).attr('name'),
        'value_option_24h': jquery_option.val(),
        'jquery_option': jquery_option,
        'times_as_seconds': times_as_seconds
      });
    }
  }

  return time_fields_obj_arr;
}
/**
 * Disable HTML options and add booked CSS class
 *
 * @param time_fields_obj_arr      - this value is from  the func:  	wpbc_get__time_fields__in_booking_form__as_arr( resource_id )
 * 					[
 * 					 	   {	jquery_option:      jQuery_Object {}
 * 								name:               'rangetime2[]'
 * 								times_as_seconds:   [ 21600, 23400 ]
 * 								value_option_24h:   '06:00 - 06:30'
 * 	  						    disabled = 1
 * 					     }
 * 					  ...
 * 						   {	jquery_option:      jQuery_Object {}
 * 								name:               'starttime2[]'
 * 								times_as_seconds:   [ 21600 ]
 * 								value_option_24h:   '06:00'
 *   							disabled = 0
 *  					    }
 * 					 ]
 *
 */


function wpbc__html__time_field_options__set_disabled(time_fields_obj_arr) {
  var jquery_option;

  for (var i = 0; i < time_fields_obj_arr.length; i++) {
    var jquery_option = time_fields_obj_arr[i].jquery_option;

    if (1 == time_fields_obj_arr[i].disabled) {
      jquery_option.prop('disabled', true); // Make disable some options

      jquery_option.addClass('booked'); // Add "booked" CSS class
      // if this booked element selected --> then deselect  it

      if (jquery_option.prop('selected')) {
        jquery_option.prop('selected', false);
        jquery_option.parent().find('option:not([disabled]):first').prop('selected', true).trigger("change");
      }
    } else {
      jquery_option.prop('disabled', false); // Make active all times

      jquery_option.removeClass('booked'); // Remove class "booked"
    }
  }
}
/**
 * Check if this time_range | Time_Slot is Full Day  booked
 *
 * @param timeslot_arr_in_seconds		- [ 36011, 86400 ]
 * @returns {boolean}
 */


function wpbc_is_this_timeslot__full_day_booked(timeslot_arr_in_seconds) {
  if (timeslot_arr_in_seconds.length > 1 && parseInt(timeslot_arr_in_seconds[0]) < 30 && parseInt(timeslot_arr_in_seconds[1]) > 24 * 60 * 60 - 30) {
    return true;
  }

  return false;
} // -----------------------------------------------------------------------------------------------------------------
// S e l e c t e d    D a t e s  /  T i m e - F i e l d s
// -----------------------------------------------------------------------------------------------------------------

/**
 *  Get all selected dates in SQL format like this [ "2023-08-23", "2023-08-24" , ... ]
 *
 * @param resource_id
 * @returns {[]}			[ "2023-08-23", "2023-08-24", "2023-08-25", "2023-08-26", "2023-08-27", "2023-08-28", "2023-08-29" ]
 */


function wpbc_get__selected_dates_sql__as_arr(resource_id) {
  var selected_dates_arr = [];
  selected_dates_arr = jQuery('#date_booking' + resource_id).val().split(',');

  if (selected_dates_arr.length) {
    //FixIn: 9.8.10.1
    for (var i = 0; i < selected_dates_arr.length; i++) {
      //FixIn: 10.0.0.56
      selected_dates_arr[i] = selected_dates_arr[i].trim();
      selected_dates_arr[i] = selected_dates_arr[i].split('.');

      if (selected_dates_arr[i].length > 1) {
        selected_dates_arr[i] = selected_dates_arr[i][2] + '-' + selected_dates_arr[i][1] + '-' + selected_dates_arr[i][0];
      }
    }
  } // Remove empty elements from an array


  selected_dates_arr = selected_dates_arr.filter(function (n) {
    return parseInt(n);
  });
  selected_dates_arr.sort();
  return selected_dates_arr;
}
/**
 * Get all time fields in the booking form as array  of objects
 *
 * @param resource_id
 * @param is_only_selected_time
 * @returns []
 *
 * 		Example:
 * 					[
 * 					 	   {
 * 								value_option_24h:   '06:00 - 06:30'
 * 								times_as_seconds:   [ 21600, 23400 ]
 * 					 	   		jquery_option:      jQuery_Object {}
 * 								name:               'rangetime2[]'
 * 					     }
 * 					  ...
 * 						   {
 * 								value_option_24h:   '06:00'
 * 								times_as_seconds:   [ 21600 ]
 * 						   		jquery_option:      jQuery_Object {}
 * 								name:               'starttime2[]'
 *  					    }
 * 					 ]
 */


function wpbc_get__selected_time_fields__in_booking_form__as_arr(resource_id) {
  var is_only_selected_time = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;

  /**
   * Fields with  []  like this   select[name="rangetime1[]"]
   * it's when we have 'multiple' in shortcode:   [select* rangetime multiple  "06:00 - 06:30" ... ]
   */
  var time_fields_arr = ['select[name="rangetime' + resource_id + '"]', 'select[name="rangetime' + resource_id + '[]"]', 'select[name="starttime' + resource_id + '"]', 'select[name="starttime' + resource_id + '[]"]', 'select[name="endtime' + resource_id + '"]', 'select[name="endtime' + resource_id + '[]"]', 'select[name="durationtime' + resource_id + '"]', 'select[name="durationtime' + resource_id + '[]"]'];
  var time_fields_obj_arr = []; // Loop all Time Fields

  for (var ctf = 0; ctf < time_fields_arr.length; ctf++) {
    var time_field = time_fields_arr[ctf];
    var time_option;

    if (is_only_selected_time) {
      time_option = jQuery('#booking_form' + resource_id + ' ' + time_field + ' option:selected'); // Exclude conditional  fields,  because of using '#booking_form3 ...'
    } else {
      time_option = jQuery('#booking_form' + resource_id + ' ' + time_field + ' option'); // All  time fields
    } // Loop all options in time field


    for (var j = 0; j < time_option.length; j++) {
      var jquery_option = jQuery(time_option[j]); // Get only  selected options 	//jQuery( time_field + ' option:eq(' + j + ')' );

      var value_option_seconds_arr = jquery_option.val().split('-');
      var times_as_seconds = []; // Get time as seconds

      if (value_option_seconds_arr.length) {
        //FixIn: 9.8.10.1
        for (var i = 0; i < value_option_seconds_arr.length; i++) {
          //FixIn: 10.0.0.56
          // value_option_seconds_arr[i] = '14:00 '  | ' 16:00'   (if from 'rangetime') and '16:00'  if (start/end time)
          var start_end_times_arr = value_option_seconds_arr[i].trim().split(':');
          var time_in_seconds = parseInt(start_end_times_arr[0]) * 60 * 60 + parseInt(start_end_times_arr[1]) * 60;
          times_as_seconds.push(time_in_seconds);
        }
      }

      time_fields_obj_arr.push({
        'name': jQuery('#booking_form' + resource_id + ' ' + time_field).attr('name'),
        'value_option_24h': jquery_option.val(),
        'jquery_option': jquery_option,
        'times_as_seconds': times_as_seconds
      });
    }
  } // Text:   [starttime] - [endtime] -----------------------------------------------------------------------------


  var text_time_fields_arr = ['input[name="starttime' + resource_id + '"]', 'input[name="endtime' + resource_id + '"]'];

  for (var tf = 0; tf < text_time_fields_arr.length; tf++) {
    var text_jquery = jQuery('#booking_form' + resource_id + ' ' + text_time_fields_arr[tf]); // Exclude conditional  fields,  because of using '#booking_form3 ...'

    if (text_jquery.length > 0) {
      var time__h_m__arr = text_jquery.val().trim().split(':'); // '14:00'

      if (0 == time__h_m__arr.length) {
        continue; // Not entered time value in a field
      }

      if (1 == time__h_m__arr.length) {
        if ('' === time__h_m__arr[0]) {
          continue; // Not entered time value in a field
        }

        time__h_m__arr[1] = 0;
      }

      var text_time_in_seconds = parseInt(time__h_m__arr[0]) * 60 * 60 + parseInt(time__h_m__arr[1]) * 60;
      var text_times_as_seconds = [];
      text_times_as_seconds.push(text_time_in_seconds);
      time_fields_obj_arr.push({
        'name': text_jquery.attr('name'),
        'value_option_24h': text_jquery.val(),
        'jquery_option': text_jquery,
        'times_as_seconds': text_times_as_seconds
      });
    }
  }

  return time_fields_obj_arr;
} // ---------------------------------------------------------------------------------------------------------------------
// S U P P O R T    for    C A L E N D A R
// ---------------------------------------------------------------------------------------------------------------------

/**
 * Get Calendar datepick  Instance
 * @param resource_id  of booking resource
 * @returns {*|null}
 */


function wpbc_calendar__get_inst(resource_id) {
  if ('undefined' === typeof resource_id) {
    resource_id = '1';
  }

  if (jQuery('#calendar_booking' + resource_id).length > 0) {
    return jQuery.datepick._getInst(jQuery('#calendar_booking' + resource_id).get(0));
  }

  return null;
}
/**
 * Unselect  all dates in calendar and visually update this calendar
 *
 * @param resource_id		ID of booking resource
 * @returns {boolean}		true on success | false,  if no such  calendar
 */


function wpbc_calendar__unselect_all_dates(resource_id) {
  if ('undefined' === typeof resource_id) {
    resource_id = '1';
  }

  var inst = wpbc_calendar__get_inst(resource_id);

  if (null !== inst) {
    // Unselect all dates and set  properties of Datepick
    jQuery('#date_booking' + resource_id).val(''); //FixIn: 5.4.3

    inst.stayOpen = false;
    inst.dates = [];

    jQuery.datepick._updateDatepick(inst);

    return true;
  }

  return false;
}
/**
 * Clear days highlighting in All or specific Calendars
 *
    * @param resource_id  - can be skiped to  clear highlighting in all calendars
    */


function wpbc_calendars__clear_days_highlighting(resource_id) {
  if ('undefined' !== typeof resource_id) {
    jQuery('#calendar_booking' + resource_id + ' .datepick-days-cell-over').removeClass('datepick-days-cell-over'); // Clear in specific calendar
  } else {
    jQuery('.datepick-days-cell-over').removeClass('datepick-days-cell-over'); // Clear in all calendars
  }
}
/**
 * Scroll to specific month in calendar
 *
 * @param resource_id		ID of resource
 * @param year				- real year  - 2023
 * @param month				- real month - 12
 * @returns {boolean}
 */


function wpbc_calendar__scroll_to(resource_id, year, month) {
  if ('undefined' === typeof resource_id) {
    resource_id = '1';
  }

  var inst = wpbc_calendar__get_inst(resource_id);

  if (null !== inst) {
    year = parseInt(year);
    month = parseInt(month) - 1; // In JS date,  month -1

    inst.cursorDate = new Date(); // In some cases,  the setFullYear can  set  only Year,  and not the Month and day      //FixIn:6.2.3.5

    inst.cursorDate.setFullYear(year, month, 1);
    inst.cursorDate.setMonth(month);
    inst.cursorDate.setDate(1);
    inst.drawMonth = inst.cursorDate.getMonth();
    inst.drawYear = inst.cursorDate.getFullYear();

    jQuery.datepick._notifyChange(inst);

    jQuery.datepick._adjustInstDate(inst);

    jQuery.datepick._showDate(inst);

    jQuery.datepick._updateDatepick(inst);

    return true;
  }

  return false;
}
/**
 * Is this date selectable in calendar (mainly it's means AVAILABLE date)
 *
 * @param {int|string} resource_id		1
 * @param {string} sql_class_day		'2023-08-11'
 * @returns {boolean}					true | false
 */


function wpbc_is_this_day_selectable(resource_id, sql_class_day) {
  // Get Data --------------------------------------------------------------------------------------------------------
  var date_bookings_obj = _wpbc.bookings_in_calendar__get_for_date(resource_id, sql_class_day);

  var is_day_selectable = parseInt(date_bookings_obj['day_availability']) > 0;

  if (typeof date_bookings_obj['summary'] === 'undefined') {
    return is_day_selectable;
  }

  if ('available' != date_bookings_obj['summary']['status_for_day']) {
    var is_set_pending_days_selectable = _wpbc.calendar__get_param_value(resource_id, 'pending_days_selectable'); // set pending days selectable          //FixIn: 8.6.1.18


    switch (date_bookings_obj['summary']['status_for_bookings']) {
      case 'pending': // Situations for "change-over" days:

      case 'pending_pending':
      case 'pending_approved':
      case 'approved_pending':
        is_day_selectable = is_day_selectable ? true : is_set_pending_days_selectable;
        break;

      default:
    }
  }

  return is_day_selectable;
}
/**
 * Is date to check IN array of selected dates
 *
 * @param {date}js_date_to_check		- JS Date			- simple  JavaScript Date object
 * @param {[]} js_dates_arr			- [ JSDate, ... ]   - array  of JS dates
 * @returns {boolean}
 */


function wpbc_is_this_day_among_selected_days(js_date_to_check, js_dates_arr) {
  for (var date_index = 0; date_index < js_dates_arr.length; date_index++) {
    //FixIn: 8.4.5.16
    if (js_dates_arr[date_index].getFullYear() === js_date_to_check.getFullYear() && js_dates_arr[date_index].getMonth() === js_date_to_check.getMonth() && js_dates_arr[date_index].getDate() === js_date_to_check.getDate()) {
      return true;
    }
  }

  return false;
}
/**
 * Get SQL Class Date '2023-08-01' from  JS Date
 *
 * @param date				JS Date
 * @returns {string}		'2023-08-12'
 */


function wpbc__get__sql_class_date(date) {
  var sql_class_day = date.getFullYear() + '-';
  sql_class_day += date.getMonth() + 1 < 10 ? '0' : '';
  sql_class_day += date.getMonth() + 1 + '-';
  sql_class_day += date.getDate() < 10 ? '0' : '';
  sql_class_day += date.getDate();
  return sql_class_day;
}
/**
 * Get JS Date from  the SQL date format '2024-05-14'
 * @param sql_class_date
 * @returns {Date}
 */


function wpbc__get__js_date(sql_class_date) {
  var sql_class_date_arr = sql_class_date.split('-');
  var date_js = new Date();
  date_js.setFullYear(parseInt(sql_class_date_arr[0]), parseInt(sql_class_date_arr[1]) - 1, parseInt(sql_class_date_arr[2])); // year, month, date
  // Without this time adjust Dates selection  in Datepicker can not work!!!

  date_js.setHours(0);
  date_js.setMinutes(0);
  date_js.setSeconds(0);
  date_js.setMilliseconds(0);
  return date_js;
}
/**
 * Get TD Class Date '1-31-2023' from  JS Date
 *
 * @param date				JS Date
 * @returns {string}		'1-31-2023'
 */


function wpbc__get__td_class_date(date) {
  var td_class_day = date.getMonth() + 1 + '-' + date.getDate() + '-' + date.getFullYear(); // '1-9-2023'

  return td_class_day;
}
/**
 * Get date params from  string date
 *
 * @param date			string date like '31.5.2023'
 * @param separator		default '.'  can be skipped.
 * @returns {  {date: number, month: number, year: number}  }
 */


function wpbc__get__date_params__from_string_date(date, separator) {
  separator = 'undefined' !== typeof separator ? separator : '.';
  var date_arr = date.split(separator);
  var date_obj = {
    'year': parseInt(date_arr[2]),
    'month': parseInt(date_arr[1]) - 1,
    'date': parseInt(date_arr[0])
  };
  return date_obj; // for 		 = new Date( date_obj.year , date_obj.month , date_obj.date );
}
/**
 * Add Spin Loader to  calendar
 * @param resource_id
 */


function wpbc_calendar__loading__start(resource_id) {
  if (!jQuery('#calendar_booking' + resource_id).next().hasClass('wpbc_spins_loader_wrapper')) {
    jQuery('#calendar_booking' + resource_id).after('<div class="wpbc_spins_loader_wrapper"><div class="wpbc_spins_loader"></div></div>');
  }

  if (!jQuery('#calendar_booking' + resource_id).hasClass('wpbc_calendar_blur_small')) {
    jQuery('#calendar_booking' + resource_id).addClass('wpbc_calendar_blur_small');
  }

  wpbc_calendar__blur__start(resource_id);
}
/**
 * Remove Spin Loader to  calendar
 * @param resource_id
 */


function wpbc_calendar__loading__stop(resource_id) {
  jQuery('#calendar_booking' + resource_id + ' + .wpbc_spins_loader_wrapper').remove();
  jQuery('#calendar_booking' + resource_id).removeClass('wpbc_calendar_blur_small');
  wpbc_calendar__blur__stop(resource_id);
}
/**
 * Add Blur to  calendar
 * @param resource_id
 */


function wpbc_calendar__blur__start(resource_id) {
  if (!jQuery('#calendar_booking' + resource_id).hasClass('wpbc_calendar_blur')) {
    jQuery('#calendar_booking' + resource_id).addClass('wpbc_calendar_blur');
  }
}
/**
 * Remove Blur in  calendar
 * @param resource_id
 */


function wpbc_calendar__blur__stop(resource_id) {
  jQuery('#calendar_booking' + resource_id).removeClass('wpbc_calendar_blur');
}
/**
 * Update Look  of calendar
 *
 * @param resource_id
 */


function wpbc_calendar__update_look(resource_id) {
  var inst = wpbc_calendar__get_inst(resource_id);

  jQuery.datepick._updateDatepick(inst);
} // ---------------------------------------------------------------------------------------------------------------------
// S U P P O R T    M A T H
// ---------------------------------------------------------------------------------------------------------------------

/**
 * Merge several  intersected intervals or return not intersected:                        [[1,3],[2,6],[8,10],[15,18]]  ->   [[1,6],[8,10],[15,18]]
 *
 * @param [] intervals			 [ [1,3],[2,4],[6,8],[9,10],[3,7] ]
 * @returns []					 [ [1,8],[9,10] ]
 *
 * Exmample: wpbc_intervals__merge_inersected(  [ [1,3],[2,4],[6,8],[9,10],[3,7] ]  );
 */


function wpbc_intervals__merge_inersected(intervals) {
  if (!intervals || intervals.length === 0) {
    return [];
  }

  var merged = [];
  intervals.sort(function (a, b) {
    return a[0] - b[0];
  });
  var mergedInterval = intervals[0];

  for (var i = 1; i < intervals.length; i++) {
    var interval = intervals[i];

    if (interval[0] <= mergedInterval[1]) {
      mergedInterval[1] = Math.max(mergedInterval[1], interval[1]);
    } else {
      merged.push(mergedInterval);
      mergedInterval = interval;
    }
  }

  merged.push(mergedInterval);
  return merged;
}
/**
 * Is 2 intervals intersected:       [36011, 86392]    <=>    [1, 43192]  =>  true      ( intersected )
 *
 * Good explanation  here https://stackoverflow.com/questions/3269434/whats-the-most-efficient-way-to-test-if-two-ranges-overlap
 *
 * @param  interval_A   - [ 36011, 86392 ]
 * @param  interval_B   - [     1, 43192 ]
 *
 * @return bool
 */


function wpbc_intervals__is_intersected(interval_A, interval_B) {
  if (0 == interval_A.length || 0 == interval_B.length) {
    return false;
  }

  interval_A[0] = parseInt(interval_A[0]);
  interval_A[1] = parseInt(interval_A[1]);
  interval_B[0] = parseInt(interval_B[0]);
  interval_B[1] = parseInt(interval_B[1]);
  var is_intersected = Math.max(interval_A[0], interval_B[0]) - Math.min(interval_A[1], interval_B[1]); // if ( 0 == is_intersected ) {
  //	                                 // Such ranges going one after other, e.g.: [ 12, 15 ] and [ 15, 21 ]
  // }

  if (is_intersected < 0) {
    return true; // INTERSECTED
  }

  return false; // Not intersected
}
/**
 * Get the closets ABS value of element in array to the current myValue
 *
 * @param myValue 	- int element to search closet 			4
 * @param myArray	- array of elements where to search 	[5,8,1,7]
 * @returns int												5
 */


function wpbc_get_abs_closest_value_in_arr(myValue, myArray) {
  if (myArray.length == 0) {
    // If the array is empty -> return  the myValue
    return myValue;
  }

  var obj = myArray[0];
  var diff = Math.abs(myValue - obj); // Get distance between  1st element

  var closetValue = myArray[0]; // Save 1st element

  for (var i = 1; i < myArray.length; i++) {
    obj = myArray[i];

    if (Math.abs(myValue - obj) < diff) {
      // we found closer value -> save it
      diff = Math.abs(myValue - obj);
      closetValue = obj;
    }
  }

  return closetValue;
} // ---------------------------------------------------------------------------------------------------------------------
//  T O O L T I P S
// ---------------------------------------------------------------------------------------------------------------------

/**
 * Define tooltip to show,  when  mouse over Date in Calendar
 *
 * @param  tooltip_text			- Text to show				'Booked time: 12:00 - 13:00<br>Cost: $20.00'
 * @param  resource_id			- ID of booking resource	'1'
 * @param  td_class				- SQL class					'1-9-2023'
 * @returns {boolean}					- defined to show or not
 */


function wpbc_set_tooltip___for__calendar_date(tooltip_text, resource_id, td_class) {
  //TODO: make escaping of text for quot symbols,  and JS/HTML...
  jQuery('#calendar_booking' + resource_id + ' td.cal4date-' + td_class).attr('data-content', tooltip_text);
  var td_el = jQuery('#calendar_booking' + resource_id + ' td.cal4date-' + td_class).get(0); //FixIn: 9.0.1.1

  if ('undefined' !== typeof td_el && undefined == td_el._tippy && '' !== tooltip_text) {
    wpbc_tippy(td_el, {
      content: function content(reference) {
        var popover_content = reference.getAttribute('data-content');
        return '<div class="popover popover_tippy">' + '<div class="popover-content">' + popover_content + '</div>' + '</div>';
      },
      allowHTML: true,
      trigger: 'mouseenter focus',
      interactive: false,
      hideOnClick: true,
      interactiveBorder: 10,
      maxWidth: 550,
      theme: 'wpbc-tippy-times',
      placement: 'top',
      delay: [400, 0],
      //FixIn: 9.4.2.2
      //delay			 : [0, 9999999999],						// Debuge  tooltip
      ignoreAttributes: true,
      touch: true,
      //['hold', 500], // 500ms delay				//FixIn: 9.2.1.5
      appendTo: function appendTo() {
        return document.body;
      }
    });
    return true;
  }

  return false;
} // ---------------------------------------------------------------------------------------------------------------------
//  ==  Dates Functions  ==
// ---------------------------------------------------------------------------------------------------------------------

/**
 * Get number of dates between 2 JS Dates
 *
 * @param date1		JS Date
 * @param date2		JS Date
 * @returns {number}
 */


function wpbc_dates__days_between(date1, date2) {
  // The number of milliseconds in one day
  var ONE_DAY = 1000 * 60 * 60 * 24; // Convert both dates to milliseconds

  var date1_ms = date1.getTime();
  var date2_ms = date2.getTime(); // Calculate the difference in milliseconds

  var difference_ms = date1_ms - date2_ms; // Convert back to days and return

  return Math.round(difference_ms / ONE_DAY);
}
/**
 * Check  if this array  of dates is consecutive array  of dates or not.
 * 		e.g.  ['2024-05-09','2024-05-19','2024-05-30'] -> false
 * 		e.g.  ['2024-05-09','2024-05-10','2024-05-11'] -> true
 * @param sql_dates_arr	 array		e.g.: ['2024-05-09','2024-05-19','2024-05-30']
 * @returns {boolean}
 */


function wpbc_dates__is_consecutive_dates_arr_range(sql_dates_arr) {
  //FixIn: 10.0.0.50
  if (sql_dates_arr.length > 1) {
    var previos_date = wpbc__get__js_date(sql_dates_arr[0]);
    var current_date;

    for (var i = 1; i < sql_dates_arr.length; i++) {
      current_date = wpbc__get__js_date(sql_dates_arr[i]);

      if (wpbc_dates__days_between(current_date, previos_date) != 1) {
        return false;
      }

      previos_date = current_date;
    }
  }

  return true;
} // ---------------------------------------------------------------------------------------------------------------------
//  ==  Auto Dates Selection  ==
// ---------------------------------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------------------------
// Auto Fill Fields / Auto Select Dates
// -------------------------------------------------------------------------------------------------------------

/**
 *  == How to  use ? ==      For Dates selection, we need to use this logic!     We need select the dates only after booking data loaded!     Check example bellow.
 *
 *	// Fire on all booking dates loaded
 *	jQuery( 'body' ).on( 'wpbc_calendar_ajx__loaded_data', function ( event, loaded_resource_id ){
 *
 *		if ( loaded_resource_id == select_dates_in_calendar_id ){
 *			wpbc_auto_select_dates_in_calendar( select_dates_in_calendar_id, '2024-05-15', '2024-05-25' );
 *		}
 *	} );
 *
 */

/**
 * Try to Auto select dates in specific calendar by simulated clicks in datepicker
 *
 * @param resource_id		1
 * @param check_in_ymd		'2024-05-09'		OR  	['2024-05-09','2024-05-19','2024-05-20']
 * @param check_out_ymd		'2024-05-15'		Optional
 *
 * @returns {number}		number of selected dates
 *
 * 	Example 1:				var num_selected_days = wpbc_auto_select_dates_in_calendar( 1, '2024-05-15', '2024-05-25' );
 * 	Example 2:				var num_selected_days = wpbc_auto_select_dates_in_calendar( 1, ['2024-05-09','2024-05-19','2024-05-20'] );
 */


function wpbc_auto_select_dates_in_calendar(resource_id, check_in_ymd) {
  var check_out_ymd = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : '';
  //FixIn: 10.0.0.47
  console.log('WPBC_AUTO_SELECT_DATES_IN_CALENDAR( RESOURCE_ID, CHECK_IN_YMD, CHECK_OUT_YMD )', resource_id, check_in_ymd, check_out_ymd);

  if ('2100-01-01' == check_in_ymd || '2100-01-01' == check_out_ymd || '' == check_in_ymd && '' == check_out_ymd) {
    return 0;
  } // -----------------------------------------------------------------------------------------------------------------
  // If 	check_in_ymd  =  [ '2024-05-09','2024-05-19','2024-05-30' ]				ARRAY of DATES						//FixIn: 10.0.0.50
  // -----------------------------------------------------------------------------------------------------------------


  var dates_to_select_arr = [];

  if (Array.isArray(check_in_ymd)) {
    dates_to_select_arr = wpbc_clone_obj(check_in_ymd); // -------------------------------------------------------------------------------------------------------------
    // Exceptions to  set  	MULTIPLE DAYS 	mode
    // -------------------------------------------------------------------------------------------------------------
    // if dates as NOT CONSECUTIVE: ['2024-05-09','2024-05-19','2024-05-30'], -> set MULTIPLE DAYS mode

    if (dates_to_select_arr.length > 0 && '' == check_out_ymd && !wpbc_dates__is_consecutive_dates_arr_range(dates_to_select_arr)) {
      wpbc_cal_days_select__multiple(resource_id);
    } // if multiple days to select, but enabled SINGLE day mode, -> set MULTIPLE DAYS mode


    if (dates_to_select_arr.length > 1 && '' == check_out_ymd && 'single' === _wpbc.calendar__get_param_value(resource_id, 'days_select_mode')) {
      wpbc_cal_days_select__multiple(resource_id);
    } // -------------------------------------------------------------------------------------------------------------


    check_in_ymd = dates_to_select_arr[0];

    if ('' == check_out_ymd) {
      check_out_ymd = dates_to_select_arr[dates_to_select_arr.length - 1];
    }
  } // -----------------------------------------------------------------------------------------------------------------


  if ('' == check_in_ymd) {
    check_in_ymd = check_out_ymd;
  }

  if ('' == check_out_ymd) {
    check_out_ymd = check_in_ymd;
  }

  if ('undefined' === typeof resource_id) {
    resource_id = '1';
  }

  var inst = wpbc_calendar__get_inst(resource_id);

  if (null !== inst) {
    // Unselect all dates and set  properties of Datepick
    jQuery('#date_booking' + resource_id).val(''); //FixIn: 5.4.3

    inst.stayOpen = false;
    inst.dates = [];
    var check_in_js = wpbc__get__js_date(check_in_ymd);
    var td_cell = wpbc_get_clicked_td(inst.id, check_in_js); // ---------------------------------------------------------------------------------------------------------
    //  == DYNAMIC ==

    if ('dynamic' === _wpbc.calendar__get_param_value(resource_id, 'days_select_mode')) {
      // 1-st click
      inst.stayOpen = false;

      jQuery.datepick._selectDay(td_cell, '#' + inst.id, check_in_js.getTime());

      if (0 === inst.dates.length) {
        return 0; // First click  was unsuccessful, so we must not make other click
      } // 2-nd click


      var check_out_js = wpbc__get__js_date(check_out_ymd);
      var td_cell_out = wpbc_get_clicked_td(inst.id, check_out_js);
      inst.stayOpen = true;

      jQuery.datepick._selectDay(td_cell_out, '#' + inst.id, check_out_js.getTime());
    } // ---------------------------------------------------------------------------------------------------------
    //  == FIXED ==


    if ('fixed' === _wpbc.calendar__get_param_value(resource_id, 'days_select_mode')) {
      jQuery.datepick._selectDay(td_cell, '#' + inst.id, check_in_js.getTime());
    } // ---------------------------------------------------------------------------------------------------------
    //  == SINGLE ==


    if ('single' === _wpbc.calendar__get_param_value(resource_id, 'days_select_mode')) {
      //jQuery.datepick._restrictMinMax( inst, jQuery.datepick._determineDate( inst, check_in_js, null ) );		// Do we need to run  this ? Please note, check_in_js must  have time,  min, sec defined to 0!
      jQuery.datepick._selectDay(td_cell, '#' + inst.id, check_in_js.getTime());
    } // ---------------------------------------------------------------------------------------------------------
    //  == MULTIPLE ==


    if ('multiple' === _wpbc.calendar__get_param_value(resource_id, 'days_select_mode')) {
      var dates_arr;

      if (dates_to_select_arr.length > 0) {
        // Situation, when we have dates array: ['2024-05-09','2024-05-19','2024-05-30'].  and not the Check In / Check  out dates as parameter in this function
        dates_arr = wpbc_get_selection_dates_js_str_arr__from_arr(dates_to_select_arr);
      } else {
        dates_arr = wpbc_get_selection_dates_js_str_arr__from_check_in_out(check_in_ymd, check_out_ymd, inst);
      }

      if (0 === dates_arr.dates_js.length) {
        return 0;
      } // For Calendar Days selection


      for (var j = 0; j < dates_arr.dates_js.length; j++) {
        // Loop array of dates
        var str_date = wpbc__get__sql_class_date(dates_arr.dates_js[j]); // Date unavailable !

        if (0 == _wpbc.bookings_in_calendar__get_for_date(resource_id, str_date).day_availability) {
          return 0;
        }

        if (dates_arr.dates_js[j] != -1) {
          inst.dates.push(dates_arr.dates_js[j]);
        }
      }

      var check_out_date = dates_arr.dates_js[dates_arr.dates_js.length - 1];
      inst.dates.push(check_out_date); // Need add one additional SAME date for correct  works of dates selection !!!!!

      var checkout_timestamp = check_out_date.getTime();
      var td_cell = wpbc_get_clicked_td(inst.id, check_out_date);

      jQuery.datepick._selectDay(td_cell, '#' + inst.id, checkout_timestamp);
    }

    if (0 !== inst.dates.length) {
      // Scroll to specific month, if we set dates in some future months
      wpbc_calendar__scroll_to(resource_id, inst.dates[0].getFullYear(), inst.dates[0].getMonth() + 1);
    }

    return inst.dates.length;
  }

  return 0;
}
/**
 * Get HTML td element (where was click in calendar  day  cell)
 *
 * @param calendar_html_id			'calendar_booking1'
 * @param date_js					JS Date
 * @returns {*|jQuery}				Dom HTML td element
 */


function wpbc_get_clicked_td(calendar_html_id, date_js) {
  var td_cell = jQuery('#' + calendar_html_id + ' .sql_date_' + wpbc__get__sql_class_date(date_js)).get(0);
  return td_cell;
}
/**
 * Get arrays of JS and SQL dates as dates array
 *
 * @param check_in_ymd							'2024-05-15'
 * @param check_out_ymd							'2024-05-25'
 * @param inst									Datepick Inst. Use wpbc_calendar__get_inst( resource_id );
 * @returns {{dates_js: *[], dates_str: *[]}}
 */


function wpbc_get_selection_dates_js_str_arr__from_check_in_out(check_in_ymd, check_out_ymd, inst) {
  var original_array = [];
  var date;
  var bk_distinct_dates = [];
  var check_in_date = check_in_ymd.split('-');
  var check_out_date = check_out_ymd.split('-');
  date = new Date();
  date.setFullYear(check_in_date[0], check_in_date[1] - 1, check_in_date[2]); // year, month, date

  var original_check_in_date = date;
  original_array.push(jQuery.datepick._restrictMinMax(inst, jQuery.datepick._determineDate(inst, date, null))); //add date

  if (!wpdev_in_array(bk_distinct_dates, check_in_date[2] + '.' + check_in_date[1] + '.' + check_in_date[0])) {
    bk_distinct_dates.push(parseInt(check_in_date[2]) + '.' + parseInt(check_in_date[1]) + '.' + check_in_date[0]);
  }

  var date_out = new Date();
  date_out.setFullYear(check_out_date[0], check_out_date[1] - 1, check_out_date[2]); // year, month, date

  var original_check_out_date = date_out;
  var mewDate = new Date(original_check_in_date.getFullYear(), original_check_in_date.getMonth(), original_check_in_date.getDate());
  mewDate.setDate(original_check_in_date.getDate() + 1);

  while (original_check_out_date > date && original_check_in_date != original_check_out_date) {
    date = new Date(mewDate.getFullYear(), mewDate.getMonth(), mewDate.getDate());
    original_array.push(jQuery.datepick._restrictMinMax(inst, jQuery.datepick._determineDate(inst, date, null))); //add date

    if (!wpdev_in_array(bk_distinct_dates, date.getDate() + '.' + parseInt(date.getMonth() + 1) + '.' + date.getFullYear())) {
      bk_distinct_dates.push(parseInt(date.getDate()) + '.' + parseInt(date.getMonth() + 1) + '.' + date.getFullYear());
    }

    mewDate = new Date(date.getFullYear(), date.getMonth(), date.getDate());
    mewDate.setDate(mewDate.getDate() + 1);
  }

  original_array.pop();
  bk_distinct_dates.pop();
  return {
    'dates_js': original_array,
    'dates_str': bk_distinct_dates
  };
}
/**
 * Get arrays of JS and SQL dates as dates array
 *
 * @param dates_to_select_arr	= ['2024-05-09','2024-05-19','2024-05-30']
 *
 * @returns {{dates_js: *[], dates_str: *[]}}
 */


function wpbc_get_selection_dates_js_str_arr__from_arr(dates_to_select_arr) {
  //FixIn: 10.0.0.50
  var original_array = [];
  var bk_distinct_dates = [];
  var one_date_str;

  for (var d = 0; d < dates_to_select_arr.length; d++) {
    original_array.push(wpbc__get__js_date(dates_to_select_arr[d]));
    one_date_str = dates_to_select_arr[d].split('-');

    if (!wpdev_in_array(bk_distinct_dates, one_date_str[2] + '.' + one_date_str[1] + '.' + one_date_str[0])) {
      bk_distinct_dates.push(parseInt(one_date_str[2]) + '.' + parseInt(one_date_str[1]) + '.' + one_date_str[0]);
    }
  }

  return {
    'dates_js': original_array,
    'dates_str': original_array
  };
}

jQuery(document).ready(function () {
  var url_params = new URLSearchParams(window.location.search); // Disable days selection  in calendar,  after  redirection  from  the "Search results page,  after  search  availability" 			//FixIn: 8.8.2.3

  if ('On' != _wpbc.get_other_param('is_enabled_booking_search_results_days_select')) {
    if (url_params.has('wpbc_select_check_in') && url_params.has('wpbc_select_check_out') && url_params.has('wpbc_select_calendar_id')) {
      var select_dates_in_calendar_id = parseInt(url_params.get('wpbc_select_calendar_id')); // Fire on all booking dates loaded

      jQuery('body').on('wpbc_calendar_ajx__loaded_data', function (event, loaded_resource_id) {
        if (loaded_resource_id == select_dates_in_calendar_id) {
          wpbc_auto_select_dates_in_calendar(select_dates_in_calendar_id, url_params.get('wpbc_select_check_in'), url_params.get('wpbc_select_check_out'));
        }
      });
    }
  }

  if (url_params.has('wpbc_auto_fill')) {
    var wpbc_auto_fill_value = url_params.get('wpbc_auto_fill'); // Convert back.     Some systems do not like symbol '~' in URL, so  we need to replace to  some other symbols

    wpbc_auto_fill_value = wpbc_auto_fill_value.replaceAll('_^_', '~');
    wpbc_auto_fill_booking_fields(wpbc_auto_fill_value);
  }
});
/**
 * Autofill / select booking form  fields by  values from  the GET request  parameter: ?wpbc_auto_fill=
 *
 * @param auto_fill_str
 */

function wpbc_auto_fill_booking_fields(auto_fill_str) {
  //FixIn: 10.0.0.48
  if ('' == auto_fill_str) {
    return;
  } // console.log( 'WPBC_AUTO_FILL_BOOKING_FIELDS( AUTO_FILL_STR )', auto_fill_str);


  var fields_arr = wpbc_auto_fill_booking_fields__parse(auto_fill_str);

  for (var i = 0; i < fields_arr.length; i++) {
    jQuery('[name="' + fields_arr[i]['name'] + '"]').val(fields_arr[i]['value']);
  }
}
/**
 * Parse data from  get parameter:	?wpbc_auto_fill=visitors231^2~max_capacity231^2
 *
 * @param data_str      =   'visitors231^2~max_capacity231^2';
 * @returns {*}
 */


function wpbc_auto_fill_booking_fields__parse(data_str) {
  var filter_options_arr = [];
  var data_arr = data_str.split('~');

  for (var j = 0; j < data_arr.length; j++) {
    var my_form_field = data_arr[j].split('^');
    var filter_name = 'undefined' !== typeof my_form_field[0] ? my_form_field[0] : '';
    var filter_value = 'undefined' !== typeof my_form_field[1] ? my_form_field[1] : '';
    filter_options_arr.push({
      'name': filter_name,
      'value': filter_value
    });
  }

  return filter_options_arr;
}
/**
 * Parse data from  get parameter:	?search_get__custom_params=...
 *
 * @param data_str      =   'text^search_field__display_check_in^23.05.2024~text^search_field__display_check_out^26.05.2024~selectbox-one^search_quantity^2~selectbox-one^location^Spain~selectbox-one^max_capacity^2~selectbox-one^amenity^parking~checkbox^search_field__extend_search_days^5~submit^^Search~hidden^search_get__check_in_ymd^2024-05-23~hidden^search_get__check_out_ymd^2024-05-26~hidden^search_get__time^~hidden^search_get__quantity^2~hidden^search_get__extend^5~hidden^search_get__users_id^~hidden^search_get__custom_params^~';
 * @returns {*}
 */


function wpbc_auto_fill_search_fields__parse(data_str) {
  var filter_options_arr = [];
  var data_arr = data_str.split('~');

  for (var j = 0; j < data_arr.length; j++) {
    var my_form_field = data_arr[j].split('^');
    var filter_type = 'undefined' !== typeof my_form_field[0] ? my_form_field[0] : '';
    var filter_name = 'undefined' !== typeof my_form_field[1] ? my_form_field[1] : '';
    var filter_value = 'undefined' !== typeof my_form_field[2] ? my_form_field[2] : '';
    filter_options_arr.push({
      'type': filter_type,
      'name': filter_name,
      'value': filter_value
    });
  }

  return filter_options_arr;
}
/**
 * ====================================================================================================================
 *	includes/__js/cal/days_select_custom.js
 * ====================================================================================================================
 */
//FixIn: 9.8.9.2

/**
 * Re-Init Calendar and Re-Render it.
 *
 * @param resource_id
 */


function wpbc_cal__re_init(resource_id) {
  // Remove CLASS  for ability to re-render and reinit calendar.
  jQuery('#calendar_booking' + resource_id).removeClass('hasDatepick');
  wpbc_calendar_show(resource_id);
}
/**
 * Re-Init previously  saved days selection  variables.
 *
 * @param resource_id
 */


function wpbc_cal_days_select__re_init(resource_id) {
  _wpbc.calendar__set_param_value(resource_id, 'saved_variable___days_select_initial', {
    'dynamic__days_min': _wpbc.calendar__get_param_value(resource_id, 'dynamic__days_min'),
    'dynamic__days_max': _wpbc.calendar__get_param_value(resource_id, 'dynamic__days_max'),
    'dynamic__days_specific': _wpbc.calendar__get_param_value(resource_id, 'dynamic__days_specific'),
    'dynamic__week_days__start': _wpbc.calendar__get_param_value(resource_id, 'dynamic__week_days__start'),
    'fixed__days_num': _wpbc.calendar__get_param_value(resource_id, 'fixed__days_num'),
    'fixed__week_days__start': _wpbc.calendar__get_param_value(resource_id, 'fixed__week_days__start')
  });
} // ---------------------------------------------------------------------------------------------------------------------

/**
 * Set Single Day selection - after page load
 *
 * @param resource_id		ID of booking resource
 */


function wpbc_cal_ready_days_select__single(resource_id) {
  // Re-define selection, only after page loaded with all init vars
  jQuery(document).ready(function () {
    // Wait 1 second, just to  be sure, that all init vars defined
    setTimeout(function () {
      wpbc_cal_days_select__single(resource_id);
    }, 1000);
  });
}
/**
 * Set Single Day selection
 * Can be run at any  time,  when  calendar defined - useful for console run.
 *
 * @param resource_id		ID of booking resource
 */


function wpbc_cal_days_select__single(resource_id) {
  _wpbc.calendar__set_parameters(resource_id, {
    'days_select_mode': 'single'
  });

  wpbc_cal_days_select__re_init(resource_id);
  wpbc_cal__re_init(resource_id);
} // ---------------------------------------------------------------------------------------------------------------------

/**
 * Set Multiple Days selection  - after page load
 *
 * @param resource_id		ID of booking resource
 */


function wpbc_cal_ready_days_select__multiple(resource_id) {
  // Re-define selection, only after page loaded with all init vars
  jQuery(document).ready(function () {
    // Wait 1 second, just to  be sure, that all init vars defined
    setTimeout(function () {
      wpbc_cal_days_select__multiple(resource_id);
    }, 1000);
  });
}
/**
 * Set Multiple Days selection
 * Can be run at any  time,  when  calendar defined - useful for console run.
 *
 * @param resource_id		ID of booking resource
 */


function wpbc_cal_days_select__multiple(resource_id) {
  _wpbc.calendar__set_parameters(resource_id, {
    'days_select_mode': 'multiple'
  });

  wpbc_cal_days_select__re_init(resource_id);
  wpbc_cal__re_init(resource_id);
} // ---------------------------------------------------------------------------------------------------------------------

/**
 * Set Fixed Days selection with  1 mouse click  - after page load
 *
 * @integer resource_id			- 1				   -- ID of booking resource (calendar) -
 * @integer days_number			- 3				   -- number of days to  select	-
 * @array week_days__start	- [-1] | [ 1, 5]   --  { -1 - Any | 0 - Su,  1 - Mo,  2 - Tu, 3 - We, 4 - Th, 5 - Fr, 6 - Sat }
 */


function wpbc_cal_ready_days_select__fixed(resource_id, days_number) {
  var week_days__start = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : [-1];
  // Re-define selection, only after page loaded with all init vars
  jQuery(document).ready(function () {
    // Wait 1 second, just to  be sure, that all init vars defined
    setTimeout(function () {
      wpbc_cal_days_select__fixed(resource_id, days_number, week_days__start);
    }, 1000);
  });
}
/**
 * Set Fixed Days selection with  1 mouse click
 * Can be run at any  time,  when  calendar defined - useful for console run.
 *
 * @integer resource_id			- 1				   -- ID of booking resource (calendar) -
 * @integer days_number			- 3				   -- number of days to  select	-
 * @array week_days__start	- [-1] | [ 1, 5]   --  { -1 - Any | 0 - Su,  1 - Mo,  2 - Tu, 3 - We, 4 - Th, 5 - Fr, 6 - Sat }
 */


function wpbc_cal_days_select__fixed(resource_id, days_number) {
  var week_days__start = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : [-1];

  _wpbc.calendar__set_parameters(resource_id, {
    'days_select_mode': 'fixed'
  });

  _wpbc.calendar__set_parameters(resource_id, {
    'fixed__days_num': parseInt(days_number)
  }); // Number of days selection with 1 mouse click


  _wpbc.calendar__set_parameters(resource_id, {
    'fixed__week_days__start': week_days__start
  }); // { -1 - Any | 0 - Su,  1 - Mo,  2 - Tu, 3 - We, 4 - Th, 5 - Fr, 6 - Sat }


  wpbc_cal_days_select__re_init(resource_id);
  wpbc_cal__re_init(resource_id);
} // ---------------------------------------------------------------------------------------------------------------------

/**
 * Set Range Days selection  with  2 mouse clicks  - after page load
 *
 * @integer resource_id			- 1				   		-- ID of booking resource (calendar)
 * @integer days_min			- 7				   		-- Min number of days to select
 * @integer days_max			- 30			   		-- Max number of days to select
 * @array days_specific			- [] | [7,14,21,28]		-- Restriction for Specific number of days selection
 * @array week_days__start		- [-1] | [ 1, 5]   		--  { -1 - Any | 0 - Su,  1 - Mo,  2 - Tu, 3 - We, 4 - Th, 5 - Fr, 6 - Sat }
 */


function wpbc_cal_ready_days_select__range(resource_id, days_min, days_max) {
  var days_specific = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : [];
  var week_days__start = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : [-1];
  // Re-define selection, only after page loaded with all init vars
  jQuery(document).ready(function () {
    // Wait 1 second, just to  be sure, that all init vars defined
    setTimeout(function () {
      wpbc_cal_days_select__range(resource_id, days_min, days_max, days_specific, week_days__start);
    }, 1000);
  });
}
/**
 * Set Range Days selection  with  2 mouse clicks
 * Can be run at any  time,  when  calendar defined - useful for console run.
 *
 * @integer resource_id			- 1				   		-- ID of booking resource (calendar)
 * @integer days_min			- 7				   		-- Min number of days to select
 * @integer days_max			- 30			   		-- Max number of days to select
 * @array days_specific			- [] | [7,14,21,28]		-- Restriction for Specific number of days selection
 * @array week_days__start		- [-1] | [ 1, 5]   		--  { -1 - Any | 0 - Su,  1 - Mo,  2 - Tu, 3 - We, 4 - Th, 5 - Fr, 6 - Sat }
 */


function wpbc_cal_days_select__range(resource_id, days_min, days_max) {
  var days_specific = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : [];
  var week_days__start = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : [-1];

  _wpbc.calendar__set_parameters(resource_id, {
    'days_select_mode': 'dynamic'
  });

  _wpbc.calendar__set_param_value(resource_id, 'dynamic__days_min', parseInt(days_min)); // Min. Number of days selection with 2 mouse clicks


  _wpbc.calendar__set_param_value(resource_id, 'dynamic__days_max', parseInt(days_max)); // Max. Number of days selection with 2 mouse clicks


  _wpbc.calendar__set_param_value(resource_id, 'dynamic__days_specific', days_specific); // Example [5,7]


  _wpbc.calendar__set_param_value(resource_id, 'dynamic__week_days__start', week_days__start); // { -1 - Any | 0 - Su,  1 - Mo,  2 - Tu, 3 - We, 4 - Th, 5 - Fr, 6 - Sat }


  wpbc_cal_days_select__re_init(resource_id);
  wpbc_cal__re_init(resource_id);
}
/**
 * ====================================================================================================================
 *	includes/__js/cal_ajx_load/wpbc_cal_ajx.js
 * ====================================================================================================================
 */
// ---------------------------------------------------------------------------------------------------------------------
//  A j a x    L o a d    C a l e n d a r    D a t a
// ---------------------------------------------------------------------------------------------------------------------


function wpbc_calendar__load_data__ajx(params) {
  //FixIn: 9.8.6.2
  wpbc_calendar__loading__start(params['resource_id']);

  if (wpbc_balancer__is_wait(params, 'wpbc_calendar__load_data__ajx')) {
    return false;
  } //FixIn: 9.8.6.2


  wpbc_calendar__blur__stop(params['resource_id']); // console.groupEnd(); console.time('resource_id_' + params['resource_id']);

  console.groupCollapsed('WPBC_AJX_CALENDAR_LOAD');
  console.log(' == Before Ajax Send - calendars_all__get() == ', _wpbc.calendars_all__get()); // Start Ajax

  jQuery.post(wpbc_url_ajax, {
    action: 'WPBC_AJX_CALENDAR_LOAD',
    wpbc_ajx_user_id: _wpbc.get_secure_param('user_id'),
    nonce: _wpbc.get_secure_param('nonce'),
    wpbc_ajx_locale: _wpbc.get_secure_param('locale'),
    calendar_request_params: params // Usually like: { 'resource_id': 1, 'max_days_count': 365 }

  },
  /**
   * S u c c e s s
   *
   * @param response_data		-	its object returned from  Ajax - class-live-search.php
   * @param textStatus		-	'success'
   * @param jqXHR				-	Object
   */
  function (response_data, textStatus, jqXHR) {
    // console.timeEnd('resource_id_' + response_data['resource_id']);
    console.log(' == Response WPBC_AJX_CALENDAR_LOAD == ', response_data);
    console.groupEnd(); //FixIn: 9.8.6.2

    var ajx_post_data__resource_id = wpbc_get_resource_id__from_ajx_post_data_url(this.data);
    wpbc_balancer__completed(ajx_post_data__resource_id, 'wpbc_calendar__load_data__ajx'); // Probably Error

    if (_typeof(response_data) !== 'object' || response_data === null) {
      var jq_node = wpbc_get_calendar__jq_node__for_messages(this.data);
      var message_type = 'info';

      if ('' === response_data) {
        response_data = 'The server responds with an empty string. The server probably stopped working unexpectedly. <br>Please check your <strong>error.log</strong> in your server configuration for relative errors.';
        message_type = 'warning';
      } // Show Message


      wpbc_front_end__show_message(response_data, {
        'type': message_type,
        'show_here': {
          'jq_node': jq_node,
          'where': 'after'
        },
        'is_append': true,
        'style': 'text-align:left;',
        'delay': 0
      });
      return;
    } // Show Calendar


    wpbc_calendar__loading__stop(response_data['resource_id']); // -------------------------------------------------------------------------------------------------
    // Bookings - Dates

    _wpbc.bookings_in_calendar__set_dates(response_data['resource_id'], response_data['ajx_data']['dates']); // Bookings - Child or only single booking resource in dates


    _wpbc.booking__set_param_value(response_data['resource_id'], 'resources_id_arr__in_dates', response_data['ajx_data']['resources_id_arr__in_dates']); // Aggregate booking resources,  if any ?


    _wpbc.booking__set_param_value(response_data['resource_id'], 'aggregate_resource_id_arr', response_data['ajx_data']['aggregate_resource_id_arr']); // -------------------------------------------------------------------------------------------------
    // Update calendar


    wpbc_calendar__update_look(response_data['resource_id']);

    if ('undefined' !== typeof response_data['ajx_data']['ajx_after_action_message'] && '' != response_data['ajx_data']['ajx_after_action_message'].replace(/\n/g, "<br />")) {
      var jq_node = wpbc_get_calendar__jq_node__for_messages(this.data); // Show Message

      wpbc_front_end__show_message(response_data['ajx_data']['ajx_after_action_message'].replace(/\n/g, "<br />"), {
        'type': 'undefined' !== typeof response_data['ajx_data']['ajx_after_action_message_status'] ? response_data['ajx_data']['ajx_after_action_message_status'] : 'info',
        'show_here': {
          'jq_node': jq_node,
          'where': 'after'
        },
        'is_append': true,
        'style': 'text-align:left;',
        'delay': 10000
      });
    } // Trigger event that calendar has been		 //FixIn: 10.0.0.44


    if (jQuery('#calendar_booking' + response_data['resource_id']).length > 0) {
      var target_elm = jQuery('body').trigger("wpbc_calendar_ajx__loaded_data", [response_data['resource_id']]); //jQuery( 'body' ).on( 'wpbc_calendar_ajx__loaded_data', function( event, resource_id ) { ... } );
    } //jQuery( '#ajax_respond' ).html( response_data );		// For ability to show response, add such DIV element to page

  }).fail(function (jqXHR, textStatus, errorThrown) {
    if (window.console && window.console.log) {
      console.log('Ajax_Error', jqXHR, textStatus, errorThrown);
    }

    var ajx_post_data__resource_id = wpbc_get_resource_id__from_ajx_post_data_url(this.data);
    wpbc_balancer__completed(ajx_post_data__resource_id, 'wpbc_calendar__load_data__ajx'); // Get Content of Error Message

    var error_message = '<strong>' + 'Error!' + '</strong> ' + errorThrown;

    if (jqXHR.status) {
      error_message += ' (<b>' + jqXHR.status + '</b>)';

      if (403 == jqXHR.status) {
        error_message += '<br> Probably nonce for this page has been expired. Please <a href="javascript:void(0)" onclick="javascript:location.reload();">reload the page</a>.';
        error_message += '<br> Otherwise, please check this <a style="font-weight: 600;" href="https://wpbookingcalendar.com/faq/request-do-not-pass-security-check/">troubleshooting instruction</a>.<br>';
      }
    }

    var message_show_delay = 3000;

    if (jqXHR.responseText) {
      error_message += ' ' + jqXHR.responseText;
      message_show_delay = 10;
    }

    error_message = error_message.replace(/\n/g, "<br />");
    var jq_node = wpbc_get_calendar__jq_node__for_messages(this.data);
    /**
     * If we make fast clicking on different pages,
     * then under calendar will show error message with  empty  text, because ajax was not received.
     * To  not show such warnings we are set delay  in 3 seconds.  var message_show_delay = 3000;
     */

    var closed_timer = setTimeout(function () {
      // Show Message
      wpbc_front_end__show_message(error_message, {
        'type': 'error',
        'show_here': {
          'jq_node': jq_node,
          'where': 'after'
        },
        'is_append': true,
        'style': 'text-align:left;',
        'css_class': 'wpbc_fe_message_alt',
        'delay': 0
      });
    }, parseInt(message_show_delay));
  }) // .done(   function ( data, textStatus, jqXHR ) {   if ( window.console && window.console.log ){ console.log( 'second success', data, textStatus, jqXHR ); }    })
  // .always( function ( data_jqXHR, textStatus, jqXHR_errorThrown ) {   if ( window.console && window.console.log ){ console.log( 'always finished', data_jqXHR, textStatus, jqXHR_errorThrown ); }     })
  ; // End Ajax
} // ---------------------------------------------------------------------------------------------------------------------
// Support
// ---------------------------------------------------------------------------------------------------------------------

/**
 * Get Calendar jQuery node for showing messages during Ajax
 * This parameter:   calendar_request_params[resource_id]   parsed from this.data Ajax post  data
 *
 * @param ajx_post_data_url_params		 'action=WPBC_AJX_CALENDAR_LOAD...&calendar_request_params%5Bresource_id%5D=2&calendar_request_params%5Bbooking_hash%5D=&calendar_request_params'
 * @returns {string}	''#calendar_booking1'  |   '.booking_form_div' ...
 *
 * Example    var jq_node  = wpbc_get_calendar__jq_node__for_messages( this.data );
 */


function wpbc_get_calendar__jq_node__for_messages(ajx_post_data_url_params) {
  var jq_node = '.booking_form_div';
  var calendar_resource_id = wpbc_get_resource_id__from_ajx_post_data_url(ajx_post_data_url_params);

  if (calendar_resource_id > 0) {
    jq_node = '#calendar_booking' + calendar_resource_id;
  }

  return jq_node;
}
/**
 * Get resource ID from ajx post data url   usually  from  this.data  = 'action=WPBC_AJX_CALENDAR_LOAD...&calendar_request_params%5Bresource_id%5D=2&calendar_request_params%5Bbooking_hash%5D=&calendar_request_params'
 *
 * @param ajx_post_data_url_params		 'action=WPBC_AJX_CALENDAR_LOAD...&calendar_request_params%5Bresource_id%5D=2&calendar_request_params%5Bbooking_hash%5D=&calendar_request_params'
 * @returns {int}						 1 | 0  (if errror then  0)
 *
 * Example    var jq_node  = wpbc_get_calendar__jq_node__for_messages( this.data );
 */


function wpbc_get_resource_id__from_ajx_post_data_url(ajx_post_data_url_params) {
  // Get booking resource ID from Ajax Post Request  -> this.data = 'action=WPBC_AJX_CALENDAR_LOAD...&calendar_request_params%5Bresource_id%5D=2&calendar_request_params%5Bbooking_hash%5D=&calendar_request_params'
  var calendar_resource_id = wpbc_get_uri_param_by_name('calendar_request_params[resource_id]', ajx_post_data_url_params);

  if (null !== calendar_resource_id && '' !== calendar_resource_id) {
    calendar_resource_id = parseInt(calendar_resource_id);

    if (calendar_resource_id > 0) {
      return calendar_resource_id;
    }
  }

  return 0;
}
/**
 * Get parameter from URL  -  parse URL parameters,  like this: action=WPBC_AJX_CALENDAR_LOAD...&calendar_request_params%5Bresource_id%5D=2&calendar_request_params%5Bbooking_hash%5D=&calendar_request_params
 * @param name  parameter  name,  like 'calendar_request_params[resource_id]'
 * @param url	'parameter  string URL'
 * @returns {string|null}   parameter value
 *
 * Example: 		wpbc_get_uri_param_by_name( 'calendar_request_params[resource_id]', this.data );  -> '2'
 */


function wpbc_get_uri_param_by_name(name, url) {
  url = decodeURIComponent(url);
  name = name.replace(/[\[\]]/g, '\\$&');
  var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
      results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return '';
  return decodeURIComponent(results[2].replace(/\+/g, ' '));
}
/**
 * =====================================================================================================================
 *	includes/__js/front_end_messages/wpbc_fe_messages.js
 * =====================================================================================================================
 */
// ---------------------------------------------------------------------------------------------------------------------
// Show Messages at Front-Edn side
// ---------------------------------------------------------------------------------------------------------------------

/**
 * Show message in content
 *
 * @param message				Message HTML
 * @param params = {
 *								'type'     : 'warning',							// 'error' | 'warning' | 'info' | 'success'
 *								'show_here' : {
 *													'jq_node' : '',				// any jQuery node definition
 *													'where'   : 'inside'		// 'inside' | 'before' | 'after' | 'right' | 'left'
 *											  },
 *								'is_append': true,								// Apply  only if 	'where'   : 'inside'
 *								'style'    : 'text-align:left;',				// styles, if needed
 *							    'css_class': '',								// For example can  be: 'wpbc_fe_message_alt'
 *								'delay'    : 0,									// how many microsecond to  show,  if 0  then  show forever
 *								'if_visible_not_show': false					// if true,  then do not show message,  if previos message was not hided (not apply if 'where'   : 'inside' )
 *				};
 * Examples:
 * 			var html_id = wpbc_front_end__show_message( 'You can test days selection in calendar', {} );
 *
 *			var notice_message_id = wpbc_front_end__show_message( _wpbc.get_message( 'message_check_required' ), { 'type': 'warning', 'delay': 10000, 'if_visible_not_show': true,
 *																  'show_here': {'where': 'right', 'jq_node': el,} } );
 *
 *			wpbc_front_end__show_message( response_data[ 'ajx_data' ][ 'ajx_after_action_message' ].replace( /\n/g, "<br />" ),
 *											{   'type'     : ( 'undefined' !== typeof( response_data[ 'ajx_data' ][ 'ajx_after_action_message_status' ] ) )
 *															  ? response_data[ 'ajx_data' ][ 'ajx_after_action_message_status' ] : 'info',
 *												'show_here': {'jq_node': jq_node, 'where': 'after'},
 *												'css_class':'wpbc_fe_message_alt',
 *												'delay'    : 10000
 *											} );
 *
 *
 * @returns string  - HTML ID		or 0 if not showing during this time.
 */


function wpbc_front_end__show_message(message) {
  var params = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
  var params_default = {
    'type': 'warning',
    // 'error' | 'warning' | 'info' | 'success'
    'show_here': {
      'jq_node': '',
      // any jQuery node definition
      'where': 'inside' // 'inside' | 'before' | 'after' | 'right' | 'left'

    },
    'is_append': true,
    // Apply  only if 	'where'   : 'inside'
    'style': 'text-align:left;',
    // styles, if needed
    'css_class': '',
    // For example can  be: 'wpbc_fe_message_alt'
    'delay': 0,
    // how many microsecond to  show,  if 0  then  show forever
    'if_visible_not_show': false,
    // if true,  then do not show message,  if previos message was not hided (not apply if 'where'   : 'inside' )
    'is_scroll': true // is scroll  to  this element

  };

  for (var p_key in params) {
    params_default[p_key] = params[p_key];
  }

  params = params_default;
  var unique_div_id = new Date();
  unique_div_id = 'wpbc_notice_' + unique_div_id.getTime();
  params['css_class'] += ' wpbc_fe_message';

  if (params['type'] == 'error') {
    params['css_class'] += ' wpbc_fe_message_error';
    message = '<i class="menu_icon icon-1x wpbc_icn_report_gmailerrorred"></i>' + message;
  }

  if (params['type'] == 'warning') {
    params['css_class'] += ' wpbc_fe_message_warning';
    message = '<i class="menu_icon icon-1x wpbc_icn_warning"></i>' + message;
  }

  if (params['type'] == 'info') {
    params['css_class'] += ' wpbc_fe_message_info';
  }

  if (params['type'] == 'success') {
    params['css_class'] += ' wpbc_fe_message_success';
    message = '<i class="menu_icon icon-1x wpbc_icn_done_outline"></i>' + message;
  }

  var scroll_to_element = '<div id="' + unique_div_id + '_scroll" style="display:none;"></div>';
  message = '<div id="' + unique_div_id + '" class="wpbc_front_end__message ' + params['css_class'] + '" style="' + params['style'] + '">' + message + '</div>';
  var jq_el_message = false;
  var is_show_message = true;

  if ('inside' === params['show_here']['where']) {
    if (params['is_append']) {
      jQuery(params['show_here']['jq_node']).append(scroll_to_element);
      jQuery(params['show_here']['jq_node']).append(message);
    } else {
      jQuery(params['show_here']['jq_node']).html(scroll_to_element + message);
    }
  } else if ('before' === params['show_here']['where']) {
    jq_el_message = jQuery(params['show_here']['jq_node']).siblings('[id^="wpbc_notice_"]');

    if (params['if_visible_not_show'] && jq_el_message.is(':visible')) {
      is_show_message = false;
      unique_div_id = jQuery(jq_el_message.get(0)).attr('id');
    }

    if (is_show_message) {
      jQuery(params['show_here']['jq_node']).before(scroll_to_element);
      jQuery(params['show_here']['jq_node']).before(message);
    }
  } else if ('after' === params['show_here']['where']) {
    jq_el_message = jQuery(params['show_here']['jq_node']).nextAll('[id^="wpbc_notice_"]');

    if (params['if_visible_not_show'] && jq_el_message.is(':visible')) {
      is_show_message = false;
      unique_div_id = jQuery(jq_el_message.get(0)).attr('id');
    }

    if (is_show_message) {
      jQuery(params['show_here']['jq_node']).before(scroll_to_element); // We need to  set  here before(for handy scroll)

      jQuery(params['show_here']['jq_node']).after(message);
    }
  } else if ('right' === params['show_here']['where']) {
    jq_el_message = jQuery(params['show_here']['jq_node']).nextAll('.wpbc_front_end__message_container_right').find('[id^="wpbc_notice_"]');

    if (params['if_visible_not_show'] && jq_el_message.is(':visible')) {
      is_show_message = false;
      unique_div_id = jQuery(jq_el_message.get(0)).attr('id');
    }

    if (is_show_message) {
      jQuery(params['show_here']['jq_node']).before(scroll_to_element); // We need to  set  here before(for handy scroll)

      jQuery(params['show_here']['jq_node']).after('<div class="wpbc_front_end__message_container_right">' + message + '</div>');
    }
  } else if ('left' === params['show_here']['where']) {
    jq_el_message = jQuery(params['show_here']['jq_node']).siblings('.wpbc_front_end__message_container_left').find('[id^="wpbc_notice_"]');

    if (params['if_visible_not_show'] && jq_el_message.is(':visible')) {
      is_show_message = false;
      unique_div_id = jQuery(jq_el_message.get(0)).attr('id');
    }

    if (is_show_message) {
      jQuery(params['show_here']['jq_node']).before(scroll_to_element); // We need to  set  here before(for handy scroll)

      jQuery(params['show_here']['jq_node']).before('<div class="wpbc_front_end__message_container_left">' + message + '</div>');
    }
  }

  if (is_show_message && parseInt(params['delay']) > 0) {
    var closed_timer = setTimeout(function () {
      jQuery('#' + unique_div_id).fadeOut(1500);
    }, parseInt(params['delay']));
    var closed_timer2 = setTimeout(function () {
      jQuery('#' + unique_div_id).trigger('hide');
    }, parseInt(params['delay']) + 1501);
  } // Check  if showed message in some hidden parent section and show it. But it must  be lower than '.wpbc_container'


  var parent_els = jQuery('#' + unique_div_id).parents().map(function () {
    if (!jQuery(this).is('visible') && jQuery('.wpbc_container').has(this)) {
      jQuery(this).show();
    }
  });

  if (params['is_scroll']) {
    wpbc_do_scroll('#' + unique_div_id + '_scroll');
  }

  return unique_div_id;
}
/**
 * Error message. 	Preset of parameters for real message function.
 *
 * @param el		- any jQuery node definition
 * @param message	- Message HTML
 * @returns string  - HTML ID		or 0 if not showing during this time.
 */


function wpbc_front_end__show_message__error(jq_node, message) {
  var notice_message_id = wpbc_front_end__show_message(message, {
    'type': 'error',
    'delay': 10000,
    'if_visible_not_show': true,
    'show_here': {
      'where': 'right',
      'jq_node': jq_node
    }
  });
  return notice_message_id;
}
/**
 * Error message UNDER element. 	Preset of parameters for real message function.
 *
 * @param el		- any jQuery node definition
 * @param message	- Message HTML
 * @returns string  - HTML ID		or 0 if not showing during this time.
 */


function wpbc_front_end__show_message__error_under_element(jq_node, message, message_delay) {
  if ('undefined' === typeof message_delay) {
    message_delay = 0;
  }

  var notice_message_id = wpbc_front_end__show_message(message, {
    'type': 'error',
    'delay': message_delay,
    'if_visible_not_show': true,
    'show_here': {
      'where': 'after',
      'jq_node': jq_node
    }
  });
  return notice_message_id;
}
/**
 * Error message UNDER element. 	Preset of parameters for real message function.
 *
 * @param el		- any jQuery node definition
 * @param message	- Message HTML
 * @returns string  - HTML ID		or 0 if not showing during this time.
 */


function wpbc_front_end__show_message__error_above_element(jq_node, message, message_delay) {
  if ('undefined' === typeof message_delay) {
    message_delay = 10000;
  }

  var notice_message_id = wpbc_front_end__show_message(message, {
    'type': 'error',
    'delay': message_delay,
    'if_visible_not_show': true,
    'show_here': {
      'where': 'before',
      'jq_node': jq_node
    }
  });
  return notice_message_id;
}
/**
 * Warning message. 	Preset of parameters for real message function.
 *
 * @param el		- any jQuery node definition
 * @param message	- Message HTML
 * @returns string  - HTML ID		or 0 if not showing during this time.
 */


function wpbc_front_end__show_message__warning(jq_node, message) {
  var notice_message_id = wpbc_front_end__show_message(message, {
    'type': 'warning',
    'delay': 10000,
    'if_visible_not_show': true,
    'show_here': {
      'where': 'right',
      'jq_node': jq_node
    }
  });
  return notice_message_id;
}
/**
 * Warning message UNDER element. 	Preset of parameters for real message function.
 *
 * @param el		- any jQuery node definition
 * @param message	- Message HTML
 * @returns string  - HTML ID		or 0 if not showing during this time.
 */


function wpbc_front_end__show_message__warning_under_element(jq_node, message) {
  var notice_message_id = wpbc_front_end__show_message(message, {
    'type': 'warning',
    'delay': 10000,
    'if_visible_not_show': true,
    'show_here': {
      'where': 'after',
      'jq_node': jq_node
    }
  });
  return notice_message_id;
}
/**
 * Warning message ABOVE element. 	Preset of parameters for real message function.
 *
 * @param el		- any jQuery node definition
 * @param message	- Message HTML
 * @returns string  - HTML ID		or 0 if not showing during this time.
 */


function wpbc_front_end__show_message__warning_above_element(jq_node, message) {
  var notice_message_id = wpbc_front_end__show_message(message, {
    'type': 'warning',
    'delay': 10000,
    'if_visible_not_show': true,
    'show_here': {
      'where': 'before',
      'jq_node': jq_node
    }
  });
  return notice_message_id;
}
/**
 * Scroll to specific element
 *
 * @param jq_node					string or jQuery element,  where scroll  to
 * @param extra_shift_offset		int shift offset from  jq_node
 */


function wpbc_do_scroll(jq_node) {
  var extra_shift_offset = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;

  if (!jQuery(jq_node).length) {
    return;
  }

  var targetOffset = jQuery(jq_node).offset().top;

  if (targetOffset <= 0) {
    if (0 != jQuery(jq_node).nextAll(':visible').length) {
      targetOffset = jQuery(jq_node).nextAll(':visible').first().offset().top;
    } else if (0 != jQuery(jq_node).parent().nextAll(':visible').length) {
      targetOffset = jQuery(jq_node).parent().nextAll(':visible').first().offset().top;
    }
  }

  if (jQuery('#wpadminbar').length > 0) {
    targetOffset = targetOffset - 50 - 50;
  } else {
    targetOffset = targetOffset - 20 - 50;
  }

  targetOffset += extra_shift_offset; // Scroll only  if we did not scroll before

  if (!jQuery('html,body').is(':animated')) {
    jQuery('html,body').animate({
      scrollTop: targetOffset
    }, 500);
  }
}
//# sourceMappingURL=data:application/json;charset=utf8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndwYmMuanMiLCJhanhfbG9hZF9iYWxhbmNlci5qcyIsIndwYmNfY2FsLmpzIiwiZGF5c19zZWxlY3RfY3VzdG9tLmpzIiwid3BiY19jYWxfYWp4LmpzIiwid3BiY19mZV9tZXNzYWdlcy5qcyJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiQUFBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7O0FBQ0EsU0FBQSxjQUFBLENBQUEsR0FBQSxFQUFBO0FBRUEsU0FBQSxJQUFBLENBQUEsS0FBQSxDQUFBLElBQUEsQ0FBQSxTQUFBLENBQUEsR0FBQSxDQUFBLENBQUE7QUFDQTtBQUlBO0FBQ0E7QUFDQTs7O0FBRUEsSUFBQSxLQUFBLEdBQUEsVUFBQSxHQUFBLEVBQUEsQ0FBQSxFQUFBO0FBRUE7QUFDQSxNQUFBLFFBQUEsR0FBQSxHQUFBLENBQUEsWUFBQSxHQUFBLEdBQUEsQ0FBQSxZQUFBLElBQUE7QUFDQSxJQUFBLE9BQUEsRUFBQSxDQURBO0FBRUEsSUFBQSxLQUFBLEVBQUEsRUFGQTtBQUdBLElBQUEsTUFBQSxFQUFBO0FBSEEsR0FBQTs7QUFLQSxFQUFBLEdBQUEsQ0FBQSxnQkFBQSxHQUFBLFVBQUEsU0FBQSxFQUFBLFNBQUEsRUFBQTtBQUNBLElBQUEsUUFBQSxDQUFBLFNBQUEsQ0FBQSxHQUFBLFNBQUE7QUFDQSxHQUZBOztBQUlBLEVBQUEsR0FBQSxDQUFBLGdCQUFBLEdBQUEsVUFBQSxTQUFBLEVBQUE7QUFDQSxXQUFBLFFBQUEsQ0FBQSxTQUFBLENBQUE7QUFDQSxHQUZBLENBWkEsQ0FpQkE7OztBQUNBLE1BQUEsV0FBQSxHQUFBLEdBQUEsQ0FBQSxhQUFBLEdBQUEsR0FBQSxDQUFBLGFBQUEsSUFBQSxDQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBUEEsR0FBQTtBQVVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFDQSxFQUFBLEdBQUEsQ0FBQSxvQkFBQSxHQUFBLFVBQUEsV0FBQSxFQUFBO0FBRUEsV0FBQSxnQkFBQSxPQUFBLFdBQUEsQ0FBQSxjQUFBLFdBQUEsQ0FBQTtBQUNBLEdBSEE7QUFLQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQSxFQUFBLEdBQUEsQ0FBQSxjQUFBLEdBQUEsVUFBQSxXQUFBLEVBQUE7QUFFQSxJQUFBLFdBQUEsQ0FBQSxjQUFBLFdBQUEsQ0FBQSxHQUFBLEVBQUE7QUFDQSxJQUFBLFdBQUEsQ0FBQSxjQUFBLFdBQUEsQ0FBQSxDQUFBLElBQUEsSUFBQSxXQUFBO0FBQ0EsSUFBQSxXQUFBLENBQUEsY0FBQSxXQUFBLENBQUEsQ0FBQSx5QkFBQSxJQUFBLEtBQUE7QUFFQSxHQU5BO0FBUUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7O0FBQ0EsRUFBQSxHQUFBLENBQUEscUJBQUEsR0FBQSxVQUFBLGFBQUEsRUFBQTtBQUFBO0FBRUEsUUFBQSx5QkFBQSxHQUFBLENBQUEsbUJBQUEsRUFBQSxtQkFBQSxFQUFBLGlCQUFBLENBQUE7QUFFQSxRQUFBLFVBQUEsR0FBQSx5QkFBQSxDQUFBLFFBQUEsQ0FBQSxhQUFBLENBQUE7QUFFQSxXQUFBLFVBQUE7QUFDQSxHQVBBO0FBVUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQSxFQUFBLEdBQUEsQ0FBQSxrQkFBQSxHQUFBLFVBQUEsYUFBQSxFQUFBO0FBQ0EsSUFBQSxXQUFBLEdBQUEsYUFBQTtBQUNBLEdBRkE7QUFJQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQSxFQUFBLEdBQUEsQ0FBQSxrQkFBQSxHQUFBLFlBQUE7QUFDQSxXQUFBLFdBQUE7QUFDQSxHQUZBO0FBSUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQSxFQUFBLEdBQUEsQ0FBQSx3QkFBQSxHQUFBLFVBQUEsV0FBQSxFQUFBO0FBRUEsUUFBQSxHQUFBLENBQUEsb0JBQUEsQ0FBQSxXQUFBLENBQUEsRUFBQTtBQUVBLGFBQUEsV0FBQSxDQUFBLGNBQUEsV0FBQSxDQUFBO0FBQ0EsS0FIQSxNQUdBO0FBQ0EsYUFBQSxLQUFBO0FBQ0E7QUFDQSxHQVJBO0FBVUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7OztBQUNBLEVBQUEsR0FBQSxDQUFBLHdCQUFBLEdBQUEsVUFBQSxXQUFBLEVBQUEscUJBQUEsRUFBQTtBQUFBLFFBQUEscUJBQUEsdUVBQUEsS0FBQTs7QUFFQSxRQUFBLENBQUEsR0FBQSxDQUFBLG9CQUFBLENBQUEsV0FBQSxDQUFBLElBQUEsU0FBQSxxQkFBQSxFQUFBO0FBQ0EsTUFBQSxHQUFBLENBQUEsY0FBQSxDQUFBLFdBQUE7QUFDQTs7QUFFQSxTQUFBLElBQUEsU0FBQSxJQUFBLHFCQUFBLEVBQUE7QUFFQSxNQUFBLFdBQUEsQ0FBQSxjQUFBLFdBQUEsQ0FBQSxDQUFBLFNBQUEsSUFBQSxxQkFBQSxDQUFBLFNBQUEsQ0FBQTtBQUNBOztBQUVBLFdBQUEsV0FBQSxDQUFBLGNBQUEsV0FBQSxDQUFBO0FBQ0EsR0FaQTtBQWNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQSxFQUFBLEdBQUEsQ0FBQSx5QkFBQSxHQUFBLFVBQUEsV0FBQSxFQUFBLFNBQUEsRUFBQSxVQUFBLEVBQUE7QUFFQSxRQUFBLENBQUEsR0FBQSxDQUFBLG9CQUFBLENBQUEsV0FBQSxDQUFBLEVBQUE7QUFDQSxNQUFBLEdBQUEsQ0FBQSxjQUFBLENBQUEsV0FBQTtBQUNBOztBQUVBLElBQUEsV0FBQSxDQUFBLGNBQUEsV0FBQSxDQUFBLENBQUEsU0FBQSxJQUFBLFVBQUE7QUFFQSxXQUFBLFdBQUEsQ0FBQSxjQUFBLFdBQUEsQ0FBQTtBQUNBLEdBVEE7QUFXQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7O0FBQ0EsRUFBQSxHQUFBLENBQUEseUJBQUEsR0FBQSxVQUFBLFdBQUEsRUFBQSxTQUFBLEVBQUE7QUFFQSxRQUNBLEdBQUEsQ0FBQSxvQkFBQSxDQUFBLFdBQUEsQ0FBQSxJQUNBLGdCQUFBLE9BQUEsV0FBQSxDQUFBLGNBQUEsV0FBQSxDQUFBLENBQUEsU0FBQSxDQUZBLEVBR0E7QUFDQTtBQUNBLFVBQUEsR0FBQSxDQUFBLHFCQUFBLENBQUEsU0FBQSxDQUFBLEVBQUE7QUFDQSxRQUFBLFdBQUEsQ0FBQSxjQUFBLFdBQUEsQ0FBQSxDQUFBLFNBQUEsSUFBQSxRQUFBLENBQUEsV0FBQSxDQUFBLGNBQUEsV0FBQSxDQUFBLENBQUEsU0FBQSxDQUFBLENBQUE7QUFDQTs7QUFDQSxhQUFBLFdBQUEsQ0FBQSxjQUFBLFdBQUEsQ0FBQSxDQUFBLFNBQUEsQ0FBQTtBQUNBOztBQUVBLFdBQUEsSUFBQSxDQWJBLENBYUE7QUFDQSxHQWRBLENBN0pBLENBNEtBO0FBR0E7OztBQUNBLE1BQUEsVUFBQSxHQUFBLEdBQUEsQ0FBQSxZQUFBLEdBQUEsR0FBQSxDQUFBLFlBQUEsSUFBQSxDQUNBO0FBQ0E7QUFDQTtBQUNBO0FBSkEsR0FBQTtBQU9BO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFDQSxFQUFBLEdBQUEsQ0FBQSxnQ0FBQSxHQUFBLFVBQUEsV0FBQSxFQUFBO0FBRUEsV0FBQSxnQkFBQSxPQUFBLFVBQUEsQ0FBQSxjQUFBLFdBQUEsQ0FBQTtBQUNBLEdBSEE7QUFLQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7OztBQUNBLEVBQUEsR0FBQSxDQUFBLHlCQUFBLEdBQUEsVUFBQSxXQUFBLEVBQUE7QUFFQSxRQUFBLEdBQUEsQ0FBQSxnQ0FBQSxDQUFBLFdBQUEsQ0FBQSxFQUFBO0FBRUEsYUFBQSxVQUFBLENBQUEsY0FBQSxXQUFBLENBQUE7QUFDQSxLQUhBLE1BR0E7QUFDQSxhQUFBLEtBQUE7QUFDQTtBQUNBLEdBUkE7QUFVQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7OztBQUNBLEVBQUEsR0FBQSxDQUFBLHlCQUFBLEdBQUEsVUFBQSxXQUFBLEVBQUEsWUFBQSxFQUFBO0FBRUEsUUFBQSxDQUFBLEdBQUEsQ0FBQSxnQ0FBQSxDQUFBLFdBQUEsQ0FBQSxFQUFBO0FBQ0EsTUFBQSxVQUFBLENBQUEsY0FBQSxXQUFBLENBQUEsR0FBQSxFQUFBO0FBQ0EsTUFBQSxVQUFBLENBQUEsY0FBQSxXQUFBLENBQUEsQ0FBQSxJQUFBLElBQUEsV0FBQTtBQUNBOztBQUVBLFNBQUEsSUFBQSxTQUFBLElBQUEsWUFBQSxFQUFBO0FBRUEsTUFBQSxVQUFBLENBQUEsY0FBQSxXQUFBLENBQUEsQ0FBQSxTQUFBLElBQUEsWUFBQSxDQUFBLFNBQUEsQ0FBQTtBQUNBOztBQUVBLFdBQUEsVUFBQSxDQUFBLGNBQUEsV0FBQSxDQUFBO0FBQ0EsR0FiQSxDQWpPQSxDQWdQQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQSxFQUFBLEdBQUEsQ0FBQSwrQkFBQSxHQUFBLFVBQUEsV0FBQSxFQUFBO0FBRUEsUUFDQSxHQUFBLENBQUEsZ0NBQUEsQ0FBQSxXQUFBLENBQUEsSUFDQSxnQkFBQSxPQUFBLFVBQUEsQ0FBQSxjQUFBLFdBQUEsQ0FBQSxDQUFBLE9BQUEsQ0FGQSxFQUdBO0FBQ0EsYUFBQSxVQUFBLENBQUEsY0FBQSxXQUFBLENBQUEsQ0FBQSxPQUFBLENBQUE7QUFDQTs7QUFFQSxXQUFBLEtBQUEsQ0FUQSxDQVNBO0FBQ0EsR0FWQTtBQVlBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQSxFQUFBLEdBQUEsQ0FBQSwrQkFBQSxHQUFBLFVBQUEsV0FBQSxFQUFBLFNBQUEsRUFBQTtBQUFBLFFBQUEscUJBQUEsdUVBQUEsSUFBQTs7QUFFQSxRQUFBLENBQUEsR0FBQSxDQUFBLGdDQUFBLENBQUEsV0FBQSxDQUFBLEVBQUE7QUFDQSxNQUFBLEdBQUEsQ0FBQSx5QkFBQSxDQUFBLFdBQUEsRUFBQTtBQUFBLGlCQUFBO0FBQUEsT0FBQTtBQUNBOztBQUVBLFFBQUEsZ0JBQUEsT0FBQSxVQUFBLENBQUEsY0FBQSxXQUFBLENBQUEsQ0FBQSxPQUFBLENBQUEsRUFBQTtBQUNBLE1BQUEsVUFBQSxDQUFBLGNBQUEsV0FBQSxDQUFBLENBQUEsT0FBQSxJQUFBLEVBQUE7QUFDQTs7QUFFQSxRQUFBLHFCQUFBLEVBQUE7QUFFQTtBQUNBLE1BQUEsVUFBQSxDQUFBLGNBQUEsV0FBQSxDQUFBLENBQUEsT0FBQSxJQUFBLFNBQUE7QUFDQSxLQUpBLE1BSUE7QUFFQTtBQUNBLFdBQUEsSUFBQSxTQUFBLElBQUEsU0FBQSxFQUFBO0FBRUEsUUFBQSxVQUFBLENBQUEsY0FBQSxXQUFBLENBQUEsQ0FBQSxPQUFBLEVBQUEsU0FBQSxJQUFBLFNBQUEsQ0FBQSxTQUFBLENBQUE7QUFDQTtBQUNBOztBQUVBLFdBQUEsVUFBQSxDQUFBLGNBQUEsV0FBQSxDQUFBO0FBQ0EsR0F4QkE7QUEyQkE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7O0FBQ0EsRUFBQSxHQUFBLENBQUEsa0NBQUEsR0FBQSxVQUFBLFdBQUEsRUFBQSxhQUFBLEVBQUE7QUFFQSxRQUNBLEdBQUEsQ0FBQSxnQ0FBQSxDQUFBLFdBQUEsQ0FBQSxJQUNBLGdCQUFBLE9BQUEsVUFBQSxDQUFBLGNBQUEsV0FBQSxDQUFBLENBQUEsT0FBQSxDQURBLElBRUEsZ0JBQUEsT0FBQSxVQUFBLENBQUEsY0FBQSxXQUFBLENBQUEsQ0FBQSxPQUFBLEVBQUEsYUFBQSxDQUhBLEVBSUE7QUFDQSxhQUFBLFVBQUEsQ0FBQSxjQUFBLFdBQUEsQ0FBQSxDQUFBLE9BQUEsRUFBQSxhQUFBLENBQUE7QUFDQTs7QUFFQSxXQUFBLEtBQUEsQ0FWQSxDQVVBO0FBQ0EsR0FYQSxDQXJVQSxDQW1WQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7O0FBQ0EsRUFBQSxHQUFBLENBQUEsd0JBQUEsR0FBQSxVQUFBLFdBQUEsRUFBQSxTQUFBLEVBQUEsVUFBQSxFQUFBO0FBRUEsUUFBQSxDQUFBLEdBQUEsQ0FBQSxnQ0FBQSxDQUFBLFdBQUEsQ0FBQSxFQUFBO0FBQ0EsTUFBQSxVQUFBLENBQUEsY0FBQSxXQUFBLENBQUEsR0FBQSxFQUFBO0FBQ0EsTUFBQSxVQUFBLENBQUEsY0FBQSxXQUFBLENBQUEsQ0FBQSxJQUFBLElBQUEsV0FBQTtBQUNBOztBQUVBLElBQUEsVUFBQSxDQUFBLGNBQUEsV0FBQSxDQUFBLENBQUEsU0FBQSxJQUFBLFVBQUE7QUFFQSxXQUFBLFVBQUEsQ0FBQSxjQUFBLFdBQUEsQ0FBQTtBQUNBLEdBVkE7QUFZQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7O0FBQ0EsRUFBQSxHQUFBLENBQUEsd0JBQUEsR0FBQSxVQUFBLFdBQUEsRUFBQSxTQUFBLEVBQUE7QUFFQSxRQUNBLEdBQUEsQ0FBQSxnQ0FBQSxDQUFBLFdBQUEsQ0FBQSxJQUNBLGdCQUFBLE9BQUEsVUFBQSxDQUFBLGNBQUEsV0FBQSxDQUFBLENBQUEsU0FBQSxDQUZBLEVBR0E7QUFDQSxhQUFBLFVBQUEsQ0FBQSxjQUFBLFdBQUEsQ0FBQSxDQUFBLFNBQUEsQ0FBQTtBQUNBOztBQUVBLFdBQUEsSUFBQSxDQVRBLENBU0E7QUFDQSxHQVZBO0FBZUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQSxFQUFBLEdBQUEsQ0FBQSw4QkFBQSxHQUFBLFVBQUEsYUFBQSxFQUFBO0FBQ0EsSUFBQSxVQUFBLEdBQUEsYUFBQTtBQUNBLEdBRkE7QUFJQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQSxFQUFBLEdBQUEsQ0FBQSw4QkFBQSxHQUFBLFlBQUE7QUFDQSxXQUFBLFVBQUE7QUFDQSxHQUZBLENBN1lBLENBZ1pBO0FBS0E7OztBQUNBLE1BQUEsU0FBQSxHQUFBLEdBQUEsQ0FBQSxXQUFBLEdBQUEsR0FBQSxDQUFBLFdBQUEsSUFBQSxDQUNBO0FBQ0E7QUFDQTtBQUNBO0FBSkEsR0FBQTtBQU9BO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFDQSxFQUFBLEdBQUEsQ0FBQSxZQUFBLEdBQUEsVUFBQSxXQUFBLEVBQUEsU0FBQSxFQUFBO0FBQUEsUUFBQSxxQkFBQSx1RUFBQSxLQUFBOztBQUVBLFFBQUEsZ0JBQUEsT0FBQSxTQUFBLENBQUEsY0FBQSxXQUFBLENBQUEsRUFBQTtBQUNBLE1BQUEsU0FBQSxDQUFBLGNBQUEsV0FBQSxDQUFBLEdBQUEsRUFBQTtBQUNBOztBQUVBLFFBQUEscUJBQUEsRUFBQTtBQUVBO0FBQ0EsTUFBQSxTQUFBLENBQUEsY0FBQSxXQUFBLENBQUEsR0FBQSxTQUFBO0FBRUEsS0FMQSxNQUtBO0FBRUE7QUFDQSxXQUFBLElBQUEsU0FBQSxJQUFBLFNBQUEsRUFBQTtBQUVBLFlBQUEsZ0JBQUEsT0FBQSxTQUFBLENBQUEsY0FBQSxXQUFBLENBQUEsQ0FBQSxTQUFBLENBQUEsRUFBQTtBQUNBLFVBQUEsU0FBQSxDQUFBLGNBQUEsV0FBQSxDQUFBLENBQUEsU0FBQSxJQUFBLEVBQUE7QUFDQTs7QUFDQSxhQUFBLElBQUEsZUFBQSxJQUFBLFNBQUEsQ0FBQSxTQUFBLENBQUEsRUFBQTtBQUNBLFVBQUEsU0FBQSxDQUFBLGNBQUEsV0FBQSxDQUFBLENBQUEsU0FBQSxFQUFBLElBQUEsQ0FBQSxTQUFBLENBQUEsU0FBQSxDQUFBLENBQUEsZUFBQSxDQUFBO0FBQ0E7QUFDQTtBQUNBOztBQUVBLFdBQUEsU0FBQSxDQUFBLGNBQUEsV0FBQSxDQUFBO0FBQ0EsR0ExQkE7QUE2QkE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7OztBQUNBLEVBQUEsR0FBQSxDQUFBLHFCQUFBLEdBQUEsVUFBQSxXQUFBLEVBQUEsYUFBQSxFQUFBO0FBRUEsUUFDQSxnQkFBQSxPQUFBLFNBQUEsQ0FBQSxjQUFBLFdBQUEsQ0FBQSxJQUNBLGdCQUFBLE9BQUEsU0FBQSxDQUFBLGNBQUEsV0FBQSxDQUFBLENBQUEsYUFBQSxDQUZBLEVBR0E7QUFDQSxhQUFBLFNBQUEsQ0FBQSxjQUFBLFdBQUEsQ0FBQSxDQUFBLGFBQUEsQ0FBQTtBQUNBOztBQUVBLFdBQUEsRUFBQSxDQVRBLENBU0E7QUFDQSxHQVZBLENBN2NBLENBMGRBOzs7QUFDQSxNQUFBLE9BQUEsR0FBQSxHQUFBLENBQUEsU0FBQSxHQUFBLEdBQUEsQ0FBQSxTQUFBLElBQUEsRUFBQTs7QUFFQSxFQUFBLEdBQUEsQ0FBQSxlQUFBLEdBQUEsVUFBQSxTQUFBLEVBQUEsU0FBQSxFQUFBO0FBQ0EsSUFBQSxPQUFBLENBQUEsU0FBQSxDQUFBLEdBQUEsU0FBQTtBQUNBLEdBRkE7O0FBSUEsRUFBQSxHQUFBLENBQUEsZUFBQSxHQUFBLFVBQUEsU0FBQSxFQUFBO0FBQ0EsV0FBQSxPQUFBLENBQUEsU0FBQSxDQUFBO0FBQ0EsR0FGQTtBQUlBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7OztBQUNBLEVBQUEsR0FBQSxDQUFBLG9CQUFBLEdBQUEsWUFBQTtBQUNBLFdBQUEsT0FBQTtBQUNBLEdBRkEsQ0ExZUEsQ0E4ZUE7OztBQUNBLE1BQUEsVUFBQSxHQUFBLEdBQUEsQ0FBQSxZQUFBLEdBQUEsR0FBQSxDQUFBLFlBQUEsSUFBQSxFQUFBOztBQUVBLEVBQUEsR0FBQSxDQUFBLFdBQUEsR0FBQSxVQUFBLFNBQUEsRUFBQSxTQUFBLEVBQUE7QUFDQSxJQUFBLFVBQUEsQ0FBQSxTQUFBLENBQUEsR0FBQSxTQUFBO0FBQ0EsR0FGQTs7QUFJQSxFQUFBLEdBQUEsQ0FBQSxXQUFBLEdBQUEsVUFBQSxTQUFBLEVBQUE7QUFDQSxXQUFBLFVBQUEsQ0FBQSxTQUFBLENBQUE7QUFDQSxHQUZBO0FBSUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7O0FBQ0EsRUFBQSxHQUFBLENBQUEsaUJBQUEsR0FBQSxZQUFBO0FBQ0EsV0FBQSxVQUFBO0FBQ0EsR0FGQSxDQTlmQSxDQWtnQkE7OztBQUVBLFNBQUEsR0FBQTtBQUVBLENBdGdCQSxDQXNnQkEsS0FBQSxJQUFBLEVBdGdCQSxFQXNnQkEsTUF0Z0JBLENBQUE7QUN4QkE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQSxLQUFBLEdBQUEsVUFBQSxHQUFBLEVBQUEsQ0FBQSxFQUFBO0FBRUE7QUFFQSxNQUFBLFVBQUEsR0FBQSxHQUFBLENBQUEsWUFBQSxHQUFBLEdBQUEsQ0FBQSxZQUFBLElBQUE7QUFDQSxtQkFBQSxDQURBO0FBRUEsa0JBQUEsRUFGQTtBQUdBLFlBQUE7QUFIQSxHQUFBO0FBTUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFDQSxFQUFBLEdBQUEsQ0FBQSx5QkFBQSxHQUFBLFVBQUEsV0FBQSxFQUFBO0FBRUEsSUFBQSxVQUFBLENBQUEsYUFBQSxDQUFBLEdBQUEsV0FBQTtBQUNBLEdBSEE7QUFLQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7OztBQUNBLEVBQUEsR0FBQSxDQUFBLG9CQUFBLEdBQUEsVUFBQSxXQUFBLEVBQUE7QUFFQSxXQUFBLGdCQUFBLE9BQUEsVUFBQSxDQUFBLGNBQUEsV0FBQSxDQUFBO0FBQ0EsR0FIQTtBQU1BO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7OztBQUNBLEVBQUEsR0FBQSxDQUFBLGNBQUEsR0FBQSxVQUFBLFdBQUEsRUFBQSxhQUFBLEVBQUE7QUFBQSxRQUFBLE1BQUEsdUVBQUEsRUFBQTtBQUVBLFFBQUEsV0FBQSxHQUFBLEVBQUE7QUFDQSxJQUFBLFdBQUEsQ0FBQSxhQUFBLENBQUEsR0FBQSxXQUFBO0FBQ0EsSUFBQSxXQUFBLENBQUEsVUFBQSxDQUFBLEdBQUEsQ0FBQTtBQUNBLElBQUEsV0FBQSxDQUFBLGVBQUEsQ0FBQSxHQUFBLGFBQUE7QUFDQSxJQUFBLFdBQUEsQ0FBQSxRQUFBLENBQUEsR0FBQSxjQUFBLENBQUEsTUFBQSxDQUFBOztBQUdBLFFBQUEsR0FBQSxDQUFBLHdCQUFBLENBQUEsV0FBQSxFQUFBLGFBQUEsQ0FBQSxFQUFBO0FBQ0EsYUFBQSxLQUFBO0FBQ0E7O0FBQ0EsUUFBQSxHQUFBLENBQUEseUJBQUEsQ0FBQSxXQUFBLEVBQUEsYUFBQSxDQUFBLEVBQUE7QUFDQSxhQUFBLE1BQUE7QUFDQTs7QUFHQSxRQUFBLEdBQUEsQ0FBQSxtQkFBQSxFQUFBLEVBQUE7QUFDQSxNQUFBLEdBQUEsQ0FBQSxxQkFBQSxDQUFBLFdBQUE7QUFDQSxhQUFBLEtBQUE7QUFDQSxLQUhBLE1BR0E7QUFDQSxNQUFBLEdBQUEsQ0FBQSxzQkFBQSxDQUFBLFdBQUE7QUFDQSxhQUFBLE1BQUE7QUFDQTtBQUNBLEdBeEJBO0FBMEJBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQSxFQUFBLEdBQUEsQ0FBQSxtQkFBQSxHQUFBLFlBQUE7QUFDQSxXQUFBLFVBQUEsQ0FBQSxZQUFBLENBQUEsQ0FBQSxNQUFBLEdBQUEsVUFBQSxDQUFBLGFBQUEsQ0FBQTtBQUNBLEdBRkE7QUFJQTtBQUNBO0FBQ0E7QUFDQTs7O0FBQ0EsRUFBQSxHQUFBLENBQUEsc0JBQUEsR0FBQSxVQUFBLFdBQUEsRUFBQTtBQUNBLElBQUEsVUFBQSxDQUFBLE1BQUEsQ0FBQSxDQUFBLElBQUEsQ0FBQSxXQUFBO0FBQ0EsR0FGQTtBQUlBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQSxFQUFBLEdBQUEsQ0FBQSxnQ0FBQSxHQUFBLFVBQUEsV0FBQSxFQUFBLGFBQUEsRUFBQTtBQUVBLFFBQUEsVUFBQSxHQUFBLEtBQUE7O0FBRUEsUUFBQSxVQUFBLENBQUEsTUFBQSxDQUFBLENBQUEsTUFBQSxFQUFBO0FBQUE7QUFDQSxXQUFBLElBQUEsQ0FBQSxJQUFBLFVBQUEsQ0FBQSxNQUFBLENBQUEsRUFBQTtBQUNBLFlBQ0EsV0FBQSxLQUFBLFVBQUEsQ0FBQSxNQUFBLENBQUEsQ0FBQSxDQUFBLEVBQUEsYUFBQSxDQUFBLElBQ0EsYUFBQSxLQUFBLFVBQUEsQ0FBQSxNQUFBLENBQUEsQ0FBQSxDQUFBLEVBQUEsZUFBQSxDQUZBLEVBR0E7QUFDQSxVQUFBLFVBQUEsR0FBQSxVQUFBLENBQUEsTUFBQSxDQUFBLENBQUEsTUFBQSxDQUFBLENBQUEsRUFBQSxDQUFBLENBQUE7QUFDQSxVQUFBLFVBQUEsR0FBQSxVQUFBLENBQUEsR0FBQSxFQUFBO0FBQ0EsVUFBQSxVQUFBLENBQUEsTUFBQSxDQUFBLEdBQUEsVUFBQSxDQUFBLE1BQUEsQ0FBQSxDQUFBLE1BQUEsQ0FBQSxVQUFBLENBQUEsRUFBQTtBQUNBLG1CQUFBLENBQUE7QUFDQSxXQUZBLENBQUEsQ0FIQSxDQUtBOztBQUNBLGlCQUFBLFVBQUE7QUFDQTtBQUNBO0FBQ0E7O0FBQ0EsV0FBQSxVQUFBO0FBQ0EsR0FwQkE7QUFzQkE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7OztBQUNBLEVBQUEsR0FBQSxDQUFBLHlCQUFBLEdBQUEsVUFBQSxXQUFBLEVBQUEsYUFBQSxFQUFBO0FBRUEsUUFBQSxVQUFBLENBQUEsTUFBQSxDQUFBLENBQUEsTUFBQSxFQUFBO0FBQUE7QUFDQSxXQUFBLElBQUEsQ0FBQSxJQUFBLFVBQUEsQ0FBQSxNQUFBLENBQUEsRUFBQTtBQUNBLFlBQ0EsV0FBQSxLQUFBLFVBQUEsQ0FBQSxNQUFBLENBQUEsQ0FBQSxDQUFBLEVBQUEsYUFBQSxDQUFBLElBQ0EsYUFBQSxLQUFBLFVBQUEsQ0FBQSxNQUFBLENBQUEsQ0FBQSxDQUFBLEVBQUEsZUFBQSxDQUZBLEVBR0E7QUFDQSxpQkFBQSxJQUFBO0FBQ0E7QUFDQTtBQUNBOztBQUNBLFdBQUEsS0FBQTtBQUNBLEdBYkE7QUFnQkE7QUFDQTtBQUNBO0FBQ0E7OztBQUNBLEVBQUEsR0FBQSxDQUFBLHFCQUFBLEdBQUEsVUFBQSxXQUFBLEVBQUE7QUFDQSxJQUFBLFVBQUEsQ0FBQSxZQUFBLENBQUEsQ0FBQSxJQUFBLENBQUEsV0FBQTtBQUNBLEdBRkE7QUFJQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7O0FBQ0EsRUFBQSxHQUFBLENBQUEsK0JBQUEsR0FBQSxVQUFBLFdBQUEsRUFBQSxhQUFBLEVBQUE7QUFFQSxRQUFBLFVBQUEsR0FBQSxLQUFBOztBQUVBLFFBQUEsVUFBQSxDQUFBLFlBQUEsQ0FBQSxDQUFBLE1BQUEsRUFBQTtBQUFBO0FBQ0EsV0FBQSxJQUFBLENBQUEsSUFBQSxVQUFBLENBQUEsWUFBQSxDQUFBLEVBQUE7QUFDQSxZQUNBLFdBQUEsS0FBQSxVQUFBLENBQUEsWUFBQSxDQUFBLENBQUEsQ0FBQSxFQUFBLGFBQUEsQ0FBQSxJQUNBLGFBQUEsS0FBQSxVQUFBLENBQUEsWUFBQSxDQUFBLENBQUEsQ0FBQSxFQUFBLGVBQUEsQ0FGQSxFQUdBO0FBQ0EsVUFBQSxVQUFBLEdBQUEsVUFBQSxDQUFBLFlBQUEsQ0FBQSxDQUFBLE1BQUEsQ0FBQSxDQUFBLEVBQUEsQ0FBQSxDQUFBO0FBQ0EsVUFBQSxVQUFBLEdBQUEsVUFBQSxDQUFBLEdBQUEsRUFBQTtBQUNBLFVBQUEsVUFBQSxDQUFBLFlBQUEsQ0FBQSxHQUFBLFVBQUEsQ0FBQSxZQUFBLENBQUEsQ0FBQSxNQUFBLENBQUEsVUFBQSxDQUFBLEVBQUE7QUFDQSxtQkFBQSxDQUFBO0FBQ0EsV0FGQSxDQUFBLENBSEEsQ0FLQTs7QUFDQSxpQkFBQSxVQUFBO0FBQ0E7QUFDQTtBQUNBOztBQUNBLFdBQUEsVUFBQTtBQUNBLEdBcEJBO0FBc0JBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQSxFQUFBLEdBQUEsQ0FBQSx3QkFBQSxHQUFBLFVBQUEsV0FBQSxFQUFBLGFBQUEsRUFBQTtBQUVBLFFBQUEsVUFBQSxDQUFBLFlBQUEsQ0FBQSxDQUFBLE1BQUEsRUFBQTtBQUFBO0FBQ0EsV0FBQSxJQUFBLENBQUEsSUFBQSxVQUFBLENBQUEsWUFBQSxDQUFBLEVBQUE7QUFDQSxZQUNBLFdBQUEsS0FBQSxVQUFBLENBQUEsWUFBQSxDQUFBLENBQUEsQ0FBQSxFQUFBLGFBQUEsQ0FBQSxJQUNBLGFBQUEsS0FBQSxVQUFBLENBQUEsWUFBQSxDQUFBLENBQUEsQ0FBQSxFQUFBLGVBQUEsQ0FGQSxFQUdBO0FBQ0EsaUJBQUEsSUFBQTtBQUNBO0FBQ0E7QUFDQTs7QUFDQSxXQUFBLEtBQUE7QUFDQSxHQWJBOztBQWlCQSxFQUFBLEdBQUEsQ0FBQSxrQkFBQSxHQUFBLFlBQUE7QUFFQTtBQUNBLFFBQUEsVUFBQSxHQUFBLEtBQUE7O0FBQ0EsUUFBQSxVQUFBLENBQUEsTUFBQSxD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QUEsQ0FBQSxLQUFBLENBQUEsZUFBQSxDQUFBLFdBQUEsRUFBQSxDQUFBLENBQUEsRUFBQSxRQUFBLENBQUEsS0FBQSxDQUFBLGVBQUEsQ0FBQSxXQUFBLEVBQUEsQ0FBQSxDQUFBLENBQUEsR0FBQSxDQUFBLEVBQUEsS0FBQSxDQUFBLGVBQUEsQ0FBQSxXQUFBLEVBQUEsQ0FBQSxDQUFBLEVBQUEsQ0FBQSxFQUFBLENBQUEsRUFBQSxDQUFBLENBQUEsQ0F6QkEsQ0F5QkE7QUFDQTs7QUFDQSxNQUFBLGVBQUEsR0FBQSxLQUFBLENBQUEseUJBQUEsQ0FBQSxXQUFBLEVBQUEsaUNBQUEsQ0FBQSxDQTNCQSxDQTRCQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7OztBQUVBLE1BQUEsUUFBQSxDQUFBLElBQUEsQ0FBQSxPQUFBLENBQUEsZUFBQSxLQUFBLENBQUEsQ0FBQSxJQUNBLFFBQUEsQ0FBQSxJQUFBLENBQUEsT0FBQSxDQUFBLGNBQUEsS0FBQSxDQUFBLENBREEsQ0FDQTtBQURBLElBRUE7QUFDQSxJQUFBLGVBQUEsR0FBQSxJQUFBO0FBQ0EsSUFBQSxlQUFBLEdBQUEsSUFBQTtBQUNBOztBQUVBLE1BQUEsb0JBQUEsR0FBQSxLQUFBLENBQUEseUJBQUEsQ0FBQSxXQUFBLEVBQUEseUJBQUEsQ0FBQTs7QUFDQSxNQUFBLHVCQUFBLEdBQUEsUUFBQSxDQUFBLEtBQUEsQ0FBQSx5QkFBQSxDQUFBLFdBQUEsRUFBQSwyQkFBQSxDQUFBLENBQUE7QUFFQSxFQUFBLE1BQUEsQ0FBQSxzQkFBQSxXQUFBLENBQUEsQ0FBQSxJQUFBLENBQUEsRUFBQSxFQTlDQSxDQThDQTtBQUNBO0FBQ0E7QUFDQTs7QUFDQSxFQUFBLE1BQUEsQ0FBQSxzQkFBQSxXQUFBLENBQUEsQ0FBQSxRQUFBLENBQ0E7QUFDQSxJQUFBLGFBQUEsRUFBQSx1QkFBQSxPQUFBLEVBQUE7QUFDQSxhQUFBLGlDQUFBLENBQUEsT0FBQSxFQUFBO0FBQUEsdUJBQUE7QUFBQSxPQUFBLEVBQUEsSUFBQSxDQUFBO0FBQ0EsS0FIQTtBQUlBLElB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QUFBLENBQUEsR0FBQSxpQkFBQSxDQUFBLGtCQUFBLENBQUEsQ0FBQTtBQUNBLEdBSkEsTUFJQTtBQUNBLElBQUEsaUJBQUEsR0FBQSxLQUFBO0FBQ0EsSUFBQSxxQkFBQSxDQUFBLElBQUEsQ0FBQSx1QkFBQTtBQUNBOztBQUdBLFVBQUEsaUJBQUEsQ0FBQSxTQUFBLENBQUEsQ0FBQSxnQkFBQSxDQUFBO0FBRUEsU0FBQSxXQUFBO0FBQ0E7O0FBRUEsU0FBQSxvQkFBQTtBQUNBLE1BQUEscUJBQUEsQ0FBQSxJQUFBLENBQUEsYUFBQSxFQUFBLGFBQUE7QUFDQTs7QUFFQSxTQUFBLGtCQUFBO0FBQ0EsTUFBQSxxQkFBQSxDQUFBLElBQUEsQ0FBQSxrQkFBQTtBQUNBOztBQUVBLFNBQUEsZUFBQTtBQUNBLE1BQUEscUJBQUEsQ0FBQSxJQUFBLENBQUEsdUJBQUEsRUFBQSxvQkFBQTtBQUNBLE1BQUEsaUJBQUEsQ0FBQSxTQUFBLENBQUEsQ0FBQSxxQkFBQSxJQUFBLEVBQUEsQ0FGQSxDQUVBOztBQUNBOztBQUVBLFNBQUEsdUJBQUE7QUFDQSxNQUFBLHFCQUFBLENBQUEsSUFBQSxDQUFBLHVCQUFBLEVBQUEsc0JBQUE7QUFDQSxNQUFBLGlCQUFBLENBQUEsU0FBQSxDQUFBLENBQUEscUJBQUEsSUFBQSxFQUFBLENBRkEsQ0FFQTs7QUFDQTs7QUFFQSxTQUFBLHFCQUFBO0FBQ0EsTUFBQSxxQkFBQSxDQUFBLElBQUEsQ0FBQSx1QkFBQSxFQUFBLHFCQUFBO0FBQ0EsTUFBQSxpQkFBQSxDQUFBLFNBQUEsQ0FBQSxDQUFBLHFCQUFBLElBQUEsRUFBQSxDQUZBLENBRUE7O0FBQ0E7O0FBRUEsU0FBQSx3QkFBQTtBQUNBLE1BQUEscUJBQUEsQ0FBQSxJQUFBLENBQUEsdUJBQUEsRUFBQSx3QkFBQTtBQUNBLE1BQUEsaUJBQUEsQ0FBQSxTQUFBLENBQUEsQ0FBQSxxQkFBQSxJQUFBLEVBQUEsQ0FGQSxDQUVBOztBQUNBOztBQUVBLFNBQUEsNEJBQUE7QUFDQSxNQUFBLHFCQUFBLENBQUEsSUFBQSxDQUFBLHVCQUFBLEVBQUEsNEJBQUE7QUFDQSxNQUFBLGlCQUFBLENBQUEsU0FBQSxDQUFBLENBQUEscUJBQUEsSUFBQSxFQUFBLENBRkEsQ0FFQTs7QUFDQTs7QUFFQSxTQUFBLGFBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUVBLE1BQUEscUJBQUEsQ0FBQSxJQUFBLENBQUEsYUFBQSxFQUFBLGVBQUEsRUFBQSxnQkFBQSxFQVRBLENBVUE7O0FBQ0EsVUFBQSxpQkFBQSxDQUFBLFNBQUEsQ0FBQSxDQUFBLHFCQUFBLEVBQUEsT0FBQSxDQUFBLGtCQUFBLElBQUEsQ0FBQSxDQUFBLEVBQUE7QUFDQSxRQUFBLHFCQUFBLENBQUEsSUFBQSxDQUFBLDhCQUFBLEVBQUEsNEJBQUE7QUFDQTs7QUFDQSxVQUFBLGlCQUFBLENBQUEsU0FBQSxDQUFBLENBQUEscUJBQUEsRUFBQSxPQUFBLENBQUEsa0JBQUEsSUFBQSxDQUFBLENBQUEsRUFBQTtBQUNBLFFBQUEscUJBQUEsQ0FBQSxJQUFBLENBQUEsNkJBQUEsRUFBQSw2QkFBQTtBQUNBOztBQUNBOztBQUVBLFNBQUEsVUFBQTtBQUNBLE1BQUEscUJBQUEsQ0FBQSxJQUFBLENBQUEsYUFBQSxFQUFBLGVBQUEsRUFEQSxDQUdBOztBQUNBLFVBQUEsaUJBQUEsQ0FBQSxTQUFBLENBQUEsQ0FBQSxxQkFBQSxFQUFBLE9BQUEsQ0FBQSxTQUFBLElBQUEsQ0FBQSxDQUFBLEVBQUE7QUFDQSxRQUFBLHFCQUFBLENBQUEsSUFBQSxDQUFBLDRCQUFBO0FBQ0EsT0FGQSxNQUVBLElBQUEsaUJBQUEsQ0FBQSxTQUFBLENBQUEsQ0FBQSxxQkFBQSxFQUFBLE9BQUEsQ0FBQSxVQUFBLElBQUEsQ0FBQSxDQUFBLEVBQUE7QUFDQSxRQUFBLHFCQUFBLENBQUEsSUFBQSxDQUFBLDZCQUFBO0FBQ0E7O0FBQ0E7O0FBRUEsU0FBQSxXQUFBO0FBQ0EsTUFBQSxxQkFBQSxDQUFBLElBQUEsQ0FBQSxhQUFBLEVBQUEsZ0JBQUEsRUFEQSxDQUdBOztBQUNBLFVBQUEsaUJBQUEsQ0FBQSxTQUFBLENBQUEsQ0FBQSxxQkFBQSxFQUFBLE9BQUEsQ0FBQSxTQUFBLElBQUEsQ0FBQSxDQUFBLEVBQUE7QUFDQSxRQUFBLHFCQUFBLENBQUEsSUFBQSxDQUFBLDZCQUFBO0FBQ0EsT0FGQSxNQUVBLElBQUEsaUJBQUEsQ0FBQSxTQUFBLENBQUEsQ0FBQSxxQkFBQSxFQUFBLE9BQUEsQ0FBQSxVQUFBLElBQUEsQ0FBQSxDQUFBLEVBQUE7QUFDQSxRQUFBLHFCQUFBLENBQUEsSUFBQSxDQUFBLDhCQUFBO0FBQ0E7O0FBQ0E7O0FBRUE7QUFDQTtBQUNBLE1BQUEsaUJBQUEsQ0FBQSxTQUFBLENBQUEsQ0FBQSxnQkFBQSxJQUFBLFdBQUE7QUFqRkE7O0FBc0ZBLE1BQUEsZUFBQSxpQkFBQSxDQUFBLFNBQUEsQ0FBQSxDQUFBLGdCQUFBLENBQUEsRUFBQTtBQUVBLFFBQUEsOEJBQUEsR0FBQSxLQUFBLENBQUEseUJBQUEsQ0FBQSxXQUFBLEVBQUEseUJBQUEsQ0FBQSxDQUZBLENBRUE7OztBQUVBLFlBQUEsaUJBQUEsQ0FBQSxTQUFBLENBQUEsQ0FBQSxxQkFBQSxDQUFBO0FBRUEsV0FBQSxFQUFBO0FBQ0E7QUFDQTs7QUFFQSxXQUFBLFNBQUE7QUFDQSxRQUFBLHFCQUFBLENBQUEsSUFBQSxDQUFBLGNBQUE7QUFDQSxRQUFBLGlCQUFBLEdBQUEsaUJBQUEsR0FBQSxJQUFBLEdBQUEsOEJBQUE7QUFDQTs7QUFFQSxXQUFBLFVBQUE7QUFDQSxRQUFBLHFCQUFBLENBQUEsSUFBQSxDQUFBLGVBQUE7QUFDQTtBQUVBOztBQUNBLFdBQUEsaUJBQUE7QUFDQSxRQUFBLHFCQUFBLENBQUEsSUFBQSxDQUFBLDZCQUFBLEVBQUEsNEJBQUE7QUFDQSxRQUFBLGlCQUFBLEdBQUEsaUJBQUEsR0FBQSxJQUFBLEdBQUEsOEJBQUE7QUFDQTs7QUFFQSxXQUFBLGtCQUFBO0FBQ0EsUUFBQSxxQkFBQSxDQUFBLElBQUEsQ0FBQSw2QkFBQSxFQUFBLDZCQUFBO0FBQ0EsUUFBQSxpQkFBQSxHQUFBLGlCQUFBLEdBQUEsSUFBQSxHQUFBLDhCQUFBO0FBQ0E7O0FBRUEsV0FBQSxrQkFBQTtBQUNBLFFBQUEscUJBQUEsQ0FBQSxJQUFBLENBQUEsOEJBQUEsRUFBQSw0QkFBQTtBQUNBLFFBQUEsaUJBQUEsR0FBQSxpQkFBQSxHQUFBLElBQUEsR0FBQSw4QkFBQTtBQUNBOztBQUVBLFdBQUEsbUJBQUE7QUFDQSxRQUFBLHFCQUFBLENBQUEsSUFBQSxDQUFBLDhCQUFBLEVBQUEsNkJBQUE7QUFDQTs7QUFFQTtBQW5DQTtBQXNDQTs7QUFFQSxTQUFBLENBQUEsaUJBQUEsRUFBQSxxQkFBQSxDQUFBLElBQUEsQ0FBQSxHQUFBLENBQUEsQ0FBQTtBQUNBO0FBR0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7O0FBQ0EsU0FBQSw2QkFBQSxDQUFBLFdBQUEsRUFBQSxJQUFBLEVBQUEsbUJBQUEsRUFBQSxhQUFBLEVBQUE7QUFFQSxNQUFBLFNBQUEsSUFBQSxFQUFBO0FBQUEsV0FBQSxLQUFBO0FBQUE7O0FBRUEsTUFBQSxTQUFBLEdBQUEsd0JBQUEsQ0FBQSxJQUFBLENBQUEsQ0FKQSxDQUlBOztBQUNBLE1BQUEsYUFBQSxHQUFBLHlCQUFBLENBQUEsSUFBQSxDQUFBLENBTEEsQ0FLQTs7QUFDQSxNQUFBLFdBQUEsR0FBQSxnQkFBQSxPQUFBLG1CQUFBLENBQUEsYUFBQSxDQUFBLEdBQUEsbUJBQUEsQ0FBQSxhQUFBLENBQUEsR0FBQSxHQUFBLENBTkEsQ0FNQTtBQUVBOztBQUNBLE1BQUEsZ0JBQUEsR0FBQSxLQUFBLENBQUEsa0NBQUEsQ0FBQSxXQUFBLEVBQUEsYUFBQSxDQUFBLENBVEEsQ0FTQTs7O0FBRUEsTUFBQSxDQUFBLGdCQUFBLEVBQUE7QUFBQSxXQUFBLEtBQUE7QUFBQSxHQVhBLENBY0E7OztBQUNBLE1BQUEsWUFBQSxHQUFBLEVBQUE7O0FBQ0EsTUFBQSxnQkFBQSxDQUFBLFNBQUEsQ0FBQSxDQUFBLHNCQUFBLEVBQUEsTUFBQSxHQUFBLENBQUEsRUFBQTtBQUNBLElBQUEsWUFBQSxJQUFBLGdCQUFBLENBQUEsU0FBQSxDQUFBLENBQUEsc0JBQUEsQ0FBQTtBQUNBOztBQUNBLE1BQUEsZ0JBQUEsQ0FBQSxTQUFBLENBQUEsQ0FBQSxrQkFBQSxFQUFBLE1BQUEsR0FBQSxDQUFBLEVBQUE7QUFDQSxJQUFBLFlBQUEsSUFBQSxnQkFBQSxDQUFBLFNBQUEsQ0FBQSxDQUFBLGtCQUFBLENBQUE7QUFDQTs7QUFDQSxNQUFBLGdCQUFBLENBQUEsU0FBQSxDQUFBLENBQUEsZUFBQSxFQUFBLE1BQUEsR0FBQSxDQUFBLEVBQUE7QUFDQSxJQUFBLFlBQUEsSUFBQSxnQkFBQSxDQUFBLFNBQUEsQ0FBQSxDQUFBLGVBQUEsQ0FBQTtBQUNBOztBQUNBLE1BQUEsZ0JBQUEsQ0FBQSxTQUFBLENBQUEsQ0FBQSx5QkFBQSxFQUFBLE1BQUEsR0FBQSxDQUFBLEVBQUE7QUFDQSxJQUFBLFlBQUEsSUFBQSxnQkFBQSxDQUFBLFNBQUEsQ0FBQSxDQUFBLHlCQUFBLENBQUE7QUFDQTs7QUFDQSxFQUFBLHFDQUFBLENBQUEsWUFBQSxFQUFBLFdBQUEsRUFBQSxTQUFBLENBQUEsQ0E1QkEsQ0FnQ0E7O0FBQ0EsTUFBQSx3QkFBQSxHQUFBLE1BQUEsQ0FBQSxtQ0FBQSxXQUFBLENBQUEsQ0FBQSxNQUFBLEdBQUEsQ0FBQSxDQWpDQSxDQWlDQTs7QUFDQSxNQUFBLHFCQUFBLEdBQUEsTUFBQSxDQUFBLHNCQUFBLFdBQUEsQ0FBQSxDQUFBLE1BQUEsR0FBQSxDQUFBOztBQUVBLE1BQUEsd0JBQUEsSUFBQSxDQUFBLHFCQUFBLEVBQUE7QUFFQTtBQUNBO0FBQ0E7QUFFQSxJQUFBLHVDQUFBLENBQUEsV0FBQSxDQUFBLENBTkEsQ0FNQTs7QUFFQSxRQUFBLGVBQUEsR0FBQSwwQ0FBQSxXQUFBO0FBQ0EsSUFBQSxNQUFBLENBQUEsZUFBQSxHQUFBLHdCQUFBLEdBQ0EsZUFEQSxHQUNBLHdCQURBLENBQUEsQ0FDQSxHQURBLENBQ0EsUUFEQSxFQUNBLFNBREEsRUFUQSxDQVVBOztBQUNBLFdBQUEsS0FBQTtBQUNBLEdBaERBLENBb0RBOzs7QUFDQSxNQUNBLFFBQUEsQ0FBQSxJQUFBLENBQUEsT0FBQSxDQUFBLFdBQUEsS0FBQSxDQUFBLENBQUEsSUFDQSxRQUFBLENBQUEsSUFBQSxDQUFBLE9BQUEsQ0FBQSxlQUFBLElBQUEsQ0FEQSxJQUVBLFFBQUEsQ0FBQSxJQUFBLENBQUEsT0FBQSxDQUFBLHdCQUFBLElBQUEsQ0FGQSxJQUdBLFFBQUEsQ0FBQSxJQUFBLENBQUEsT0FBQSxDQUFBLG9CQUFBLElBQUEsQ0FBQSxJQUNBLFFBQUEsQ0FBQSxJQUFBLENBQUEsT0FBQSxDQUFBLFdBQUEsSUFBQSxDQUxBLEVBT0E7QUFDQTtBQUVBLFFBQUEsY0FBQSxPQUFBLHFDQUFBLEVBQUE7QUFDQSxNQUFBLHFDQUFBLENBQUEsYUFBQSxFQUFBLElBQUEsRUFBQSxXQUFBLENBQUE7QUFDQTtBQUNBO0FBRUE7QUFHQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7O0FBQ0EsU0FBQSw4QkFBQSxDQUFBLElBQUEsRUFBQSxtQkFBQSxFQUFBLGFBQUEsRUFBQTtBQUVBLE1BQUEsV0FBQSxHQUFBLGdCQUFBLE9BQUEsbUJBQUEsQ0FBQSxhQUFBLENBQUEsR0FBQSxtQkFBQSxDQUFBLGFBQUEsQ0FBQSxHQUFBLEdBQUEsQ0FGQSxDQUVBO0FBRUE7O0FBQ0EsTUFBQSx3QkFBQSxHQUFBLE1BQUEsQ0FBQSxtQ0FBQSxXQUFBLENBQUEsQ0FBQSxNQUFBLEdBQUEsQ0FBQSxDQUxBLENBS0E7O0FBQ0EsTUFBQSxxQkFBQSxHQUFBLE1BQUEsQ0FBQSxzQkFBQSxXQUFBLENBQUEsQ0FBQSxNQUFBLEdBQUEsQ0FBQTs7QUFDQSxNQUFBLHdCQUFBLElBQUEsQ0FBQSxxQkFBQSxFQUFBO0FBQ0EsSUFBQSxpQ0FBQSxDQUFBLFdBQUEsQ0FBQSxDQURBLENBQ0E7O0FBQ0EsSUFBQSxNQUFBLENBQUEsNkNBQUEsQ0FBQSxDQUFBLE1BQUEsR0FGQSxDQUVBOztBQUNBLFdBQUEsS0FBQTtBQUNBOztBQUVBLEVBQUEsTUFBQSxDQUFBLGtCQUFBLFdBQUEsQ0FBQSxDQUFBLEdBQUEsQ0FBQSxJQUFBLEVBYkEsQ0FhQTs7QUFHQSxNQUFBLGVBQUEsT0FBQSxrQ0FBQSxFQUFBO0FBQUEsSUFBQSxrQ0FBQSxDQUFBLElBQUEsRUFBQSxXQUFBLENBQUE7QUFBQTs7QUFFQSxFQUFBLHdDQUFBLENBQUEsV0FBQSxDQUFBLENBbEJBLENBb0JBOztBQUNBLE1BQUEsbUJBQUEsR0FBQSxJQUFBLENBckJBLENBcUJBOztBQUNBLE1BQUEsc0JBQUEsR0FBQSxvQ0FBQSxDQUFBLFdBQUEsQ0FBQSxDQXRCQSxDQXNCQTs7QUFDQSxFQUFBLE1BQUEsQ0FBQSxtQkFBQSxDQUFBLENBQUEsT0FBQSxDQUFBLGVBQUEsRUFBQSxDQUFBLFdBQUEsRUFBQSxtQkFBQSxFQUFBLHNCQUFBLENBQUE7QUFDQTtBQUdBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQSxTQUFBLHdDQUFBLENBQUEsV0FBQSxFQUFBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxNQUFBLG1CQUFBLEdBQUEsOENBQUEsQ0FBQSxXQUFBLENBQUEsQ0FsQkEsQ0FvQkE7O0FBQ0EsTUFBQSxrQkFBQSxHQUFBLG9DQUFBLENBQUEsV0FBQSxDQUFBLENBckJBLENBdUJBOztBQUNBLE1BQUEsbUJBQUEsR0FBQSxjQUFBLENBQUEsS0FBQSxDQUFBLHdCQUFBLENBQUEsV0FBQSxFQUFBLDRCQUFBLENBQUEsQ0FBQTtBQUVBLE1BQUEsUUFBQTtBQUNBLE1BQUEsaUJBQUE7QUFDQSxNQUFBLGNBQUE7QUFDQSxNQUFBLGVBQUE7QUFDQSxNQUFBLFlBQUE7QUFDQSxNQUFBLFdBQUEsQ0EvQkEsQ0FpQ0E7O0FBQ0EsT0FBQSxJQUFBLFNBQUEsSUFBQSxtQkFBQSxFQUFBO0FBRUEsSUFBQSxtQkFBQSxDQUFBLFNBQUEsQ0FBQSxDQUFBLFFBQUEsR0FBQSxDQUFBLENBRkEsQ0FFQTs7QUFFQSxJQUFBLGVBQUEsR0FBQSxtQkFBQSxDQUFBLFNBQUEsQ0FBQSxDQUpBLENBSUE7QUFFQTs7QUFDQSxTQUFBLElBQUEsQ0FBQSxHQUFBLENBQUEsRUFBQSxDQUFBLEdBQUEsa0JBQUEsQ0FBQSxNQUFBLEVBQUEsQ0FBQSxFQUFBLEVBQUE7QUFFQTtBQUNBLFVBQ0EsVUFBQSxLQUFBLENBQUEseUJBQUEsQ0FBQSxXQUFBLEVBQUEsd0JBQUEsQ0FBQSxJQUNBLGtCQUFBLENBQUEsTUFBQSxHQUFBLENBRkEsRUFHQTtBQUNBO0FBQ0E7QUFFQSxZQUFBLEtBQUEsQ0FBQSxJQUFBLGVBQUEsQ0FBQSxNQUFBLENBQUEsQ0FBQSxPQUFBLENBQUEsU0FBQSxLQUFBLENBQUEsRUFBQTtBQUNBO0FBQ0E7O0FBQ0EsWUFBQSxrQkFBQSxDQUFBLE1BQUEsR0FBQSxDQUFBLElBQUEsQ0FBQSxJQUFBLGVBQUEsQ0FBQSxNQUFBLENBQUEsQ0FBQSxPQUFBLENBQUEsV0FBQSxLQUFBLENBQUEsRUFBQTtBQUNBO0FBQ0E7QUFDQSxPQWhCQSxDQWtCQTs7O0FBQ0EsTUFBQSxRQUFBLEdBQUEsa0JBQUEsQ0FBQSxDQUFBLENBQUE7QUFHQSxVQUFBLDhCQUFBLEdBQUEsQ0FBQSxDQXRCQSxDQXVCQTs7QUFDQSxXQUFBLElBQUEsT0FBQSxJQUFBLG1CQUFBLEVBQUE7QUFFQSxRQUFBLGlCQUFBLEdBQUEsbUJBQUEsQ0FBQSxPQUFBLENBQUEsQ0FGQSxDQUlBO0FBQ0E7O0FBRUEsWUFBQSxVQUFBLEtBQUEsQ0FBQSxrQ0FBQSxDQUFBLFdBQUEsRUFBQSxRQUFBLENBQUEsRUFBQTtBQUNBLFVBQUEsY0FBQSxHQUFBLEtBQUEsQ0FBQSxrQ0FBQSxDQUFBLFdBQUEsRUFBQSxRQUFBLEVBQUEsaUJBQUEsRUFBQSxpQkFBQSxDQUFBLGNBQUEsQ0FEQSxDQUNBO0FBQ0EsU0FGQSxNQUVBO0FBQ0EsVUFBQSxjQUFBLEdBQUEsRUFBQTtBQUNBOztBQUNBLFlBQUEsZUFBQSxDQUFBLGdCQUFBLENBQUEsTUFBQSxHQUFBLENBQUEsRUFBQTtBQUNBLFVBQUEsWUFBQSxHQUFBLHNDQUFBLENBQUEsQ0FDQSxDQUNBLFFBQUEsQ0FBQSxlQUFBLENBQUEsZ0JBQUEsQ0FBQSxDQUFBLENBQUEsQ0FBQSxHQUFBLEVBREEsRUFFQSxRQUFBLENBQUEsZUFBQSxDQUFBLGdCQUFBLENBQUEsQ0FBQSxDQUFBLENBQUEsR0FBQSxFQUZBLENBREEsQ0FBQSxFQU1BLGNBTkEsQ0FBQTtBQU9BLFNBUkEsTUFRQTtBQUNBLFVBQUEsV0FBQSxHQUFBLENBQUEsQ0FBQSxLQUFBLGVBQUEsQ0FBQSxJQUFBLENBQUEsT0FBQSxDQUFBLE9BQUEsQ0FBQTtBQUNBLFVBQUEsWUFBQSxHQUFBLG9DQUFBLENBQ0EsV0FBQSxHQUNBLFFBQUEsQ0FBQSxlQUFBLENBQUEsZ0JBQUEsQ0FBQSxHQUFBLEVBREEsR0FFQSxRQUFBLENBQUEsZUFBQSxDQUFBLGdCQUFBLENBQUEsR0FBQSxFQUhBLEVBS0EsY0FMQSxDQUFBO0FBTUE7O0FBQ0EsWUFBQSxZQUFBLEVBQUE7QUFDQSxVQUFBLDhCQUFBLEdBREEsQ0FDQTtBQUNBO0FBRUE7O0FBRUEsVUFBQSxtQkFBQSxDQUFBLE1BQUEsSUFBQSw4QkFBQSxFQUFBO0FBQ0E7QUFFQSxRQUFBLG1CQUFBLENBQUEsU0FBQSxDQUFBLENBQUEsUUFBQSxHQUFBLENBQUE7QUFDQSxjQUpBLENBSUE7QUFDQTtBQUNBO0FBQ0EsR0EzR0EsQ0E4R0E7OztBQUNBLEVBQUEsNENBQUEsQ0FBQSxtQkFBQSxDQUFBO0FBRUEsRUFBQSxNQUFBLENBQUEsbUJBQUEsQ0FBQSxDQUFBLE9BQUEsQ0FBQSw4QkFBQSxFQUFBLENBQUEsV0FBQSxFQUFBLGtCQUFBLENBQUEsRUFqSEEsQ0FpSEE7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQSxTQUFBLG9DQUFBLENBQUEsTUFBQSxFQUFBLGVBQUEsRUFBQTtBQUVBLE9BQUEsSUFBQSxDQUFBLEdBQUEsQ0FBQSxFQUFBLENBQUEsR0FBQSxlQUFBLENBQUEsTUFBQSxFQUFBLENBQUEsRUFBQSxFQUFBO0FBRUEsUUFBQSxRQUFBLENBQUEsTUFBQSxDQUFBLEdBQUEsUUFBQSxDQUFBLGVBQUEsQ0FBQSxDQUFBLENBQUEsQ0FBQSxDQUFBLENBQUEsQ0FBQSxJQUFBLFFBQUEsQ0FBQSxNQUFBLENBQUEsR0FBQSxRQUFBLENBQUEsZUFBQSxDQUFBLENBQUEsQ0FBQSxDQUFBLENBQUEsQ0FBQSxDQUFBLEVBQUE7QUFDQSxhQUFBLElBQUE7QUFDQSxLQUpBLENBTUE7QUFDQTtBQUNBOztBQUNBOztBQUVBLFNBQUEsS0FBQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7OztBQUNBLFNBQUEsc0NBQUEsQ0FBQSxlQUFBLEVBQUEsZUFBQSxFQUFBO0FBRUEsTUFBQSxZQUFBOztBQUVBLE9BQUEsSUFBQSxDQUFBLEdBQUEsQ0FBQSxFQUFBLENBQUEsR0FBQSxlQUFBLENBQUEsTUFBQSxFQUFBLENBQUEsRUFBQSxFQUFBO0FBRUEsU0FBQSxJQUFBLENBQUEsR0FBQSxDQUFBLEVBQUEsQ0FBQSxHQUFBLGVBQUEsQ0FBQSxNQUFBLEVBQUEsQ0FBQSxFQUFBLEVBQUE7QUFFQSxNQUFBLFlBQUEsR0FBQSw4QkFBQSxDQUFBLGVBQUEsQ0FBQSxDQUFBLENBQUEsRUFBQSxlQUFBLENBQUEsQ0FBQSxDQUFBLENBQUE7O0FBRUEsVUFBQSxZQUFBLEVBQUE7QUFDQSxlQUFBLElBQUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUEsU0FBQSxLQUFBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQSxTQUFBLDhDQUFBLENBQUEsV0FBQSxFQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxNQUFBLGVBQUEsR0FBQSxDQUNBLDJCQUFBLFdBQUEsR0FBQSxJQURBLEVBRUEsMkJBQUEsV0FBQSxHQUFBLE1BRkEsRUFHQSwyQkFBQSxXQUFBLEdBQUEsSUFIQSxFQUlBLDJCQUFBLFdBQUEsR0FBQSxNQUpBLEVBS0EseUJBQUEsV0FBQSxHQUFBLElBTEEsRUFNQSx5QkFBQSxXQUFBLEdBQUEsTUFOQSxDQUFBO0FBU0EsTUFBQSxtQkFBQSxHQUFBLEVBQUEsQ0FkQSxDQWdCQTs7QUFDQSxPQUFBLElBQUEsR0FBQSxHQUFBLENBQUEsRUFBQSxHQUFBLEdBQUEsZUFBQSxDQUFBLE1BQUEsRUFBQSxHQUFBLEVBQUEsRUFBQTtBQUVBLFFBQUEsVUFBQSxHQUFBLGVBQUEsQ0FBQSxHQUFBLENBQUE7QUFDQSxRQUFBLFdBQUEsR0FBQSxNQUFBLENBQUEsVUFBQSxHQUFBLFNBQUEsQ0FBQSxDQUhBLENBS0E7O0FBQ0EsU0FBQSxJQUFBLENBQUEsR0FBQSxDQUFBLEVBQUEsQ0FBQSxHQUFBLFdBQUEsQ0FBQSxNQUFBLEVBQUEsQ0FBQSxFQUFBLEVBQUE7QUFFQSxVQUFBLGFBQUEsR0FBQSxNQUFBLENBQUEsVUFBQSxHQUFBLGFBQUEsR0FBQSxDQUFBLEdBQUEsR0FBQSxDQUFBO0FBQ0EsVUFBQSx3QkFBQSxHQUFBLGFBQUEsQ0FBQSxHQUFBLEdBQUEsS0FBQSxDQUFBLEdBQUEsQ0FBQTtBQUNBLFVBQUEsZ0JBQUEsR0FBQSxFQUFBLENBSkEsQ0FNQTs7QUFDQSxVQUFBLHdCQUFBLENBQUEsTUFBQSxFQUFBO0FBQUE7QUFDQSxhQUFBLElBQUEsQ0FBQSxHQUFBLENBQUEsRUFBQSxDQUFBLEdBQUEsd0JBQUEsQ0FBQSxNQUFBLEVBQUEsQ0FBQSxFQUFBLEVBQUE7QUFBQTtBQUNBO0FBRUEsY0FBQSxtQkFBQSxHQUFBLHdCQUFBLENBQUEsQ0FBQSxDQUFBLENBQUEsSUFBQSxHQUFBLEtBQUEsQ0FBQSxHQUFBLENBQUE7QUFFQSxjQUFBLGVBQUEsR0FBQSxRQUFBLENBQUEsbUJBQUEsQ0FBQSxDQUFBLENBQUEsQ0FBQSxHQUFBLEVBQUEsR0FBQSxFQUFBLEdBQUEsUUFBQSxDQUFBLG1CQUFBLENBQUEsQ0FBQSxDQUFBLENBQUEsR0FBQSxFQUFBO0FBRUEsVUFBQSxnQkFBQSxDQUFBLElBQUEsQ0FBQSxlQUFBO0FBQ0E7QUFDQTs7QUFFQSxNQUFBLG1CQUFBLENBQUEsSUFBQSxDQUFBO0FBQ0EsZ0JBQUEsTUFBQSxDQUFBLFVBQUEsQ0FBQSxDQUFBLElBQUEsQ0FBQSxNQUFBLENBREE7QUFFQSw0QkFBQSxhQUFBLENBQUEsR0FBQSxFQUZBO0FBR0EseUJBQUEsYUFIQTtBQUlBLDRCQUFBO0FBSkEsT0FBQTtBQU1BO0FBQ0E7O0FBRUEsU0FBQSxtQkFBQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQSxTQUFBLDRDQUFBLENBQUEsbUJBQUEsRUFBQTtBQUVBLE1BQUEsYUFBQTs7QUFFQSxPQUFBLElBQUEsQ0FBQSxHQUFBLENBQUEsRUFBQSxDQUFBLEdBQUEsbUJBQUEsQ0FBQSxNQUFBLEVBQUEsQ0FBQSxFQUFBLEVBQUE7QUFFQSxRQUFBLGFBQUEsR0FBQSxtQkFBQSxDQUFBLENBQUEsQ0FBQSxDQUFBLGFBQUE7O0FBRUEsUUFBQSxLQUFBLG1CQUFBLENBQUEsQ0FBQSxDQUFBLENBQUEsUUFBQSxFQUFBO0FBQ0EsTUFBQSxhQUFBLENBQUEsSUFBQSxDQUFBLFVBQUEsRUFBQSxJQUFBLEVBREEsQ0FDQTs7QUFDQSxNQUFBLGFBQUEsQ0FBQSxRQUFBLENBQUEsUUFBQSxFQUZBLENBRUE7QUFFQTs7QUFDQSxVQUFBLGFBQUEsQ0FBQSxJQUFBLENBQUEsVUFBQSxDQUFBLEVBQUE7QUFDQSxRQUFBLGFBQUEsQ0FBQSxJQUFBLENBQUEsVUFBQSxFQUFBLEtBQUE7QUFFQSxRQUFBLGFBQUEsQ0FBQSxNQUFBLEdBQUEsSUFBQSxDQUFBLDhCQUFBLEVBQUEsSUFBQSxDQUFBLFVBQUEsRUFBQSxJQUFBLEVBQUEsT0FBQSxDQUFBLFFBQUE7QUFDQTtBQUVBLEtBWEEsTUFXQTtBQUNBLE1BQUEsYUFBQSxDQUFBLElBQUEsQ0FBQSxVQUFBLEVBQUEsS0FBQSxFQURBLENBQ0E7O0FBQ0EsTUFBQSxhQUFBLENBQUEsV0FBQSxDQUFBLFFBQUEsRUFGQSxDQUVBO0FBQ0E7QUFDQTtBQUVBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQSxTQUFBLHNDQUFBLENBQUEsdUJBQUEsRUFBQTtBQUVBLE1BQ0EsdUJBQUEsQ0FBQSxNQUFBLEdBQUEsQ0FBQSxJQUNBLFFBQUEsQ0FBQSx1QkFBQSxDQUFBLENBQUEsQ0FBQSxDQUFBLEdBQUEsRUFEQSxJQUVBLFFBQUEsQ0FBQSx1QkFBQSxDQUFBLENBQUEsQ0FBQSxDQUFBLEdBQUEsS0FBQSxFQUFBLEdBQUEsRUFBQSxHQUFBLEVBSEEsRUFJQTtBQUNBLFdBQUEsSUFBQTtBQUNBOztBQUVBLFNBQUEsS0FBQTtBQUNBLEMsQ0FHQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQSxTQUFBLG9DQUFBLENBQUEsV0FBQSxFQUFBO0FBRUEsTUFBQSxrQkFBQSxHQUFBLEVBQUE7QUFDQSxFQUFBLGtCQUFBLEdBQUEsTUFBQSxDQUFBLGtCQUFBLFdBQUEsQ0FBQSxDQUFBLEdBQUEsR0FBQSxLQUFBLENBQUEsR0FBQSxDQUFBOztBQUVBLE1BQUEsa0JBQUEsQ0FBQSxNQUFBLEVBQUE7QUFBQTtBQUNBLFNBQUEsSUFBQSxDQUFBLEdBQUEsQ0FBQSxFQUFBLENBQUEsR0FBQSxrQkFBQSxDQUFBLE1BQUEsRUFBQSxDQUFBLEVBQUEsRUFBQTtBQUFBO0FBQ0EsTUFBQSxrQkFBQSxDQUFBLENBQUEsQ0FBQSxHQUFBLGtCQUFBLENBQUEsQ0FBQSxDQUFBLENBQUEsSUFBQSxFQUFBO0FBQ0EsTUFBQSxrQkFBQSxDQUFBLENBQUEsQ0FBQSxHQUFBLGtCQUFBLENBQUEsQ0FBQSxDQUFBLENBQUEsS0FBQSxDQUFBLEdBQUEsQ0FBQTs7QUFDQSxVQUFBLGtCQUFBLENBQUEsQ0FBQSxDQUFBLENBQUEsTUFBQSxHQUFBLENBQUEsRUFBQTtBQUNBLFFBQUEsa0JBQUEsQ0FBQSxDQUFBLENBQUEsR0FBQSxrQkFBQSxDQUFBLENBQUEsQ0FBQSxDQUFBLENBQUEsSUFBQSxHQUFBLEdBQUEsa0JBQUEsQ0FBQSxDQUFBLENBQUEsQ0FBQSxDQUFBLENBQUEsR0FBQSxHQUFBLEdBQUEsa0JBQUEsQ0FBQSxDQUFBLENBQUEsQ0FBQSxDQUFBLENBQUE7QUFDQTtBQUNBO0FBQ0EsR0FiQSxDQWVBOzs7QUFDQSxFQUFBLGtCQUFBLEdBQUEsa0JBQUEsQ0FBQSxNQUFBLENBQUEsVUFBQSxDQUFBLEVBQUE7QUFBQSxXQUFBLFFBQUEsQ0FBQSxDQUFBLENBQUE7QUFBQSxHQUFBLENBQUE7QUFFQSxFQUFBLGtCQUFBLENBQUEsSUFBQTtBQUVBLFNBQUEsa0JBQUE7QUFDQTtBQUdBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7O0FBQ0EsU0FBQSx1REFBQSxDQUFBLFdBQUEsRUFBQTtBQUFBLE1BQUEscUJBQUEsdUVBQUEsSUFBQTs7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLE1BQUEsZUFBQSxHQUFBLENBQ0EsMkJBQUEsV0FBQSxHQUFBLElBREEsRUFFQSwyQkFBQSxXQUFBLEdBQUEsTUFGQSxFQUdBLDJCQUFBLFdBQUEsR0FBQSxJQUhBLEVBSUEsMkJBQUEsV0FBQSxHQUFBLE1BSkEsRUFLQSx5QkFBQSxXQUFBLEdBQUEsSUFMQSxFQU1BLHlCQUFBLFdBQUEsR0FBQSxNQU5BLEVBT0EsOEJBQUEsV0FBQSxHQUFBLElBUEEsRUFRQSw4QkFBQSxXQUFBLEdBQUEsTUFSQSxDQUFBO0FBV0EsTUFBQSxtQkFBQSxHQUFBLEVBQUEsQ0FoQkEsQ0FrQkE7O0FBQ0EsT0FBQSxJQUFBLEdBQUEsR0FBQSxDQUFBLEVBQUEsR0FBQSxHQUFBLGVBQUEsQ0FBQSxNQUFBLEVBQUEsR0FBQSxFQUFBLEVBQUE7QUFFQSxRQUFBLFVBQUEsR0FBQSxlQUFBLENBQUEsR0FBQSxDQUFBO0FBRUEsUUFBQSxXQUFBOztBQUNBLFFBQUEscUJBQUEsRUFBQTtBQUNBLE1BQUEsV0FBQSxHQUFBLE1BQUEsQ0FBQSxrQkFBQSxXQUFBLEdBQUEsR0FBQSxHQUFBLFVBQUEsR0FBQSxrQkFBQSxDQUFBLENBREEsQ0FDQTtBQUNBLEtBRkEsTUFFQTtBQUNBLE1BQUEsV0FBQSxHQUFBLE1BQUEsQ0FBQSxrQkFBQSxXQUFBLEdBQUEsR0FBQSxHQUFBLFVBQUEsR0FBQSxTQUFBLENBQUEsQ0FEQSxDQUNBO0FBQ0EsS0FUQSxDQVlBOzs7QUFDQSxTQUFBLElBQUEsQ0FBQSxHQUFBLENBQUEsRUFBQSxDQUFBLEdBQUEsV0FBQSxDQUFBLE1BQUEsRUFBQSxDQUFBLEVBQUEsRUFBQTtBQUVBLFVBQUEsYUFBQSxHQUFBLE1BQUEsQ0FBQSxXQUFBLENBQUEsQ0FBQSxDQUFBLENBQUEsQ0FGQSxDQUVBOztBQUNBLFVBQUEsd0JBQUEsR0FBQSxhQUFBLENBQUEsR0FBQSxHQUFBLEtBQUEsQ0FBQSxHQUFBLENBQUE7QUFDQSxVQUFBLGdCQUFBLEdBQUEsRUFBQSxDQUpBLENBTUE7O0FBQ0EsVUFBQSx3QkFBQSxDQUFBLE1BQUEsRUFBQTtBQUFBO0FBQ0EsYUFBQSxJQUFBLENBQUEsR0FBQSxDQUFBLEVBQUEsQ0FBQSxHQUFBLHdCQUFBLENBQUEsTUFBQSxFQUFBLENBQUEsRUFBQSxFQUFBO0FBQUE7QUFDQTtBQUVBLGNBQUEsbUJBQUEsR0FBQSx3QkFBQSxDQUFBLENBQUEsQ0FBQSxDQUFBLElBQUEsR0FBQSxLQUFBLENBQUEsR0FBQSxDQUFBO0FBRUEsY0FBQSxlQUFBLEdBQUEsUUFBQSxDQUFBLG1CQUFBLENBQUEsQ0FBQSxDQUFBLENBQUEsR0FBQSxFQUFBLEdBQUEsRUFBQSxHQUFBLFFBQUEsQ0FBQSxtQkFBQSxDQUFBLENBQUEsQ0FBQSxDQUFBLEdBQUEsRUFBQTtBQUVBLFVBQUEsZ0JBQUEsQ0FBQSxJQUFBLENBQUEsZUFBQTtBQUNBO0FBQ0E7O0FBRUEsTUFBQSxtQkFBQSxDQUFBLElBQUEsQ0FBQTtBQUNBLGdCQUFBLE1BQUEsQ0FBQSxrQkFBQSxXQUFBLEdBQUEsR0FBQSxHQUFBLFVBQUEsQ0FBQSxDQUFBLElBQUEsQ0FBQSxNQUFBLENBREE7QUFFQSw0QkFBQSxhQUFBLENBQUEsR0FBQSxFQUZBO0FBR0EseUJBQUEsYUFIQTtBQUlBLDRCQUFBO0FBSkEsT0FBQTtBQU1BO0FBQ0EsR0ExREEsQ0E0REE7OztBQUVBLE1BQUEsb0JBQUEsR0FBQSxDQUNBLDBCQUFBLFdBQUEsR0FBQSxJQURBLEVBRUEsd0JBQUEsV0FBQSxHQUFBLElBRkEsQ0FBQTs7QUFJQSxPQUFBLElBQUEsRUFBQSxHQUFBLENBQUEsRUFBQSxFQUFBLEdBQUEsb0JBQUEsQ0FBQSxNQUFBLEVBQUEsRUFBQSxFQUFBLEVBQUE7QUFFQSxRQUFBLFdBQUEsR0FBQSxNQUFBLENBQUEsa0JBQUEsV0FBQSxHQUFBLEdBQUEsR0FBQSxvQkFBQSxDQUFBLEVBQUEsQ0FBQSxDQUFBLENBRkEsQ0FFQTs7QUFDQSxRQUFBLFdBQUEsQ0FBQSxNQUFBLEdBQUEsQ0FBQSxFQUFBO0FBRUEsVUFBQSxjQUFBLEdBQUEsV0FBQSxDQUFBLEdBQUEsR0FBQSxJQUFBLEdBQUEsS0FBQSxDQUFBLEdBQUEsQ0FBQSxDQUZBLENBRUE7O0FBQ0EsVUFBQSxLQUFBLGNBQUEsQ0FBQSxNQUFBLEVBQUE7QUFDQSxpQkFEQSxDQUNBO0FBQ0E7O0FBQ0EsVUFBQSxLQUFBLGNBQUEsQ0FBQSxNQUFBLEVBQUE7QUFDQSxZQUFBLE9BQUEsY0FBQSxDQUFBLENBQUEsQ0FBQSxFQUFBO0FBQ0EsbUJBREEsQ0FDQTtBQUNBOztBQUNBLFFBQUEsY0FBQSxDQUFBLENBQUEsQ0FBQSxHQUFBLENBQUE7QUFDQTs7QUFDQSxVQUFBLG9CQUFBLEdBQUEsUUFBQSxDQUFBLGNBQUEsQ0FBQSxDQUFBLENBQUEsQ0FBQSxHQUFBLEVBQUEsR0FBQSxFQUFBLEdBQUEsUUFBQSxDQUFBLGNBQUEsQ0FBQSxDQUFBLENBQUEsQ0FBQSxHQUFBLEVBQUE7QUFFQSxVQUFBLHFCQUFBLEdBQUEsRUFBQTtBQUNBLE1BQUEscUJBQUEsQ0FBQSxJQUFBLENBQUEsb0JBQUE7QUFFQSxNQUFBLG1CQUFBLENBQUEsSUFBQSxDQUFBO0FBQ0EsZ0JBQUEsV0FBQSxDQUFBLElBQUEsQ0FBQSxNQUFBLENBREE7QUFFQSw0QkFBQSxXQUFBLENBQUEsR0FBQSxFQUZBO0FBR0EseUJBQUEsV0FIQTtBQUlBLDRCQUFBO0FBSkEsT0FBQTtBQU1BO0FBQ0E7O0FBRUEsU0FBQSxtQkFBQTtBQUNBLEMsQ0FJQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7O0FBQ0EsU0FBQSx1QkFBQSxDQUFBLFdBQUEsRUFBQTtBQUVBLE1BQUEsZ0JBQUEsT0FBQSxXQUFBLEVBQUE7QUFDQSxJQUFBLFdBQUEsR0FBQSxHQUFBO0FBQ0E7O0FBRUEsTUFBQSxNQUFBLENBQUEsc0JBQUEsV0FBQSxDQUFBLENBQUEsTUFBQSxHQUFBLENBQUEsRUFBQTtBQUNBLFdBQUEsTUFBQSxDQUFBLFFBQUEsQ0FBQSxRQUFBLENBQUEsTUFBQSxDQUFBLHNCQUFBLFdBQUEsQ0FBQSxDQUFBLEdBQUEsQ0FBQSxDQUFBLENBQUEsQ0FBQTtBQUNBOztBQUVBLFNBQUEsSUFBQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQSxTQUFBLGlDQUFBLENBQUEsV0FBQSxFQUFBO0FBRUEsTUFBQSxnQkFBQSxPQUFBLFdBQUEsRUFBQTtBQUNBLElBQUEsV0FBQSxHQUFBLEdBQUE7QUFDQTs7QUFFQSxNQUFBLElBQUEsR0FBQSx1QkFBQSxDQUFBLFdBQUEsQ0FBQTs7QUFFQSxNQUFBLFNBQUEsSUFBQSxFQUFBO0FBRUE7QUFDQSxJQUFBLE1BQUEsQ0FBQSxrQkFBQSxXQUFBLENBQUEsQ0FBQSxHQUFBLENBQUEsRUFBQSxFQUhBLENBR0E7O0FBQ0EsSUFBQSxJQUFBLENBQUEsUUFBQSxHQUFBLEtBQUE7QUFDQSxJQUFBLElBQUEsQ0FBQSxLQUFBLEdBQUEsRUFBQTs7QUFDQSxJQUFBLE1BQUEsQ0FBQSxRQUFBLENBQUEsZUFBQSxDQUFBLElBQUE7O0FBRUEsV0FBQSxJQUFBO0FBQ0E7O0FBRUEsU0FBQSxLQUFBO0FBRUE7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQSxTQUFBLHVDQUFBLENBQUEsV0FBQSxFQUFBO0FBRUEsTUFBQSxnQkFBQSxPQUFBLFdBQUEsRUFBQTtBQUVBLElBQUEsTUFBQSxDQUFBLHNCQUFBLFdBQUEsR0FBQSwyQkFBQSxDQUFBLENBQUEsV0FBQSxDQUFBLHlCQUFBLEVBRkEsQ0FFQTtBQUVBLEdBSkEsTUFJQTtBQUNBLElBQUEsTUFBQSxDQUFBLDBCQUFBLENBQUEsQ0FBQSxXQUFBLENBQUEseUJBQUEsRUFEQSxDQUNBO0FBQ0E7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7OztBQUNBLFNBQUEsd0JBQUEsQ0FBQSxXQUFBLEVBQUEsSUFBQSxFQUFBLEtBQUEsRUFBQTtBQUVBLE1BQUEsZ0JBQUEsT0FBQSxXQUFBLEVBQUE7QUFBQSxJQUFBLFdBQUEsR0FBQSxHQUFBO0FBQUE7O0FBQ0EsTUFBQSxJQUFBLEdBQUEsdUJBQUEsQ0FBQSxXQUFBLENBQUE7O0FBQ0EsTUFBQSxTQUFBLElBQUEsRUFBQTtBQUVBLElBQUEsSUFBQSxHQUFBLFFBQUEsQ0FBQSxJQUFBLENBQUE7QUFDQSxJQUFBLEtBQUEsR0FBQSxRQUFBLENBQUEsS0FBQSxDQUFBLEdBQUEsQ0FBQSxDQUhBLENBR0E7O0FBRUEsSUFBQSxJQUFBLENBQUEsVUFBQSxHQUFBLElBQUEsSUFBQSxFQUFBLENBTEEsQ0FNQTs7QUFDQSxJQUFBLElBQUEsQ0FBQSxVQUFBLENBQUEsV0FBQSxDQUFBLElBQUEsRUFBQSxLQUFBLEVBQUEsQ0FBQTtBQUNBLElBQUEsSUFBQSxDQUFBLFVBQUEsQ0FBQSxRQUFBLENBQUEsS0FBQTtBQUNBLElBQUEsSUFBQSxDQUFBLFVBQUEsQ0FBQSxPQUFBLENBQUEsQ0FBQTtBQUVBLElBQUEsSUFBQSxDQUFBLFNBQUEsR0FBQSxJQUFBLENBQUEsVUFBQSxDQUFBLFFBQUEsRUFBQTtBQUNBLElBQUEsSUFBQSxDQUFBLFFBQUEsR0FBQSxJQUFBLENBQUEsVUFBQSxDQUFBLFdBQUEsRUFBQTs7QUFFQSxJQUFBLE1BQUEsQ0FBQSxRQUFBLENBQUEsYUFBQSxDQUFBLElBQUE7O0FBQ0EsSUFBQSxNQUFBLENBQUEsUUFBQSxDQUFBLGVBQUEsQ0FBQSxJQUFBOztBQUNBLElBQUEsTUFBQSxDQUFBLFFBQUEsQ0FBQSxTQUFBLENBQUEsSUFBQTs7QUFDQSxJQUFBLE1BQUEsQ0FBQSxRQUFBLENBQUEsZUFBQSxDQUFBLElBQUE7O0FBRUEsV0FBQSxJQUFBO0FBQ0E7O0FBQ0EsU0FBQSxLQUFBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7O0FBQ0EsU0FBQSwyQkFBQSxDQUFBLFdBQUEsRUFBQSxhQUFBLEVBQUE7QUFFQTtBQUNBLE1BQUEsaUJBQUEsR0FBQSxLQUFBLENBQUEsa0NBQUEsQ0FBQSxXQUFBLEVBQUEsYUFBQSxDQUFBOztBQUVBLE1BQUEsaUJBQUEsR0FBQSxRQUFBLENBQUEsaUJBQUEsQ0FBQSxrQkFBQSxDQUFBLENBQUEsR0FBQSxDQUFBOztBQUVBLE1BQUEsT0FBQSxpQkFBQSxDQUFBLFNBQUEsQ0FBQSxLQUFBLFdBQUEsRUFBQTtBQUNBLFdBQUEsaUJBQUE7QUFDQTs7QUFFQSxNQUFBLGVBQUEsaUJBQUEsQ0FBQSxTQUFBLENBQUEsQ0FBQSxnQkFBQSxDQUFBLEVBQUE7QUFFQSxRQUFBLDhCQUFBLEdBQUEsS0FBQSxDQUFBLHlCQUFBLENBQUEsV0FBQSxFQUFBLHlCQUFBLENBQUEsQ0FGQSxDQUVBOzs7QUFFQSxZQUFBLGlCQUFBLENBQUEsU0FBQSxDQUFBLENBQUEscUJBQUEsQ0FBQTtBQUNBLFdBQUEsU0FBQSxDQURBLENBRUE7O0FBQ0EsV0FBQSxpQkFBQTtBQUNBLFdBQUEsa0JBQUE7QUFDQSxXQUFBLGtCQUFBO0FBQ0EsUUFBQSxpQkFBQSxHQUFBLGlCQUFBLEdBQUEsSUFBQSxHQUFBLDhCQUFBO0FBQ0E7O0FBQ0E7QUFSQTtBQVVBOztBQUVBLFNBQUEsaUJBQUE7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQSxTQUFBLG9DQUFBLENBQUEsZ0JBQUEsRUFBQSxZQUFBLEVBQUE7QUFFQSxPQUFBLElBQUEsVUFBQSxHQUFBLENBQUEsRUFBQSxVQUFBLEdBQUEsWUFBQSxDQUFBLE1BQUEsRUFBQSxVQUFBLEVBQUEsRUFBQTtBQUFBO0FBQ0EsUUFBQSxZQUFBLENBQUEsVUFBQSxDQUFBLENBQUEsV0FBQSxPQUFBLGdCQUFBLENBQUEsV0FBQSxFQUFBLElBQ0EsWUFBQSxDQUFBLFVBQUEsQ0FBQSxDQUFBLFFBQUEsT0FBQSxnQkFBQSxDQUFBLFFBQUEsRUFEQSxJQUVBLFlBQUEsQ0FBQSxVQUFBLENBQUEsQ0FBQSxPQUFBLE9BQUEsZ0JBQUEsQ0FBQSxPQUFBLEVBRkEsRUFFQTtBQUNBLGFBQUEsSUFBQTtBQUNBO0FBQ0E7O0FBRUEsU0FBQSxLQUFBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7OztBQUNBLFNBQUEseUJBQUEsQ0FBQSxJQUFBLEVBQUE7QUFFQSxNQUFBLGFBQUEsR0FBQSxJQUFBLENBQUEsV0FBQSxLQUFBLEdBQUE7QUFDQSxFQUFBLGFBQUEsSUFBQSxJQUFBLENBQUEsUUFBQSxLQUFBLENBQUEsR0FBQSxFQUFBLEdBQUEsR0FBQSxHQUFBLEVBQUE7QUFDQSxFQUFBLGFBQUEsSUFBQSxJQUFBLENBQUEsUUFBQSxLQUFBLENBQUEsR0FBQSxHQUFBO0FBQ0EsRUFBQSxhQUFBLElBQUEsSUFBQSxDQUFBLE9BQUEsS0FBQSxFQUFBLEdBQUEsR0FBQSxHQUFBLEVBQUE7QUFDQSxFQUFBLGFBQUEsSUFBQSxJQUFBLENBQUEsT0FBQSxFQUFBO0FBRUEsU0FBQSxhQUFBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQSxTQUFBLGtCQUFBLENBQUEsY0FBQSxFQUFBO0FBRUEsTUFBQSxrQkFBQSxHQUFBLGNBQUEsQ0FBQSxLQUFBLENBQUEsR0FBQSxDQUFBO0FBRUEsTUFBQSxPQUFBLEdBQUEsSUFBQSxJQUFBLEVBQUE7QUFFQSxFQUFBLE9BQUEsQ0FBQSxXQUFBLENBQUEsUUFBQSxDQUFBLGtCQUFBLENBQUEsQ0FBQSxDQUFBLENBQUEsRUFBQSxRQUFBLENBQUEsa0JBQUEsQ0FBQSxDQUFBLENBQUEsQ0FBQSxHQUFBLENBQUEsRUFBQSxRQUFBLENBQUEsa0JBQUEsQ0FBQSxDQUFBLENBQUEsQ0FBQSxFQU5BLENBTUE7QUFFQTs7QUFDQSxFQUFBLE9BQUEsQ0FBQSxRQUFBLENBQUEsQ0FBQTtBQUNBLEVBQUEsT0FBQSxDQUFBLFVBQUEsQ0FBQSxDQUFBO0FBQ0EsRUFBQSxPQUFBLENBQUEsVUFBQSxDQUFBLENBQUE7QUFDQSxFQUFBLE9BQUEsQ0FBQSxlQUFBLENBQUEsQ0FBQTtBQUVBLFNBQUEsT0FBQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQSxTQUFBLHdCQUFBLENBQUEsSUFBQSxFQUFBO0FBRUEsTUFBQSxZQUFBLEdBQUEsSUFBQSxDQUFBLFFBQUEsS0FBQSxDQUFBLEdBQUEsR0FBQSxHQUFBLElBQUEsQ0FBQSxPQUFBLEVBQUEsR0FBQSxHQUFBLEdBQUEsSUFBQSxDQUFBLFdBQUEsRUFBQSxDQUZBLENBRUE7O0FBRUEsU0FBQSxZQUFBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7O0FBQ0EsU0FBQSx3Q0FBQSxDQUFBLElBQUEsRUFBQSxTQUFBLEVBQUE7QUFFQSxFQUFBLFNBQUEsR0FBQSxnQkFBQSxPQUFBLFNBQUEsR0FBQSxTQUFBLEdBQUEsR0FBQTtBQUVBLE1BQUEsUUFBQSxHQUFBLElBQUEsQ0FBQSxLQUFBLENBQUEsU0FBQSxDQUFBO0FBQ0EsTUFBQSxRQUFBLEdBQUE7QUFDQSxZQUFBLFFBQUEsQ0FBQSxRQUFBLENBQUEsQ0FBQSxDQUFBLENBREE7QUFFQSxhQUFBLFFBQUEsQ0FBQSxRQUFBLENBQUEsQ0FBQSxDQUFBLENBQUEsR0FBQSxDQUZBO0FBR0EsWUFBQSxRQUFBLENBQUEsUUFBQSxDQUFBLENBQUEsQ0FBQTtBQUhBLEdBQUE7QUFLQSxTQUFBLFFBQUEsQ0FWQSxDQVVBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7O0FBQ0EsU0FBQSw2QkFBQSxDQUFBLFdBQUEsRUFBQTtBQUNBLE1BQUEsQ0FBQSxNQUFBLENBQUEsc0JBQUEsV0FBQSxDQUFBLENBQUEsSUFBQSxHQUFBLFFBQUEsQ0FBQSwyQkFBQSxDQUFBLEVBQUE7QUFDQSxJQUFBLE1BQUEsQ0FBQSxzQkFBQSxXQUFBLENBQUEsQ0FBQSxLQUFBLENBQUEsb0ZBQUE7QUFDQTs7QUFDQSxNQUFBLENBQUEsTUFBQSxDQUFBLHNCQUFBLFdBQUEsQ0FBQSxDQUFBLFFBQUEsQ0FBQSwwQkFBQSxDQUFBLEVBQUE7QUFDQSxJQUFBLE1BQUEsQ0FBQSxzQkFBQSxXQUFBLENBQUEsQ0FBQSxRQUFBLENBQUEsMEJBQUE7QUFDQTs7QUFDQSxFQUFBLDBCQUFBLENBQUEsV0FBQSxDQUFBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7O0FBQ0EsU0FBQSw0QkFBQSxDQUFBLFdBQUEsRUFBQTtBQUNBLEVBQUEsTUFBQSxDQUFBLHNCQUFBLFdBQUEsR0FBQSwrQkFBQSxDQUFBLENBQUEsTUFBQTtBQUNBLEVBQUEsTUFBQSxDQUFBLHNCQUFBLFdBQUEsQ0FBQSxDQUFBLFdBQUEsQ0FBQSwwQkFBQTtBQUNBLEVBQUEseUJBQUEsQ0FBQSxXQUFBLENBQUE7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQSxTQUFBLDBCQUFBLENBQUEsV0FBQSxFQUFBO0FBQ0EsTUFBQSxDQUFBLE1BQUEsQ0FBQSxzQkFBQSxXQUFBLENBQUEsQ0FBQSxRQUFBLENBQUEsb0JBQUEsQ0FBQSxFQUFBO0FBQ0EsSUFBQSxNQUFBLENBQUEsc0JBQUEsV0FBQSxDQUFBLENBQUEsUUFBQSxDQUFBLG9CQUFBO0FBQ0E7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQSxTQUFBLHlCQUFBLENBQUEsV0FBQSxFQUFBO0FBQ0EsRUFBQSxNQUFBLENBQUEsc0JBQUEsV0FBQSxDQUFBLENBQUEsV0FBQSxDQUFBLG9CQUFBO0FBQ0E7QUFLQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQSxTQUFBLDBCQUFBLENBQUEsV0FBQSxFQUFBO0FBRUEsTUFBQSxJQUFBLEdBQUEsdUJBQUEsQ0FBQSxXQUFBLENBQUE7O0FBRUEsRUFBQSxNQUFBLENBQUEsUUFBQSxDQUFBLGVBQUEsQ0FBQSxJQUFBO0FBQ0EsQyxDQUdBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQSxTQUFBLGdDQUFBLENBQUEsU0FBQSxFQUFBO0FBRUEsTUFBQSxDQUFBLFNBQUEsSUFBQSxTQUFBLENBQUEsTUFBQSxLQUFBLENBQUEsRUFBQTtBQUNBLFdBQUEsRUFBQTtBQUNBOztBQUVBLE1BQUEsTUFBQSxHQUFBLEVBQUE7QUFDQSxFQUFBLFNBQUEsQ0FBQSxJQUFBLENBQUEsVUFBQSxDQUFBLEVBQUEsQ0FBQSxFQUFBO0FBQ0EsV0FBQSxDQUFBLENBQUEsQ0FBQSxDQUFBLEdBQUEsQ0FBQSxDQUFBLENBQUEsQ0FBQTtBQUNBLEdBRkE7QUFJQSxNQUFBLGNBQUEsR0FBQSxTQUFBLENBQUEsQ0FBQSxDQUFBOztBQUVBLE9BQUEsSUFBQSxDQUFBLEdBQUEsQ0FBQSxFQUFBLENBQUEsR0FBQSxTQUFBLENBQUEsTUFBQSxFQUFBLENBQUEsRUFBQSxFQUFBO0FBQ0EsUUFBQSxRQUFBLEdBQUEsU0FBQSxDQUFBLENBQUEsQ0FBQTs7QUFFQSxRQUFBLFFBQUEsQ0FBQSxDQUFBLENBQUEsSUFBQSxjQUFBLENBQUEsQ0FBQSxDQUFBLEVBQUE7QUFDQSxNQUFBLGNBQUEsQ0FBQSxDQUFBLENBQUEsR0FBQSxJQUFBLENBQUEsR0FBQSxDQUFBLGNBQUEsQ0FBQSxDQUFBLENBQUEsRUFBQSxRQUFBLENBQUEsQ0FBQSxDQUFBLENBQUE7QUFDQSxLQUZBLE1BRUE7QUFDQSxNQUFBLE1BQUEsQ0FBQSxJQUFBLENBQUEsY0FBQTtBQUNBLE1BQUEsY0FBQSxHQUFBLFFBQUE7QUFDQTtBQUNBOztBQUVBLEVBQUEsTUFBQSxDQUFBLElBQUEsQ0FBQSxjQUFBO0FBQ0EsU0FBQSxNQUFBO0FBQ0E7QUFHQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7O0FBQ0EsU0FBQSw4QkFBQSxDQUFBLFVBQUEsRUFBQSxVQUFBLEVBQUE7QUFFQSxNQUNBLEtBQUEsVUFBQSxDQUFBLE1BQUEsSUFDQSxLQUFBLFVBQUEsQ0FBQSxNQUZBLEVBR0E7QUFDQSxXQUFBLEtBQUE7QUFDQTs7QUFFQSxFQUFBLFVBQUEsQ0FBQSxDQUFBLENBQUEsR0FBQSxRQUFBLENBQUEsVUFBQSxDQUFBLENBQUEsQ0FBQSxDQUFBO0FBQ0EsRUFBQSxVQUFBLENBQUEsQ0FBQSxDQUFBLEdBQUEsUUFBQSxDQUFBLFVBQUEsQ0FBQSxDQUFBLENBQUEsQ0FBQTtBQUNBLEVBQUEsVUFBQSxDQUFBLENBQUEsQ0FBQSxHQUFBLFFBQUEsQ0FBQSxVQUFBLENBQUEsQ0FBQSxDQUFBLENBQUE7QUFDQSxFQUFBLFVBQUEsQ0FBQSxDQUFBLENBQUEsR0FBQSxRQUFBLENBQUEsVUFBQSxDQUFBLENBQUEsQ0FBQSxDQUFBO0FBRUEsTUFBQSxjQUFBLEdBQUEsSUFBQSxDQUFBLEdBQUEsQ0FBQSxVQUFBLENBQUEsQ0FBQSxDQUFBLEVBQUEsVUFBQSxDQUFBLENBQUEsQ0FBQSxJQUFBLElBQUEsQ0FBQSxHQUFBLENBQUEsVUFBQSxDQUFBLENBQUEsQ0FBQSxFQUFBLFVBQUEsQ0FBQSxDQUFBLENBQUEsQ0FBQSxDQWRBLENBZ0JBO0FBQ0E7QUFDQTs7QUFFQSxNQUFBLGNBQUEsR0FBQSxDQUFBLEVBQUE7QUFDQSxXQUFBLElBQUEsQ0FEQSxDQUNBO0FBQ0E7O0FBRUEsU0FBQSxLQUFBLENBeEJBLENBd0JBO0FBQ0E7QUFHQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7O0FBQ0EsU0FBQSxpQ0FBQSxDQUFBLE9BQUEsRUFBQSxPQUFBLEVBQUE7QUFFQSxNQUFBLE9BQUEsQ0FBQSxNQUFBLElBQUEsQ0FBQSxFQUFBO0FBQUE7QUFDQSxXQUFBLE9BQUE7QUFDQTs7QUFFQSxNQUFBLEdBQUEsR0FBQSxPQUFBLENBQUEsQ0FBQSxDQUFBO0FBQ0EsTUFBQSxJQUFBLEdBQUEsSUFBQSxDQUFBLEdBQUEsQ0FBQSxPQUFBLEdBQUEsR0FBQSxDQUFBLENBUEEsQ0FPQTs7QUFDQSxNQUFBLFdBQUEsR0FBQSxPQUFBLENBQUEsQ0FBQSxDQUFBLENBUkEsQ0FRQTs7QUFFQSxPQUFBLElBQUEsQ0FBQSxHQUFBLENBQUEsRUFBQSxDQUFBLEdBQUEsT0FBQSxDQUFBLE1BQUEsRUFBQSxDQUFBLEVBQUEsRUFBQTtBQUNBLElBQUEsR0FBQSxHQUFBLE9BQUEsQ0FBQSxDQUFBLENBQUE7O0FBRUEsUUFBQSxJQUFBLENBQUEsR0FBQSxDQUFBLE9BQUEsR0FBQSxHQUFBLElBQUEsSUFBQSxFQUFBO0FBQUE7QUFDQSxNQUFBLElBQUEsR0FBQSxJQUFBLENBQUEsR0FBQSxDQUFBLE9BQUEsR0FBQSxHQUFBLENBQUE7QUFDQSxNQUFBLFdBQUEsR0FBQSxHQUFBO0FBQ0E7QUFDQTs7QUFFQSxTQUFBLFdBQUE7QUFDQSxDLENBR0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7OztBQUNBLFNBQUEscUNBQUEsQ0FBQSxZQUFBLEVBQUEsV0FBQSxFQUFBLFFBQUEsRUFBQTtBQUVBO0FBRUEsRUFBQSxNQUFBLENBQUEsc0JBQUEsV0FBQSxHQUFBLGVBQUEsR0FBQSxRQUFBLENBQUEsQ0FBQSxJQUFBLENBQUEsY0FBQSxFQUFBLFlBQUE7QUFFQSxNQUFBLEtBQUEsR0FBQSxNQUFBLENBQUEsc0JBQUEsV0FBQSxHQUFBLGVBQUEsR0FBQSxRQUFBLENBQUEsQ0FBQSxHQUFBLENBQUEsQ0FBQSxDQUFBLENBTkEsQ0FNQTs7QUFFQSxNQUNBLGdCQUFBLE9BQUEsS0FBQSxJQUNBLFNBQUEsSUFBQSxLQUFBLENBQUEsTUFEQSxJQUVBLE9BQUEsWUFIQSxFQUlBO0FBRUEsSUFBQSxVQUFBLENBQUEsS0FBQSxFQUFBO0FBQ0EsTUFBQSxPQURBLG1CQUNBLFNBREEsRUFDQTtBQUVBLFlBQUEsZUFBQSxHQUFBLFNBQUEsQ0FBQSxZQUFBLENBQUEsY0FBQSxDQUFBO0FBRUEsZUFBQSx3Q0FDQSwrQkFEQSxHQUVBLGVBRkEsR0FHQSxRQUhBLEdBSUEsUUFKQTtBQUtBLE9BVkE7QUFXQSxNQUFBLFNBQUEsRUFBQSxJQVhBO0FBWUEsTUFBQSxPQUFBLEVBQUEsa0JBWkE7QUFhQSxNQUFBLFdBQUEsRUFBQSxLQWJBO0FBY0EsTUFBQSxXQUFBLEVBQUEsSUFkQTtBQWVBLE1BQUEsaUJBQUEsRUFBQSxFQWZBO0FBZ0JBLE1BQUEsUUFBQSxFQUFBLEdBaEJBO0FBaUJBLE1BQUEsS0FBQSxFQUFBLGtCQWpCQTtBQWtCQSxNQUFBLFNBQUEsRUFBQSxLQWxCQTtBQW1CQSxNQUFBLEtBQUEsRUFBQSxDQUFBLEdBQUEsRUFBQSxDQUFBLENBbkJBO0FBbUJBO0FBQ0E7QUFDQSxNQUFBLGdCQUFBLEVBQUEsSUFyQkE7QUFzQkEsTUFBQSxLQUFBLEVBQUEsSUF0QkE7QUFzQkE7QUFDQSxNQUFBLFFBQUEsRUFBQTtBQUFBLGVBQUEsUUFBQSxDQUFBLElBQUE7QUFBQTtBQXZCQSxLQUFBLENBQUE7QUEwQkEsV0FBQSxJQUFBO0FBQ0E7O0FBRUEsU0FBQSxLQUFBO0FBQ0EsQyxDQUdBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7O0FBQ0EsU0FBQSx3QkFBQSxDQUFBLEtBQUEsRUFBQSxLQUFBLEVBQUE7QUFFQTtBQUNBLE1BQUEsT0FBQSxHQUFBLE9BQUEsRUFBQSxHQUFBLEVBQUEsR0FBQSxFQUFBLENBSEEsQ0FLQTs7QUFDQSxNQUFBLFFBQUEsR0FBQSxLQUFBLENBQUEsT0FBQSxFQUFBO0FBQ0EsTUFBQSxRQUFBLEdBQUEsS0FBQSxDQUFBLE9BQUEsRUFBQSxDQVBBLENBU0E7O0FBQ0EsTUFBQSxhQUFBLEdBQUEsUUFBQSxHQUFBLFFBQUEsQ0FWQSxDQVlBOztBQUNBLFNBQUEsSUFBQSxDQUFBLEtBQUEsQ0FBQSxhQUFBLEdBQUEsT0FBQSxDQUFBO0FBQ0E7QUFHQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7O0FBQ0EsU0FBQSwwQ0FBQSxDQUFBLGFBQUEsRUFBQTtBQUFBO0FBRUEsTUFBQSxhQUFBLENBQUEsTUFBQSxHQUFBLENBQUEsRUFBQTtBQUNBLFFBQUEsWUFBQSxHQUFBLGtCQUFBLENBQUEsYUFBQSxDQUFBLENBQUEsQ0FBQSxDQUFBO0FBQ0EsUUFBQSxZQUFBOztBQUVBLFNBQUEsSUFBQSxDQUFBLEdBQUEsQ0FBQSxFQUFBLENBQUEsR0FBQSxhQUFBLENBQUEsTUFBQSxFQUFBLENBQUEsRUFBQSxFQUFBO0FBQ0EsTUFBQSxZQUFBLEdBQUEsa0JBQUEsQ0FBQSxhQUFBLENBQUEsQ0FBQSxDQUFBLENBQUE7O0FBRUEsVUFBQSx3QkFBQSxDQUFBLFlBQUEsRUFBQSxZQUFBLENBQUEsSUFBQSxDQUFBLEVBQUE7QUFDQSxlQUFBLEtBQUE7QUFDQTs7QUFFQSxNQUFBLFlBQUEsR0FBQSxZQUFBO0FBQ0E7QUFDQTs7QUFFQSxTQUFBLElBQUE7QUFDQSxDLENBR0E7QUFDQTtBQUNBO0FBRUE7QUFDQTtBQUNBOztBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFJQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7OztBQUNBLFNBQUEsa0NBQUEsQ0FBQSxXQUFBLEVBQUEsWUFBQSxFQUFBO0FBQUEsTUFBQSxhQUFBLHVFQUFBLEVBQUE7QUFBQTtBQUVBLEVBQUEsT0FBQSxDQUFBLEdBQUEsQ0FBQSxnRkFBQSxFQUFBLFdBQUEsRUFBQSxZQUFBLEVBQUEsYUFBQTs7QUFFQSxNQUNBLGdCQUFBLFlBQUEsSUFDQSxnQkFBQSxhQURBLElBRUEsTUFBQSxZQUFBLElBQUEsTUFBQSxhQUhBLEVBSUE7QUFDQSxXQUFBLENBQUE7QUFDQSxHQVZBLENBWUE7QUFDQTtBQUNBOzs7QUFDQSxNQUFBLG1CQUFBLEdBQUEsRUFBQTs7QUFDQSxNQUFBLEtBQUEsQ0FBQSxPQUFBLENBQUEsWUFBQSxDQUFBLEVBQUE7QUFDQSxJQUFBLG1CQUFBLEdBQUEsY0FBQSxDQUFBLFlBQUEsQ0FBQSxDQURBLENBR0E7QUFDQTtBQUNBO0FBQ0E7O0FBQ0EsUUFDQSxtQkFBQSxDQUFBLE1BQUEsR0FBQSxDQUFBLElBQ0EsTUFBQSxhQURBLElBRUEsQ0FBQSwwQ0FBQSxDQUFBLG1CQUFBLENBSEEsRUFJQTtBQUNBLE1BQUEsOEJBQUEsQ0FBQSxXQUFBLENBQUE7QUFDQSxLQWJBLENBY0E7OztBQUNBLFFBQ0EsbUJBQUEsQ0FBQSxNQUFBLEdBQUEsQ0FBQSxJQUNBLE1BQUEsYUFEQSxJQUVBLGFBQUEsS0FBQSxDQUFBLHlCQUFBLENBQUEsV0FBQSxFQUFBLGtCQUFBLENBSEEsRUFJQTtBQUNBLE1BQUEsOEJBQUEsQ0FBQSxXQUFBLENBQUE7QUFDQSxLQXJCQSxDQXNCQTs7O0FBQ0EsSUFBQSxZQUFBLEdBQUEsbUJBQUEsQ0FBQSxDQUFBLENBQUE7O0FBQ0EsUUFBQSxNQUFBLGFBQUEsRUFBQTtBQUNBLE1BQUEsYUFBQSxHQUFBLG1CQUFBLENBQUEsbUJBQUEsQ0FBQSxNQUFBLEdBQUEsQ0FBQSxDQUFBO0FBQ0E7QUFDQSxHQTNDQSxDQTRDQTs7O0FBR0EsTUFBQSxNQUFBLFlBQUEsRUFBQTtBQUNBLElBQUEsWUFBQSxHQUFBLGFBQUE7QUFDQTs7QUFDQSxNQUFBLE1BQUEsYUFBQSxFQUFBO0FBQ0EsSUFBQSxhQUFBLEdBQUEsWUFBQTtBQUNBOztBQUVBLE1BQUEsZ0JBQUEsT0FBQSxXQUFBLEVBQUE7QUFDQSxJQUFBLFdBQUEsR0FBQSxHQUFBO0FBQ0E7O0FBR0EsTUFBQSxJQUFBLEdBQUEsdUJBQUEsQ0FBQSxXQUFBLENBQUE7O0FBRUEsTUFBQSxTQUFBLElBQUEsRUFBQTtBQUVBO0FBQ0Es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O0FBQ0EsVUFBQSxJQUFBLENBQUEsS0FBQSxDQUFBLElBQUEsQ0FBQSxTQUFBLENBQUEsUUFBQSxDQUFBLENBQUEsQ0FBQTtBQUNBO0FBQ0E7O0FBRUEsVUFBQSxjQUFBLEdBQUEsU0FBQSxDQUFBLFFBQUEsQ0FBQSxTQUFBLENBQUEsUUFBQSxDQUFBLE1BQUEsR0FBQSxDQUFBLENBQUE7QUFFQSxNQUFBLElBQUEsQ0FBQSxLQUFBLENBQUEsSUFBQSxDQUFBLGNBQUEsRUFoQ0EsQ0FnQ0E7O0FBRUEsVUFBQSxrQkFBQSxHQUFBLGNBQUEsQ0FBQSxPQUFBLEVBQUE7QUFDQSxVQUFBLE9BQUEsR0FBQSxtQkFBQSxDQUFBLElBQUEsQ0FBQSxFQUFBLEVBQUEsY0FBQSxDQUFBOztBQUVBLE1BQUEsTUFBQSxDQUFBLFFBQUEsQ0FBQSxVQUFBLENBQUEsT0FBQSxFQUFBLE1BQUEsSUFBQSxDQUFBLEVBQUEsRUFBQSxrQkFBQTtBQUNBOztBQUdBLFFBQUEsTUFBQSxJQUFBLENBQUEsS0FBQSxDQUFBLE1BQUEsRUFBQTtBQUNBO0FBQ0EsTUFBQSx3QkFBQSxDQUFBLFdBQUEsRUFBQSxJQUFBLENBQUEsS0FBQSxDQUFBLENBQUEsRUFBQSxXQUFBLEVBQUEsRUFBQSxJQUFBLENBQUEsS0FBQSxDQUFBLENBQUEsRUFBQSxRQUFBLEtBQUEsQ0FBQSxDQUFBO0FBQ0E7O0FBRUEsV0FBQSxJQUFBLENBQUEsS0FBQSxDQUFBLE1BQUE7QUFDQTs7QUFFQSxTQUFBLENBQUE7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQSxTQUFBLG1CQUFBLENBQUEsZ0JBQUEsRUFBQSxPQUFBLEVBQUE7QUFFQSxNQUFBLE9BQUEsR0FBQSxNQUFBLENBQUEsTUFBQSxnQkFBQSxHQUFBLGFBQUEsR0FBQSx5QkFBQSxDQUFBLE9BQUEsQ0FBQSxDQUFBLENBQUEsR0FBQSxDQUFBLENBQUEsQ0FBQTtBQUVBLFNBQUEsT0FBQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7O0FBQ0EsU0FBQSxzREFBQSxDQUFBLFlBQUEsRUFBQSxhQUFBLEVBQUEsSUFBQSxFQUFBO0FBRUEsTUFBQSxjQUFBLEdBQUEsRUFBQTtBQUNBLE1BQUEsSUFBQTtBQUNBLE1BQUEsaUJBQUEsR0FBQSxFQUFBO0FBRUEsTUFBQSxhQUFBLEdBQUEsWUFBQSxDQUFBLEtBQUEsQ0FBQSxHQUFBLENBQUE7QUFDQSxNQUFBLGNBQUEsR0FBQSxhQUFBLENBQUEsS0FBQSxDQUFBLEdBQUEsQ0FBQTtBQUVBLEVBQUEsSUFBQSxHQUFBLElBQUEsSUFBQSxFQUFBO0FBQ0EsRUFBQSxJQUFBLENBQUEsV0FBQSxDQUFBLGFBQUEsQ0FBQSxDQUFBLENBQUEsRUFBQSxhQUFBLENBQUEsQ0FBQSxDQUFBLEdBQUEsQ0FBQSxFQUFBLGFBQUEsQ0FBQSxDQUFBLENBQUEsRUFWQSxDQVVBOztBQUNBLE1BQUEsc0JBQUEsR0FBQSxJQUFBO0FBQ0EsRUFBQSxjQUFBLENBQUEsSUFBQSxDQUFBLE1BQUEsQ0FBQSxRQUFBLENBQUEsZUFBQSxDQUFBLElBQUEsRUFBQSxNQUFBLENBQUEsUUFBQSxDQUFBLGNBQUEsQ0FBQSxJQUFBLEVBQUEsSUFBQSxFQUFBLElBQUEsQ0FBQSxDQUFBLEVBWkEsQ0FZQTs7QUFDQSxNQUFBLENBQUEsY0FBQSxDQUFBLGlCQUFBLEVBQUEsYUFBQSxDQUFBLENBQUEsQ0FBQSxHQUFBLEdBQUEsR0FBQSxhQUFBLENBQUEsQ0FBQSxDQUFBLEdBQUEsR0FBQSxHQUFBLGFBQUEsQ0FBQSxDQUFBLENBQUEsQ0FBQSxFQUFBO0FBQ0EsSUFBQSxpQkFBQSxDQUFBLElBQUEsQ0FBQSxRQUFBLENBQUEsYUFBQSxDQUFBLENBQUEsQ0FBQSxDQUFBLEdBQUEsR0FBQSxHQUFBLFFBQUEsQ0FBQSxhQUFBLENBQUEsQ0FBQSxDQUFBLENBQUEsR0FBQSxHQUFBLEdBQUEsYUFBQSxDQUFBLENBQUEsQ0FBQTtBQUNBOztBQUVBLE1BQUEsUUFBQSxHQUFBLElBQUEsSUFBQSxFQUFBO0FBQ0EsRUFBQSxRQUFBLENBQUEsV0FBQSxDQUFBLGNBQUEsQ0FBQSxDQUFBLENBQUEsRUFBQSxjQUFBLENBQUEsQ0FBQSxDQUFBLEdBQUEsQ0FBQSxFQUFBLGNBQUEsQ0FBQSxDQUFBLENBQUEsRUFsQkEsQ0FrQkE7O0FBQ0EsTUFBQSx1QkFBQSxHQUFBLFFBQUE7QUFFQSxNQUFBLE9BQUEsR0FBQSxJQUFBLElBQUEsQ0FBQSxzQkFBQSxDQUFBLFdBQUEsRUFBQSxFQUFBLHNCQUFBLENBQUEsUUFBQSxFQUFBLEVBQUEsc0JBQUEsQ0FBQSxPQUFBLEVBQUEsQ0FBQTtBQUNBLEVBQUEsT0FBQSxDQUFBLE9BQUEsQ0FBQSxzQkFBQSxDQUFBLE9BQUEsS0FBQSxDQUFBOztBQUVBLFNBQ0EsdUJBQUEsR0FBQSxJQUFBLElBQ0Esc0JBQUEsSUFBQSx1QkFGQSxFQUVBO0FBQ0EsSUFBQSxJQUFBLEdBQUEsSUFBQSxJQUFBLENBQUEsT0FBQSxDQUFBLFdBQUEsRUFBQSxFQUFBLE9BQUEsQ0FBQSxRQUFBLEVBQUEsRUFBQSxPQUFBLENBQUEsT0FBQSxFQUFBLENBQUE7QUFFQSxJQUFBLGNBQUEsQ0FBQSxJQUFBLENBQUEsTUFBQSxDQUFBLFFBQUEsQ0FBQSxlQUFBLENBQUEsSUFBQSxFQUFBLE1BQUEsQ0FBQSxRQUFBLENBQUEsY0FBQSxDQUFBLElBQUEsRUFBQSxJQUFBLEVBQUEsSUFBQSxDQUFBLENBQUEsRUFIQSxDQUdBOztBQUNBLFFBQUEsQ0FBQSxjQUFBLENBQUEsaUJBQUEsRUFBQSxJQUFBLENBQUEsT0FBQSxLQUFBLEdBQUEsR0FBQSxRQUFBLENBQUEsSUFBQSxDQUFBLFFBQUEsS0FBQSxDQUFBLENBQUEsR0FBQSxHQUFBLEdBQUEsSUFBQSxDQUFBLFdBQUEsRUFBQSxDQUFBLEVBQUE7QUFDQSxNQUFBLGlCQUFBLENBQUEsSUFBQSxDQUFBLFFBQUEsQ0FBQSxJQUFBLENBQUEsT0FBQSxFQUFBLENBQUEsR0FBQSxHQUFBLEdBQUEsUUFBQSxDQUFBLElBQUEsQ0FBQSxRQUFBLEtBQUEsQ0FBQSxDQUFBLEdBQUEsR0FBQSxHQUFBLElBQUEsQ0FBQSxXQUFBLEVBQUE7QUFDQTs7QUFFQSxJQUFBLE9BQUEsR0FBQSxJQUFBLElBQUEsQ0FBQSxJQUFBLENBQUEsV0FBQSxFQUFBLEVBQUEsSUFBQSxDQUFBLFFBQUEsRUFBQSxFQUFBLElBQUEsQ0FBQSxPQUFBLEVBQUEsQ0FBQTtBQUNBLElBQUEsT0FBQSxDQUFBLE9BQUEsQ0FBQSxPQUFBLENBQUEsT0FBQSxLQUFBLENBQUE7QUFDQTs7QUFDQSxFQUFBLGNBQUEsQ0FBQSxHQUFBO0FBQ0EsRUFBQSxpQkFBQSxDQUFBLEdBQUE7QUFFQSxTQUFBO0FBQUEsZ0JBQUEsY0FBQTtBQUFBLGlCQUFBO0FBQUEsR0FBQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7OztBQUNBLFNBQUEsNkNBQUEsQ0FBQSxtQkFBQSxFQUFBO0FBQUE7QUFFQSxNQUFBLGNBQUEsR0FBQSxFQUFBO0FBQ0EsTUFBQSxpQkFBQSxHQUFBLEVBQUE7QUFDQSxNQUFBLFlBQUE7O0FBRUEsT0FBQSxJQUFBLENBQUEsR0FBQSxDQUFBLEVBQUEsQ0FBQSxHQUFBLG1CQUFBLENBQUEsTUFBQSxFQUFBLENBQUEsRUFBQSxFQUFBO0FBRUEsSUFBQSxjQUFBLENBQUEsSUFBQSxDQUFBLGtCQUFBLENBQUEsbUJBQUEsQ0FBQSxDQUFBLENBQUEsQ0FBQTtBQUVBLElBQUEsWUFBQSxHQUFBLG1CQUFBLENBQUEsQ0FBQSxDQUFBLENBQUEsS0FBQSxDQUFBLEdBQUEsQ0FBQTs7QUFDQSxRQUFBLENBQUEsY0FBQSxDQUFBLGlCQUFBLEVBQUEsWUFBQSxDQUFBLENBQUEsQ0FBQSxHQUFBLEdBQUEsR0FBQSxZQUFBLENBQUEsQ0FBQSxDQUFBLEdBQUEsR0FBQSxHQUFBLFlBQUEsQ0FBQSxDQUFBLENBQUEsQ0FBQSxFQUFBO0FBQ0EsTUFBQSxpQkFBQSxDQUFBLElBQUEsQ0FBQSxRQUFBLENBQUEsWUFBQSxDQUFBLENBQUEsQ0FBQSxDQUFBLEdBQUEsR0FBQSxHQUFBLFFBQUEsQ0FBQSxZQUFBLENBQUEsQ0FBQSxDQUFBLENBQUEsR0FBQSxHQUFBLEdBQUEsWUFBQSxDQUFBLENBQUEsQ0FBQTtBQUNBO0FBQ0E7O0FBRUEsU0FBQTtBQUFBLGdCQUFBLGNBQUE7QUFBQSxpQkFBQTtBQUFBLEdBQUE7QUFDQTs7QUFHQSxNQUFBLENBQUEsUUFBQSxDQUFBLENBQUEsS0FBQSxDQUFBLFlBQUE7QUFFQSxNQUFBLFVBQUEsR0FBQSxJQUFBLGVBQUEsQ0FBQSxNQUFBLENBQUEsUUFBQSxDQUFBLE1BQUEsQ0FBQSxDQUZBLENBSUE7O0FBQ0EsTUFBQSxRQUFBLEtBQUEsQ0FBQSxlQUFBLENBQUEsK0NBQUEsQ0FBQSxFQUFBO0FBQ0EsUUFDQSxVQUFBLENBQUEsR0FBQSxDQUFBLHNCQUFBLENBQUEsSUFDQSxVQUFBLENBQUEsR0FBQSxDQUFBLHVCQUFBLENBREEsSUFFQSxVQUFBLENBQUEsR0FBQSxDQUFBLHlCQUFBLENBSEEsRUFJQTtBQUVBLFVBQUEsMkJBQUEsR0FBQSxRQUFBLENBQUEsVUFBQSxDQUFBLEdBQUEsQ0FBQSx5QkFBQSxDQUFBLENBQUEsQ0FGQSxDQUlBOztBQUNBLE1BQUEsTUFBQSxDQUFBLE1BQUEsQ0FBQSxDQUFBLEVBQUEsQ0FBQSxnQ0FBQSxFQUFBLFVBQUEsS0FBQSxFQUFBLGtCQUFBLEVBQUE7QUFFQSxZQUFBLGtCQUFBLElBQUEsMkJBQUEsRUFBQTtBQUNBLFVBQUEsa0NBQUEsQ0FBQSwyQkFBQSxFQUFBLFVBQUEsQ0FBQSxHQUFBLENBQUEsc0JBQUEsQ0FBQSxFQUFBLFVBQUEsQ0FBQSxHQUFBLENBQUEsdUJBQUEsQ0FBQSxDQUFBO0FBQ0E7QUFDQSxPQUxBO0FBTUE7QUFDQTs7QUFFQSxNQUFBLFVBQUEsQ0FBQSxHQUFBLENBQUEsZ0JBQUEsQ0FBQSxFQUFBO0FBRUEsUUFBQSxvQkFBQSxHQUFBLFVBQUEsQ0FBQSxHQUFBLENBQUEsZ0JBQUEsQ0FBQSxDQUZBLENBSUE7O0FBQ0EsSUFBQSxvQkFBQSxHQUFBLG9CQUFBLENBQUEsVUFBQSxDQUFBLEtBQUEsRUFBQSxHQUFBLENBQUE7QUFFQSxJQUFBLDZCQUFBLENBQUEsb0JBQUEsQ0FBQTtBQUNBO0FBRUEsQ0FsQ0E7QUFxQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFDQSxTQUFBLDZCQUFBLENBQUEsYUFBQSxFQUFBO0FBQUE7QUFFQSxNQUFBLE1BQUEsYUFBQSxFQUFBO0FBQ0E7QUFDQSxHQUpBLENBTUE7OztBQUVBLE1BQUEsVUFBQSxHQUFBLG9DQUFBLENBQUEsYUFBQSxDQUFBOztBQUVBLE9BQUEsSUFBQSxDQUFBLEdBQUEsQ0FBQSxFQUFBLENBQUEsR0FBQSxVQUFBLENBQUEsTUFBQSxFQUFBLENBQUEsRUFBQSxFQUFBO0FBQ0EsSUFBQSxNQUFBLENBQUEsWUFBQSxVQUFBLENBQUEsQ0FBQSxDQUFBLENBQUEsTUFBQSxDQUFBLEdBQUEsSUFBQSxDQUFBLENBQUEsR0FBQSxDQUFBLFVBQUEsQ0FBQSxDQUFBLENBQUEsQ0FBQSxPQUFBLENBQUE7QUFDQTtBQUNBO0FBR0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQSxTQUFBLG9DQUFBLENBQUEsUUFBQSxFQUFBO0FBRUEsTUFBQSxrQkFBQSxHQUFBLEVBQUE7QUFFQSxNQUFBLFFBQUEsR0FBQSxRQUFBLENBQUEsS0FBQSxDQUFBLEdBQUEsQ0FBQTs7QUFFQSxPQUFBLElBQUEsQ0FBQSxHQUFBLENBQUEsRUFBQSxDQUFBLEdBQUEsUUFBQSxDQUFBLE1BQUEsRUFBQSxDQUFBLEVBQUEsRUFBQTtBQUVBLFFBQUEsYUFBQSxHQUFBLFFBQUEsQ0FBQSxDQUFBLENBQUEsQ0FBQSxLQUFBLENBQUEsR0FBQSxDQUFBO0FBRUEsUUFBQSxXQUFBLEdBQUEsZ0JBQUEsT0FBQSxhQUFBLENBQUEsQ0FBQSxDQUFBLEdBQUEsYUFBQSxDQUFBLENBQUEsQ0FBQSxHQUFBLEVBQUE7QUFDQSxRQUFBLFlBQUEsR0FBQSxnQkFBQSxPQUFBLGFBQUEsQ0FBQSxDQUFBLENBQUEsR0FBQSxhQUFBLENBQUEsQ0FBQSxDQUFBLEdBQUEsRUFBQTtBQUVBLElBQUEsa0JBQUEsQ0FBQSxJQUFBLENBQ0E7QUFDQSxjQUFBLFdBREE7QUFFQSxlQUFBO0FBRkEsS0FEQTtBQU1BOztBQUNBLFNBQUEsa0JBQUE7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7O0FBQ0EsU0FBQSxtQ0FBQSxDQUFBLFFBQUEsRUFBQTtBQUVBLE1BQUEsa0JBQUEsR0FBQSxFQUFBO0FBRUEsTUFBQSxRQUFBLEdBQUEsUUFBQSxDQUFBLEtBQUEsQ0FBQSxHQUFBLENBQUE7O0FBRUEsT0FBQSxJQUFBLENBQUEsR0FBQSxDQUFBLEVBQUEsQ0FBQSxHQUFBLFFBQUEsQ0FBQSxNQUFBLEVBQUEsQ0FBQSxFQUFBLEVBQUE7QUFFQSxRQUFBLGFBQUEsR0FBQSxRQUFBLENBQUEsQ0FBQSxDQUFBLENBQUEsS0FBQSxDQUFBLEdBQUEsQ0FBQTtBQUVBLFFBQUEsV0FBQSxHQUFBLGdCQUFBLE9BQUEsYUFBQSxDQUFBLENBQUEsQ0FBQSxHQUFBLGFBQUEsQ0FBQSxDQUFBLENBQUEsR0FBQSxFQUFBO0FBQ0EsUUFBQSxXQUFBLEdBQUEsZ0JBQUEsT0FBQSxhQUFBLENBQUEsQ0FBQSxDQUFBLEdBQUEsYUFBQSxDQUFBLENBQUEsQ0FBQSxHQUFBLEVBQUE7QUFDQSxRQUFBLFlBQUEsR0FBQSxnQkFBQSxPQUFBLGFBQUEsQ0FBQSxDQUFBLENBQUEsR0FBQSxhQUFBLENBQUEsQ0FBQSxDQUFBLEdBQUEsRUFBQTtBQUVBLElBQUEsa0JBQUEsQ0FBQSxJQUFBLENBQ0E7QUFDQSxjQUFBLFdBREE7QUFFQSxjQUFBLFdBRkE7QUFHQSxlQUFBO0FBSEEsS0FEQTtBQU9BOztBQUNBLFNBQUEsa0JBQUE7QUFDQTtBQ3gwREE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUVBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7OztBQUNBLFNBQUEsaUJBQUEsQ0FBQSxXQUFBLEVBQUE7QUFFQTtBQUNBLEVBQUEsTUFBQSxDQUFBLHNCQUFBLFdBQUEsQ0FBQSxDQUFBLFdBQUEsQ0FBQSxhQUFBO0FBQ0EsRUFBQSxrQkFBQSxDQUFBLFdBQUEsQ0FBQTtBQUNBO0FBR0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7O0FBQ0EsU0FBQSw2QkFBQSxDQUFBLFdBQUEsRUFBQTtBQUVBLEVBQUEsS0FBQSxDQUFBLHlCQUFBLENBQUEsV0FBQSxFQUFBLHNDQUFBLEVBQ0E7QUFDQSx5QkFBQSxLQUFBLENBQUEseUJBQUEsQ0FBQSxXQUFBLEVBQUEsbUJBQUEsQ0FEQTtBQUVBLHlCQUFBLEtBQUEsQ0FBQSx5QkFBQSxDQUFBLFdBQUEsRUFBQSxtQkFBQSxDQUZBO0FBR0EsOEJBQUEsS0FBQSxDQUFBLHlCQUFBLENBQUEsV0FBQSxFQUFBLHdCQUFBLENBSEE7QUFJQSxpQ0FBQSxLQUFBLENBQUEseUJBQUEsQ0FBQSxXQUFBLEVBQUEsMkJBQUEsQ0FKQTtBQUtBLHVCQUFBLEtBQUEsQ0FBQSx5QkFBQSxDQUFBLFdBQUEsRUFBQSxpQkFBQSxDQUxBO0FBTUEsK0JBQUEsS0FBQSxDQUFBLHlCQUFBLENBQUEsV0FBQSxFQUFBLHlCQUFBO0FBTkEsR0FEQTtBQVVBLEMsQ0FFQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQSxTQUFBLGtDQUFBLENBQUEsV0FBQSxFQUFBO0FBRUE7QUFDQSxFQUFBLE1BQUEsQ0FBQSxRQUFBLENBQUEsQ0FBQSxLQUFBLENBQUEsWUFBQTtBQUVBO0FBQ0EsSUFBQSxVQUFBLENBQUEsWUFBQTtBQUVBLE1BQUEsNEJBQUEsQ0FBQSxXQUFBLENBQUE7QUFFQSxLQUpBLEVBSUEsSUFKQSxDQUFBO0FBS0EsR0FSQTtBQVNBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQSxTQUFBLDRCQUFBLENBQUEsV0FBQSxFQUFBO0FBRUEsRUFBQSxLQUFBLENBQUEsd0JBQUEsQ0FBQSxXQUFBLEVBQUE7QUFBQSx3QkFBQTtBQUFBLEdBQUE7O0FBRUEsRUFBQSw2QkFBQSxDQUFBLFdBQUEsQ0FBQTtBQUNBLEVBQUEsaUJBQUEsQ0FBQSxXQUFBLENBQUE7QUFDQSxDLENBRUE7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7O0FBQ0EsU0FBQSxvQ0FBQSxDQUFBLFdBQUEsRUFBQTtBQUVBO0FBQ0EsRUFBQSxNQUFBLENBQUEsUUFBQSxDQUFBLENBQUEsS0FBQSxDQUFBLFlBQUE7QUFFQTtBQUNBLElBQUEsVUFBQSxDQUFBLFlBQUE7QUFFQSxNQUFBLDhCQUFBLENBQUEsV0FBQSxDQUFBO0FBRUEsS0FKQSxFQUlBLElBSkEsQ0FBQTtBQUtBLEdBUkE7QUFTQTtBQUdBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7O0FBQ0EsU0FBQSw4QkFBQSxDQUFBLFdBQUEsRUFBQTtBQUVBLEVBQUEsS0FBQSxDQUFBLHdCQUFBLENBQUEsV0FBQSxFQUFBO0FBQUEsd0JBQUE7QUFBQSxHQUFBOztBQUVBLEVBQUEsNkJBQUEsQ0FBQSxXQUFBLENBQUE7QUFDQSxFQUFBLGlCQUFBLENBQUEsV0FBQSxDQUFBO0FBQ0EsQyxDQUdBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQSxTQUFBLGlDQUFBLENBQUEsV0FBQSxFQUFBLFdBQUEsRUFBQTtBQUFBLE1BQUEsZ0JBQUEsdUVBQUEsQ0FBQSxDQUFBLENBQUEsQ0FBQTtBQUVBO0FBQ0EsRUFBQSxNQUFBLENBQUEsUUFBQSxDQUFBLENBQUEsS0FBQSxDQUFBLFlBQUE7QUFFQTtBQUNBLElBQUEsVUFBQSxDQUFBLFlBQUE7QUFFQSxNQUFBLDJCQUFBLENBQUEsV0FBQSxFQUFBLFdBQUEsRUFBQSxnQkFBQSxDQUFBO0FBRUEsS0FKQSxFQUlBLElBSkEsQ0FBQTtBQUtBLEdBUkE7QUFTQTtBQUdBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7OztBQUNBLFNBQUEsMkJBQUEsQ0FBQSxXQUFBLEVBQUEsV0FBQSxFQUFBO0FBQUEsTUFBQSxnQkFBQSx1RUFBQSxDQUFBLENBQUEsQ0FBQSxDQUFBOztBQUVBLEVBQUEsS0FBQSxDQUFBLHdCQUFBLENBQUEsV0FBQSxFQUFBO0FBQUEsd0JBQUE7QUFBQSxHQUFBOztBQUVBLEVBQUEsS0FBQSxDQUFBLHdCQUFBLENBQUEsV0FBQSxFQUFBO0FBQUEsdUJBQUEsUUFB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Q0FBQSxDQUFBLDRCQUFBLENBQUEsRUFyQ0EsQ0F1Q0E7OztBQUNBLElBQUEsS0FBQSxDQUFBLHdCQUFBLENBQUEsYUFBQSxDQUFBLGFBQUEsQ0FBQSxFQUFBLDJCQUFBLEVBQUEsYUFBQSxDQUFBLFVBQUEsQ0FBQSxDQUFBLDJCQUFBLENBQUEsRUF4Q0EsQ0F5Q0E7QUFFQTs7O0FBQ0EsSUFBQSwwQkFBQSxDQUFBLGFBQUEsQ0FBQSxhQUFBLENBQUEsQ0FBQTs7QUFHQSxRQUNBLGdCQUFBLE9BQUEsYUFBQSxDQUFBLFVBQUEsQ0FBQSxDQUFBLDBCQUFBLENBQUEsSUFDQSxNQUFBLGFBQUEsQ0FBQSxVQUFBLENBQUEsQ0FBQSwwQkFBQSxFQUFBLE9BQUEsQ0FBQSxLQUFBLEVBQUEsUUFBQSxDQUZBLEVBR0E7QUFFQSxVQUFBLE9BQUEsR0FBQSx3Q0FBQSxDQUFBLEtBQUEsSUFBQSxDQUFBLENBRkEsQ0FJQTs7QUFDQSxNQUFBLDRCQUFBLENBQUEsYUFBQSxDQUFBLFVBQUEsQ0FBQSxDQUFBLDBCQUFBLEVBQUEsT0FBQSxDQUFBLEtBQUEsRUFBQSxRQUFBLENBQUEsRUFDQTtBQUFBLGdCQUFBLGdCQUFBLE9BQUEsYUFBQSxDQUFBLFVBQUEsQ0FBQSxDQUFBLGlDQUFBLENBQUEsR0FDQSxhQUFBLENBQUEsVUFBQSxDQUFBLENBQUEsaUNBQUEsQ0FEQSxHQUNBLE1BREE7QUFFQSxxQkFBQTtBQUFBLHFCQUFBLE9BQUE7QUFBQSxtQkFBQTtBQUFBLFNBRkE7QUFHQSxxQkFBQSxJQUhBO0FBSUEsaUJBQUEsa0JBSkE7QUFLQSxpQkFBQTtBQUxBLE9BREEsQ0FBQTtBQVFBLEtBL0RBLENBaUVBOzs7QUFDQSxRQUFBLE1BQUEsQ0FBQSxzQkFBQSxhQUFBLENBQUEsYUFBQSxDQUFBLENBQUEsQ0FBQSxNQUFBLEdBQUEsQ0FBQSxFQUFBO0FBQ0EsVUFBQSxVQUFBLEdBQUEsTUFBQSxDQUFBLE1BQUEsQ0FBQSxDQUFBLE9BQUEsQ0FBQSxnQ0FBQSxFQUFBLENBQUEsYUFBQSxDQUFBLGFBQUEsQ0FBQSxDQUFBLENB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Q0FBQSxHQUFBLE1BQUEsQ0FBQSxLQUFBLENBQUE7QUFDQTs7QUFDQSxFQUFBLE1BQUEsR0FBQSxjQUFBO0FBRUEsTUFBQSxhQUFBLEdBQUEsSUFBQSxJQUFBLEVBQUE7QUFDQSxFQUFBLGFBQUEsR0FBQSxpQkFBQSxhQUFBLENBQUEsT0FBQSxFQUFBO0FBRUEsRUFBQSxNQUFBLENBQUEsV0FBQSxDQUFBLElBQUEsa0JBQUE7O0FBQ0EsTUFBQSxNQUFBLENBQUEsTUFBQSxDQUFBLElBQUEsT0FBQSxFQUFBO0FBQ0EsSUFBQSxNQUFBLENBQUEsV0FBQSxDQUFBLElBQUEsd0JBQUE7QUFDQSxJQUFBLE9BQUEsR0FBQSxvRUFBQSxPQUFBO0FBQ0E7O0FBQ0EsTUFBQSxNQUFBLENBQUEsTUFBQSxDQUFBLElBQUEsU0FBQSxFQUFBO0FBQ0EsSUFBQSxNQUFBLENBQUEsV0FBQSxDQUFBLElBQUEsMEJBQUE7QUFDQSxJQUFBLE9BQUEsR0FBQSx1REFBQSxPQUFBO0FBQ0E7O0FBQ0EsTUFBQSxNQUFBLENBQUEsTUFBQSxDQUFBLElBQUEsTUFBQSxFQUFBO0FBQ0EsSUFBQSxNQUFBLENBQUEsV0FBQSxDQUFBLElBQUEsdUJBQUE7QUFDQTs7QUFDQSxNQUFBLE1BQUEsQ0FBQSxNQUFBLENBQUEsSUFBQSxTQUFBLEVBQUE7QUFDQSxJQUFBLE1BQUEsQ0FBQSxXQUFBLENBQUEsSUFBQSwwQkFBQTtBQUNBLElBQUEsT0FBQSxHQUFBLDREQUFBLE9BQUE7QUFDQTs7QUFFQSxNQUFBLGlCQUFBLEdBQUEsY0FBQSxhQUFBLEdBQUEsdUNBQUE7QUFDQSxFQUFBLE9BQUEsR0FBQSxjQUFBLGFBQUEsR0FBQSxtQ0FBQSxHQUFBLE1BQUEsQ0FBQSxXQUFBLENBQUEsR0FBQSxXQUFBLEdBQUEsTUFBQSxDQUFBLE9BQUEsQ0FBQSxHQUFBLElBQUEsR0FBQSxPQUFBLEdBQUEsUUFBQTtBQUdBLE1BQUEsYUFBQSxHQUFBLEtBQUE7QUFDQSxNQUFBLGVBQUEsR0FBQSxJQUFBOztBQUVBLE1BQUEsYUFBQSxNQUFBLENBQUEsV0FBQSxDQUFBLENBQUEsT0FBQSxDQUFBLEVBQUE7QUFFQSxRQUFBLE1BQUEsQ0FBQSxXQUFBLENBQUEsRUFBQTtBQUNBLE1BQUEsTUFBQSxDQUFBLE1BQUEsQ0FBQSxXQUFBLENBQUEsQ0FBQSxTQUFBLENBQUEsQ0FBQSxDQUFBLE1BQUEsQ0FBQSxpQkFBQTtBQUNBLE1BQUEsTUFBQSxDQUFBLE1BQUEsQ0FBQSxXQUFBLENBQUEsQ0FBQSxTQUFBLENBQUEsQ0FBQSxDQUFBLE1BQUEsQ0FBQSxPQUFBO0FBQ0EsS0FIQSxNQUdBO0FBQ0EsTUFBQSxNQUFBLENBQUEsTUFBQSxDQUFBLFdBQUEsQ0FBQSxDQUFBLFNBQUEsQ0FBQSxDQUFBLENBQUEsSUFBQSxDQUFBLGlCQUFBLEdBQUEsT0FBQTtBQUNBO0FBRUEsR0FUQSxNQVNBLElBQUEsYUFBQSxNQUFBLENBQUEsV0FBQSxDQUFBLENBQUEsT0FBQSxDQUFBLEVBQUE7QUFFQSxJQUFBLGFBQUEsR0FBQSxNQUFBLENBQUEsTUFBQSxDQUFBLFdBQUEsQ0FBQSxDQUFBLFNBQUEsQ0FBQSxDQUFBLENBQUEsUUFBQSxDQUFBLHNCQUFBLENBQUE7O0FBQ0EsUUFBQSxNQUFBLENBQUEscUJBQUEsQ0FBQSxJQUFBLGFBQUEsQ0FBQSxFQUFBLENBQUEsVUFBQSxDQUFBLEVBQUE7QUFDQSxNQUFBLGVBQUEsR0FBQSxLQUFBO0FBQ0EsTUFBQSxhQUFBLEdBQUEsTUFBQSxDQUFBLGFBQUEsQ0FBQSxHQUFBLENBQUEsQ0FBQSxDQUFBLENBQUEsQ0FBQSxJQUFBLENBQUEsSUFBQSxDQUFBO0FBQ0E7O0FBQ0EsUUFBQSxlQUFBLEVBQUE7QUFDQSxNQUFBLE1BQUEsQ0FBQSxNQUFBLENBQUEsV0FBQSxDQUFBLENBQUEsU0FBQSxDQUFBLENBQUEsQ0FBQSxNQUFBLENBQUEsaUJBQUE7QUFDQSxNQUFBLE1BQUEsQ0FBQSxNQUFBLENBQUEsV0FBQSxDQUFBLENBQUEsU0FBQSxDQUFBLENBQUEsQ0FBQSxNQUFBLENBQUEsT0FBQTtBQUNBO0FBRUEsR0FaQSxNQVlBLElBQUEsWUFBQSxNQUFBLENBQUEsV0FBQSxDQUFBLENBQUEsT0FBQSxDQUFBLEVBQUE7QUFFQSxJQUFBLGFBQUEsR0FBQSxNQUFBLENBQUEsTUFBQSxDQUFBLFdBQUEsQ0FBQSxDQUFBLFNBQUEsQ0FBQSxDQUFBLENBQUEsT0FBQSxDQUFBLHNCQUFBLENBQUE7O0FBQ0EsUUFBQSxNQUFBLENBQUEscUJBQUEsQ0FBQSxJQUFBLGFBQUEsQ0FBQSxFQUFBLENBQUEsVUFBQSxDQUFBLEVBQUE7QUFDQSxNQUFBLGVBQUEsR0FBQSxLQUFBO0FBQ0EsTUFBQSxhQUFBLEdBQUEsTUFBQSxDQUFBLGFBQUEsQ0FBQSxHQUFBLENBQUEsQ0FBQSxDQUFBLENBQUEsQ0FBQSxJQUFBLENBQUEsSUFBQSxDQUFBO0FBQ0E7O0FBQ0EsUUFBQSxlQUFBLEVBQUE7QUFDQSxNQUFBLE1BQUEsQ0FBQSxNQUFBLENBQUEsV0FBQSxDQUFBLENBQUEsU0FBQSxDQUFBLENBQUEsQ0FBQSxNQUFBLENBQUEsaUJBQUEsRUFEQSxDQUNBOztBQUNBLE1BQUEsTUFBQSxDQUFBLE1BQUEsQ0FBQSxXQUFBLENBQUEsQ0FBQSxTQUFBLENBQUEsQ0FBQSxDQUFBLEtBQUEsQ0FBQSxPQUFBO0FBQ0E7QUFFQSxHQVpBLE1BWUEsSUFBQSxZQUFBLE1BQUEsQ0FBQSxXQUFBLENBQUEsQ0FBQSxPQUFBLENBQUEsRUFBQTtBQUVBLElBQUEsYUFBQSxHQUFBLE1BQUEsQ0FBQSxNQUFBLENBQUEsV0FBQSxDQUFBLENBQUEsU0FBQSxDQUFBLENBQUEsQ0FBQSxPQUFBLENBQUEsMENBQUEsRUFBQSxJQUFBLENBQUEsc0JBQUEsQ0FBQTs7QUFDQSxRQUFBLE1BQUEsQ0FBQSxxQkFBQSxDQUFBLElBQUEsYUFBQSxDQUFBLEVBQUEsQ0FBQSxVQUFBLENBQUEsRUFBQTtBQUNBLE1BQUEsZUFBQSxHQUFBLEtBQUE7QUFDQSxNQUFBLGFBQUEsR0FBQSxNQUFBLENBQUEsYUFBQSxDQUFBLEdBQUEsQ0FBQSxDQUFBLENBQUEsQ0FBQSxDQUFBLElBQUEsQ0FBQSxJQUFBLENBQUE7QUFDQTs7QUFDQSxRQUFBLGVBQUEsRUFBQTtBQUNBLE1BQUEsTUFBQSxDQUFBLE1BQUEsQ0FBQSxXQUFBLENBQUEsQ0FBQSxTQUFBLENBQUEsQ0FBQSxDQUFBLE1BQUEsQ0FBQSxpQkFBQSxFQURBLENBQ0E7O0FBQ0EsTUFBQSxNQUFBLENBQUEsTUFBQSxDQUFBLFdBQUEsQ0FBQSxDQUFBLFNBQUEsQ0FBQSxDQUFBLENBQUEsS0FBQSxDQUFBLDBEQUFBLE9BQUEsR0FBQSxRQUFBO0FBQ0E7QUFDQSxHQVhBLE1BV0EsSUFBQSxXQUFBLE1BQUEsQ0FBQSxXQUFBLENBQUEsQ0FBQSxPQUFBLENBQUEsRUFBQTtBQUVBLElBQUEsYUFBQSxHQUFBLE1BQUEsQ0FBQSxNQUFBLENBQUEsV0FBQSxDQUFBLENBQUEsU0FBQSxDQUFBLENBQUEsQ0FBQSxRQUFBLENBQUEseUNBQUEsRUFBQSxJQUFBLENBQUEsc0JBQUEsQ0FBQTs7QUFDQSxRQUFBLE1BQUEsQ0FBQSxxQkFBQSxDQUFBLElBQUEsYUFBQSxDQUFBLEVBQUEsQ0FBQSxVQUFBLENBQUEsRUFBQTtBQUNBLE1BQUEsZUFBQSxHQUFBLEtBQUE7QUFDQSxNQUFBLGFBQUEsR0FBQSxNQUFBLENBQUEsYUFBQSxDQUFBLEdBQUEsQ0FBQSxDQUFBLENBQUEsQ0FBQSxDQUFBLElBQUEsQ0FBQSxJQUFBLENBQUE7QUFDQTs7QUFDQSxRQUFBLGVBQUEsRUFBQTtBQUNBLE1BQUEsTUFBQSxDQUFBLE1BQUEsQ0FBQSxXQUFBLENBQUEsQ0FBQSxTQUFBLENBQUEsQ0FBQSxDQUFBLE1BQUEsQ0FBQSxpQkFBQSxFQURBLENBQ0E7O0FBQ0EsTUFBQSxNQUFBLENBQUEsTUFBQSxDQUFBLFdBQUEsQ0FBQSxDQUFBLFNBQUEsQ0FBQSxDQUFBLENBQUEsTUFBQSxDQUFBLHlEQUFBLE9BQUEsR0FBQSxRQUFBO0FBQ0E7QUFDQTs7QUFFQSxNQUFBLGVBQUEsSUFBQSxRQUFBLENBQUEsTUFBQSxDQUFBLE9BQUEsQ0FBQSxDQUFBLEdBQUEsQ0FBQSxFQUFBO0FBQ0EsUUFBQSxZQUFBLEdBQUEsVUFBQSxD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O0FBQ0E7OztBQUNBLFNBQUEsbURBQUEsQ0FBQSxPQUFBLEVBQUEsT0FBQSxFQUFBO0FBRUEsTUFBQSxpQkFBQSxHQUFBLDRCQUFBLENBQ0EsT0FEQSxFQUVBO0FBQ0EsWUFBQSxTQURBO0FBRUEsYUFBQSxLQUZBO0FBR0EsMkJBQUEsSUFIQTtBQUlBLGlCQUFBO0FBQ0EsZUFBQSxPQURBO0FBRUEsaUJBQUE7QUFGQTtBQUpBLEdBRkEsQ0FBQTtBQVlBLFNBQUEsaUJBQUE7QUFDQTtBQUdBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQSxTQUFBLG1EQUFBLENBQUEsT0FBQSxFQUFBLE9BQUEsRUFBQTtBQUVBLE1BQUEsaUJBQUEsR0FBQSw0QkFBQSxDQUNBLE9BREEsRUFFQTtBQUNBLFlBQUEsU0FEQTtBQUVBLGFBQUEsS0FGQTtBQUdBLDJCQUFBLElBSEE7QUFJQSxpQkFBQTtBQUNBLGVBQUEsUUFEQTtBQUVBLGlCQUFBO0FBRkE7QUFKQSxHQUZBLENBQUE7QUFZQSxTQUFBLGlCQUFBO0FBQ0E7QUFHQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7OztBQUNBLFNBQUEsY0FBQSxDQUFBLE9BQUEsRUFBQTtBQUFBLE1BQUEsa0JBQUEsdUVBQUEsQ0FBQTs7QUFFQSxNQUFBLENBQUEsTUFBQSxDQUFBLE9BQUEsQ0FBQSxDQUFBLE1BQUEsRUFBQTtBQUNBO0FBQ0E7O0FBQ0EsTUFBQSxZQUFBLEdBQUEsTUFBQSxDQUFBLE9BQUEsQ0FBQSxDQUFBLE1BQUEsR0FBQSxHQUFBOztBQUVBLE1BQUEsWUFBQSxJQUFBLENBQUEsRUFBQTtBQUNBLFFBQUEsS0FBQSxNQUFBLENBQUEsT0FBQSxDQUFBLENBQUEsT0FBQSxDQUFBLFVBQUEsRUFBQSxNQUFBLEVBQUE7QUFDQSxNQUFBLFlBQUEsR0FBQSxNQUFBLENBQUEsT0FBQSxDQUFBLENBQUEsT0FBQSxDQUFBLFVBQUEsRUFBQSxLQUFBLEdBQUEsTUFBQSxHQUFBLEdBQUE7QUFDQSxLQUZBLE1BRUEsSUFBQSxLQUFBLE1BQUEsQ0FBQSxPQUFBLENBQUEsQ0FBQSxNQUFBLEdBQUEsT0FBQSxDQUFBLFVBQUEsRUFBQSxNQUFBLEVBQUE7QUFDQSxNQUFBLFlBQUEsR0FBQSxNQUFBLENBQUEsT0FBQSxDQUFBLENBQUEsTUFBQSxHQUFBLE9BQUEsQ0FBQSxVQUFBLEVBQUEsS0FBQSxHQUFBLE1BQUEsR0FBQSxHQUFBO0FBQ0E7QUFDQTs7QUFFQSxNQUFBLE1BQUEsQ0FBQSxhQUFBLENBQUEsQ0FBQSxNQUFBLEdBQUEsQ0FBQSxFQUFBO0FBQ0EsSUFBQSxZQUFBLEdBQUEsWUFBQSxHQUFBLEVBQUEsR0FBQSxFQUFBO0FBQ0EsR0FGQSxNQUVBO0FBQ0EsSUFBQSxZQUFBLEdBQUEsWUFBQSxHQUFBLEVBQUEsR0FBQSxFQUFBO0FBQ0E7O0FBQ0EsRUFBQSxZQUFBLElBQUEsa0JBQUEsQ0FwQkEsQ0FzQkE7O0FBQ0EsTUFBQSxDQUFBLE1BQUEsQ0FBQSxXQUFBLENBQUEsQ0FBQSxFQUFBLENBQUEsV0FBQSxDQUFBLEVBQUE7QUFDQSxJQUFBLE1BQUEsQ0FBQSxXQUFBLENBQUEsQ0FBQSxPQUFBLENBQUE7QUFBQSxNQUFBLFNBQUEsRUFBQTtBQUFBLEtBQUEsRUFBQSxHQUFBO0FBQ0E7QUFDQSIsInNvdXJjZXNDb250ZW50IjpbIlwidXNlIHN0cmljdFwiO1xyXG4vKipcclxuICogPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XHJcbiAqXHRpbmNsdWRlcy9fX2pzL3dwYmMvd3BiYy5qc1xyXG4gKiA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cclxuICovXHJcblxyXG4vKipcclxuICogRGVlcCBDbG9uZSBvZiBvYmplY3Qgb3IgYXJyYXlcclxuICpcclxuICogQHBhcmFtIG9ialxyXG4gKiBAcmV0dXJucyB7YW55fVxyXG4gKi9cclxuZnVuY3Rpb24gd3BiY19jbG9uZV9vYmooIG9iaiApe1xyXG5cclxuXHRyZXR1cm4gSlNPTi5wYXJzZSggSlNPTi5zdHJpbmdpZnkoIG9iaiApICk7XHJcbn1cclxuXHJcblxyXG5cclxuLyoqXHJcbiAqIE1haW4gX3dwYmMgSlMgb2JqZWN0XHJcbiAqL1xyXG5cclxudmFyIF93cGJjID0gKGZ1bmN0aW9uICggb2JqLCAkKSB7XHJcblxyXG5cdC8vIFNlY3VyZSBwYXJhbWV0ZXJzIGZvciBBamF4XHQtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHR2YXIgcF9zZWN1cmUgPSBvYmouc2VjdXJpdHlfb2JqID0gb2JqLnNlY3VyaXR5X29iaiB8fCB7XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdHVzZXJfaWQ6IDAsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdG5vbmNlICA6ICcnLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRsb2NhbGUgOiAnJ1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0ICB9O1xyXG5cdG9iai5zZXRfc2VjdXJlX3BhcmFtID0gZnVuY3Rpb24gKCBwYXJhbV9rZXksIHBhcmFtX3ZhbCApIHtcclxuXHRcdHBfc2VjdXJlWyBwYXJhbV9rZXkgXSA9IHBhcmFtX3ZhbDtcclxuXHR9O1xyXG5cclxuXHRvYmouZ2V0X3NlY3VyZV9wYXJhbSA9IGZ1bmN0aW9uICggcGFyYW1fa2V5ICkge1xyXG5cdFx0cmV0dXJuIHBfc2VjdXJlWyBwYXJhbV9rZXkgXTtcclxuXHR9O1xyXG5cclxuXHJcblx0Ly8gQ2FsZW5kYXJzIFx0LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cdHZhciBwX2NhbGVuZGFycyA9IG9iai5jYWxlbmRhcnNfb2JqID0gb2JqLmNhbGVuZGFyc19vYmogfHwge1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQvLyBzb3J0ICAgICAgICAgICAgOiBcImJvb2tpbmdfaWRcIixcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0Ly8gc29ydF90eXBlICAgICAgIDogXCJERVNDXCIsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdC8vIHBhZ2VfbnVtICAgICAgICA6IDEsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdC8vIHBhZ2VfaXRlbXNfY291bnQ6IDEwLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQvLyBjcmVhdGVfZGF0ZSAgICAgOiBcIlwiLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQvLyBrZXl3b3JkICAgICAgICAgOiBcIlwiLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQvLyBzb3VyY2UgICAgICAgICAgOiBcIlwiXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0fTtcclxuXHJcblx0LyoqXHJcblx0ICogIENoZWNrIGlmIGNhbGVuZGFyIGZvciBzcGVjaWZpYyBib29raW5nIHJlc291cmNlIGRlZmluZWQgICA6OiAgIHRydWUgfCBmYWxzZVxyXG5cdCAqXHJcblx0ICogQHBhcmFtIHtzdHJpbmd8aW50fSByZXNvdXJjZV9pZFxyXG5cdCAqIEByZXR1cm5zIHtib29sZWFufVxyXG5cdCAqL1xyXG5cdG9iai5jYWxlbmRhcl9faXNfZGVmaW5lZCA9IGZ1bmN0aW9uICggcmVzb3VyY2VfaWQgKSB7XHJcblxyXG5cdFx0cmV0dXJuICgndW5kZWZpbmVkJyAhPT0gdHlwZW9mKCBwX2NhbGVuZGFyc1sgJ2NhbGVuZGFyXycgKyByZXNvdXJjZV9pZCBdICkgKTtcclxuXHR9O1xyXG5cclxuXHQvKipcclxuXHQgKiAgQ3JlYXRlIENhbGVuZGFyIGluaXRpYWxpemluZ1xyXG5cdCAqXHJcblx0ICogQHBhcmFtIHtzdHJpbmd8aW50fSByZXNvdXJjZV9pZFxyXG5cdCAqL1xyXG5cdG9iai5jYWxlbmRhcl9faW5pdCA9IGZ1bmN0aW9uICggcmVzb3VyY2VfaWQgKSB7XHJcblxyXG5cdFx0cF9jYWxlbmRhcnNbICdjYWxlbmRhcl8nICsgcmVzb3VyY2VfaWQgXSA9IHt9O1xyXG5cdFx0cF9jYWxlbmRhcnNbICdjYWxlbmRhcl8nICsgcmVzb3VyY2VfaWQgXVsgJ2lkJyBdID0gcmVzb3VyY2VfaWQ7XHJcblx0XHRwX2NhbGVuZGFyc1sgJ2NhbGVuZGFyXycgKyByZXNvdXJjZV9pZCBdWyAncGVuZGluZ19kYXlzX3NlbGVjdGFibGUnIF0gPSBmYWxzZTtcclxuXHJcblx0fTtcclxuXHJcblx0LyoqXHJcblx0ICogQ2hlY2sgIGlmIHRoZSB0eXBlIG9mIHRoaXMgcHJvcGVydHkgIGlzIElOVFxyXG5cdCAqIEBwYXJhbSBwcm9wZXJ0eV9uYW1lXHJcblx0ICogQHJldHVybnMge2Jvb2xlYW59XHJcblx0ICovXHJcblx0b2JqLmNhbGVuZGFyX19pc19wcm9wX2ludCA9IGZ1bmN0aW9uICggcHJvcGVydHlfbmFtZSApIHtcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdC8vRml4SW46IDkuOS4wLjI5XHJcblxyXG5cdFx0dmFyIHBfY2FsZW5kYXJfaW50X3Byb3BlcnRpZXMgPSBbJ2R5bmFtaWNfX2RheXNfbWluJywgJ2R5bmFtaWNfX2RheXNfbWF4JywgJ2ZpeGVkX19kYXlzX251bSddO1xyXG5cclxuXHRcdHZhciBpc19pbmNsdWRlID0gcF9jYWxlbmRhcl9pbnRfcHJvcGVydGllcy5pbmNsdWRlcyggcHJvcGVydHlfbmFtZSApO1xyXG5cclxuXHRcdHJldHVybiBpc19pbmNsdWRlO1xyXG5cdH07XHJcblxyXG5cclxuXHQvKipcclxuXHQgKiBTZXQgcGFyYW1zIGZvciBhbGwgIGNhbGVuZGFyc1xyXG5cdCAqXHJcblx0ICogQHBhcmFtIHtvYmplY3R9IGNhbGVuZGFyc19vYmpcdFx0T2JqZWN0IHsgY2FsZW5kYXJfMToge30gfVxyXG5cdCAqIFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCBjYWxlbmRhcl8zOiB7fSwgLi4uIH1cclxuXHQgKi9cclxuXHRvYmouY2FsZW5kYXJzX2FsbF9fc2V0ID0gZnVuY3Rpb24gKCBjYWxlbmRhcnNfb2JqICkge1xyXG5cdFx0cF9jYWxlbmRhcnMgPSBjYWxlbmRhcnNfb2JqO1xyXG5cdH07XHJcblxyXG5cdC8qKlxyXG5cdCAqIEdldCBib29raW5ncyBpbiBhbGwgY2FsZW5kYXJzXHJcblx0ICpcclxuXHQgKiBAcmV0dXJucyB7b2JqZWN0fHt9fVxyXG5cdCAqL1xyXG5cdG9iai5jYWxlbmRhcnNfYWxsX19nZXQgPSBmdW5jdGlvbiAoKSB7XHJcblx0XHRyZXR1cm4gcF9jYWxlbmRhcnM7XHJcblx0fTtcclxuXHJcblx0LyoqXHJcblx0ICogR2V0IGNhbGVuZGFyIG9iamVjdCAgIDo6ICAgeyBpZDogMSwg4oCmIH1cclxuXHQgKlxyXG5cdCAqIEBwYXJhbSB7c3RyaW5nfGludH0gcmVzb3VyY2VfaWRcdFx0XHRcdCAgJzInXHJcblx0ICogQHJldHVybnMge29iamVjdHxib29sZWFufVx0XHRcdFx0XHR7IGlkOiAyICzigKYgfVxyXG5cdCAqL1xyXG5cdG9iai5jYWxlbmRhcl9fZ2V0X3BhcmFtZXRlcnMgPSBmdW5jdGlvbiAoIHJlc291cmNlX2lkICkge1xyXG5cclxuXHRcdGlmICggb2JqLmNhbGVuZGFyX19pc19kZWZpbmVkKCByZXNvdXJjZV9pZCApICl7XHJcblxyXG5cdFx0XHRyZXR1cm4gcF9jYWxlbmRhcnNbICdjYWxlbmRhcl8nICsgcmVzb3VyY2VfaWQgXTtcclxuXHRcdH0gZWxzZSB7XHJcblx0XHRcdHJldHVybiBmYWxzZTtcclxuXHRcdH1cclxuXHR9O1xyXG5cclxuXHQvKipcclxuXHQgKiBTZXQgY2FsZW5kYXIgb2JqZWN0ICAgOjogICB7IGRhdGVzOiAgT2JqZWN0IHsgXCIyMDIzLTA3LTIxXCI6IHvigKZ9LCBcIjIwMjMtMDctMjJcIjoge+KApn0sIFwiMjAyMy0wNy0yM1wiOiB74oCmfSwg4oCmIH1cclxuXHQgKlxyXG5cdCAqIGlmIGNhbGVuZGFyIG9iamVjdCAgbm90IGRlZmluZWQsIHRoZW4gIGl0J3Mgd2lsbCBiZSBkZWZpbmVkIGFuZCBJRCBzZXRcclxuXHQgKiBpZiBjYWxlbmRhciBleGlzdCwgdGhlbiAgc3lzdGVtIHNldCAgYXMgbmV3IG9yIG92ZXJ3cml0ZSBvbmx5IHByb3BlcnRpZXMgZnJvbSBjYWxlbmRhcl9wcm9wZXJ0eV9vYmogcGFyYW1ldGVyLCAgYnV0IG90aGVyIHByb3BlcnRpZXMgd2lsbCBiZSBleGlzdGVkIGFuZCBub3Qgb3ZlcndyaXRlLCBsaWtlICdpZCdcclxuXHQgKlxyXG5cdCAqIEBwYXJhbSB7c3RyaW5nfGludH0gcmVzb3VyY2VfaWRcdFx0XHRcdCAgJzInXHJcblx0ICogQHBhcmFtIHtvYmplY3R9IGNhbGVuZGFyX3Byb3BlcnR5X29ialx0XHRcdFx0XHQgIHsgIGRhdGVzOiAgT2JqZWN0IHsgXCIyMDIzLTA3LTIxXCI6IHvigKZ9LCBcIjIwMjMtMDctMjJcIjoge+KApn0sIFwiMjAyMy0wNy0yM1wiOiB74oCmfSwg4oCmIH0gIH1cclxuXHQgKiBAcGFyYW0ge2Jvb2xlYW59IGlzX2NvbXBsZXRlX292ZXJ3cml0ZVx0XHQgIGlmICd0cnVlJyAoZGVmYXVsdDogJ2ZhbHNlJyksICB0aGVuICBvbmx5IG92ZXJ3cml0ZSBvciBhZGQgIG5ldyBwcm9wZXJ0aWVzIGluICBjYWxlbmRhcl9wcm9wZXJ0eV9vYmpcclxuXHQgKiBAcmV0dXJucyB7Kn1cclxuXHQgKlxyXG5cdCAqIEV4YW1wbGVzOlxyXG5cdCAqXHJcblx0ICogQ29tbW9uIHVzYWdlIGluIFBIUDpcclxuXHQgKiAgIFx0XHRcdGVjaG8gXCIgIF93cGJjLmNhbGVuZGFyX19zZXQoICBcIiAuaW50dmFsKCAkcmVzb3VyY2VfaWQgKSAuIFwiLCB7ICdkYXRlcyc6IFwiIC4gd3BfanNvbl9lbmNvZGUoICRhdmFpbGFiaWxpdHlfcGVyX2RheXNfYXJyICkgLiBcIiB9ICk7XCI7XHJcblx0ICovXHJcblx0b2JqLmNhbGVuZGFyX19zZXRfcGFyYW1ldGVycyA9IGZ1bmN0aW9uICggcmVzb3VyY2VfaWQsIGNhbGVuZGFyX3Byb3BlcnR5X29iaiwgaXNfY29tcGxldGVfb3ZlcndyaXRlID0gZmFsc2UgICkge1xyXG5cclxuXHRcdGlmICggKCFvYmouY2FsZW5kYXJfX2lzX2RlZmluZWQoIHJlc291cmNlX2lkICkpIHx8ICh0cnVlID09PSBpc19jb21wbGV0ZV9vdmVyd3JpdGUpICl7XHJcblx0XHRcdG9iai5jYWxlbmRhcl9faW5pdCggcmVzb3VyY2VfaWQgKTtcclxuXHRcdH1cclxuXHJcblx0XHRmb3IgKCB2YXIgcHJvcF9uYW1lIGluIGNhbGVuZGFyX3Byb3BlcnR5X29iaiApe1xyXG5cclxuXHRcdFx0cF9jYWxlbmRhcnNbICdjYWxlbmRhcl8nICsgcmVzb3VyY2VfaWQgXVsgcHJvcF9uYW1lIF0gPSBjYWxlbmRhcl9wcm9wZXJ0eV9vYmpbIHByb3BfbmFtZSBdO1xyXG5cdFx0fVxyXG5cclxuXHRcdHJldHVybiBwX2NhbGVuZGFyc1sgJ2NhbGVuZGFyXycgKyByZXNvdXJjZV9pZCBdO1xyXG5cdH07XHJcblxyXG5cdC8qKlxyXG5cdCAqIFNldCBwcm9wZXJ0eSAgdG8gIGNhbGVuZGFyXHJcblx0ICogQHBhcmFtIHJlc291cmNlX2lkXHRcIjFcIlxyXG5cdCAqIEBwYXJhbSBwcm9wX25hbWVcdFx0bmFtZSBvZiBwcm9wZXJ0eVxyXG5cdCAqIEBwYXJhbSBwcm9wX3ZhbHVlXHR2YWx1ZSBvZiBwcm9wZXJ0eVxyXG5cdCAqIEByZXR1cm5zIHsqfVx0XHRcdGNhbGVuZGFyIG9iamVjdFxyXG5cdCAqL1xyXG5cdG9iai5jYWxlbmRhcl9fc2V0X3BhcmFtX3ZhbHVlID0gZnVuY3Rpb24gKCByZXNvdXJjZV9pZCwgcHJvcF9uYW1lLCBwcm9wX3ZhbHVlICkge1xyXG5cclxuXHRcdGlmICggKCFvYmouY2FsZW5kYXJfX2lzX2RlZmluZWQoIHJlc291cmNlX2lkICkpICl7XHJcblx0XHRcdG9iai5jYWxlbmRhcl9faW5pdCggcmVzb3VyY2VfaWQgKTtcclxuXHRcdH1cclxuXHJcblx0XHRwX2NhbGVuZGFyc1sgJ2NhbGVuZGFyXycgKyByZXNvdXJjZV9pZCBdWyBwcm9wX25hbWUgXSA9IHByb3BfdmFsdWU7XHJcblxyXG5cdFx0cmV0dXJuIHBfY2FsZW5kYXJzWyAnY2FsZW5kYXJfJyArIHJlc291cmNlX2lkIF07XHJcblx0fTtcclxuXHJcblx0LyoqXHJcblx0ICogIEdldCBjYWxlbmRhciBwcm9wZXJ0eSB2YWx1ZSAgIFx0OjogICBtaXhlZCB8IG51bGxcclxuXHQgKlxyXG5cdCAqIEBwYXJhbSB7c3RyaW5nfGludH0gIHJlc291cmNlX2lkXHRcdCcxJ1xyXG5cdCAqIEBwYXJhbSB7c3RyaW5nfSBwcm9wX25hbWVcdFx0XHQnc2VsZWN0aW9uX21vZGUnXHJcblx0ICogQHJldHVybnMgeyp8bnVsbH1cdFx0XHRcdFx0bWl4ZWQgfCBudWxsXHJcblx0ICovXHJcblx0b2JqLmNhbGVuZGFyX19nZXRfcGFyYW1fdmFsdWUgPSBmdW5jdGlvbiggcmVzb3VyY2VfaWQsIHByb3BfbmFtZSApe1xyXG5cclxuXHRcdGlmIChcclxuXHRcdFx0ICAgKCBvYmouY2FsZW5kYXJfX2lzX2RlZmluZWQoIHJlc291cmNlX2lkICkgKVxyXG5cdFx0XHQmJiAoICd1bmRlZmluZWQnICE9PSB0eXBlb2YgKCBwX2NhbGVuZGFyc1sgJ2NhbGVuZGFyXycgKyByZXNvdXJjZV9pZCBdWyBwcm9wX25hbWUgXSApIClcclxuXHRcdCl7XHJcblx0XHRcdC8vRml4SW46IDkuOS4wLjI5XHJcblx0XHRcdGlmICggb2JqLmNhbGVuZGFyX19pc19wcm9wX2ludCggcHJvcF9uYW1lICkgKXtcclxuXHRcdFx0XHRwX2NhbGVuZGFyc1sgJ2NhbGVuZGFyXycgKyByZXNvdXJjZV9pZCBdWyBwcm9wX25hbWUgXSA9IHBhcnNlSW50KCBwX2NhbGVuZGFyc1sgJ2NhbGVuZGFyXycgKyByZXNvdXJjZV9pZCBdWyBwcm9wX25hbWUgXSApO1xyXG5cdFx0XHR9XHJcblx0XHRcdHJldHVybiAgcF9jYWxlbmRhcnNbICdjYWxlbmRhcl8nICsgcmVzb3VyY2VfaWQgXVsgcHJvcF9uYW1lIF07XHJcblx0XHR9XHJcblxyXG5cdFx0cmV0dXJuIG51bGw7XHRcdC8vIElmIHNvbWUgcHJvcGVydHkgbm90IGRlZmluZWQsIHRoZW4gbnVsbDtcclxuXHR9O1xyXG5cdC8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblxyXG5cclxuXHQvLyBCb29raW5ncyBcdC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHR2YXIgcF9ib29raW5ncyA9IG9iai5ib29raW5nc19vYmogPSBvYmouYm9va2luZ3Nfb2JqIHx8IHtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQvLyBjYWxlbmRhcl8xOiBPYmplY3Qge1xyXG4gXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQvL1x0XHRcdFx0XHRcdCAgIGlkOiAgICAgMVxyXG4gXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQvL1x0XHRcdFx0XHRcdCAsIGRhdGVzOiAgT2JqZWN0IHsgXCIyMDIzLTA3LTIxXCI6IHvigKZ9LCBcIjIwMjMtMDctMjJcIjoge+KApn0sIFwiMjAyMy0wNy0yM1wiOiB74oCmfSwg4oCmXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0Ly8gfVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHR9O1xyXG5cclxuXHQvKipcclxuXHQgKiAgQ2hlY2sgaWYgYm9va2luZ3MgZm9yIHNwZWNpZmljIGJvb2tpbmcgcmVzb3VyY2UgZGVmaW5lZCAgIDo6ICAgdHJ1ZSB8IGZhbHNlXHJcblx0ICpcclxuXHQgKiBAcGFyYW0ge3N0cmluZ3xpbnR9IHJlc291cmNlX2lkXHJcblx0ICogQHJldHVybnMge2Jvb2xlYW59XHJcblx0ICovXHJcblx0b2JqLmJvb2tpbmdzX2luX2NhbGVuZGFyX19pc19kZWZpbmVkID0gZnVuY3Rpb24gKCByZXNvdXJjZV9pZCApIHtcclxuXHJcblx0XHRyZXR1cm4gKCd1bmRlZmluZWQnICE9PSB0eXBlb2YoIHBfYm9va2luZ3NbICdjYWxlbmRhcl8nICsgcmVzb3VyY2VfaWQgXSApICk7XHJcblx0fTtcclxuXHJcblx0LyoqXHJcblx0ICogR2V0IGJvb2tpbmdzIGNhbGVuZGFyIG9iamVjdCAgIDo6ICAgeyBpZDogMSAsIGRhdGVzOiAgT2JqZWN0IHsgXCIyMDIzLTA3LTIxXCI6IHvigKZ9LCBcIjIwMjMtMDctMjJcIjoge+KApn0sIFwiMjAyMy0wNy0yM1wiOiB74oCmfSwg4oCmIH1cclxuXHQgKlxyXG5cdCAqIEBwYXJhbSB7c3RyaW5nfGludH0gcmVzb3VyY2VfaWRcdFx0XHRcdCAgJzInXHJcblx0ICogQHJldHVybnMge29iamVjdHxib29sZWFufVx0XHRcdFx0XHR7IGlkOiAyICwgZGF0ZXM6ICBPYmplY3QgeyBcIjIwMjMtMDctMjFcIjoge+KApn0sIFwiMjAyMy0wNy0yMlwiOiB74oCmfSwgXCIyMDIzLTA3LTIzXCI6IHvigKZ9LCDigKYgfVxyXG5cdCAqL1xyXG5cdG9iai5ib29raW5nc19pbl9jYWxlbmRhcl9fZ2V0ID0gZnVuY3Rpb24oIHJlc291cmNlX2lkICl7XHJcblxyXG5cdFx0aWYgKCBvYmouYm9va2luZ3NfaW5fY2FsZW5kYXJfX2lzX2RlZmluZWQoIHJlc291cmNlX2lkICkgKXtcclxuXHJcblx0XHRcdHJldHVybiBwX2Jvb2tpbmdzWyAnY2FsZW5kYXJfJyArIHJlc291cmNlX2lkIF07XHJcblx0XHR9IGVsc2Uge1xyXG5cdFx0XHRyZXR1cm4gZmFsc2U7XHJcblx0XHR9XHJcblx0fTtcclxuXHJcblx0LyoqXHJcblx0ICogU2V0IGJvb2tpbmdzIGNhbGVuZGFyIG9iamVjdCAgIDo6ICAgeyBkYXRlczogIE9iamVjdCB7IFwiMjAyMy0wNy0yMVwiOiB74oCmfSwgXCIyMDIzLTA3LTIyXCI6IHvigKZ9LCBcIjIwMjMtMDctMjNcIjoge+KApn0sIOKApiB9XHJcblx0ICpcclxuXHQgKiBpZiBjYWxlbmRhciBvYmplY3QgIG5vdCBkZWZpbmVkLCB0aGVuICBpdCdzIHdpbGwgYmUgZGVmaW5lZCBhbmQgSUQgc2V0XHJcblx0ICogaWYgY2FsZW5kYXIgZXhpc3QsIHRoZW4gIHN5c3RlbSBzZXQgIGFzIG5ldyBvciBvdmVyd3JpdGUgb25seSBwcm9wZXJ0aWVzIGZyb20gY2FsZW5kYXJfb2JqIHBhcmFtZXRlciwgIGJ1dCBvdGhlciBwcm9wZXJ0aWVzIHdpbGwgYmUgZXhpc3RlZCBhbmQgbm90IG92ZXJ3cml0ZSwgbGlrZSAnaWQnXHJcblx0ICpcclxuXHQgKiBAcGFyYW0ge3N0cmluZ3xpbnR9IHJlc291cmNlX2lkXHRcdFx0XHQgICcyJ1xyXG5cdCAqIEBwYXJhbSB7b2JqZWN0fSBjYWxlbmRhcl9vYmpcdFx0XHRcdFx0ICB7ICBkYXRlczogIE9iamVjdCB7IFwiMjAyMy0wNy0yMVwiOiB74oCmfSwgXCIyMDIzLTA3LTIyXCI6IHvigKZ9LCBcIjIwMjMtMDctMjNcIjoge+KApn0sIOKApiB9ICB9XHJcblx0ICogQHJldHVybnMgeyp9XHJcblx0ICpcclxuXHQgKiBFeGFtcGxlczpcclxuXHQgKlxyXG5cdCAqIENvbW1vbiB1c2FnZSBpbiBQSFA6XHJcblx0ICogICBcdFx0XHRlY2hvIFwiICBfd3BiYy5ib29raW5nc19pbl9jYWxlbmRhcl9fc2V0KCAgXCIgLmludHZhbCggJHJlc291cmNlX2lkICkgLiBcIiwgeyAnZGF0ZXMnOiBcIiAuIHdwX2pzb25fZW5jb2RlKCAkYXZhaWxhYmlsaXR5X3Blcl9kYXlzX2FyciApIC4gXCIgfSApO1wiO1xyXG5cdCAqL1xyXG5cdG9iai5ib29raW5nc19pbl9jYWxlbmRhcl9fc2V0ID0gZnVuY3Rpb24oIHJlc291cmNlX2lkLCBjYWxlbmRhcl9vYmogKXtcclxuXHJcblx0XHRpZiAoICEgb2JqLmJvb2tpbmdzX2luX2NhbGVuZGFyX19pc19kZWZpbmVkKCByZXNvdXJjZV9pZCApICl7XHJcblx0XHRcdHBfYm9va2luZ3NbICdjYWxlbmRhcl8nICsgcmVzb3VyY2VfaWQgXSA9IHt9O1xyXG5cdFx0XHRwX2Jvb2tpbmdzWyAnY2FsZW5kYXJfJyArIHJlc291cmNlX2lkIF1bICdpZCcgXSA9IHJlc291cmNlX2lkO1xyXG5cdFx0fVxyXG5cclxuXHRcdGZvciAoIHZhciBwcm9wX25hbWUgaW4gY2FsZW5kYXJfb2JqICl7XHJcblxyXG5cdFx0XHRwX2Jvb2tpbmdzWyAnY2FsZW5kYXJfJyArIHJlc291cmNlX2lkIF1bIHByb3BfbmFtZSBdID0gY2FsZW5kYXJfb2JqWyBwcm9wX25hbWUgXTtcclxuXHRcdH1cclxuXHJcblx0XHRyZXR1cm4gcF9ib29raW5nc1sgJ2NhbGVuZGFyXycgKyByZXNvdXJjZV9pZCBdO1xyXG5cdH07XHJcblxyXG5cdC8vIERhdGVzXHJcblxyXG5cdC8qKlxyXG5cdCAqICBHZXQgYm9va2luZ3MgZGF0YSBmb3IgQUxMIERhdGVzIGluIGNhbGVuZGFyICAgOjogICBmYWxzZSB8IHsgXCIyMDIzLTA3LTIyXCI6IHvigKZ9LCBcIjIwMjMtMDctMjNcIjoge+KApn0sIOKApiB9XHJcblx0ICpcclxuXHQgKiBAcGFyYW0ge3N0cmluZ3xpbnR9IHJlc291cmNlX2lkXHRcdFx0JzEnXHJcblx0ICogQHJldHVybnMge29iamVjdHxib29sZWFufVx0XHRcdFx0ZmFsc2UgfCBPYmplY3Qge1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFwiMjAyMy0wNy0yNFwiOiBPYmplY3QgeyBbJ3N1bW1hcnknXVsnc3RhdHVzX2Zvcl9kYXknXTogXCJhdmFpbGFibGVcIiwgZGF5X2F2YWlsYWJpbGl0eTogMSwgbWF4X2NhcGFjaXR5OiAxLCDigKYgfVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFwiMjAyMy0wNy0yNlwiOiBPYmplY3QgeyBbJ3N1bW1hcnknXVsnc3RhdHVzX2Zvcl9kYXknXTogXCJmdWxsX2RheV9ib29raW5nXCIsIFsnc3VtbWFyeSddWydzdGF0dXNfZm9yX2Jvb2tpbmdzJ106IFwicGVuZGluZ1wiLCBkYXlfYXZhaWxhYmlsaXR5OiAwLCDigKYgfVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFwiMjAyMy0wNy0yOVwiOiBPYmplY3QgeyBbJ3N1bW1hcnknXVsnc3RhdHVzX2Zvcl9kYXknXTogXCJyZXNvdXJjZV9hdmFpbGFiaWxpdHlcIiwgZGF5X2F2YWlsYWJpbGl0eTogMCwgbWF4X2NhcGFjaXR5OiAxLCDigKYgfVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFwiMjAyMy0wNy0zMFwiOiB74oCmfSwgXCIyMDIzLTA3LTMxXCI6IHvigKZ9LCDigKZcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0fVxyXG5cdCAqL1xyXG5cdG9iai5ib29raW5nc19pbl9jYWxlbmRhcl9fZ2V0X2RhdGVzID0gZnVuY3Rpb24oIHJlc291cmNlX2lkKXtcclxuXHJcblx0XHRpZiAoXHJcblx0XHRcdCAgICggb2JqLmJvb2tpbmdzX2luX2NhbGVuZGFyX19pc19kZWZpbmVkKCByZXNvdXJjZV9pZCApIClcclxuXHRcdFx0JiYgKCAndW5kZWZpbmVkJyAhPT0gdHlwZW9mICggcF9ib29raW5nc1sgJ2NhbGVuZGFyXycgKyByZXNvdXJjZV9pZCBdWyAnZGF0ZXMnIF0gKSApXHJcblx0XHQpe1xyXG5cdFx0XHRyZXR1cm4gIHBfYm9va2luZ3NbICdjYWxlbmRhcl8nICsgcmVzb3VyY2VfaWQgXVsgJ2RhdGVzJyBdO1xyXG5cdFx0fVxyXG5cclxuXHRcdHJldHVybiBmYWxzZTtcdFx0Ly8gSWYgc29tZSBwcm9wZXJ0eSBub3QgZGVmaW5lZCwgdGhlbiBmYWxzZTtcclxuXHR9O1xyXG5cclxuXHQvKipcclxuXHQgKiBTZXQgYm9va2luZ3MgZGF0ZXMgaW4gY2FsZW5kYXIgb2JqZWN0ICAgOjogICAgeyBcIjIwMjMtMDctMjFcIjoge+KApn0sIFwiMjAyMy0wNy0yMlwiOiB74oCmfSwgXCIyMDIzLTA3LTIzXCI6IHvigKZ9LCDigKYgfVxyXG5cdCAqXHJcblx0ICogaWYgY2FsZW5kYXIgb2JqZWN0ICBub3QgZGVmaW5lZCwgdGhlbiAgaXQncyB3aWxsIGJlIGRlZmluZWQgYW5kICdpZCcsICdkYXRlcycgc2V0XHJcblx0ICogaWYgY2FsZW5kYXIgZXhpc3QsIHRoZW4gc3lzdGVtIGFkZCBhICBuZXcgb3Igb3ZlcndyaXRlIG9ubHkgZGF0ZXMgZnJvbSBkYXRlc19vYmogcGFyYW1ldGVyLFxyXG5cdCAqIGJ1dCBvdGhlciBkYXRlcyBub3QgZnJvbSBwYXJhbWV0ZXIgZGF0ZXNfb2JqIHdpbGwgYmUgZXhpc3RlZCBhbmQgbm90IG92ZXJ3cml0ZS5cclxuXHQgKlxyXG5cdCAqIEBwYXJhbSB7c3RyaW5nfGludH0gcmVzb3VyY2VfaWRcdFx0XHRcdCAgJzInXHJcblx0ICogQHBhcmFtIHtvYmplY3R9IGRhdGVzX29ialx0XHRcdFx0XHQgIHsgXCIyMDIzLTA3LTIxXCI6IHvigKZ9LCBcIjIwMjMtMDctMjJcIjoge+KApn0sIFwiMjAyMy0wNy0yM1wiOiB74oCmfSwg4oCmIH1cclxuXHQgKiBAcGFyYW0ge2Jvb2xlYW59IGlzX2NvbXBsZXRlX292ZXJ3cml0ZVx0XHQgIGlmIGZhbHNlLCAgdGhlbiAgb25seSBvdmVyd3JpdGUgb3IgYWRkICBkYXRlcyBmcm9tIFx0ZGF0ZXNfb2JqXHJcblx0ICogQHJldHVybnMgeyp9XHJcblx0ICpcclxuXHQgKiBFeGFtcGxlczpcclxuXHQgKiAgIFx0XHRcdF93cGJjLmJvb2tpbmdzX2luX2NhbGVuZGFyX19zZXRfZGF0ZXMoIHJlc291cmNlX2lkLCB7IFwiMjAyMy0wNy0yMVwiOiB74oCmfSwgXCIyMDIzLTA3LTIyXCI6IHvigKZ9LCDigKYgfSAgKTtcdFx0PC0gICBvdmVyd3JpdGUgQUxMIGRhdGVzXHJcblx0ICogICBcdFx0XHRfd3BiYy5ib29raW5nc19pbl9jYWxlbmRhcl9fc2V0X2RhdGVzKCByZXNvdXJjZV9pZCwgeyBcIjIwMjMtMDctMjJcIjoge+KApn0gfSwgIGZhbHNlICApO1x0XHRcdFx0XHQ8LSAgIGFkZCBvciBvdmVyd3JpdGUgb25seSAgXHRcIjIwMjMtMDctMjJcIjoge31cclxuXHQgKlxyXG5cdCAqIENvbW1vbiB1c2FnZSBpbiBQSFA6XHJcblx0ICogICBcdFx0XHRlY2hvIFwiICBfd3BiYy5ib29raW5nc19pbl9jYWxlbmRhcl9fc2V0X2RhdGVzKCAgXCIgLiBpbnR2YWwoICRyZXNvdXJjZV9pZCApIC4gXCIsICBcIiAuIHdwX2pzb25fZW5jb2RlKCAkYXZhaWxhYmlsaXR5X3Blcl9kYXlzX2FyciApIC4gXCIgICk7ICBcIjtcclxuXHQgKi9cclxuXHRvYmouYm9va2luZ3NfaW5fY2FsZW5kYXJfX3NldF9kYXRlcyA9IGZ1bmN0aW9uKCByZXNvdXJjZV9pZCwgZGF0ZXNfb2JqICwgaXNfY29tcGxldGVfb3ZlcndyaXRlID0gdHJ1ZSApe1xyXG5cclxuXHRcdGlmICggIW9iai5ib29raW5nc19pbl9jYWxlbmRhcl9faXNfZGVmaW5lZCggcmVzb3VyY2VfaWQgKSApe1xyXG5cdFx0XHRvYmouYm9va2luZ3NfaW5fY2FsZW5kYXJfX3NldCggcmVzb3VyY2VfaWQsIHsgJ2RhdGVzJzoge30gfSApO1xyXG5cdFx0fVxyXG5cclxuXHRcdGlmICggJ3VuZGVmaW5lZCcgPT09IHR5cGVvZiAocF9ib29raW5nc1sgJ2NhbGVuZGFyXycgKyByZXNvdXJjZV9pZCBdWyAnZGF0ZXMnIF0pICl7XHJcblx0XHRcdHBfYm9va2luZ3NbICdjYWxlbmRhcl8nICsgcmVzb3VyY2VfaWQgXVsgJ2RhdGVzJyBdID0ge31cclxuXHRcdH1cclxuXHJcblx0XHRpZiAoaXNfY29tcGxldGVfb3ZlcndyaXRlKXtcclxuXHJcblx0XHRcdC8vIENvbXBsZXRlIG92ZXJ3cml0ZSBhbGwgIGJvb2tpbmcgZGF0ZXNcclxuXHRcdFx0cF9ib29raW5nc1sgJ2NhbGVuZGFyXycgKyByZXNvdXJjZV9pZCBdWyAnZGF0ZXMnIF0gPSBkYXRlc19vYmo7XHJcblx0XHR9IGVsc2Uge1xyXG5cclxuXHRcdFx0Ly8gQWRkIG9ubHkgIG5ldyBvciBvdmVyd3JpdGUgZXhpc3QgYm9va2luZyBkYXRlcyBmcm9tICBwYXJhbWV0ZXIuIEJvb2tpbmcgZGF0ZXMgbm90IGZyb20gIHBhcmFtZXRlciAgd2lsbCAgYmUgd2l0aG91dCBjaG5hbmdlc1xyXG5cdFx0XHRmb3IgKCB2YXIgcHJvcF9uYW1lIGluIGRhdGVzX29iaiApe1xyXG5cclxuXHRcdFx0XHRwX2Jvb2tpbmdzWyAnY2FsZW5kYXJfJyArIHJlc291cmNlX2lkIF1bJ2RhdGVzJ11bIHByb3BfbmFtZSBdID0gZGF0ZXNfb2JqWyBwcm9wX25hbWUgXTtcclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cclxuXHRcdHJldHVybiBwX2Jvb2tpbmdzWyAnY2FsZW5kYXJfJyArIHJlc291cmNlX2lkIF07XHJcblx0fTtcclxuXHJcblxyXG5cdC8qKlxyXG5cdCAqICBHZXQgYm9va2luZ3MgZGF0YSBmb3Igc3BlY2lmaWMgZGF0ZSBpbiBjYWxlbmRhciAgIDo6ICAgZmFsc2UgfCB7IGRheV9hdmFpbGFiaWxpdHk6IDEsIC4uLiB9XHJcblx0ICpcclxuXHQgKiBAcGFyYW0ge3N0cmluZ3xpbnR9IHJlc291cmNlX2lkXHRcdFx0JzEnXHJcblx0ICogQHBhcmFtIHtzdHJpbmd9IHNxbF9jbGFzc19kYXlcdFx0XHQnMjAyMy0wNy0yMSdcclxuXHQgKiBAcmV0dXJucyB7b2JqZWN0fGJvb2xlYW59XHRcdFx0XHRmYWxzZSB8IHtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0ZGF5X2F2YWlsYWJpbGl0eTogNFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRtYXhfY2FwYWNpdHk6IDRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQvLyAgPj0gQnVzaW5lc3MgTGFyZ2VcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0MjogT2JqZWN0IHsgaXNfZGF5X3VuYXZhaWxhYmxlOiBmYWxzZSwgX2RheV9zdGF0dXM6IFwiYXZhaWxhYmxlXCIgfVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQxMDogT2JqZWN0IHsgaXNfZGF5X3VuYXZhaWxhYmxlOiBmYWxzZSwgX2RheV9zdGF0dXM6IFwiYXZhaWxhYmxlXCIgfVx0XHQvLyAgPj0gQnVzaW5lc3MgTGFyZ2UgLi4uXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdDExOiBPYmplY3QgeyBpc19kYXlfdW5hdmFpbGFibGU6IGZhbHNlLCBfZGF5X3N0YXR1czogXCJhdmFpbGFibGVcIiB9XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdDEyOiBPYmplY3QgeyBpc19kYXlfdW5hdmFpbGFibGU6IGZhbHNlLCBfZGF5X3N0YXR1czogXCJhdmFpbGFibGVcIiB9XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHR9XHJcblx0ICovXHJcblx0b2JqLmJvb2tpbmdzX2luX2NhbGVuZGFyX19nZXRfZm9yX2RhdGUgPSBmdW5jdGlvbiggcmVzb3VyY2VfaWQsIHNxbF9jbGFzc19kYXkgKXtcclxuXHJcblx0XHRpZiAoXHJcblx0XHRcdCAgICggb2JqLmJvb2tpbmdzX2luX2NhbGVuZGFyX19pc19kZWZpbmVkKCByZXNvdXJjZV9pZCApIClcclxuXHRcdFx0JiYgKCAndW5kZWZpbmVkJyAhPT0gdHlwZW9mICggcF9ib29raW5nc1sgJ2NhbGVuZGFyXycgKyByZXNvdXJjZV9pZCBdWyAnZGF0ZXMnIF0gKSApXHJcblx0XHRcdCYmICggJ3VuZGVmaW5lZCcgIT09IHR5cGVvZiAoIHBfYm9va2luZ3NbICdjYWxlbmRhcl8nICsgcmVzb3VyY2VfaWQgXVsgJ2RhdGVzJyBdWyBzcWxfY2xhc3NfZGF5IF0gKSApXHJcblx0XHQpe1xyXG5cdFx0XHRyZXR1cm4gIHBfYm9va2luZ3NbICdjYWxlbmRhcl8nICsgcmVzb3VyY2VfaWQgXVsgJ2RhdGVzJyBdWyBzcWxfY2xhc3NfZGF5IF07XHJcblx0XHR9XHJcblxyXG5cdFx0cmV0dXJuIGZhbHNlO1x0XHQvLyBJZiBzb21lIHByb3BlcnR5IG5vdCBkZWZpbmVkLCB0aGVuIGZhbHNlO1xyXG5cdH07XHJcblxyXG5cclxuXHQvLyBBbnkgIFBBUkFNUyAgIGluIGJvb2tpbmdzXHJcblxyXG5cdC8qKlxyXG5cdCAqIFNldCBwcm9wZXJ0eSAgdG8gIGJvb2tpbmdcclxuXHQgKiBAcGFyYW0gcmVzb3VyY2VfaWRcdFwiMVwiXHJcblx0ICogQHBhcmFtIHByb3BfbmFtZVx0XHRuYW1lIG9mIHByb3BlcnR5XHJcblx0ICogQHBhcmFtIHByb3BfdmFsdWVcdHZhbHVlIG9mIHByb3BlcnR5XHJcblx0ICogQHJldHVybnMgeyp9XHRcdFx0Ym9va2luZyBvYmplY3RcclxuXHQgKi9cclxuXHRvYmouYm9va2luZ19fc2V0X3BhcmFtX3ZhbHVlID0gZnVuY3Rpb24gKCByZXNvdXJjZV9pZCwgcHJvcF9uYW1lLCBwcm9wX3ZhbHVlICkge1xyXG5cclxuXHRcdGlmICggISBvYmouYm9va2luZ3NfaW5fY2FsZW5kYXJfX2lzX2RlZmluZWQoIHJlc291cmNlX2lkICkgKXtcclxuXHRcdFx0cF9ib29raW5nc1sgJ2NhbGVuZGFyXycgKyByZXNvdXJjZV9pZCBdID0ge307XHJcblx0XHRcdHBfYm9va2luZ3NbICdjYWxlbmRhcl8nICsgcmVzb3VyY2VfaWQgXVsgJ2lkJyBdID0gcmVzb3VyY2VfaWQ7XHJcblx0XHR9XHJcblxyXG5cdFx0cF9ib29raW5nc1sgJ2NhbGVuZGFyXycgKyByZXNvdXJjZV9pZCBdWyBwcm9wX25hbWUgXSA9IHByb3BfdmFsdWU7XHJcblxyXG5cdFx0cmV0dXJuIHBfYm9va2luZ3NbICdjYWxlbmRhcl8nICsgcmVzb3VyY2VfaWQgXTtcclxuXHR9O1xyXG5cclxuXHQvKipcclxuXHQgKiAgR2V0IGJvb2tpbmcgcHJvcGVydHkgdmFsdWUgICBcdDo6ICAgbWl4ZWQgfCBudWxsXHJcblx0ICpcclxuXHQgKiBAcGFyYW0ge3N0cmluZ3xpbnR9ICByZXNvdXJjZV9pZFx0XHQnMSdcclxuXHQgKiBAcGFyYW0ge3N0cmluZ30gcHJvcF9uYW1lXHRcdFx0J3NlbGVjdGlvbl9tb2RlJ1xyXG5cdCAqIEByZXR1cm5zIHsqfG51bGx9XHRcdFx0XHRcdG1peGVkIHwgbnVsbFxyXG5cdCAqL1xyXG5cdG9iai5ib29raW5nX19nZXRfcGFyYW1fdmFsdWUgPSBmdW5jdGlvbiggcmVzb3VyY2VfaWQsIHByb3BfbmFtZSApe1xyXG5cclxuXHRcdGlmIChcclxuXHRcdFx0ICAgKCBvYmouYm9va2luZ3NfaW5fY2FsZW5kYXJfX2lzX2RlZmluZWQoIHJlc291cmNlX2lkICkgKVxyXG5cdFx0XHQmJiAoICd1bmRlZmluZWQnICE9PSB0eXBlb2YgKCBwX2Jvb2tpbmdzWyAnY2FsZW5kYXJfJyArIHJlc291cmNlX2lkIF1bIHByb3BfbmFtZSBdICkgKVxyXG5cdFx0KXtcclxuXHRcdFx0cmV0dXJuICBwX2Jvb2tpbmdzWyAnY2FsZW5kYXJfJyArIHJlc291cmNlX2lkIF1bIHByb3BfbmFtZSBdO1xyXG5cdFx0fVxyXG5cclxuXHRcdHJldHVybiBudWxsO1x0XHQvLyBJZiBzb21lIHByb3BlcnR5IG5vdCBkZWZpbmVkLCB0aGVuIG51bGw7XHJcblx0fTtcclxuXHJcblxyXG5cclxuXHJcblx0LyoqXHJcblx0ICogU2V0IGJvb2tpbmdzIGZvciBhbGwgIGNhbGVuZGFyc1xyXG5cdCAqXHJcblx0ICogQHBhcmFtIHtvYmplY3R9IGNhbGVuZGFyc19vYmpcdFx0T2JqZWN0IHsgY2FsZW5kYXJfMTogeyBpZDogMSwgZGF0ZXM6IE9iamVjdCB7IFwiMjAyMy0wNy0yMlwiOiB74oCmfSwgXCIyMDIzLTA3LTIzXCI6IHvigKZ9LCBcIjIwMjMtMDctMjRcIjoge+KApn0sIOKApiB9IH1cclxuXHQgKiBcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQgY2FsZW5kYXJfMzoge30sIC4uLiB9XHJcblx0ICovXHJcblx0b2JqLmJvb2tpbmdzX2luX2NhbGVuZGFyc19fc2V0X2FsbCA9IGZ1bmN0aW9uICggY2FsZW5kYXJzX29iaiApIHtcclxuXHRcdHBfYm9va2luZ3MgPSBjYWxlbmRhcnNfb2JqO1xyXG5cdH07XHJcblxyXG5cdC8qKlxyXG5cdCAqIEdldCBib29raW5ncyBpbiBhbGwgY2FsZW5kYXJzXHJcblx0ICpcclxuXHQgKiBAcmV0dXJucyB7b2JqZWN0fHt9fVxyXG5cdCAqL1xyXG5cdG9iai5ib29raW5nc19pbl9jYWxlbmRhcnNfX2dldF9hbGwgPSBmdW5jdGlvbiAoKSB7XHJcblx0XHRyZXR1cm4gcF9ib29raW5ncztcclxuXHR9O1xyXG5cdC8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblxyXG5cclxuXHJcblxyXG5cdC8vIFNlYXNvbnMgXHQtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblx0dmFyIHBfc2Vhc29ucyA9IG9iai5zZWFzb25zX29iaiA9IG9iai5zZWFzb25zX29iaiB8fCB7XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0Ly8gY2FsZW5kYXJfMTogT2JqZWN0IHtcclxuIFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0Ly9cdFx0XHRcdFx0XHQgICBpZDogICAgIDFcclxuIFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0Ly9cdFx0XHRcdFx0XHQgLCBkYXRlczogIE9iamVjdCB7IFwiMjAyMy0wNy0yMVwiOiB74oCmfSwgXCIyMDIzLTA3LTIyXCI6IHvigKZ9LCBcIjIwMjMtMDctMjNcIjoge+KApn0sIOKAplxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdC8vIH1cclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0fTtcclxuXHJcblx0LyoqXHJcblx0ICogQWRkIHNlYXNvbiBuYW1lcyBmb3IgZGF0ZXMgaW4gY2FsZW5kYXIgb2JqZWN0ICAgOjogICAgeyBcIjIwMjMtMDctMjFcIjogWyAnd3BiY19zZWFzb25fc2VwdGVtYmVyXzIwMjMnLCAnd3BiY19zZWFzb25fc2VwdGVtYmVyXzIwMjQnIF0sIFwiMjAyMy0wNy0yMlwiOiBbLi4uXSwgLi4uIH1cclxuXHQgKlxyXG5cdCAqXHJcblx0ICogQHBhcmFtIHtzdHJpbmd8aW50fSByZXNvdXJjZV9pZFx0XHRcdFx0ICAnMidcclxuXHQgKiBAcGFyYW0ge29iamVjdH0gZGF0ZXNfb2JqXHRcdFx0XHRcdCAgeyBcIjIwMjMtMDctMjFcIjoge+KApn0sIFwiMjAyMy0wNy0yMlwiOiB74oCmfSwgXCIyMDIzLTA3LTIzXCI6IHvigKZ9LCDigKYgfVxyXG5cdCAqIEBwYXJhbSB7Ym9vbGVhbn0gaXNfY29tcGxldGVfb3ZlcndyaXRlXHRcdCAgaWYgZmFsc2UsICB0aGVuICBvbmx5ICBhZGQgIGRhdGVzIGZyb20gXHRkYXRlc19vYmpcclxuXHQgKiBAcmV0dXJucyB7Kn1cclxuXHQgKlxyXG5cdCAqIEV4YW1wbGVzOlxyXG5cdCAqICAgXHRcdFx0X3dwYmMuc2Vhc29uc19fc2V0KCByZXNvdXJjZV9pZCwgeyBcIjIwMjMtMDctMjFcIjogWyAnd3BiY19zZWFzb25fc2VwdGVtYmVyXzIwMjMnLCAnd3BiY19zZWFzb25fc2VwdGVtYmVyXzIwMjQnIF0sIFwiMjAyMy0wNy0yMlwiOiBbLi4uXSwgLi4uIH0gICk7XHJcblx0ICovXHJcblx0b2JqLnNlYXNvbnNfX3NldCA9IGZ1bmN0aW9uKCByZXNvdXJjZV9pZCwgZGF0ZXNfb2JqICwgaXNfY29tcGxldGVfb3ZlcndyaXRlID0gZmFsc2UgKXtcclxuXHJcblx0XHRpZiAoICd1bmRlZmluZWQnID09PSB0eXBlb2YgKHBfc2Vhc29uc1sgJ2NhbGVuZGFyXycgKyByZXNvdXJjZV9pZCBdKSApe1xyXG5cdFx0XHRwX3NlYXNvbnNbICdjYWxlbmRhcl8nICsgcmVzb3VyY2VfaWQgXSA9IHt9O1xyXG5cdFx0fVxyXG5cclxuXHRcdGlmICggaXNfY29tcGxldGVfb3ZlcndyaXRlICl7XHJcblxyXG5cdFx0XHQvLyBDb21wbGV0ZSBvdmVyd3JpdGUgYWxsICBzZWFzb24gZGF0ZXNcclxuXHRcdFx0cF9zZWFzb25zWyAnY2FsZW5kYXJfJyArIHJlc291cmNlX2lkIF0gPSBkYXRlc19vYmo7XHJcblxyXG5cdFx0fSBlbHNlIHtcclxuXHJcblx0XHRcdC8vIEFkZCBvbmx5ICBuZXcgb3Igb3ZlcndyaXRlIGV4aXN0IGJvb2tpbmcgZGF0ZXMgZnJvbSAgcGFyYW1ldGVyLiBCb29raW5nIGRhdGVzIG5vdCBmcm9tICBwYXJhbWV0ZXIgIHdpbGwgIGJlIHdpdGhvdXQgY2huYW5nZXNcclxuXHRcdFx0Zm9yICggdmFyIHByb3BfbmFtZSBpbiBkYXRlc19vYmogKXtcclxuXHJcblx0XHRcdFx0aWYgKCAndW5kZWZpbmVkJyA9PT0gdHlwZW9mIChwX3NlYXNvbnNbICdjYWxlbmRhcl8nICsgcmVzb3VyY2VfaWQgXVsgcHJvcF9uYW1lIF0pICl7XHJcblx0XHRcdFx0XHRwX3NlYXNvbnNbICdjYWxlbmRhcl8nICsgcmVzb3VyY2VfaWQgXVsgcHJvcF9uYW1lIF0gPSBbXTtcclxuXHRcdFx0XHR9XHJcblx0XHRcdFx0Zm9yICggdmFyIHNlYXNvbl9uYW1lX2tleSBpbiBkYXRlc19vYmpbIHByb3BfbmFtZSBdICl7XHJcblx0XHRcdFx0XHRwX3NlYXNvbnNbICdjYWxlbmRhcl8nICsgcmVzb3VyY2VfaWQgXVsgcHJvcF9uYW1lIF0ucHVzaCggZGF0ZXNfb2JqWyBwcm9wX25hbWUgXVsgc2Vhc29uX25hbWVfa2V5IF0gKTtcclxuXHRcdFx0XHR9XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHJcblx0XHRyZXR1cm4gcF9zZWFzb25zWyAnY2FsZW5kYXJfJyArIHJlc291cmNlX2lkIF07XHJcblx0fTtcclxuXHJcblxyXG5cdC8qKlxyXG5cdCAqICBHZXQgYm9va2luZ3MgZGF0YSBmb3Igc3BlY2lmaWMgZGF0ZSBpbiBjYWxlbmRhciAgIDo6ICAgW10gfCBbICd3cGJjX3NlYXNvbl9zZXB0ZW1iZXJfMjAyMycsICd3cGJjX3NlYXNvbl9zZXB0ZW1iZXJfMjAyNCcgXVxyXG5cdCAqXHJcblx0ICogQHBhcmFtIHtzdHJpbmd8aW50fSByZXNvdXJjZV9pZFx0XHRcdCcxJ1xyXG5cdCAqIEBwYXJhbSB7c3RyaW5nfSBzcWxfY2xhc3NfZGF5XHRcdFx0JzIwMjMtMDctMjEnXHJcblx0ICogQHJldHVybnMge29iamVjdHxib29sZWFufVx0XHRcdFx0W10gIHwgIFsgJ3dwYmNfc2Vhc29uX3NlcHRlbWJlcl8yMDIzJywgJ3dwYmNfc2Vhc29uX3NlcHRlbWJlcl8yMDI0JyBdXHJcblx0ICovXHJcblx0b2JqLnNlYXNvbnNfX2dldF9mb3JfZGF0ZSA9IGZ1bmN0aW9uKCByZXNvdXJjZV9pZCwgc3FsX2NsYXNzX2RheSApe1xyXG5cclxuXHRcdGlmIChcclxuXHRcdFx0ICAgKCAndW5kZWZpbmVkJyAhPT0gdHlwZW9mICggcF9zZWFzb25zWyAnY2FsZW5kYXJfJyArIHJlc291cmNlX2lkIF0gKSApXHJcblx0XHRcdCYmICggJ3VuZGVmaW5lZCcgIT09IHR5cGVvZiAoIHBfc2Vhc29uc1sgJ2NhbGVuZGFyXycgKyByZXNvdXJjZV9pZCBdWyBzcWxfY2xhc3NfZGF5IF0gKSApXHJcblx0XHQpe1xyXG5cdFx0XHRyZXR1cm4gIHBfc2Vhc29uc1sgJ2NhbGVuZGFyXycgKyByZXNvdXJjZV9pZCBdWyBzcWxfY2xhc3NfZGF5IF07XHJcblx0XHR9XHJcblxyXG5cdFx0cmV0dXJuIFtdO1x0XHQvLyBJZiBub3QgZGVmaW5lZCwgdGhlbiBbXTtcclxuXHR9O1xyXG5cclxuXHJcblx0Ly8gT3RoZXIgcGFyYW1ldGVycyBcdFx0XHQtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHR2YXIgcF9vdGhlciA9IG9iai5vdGhlcl9vYmogPSBvYmoub3RoZXJfb2JqIHx8IHsgfTtcclxuXHJcblx0b2JqLnNldF9vdGhlcl9wYXJhbSA9IGZ1bmN0aW9uICggcGFyYW1fa2V5LCBwYXJhbV92YWwgKSB7XHJcblx0XHRwX290aGVyWyBwYXJhbV9rZXkgXSA9IHBhcmFtX3ZhbDtcclxuXHR9O1xyXG5cclxuXHRvYmouZ2V0X290aGVyX3BhcmFtID0gZnVuY3Rpb24gKCBwYXJhbV9rZXkgKSB7XHJcblx0XHRyZXR1cm4gcF9vdGhlclsgcGFyYW1fa2V5IF07XHJcblx0fTtcclxuXHJcblx0LyoqXHJcblx0ICogR2V0IGFsbCBvdGhlciBwYXJhbXNcclxuXHQgKlxyXG5cdCAqIEByZXR1cm5zIHtvYmplY3R8e319XHJcblx0ICovXHJcblx0b2JqLmdldF9vdGhlcl9wYXJhbV9fYWxsID0gZnVuY3Rpb24gKCkge1xyXG5cdFx0cmV0dXJuIHBfb3RoZXI7XHJcblx0fTtcclxuXHJcblx0Ly8gTWVzc2FnZXMgXHRcdFx0ICAgICAgICAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHR2YXIgcF9tZXNzYWdlcyA9IG9iai5tZXNzYWdlc19vYmogPSBvYmoubWVzc2FnZXNfb2JqIHx8IHsgfTtcclxuXHJcblx0b2JqLnNldF9tZXNzYWdlID0gZnVuY3Rpb24gKCBwYXJhbV9rZXksIHBhcmFtX3ZhbCApIHtcclxuXHRcdHBfbWVzc2FnZXNbIHBhcmFtX2tleSBdID0gcGFyYW1fdmFsO1xyXG5cdH07XHJcblxyXG5cdG9iai5nZXRfbWVzc2FnZSA9IGZ1bmN0aW9uICggcGFyYW1fa2V5ICkge1xyXG5cdFx0cmV0dXJuIHBfbWVzc2FnZXNbIHBhcmFtX2tleSBdO1xyXG5cdH07XHJcblxyXG5cdC8qKlxyXG5cdCAqIEdldCBhbGwgb3RoZXIgcGFyYW1zXHJcblx0ICpcclxuXHQgKiBAcmV0dXJucyB7b2JqZWN0fHt9fVxyXG5cdCAqL1xyXG5cdG9iai5nZXRfbWVzc2FnZXNfX2FsbCA9IGZ1bmN0aW9uICgpIHtcclxuXHRcdHJldHVybiBwX21lc3NhZ2VzO1xyXG5cdH07XHJcblxyXG5cdC8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblxyXG5cdHJldHVybiBvYmo7XHJcblxyXG59KCBfd3BiYyB8fCB7fSwgalF1ZXJ5ICkpO1xyXG4iLCIvKipcclxuICogRXh0ZW5kIF93cGJjIHdpdGggIG5ldyBtZXRob2RzICAgICAgICAvL0ZpeEluOiA5LjguNi4yXHJcbiAqXHJcbiAqIEB0eXBlIHsqfHt9fVxyXG4gKiBAcHJpdmF0ZVxyXG4gKi9cclxuIF93cGJjID0gKGZ1bmN0aW9uICggb2JqLCAkKSB7XHJcblxyXG5cdC8vIExvYWQgQmFsYW5jZXIgXHQtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cclxuXHR2YXIgcF9iYWxhbmNlciA9IG9iai5iYWxhbmNlcl9vYmogPSBvYmouYmFsYW5jZXJfb2JqIHx8IHtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnbWF4X3RocmVhZHMnOiAyLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCdpbl9wcm9jZXNzJyA6IFtdLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCd3YWl0JyAgICAgICA6IFtdXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdH07XHJcblxyXG5cdCAvKipcclxuXHQgICogU2V0ICBtYXggcGFyYWxsZWwgcmVxdWVzdCAgdG8gIGxvYWRcclxuXHQgICpcclxuXHQgICogQHBhcmFtIG1heF90aHJlYWRzXHJcblx0ICAqL1xyXG5cdG9iai5iYWxhbmNlcl9fc2V0X21heF90aHJlYWRzID0gZnVuY3Rpb24gKCBtYXhfdGhyZWFkcyApe1xyXG5cclxuXHRcdHBfYmFsYW5jZXJbICdtYXhfdGhyZWFkcycgXSA9IG1heF90aHJlYWRzO1xyXG5cdH07XHJcblxyXG5cdC8qKlxyXG5cdCAqICBDaGVjayBpZiBiYWxhbmNlciBmb3Igc3BlY2lmaWMgYm9va2luZyByZXNvdXJjZSBkZWZpbmVkICAgOjogICB0cnVlIHwgZmFsc2VcclxuXHQgKlxyXG5cdCAqIEBwYXJhbSB7c3RyaW5nfGludH0gcmVzb3VyY2VfaWRcclxuXHQgKiBAcmV0dXJucyB7Ym9vbGVhbn1cclxuXHQgKi9cclxuXHRvYmouYmFsYW5jZXJfX2lzX2RlZmluZWQgPSBmdW5jdGlvbiAoIHJlc291cmNlX2lkICkge1xyXG5cclxuXHRcdHJldHVybiAoJ3VuZGVmaW5lZCcgIT09IHR5cGVvZiggcF9iYWxhbmNlclsgJ2JhbGFuY2VyXycgKyByZXNvdXJjZV9pZCBdICkgKTtcclxuXHR9O1xyXG5cclxuXHJcblx0LyoqXHJcblx0ICogIENyZWF0ZSBiYWxhbmNlciBpbml0aWFsaXppbmdcclxuXHQgKlxyXG5cdCAqIEBwYXJhbSB7c3RyaW5nfGludH0gcmVzb3VyY2VfaWRcclxuXHQgKi9cclxuXHRvYmouYmFsYW5jZXJfX2luaXQgPSBmdW5jdGlvbiAoIHJlc291cmNlX2lkLCBmdW5jdGlvbl9uYW1lICwgcGFyYW1zID17fSkge1xyXG5cclxuXHRcdHZhciBiYWxhbmNlX29iaiA9IHt9O1xyXG5cdFx0YmFsYW5jZV9vYmpbICdyZXNvdXJjZV9pZCcgXSAgID0gcmVzb3VyY2VfaWQ7XHJcblx0XHRiYWxhbmNlX29ialsgJ3ByaW9yaXR5JyBdICAgICAgPSAxO1xyXG5cdFx0YmFsYW5jZV9vYmpbICdmdW5jdGlvbl9uYW1lJyBdID0gZnVuY3Rpb25fbmFtZTtcclxuXHRcdGJhbGFuY2Vfb2JqWyAncGFyYW1zJyBdICAgICAgICA9IHdwYmNfY2xvbmVfb2JqKCBwYXJhbXMgKTtcclxuXHJcblxyXG5cdFx0aWYgKCBvYmouYmFsYW5jZXJfX2lzX2FscmVhZHlfcnVuKCByZXNvdXJjZV9pZCwgZnVuY3Rpb25fbmFtZSApICl7XHJcblx0XHRcdHJldHVybiAncnVuJztcclxuXHRcdH1cclxuXHRcdGlmICggb2JqLmJhbGFuY2VyX19pc19hbHJlYWR5X3dhaXQoIHJlc291cmNlX2lkLCBmdW5jdGlvbl9uYW1lICkgKXtcclxuXHRcdFx0cmV0dXJuICd3YWl0JztcclxuXHRcdH1cclxuXHJcblxyXG5cdFx0aWYgKCBvYmouYmFsYW5jZXJfX2Nhbl9pX3J1bigpICl7XHJcblx0XHRcdG9iai5iYWxhbmNlcl9fYWRkX3RvX19ydW4oIGJhbGFuY2Vfb2JqICk7XHJcblx0XHRcdHJldHVybiAncnVuJztcclxuXHRcdH0gZWxzZSB7XHJcblx0XHRcdG9iai5iYWxhbmNlcl9fYWRkX3RvX193YWl0KCBiYWxhbmNlX29iaiApO1xyXG5cdFx0XHRyZXR1cm4gJ3dhaXQnO1xyXG5cdFx0fVxyXG5cdH07XHJcblxyXG5cdCAvKipcclxuXHQgICogQ2FuIEkgUnVuID9cclxuXHQgICogQHJldHVybnMge2Jvb2xlYW59XHJcblx0ICAqL1xyXG5cdG9iai5iYWxhbmNlcl9fY2FuX2lfcnVuID0gZnVuY3Rpb24gKCl7XHJcblx0XHRyZXR1cm4gKCBwX2JhbGFuY2VyWyAnaW5fcHJvY2VzcycgXS5sZW5ndGggPCBwX2JhbGFuY2VyWyAnbWF4X3RocmVhZHMnIF0gKTtcclxuXHR9XHJcblxyXG5cdFx0IC8qKlxyXG5cdFx0ICAqIEFkZCB0byBXQUlUXHJcblx0XHQgICogQHBhcmFtIGJhbGFuY2Vfb2JqXHJcblx0XHQgICovXHJcblx0XHRvYmouYmFsYW5jZXJfX2FkZF90b19fd2FpdCA9IGZ1bmN0aW9uICggYmFsYW5jZV9vYmogKSB7XHJcblx0XHRcdHBfYmFsYW5jZXJbJ3dhaXQnXS5wdXNoKCBiYWxhbmNlX29iaiApO1xyXG5cdFx0fVxyXG5cclxuXHRcdCAvKipcclxuXHRcdCAgKiBSZW1vdmUgZnJvbSBXYWl0XHJcblx0XHQgICpcclxuXHRcdCAgKiBAcGFyYW0gcmVzb3VyY2VfaWRcclxuXHRcdCAgKiBAcGFyYW0gZnVuY3Rpb25fbmFtZVxyXG5cdFx0ICAqIEByZXR1cm5zIHsqfGJvb2xlYW59XHJcblx0XHQgICovXHJcblx0XHRvYmouYmFsYW5jZXJfX3JlbW92ZV9mcm9tX193YWl0X2xpc3QgPSBmdW5jdGlvbiAoIHJlc291cmNlX2lkLCBmdW5jdGlvbl9uYW1lICl7XHJcblxyXG5cdFx0XHR2YXIgcmVtb3ZlZF9lbCA9IGZhbHNlO1xyXG5cclxuXHRcdFx0aWYgKCBwX2JhbGFuY2VyWyAnd2FpdCcgXS5sZW5ndGggKXtcdFx0XHRcdFx0Ly9GaXhJbjogOS44LjEwLjFcclxuXHRcdFx0XHRmb3IgKCB2YXIgaSBpbiBwX2JhbGFuY2VyWyAnd2FpdCcgXSApe1xyXG5cdFx0XHRcdFx0aWYgKFxyXG5cdFx0XHRcdFx0XHQocmVzb3VyY2VfaWQgPT09IHBfYmFsYW5jZXJbICd3YWl0JyBdWyBpIF1bICdyZXNvdXJjZV9pZCcgXSlcclxuXHRcdFx0XHRcdFx0JiYgKGZ1bmN0aW9uX25hbWUgPT09IHBfYmFsYW5jZXJbICd3YWl0JyBdWyBpIF1bICdmdW5jdGlvbl9uYW1lJyBdKVxyXG5cdFx0XHRcdFx0KXtcclxuXHRcdFx0XHRcdFx0cmVtb3ZlZF9lbCA9IHBfYmFsYW5jZXJbICd3YWl0JyBdLnNwbGljZSggaSwgMSApO1xyXG5cdFx0XHRcdFx0XHRyZW1vdmVkX2VsID0gcmVtb3ZlZF9lbC5wb3AoKTtcclxuXHRcdFx0XHRcdFx0cF9iYWxhbmNlclsgJ3dhaXQnIF0gPSBwX2JhbGFuY2VyWyAnd2FpdCcgXS5maWx0ZXIoIGZ1bmN0aW9uICggdiApe1xyXG5cdFx0XHRcdFx0XHRcdHJldHVybiB2O1xyXG5cdFx0XHRcdFx0XHR9ICk7XHRcdFx0XHRcdC8vIFJlaW5kZXggYXJyYXlcclxuXHRcdFx0XHRcdFx0cmV0dXJuIHJlbW92ZWRfZWw7XHJcblx0XHRcdFx0XHR9XHJcblx0XHRcdFx0fVxyXG5cdFx0XHR9XHJcblx0XHRcdHJldHVybiByZW1vdmVkX2VsO1xyXG5cdFx0fVxyXG5cclxuXHRcdC8qKlxyXG5cdFx0KiBJcyBhbHJlYWR5IFdBSVRcclxuXHRcdCpcclxuXHRcdCogQHBhcmFtIHJlc291cmNlX2lkXHJcblx0XHQqIEBwYXJhbSBmdW5jdGlvbl9uYW1lXHJcblx0XHQqIEByZXR1cm5zIHtib29sZWFufVxyXG5cdFx0Ki9cclxuXHRcdG9iai5iYWxhbmNlcl9faXNfYWxyZWFkeV93YWl0ID0gZnVuY3Rpb24gKCByZXNvdXJjZV9pZCwgZnVuY3Rpb25fbmFtZSApe1xyXG5cclxuXHRcdFx0aWYgKCBwX2JhbGFuY2VyWyAnd2FpdCcgXS5sZW5ndGggKXtcdFx0XHRcdC8vRml4SW46IDkuOC4xMC4xXHJcblx0XHRcdFx0Zm9yICggdmFyIGkgaW4gcF9iYWxhbmNlclsgJ3dhaXQnIF0gKXtcclxuXHRcdFx0XHRcdGlmIChcclxuXHRcdFx0XHRcdFx0KHJlc291cmNlX2lkID09PSBwX2JhbGFuY2VyWyAnd2FpdCcgXVsgaSBdWyAncmVzb3VyY2VfaWQnIF0pXHJcblx0XHRcdFx0XHRcdCYmIChmdW5jdGlvbl9uYW1lID09PSBwX2JhbGFuY2VyWyAnd2FpdCcgXVsgaSBdWyAnZnVuY3Rpb25fbmFtZScgXSlcclxuXHRcdFx0XHRcdCl7XHJcblx0XHRcdFx0XHRcdHJldHVybiB0cnVlO1xyXG5cdFx0XHRcdFx0fVxyXG5cdFx0XHRcdH1cclxuXHRcdFx0fVxyXG5cdFx0XHRyZXR1cm4gZmFsc2U7XHJcblx0XHR9XHJcblxyXG5cclxuXHRcdCAvKipcclxuXHRcdCAgKiBBZGQgdG8gUlVOXHJcblx0XHQgICogQHBhcmFtIGJhbGFuY2Vfb2JqXHJcblx0XHQgICovXHJcblx0XHRvYmouYmFsYW5jZXJfX2FkZF90b19fcnVuID0gZnVuY3Rpb24gKCBiYWxhbmNlX29iaiApIHtcclxuXHRcdFx0cF9iYWxhbmNlclsnaW5fcHJvY2VzcyddLnB1c2goIGJhbGFuY2Vfb2JqICk7XHJcblx0XHR9XHJcblxyXG5cdFx0LyoqXHJcblx0XHQqIFJlbW92ZSBmcm9tIFJVTiBsaXN0XHJcblx0XHQqXHJcblx0XHQqIEBwYXJhbSByZXNvdXJjZV9pZFxyXG5cdFx0KiBAcGFyYW0gZnVuY3Rpb25fbmFtZVxyXG5cdFx0KiBAcmV0dXJucyB7Knxib29sZWFufVxyXG5cdFx0Ki9cclxuXHRcdG9iai5iYWxhbmNlcl9fcmVtb3ZlX2Zyb21fX3J1bl9saXN0ID0gZnVuY3Rpb24gKCByZXNvdXJjZV9pZCwgZnVuY3Rpb25fbmFtZSApe1xyXG5cclxuXHRcdFx0IHZhciByZW1vdmVkX2VsID0gZmFsc2U7XHJcblxyXG5cdFx0XHQgaWYgKCBwX2JhbGFuY2VyWyAnaW5fcHJvY2VzcycgXS5sZW5ndGggKXtcdFx0XHRcdC8vRml4SW46IDkuOC4xMC4xXHJcblx0XHRcdFx0IGZvciAoIHZhciBpIGluIHBfYmFsYW5jZXJbICdpbl9wcm9jZXNzJyBdICl7XHJcblx0XHRcdFx0XHQgaWYgKFxyXG5cdFx0XHRcdFx0XHQgKHJlc291cmNlX2lkID09PSBwX2JhbGFuY2VyWyAnaW5fcHJvY2VzcycgXVsgaSBdWyAncmVzb3VyY2VfaWQnIF0pXHJcblx0XHRcdFx0XHRcdCAmJiAoZnVuY3Rpb25fbmFtZSA9PT0gcF9iYWxhbmNlclsgJ2luX3Byb2Nlc3MnIF1bIGkgXVsgJ2Z1bmN0aW9uX25hbWUnIF0pXHJcblx0XHRcdFx0XHQgKXtcclxuXHRcdFx0XHRcdFx0IHJlbW92ZWRfZWwgPSBwX2JhbGFuY2VyWyAnaW5fcHJvY2VzcycgXS5zcGxpY2UoIGksIDEgKTtcclxuXHRcdFx0XHRcdFx0IHJlbW92ZWRfZWwgPSByZW1vdmVkX2VsLnBvcCgpO1xyXG5cdFx0XHRcdFx0XHQgcF9iYWxhbmNlclsgJ2luX3Byb2Nlc3MnIF0gPSBwX2JhbGFuY2VyWyAnaW5fcHJvY2VzcycgXS5maWx0ZXIoIGZ1bmN0aW9uICggdiApe1xyXG5cdFx0XHRcdFx0XHRcdCByZXR1cm4gdjtcclxuXHRcdFx0XHRcdFx0IH0gKTtcdFx0Ly8gUmVpbmRleCBhcnJheVxyXG5cdFx0XHRcdFx0XHQgcmV0dXJuIHJlbW92ZWRfZWw7XHJcblx0XHRcdFx0XHQgfVxyXG5cdFx0XHRcdCB9XHJcblx0XHRcdCB9XHJcblx0XHRcdCByZXR1cm4gcmVtb3ZlZF9lbDtcclxuXHRcdH1cclxuXHJcblx0XHQvKipcclxuXHRcdCogSXMgYWxyZWFkeSBSVU5cclxuXHRcdCpcclxuXHRcdCogQHBhcmFtIHJlc291cmNlX2lkXHJcblx0XHQqIEBwYXJhbSBmdW5jdGlvbl9uYW1lXHJcblx0XHQqIEByZXR1cm5zIHtib29sZWFufVxyXG5cdFx0Ki9cclxuXHRcdG9iai5iYWxhbmNlcl9faXNfYWxyZWFkeV9ydW4gPSBmdW5jdGlvbiAoIHJlc291cmNlX2lkLCBmdW5jdGlvbl9uYW1lICl7XHJcblxyXG5cdFx0XHRpZiAoIHBfYmFsYW5jZXJbICdpbl9wcm9jZXNzJyBdLmxlbmd0aCApe1x0XHRcdFx0XHQvL0ZpeEluOiA5LjguMTAuMVxyXG5cdFx0XHRcdGZvciAoIHZhciBpIGluIHBfYmFsYW5jZXJbICdpbl9wcm9jZXNzJyBdICl7XHJcblx0XHRcdFx0XHRpZiAoXHJcblx0XHRcdFx0XHRcdChyZXNvdXJjZV9pZCA9PT0gcF9iYWxhbmNlclsgJ2luX3Byb2Nlc3MnIF1bIGkgXVsgJ3Jlc291cmNlX2lkJyBdKVxyXG5cdFx0XHRcdFx0XHQmJiAoZnVuY3Rpb25fbmFtZSA9PT0gcF9iYWxhbmNlclsgJ2luX3Byb2Nlc3MnIF1bIGkgXVsgJ2Z1bmN0aW9uX25hbWUnIF0pXHJcblx0XHRcdFx0XHQpe1xyXG5cdFx0XHRcdFx0XHRyZXR1cm4gdHJ1ZTtcclxuXHRcdFx0XHRcdH1cclxuXHRcdFx0XHR9XHJcblx0XHRcdH1cclxuXHRcdFx0cmV0dXJuIGZhbHNlO1xyXG5cdFx0fVxyXG5cclxuXHJcblxyXG5cdG9iai5iYWxhbmNlcl9fcnVuX25leHQgPSBmdW5jdGlvbiAoKXtcclxuXHJcblx0XHQvLyBHZXQgMXN0IGZyb20gIFdhaXQgbGlzdFxyXG5cdFx0dmFyIHJlbW92ZWRfZWwgPSBmYWxzZTtcclxuXHRcdGlmICggcF9iYWxhbmNlclsgJ3dhaXQnIF0ubGVuZ3RoICl7XHRcdFx0XHRcdC8vRml4SW46IDkuOC4xMC4xXHJcblx0XHRcdGZvciAoIHZhciBpIGluIHBfYmFsYW5jZXJbICd3YWl0JyBdICl7XHJcblx0XHRcdFx0cmVtb3ZlZF9lbCA9IG9iai5iYWxhbmNlcl9fcmVtb3ZlX2Zyb21fX3dhaXRfbGlzdCggcF9iYWxhbmNlclsgJ3dhaXQnIF1bIGkgXVsgJ3Jlc291cmNlX2lkJyBdLCBwX2JhbGFuY2VyWyAnd2FpdCcgXVsgaSBdWyAnZnVuY3Rpb25fbmFtZScgXSApO1xyXG5cdFx0XHRcdGJyZWFrO1xyXG5cdFx0XHR9XHJcblx0XHR9XHJcblxyXG5cdFx0aWYgKCBmYWxzZSAhPT0gcmVtb3ZlZF9lbCApe1xyXG5cclxuXHRcdFx0Ly8gUnVuXHJcblx0XHRcdG9iai5iYWxhbmNlcl9fcnVuKCByZW1vdmVkX2VsICk7XHJcblx0XHR9XHJcblx0fVxyXG5cclxuXHQgLyoqXHJcblx0ICAqIFJ1blxyXG5cdCAgKiBAcGFyYW0gYmFsYW5jZV9vYmpcclxuXHQgICovXHJcblx0b2JqLmJhbGFuY2VyX19ydW4gPSBmdW5jdGlvbiAoIGJhbGFuY2Vfb2JqICl7XHJcblxyXG5cdFx0c3dpdGNoICggYmFsYW5jZV9vYmpbICdmdW5jdGlvbl9uYW1lJyBdICl7XHJcblxyXG5cdFx0XHRjYXNlICd3cGJjX2NhbGVuZGFyX19sb2FkX2RhdGFfX2FqeCc6XHJcblxyXG5cdFx0XHRcdC8vIEFkZCB0byBydW4gbGlzdFxyXG5cdFx0XHRcdG9iai5iYWxhbmNlcl9fYWRkX3RvX19ydW4oIGJhbGFuY2Vfb2JqICk7XHJcblxyXG5cdFx0XHRcdHdwYmNfY2FsZW5kYXJfX2xvYWRfZGF0YV9fYWp4KCBiYWxhbmNlX29ialsgJ3BhcmFtcycgXSApXHJcblx0XHRcdFx0YnJlYWs7XHJcblxyXG5cdFx0XHRkZWZhdWx0OlxyXG5cdFx0fVxyXG5cdH1cclxuXHJcblx0cmV0dXJuIG9iajtcclxuXHJcbn0oIF93cGJjIHx8IHt9LCBqUXVlcnkgKSk7XHJcblxyXG5cclxuIFx0LyoqXHJcbiBcdCAqIC0tIEhlbHAgZnVuY3Rpb25zIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHQgKi9cclxuXHJcblx0ZnVuY3Rpb24gd3BiY19iYWxhbmNlcl9faXNfd2FpdCggcGFyYW1zLCBmdW5jdGlvbl9uYW1lICl7XHJcbi8vY29uc29sZS5sb2coJzo6d3BiY19iYWxhbmNlcl9faXNfd2FpdCcscGFyYW1zICwgZnVuY3Rpb25fbmFtZSApO1xyXG5cdFx0aWYgKCAndW5kZWZpbmVkJyAhPT0gdHlwZW9mIChwYXJhbXNbICdyZXNvdXJjZV9pZCcgXSkgKXtcclxuXHJcblx0XHRcdHZhciBiYWxhbmNlcl9zdGF0dXMgPSBfd3BiYy5iYWxhbmNlcl9faW5pdCggcGFyYW1zWyAncmVzb3VyY2VfaWQnIF0sIGZ1bmN0aW9uX25hbWUsIHBhcmFtcyApO1xyXG5cclxuXHRcdFx0cmV0dXJuICggJ3dhaXQnID09PSBiYWxhbmNlcl9zdGF0dXMgKTtcclxuXHRcdH1cclxuXHJcblx0XHRyZXR1cm4gZmFsc2U7XHJcblx0fVxyXG5cclxuXHJcblx0ZnVuY3Rpb24gd3BiY19iYWxhbmNlcl9fY29tcGxldGVkKCByZXNvdXJjZV9pZCAsIGZ1bmN0aW9uX25hbWUgKXtcclxuLy9jb25zb2xlLmxvZygnOjp3cGJjX2JhbGFuY2VyX19jb21wbGV0ZWQnLHJlc291cmNlX2lkICwgZnVuY3Rpb25fbmFtZSApO1xyXG5cdFx0X3dwYmMuYmFsYW5jZXJfX3JlbW92ZV9mcm9tX19ydW5fbGlzdCggcmVzb3VyY2VfaWQsIGZ1bmN0aW9uX25hbWUgKTtcclxuXHRcdF93cGJjLmJhbGFuY2VyX19ydW5fbmV4dCgpO1xyXG5cdH0iLCIvKipcclxuICogPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XHJcbiAqXHRpbmNsdWRlcy9fX2pzL2NhbC93cGJjX2NhbC5qc1xyXG4gKiA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cclxuICovXHJcblxyXG4vKipcclxuICogT3JkZXIgb3IgY2hpbGQgYm9va2luZyByZXNvdXJjZXMgc2F2ZWQgaGVyZTogIFx0X3dwYmMuYm9va2luZ19fZ2V0X3BhcmFtX3ZhbHVlKCByZXNvdXJjZV9pZCwgJ3Jlc291cmNlc19pZF9hcnJfX2luX2RhdGVzJyApXHRcdFsyLDEwLDEyLDExXVxyXG4gKi9cclxuXHJcbi8qKlxyXG4gKiBIb3cgdG8gY2hlY2sgIGJvb2tlZCB0aW1lcyBvbiAgc3BlY2lmaWMgZGF0ZTogP1xyXG4gKlxyXG5cdFx0XHRfd3BiYy5ib29raW5nc19pbl9jYWxlbmRhcl9fZ2V0X2Zvcl9kYXRlKDIsJzIwMjMtMDgtMjEnKTtcclxuXHJcblx0XHRcdGNvbnNvbGUubG9nKFxyXG5cdFx0XHRcdFx0XHRfd3BiYy5ib29raW5nc19pbl9jYWxlbmRhcl9fZ2V0X2Zvcl9kYXRlKDIsJzIwMjMtMDgtMjEnKVsyXS5ib29rZWRfdGltZV9zbG90cy5tZXJnZWRfc2Vjb25kcyxcclxuXHRcdFx0XHRcdFx0X3dwYmMuYm9va2luZ3NfaW5fY2FsZW5kYXJfX2dldF9mb3JfZGF0ZSgyLCcyMDIzLTA4LTIxJylbMTBdLmJvb2tlZF90aW1lX3Nsb3RzLm1lcmdlZF9zZWNvbmRzLFxyXG5cdFx0XHRcdFx0XHRfd3BiYy5ib29raW5nc19pbl9jYWxlbmRhcl9fZ2V0X2Zvcl9kYXRlKDIsJzIwMjMtMDgtMjEnKVsxMV0uYm9va2VkX3RpbWVfc2xvdHMubWVyZ2VkX3NlY29uZHMsXHJcblx0XHRcdFx0XHRcdF93cGJjLmJvb2tpbmdzX2luX2NhbGVuZGFyX19nZXRfZm9yX2RhdGUoMiwnMjAyMy0wOC0yMScpWzEyXS5ib29rZWRfdGltZV9zbG90cy5tZXJnZWRfc2Vjb25kc1xyXG5cdFx0XHRcdFx0KTtcclxuICogIE9SXHJcblx0XHRcdGNvbnNvbGUubG9nKFxyXG5cdFx0XHRcdFx0XHRfd3BiYy5ib29raW5nc19pbl9jYWxlbmRhcl9fZ2V0X2Zvcl9kYXRlKDIsJzIwMjMtMDgtMjEnKVsyXS5ib29rZWRfdGltZV9zbG90cy5tZXJnZWRfcmVhZGFibGUsXHJcblx0XHRcdFx0XHRcdF93cGJjLmJvb2tpbmdzX2luX2NhbGVuZGFyX19nZXRfZm9yX2RhdGUoMiwnMjAyMy0wOC0yMScpWzEwXS5ib29rZWRfdGltZV9zbG90cy5tZXJnZWRfcmVhZGFibGUsXHJcblx0XHRcdFx0XHRcdF93cGJjLmJvb2tpbmdzX2luX2NhbGVuZGFyX19nZXRfZm9yX2RhdGUoMiwnMjAyMy0wOC0yMScpWzExXS5ib29rZWRfdGltZV9zbG90cy5tZXJnZWRfcmVhZGFibGUsXHJcblx0XHRcdFx0XHRcdF93cGJjLmJvb2tpbmdzX2luX2NhbGVuZGFyX19nZXRfZm9yX2RhdGUoMiwnMjAyMy0wOC0yMScpWzEyXS5ib29rZWRfdGltZV9zbG90cy5tZXJnZWRfcmVhZGFibGVcclxuXHRcdFx0XHRcdCk7XHJcbiAqXHJcbiAqL1xyXG5cclxuLyoqXHJcbiAqIERheXMgc2VsZWN0aW9uOlxyXG4gKiBcdFx0XHRcdFx0d3BiY19jYWxlbmRhcl9fdW5zZWxlY3RfYWxsX2RhdGVzKCByZXNvdXJjZV9pZCApO1xyXG4gKlxyXG4gKlx0XHRcdFx0XHR2YXIgcmVzb3VyY2VfaWQgPSAxO1xyXG4gKiBcdEV4YW1wbGUgMTpcdFx0dmFyIG51bV9zZWxlY3RlZF9kYXlzID0gd3BiY19hdXRvX3NlbGVjdF9kYXRlc19pbl9jYWxlbmRhciggcmVzb3VyY2VfaWQsICcyMDI0LTA1LTE1JywgJzIwMjQtMDUtMjUnICk7XHJcbiAqIFx0RXhhbXBsZSAyOlx0XHR2YXIgbnVtX3NlbGVjdGVkX2RheXMgPSB3cGJjX2F1dG9fc2VsZWN0X2RhdGVzX2luX2NhbGVuZGFyKCByZXNvdXJjZV9pZCwgWycyMDI0LTA1LTA5JywnMjAyNC0wNS0xOScsJzIwMjQtMDUtMjUnXSApO1xyXG4gKlxyXG4gKi9cclxuXHJcblxyXG4vKipcclxuICogQyBBIEwgRSBOIEQgQSBSICAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuICovXHJcblxyXG5cclxuLyoqXHJcbiAqICBTaG93IFdQQkMgQ2FsZW5kYXJcclxuICpcclxuICogQHBhcmFtIHJlc291cmNlX2lkXHRcdFx0LSByZXNvdXJjZSBJRFxyXG4gKiBAcmV0dXJucyB7Ym9vbGVhbn1cclxuICovXHJcbmZ1bmN0aW9uIHdwYmNfY2FsZW5kYXJfc2hvdyggcmVzb3VyY2VfaWQgKXtcclxuXHJcblx0Ly8gSWYgbm8gY2FsZW5kYXIgSFRNTCB0YWcsICB0aGVuICBleGl0XHJcblx0aWYgKCAwID09PSBqUXVlcnkoICcjY2FsZW5kYXJfYm9va2luZycgKyByZXNvdXJjZV9pZCApLmxlbmd0aCApeyByZXR1cm4gZmFsc2U7IH1cclxuXHJcblx0Ly8gSWYgdGhlIGNhbGVuZGFyIHdpdGggdGhlIHNhbWUgQm9va2luZyByZXNvdXJjZSBpcyBhY3RpdmF0ZWQgYWxyZWFkeSwgdGhlbiBleGl0LlxyXG5cdGlmICggdHJ1ZSA9PT0galF1ZXJ5KCAnI2NhbGVuZGFyX2Jvb2tpbmcnICsgcmVzb3VyY2VfaWQgKS5oYXNDbGFzcyggJ2hhc0RhdGVwaWNrJyApICl7IHJldHVybiBmYWxzZTsgfVxyXG5cclxuXHQvLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cdC8vIERheXMgc2VsZWN0aW9uXHJcblx0Ly8gLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHR2YXIgbG9jYWxfX2lzX3JhbmdlX3NlbGVjdCA9IGZhbHNlO1xyXG5cdHZhciBsb2NhbF9fbXVsdGlfZGF5c19zZWxlY3RfbnVtICAgPSAzNjU7XHRcdFx0XHRcdC8vIG11bHRpcGxlIHwgZml4ZWRcclxuXHRpZiAoICdkeW5hbWljJyA9PT0gX3dwYmMuY2FsZW5kYXJfX2dldF9wYXJhbV92YWx1ZSggcmVzb3VyY2VfaWQsICdkYXlzX3NlbGVjdF9tb2RlJyApICl7XHJcblx0XHRsb2NhbF9faXNfcmFuZ2Vfc2VsZWN0ID0gdHJ1ZTtcclxuXHRcdGxvY2FsX19tdWx0aV9kYXlzX3NlbGVjdF9udW0gPSAwO1xyXG5cdH1cclxuXHRpZiAoICdzaW5nbGUnICA9PT0gX3dwYmMuY2FsZW5kYXJfX2dldF9wYXJhbV92YWx1ZSggcmVzb3VyY2VfaWQsICdkYXlzX3NlbGVjdF9tb2RlJyApICl7XHJcblx0XHRsb2NhbF9fbXVsdGlfZGF5c19zZWxlY3RfbnVtID0gMDtcclxuXHR9XHJcblxyXG5cdC8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblx0Ly8gTWluIC0gTWF4IGRheXMgdG8gc2Nyb2xsL3Nob3dcclxuXHQvLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cdHZhciBsb2NhbF9fbWluX2RhdGUgPSAwO1xyXG4gXHRsb2NhbF9fbWluX2RhdGUgPSBuZXcgRGF0ZSggX3dwYmMuZ2V0X290aGVyX3BhcmFtKCAndG9kYXlfYXJyJyApWyAwIF0sIChwYXJzZUludCggX3dwYmMuZ2V0X290aGVyX3BhcmFtKCAndG9kYXlfYXJyJyApWyAxIF0gKSAtIDEpLCBfd3BiYy5nZXRfb3RoZXJfcGFyYW0oICd0b2RheV9hcnInIClbIDIgXSwgMCwgMCwgMCApO1x0XHRcdC8vRml4SW46IDkuOS4wLjE3XHJcbi8vY29uc29sZS5sb2coIGxvY2FsX19taW5fZGF0ZSApO1xyXG5cdHZhciBsb2NhbF9fbWF4X2RhdGUgPSBfd3BiYy5jYWxlbmRhcl9fZ2V0X3BhcmFtX3ZhbHVlKCByZXNvdXJjZV9pZCwgJ2Jvb2tpbmdfbWF4X21vbnRoZXNfaW5fY2FsZW5kYXInICk7XHJcblx0Ly9sb2NhbF9fbWF4X2RhdGUgPSBuZXcgRGF0ZSgyMDI0LCA1LCAyOCk7ICBJdCBpcyBoZXJlIGlzc3VlIG9mIG5vdCBzZWxlY3RhYmxlIGRhdGVzLCBidXQgc29tZSBkYXRlcyBzaG93aW5nIGluIGNhbGVuZGFyIGFzIGF2YWlsYWJsZSwgYnV0IHdlIGNhbiBub3Qgc2VsZWN0IGl0LlxyXG5cclxuXHQvLy8vIERlZmluZSBsYXN0IGRheSBpbiBjYWxlbmRhciAoYXMgYSBsYXN0IGRheSBvZiBtb250aCAoYW5kIG5vdCBkYXRlLCB3aGljaCBpcyByZWxhdGVkIHRvIGFjdHVhbCAnVG9kYXknIGRhdGUpLlxyXG5cdC8vLy8gRS5nLiBpZiB0b2RheSBpcyAyMDIzLTA5LTI1LCBhbmQgd2Ugc2V0ICdOdW1iZXIgb2YgbW9udGhzIHRvIHNjcm9sbCcgYXMgNSBtb250aHMsIHRoZW4gbGFzdCBkYXkgd2lsbCBiZSAyMDI0LTAyLTI5IGFuZCBub3QgdGhlIDIwMjQtMDItMjUuXHJcblx0Ly8gdmFyIGNhbF9sYXN0X2RheV9pbl9tb250aCA9IGpRdWVyeS5kYXRlcGljay5fZGV0ZXJtaW5lRGF0ZSggbnVsbCwgbG9jYWxfX21heF9kYXRlLCBuZXcgRGF0ZSgpICk7XHJcblx0Ly8gY2FsX2xhc3RfZGF5X2luX21vbnRoID0gbmV3IERhdGUoIGNhbF9sYXN0X2RheV9pbl9tb250aC5nZXRGdWxsWWVhcigpLCBjYWxfbGFzdF9kYXlfaW5fbW9udGguZ2V0TW9udGgoKSArIDEsIDAgKTtcclxuXHQvLyBsb2NhbF9fbWF4X2RhdGUgPSBjYWxfbGFzdF9kYXlfaW5fbW9udGg7XHRcdFx0Ly9GaXhJbjogMTAuMC4wLjI2XHJcblxyXG5cdGlmICggICAoIGxvY2F0aW9uLmhyZWYuaW5kZXhPZigncGFnZT13cGJjLW5ldycpICE9IC0xIClcclxuXHRcdCYmICggbG9jYXRpb24uaHJlZi5pbmRleE9mKCdib29raW5nX2hhc2gnKSAhPSAtMSApICAgICAgICAgICAgICAgICAgLy8gQ29tbWVudCB0aGlzIGxpbmUgZm9yIGFiaWxpdHkgdG8gYWRkICBib29raW5nIGluIHBhc3QgZGF5cyBhdCAgQm9va2luZyA+IEFkZCBib29raW5nIHBhZ2UuXHJcblx0XHQpe1xyXG5cdFx0bG9jYWxfX21pbl9kYXRlID0gbnVsbDtcclxuXHRcdGxvY2FsX19tYXhfZGF0ZSA9IG51bGw7XHJcblx0fVxyXG5cclxuXHR2YXIgbG9jYWxfX3N0YXJ0X3dlZWtkYXkgICAgPSBfd3BiYy5jYWxlbmRhcl9fZ2V0X3BhcmFtX3ZhbHVlKCByZXNvdXJjZV9pZCwgJ2Jvb2tpbmdfc3RhcnRfZGF5X3dlZWVrJyApO1xyXG5cdHZhciBsb2NhbF9fbnVtYmVyX29mX21vbnRocyA9IHBhcnNlSW50KCBfd3BiYy5jYWxlbmRhcl9fZ2V0X3BhcmFtX3ZhbHVlKCByZXNvdXJjZV9pZCwgJ2NhbGVuZGFyX251bWJlcl9vZl9tb250aHMnICkgKTtcclxuXHJcblx0alF1ZXJ5KCAnI2NhbGVuZGFyX2Jvb2tpbmcnICsgcmVzb3VyY2VfaWQgKS50ZXh0KCAnJyApO1x0XHRcdFx0XHQvLyBSZW1vdmUgYWxsIEhUTUwgaW4gY2FsZW5kYXIgdGFnXHJcblx0Ly8gLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHQvLyBTaG93IGNhbGVuZGFyXHJcblx0Ly8gLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHRqUXVlcnkoJyNjYWxlbmRhcl9ib29raW5nJysgcmVzb3VyY2VfaWQpLmRhdGVwaWNrKFxyXG5cdFx0XHR7XHJcblx0XHRcdFx0YmVmb3JlU2hvd0RheTogZnVuY3Rpb24gKCBqc19kYXRlICl7XHJcblx0XHRcdFx0XHRcdFx0XHRcdHJldHVybiB3cGJjX19jYWxlbmRhcl9fYXBwbHlfY3NzX3RvX2RheXMoIGpzX2RhdGUsIHsncmVzb3VyY2VfaWQnOiByZXNvdXJjZV9pZH0sIHRoaXMgKTtcclxuXHRcdFx0XHRcdFx0XHQgIH0sXHJcblx0XHRcdFx0b25TZWxlY3Q6IGZ1bmN0aW9uICggc3RyaW5nX2RhdGVzLCBqc19kYXRlc19hcnIgKXsgIC8qKlxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0ICpcdHN0cmluZ19kYXRlcyAgID0gICAnMjMuMDguMjAyMyAtIDI2LjA4LjIwMjMnICAgIHwgICAgJzIzLjA4LjIwMjMgLSAyMy4wOC4yMDIzJyAgICB8ICAgICcxOS4wOS4yMDIzLCAyNC4wOC4yMDIzLCAzMC4wOS4yMDIzJ1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0ICogIGpzX2RhdGVzX2FyciAgID0gICByYW5nZTogWyBEYXRlIChBdWcgMjMgMjAyMyksIERhdGUgKEF1ZyAyNSAyMDIzKV0gICAgIHwgICAgIG11bHRpcGxlOiBbIERhdGUoT2N0IDI0IDIwMjMpLCBEYXRlKE9jdCAyMCAyMDIzKSwgRGF0ZShPY3QgMTYgMjAyMykgXVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0ICovXHJcblx0XHRcdFx0XHRcdFx0XHRcdHJldHVybiB3cGJjX19jYWxlbmRhcl9fb25fc2VsZWN0X2RheXMoIHN0cmluZ19kYXRlcywgeydyZXNvdXJjZV9pZCc6IHJlc291cmNlX2lkfSwgdGhpcyApO1xyXG5cdFx0XHRcdFx0XHRcdCAgfSxcclxuXHRcdFx0XHRvbkhvdmVyOiBmdW5jdGlvbiAoIHN0cmluZ19kYXRlLCBqc19kYXRlICl7XHJcblx0XHRcdFx0XHRcdFx0XHRcdHJldHVybiB3cGJjX19jYWxlbmRhcl9fb25faG92ZXJfZGF5cyggc3RyaW5nX2RhdGUsIGpzX2RhdGUsIHsncmVzb3VyY2VfaWQnOiByZXNvdXJjZV9pZH0sIHRoaXMgKTtcclxuXHRcdFx0XHRcdFx0XHQgIH0sXHJcblx0XHRcdFx0b25DaGFuZ2VNb250aFllYXI6IGZ1bmN0aW9uICggeWVhciwgcmVhbF9tb250aCwganNfZGF0ZV9fMXN0X2RheV9pbl9tb250aCApeyB9LFxyXG5cdFx0XHRcdHNob3dPbiAgICAgICAgOiAnYm90aCcsXHJcblx0XHRcdFx0bnVtYmVyT2ZNb250aHM6IGxvY2FsX19udW1iZXJfb2ZfbW9udGhzLFxyXG5cdFx0XHRcdHN0ZXBNb250aHMgICAgOiAxLFxyXG5cdFx0XHRcdHByZXZUZXh0ICAgICAgOiAnJmxhcXVvOycsXHJcblx0XHRcdFx0bmV4dFRleHQgICAgICA6ICcmcmFxdW87JyxcclxuXHRcdFx0XHRkYXRlRm9ybWF0ICAgIDogJ2RkLm1tLnl5JyxcclxuXHRcdFx0XHRjaGFuZ2VNb250aCAgIDogZmFsc2UsXHJcblx0XHRcdFx0Y2hhbmdlWWVhciAgICA6IGZhbHNlLFxyXG5cdFx0XHRcdG1pbkRhdGUgICAgICAgOiBsb2NhbF9fbWluX2RhdGUsXHJcblx0XHRcdFx0bWF4RGF0ZSAgICAgICA6IGxvY2FsX19tYXhfZGF0ZSwgXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdC8vICcxWScsXHJcblx0XHRcdFx0Ly8gbWluRGF0ZTogbmV3IERhdGUoMjAyMCwgMiwgMSksIG1heERhdGU6IG5ldyBEYXRlKDIwMjAsIDksIDMxKSwgICAgICAgICAgICAgXHQvLyBBYmlsaXR5IHRvIHNldCBhbnkgIHN0YXJ0IGFuZCBlbmQgZGF0ZSBpbiBjYWxlbmRhclxyXG5cdFx0XHRcdHNob3dTdGF0dXMgICAgICA6IGZhbHNlLFxyXG5cdFx0XHRcdG11bHRpU2VwYXJhdG9yICA6ICcsICcsXHJcblx0XHRcdFx0Y2xvc2VBdFRvcCAgICAgIDogZmFsc2UsXHJcblx0XHRcdFx0Zmlyc3REYXkgICAgICAgIDogbG9jYWxfX3N0YXJ0X3dlZWtkYXksXHJcblx0XHRcdFx0Z290b0N1cnJlbnQgICAgIDogZmFsc2UsXHJcblx0XHRcdFx0aGlkZUlmTm9QcmV2TmV4dDogdHJ1ZSxcclxuXHRcdFx0XHRtdWx0aVNlbGVjdCAgICAgOiBsb2NhbF9fbXVsdGlfZGF5c19zZWxlY3RfbnVtLFxyXG5cdFx0XHRcdHJhbmdlU2VsZWN0ICAgICA6IGxvY2FsX19pc19yYW5nZV9zZWxlY3QsXHJcblx0XHRcdFx0Ly8gc2hvd1dlZWtzOiB0cnVlLFxyXG5cdFx0XHRcdHVzZVRoZW1lUm9sbGVyOiBmYWxzZVxyXG5cdFx0XHR9XHJcblx0KTtcclxuXHJcblxyXG5cdFxyXG5cdC8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblx0Ly8gQ2xlYXIgdG9kYXkgZGF0ZSBoaWdobGlnaHRpbmdcclxuXHQvLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cdHNldFRpbWVvdXQoIGZ1bmN0aW9uICgpeyAgd3BiY19jYWxlbmRhcnNfX2NsZWFyX2RheXNfaGlnaGxpZ2h0aW5nKCByZXNvdXJjZV9pZCApOyAgfSwgNTAwICk7ICAgICAgICAgICAgICAgICAgICBcdC8vRml4SW46IDcuMS4yLjhcclxuXHRcclxuXHQvLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cdC8vIFNjcm9sbCBjYWxlbmRhciB0byAgc3BlY2lmaWMgbW9udGhcclxuXHQvLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cdHZhciBzdGFydF9ia19tb250aCA9IF93cGJjLmNhbGVuZGFyX19nZXRfcGFyYW1fdmFsdWUoIHJlc291cmNlX2lkLCAnY2FsZW5kYXJfc2Nyb2xsX3RvJyApO1xyXG5cdGlmICggZmFsc2UgIT09IHN0YXJ0X2JrX21vbnRoICl7XHJcblx0XHR3cGJjX2NhbGVuZGFyX19zY3JvbGxfdG8oIHJlc291cmNlX2lkLCBzdGFydF9ia19tb250aFsgMCBdLCBzdGFydF9ia19tb250aFsgMSBdICk7XHJcblx0fVxyXG59XHJcblxyXG5cclxuXHQvKipcclxuXHQgKiBBcHBseSBDU1MgdG8gY2FsZW5kYXIgZGF0ZSBjZWxsc1xyXG5cdCAqXHJcblx0ICogQHBhcmFtIGRhdGVcdFx0XHRcdFx0XHRcdFx0XHRcdC0gIEphdmFTY3JpcHQgRGF0ZSBPYmo6ICBcdFx0TW9uIERlYyAxMSAyMDIzIDAwOjAwOjAwIEdNVCswMjAwIChFYXN0ZXJuIEV1cm9wZWFuIFN0YW5kYXJkIFRpbWUpXHJcblx0ICogQHBhcmFtIGNhbGVuZGFyX3BhcmFtc19hcnJcdFx0XHRcdFx0XHQtICBDYWxlbmRhciBTZXR0aW5ncyBPYmplY3Q6ICBcdHtcclxuXHQgKlx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0ICBcdFx0XHRcdFx0XHRcInJlc291cmNlX2lkXCI6IDRcclxuXHQgKlx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdH1cclxuXHQgKiBAcGFyYW0gZGF0ZXBpY2tfdGhpc1x0XHRcdFx0XHRcdFx0XHQtIHRoaXMgb2YgZGF0ZXBpY2sgT2JqXHJcblx0ICogQHJldHVybnMgeygqfHN0cmluZylbXXwoYm9vbGVhbnxzdHJpbmcpW119XHRcdC0gWyB7dHJ1ZSAtYXZhaWxhYmxlIHwgZmFsc2UgLSB1bmF2YWlsYWJsZX0sICdDU1MgY2xhc3NlcyBmb3IgY2FsZW5kYXIgZGF5IGNlbGwnIF1cclxuXHQgKi9cclxuXHRmdW5jdGlvbiB3cGJjX19jYWxlbmRhcl9fYXBwbHlfY3NzX3RvX2RheXMoIGRhdGUsIGNhbGVuZGFyX3BhcmFtc19hcnIsIGRhdGVwaWNrX3RoaXMgKXtcclxuXHJcblx0XHR2YXIgdG9kYXlfZGF0ZSA9IG5ldyBEYXRlKCBfd3BiYy5nZXRfb3RoZXJfcGFyYW0oICd0b2RheV9hcnInIClbIDAgXSwgKHBhcnNlSW50KCBfd3BiYy5nZXRfb3RoZXJfcGFyYW0oICd0b2RheV9hcnInIClbIDEgXSApIC0gMSksIF93cGJjLmdldF9vdGhlcl9wYXJhbSggJ3RvZGF5X2FycicgKVsgMiBdLCAwLCAwLCAwICk7XHRcdFx0XHRcdFx0XHRcdC8vIFRvZGF5IEpTX0RhdGVfT2JqLlxyXG5cdFx0dmFyIGNsYXNzX2RheSAgICAgPSB3cGJjX19nZXRfX3RkX2NsYXNzX2RhdGUoIGRhdGUgKTtcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQvLyAnMS05LTIwMjMnXHJcblx0XHR2YXIgc3FsX2NsYXNzX2RheSA9IHdwYmNfX2dldF9fc3FsX2NsYXNzX2RhdGUoIGRhdGUgKTtcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQvLyAnMjAyMy0wMS0wOSdcclxuXHRcdHZhciByZXNvdXJjZV9pZCA9ICggJ3VuZGVmaW5lZCcgIT09IHR5cGVvZihjYWxlbmRhcl9wYXJhbXNfYXJyWyAncmVzb3VyY2VfaWQnIF0pICkgPyBjYWxlbmRhcl9wYXJhbXNfYXJyWyAncmVzb3VyY2VfaWQnIF0gOiAnMSc7IFx0XHQvLyAnMSdcclxuXHJcblx0XHQvLyBHZXQgRGF0YSAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cdFx0dmFyIGRhdGVfYm9va2luZ3Nfb2JqID0gX3dwYmMuYm9va2luZ3NfaW5fY2FsZW5kYXJfX2dldF9mb3JfZGF0ZSggcmVzb3VyY2VfaWQsIHNxbF9jbGFzc19kYXkgKTtcclxuXHJcblxyXG5cdFx0Ly8gQXJyYXkgd2l0aCBDU1MgY2xhc3NlcyBmb3IgZGF0ZSAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHRcdHZhciBjc3NfY2xhc3Nlc19fZm9yX2RhdGUgPSBbXTtcclxuXHRcdGNzc19jbGFzc2VzX19mb3JfZGF0ZS5wdXNoKCAnc3FsX2RhdGVfJyAgICAgKyBzcWxfY2xhc3NfZGF5ICk7XHRcdFx0XHQvLyAgJ3NxbF9kYXRlXzIwMjMtMDctMjEnXHJcblx0XHRjc3NfY2xhc3Nlc19fZm9yX2RhdGUucHVzaCggJ2NhbDRkYXRlLScgICAgICsgY2xhc3NfZGF5ICk7XHRcdFx0XHRcdC8vICAnY2FsNGRhdGUtNy0yMS0yMDIzJ1xyXG5cdFx0Y3NzX2NsYXNzZXNfX2Zvcl9kYXRlLnB1c2goICd3cGJjX3dlZWtkYXlfJyArIGRhdGUuZ2V0RGF5KCkgKTtcdFx0XHRcdC8vICAnd3BiY193ZWVrZGF5XzQnXHJcblxyXG5cdFx0dmFyIGlzX2RheV9zZWxlY3RhYmxlID0gZmFsc2U7XHJcblxyXG5cdFx0Ly8gSWYgc29tZXRoaW5nIG5vdCBkZWZpbmVkLCAgdGhlbiAgdGhpcyBkYXRlIGNsb3NlZCAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHRcdGlmICggZmFsc2UgPT09IGRhdGVfYm9va2luZ3Nfb2JqICl7XHJcblxyXG5cdFx0XHRjc3NfY2xhc3Nlc19fZm9yX2RhdGUucHVzaCggJ2RhdGVfdXNlcl91bmF2YWlsYWJsZScgKTtcclxuXHJcblx0XHRcdHJldHVybiBbIGlzX2RheV9zZWxlY3RhYmxlLCBjc3NfY2xhc3Nlc19fZm9yX2RhdGUuam9pbignICcpICBdO1xyXG5cdFx0fVxyXG5cclxuXHJcblx0XHQvLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cdFx0Ly8gICBkYXRlX2Jvb2tpbmdzX29iaiAgLSBEZWZpbmVkLiAgICAgICAgICAgIERhdGVzIGNhbiBiZSBzZWxlY3RhYmxlLlxyXG5cdFx0Ly8gLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHJcblx0XHQvLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cdFx0Ly8gQWRkIHNlYXNvbiBuYW1lcyB0byB0aGUgZGF5IENTUyBjbGFzc2VzIC0tIGl0IGlzIHJlcXVpcmVkIGZvciBjb3JyZWN0ICB3b3JrICBvZiBjb25kaXRpb25hbCBmaWVsZHMgLS0tLS0tLS0tLS0tLS1cclxuXHRcdHZhciBzZWFzb25fbmFtZXNfYXJyID0gX3dwYmMuc2Vhc29uc19fZ2V0X2Zvcl9kYXRlKCByZXNvdXJjZV9pZCwgc3FsX2NsYXNzX2RheSApO1xyXG5cdFx0Zm9yICggdmFyIHNlYXNvbl9rZXkgaW4gc2Vhc29uX25hbWVzX2FyciApe1xyXG5cdFx0XHRjc3NfY2xhc3Nlc19fZm9yX2RhdGUucHVzaCggc2Vhc29uX25hbWVzX2Fyclsgc2Vhc29uX2tleSBdICk7XHRcdFx0XHQvLyAgJ3dwZGV2Ymtfc2Vhc29uX3NlcHRlbWJlcl8yMDIzJ1xyXG5cdFx0fVxyXG5cdFx0Ly8gLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHJcblxyXG5cdFx0Ly8gQ29zdCBSYXRlIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHRcdGNzc19jbGFzc2VzX19mb3JfZGF0ZS5wdXNoKCAncmF0ZV8nICsgZGF0ZV9ib29raW5nc19vYmpbIHJlc291cmNlX2lkIF1bICdkYXRlX2Nvc3RfcmF0ZScgXS50b1N0cmluZygpLnJlcGxhY2UoIC9bXFwuXFxzXS9nLCAnXycgKSApO1x0XHRcdFx0XHRcdC8vICAncmF0ZV85OV8wMCcgLT4gOTkuMDBcclxuXHJcblxyXG5cdFx0aWYgKCBwYXJzZUludCggZGF0ZV9ib29raW5nc19vYmpbICdkYXlfYXZhaWxhYmlsaXR5JyBdICkgPiAwICl7XHJcblx0XHRcdGlzX2RheV9zZWxlY3RhYmxlID0gdHJ1ZTtcclxuXHRcdFx0Y3NzX2NsYXNzZXNfX2Zvcl9kYXRlLnB1c2goICdkYXRlX2F2YWlsYWJsZScgKTtcclxuXHRcdFx0Y3NzX2NsYXNzZXNfX2Zvcl9kYXRlLnB1c2goICdyZXNlcnZlZF9kYXlzX2NvdW50JyArIHBhcnNlSW50KCBkYXRlX2Jvb2tpbmdzX29ialsgJ21heF9jYXBhY2l0eScgXSAtIGRhdGVfYm9va2luZ3Nfb2JqWyAnZGF5X2F2YWlsYWJpbGl0eScgXSApICk7XHJcblx0XHR9IGVsc2Uge1xyXG5cdFx0XHRpc19kYXlfc2VsZWN0YWJsZSA9IGZhbHNlO1xyXG5cdFx0XHRjc3NfY2xhc3Nlc19fZm9yX2RhdGUucHVzaCggJ2RhdGVfdXNlcl91bmF2YWlsYWJsZScgKTtcclxuXHRcdH1cclxuXHJcblxyXG5cdFx0c3dpdGNoICggZGF0ZV9ib29raW5nc19vYmpbICdzdW1tYXJ5J11bJ3N0YXR1c19mb3JfZGF5JyBdICl7XHJcblxyXG5cdFx0XHRjYXNlICdhdmFpbGFibGUnOlxyXG5cdFx0XHRcdGJyZWFrO1xyXG5cclxuXHRcdFx0Y2FzZSAndGltZV9zbG90c19ib29raW5nJzpcclxuXHRcdFx0XHRjc3NfY2xhc3Nlc19fZm9yX2RhdGUucHVzaCggJ3RpbWVzcGFydGx5JywgJ3RpbWVzX2Nsb2NrJyApO1xyXG5cdFx0XHRcdGJyZWFrO1xyXG5cclxuXHRcdFx0Y2FzZSAnZnVsbF9kYXlfYm9va2luZyc6XHJcblx0XHRcdFx0Y3NzX2NsYXNzZXNfX2Zvcl9kYXRlLnB1c2goICdmdWxsX2RheV9ib29raW5nJyApO1xyXG5cdFx0XHRcdGJyZWFrO1xyXG5cclxuXHRcdFx0Y2FzZSAnc2Vhc29uX2ZpbHRlcic6XHJcblx0XHRcdFx0Y3NzX2NsYXNzZXNfX2Zvcl9kYXRlLnB1c2goICdkYXRlX3VzZXJfdW5hdmFpbGFibGUnLCAnc2Vhc29uX3VuYXZhaWxhYmxlJyApO1xyXG5cdFx0XHRcdGRhdGVfYm9va2luZ3Nfb2JqWyAnc3VtbWFyeSddWydzdGF0dXNfZm9yX2Jvb2tpbmdzJyBdID0gJyc7XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdC8vIFJlc2V0IGJvb2tpbmcgc3RhdHVzIGNvbG9yIGZvciBwb3NzaWJsZSBvbGQgYm9va2luZ3Mgb24gdGhpcyBkYXRlXHJcblx0XHRcdFx0YnJlYWs7XHJcblxyXG5cdFx0XHRjYXNlICdyZXNvdXJjZV9hdmFpbGFiaWxpdHknOlxyXG5cdFx0XHRcdGNzc19jbGFzc2VzX19mb3JfZGF0ZS5wdXNoKCAnZGF0ZV91c2VyX3VuYXZhaWxhYmxlJywgJ3Jlc291cmNlX3VuYXZhaWxhYmxlJyApO1xyXG5cdFx0XHRcdGRhdGVfYm9va2luZ3Nfb2JqWyAnc3VtbWFyeSddWydzdGF0dXNfZm9yX2Jvb2tpbmdzJyBdID0gJyc7XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdC8vIFJlc2V0IGJvb2tpbmcgc3RhdHVzIGNvbG9yIGZvciBwb3NzaWJsZSBvbGQgYm9va2luZ3Mgb24gdGhpcyBkYXRlXHJcblx0XHRcdFx0YnJlYWs7XHJcblxyXG5cdFx0XHRjYXNlICd3ZWVrZGF5X3VuYXZhaWxhYmxlJzpcclxuXHRcdFx0XHRjc3NfY2xhc3Nlc19fZm9yX2RhdGUucHVzaCggJ2RhdGVfdXNlcl91bmF2YWlsYWJsZScsICd3ZWVrZGF5X3VuYXZhaWxhYmxlJyApO1xyXG5cdFx0XHRcdGRhdGVfYm9va2luZ3Nfb2JqWyAnc3VtbWFyeSddWydzdGF0dXNfZm9yX2Jvb2tpbmdzJyBdID0gJyc7XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdC8vIFJlc2V0IGJvb2tpbmcgc3RhdHVzIGNvbG9yIGZvciBwb3NzaWJsZSBvbGQgYm9va2luZ3Mgb24gdGhpcyBkYXRlXHJcblx0XHRcdFx0YnJlYWs7XHJcblxyXG5cdFx0XHRjYXNlICdmcm9tX3RvZGF5X3VuYXZhaWxhYmxlJzpcclxuXHRcdFx0XHRjc3NfY2xhc3Nlc19fZm9yX2RhdGUucHVzaCggJ2RhdGVfdXNlcl91bmF2YWlsYWJsZScsICdmcm9tX3RvZGF5X3VuYXZhaWxhYmxlJyApO1xyXG5cdFx0XHRcdGRhdGVfYm9va2luZ3Nfb2JqWyAnc3VtbWFyeSddWydzdGF0dXNfZm9yX2Jvb2tpbmdzJyBdID0gJyc7XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdC8vIFJlc2V0IGJvb2tpbmcgc3RhdHVzIGNvbG9yIGZvciBwb3NzaWJsZSBvbGQgYm9va2luZ3Mgb24gdGhpcyBkYXRlXHJcblx0XHRcdFx0YnJlYWs7XHJcblxyXG5cdFx0XHRjYXNlICdsaW1pdF9hdmFpbGFibGVfZnJvbV90b2RheSc6XHJcblx0XHRcdFx0Y3NzX2NsYXNzZXNfX2Zvcl9kYXRlLnB1c2goICdkYXRlX3VzZXJfdW5hdmFpbGFibGUnLCAnbGltaXRfYXZhaWxhYmxlX2Zyb21fdG9kYXknICk7XHJcblx0XHRcdFx0ZGF0ZV9ib29raW5nc19vYmpbICdzdW1tYXJ5J11bJ3N0YXR1c19mb3JfYm9va2luZ3MnIF0gPSAnJztcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0Ly8gUmVzZXQgYm9va2luZyBzdGF0dXMgY29sb3IgZm9yIHBvc3NpYmxlIG9sZCBib29raW5ncyBvbiB0aGlzIGRhdGVcclxuXHRcdFx0XHRicmVhaztcclxuXHJcblx0XHRcdGNhc2UgJ2NoYW5nZV9vdmVyJzpcclxuXHRcdFx0XHQvKlxyXG5cdFx0XHRcdCAqXHJcblx0XHRcdFx0Ly8gIGNoZWNrX291dF90aW1lX2RhdGUyYXBwcm92ZSBcdCBcdGNoZWNrX2luX3RpbWVfZGF0ZTJhcHByb3ZlXHJcblx0XHRcdFx0Ly8gIGNoZWNrX291dF90aW1lX2RhdGUyYXBwcm92ZSBcdCBcdGNoZWNrX2luX3RpbWVfZGF0ZV9hcHByb3ZlZFxyXG5cdFx0XHRcdC8vICBjaGVja19pbl90aW1lX2RhdGUyYXBwcm92ZSBcdFx0IFx0Y2hlY2tfb3V0X3RpbWVfZGF0ZV9hcHByb3ZlZFxyXG5cdFx0XHRcdC8vICBjaGVja19vdXRfdGltZV9kYXRlX2FwcHJvdmVkIFx0IFx0Y2hlY2tfaW5fdGltZV9kYXRlX2FwcHJvdmVkXHJcblx0XHRcdFx0ICovXHJcblxyXG5cdFx0XHRcdGNzc19jbGFzc2VzX19mb3JfZGF0ZS5wdXNoKCAndGltZXNwYXJ0bHknLCAnY2hlY2tfaW5fdGltZScsICdjaGVja19vdXRfdGltZScgKTtcclxuXHRcdFx0XHQvL0ZpeEluOiAxMC4wLjAuMlxyXG5cdFx0XHRcdGlmICggZGF0ZV9ib29raW5nc19vYmpbICdzdW1tYXJ5JyBdWyAnc3RhdHVzX2Zvcl9ib29raW5ncycgXS5pbmRleE9mKCAnYXBwcm92ZWRfcGVuZGluZycgKSA+IC0xICl7XHJcblx0XHRcdFx0XHRjc3NfY2xhc3Nlc19fZm9yX2RhdGUucHVzaCggJ2NoZWNrX291dF90aW1lX2RhdGVfYXBwcm92ZWQnLCAnY2hlY2tfaW5fdGltZV9kYXRlMmFwcHJvdmUnICk7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHRcdGlmICggZGF0ZV9ib29raW5nc19vYmpbICdzdW1tYXJ5JyBdWyAnc3RhdHVzX2Zvcl9ib29raW5ncycgXS5pbmRleE9mKCAncGVuZGluZ19hcHByb3ZlZCcgKSA+IC0xICl7XHJcblx0XHRcdFx0XHRjc3NfY2xhc3Nlc19fZm9yX2RhdGUucHVzaCggJ2NoZWNrX291dF90aW1lX2RhdGUyYXBwcm92ZScsICdjaGVja19pbl90aW1lX2RhdGVfYXBwcm92ZWQnICk7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHRcdGJyZWFrO1xyXG5cclxuXHRcdFx0Y2FzZSAnY2hlY2tfaW4nOlxyXG5cdFx0XHRcdGNzc19jbGFzc2VzX19mb3JfZGF0ZS5wdXNoKCAndGltZXNwYXJ0bHknLCAnY2hlY2tfaW5fdGltZScgKTtcclxuXHJcblx0XHRcdFx0Ly9GaXhJbjogOS45LjAuMzNcclxuXHRcdFx0XHRpZiAoIGRhdGVfYm9va2luZ3Nfb2JqWyAnc3VtbWFyeScgXVsgJ3N0YXR1c19mb3JfYm9va2luZ3MnIF0uaW5kZXhPZiggJ3BlbmRpbmcnICkgPiAtMSApe1xyXG5cdFx0XHRcdFx0Y3NzX2NsYXNzZXNfX2Zvcl9kYXRlLnB1c2goICdjaGVja19pbl90aW1lX2RhdGUyYXBwcm92ZScgKTtcclxuXHRcdFx0XHR9IGVsc2UgaWYgKCBkYXRlX2Jvb2tpbmdzX29ialsgJ3N1bW1hcnknIF1bICdzdGF0dXNfZm9yX2Jvb2tpbmdzJyBdLmluZGV4T2YoICdhcHByb3ZlZCcgKSA+IC0xICl7XHJcblx0XHRcdFx0XHRjc3NfY2xhc3Nlc19fZm9yX2RhdGUucHVzaCggJ2NoZWNrX2luX3RpbWVfZGF0ZV9hcHByb3ZlZCcgKTtcclxuXHRcdFx0XHR9XHJcblx0XHRcdFx0YnJlYWs7XHJcblxyXG5cdFx0XHRjYXNlICdjaGVja19vdXQnOlxyXG5cdFx0XHRcdGNzc19jbGFzc2VzX19mb3JfZGF0ZS5wdXNoKCAndGltZXNwYXJ0bHknLCAnY2hlY2tfb3V0X3RpbWUnICk7XHJcblxyXG5cdFx0XHRcdC8vRml4SW46IDkuOS4wLjMzXHJcblx0XHRcdFx0aWYgKCBkYXRlX2Jvb2tpbmdzX29ialsgJ3N1bW1hcnknIF1bICdzdGF0dXNfZm9yX2Jvb2tpbmdzJyBdLmluZGV4T2YoICdwZW5kaW5nJyApID4gLTEgKXtcclxuXHRcdFx0XHRcdGNzc19jbGFzc2VzX19mb3JfZGF0ZS5wdXNoKCAnY2hlY2tfb3V0X3RpbWVfZGF0ZTJhcHByb3ZlJyApO1xyXG5cdFx0XHRcdH0gZWxzZSBpZiAoIGRhdGVfYm9va2luZ3Nfb2JqWyAnc3VtbWFyeScgXVsgJ3N0YXR1c19mb3JfYm9va2luZ3MnIF0uaW5kZXhPZiggJ2FwcHJvdmVkJyApID4gLTEgKXtcclxuXHRcdFx0XHRcdGNzc19jbGFzc2VzX19mb3JfZGF0ZS5wdXNoKCAnY2hlY2tfb3V0X3RpbWVfZGF0ZV9hcHByb3ZlZCcgKTtcclxuXHRcdFx0XHR9XHJcblx0XHRcdFx0YnJlYWs7XHJcblxyXG5cdFx0XHRkZWZhdWx0OlxyXG5cdFx0XHRcdC8vIG1peGVkIHN0YXR1c2VzOiAnY2hhbmdlX292ZXIgY2hlY2tfb3V0JyAuLi4uIHZhcmlhdGlvbnMuLi4uIGNoZWNrIG1vcmUgaW4gXHRcdGZ1bmN0aW9uIHdwYmNfZ2V0X2F2YWlsYWJpbGl0eV9wZXJfZGF5c19hcnIoKVxyXG5cdFx0XHRcdGRhdGVfYm9va2luZ3Nfb2JqWyAnc3VtbWFyeSddWydzdGF0dXNfZm9yX2RheScgXSA9ICdhdmFpbGFibGUnO1xyXG5cdFx0fVxyXG5cclxuXHJcblxyXG5cdFx0aWYgKCAnYXZhaWxhYmxlJyAhPSBkYXRlX2Jvb2tpbmdzX29ialsgJ3N1bW1hcnknXVsnc3RhdHVzX2Zvcl9kYXknIF0gKXtcclxuXHJcblx0XHRcdHZhciBpc19zZXRfcGVuZGluZ19kYXlzX3NlbGVjdGFibGUgPSBfd3BiYy5jYWxlbmRhcl9fZ2V0X3BhcmFtX3ZhbHVlKCByZXNvdXJjZV9pZCwgJ3BlbmRpbmdfZGF5c19zZWxlY3RhYmxlJyApO1x0Ly8gc2V0IHBlbmRpbmcgZGF5cyBzZWxlY3RhYmxlICAgICAgICAgIC8vRml4SW46IDguNi4xLjE4XHJcblxyXG5cdFx0XHRzd2l0Y2ggKCBkYXRlX2Jvb2tpbmdzX29ialsgJ3N1bW1hcnknXVsnc3RhdHVzX2Zvcl9ib29raW5ncycgXSApe1xyXG5cclxuXHRcdFx0XHRjYXNlICcnOlxyXG5cdFx0XHRcdFx0Ly8gVXN1YWxseSAgaXQncyBtZWFucyB0aGF0IGRheSAgaXMgYXZhaWxhYmxlIG9yIHVuYXZhaWxhYmxlIHdpdGhvdXQgdGhlIGJvb2tpbmdzXHJcblx0XHRcdFx0XHRicmVhaztcclxuXHJcblx0XHRcdFx0Y2FzZSAncGVuZGluZyc6XHJcblx0XHRcdFx0XHRjc3NfY2xhc3Nlc19fZm9yX2RhdGUucHVzaCggJ2RhdGUyYXBwcm92ZScgKTtcclxuXHRcdFx0XHRcdGlzX2RheV9zZWxlY3RhYmxlID0gKGlzX2RheV9zZWxlY3RhYmxlKSA/IHRydWUgOiBpc19zZXRfcGVuZGluZ19kYXlzX3NlbGVjdGFibGU7XHJcblx0XHRcdFx0XHRicmVhaztcclxuXHJcblx0XHRcdFx0Y2FzZSAnYXBwcm92ZWQnOlxyXG5cdFx0XHRcdFx0Y3NzX2NsYXNzZXNfX2Zvcl9kYXRlLnB1c2goICdkYXRlX2FwcHJvdmVkJyApO1xyXG5cdFx0XHRcdFx0YnJlYWs7XHJcblxyXG5cdFx0XHRcdC8vIFNpdHVhdGlvbnMgZm9yIFwiY2hhbmdlLW92ZXJcIiBkYXlzOiAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblx0XHRcdFx0Y2FzZSAncGVuZGluZ19wZW5kaW5nJzpcclxuXHRcdFx0XHRcdGNzc19jbGFzc2VzX19mb3JfZGF0ZS5wdXNoKCAnY2hlY2tfb3V0X3RpbWVfZGF0ZTJhcHByb3ZlJywgJ2NoZWNrX2luX3RpbWVfZGF0ZTJhcHByb3ZlJyApO1xyXG5cdFx0XHRcdFx0aXNfZGF5X3NlbGVjdGFibGUgPSAoaXNfZGF5X3NlbGVjdGFibGUpID8gdHJ1ZSA6IGlzX3NldF9wZW5kaW5nX2RheXNfc2VsZWN0YWJsZTtcclxuXHRcdFx0XHRcdGJyZWFrO1xyXG5cclxuXHRcdFx0XHRjYXNlICdwZW5kaW5nX2FwcHJvdmVkJzpcclxuXHRcdFx0XHRcdGNzc19jbGFzc2VzX19mb3JfZGF0ZS5wdXNoKCAnY2hlY2tfb3V0X3RpbWVfZGF0ZTJhcHByb3ZlJywgJ2NoZWNrX2luX3RpbWVfZGF0ZV9hcHByb3ZlZCcgKTtcclxuXHRcdFx0XHRcdGlzX2RheV9zZWxlY3RhYmxlID0gKGlzX2RheV9zZWxlY3RhYmxlKSA/IHRydWUgOiBpc19zZXRfcGVuZGluZ19kYXlzX3NlbGVjdGFibGU7XHJcblx0XHRcdFx0XHRicmVhaztcclxuXHJcblx0XHRcdFx0Y2FzZSAnYXBwcm92ZWRfcGVuZGluZyc6XHJcblx0XHRcdFx0XHRjc3NfY2xhc3Nlc19fZm9yX2RhdGUucHVzaCggJ2NoZWNrX291dF90aW1lX2RhdGVfYXBwcm92ZWQnLCAnY2hlY2tfaW5fdGltZV9kYXRlMmFwcHJvdmUnICk7XHJcblx0XHRcdFx0XHRpc19kYXlfc2VsZWN0YWJsZSA9IChpc19kYXlfc2VsZWN0YWJsZSkgPyB0cnVlIDogaXNfc2V0X3BlbmRpbmdfZGF5c19zZWxlY3RhYmxlO1xyXG5cdFx0XHRcdFx0YnJlYWs7XHJcblxyXG5cdFx0XHRcdGNhc2UgJ2FwcHJvdmVkX2FwcHJvdmVkJzpcclxuXHRcdFx0XHRcdGNzc19jbGFzc2VzX19mb3JfZGF0ZS5wdXNoKCAnY2hlY2tfb3V0X3RpbWVfZGF0ZV9hcHByb3ZlZCcsICdjaGVja19pbl90aW1lX2RhdGVfYXBwcm92ZWQnICk7XHJcblx0XHRcdFx0XHRicmVhaztcclxuXHJcblx0XHRcdFx0ZGVmYXVsdDpcclxuXHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHJcblx0XHRyZXR1cm4gWyBpc19kYXlfc2VsZWN0YWJsZSwgY3NzX2NsYXNzZXNfX2Zvcl9kYXRlLmpvaW4oICcgJyApIF07XHJcblx0fVxyXG5cclxuXHJcblx0LyoqXHJcblx0ICogTW91c2VvdmVyIGNhbGVuZGFyIGRhdGUgY2VsbHNcclxuXHQgKlxyXG5cdCAqIEBwYXJhbSBzdHJpbmdfZGF0ZVxyXG5cdCAqIEBwYXJhbSBkYXRlXHRcdFx0XHRcdFx0XHRcdFx0XHQtICBKYXZhU2NyaXB0IERhdGUgT2JqOiAgXHRcdE1vbiBEZWMgMTEgMjAyMyAwMDowMDowMCBHTVQrMDIwMCAoRWFzdGVybiBFdXJvcGVhbiBTdGFuZGFyZCBUaW1lKVxyXG5cdCAqIEBwYXJhbSBjYWxlbmRhcl9wYXJhbXNfYXJyXHRcdFx0XHRcdFx0LSAgQ2FsZW5kYXIgU2V0dGluZ3MgT2JqZWN0OiAgXHR7XHJcblx0ICpcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCAgXHRcdFx0XHRcdFx0XCJyZXNvdXJjZV9pZFwiOiA0XHJcblx0ICpcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHR9XHJcblx0ICogQHBhcmFtIGRhdGVwaWNrX3RoaXNcdFx0XHRcdFx0XHRcdFx0LSB0aGlzIG9mIGRhdGVwaWNrIE9ialxyXG5cdCAqIEByZXR1cm5zIHtib29sZWFufVxyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfX2NhbGVuZGFyX19vbl9ob3Zlcl9kYXlzKCBzdHJpbmdfZGF0ZSwgZGF0ZSwgY2FsZW5kYXJfcGFyYW1zX2FyciwgZGF0ZXBpY2tfdGhpcyApIHtcclxuXHJcblx0XHRpZiAoIG51bGwgPT09IGRhdGUgKXsgcmV0dXJuIGZhbHNlOyB9XHJcblxyXG5cdFx0dmFyIGNsYXNzX2RheSAgICAgPSB3cGJjX19nZXRfX3RkX2NsYXNzX2RhdGUoIGRhdGUgKTtcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQvLyAnMS05LTIwMjMnXHJcblx0XHR2YXIgc3FsX2NsYXNzX2RheSA9IHdwYmNfX2dldF9fc3FsX2NsYXNzX2RhdGUoIGRhdGUgKTtcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQvLyAnMjAyMy0wMS0wOSdcclxuXHRcdHZhciByZXNvdXJjZV9pZCA9ICggJ3VuZGVmaW5lZCcgIT09IHR5cGVvZihjYWxlbmRhcl9wYXJhbXNfYXJyWyAncmVzb3VyY2VfaWQnIF0pICkgPyBjYWxlbmRhcl9wYXJhbXNfYXJyWyAncmVzb3VyY2VfaWQnIF0gOiAnMSc7XHRcdC8vICcxJ1xyXG5cclxuXHRcdC8vIEdldCBEYXRhIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblx0XHR2YXIgZGF0ZV9ib29raW5nX29iaiA9IF93cGJjLmJvb2tpbmdzX2luX2NhbGVuZGFyX19nZXRfZm9yX2RhdGUoIHJlc291cmNlX2lkLCBzcWxfY2xhc3NfZGF5ICk7XHRcdFx0XHRcdFx0XHRcdFx0XHRcdC8vIHsuLi59XHJcblxyXG5cdFx0aWYgKCAhIGRhdGVfYm9va2luZ19vYmogKXsgcmV0dXJuIGZhbHNlOyB9XHJcblxyXG5cclxuXHRcdC8vIFQgbyBvIGwgdCBpIHAgcyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblx0XHR2YXIgdG9vbHRpcF90ZXh0ID0gJyc7XHJcblx0XHRpZiAoIGRhdGVfYm9va2luZ19vYmpbICdzdW1tYXJ5J11bJ3Rvb2x0aXBfYXZhaWxhYmlsaXR5JyBdLmxlbmd0aCA+IDAgKXtcclxuXHRcdFx0dG9vbHRpcF90ZXh0ICs9ICBkYXRlX2Jvb2tpbmdfb2JqWyAnc3VtbWFyeSddWyd0b29sdGlwX2F2YWlsYWJpbGl0eScgXTtcclxuXHRcdH1cclxuXHRcdGlmICggZGF0ZV9ib29raW5nX29ialsgJ3N1bW1hcnknXVsndG9vbHRpcF9kYXlfY29zdCcgXS5sZW5ndGggPiAwICl7XHJcblx0XHRcdHRvb2x0aXBfdGV4dCArPSAgZGF0ZV9ib29raW5nX29ialsgJ3N1bW1hcnknXVsndG9vbHRpcF9kYXlfY29zdCcgXTtcclxuXHRcdH1cclxuXHRcdGlmICggZGF0ZV9ib29raW5nX29ialsgJ3N1bW1hcnknXVsndG9vbHRpcF90aW1lcycgXS5sZW5ndGggPiAwICl7XHJcblx0XHRcdHRvb2x0aXBfdGV4dCArPSAgZGF0ZV9ib29raW5nX29ialsgJ3N1bW1hcnknXVsndG9vbHRpcF90aW1lcycgXTtcclxuXHRcdH1cclxuXHRcdGlmICggZGF0ZV9ib29raW5nX29ialsgJ3N1bW1hcnknXVsndG9vbHRpcF9ib29raW5nX2RldGFpbHMnIF0ubGVuZ3RoID4gMCApe1xyXG5cdFx0XHR0b29sdGlwX3RleHQgKz0gIGRhdGVfYm9va2luZ19vYmpbICdzdW1tYXJ5J11bJ3Rvb2x0aXBfYm9va2luZ19kZXRhaWxzJyBdO1xyXG5cdFx0fVxyXG5cdFx0d3BiY19zZXRfdG9vbHRpcF9fX2Zvcl9fY2FsZW5kYXJfZGF0ZSggdG9vbHRpcF90ZXh0LCByZXNvdXJjZV9pZCwgY2xhc3NfZGF5ICk7XHJcblxyXG5cclxuXHJcblx0XHQvLyAgVSBuIGggbyB2IGUgciBpIG4gZyAgICBpbiAgICBVTlNFTEVDVEFCTEVfQ0FMRU5EQVIgIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cdFx0dmFyIGlzX3Vuc2VsZWN0YWJsZV9jYWxlbmRhciA9ICggalF1ZXJ5KCAnI2NhbGVuZGFyX2Jvb2tpbmdfdW5zZWxlY3RhYmxlJyArIHJlc291cmNlX2lkICkubGVuZ3RoID4gMCk7XHRcdFx0XHQvL0ZpeEluOiA4LjAuMS4yXHJcblx0XHR2YXIgaXNfYm9va2luZ19mb3JtX2V4aXN0ICAgID0gKCBqUXVlcnkoICcjYm9va2luZ19mb3JtX2RpdicgKyByZXNvdXJjZV9pZCApLmxlbmd0aCA+IDAgKTtcclxuXHJcblx0XHRpZiAoICggaXNfdW5zZWxlY3RhYmxlX2NhbGVuZGFyICkgJiYgKCAhIGlzX2Jvb2tpbmdfZm9ybV9leGlzdCApICl7XHJcblxyXG5cdFx0XHQvKipcclxuXHRcdFx0ICogIFVuIEhvdmVyIGFsbCBkYXRlcyBpbiBjYWxlbmRhciAod2l0aG91dCB0aGUgYm9va2luZyBmb3JtKSwgaWYgb25seSBBdmFpbGFiaWxpdHkgQ2FsZW5kYXIgaGVyZSBhbmQgd2UgZG8gbm90IGluc2VydCBCb29raW5nIGZvcm0gYnkgbWlzdGFrZS5cclxuXHRcdFx0ICovXHJcblxyXG5cdFx0XHR3cGJjX2NhbGVuZGFyc19fY2xlYXJfZGF5c19oaWdobGlnaHRpbmcoIHJlc291cmNlX2lkICk7IFx0XHRcdFx0XHRcdFx0Ly8gQ2xlYXIgZGF5cyBoaWdobGlnaHRpbmdcclxuXHJcblx0XHRcdHZhciBjc3Nfb2ZfY2FsZW5kYXIgPSAnLndwYmNfb25seV9jYWxlbmRhciAjY2FsZW5kYXJfYm9va2luZycgKyByZXNvdXJjZV9pZDtcclxuXHRcdFx0alF1ZXJ5KCBjc3Nfb2ZfY2FsZW5kYXIgKyAnIC5kYXRlcGljay1kYXlzLWNlbGwsICdcclxuXHRcdFx0XHQgICsgY3NzX29mX2NhbGVuZGFyICsgJyAuZGF0ZXBpY2stZGF5cy1jZWxsIGEnICkuY3NzKCAnY3Vyc29yJywgJ2RlZmF1bHQnICk7XHQvLyBTZXQgY3Vyc29yIHRvIERlZmF1bHRcclxuXHRcdFx0cmV0dXJuIGZhbHNlO1xyXG5cdFx0fVxyXG5cclxuXHJcblxyXG5cdFx0Ly8gIEQgYSB5IHMgICAgSCBvIHYgZSByIGkgbiBnICAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHRcdGlmIChcclxuXHRcdFx0ICAgKCBsb2NhdGlvbi5ocmVmLmluZGV4T2YoICdwYWdlPXdwYmMnICkgPT0gLTEgKVxyXG5cdFx0XHR8fCAoIGxvY2F0aW9uLmhyZWYuaW5kZXhPZiggJ3BhZ2U9d3BiYy1uZXcnICkgPiAwIClcclxuXHRcdFx0fHwgKCBsb2NhdGlvbi5ocmVmLmluZGV4T2YoICdwYWdlPXdwYmMtYXZhaWxhYmlsaXR5JyApID4gMCApXHJcblx0XHRcdHx8ICggICggbG9jYXRpb24uaHJlZi5pbmRleE9mKCAncGFnZT13cGJjLXNldHRpbmdzJyApID4gMCApICAmJlxyXG5cdFx0XHRcdCAgKCBsb2NhdGlvbi5ocmVmLmluZGV4T2YoICcmdGFiPWZvcm0nICkgPiAwIClcclxuXHRcdFx0ICAgKVxyXG5cdFx0KXtcclxuXHRcdFx0Ly8gVGhlIHNhbWUgYXMgZGF0ZXMgc2VsZWN0aW9uLCAgYnV0IGZvciBkYXlzIGhvdmVyaW5nXHJcblxyXG5cdFx0XHRpZiAoICdmdW5jdGlvbicgPT0gdHlwZW9mKCB3cGJjX19jYWxlbmRhcl9fZG9fZGF5c19oaWdobGlnaHRfX2JzICkgKXtcclxuXHRcdFx0XHR3cGJjX19jYWxlbmRhcl9fZG9fZGF5c19oaWdobGlnaHRfX2JzKCBzcWxfY2xhc3NfZGF5LCBkYXRlLCByZXNvdXJjZV9pZCApO1xyXG5cdFx0XHR9XHJcblx0XHR9XHJcblxyXG5cdH1cclxuXHJcblxyXG5cdC8qKlxyXG5cdCAqIFNlbGVjdCBjYWxlbmRhciBkYXRlIGNlbGxzXHJcblx0ICpcclxuXHQgKiBAcGFyYW0gZGF0ZVx0XHRcdFx0XHRcdFx0XHRcdFx0LSAgSmF2YVNjcmlwdCBEYXRlIE9iajogIFx0XHRNb24gRGVjIDExIDIwMjMgMDA6MDA6MDAgR01UKzAyMDAgKEVhc3Rlcm4gRXVyb3BlYW4gU3RhbmRhcmQgVGltZSlcclxuXHQgKiBAcGFyYW0gY2FsZW5kYXJfcGFyYW1zX2Fyclx0XHRcdFx0XHRcdC0gIENhbGVuZGFyIFNldHRpbmdzIE9iamVjdDogIFx0e1xyXG5cdCAqXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQgIFx0XHRcdFx0XHRcdFwicmVzb3VyY2VfaWRcIjogNFxyXG5cdCAqXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0fVxyXG5cdCAqIEBwYXJhbSBkYXRlcGlja190aGlzXHRcdFx0XHRcdFx0XHRcdC0gdGhpcyBvZiBkYXRlcGljayBPYmpcclxuXHQgKlxyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfX2NhbGVuZGFyX19vbl9zZWxlY3RfZGF5cyggZGF0ZSwgY2FsZW5kYXJfcGFyYW1zX2FyciwgZGF0ZXBpY2tfdGhpcyApe1xyXG5cclxuXHRcdHZhciByZXNvdXJjZV9pZCA9ICggJ3VuZGVmaW5lZCcgIT09IHR5cGVvZihjYWxlbmRhcl9wYXJhbXNfYXJyWyAncmVzb3VyY2VfaWQnIF0pICkgPyBjYWxlbmRhcl9wYXJhbXNfYXJyWyAncmVzb3VyY2VfaWQnIF0gOiAnMSc7XHRcdC8vICcxJ1xyXG5cclxuXHRcdC8vIFNldCB1bnNlbGVjdGFibGUsICBpZiBvbmx5IEF2YWlsYWJpbGl0eSBDYWxlbmRhciAgaGVyZSAoYW5kIHdlIGRvIG5vdCBpbnNlcnQgQm9va2luZyBmb3JtIGJ5IG1pc3Rha2UpLlxyXG5cdFx0dmFyIGlzX3Vuc2VsZWN0YWJsZV9jYWxlbmRhciA9ICggalF1ZXJ5KCAnI2NhbGVuZGFyX2Jvb2tpbmdfdW5zZWxlY3RhYmxlJyArIHJlc291cmNlX2lkICkubGVuZ3RoID4gMCk7XHRcdFx0XHQvL0ZpeEluOiA4LjAuMS4yXHJcblx0XHR2YXIgaXNfYm9va2luZ19mb3JtX2V4aXN0ICAgID0gKCBqUXVlcnkoICcjYm9va2luZ19mb3JtX2RpdicgKyByZXNvdXJjZV9pZCApLmxlbmd0aCA+IDAgKTtcclxuXHRcdGlmICggKCBpc191bnNlbGVjdGFibGVfY2FsZW5kYXIgKSAmJiAoICEgaXNfYm9va2luZ19mb3JtX2V4aXN0ICkgKXtcclxuXHRcdFx0d3BiY19jYWxlbmRhcl9fdW5zZWxlY3RfYWxsX2RhdGVzKCByZXNvdXJjZV9pZCApO1x0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0Ly8gVW5zZWxlY3QgRGF0ZXNcclxuXHRcdFx0alF1ZXJ5KCcud3BiY19vbmx5X2NhbGVuZGFyIC5wb3BvdmVyX2NhbGVuZGFyX2hvdmVyJykucmVtb3ZlKCk7ICAgICAgICAgICAgICAgICAgICAgIFx0XHRcdFx0XHRcdFx0Ly8gSGlkZSBhbGwgb3BlbmVkIHBvcG92ZXJzXHJcblx0XHRcdHJldHVybiBmYWxzZTtcclxuXHRcdH1cclxuXHJcblx0XHRqUXVlcnkoICcjZGF0ZV9ib29raW5nJyArIHJlc291cmNlX2lkICkudmFsKCBkYXRlICk7XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQvLyBBZGQgc2VsZWN0ZWQgZGF0ZXMgdG8gIGhpZGRlbiB0ZXh0YXJlYVxyXG5cclxuXHJcblx0XHRpZiAoICdmdW5jdGlvbicgPT09IHR5cGVvZiAod3BiY19fY2FsZW5kYXJfX2RvX2RheXNfc2VsZWN0X19icykgKXsgd3BiY19fY2FsZW5kYXJfX2RvX2RheXNfc2VsZWN0X19icyggZGF0ZSwgcmVzb3VyY2VfaWQgKTsgfVxyXG5cclxuXHRcdHdwYmNfZGlzYWJsZV90aW1lX2ZpZWxkc19pbl9ib29raW5nX2Zvcm0oIHJlc291cmNlX2lkICk7XHJcblxyXG5cdFx0Ly8gSG9vayAtLSB0cmlnZ2VyIGRheSBzZWxlY3Rpb24gLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHRcdHZhciBtb3VzZV9jbGlja2VkX2RhdGVzID0gZGF0ZTtcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdC8vIENhbiBiZTogXCIwNS4xMC4yMDIzIC0gMDcuMTAuMjAyM1wiICB8ICBcIjEwLjEwLjIwMjMgLSAxMC4xMC4yMDIzXCIgIHxcclxuXHRcdHZhciBhbGxfc2VsZWN0ZWRfZGF0ZXNfYXJyID0gd3BiY19nZXRfX3NlbGVjdGVkX2RhdGVzX3NxbF9fYXNfYXJyKCByZXNvdXJjZV9pZCApO1x0XHRcdFx0XHRcdFx0XHRcdC8vIENhbiBiZTogWyBcIjIwMjMtMTAtMDVcIiwgXCIyMDIzLTEwLTA2XCIsIFwiMjAyMy0xMC0wN1wiLCDigKYgXVxyXG5cdFx0alF1ZXJ5KCBcIi5ib29raW5nX2Zvcm1fZGl2XCIgKS50cmlnZ2VyKCBcImRhdGVfc2VsZWN0ZWRcIiwgWyByZXNvdXJjZV9pZCwgbW91c2VfY2xpY2tlZF9kYXRlcywgYWxsX3NlbGVjdGVkX2RhdGVzX2FyciBdICk7XHJcblx0fVxyXG5cclxuXHJcblx0LyoqXHJcblx0ICogLS0gIFQgaSBtIGUgICAgRiBpIGUgbCBkIHMgICAgIHN0YXJ0ICAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cdCAqL1xyXG5cclxuXHQvKipcclxuXHQgKiBEaXNhYmxlIHRpbWUgc2xvdHMgaW4gYm9va2luZyBmb3JtIGRlcGVuZCBvbiBzZWxlY3RlZCBkYXRlcyBhbmQgYm9va2VkIGRhdGVzL3RpbWVzXHJcblx0ICpcclxuXHQgKiBAcGFyYW0gcmVzb3VyY2VfaWRcclxuXHQgKi9cclxuXHRmdW5jdGlvbiB3cGJjX2Rpc2FibGVfdGltZV9maWVsZHNfaW5fYm9va2luZ19mb3JtKCByZXNvdXJjZV9pZCApe1xyXG5cclxuXHRcdC8qKlxyXG5cdFx0ICogXHQxLiBHZXQgYWxsIHRpbWUgZmllbGRzIGluIHRoZSBib29raW5nIGZvcm0gYXMgYXJyYXkgIG9mIG9iamVjdHNcclxuXHRcdCAqIFx0XHRcdFx0XHRbXHJcblx0XHQgKiBcdFx0XHRcdFx0IFx0ICAge1x0anF1ZXJ5X29wdGlvbjogICAgICBqUXVlcnlfT2JqZWN0IHt9XHJcblx0XHQgKiBcdFx0XHRcdFx0XHRcdFx0bmFtZTogICAgICAgICAgICAgICAncmFuZ2V0aW1lMltdJ1xyXG5cdFx0ICogXHRcdFx0XHRcdFx0XHRcdHRpbWVzX2FzX3NlY29uZHM6ICAgWyAyMTYwMCwgMjM0MDAgXVxyXG5cdFx0ICogXHRcdFx0XHRcdFx0XHRcdHZhbHVlX29wdGlvbl8yNGg6ICAgJzA2OjAwIC0gMDY6MzAnXHJcblx0XHQgKiBcdFx0XHRcdFx0ICAgICB9XHJcblx0XHQgKiBcdFx0XHRcdFx0ICAuLi5cclxuXHRcdCAqIFx0XHRcdFx0XHRcdCAgIHtcdGpxdWVyeV9vcHRpb246ICAgICAgalF1ZXJ5X09iamVjdCB7fVxyXG5cdFx0ICogXHRcdFx0XHRcdFx0XHRcdG5hbWU6ICAgICAgICAgICAgICAgJ3N0YXJ0dGltZTJbXSdcclxuXHRcdCAqIFx0XHRcdFx0XHRcdFx0XHR0aW1lc19hc19zZWNvbmRzOiAgIFsgMjE2MDAgXVxyXG5cdFx0ICogXHRcdFx0XHRcdFx0XHRcdHZhbHVlX29wdGlvbl8yNGg6ICAgJzA2OjAwJ1xyXG5cdFx0ICogIFx0XHRcdFx0XHQgICAgfVxyXG5cdFx0ICogXHRcdFx0XHRcdCBdXHJcblx0XHQgKi9cclxuXHRcdHZhciB0aW1lX2ZpZWxkc19vYmpfYXJyID0gd3BiY19nZXRfX3RpbWVfZmllbGRzX19pbl9ib29raW5nX2Zvcm1fX2FzX2FyciggcmVzb3VyY2VfaWQgKTtcclxuXHJcblx0XHQvLyAyLiBHZXQgYWxsIHNlbGVjdGVkIGRhdGVzIGluICBTUUwgZm9ybWF0ICBsaWtlIHRoaXMgWyBcIjIwMjMtMDgtMjNcIiwgXCIyMDIzLTA4LTI0XCIsIFwiMjAyMy0wOC0yNVwiLCAuLi4gXVxyXG5cdFx0dmFyIHNlbGVjdGVkX2RhdGVzX2FyciA9IHdwYmNfZ2V0X19zZWxlY3RlZF9kYXRlc19zcWxfX2FzX2FyciggcmVzb3VyY2VfaWQgKTtcclxuXHJcblx0XHQvLyAzLiBHZXQgY2hpbGQgYm9va2luZyByZXNvdXJjZXMgIG9yIHNpbmdsZSBib29raW5nIHJlc291cmNlICB0aGF0ICBleGlzdCAgaW4gZGF0ZXNcclxuXHRcdHZhciBjaGlsZF9yZXNvdXJjZXNfYXJyID0gd3BiY19jbG9uZV9vYmooIF93cGJjLmJvb2tpbmdfX2dldF9wYXJhbV92YWx1ZSggcmVzb3VyY2VfaWQsICdyZXNvdXJjZXNfaWRfYXJyX19pbl9kYXRlcycgKSApO1xyXG5cclxuXHRcdHZhciBzcWxfZGF0ZTtcclxuXHRcdHZhciBjaGlsZF9yZXNvdXJjZV9pZDtcclxuXHRcdHZhciBtZXJnZWRfc2Vjb25kcztcclxuXHRcdHZhciB0aW1lX2ZpZWxkc19vYmo7XHJcblx0XHR2YXIgaXNfaW50ZXJzZWN0O1xyXG5cdFx0dmFyIGlzX2NoZWNrX2luO1xyXG5cclxuXHRcdC8vIDQuIExvb3AgIGFsbCAgdGltZSBGaWVsZHMgb3B0aW9uc1xyXG5cdFx0Zm9yICggdmFyIGZpZWxkX2tleSBpbiB0aW1lX2ZpZWxkc19vYmpfYXJyICl7XHJcblxyXG5cdFx0XHR0aW1lX2ZpZWxkc19vYmpfYXJyWyBmaWVsZF9rZXkgXS5kaXNhYmxlZCA9IDA7ICAgICAgICAgIC8vIEJ5IGRlZmF1bHQgdGhpcyB0aW1lIGZpZWxkIGlzIG5vdCBkaXNhYmxlZFxyXG5cclxuXHRcdFx0dGltZV9maWVsZHNfb2JqID0gdGltZV9maWVsZHNfb2JqX2FyclsgZmllbGRfa2V5IF07XHRcdC8vIHsgdGltZXNfYXNfc2Vjb25kczogWyAyMTYwMCwgMjM0MDAgXSwgdmFsdWVfb3B0aW9uXzI0aDogJzA2OjAwIC0gMDY6MzAnLCBuYW1lOiAncmFuZ2V0aW1lMltdJywganF1ZXJ5X29wdGlvbjogalF1ZXJ5X09iamVjdCB7fX1cclxuXHJcblx0XHRcdC8vIExvb3AgIGFsbCAgc2VsZWN0ZWQgZGF0ZXNcclxuXHRcdFx0Zm9yICggdmFyIGkgPSAwOyBpIDwgc2VsZWN0ZWRfZGF0ZXNfYXJyLmxlbmd0aDsgaSsrICl7XHJcblxyXG5cdFx0XHRcdC8vRml4SW46IDkuOS4wLjMxXHJcblx0XHRcdFx0aWYgKFxyXG5cdFx0XHRcdFx0ICAgKCAnT2ZmJyA9PT0gX3dwYmMuY2FsZW5kYXJfX2dldF9wYXJhbV92YWx1ZSggcmVzb3VyY2VfaWQsICdib29raW5nX3JlY3VycmVudF90aW1lJyApIClcclxuXHRcdFx0XHRcdCYmICggc2VsZWN0ZWRfZGF0ZXNfYXJyLmxlbmd0aD4xIClcclxuXHRcdFx0XHQpe1xyXG5cdFx0XHRcdFx0Ly9UT0RPOiBza2lwIHNvbWUgZmllbGRzIGNoZWNraW5nIGlmIGl0J3Mgc3RhcnQgLyBlbmQgdGltZSBmb3IgbXVscGxlIGRhdGVzICBzZWxlY3Rpb24gIG1vZGUuXHJcblx0XHRcdFx0XHQvL1RPRE86IHdlIG5lZWQgdG8gZml4IHNpdHVhdGlvbiAgZm9yIGVudGltZXMsICB3aGVuICB1c2VyICBzZWxlY3QgIHNldmVyYWwgIGRhdGVzLCAgYW5kIGluIHN0YXJ0ICB0aW1lIGJvb2tlZCAwMDowMCAtIDE1OjAwICwgYnV0IHN5c3RzbWUgYmxvY2sgdW50aWxsIDE1OjAwIHRoZSBlbmQgdGltZSBhcyB3ZWxsLCAgd2hpY2ggIGlzIHdyb25nLCAgYmVjYXVzZSBpdCAyIG9yIDMgZGF0ZXMgc2VsZWN0aW9uICBhbmQgZW5kIGRhdGUgY2FuIGJlIGZ1bGx1ICBhdmFpbGFibGVcclxuXHJcblx0XHRcdFx0XHRpZiAoICgwID09IGkpICYmICh0aW1lX2ZpZWxkc19vYmpbICduYW1lJyBdLmluZGV4T2YoICdlbmR0aW1lJyApID49IDApICl7XHJcblx0XHRcdFx0XHRcdGJyZWFrO1xyXG5cdFx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0aWYgKCAoIChzZWxlY3RlZF9kYXRlc19hcnIubGVuZ3RoLTEpID09IGkgKSAmJiAodGltZV9maWVsZHNfb2JqWyAnbmFtZScgXS5pbmRleE9mKCAnc3RhcnR0aW1lJyApID49IDApICl7XHJcblx0XHRcdFx0XHRcdGJyZWFrO1xyXG5cdFx0XHRcdFx0fVxyXG5cdFx0XHRcdH1cclxuXHJcblx0XHRcdFx0Ly8gR2V0IERhdGU6ICcyMDIzLTA4LTE4J1xyXG5cdFx0XHRcdHNxbF9kYXRlID0gc2VsZWN0ZWRfZGF0ZXNfYXJyWyBpIF07XHJcblxyXG5cclxuXHRcdFx0XHR2YXIgaG93X21hbnlfcmVzb3VyY2VzX2ludGVyc2VjdGVkID0gMDtcclxuXHRcdFx0XHQvLyBMb29wIGFsbCByZXNvdXJjZXMgSURcclxuXHRcdFx0XHRmb3IgKCB2YXIgcmVzX2tleSBpbiBjaGlsZF9yZXNvdXJjZXNfYXJyICl7XHJcblxyXG5cdFx0XHRcdFx0Y2hpbGRfcmVzb3VyY2VfaWQgPSBjaGlsZF9yZXNvdXJjZXNfYXJyWyByZXNfa2V5IF07XHJcblxyXG5cdFx0XHRcdFx0Ly8gX3dwYmMuYm9va2luZ3NfaW5fY2FsZW5kYXJfX2dldF9mb3JfZGF0ZSgyLCcyMDIzLTA4LTIxJylbMTJdLmJvb2tlZF90aW1lX3Nsb3RzLm1lcmdlZF9zZWNvbmRzXHRcdD0gWyBcIjA3OjAwOjExIC0gMDc6MzA6MDJcIiwgXCIxMDowMDoxMSAtIDAwOjAwOjAwXCIgXVxyXG5cdFx0XHRcdFx0Ly8gX3dwYmMuYm9va2luZ3NfaW5fY2FsZW5kYXJfX2dldF9mb3JfZGF0ZSgyLCcyMDIzLTA4LTIxJylbMl0uYm9va2VkX3RpbWVfc2xvdHMubWVyZ2VkX3NlY29uZHNcdFx0XHQ9IFsgIFsgMjUyMTEsIDI3MDAyIF0sIFsgMzYwMTEsIDg2NDAwIF0gIF1cclxuXHJcblx0XHRcdFx0XHRpZiAoIGZhbHNlICE9PSBfd3BiYy5ib29raW5nc19pbl9jYWxlbmRhcl9fZ2V0X2Zvcl9kYXRlKCByZXNvdXJjZV9pZCwgc3FsX2RhdGUgKSApe1xyXG5cdFx0XHRcdFx0XHRtZXJnZWRfc2Vjb25kcyA9IF93cGJjLmJvb2tpbmdzX2luX2NhbGVuZGFyX19nZXRfZm9yX2RhdGUoIHJlc291cmNlX2lkLCBzcWxfZGF0ZSApWyBjaGlsZF9yZXNvdXJjZV9pZCBdLmJvb2tlZF90aW1lX3Nsb3RzLm1lcmdlZF9zZWNvbmRzO1x0XHQvLyBbICBbIDI1MjExLCAyNzAwMiBdLCBbIDM2MDExLCA4NjQwMCBdICBdXHJcblx0XHRcdFx0XHR9IGVsc2Uge1xyXG5cdFx0XHRcdFx0XHRtZXJnZWRfc2Vjb25kcyA9IFtdO1xyXG5cdFx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0aWYgKCB0aW1lX2ZpZWxkc19vYmoudGltZXNfYXNfc2Vjb25kcy5sZW5ndGggPiAxICl7XHJcblx0XHRcdFx0XHRcdGlzX2ludGVyc2VjdCA9IHdwYmNfaXNfaW50ZXJzZWN0X19yYW5nZV90aW1lX2ludGVydmFsKCAgW1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRbXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0KCBwYXJzZUludCggdGltZV9maWVsZHNfb2JqLnRpbWVzX2FzX3NlY29uZHNbMF0gKSArIDIwICksXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0KCBwYXJzZUludCggdGltZV9maWVsZHNfb2JqLnRpbWVzX2FzX3NlY29uZHNbMV0gKSAtIDIwIClcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0LCBtZXJnZWRfc2Vjb25kcyApO1xyXG5cdFx0XHRcdFx0fSBlbHNlIHtcclxuXHRcdFx0XHRcdFx0aXNfY2hlY2tfaW4gPSAoLTEgIT09IHRpbWVfZmllbGRzX29iai5uYW1lLmluZGV4T2YoICdzdGFydCcgKSk7XHJcblx0XHRcdFx0XHRcdGlzX2ludGVyc2VjdCA9IHdwYmNfaXNfaW50ZXJzZWN0X19vbmVfdGltZV9pbnRlcnZhbChcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCggKCBpc19jaGVja19pbiApXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQgID8gcGFyc2VJbnQoIHRpbWVfZmllbGRzX29iai50aW1lc19hc19zZWNvbmRzICkgKyAyMFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0ICA6IHBhcnNlSW50KCB0aW1lX2ZpZWxkc19vYmoudGltZXNfYXNfc2Vjb25kcyApIC0gMjBcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdClcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCwgbWVyZ2VkX3NlY29uZHMgKTtcclxuXHRcdFx0XHRcdH1cclxuXHRcdFx0XHRcdGlmIChpc19pbnRlcnNlY3Qpe1xyXG5cdFx0XHRcdFx0XHRob3dfbWFueV9yZXNvdXJjZXNfaW50ZXJzZWN0ZWQrKztcdFx0XHQvLyBJbmNyZWFzZVxyXG5cdFx0XHRcdFx0fVxyXG5cclxuXHRcdFx0XHR9XHJcblxyXG5cdFx0XHRcdGlmICggY2hpbGRfcmVzb3VyY2VzX2Fyci5sZW5ndGggPT0gaG93X21hbnlfcmVzb3VyY2VzX2ludGVyc2VjdGVkICkge1xyXG5cdFx0XHRcdFx0Ly8gQWxsIHJlc291cmNlcyBpbnRlcnNlY3RlZCwgIHRoZW4gIGl0J3MgbWVhbnMgdGhhdCB0aGlzIHRpbWUtc2xvdCBvciB0aW1lIG11c3QgIGJlICBEaXNhYmxlZCwgYW5kIHdlIGNhbiAgZXhpc3QgIGZyb20gICBzZWxlY3RlZF9kYXRlc19hcnIgTE9PUFxyXG5cclxuXHRcdFx0XHRcdHRpbWVfZmllbGRzX29ial9hcnJbIGZpZWxkX2tleSBdLmRpc2FibGVkID0gMTtcclxuXHRcdFx0XHRcdGJyZWFrO1x0XHRcdFx0XHRcdFx0XHRcdFx0XHQvLyBleGlzdCAgZnJvbSAgIERhdGVzIExPT1BcclxuXHRcdFx0XHR9XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHJcblxyXG5cdFx0Ly8gNS4gTm93IHdlIGNhbiBkaXNhYmxlIHRpbWUgc2xvdCBpbiBIVE1MIGJ5ICB1c2luZyAgKCBmaWVsZC5kaXNhYmxlZCA9PSAxICkgcHJvcGVydHlcclxuXHRcdHdwYmNfX2h0bWxfX3RpbWVfZmllbGRfb3B0aW9uc19fc2V0X2Rpc2FibGVkKCB0aW1lX2ZpZWxkc19vYmpfYXJyICk7XHJcblxyXG5cdFx0alF1ZXJ5KCBcIi5ib29raW5nX2Zvcm1fZGl2XCIgKS50cmlnZ2VyKCAnd3BiY19ob29rX3RpbWVzbG90c19kaXNhYmxlZCcsIFtyZXNvdXJjZV9pZCwgc2VsZWN0ZWRfZGF0ZXNfYXJyXSApO1x0XHRcdFx0XHQvLyBUcmlnZ2VyIGhvb2sgb24gZGlzYWJsaW5nIHRpbWVzbG90cy5cdFx0VXNhZ2U6IFx0alF1ZXJ5KCBcIi5ib29raW5nX2Zvcm1fZGl2XCIgKS5vbiggJ3dwYmNfaG9va190aW1lc2xvdHNfZGlzYWJsZWQnLCBmdW5jdGlvbiAoIGV2ZW50LCBia190eXBlLCBhbGxfZGF0ZXMgKXsgLi4uIH0gKTtcdFx0Ly9GaXhJbjogOC43LjExLjlcclxuXHR9XHJcblxyXG5cdFx0LyoqXHJcblx0XHQgKiBJcyBudW1iZXIgaW5zaWRlIC9pbnRlcnNlY3QgIG9mIGFycmF5IG9mIGludGVydmFscyA/XHJcblx0XHQgKlxyXG5cdFx0ICogQHBhcmFtIHRpbWVfQVx0XHQgICAgIFx0LSAyNTgwMFxyXG5cdFx0ICogQHBhcmFtIHRpbWVfaW50ZXJ2YWxfQlx0XHQtIFsgIFsgMjUyMTEsIDI3MDAyIF0sIFsgMzYwMTEsIDg2NDAwIF0gIF1cclxuXHRcdCAqIEByZXR1cm5zIHtib29sZWFufVxyXG5cdFx0ICovXHJcblx0XHRmdW5jdGlvbiB3cGJjX2lzX2ludGVyc2VjdF9fb25lX3RpbWVfaW50ZXJ2YWwoIHRpbWVfQSwgdGltZV9pbnRlcnZhbF9CICl7XHJcblxyXG5cdFx0XHRmb3IgKCB2YXIgaiA9IDA7IGogPCB0aW1lX2ludGVydmFsX0IubGVuZ3RoOyBqKysgKXtcclxuXHJcblx0XHRcdFx0aWYgKCAocGFyc2VJbnQoIHRpbWVfQSApID4gcGFyc2VJbnQoIHRpbWVfaW50ZXJ2YWxfQlsgaiBdWyAwIF0gKSkgJiYgKHBhcnNlSW50KCB0aW1lX0EgKSA8IHBhcnNlSW50KCB0aW1lX2ludGVydmFsX0JbIGogXVsgMSBdICkpICl7XHJcblx0XHRcdFx0XHRyZXR1cm4gdHJ1ZVxyXG5cdFx0XHRcdH1cclxuXHJcblx0XHRcdFx0Ly8gaWYgKCAoIHBhcnNlSW50KCB0aW1lX0EgKSA9PSBwYXJzZUludCggdGltZV9pbnRlcnZhbF9CWyBqIF1bIDAgXSApICkgfHwgKCBwYXJzZUludCggdGltZV9BICkgPT0gcGFyc2VJbnQoIHRpbWVfaW50ZXJ2YWxfQlsgaiBdWyAxIF0gKSApICkge1xyXG5cdFx0XHRcdC8vIFx0XHRcdC8vIFRpbWUgQSBqdXN0ICBhdCAgdGhlIGJvcmRlciBvZiBpbnRlcnZhbFxyXG5cdFx0XHRcdC8vIH1cclxuXHRcdFx0fVxyXG5cclxuXHRcdCAgICByZXR1cm4gZmFsc2U7XHJcblx0XHR9XHJcblxyXG5cdFx0LyoqXHJcblx0XHQgKiBJcyB0aGVzZSBhcnJheSBvZiBpbnRlcnZhbHMgaW50ZXJzZWN0ZWQgP1xyXG5cdFx0ICpcclxuXHRcdCAqIEBwYXJhbSB0aW1lX2ludGVydmFsX0FcdFx0LSBbIFsgMjE2MDAsIDIzNDAwIF0gXVxyXG5cdFx0ICogQHBhcmFtIHRpbWVfaW50ZXJ2YWxfQlx0XHQtIFsgIFsgMjUyMTEsIDI3MDAyIF0sIFsgMzYwMTEsIDg2NDAwIF0gIF1cclxuXHRcdCAqIEByZXR1cm5zIHtib29sZWFufVxyXG5cdFx0ICovXHJcblx0XHRmdW5jdGlvbiB3cGJjX2lzX2ludGVyc2VjdF9fcmFuZ2VfdGltZV9pbnRlcnZhbCggdGltZV9pbnRlcnZhbF9BLCB0aW1lX2ludGVydmFsX0IgKXtcclxuXHJcblx0XHRcdHZhciBpc19pbnRlcnNlY3Q7XHJcblxyXG5cdFx0XHRmb3IgKCB2YXIgaSA9IDA7IGkgPCB0aW1lX2ludGVydmFsX0EubGVuZ3RoOyBpKysgKXtcclxuXHJcblx0XHRcdFx0Zm9yICggdmFyIGogPSAwOyBqIDwgdGltZV9pbnRlcnZhbF9CLmxlbmd0aDsgaisrICl7XHJcblxyXG5cdFx0XHRcdFx0aXNfaW50ZXJzZWN0ID0gd3BiY19pbnRlcnZhbHNfX2lzX2ludGVyc2VjdGVkKCB0aW1lX2ludGVydmFsX0FbIGkgXSwgdGltZV9pbnRlcnZhbF9CWyBqIF0gKTtcclxuXHJcblx0XHRcdFx0XHRpZiAoIGlzX2ludGVyc2VjdCApe1xyXG5cdFx0XHRcdFx0XHRyZXR1cm4gdHJ1ZTtcclxuXHRcdFx0XHRcdH1cclxuXHRcdFx0XHR9XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdHJldHVybiBmYWxzZTtcclxuXHRcdH1cclxuXHJcblx0XHQvKipcclxuXHRcdCAqIEdldCBhbGwgdGltZSBmaWVsZHMgaW4gdGhlIGJvb2tpbmcgZm9ybSBhcyBhcnJheSAgb2Ygb2JqZWN0c1xyXG5cdFx0ICpcclxuXHRcdCAqIEBwYXJhbSByZXNvdXJjZV9pZFxyXG5cdFx0ICogQHJldHVybnMgW11cclxuXHRcdCAqXHJcblx0XHQgKiBcdFx0RXhhbXBsZTpcclxuXHRcdCAqIFx0XHRcdFx0XHRbXHJcblx0XHQgKiBcdFx0XHRcdFx0IFx0ICAge1xyXG5cdFx0ICogXHRcdFx0XHRcdFx0XHRcdHZhbHVlX29wdGlvbl8yNGg6ICAgJzA2OjAwIC0gMDY6MzAnXHJcblx0XHQgKiBcdFx0XHRcdFx0XHRcdFx0dGltZXNfYXNfc2Vjb25kczogICBbIDIxNjAwLCAyMzQwMCBdXHJcblx0XHQgKiBcdFx0XHRcdFx0IFx0ICAgXHRcdGpxdWVyeV9vcHRpb246ICAgICAgalF1ZXJ5X09iamVjdCB7fVxyXG5cdFx0ICogXHRcdFx0XHRcdFx0XHRcdG5hbWU6ICAgICAgICAgICAgICAgJ3JhbmdldGltZTJbXSdcclxuXHRcdCAqIFx0XHRcdFx0XHQgICAgIH1cclxuXHRcdCAqIFx0XHRcdFx0XHQgIC4uLlxyXG5cdFx0ICogXHRcdFx0XHRcdFx0ICAge1xyXG5cdFx0ICogXHRcdFx0XHRcdFx0XHRcdHZhbHVlX29wdGlvbl8yNGg6ICAgJzA2OjAwJ1xyXG5cdFx0ICogXHRcdFx0XHRcdFx0XHRcdHRpbWVzX2FzX3NlY29uZHM6ICAgWyAyMTYwMCBdXHJcblx0XHQgKiBcdFx0XHRcdFx0XHQgICBcdFx0anF1ZXJ5X29wdGlvbjogICAgICBqUXVlcnlfT2JqZWN0IHt9XHJcblx0XHQgKiBcdFx0XHRcdFx0XHRcdFx0bmFtZTogICAgICAgICAgICAgICAnc3RhcnR0aW1lMltdJ1xyXG5cdFx0ICogIFx0XHRcdFx0XHQgICAgfVxyXG5cdFx0ICogXHRcdFx0XHRcdCBdXHJcblx0XHQgKi9cclxuXHRcdGZ1bmN0aW9uIHdwYmNfZ2V0X190aW1lX2ZpZWxkc19faW5fYm9va2luZ19mb3JtX19hc19hcnIoIHJlc291cmNlX2lkICl7XHJcblx0XHQgICAgLyoqXHJcblx0XHRcdCAqIEZpZWxkcyB3aXRoICBbXSAgbGlrZSB0aGlzICAgc2VsZWN0W25hbWU9XCJyYW5nZXRpbWUxW11cIl1cclxuXHRcdFx0ICogaXQncyB3aGVuIHdlIGhhdmUgJ211bHRpcGxlJyBpbiBzaG9ydGNvZGU6ICAgW3NlbGVjdCogcmFuZ2V0aW1lIG11bHRpcGxlICBcIjA2OjAwIC0gMDY6MzBcIiAuLi4gXVxyXG5cdFx0XHQgKi9cclxuXHRcdFx0dmFyIHRpbWVfZmllbGRzX2Fycj1bXHJcblx0XHRcdFx0XHRcdFx0XHRcdCdzZWxlY3RbbmFtZT1cInJhbmdldGltZScgKyByZXNvdXJjZV9pZCArICdcIl0nLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHQnc2VsZWN0W25hbWU9XCJyYW5nZXRpbWUnICsgcmVzb3VyY2VfaWQgKyAnW11cIl0nLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHQnc2VsZWN0W25hbWU9XCJzdGFydHRpbWUnICsgcmVzb3VyY2VfaWQgKyAnXCJdJyxcclxuXHRcdFx0XHRcdFx0XHRcdFx0J3NlbGVjdFtuYW1lPVwic3RhcnR0aW1lJyArIHJlc291cmNlX2lkICsgJ1tdXCJdJyxcclxuXHRcdFx0XHRcdFx0XHRcdFx0J3NlbGVjdFtuYW1lPVwiZW5kdGltZScgKyByZXNvdXJjZV9pZCArICdcIl0nLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHQnc2VsZWN0W25hbWU9XCJlbmR0aW1lJyArIHJlc291cmNlX2lkICsgJ1tdXCJdJ1xyXG5cdFx0XHRcdFx0XHRcdFx0XTtcclxuXHJcblx0XHRcdHZhciB0aW1lX2ZpZWxkc19vYmpfYXJyID0gW107XHJcblxyXG5cdFx0XHQvLyBMb29wIGFsbCBUaW1lIEZpZWxkc1xyXG5cdFx0XHRmb3IgKCB2YXIgY3RmPSAwOyBjdGYgPCB0aW1lX2ZpZWxkc19hcnIubGVuZ3RoOyBjdGYrKyApe1xyXG5cclxuXHRcdFx0XHR2YXIgdGltZV9maWVsZCA9IHRpbWVfZmllbGRzX2FyclsgY3RmIF07XHJcblx0XHRcdFx0dmFyIHRpbWVfb3B0aW9uID0galF1ZXJ5KCB0aW1lX2ZpZWxkICsgJyBvcHRpb24nICk7XHJcblxyXG5cdFx0XHRcdC8vIExvb3AgYWxsIG9wdGlvbnMgaW4gdGltZSBmaWVsZFxyXG5cdFx0XHRcdGZvciAoIHZhciBqID0gMDsgaiA8IHRpbWVfb3B0aW9uLmxlbmd0aDsgaisrICl7XHJcblxyXG5cdFx0XHRcdFx0dmFyIGpxdWVyeV9vcHRpb24gPSBqUXVlcnkoIHRpbWVfZmllbGQgKyAnIG9wdGlvbjplcSgnICsgaiArICcpJyApO1xyXG5cdFx0XHRcdFx0dmFyIHZhbHVlX29wdGlvbl9zZWNvbmRzX2FyciA9IGpxdWVyeV9vcHRpb24udmFsKCkuc3BsaXQoICctJyApO1xyXG5cdFx0XHRcdFx0dmFyIHRpbWVzX2FzX3NlY29uZHMgPSBbXTtcclxuXHJcblx0XHRcdFx0XHQvLyBHZXQgdGltZSBhcyBzZWNvbmRzXHJcblx0XHRcdFx0XHRpZiAoIHZhbHVlX29wdGlvbl9zZWNvbmRzX2Fyci5sZW5ndGggKXtcdFx0XHRcdFx0XHRcdFx0XHQvL0ZpeEluOiA5LjguMTAuMVxyXG5cdFx0XHRcdFx0XHRmb3IgKCBsZXQgaSA9IDA7IGkgPCB2YWx1ZV9vcHRpb25fc2Vjb25kc19hcnIubGVuZ3RoOyBpKysgKXtcdFx0Ly9GaXhJbjogMTAuMC4wLjU2XHJcblx0XHRcdFx0XHRcdFx0Ly8gdmFsdWVfb3B0aW9uX3NlY29uZHNfYXJyW2ldID0gJzE0OjAwICcgIHwgJyAxNjowMCcgICAoaWYgZnJvbSAncmFuZ2V0aW1lJykgYW5kICcxNjowMCcgIGlmIChzdGFydC9lbmQgdGltZSlcclxuXHJcblx0XHRcdFx0XHRcdFx0dmFyIHN0YXJ0X2VuZF90aW1lc19hcnIgPSB2YWx1ZV9vcHRpb25fc2Vjb25kc19hcnJbIGkgXS50cmltKCkuc3BsaXQoICc6JyApO1xyXG5cclxuXHRcdFx0XHRcdFx0XHR2YXIgdGltZV9pbl9zZWNvbmRzID0gcGFyc2VJbnQoIHN0YXJ0X2VuZF90aW1lc19hcnJbIDAgXSApICogNjAgKiA2MCArIHBhcnNlSW50KCBzdGFydF9lbmRfdGltZXNfYXJyWyAxIF0gKSAqIDYwO1xyXG5cclxuXHRcdFx0XHRcdFx0XHR0aW1lc19hc19zZWNvbmRzLnB1c2goIHRpbWVfaW5fc2Vjb25kcyApO1xyXG5cdFx0XHRcdFx0XHR9XHJcblx0XHRcdFx0XHR9XHJcblxyXG5cdFx0XHRcdFx0dGltZV9maWVsZHNfb2JqX2Fyci5wdXNoKCB7XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCduYW1lJyAgICAgICAgICAgIDogalF1ZXJ5KCB0aW1lX2ZpZWxkICkuYXR0ciggJ25hbWUnICksXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCd2YWx1ZV9vcHRpb25fMjRoJzoganF1ZXJ5X29wdGlvbi52YWwoKSxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J2pxdWVyeV9vcHRpb24nICAgOiBqcXVlcnlfb3B0aW9uLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQndGltZXNfYXNfc2Vjb25kcyc6IHRpbWVzX2FzX3NlY29uZHNcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdH0gKTtcclxuXHRcdFx0XHR9XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdHJldHVybiB0aW1lX2ZpZWxkc19vYmpfYXJyO1xyXG5cdFx0fVxyXG5cclxuXHRcdFx0LyoqXHJcblx0XHRcdCAqIERpc2FibGUgSFRNTCBvcHRpb25zIGFuZCBhZGQgYm9va2VkIENTUyBjbGFzc1xyXG5cdFx0XHQgKlxyXG5cdFx0XHQgKiBAcGFyYW0gdGltZV9maWVsZHNfb2JqX2FyciAgICAgIC0gdGhpcyB2YWx1ZSBpcyBmcm9tICB0aGUgZnVuYzogIFx0d3BiY19nZXRfX3RpbWVfZmllbGRzX19pbl9ib29raW5nX2Zvcm1fX2FzX2FyciggcmVzb3VyY2VfaWQgKVxyXG5cdFx0XHQgKiBcdFx0XHRcdFx0W1xyXG5cdFx0XHQgKiBcdFx0XHRcdFx0IFx0ICAge1x0anF1ZXJ5X29wdGlvbjogICAgICBqUXVlcnlfT2JqZWN0IHt9XHJcblx0XHRcdCAqIFx0XHRcdFx0XHRcdFx0XHRuYW1lOiAgICAgICAgICAgICAgICdyYW5nZXRpbWUyW10nXHJcblx0XHRcdCAqIFx0XHRcdFx0XHRcdFx0XHR0aW1lc19hc19zZWNvbmRzOiAgIFsgMjE2MDAsIDIzNDAwIF1cclxuXHRcdFx0ICogXHRcdFx0XHRcdFx0XHRcdHZhbHVlX29wdGlvbl8yNGg6ICAgJzA2OjAwIC0gMDY6MzAnXHJcblx0XHRcdCAqIFx0ICBcdFx0XHRcdFx0XHQgICAgZGlzYWJsZWQgPSAxXHJcblx0XHRcdCAqIFx0XHRcdFx0XHQgICAgIH1cclxuXHRcdFx0ICogXHRcdFx0XHRcdCAgLi4uXHJcblx0XHRcdCAqIFx0XHRcdFx0XHRcdCAgIHtcdGpxdWVyeV9vcHRpb246ICAgICAgalF1ZXJ5X09iamVjdCB7fVxyXG5cdFx0XHQgKiBcdFx0XHRcdFx0XHRcdFx0bmFtZTogICAgICAgICAgICAgICAnc3RhcnR0aW1lMltdJ1xyXG5cdFx0XHQgKiBcdFx0XHRcdFx0XHRcdFx0dGltZXNfYXNfc2Vjb25kczogICBbIDIxNjAwIF1cclxuXHRcdFx0ICogXHRcdFx0XHRcdFx0XHRcdHZhbHVlX29wdGlvbl8yNGg6ICAgJzA2OjAwJ1xyXG5cdFx0XHQgKiAgIFx0XHRcdFx0XHRcdFx0ZGlzYWJsZWQgPSAwXHJcblx0XHRcdCAqICBcdFx0XHRcdFx0ICAgIH1cclxuXHRcdFx0ICogXHRcdFx0XHRcdCBdXHJcblx0XHRcdCAqXHJcblx0XHRcdCAqL1xyXG5cdFx0XHRmdW5jdGlvbiB3cGJjX19odG1sX190aW1lX2ZpZWxkX29wdGlvbnNfX3NldF9kaXNhYmxlZCggdGltZV9maWVsZHNfb2JqX2FyciApe1xyXG5cclxuXHRcdFx0XHR2YXIganF1ZXJ5X29wdGlvbjtcclxuXHJcblx0XHRcdFx0Zm9yICggdmFyIGkgPSAwOyBpIDwgdGltZV9maWVsZHNfb2JqX2Fyci5sZW5ndGg7IGkrKyApe1xyXG5cclxuXHRcdFx0XHRcdHZhciBqcXVlcnlfb3B0aW9uID0gdGltZV9maWVsZHNfb2JqX2FyclsgaSBdLmpxdWVyeV9vcHRpb247XHJcblxyXG5cdFx0XHRcdFx0aWYgKCAxID09IHRpbWVfZmllbGRzX29ial9hcnJbIGkgXS5kaXNhYmxlZCApe1xyXG5cdFx0XHRcdFx0XHRqcXVlcnlfb3B0aW9uLnByb3AoICdkaXNhYmxlZCcsIHRydWUgKTsgXHRcdC8vIE1ha2UgZGlzYWJsZSBzb21lIG9wdGlvbnNcclxuXHRcdFx0XHRcdFx0anF1ZXJ5X29wdGlvbi5hZGRDbGFzcyggJ2Jvb2tlZCcgKTsgICAgICAgICAgIFx0Ly8gQWRkIFwiYm9va2VkXCIgQ1NTIGNsYXNzXHJcblxyXG5cdFx0XHRcdFx0XHQvLyBpZiB0aGlzIGJvb2tlZCBlbGVtZW50IHNlbGVjdGVkIC0tPiB0aGVuIGRlc2VsZWN0ICBpdFxyXG5cdFx0XHRcdFx0XHRpZiAoIGpxdWVyeV9vcHRpb24ucHJvcCggJ3NlbGVjdGVkJyApICl7XHJcblx0XHRcdFx0XHRcdFx0anF1ZXJ5X29wdGlvbi5wcm9wKCAnc2VsZWN0ZWQnLCBmYWxzZSApO1xyXG5cclxuXHRcdFx0XHRcdFx0XHRqcXVlcnlfb3B0aW9uLnBhcmVudCgpLmZpbmQoICdvcHRpb246bm90KFtkaXNhYmxlZF0pOmZpcnN0JyApLnByb3AoICdzZWxlY3RlZCcsIHRydWUgKS50cmlnZ2VyKCBcImNoYW5nZVwiICk7XHJcblx0XHRcdFx0XHRcdH1cclxuXHJcblx0XHRcdFx0XHR9IGVsc2Uge1xyXG5cdFx0XHRcdFx0XHRqcXVlcnlfb3B0aW9uLnByb3AoICdkaXNhYmxlZCcsIGZhbHNlICk7ICBcdFx0Ly8gTWFrZSBhY3RpdmUgYWxsIHRpbWVzXHJcblx0XHRcdFx0XHRcdGpxdWVyeV9vcHRpb24ucmVtb3ZlQ2xhc3MoICdib29rZWQnICk7ICAgXHRcdC8vIFJlbW92ZSBjbGFzcyBcImJvb2tlZFwiXHJcblx0XHRcdFx0XHR9XHJcblx0XHRcdFx0fVxyXG5cclxuXHRcdFx0fVxyXG5cclxuXHQvKipcclxuXHQgKiBDaGVjayBpZiB0aGlzIHRpbWVfcmFuZ2UgfCBUaW1lX1Nsb3QgaXMgRnVsbCBEYXkgIGJvb2tlZFxyXG5cdCAqXHJcblx0ICogQHBhcmFtIHRpbWVzbG90X2Fycl9pbl9zZWNvbmRzXHRcdC0gWyAzNjAxMSwgODY0MDAgXVxyXG5cdCAqIEByZXR1cm5zIHtib29sZWFufVxyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfaXNfdGhpc190aW1lc2xvdF9fZnVsbF9kYXlfYm9va2VkKCB0aW1lc2xvdF9hcnJfaW5fc2Vjb25kcyApe1xyXG5cclxuXHRcdGlmIChcclxuXHRcdFx0XHQoIHRpbWVzbG90X2Fycl9pbl9zZWNvbmRzLmxlbmd0aCA+IDEgKVxyXG5cdFx0XHQmJiAoIHBhcnNlSW50KCB0aW1lc2xvdF9hcnJfaW5fc2Vjb25kc1sgMCBdICkgPCAzMCApXHJcblx0XHRcdCYmICggcGFyc2VJbnQoIHRpbWVzbG90X2Fycl9pbl9zZWNvbmRzWyAxIF0gKSA+ICAoICgyNCAqIDYwICogNjApIC0gMzApIClcclxuXHRcdCl7XHJcblx0XHRcdHJldHVybiB0cnVlO1xyXG5cdFx0fVxyXG5cclxuXHRcdHJldHVybiBmYWxzZTtcclxuXHR9XHJcblxyXG5cclxuXHQvLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cdC8vIFMgZSBsIGUgYyB0IGUgZCAgICBEIGEgdCBlIHMgIC8gIFQgaSBtIGUgLSBGIGkgZSBsIGQgc1xyXG5cdC8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblxyXG5cdC8qKlxyXG5cdCAqICBHZXQgYWxsIHNlbGVjdGVkIGRhdGVzIGluIFNRTCBmb3JtYXQgbGlrZSB0aGlzIFsgXCIyMDIzLTA4LTIzXCIsIFwiMjAyMy0wOC0yNFwiICwgLi4uIF1cclxuXHQgKlxyXG5cdCAqIEBwYXJhbSByZXNvdXJjZV9pZFxyXG5cdCAqIEByZXR1cm5zIHtbXX1cdFx0XHRbIFwiMjAyMy0wOC0yM1wiLCBcIjIwMjMtMDgtMjRcIiwgXCIyMDIzLTA4LTI1XCIsIFwiMjAyMy0wOC0yNlwiLCBcIjIwMjMtMDgtMjdcIiwgXCIyMDIzLTA4LTI4XCIsIFwiMjAyMy0wOC0yOVwiIF1cclxuXHQgKi9cclxuXHRmdW5jdGlvbiB3cGJjX2dldF9fc2VsZWN0ZWRfZGF0ZXNfc3FsX19hc19hcnIoIHJlc291cmNlX2lkICl7XHJcblxyXG5cdFx0dmFyIHNlbGVjdGVkX2RhdGVzX2FyciA9IFtdO1xyXG5cdFx0c2VsZWN0ZWRfZGF0ZXNfYXJyID0galF1ZXJ5KCAnI2RhdGVfYm9va2luZycgKyByZXNvdXJjZV9pZCApLnZhbCgpLnNwbGl0KCcsJyk7XHJcblxyXG5cdFx0aWYgKCBzZWxlY3RlZF9kYXRlc19hcnIubGVuZ3RoICl7XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0Ly9GaXhJbjogOS44LjEwLjFcclxuXHRcdFx0Zm9yICggbGV0IGkgPSAwOyBpIDwgc2VsZWN0ZWRfZGF0ZXNfYXJyLmxlbmd0aDsgaSsrICl7XHRcdFx0XHRcdFx0Ly9GaXhJbjogMTAuMC4wLjU2XHJcblx0XHRcdFx0c2VsZWN0ZWRfZGF0ZXNfYXJyWyBpIF0gPSBzZWxlY3RlZF9kYXRlc19hcnJbIGkgXS50cmltKCk7XHJcblx0XHRcdFx0c2VsZWN0ZWRfZGF0ZXNfYXJyWyBpIF0gPSBzZWxlY3RlZF9kYXRlc19hcnJbIGkgXS5zcGxpdCggJy4nICk7XHJcblx0XHRcdFx0aWYgKCBzZWxlY3RlZF9kYXRlc19hcnJbIGkgXS5sZW5ndGggPiAxICl7XHJcblx0XHRcdFx0XHRzZWxlY3RlZF9kYXRlc19hcnJbIGkgXSA9IHNlbGVjdGVkX2RhdGVzX2FyclsgaSBdWyAyIF0gKyAnLScgKyBzZWxlY3RlZF9kYXRlc19hcnJbIGkgXVsgMSBdICsgJy0nICsgc2VsZWN0ZWRfZGF0ZXNfYXJyWyBpIF1bIDAgXTtcclxuXHRcdFx0XHR9XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHJcblx0XHQvLyBSZW1vdmUgZW1wdHkgZWxlbWVudHMgZnJvbSBhbiBhcnJheVxyXG5cdFx0c2VsZWN0ZWRfZGF0ZXNfYXJyID0gc2VsZWN0ZWRfZGF0ZXNfYXJyLmZpbHRlciggZnVuY3Rpb24gKCBuICl7IHJldHVybiBwYXJzZUludChuKTsgfSApO1xyXG5cclxuXHRcdHNlbGVjdGVkX2RhdGVzX2Fyci5zb3J0KCk7XHJcblxyXG5cdFx0cmV0dXJuIHNlbGVjdGVkX2RhdGVzX2FycjtcclxuXHR9XHJcblxyXG5cclxuXHQvKipcclxuXHQgKiBHZXQgYWxsIHRpbWUgZmllbGRzIGluIHRoZSBib29raW5nIGZvcm0gYXMgYXJyYXkgIG9mIG9iamVjdHNcclxuXHQgKlxyXG5cdCAqIEBwYXJhbSByZXNvdXJjZV9pZFxyXG5cdCAqIEBwYXJhbSBpc19vbmx5X3NlbGVjdGVkX3RpbWVcclxuXHQgKiBAcmV0dXJucyBbXVxyXG5cdCAqXHJcblx0ICogXHRcdEV4YW1wbGU6XHJcblx0ICogXHRcdFx0XHRcdFtcclxuXHQgKiBcdFx0XHRcdFx0IFx0ICAge1xyXG5cdCAqIFx0XHRcdFx0XHRcdFx0XHR2YWx1ZV9vcHRpb25fMjRoOiAgICcwNjowMCAtIDA2OjMwJ1xyXG5cdCAqIFx0XHRcdFx0XHRcdFx0XHR0aW1lc19hc19zZWNvbmRzOiAgIFsgMjE2MDAsIDIzNDAwIF1cclxuXHQgKiBcdFx0XHRcdFx0IFx0ICAgXHRcdGpxdWVyeV9vcHRpb246ICAgICAgalF1ZXJ5X09iamVjdCB7fVxyXG5cdCAqIFx0XHRcdFx0XHRcdFx0XHRuYW1lOiAgICAgICAgICAgICAgICdyYW5nZXRpbWUyW10nXHJcblx0ICogXHRcdFx0XHRcdCAgICAgfVxyXG5cdCAqIFx0XHRcdFx0XHQgIC4uLlxyXG5cdCAqIFx0XHRcdFx0XHRcdCAgIHtcclxuXHQgKiBcdFx0XHRcdFx0XHRcdFx0dmFsdWVfb3B0aW9uXzI0aDogICAnMDY6MDAnXHJcblx0ICogXHRcdFx0XHRcdFx0XHRcdHRpbWVzX2FzX3NlY29uZHM6ICAgWyAyMTYwMCBdXHJcblx0ICogXHRcdFx0XHRcdFx0ICAgXHRcdGpxdWVyeV9vcHRpb246ICAgICAgalF1ZXJ5X09iamVjdCB7fVxyXG5cdCAqIFx0XHRcdFx0XHRcdFx0XHRuYW1lOiAgICAgICAgICAgICAgICdzdGFydHRpbWUyW10nXHJcblx0ICogIFx0XHRcdFx0XHQgICAgfVxyXG5cdCAqIFx0XHRcdFx0XHQgXVxyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfZ2V0X19zZWxlY3RlZF90aW1lX2ZpZWxkc19faW5fYm9va2luZ19mb3JtX19hc19hcnIoIHJlc291cmNlX2lkLCBpc19vbmx5X3NlbGVjdGVkX3RpbWUgPSB0cnVlICl7XHJcblx0XHQvKipcclxuXHRcdCAqIEZpZWxkcyB3aXRoICBbXSAgbGlrZSB0aGlzICAgc2VsZWN0W25hbWU9XCJyYW5nZXRpbWUxW11cIl1cclxuXHRcdCAqIGl0J3Mgd2hlbiB3ZSBoYXZlICdtdWx0aXBsZScgaW4gc2hvcnRjb2RlOiAgIFtzZWxlY3QqIHJhbmdldGltZSBtdWx0aXBsZSAgXCIwNjowMCAtIDA2OjMwXCIgLi4uIF1cclxuXHRcdCAqL1xyXG5cdFx0dmFyIHRpbWVfZmllbGRzX2Fycj1bXHJcblx0XHRcdFx0XHRcdFx0XHQnc2VsZWN0W25hbWU9XCJyYW5nZXRpbWUnICsgcmVzb3VyY2VfaWQgKyAnXCJdJyxcclxuXHRcdFx0XHRcdFx0XHRcdCdzZWxlY3RbbmFtZT1cInJhbmdldGltZScgKyByZXNvdXJjZV9pZCArICdbXVwiXScsXHJcblx0XHRcdFx0XHRcdFx0XHQnc2VsZWN0W25hbWU9XCJzdGFydHRpbWUnICsgcmVzb3VyY2VfaWQgKyAnXCJdJyxcclxuXHRcdFx0XHRcdFx0XHRcdCdzZWxlY3RbbmFtZT1cInN0YXJ0dGltZScgKyByZXNvdXJjZV9pZCArICdbXVwiXScsXHJcblx0XHRcdFx0XHRcdFx0XHQnc2VsZWN0W25hbWU9XCJlbmR0aW1lJyArIHJlc291cmNlX2lkICsgJ1wiXScsXHJcblx0XHRcdFx0XHRcdFx0XHQnc2VsZWN0W25hbWU9XCJlbmR0aW1lJyArIHJlc291cmNlX2lkICsgJ1tdXCJdJyxcclxuXHRcdFx0XHRcdFx0XHRcdCdzZWxlY3RbbmFtZT1cImR1cmF0aW9udGltZScgKyByZXNvdXJjZV9pZCArICdcIl0nLFxyXG5cdFx0XHRcdFx0XHRcdFx0J3NlbGVjdFtuYW1lPVwiZHVyYXRpb250aW1lJyArIHJlc291cmNlX2lkICsgJ1tdXCJdJ1xyXG5cdFx0XHRcdFx0XHRcdF07XHJcblxyXG5cdFx0dmFyIHRpbWVfZmllbGRzX29ial9hcnIgPSBbXTtcclxuXHJcblx0XHQvLyBMb29wIGFsbCBUaW1lIEZpZWxkc1xyXG5cdFx0Zm9yICggdmFyIGN0Zj0gMDsgY3RmIDwgdGltZV9maWVsZHNfYXJyLmxlbmd0aDsgY3RmKysgKXtcclxuXHJcblx0XHRcdHZhciB0aW1lX2ZpZWxkID0gdGltZV9maWVsZHNfYXJyWyBjdGYgXTtcclxuXHJcblx0XHRcdHZhciB0aW1lX29wdGlvbjtcclxuXHRcdFx0aWYgKCBpc19vbmx5X3NlbGVjdGVkX3RpbWUgKXtcclxuXHRcdFx0XHR0aW1lX29wdGlvbiA9IGpRdWVyeSggJyNib29raW5nX2Zvcm0nICsgcmVzb3VyY2VfaWQgKyAnICcgKyB0aW1lX2ZpZWxkICsgJyBvcHRpb246c2VsZWN0ZWQnICk7XHRcdFx0Ly8gRXhjbHVkZSBjb25kaXRpb25hbCAgZmllbGRzLCAgYmVjYXVzZSBvZiB1c2luZyAnI2Jvb2tpbmdfZm9ybTMgLi4uJ1xyXG5cdFx0XHR9IGVsc2Uge1xyXG5cdFx0XHRcdHRpbWVfb3B0aW9uID0galF1ZXJ5KCAnI2Jvb2tpbmdfZm9ybScgKyByZXNvdXJjZV9pZCArICcgJyArIHRpbWVfZmllbGQgKyAnIG9wdGlvbicgKTtcdFx0XHRcdC8vIEFsbCAgdGltZSBmaWVsZHNcclxuXHRcdFx0fVxyXG5cclxuXHJcblx0XHRcdC8vIExvb3AgYWxsIG9wdGlvbnMgaW4gdGltZSBmaWVsZFxyXG5cdFx0XHRmb3IgKCB2YXIgaiA9IDA7IGogPCB0aW1lX29wdGlvbi5sZW5ndGg7IGorKyApe1xyXG5cclxuXHRcdFx0XHR2YXIganF1ZXJ5X29wdGlvbiA9IGpRdWVyeSggdGltZV9vcHRpb25bIGogXSApO1x0XHQvLyBHZXQgb25seSAgc2VsZWN0ZWQgb3B0aW9ucyBcdC8valF1ZXJ5KCB0aW1lX2ZpZWxkICsgJyBvcHRpb246ZXEoJyArIGogKyAnKScgKTtcclxuXHRcdFx0XHR2YXIgdmFsdWVfb3B0aW9uX3NlY29uZHNfYXJyID0ganF1ZXJ5X29wdGlvbi52YWwoKS5zcGxpdCggJy0nICk7XHJcblx0XHRcdFx0dmFyIHRpbWVzX2FzX3NlY29uZHMgPSBbXTtcclxuXHJcblx0XHRcdFx0Ly8gR2V0IHRpbWUgYXMgc2Vjb25kc1xyXG5cdFx0XHRcdGlmICggdmFsdWVfb3B0aW9uX3NlY29uZHNfYXJyLmxlbmd0aCApe1x0XHRcdFx0IFx0XHRcdFx0XHRcdFx0XHQvL0ZpeEluOiA5LjguMTAuMVxyXG5cdFx0XHRcdFx0Zm9yICggbGV0IGkgPSAwOyBpIDwgdmFsdWVfb3B0aW9uX3NlY29uZHNfYXJyLmxlbmd0aDsgaSsrICl7XHRcdFx0XHRcdC8vRml4SW46IDEwLjAuMC41NlxyXG5cdFx0XHRcdFx0XHQvLyB2YWx1ZV9vcHRpb25fc2Vjb25kc19hcnJbaV0gPSAnMTQ6MDAgJyAgfCAnIDE2OjAwJyAgIChpZiBmcm9tICdyYW5nZXRpbWUnKSBhbmQgJzE2OjAwJyAgaWYgKHN0YXJ0L2VuZCB0aW1lKVxyXG5cclxuXHRcdFx0XHRcdFx0dmFyIHN0YXJ0X2VuZF90aW1lc19hcnIgPSB2YWx1ZV9vcHRpb25fc2Vjb25kc19hcnJbIGkgXS50cmltKCkuc3BsaXQoICc6JyApO1xyXG5cclxuXHRcdFx0XHRcdFx0dmFyIHRpbWVfaW5fc2Vjb25kcyA9IHBhcnNlSW50KCBzdGFydF9lbmRfdGltZXNfYXJyWyAwIF0gKSAqIDYwICogNjAgKyBwYXJzZUludCggc3RhcnRfZW5kX3RpbWVzX2FyclsgMSBdICkgKiA2MDtcclxuXHJcblx0XHRcdFx0XHRcdHRpbWVzX2FzX3NlY29uZHMucHVzaCggdGltZV9pbl9zZWNvbmRzICk7XHJcblx0XHRcdFx0XHR9XHJcblx0XHRcdFx0fVxyXG5cclxuXHRcdFx0XHR0aW1lX2ZpZWxkc19vYmpfYXJyLnB1c2goIHtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdCduYW1lJyAgICAgICAgICAgIDogalF1ZXJ5KCAnI2Jvb2tpbmdfZm9ybScgKyByZXNvdXJjZV9pZCArICcgJyArIHRpbWVfZmllbGQgKS5hdHRyKCAnbmFtZScgKSxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdCd2YWx1ZV9vcHRpb25fMjRoJzoganF1ZXJ5X29wdGlvbi52YWwoKSxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdCdqcXVlcnlfb3B0aW9uJyAgIDoganF1ZXJ5X29wdGlvbixcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdCd0aW1lc19hc19zZWNvbmRzJzogdGltZXNfYXNfc2Vjb25kc1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdH0gKTtcclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cclxuXHRcdC8vIFRleHQ6ICAgW3N0YXJ0dGltZV0gLSBbZW5kdGltZV0gLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHJcblx0XHR2YXIgdGV4dF90aW1lX2ZpZWxkc19hcnI9W1xyXG5cdFx0XHRcdFx0XHRcdFx0XHQnaW5wdXRbbmFtZT1cInN0YXJ0dGltZScgKyByZXNvdXJjZV9pZCArICdcIl0nLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHQnaW5wdXRbbmFtZT1cImVuZHRpbWUnICsgcmVzb3VyY2VfaWQgKyAnXCJdJyxcclxuXHRcdFx0XHRcdFx0XHRcdF07XHJcblx0XHRmb3IgKCB2YXIgdGY9IDA7IHRmIDwgdGV4dF90aW1lX2ZpZWxkc19hcnIubGVuZ3RoOyB0ZisrICl7XHJcblxyXG5cdFx0XHR2YXIgdGV4dF9qcXVlcnkgPSBqUXVlcnkoICcjYm9va2luZ19mb3JtJyArIHJlc291cmNlX2lkICsgJyAnICsgdGV4dF90aW1lX2ZpZWxkc19hcnJbIHRmIF0gKTtcdFx0XHRcdFx0XHRcdFx0Ly8gRXhjbHVkZSBjb25kaXRpb25hbCAgZmllbGRzLCAgYmVjYXVzZSBvZiB1c2luZyAnI2Jvb2tpbmdfZm9ybTMgLi4uJ1xyXG5cdFx0XHRpZiAoIHRleHRfanF1ZXJ5Lmxlbmd0aCA+IDAgKXtcclxuXHJcblx0XHRcdFx0dmFyIHRpbWVfX2hfbV9fYXJyID0gdGV4dF9qcXVlcnkudmFsKCkudHJpbSgpLnNwbGl0KCAnOicgKTtcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0Ly8gJzE0OjAwJ1xyXG5cdFx0XHRcdGlmICggMCA9PSB0aW1lX19oX21fX2Fyci5sZW5ndGggKXtcclxuXHRcdFx0XHRcdGNvbnRpbnVlO1x0XHRcdFx0XHRcdFx0XHRcdC8vIE5vdCBlbnRlcmVkIHRpbWUgdmFsdWUgaW4gYSBmaWVsZFxyXG5cdFx0XHRcdH1cclxuXHRcdFx0XHRpZiAoIDEgPT0gdGltZV9faF9tX19hcnIubGVuZ3RoICl7XHJcblx0XHRcdFx0XHRpZiAoICcnID09PSB0aW1lX19oX21fX2FyclsgMCBdICl7XHJcblx0XHRcdFx0XHRcdGNvbnRpbnVlO1x0XHRcdFx0XHRcdFx0XHQvLyBOb3QgZW50ZXJlZCB0aW1lIHZhbHVlIGluIGEgZmllbGRcclxuXHRcdFx0XHRcdH1cclxuXHRcdFx0XHRcdHRpbWVfX2hfbV9fYXJyWyAxIF0gPSAwO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0XHR2YXIgdGV4dF90aW1lX2luX3NlY29uZHMgPSBwYXJzZUludCggdGltZV9faF9tX19hcnJbIDAgXSApICogNjAgKiA2MCArIHBhcnNlSW50KCB0aW1lX19oX21fX2FyclsgMSBdICkgKiA2MDtcclxuXHJcblx0XHRcdFx0dmFyIHRleHRfdGltZXNfYXNfc2Vjb25kcyA9IFtdO1xyXG5cdFx0XHRcdHRleHRfdGltZXNfYXNfc2Vjb25kcy5wdXNoKCB0ZXh0X3RpbWVfaW5fc2Vjb25kcyApO1xyXG5cclxuXHRcdFx0XHR0aW1lX2ZpZWxkc19vYmpfYXJyLnB1c2goIHtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdCduYW1lJyAgICAgICAgICAgIDogdGV4dF9qcXVlcnkuYXR0ciggJ25hbWUnICksXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHQndmFsdWVfb3B0aW9uXzI0aCc6IHRleHRfanF1ZXJ5LnZhbCgpLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0J2pxdWVyeV9vcHRpb24nICAgOiB0ZXh0X2pxdWVyeSxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdCd0aW1lc19hc19zZWNvbmRzJzogdGV4dF90aW1lc19hc19zZWNvbmRzXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0fSApO1xyXG5cdFx0XHR9XHJcblx0XHR9XHJcblxyXG5cdFx0cmV0dXJuIHRpbWVfZmllbGRzX29ial9hcnI7XHJcblx0fVxyXG5cclxuXHJcblxyXG4vLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuLy8gUyBVIFAgUCBPIFIgVCAgICBmb3IgICAgQyBBIEwgRSBOIEQgQSBSXHJcbi8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cclxuXHQvKipcclxuXHQgKiBHZXQgQ2FsZW5kYXIgZGF0ZXBpY2sgIEluc3RhbmNlXHJcblx0ICogQHBhcmFtIHJlc291cmNlX2lkICBvZiBib29raW5nIHJlc291cmNlXHJcblx0ICogQHJldHVybnMgeyp8bnVsbH1cclxuXHQgKi9cclxuXHRmdW5jdGlvbiB3cGJjX2NhbGVuZGFyX19nZXRfaW5zdCggcmVzb3VyY2VfaWQgKXtcclxuXHJcblx0XHRpZiAoICd1bmRlZmluZWQnID09PSB0eXBlb2YgKHJlc291cmNlX2lkKSApe1xyXG5cdFx0XHRyZXNvdXJjZV9pZCA9ICcxJztcclxuXHRcdH1cclxuXHJcblx0XHRpZiAoIGpRdWVyeSggJyNjYWxlbmRhcl9ib29raW5nJyArIHJlc291cmNlX2lkICkubGVuZ3RoID4gMCApe1xyXG5cdFx0XHRyZXR1cm4galF1ZXJ5LmRhdGVwaWNrLl9nZXRJbnN0KCBqUXVlcnkoICcjY2FsZW5kYXJfYm9va2luZycgKyByZXNvdXJjZV9pZCApLmdldCggMCApICk7XHJcblx0XHR9XHJcblxyXG5cdFx0cmV0dXJuIG51bGw7XHJcblx0fVxyXG5cclxuXHQvKipcclxuXHQgKiBVbnNlbGVjdCAgYWxsIGRhdGVzIGluIGNhbGVuZGFyIGFuZCB2aXN1YWxseSB1cGRhdGUgdGhpcyBjYWxlbmRhclxyXG5cdCAqXHJcblx0ICogQHBhcmFtIHJlc291cmNlX2lkXHRcdElEIG9mIGJvb2tpbmcgcmVzb3VyY2VcclxuXHQgKiBAcmV0dXJucyB7Ym9vbGVhbn1cdFx0dHJ1ZSBvbiBzdWNjZXNzIHwgZmFsc2UsICBpZiBubyBzdWNoICBjYWxlbmRhclxyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfY2FsZW5kYXJfX3Vuc2VsZWN0X2FsbF9kYXRlcyggcmVzb3VyY2VfaWQgKXtcclxuXHJcblx0XHRpZiAoICd1bmRlZmluZWQnID09PSB0eXBlb2YgKHJlc291cmNlX2lkKSApe1xyXG5cdFx0XHRyZXNvdXJjZV9pZCA9ICcxJztcclxuXHRcdH1cclxuXHJcblx0XHR2YXIgaW5zdCA9IHdwYmNfY2FsZW5kYXJfX2dldF9pbnN0KCByZXNvdXJjZV9pZCApXHJcblxyXG5cdFx0aWYgKCBudWxsICE9PSBpbnN0ICl7XHJcblxyXG5cdFx0XHQvLyBVbnNlbGVjdCBhbGwgZGF0ZXMgYW5kIHNldCAgcHJvcGVydGllcyBvZiBEYXRlcGlja1xyXG5cdFx0XHRqUXVlcnkoICcjZGF0ZV9ib29raW5nJyArIHJlc291cmNlX2lkICkudmFsKCAnJyApOyAgICAgIC8vRml4SW46IDUuNC4zXHJcblx0XHRcdGluc3Quc3RheU9wZW4gPSBmYWxzZTtcclxuXHRcdFx0aW5zdC5kYXRlcyA9IFtdO1xyXG5cdFx0XHRqUXVlcnkuZGF0ZXBpY2suX3VwZGF0ZURhdGVwaWNrKCBpbnN0ICk7XHJcblxyXG5cdFx0XHRyZXR1cm4gdHJ1ZVxyXG5cdFx0fVxyXG5cclxuXHRcdHJldHVybiBmYWxzZTtcclxuXHJcblx0fVxyXG5cclxuXHQvKipcclxuXHQgKiBDbGVhciBkYXlzIGhpZ2hsaWdodGluZyBpbiBBbGwgb3Igc3BlY2lmaWMgQ2FsZW5kYXJzXHJcblx0ICpcclxuICAgICAqIEBwYXJhbSByZXNvdXJjZV9pZCAgLSBjYW4gYmUgc2tpcGVkIHRvICBjbGVhciBoaWdobGlnaHRpbmcgaW4gYWxsIGNhbGVuZGFyc1xyXG4gICAgICovXHJcblx0ZnVuY3Rpb24gd3BiY19jYWxlbmRhcnNfX2NsZWFyX2RheXNfaGlnaGxpZ2h0aW5nKCByZXNvdXJjZV9pZCApe1xyXG5cclxuXHRcdGlmICggJ3VuZGVmaW5lZCcgIT09IHR5cGVvZiAoIHJlc291cmNlX2lkICkgKXtcclxuXHJcblx0XHRcdGpRdWVyeSggJyNjYWxlbmRhcl9ib29raW5nJyArIHJlc291cmNlX2lkICsgJyAuZGF0ZXBpY2stZGF5cy1jZWxsLW92ZXInICkucmVtb3ZlQ2xhc3MoICdkYXRlcGljay1kYXlzLWNlbGwtb3ZlcicgKTtcdFx0Ly8gQ2xlYXIgaW4gc3BlY2lmaWMgY2FsZW5kYXJcclxuXHJcblx0XHR9IGVsc2Uge1xyXG5cdFx0XHRqUXVlcnkoICcuZGF0ZXBpY2stZGF5cy1jZWxsLW92ZXInICkucmVtb3ZlQ2xhc3MoICdkYXRlcGljay1kYXlzLWNlbGwtb3ZlcicgKTtcdFx0XHRcdFx0XHRcdFx0Ly8gQ2xlYXIgaW4gYWxsIGNhbGVuZGFyc1xyXG5cdFx0fVxyXG5cdH1cclxuXHJcblx0LyoqXHJcblx0ICogU2Nyb2xsIHRvIHNwZWNpZmljIG1vbnRoIGluIGNhbGVuZGFyXHJcblx0ICpcclxuXHQgKiBAcGFyYW0gcmVzb3VyY2VfaWRcdFx0SUQgb2YgcmVzb3VyY2VcclxuXHQgKiBAcGFyYW0geWVhclx0XHRcdFx0LSByZWFsIHllYXIgIC0gMjAyM1xyXG5cdCAqIEBwYXJhbSBtb250aFx0XHRcdFx0LSByZWFsIG1vbnRoIC0gMTJcclxuXHQgKiBAcmV0dXJucyB7Ym9vbGVhbn1cclxuXHQgKi9cclxuXHRmdW5jdGlvbiB3cGJjX2NhbGVuZGFyX19zY3JvbGxfdG8oIHJlc291cmNlX2lkLCB5ZWFyLCBtb250aCApe1xyXG5cclxuXHRcdGlmICggJ3VuZGVmaW5lZCcgPT09IHR5cGVvZiAocmVzb3VyY2VfaWQpICl7IHJlc291cmNlX2lkID0gJzEnOyB9XHJcblx0XHR2YXIgaW5zdCA9IHdwYmNfY2FsZW5kYXJfX2dldF9pbnN0KCByZXNvdXJjZV9pZCApXHJcblx0XHRpZiAoIG51bGwgIT09IGluc3QgKXtcclxuXHJcblx0XHRcdHllYXIgID0gcGFyc2VJbnQoIHllYXIgKTtcclxuXHRcdFx0bW9udGggPSBwYXJzZUludCggbW9udGggKSAtIDE7XHRcdC8vIEluIEpTIGRhdGUsICBtb250aCAtMVxyXG5cclxuXHRcdFx0aW5zdC5jdXJzb3JEYXRlID0gbmV3IERhdGUoKTtcclxuXHRcdFx0Ly8gSW4gc29tZSBjYXNlcywgIHRoZSBzZXRGdWxsWWVhciBjYW4gIHNldCAgb25seSBZZWFyLCAgYW5kIG5vdCB0aGUgTW9udGggYW5kIGRheSAgICAgIC8vRml4SW46Ni4yLjMuNVxyXG5cdFx0XHRpbnN0LmN1cnNvckRhdGUuc2V0RnVsbFllYXIoIHllYXIsIG1vbnRoLCAxICk7XHJcblx0XHRcdGluc3QuY3Vyc29yRGF0ZS5zZXRNb250aCggbW9udGggKTtcclxuXHRcdFx0aW5zdC5jdXJzb3JEYXRlLnNldERhdGUoIDEgKTtcclxuXHJcblx0XHRcdGluc3QuZHJhd01vbnRoID0gaW5zdC5jdXJzb3JEYXRlLmdldE1vbnRoKCk7XHJcblx0XHRcdGluc3QuZHJhd1llYXIgPSBpbnN0LmN1cnNvckRhdGUuZ2V0RnVsbFllYXIoKTtcclxuXHJcblx0XHRcdGpRdWVyeS5kYXRlcGljay5fbm90aWZ5Q2hhbmdlKCBpbnN0ICk7XHJcblx0XHRcdGpRdWVyeS5kYXRlcGljay5fYWRqdXN0SW5zdERhdGUoIGluc3QgKTtcclxuXHRcdFx0alF1ZXJ5LmRhdGVwaWNrLl9zaG93RGF0ZSggaW5zdCApO1xyXG5cdFx0XHRqUXVlcnkuZGF0ZXBpY2suX3VwZGF0ZURhdGVwaWNrKCBpbnN0ICk7XHJcblxyXG5cdFx0XHRyZXR1cm4gdHJ1ZTtcclxuXHRcdH1cclxuXHRcdHJldHVybiBmYWxzZTtcclxuXHR9XHJcblxyXG5cdC8qKlxyXG5cdCAqIElzIHRoaXMgZGF0ZSBzZWxlY3RhYmxlIGluIGNhbGVuZGFyIChtYWlubHkgaXQncyBtZWFucyBBVkFJTEFCTEUgZGF0ZSlcclxuXHQgKlxyXG5cdCAqIEBwYXJhbSB7aW50fHN0cmluZ30gcmVzb3VyY2VfaWRcdFx0MVxyXG5cdCAqIEBwYXJhbSB7c3RyaW5nfSBzcWxfY2xhc3NfZGF5XHRcdCcyMDIzLTA4LTExJ1xyXG5cdCAqIEByZXR1cm5zIHtib29sZWFufVx0XHRcdFx0XHR0cnVlIHwgZmFsc2VcclxuXHQgKi9cclxuXHRmdW5jdGlvbiB3cGJjX2lzX3RoaXNfZGF5X3NlbGVjdGFibGUoIHJlc291cmNlX2lkLCBzcWxfY2xhc3NfZGF5ICl7XHJcblxyXG5cdFx0Ly8gR2V0IERhdGEgLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHRcdHZhciBkYXRlX2Jvb2tpbmdzX29iaiA9IF93cGJjLmJvb2tpbmdzX2luX2NhbGVuZGFyX19nZXRfZm9yX2RhdGUoIHJlc291cmNlX2lkLCBzcWxfY2xhc3NfZGF5ICk7XHJcblxyXG5cdFx0dmFyIGlzX2RheV9zZWxlY3RhYmxlID0gKCBwYXJzZUludCggZGF0ZV9ib29raW5nc19vYmpbICdkYXlfYXZhaWxhYmlsaXR5JyBdICkgPiAwICk7XHJcblxyXG5cdFx0aWYgKCB0eXBlb2YgKGRhdGVfYm9va2luZ3Nfb2JqWyAnc3VtbWFyeScgXSkgPT09ICd1bmRlZmluZWQnICl7XHJcblx0XHRcdHJldHVybiBpc19kYXlfc2VsZWN0YWJsZTtcclxuXHRcdH1cclxuXHJcblx0XHRpZiAoICdhdmFpbGFibGUnICE9IGRhdGVfYm9va2luZ3Nfb2JqWyAnc3VtbWFyeSddWydzdGF0dXNfZm9yX2RheScgXSApe1xyXG5cclxuXHRcdFx0dmFyIGlzX3NldF9wZW5kaW5nX2RheXNfc2VsZWN0YWJsZSA9IF93cGJjLmNhbGVuZGFyX19nZXRfcGFyYW1fdmFsdWUoIHJlc291cmNlX2lkLCAncGVuZGluZ19kYXlzX3NlbGVjdGFibGUnICk7XHRcdC8vIHNldCBwZW5kaW5nIGRheXMgc2VsZWN0YWJsZSAgICAgICAgICAvL0ZpeEluOiA4LjYuMS4xOFxyXG5cclxuXHRcdFx0c3dpdGNoICggZGF0ZV9ib29raW5nc19vYmpbICdzdW1tYXJ5J11bJ3N0YXR1c19mb3JfYm9va2luZ3MnIF0gKXtcclxuXHRcdFx0XHRjYXNlICdwZW5kaW5nJzpcclxuXHRcdFx0XHQvLyBTaXR1YXRpb25zIGZvciBcImNoYW5nZS1vdmVyXCIgZGF5czpcclxuXHRcdFx0XHRjYXNlICdwZW5kaW5nX3BlbmRpbmcnOlxyXG5cdFx0XHRcdGNhc2UgJ3BlbmRpbmdfYXBwcm92ZWQnOlxyXG5cdFx0XHRcdGNhc2UgJ2FwcHJvdmVkX3BlbmRpbmcnOlxyXG5cdFx0XHRcdFx0aXNfZGF5X3NlbGVjdGFibGUgPSAoaXNfZGF5X3NlbGVjdGFibGUpID8gdHJ1ZSA6IGlzX3NldF9wZW5kaW5nX2RheXNfc2VsZWN0YWJsZTtcclxuXHRcdFx0XHRcdGJyZWFrO1xyXG5cdFx0XHRcdGRlZmF1bHQ6XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHJcblx0XHRyZXR1cm4gaXNfZGF5X3NlbGVjdGFibGU7XHJcblx0fVxyXG5cclxuXHQvKipcclxuXHQgKiBJcyBkYXRlIHRvIGNoZWNrIElOIGFycmF5IG9mIHNlbGVjdGVkIGRhdGVzXHJcblx0ICpcclxuXHQgKiBAcGFyYW0ge2RhdGV9anNfZGF0ZV90b19jaGVja1x0XHQtIEpTIERhdGVcdFx0XHQtIHNpbXBsZSAgSmF2YVNjcmlwdCBEYXRlIG9iamVjdFxyXG5cdCAqIEBwYXJhbSB7W119IGpzX2RhdGVzX2Fyclx0XHRcdC0gWyBKU0RhdGUsIC4uLiBdICAgLSBhcnJheSAgb2YgSlMgZGF0ZXNcclxuXHQgKiBAcmV0dXJucyB7Ym9vbGVhbn1cclxuXHQgKi9cclxuXHRmdW5jdGlvbiB3cGJjX2lzX3RoaXNfZGF5X2Ftb25nX3NlbGVjdGVkX2RheXMoIGpzX2RhdGVfdG9fY2hlY2ssIGpzX2RhdGVzX2FyciApe1xyXG5cclxuXHRcdGZvciAoIHZhciBkYXRlX2luZGV4ID0gMDsgZGF0ZV9pbmRleCA8IGpzX2RhdGVzX2Fyci5sZW5ndGggOyBkYXRlX2luZGV4KysgKXsgICAgIFx0XHRcdFx0XHRcdFx0XHRcdC8vRml4SW46IDguNC41LjE2XHJcblx0XHRcdGlmICggKCBqc19kYXRlc19hcnJbIGRhdGVfaW5kZXggXS5nZXRGdWxsWWVhcigpID09PSBqc19kYXRlX3RvX2NoZWNrLmdldEZ1bGxZZWFyKCkgKSAmJlxyXG5cdFx0XHRcdCAoIGpzX2RhdGVzX2FyclsgZGF0ZV9pbmRleCBdLmdldE1vbnRoKCkgPT09IGpzX2RhdGVfdG9fY2hlY2suZ2V0TW9udGgoKSApICYmXHJcblx0XHRcdFx0ICgganNfZGF0ZXNfYXJyWyBkYXRlX2luZGV4IF0uZ2V0RGF0ZSgpID09PSBqc19kYXRlX3RvX2NoZWNrLmdldERhdGUoKSApICkge1xyXG5cdFx0XHRcdFx0cmV0dXJuIHRydWU7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHJcblx0XHRyZXR1cm4gIGZhbHNlO1xyXG5cdH1cclxuXHJcblx0LyoqXHJcblx0ICogR2V0IFNRTCBDbGFzcyBEYXRlICcyMDIzLTA4LTAxJyBmcm9tICBKUyBEYXRlXHJcblx0ICpcclxuXHQgKiBAcGFyYW0gZGF0ZVx0XHRcdFx0SlMgRGF0ZVxyXG5cdCAqIEByZXR1cm5zIHtzdHJpbmd9XHRcdCcyMDIzLTA4LTEyJ1xyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfX2dldF9fc3FsX2NsYXNzX2RhdGUoIGRhdGUgKXtcclxuXHJcblx0XHR2YXIgc3FsX2NsYXNzX2RheSA9IGRhdGUuZ2V0RnVsbFllYXIoKSArICctJztcclxuXHRcdFx0c3FsX2NsYXNzX2RheSArPSAoICggZGF0ZS5nZXRNb250aCgpICsgMSApIDwgMTAgKSA/ICcwJyA6ICcnO1xyXG5cdFx0XHRzcWxfY2xhc3NfZGF5ICs9ICggZGF0ZS5nZXRNb250aCgpICsgMSApICsgJy0nXHJcblx0XHRcdHNxbF9jbGFzc19kYXkgKz0gKCBkYXRlLmdldERhdGUoKSA8IDEwICkgPyAnMCcgOiAnJztcclxuXHRcdFx0c3FsX2NsYXNzX2RheSArPSBkYXRlLmdldERhdGUoKTtcclxuXHJcblx0XHRcdHJldHVybiBzcWxfY2xhc3NfZGF5O1xyXG5cdH1cclxuXHJcblx0LyoqXHJcblx0ICogR2V0IEpTIERhdGUgZnJvbSAgdGhlIFNRTCBkYXRlIGZvcm1hdCAnMjAyNC0wNS0xNCdcclxuXHQgKiBAcGFyYW0gc3FsX2NsYXNzX2RhdGVcclxuXHQgKiBAcmV0dXJucyB7RGF0ZX1cclxuXHQgKi9cclxuXHRmdW5jdGlvbiB3cGJjX19nZXRfX2pzX2RhdGUoIHNxbF9jbGFzc19kYXRlICl7XHJcblxyXG5cdFx0dmFyIHNxbF9jbGFzc19kYXRlX2FyciA9IHNxbF9jbGFzc19kYXRlLnNwbGl0KCAnLScgKTtcclxuXHJcblx0XHR2YXIgZGF0ZV9qcyA9IG5ldyBEYXRlKCk7XHJcblxyXG5cdFx0ZGF0ZV9qcy5zZXRGdWxsWWVhciggcGFyc2VJbnQoIHNxbF9jbGFzc19kYXRlX2FyclsgMCBdICksIChwYXJzZUludCggc3FsX2NsYXNzX2RhdGVfYXJyWyAxIF0gKSAtIDEpLCBwYXJzZUludCggc3FsX2NsYXNzX2RhdGVfYXJyWyAyIF0gKSApOyAgLy8geWVhciwgbW9udGgsIGRhdGVcclxuXHJcblx0XHQvLyBXaXRob3V0IHRoaXMgdGltZSBhZGp1c3QgRGF0ZXMgc2VsZWN0aW9uICBpbiBEYXRlcGlja2VyIGNhbiBub3Qgd29yayEhIVxyXG5cdFx0ZGF0ZV9qcy5zZXRIb3VycygwKTtcclxuXHRcdGRhdGVfanMuc2V0TWludXRlcygwKTtcclxuXHRcdGRhdGVfanMuc2V0U2Vjb25kcygwKTtcclxuXHRcdGRhdGVfanMuc2V0TWlsbGlzZWNvbmRzKDApO1xyXG5cclxuXHRcdHJldHVybiBkYXRlX2pzO1xyXG5cdH1cclxuXHJcblx0LyoqXHJcblx0ICogR2V0IFREIENsYXNzIERhdGUgJzEtMzEtMjAyMycgZnJvbSAgSlMgRGF0ZVxyXG5cdCAqXHJcblx0ICogQHBhcmFtIGRhdGVcdFx0XHRcdEpTIERhdGVcclxuXHQgKiBAcmV0dXJucyB7c3RyaW5nfVx0XHQnMS0zMS0yMDIzJ1xyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfX2dldF9fdGRfY2xhc3NfZGF0ZSggZGF0ZSApe1xyXG5cclxuXHRcdHZhciB0ZF9jbGFzc19kYXkgPSAoZGF0ZS5nZXRNb250aCgpICsgMSkgKyAnLScgKyBkYXRlLmdldERhdGUoKSArICctJyArIGRhdGUuZ2V0RnVsbFllYXIoKTtcdFx0XHRcdFx0XHRcdFx0Ly8gJzEtOS0yMDIzJ1xyXG5cclxuXHRcdHJldHVybiB0ZF9jbGFzc19kYXk7XHJcblx0fVxyXG5cclxuXHQvKipcclxuXHQgKiBHZXQgZGF0ZSBwYXJhbXMgZnJvbSAgc3RyaW5nIGRhdGVcclxuXHQgKlxyXG5cdCAqIEBwYXJhbSBkYXRlXHRcdFx0c3RyaW5nIGRhdGUgbGlrZSAnMzEuNS4yMDIzJ1xyXG5cdCAqIEBwYXJhbSBzZXBhcmF0b3JcdFx0ZGVmYXVsdCAnLicgIGNhbiBiZSBza2lwcGVkLlxyXG5cdCAqIEByZXR1cm5zIHsgIHtkYXRlOiBudW1iZXIsIG1vbnRoOiBudW1iZXIsIHllYXI6IG51bWJlcn0gIH1cclxuXHQgKi9cclxuXHRmdW5jdGlvbiB3cGJjX19nZXRfX2RhdGVfcGFyYW1zX19mcm9tX3N0cmluZ19kYXRlKCBkYXRlICwgc2VwYXJhdG9yKXtcclxuXHJcblx0XHRzZXBhcmF0b3IgPSAoICd1bmRlZmluZWQnICE9PSB0eXBlb2YgKHNlcGFyYXRvcikgKSA/IHNlcGFyYXRvciA6ICcuJztcclxuXHJcblx0XHR2YXIgZGF0ZV9hcnIgPSBkYXRlLnNwbGl0KCBzZXBhcmF0b3IgKTtcclxuXHRcdHZhciBkYXRlX29iaiA9IHtcclxuXHRcdFx0J3llYXInIDogIHBhcnNlSW50KCBkYXRlX2FyclsgMiBdICksXHJcblx0XHRcdCdtb250aCc6IChwYXJzZUludCggZGF0ZV9hcnJbIDEgXSApIC0gMSksXHJcblx0XHRcdCdkYXRlJyA6ICBwYXJzZUludCggZGF0ZV9hcnJbIDAgXSApXHJcblx0XHR9O1xyXG5cdFx0cmV0dXJuIGRhdGVfb2JqO1x0XHQvLyBmb3IgXHRcdCA9IG5ldyBEYXRlKCBkYXRlX29iai55ZWFyICwgZGF0ZV9vYmoubW9udGggLCBkYXRlX29iai5kYXRlICk7XHJcblx0fVxyXG5cclxuXHQvKipcclxuXHQgKiBBZGQgU3BpbiBMb2FkZXIgdG8gIGNhbGVuZGFyXHJcblx0ICogQHBhcmFtIHJlc291cmNlX2lkXHJcblx0ICovXHJcblx0ZnVuY3Rpb24gd3BiY19jYWxlbmRhcl9fbG9hZGluZ19fc3RhcnQoIHJlc291cmNlX2lkICl7XHJcblx0XHRpZiAoICEgalF1ZXJ5KCAnI2NhbGVuZGFyX2Jvb2tpbmcnICsgcmVzb3VyY2VfaWQgKS5uZXh0KCkuaGFzQ2xhc3MoICd3cGJjX3NwaW5zX2xvYWRlcl93cmFwcGVyJyApICl7XHJcblx0XHRcdGpRdWVyeSggJyNjYWxlbmRhcl9ib29raW5nJyArIHJlc291cmNlX2lkICkuYWZ0ZXIoICc8ZGl2IGNsYXNzPVwid3BiY19zcGluc19sb2FkZXJfd3JhcHBlclwiPjxkaXYgY2xhc3M9XCJ3cGJjX3NwaW5zX2xvYWRlclwiPjwvZGl2PjwvZGl2PicgKTtcclxuXHRcdH1cclxuXHRcdGlmICggISBqUXVlcnkoICcjY2FsZW5kYXJfYm9va2luZycgKyByZXNvdXJjZV9pZCApLmhhc0NsYXNzKCAnd3BiY19jYWxlbmRhcl9ibHVyX3NtYWxsJyApICl7XHJcblx0XHRcdGpRdWVyeSggJyNjYWxlbmRhcl9ib29raW5nJyArIHJlc291cmNlX2lkICkuYWRkQ2xhc3MoICd3cGJjX2NhbGVuZGFyX2JsdXJfc21hbGwnICk7XHJcblx0XHR9XHJcblx0XHR3cGJjX2NhbGVuZGFyX19ibHVyX19zdGFydCggcmVzb3VyY2VfaWQgKTtcclxuXHR9XHJcblxyXG5cdC8qKlxyXG5cdCAqIFJlbW92ZSBTcGluIExvYWRlciB0byAgY2FsZW5kYXJcclxuXHQgKiBAcGFyYW0gcmVzb3VyY2VfaWRcclxuXHQgKi9cclxuXHRmdW5jdGlvbiB3cGJjX2NhbGVuZGFyX19sb2FkaW5nX19zdG9wKCByZXNvdXJjZV9pZCApe1xyXG5cdFx0alF1ZXJ5KCAnI2NhbGVuZGFyX2Jvb2tpbmcnICsgcmVzb3VyY2VfaWQgKyAnICsgLndwYmNfc3BpbnNfbG9hZGVyX3dyYXBwZXInICkucmVtb3ZlKCk7XHJcblx0XHRqUXVlcnkoICcjY2FsZW5kYXJfYm9va2luZycgKyByZXNvdXJjZV9pZCApLnJlbW92ZUNsYXNzKCAnd3BiY19jYWxlbmRhcl9ibHVyX3NtYWxsJyApO1xyXG5cdFx0d3BiY19jYWxlbmRhcl9fYmx1cl9fc3RvcCggcmVzb3VyY2VfaWQgKTtcclxuXHR9XHJcblxyXG5cdC8qKlxyXG5cdCAqIEFkZCBCbHVyIHRvICBjYWxlbmRhclxyXG5cdCAqIEBwYXJhbSByZXNvdXJjZV9pZFxyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfY2FsZW5kYXJfX2JsdXJfX3N0YXJ0KCByZXNvdXJjZV9pZCApe1xyXG5cdFx0aWYgKCAhIGpRdWVyeSggJyNjYWxlbmRhcl9ib29raW5nJyArIHJlc291cmNlX2lkICkuaGFzQ2xhc3MoICd3cGJjX2NhbGVuZGFyX2JsdXInICkgKXtcclxuXHRcdFx0alF1ZXJ5KCAnI2NhbGVuZGFyX2Jvb2tpbmcnICsgcmVzb3VyY2VfaWQgKS5hZGRDbGFzcyggJ3dwYmNfY2FsZW5kYXJfYmx1cicgKTtcclxuXHRcdH1cclxuXHR9XHJcblxyXG5cdC8qKlxyXG5cdCAqIFJlbW92ZSBCbHVyIGluICBjYWxlbmRhclxyXG5cdCAqIEBwYXJhbSByZXNvdXJjZV9pZFxyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfY2FsZW5kYXJfX2JsdXJfX3N0b3AoIHJlc291cmNlX2lkICl7XHJcblx0XHRqUXVlcnkoICcjY2FsZW5kYXJfYm9va2luZycgKyByZXNvdXJjZV9pZCApLnJlbW92ZUNsYXNzKCAnd3BiY19jYWxlbmRhcl9ibHVyJyApO1xyXG5cdH1cclxuXHJcblxyXG5cclxuXHJcblx0LyoqXHJcblx0ICogVXBkYXRlIExvb2sgIG9mIGNhbGVuZGFyXHJcblx0ICpcclxuXHQgKiBAcGFyYW0gcmVzb3VyY2VfaWRcclxuXHQgKi9cclxuXHRmdW5jdGlvbiB3cGJjX2NhbGVuZGFyX191cGRhdGVfbG9vayggcmVzb3VyY2VfaWQgKXtcclxuXHJcblx0XHR2YXIgaW5zdCA9IHdwYmNfY2FsZW5kYXJfX2dldF9pbnN0KCByZXNvdXJjZV9pZCApO1xyXG5cclxuXHRcdGpRdWVyeS5kYXRlcGljay5fdXBkYXRlRGF0ZXBpY2soIGluc3QgKTtcclxuXHR9XHJcblxyXG5cclxuLy8gLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcbi8vIFMgVSBQIFAgTyBSIFQgICAgTSBBIFQgSFxyXG4vLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHJcblx0XHQvKipcclxuXHRcdCAqIE1lcmdlIHNldmVyYWwgIGludGVyc2VjdGVkIGludGVydmFscyBvciByZXR1cm4gbm90IGludGVyc2VjdGVkOiAgICAgICAgICAgICAgICAgICAgICAgIFtbMSwzXSxbMiw2XSxbOCwxMF0sWzE1LDE4XV0gIC0+ICAgW1sxLDZdLFs4LDEwXSxbMTUsMThdXVxyXG5cdFx0ICpcclxuXHRcdCAqIEBwYXJhbSBbXSBpbnRlcnZhbHNcdFx0XHQgWyBbMSwzXSxbMiw0XSxbNiw4XSxbOSwxMF0sWzMsN10gXVxyXG5cdFx0ICogQHJldHVybnMgW11cdFx0XHRcdFx0IFsgWzEsOF0sWzksMTBdIF1cclxuXHRcdCAqXHJcblx0XHQgKiBFeG1hbXBsZTogd3BiY19pbnRlcnZhbHNfX21lcmdlX2luZXJzZWN0ZWQoICBbIFsxLDNdLFsyLDRdLFs2LDhdLFs5LDEwXSxbMyw3XSBdICApO1xyXG5cdFx0ICovXHJcblx0XHRmdW5jdGlvbiB3cGJjX2ludGVydmFsc19fbWVyZ2VfaW5lcnNlY3RlZCggaW50ZXJ2YWxzICl7XHJcblxyXG5cdFx0XHRpZiAoICEgaW50ZXJ2YWxzIHx8IGludGVydmFscy5sZW5ndGggPT09IDAgKXtcclxuXHRcdFx0XHRyZXR1cm4gW107XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdHZhciBtZXJnZWQgPSBbXTtcclxuXHRcdFx0aW50ZXJ2YWxzLnNvcnQoIGZ1bmN0aW9uICggYSwgYiApe1xyXG5cdFx0XHRcdHJldHVybiBhWyAwIF0gLSBiWyAwIF07XHJcblx0XHRcdH0gKTtcclxuXHJcblx0XHRcdHZhciBtZXJnZWRJbnRlcnZhbCA9IGludGVydmFsc1sgMCBdO1xyXG5cclxuXHRcdFx0Zm9yICggdmFyIGkgPSAxOyBpIDwgaW50ZXJ2YWxzLmxlbmd0aDsgaSsrICl7XHJcblx0XHRcdFx0dmFyIGludGVydmFsID0gaW50ZXJ2YWxzWyBpIF07XHJcblxyXG5cdFx0XHRcdGlmICggaW50ZXJ2YWxbIDAgXSA8PSBtZXJnZWRJbnRlcnZhbFsgMSBdICl7XHJcblx0XHRcdFx0XHRtZXJnZWRJbnRlcnZhbFsgMSBdID0gTWF0aC5tYXgoIG1lcmdlZEludGVydmFsWyAxIF0sIGludGVydmFsWyAxIF0gKTtcclxuXHRcdFx0XHR9IGVsc2Uge1xyXG5cdFx0XHRcdFx0bWVyZ2VkLnB1c2goIG1lcmdlZEludGVydmFsICk7XHJcblx0XHRcdFx0XHRtZXJnZWRJbnRlcnZhbCA9IGludGVydmFsO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0bWVyZ2VkLnB1c2goIG1lcmdlZEludGVydmFsICk7XHJcblx0XHRcdHJldHVybiBtZXJnZWQ7XHJcblx0XHR9XHJcblxyXG5cclxuXHRcdC8qKlxyXG5cdFx0ICogSXMgMiBpbnRlcnZhbHMgaW50ZXJzZWN0ZWQ6ICAgICAgIFszNjAxMSwgODYzOTJdICAgIDw9PiAgICBbMSwgNDMxOTJdICA9PiAgdHJ1ZSAgICAgICggaW50ZXJzZWN0ZWQgKVxyXG5cdFx0ICpcclxuXHRcdCAqIEdvb2QgZXhwbGFuYXRpb24gIGhlcmUgaHR0cHM6Ly9zdGFja292ZXJmbG93LmNvbS9xdWVzdGlvbnMvMzI2OTQzNC93aGF0cy10aGUtbW9zdC1lZmZpY2llbnQtd2F5LXRvLXRlc3QtaWYtdHdvLXJhbmdlcy1vdmVybGFwXHJcblx0XHQgKlxyXG5cdFx0ICogQHBhcmFtICBpbnRlcnZhbF9BICAgLSBbIDM2MDExLCA4NjM5MiBdXHJcblx0XHQgKiBAcGFyYW0gIGludGVydmFsX0IgICAtIFsgICAgIDEsIDQzMTkyIF1cclxuXHRcdCAqXHJcblx0XHQgKiBAcmV0dXJuIGJvb2xcclxuXHRcdCAqL1xyXG5cdFx0ZnVuY3Rpb24gd3BiY19pbnRlcnZhbHNfX2lzX2ludGVyc2VjdGVkKCBpbnRlcnZhbF9BLCBpbnRlcnZhbF9CICkge1xyXG5cclxuXHRcdFx0aWYgKFxyXG5cdFx0XHRcdFx0KCAwID09IGludGVydmFsX0EubGVuZ3RoIClcclxuXHRcdFx0XHQgfHwgKCAwID09IGludGVydmFsX0IubGVuZ3RoIClcclxuXHRcdFx0KXtcclxuXHRcdFx0XHRyZXR1cm4gZmFsc2U7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdGludGVydmFsX0FbIDAgXSA9IHBhcnNlSW50KCBpbnRlcnZhbF9BWyAwIF0gKTtcclxuXHRcdFx0aW50ZXJ2YWxfQVsgMSBdID0gcGFyc2VJbnQoIGludGVydmFsX0FbIDEgXSApO1xyXG5cdFx0XHRpbnRlcnZhbF9CWyAwIF0gPSBwYXJzZUludCggaW50ZXJ2YWxfQlsgMCBdICk7XHJcblx0XHRcdGludGVydmFsX0JbIDEgXSA9IHBhcnNlSW50KCBpbnRlcnZhbF9CWyAxIF0gKTtcclxuXHJcblx0XHRcdHZhciBpc19pbnRlcnNlY3RlZCA9IE1hdGgubWF4KCBpbnRlcnZhbF9BWyAwIF0sIGludGVydmFsX0JbIDAgXSApIC0gTWF0aC5taW4oIGludGVydmFsX0FbIDEgXSwgaW50ZXJ2YWxfQlsgMSBdICk7XHJcblxyXG5cdFx0XHQvLyBpZiAoIDAgPT0gaXNfaW50ZXJzZWN0ZWQgKSB7XHJcblx0XHRcdC8vXHQgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAvLyBTdWNoIHJhbmdlcyBnb2luZyBvbmUgYWZ0ZXIgb3RoZXIsIGUuZy46IFsgMTIsIDE1IF0gYW5kIFsgMTUsIDIxIF1cclxuXHRcdFx0Ly8gfVxyXG5cclxuXHRcdFx0aWYgKCBpc19pbnRlcnNlY3RlZCA8IDAgKSB7XHJcblx0XHRcdFx0cmV0dXJuIHRydWU7ICAgICAgICAgICAgICAgICAgICAgLy8gSU5URVJTRUNURURcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0cmV0dXJuIGZhbHNlOyAgICAgICAgICAgICAgICAgICAgICAgLy8gTm90IGludGVyc2VjdGVkXHJcblx0XHR9XHJcblxyXG5cclxuXHRcdC8qKlxyXG5cdFx0ICogR2V0IHRoZSBjbG9zZXRzIEFCUyB2YWx1ZSBvZiBlbGVtZW50IGluIGFycmF5IHRvIHRoZSBjdXJyZW50IG15VmFsdWVcclxuXHRcdCAqXHJcblx0XHQgKiBAcGFyYW0gbXlWYWx1ZSBcdC0gaW50IGVsZW1lbnQgdG8gc2VhcmNoIGNsb3NldCBcdFx0XHQ0XHJcblx0XHQgKiBAcGFyYW0gbXlBcnJheVx0LSBhcnJheSBvZiBlbGVtZW50cyB3aGVyZSB0byBzZWFyY2ggXHRbNSw4LDEsN11cclxuXHRcdCAqIEByZXR1cm5zIGludFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdDVcclxuXHRcdCAqL1xyXG5cdFx0ZnVuY3Rpb24gd3BiY19nZXRfYWJzX2Nsb3Nlc3RfdmFsdWVfaW5fYXJyKCBteVZhbHVlLCBteUFycmF5ICl7XHJcblxyXG5cdFx0XHRpZiAoIG15QXJyYXkubGVuZ3RoID09IDAgKXsgXHRcdFx0XHRcdFx0XHRcdC8vIElmIHRoZSBhcnJheSBpcyBlbXB0eSAtPiByZXR1cm4gIHRoZSBteVZhbHVlXHJcblx0XHRcdFx0cmV0dXJuIG15VmFsdWU7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdHZhciBvYmogPSBteUFycmF5WyAwIF07XHJcblx0XHRcdHZhciBkaWZmID0gTWF0aC5hYnMoIG15VmFsdWUgLSBvYmogKTsgICAgICAgICAgICAgXHQvLyBHZXQgZGlzdGFuY2UgYmV0d2VlbiAgMXN0IGVsZW1lbnRcclxuXHRcdFx0dmFyIGNsb3NldFZhbHVlID0gbXlBcnJheVsgMCBdOyAgICAgICAgICAgICAgICAgICBcdFx0XHQvLyBTYXZlIDFzdCBlbGVtZW50XHJcblxyXG5cdFx0XHRmb3IgKCB2YXIgaSA9IDE7IGkgPCBteUFycmF5Lmxlbmd0aDsgaSsrICl7XHJcblx0XHRcdFx0b2JqID0gbXlBcnJheVsgaSBdO1xyXG5cclxuXHRcdFx0XHRpZiAoIE1hdGguYWJzKCBteVZhbHVlIC0gb2JqICkgPCBkaWZmICl7ICAgICBcdFx0XHQvLyB3ZSBmb3VuZCBjbG9zZXIgdmFsdWUgLT4gc2F2ZSBpdFxyXG5cdFx0XHRcdFx0ZGlmZiA9IE1hdGguYWJzKCBteVZhbHVlIC0gb2JqICk7XHJcblx0XHRcdFx0XHRjbG9zZXRWYWx1ZSA9IG9iajtcclxuXHRcdFx0XHR9XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdHJldHVybiBjbG9zZXRWYWx1ZTtcclxuXHRcdH1cclxuXHJcblxyXG4vLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuLy8gIFQgTyBPIEwgVCBJIFAgU1xyXG4vLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHJcblx0LyoqXHJcblx0ICogRGVmaW5lIHRvb2x0aXAgdG8gc2hvdywgIHdoZW4gIG1vdXNlIG92ZXIgRGF0ZSBpbiBDYWxlbmRhclxyXG5cdCAqXHJcblx0ICogQHBhcmFtICB0b29sdGlwX3RleHRcdFx0XHQtIFRleHQgdG8gc2hvd1x0XHRcdFx0J0Jvb2tlZCB0aW1lOiAxMjowMCAtIDEzOjAwPGJyPkNvc3Q6ICQyMC4wMCdcclxuXHQgKiBAcGFyYW0gIHJlc291cmNlX2lkXHRcdFx0LSBJRCBvZiBib29raW5nIHJlc291cmNlXHQnMSdcclxuXHQgKiBAcGFyYW0gIHRkX2NsYXNzXHRcdFx0XHQtIFNRTCBjbGFzc1x0XHRcdFx0XHQnMS05LTIwMjMnXHJcblx0ICogQHJldHVybnMge2Jvb2xlYW59XHRcdFx0XHRcdC0gZGVmaW5lZCB0byBzaG93IG9yIG5vdFxyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfc2V0X3Rvb2x0aXBfX19mb3JfX2NhbGVuZGFyX2RhdGUoIHRvb2x0aXBfdGV4dCwgcmVzb3VyY2VfaWQsIHRkX2NsYXNzICl7XHJcblxyXG5cdFx0Ly9UT0RPOiBtYWtlIGVzY2FwaW5nIG9mIHRleHQgZm9yIHF1b3Qgc3ltYm9scywgIGFuZCBKUy9IVE1MLi4uXHJcblxyXG5cdFx0alF1ZXJ5KCAnI2NhbGVuZGFyX2Jvb2tpbmcnICsgcmVzb3VyY2VfaWQgKyAnIHRkLmNhbDRkYXRlLScgKyB0ZF9jbGFzcyApLmF0dHIoICdkYXRhLWNvbnRlbnQnLCB0b29sdGlwX3RleHQgKTtcclxuXHJcblx0XHR2YXIgdGRfZWwgPSBqUXVlcnkoICcjY2FsZW5kYXJfYm9va2luZycgKyByZXNvdXJjZV9pZCArICcgdGQuY2FsNGRhdGUtJyArIHRkX2NsYXNzICkuZ2V0KCAwICk7XHRcdFx0XHRcdC8vRml4SW46IDkuMC4xLjFcclxuXHJcblx0XHRpZiAoXHJcblx0XHRcdCAgICggJ3VuZGVmaW5lZCcgIT09IHR5cGVvZih0ZF9lbCkgKVxyXG5cdFx0XHQmJiAoIHVuZGVmaW5lZCA9PSB0ZF9lbC5fdGlwcHkgKVxyXG5cdFx0XHQmJiAoICcnICE9PSB0b29sdGlwX3RleHQgKVxyXG5cdFx0KXtcclxuXHJcblx0XHRcdHdwYmNfdGlwcHkoIHRkX2VsICwge1xyXG5cdFx0XHRcdFx0Y29udGVudCggcmVmZXJlbmNlICl7XHJcblxyXG5cdFx0XHRcdFx0XHR2YXIgcG9wb3Zlcl9jb250ZW50ID0gcmVmZXJlbmNlLmdldEF0dHJpYnV0ZSggJ2RhdGEtY29udGVudCcgKTtcclxuXHJcblx0XHRcdFx0XHRcdHJldHVybiAnPGRpdiBjbGFzcz1cInBvcG92ZXIgcG9wb3Zlcl90aXBweVwiPidcclxuXHRcdFx0XHRcdFx0XHRcdFx0KyAnPGRpdiBjbGFzcz1cInBvcG92ZXItY29udGVudFwiPidcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHQrIHBvcG92ZXJfY29udGVudFxyXG5cdFx0XHRcdFx0XHRcdFx0XHQrICc8L2Rpdj4nXHJcblx0XHRcdFx0XHRcdFx0ICsgJzwvZGl2Pic7XHJcblx0XHRcdFx0XHR9LFxyXG5cdFx0XHRcdFx0YWxsb3dIVE1MICAgICAgICA6IHRydWUsXHJcblx0XHRcdFx0XHR0cmlnZ2VyXHRcdFx0IDogJ21vdXNlZW50ZXIgZm9jdXMnLFxyXG5cdFx0XHRcdFx0aW50ZXJhY3RpdmUgICAgICA6IGZhbHNlLFxyXG5cdFx0XHRcdFx0aGlkZU9uQ2xpY2sgICAgICA6IHRydWUsXHJcblx0XHRcdFx0XHRpbnRlcmFjdGl2ZUJvcmRlcjogMTAsXHJcblx0XHRcdFx0XHRtYXhXaWR0aCAgICAgICAgIDogNTUwLFxyXG5cdFx0XHRcdFx0dGhlbWUgICAgICAgICAgICA6ICd3cGJjLXRpcHB5LXRpbWVzJyxcclxuXHRcdFx0XHRcdHBsYWNlbWVudCAgICAgICAgOiAndG9wJyxcclxuXHRcdFx0XHRcdGRlbGF5XHRcdFx0IDogWzQwMCwgMF0sXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0Ly9GaXhJbjogOS40LjIuMlxyXG5cdFx0XHRcdFx0Ly9kZWxheVx0XHRcdCA6IFswLCA5OTk5OTk5OTk5XSxcdFx0XHRcdFx0XHQvLyBEZWJ1Z2UgIHRvb2x0aXBcclxuXHRcdFx0XHRcdGlnbm9yZUF0dHJpYnV0ZXMgOiB0cnVlLFxyXG5cdFx0XHRcdFx0dG91Y2hcdFx0XHQgOiB0cnVlLFx0XHRcdFx0XHRcdFx0XHQvL1snaG9sZCcsIDUwMF0sIC8vIDUwMG1zIGRlbGF5XHRcdFx0XHQvL0ZpeEluOiA5LjIuMS41XHJcblx0XHRcdFx0XHRhcHBlbmRUbzogKCkgPT4gZG9jdW1lbnQuYm9keSxcclxuXHRcdFx0fSk7XHJcblxyXG5cdFx0XHRyZXR1cm4gIHRydWU7XHJcblx0XHR9XHJcblxyXG5cdFx0cmV0dXJuICBmYWxzZTtcclxuXHR9XHJcblxyXG5cclxuLy8gLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcbi8vICA9PSAgRGF0ZXMgRnVuY3Rpb25zICA9PVxyXG4vLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHJcbi8qKlxyXG4gKiBHZXQgbnVtYmVyIG9mIGRhdGVzIGJldHdlZW4gMiBKUyBEYXRlc1xyXG4gKlxyXG4gKiBAcGFyYW0gZGF0ZTFcdFx0SlMgRGF0ZVxyXG4gKiBAcGFyYW0gZGF0ZTJcdFx0SlMgRGF0ZVxyXG4gKiBAcmV0dXJucyB7bnVtYmVyfVxyXG4gKi9cclxuZnVuY3Rpb24gd3BiY19kYXRlc19fZGF5c19iZXR3ZWVuKGRhdGUxLCBkYXRlMikge1xyXG5cclxuICAgIC8vIFRoZSBudW1iZXIgb2YgbWlsbGlzZWNvbmRzIGluIG9uZSBkYXlcclxuICAgIHZhciBPTkVfREFZID0gMTAwMCAqIDYwICogNjAgKiAyNDtcclxuXHJcbiAgICAvLyBDb252ZXJ0IGJvdGggZGF0ZXMgdG8gbWlsbGlzZWNvbmRzXHJcbiAgICB2YXIgZGF0ZTFfbXMgPSBkYXRlMS5nZXRUaW1lKCk7XHJcbiAgICB2YXIgZGF0ZTJfbXMgPSBkYXRlMi5nZXRUaW1lKCk7XHJcblxyXG4gICAgLy8gQ2FsY3VsYXRlIHRoZSBkaWZmZXJlbmNlIGluIG1pbGxpc2Vjb25kc1xyXG4gICAgdmFyIGRpZmZlcmVuY2VfbXMgPSAgZGF0ZTFfbXMgLSBkYXRlMl9tcztcclxuXHJcbiAgICAvLyBDb252ZXJ0IGJhY2sgdG8gZGF5cyBhbmQgcmV0dXJuXHJcbiAgICByZXR1cm4gTWF0aC5yb3VuZChkaWZmZXJlbmNlX21zL09ORV9EQVkpO1xyXG59XHJcblxyXG5cclxuLyoqXHJcbiAqIENoZWNrICBpZiB0aGlzIGFycmF5ICBvZiBkYXRlcyBpcyBjb25zZWN1dGl2ZSBhcnJheSAgb2YgZGF0ZXMgb3Igbm90LlxyXG4gKiBcdFx0ZS5nLiAgWycyMDI0LTA1LTA5JywnMjAyNC0wNS0xOScsJzIwMjQtMDUtMzAnXSAtPiBmYWxzZVxyXG4gKiBcdFx0ZS5nLiAgWycyMDI0LTA1LTA5JywnMjAyNC0wNS0xMCcsJzIwMjQtMDUtMTEnXSAtPiB0cnVlXHJcbiAqIEBwYXJhbSBzcWxfZGF0ZXNfYXJyXHQgYXJyYXlcdFx0ZS5nLjogWycyMDI0LTA1LTA5JywnMjAyNC0wNS0xOScsJzIwMjQtMDUtMzAnXVxyXG4gKiBAcmV0dXJucyB7Ym9vbGVhbn1cclxuICovXHJcbmZ1bmN0aW9uIHdwYmNfZGF0ZXNfX2lzX2NvbnNlY3V0aXZlX2RhdGVzX2Fycl9yYW5nZSggc3FsX2RhdGVzX2FyciApe1x0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0Ly9GaXhJbjogMTAuMC4wLjUwXHJcblxyXG5cdGlmICggc3FsX2RhdGVzX2Fyci5sZW5ndGggPiAxICl7XHJcblx0XHR2YXIgcHJldmlvc19kYXRlID0gd3BiY19fZ2V0X19qc19kYXRlKCBzcWxfZGF0ZXNfYXJyWyAwIF0gKTtcclxuXHRcdHZhciBjdXJyZW50X2RhdGU7XHJcblxyXG5cdFx0Zm9yICggdmFyIGkgPSAxOyBpIDwgc3FsX2RhdGVzX2Fyci5sZW5ndGg7IGkrKyApe1xyXG5cdFx0XHRjdXJyZW50X2RhdGUgPSB3cGJjX19nZXRfX2pzX2RhdGUoIHNxbF9kYXRlc19hcnJbaV0gKTtcclxuXHJcblx0XHRcdGlmICggd3BiY19kYXRlc19fZGF5c19iZXR3ZWVuKCBjdXJyZW50X2RhdGUsIHByZXZpb3NfZGF0ZSApICE9IDEgKXtcclxuXHRcdFx0XHRyZXR1cm4gIGZhbHNlO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHRwcmV2aW9zX2RhdGUgPSBjdXJyZW50X2RhdGU7XHJcblx0XHR9XHJcblx0fVxyXG5cclxuXHRyZXR1cm4gdHJ1ZTtcclxufVxyXG5cclxuXHJcbi8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG4vLyAgPT0gIEF1dG8gRGF0ZXMgU2VsZWN0aW9uICA9PVxyXG4vLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHJcbi8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuLy8gQXV0byBGaWxsIEZpZWxkcyAvIEF1dG8gU2VsZWN0IERhdGVzXHJcbi8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuLyoqXHJcbiAqICA9PSBIb3cgdG8gIHVzZSA/ID09ICAgICAgRm9yIERhdGVzIHNlbGVjdGlvbiwgd2UgbmVlZCB0byB1c2UgdGhpcyBsb2dpYyEgICAgIFdlIG5lZWQgc2VsZWN0IHRoZSBkYXRlcyBvbmx5IGFmdGVyIGJvb2tpbmcgZGF0YSBsb2FkZWQhICAgICBDaGVjayBleGFtcGxlIGJlbGxvdy5cclxuICpcclxuICpcdC8vIEZpcmUgb24gYWxsIGJvb2tpbmcgZGF0ZXMgbG9hZGVkXHJcbiAqXHRqUXVlcnkoICdib2R5JyApLm9uKCAnd3BiY19jYWxlbmRhcl9hanhfX2xvYWRlZF9kYXRhJywgZnVuY3Rpb24gKCBldmVudCwgbG9hZGVkX3Jlc291cmNlX2lkICl7XHJcbiAqXHJcbiAqXHRcdGlmICggbG9hZGVkX3Jlc291cmNlX2lkID09IHNlbGVjdF9kYXRlc19pbl9jYWxlbmRhcl9pZCApe1xyXG4gKlx0XHRcdHdwYmNfYXV0b19zZWxlY3RfZGF0ZXNfaW5fY2FsZW5kYXIoIHNlbGVjdF9kYXRlc19pbl9jYWxlbmRhcl9pZCwgJzIwMjQtMDUtMTUnLCAnMjAyNC0wNS0yNScgKTtcclxuICpcdFx0fVxyXG4gKlx0fSApO1xyXG4gKlxyXG4gKi9cclxuXHJcblxyXG5cclxuLyoqXHJcbiAqIFRyeSB0byBBdXRvIHNlbGVjdCBkYXRlcyBpbiBzcGVjaWZpYyBjYWxlbmRhciBieSBzaW11bGF0ZWQgY2xpY2tzIGluIGRhdGVwaWNrZXJcclxuICpcclxuICogQHBhcmFtIHJlc291cmNlX2lkXHRcdDFcclxuICogQHBhcmFtIGNoZWNrX2luX3ltZFx0XHQnMjAyNC0wNS0wOSdcdFx0T1IgIFx0WycyMDI0LTA1LTA5JywnMjAyNC0wNS0xOScsJzIwMjQtMDUtMjAnXVxyXG4gKiBAcGFyYW0gY2hlY2tfb3V0X3ltZFx0XHQnMjAyNC0wNS0xNSdcdFx0T3B0aW9uYWxcclxuICpcclxuICogQHJldHVybnMge251bWJlcn1cdFx0bnVtYmVyIG9mIHNlbGVjdGVkIGRhdGVzXHJcbiAqXHJcbiAqIFx0RXhhbXBsZSAxOlx0XHRcdFx0dmFyIG51bV9zZWxlY3RlZF9kYXlzID0gd3BiY19hdXRvX3NlbGVjdF9kYXRlc19pbl9jYWxlbmRhciggMSwgJzIwMjQtMDUtMTUnLCAnMjAyNC0wNS0yNScgKTtcclxuICogXHRFeGFtcGxlIDI6XHRcdFx0XHR2YXIgbnVtX3NlbGVjdGVkX2RheXMgPSB3cGJjX2F1dG9fc2VsZWN0X2RhdGVzX2luX2NhbGVuZGFyKCAxLCBbJzIwMjQtMDUtMDknLCcyMDI0LTA1LTE5JywnMjAyNC0wNS0yMCddICk7XHJcbiAqL1xyXG5mdW5jdGlvbiB3cGJjX2F1dG9fc2VsZWN0X2RhdGVzX2luX2NhbGVuZGFyKCByZXNvdXJjZV9pZCwgY2hlY2tfaW5feW1kLCBjaGVja19vdXRfeW1kID0gJycgKXtcdFx0XHRcdFx0XHRcdFx0Ly9GaXhJbjogMTAuMC4wLjQ3XHJcblxyXG5cdGNvbnNvbGUubG9nKCAnV1BCQ19BVVRPX1NFTEVDVF9EQVRFU19JTl9DQUxFTkRBUiggUkVTT1VSQ0VfSUQsIENIRUNLX0lOX1lNRCwgQ0hFQ0tfT1VUX1lNRCApJywgcmVzb3VyY2VfaWQsIGNoZWNrX2luX3ltZCwgY2hlY2tfb3V0X3ltZCApO1xyXG5cclxuXHRpZiAoXHJcblx0XHQgICAoICcyMTAwLTAxLTAxJyA9PSBjaGVja19pbl95bWQgKVxyXG5cdFx0fHwgKCAnMjEwMC0wMS0wMScgPT0gY2hlY2tfb3V0X3ltZCApXHJcblx0XHR8fCAoICggJycgPT0gY2hlY2tfaW5feW1kICkgJiYgKCAnJyA9PSBjaGVja19vdXRfeW1kICkgKVxyXG5cdCl7XHJcblx0XHRyZXR1cm4gMDtcclxuXHR9XHJcblxyXG5cdC8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblx0Ly8gSWYgXHRjaGVja19pbl95bWQgID0gIFsgJzIwMjQtMDUtMDknLCcyMDI0LTA1LTE5JywnMjAyNC0wNS0zMCcgXVx0XHRcdFx0QVJSQVkgb2YgREFURVNcdFx0XHRcdFx0XHQvL0ZpeEluOiAxMC4wLjAuNTBcclxuXHQvLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cdHZhciBkYXRlc190b19zZWxlY3RfYXJyID0gW107XHJcblx0aWYgKCBBcnJheS5pc0FycmF5KCBjaGVja19pbl95bWQgKSApe1xyXG5cdFx0ZGF0ZXNfdG9fc2VsZWN0X2FyciA9IHdwYmNfY2xvbmVfb2JqKCBjaGVja19pbl95bWQgKTtcclxuXHJcblx0XHQvLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblx0XHQvLyBFeGNlcHRpb25zIHRvICBzZXQgIFx0TVVMVElQTEUgREFZUyBcdG1vZGVcclxuXHRcdC8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHRcdC8vIGlmIGRhdGVzIGFzIE5PVCBDT05TRUNVVElWRTogWycyMDI0LTA1LTA5JywnMjAyNC0wNS0xOScsJzIwMjQtMDUtMzAnXSwgLT4gc2V0IE1VTFRJUExFIERBWVMgbW9kZVxyXG5cdFx0aWYgKFxyXG5cdFx0XHQgICAoIGRhdGVzX3RvX3NlbGVjdF9hcnIubGVuZ3RoID4gMCApXHJcblx0XHRcdCYmICggJycgPT0gY2hlY2tfb3V0X3ltZCApXHJcblx0XHRcdCYmICggISB3cGJjX2RhdGVzX19pc19jb25zZWN1dGl2ZV9kYXRlc19hcnJfcmFuZ2UoIGRhdGVzX3RvX3NlbGVjdF9hcnIgKSApXHJcblx0XHQpe1xyXG5cdFx0XHR3cGJjX2NhbF9kYXlzX3NlbGVjdF9fbXVsdGlwbGUoIHJlc291cmNlX2lkICk7XHJcblx0XHR9XHJcblx0XHQvLyBpZiBtdWx0aXBsZSBkYXlzIHRvIHNlbGVjdCwgYnV0IGVuYWJsZWQgU0lOR0xFIGRheSBtb2RlLCAtPiBzZXQgTVVMVElQTEUgREFZUyBtb2RlXHJcblx0XHRpZiAoXHJcblx0XHRcdCAgICggZGF0ZXNfdG9fc2VsZWN0X2Fyci5sZW5ndGggPiAxIClcclxuXHRcdFx0JiYgKCAnJyA9PSBjaGVja19vdXRfeW1kIClcclxuXHRcdFx0JiYgKCAnc2luZ2xlJyA9PT0gX3dwYmMuY2FsZW5kYXJfX2dldF9wYXJhbV92YWx1ZSggcmVzb3VyY2VfaWQsICdkYXlzX3NlbGVjdF9tb2RlJyApIClcclxuXHRcdCl7XHJcblx0XHRcdHdwYmNfY2FsX2RheXNfc2VsZWN0X19tdWx0aXBsZSggcmVzb3VyY2VfaWQgKTtcclxuXHRcdH1cclxuXHRcdC8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHRcdGNoZWNrX2luX3ltZCA9IGRhdGVzX3RvX3NlbGVjdF9hcnJbIDAgXTtcclxuXHRcdGlmICggJycgPT0gY2hlY2tfb3V0X3ltZCApe1xyXG5cdFx0XHRjaGVja19vdXRfeW1kID0gZGF0ZXNfdG9fc2VsZWN0X2FyclsgKGRhdGVzX3RvX3NlbGVjdF9hcnIubGVuZ3RoLTEpIF07XHJcblx0XHR9XHJcblx0fVxyXG5cdC8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblxyXG5cclxuXHRpZiAoICcnID09IGNoZWNrX2luX3ltZCApe1xyXG5cdFx0Y2hlY2tfaW5feW1kID0gY2hlY2tfb3V0X3ltZDtcclxuXHR9XHJcblx0aWYgKCAnJyA9PSBjaGVja19vdXRfeW1kICl7XHJcblx0XHRjaGVja19vdXRfeW1kID0gY2hlY2tfaW5feW1kO1xyXG5cdH1cclxuXHJcblx0aWYgKCAndW5kZWZpbmVkJyA9PT0gdHlwZW9mIChyZXNvdXJjZV9pZCkgKXtcclxuXHRcdHJlc291cmNlX2lkID0gJzEnO1xyXG5cdH1cclxuXHJcblxyXG5cdHZhciBpbnN0ID0gd3BiY19jYWxlbmRhcl9fZ2V0X2luc3QoIHJlc291cmNlX2lkICk7XHJcblxyXG5cdGlmICggbnVsbCAhPT0gaW5zdCApe1xyXG5cclxuXHRcdC8vIFVuc2VsZWN0IGFsbCBkYXRlcyBhbmQgc2V0ICBwcm9wZXJ0aWVzIG9mIERhdGVwaWNrXHJcblx0XHRqUXVlcnkoICcjZGF0ZV9ib29raW5nJyArIHJlc291cmNlX2lkICkudmFsKCAnJyApOyAgICAgIFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQvL0ZpeEluOiA1LjQuM1xyXG5cdFx0aW5zdC5zdGF5T3BlbiA9IGZhbHNlO1xyXG5cdFx0aW5zdC5kYXRlcyA9IFtdO1xyXG5cdFx0dmFyIGNoZWNrX2luX2pzID0gd3BiY19fZ2V0X19qc19kYXRlKCBjaGVja19pbl95bWQgKTtcclxuXHRcdHZhciB0ZF9jZWxsICAgICA9IHdwYmNfZ2V0X2NsaWNrZWRfdGQoIGluc3QuaWQsIGNoZWNrX2luX2pzICk7XHJcblxyXG5cdFx0Ly8gLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblx0XHQvLyAgPT0gRFlOQU1JQyA9PVxyXG5cdFx0aWYgKCAnZHluYW1pYycgPT09IF93cGJjLmNhbGVuZGFyX19nZXRfcGFyYW1fdmFsdWUoIHJlc291cmNlX2lkLCAnZGF5c19zZWxlY3RfbW9kZScgKSApe1xyXG5cdFx0XHQvLyAxLXN0IGNsaWNrXHJcblx0XHRcdGluc3Quc3RheU9wZW4gPSBmYWxzZTtcclxuXHRcdFx0alF1ZXJ5LmRhdGVwaWNrLl9zZWxlY3REYXkoIHRkX2NlbGwsICcjJyArIGluc3QuaWQsIGNoZWNrX2luX2pzLmdldFRpbWUoKSApO1xyXG5cdFx0XHRpZiAoIDAgPT09IGluc3QuZGF0ZXMubGVuZ3RoICl7XHJcblx0XHRcdFx0cmV0dXJuIDA7ICBcdFx0XHRcdFx0XHRcdFx0Ly8gRmlyc3QgY2xpY2sgIHdhcyB1bnN1Y2Nlc3NmdWwsIHNvIHdlIG11c3Qgbm90IG1ha2Ugb3RoZXIgY2xpY2tcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0Ly8gMi1uZCBjbGlja1xyXG5cdFx0XHR2YXIgY2hlY2tfb3V0X2pzID0gd3BiY19fZ2V0X19qc19kYXRlKCBjaGVja19vdXRfeW1kICk7XHJcblx0XHRcdHZhciB0ZF9jZWxsX291dCA9IHdwYmNfZ2V0X2NsaWNrZWRfdGQoIGluc3QuaWQsIGNoZWNrX291dF9qcyApO1xyXG5cdFx0XHRpbnN0LnN0YXlPcGVuID0gdHJ1ZTtcclxuXHRcdFx0alF1ZXJ5LmRhdGVwaWNrLl9zZWxlY3REYXkoIHRkX2NlbGxfb3V0LCAnIycgKyBpbnN0LmlkLCBjaGVja19vdXRfanMuZ2V0VGltZSgpICk7XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblx0XHQvLyAgPT0gRklYRUQgPT1cclxuXHRcdGlmICggICdmaXhlZCcgPT09IF93cGJjLmNhbGVuZGFyX19nZXRfcGFyYW1fdmFsdWUoIHJlc291cmNlX2lkLCAnZGF5c19zZWxlY3RfbW9kZScgKSkge1xyXG5cdFx0XHRqUXVlcnkuZGF0ZXBpY2suX3NlbGVjdERheSggdGRfY2VsbCwgJyMnICsgaW5zdC5pZCwgY2hlY2tfaW5fanMuZ2V0VGltZSgpICk7XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblx0XHQvLyAgPT0gU0lOR0xFID09XHJcblx0XHRpZiAoICdzaW5nbGUnID09PSBfd3BiYy5jYWxlbmRhcl9fZ2V0X3BhcmFtX3ZhbHVlKCByZXNvdXJjZV9pZCwgJ2RheXNfc2VsZWN0X21vZGUnICkgKXtcclxuXHRcdFx0Ly9qUXVlcnkuZGF0ZXBpY2suX3Jlc3RyaWN0TWluTWF4KCBpbnN0LCBqUXVlcnkuZGF0ZXBpY2suX2RldGVybWluZURhdGUoIGluc3QsIGNoZWNrX2luX2pzLCBudWxsICkgKTtcdFx0Ly8gRG8gd2UgbmVlZCB0byBydW4gIHRoaXMgPyBQbGVhc2Ugbm90ZSwgY2hlY2tfaW5fanMgbXVzdCAgaGF2ZSB0aW1lLCAgbWluLCBzZWMgZGVmaW5lZCB0byAwIVxyXG5cdFx0XHRqUXVlcnkuZGF0ZXBpY2suX3NlbGVjdERheSggdGRfY2VsbCwgJyMnICsgaW5zdC5pZCwgY2hlY2tfaW5fanMuZ2V0VGltZSgpICk7XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblx0XHQvLyAgPT0gTVVMVElQTEUgPT1cclxuXHRcdGlmICggJ211bHRpcGxlJyA9PT0gX3dwYmMuY2FsZW5kYXJfX2dldF9wYXJhbV92YWx1ZSggcmVzb3VyY2VfaWQsICdkYXlzX3NlbGVjdF9tb2RlJyApICl7XHJcblxyXG5cdFx0XHR2YXIgZGF0ZXNfYXJyO1xyXG5cclxuXHRcdFx0aWYgKCBkYXRlc190b19zZWxlY3RfYXJyLmxlbmd0aCA+IDAgKXtcclxuXHRcdFx0XHQvLyBTaXR1YXRpb24sIHdoZW4gd2UgaGF2ZSBkYXRlcyBhcnJheTogWycyMDI0LTA1LTA5JywnMjAyNC0wNS0xOScsJzIwMjQtMDUtMzAnXS4gIGFuZCBub3QgdGhlIENoZWNrIEluIC8gQ2hlY2sgIG91dCBkYXRlcyBhcyBwYXJhbWV0ZXIgaW4gdGhpcyBmdW5jdGlvblxyXG5cdFx0XHRcdGRhdGVzX2FyciA9IHdwYmNfZ2V0X3NlbGVjdGlvbl9kYXRlc19qc19zdHJfYXJyX19mcm9tX2FyciggZGF0ZXNfdG9fc2VsZWN0X2FyciApO1xyXG5cdFx0XHR9IGVsc2Uge1xyXG5cdFx0XHRcdGRhdGVzX2FyciA9IHdwYmNfZ2V0X3NlbGVjdGlvbl9kYXRlc19qc19zdHJfYXJyX19mcm9tX2NoZWNrX2luX291dCggY2hlY2tfaW5feW1kLCBjaGVja19vdXRfeW1kLCBpbnN0ICk7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdGlmICggMCA9PT0gZGF0ZXNfYXJyLmRhdGVzX2pzLmxlbmd0aCApe1xyXG5cdFx0XHRcdHJldHVybiAwO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHQvLyBGb3IgQ2FsZW5kYXIgRGF5cyBzZWxlY3Rpb25cclxuXHRcdFx0Zm9yICggdmFyIGogPSAwOyBqIDwgZGF0ZXNfYXJyLmRhdGVzX2pzLmxlbmd0aDsgaisrICl7ICAgICAgIC8vIExvb3AgYXJyYXkgb2YgZGF0ZXNcclxuXHJcblx0XHRcdFx0dmFyIHN0cl9kYXRlID0gd3BiY19fZ2V0X19zcWxfY2xhc3NfZGF0ZSggZGF0ZXNfYXJyLmRhdGVzX2pzWyBqIF0gKTtcclxuXHJcblx0XHRcdFx0Ly8gRGF0ZSB1bmF2YWlsYWJsZSAhXHJcblx0XHRcdFx0aWYgKCAwID09IF93cGJjLmJvb2tpbmdzX2luX2NhbGVuZGFyX19nZXRfZm9yX2RhdGUoIHJlc291cmNlX2lkLCBzdHJfZGF0ZSApLmRheV9hdmFpbGFiaWxpdHkgKXtcclxuXHRcdFx0XHRcdHJldHVybiAwO1xyXG5cdFx0XHRcdH1cclxuXHJcblx0XHRcdFx0aWYgKCBkYXRlc19hcnIuZGF0ZXNfanNbIGogXSAhPSAtMSApIHtcclxuXHRcdFx0XHRcdGluc3QuZGF0ZXMucHVzaCggZGF0ZXNfYXJyLmRhdGVzX2pzWyBqIF0gKTtcclxuXHRcdFx0XHR9XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdHZhciBjaGVja19vdXRfZGF0ZSA9IGRhdGVzX2Fyci5kYXRlc19qc1sgKGRhdGVzX2Fyci5kYXRlc19qcy5sZW5ndGggLSAxKSBdO1xyXG5cclxuXHRcdFx0aW5zdC5kYXRlcy5wdXNoKCBjaGVja19vdXRfZGF0ZSApOyBcdFx0XHQvLyBOZWVkIGFkZCBvbmUgYWRkaXRpb25hbCBTQU1FIGRhdGUgZm9yIGNvcnJlY3QgIHdvcmtzIG9mIGRhdGVzIHNlbGVjdGlvbiAhISEhIVxyXG5cclxuXHRcdFx0dmFyIGNoZWNrb3V0X3RpbWVzdGFtcCA9IGNoZWNrX291dF9kYXRlLmdldFRpbWUoKTtcclxuXHRcdFx0dmFyIHRkX2NlbGwgPSB3cGJjX2dldF9jbGlja2VkX3RkKCBpbnN0LmlkLCBjaGVja19vdXRfZGF0ZSApO1xyXG5cclxuXHRcdFx0alF1ZXJ5LmRhdGVwaWNrLl9zZWxlY3REYXkoIHRkX2NlbGwsICcjJyArIGluc3QuaWQsIGNoZWNrb3V0X3RpbWVzdGFtcCApO1xyXG5cdFx0fVxyXG5cclxuXHJcblx0XHRpZiAoIDAgIT09IGluc3QuZGF0ZXMubGVuZ3RoICl7XHJcblx0XHRcdC8vIFNjcm9sbCB0byBzcGVjaWZpYyBtb250aCwgaWYgd2Ugc2V0IGRhdGVzIGluIHNvbWUgZnV0dXJlIG1vbnRoc1xyXG5cdFx0XHR3cGJjX2NhbGVuZGFyX19zY3JvbGxfdG8oIHJlc291cmNlX2lkLCBpbnN0LmRhdGVzWyAwIF0uZ2V0RnVsbFllYXIoKSwgaW5zdC5kYXRlc1sgMCBdLmdldE1vbnRoKCkrMSApO1xyXG5cdFx0fVxyXG5cclxuXHRcdHJldHVybiBpbnN0LmRhdGVzLmxlbmd0aDtcclxuXHR9XHJcblxyXG5cdHJldHVybiAwO1xyXG59XHJcblxyXG5cdC8qKlxyXG5cdCAqIEdldCBIVE1MIHRkIGVsZW1lbnQgKHdoZXJlIHdhcyBjbGljayBpbiBjYWxlbmRhciAgZGF5ICBjZWxsKVxyXG5cdCAqXHJcblx0ICogQHBhcmFtIGNhbGVuZGFyX2h0bWxfaWRcdFx0XHQnY2FsZW5kYXJfYm9va2luZzEnXHJcblx0ICogQHBhcmFtIGRhdGVfanNcdFx0XHRcdFx0SlMgRGF0ZVxyXG5cdCAqIEByZXR1cm5zIHsqfGpRdWVyeX1cdFx0XHRcdERvbSBIVE1MIHRkIGVsZW1lbnRcclxuXHQgKi9cclxuXHRmdW5jdGlvbiB3cGJjX2dldF9jbGlja2VkX3RkKCBjYWxlbmRhcl9odG1sX2lkLCBkYXRlX2pzICl7XHJcblxyXG5cdCAgICB2YXIgdGRfY2VsbCA9IGpRdWVyeSggJyMnICsgY2FsZW5kYXJfaHRtbF9pZCArICcgLnNxbF9kYXRlXycgKyB3cGJjX19nZXRfX3NxbF9jbGFzc19kYXRlKCBkYXRlX2pzICkgKS5nZXQoIDAgKTtcclxuXHJcblx0XHRyZXR1cm4gdGRfY2VsbDtcclxuXHR9XHJcblxyXG5cdC8qKlxyXG5cdCAqIEdldCBhcnJheXMgb2YgSlMgYW5kIFNRTCBkYXRlcyBhcyBkYXRlcyBhcnJheVxyXG5cdCAqXHJcblx0ICogQHBhcmFtIGNoZWNrX2luX3ltZFx0XHRcdFx0XHRcdFx0JzIwMjQtMDUtMTUnXHJcblx0ICogQHBhcmFtIGNoZWNrX291dF95bWRcdFx0XHRcdFx0XHRcdCcyMDI0LTA1LTI1J1xyXG5cdCAqIEBwYXJhbSBpbnN0XHRcdFx0XHRcdFx0XHRcdFx0RGF0ZXBpY2sgSW5zdC4gVXNlIHdwYmNfY2FsZW5kYXJfX2dldF9pbnN0KCByZXNvdXJjZV9pZCApO1xyXG5cdCAqIEByZXR1cm5zIHt7ZGF0ZXNfanM6ICpbXSwgZGF0ZXNfc3RyOiAqW119fVxyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfZ2V0X3NlbGVjdGlvbl9kYXRlc19qc19zdHJfYXJyX19mcm9tX2NoZWNrX2luX291dCggY2hlY2tfaW5feW1kLCBjaGVja19vdXRfeW1kICwgaW5zdCApe1xyXG5cclxuXHRcdHZhciBvcmlnaW5hbF9hcnJheSA9IFtdO1xyXG5cdFx0dmFyIGRhdGU7XHJcblx0XHR2YXIgYmtfZGlzdGluY3RfZGF0ZXMgPSBbXTtcclxuXHJcblx0XHR2YXIgY2hlY2tfaW5fZGF0ZSA9IGNoZWNrX2luX3ltZC5zcGxpdCggJy0nICk7XHJcblx0XHR2YXIgY2hlY2tfb3V0X2RhdGUgPSBjaGVja19vdXRfeW1kLnNwbGl0KCAnLScgKTtcclxuXHJcblx0XHRkYXRlID0gbmV3IERhdGUoKTtcclxuXHRcdGRhdGUuc2V0RnVsbFllYXIoIGNoZWNrX2luX2RhdGVbIDAgXSwgKGNoZWNrX2luX2RhdGVbIDEgXSAtIDEpLCBjaGVja19pbl9kYXRlWyAyIF0gKTsgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAvLyB5ZWFyLCBtb250aCwgZGF0ZVxyXG5cdFx0dmFyIG9yaWdpbmFsX2NoZWNrX2luX2RhdGUgPSBkYXRlO1xyXG5cdFx0b3JpZ2luYWxfYXJyYXkucHVzaCggalF1ZXJ5LmRhdGVwaWNrLl9yZXN0cmljdE1pbk1heCggaW5zdCwgalF1ZXJ5LmRhdGVwaWNrLl9kZXRlcm1pbmVEYXRlKCBpbnN0LCBkYXRlLCBudWxsICkgKSApOyAvL2FkZCBkYXRlXHJcblx0XHRpZiAoICEgd3BkZXZfaW5fYXJyYXkoIGJrX2Rpc3RpbmN0X2RhdGVzLCAoY2hlY2tfaW5fZGF0ZVsgMiBdICsgJy4nICsgY2hlY2tfaW5fZGF0ZVsgMSBdICsgJy4nICsgY2hlY2tfaW5fZGF0ZVsgMCBdKSApICl7XHJcblx0XHRcdGJrX2Rpc3RpbmN0X2RhdGVzLnB1c2goIHBhcnNlSW50KGNoZWNrX2luX2RhdGVbIDIgXSkgKyAnLicgKyBwYXJzZUludChjaGVja19pbl9kYXRlWyAxIF0pICsgJy4nICsgY2hlY2tfaW5fZGF0ZVsgMCBdICk7XHJcblx0XHR9XHJcblxyXG5cdFx0dmFyIGRhdGVfb3V0ID0gbmV3IERhdGUoKTtcclxuXHRcdGRhdGVfb3V0LnNldEZ1bGxZZWFyKCBjaGVja19vdXRfZGF0ZVsgMCBdLCAoY2hlY2tfb3V0X2RhdGVbIDEgXSAtIDEpLCBjaGVja19vdXRfZGF0ZVsgMiBdICk7ICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgLy8geWVhciwgbW9udGgsIGRhdGVcclxuXHRcdHZhciBvcmlnaW5hbF9jaGVja19vdXRfZGF0ZSA9IGRhdGVfb3V0O1xyXG5cclxuXHRcdHZhciBtZXdEYXRlID0gbmV3IERhdGUoIG9yaWdpbmFsX2NoZWNrX2luX2RhdGUuZ2V0RnVsbFllYXIoKSwgb3JpZ2luYWxfY2hlY2tfaW5fZGF0ZS5nZXRNb250aCgpLCBvcmlnaW5hbF9jaGVja19pbl9kYXRlLmdldERhdGUoKSApO1xyXG5cdFx0bWV3RGF0ZS5zZXREYXRlKCBvcmlnaW5hbF9jaGVja19pbl9kYXRlLmdldERhdGUoKSArIDEgKTtcclxuXHJcblx0XHR3aGlsZSAoXHJcblx0XHRcdChvcmlnaW5hbF9jaGVja19vdXRfZGF0ZSA+IGRhdGUpICYmXHJcblx0XHRcdChvcmlnaW5hbF9jaGVja19pbl9kYXRlICE9IG9yaWdpbmFsX2NoZWNrX291dF9kYXRlKSApe1xyXG5cdFx0XHRkYXRlID0gbmV3IERhdGUoIG1ld0RhdGUuZ2V0RnVsbFllYXIoKSwgbWV3RGF0ZS5nZXRNb250aCgpLCBtZXdEYXRlLmdldERhdGUoKSApO1xyXG5cclxuXHRcdFx0b3JpZ2luYWxfYXJyYXkucHVzaCggalF1ZXJ5LmRhdGVwaWNrLl9yZXN0cmljdE1pbk1heCggaW5zdCwgalF1ZXJ5LmRhdGVwaWNrLl9kZXRlcm1pbmVEYXRlKCBpbnN0LCBkYXRlLCBudWxsICkgKSApOyAvL2FkZCBkYXRlXHJcblx0XHRcdGlmICggIXdwZGV2X2luX2FycmF5KCBia19kaXN0aW5jdF9kYXRlcywgKGRhdGUuZ2V0RGF0ZSgpICsgJy4nICsgcGFyc2VJbnQoIGRhdGUuZ2V0TW9udGgoKSArIDEgKSArICcuJyArIGRhdGUuZ2V0RnVsbFllYXIoKSkgKSApe1xyXG5cdFx0XHRcdGJrX2Rpc3RpbmN0X2RhdGVzLnB1c2goIChwYXJzZUludChkYXRlLmdldERhdGUoKSkgKyAnLicgKyBwYXJzZUludCggZGF0ZS5nZXRNb250aCgpICsgMSApICsgJy4nICsgZGF0ZS5nZXRGdWxsWWVhcigpKSApO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHRtZXdEYXRlID0gbmV3IERhdGUoIGRhdGUuZ2V0RnVsbFllYXIoKSwgZGF0ZS5nZXRNb250aCgpLCBkYXRlLmdldERhdGUoKSApO1xyXG5cdFx0XHRtZXdEYXRlLnNldERhdGUoIG1ld0RhdGUuZ2V0RGF0ZSgpICsgMSApO1xyXG5cdFx0fVxyXG5cdFx0b3JpZ2luYWxfYXJyYXkucG9wKCk7XHJcblx0XHRia19kaXN0aW5jdF9kYXRlcy5wb3AoKTtcclxuXHJcblx0XHRyZXR1cm4geydkYXRlc19qcyc6IG9yaWdpbmFsX2FycmF5LCAnZGF0ZXNfc3RyJzogYmtfZGlzdGluY3RfZGF0ZXN9O1xyXG5cdH1cclxuXHJcblx0LyoqXHJcblx0ICogR2V0IGFycmF5cyBvZiBKUyBhbmQgU1FMIGRhdGVzIGFzIGRhdGVzIGFycmF5XHJcblx0ICpcclxuXHQgKiBAcGFyYW0gZGF0ZXNfdG9fc2VsZWN0X2Fyclx0PSBbJzIwMjQtMDUtMDknLCcyMDI0LTA1LTE5JywnMjAyNC0wNS0zMCddXHJcblx0ICpcclxuXHQgKiBAcmV0dXJucyB7e2RhdGVzX2pzOiAqW10sIGRhdGVzX3N0cjogKltdfX1cclxuXHQgKi9cclxuXHRmdW5jdGlvbiB3cGJjX2dldF9zZWxlY3Rpb25fZGF0ZXNfanNfc3RyX2Fycl9fZnJvbV9hcnIoIGRhdGVzX3RvX3NlbGVjdF9hcnIgKXtcdFx0XHRcdFx0XHRcdFx0XHRcdC8vRml4SW46IDEwLjAuMC41MFxyXG5cclxuXHRcdHZhciBvcmlnaW5hbF9hcnJheSAgICA9IFtdO1xyXG5cdFx0dmFyIGJrX2Rpc3RpbmN0X2RhdGVzID0gW107XHJcblx0XHR2YXIgb25lX2RhdGVfc3RyO1xyXG5cclxuXHRcdGZvciAoIHZhciBkID0gMDsgZCA8IGRhdGVzX3RvX3NlbGVjdF9hcnIubGVuZ3RoOyBkKysgKXtcclxuXHJcblx0XHRcdG9yaWdpbmFsX2FycmF5LnB1c2goIHdwYmNfX2dldF9fanNfZGF0ZSggZGF0ZXNfdG9fc2VsZWN0X2FyclsgZCBdICkgKTtcclxuXHJcblx0XHRcdG9uZV9kYXRlX3N0ciA9IGRhdGVzX3RvX3NlbGVjdF9hcnJbIGQgXS5zcGxpdCgnLScpXHJcblx0XHRcdGlmICggISB3cGRldl9pbl9hcnJheSggYmtfZGlzdGluY3RfZGF0ZXMsIChvbmVfZGF0ZV9zdHJbIDIgXSArICcuJyArIG9uZV9kYXRlX3N0clsgMSBdICsgJy4nICsgb25lX2RhdGVfc3RyWyAwIF0pICkgKXtcclxuXHRcdFx0XHRia19kaXN0aW5jdF9kYXRlcy5wdXNoKCBwYXJzZUludChvbmVfZGF0ZV9zdHJbIDIgXSkgKyAnLicgKyBwYXJzZUludChvbmVfZGF0ZV9zdHJbIDEgXSkgKyAnLicgKyBvbmVfZGF0ZV9zdHJbIDAgXSApO1xyXG5cdFx0XHR9XHJcblx0XHR9XHJcblxyXG5cdFx0cmV0dXJuIHsnZGF0ZXNfanMnOiBvcmlnaW5hbF9hcnJheSwgJ2RhdGVzX3N0cic6IG9yaWdpbmFsX2FycmF5fTtcclxuXHR9XHJcblxyXG5cclxualF1ZXJ5KCBkb2N1bWVudCApLnJlYWR5KCBmdW5jdGlvbiAoKXtcclxuXHJcblx0dmFyIHVybF9wYXJhbXMgPSBuZXcgVVJMU2VhcmNoUGFyYW1zKCB3aW5kb3cubG9jYXRpb24uc2VhcmNoICk7XHJcblxyXG5cdC8vIERpc2FibGUgZGF5cyBzZWxlY3Rpb24gIGluIGNhbGVuZGFyLCAgYWZ0ZXIgIHJlZGlyZWN0aW9uICBmcm9tICB0aGUgXCJTZWFyY2ggcmVzdWx0cyBwYWdlLCAgYWZ0ZXIgIHNlYXJjaCAgYXZhaWxhYmlsaXR5XCIgXHRcdFx0Ly9GaXhJbjogOC44LjIuM1xyXG5cdGlmICAoICdPbicgIT0gX3dwYmMuZ2V0X290aGVyX3BhcmFtKCAnaXNfZW5hYmxlZF9ib29raW5nX3NlYXJjaF9yZXN1bHRzX2RheXNfc2VsZWN0JyApICkge1xyXG5cdFx0aWYgKFxyXG5cdFx0XHQoIHVybF9wYXJhbXMuaGFzKCAnd3BiY19zZWxlY3RfY2hlY2tfaW4nICkgKSAmJlxyXG5cdFx0XHQoIHVybF9wYXJhbXMuaGFzKCAnd3BiY19zZWxlY3RfY2hlY2tfb3V0JyApICkgJiZcclxuXHRcdFx0KCB1cmxfcGFyYW1zLmhhcyggJ3dwYmNfc2VsZWN0X2NhbGVuZGFyX2lkJyApIClcclxuXHRcdCl7XHJcblxyXG5cdFx0XHR2YXIgc2VsZWN0X2RhdGVzX2luX2NhbGVuZGFyX2lkID0gcGFyc2VJbnQoIHVybF9wYXJhbXMuZ2V0KCAnd3BiY19zZWxlY3RfY2FsZW5kYXJfaWQnICkgKTtcclxuXHJcblx0XHRcdC8vIEZpcmUgb24gYWxsIGJvb2tpbmcgZGF0ZXMgbG9hZGVkXHJcblx0XHRcdGpRdWVyeSggJ2JvZHknICkub24oICd3cGJjX2NhbGVuZGFyX2FqeF9fbG9hZGVkX2RhdGEnLCBmdW5jdGlvbiAoIGV2ZW50LCBsb2FkZWRfcmVzb3VyY2VfaWQgKXtcclxuXHJcblx0XHRcdFx0aWYgKCBsb2FkZWRfcmVzb3VyY2VfaWQgPT0gc2VsZWN0X2RhdGVzX2luX2NhbGVuZGFyX2lkICl7XHJcblx0XHRcdFx0XHR3cGJjX2F1dG9fc2VsZWN0X2RhdGVzX2luX2NhbGVuZGFyKCBzZWxlY3RfZGF0ZXNfaW5fY2FsZW5kYXJfaWQsIHVybF9wYXJhbXMuZ2V0KCAnd3BiY19zZWxlY3RfY2hlY2tfaW4nICksIHVybF9wYXJhbXMuZ2V0KCAnd3BiY19zZWxlY3RfY2hlY2tfb3V0JyApICk7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHR9ICk7XHJcblx0XHR9XHJcblx0fVxyXG5cclxuXHRpZiAoIHVybF9wYXJhbXMuaGFzKCAnd3BiY19hdXRvX2ZpbGwnICkgKXtcclxuXHJcblx0XHR2YXIgd3BiY19hdXRvX2ZpbGxfdmFsdWUgPSB1cmxfcGFyYW1zLmdldCggJ3dwYmNfYXV0b19maWxsJyApO1xyXG5cclxuXHRcdC8vIENvbnZlcnQgYmFjay4gICAgIFNvbWUgc3lzdGVtcyBkbyBub3QgbGlrZSBzeW1ib2wgJ34nIGluIFVSTCwgc28gIHdlIG5lZWQgdG8gcmVwbGFjZSB0byAgc29tZSBvdGhlciBzeW1ib2xzXHJcblx0XHR3cGJjX2F1dG9fZmlsbF92YWx1ZSA9IHdwYmNfYXV0b19maWxsX3ZhbHVlLnJlcGxhY2VBbGwoICdfXl8nLCAnficgKTtcclxuXHJcblx0XHR3cGJjX2F1dG9fZmlsbF9ib29raW5nX2ZpZWxkcyggd3BiY19hdXRvX2ZpbGxfdmFsdWUgKTtcclxuXHR9XHJcblxyXG59ICk7XHJcblxyXG5cclxuLyoqXHJcbiAqIEF1dG9maWxsIC8gc2VsZWN0IGJvb2tpbmcgZm9ybSAgZmllbGRzIGJ5ICB2YWx1ZXMgZnJvbSAgdGhlIEdFVCByZXF1ZXN0ICBwYXJhbWV0ZXI6ID93cGJjX2F1dG9fZmlsbD1cclxuICpcclxuICogQHBhcmFtIGF1dG9fZmlsbF9zdHJcclxuICovXHJcbmZ1bmN0aW9uIHdwYmNfYXV0b19maWxsX2Jvb2tpbmdfZmllbGRzKCBhdXRvX2ZpbGxfc3RyICl7XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQvL0ZpeEluOiAxMC4wLjAuNDhcclxuXHJcblx0aWYgKCAnJyA9PSBhdXRvX2ZpbGxfc3RyICl7XHJcblx0XHRyZXR1cm47XHJcblx0fVxyXG5cclxuLy8gY29uc29sZS5sb2coICdXUEJDX0FVVE9fRklMTF9CT09LSU5HX0ZJRUxEUyggQVVUT19GSUxMX1NUUiApJywgYXV0b19maWxsX3N0cik7XHJcblxyXG5cdHZhciBmaWVsZHNfYXJyID0gd3BiY19hdXRvX2ZpbGxfYm9va2luZ19maWVsZHNfX3BhcnNlKCBhdXRvX2ZpbGxfc3RyICk7XHJcblxyXG5cdGZvciAoIGxldCBpID0gMDsgaSA8IGZpZWxkc19hcnIubGVuZ3RoOyBpKysgKXtcclxuXHRcdGpRdWVyeSggJ1tuYW1lPVwiJyArIGZpZWxkc19hcnJbIGkgXVsgJ25hbWUnIF0gKyAnXCJdJyApLnZhbCggZmllbGRzX2FyclsgaSBdWyAndmFsdWUnIF0gKTtcclxuXHR9XHJcbn1cclxuXHJcblxyXG5cdC8qKlxyXG5cdCAqIFBhcnNlIGRhdGEgZnJvbSAgZ2V0IHBhcmFtZXRlcjpcdD93cGJjX2F1dG9fZmlsbD12aXNpdG9yczIzMV4yfm1heF9jYXBhY2l0eTIzMV4yXHJcblx0ICpcclxuXHQgKiBAcGFyYW0gZGF0YV9zdHIgICAgICA9ICAgJ3Zpc2l0b3JzMjMxXjJ+bWF4X2NhcGFjaXR5MjMxXjInO1xyXG5cdCAqIEByZXR1cm5zIHsqfVxyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfYXV0b19maWxsX2Jvb2tpbmdfZmllbGRzX19wYXJzZSggZGF0YV9zdHIgKXtcclxuXHJcblx0XHR2YXIgZmlsdGVyX29wdGlvbnNfYXJyID0gW107XHJcblxyXG5cdFx0dmFyIGRhdGFfYXJyID0gZGF0YV9zdHIuc3BsaXQoICd+JyApO1xyXG5cclxuXHRcdGZvciAoIHZhciBqID0gMDsgaiA8IGRhdGFfYXJyLmxlbmd0aDsgaisrICl7XHJcblxyXG5cdFx0XHR2YXIgbXlfZm9ybV9maWVsZCA9IGRhdGFfYXJyWyBqIF0uc3BsaXQoICdeJyApO1xyXG5cclxuXHRcdFx0dmFyIGZpbHRlcl9uYW1lICA9ICgndW5kZWZpbmVkJyAhPT0gdHlwZW9mIChteV9mb3JtX2ZpZWxkWyAwIF0pKSA/IG15X2Zvcm1fZmllbGRbIDAgXSA6ICcnO1xyXG5cdFx0XHR2YXIgZmlsdGVyX3ZhbHVlID0gKCd1bmRlZmluZWQnICE9PSB0eXBlb2YgKG15X2Zvcm1fZmllbGRbIDEgXSkpID8gbXlfZm9ybV9maWVsZFsgMSBdIDogJyc7XHJcblxyXG5cdFx0XHRmaWx0ZXJfb3B0aW9uc19hcnIucHVzaChcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHR7XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnbmFtZScgIDogZmlsdGVyX25hbWUsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHQndmFsdWUnIDogZmlsdGVyX3ZhbHVlXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0XHRcdFx0ICAgKTtcclxuXHRcdH1cclxuXHRcdHJldHVybiBmaWx0ZXJfb3B0aW9uc19hcnI7XHJcblx0fVxyXG5cclxuXHQvKipcclxuXHQgKiBQYXJzZSBkYXRhIGZyb20gIGdldCBwYXJhbWV0ZXI6XHQ/c2VhcmNoX2dldF9fY3VzdG9tX3BhcmFtcz0uLi5cclxuXHQgKlxyXG5cdCAqIEBwYXJhbSBkYXRhX3N0ciAgICAgID0gICAndGV4dF5zZWFyY2hfZmllbGRfX2Rpc3BsYXlfY2hlY2tfaW5eMjMuMDUuMjAyNH50ZXh0XnNlYXJjaF9maWVsZF9fZGlzcGxheV9jaGVja19vdXReMjYuMDUuMjAyNH5zZWxlY3Rib3gtb25lXnNlYXJjaF9xdWFudGl0eV4yfnNlbGVjdGJveC1vbmVebG9jYXRpb25eU3BhaW5+c2VsZWN0Ym94LW9uZV5tYXhfY2FwYWNpdHleMn5zZWxlY3Rib3gtb25lXmFtZW5pdHlecGFya2luZ35jaGVja2JveF5zZWFyY2hfZmllbGRfX2V4dGVuZF9zZWFyY2hfZGF5c141fnN1Ym1pdF5eU2VhcmNofmhpZGRlbl5zZWFyY2hfZ2V0X19jaGVja19pbl95bWReMjAyNC0wNS0yM35oaWRkZW5ec2VhcmNoX2dldF9fY2hlY2tfb3V0X3ltZF4yMDI0LTA1LTI2fmhpZGRlbl5zZWFyY2hfZ2V0X190aW1lXn5oaWRkZW5ec2VhcmNoX2dldF9fcXVhbnRpdHleMn5oaWRkZW5ec2VhcmNoX2dldF9fZXh0ZW5kXjV+aGlkZGVuXnNlYXJjaF9nZXRfX3VzZXJzX2lkXn5oaWRkZW5ec2VhcmNoX2dldF9fY3VzdG9tX3BhcmFtc15+JztcclxuXHQgKiBAcmV0dXJucyB7Kn1cclxuXHQgKi9cclxuXHRmdW5jdGlvbiB3cGJjX2F1dG9fZmlsbF9zZWFyY2hfZmllbGRzX19wYXJzZSggZGF0YV9zdHIgKXtcclxuXHJcblx0XHR2YXIgZmlsdGVyX29wdGlvbnNfYXJyID0gW107XHJcblxyXG5cdFx0dmFyIGRhdGFfYXJyID0gZGF0YV9zdHIuc3BsaXQoICd+JyApO1xyXG5cclxuXHRcdGZvciAoIHZhciBqID0gMDsgaiA8IGRhdGFfYXJyLmxlbmd0aDsgaisrICl7XHJcblxyXG5cdFx0XHR2YXIgbXlfZm9ybV9maWVsZCA9IGRhdGFfYXJyWyBqIF0uc3BsaXQoICdeJyApO1xyXG5cclxuXHRcdFx0dmFyIGZpbHRlcl90eXBlICA9ICgndW5kZWZpbmVkJyAhPT0gdHlwZW9mIChteV9mb3JtX2ZpZWxkWyAwIF0pKSA/IG15X2Zvcm1fZmllbGRbIDAgXSA6ICcnO1xyXG5cdFx0XHR2YXIgZmlsdGVyX25hbWUgID0gKCd1bmRlZmluZWQnICE9PSB0eXBlb2YgKG15X2Zvcm1fZmllbGRbIDEgXSkpID8gbXlfZm9ybV9maWVsZFsgMSBdIDogJyc7XHJcblx0XHRcdHZhciBmaWx0ZXJfdmFsdWUgPSAoJ3VuZGVmaW5lZCcgIT09IHR5cGVvZiAobXlfZm9ybV9maWVsZFsgMiBdKSkgPyBteV9mb3JtX2ZpZWxkWyAyIF0gOiAnJztcclxuXHJcblx0XHRcdGZpbHRlcl9vcHRpb25zX2Fyci5wdXNoKFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdHtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdCd0eXBlJyAgOiBmaWx0ZXJfdHlwZSxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdCduYW1lJyAgOiBmaWx0ZXJfbmFtZSxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdCd2YWx1ZScgOiBmaWx0ZXJfdmFsdWVcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHR9XHJcblx0XHRcdFx0XHRcdFx0XHQgICApO1xyXG5cdFx0fVxyXG5cdFx0cmV0dXJuIGZpbHRlcl9vcHRpb25zX2FycjtcclxuXHR9XHJcbiIsIi8qKlxyXG4gKiA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxyXG4gKlx0aW5jbHVkZXMvX19qcy9jYWwvZGF5c19zZWxlY3RfY3VzdG9tLmpzXHJcbiAqID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XHJcbiAqL1xyXG5cclxuLy9GaXhJbjogOS44LjkuMlxyXG5cclxuLyoqXHJcbiAqIFJlLUluaXQgQ2FsZW5kYXIgYW5kIFJlLVJlbmRlciBpdC5cclxuICpcclxuICogQHBhcmFtIHJlc291cmNlX2lkXHJcbiAqL1xyXG5mdW5jdGlvbiB3cGJjX2NhbF9fcmVfaW5pdCggcmVzb3VyY2VfaWQgKXtcclxuXHJcblx0Ly8gUmVtb3ZlIENMQVNTICBmb3IgYWJpbGl0eSB0byByZS1yZW5kZXIgYW5kIHJlaW5pdCBjYWxlbmRhci5cclxuXHRqUXVlcnkoICcjY2FsZW5kYXJfYm9va2luZycgKyByZXNvdXJjZV9pZCApLnJlbW92ZUNsYXNzKCAnaGFzRGF0ZXBpY2snICk7XHJcblx0d3BiY19jYWxlbmRhcl9zaG93KCByZXNvdXJjZV9pZCApO1xyXG59XHJcblxyXG5cclxuLyoqXHJcbiAqIFJlLUluaXQgcHJldmlvdXNseSAgc2F2ZWQgZGF5cyBzZWxlY3Rpb24gIHZhcmlhYmxlcy5cclxuICpcclxuICogQHBhcmFtIHJlc291cmNlX2lkXHJcbiAqL1xyXG5mdW5jdGlvbiB3cGJjX2NhbF9kYXlzX3NlbGVjdF9fcmVfaW5pdCggcmVzb3VyY2VfaWQgKXtcclxuXHJcblx0X3dwYmMuY2FsZW5kYXJfX3NldF9wYXJhbV92YWx1ZSggcmVzb3VyY2VfaWQsICdzYXZlZF92YXJpYWJsZV9fX2RheXNfc2VsZWN0X2luaXRpYWwnXHJcblx0XHQsIHtcclxuXHRcdFx0J2R5bmFtaWNfX2RheXNfbWluJyAgICAgICAgOiBfd3BiYy5jYWxlbmRhcl9fZ2V0X3BhcmFtX3ZhbHVlKCByZXNvdXJjZV9pZCwgJ2R5bmFtaWNfX2RheXNfbWluJyApLFxyXG5cdFx0XHQnZHluYW1pY19fZGF5c19tYXgnICAgICAgICA6IF93cGJjLmNhbGVuZGFyX19nZXRfcGFyYW1fdmFsdWUoIHJlc291cmNlX2lkLCAnZHluYW1pY19fZGF5c19tYXgnICksXHJcblx0XHRcdCdkeW5hbWljX19kYXlzX3NwZWNpZmljJyAgIDogX3dwYmMuY2FsZW5kYXJfX2dldF9wYXJhbV92YWx1ZSggcmVzb3VyY2VfaWQsICdkeW5hbWljX19kYXlzX3NwZWNpZmljJyApLFxyXG5cdFx0XHQnZHluYW1pY19fd2Vla19kYXlzX19zdGFydCc6IF93cGJjLmNhbGVuZGFyX19nZXRfcGFyYW1fdmFsdWUoIHJlc291cmNlX2lkLCAnZHluYW1pY19fd2Vla19kYXlzX19zdGFydCcgKSxcclxuXHRcdFx0J2ZpeGVkX19kYXlzX251bScgICAgICAgICAgOiBfd3BiYy5jYWxlbmRhcl9fZ2V0X3BhcmFtX3ZhbHVlKCByZXNvdXJjZV9pZCwgJ2ZpeGVkX19kYXlzX251bScgKSxcclxuXHRcdFx0J2ZpeGVkX193ZWVrX2RheXNfX3N0YXJ0JyAgOiBfd3BiYy5jYWxlbmRhcl9fZ2V0X3BhcmFtX3ZhbHVlKCByZXNvdXJjZV9pZCwgJ2ZpeGVkX193ZWVrX2RheXNfX3N0YXJ0JyApXHJcblx0XHR9XHJcblx0KTtcclxufVxyXG5cclxuLy8gLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblxyXG4vKipcclxuICogU2V0IFNpbmdsZSBEYXkgc2VsZWN0aW9uIC0gYWZ0ZXIgcGFnZSBsb2FkXHJcbiAqXHJcbiAqIEBwYXJhbSByZXNvdXJjZV9pZFx0XHRJRCBvZiBib29raW5nIHJlc291cmNlXHJcbiAqL1xyXG5mdW5jdGlvbiB3cGJjX2NhbF9yZWFkeV9kYXlzX3NlbGVjdF9fc2luZ2xlKCByZXNvdXJjZV9pZCApe1xyXG5cclxuXHQvLyBSZS1kZWZpbmUgc2VsZWN0aW9uLCBvbmx5IGFmdGVyIHBhZ2UgbG9hZGVkIHdpdGggYWxsIGluaXQgdmFyc1xyXG5cdGpRdWVyeShkb2N1bWVudCkucmVhZHkoZnVuY3Rpb24oKXtcclxuXHJcblx0XHQvLyBXYWl0IDEgc2Vjb25kLCBqdXN0IHRvICBiZSBzdXJlLCB0aGF0IGFsbCBpbml0IHZhcnMgZGVmaW5lZFxyXG5cdFx0c2V0VGltZW91dChmdW5jdGlvbigpe1xyXG5cclxuXHRcdFx0d3BiY19jYWxfZGF5c19zZWxlY3RfX3NpbmdsZSggcmVzb3VyY2VfaWQgKTtcclxuXHJcblx0XHR9LCAxMDAwKTtcclxuXHR9KTtcclxufVxyXG5cclxuLyoqXHJcbiAqIFNldCBTaW5nbGUgRGF5IHNlbGVjdGlvblxyXG4gKiBDYW4gYmUgcnVuIGF0IGFueSAgdGltZSwgIHdoZW4gIGNhbGVuZGFyIGRlZmluZWQgLSB1c2VmdWwgZm9yIGNvbnNvbGUgcnVuLlxyXG4gKlxyXG4gKiBAcGFyYW0gcmVzb3VyY2VfaWRcdFx0SUQgb2YgYm9va2luZyByZXNvdXJjZVxyXG4gKi9cclxuZnVuY3Rpb24gd3BiY19jYWxfZGF5c19zZWxlY3RfX3NpbmdsZSggcmVzb3VyY2VfaWQgKXtcclxuXHJcblx0X3dwYmMuY2FsZW5kYXJfX3NldF9wYXJhbWV0ZXJzKCByZXNvdXJjZV9pZCwgeydkYXlzX3NlbGVjdF9tb2RlJzogJ3NpbmdsZSd9ICk7XHJcblxyXG5cdHdwYmNfY2FsX2RheXNfc2VsZWN0X19yZV9pbml0KCByZXNvdXJjZV9pZCApO1xyXG5cdHdwYmNfY2FsX19yZV9pbml0KCByZXNvdXJjZV9pZCApO1xyXG59XHJcblxyXG4vLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHJcbi8qKlxyXG4gKiBTZXQgTXVsdGlwbGUgRGF5cyBzZWxlY3Rpb24gIC0gYWZ0ZXIgcGFnZSBsb2FkXHJcbiAqXHJcbiAqIEBwYXJhbSByZXNvdXJjZV9pZFx0XHRJRCBvZiBib29raW5nIHJlc291cmNlXHJcbiAqL1xyXG5mdW5jdGlvbiB3cGJjX2NhbF9yZWFkeV9kYXlzX3NlbGVjdF9fbXVsdGlwbGUoIHJlc291cmNlX2lkICl7XHJcblxyXG5cdC8vIFJlLWRlZmluZSBzZWxlY3Rpb24sIG9ubHkgYWZ0ZXIgcGFnZSBsb2FkZWQgd2l0aCBhbGwgaW5pdCB2YXJzXHJcblx0alF1ZXJ5KGRvY3VtZW50KS5yZWFkeShmdW5jdGlvbigpe1xyXG5cclxuXHRcdC8vIFdhaXQgMSBzZWNvbmQsIGp1c3QgdG8gIGJlIHN1cmUsIHRoYXQgYWxsIGluaXQgdmFycyBkZWZpbmVkXHJcblx0XHRzZXRUaW1lb3V0KGZ1bmN0aW9uKCl7XHJcblxyXG5cdFx0XHR3cGJjX2NhbF9kYXlzX3NlbGVjdF9fbXVsdGlwbGUoIHJlc291cmNlX2lkICk7XHJcblxyXG5cdFx0fSwgMTAwMCk7XHJcblx0fSk7XHJcbn1cclxuXHJcblxyXG4vKipcclxuICogU2V0IE11bHRpcGxlIERheXMgc2VsZWN0aW9uXHJcbiAqIENhbiBiZSBydW4gYXQgYW55ICB0aW1lLCAgd2hlbiAgY2FsZW5kYXIgZGVmaW5lZCAtIHVzZWZ1bCBmb3IgY29uc29sZSBydW4uXHJcbiAqXHJcbiAqIEBwYXJhbSByZXNvdXJjZV9pZFx0XHRJRCBvZiBib29raW5nIHJlc291cmNlXHJcbiAqL1xyXG5mdW5jdGlvbiB3cGJjX2NhbF9kYXlzX3NlbGVjdF9fbXVsdGlwbGUoIHJlc291cmNlX2lkICl7XHJcblxyXG5cdF93cGJjLmNhbGVuZGFyX19zZXRfcGFyYW1ldGVycyggcmVzb3VyY2VfaWQsIHsnZGF5c19zZWxlY3RfbW9kZSc6ICdtdWx0aXBsZSd9ICk7XHJcblxyXG5cdHdwYmNfY2FsX2RheXNfc2VsZWN0X19yZV9pbml0KCByZXNvdXJjZV9pZCApO1xyXG5cdHdwYmNfY2FsX19yZV9pbml0KCByZXNvdXJjZV9pZCApO1xyXG59XHJcblxyXG5cclxuLy8gLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblxyXG4vKipcclxuICogU2V0IEZpeGVkIERheXMgc2VsZWN0aW9uIHdpdGggIDEgbW91c2UgY2xpY2sgIC0gYWZ0ZXIgcGFnZSBsb2FkXHJcbiAqXHJcbiAqIEBpbnRlZ2VyIHJlc291cmNlX2lkXHRcdFx0LSAxXHRcdFx0XHQgICAtLSBJRCBvZiBib29raW5nIHJlc291cmNlIChjYWxlbmRhcikgLVxyXG4gKiBAaW50ZWdlciBkYXlzX251bWJlclx0XHRcdC0gM1x0XHRcdFx0ICAgLS0gbnVtYmVyIG9mIGRheXMgdG8gIHNlbGVjdFx0LVxyXG4gKiBAYXJyYXkgd2Vla19kYXlzX19zdGFydFx0LSBbLTFdIHwgWyAxLCA1XSAgIC0tICB7IC0xIC0gQW55IHwgMCAtIFN1LCAgMSAtIE1vLCAgMiAtIFR1LCAzIC0gV2UsIDQgLSBUaCwgNSAtIEZyLCA2IC0gU2F0IH1cclxuICovXHJcbmZ1bmN0aW9uIHdwYmNfY2FsX3JlYWR5X2RheXNfc2VsZWN0X19maXhlZCggcmVzb3VyY2VfaWQsIGRheXNfbnVtYmVyLCB3ZWVrX2RheXNfX3N0YXJ0ID0gWy0xXSApe1xyXG5cclxuXHQvLyBSZS1kZWZpbmUgc2VsZWN0aW9uLCBvbmx5IGFmdGVyIHBhZ2UgbG9hZGVkIHdpdGggYWxsIGluaXQgdmFyc1xyXG5cdGpRdWVyeShkb2N1bWVudCkucmVhZHkoZnVuY3Rpb24oKXtcclxuXHJcblx0XHQvLyBXYWl0IDEgc2Vjb25kLCBqdXN0IHRvICBiZSBzdXJlLCB0aGF0IGFsbCBpbml0IHZhcnMgZGVmaW5lZFxyXG5cdFx0c2V0VGltZW91dChmdW5jdGlvbigpe1xyXG5cclxuXHRcdFx0d3BiY19jYWxfZGF5c19zZWxlY3RfX2ZpeGVkKCByZXNvdXJjZV9pZCwgZGF5c19udW1iZXIsIHdlZWtfZGF5c19fc3RhcnQgKTtcclxuXHJcblx0XHR9LCAxMDAwKTtcclxuXHR9KTtcclxufVxyXG5cclxuXHJcbi8qKlxyXG4gKiBTZXQgRml4ZWQgRGF5cyBzZWxlY3Rpb24gd2l0aCAgMSBtb3VzZSBjbGlja1xyXG4gKiBDYW4gYmUgcnVuIGF0IGFueSAgdGltZSwgIHdoZW4gIGNhbGVuZGFyIGRlZmluZWQgLSB1c2VmdWwgZm9yIGNvbnNvbGUgcnVuLlxyXG4gKlxyXG4gKiBAaW50ZWdlciByZXNvdXJjZV9pZFx0XHRcdC0gMVx0XHRcdFx0ICAgLS0gSUQgb2YgYm9va2luZyByZXNvdXJjZSAoY2FsZW5kYXIpIC1cclxuICogQGludGVnZXIgZGF5c19udW1iZXJcdFx0XHQtIDNcdFx0XHRcdCAgIC0tIG51bWJlciBvZiBkYXlzIHRvICBzZWxlY3RcdC1cclxuICogQGFycmF5IHdlZWtfZGF5c19fc3RhcnRcdC0gWy0xXSB8IFsgMSwgNV0gICAtLSAgeyAtMSAtIEFueSB8IDAgLSBTdSwgIDEgLSBNbywgIDIgLSBUdSwgMyAtIFdlLCA0IC0gVGgsIDUgLSBGciwgNiAtIFNhdCB9XHJcbiAqL1xyXG5mdW5jdGlvbiB3cGJjX2NhbF9kYXlzX3NlbGVjdF9fZml4ZWQoIHJlc291cmNlX2lkLCBkYXlzX251bWJlciwgd2Vla19kYXlzX19zdGFydCA9IFstMV0gKXtcclxuXHJcblx0X3dwYmMuY2FsZW5kYXJfX3NldF9wYXJhbWV0ZXJzKCByZXNvdXJjZV9pZCwgeydkYXlzX3NlbGVjdF9tb2RlJzogJ2ZpeGVkJ30gKTtcclxuXHJcblx0X3dwYmMuY2FsZW5kYXJfX3NldF9wYXJhbWV0ZXJzKCByZXNvdXJjZV9pZCwgeydmaXhlZF9fZGF5c19udW0nOiBwYXJzZUludCggZGF5c19udW1iZXIgKX0gKTtcdFx0XHQvLyBOdW1iZXIgb2YgZGF5cyBzZWxlY3Rpb24gd2l0aCAxIG1vdXNlIGNsaWNrXHJcblx0X3dwYmMuY2FsZW5kYXJfX3NldF9wYXJhbWV0ZXJzKCByZXNvdXJjZV9pZCwgeydmaXhlZF9fd2Vla19kYXlzX19zdGFydCc6IHdlZWtfZGF5c19fc3RhcnR9ICk7IFx0Ly8geyAtMSAtIEFueSB8IDAgLSBTdSwgIDEgLSBNbywgIDIgLSBUdSwgMyAtIFdlLCA0IC0gVGgsIDUgLSBGciwgNiAtIFNhdCB9XHJcblxyXG5cdHdwYmNfY2FsX2RheXNfc2VsZWN0X19yZV9pbml0KCByZXNvdXJjZV9pZCApO1xyXG5cdHdwYmNfY2FsX19yZV9pbml0KCByZXNvdXJjZV9pZCApO1xyXG59XHJcblxyXG4vLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHJcbi8qKlxyXG4gKiBTZXQgUmFuZ2UgRGF5cyBzZWxlY3Rpb24gIHdpdGggIDIgbW91c2UgY2xpY2tzICAtIGFmdGVyIHBhZ2UgbG9hZFxyXG4gKlxyXG4gKiBAaW50ZWdlciByZXNvdXJjZV9pZFx0XHRcdC0gMVx0XHRcdFx0ICAgXHRcdC0tIElEIG9mIGJvb2tpbmcgcmVzb3VyY2UgKGNhbGVuZGFyKVxyXG4gKiBAaW50ZWdlciBkYXlzX21pblx0XHRcdC0gN1x0XHRcdFx0ICAgXHRcdC0tIE1pbiBudW1iZXIgb2YgZGF5cyB0byBzZWxlY3RcclxuICogQGludGVnZXIgZGF5c19tYXhcdFx0XHQtIDMwXHRcdFx0ICAgXHRcdC0tIE1heCBudW1iZXIgb2YgZGF5cyB0byBzZWxlY3RcclxuICogQGFycmF5IGRheXNfc3BlY2lmaWNcdFx0XHQtIFtdIHwgWzcsMTQsMjEsMjhdXHRcdC0tIFJlc3RyaWN0aW9uIGZvciBTcGVjaWZpYyBudW1iZXIgb2YgZGF5cyBzZWxlY3Rpb25cclxuICogQGFycmF5IHdlZWtfZGF5c19fc3RhcnRcdFx0LSBbLTFdIHwgWyAxLCA1XSAgIFx0XHQtLSAgeyAtMSAtIEFueSB8IDAgLSBTdSwgIDEgLSBNbywgIDIgLSBUdSwgMyAtIFdlLCA0IC0gVGgsIDUgLSBGciwgNiAtIFNhdCB9XHJcbiAqL1xyXG5mdW5jdGlvbiB3cGJjX2NhbF9yZWFkeV9kYXlzX3NlbGVjdF9fcmFuZ2UoIHJlc291cmNlX2lkLCBkYXlzX21pbiwgZGF5c19tYXgsIGRheXNfc3BlY2lmaWMgPSBbXSwgd2Vla19kYXlzX19zdGFydCA9IFstMV0gKXtcclxuXHJcblx0Ly8gUmUtZGVmaW5lIHNlbGVjdGlvbiwgb25seSBhZnRlciBwYWdlIGxvYWRlZCB3aXRoIGFsbCBpbml0IHZhcnNcclxuXHRqUXVlcnkoZG9jdW1lbnQpLnJlYWR5KGZ1bmN0aW9uKCl7XHJcblxyXG5cdFx0Ly8gV2FpdCAxIHNlY29uZCwganVzdCB0byAgYmUgc3VyZSwgdGhhdCBhbGwgaW5pdCB2YXJzIGRlZmluZWRcclxuXHRcdHNldFRpbWVvdXQoZnVuY3Rpb24oKXtcclxuXHJcblx0XHRcdHdwYmNfY2FsX2RheXNfc2VsZWN0X19yYW5nZSggcmVzb3VyY2VfaWQsIGRheXNfbWluLCBkYXlzX21heCwgZGF5c19zcGVjaWZpYywgd2Vla19kYXlzX19zdGFydCApO1xyXG5cdFx0fSwgMTAwMCk7XHJcblx0fSk7XHJcbn1cclxuXHJcbi8qKlxyXG4gKiBTZXQgUmFuZ2UgRGF5cyBzZWxlY3Rpb24gIHdpdGggIDIgbW91c2UgY2xpY2tzXHJcbiAqIENhbiBiZSBydW4gYXQgYW55ICB0aW1lLCAgd2hlbiAgY2FsZW5kYXIgZGVmaW5lZCAtIHVzZWZ1bCBmb3IgY29uc29sZSBydW4uXHJcbiAqXHJcbiAqIEBpbnRlZ2VyIHJlc291cmNlX2lkXHRcdFx0LSAxXHRcdFx0XHQgICBcdFx0LS0gSUQgb2YgYm9va2luZyByZXNvdXJjZSAoY2FsZW5kYXIpXHJcbiAqIEBpbnRlZ2VyIGRheXNfbWluXHRcdFx0LSA3XHRcdFx0XHQgICBcdFx0LS0gTWluIG51bWJlciBvZiBkYXlzIHRvIHNlbGVjdFxyXG4gKiBAaW50ZWdlciBkYXlzX21heFx0XHRcdC0gMzBcdFx0XHQgICBcdFx0LS0gTWF4IG51bWJlciBvZiBkYXlzIHRvIHNlbGVjdFxyXG4gKiBAYXJyYXkgZGF5c19zcGVjaWZpY1x0XHRcdC0gW10gfCBbNywxNCwyMSwyOF1cdFx0LS0gUmVzdHJpY3Rpb24gZm9yIFNwZWNpZmljIG51bWJlciBvZiBkYXlzIHNlbGVjdGlvblxyXG4gKiBAYXJyYXkgd2Vla19kYXlzX19zdGFydFx0XHQtIFstMV0gfCBbIDEsIDVdICAgXHRcdC0tICB7IC0xIC0gQW55IHwgMCAtIFN1LCAgMSAtIE1vLCAgMiAtIFR1LCAzIC0gV2UsIDQgLSBUaCwgNSAtIEZyLCA2IC0gU2F0IH1cclxuICovXHJcbmZ1bmN0aW9uIHdwYmNfY2FsX2RheXNfc2VsZWN0X19yYW5nZSggcmVzb3VyY2VfaWQsIGRheXNfbWluLCBkYXlzX21heCwgZGF5c19zcGVjaWZpYyA9IFtdLCB3ZWVrX2RheXNfX3N0YXJ0ID0gWy0xXSApe1xyXG5cclxuXHRfd3BiYy5jYWxlbmRhcl9fc2V0X3BhcmFtZXRlcnMoICByZXNvdXJjZV9pZCwgeydkYXlzX3NlbGVjdF9tb2RlJzogJ2R5bmFtaWMnfSAgKTtcclxuXHRfd3BiYy5jYWxlbmRhcl9fc2V0X3BhcmFtX3ZhbHVlKCByZXNvdXJjZV9pZCwgJ2R5bmFtaWNfX2RheXNfbWluJyAgICAgICAgICwgcGFyc2VJbnQoIGRheXNfbWluICkgICk7ICAgICAgICAgICBcdFx0Ly8gTWluLiBOdW1iZXIgb2YgZGF5cyBzZWxlY3Rpb24gd2l0aCAyIG1vdXNlIGNsaWNrc1xyXG5cdF93cGJjLmNhbGVuZGFyX19zZXRfcGFyYW1fdmFsdWUoIHJlc291cmNlX2lkLCAnZHluYW1pY19fZGF5c19tYXgnICAgICAgICAgLCBwYXJzZUludCggZGF5c19tYXggKSAgKTsgICAgICAgICAgXHRcdC8vIE1heC4gTnVtYmVyIG9mIGRheXMgc2VsZWN0aW9uIHdpdGggMiBtb3VzZSBjbGlja3NcclxuXHRfd3BiYy5jYWxlbmRhcl9fc2V0X3BhcmFtX3ZhbHVlKCByZXNvdXJjZV9pZCwgJ2R5bmFtaWNfX2RheXNfc3BlY2lmaWMnICAgICwgZGF5c19zcGVjaWZpYyAgKTtcdCAgICAgIFx0XHRcdFx0Ly8gRXhhbXBsZSBbNSw3XVxyXG5cdF93cGJjLmNhbGVuZGFyX19zZXRfcGFyYW1fdmFsdWUoIHJlc291cmNlX2lkLCAnZHluYW1pY19fd2Vla19kYXlzX19zdGFydCcgLCB3ZWVrX2RheXNfX3N0YXJ0ICApOyAgXHRcdFx0XHRcdC8vIHsgLTEgLSBBbnkgfCAwIC0gU3UsICAxIC0gTW8sICAyIC0gVHUsIDMgLSBXZSwgNCAtIFRoLCA1IC0gRnIsIDYgLSBTYXQgfVxyXG5cclxuXHR3cGJjX2NhbF9kYXlzX3NlbGVjdF9fcmVfaW5pdCggcmVzb3VyY2VfaWQgKTtcclxuXHR3cGJjX2NhbF9fcmVfaW5pdCggcmVzb3VyY2VfaWQgKTtcclxufVxyXG4iLCIvKipcclxuICogPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cclxuICpcdGluY2x1ZGVzL19fanMvY2FsX2FqeF9sb2FkL3dwYmNfY2FsX2FqeC5qc1xyXG4gKiA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxyXG4gKi9cclxuXHJcbi8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG4vLyAgQSBqIGEgeCAgICBMIG8gYSBkICAgIEMgYSBsIGUgbiBkIGEgciAgICBEIGEgdCBhXHJcbi8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cclxuZnVuY3Rpb24gd3BiY19jYWxlbmRhcl9fbG9hZF9kYXRhX19hangoIHBhcmFtcyApe1xyXG5cclxuXHQvL0ZpeEluOiA5LjguNi4yXHJcblx0d3BiY19jYWxlbmRhcl9fbG9hZGluZ19fc3RhcnQoIHBhcmFtc1sncmVzb3VyY2VfaWQnXSApO1xyXG5cdGlmICggd3BiY19iYWxhbmNlcl9faXNfd2FpdCggcGFyYW1zICwgJ3dwYmNfY2FsZW5kYXJfX2xvYWRfZGF0YV9fYWp4JyApICl7XHJcblx0XHRyZXR1cm4gZmFsc2U7XHJcblx0fVxyXG5cclxuXHQvL0ZpeEluOiA5LjguNi4yXHJcblx0d3BiY19jYWxlbmRhcl9fYmx1cl9fc3RvcCggcGFyYW1zWydyZXNvdXJjZV9pZCddICk7XHJcblxyXG5cclxuLy8gY29uc29sZS5ncm91cEVuZCgpOyBjb25zb2xlLnRpbWUoJ3Jlc291cmNlX2lkXycgKyBwYXJhbXNbJ3Jlc291cmNlX2lkJ10pO1xyXG5jb25zb2xlLmdyb3VwQ29sbGFwc2VkKCAnV1BCQ19BSlhfQ0FMRU5EQVJfTE9BRCcgKTsgY29uc29sZS5sb2coICcgPT0gQmVmb3JlIEFqYXggU2VuZCAtIGNhbGVuZGFyc19hbGxfX2dldCgpID09ICcgLCBfd3BiYy5jYWxlbmRhcnNfYWxsX19nZXQoKSApO1xyXG5cclxuXHQvLyBTdGFydCBBamF4XHJcblx0alF1ZXJ5LnBvc3QoIHdwYmNfdXJsX2FqYXgsXHJcblx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0YWN0aW9uICAgICAgICAgIDogJ1dQQkNfQUpYX0NBTEVOREFSX0xPQUQnLFxyXG5cdFx0XHRcdFx0d3BiY19hanhfdXNlcl9pZDogX3dwYmMuZ2V0X3NlY3VyZV9wYXJhbSggJ3VzZXJfaWQnICksXHJcblx0XHRcdFx0XHRub25jZSAgICAgICAgICAgOiBfd3BiYy5nZXRfc2VjdXJlX3BhcmFtKCAnbm9uY2UnICksXHJcblx0XHRcdFx0XHR3cGJjX2FqeF9sb2NhbGUgOiBfd3BiYy5nZXRfc2VjdXJlX3BhcmFtKCAnbG9jYWxlJyApLFxyXG5cclxuXHRcdFx0XHRcdGNhbGVuZGFyX3JlcXVlc3RfcGFyYW1zIDogcGFyYW1zIFx0XHRcdFx0XHRcdC8vIFVzdWFsbHkgbGlrZTogeyAncmVzb3VyY2VfaWQnOiAxLCAnbWF4X2RheXNfY291bnQnOiAzNjUgfVxyXG5cdFx0XHRcdH0sXHJcblxyXG5cdFx0XHRcdC8qKlxyXG5cdFx0XHRcdCAqIFMgdSBjIGMgZSBzIHNcclxuXHRcdFx0XHQgKlxyXG5cdFx0XHRcdCAqIEBwYXJhbSByZXNwb25zZV9kYXRhXHRcdC1cdGl0cyBvYmplY3QgcmV0dXJuZWQgZnJvbSAgQWpheCAtIGNsYXNzLWxpdmUtc2VhcmNoLnBocFxyXG5cdFx0XHRcdCAqIEBwYXJhbSB0ZXh0U3RhdHVzXHRcdC1cdCdzdWNjZXNzJ1xyXG5cdFx0XHRcdCAqIEBwYXJhbSBqcVhIUlx0XHRcdFx0LVx0T2JqZWN0XHJcblx0XHRcdFx0ICovXHJcblx0XHRcdFx0ZnVuY3Rpb24gKCByZXNwb25zZV9kYXRhLCB0ZXh0U3RhdHVzLCBqcVhIUiApIHtcclxuLy8gY29uc29sZS50aW1lRW5kKCdyZXNvdXJjZV9pZF8nICsgcmVzcG9uc2VfZGF0YVsncmVzb3VyY2VfaWQnXSk7XHJcbmNvbnNvbGUubG9nKCAnID09IFJlc3BvbnNlIFdQQkNfQUpYX0NBTEVOREFSX0xPQUQgPT0gJywgcmVzcG9uc2VfZGF0YSApOyBjb25zb2xlLmdyb3VwRW5kKCk7XHJcblxyXG5cdFx0XHRcdFx0Ly9GaXhJbjogOS44LjYuMlxyXG5cdFx0XHRcdFx0dmFyIGFqeF9wb3N0X2RhdGFfX3Jlc291cmNlX2lkID0gd3BiY19nZXRfcmVzb3VyY2VfaWRfX2Zyb21fYWp4X3Bvc3RfZGF0YV91cmwoIHRoaXMuZGF0YSApO1xyXG5cdFx0XHRcdFx0d3BiY19iYWxhbmNlcl9fY29tcGxldGVkKCBhanhfcG9zdF9kYXRhX19yZXNvdXJjZV9pZCAsICd3cGJjX2NhbGVuZGFyX19sb2FkX2RhdGFfX2FqeCcgKTtcclxuXHJcblx0XHRcdFx0XHQvLyBQcm9iYWJseSBFcnJvclxyXG5cdFx0XHRcdFx0aWYgKCAodHlwZW9mIHJlc3BvbnNlX2RhdGEgIT09ICdvYmplY3QnKSB8fCAocmVzcG9uc2VfZGF0YSA9PT0gbnVsbCkgKXtcclxuXHJcblx0XHRcdFx0XHRcdHZhciBqcV9ub2RlICA9IHdwYmNfZ2V0X2NhbGVuZGFyX19qcV9ub2RlX19mb3JfbWVzc2FnZXMoIHRoaXMuZGF0YSApO1xyXG5cdFx0XHRcdFx0XHR2YXIgbWVzc2FnZV90eXBlID0gJ2luZm8nO1xyXG5cclxuXHRcdFx0XHRcdFx0aWYgKCAnJyA9PT0gcmVzcG9uc2VfZGF0YSApe1xyXG5cdFx0XHRcdFx0XHRcdHJlc3BvbnNlX2RhdGEgPSAnVGhlIHNlcnZlciByZXNwb25kcyB3aXRoIGFuIGVtcHR5IHN0cmluZy4gVGhlIHNlcnZlciBwcm9iYWJseSBzdG9wcGVkIHdvcmtpbmcgdW5leHBlY3RlZGx5LiA8YnI+UGxlYXNlIGNoZWNrIHlvdXIgPHN0cm9uZz5lcnJvci5sb2c8L3N0cm9uZz4gaW4geW91ciBzZXJ2ZXIgY29uZmlndXJhdGlvbiBmb3IgcmVsYXRpdmUgZXJyb3JzLic7XHJcblx0XHRcdFx0XHRcdFx0bWVzc2FnZV90eXBlID0gJ3dhcm5pbmcnO1xyXG5cdFx0XHRcdFx0XHR9XHJcblxyXG5cdFx0XHRcdFx0XHQvLyBTaG93IE1lc3NhZ2VcclxuXHRcdFx0XHRcdFx0d3BiY19mcm9udF9lbmRfX3Nob3dfbWVzc2FnZSggcmVzcG9uc2VfZGF0YSAsIHsgJ3R5cGUnICAgICA6IG1lc3NhZ2VfdHlwZSxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J3Nob3dfaGVyZSc6IHsnanFfbm9kZSc6IGpxX25vZGUsICd3aGVyZSc6ICdhZnRlcid9LFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnaXNfYXBwZW5kJzogdHJ1ZSxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J3N0eWxlJyAgICA6ICd0ZXh0LWFsaWduOmxlZnQ7JyxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J2RlbGF5JyAgICA6IDBcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdH0gKTtcclxuXHRcdFx0XHRcdFx0cmV0dXJuO1xyXG5cdFx0XHRcdFx0fVxyXG5cclxuXHRcdFx0XHRcdC8vIFNob3cgQ2FsZW5kYXJcclxuXHRcdFx0XHRcdHdwYmNfY2FsZW5kYXJfX2xvYWRpbmdfX3N0b3AoIHJlc3BvbnNlX2RhdGFbICdyZXNvdXJjZV9pZCcgXSApO1xyXG5cclxuXHRcdFx0XHRcdC8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHRcdFx0XHRcdC8vIEJvb2tpbmdzIC0gRGF0ZXNcclxuXHRcdFx0XHRcdF93cGJjLmJvb2tpbmdzX2luX2NhbGVuZGFyX19zZXRfZGF0ZXMoICByZXNwb25zZV9kYXRhWyAncmVzb3VyY2VfaWQnIF0sIHJlc3BvbnNlX2RhdGFbICdhanhfZGF0YScgXVsnZGF0ZXMnXSAgKTtcclxuXHJcblx0XHRcdFx0XHQvLyBCb29raW5ncyAtIENoaWxkIG9yIG9ubHkgc2luZ2xlIGJvb2tpbmcgcmVzb3VyY2UgaW4gZGF0ZXNcclxuXHRcdFx0XHRcdF93cGJjLmJvb2tpbmdfX3NldF9wYXJhbV92YWx1ZSggcmVzcG9uc2VfZGF0YVsgJ3Jlc291cmNlX2lkJyBdLCAncmVzb3VyY2VzX2lkX2Fycl9faW5fZGF0ZXMnLCByZXNwb25zZV9kYXRhWyAnYWp4X2RhdGEnIF1bICdyZXNvdXJjZXNfaWRfYXJyX19pbl9kYXRlcycgXSApO1xyXG5cclxuXHRcdFx0XHRcdC8vIEFnZ3JlZ2F0ZSBib29raW5nIHJlc291cmNlcywgIGlmIGFueSA/XHJcblx0XHRcdFx0XHRfd3BiYy5ib29raW5nX19zZXRfcGFyYW1fdmFsdWUoIHJlc3BvbnNlX2RhdGFbICdyZXNvdXJjZV9pZCcgXSwgJ2FnZ3JlZ2F0ZV9yZXNvdXJjZV9pZF9hcnInLCByZXNwb25zZV9kYXRhWyAnYWp4X2RhdGEnIF1bICdhZ2dyZWdhdGVfcmVzb3VyY2VfaWRfYXJyJyBdICk7XHJcblx0XHRcdFx0XHQvLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblxyXG5cdFx0XHRcdFx0Ly8gVXBkYXRlIGNhbGVuZGFyXHJcblx0XHRcdFx0XHR3cGJjX2NhbGVuZGFyX191cGRhdGVfbG9vayggcmVzcG9uc2VfZGF0YVsgJ3Jlc291cmNlX2lkJyBdICk7XHJcblxyXG5cclxuXHRcdFx0XHRcdGlmIChcclxuXHRcdFx0XHRcdFx0XHQoICd1bmRlZmluZWQnICE9PSB0eXBlb2YgKHJlc3BvbnNlX2RhdGFbICdhanhfZGF0YScgXVsgJ2FqeF9hZnRlcl9hY3Rpb25fbWVzc2FnZScgXSkgKVxyXG5cdFx0XHRcdFx0XHQgJiYgKCAnJyAhPSByZXNwb25zZV9kYXRhWyAnYWp4X2RhdGEnIF1bICdhanhfYWZ0ZXJfYWN0aW9uX21lc3NhZ2UnIF0ucmVwbGFjZSggL1xcbi9nLCBcIjxiciAvPlwiICkgKVxyXG5cdFx0XHRcdFx0KXtcclxuXHJcblx0XHRcdFx0XHRcdHZhciBqcV9ub2RlICA9IHdwYmNfZ2V0X2NhbGVuZGFyX19qcV9ub2RlX19mb3JfbWVzc2FnZXMoIHRoaXMuZGF0YSApO1xyXG5cclxuXHRcdFx0XHRcdFx0Ly8gU2hvdyBNZXNzYWdlXHJcblx0XHRcdFx0XHRcdHdwYmNfZnJvbnRfZW5kX19zaG93X21lc3NhZ2UoIHJlc3BvbnNlX2RhdGFbICdhanhfZGF0YScgXVsgJ2FqeF9hZnRlcl9hY3Rpb25fbWVzc2FnZScgXS5yZXBsYWNlKCAvXFxuL2csIFwiPGJyIC8+XCIgKSxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdHsgICAndHlwZScgICAgIDogKCAndW5kZWZpbmVkJyAhPT0gdHlwZW9mKCByZXNwb25zZV9kYXRhWyAnYWp4X2RhdGEnIF1bICdhanhfYWZ0ZXJfYWN0aW9uX21lc3NhZ2Vfc3RhdHVzJyBdICkgKVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQgID8gcmVzcG9uc2VfZGF0YVsgJ2FqeF9kYXRhJyBdWyAnYWp4X2FmdGVyX2FjdGlvbl9tZXNzYWdlX3N0YXR1cycgXSA6ICdpbmZvJyxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J3Nob3dfaGVyZSc6IHsnanFfbm9kZSc6IGpxX25vZGUsICd3aGVyZSc6ICdhZnRlcid9LFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnaXNfYXBwZW5kJzogdHJ1ZSxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J3N0eWxlJyAgICA6ICd0ZXh0LWFsaWduOmxlZnQ7JyxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J2RlbGF5JyAgICA6IDEwMDAwXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHR9ICk7XHJcblx0XHRcdFx0XHR9XHJcblxyXG5cdFx0XHRcdFx0Ly8gVHJpZ2dlciBldmVudCB0aGF0IGNhbGVuZGFyIGhhcyBiZWVuXHRcdCAvL0ZpeEluOiAxMC4wLjAuNDRcclxuXHRcdFx0XHRcdGlmICggalF1ZXJ5KCAnI2NhbGVuZGFyX2Jvb2tpbmcnICsgcmVzcG9uc2VfZGF0YVsgJ3Jlc291cmNlX2lkJyBdICkubGVuZ3RoID4gMCApe1xyXG5cdFx0XHRcdFx0XHR2YXIgdGFyZ2V0X2VsbSA9IGpRdWVyeSggJ2JvZHknICkudHJpZ2dlciggXCJ3cGJjX2NhbGVuZGFyX2FqeF9fbG9hZGVkX2RhdGFcIiwgW3Jlc3BvbnNlX2RhdGFbICdyZXNvdXJjZV9pZCcgXV0gKTtcclxuXHRcdFx0XHRcdFx0IC8valF1ZXJ5KCAnYm9keScgKS5vbiggJ3dwYmNfY2FsZW5kYXJfYWp4X19sb2FkZWRfZGF0YScsIGZ1bmN0aW9uKCBldmVudCwgcmVzb3VyY2VfaWQgKSB7IC4uLiB9ICk7XHJcblx0XHRcdFx0XHR9XHJcblxyXG5cdFx0XHRcdFx0Ly9qUXVlcnkoICcjYWpheF9yZXNwb25kJyApLmh0bWwoIHJlc3BvbnNlX2RhdGEgKTtcdFx0Ly8gRm9yIGFiaWxpdHkgdG8gc2hvdyByZXNwb25zZSwgYWRkIHN1Y2ggRElWIGVsZW1lbnQgdG8gcGFnZVxyXG5cdFx0XHRcdH1cclxuXHRcdFx0ICApLmZhaWwoIGZ1bmN0aW9uICgganFYSFIsIHRleHRTdGF0dXMsIGVycm9yVGhyb3duICkgeyAgICBpZiAoIHdpbmRvdy5jb25zb2xlICYmIHdpbmRvdy5jb25zb2xlLmxvZyApeyBjb25zb2xlLmxvZyggJ0FqYXhfRXJyb3InLCBqcVhIUiwgdGV4dFN0YXR1cywgZXJyb3JUaHJvd24gKTsgfVxyXG5cclxuXHRcdFx0XHRcdHZhciBhanhfcG9zdF9kYXRhX19yZXNvdXJjZV9pZCA9IHdwYmNfZ2V0X3Jlc291cmNlX2lkX19mcm9tX2FqeF9wb3N0X2RhdGFfdXJsKCB0aGlzLmRhdGEgKTtcclxuXHRcdFx0XHRcdHdwYmNfYmFsYW5jZXJfX2NvbXBsZXRlZCggYWp4X3Bvc3RfZGF0YV9fcmVzb3VyY2VfaWQgLCAnd3BiY19jYWxlbmRhcl9fbG9hZF9kYXRhX19hangnICk7XHJcblxyXG5cdFx0XHRcdFx0Ly8gR2V0IENvbnRlbnQgb2YgRXJyb3IgTWVzc2FnZVxyXG5cdFx0XHRcdFx0dmFyIGVycm9yX21lc3NhZ2UgPSAnPHN0cm9uZz4nICsgJ0Vycm9yIScgKyAnPC9zdHJvbmc+ICcgKyBlcnJvclRocm93biA7XHJcblx0XHRcdFx0XHRpZiAoIGpxWEhSLnN0YXR1cyApe1xyXG5cdFx0XHRcdFx0XHRlcnJvcl9tZXNzYWdlICs9ICcgKDxiPicgKyBqcVhIUi5zdGF0dXMgKyAnPC9iPiknO1xyXG5cdFx0XHRcdFx0XHRpZiAoNDAzID09IGpxWEhSLnN0YXR1cyApe1xyXG5cdFx0XHRcdFx0XHRcdGVycm9yX21lc3NhZ2UgKz0gJzxicj4gUHJvYmFibHkgbm9uY2UgZm9yIHRoaXMgcGFnZSBoYXMgYmVlbiBleHBpcmVkLiBQbGVhc2UgPGEgaHJlZj1cImphdmFzY3JpcHQ6dm9pZCgwKVwiIG9uY2xpY2s9XCJqYXZhc2NyaXB0OmxvY2F0aW9uLnJlbG9hZCgpO1wiPnJlbG9hZCB0aGUgcGFnZTwvYT4uJztcclxuXHRcdFx0XHRcdFx0XHRlcnJvcl9tZXNzYWdlICs9ICc8YnI+IE90aGVyd2lzZSwgcGxlYXNlIGNoZWNrIHRoaXMgPGEgc3R5bGU9XCJmb250LXdlaWdodDogNjAwO1wiIGhyZWY9XCJodHRwczovL3dwYm9va2luZ2NhbGVuZGFyLmNvbS9mYXEvcmVxdWVzdC1kby1ub3QtcGFzcy1zZWN1cml0eS1jaGVjay9cIj50cm91Ymxlc2hvb3RpbmcgaW5zdHJ1Y3Rpb248L2E+Ljxicj4nXHJcblx0XHRcdFx0XHRcdH1cclxuXHRcdFx0XHRcdH1cclxuXHRcdFx0XHRcdHZhciBtZXNzYWdlX3Nob3dfZGVsYXkgPSAzMDAwO1xyXG5cdFx0XHRcdFx0aWYgKCBqcVhIUi5yZXNwb25zZVRleHQgKXtcclxuXHRcdFx0XHRcdFx0ZXJyb3JfbWVzc2FnZSArPSAnICcgKyBqcVhIUi5yZXNwb25zZVRleHQ7XHJcblx0XHRcdFx0XHRcdG1lc3NhZ2Vfc2hvd19kZWxheSA9IDEwO1xyXG5cdFx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0ZXJyb3JfbWVzc2FnZSA9IGVycm9yX21lc3NhZ2UucmVwbGFjZSggL1xcbi9nLCBcIjxiciAvPlwiICk7XHJcblxyXG5cdFx0XHRcdFx0dmFyIGpxX25vZGUgID0gd3BiY19nZXRfY2FsZW5kYXJfX2pxX25vZGVfX2Zvcl9tZXNzYWdlcyggdGhpcy5kYXRhICk7XHJcblxyXG5cdFx0XHRcdFx0LyoqXHJcblx0XHRcdFx0XHQgKiBJZiB3ZSBtYWtlIGZhc3QgY2xpY2tpbmcgb24gZGlmZmVyZW50IHBhZ2VzLFxyXG5cdFx0XHRcdFx0ICogdGhlbiB1bmRlciBjYWxlbmRhciB3aWxsIHNob3cgZXJyb3IgbWVzc2FnZSB3aXRoICBlbXB0eSAgdGV4dCwgYmVjYXVzZSBhamF4IHdhcyBub3QgcmVjZWl2ZWQuXHJcblx0XHRcdFx0XHQgKiBUbyAgbm90IHNob3cgc3VjaCB3YXJuaW5ncyB3ZSBhcmUgc2V0IGRlbGF5ICBpbiAzIHNlY29uZHMuICB2YXIgbWVzc2FnZV9zaG93X2RlbGF5ID0gMzAwMDtcclxuXHRcdFx0XHRcdCAqL1xyXG5cdFx0XHRcdFx0dmFyIGNsb3NlZF90aW1lciA9IHNldFRpbWVvdXQoIGZ1bmN0aW9uICgpe1xyXG5cclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQvLyBTaG93IE1lc3NhZ2VcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHR3cGJjX2Zyb250X2VuZF9fc2hvd19tZXNzYWdlKCBlcnJvcl9tZXNzYWdlICwgeyAndHlwZScgICAgIDogJ2Vycm9yJyxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnc2hvd19oZXJlJzogeydqcV9ub2RlJzoganFfbm9kZSwgJ3doZXJlJzogJ2FmdGVyJ30sXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J2lzX2FwcGVuZCc6IHRydWUsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J3N0eWxlJyAgICA6ICd0ZXh0LWFsaWduOmxlZnQ7JyxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnY3NzX2NsYXNzJzond3BiY19mZV9tZXNzYWdlX2FsdCcsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J2RlbGF5JyAgICA6IDBcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0fSApO1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0ICAgfSAsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQgICBwYXJzZUludCggbWVzc2FnZV9zaG93X2RlbGF5ICkgICApO1xyXG5cclxuXHRcdFx0ICB9KVxyXG5cdCAgICAgICAgICAvLyAuZG9uZSggICBmdW5jdGlvbiAoIGRhdGEsIHRleHRTdGF0dXMsIGpxWEhSICkgeyAgIGlmICggd2luZG93LmNvbnNvbGUgJiYgd2luZG93LmNvbnNvbGUubG9nICl7IGNvbnNvbGUubG9nKCAnc2Vjb25kIHN1Y2Nlc3MnLCBkYXRhLCB0ZXh0U3RhdHVzLCBqcVhIUiApOyB9ICAgIH0pXHJcblx0XHRcdCAgLy8gLmFsd2F5cyggZnVuY3Rpb24gKCBkYXRhX2pxWEhSLCB0ZXh0U3RhdHVzLCBqcVhIUl9lcnJvclRocm93biApIHsgICBpZiAoIHdpbmRvdy5jb25zb2xlICYmIHdpbmRvdy5jb25zb2xlLmxvZyApeyBjb25zb2xlLmxvZyggJ2Fsd2F5cyBmaW5pc2hlZCcsIGRhdGFfanFYSFIsIHRleHRTdGF0dXMsIGpxWEhSX2Vycm9yVGhyb3duICk7IH0gICAgIH0pXHJcblx0XHRcdCAgOyAgLy8gRW5kIEFqYXhcclxufVxyXG5cclxuXHJcblxyXG4vLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuLy8gU3VwcG9ydFxyXG4vLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHJcblx0LyoqXHJcblx0ICogR2V0IENhbGVuZGFyIGpRdWVyeSBub2RlIGZvciBzaG93aW5nIG1lc3NhZ2VzIGR1cmluZyBBamF4XHJcblx0ICogVGhpcyBwYXJhbWV0ZXI6ICAgY2FsZW5kYXJfcmVxdWVzdF9wYXJhbXNbcmVzb3VyY2VfaWRdICAgcGFyc2VkIGZyb20gdGhpcy5kYXRhIEFqYXggcG9zdCAgZGF0YVxyXG5cdCAqXHJcblx0ICogQHBhcmFtIGFqeF9wb3N0X2RhdGFfdXJsX3BhcmFtc1x0XHQgJ2FjdGlvbj1XUEJDX0FKWF9DQUxFTkRBUl9MT0FELi4uJmNhbGVuZGFyX3JlcXVlc3RfcGFyYW1zJTVCcmVzb3VyY2VfaWQlNUQ9MiZjYWxlbmRhcl9yZXF1ZXN0X3BhcmFtcyU1QmJvb2tpbmdfaGFzaCU1RD0mY2FsZW5kYXJfcmVxdWVzdF9wYXJhbXMnXHJcblx0ICogQHJldHVybnMge3N0cmluZ31cdCcnI2NhbGVuZGFyX2Jvb2tpbmcxJyAgfCAgICcuYm9va2luZ19mb3JtX2RpdicgLi4uXHJcblx0ICpcclxuXHQgKiBFeGFtcGxlICAgIHZhciBqcV9ub2RlICA9IHdwYmNfZ2V0X2NhbGVuZGFyX19qcV9ub2RlX19mb3JfbWVzc2FnZXMoIHRoaXMuZGF0YSApO1xyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfZ2V0X2NhbGVuZGFyX19qcV9ub2RlX19mb3JfbWVzc2FnZXMoIGFqeF9wb3N0X2RhdGFfdXJsX3BhcmFtcyApe1xyXG5cclxuXHRcdHZhciBqcV9ub2RlID0gJy5ib29raW5nX2Zvcm1fZGl2JztcclxuXHJcblx0XHR2YXIgY2FsZW5kYXJfcmVzb3VyY2VfaWQgPSB3cGJjX2dldF9yZXNvdXJjZV9pZF9fZnJvbV9hanhfcG9zdF9kYXRhX3VybCggYWp4X3Bvc3RfZGF0YV91cmxfcGFyYW1zICk7XHJcblxyXG5cdFx0aWYgKCBjYWxlbmRhcl9yZXNvdXJjZV9pZCA+IDAgKXtcclxuXHRcdFx0anFfbm9kZSA9ICcjY2FsZW5kYXJfYm9va2luZycgKyBjYWxlbmRhcl9yZXNvdXJjZV9pZDtcclxuXHRcdH1cclxuXHJcblx0XHRyZXR1cm4ganFfbm9kZTtcclxuXHR9XHJcblxyXG5cclxuXHQvKipcclxuXHQgKiBHZXQgcmVzb3VyY2UgSUQgZnJvbSBhanggcG9zdCBkYXRhIHVybCAgIHVzdWFsbHkgIGZyb20gIHRoaXMuZGF0YSAgPSAnYWN0aW9uPVdQQkNfQUpYX0NBTEVOREFSX0xPQUQuLi4mY2FsZW5kYXJfcmVxdWVzdF9wYXJhbXMlNUJyZXNvdXJjZV9pZCU1RD0yJmNhbGVuZGFyX3JlcXVlc3RfcGFyYW1zJTVCYm9va2luZ19oYXNoJTVEPSZjYWxlbmRhcl9yZXF1ZXN0X3BhcmFtcydcclxuXHQgKlxyXG5cdCAqIEBwYXJhbSBhanhfcG9zdF9kYXRhX3VybF9wYXJhbXNcdFx0ICdhY3Rpb249V1BCQ19BSlhfQ0FMRU5EQVJfTE9BRC4uLiZjYWxlbmRhcl9yZXF1ZXN0X3BhcmFtcyU1QnJlc291cmNlX2lkJTVEPTImY2FsZW5kYXJfcmVxdWVzdF9wYXJhbXMlNUJib29raW5nX2hhc2glNUQ9JmNhbGVuZGFyX3JlcXVlc3RfcGFyYW1zJ1xyXG5cdCAqIEByZXR1cm5zIHtpbnR9XHRcdFx0XHRcdFx0IDEgfCAwICAoaWYgZXJycm9yIHRoZW4gIDApXHJcblx0ICpcclxuXHQgKiBFeGFtcGxlICAgIHZhciBqcV9ub2RlICA9IHdwYmNfZ2V0X2NhbGVuZGFyX19qcV9ub2RlX19mb3JfbWVzc2FnZXMoIHRoaXMuZGF0YSApO1xyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfZ2V0X3Jlc291cmNlX2lkX19mcm9tX2FqeF9wb3N0X2RhdGFfdXJsKCBhanhfcG9zdF9kYXRhX3VybF9wYXJhbXMgKXtcclxuXHJcblx0XHQvLyBHZXQgYm9va2luZyByZXNvdXJjZSBJRCBmcm9tIEFqYXggUG9zdCBSZXF1ZXN0ICAtPiB0aGlzLmRhdGEgPSAnYWN0aW9uPVdQQkNfQUpYX0NBTEVOREFSX0xPQUQuLi4mY2FsZW5kYXJfcmVxdWVzdF9wYXJhbXMlNUJyZXNvdXJjZV9pZCU1RD0yJmNhbGVuZGFyX3JlcXVlc3RfcGFyYW1zJTVCYm9va2luZ19oYXNoJTVEPSZjYWxlbmRhcl9yZXF1ZXN0X3BhcmFtcydcclxuXHRcdHZhciBjYWxlbmRhcl9yZXNvdXJjZV9pZCA9IHdwYmNfZ2V0X3VyaV9wYXJhbV9ieV9uYW1lKCAnY2FsZW5kYXJfcmVxdWVzdF9wYXJhbXNbcmVzb3VyY2VfaWRdJywgYWp4X3Bvc3RfZGF0YV91cmxfcGFyYW1zICk7XHJcblx0XHRpZiAoIChudWxsICE9PSBjYWxlbmRhcl9yZXNvdXJjZV9pZCkgJiYgKCcnICE9PSBjYWxlbmRhcl9yZXNvdXJjZV9pZCkgKXtcclxuXHRcdFx0Y2FsZW5kYXJfcmVzb3VyY2VfaWQgPSBwYXJzZUludCggY2FsZW5kYXJfcmVzb3VyY2VfaWQgKTtcclxuXHRcdFx0aWYgKCBjYWxlbmRhcl9yZXNvdXJjZV9pZCA+IDAgKXtcclxuXHRcdFx0XHRyZXR1cm4gY2FsZW5kYXJfcmVzb3VyY2VfaWQ7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHRcdHJldHVybiAwO1xyXG5cdH1cclxuXHJcblxyXG5cdC8qKlxyXG5cdCAqIEdldCBwYXJhbWV0ZXIgZnJvbSBVUkwgIC0gIHBhcnNlIFVSTCBwYXJhbWV0ZXJzLCAgbGlrZSB0aGlzOiBhY3Rpb249V1BCQ19BSlhfQ0FMRU5EQVJfTE9BRC4uLiZjYWxlbmRhcl9yZXF1ZXN0X3BhcmFtcyU1QnJlc291cmNlX2lkJTVEPTImY2FsZW5kYXJfcmVxdWVzdF9wYXJhbXMlNUJib29raW5nX2hhc2glNUQ9JmNhbGVuZGFyX3JlcXVlc3RfcGFyYW1zXHJcblx0ICogQHBhcmFtIG5hbWUgIHBhcmFtZXRlciAgbmFtZSwgIGxpa2UgJ2NhbGVuZGFyX3JlcXVlc3RfcGFyYW1zW3Jlc291cmNlX2lkXSdcclxuXHQgKiBAcGFyYW0gdXJsXHQncGFyYW1ldGVyICBzdHJpbmcgVVJMJ1xyXG5cdCAqIEByZXR1cm5zIHtzdHJpbmd8bnVsbH0gICBwYXJhbWV0ZXIgdmFsdWVcclxuXHQgKlxyXG5cdCAqIEV4YW1wbGU6IFx0XHR3cGJjX2dldF91cmlfcGFyYW1fYnlfbmFtZSggJ2NhbGVuZGFyX3JlcXVlc3RfcGFyYW1zW3Jlc291cmNlX2lkXScsIHRoaXMuZGF0YSApOyAgLT4gJzInXHJcblx0ICovXHJcblx0ZnVuY3Rpb24gd3BiY19nZXRfdXJpX3BhcmFtX2J5X25hbWUoIG5hbWUsIHVybCApe1xyXG5cclxuXHRcdHVybCA9IGRlY29kZVVSSUNvbXBvbmVudCggdXJsICk7XHJcblxyXG5cdFx0bmFtZSA9IG5hbWUucmVwbGFjZSggL1tcXFtcXF1dL2csICdcXFxcJCYnICk7XHJcblx0XHR2YXIgcmVnZXggPSBuZXcgUmVnRXhwKCAnWz8mXScgKyBuYW1lICsgJyg9KFteJiNdKil8JnwjfCQpJyApLFxyXG5cdFx0XHRyZXN1bHRzID0gcmVnZXguZXhlYyggdXJsICk7XHJcblx0XHRpZiAoICFyZXN1bHRzICkgcmV0dXJuIG51bGw7XHJcblx0XHRpZiAoICFyZXN1bHRzWyAyIF0gKSByZXR1cm4gJyc7XHJcblx0XHRyZXR1cm4gZGVjb2RlVVJJQ29tcG9uZW50KCByZXN1bHRzWyAyIF0ucmVwbGFjZSggL1xcKy9nLCAnICcgKSApO1xyXG5cdH1cclxuIiwiLyoqXHJcbiAqID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxyXG4gKlx0aW5jbHVkZXMvX19qcy9mcm9udF9lbmRfbWVzc2FnZXMvd3BiY19mZV9tZXNzYWdlcy5qc1xyXG4gKiA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cclxuICovXHJcblxyXG4vLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuLy8gU2hvdyBNZXNzYWdlcyBhdCBGcm9udC1FZG4gc2lkZVxyXG4vLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHJcbi8qKlxyXG4gKiBTaG93IG1lc3NhZ2UgaW4gY29udGVudFxyXG4gKlxyXG4gKiBAcGFyYW0gbWVzc2FnZVx0XHRcdFx0TWVzc2FnZSBIVE1MXHJcbiAqIEBwYXJhbSBwYXJhbXMgPSB7XHJcbiAqXHRcdFx0XHRcdFx0XHRcdCd0eXBlJyAgICAgOiAnd2FybmluZycsXHRcdFx0XHRcdFx0XHQvLyAnZXJyb3InIHwgJ3dhcm5pbmcnIHwgJ2luZm8nIHwgJ3N1Y2Nlc3MnXHJcbiAqXHRcdFx0XHRcdFx0XHRcdCdzaG93X2hlcmUnIDoge1xyXG4gKlx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J2pxX25vZGUnIDogJycsXHRcdFx0XHQvLyBhbnkgalF1ZXJ5IG5vZGUgZGVmaW5pdGlvblxyXG4gKlx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J3doZXJlJyAgIDogJ2luc2lkZSdcdFx0Ly8gJ2luc2lkZScgfCAnYmVmb3JlJyB8ICdhZnRlcicgfCAncmlnaHQnIHwgJ2xlZnQnXHJcbiAqXHRcdFx0XHRcdFx0XHRcdFx0XHRcdCAgfSxcclxuICpcdFx0XHRcdFx0XHRcdFx0J2lzX2FwcGVuZCc6IHRydWUsXHRcdFx0XHRcdFx0XHRcdC8vIEFwcGx5ICBvbmx5IGlmIFx0J3doZXJlJyAgIDogJ2luc2lkZSdcclxuICpcdFx0XHRcdFx0XHRcdFx0J3N0eWxlJyAgICA6ICd0ZXh0LWFsaWduOmxlZnQ7JyxcdFx0XHRcdC8vIHN0eWxlcywgaWYgbmVlZGVkXHJcbiAqXHRcdFx0XHRcdFx0XHQgICAgJ2Nzc19jbGFzcyc6ICcnLFx0XHRcdFx0XHRcdFx0XHQvLyBGb3IgZXhhbXBsZSBjYW4gIGJlOiAnd3BiY19mZV9tZXNzYWdlX2FsdCdcclxuICpcdFx0XHRcdFx0XHRcdFx0J2RlbGF5JyAgICA6IDAsXHRcdFx0XHRcdFx0XHRcdFx0Ly8gaG93IG1hbnkgbWljcm9zZWNvbmQgdG8gIHNob3csICBpZiAwICB0aGVuICBzaG93IGZvcmV2ZXJcclxuICpcdFx0XHRcdFx0XHRcdFx0J2lmX3Zpc2libGVfbm90X3Nob3cnOiBmYWxzZVx0XHRcdFx0XHQvLyBpZiB0cnVlLCAgdGhlbiBkbyBub3Qgc2hvdyBtZXNzYWdlLCAgaWYgcHJldmlvcyBtZXNzYWdlIHdhcyBub3QgaGlkZWQgKG5vdCBhcHBseSBpZiAnd2hlcmUnICAgOiAnaW5zaWRlJyApXHJcbiAqXHRcdFx0XHR9O1xyXG4gKiBFeGFtcGxlczpcclxuICogXHRcdFx0dmFyIGh0bWxfaWQgPSB3cGJjX2Zyb250X2VuZF9fc2hvd19tZXNzYWdlKCAnWW91IGNhbiB0ZXN0IGRheXMgc2VsZWN0aW9uIGluIGNhbGVuZGFyJywge30gKTtcclxuICpcclxuICpcdFx0XHR2YXIgbm90aWNlX21lc3NhZ2VfaWQgPSB3cGJjX2Zyb250X2VuZF9fc2hvd19tZXNzYWdlKCBfd3BiYy5nZXRfbWVzc2FnZSggJ21lc3NhZ2VfY2hlY2tfcmVxdWlyZWQnICksIHsgJ3R5cGUnOiAnd2FybmluZycsICdkZWxheSc6IDEwMDAwLCAnaWZfdmlzaWJsZV9ub3Rfc2hvdyc6IHRydWUsXHJcbiAqXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQgICdzaG93X2hlcmUnOiB7J3doZXJlJzogJ3JpZ2h0JywgJ2pxX25vZGUnOiBlbCx9IH0gKTtcclxuICpcclxuICpcdFx0XHR3cGJjX2Zyb250X2VuZF9fc2hvd19tZXNzYWdlKCByZXNwb25zZV9kYXRhWyAnYWp4X2RhdGEnIF1bICdhanhfYWZ0ZXJfYWN0aW9uX21lc3NhZ2UnIF0ucmVwbGFjZSggL1xcbi9nLCBcIjxiciAvPlwiICksXHJcbiAqXHRcdFx0XHRcdFx0XHRcdFx0XHRcdHsgICAndHlwZScgICAgIDogKCAndW5kZWZpbmVkJyAhPT0gdHlwZW9mKCByZXNwb25zZV9kYXRhWyAnYWp4X2RhdGEnIF1bICdhanhfYWZ0ZXJfYWN0aW9uX21lc3NhZ2Vfc3RhdHVzJyBdICkgKVxyXG4gKlx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCAgPyByZXNwb25zZV9kYXRhWyAnYWp4X2RhdGEnIF1bICdhanhfYWZ0ZXJfYWN0aW9uX21lc3NhZ2Vfc3RhdHVzJyBdIDogJ2luZm8nLFxyXG4gKlx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCdzaG93X2hlcmUnOiB7J2pxX25vZGUnOiBqcV9ub2RlLCAnd2hlcmUnOiAnYWZ0ZXInfSxcclxuICpcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnY3NzX2NsYXNzJzond3BiY19mZV9tZXNzYWdlX2FsdCcsXHJcbiAqXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J2RlbGF5JyAgICA6IDEwMDAwXHJcbiAqXHRcdFx0XHRcdFx0XHRcdFx0XHRcdH0gKTtcclxuICpcclxuICpcclxuICogQHJldHVybnMgc3RyaW5nICAtIEhUTUwgSURcdFx0b3IgMCBpZiBub3Qgc2hvd2luZyBkdXJpbmcgdGhpcyB0aW1lLlxyXG4gKi9cclxuZnVuY3Rpb24gd3BiY19mcm9udF9lbmRfX3Nob3dfbWVzc2FnZSggbWVzc2FnZSwgcGFyYW1zID0ge30gKXtcclxuXHJcblx0dmFyIHBhcmFtc19kZWZhdWx0ID0ge1xyXG5cdFx0XHRcdFx0XHRcdFx0J3R5cGUnICAgICA6ICd3YXJuaW5nJyxcdFx0XHRcdFx0XHRcdC8vICdlcnJvcicgfCAnd2FybmluZycgfCAnaW5mbycgfCAnc3VjY2VzcydcclxuXHRcdFx0XHRcdFx0XHRcdCdzaG93X2hlcmUnIDoge1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCdqcV9ub2RlJyA6ICcnLFx0XHRcdFx0Ly8gYW55IGpRdWVyeSBub2RlIGRlZmluaXRpb25cclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnd2hlcmUnICAgOiAnaW5zaWRlJ1x0XHQvLyAnaW5zaWRlJyB8ICdiZWZvcmUnIHwgJ2FmdGVyJyB8ICdyaWdodCcgfCAnbGVmdCdcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdCAgfSxcclxuXHRcdFx0XHRcdFx0XHRcdCdpc19hcHBlbmQnOiB0cnVlLFx0XHRcdFx0XHRcdFx0XHQvLyBBcHBseSAgb25seSBpZiBcdCd3aGVyZScgICA6ICdpbnNpZGUnXHJcblx0XHRcdFx0XHRcdFx0XHQnc3R5bGUnICAgIDogJ3RleHQtYWxpZ246bGVmdDsnLFx0XHRcdFx0Ly8gc3R5bGVzLCBpZiBuZWVkZWRcclxuXHRcdFx0XHRcdFx0XHQgICAgJ2Nzc19jbGFzcyc6ICcnLFx0XHRcdFx0XHRcdFx0XHQvLyBGb3IgZXhhbXBsZSBjYW4gIGJlOiAnd3BiY19mZV9tZXNzYWdlX2FsdCdcclxuXHRcdFx0XHRcdFx0XHRcdCdkZWxheScgICAgOiAwLFx0XHRcdFx0XHRcdFx0XHRcdC8vIGhvdyBtYW55IG1pY3Jvc2Vjb25kIHRvICBzaG93LCAgaWYgMCAgdGhlbiAgc2hvdyBmb3JldmVyXHJcblx0XHRcdFx0XHRcdFx0XHQnaWZfdmlzaWJsZV9ub3Rfc2hvdyc6IGZhbHNlLFx0XHRcdFx0XHQvLyBpZiB0cnVlLCAgdGhlbiBkbyBub3Qgc2hvdyBtZXNzYWdlLCAgaWYgcHJldmlvcyBtZXNzYWdlIHdhcyBub3QgaGlkZWQgKG5vdCBhcHBseSBpZiAnd2hlcmUnICAgOiAnaW5zaWRlJyApXHJcblx0XHRcdFx0XHRcdFx0XHQnaXNfc2Nyb2xsJzogdHJ1ZVx0XHRcdFx0XHRcdFx0XHQvLyBpcyBzY3JvbGwgIHRvICB0aGlzIGVsZW1lbnRcclxuXHRcdFx0XHRcdFx0fTtcclxuXHRmb3IgKCB2YXIgcF9rZXkgaW4gcGFyYW1zICl7XHJcblx0XHRwYXJhbXNfZGVmYXVsdFsgcF9rZXkgXSA9IHBhcmFtc1sgcF9rZXkgXTtcclxuXHR9XHJcblx0cGFyYW1zID0gcGFyYW1zX2RlZmF1bHQ7XHJcblxyXG4gICAgdmFyIHVuaXF1ZV9kaXZfaWQgPSBuZXcgRGF0ZSgpO1xyXG4gICAgdW5pcXVlX2Rpdl9pZCA9ICd3cGJjX25vdGljZV8nICsgdW5pcXVlX2Rpdl9pZC5nZXRUaW1lKCk7XHJcblxyXG5cdHBhcmFtc1snY3NzX2NsYXNzJ10gKz0gJyB3cGJjX2ZlX21lc3NhZ2UnO1xyXG5cdGlmICggcGFyYW1zWyd0eXBlJ10gPT0gJ2Vycm9yJyApe1xyXG5cdFx0cGFyYW1zWydjc3NfY2xhc3MnXSArPSAnIHdwYmNfZmVfbWVzc2FnZV9lcnJvcic7XHJcblx0XHRtZXNzYWdlID0gJzxpIGNsYXNzPVwibWVudV9pY29uIGljb24tMXggd3BiY19pY25fcmVwb3J0X2dtYWlsZXJyb3JyZWRcIj48L2k+JyArIG1lc3NhZ2U7XHJcblx0fVxyXG5cdGlmICggcGFyYW1zWyd0eXBlJ10gPT0gJ3dhcm5pbmcnICl7XHJcblx0XHRwYXJhbXNbJ2Nzc19jbGFzcyddICs9ICcgd3BiY19mZV9tZXNzYWdlX3dhcm5pbmcnO1xyXG5cdFx0bWVzc2FnZSA9ICc8aSBjbGFzcz1cIm1lbnVfaWNvbiBpY29uLTF4IHdwYmNfaWNuX3dhcm5pbmdcIj48L2k+JyArIG1lc3NhZ2U7XHJcblx0fVxyXG5cdGlmICggcGFyYW1zWyd0eXBlJ10gPT0gJ2luZm8nICl7XHJcblx0XHRwYXJhbXNbJ2Nzc19jbGFzcyddICs9ICcgd3BiY19mZV9tZXNzYWdlX2luZm8nO1xyXG5cdH1cclxuXHRpZiAoIHBhcmFtc1sndHlwZSddID09ICdzdWNjZXNzJyApe1xyXG5cdFx0cGFyYW1zWydjc3NfY2xhc3MnXSArPSAnIHdwYmNfZmVfbWVzc2FnZV9zdWNjZXNzJztcclxuXHRcdG1lc3NhZ2UgPSAnPGkgY2xhc3M9XCJtZW51X2ljb24gaWNvbi0xeCB3cGJjX2ljbl9kb25lX291dGxpbmVcIj48L2k+JyArIG1lc3NhZ2U7XHJcblx0fVxyXG5cclxuXHR2YXIgc2Nyb2xsX3RvX2VsZW1lbnQgPSAnPGRpdiBpZD1cIicgKyB1bmlxdWVfZGl2X2lkICsgJ19zY3JvbGxcIiBzdHlsZT1cImRpc3BsYXk6bm9uZTtcIj48L2Rpdj4nO1xyXG5cdG1lc3NhZ2UgPSAnPGRpdiBpZD1cIicgKyB1bmlxdWVfZGl2X2lkICsgJ1wiIGNsYXNzPVwid3BiY19mcm9udF9lbmRfX21lc3NhZ2UgJyArIHBhcmFtc1snY3NzX2NsYXNzJ10gKyAnXCIgc3R5bGU9XCInICsgcGFyYW1zWyAnc3R5bGUnIF0gKyAnXCI+JyArIG1lc3NhZ2UgKyAnPC9kaXY+JztcclxuXHJcblxyXG5cdHZhciBqcV9lbF9tZXNzYWdlID0gZmFsc2U7XHJcblx0dmFyIGlzX3Nob3dfbWVzc2FnZSA9IHRydWU7XHJcblxyXG5cdGlmICggJ2luc2lkZScgPT09IHBhcmFtc1sgJ3Nob3dfaGVyZScgXVsgJ3doZXJlJyBdICl7XHJcblxyXG5cdFx0aWYgKCBwYXJhbXNbICdpc19hcHBlbmQnIF0gKXtcclxuXHRcdFx0alF1ZXJ5KCBwYXJhbXNbICdzaG93X2hlcmUnIF1bICdqcV9ub2RlJyBdICkuYXBwZW5kKCBzY3JvbGxfdG9fZWxlbWVudCApO1xyXG5cdFx0XHRqUXVlcnkoIHBhcmFtc1sgJ3Nob3dfaGVyZScgXVsgJ2pxX25vZGUnIF0gKS5hcHBlbmQoIG1lc3NhZ2UgKTtcclxuXHRcdH0gZWxzZSB7XHJcblx0XHRcdGpRdWVyeSggcGFyYW1zWyAnc2hvd19oZXJlJyBdWyAnanFfbm9kZScgXSApLmh0bWwoIHNjcm9sbF90b19lbGVtZW50ICsgbWVzc2FnZSApO1xyXG5cdFx0fVxyXG5cclxuXHR9IGVsc2UgaWYgKCAnYmVmb3JlJyA9PT0gcGFyYW1zWyAnc2hvd19oZXJlJyBdWyAnd2hlcmUnIF0gKXtcclxuXHJcblx0XHRqcV9lbF9tZXNzYWdlID0galF1ZXJ5KCBwYXJhbXNbICdzaG93X2hlcmUnIF1bICdqcV9ub2RlJyBdICkuc2libGluZ3MoICdbaWRePVwid3BiY19ub3RpY2VfXCJdJyApO1xyXG5cdFx0aWYgKCAocGFyYW1zWyAnaWZfdmlzaWJsZV9ub3Rfc2hvdycgXSkgJiYgKGpxX2VsX21lc3NhZ2UuaXMoICc6dmlzaWJsZScgKSkgKXtcclxuXHRcdFx0aXNfc2hvd19tZXNzYWdlID0gZmFsc2U7XHJcblx0XHRcdHVuaXF1ZV9kaXZfaWQgPSBqUXVlcnkoIGpxX2VsX21lc3NhZ2UuZ2V0KCAwICkgKS5hdHRyKCAnaWQnICk7XHJcblx0XHR9XHJcblx0XHRpZiAoIGlzX3Nob3dfbWVzc2FnZSApe1xyXG5cdFx0XHRqUXVlcnkoIHBhcmFtc1sgJ3Nob3dfaGVyZScgXVsgJ2pxX25vZGUnIF0gKS5iZWZvcmUoIHNjcm9sbF90b19lbGVtZW50ICk7XHJcblx0XHRcdGpRdWVyeSggcGFyYW1zWyAnc2hvd19oZXJlJyBdWyAnanFfbm9kZScgXSApLmJlZm9yZSggbWVzc2FnZSApO1xyXG5cdFx0fVxyXG5cclxuXHR9IGVsc2UgaWYgKCAnYWZ0ZXInID09PSBwYXJhbXNbICdzaG93X2hlcmUnIF1bICd3aGVyZScgXSApe1xyXG5cclxuXHRcdGpxX2VsX21lc3NhZ2UgPSBqUXVlcnkoIHBhcmFtc1sgJ3Nob3dfaGVyZScgXVsgJ2pxX25vZGUnIF0gKS5uZXh0QWxsKCAnW2lkXj1cIndwYmNfbm90aWNlX1wiXScgKTtcclxuXHRcdGlmICggKHBhcmFtc1sgJ2lmX3Zpc2libGVfbm90X3Nob3cnIF0pICYmIChqcV9lbF9tZXNzYWdlLmlzKCAnOnZpc2libGUnICkpICl7XHJcblx0XHRcdGlzX3Nob3dfbWVzc2FnZSA9IGZhbHNlO1xyXG5cdFx0XHR1bmlxdWVfZGl2X2lkID0galF1ZXJ5KCBqcV9lbF9tZXNzYWdlLmdldCggMCApICkuYXR0ciggJ2lkJyApO1xyXG5cdFx0fVxyXG5cdFx0aWYgKCBpc19zaG93X21lc3NhZ2UgKXtcclxuXHRcdFx0alF1ZXJ5KCBwYXJhbXNbICdzaG93X2hlcmUnIF1bICdqcV9ub2RlJyBdICkuYmVmb3JlKCBzY3JvbGxfdG9fZWxlbWVudCApO1x0XHQvLyBXZSBuZWVkIHRvICBzZXQgIGhlcmUgYmVmb3JlKGZvciBoYW5keSBzY3JvbGwpXHJcblx0XHRcdGpRdWVyeSggcGFyYW1zWyAnc2hvd19oZXJlJyBdWyAnanFfbm9kZScgXSApLmFmdGVyKCBtZXNzYWdlICk7XHJcblx0XHR9XHJcblxyXG5cdH0gZWxzZSBpZiAoICdyaWdodCcgPT09IHBhcmFtc1sgJ3Nob3dfaGVyZScgXVsgJ3doZXJlJyBdICl7XHJcblxyXG5cdFx0anFfZWxfbWVzc2FnZSA9IGpRdWVyeSggcGFyYW1zWyAnc2hvd19oZXJlJyBdWyAnanFfbm9kZScgXSApLm5leHRBbGwoICcud3BiY19mcm9udF9lbmRfX21lc3NhZ2VfY29udGFpbmVyX3JpZ2h0JyApLmZpbmQoICdbaWRePVwid3BiY19ub3RpY2VfXCJdJyApO1xyXG5cdFx0aWYgKCAocGFyYW1zWyAnaWZfdmlzaWJsZV9ub3Rfc2hvdycgXSkgJiYgKGpxX2VsX21lc3NhZ2UuaXMoICc6dmlzaWJsZScgKSkgKXtcclxuXHRcdFx0aXNfc2hvd19tZXNzYWdlID0gZmFsc2U7XHJcblx0XHRcdHVuaXF1ZV9kaXZfaWQgPSBqUXVlcnkoIGpxX2VsX21lc3NhZ2UuZ2V0KCAwICkgKS5hdHRyKCAnaWQnICk7XHJcblx0XHR9XHJcblx0XHRpZiAoIGlzX3Nob3dfbWVzc2FnZSApe1xyXG5cdFx0XHRqUXVlcnkoIHBhcmFtc1sgJ3Nob3dfaGVyZScgXVsgJ2pxX25vZGUnIF0gKS5iZWZvcmUoIHNjcm9sbF90b19lbGVtZW50ICk7XHRcdC8vIFdlIG5lZWQgdG8gIHNldCAgaGVyZSBiZWZvcmUoZm9yIGhhbmR5IHNjcm9sbClcclxuXHRcdFx0alF1ZXJ5KCBwYXJhbXNbICdzaG93X2hlcmUnIF1bICdqcV9ub2RlJyBdICkuYWZ0ZXIoICc8ZGl2IGNsYXNzPVwid3BiY19mcm9udF9lbmRfX21lc3NhZ2VfY29udGFpbmVyX3JpZ2h0XCI+JyArIG1lc3NhZ2UgKyAnPC9kaXY+JyApO1xyXG5cdFx0fVxyXG5cdH0gZWxzZSBpZiAoICdsZWZ0JyA9PT0gcGFyYW1zWyAnc2hvd19oZXJlJyBdWyAnd2hlcmUnIF0gKXtcclxuXHJcblx0XHRqcV9lbF9tZXNzYWdlID0galF1ZXJ5KCBwYXJhbXNbICdzaG93X2hlcmUnIF1bICdqcV9ub2RlJyBdICkuc2libGluZ3MoICcud3BiY19mcm9udF9lbmRfX21lc3NhZ2VfY29udGFpbmVyX2xlZnQnICkuZmluZCggJ1tpZF49XCJ3cGJjX25vdGljZV9cIl0nICk7XHJcblx0XHRpZiAoIChwYXJhbXNbICdpZl92aXNpYmxlX25vdF9zaG93JyBdKSAmJiAoanFfZWxfbWVzc2FnZS5pcyggJzp2aXNpYmxlJyApKSApe1xyXG5cdFx0XHRpc19zaG93X21lc3NhZ2UgPSBmYWxzZTtcclxuXHRcdFx0dW5pcXVlX2Rpdl9pZCA9IGpRdWVyeSgganFfZWxfbWVzc2FnZS5nZXQoIDAgKSApLmF0dHIoICdpZCcgKTtcclxuXHRcdH1cclxuXHRcdGlmICggaXNfc2hvd19tZXNzYWdlICl7XHJcblx0XHRcdGpRdWVyeSggcGFyYW1zWyAnc2hvd19oZXJlJyBdWyAnanFfbm9kZScgXSApLmJlZm9yZSggc2Nyb2xsX3RvX2VsZW1lbnQgKTtcdFx0Ly8gV2UgbmVlZCB0byAgc2V0ICBoZXJlIGJlZm9yZShmb3IgaGFuZHkgc2Nyb2xsKVxyXG5cdFx0XHRqUXVlcnkoIHBhcmFtc1sgJ3Nob3dfaGVyZScgXVsgJ2pxX25vZGUnIF0gKS5iZWZvcmUoICc8ZGl2IGNsYXNzPVwid3BiY19mcm9udF9lbmRfX21lc3NhZ2VfY29udGFpbmVyX2xlZnRcIj4nICsgbWVzc2FnZSArICc8L2Rpdj4nICk7XHJcblx0XHR9XHJcblx0fVxyXG5cclxuXHRpZiAoICAgKCBpc19zaG93X21lc3NhZ2UgKSAgJiYgICggcGFyc2VJbnQoIHBhcmFtc1sgJ2RlbGF5JyBdICkgPiAwICkgICApe1xyXG5cdFx0dmFyIGNsb3NlZF90aW1lciA9IHNldFRpbWVvdXQoIGZ1bmN0aW9uICgpe1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdGpRdWVyeSggJyMnICsgdW5pcXVlX2Rpdl9pZCApLmZhZGVPdXQoIDE1MDAgKTtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHR9ICwgcGFyc2VJbnQoIHBhcmFtc1sgJ2RlbGF5JyBdICkgICApO1xyXG5cclxuXHRcdHZhciBjbG9zZWRfdGltZXIyID0gc2V0VGltZW91dCggZnVuY3Rpb24gKCl7XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRqUXVlcnkoICcjJyArIHVuaXF1ZV9kaXZfaWQgKS50cmlnZ2VyKCAnaGlkZScgKTtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHR9LCAoIHBhcnNlSW50KCBwYXJhbXNbICdkZWxheScgXSApICsgMTUwMSApICk7XHJcblx0fVxyXG5cclxuXHQvLyBDaGVjayAgaWYgc2hvd2VkIG1lc3NhZ2UgaW4gc29tZSBoaWRkZW4gcGFyZW50IHNlY3Rpb24gYW5kIHNob3cgaXQuIEJ1dCBpdCBtdXN0ICBiZSBsb3dlciB0aGFuICcud3BiY19jb250YWluZXInXHJcblx0dmFyIHBhcmVudF9lbHMgPSBqUXVlcnkoICcjJyArIHVuaXF1ZV9kaXZfaWQgKS5wYXJlbnRzKCkubWFwKCBmdW5jdGlvbiAoKXtcclxuXHRcdGlmICggKCFqUXVlcnkoIHRoaXMgKS5pcyggJ3Zpc2libGUnICkpICYmIChqUXVlcnkoICcud3BiY19jb250YWluZXInICkuaGFzKCB0aGlzICkpICl7XHJcblx0XHRcdGpRdWVyeSggdGhpcyApLnNob3coKTtcclxuXHRcdH1cclxuXHR9ICk7XHJcblxyXG5cdGlmICggcGFyYW1zWyAnaXNfc2Nyb2xsJyBdICl7XHJcblx0XHR3cGJjX2RvX3Njcm9sbCggJyMnICsgdW5pcXVlX2Rpdl9pZCArICdfc2Nyb2xsJyApO1xyXG5cdH1cclxuXHJcblx0cmV0dXJuIHVuaXF1ZV9kaXZfaWQ7XHJcbn1cclxuXHJcblxyXG5cdC8qKlxyXG5cdCAqIEVycm9yIG1lc3NhZ2UuIFx0UHJlc2V0IG9mIHBhcmFtZXRlcnMgZm9yIHJlYWwgbWVzc2FnZSBmdW5jdGlvbi5cclxuXHQgKlxyXG5cdCAqIEBwYXJhbSBlbFx0XHQtIGFueSBqUXVlcnkgbm9kZSBkZWZpbml0aW9uXHJcblx0ICogQHBhcmFtIG1lc3NhZ2VcdC0gTWVzc2FnZSBIVE1MXHJcblx0ICogQHJldHVybnMgc3RyaW5nICAtIEhUTUwgSURcdFx0b3IgMCBpZiBub3Qgc2hvd2luZyBkdXJpbmcgdGhpcyB0aW1lLlxyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfZnJvbnRfZW5kX19zaG93X21lc3NhZ2VfX2Vycm9yKCBqcV9ub2RlLCBtZXNzYWdlICl7XHJcblxyXG5cdFx0dmFyIG5vdGljZV9tZXNzYWdlX2lkID0gd3BiY19mcm9udF9lbmRfX3Nob3dfbWVzc2FnZShcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRtZXNzYWdlLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdHtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCd0eXBlJyAgICAgICAgICAgICAgIDogJ2Vycm9yJyxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCdkZWxheScgICAgICAgICAgICAgIDogMTAwMDAsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnaWZfdmlzaWJsZV9ub3Rfc2hvdyc6IHRydWUsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnc2hvd19oZXJlJyAgICAgICAgICA6IHtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCd3aGVyZScgIDogJ3JpZ2h0JyxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCdqcV9ub2RlJzoganFfbm9kZVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCAgIH1cclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHR9XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQpO1xyXG5cdFx0cmV0dXJuIG5vdGljZV9tZXNzYWdlX2lkO1xyXG5cdH1cclxuXHJcblxyXG5cdC8qKlxyXG5cdCAqIEVycm9yIG1lc3NhZ2UgVU5ERVIgZWxlbWVudC4gXHRQcmVzZXQgb2YgcGFyYW1ldGVycyBmb3IgcmVhbCBtZXNzYWdlIGZ1bmN0aW9uLlxyXG5cdCAqXHJcblx0ICogQHBhcmFtIGVsXHRcdC0gYW55IGpRdWVyeSBub2RlIGRlZmluaXRpb25cclxuXHQgKiBAcGFyYW0gbWVzc2FnZVx0LSBNZXNzYWdlIEhUTUxcclxuXHQgKiBAcmV0dXJucyBzdHJpbmcgIC0gSFRNTCBJRFx0XHRvciAwIGlmIG5vdCBzaG93aW5nIGR1cmluZyB0aGlzIHRpbWUuXHJcblx0ICovXHJcblx0ZnVuY3Rpb24gd3BiY19mcm9udF9lbmRfX3Nob3dfbWVzc2FnZV9fZXJyb3JfdW5kZXJfZWxlbWVudCgganFfbm9kZSwgbWVzc2FnZSwgbWVzc2FnZV9kZWxheSApe1xyXG5cclxuXHRcdGlmICggJ3VuZGVmaW5lZCcgPT09IHR5cGVvZiAobWVzc2FnZV9kZWxheSkgKXtcclxuXHRcdFx0bWVzc2FnZV9kZWxheSA9IDBcclxuXHRcdH1cclxuXHJcblx0XHR2YXIgbm90aWNlX21lc3NhZ2VfaWQgPSB3cGJjX2Zyb250X2VuZF9fc2hvd19tZXNzYWdlKFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdG1lc3NhZ2UsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J3R5cGUnICAgICAgICAgICAgICAgOiAnZXJyb3InLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J2RlbGF5JyAgICAgICAgICAgICAgOiBtZXNzYWdlX2RlbGF5LFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J2lmX3Zpc2libGVfbm90X3Nob3cnOiB0cnVlLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J3Nob3dfaGVyZScgICAgICAgICAgOiB7XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnd2hlcmUnICA6ICdhZnRlcicsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnanFfbm9kZSc6IGpxX25vZGVcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQgICB9XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0KTtcclxuXHRcdHJldHVybiBub3RpY2VfbWVzc2FnZV9pZDtcclxuXHR9XHJcblxyXG5cclxuXHQvKipcclxuXHQgKiBFcnJvciBtZXNzYWdlIFVOREVSIGVsZW1lbnQuIFx0UHJlc2V0IG9mIHBhcmFtZXRlcnMgZm9yIHJlYWwgbWVzc2FnZSBmdW5jdGlvbi5cclxuXHQgKlxyXG5cdCAqIEBwYXJhbSBlbFx0XHQtIGFueSBqUXVlcnkgbm9kZSBkZWZpbml0aW9uXHJcblx0ICogQHBhcmFtIG1lc3NhZ2VcdC0gTWVzc2FnZSBIVE1MXHJcblx0ICogQHJldHVybnMgc3RyaW5nICAtIEhUTUwgSURcdFx0b3IgMCBpZiBub3Qgc2hvd2luZyBkdXJpbmcgdGhpcyB0aW1lLlxyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfZnJvbnRfZW5kX19zaG93X21lc3NhZ2VfX2Vycm9yX2Fib3ZlX2VsZW1lbnQoIGpxX25vZGUsIG1lc3NhZ2UsIG1lc3NhZ2VfZGVsYXkgKXtcclxuXHJcblx0XHRpZiAoICd1bmRlZmluZWQnID09PSB0eXBlb2YgKG1lc3NhZ2VfZGVsYXkpICl7XHJcblx0XHRcdG1lc3NhZ2VfZGVsYXkgPSAxMDAwMFxyXG5cdFx0fVxyXG5cclxuXHRcdHZhciBub3RpY2VfbWVzc2FnZV9pZCA9IHdwYmNfZnJvbnRfZW5kX19zaG93X21lc3NhZ2UoXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0bWVzc2FnZSxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHR7XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQndHlwZScgICAgICAgICAgICAgICA6ICdlcnJvcicsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnZGVsYXknICAgICAgICAgICAgICA6IG1lc3NhZ2VfZGVsYXksXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnaWZfdmlzaWJsZV9ub3Rfc2hvdyc6IHRydWUsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnc2hvd19oZXJlJyAgICAgICAgICA6IHtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCd3aGVyZScgIDogJ2JlZm9yZScsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnanFfbm9kZSc6IGpxX25vZGVcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQgICB9XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0KTtcclxuXHRcdHJldHVybiBub3RpY2VfbWVzc2FnZV9pZDtcclxuXHR9XHJcblxyXG5cclxuXHQvKipcclxuXHQgKiBXYXJuaW5nIG1lc3NhZ2UuIFx0UHJlc2V0IG9mIHBhcmFtZXRlcnMgZm9yIHJlYWwgbWVzc2FnZSBmdW5jdGlvbi5cclxuXHQgKlxyXG5cdCAqIEBwYXJhbSBlbFx0XHQtIGFueSBqUXVlcnkgbm9kZSBkZWZpbml0aW9uXHJcblx0ICogQHBhcmFtIG1lc3NhZ2VcdC0gTWVzc2FnZSBIVE1MXHJcblx0ICogQHJldHVybnMgc3RyaW5nICAtIEhUTUwgSURcdFx0b3IgMCBpZiBub3Qgc2hvd2luZyBkdXJpbmcgdGhpcyB0aW1lLlxyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfZnJvbnRfZW5kX19zaG93X21lc3NhZ2VfX3dhcm5pbmcoIGpxX25vZGUsIG1lc3NhZ2UgKXtcclxuXHJcblx0XHR2YXIgbm90aWNlX21lc3NhZ2VfaWQgPSB3cGJjX2Zyb250X2VuZF9fc2hvd19tZXNzYWdlKFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdG1lc3NhZ2UsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J3R5cGUnICAgICAgICAgICAgICAgOiAnd2FybmluZycsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnZGVsYXknICAgICAgICAgICAgICA6IDEwMDAwLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J2lmX3Zpc2libGVfbm90X3Nob3cnOiB0cnVlLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J3Nob3dfaGVyZScgICAgICAgICAgOiB7XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnd2hlcmUnICA6ICdyaWdodCcsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnanFfbm9kZSc6IGpxX25vZGVcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQgICB9XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0KTtcclxuXHRcdHJldHVybiBub3RpY2VfbWVzc2FnZV9pZDtcclxuXHR9XHJcblxyXG5cclxuXHQvKipcclxuXHQgKiBXYXJuaW5nIG1lc3NhZ2UgVU5ERVIgZWxlbWVudC4gXHRQcmVzZXQgb2YgcGFyYW1ldGVycyBmb3IgcmVhbCBtZXNzYWdlIGZ1bmN0aW9uLlxyXG5cdCAqXHJcblx0ICogQHBhcmFtIGVsXHRcdC0gYW55IGpRdWVyeSBub2RlIGRlZmluaXRpb25cclxuXHQgKiBAcGFyYW0gbWVzc2FnZVx0LSBNZXNzYWdlIEhUTUxcclxuXHQgKiBAcmV0dXJucyBzdHJpbmcgIC0gSFRNTCBJRFx0XHRvciAwIGlmIG5vdCBzaG93aW5nIGR1cmluZyB0aGlzIHRpbWUuXHJcblx0ICovXHJcblx0ZnVuY3Rpb24gd3BiY19mcm9udF9lbmRfX3Nob3dfbWVzc2FnZV9fd2FybmluZ191bmRlcl9lbGVtZW50KCBqcV9ub2RlLCBtZXNzYWdlICl7XHJcblxyXG5cdFx0dmFyIG5vdGljZV9tZXNzYWdlX2lkID0gd3BiY19mcm9udF9lbmRfX3Nob3dfbWVzc2FnZShcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRtZXNzYWdlLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdHtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCd0eXBlJyAgICAgICAgICAgICAgIDogJ3dhcm5pbmcnLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J2RlbGF5JyAgICAgICAgICAgICAgOiAxMDAwMCxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCdpZl92aXNpYmxlX25vdF9zaG93JzogdHJ1ZSxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCdzaG93X2hlcmUnICAgICAgICAgIDoge1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J3doZXJlJyAgOiAnYWZ0ZXInLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J2pxX25vZGUnOiBqcV9ub2RlXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0ICAgfVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdH1cclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCk7XHJcblx0XHRyZXR1cm4gbm90aWNlX21lc3NhZ2VfaWQ7XHJcblx0fVxyXG5cclxuXHJcblx0LyoqXHJcblx0ICogV2FybmluZyBtZXNzYWdlIEFCT1ZFIGVsZW1lbnQuIFx0UHJlc2V0IG9mIHBhcmFtZXRlcnMgZm9yIHJlYWwgbWVzc2FnZSBmdW5jdGlvbi5cclxuXHQgKlxyXG5cdCAqIEBwYXJhbSBlbFx0XHQtIGFueSBqUXVlcnkgbm9kZSBkZWZpbml0aW9uXHJcblx0ICogQHBhcmFtIG1lc3NhZ2VcdC0gTWVzc2FnZSBIVE1MXHJcblx0ICogQHJldHVybnMgc3RyaW5nICAtIEhUTUwgSURcdFx0b3IgMCBpZiBub3Qgc2hvd2luZyBkdXJpbmcgdGhpcyB0aW1lLlxyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfZnJvbnRfZW5kX19zaG93X21lc3NhZ2VfX3dhcm5pbmdfYWJvdmVfZWxlbWVudCgganFfbm9kZSwgbWVzc2FnZSApe1xyXG5cclxuXHRcdHZhciBub3RpY2VfbWVzc2FnZV9pZCA9IHdwYmNfZnJvbnRfZW5kX19zaG93X21lc3NhZ2UoXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0bWVzc2FnZSxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHR7XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQndHlwZScgICAgICAgICAgICAgICA6ICd3YXJuaW5nJyxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCdkZWxheScgICAgICAgICAgICAgIDogMTAwMDAsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnaWZfdmlzaWJsZV9ub3Rfc2hvdyc6IHRydWUsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnc2hvd19oZXJlJyAgICAgICAgICA6IHtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCd3aGVyZScgIDogJ2JlZm9yZScsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnanFfbm9kZSc6IGpxX25vZGVcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQgICB9XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0KTtcclxuXHRcdHJldHVybiBub3RpY2VfbWVzc2FnZV9pZDtcclxuXHR9XHJcblxyXG5cclxuLyoqXHJcbiAqIFNjcm9sbCB0byBzcGVjaWZpYyBlbGVtZW50XHJcbiAqXHJcbiAqIEBwYXJhbSBqcV9ub2RlXHRcdFx0XHRcdHN0cmluZyBvciBqUXVlcnkgZWxlbWVudCwgIHdoZXJlIHNjcm9sbCAgdG9cclxuICogQHBhcmFtIGV4dHJhX3NoaWZ0X29mZnNldFx0XHRpbnQgc2hpZnQgb2Zmc2V0IGZyb20gIGpxX25vZGVcclxuICovXHJcbmZ1bmN0aW9uIHdwYmNfZG9fc2Nyb2xsKCBqcV9ub2RlICwgZXh0cmFfc2hpZnRfb2Zmc2V0ID0gMCApe1xyXG5cclxuXHRpZiAoICFqUXVlcnkoIGpxX25vZGUgKS5sZW5ndGggKXtcclxuXHRcdHJldHVybjtcclxuXHR9XHJcblx0dmFyIHRhcmdldE9mZnNldCA9IGpRdWVyeSgganFfbm9kZSApLm9mZnNldCgpLnRvcDtcclxuXHJcblx0aWYgKCB0YXJnZXRPZmZzZXQgPD0gMCApe1xyXG5cdFx0aWYgKCAwICE9IGpRdWVyeSgganFfbm9kZSApLm5leHRBbGwoICc6dmlzaWJsZScgKS5sZW5ndGggKXtcclxuXHRcdFx0dGFyZ2V0T2Zmc2V0ID0galF1ZXJ5KCBqcV9ub2RlICkubmV4dEFsbCggJzp2aXNpYmxlJyApLmZpcnN0KCkub2Zmc2V0KCkudG9wO1xyXG5cdFx0fSBlbHNlIGlmICggMCAhPSBqUXVlcnkoIGpxX25vZGUgKS5wYXJlbnQoKS5uZXh0QWxsKCAnOnZpc2libGUnICkubGVuZ3RoICl7XHJcblx0XHRcdHRhcmdldE9mZnNldCA9IGpRdWVyeSgganFfbm9kZSApLnBhcmVudCgpLm5leHRBbGwoICc6dmlzaWJsZScgKS5maXJzdCgpLm9mZnNldCgpLnRvcDtcclxuXHRcdH1cclxuXHR9XHJcblxyXG5cdGlmICggalF1ZXJ5KCAnI3dwYWRtaW5iYXInICkubGVuZ3RoID4gMCApe1xyXG5cdFx0dGFyZ2V0T2Zmc2V0ID0gdGFyZ2V0T2Zmc2V0IC0gNTAgLSA1MDtcclxuXHR9IGVsc2Uge1xyXG5cdFx0dGFyZ2V0T2Zmc2V0ID0gdGFyZ2V0T2Zmc2V0IC0gMjAgLSA1MDtcclxuXHR9XHJcblx0dGFyZ2V0T2Zmc2V0ICs9IGV4dHJhX3NoaWZ0X29mZnNldDtcclxuXHJcblx0Ly8gU2Nyb2xsIG9ubHkgIGlmIHdlIGRpZCBub3Qgc2Nyb2xsIGJlZm9yZVxyXG5cdGlmICggISBqUXVlcnkoICdodG1sLGJvZHknICkuaXMoICc6YW5pbWF0ZWQnICkgKXtcclxuXHRcdGpRdWVyeSggJ2h0bWwsYm9keScgKS5hbmltYXRlKCB7c2Nyb2xsVG9wOiB0YXJnZXRPZmZzZXR9LCA1MDAgKTtcclxuXHR9XHJcbn1cclxuXHJcbiJdLCJmaWxlIjoiX2Rpc3QvYWxsL19vdXQvd3BiY19hbGwuanMifQ==
