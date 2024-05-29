<?php

if ( ! class_exists( 'BWFAN_Model_Fields' ) && BWFAN_Common::is_pro_3_0() ) {
	class BWFAN_Model_Fields extends BWFAN_Model {
		private static $fields_cache_by_slug = [];

		static $primary_key = 'ID';
		static $cache_query = [];

		/**
		 * function to return field data using term slug
		 *
		 * @param $id
		 *
		 * @return array|mixed
		 */
		static function get_field_by_id( $id ) {
			global $wpdb;
			$query     = "SELECT * from {table_name} where ID = $id ";
			$fielddata = self::get_results( $query );
			$fielddata = is_array( $fielddata ) && ! empty( $fielddata ) ? $fielddata[0] : array();
			if ( isset( $fielddata['meta'] ) ) {
				$fielddata['meta'] = json_decode( $fielddata['meta'] );
			}

			return $fielddata;
		}

		public static function get_group_fields( $group_id = 0, $mode = null, $vmode = null, $searchable = null ) {
			global $wpdb;
			$query = "SELECT fg.name AS group_name, cf.ID AS field_id, cf.name, cf.slug, cf.type, cf.gid, cf.meta, cf.search, cf.mode, cf.vmode, cf.created_at FROM {table_name} AS cf LEFT JOIN {$wpdb->prefix}bwfan_field_groups AS fg ON cf.gid = fg.ID ";

			$query .= " WHERE 1=1";

			! empty( $mode ) && $query .= " AND mode = $mode";
			! empty( $vmode ) && $query .= " AND vmode = $vmode";
			! empty( $searchable ) && $query .= " AND search = $searchable";

			$group_id > 0 ? $query .= " AND fg.ID = $group_id" : $query .= " AND (EXISTS (SELECT 1 FROM {$wpdb->prefix}bwfan_field_groups WHERE cf.gid=ID) OR cf.gid=0 )";

			$fields = self::get_results( $query );

			return $fields;
		}

		public static function get_custom_fields( $mode = null, $vmode = null, $searchable = null, $viewable = null, $type = null ) {
			$query = "SELECT * FROM {table_name} WHERE 1=1";

			! empty( $mode ) && $query .= " AND mode = $mode";
			! empty( $vmode ) && $query .= " AND vmode = $vmode";
			! empty( $searchable ) && $query .= " AND search = $searchable";
			! empty( $viewable ) && $query .= " AND view = $viewable";
			! empty( $type ) && $query .= " AND type = $type";

			$fields = self::get_results( $query );

			return $fields;
		}

		public static function get_field_by_slug( $slug ) {
			$field = self::get_fields_by_slugs_cache( [ $slug ] );

			return $field;
		}

		public static function get_fields_by_multiple_slugs( $slugs = [] ) {
			$fields = self::get_fields_by_slugs_cache( $slugs );

			return $fields;
		}

		public static function get_fields_by_slugs_cache( $slugs, $return_by = 'slug' ) {

			if ( empty( $slugs ) ) {
				return [];
			}

			$fields = self::$fields_cache_by_slug;
			if ( 0 === count( $fields ) ) {
				global $wpdb;
				$table = self::_table();

				$query = "SELECT * from $table";

				$rest_fields = $wpdb->get_results( $query, ARRAY_A );
				$fields      = [];
				foreach ( $rest_fields as $field ) {
					if ( ! is_array( $field ) ) {
						continue;
					}

					$fields[ $field['slug'] ] = $field;
				}
				self::$fields_cache_by_slug = $fields;
			}

			$return = [];
			foreach ( $slugs as $slug ) {
				if ( ! isset( $fields[ $slug ] ) || ! is_array( $fields[ $slug ] ) ) {
					continue;
				}

				$field = $fields[ $slug ];
				$key   = 'slug' === $return_by ? $slug : $field['id'];

				if ( 1 === count( $slugs ) ) {
					return $field;
				}
				$return[ $key ] = $field;
			}

			return $return;
		}

		public static function get_field_type( $id ) {
			global $wpdb;
			$table = self::_table();

			$query = "SELECT `type` FROM $table WHERE `ID` = $id LIMIT 0,1";
			if ( isset( self::$cache_query[ md5( $query ) ] ) ) {
				return self::$cache_query[ md5( $query ) ];
			}

			self::$cache_query[ md5( $query ) ] = $wpdb->get_var( $query );

			return self::$cache_query[ md5( $query ) ];
		}

		/**
		 * Get all fields and their slug, name, type details
		 *
		 * @return array|object|stdClass[]|null
		 */
		public static function get_field_types() {
			global $wpdb;
			$table = self::_table();

			$query = "SELECT `ID`, `slug`, `type`, `name` FROM $table LIMIT 0,500";
			if ( isset( self::$cache_query[ md5( $query ) ] ) ) {
				return self::$cache_query[ md5( $query ) ];
			}

			self::$cache_query[ md5( $query ) ] = $wpdb->get_results( $query, ARRAY_A );

			return self::$cache_query[ md5( $query ) ];
		}

		/**Get total Count of fields for showing in frontend*/
		public static function get_fields_count() {
			global $wpdb;
			$table        = self::_table();
			$addressfield = implode( "', '", array_keys( BWFCRM_Fields::$contact_address_fields ) );

			$query         = "SELECT COUNT(ID) FROM {$table} WHERE 1=1 AND vmode=1 AND slug NOT IN('$addressfield')";
			$custom_fields = $wpdb->get_var( $query );
			$column_field  = BWFCRM_Fields::$contact_columns;
			if ( isset( $column_field['creation_date'] ) ) {
				unset( $column_field['creation_date'] );
			}

			$fields_count = $custom_fields + count( $column_field ) + count( BWFCRM_Fields::$extra_columns );

			return $fields_count;
		}

		/**
		 * Get multiple fields
		 *
		 * @param $ids
		 *
		 * @return array|object|stdClass[]|null
		 */
		public static function get_multiple_fields( $ids ) {
			if ( empty( $ids ) ) {
				return [];
			}
			global $wpdb;
			$table = self::_table();

			$ids   = implode( ',', $ids );
			$query = "SELECT * From $table WHERE ID IN ($ids)";

			return $wpdb->get_results( $query, ARRAY_A );
		}
	}
}