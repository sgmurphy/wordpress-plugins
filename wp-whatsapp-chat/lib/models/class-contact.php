<?php

namespace QuadLayers\QLWAPP\Models;

use QuadLayers\QLWAPP\Entities\Contact as Contact_Entity;
use QuadLayers\WP_Orm\Builder\CollectionRepositoryBuilder;

/**
 * Models_Action Class
 */
class Contact {

	protected static $instance;
	protected $repository;

	public function __construct() {
		add_filter( 'sanitize_option_qlwapp_contacts', 'wp_unslash' );
		$builder = ( new CollectionRepositoryBuilder() )
		->setTable( 'qlwapp_contacts' )
		->setEntity( Contact_Entity::class )
		->setAutoIncrement( true );

		$this->repository = $builder->getRepository();
	}

	public function get_table() {
		return $this->repository->getTable();
	}

	public function get_args() {
		$entity   = new Contact_Entity();
		$defaults = $entity->getDefaults();
		return $defaults;
	}

	public function get_contact( $id ) {
		return $this->get( $id );
	}

	public function get( int $id ) {
		$entity = $this->repository->find( $id );
		if ( $entity ) {
			return $entity->getProperties();
		}
	}

	public function delete( int $id ) {
		return $this->repository->delete( $id );
	}

	public function update_contact( $contact_data ) {
		return ! ! $this->update( $contact_data['id'], $contact_data );
	}

	public function update_contacts( $contacts ) {
		foreach ( $contacts as $contact ) {
			$this->update( $contact['id'], $contact );
		}

		return true;
	}

	public function update( int $id, array $contact ) {
		$entity = $this->repository->update( $id, $this->sanitize_value_data( $contact ) );
		if ( $entity ) {
			return $entity->getProperties();
		}
	}

	public function add_contact( $contact_data ) {
		$contacts = $this->get_all();

		$max_order = 0;

		foreach ( $contacts as $contact ) {
			if ( isset( $contact['order'] ) && $contact['order'] > $max_order ) {
				$max_order = $contact['order'];
			}
		}

		$contact_data['order'] = $max_order + 1;

		return ! ! $this->create( $contact_data );
	}

	public function create( array $contact ) {
		if ( isset( $contact['id'] ) ) {
			unset( $contact['id'] );
		}

		$entity = $this->repository->create( $this->sanitize_value_data( $contact ) );

		if ( $entity ) {
			return $entity->getProperties();
		}
	}

	public function order_contact( $a, $b ) {

		if ( ! isset( $a['order'] ) || ! isset( $b['order'] ) ) {
			return 0;
		}

		if ( $a['order'] == $b['order'] ) {
			return 0;
		}

		return ( $a['order'] < $b['order'] ) ? -1 : 1;
	}

	public function get_contacts_reorder() {
		$contacts = $this->get_contacts();
		uasort( $contacts, array( $this, 'order_contact' ) );
		return $contacts;
	}

	public function get_contacts() {
		return $this->get_all();
	}

	public function get_all() {
		$button_model = Button::instance();
		$button       = $button_model->get();
		$entities     = $this->repository->findAll();

		if ( ! $entities ) {
			$default             = array();
			$default[0]          = $this->get_args();
			$default[0]['order'] = 1;
			$default[0]['phone'] = qlwapp_format_phone( $button['phone'] );
			$contact             = $this->create( $default[0] );
			$default[0]['id']    = $contact['id'];

			if ( ! is_admin() ) {
				$default[0]['message'] = qlwapp_replacements_vars( $default[0]['message'] );
			}

			return $default;
		}

		$contacts = array();

		foreach ( $entities as $entity ) {
			$contact = $entity->getProperties();

			if ( ! $contact['phone'] ) {
				$contact['phone'] = qlwapp_format_phone( $button['phone'] );
			}

			if ( ! is_admin() ) {
				$contact['message'] = qlwapp_replacements_vars( $contact['message'] );
			}

			$contacts[ $contact['id'] ] = $contact;
		}

		return $contacts;
	}

	public function delete_all() {
		return $this->repository->deleteAll();
	}

	public function sanitize_value_data( $value_data ) {
		$args = $this->get_args();

		foreach ( $value_data as $key => $value ) {
			if ( array_key_exists( $key, $args ) ) {
				$type = $args[ $key ];

				if ( is_null( $type ) && ! is_numeric( $value ) ) {
					$value_data[ $key ] = intval( $value );
				} elseif ( is_bool( $type ) && ! is_bool( $value ) ) {
					$value_data[ $key ] = ( $value === 'true' || $value === '1' || $value === 1 );
				} elseif ( is_string( $type ) && ! is_string( $value ) ) {
					$value_data[ $key ] = strval( $value );
				} elseif ( is_array( $type ) && ! is_array( $value ) ) {
					$value_data[ $key ] = (array) $type;
				}
			} else {
				unset( $value_data[ $key ] );
			}
		}

		return $value_data;
	}

	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
