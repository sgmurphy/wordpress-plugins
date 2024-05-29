<?php


if ( ! class_exists( 'BWF_Model_Contact_Fields' ) && BWFAN_Common::is_pro_3_0() ) {

	class BWF_Model_Contact_Fields {

		static $primary_key = 'ID';

		public static $db_field_types = [
			'1' => [
				'name'   => 'Text Input',
				'type'   => 'VARCHAR',
				'length' => 99
			],
			'2' => [
				'name'     => 'Text Number',
				'type'     => 'BIGINT',
				'length'   => 10,
				'unsigned' => true
			],
			'3' => [
				'name' => 'Text Area',
				'type' => 'LONGTEXT'
			],
			'4' => [
				'name'   => 'Drop Down',
				'type'   => 'VARCHAR',
				'length' => 99
			],
			'5' => [
				'name'   => 'Radio Button',
				'type'   => 'VARCHAR',
				'length' => 99
			],
			'6' => [
				'name' => 'Checkboxes',
				'type' => 'LONGTEXT'
			],
			'7' => [
				'name' => 'Date',
				'type' => 'DATE'
			],
			'8' => [
				'name' => 'Datetime',
				'type' => 'DATETIME'
			]
		];

		static function _table() {
			global $wpdb;

			return "{$wpdb->prefix}bwf_contact_fields";
		}

		static function insert( $data ) {
			global $wpdb;

			$wpdb->insert( self::_table(), $data );
		}

		static function update( $data, $where ) {
			global $wpdb;

			return $wpdb->update( self::_table(), $data, $where );
		}

		public static function get_contact_field_by_id( $contact_id ) {
			global $wpdb;
			$table = self::_table();
			$query = "SELECT * from $table where cid = $contact_id LIMIT 0, 1";
			$field = $wpdb->get_row( $query, ARRAY_A );

			return ! empty( $field ) ? $field : '';
		}

		public static function column_already_exists( $field_id ) {
			global $wpdb;
			$table  = self::_table();
			$column = "f{$field_id}";
			$query  = "SHOW COLUMNS FROM {$table} LIKE '" . esc_sql( $column ) . "'";

			return $wpdb->get_row( $query, ARRAY_A );
		}

		public static function add_column_field( $field_id, $searchable = 2 ) {
			global $wpdb;
			$table      = self::_table();
			$field_type = BWFAN_Model_Fields::get_field_type( $field_id );

			$db_details = self::$db_field_types[ $field_type ];
			$data_type  = $db_details['type'];
			$length     = '';
			$unsigned   = '';
			$indexing   = '';
			$column     = "f{$field_id}";
			if ( isset( $db_details['length'] ) ) {
				$length = "(" . $db_details['length'] . ")";
			}

			if ( isset( $db_details['unsigned'] ) ) {
				$unsigned = " unsigned ";
			}

			if ( 1 === absint( $searchable ) && 'LONGTEXT' !== $db_details['type'] ) {
				$indexing = ", ADD KEY ($column)";
			}

			$query = "ALTER TABLE $table ADD $column $data_type{$length} $unsigned DEFAULT NULL $indexing";
			$wpdb->query( $query );

			return empty( $wpdb->last_error ) ? true : $wpdb->last_error;
		}

		public static function drop_contact_field_column( $field_id ) {
			global $wpdb;
			$table  = self::_table();
			$column = "f{$field_id}";

			if ( ! empty( self::column_already_exists( $field_id ) ) ) {
				$query = "ALTER TABLE $table DROP COLUMN $column";
				$wpdb->query( $query );
			}
		}

		public static function get_contact_fields( $contact_id ) {
			global $wpdb;
			$table = self::_table();

			$query = "SELECT * FROM $table WHERE cid = $contact_id LIMIT 0, 1";

			return $wpdb->get_row( $query, ARRAY_A );
		}

		public static function update_contact_field_column_indexing( $field_id, $searchable = 1 ) {
			global $wpdb;
			$table         = self::_table();
			$already_exist = self::column_already_exists( $field_id );
			if ( empty( $already_exist ) || ( ! empty( $already_exist['Type'] ) && 'longtext' === $already_exist['Type'] ) ) {
				return false;
			}

			/** Checking indexing already set or not **/
			if ( ( 1 === absint( $searchable ) && ! empty( $already_exist['Key'] ) ) || ( 2 === absint( $searchable ) && empty( $already_exist['Key'] ) ) ) {
				return false;
			}

			$column   = "f{$field_id}";
			$indexing = " ADD KEY ($column)";
			if ( 2 === absint( $searchable ) ) {
				$indexing = " DROP KEY `$column` ";
			}

			$query = "ALTER TABLE $table $indexing";
			$wpdb->query( $query );

			return empty( $wpdb->last_error ) ? true : false;
		}
	}
}