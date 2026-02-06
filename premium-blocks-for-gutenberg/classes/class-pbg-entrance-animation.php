<?php
/**
 * Entrance Animation
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class PBG_Entrance_Animation
 */
class PBG_Entrance_Animation {

	/**
	 * Class instance
	 *
	 * @var instance
	 */
	private static $instance = null;

	/**
	 * Creates and returns an instance of the class
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return object
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor
	 */
	private function __construct() {
		// Register block support.
		add_action( 'init', array( $this, 'register_block_support' ) );

		// Add support to all blocks.
		add_filter( 'register_block_type_args', array( $this, 'add_entrance_animation_support' ), 100, 2 );

		// Modify block metadata to allow entrance animation.
		add_filter( 'block_type_metadata', array( $this, 'add_entrance_animation_metadata' ), 10, 2 );
	}

	/**
	 * Register block support for entrance animation.
	 */
	public function register_block_support() {
		WP_Block_Supports::get_instance()->register(
			'entranceAnimation',
			array(
				'register_attribute' => array( $this, 'register_entrance_animation_attribute' ),
			)
		);
	}

	/**
	 * Register the entranceAnimation attribute for blocks that support it.
	 *
	 * @param WP_Block_Type $block_type Block type.
	 */
	public function register_entrance_animation_attribute( $block_type ) {
		if ( ! $block_type->attributes ) {
			$block_type->attributes = array();
		}

		$block_type->attributes['entranceAnimation'] = array(
			'type'    => 'object',
			'default' => array(
				'animation' => '',
				'curve'     => 'ease',
				'duration'  => 1000,
				'delay'     => 0,
				'clientId'  => '',
			),
		);
	}

	/**
	 * Add entranceAnimation support to all block types.
	 *
	 * @param array  $args       Array of arguments for registering a block type.
	 * @param string $block_type Block type name.
	 *
	 * @return array
	 */
	public function add_entrance_animation_support( $args, $block_type ) {
		if ( ! isset( $args['supports'] ) ) {
			$args['supports'] = array();
		}

		$args['supports']['entranceAnimation'] = true;

		return $args;
	}

	/**
	 * Modify block metadata to add entrance animation attribute.
	 *
	 * @param array          $metadata   Block type metadata.
	 * @param WP_Block_Type  $block_type Block type.
	 *
	 * @return array Modified metadata.
	 */
	public function add_entrance_animation_metadata( $metadata, $block_type = null ) {
		if ( isset( $metadata['attributes'] ) ) {
			$metadata['attributes']['entranceAnimation'] = array(
				'type' => 'object',
				'default' => array(
					'animation' => '',
					'curve' => 'ease',
					'duration' => 1000,
					'delay' => 0,
					'clientId' => '',
				),
			);
		}

		return $metadata;
	}
}

PBG_Entrance_Animation::get_instance();
