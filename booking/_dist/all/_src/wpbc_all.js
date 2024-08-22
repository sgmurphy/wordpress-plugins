/**
 * =====================================================================================================================
 * JavaScript Util Functions		../includes/__js/utils/wpbc_utils.js
 * =====================================================================================================================
 */

/**
 * Trim  strings and array joined with  (,)
 *
 * @param string_to_trim   string / array
 * @returns string
 */
function wpbc_trim( string_to_trim ){

    if ( Array.isArray( string_to_trim ) ){
        string_to_trim = string_to_trim.join( ',' );
    }

    if ( 'string' == typeof (string_to_trim) ){
        string_to_trim = string_to_trim.trim();
    }

    return string_to_trim;
}

/**
 * Check if element in array
 *
 * @param array_here		array
 * @param p_val				element to  check
 * @returns {boolean}
 */
function wpbc_in_array( array_here, p_val ){
	for ( var i = 0, l = array_here.length; i < l; i++ ){
		if ( array_here[ i ] == p_val ){
			return true;
		}
	}
	return false;
}

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
function wpbc_clone_obj( obj ){

	return JSON.parse( JSON.stringify( obj ) );
}



/**
 * Main _wpbc JS object
 */

var _wpbc = (function ( obj, $) {

	// Secure parameters for Ajax	------------------------------------------------------------------------------------
	var p_secure = obj.security_obj = obj.security_obj || {
															user_id: 0,
															nonce  : '',
															locale : ''
														  };
	obj.set_secure_param = function ( param_key, param_val ) {
		p_secure[ param_key ] = param_val;
	};

	obj.get_secure_param = function ( param_key ) {
		return p_secure[ param_key ];
	};


	// Calendars 	----------------------------------------------------------------------------------------------------
	var p_calendars = obj.calendars_obj = obj.calendars_obj || {
																		// sort            : "booking_id",
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
	obj.calendar__is_defined = function ( resource_id ) {

		return ('undefined' !== typeof( p_calendars[ 'calendar_' + resource_id ] ) );
	};

	/**
	 *  Create Calendar initializing
	 *
	 * @param {string|int} resource_id
	 */
	obj.calendar__init = function ( resource_id ) {

		p_calendars[ 'calendar_' + resource_id ] = {};
		p_calendars[ 'calendar_' + resource_id ][ 'id' ] = resource_id;
		p_calendars[ 'calendar_' + resource_id ][ 'pending_days_selectable' ] = false;

	};

	/**
	 * Check  if the type of this property  is INT
	 * @param property_name
	 * @returns {boolean}
	 */
	obj.calendar__is_prop_int = function ( property_name ) {													//FixIn: 9.9.0.29

		var p_calendar_int_properties = ['dynamic__days_min', 'dynamic__days_max', 'fixed__days_num'];

		var is_include = p_calendar_int_properties.includes( property_name );

		return is_include;
	};


	/**
	 * Set params for all  calendars
	 *
	 * @param {object} calendars_obj		Object { calendar_1: {} }
	 * 												 calendar_3: {}, ... }
	 */
	obj.calendars_all__set = function ( calendars_obj ) {
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
	obj.calendar__get_parameters = function ( resource_id ) {

		if ( obj.calendar__is_defined( resource_id ) ){

			return p_calendars[ 'calendar_' + resource_id ];
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
	obj.calendar__set_parameters = function ( resource_id, calendar_property_obj, is_complete_overwrite = false  ) {

		if ( (!obj.calendar__is_defined( resource_id )) || (true === is_complete_overwrite) ){
			obj.calendar__init( resource_id );
		}

		for ( var prop_name in calendar_property_obj ){

			p_calendars[ 'calendar_' + resource_id ][ prop_name ] = calendar_property_obj[ prop_name ];
		}

		return p_calendars[ 'calendar_' + resource_id ];
	};

	/**
	 * Set property  to  calendar
	 * @param resource_id	"1"
	 * @param prop_name		name of property
	 * @param prop_value	value of property
	 * @returns {*}			calendar object
	 */
	obj.calendar__set_param_value = function ( resource_id, prop_name, prop_value ) {

		if ( (!obj.calendar__is_defined( resource_id )) ){
			obj.calendar__init( resource_id );
		}

		p_calendars[ 'calendar_' + resource_id ][ prop_name ] = prop_value;

		return p_calendars[ 'calendar_' + resource_id ];
	};

	/**
	 *  Get calendar property value   	::   mixed | null
	 *
	 * @param {string|int}  resource_id		'1'
	 * @param {string} prop_name			'selection_mode'
	 * @returns {*|null}					mixed | null
	 */
	obj.calendar__get_param_value = function( resource_id, prop_name ){

		if (
			   ( obj.calendar__is_defined( resource_id ) )
			&& ( 'undefined' !== typeof ( p_calendars[ 'calendar_' + resource_id ][ prop_name ] ) )
		){
			//FixIn: 9.9.0.29
			if ( obj.calendar__is_prop_int( prop_name ) ){
				p_calendars[ 'calendar_' + resource_id ][ prop_name ] = parseInt( p_calendars[ 'calendar_' + resource_id ][ prop_name ] );
			}
			return  p_calendars[ 'calendar_' + resource_id ][ prop_name ];
		}

		return null;		// If some property not defined, then null;
	};
	// -----------------------------------------------------------------------------------------------------------------


	// Bookings 	----------------------------------------------------------------------------------------------------
	var p_bookings = obj.bookings_obj = obj.bookings_obj || {
																// calendar_1: Object {
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
	obj.bookings_in_calendar__is_defined = function ( resource_id ) {

		return ('undefined' !== typeof( p_bookings[ 'calendar_' + resource_id ] ) );
	};

	/**
	 * Get bookings calendar object   ::   { id: 1 , dates:  Object { "2023-07-21": {…}, "2023-07-22": {…}, "2023-07-23": {…}, … }
	 *
	 * @param {string|int} resource_id				  '2'
	 * @returns {object|boolean}					{ id: 2 , dates:  Object { "2023-07-21": {…}, "2023-07-22": {…}, "2023-07-23": {…}, … }
	 */
	obj.bookings_in_calendar__get = function( resource_id ){

		if ( obj.bookings_in_calendar__is_defined( resource_id ) ){

			return p_bookings[ 'calendar_' + resource_id ];
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
	obj.bookings_in_calendar__set = function( resource_id, calendar_obj ){

		if ( ! obj.bookings_in_calendar__is_defined( resource_id ) ){
			p_bookings[ 'calendar_' + resource_id ] = {};
			p_bookings[ 'calendar_' + resource_id ][ 'id' ] = resource_id;
		}

		for ( var prop_name in calendar_obj ){

			p_bookings[ 'calendar_' + resource_id ][ prop_name ] = calendar_obj[ prop_name ];
		}

		return p_bookings[ 'calendar_' + resource_id ];
	};

	// Dates

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
	obj.bookings_in_calendar__get_dates = function( resource_id){

		if (
			   ( obj.bookings_in_calendar__is_defined( resource_id ) )
			&& ( 'undefined' !== typeof ( p_bookings[ 'calendar_' + resource_id ][ 'dates' ] ) )
		){
			return  p_bookings[ 'calendar_' + resource_id ][ 'dates' ];
		}

		return false;		// If some property not defined, then false;
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
	obj.bookings_in_calendar__set_dates = function( resource_id, dates_obj , is_complete_overwrite = true ){

		if ( !obj.bookings_in_calendar__is_defined( resource_id ) ){
			obj.bookings_in_calendar__set( resource_id, { 'dates': {} } );
		}

		if ( 'undefined' === typeof (p_bookings[ 'calendar_' + resource_id ][ 'dates' ]) ){
			p_bookings[ 'calendar_' + resource_id ][ 'dates' ] = {}
		}

		if (is_complete_overwrite){

			// Complete overwrite all  booking dates
			p_bookings[ 'calendar_' + resource_id ][ 'dates' ] = dates_obj;
		} else {

			// Add only  new or overwrite exist booking dates from  parameter. Booking dates not from  parameter  will  be without chnanges
			for ( var prop_name in dates_obj ){

				p_bookings[ 'calendar_' + resource_id ]['dates'][ prop_name ] = dates_obj[ prop_name ];
			}
		}

		return p_bookings[ 'calendar_' + resource_id ];
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
	obj.bookings_in_calendar__get_for_date = function( resource_id, sql_class_day ){

		if (
			   ( obj.bookings_in_calendar__is_defined( resource_id ) )
			&& ( 'undefined' !== typeof ( p_bookings[ 'calendar_' + resource_id ][ 'dates' ] ) )
			&& ( 'undefined' !== typeof ( p_bookings[ 'calendar_' + resource_id ][ 'dates' ][ sql_class_day ] ) )
		){
			return  p_bookings[ 'calendar_' + resource_id ][ 'dates' ][ sql_class_day ];
		}

		return false;		// If some property not defined, then false;
	};


	// Any  PARAMS   in bookings

	/**
	 * Set property  to  booking
	 * @param resource_id	"1"
	 * @param prop_name		name of property
	 * @param prop_value	value of property
	 * @returns {*}			booking object
	 */
	obj.booking__set_param_value = function ( resource_id, prop_name, prop_value ) {

		if ( ! obj.bookings_in_calendar__is_defined( resource_id ) ){
			p_bookings[ 'calendar_' + resource_id ] = {};
			p_bookings[ 'calendar_' + resource_id ][ 'id' ] = resource_id;
		}

		p_bookings[ 'calendar_' + resource_id ][ prop_name ] = prop_value;

		return p_bookings[ 'calendar_' + resource_id ];
	};

	/**
	 *  Get booking property value   	::   mixed | null
	 *
	 * @param {string|int}  resource_id		'1'
	 * @param {string} prop_name			'selection_mode'
	 * @returns {*|null}					mixed | null
	 */
	obj.booking__get_param_value = function( resource_id, prop_name ){

		if (
			   ( obj.bookings_in_calendar__is_defined( resource_id ) )
			&& ( 'undefined' !== typeof ( p_bookings[ 'calendar_' + resource_id ][ prop_name ] ) )
		){
			return  p_bookings[ 'calendar_' + resource_id ][ prop_name ];
		}

		return null;		// If some property not defined, then null;
	};




	/**
	 * Set bookings for all  calendars
	 *
	 * @param {object} calendars_obj		Object { calendar_1: { id: 1, dates: Object { "2023-07-22": {…}, "2023-07-23": {…}, "2023-07-24": {…}, … } }
	 * 												 calendar_3: {}, ... }
	 */
	obj.bookings_in_calendars__set_all = function ( calendars_obj ) {
		p_bookings = calendars_obj;
	};

	/**
	 * Get bookings in all calendars
	 *
	 * @returns {object|{}}
	 */
	obj.bookings_in_calendars__get_all = function () {
		return p_bookings;
	};
	// -----------------------------------------------------------------------------------------------------------------




	// Seasons 	----------------------------------------------------------------------------------------------------
	var p_seasons = obj.seasons_obj = obj.seasons_obj || {
																// calendar_1: Object {
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
	obj.seasons__set = function( resource_id, dates_obj , is_complete_overwrite = false ){

		if ( 'undefined' === typeof (p_seasons[ 'calendar_' + resource_id ]) ){
			p_seasons[ 'calendar_' + resource_id ] = {};
		}

		if ( is_complete_overwrite ){

			// Complete overwrite all  season dates
			p_seasons[ 'calendar_' + resource_id ] = dates_obj;

		} else {

			// Add only  new or overwrite exist booking dates from  parameter. Booking dates not from  parameter  will  be without chnanges
			for ( var prop_name in dates_obj ){

				if ( 'undefined' === typeof (p_seasons[ 'calendar_' + resource_id ][ prop_name ]) ){
					p_seasons[ 'calendar_' + resource_id ][ prop_name ] = [];
				}
				for ( var season_name_key in dates_obj[ prop_name ] ){
					p_seasons[ 'calendar_' + resource_id ][ prop_name ].push( dates_obj[ prop_name ][ season_name_key ] );
				}
			}
		}

		return p_seasons[ 'calendar_' + resource_id ];
	};


	/**
	 *  Get bookings data for specific date in calendar   ::   [] | [ 'wpbc_season_september_2023', 'wpbc_season_september_2024' ]
	 *
	 * @param {string|int} resource_id			'1'
	 * @param {string} sql_class_day			'2023-07-21'
	 * @returns {object|boolean}				[]  |  [ 'wpbc_season_september_2023', 'wpbc_season_september_2024' ]
	 */
	obj.seasons__get_for_date = function( resource_id, sql_class_day ){

		if (
			   ( 'undefined' !== typeof ( p_seasons[ 'calendar_' + resource_id ] ) )
			&& ( 'undefined' !== typeof ( p_seasons[ 'calendar_' + resource_id ][ sql_class_day ] ) )
		){
			return  p_seasons[ 'calendar_' + resource_id ][ sql_class_day ];
		}

		return [];		// If not defined, then [];
	};


	// Other parameters 			------------------------------------------------------------------------------------
	var p_other = obj.other_obj = obj.other_obj || { };

	obj.set_other_param = function ( param_key, param_val ) {
		p_other[ param_key ] = param_val;
	};

	obj.get_other_param = function ( param_key ) {
		return p_other[ param_key ];
	};

	/**
	 * Get all other params
	 *
	 * @returns {object|{}}
	 */
	obj.get_other_param__all = function () {
		return p_other;
	};

	// Messages 			        ------------------------------------------------------------------------------------
	var p_messages = obj.messages_obj = obj.messages_obj || { };

	obj.set_message = function ( param_key, param_val ) {
		p_messages[ param_key ] = param_val;
	};

	obj.get_message = function ( param_key ) {
		return p_messages[ param_key ];
	};

	/**
	 * Get all other params
	 *
	 * @returns {object|{}}
	 */
	obj.get_messages__all = function () {
		return p_messages;
	};

	// -----------------------------------------------------------------------------------------------------------------

	return obj;

}( _wpbc || {}, jQuery ));

/**
 * Extend _wpbc with  new methods        //FixIn: 9.8.6.2
 *
 * @type {*|{}}
 * @private
 */
 _wpbc = (function ( obj, $) {

	// Load Balancer 	-----------------------------------------------------------------------------------------------

	var p_balancer = obj.balancer_obj = obj.balancer_obj || {
																'max_threads': 2,
																'in_process' : [],
																'wait'       : []
															};

	 /**
	  * Set  max parallel request  to  load
	  *
	  * @param max_threads
	  */
	obj.balancer__set_max_threads = function ( max_threads ){

		p_balancer[ 'max_threads' ] = max_threads;
	};

	/**
	 *  Check if balancer for specific booking resource defined   ::   true | false
	 *
	 * @param {string|int} resource_id
	 * @returns {boolean}
	 */
	obj.balancer__is_defined = function ( resource_id ) {

		return ('undefined' !== typeof( p_balancer[ 'balancer_' + resource_id ] ) );
	};


	/**
	 *  Create balancer initializing
	 *
	 * @param {string|int} resource_id
	 */
	obj.balancer__init = function ( resource_id, function_name , params ={}) {

		var balance_obj = {};
		balance_obj[ 'resource_id' ]   = resource_id;
		balance_obj[ 'priority' ]      = 1;
		balance_obj[ 'function_name' ] = function_name;
		balance_obj[ 'params' ]        = wpbc_clone_obj( params );


		if ( obj.balancer__is_already_run( resource_id, function_name ) ){
			return 'run';
		}
		if ( obj.balancer__is_already_wait( resource_id, function_name ) ){
			return 'wait';
		}


		if ( obj.balancer__can_i_run() ){
			obj.balancer__add_to__run( balance_obj );
			return 'run';
		} else {
			obj.balancer__add_to__wait( balance_obj );
			return 'wait';
		}
	};

	 /**
	  * Can I Run ?
	  * @returns {boolean}
	  */
	obj.balancer__can_i_run = function (){
		return ( p_balancer[ 'in_process' ].length < p_balancer[ 'max_threads' ] );
	}

		 /**
		  * Add to WAIT
		  * @param balance_obj
		  */
		obj.balancer__add_to__wait = function ( balance_obj ) {
			p_balancer['wait'].push( balance_obj );
		}

		 /**
		  * Remove from Wait
		  *
		  * @param resource_id
		  * @param function_name
		  * @returns {*|boolean}
		  */
		obj.balancer__remove_from__wait_list = function ( resource_id, function_name ){

			var removed_el = false;

			if ( p_balancer[ 'wait' ].length ){					//FixIn: 9.8.10.1
				for ( var i in p_balancer[ 'wait' ] ){
					if (
						(resource_id === p_balancer[ 'wait' ][ i ][ 'resource_id' ])
						&& (function_name === p_balancer[ 'wait' ][ i ][ 'function_name' ])
					){
						removed_el = p_balancer[ 'wait' ].splice( i, 1 );
						removed_el = removed_el.pop();
						p_balancer[ 'wait' ] = p_balancer[ 'wait' ].filter( function ( v ){
							return v;
						} );					// Reindex array
						return removed_el;
					}
				}
			}
			return removed_el;
		}

		/**
		* Is already WAIT
		*
		* @param resource_id
		* @param function_name
		* @returns {boolean}
		*/
		obj.balancer__is_already_wait = function ( resource_id, function_name ){

			if ( p_balancer[ 'wait' ].length ){				//FixIn: 9.8.10.1
				for ( var i in p_balancer[ 'wait' ] ){
					if (
						(resource_id === p_balancer[ 'wait' ][ i ][ 'resource_id' ])
						&& (function_name === p_balancer[ 'wait' ][ i ][ 'function_name' ])
					){
						return true;
					}
				}
			}
			return false;
		}


		 /**
		  * Add to RUN
		  * @param balance_obj
		  */
		obj.balancer__add_to__run = function ( balance_obj ) {
			p_balancer['in_process'].push( balance_obj );
		}

		/**
		* Remove from RUN list
		*
		* @param resource_id
		* @param function_name
		* @returns {*|boolean}
		*/
		obj.balancer__remove_from__run_list = function ( resource_id, function_name ){

			 var removed_el = false;

			 if ( p_balancer[ 'in_process' ].length ){				//FixIn: 9.8.10.1
				 for ( var i in p_balancer[ 'in_process' ] ){
					 if (
						 (resource_id === p_balancer[ 'in_process' ][ i ][ 'resource_id' ])
						 && (function_name === p_balancer[ 'in_process' ][ i ][ 'function_name' ])
					 ){
						 removed_el = p_balancer[ 'in_process' ].splice( i, 1 );
						 removed_el = removed_el.pop();
						 p_balancer[ 'in_process' ] = p_balancer[ 'in_process' ].filter( function ( v ){
							 return v;
						 } );		// Reindex array
						 return removed_el;
					 }
				 }
			 }
			 return removed_el;
		}

		/**
		* Is already RUN
		*
		* @param resource_id
		* @param function_name
		* @returns {boolean}
		*/
		obj.balancer__is_already_run = function ( resource_id, function_name ){

			if ( p_balancer[ 'in_process' ].length ){					//FixIn: 9.8.10.1
				for ( var i in p_balancer[ 'in_process' ] ){
					if (
						(resource_id === p_balancer[ 'in_process' ][ i ][ 'resource_id' ])
						&& (function_name === p_balancer[ 'in_process' ][ i ][ 'function_name' ])
					){
						return true;
					}
				}
			}
			return false;
		}



	obj.balancer__run_next = function (){

		// Get 1st from  Wait list
		var removed_el = false;
		if ( p_balancer[ 'wait' ].length ){					//FixIn: 9.8.10.1
			for ( var i in p_balancer[ 'wait' ] ){
				removed_el = obj.balancer__remove_from__wait_list( p_balancer[ 'wait' ][ i ][ 'resource_id' ], p_balancer[ 'wait' ][ i ][ 'function_name' ] );
				break;
			}
		}

		if ( false !== removed_el ){

			// Run
			obj.balancer__run( removed_el );
		}
	}

	 /**
	  * Run
	  * @param balance_obj
	  */
	obj.balancer__run = function ( balance_obj ){

		switch ( balance_obj[ 'function_name' ] ){

			case 'wpbc_calendar__load_data__ajx':

				// Add to run list
				obj.balancer__add_to__run( balance_obj );

				wpbc_calendar__load_data__ajx( balance_obj[ 'params' ] )
				break;

			default:
		}
	}

	return obj;

}( _wpbc || {}, jQuery ));


 	/**
 	 * -- Help functions ----------------------------------------------------------------------------------------------
	 */

	function wpbc_balancer__is_wait( params, function_name ){
//console.log('::wpbc_balancer__is_wait',params , function_name );
		if ( 'undefined' !== typeof (params[ 'resource_id' ]) ){

			var balancer_status = _wpbc.balancer__init( params[ 'resource_id' ], function_name, params );

			return ( 'wait' === balancer_status );
		}

		return false;
	}


	function wpbc_balancer__completed( resource_id , function_name ){
//console.log('::wpbc_balancer__completed',resource_id , function_name );
		_wpbc.balancer__remove_from__run_list( resource_id, function_name );
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
function wpbc_calendar_show( resource_id ){

	// If no calendar HTML tag,  then  exit
	if ( 0 === jQuery( '#calendar_booking' + resource_id ).length ){ return false; }

	// If the calendar with the same Booking resource is activated already, then exit.
	if ( true === jQuery( '#calendar_booking' + resource_id ).hasClass( 'hasDatepick' ) ){ return false; }

	// -----------------------------------------------------------------------------------------------------------------
	// Days selection
	// -----------------------------------------------------------------------------------------------------------------
	var local__is_range_select = false;
	var local__multi_days_select_num   = 365;					// multiple | fixed
	if ( 'dynamic' === _wpbc.calendar__get_param_value( resource_id, 'days_select_mode' ) ){
		local__is_range_select = true;
		local__multi_days_select_num = 0;
	}
	if ( 'single'  === _wpbc.calendar__get_param_value( resource_id, 'days_select_mode' ) ){
		local__multi_days_select_num = 0;
	}

	// -----------------------------------------------------------------------------------------------------------------
	// Min - Max days to scroll/show
	// -----------------------------------------------------------------------------------------------------------------
	var local__min_date = 0;
 	local__min_date = new Date( _wpbc.get_other_param( 'today_arr' )[ 0 ], (parseInt( _wpbc.get_other_param( 'today_arr' )[ 1 ] ) - 1), _wpbc.get_other_param( 'today_arr' )[ 2 ], 0, 0, 0 );			//FixIn: 9.9.0.17
//console.log( local__min_date );
	var local__max_date = _wpbc.calendar__get_param_value( resource_id, 'booking_max_monthes_in_calendar' );
	//local__max_date = new Date(2024, 5, 28);  It is here issue of not selectable dates, but some dates showing in calendar as available, but we can not select it.

	//// Define last day in calendar (as a last day of month (and not date, which is related to actual 'Today' date).
	//// E.g. if today is 2023-09-25, and we set 'Number of months to scroll' as 5 months, then last day will be 2024-02-29 and not the 2024-02-25.
	// var cal_last_day_in_month = jQuery.datepick._determineDate( null, local__max_date, new Date() );
	// cal_last_day_in_month = new Date( cal_last_day_in_month.getFullYear(), cal_last_day_in_month.getMonth() + 1, 0 );
	// local__max_date = cal_last_day_in_month;			//FixIn: 10.0.0.26

	if (   ( location.href.indexOf('page=wpbc-new') != -1 )
		&& ( location.href.indexOf('booking_hash') != -1 )                  // Comment this line for ability to add  booking in past days at  Booking > Add booking page.
		){
		local__min_date = null;
		local__max_date = null;
	}

	var local__start_weekday    = _wpbc.calendar__get_param_value( resource_id, 'booking_start_day_weeek' );
	var local__number_of_months = parseInt( _wpbc.calendar__get_param_value( resource_id, 'calendar_number_of_months' ) );

	jQuery( '#calendar_booking' + resource_id ).text( '' );					// Remove all HTML in calendar tag
	// -----------------------------------------------------------------------------------------------------------------
	// Show calendar
	// -----------------------------------------------------------------------------------------------------------------
	jQuery('#calendar_booking'+ resource_id).datepick(
			{
				beforeShowDay: function ( js_date ){
									return wpbc__calendar__apply_css_to_days( js_date, {'resource_id': resource_id}, this );
							  },
				onSelect: function ( string_dates, js_dates_arr ){  /**
																	 *	string_dates   =   '23.08.2023 - 26.08.2023'    |    '23.08.2023 - 23.08.2023'    |    '19.09.2023, 24.08.2023, 30.09.2023'
																	 *  js_dates_arr   =   range: [ Date (Aug 23 2023), Date (Aug 25 2023)]     |     multiple: [ Date(Oct 24 2023), Date(Oct 20 2023), Date(Oct 16 2023) ]
																	 */
									return wpbc__calendar__on_select_days( string_dates, {'resource_id': resource_id}, this );
							  },
				onHover: function ( string_date, js_date ){
									return wpbc__calendar__on_hover_days( string_date, js_date, {'resource_id': resource_id}, this );
							  },
				onChangeMonthYear: function ( year, real_month, js_date__1st_day_in_month ){ },
				showOn        : 'both',
				numberOfMonths: local__number_of_months,
				stepMonths    : 1,
				// prevText      : '&laquo;',
				// nextText      : '&raquo;',
				prevText      : '&lsaquo;',
				nextText      : '&rsaquo;',
				dateFormat    : 'dd.mm.yy',
				changeMonth   : false,
				changeYear    : false,
				minDate       : local__min_date,
				maxDate       : local__max_date, 														// '1Y',
				// minDate: new Date(2020, 2, 1), maxDate: new Date(2020, 9, 31),             	// Ability to set any  start and end date in calendar
				showStatus      : false,
				multiSeparator  : ', ',
				closeAtTop      : false,
				firstDay        : local__start_weekday,
				gotoCurrent     : false,
				hideIfNoPrevNext: true,
				multiSelect     : local__multi_days_select_num,
				rangeSelect     : local__is_range_select,
				// showWeeks: true,
				useThemeRoller: false
			}
	);


	
	// -----------------------------------------------------------------------------------------------------------------
	// Clear today date highlighting
	// -----------------------------------------------------------------------------------------------------------------
	setTimeout( function (){  wpbc_calendars__clear_days_highlighting( resource_id );  }, 500 );                    	//FixIn: 7.1.2.8
	
	// -----------------------------------------------------------------------------------------------------------------
	// Scroll calendar to  specific month
	// -----------------------------------------------------------------------------------------------------------------
	var start_bk_month = _wpbc.calendar__get_param_value( resource_id, 'calendar_scroll_to' );
	if ( false !== start_bk_month ){
		wpbc_calendar__scroll_to( resource_id, start_bk_month[ 0 ], start_bk_month[ 1 ] );
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
	function wpbc__calendar__apply_css_to_days( date, calendar_params_arr, datepick_this ){

		var today_date = new Date( _wpbc.get_other_param( 'today_arr' )[ 0 ], (parseInt( _wpbc.get_other_param( 'today_arr' )[ 1 ] ) - 1), _wpbc.get_other_param( 'today_arr' )[ 2 ], 0, 0, 0 );								// Today JS_Date_Obj.
		var class_day     = wpbc__get__td_class_date( date );																					// '1-9-2023'
		var sql_class_day = wpbc__get__sql_class_date( date );																					// '2023-01-09'
		var resource_id = ( 'undefined' !== typeof(calendar_params_arr[ 'resource_id' ]) ) ? calendar_params_arr[ 'resource_id' ] : '1'; 		// '1'

		// Get Selected dates in calendar
		var selected_dates_sql = wpbc_get__selected_dates_sql__as_arr( resource_id );

		// Get Data --------------------------------------------------------------------------------------------------------
		var date_bookings_obj = _wpbc.bookings_in_calendar__get_for_date( resource_id, sql_class_day );


		// Array with CSS classes for date ---------------------------------------------------------------------------------
		var css_classes__for_date = [];
		css_classes__for_date.push( 'sql_date_'     + sql_class_day );				//  'sql_date_2023-07-21'
		css_classes__for_date.push( 'cal4date-'     + class_day );					//  'cal4date-7-21-2023'
		css_classes__for_date.push( 'wpbc_weekday_' + date.getDay() );				//  'wpbc_weekday_4'

		// Define Selected Check In/Out dates in TD  -----------------------------------------------------------------------
		if (
				( selected_dates_sql.length  )
			//&&  ( selected_dates_sql[ 0 ] !== selected_dates_sql[ (selected_dates_sql.length - 1) ] )
		){
			if ( sql_class_day === selected_dates_sql[ 0 ] ){
				css_classes__for_date.push( 'selected_check_in' );
				css_classes__for_date.push( 'selected_check_in_out' );
			}
			if (  ( selected_dates_sql.length > 1 ) && ( sql_class_day === selected_dates_sql[ (selected_dates_sql.length - 1) ] ) ) {
				css_classes__for_date.push( 'selected_check_out' );
				css_classes__for_date.push( 'selected_check_in_out' );
			}
		}


		var is_day_selectable = false;

		// If something not defined,  then  this date closed ---------------------------------------------------------------
		if ( false === date_bookings_obj ){

			css_classes__for_date.push( 'date_user_unavailable' );

			return [ is_day_selectable, css_classes__for_date.join(' ')  ];
		}


		// -----------------------------------------------------------------------------------------------------------------
		//   date_bookings_obj  - Defined.            Dates can be selectable.
		// -----------------------------------------------------------------------------------------------------------------

		// -----------------------------------------------------------------------------------------------------------------
		// Add season names to the day CSS classes -- it is required for correct  work  of conditional fields --------------
		var season_names_arr = _wpbc.seasons__get_for_date( resource_id, sql_class_day );

		for ( var season_key in season_names_arr ){

			css_classes__for_date.push( season_names_arr[ season_key ] );				//  'wpdevbk_season_september_2023'
		}
		// -----------------------------------------------------------------------------------------------------------------


		// Cost Rate -------------------------------------------------------------------------------------------------------
		css_classes__for_date.push( 'rate_' + date_bookings_obj[ resource_id ][ 'date_cost_rate' ].toString().replace( /[\.\s]/g, '_' ) );						//  'rate_99_00' -> 99.00


		if ( parseInt( date_bookings_obj[ 'day_availability' ] ) > 0 ){
			is_day_selectable = true;
			css_classes__for_date.push( 'date_available' );
			css_classes__for_date.push( 'reserved_days_count' + parseInt( date_bookings_obj[ 'max_capacity' ] - date_bookings_obj[ 'day_availability' ] ) );
		} else {
			is_day_selectable = false;
			css_classes__for_date.push( 'date_user_unavailable' );
		}


		switch ( date_bookings_obj[ 'summary']['status_for_day' ] ){

			case 'available':
				break;

			case 'time_slots_booking':
				css_classes__for_date.push( 'timespartly', 'times_clock' );
				break;

			case 'full_day_booking':
				css_classes__for_date.push( 'full_day_booking' );
				break;

			case 'season_filter':
				css_classes__for_date.push( 'date_user_unavailable', 'season_unavailable' );
				date_bookings_obj[ 'summary']['status_for_bookings' ] = '';														// Reset booking status color for possible old bookings on this date
				break;

			case 'resource_availability':
				css_classes__for_date.push( 'date_user_unavailable', 'resource_unavailable' );
				date_bookings_obj[ 'summary']['status_for_bookings' ] = '';														// Reset booking status color for possible old bookings on this date
				break;

			case 'weekday_unavailable':
				css_classes__for_date.push( 'date_user_unavailable', 'weekday_unavailable' );
				date_bookings_obj[ 'summary']['status_for_bookings' ] = '';														// Reset booking status color for possible old bookings on this date
				break;

			case 'from_today_unavailable':
				css_classes__for_date.push( 'date_user_unavailable', 'from_today_unavailable' );
				date_bookings_obj[ 'summary']['status_for_bookings' ] = '';														// Reset booking status color for possible old bookings on this date
				break;

			case 'limit_available_from_today':
				css_classes__for_date.push( 'date_user_unavailable', 'limit_available_from_today' );
				date_bookings_obj[ 'summary']['status_for_bookings' ] = '';														// Reset booking status color for possible old bookings on this date
				break;

			case 'change_over':
				/*
				 *
				//  check_out_time_date2approve 	 	check_in_time_date2approve
				//  check_out_time_date2approve 	 	check_in_time_date_approved
				//  check_in_time_date2approve 		 	check_out_time_date_approved
				//  check_out_time_date_approved 	 	check_in_time_date_approved
				 */

				css_classes__for_date.push( 'timespartly', 'check_in_time', 'check_out_time' );
				//FixIn: 10.0.0.2
				if ( date_bookings_obj[ 'summary' ][ 'status_for_bookings' ].indexOf( 'approved_pending' ) > -1 ){
					css_classes__for_date.push( 'check_out_time_date_approved', 'check_in_time_date2approve' );
				}
				if ( date_bookings_obj[ 'summary' ][ 'status_for_bookings' ].indexOf( 'pending_approved' ) > -1 ){
					css_classes__for_date.push( 'check_out_time_date2approve', 'check_in_time_date_approved' );
				}
				break;

			case 'check_in':
				css_classes__for_date.push( 'timespartly', 'check_in_time' );

				//FixIn: 9.9.0.33
				if ( date_bookings_obj[ 'summary' ][ 'status_for_bookings' ].indexOf( 'pending' ) > -1 ){
					css_classes__for_date.push( 'check_in_time_date2approve' );
				} else if ( date_bookings_obj[ 'summary' ][ 'status_for_bookings' ].indexOf( 'approved' ) > -1 ){
					css_classes__for_date.push( 'check_in_time_date_approved' );
				}
				break;

			case 'check_out':
				css_classes__for_date.push( 'timespartly', 'check_out_time' );

				//FixIn: 9.9.0.33
				if ( date_bookings_obj[ 'summary' ][ 'status_for_bookings' ].indexOf( 'pending' ) > -1 ){
					css_classes__for_date.push( 'check_out_time_date2approve' );
				} else if ( date_bookings_obj[ 'summary' ][ 'status_for_bookings' ].indexOf( 'approved' ) > -1 ){
					css_classes__for_date.push( 'check_out_time_date_approved' );
				}
				break;

			default:
				// mixed statuses: 'change_over check_out' .... variations.... check more in 		function wpbc_get_availability_per_days_arr()
				date_bookings_obj[ 'summary']['status_for_day' ] = 'available';
		}



		if ( 'available' != date_bookings_obj[ 'summary']['status_for_day' ] ){

			var is_set_pending_days_selectable = _wpbc.calendar__get_param_value( resource_id, 'pending_days_selectable' );	// set pending days selectable          //FixIn: 8.6.1.18

			switch ( date_bookings_obj[ 'summary']['status_for_bookings' ] ){

				case '':
					// Usually  it's means that day  is available or unavailable without the bookings
					break;

				case 'pending':
					css_classes__for_date.push( 'date2approve' );
					is_day_selectable = (is_day_selectable) ? true : is_set_pending_days_selectable;
					break;

				case 'approved':
					css_classes__for_date.push( 'date_approved' );
					break;

				// Situations for "change-over" days: ----------------------------------------------------------------------
				case 'pending_pending':
					css_classes__for_date.push( 'check_out_time_date2approve', 'check_in_time_date2approve' );
					is_day_selectable = (is_day_selectable) ? true : is_set_pending_days_selectable;
					break;

				case 'pending_approved':
					css_classes__for_date.push( 'check_out_time_date2approve', 'check_in_time_date_approved' );
					is_day_selectable = (is_day_selectable) ? true : is_set_pending_days_selectable;
					break;

				case 'approved_pending':
					css_classes__for_date.push( 'check_out_time_date_approved', 'check_in_time_date2approve' );
					is_day_selectable = (is_day_selectable) ? true : is_set_pending_days_selectable;
					break;

				case 'approved_approved':
					css_classes__for_date.push( 'check_out_time_date_approved', 'check_in_time_date_approved' );
					break;

				default:

			}
		}

		return [ is_day_selectable, css_classes__for_date.join( ' ' ) ];
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
	function wpbc__calendar__on_hover_days( string_date, date, calendar_params_arr, datepick_this ) {

		if ( null === date ){ return false; }

		var class_day     = wpbc__get__td_class_date( date );																					// '1-9-2023'
		var sql_class_day = wpbc__get__sql_class_date( date );																					// '2023-01-09'
		var resource_id = ( 'undefined' !== typeof(calendar_params_arr[ 'resource_id' ]) ) ? calendar_params_arr[ 'resource_id' ] : '1';		// '1'

		// Get Data --------------------------------------------------------------------------------------------------------
		var date_booking_obj = _wpbc.bookings_in_calendar__get_for_date( resource_id, sql_class_day );											// {...}

		if ( ! date_booking_obj ){ return false; }


		// T o o l t i p s -------------------------------------------------------------------------------------------------
		var tooltip_text = '';
		if ( date_booking_obj[ 'summary']['tooltip_availability' ].length > 0 ){
			tooltip_text +=  date_booking_obj[ 'summary']['tooltip_availability' ];
		}
		if ( date_booking_obj[ 'summary']['tooltip_day_cost' ].length > 0 ){
			tooltip_text +=  date_booking_obj[ 'summary']['tooltip_day_cost' ];
		}
		if ( date_booking_obj[ 'summary']['tooltip_times' ].length > 0 ){
			tooltip_text +=  date_booking_obj[ 'summary']['tooltip_times' ];
		}
		if ( date_booking_obj[ 'summary']['tooltip_booking_details' ].length > 0 ){
			tooltip_text +=  date_booking_obj[ 'summary']['tooltip_booking_details' ];
		}
		wpbc_set_tooltip___for__calendar_date( tooltip_text, resource_id, class_day );



		//  U n h o v e r i n g    in    UNSELECTABLE_CALENDAR  ------------------------------------------------------------
		var is_unselectable_calendar = ( jQuery( '#calendar_booking_unselectable' + resource_id ).length > 0);				//FixIn: 8.0.1.2
		var is_booking_form_exist    = ( jQuery( '#booking_form_div' + resource_id ).length > 0 );

		if ( ( is_unselectable_calendar ) && ( ! is_booking_form_exist ) ){

			/**
			 *  Un Hover all dates in calendar (without the booking form), if only Availability Calendar here and we do not insert Booking form by mistake.
			 */

			wpbc_calendars__clear_days_highlighting( resource_id ); 							// Clear days highlighting

			var css_of_calendar = '.wpbc_only_calendar #calendar_booking' + resource_id;
			jQuery( css_of_calendar + ' .datepick-days-cell, '
				  + css_of_calendar + ' .datepick-days-cell a' ).css( 'cursor', 'default' );	// Set cursor to Default
			return false;
		}



		//  D a y s    H o v e r i n g  ------------------------------------------------------------------------------------
		if (
			   ( location.href.indexOf( 'page=wpbc' ) == -1 )
			|| ( location.href.indexOf( 'page=wpbc-new' ) > 0 )
			|| ( location.href.indexOf( 'page=wpbc-availability' ) > 0 )
			|| (  ( location.href.indexOf( 'page=wpbc-settings' ) > 0 )  &&
				  ( location.href.indexOf( '&tab=form' ) > 0 )
			   )
		){
			// The same as dates selection,  but for days hovering

			if ( 'function' == typeof( wpbc__calendar__do_days_highlight__bs ) ){
				wpbc__calendar__do_days_highlight__bs( sql_class_day, date, resource_id );
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
	function wpbc__calendar__on_select_days( date, calendar_params_arr, datepick_this ){

		var resource_id = ( 'undefined' !== typeof(calendar_params_arr[ 'resource_id' ]) ) ? calendar_params_arr[ 'resource_id' ] : '1';		// '1'

		// Set unselectable,  if only Availability Calendar  here (and we do not insert Booking form by mistake).
		var is_unselectable_calendar = ( jQuery( '#calendar_booking_unselectable' + resource_id ).length > 0);				//FixIn: 8.0.1.2
		var is_booking_form_exist    = ( jQuery( '#booking_form_div' + resource_id ).length > 0 );
		if ( ( is_unselectable_calendar ) && ( ! is_booking_form_exist ) ){
			wpbc_calendar__unselect_all_dates( resource_id );																			// Unselect Dates
			jQuery('.wpbc_only_calendar .popover_calendar_hover').remove();                      							// Hide all opened popovers
			return false;
		}

		jQuery( '#date_booking' + resource_id ).val( date );																// Add selected dates to  hidden textarea


		if ( 'function' === typeof (wpbc__calendar__do_days_select__bs) ){ wpbc__calendar__do_days_select__bs( date, resource_id ); }

		wpbc_disable_time_fields_in_booking_form( resource_id );

		// Hook -- trigger day selection -----------------------------------------------------------------------------------
		var mouse_clicked_dates = date;																						// Can be: "05.10.2023 - 07.10.2023"  |  "10.10.2023 - 10.10.2023"  |
		var all_selected_dates_arr = wpbc_get__selected_dates_sql__as_arr( resource_id );									// Can be: [ "2023-10-05", "2023-10-06", "2023-10-07", … ]
		jQuery( ".booking_form_div" ).trigger( "date_selected", [ resource_id, mouse_clicked_dates, all_selected_dates_arr ] );
	}

	// Mark middle selected dates with 0.5 opacity		//FixIn: 10.3.0.9
	jQuery( document ).ready( function (){
		jQuery( ".booking_form_div" ).on( 'date_selected', function ( event, resource_id, date ){
				if (
					   (  'fixed' === _wpbc.calendar__get_param_value( resource_id, 'days_select_mode' ))
					|| ('dynamic' === _wpbc.calendar__get_param_value( resource_id, 'days_select_mode' ))
				){
					var closed_timer = setTimeout( function (){
						var middle_days_opacity = _wpbc.get_other_param( 'calendars__days_selection__middle_days_opacity' );
						jQuery( '#calendar_booking' + resource_id + ' .datepick-current-day' ).not( ".selected_check_in_out" ).css( 'opacity', middle_days_opacity );
					}, 10 );
				}
		} );
	} );


	/**
	 * --  T i m e    F i e l d s     start  --------------------------------------------------------------------------
	 */

	/**
	 * Disable time slots in booking form depend on selected dates and booked dates/times
	 *
	 * @param resource_id
	 */
	function wpbc_disable_time_fields_in_booking_form( resource_id ){

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
		var time_fields_obj_arr = wpbc_get__time_fields__in_booking_form__as_arr( resource_id );

		// 2. Get all selected dates in  SQL format  like this [ "2023-08-23", "2023-08-24", "2023-08-25", ... ]
		var selected_dates_arr = wpbc_get__selected_dates_sql__as_arr( resource_id );

		// 3. Get child booking resources  or single booking resource  that  exist  in dates
		var child_resources_arr = wpbc_clone_obj( _wpbc.booking__get_param_value( resource_id, 'resources_id_arr__in_dates' ) );

		var sql_date;
		var child_resource_id;
		var merged_seconds;
		var time_fields_obj;
		var is_intersect;
		var is_check_in;

		// 4. Loop  all  time Fields options		//FixIn: 10.3.0.2
		for ( let field_key = 0; field_key < time_fields_obj_arr.length; field_key++ ){

			time_fields_obj_arr[ field_key ].disabled = 0;          // By default, this time field is not disabled

			time_fields_obj = time_fields_obj_arr[ field_key ];		// { times_as_seconds: [ 21600, 23400 ], value_option_24h: '06:00 - 06:30', name: 'rangetime2[]', jquery_option: jQuery_Object {}}

			// Loop  all  selected dates
			for ( var i = 0; i < selected_dates_arr.length; i++ ){

				//FixIn: 9.9.0.31
				if (
					   ( 'Off' === _wpbc.calendar__get_param_value( resource_id, 'booking_recurrent_time' ) )
					&& ( selected_dates_arr.length>1 )
				){
					//TODO: skip some fields checking if it's start / end time for mulple dates  selection  mode.
					//TODO: we need to fix situation  for entimes,  when  user  select  several  dates,  and in start  time booked 00:00 - 15:00 , but systsme block untill 15:00 the end time as well,  which  is wrong,  because it 2 or 3 dates selection  and end date can be fullu  available

					if ( (0 == i) && (time_fields_obj[ 'name' ].indexOf( 'endtime' ) >= 0) ){
						break;
					}
					if ( ( (selected_dates_arr.length-1) == i ) && (time_fields_obj[ 'name' ].indexOf( 'starttime' ) >= 0) ){
						break;
					}
				}

				// Get Date: '2023-08-18'
				sql_date = selected_dates_arr[ i ];


				var how_many_resources_intersected = 0;
				// Loop all resources ID
					// for ( var res_key in child_resources_arr ){	 						//FixIn: 10.3.0.2
				for ( let res_key = 0; res_key < child_resources_arr.length; res_key++ ){

					child_resource_id = child_resources_arr[ res_key ];

					// _wpbc.bookings_in_calendar__get_for_date(2,'2023-08-21')[12].booked_time_slots.merged_seconds		= [ "07:00:11 - 07:30:02", "10:00:11 - 00:00:00" ]
					// _wpbc.bookings_in_calendar__get_for_date(2,'2023-08-21')[2].booked_time_slots.merged_seconds			= [  [ 25211, 27002 ], [ 36011, 86400 ]  ]

					if ( false !== _wpbc.bookings_in_calendar__get_for_date( resource_id, sql_date ) ){
						merged_seconds = _wpbc.bookings_in_calendar__get_for_date( resource_id, sql_date )[ child_resource_id ].booked_time_slots.merged_seconds;		// [  [ 25211, 27002 ], [ 36011, 86400 ]  ]
					} else {
						merged_seconds = [];
					}
					if ( time_fields_obj.times_as_seconds.length > 1 ){
						is_intersect = wpbc_is_intersect__range_time_interval(  [
																					[
																						( parseInt( time_fields_obj.times_as_seconds[0] ) + 20 ),
																						( parseInt( time_fields_obj.times_as_seconds[1] ) - 20 )
																					]
																				]
																				, merged_seconds );
					} else {
						is_check_in = (-1 !== time_fields_obj.name.indexOf( 'start' ));
						is_intersect = wpbc_is_intersect__one_time_interval(
																				( ( is_check_in )
																							  ? parseInt( time_fields_obj.times_as_seconds ) + 20
																							  : parseInt( time_fields_obj.times_as_seconds ) - 20
																				)
																				, merged_seconds );
					}
					if (is_intersect){
						how_many_resources_intersected++;			// Increase
					}

				}

				if ( child_resources_arr.length == how_many_resources_intersected ) {
					// All resources intersected,  then  it's means that this time-slot or time must  be  Disabled, and we can  exist  from   selected_dates_arr LOOP

					time_fields_obj_arr[ field_key ].disabled = 1;
					break;											// exist  from   Dates LOOP
				}
			}
		}


		// 5. Now we can disable time slot in HTML by  using  ( field.disabled == 1 ) property
		wpbc__html__time_field_options__set_disabled( time_fields_obj_arr );

		jQuery( ".booking_form_div" ).trigger( 'wpbc_hook_timeslots_disabled', [resource_id, selected_dates_arr] );					// Trigger hook on disabling timeslots.		Usage: 	jQuery( ".booking_form_div" ).on( 'wpbc_hook_timeslots_disabled', function ( event, bk_type, all_dates ){ ... } );		//FixIn: 8.7.11.9
	}

		/**
		 * Is number inside /intersect  of array of intervals ?
		 *
		 * @param time_A		     	- 25800
		 * @param time_interval_B		- [  [ 25211, 27002 ], [ 36011, 86400 ]  ]
		 * @returns {boolean}
		 */
		function wpbc_is_intersect__one_time_interval( time_A, time_interval_B ){

			for ( var j = 0; j < time_interval_B.length; j++ ){

				if ( (parseInt( time_A ) > parseInt( time_interval_B[ j ][ 0 ] )) && (parseInt( time_A ) < parseInt( time_interval_B[ j ][ 1 ] )) ){
					return true
				}

				// if ( ( parseInt( time_A ) == parseInt( time_interval_B[ j ][ 0 ] ) ) || ( parseInt( time_A ) == parseInt( time_interval_B[ j ][ 1 ] ) ) ) {
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
		function wpbc_is_intersect__range_time_interval( time_interval_A, time_interval_B ){

			var is_intersect;

			for ( var i = 0; i < time_interval_A.length; i++ ){

				for ( var j = 0; j < time_interval_B.length; j++ ){

					is_intersect = wpbc_intervals__is_intersected( time_interval_A[ i ], time_interval_B[ j ] );

					if ( is_intersect ){
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
		function wpbc_get__time_fields__in_booking_form__as_arr( resource_id ){
		    /**
			 * Fields with  []  like this   select[name="rangetime1[]"]
			 * it's when we have 'multiple' in shortcode:   [select* rangetime multiple  "06:00 - 06:30" ... ]
			 */
			var time_fields_arr=[
									'select[name="rangetime' + resource_id + '"]',
									'select[name="rangetime' + resource_id + '[]"]',
									'select[name="starttime' + resource_id + '"]',
									'select[name="starttime' + resource_id + '[]"]',
									'select[name="endtime' + resource_id + '"]',
									'select[name="endtime' + resource_id + '[]"]'
								];

			var time_fields_obj_arr = [];

			// Loop all Time Fields
			for ( var ctf= 0; ctf < time_fields_arr.length; ctf++ ){

				var time_field = time_fields_arr[ ctf ];
				var time_option = jQuery( time_field + ' option' );

				// Loop all options in time field
				for ( var j = 0; j < time_option.length; j++ ){

					var jquery_option = jQuery( time_field + ' option:eq(' + j + ')' );
					var value_option_seconds_arr = jquery_option.val().split( '-' );
					var times_as_seconds = [];

					// Get time as seconds
					if ( value_option_seconds_arr.length ){									//FixIn: 9.8.10.1
						for ( let i = 0; i < value_option_seconds_arr.length; i++ ){		//FixIn: 10.0.0.56
							// value_option_seconds_arr[i] = '14:00 '  | ' 16:00'   (if from 'rangetime') and '16:00'  if (start/end time)

							var start_end_times_arr = value_option_seconds_arr[ i ].trim().split( ':' );

							var time_in_seconds = parseInt( start_end_times_arr[ 0 ] ) * 60 * 60 + parseInt( start_end_times_arr[ 1 ] ) * 60;

							times_as_seconds.push( time_in_seconds );
						}
					}

					time_fields_obj_arr.push( {
												'name'            : jQuery( time_field ).attr( 'name' ),
												'value_option_24h': jquery_option.val(),
												'jquery_option'   : jquery_option,
												'times_as_seconds': times_as_seconds
											} );
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
			function wpbc__html__time_field_options__set_disabled( time_fields_obj_arr ){

				var jquery_option;

				for ( var i = 0; i < time_fields_obj_arr.length; i++ ){

					var jquery_option = time_fields_obj_arr[ i ].jquery_option;

					if ( 1 == time_fields_obj_arr[ i ].disabled ){
						jquery_option.prop( 'disabled', true ); 		// Make disable some options
						jquery_option.addClass( 'booked' );           	// Add "booked" CSS class

						// if this booked element selected --> then deselect  it
						if ( jquery_option.prop( 'selected' ) ){
							jquery_option.prop( 'selected', false );

							jquery_option.parent().find( 'option:not([disabled]):first' ).prop( 'selected', true ).trigger( "change" );
						}

					} else {
						jquery_option.prop( 'disabled', false );  		// Make active all times
						jquery_option.removeClass( 'booked' );   		// Remove class "booked"
					}
				}

			}

	/**
	 * Check if this time_range | Time_Slot is Full Day  booked
	 *
	 * @param timeslot_arr_in_seconds		- [ 36011, 86400 ]
	 * @returns {boolean}
	 */
	function wpbc_is_this_timeslot__full_day_booked( timeslot_arr_in_seconds ){

		if (
				( timeslot_arr_in_seconds.length > 1 )
			&& ( parseInt( timeslot_arr_in_seconds[ 0 ] ) < 30 )
			&& ( parseInt( timeslot_arr_in_seconds[ 1 ] ) >  ( (24 * 60 * 60) - 30) )
		){
			return true;
		}

		return false;
	}


	// -----------------------------------------------------------------------------------------------------------------
	/*  ==  S e l e c t e d    D a t e s  /  T i m e - F i e l d s  ==
	// ----------------------------------------------------------------------------------------------------------------- */

	/**
	 *  Get all selected dates in SQL format like this [ "2023-08-23", "2023-08-24" , ... ]
	 *
	 * @param resource_id
	 * @returns {[]}			[ "2023-08-23", "2023-08-24", "2023-08-25", "2023-08-26", "2023-08-27", "2023-08-28", "2023-08-29" ]
	 */
	function wpbc_get__selected_dates_sql__as_arr( resource_id ){

		var selected_dates_arr = [];
		selected_dates_arr = jQuery( '#date_booking' + resource_id ).val().split(',');

		if ( selected_dates_arr.length ){												//FixIn: 9.8.10.1
			for ( let i = 0; i < selected_dates_arr.length; i++ ){						//FixIn: 10.0.0.56
				selected_dates_arr[ i ] = selected_dates_arr[ i ].trim();
				selected_dates_arr[ i ] = selected_dates_arr[ i ].split( '.' );
				if ( selected_dates_arr[ i ].length > 1 ){
					selected_dates_arr[ i ] = selected_dates_arr[ i ][ 2 ] + '-' + selected_dates_arr[ i ][ 1 ] + '-' + selected_dates_arr[ i ][ 0 ];
				}
			}
		}

		// Remove empty elements from an array
		selected_dates_arr = selected_dates_arr.filter( function ( n ){ return parseInt(n); } );

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
	function wpbc_get__selected_time_fields__in_booking_form__as_arr( resource_id, is_only_selected_time = true ){
		/**
		 * Fields with  []  like this   select[name="rangetime1[]"]
		 * it's when we have 'multiple' in shortcode:   [select* rangetime multiple  "06:00 - 06:30" ... ]
		 */
		var time_fields_arr=[
								'select[name="rangetime' + resource_id + '"]',
								'select[name="rangetime' + resource_id + '[]"]',
								'select[name="starttime' + resource_id + '"]',
								'select[name="starttime' + resource_id + '[]"]',
								'select[name="endtime' + resource_id + '"]',
								'select[name="endtime' + resource_id + '[]"]',
								'select[name="durationtime' + resource_id + '"]',
								'select[name="durationtime' + resource_id + '[]"]'
							];

		var time_fields_obj_arr = [];

		// Loop all Time Fields
		for ( var ctf= 0; ctf < time_fields_arr.length; ctf++ ){

			var time_field = time_fields_arr[ ctf ];

			var time_option;
			if ( is_only_selected_time ){
				time_option = jQuery( '#booking_form' + resource_id + ' ' + time_field + ' option:selected' );			// Exclude conditional  fields,  because of using '#booking_form3 ...'
			} else {
				time_option = jQuery( '#booking_form' + resource_id + ' ' + time_field + ' option' );				// All  time fields
			}


			// Loop all options in time field
			for ( var j = 0; j < time_option.length; j++ ){

				var jquery_option = jQuery( time_option[ j ] );		// Get only  selected options 	//jQuery( time_field + ' option:eq(' + j + ')' );
				var value_option_seconds_arr = jquery_option.val().split( '-' );
				var times_as_seconds = [];

				// Get time as seconds
				if ( value_option_seconds_arr.length ){				 								//FixIn: 9.8.10.1
					for ( let i = 0; i < value_option_seconds_arr.length; i++ ){					//FixIn: 10.0.0.56
						// value_option_seconds_arr[i] = '14:00 '  | ' 16:00'   (if from 'rangetime') and '16:00'  if (start/end time)

						var start_end_times_arr = value_option_seconds_arr[ i ].trim().split( ':' );

						var time_in_seconds = parseInt( start_end_times_arr[ 0 ] ) * 60 * 60 + parseInt( start_end_times_arr[ 1 ] ) * 60;

						times_as_seconds.push( time_in_seconds );
					}
				}

				time_fields_obj_arr.push( {
											'name'            : jQuery( '#booking_form' + resource_id + ' ' + time_field ).attr( 'name' ),
											'value_option_24h': jquery_option.val(),
											'jquery_option'   : jquery_option,
											'times_as_seconds': times_as_seconds
										} );
			}
		}

		// Text:   [starttime] - [endtime] -----------------------------------------------------------------------------

		var text_time_fields_arr=[
									'input[name="starttime' + resource_id + '"]',
									'input[name="endtime' + resource_id + '"]',
								];
		for ( var tf= 0; tf < text_time_fields_arr.length; tf++ ){

			var text_jquery = jQuery( '#booking_form' + resource_id + ' ' + text_time_fields_arr[ tf ] );								// Exclude conditional  fields,  because of using '#booking_form3 ...'
			if ( text_jquery.length > 0 ){

				var time__h_m__arr = text_jquery.val().trim().split( ':' );														// '14:00'
				if ( 0 == time__h_m__arr.length ){
					continue;									// Not entered time value in a field
				}
				if ( 1 == time__h_m__arr.length ){
					if ( '' === time__h_m__arr[ 0 ] ){
						continue;								// Not entered time value in a field
					}
					time__h_m__arr[ 1 ] = 0;
				}
				var text_time_in_seconds = parseInt( time__h_m__arr[ 0 ] ) * 60 * 60 + parseInt( time__h_m__arr[ 1 ] ) * 60;

				var text_times_as_seconds = [];
				text_times_as_seconds.push( text_time_in_seconds );

				time_fields_obj_arr.push( {
											'name'            : text_jquery.attr( 'name' ),
											'value_option_24h': text_jquery.val(),
											'jquery_option'   : text_jquery,
											'times_as_seconds': text_times_as_seconds
										} );
			}
		}

		return time_fields_obj_arr;
	}



// ---------------------------------------------------------------------------------------------------------------------
/*  ==  S U P P O R T    for    C A L E N D A R  ==
// --------------------------------------------------------------------------------------------------------------------- */

	/**
	 * Get Calendar datepick  Instance
	 * @param resource_id  of booking resource
	 * @returns {*|null}
	 */
	function wpbc_calendar__get_inst( resource_id ){

		if ( 'undefined' === typeof (resource_id) ){
			resource_id = '1';
		}

		if ( jQuery( '#calendar_booking' + resource_id ).length > 0 ){
			return jQuery.datepick._getInst( jQuery( '#calendar_booking' + resource_id ).get( 0 ) );
		}

		return null;
	}

	/**
	 * Unselect  all dates in calendar and visually update this calendar
	 *
	 * @param resource_id		ID of booking resource
	 * @returns {boolean}		true on success | false,  if no such  calendar
	 */
	function wpbc_calendar__unselect_all_dates( resource_id ){

		if ( 'undefined' === typeof (resource_id) ){
			resource_id = '1';
		}

		var inst = wpbc_calendar__get_inst( resource_id )

		if ( null !== inst ){

			// Unselect all dates and set  properties of Datepick
			jQuery( '#date_booking' + resource_id ).val( '' );      //FixIn: 5.4.3
			inst.stayOpen = false;
			inst.dates = [];
			jQuery.datepick._updateDatepick( inst );

			return true
		}

		return false;

	}

	/**
	 * Clear days highlighting in All or specific Calendars
	 *
     * @param resource_id  - can be skiped to  clear highlighting in all calendars
     */
	function wpbc_calendars__clear_days_highlighting( resource_id ){

		if ( 'undefined' !== typeof ( resource_id ) ){

			jQuery( '#calendar_booking' + resource_id + ' .datepick-days-cell-over' ).removeClass( 'datepick-days-cell-over' );		// Clear in specific calendar

		} else {
			jQuery( '.datepick-days-cell-over' ).removeClass( 'datepick-days-cell-over' );								// Clear in all calendars
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
	function wpbc_calendar__scroll_to( resource_id, year, month ){

		if ( 'undefined' === typeof (resource_id) ){ resource_id = '1'; }
		var inst = wpbc_calendar__get_inst( resource_id )
		if ( null !== inst ){

			year  = parseInt( year );
			month = parseInt( month ) - 1;		// In JS date,  month -1

			inst.cursorDate = new Date();
			// In some cases,  the setFullYear can  set  only Year,  and not the Month and day      //FixIn:6.2.3.5
			inst.cursorDate.setFullYear( year, month, 1 );
			inst.cursorDate.setMonth( month );
			inst.cursorDate.setDate( 1 );

			inst.drawMonth = inst.cursorDate.getMonth();
			inst.drawYear = inst.cursorDate.getFullYear();

			jQuery.datepick._notifyChange( inst );
			jQuery.datepick._adjustInstDate( inst );
			jQuery.datepick._showDate( inst );
			jQuery.datepick._updateDatepick( inst );

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
	function wpbc_is_this_day_selectable( resource_id, sql_class_day ){

		// Get Data --------------------------------------------------------------------------------------------------------
		var date_bookings_obj = _wpbc.bookings_in_calendar__get_for_date( resource_id, sql_class_day );

		var is_day_selectable = ( parseInt( date_bookings_obj[ 'day_availability' ] ) > 0 );

		if ( typeof (date_bookings_obj[ 'summary' ]) === 'undefined' ){
			return is_day_selectable;
		}

		if ( 'available' != date_bookings_obj[ 'summary']['status_for_day' ] ){

			var is_set_pending_days_selectable = _wpbc.calendar__get_param_value( resource_id, 'pending_days_selectable' );		// set pending days selectable          //FixIn: 8.6.1.18

			switch ( date_bookings_obj[ 'summary']['status_for_bookings' ] ){
				case 'pending':
				// Situations for "change-over" days:
				case 'pending_pending':
				case 'pending_approved':
				case 'approved_pending':
					is_day_selectable = (is_day_selectable) ? true : is_set_pending_days_selectable;
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
	function wpbc_is_this_day_among_selected_days( js_date_to_check, js_dates_arr ){

		for ( var date_index = 0; date_index < js_dates_arr.length ; date_index++ ){     									//FixIn: 8.4.5.16
			if ( ( js_dates_arr[ date_index ].getFullYear() === js_date_to_check.getFullYear() ) &&
				 ( js_dates_arr[ date_index ].getMonth() === js_date_to_check.getMonth() ) &&
				 ( js_dates_arr[ date_index ].getDate() === js_date_to_check.getDate() ) ) {
					return true;
			}
		}

		return  false;
	}

	/**
	 * Get SQL Class Date '2023-08-01' from  JS Date
	 *
	 * @param date				JS Date
	 * @returns {string}		'2023-08-12'
	 */
	function wpbc__get__sql_class_date( date ){

		var sql_class_day = date.getFullYear() + '-';
			sql_class_day += ( ( date.getMonth() + 1 ) < 10 ) ? '0' : '';
			sql_class_day += ( date.getMonth() + 1 ) + '-'
			sql_class_day += ( date.getDate() < 10 ) ? '0' : '';
			sql_class_day += date.getDate();

			return sql_class_day;
	}

	/**
	 * Get JS Date from  the SQL date format '2024-05-14'
	 * @param sql_class_date
	 * @returns {Date}
	 */
	function wpbc__get__js_date( sql_class_date ){

		var sql_class_date_arr = sql_class_date.split( '-' );

		var date_js = new Date();

		date_js.setFullYear( parseInt( sql_class_date_arr[ 0 ] ), (parseInt( sql_class_date_arr[ 1 ] ) - 1), parseInt( sql_class_date_arr[ 2 ] ) );  // year, month, date

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
	function wpbc__get__td_class_date( date ){

		var td_class_day = (date.getMonth() + 1) + '-' + date.getDate() + '-' + date.getFullYear();								// '1-9-2023'

		return td_class_day;
	}

	/**
	 * Get date params from  string date
	 *
	 * @param date			string date like '31.5.2023'
	 * @param separator		default '.'  can be skipped.
	 * @returns {  {date: number, month: number, year: number}  }
	 */
	function wpbc__get__date_params__from_string_date( date , separator){

		separator = ( 'undefined' !== typeof (separator) ) ? separator : '.';

		var date_arr = date.split( separator );
		var date_obj = {
			'year' :  parseInt( date_arr[ 2 ] ),
			'month': (parseInt( date_arr[ 1 ] ) - 1),
			'date' :  parseInt( date_arr[ 0 ] )
		};
		return date_obj;		// for 		 = new Date( date_obj.year , date_obj.month , date_obj.date );
	}

	/**
	 * Add Spin Loader to  calendar
	 * @param resource_id
	 */
	function wpbc_calendar__loading__start( resource_id ){
		if ( ! jQuery( '#calendar_booking' + resource_id ).next().hasClass( 'wpbc_spins_loader_wrapper' ) ){
			jQuery( '#calendar_booking' + resource_id ).after( '<div class="wpbc_spins_loader_wrapper"><div class="wpbc_spins_loader"></div></div>' );
		}
		if ( ! jQuery( '#calendar_booking' + resource_id ).hasClass( 'wpbc_calendar_blur_small' ) ){
			jQuery( '#calendar_booking' + resource_id ).addClass( 'wpbc_calendar_blur_small' );
		}
		wpbc_calendar__blur__start( resource_id );
	}

	/**
	 * Remove Spin Loader to  calendar
	 * @param resource_id
	 */
	function wpbc_calendar__loading__stop( resource_id ){
		jQuery( '#calendar_booking' + resource_id + ' + .wpbc_spins_loader_wrapper' ).remove();
		jQuery( '#calendar_booking' + resource_id ).removeClass( 'wpbc_calendar_blur_small' );
		wpbc_calendar__blur__stop( resource_id );
	}

	/**
	 * Add Blur to  calendar
	 * @param resource_id
	 */
	function wpbc_calendar__blur__start( resource_id ){
		if ( ! jQuery( '#calendar_booking' + resource_id ).hasClass( 'wpbc_calendar_blur' ) ){
			jQuery( '#calendar_booking' + resource_id ).addClass( 'wpbc_calendar_blur' );
		}
	}

	/**
	 * Remove Blur in  calendar
	 * @param resource_id
	 */
	function wpbc_calendar__blur__stop( resource_id ){
		jQuery( '#calendar_booking' + resource_id ).removeClass( 'wpbc_calendar_blur' );
	}


	// .................................................................................................................
	/*  ==  Calendar Update  - View  ==
	// ................................................................................................................. */

	/**
	 * Update Look  of calendar
	 *
	 * @param resource_id
	 */
	function wpbc_calendar__update_look( resource_id ){

		var inst = wpbc_calendar__get_inst( resource_id );

		jQuery.datepick._updateDatepick( inst );
	}


	/**
	 * Update dynamically Number of Months in calendar
	 *
	 * @param resource_id int
	 * @param months_number int
	 */
	function wpbc_calendar__update_months_number( resource_id, months_number ){
		var inst = wpbc_calendar__get_inst( resource_id );
		if ( null !== inst ){
			inst.settings[ 'numberOfMonths' ] = months_number;
			//_wpbc.calendar__set_param_value( resource_id, 'calendar_number_of_months', months_number );
			wpbc_calendar__update_look( resource_id );
		}
	}


	/**
	 * Show calendar in  different Skin
	 *
	 * @param selected_skin_url
	 */
	function wpbc__calendar__change_skin( selected_skin_url ){

	//console.log( 'SKIN SELECTION ::', selected_skin_url );

		// Remove CSS skin
		var stylesheet = document.getElementById( 'wpbc-calendar-skin-css' );
		stylesheet.parentNode.removeChild( stylesheet );


		// Add new CSS skin
		var headID = document.getElementsByTagName( "head" )[ 0 ];
		var cssNode = document.createElement( 'link' );
		cssNode.type = 'text/css';
		cssNode.setAttribute( "id", "wpbc-calendar-skin-css" );
		cssNode.rel = 'stylesheet';
		cssNode.media = 'screen';
		cssNode.href = selected_skin_url;	//"http://beta/wp-content/plugins/booking/css/skins/green-01.css";
		headID.appendChild( cssNode );
	}


	function wpbc__css__change_skin( selected_skin_url, stylesheet_id = 'wpbc-time_picker-skin-css' ){

		// Remove CSS skin
		var stylesheet = document.getElementById( stylesheet_id );
		stylesheet.parentNode.removeChild( stylesheet );


		// Add new CSS skin
		var headID = document.getElementsByTagName( "head" )[ 0 ];
		var cssNode = document.createElement( 'link' );
		cssNode.type = 'text/css';
		cssNode.setAttribute( "id", stylesheet_id );
		cssNode.rel = 'stylesheet';
		cssNode.media = 'screen';
		cssNode.href = selected_skin_url;	//"http://beta/wp-content/plugins/booking/css/skins/green-01.css";
		headID.appendChild( cssNode );
	}


// ---------------------------------------------------------------------------------------------------------------------
/*  ==  S U P P O R T    M A T H  ==
// --------------------------------------------------------------------------------------------------------------------- */

		/**
		 * Merge several  intersected intervals or return not intersected:                        [[1,3],[2,6],[8,10],[15,18]]  ->   [[1,6],[8,10],[15,18]]
		 *
		 * @param [] intervals			 [ [1,3],[2,4],[6,8],[9,10],[3,7] ]
		 * @returns []					 [ [1,8],[9,10] ]
		 *
		 * Exmample: wpbc_intervals__merge_inersected(  [ [1,3],[2,4],[6,8],[9,10],[3,7] ]  );
		 */
		function wpbc_intervals__merge_inersected( intervals ){

			if ( ! intervals || intervals.length === 0 ){
				return [];
			}

			var merged = [];
			intervals.sort( function ( a, b ){
				return a[ 0 ] - b[ 0 ];
			} );

			var mergedInterval = intervals[ 0 ];

			for ( var i = 1; i < intervals.length; i++ ){
				var interval = intervals[ i ];

				if ( interval[ 0 ] <= mergedInterval[ 1 ] ){
					mergedInterval[ 1 ] = Math.max( mergedInterval[ 1 ], interval[ 1 ] );
				} else {
					merged.push( mergedInterval );
					mergedInterval = interval;
				}
			}

			merged.push( mergedInterval );
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
		function wpbc_intervals__is_intersected( interval_A, interval_B ) {

			if (
					( 0 == interval_A.length )
				 || ( 0 == interval_B.length )
			){
				return false;
			}

			interval_A[ 0 ] = parseInt( interval_A[ 0 ] );
			interval_A[ 1 ] = parseInt( interval_A[ 1 ] );
			interval_B[ 0 ] = parseInt( interval_B[ 0 ] );
			interval_B[ 1 ] = parseInt( interval_B[ 1 ] );

			var is_intersected = Math.max( interval_A[ 0 ], interval_B[ 0 ] ) - Math.min( interval_A[ 1 ], interval_B[ 1 ] );

			// if ( 0 == is_intersected ) {
			//	                                 // Such ranges going one after other, e.g.: [ 12, 15 ] and [ 15, 21 ]
			// }

			if ( is_intersected < 0 ) {
				return true;                     // INTERSECTED
			}

			return false;                       // Not intersected
		}


		/**
		 * Get the closets ABS value of element in array to the current myValue
		 *
		 * @param myValue 	- int element to search closet 			4
		 * @param myArray	- array of elements where to search 	[5,8,1,7]
		 * @returns int												5
		 */
		function wpbc_get_abs_closest_value_in_arr( myValue, myArray ){

			if ( myArray.length == 0 ){ 								// If the array is empty -> return  the myValue
				return myValue;
			}

			var obj = myArray[ 0 ];
			var diff = Math.abs( myValue - obj );             	// Get distance between  1st element
			var closetValue = myArray[ 0 ];                   			// Save 1st element

			for ( var i = 1; i < myArray.length; i++ ){
				obj = myArray[ i ];

				if ( Math.abs( myValue - obj ) < diff ){     			// we found closer value -> save it
					diff = Math.abs( myValue - obj );
					closetValue = obj;
				}
			}

			return closetValue;
		}


// ---------------------------------------------------------------------------------------------------------------------
/*  ==  T O O L T I P S  ==
// --------------------------------------------------------------------------------------------------------------------- */

	/**
	 * Define tooltip to show,  when  mouse over Date in Calendar
	 *
	 * @param  tooltip_text			- Text to show				'Booked time: 12:00 - 13:00<br>Cost: $20.00'
	 * @param  resource_id			- ID of booking resource	'1'
	 * @param  td_class				- SQL class					'1-9-2023'
	 * @returns {boolean}					- defined to show or not
	 */
	function wpbc_set_tooltip___for__calendar_date( tooltip_text, resource_id, td_class ){

		//TODO: make escaping of text for quot symbols,  and JS/HTML...

		jQuery( '#calendar_booking' + resource_id + ' td.cal4date-' + td_class ).attr( 'data-content', tooltip_text );

		var td_el = jQuery( '#calendar_booking' + resource_id + ' td.cal4date-' + td_class ).get( 0 );					//FixIn: 9.0.1.1

		if (
			   ( 'undefined' !== typeof(td_el) )
			&& ( undefined == td_el._tippy )
			&& ( '' !== tooltip_text )
		){

			wpbc_tippy( td_el , {
					content( reference ){

						var popover_content = reference.getAttribute( 'data-content' );

						return '<div class="popover popover_tippy">'
									+ '<div class="popover-content">'
										+ popover_content
									+ '</div>'
							 + '</div>';
					},
					allowHTML        : true,
					trigger			 : 'mouseenter focus',
					interactive      : false,
					hideOnClick      : true,
					interactiveBorder: 10,
					maxWidth         : 550,
					theme            : 'wpbc-tippy-times',
					placement        : 'top',
					delay			 : [400, 0],																		//FixIn: 9.4.2.2
					//delay			 : [0, 9999999999],						// Debuge  tooltip
					ignoreAttributes : true,
					touch			 : true,								//['hold', 500], // 500ms delay				//FixIn: 9.2.1.5
					appendTo: () => document.body,
			});

			return  true;
		}

		return  false;
	}


// ---------------------------------------------------------------------------------------------------------------------
/*  ==  Dates Functions  ==
// --------------------------------------------------------------------------------------------------------------------- */

/**
 * Get number of dates between 2 JS Dates
 *
 * @param date1		JS Date
 * @param date2		JS Date
 * @returns {number}
 */
function wpbc_dates__days_between(date1, date2) {

    // The number of milliseconds in one day
    var ONE_DAY = 1000 * 60 * 60 * 24;

    // Convert both dates to milliseconds
    var date1_ms = date1.getTime();
    var date2_ms = date2.getTime();

    // Calculate the difference in milliseconds
    var difference_ms =  date1_ms - date2_ms;

    // Convert back to days and return
    return Math.round(difference_ms/ONE_DAY);
}


/**
 * Check  if this array  of dates is consecutive array  of dates or not.
 * 		e.g.  ['2024-05-09','2024-05-19','2024-05-30'] -> false
 * 		e.g.  ['2024-05-09','2024-05-10','2024-05-11'] -> true
 * @param sql_dates_arr	 array		e.g.: ['2024-05-09','2024-05-19','2024-05-30']
 * @returns {boolean}
 */
function wpbc_dates__is_consecutive_dates_arr_range( sql_dates_arr ){													//FixIn: 10.0.0.50

	if ( sql_dates_arr.length > 1 ){
		var previos_date = wpbc__get__js_date( sql_dates_arr[ 0 ] );
		var current_date;

		for ( var i = 1; i < sql_dates_arr.length; i++ ){
			current_date = wpbc__get__js_date( sql_dates_arr[i] );

			if ( wpbc_dates__days_between( current_date, previos_date ) != 1 ){
				return  false;
			}

			previos_date = current_date;
		}
	}

	return true;
}


// ---------------------------------------------------------------------------------------------------------------------
/*  ==  Auto Dates Selection  ==
// --------------------------------------------------------------------------------------------------------------------- */

/**
 *  == How to  use ? ==
 *
 *  For Dates selection, we need to use this logic!     We need select the dates only after booking data loaded!
 *
 *  Check example bellow.
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
function wpbc_auto_select_dates_in_calendar( resource_id, check_in_ymd, check_out_ymd = '' ){								//FixIn: 10.0.0.47

	console.log( 'WPBC_AUTO_SELECT_DATES_IN_CALENDAR( RESOURCE_ID, CHECK_IN_YMD, CHECK_OUT_YMD )', resource_id, check_in_ymd, check_out_ymd );

	if (
		   ( '2100-01-01' == check_in_ymd )
		|| ( '2100-01-01' == check_out_ymd )
		|| ( ( '' == check_in_ymd ) && ( '' == check_out_ymd ) )
	){
		return 0;
	}

	// -----------------------------------------------------------------------------------------------------------------
	// If 	check_in_ymd  =  [ '2024-05-09','2024-05-19','2024-05-30' ]				ARRAY of DATES						//FixIn: 10.0.0.50
	// -----------------------------------------------------------------------------------------------------------------
	var dates_to_select_arr = [];
	if ( Array.isArray( check_in_ymd ) ){
		dates_to_select_arr = wpbc_clone_obj( check_in_ymd );

		// -------------------------------------------------------------------------------------------------------------
		// Exceptions to  set  	MULTIPLE DAYS 	mode
		// -------------------------------------------------------------------------------------------------------------
		// if dates as NOT CONSECUTIVE: ['2024-05-09','2024-05-19','2024-05-30'], -> set MULTIPLE DAYS mode
		if (
			   ( dates_to_select_arr.length > 0 )
			&& ( '' == check_out_ymd )
			&& ( ! wpbc_dates__is_consecutive_dates_arr_range( dates_to_select_arr ) )
		){
			wpbc_cal_days_select__multiple( resource_id );
		}
		// if multiple days to select, but enabled SINGLE day mode, -> set MULTIPLE DAYS mode
		if (
			   ( dates_to_select_arr.length > 1 )
			&& ( '' == check_out_ymd )
			&& ( 'single' === _wpbc.calendar__get_param_value( resource_id, 'days_select_mode' ) )
		){
			wpbc_cal_days_select__multiple( resource_id );
		}
		// -------------------------------------------------------------------------------------------------------------
		check_in_ymd = dates_to_select_arr[ 0 ];
		if ( '' == check_out_ymd ){
			check_out_ymd = dates_to_select_arr[ (dates_to_select_arr.length-1) ];
		}
	}
	// -----------------------------------------------------------------------------------------------------------------


	if ( '' == check_in_ymd ){
		check_in_ymd = check_out_ymd;
	}
	if ( '' == check_out_ymd ){
		check_out_ymd = check_in_ymd;
	}

	if ( 'undefined' === typeof (resource_id) ){
		resource_id = '1';
	}


	var inst = wpbc_calendar__get_inst( resource_id );

	if ( null !== inst ){

		// Unselect all dates and set  properties of Datepick
		jQuery( '#date_booking' + resource_id ).val( '' );      														//FixIn: 5.4.3
		inst.stayOpen = false;
		inst.dates = [];
		var check_in_js = wpbc__get__js_date( check_in_ymd );
		var td_cell     = wpbc_get_clicked_td( inst.id, check_in_js );

		// Is ome type of error, then select multiple days selection  mode.
		if ( '' === _wpbc.calendar__get_param_value( resource_id, 'days_select_mode' ) ) {
 			_wpbc.calendar__set_param_value( resource_id, 'days_select_mode', 'multiple' );
		}


		// ---------------------------------------------------------------------------------------------------------
		//  == DYNAMIC ==
		if ( 'dynamic' === _wpbc.calendar__get_param_value( resource_id, 'days_select_mode' ) ){
			// 1-st click
			inst.stayOpen = false;
			jQuery.datepick._selectDay( td_cell, '#' + inst.id, check_in_js.getTime() );
			if ( 0 === inst.dates.length ){
				return 0;  								// First click  was unsuccessful, so we must not make other click
			}

			// 2-nd click
			var check_out_js = wpbc__get__js_date( check_out_ymd );
			var td_cell_out = wpbc_get_clicked_td( inst.id, check_out_js );
			inst.stayOpen = true;
			jQuery.datepick._selectDay( td_cell_out, '#' + inst.id, check_out_js.getTime() );
		}

		// ---------------------------------------------------------------------------------------------------------
		//  == FIXED ==
		if (  'fixed' === _wpbc.calendar__get_param_value( resource_id, 'days_select_mode' )) {
			jQuery.datepick._selectDay( td_cell, '#' + inst.id, check_in_js.getTime() );
		}

		// ---------------------------------------------------------------------------------------------------------
		//  == SINGLE ==
		if ( 'single' === _wpbc.calendar__get_param_value( resource_id, 'days_select_mode' ) ){
			//jQuery.datepick._restrictMinMax( inst, jQuery.datepick._determineDate( inst, check_in_js, null ) );		// Do we need to run  this ? Please note, check_in_js must  have time,  min, sec defined to 0!
			jQuery.datepick._selectDay( td_cell, '#' + inst.id, check_in_js.getTime() );
		}

		// ---------------------------------------------------------------------------------------------------------
		//  == MULTIPLE ==
		if ( 'multiple' === _wpbc.calendar__get_param_value( resource_id, 'days_select_mode' ) ){

			var dates_arr;

			if ( dates_to_select_arr.length > 0 ){
				// Situation, when we have dates array: ['2024-05-09','2024-05-19','2024-05-30'].  and not the Check In / Check  out dates as parameter in this function
				dates_arr = wpbc_get_selection_dates_js_str_arr__from_arr( dates_to_select_arr );
			} else {
				dates_arr = wpbc_get_selection_dates_js_str_arr__from_check_in_out( check_in_ymd, check_out_ymd, inst );
			}

			if ( 0 === dates_arr.dates_js.length ){
				return 0;
			}

			// For Calendar Days selection
			for ( var j = 0; j < dates_arr.dates_js.length; j++ ){       // Loop array of dates

				var str_date = wpbc__get__sql_class_date( dates_arr.dates_js[ j ] );

				// Date unavailable !
				if ( 0 == _wpbc.bookings_in_calendar__get_for_date( resource_id, str_date ).day_availability ){
					return 0;
				}

				if ( dates_arr.dates_js[ j ] != -1 ) {
					inst.dates.push( dates_arr.dates_js[ j ] );
				}
			}

			var check_out_date = dates_arr.dates_js[ (dates_arr.dates_js.length - 1) ];

			inst.dates.push( check_out_date ); 			// Need add one additional SAME date for correct  works of dates selection !!!!!

			var checkout_timestamp = check_out_date.getTime();
			var td_cell = wpbc_get_clicked_td( inst.id, check_out_date );

			jQuery.datepick._selectDay( td_cell, '#' + inst.id, checkout_timestamp );
		}


		if ( 0 !== inst.dates.length ){
			// Scroll to specific month, if we set dates in some future months
			wpbc_calendar__scroll_to( resource_id, inst.dates[ 0 ].getFullYear(), inst.dates[ 0 ].getMonth()+1 );
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
	function wpbc_get_clicked_td( calendar_html_id, date_js ){

	    var td_cell = jQuery( '#' + calendar_html_id + ' .sql_date_' + wpbc__get__sql_class_date( date_js ) ).get( 0 );

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
	function wpbc_get_selection_dates_js_str_arr__from_check_in_out( check_in_ymd, check_out_ymd , inst ){

		var original_array = [];
		var date;
		var bk_distinct_dates = [];

		var check_in_date = check_in_ymd.split( '-' );
		var check_out_date = check_out_ymd.split( '-' );

		date = new Date();
		date.setFullYear( check_in_date[ 0 ], (check_in_date[ 1 ] - 1), check_in_date[ 2 ] );                                    // year, month, date
		var original_check_in_date = date;
		original_array.push( jQuery.datepick._restrictMinMax( inst, jQuery.datepick._determineDate( inst, date, null ) ) ); //add date
		if ( ! wpbc_in_array( bk_distinct_dates, (check_in_date[ 2 ] + '.' + check_in_date[ 1 ] + '.' + check_in_date[ 0 ]) ) ){
			bk_distinct_dates.push( parseInt(check_in_date[ 2 ]) + '.' + parseInt(check_in_date[ 1 ]) + '.' + check_in_date[ 0 ] );
		}

		var date_out = new Date();
		date_out.setFullYear( check_out_date[ 0 ], (check_out_date[ 1 ] - 1), check_out_date[ 2 ] );                                    // year, month, date
		var original_check_out_date = date_out;

		var mewDate = new Date( original_check_in_date.getFullYear(), original_check_in_date.getMonth(), original_check_in_date.getDate() );
		mewDate.setDate( original_check_in_date.getDate() + 1 );

		while (
			(original_check_out_date > date) &&
			(original_check_in_date != original_check_out_date) ){
			date = new Date( mewDate.getFullYear(), mewDate.getMonth(), mewDate.getDate() );

			original_array.push( jQuery.datepick._restrictMinMax( inst, jQuery.datepick._determineDate( inst, date, null ) ) ); //add date
			if ( !wpbc_in_array( bk_distinct_dates, (date.getDate() + '.' + parseInt( date.getMonth() + 1 ) + '.' + date.getFullYear()) ) ){
				bk_distinct_dates.push( (parseInt(date.getDate()) + '.' + parseInt( date.getMonth() + 1 ) + '.' + date.getFullYear()) );
			}

			mewDate = new Date( date.getFullYear(), date.getMonth(), date.getDate() );
			mewDate.setDate( mewDate.getDate() + 1 );
		}
		original_array.pop();
		bk_distinct_dates.pop();

		return {'dates_js': original_array, 'dates_str': bk_distinct_dates};
	}

	/**
	 * Get arrays of JS and SQL dates as dates array
	 *
	 * @param dates_to_select_arr	= ['2024-05-09','2024-05-19','2024-05-30']
	 *
	 * @returns {{dates_js: *[], dates_str: *[]}}
	 */
	function wpbc_get_selection_dates_js_str_arr__from_arr( dates_to_select_arr ){										//FixIn: 10.0.0.50

		var original_array    = [];
		var bk_distinct_dates = [];
		var one_date_str;

		for ( var d = 0; d < dates_to_select_arr.length; d++ ){

			original_array.push( wpbc__get__js_date( dates_to_select_arr[ d ] ) );

			one_date_str = dates_to_select_arr[ d ].split('-')
			if ( ! wpbc_in_array( bk_distinct_dates, (one_date_str[ 2 ] + '.' + one_date_str[ 1 ] + '.' + one_date_str[ 0 ]) ) ){
				bk_distinct_dates.push( parseInt(one_date_str[ 2 ]) + '.' + parseInt(one_date_str[ 1 ]) + '.' + one_date_str[ 0 ] );
			}
		}

		return {'dates_js': original_array, 'dates_str': original_array};
	}

// =====================================================================================================================
/*  ==  Auto Fill Fields / Auto Select Dates  ==
// ===================================================================================================================== */

jQuery( document ).ready( function (){

	var url_params = new URLSearchParams( window.location.search );

	// Disable days selection  in calendar,  after  redirection  from  the "Search results page,  after  search  availability" 			//FixIn: 8.8.2.3
	if  ( 'On' != _wpbc.get_other_param( 'is_enabled_booking_search_results_days_select' ) ) {
		if (
			( url_params.has( 'wpbc_select_check_in' ) ) &&
			( url_params.has( 'wpbc_select_check_out' ) ) &&
			( url_params.has( 'wpbc_select_calendar_id' ) )
		){

			var select_dates_in_calendar_id = parseInt( url_params.get( 'wpbc_select_calendar_id' ) );

			// Fire on all booking dates loaded
			jQuery( 'body' ).on( 'wpbc_calendar_ajx__loaded_data', function ( event, loaded_resource_id ){

				if ( loaded_resource_id == select_dates_in_calendar_id ){
					wpbc_auto_select_dates_in_calendar( select_dates_in_calendar_id, url_params.get( 'wpbc_select_check_in' ), url_params.get( 'wpbc_select_check_out' ) );
				}
			} );
		}
	}

	if ( url_params.has( 'wpbc_auto_fill' ) ){

		var wpbc_auto_fill_value = url_params.get( 'wpbc_auto_fill' );

		// Convert back.     Some systems do not like symbol '~' in URL, so  we need to replace to  some other symbols
		wpbc_auto_fill_value = wpbc_auto_fill_value.replaceAll( '_^_', '~' );

		wpbc_auto_fill_booking_fields( wpbc_auto_fill_value );
	}

} );

/**
 * Autofill / select booking form  fields by  values from  the GET request  parameter: ?wpbc_auto_fill=
 *
 * @param auto_fill_str
 */
function wpbc_auto_fill_booking_fields( auto_fill_str ){																//FixIn: 10.0.0.48

	if ( '' == auto_fill_str ){
		return;
	}

// console.log( 'WPBC_AUTO_FILL_BOOKING_FIELDS( AUTO_FILL_STR )', auto_fill_str);

	var fields_arr = wpbc_auto_fill_booking_fields__parse( auto_fill_str );

	for ( let i = 0; i < fields_arr.length; i++ ){
		jQuery( '[name="' + fields_arr[ i ][ 'name' ] + '"]' ).val( fields_arr[ i ][ 'value' ] );
	}
}

	/**
	 * Parse data from  get parameter:	?wpbc_auto_fill=visitors231^2~max_capacity231^2
	 *
	 * @param data_str      =   'visitors231^2~max_capacity231^2';
	 * @returns {*}
	 */
	function wpbc_auto_fill_booking_fields__parse( data_str ){

		var filter_options_arr = [];

		var data_arr = data_str.split( '~' );

		for ( var j = 0; j < data_arr.length; j++ ){

			var my_form_field = data_arr[ j ].split( '^' );

			var filter_name  = ('undefined' !== typeof (my_form_field[ 0 ])) ? my_form_field[ 0 ] : '';
			var filter_value = ('undefined' !== typeof (my_form_field[ 1 ])) ? my_form_field[ 1 ] : '';

			filter_options_arr.push(
										{
											'name'  : filter_name,
											'value' : filter_value
										}
								   );
		}
		return filter_options_arr;
	}

	/**
	 * Parse data from  get parameter:	?search_get__custom_params=...
	 *
	 * @param data_str      =   'text^search_field__display_check_in^23.05.2024~text^search_field__display_check_out^26.05.2024~selectbox-one^search_quantity^2~selectbox-one^location^Spain~selectbox-one^max_capacity^2~selectbox-one^amenity^parking~checkbox^search_field__extend_search_days^5~submit^^Search~hidden^search_get__check_in_ymd^2024-05-23~hidden^search_get__check_out_ymd^2024-05-26~hidden^search_get__time^~hidden^search_get__quantity^2~hidden^search_get__extend^5~hidden^search_get__users_id^~hidden^search_get__custom_params^~';
	 * @returns {*}
	 */
	function wpbc_auto_fill_search_fields__parse( data_str ){

		var filter_options_arr = [];

		var data_arr = data_str.split( '~' );

		for ( var j = 0; j < data_arr.length; j++ ){

			var my_form_field = data_arr[ j ].split( '^' );

			var filter_type  = ('undefined' !== typeof (my_form_field[ 0 ])) ? my_form_field[ 0 ] : '';
			var filter_name  = ('undefined' !== typeof (my_form_field[ 1 ])) ? my_form_field[ 1 ] : '';
			var filter_value = ('undefined' !== typeof (my_form_field[ 2 ])) ? my_form_field[ 2 ] : '';

			filter_options_arr.push(
										{
											'type'  : filter_type,
											'name'  : filter_name,
											'value' : filter_value
										}
								   );
		}
		return filter_options_arr;
	}


// ---------------------------------------------------------------------------------------------------------------------
/*  ==  Auto Update number of months in calendars ON screen size changed  ==
// --------------------------------------------------------------------------------------------------------------------- */

/**
 * Auto Update Number of Months in Calendar, e.g.:  		if    ( WINDOW_WIDTH <= 782px )   >>> 	MONTHS_NUMBER = 1
 *   ELSE:  number of months defined in shortcode.
 * @param resource_id int
 *
 */
function wpbc_calendar__auto_update_months_number__on_resize( resource_id ){

	var local__number_of_months = parseInt( _wpbc.calendar__get_param_value( resource_id, 'calendar_number_of_months' ) );

	if ( local__number_of_months > 1 ){

		if ( jQuery( window ).width() <= 782 ){
			wpbc_calendar__update_months_number( resource_id, 1 );
		} else {
			wpbc_calendar__update_months_number( resource_id, local__number_of_months );
		}

	}
}

/**
 * Auto Update Number of Months in   ALL   Calendars
 *
 */
function wpbc_calendars__auto_update_months_number(){

	var all_calendars_arr = _wpbc.calendars_all__get();

	// This LOOP "for in" is GOOD, because we check  here keys    'calendar_' === calendar_id.slice( 0, 9 )
	for ( var calendar_id in all_calendars_arr ){
		if ( 'calendar_' === calendar_id.slice( 0, 9 ) ){
			var resource_id = parseInt( calendar_id.slice( 9 ) );			//  'calendar_3' -> 3
			if ( resource_id > 0 ){
				wpbc_calendar__auto_update_months_number__on_resize( resource_id );
			}
		}
	}
}

/**
 * If browser window changed,  then  update number of months.
 */
jQuery( window ).on( 'resize', function (){
	wpbc_calendars__auto_update_months_number();
} );

/**
 * Auto update calendar number of months on initial page load
 */
jQuery( document ).ready( function (){
	var closed_timer = setTimeout( function (){
		wpbc_calendars__auto_update_months_number();
	}, 100 );
});
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
function wpbc_cal__re_init( resource_id ){

	// Remove CLASS  for ability to re-render and reinit calendar.
	jQuery( '#calendar_booking' + resource_id ).removeClass( 'hasDatepick' );
	wpbc_calendar_show( resource_id );
}


/**
 * Re-Init previously  saved days selection  variables.
 *
 * @param resource_id
 */
function wpbc_cal_days_select__re_init( resource_id ){

	_wpbc.calendar__set_param_value( resource_id, 'saved_variable___days_select_initial'
		, {
			'dynamic__days_min'        : _wpbc.calendar__get_param_value( resource_id, 'dynamic__days_min' ),
			'dynamic__days_max'        : _wpbc.calendar__get_param_value( resource_id, 'dynamic__days_max' ),
			'dynamic__days_specific'   : _wpbc.calendar__get_param_value( resource_id, 'dynamic__days_specific' ),
			'dynamic__week_days__start': _wpbc.calendar__get_param_value( resource_id, 'dynamic__week_days__start' ),
			'fixed__days_num'          : _wpbc.calendar__get_param_value( resource_id, 'fixed__days_num' ),
			'fixed__week_days__start'  : _wpbc.calendar__get_param_value( resource_id, 'fixed__week_days__start' )
		}
	);
}

// ---------------------------------------------------------------------------------------------------------------------

/**
 * Set Single Day selection - after page load
 *
 * @param resource_id		ID of booking resource
 */
function wpbc_cal_ready_days_select__single( resource_id ){

	// Re-define selection, only after page loaded with all init vars
	jQuery(document).ready(function(){

		// Wait 1 second, just to  be sure, that all init vars defined
		setTimeout(function(){

			wpbc_cal_days_select__single( resource_id );

		}, 1000);
	});
}

/**
 * Set Single Day selection
 * Can be run at any  time,  when  calendar defined - useful for console run.
 *
 * @param resource_id		ID of booking resource
 */
function wpbc_cal_days_select__single( resource_id ){

	_wpbc.calendar__set_parameters( resource_id, {'days_select_mode': 'single'} );

	wpbc_cal_days_select__re_init( resource_id );
	wpbc_cal__re_init( resource_id );
}

// ---------------------------------------------------------------------------------------------------------------------

/**
 * Set Multiple Days selection  - after page load
 *
 * @param resource_id		ID of booking resource
 */
function wpbc_cal_ready_days_select__multiple( resource_id ){

	// Re-define selection, only after page loaded with all init vars
	jQuery(document).ready(function(){

		// Wait 1 second, just to  be sure, that all init vars defined
		setTimeout(function(){

			wpbc_cal_days_select__multiple( resource_id );

		}, 1000);
	});
}


/**
 * Set Multiple Days selection
 * Can be run at any  time,  when  calendar defined - useful for console run.
 *
 * @param resource_id		ID of booking resource
 */
function wpbc_cal_days_select__multiple( resource_id ){

	_wpbc.calendar__set_parameters( resource_id, {'days_select_mode': 'multiple'} );

	wpbc_cal_days_select__re_init( resource_id );
	wpbc_cal__re_init( resource_id );
}


// ---------------------------------------------------------------------------------------------------------------------

/**
 * Set Fixed Days selection with  1 mouse click  - after page load
 *
 * @integer resource_id			- 1				   -- ID of booking resource (calendar) -
 * @integer days_number			- 3				   -- number of days to  select	-
 * @array week_days__start	- [-1] | [ 1, 5]   --  { -1 - Any | 0 - Su,  1 - Mo,  2 - Tu, 3 - We, 4 - Th, 5 - Fr, 6 - Sat }
 */
function wpbc_cal_ready_days_select__fixed( resource_id, days_number, week_days__start = [-1] ){

	// Re-define selection, only after page loaded with all init vars
	jQuery(document).ready(function(){

		// Wait 1 second, just to  be sure, that all init vars defined
		setTimeout(function(){

			wpbc_cal_days_select__fixed( resource_id, days_number, week_days__start );

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
function wpbc_cal_days_select__fixed( resource_id, days_number, week_days__start = [-1] ){

	_wpbc.calendar__set_parameters( resource_id, {'days_select_mode': 'fixed'} );

	_wpbc.calendar__set_parameters( resource_id, {'fixed__days_num': parseInt( days_number )} );			// Number of days selection with 1 mouse click
	_wpbc.calendar__set_parameters( resource_id, {'fixed__week_days__start': week_days__start} ); 	// { -1 - Any | 0 - Su,  1 - Mo,  2 - Tu, 3 - We, 4 - Th, 5 - Fr, 6 - Sat }

	wpbc_cal_days_select__re_init( resource_id );
	wpbc_cal__re_init( resource_id );
}

// ---------------------------------------------------------------------------------------------------------------------

/**
 * Set Range Days selection  with  2 mouse clicks  - after page load
 *
 * @integer resource_id			- 1				   		-- ID of booking resource (calendar)
 * @integer days_min			- 7				   		-- Min number of days to select
 * @integer days_max			- 30			   		-- Max number of days to select
 * @array days_specific			- [] | [7,14,21,28]		-- Restriction for Specific number of days selection
 * @array week_days__start		- [-1] | [ 1, 5]   		--  { -1 - Any | 0 - Su,  1 - Mo,  2 - Tu, 3 - We, 4 - Th, 5 - Fr, 6 - Sat }
 */
function wpbc_cal_ready_days_select__range( resource_id, days_min, days_max, days_specific = [], week_days__start = [-1] ){

	// Re-define selection, only after page loaded with all init vars
	jQuery(document).ready(function(){

		// Wait 1 second, just to  be sure, that all init vars defined
		setTimeout(function(){

			wpbc_cal_days_select__range( resource_id, days_min, days_max, days_specific, week_days__start );
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
function wpbc_cal_days_select__range( resource_id, days_min, days_max, days_specific = [], week_days__start = [-1] ){

	_wpbc.calendar__set_parameters(  resource_id, {'days_select_mode': 'dynamic'}  );
	_wpbc.calendar__set_param_value( resource_id, 'dynamic__days_min'         , parseInt( days_min )  );           		// Min. Number of days selection with 2 mouse clicks
	_wpbc.calendar__set_param_value( resource_id, 'dynamic__days_max'         , parseInt( days_max )  );          		// Max. Number of days selection with 2 mouse clicks
	_wpbc.calendar__set_param_value( resource_id, 'dynamic__days_specific'    , days_specific  );	      				// Example [5,7]
	_wpbc.calendar__set_param_value( resource_id, 'dynamic__week_days__start' , week_days__start  );  					// { -1 - Any | 0 - Su,  1 - Mo,  2 - Tu, 3 - We, 4 - Th, 5 - Fr, 6 - Sat }

	wpbc_cal_days_select__re_init( resource_id );
	wpbc_cal__re_init( resource_id );
}

/**
 * ====================================================================================================================
 *	includes/__js/cal_ajx_load/wpbc_cal_ajx.js
 * ====================================================================================================================
 */

// ---------------------------------------------------------------------------------------------------------------------
//  A j a x    L o a d    C a l e n d a r    D a t a
// ---------------------------------------------------------------------------------------------------------------------

function wpbc_calendar__load_data__ajx( params ){

	//FixIn: 9.8.6.2
	wpbc_calendar__loading__start( params['resource_id'] );
	if ( wpbc_balancer__is_wait( params , 'wpbc_calendar__load_data__ajx' ) ){
		return false;
	}

	//FixIn: 9.8.6.2
	wpbc_calendar__blur__stop( params['resource_id'] );


// console.groupEnd(); console.time('resource_id_' + params['resource_id']);
console.groupCollapsed( 'WPBC_AJX_CALENDAR_LOAD' ); console.log( ' == Before Ajax Send - calendars_all__get() == ' , _wpbc.calendars_all__get() );

	// Start Ajax
	jQuery.post( wpbc_url_ajax,
				{
					action          : 'WPBC_AJX_CALENDAR_LOAD',
					wpbc_ajx_user_id: _wpbc.get_secure_param( 'user_id' ),
					nonce           : _wpbc.get_secure_param( 'nonce' ),
					wpbc_ajx_locale : _wpbc.get_secure_param( 'locale' ),

					calendar_request_params : params 						// Usually like: { 'resource_id': 1, 'max_days_count': 365 }
				},

				/**
				 * S u c c e s s
				 *
				 * @param response_data		-	its object returned from  Ajax - class-live-search.php
				 * @param textStatus		-	'success'
				 * @param jqXHR				-	Object
				 */
				function ( response_data, textStatus, jqXHR ) {
// console.timeEnd('resource_id_' + response_data['resource_id']);
console.log( ' == Response WPBC_AJX_CALENDAR_LOAD == ', response_data ); console.groupEnd();

					//FixIn: 9.8.6.2
					var ajx_post_data__resource_id = wpbc_get_resource_id__from_ajx_post_data_url( this.data );
					wpbc_balancer__completed( ajx_post_data__resource_id , 'wpbc_calendar__load_data__ajx' );

					// Probably Error
					if ( (typeof response_data !== 'object') || (response_data === null) ){

						var jq_node  = wpbc_get_calendar__jq_node__for_messages( this.data );
						var message_type = 'info';

						if ( '' === response_data ){
							response_data = 'The server responds with an empty string. The server probably stopped working unexpectedly. <br>Please check your <strong>error.log</strong> in your server configuration for relative errors.';
							message_type = 'warning';
						}

						// Show Message
						wpbc_front_end__show_message( response_data , { 'type'     : message_type,
																		'show_here': {'jq_node': jq_node, 'where': 'after'},
																		'is_append': true,
																		'style'    : 'text-align:left;',
																		'delay'    : 0
																	} );
						return;
					}

					// Show Calendar
					wpbc_calendar__loading__stop( response_data[ 'resource_id' ] );

					// -------------------------------------------------------------------------------------------------
					// Bookings - Dates
					_wpbc.bookings_in_calendar__set_dates(  response_data[ 'resource_id' ], response_data[ 'ajx_data' ]['dates']  );

					// Bookings - Child or only single booking resource in dates
					_wpbc.booking__set_param_value( response_data[ 'resource_id' ], 'resources_id_arr__in_dates', response_data[ 'ajx_data' ][ 'resources_id_arr__in_dates' ] );

					// Aggregate booking resources,  if any ?
					_wpbc.booking__set_param_value( response_data[ 'resource_id' ], 'aggregate_resource_id_arr', response_data[ 'ajx_data' ][ 'aggregate_resource_id_arr' ] );
					// -------------------------------------------------------------------------------------------------

					// Update calendar
					wpbc_calendar__update_look( response_data[ 'resource_id' ] );


					if (
							( 'undefined' !== typeof (response_data[ 'ajx_data' ][ 'ajx_after_action_message' ]) )
						 && ( '' != response_data[ 'ajx_data' ][ 'ajx_after_action_message' ].replace( /\n/g, "<br />" ) )
					){

						var jq_node  = wpbc_get_calendar__jq_node__for_messages( this.data );

						// Show Message
						wpbc_front_end__show_message( response_data[ 'ajx_data' ][ 'ajx_after_action_message' ].replace( /\n/g, "<br />" ),
														{   'type'     : ( 'undefined' !== typeof( response_data[ 'ajx_data' ][ 'ajx_after_action_message_status' ] ) )
																		  ? response_data[ 'ajx_data' ][ 'ajx_after_action_message_status' ] : 'info',
															'show_here': {'jq_node': jq_node, 'where': 'after'},
															'is_append': true,
															'style'    : 'text-align:left;',
															'delay'    : 10000
														} );
					}

					// Trigger event that calendar has been		 //FixIn: 10.0.0.44
					if ( jQuery( '#calendar_booking' + response_data[ 'resource_id' ] ).length > 0 ){
						var target_elm = jQuery( 'body' ).trigger( "wpbc_calendar_ajx__loaded_data", [response_data[ 'resource_id' ]] );
						 //jQuery( 'body' ).on( 'wpbc_calendar_ajx__loaded_data', function( event, resource_id ) { ... } );
					}

					//jQuery( '#ajax_respond' ).html( response_data );		// For ability to show response, add such DIV element to page
				}
			  ).fail( function ( jqXHR, textStatus, errorThrown ) {    if ( window.console && window.console.log ){ console.log( 'Ajax_Error', jqXHR, textStatus, errorThrown ); }

					var ajx_post_data__resource_id = wpbc_get_resource_id__from_ajx_post_data_url( this.data );
					wpbc_balancer__completed( ajx_post_data__resource_id , 'wpbc_calendar__load_data__ajx' );

					// Get Content of Error Message
					var error_message = '<strong>' + 'Error!' + '</strong> ' + errorThrown ;
					if ( jqXHR.status ){
						error_message += ' (<b>' + jqXHR.status + '</b>)';
						if (403 == jqXHR.status ){
							error_message += '<br> Probably nonce for this page has been expired. Please <a href="javascript:void(0)" onclick="javascript:location.reload();">reload the page</a>.';
							error_message += '<br> Otherwise, please check this <a style="font-weight: 600;" href="https://wpbookingcalendar.com/faq/request-do-not-pass-security-check/?after_update=10.1.1">troubleshooting instruction</a>.<br>'
						}
					}
					var message_show_delay = 3000;
					if ( jqXHR.responseText ){
						error_message += ' ' + jqXHR.responseText;
						message_show_delay = 10;
					}
					error_message = error_message.replace( /\n/g, "<br />" );

					var jq_node  = wpbc_get_calendar__jq_node__for_messages( this.data );

					/**
					 * If we make fast clicking on different pages,
					 * then under calendar will show error message with  empty  text, because ajax was not received.
					 * To  not show such warnings we are set delay  in 3 seconds.  var message_show_delay = 3000;
					 */
					var closed_timer = setTimeout( function (){

																// Show Message
																wpbc_front_end__show_message( error_message , { 'type'     : 'error',
																												'show_here': {'jq_node': jq_node, 'where': 'after'},
																												'is_append': true,
																												'style'    : 'text-align:left;',
																												'css_class':'wpbc_fe_message_alt',
																												'delay'    : 0
																											} );
														   } ,
														   parseInt( message_show_delay )   );

			  })
	          // .done(   function ( data, textStatus, jqXHR ) {   if ( window.console && window.console.log ){ console.log( 'second success', data, textStatus, jqXHR ); }    })
			  // .always( function ( data_jqXHR, textStatus, jqXHR_errorThrown ) {   if ( window.console && window.console.log ){ console.log( 'always finished', data_jqXHR, textStatus, jqXHR_errorThrown ); }     })
			  ;  // End Ajax
}



// ---------------------------------------------------------------------------------------------------------------------
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
	function wpbc_get_calendar__jq_node__for_messages( ajx_post_data_url_params ){

		var jq_node = '.booking_form_div';

		var calendar_resource_id = wpbc_get_resource_id__from_ajx_post_data_url( ajx_post_data_url_params );

		if ( calendar_resource_id > 0 ){
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
	function wpbc_get_resource_id__from_ajx_post_data_url( ajx_post_data_url_params ){

		// Get booking resource ID from Ajax Post Request  -> this.data = 'action=WPBC_AJX_CALENDAR_LOAD...&calendar_request_params%5Bresource_id%5D=2&calendar_request_params%5Bbooking_hash%5D=&calendar_request_params'
		var calendar_resource_id = wpbc_get_uri_param_by_name( 'calendar_request_params[resource_id]', ajx_post_data_url_params );
		if ( (null !== calendar_resource_id) && ('' !== calendar_resource_id) ){
			calendar_resource_id = parseInt( calendar_resource_id );
			if ( calendar_resource_id > 0 ){
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
	function wpbc_get_uri_param_by_name( name, url ){

		url = decodeURIComponent( url );

		name = name.replace( /[\[\]]/g, '\\$&' );
		var regex = new RegExp( '[?&]' + name + '(=([^&#]*)|&|#|$)' ),
			results = regex.exec( url );
		if ( !results ) return null;
		if ( !results[ 2 ] ) return '';
		return decodeURIComponent( results[ 2 ].replace( /\+/g, ' ' ) );
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
function wpbc_front_end__show_message( message, params = {} ){

	var params_default = {
								'type'     : 'warning',							// 'error' | 'warning' | 'info' | 'success'
								'show_here' : {
													'jq_node' : '',				// any jQuery node definition
													'where'   : 'inside'		// 'inside' | 'before' | 'after' | 'right' | 'left'
											  },
								'is_append': true,								// Apply  only if 	'where'   : 'inside'
								'style'    : 'text-align:left;',				// styles, if needed
							    'css_class': '',								// For example can  be: 'wpbc_fe_message_alt'
								'delay'    : 0,									// how many microsecond to  show,  if 0  then  show forever
								'if_visible_not_show': false,					// if true,  then do not show message,  if previos message was not hided (not apply if 'where'   : 'inside' )
								'is_scroll': true								// is scroll  to  this element
						};
	for ( var p_key in params ){
		params_default[ p_key ] = params[ p_key ];
	}
	params = params_default;

    var unique_div_id = new Date();
    unique_div_id = 'wpbc_notice_' + unique_div_id.getTime();

	params['css_class'] += ' wpbc_fe_message';
	if ( params['type'] == 'error' ){
		params['css_class'] += ' wpbc_fe_message_error';
		message = '<i class="menu_icon icon-1x wpbc_icn_report_gmailerrorred"></i>' + message;
	}
	if ( params['type'] == 'warning' ){
		params['css_class'] += ' wpbc_fe_message_warning';
		message = '<i class="menu_icon icon-1x wpbc_icn_warning"></i>' + message;
	}
	if ( params['type'] == 'info' ){
		params['css_class'] += ' wpbc_fe_message_info';
	}
	if ( params['type'] == 'success' ){
		params['css_class'] += ' wpbc_fe_message_success';
		message = '<i class="menu_icon icon-1x wpbc_icn_done_outline"></i>' + message;
	}

	var scroll_to_element = '<div id="' + unique_div_id + '_scroll" style="display:none;"></div>';
	message = '<div id="' + unique_div_id + '" class="wpbc_front_end__message ' + params['css_class'] + '" style="' + params[ 'style' ] + '">' + message + '</div>';


	var jq_el_message = false;
	var is_show_message = true;

	if ( 'inside' === params[ 'show_here' ][ 'where' ] ){

		if ( params[ 'is_append' ] ){
			jQuery( params[ 'show_here' ][ 'jq_node' ] ).append( scroll_to_element );
			jQuery( params[ 'show_here' ][ 'jq_node' ] ).append( message );
		} else {
			jQuery( params[ 'show_here' ][ 'jq_node' ] ).html( scroll_to_element + message );
		}

	} else if ( 'before' === params[ 'show_here' ][ 'where' ] ){

		jq_el_message = jQuery( params[ 'show_here' ][ 'jq_node' ] ).siblings( '[id^="wpbc_notice_"]' );
		if ( (params[ 'if_visible_not_show' ]) && (jq_el_message.is( ':visible' )) ){
			is_show_message = false;
			unique_div_id = jQuery( jq_el_message.get( 0 ) ).attr( 'id' );
		}
		if ( is_show_message ){
			jQuery( params[ 'show_here' ][ 'jq_node' ] ).before( scroll_to_element );
			jQuery( params[ 'show_here' ][ 'jq_node' ] ).before( message );
		}

	} else if ( 'after' === params[ 'show_here' ][ 'where' ] ){

		jq_el_message = jQuery( params[ 'show_here' ][ 'jq_node' ] ).nextAll( '[id^="wpbc_notice_"]' );
		if ( (params[ 'if_visible_not_show' ]) && (jq_el_message.is( ':visible' )) ){
			is_show_message = false;
			unique_div_id = jQuery( jq_el_message.get( 0 ) ).attr( 'id' );
		}
		if ( is_show_message ){
			jQuery( params[ 'show_here' ][ 'jq_node' ] ).before( scroll_to_element );		// We need to  set  here before(for handy scroll)
			jQuery( params[ 'show_here' ][ 'jq_node' ] ).after( message );
		}

	} else if ( 'right' === params[ 'show_here' ][ 'where' ] ){

		jq_el_message = jQuery( params[ 'show_here' ][ 'jq_node' ] ).nextAll( '.wpbc_front_end__message_container_right' ).find( '[id^="wpbc_notice_"]' );
		if ( (params[ 'if_visible_not_show' ]) && (jq_el_message.is( ':visible' )) ){
			is_show_message = false;
			unique_div_id = jQuery( jq_el_message.get( 0 ) ).attr( 'id' );
		}
		if ( is_show_message ){
			jQuery( params[ 'show_here' ][ 'jq_node' ] ).before( scroll_to_element );		// We need to  set  here before(for handy scroll)
			jQuery( params[ 'show_here' ][ 'jq_node' ] ).after( '<div class="wpbc_front_end__message_container_right">' + message + '</div>' );
		}
	} else if ( 'left' === params[ 'show_here' ][ 'where' ] ){

		jq_el_message = jQuery( params[ 'show_here' ][ 'jq_node' ] ).siblings( '.wpbc_front_end__message_container_left' ).find( '[id^="wpbc_notice_"]' );
		if ( (params[ 'if_visible_not_show' ]) && (jq_el_message.is( ':visible' )) ){
			is_show_message = false;
			unique_div_id = jQuery( jq_el_message.get( 0 ) ).attr( 'id' );
		}
		if ( is_show_message ){
			jQuery( params[ 'show_here' ][ 'jq_node' ] ).before( scroll_to_element );		// We need to  set  here before(for handy scroll)
			jQuery( params[ 'show_here' ][ 'jq_node' ] ).before( '<div class="wpbc_front_end__message_container_left">' + message + '</div>' );
		}
	}

	if (   ( is_show_message )  &&  ( parseInt( params[ 'delay' ] ) > 0 )   ){
		var closed_timer = setTimeout( function (){
													jQuery( '#' + unique_div_id ).fadeOut( 1500 );
										} , parseInt( params[ 'delay' ] )   );

		var closed_timer2 = setTimeout( function (){
														jQuery( '#' + unique_div_id ).trigger( 'hide' );
										}, ( parseInt( params[ 'delay' ] ) + 1501 ) );
	}

	// Check  if showed message in some hidden parent section and show it. But it must  be lower than '.wpbc_container'
	var parent_els = jQuery( '#' + unique_div_id ).parents().map( function (){
		if ( (!jQuery( this ).is( 'visible' )) && (jQuery( '.wpbc_container' ).has( this )) ){
			jQuery( this ).show();
		}
	} );

	if ( params[ 'is_scroll' ] ){
		wpbc_do_scroll( '#' + unique_div_id + '_scroll' );
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
	function wpbc_front_end__show_message__error( jq_node, message ){

		var notice_message_id = wpbc_front_end__show_message(
																message,
																{
																	'type'               : 'error',
																	'delay'              : 10000,
																	'if_visible_not_show': true,
																	'show_here'          : {
																							'where'  : 'right',
																							'jq_node': jq_node
																						   }
																}
														);
		return notice_message_id;
	}


	/**
	 * Error message UNDER element. 	Preset of parameters for real message function.
	 *
	 * @param el		- any jQuery node definition
	 * @param message	- Message HTML
	 * @returns string  - HTML ID		or 0 if not showing during this time.
	 */
	function wpbc_front_end__show_message__error_under_element( jq_node, message, message_delay ){

		if ( 'undefined' === typeof (message_delay) ){
			message_delay = 0
		}

		var notice_message_id = wpbc_front_end__show_message(
																message,
																{
																	'type'               : 'error',
																	'delay'              : message_delay,
																	'if_visible_not_show': true,
																	'show_here'          : {
																							'where'  : 'after',
																							'jq_node': jq_node
																						   }
																}
														);
		return notice_message_id;
	}


	/**
	 * Error message UNDER element. 	Preset of parameters for real message function.
	 *
	 * @param el		- any jQuery node definition
	 * @param message	- Message HTML
	 * @returns string  - HTML ID		or 0 if not showing during this time.
	 */
	function wpbc_front_end__show_message__error_above_element( jq_node, message, message_delay ){

		if ( 'undefined' === typeof (message_delay) ){
			message_delay = 10000
		}

		var notice_message_id = wpbc_front_end__show_message(
																message,
																{
																	'type'               : 'error',
																	'delay'              : message_delay,
																	'if_visible_not_show': true,
																	'show_here'          : {
																							'where'  : 'before',
																							'jq_node': jq_node
																						   }
																}
														);
		return notice_message_id;
	}


	/**
	 * Warning message. 	Preset of parameters for real message function.
	 *
	 * @param el		- any jQuery node definition
	 * @param message	- Message HTML
	 * @returns string  - HTML ID		or 0 if not showing during this time.
	 */
	function wpbc_front_end__show_message__warning( jq_node, message ){

		var notice_message_id = wpbc_front_end__show_message(
																message,
																{
																	'type'               : 'warning',
																	'delay'              : 10000,
																	'if_visible_not_show': true,
																	'show_here'          : {
																							'where'  : 'right',
																							'jq_node': jq_node
																						   }
																}
														);
		wpbc_highlight_error_on_form_field( jq_node );
		return notice_message_id;
	}


	/**
	 * Warning message UNDER element. 	Preset of parameters for real message function.
	 *
	 * @param el		- any jQuery node definition
	 * @param message	- Message HTML
	 * @returns string  - HTML ID		or 0 if not showing during this time.
	 */
	function wpbc_front_end__show_message__warning_under_element( jq_node, message ){

		var notice_message_id = wpbc_front_end__show_message(
																message,
																{
																	'type'               : 'warning',
																	'delay'              : 10000,
																	'if_visible_not_show': true,
																	'show_here'          : {
																							'where'  : 'after',
																							'jq_node': jq_node
																						   }
																}
														);
		return notice_message_id;
	}


	/**
	 * Warning message ABOVE element. 	Preset of parameters for real message function.
	 *
	 * @param el		- any jQuery node definition
	 * @param message	- Message HTML
	 * @returns string  - HTML ID		or 0 if not showing during this time.
	 */
	function wpbc_front_end__show_message__warning_above_element( jq_node, message ){

		var notice_message_id = wpbc_front_end__show_message(
																message,
																{
																	'type'               : 'warning',
																	'delay'              : 10000,
																	'if_visible_not_show': true,
																	'show_here'          : {
																							'where'  : 'before',
																							'jq_node': jq_node
																						   }
																}
														);
		return notice_message_id;
	}

	/**
	 * Highlight Error in specific field
	 *
	 * @param jq_node					string or jQuery element,  where scroll  to
	 */
	function wpbc_highlight_error_on_form_field( jq_node ){

		if ( !jQuery( jq_node ).length ){
			return;
		}
		if ( ! jQuery( jq_node ).is( ':input' ) ){
			// Situation with  checkboxes or radio  buttons
			var jq_node_arr = jQuery( jq_node ).find( ':input' );
			if ( !jq_node_arr.length ){
				return
			}
			jq_node = jq_node_arr.get( 0 );
		}
		var params = {};
		params[ 'delay' ] = 10000;

		if ( !jQuery( jq_node ).hasClass( 'wpbc_form_field_error' ) ){

			jQuery( jq_node ).addClass( 'wpbc_form_field_error' )

			if ( parseInt( params[ 'delay' ] ) > 0 ){
				var closed_timer = setTimeout( function (){
															 jQuery( jq_node ).removeClass( 'wpbc_form_field_error' );
														  }
											   , parseInt( params[ 'delay' ] )
									);

			}
		}
	}

/**
 * Scroll to specific element
 *
 * @param jq_node					string or jQuery element,  where scroll  to
 * @param extra_shift_offset		int shift offset from  jq_node
 */
function wpbc_do_scroll( jq_node , extra_shift_offset = 0 ){

	if ( !jQuery( jq_node ).length ){
		return;
	}
	var targetOffset = jQuery( jq_node ).offset().top;

	if ( targetOffset <= 0 ){
		if ( 0 != jQuery( jq_node ).nextAll( ':visible' ).length ){
			targetOffset = jQuery( jq_node ).nextAll( ':visible' ).first().offset().top;
		} else if ( 0 != jQuery( jq_node ).parent().nextAll( ':visible' ).length ){
			targetOffset = jQuery( jq_node ).parent().nextAll( ':visible' ).first().offset().top;
		}
	}

	if ( jQuery( '#wpadminbar' ).length > 0 ){
		targetOffset = targetOffset - 50 - 50;
	} else {
		targetOffset = targetOffset - 20 - 50;
	}
	targetOffset += extra_shift_offset;

	// Scroll only  if we did not scroll before
	if ( ! jQuery( 'html,body' ).is( ':animated' ) ){
		jQuery( 'html,body' ).animate( {scrollTop: targetOffset}, 500 );
	}
}



//FixIn: 10.2.0.4
/**
 * Define Popovers for Timelines in WP Booking Calendar
 *
 * @returns {string|boolean}
 */
function wpbc_define_tippy_popover(){
	if ( 'function' !== typeof (wpbc_tippy) ){
		console.log( 'WPBC Error. wpbc_tippy was not defined.' );
		return false;
	}
	wpbc_tippy( '.popover_bottom.popover_click', {
		content( reference ){
			var popover_title = reference.getAttribute( 'data-original-title' );
			var popover_content = reference.getAttribute( 'data-content' );
			return '<div class="popover popover_tippy">'
				+ '<div class="popover-close"><a href="javascript:void(0)" onclick="javascript:this.parentElement.parentElement.parentElement.parentElement.parentElement._tippy.hide();" >&times;</a></div>'
				+ popover_content
				+ '</div>';
		},
		allowHTML        : true,
		trigger          : 'manual',
		interactive      : true,
		hideOnClick      : false,
		interactiveBorder: 10,
		maxWidth         : 550,
		theme            : 'wpbc-tippy-popover',
		placement        : 'bottom-start',
		touch            : ['hold', 500],
	} );
	jQuery( '.popover_bottom.popover_click' ).on( 'click', function (){
		if ( this._tippy.state.isVisible ){
			this._tippy.hide();
		} else {
			this._tippy.show();
		}
	} );
	wpbc_define_hide_tippy_on_scroll();
}



function wpbc_define_hide_tippy_on_scroll(){
	jQuery( '.flex_tl__scrolling_section2,.flex_tl__scrolling_sections' ).on( 'scroll', function ( event ){
		if ( 'function' === typeof (wpbc_tippy) ){
			wpbc_tippy.hideAll();
		}
	} );
}

//# sourceMappingURL=data:application/json;charset=utf8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndwYmNfdXRpbHMuanMiLCJ3cGJjLmpzIiwiYWp4X2xvYWRfYmFsYW5jZXIuanMiLCJ3cGJjX2NhbC5qcyIsImRheXNfc2VsZWN0X2N1c3RvbS5qcyIsIndwYmNfY2FsX2FqeC5qcyIsIndwYmNfZmVfbWVzc2FnZXMuanMiLCJ0aW1lbGluZV9wb3BvdmVyLmpzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUN4Q0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUMvaEJBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUN0UUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUNsL0RBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQ3hNQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUN6T0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQ2haQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EiLCJmaWxlIjoid3BiY19hbGwuanMiLCJzb3VyY2VzQ29udGVudCI6WyIvKipcclxuICogPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XHJcbiAqIEphdmFTY3JpcHQgVXRpbCBGdW5jdGlvbnNcdFx0Li4vaW5jbHVkZXMvX19qcy91dGlscy93cGJjX3V0aWxzLmpzXHJcbiAqID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxyXG4gKi9cclxuXHJcbi8qKlxyXG4gKiBUcmltICBzdHJpbmdzIGFuZCBhcnJheSBqb2luZWQgd2l0aCAgKCwpXHJcbiAqXHJcbiAqIEBwYXJhbSBzdHJpbmdfdG9fdHJpbSAgIHN0cmluZyAvIGFycmF5XHJcbiAqIEByZXR1cm5zIHN0cmluZ1xyXG4gKi9cclxuZnVuY3Rpb24gd3BiY190cmltKCBzdHJpbmdfdG9fdHJpbSApe1xyXG5cclxuICAgIGlmICggQXJyYXkuaXNBcnJheSggc3RyaW5nX3RvX3RyaW0gKSApe1xyXG4gICAgICAgIHN0cmluZ190b190cmltID0gc3RyaW5nX3RvX3RyaW0uam9pbiggJywnICk7XHJcbiAgICB9XHJcblxyXG4gICAgaWYgKCAnc3RyaW5nJyA9PSB0eXBlb2YgKHN0cmluZ190b190cmltKSApe1xyXG4gICAgICAgIHN0cmluZ190b190cmltID0gc3RyaW5nX3RvX3RyaW0udHJpbSgpO1xyXG4gICAgfVxyXG5cclxuICAgIHJldHVybiBzdHJpbmdfdG9fdHJpbTtcclxufVxyXG5cclxuLyoqXHJcbiAqIENoZWNrIGlmIGVsZW1lbnQgaW4gYXJyYXlcclxuICpcclxuICogQHBhcmFtIGFycmF5X2hlcmVcdFx0YXJyYXlcclxuICogQHBhcmFtIHBfdmFsXHRcdFx0XHRlbGVtZW50IHRvICBjaGVja1xyXG4gKiBAcmV0dXJucyB7Ym9vbGVhbn1cclxuICovXHJcbmZ1bmN0aW9uIHdwYmNfaW5fYXJyYXkoIGFycmF5X2hlcmUsIHBfdmFsICl7XHJcblx0Zm9yICggdmFyIGkgPSAwLCBsID0gYXJyYXlfaGVyZS5sZW5ndGg7IGkgPCBsOyBpKysgKXtcclxuXHRcdGlmICggYXJyYXlfaGVyZVsgaSBdID09IHBfdmFsICl7XHJcblx0XHRcdHJldHVybiB0cnVlO1xyXG5cdFx0fVxyXG5cdH1cclxuXHRyZXR1cm4gZmFsc2U7XHJcbn1cclxuIiwiXCJ1c2Ugc3RyaWN0XCI7XHJcbi8qKlxyXG4gKiA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cclxuICpcdGluY2x1ZGVzL19fanMvd3BiYy93cGJjLmpzXHJcbiAqID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxyXG4gKi9cclxuXHJcbi8qKlxyXG4gKiBEZWVwIENsb25lIG9mIG9iamVjdCBvciBhcnJheVxyXG4gKlxyXG4gKiBAcGFyYW0gb2JqXHJcbiAqIEByZXR1cm5zIHthbnl9XHJcbiAqL1xyXG5mdW5jdGlvbiB3cGJjX2Nsb25lX29iaiggb2JqICl7XHJcblxyXG5cdHJldHVybiBKU09OLnBhcnNlKCBKU09OLnN0cmluZ2lmeSggb2JqICkgKTtcclxufVxyXG5cclxuXHJcblxyXG4vKipcclxuICogTWFpbiBfd3BiYyBKUyBvYmplY3RcclxuICovXHJcblxyXG52YXIgX3dwYmMgPSAoZnVuY3Rpb24gKCBvYmosICQpIHtcclxuXHJcblx0Ly8gU2VjdXJlIHBhcmFtZXRlcnMgZm9yIEFqYXhcdC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cdHZhciBwX3NlY3VyZSA9IG9iai5zZWN1cml0eV9vYmogPSBvYmouc2VjdXJpdHlfb2JqIHx8IHtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0dXNlcl9pZDogMCxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0bm9uY2UgIDogJycsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdGxvY2FsZSA6ICcnXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQgIH07XHJcblx0b2JqLnNldF9zZWN1cmVfcGFyYW0gPSBmdW5jdGlvbiAoIHBhcmFtX2tleSwgcGFyYW1fdmFsICkge1xyXG5cdFx0cF9zZWN1cmVbIHBhcmFtX2tleSBdID0gcGFyYW1fdmFsO1xyXG5cdH07XHJcblxyXG5cdG9iai5nZXRfc2VjdXJlX3BhcmFtID0gZnVuY3Rpb24gKCBwYXJhbV9rZXkgKSB7XHJcblx0XHRyZXR1cm4gcF9zZWN1cmVbIHBhcmFtX2tleSBdO1xyXG5cdH07XHJcblxyXG5cclxuXHQvLyBDYWxlbmRhcnMgXHQtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblx0dmFyIHBfY2FsZW5kYXJzID0gb2JqLmNhbGVuZGFyc19vYmogPSBvYmouY2FsZW5kYXJzX29iaiB8fCB7XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdC8vIHNvcnQgICAgICAgICAgICA6IFwiYm9va2luZ19pZFwiLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQvLyBzb3J0X3R5cGUgICAgICAgOiBcIkRFU0NcIixcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0Ly8gcGFnZV9udW0gICAgICAgIDogMSxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0Ly8gcGFnZV9pdGVtc19jb3VudDogMTAsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdC8vIGNyZWF0ZV9kYXRlICAgICA6IFwiXCIsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdC8vIGtleXdvcmQgICAgICAgICA6IFwiXCIsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdC8vIHNvdXJjZSAgICAgICAgICA6IFwiXCJcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHR9O1xyXG5cclxuXHQvKipcclxuXHQgKiAgQ2hlY2sgaWYgY2FsZW5kYXIgZm9yIHNwZWNpZmljIGJvb2tpbmcgcmVzb3VyY2UgZGVmaW5lZCAgIDo6ICAgdHJ1ZSB8IGZhbHNlXHJcblx0ICpcclxuXHQgKiBAcGFyYW0ge3N0cmluZ3xpbnR9IHJlc291cmNlX2lkXHJcblx0ICogQHJldHVybnMge2Jvb2xlYW59XHJcblx0ICovXHJcblx0b2JqLmNhbGVuZGFyX19pc19kZWZpbmVkID0gZnVuY3Rpb24gKCByZXNvdXJjZV9pZCApIHtcclxuXHJcblx0XHRyZXR1cm4gKCd1bmRlZmluZWQnICE9PSB0eXBlb2YoIHBfY2FsZW5kYXJzWyAnY2FsZW5kYXJfJyArIHJlc291cmNlX2lkIF0gKSApO1xyXG5cdH07XHJcblxyXG5cdC8qKlxyXG5cdCAqICBDcmVhdGUgQ2FsZW5kYXIgaW5pdGlhbGl6aW5nXHJcblx0ICpcclxuXHQgKiBAcGFyYW0ge3N0cmluZ3xpbnR9IHJlc291cmNlX2lkXHJcblx0ICovXHJcblx0b2JqLmNhbGVuZGFyX19pbml0ID0gZnVuY3Rpb24gKCByZXNvdXJjZV9pZCApIHtcclxuXHJcblx0XHRwX2NhbGVuZGFyc1sgJ2NhbGVuZGFyXycgKyByZXNvdXJjZV9pZCBdID0ge307XHJcblx0XHRwX2NhbGVuZGFyc1sgJ2NhbGVuZGFyXycgKyByZXNvdXJjZV9pZCBdWyAnaWQnIF0gPSByZXNvdXJjZV9pZDtcclxuXHRcdHBfY2FsZW5kYXJzWyAnY2FsZW5kYXJfJyArIHJlc291cmNlX2lkIF1bICdwZW5kaW5nX2RheXNfc2VsZWN0YWJsZScgXSA9IGZhbHNlO1xyXG5cclxuXHR9O1xyXG5cclxuXHQvKipcclxuXHQgKiBDaGVjayAgaWYgdGhlIHR5cGUgb2YgdGhpcyBwcm9wZXJ0eSAgaXMgSU5UXHJcblx0ICogQHBhcmFtIHByb3BlcnR5X25hbWVcclxuXHQgKiBAcmV0dXJucyB7Ym9vbGVhbn1cclxuXHQgKi9cclxuXHRvYmouY2FsZW5kYXJfX2lzX3Byb3BfaW50ID0gZnVuY3Rpb24gKCBwcm9wZXJ0eV9uYW1lICkge1x0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0Ly9GaXhJbjogOS45LjAuMjlcclxuXHJcblx0XHR2YXIgcF9jYWxlbmRhcl9pbnRfcHJvcGVydGllcyA9IFsnZHluYW1pY19fZGF5c19taW4nLCAnZHluYW1pY19fZGF5c19tYXgnLCAnZml4ZWRfX2RheXNfbnVtJ107XHJcblxyXG5cdFx0dmFyIGlzX2luY2x1ZGUgPSBwX2NhbGVuZGFyX2ludF9wcm9wZXJ0aWVzLmluY2x1ZGVzKCBwcm9wZXJ0eV9uYW1lICk7XHJcblxyXG5cdFx0cmV0dXJuIGlzX2luY2x1ZGU7XHJcblx0fTtcclxuXHJcblxyXG5cdC8qKlxyXG5cdCAqIFNldCBwYXJhbXMgZm9yIGFsbCAgY2FsZW5kYXJzXHJcblx0ICpcclxuXHQgKiBAcGFyYW0ge29iamVjdH0gY2FsZW5kYXJzX29ialx0XHRPYmplY3QgeyBjYWxlbmRhcl8xOiB7fSB9XHJcblx0ICogXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0IGNhbGVuZGFyXzM6IHt9LCAuLi4gfVxyXG5cdCAqL1xyXG5cdG9iai5jYWxlbmRhcnNfYWxsX19zZXQgPSBmdW5jdGlvbiAoIGNhbGVuZGFyc19vYmogKSB7XHJcblx0XHRwX2NhbGVuZGFycyA9IGNhbGVuZGFyc19vYmo7XHJcblx0fTtcclxuXHJcblx0LyoqXHJcblx0ICogR2V0IGJvb2tpbmdzIGluIGFsbCBjYWxlbmRhcnNcclxuXHQgKlxyXG5cdCAqIEByZXR1cm5zIHtvYmplY3R8e319XHJcblx0ICovXHJcblx0b2JqLmNhbGVuZGFyc19hbGxfX2dldCA9IGZ1bmN0aW9uICgpIHtcclxuXHRcdHJldHVybiBwX2NhbGVuZGFycztcclxuXHR9O1xyXG5cclxuXHQvKipcclxuXHQgKiBHZXQgY2FsZW5kYXIgb2JqZWN0ICAgOjogICB7IGlkOiAxLCDigKYgfVxyXG5cdCAqXHJcblx0ICogQHBhcmFtIHtzdHJpbmd8aW50fSByZXNvdXJjZV9pZFx0XHRcdFx0ICAnMidcclxuXHQgKiBAcmV0dXJucyB7b2JqZWN0fGJvb2xlYW59XHRcdFx0XHRcdHsgaWQ6IDIgLOKApiB9XHJcblx0ICovXHJcblx0b2JqLmNhbGVuZGFyX19nZXRfcGFyYW1ldGVycyA9IGZ1bmN0aW9uICggcmVzb3VyY2VfaWQgKSB7XHJcblxyXG5cdFx0aWYgKCBvYmouY2FsZW5kYXJfX2lzX2RlZmluZWQoIHJlc291cmNlX2lkICkgKXtcclxuXHJcblx0XHRcdHJldHVybiBwX2NhbGVuZGFyc1sgJ2NhbGVuZGFyXycgKyByZXNvdXJjZV9pZCBdO1xyXG5cdFx0fSBlbHNlIHtcclxuXHRcdFx0cmV0dXJuIGZhbHNlO1xyXG5cdFx0fVxyXG5cdH07XHJcblxyXG5cdC8qKlxyXG5cdCAqIFNldCBjYWxlbmRhciBvYmplY3QgICA6OiAgIHsgZGF0ZXM6ICBPYmplY3QgeyBcIjIwMjMtMDctMjFcIjoge+KApn0sIFwiMjAyMy0wNy0yMlwiOiB74oCmfSwgXCIyMDIzLTA3LTIzXCI6IHvigKZ9LCDigKYgfVxyXG5cdCAqXHJcblx0ICogaWYgY2FsZW5kYXIgb2JqZWN0ICBub3QgZGVmaW5lZCwgdGhlbiAgaXQncyB3aWxsIGJlIGRlZmluZWQgYW5kIElEIHNldFxyXG5cdCAqIGlmIGNhbGVuZGFyIGV4aXN0LCB0aGVuICBzeXN0ZW0gc2V0ICBhcyBuZXcgb3Igb3ZlcndyaXRlIG9ubHkgcHJvcGVydGllcyBmcm9tIGNhbGVuZGFyX3Byb3BlcnR5X29iaiBwYXJhbWV0ZXIsICBidXQgb3RoZXIgcHJvcGVydGllcyB3aWxsIGJlIGV4aXN0ZWQgYW5kIG5vdCBvdmVyd3JpdGUsIGxpa2UgJ2lkJ1xyXG5cdCAqXHJcblx0ICogQHBhcmFtIHtzdHJpbmd8aW50fSByZXNvdXJjZV9pZFx0XHRcdFx0ICAnMidcclxuXHQgKiBAcGFyYW0ge29iamVjdH0gY2FsZW5kYXJfcHJvcGVydHlfb2JqXHRcdFx0XHRcdCAgeyAgZGF0ZXM6ICBPYmplY3QgeyBcIjIwMjMtMDctMjFcIjoge+KApn0sIFwiMjAyMy0wNy0yMlwiOiB74oCmfSwgXCIyMDIzLTA3LTIzXCI6IHvigKZ9LCDigKYgfSAgfVxyXG5cdCAqIEBwYXJhbSB7Ym9vbGVhbn0gaXNfY29tcGxldGVfb3ZlcndyaXRlXHRcdCAgaWYgJ3RydWUnIChkZWZhdWx0OiAnZmFsc2UnKSwgIHRoZW4gIG9ubHkgb3ZlcndyaXRlIG9yIGFkZCAgbmV3IHByb3BlcnRpZXMgaW4gIGNhbGVuZGFyX3Byb3BlcnR5X29ialxyXG5cdCAqIEByZXR1cm5zIHsqfVxyXG5cdCAqXHJcblx0ICogRXhhbXBsZXM6XHJcblx0ICpcclxuXHQgKiBDb21tb24gdXNhZ2UgaW4gUEhQOlxyXG5cdCAqICAgXHRcdFx0ZWNobyBcIiAgX3dwYmMuY2FsZW5kYXJfX3NldCggIFwiIC5pbnR2YWwoICRyZXNvdXJjZV9pZCApIC4gXCIsIHsgJ2RhdGVzJzogXCIgLiB3cF9qc29uX2VuY29kZSggJGF2YWlsYWJpbGl0eV9wZXJfZGF5c19hcnIgKSAuIFwiIH0gKTtcIjtcclxuXHQgKi9cclxuXHRvYmouY2FsZW5kYXJfX3NldF9wYXJhbWV0ZXJzID0gZnVuY3Rpb24gKCByZXNvdXJjZV9pZCwgY2FsZW5kYXJfcHJvcGVydHlfb2JqLCBpc19jb21wbGV0ZV9vdmVyd3JpdGUgPSBmYWxzZSAgKSB7XHJcblxyXG5cdFx0aWYgKCAoIW9iai5jYWxlbmRhcl9faXNfZGVmaW5lZCggcmVzb3VyY2VfaWQgKSkgfHwgKHRydWUgPT09IGlzX2NvbXBsZXRlX292ZXJ3cml0ZSkgKXtcclxuXHRcdFx0b2JqLmNhbGVuZGFyX19pbml0KCByZXNvdXJjZV9pZCApO1xyXG5cdFx0fVxyXG5cclxuXHRcdGZvciAoIHZhciBwcm9wX25hbWUgaW4gY2FsZW5kYXJfcHJvcGVydHlfb2JqICl7XHJcblxyXG5cdFx0XHRwX2NhbGVuZGFyc1sgJ2NhbGVuZGFyXycgKyByZXNvdXJjZV9pZCBdWyBwcm9wX25hbWUgXSA9IGNhbGVuZGFyX3Byb3BlcnR5X29ialsgcHJvcF9uYW1lIF07XHJcblx0XHR9XHJcblxyXG5cdFx0cmV0dXJuIHBfY2FsZW5kYXJzWyAnY2FsZW5kYXJfJyArIHJlc291cmNlX2lkIF07XHJcblx0fTtcclxuXHJcblx0LyoqXHJcblx0ICogU2V0IHByb3BlcnR5ICB0byAgY2FsZW5kYXJcclxuXHQgKiBAcGFyYW0gcmVzb3VyY2VfaWRcdFwiMVwiXHJcblx0ICogQHBhcmFtIHByb3BfbmFtZVx0XHRuYW1lIG9mIHByb3BlcnR5XHJcblx0ICogQHBhcmFtIHByb3BfdmFsdWVcdHZhbHVlIG9mIHByb3BlcnR5XHJcblx0ICogQHJldHVybnMgeyp9XHRcdFx0Y2FsZW5kYXIgb2JqZWN0XHJcblx0ICovXHJcblx0b2JqLmNhbGVuZGFyX19zZXRfcGFyYW1fdmFsdWUgPSBmdW5jdGlvbiAoIHJlc291cmNlX2lkLCBwcm9wX25hbWUsIHByb3BfdmFsdWUgKSB7XHJcblxyXG5cdFx0aWYgKCAoIW9iai5jYWxlbmRhcl9faXNfZGVmaW5lZCggcmVzb3VyY2VfaWQgKSkgKXtcclxuXHRcdFx0b2JqLmNhbGVuZGFyX19pbml0KCByZXNvdXJjZV9pZCApO1xyXG5cdFx0fVxyXG5cclxuXHRcdHBfY2FsZW5kYXJzWyAnY2FsZW5kYXJfJyArIHJlc291cmNlX2lkIF1bIHByb3BfbmFtZSBdID0gcHJvcF92YWx1ZTtcclxuXHJcblx0XHRyZXR1cm4gcF9jYWxlbmRhcnNbICdjYWxlbmRhcl8nICsgcmVzb3VyY2VfaWQgXTtcclxuXHR9O1xyXG5cclxuXHQvKipcclxuXHQgKiAgR2V0IGNhbGVuZGFyIHByb3BlcnR5IHZhbHVlICAgXHQ6OiAgIG1peGVkIHwgbnVsbFxyXG5cdCAqXHJcblx0ICogQHBhcmFtIHtzdHJpbmd8aW50fSAgcmVzb3VyY2VfaWRcdFx0JzEnXHJcblx0ICogQHBhcmFtIHtzdHJpbmd9IHByb3BfbmFtZVx0XHRcdCdzZWxlY3Rpb25fbW9kZSdcclxuXHQgKiBAcmV0dXJucyB7KnxudWxsfVx0XHRcdFx0XHRtaXhlZCB8IG51bGxcclxuXHQgKi9cclxuXHRvYmouY2FsZW5kYXJfX2dldF9wYXJhbV92YWx1ZSA9IGZ1bmN0aW9uKCByZXNvdXJjZV9pZCwgcHJvcF9uYW1lICl7XHJcblxyXG5cdFx0aWYgKFxyXG5cdFx0XHQgICAoIG9iai5jYWxlbmRhcl9faXNfZGVmaW5lZCggcmVzb3VyY2VfaWQgKSApXHJcblx0XHRcdCYmICggJ3VuZGVmaW5lZCcgIT09IHR5cGVvZiAoIHBfY2FsZW5kYXJzWyAnY2FsZW5kYXJfJyArIHJlc291cmNlX2lkIF1bIHByb3BfbmFtZSBdICkgKVxyXG5cdFx0KXtcclxuXHRcdFx0Ly9GaXhJbjogOS45LjAuMjlcclxuXHRcdFx0aWYgKCBvYmouY2FsZW5kYXJfX2lzX3Byb3BfaW50KCBwcm9wX25hbWUgKSApe1xyXG5cdFx0XHRcdHBfY2FsZW5kYXJzWyAnY2FsZW5kYXJfJyArIHJlc291cmNlX2lkIF1bIHByb3BfbmFtZSBdID0gcGFyc2VJbnQoIHBfY2FsZW5kYXJzWyAnY2FsZW5kYXJfJyArIHJlc291cmNlX2lkIF1bIHByb3BfbmFtZSBdICk7XHJcblx0XHRcdH1cclxuXHRcdFx0cmV0dXJuICBwX2NhbGVuZGFyc1sgJ2NhbGVuZGFyXycgKyByZXNvdXJjZV9pZCBdWyBwcm9wX25hbWUgXTtcclxuXHRcdH1cclxuXHJcblx0XHRyZXR1cm4gbnVsbDtcdFx0Ly8gSWYgc29tZSBwcm9wZXJ0eSBub3QgZGVmaW5lZCwgdGhlbiBudWxsO1xyXG5cdH07XHJcblx0Ly8gLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHJcblxyXG5cdC8vIEJvb2tpbmdzIFx0LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cdHZhciBwX2Jvb2tpbmdzID0gb2JqLmJvb2tpbmdzX29iaiA9IG9iai5ib29raW5nc19vYmogfHwge1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdC8vIGNhbGVuZGFyXzE6IE9iamVjdCB7XHJcbiBcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdC8vXHRcdFx0XHRcdFx0ICAgaWQ6ICAgICAxXHJcbiBcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdC8vXHRcdFx0XHRcdFx0ICwgZGF0ZXM6ICBPYmplY3QgeyBcIjIwMjMtMDctMjFcIjoge+KApn0sIFwiMjAyMy0wNy0yMlwiOiB74oCmfSwgXCIyMDIzLTA3LTIzXCI6IHvigKZ9LCDigKZcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQvLyB9XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdH07XHJcblxyXG5cdC8qKlxyXG5cdCAqICBDaGVjayBpZiBib29raW5ncyBmb3Igc3BlY2lmaWMgYm9va2luZyByZXNvdXJjZSBkZWZpbmVkICAgOjogICB0cnVlIHwgZmFsc2VcclxuXHQgKlxyXG5cdCAqIEBwYXJhbSB7c3RyaW5nfGludH0gcmVzb3VyY2VfaWRcclxuXHQgKiBAcmV0dXJucyB7Ym9vbGVhbn1cclxuXHQgKi9cclxuXHRvYmouYm9va2luZ3NfaW5fY2FsZW5kYXJfX2lzX2RlZmluZWQgPSBmdW5jdGlvbiAoIHJlc291cmNlX2lkICkge1xyXG5cclxuXHRcdHJldHVybiAoJ3VuZGVmaW5lZCcgIT09IHR5cGVvZiggcF9ib29raW5nc1sgJ2NhbGVuZGFyXycgKyByZXNvdXJjZV9pZCBdICkgKTtcclxuXHR9O1xyXG5cclxuXHQvKipcclxuXHQgKiBHZXQgYm9va2luZ3MgY2FsZW5kYXIgb2JqZWN0ICAgOjogICB7IGlkOiAxICwgZGF0ZXM6ICBPYmplY3QgeyBcIjIwMjMtMDctMjFcIjoge+KApn0sIFwiMjAyMy0wNy0yMlwiOiB74oCmfSwgXCIyMDIzLTA3LTIzXCI6IHvigKZ9LCDigKYgfVxyXG5cdCAqXHJcblx0ICogQHBhcmFtIHtzdHJpbmd8aW50fSByZXNvdXJjZV9pZFx0XHRcdFx0ICAnMidcclxuXHQgKiBAcmV0dXJucyB7b2JqZWN0fGJvb2xlYW59XHRcdFx0XHRcdHsgaWQ6IDIgLCBkYXRlczogIE9iamVjdCB7IFwiMjAyMy0wNy0yMVwiOiB74oCmfSwgXCIyMDIzLTA3LTIyXCI6IHvigKZ9LCBcIjIwMjMtMDctMjNcIjoge+KApn0sIOKApiB9XHJcblx0ICovXHJcblx0b2JqLmJvb2tpbmdzX2luX2NhbGVuZGFyX19nZXQgPSBmdW5jdGlvbiggcmVzb3VyY2VfaWQgKXtcclxuXHJcblx0XHRpZiAoIG9iai5ib29raW5nc19pbl9jYWxlbmRhcl9faXNfZGVmaW5lZCggcmVzb3VyY2VfaWQgKSApe1xyXG5cclxuXHRcdFx0cmV0dXJuIHBfYm9va2luZ3NbICdjYWxlbmRhcl8nICsgcmVzb3VyY2VfaWQgXTtcclxuXHRcdH0gZWxzZSB7XHJcblx0XHRcdHJldHVybiBmYWxzZTtcclxuXHRcdH1cclxuXHR9O1xyXG5cclxuXHQvKipcclxuXHQgKiBTZXQgYm9va2luZ3MgY2FsZW5kYXIgb2JqZWN0ICAgOjogICB7IGRhdGVzOiAgT2JqZWN0IHsgXCIyMDIzLTA3LTIxXCI6IHvigKZ9LCBcIjIwMjMtMDctMjJcIjoge+KApn0sIFwiMjAyMy0wNy0yM1wiOiB74oCmfSwg4oCmIH1cclxuXHQgKlxyXG5cdCAqIGlmIGNhbGVuZGFyIG9iamVjdCAgbm90IGRlZmluZWQsIHRoZW4gIGl0J3Mgd2lsbCBiZSBkZWZpbmVkIGFuZCBJRCBzZXRcclxuXHQgKiBpZiBjYWxlbmRhciBleGlzdCwgdGhlbiAgc3lzdGVtIHNldCAgYXMgbmV3IG9yIG92ZXJ3cml0ZSBvbmx5IHByb3BlcnRpZXMgZnJvbSBjYWxlbmRhcl9vYmogcGFyYW1ldGVyLCAgYnV0IG90aGVyIHByb3BlcnRpZXMgd2lsbCBiZSBleGlzdGVkIGFuZCBub3Qgb3ZlcndyaXRlLCBsaWtlICdpZCdcclxuXHQgKlxyXG5cdCAqIEBwYXJhbSB7c3RyaW5nfGludH0gcmVzb3VyY2VfaWRcdFx0XHRcdCAgJzInXHJcblx0ICogQHBhcmFtIHtvYmplY3R9IGNhbGVuZGFyX29ialx0XHRcdFx0XHQgIHsgIGRhdGVzOiAgT2JqZWN0IHsgXCIyMDIzLTA3LTIxXCI6IHvigKZ9LCBcIjIwMjMtMDctMjJcIjoge+KApn0sIFwiMjAyMy0wNy0yM1wiOiB74oCmfSwg4oCmIH0gIH1cclxuXHQgKiBAcmV0dXJucyB7Kn1cclxuXHQgKlxyXG5cdCAqIEV4YW1wbGVzOlxyXG5cdCAqXHJcblx0ICogQ29tbW9uIHVzYWdlIGluIFBIUDpcclxuXHQgKiAgIFx0XHRcdGVjaG8gXCIgIF93cGJjLmJvb2tpbmdzX2luX2NhbGVuZGFyX19zZXQoICBcIiAuaW50dmFsKCAkcmVzb3VyY2VfaWQgKSAuIFwiLCB7ICdkYXRlcyc6IFwiIC4gd3BfanNvbl9lbmNvZGUoICRhdmFpbGFiaWxpdHlfcGVyX2RheXNfYXJyICkgLiBcIiB9ICk7XCI7XHJcblx0ICovXHJcblx0b2JqLmJvb2tpbmdzX2luX2NhbGVuZGFyX19zZXQgPSBmdW5jdGlvbiggcmVzb3VyY2VfaWQsIGNhbGVuZGFyX29iaiApe1xyXG5cclxuXHRcdGlmICggISBvYmouYm9va2luZ3NfaW5fY2FsZW5kYXJfX2lzX2RlZmluZWQoIHJlc291cmNlX2lkICkgKXtcclxuXHRcdFx0cF9ib29raW5nc1sgJ2NhbGVuZGFyXycgKyByZXNvdXJjZV9pZCBdID0ge307XHJcblx0XHRcdHBfYm9va2luZ3NbICdjYWxlbmRhcl8nICsgcmVzb3VyY2VfaWQgXVsgJ2lkJyBdID0gcmVzb3VyY2VfaWQ7XHJcblx0XHR9XHJcblxyXG5cdFx0Zm9yICggdmFyIHByb3BfbmFtZSBpbiBjYWxlbmRhcl9vYmogKXtcclxuXHJcblx0XHRcdHBfYm9va2luZ3NbICdjYWxlbmRhcl8nICsgcmVzb3VyY2VfaWQgXVsgcHJvcF9uYW1lIF0gPSBjYWxlbmRhcl9vYmpbIHByb3BfbmFtZSBdO1xyXG5cdFx0fVxyXG5cclxuXHRcdHJldHVybiBwX2Jvb2tpbmdzWyAnY2FsZW5kYXJfJyArIHJlc291cmNlX2lkIF07XHJcblx0fTtcclxuXHJcblx0Ly8gRGF0ZXNcclxuXHJcblx0LyoqXHJcblx0ICogIEdldCBib29raW5ncyBkYXRhIGZvciBBTEwgRGF0ZXMgaW4gY2FsZW5kYXIgICA6OiAgIGZhbHNlIHwgeyBcIjIwMjMtMDctMjJcIjoge+KApn0sIFwiMjAyMy0wNy0yM1wiOiB74oCmfSwg4oCmIH1cclxuXHQgKlxyXG5cdCAqIEBwYXJhbSB7c3RyaW5nfGludH0gcmVzb3VyY2VfaWRcdFx0XHQnMSdcclxuXHQgKiBAcmV0dXJucyB7b2JqZWN0fGJvb2xlYW59XHRcdFx0XHRmYWxzZSB8IE9iamVjdCB7XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XCIyMDIzLTA3LTI0XCI6IE9iamVjdCB7IFsnc3VtbWFyeSddWydzdGF0dXNfZm9yX2RheSddOiBcImF2YWlsYWJsZVwiLCBkYXlfYXZhaWxhYmlsaXR5OiAxLCBtYXhfY2FwYWNpdHk6IDEsIOKApiB9XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XCIyMDIzLTA3LTI2XCI6IE9iamVjdCB7IFsnc3VtbWFyeSddWydzdGF0dXNfZm9yX2RheSddOiBcImZ1bGxfZGF5X2Jvb2tpbmdcIiwgWydzdW1tYXJ5J11bJ3N0YXR1c19mb3JfYm9va2luZ3MnXTogXCJwZW5kaW5nXCIsIGRheV9hdmFpbGFiaWxpdHk6IDAsIOKApiB9XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XCIyMDIzLTA3LTI5XCI6IE9iamVjdCB7IFsnc3VtbWFyeSddWydzdGF0dXNfZm9yX2RheSddOiBcInJlc291cmNlX2F2YWlsYWJpbGl0eVwiLCBkYXlfYXZhaWxhYmlsaXR5OiAwLCBtYXhfY2FwYWNpdHk6IDEsIOKApiB9XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XCIyMDIzLTA3LTMwXCI6IHvigKZ9LCBcIjIwMjMtMDctMzFcIjoge+KApn0sIOKAplxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHR9XHJcblx0ICovXHJcblx0b2JqLmJvb2tpbmdzX2luX2NhbGVuZGFyX19nZXRfZGF0ZXMgPSBmdW5jdGlvbiggcmVzb3VyY2VfaWQpe1xyXG5cclxuXHRcdGlmIChcclxuXHRcdFx0ICAgKCBvYmouYm9va2luZ3NfaW5fY2FsZW5kYXJfX2lzX2RlZmluZWQoIHJlc291cmNlX2lkICkgKVxyXG5cdFx0XHQmJiAoICd1bmRlZmluZWQnICE9PSB0eXBlb2YgKCBwX2Jvb2tpbmdzWyAnY2FsZW5kYXJfJyArIHJlc291cmNlX2lkIF1bICdkYXRlcycgXSApIClcclxuXHRcdCl7XHJcblx0XHRcdHJldHVybiAgcF9ib29raW5nc1sgJ2NhbGVuZGFyXycgKyByZXNvdXJjZV9pZCBdWyAnZGF0ZXMnIF07XHJcblx0XHR9XHJcblxyXG5cdFx0cmV0dXJuIGZhbHNlO1x0XHQvLyBJZiBzb21lIHByb3BlcnR5IG5vdCBkZWZpbmVkLCB0aGVuIGZhbHNlO1xyXG5cdH07XHJcblxyXG5cdC8qKlxyXG5cdCAqIFNldCBib29raW5ncyBkYXRlcyBpbiBjYWxlbmRhciBvYmplY3QgICA6OiAgICB7IFwiMjAyMy0wNy0yMVwiOiB74oCmfSwgXCIyMDIzLTA3LTIyXCI6IHvigKZ9LCBcIjIwMjMtMDctMjNcIjoge+KApn0sIOKApiB9XHJcblx0ICpcclxuXHQgKiBpZiBjYWxlbmRhciBvYmplY3QgIG5vdCBkZWZpbmVkLCB0aGVuICBpdCdzIHdpbGwgYmUgZGVmaW5lZCBhbmQgJ2lkJywgJ2RhdGVzJyBzZXRcclxuXHQgKiBpZiBjYWxlbmRhciBleGlzdCwgdGhlbiBzeXN0ZW0gYWRkIGEgIG5ldyBvciBvdmVyd3JpdGUgb25seSBkYXRlcyBmcm9tIGRhdGVzX29iaiBwYXJhbWV0ZXIsXHJcblx0ICogYnV0IG90aGVyIGRhdGVzIG5vdCBmcm9tIHBhcmFtZXRlciBkYXRlc19vYmogd2lsbCBiZSBleGlzdGVkIGFuZCBub3Qgb3ZlcndyaXRlLlxyXG5cdCAqXHJcblx0ICogQHBhcmFtIHtzdHJpbmd8aW50fSByZXNvdXJjZV9pZFx0XHRcdFx0ICAnMidcclxuXHQgKiBAcGFyYW0ge29iamVjdH0gZGF0ZXNfb2JqXHRcdFx0XHRcdCAgeyBcIjIwMjMtMDctMjFcIjoge+KApn0sIFwiMjAyMy0wNy0yMlwiOiB74oCmfSwgXCIyMDIzLTA3LTIzXCI6IHvigKZ9LCDigKYgfVxyXG5cdCAqIEBwYXJhbSB7Ym9vbGVhbn0gaXNfY29tcGxldGVfb3ZlcndyaXRlXHRcdCAgaWYgZmFsc2UsICB0aGVuICBvbmx5IG92ZXJ3cml0ZSBvciBhZGQgIGRhdGVzIGZyb20gXHRkYXRlc19vYmpcclxuXHQgKiBAcmV0dXJucyB7Kn1cclxuXHQgKlxyXG5cdCAqIEV4YW1wbGVzOlxyXG5cdCAqICAgXHRcdFx0X3dwYmMuYm9va2luZ3NfaW5fY2FsZW5kYXJfX3NldF9kYXRlcyggcmVzb3VyY2VfaWQsIHsgXCIyMDIzLTA3LTIxXCI6IHvigKZ9LCBcIjIwMjMtMDctMjJcIjoge+KApn0sIOKApiB9ICApO1x0XHQ8LSAgIG92ZXJ3cml0ZSBBTEwgZGF0ZXNcclxuXHQgKiAgIFx0XHRcdF93cGJjLmJvb2tpbmdzX2luX2NhbGVuZGFyX19zZXRfZGF0ZXMoIHJlc291cmNlX2lkLCB7IFwiMjAyMy0wNy0yMlwiOiB74oCmfSB9LCAgZmFsc2UgICk7XHRcdFx0XHRcdDwtICAgYWRkIG9yIG92ZXJ3cml0ZSBvbmx5ICBcdFwiMjAyMy0wNy0yMlwiOiB7fVxyXG5cdCAqXHJcblx0ICogQ29tbW9uIHVzYWdlIGluIFBIUDpcclxuXHQgKiAgIFx0XHRcdGVjaG8gXCIgIF93cGJjLmJvb2tpbmdzX2luX2NhbGVuZGFyX19zZXRfZGF0ZXMoICBcIiAuIGludHZhbCggJHJlc291cmNlX2lkICkgLiBcIiwgIFwiIC4gd3BfanNvbl9lbmNvZGUoICRhdmFpbGFiaWxpdHlfcGVyX2RheXNfYXJyICkgLiBcIiAgKTsgIFwiO1xyXG5cdCAqL1xyXG5cdG9iai5ib29raW5nc19pbl9jYWxlbmRhcl9fc2V0X2RhdGVzID0gZnVuY3Rpb24oIHJlc291cmNlX2lkLCBkYXRlc19vYmogLCBpc19jb21wbGV0ZV9vdmVyd3JpdGUgPSB0cnVlICl7XHJcblxyXG5cdFx0aWYgKCAhb2JqLmJvb2tpbmdzX2luX2NhbGVuZGFyX19pc19kZWZpbmVkKCByZXNvdXJjZV9pZCApICl7XHJcblx0XHRcdG9iai5ib29raW5nc19pbl9jYWxlbmRhcl9fc2V0KCByZXNvdXJjZV9pZCwgeyAnZGF0ZXMnOiB7fSB9ICk7XHJcblx0XHR9XHJcblxyXG5cdFx0aWYgKCAndW5kZWZpbmVkJyA9PT0gdHlwZW9mIChwX2Jvb2tpbmdzWyAnY2FsZW5kYXJfJyArIHJlc291cmNlX2lkIF1bICdkYXRlcycgXSkgKXtcclxuXHRcdFx0cF9ib29raW5nc1sgJ2NhbGVuZGFyXycgKyByZXNvdXJjZV9pZCBdWyAnZGF0ZXMnIF0gPSB7fVxyXG5cdFx0fVxyXG5cclxuXHRcdGlmIChpc19jb21wbGV0ZV9vdmVyd3JpdGUpe1xyXG5cclxuXHRcdFx0Ly8gQ29tcGxldGUgb3ZlcndyaXRlIGFsbCAgYm9va2luZyBkYXRlc1xyXG5cdFx0XHRwX2Jvb2tpbmdzWyAnY2FsZW5kYXJfJyArIHJlc291cmNlX2lkIF1bICdkYXRlcycgXSA9IGRhdGVzX29iajtcclxuXHRcdH0gZWxzZSB7XHJcblxyXG5cdFx0XHQvLyBBZGQgb25seSAgbmV3IG9yIG92ZXJ3cml0ZSBleGlzdCBib29raW5nIGRhdGVzIGZyb20gIHBhcmFtZXRlci4gQm9va2luZyBkYXRlcyBub3QgZnJvbSAgcGFyYW1ldGVyICB3aWxsICBiZSB3aXRob3V0IGNobmFuZ2VzXHJcblx0XHRcdGZvciAoIHZhciBwcm9wX25hbWUgaW4gZGF0ZXNfb2JqICl7XHJcblxyXG5cdFx0XHRcdHBfYm9va2luZ3NbICdjYWxlbmRhcl8nICsgcmVzb3VyY2VfaWQgXVsnZGF0ZXMnXVsgcHJvcF9uYW1lIF0gPSBkYXRlc19vYmpbIHByb3BfbmFtZSBdO1xyXG5cdFx0XHR9XHJcblx0XHR9XHJcblxyXG5cdFx0cmV0dXJuIHBfYm9va2luZ3NbICdjYWxlbmRhcl8nICsgcmVzb3VyY2VfaWQgXTtcclxuXHR9O1xyXG5cclxuXHJcblx0LyoqXHJcblx0ICogIEdldCBib29raW5ncyBkYXRhIGZvciBzcGVjaWZpYyBkYXRlIGluIGNhbGVuZGFyICAgOjogICBmYWxzZSB8IHsgZGF5X2F2YWlsYWJpbGl0eTogMSwgLi4uIH1cclxuXHQgKlxyXG5cdCAqIEBwYXJhbSB7c3RyaW5nfGludH0gcmVzb3VyY2VfaWRcdFx0XHQnMSdcclxuXHQgKiBAcGFyYW0ge3N0cmluZ30gc3FsX2NsYXNzX2RheVx0XHRcdCcyMDIzLTA3LTIxJ1xyXG5cdCAqIEByZXR1cm5zIHtvYmplY3R8Ym9vbGVhbn1cdFx0XHRcdGZhbHNlIHwge1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRkYXlfYXZhaWxhYmlsaXR5OiA0XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdG1heF9jYXBhY2l0eTogNFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdC8vICA+PSBCdXNpbmVzcyBMYXJnZVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQyOiBPYmplY3QgeyBpc19kYXlfdW5hdmFpbGFibGU6IGZhbHNlLCBfZGF5X3N0YXR1czogXCJhdmFpbGFibGVcIiB9XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdDEwOiBPYmplY3QgeyBpc19kYXlfdW5hdmFpbGFibGU6IGZhbHNlLCBfZGF5X3N0YXR1czogXCJhdmFpbGFibGVcIiB9XHRcdC8vICA+PSBCdXNpbmVzcyBMYXJnZSAuLi5cclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0MTE6IE9iamVjdCB7IGlzX2RheV91bmF2YWlsYWJsZTogZmFsc2UsIF9kYXlfc3RhdHVzOiBcImF2YWlsYWJsZVwiIH1cclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0MTI6IE9iamVjdCB7IGlzX2RheV91bmF2YWlsYWJsZTogZmFsc2UsIF9kYXlfc3RhdHVzOiBcImF2YWlsYWJsZVwiIH1cclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdH1cclxuXHQgKi9cclxuXHRvYmouYm9va2luZ3NfaW5fY2FsZW5kYXJfX2dldF9mb3JfZGF0ZSA9IGZ1bmN0aW9uKCByZXNvdXJjZV9pZCwgc3FsX2NsYXNzX2RheSApe1xyXG5cclxuXHRcdGlmIChcclxuXHRcdFx0ICAgKCBvYmouYm9va2luZ3NfaW5fY2FsZW5kYXJfX2lzX2RlZmluZWQoIHJlc291cmNlX2lkICkgKVxyXG5cdFx0XHQmJiAoICd1bmRlZmluZWQnICE9PSB0eXBlb2YgKCBwX2Jvb2tpbmdzWyAnY2FsZW5kYXJfJyArIHJlc291cmNlX2lkIF1bICdkYXRlcycgXSApIClcclxuXHRcdFx0JiYgKCAndW5kZWZpbmVkJyAhPT0gdHlwZW9mICggcF9ib29raW5nc1sgJ2NhbGVuZGFyXycgKyByZXNvdXJjZV9pZCBdWyAnZGF0ZXMnIF1bIHNxbF9jbGFzc19kYXkgXSApIClcclxuXHRcdCl7XHJcblx0XHRcdHJldHVybiAgcF9ib29raW5nc1sgJ2NhbGVuZGFyXycgKyByZXNvdXJjZV9pZCBdWyAnZGF0ZXMnIF1bIHNxbF9jbGFzc19kYXkgXTtcclxuXHRcdH1cclxuXHJcblx0XHRyZXR1cm4gZmFsc2U7XHRcdC8vIElmIHNvbWUgcHJvcGVydHkgbm90IGRlZmluZWQsIHRoZW4gZmFsc2U7XHJcblx0fTtcclxuXHJcblxyXG5cdC8vIEFueSAgUEFSQU1TICAgaW4gYm9va2luZ3NcclxuXHJcblx0LyoqXHJcblx0ICogU2V0IHByb3BlcnR5ICB0byAgYm9va2luZ1xyXG5cdCAqIEBwYXJhbSByZXNvdXJjZV9pZFx0XCIxXCJcclxuXHQgKiBAcGFyYW0gcHJvcF9uYW1lXHRcdG5hbWUgb2YgcHJvcGVydHlcclxuXHQgKiBAcGFyYW0gcHJvcF92YWx1ZVx0dmFsdWUgb2YgcHJvcGVydHlcclxuXHQgKiBAcmV0dXJucyB7Kn1cdFx0XHRib29raW5nIG9iamVjdFxyXG5cdCAqL1xyXG5cdG9iai5ib29raW5nX19zZXRfcGFyYW1fdmFsdWUgPSBmdW5jdGlvbiAoIHJlc291cmNlX2lkLCBwcm9wX25hbWUsIHByb3BfdmFsdWUgKSB7XHJcblxyXG5cdFx0aWYgKCAhIG9iai5ib29raW5nc19pbl9jYWxlbmRhcl9faXNfZGVmaW5lZCggcmVzb3VyY2VfaWQgKSApe1xyXG5cdFx0XHRwX2Jvb2tpbmdzWyAnY2FsZW5kYXJfJyArIHJlc291cmNlX2lkIF0gPSB7fTtcclxuXHRcdFx0cF9ib29raW5nc1sgJ2NhbGVuZGFyXycgKyByZXNvdXJjZV9pZCBdWyAnaWQnIF0gPSByZXNvdXJjZV9pZDtcclxuXHRcdH1cclxuXHJcblx0XHRwX2Jvb2tpbmdzWyAnY2FsZW5kYXJfJyArIHJlc291cmNlX2lkIF1bIHByb3BfbmFtZSBdID0gcHJvcF92YWx1ZTtcclxuXHJcblx0XHRyZXR1cm4gcF9ib29raW5nc1sgJ2NhbGVuZGFyXycgKyByZXNvdXJjZV9pZCBdO1xyXG5cdH07XHJcblxyXG5cdC8qKlxyXG5cdCAqICBHZXQgYm9va2luZyBwcm9wZXJ0eSB2YWx1ZSAgIFx0OjogICBtaXhlZCB8IG51bGxcclxuXHQgKlxyXG5cdCAqIEBwYXJhbSB7c3RyaW5nfGludH0gIHJlc291cmNlX2lkXHRcdCcxJ1xyXG5cdCAqIEBwYXJhbSB7c3RyaW5nfSBwcm9wX25hbWVcdFx0XHQnc2VsZWN0aW9uX21vZGUnXHJcblx0ICogQHJldHVybnMgeyp8bnVsbH1cdFx0XHRcdFx0bWl4ZWQgfCBudWxsXHJcblx0ICovXHJcblx0b2JqLmJvb2tpbmdfX2dldF9wYXJhbV92YWx1ZSA9IGZ1bmN0aW9uKCByZXNvdXJjZV9pZCwgcHJvcF9uYW1lICl7XHJcblxyXG5cdFx0aWYgKFxyXG5cdFx0XHQgICAoIG9iai5ib29raW5nc19pbl9jYWxlbmRhcl9faXNfZGVmaW5lZCggcmVzb3VyY2VfaWQgKSApXHJcblx0XHRcdCYmICggJ3VuZGVmaW5lZCcgIT09IHR5cGVvZiAoIHBfYm9va2luZ3NbICdjYWxlbmRhcl8nICsgcmVzb3VyY2VfaWQgXVsgcHJvcF9uYW1lIF0gKSApXHJcblx0XHQpe1xyXG5cdFx0XHRyZXR1cm4gIHBfYm9va2luZ3NbICdjYWxlbmRhcl8nICsgcmVzb3VyY2VfaWQgXVsgcHJvcF9uYW1lIF07XHJcblx0XHR9XHJcblxyXG5cdFx0cmV0dXJuIG51bGw7XHRcdC8vIElmIHNvbWUgcHJvcGVydHkgbm90IGRlZmluZWQsIHRoZW4gbnVsbDtcclxuXHR9O1xyXG5cclxuXHJcblxyXG5cclxuXHQvKipcclxuXHQgKiBTZXQgYm9va2luZ3MgZm9yIGFsbCAgY2FsZW5kYXJzXHJcblx0ICpcclxuXHQgKiBAcGFyYW0ge29iamVjdH0gY2FsZW5kYXJzX29ialx0XHRPYmplY3QgeyBjYWxlbmRhcl8xOiB7IGlkOiAxLCBkYXRlczogT2JqZWN0IHsgXCIyMDIzLTA3LTIyXCI6IHvigKZ9LCBcIjIwMjMtMDctMjNcIjoge+KApn0sIFwiMjAyMy0wNy0yNFwiOiB74oCmfSwg4oCmIH0gfVxyXG5cdCAqIFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCBjYWxlbmRhcl8zOiB7fSwgLi4uIH1cclxuXHQgKi9cclxuXHRvYmouYm9va2luZ3NfaW5fY2FsZW5kYXJzX19zZXRfYWxsID0gZnVuY3Rpb24gKCBjYWxlbmRhcnNfb2JqICkge1xyXG5cdFx0cF9ib29raW5ncyA9IGNhbGVuZGFyc19vYmo7XHJcblx0fTtcclxuXHJcblx0LyoqXHJcblx0ICogR2V0IGJvb2tpbmdzIGluIGFsbCBjYWxlbmRhcnNcclxuXHQgKlxyXG5cdCAqIEByZXR1cm5zIHtvYmplY3R8e319XHJcblx0ICovXHJcblx0b2JqLmJvb2tpbmdzX2luX2NhbGVuZGFyc19fZ2V0X2FsbCA9IGZ1bmN0aW9uICgpIHtcclxuXHRcdHJldHVybiBwX2Jvb2tpbmdzO1xyXG5cdH07XHJcblx0Ly8gLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHJcblxyXG5cclxuXHJcblx0Ly8gU2Vhc29ucyBcdC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHR2YXIgcF9zZWFzb25zID0gb2JqLnNlYXNvbnNfb2JqID0gb2JqLnNlYXNvbnNfb2JqIHx8IHtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQvLyBjYWxlbmRhcl8xOiBPYmplY3Qge1xyXG4gXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQvL1x0XHRcdFx0XHRcdCAgIGlkOiAgICAgMVxyXG4gXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQvL1x0XHRcdFx0XHRcdCAsIGRhdGVzOiAgT2JqZWN0IHsgXCIyMDIzLTA3LTIxXCI6IHvigKZ9LCBcIjIwMjMtMDctMjJcIjoge+KApn0sIFwiMjAyMy0wNy0yM1wiOiB74oCmfSwg4oCmXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0Ly8gfVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHR9O1xyXG5cclxuXHQvKipcclxuXHQgKiBBZGQgc2Vhc29uIG5hbWVzIGZvciBkYXRlcyBpbiBjYWxlbmRhciBvYmplY3QgICA6OiAgICB7IFwiMjAyMy0wNy0yMVwiOiBbICd3cGJjX3NlYXNvbl9zZXB0ZW1iZXJfMjAyMycsICd3cGJjX3NlYXNvbl9zZXB0ZW1iZXJfMjAyNCcgXSwgXCIyMDIzLTA3LTIyXCI6IFsuLi5dLCAuLi4gfVxyXG5cdCAqXHJcblx0ICpcclxuXHQgKiBAcGFyYW0ge3N0cmluZ3xpbnR9IHJlc291cmNlX2lkXHRcdFx0XHQgICcyJ1xyXG5cdCAqIEBwYXJhbSB7b2JqZWN0fSBkYXRlc19vYmpcdFx0XHRcdFx0ICB7IFwiMjAyMy0wNy0yMVwiOiB74oCmfSwgXCIyMDIzLTA3LTIyXCI6IHvigKZ9LCBcIjIwMjMtMDctMjNcIjoge+KApn0sIOKApiB9XHJcblx0ICogQHBhcmFtIHtib29sZWFufSBpc19jb21wbGV0ZV9vdmVyd3JpdGVcdFx0ICBpZiBmYWxzZSwgIHRoZW4gIG9ubHkgIGFkZCAgZGF0ZXMgZnJvbSBcdGRhdGVzX29ialxyXG5cdCAqIEByZXR1cm5zIHsqfVxyXG5cdCAqXHJcblx0ICogRXhhbXBsZXM6XHJcblx0ICogICBcdFx0XHRfd3BiYy5zZWFzb25zX19zZXQoIHJlc291cmNlX2lkLCB7IFwiMjAyMy0wNy0yMVwiOiBbICd3cGJjX3NlYXNvbl9zZXB0ZW1iZXJfMjAyMycsICd3cGJjX3NlYXNvbl9zZXB0ZW1iZXJfMjAyNCcgXSwgXCIyMDIzLTA3LTIyXCI6IFsuLi5dLCAuLi4gfSAgKTtcclxuXHQgKi9cclxuXHRvYmouc2Vhc29uc19fc2V0ID0gZnVuY3Rpb24oIHJlc291cmNlX2lkLCBkYXRlc19vYmogLCBpc19jb21wbGV0ZV9vdmVyd3JpdGUgPSBmYWxzZSApe1xyXG5cclxuXHRcdGlmICggJ3VuZGVmaW5lZCcgPT09IHR5cGVvZiAocF9zZWFzb25zWyAnY2FsZW5kYXJfJyArIHJlc291cmNlX2lkIF0pICl7XHJcblx0XHRcdHBfc2Vhc29uc1sgJ2NhbGVuZGFyXycgKyByZXNvdXJjZV9pZCBdID0ge307XHJcblx0XHR9XHJcblxyXG5cdFx0aWYgKCBpc19jb21wbGV0ZV9vdmVyd3JpdGUgKXtcclxuXHJcblx0XHRcdC8vIENvbXBsZXRlIG92ZXJ3cml0ZSBhbGwgIHNlYXNvbiBkYXRlc1xyXG5cdFx0XHRwX3NlYXNvbnNbICdjYWxlbmRhcl8nICsgcmVzb3VyY2VfaWQgXSA9IGRhdGVzX29iajtcclxuXHJcblx0XHR9IGVsc2Uge1xyXG5cclxuXHRcdFx0Ly8gQWRkIG9ubHkgIG5ldyBvciBvdmVyd3JpdGUgZXhpc3QgYm9va2luZyBkYXRlcyBmcm9tICBwYXJhbWV0ZXIuIEJvb2tpbmcgZGF0ZXMgbm90IGZyb20gIHBhcmFtZXRlciAgd2lsbCAgYmUgd2l0aG91dCBjaG5hbmdlc1xyXG5cdFx0XHRmb3IgKCB2YXIgcHJvcF9uYW1lIGluIGRhdGVzX29iaiApe1xyXG5cclxuXHRcdFx0XHRpZiAoICd1bmRlZmluZWQnID09PSB0eXBlb2YgKHBfc2Vhc29uc1sgJ2NhbGVuZGFyXycgKyByZXNvdXJjZV9pZCBdWyBwcm9wX25hbWUgXSkgKXtcclxuXHRcdFx0XHRcdHBfc2Vhc29uc1sgJ2NhbGVuZGFyXycgKyByZXNvdXJjZV9pZCBdWyBwcm9wX25hbWUgXSA9IFtdO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0XHRmb3IgKCB2YXIgc2Vhc29uX25hbWVfa2V5IGluIGRhdGVzX29ialsgcHJvcF9uYW1lIF0gKXtcclxuXHRcdFx0XHRcdHBfc2Vhc29uc1sgJ2NhbGVuZGFyXycgKyByZXNvdXJjZV9pZCBdWyBwcm9wX25hbWUgXS5wdXNoKCBkYXRlc19vYmpbIHByb3BfbmFtZSBdWyBzZWFzb25fbmFtZV9rZXkgXSApO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cclxuXHRcdHJldHVybiBwX3NlYXNvbnNbICdjYWxlbmRhcl8nICsgcmVzb3VyY2VfaWQgXTtcclxuXHR9O1xyXG5cclxuXHJcblx0LyoqXHJcblx0ICogIEdldCBib29raW5ncyBkYXRhIGZvciBzcGVjaWZpYyBkYXRlIGluIGNhbGVuZGFyICAgOjogICBbXSB8IFsgJ3dwYmNfc2Vhc29uX3NlcHRlbWJlcl8yMDIzJywgJ3dwYmNfc2Vhc29uX3NlcHRlbWJlcl8yMDI0JyBdXHJcblx0ICpcclxuXHQgKiBAcGFyYW0ge3N0cmluZ3xpbnR9IHJlc291cmNlX2lkXHRcdFx0JzEnXHJcblx0ICogQHBhcmFtIHtzdHJpbmd9IHNxbF9jbGFzc19kYXlcdFx0XHQnMjAyMy0wNy0yMSdcclxuXHQgKiBAcmV0dXJucyB7b2JqZWN0fGJvb2xlYW59XHRcdFx0XHRbXSAgfCAgWyAnd3BiY19zZWFzb25fc2VwdGVtYmVyXzIwMjMnLCAnd3BiY19zZWFzb25fc2VwdGVtYmVyXzIwMjQnIF1cclxuXHQgKi9cclxuXHRvYmouc2Vhc29uc19fZ2V0X2Zvcl9kYXRlID0gZnVuY3Rpb24oIHJlc291cmNlX2lkLCBzcWxfY2xhc3NfZGF5ICl7XHJcblxyXG5cdFx0aWYgKFxyXG5cdFx0XHQgICAoICd1bmRlZmluZWQnICE9PSB0eXBlb2YgKCBwX3NlYXNvbnNbICdjYWxlbmRhcl8nICsgcmVzb3VyY2VfaWQgXSApIClcclxuXHRcdFx0JiYgKCAndW5kZWZpbmVkJyAhPT0gdHlwZW9mICggcF9zZWFzb25zWyAnY2FsZW5kYXJfJyArIHJlc291cmNlX2lkIF1bIHNxbF9jbGFzc19kYXkgXSApIClcclxuXHRcdCl7XHJcblx0XHRcdHJldHVybiAgcF9zZWFzb25zWyAnY2FsZW5kYXJfJyArIHJlc291cmNlX2lkIF1bIHNxbF9jbGFzc19kYXkgXTtcclxuXHRcdH1cclxuXHJcblx0XHRyZXR1cm4gW107XHRcdC8vIElmIG5vdCBkZWZpbmVkLCB0aGVuIFtdO1xyXG5cdH07XHJcblxyXG5cclxuXHQvLyBPdGhlciBwYXJhbWV0ZXJzIFx0XHRcdC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cdHZhciBwX290aGVyID0gb2JqLm90aGVyX29iaiA9IG9iai5vdGhlcl9vYmogfHwgeyB9O1xyXG5cclxuXHRvYmouc2V0X290aGVyX3BhcmFtID0gZnVuY3Rpb24gKCBwYXJhbV9rZXksIHBhcmFtX3ZhbCApIHtcclxuXHRcdHBfb3RoZXJbIHBhcmFtX2tleSBdID0gcGFyYW1fdmFsO1xyXG5cdH07XHJcblxyXG5cdG9iai5nZXRfb3RoZXJfcGFyYW0gPSBmdW5jdGlvbiAoIHBhcmFtX2tleSApIHtcclxuXHRcdHJldHVybiBwX290aGVyWyBwYXJhbV9rZXkgXTtcclxuXHR9O1xyXG5cclxuXHQvKipcclxuXHQgKiBHZXQgYWxsIG90aGVyIHBhcmFtc1xyXG5cdCAqXHJcblx0ICogQHJldHVybnMge29iamVjdHx7fX1cclxuXHQgKi9cclxuXHRvYmouZ2V0X290aGVyX3BhcmFtX19hbGwgPSBmdW5jdGlvbiAoKSB7XHJcblx0XHRyZXR1cm4gcF9vdGhlcjtcclxuXHR9O1xyXG5cclxuXHQvLyBNZXNzYWdlcyBcdFx0XHQgICAgICAgIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cdHZhciBwX21lc3NhZ2VzID0gb2JqLm1lc3NhZ2VzX29iaiA9IG9iai5tZXNzYWdlc19vYmogfHwgeyB9O1xyXG5cclxuXHRvYmouc2V0X21lc3NhZ2UgPSBmdW5jdGlvbiAoIHBhcmFtX2tleSwgcGFyYW1fdmFsICkge1xyXG5cdFx0cF9tZXNzYWdlc1sgcGFyYW1fa2V5IF0gPSBwYXJhbV92YWw7XHJcblx0fTtcclxuXHJcblx0b2JqLmdldF9tZXNzYWdlID0gZnVuY3Rpb24gKCBwYXJhbV9rZXkgKSB7XHJcblx0XHRyZXR1cm4gcF9tZXNzYWdlc1sgcGFyYW1fa2V5IF07XHJcblx0fTtcclxuXHJcblx0LyoqXHJcblx0ICogR2V0IGFsbCBvdGhlciBwYXJhbXNcclxuXHQgKlxyXG5cdCAqIEByZXR1cm5zIHtvYmplY3R8e319XHJcblx0ICovXHJcblx0b2JqLmdldF9tZXNzYWdlc19fYWxsID0gZnVuY3Rpb24gKCkge1xyXG5cdFx0cmV0dXJuIHBfbWVzc2FnZXM7XHJcblx0fTtcclxuXHJcblx0Ly8gLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHJcblx0cmV0dXJuIG9iajtcclxuXHJcbn0oIF93cGJjIHx8IHt9LCBqUXVlcnkgKSk7XHJcbiIsIi8qKlxyXG4gKiBFeHRlbmQgX3dwYmMgd2l0aCAgbmV3IG1ldGhvZHMgICAgICAgIC8vRml4SW46IDkuOC42LjJcclxuICpcclxuICogQHR5cGUgeyp8e319XHJcbiAqIEBwcml2YXRlXHJcbiAqL1xyXG4gX3dwYmMgPSAoZnVuY3Rpb24gKCBvYmosICQpIHtcclxuXHJcblx0Ly8gTG9hZCBCYWxhbmNlciBcdC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblxyXG5cdHZhciBwX2JhbGFuY2VyID0gb2JqLmJhbGFuY2VyX29iaiA9IG9iai5iYWxhbmNlcl9vYmogfHwge1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCdtYXhfdGhyZWFkcyc6IDIsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J2luX3Byb2Nlc3MnIDogW10sXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J3dhaXQnICAgICAgIDogW11cclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0fTtcclxuXHJcblx0IC8qKlxyXG5cdCAgKiBTZXQgIG1heCBwYXJhbGxlbCByZXF1ZXN0ICB0byAgbG9hZFxyXG5cdCAgKlxyXG5cdCAgKiBAcGFyYW0gbWF4X3RocmVhZHNcclxuXHQgICovXHJcblx0b2JqLmJhbGFuY2VyX19zZXRfbWF4X3RocmVhZHMgPSBmdW5jdGlvbiAoIG1heF90aHJlYWRzICl7XHJcblxyXG5cdFx0cF9iYWxhbmNlclsgJ21heF90aHJlYWRzJyBdID0gbWF4X3RocmVhZHM7XHJcblx0fTtcclxuXHJcblx0LyoqXHJcblx0ICogIENoZWNrIGlmIGJhbGFuY2VyIGZvciBzcGVjaWZpYyBib29raW5nIHJlc291cmNlIGRlZmluZWQgICA6OiAgIHRydWUgfCBmYWxzZVxyXG5cdCAqXHJcblx0ICogQHBhcmFtIHtzdHJpbmd8aW50fSByZXNvdXJjZV9pZFxyXG5cdCAqIEByZXR1cm5zIHtib29sZWFufVxyXG5cdCAqL1xyXG5cdG9iai5iYWxhbmNlcl9faXNfZGVmaW5lZCA9IGZ1bmN0aW9uICggcmVzb3VyY2VfaWQgKSB7XHJcblxyXG5cdFx0cmV0dXJuICgndW5kZWZpbmVkJyAhPT0gdHlwZW9mKCBwX2JhbGFuY2VyWyAnYmFsYW5jZXJfJyArIHJlc291cmNlX2lkIF0gKSApO1xyXG5cdH07XHJcblxyXG5cclxuXHQvKipcclxuXHQgKiAgQ3JlYXRlIGJhbGFuY2VyIGluaXRpYWxpemluZ1xyXG5cdCAqXHJcblx0ICogQHBhcmFtIHtzdHJpbmd8aW50fSByZXNvdXJjZV9pZFxyXG5cdCAqL1xyXG5cdG9iai5iYWxhbmNlcl9faW5pdCA9IGZ1bmN0aW9uICggcmVzb3VyY2VfaWQsIGZ1bmN0aW9uX25hbWUgLCBwYXJhbXMgPXt9KSB7XHJcblxyXG5cdFx0dmFyIGJhbGFuY2Vfb2JqID0ge307XHJcblx0XHRiYWxhbmNlX29ialsgJ3Jlc291cmNlX2lkJyBdICAgPSByZXNvdXJjZV9pZDtcclxuXHRcdGJhbGFuY2Vfb2JqWyAncHJpb3JpdHknIF0gICAgICA9IDE7XHJcblx0XHRiYWxhbmNlX29ialsgJ2Z1bmN0aW9uX25hbWUnIF0gPSBmdW5jdGlvbl9uYW1lO1xyXG5cdFx0YmFsYW5jZV9vYmpbICdwYXJhbXMnIF0gICAgICAgID0gd3BiY19jbG9uZV9vYmooIHBhcmFtcyApO1xyXG5cclxuXHJcblx0XHRpZiAoIG9iai5iYWxhbmNlcl9faXNfYWxyZWFkeV9ydW4oIHJlc291cmNlX2lkLCBmdW5jdGlvbl9uYW1lICkgKXtcclxuXHRcdFx0cmV0dXJuICdydW4nO1xyXG5cdFx0fVxyXG5cdFx0aWYgKCBvYmouYmFsYW5jZXJfX2lzX2FscmVhZHlfd2FpdCggcmVzb3VyY2VfaWQsIGZ1bmN0aW9uX25hbWUgKSApe1xyXG5cdFx0XHRyZXR1cm4gJ3dhaXQnO1xyXG5cdFx0fVxyXG5cclxuXHJcblx0XHRpZiAoIG9iai5iYWxhbmNlcl9fY2FuX2lfcnVuKCkgKXtcclxuXHRcdFx0b2JqLmJhbGFuY2VyX19hZGRfdG9fX3J1biggYmFsYW5jZV9vYmogKTtcclxuXHRcdFx0cmV0dXJuICdydW4nO1xyXG5cdFx0fSBlbHNlIHtcclxuXHRcdFx0b2JqLmJhbGFuY2VyX19hZGRfdG9fX3dhaXQoIGJhbGFuY2Vfb2JqICk7XHJcblx0XHRcdHJldHVybiAnd2FpdCc7XHJcblx0XHR9XHJcblx0fTtcclxuXHJcblx0IC8qKlxyXG5cdCAgKiBDYW4gSSBSdW4gP1xyXG5cdCAgKiBAcmV0dXJucyB7Ym9vbGVhbn1cclxuXHQgICovXHJcblx0b2JqLmJhbGFuY2VyX19jYW5faV9ydW4gPSBmdW5jdGlvbiAoKXtcclxuXHRcdHJldHVybiAoIHBfYmFsYW5jZXJbICdpbl9wcm9jZXNzJyBdLmxlbmd0aCA8IHBfYmFsYW5jZXJbICdtYXhfdGhyZWFkcycgXSApO1xyXG5cdH1cclxuXHJcblx0XHQgLyoqXHJcblx0XHQgICogQWRkIHRvIFdBSVRcclxuXHRcdCAgKiBAcGFyYW0gYmFsYW5jZV9vYmpcclxuXHRcdCAgKi9cclxuXHRcdG9iai5iYWxhbmNlcl9fYWRkX3RvX193YWl0ID0gZnVuY3Rpb24gKCBiYWxhbmNlX29iaiApIHtcclxuXHRcdFx0cF9iYWxhbmNlclsnd2FpdCddLnB1c2goIGJhbGFuY2Vfb2JqICk7XHJcblx0XHR9XHJcblxyXG5cdFx0IC8qKlxyXG5cdFx0ICAqIFJlbW92ZSBmcm9tIFdhaXRcclxuXHRcdCAgKlxyXG5cdFx0ICAqIEBwYXJhbSByZXNvdXJjZV9pZFxyXG5cdFx0ICAqIEBwYXJhbSBmdW5jdGlvbl9uYW1lXHJcblx0XHQgICogQHJldHVybnMgeyp8Ym9vbGVhbn1cclxuXHRcdCAgKi9cclxuXHRcdG9iai5iYWxhbmNlcl9fcmVtb3ZlX2Zyb21fX3dhaXRfbGlzdCA9IGZ1bmN0aW9uICggcmVzb3VyY2VfaWQsIGZ1bmN0aW9uX25hbWUgKXtcclxuXHJcblx0XHRcdHZhciByZW1vdmVkX2VsID0gZmFsc2U7XHJcblxyXG5cdFx0XHRpZiAoIHBfYmFsYW5jZXJbICd3YWl0JyBdLmxlbmd0aCApe1x0XHRcdFx0XHQvL0ZpeEluOiA5LjguMTAuMVxyXG5cdFx0XHRcdGZvciAoIHZhciBpIGluIHBfYmFsYW5jZXJbICd3YWl0JyBdICl7XHJcblx0XHRcdFx0XHRpZiAoXHJcblx0XHRcdFx0XHRcdChyZXNvdXJjZV9pZCA9PT0gcF9iYWxhbmNlclsgJ3dhaXQnIF1bIGkgXVsgJ3Jlc291cmNlX2lkJyBdKVxyXG5cdFx0XHRcdFx0XHQmJiAoZnVuY3Rpb25fbmFtZSA9PT0gcF9iYWxhbmNlclsgJ3dhaXQnIF1bIGkgXVsgJ2Z1bmN0aW9uX25hbWUnIF0pXHJcblx0XHRcdFx0XHQpe1xyXG5cdFx0XHRcdFx0XHRyZW1vdmVkX2VsID0gcF9iYWxhbmNlclsgJ3dhaXQnIF0uc3BsaWNlKCBpLCAxICk7XHJcblx0XHRcdFx0XHRcdHJlbW92ZWRfZWwgPSByZW1vdmVkX2VsLnBvcCgpO1xyXG5cdFx0XHRcdFx0XHRwX2JhbGFuY2VyWyAnd2FpdCcgXSA9IHBfYmFsYW5jZXJbICd3YWl0JyBdLmZpbHRlciggZnVuY3Rpb24gKCB2ICl7XHJcblx0XHRcdFx0XHRcdFx0cmV0dXJuIHY7XHJcblx0XHRcdFx0XHRcdH0gKTtcdFx0XHRcdFx0Ly8gUmVpbmRleCBhcnJheVxyXG5cdFx0XHRcdFx0XHRyZXR1cm4gcmVtb3ZlZF9lbDtcclxuXHRcdFx0XHRcdH1cclxuXHRcdFx0XHR9XHJcblx0XHRcdH1cclxuXHRcdFx0cmV0dXJuIHJlbW92ZWRfZWw7XHJcblx0XHR9XHJcblxyXG5cdFx0LyoqXHJcblx0XHQqIElzIGFscmVhZHkgV0FJVFxyXG5cdFx0KlxyXG5cdFx0KiBAcGFyYW0gcmVzb3VyY2VfaWRcclxuXHRcdCogQHBhcmFtIGZ1bmN0aW9uX25hbWVcclxuXHRcdCogQHJldHVybnMge2Jvb2xlYW59XHJcblx0XHQqL1xyXG5cdFx0b2JqLmJhbGFuY2VyX19pc19hbHJlYWR5X3dhaXQgPSBmdW5jdGlvbiAoIHJlc291cmNlX2lkLCBmdW5jdGlvbl9uYW1lICl7XHJcblxyXG5cdFx0XHRpZiAoIHBfYmFsYW5jZXJbICd3YWl0JyBdLmxlbmd0aCApe1x0XHRcdFx0Ly9GaXhJbjogOS44LjEwLjFcclxuXHRcdFx0XHRmb3IgKCB2YXIgaSBpbiBwX2JhbGFuY2VyWyAnd2FpdCcgXSApe1xyXG5cdFx0XHRcdFx0aWYgKFxyXG5cdFx0XHRcdFx0XHQocmVzb3VyY2VfaWQgPT09IHBfYmFsYW5jZXJbICd3YWl0JyBdWyBpIF1bICdyZXNvdXJjZV9pZCcgXSlcclxuXHRcdFx0XHRcdFx0JiYgKGZ1bmN0aW9uX25hbWUgPT09IHBfYmFsYW5jZXJbICd3YWl0JyBdWyBpIF1bICdmdW5jdGlvbl9uYW1lJyBdKVxyXG5cdFx0XHRcdFx0KXtcclxuXHRcdFx0XHRcdFx0cmV0dXJuIHRydWU7XHJcblx0XHRcdFx0XHR9XHJcblx0XHRcdFx0fVxyXG5cdFx0XHR9XHJcblx0XHRcdHJldHVybiBmYWxzZTtcclxuXHRcdH1cclxuXHJcblxyXG5cdFx0IC8qKlxyXG5cdFx0ICAqIEFkZCB0byBSVU5cclxuXHRcdCAgKiBAcGFyYW0gYmFsYW5jZV9vYmpcclxuXHRcdCAgKi9cclxuXHRcdG9iai5iYWxhbmNlcl9fYWRkX3RvX19ydW4gPSBmdW5jdGlvbiAoIGJhbGFuY2Vfb2JqICkge1xyXG5cdFx0XHRwX2JhbGFuY2VyWydpbl9wcm9jZXNzJ10ucHVzaCggYmFsYW5jZV9vYmogKTtcclxuXHRcdH1cclxuXHJcblx0XHQvKipcclxuXHRcdCogUmVtb3ZlIGZyb20gUlVOIGxpc3RcclxuXHRcdCpcclxuXHRcdCogQHBhcmFtIHJlc291cmNlX2lkXHJcblx0XHQqIEBwYXJhbSBmdW5jdGlvbl9uYW1lXHJcblx0XHQqIEByZXR1cm5zIHsqfGJvb2xlYW59XHJcblx0XHQqL1xyXG5cdFx0b2JqLmJhbGFuY2VyX19yZW1vdmVfZnJvbV9fcnVuX2xpc3QgPSBmdW5jdGlvbiAoIHJlc291cmNlX2lkLCBmdW5jdGlvbl9uYW1lICl7XHJcblxyXG5cdFx0XHQgdmFyIHJlbW92ZWRfZWwgPSBmYWxzZTtcclxuXHJcblx0XHRcdCBpZiAoIHBfYmFsYW5jZXJbICdpbl9wcm9jZXNzJyBdLmxlbmd0aCApe1x0XHRcdFx0Ly9GaXhJbjogOS44LjEwLjFcclxuXHRcdFx0XHQgZm9yICggdmFyIGkgaW4gcF9iYWxhbmNlclsgJ2luX3Byb2Nlc3MnIF0gKXtcclxuXHRcdFx0XHRcdCBpZiAoXHJcblx0XHRcdFx0XHRcdCAocmVzb3VyY2VfaWQgPT09IHBfYmFsYW5jZXJbICdpbl9wcm9jZXNzJyBdWyBpIF1bICdyZXNvdXJjZV9pZCcgXSlcclxuXHRcdFx0XHRcdFx0ICYmIChmdW5jdGlvbl9uYW1lID09PSBwX2JhbGFuY2VyWyAnaW5fcHJvY2VzcycgXVsgaSBdWyAnZnVuY3Rpb25fbmFtZScgXSlcclxuXHRcdFx0XHRcdCApe1xyXG5cdFx0XHRcdFx0XHQgcmVtb3ZlZF9lbCA9IHBfYmFsYW5jZXJbICdpbl9wcm9jZXNzJyBdLnNwbGljZSggaSwgMSApO1xyXG5cdFx0XHRcdFx0XHQgcmVtb3ZlZF9lbCA9IHJlbW92ZWRfZWwucG9wKCk7XHJcblx0XHRcdFx0XHRcdCBwX2JhbGFuY2VyWyAnaW5fcHJvY2VzcycgXSA9IHBfYmFsYW5jZXJbICdpbl9wcm9jZXNzJyBdLmZpbHRlciggZnVuY3Rpb24gKCB2ICl7XHJcblx0XHRcdFx0XHRcdFx0IHJldHVybiB2O1xyXG5cdFx0XHRcdFx0XHQgfSApO1x0XHQvLyBSZWluZGV4IGFycmF5XHJcblx0XHRcdFx0XHRcdCByZXR1cm4gcmVtb3ZlZF9lbDtcclxuXHRcdFx0XHRcdCB9XHJcblx0XHRcdFx0IH1cclxuXHRcdFx0IH1cclxuXHRcdFx0IHJldHVybiByZW1vdmVkX2VsO1xyXG5cdFx0fVxyXG5cclxuXHRcdC8qKlxyXG5cdFx0KiBJcyBhbHJlYWR5IFJVTlxyXG5cdFx0KlxyXG5cdFx0KiBAcGFyYW0gcmVzb3VyY2VfaWRcclxuXHRcdCogQHBhcmFtIGZ1bmN0aW9uX25hbWVcclxuXHRcdCogQHJldHVybnMge2Jvb2xlYW59XHJcblx0XHQqL1xyXG5cdFx0b2JqLmJhbGFuY2VyX19pc19hbHJlYWR5X3J1biA9IGZ1bmN0aW9uICggcmVzb3VyY2VfaWQsIGZ1bmN0aW9uX25hbWUgKXtcclxuXHJcblx0XHRcdGlmICggcF9iYWxhbmNlclsgJ2luX3Byb2Nlc3MnIF0ubGVuZ3RoICl7XHRcdFx0XHRcdC8vRml4SW46IDkuOC4xMC4xXHJcblx0XHRcdFx0Zm9yICggdmFyIGkgaW4gcF9iYWxhbmNlclsgJ2luX3Byb2Nlc3MnIF0gKXtcclxuXHRcdFx0XHRcdGlmIChcclxuXHRcdFx0XHRcdFx0KHJlc291cmNlX2lkID09PSBwX2JhbGFuY2VyWyAnaW5fcHJvY2VzcycgXVsgaSBdWyAncmVzb3VyY2VfaWQnIF0pXHJcblx0XHRcdFx0XHRcdCYmIChmdW5jdGlvbl9uYW1lID09PSBwX2JhbGFuY2VyWyAnaW5fcHJvY2VzcycgXVsgaSBdWyAnZnVuY3Rpb25fbmFtZScgXSlcclxuXHRcdFx0XHRcdCl7XHJcblx0XHRcdFx0XHRcdHJldHVybiB0cnVlO1xyXG5cdFx0XHRcdFx0fVxyXG5cdFx0XHRcdH1cclxuXHRcdFx0fVxyXG5cdFx0XHRyZXR1cm4gZmFsc2U7XHJcblx0XHR9XHJcblxyXG5cclxuXHJcblx0b2JqLmJhbGFuY2VyX19ydW5fbmV4dCA9IGZ1bmN0aW9uICgpe1xyXG5cclxuXHRcdC8vIEdldCAxc3QgZnJvbSAgV2FpdCBsaXN0XHJcblx0XHR2YXIgcmVtb3ZlZF9lbCA9IGZhbHNlO1xyXG5cdFx0aWYgKCBwX2JhbGFuY2VyWyAnd2FpdCcgXS5sZW5ndGggKXtcdFx0XHRcdFx0Ly9GaXhJbjogOS44LjEwLjFcclxuXHRcdFx0Zm9yICggdmFyIGkgaW4gcF9iYWxhbmNlclsgJ3dhaXQnIF0gKXtcclxuXHRcdFx0XHRyZW1vdmVkX2VsID0gb2JqLmJhbGFuY2VyX19yZW1vdmVfZnJvbV9fd2FpdF9saXN0KCBwX2JhbGFuY2VyWyAnd2FpdCcgXVsgaSBdWyAncmVzb3VyY2VfaWQnIF0sIHBfYmFsYW5jZXJbICd3YWl0JyBdWyBpIF1bICdmdW5jdGlvbl9uYW1lJyBdICk7XHJcblx0XHRcdFx0YnJlYWs7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHJcblx0XHRpZiAoIGZhbHNlICE9PSByZW1vdmVkX2VsICl7XHJcblxyXG5cdFx0XHQvLyBSdW5cclxuXHRcdFx0b2JqLmJhbGFuY2VyX19ydW4oIHJlbW92ZWRfZWwgKTtcclxuXHRcdH1cclxuXHR9XHJcblxyXG5cdCAvKipcclxuXHQgICogUnVuXHJcblx0ICAqIEBwYXJhbSBiYWxhbmNlX29ialxyXG5cdCAgKi9cclxuXHRvYmouYmFsYW5jZXJfX3J1biA9IGZ1bmN0aW9uICggYmFsYW5jZV9vYmogKXtcclxuXHJcblx0XHRzd2l0Y2ggKCBiYWxhbmNlX29ialsgJ2Z1bmN0aW9uX25hbWUnIF0gKXtcclxuXHJcblx0XHRcdGNhc2UgJ3dwYmNfY2FsZW5kYXJfX2xvYWRfZGF0YV9fYWp4JzpcclxuXHJcblx0XHRcdFx0Ly8gQWRkIHRvIHJ1biBsaXN0XHJcblx0XHRcdFx0b2JqLmJhbGFuY2VyX19hZGRfdG9fX3J1biggYmFsYW5jZV9vYmogKTtcclxuXHJcblx0XHRcdFx0d3BiY19jYWxlbmRhcl9fbG9hZF9kYXRhX19hangoIGJhbGFuY2Vfb2JqWyAncGFyYW1zJyBdIClcclxuXHRcdFx0XHRicmVhaztcclxuXHJcblx0XHRcdGRlZmF1bHQ6XHJcblx0XHR9XHJcblx0fVxyXG5cclxuXHRyZXR1cm4gb2JqO1xyXG5cclxufSggX3dwYmMgfHwge30sIGpRdWVyeSApKTtcclxuXHJcblxyXG4gXHQvKipcclxuIFx0ICogLS0gSGVscCBmdW5jdGlvbnMgLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cdCAqL1xyXG5cclxuXHRmdW5jdGlvbiB3cGJjX2JhbGFuY2VyX19pc193YWl0KCBwYXJhbXMsIGZ1bmN0aW9uX25hbWUgKXtcclxuLy9jb25zb2xlLmxvZygnOjp3cGJjX2JhbGFuY2VyX19pc193YWl0JyxwYXJhbXMgLCBmdW5jdGlvbl9uYW1lICk7XHJcblx0XHRpZiAoICd1bmRlZmluZWQnICE9PSB0eXBlb2YgKHBhcmFtc1sgJ3Jlc291cmNlX2lkJyBdKSApe1xyXG5cclxuXHRcdFx0dmFyIGJhbGFuY2VyX3N0YXR1cyA9IF93cGJjLmJhbGFuY2VyX19pbml0KCBwYXJhbXNbICdyZXNvdXJjZV9pZCcgXSwgZnVuY3Rpb25fbmFtZSwgcGFyYW1zICk7XHJcblxyXG5cdFx0XHRyZXR1cm4gKCAnd2FpdCcgPT09IGJhbGFuY2VyX3N0YXR1cyApO1xyXG5cdFx0fVxyXG5cclxuXHRcdHJldHVybiBmYWxzZTtcclxuXHR9XHJcblxyXG5cclxuXHRmdW5jdGlvbiB3cGJjX2JhbGFuY2VyX19jb21wbGV0ZWQoIHJlc291cmNlX2lkICwgZnVuY3Rpb25fbmFtZSApe1xyXG4vL2NvbnNvbGUubG9nKCc6OndwYmNfYmFsYW5jZXJfX2NvbXBsZXRlZCcscmVzb3VyY2VfaWQgLCBmdW5jdGlvbl9uYW1lICk7XHJcblx0XHRfd3BiYy5iYWxhbmNlcl9fcmVtb3ZlX2Zyb21fX3J1bl9saXN0KCByZXNvdXJjZV9pZCwgZnVuY3Rpb25fbmFtZSApO1xyXG5cdFx0X3dwYmMuYmFsYW5jZXJfX3J1bl9uZXh0KCk7XHJcblx0fSIsIi8qKlxyXG4gKiA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cclxuICpcdGluY2x1ZGVzL19fanMvY2FsL3dwYmNfY2FsLmpzXHJcbiAqID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxyXG4gKi9cclxuXHJcbi8qKlxyXG4gKiBPcmRlciBvciBjaGlsZCBib29raW5nIHJlc291cmNlcyBzYXZlZCBoZXJlOiAgXHRfd3BiYy5ib29raW5nX19nZXRfcGFyYW1fdmFsdWUoIHJlc291cmNlX2lkLCAncmVzb3VyY2VzX2lkX2Fycl9faW5fZGF0ZXMnIClcdFx0WzIsMTAsMTIsMTFdXHJcbiAqL1xyXG5cclxuLyoqXHJcbiAqIEhvdyB0byBjaGVjayAgYm9va2VkIHRpbWVzIG9uICBzcGVjaWZpYyBkYXRlOiA/XHJcbiAqXHJcblx0XHRcdF93cGJjLmJvb2tpbmdzX2luX2NhbGVuZGFyX19nZXRfZm9yX2RhdGUoMiwnMjAyMy0wOC0yMScpO1xyXG5cclxuXHRcdFx0Y29uc29sZS5sb2coXHJcblx0XHRcdFx0XHRcdF93cGJjLmJvb2tpbmdzX2luX2NhbGVuZGFyX19nZXRfZm9yX2RhdGUoMiwnMjAyMy0wOC0yMScpWzJdLmJvb2tlZF90aW1lX3Nsb3RzLm1lcmdlZF9zZWNvbmRzLFxyXG5cdFx0XHRcdFx0XHRfd3BiYy5ib29raW5nc19pbl9jYWxlbmRhcl9fZ2V0X2Zvcl9kYXRlKDIsJzIwMjMtMDgtMjEnKVsxMF0uYm9va2VkX3RpbWVfc2xvdHMubWVyZ2VkX3NlY29uZHMsXHJcblx0XHRcdFx0XHRcdF93cGJjLmJvb2tpbmdzX2luX2NhbGVuZGFyX19nZXRfZm9yX2RhdGUoMiwnMjAyMy0wOC0yMScpWzExXS5ib29rZWRfdGltZV9zbG90cy5tZXJnZWRfc2Vjb25kcyxcclxuXHRcdFx0XHRcdFx0X3dwYmMuYm9va2luZ3NfaW5fY2FsZW5kYXJfX2dldF9mb3JfZGF0ZSgyLCcyMDIzLTA4LTIxJylbMTJdLmJvb2tlZF90aW1lX3Nsb3RzLm1lcmdlZF9zZWNvbmRzXHJcblx0XHRcdFx0XHQpO1xyXG4gKiAgT1JcclxuXHRcdFx0Y29uc29sZS5sb2coXHJcblx0XHRcdFx0XHRcdF93cGJjLmJvb2tpbmdzX2luX2NhbGVuZGFyX19nZXRfZm9yX2RhdGUoMiwnMjAyMy0wOC0yMScpWzJdLmJvb2tlZF90aW1lX3Nsb3RzLm1lcmdlZF9yZWFkYWJsZSxcclxuXHRcdFx0XHRcdFx0X3dwYmMuYm9va2luZ3NfaW5fY2FsZW5kYXJfX2dldF9mb3JfZGF0ZSgyLCcyMDIzLTA4LTIxJylbMTBdLmJvb2tlZF90aW1lX3Nsb3RzLm1lcmdlZF9yZWFkYWJsZSxcclxuXHRcdFx0XHRcdFx0X3dwYmMuYm9va2luZ3NfaW5fY2FsZW5kYXJfX2dldF9mb3JfZGF0ZSgyLCcyMDIzLTA4LTIxJylbMTFdLmJvb2tlZF90aW1lX3Nsb3RzLm1lcmdlZF9yZWFkYWJsZSxcclxuXHRcdFx0XHRcdFx0X3dwYmMuYm9va2luZ3NfaW5fY2FsZW5kYXJfX2dldF9mb3JfZGF0ZSgyLCcyMDIzLTA4LTIxJylbMTJdLmJvb2tlZF90aW1lX3Nsb3RzLm1lcmdlZF9yZWFkYWJsZVxyXG5cdFx0XHRcdFx0KTtcclxuICpcclxuICovXHJcblxyXG4vKipcclxuICogRGF5cyBzZWxlY3Rpb246XHJcbiAqIFx0XHRcdFx0XHR3cGJjX2NhbGVuZGFyX191bnNlbGVjdF9hbGxfZGF0ZXMoIHJlc291cmNlX2lkICk7XHJcbiAqXHJcbiAqXHRcdFx0XHRcdHZhciByZXNvdXJjZV9pZCA9IDE7XHJcbiAqIFx0RXhhbXBsZSAxOlx0XHR2YXIgbnVtX3NlbGVjdGVkX2RheXMgPSB3cGJjX2F1dG9fc2VsZWN0X2RhdGVzX2luX2NhbGVuZGFyKCByZXNvdXJjZV9pZCwgJzIwMjQtMDUtMTUnLCAnMjAyNC0wNS0yNScgKTtcclxuICogXHRFeGFtcGxlIDI6XHRcdHZhciBudW1fc2VsZWN0ZWRfZGF5cyA9IHdwYmNfYXV0b19zZWxlY3RfZGF0ZXNfaW5fY2FsZW5kYXIoIHJlc291cmNlX2lkLCBbJzIwMjQtMDUtMDknLCcyMDI0LTA1LTE5JywnMjAyNC0wNS0yNSddICk7XHJcbiAqXHJcbiAqL1xyXG5cclxuXHJcbi8qKlxyXG4gKiBDIEEgTCBFIE4gRCBBIFIgIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG4gKi9cclxuXHJcblxyXG4vKipcclxuICogIFNob3cgV1BCQyBDYWxlbmRhclxyXG4gKlxyXG4gKiBAcGFyYW0gcmVzb3VyY2VfaWRcdFx0XHQtIHJlc291cmNlIElEXHJcbiAqIEByZXR1cm5zIHtib29sZWFufVxyXG4gKi9cclxuZnVuY3Rpb24gd3BiY19jYWxlbmRhcl9zaG93KCByZXNvdXJjZV9pZCApe1xyXG5cclxuXHQvLyBJZiBubyBjYWxlbmRhciBIVE1MIHRhZywgIHRoZW4gIGV4aXRcclxuXHRpZiAoIDAgPT09IGpRdWVyeSggJyNjYWxlbmRhcl9ib29raW5nJyArIHJlc291cmNlX2lkICkubGVuZ3RoICl7IHJldHVybiBmYWxzZTsgfVxyXG5cclxuXHQvLyBJZiB0aGUgY2FsZW5kYXIgd2l0aCB0aGUgc2FtZSBCb29raW5nIHJlc291cmNlIGlzIGFjdGl2YXRlZCBhbHJlYWR5LCB0aGVuIGV4aXQuXHJcblx0aWYgKCB0cnVlID09PSBqUXVlcnkoICcjY2FsZW5kYXJfYm9va2luZycgKyByZXNvdXJjZV9pZCApLmhhc0NsYXNzKCAnaGFzRGF0ZXBpY2snICkgKXsgcmV0dXJuIGZhbHNlOyB9XHJcblxyXG5cdC8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblx0Ly8gRGF5cyBzZWxlY3Rpb25cclxuXHQvLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cdHZhciBsb2NhbF9faXNfcmFuZ2Vfc2VsZWN0ID0gZmFsc2U7XHJcblx0dmFyIGxvY2FsX19tdWx0aV9kYXlzX3NlbGVjdF9udW0gICA9IDM2NTtcdFx0XHRcdFx0Ly8gbXVsdGlwbGUgfCBmaXhlZFxyXG5cdGlmICggJ2R5bmFtaWMnID09PSBfd3BiYy5jYWxlbmRhcl9fZ2V0X3BhcmFtX3ZhbHVlKCByZXNvdXJjZV9pZCwgJ2RheXNfc2VsZWN0X21vZGUnICkgKXtcclxuXHRcdGxvY2FsX19pc19yYW5nZV9zZWxlY3QgPSB0cnVlO1xyXG5cdFx0bG9jYWxfX211bHRpX2RheXNfc2VsZWN0X251bSA9IDA7XHJcblx0fVxyXG5cdGlmICggJ3NpbmdsZScgID09PSBfd3BiYy5jYWxlbmRhcl9fZ2V0X3BhcmFtX3ZhbHVlKCByZXNvdXJjZV9pZCwgJ2RheXNfc2VsZWN0X21vZGUnICkgKXtcclxuXHRcdGxvY2FsX19tdWx0aV9kYXlzX3NlbGVjdF9udW0gPSAwO1xyXG5cdH1cclxuXHJcblx0Ly8gLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHQvLyBNaW4gLSBNYXggZGF5cyB0byBzY3JvbGwvc2hvd1xyXG5cdC8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblx0dmFyIGxvY2FsX19taW5fZGF0ZSA9IDA7XHJcbiBcdGxvY2FsX19taW5fZGF0ZSA9IG5ldyBEYXRlKCBfd3BiYy5nZXRfb3RoZXJfcGFyYW0oICd0b2RheV9hcnInIClbIDAgXSwgKHBhcnNlSW50KCBfd3BiYy5nZXRfb3RoZXJfcGFyYW0oICd0b2RheV9hcnInIClbIDEgXSApIC0gMSksIF93cGJjLmdldF9vdGhlcl9wYXJhbSggJ3RvZGF5X2FycicgKVsgMiBdLCAwLCAwLCAwICk7XHRcdFx0Ly9GaXhJbjogOS45LjAuMTdcclxuLy9jb25zb2xlLmxvZyggbG9jYWxfX21pbl9kYXRlICk7XHJcblx0dmFyIGxvY2FsX19tYXhfZGF0ZSA9IF93cGJjLmNhbGVuZGFyX19nZXRfcGFyYW1fdmFsdWUoIHJlc291cmNlX2lkLCAnYm9va2luZ19tYXhfbW9udGhlc19pbl9jYWxlbmRhcicgKTtcclxuXHQvL2xvY2FsX19tYXhfZGF0ZSA9IG5ldyBEYXRlKDIwMjQsIDUsIDI4KTsgIEl0IGlzIGhlcmUgaXNzdWUgb2Ygbm90IHNlbGVjdGFibGUgZGF0ZXMsIGJ1dCBzb21lIGRhdGVzIHNob3dpbmcgaW4gY2FsZW5kYXIgYXMgYXZhaWxhYmxlLCBidXQgd2UgY2FuIG5vdCBzZWxlY3QgaXQuXHJcblxyXG5cdC8vLy8gRGVmaW5lIGxhc3QgZGF5IGluIGNhbGVuZGFyIChhcyBhIGxhc3QgZGF5IG9mIG1vbnRoIChhbmQgbm90IGRhdGUsIHdoaWNoIGlzIHJlbGF0ZWQgdG8gYWN0dWFsICdUb2RheScgZGF0ZSkuXHJcblx0Ly8vLyBFLmcuIGlmIHRvZGF5IGlzIDIwMjMtMDktMjUsIGFuZCB3ZSBzZXQgJ051bWJlciBvZiBtb250aHMgdG8gc2Nyb2xsJyBhcyA1IG1vbnRocywgdGhlbiBsYXN0IGRheSB3aWxsIGJlIDIwMjQtMDItMjkgYW5kIG5vdCB0aGUgMjAyNC0wMi0yNS5cclxuXHQvLyB2YXIgY2FsX2xhc3RfZGF5X2luX21vbnRoID0galF1ZXJ5LmRhdGVwaWNrLl9kZXRlcm1pbmVEYXRlKCBudWxsLCBsb2NhbF9fbWF4X2RhdGUsIG5ldyBEYXRlKCkgKTtcclxuXHQvLyBjYWxfbGFzdF9kYXlfaW5fbW9udGggPSBuZXcgRGF0ZSggY2FsX2xhc3RfZGF5X2luX21vbnRoLmdldEZ1bGxZZWFyKCksIGNhbF9sYXN0X2RheV9pbl9tb250aC5nZXRNb250aCgpICsgMSwgMCApO1xyXG5cdC8vIGxvY2FsX19tYXhfZGF0ZSA9IGNhbF9sYXN0X2RheV9pbl9tb250aDtcdFx0XHQvL0ZpeEluOiAxMC4wLjAuMjZcclxuXHJcblx0aWYgKCAgICggbG9jYXRpb24uaHJlZi5pbmRleE9mKCdwYWdlPXdwYmMtbmV3JykgIT0gLTEgKVxyXG5cdFx0JiYgKCBsb2NhdGlvbi5ocmVmLmluZGV4T2YoJ2Jvb2tpbmdfaGFzaCcpICE9IC0xICkgICAgICAgICAgICAgICAgICAvLyBDb21tZW50IHRoaXMgbGluZSBmb3IgYWJpbGl0eSB0byBhZGQgIGJvb2tpbmcgaW4gcGFzdCBkYXlzIGF0ICBCb29raW5nID4gQWRkIGJvb2tpbmcgcGFnZS5cclxuXHRcdCl7XHJcblx0XHRsb2NhbF9fbWluX2RhdGUgPSBudWxsO1xyXG5cdFx0bG9jYWxfX21heF9kYXRlID0gbnVsbDtcclxuXHR9XHJcblxyXG5cdHZhciBsb2NhbF9fc3RhcnRfd2Vla2RheSAgICA9IF93cGJjLmNhbGVuZGFyX19nZXRfcGFyYW1fdmFsdWUoIHJlc291cmNlX2lkLCAnYm9va2luZ19zdGFydF9kYXlfd2VlZWsnICk7XHJcblx0dmFyIGxvY2FsX19udW1iZXJfb2ZfbW9udGhzID0gcGFyc2VJbnQoIF93cGJjLmNhbGVuZGFyX19nZXRfcGFyYW1fdmFsdWUoIHJlc291cmNlX2lkLCAnY2FsZW5kYXJfbnVtYmVyX29mX21vbnRocycgKSApO1xyXG5cclxuXHRqUXVlcnkoICcjY2FsZW5kYXJfYm9va2luZycgKyByZXNvdXJjZV9pZCApLnRleHQoICcnICk7XHRcdFx0XHRcdC8vIFJlbW92ZSBhbGwgSFRNTCBpbiBjYWxlbmRhciB0YWdcclxuXHQvLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cdC8vIFNob3cgY2FsZW5kYXJcclxuXHQvLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cdGpRdWVyeSgnI2NhbGVuZGFyX2Jvb2tpbmcnKyByZXNvdXJjZV9pZCkuZGF0ZXBpY2soXHJcblx0XHRcdHtcclxuXHRcdFx0XHRiZWZvcmVTaG93RGF5OiBmdW5jdGlvbiAoIGpzX2RhdGUgKXtcclxuXHRcdFx0XHRcdFx0XHRcdFx0cmV0dXJuIHdwYmNfX2NhbGVuZGFyX19hcHBseV9jc3NfdG9fZGF5cygganNfZGF0ZSwgeydyZXNvdXJjZV9pZCc6IHJlc291cmNlX2lkfSwgdGhpcyApO1xyXG5cdFx0XHRcdFx0XHRcdCAgfSxcclxuXHRcdFx0XHRvblNlbGVjdDogZnVuY3Rpb24gKCBzdHJpbmdfZGF0ZXMsIGpzX2RhdGVzX2FyciApeyAgLyoqXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQgKlx0c3RyaW5nX2RhdGVzICAgPSAgICcyMy4wOC4yMDIzIC0gMjYuMDguMjAyMycgICAgfCAgICAnMjMuMDguMjAyMyAtIDIzLjA4LjIwMjMnICAgIHwgICAgJzE5LjA5LjIwMjMsIDI0LjA4LjIwMjMsIDMwLjA5LjIwMjMnXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQgKiAganNfZGF0ZXNfYXJyICAgPSAgIHJhbmdlOiBbIERhdGUgKEF1ZyAyMyAyMDIzKSwgRGF0ZSAoQXVnIDI1IDIwMjMpXSAgICAgfCAgICAgbXVsdGlwbGU6IFsgRGF0ZShPY3QgMjQgMjAyMyksIERhdGUoT2N0IDIwIDIwMjMpLCBEYXRlKE9jdCAxNiAyMDIzKSBdXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQgKi9cclxuXHRcdFx0XHRcdFx0XHRcdFx0cmV0dXJuIHdwYmNfX2NhbGVuZGFyX19vbl9zZWxlY3RfZGF5cyggc3RyaW5nX2RhdGVzLCB7J3Jlc291cmNlX2lkJzogcmVzb3VyY2VfaWR9LCB0aGlzICk7XHJcblx0XHRcdFx0XHRcdFx0ICB9LFxyXG5cdFx0XHRcdG9uSG92ZXI6IGZ1bmN0aW9uICggc3RyaW5nX2RhdGUsIGpzX2RhdGUgKXtcclxuXHRcdFx0XHRcdFx0XHRcdFx0cmV0dXJuIHdwYmNfX2NhbGVuZGFyX19vbl9ob3Zlcl9kYXlzKCBzdHJpbmdfZGF0ZSwganNfZGF0ZSwgeydyZXNvdXJjZV9pZCc6IHJlc291cmNlX2lkfSwgdGhpcyApO1xyXG5cdFx0XHRcdFx0XHRcdCAgfSxcclxuXHRcdFx0XHRvbkNoYW5nZU1vbnRoWWVhcjogZnVuY3Rpb24gKCB5ZWFyLCByZWFsX21vbnRoLCBqc19kYXRlX18xc3RfZGF5X2luX21vbnRoICl7IH0sXHJcblx0XHRcdFx0c2hvd09uICAgICAgICA6ICdib3RoJyxcclxuXHRcdFx0XHRudW1iZXJPZk1vbnRoczogbG9jYWxfX251bWJlcl9vZl9tb250aHMsXHJcblx0XHRcdFx0c3RlcE1vbnRocyAgICA6IDEsXHJcblx0XHRcdFx0Ly8gcHJldlRleHQgICAgICA6ICcmbGFxdW87JyxcclxuXHRcdFx0XHQvLyBuZXh0VGV4dCAgICAgIDogJyZyYXF1bzsnLFxyXG5cdFx0XHRcdHByZXZUZXh0ICAgICAgOiAnJmxzYXF1bzsnLFxyXG5cdFx0XHRcdG5leHRUZXh0ICAgICAgOiAnJnJzYXF1bzsnLFxyXG5cdFx0XHRcdGRhdGVGb3JtYXQgICAgOiAnZGQubW0ueXknLFxyXG5cdFx0XHRcdGNoYW5nZU1vbnRoICAgOiBmYWxzZSxcclxuXHRcdFx0XHRjaGFuZ2VZZWFyICAgIDogZmFsc2UsXHJcblx0XHRcdFx0bWluRGF0ZSAgICAgICA6IGxvY2FsX19taW5fZGF0ZSxcclxuXHRcdFx0XHRtYXhEYXRlICAgICAgIDogbG9jYWxfX21heF9kYXRlLCBcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0Ly8gJzFZJyxcclxuXHRcdFx0XHQvLyBtaW5EYXRlOiBuZXcgRGF0ZSgyMDIwLCAyLCAxKSwgbWF4RGF0ZTogbmV3IERhdGUoMjAyMCwgOSwgMzEpLCAgICAgICAgICAgICBcdC8vIEFiaWxpdHkgdG8gc2V0IGFueSAgc3RhcnQgYW5kIGVuZCBkYXRlIGluIGNhbGVuZGFyXHJcblx0XHRcdFx0c2hvd1N0YXR1cyAgICAgIDogZmFsc2UsXHJcblx0XHRcdFx0bXVsdGlTZXBhcmF0b3IgIDogJywgJyxcclxuXHRcdFx0XHRjbG9zZUF0VG9wICAgICAgOiBmYWxzZSxcclxuXHRcdFx0XHRmaXJzdERheSAgICAgICAgOiBsb2NhbF9fc3RhcnRfd2Vla2RheSxcclxuXHRcdFx0XHRnb3RvQ3VycmVudCAgICAgOiBmYWxzZSxcclxuXHRcdFx0XHRoaWRlSWZOb1ByZXZOZXh0OiB0cnVlLFxyXG5cdFx0XHRcdG11bHRpU2VsZWN0ICAgICA6IGxvY2FsX19tdWx0aV9kYXlzX3NlbGVjdF9udW0sXHJcblx0XHRcdFx0cmFuZ2VTZWxlY3QgICAgIDogbG9jYWxfX2lzX3JhbmdlX3NlbGVjdCxcclxuXHRcdFx0XHQvLyBzaG93V2Vla3M6IHRydWUsXHJcblx0XHRcdFx0dXNlVGhlbWVSb2xsZXI6IGZhbHNlXHJcblx0XHRcdH1cclxuXHQpO1xyXG5cclxuXHJcblx0XHJcblx0Ly8gLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHQvLyBDbGVhciB0b2RheSBkYXRlIGhpZ2hsaWdodGluZ1xyXG5cdC8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblx0c2V0VGltZW91dCggZnVuY3Rpb24gKCl7ICB3cGJjX2NhbGVuZGFyc19fY2xlYXJfZGF5c19oaWdobGlnaHRpbmcoIHJlc291cmNlX2lkICk7ICB9LCA1MDAgKTsgICAgICAgICAgICAgICAgICAgIFx0Ly9GaXhJbjogNy4xLjIuOFxyXG5cdFxyXG5cdC8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblx0Ly8gU2Nyb2xsIGNhbGVuZGFyIHRvICBzcGVjaWZpYyBtb250aFxyXG5cdC8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblx0dmFyIHN0YXJ0X2JrX21vbnRoID0gX3dwYmMuY2FsZW5kYXJfX2dldF9wYXJhbV92YWx1ZSggcmVzb3VyY2VfaWQsICdjYWxlbmRhcl9zY3JvbGxfdG8nICk7XHJcblx0aWYgKCBmYWxzZSAhPT0gc3RhcnRfYmtfbW9udGggKXtcclxuXHRcdHdwYmNfY2FsZW5kYXJfX3Njcm9sbF90byggcmVzb3VyY2VfaWQsIHN0YXJ0X2JrX21vbnRoWyAwIF0sIHN0YXJ0X2JrX21vbnRoWyAxIF0gKTtcclxuXHR9XHJcbn1cclxuXHJcblxyXG5cdC8qKlxyXG5cdCAqIEFwcGx5IENTUyB0byBjYWxlbmRhciBkYXRlIGNlbGxzXHJcblx0ICpcclxuXHQgKiBAcGFyYW0gZGF0ZVx0XHRcdFx0XHRcdFx0XHRcdFx0LSAgSmF2YVNjcmlwdCBEYXRlIE9iajogIFx0XHRNb24gRGVjIDExIDIwMjMgMDA6MDA6MDAgR01UKzAyMDAgKEVhc3Rlcm4gRXVyb3BlYW4gU3RhbmRhcmQgVGltZSlcclxuXHQgKiBAcGFyYW0gY2FsZW5kYXJfcGFyYW1zX2Fyclx0XHRcdFx0XHRcdC0gIENhbGVuZGFyIFNldHRpbmdzIE9iamVjdDogIFx0e1xyXG5cdCAqXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQgIFx0XHRcdFx0XHRcdFwicmVzb3VyY2VfaWRcIjogNFxyXG5cdCAqXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0fVxyXG5cdCAqIEBwYXJhbSBkYXRlcGlja190aGlzXHRcdFx0XHRcdFx0XHRcdC0gdGhpcyBvZiBkYXRlcGljayBPYmpcclxuXHQgKiBAcmV0dXJucyB7KCp8c3RyaW5nKVtdfChib29sZWFufHN0cmluZylbXX1cdFx0LSBbIHt0cnVlIC1hdmFpbGFibGUgfCBmYWxzZSAtIHVuYXZhaWxhYmxlfSwgJ0NTUyBjbGFzc2VzIGZvciBjYWxlbmRhciBkYXkgY2VsbCcgXVxyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfX2NhbGVuZGFyX19hcHBseV9jc3NfdG9fZGF5cyggZGF0ZSwgY2FsZW5kYXJfcGFyYW1zX2FyciwgZGF0ZXBpY2tfdGhpcyApe1xyXG5cclxuXHRcdHZhciB0b2RheV9kYXRlID0gbmV3IERhdGUoIF93cGJjLmdldF9vdGhlcl9wYXJhbSggJ3RvZGF5X2FycicgKVsgMCBdLCAocGFyc2VJbnQoIF93cGJjLmdldF9vdGhlcl9wYXJhbSggJ3RvZGF5X2FycicgKVsgMSBdICkgLSAxKSwgX3dwYmMuZ2V0X290aGVyX3BhcmFtKCAndG9kYXlfYXJyJyApWyAyIF0sIDAsIDAsIDAgKTtcdFx0XHRcdFx0XHRcdFx0Ly8gVG9kYXkgSlNfRGF0ZV9PYmouXHJcblx0XHR2YXIgY2xhc3NfZGF5ICAgICA9IHdwYmNfX2dldF9fdGRfY2xhc3NfZGF0ZSggZGF0ZSApO1x0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdC8vICcxLTktMjAyMydcclxuXHRcdHZhciBzcWxfY2xhc3NfZGF5ID0gd3BiY19fZ2V0X19zcWxfY2xhc3NfZGF0ZSggZGF0ZSApO1x0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdC8vICcyMDIzLTAxLTA5J1xyXG5cdFx0dmFyIHJlc291cmNlX2lkID0gKCAndW5kZWZpbmVkJyAhPT0gdHlwZW9mKGNhbGVuZGFyX3BhcmFtc19hcnJbICdyZXNvdXJjZV9pZCcgXSkgKSA/IGNhbGVuZGFyX3BhcmFtc19hcnJbICdyZXNvdXJjZV9pZCcgXSA6ICcxJzsgXHRcdC8vICcxJ1xyXG5cclxuXHRcdC8vIEdldCBTZWxlY3RlZCBkYXRlcyBpbiBjYWxlbmRhclxyXG5cdFx0dmFyIHNlbGVjdGVkX2RhdGVzX3NxbCA9IHdwYmNfZ2V0X19zZWxlY3RlZF9kYXRlc19zcWxfX2FzX2FyciggcmVzb3VyY2VfaWQgKTtcclxuXHJcblx0XHQvLyBHZXQgRGF0YSAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cdFx0dmFyIGRhdGVfYm9va2luZ3Nfb2JqID0gX3dwYmMuYm9va2luZ3NfaW5fY2FsZW5kYXJfX2dldF9mb3JfZGF0ZSggcmVzb3VyY2VfaWQsIHNxbF9jbGFzc19kYXkgKTtcclxuXHJcblxyXG5cdFx0Ly8gQXJyYXkgd2l0aCBDU1MgY2xhc3NlcyBmb3IgZGF0ZSAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHRcdHZhciBjc3NfY2xhc3Nlc19fZm9yX2RhdGUgPSBbXTtcclxuXHRcdGNzc19jbGFzc2VzX19mb3JfZGF0ZS5wdXNoKCAnc3FsX2RhdGVfJyAgICAgKyBzcWxfY2xhc3NfZGF5ICk7XHRcdFx0XHQvLyAgJ3NxbF9kYXRlXzIwMjMtMDctMjEnXHJcblx0XHRjc3NfY2xhc3Nlc19fZm9yX2RhdGUucHVzaCggJ2NhbDRkYXRlLScgICAgICsgY2xhc3NfZGF5ICk7XHRcdFx0XHRcdC8vICAnY2FsNGRhdGUtNy0yMS0yMDIzJ1xyXG5cdFx0Y3NzX2NsYXNzZXNfX2Zvcl9kYXRlLnB1c2goICd3cGJjX3dlZWtkYXlfJyArIGRhdGUuZ2V0RGF5KCkgKTtcdFx0XHRcdC8vICAnd3BiY193ZWVrZGF5XzQnXHJcblxyXG5cdFx0Ly8gRGVmaW5lIFNlbGVjdGVkIENoZWNrIEluL091dCBkYXRlcyBpbiBURCAgLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHRcdGlmIChcclxuXHRcdFx0XHQoIHNlbGVjdGVkX2RhdGVzX3NxbC5sZW5ndGggIClcclxuXHRcdFx0Ly8mJiAgKCBzZWxlY3RlZF9kYXRlc19zcWxbIDAgXSAhPT0gc2VsZWN0ZWRfZGF0ZXNfc3FsWyAoc2VsZWN0ZWRfZGF0ZXNfc3FsLmxlbmd0aCAtIDEpIF0gKVxyXG5cdFx0KXtcclxuXHRcdFx0aWYgKCBzcWxfY2xhc3NfZGF5ID09PSBzZWxlY3RlZF9kYXRlc19zcWxbIDAgXSApe1xyXG5cdFx0XHRcdGNzc19jbGFzc2VzX19mb3JfZGF0ZS5wdXNoKCAnc2VsZWN0ZWRfY2hlY2tfaW4nICk7XHJcblx0XHRcdFx0Y3NzX2NsYXNzZXNfX2Zvcl9kYXRlLnB1c2goICdzZWxlY3RlZF9jaGVja19pbl9vdXQnICk7XHJcblx0XHRcdH1cclxuXHRcdFx0aWYgKCAgKCBzZWxlY3RlZF9kYXRlc19zcWwubGVuZ3RoID4gMSApICYmICggc3FsX2NsYXNzX2RheSA9PT0gc2VsZWN0ZWRfZGF0ZXNfc3FsWyAoc2VsZWN0ZWRfZGF0ZXNfc3FsLmxlbmd0aCAtIDEpIF0gKSApIHtcclxuXHRcdFx0XHRjc3NfY2xhc3Nlc19fZm9yX2RhdGUucHVzaCggJ3NlbGVjdGVkX2NoZWNrX291dCcgKTtcclxuXHRcdFx0XHRjc3NfY2xhc3Nlc19fZm9yX2RhdGUucHVzaCggJ3NlbGVjdGVkX2NoZWNrX2luX291dCcgKTtcclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cclxuXHJcblx0XHR2YXIgaXNfZGF5X3NlbGVjdGFibGUgPSBmYWxzZTtcclxuXHJcblx0XHQvLyBJZiBzb21ldGhpbmcgbm90IGRlZmluZWQsICB0aGVuICB0aGlzIGRhdGUgY2xvc2VkIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cdFx0aWYgKCBmYWxzZSA9PT0gZGF0ZV9ib29raW5nc19vYmogKXtcclxuXHJcblx0XHRcdGNzc19jbGFzc2VzX19mb3JfZGF0ZS5wdXNoKCAnZGF0ZV91c2VyX3VuYXZhaWxhYmxlJyApO1xyXG5cclxuXHRcdFx0cmV0dXJuIFsgaXNfZGF5X3NlbGVjdGFibGUsIGNzc19jbGFzc2VzX19mb3JfZGF0ZS5qb2luKCcgJykgIF07XHJcblx0XHR9XHJcblxyXG5cclxuXHRcdC8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblx0XHQvLyAgIGRhdGVfYm9va2luZ3Nfb2JqICAtIERlZmluZWQuICAgICAgICAgICAgRGF0ZXMgY2FuIGJlIHNlbGVjdGFibGUuXHJcblx0XHQvLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cclxuXHRcdC8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblx0XHQvLyBBZGQgc2Vhc29uIG5hbWVzIHRvIHRoZSBkYXkgQ1NTIGNsYXNzZXMgLS0gaXQgaXMgcmVxdWlyZWQgZm9yIGNvcnJlY3QgIHdvcmsgIG9mIGNvbmRpdGlvbmFsIGZpZWxkcyAtLS0tLS0tLS0tLS0tLVxyXG5cdFx0dmFyIHNlYXNvbl9uYW1lc19hcnIgPSBfd3BiYy5zZWFzb25zX19nZXRfZm9yX2RhdGUoIHJlc291cmNlX2lkLCBzcWxfY2xhc3NfZGF5ICk7XHJcblxyXG5cdFx0Zm9yICggdmFyIHNlYXNvbl9rZXkgaW4gc2Vhc29uX25hbWVzX2FyciApe1xyXG5cclxuXHRcdFx0Y3NzX2NsYXNzZXNfX2Zvcl9kYXRlLnB1c2goIHNlYXNvbl9uYW1lc19hcnJbIHNlYXNvbl9rZXkgXSApO1x0XHRcdFx0Ly8gICd3cGRldmJrX3NlYXNvbl9zZXB0ZW1iZXJfMjAyMydcclxuXHRcdH1cclxuXHRcdC8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblxyXG5cclxuXHRcdC8vIENvc3QgUmF0ZSAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblx0XHRjc3NfY2xhc3Nlc19fZm9yX2RhdGUucHVzaCggJ3JhdGVfJyArIGRhdGVfYm9va2luZ3Nfb2JqWyByZXNvdXJjZV9pZCBdWyAnZGF0ZV9jb3N0X3JhdGUnIF0udG9TdHJpbmcoKS5yZXBsYWNlKCAvW1xcLlxcc10vZywgJ18nICkgKTtcdFx0XHRcdFx0XHQvLyAgJ3JhdGVfOTlfMDAnIC0+IDk5LjAwXHJcblxyXG5cclxuXHRcdGlmICggcGFyc2VJbnQoIGRhdGVfYm9va2luZ3Nfb2JqWyAnZGF5X2F2YWlsYWJpbGl0eScgXSApID4gMCApe1xyXG5cdFx0XHRpc19kYXlfc2VsZWN0YWJsZSA9IHRydWU7XHJcblx0XHRcdGNzc19jbGFzc2VzX19mb3JfZGF0ZS5wdXNoKCAnZGF0ZV9hdmFpbGFibGUnICk7XHJcblx0XHRcdGNzc19jbGFzc2VzX19mb3JfZGF0ZS5wdXNoKCAncmVzZXJ2ZWRfZGF5c19jb3VudCcgKyBwYXJzZUludCggZGF0ZV9ib29raW5nc19vYmpbICdtYXhfY2FwYWNpdHknIF0gLSBkYXRlX2Jvb2tpbmdzX29ialsgJ2RheV9hdmFpbGFiaWxpdHknIF0gKSApO1xyXG5cdFx0fSBlbHNlIHtcclxuXHRcdFx0aXNfZGF5X3NlbGVjdGFibGUgPSBmYWxzZTtcclxuXHRcdFx0Y3NzX2NsYXNzZXNfX2Zvcl9kYXRlLnB1c2goICdkYXRlX3VzZXJfdW5hdmFpbGFibGUnICk7XHJcblx0XHR9XHJcblxyXG5cclxuXHRcdHN3aXRjaCAoIGRhdGVfYm9va2luZ3Nfb2JqWyAnc3VtbWFyeSddWydzdGF0dXNfZm9yX2RheScgXSApe1xyXG5cclxuXHRcdFx0Y2FzZSAnYXZhaWxhYmxlJzpcclxuXHRcdFx0XHRicmVhaztcclxuXHJcblx0XHRcdGNhc2UgJ3RpbWVfc2xvdHNfYm9va2luZyc6XHJcblx0XHRcdFx0Y3NzX2NsYXNzZXNfX2Zvcl9kYXRlLnB1c2goICd0aW1lc3BhcnRseScsICd0aW1lc19jbG9jaycgKTtcclxuXHRcdFx0XHRicmVhaztcclxuXHJcblx0XHRcdGNhc2UgJ2Z1bGxfZGF5X2Jvb2tpbmcnOlxyXG5cdFx0XHRcdGNzc19jbGFzc2VzX19mb3JfZGF0ZS5wdXNoKCAnZnVsbF9kYXlfYm9va2luZycgKTtcclxuXHRcdFx0XHRicmVhaztcclxuXHJcblx0XHRcdGNhc2UgJ3NlYXNvbl9maWx0ZXInOlxyXG5cdFx0XHRcdGNzc19jbGFzc2VzX19mb3JfZGF0ZS5wdXNoKCAnZGF0ZV91c2VyX3VuYXZhaWxhYmxlJywgJ3NlYXNvbl91bmF2YWlsYWJsZScgKTtcclxuXHRcdFx0XHRkYXRlX2Jvb2tpbmdzX29ialsgJ3N1bW1hcnknXVsnc3RhdHVzX2Zvcl9ib29raW5ncycgXSA9ICcnO1x0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQvLyBSZXNldCBib29raW5nIHN0YXR1cyBjb2xvciBmb3IgcG9zc2libGUgb2xkIGJvb2tpbmdzIG9uIHRoaXMgZGF0ZVxyXG5cdFx0XHRcdGJyZWFrO1xyXG5cclxuXHRcdFx0Y2FzZSAncmVzb3VyY2VfYXZhaWxhYmlsaXR5JzpcclxuXHRcdFx0XHRjc3NfY2xhc3Nlc19fZm9yX2RhdGUucHVzaCggJ2RhdGVfdXNlcl91bmF2YWlsYWJsZScsICdyZXNvdXJjZV91bmF2YWlsYWJsZScgKTtcclxuXHRcdFx0XHRkYXRlX2Jvb2tpbmdzX29ialsgJ3N1bW1hcnknXVsnc3RhdHVzX2Zvcl9ib29raW5ncycgXSA9ICcnO1x0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQvLyBSZXNldCBib29raW5nIHN0YXR1cyBjb2xvciBmb3IgcG9zc2libGUgb2xkIGJvb2tpbmdzIG9uIHRoaXMgZGF0ZVxyXG5cdFx0XHRcdGJyZWFrO1xyXG5cclxuXHRcdFx0Y2FzZSAnd2Vla2RheV91bmF2YWlsYWJsZSc6XHJcblx0XHRcdFx0Y3NzX2NsYXNzZXNfX2Zvcl9kYXRlLnB1c2goICdkYXRlX3VzZXJfdW5hdmFpbGFibGUnLCAnd2Vla2RheV91bmF2YWlsYWJsZScgKTtcclxuXHRcdFx0XHRkYXRlX2Jvb2tpbmdzX29ialsgJ3N1bW1hcnknXVsnc3RhdHVzX2Zvcl9ib29raW5ncycgXSA9ICcnO1x0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQvLyBSZXNldCBib29raW5nIHN0YXR1cyBjb2xvciBmb3IgcG9zc2libGUgb2xkIGJvb2tpbmdzIG9uIHRoaXMgZGF0ZVxyXG5cdFx0XHRcdGJyZWFrO1xyXG5cclxuXHRcdFx0Y2FzZSAnZnJvbV90b2RheV91bmF2YWlsYWJsZSc6XHJcblx0XHRcdFx0Y3NzX2NsYXNzZXNfX2Zvcl9kYXRlLnB1c2goICdkYXRlX3VzZXJfdW5hdmFpbGFibGUnLCAnZnJvbV90b2RheV91bmF2YWlsYWJsZScgKTtcclxuXHRcdFx0XHRkYXRlX2Jvb2tpbmdzX29ialsgJ3N1bW1hcnknXVsnc3RhdHVzX2Zvcl9ib29raW5ncycgXSA9ICcnO1x0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQvLyBSZXNldCBib29raW5nIHN0YXR1cyBjb2xvciBmb3IgcG9zc2libGUgb2xkIGJvb2tpbmdzIG9uIHRoaXMgZGF0ZVxyXG5cdFx0XHRcdGJyZWFrO1xyXG5cclxuXHRcdFx0Y2FzZSAnbGltaXRfYXZhaWxhYmxlX2Zyb21fdG9kYXknOlxyXG5cdFx0XHRcdGNzc19jbGFzc2VzX19mb3JfZGF0ZS5wdXNoKCAnZGF0ZV91c2VyX3VuYXZhaWxhYmxlJywgJ2xpbWl0X2F2YWlsYWJsZV9mcm9tX3RvZGF5JyApO1xyXG5cdFx0XHRcdGRhdGVfYm9va2luZ3Nfb2JqWyAnc3VtbWFyeSddWydzdGF0dXNfZm9yX2Jvb2tpbmdzJyBdID0gJyc7XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdC8vIFJlc2V0IGJvb2tpbmcgc3RhdHVzIGNvbG9yIGZvciBwb3NzaWJsZSBvbGQgYm9va2luZ3Mgb24gdGhpcyBkYXRlXHJcblx0XHRcdFx0YnJlYWs7XHJcblxyXG5cdFx0XHRjYXNlICdjaGFuZ2Vfb3Zlcic6XHJcblx0XHRcdFx0LypcclxuXHRcdFx0XHQgKlxyXG5cdFx0XHRcdC8vICBjaGVja19vdXRfdGltZV9kYXRlMmFwcHJvdmUgXHQgXHRjaGVja19pbl90aW1lX2RhdGUyYXBwcm92ZVxyXG5cdFx0XHRcdC8vICBjaGVja19vdXRfdGltZV9kYXRlMmFwcHJvdmUgXHQgXHRjaGVja19pbl90aW1lX2RhdGVfYXBwcm92ZWRcclxuXHRcdFx0XHQvLyAgY2hlY2tfaW5fdGltZV9kYXRlMmFwcHJvdmUgXHRcdCBcdGNoZWNrX291dF90aW1lX2RhdGVfYXBwcm92ZWRcclxuXHRcdFx0XHQvLyAgY2hlY2tfb3V0X3RpbWVfZGF0ZV9hcHByb3ZlZCBcdCBcdGNoZWNrX2luX3RpbWVfZGF0ZV9hcHByb3ZlZFxyXG5cdFx0XHRcdCAqL1xyXG5cclxuXHRcdFx0XHRjc3NfY2xhc3Nlc19fZm9yX2RhdGUucHVzaCggJ3RpbWVzcGFydGx5JywgJ2NoZWNrX2luX3RpbWUnLCAnY2hlY2tfb3V0X3RpbWUnICk7XHJcblx0XHRcdFx0Ly9GaXhJbjogMTAuMC4wLjJcclxuXHRcdFx0XHRpZiAoIGRhdGVfYm9va2luZ3Nfb2JqWyAnc3VtbWFyeScgXVsgJ3N0YXR1c19mb3JfYm9va2luZ3MnIF0uaW5kZXhPZiggJ2FwcHJvdmVkX3BlbmRpbmcnICkgPiAtMSApe1xyXG5cdFx0XHRcdFx0Y3NzX2NsYXNzZXNfX2Zvcl9kYXRlLnB1c2goICdjaGVja19vdXRfdGltZV9kYXRlX2FwcHJvdmVkJywgJ2NoZWNrX2luX3RpbWVfZGF0ZTJhcHByb3ZlJyApO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0XHRpZiAoIGRhdGVfYm9va2luZ3Nfb2JqWyAnc3VtbWFyeScgXVsgJ3N0YXR1c19mb3JfYm9va2luZ3MnIF0uaW5kZXhPZiggJ3BlbmRpbmdfYXBwcm92ZWQnICkgPiAtMSApe1xyXG5cdFx0XHRcdFx0Y3NzX2NsYXNzZXNfX2Zvcl9kYXRlLnB1c2goICdjaGVja19vdXRfdGltZV9kYXRlMmFwcHJvdmUnLCAnY2hlY2tfaW5fdGltZV9kYXRlX2FwcHJvdmVkJyApO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0XHRicmVhaztcclxuXHJcblx0XHRcdGNhc2UgJ2NoZWNrX2luJzpcclxuXHRcdFx0XHRjc3NfY2xhc3Nlc19fZm9yX2RhdGUucHVzaCggJ3RpbWVzcGFydGx5JywgJ2NoZWNrX2luX3RpbWUnICk7XHJcblxyXG5cdFx0XHRcdC8vRml4SW46IDkuOS4wLjMzXHJcblx0XHRcdFx0aWYgKCBkYXRlX2Jvb2tpbmdzX29ialsgJ3N1bW1hcnknIF1bICdzdGF0dXNfZm9yX2Jvb2tpbmdzJyBdLmluZGV4T2YoICdwZW5kaW5nJyApID4gLTEgKXtcclxuXHRcdFx0XHRcdGNzc19jbGFzc2VzX19mb3JfZGF0ZS5wdXNoKCAnY2hlY2tfaW5fdGltZV9kYXRlMmFwcHJvdmUnICk7XHJcblx0XHRcdFx0fSBlbHNlIGlmICggZGF0ZV9ib29raW5nc19vYmpbICdzdW1tYXJ5JyBdWyAnc3RhdHVzX2Zvcl9ib29raW5ncycgXS5pbmRleE9mKCAnYXBwcm92ZWQnICkgPiAtMSApe1xyXG5cdFx0XHRcdFx0Y3NzX2NsYXNzZXNfX2Zvcl9kYXRlLnB1c2goICdjaGVja19pbl90aW1lX2RhdGVfYXBwcm92ZWQnICk7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHRcdGJyZWFrO1xyXG5cclxuXHRcdFx0Y2FzZSAnY2hlY2tfb3V0JzpcclxuXHRcdFx0XHRjc3NfY2xhc3Nlc19fZm9yX2RhdGUucHVzaCggJ3RpbWVzcGFydGx5JywgJ2NoZWNrX291dF90aW1lJyApO1xyXG5cclxuXHRcdFx0XHQvL0ZpeEluOiA5LjkuMC4zM1xyXG5cdFx0XHRcdGlmICggZGF0ZV9ib29raW5nc19vYmpbICdzdW1tYXJ5JyBdWyAnc3RhdHVzX2Zvcl9ib29raW5ncycgXS5pbmRleE9mKCAncGVuZGluZycgKSA+IC0xICl7XHJcblx0XHRcdFx0XHRjc3NfY2xhc3Nlc19fZm9yX2RhdGUucHVzaCggJ2NoZWNrX291dF90aW1lX2RhdGUyYXBwcm92ZScgKTtcclxuXHRcdFx0XHR9IGVsc2UgaWYgKCBkYXRlX2Jvb2tpbmdzX29ialsgJ3N1bW1hcnknIF1bICdzdGF0dXNfZm9yX2Jvb2tpbmdzJyBdLmluZGV4T2YoICdhcHByb3ZlZCcgKSA+IC0xICl7XHJcblx0XHRcdFx0XHRjc3NfY2xhc3Nlc19fZm9yX2RhdGUucHVzaCggJ2NoZWNrX291dF90aW1lX2RhdGVfYXBwcm92ZWQnICk7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHRcdGJyZWFrO1xyXG5cclxuXHRcdFx0ZGVmYXVsdDpcclxuXHRcdFx0XHQvLyBtaXhlZCBzdGF0dXNlczogJ2NoYW5nZV9vdmVyIGNoZWNrX291dCcgLi4uLiB2YXJpYXRpb25zLi4uLiBjaGVjayBtb3JlIGluIFx0XHRmdW5jdGlvbiB3cGJjX2dldF9hdmFpbGFiaWxpdHlfcGVyX2RheXNfYXJyKClcclxuXHRcdFx0XHRkYXRlX2Jvb2tpbmdzX29ialsgJ3N1bW1hcnknXVsnc3RhdHVzX2Zvcl9kYXknIF0gPSAnYXZhaWxhYmxlJztcclxuXHRcdH1cclxuXHJcblxyXG5cclxuXHRcdGlmICggJ2F2YWlsYWJsZScgIT0gZGF0ZV9ib29raW5nc19vYmpbICdzdW1tYXJ5J11bJ3N0YXR1c19mb3JfZGF5JyBdICl7XHJcblxyXG5cdFx0XHR2YXIgaXNfc2V0X3BlbmRpbmdfZGF5c19zZWxlY3RhYmxlID0gX3dwYmMuY2FsZW5kYXJfX2dldF9wYXJhbV92YWx1ZSggcmVzb3VyY2VfaWQsICdwZW5kaW5nX2RheXNfc2VsZWN0YWJsZScgKTtcdC8vIHNldCBwZW5kaW5nIGRheXMgc2VsZWN0YWJsZSAgICAgICAgICAvL0ZpeEluOiA4LjYuMS4xOFxyXG5cclxuXHRcdFx0c3dpdGNoICggZGF0ZV9ib29raW5nc19vYmpbICdzdW1tYXJ5J11bJ3N0YXR1c19mb3JfYm9va2luZ3MnIF0gKXtcclxuXHJcblx0XHRcdFx0Y2FzZSAnJzpcclxuXHRcdFx0XHRcdC8vIFVzdWFsbHkgIGl0J3MgbWVhbnMgdGhhdCBkYXkgIGlzIGF2YWlsYWJsZSBvciB1bmF2YWlsYWJsZSB3aXRob3V0IHRoZSBib29raW5nc1xyXG5cdFx0XHRcdFx0YnJlYWs7XHJcblxyXG5cdFx0XHRcdGNhc2UgJ3BlbmRpbmcnOlxyXG5cdFx0XHRcdFx0Y3NzX2NsYXNzZXNfX2Zvcl9kYXRlLnB1c2goICdkYXRlMmFwcHJvdmUnICk7XHJcblx0XHRcdFx0XHRpc19kYXlfc2VsZWN0YWJsZSA9IChpc19kYXlfc2VsZWN0YWJsZSkgPyB0cnVlIDogaXNfc2V0X3BlbmRpbmdfZGF5c19zZWxlY3RhYmxlO1xyXG5cdFx0XHRcdFx0YnJlYWs7XHJcblxyXG5cdFx0XHRcdGNhc2UgJ2FwcHJvdmVkJzpcclxuXHRcdFx0XHRcdGNzc19jbGFzc2VzX19mb3JfZGF0ZS5wdXNoKCAnZGF0ZV9hcHByb3ZlZCcgKTtcclxuXHRcdFx0XHRcdGJyZWFrO1xyXG5cclxuXHRcdFx0XHQvLyBTaXR1YXRpb25zIGZvciBcImNoYW5nZS1vdmVyXCIgZGF5czogLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cdFx0XHRcdGNhc2UgJ3BlbmRpbmdfcGVuZGluZyc6XHJcblx0XHRcdFx0XHRjc3NfY2xhc3Nlc19fZm9yX2RhdGUucHVzaCggJ2NoZWNrX291dF90aW1lX2RhdGUyYXBwcm92ZScsICdjaGVja19pbl90aW1lX2RhdGUyYXBwcm92ZScgKTtcclxuXHRcdFx0XHRcdGlzX2RheV9zZWxlY3RhYmxlID0gKGlzX2RheV9zZWxlY3RhYmxlKSA/IHRydWUgOiBpc19zZXRfcGVuZGluZ19kYXlzX3NlbGVjdGFibGU7XHJcblx0XHRcdFx0XHRicmVhaztcclxuXHJcblx0XHRcdFx0Y2FzZSAncGVuZGluZ19hcHByb3ZlZCc6XHJcblx0XHRcdFx0XHRjc3NfY2xhc3Nlc19fZm9yX2RhdGUucHVzaCggJ2NoZWNrX291dF90aW1lX2RhdGUyYXBwcm92ZScsICdjaGVja19pbl90aW1lX2RhdGVfYXBwcm92ZWQnICk7XHJcblx0XHRcdFx0XHRpc19kYXlfc2VsZWN0YWJsZSA9IChpc19kYXlfc2VsZWN0YWJsZSkgPyB0cnVlIDogaXNfc2V0X3BlbmRpbmdfZGF5c19zZWxlY3RhYmxlO1xyXG5cdFx0XHRcdFx0YnJlYWs7XHJcblxyXG5cdFx0XHRcdGNhc2UgJ2FwcHJvdmVkX3BlbmRpbmcnOlxyXG5cdFx0XHRcdFx0Y3NzX2NsYXNzZXNfX2Zvcl9kYXRlLnB1c2goICdjaGVja19vdXRfdGltZV9kYXRlX2FwcHJvdmVkJywgJ2NoZWNrX2luX3RpbWVfZGF0ZTJhcHByb3ZlJyApO1xyXG5cdFx0XHRcdFx0aXNfZGF5X3NlbGVjdGFibGUgPSAoaXNfZGF5X3NlbGVjdGFibGUpID8gdHJ1ZSA6IGlzX3NldF9wZW5kaW5nX2RheXNfc2VsZWN0YWJsZTtcclxuXHRcdFx0XHRcdGJyZWFrO1xyXG5cclxuXHRcdFx0XHRjYXNlICdhcHByb3ZlZF9hcHByb3ZlZCc6XHJcblx0XHRcdFx0XHRjc3NfY2xhc3Nlc19fZm9yX2RhdGUucHVzaCggJ2NoZWNrX291dF90aW1lX2RhdGVfYXBwcm92ZWQnLCAnY2hlY2tfaW5fdGltZV9kYXRlX2FwcHJvdmVkJyApO1xyXG5cdFx0XHRcdFx0YnJlYWs7XHJcblxyXG5cdFx0XHRcdGRlZmF1bHQ6XHJcblxyXG5cdFx0XHR9XHJcblx0XHR9XHJcblxyXG5cdFx0cmV0dXJuIFsgaXNfZGF5X3NlbGVjdGFibGUsIGNzc19jbGFzc2VzX19mb3JfZGF0ZS5qb2luKCAnICcgKSBdO1xyXG5cdH1cclxuXHJcblxyXG5cdC8qKlxyXG5cdCAqIE1vdXNlb3ZlciBjYWxlbmRhciBkYXRlIGNlbGxzXHJcblx0ICpcclxuXHQgKiBAcGFyYW0gc3RyaW5nX2RhdGVcclxuXHQgKiBAcGFyYW0gZGF0ZVx0XHRcdFx0XHRcdFx0XHRcdFx0LSAgSmF2YVNjcmlwdCBEYXRlIE9iajogIFx0XHRNb24gRGVjIDExIDIwMjMgMDA6MDA6MDAgR01UKzAyMDAgKEVhc3Rlcm4gRXVyb3BlYW4gU3RhbmRhcmQgVGltZSlcclxuXHQgKiBAcGFyYW0gY2FsZW5kYXJfcGFyYW1zX2Fyclx0XHRcdFx0XHRcdC0gIENhbGVuZGFyIFNldHRpbmdzIE9iamVjdDogIFx0e1xyXG5cdCAqXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQgIFx0XHRcdFx0XHRcdFwicmVzb3VyY2VfaWRcIjogNFxyXG5cdCAqXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0fVxyXG5cdCAqIEBwYXJhbSBkYXRlcGlja190aGlzXHRcdFx0XHRcdFx0XHRcdC0gdGhpcyBvZiBkYXRlcGljayBPYmpcclxuXHQgKiBAcmV0dXJucyB7Ym9vbGVhbn1cclxuXHQgKi9cclxuXHRmdW5jdGlvbiB3cGJjX19jYWxlbmRhcl9fb25faG92ZXJfZGF5cyggc3RyaW5nX2RhdGUsIGRhdGUsIGNhbGVuZGFyX3BhcmFtc19hcnIsIGRhdGVwaWNrX3RoaXMgKSB7XHJcblxyXG5cdFx0aWYgKCBudWxsID09PSBkYXRlICl7IHJldHVybiBmYWxzZTsgfVxyXG5cclxuXHRcdHZhciBjbGFzc19kYXkgICAgID0gd3BiY19fZ2V0X190ZF9jbGFzc19kYXRlKCBkYXRlICk7XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0Ly8gJzEtOS0yMDIzJ1xyXG5cdFx0dmFyIHNxbF9jbGFzc19kYXkgPSB3cGJjX19nZXRfX3NxbF9jbGFzc19kYXRlKCBkYXRlICk7XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0Ly8gJzIwMjMtMDEtMDknXHJcblx0XHR2YXIgcmVzb3VyY2VfaWQgPSAoICd1bmRlZmluZWQnICE9PSB0eXBlb2YoY2FsZW5kYXJfcGFyYW1zX2FyclsgJ3Jlc291cmNlX2lkJyBdKSApID8gY2FsZW5kYXJfcGFyYW1zX2FyclsgJ3Jlc291cmNlX2lkJyBdIDogJzEnO1x0XHQvLyAnMSdcclxuXHJcblx0XHQvLyBHZXQgRGF0YSAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cdFx0dmFyIGRhdGVfYm9va2luZ19vYmogPSBfd3BiYy5ib29raW5nc19pbl9jYWxlbmRhcl9fZ2V0X2Zvcl9kYXRlKCByZXNvdXJjZV9pZCwgc3FsX2NsYXNzX2RheSApO1x0XHRcdFx0XHRcdFx0XHRcdFx0XHQvLyB7Li4ufVxyXG5cclxuXHRcdGlmICggISBkYXRlX2Jvb2tpbmdfb2JqICl7IHJldHVybiBmYWxzZTsgfVxyXG5cclxuXHJcblx0XHQvLyBUIG8gbyBsIHQgaSBwIHMgLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cdFx0dmFyIHRvb2x0aXBfdGV4dCA9ICcnO1xyXG5cdFx0aWYgKCBkYXRlX2Jvb2tpbmdfb2JqWyAnc3VtbWFyeSddWyd0b29sdGlwX2F2YWlsYWJpbGl0eScgXS5sZW5ndGggPiAwICl7XHJcblx0XHRcdHRvb2x0aXBfdGV4dCArPSAgZGF0ZV9ib29raW5nX29ialsgJ3N1bW1hcnknXVsndG9vbHRpcF9hdmFpbGFiaWxpdHknIF07XHJcblx0XHR9XHJcblx0XHRpZiAoIGRhdGVfYm9va2luZ19vYmpbICdzdW1tYXJ5J11bJ3Rvb2x0aXBfZGF5X2Nvc3QnIF0ubGVuZ3RoID4gMCApe1xyXG5cdFx0XHR0b29sdGlwX3RleHQgKz0gIGRhdGVfYm9va2luZ19vYmpbICdzdW1tYXJ5J11bJ3Rvb2x0aXBfZGF5X2Nvc3QnIF07XHJcblx0XHR9XHJcblx0XHRpZiAoIGRhdGVfYm9va2luZ19vYmpbICdzdW1tYXJ5J11bJ3Rvb2x0aXBfdGltZXMnIF0ubGVuZ3RoID4gMCApe1xyXG5cdFx0XHR0b29sdGlwX3RleHQgKz0gIGRhdGVfYm9va2luZ19vYmpbICdzdW1tYXJ5J11bJ3Rvb2x0aXBfdGltZXMnIF07XHJcblx0XHR9XHJcblx0XHRpZiAoIGRhdGVfYm9va2luZ19vYmpbICdzdW1tYXJ5J11bJ3Rvb2x0aXBfYm9va2luZ19kZXRhaWxzJyBdLmxlbmd0aCA+IDAgKXtcclxuXHRcdFx0dG9vbHRpcF90ZXh0ICs9ICBkYXRlX2Jvb2tpbmdfb2JqWyAnc3VtbWFyeSddWyd0b29sdGlwX2Jvb2tpbmdfZGV0YWlscycgXTtcclxuXHRcdH1cclxuXHRcdHdwYmNfc2V0X3Rvb2x0aXBfX19mb3JfX2NhbGVuZGFyX2RhdGUoIHRvb2x0aXBfdGV4dCwgcmVzb3VyY2VfaWQsIGNsYXNzX2RheSApO1xyXG5cclxuXHJcblxyXG5cdFx0Ly8gIFUgbiBoIG8gdiBlIHIgaSBuIGcgICAgaW4gICAgVU5TRUxFQ1RBQkxFX0NBTEVOREFSICAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHRcdHZhciBpc191bnNlbGVjdGFibGVfY2FsZW5kYXIgPSAoIGpRdWVyeSggJyNjYWxlbmRhcl9ib29raW5nX3Vuc2VsZWN0YWJsZScgKyByZXNvdXJjZV9pZCApLmxlbmd0aCA+IDApO1x0XHRcdFx0Ly9GaXhJbjogOC4wLjEuMlxyXG5cdFx0dmFyIGlzX2Jvb2tpbmdfZm9ybV9leGlzdCAgICA9ICggalF1ZXJ5KCAnI2Jvb2tpbmdfZm9ybV9kaXYnICsgcmVzb3VyY2VfaWQgKS5sZW5ndGggPiAwICk7XHJcblxyXG5cdFx0aWYgKCAoIGlzX3Vuc2VsZWN0YWJsZV9jYWxlbmRhciApICYmICggISBpc19ib29raW5nX2Zvcm1fZXhpc3QgKSApe1xyXG5cclxuXHRcdFx0LyoqXHJcblx0XHRcdCAqICBVbiBIb3ZlciBhbGwgZGF0ZXMgaW4gY2FsZW5kYXIgKHdpdGhvdXQgdGhlIGJvb2tpbmcgZm9ybSksIGlmIG9ubHkgQXZhaWxhYmlsaXR5IENhbGVuZGFyIGhlcmUgYW5kIHdlIGRvIG5vdCBpbnNlcnQgQm9va2luZyBmb3JtIGJ5IG1pc3Rha2UuXHJcblx0XHRcdCAqL1xyXG5cclxuXHRcdFx0d3BiY19jYWxlbmRhcnNfX2NsZWFyX2RheXNfaGlnaGxpZ2h0aW5nKCByZXNvdXJjZV9pZCApOyBcdFx0XHRcdFx0XHRcdC8vIENsZWFyIGRheXMgaGlnaGxpZ2h0aW5nXHJcblxyXG5cdFx0XHR2YXIgY3NzX29mX2NhbGVuZGFyID0gJy53cGJjX29ubHlfY2FsZW5kYXIgI2NhbGVuZGFyX2Jvb2tpbmcnICsgcmVzb3VyY2VfaWQ7XHJcblx0XHRcdGpRdWVyeSggY3NzX29mX2NhbGVuZGFyICsgJyAuZGF0ZXBpY2stZGF5cy1jZWxsLCAnXHJcblx0XHRcdFx0ICArIGNzc19vZl9jYWxlbmRhciArICcgLmRhdGVwaWNrLWRheXMtY2VsbCBhJyApLmNzcyggJ2N1cnNvcicsICdkZWZhdWx0JyApO1x0Ly8gU2V0IGN1cnNvciB0byBEZWZhdWx0XHJcblx0XHRcdHJldHVybiBmYWxzZTtcclxuXHRcdH1cclxuXHJcblxyXG5cclxuXHRcdC8vICBEIGEgeSBzICAgIEggbyB2IGUgciBpIG4gZyAgLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblx0XHRpZiAoXHJcblx0XHRcdCAgICggbG9jYXRpb24uaHJlZi5pbmRleE9mKCAncGFnZT13cGJjJyApID09IC0xIClcclxuXHRcdFx0fHwgKCBsb2NhdGlvbi5ocmVmLmluZGV4T2YoICdwYWdlPXdwYmMtbmV3JyApID4gMCApXHJcblx0XHRcdHx8ICggbG9jYXRpb24uaHJlZi5pbmRleE9mKCAncGFnZT13cGJjLWF2YWlsYWJpbGl0eScgKSA+IDAgKVxyXG5cdFx0XHR8fCAoICAoIGxvY2F0aW9uLmhyZWYuaW5kZXhPZiggJ3BhZ2U9d3BiYy1zZXR0aW5ncycgKSA+IDAgKSAgJiZcclxuXHRcdFx0XHQgICggbG9jYXRpb24uaHJlZi5pbmRleE9mKCAnJnRhYj1mb3JtJyApID4gMCApXHJcblx0XHRcdCAgIClcclxuXHRcdCl7XHJcblx0XHRcdC8vIFRoZSBzYW1lIGFzIGRhdGVzIHNlbGVjdGlvbiwgIGJ1dCBmb3IgZGF5cyBob3ZlcmluZ1xyXG5cclxuXHRcdFx0aWYgKCAnZnVuY3Rpb24nID09IHR5cGVvZiggd3BiY19fY2FsZW5kYXJfX2RvX2RheXNfaGlnaGxpZ2h0X19icyApICl7XHJcblx0XHRcdFx0d3BiY19fY2FsZW5kYXJfX2RvX2RheXNfaGlnaGxpZ2h0X19icyggc3FsX2NsYXNzX2RheSwgZGF0ZSwgcmVzb3VyY2VfaWQgKTtcclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cclxuXHR9XHJcblxyXG5cclxuXHQvKipcclxuXHQgKiBTZWxlY3QgY2FsZW5kYXIgZGF0ZSBjZWxsc1xyXG5cdCAqXHJcblx0ICogQHBhcmFtIGRhdGVcdFx0XHRcdFx0XHRcdFx0XHRcdC0gIEphdmFTY3JpcHQgRGF0ZSBPYmo6ICBcdFx0TW9uIERlYyAxMSAyMDIzIDAwOjAwOjAwIEdNVCswMjAwIChFYXN0ZXJuIEV1cm9wZWFuIFN0YW5kYXJkIFRpbWUpXHJcblx0ICogQHBhcmFtIGNhbGVuZGFyX3BhcmFtc19hcnJcdFx0XHRcdFx0XHQtICBDYWxlbmRhciBTZXR0aW5ncyBPYmplY3Q6ICBcdHtcclxuXHQgKlx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0ICBcdFx0XHRcdFx0XHRcInJlc291cmNlX2lkXCI6IDRcclxuXHQgKlx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdH1cclxuXHQgKiBAcGFyYW0gZGF0ZXBpY2tfdGhpc1x0XHRcdFx0XHRcdFx0XHQtIHRoaXMgb2YgZGF0ZXBpY2sgT2JqXHJcblx0ICpcclxuXHQgKi9cclxuXHRmdW5jdGlvbiB3cGJjX19jYWxlbmRhcl9fb25fc2VsZWN0X2RheXMoIGRhdGUsIGNhbGVuZGFyX3BhcmFtc19hcnIsIGRhdGVwaWNrX3RoaXMgKXtcclxuXHJcblx0XHR2YXIgcmVzb3VyY2VfaWQgPSAoICd1bmRlZmluZWQnICE9PSB0eXBlb2YoY2FsZW5kYXJfcGFyYW1zX2FyclsgJ3Jlc291cmNlX2lkJyBdKSApID8gY2FsZW5kYXJfcGFyYW1zX2FyclsgJ3Jlc291cmNlX2lkJyBdIDogJzEnO1x0XHQvLyAnMSdcclxuXHJcblx0XHQvLyBTZXQgdW5zZWxlY3RhYmxlLCAgaWYgb25seSBBdmFpbGFiaWxpdHkgQ2FsZW5kYXIgIGhlcmUgKGFuZCB3ZSBkbyBub3QgaW5zZXJ0IEJvb2tpbmcgZm9ybSBieSBtaXN0YWtlKS5cclxuXHRcdHZhciBpc191bnNlbGVjdGFibGVfY2FsZW5kYXIgPSAoIGpRdWVyeSggJyNjYWxlbmRhcl9ib29raW5nX3Vuc2VsZWN0YWJsZScgKyByZXNvdXJjZV9pZCApLmxlbmd0aCA+IDApO1x0XHRcdFx0Ly9GaXhJbjogOC4wLjEuMlxyXG5cdFx0dmFyIGlzX2Jvb2tpbmdfZm9ybV9leGlzdCAgICA9ICggalF1ZXJ5KCAnI2Jvb2tpbmdfZm9ybV9kaXYnICsgcmVzb3VyY2VfaWQgKS5sZW5ndGggPiAwICk7XHJcblx0XHRpZiAoICggaXNfdW5zZWxlY3RhYmxlX2NhbGVuZGFyICkgJiYgKCAhIGlzX2Jvb2tpbmdfZm9ybV9leGlzdCApICl7XHJcblx0XHRcdHdwYmNfY2FsZW5kYXJfX3Vuc2VsZWN0X2FsbF9kYXRlcyggcmVzb3VyY2VfaWQgKTtcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdC8vIFVuc2VsZWN0IERhdGVzXHJcblx0XHRcdGpRdWVyeSgnLndwYmNfb25seV9jYWxlbmRhciAucG9wb3Zlcl9jYWxlbmRhcl9ob3ZlcicpLnJlbW92ZSgpOyAgICAgICAgICAgICAgICAgICAgICBcdFx0XHRcdFx0XHRcdC8vIEhpZGUgYWxsIG9wZW5lZCBwb3BvdmVyc1xyXG5cdFx0XHRyZXR1cm4gZmFsc2U7XHJcblx0XHR9XHJcblxyXG5cdFx0alF1ZXJ5KCAnI2RhdGVfYm9va2luZycgKyByZXNvdXJjZV9pZCApLnZhbCggZGF0ZSApO1x0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0Ly8gQWRkIHNlbGVjdGVkIGRhdGVzIHRvICBoaWRkZW4gdGV4dGFyZWFcclxuXHJcblxyXG5cdFx0aWYgKCAnZnVuY3Rpb24nID09PSB0eXBlb2YgKHdwYmNfX2NhbGVuZGFyX19kb19kYXlzX3NlbGVjdF9fYnMpICl7IHdwYmNfX2NhbGVuZGFyX19kb19kYXlzX3NlbGVjdF9fYnMoIGRhdGUsIHJlc291cmNlX2lkICk7IH1cclxuXHJcblx0XHR3cGJjX2Rpc2FibGVfdGltZV9maWVsZHNfaW5fYm9va2luZ19mb3JtKCByZXNvdXJjZV9pZCApO1xyXG5cclxuXHRcdC8vIEhvb2sgLS0gdHJpZ2dlciBkYXkgc2VsZWN0aW9uIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblx0XHR2YXIgbW91c2VfY2xpY2tlZF9kYXRlcyA9IGRhdGU7XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQvLyBDYW4gYmU6IFwiMDUuMTAuMjAyMyAtIDA3LjEwLjIwMjNcIiAgfCAgXCIxMC4xMC4yMDIzIC0gMTAuMTAuMjAyM1wiICB8XHJcblx0XHR2YXIgYWxsX3NlbGVjdGVkX2RhdGVzX2FyciA9IHdwYmNfZ2V0X19zZWxlY3RlZF9kYXRlc19zcWxfX2FzX2FyciggcmVzb3VyY2VfaWQgKTtcdFx0XHRcdFx0XHRcdFx0XHQvLyBDYW4gYmU6IFsgXCIyMDIzLTEwLTA1XCIsIFwiMjAyMy0xMC0wNlwiLCBcIjIwMjMtMTAtMDdcIiwg4oCmIF1cclxuXHRcdGpRdWVyeSggXCIuYm9va2luZ19mb3JtX2RpdlwiICkudHJpZ2dlciggXCJkYXRlX3NlbGVjdGVkXCIsIFsgcmVzb3VyY2VfaWQsIG1vdXNlX2NsaWNrZWRfZGF0ZXMsIGFsbF9zZWxlY3RlZF9kYXRlc19hcnIgXSApO1xyXG5cdH1cclxuXHJcblx0Ly8gTWFyayBtaWRkbGUgc2VsZWN0ZWQgZGF0ZXMgd2l0aCAwLjUgb3BhY2l0eVx0XHQvL0ZpeEluOiAxMC4zLjAuOVxyXG5cdGpRdWVyeSggZG9jdW1lbnQgKS5yZWFkeSggZnVuY3Rpb24gKCl7XHJcblx0XHRqUXVlcnkoIFwiLmJvb2tpbmdfZm9ybV9kaXZcIiApLm9uKCAnZGF0ZV9zZWxlY3RlZCcsIGZ1bmN0aW9uICggZXZlbnQsIHJlc291cmNlX2lkLCBkYXRlICl7XHJcblx0XHRcdFx0aWYgKFxyXG5cdFx0XHRcdFx0ICAgKCAgJ2ZpeGVkJyA9PT0gX3dwYmMuY2FsZW5kYXJfX2dldF9wYXJhbV92YWx1ZSggcmVzb3VyY2VfaWQsICdkYXlzX3NlbGVjdF9tb2RlJyApKVxyXG5cdFx0XHRcdFx0fHwgKCdkeW5hbWljJyA9PT0gX3dwYmMuY2FsZW5kYXJfX2dldF9wYXJhbV92YWx1ZSggcmVzb3VyY2VfaWQsICdkYXlzX3NlbGVjdF9tb2RlJyApKVxyXG5cdFx0XHRcdCl7XHJcblx0XHRcdFx0XHR2YXIgY2xvc2VkX3RpbWVyID0gc2V0VGltZW91dCggZnVuY3Rpb24gKCl7XHJcblx0XHRcdFx0XHRcdHZhciBtaWRkbGVfZGF5c19vcGFjaXR5ID0gX3dwYmMuZ2V0X290aGVyX3BhcmFtKCAnY2FsZW5kYXJzX19kYXlzX3NlbGVjdGlvbl9fbWlkZGxlX2RheXNfb3BhY2l0eScgKTtcclxuXHRcdFx0XHRcdFx0alF1ZXJ5KCAnI2NhbGVuZGFyX2Jvb2tpbmcnICsgcmVzb3VyY2VfaWQgKyAnIC5kYXRlcGljay1jdXJyZW50LWRheScgKS5ub3QoIFwiLnNlbGVjdGVkX2NoZWNrX2luX291dFwiICkuY3NzKCAnb3BhY2l0eScsIG1pZGRsZV9kYXlzX29wYWNpdHkgKTtcclxuXHRcdFx0XHRcdH0sIDEwICk7XHJcblx0XHRcdFx0fVxyXG5cdFx0fSApO1xyXG5cdH0gKTtcclxuXHJcblxyXG5cdC8qKlxyXG5cdCAqIC0tICBUIGkgbSBlICAgIEYgaSBlIGwgZCBzICAgICBzdGFydCAgLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHQgKi9cclxuXHJcblx0LyoqXHJcblx0ICogRGlzYWJsZSB0aW1lIHNsb3RzIGluIGJvb2tpbmcgZm9ybSBkZXBlbmQgb24gc2VsZWN0ZWQgZGF0ZXMgYW5kIGJvb2tlZCBkYXRlcy90aW1lc1xyXG5cdCAqXHJcblx0ICogQHBhcmFtIHJlc291cmNlX2lkXHJcblx0ICovXHJcblx0ZnVuY3Rpb24gd3BiY19kaXNhYmxlX3RpbWVfZmllbGRzX2luX2Jvb2tpbmdfZm9ybSggcmVzb3VyY2VfaWQgKXtcclxuXHJcblx0XHQvKipcclxuXHRcdCAqIFx0MS4gR2V0IGFsbCB0aW1lIGZpZWxkcyBpbiB0aGUgYm9va2luZyBmb3JtIGFzIGFycmF5ICBvZiBvYmplY3RzXHJcblx0XHQgKiBcdFx0XHRcdFx0W1xyXG5cdFx0ICogXHRcdFx0XHRcdCBcdCAgIHtcdGpxdWVyeV9vcHRpb246ICAgICAgalF1ZXJ5X09iamVjdCB7fVxyXG5cdFx0ICogXHRcdFx0XHRcdFx0XHRcdG5hbWU6ICAgICAgICAgICAgICAgJ3JhbmdldGltZTJbXSdcclxuXHRcdCAqIFx0XHRcdFx0XHRcdFx0XHR0aW1lc19hc19zZWNvbmRzOiAgIFsgMjE2MDAsIDIzNDAwIF1cclxuXHRcdCAqIFx0XHRcdFx0XHRcdFx0XHR2YWx1ZV9vcHRpb25fMjRoOiAgICcwNjowMCAtIDA2OjMwJ1xyXG5cdFx0ICogXHRcdFx0XHRcdCAgICAgfVxyXG5cdFx0ICogXHRcdFx0XHRcdCAgLi4uXHJcblx0XHQgKiBcdFx0XHRcdFx0XHQgICB7XHRqcXVlcnlfb3B0aW9uOiAgICAgIGpRdWVyeV9PYmplY3Qge31cclxuXHRcdCAqIFx0XHRcdFx0XHRcdFx0XHRuYW1lOiAgICAgICAgICAgICAgICdzdGFydHRpbWUyW10nXHJcblx0XHQgKiBcdFx0XHRcdFx0XHRcdFx0dGltZXNfYXNfc2Vjb25kczogICBbIDIxNjAwIF1cclxuXHRcdCAqIFx0XHRcdFx0XHRcdFx0XHR2YWx1ZV9vcHRpb25fMjRoOiAgICcwNjowMCdcclxuXHRcdCAqICBcdFx0XHRcdFx0ICAgIH1cclxuXHRcdCAqIFx0XHRcdFx0XHQgXVxyXG5cdFx0ICovXHJcblx0XHR2YXIgdGltZV9maWVsZHNfb2JqX2FyciA9IHdwYmNfZ2V0X190aW1lX2ZpZWxkc19faW5fYm9va2luZ19mb3JtX19hc19hcnIoIHJlc291cmNlX2lkICk7XHJcblxyXG5cdFx0Ly8gMi4gR2V0IGFsbCBzZWxlY3RlZCBkYXRlcyBpbiAgU1FMIGZvcm1hdCAgbGlrZSB0aGlzIFsgXCIyMDIzLTA4LTIzXCIsIFwiMjAyMy0wOC0yNFwiLCBcIjIwMjMtMDgtMjVcIiwgLi4uIF1cclxuXHRcdHZhciBzZWxlY3RlZF9kYXRlc19hcnIgPSB3cGJjX2dldF9fc2VsZWN0ZWRfZGF0ZXNfc3FsX19hc19hcnIoIHJlc291cmNlX2lkICk7XHJcblxyXG5cdFx0Ly8gMy4gR2V0IGNoaWxkIGJvb2tpbmcgcmVzb3VyY2VzICBvciBzaW5nbGUgYm9va2luZyByZXNvdXJjZSAgdGhhdCAgZXhpc3QgIGluIGRhdGVzXHJcblx0XHR2YXIgY2hpbGRfcmVzb3VyY2VzX2FyciA9IHdwYmNfY2xvbmVfb2JqKCBfd3BiYy5ib29raW5nX19nZXRfcGFyYW1fdmFsdWUoIHJlc291cmNlX2lkLCAncmVzb3VyY2VzX2lkX2Fycl9faW5fZGF0ZXMnICkgKTtcclxuXHJcblx0XHR2YXIgc3FsX2RhdGU7XHJcblx0XHR2YXIgY2hpbGRfcmVzb3VyY2VfaWQ7XHJcblx0XHR2YXIgbWVyZ2VkX3NlY29uZHM7XHJcblx0XHR2YXIgdGltZV9maWVsZHNfb2JqO1xyXG5cdFx0dmFyIGlzX2ludGVyc2VjdDtcclxuXHRcdHZhciBpc19jaGVja19pbjtcclxuXHJcblx0XHQvLyA0LiBMb29wICBhbGwgIHRpbWUgRmllbGRzIG9wdGlvbnNcdFx0Ly9GaXhJbjogMTAuMy4wLjJcclxuXHRcdGZvciAoIGxldCBmaWVsZF9rZXkgPSAwOyBmaWVsZF9rZXkgPCB0aW1lX2ZpZWxkc19vYmpfYXJyLmxlbmd0aDsgZmllbGRfa2V5KysgKXtcclxuXHJcblx0XHRcdHRpbWVfZmllbGRzX29ial9hcnJbIGZpZWxkX2tleSBdLmRpc2FibGVkID0gMDsgICAgICAgICAgLy8gQnkgZGVmYXVsdCwgdGhpcyB0aW1lIGZpZWxkIGlzIG5vdCBkaXNhYmxlZFxyXG5cclxuXHRcdFx0dGltZV9maWVsZHNfb2JqID0gdGltZV9maWVsZHNfb2JqX2FyclsgZmllbGRfa2V5IF07XHRcdC8vIHsgdGltZXNfYXNfc2Vjb25kczogWyAyMTYwMCwgMjM0MDAgXSwgdmFsdWVfb3B0aW9uXzI0aDogJzA2OjAwIC0gMDY6MzAnLCBuYW1lOiAncmFuZ2V0aW1lMltdJywganF1ZXJ5X29wdGlvbjogalF1ZXJ5X09iamVjdCB7fX1cclxuXHJcblx0XHRcdC8vIExvb3AgIGFsbCAgc2VsZWN0ZWQgZGF0ZXNcclxuXHRcdFx0Zm9yICggdmFyIGkgPSAwOyBpIDwgc2VsZWN0ZWRfZGF0ZXNfYXJyLmxlbmd0aDsgaSsrICl7XHJcblxyXG5cdFx0XHRcdC8vRml4SW46IDkuOS4wLjMxXHJcblx0XHRcdFx0aWYgKFxyXG5cdFx0XHRcdFx0ICAgKCAnT2ZmJyA9PT0gX3dwYmMuY2FsZW5kYXJfX2dldF9wYXJhbV92YWx1ZSggcmVzb3VyY2VfaWQsICdib29raW5nX3JlY3VycmVudF90aW1lJyApIClcclxuXHRcdFx0XHRcdCYmICggc2VsZWN0ZWRfZGF0ZXNfYXJyLmxlbmd0aD4xIClcclxuXHRcdFx0XHQpe1xyXG5cdFx0XHRcdFx0Ly9UT0RPOiBza2lwIHNvbWUgZmllbGRzIGNoZWNraW5nIGlmIGl0J3Mgc3RhcnQgLyBlbmQgdGltZSBmb3IgbXVscGxlIGRhdGVzICBzZWxlY3Rpb24gIG1vZGUuXHJcblx0XHRcdFx0XHQvL1RPRE86IHdlIG5lZWQgdG8gZml4IHNpdHVhdGlvbiAgZm9yIGVudGltZXMsICB3aGVuICB1c2VyICBzZWxlY3QgIHNldmVyYWwgIGRhdGVzLCAgYW5kIGluIHN0YXJ0ICB0aW1lIGJvb2tlZCAwMDowMCAtIDE1OjAwICwgYnV0IHN5c3RzbWUgYmxvY2sgdW50aWxsIDE1OjAwIHRoZSBlbmQgdGltZSBhcyB3ZWxsLCAgd2hpY2ggIGlzIHdyb25nLCAgYmVjYXVzZSBpdCAyIG9yIDMgZGF0ZXMgc2VsZWN0aW9uICBhbmQgZW5kIGRhdGUgY2FuIGJlIGZ1bGx1ICBhdmFpbGFibGVcclxuXHJcblx0XHRcdFx0XHRpZiAoICgwID09IGkpICYmICh0aW1lX2ZpZWxkc19vYmpbICduYW1lJyBdLmluZGV4T2YoICdlbmR0aW1lJyApID49IDApICl7XHJcblx0XHRcdFx0XHRcdGJyZWFrO1xyXG5cdFx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0aWYgKCAoIChzZWxlY3RlZF9kYXRlc19hcnIubGVuZ3RoLTEpID09IGkgKSAmJiAodGltZV9maWVsZHNfb2JqWyAnbmFtZScgXS5pbmRleE9mKCAnc3RhcnR0aW1lJyApID49IDApICl7XHJcblx0XHRcdFx0XHRcdGJyZWFrO1xyXG5cdFx0XHRcdFx0fVxyXG5cdFx0XHRcdH1cclxuXHJcblx0XHRcdFx0Ly8gR2V0IERhdGU6ICcyMDIzLTA4LTE4J1xyXG5cdFx0XHRcdHNxbF9kYXRlID0gc2VsZWN0ZWRfZGF0ZXNfYXJyWyBpIF07XHJcblxyXG5cclxuXHRcdFx0XHR2YXIgaG93X21hbnlfcmVzb3VyY2VzX2ludGVyc2VjdGVkID0gMDtcclxuXHRcdFx0XHQvLyBMb29wIGFsbCByZXNvdXJjZXMgSURcclxuXHRcdFx0XHRcdC8vIGZvciAoIHZhciByZXNfa2V5IGluIGNoaWxkX3Jlc291cmNlc19hcnIgKXtcdCBcdFx0XHRcdFx0XHQvL0ZpeEluOiAxMC4zLjAuMlxyXG5cdFx0XHRcdGZvciAoIGxldCByZXNfa2V5ID0gMDsgcmVzX2tleSA8IGNoaWxkX3Jlc291cmNlc19hcnIubGVuZ3RoOyByZXNfa2V5KysgKXtcclxuXHJcblx0XHRcdFx0XHRjaGlsZF9yZXNvdXJjZV9pZCA9IGNoaWxkX3Jlc291cmNlc19hcnJbIHJlc19rZXkgXTtcclxuXHJcblx0XHRcdFx0XHQvLyBfd3BiYy5ib29raW5nc19pbl9jYWxlbmRhcl9fZ2V0X2Zvcl9kYXRlKDIsJzIwMjMtMDgtMjEnKVsxMl0uYm9va2VkX3RpbWVfc2xvdHMubWVyZ2VkX3NlY29uZHNcdFx0PSBbIFwiMDc6MDA6MTEgLSAwNzozMDowMlwiLCBcIjEwOjAwOjExIC0gMDA6MDA6MDBcIiBdXHJcblx0XHRcdFx0XHQvLyBfd3BiYy5ib29raW5nc19pbl9jYWxlbmRhcl9fZ2V0X2Zvcl9kYXRlKDIsJzIwMjMtMDgtMjEnKVsyXS5ib29rZWRfdGltZV9zbG90cy5tZXJnZWRfc2Vjb25kc1x0XHRcdD0gWyAgWyAyNTIxMSwgMjcwMDIgXSwgWyAzNjAxMSwgODY0MDAgXSAgXVxyXG5cclxuXHRcdFx0XHRcdGlmICggZmFsc2UgIT09IF93cGJjLmJvb2tpbmdzX2luX2NhbGVuZGFyX19nZXRfZm9yX2RhdGUoIHJlc291cmNlX2lkLCBzcWxfZGF0ZSApICl7XHJcblx0XHRcdFx0XHRcdG1lcmdlZF9zZWNvbmRzID0gX3dwYmMuYm9va2luZ3NfaW5fY2FsZW5kYXJfX2dldF9mb3JfZGF0ZSggcmVzb3VyY2VfaWQsIHNxbF9kYXRlIClbIGNoaWxkX3Jlc291cmNlX2lkIF0uYm9va2VkX3RpbWVfc2xvdHMubWVyZ2VkX3NlY29uZHM7XHRcdC8vIFsgIFsgMjUyMTEsIDI3MDAyIF0sIFsgMzYwMTEsIDg2NDAwIF0gIF1cclxuXHRcdFx0XHRcdH0gZWxzZSB7XHJcblx0XHRcdFx0XHRcdG1lcmdlZF9zZWNvbmRzID0gW107XHJcblx0XHRcdFx0XHR9XHJcblx0XHRcdFx0XHRpZiAoIHRpbWVfZmllbGRzX29iai50aW1lc19hc19zZWNvbmRzLmxlbmd0aCA+IDEgKXtcclxuXHRcdFx0XHRcdFx0aXNfaW50ZXJzZWN0ID0gd3BiY19pc19pbnRlcnNlY3RfX3JhbmdlX3RpbWVfaW50ZXJ2YWwoICBbXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQoIHBhcnNlSW50KCB0aW1lX2ZpZWxkc19vYmoudGltZXNfYXNfc2Vjb25kc1swXSApICsgMjAgKSxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQoIHBhcnNlSW50KCB0aW1lX2ZpZWxkc19vYmoudGltZXNfYXNfc2Vjb25kc1sxXSApIC0gMjAgKVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRdXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRdXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQsIG1lcmdlZF9zZWNvbmRzICk7XHJcblx0XHRcdFx0XHR9IGVsc2Uge1xyXG5cdFx0XHRcdFx0XHRpc19jaGVja19pbiA9ICgtMSAhPT0gdGltZV9maWVsZHNfb2JqLm5hbWUuaW5kZXhPZiggJ3N0YXJ0JyApKTtcclxuXHRcdFx0XHRcdFx0aXNfaW50ZXJzZWN0ID0gd3BiY19pc19pbnRlcnNlY3RfX29uZV90aW1lX2ludGVydmFsKFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0KCAoIGlzX2NoZWNrX2luIClcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCAgPyBwYXJzZUludCggdGltZV9maWVsZHNfb2JqLnRpbWVzX2FzX3NlY29uZHMgKSArIDIwXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQgIDogcGFyc2VJbnQoIHRpbWVfZmllbGRzX29iai50aW1lc19hc19zZWNvbmRzICkgLSAyMFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0KVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0LCBtZXJnZWRfc2Vjb25kcyApO1xyXG5cdFx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0aWYgKGlzX2ludGVyc2VjdCl7XHJcblx0XHRcdFx0XHRcdGhvd19tYW55X3Jlc291cmNlc19pbnRlcnNlY3RlZCsrO1x0XHRcdC8vIEluY3JlYXNlXHJcblx0XHRcdFx0XHR9XHJcblxyXG5cdFx0XHRcdH1cclxuXHJcblx0XHRcdFx0aWYgKCBjaGlsZF9yZXNvdXJjZXNfYXJyLmxlbmd0aCA9PSBob3dfbWFueV9yZXNvdXJjZXNfaW50ZXJzZWN0ZWQgKSB7XHJcblx0XHRcdFx0XHQvLyBBbGwgcmVzb3VyY2VzIGludGVyc2VjdGVkLCAgdGhlbiAgaXQncyBtZWFucyB0aGF0IHRoaXMgdGltZS1zbG90IG9yIHRpbWUgbXVzdCAgYmUgIERpc2FibGVkLCBhbmQgd2UgY2FuICBleGlzdCAgZnJvbSAgIHNlbGVjdGVkX2RhdGVzX2FyciBMT09QXHJcblxyXG5cdFx0XHRcdFx0dGltZV9maWVsZHNfb2JqX2FyclsgZmllbGRfa2V5IF0uZGlzYWJsZWQgPSAxO1xyXG5cdFx0XHRcdFx0YnJlYWs7XHRcdFx0XHRcdFx0XHRcdFx0XHRcdC8vIGV4aXN0ICBmcm9tICAgRGF0ZXMgTE9PUFxyXG5cdFx0XHRcdH1cclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cclxuXHJcblx0XHQvLyA1LiBOb3cgd2UgY2FuIGRpc2FibGUgdGltZSBzbG90IGluIEhUTUwgYnkgIHVzaW5nICAoIGZpZWxkLmRpc2FibGVkID09IDEgKSBwcm9wZXJ0eVxyXG5cdFx0d3BiY19faHRtbF9fdGltZV9maWVsZF9vcHRpb25zX19zZXRfZGlzYWJsZWQoIHRpbWVfZmllbGRzX29ial9hcnIgKTtcclxuXHJcblx0XHRqUXVlcnkoIFwiLmJvb2tpbmdfZm9ybV9kaXZcIiApLnRyaWdnZXIoICd3cGJjX2hvb2tfdGltZXNsb3RzX2Rpc2FibGVkJywgW3Jlc291cmNlX2lkLCBzZWxlY3RlZF9kYXRlc19hcnJdICk7XHRcdFx0XHRcdC8vIFRyaWdnZXIgaG9vayBvbiBkaXNhYmxpbmcgdGltZXNsb3RzLlx0XHRVc2FnZTogXHRqUXVlcnkoIFwiLmJvb2tpbmdfZm9ybV9kaXZcIiApLm9uKCAnd3BiY19ob29rX3RpbWVzbG90c19kaXNhYmxlZCcsIGZ1bmN0aW9uICggZXZlbnQsIGJrX3R5cGUsIGFsbF9kYXRlcyApeyAuLi4gfSApO1x0XHQvL0ZpeEluOiA4LjcuMTEuOVxyXG5cdH1cclxuXHJcblx0XHQvKipcclxuXHRcdCAqIElzIG51bWJlciBpbnNpZGUgL2ludGVyc2VjdCAgb2YgYXJyYXkgb2YgaW50ZXJ2YWxzID9cclxuXHRcdCAqXHJcblx0XHQgKiBAcGFyYW0gdGltZV9BXHRcdCAgICAgXHQtIDI1ODAwXHJcblx0XHQgKiBAcGFyYW0gdGltZV9pbnRlcnZhbF9CXHRcdC0gWyAgWyAyNTIxMSwgMjcwMDIgXSwgWyAzNjAxMSwgODY0MDAgXSAgXVxyXG5cdFx0ICogQHJldHVybnMge2Jvb2xlYW59XHJcblx0XHQgKi9cclxuXHRcdGZ1bmN0aW9uIHdwYmNfaXNfaW50ZXJzZWN0X19vbmVfdGltZV9pbnRlcnZhbCggdGltZV9BLCB0aW1lX2ludGVydmFsX0IgKXtcclxuXHJcblx0XHRcdGZvciAoIHZhciBqID0gMDsgaiA8IHRpbWVfaW50ZXJ2YWxfQi5sZW5ndGg7IGorKyApe1xyXG5cclxuXHRcdFx0XHRpZiAoIChwYXJzZUludCggdGltZV9BICkgPiBwYXJzZUludCggdGltZV9pbnRlcnZhbF9CWyBqIF1bIDAgXSApKSAmJiAocGFyc2VJbnQoIHRpbWVfQSApIDwgcGFyc2VJbnQoIHRpbWVfaW50ZXJ2YWxfQlsgaiBdWyAxIF0gKSkgKXtcclxuXHRcdFx0XHRcdHJldHVybiB0cnVlXHJcblx0XHRcdFx0fVxyXG5cclxuXHRcdFx0XHQvLyBpZiAoICggcGFyc2VJbnQoIHRpbWVfQSApID09IHBhcnNlSW50KCB0aW1lX2ludGVydmFsX0JbIGogXVsgMCBdICkgKSB8fCAoIHBhcnNlSW50KCB0aW1lX0EgKSA9PSBwYXJzZUludCggdGltZV9pbnRlcnZhbF9CWyBqIF1bIDEgXSApICkgKSB7XHJcblx0XHRcdFx0Ly8gXHRcdFx0Ly8gVGltZSBBIGp1c3QgIGF0ICB0aGUgYm9yZGVyIG9mIGludGVydmFsXHJcblx0XHRcdFx0Ly8gfVxyXG5cdFx0XHR9XHJcblxyXG5cdFx0ICAgIHJldHVybiBmYWxzZTtcclxuXHRcdH1cclxuXHJcblx0XHQvKipcclxuXHRcdCAqIElzIHRoZXNlIGFycmF5IG9mIGludGVydmFscyBpbnRlcnNlY3RlZCA/XHJcblx0XHQgKlxyXG5cdFx0ICogQHBhcmFtIHRpbWVfaW50ZXJ2YWxfQVx0XHQtIFsgWyAyMTYwMCwgMjM0MDAgXSBdXHJcblx0XHQgKiBAcGFyYW0gdGltZV9pbnRlcnZhbF9CXHRcdC0gWyAgWyAyNTIxMSwgMjcwMDIgXSwgWyAzNjAxMSwgODY0MDAgXSAgXVxyXG5cdFx0ICogQHJldHVybnMge2Jvb2xlYW59XHJcblx0XHQgKi9cclxuXHRcdGZ1bmN0aW9uIHdwYmNfaXNfaW50ZXJzZWN0X19yYW5nZV90aW1lX2ludGVydmFsKCB0aW1lX2ludGVydmFsX0EsIHRpbWVfaW50ZXJ2YWxfQiApe1xyXG5cclxuXHRcdFx0dmFyIGlzX2ludGVyc2VjdDtcclxuXHJcblx0XHRcdGZvciAoIHZhciBpID0gMDsgaSA8IHRpbWVfaW50ZXJ2YWxfQS5sZW5ndGg7IGkrKyApe1xyXG5cclxuXHRcdFx0XHRmb3IgKCB2YXIgaiA9IDA7IGogPCB0aW1lX2ludGVydmFsX0IubGVuZ3RoOyBqKysgKXtcclxuXHJcblx0XHRcdFx0XHRpc19pbnRlcnNlY3QgPSB3cGJjX2ludGVydmFsc19faXNfaW50ZXJzZWN0ZWQoIHRpbWVfaW50ZXJ2YWxfQVsgaSBdLCB0aW1lX2ludGVydmFsX0JbIGogXSApO1xyXG5cclxuXHRcdFx0XHRcdGlmICggaXNfaW50ZXJzZWN0ICl7XHJcblx0XHRcdFx0XHRcdHJldHVybiB0cnVlO1xyXG5cdFx0XHRcdFx0fVxyXG5cdFx0XHRcdH1cclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0cmV0dXJuIGZhbHNlO1xyXG5cdFx0fVxyXG5cclxuXHRcdC8qKlxyXG5cdFx0ICogR2V0IGFsbCB0aW1lIGZpZWxkcyBpbiB0aGUgYm9va2luZyBmb3JtIGFzIGFycmF5ICBvZiBvYmplY3RzXHJcblx0XHQgKlxyXG5cdFx0ICogQHBhcmFtIHJlc291cmNlX2lkXHJcblx0XHQgKiBAcmV0dXJucyBbXVxyXG5cdFx0ICpcclxuXHRcdCAqIFx0XHRFeGFtcGxlOlxyXG5cdFx0ICogXHRcdFx0XHRcdFtcclxuXHRcdCAqIFx0XHRcdFx0XHQgXHQgICB7XHJcblx0XHQgKiBcdFx0XHRcdFx0XHRcdFx0dmFsdWVfb3B0aW9uXzI0aDogICAnMDY6MDAgLSAwNjozMCdcclxuXHRcdCAqIFx0XHRcdFx0XHRcdFx0XHR0aW1lc19hc19zZWNvbmRzOiAgIFsgMjE2MDAsIDIzNDAwIF1cclxuXHRcdCAqIFx0XHRcdFx0XHQgXHQgICBcdFx0anF1ZXJ5X29wdGlvbjogICAgICBqUXVlcnlfT2JqZWN0IHt9XHJcblx0XHQgKiBcdFx0XHRcdFx0XHRcdFx0bmFtZTogICAgICAgICAgICAgICAncmFuZ2V0aW1lMltdJ1xyXG5cdFx0ICogXHRcdFx0XHRcdCAgICAgfVxyXG5cdFx0ICogXHRcdFx0XHRcdCAgLi4uXHJcblx0XHQgKiBcdFx0XHRcdFx0XHQgICB7XHJcblx0XHQgKiBcdFx0XHRcdFx0XHRcdFx0dmFsdWVfb3B0aW9uXzI0aDogICAnMDY6MDAnXHJcblx0XHQgKiBcdFx0XHRcdFx0XHRcdFx0dGltZXNfYXNfc2Vjb25kczogICBbIDIxNjAwIF1cclxuXHRcdCAqIFx0XHRcdFx0XHRcdCAgIFx0XHRqcXVlcnlfb3B0aW9uOiAgICAgIGpRdWVyeV9PYmplY3Qge31cclxuXHRcdCAqIFx0XHRcdFx0XHRcdFx0XHRuYW1lOiAgICAgICAgICAgICAgICdzdGFydHRpbWUyW10nXHJcblx0XHQgKiAgXHRcdFx0XHRcdCAgICB9XHJcblx0XHQgKiBcdFx0XHRcdFx0IF1cclxuXHRcdCAqL1xyXG5cdFx0ZnVuY3Rpb24gd3BiY19nZXRfX3RpbWVfZmllbGRzX19pbl9ib29raW5nX2Zvcm1fX2FzX2FyciggcmVzb3VyY2VfaWQgKXtcclxuXHRcdCAgICAvKipcclxuXHRcdFx0ICogRmllbGRzIHdpdGggIFtdICBsaWtlIHRoaXMgICBzZWxlY3RbbmFtZT1cInJhbmdldGltZTFbXVwiXVxyXG5cdFx0XHQgKiBpdCdzIHdoZW4gd2UgaGF2ZSAnbXVsdGlwbGUnIGluIHNob3J0Y29kZTogICBbc2VsZWN0KiByYW5nZXRpbWUgbXVsdGlwbGUgIFwiMDY6MDAgLSAwNjozMFwiIC4uLiBdXHJcblx0XHRcdCAqL1xyXG5cdFx0XHR2YXIgdGltZV9maWVsZHNfYXJyPVtcclxuXHRcdFx0XHRcdFx0XHRcdFx0J3NlbGVjdFtuYW1lPVwicmFuZ2V0aW1lJyArIHJlc291cmNlX2lkICsgJ1wiXScsXHJcblx0XHRcdFx0XHRcdFx0XHRcdCdzZWxlY3RbbmFtZT1cInJhbmdldGltZScgKyByZXNvdXJjZV9pZCArICdbXVwiXScsXHJcblx0XHRcdFx0XHRcdFx0XHRcdCdzZWxlY3RbbmFtZT1cInN0YXJ0dGltZScgKyByZXNvdXJjZV9pZCArICdcIl0nLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHQnc2VsZWN0W25hbWU9XCJzdGFydHRpbWUnICsgcmVzb3VyY2VfaWQgKyAnW11cIl0nLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHQnc2VsZWN0W25hbWU9XCJlbmR0aW1lJyArIHJlc291cmNlX2lkICsgJ1wiXScsXHJcblx0XHRcdFx0XHRcdFx0XHRcdCdzZWxlY3RbbmFtZT1cImVuZHRpbWUnICsgcmVzb3VyY2VfaWQgKyAnW11cIl0nXHJcblx0XHRcdFx0XHRcdFx0XHRdO1xyXG5cclxuXHRcdFx0dmFyIHRpbWVfZmllbGRzX29ial9hcnIgPSBbXTtcclxuXHJcblx0XHRcdC8vIExvb3AgYWxsIFRpbWUgRmllbGRzXHJcblx0XHRcdGZvciAoIHZhciBjdGY9IDA7IGN0ZiA8IHRpbWVfZmllbGRzX2Fyci5sZW5ndGg7IGN0ZisrICl7XHJcblxyXG5cdFx0XHRcdHZhciB0aW1lX2ZpZWxkID0gdGltZV9maWVsZHNfYXJyWyBjdGYgXTtcclxuXHRcdFx0XHR2YXIgdGltZV9vcHRpb24gPSBqUXVlcnkoIHRpbWVfZmllbGQgKyAnIG9wdGlvbicgKTtcclxuXHJcblx0XHRcdFx0Ly8gTG9vcCBhbGwgb3B0aW9ucyBpbiB0aW1lIGZpZWxkXHJcblx0XHRcdFx0Zm9yICggdmFyIGogPSAwOyBqIDwgdGltZV9vcHRpb24ubGVuZ3RoOyBqKysgKXtcclxuXHJcblx0XHRcdFx0XHR2YXIganF1ZXJ5X29wdGlvbiA9IGpRdWVyeSggdGltZV9maWVsZCArICcgb3B0aW9uOmVxKCcgKyBqICsgJyknICk7XHJcblx0XHRcdFx0XHR2YXIgdmFsdWVfb3B0aW9uX3NlY29uZHNfYXJyID0ganF1ZXJ5X29wdGlvbi52YWwoKS5zcGxpdCggJy0nICk7XHJcblx0XHRcdFx0XHR2YXIgdGltZXNfYXNfc2Vjb25kcyA9IFtdO1xyXG5cclxuXHRcdFx0XHRcdC8vIEdldCB0aW1lIGFzIHNlY29uZHNcclxuXHRcdFx0XHRcdGlmICggdmFsdWVfb3B0aW9uX3NlY29uZHNfYXJyLmxlbmd0aCApe1x0XHRcdFx0XHRcdFx0XHRcdC8vRml4SW46IDkuOC4xMC4xXHJcblx0XHRcdFx0XHRcdGZvciAoIGxldCBpID0gMDsgaSA8IHZhbHVlX29wdGlvbl9zZWNvbmRzX2Fyci5sZW5ndGg7IGkrKyApe1x0XHQvL0ZpeEluOiAxMC4wLjAuNTZcclxuXHRcdFx0XHRcdFx0XHQvLyB2YWx1ZV9vcHRpb25fc2Vjb25kc19hcnJbaV0gPSAnMTQ6MDAgJyAgfCAnIDE2OjAwJyAgIChpZiBmcm9tICdyYW5nZXRpbWUnKSBhbmQgJzE2OjAwJyAgaWYgKHN0YXJ0L2VuZCB0aW1lKVxyXG5cclxuXHRcdFx0XHRcdFx0XHR2YXIgc3RhcnRfZW5kX3RpbWVzX2FyciA9IHZhbHVlX29wdGlvbl9zZWNvbmRzX2FyclsgaSBdLnRyaW0oKS5zcGxpdCggJzonICk7XHJcblxyXG5cdFx0XHRcdFx0XHRcdHZhciB0aW1lX2luX3NlY29uZHMgPSBwYXJzZUludCggc3RhcnRfZW5kX3RpbWVzX2FyclsgMCBdICkgKiA2MCAqIDYwICsgcGFyc2VJbnQoIHN0YXJ0X2VuZF90aW1lc19hcnJbIDEgXSApICogNjA7XHJcblxyXG5cdFx0XHRcdFx0XHRcdHRpbWVzX2FzX3NlY29uZHMucHVzaCggdGltZV9pbl9zZWNvbmRzICk7XHJcblx0XHRcdFx0XHRcdH1cclxuXHRcdFx0XHRcdH1cclxuXHJcblx0XHRcdFx0XHR0aW1lX2ZpZWxkc19vYmpfYXJyLnB1c2goIHtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J25hbWUnICAgICAgICAgICAgOiBqUXVlcnkoIHRpbWVfZmllbGQgKS5hdHRyKCAnbmFtZScgKSxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J3ZhbHVlX29wdGlvbl8yNGgnOiBqcXVlcnlfb3B0aW9uLnZhbCgpLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnanF1ZXJ5X29wdGlvbicgICA6IGpxdWVyeV9vcHRpb24sXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCd0aW1lc19hc19zZWNvbmRzJzogdGltZXNfYXNfc2Vjb25kc1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0fSApO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0cmV0dXJuIHRpbWVfZmllbGRzX29ial9hcnI7XHJcblx0XHR9XHJcblxyXG5cdFx0XHQvKipcclxuXHRcdFx0ICogRGlzYWJsZSBIVE1MIG9wdGlvbnMgYW5kIGFkZCBib29rZWQgQ1NTIGNsYXNzXHJcblx0XHRcdCAqXHJcblx0XHRcdCAqIEBwYXJhbSB0aW1lX2ZpZWxkc19vYmpfYXJyICAgICAgLSB0aGlzIHZhbHVlIGlzIGZyb20gIHRoZSBmdW5jOiAgXHR3cGJjX2dldF9fdGltZV9maWVsZHNfX2luX2Jvb2tpbmdfZm9ybV9fYXNfYXJyKCByZXNvdXJjZV9pZCApXHJcblx0XHRcdCAqIFx0XHRcdFx0XHRbXHJcblx0XHRcdCAqIFx0XHRcdFx0XHQgXHQgICB7XHRqcXVlcnlfb3B0aW9uOiAgICAgIGpRdWVyeV9PYmplY3Qge31cclxuXHRcdFx0ICogXHRcdFx0XHRcdFx0XHRcdG5hbWU6ICAgICAgICAgICAgICAgJ3JhbmdldGltZTJbXSdcclxuXHRcdFx0ICogXHRcdFx0XHRcdFx0XHRcdHRpbWVzX2FzX3NlY29uZHM6ICAgWyAyMTYwMCwgMjM0MDAgXVxyXG5cdFx0XHQgKiBcdFx0XHRcdFx0XHRcdFx0dmFsdWVfb3B0aW9uXzI0aDogICAnMDY6MDAgLSAwNjozMCdcclxuXHRcdFx0ICogXHQgIFx0XHRcdFx0XHRcdCAgICBkaXNhYmxlZCA9IDFcclxuXHRcdFx0ICogXHRcdFx0XHRcdCAgICAgfVxyXG5cdFx0XHQgKiBcdFx0XHRcdFx0ICAuLi5cclxuXHRcdFx0ICogXHRcdFx0XHRcdFx0ICAge1x0anF1ZXJ5X29wdGlvbjogICAgICBqUXVlcnlfT2JqZWN0IHt9XHJcblx0XHRcdCAqIFx0XHRcdFx0XHRcdFx0XHRuYW1lOiAgICAgICAgICAgICAgICdzdGFydHRpbWUyW10nXHJcblx0XHRcdCAqIFx0XHRcdFx0XHRcdFx0XHR0aW1lc19hc19zZWNvbmRzOiAgIFsgMjE2MDAgXVxyXG5cdFx0XHQgKiBcdFx0XHRcdFx0XHRcdFx0dmFsdWVfb3B0aW9uXzI0aDogICAnMDY6MDAnXHJcblx0XHRcdCAqICAgXHRcdFx0XHRcdFx0XHRkaXNhYmxlZCA9IDBcclxuXHRcdFx0ICogIFx0XHRcdFx0XHQgICAgfVxyXG5cdFx0XHQgKiBcdFx0XHRcdFx0IF1cclxuXHRcdFx0ICpcclxuXHRcdFx0ICovXHJcblx0XHRcdGZ1bmN0aW9uIHdwYmNfX2h0bWxfX3RpbWVfZmllbGRfb3B0aW9uc19fc2V0X2Rpc2FibGVkKCB0aW1lX2ZpZWxkc19vYmpfYXJyICl7XHJcblxyXG5cdFx0XHRcdHZhciBqcXVlcnlfb3B0aW9uO1xyXG5cclxuXHRcdFx0XHRmb3IgKCB2YXIgaSA9IDA7IGkgPCB0aW1lX2ZpZWxkc19vYmpfYXJyLmxlbmd0aDsgaSsrICl7XHJcblxyXG5cdFx0XHRcdFx0dmFyIGpxdWVyeV9vcHRpb24gPSB0aW1lX2ZpZWxkc19vYmpfYXJyWyBpIF0uanF1ZXJ5X29wdGlvbjtcclxuXHJcblx0XHRcdFx0XHRpZiAoIDEgPT0gdGltZV9maWVsZHNfb2JqX2FyclsgaSBdLmRpc2FibGVkICl7XHJcblx0XHRcdFx0XHRcdGpxdWVyeV9vcHRpb24ucHJvcCggJ2Rpc2FibGVkJywgdHJ1ZSApOyBcdFx0Ly8gTWFrZSBkaXNhYmxlIHNvbWUgb3B0aW9uc1xyXG5cdFx0XHRcdFx0XHRqcXVlcnlfb3B0aW9uLmFkZENsYXNzKCAnYm9va2VkJyApOyAgICAgICAgICAgXHQvLyBBZGQgXCJib29rZWRcIiBDU1MgY2xhc3NcclxuXHJcblx0XHRcdFx0XHRcdC8vIGlmIHRoaXMgYm9va2VkIGVsZW1lbnQgc2VsZWN0ZWQgLS0+IHRoZW4gZGVzZWxlY3QgIGl0XHJcblx0XHRcdFx0XHRcdGlmICgganF1ZXJ5X29wdGlvbi5wcm9wKCAnc2VsZWN0ZWQnICkgKXtcclxuXHRcdFx0XHRcdFx0XHRqcXVlcnlfb3B0aW9uLnByb3AoICdzZWxlY3RlZCcsIGZhbHNlICk7XHJcblxyXG5cdFx0XHRcdFx0XHRcdGpxdWVyeV9vcHRpb24ucGFyZW50KCkuZmluZCggJ29wdGlvbjpub3QoW2Rpc2FibGVkXSk6Zmlyc3QnICkucHJvcCggJ3NlbGVjdGVkJywgdHJ1ZSApLnRyaWdnZXIoIFwiY2hhbmdlXCIgKTtcclxuXHRcdFx0XHRcdFx0fVxyXG5cclxuXHRcdFx0XHRcdH0gZWxzZSB7XHJcblx0XHRcdFx0XHRcdGpxdWVyeV9vcHRpb24ucHJvcCggJ2Rpc2FibGVkJywgZmFsc2UgKTsgIFx0XHQvLyBNYWtlIGFjdGl2ZSBhbGwgdGltZXNcclxuXHRcdFx0XHRcdFx0anF1ZXJ5X29wdGlvbi5yZW1vdmVDbGFzcyggJ2Jvb2tlZCcgKTsgICBcdFx0Ly8gUmVtb3ZlIGNsYXNzIFwiYm9va2VkXCJcclxuXHRcdFx0XHRcdH1cclxuXHRcdFx0XHR9XHJcblxyXG5cdFx0XHR9XHJcblxyXG5cdC8qKlxyXG5cdCAqIENoZWNrIGlmIHRoaXMgdGltZV9yYW5nZSB8IFRpbWVfU2xvdCBpcyBGdWxsIERheSAgYm9va2VkXHJcblx0ICpcclxuXHQgKiBAcGFyYW0gdGltZXNsb3RfYXJyX2luX3NlY29uZHNcdFx0LSBbIDM2MDExLCA4NjQwMCBdXHJcblx0ICogQHJldHVybnMge2Jvb2xlYW59XHJcblx0ICovXHJcblx0ZnVuY3Rpb24gd3BiY19pc190aGlzX3RpbWVzbG90X19mdWxsX2RheV9ib29rZWQoIHRpbWVzbG90X2Fycl9pbl9zZWNvbmRzICl7XHJcblxyXG5cdFx0aWYgKFxyXG5cdFx0XHRcdCggdGltZXNsb3RfYXJyX2luX3NlY29uZHMubGVuZ3RoID4gMSApXHJcblx0XHRcdCYmICggcGFyc2VJbnQoIHRpbWVzbG90X2Fycl9pbl9zZWNvbmRzWyAwIF0gKSA8IDMwIClcclxuXHRcdFx0JiYgKCBwYXJzZUludCggdGltZXNsb3RfYXJyX2luX3NlY29uZHNbIDEgXSApID4gICggKDI0ICogNjAgKiA2MCkgLSAzMCkgKVxyXG5cdFx0KXtcclxuXHRcdFx0cmV0dXJuIHRydWU7XHJcblx0XHR9XHJcblxyXG5cdFx0cmV0dXJuIGZhbHNlO1xyXG5cdH1cclxuXHJcblxyXG5cdC8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblx0LyogID09ICBTIGUgbCBlIGMgdCBlIGQgICAgRCBhIHQgZSBzICAvICBUIGkgbSBlIC0gRiBpIGUgbCBkIHMgID09XHJcblx0Ly8gLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0gKi9cclxuXHJcblx0LyoqXHJcblx0ICogIEdldCBhbGwgc2VsZWN0ZWQgZGF0ZXMgaW4gU1FMIGZvcm1hdCBsaWtlIHRoaXMgWyBcIjIwMjMtMDgtMjNcIiwgXCIyMDIzLTA4LTI0XCIgLCAuLi4gXVxyXG5cdCAqXHJcblx0ICogQHBhcmFtIHJlc291cmNlX2lkXHJcblx0ICogQHJldHVybnMge1tdfVx0XHRcdFsgXCIyMDIzLTA4LTIzXCIsIFwiMjAyMy0wOC0yNFwiLCBcIjIwMjMtMDgtMjVcIiwgXCIyMDIzLTA4LTI2XCIsIFwiMjAyMy0wOC0yN1wiLCBcIjIwMjMtMDgtMjhcIiwgXCIyMDIzLTA4LTI5XCIgXVxyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfZ2V0X19zZWxlY3RlZF9kYXRlc19zcWxfX2FzX2FyciggcmVzb3VyY2VfaWQgKXtcclxuXHJcblx0XHR2YXIgc2VsZWN0ZWRfZGF0ZXNfYXJyID0gW107XHJcblx0XHRzZWxlY3RlZF9kYXRlc19hcnIgPSBqUXVlcnkoICcjZGF0ZV9ib29raW5nJyArIHJlc291cmNlX2lkICkudmFsKCkuc3BsaXQoJywnKTtcclxuXHJcblx0XHRpZiAoIHNlbGVjdGVkX2RhdGVzX2Fyci5sZW5ndGggKXtcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQvL0ZpeEluOiA5LjguMTAuMVxyXG5cdFx0XHRmb3IgKCBsZXQgaSA9IDA7IGkgPCBzZWxlY3RlZF9kYXRlc19hcnIubGVuZ3RoOyBpKysgKXtcdFx0XHRcdFx0XHQvL0ZpeEluOiAxMC4wLjAuNTZcclxuXHRcdFx0XHRzZWxlY3RlZF9kYXRlc19hcnJbIGkgXSA9IHNlbGVjdGVkX2RhdGVzX2FyclsgaSBdLnRyaW0oKTtcclxuXHRcdFx0XHRzZWxlY3RlZF9kYXRlc19hcnJbIGkgXSA9IHNlbGVjdGVkX2RhdGVzX2FyclsgaSBdLnNwbGl0KCAnLicgKTtcclxuXHRcdFx0XHRpZiAoIHNlbGVjdGVkX2RhdGVzX2FyclsgaSBdLmxlbmd0aCA+IDEgKXtcclxuXHRcdFx0XHRcdHNlbGVjdGVkX2RhdGVzX2FyclsgaSBdID0gc2VsZWN0ZWRfZGF0ZXNfYXJyWyBpIF1bIDIgXSArICctJyArIHNlbGVjdGVkX2RhdGVzX2FyclsgaSBdWyAxIF0gKyAnLScgKyBzZWxlY3RlZF9kYXRlc19hcnJbIGkgXVsgMCBdO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cclxuXHRcdC8vIFJlbW92ZSBlbXB0eSBlbGVtZW50cyBmcm9tIGFuIGFycmF5XHJcblx0XHRzZWxlY3RlZF9kYXRlc19hcnIgPSBzZWxlY3RlZF9kYXRlc19hcnIuZmlsdGVyKCBmdW5jdGlvbiAoIG4gKXsgcmV0dXJuIHBhcnNlSW50KG4pOyB9ICk7XHJcblxyXG5cdFx0c2VsZWN0ZWRfZGF0ZXNfYXJyLnNvcnQoKTtcclxuXHJcblx0XHRyZXR1cm4gc2VsZWN0ZWRfZGF0ZXNfYXJyO1xyXG5cdH1cclxuXHJcblxyXG5cdC8qKlxyXG5cdCAqIEdldCBhbGwgdGltZSBmaWVsZHMgaW4gdGhlIGJvb2tpbmcgZm9ybSBhcyBhcnJheSAgb2Ygb2JqZWN0c1xyXG5cdCAqXHJcblx0ICogQHBhcmFtIHJlc291cmNlX2lkXHJcblx0ICogQHBhcmFtIGlzX29ubHlfc2VsZWN0ZWRfdGltZVxyXG5cdCAqIEByZXR1cm5zIFtdXHJcblx0ICpcclxuXHQgKiBcdFx0RXhhbXBsZTpcclxuXHQgKiBcdFx0XHRcdFx0W1xyXG5cdCAqIFx0XHRcdFx0XHQgXHQgICB7XHJcblx0ICogXHRcdFx0XHRcdFx0XHRcdHZhbHVlX29wdGlvbl8yNGg6ICAgJzA2OjAwIC0gMDY6MzAnXHJcblx0ICogXHRcdFx0XHRcdFx0XHRcdHRpbWVzX2FzX3NlY29uZHM6ICAgWyAyMTYwMCwgMjM0MDAgXVxyXG5cdCAqIFx0XHRcdFx0XHQgXHQgICBcdFx0anF1ZXJ5X29wdGlvbjogICAgICBqUXVlcnlfT2JqZWN0IHt9XHJcblx0ICogXHRcdFx0XHRcdFx0XHRcdG5hbWU6ICAgICAgICAgICAgICAgJ3JhbmdldGltZTJbXSdcclxuXHQgKiBcdFx0XHRcdFx0ICAgICB9XHJcblx0ICogXHRcdFx0XHRcdCAgLi4uXHJcblx0ICogXHRcdFx0XHRcdFx0ICAge1xyXG5cdCAqIFx0XHRcdFx0XHRcdFx0XHR2YWx1ZV9vcHRpb25fMjRoOiAgICcwNjowMCdcclxuXHQgKiBcdFx0XHRcdFx0XHRcdFx0dGltZXNfYXNfc2Vjb25kczogICBbIDIxNjAwIF1cclxuXHQgKiBcdFx0XHRcdFx0XHQgICBcdFx0anF1ZXJ5X29wdGlvbjogICAgICBqUXVlcnlfT2JqZWN0IHt9XHJcblx0ICogXHRcdFx0XHRcdFx0XHRcdG5hbWU6ICAgICAgICAgICAgICAgJ3N0YXJ0dGltZTJbXSdcclxuXHQgKiAgXHRcdFx0XHRcdCAgICB9XHJcblx0ICogXHRcdFx0XHRcdCBdXHJcblx0ICovXHJcblx0ZnVuY3Rpb24gd3BiY19nZXRfX3NlbGVjdGVkX3RpbWVfZmllbGRzX19pbl9ib29raW5nX2Zvcm1fX2FzX2FyciggcmVzb3VyY2VfaWQsIGlzX29ubHlfc2VsZWN0ZWRfdGltZSA9IHRydWUgKXtcclxuXHRcdC8qKlxyXG5cdFx0ICogRmllbGRzIHdpdGggIFtdICBsaWtlIHRoaXMgICBzZWxlY3RbbmFtZT1cInJhbmdldGltZTFbXVwiXVxyXG5cdFx0ICogaXQncyB3aGVuIHdlIGhhdmUgJ211bHRpcGxlJyBpbiBzaG9ydGNvZGU6ICAgW3NlbGVjdCogcmFuZ2V0aW1lIG11bHRpcGxlICBcIjA2OjAwIC0gMDY6MzBcIiAuLi4gXVxyXG5cdFx0ICovXHJcblx0XHR2YXIgdGltZV9maWVsZHNfYXJyPVtcclxuXHRcdFx0XHRcdFx0XHRcdCdzZWxlY3RbbmFtZT1cInJhbmdldGltZScgKyByZXNvdXJjZV9pZCArICdcIl0nLFxyXG5cdFx0XHRcdFx0XHRcdFx0J3NlbGVjdFtuYW1lPVwicmFuZ2V0aW1lJyArIHJlc291cmNlX2lkICsgJ1tdXCJdJyxcclxuXHRcdFx0XHRcdFx0XHRcdCdzZWxlY3RbbmFtZT1cInN0YXJ0dGltZScgKyByZXNvdXJjZV9pZCArICdcIl0nLFxyXG5cdFx0XHRcdFx0XHRcdFx0J3NlbGVjdFtuYW1lPVwic3RhcnR0aW1lJyArIHJlc291cmNlX2lkICsgJ1tdXCJdJyxcclxuXHRcdFx0XHRcdFx0XHRcdCdzZWxlY3RbbmFtZT1cImVuZHRpbWUnICsgcmVzb3VyY2VfaWQgKyAnXCJdJyxcclxuXHRcdFx0XHRcdFx0XHRcdCdzZWxlY3RbbmFtZT1cImVuZHRpbWUnICsgcmVzb3VyY2VfaWQgKyAnW11cIl0nLFxyXG5cdFx0XHRcdFx0XHRcdFx0J3NlbGVjdFtuYW1lPVwiZHVyYXRpb250aW1lJyArIHJlc291cmNlX2lkICsgJ1wiXScsXHJcblx0XHRcdFx0XHRcdFx0XHQnc2VsZWN0W25hbWU9XCJkdXJhdGlvbnRpbWUnICsgcmVzb3VyY2VfaWQgKyAnW11cIl0nXHJcblx0XHRcdFx0XHRcdFx0XTtcclxuXHJcblx0XHR2YXIgdGltZV9maWVsZHNfb2JqX2FyciA9IFtdO1xyXG5cclxuXHRcdC8vIExvb3AgYWxsIFRpbWUgRmllbGRzXHJcblx0XHRmb3IgKCB2YXIgY3RmPSAwOyBjdGYgPCB0aW1lX2ZpZWxkc19hcnIubGVuZ3RoOyBjdGYrKyApe1xyXG5cclxuXHRcdFx0dmFyIHRpbWVfZmllbGQgPSB0aW1lX2ZpZWxkc19hcnJbIGN0ZiBdO1xyXG5cclxuXHRcdFx0dmFyIHRpbWVfb3B0aW9uO1xyXG5cdFx0XHRpZiAoIGlzX29ubHlfc2VsZWN0ZWRfdGltZSApe1xyXG5cdFx0XHRcdHRpbWVfb3B0aW9uID0galF1ZXJ5KCAnI2Jvb2tpbmdfZm9ybScgKyByZXNvdXJjZV9pZCArICcgJyArIHRpbWVfZmllbGQgKyAnIG9wdGlvbjpzZWxlY3RlZCcgKTtcdFx0XHQvLyBFeGNsdWRlIGNvbmRpdGlvbmFsICBmaWVsZHMsICBiZWNhdXNlIG9mIHVzaW5nICcjYm9va2luZ19mb3JtMyAuLi4nXHJcblx0XHRcdH0gZWxzZSB7XHJcblx0XHRcdFx0dGltZV9vcHRpb24gPSBqUXVlcnkoICcjYm9va2luZ19mb3JtJyArIHJlc291cmNlX2lkICsgJyAnICsgdGltZV9maWVsZCArICcgb3B0aW9uJyApO1x0XHRcdFx0Ly8gQWxsICB0aW1lIGZpZWxkc1xyXG5cdFx0XHR9XHJcblxyXG5cclxuXHRcdFx0Ly8gTG9vcCBhbGwgb3B0aW9ucyBpbiB0aW1lIGZpZWxkXHJcblx0XHRcdGZvciAoIHZhciBqID0gMDsgaiA8IHRpbWVfb3B0aW9uLmxlbmd0aDsgaisrICl7XHJcblxyXG5cdFx0XHRcdHZhciBqcXVlcnlfb3B0aW9uID0galF1ZXJ5KCB0aW1lX29wdGlvblsgaiBdICk7XHRcdC8vIEdldCBvbmx5ICBzZWxlY3RlZCBvcHRpb25zIFx0Ly9qUXVlcnkoIHRpbWVfZmllbGQgKyAnIG9wdGlvbjplcSgnICsgaiArICcpJyApO1xyXG5cdFx0XHRcdHZhciB2YWx1ZV9vcHRpb25fc2Vjb25kc19hcnIgPSBqcXVlcnlfb3B0aW9uLnZhbCgpLnNwbGl0KCAnLScgKTtcclxuXHRcdFx0XHR2YXIgdGltZXNfYXNfc2Vjb25kcyA9IFtdO1xyXG5cclxuXHRcdFx0XHQvLyBHZXQgdGltZSBhcyBzZWNvbmRzXHJcblx0XHRcdFx0aWYgKCB2YWx1ZV9vcHRpb25fc2Vjb25kc19hcnIubGVuZ3RoICl7XHRcdFx0XHQgXHRcdFx0XHRcdFx0XHRcdC8vRml4SW46IDkuOC4xMC4xXHJcblx0XHRcdFx0XHRmb3IgKCBsZXQgaSA9IDA7IGkgPCB2YWx1ZV9vcHRpb25fc2Vjb25kc19hcnIubGVuZ3RoOyBpKysgKXtcdFx0XHRcdFx0Ly9GaXhJbjogMTAuMC4wLjU2XHJcblx0XHRcdFx0XHRcdC8vIHZhbHVlX29wdGlvbl9zZWNvbmRzX2FycltpXSA9ICcxNDowMCAnICB8ICcgMTY6MDAnICAgKGlmIGZyb20gJ3JhbmdldGltZScpIGFuZCAnMTY6MDAnICBpZiAoc3RhcnQvZW5kIHRpbWUpXHJcblxyXG5cdFx0XHRcdFx0XHR2YXIgc3RhcnRfZW5kX3RpbWVzX2FyciA9IHZhbHVlX29wdGlvbl9zZWNvbmRzX2FyclsgaSBdLnRyaW0oKS5zcGxpdCggJzonICk7XHJcblxyXG5cdFx0XHRcdFx0XHR2YXIgdGltZV9pbl9zZWNvbmRzID0gcGFyc2VJbnQoIHN0YXJ0X2VuZF90aW1lc19hcnJbIDAgXSApICogNjAgKiA2MCArIHBhcnNlSW50KCBzdGFydF9lbmRfdGltZXNfYXJyWyAxIF0gKSAqIDYwO1xyXG5cclxuXHRcdFx0XHRcdFx0dGltZXNfYXNfc2Vjb25kcy5wdXNoKCB0aW1lX2luX3NlY29uZHMgKTtcclxuXHRcdFx0XHRcdH1cclxuXHRcdFx0XHR9XHJcblxyXG5cdFx0XHRcdHRpbWVfZmllbGRzX29ial9hcnIucHVzaCgge1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0J25hbWUnICAgICAgICAgICAgOiBqUXVlcnkoICcjYm9va2luZ19mb3JtJyArIHJlc291cmNlX2lkICsgJyAnICsgdGltZV9maWVsZCApLmF0dHIoICduYW1lJyApLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0J3ZhbHVlX29wdGlvbl8yNGgnOiBqcXVlcnlfb3B0aW9uLnZhbCgpLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0J2pxdWVyeV9vcHRpb24nICAgOiBqcXVlcnlfb3B0aW9uLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0J3RpbWVzX2FzX3NlY29uZHMnOiB0aW1lc19hc19zZWNvbmRzXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0fSApO1xyXG5cdFx0XHR9XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gVGV4dDogICBbc3RhcnR0aW1lXSAtIFtlbmR0aW1lXSAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cclxuXHRcdHZhciB0ZXh0X3RpbWVfZmllbGRzX2Fycj1bXHJcblx0XHRcdFx0XHRcdFx0XHRcdCdpbnB1dFtuYW1lPVwic3RhcnR0aW1lJyArIHJlc291cmNlX2lkICsgJ1wiXScsXHJcblx0XHRcdFx0XHRcdFx0XHRcdCdpbnB1dFtuYW1lPVwiZW5kdGltZScgKyByZXNvdXJjZV9pZCArICdcIl0nLFxyXG5cdFx0XHRcdFx0XHRcdFx0XTtcclxuXHRcdGZvciAoIHZhciB0Zj0gMDsgdGYgPCB0ZXh0X3RpbWVfZmllbGRzX2Fyci5sZW5ndGg7IHRmKysgKXtcclxuXHJcblx0XHRcdHZhciB0ZXh0X2pxdWVyeSA9IGpRdWVyeSggJyNib29raW5nX2Zvcm0nICsgcmVzb3VyY2VfaWQgKyAnICcgKyB0ZXh0X3RpbWVfZmllbGRzX2FyclsgdGYgXSApO1x0XHRcdFx0XHRcdFx0XHQvLyBFeGNsdWRlIGNvbmRpdGlvbmFsICBmaWVsZHMsICBiZWNhdXNlIG9mIHVzaW5nICcjYm9va2luZ19mb3JtMyAuLi4nXHJcblx0XHRcdGlmICggdGV4dF9qcXVlcnkubGVuZ3RoID4gMCApe1xyXG5cclxuXHRcdFx0XHR2YXIgdGltZV9faF9tX19hcnIgPSB0ZXh0X2pxdWVyeS52YWwoKS50cmltKCkuc3BsaXQoICc6JyApO1x0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQvLyAnMTQ6MDAnXHJcblx0XHRcdFx0aWYgKCAwID09IHRpbWVfX2hfbV9fYXJyLmxlbmd0aCApe1xyXG5cdFx0XHRcdFx0Y29udGludWU7XHRcdFx0XHRcdFx0XHRcdFx0Ly8gTm90IGVudGVyZWQgdGltZSB2YWx1ZSBpbiBhIGZpZWxkXHJcblx0XHRcdFx0fVxyXG5cdFx0XHRcdGlmICggMSA9PSB0aW1lX19oX21fX2Fyci5sZW5ndGggKXtcclxuXHRcdFx0XHRcdGlmICggJycgPT09IHRpbWVfX2hfbV9fYXJyWyAwIF0gKXtcclxuXHRcdFx0XHRcdFx0Y29udGludWU7XHRcdFx0XHRcdFx0XHRcdC8vIE5vdCBlbnRlcmVkIHRpbWUgdmFsdWUgaW4gYSBmaWVsZFxyXG5cdFx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0dGltZV9faF9tX19hcnJbIDEgXSA9IDA7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHRcdHZhciB0ZXh0X3RpbWVfaW5fc2Vjb25kcyA9IHBhcnNlSW50KCB0aW1lX19oX21fX2FyclsgMCBdICkgKiA2MCAqIDYwICsgcGFyc2VJbnQoIHRpbWVfX2hfbV9fYXJyWyAxIF0gKSAqIDYwO1xyXG5cclxuXHRcdFx0XHR2YXIgdGV4dF90aW1lc19hc19zZWNvbmRzID0gW107XHJcblx0XHRcdFx0dGV4dF90aW1lc19hc19zZWNvbmRzLnB1c2goIHRleHRfdGltZV9pbl9zZWNvbmRzICk7XHJcblxyXG5cdFx0XHRcdHRpbWVfZmllbGRzX29ial9hcnIucHVzaCgge1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0J25hbWUnICAgICAgICAgICAgOiB0ZXh0X2pxdWVyeS5hdHRyKCAnbmFtZScgKSxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdCd2YWx1ZV9vcHRpb25fMjRoJzogdGV4dF9qcXVlcnkudmFsKCksXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnanF1ZXJ5X29wdGlvbicgICA6IHRleHRfanF1ZXJ5LFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0J3RpbWVzX2FzX3NlY29uZHMnOiB0ZXh0X3RpbWVzX2FzX3NlY29uZHNcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHR9ICk7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHJcblx0XHRyZXR1cm4gdGltZV9maWVsZHNfb2JqX2FycjtcclxuXHR9XHJcblxyXG5cclxuXHJcbi8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG4vKiAgPT0gIFMgVSBQIFAgTyBSIFQgICAgZm9yICAgIEMgQSBMIEUgTiBEIEEgUiAgPT1cclxuLy8gLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tICovXHJcblxyXG5cdC8qKlxyXG5cdCAqIEdldCBDYWxlbmRhciBkYXRlcGljayAgSW5zdGFuY2VcclxuXHQgKiBAcGFyYW0gcmVzb3VyY2VfaWQgIG9mIGJvb2tpbmcgcmVzb3VyY2VcclxuXHQgKiBAcmV0dXJucyB7KnxudWxsfVxyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfY2FsZW5kYXJfX2dldF9pbnN0KCByZXNvdXJjZV9pZCApe1xyXG5cclxuXHRcdGlmICggJ3VuZGVmaW5lZCcgPT09IHR5cGVvZiAocmVzb3VyY2VfaWQpICl7XHJcblx0XHRcdHJlc291cmNlX2lkID0gJzEnO1xyXG5cdFx0fVxyXG5cclxuXHRcdGlmICggalF1ZXJ5KCAnI2NhbGVuZGFyX2Jvb2tpbmcnICsgcmVzb3VyY2VfaWQgKS5sZW5ndGggPiAwICl7XHJcblx0XHRcdHJldHVybiBqUXVlcnkuZGF0ZXBpY2suX2dldEluc3QoIGpRdWVyeSggJyNjYWxlbmRhcl9ib29raW5nJyArIHJlc291cmNlX2lkICkuZ2V0KCAwICkgKTtcclxuXHRcdH1cclxuXHJcblx0XHRyZXR1cm4gbnVsbDtcclxuXHR9XHJcblxyXG5cdC8qKlxyXG5cdCAqIFVuc2VsZWN0ICBhbGwgZGF0ZXMgaW4gY2FsZW5kYXIgYW5kIHZpc3VhbGx5IHVwZGF0ZSB0aGlzIGNhbGVuZGFyXHJcblx0ICpcclxuXHQgKiBAcGFyYW0gcmVzb3VyY2VfaWRcdFx0SUQgb2YgYm9va2luZyByZXNvdXJjZVxyXG5cdCAqIEByZXR1cm5zIHtib29sZWFufVx0XHR0cnVlIG9uIHN1Y2Nlc3MgfCBmYWxzZSwgIGlmIG5vIHN1Y2ggIGNhbGVuZGFyXHJcblx0ICovXHJcblx0ZnVuY3Rpb24gd3BiY19jYWxlbmRhcl9fdW5zZWxlY3RfYWxsX2RhdGVzKCByZXNvdXJjZV9pZCApe1xyXG5cclxuXHRcdGlmICggJ3VuZGVmaW5lZCcgPT09IHR5cGVvZiAocmVzb3VyY2VfaWQpICl7XHJcblx0XHRcdHJlc291cmNlX2lkID0gJzEnO1xyXG5cdFx0fVxyXG5cclxuXHRcdHZhciBpbnN0ID0gd3BiY19jYWxlbmRhcl9fZ2V0X2luc3QoIHJlc291cmNlX2lkIClcclxuXHJcblx0XHRpZiAoIG51bGwgIT09IGluc3QgKXtcclxuXHJcblx0XHRcdC8vIFVuc2VsZWN0IGFsbCBkYXRlcyBhbmQgc2V0ICBwcm9wZXJ0aWVzIG9mIERhdGVwaWNrXHJcblx0XHRcdGpRdWVyeSggJyNkYXRlX2Jvb2tpbmcnICsgcmVzb3VyY2VfaWQgKS52YWwoICcnICk7ICAgICAgLy9GaXhJbjogNS40LjNcclxuXHRcdFx0aW5zdC5zdGF5T3BlbiA9IGZhbHNlO1xyXG5cdFx0XHRpbnN0LmRhdGVzID0gW107XHJcblx0XHRcdGpRdWVyeS5kYXRlcGljay5fdXBkYXRlRGF0ZXBpY2soIGluc3QgKTtcclxuXHJcblx0XHRcdHJldHVybiB0cnVlXHJcblx0XHR9XHJcblxyXG5cdFx0cmV0dXJuIGZhbHNlO1xyXG5cclxuXHR9XHJcblxyXG5cdC8qKlxyXG5cdCAqIENsZWFyIGRheXMgaGlnaGxpZ2h0aW5nIGluIEFsbCBvciBzcGVjaWZpYyBDYWxlbmRhcnNcclxuXHQgKlxyXG4gICAgICogQHBhcmFtIHJlc291cmNlX2lkICAtIGNhbiBiZSBza2lwZWQgdG8gIGNsZWFyIGhpZ2hsaWdodGluZyBpbiBhbGwgY2FsZW5kYXJzXHJcbiAgICAgKi9cclxuXHRmdW5jdGlvbiB3cGJjX2NhbGVuZGFyc19fY2xlYXJfZGF5c19oaWdobGlnaHRpbmcoIHJlc291cmNlX2lkICl7XHJcblxyXG5cdFx0aWYgKCAndW5kZWZpbmVkJyAhPT0gdHlwZW9mICggcmVzb3VyY2VfaWQgKSApe1xyXG5cclxuXHRcdFx0alF1ZXJ5KCAnI2NhbGVuZGFyX2Jvb2tpbmcnICsgcmVzb3VyY2VfaWQgKyAnIC5kYXRlcGljay1kYXlzLWNlbGwtb3ZlcicgKS5yZW1vdmVDbGFzcyggJ2RhdGVwaWNrLWRheXMtY2VsbC1vdmVyJyApO1x0XHQvLyBDbGVhciBpbiBzcGVjaWZpYyBjYWxlbmRhclxyXG5cclxuXHRcdH0gZWxzZSB7XHJcblx0XHRcdGpRdWVyeSggJy5kYXRlcGljay1kYXlzLWNlbGwtb3ZlcicgKS5yZW1vdmVDbGFzcyggJ2RhdGVwaWNrLWRheXMtY2VsbC1vdmVyJyApO1x0XHRcdFx0XHRcdFx0XHQvLyBDbGVhciBpbiBhbGwgY2FsZW5kYXJzXHJcblx0XHR9XHJcblx0fVxyXG5cclxuXHQvKipcclxuXHQgKiBTY3JvbGwgdG8gc3BlY2lmaWMgbW9udGggaW4gY2FsZW5kYXJcclxuXHQgKlxyXG5cdCAqIEBwYXJhbSByZXNvdXJjZV9pZFx0XHRJRCBvZiByZXNvdXJjZVxyXG5cdCAqIEBwYXJhbSB5ZWFyXHRcdFx0XHQtIHJlYWwgeWVhciAgLSAyMDIzXHJcblx0ICogQHBhcmFtIG1vbnRoXHRcdFx0XHQtIHJlYWwgbW9udGggLSAxMlxyXG5cdCAqIEByZXR1cm5zIHtib29sZWFufVxyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfY2FsZW5kYXJfX3Njcm9sbF90byggcmVzb3VyY2VfaWQsIHllYXIsIG1vbnRoICl7XHJcblxyXG5cdFx0aWYgKCAndW5kZWZpbmVkJyA9PT0gdHlwZW9mIChyZXNvdXJjZV9pZCkgKXsgcmVzb3VyY2VfaWQgPSAnMSc7IH1cclxuXHRcdHZhciBpbnN0ID0gd3BiY19jYWxlbmRhcl9fZ2V0X2luc3QoIHJlc291cmNlX2lkIClcclxuXHRcdGlmICggbnVsbCAhPT0gaW5zdCApe1xyXG5cclxuXHRcdFx0eWVhciAgPSBwYXJzZUludCggeWVhciApO1xyXG5cdFx0XHRtb250aCA9IHBhcnNlSW50KCBtb250aCApIC0gMTtcdFx0Ly8gSW4gSlMgZGF0ZSwgIG1vbnRoIC0xXHJcblxyXG5cdFx0XHRpbnN0LmN1cnNvckRhdGUgPSBuZXcgRGF0ZSgpO1xyXG5cdFx0XHQvLyBJbiBzb21lIGNhc2VzLCAgdGhlIHNldEZ1bGxZZWFyIGNhbiAgc2V0ICBvbmx5IFllYXIsICBhbmQgbm90IHRoZSBNb250aCBhbmQgZGF5ICAgICAgLy9GaXhJbjo2LjIuMy41XHJcblx0XHRcdGluc3QuY3Vyc29yRGF0ZS5zZXRGdWxsWWVhciggeWVhciwgbW9udGgsIDEgKTtcclxuXHRcdFx0aW5zdC5jdXJzb3JEYXRlLnNldE1vbnRoKCBtb250aCApO1xyXG5cdFx0XHRpbnN0LmN1cnNvckRhdGUuc2V0RGF0ZSggMSApO1xyXG5cclxuXHRcdFx0aW5zdC5kcmF3TW9udGggPSBpbnN0LmN1cnNvckRhdGUuZ2V0TW9udGgoKTtcclxuXHRcdFx0aW5zdC5kcmF3WWVhciA9IGluc3QuY3Vyc29yRGF0ZS5nZXRGdWxsWWVhcigpO1xyXG5cclxuXHRcdFx0alF1ZXJ5LmRhdGVwaWNrLl9ub3RpZnlDaGFuZ2UoIGluc3QgKTtcclxuXHRcdFx0alF1ZXJ5LmRhdGVwaWNrLl9hZGp1c3RJbnN0RGF0ZSggaW5zdCApO1xyXG5cdFx0XHRqUXVlcnkuZGF0ZXBpY2suX3Nob3dEYXRlKCBpbnN0ICk7XHJcblx0XHRcdGpRdWVyeS5kYXRlcGljay5fdXBkYXRlRGF0ZXBpY2soIGluc3QgKTtcclxuXHJcblx0XHRcdHJldHVybiB0cnVlO1xyXG5cdFx0fVxyXG5cdFx0cmV0dXJuIGZhbHNlO1xyXG5cdH1cclxuXHJcblx0LyoqXHJcblx0ICogSXMgdGhpcyBkYXRlIHNlbGVjdGFibGUgaW4gY2FsZW5kYXIgKG1haW5seSBpdCdzIG1lYW5zIEFWQUlMQUJMRSBkYXRlKVxyXG5cdCAqXHJcblx0ICogQHBhcmFtIHtpbnR8c3RyaW5nfSByZXNvdXJjZV9pZFx0XHQxXHJcblx0ICogQHBhcmFtIHtzdHJpbmd9IHNxbF9jbGFzc19kYXlcdFx0JzIwMjMtMDgtMTEnXHJcblx0ICogQHJldHVybnMge2Jvb2xlYW59XHRcdFx0XHRcdHRydWUgfCBmYWxzZVxyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfaXNfdGhpc19kYXlfc2VsZWN0YWJsZSggcmVzb3VyY2VfaWQsIHNxbF9jbGFzc19kYXkgKXtcclxuXHJcblx0XHQvLyBHZXQgRGF0YSAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cdFx0dmFyIGRhdGVfYm9va2luZ3Nfb2JqID0gX3dwYmMuYm9va2luZ3NfaW5fY2FsZW5kYXJfX2dldF9mb3JfZGF0ZSggcmVzb3VyY2VfaWQsIHNxbF9jbGFzc19kYXkgKTtcclxuXHJcblx0XHR2YXIgaXNfZGF5X3NlbGVjdGFibGUgPSAoIHBhcnNlSW50KCBkYXRlX2Jvb2tpbmdzX29ialsgJ2RheV9hdmFpbGFiaWxpdHknIF0gKSA+IDAgKTtcclxuXHJcblx0XHRpZiAoIHR5cGVvZiAoZGF0ZV9ib29raW5nc19vYmpbICdzdW1tYXJ5JyBdKSA9PT0gJ3VuZGVmaW5lZCcgKXtcclxuXHRcdFx0cmV0dXJuIGlzX2RheV9zZWxlY3RhYmxlO1xyXG5cdFx0fVxyXG5cclxuXHRcdGlmICggJ2F2YWlsYWJsZScgIT0gZGF0ZV9ib29raW5nc19vYmpbICdzdW1tYXJ5J11bJ3N0YXR1c19mb3JfZGF5JyBdICl7XHJcblxyXG5cdFx0XHR2YXIgaXNfc2V0X3BlbmRpbmdfZGF5c19zZWxlY3RhYmxlID0gX3dwYmMuY2FsZW5kYXJfX2dldF9wYXJhbV92YWx1ZSggcmVzb3VyY2VfaWQsICdwZW5kaW5nX2RheXNfc2VsZWN0YWJsZScgKTtcdFx0Ly8gc2V0IHBlbmRpbmcgZGF5cyBzZWxlY3RhYmxlICAgICAgICAgIC8vRml4SW46IDguNi4xLjE4XHJcblxyXG5cdFx0XHRzd2l0Y2ggKCBkYXRlX2Jvb2tpbmdzX29ialsgJ3N1bW1hcnknXVsnc3RhdHVzX2Zvcl9ib29raW5ncycgXSApe1xyXG5cdFx0XHRcdGNhc2UgJ3BlbmRpbmcnOlxyXG5cdFx0XHRcdC8vIFNpdHVhdGlvbnMgZm9yIFwiY2hhbmdlLW92ZXJcIiBkYXlzOlxyXG5cdFx0XHRcdGNhc2UgJ3BlbmRpbmdfcGVuZGluZyc6XHJcblx0XHRcdFx0Y2FzZSAncGVuZGluZ19hcHByb3ZlZCc6XHJcblx0XHRcdFx0Y2FzZSAnYXBwcm92ZWRfcGVuZGluZyc6XHJcblx0XHRcdFx0XHRpc19kYXlfc2VsZWN0YWJsZSA9IChpc19kYXlfc2VsZWN0YWJsZSkgPyB0cnVlIDogaXNfc2V0X3BlbmRpbmdfZGF5c19zZWxlY3RhYmxlO1xyXG5cdFx0XHRcdFx0YnJlYWs7XHJcblx0XHRcdFx0ZGVmYXVsdDpcclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cclxuXHRcdHJldHVybiBpc19kYXlfc2VsZWN0YWJsZTtcclxuXHR9XHJcblxyXG5cdC8qKlxyXG5cdCAqIElzIGRhdGUgdG8gY2hlY2sgSU4gYXJyYXkgb2Ygc2VsZWN0ZWQgZGF0ZXNcclxuXHQgKlxyXG5cdCAqIEBwYXJhbSB7ZGF0ZX1qc19kYXRlX3RvX2NoZWNrXHRcdC0gSlMgRGF0ZVx0XHRcdC0gc2ltcGxlICBKYXZhU2NyaXB0IERhdGUgb2JqZWN0XHJcblx0ICogQHBhcmFtIHtbXX0ganNfZGF0ZXNfYXJyXHRcdFx0LSBbIEpTRGF0ZSwgLi4uIF0gICAtIGFycmF5ICBvZiBKUyBkYXRlc1xyXG5cdCAqIEByZXR1cm5zIHtib29sZWFufVxyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfaXNfdGhpc19kYXlfYW1vbmdfc2VsZWN0ZWRfZGF5cygganNfZGF0ZV90b19jaGVjaywganNfZGF0ZXNfYXJyICl7XHJcblxyXG5cdFx0Zm9yICggdmFyIGRhdGVfaW5kZXggPSAwOyBkYXRlX2luZGV4IDwganNfZGF0ZXNfYXJyLmxlbmd0aCA7IGRhdGVfaW5kZXgrKyApeyAgICAgXHRcdFx0XHRcdFx0XHRcdFx0Ly9GaXhJbjogOC40LjUuMTZcclxuXHRcdFx0aWYgKCAoIGpzX2RhdGVzX2FyclsgZGF0ZV9pbmRleCBdLmdldEZ1bGxZZWFyKCkgPT09IGpzX2RhdGVfdG9fY2hlY2suZ2V0RnVsbFllYXIoKSApICYmXHJcblx0XHRcdFx0ICgganNfZGF0ZXNfYXJyWyBkYXRlX2luZGV4IF0uZ2V0TW9udGgoKSA9PT0ganNfZGF0ZV90b19jaGVjay5nZXRNb250aCgpICkgJiZcclxuXHRcdFx0XHQgKCBqc19kYXRlc19hcnJbIGRhdGVfaW5kZXggXS5nZXREYXRlKCkgPT09IGpzX2RhdGVfdG9fY2hlY2suZ2V0RGF0ZSgpICkgKSB7XHJcblx0XHRcdFx0XHRyZXR1cm4gdHJ1ZTtcclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cclxuXHRcdHJldHVybiAgZmFsc2U7XHJcblx0fVxyXG5cclxuXHQvKipcclxuXHQgKiBHZXQgU1FMIENsYXNzIERhdGUgJzIwMjMtMDgtMDEnIGZyb20gIEpTIERhdGVcclxuXHQgKlxyXG5cdCAqIEBwYXJhbSBkYXRlXHRcdFx0XHRKUyBEYXRlXHJcblx0ICogQHJldHVybnMge3N0cmluZ31cdFx0JzIwMjMtMDgtMTInXHJcblx0ICovXHJcblx0ZnVuY3Rpb24gd3BiY19fZ2V0X19zcWxfY2xhc3NfZGF0ZSggZGF0ZSApe1xyXG5cclxuXHRcdHZhciBzcWxfY2xhc3NfZGF5ID0gZGF0ZS5nZXRGdWxsWWVhcigpICsgJy0nO1xyXG5cdFx0XHRzcWxfY2xhc3NfZGF5ICs9ICggKCBkYXRlLmdldE1vbnRoKCkgKyAxICkgPCAxMCApID8gJzAnIDogJyc7XHJcblx0XHRcdHNxbF9jbGFzc19kYXkgKz0gKCBkYXRlLmdldE1vbnRoKCkgKyAxICkgKyAnLSdcclxuXHRcdFx0c3FsX2NsYXNzX2RheSArPSAoIGRhdGUuZ2V0RGF0ZSgpIDwgMTAgKSA/ICcwJyA6ICcnO1xyXG5cdFx0XHRzcWxfY2xhc3NfZGF5ICs9IGRhdGUuZ2V0RGF0ZSgpO1xyXG5cclxuXHRcdFx0cmV0dXJuIHNxbF9jbGFzc19kYXk7XHJcblx0fVxyXG5cclxuXHQvKipcclxuXHQgKiBHZXQgSlMgRGF0ZSBmcm9tICB0aGUgU1FMIGRhdGUgZm9ybWF0ICcyMDI0LTA1LTE0J1xyXG5cdCAqIEBwYXJhbSBzcWxfY2xhc3NfZGF0ZVxyXG5cdCAqIEByZXR1cm5zIHtEYXRlfVxyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfX2dldF9fanNfZGF0ZSggc3FsX2NsYXNzX2RhdGUgKXtcclxuXHJcblx0XHR2YXIgc3FsX2NsYXNzX2RhdGVfYXJyID0gc3FsX2NsYXNzX2RhdGUuc3BsaXQoICctJyApO1xyXG5cclxuXHRcdHZhciBkYXRlX2pzID0gbmV3IERhdGUoKTtcclxuXHJcblx0XHRkYXRlX2pzLnNldEZ1bGxZZWFyKCBwYXJzZUludCggc3FsX2NsYXNzX2RhdGVfYXJyWyAwIF0gKSwgKHBhcnNlSW50KCBzcWxfY2xhc3NfZGF0ZV9hcnJbIDEgXSApIC0gMSksIHBhcnNlSW50KCBzcWxfY2xhc3NfZGF0ZV9hcnJbIDIgXSApICk7ICAvLyB5ZWFyLCBtb250aCwgZGF0ZVxyXG5cclxuXHRcdC8vIFdpdGhvdXQgdGhpcyB0aW1lIGFkanVzdCBEYXRlcyBzZWxlY3Rpb24gIGluIERhdGVwaWNrZXIgY2FuIG5vdCB3b3JrISEhXHJcblx0XHRkYXRlX2pzLnNldEhvdXJzKDApO1xyXG5cdFx0ZGF0ZV9qcy5zZXRNaW51dGVzKDApO1xyXG5cdFx0ZGF0ZV9qcy5zZXRTZWNvbmRzKDApO1xyXG5cdFx0ZGF0ZV9qcy5zZXRNaWxsaXNlY29uZHMoMCk7XHJcblxyXG5cdFx0cmV0dXJuIGRhdGVfanM7XHJcblx0fVxyXG5cclxuXHQvKipcclxuXHQgKiBHZXQgVEQgQ2xhc3MgRGF0ZSAnMS0zMS0yMDIzJyBmcm9tICBKUyBEYXRlXHJcblx0ICpcclxuXHQgKiBAcGFyYW0gZGF0ZVx0XHRcdFx0SlMgRGF0ZVxyXG5cdCAqIEByZXR1cm5zIHtzdHJpbmd9XHRcdCcxLTMxLTIwMjMnXHJcblx0ICovXHJcblx0ZnVuY3Rpb24gd3BiY19fZ2V0X190ZF9jbGFzc19kYXRlKCBkYXRlICl7XHJcblxyXG5cdFx0dmFyIHRkX2NsYXNzX2RheSA9IChkYXRlLmdldE1vbnRoKCkgKyAxKSArICctJyArIGRhdGUuZ2V0RGF0ZSgpICsgJy0nICsgZGF0ZS5nZXRGdWxsWWVhcigpO1x0XHRcdFx0XHRcdFx0XHQvLyAnMS05LTIwMjMnXHJcblxyXG5cdFx0cmV0dXJuIHRkX2NsYXNzX2RheTtcclxuXHR9XHJcblxyXG5cdC8qKlxyXG5cdCAqIEdldCBkYXRlIHBhcmFtcyBmcm9tICBzdHJpbmcgZGF0ZVxyXG5cdCAqXHJcblx0ICogQHBhcmFtIGRhdGVcdFx0XHRzdHJpbmcgZGF0ZSBsaWtlICczMS41LjIwMjMnXHJcblx0ICogQHBhcmFtIHNlcGFyYXRvclx0XHRkZWZhdWx0ICcuJyAgY2FuIGJlIHNraXBwZWQuXHJcblx0ICogQHJldHVybnMgeyAge2RhdGU6IG51bWJlciwgbW9udGg6IG51bWJlciwgeWVhcjogbnVtYmVyfSAgfVxyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfX2dldF9fZGF0ZV9wYXJhbXNfX2Zyb21fc3RyaW5nX2RhdGUoIGRhdGUgLCBzZXBhcmF0b3Ipe1xyXG5cclxuXHRcdHNlcGFyYXRvciA9ICggJ3VuZGVmaW5lZCcgIT09IHR5cGVvZiAoc2VwYXJhdG9yKSApID8gc2VwYXJhdG9yIDogJy4nO1xyXG5cclxuXHRcdHZhciBkYXRlX2FyciA9IGRhdGUuc3BsaXQoIHNlcGFyYXRvciApO1xyXG5cdFx0dmFyIGRhdGVfb2JqID0ge1xyXG5cdFx0XHQneWVhcicgOiAgcGFyc2VJbnQoIGRhdGVfYXJyWyAyIF0gKSxcclxuXHRcdFx0J21vbnRoJzogKHBhcnNlSW50KCBkYXRlX2FyclsgMSBdICkgLSAxKSxcclxuXHRcdFx0J2RhdGUnIDogIHBhcnNlSW50KCBkYXRlX2FyclsgMCBdIClcclxuXHRcdH07XHJcblx0XHRyZXR1cm4gZGF0ZV9vYmo7XHRcdC8vIGZvciBcdFx0ID0gbmV3IERhdGUoIGRhdGVfb2JqLnllYXIgLCBkYXRlX29iai5tb250aCAsIGRhdGVfb2JqLmRhdGUgKTtcclxuXHR9XHJcblxyXG5cdC8qKlxyXG5cdCAqIEFkZCBTcGluIExvYWRlciB0byAgY2FsZW5kYXJcclxuXHQgKiBAcGFyYW0gcmVzb3VyY2VfaWRcclxuXHQgKi9cclxuXHRmdW5jdGlvbiB3cGJjX2NhbGVuZGFyX19sb2FkaW5nX19zdGFydCggcmVzb3VyY2VfaWQgKXtcclxuXHRcdGlmICggISBqUXVlcnkoICcjY2FsZW5kYXJfYm9va2luZycgKyByZXNvdXJjZV9pZCApLm5leHQoKS5oYXNDbGFzcyggJ3dwYmNfc3BpbnNfbG9hZGVyX3dyYXBwZXInICkgKXtcclxuXHRcdFx0alF1ZXJ5KCAnI2NhbGVuZGFyX2Jvb2tpbmcnICsgcmVzb3VyY2VfaWQgKS5hZnRlciggJzxkaXYgY2xhc3M9XCJ3cGJjX3NwaW5zX2xvYWRlcl93cmFwcGVyXCI+PGRpdiBjbGFzcz1cIndwYmNfc3BpbnNfbG9hZGVyXCI+PC9kaXY+PC9kaXY+JyApO1xyXG5cdFx0fVxyXG5cdFx0aWYgKCAhIGpRdWVyeSggJyNjYWxlbmRhcl9ib29raW5nJyArIHJlc291cmNlX2lkICkuaGFzQ2xhc3MoICd3cGJjX2NhbGVuZGFyX2JsdXJfc21hbGwnICkgKXtcclxuXHRcdFx0alF1ZXJ5KCAnI2NhbGVuZGFyX2Jvb2tpbmcnICsgcmVzb3VyY2VfaWQgKS5hZGRDbGFzcyggJ3dwYmNfY2FsZW5kYXJfYmx1cl9zbWFsbCcgKTtcclxuXHRcdH1cclxuXHRcdHdwYmNfY2FsZW5kYXJfX2JsdXJfX3N0YXJ0KCByZXNvdXJjZV9pZCApO1xyXG5cdH1cclxuXHJcblx0LyoqXHJcblx0ICogUmVtb3ZlIFNwaW4gTG9hZGVyIHRvICBjYWxlbmRhclxyXG5cdCAqIEBwYXJhbSByZXNvdXJjZV9pZFxyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfY2FsZW5kYXJfX2xvYWRpbmdfX3N0b3AoIHJlc291cmNlX2lkICl7XHJcblx0XHRqUXVlcnkoICcjY2FsZW5kYXJfYm9va2luZycgKyByZXNvdXJjZV9pZCArICcgKyAud3BiY19zcGluc19sb2FkZXJfd3JhcHBlcicgKS5yZW1vdmUoKTtcclxuXHRcdGpRdWVyeSggJyNjYWxlbmRhcl9ib29raW5nJyArIHJlc291cmNlX2lkICkucmVtb3ZlQ2xhc3MoICd3cGJjX2NhbGVuZGFyX2JsdXJfc21hbGwnICk7XHJcblx0XHR3cGJjX2NhbGVuZGFyX19ibHVyX19zdG9wKCByZXNvdXJjZV9pZCApO1xyXG5cdH1cclxuXHJcblx0LyoqXHJcblx0ICogQWRkIEJsdXIgdG8gIGNhbGVuZGFyXHJcblx0ICogQHBhcmFtIHJlc291cmNlX2lkXHJcblx0ICovXHJcblx0ZnVuY3Rpb24gd3BiY19jYWxlbmRhcl9fYmx1cl9fc3RhcnQoIHJlc291cmNlX2lkICl7XHJcblx0XHRpZiAoICEgalF1ZXJ5KCAnI2NhbGVuZGFyX2Jvb2tpbmcnICsgcmVzb3VyY2VfaWQgKS5oYXNDbGFzcyggJ3dwYmNfY2FsZW5kYXJfYmx1cicgKSApe1xyXG5cdFx0XHRqUXVlcnkoICcjY2FsZW5kYXJfYm9va2luZycgKyByZXNvdXJjZV9pZCApLmFkZENsYXNzKCAnd3BiY19jYWxlbmRhcl9ibHVyJyApO1xyXG5cdFx0fVxyXG5cdH1cclxuXHJcblx0LyoqXHJcblx0ICogUmVtb3ZlIEJsdXIgaW4gIGNhbGVuZGFyXHJcblx0ICogQHBhcmFtIHJlc291cmNlX2lkXHJcblx0ICovXHJcblx0ZnVuY3Rpb24gd3BiY19jYWxlbmRhcl9fYmx1cl9fc3RvcCggcmVzb3VyY2VfaWQgKXtcclxuXHRcdGpRdWVyeSggJyNjYWxlbmRhcl9ib29raW5nJyArIHJlc291cmNlX2lkICkucmVtb3ZlQ2xhc3MoICd3cGJjX2NhbGVuZGFyX2JsdXInICk7XHJcblx0fVxyXG5cclxuXHJcblx0Ly8gLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi5cclxuXHQvKiAgPT0gIENhbGVuZGFyIFVwZGF0ZSAgLSBWaWV3ICA9PVxyXG5cdC8vIC4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uLi4uICovXHJcblxyXG5cdC8qKlxyXG5cdCAqIFVwZGF0ZSBMb29rICBvZiBjYWxlbmRhclxyXG5cdCAqXHJcblx0ICogQHBhcmFtIHJlc291cmNlX2lkXHJcblx0ICovXHJcblx0ZnVuY3Rpb24gd3BiY19jYWxlbmRhcl9fdXBkYXRlX2xvb2soIHJlc291cmNlX2lkICl7XHJcblxyXG5cdFx0dmFyIGluc3QgPSB3cGJjX2NhbGVuZGFyX19nZXRfaW5zdCggcmVzb3VyY2VfaWQgKTtcclxuXHJcblx0XHRqUXVlcnkuZGF0ZXBpY2suX3VwZGF0ZURhdGVwaWNrKCBpbnN0ICk7XHJcblx0fVxyXG5cclxuXHJcblx0LyoqXHJcblx0ICogVXBkYXRlIGR5bmFtaWNhbGx5IE51bWJlciBvZiBNb250aHMgaW4gY2FsZW5kYXJcclxuXHQgKlxyXG5cdCAqIEBwYXJhbSByZXNvdXJjZV9pZCBpbnRcclxuXHQgKiBAcGFyYW0gbW9udGhzX251bWJlciBpbnRcclxuXHQgKi9cclxuXHRmdW5jdGlvbiB3cGJjX2NhbGVuZGFyX191cGRhdGVfbW9udGhzX251bWJlciggcmVzb3VyY2VfaWQsIG1vbnRoc19udW1iZXIgKXtcclxuXHRcdHZhciBpbnN0ID0gd3BiY19jYWxlbmRhcl9fZ2V0X2luc3QoIHJlc291cmNlX2lkICk7XHJcblx0XHRpZiAoIG51bGwgIT09IGluc3QgKXtcclxuXHRcdFx0aW5zdC5zZXR0aW5nc1sgJ251bWJlck9mTW9udGhzJyBdID0gbW9udGhzX251bWJlcjtcclxuXHRcdFx0Ly9fd3BiYy5jYWxlbmRhcl9fc2V0X3BhcmFtX3ZhbHVlKCByZXNvdXJjZV9pZCwgJ2NhbGVuZGFyX251bWJlcl9vZl9tb250aHMnLCBtb250aHNfbnVtYmVyICk7XHJcblx0XHRcdHdwYmNfY2FsZW5kYXJfX3VwZGF0ZV9sb29rKCByZXNvdXJjZV9pZCApO1xyXG5cdFx0fVxyXG5cdH1cclxuXHJcblxyXG5cdC8qKlxyXG5cdCAqIFNob3cgY2FsZW5kYXIgaW4gIGRpZmZlcmVudCBTa2luXHJcblx0ICpcclxuXHQgKiBAcGFyYW0gc2VsZWN0ZWRfc2tpbl91cmxcclxuXHQgKi9cclxuXHRmdW5jdGlvbiB3cGJjX19jYWxlbmRhcl9fY2hhbmdlX3NraW4oIHNlbGVjdGVkX3NraW5fdXJsICl7XHJcblxyXG5cdC8vY29uc29sZS5sb2coICdTS0lOIFNFTEVDVElPTiA6OicsIHNlbGVjdGVkX3NraW5fdXJsICk7XHJcblxyXG5cdFx0Ly8gUmVtb3ZlIENTUyBza2luXHJcblx0XHR2YXIgc3R5bGVzaGVldCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCAnd3BiYy1jYWxlbmRhci1za2luLWNzcycgKTtcclxuXHRcdHN0eWxlc2hlZXQucGFyZW50Tm9kZS5yZW1vdmVDaGlsZCggc3R5bGVzaGVldCApO1xyXG5cclxuXHJcblx0XHQvLyBBZGQgbmV3IENTUyBza2luXHJcblx0XHR2YXIgaGVhZElEID0gZG9jdW1lbnQuZ2V0RWxlbWVudHNCeVRhZ05hbWUoIFwiaGVhZFwiIClbIDAgXTtcclxuXHRcdHZhciBjc3NOb2RlID0gZG9jdW1lbnQuY3JlYXRlRWxlbWVudCggJ2xpbmsnICk7XHJcblx0XHRjc3NOb2RlLnR5cGUgPSAndGV4dC9jc3MnO1xyXG5cdFx0Y3NzTm9kZS5zZXRBdHRyaWJ1dGUoIFwiaWRcIiwgXCJ3cGJjLWNhbGVuZGFyLXNraW4tY3NzXCIgKTtcclxuXHRcdGNzc05vZGUucmVsID0gJ3N0eWxlc2hlZXQnO1xyXG5cdFx0Y3NzTm9kZS5tZWRpYSA9ICdzY3JlZW4nO1xyXG5cdFx0Y3NzTm9kZS5ocmVmID0gc2VsZWN0ZWRfc2tpbl91cmw7XHQvL1wiaHR0cDovL2JldGEvd3AtY29udGVudC9wbHVnaW5zL2Jvb2tpbmcvY3NzL3NraW5zL2dyZWVuLTAxLmNzc1wiO1xyXG5cdFx0aGVhZElELmFwcGVuZENoaWxkKCBjc3NOb2RlICk7XHJcblx0fVxyXG5cclxuXHJcblx0ZnVuY3Rpb24gd3BiY19fY3NzX19jaGFuZ2Vfc2tpbiggc2VsZWN0ZWRfc2tpbl91cmwsIHN0eWxlc2hlZXRfaWQgPSAnd3BiYy10aW1lX3BpY2tlci1za2luLWNzcycgKXtcclxuXHJcblx0XHQvLyBSZW1vdmUgQ1NTIHNraW5cclxuXHRcdHZhciBzdHlsZXNoZWV0ID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoIHN0eWxlc2hlZXRfaWQgKTtcclxuXHRcdHN0eWxlc2hlZXQucGFyZW50Tm9kZS5yZW1vdmVDaGlsZCggc3R5bGVzaGVldCApO1xyXG5cclxuXHJcblx0XHQvLyBBZGQgbmV3IENTUyBza2luXHJcblx0XHR2YXIgaGVhZElEID0gZG9jdW1lbnQuZ2V0RWxlbWVudHNCeVRhZ05hbWUoIFwiaGVhZFwiIClbIDAgXTtcclxuXHRcdHZhciBjc3NOb2RlID0gZG9jdW1lbnQuY3JlYXRlRWxlbWVudCggJ2xpbmsnICk7XHJcblx0XHRjc3NOb2RlLnR5cGUgPSAndGV4dC9jc3MnO1xyXG5cdFx0Y3NzTm9kZS5zZXRBdHRyaWJ1dGUoIFwiaWRcIiwgc3R5bGVzaGVldF9pZCApO1xyXG5cdFx0Y3NzTm9kZS5yZWwgPSAnc3R5bGVzaGVldCc7XHJcblx0XHRjc3NOb2RlLm1lZGlhID0gJ3NjcmVlbic7XHJcblx0XHRjc3NOb2RlLmhyZWYgPSBzZWxlY3RlZF9za2luX3VybDtcdC8vXCJodHRwOi8vYmV0YS93cC1jb250ZW50L3BsdWdpbnMvYm9va2luZy9jc3Mvc2tpbnMvZ3JlZW4tMDEuY3NzXCI7XHJcblx0XHRoZWFkSUQuYXBwZW5kQ2hpbGQoIGNzc05vZGUgKTtcclxuXHR9XHJcblxyXG5cclxuLy8gLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcbi8qICA9PSAgUyBVIFAgUCBPIFIgVCAgICBNIEEgVCBIICA9PVxyXG4vLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0gKi9cclxuXHJcblx0XHQvKipcclxuXHRcdCAqIE1lcmdlIHNldmVyYWwgIGludGVyc2VjdGVkIGludGVydmFscyBvciByZXR1cm4gbm90IGludGVyc2VjdGVkOiAgICAgICAgICAgICAgICAgICAgICAgIFtbMSwzXSxbMiw2XSxbOCwxMF0sWzE1LDE4XV0gIC0+ICAgW1sxLDZdLFs4LDEwXSxbMTUsMThdXVxyXG5cdFx0ICpcclxuXHRcdCAqIEBwYXJhbSBbXSBpbnRlcnZhbHNcdFx0XHQgWyBbMSwzXSxbMiw0XSxbNiw4XSxbOSwxMF0sWzMsN10gXVxyXG5cdFx0ICogQHJldHVybnMgW11cdFx0XHRcdFx0IFsgWzEsOF0sWzksMTBdIF1cclxuXHRcdCAqXHJcblx0XHQgKiBFeG1hbXBsZTogd3BiY19pbnRlcnZhbHNfX21lcmdlX2luZXJzZWN0ZWQoICBbIFsxLDNdLFsyLDRdLFs2LDhdLFs5LDEwXSxbMyw3XSBdICApO1xyXG5cdFx0ICovXHJcblx0XHRmdW5jdGlvbiB3cGJjX2ludGVydmFsc19fbWVyZ2VfaW5lcnNlY3RlZCggaW50ZXJ2YWxzICl7XHJcblxyXG5cdFx0XHRpZiAoICEgaW50ZXJ2YWxzIHx8IGludGVydmFscy5sZW5ndGggPT09IDAgKXtcclxuXHRcdFx0XHRyZXR1cm4gW107XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdHZhciBtZXJnZWQgPSBbXTtcclxuXHRcdFx0aW50ZXJ2YWxzLnNvcnQoIGZ1bmN0aW9uICggYSwgYiApe1xyXG5cdFx0XHRcdHJldHVybiBhWyAwIF0gLSBiWyAwIF07XHJcblx0XHRcdH0gKTtcclxuXHJcblx0XHRcdHZhciBtZXJnZWRJbnRlcnZhbCA9IGludGVydmFsc1sgMCBdO1xyXG5cclxuXHRcdFx0Zm9yICggdmFyIGkgPSAxOyBpIDwgaW50ZXJ2YWxzLmxlbmd0aDsgaSsrICl7XHJcblx0XHRcdFx0dmFyIGludGVydmFsID0gaW50ZXJ2YWxzWyBpIF07XHJcblxyXG5cdFx0XHRcdGlmICggaW50ZXJ2YWxbIDAgXSA8PSBtZXJnZWRJbnRlcnZhbFsgMSBdICl7XHJcblx0XHRcdFx0XHRtZXJnZWRJbnRlcnZhbFsgMSBdID0gTWF0aC5tYXgoIG1lcmdlZEludGVydmFsWyAxIF0sIGludGVydmFsWyAxIF0gKTtcclxuXHRcdFx0XHR9IGVsc2Uge1xyXG5cdFx0XHRcdFx0bWVyZ2VkLnB1c2goIG1lcmdlZEludGVydmFsICk7XHJcblx0XHRcdFx0XHRtZXJnZWRJbnRlcnZhbCA9IGludGVydmFsO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0bWVyZ2VkLnB1c2goIG1lcmdlZEludGVydmFsICk7XHJcblx0XHRcdHJldHVybiBtZXJnZWQ7XHJcblx0XHR9XHJcblxyXG5cclxuXHRcdC8qKlxyXG5cdFx0ICogSXMgMiBpbnRlcnZhbHMgaW50ZXJzZWN0ZWQ6ICAgICAgIFszNjAxMSwgODYzOTJdICAgIDw9PiAgICBbMSwgNDMxOTJdICA9PiAgdHJ1ZSAgICAgICggaW50ZXJzZWN0ZWQgKVxyXG5cdFx0ICpcclxuXHRcdCAqIEdvb2QgZXhwbGFuYXRpb24gIGhlcmUgaHR0cHM6Ly9zdGFja292ZXJmbG93LmNvbS9xdWVzdGlvbnMvMzI2OTQzNC93aGF0cy10aGUtbW9zdC1lZmZpY2llbnQtd2F5LXRvLXRlc3QtaWYtdHdvLXJhbmdlcy1vdmVybGFwXHJcblx0XHQgKlxyXG5cdFx0ICogQHBhcmFtICBpbnRlcnZhbF9BICAgLSBbIDM2MDExLCA4NjM5MiBdXHJcblx0XHQgKiBAcGFyYW0gIGludGVydmFsX0IgICAtIFsgICAgIDEsIDQzMTkyIF1cclxuXHRcdCAqXHJcblx0XHQgKiBAcmV0dXJuIGJvb2xcclxuXHRcdCAqL1xyXG5cdFx0ZnVuY3Rpb24gd3BiY19pbnRlcnZhbHNfX2lzX2ludGVyc2VjdGVkKCBpbnRlcnZhbF9BLCBpbnRlcnZhbF9CICkge1xyXG5cclxuXHRcdFx0aWYgKFxyXG5cdFx0XHRcdFx0KCAwID09IGludGVydmFsX0EubGVuZ3RoIClcclxuXHRcdFx0XHQgfHwgKCAwID09IGludGVydmFsX0IubGVuZ3RoIClcclxuXHRcdFx0KXtcclxuXHRcdFx0XHRyZXR1cm4gZmFsc2U7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdGludGVydmFsX0FbIDAgXSA9IHBhcnNlSW50KCBpbnRlcnZhbF9BWyAwIF0gKTtcclxuXHRcdFx0aW50ZXJ2YWxfQVsgMSBdID0gcGFyc2VJbnQoIGludGVydmFsX0FbIDEgXSApO1xyXG5cdFx0XHRpbnRlcnZhbF9CWyAwIF0gPSBwYXJzZUludCggaW50ZXJ2YWxfQlsgMCBdICk7XHJcblx0XHRcdGludGVydmFsX0JbIDEgXSA9IHBhcnNlSW50KCBpbnRlcnZhbF9CWyAxIF0gKTtcclxuXHJcblx0XHRcdHZhciBpc19pbnRlcnNlY3RlZCA9IE1hdGgubWF4KCBpbnRlcnZhbF9BWyAwIF0sIGludGVydmFsX0JbIDAgXSApIC0gTWF0aC5taW4oIGludGVydmFsX0FbIDEgXSwgaW50ZXJ2YWxfQlsgMSBdICk7XHJcblxyXG5cdFx0XHQvLyBpZiAoIDAgPT0gaXNfaW50ZXJzZWN0ZWQgKSB7XHJcblx0XHRcdC8vXHQgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAvLyBTdWNoIHJhbmdlcyBnb2luZyBvbmUgYWZ0ZXIgb3RoZXIsIGUuZy46IFsgMTIsIDE1IF0gYW5kIFsgMTUsIDIxIF1cclxuXHRcdFx0Ly8gfVxyXG5cclxuXHRcdFx0aWYgKCBpc19pbnRlcnNlY3RlZCA8IDAgKSB7XHJcblx0XHRcdFx0cmV0dXJuIHRydWU7ICAgICAgICAgICAgICAgICAgICAgLy8gSU5URVJTRUNURURcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0cmV0dXJuIGZhbHNlOyAgICAgICAgICAgICAgICAgICAgICAgLy8gTm90IGludGVyc2VjdGVkXHJcblx0XHR9XHJcblxyXG5cclxuXHRcdC8qKlxyXG5cdFx0ICogR2V0IHRoZSBjbG9zZXRzIEFCUyB2YWx1ZSBvZiBlbGVtZW50IGluIGFycmF5IHRvIHRoZSBjdXJyZW50IG15VmFsdWVcclxuXHRcdCAqXHJcblx0XHQgKiBAcGFyYW0gbXlWYWx1ZSBcdC0gaW50IGVsZW1lbnQgdG8gc2VhcmNoIGNsb3NldCBcdFx0XHQ0XHJcblx0XHQgKiBAcGFyYW0gbXlBcnJheVx0LSBhcnJheSBvZiBlbGVtZW50cyB3aGVyZSB0byBzZWFyY2ggXHRbNSw4LDEsN11cclxuXHRcdCAqIEByZXR1cm5zIGludFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdDVcclxuXHRcdCAqL1xyXG5cdFx0ZnVuY3Rpb24gd3BiY19nZXRfYWJzX2Nsb3Nlc3RfdmFsdWVfaW5fYXJyKCBteVZhbHVlLCBteUFycmF5ICl7XHJcblxyXG5cdFx0XHRpZiAoIG15QXJyYXkubGVuZ3RoID09IDAgKXsgXHRcdFx0XHRcdFx0XHRcdC8vIElmIHRoZSBhcnJheSBpcyBlbXB0eSAtPiByZXR1cm4gIHRoZSBteVZhbHVlXHJcblx0XHRcdFx0cmV0dXJuIG15VmFsdWU7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdHZhciBvYmogPSBteUFycmF5WyAwIF07XHJcblx0XHRcdHZhciBkaWZmID0gTWF0aC5hYnMoIG15VmFsdWUgLSBvYmogKTsgICAgICAgICAgICAgXHQvLyBHZXQgZGlzdGFuY2UgYmV0d2VlbiAgMXN0IGVsZW1lbnRcclxuXHRcdFx0dmFyIGNsb3NldFZhbHVlID0gbXlBcnJheVsgMCBdOyAgICAgICAgICAgICAgICAgICBcdFx0XHQvLyBTYXZlIDFzdCBlbGVtZW50XHJcblxyXG5cdFx0XHRmb3IgKCB2YXIgaSA9IDE7IGkgPCBteUFycmF5Lmxlbmd0aDsgaSsrICl7XHJcblx0XHRcdFx0b2JqID0gbXlBcnJheVsgaSBdO1xyXG5cclxuXHRcdFx0XHRpZiAoIE1hdGguYWJzKCBteVZhbHVlIC0gb2JqICkgPCBkaWZmICl7ICAgICBcdFx0XHQvLyB3ZSBmb3VuZCBjbG9zZXIgdmFsdWUgLT4gc2F2ZSBpdFxyXG5cdFx0XHRcdFx0ZGlmZiA9IE1hdGguYWJzKCBteVZhbHVlIC0gb2JqICk7XHJcblx0XHRcdFx0XHRjbG9zZXRWYWx1ZSA9IG9iajtcclxuXHRcdFx0XHR9XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdHJldHVybiBjbG9zZXRWYWx1ZTtcclxuXHRcdH1cclxuXHJcblxyXG4vLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuLyogID09ICBUIE8gTyBMIFQgSSBQIFMgID09XHJcbi8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLSAqL1xyXG5cclxuXHQvKipcclxuXHQgKiBEZWZpbmUgdG9vbHRpcCB0byBzaG93LCAgd2hlbiAgbW91c2Ugb3ZlciBEYXRlIGluIENhbGVuZGFyXHJcblx0ICpcclxuXHQgKiBAcGFyYW0gIHRvb2x0aXBfdGV4dFx0XHRcdC0gVGV4dCB0byBzaG93XHRcdFx0XHQnQm9va2VkIHRpbWU6IDEyOjAwIC0gMTM6MDA8YnI+Q29zdDogJDIwLjAwJ1xyXG5cdCAqIEBwYXJhbSAgcmVzb3VyY2VfaWRcdFx0XHQtIElEIG9mIGJvb2tpbmcgcmVzb3VyY2VcdCcxJ1xyXG5cdCAqIEBwYXJhbSAgdGRfY2xhc3NcdFx0XHRcdC0gU1FMIGNsYXNzXHRcdFx0XHRcdCcxLTktMjAyMydcclxuXHQgKiBAcmV0dXJucyB7Ym9vbGVhbn1cdFx0XHRcdFx0LSBkZWZpbmVkIHRvIHNob3cgb3Igbm90XHJcblx0ICovXHJcblx0ZnVuY3Rpb24gd3BiY19zZXRfdG9vbHRpcF9fX2Zvcl9fY2FsZW5kYXJfZGF0ZSggdG9vbHRpcF90ZXh0LCByZXNvdXJjZV9pZCwgdGRfY2xhc3MgKXtcclxuXHJcblx0XHQvL1RPRE86IG1ha2UgZXNjYXBpbmcgb2YgdGV4dCBmb3IgcXVvdCBzeW1ib2xzLCAgYW5kIEpTL0hUTUwuLi5cclxuXHJcblx0XHRqUXVlcnkoICcjY2FsZW5kYXJfYm9va2luZycgKyByZXNvdXJjZV9pZCArICcgdGQuY2FsNGRhdGUtJyArIHRkX2NsYXNzICkuYXR0ciggJ2RhdGEtY29udGVudCcsIHRvb2x0aXBfdGV4dCApO1xyXG5cclxuXHRcdHZhciB0ZF9lbCA9IGpRdWVyeSggJyNjYWxlbmRhcl9ib29raW5nJyArIHJlc291cmNlX2lkICsgJyB0ZC5jYWw0ZGF0ZS0nICsgdGRfY2xhc3MgKS5nZXQoIDAgKTtcdFx0XHRcdFx0Ly9GaXhJbjogOS4wLjEuMVxyXG5cclxuXHRcdGlmIChcclxuXHRcdFx0ICAgKCAndW5kZWZpbmVkJyAhPT0gdHlwZW9mKHRkX2VsKSApXHJcblx0XHRcdCYmICggdW5kZWZpbmVkID09IHRkX2VsLl90aXBweSApXHJcblx0XHRcdCYmICggJycgIT09IHRvb2x0aXBfdGV4dCApXHJcblx0XHQpe1xyXG5cclxuXHRcdFx0d3BiY190aXBweSggdGRfZWwgLCB7XHJcblx0XHRcdFx0XHRjb250ZW50KCByZWZlcmVuY2UgKXtcclxuXHJcblx0XHRcdFx0XHRcdHZhciBwb3BvdmVyX2NvbnRlbnQgPSByZWZlcmVuY2UuZ2V0QXR0cmlidXRlKCAnZGF0YS1jb250ZW50JyApO1xyXG5cclxuXHRcdFx0XHRcdFx0cmV0dXJuICc8ZGl2IGNsYXNzPVwicG9wb3ZlciBwb3BvdmVyX3RpcHB5XCI+J1xyXG5cdFx0XHRcdFx0XHRcdFx0XHQrICc8ZGl2IGNsYXNzPVwicG9wb3Zlci1jb250ZW50XCI+J1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdCsgcG9wb3Zlcl9jb250ZW50XHJcblx0XHRcdFx0XHRcdFx0XHRcdCsgJzwvZGl2PidcclxuXHRcdFx0XHRcdFx0XHQgKyAnPC9kaXY+JztcclxuXHRcdFx0XHRcdH0sXHJcblx0XHRcdFx0XHRhbGxvd0hUTUwgICAgICAgIDogdHJ1ZSxcclxuXHRcdFx0XHRcdHRyaWdnZXJcdFx0XHQgOiAnbW91c2VlbnRlciBmb2N1cycsXHJcblx0XHRcdFx0XHRpbnRlcmFjdGl2ZSAgICAgIDogZmFsc2UsXHJcblx0XHRcdFx0XHRoaWRlT25DbGljayAgICAgIDogdHJ1ZSxcclxuXHRcdFx0XHRcdGludGVyYWN0aXZlQm9yZGVyOiAxMCxcclxuXHRcdFx0XHRcdG1heFdpZHRoICAgICAgICAgOiA1NTAsXHJcblx0XHRcdFx0XHR0aGVtZSAgICAgICAgICAgIDogJ3dwYmMtdGlwcHktdGltZXMnLFxyXG5cdFx0XHRcdFx0cGxhY2VtZW50ICAgICAgICA6ICd0b3AnLFxyXG5cdFx0XHRcdFx0ZGVsYXlcdFx0XHQgOiBbNDAwLCAwXSxcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQvL0ZpeEluOiA5LjQuMi4yXHJcblx0XHRcdFx0XHQvL2RlbGF5XHRcdFx0IDogWzAsIDk5OTk5OTk5OTldLFx0XHRcdFx0XHRcdC8vIERlYnVnZSAgdG9vbHRpcFxyXG5cdFx0XHRcdFx0aWdub3JlQXR0cmlidXRlcyA6IHRydWUsXHJcblx0XHRcdFx0XHR0b3VjaFx0XHRcdCA6IHRydWUsXHRcdFx0XHRcdFx0XHRcdC8vWydob2xkJywgNTAwXSwgLy8gNTAwbXMgZGVsYXlcdFx0XHRcdC8vRml4SW46IDkuMi4xLjVcclxuXHRcdFx0XHRcdGFwcGVuZFRvOiAoKSA9PiBkb2N1bWVudC5ib2R5LFxyXG5cdFx0XHR9KTtcclxuXHJcblx0XHRcdHJldHVybiAgdHJ1ZTtcclxuXHRcdH1cclxuXHJcblx0XHRyZXR1cm4gIGZhbHNlO1xyXG5cdH1cclxuXHJcblxyXG4vLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuLyogID09ICBEYXRlcyBGdW5jdGlvbnMgID09XHJcbi8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLSAqL1xyXG5cclxuLyoqXHJcbiAqIEdldCBudW1iZXIgb2YgZGF0ZXMgYmV0d2VlbiAyIEpTIERhdGVzXHJcbiAqXHJcbiAqIEBwYXJhbSBkYXRlMVx0XHRKUyBEYXRlXHJcbiAqIEBwYXJhbSBkYXRlMlx0XHRKUyBEYXRlXHJcbiAqIEByZXR1cm5zIHtudW1iZXJ9XHJcbiAqL1xyXG5mdW5jdGlvbiB3cGJjX2RhdGVzX19kYXlzX2JldHdlZW4oZGF0ZTEsIGRhdGUyKSB7XHJcblxyXG4gICAgLy8gVGhlIG51bWJlciBvZiBtaWxsaXNlY29uZHMgaW4gb25lIGRheVxyXG4gICAgdmFyIE9ORV9EQVkgPSAxMDAwICogNjAgKiA2MCAqIDI0O1xyXG5cclxuICAgIC8vIENvbnZlcnQgYm90aCBkYXRlcyB0byBtaWxsaXNlY29uZHNcclxuICAgIHZhciBkYXRlMV9tcyA9IGRhdGUxLmdldFRpbWUoKTtcclxuICAgIHZhciBkYXRlMl9tcyA9IGRhdGUyLmdldFRpbWUoKTtcclxuXHJcbiAgICAvLyBDYWxjdWxhdGUgdGhlIGRpZmZlcmVuY2UgaW4gbWlsbGlzZWNvbmRzXHJcbiAgICB2YXIgZGlmZmVyZW5jZV9tcyA9ICBkYXRlMV9tcyAtIGRhdGUyX21zO1xyXG5cclxuICAgIC8vIENvbnZlcnQgYmFjayB0byBkYXlzIGFuZCByZXR1cm5cclxuICAgIHJldHVybiBNYXRoLnJvdW5kKGRpZmZlcmVuY2VfbXMvT05FX0RBWSk7XHJcbn1cclxuXHJcblxyXG4vKipcclxuICogQ2hlY2sgIGlmIHRoaXMgYXJyYXkgIG9mIGRhdGVzIGlzIGNvbnNlY3V0aXZlIGFycmF5ICBvZiBkYXRlcyBvciBub3QuXHJcbiAqIFx0XHRlLmcuICBbJzIwMjQtMDUtMDknLCcyMDI0LTA1LTE5JywnMjAyNC0wNS0zMCddIC0+IGZhbHNlXHJcbiAqIFx0XHRlLmcuICBbJzIwMjQtMDUtMDknLCcyMDI0LTA1LTEwJywnMjAyNC0wNS0xMSddIC0+IHRydWVcclxuICogQHBhcmFtIHNxbF9kYXRlc19hcnJcdCBhcnJheVx0XHRlLmcuOiBbJzIwMjQtMDUtMDknLCcyMDI0LTA1LTE5JywnMjAyNC0wNS0zMCddXHJcbiAqIEByZXR1cm5zIHtib29sZWFufVxyXG4gKi9cclxuZnVuY3Rpb24gd3BiY19kYXRlc19faXNfY29uc2VjdXRpdmVfZGF0ZXNfYXJyX3JhbmdlKCBzcWxfZGF0ZXNfYXJyICl7XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQvL0ZpeEluOiAxMC4wLjAuNTBcclxuXHJcblx0aWYgKCBzcWxfZGF0ZXNfYXJyLmxlbmd0aCA+IDEgKXtcclxuXHRcdHZhciBwcmV2aW9zX2RhdGUgPSB3cGJjX19nZXRfX2pzX2RhdGUoIHNxbF9kYXRlc19hcnJbIDAgXSApO1xyXG5cdFx0dmFyIGN1cnJlbnRfZGF0ZTtcclxuXHJcblx0XHRmb3IgKCB2YXIgaSA9IDE7IGkgPCBzcWxfZGF0ZXNfYXJyLmxlbmd0aDsgaSsrICl7XHJcblx0XHRcdGN1cnJlbnRfZGF0ZSA9IHdwYmNfX2dldF9fanNfZGF0ZSggc3FsX2RhdGVzX2FycltpXSApO1xyXG5cclxuXHRcdFx0aWYgKCB3cGJjX2RhdGVzX19kYXlzX2JldHdlZW4oIGN1cnJlbnRfZGF0ZSwgcHJldmlvc19kYXRlICkgIT0gMSApe1xyXG5cdFx0XHRcdHJldHVybiAgZmFsc2U7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdHByZXZpb3NfZGF0ZSA9IGN1cnJlbnRfZGF0ZTtcclxuXHRcdH1cclxuXHR9XHJcblxyXG5cdHJldHVybiB0cnVlO1xyXG59XHJcblxyXG5cclxuLy8gLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcbi8qICA9PSAgQXV0byBEYXRlcyBTZWxlY3Rpb24gID09XHJcbi8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLSAqL1xyXG5cclxuLyoqXHJcbiAqICA9PSBIb3cgdG8gIHVzZSA/ID09XHJcbiAqXHJcbiAqICBGb3IgRGF0ZXMgc2VsZWN0aW9uLCB3ZSBuZWVkIHRvIHVzZSB0aGlzIGxvZ2ljISAgICAgV2UgbmVlZCBzZWxlY3QgdGhlIGRhdGVzIG9ubHkgYWZ0ZXIgYm9va2luZyBkYXRhIGxvYWRlZCFcclxuICpcclxuICogIENoZWNrIGV4YW1wbGUgYmVsbG93LlxyXG4gKlxyXG4gKlx0Ly8gRmlyZSBvbiBhbGwgYm9va2luZyBkYXRlcyBsb2FkZWRcclxuICpcdGpRdWVyeSggJ2JvZHknICkub24oICd3cGJjX2NhbGVuZGFyX2FqeF9fbG9hZGVkX2RhdGEnLCBmdW5jdGlvbiAoIGV2ZW50LCBsb2FkZWRfcmVzb3VyY2VfaWQgKXtcclxuICpcclxuICpcdFx0aWYgKCBsb2FkZWRfcmVzb3VyY2VfaWQgPT0gc2VsZWN0X2RhdGVzX2luX2NhbGVuZGFyX2lkICl7XHJcbiAqXHRcdFx0d3BiY19hdXRvX3NlbGVjdF9kYXRlc19pbl9jYWxlbmRhciggc2VsZWN0X2RhdGVzX2luX2NhbGVuZGFyX2lkLCAnMjAyNC0wNS0xNScsICcyMDI0LTA1LTI1JyApO1xyXG4gKlx0XHR9XHJcbiAqXHR9ICk7XHJcbiAqXHJcbiAqL1xyXG5cclxuXHJcbi8qKlxyXG4gKiBUcnkgdG8gQXV0byBzZWxlY3QgZGF0ZXMgaW4gc3BlY2lmaWMgY2FsZW5kYXIgYnkgc2ltdWxhdGVkIGNsaWNrcyBpbiBkYXRlcGlja2VyXHJcbiAqXHJcbiAqIEBwYXJhbSByZXNvdXJjZV9pZFx0XHQxXHJcbiAqIEBwYXJhbSBjaGVja19pbl95bWRcdFx0JzIwMjQtMDUtMDknXHRcdE9SICBcdFsnMjAyNC0wNS0wOScsJzIwMjQtMDUtMTknLCcyMDI0LTA1LTIwJ11cclxuICogQHBhcmFtIGNoZWNrX291dF95bWRcdFx0JzIwMjQtMDUtMTUnXHRcdE9wdGlvbmFsXHJcbiAqXHJcbiAqIEByZXR1cm5zIHtudW1iZXJ9XHRcdG51bWJlciBvZiBzZWxlY3RlZCBkYXRlc1xyXG4gKlxyXG4gKiBcdEV4YW1wbGUgMTpcdFx0XHRcdHZhciBudW1fc2VsZWN0ZWRfZGF5cyA9IHdwYmNfYXV0b19zZWxlY3RfZGF0ZXNfaW5fY2FsZW5kYXIoIDEsICcyMDI0LTA1LTE1JywgJzIwMjQtMDUtMjUnICk7XHJcbiAqIFx0RXhhbXBsZSAyOlx0XHRcdFx0dmFyIG51bV9zZWxlY3RlZF9kYXlzID0gd3BiY19hdXRvX3NlbGVjdF9kYXRlc19pbl9jYWxlbmRhciggMSwgWycyMDI0LTA1LTA5JywnMjAyNC0wNS0xOScsJzIwMjQtMDUtMjAnXSApO1xyXG4gKi9cclxuZnVuY3Rpb24gd3BiY19hdXRvX3NlbGVjdF9kYXRlc19pbl9jYWxlbmRhciggcmVzb3VyY2VfaWQsIGNoZWNrX2luX3ltZCwgY2hlY2tfb3V0X3ltZCA9ICcnICl7XHRcdFx0XHRcdFx0XHRcdC8vRml4SW46IDEwLjAuMC40N1xyXG5cclxuXHRjb25zb2xlLmxvZyggJ1dQQkNfQVVUT19TRUxFQ1RfREFURVNfSU5fQ0FMRU5EQVIoIFJFU09VUkNFX0lELCBDSEVDS19JTl9ZTUQsIENIRUNLX09VVF9ZTUQgKScsIHJlc291cmNlX2lkLCBjaGVja19pbl95bWQsIGNoZWNrX291dF95bWQgKTtcclxuXHJcblx0aWYgKFxyXG5cdFx0ICAgKCAnMjEwMC0wMS0wMScgPT0gY2hlY2tfaW5feW1kIClcclxuXHRcdHx8ICggJzIxMDAtMDEtMDEnID09IGNoZWNrX291dF95bWQgKVxyXG5cdFx0fHwgKCAoICcnID09IGNoZWNrX2luX3ltZCApICYmICggJycgPT0gY2hlY2tfb3V0X3ltZCApIClcclxuXHQpe1xyXG5cdFx0cmV0dXJuIDA7XHJcblx0fVxyXG5cclxuXHQvLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cdC8vIElmIFx0Y2hlY2tfaW5feW1kICA9ICBbICcyMDI0LTA1LTA5JywnMjAyNC0wNS0xOScsJzIwMjQtMDUtMzAnIF1cdFx0XHRcdEFSUkFZIG9mIERBVEVTXHRcdFx0XHRcdFx0Ly9GaXhJbjogMTAuMC4wLjUwXHJcblx0Ly8gLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHR2YXIgZGF0ZXNfdG9fc2VsZWN0X2FyciA9IFtdO1xyXG5cdGlmICggQXJyYXkuaXNBcnJheSggY2hlY2tfaW5feW1kICkgKXtcclxuXHRcdGRhdGVzX3RvX3NlbGVjdF9hcnIgPSB3cGJjX2Nsb25lX29iaiggY2hlY2tfaW5feW1kICk7XHJcblxyXG5cdFx0Ly8gLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cdFx0Ly8gRXhjZXB0aW9ucyB0byAgc2V0ICBcdE1VTFRJUExFIERBWVMgXHRtb2RlXHJcblx0XHQvLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblx0XHQvLyBpZiBkYXRlcyBhcyBOT1QgQ09OU0VDVVRJVkU6IFsnMjAyNC0wNS0wOScsJzIwMjQtMDUtMTknLCcyMDI0LTA1LTMwJ10sIC0+IHNldCBNVUxUSVBMRSBEQVlTIG1vZGVcclxuXHRcdGlmIChcclxuXHRcdFx0ICAgKCBkYXRlc190b19zZWxlY3RfYXJyLmxlbmd0aCA+IDAgKVxyXG5cdFx0XHQmJiAoICcnID09IGNoZWNrX291dF95bWQgKVxyXG5cdFx0XHQmJiAoICEgd3BiY19kYXRlc19faXNfY29uc2VjdXRpdmVfZGF0ZXNfYXJyX3JhbmdlKCBkYXRlc190b19zZWxlY3RfYXJyICkgKVxyXG5cdFx0KXtcclxuXHRcdFx0d3BiY19jYWxfZGF5c19zZWxlY3RfX211bHRpcGxlKCByZXNvdXJjZV9pZCApO1xyXG5cdFx0fVxyXG5cdFx0Ly8gaWYgbXVsdGlwbGUgZGF5cyB0byBzZWxlY3QsIGJ1dCBlbmFibGVkIFNJTkdMRSBkYXkgbW9kZSwgLT4gc2V0IE1VTFRJUExFIERBWVMgbW9kZVxyXG5cdFx0aWYgKFxyXG5cdFx0XHQgICAoIGRhdGVzX3RvX3NlbGVjdF9hcnIubGVuZ3RoID4gMSApXHJcblx0XHRcdCYmICggJycgPT0gY2hlY2tfb3V0X3ltZCApXHJcblx0XHRcdCYmICggJ3NpbmdsZScgPT09IF93cGJjLmNhbGVuZGFyX19nZXRfcGFyYW1fdmFsdWUoIHJlc291cmNlX2lkLCAnZGF5c19zZWxlY3RfbW9kZScgKSApXHJcblx0XHQpe1xyXG5cdFx0XHR3cGJjX2NhbF9kYXlzX3NlbGVjdF9fbXVsdGlwbGUoIHJlc291cmNlX2lkICk7XHJcblx0XHR9XHJcblx0XHQvLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblx0XHRjaGVja19pbl95bWQgPSBkYXRlc190b19zZWxlY3RfYXJyWyAwIF07XHJcblx0XHRpZiAoICcnID09IGNoZWNrX291dF95bWQgKXtcclxuXHRcdFx0Y2hlY2tfb3V0X3ltZCA9IGRhdGVzX3RvX3NlbGVjdF9hcnJbIChkYXRlc190b19zZWxlY3RfYXJyLmxlbmd0aC0xKSBdO1xyXG5cdFx0fVxyXG5cdH1cclxuXHQvLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cclxuXHJcblx0aWYgKCAnJyA9PSBjaGVja19pbl95bWQgKXtcclxuXHRcdGNoZWNrX2luX3ltZCA9IGNoZWNrX291dF95bWQ7XHJcblx0fVxyXG5cdGlmICggJycgPT0gY2hlY2tfb3V0X3ltZCApe1xyXG5cdFx0Y2hlY2tfb3V0X3ltZCA9IGNoZWNrX2luX3ltZDtcclxuXHR9XHJcblxyXG5cdGlmICggJ3VuZGVmaW5lZCcgPT09IHR5cGVvZiAocmVzb3VyY2VfaWQpICl7XHJcblx0XHRyZXNvdXJjZV9pZCA9ICcxJztcclxuXHR9XHJcblxyXG5cclxuXHR2YXIgaW5zdCA9IHdwYmNfY2FsZW5kYXJfX2dldF9pbnN0KCByZXNvdXJjZV9pZCApO1xyXG5cclxuXHRpZiAoIG51bGwgIT09IGluc3QgKXtcclxuXHJcblx0XHQvLyBVbnNlbGVjdCBhbGwgZGF0ZXMgYW5kIHNldCAgcHJvcGVydGllcyBvZiBEYXRlcGlja1xyXG5cdFx0alF1ZXJ5KCAnI2RhdGVfYm9va2luZycgKyByZXNvdXJjZV9pZCApLnZhbCggJycgKTsgICAgICBcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0Ly9GaXhJbjogNS40LjNcclxuXHRcdGluc3Quc3RheU9wZW4gPSBmYWxzZTtcclxuXHRcdGluc3QuZGF0ZXMgPSBbXTtcclxuXHRcdHZhciBjaGVja19pbl9qcyA9IHdwYmNfX2dldF9fanNfZGF0ZSggY2hlY2tfaW5feW1kICk7XHJcblx0XHR2YXIgdGRfY2VsbCAgICAgPSB3cGJjX2dldF9jbGlja2VkX3RkKCBpbnN0LmlkLCBjaGVja19pbl9qcyApO1xyXG5cclxuXHRcdC8vIElzIG9tZSB0eXBlIG9mIGVycm9yLCB0aGVuIHNlbGVjdCBtdWx0aXBsZSBkYXlzIHNlbGVjdGlvbiAgbW9kZS5cclxuXHRcdGlmICggJycgPT09IF93cGJjLmNhbGVuZGFyX19nZXRfcGFyYW1fdmFsdWUoIHJlc291cmNlX2lkLCAnZGF5c19zZWxlY3RfbW9kZScgKSApIHtcclxuIFx0XHRcdF93cGJjLmNhbGVuZGFyX19zZXRfcGFyYW1fdmFsdWUoIHJlc291cmNlX2lkLCAnZGF5c19zZWxlY3RfbW9kZScsICdtdWx0aXBsZScgKTtcclxuXHRcdH1cclxuXHJcblxyXG5cdFx0Ly8gLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblx0XHQvLyAgPT0gRFlOQU1JQyA9PVxyXG5cdFx0aWYgKCAnZHluYW1pYycgPT09IF93cGJjLmNhbGVuZGFyX19nZXRfcGFyYW1fdmFsdWUoIHJlc291cmNlX2lkLCAnZGF5c19zZWxlY3RfbW9kZScgKSApe1xyXG5cdFx0XHQvLyAxLXN0IGNsaWNrXHJcblx0XHRcdGluc3Quc3RheU9wZW4gPSBmYWxzZTtcclxuXHRcdFx0alF1ZXJ5LmRhdGVwaWNrLl9zZWxlY3REYXkoIHRkX2NlbGwsICcjJyArIGluc3QuaWQsIGNoZWNrX2luX2pzLmdldFRpbWUoKSApO1xyXG5cdFx0XHRpZiAoIDAgPT09IGluc3QuZGF0ZXMubGVuZ3RoICl7XHJcblx0XHRcdFx0cmV0dXJuIDA7ICBcdFx0XHRcdFx0XHRcdFx0Ly8gRmlyc3QgY2xpY2sgIHdhcyB1bnN1Y2Nlc3NmdWwsIHNvIHdlIG11c3Qgbm90IG1ha2Ugb3RoZXIgY2xpY2tcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0Ly8gMi1uZCBjbGlja1xyXG5cdFx0XHR2YXIgY2hlY2tfb3V0X2pzID0gd3BiY19fZ2V0X19qc19kYXRlKCBjaGVja19vdXRfeW1kICk7XHJcblx0XHRcdHZhciB0ZF9jZWxsX291dCA9IHdwYmNfZ2V0X2NsaWNrZWRfdGQoIGluc3QuaWQsIGNoZWNrX291dF9qcyApO1xyXG5cdFx0XHRpbnN0LnN0YXlPcGVuID0gdHJ1ZTtcclxuXHRcdFx0alF1ZXJ5LmRhdGVwaWNrLl9zZWxlY3REYXkoIHRkX2NlbGxfb3V0LCAnIycgKyBpbnN0LmlkLCBjaGVja19vdXRfanMuZ2V0VGltZSgpICk7XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblx0XHQvLyAgPT0gRklYRUQgPT1cclxuXHRcdGlmICggICdmaXhlZCcgPT09IF93cGJjLmNhbGVuZGFyX19nZXRfcGFyYW1fdmFsdWUoIHJlc291cmNlX2lkLCAnZGF5c19zZWxlY3RfbW9kZScgKSkge1xyXG5cdFx0XHRqUXVlcnkuZGF0ZXBpY2suX3NlbGVjdERheSggdGRfY2VsbCwgJyMnICsgaW5zdC5pZCwgY2hlY2tfaW5fanMuZ2V0VGltZSgpICk7XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblx0XHQvLyAgPT0gU0lOR0xFID09XHJcblx0XHRpZiAoICdzaW5nbGUnID09PSBfd3BiYy5jYWxlbmRhcl9fZ2V0X3BhcmFtX3ZhbHVlKCByZXNvdXJjZV9pZCwgJ2RheXNfc2VsZWN0X21vZGUnICkgKXtcclxuXHRcdFx0Ly9qUXVlcnkuZGF0ZXBpY2suX3Jlc3RyaWN0TWluTWF4KCBpbnN0LCBqUXVlcnkuZGF0ZXBpY2suX2RldGVybWluZURhdGUoIGluc3QsIGNoZWNrX2luX2pzLCBudWxsICkgKTtcdFx0Ly8gRG8gd2UgbmVlZCB0byBydW4gIHRoaXMgPyBQbGVhc2Ugbm90ZSwgY2hlY2tfaW5fanMgbXVzdCAgaGF2ZSB0aW1lLCAgbWluLCBzZWMgZGVmaW5lZCB0byAwIVxyXG5cdFx0XHRqUXVlcnkuZGF0ZXBpY2suX3NlbGVjdERheSggdGRfY2VsbCwgJyMnICsgaW5zdC5pZCwgY2hlY2tfaW5fanMuZ2V0VGltZSgpICk7XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblx0XHQvLyAgPT0gTVVMVElQTEUgPT1cclxuXHRcdGlmICggJ211bHRpcGxlJyA9PT0gX3dwYmMuY2FsZW5kYXJfX2dldF9wYXJhbV92YWx1ZSggcmVzb3VyY2VfaWQsICdkYXlzX3NlbGVjdF9tb2RlJyApICl7XHJcblxyXG5cdFx0XHR2YXIgZGF0ZXNfYXJyO1xyXG5cclxuXHRcdFx0aWYgKCBkYXRlc190b19zZWxlY3RfYXJyLmxlbmd0aCA+IDAgKXtcclxuXHRcdFx0XHQvLyBTaXR1YXRpb24sIHdoZW4gd2UgaGF2ZSBkYXRlcyBhcnJheTogWycyMDI0LTA1LTA5JywnMjAyNC0wNS0xOScsJzIwMjQtMDUtMzAnXS4gIGFuZCBub3QgdGhlIENoZWNrIEluIC8gQ2hlY2sgIG91dCBkYXRlcyBhcyBwYXJhbWV0ZXIgaW4gdGhpcyBmdW5jdGlvblxyXG5cdFx0XHRcdGRhdGVzX2FyciA9IHdwYmNfZ2V0X3NlbGVjdGlvbl9kYXRlc19qc19zdHJfYXJyX19mcm9tX2FyciggZGF0ZXNfdG9fc2VsZWN0X2FyciApO1xyXG5cdFx0XHR9IGVsc2Uge1xyXG5cdFx0XHRcdGRhdGVzX2FyciA9IHdwYmNfZ2V0X3NlbGVjdGlvbl9kYXRlc19qc19zdHJfYXJyX19mcm9tX2NoZWNrX2luX291dCggY2hlY2tfaW5feW1kLCBjaGVja19vdXRfeW1kLCBpbnN0ICk7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdGlmICggMCA9PT0gZGF0ZXNfYXJyLmRhdGVzX2pzLmxlbmd0aCApe1xyXG5cdFx0XHRcdHJldHVybiAwO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHQvLyBGb3IgQ2FsZW5kYXIgRGF5cyBzZWxlY3Rpb25cclxuXHRcdFx0Zm9yICggdmFyIGogPSAwOyBqIDwgZGF0ZXNfYXJyLmRhdGVzX2pzLmxlbmd0aDsgaisrICl7ICAgICAgIC8vIExvb3AgYXJyYXkgb2YgZGF0ZXNcclxuXHJcblx0XHRcdFx0dmFyIHN0cl9kYXRlID0gd3BiY19fZ2V0X19zcWxfY2xhc3NfZGF0ZSggZGF0ZXNfYXJyLmRhdGVzX2pzWyBqIF0gKTtcclxuXHJcblx0XHRcdFx0Ly8gRGF0ZSB1bmF2YWlsYWJsZSAhXHJcblx0XHRcdFx0aWYgKCAwID09IF93cGJjLmJvb2tpbmdzX2luX2NhbGVuZGFyX19nZXRfZm9yX2RhdGUoIHJlc291cmNlX2lkLCBzdHJfZGF0ZSApLmRheV9hdmFpbGFiaWxpdHkgKXtcclxuXHRcdFx0XHRcdHJldHVybiAwO1xyXG5cdFx0XHRcdH1cclxuXHJcblx0XHRcdFx0aWYgKCBkYXRlc19hcnIuZGF0ZXNfanNbIGogXSAhPSAtMSApIHtcclxuXHRcdFx0XHRcdGluc3QuZGF0ZXMucHVzaCggZGF0ZXNfYXJyLmRhdGVzX2pzWyBqIF0gKTtcclxuXHRcdFx0XHR9XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdHZhciBjaGVja19vdXRfZGF0ZSA9IGRhdGVzX2Fyci5kYXRlc19qc1sgKGRhdGVzX2Fyci5kYXRlc19qcy5sZW5ndGggLSAxKSBdO1xyXG5cclxuXHRcdFx0aW5zdC5kYXRlcy5wdXNoKCBjaGVja19vdXRfZGF0ZSApOyBcdFx0XHQvLyBOZWVkIGFkZCBvbmUgYWRkaXRpb25hbCBTQU1FIGRhdGUgZm9yIGNvcnJlY3QgIHdvcmtzIG9mIGRhdGVzIHNlbGVjdGlvbiAhISEhIVxyXG5cclxuXHRcdFx0dmFyIGNoZWNrb3V0X3RpbWVzdGFtcCA9IGNoZWNrX291dF9kYXRlLmdldFRpbWUoKTtcclxuXHRcdFx0dmFyIHRkX2NlbGwgPSB3cGJjX2dldF9jbGlja2VkX3RkKCBpbnN0LmlkLCBjaGVja19vdXRfZGF0ZSApO1xyXG5cclxuXHRcdFx0alF1ZXJ5LmRhdGVwaWNrLl9zZWxlY3REYXkoIHRkX2NlbGwsICcjJyArIGluc3QuaWQsIGNoZWNrb3V0X3RpbWVzdGFtcCApO1xyXG5cdFx0fVxyXG5cclxuXHJcblx0XHRpZiAoIDAgIT09IGluc3QuZGF0ZXMubGVuZ3RoICl7XHJcblx0XHRcdC8vIFNjcm9sbCB0byBzcGVjaWZpYyBtb250aCwgaWYgd2Ugc2V0IGRhdGVzIGluIHNvbWUgZnV0dXJlIG1vbnRoc1xyXG5cdFx0XHR3cGJjX2NhbGVuZGFyX19zY3JvbGxfdG8oIHJlc291cmNlX2lkLCBpbnN0LmRhdGVzWyAwIF0uZ2V0RnVsbFllYXIoKSwgaW5zdC5kYXRlc1sgMCBdLmdldE1vbnRoKCkrMSApO1xyXG5cdFx0fVxyXG5cclxuXHRcdHJldHVybiBpbnN0LmRhdGVzLmxlbmd0aDtcclxuXHR9XHJcblxyXG5cdHJldHVybiAwO1xyXG59XHJcblxyXG5cdC8qKlxyXG5cdCAqIEdldCBIVE1MIHRkIGVsZW1lbnQgKHdoZXJlIHdhcyBjbGljayBpbiBjYWxlbmRhciAgZGF5ICBjZWxsKVxyXG5cdCAqXHJcblx0ICogQHBhcmFtIGNhbGVuZGFyX2h0bWxfaWRcdFx0XHQnY2FsZW5kYXJfYm9va2luZzEnXHJcblx0ICogQHBhcmFtIGRhdGVfanNcdFx0XHRcdFx0SlMgRGF0ZVxyXG5cdCAqIEByZXR1cm5zIHsqfGpRdWVyeX1cdFx0XHRcdERvbSBIVE1MIHRkIGVsZW1lbnRcclxuXHQgKi9cclxuXHRmdW5jdGlvbiB3cGJjX2dldF9jbGlja2VkX3RkKCBjYWxlbmRhcl9odG1sX2lkLCBkYXRlX2pzICl7XHJcblxyXG5cdCAgICB2YXIgdGRfY2VsbCA9IGpRdWVyeSggJyMnICsgY2FsZW5kYXJfaHRtbF9pZCArICcgLnNxbF9kYXRlXycgKyB3cGJjX19nZXRfX3NxbF9jbGFzc19kYXRlKCBkYXRlX2pzICkgKS5nZXQoIDAgKTtcclxuXHJcblx0XHRyZXR1cm4gdGRfY2VsbDtcclxuXHR9XHJcblxyXG5cdC8qKlxyXG5cdCAqIEdldCBhcnJheXMgb2YgSlMgYW5kIFNRTCBkYXRlcyBhcyBkYXRlcyBhcnJheVxyXG5cdCAqXHJcblx0ICogQHBhcmFtIGNoZWNrX2luX3ltZFx0XHRcdFx0XHRcdFx0JzIwMjQtMDUtMTUnXHJcblx0ICogQHBhcmFtIGNoZWNrX291dF95bWRcdFx0XHRcdFx0XHRcdCcyMDI0LTA1LTI1J1xyXG5cdCAqIEBwYXJhbSBpbnN0XHRcdFx0XHRcdFx0XHRcdFx0RGF0ZXBpY2sgSW5zdC4gVXNlIHdwYmNfY2FsZW5kYXJfX2dldF9pbnN0KCByZXNvdXJjZV9pZCApO1xyXG5cdCAqIEByZXR1cm5zIHt7ZGF0ZXNfanM6ICpbXSwgZGF0ZXNfc3RyOiAqW119fVxyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfZ2V0X3NlbGVjdGlvbl9kYXRlc19qc19zdHJfYXJyX19mcm9tX2NoZWNrX2luX291dCggY2hlY2tfaW5feW1kLCBjaGVja19vdXRfeW1kICwgaW5zdCApe1xyXG5cclxuXHRcdHZhciBvcmlnaW5hbF9hcnJheSA9IFtdO1xyXG5cdFx0dmFyIGRhdGU7XHJcblx0XHR2YXIgYmtfZGlzdGluY3RfZGF0ZXMgPSBbXTtcclxuXHJcblx0XHR2YXIgY2hlY2tfaW5fZGF0ZSA9IGNoZWNrX2luX3ltZC5zcGxpdCggJy0nICk7XHJcblx0XHR2YXIgY2hlY2tfb3V0X2RhdGUgPSBjaGVja19vdXRfeW1kLnNwbGl0KCAnLScgKTtcclxuXHJcblx0XHRkYXRlID0gbmV3IERhdGUoKTtcclxuXHRcdGRhdGUuc2V0RnVsbFllYXIoIGNoZWNrX2luX2RhdGVbIDAgXSwgKGNoZWNrX2luX2RhdGVbIDEgXSAtIDEpLCBjaGVja19pbl9kYXRlWyAyIF0gKTsgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAvLyB5ZWFyLCBtb250aCwgZGF0ZVxyXG5cdFx0dmFyIG9yaWdpbmFsX2NoZWNrX2luX2RhdGUgPSBkYXRlO1xyXG5cdFx0b3JpZ2luYWxfYXJyYXkucHVzaCggalF1ZXJ5LmRhdGVwaWNrLl9yZXN0cmljdE1pbk1heCggaW5zdCwgalF1ZXJ5LmRhdGVwaWNrLl9kZXRlcm1pbmVEYXRlKCBpbnN0LCBkYXRlLCBudWxsICkgKSApOyAvL2FkZCBkYXRlXHJcblx0XHRpZiAoICEgd3BiY19pbl9hcnJheSggYmtfZGlzdGluY3RfZGF0ZXMsIChjaGVja19pbl9kYXRlWyAyIF0gKyAnLicgKyBjaGVja19pbl9kYXRlWyAxIF0gKyAnLicgKyBjaGVja19pbl9kYXRlWyAwIF0pICkgKXtcclxuXHRcdFx0YmtfZGlzdGluY3RfZGF0ZXMucHVzaCggcGFyc2VJbnQoY2hlY2tfaW5fZGF0ZVsgMiBdKSArICcuJyArIHBhcnNlSW50KGNoZWNrX2luX2RhdGVbIDEgXSkgKyAnLicgKyBjaGVja19pbl9kYXRlWyAwIF0gKTtcclxuXHRcdH1cclxuXHJcblx0XHR2YXIgZGF0ZV9vdXQgPSBuZXcgRGF0ZSgpO1xyXG5cdFx0ZGF0ZV9vdXQuc2V0RnVsbFllYXIoIGNoZWNrX291dF9kYXRlWyAwIF0sIChjaGVja19vdXRfZGF0ZVsgMSBdIC0gMSksIGNoZWNrX291dF9kYXRlWyAyIF0gKTsgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAvLyB5ZWFyLCBtb250aCwgZGF0ZVxyXG5cdFx0dmFyIG9yaWdpbmFsX2NoZWNrX291dF9kYXRlID0gZGF0ZV9vdXQ7XHJcblxyXG5cdFx0dmFyIG1ld0RhdGUgPSBuZXcgRGF0ZSggb3JpZ2luYWxfY2hlY2tfaW5fZGF0ZS5nZXRGdWxsWWVhcigpLCBvcmlnaW5hbF9jaGVja19pbl9kYXRlLmdldE1vbnRoKCksIG9yaWdpbmFsX2NoZWNrX2luX2RhdGUuZ2V0RGF0ZSgpICk7XHJcblx0XHRtZXdEYXRlLnNldERhdGUoIG9yaWdpbmFsX2NoZWNrX2luX2RhdGUuZ2V0RGF0ZSgpICsgMSApO1xyXG5cclxuXHRcdHdoaWxlIChcclxuXHRcdFx0KG9yaWdpbmFsX2NoZWNrX291dF9kYXRlID4gZGF0ZSkgJiZcclxuXHRcdFx0KG9yaWdpbmFsX2NoZWNrX2luX2RhdGUgIT0gb3JpZ2luYWxfY2hlY2tfb3V0X2RhdGUpICl7XHJcblx0XHRcdGRhdGUgPSBuZXcgRGF0ZSggbWV3RGF0ZS5nZXRGdWxsWWVhcigpLCBtZXdEYXRlLmdldE1vbnRoKCksIG1ld0RhdGUuZ2V0RGF0ZSgpICk7XHJcblxyXG5cdFx0XHRvcmlnaW5hbF9hcnJheS5wdXNoKCBqUXVlcnkuZGF0ZXBpY2suX3Jlc3RyaWN0TWluTWF4KCBpbnN0LCBqUXVlcnkuZGF0ZXBpY2suX2RldGVybWluZURhdGUoIGluc3QsIGRhdGUsIG51bGwgKSApICk7IC8vYWRkIGRhdGVcclxuXHRcdFx0aWYgKCAhd3BiY19pbl9hcnJheSggYmtfZGlzdGluY3RfZGF0ZXMsIChkYXRlLmdldERhdGUoKSArICcuJyArIHBhcnNlSW50KCBkYXRlLmdldE1vbnRoKCkgKyAxICkgKyAnLicgKyBkYXRlLmdldEZ1bGxZZWFyKCkpICkgKXtcclxuXHRcdFx0XHRia19kaXN0aW5jdF9kYXRlcy5wdXNoKCAocGFyc2VJbnQoZGF0ZS5nZXREYXRlKCkpICsgJy4nICsgcGFyc2VJbnQoIGRhdGUuZ2V0TW9udGgoKSArIDEgKSArICcuJyArIGRhdGUuZ2V0RnVsbFllYXIoKSkgKTtcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0bWV3RGF0ZSA9IG5ldyBEYXRlKCBkYXRlLmdldEZ1bGxZZWFyKCksIGRhdGUuZ2V0TW9udGgoKSwgZGF0ZS5nZXREYXRlKCkgKTtcclxuXHRcdFx0bWV3RGF0ZS5zZXREYXRlKCBtZXdEYXRlLmdldERhdGUoKSArIDEgKTtcclxuXHRcdH1cclxuXHRcdG9yaWdpbmFsX2FycmF5LnBvcCgpO1xyXG5cdFx0YmtfZGlzdGluY3RfZGF0ZXMucG9wKCk7XHJcblxyXG5cdFx0cmV0dXJuIHsnZGF0ZXNfanMnOiBvcmlnaW5hbF9hcnJheSwgJ2RhdGVzX3N0cic6IGJrX2Rpc3RpbmN0X2RhdGVzfTtcclxuXHR9XHJcblxyXG5cdC8qKlxyXG5cdCAqIEdldCBhcnJheXMgb2YgSlMgYW5kIFNRTCBkYXRlcyBhcyBkYXRlcyBhcnJheVxyXG5cdCAqXHJcblx0ICogQHBhcmFtIGRhdGVzX3RvX3NlbGVjdF9hcnJcdD0gWycyMDI0LTA1LTA5JywnMjAyNC0wNS0xOScsJzIwMjQtMDUtMzAnXVxyXG5cdCAqXHJcblx0ICogQHJldHVybnMge3tkYXRlc19qczogKltdLCBkYXRlc19zdHI6ICpbXX19XHJcblx0ICovXHJcblx0ZnVuY3Rpb24gd3BiY19nZXRfc2VsZWN0aW9uX2RhdGVzX2pzX3N0cl9hcnJfX2Zyb21fYXJyKCBkYXRlc190b19zZWxlY3RfYXJyICl7XHRcdFx0XHRcdFx0XHRcdFx0XHQvL0ZpeEluOiAxMC4wLjAuNTBcclxuXHJcblx0XHR2YXIgb3JpZ2luYWxfYXJyYXkgICAgPSBbXTtcclxuXHRcdHZhciBia19kaXN0aW5jdF9kYXRlcyA9IFtdO1xyXG5cdFx0dmFyIG9uZV9kYXRlX3N0cjtcclxuXHJcblx0XHRmb3IgKCB2YXIgZCA9IDA7IGQgPCBkYXRlc190b19zZWxlY3RfYXJyLmxlbmd0aDsgZCsrICl7XHJcblxyXG5cdFx0XHRvcmlnaW5hbF9hcnJheS5wdXNoKCB3cGJjX19nZXRfX2pzX2RhdGUoIGRhdGVzX3RvX3NlbGVjdF9hcnJbIGQgXSApICk7XHJcblxyXG5cdFx0XHRvbmVfZGF0ZV9zdHIgPSBkYXRlc190b19zZWxlY3RfYXJyWyBkIF0uc3BsaXQoJy0nKVxyXG5cdFx0XHRpZiAoICEgd3BiY19pbl9hcnJheSggYmtfZGlzdGluY3RfZGF0ZXMsIChvbmVfZGF0ZV9zdHJbIDIgXSArICcuJyArIG9uZV9kYXRlX3N0clsgMSBdICsgJy4nICsgb25lX2RhdGVfc3RyWyAwIF0pICkgKXtcclxuXHRcdFx0XHRia19kaXN0aW5jdF9kYXRlcy5wdXNoKCBwYXJzZUludChvbmVfZGF0ZV9zdHJbIDIgXSkgKyAnLicgKyBwYXJzZUludChvbmVfZGF0ZV9zdHJbIDEgXSkgKyAnLicgKyBvbmVfZGF0ZV9zdHJbIDAgXSApO1xyXG5cdFx0XHR9XHJcblx0XHR9XHJcblxyXG5cdFx0cmV0dXJuIHsnZGF0ZXNfanMnOiBvcmlnaW5hbF9hcnJheSwgJ2RhdGVzX3N0cic6IG9yaWdpbmFsX2FycmF5fTtcclxuXHR9XHJcblxyXG4vLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cclxuLyogID09ICBBdXRvIEZpbGwgRmllbGRzIC8gQXV0byBTZWxlY3QgRGF0ZXMgID09XHJcbi8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PSAqL1xyXG5cclxualF1ZXJ5KCBkb2N1bWVudCApLnJlYWR5KCBmdW5jdGlvbiAoKXtcclxuXHJcblx0dmFyIHVybF9wYXJhbXMgPSBuZXcgVVJMU2VhcmNoUGFyYW1zKCB3aW5kb3cubG9jYXRpb24uc2VhcmNoICk7XHJcblxyXG5cdC8vIERpc2FibGUgZGF5cyBzZWxlY3Rpb24gIGluIGNhbGVuZGFyLCAgYWZ0ZXIgIHJlZGlyZWN0aW9uICBmcm9tICB0aGUgXCJTZWFyY2ggcmVzdWx0cyBwYWdlLCAgYWZ0ZXIgIHNlYXJjaCAgYXZhaWxhYmlsaXR5XCIgXHRcdFx0Ly9GaXhJbjogOC44LjIuM1xyXG5cdGlmICAoICdPbicgIT0gX3dwYmMuZ2V0X290aGVyX3BhcmFtKCAnaXNfZW5hYmxlZF9ib29raW5nX3NlYXJjaF9yZXN1bHRzX2RheXNfc2VsZWN0JyApICkge1xyXG5cdFx0aWYgKFxyXG5cdFx0XHQoIHVybF9wYXJhbXMuaGFzKCAnd3BiY19zZWxlY3RfY2hlY2tfaW4nICkgKSAmJlxyXG5cdFx0XHQoIHVybF9wYXJhbXMuaGFzKCAnd3BiY19zZWxlY3RfY2hlY2tfb3V0JyApICkgJiZcclxuXHRcdFx0KCB1cmxfcGFyYW1zLmhhcyggJ3dwYmNfc2VsZWN0X2NhbGVuZGFyX2lkJyApIClcclxuXHRcdCl7XHJcblxyXG5cdFx0XHR2YXIgc2VsZWN0X2RhdGVzX2luX2NhbGVuZGFyX2lkID0gcGFyc2VJbnQoIHVybF9wYXJhbXMuZ2V0KCAnd3BiY19zZWxlY3RfY2FsZW5kYXJfaWQnICkgKTtcclxuXHJcblx0XHRcdC8vIEZpcmUgb24gYWxsIGJvb2tpbmcgZGF0ZXMgbG9hZGVkXHJcblx0XHRcdGpRdWVyeSggJ2JvZHknICkub24oICd3cGJjX2NhbGVuZGFyX2FqeF9fbG9hZGVkX2RhdGEnLCBmdW5jdGlvbiAoIGV2ZW50LCBsb2FkZWRfcmVzb3VyY2VfaWQgKXtcclxuXHJcblx0XHRcdFx0aWYgKCBsb2FkZWRfcmVzb3VyY2VfaWQgPT0gc2VsZWN0X2RhdGVzX2luX2NhbGVuZGFyX2lkICl7XHJcblx0XHRcdFx0XHR3cGJjX2F1dG9fc2VsZWN0X2RhdGVzX2luX2NhbGVuZGFyKCBzZWxlY3RfZGF0ZXNfaW5fY2FsZW5kYXJfaWQsIHVybF9wYXJhbXMuZ2V0KCAnd3BiY19zZWxlY3RfY2hlY2tfaW4nICksIHVybF9wYXJhbXMuZ2V0KCAnd3BiY19zZWxlY3RfY2hlY2tfb3V0JyApICk7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHR9ICk7XHJcblx0XHR9XHJcblx0fVxyXG5cclxuXHRpZiAoIHVybF9wYXJhbXMuaGFzKCAnd3BiY19hdXRvX2ZpbGwnICkgKXtcclxuXHJcblx0XHR2YXIgd3BiY19hdXRvX2ZpbGxfdmFsdWUgPSB1cmxfcGFyYW1zLmdldCggJ3dwYmNfYXV0b19maWxsJyApO1xyXG5cclxuXHRcdC8vIENvbnZlcnQgYmFjay4gICAgIFNvbWUgc3lzdGVtcyBkbyBub3QgbGlrZSBzeW1ib2wgJ34nIGluIFVSTCwgc28gIHdlIG5lZWQgdG8gcmVwbGFjZSB0byAgc29tZSBvdGhlciBzeW1ib2xzXHJcblx0XHR3cGJjX2F1dG9fZmlsbF92YWx1ZSA9IHdwYmNfYXV0b19maWxsX3ZhbHVlLnJlcGxhY2VBbGwoICdfXl8nLCAnficgKTtcclxuXHJcblx0XHR3cGJjX2F1dG9fZmlsbF9ib29raW5nX2ZpZWxkcyggd3BiY19hdXRvX2ZpbGxfdmFsdWUgKTtcclxuXHR9XHJcblxyXG59ICk7XHJcblxyXG4vKipcclxuICogQXV0b2ZpbGwgLyBzZWxlY3QgYm9va2luZyBmb3JtICBmaWVsZHMgYnkgIHZhbHVlcyBmcm9tICB0aGUgR0VUIHJlcXVlc3QgIHBhcmFtZXRlcjogP3dwYmNfYXV0b19maWxsPVxyXG4gKlxyXG4gKiBAcGFyYW0gYXV0b19maWxsX3N0clxyXG4gKi9cclxuZnVuY3Rpb24gd3BiY19hdXRvX2ZpbGxfYm9va2luZ19maWVsZHMoIGF1dG9fZmlsbF9zdHIgKXtcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdC8vRml4SW46IDEwLjAuMC40OFxyXG5cclxuXHRpZiAoICcnID09IGF1dG9fZmlsbF9zdHIgKXtcclxuXHRcdHJldHVybjtcclxuXHR9XHJcblxyXG4vLyBjb25zb2xlLmxvZyggJ1dQQkNfQVVUT19GSUxMX0JPT0tJTkdfRklFTERTKCBBVVRPX0ZJTExfU1RSICknLCBhdXRvX2ZpbGxfc3RyKTtcclxuXHJcblx0dmFyIGZpZWxkc19hcnIgPSB3cGJjX2F1dG9fZmlsbF9ib29raW5nX2ZpZWxkc19fcGFyc2UoIGF1dG9fZmlsbF9zdHIgKTtcclxuXHJcblx0Zm9yICggbGV0IGkgPSAwOyBpIDwgZmllbGRzX2Fyci5sZW5ndGg7IGkrKyApe1xyXG5cdFx0alF1ZXJ5KCAnW25hbWU9XCInICsgZmllbGRzX2FyclsgaSBdWyAnbmFtZScgXSArICdcIl0nICkudmFsKCBmaWVsZHNfYXJyWyBpIF1bICd2YWx1ZScgXSApO1xyXG5cdH1cclxufVxyXG5cclxuXHQvKipcclxuXHQgKiBQYXJzZSBkYXRhIGZyb20gIGdldCBwYXJhbWV0ZXI6XHQ/d3BiY19hdXRvX2ZpbGw9dmlzaXRvcnMyMzFeMn5tYXhfY2FwYWNpdHkyMzFeMlxyXG5cdCAqXHJcblx0ICogQHBhcmFtIGRhdGFfc3RyICAgICAgPSAgICd2aXNpdG9yczIzMV4yfm1heF9jYXBhY2l0eTIzMV4yJztcclxuXHQgKiBAcmV0dXJucyB7Kn1cclxuXHQgKi9cclxuXHRmdW5jdGlvbiB3cGJjX2F1dG9fZmlsbF9ib29raW5nX2ZpZWxkc19fcGFyc2UoIGRhdGFfc3RyICl7XHJcblxyXG5cdFx0dmFyIGZpbHRlcl9vcHRpb25zX2FyciA9IFtdO1xyXG5cclxuXHRcdHZhciBkYXRhX2FyciA9IGRhdGFfc3RyLnNwbGl0KCAnficgKTtcclxuXHJcblx0XHRmb3IgKCB2YXIgaiA9IDA7IGogPCBkYXRhX2Fyci5sZW5ndGg7IGorKyApe1xyXG5cclxuXHRcdFx0dmFyIG15X2Zvcm1fZmllbGQgPSBkYXRhX2FyclsgaiBdLnNwbGl0KCAnXicgKTtcclxuXHJcblx0XHRcdHZhciBmaWx0ZXJfbmFtZSAgPSAoJ3VuZGVmaW5lZCcgIT09IHR5cGVvZiAobXlfZm9ybV9maWVsZFsgMCBdKSkgPyBteV9mb3JtX2ZpZWxkWyAwIF0gOiAnJztcclxuXHRcdFx0dmFyIGZpbHRlcl92YWx1ZSA9ICgndW5kZWZpbmVkJyAhPT0gdHlwZW9mIChteV9mb3JtX2ZpZWxkWyAxIF0pKSA/IG15X2Zvcm1fZmllbGRbIDEgXSA6ICcnO1xyXG5cclxuXHRcdFx0ZmlsdGVyX29wdGlvbnNfYXJyLnB1c2goXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0J25hbWUnICA6IGZpbHRlcl9uYW1lLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0J3ZhbHVlJyA6IGZpbHRlcl92YWx1ZVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdH1cclxuXHRcdFx0XHRcdFx0XHRcdCAgICk7XHJcblx0XHR9XHJcblx0XHRyZXR1cm4gZmlsdGVyX29wdGlvbnNfYXJyO1xyXG5cdH1cclxuXHJcblx0LyoqXHJcblx0ICogUGFyc2UgZGF0YSBmcm9tICBnZXQgcGFyYW1ldGVyOlx0P3NlYXJjaF9nZXRfX2N1c3RvbV9wYXJhbXM9Li4uXHJcblx0ICpcclxuXHQgKiBAcGFyYW0gZGF0YV9zdHIgICAgICA9ICAgJ3RleHRec2VhcmNoX2ZpZWxkX19kaXNwbGF5X2NoZWNrX2luXjIzLjA1LjIwMjR+dGV4dF5zZWFyY2hfZmllbGRfX2Rpc3BsYXlfY2hlY2tfb3V0XjI2LjA1LjIwMjR+c2VsZWN0Ym94LW9uZV5zZWFyY2hfcXVhbnRpdHleMn5zZWxlY3Rib3gtb25lXmxvY2F0aW9uXlNwYWlufnNlbGVjdGJveC1vbmVebWF4X2NhcGFjaXR5XjJ+c2VsZWN0Ym94LW9uZV5hbWVuaXR5XnBhcmtpbmd+Y2hlY2tib3hec2VhcmNoX2ZpZWxkX19leHRlbmRfc2VhcmNoX2RheXNeNX5zdWJtaXReXlNlYXJjaH5oaWRkZW5ec2VhcmNoX2dldF9fY2hlY2tfaW5feW1kXjIwMjQtMDUtMjN+aGlkZGVuXnNlYXJjaF9nZXRfX2NoZWNrX291dF95bWReMjAyNC0wNS0yNn5oaWRkZW5ec2VhcmNoX2dldF9fdGltZV5+aGlkZGVuXnNlYXJjaF9nZXRfX3F1YW50aXR5XjJ+aGlkZGVuXnNlYXJjaF9nZXRfX2V4dGVuZF41fmhpZGRlbl5zZWFyY2hfZ2V0X191c2Vyc19pZF5+aGlkZGVuXnNlYXJjaF9nZXRfX2N1c3RvbV9wYXJhbXNefic7XHJcblx0ICogQHJldHVybnMgeyp9XHJcblx0ICovXHJcblx0ZnVuY3Rpb24gd3BiY19hdXRvX2ZpbGxfc2VhcmNoX2ZpZWxkc19fcGFyc2UoIGRhdGFfc3RyICl7XHJcblxyXG5cdFx0dmFyIGZpbHRlcl9vcHRpb25zX2FyciA9IFtdO1xyXG5cclxuXHRcdHZhciBkYXRhX2FyciA9IGRhdGFfc3RyLnNwbGl0KCAnficgKTtcclxuXHJcblx0XHRmb3IgKCB2YXIgaiA9IDA7IGogPCBkYXRhX2Fyci5sZW5ndGg7IGorKyApe1xyXG5cclxuXHRcdFx0dmFyIG15X2Zvcm1fZmllbGQgPSBkYXRhX2FyclsgaiBdLnNwbGl0KCAnXicgKTtcclxuXHJcblx0XHRcdHZhciBmaWx0ZXJfdHlwZSAgPSAoJ3VuZGVmaW5lZCcgIT09IHR5cGVvZiAobXlfZm9ybV9maWVsZFsgMCBdKSkgPyBteV9mb3JtX2ZpZWxkWyAwIF0gOiAnJztcclxuXHRcdFx0dmFyIGZpbHRlcl9uYW1lICA9ICgndW5kZWZpbmVkJyAhPT0gdHlwZW9mIChteV9mb3JtX2ZpZWxkWyAxIF0pKSA/IG15X2Zvcm1fZmllbGRbIDEgXSA6ICcnO1xyXG5cdFx0XHR2YXIgZmlsdGVyX3ZhbHVlID0gKCd1bmRlZmluZWQnICE9PSB0eXBlb2YgKG15X2Zvcm1fZmllbGRbIDIgXSkpID8gbXlfZm9ybV9maWVsZFsgMiBdIDogJyc7XHJcblxyXG5cdFx0XHRmaWx0ZXJfb3B0aW9uc19hcnIucHVzaChcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHR7XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHQndHlwZScgIDogZmlsdGVyX3R5cGUsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnbmFtZScgIDogZmlsdGVyX25hbWUsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHQndmFsdWUnIDogZmlsdGVyX3ZhbHVlXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0XHRcdFx0ICAgKTtcclxuXHRcdH1cclxuXHRcdHJldHVybiBmaWx0ZXJfb3B0aW9uc19hcnI7XHJcblx0fVxyXG5cclxuXHJcbi8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG4vKiAgPT0gIEF1dG8gVXBkYXRlIG51bWJlciBvZiBtb250aHMgaW4gY2FsZW5kYXJzIE9OIHNjcmVlbiBzaXplIGNoYW5nZWQgID09XHJcbi8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLSAqL1xyXG5cclxuLyoqXHJcbiAqIEF1dG8gVXBkYXRlIE51bWJlciBvZiBNb250aHMgaW4gQ2FsZW5kYXIsIGUuZy46ICBcdFx0aWYgICAgKCBXSU5ET1dfV0lEVEggPD0gNzgycHggKSAgID4+PiBcdE1PTlRIU19OVU1CRVIgPSAxXHJcbiAqICAgRUxTRTogIG51bWJlciBvZiBtb250aHMgZGVmaW5lZCBpbiBzaG9ydGNvZGUuXHJcbiAqIEBwYXJhbSByZXNvdXJjZV9pZCBpbnRcclxuICpcclxuICovXHJcbmZ1bmN0aW9uIHdwYmNfY2FsZW5kYXJfX2F1dG9fdXBkYXRlX21vbnRoc19udW1iZXJfX29uX3Jlc2l6ZSggcmVzb3VyY2VfaWQgKXtcclxuXHJcblx0dmFyIGxvY2FsX19udW1iZXJfb2ZfbW9udGhzID0gcGFyc2VJbnQoIF93cGJjLmNhbGVuZGFyX19nZXRfcGFyYW1fdmFsdWUoIHJlc291cmNlX2lkLCAnY2FsZW5kYXJfbnVtYmVyX29mX21vbnRocycgKSApO1xyXG5cclxuXHRpZiAoIGxvY2FsX19udW1iZXJfb2ZfbW9udGhzID4gMSApe1xyXG5cclxuXHRcdGlmICggalF1ZXJ5KCB3aW5kb3cgKS53aWR0aCgpIDw9IDc4MiApe1xyXG5cdFx0XHR3cGJjX2NhbGVuZGFyX191cGRhdGVfbW9udGhzX251bWJlciggcmVzb3VyY2VfaWQsIDEgKTtcclxuXHRcdH0gZWxzZSB7XHJcblx0XHRcdHdwYmNfY2FsZW5kYXJfX3VwZGF0ZV9tb250aHNfbnVtYmVyKCByZXNvdXJjZV9pZCwgbG9jYWxfX251bWJlcl9vZl9tb250aHMgKTtcclxuXHRcdH1cclxuXHJcblx0fVxyXG59XHJcblxyXG4vKipcclxuICogQXV0byBVcGRhdGUgTnVtYmVyIG9mIE1vbnRocyBpbiAgIEFMTCAgIENhbGVuZGFyc1xyXG4gKlxyXG4gKi9cclxuZnVuY3Rpb24gd3BiY19jYWxlbmRhcnNfX2F1dG9fdXBkYXRlX21vbnRoc19udW1iZXIoKXtcclxuXHJcblx0dmFyIGFsbF9jYWxlbmRhcnNfYXJyID0gX3dwYmMuY2FsZW5kYXJzX2FsbF9fZ2V0KCk7XHJcblxyXG5cdC8vIFRoaXMgTE9PUCBcImZvciBpblwiIGlzIEdPT0QsIGJlY2F1c2Ugd2UgY2hlY2sgIGhlcmUga2V5cyAgICAnY2FsZW5kYXJfJyA9PT0gY2FsZW5kYXJfaWQuc2xpY2UoIDAsIDkgKVxyXG5cdGZvciAoIHZhciBjYWxlbmRhcl9pZCBpbiBhbGxfY2FsZW5kYXJzX2FyciApe1xyXG5cdFx0aWYgKCAnY2FsZW5kYXJfJyA9PT0gY2FsZW5kYXJfaWQuc2xpY2UoIDAsIDkgKSApe1xyXG5cdFx0XHR2YXIgcmVzb3VyY2VfaWQgPSBwYXJzZUludCggY2FsZW5kYXJfaWQuc2xpY2UoIDkgKSApO1x0XHRcdC8vICAnY2FsZW5kYXJfMycgLT4gM1xyXG5cdFx0XHRpZiAoIHJlc291cmNlX2lkID4gMCApe1xyXG5cdFx0XHRcdHdwYmNfY2FsZW5kYXJfX2F1dG9fdXBkYXRlX21vbnRoc19udW1iZXJfX29uX3Jlc2l6ZSggcmVzb3VyY2VfaWQgKTtcclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cdH1cclxufVxyXG5cclxuLyoqXHJcbiAqIElmIGJyb3dzZXIgd2luZG93IGNoYW5nZWQsICB0aGVuICB1cGRhdGUgbnVtYmVyIG9mIG1vbnRocy5cclxuICovXHJcbmpRdWVyeSggd2luZG93ICkub24oICdyZXNpemUnLCBmdW5jdGlvbiAoKXtcclxuXHR3cGJjX2NhbGVuZGFyc19fYXV0b191cGRhdGVfbW9udGhzX251bWJlcigpO1xyXG59ICk7XHJcblxyXG4vKipcclxuICogQXV0byB1cGRhdGUgY2FsZW5kYXIgbnVtYmVyIG9mIG1vbnRocyBvbiBpbml0aWFsIHBhZ2UgbG9hZFxyXG4gKi9cclxualF1ZXJ5KCBkb2N1bWVudCApLnJlYWR5KCBmdW5jdGlvbiAoKXtcclxuXHR2YXIgY2xvc2VkX3RpbWVyID0gc2V0VGltZW91dCggZnVuY3Rpb24gKCl7XHJcblx0XHR3cGJjX2NhbGVuZGFyc19fYXV0b191cGRhdGVfbW9udGhzX251bWJlcigpO1xyXG5cdH0sIDEwMCApO1xyXG59KTsiLCIvKipcclxuICogPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cclxuICpcdGluY2x1ZGVzL19fanMvY2FsL2RheXNfc2VsZWN0X2N1c3RvbS5qc1xyXG4gKiA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxyXG4gKi9cclxuXHJcbi8vRml4SW46IDkuOC45LjJcclxuXHJcbi8qKlxyXG4gKiBSZS1Jbml0IENhbGVuZGFyIGFuZCBSZS1SZW5kZXIgaXQuXHJcbiAqXHJcbiAqIEBwYXJhbSByZXNvdXJjZV9pZFxyXG4gKi9cclxuZnVuY3Rpb24gd3BiY19jYWxfX3JlX2luaXQoIHJlc291cmNlX2lkICl7XHJcblxyXG5cdC8vIFJlbW92ZSBDTEFTUyAgZm9yIGFiaWxpdHkgdG8gcmUtcmVuZGVyIGFuZCByZWluaXQgY2FsZW5kYXIuXHJcblx0alF1ZXJ5KCAnI2NhbGVuZGFyX2Jvb2tpbmcnICsgcmVzb3VyY2VfaWQgKS5yZW1vdmVDbGFzcyggJ2hhc0RhdGVwaWNrJyApO1xyXG5cdHdwYmNfY2FsZW5kYXJfc2hvdyggcmVzb3VyY2VfaWQgKTtcclxufVxyXG5cclxuXHJcbi8qKlxyXG4gKiBSZS1Jbml0IHByZXZpb3VzbHkgIHNhdmVkIGRheXMgc2VsZWN0aW9uICB2YXJpYWJsZXMuXHJcbiAqXHJcbiAqIEBwYXJhbSByZXNvdXJjZV9pZFxyXG4gKi9cclxuZnVuY3Rpb24gd3BiY19jYWxfZGF5c19zZWxlY3RfX3JlX2luaXQoIHJlc291cmNlX2lkICl7XHJcblxyXG5cdF93cGJjLmNhbGVuZGFyX19zZXRfcGFyYW1fdmFsdWUoIHJlc291cmNlX2lkLCAnc2F2ZWRfdmFyaWFibGVfX19kYXlzX3NlbGVjdF9pbml0aWFsJ1xyXG5cdFx0LCB7XHJcblx0XHRcdCdkeW5hbWljX19kYXlzX21pbicgICAgICAgIDogX3dwYmMuY2FsZW5kYXJfX2dldF9wYXJhbV92YWx1ZSggcmVzb3VyY2VfaWQsICdkeW5hbWljX19kYXlzX21pbicgKSxcclxuXHRcdFx0J2R5bmFtaWNfX2RheXNfbWF4JyAgICAgICAgOiBfd3BiYy5jYWxlbmRhcl9fZ2V0X3BhcmFtX3ZhbHVlKCByZXNvdXJjZV9pZCwgJ2R5bmFtaWNfX2RheXNfbWF4JyApLFxyXG5cdFx0XHQnZHluYW1pY19fZGF5c19zcGVjaWZpYycgICA6IF93cGJjLmNhbGVuZGFyX19nZXRfcGFyYW1fdmFsdWUoIHJlc291cmNlX2lkLCAnZHluYW1pY19fZGF5c19zcGVjaWZpYycgKSxcclxuXHRcdFx0J2R5bmFtaWNfX3dlZWtfZGF5c19fc3RhcnQnOiBfd3BiYy5jYWxlbmRhcl9fZ2V0X3BhcmFtX3ZhbHVlKCByZXNvdXJjZV9pZCwgJ2R5bmFtaWNfX3dlZWtfZGF5c19fc3RhcnQnICksXHJcblx0XHRcdCdmaXhlZF9fZGF5c19udW0nICAgICAgICAgIDogX3dwYmMuY2FsZW5kYXJfX2dldF9wYXJhbV92YWx1ZSggcmVzb3VyY2VfaWQsICdmaXhlZF9fZGF5c19udW0nICksXHJcblx0XHRcdCdmaXhlZF9fd2Vla19kYXlzX19zdGFydCcgIDogX3dwYmMuY2FsZW5kYXJfX2dldF9wYXJhbV92YWx1ZSggcmVzb3VyY2VfaWQsICdmaXhlZF9fd2Vla19kYXlzX19zdGFydCcgKVxyXG5cdFx0fVxyXG5cdCk7XHJcbn1cclxuXHJcbi8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cclxuLyoqXHJcbiAqIFNldCBTaW5nbGUgRGF5IHNlbGVjdGlvbiAtIGFmdGVyIHBhZ2UgbG9hZFxyXG4gKlxyXG4gKiBAcGFyYW0gcmVzb3VyY2VfaWRcdFx0SUQgb2YgYm9va2luZyByZXNvdXJjZVxyXG4gKi9cclxuZnVuY3Rpb24gd3BiY19jYWxfcmVhZHlfZGF5c19zZWxlY3RfX3NpbmdsZSggcmVzb3VyY2VfaWQgKXtcclxuXHJcblx0Ly8gUmUtZGVmaW5lIHNlbGVjdGlvbiwgb25seSBhZnRlciBwYWdlIGxvYWRlZCB3aXRoIGFsbCBpbml0IHZhcnNcclxuXHRqUXVlcnkoZG9jdW1lbnQpLnJlYWR5KGZ1bmN0aW9uKCl7XHJcblxyXG5cdFx0Ly8gV2FpdCAxIHNlY29uZCwganVzdCB0byAgYmUgc3VyZSwgdGhhdCBhbGwgaW5pdCB2YXJzIGRlZmluZWRcclxuXHRcdHNldFRpbWVvdXQoZnVuY3Rpb24oKXtcclxuXHJcblx0XHRcdHdwYmNfY2FsX2RheXNfc2VsZWN0X19zaW5nbGUoIHJlc291cmNlX2lkICk7XHJcblxyXG5cdFx0fSwgMTAwMCk7XHJcblx0fSk7XHJcbn1cclxuXHJcbi8qKlxyXG4gKiBTZXQgU2luZ2xlIERheSBzZWxlY3Rpb25cclxuICogQ2FuIGJlIHJ1biBhdCBhbnkgIHRpbWUsICB3aGVuICBjYWxlbmRhciBkZWZpbmVkIC0gdXNlZnVsIGZvciBjb25zb2xlIHJ1bi5cclxuICpcclxuICogQHBhcmFtIHJlc291cmNlX2lkXHRcdElEIG9mIGJvb2tpbmcgcmVzb3VyY2VcclxuICovXHJcbmZ1bmN0aW9uIHdwYmNfY2FsX2RheXNfc2VsZWN0X19zaW5nbGUoIHJlc291cmNlX2lkICl7XHJcblxyXG5cdF93cGJjLmNhbGVuZGFyX19zZXRfcGFyYW1ldGVycyggcmVzb3VyY2VfaWQsIHsnZGF5c19zZWxlY3RfbW9kZSc6ICdzaW5nbGUnfSApO1xyXG5cclxuXHR3cGJjX2NhbF9kYXlzX3NlbGVjdF9fcmVfaW5pdCggcmVzb3VyY2VfaWQgKTtcclxuXHR3cGJjX2NhbF9fcmVfaW5pdCggcmVzb3VyY2VfaWQgKTtcclxufVxyXG5cclxuLy8gLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblxyXG4vKipcclxuICogU2V0IE11bHRpcGxlIERheXMgc2VsZWN0aW9uICAtIGFmdGVyIHBhZ2UgbG9hZFxyXG4gKlxyXG4gKiBAcGFyYW0gcmVzb3VyY2VfaWRcdFx0SUQgb2YgYm9va2luZyByZXNvdXJjZVxyXG4gKi9cclxuZnVuY3Rpb24gd3BiY19jYWxfcmVhZHlfZGF5c19zZWxlY3RfX211bHRpcGxlKCByZXNvdXJjZV9pZCApe1xyXG5cclxuXHQvLyBSZS1kZWZpbmUgc2VsZWN0aW9uLCBvbmx5IGFmdGVyIHBhZ2UgbG9hZGVkIHdpdGggYWxsIGluaXQgdmFyc1xyXG5cdGpRdWVyeShkb2N1bWVudCkucmVhZHkoZnVuY3Rpb24oKXtcclxuXHJcblx0XHQvLyBXYWl0IDEgc2Vjb25kLCBqdXN0IHRvICBiZSBzdXJlLCB0aGF0IGFsbCBpbml0IHZhcnMgZGVmaW5lZFxyXG5cdFx0c2V0VGltZW91dChmdW5jdGlvbigpe1xyXG5cclxuXHRcdFx0d3BiY19jYWxfZGF5c19zZWxlY3RfX211bHRpcGxlKCByZXNvdXJjZV9pZCApO1xyXG5cclxuXHRcdH0sIDEwMDApO1xyXG5cdH0pO1xyXG59XHJcblxyXG5cclxuLyoqXHJcbiAqIFNldCBNdWx0aXBsZSBEYXlzIHNlbGVjdGlvblxyXG4gKiBDYW4gYmUgcnVuIGF0IGFueSAgdGltZSwgIHdoZW4gIGNhbGVuZGFyIGRlZmluZWQgLSB1c2VmdWwgZm9yIGNvbnNvbGUgcnVuLlxyXG4gKlxyXG4gKiBAcGFyYW0gcmVzb3VyY2VfaWRcdFx0SUQgb2YgYm9va2luZyByZXNvdXJjZVxyXG4gKi9cclxuZnVuY3Rpb24gd3BiY19jYWxfZGF5c19zZWxlY3RfX211bHRpcGxlKCByZXNvdXJjZV9pZCApe1xyXG5cclxuXHRfd3BiYy5jYWxlbmRhcl9fc2V0X3BhcmFtZXRlcnMoIHJlc291cmNlX2lkLCB7J2RheXNfc2VsZWN0X21vZGUnOiAnbXVsdGlwbGUnfSApO1xyXG5cclxuXHR3cGJjX2NhbF9kYXlzX3NlbGVjdF9fcmVfaW5pdCggcmVzb3VyY2VfaWQgKTtcclxuXHR3cGJjX2NhbF9fcmVfaW5pdCggcmVzb3VyY2VfaWQgKTtcclxufVxyXG5cclxuXHJcbi8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cclxuLyoqXHJcbiAqIFNldCBGaXhlZCBEYXlzIHNlbGVjdGlvbiB3aXRoICAxIG1vdXNlIGNsaWNrICAtIGFmdGVyIHBhZ2UgbG9hZFxyXG4gKlxyXG4gKiBAaW50ZWdlciByZXNvdXJjZV9pZFx0XHRcdC0gMVx0XHRcdFx0ICAgLS0gSUQgb2YgYm9va2luZyByZXNvdXJjZSAoY2FsZW5kYXIpIC1cclxuICogQGludGVnZXIgZGF5c19udW1iZXJcdFx0XHQtIDNcdFx0XHRcdCAgIC0tIG51bWJlciBvZiBkYXlzIHRvICBzZWxlY3RcdC1cclxuICogQGFycmF5IHdlZWtfZGF5c19fc3RhcnRcdC0gWy0xXSB8IFsgMSwgNV0gICAtLSAgeyAtMSAtIEFueSB8IDAgLSBTdSwgIDEgLSBNbywgIDIgLSBUdSwgMyAtIFdlLCA0IC0gVGgsIDUgLSBGciwgNiAtIFNhdCB9XHJcbiAqL1xyXG5mdW5jdGlvbiB3cGJjX2NhbF9yZWFkeV9kYXlzX3NlbGVjdF9fZml4ZWQoIHJlc291cmNlX2lkLCBkYXlzX251bWJlciwgd2Vla19kYXlzX19zdGFydCA9IFstMV0gKXtcclxuXHJcblx0Ly8gUmUtZGVmaW5lIHNlbGVjdGlvbiwgb25seSBhZnRlciBwYWdlIGxvYWRlZCB3aXRoIGFsbCBpbml0IHZhcnNcclxuXHRqUXVlcnkoZG9jdW1lbnQpLnJlYWR5KGZ1bmN0aW9uKCl7XHJcblxyXG5cdFx0Ly8gV2FpdCAxIHNlY29uZCwganVzdCB0byAgYmUgc3VyZSwgdGhhdCBhbGwgaW5pdCB2YXJzIGRlZmluZWRcclxuXHRcdHNldFRpbWVvdXQoZnVuY3Rpb24oKXtcclxuXHJcblx0XHRcdHdwYmNfY2FsX2RheXNfc2VsZWN0X19maXhlZCggcmVzb3VyY2VfaWQsIGRheXNfbnVtYmVyLCB3ZWVrX2RheXNfX3N0YXJ0ICk7XHJcblxyXG5cdFx0fSwgMTAwMCk7XHJcblx0fSk7XHJcbn1cclxuXHJcblxyXG4vKipcclxuICogU2V0IEZpeGVkIERheXMgc2VsZWN0aW9uIHdpdGggIDEgbW91c2UgY2xpY2tcclxuICogQ2FuIGJlIHJ1biBhdCBhbnkgIHRpbWUsICB3aGVuICBjYWxlbmRhciBkZWZpbmVkIC0gdXNlZnVsIGZvciBjb25zb2xlIHJ1bi5cclxuICpcclxuICogQGludGVnZXIgcmVzb3VyY2VfaWRcdFx0XHQtIDFcdFx0XHRcdCAgIC0tIElEIG9mIGJvb2tpbmcgcmVzb3VyY2UgKGNhbGVuZGFyKSAtXHJcbiAqIEBpbnRlZ2VyIGRheXNfbnVtYmVyXHRcdFx0LSAzXHRcdFx0XHQgICAtLSBudW1iZXIgb2YgZGF5cyB0byAgc2VsZWN0XHQtXHJcbiAqIEBhcnJheSB3ZWVrX2RheXNfX3N0YXJ0XHQtIFstMV0gfCBbIDEsIDVdICAgLS0gIHsgLTEgLSBBbnkgfCAwIC0gU3UsICAxIC0gTW8sICAyIC0gVHUsIDMgLSBXZSwgNCAtIFRoLCA1IC0gRnIsIDYgLSBTYXQgfVxyXG4gKi9cclxuZnVuY3Rpb24gd3BiY19jYWxfZGF5c19zZWxlY3RfX2ZpeGVkKCByZXNvdXJjZV9pZCwgZGF5c19udW1iZXIsIHdlZWtfZGF5c19fc3RhcnQgPSBbLTFdICl7XHJcblxyXG5cdF93cGJjLmNhbGVuZGFyX19zZXRfcGFyYW1ldGVycyggcmVzb3VyY2VfaWQsIHsnZGF5c19zZWxlY3RfbW9kZSc6ICdmaXhlZCd9ICk7XHJcblxyXG5cdF93cGJjLmNhbGVuZGFyX19zZXRfcGFyYW1ldGVycyggcmVzb3VyY2VfaWQsIHsnZml4ZWRfX2RheXNfbnVtJzogcGFyc2VJbnQoIGRheXNfbnVtYmVyICl9ICk7XHRcdFx0Ly8gTnVtYmVyIG9mIGRheXMgc2VsZWN0aW9uIHdpdGggMSBtb3VzZSBjbGlja1xyXG5cdF93cGJjLmNhbGVuZGFyX19zZXRfcGFyYW1ldGVycyggcmVzb3VyY2VfaWQsIHsnZml4ZWRfX3dlZWtfZGF5c19fc3RhcnQnOiB3ZWVrX2RheXNfX3N0YXJ0fSApOyBcdC8vIHsgLTEgLSBBbnkgfCAwIC0gU3UsICAxIC0gTW8sICAyIC0gVHUsIDMgLSBXZSwgNCAtIFRoLCA1IC0gRnIsIDYgLSBTYXQgfVxyXG5cclxuXHR3cGJjX2NhbF9kYXlzX3NlbGVjdF9fcmVfaW5pdCggcmVzb3VyY2VfaWQgKTtcclxuXHR3cGJjX2NhbF9fcmVfaW5pdCggcmVzb3VyY2VfaWQgKTtcclxufVxyXG5cclxuLy8gLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblxyXG4vKipcclxuICogU2V0IFJhbmdlIERheXMgc2VsZWN0aW9uICB3aXRoICAyIG1vdXNlIGNsaWNrcyAgLSBhZnRlciBwYWdlIGxvYWRcclxuICpcclxuICogQGludGVnZXIgcmVzb3VyY2VfaWRcdFx0XHQtIDFcdFx0XHRcdCAgIFx0XHQtLSBJRCBvZiBib29raW5nIHJlc291cmNlIChjYWxlbmRhcilcclxuICogQGludGVnZXIgZGF5c19taW5cdFx0XHQtIDdcdFx0XHRcdCAgIFx0XHQtLSBNaW4gbnVtYmVyIG9mIGRheXMgdG8gc2VsZWN0XHJcbiAqIEBpbnRlZ2VyIGRheXNfbWF4XHRcdFx0LSAzMFx0XHRcdCAgIFx0XHQtLSBNYXggbnVtYmVyIG9mIGRheXMgdG8gc2VsZWN0XHJcbiAqIEBhcnJheSBkYXlzX3NwZWNpZmljXHRcdFx0LSBbXSB8IFs3LDE0LDIxLDI4XVx0XHQtLSBSZXN0cmljdGlvbiBmb3IgU3BlY2lmaWMgbnVtYmVyIG9mIGRheXMgc2VsZWN0aW9uXHJcbiAqIEBhcnJheSB3ZWVrX2RheXNfX3N0YXJ0XHRcdC0gWy0xXSB8IFsgMSwgNV0gICBcdFx0LS0gIHsgLTEgLSBBbnkgfCAwIC0gU3UsICAxIC0gTW8sICAyIC0gVHUsIDMgLSBXZSwgNCAtIFRoLCA1IC0gRnIsIDYgLSBTYXQgfVxyXG4gKi9cclxuZnVuY3Rpb24gd3BiY19jYWxfcmVhZHlfZGF5c19zZWxlY3RfX3JhbmdlKCByZXNvdXJjZV9pZCwgZGF5c19taW4sIGRheXNfbWF4LCBkYXlzX3NwZWNpZmljID0gW10sIHdlZWtfZGF5c19fc3RhcnQgPSBbLTFdICl7XHJcblxyXG5cdC8vIFJlLWRlZmluZSBzZWxlY3Rpb24sIG9ubHkgYWZ0ZXIgcGFnZSBsb2FkZWQgd2l0aCBhbGwgaW5pdCB2YXJzXHJcblx0alF1ZXJ5KGRvY3VtZW50KS5yZWFkeShmdW5jdGlvbigpe1xyXG5cclxuXHRcdC8vIFdhaXQgMSBzZWNvbmQsIGp1c3QgdG8gIGJlIHN1cmUsIHRoYXQgYWxsIGluaXQgdmFycyBkZWZpbmVkXHJcblx0XHRzZXRUaW1lb3V0KGZ1bmN0aW9uKCl7XHJcblxyXG5cdFx0XHR3cGJjX2NhbF9kYXlzX3NlbGVjdF9fcmFuZ2UoIHJlc291cmNlX2lkLCBkYXlzX21pbiwgZGF5c19tYXgsIGRheXNfc3BlY2lmaWMsIHdlZWtfZGF5c19fc3RhcnQgKTtcclxuXHRcdH0sIDEwMDApO1xyXG5cdH0pO1xyXG59XHJcblxyXG4vKipcclxuICogU2V0IFJhbmdlIERheXMgc2VsZWN0aW9uICB3aXRoICAyIG1vdXNlIGNsaWNrc1xyXG4gKiBDYW4gYmUgcnVuIGF0IGFueSAgdGltZSwgIHdoZW4gIGNhbGVuZGFyIGRlZmluZWQgLSB1c2VmdWwgZm9yIGNvbnNvbGUgcnVuLlxyXG4gKlxyXG4gKiBAaW50ZWdlciByZXNvdXJjZV9pZFx0XHRcdC0gMVx0XHRcdFx0ICAgXHRcdC0tIElEIG9mIGJvb2tpbmcgcmVzb3VyY2UgKGNhbGVuZGFyKVxyXG4gKiBAaW50ZWdlciBkYXlzX21pblx0XHRcdC0gN1x0XHRcdFx0ICAgXHRcdC0tIE1pbiBudW1iZXIgb2YgZGF5cyB0byBzZWxlY3RcclxuICogQGludGVnZXIgZGF5c19tYXhcdFx0XHQtIDMwXHRcdFx0ICAgXHRcdC0tIE1heCBudW1iZXIgb2YgZGF5cyB0byBzZWxlY3RcclxuICogQGFycmF5IGRheXNfc3BlY2lmaWNcdFx0XHQtIFtdIHwgWzcsMTQsMjEsMjhdXHRcdC0tIFJlc3RyaWN0aW9uIGZvciBTcGVjaWZpYyBudW1iZXIgb2YgZGF5cyBzZWxlY3Rpb25cclxuICogQGFycmF5IHdlZWtfZGF5c19fc3RhcnRcdFx0LSBbLTFdIHwgWyAxLCA1XSAgIFx0XHQtLSAgeyAtMSAtIEFueSB8IDAgLSBTdSwgIDEgLSBNbywgIDIgLSBUdSwgMyAtIFdlLCA0IC0gVGgsIDUgLSBGciwgNiAtIFNhdCB9XHJcbiAqL1xyXG5mdW5jdGlvbiB3cGJjX2NhbF9kYXlzX3NlbGVjdF9fcmFuZ2UoIHJlc291cmNlX2lkLCBkYXlzX21pbiwgZGF5c19tYXgsIGRheXNfc3BlY2lmaWMgPSBbXSwgd2Vla19kYXlzX19zdGFydCA9IFstMV0gKXtcclxuXHJcblx0X3dwYmMuY2FsZW5kYXJfX3NldF9wYXJhbWV0ZXJzKCAgcmVzb3VyY2VfaWQsIHsnZGF5c19zZWxlY3RfbW9kZSc6ICdkeW5hbWljJ30gICk7XHJcblx0X3dwYmMuY2FsZW5kYXJfX3NldF9wYXJhbV92YWx1ZSggcmVzb3VyY2VfaWQsICdkeW5hbWljX19kYXlzX21pbicgICAgICAgICAsIHBhcnNlSW50KCBkYXlzX21pbiApICApOyAgICAgICAgICAgXHRcdC8vIE1pbi4gTnVtYmVyIG9mIGRheXMgc2VsZWN0aW9uIHdpdGggMiBtb3VzZSBjbGlja3NcclxuXHRfd3BiYy5jYWxlbmRhcl9fc2V0X3BhcmFtX3ZhbHVlKCByZXNvdXJjZV9pZCwgJ2R5bmFtaWNfX2RheXNfbWF4JyAgICAgICAgICwgcGFyc2VJbnQoIGRheXNfbWF4ICkgICk7ICAgICAgICAgIFx0XHQvLyBNYXguIE51bWJlciBvZiBkYXlzIHNlbGVjdGlvbiB3aXRoIDIgbW91c2UgY2xpY2tzXHJcblx0X3dwYmMuY2FsZW5kYXJfX3NldF9wYXJhbV92YWx1ZSggcmVzb3VyY2VfaWQsICdkeW5hbWljX19kYXlzX3NwZWNpZmljJyAgICAsIGRheXNfc3BlY2lmaWMgICk7XHQgICAgICBcdFx0XHRcdC8vIEV4YW1wbGUgWzUsN11cclxuXHRfd3BiYy5jYWxlbmRhcl9fc2V0X3BhcmFtX3ZhbHVlKCByZXNvdXJjZV9pZCwgJ2R5bmFtaWNfX3dlZWtfZGF5c19fc3RhcnQnICwgd2Vla19kYXlzX19zdGFydCAgKTsgIFx0XHRcdFx0XHQvLyB7IC0xIC0gQW55IHwgMCAtIFN1LCAgMSAtIE1vLCAgMiAtIFR1LCAzIC0gV2UsIDQgLSBUaCwgNSAtIEZyLCA2IC0gU2F0IH1cclxuXHJcblx0d3BiY19jYWxfZGF5c19zZWxlY3RfX3JlX2luaXQoIHJlc291cmNlX2lkICk7XHJcblx0d3BiY19jYWxfX3JlX2luaXQoIHJlc291cmNlX2lkICk7XHJcbn1cclxuIiwiLyoqXHJcbiAqID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XHJcbiAqXHRpbmNsdWRlcy9fX2pzL2NhbF9hanhfbG9hZC93cGJjX2NhbF9hanguanNcclxuICogPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cclxuICovXHJcblxyXG4vLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuLy8gIEEgaiBhIHggICAgTCBvIGEgZCAgICBDIGEgbCBlIG4gZCBhIHIgICAgRCBhIHQgYVxyXG4vLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHJcbmZ1bmN0aW9uIHdwYmNfY2FsZW5kYXJfX2xvYWRfZGF0YV9fYWp4KCBwYXJhbXMgKXtcclxuXHJcblx0Ly9GaXhJbjogOS44LjYuMlxyXG5cdHdwYmNfY2FsZW5kYXJfX2xvYWRpbmdfX3N0YXJ0KCBwYXJhbXNbJ3Jlc291cmNlX2lkJ10gKTtcclxuXHRpZiAoIHdwYmNfYmFsYW5jZXJfX2lzX3dhaXQoIHBhcmFtcyAsICd3cGJjX2NhbGVuZGFyX19sb2FkX2RhdGFfX2FqeCcgKSApe1xyXG5cdFx0cmV0dXJuIGZhbHNlO1xyXG5cdH1cclxuXHJcblx0Ly9GaXhJbjogOS44LjYuMlxyXG5cdHdwYmNfY2FsZW5kYXJfX2JsdXJfX3N0b3AoIHBhcmFtc1sncmVzb3VyY2VfaWQnXSApO1xyXG5cclxuXHJcbi8vIGNvbnNvbGUuZ3JvdXBFbmQoKTsgY29uc29sZS50aW1lKCdyZXNvdXJjZV9pZF8nICsgcGFyYW1zWydyZXNvdXJjZV9pZCddKTtcclxuY29uc29sZS5ncm91cENvbGxhcHNlZCggJ1dQQkNfQUpYX0NBTEVOREFSX0xPQUQnICk7IGNvbnNvbGUubG9nKCAnID09IEJlZm9yZSBBamF4IFNlbmQgLSBjYWxlbmRhcnNfYWxsX19nZXQoKSA9PSAnICwgX3dwYmMuY2FsZW5kYXJzX2FsbF9fZ2V0KCkgKTtcclxuXHJcblx0Ly8gU3RhcnQgQWpheFxyXG5cdGpRdWVyeS5wb3N0KCB3cGJjX3VybF9hamF4LFxyXG5cdFx0XHRcdHtcclxuXHRcdFx0XHRcdGFjdGlvbiAgICAgICAgICA6ICdXUEJDX0FKWF9DQUxFTkRBUl9MT0FEJyxcclxuXHRcdFx0XHRcdHdwYmNfYWp4X3VzZXJfaWQ6IF93cGJjLmdldF9zZWN1cmVfcGFyYW0oICd1c2VyX2lkJyApLFxyXG5cdFx0XHRcdFx0bm9uY2UgICAgICAgICAgIDogX3dwYmMuZ2V0X3NlY3VyZV9wYXJhbSggJ25vbmNlJyApLFxyXG5cdFx0XHRcdFx0d3BiY19hanhfbG9jYWxlIDogX3dwYmMuZ2V0X3NlY3VyZV9wYXJhbSggJ2xvY2FsZScgKSxcclxuXHJcblx0XHRcdFx0XHRjYWxlbmRhcl9yZXF1ZXN0X3BhcmFtcyA6IHBhcmFtcyBcdFx0XHRcdFx0XHQvLyBVc3VhbGx5IGxpa2U6IHsgJ3Jlc291cmNlX2lkJzogMSwgJ21heF9kYXlzX2NvdW50JzogMzY1IH1cclxuXHRcdFx0XHR9LFxyXG5cclxuXHRcdFx0XHQvKipcclxuXHRcdFx0XHQgKiBTIHUgYyBjIGUgcyBzXHJcblx0XHRcdFx0ICpcclxuXHRcdFx0XHQgKiBAcGFyYW0gcmVzcG9uc2VfZGF0YVx0XHQtXHRpdHMgb2JqZWN0IHJldHVybmVkIGZyb20gIEFqYXggLSBjbGFzcy1saXZlLXNlYXJjaC5waHBcclxuXHRcdFx0XHQgKiBAcGFyYW0gdGV4dFN0YXR1c1x0XHQtXHQnc3VjY2VzcydcclxuXHRcdFx0XHQgKiBAcGFyYW0ganFYSFJcdFx0XHRcdC1cdE9iamVjdFxyXG5cdFx0XHRcdCAqL1xyXG5cdFx0XHRcdGZ1bmN0aW9uICggcmVzcG9uc2VfZGF0YSwgdGV4dFN0YXR1cywganFYSFIgKSB7XHJcbi8vIGNvbnNvbGUudGltZUVuZCgncmVzb3VyY2VfaWRfJyArIHJlc3BvbnNlX2RhdGFbJ3Jlc291cmNlX2lkJ10pO1xyXG5jb25zb2xlLmxvZyggJyA9PSBSZXNwb25zZSBXUEJDX0FKWF9DQUxFTkRBUl9MT0FEID09ICcsIHJlc3BvbnNlX2RhdGEgKTsgY29uc29sZS5ncm91cEVuZCgpO1xyXG5cclxuXHRcdFx0XHRcdC8vRml4SW46IDkuOC42LjJcclxuXHRcdFx0XHRcdHZhciBhanhfcG9zdF9kYXRhX19yZXNvdXJjZV9pZCA9IHdwYmNfZ2V0X3Jlc291cmNlX2lkX19mcm9tX2FqeF9wb3N0X2RhdGFfdXJsKCB0aGlzLmRhdGEgKTtcclxuXHRcdFx0XHRcdHdwYmNfYmFsYW5jZXJfX2NvbXBsZXRlZCggYWp4X3Bvc3RfZGF0YV9fcmVzb3VyY2VfaWQgLCAnd3BiY19jYWxlbmRhcl9fbG9hZF9kYXRhX19hangnICk7XHJcblxyXG5cdFx0XHRcdFx0Ly8gUHJvYmFibHkgRXJyb3JcclxuXHRcdFx0XHRcdGlmICggKHR5cGVvZiByZXNwb25zZV9kYXRhICE9PSAnb2JqZWN0JykgfHwgKHJlc3BvbnNlX2RhdGEgPT09IG51bGwpICl7XHJcblxyXG5cdFx0XHRcdFx0XHR2YXIganFfbm9kZSAgPSB3cGJjX2dldF9jYWxlbmRhcl9fanFfbm9kZV9fZm9yX21lc3NhZ2VzKCB0aGlzLmRhdGEgKTtcclxuXHRcdFx0XHRcdFx0dmFyIG1lc3NhZ2VfdHlwZSA9ICdpbmZvJztcclxuXHJcblx0XHRcdFx0XHRcdGlmICggJycgPT09IHJlc3BvbnNlX2RhdGEgKXtcclxuXHRcdFx0XHRcdFx0XHRyZXNwb25zZV9kYXRhID0gJ1RoZSBzZXJ2ZXIgcmVzcG9uZHMgd2l0aCBhbiBlbXB0eSBzdHJpbmcuIFRoZSBzZXJ2ZXIgcHJvYmFibHkgc3RvcHBlZCB3b3JraW5nIHVuZXhwZWN0ZWRseS4gPGJyPlBsZWFzZSBjaGVjayB5b3VyIDxzdHJvbmc+ZXJyb3IubG9nPC9zdHJvbmc+IGluIHlvdXIgc2VydmVyIGNvbmZpZ3VyYXRpb24gZm9yIHJlbGF0aXZlIGVycm9ycy4nO1xyXG5cdFx0XHRcdFx0XHRcdG1lc3NhZ2VfdHlwZSA9ICd3YXJuaW5nJztcclxuXHRcdFx0XHRcdFx0fVxyXG5cclxuXHRcdFx0XHRcdFx0Ly8gU2hvdyBNZXNzYWdlXHJcblx0XHRcdFx0XHRcdHdwYmNfZnJvbnRfZW5kX19zaG93X21lc3NhZ2UoIHJlc3BvbnNlX2RhdGEgLCB7ICd0eXBlJyAgICAgOiBtZXNzYWdlX3R5cGUsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCdzaG93X2hlcmUnOiB7J2pxX25vZGUnOiBqcV9ub2RlLCAnd2hlcmUnOiAnYWZ0ZXInfSxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J2lzX2FwcGVuZCc6IHRydWUsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCdzdHlsZScgICAgOiAndGV4dC1hbGlnbjpsZWZ0OycsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCdkZWxheScgICAgOiAwXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHR9ICk7XHJcblx0XHRcdFx0XHRcdHJldHVybjtcclxuXHRcdFx0XHRcdH1cclxuXHJcblx0XHRcdFx0XHQvLyBTaG93IENhbGVuZGFyXHJcblx0XHRcdFx0XHR3cGJjX2NhbGVuZGFyX19sb2FkaW5nX19zdG9wKCByZXNwb25zZV9kYXRhWyAncmVzb3VyY2VfaWQnIF0gKTtcclxuXHJcblx0XHRcdFx0XHQvLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblx0XHRcdFx0XHQvLyBCb29raW5ncyAtIERhdGVzXHJcblx0XHRcdFx0XHRfd3BiYy5ib29raW5nc19pbl9jYWxlbmRhcl9fc2V0X2RhdGVzKCAgcmVzcG9uc2VfZGF0YVsgJ3Jlc291cmNlX2lkJyBdLCByZXNwb25zZV9kYXRhWyAnYWp4X2RhdGEnIF1bJ2RhdGVzJ10gICk7XHJcblxyXG5cdFx0XHRcdFx0Ly8gQm9va2luZ3MgLSBDaGlsZCBvciBvbmx5IHNpbmdsZSBib29raW5nIHJlc291cmNlIGluIGRhdGVzXHJcblx0XHRcdFx0XHRfd3BiYy5ib29raW5nX19zZXRfcGFyYW1fdmFsdWUoIHJlc3BvbnNlX2RhdGFbICdyZXNvdXJjZV9pZCcgXSwgJ3Jlc291cmNlc19pZF9hcnJfX2luX2RhdGVzJywgcmVzcG9uc2VfZGF0YVsgJ2FqeF9kYXRhJyBdWyAncmVzb3VyY2VzX2lkX2Fycl9faW5fZGF0ZXMnIF0gKTtcclxuXHJcblx0XHRcdFx0XHQvLyBBZ2dyZWdhdGUgYm9va2luZyByZXNvdXJjZXMsICBpZiBhbnkgP1xyXG5cdFx0XHRcdFx0X3dwYmMuYm9va2luZ19fc2V0X3BhcmFtX3ZhbHVlKCByZXNwb25zZV9kYXRhWyAncmVzb3VyY2VfaWQnIF0sICdhZ2dyZWdhdGVfcmVzb3VyY2VfaWRfYXJyJywgcmVzcG9uc2VfZGF0YVsgJ2FqeF9kYXRhJyBdWyAnYWdncmVnYXRlX3Jlc291cmNlX2lkX2FycicgXSApO1xyXG5cdFx0XHRcdFx0Ly8gLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cclxuXHRcdFx0XHRcdC8vIFVwZGF0ZSBjYWxlbmRhclxyXG5cdFx0XHRcdFx0d3BiY19jYWxlbmRhcl9fdXBkYXRlX2xvb2soIHJlc3BvbnNlX2RhdGFbICdyZXNvdXJjZV9pZCcgXSApO1xyXG5cclxuXHJcblx0XHRcdFx0XHRpZiAoXHJcblx0XHRcdFx0XHRcdFx0KCAndW5kZWZpbmVkJyAhPT0gdHlwZW9mIChyZXNwb25zZV9kYXRhWyAnYWp4X2RhdGEnIF1bICdhanhfYWZ0ZXJfYWN0aW9uX21lc3NhZ2UnIF0pIClcclxuXHRcdFx0XHRcdFx0ICYmICggJycgIT0gcmVzcG9uc2VfZGF0YVsgJ2FqeF9kYXRhJyBdWyAnYWp4X2FmdGVyX2FjdGlvbl9tZXNzYWdlJyBdLnJlcGxhY2UoIC9cXG4vZywgXCI8YnIgLz5cIiApIClcclxuXHRcdFx0XHRcdCl7XHJcblxyXG5cdFx0XHRcdFx0XHR2YXIganFfbm9kZSAgPSB3cGJjX2dldF9jYWxlbmRhcl9fanFfbm9kZV9fZm9yX21lc3NhZ2VzKCB0aGlzLmRhdGEgKTtcclxuXHJcblx0XHRcdFx0XHRcdC8vIFNob3cgTWVzc2FnZVxyXG5cdFx0XHRcdFx0XHR3cGJjX2Zyb250X2VuZF9fc2hvd19tZXNzYWdlKCByZXNwb25zZV9kYXRhWyAnYWp4X2RhdGEnIF1bICdhanhfYWZ0ZXJfYWN0aW9uX21lc3NhZ2UnIF0ucmVwbGFjZSggL1xcbi9nLCBcIjxiciAvPlwiICksXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHR7ICAgJ3R5cGUnICAgICA6ICggJ3VuZGVmaW5lZCcgIT09IHR5cGVvZiggcmVzcG9uc2VfZGF0YVsgJ2FqeF9kYXRhJyBdWyAnYWp4X2FmdGVyX2FjdGlvbl9tZXNzYWdlX3N0YXR1cycgXSApIClcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0ICA/IHJlc3BvbnNlX2RhdGFbICdhanhfZGF0YScgXVsgJ2FqeF9hZnRlcl9hY3Rpb25fbWVzc2FnZV9zdGF0dXMnIF0gOiAnaW5mbycsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCdzaG93X2hlcmUnOiB7J2pxX25vZGUnOiBqcV9ub2RlLCAnd2hlcmUnOiAnYWZ0ZXInfSxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J2lzX2FwcGVuZCc6IHRydWUsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCdzdHlsZScgICAgOiAndGV4dC1hbGlnbjpsZWZ0OycsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCdkZWxheScgICAgOiAxMDAwMFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0fSApO1xyXG5cdFx0XHRcdFx0fVxyXG5cclxuXHRcdFx0XHRcdC8vIFRyaWdnZXIgZXZlbnQgdGhhdCBjYWxlbmRhciBoYXMgYmVlblx0XHQgLy9GaXhJbjogMTAuMC4wLjQ0XHJcblx0XHRcdFx0XHRpZiAoIGpRdWVyeSggJyNjYWxlbmRhcl9ib29raW5nJyArIHJlc3BvbnNlX2RhdGFbICdyZXNvdXJjZV9pZCcgXSApLmxlbmd0aCA+IDAgKXtcclxuXHRcdFx0XHRcdFx0dmFyIHRhcmdldF9lbG0gPSBqUXVlcnkoICdib2R5JyApLnRyaWdnZXIoIFwid3BiY19jYWxlbmRhcl9hanhfX2xvYWRlZF9kYXRhXCIsIFtyZXNwb25zZV9kYXRhWyAncmVzb3VyY2VfaWQnIF1dICk7XHJcblx0XHRcdFx0XHRcdCAvL2pRdWVyeSggJ2JvZHknICkub24oICd3cGJjX2NhbGVuZGFyX2FqeF9fbG9hZGVkX2RhdGEnLCBmdW5jdGlvbiggZXZlbnQsIHJlc291cmNlX2lkICkgeyAuLi4gfSApO1xyXG5cdFx0XHRcdFx0fVxyXG5cclxuXHRcdFx0XHRcdC8valF1ZXJ5KCAnI2FqYXhfcmVzcG9uZCcgKS5odG1sKCByZXNwb25zZV9kYXRhICk7XHRcdC8vIEZvciBhYmlsaXR5IHRvIHNob3cgcmVzcG9uc2UsIGFkZCBzdWNoIERJViBlbGVtZW50IHRvIHBhZ2VcclxuXHRcdFx0XHR9XHJcblx0XHRcdCAgKS5mYWlsKCBmdW5jdGlvbiAoIGpxWEhSLCB0ZXh0U3RhdHVzLCBlcnJvclRocm93biApIHsgICAgaWYgKCB3aW5kb3cuY29uc29sZSAmJiB3aW5kb3cuY29uc29sZS5sb2cgKXsgY29uc29sZS5sb2coICdBamF4X0Vycm9yJywganFYSFIsIHRleHRTdGF0dXMsIGVycm9yVGhyb3duICk7IH1cclxuXHJcblx0XHRcdFx0XHR2YXIgYWp4X3Bvc3RfZGF0YV9fcmVzb3VyY2VfaWQgPSB3cGJjX2dldF9yZXNvdXJjZV9pZF9fZnJvbV9hanhfcG9zdF9kYXRhX3VybCggdGhpcy5kYXRhICk7XHJcblx0XHRcdFx0XHR3cGJjX2JhbGFuY2VyX19jb21wbGV0ZWQoIGFqeF9wb3N0X2RhdGFfX3Jlc291cmNlX2lkICwgJ3dwYmNfY2FsZW5kYXJfX2xvYWRfZGF0YV9fYWp4JyApO1xyXG5cclxuXHRcdFx0XHRcdC8vIEdldCBDb250ZW50IG9mIEVycm9yIE1lc3NhZ2VcclxuXHRcdFx0XHRcdHZhciBlcnJvcl9tZXNzYWdlID0gJzxzdHJvbmc+JyArICdFcnJvciEnICsgJzwvc3Ryb25nPiAnICsgZXJyb3JUaHJvd24gO1xyXG5cdFx0XHRcdFx0aWYgKCBqcVhIUi5zdGF0dXMgKXtcclxuXHRcdFx0XHRcdFx0ZXJyb3JfbWVzc2FnZSArPSAnICg8Yj4nICsganFYSFIuc3RhdHVzICsgJzwvYj4pJztcclxuXHRcdFx0XHRcdFx0aWYgKDQwMyA9PSBqcVhIUi5zdGF0dXMgKXtcclxuXHRcdFx0XHRcdFx0XHRlcnJvcl9tZXNzYWdlICs9ICc8YnI+IFByb2JhYmx5IG5vbmNlIGZvciB0aGlzIHBhZ2UgaGFzIGJlZW4gZXhwaXJlZC4gUGxlYXNlIDxhIGhyZWY9XCJqYXZhc2NyaXB0OnZvaWQoMClcIiBvbmNsaWNrPVwiamF2YXNjcmlwdDpsb2NhdGlvbi5yZWxvYWQoKTtcIj5yZWxvYWQgdGhlIHBhZ2U8L2E+Lic7XHJcblx0XHRcdFx0XHRcdFx0ZXJyb3JfbWVzc2FnZSArPSAnPGJyPiBPdGhlcndpc2UsIHBsZWFzZSBjaGVjayB0aGlzIDxhIHN0eWxlPVwiZm9udC13ZWlnaHQ6IDYwMDtcIiBocmVmPVwiaHR0cHM6Ly93cGJvb2tpbmdjYWxlbmRhci5jb20vZmFxL3JlcXVlc3QtZG8tbm90LXBhc3Mtc2VjdXJpdHktY2hlY2svP2FmdGVyX3VwZGF0ZT0xMC4xLjFcIj50cm91Ymxlc2hvb3RpbmcgaW5zdHJ1Y3Rpb248L2E+Ljxicj4nXHJcblx0XHRcdFx0XHRcdH1cclxuXHRcdFx0XHRcdH1cclxuXHRcdFx0XHRcdHZhciBtZXNzYWdlX3Nob3dfZGVsYXkgPSAzMDAwO1xyXG5cdFx0XHRcdFx0aWYgKCBqcVhIUi5yZXNwb25zZVRleHQgKXtcclxuXHRcdFx0XHRcdFx0ZXJyb3JfbWVzc2FnZSArPSAnICcgKyBqcVhIUi5yZXNwb25zZVRleHQ7XHJcblx0XHRcdFx0XHRcdG1lc3NhZ2Vfc2hvd19kZWxheSA9IDEwO1xyXG5cdFx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0ZXJyb3JfbWVzc2FnZSA9IGVycm9yX21lc3NhZ2UucmVwbGFjZSggL1xcbi9nLCBcIjxiciAvPlwiICk7XHJcblxyXG5cdFx0XHRcdFx0dmFyIGpxX25vZGUgID0gd3BiY19nZXRfY2FsZW5kYXJfX2pxX25vZGVfX2Zvcl9tZXNzYWdlcyggdGhpcy5kYXRhICk7XHJcblxyXG5cdFx0XHRcdFx0LyoqXHJcblx0XHRcdFx0XHQgKiBJZiB3ZSBtYWtlIGZhc3QgY2xpY2tpbmcgb24gZGlmZmVyZW50IHBhZ2VzLFxyXG5cdFx0XHRcdFx0ICogdGhlbiB1bmRlciBjYWxlbmRhciB3aWxsIHNob3cgZXJyb3IgbWVzc2FnZSB3aXRoICBlbXB0eSAgdGV4dCwgYmVjYXVzZSBhamF4IHdhcyBub3QgcmVjZWl2ZWQuXHJcblx0XHRcdFx0XHQgKiBUbyAgbm90IHNob3cgc3VjaCB3YXJuaW5ncyB3ZSBhcmUgc2V0IGRlbGF5ICBpbiAzIHNlY29uZHMuICB2YXIgbWVzc2FnZV9zaG93X2RlbGF5ID0gMzAwMDtcclxuXHRcdFx0XHRcdCAqL1xyXG5cdFx0XHRcdFx0dmFyIGNsb3NlZF90aW1lciA9IHNldFRpbWVvdXQoIGZ1bmN0aW9uICgpe1xyXG5cclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQvLyBTaG93IE1lc3NhZ2VcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHR3cGJjX2Zyb250X2VuZF9fc2hvd19tZXNzYWdlKCBlcnJvcl9tZXNzYWdlICwgeyAndHlwZScgICAgIDogJ2Vycm9yJyxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnc2hvd19oZXJlJzogeydqcV9ub2RlJzoganFfbm9kZSwgJ3doZXJlJzogJ2FmdGVyJ30sXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J2lzX2FwcGVuZCc6IHRydWUsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J3N0eWxlJyAgICA6ICd0ZXh0LWFsaWduOmxlZnQ7JyxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnY3NzX2NsYXNzJzond3BiY19mZV9tZXNzYWdlX2FsdCcsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J2RlbGF5JyAgICA6IDBcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0fSApO1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0ICAgfSAsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQgICBwYXJzZUludCggbWVzc2FnZV9zaG93X2RlbGF5ICkgICApO1xyXG5cclxuXHRcdFx0ICB9KVxyXG5cdCAgICAgICAgICAvLyAuZG9uZSggICBmdW5jdGlvbiAoIGRhdGEsIHRleHRTdGF0dXMsIGpxWEhSICkgeyAgIGlmICggd2luZG93LmNvbnNvbGUgJiYgd2luZG93LmNvbnNvbGUubG9nICl7IGNvbnNvbGUubG9nKCAnc2Vjb25kIHN1Y2Nlc3MnLCBkYXRhLCB0ZXh0U3RhdHVzLCBqcVhIUiApOyB9ICAgIH0pXHJcblx0XHRcdCAgLy8gLmFsd2F5cyggZnVuY3Rpb24gKCBkYXRhX2pxWEhSLCB0ZXh0U3RhdHVzLCBqcVhIUl9lcnJvclRocm93biApIHsgICBpZiAoIHdpbmRvdy5jb25zb2xlICYmIHdpbmRvdy5jb25zb2xlLmxvZyApeyBjb25zb2xlLmxvZyggJ2Fsd2F5cyBmaW5pc2hlZCcsIGRhdGFfanFYSFIsIHRleHRTdGF0dXMsIGpxWEhSX2Vycm9yVGhyb3duICk7IH0gICAgIH0pXHJcblx0XHRcdCAgOyAgLy8gRW5kIEFqYXhcclxufVxyXG5cclxuXHJcblxyXG4vLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuLy8gU3VwcG9ydFxyXG4vLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHJcblx0LyoqXHJcblx0ICogR2V0IENhbGVuZGFyIGpRdWVyeSBub2RlIGZvciBzaG93aW5nIG1lc3NhZ2VzIGR1cmluZyBBamF4XHJcblx0ICogVGhpcyBwYXJhbWV0ZXI6ICAgY2FsZW5kYXJfcmVxdWVzdF9wYXJhbXNbcmVzb3VyY2VfaWRdICAgcGFyc2VkIGZyb20gdGhpcy5kYXRhIEFqYXggcG9zdCAgZGF0YVxyXG5cdCAqXHJcblx0ICogQHBhcmFtIGFqeF9wb3N0X2RhdGFfdXJsX3BhcmFtc1x0XHQgJ2FjdGlvbj1XUEJDX0FKWF9DQUxFTkRBUl9MT0FELi4uJmNhbGVuZGFyX3JlcXVlc3RfcGFyYW1zJTVCcmVzb3VyY2VfaWQlNUQ9MiZjYWxlbmRhcl9yZXF1ZXN0X3BhcmFtcyU1QmJvb2tpbmdfaGFzaCU1RD0mY2FsZW5kYXJfcmVxdWVzdF9wYXJhbXMnXHJcblx0ICogQHJldHVybnMge3N0cmluZ31cdCcnI2NhbGVuZGFyX2Jvb2tpbmcxJyAgfCAgICcuYm9va2luZ19mb3JtX2RpdicgLi4uXHJcblx0ICpcclxuXHQgKiBFeGFtcGxlICAgIHZhciBqcV9ub2RlICA9IHdwYmNfZ2V0X2NhbGVuZGFyX19qcV9ub2RlX19mb3JfbWVzc2FnZXMoIHRoaXMuZGF0YSApO1xyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfZ2V0X2NhbGVuZGFyX19qcV9ub2RlX19mb3JfbWVzc2FnZXMoIGFqeF9wb3N0X2RhdGFfdXJsX3BhcmFtcyApe1xyXG5cclxuXHRcdHZhciBqcV9ub2RlID0gJy5ib29raW5nX2Zvcm1fZGl2JztcclxuXHJcblx0XHR2YXIgY2FsZW5kYXJfcmVzb3VyY2VfaWQgPSB3cGJjX2dldF9yZXNvdXJjZV9pZF9fZnJvbV9hanhfcG9zdF9kYXRhX3VybCggYWp4X3Bvc3RfZGF0YV91cmxfcGFyYW1zICk7XHJcblxyXG5cdFx0aWYgKCBjYWxlbmRhcl9yZXNvdXJjZV9pZCA+IDAgKXtcclxuXHRcdFx0anFfbm9kZSA9ICcjY2FsZW5kYXJfYm9va2luZycgKyBjYWxlbmRhcl9yZXNvdXJjZV9pZDtcclxuXHRcdH1cclxuXHJcblx0XHRyZXR1cm4ganFfbm9kZTtcclxuXHR9XHJcblxyXG5cclxuXHQvKipcclxuXHQgKiBHZXQgcmVzb3VyY2UgSUQgZnJvbSBhanggcG9zdCBkYXRhIHVybCAgIHVzdWFsbHkgIGZyb20gIHRoaXMuZGF0YSAgPSAnYWN0aW9uPVdQQkNfQUpYX0NBTEVOREFSX0xPQUQuLi4mY2FsZW5kYXJfcmVxdWVzdF9wYXJhbXMlNUJyZXNvdXJjZV9pZCU1RD0yJmNhbGVuZGFyX3JlcXVlc3RfcGFyYW1zJTVCYm9va2luZ19oYXNoJTVEPSZjYWxlbmRhcl9yZXF1ZXN0X3BhcmFtcydcclxuXHQgKlxyXG5cdCAqIEBwYXJhbSBhanhfcG9zdF9kYXRhX3VybF9wYXJhbXNcdFx0ICdhY3Rpb249V1BCQ19BSlhfQ0FMRU5EQVJfTE9BRC4uLiZjYWxlbmRhcl9yZXF1ZXN0X3BhcmFtcyU1QnJlc291cmNlX2lkJTVEPTImY2FsZW5kYXJfcmVxdWVzdF9wYXJhbXMlNUJib29raW5nX2hhc2glNUQ9JmNhbGVuZGFyX3JlcXVlc3RfcGFyYW1zJ1xyXG5cdCAqIEByZXR1cm5zIHtpbnR9XHRcdFx0XHRcdFx0IDEgfCAwICAoaWYgZXJycm9yIHRoZW4gIDApXHJcblx0ICpcclxuXHQgKiBFeGFtcGxlICAgIHZhciBqcV9ub2RlICA9IHdwYmNfZ2V0X2NhbGVuZGFyX19qcV9ub2RlX19mb3JfbWVzc2FnZXMoIHRoaXMuZGF0YSApO1xyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfZ2V0X3Jlc291cmNlX2lkX19mcm9tX2FqeF9wb3N0X2RhdGFfdXJsKCBhanhfcG9zdF9kYXRhX3VybF9wYXJhbXMgKXtcclxuXHJcblx0XHQvLyBHZXQgYm9va2luZyByZXNvdXJjZSBJRCBmcm9tIEFqYXggUG9zdCBSZXF1ZXN0ICAtPiB0aGlzLmRhdGEgPSAnYWN0aW9uPVdQQkNfQUpYX0NBTEVOREFSX0xPQUQuLi4mY2FsZW5kYXJfcmVxdWVzdF9wYXJhbXMlNUJyZXNvdXJjZV9pZCU1RD0yJmNhbGVuZGFyX3JlcXVlc3RfcGFyYW1zJTVCYm9va2luZ19oYXNoJTVEPSZjYWxlbmRhcl9yZXF1ZXN0X3BhcmFtcydcclxuXHRcdHZhciBjYWxlbmRhcl9yZXNvdXJjZV9pZCA9IHdwYmNfZ2V0X3VyaV9wYXJhbV9ieV9uYW1lKCAnY2FsZW5kYXJfcmVxdWVzdF9wYXJhbXNbcmVzb3VyY2VfaWRdJywgYWp4X3Bvc3RfZGF0YV91cmxfcGFyYW1zICk7XHJcblx0XHRpZiAoIChudWxsICE9PSBjYWxlbmRhcl9yZXNvdXJjZV9pZCkgJiYgKCcnICE9PSBjYWxlbmRhcl9yZXNvdXJjZV9pZCkgKXtcclxuXHRcdFx0Y2FsZW5kYXJfcmVzb3VyY2VfaWQgPSBwYXJzZUludCggY2FsZW5kYXJfcmVzb3VyY2VfaWQgKTtcclxuXHRcdFx0aWYgKCBjYWxlbmRhcl9yZXNvdXJjZV9pZCA+IDAgKXtcclxuXHRcdFx0XHRyZXR1cm4gY2FsZW5kYXJfcmVzb3VyY2VfaWQ7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHRcdHJldHVybiAwO1xyXG5cdH1cclxuXHJcblxyXG5cdC8qKlxyXG5cdCAqIEdldCBwYXJhbWV0ZXIgZnJvbSBVUkwgIC0gIHBhcnNlIFVSTCBwYXJhbWV0ZXJzLCAgbGlrZSB0aGlzOiBhY3Rpb249V1BCQ19BSlhfQ0FMRU5EQVJfTE9BRC4uLiZjYWxlbmRhcl9yZXF1ZXN0X3BhcmFtcyU1QnJlc291cmNlX2lkJTVEPTImY2FsZW5kYXJfcmVxdWVzdF9wYXJhbXMlNUJib29raW5nX2hhc2glNUQ9JmNhbGVuZGFyX3JlcXVlc3RfcGFyYW1zXHJcblx0ICogQHBhcmFtIG5hbWUgIHBhcmFtZXRlciAgbmFtZSwgIGxpa2UgJ2NhbGVuZGFyX3JlcXVlc3RfcGFyYW1zW3Jlc291cmNlX2lkXSdcclxuXHQgKiBAcGFyYW0gdXJsXHQncGFyYW1ldGVyICBzdHJpbmcgVVJMJ1xyXG5cdCAqIEByZXR1cm5zIHtzdHJpbmd8bnVsbH0gICBwYXJhbWV0ZXIgdmFsdWVcclxuXHQgKlxyXG5cdCAqIEV4YW1wbGU6IFx0XHR3cGJjX2dldF91cmlfcGFyYW1fYnlfbmFtZSggJ2NhbGVuZGFyX3JlcXVlc3RfcGFyYW1zW3Jlc291cmNlX2lkXScsIHRoaXMuZGF0YSApOyAgLT4gJzInXHJcblx0ICovXHJcblx0ZnVuY3Rpb24gd3BiY19nZXRfdXJpX3BhcmFtX2J5X25hbWUoIG5hbWUsIHVybCApe1xyXG5cclxuXHRcdHVybCA9IGRlY29kZVVSSUNvbXBvbmVudCggdXJsICk7XHJcblxyXG5cdFx0bmFtZSA9IG5hbWUucmVwbGFjZSggL1tcXFtcXF1dL2csICdcXFxcJCYnICk7XHJcblx0XHR2YXIgcmVnZXggPSBuZXcgUmVnRXhwKCAnWz8mXScgKyBuYW1lICsgJyg9KFteJiNdKil8JnwjfCQpJyApLFxyXG5cdFx0XHRyZXN1bHRzID0gcmVnZXguZXhlYyggdXJsICk7XHJcblx0XHRpZiAoICFyZXN1bHRzICkgcmV0dXJuIG51bGw7XHJcblx0XHRpZiAoICFyZXN1bHRzWyAyIF0gKSByZXR1cm4gJyc7XHJcblx0XHRyZXR1cm4gZGVjb2RlVVJJQ29tcG9uZW50KCByZXN1bHRzWyAyIF0ucmVwbGFjZSggL1xcKy9nLCAnICcgKSApO1xyXG5cdH1cclxuIiwiLyoqXHJcbiAqID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxyXG4gKlx0aW5jbHVkZXMvX19qcy9mcm9udF9lbmRfbWVzc2FnZXMvd3BiY19mZV9tZXNzYWdlcy5qc1xyXG4gKiA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cclxuICovXHJcblxyXG4vLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuLy8gU2hvdyBNZXNzYWdlcyBhdCBGcm9udC1FZG4gc2lkZVxyXG4vLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHJcbi8qKlxyXG4gKiBTaG93IG1lc3NhZ2UgaW4gY29udGVudFxyXG4gKlxyXG4gKiBAcGFyYW0gbWVzc2FnZVx0XHRcdFx0TWVzc2FnZSBIVE1MXHJcbiAqIEBwYXJhbSBwYXJhbXMgPSB7XHJcbiAqXHRcdFx0XHRcdFx0XHRcdCd0eXBlJyAgICAgOiAnd2FybmluZycsXHRcdFx0XHRcdFx0XHQvLyAnZXJyb3InIHwgJ3dhcm5pbmcnIHwgJ2luZm8nIHwgJ3N1Y2Nlc3MnXHJcbiAqXHRcdFx0XHRcdFx0XHRcdCdzaG93X2hlcmUnIDoge1xyXG4gKlx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J2pxX25vZGUnIDogJycsXHRcdFx0XHQvLyBhbnkgalF1ZXJ5IG5vZGUgZGVmaW5pdGlvblxyXG4gKlx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J3doZXJlJyAgIDogJ2luc2lkZSdcdFx0Ly8gJ2luc2lkZScgfCAnYmVmb3JlJyB8ICdhZnRlcicgfCAncmlnaHQnIHwgJ2xlZnQnXHJcbiAqXHRcdFx0XHRcdFx0XHRcdFx0XHRcdCAgfSxcclxuICpcdFx0XHRcdFx0XHRcdFx0J2lzX2FwcGVuZCc6IHRydWUsXHRcdFx0XHRcdFx0XHRcdC8vIEFwcGx5ICBvbmx5IGlmIFx0J3doZXJlJyAgIDogJ2luc2lkZSdcclxuICpcdFx0XHRcdFx0XHRcdFx0J3N0eWxlJyAgICA6ICd0ZXh0LWFsaWduOmxlZnQ7JyxcdFx0XHRcdC8vIHN0eWxlcywgaWYgbmVlZGVkXHJcbiAqXHRcdFx0XHRcdFx0XHQgICAgJ2Nzc19jbGFzcyc6ICcnLFx0XHRcdFx0XHRcdFx0XHQvLyBGb3IgZXhhbXBsZSBjYW4gIGJlOiAnd3BiY19mZV9tZXNzYWdlX2FsdCdcclxuICpcdFx0XHRcdFx0XHRcdFx0J2RlbGF5JyAgICA6IDAsXHRcdFx0XHRcdFx0XHRcdFx0Ly8gaG93IG1hbnkgbWljcm9zZWNvbmQgdG8gIHNob3csICBpZiAwICB0aGVuICBzaG93IGZvcmV2ZXJcclxuICpcdFx0XHRcdFx0XHRcdFx0J2lmX3Zpc2libGVfbm90X3Nob3cnOiBmYWxzZVx0XHRcdFx0XHQvLyBpZiB0cnVlLCAgdGhlbiBkbyBub3Qgc2hvdyBtZXNzYWdlLCAgaWYgcHJldmlvcyBtZXNzYWdlIHdhcyBub3QgaGlkZWQgKG5vdCBhcHBseSBpZiAnd2hlcmUnICAgOiAnaW5zaWRlJyApXHJcbiAqXHRcdFx0XHR9O1xyXG4gKiBFeGFtcGxlczpcclxuICogXHRcdFx0dmFyIGh0bWxfaWQgPSB3cGJjX2Zyb250X2VuZF9fc2hvd19tZXNzYWdlKCAnWW91IGNhbiB0ZXN0IGRheXMgc2VsZWN0aW9uIGluIGNhbGVuZGFyJywge30gKTtcclxuICpcclxuICpcdFx0XHR2YXIgbm90aWNlX21lc3NhZ2VfaWQgPSB3cGJjX2Zyb250X2VuZF9fc2hvd19tZXNzYWdlKCBfd3BiYy5nZXRfbWVzc2FnZSggJ21lc3NhZ2VfY2hlY2tfcmVxdWlyZWQnICksIHsgJ3R5cGUnOiAnd2FybmluZycsICdkZWxheSc6IDEwMDAwLCAnaWZfdmlzaWJsZV9ub3Rfc2hvdyc6IHRydWUsXHJcbiAqXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQgICdzaG93X2hlcmUnOiB7J3doZXJlJzogJ3JpZ2h0JywgJ2pxX25vZGUnOiBlbCx9IH0gKTtcclxuICpcclxuICpcdFx0XHR3cGJjX2Zyb250X2VuZF9fc2hvd19tZXNzYWdlKCByZXNwb25zZV9kYXRhWyAnYWp4X2RhdGEnIF1bICdhanhfYWZ0ZXJfYWN0aW9uX21lc3NhZ2UnIF0ucmVwbGFjZSggL1xcbi9nLCBcIjxiciAvPlwiICksXHJcbiAqXHRcdFx0XHRcdFx0XHRcdFx0XHRcdHsgICAndHlwZScgICAgIDogKCAndW5kZWZpbmVkJyAhPT0gdHlwZW9mKCByZXNwb25zZV9kYXRhWyAnYWp4X2RhdGEnIF1bICdhanhfYWZ0ZXJfYWN0aW9uX21lc3NhZ2Vfc3RhdHVzJyBdICkgKVxyXG4gKlx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCAgPyByZXNwb25zZV9kYXRhWyAnYWp4X2RhdGEnIF1bICdhanhfYWZ0ZXJfYWN0aW9uX21lc3NhZ2Vfc3RhdHVzJyBdIDogJ2luZm8nLFxyXG4gKlx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCdzaG93X2hlcmUnOiB7J2pxX25vZGUnOiBqcV9ub2RlLCAnd2hlcmUnOiAnYWZ0ZXInfSxcclxuICpcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnY3NzX2NsYXNzJzond3BiY19mZV9tZXNzYWdlX2FsdCcsXHJcbiAqXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J2RlbGF5JyAgICA6IDEwMDAwXHJcbiAqXHRcdFx0XHRcdFx0XHRcdFx0XHRcdH0gKTtcclxuICpcclxuICpcclxuICogQHJldHVybnMgc3RyaW5nICAtIEhUTUwgSURcdFx0b3IgMCBpZiBub3Qgc2hvd2luZyBkdXJpbmcgdGhpcyB0aW1lLlxyXG4gKi9cclxuZnVuY3Rpb24gd3BiY19mcm9udF9lbmRfX3Nob3dfbWVzc2FnZSggbWVzc2FnZSwgcGFyYW1zID0ge30gKXtcclxuXHJcblx0dmFyIHBhcmFtc19kZWZhdWx0ID0ge1xyXG5cdFx0XHRcdFx0XHRcdFx0J3R5cGUnICAgICA6ICd3YXJuaW5nJyxcdFx0XHRcdFx0XHRcdC8vICdlcnJvcicgfCAnd2FybmluZycgfCAnaW5mbycgfCAnc3VjY2VzcydcclxuXHRcdFx0XHRcdFx0XHRcdCdzaG93X2hlcmUnIDoge1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCdqcV9ub2RlJyA6ICcnLFx0XHRcdFx0Ly8gYW55IGpRdWVyeSBub2RlIGRlZmluaXRpb25cclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnd2hlcmUnICAgOiAnaW5zaWRlJ1x0XHQvLyAnaW5zaWRlJyB8ICdiZWZvcmUnIHwgJ2FmdGVyJyB8ICdyaWdodCcgfCAnbGVmdCdcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdCAgfSxcclxuXHRcdFx0XHRcdFx0XHRcdCdpc19hcHBlbmQnOiB0cnVlLFx0XHRcdFx0XHRcdFx0XHQvLyBBcHBseSAgb25seSBpZiBcdCd3aGVyZScgICA6ICdpbnNpZGUnXHJcblx0XHRcdFx0XHRcdFx0XHQnc3R5bGUnICAgIDogJ3RleHQtYWxpZ246bGVmdDsnLFx0XHRcdFx0Ly8gc3R5bGVzLCBpZiBuZWVkZWRcclxuXHRcdFx0XHRcdFx0XHQgICAgJ2Nzc19jbGFzcyc6ICcnLFx0XHRcdFx0XHRcdFx0XHQvLyBGb3IgZXhhbXBsZSBjYW4gIGJlOiAnd3BiY19mZV9tZXNzYWdlX2FsdCdcclxuXHRcdFx0XHRcdFx0XHRcdCdkZWxheScgICAgOiAwLFx0XHRcdFx0XHRcdFx0XHRcdC8vIGhvdyBtYW55IG1pY3Jvc2Vjb25kIHRvICBzaG93LCAgaWYgMCAgdGhlbiAgc2hvdyBmb3JldmVyXHJcblx0XHRcdFx0XHRcdFx0XHQnaWZfdmlzaWJsZV9ub3Rfc2hvdyc6IGZhbHNlLFx0XHRcdFx0XHQvLyBpZiB0cnVlLCAgdGhlbiBkbyBub3Qgc2hvdyBtZXNzYWdlLCAgaWYgcHJldmlvcyBtZXNzYWdlIHdhcyBub3QgaGlkZWQgKG5vdCBhcHBseSBpZiAnd2hlcmUnICAgOiAnaW5zaWRlJyApXHJcblx0XHRcdFx0XHRcdFx0XHQnaXNfc2Nyb2xsJzogdHJ1ZVx0XHRcdFx0XHRcdFx0XHQvLyBpcyBzY3JvbGwgIHRvICB0aGlzIGVsZW1lbnRcclxuXHRcdFx0XHRcdFx0fTtcclxuXHRmb3IgKCB2YXIgcF9rZXkgaW4gcGFyYW1zICl7XHJcblx0XHRwYXJhbXNfZGVmYXVsdFsgcF9rZXkgXSA9IHBhcmFtc1sgcF9rZXkgXTtcclxuXHR9XHJcblx0cGFyYW1zID0gcGFyYW1zX2RlZmF1bHQ7XHJcblxyXG4gICAgdmFyIHVuaXF1ZV9kaXZfaWQgPSBuZXcgRGF0ZSgpO1xyXG4gICAgdW5pcXVlX2Rpdl9pZCA9ICd3cGJjX25vdGljZV8nICsgdW5pcXVlX2Rpdl9pZC5nZXRUaW1lKCk7XHJcblxyXG5cdHBhcmFtc1snY3NzX2NsYXNzJ10gKz0gJyB3cGJjX2ZlX21lc3NhZ2UnO1xyXG5cdGlmICggcGFyYW1zWyd0eXBlJ10gPT0gJ2Vycm9yJyApe1xyXG5cdFx0cGFyYW1zWydjc3NfY2xhc3MnXSArPSAnIHdwYmNfZmVfbWVzc2FnZV9lcnJvcic7XHJcblx0XHRtZXNzYWdlID0gJzxpIGNsYXNzPVwibWVudV9pY29uIGljb24tMXggd3BiY19pY25fcmVwb3J0X2dtYWlsZXJyb3JyZWRcIj48L2k+JyArIG1lc3NhZ2U7XHJcblx0fVxyXG5cdGlmICggcGFyYW1zWyd0eXBlJ10gPT0gJ3dhcm5pbmcnICl7XHJcblx0XHRwYXJhbXNbJ2Nzc19jbGFzcyddICs9ICcgd3BiY19mZV9tZXNzYWdlX3dhcm5pbmcnO1xyXG5cdFx0bWVzc2FnZSA9ICc8aSBjbGFzcz1cIm1lbnVfaWNvbiBpY29uLTF4IHdwYmNfaWNuX3dhcm5pbmdcIj48L2k+JyArIG1lc3NhZ2U7XHJcblx0fVxyXG5cdGlmICggcGFyYW1zWyd0eXBlJ10gPT0gJ2luZm8nICl7XHJcblx0XHRwYXJhbXNbJ2Nzc19jbGFzcyddICs9ICcgd3BiY19mZV9tZXNzYWdlX2luZm8nO1xyXG5cdH1cclxuXHRpZiAoIHBhcmFtc1sndHlwZSddID09ICdzdWNjZXNzJyApe1xyXG5cdFx0cGFyYW1zWydjc3NfY2xhc3MnXSArPSAnIHdwYmNfZmVfbWVzc2FnZV9zdWNjZXNzJztcclxuXHRcdG1lc3NhZ2UgPSAnPGkgY2xhc3M9XCJtZW51X2ljb24gaWNvbi0xeCB3cGJjX2ljbl9kb25lX291dGxpbmVcIj48L2k+JyArIG1lc3NhZ2U7XHJcblx0fVxyXG5cclxuXHR2YXIgc2Nyb2xsX3RvX2VsZW1lbnQgPSAnPGRpdiBpZD1cIicgKyB1bmlxdWVfZGl2X2lkICsgJ19zY3JvbGxcIiBzdHlsZT1cImRpc3BsYXk6bm9uZTtcIj48L2Rpdj4nO1xyXG5cdG1lc3NhZ2UgPSAnPGRpdiBpZD1cIicgKyB1bmlxdWVfZGl2X2lkICsgJ1wiIGNsYXNzPVwid3BiY19mcm9udF9lbmRfX21lc3NhZ2UgJyArIHBhcmFtc1snY3NzX2NsYXNzJ10gKyAnXCIgc3R5bGU9XCInICsgcGFyYW1zWyAnc3R5bGUnIF0gKyAnXCI+JyArIG1lc3NhZ2UgKyAnPC9kaXY+JztcclxuXHJcblxyXG5cdHZhciBqcV9lbF9tZXNzYWdlID0gZmFsc2U7XHJcblx0dmFyIGlzX3Nob3dfbWVzc2FnZSA9IHRydWU7XHJcblxyXG5cdGlmICggJ2luc2lkZScgPT09IHBhcmFtc1sgJ3Nob3dfaGVyZScgXVsgJ3doZXJlJyBdICl7XHJcblxyXG5cdFx0aWYgKCBwYXJhbXNbICdpc19hcHBlbmQnIF0gKXtcclxuXHRcdFx0alF1ZXJ5KCBwYXJhbXNbICdzaG93X2hlcmUnIF1bICdqcV9ub2RlJyBdICkuYXBwZW5kKCBzY3JvbGxfdG9fZWxlbWVudCApO1xyXG5cdFx0XHRqUXVlcnkoIHBhcmFtc1sgJ3Nob3dfaGVyZScgXVsgJ2pxX25vZGUnIF0gKS5hcHBlbmQoIG1lc3NhZ2UgKTtcclxuXHRcdH0gZWxzZSB7XHJcblx0XHRcdGpRdWVyeSggcGFyYW1zWyAnc2hvd19oZXJlJyBdWyAnanFfbm9kZScgXSApLmh0bWwoIHNjcm9sbF90b19lbGVtZW50ICsgbWVzc2FnZSApO1xyXG5cdFx0fVxyXG5cclxuXHR9IGVsc2UgaWYgKCAnYmVmb3JlJyA9PT0gcGFyYW1zWyAnc2hvd19oZXJlJyBdWyAnd2hlcmUnIF0gKXtcclxuXHJcblx0XHRqcV9lbF9tZXNzYWdlID0galF1ZXJ5KCBwYXJhbXNbICdzaG93X2hlcmUnIF1bICdqcV9ub2RlJyBdICkuc2libGluZ3MoICdbaWRePVwid3BiY19ub3RpY2VfXCJdJyApO1xyXG5cdFx0aWYgKCAocGFyYW1zWyAnaWZfdmlzaWJsZV9ub3Rfc2hvdycgXSkgJiYgKGpxX2VsX21lc3NhZ2UuaXMoICc6dmlzaWJsZScgKSkgKXtcclxuXHRcdFx0aXNfc2hvd19tZXNzYWdlID0gZmFsc2U7XHJcblx0XHRcdHVuaXF1ZV9kaXZfaWQgPSBqUXVlcnkoIGpxX2VsX21lc3NhZ2UuZ2V0KCAwICkgKS5hdHRyKCAnaWQnICk7XHJcblx0XHR9XHJcblx0XHRpZiAoIGlzX3Nob3dfbWVzc2FnZSApe1xyXG5cdFx0XHRqUXVlcnkoIHBhcmFtc1sgJ3Nob3dfaGVyZScgXVsgJ2pxX25vZGUnIF0gKS5iZWZvcmUoIHNjcm9sbF90b19lbGVtZW50ICk7XHJcblx0XHRcdGpRdWVyeSggcGFyYW1zWyAnc2hvd19oZXJlJyBdWyAnanFfbm9kZScgXSApLmJlZm9yZSggbWVzc2FnZSApO1xyXG5cdFx0fVxyXG5cclxuXHR9IGVsc2UgaWYgKCAnYWZ0ZXInID09PSBwYXJhbXNbICdzaG93X2hlcmUnIF1bICd3aGVyZScgXSApe1xyXG5cclxuXHRcdGpxX2VsX21lc3NhZ2UgPSBqUXVlcnkoIHBhcmFtc1sgJ3Nob3dfaGVyZScgXVsgJ2pxX25vZGUnIF0gKS5uZXh0QWxsKCAnW2lkXj1cIndwYmNfbm90aWNlX1wiXScgKTtcclxuXHRcdGlmICggKHBhcmFtc1sgJ2lmX3Zpc2libGVfbm90X3Nob3cnIF0pICYmIChqcV9lbF9tZXNzYWdlLmlzKCAnOnZpc2libGUnICkpICl7XHJcblx0XHRcdGlzX3Nob3dfbWVzc2FnZSA9IGZhbHNlO1xyXG5cdFx0XHR1bmlxdWVfZGl2X2lkID0galF1ZXJ5KCBqcV9lbF9tZXNzYWdlLmdldCggMCApICkuYXR0ciggJ2lkJyApO1xyXG5cdFx0fVxyXG5cdFx0aWYgKCBpc19zaG93X21lc3NhZ2UgKXtcclxuXHRcdFx0alF1ZXJ5KCBwYXJhbXNbICdzaG93X2hlcmUnIF1bICdqcV9ub2RlJyBdICkuYmVmb3JlKCBzY3JvbGxfdG9fZWxlbWVudCApO1x0XHQvLyBXZSBuZWVkIHRvICBzZXQgIGhlcmUgYmVmb3JlKGZvciBoYW5keSBzY3JvbGwpXHJcblx0XHRcdGpRdWVyeSggcGFyYW1zWyAnc2hvd19oZXJlJyBdWyAnanFfbm9kZScgXSApLmFmdGVyKCBtZXNzYWdlICk7XHJcblx0XHR9XHJcblxyXG5cdH0gZWxzZSBpZiAoICdyaWdodCcgPT09IHBhcmFtc1sgJ3Nob3dfaGVyZScgXVsgJ3doZXJlJyBdICl7XHJcblxyXG5cdFx0anFfZWxfbWVzc2FnZSA9IGpRdWVyeSggcGFyYW1zWyAnc2hvd19oZXJlJyBdWyAnanFfbm9kZScgXSApLm5leHRBbGwoICcud3BiY19mcm9udF9lbmRfX21lc3NhZ2VfY29udGFpbmVyX3JpZ2h0JyApLmZpbmQoICdbaWRePVwid3BiY19ub3RpY2VfXCJdJyApO1xyXG5cdFx0aWYgKCAocGFyYW1zWyAnaWZfdmlzaWJsZV9ub3Rfc2hvdycgXSkgJiYgKGpxX2VsX21lc3NhZ2UuaXMoICc6dmlzaWJsZScgKSkgKXtcclxuXHRcdFx0aXNfc2hvd19tZXNzYWdlID0gZmFsc2U7XHJcblx0XHRcdHVuaXF1ZV9kaXZfaWQgPSBqUXVlcnkoIGpxX2VsX21lc3NhZ2UuZ2V0KCAwICkgKS5hdHRyKCAnaWQnICk7XHJcblx0XHR9XHJcblx0XHRpZiAoIGlzX3Nob3dfbWVzc2FnZSApe1xyXG5cdFx0XHRqUXVlcnkoIHBhcmFtc1sgJ3Nob3dfaGVyZScgXVsgJ2pxX25vZGUnIF0gKS5iZWZvcmUoIHNjcm9sbF90b19lbGVtZW50ICk7XHRcdC8vIFdlIG5lZWQgdG8gIHNldCAgaGVyZSBiZWZvcmUoZm9yIGhhbmR5IHNjcm9sbClcclxuXHRcdFx0alF1ZXJ5KCBwYXJhbXNbICdzaG93X2hlcmUnIF1bICdqcV9ub2RlJyBdICkuYWZ0ZXIoICc8ZGl2IGNsYXNzPVwid3BiY19mcm9udF9lbmRfX21lc3NhZ2VfY29udGFpbmVyX3JpZ2h0XCI+JyArIG1lc3NhZ2UgKyAnPC9kaXY+JyApO1xyXG5cdFx0fVxyXG5cdH0gZWxzZSBpZiAoICdsZWZ0JyA9PT0gcGFyYW1zWyAnc2hvd19oZXJlJyBdWyAnd2hlcmUnIF0gKXtcclxuXHJcblx0XHRqcV9lbF9tZXNzYWdlID0galF1ZXJ5KCBwYXJhbXNbICdzaG93X2hlcmUnIF1bICdqcV9ub2RlJyBdICkuc2libGluZ3MoICcud3BiY19mcm9udF9lbmRfX21lc3NhZ2VfY29udGFpbmVyX2xlZnQnICkuZmluZCggJ1tpZF49XCJ3cGJjX25vdGljZV9cIl0nICk7XHJcblx0XHRpZiAoIChwYXJhbXNbICdpZl92aXNpYmxlX25vdF9zaG93JyBdKSAmJiAoanFfZWxfbWVzc2FnZS5pcyggJzp2aXNpYmxlJyApKSApe1xyXG5cdFx0XHRpc19zaG93X21lc3NhZ2UgPSBmYWxzZTtcclxuXHRcdFx0dW5pcXVlX2Rpdl9pZCA9IGpRdWVyeSgganFfZWxfbWVzc2FnZS5nZXQoIDAgKSApLmF0dHIoICdpZCcgKTtcclxuXHRcdH1cclxuXHRcdGlmICggaXNfc2hvd19tZXNzYWdlICl7XHJcblx0XHRcdGpRdWVyeSggcGFyYW1zWyAnc2hvd19oZXJlJyBdWyAnanFfbm9kZScgXSApLmJlZm9yZSggc2Nyb2xsX3RvX2VsZW1lbnQgKTtcdFx0Ly8gV2UgbmVlZCB0byAgc2V0ICBoZXJlIGJlZm9yZShmb3IgaGFuZHkgc2Nyb2xsKVxyXG5cdFx0XHRqUXVlcnkoIHBhcmFtc1sgJ3Nob3dfaGVyZScgXVsgJ2pxX25vZGUnIF0gKS5iZWZvcmUoICc8ZGl2IGNsYXNzPVwid3BiY19mcm9udF9lbmRfX21lc3NhZ2VfY29udGFpbmVyX2xlZnRcIj4nICsgbWVzc2FnZSArICc8L2Rpdj4nICk7XHJcblx0XHR9XHJcblx0fVxyXG5cclxuXHRpZiAoICAgKCBpc19zaG93X21lc3NhZ2UgKSAgJiYgICggcGFyc2VJbnQoIHBhcmFtc1sgJ2RlbGF5JyBdICkgPiAwICkgICApe1xyXG5cdFx0dmFyIGNsb3NlZF90aW1lciA9IHNldFRpbWVvdXQoIGZ1bmN0aW9uICgpe1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdGpRdWVyeSggJyMnICsgdW5pcXVlX2Rpdl9pZCApLmZhZGVPdXQoIDE1MDAgKTtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHR9ICwgcGFyc2VJbnQoIHBhcmFtc1sgJ2RlbGF5JyBdICkgICApO1xyXG5cclxuXHRcdHZhciBjbG9zZWRfdGltZXIyID0gc2V0VGltZW91dCggZnVuY3Rpb24gKCl7XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRqUXVlcnkoICcjJyArIHVuaXF1ZV9kaXZfaWQgKS50cmlnZ2VyKCAnaGlkZScgKTtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHR9LCAoIHBhcnNlSW50KCBwYXJhbXNbICdkZWxheScgXSApICsgMTUwMSApICk7XHJcblx0fVxyXG5cclxuXHQvLyBDaGVjayAgaWYgc2hvd2VkIG1lc3NhZ2UgaW4gc29tZSBoaWRkZW4gcGFyZW50IHNlY3Rpb24gYW5kIHNob3cgaXQuIEJ1dCBpdCBtdXN0ICBiZSBsb3dlciB0aGFuICcud3BiY19jb250YWluZXInXHJcblx0dmFyIHBhcmVudF9lbHMgPSBqUXVlcnkoICcjJyArIHVuaXF1ZV9kaXZfaWQgKS5wYXJlbnRzKCkubWFwKCBmdW5jdGlvbiAoKXtcclxuXHRcdGlmICggKCFqUXVlcnkoIHRoaXMgKS5pcyggJ3Zpc2libGUnICkpICYmIChqUXVlcnkoICcud3BiY19jb250YWluZXInICkuaGFzKCB0aGlzICkpICl7XHJcblx0XHRcdGpRdWVyeSggdGhpcyApLnNob3coKTtcclxuXHRcdH1cclxuXHR9ICk7XHJcblxyXG5cdGlmICggcGFyYW1zWyAnaXNfc2Nyb2xsJyBdICl7XHJcblx0XHR3cGJjX2RvX3Njcm9sbCggJyMnICsgdW5pcXVlX2Rpdl9pZCArICdfc2Nyb2xsJyApO1xyXG5cdH1cclxuXHJcblx0cmV0dXJuIHVuaXF1ZV9kaXZfaWQ7XHJcbn1cclxuXHJcblxyXG5cdC8qKlxyXG5cdCAqIEVycm9yIG1lc3NhZ2UuIFx0UHJlc2V0IG9mIHBhcmFtZXRlcnMgZm9yIHJlYWwgbWVzc2FnZSBmdW5jdGlvbi5cclxuXHQgKlxyXG5cdCAqIEBwYXJhbSBlbFx0XHQtIGFueSBqUXVlcnkgbm9kZSBkZWZpbml0aW9uXHJcblx0ICogQHBhcmFtIG1lc3NhZ2VcdC0gTWVzc2FnZSBIVE1MXHJcblx0ICogQHJldHVybnMgc3RyaW5nICAtIEhUTUwgSURcdFx0b3IgMCBpZiBub3Qgc2hvd2luZyBkdXJpbmcgdGhpcyB0aW1lLlxyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfZnJvbnRfZW5kX19zaG93X21lc3NhZ2VfX2Vycm9yKCBqcV9ub2RlLCBtZXNzYWdlICl7XHJcblxyXG5cdFx0dmFyIG5vdGljZV9tZXNzYWdlX2lkID0gd3BiY19mcm9udF9lbmRfX3Nob3dfbWVzc2FnZShcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRtZXNzYWdlLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdHtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCd0eXBlJyAgICAgICAgICAgICAgIDogJ2Vycm9yJyxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCdkZWxheScgICAgICAgICAgICAgIDogMTAwMDAsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnaWZfdmlzaWJsZV9ub3Rfc2hvdyc6IHRydWUsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnc2hvd19oZXJlJyAgICAgICAgICA6IHtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCd3aGVyZScgIDogJ3JpZ2h0JyxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCdqcV9ub2RlJzoganFfbm9kZVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCAgIH1cclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHR9XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQpO1xyXG5cdFx0cmV0dXJuIG5vdGljZV9tZXNzYWdlX2lkO1xyXG5cdH1cclxuXHJcblxyXG5cdC8qKlxyXG5cdCAqIEVycm9yIG1lc3NhZ2UgVU5ERVIgZWxlbWVudC4gXHRQcmVzZXQgb2YgcGFyYW1ldGVycyBmb3IgcmVhbCBtZXNzYWdlIGZ1bmN0aW9uLlxyXG5cdCAqXHJcblx0ICogQHBhcmFtIGVsXHRcdC0gYW55IGpRdWVyeSBub2RlIGRlZmluaXRpb25cclxuXHQgKiBAcGFyYW0gbWVzc2FnZVx0LSBNZXNzYWdlIEhUTUxcclxuXHQgKiBAcmV0dXJucyBzdHJpbmcgIC0gSFRNTCBJRFx0XHRvciAwIGlmIG5vdCBzaG93aW5nIGR1cmluZyB0aGlzIHRpbWUuXHJcblx0ICovXHJcblx0ZnVuY3Rpb24gd3BiY19mcm9udF9lbmRfX3Nob3dfbWVzc2FnZV9fZXJyb3JfdW5kZXJfZWxlbWVudCgganFfbm9kZSwgbWVzc2FnZSwgbWVzc2FnZV9kZWxheSApe1xyXG5cclxuXHRcdGlmICggJ3VuZGVmaW5lZCcgPT09IHR5cGVvZiAobWVzc2FnZV9kZWxheSkgKXtcclxuXHRcdFx0bWVzc2FnZV9kZWxheSA9IDBcclxuXHRcdH1cclxuXHJcblx0XHR2YXIgbm90aWNlX21lc3NhZ2VfaWQgPSB3cGJjX2Zyb250X2VuZF9fc2hvd19tZXNzYWdlKFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdG1lc3NhZ2UsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J3R5cGUnICAgICAgICAgICAgICAgOiAnZXJyb3InLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J2RlbGF5JyAgICAgICAgICAgICAgOiBtZXNzYWdlX2RlbGF5LFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J2lmX3Zpc2libGVfbm90X3Nob3cnOiB0cnVlLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J3Nob3dfaGVyZScgICAgICAgICAgOiB7XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnd2hlcmUnICA6ICdhZnRlcicsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnanFfbm9kZSc6IGpxX25vZGVcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQgICB9XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0KTtcclxuXHRcdHJldHVybiBub3RpY2VfbWVzc2FnZV9pZDtcclxuXHR9XHJcblxyXG5cclxuXHQvKipcclxuXHQgKiBFcnJvciBtZXNzYWdlIFVOREVSIGVsZW1lbnQuIFx0UHJlc2V0IG9mIHBhcmFtZXRlcnMgZm9yIHJlYWwgbWVzc2FnZSBmdW5jdGlvbi5cclxuXHQgKlxyXG5cdCAqIEBwYXJhbSBlbFx0XHQtIGFueSBqUXVlcnkgbm9kZSBkZWZpbml0aW9uXHJcblx0ICogQHBhcmFtIG1lc3NhZ2VcdC0gTWVzc2FnZSBIVE1MXHJcblx0ICogQHJldHVybnMgc3RyaW5nICAtIEhUTUwgSURcdFx0b3IgMCBpZiBub3Qgc2hvd2luZyBkdXJpbmcgdGhpcyB0aW1lLlxyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfZnJvbnRfZW5kX19zaG93X21lc3NhZ2VfX2Vycm9yX2Fib3ZlX2VsZW1lbnQoIGpxX25vZGUsIG1lc3NhZ2UsIG1lc3NhZ2VfZGVsYXkgKXtcclxuXHJcblx0XHRpZiAoICd1bmRlZmluZWQnID09PSB0eXBlb2YgKG1lc3NhZ2VfZGVsYXkpICl7XHJcblx0XHRcdG1lc3NhZ2VfZGVsYXkgPSAxMDAwMFxyXG5cdFx0fVxyXG5cclxuXHRcdHZhciBub3RpY2VfbWVzc2FnZV9pZCA9IHdwYmNfZnJvbnRfZW5kX19zaG93X21lc3NhZ2UoXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0bWVzc2FnZSxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHR7XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQndHlwZScgICAgICAgICAgICAgICA6ICdlcnJvcicsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnZGVsYXknICAgICAgICAgICAgICA6IG1lc3NhZ2VfZGVsYXksXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnaWZfdmlzaWJsZV9ub3Rfc2hvdyc6IHRydWUsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnc2hvd19oZXJlJyAgICAgICAgICA6IHtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCd3aGVyZScgIDogJ2JlZm9yZScsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnanFfbm9kZSc6IGpxX25vZGVcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQgICB9XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0KTtcclxuXHRcdHJldHVybiBub3RpY2VfbWVzc2FnZV9pZDtcclxuXHR9XHJcblxyXG5cclxuXHQvKipcclxuXHQgKiBXYXJuaW5nIG1lc3NhZ2UuIFx0UHJlc2V0IG9mIHBhcmFtZXRlcnMgZm9yIHJlYWwgbWVzc2FnZSBmdW5jdGlvbi5cclxuXHQgKlxyXG5cdCAqIEBwYXJhbSBlbFx0XHQtIGFueSBqUXVlcnkgbm9kZSBkZWZpbml0aW9uXHJcblx0ICogQHBhcmFtIG1lc3NhZ2VcdC0gTWVzc2FnZSBIVE1MXHJcblx0ICogQHJldHVybnMgc3RyaW5nICAtIEhUTUwgSURcdFx0b3IgMCBpZiBub3Qgc2hvd2luZyBkdXJpbmcgdGhpcyB0aW1lLlxyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfZnJvbnRfZW5kX19zaG93X21lc3NhZ2VfX3dhcm5pbmcoIGpxX25vZGUsIG1lc3NhZ2UgKXtcclxuXHJcblx0XHR2YXIgbm90aWNlX21lc3NhZ2VfaWQgPSB3cGJjX2Zyb250X2VuZF9fc2hvd19tZXNzYWdlKFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdG1lc3NhZ2UsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J3R5cGUnICAgICAgICAgICAgICAgOiAnd2FybmluZycsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnZGVsYXknICAgICAgICAgICAgICA6IDEwMDAwLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J2lmX3Zpc2libGVfbm90X3Nob3cnOiB0cnVlLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J3Nob3dfaGVyZScgICAgICAgICAgOiB7XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnd2hlcmUnICA6ICdyaWdodCcsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnanFfbm9kZSc6IGpxX25vZGVcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQgICB9XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0KTtcclxuXHRcdHdwYmNfaGlnaGxpZ2h0X2Vycm9yX29uX2Zvcm1fZmllbGQoIGpxX25vZGUgKTtcclxuXHRcdHJldHVybiBub3RpY2VfbWVzc2FnZV9pZDtcclxuXHR9XHJcblxyXG5cclxuXHQvKipcclxuXHQgKiBXYXJuaW5nIG1lc3NhZ2UgVU5ERVIgZWxlbWVudC4gXHRQcmVzZXQgb2YgcGFyYW1ldGVycyBmb3IgcmVhbCBtZXNzYWdlIGZ1bmN0aW9uLlxyXG5cdCAqXHJcblx0ICogQHBhcmFtIGVsXHRcdC0gYW55IGpRdWVyeSBub2RlIGRlZmluaXRpb25cclxuXHQgKiBAcGFyYW0gbWVzc2FnZVx0LSBNZXNzYWdlIEhUTUxcclxuXHQgKiBAcmV0dXJucyBzdHJpbmcgIC0gSFRNTCBJRFx0XHRvciAwIGlmIG5vdCBzaG93aW5nIGR1cmluZyB0aGlzIHRpbWUuXHJcblx0ICovXHJcblx0ZnVuY3Rpb24gd3BiY19mcm9udF9lbmRfX3Nob3dfbWVzc2FnZV9fd2FybmluZ191bmRlcl9lbGVtZW50KCBqcV9ub2RlLCBtZXNzYWdlICl7XHJcblxyXG5cdFx0dmFyIG5vdGljZV9tZXNzYWdlX2lkID0gd3BiY19mcm9udF9lbmRfX3Nob3dfbWVzc2FnZShcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRtZXNzYWdlLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdHtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCd0eXBlJyAgICAgICAgICAgICAgIDogJ3dhcm5pbmcnLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J2RlbGF5JyAgICAgICAgICAgICAgOiAxMDAwMCxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCdpZl92aXNpYmxlX25vdF9zaG93JzogdHJ1ZSxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCdzaG93X2hlcmUnICAgICAgICAgIDoge1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J3doZXJlJyAgOiAnYWZ0ZXInLFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0J2pxX25vZGUnOiBqcV9ub2RlXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0ICAgfVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdH1cclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCk7XHJcblx0XHRyZXR1cm4gbm90aWNlX21lc3NhZ2VfaWQ7XHJcblx0fVxyXG5cclxuXHJcblx0LyoqXHJcblx0ICogV2FybmluZyBtZXNzYWdlIEFCT1ZFIGVsZW1lbnQuIFx0UHJlc2V0IG9mIHBhcmFtZXRlcnMgZm9yIHJlYWwgbWVzc2FnZSBmdW5jdGlvbi5cclxuXHQgKlxyXG5cdCAqIEBwYXJhbSBlbFx0XHQtIGFueSBqUXVlcnkgbm9kZSBkZWZpbml0aW9uXHJcblx0ICogQHBhcmFtIG1lc3NhZ2VcdC0gTWVzc2FnZSBIVE1MXHJcblx0ICogQHJldHVybnMgc3RyaW5nICAtIEhUTUwgSURcdFx0b3IgMCBpZiBub3Qgc2hvd2luZyBkdXJpbmcgdGhpcyB0aW1lLlxyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfZnJvbnRfZW5kX19zaG93X21lc3NhZ2VfX3dhcm5pbmdfYWJvdmVfZWxlbWVudCgganFfbm9kZSwgbWVzc2FnZSApe1xyXG5cclxuXHRcdHZhciBub3RpY2VfbWVzc2FnZV9pZCA9IHdwYmNfZnJvbnRfZW5kX19zaG93X21lc3NhZ2UoXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0bWVzc2FnZSxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHR7XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQndHlwZScgICAgICAgICAgICAgICA6ICd3YXJuaW5nJyxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCdkZWxheScgICAgICAgICAgICAgIDogMTAwMDAsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnaWZfdmlzaWJsZV9ub3Rfc2hvdyc6IHRydWUsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnc2hvd19oZXJlJyAgICAgICAgICA6IHtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCd3aGVyZScgIDogJ2JlZm9yZScsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQnanFfbm9kZSc6IGpxX25vZGVcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQgICB9XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0KTtcclxuXHRcdHJldHVybiBub3RpY2VfbWVzc2FnZV9pZDtcclxuXHR9XHJcblxyXG5cdC8qKlxyXG5cdCAqIEhpZ2hsaWdodCBFcnJvciBpbiBzcGVjaWZpYyBmaWVsZFxyXG5cdCAqXHJcblx0ICogQHBhcmFtIGpxX25vZGVcdFx0XHRcdFx0c3RyaW5nIG9yIGpRdWVyeSBlbGVtZW50LCAgd2hlcmUgc2Nyb2xsICB0b1xyXG5cdCAqL1xyXG5cdGZ1bmN0aW9uIHdwYmNfaGlnaGxpZ2h0X2Vycm9yX29uX2Zvcm1fZmllbGQoIGpxX25vZGUgKXtcclxuXHJcblx0XHRpZiAoICFqUXVlcnkoIGpxX25vZGUgKS5sZW5ndGggKXtcclxuXHRcdFx0cmV0dXJuO1xyXG5cdFx0fVxyXG5cdFx0aWYgKCAhIGpRdWVyeSgganFfbm9kZSApLmlzKCAnOmlucHV0JyApICl7XHJcblx0XHRcdC8vIFNpdHVhdGlvbiB3aXRoICBjaGVja2JveGVzIG9yIHJhZGlvICBidXR0b25zXHJcblx0XHRcdHZhciBqcV9ub2RlX2FyciA9IGpRdWVyeSgganFfbm9kZSApLmZpbmQoICc6aW5wdXQnICk7XHJcblx0XHRcdGlmICggIWpxX25vZGVfYXJyLmxlbmd0aCApe1xyXG5cdFx0XHRcdHJldHVyblxyXG5cdFx0XHR9XHJcblx0XHRcdGpxX25vZGUgPSBqcV9ub2RlX2Fyci5nZXQoIDAgKTtcclxuXHRcdH1cclxuXHRcdHZhciBwYXJhbXMgPSB7fTtcclxuXHRcdHBhcmFtc1sgJ2RlbGF5JyBdID0gMTAwMDA7XHJcblxyXG5cdFx0aWYgKCAhalF1ZXJ5KCBqcV9ub2RlICkuaGFzQ2xhc3MoICd3cGJjX2Zvcm1fZmllbGRfZXJyb3InICkgKXtcclxuXHJcblx0XHRcdGpRdWVyeSgganFfbm9kZSApLmFkZENsYXNzKCAnd3BiY19mb3JtX2ZpZWxkX2Vycm9yJyApXHJcblxyXG5cdFx0XHRpZiAoIHBhcnNlSW50KCBwYXJhbXNbICdkZWxheScgXSApID4gMCApe1xyXG5cdFx0XHRcdHZhciBjbG9zZWRfdGltZXIgPSBzZXRUaW1lb3V0KCBmdW5jdGlvbiAoKXtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0IGpRdWVyeSgganFfbm9kZSApLnJlbW92ZUNsYXNzKCAnd3BiY19mb3JtX2ZpZWxkX2Vycm9yJyApO1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0ICB9XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHQgICAsIHBhcnNlSW50KCBwYXJhbXNbICdkZWxheScgXSApXHJcblx0XHRcdFx0XHRcdFx0XHRcdCk7XHJcblxyXG5cdFx0XHR9XHJcblx0XHR9XHJcblx0fVxyXG5cclxuLyoqXHJcbiAqIFNjcm9sbCB0byBzcGVjaWZpYyBlbGVtZW50XHJcbiAqXHJcbiAqIEBwYXJhbSBqcV9ub2RlXHRcdFx0XHRcdHN0cmluZyBvciBqUXVlcnkgZWxlbWVudCwgIHdoZXJlIHNjcm9sbCAgdG9cclxuICogQHBhcmFtIGV4dHJhX3NoaWZ0X29mZnNldFx0XHRpbnQgc2hpZnQgb2Zmc2V0IGZyb20gIGpxX25vZGVcclxuICovXHJcbmZ1bmN0aW9uIHdwYmNfZG9fc2Nyb2xsKCBqcV9ub2RlICwgZXh0cmFfc2hpZnRfb2Zmc2V0ID0gMCApe1xyXG5cclxuXHRpZiAoICFqUXVlcnkoIGpxX25vZGUgKS5sZW5ndGggKXtcclxuXHRcdHJldHVybjtcclxuXHR9XHJcblx0dmFyIHRhcmdldE9mZnNldCA9IGpRdWVyeSgganFfbm9kZSApLm9mZnNldCgpLnRvcDtcclxuXHJcblx0aWYgKCB0YXJnZXRPZmZzZXQgPD0gMCApe1xyXG5cdFx0aWYgKCAwICE9IGpRdWVyeSgganFfbm9kZSApLm5leHRBbGwoICc6dmlzaWJsZScgKS5sZW5ndGggKXtcclxuXHRcdFx0dGFyZ2V0T2Zmc2V0ID0galF1ZXJ5KCBqcV9ub2RlICkubmV4dEFsbCggJzp2aXNpYmxlJyApLmZpcnN0KCkub2Zmc2V0KCkudG9wO1xyXG5cdFx0fSBlbHNlIGlmICggMCAhPSBqUXVlcnkoIGpxX25vZGUgKS5wYXJlbnQoKS5uZXh0QWxsKCAnOnZpc2libGUnICkubGVuZ3RoICl7XHJcblx0XHRcdHRhcmdldE9mZnNldCA9IGpRdWVyeSgganFfbm9kZSApLnBhcmVudCgpLm5leHRBbGwoICc6dmlzaWJsZScgKS5maXJzdCgpLm9mZnNldCgpLnRvcDtcclxuXHRcdH1cclxuXHR9XHJcblxyXG5cdGlmICggalF1ZXJ5KCAnI3dwYWRtaW5iYXInICkubGVuZ3RoID4gMCApe1xyXG5cdFx0dGFyZ2V0T2Zmc2V0ID0gdGFyZ2V0T2Zmc2V0IC0gNTAgLSA1MDtcclxuXHR9IGVsc2Uge1xyXG5cdFx0dGFyZ2V0T2Zmc2V0ID0gdGFyZ2V0T2Zmc2V0IC0gMjAgLSA1MDtcclxuXHR9XHJcblx0dGFyZ2V0T2Zmc2V0ICs9IGV4dHJhX3NoaWZ0X29mZnNldDtcclxuXHJcblx0Ly8gU2Nyb2xsIG9ubHkgIGlmIHdlIGRpZCBub3Qgc2Nyb2xsIGJlZm9yZVxyXG5cdGlmICggISBqUXVlcnkoICdodG1sLGJvZHknICkuaXMoICc6YW5pbWF0ZWQnICkgKXtcclxuXHRcdGpRdWVyeSggJ2h0bWwsYm9keScgKS5hbmltYXRlKCB7c2Nyb2xsVG9wOiB0YXJnZXRPZmZzZXR9LCA1MDAgKTtcclxuXHR9XHJcbn1cclxuXHJcbiIsIlxyXG4vL0ZpeEluOiAxMC4yLjAuNFxyXG4vKipcclxuICogRGVmaW5lIFBvcG92ZXJzIGZvciBUaW1lbGluZXMgaW4gV1AgQm9va2luZyBDYWxlbmRhclxyXG4gKlxyXG4gKiBAcmV0dXJucyB7c3RyaW5nfGJvb2xlYW59XHJcbiAqL1xyXG5mdW5jdGlvbiB3cGJjX2RlZmluZV90aXBweV9wb3BvdmVyKCl7XHJcblx0aWYgKCAnZnVuY3Rpb24nICE9PSB0eXBlb2YgKHdwYmNfdGlwcHkpICl7XHJcblx0XHRjb25zb2xlLmxvZyggJ1dQQkMgRXJyb3IuIHdwYmNfdGlwcHkgd2FzIG5vdCBkZWZpbmVkLicgKTtcclxuXHRcdHJldHVybiBmYWxzZTtcclxuXHR9XHJcblx0d3BiY190aXBweSggJy5wb3BvdmVyX2JvdHRvbS5wb3BvdmVyX2NsaWNrJywge1xyXG5cdFx0Y29udGVudCggcmVmZXJlbmNlICl7XHJcblx0XHRcdHZhciBwb3BvdmVyX3RpdGxlID0gcmVmZXJlbmNlLmdldEF0dHJpYnV0ZSggJ2RhdGEtb3JpZ2luYWwtdGl0bGUnICk7XHJcblx0XHRcdHZhciBwb3BvdmVyX2NvbnRlbnQgPSByZWZlcmVuY2UuZ2V0QXR0cmlidXRlKCAnZGF0YS1jb250ZW50JyApO1xyXG5cdFx0XHRyZXR1cm4gJzxkaXYgY2xhc3M9XCJwb3BvdmVyIHBvcG92ZXJfdGlwcHlcIj4nXHJcblx0XHRcdFx0KyAnPGRpdiBjbGFzcz1cInBvcG92ZXItY2xvc2VcIj48YSBocmVmPVwiamF2YXNjcmlwdDp2b2lkKDApXCIgb25jbGljaz1cImphdmFzY3JpcHQ6dGhpcy5wYXJlbnRFbGVtZW50LnBhcmVudEVsZW1lbnQucGFyZW50RWxlbWVudC5wYXJlbnRFbGVtZW50LnBhcmVudEVsZW1lbnQuX3RpcHB5LmhpZGUoKTtcIiA+JnRpbWVzOzwvYT48L2Rpdj4nXHJcblx0XHRcdFx0KyBwb3BvdmVyX2NvbnRlbnRcclxuXHRcdFx0XHQrICc8L2Rpdj4nO1xyXG5cdFx0fSxcclxuXHRcdGFsbG93SFRNTCAgICAgICAgOiB0cnVlLFxyXG5cdFx0dHJpZ2dlciAgICAgICAgICA6ICdtYW51YWwnLFxyXG5cdFx0aW50ZXJhY3RpdmUgICAgICA6IHRydWUsXHJcblx0XHRoaWRlT25DbGljayAgICAgIDogZmFsc2UsXHJcblx0XHRpbnRlcmFjdGl2ZUJvcmRlcjogMTAsXHJcblx0XHRtYXhXaWR0aCAgICAgICAgIDogNTUwLFxyXG5cdFx0dGhlbWUgICAgICAgICAgICA6ICd3cGJjLXRpcHB5LXBvcG92ZXInLFxyXG5cdFx0cGxhY2VtZW50ICAgICAgICA6ICdib3R0b20tc3RhcnQnLFxyXG5cdFx0dG91Y2ggICAgICAgICAgICA6IFsnaG9sZCcsIDUwMF0sXHJcblx0fSApO1xyXG5cdGpRdWVyeSggJy5wb3BvdmVyX2JvdHRvbS5wb3BvdmVyX2NsaWNrJyApLm9uKCAnY2xpY2snLCBmdW5jdGlvbiAoKXtcclxuXHRcdGlmICggdGhpcy5fdGlwcHkuc3RhdGUuaXNWaXNpYmxlICl7XHJcblx0XHRcdHRoaXMuX3RpcHB5LmhpZGUoKTtcclxuXHRcdH0gZWxzZSB7XHJcblx0XHRcdHRoaXMuX3RpcHB5LnNob3coKTtcclxuXHRcdH1cclxuXHR9ICk7XHJcblx0d3BiY19kZWZpbmVfaGlkZV90aXBweV9vbl9zY3JvbGwoKTtcclxufVxyXG5cclxuXHJcblxyXG5mdW5jdGlvbiB3cGJjX2RlZmluZV9oaWRlX3RpcHB5X29uX3Njcm9sbCgpe1xyXG5cdGpRdWVyeSggJy5mbGV4X3RsX19zY3JvbGxpbmdfc2VjdGlvbjIsLmZsZXhfdGxfX3Njcm9sbGluZ19zZWN0aW9ucycgKS5vbiggJ3Njcm9sbCcsIGZ1bmN0aW9uICggZXZlbnQgKXtcclxuXHRcdGlmICggJ2Z1bmN0aW9uJyA9PT0gdHlwZW9mICh3cGJjX3RpcHB5KSApe1xyXG5cdFx0XHR3cGJjX3RpcHB5LmhpZGVBbGwoKTtcclxuXHRcdH1cclxuXHR9ICk7XHJcbn1cclxuIl19
