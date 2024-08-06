<?php

namespace QuadLayers\IGG\Models;

use QuadLayers\WP_Orm\Builder\SingleRepositoryBuilder;
use QuadLayers\IGG\Entity\Settings as Settings;


/**
 * Models_Setting Class
 */
class Setting {

	protected static $instance;
	protected $repository;

	public function __construct() {
		$builder = ( new SingleRepositoryBuilder() )
		->setTable( 'insta_gallery_settings' )
		->setEntity( Settings::class );

		$this->repository = $builder->getRepository();
	}

	/* CRUD */

	/**
	 * Function to get default args
	 *
	 * @return array
	 */
	public function get_args() {
		return ( new Settings() )->getDefaults();
	}

	/**
	 * Function to get all settings
	 *
	 * @return array
	 */
	public function get() {
		$entity = $this->repository->find();

		if ( $entity ) {
			return $entity->getProperties();
		} else {
			$settings = new Settings();
			return $settings->getProperties();
		}
	}

	/**
	 * Function to save settings
	 *
	 * @param array $settings Settings to be saved.
	 * @return boolean
	 */
	public function save( $data ) {
		$entity = $this->repository->create( $data );

		if ( $entity ) {
			return true;
		}
	}

	/**
	 * Function to delete table
	 *
	 * @return void
	 */
	public function delete_all() {
		return $this->repository->delete();
	}

	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
