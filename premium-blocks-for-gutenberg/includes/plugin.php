<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define class 'PBG_Plugin' if not Exists
if ( ! class_exists( 'PBG_Plugin' ) ) {

	/**
	 * Define PBG_Plugin class
	 */
	class PBG_Plugin {

		/**
		 * Member Variable
		 *
		 * @var object instance
		 */
		private static $instance = null;

		/**
		 * Premium Addons Settings Page Slug
		 *
		 * @var page_slug
		 */
		protected $page_slug = 'pb_panel';

		/**
		 * Constructor for the class
		 */
		public function __construct() {
			 // Enqueue the required files
			$this->pbg_setup();
			add_filter( 'plugin_action_links_' . PREMIUM_BLOCKS_BASENAME, array( $this, 'add_action_links' ), 10, 2 );
			add_action( 'plugins_loaded', array( $this, 'load_plugin' ) );
			add_filter('wp_img_tag_add_loading_attr', array( $this, 'gspb_skip_lazy_load' ) , 10, 3);
			// Register Activation hooks.
			register_activation_hook( PREMIUM_BLOCKS_FILE, array( $this, 'set_transient' ) );

			if ( ! $this->is_gutenberg_active() ) {
				return;
			}
		}

		/*
		 * Triggers initial functions
		 *
		 * @since 1.0.0
		 * @access public
		 *
		 * @return void
		 */
		public function pbg_setup() {
			$this->load_domain();

			$this->init_files();
		}

		public function add_action_links( $links ) {
			$new_links[] = sprintf( '<a href="%1$s">%2$s</a>', admin_url( 'admin.php?page=' . $this->page_slug . '&path=welcome' ), __( 'Settings', 'premium-blocks-for-gutenberg' ) );

			return $new_links + $links;
		}

		function gspb_skip_lazy_load($value, $image, $context)
		{
			if (strpos($image, 'no-lazyload') !== false) $value = 'eager';
			return $value;
		}

		/*
		 * Load Premium Block for Gutenberg text domain
		 *
		 * @since 1.0.0
		 * @access public
		 *
		 * @return void
		 */
		public function load_domain() {
			 load_plugin_textdomain( 'premium-blocks-for-gutenberg', false, dirname( PREMIUM_BLOCKS_BASENAME ) . '/languages/' );
		}

		/**
		 * Set transient for admin review notice
		 *
		 * @since 3.1.7
		 * @access public
		 *
		 * @return void
		 */
		public function set_transient() {

			$cache_key = 'premium_notice_' . PREMIUM_BLOCKS_VERSION;

			$expiration = 3600 * 72;

			set_transient( $cache_key, true, $expiration );

			$install_time = get_option( 'pb_install_time' );

			if ( ! $install_time ) {

				$current_time = date( 'j F, Y', time() );

				update_option( 'pb_install_time', $current_time );

				$api_url = 'https://feedback.premiumblocks.io/wp-json/install/v2/add';

				$response = wp_safe_remote_request(
					$api_url,
					array(
						'headers'     => array(
							'Content-Type' => 'application/json',
						),
						'body'        => wp_json_encode(
							array(
								'time' => $current_time,
							)
						),
						'timeout'     => 20,
						'method'      => 'POST',
						'httpversion' => '1.1',
					)
				);

			}
		}

		/*
		 * Load necessary files
		 *
		 * @since 1.0.0
		 * @access public
		 *
		 * @return void
		 */
		public function load_plugin() {
			 require_once PREMIUM_BLOCKS_PATH . 'includes/premium-blocks-css.php';
			 require_once PREMIUM_BLOCKS_PATH . 'classes/class-rest-api.php';
			 require_once PREMIUM_BLOCKS_PATH . 'blocks-config/post.php';
		}

		/**
		 * Setup the post select API endpoint.
		 *
		 * @return void
		 */
		public function is_gutenberg_active() {
			 return function_exists( 'register_block_type' );
		}

		/**
		 * Init files
		 *
		 * @return void
		 */
		public function init_files() {
			require_once PREMIUM_BLOCKS_PATH . 'classes/class-pbg-assets-generator.php';

			if ( is_admin() ) {
				require_once PREMIUM_BLOCKS_PATH . 'admin/includes/rollback.php';
				require_once PREMIUM_BLOCKS_PATH . 'admin/includes/feedback.php';
				
			}
			
			require_once PREMIUM_BLOCKS_PATH . 'admin/includes/pb-panel/class-pb-panel.php';

			require_once PREMIUM_BLOCKS_PATH . 'classes/class-pbg-blocks-helper.php';

			require_once PREMIUM_BLOCKS_PATH . 'classes/class-pbg-blocks-integrations.php';

			require_once PREMIUM_BLOCKS_PATH . 'includes/google-fonts/class-pbg-webfont-loader.php';

			require_once PREMIUM_BLOCKS_PATH . 'includes/google-fonts/class-pbg-fonts.php';

			$settings = apply_filters( 'pb_settings', get_option( 'pbg_blocks_settings', array() ) );

			if ( isset( $settings['enable-post-editor-sidebar'] ) && $settings['enable-post-editor-sidebar'] ) {
				require_once PREMIUM_BLOCKS_PATH . 'global-settings/class-pbg-global-settings.php';
			}
		}

		/**
		 * Creates and returns an instance of the class
		 *
		 * @since 1.0.0
		 * @access public
		 * return object
		 */
		public static function get_instance() {
			if ( self::$instance == null ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
	}
}

if ( ! function_exists( 'pbg_plugin' ) ) {

	/**
	 * Returns an instance of the plugin class.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	function pbg_plugin() {
		 return PBG_Plugin::get_instance();
	}
}

pbg_plugin();
