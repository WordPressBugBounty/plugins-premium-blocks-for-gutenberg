<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Define PBG_Blocks_Helper class
 */
class PBG_Blocks_Helper {

	/**
	 * Class instance
	 *
	 * @var instance
	 */
	private static $instance = null;

	/**
	 * Blocks
	 *
	 * @var blocks
	 */
	public static $blocks;

	/**
	 * Config
	 *
	 * @var config
	 */
	public static $config;

	/**
	 * Stylesheet
	 *
	 * @since 1.13.4
	 *
	 * @var stylesheet
	 */
	public static $stylesheet;

	/**
	 * Page Blocks Variable
	 *
	 * @since 1.6.0
	 *
	 * @var instance
	 */
	public static $page_blocks;

	/**
	 * Member Variable
	 *
	 * @since 0.0.1
	 *
	 * @var instance
	 */
	public static $block_atts;

	/**
	 * PBG Block Flag
	 *
	 * @since 1.8.2
	 *
	 * @var premium_flag
	 */
	public static $premium_flag = false;

	/**
	 * Current Block List
	 *
	 * @since 1.8.2
	 *
	 * @var current_block_list
	 */
	public static $current_block_list = array();

	/**
	 * Global features
	 *
	 * @since 1.8.2
	 *
	 * @var array
	 */
	public $global_features;

	/**
	 * Performance Settings
	 *
	 * @since 2.0.14
	 *
	 * @var array
	 */
	public $performance_settings;

	/**
	 * Blocks Frontend Assets
	 *
	 * @since 2.0.14
	 *
	 * @var Pbg_Assets_Generator
	 */
	public $blocks_frondend_assets;

	/**
	 * Blocks Frontend CSS Deps
	 *
	 * @since 2.0.14
	 *
	 * @var array
	 */
	public $blocks_frontend_css_deps = array();

	/**
	 * Loaded Blocks
	 *
	 * @since 2.0.27
	 *
	 * @var array
	 */
	public $loaded_blocks = array();

	/**
	 * Svg draw blocks
	 *
	 * @since 2.0.26
	 *
	 * @var array
	 */
	public $svg_draw_blocks = array();

	/**
	 * Entrance animation blocks
	 *
	 * @since 2.1.6
	 *
	 * @var array
	 */
	public $entrance_animation_blocks = array();

	/**
	 * Extra options blocks
	 *
	 * @var array
	 */
	public $extra_options_blocks = array();

	/**
	 * Support links blocks
	 *
	 * @var array
	 */
	public $support_links_blocks = array();

	/**
	 * Integrations Settings
	 *
	 * @var array
	 */
	public $integrations_settings;

	/**
	 * Constructor for the class
	 */
	public function __construct() {
		// Blocks Frontend Assets.
		$this->blocks_frondend_assets = new Pbg_Assets_Generator( 'frontend' );
		// Global Features.
		$this->global_features = apply_filters( 'pb_global_features', get_option( 'pbg_global_features', array() ) );
		// Performance Settings.
		$this->performance_settings = apply_filters( 'pb_performance_options', get_option( 'pbg_performance_options', array() ) );
		// Gets Active Blocks.
		self::$blocks = apply_filters( 'pb_options', get_option( 'pb_options', array() ) );
		// Support Links Blocks.
		$this->support_links_blocks = array(
			'premium/container',
			'premium/icon-box',
		);
		// Integrations Settings.
		$this->integrations_settings = apply_filters( 'pb_integrations_options', get_option( 'pbg_integrations_options', array() ) );
		// Gets Plugin Admin Settings.

		self::$config = apply_filters( 'pb_settings', get_option( 'pbg_blocks_settings', array() ) );
		$allow_json   = isset( self::$config['premium-upload-json'] ) ? self::$config['premium-upload-json'] : true;
		if ( $allow_json ) {
			add_filter( 'upload_mimes', array( $this, 'pbg_mime_types' ) ); // phpcs:ignore WordPressVIPMinimum.Hooks.RestrictedHooks.upload_mimes
			add_filter( 'wp_check_filetype_and_ext', array( $this, 'fix_mime_type_json' ), 75, 4 );
		}
		add_action( 'init', array( $this, 'on_init' ), 20 );
		// Enqueue Editor Assets.
		add_action( 'enqueue_block_editor_assets', array( $this, 'pbg_editor' ) );
		// Enqueue Frontend Styles.
		add_action( 'enqueue_block_assets', array( $this, 'pbg_frontend' ) );
		// Enqueue Frontend Scripts.
		add_action( 'wp_enqueue_scripts', array( $this, 'add_blocks_frontend_assets' ), 10 );
		// Register Premium Blocks category.
		add_filter( 'block_categories_all', array( $this, 'register_premium_category' ), 9999991, 2 );
		// Generate Blocks Stylesheet.
		// add_action( 'wp', array( $this, 'generate_stylesheet' ), 99 );
		add_action( 'wp_enqueue_scripts', array( $this, 'generate_stylesheet' ), 20 );
		// Enqueue Generated stylesheet to WP Head.
		add_action( 'wp_head', array( $this, 'print_stylesheet' ), 80 );

		add_action( 'wp_enqueue_scripts', array( $this, 'load_dashicons_front_end' ) );

		add_action( 'enqueue_block_editor_assets', array( $this, 'add_blocks_editor_styles' ) );

		add_filter( 'render_block_premium/container', array( $this, 'equal_height_front_script' ), 1, 2 );

		add_action( 'wp_head', array( $this, 'add_blocks_frontend_inline_styles' ), 80 );

		add_filter( 'render_block', array( $this, 'add_block_style' ), 9, 2 );
		// Add custom breakpoints.
		add_filter( 'Premium_BLocks_mobile_media_query', array( $this, 'mobile_breakpoint' ), 1 );
		add_filter( 'Premium_BLocks_tablet_media_query', array( $this, 'tablet_breakpoint' ), 1 );
		add_filter( 'Premium_BLocks_desktop_media_query', array( $this, 'desktop_breakpoint' ), 1 );

		add_filter( 'render_block_premium/instagram-feed-posts', array( $this, 'instagram_front_script' ), 1, 2 );

		// Add block in template parts in FSE theme styles.
		add_filter( 'render_block', array( $this, 'add_block_style_in_template_parts' ), 9, 2 );

		// Form Block.
		add_filter( 'render_block_premium/form', array( $this, 'form_block_front_script' ), 1, 2 );

		// Submit form with ajax.
		add_action( 'wp_ajax_premium_form_submit', array( $this, 'premium_form_submit' ) );
		add_action( 'wp_ajax_nopriv_premium_form_submit', array( $this, 'premium_form_submit' ) );

		// Get mailchimp lists.
		add_action( 'wp_ajax_premium_blocks_get_mailchimp_lists', array( $this, 'premium_get_mailchimp_lists' ) );

		// Get mailerlite groups.
		add_action( 'wp_ajax_premium_blocks_get_mailerlite_groups', array( $this, 'premium_get_mailerlite_groups' ) );
        add_filter( 'render_block_premium/gallery', array( $this, 'gallery_front_script' ), 2, 2 );

		// After post update, update the _pbg_blocks_version post meta.
		add_action( 'save_post', array( $this, 'update_post_meta' ), 10, 3 );
		if (is_admin()) {
			add_action('init', array($this, 'init_admin_features'));
		}
		
	}

	/**
	 * Update post meta
	 *
	 * @param int     $post_id Post ID.
	 * @param WP_Post $post Post object.
	 * @param bool    $update Whether this is an existing post being updated or not.
	 *
	 * @return void
	 */
	public function update_post_meta( $post_id, $post, $update ) {
		$new_version = time();
		update_post_meta( $post_id, '_pbg_blocks_version', $new_version );
	}

	/**
	 * Get mailerlite groups
	 *
	 * @access public
	 * @return void
	 */
	public function premium_get_mailerlite_groups() {
		// Check if nonce is set.
		check_ajax_referer( 'pa-blog-block-nonce', 'nonce' );

		// Check if api key is set.
		if ( ! isset( $_POST['api_key'] ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'API key is not set.', 'premium-blocks-for-gutenberg' ) ) );
		}

		// Get mailerlite groups.
		$mailerlite_groups = PBG_Blocks_Integrations::get_instance()->get_mailerlite_groups( $_POST['api_key'] );

		// Check if mailerlite groups is empty.
		if ( empty( $mailerlite_groups ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'No groups found.', 'premium-blocks-for-gutenberg' ) ) );
		}

		// Send mailerlite groups.
		wp_send_json_success( array( 'groups' => $mailerlite_groups ) );
	}

	/**
		 * Checks user credentials for specific action
		 *
		 * @since 2.6.8
		 *
		 * @param string $action action.
		 *
		 * @return boolean
		 */
		public static function check_user_can( $action ) {
			return current_user_can( $action );
		}

	/**
	 * Get mailchimp lists
	 *
	 * @access public
	 * @return void
	 */
	public function premium_get_mailchimp_lists() {
		// Check if nonce is set.
		check_ajax_referer( 'pa-blog-block-nonce', 'nonce' );

		// Check if api key is set.
		if ( ! isset( $_POST['api_key'] ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'API key is not set.', 'premium-blocks-for-gutenberg' ) ) );
		}

		// Get mailchimp lists.
		$mailchimp_lists = PBG_Blocks_Integrations::get_instance()->get_mailchimp_lists( $_POST['api_key'] );

		// Check if mailchimp lists is empty.
		if ( empty( $mailchimp_lists ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'No lists found.', 'premium-blocks-for-gutenberg' ) ) );
		}

		// Send mailchimp lists.
		wp_send_json_success( array( 'mailchimp_lists' => $mailchimp_lists ) );
	}

	/**
	 * Premium Form Submit
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function premium_form_submit() {
		// Check if nonce is set.
		check_ajax_referer( 'pbg_form_nonce', 'nonce' );
		// Check if form id is set.
		if ( ! isset( $_POST['form_id'] ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Form id is not set.', 'premium-blocks-for-gutenberg' ) ) );
		}

		// reCAPTCHA settings.
		$recaptcha_settings      = json_decode( wp_unslash( $_POST['recaptcha_settings'] ), true );
		$recaptcha_enabled       = isset( $recaptcha_settings['enabled'] ) ? $recaptcha_settings['enabled'] : false;
		$recaptcha_version       = isset( $recaptcha_settings['version'] ) ? $recaptcha_settings['version'] : '';
		$recaptcha_response      = isset( $recaptcha_settings['response'] ) ? $recaptcha_settings['response'] : '';
		$recaptcha_v2_secret_key = $this->integrations_settings['premium-recaptcha-v2-secret'];
		$recaptcha_v3_secret_key = $this->integrations_settings['premium-recaptcha-v3-secret'];

		// Check if reCAPTCHA is enabled.
		if ( $recaptcha_enabled ) {
			// Check if reCAPTCHA version is v2.
			if ( $recaptcha_version == 'v2' ) {
				// Check if reCAPTCHA response is empty.
				if ( empty( $recaptcha_response ) ) {
					wp_send_json_error( array( 'message' => esc_html__( 'Please verify reCAPTCHA.', 'premium-blocks-for-gutenberg' ) ) );
				}
				// Verify reCAPTCHA.
				$recaptcha_response = wp_remote_get(
					'https://www.google.com/recaptcha/api/siteverify',
					array(
						'body' => array(
							'secret'   => $recaptcha_v2_secret_key,
							'response' => $recaptcha_response,
							'remoteip' => $_SERVER['REMOTE_ADDR'],
						),
					)
				);
				$recaptcha_response = json_decode( wp_remote_retrieve_body( $recaptcha_response ) );
				// Check if reCAPTCHA response is success.
				if ( ! $recaptcha_response->success ) {
					wp_send_json_error( array( 'message' => esc_html__( 'reCAPTCHA verification failed.', 'premium-blocks-for-gutenberg' ) ) );
				}
			}
			// Check if reCAPTCHA version is v3.
			if ( $recaptcha_version == 'v3' ) {
				// Check if reCAPTCHA response is empty.
				if ( empty( $recaptcha_response ) ) {
					wp_send_json_error( array( 'message' => esc_html__( 'Please verify reCAPTCHA.', 'premium-blocks-for-gutenberg' ) ) );
				}
				// Verify reCAPTCHA.
				$recaptcha_response = wp_remote_get(
					'https://www.google.com/recaptcha/api/siteverify',
					array(
						'body' => array(
							'secret'   => $recaptcha_v3_secret_key,
							'response' => $recaptcha_response,
							'remoteip' => $_SERVER['REMOTE_ADDR'],
						),
					)
				);
				$recaptcha_response = json_decode( wp_remote_retrieve_body( $recaptcha_response ) );
				// Check if reCAPTCHA response is success.
				if ( ! $recaptcha_response->success ) {
					wp_send_json_error( array( 'message' => esc_html__( 'reCAPTCHA verification failed.', 'premium-blocks-for-gutenberg' ) ) );
				}
			}
		}
		// Get submit actions.
		$submit_actions = json_decode( wp_unslash( $_POST['submit_actions'] ), true );
		foreach ( $submit_actions as $action => $value ) {
			if ( ! $value ) {
				continue;
			}
			switch ( $action ) {
				case 'sendEmail':
					$email_response = $this->send_email();
					if ( ! $email_response['success'] ) {
						wp_send_json_error( array( 'message' => $email_response['message'] ) );
					}
					break;
				case 'mailchimp':
					$mailchimp_response = $this->mailchimp_subscribe();
					if ( ! $mailchimp_response['success'] ) {
						wp_send_json_error( array( 'message' => $mailchimp_response['message'] ) );
					}
					break;
				case 'mailerlite':
					$mailerlite_response = $this->mailerlite_subscribe();
					if ( ! $mailerlite_response['success'] ) {
						wp_send_json_error( array( 'message' => $mailerlite_response['message'] ) );
					}
					break;
				case 'fluentcrm':
					$fluentcrm_response = $this->fluentcrm_subscribe();
					if ( ! $fluentcrm_response['success'] ) {
						wp_send_json_error( array( 'message' => $fluentcrm_response['message'] ) );
					}
					break;
			}
		}

		// Test send success.
		wp_send_json_success( array( 'message' => esc_html__( 'Form submitted successfully.', 'premium-blocks-for-gutenberg' ) ) );
	}

	/**
	 * FluentCRM Subscribe
	 */
	function fluentcrm_subscribe() {
		// Check if fluentcrm plugin is active.
		if ( ! function_exists( 'FluentCrm' ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'FluentCRM plugin is not active.', 'premium-blocks-for-gutenberg' ) ) );
		}

		// Check if fluentcrm settings is set.
		if ( ! isset( $_POST['fluentcrm_settings'] ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'FluentCRM settings is not set.', 'premium-blocks-for-gutenberg' ) ) );
		}

		// FluentCRM settings.
		$fluentcrm_settings = json_decode( wp_unslash( $_POST['fluentcrm_settings'] ), true );
		$email              = $fluentcrm_settings['email'] ?? '';
		$first_name         = $fluentcrm_settings['firstName'] ?? '';
		$last_name          = $fluentcrm_settings['lastName'] ?? '';
		$lists              = $fluentcrm_settings['lists'] ?? '';
		$tags               = $fluentcrm_settings['tags'] ?? '';

		// Check if email is empty.
		if ( empty( $email ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Email is required.', 'premium-blocks-for-gutenberg' ) ) );
		}

		$contact_data = array(
			'email'      => $email,
			'first_name' => $first_name,
			'last_name'  => $last_name,
			'lists'      => $lists,
		);

		if ( ! empty( $tags ) ) {
			$contact_data['tags'] = $tags;
		}

		$result = FluentCrmApi( 'contacts' )->createOrUpdate( $contact_data );

		if ( $result['id'] ) {
			return array(
				'success' => true,
				'message' => esc_html__( 'FluentCRM subscribed successfully.', 'premium-blocks-for-gutenberg' ),
			);
		}

		return array(
			'success' => false,
			'message' => esc_html__( 'FluentCRM subscription failed.', 'premium-blocks-for-gutenberg' ),
		);
	}

	public function init_admin_features() {
		if (self::check_user_can('install_plugins')) {
			Feedback::get_instance();
		}
	}
	/**
	 * Mailerlite Subscribe
	 */
	function mailerlite_subscribe() {
		// Check if mailerlite settings is set.
		if ( ! isset( $_POST['mailerlite_settings'] ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Mailerlite settings is not set.', 'premium-blocks-for-gutenberg' ) ) );
		}

		// Mailerlite settings.
		$mailerlite_settings = json_decode( wp_unslash( $_POST['mailerlite_settings'] ), true );
		$api_token           = $this->integrations_settings['premium-mailerlite-api-token'] ?? '';
		$api_token_type      = $mailerlite_settings['apiToken'] ?? '';
		$group_id            = $mailerlite_settings['groupId'] ?? '';
		$email               = $mailerlite_settings['email'] ?? '';
		$name                = $mailerlite_settings['name'] ?? '';

		if ( 'custom' === $api_token_type ) {
			$api_token = $mailerlite_settings['apiToken'] ?? '';
		}

		// Check if API token is empty.
		if ( empty( $api_token ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Mailerlite API token is empty.', 'premium-blocks-for-gutenberg' ) ) );
		}

		// Check if email is empty.
		if ( empty( $email ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Email is empty.', 'premium-blocks-for-gutenberg' ) ) );
		}

		$response = PBG_Blocks_Integrations::get_instance()->add_mailerlite_subscriber( $api_token, $email, $name, $group_id );

		return $response;
	}

	/**
	 * Mailchimp Subscribe
	 */
	function mailchimp_subscribe() {
		// Check if mailchimp settings is set.
		if ( ! isset( $_POST['mailchimp_settings'] ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Mailchimp settings is not set.', 'premium-blocks-for-gutenberg' ) ) );
		}

		// Mailchimp settings.
		$mailchimp_settings = json_decode( wp_unslash( $_POST['mailchimp_settings'] ), true );
		$api_key            = $this->integrations_settings['premium-mailchimp-api-key'] ?? '';
		$api_key_type       = $mailchimp_settings['apiKeyType'] ?? '';
		$list_id            = $mailchimp_settings['listId'] ?? '';
		$email              = $mailchimp_settings['email'] ?? '';
		$first_name         = $mailchimp_settings['firstName'] ?? '';
		$last_name          = $mailchimp_settings['lastName'] ?? '';

		if ( 'custom' === $api_key_type ) {
			$api_key = $mailchimp_settings['apiKey'] ?? '';
		}

		// Check if API key is empty.
		if ( empty( $api_key ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Mailchimp API key is empty.', 'premium-blocks-for-gutenberg' ) ) );
		}

		// Check if list ID is empty.
		if ( empty( $list_id ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Mailchimp list ID is empty.', 'premium-blocks-for-gutenberg' ) ) );
		}

		// Check if email is empty.
		if ( empty( $email ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Email is empty.', 'premium-blocks-for-gutenberg' ) ) );
		}

		// Mailchimp API URL.
		$response = PBG_Blocks_Integrations::get_instance()->add_mailchimp_subscriber( $api_key, $list_id, $email, $first_name, $last_name );

		return $response;
	}

	/**
	 * Sent Email
	 */
	function send_email() {
		// Check if form data is set.
		if ( ! isset( $_POST['form_data'] ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Form data is not set.', 'premium-blocks-for-gutenberg' ) ) );
		}

		// Check if email settings is set.
		if ( ! isset( $_POST['email_settings'] ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Email settings is not set.', 'premium-blocks-for-gutenberg' ) ) );
		}

		// Email settings.
		$email_settings = json_decode( wp_unslash( $_POST['email_settings'] ), true );
		$to_email       = isset( $email_settings['to'] ) ? $email_settings['to'] : '';
		$subject        = isset( $email_settings['subject'] ) ? $email_settings['subject'] : '';
		$reply_to       = isset( $email_settings['replyTo'] ) ? $email_settings['replyTo'] : '';
		$cc             = isset( $email_settings['cc'] ) ? $email_settings['cc'] : '';
		$bcc            = isset( $email_settings['bcc'] ) ? $email_settings['bcc'] : '';
		$from_name      = isset( $email_settings['fromName'] ) ? $email_settings['fromName'] : '';

		// Get form data.
		$form_data = json_decode( wp_unslash( $_POST['form_data'] ), true );

		// Mail body.
		$mail_body = '<div style="width: 100%;"><table style="width: 100%; border: 1px solid #ddd; border-collapse: collapse;"><tbody>';
		// Map form data.
		foreach ( $form_data as $key => $value ) {
			// Check if value is array.
			if ( is_array( $value ) ) {
				$value = implode( ', ', $value );
			}
			$mail_body .= '<tr><td style="border: 1px solid #ddd; padding: 10px;">' . esc_html( $key ) . '</td><td style="border: 1px solid #ddd; padding: 10px;">' . esc_html( $value ) . '</td></tr>';
		}
		$mail_body .= '</tbody></table></div>';

		// Headers.
		$headers = array(
			'Content-Type: text/html; charset=UTF-8',
		);

		// Check if from name is set.
		if ( ! empty( $from_name ) ) {
			$headers[] = 'From: ' . $from_name . ' <' . get_option( 'admin_email' ) . '>';
		}

		// Check if reply to is set.
		if ( ! empty( $reply_to ) ) {
			$headers[] = 'Reply-To: ' . get_bloginfo( 'name' ) . ' <' . $reply_to . '>';
		}

		// Check if cc is set.
		if ( ! empty( $cc ) ) {
			$headers[] = 'Cc: ' . $cc;
		}

		// Check if bcc is set.
		if ( ! empty( $bcc ) ) {
			$headers[] = 'Bcc: ' . $bcc;
		}

		// Send mail.
		$mail = wp_mail( $to_email, $subject, $mail_body, $headers );

		// Check if mail is sent.
		if ( $mail ) {
			return array(
				'success' => true,
				'message' => esc_html__( 'Email sent successfully.', 'premium-blocks-for-gutenberg' ),
			);
		} else {
			return array(
				'success' => false,
				'message' => esc_html__( 'Email sending failed.', 'premium-blocks-for-gutenberg' ),
			);
		}
	}

	/**
	 * Form Block Frontend
	 *
	 * Enqueue Frontend Assets for Premium Blocks.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function form_block_front_script( $content, $block ) {
		// Check if there is inner blocks.
		if ( ! isset( $block['innerBlocks'] ) || empty( $block['innerBlocks'] ) ) {
			return $content;
		}

		$dependencies = array( 'wp-element', 'wp-i18n' );
		// Check if reCAPTCHA is enabled.
		if ( isset( $block['attrs']['enableRecaptcha'] ) && $block['attrs']['enableRecaptcha'] ) {
			if ( isset( $block['attrs']['recaptchaVersion'] ) && $block['attrs']['recaptchaVersion'] === 'v3' && $this->integrations_settings['premium-recaptcha-v3-site-key'] !== '' ) {
				wp_enqueue_script(
					'premium-recaptcha-v3',
					'https://www.google.com/recaptcha/api.js?render=' . $this->integrations_settings['premium-recaptcha-v3-site-key'],
					array(),
					PREMIUM_BLOCKS_VERSION,
					true
				);

				$dependencies[] = 'premium-recaptcha-v3';
			} elseif ( $this->integrations_settings['premium-recaptcha-v2-site-key'] !== '' ) {

				wp_enqueue_script(
					'premium-recaptcha-v2',
					'https://www.google.com/recaptcha/api.js',
					array(),
					PREMIUM_BLOCKS_VERSION,
					true
				);

				$dependencies[] = 'premium-recaptcha-v2';
			}
		}

		wp_enqueue_script(
			'premium-form-view',
			PREMIUM_BLOCKS_URL . 'assets/js/build/form/index.js',
			$dependencies,
			PREMIUM_BLOCKS_VERSION,
			true
		);

		wp_localize_script(
			'premium-form-view',
			'PBG_Form',
			apply_filters(
				'premium_form_localize_script',
				array(
					'ajaxurl'   => esc_url( admin_url( 'admin-ajax.php' ) ),
					'nonce'     => wp_create_nonce( 'pbg_form_nonce' ),
					'recaptcha' => array(
						'v2SiteKey' => $this->integrations_settings['premium-recaptcha-v2-site-key'],
						'v3SiteKey' => $this->integrations_settings['premium-recaptcha-v3-site-key'],
					),
				)
			)
		);

		return $content;
	}

	/**
	 * Get Form Inner Blocks
	 *
	 * Get all inner blocks of form block.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array
	 */
	public function get_form_inner_blocks( $inner_blocks ) {
		$form_fields_blocks = array(
			'premium/form-checkbox',
			'premium/form-email',
			'premium/form-name',
			'premium/form-toggle',
			'premium/form-radio',
			'premium/form-accept',
			'premium/form-phone',
			'premium/form-date',
			'premium/form-textarea',
			'premium/form-select',
			'premium/form-url',
			'premium/form-hidden',
		);

		$form_blocks = array();
		foreach ( $inner_blocks as $inner_block ) {
			if ( isset( $inner_block['innerBlocks'] ) && ! empty( $inner_block['innerBlocks'] ) ) {
				$form_blocks = array_merge( $form_blocks, $this->get_form_inner_blocks( $inner_block['innerBlocks'] ) );
			}
			// Check if block is form field block.
			if ( ! in_array( $inner_block['blockName'], $form_fields_blocks, true ) ) {
				continue;
			}
			$form_blocks[ $inner_block['attrs']['blockId'] ] = array(
				'blockName' => $inner_block['blockName'],
				'attrs'     => $this->get_block_attributes( $inner_block ),
			);
		}

		return $form_blocks;
	}

	/**
	 * Add block style in template parts.
	 *
	 * @since 2.0.14
	 *
	 * @param string $content Block content.
	 * @param array  $block Block attributes.
	 *
	 * @return string
	 */
	public function add_block_style_in_template_parts( $content, $block ) {
		$this->add_blocks_assets( array( $block ) );
		return $content;
	}

	/**
	 * PBG Frontend
	 *
	 * Enqueue Frontend Assets for Premium Blocks.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function instagram_front_script( $content, $block ) {
		if ( apply_filters( 'pbg_disable_instagram_script', false ) ) {
			return $content;
		}
		$media_query            = array();
		$media_query['mobile']  = apply_filters( 'Premium_BLocks_mobile_media_query', '(max-width: 767px)' );
		$media_query['tablet']  = apply_filters( 'Premium_BLocks_tablet_media_query', '(max-width: 1024px)' );
		$media_query['desktop'] = apply_filters( 'Premium_BLocks_tablet_media_query', '(min-width: 1025px)' );

		if ( isset( $block['attrs']['clickAction'] ) && 'lightBox' === $block['attrs']['clickAction'] ) {
			$images_lightbox_js = PREMIUM_BLOCKS_URL . 'assets/js/lib/fslightbox.js';

			wp_enqueue_script(
				'image-gallery-fslightbox-js',
				$images_lightbox_js,
				array( 'jquery' ),
				PREMIUM_BLOCKS_VERSION,
				true
			);
		}

		// View file after move it to "assets/js".
		wp_enqueue_script(
			'premium-instagram-feed-view',
			PREMIUM_BLOCKS_URL . 'assets/js/build/instagram-feed/index.js',
			array( 'jquery' ),
			PREMIUM_BLOCKS_VERSION,
			true
		);

		// carousel slick css.
		wp_enqueue_style(
			'premium-instagram-feed-view',
			PREMIUM_BLOCKS_URL . 'assets/js/build/instagram-feed/view.css',
			array(),
			PREMIUM_BLOCKS_VERSION
		);

		wp_localize_script(
			'premium-instagram-feed-view',
			'PBGPRO_InstaFeed',
			apply_filters(
				'premium_instagram_feed_localize_script',
				array(
					'ajaxurl'     => esc_url( admin_url( 'admin-ajax.php' ) ),
					'breakPoints' => $media_query,
					'pluginURL'   => PREMIUM_BLOCKS_URL,
				)
			)
		);
		return $content;
	}

	public function gallery_front_script( $content, $block ) {
	
		$media_query            = array();
		$media_query['mobile']  = apply_filters( 'Premium_BLocks_mobile_media_query', '(max-width: 767px)' );
		$media_query['tablet']  = apply_filters( 'Premium_BLocks_tablet_media_query', '(max-width: 1024px)' );
		$media_query['desktop'] = apply_filters( 'Premium_BLocks_tablet_media_query', '(min-width: 1025px)' );

		wp_enqueue_script(
			'premium-image-loaded',
			PREMIUM_BLOCKS_URL . 'assets/js/lib/imageLoaded.min.js',
            array( "jquery" ),
			PREMIUM_BLOCKS_VERSION,
			true
		);
		wp_enqueue_script(
			'premium-isotope',
			PREMIUM_BLOCKS_URL . 'assets/js/lib/isotope.pkgd.min.js',
            array( "jquery"),
			PREMIUM_BLOCKS_VERSION,
			true
		);
		wp_enqueue_script(
			'premium-gallery-view',
			PREMIUM_BLOCKS_URL . 'assets/js/build/gallery/index.js',
            array( 'wp-element', 'wp-i18n' ,'premium-image-loaded',"premium-isotope"),
			PREMIUM_BLOCKS_VERSION,
			true
		);
		wp_localize_script(
			'premium-gallery-view',
			'PBGPRO_Gallery',
			apply_filters(
				'premium_gallery_localize_script',
				array(
					'ajaxurl'     => esc_url( admin_url( 'admin-ajax.php' ) ),
					'breakPoints' => $media_query,
					'pluginURL'   => PREMIUM_BLOCKS_URL,
				)
			)
		);

		wp_localize_script(
			'premium-gallery-view',
			'PremiumBlocksSettings',
			array(
				'defaultAuthImg'    =>  PREMIUM_BLOCKS_URL . 'assets/img/author.jpg'
			)
		);
		return $content;
	}

	/**
	 * Get Premium Blocks Names
	 *
	 * @return array
	 */
	public function get_premium_blocks_names() {
		$blocks_array = array(
			'premium/accordion'             => array(
				'name'       => 'accordion',
				'style_func' => 'get_premium_accordion_css_style',
			),
			'premium/accordion-item'        => array(
				'name'       => 'accordion-item',
				'style_func' => null,
			),
			'premium/banner'                => array(
				'name'       => 'banner',
				'style_func' => 'get_premium_banner_css_style',
			),
			'premium/bullet-list'           => array(
				'name'       => 'bullet-list',
				'style_func' => 'get_premium_bullet_list_css_style',
			),
			'premium/list-item'             => array(
				'name'       => 'list-item',
				'style_func' => null,
			),
			'premium/countup'               => array(
				'name'       => 'count-up',
				'style_func' => 'get_premium_count_up_css_style',
			),
			'premium/counter'               => array(
				'name'       => 'counter',
				'style_func' => 'get_premium_counter_css',
			),
			'premium/dheading-block'        => array(
				'name'       => 'dual-heading',
				'style_func' => 'get_premium_dual_heading_css_style',
			),
			'premium/heading'               => array(
				'name'       => 'heading',
				'style_func' => 'get_premium_heading_css_style',
			),
			'premium/icon'                  => array(
				'name'       => 'icon',
				'style_func' => 'get_premium_icon_css_style',
			),
			'premium/icon-box'              => array(
				'name'       => 'icon-box',
				'style_func' => 'get_premium_icon_box_css_style',
			),
			'premium/maps'                  => array(
				'name'       => 'maps',
				'style_func' => 'get_premium_maps_css_style',
			),
			'premium/pricing-table'         => array(
				'name'       => 'pricing-table',
				'style_func' => 'get_premium_pricing_table_css_style',
			),
			'premium/section'               => array(
				'name'       => 'section',
				'style_func' => 'get_premium_section_css_style',
			),
			'premium/testimonial'           => array(
				'name'       => 'testimonials',
				'style_func' => 'get_premium_testimonials_css_style',
			),
			'premium/video-box'             => array(
				'name'       => 'video-box',
				'style_func' => 'get_premium_video_box_css_style',
			),
			'premium/fancy-text'            => array(
				'name'       => 'fancy-text',
				'style_func' => 'get_premium_fancy_text_css_style',
			),
			'premium/lottie'                => array(
				'name'       => 'lottie',
				'style_func' => 'get_premium_lottie_css_style',
			),
			'premium/modal'                 => array(
				'name'       => 'Modal',
				'style_func' => 'get_premium_modal_css_style',
			),
			'premium/image-separator'       => array(
				'name'       => 'image-separator',
				'style_func' => 'get_premium_image_separator_css_style',
			),
			'premium/person'                => array(
				'name'       => 'person',
				'style_func' => 'get_premium_person_css_style',
			),
			'premium/container'             => array(
				'name'       => 'container',
				'style_func' => 'get_premium_container_css_style',
			),
			'premium/content-switcher'      => array(
				'name'       => 'content-switcher',
				'style_func' => 'get_content_switcher_css_style',
			),
			'premium/buttons'               => array(
				'name'       => 'buttons',
				'style_func' => 'get_premium_button_group_css_style',
			),
		
			'premium/badge'                 => array(
				'name'       => 'badge',
				'style_func' => 'get_premium_badge_css',
			),
			'premium/button'                => array(
				'name'       => 'button',
				'style_func' => 'get_premium_button_css_style',
			),
			'premium/icon-group'            => array(
				'name'       => 'icon-group',
				'style_func' => 'get_premium_icon_group_css',
			),
			'premium/image'                 => array(
				'name'       => 'image',
				'style_func' => 'get_premium_image_css',
			),
			'premium/price'                 => array(
				'name'       => 'price',
				'style_func' => 'get_premium_price_css',
			),
			'premium/switcher-child'        => array(
				'name'       => 'switcher-child',
				'style_func' => 'get_premium_switcher_child_css',
			),
			'premium/text'                  => array(
				'name'       => 'text',
				'style_func' => 'get_premium_text_css',
			),
			'premium/instagram-feed'        => array(
				'name'       => 'instagram-feed',
				'style_func' => null,
			),
			'premium/instagram-feed-header' => array(
				'name'       => 'instagram-feed-header',
				'style_func' => 'get_premium_instagram_feed_header_css',
			),
			'premium/instagram-feed-posts'  => array(
				'name'       => 'instagram-feed-posts',
				'style_func' => 'get_premium_instagram_feed_posts_css',
			),
			'premium/post-carousel'         => array(
				'name'       => 'post',
				'style_func' => array( new PBG_POST(), 'get_premium_post_css_style' ),
			),
			'premium/post-grid'             => array(
				'name'       => 'post',
				'style_func' => array( new PBG_POST(), 'get_premium_post_css_style' ),
			),
			'premium/post'                  => array(
				'name'       => 'post',
				'style_func' => array( 'PBG_Post', 'get_premium_post_css_style' ),
			),
			'premium/svg-draw'              => array(
				'name'       => 'svg-draw',
				'style_func' => 'get_premium_svg_draw_css_style',
			),
			'premium/form'                  => array(
				'name'       => 'form',
				'style_func' => 'get_premium_form_css_style',
			),
			'premium/form-checkbox'         => array(
				'name'       => 'form-checkbox',
				'style_func' => null,
			),
			'premium/form-email'            => array(
				'name'       => 'form-email',
				'style_func' => null,
			),
			'premium/form-name'             => array(
				'name'       => 'form-name',
				'style_func' => null,
			),
			'premium/form-toggle'           => array(
				'name'       => 'form-toggle',
				'style_func' => null,
			),
			'premium/form-radio'            => array(
				'name'       => 'form-radio',
				'style_func' => null,
			),
			'premium/form-accept'           => array(
				'name'       => 'form-accept',
				'style_func' => null,
			),
			'premium/form-phone'            => array(
				'name'       => 'form-phone',
				'style_func' => null,
			),
			'premium/form-date'             => array(
				'name'       => 'form-date',
				'style_func' => null,
			),
			'premium/form-textarea'         => array(
				'name'       => 'form-textarea',
				'style_func' => null,
			),
			'premium/form-select'           => array(
				'name'       => 'form-select',
				'style_func' => null,
			),
			'premium/form-url'              => array(
				'name'       => 'form-url',
				'style_func' => null,
			),
			'premium/form-hidden'           => array(
				'name'       => 'form-hidden',
				'style_func' => null,
			),
			'premium/gallery'           => array(
				'name'       => 'gallery',
				'style_func' => null,
			),
			'premium/tabs'           => array(
				'name'       => 'tabs',
				'style_func' => 'get_premium_tabs_css_style',
			),
			'premium/tab-item'           => array(
				'name'       => 'tab-item',
				'style_func' => '',
			),
			);

		return $blocks_array;
	}

	/**
	 * Mobile breakpoint
	 *
	 * @param  string $breakpoint
	 * @return string
	 */
	public function mobile_breakpoint( $breakpoint ) {
		$layout_settings = get_option( 'pbg_global_layout', array() );
		$breakpoint      = isset( $layout_settings['mobile_breakpoint'] ) ? '(max-width: ' . $layout_settings['mobile_breakpoint'] . 'px)' : $breakpoint;

		return $breakpoint;
	}

	/**
	 * Tablet breakpoint
	 *
	 * @param  string $breakpoint
	 * @return string
	 */
	public function tablet_breakpoint( $breakpoint ) {
		$layout_settings = get_option( 'pbg_global_layout', array() );
		$breakpoint      = isset( $layout_settings['tablet_breakpoint'] ) ? '(max-width: ' . $layout_settings['tablet_breakpoint'] . 'px)' : $breakpoint;
		return $breakpoint;
	}

	/**
	 * Desktop breakpoint
	 *
	 * @param  string $breakpoint
	 * @return string
	 */
	public function desktop_breakpoint( $breakpoint ) {
		$layout_settings = get_option( 'pbg_global_layout', array() );
		$breakpoint      = isset( $layout_settings['tablet_breakpoint'] ) ? '(min-width: ' . ( $layout_settings['tablet_breakpoint'] + 1 ) . 'px)' : $breakpoint;
		return $breakpoint;
	}

	/**
	 * Generate assets files feature.
	 *
	 * @return bool
	 */
	public function generate_assets_files() {
		$global_settings = apply_filters( 'pb_settings', get_option( 'pbg_blocks_settings', array() ) );
		return $global_settings['generate-assets-files'] ?? true;
	}

	/**
	 * Add block css file to the frontend assets.
	 *
	 * @param string $src The css file url.
	 */
	public function add_block_css( $src, $dependencies = array() ) {
		$this->blocks_frondend_assets->pbg_add_css( $src );
		if ( ! empty( $dependencies ) ) {
			$this->blocks_frontend_css_deps = array_merge( $this->blocks_frontend_css_deps, $dependencies );
		}
	}

	/**
	 * Add inline css to the frontend assets.
	 */
	public function add_blocks_frontend_inline_styles() {
		if ( $this->generate_assets_files() ) {
			return;
		}
		$this->add_blocks_assets();
		$this->blocks_frondend_assets->add_inline_css( $this->get_custom_block_css() );
		$inline_css = $this->blocks_frondend_assets->get_inline_css();
		if ( ! empty( $inline_css ) ) {
			echo '<style id="pbg-blocks-frontend-inline-css">' . $inline_css . '</style>';
		}
	}

	/**
	 * Add css.
	 *
	 * @param array $blocks The blocks array.
	 *
	 * @return void
	 */
	public function add_css( $blocks ) {
		 // Add block css file to the frontend assets.
		$blocks_names = $this->get_premium_blocks_names();
		foreach ( $blocks_names as $name => $block ) {
			$slug = $block['name'];
			if ( ! $this->has_block( $name, $blocks ) ) {
				continue;
			}

			if ( ! file_exists( PREMIUM_BLOCKS_PATH . "assets/css/minified/{$slug}.min.css" ) ) {
				continue;
			}

			$this->add_block_css( "assets/css/minified/{$slug}.min.css" );
		}
	}

	/**
	 * Register blocks animation.
	 *
	 * @param array $blocks.
	 *
	 * @return void
	 */
	private function register_animation_blocks( $blocks ) {
		foreach ( $blocks as $block ) {
			$this->register_block_data( $block );
		}
	}

	/**
	 * Enqueue frontend assets.
	 */
	public function add_blocks_frontend_assets() {
		if ( ! $this->generate_assets_files() ) {
			return;
		}
		$this->add_blocks_assets();
		$this->blocks_frondend_assets->set_post_id( get_the_ID() );
		$this->blocks_frondend_assets->add_inline_css( $this->get_custom_block_css() );
		$css_url = $this->blocks_frondend_assets->get_css_url();

		if ( ! empty( $css_url ) ) {
			$version = get_post_meta( get_the_ID(), '_pbg_blocks_version', true );
			if ( ! $version ) {
				$version = PREMIUM_BLOCKS_VERSION;
			}
			wp_enqueue_style( 'pbg-blocks-frontend-css', $css_url, array_values( $this->blocks_frontend_css_deps ), $version );
		}
	}

	/**
	 * Add blocks assets.
	 *
	 * @param array $blocks The blocks array.
	 *
	 * @return void
	 */
	public function add_blocks_assets( $blocks = array() ) {
		if ( empty( $blocks ) ) {
			$post_id = get_the_ID();
			$blocks  = parse_blocks( get_post_field( 'post_content', $post_id ) );
		}
		$this->add_css( $blocks );
		$this->add_blocks_dynamic_css( $blocks );
		$this->register_animation_blocks( $blocks );
		$this->enqueue_features_script();
	}

	/**
	 * Get block unique id.
	 *
	 * @param  string $block_name The block name.
	 * @param  array  $attributes The block attributes.
	 * @return string
	 */
	public function get_block_unique_id( $block_name, $attributes ) {
		$unique_id    = '';
		$blocks_names = $this->get_premium_blocks_names();
		$block_data   = $blocks_names[ $block_name ] ?? array();
		switch ( $block_name ) {
			case 'premium/banner':
			case 'premium/countup':
			case 'premium/lottie':
			case 'premium/pricing-table':
			case 'premium/testimonial':
				$unique_name = explode( '/', $block_data['name'] );
				$unique_name = end( $unique_name );
				if ( isset( $attributes['block_id'] ) && ! empty( $attributes['block_id'] ) ) {
					$unique_id = "#premium-{$unique_name}-{$attributes['block_id']}";
				}
				if ( isset( $attributes['blockId'] ) && ! empty( $attributes['blockId'] ) ) {
					$unique_id = ".{$attributes['blockId']}";
				}
				break;
			case 'premium/buttons':
			case 'premium/maps':
				if ( isset( $attributes['blockId'] ) && ! empty( $attributes['blockId'] ) ) {
					$unique_id = ".{$attributes['blockId']}";
				}
				break;
			case 'premium/container':
				if ( isset( $attributes['block_id'] ) && ! empty( $attributes['block_id'] ) ) {
					$unique_id = $attributes['block_id'];
				}
				break;
			case 'premium/dheading-block':
				if ( isset( $attributes['block_id'] ) && ! empty( $attributes['block_id'] ) ) {
					$unique_id = "#premium-dheading-block-{$attributes['block_id']}";
				}

				if ( isset( $attributes['blockId'] ) && ! empty( $attributes['blockId'] ) ) {
					$unique_id = ".{$attributes['blockId']}";
				}
				break;
			case 'premium/heading':
				if ( isset( $attributes['block_id'] ) && ! empty( $attributes['block_id'] ) ) {
					$unique_id = "#premium-title-{$attributes['block_id']}";
				}

				if ( isset( $attributes['blockId'] ) && ! empty( $attributes['blockId'] ) ) {
					$unique_id = ".{$attributes['blockId']}";
				}
				break;
			case 'premium/section':
				if ( isset( $attributes['block_id'] ) && ! empty( $attributes['block_id'] ) ) {
					$unique_id = '.premium-container';
				}

				if ( isset( $attributes['blockId'] ) && ! empty( $attributes['blockId'] ) ) {
					$unique_id = ".{$attributes['blockId']}";
				}
				break;
			case 'premium/tabs' :
				if ( isset( $attributes['blockId'] ) && ! empty( $attributes['blockId'] ) ) {

					$unique_id = ".{$attributes['blockId']}";

				}
				break;
			default:
				$unique_id = ( ! empty( $attributes['blockId'] ) ) ? $attributes['blockId'] : '';
				break;
		}
		return $unique_id;
	}

	/**
	 * Get extra options css.
	 *
	 * @param string $block_id The block id.
	 * @param string $block_name The block name.
	 * @param array  $attrs The block attributes.
	 *
	 * @return array
	 */
	public function get_extra_options_css( $block_id, $block_name, $attrs ) {
		$css = new Premium_Blocks_css();
		if ( '.' === substr( $block_id, 0, 1 ) ) {
			$block_id = substr( $block_id, 1 );
		}

		if ( 'premium/container' === $block_name ) {
			$block_id = 'premium-container-' . $block_id;
		}

		if ( in_array( $block_name, $this->support_links_blocks, true ) ) {
			$link_settings = $attrs['pbgLinkSettings'] ?? array();
			if ( isset( $link_settings['enable'] ) && ! empty( $link_settings['enable'] ) ) {
				$css->set_selector( ".{$block_id}" );
				$css->add_property( 'cursor', 'pointer' );
			}
		}

		if ( isset( $attrs['pbgzIndex'] ) ) {
			$css->set_selector( ".{$block_id}" );
			$css->add_property( 'z-index', $attrs['pbgzIndex'] . ' !important' );
		}

		if ( isset( $attrs['pbgWidth'] ) ) {
			$css->set_selector( ".{$block_id}" );
			$css->add_property( 'width', $css->render_range( $attrs['pbgWidth'], 'Desktop' ) . ' !important' );
		}
		if ( isset( $attrs['blockMargin'] ) ) {
			$block_margin = $attrs['blockMargin'];

			$css->set_selector( ":root:has(.{$block_id}) .{$block_id}" );
			$css->add_property( 'margin', $css->render_spacing( $block_margin['Desktop'],$block_margin['unit']['Desktop']));
		}
		if ( isset( $attrs['blockPadding'] ) ) {
			$block_padding = $attrs['blockPadding'];

			$css->set_selector( ".{$block_id}" );
			$css->add_property( 'padding', $css->render_string($css->render_spacing( $block_padding['Desktop'],$block_padding['unit']['Desktop']),' !important' ));
		}
		// Tablet.
		$css->start_media_query( 'tablet' );
		if ( isset( $attrs['pbgWidth'] ) ) {
			$css->set_selector( ".{$block_id}" );
			$css->add_property( 'width', $css->render_range( $attrs['pbgWidth'], 'Tablet' ) . ' !important' );
		}

		if ( isset( $attrs['blockMargin'] ) ) {
			$block_margin = $attrs['blockMargin'];

			$css->set_selector( ":root:has(.{$block_id}) .{$block_id}" );
			$css->add_property( 'margin', $css->render_spacing( $block_margin['Tablet'],$block_margin['unit']['Tablet']) );
		}

    if ( isset( $attrs['blockPadding'] ) ) {
			$block_padding = $attrs['blockPadding'];

			$css->set_selector( ".{$block_id}" );
			$css->add_property( 'padding', $css->render_string($css->render_spacing( $block_padding['Tablet'],$block_padding['unit']['Tablet']),' !important' ));
		}
		$css->stop_media_query();

		// Mobile.
		$css->start_media_query( 'mobile' );
		if ( isset( $attrs['pbgWidth'] ) ) {
			$css->set_selector( ".{$block_id}" );
			$css->add_property( 'width', $css->render_range( $attrs['pbgWidth'], 'Mobile' ) . ' !important' );
		}

		if ( isset( $attrs['blockMargin'] ) ) {
			$block_margin = $attrs['blockMargin'];

			$css->set_selector( ":root:has(.{$block_id}) .{$block_id}" );
			$css->add_property( 'margin', $css->render_spacing( $block_margin['Mobile'],$block_margin['unit']['Mobile']) );
		}

    if ( isset( $attrs['blockPadding'] ) ) {
			$block_padding = $attrs['blockPadding'];

			$css->set_selector( ".{$block_id}" );
			$css->add_property( 'padding', $css->render_string($css->render_spacing( $block_padding['Mobile'],$block_padding['unit']['Mobile']),' !important' ));
		}
		$css->stop_media_query();

		return $css->css_output();
	}

	/**
	 * Get svg draw css.
	 *
	 * @param string $block_id The block id.
	 * @param string $block_name The block name.
	 * @param array  $attrs The block attributes.
	 *
	 * @return array
	 */
	public function get_svg_draw_css( $block_id, $block_name, $attrs ) {
		$css = new Premium_Blocks_css();

		if ( 'premium/svg-draw' === $block_name && isset( $attrs['svgDraw'] ) && $attrs['svgDraw']['enabled'] ) {
			if ( '.' === substr( $block_id, 0, 1 ) ) {
				$block_id = substr( $block_id, 1 );
			}
			$svg_draw = $attrs['svgDraw'];
			$css->set_selector( ".{$block_id} svg *" );
			$css->add_property( 'stroke', "{$svg_draw['strokeColor']} !important" );
			$css->add_property( 'stroke-width', $css->get_responsive_css( $svg_draw['strokeWidth'], 'Desktop' ) );

			// Tablet.
			$css->start_media_query( 'tablet' );
			$css->add_property( 'stroke-width', $css->get_responsive_css( $svg_draw['strokeWidth'], 'Tablet' ) );

			// Mobile.
			$css->start_media_query( 'mobile' );
			$css->add_property( 'stroke-width', $css->get_responsive_css( $svg_draw['strokeWidth'], 'Mobile' ) );
		}

		return $css->css_output();
	}

	public function export_settings() {
		return self::$config;
	}
	/**
	 * Add block dynamic css.
	 *
	 * @param array  $block The block data.
	 * @param string $block_name The block name.
	 *
	 * @return void
	 */
	function add_block_dynamic_css( $block, $block_name ) {
		$unique_id = $this->get_block_unique_id( $block_name, $block['attrs'] );
		if ( in_array( $unique_id, $this->loaded_blocks ) ) {
			return;
		}
		$this->loaded_blocks[] = $unique_id;

		$blocks_names = $this->get_premium_blocks_names();
		if ( ! isset( $blocks_names[ $block_name ] ) ) {
			return;
		}
		$block_data = $blocks_names[ $block_name ];
		$style_func = $block_data['style_func'];

		$attr       = $this->get_block_attributes( $block );
    
		if ( ! empty( $style_func ) ) {
			$unique_id = $this->get_block_unique_id( $block_name, $attr );
			if ( ! is_callable( $style_func ) ) {
				return;
			}
			if ( is_array( $style_func ) ) {
				$class      = $style_func[0];
				$instance   = $class::get_instance();
				$style_func = array( $instance, $style_func[1] );
			}
			$css = call_user_func( $style_func, $attr, $unique_id );

			if ( apply_filters( 'Premium_BLocks_blocks_render_inline_css', true, $block_data['name'], $unique_id ) ) {
				if ( ! empty( $css ) ) {
					$this->add_custom_block_css( $css );
				}
			}
		}

		$extra_options_css = $this->get_extra_options_css( $unique_id, $block_name, $attr );
		if ( ! empty( $extra_options_css ) ) {
			$this->add_custom_block_css( $extra_options_css );
		}

		$svg_draw_css = $this->get_svg_draw_css( $unique_id, $block_name, $attr );
		if ( ! empty( $svg_draw_css ) ) {
			$this->add_custom_block_css( $svg_draw_css );
		}
	}

	/**
	 * Add block dynamic css.
	 *
	 * @param array $blocks The blocks data.
	 *
	 * @return void
	 */
	public function add_blocks_dynamic_css( $blocks ) {
		foreach ( $blocks ?? array() as $block ) {
			// Check if premium block by block name.
			$block_name = $block['blockName'];

			if ( ! empty( $block['innerBlocks'] ) ) {
				$this->add_inner_blocks_dynamic_css( $block['innerBlocks'] );
			}

			if ( ! $this->is_premium_block( $block_name ) ) {
				continue;
			}

			$this->add_block_dynamic_css( $block, $block_name );
		}
	}

	/**
	 * Add inner blocks dynamic css.
	 *
	 * @param array $inner_blocks
	 *
	 * @return void
	 */
	public function add_inner_blocks_dynamic_css( $inner_blocks ) {
		foreach ( $inner_blocks as $block ) {
			// Check if premium block by block name.
			$block_name = $block['blockName'];

			if ( ! empty( $block['innerBlocks'] ) ) {
				$this->add_inner_blocks_dynamic_css( $block['innerBlocks'] );
			}

			if ( ! $this->is_premium_block( $block_name ) ) {
				continue;
			}

			$this->add_block_dynamic_css( $block, $block_name );
		}
	}

	/**
	 * Check if the page has a specific block.
	 *
	 * @param string $block_name The block name.
	 * @param array  $blocks The blocks data.
	 *
	 * @return bool
	 */
	function has_block( $block_name, $blocks ) {
		foreach ( $blocks ?? array() as $block ) {
			if ( $block['blockName'] === $block_name ) {
				return true;
			}

			if ( ! empty( $block['innerBlocks'] ) ) {
				$has_block = $this->check_inner_blocks( $block['innerBlocks'], $block_name );
				if ( $has_block ) {
					return true;
				}
			}
		}

		return false;
	}


	
	/**
	 * Get allowed HTML title tag.
	 *
	 * @param string $title_Tag HTML tag of title.
	 * @param array  $allowed_array Array of allowed HTML tags.
	 * @param string $default_tag Default HTML tag.
	 * @return string $title_Tag | $default_tag.
	 */
	public static function title_tag_allowed_html( $title_Tag, $allowed_array, $default_tag ) {
		return in_array( $title_Tag, $allowed_array, true ) ? sanitize_key( $title_Tag ) : $default_tag;
	}

	
	/**
	 * Check inner blocks.
	 *
	 * @param array  $inner_blocks
	 * @param string $block_name
	 *
	 * @return bool
	 */
	function check_inner_blocks( $inner_blocks, $block_name ) {
		foreach ( $inner_blocks as $inner_block ) {
			if ( $inner_block['blockName'] === $block_name ) {
				return true;
			}

			if ( ! empty( $inner_block['innerBlocks'] ) ) {
				$has_block = $this->check_inner_blocks( $inner_block['innerBlocks'], $block_name );
				if ( $has_block ) {
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * Add the clientId attribute to the block element.
	 *
	 * @param string $block_content The HTML content of the block.
	 * @param array  $block The block data.
	 *
	 * @return string The updated HTML content of the block.
	 */
	public function add_block_style( $block_content, $block ) {
		if ( $this->is_premium_block( $block['blockName'] ) ) {
			// Find the style tag and its contents.
			preg_match( '/<style(?:\s+(?:class|id)="[^"]*")*>(.*?)<\/style>/s', $block_content, $matches );

			// If a style tag was found, store its contents.
			if ( ! empty( $matches ) ) {
				$style_content = $matches[1];
				$this->add_custom_block_css( $style_content );
				// Remove all style tags and their contents from the block content.
				$block_content = preg_replace( '/<style(?:\s+(?:class|id)="[^"]*")*>(.*?)<\/style>/s', '', $block_content );
			}
		}

		return $block_content;
	}

	/**
	 * Check if any value in an array is not empty.
	 *
	 * @param array $array An array of key-value pairs to check for non-empty values.
	 * @return bool Whether any of the values in the array are not empty.
	 */
	public function check_if_any_value_not_empty( $array ) {
		if ( ! is_array( $array ) ) {
			return false;
		}
		foreach ( $array as $key => $value ) {
			if ( ! empty( $value ) ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Check if a block name is a premium block.
	 *
	 * @param string $block_name The name of the block to check.
	 *
	 * @return bool True if the block name starts with "premium/", false otherwise.
	 */
	public function is_premium_block( $block_name ) {
		if ( $block_name !== null && strpos( $block_name, 'premium/' ) !== false ) {
			return true;
		} else {
			return false;
		}
	}


	/**
	 * Registers blocks with features.
	 *
	 * @param array $block         The block attributes.
	 *
	 * @return string $block_content The block content.
	 */
	public function register_block_data( $block ) {
		$attrs = $block['attrs'];
		if ( $this->is_premium_block( $block['blockName'] ) ) {
			$attrs = $this->get_block_attributes( $block );
		}
		if ( 'premium/svg-draw' === $block['blockName'] && isset( $attrs['svgDraw'] ) ) {
			$svg_draw = $attrs['svgDraw'];
			if ( $svg_draw['enabled'] ) {
				$this->svg_draw_blocks[ $attrs['blockId'] ] = $attrs['svgDraw'];
			}
		}

		if ( ! $this->global_features['premium-entrance-animation-all-blocks'] && ! $this->is_premium_block( $block['blockName'] ) ) {
			return;
		}

		if ( $this->global_features['premium-entrance-animation'] && isset( $attrs['entranceAnimation'] ) && $this->check_if_any_value_not_empty( $attrs['entranceAnimation']['animation'] ) ) {
			$this->entrance_animation_blocks[ $attrs['entranceAnimation']['clientId'] ] = $attrs['entranceAnimation'];
		}

		if ( in_array( $block['blockName'], $this->support_links_blocks, true ) ) {
			$link_settings = $attrs['pbgLinkSettings'] ?? array();
			if ( isset( $link_settings['enable'] ) && $link_settings['enable'] ) {
				$link_id = $this->get_block_unique_id( $block['blockName'], $attrs );
				if ( '.' === substr( $link_id, 0, 1 ) ) {
					$link_id = substr( $link_id, 1 );
				}

				if ( 'premium/container' === $block['blockName'] ) {
					$link_id = 'premium-block-' . $link_id;
				}

				if ( $link_id ) {
					$this->extra_options_blocks[ $link_id ]['link'] = $link_settings;
				}
			}
		}
	}

	/**
	 * Get block attributes.
	 *
	 * @param array $block The block data
	 *
	 * @return array
	 */
	public function get_block_attributes( $block ) {
		$blocks_names = $this->get_premium_blocks_names();
		$block_data   = $blocks_names[ $block['blockName'] ] ?? array();
		if ( empty( $block_data ) ) {
			return array();
		}
		// Get default attributes from block.json.
		$default_attrs = array();
		// Check if block.json file exists.
		$json_file = PREMIUM_BLOCKS_PATH . "blocks-config/{$block_data['name']}/block.json";
		if ( file_exists( $json_file ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php'; // We will probably need to load this file.
			global $wp_filesystem;
			WP_Filesystem(); // Initial WP file system.
			$default_attributes = $wp_filesystem->get_contents( $json_file );
			$default_attributes = json_decode( $default_attributes, true );
			$default_attributes = $default_attributes['attributes'];
			// Get default for each attribute.
			foreach ( $default_attributes as $key => $value ) {
				if ( isset( $value['default'] ) ) {
					$default_attrs[ $key ] = $value['default'];
				}
			}
		}
		// Merge default attributes with block attributes.
		$attr = wp_parse_args( $block['attrs'], $default_attrs );

		return $attr;
	}

	/**
	 * Enqueues features scripts.
	 */
	public function enqueue_features_script() {
		$media_query            = array();
		$media_query['mobile']  = apply_filters( 'Premium_BLocks_mobile_media_query', '(max-width: 767px)' );
		$media_query['tablet']  = apply_filters( 'Premium_BLocks_tablet_media_query', '(max-width: 1024px)' );
		$media_query['desktop'] = apply_filters( 'Premium_BLocks_desktop_media_query', '(min-width: 1025px)' );

		if ( ! empty( $this->entrance_animation_blocks ) ) {
			$this->entrance_animation_blocks['breakPoints'] = $media_query;
			wp_enqueue_script(
				'premium-entrance-animation-view',
				PREMIUM_BLOCKS_URL . 'assets/js/build/entrance-animation/frontend/index.js',
				array(),
				PREMIUM_BLOCKS_VERSION,
				true
			);

			wp_enqueue_style(
				'pbg-entrance-animation-css',
				PREMIUM_BLOCKS_URL . 'assets/js/build/entrance-animation/editor/index.css',
				array(),
				PREMIUM_BLOCKS_VERSION,
				'all'
			);

			wp_localize_script(
				'premium-entrance-animation-view',
				'PBG_EntranceAnimation',
				$this->entrance_animation_blocks
			);
		}

		if ( ! empty( $this->svg_draw_blocks ) ) {
			wp_enqueue_script(
				'premium-svg-draw-view',
				PREMIUM_BLOCKS_URL . 'assets/js/build/svg-draw/index.js',
				array(),
				PREMIUM_BLOCKS_VERSION,
				true
			);
			wp_localize_script(
				'premium-svg-draw-view',
				'PBG_SvgDraw',
				$this->svg_draw_blocks
			);
		}

		if ( ! empty( $this->extra_options_blocks ) ) {
		
			wp_localize_script(
				'pbg-blocks-wrapper-link',
				'PBG_WrapperLink',
				apply_filters(
					'pbg_wrapper_link_localize_script',
					array(
						'blocks' => $this->extra_options_blocks,
					)
				)
			);
		}
	}

	/**
	 * Equal Height Frontend
	 *
	 * Enqueue Frontend Assets for Premium Blocks.
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function equal_height_front_script( $content, $block ) {
		$media_query            = array();
		$media_query['mobile']  = apply_filters( 'Premium_BLocks_mobile_media_query', '(max-width: 767px)' );
		$media_query['tablet']  = apply_filters( 'Premium_BLocks_tablet_media_query', '(max-width: 1024px)' );
		$media_query['desktop'] = apply_filters( 'Premium_BLocks_desktop_media_query', '(min-width: 1025px)' );
		if ( $this->global_features['premium-equal-height'] && isset( $block['attrs']['equalHeight'] ) && $block['attrs']['equalHeight'] ) {
			wp_enqueue_script(
				'premium-equal-height-view',
				PREMIUM_BLOCKS_URL . 'assets/js/build/equal-height/index.js',
				array(),
				PREMIUM_BLOCKS_VERSION,
				true
			);

			wp_localize_script(
				'premium-equal-height-view',
				'PBG_EqualHeight',
				apply_filters(
					'premium_equal_height_localize_script',
					array(
						'breakPoints' => $media_query,
					)
				)
			);
		}
		return $content;
	}

	/**
	 * Add blocks editor style
	 *
	 * @return void
	 */
	public function add_blocks_editor_styles() {
		$generate_css = new Pbg_Assets_Generator( 'editor' );
		if ( $this->global_features['premium-entrance-animation'] ) {
			$generate_css->pbg_add_css( 'assets/js/build/entrance-animation/editor/index.css' );
		}
		$generate_css->pbg_add_css( 'assets/css/minified/blockseditor.min.css' );
		$generate_css->pbg_add_css( 'assets/css/minified/editorpanel.min.css' );
		$generate_css->pbg_add_css( 'assets/css/minified/carousel.min.css' );
		$is_rtl = is_rtl() ? true : false;
		$is_rtl ? $generate_css->pbg_add_css( 'assets/css/minified/style-blocks-rtl.min.css' ) : '';

		if ( is_array( self::$blocks ) && ! empty( self::$blocks ) ) {
			foreach ( self::$blocks as $slug => $value ) {

				if ( false === $value ) {
					continue;
				}

				if ( 'buttons' === $slug ) {
					$this->blocks_frondend_assets->pbg_add_css( 'assets/css/minified/button.min.css' );
				}

				if ( 'pricing-table' === $slug ) {
					$generate_css->pbg_add_css( 'assets/css/minified/price.min.css' );
					$generate_css->pbg_add_css( 'assets/css/minified/badge.min.css' );
				}
				if ( 'pricing-table' === $slug || 'icon-box' === $slug || 'person' === $slug ) {
					$generate_css->pbg_add_css( 'assets/css/minified/text.min.css' );
				}
				if ( 'pricing-table' === $slug || 'icon-box' === $slug ) {
					$generate_css->pbg_add_css( 'assets/css/minified/button.min.css' );
				}
				if ( 'person' === $slug ) {
					$generate_css->pbg_add_css( 'assets/css/minified/image.min.css' );
					$generate_css->pbg_add_css( 'assets/css/minified/icon-group.min.css' );
				}
				if ( 'content-switcher' === $slug ) {
					$generate_css->pbg_add_css( 'assets/css/minified/switcher-child.min.css' );
				}
				if ( 'count-up' === $slug ) {
					$generate_css->pbg_add_css( 'assets/css/minified/counter.min.css' );
				}
				

				if ( 'instagram-feed' === $slug ) {
					$generate_css->pbg_add_css( 'assets/css/minified/instagram-feed-header.min.css' );
					$generate_css->pbg_add_css( 'assets/css/minified/instagram-feed-posts.min.css' );
				}
				if ( 'post-carousel' === $slug || 'post-grid' === $slug || 'post-masonary' === $slug ) {
					$generate_css->pbg_add_css( 'assets/css/minified/post.min.css' );
				} elseif ( 'form' === $slug ) {
					$generate_css->pbg_add_css( 'assets/css/minified/form-toggle.min.css' );
					$generate_css->pbg_add_css( 'assets/css/minified/form-checkbox.min.css' );
					$generate_css->pbg_add_css( 'assets/css/minified/form-radio.min.css' );
					$generate_css->pbg_add_css( 'assets/css/minified/form-accept.min.css' );
					$generate_css->pbg_add_css( 'assets/css/minified/form-phone.min.css' );
					$generate_css->pbg_add_css( 'assets/css/minified/form-select.min.css' );
				}

				$generate_css->pbg_add_css( "assets/css/minified/{$slug}.min.css" );
			}
		}

		// Add dynamic css.
		$css_url = $generate_css->get_css_url();

		// Enqueue editor styles.
		if ( false != $css_url ) {
			wp_register_style( 'premium-blocks-editor-css', $css_url, array(), PREMIUM_BLOCKS_VERSION, 'all' );
			wp_add_inline_style( 'premium-blocks-editor-css', apply_filters( 'pbg_dynamic_css', '' ) );
		}

	}

	/**
	 * Add blocks frontend style
	 *
	 * @return void
	 */
	function load_dashicons_front_end() {
		wp_enqueue_style( 'dashicons' );
	}

	/**
	 * Load Json Files
	 */
	public function pbg_mime_types( $mimes ) {
		$mimes['json'] = 'application/json';
		$mimes['svg']  = 'image/svg+xml';
		return $mimes;
	}
//////////////////////////////////////////////////////////////////
// Get WP fonts
//////////////////////////////////////////////////////////////////

public function premium_get_wp_local_fonts(){
	$fonts = [];
	$query = get_posts(
		array(
			'post_type'              => 'wp_font_face',
			'posts_per_page'         => 99,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		)
	);
	if(!empty($query)){
		foreach($query as $font){
			$font_content = json_decode($font->post_content, true);
			if($font_content['fontFamily']){
				$fonts[] = $font_content['fontFamily'];
			}
		}
	}
	return $fonts;
}
	/**
	 * Load SvgShapes
	 *
	 * @since 1.0.0
	 */
	public function getSvgShapes() {
		$shape_path = PREMIUM_BLOCKS_PATH . 'assets/icons/shape';
		$shapes     = glob( $shape_path . '/*.svg' );
		$shapeArray = array();

		if ( count( $shapes ) ) {
			if ( ! defined( 'GLOB_BRACE' ) ) {
				define( 'GLOB_BRACE', 1024 );
			}

			foreach ( $shapes as $shape ) {
				$shapeArray[ str_replace( array( '.svg', $shape_path . '/' ), '', $shape ) ] = file_get_contents( $shape );
			}
		}

		return $shapeArray;
	}


	/**
	 * Fix File Of type JSON
	 */
	public function fix_mime_type_json( $data = null, $file = null, $filename = null, $mimes = null ) {
		$ext = isset( $data['ext'] ) ? $data['ext'] : '';
		if ( 1 > strlen( $ext ) ) {
			$exploded = explode( '.', $filename );
			$ext      = strtolower( end( $exploded ) );
		}
		if ( 'json' === $ext ) {
			$data['type'] = 'application/json';
			$data['ext']  = 'json';
		}
		return $data;
	}
	public static function get_default_posts_list( $post_type ) {
		$list = get_posts(
			array(
				'post_type'              => $post_type,
				'posts_per_page'         => -1,
				'update_post_term_cache' => false,
				'update_post_meta_cache' => false,
				'fields'                 => array( 'ids' ),
			)
		);

		$options = array();

		if ( ! empty( $list ) && ! is_wp_error( $list ) ) {
			foreach ( $list as $post ) {
				$options[ $post->ID ] = $post->post_title;
			}
		}

		return $options;

	}




	/**
	 * Get authors
	 *
	 * Get posts author array
	 *
	 * @since 3.20.3
	 * @access public
	 *
	 * @return array
	 */
	public static function get_authors() {
		$users = get_users( array( 'role__in' => array( 'administrator', 'editor', 'author', 'contributor' ) ) );

		$options = array();

		if ( ! empty( $users ) && ! is_wp_error( $users ) ) {
			foreach ( $users as $user ) {
				if ( 'wp_update_service' !== $user->display_name ) {
					$options[ $user->ID ] = $user->display_name;
				}
			}
		}

		return $options;
	}


	/**
	 * Enqueue Editor CSS/JS for Premium Blocks
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function pbg_editor() {
		$allow_json           = isset( self::$config['premium-upload-json'] ) ? self::$config['premium-upload-json'] : true;
		$is_fa_enabled        = isset( self::$config['premium-fa-css'] ) ? self::$config['premium-fa-css'] : true;
		$plugin_dependencies  = array( 'wp-blocks', 'react', 'react-dom', 'wp-components', 'wp-compose', 'wp-data', 'wp-edit-post', 'wp-element', 'wp-hooks', 'wp-i18n', 'wp-plugins', 'wp-polyfill', 'wp-primitives', 'wp-api', 'wp-widgets', 'lodash' );
		$mailchimp_api_key    = $this->integrations_settings['premium-mailchimp-api-key'];
		$mailerlite_api_token = $this->integrations_settings['premium-mailerlite-api-token'];

		$settings_data = array(
			'ajaxurl'           => esc_url( admin_url( 'admin-ajax.php' ) ),
			'nonce'             => wp_create_nonce( 'pa-blog-block-nonce' ),
			'settingPath'       => admin_url( 'admin.php?page=pb_panel&path=settings' ),
			'defaultAuthImg'    => PREMIUM_BLOCKS_URL . 'assets/img/author.jpg',
			"defaultImage"		=>PREMIUM_BLOCKS_URL . 'assets/img/a-woman-working-on-laptop.jpg',
			'activeBlocks'      => self::$blocks,
			'tablet_breakpoint' => PBG_TABLET_BREAKPOINT,
			'mobile_breakpoint' => PBG_MOBILE_BREAKPOINT,
			'shapes'            => $this->getSvgShapes(),
			'localFonts'		=> $this->premium_get_wp_local_fonts(),
			'masks'             => PREMIUM_BLOCKS_URL . 'assets/icons/masks',
			'plugin_url'		=>PREMIUM_BLOCKS_URL,
			'admin_url'         => admin_url(),
			'all_taxonomy'      => $this->get_related_taxonomy(),
			'image_sizes'       => $this->get_image_sizes(),
			'post-list'         => $this->get_default_posts_list( 'post' ),
			'get_authors'       => $this->get_authors(),
			'post_type'         => $this->get_post_types(),
			'globalFeatures'    => $this->global_features,
			'performance'       => $this->performance_settings,
			'socialNonce'       => wp_create_nonce( 'pbg-social' ),
			'recaptcha'         => array(
				'v2SiteKey' => $this->integrations_settings['premium-recaptcha-v2-site-key'],
				'v3SiteKey' => $this->integrations_settings['premium-recaptcha-v3-site-key'],
			),
			'mailchimp'         => array(
				'apiKey' => $mailchimp_api_key,
				'lists'  => PBG_Blocks_Integrations::get_instance()->get_mailchimp_lists( $mailchimp_api_key ),
			),
			'mailerlite'        => array(
				'apiToken' => $mailerlite_api_token,
				'groups'   => PBG_Blocks_Integrations::get_instance()->get_mailerlite_groups( $mailerlite_api_token ),
			),
			'fluentCRM'         => array(
				'is_active' => function_exists( 'FluentCrm' ),
				'lists'     => PBG_Blocks_Integrations::get_instance()->get_fluentcrm_lists(),
				'tags'      => PBG_Blocks_Integrations::get_instance()->get_fluentcrm_tags(),
			),
		);

		// PBG.
		$pbg_asset_file   = PREMIUM_BLOCKS_PATH . 'assets/js/build/pbg/index.asset.php';
		$pbg_dependencies = file_exists( $pbg_asset_file ) ? include $pbg_asset_file : array();
		$pbg_dependencies = $pbg_dependencies['dependencies'] ?? array();
		// Blocks.
		$blocks_asset_file   = PREMIUM_BLOCKS_PATH . 'assets/js/build/blocks/index.asset.php';
		$blocks_dependencies = file_exists( $blocks_asset_file ) ? include $blocks_asset_file : array();
		$blocks_dependencies = $blocks_dependencies['dependencies'] ?? array();
		// Entrance Animation.
		$entrance_animation_asset_file   = PREMIUM_BLOCKS_PATH . 'assets/js/build/entrance-animation/editor/index.asset.php';
		$entrance_animation_dependencies = file_exists( $entrance_animation_asset_file ) ? include $entrance_animation_asset_file : array();
		$entrance_animation_dependencies = $entrance_animation_dependencies['dependencies'] ?? array();
		// PBG deps.
		array_push( $blocks_dependencies, 'wp-edit-post', 'pbg-settings-js' );
		array_push( $entrance_animation_dependencies, 'wp-edit-post', 'pbg-settings-js' );

		wp_register_script(
			'pbg-settings-js',
			PREMIUM_BLOCKS_URL . 'assets/js/build/pbg/index.js',
			$pbg_dependencies,
			PREMIUM_BLOCKS_VERSION,
			true
		);

		wp_register_script(
			'pbg-blocks-js',
			PREMIUM_BLOCKS_URL . 'assets/js/build/blocks/index.js',
			$blocks_dependencies,
			PREMIUM_BLOCKS_VERSION,
			true
		);

		wp_localize_script(
			'pbg-blocks-js',
			'PremiumBlocksSettings',
			$settings_data
		);

		wp_localize_script(
			'pbg-settings-js',
			'PremiumBlocksSettings',
			$settings_data
		);

		wp_localize_script(
			'pbg-settings-js',
			'FontAwesomeConfig',
			array(
				'FontAwesomeEnabled' => $is_fa_enabled,
			)
		);
		wp_localize_script(
			'pbg-settings-js',
			'JsonUploadFile',
			array(
				'JsonUploadEnabled' => $allow_json,
			)
		);

		if ( $this->global_features['premium-entrance-animation'] ) {
			wp_enqueue_script(
				'pbg-entrance-animation',
				PREMIUM_BLOCKS_URL . 'assets/js/build/entrance-animation/editor/index.js',
				$entrance_animation_dependencies,
				PREMIUM_BLOCKS_VERSION,
				true
			);
			wp_localize_script(
				'pbg-entrance-animation',
				'PremiumAnimation',
				array(
					'allBlocks' => $this->global_features['premium-entrance-animation-all-blocks'],
				)
			);
		}

		if ( $this->global_features['premium-copy-paste-styles'] ?? true ) {
			wp_enqueue_script(
				'pbg-copy-paste-style',
				PREMIUM_BLOCKS_URL . 'assets/js/build/copy-paste-style/index.js',
				array( 'wp-block-editor', 'wp-blocks', 'wp-components', 'wp-compose', 'wp-data', 'wp-element', 'wp-hooks', 'wp-i18n', 'wp-notices', 'pbg-settings-js' ),
				PREMIUM_BLOCKS_VERSION,
				true
			);
		}

		if ( self::$blocks['svg-draw'] ?? true ) {
			$svgdraw_asset_file   = PREMIUM_BLOCKS_PATH . 'assets/js/build/icon-content/index.asset.php';
			$svgdraw_dependencies = file_exists( $svgdraw_asset_file ) ? include $svgdraw_asset_file : array();
			$svgdraw_dependencies = $svgdraw_dependencies['dependencies'] ?? array();

			array_push( $svgdraw_dependencies, 'pbg-settings-js' );
			wp_enqueue_script(
				'pbg-icon-content',
				PREMIUM_BLOCKS_URL . 'assets/js/build/icon-content/index.js',
				$svgdraw_dependencies,
				PREMIUM_BLOCKS_VERSION,
				true
			);
		}

		$is_maps_enabled = self::$blocks['maps'];
		$is_enabled      = isset( self::$config['premium-map-api'] ) ? self::$config['premium-map-api'] : true;
		$api_key         = isset( self::$config['premium-map-key'] ) ? self::$config['premium-map-key'] : '';

		if ( $is_maps_enabled && $is_enabled ) {
			if ( ! empty( $api_key ) && '1' != $api_key ) {
				wp_enqueue_script(
					'premium-map-block',
					'https://maps.googleapis.com/maps/api/js?key=' . $api_key,
					array(),
					PREMIUM_BLOCKS_VERSION,
					false
				);
			}
		}
	}


	/**
	 * PBG Frontend
	 *
	 * Enqueue Frontend Assets for Premium Blocks.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function pbg_frontend() {
		$is_fa_enabled = isset( self::$config['premium-fa-css'] ) ? self::$config['premium-fa-css'] : true;

		$is_rtl = is_rtl() ? true : false;

		if ( $is_rtl ) {
			wp_enqueue_style(
				'pbg-style',
				PREMIUM_BLOCKS_URL . 'assets/css/minified/style-blocks-rtl.min.css',
				array(),
				PREMIUM_BLOCKS_VERSION,
				'all'
			);
		}

		// Enqueue Google Maps API Script.

		wp_localize_script(
			'pbg-blocks-js',
			'PremiumSettings',
			array(
				'ajaxurl' => esc_url( admin_url( 'admin-ajax.php' ) ),
				'nonce'   => wp_create_nonce( 'pa-blog-block-nonce' ),
			)
		);
	}

	/**
	 * On init startup.
	 */
	public function on_init() {
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}

		foreach ( self::$blocks as $slug => $value ) {
			if ( false === $value ) {
				continue;
			}
			if ( file_exists( PREMIUM_BLOCKS_PATH . "blocks-config/{$slug}/index.php" ) ) {
				require_once PREMIUM_BLOCKS_PATH . "blocks-config/{$slug}/index.php";
			}
			if ( 'pricing-table' === $slug || 'icon-box' === $slug || 'person' === $slug ) {
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/text.php';
				if ( 'pricing-table' === $slug ) {
					require_once PREMIUM_BLOCKS_PATH . 'blocks-config/price.php';
					require_once PREMIUM_BLOCKS_PATH . 'blocks-config/badge.php';
			

				}
				if ( 'pricing-table' === $slug || 'icon-box' === $slug ||'count-up'=== $slug   ) {
					require_once PREMIUM_BLOCKS_PATH . 'blocks-config/buttons/index.php';
					require_once PREMIUM_BLOCKS_PATH . 'blocks-config/button/index.php';
					require_once PREMIUM_BLOCKS_PATH . 'blocks-config/bullet-list/index.php';
					require_once PREMIUM_BLOCKS_PATH . 'blocks-config/section/index.php';
					require_once PREMIUM_BLOCKS_PATH . 'blocks-config/icon/index.php';
				}
				if ( 'person' === $slug ) {
					require_once PREMIUM_BLOCKS_PATH . 'blocks-config/image.php';
					require_once PREMIUM_BLOCKS_PATH . 'blocks-config/icon-group.php';
					require_once PREMIUM_BLOCKS_PATH . 'blocks-config/section/index.php';
					require_once PREMIUM_BLOCKS_PATH . 'blocks-config/icon/index.php';
					require_once PREMIUM_BLOCKS_PATH . 'blocks-config/buttons/index.php';


				}
			} elseif ( $slug === 'content-switcher' ) {
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/switcher-child.php';
			} elseif ( $slug === 'count-up' ) {
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/counter.php';
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/icon/index.php';
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/text.php';


			} elseif ( $slug === 'testimonials' ) {
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/image.php';
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/text.php';

			} elseif ( $slug === 'buttons' ) {
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/button/index.php';
			} elseif ( $slug === 'instagram-feed' ) {
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/instagram-feed-header/index.php';
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/instagram-feed-posts/index.php';
			} elseif ( $slug === 'bullet-list' ) {
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/list-item.php';
			} elseif ( $slug === 'tabs' ) {
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/tab-item/index.php';
			} 
			elseif ( $slug === 'text' ) {
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/text.php';
			}  
			elseif ( $slug === 'form' ) {
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/form-email.php';
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/form-name.php';
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/form-checkbox.php';
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/form-toggle.php';
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/form-radio.php';
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/form-hidden.php';
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/form-accept.php';
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/form-phone.php';
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/form-url.php';
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/form-date.php';
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/form-textarea.php';
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/form-select.php';
			}
		}
	}

	/**
	 * Add Premium Blocks category to Blocks Categories
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @param array $categories blocks categories.
	 */
	public function register_premium_category( $categories ) {
		return array_merge(
			array(
				array(
					'slug'  => 'premium-blocks',
					'title' => __( 'Premium Blocks', 'premium-blocks-for-gutenberg' ),
				),
			),
			$categories
		);
	}


	/**
	 *
	 * Generates stylesheet and appends in head tag.
	 *
	 * @since 1.8.2
	 */
	public function generate_stylesheet() {
		 $this_post = array();
		if ( class_exists( 'WooCommerce' ) ) {

			if ( is_cart() ) {

				$id        = get_option( 'woocommerce_cart_page_id' );
				$this_post = get_post( $id );
			} elseif ( is_account_page() ) {

				$id        = get_option( 'woocommerce_myaccount_page_id' );
				$this_post = get_post( $id );
			} elseif ( is_checkout() ) {

				$id        = get_option( 'woocommerce_checkout_page_id' );
				$this_post = get_post( $id );
			} elseif ( is_checkout_pay_page() ) {

				$id        = get_option( 'woocommerce_pay_page_id' );
				$this_post = get_post( $id );
			} elseif ( is_shop() ) {

				$id        = get_option( 'woocommerce_shop_page_id' );
				$this_post = get_post( $id );
			}

			if ( is_object( $this_post ) ) {
				$this->generate_post_stylesheet( $this_post );
				return;
			}
		}

		if ( is_single() || is_page() || is_404() ) {

			global $post;
			$this_post = $post;

			if ( ! is_object( $this_post ) ) {
				return;
			}

			$this->generate_post_stylesheet( $this_post );
		} elseif ( is_archive() || is_home() || is_search() ) {

			global $wp_query;

			foreach ( $wp_query as $post ) {
				$this->generate_post_stylesheet( $post );
			}
		}
	}

	/**
	 * Render Boolean is amp or Not
	 */
	public function it_is_not_amp() {
		$not_amp = true;
		if ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) {
			$not_amp = false;
		}
		return $not_amp;
	}

	/**
	 * Generates stylesheet in loop.
	 *
	 * @param object $this_post Current Post Object.
	 *
	 * @since 1.8.2
	 */
	public function generate_post_stylesheet( $this_post ) {
		if ( ! is_object( $this_post ) ) {
			return;
		}
		if ( ! isset( $this_post->ID ) ) {
			return;
		}
		if ( has_blocks( $this_post->ID ) ) {

			if ( isset( $this_post->post_content ) ) {

				$blocks            = $this->parse( $this_post->post_content );
				self::$page_blocks = $blocks;

				if ( ! is_array( $blocks ) || empty( $blocks ) ) {
					return;
				}

				self::$stylesheet .= $this->get_stylesheet( $blocks );
			}
		}
	}

	/**
	 * Parse Guten Block.
	 *
	 * @param string $content the content string.
	 *
	 * @since 1.1.0
	 */
	public function parse( $content ) {
		global $wp_version;

		return ( version_compare( $wp_version, '5', '>=' ) ) ? parse_blocks( $content ) : gutenberg_parse_blocks( $content );
	}

	/**
	 * Print the Stylesheet in header.
	 *
	 * @since 1.8.2
	 *
	 * @access public
	 */
	public function print_stylesheet() {
		global $content_width;
		if ( is_null( self::$stylesheet ) || '' === self::$stylesheet ) {
			return;
		}
		self::$stylesheet = str_replace( '#CONTENT_WIDTH#', $content_width . 'px', self::$stylesheet );
		ob_start();
		?>
		<style type="text/css" media="all" id="premium-style-frontend">
			<?php echo self::$stylesheet; ?>
		</style>
		<?php
		ob_end_flush();
	}

	/**
	 * Generates CSS recurrsively.
	 *
	 * @since 1.8.2
	 *
	 * @access public
	 *
	 * @param object $block The block object.
	 */
	public function get_block_css( $block ) {
		$block    = (array) $block;
		$name     = $block['blockName'];
		$css      = array();
		$block_id = '';

		if ( ! isset( $name ) ) {
			return;
		}

		if ( isset( $block['attrs'] ) && is_array( $block['attrs'] ) ) {
			$blockattr = $block['attrs'];
			if ( isset( $blockattr['block_id'] ) ) {
				$block_id = $blockattr['block_id'];
			}
		}

		self::$current_block_list[] = $name;

		if ( strpos( $name, 'premium/' ) !== false ) {
			self::$premium_flag = true;
		}

		if ( isset( $block['innerBlocks'] ) ) {
			foreach ( $block['innerBlocks'] as $j => $inner_block ) {
				if ( 'core/block' === $inner_block['blockName'] ) {
					$id = ( isset( $inner_block['attrs']['ref'] ) ) ? $inner_block['attrs']['ref'] : 0;

					if ( $id ) {
						$content = get_post_field( 'post_content', $id );

						$reusable_blocks = $this->parse( $content );

						self::$stylesheet .= $this->get_stylesheet( $reusable_blocks );
					}
				} else {
					// Get CSS for the Block.
					$inner_block_css = $this->get_block_css( $inner_block );

					$css_desktop = ( isset( $css['desktop'] ) ? $css['desktop'] : '' );
					$css_tablet  = ( isset( $css['tablet'] ) ? $css['tablet'] : '' );
					$css_mobile  = ( isset( $css['mobile'] ) ? $css['mobile'] : '' );

					if ( isset( $inner_block_css['desktop'] ) ) {
						$css['desktop'] = $css_desktop . $inner_block_css['desktop'];
						$css['tablet']  = $css_tablet . $inner_block_css['tablet'];
						$css['mobile']  = $css_mobile . $inner_block_css['mobile'];
					}
				}
			}
		}

		self::$current_block_list = array_unique( self::$current_block_list );
		return $css;
	}

	/**
	 * Get Post Types.
	 *
	 * @since 1.11.0
	 * @access public
	 */
	public static function get_post_types() {

		$post_types = get_post_types(
			array(
				'public'       => true,
				'show_in_rest' => true,
			),
			'objects'
		);

		$options = array();

		foreach ( $post_types as $post_type ) {

			if ( 'attachment' === $post_type->name ) {
				continue;
			}

			$options[] = array(
				'value' => $post_type->name,
				'label' => $post_type->label,
			);
		}

		return apply_filters( 'pbg_loop_post_types', $options );
	}


	public function get_related_taxonomy() {

		$post_types = self::get_post_types();

		$return_array = array();

		foreach ( $post_types as $key => $value ) {
			$post_type = $value['value'];

			$taxonomies = get_object_taxonomies( $post_type, 'objects' );
			$data       = array();

			foreach ( $taxonomies as $tax_slug => $tax ) {
				if ( ! $tax->public || ! $tax->show_ui || ! $tax->show_in_rest ) {
					continue;
				}

				$data[ $tax_slug ] = $tax;

				$terms = get_terms( $tax_slug );

				$related_tax = array();

				if ( ! empty( $terms ) ) {
					foreach ( $terms as $t_index => $t_obj ) {
						$related_tax[] = array(
							'id'    => $t_obj->term_id,
							'name'  => $t_obj->name,
							'child' => get_term_children( $t_obj->term_id, $tax_slug ),
						);
					}
					$return_array[ $post_type ]['terms'][ $tax_slug ] = $related_tax;
				}
			}

			$return_array[ $post_type ]['taxonomy'] = $data;

		}

		return apply_filters( 'pbg_post_loop_taxonomies', $return_array );
	}


	/**
	 * Get size information for all currently-registered image sizes.
	 *
	 * @global $_wp_additional_image_sizes
	 * @uses   get_intermediate_image_sizes()
	 * @link   https://codex.wordpress.org/Function_Reference/get_intermediate_image_sizes
	 * @since  1.9.0
	 * @return array $sizes Data for all currently-registered image sizes.
	 */
	public static function get_image_sizes() {

		global $_wp_additional_image_sizes;

		$sizes       = get_intermediate_image_sizes();
		$image_sizes = array();

		$image_sizes[] = array(
			'value' => 'full',
			'label' => esc_html__( 'Full', 'premium-blocks-for-gutenberg' ),
		);

		foreach ( $sizes as $size ) {
			if ( in_array( $size, array( 'thumbnail', 'medium', 'medium_large', 'large' ), true ) ) {
				$image_sizes[] = array(
					'value' => $size,
					'label' => ucwords( trim( str_replace( array( '-', '_' ), array( ' ', ' ' ), $size ) ) ),
				);
			} else {
				$image_sizes[] = array(
					'value' => $size,
					'label' => sprintf(
						'%1$s (%2$sx%3$s)',
						ucwords( trim( str_replace( array( '-', '_' ), array( ' ', ' ' ), $size ) ) ),
						$_wp_additional_image_sizes[ $size ]['width'],
						$_wp_additional_image_sizes[ $size ]['height']
					),
				);
			}
		}

		$image_sizes = apply_filters( 'pbg_post_featured_image_sizes', $image_sizes );

		return $image_sizes;
	}



	public static function get_paged( $query ) {

		global $paged;

		// Check the 'paged' query var.
		$paged_qv = $query->get( 'paged' );

		if ( is_numeric( $paged_qv ) ) {
			return $paged_qv;
		}

		// Check the 'page' query var.
		$page_qv = $query->get( 'page' );

		if ( is_numeric( $page_qv ) ) {
			return $page_qv;
		}

		// Check the $paged global?
		if ( is_numeric( $paged ) ) {
			return $paged;
		}

		return 0;
	}
	/**
	 * Builds the base url.
	 *
	 * @param string $permalink_structure Premalink Structure.
	 * @param string $base Base.
	 * @since 1.14.9
	 */
	public static function build_base_url( $permalink_structure, $base ) {
		// Check to see if we are using pretty permalinks.
		if ( ! empty( $permalink_structure ) ) {

			if ( strrpos( $base, 'paged-' ) ) {
				$base = substr_replace( $base, '', strrpos( $base, 'paged-' ), strlen( $base ) );
			}

			// Remove query string from base URL since paginate_links() adds it automatically.
			// This should also fix the WPML pagination issue that was added since 1.10.2.
			if ( count( $_GET ) > 0 ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				$base = strtok( $base, '?' );
			}

			// Add trailing slash when necessary.
			if ( '/' === substr( $permalink_structure, -1 ) ) {
				$base = trailingslashit( $base );
			} else {
				$base = untrailingslashit( $base );
			}
		} else {
			$url_params = wp_parse_url( $base, PHP_URL_QUERY );
			
      if ( empty( $url_params ) ) {
				$base = trailingslashit( $base );
			}

      if ( count( $_GET ) > 0 ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $base = explode("?", $base)[0];
			}

		}

		return $base;
	}
	/**
	 * Returns the Paged Format.
	 *
	 * @param string $permalink_structure Premalink Structure.
	 * @param string $base Base.
	 * @since 1.14.9
	 */
	public static function paged_format( $permalink_structure, $base ) {

		$page_prefix = empty( $permalink_structure ) ? 'paged' : 'page';

		if ( ! empty( $permalink_structure ) ) {
			$format  = substr( $base, -1 ) !== '/' ? '/' : '';
			$format .= $page_prefix . '/';
			$format .= '%#%';
			$format .= substr( $permalink_structure, -1 ) === '/' ? '/' : '';
		} elseif ( empty( $permalink_structure ) || is_search() ) {
			$parse_url = wp_parse_url( $base, PHP_URL_QUERY );
			$format    = empty( $parse_url ) ? '?' : '&';
			$format   .= $page_prefix . '=%#%';
		}

		return $format;
	}

	/**
	 * Returns Query.
	 *
	 * @param array  $attributes The block attributes.
	 * @param string $block_type The Block Type.
	 * @since 1.8.2
	 */
	public static function get_query( $attributes, $block_type, $page = 1 ) {
		// Block type is grid/masonry/carousel/timeline.
		$query_args     = array(
			'posts_per_page' => ( isset( $attributes['query']['perPage'] ) ) ? $attributes['query']['perPage'] : 6,
			'post_status'    => 'publish',
			'post_type'      => ( isset( $attributes['query']['postType'] ) ) ? $attributes['query']['postType'] : 'post',
			'order'          => ( isset( $attributes['query']['order'] ) ) ? $attributes['query']['order'] : 'desc',
			'orderby'        => ( isset( $attributes['query']['orderBy'] ) ) ? $attributes['query']['orderBy'] : 'date',
			'paged'          => 1,
		);
		$excluded_posts = array();
		if ( ! empty( $attributes['query']['exclude'] ) && $attributes['query']['postType'] === 'post' ) {
			if ( $attributes['postFilterRule'] === 'post__in' ) {
				$query_args['post__in'] = $attributes['query']['exclude'];
			} else {
				$excluded_posts = $attributes['query']['exclude'];
			}
		}

		if ( 0 !== $attributes['query']['offset'] ) {
			$query_args['offset'] = $attributes['query']['offset'];
		}
		if ( $attributes['query']['sticky'] ) {
			$excluded_posts = array_merge( $excluded_posts, get_option( 'sticky_posts' ) );
		}

		if ( $attributes['currentPost'] ) {
			array_push( $excluded_posts, get_the_id() );
		}

		$query_args['post__not_in'] = $excluded_posts;

		if ( ! empty( $attributes['query']['author'] ) ) {

			$query_args[ $attributes['authorFilterRule'] ] = $attributes['query']['author'];
		}

		if ( isset( $attributes['categories'] ) && ! empty( array_filter($attributes['categories']))  ) {
			$query_args['tax_query'][] = array(
				'taxonomy' => 'category',
				'field'    => 'id',
				'terms'    => array_filter($attributes['categories']),
				'operator' => str_replace( "'", '', $attributes['categoryFilterRule'] ),
			);
		}
		if ( isset( $attributes['pagination'] ) && true === $attributes['pagination'] ) {

      $paged = isset( $attributes['paged'] ) ? $attributes['paged'] : $page;
			
			$query_args['posts_per_page'] = $attributes['query']['perPage'];
			$query_args['paged']          = $paged;

		}

		$query_args = apply_filters( "pbg_post_query_args_{$block_type}", $query_args, $attributes );
		return new WP_Query( $query_args );
	}
	/**
	 * Render Inline CSS helper function
	 *
	 * @param array  $css the css for each block.
	 * @param string $style_id the unique id for the rendered style.
	 * @param bool   $in_content the bool for whether or not it should run in content.
	 */
	public function render_inline_css( $css, $block_name = '' ) {
		if ( ! is_admin() ) {
			$this->add_custom_block_css( $css );
			if ( $block_name ) {
				$this->add_block_css( "assets/css/minified/{$block_name}.min.css" );
			}
		}
	}

	/**
	 * Check if block should render inline.
	 *
	 * @param string $name the blocks name.
	 * @param string $unique_id the blocks block_id.
	 */
	public function should_render_inline( $name, $unique_id ) {
		if ( doing_filter( 'the_content' ) || apply_filters( 'premium_blocks_force_render_inline_css_in_content', false, $name, $unique_id ) || is_customize_preview() ) {
			return true;
		}
		return false;
	}

	public function add_custom_block_css( $css ) {
		// Generate a unique ID for the style tag
		$unique_id = uniqid();

		// Add the CSS code to the global array
		global $custom_block_css;
		$custom_block_css[ $unique_id ] = $css;

		// Register a function to output the CSS code in the head of the page
	}

	public function get_custom_block_css() {

		global $custom_block_css;
		// Get the media queries.
		$media_query            = array();
		$media_query['mobile']  = apply_filters( 'Premium_BLocks_mobile_media_query', '(max-width: 767px)' );
		$media_query['tablet']  = apply_filters( 'Premium_BLocks_tablet_media_query', '(max-width: 1024px)' );
		$media_query['desktop'] = apply_filters( 'Premium_BLocks_desktop_media_query', '(min-width: 1025px)' );

		// Combine all CSS code into one string
		$combined_css_array = array(
			'desktop' => '',
			'tablet'  => '',
			'mobile'  => '',
		);

		$combined_css = '';

		if ( is_array( $custom_block_css ) && ! empty( $custom_block_css ) ) {
			foreach ( $custom_block_css as $unique_id => $css ) {
				if ( ! is_array( $css ) ) {
					$combined_css_array['desktop'] .= $css;
					continue;
				}
				$combined_css_array['desktop'] .= $css['desktop'];
				$combined_css_array['tablet']  .= $css['tablet'];
				$combined_css_array['mobile']  .= $css['mobile'];
			}
		}

		if ( ! empty( $combined_css_array['desktop'] ) ) {
			$combined_css .= $combined_css_array['desktop'];
		}

		if ( ! empty( $combined_css_array['tablet'] ) ) {
			$combined_css .= "@media all and {$media_query['tablet']} {" . $combined_css_array['tablet'] . '}';
		}

		if ( ! empty( $combined_css_array['mobile'] ) ) {
			$combined_css .= "@media all and {$media_query['mobile']} {" . $combined_css_array['mobile'] . '}';
		}

		// Output the combined CSS code in a single style tag
		return $combined_css;
	}


	/**
	 * Generates stylesheet for reusable blocks.
	 *
	 * @since 1.1.0
	 *
	 * @param array $blocks blocks array.
	 */
	public function get_stylesheet( $blocks ) {
		$desktop         = '';
		$tablet          = '';
		$mobile          = '';
		$tab_styling_css = '';
		$mob_styling_css = '';

		foreach ( $blocks as $i => $block ) {
			if ( is_array( $block ) ) {
				if ( '' === $block['blockName'] ) {
					continue;
				}
				if ( 'core/block' === $block['blockName'] ) {
					$id = ( isset( $block['attrs']['ref'] ) ) ? $block['attrs']['ref'] : 0;

					if ( $id ) {
						$content = get_post_field( 'post_content', $id );

						$reusable_blocks = $this->parse( $content );

						self::$stylesheet .= $this->get_stylesheet( $reusable_blocks );
					}
				} else {
					// Get CSS for the Block.
					$css = $this->get_block_css( $block );

					if ( isset( $css['desktop'] ) ) {
						$desktop .= $css['desktop'];
						$tablet  .= $css['tablet'];
						$mobile  .= $css['mobile'];
					}
				}
			}
		}
		if ( ! empty( $tablet ) ) {
			$tab_styling_css .= '@media only screen and (max-width: ' . PBG_TABLET_BREAKPOINT . 'px) {';
			$tab_styling_css .= $tablet;
			$tab_styling_css .= '}';
		}
		if ( ! empty( $mobile ) ) {
			$mob_styling_css .= '@media only screen and (max-width: ' . PBG_MOBILE_BREAKPOINT . 'px) {';
			$mob_styling_css .= $mobile;
			$mob_styling_css .= '}';
		}
		return $desktop . $tab_styling_css . $mob_styling_css;
	}

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
}
if ( ! function_exists( 'pbg_blocks_helper' ) ) {

	/**
	 * Returns an instance of the plugin class.
	 *
	 * @since  1.0.0
	 *
	 * @return object
	 */
	function pbg_blocks_helper() {
		return pbg_blocks_helper::get_instance();
	}
}
pbg_blocks_helper();
