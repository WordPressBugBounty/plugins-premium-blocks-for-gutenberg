<?php
/**
 * PBG Blocks Integrations Class
 *
 * @package WordPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * PBG Blocks Integrations Class
 */
class PBG_Blocks_Integrations {

	/**
	 * Class instance
	 *
	 * @var instance
	 */
	private static $instance = null;

	/**
	 * Creates and returns an instance of the class
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
	 * Constructor for the class
	 */
	public function __construct() {
		add_action( 'wp_ajax_pbg-get-instagram-token', array( $this, 'get_instagram_token' ) );
		add_action( 'wp_ajax_pbg-get-instagram-feed', array( $this, 'get_instagram_feed' ) );
		// Get mailchimp lists.
		add_action( 'wp_ajax_pbg-get-mailchimp-lists', array( $this, 'get_mailchimp_lists' ) );
		// Get mailchimp list merge fields.
		add_action( 'wp_ajax_pbg-get_mailchimp_list_merge_fields', array( $this, 'get_mailchimp_list_merge_fields' ) );

	}

	/**
	 * Get Mailchimp lists
	 *
	 * @access public
	 * @param string $api_key the mailchimp api key.
	 *
	 * @return array
	 */
	public function get_mailchimp_lists( $api_key = '' ) {
		if ( empty( $api_key ) ) {
			return array();
		}
		$dc      = substr( $api_key, strpos( $api_key, '-' ) + 1 );
		$request = wp_remote_request(
			"https://{$dc}.api.mailchimp.com/3.0/lists?fields=lists.id,lists.name",
			array(
				'method'  => 'GET',
				'headers' => array(
					'Authorization' => 'Basic ' . base64_encode( 'user:' . $api_key ),
				),
			)
		);

		if ( is_wp_error( $request ) ) {
			return array();
		}

		$body = wp_remote_retrieve_body( $request );
		$body = json_decode( $body, true );

		if ( isset( $body['lists'] ) ) {
			return $body['lists'];
		}

		return array();
	}

	/**
	 * Retrieves the merge fields for a Mailchimp list.
	 *
	 * @param string $api_key The Mailchimp API key.
	 * @param string $list_id The ID of the Mailchimp list.
	 * @return array The merge fields for the specified Mailchimp list.
	 */
	public function get_mailchimp_list_merge_fields( $api_key = '', $list_id = '' ) {

		if ( empty( $api_key ) || empty( $list_id ) ) {
			return array();
		}

		$dc       = substr( $api_key, strpos( $api_key, '-' ) + 1 );
		$response = wp_remote_get(
			"https://$dc.api.mailchimp.com/3.0/lists/$list_id/merge-fields",
			array(
				'headers' => array(
					'Authorization' => 'Basic ' . base64_encode( 'user:' . $api_key ),
				),
			)
		);

		if ( is_wp_error( $response ) ) {
			return array();
		}

		$body = wp_remote_retrieve_body( $response );
		$body = json_decode( $body, true );

		if ( isset( $body['merge_fields'] ) ) {
			return $body['merge_fields'];
		}

		return array();
	}

	/**
	 * Add Mailchimp subscriber
	 *
	 * @access public
	 * @param array  $mailchimp_settings the mailchimp settings.
	 * @param string $api_key the mailchimp api key.
	 * @param string $list_id the mailchimp list id.
	 * @param array  $mapped_fields the mapped fields.
	 * @param string $email the subscriber email.
	 * @return array
	 */
	public function add_mailchimp_subscriber( $mailchimp_settings, $api_key, $list_id, $mapped_fields, $email ) {
		$dc           = substr( $api_key, strpos( $api_key, '-' ) + 1 );
		$merge_fields = array();

		foreach ( $mapped_fields as $field ) {
			$field_name = $field['field_name'];
			$field_tag  = $field['field_tag'];

			if ( ! empty( $field_name ) ) {
				$merge_fields[ $field_tag ] = $mailchimp_settings[ $field_name ];
			}
		}

		$body = array(
			'email_address' => $email,
			'status'        => 'subscribed',
		);

		if ( ! empty( $merge_fields ) ) {
			$body['merge_fields'] = $merge_fields;
		}

		$body = wp_json_encode( $body );

		$request = wp_remote_request(
			"https://{$dc}.api.mailchimp.com/3.0/lists/{$list_id}/members",
			array(
				'method'  => 'POST',
				'headers' => array(
					'Authorization' => 'Basic ' . base64_encode( 'user:' . $api_key ),
				),
				'body'    => $body,
			)
		);

		if ( is_wp_error( $request ) ) {
			return array(
				'success' => false,
				'message' => $request->get_error_message(),
			);
		}

		$body = wp_remote_retrieve_body( $request );
		$body = json_decode( $body, true );

		if ( isset( $body['id'] ) ) {
			return array(
				'success' => true,
				'message' => __( 'Subscriber added successfully', 'premium-blocks-for-gutenberg' ),
			);
		}

		return array(
			'success' => false,
			'message' => $body['title'],
		);
	}

	/**
	 * Get mailerlite groups.
	 *
	 * @access public
	 * @param string $api_token the mailerlite api key.
	 * @return array
	 */
	public function get_mailerlite_groups( $api_token = '' ) {
		if ( empty( $api_token ) ) {
			return array();
		}
		$request = wp_remote_request(
			'https://api.mailerlite.com/api/v2/groups',
			array(
				'method'  => 'GET',
				'headers' => array(
					'Accept'              => 'application/json',
					'Content-Type'        => 'application/json; charset=' . get_option( 'blog_charset' ),
					'X-MailerLite-ApiKey' => $api_token,
				),
				'timeout' => 30,
			)
		);

		if ( is_wp_error( $request ) ) {
			return array();
		}

		$body = wp_remote_retrieve_body( $request );
		$body = json_decode( $body, true );

		if ( isset( $body['error'] ) ) {
			return array();
		}

		$result = array();

		foreach ( $body as $group ) {
			$result[] = array(
				'id'   => strval( $group['id'] ),
				'name' => $group['name'],
			);
		}

		return $result;
	}

	/**
	 * Add Mailerlite subscriber
	 *
	 * @access public
	 * @param string $api_token the mailerlite api key.
	 * @param string $email the subscriber email.
	 * @param string $name the subscriber name.
	 * @param string $group_id the mailerlite group id.
	 * @return array
	 */
	public function add_mailerlite_subscriber( $api_token, $email, $name = '', $group_id = '' ) {
		$body = array(
			'email' => $email,
		);

		if ( ! empty( $name ) ) {
			$body['name'] = $name;
		}

		if ( ! empty( $group_id ) ) {
			$body['groups'] = array(
				intval( $group_id ),
			);
		}

		$body    = wp_json_encode( $body );
		$request = wp_remote_request(
			'https://api.mailerlite.com/api/v2/subscribers',
			array(
				'method'  => 'POST',
				'headers' => array(
					'Accept'              => 'application/json',
					'Content-Type'        => 'application/json; charset=' . get_option( 'blog_charset' ),
					'X-MailerLite-ApiKey' => $api_token,
				),
				'body'    => $body,
			)
		);

		if ( is_wp_error( $request ) ) {
			return array(
				'success' => false,
				'message' => $request->get_error_message(),
			);
		}

		$body = wp_remote_retrieve_body( $request );
		$body = json_decode( $body, true );

		if ( isset( $body['id'] ) ) {
			return array(
				'success' => true,
				'message' => __( 'Subscriber added successfully', 'premium-blocks-for-gutenberg' ),
			);
		}

		return array(
			'success' => false,
			'message' => $body['error']['message'],
		);
	}

	/**
	 * Get fluentCRM lists
	 *
	 * @return array
	 */
	public function get_fluentcrm_lists() {
		$lists = array();
		if ( function_exists( 'FluentCrm' ) ) {
			$lists = FluentCrmApi( 'lists' )->all();
		}

		return $lists;
	}

	/**
	 * Get fluentCRM tags
	 *
	 * @return array
	 */
	public function get_fluentcrm_tags() {
		$tags = array();
		if ( function_exists( 'FluentCrm' ) ) {
			$tags = FluentCrmApi( 'tags' )->all();
		}

		return $tags;
	}

	/**
	 * Get Instagram account token for Instagram Feed widget
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function get_instagram_token() {
		check_ajax_referer( 'pbg-social', 'nonce' );
		$api_url = 'https://appfb.premiumaddons.com/wp-json/fbapp/v2/instagram';

		$response = wp_remote_get(
			$api_url,
			array(
				'timeout'   => 60,
				'sslverify' => false,
			)
		);

		if ( is_wp_error( $response ) ) {
			wp_send_json_error(
				array(
					'message' => $response->get_error_message(),
				)
			);
		}

		$body = wp_remote_retrieve_body( $response );
		$body = json_decode( $body, true );

		if ( empty( $body ) || ! is_string( $body ) ) {
			wp_send_json_error(
				array(
					'message' => __( 'Invalid token received from authentication server.', 'premium-blocks-for-gutenberg' ),
				)
			);
		}

		$transient_name = 'pbg_insta_token_' . substr( $body, -8 );
		$expire_time    = 59 * DAY_IN_SECONDS;

		set_transient( $transient_name, $body, $expire_time );

		wp_send_json_success( $body );
	}

	/**
	 * Get Instagram feeds by token
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function get_instagram_feed() {
		check_ajax_referer( 'pbg-social', 'nonce' );

		$access_token = isset( $_POST['accessToken'] ) ? sanitize_text_field( wp_unslash( $_POST['accessToken'] ) ) : '';

		if ( ! $access_token ) {
			wp_send_json_error(
				array(
					'message' => __( 'Access token is required.', 'premium-blocks-for-gutenberg' ),
				)
			);
		}

		$access_token = $this->check_instagram_token( $access_token );

		// If token refresh failed and returned false, send error.
		if ( false === $access_token ) {
			wp_send_json_error(
				array(
					'message' => __( 'Invalid Instagram access token. Please reconnect your Instagram account.', 'premium-blocks-for-gutenberg' ),
				)
			);
		}
		$api_url = sprintf( 'https://graph.instagram.com/me/media?fields=id,media_type,media_url,username,timestamp,permalink,caption,children,thumbnail_url&limit=200&access_token=%s', $access_token );

		$response = wp_remote_get(
			$api_url,
			array(
				'timeout'   => 60,
				'sslverify' => false,
			)
		);

		if ( is_wp_error( $response ) ) {
			wp_send_json_error(
				array(
					'message' => $response->get_error_message(),
				)
			);
		}

		$response_code = wp_remote_retrieve_response_code( $response );
		if ( 200 !== $response_code ) {
			wp_send_json_error(
				array(
					'message' => __( 'Unable to connect to Instagram. Please check your access token and try again.', 'premium-blocks-for-gutenberg' ),
				)
			);
		}

		$body  = wp_remote_retrieve_body( $response );
		$posts = json_decode( $body, true );

		if ( null === $posts ) {
			wp_send_json_error(
				array(
					'message' => __( 'Invalid response from Instagram API.', 'premium-blocks-for-gutenberg' ),
				)
			);
		}

		// Check if Instagram API returned an error in the response.
		if ( isset( $posts['error'] ) ) {
			wp_send_json_error(
				array(
					'message' => isset( $posts['error']['message'] ) ? $posts['error']['message'] : __( 'Instagram API error.', 'premium-blocks-for-gutenberg' ),
				)
			);
		}

		wp_send_json_success( $posts );
	}

	/**
	 * Check Instagram token expiration
	 *
	 * @access public
	 *
	 * @param string $old_token the original access token.
	 *
	 * @return string|false the valid access token or false on failure.
	 */
	public static function check_instagram_token( $old_token ) {
		// Validate token format.
		if ( empty( $old_token ) || strlen( $old_token ) < 8 ) {
			return false;
		}

		$transient_key = 'pbg_insta_token_' . substr( $old_token, -8 );
		$cached_token  = get_transient( $transient_key );

		// If token exists in transient, return it.
		if ( $cached_token ) {
			return $cached_token;
		}

		// Token doesn't exist in cache, try to refresh it.
		$response = wp_remote_get(
			'https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token=' . $old_token,
			array(
				'timeout'   => 30,
				'sslverify' => true,
			)
		);

		// Handle request errors.
		if ( is_wp_error( $response ) ) {
			return false;
		}

		// Check response code.
		$response_code = wp_remote_retrieve_response_code( $response );
		if ( 200 !== $response_code ) {
			return false;
		}

		$body = wp_remote_retrieve_body( $response );
		$data = json_decode( $body, true );

		// Check for API errors in response.
		if ( isset( $data['error'] ) ) {
			return false;
		}

		// Validate refreshed token.
		if ( ! isset( $data['access_token'] ) || empty( $data['access_token'] ) ) {
			return false;
		}

		$refreshed_token = $data['access_token'];

		// Store the refreshed token with 59 days expiry.
		$expire_time = 59 * DAY_IN_SECONDS;
		set_transient( $transient_key, $refreshed_token, $expire_time );

		return $refreshed_token;
	}

	/**
	 * Get Time
	 *
	 * @param string $time_text the time text.
	 * @return int $time in seconds.
	 */
	public static function get_time( $time_text ) {
		switch ( $time_text ) {
			case 'minute':
				$time = MINUTE_IN_SECONDS;
				break;
			case 'hour':
				$time = HOUR_IN_SECONDS;
				break;
			case 'day':
				$time = DAY_IN_SECONDS;
				break;
			case 'week':
				$time = WEEK_IN_SECONDS;
				break;
			case 'month':
				$time = MONTH_IN_SECONDS;
				break;
			case 'year':
				$time = YEAR_IN_SECONDS;
				break;
			default:
				$time = HOUR_IN_SECONDS;
		}
		return $time;
	}
}

PBG_Blocks_Integrations::get_instance();
