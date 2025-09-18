<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Global Settings
 */
if ( ! class_exists( 'Pbg_Global_Settings' ) ) {

	/**
	 * Global Settings
	 */
	class Pbg_Global_Settings {

		/**
		 * Instance
		 *
		 * @access private
		 * @var object
		 */
		private static $instance;

		/**
		 * Blocks Helpers
		 *
		 * @var PBG_Blocks_Helper|null
		 */
		public $block_helpers;

		/**
		 * Initiator
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
		public function __construct() {
			$this->block_helpers = pbg_blocks_helper();
			add_action( 'enqueue_block_editor_assets', array( $this, 'script_enqueue' ) );
			add_action( 'init', array( $this, 'register_pbg_global_settings' ) );
			add_action( 'enqueue_block_assets', array( $this, 'pbg_fronend_global_styles' ), 999 );
			add_filter( 'render_block', array( $this, 'add_data_attr_to_native_blocks' ), 10, 2 );
			add_filter( 'body_class', array( $this, 'add_body_class' ) );
		}

		/**
		 * add_body_class
		 *
		 * @param  mixed $classes
		 * @return void
		 */
		public function add_body_class( $classes ) {
			$apply_color_to_default      = get_option( 'pbg_global_colors_to_default', false );
			$apply_typography_to_default = get_option( 'pbg_global_typography_to_default', false );

			$classes[] = 'pbg-body';
			if ( $apply_color_to_default ) {
				$classes[] = 'pbg-global-colors-to-default';
			}

			if ( $apply_typography_to_default ) {
				$classes[] = 'pbg-global-typography-to-default';
			}

			return $classes;
		}

		/**
		 * add_data_attr_to_native_blocks
		 *
		 * @param  string $block_content
		 * @param  string $block
		 * @return string
		 */
		public function add_data_attr_to_native_blocks( $block_content, $block ) {
			$apply_color_to_default      = get_option( 'pbg_global_colors_to_default', false );
			$apply_typography_to_default = get_option( 'pbg_global_typography_to_default', false );

			if ( ! $apply_color_to_default && ! $apply_typography_to_default ) {
				return $block_content;
			}

			if ( isset( $block['blockName'] ) && is_string( $block['blockName'] ) && stripos( $block['blockName'], 'core/' ) !== 0 ) {
                return $block_content;
            }

			if ( in_array( $block['blockName'], array( 'core/html', 'core/embed' ) ) ) {
				return $block_content;
			}

			if ( stripos( $block_content, '>' ) !== false ) {
				$new_block_content = $this->str_replace_first( '>', ' data-type="core">', $block_content );
				if ( stripos( $new_block_content, '-- data-type="core">' ) === false ) {
					return $new_block_content;
				}
			}

			return $block_content;
		}

		/**
		 * str_replace_first
		 *
		 * @param  string $search
		 * @param  string $replace
		 * @param  string $subject
		 * @return string
		 */
		function str_replace_first( $search, $replace, $subject ) {
			$pos = strpos( $subject, $search );
			if ( $pos !== false ) {
				return substr_replace( $subject, $replace, $pos, strlen( $search ) );
			}
			return $subject;
		}

		/**
		 * pbg_fronend_global_styles
		 *
		 * @return void
		 */
		function pbg_fronend_global_styles() {
			$this->add_global_color_to_frontend();
			$this->add_global_typography_to_frontend();
			$this->add_global_block_spacing();
		}

		/**
		 * add_global_block_spacing
		 *
		 * @return string
		 */
		public function add_global_block_spacing() {
			$global_block_spacing = get_option( 'pbg_global_layout' );
			$css                  = new Premium_Blocks_css();
			
      $css->set_selector( 'body .entry-content > div:not(:first-child) ' );
      $css->pbg_render_range($global_block_spacing, 'block_spacing', 'margin-block-start', null, null, 'px');
      $css->pbg_render_range($global_block_spacing, 'block_spacing', 'margin-top', null, null, 'px');

			$this->block_helpers->add_custom_block_css( $css->css_output() );
		}

		/**
		 * add_global_typography_to_frontend
		 *
		 * @return string
		 */
		public function add_global_typography_to_frontend() {
			$global_typography = get_option( 'pbg_global_typography', array() );
			$apply_to_default  = get_option( 'pbg_global_typography_to_default', false );
			$css               = new Premium_Blocks_css();

      $css->set_selector( '[class*="wp-block-premium"] h1, [class*="wp-block-premium"] h1 > span' );
      $css->pbg_render_typography($global_typography, 'heading1', 'Desktop');
			
      $css->set_selector( '[class*="wp-block-premium"] h2, [class*="wp-block-premium"] h2 > span' );
      $css->pbg_render_typography($global_typography, 'heading2', 'Desktop');

      $css->set_selector( '[class*="wp-block-premium"] h3, [class*="wp-block-premium"] h3 > span' );
      $css->pbg_render_typography($global_typography, 'heading3', 'Desktop');

      $css->set_selector( '[class*="wp-block-premium"] h4, [class*="wp-block-premium"] h4 > span' );
      $css->pbg_render_typography($global_typography, 'heading4', 'Desktop');

      $css->set_selector( '[class*="wp-block-premium"] h5, [class*="wp-block-premium"] h5 > span' );
      $css->pbg_render_typography($global_typography, 'heading5', 'Desktop');

      $css->set_selector( '[class*="wp-block-premium"] h6, [class*="wp-block-premium"] h6 > span' );
      $css->pbg_render_typography($global_typography, 'heading6', 'Desktop');

      $css->set_selector( '[class*="wp-block-premium"] .premium-button, [class*="wp-block-premium"] .premium-button a,[class*="wp-block-premium"] a:not(h1 > a):not(h2 > a):not(h3 > a):not(h4 > a):not(h5 > a):not(h6 > a)' );
      $css->pbg_render_typography($global_typography, 'button', 'Desktop');

      $css->set_selector( 
        '[class*="wp-block-premium"] p, ' .
        '[class*="wp-block-premium"] label, ' .
        '[class*="wp-block-premium"] li, ' .
        '[class*="wp-block-premium"] .premium-form-input-label, ' .
        '[class*="wp-block-premium"] span:not(h1 span):not(h2 span):not(h3 span):not(h4 span):not(h5 span):not(h6 span):not(button > span):not(a > span)' 
      );
      $css->pbg_render_typography($global_typography, 'paragraph', 'Desktop');

			// Core blocks styles.
			if ( $apply_to_default ) {
        $css->set_selector( '[data-type="core"] > h1, h1[data-type="core"]' );
        $css->pbg_render_typography($global_typography, 'heading1', 'Desktop');

        $css->set_selector( '[data-type="core"] > h2, h2[data-type="core"]' );
        $css->pbg_render_typography($global_typography, 'heading2', 'Desktop');

        $css->set_selector( '[data-type="core"] > h3, h3[data-type="core"]' );
        $css->pbg_render_typography($global_typography, 'heading3', 'Desktop');

        $css->set_selector( '[data-type="core"] > h4, h4[data-type="core"]' );
        $css->pbg_render_typography($global_typography, 'heading4', 'Desktop');

        $css->set_selector( '[data-type="core"] > h5, h5[data-type="core"]' );
        $css->pbg_render_typography($global_typography, 'heading5', 'Desktop');

        $css->set_selector( '[data-type="core"] > h6, h6[data-type="core"]' );
        $css->pbg_render_typography($global_typography, 'heading6', 'Desktop');

        $css->set_selector( '[data-type="core"] .wp-block-button .wp-block-button__link, .wp-block-button[data-type="core"] .wp-block-button__link' );
        $css->pbg_render_typography($global_typography, 'button', 'Desktop');

        $css->set_selector( '[data-type="core"] > p, p[data-type="core"], [data-type="core"] > span, span[data-type="core"], [data-type="core"] > li, li[data-type="core"]' );
        $css->pbg_render_typography($global_typography, 'paragraph', 'Desktop');
			}

			$css->start_media_query( 'tablet' );

      $css->set_selector( '[class*="wp-block-premium"] h1, [class*="wp-block-premium"] h1 > span' );
      $css->pbg_render_typography($global_typography, 'heading1', 'Tablet');
			
      $css->set_selector( '[class*="wp-block-premium"] h2, [class*="wp-block-premium"] h2 > span' );
      $css->pbg_render_typography($global_typography, 'heading2', 'Tablet');

      $css->set_selector( '[class*="wp-block-premium"] h3, [class*="wp-block-premium"] h3 > span' );
      $css->pbg_render_typography($global_typography, 'heading3', 'Tablet');

      $css->set_selector( '[class*="wp-block-premium"] h4, [class*="wp-block-premium"] h4 > span' );
      $css->pbg_render_typography($global_typography, 'heading4', 'Tablet');

      $css->set_selector( '[class*="wp-block-premium"] h5, [class*="wp-block-premium"] h5 > span' );
      $css->pbg_render_typography($global_typography, 'heading5', 'Tablet');

      $css->set_selector( '[class*="wp-block-premium"] h6, [class*="wp-block-premium"] h6 > span' );
      $css->pbg_render_typography($global_typography, 'heading6', 'Tablet');

      $css->set_selector( '[class*="wp-block-premium"] .premium-button, [class*="wp-block-premium"] .premium-button a,[class*="wp-block-premium"] a:not(h1 > a):not(h2 > a):not(h3 > a):not(h4 > a):not(h5 > a):not(h6 > a)' );
      $css->pbg_render_typography($global_typography, 'button', 'Tablet');

      $css->set_selector( 
        '[class*="wp-block-premium"] p, ' .
        '[class*="wp-block-premium"] label, ' .
        '[class*="wp-block-premium"] li, ' .
        '[class*="wp-block-premium"] .premium-form-input-label, ' .
        '[class*="wp-block-premium"] span:not(h1 span):not(h2 span):not(h3 span):not(h4 span):not(h5 span):not(h6 span):not(button > span):not(a > span)' 
      );
      $css->pbg_render_typography($global_typography, 'paragraph', 'Tablet');

			// Core blocks styles.
			if ( $apply_to_default ) {
        $css->set_selector( '[data-type="core"] > h1, h1[data-type="core"]' );
        $css->pbg_render_typography($global_typography, 'heading1', 'Tablet');

        $css->set_selector( '[data-type="core"] > h2, h2[data-type="core"]' );
        $css->pbg_render_typography($global_typography, 'heading2', 'Tablet');

        $css->set_selector( '[data-type="core"] > h3, h3[data-type="core"]' );
        $css->pbg_render_typography($global_typography, 'heading3', 'Tablet');

        $css->set_selector( '[data-type="core"] > h4, h4[data-type="core"]' );
        $css->pbg_render_typography($global_typography, 'heading4', 'Tablet');

        $css->set_selector( '[data-type="core"] > h5, h5[data-type="core"]' );
        $css->pbg_render_typography($global_typography, 'heading5', 'Tablet');

        $css->set_selector( '[data-type="core"] > h6, h6[data-type="core"]' );
        $css->pbg_render_typography($global_typography, 'heading6', 'Tablet');

        $css->set_selector( '[data-type="core"] .wp-block-button .wp-block-button__link, .wp-block-button[data-type="core"] .wp-block-button__link' );
        $css->pbg_render_typography($global_typography, 'button', 'Tablet');

        $css->set_selector( '[data-type="core"] > p, p[data-type="core"], [data-type="core"] > span, span[data-type="core"], [data-type="core"] > li, li[data-type="core"]' );
        $css->pbg_render_typography($global_typography, 'paragraph', 'Tablet');
			}

			$css->stop_media_query();
			$css->start_media_query( 'mobile' );

      $css->set_selector( '[class*="wp-block-premium"] h1, [class*="wp-block-premium"] h1 > span' );
      $css->pbg_render_typography($global_typography, 'heading1', 'Mobile');
			
      $css->set_selector( '[class*="wp-block-premium"] h2, [class*="wp-block-premium"] h2 > span' );
      $css->pbg_render_typography($global_typography, 'heading2', 'Mobile');

      $css->set_selector( '[class*="wp-block-premium"] h3, [class*="wp-block-premium"] h3 > span' );
      $css->pbg_render_typography($global_typography, 'heading3', 'Mobile');

      $css->set_selector( '[class*="wp-block-premium"] h4, [class*="wp-block-premium"] h4 > span' );
      $css->pbg_render_typography($global_typography, 'heading4', 'Mobile');

      $css->set_selector( '[class*="wp-block-premium"] h5, [class*="wp-block-premium"] h5 > span' );
      $css->pbg_render_typography($global_typography, 'heading5', 'Mobile');

      $css->set_selector( '[class*="wp-block-premium"] h6, [class*="wp-block-premium"] h6 > span' );
      $css->pbg_render_typography($global_typography, 'heading6', 'Mobile');

      $css->set_selector( '[class*="wp-block-premium"] .premium-button, [class*="wp-block-premium"] .premium-button a,[class*="wp-block-premium"] a:not(h1 > a):not(h2 > a):not(h3 > a):not(h4 > a):not(h5 > a):not(h6 > a)' );
      $css->pbg_render_typography($global_typography, 'button', 'Mobile');

      $css->set_selector( 
        '[class*="wp-block-premium"] p, ' .
        '[class*="wp-block-premium"] label, ' .
        '[class*="wp-block-premium"] li, ' .
        '[class*="wp-block-premium"] .premium-form-input-label, ' .
        '[class*="wp-block-premium"] span:not(h1 span):not(h2 span):not(h3 span):not(h4 span):not(h5 span):not(h6 span):not(button > span):not(a > span)' 
      );
      $css->pbg_render_typography($global_typography, 'paragraph', 'Mobile');

			// Core blocks styles.
			if ( $apply_to_default ) {
        $css->set_selector( '[data-type="core"] > h1, h1[data-type="core"]' );
        $css->pbg_render_typography($global_typography, 'heading1', 'Mobile');

        $css->set_selector( '[data-type="core"] > h2, h2[data-type="core"]' );
        $css->pbg_render_typography($global_typography, 'heading2', 'Mobile');

        $css->set_selector( '[data-type="core"] > h3, h3[data-type="core"]' );
        $css->pbg_render_typography($global_typography, 'heading3', 'Mobile');

        $css->set_selector( '[data-type="core"] > h4, h4[data-type="core"]' );
        $css->pbg_render_typography($global_typography, 'heading4', 'Mobile');

        $css->set_selector( '[data-type="core"] > h5, h5[data-type="core"]' );
        $css->pbg_render_typography($global_typography, 'heading5', 'Mobile');

        $css->set_selector( '[data-type="core"] > h6, h6[data-type="core"]' );
        $css->pbg_render_typography($global_typography, 'heading6', 'Mobile');

        $css->set_selector( '[data-type="core"] .wp-block-button .wp-block-button__link, .wp-block-button[data-type="core"] .wp-block-button__link' );
        $css->pbg_render_typography($global_typography, 'button', 'Mobile');

        $css->set_selector( '[data-type="core"] > p, p[data-type="core"], [data-type="core"] > span, span[data-type="core"], [data-type="core"] > li, li[data-type="core"]' );
        $css->pbg_render_typography($global_typography, 'paragraph', 'Mobile');
			}

			$css->stop_media_query();

			$this->block_helpers->add_custom_block_css( $css->css_output() );
		}

		/**
		 * add_global_color_to_frontend
		 *
		 * @return string
		 */
		public function add_global_color_to_frontend() {
			$global_color_palette = get_option( 'pbg_global_color_palette', 'theme' );
			$apply_to_default     = get_option( 'pbg_global_colors_to_default', false );
			if ( $global_color_palette === 'theme' ) {
				return '';
			}
			$default_value = array(
				'colors'          => array(
					array(
						'slug'  => 'color1',
						'color' => '#0085ba',
					),
					array(
						'slug'  => 'color2',
						'color' => '#333333',
					),
					array(
						'slug'  => 'color3',
						'color' => '#444140',
					),
					array(
						'slug'  => 'color4',
						'color' => '#eaeaea',
					),
					array(
						'slug'  => 'color5',
						'color' => '#ffffff',
					),
				),
				'current_palette' => 'palette-1',
				'custom_colors'   => array(),
			);
			$global_colors = get_option( 'pbg_global_colors', $default_value );
			$css           = new Premium_Blocks_css();
			$css->set_selector( ':root' );
			$css->add_property( '--pbg-global-color1', $css->render_color( $global_colors['colors'][0]['color'] ) );
			$css->add_property( '--pbg-global-color2', $css->render_color( $global_colors['colors'][1]['color'] ) );
			$css->add_property( '--pbg-global-color3', $css->render_color( $global_colors['colors'][2]['color'] ) );
			$css->add_property( '--pbg-global-color4', $css->render_color( $global_colors['colors'][3]['color'] ) );
			$css->add_property( '--pbg-global-color5', $css->render_color( $global_colors['colors'][4]['color'] ) );

			$css->set_selector( '[class*="wp-block-premium"]' );
      $css->add_property('color', 'var(--pbg-global-color3)');
			$css->set_selector( '[class*="wp-block-premium"] h1, [class*="wp-block-premium"] h2, [class*="wp-block-premium"] h3,[class*="wp-block-premium"] h4,[class*="wp-block-premium"] h5,[class*="wp-block-premium"] h6, a:where(:not([class*="button"]))' );
      $css->add_property('color', 'var(--pbg-global-color2)');
			$css->set_selector( 'a:hover:where(:not([class*="button"]))' );
      $css->add_property('color', 'var(--pbg-global-color1)');
			$css->set_selector( '[class*="wp-block-premium"] .premium-button, [class*="wp-block-premium"] .premium-modal-box-modal-lower-close' );
      $css->add_property('color', 'var(--pbg-global-color5)');
      $css->add_property('background-color', 'var(--pbg-global-color1)');
      $css->add_property('border-color', 'var(--pbg-global-color4)');
	
			// Core blocks styles.
			if ( $apply_to_default ) {
				$css->set_selector( '[data-type="core"]' );
				$css->add_property('color', 'var(--pbg-global-color3)');
				$css->set_selector( '[data-type="core"] h1, h1[data-type="core"], [data-type="core"] h2, h2[data-type="core"], [data-type="core"] h3, h3[data-type="core"],[data-type="core"] h4, h4[data-type="core"],[data-type="core"] h5, h5[data-type="core"],[data-type="core"] h6, h6[data-type="core"]' );
        $css->add_property('color', 'var(--pbg-global-color2)');
        $css->set_selector( '[data-type^="core/"] a:hover:where(:not([class*="button"]))' );
        $css->add_property('color', 'var(--pbg-global-color1)');
				$css->set_selector( '[data-type="core"] .wp-block-button .wp-block-button__link, .wp-block-button[data-type="core"] .wp-block-button__link' );
				$css->add_property('color', 'var(--pbg-global-color5)');
        $css->add_property('background-color', 'var(--pbg-global-color1)');
        $css->add_property('border-color', 'var(--pbg-global-color4)');
			}

			$this->block_helpers->add_custom_block_css( $css->css_output() );
		}

		/**
		 * Register Global Settings.
		 *
		 * @return void
		 */
		public function register_pbg_global_settings() {
			// Global Typography Schema.
			$responsive_schema = array(
				'type'       => 'object',
				'properties' => array(
					'Desktop' => array(
						'type' => 'string',
					),
					'Tablet'  => array(
						'type' => 'string',
					),
					'Mobile'  => array(
						'type' => 'string',
					),
					'unit'    => array(
						'type' => 'string',
					),
				),
			);

			$typography_schema = array(
				'type'       => 'object',
				'properties' => array(
					'fontWeight'     => array(
						'type' => 'string',
					),
					'fontStyle'      => array(
						'type' => 'string',
					),
					'textTransform'  => array(
						'type' => 'string',
					),
					'fontFamily'     => array(
						'type' => 'string',
					),
					'textDecoration' => array(
						'type' => 'string',
					),
					'fontSize'       => array(
						'type'       => 'object',
						'properties' => array(
							'Desktop' => array(
								'type' => 'string',
							),
							'Tablet'  => array(
								'type' => 'string',
							),
							'Mobile'  => array(
								'type' => 'string',
							),
							'unit'    => array(
								'type'       => 'object',
								'properties' => array(
									'Desktop' => array(
										'type' => 'string',
									),
									'Tablet'  => array(
										'type' => 'string',
									),
									'Mobile'  => array(
										'type' => 'string',
									),
								),
							),
						),
					),
					'lineHeight'     => $responsive_schema,
					'letterSpacing'  => $responsive_schema,
				),
			);
			// Global Typography Setting register.
			register_setting(
				'pbg_global_settings',
				'pbg_global_typography',
				array(
					'type'         => 'object',
					'description'  => __( 'Config Premium Blocks For Gutenberg Global Typography Settings', 'premium-blocks-for-gutenberg' ),
					'show_in_rest' => array(
						'schema' => array(
							'properties' => array(
								'heading1'  => $typography_schema,
								'heading2'  => $typography_schema,
								'heading3'  => $typography_schema,
								'heading4'  => $typography_schema,
								'heading5'  => $typography_schema,
								'heading6'  => $typography_schema,
								'button'    => $typography_schema,
								'paragraph' => $typography_schema,
							),
						),
					),
					'default'      => array(),
				)
			);
			// Global Colors Setting register.
			register_setting(
				'pbg_global_settings',
				'pbg_global_colors',
				array(
					'type'         => 'object',
					'description'  => __( 'Config Premium Blocks For Gutenberg Global Colors Settings', 'premium-blocks-for-gutenberg' ),
					'show_in_rest' => array(
						'schema' => array(
							'properties' => array(
								'colors'          => array(
									'type'  => 'array',
									'items' => array(
										'type'       => 'object',
										'properties' => array(
											'slug'  => array(
												'type' => 'string',
											),
											'color' => array(
												'type' => 'string',
											),
										),
									),
								),
								'current_palette' => array(
									'type' => 'string',
								),
								'custom_colors'   => array(
									'type'  => 'array',
									'items' => array(
										'type'       => 'object',
										'properties' => array(
											'slug'  => array(
												'type' => 'string',
											),
											'color' => array(
												'type' => 'string',
											),
											'name'  => array(
												'type' => 'string',
											),
										),
									),
								),
							),
						),
					),
					'default'      => array(
						'colors'          => array(
							array(
								'slug'  => 'color1',
								'color' => '#0085ba',
							),
							array(
								'slug'  => 'color2',
								'color' => '#333333',
							),
							array(
								'slug'  => 'color3',
								'color' => '#444140',
							),
							array(
								'slug'  => 'color4',
								'color' => '#eaeaea',
							),
							array(
								'slug'  => 'color5',
								'color' => '#ffffff',
							),
						),
						'current_palette' => 'palette-1',
					),
				)
			);

			register_setting(
				'pbg_global_settings',
				'pbg_custom_colors',
				array(
					'type'         => 'array',
					'description'  => __( 'Config Premium Blocks For Gutenberg Global Colors Settings', 'premium-blocks-for-gutenberg' ),
					'show_in_rest' => array(
						'schema' => array(
							'items' => array(
								'type'       => 'object',
								'properties' => array(
									'name'  => array(
										'type' => 'string',
									),
									'slug'  => array(
										'type' => 'string',
									),
									'color' => array(
										'type' => 'string',
									),
								),
							),
						),
					),
					'default'      => array(),
				)
			);

			// Default Color Palette.
			register_setting(
				'pbg_global_settings',
				'pbg_global_color_palette',
				array(
					'type'              => 'string',
					'description'       => __( 'Config Premium Blocks For Gutenberg Global Color Palette Settings', 'premium-blocks-for-gutenberg' ),
					'sanitize_callback' => 'sanitize_text_field',
					'show_in_rest'      => true,
					'default'           => 'theme',
				)
			);

			// Global Colors Setting register.
			register_setting(
				'pbg_global_settings',
				'pbg_global_color_palettes',
				array(
					'type'         => 'array',
					'description'  => __( 'Config Premium Blocks For Gutenberg Global Colors Settings', 'premium-blocks-for-gutenberg' ),
					'show_in_rest' => array(
						'schema' => array(
							'items' => array(
								'type'       => 'object',
								'properties' => array(
									'id'     => array(
										'type' => 'string',
									),
									'name'   => array(
										'type' => 'string',
									),
									'active' => array(
										'type' => 'boolean',
									),
									'colors' => array(
										'type'  => 'array',
										'items' => array(
											'type'       => 'object',
											'properties' => array(
												'slug'  => array(
													'type' => 'string',
												),
												'color' => array(
													'type' => 'string',
												),
											),
										),
									),
									'type'   => array(
										'type' => 'string',
									),
									'skin'   => array(
										'type' => 'string',
									),
								),
							),
						),
					),
					'default'      => array(),
				)
			);

			register_setting(
				'pbg_global_settings',
				'pbg_global_layout',
				array(
					'type'         => 'object',
					'description'  => __( 'Config Premium Blocks For Gutenberg Global Layout Settings', 'premium-blocks-for-gutenberg' ),
					'show_in_rest' => array(
						'schema' => array(
							'properties' => array(
								'block_spacing'     => array(
									'type' => 'number',
								),
								'container_width'   => array(
									'type' => 'number',
								),
								'tablet_breakpoint' => array(
									'type' => 'number',
								),
								'mobile_breakpoint' => array(
									'type' => 'number',
								),
							),
						),
					),
					'default'      => array(
						'block_spacing'     => 20,
						'container_width'   => 1200,
						'tablet_breakpoint' => 1024,
						'mobile_breakpoint' => 767,
					),
				)
			);

			// Apply colors to default blocks.
			register_setting(
				'pbg_global_settings',
				'pbg_global_colors_to_default',
				array(
					'type'         => 'boolean',
					'description'  => __( 'Config Premium Blocks For Gutenberg Global Colors Settings', 'premium-blocks-for-gutenberg' ),
					'show_in_rest' => true,
					'default'      => false,
				)
			);

			// Apply typography to default blocks.
			register_setting(
				'pbg_global_settings',
				'pbg_global_typography_to_default',
				array(
					'type'         => 'boolean',
					'description'  => __( 'Config Premium Blocks For Gutenberg Global Typography Settings', 'premium-blocks-for-gutenberg' ),
					'show_in_rest' => true,
					'default'      => false,
				)
			);
		}

		/**
		 * Enqueue Script for Meta options
		 */
		public function script_enqueue() {
			$current_sidebar = 'post-editor-sidebar';
			if ( isset( $GLOBALS['pagenow'] ) && 'site-editor.php' === $GLOBALS['pagenow'] ) {
				$current_sidebar = 'site-editor-sidebar';
			}
			$asset_file   = PREMIUM_BLOCKS_PATH . "global-settings/build/{$current_sidebar}/index.asset.php";
			$dependencies = file_exists( $asset_file ) ? include $asset_file : array();
			$dependencies = $dependencies['dependencies'] ?? array();
			array_push( $dependencies, 'pbg-settings-js' );

			wp_enqueue_script(
				"pbg-global-settings-{$current_sidebar}-js",
				PREMIUM_BLOCKS_URL . "global-settings/build/{$current_sidebar}/index.js",
				$dependencies,
				PREMIUM_BLOCKS_VERSION,
				true
			);
			wp_enqueue_style(
				'pbg-global-settings-css',
				PREMIUM_BLOCKS_URL . "global-settings/build/{$current_sidebar}/index.css",
				array(),
				PREMIUM_BLOCKS_VERSION,
				'all'
			);
			wp_localize_script(
				"pbg-global-settings-{$current_sidebar}-js",
				'pbgGlobalSettings',
				array(
					'palettes'     => get_option( 'pbg_global_color_palettes', array() ),
					'apiData'      => apply_filters( 'pb_settings', get_option( 'pbg_blocks_settings', array() ) ),
					'isBlockTheme' => wp_is_block_theme(),
				)
			);
		}
	}
}

/**
 *  Kicking this off by calling 'get_instance()' method
 */
Pbg_Global_Settings::get_instance();
