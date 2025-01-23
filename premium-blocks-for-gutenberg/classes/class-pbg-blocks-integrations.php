<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Define PBG_Blocks_Integrations class
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
	 * Add Mailchimp subscriber
	 *
	 * @access public
	 * @param string $api_key the mailchimp api key.
	 * @param string $list_id the mailchimp list id.
	 * @param string $email the subscriber email.
	 * @param string $fname the subscriber first name.
	 * @param string $lname the subscriber last name.
	 * @return array
	 */
	public function add_mailchimp_subscriber( $api_key, $list_id, $email, $fname, $lname ) {
		$dc           = substr( $api_key, strpos( $api_key, '-' ) + 1 );
		$merge_fields = array();

		if ( ! empty( $fname ) ) {
			$merge_fields['FNAME'] = $fname;
		}

		if ( ! empty( $lname ) ) {
			$merge_fields['LNAME'] = $lname;
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

		$body           = wp_remote_retrieve_body( $response );
		$body           = json_decode( $body, true );
		$transient_name = 'pbg_insta_token_' . substr( $body, -8 );

		$expire_time = 59 * DAY_IN_SECONDS;

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
			wp_send_json_error();
		}
		$posts = array();

		$access_token = $this->check_instagram_token( $access_token );
		$api_url      = sprintf( 'https://graph.instagram.com/me/media?fields=id,media_type,media_url,username,timestamp,permalink,caption,children,thumbnail_url&limit=200&access_token=%s', $access_token );

		$response = wp_remote_get(
			$api_url,
			array(
				'timeout'   => 60,
				'sslverify' => false,
			)
		);

		if ( is_wp_error( $response ) ) {
			wp_send_json_error();
		}
		$response = wp_remote_retrieve_body( $response );
		$posts    = json_decode( $response, true );

		wp_send_json_success( $posts );
	}

	/**
	 * Check Instagram token expiration
	 *
	 * @access public
	 *
	 * @param string $old_token the original access token.
	 *
	 * @return void
	 */
	public static function check_instagram_token( $old_token ) {
		$token = get_transient( 'pbg_insta_token_' . substr( $old_token, -8 ) );

		$refreshed_token = $old_token;

		if ( ! $token ) {
			$response        = wp_remote_retrieve_body(
				wp_remote_get( 'https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token=' . $token )
			);
			$response        = json_decode( $response, true );
			$refreshed_token = isset( $response->access_token ) ? $response->access_token : $old_token;
			$transient_name  = 'pbg_insta_token_' . substr( $old_token, -8 );
			$expire_time     = 59 * DAY_IN_SECONDS;
			set_transient( $transient_name, $refreshed_token, $expire_time );
		}
		return $refreshed_token;
	}

	/**
	 * Get Time
	 *
	 * @param  string $time_text
	 * @return int
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
