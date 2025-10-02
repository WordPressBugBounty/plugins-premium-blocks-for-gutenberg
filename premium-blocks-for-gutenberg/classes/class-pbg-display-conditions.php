<?php
/**
 * Display Conditions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class PBG_Display_Conditions
 */
class PBG_Display_Conditions {

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
		// Enqueue Editor Assets.
		add_action( 'enqueue_block_editor_assets', array( $this, 'pbg_editor' ) );

		// Block Render Callback.
		add_filter( 'render_block', array( $this, 'pbg_render_block' ), 10, 2 );
	}

	/**
	 * Render Block
	 *
	 * @param string $block_content Block Content.
	 * @param array  $block Block.
	 *
	 * @return string
	 */
	public function pbg_render_block( $block_content, $block ) {
		$display_conditions = $block['attrs']['displayConditions'] ?? array();

		if ( empty( $display_conditions ) || empty( $display_conditions['conditions'] ?? array() ) ||  !$display_conditions['enabled']) {
			return $block_content;
		}

		// Check if any condition value is empty
		foreach ( $display_conditions['conditions'] as $condition ) {
			if ( empty( $condition['value'] ) ) {
				return $block_content;
			}
		}

		$operator           = $display_conditions['operator'] ?? 'and';
		$display_conditions = $this->get_conditions_result( $display_conditions['conditions'], $operator, 'show' );

		if ( ! $display_conditions ) {
			return '';
		}

		return $block_content;
	}

	function is_plugin_pro_active( $plugin ) {
		return in_array( $plugin, (array) get_option( 'active_plugins', array() ), true );
	}

	/**
	 * Get Conditions Result
	 *
	 * @param array  $display_conditions Display Conditions.
	 * @param string $operator Operator.
	 * @param string $action Action.
	 *
	 * @return array
	 */
	public function get_conditions_result( $display_conditions, $operator = 'and', $action = 'show' ) {
		$is_pbg_pro_installed = $this->is_plugin_pro_active( 'premium-blocks-for-gutenberg-pro/premium-blocks-for-gutenberg-pro.php' );
		
		$display_conditions = array_filter( $display_conditions );
		$result             = array();
		foreach ( $display_conditions as $display_condition ) {
			$type = $display_condition['type'] ?? '';

			if ( empty( $type ) ) {
				continue;
			}

			$condition_operator = $display_condition['operator'] ?? 'is';
			$condition_value    = $display_condition['value'] ?? array();
			$time_zone          = $display_condition['time_zone'] ?? 'local';

			switch ( $type ) {
				case 'browser':
					$result[] = $this->compare_browser_value( $condition_operator, $condition_value );
					break;

				case 'date':
					$condition_value = $display_condition['dateValue'] ?? '';
					$result[]        = $this->compare_date_value( $condition_operator, $condition_value, $time_zone );
					break;

				case 'date_range':
					$condition_value = $display_condition['dateValue'] ?? array();
					$result[]        = $this->compare_date_range_value( $condition_operator, $condition_value, $time_zone );
					break;

				case 'day':
					$result[] = $this->compare_day_value( $condition_operator, $condition_value, $time_zone );
					break;

				case 'ip_location':
					$result[] = $this->compare_location_value( $condition_operator, $condition_value, $display_condition['method'] ?? 'old' );
					break;

				case 'login_status':
					$is_logged_in = is_user_logged_in();
					$result[]     = self::get_final_result( $is_logged_in, $condition_operator );
					break;

				case 'lang':
					$result[] = $this->compare_language_value( $condition_operator, $condition_value );
					break;

				case 'operating_system':
					$result[] = $this->compare_os_value( $condition_operator, $condition_value );
					break;

				case 'page':
					$result[] = $this->compare_page_value( $condition_operator, $condition_value );
					break;

				case 'post_format':
					$result[] = $this->compare_post_format_value( $condition_operator, $condition_value );
					break;

				case 'post_type':
					$result[] = $this->compare_post_type_value( $condition_operator, $condition_value );
					break;

				case 'post':
					$result[] = $this->compare_post_value( $condition_operator, $condition_value );
					break;

				case 'return_visitor':
					$result[] = $this->compare_return_visitor_value( $condition_operator );
					break;

				case 'static_page':
					$result[] = $this->compare_static_page_value( $condition_operator, $condition_value );
					break;

				case 'time_range':
					$from     = $condition_value[0] ?? null;
					$to       = $condition_value[1] ?? null;
					$result[] = $this->compare_time_range_value( $condition_operator, $to, $from, $time_zone );
					break;

				case 'user_role':
					$result[] = $this->compare_user_role_value( $condition_operator, $condition_value );
					break;

				default:
					$result[] = false;
					break;
			}
		}
		// if($is_pbg_pro_installed) {
		// 	$result = array_filter(apply_filters( 'pb_display_conditions_options', $type, $condition_operator, $condition_value, $result, $itemNumber, $category ));
		// }
		// else {
			$result = array_filter( $result );
		// }

		if ( 'and' === $operator ) {
			$final_result = count( $result ) === count( $display_conditions );
		} else {
			$final_result = ! empty( $result );
		}

		return $final_result;
	}

	/**
	 * Get Final Result.
	 *
	 * @access public
	 *
	 * @param bool   $condition_result  result.
	 * @param string $operator          operator.
	 *
	 * @return bool
	 */
	public static function get_final_result( $condition_result, $operator ) {
		if ( 'is' === $operator ) {
			return true === $condition_result;
		} else {
			return true !== $condition_result;
		}
	}

	/**
	 * Get Browser Name.
	 *
	 * @access private
	 *
	 * @param string $user_agent  user agent.
	 *
	 * @return array browser name.
	 */
	private static function get_browser_name( $user_agent ) {
		if ( strpos( $user_agent, 'Opera' ) || strpos( $user_agent, 'OPR/' ) ) {
			return 'opera';
		} elseif ( strpos( $user_agent, 'Edg' ) || strpos( $user_agent, 'Edge' ) ) {
			return 'edge';
		} elseif ( strpos( $user_agent, 'Chrome' ) || strpos( $user_agent, 'CriOS' ) ) {
			return 'chrome';
		} elseif ( strpos( $user_agent, 'Safari' ) ) {
			return 'safari';
		} elseif ( strpos( $user_agent, 'Firefox' ) ) {
			return 'firefox';
		}
	}

	/**
	 * Get Local Time ( WordPress TimeZone Setting ).
	 *
	 * @access public
	 *
	 * @param string $format  format.
	 */
	public static function get_local_time( $format ) {
	
		$local_time_zone = isset( $_COOKIE['localTimeZone'] ) && ! empty( $_COOKIE['localTimeZone'] ) ?
			str_replace( 'GMT ', 'GMT+', sanitize_text_field( wp_unslash( $_COOKIE['localTimeZone'] ) ) )
			: self::get_location_time_zone();

		// $today = new \DateTime( 'now', new \DateTimeZone( $local_time_zone ) );
		try {
			$today = new \DateTime( 'now', new \DateTimeZone( $local_time_zone ) );
		} catch ( \Exception $e ) {
			$today = new \DateTime( 'now', new \DateTimeZone( 'UTC' ) );
		}

		return $today->format( $format );
	}

	/**
	 * Gets the user's timezone based on his ip address.
	 *
	 * @access public
	 * @since 4.10.26
	 *
	 * @return string
	 */
	public static function get_location_time_zone() {

		$ip_address = self::get_user_ip_address();

		return self::get_timezone_by_ip( $ip_address );
	}

	/**
	 * Get user's IP address.
	 *
	 * @access public
	 * @since 4.10.26
	 *
	 * @return string
	 */
	public static function get_user_ip_address() {

		if ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {

			$x_forward = sanitize_text_field( wp_unslash( $_SERVER['HTTP_X_FORWARDED_FOR'] ) );

			if ( is_array( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {

				$http_x_headers         = explode( ',', filter_var_array( $x_forward ) );
				$_SERVER['REMOTE_ADDR'] = $http_x_headers[0];
			} else {
				$_SERVER['REMOTE_ADDR'] = $x_forward;
			}
		}

		return isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	}

	/**
	 * Get timezone by ip address.
	 *
	 * @access public
	 * @since 4.10.26
	 *
	 * @param string $ip_address user's ip address.
	 *
	 * @return string
	 */
	public static function get_timezone_by_ip( $ip_address ) {

		if ( '127.0.0.1' === $ip_address || empty( $ip_address ) ) {
			return date_default_timezone_get();
		}

		$location_data = wp_remote_get(
			'https://api.findip.net/' . $ip_address . '/?token=e21d68c353324af0af206c907e77ff97',
			array(
				'timeout'   => 15,
				'sslverify' => false,
			)
		);
		
		if ( is_wp_error( $location_data ) || empty( $location_data ) || wp_remote_retrieve_body( $location_data ) === 'null' ) {
			return date_default_timezone_get(); // localhost.
		}
		
		$location_data = json_decode( wp_remote_retrieve_body( $location_data ), true );

		$time_zone = strtolower( $location_data['location']['time_zone'] );

		return $time_zone;
	}


	/**
	 * Get Site Server Time ( WordPress TimeZone Setting ).
	 *
	 * @access public
	 *
	 * @param string $format  format.
	 */
	public static function get_site_server_time( $format ) {
		$today = gmdate( $format, strtotime( 'now' ) + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) );

		return $today;
	}

	/**
	 * Compare Condition Value.
	 *
	 * @access public
	 *
	 * @param string       $operator      condition operator.
	 * @param string|array $value         condition value.
	 *
	 * @return bool|void
	 */
	public function compare_browser_value( $operator, $value ) {
		$user_agent = isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) : '';

		$user_agent = $this->get_browser_name( $user_agent );

		$condition_result = is_array( $value ) && ! empty( $value ) ? in_array( $user_agent, $value, true ) : $value === $user_agent;

		return self::get_final_result( $condition_result, $operator );

	}

	/**
	 * Compare Condition Value.
	 *
	 * @access public
	 *
	 * @param string      $operator       condition operator.
	 * @param array       $value          condition value.
	 * @param string|bool $tz        time zone.
	 *
	 * @return bool|void
	 */
	public function compare_date_range_value( $operator, $value, $tz ) {
		$range_date = $value;

		if ( ! is_array( $range_date ) || 2 !== count( $range_date ) ) {
			return false;
		}

		$start = $this->get_date( $range_date[0] );
		$end   = $this->get_date( $range_date[1] );

		$start = strtotime( $start );
		$end   = strtotime( $end );

		$today = 'local' === $tz ? strtotime( self::get_local_time( 'd-m-Y' ) ) : strtotime( self::get_site_server_time( 'd-m-Y' ) );

		$condition_result = ( ( $today >= $start ) && ( $today <= $end ) );

		return self::get_final_result( $condition_result, $operator );
	}

	/**
	 * Compare a date value with today's date based on the given operator and timezone.
	 *
	 * @param string $operator The operator to use for comparison (e.g. '==', '>', '<=').
	 * @param string $value The date value to compare (in 'd-m-Y' format).
	 * @param string $tz The timezone to use for comparison ('local' or 'server').
	 *
	 * @return bool The result of the comparison.
	 */
	public function compare_date_value( $operator, $value, $tz ) {
		if ( ! is_string( $value ) ) {
			return false;
		}
		$value = $this->get_date( $value );

		$value = strtotime( $value );

		$today            = 'local' === $tz ? strtotime( self::get_local_time( 'd-m-Y' ) ) : strtotime( self::get_site_server_time( 'd-m-Y' ) );
		$condition_result = ! empty( $value ) && $today === $value ? true : false;

		return self::get_final_result( $condition_result, $operator );
	}

	/**
	 * Compares the day value with the current day and returns the result based on the operator.
	 *
	 * @param string $operator The operator to use for comparison.
	 * @param array  $value The array of days to compare with the current day.
	 * @param string $tz The timezone to use for getting the current day.
	 *
	 * @return bool The result of the comparison based on the operator.
	 */
	public function compare_day_value( $operator, $value, $tz ) {
		$today = 'local' === $tz ? self::get_local_time( 'l' ) : self::get_site_server_time( 'l' );

		$condition_result = ! empty( $value ) && in_array( strtolower( $today ), $value, true ) ? true : false;

		return self::get_final_result( $condition_result, $operator );
	}

	/**
	 * Compare the location of the user with the given value using the specified operator and method.
	 *
	 * @param string $operator The operator to use for comparison.
	 * @param mixed  $value The value to compare with the user's location.
	 * @param string $method The method to use for getting the user's location.
	 *
	 * @return bool|null The result of the comparison or null if the user's location cannot be determined.
	 */
	public function compare_location_value( $operator, $value, $method ) {

		if ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {

			$x_forward = sanitize_text_field( wp_unslash( $_SERVER['HTTP_X_FORWARDED_FOR'] ) );

			if ( is_array( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {

				$http_x_headers         = explode( ',', filter_var_array( $_SERVER['HTTP_X_FORWARDED_FOR'] ) );
				$_SERVER['REMOTE_ADDR'] = $http_x_headers[0];
			} else {
				$_SERVER['REMOTE_ADDR'] = $x_forward;
			}
		}

		$ip_address = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';

		if ( 'old' === $method ) {

			$location_data = unserialize( rplg_urlopen( 'http://www.geoplugin.net/php.gp?ip=' . $ip_address )['data'] );

			if ( 404 === $location_data['geoplugin_status'] ) {
				return false; // localhost.
			}

			$location = strtolower( $location_data['geoplugin_countryName'] );
		} else {

			$location_data = wp_remote_get(
				'https://api.findip.net/' . $ip_address . '/?token=e21d68c353324af0af206c907e77ff97',
				array(
					'timeout'   => 60,
					'sslverify' => false,
				)
			);

			if ( is_wp_error( $location_data ) || empty( $location_data ) ) {
				return false; // localhost.
			}

			$location_data = json_decode( wp_remote_retrieve_body( $location_data ), true );

			if ( ! $location_data ) {
				return false;
			}

			$location = strtolower( $location_data['country']['names']['en'] );

		}

		$condition_result = is_array( $value ) && ! empty( $value ) ? in_array( $location, $value, true ) : $value === $location;

		return self::get_final_result( $condition_result, $operator );
	}

	/**
	 * Compares the current language with the given value using the specified operator.
	 *
	 * @param string $operator The operator to use for comparison.
	 * @param mixed  $value The value to compare the current language with.
	 * @return mixed|null Returns the final result of the comparison or null if the current language or value is empty.
	 */
	public function compare_language_value( $operator, $value ) {
		$current_lang = function_exists( 'get_locale' ) ? get_locale() : false;

		if ( ! $current_lang || empty( $value ) ) {
			return false;
		}

		$condition_result = in_array( $current_lang, (array) $value, true ) ? true : false;

		return self::get_final_result( $condition_result, $operator );
	}


	/**
	 * Compare the current operating system with the given value using regular expressions.
	 *
	 * @param string $operator The operator to use for comparison.
	 * @param array  $value The value to compare with the current operating system.
	 * @return bool The result of the comparison.
	 */
	public function compare_os_value( $operator, $value ) {
		$user_agent = isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) : '';

		$os_list = array(
			'windows'    => '(Win16)|(Windows 95)|(Win95)|(Windows_95)|(Windows 98)|(Win98)|(Windows NT 5.0)|(Windows 2000)|(Windows NT 5.1)|(Windows XP)|(Windows NT 5.2)|(Windows NT 6.0)|(Windows Vista)|(Windows NT 6.1)|(Windows 7)|(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)|(Windows ME)',
			'mac_os'     => '(Mac_PowerPC)|(Macintosh)|(mac os x)',
			'linux'      => '(Linux)|(X11)',
			'iphone'     => 'iPhone',
			'ipad'       => 'iPad',
			'android'    => '(Android)',
			'open_bsd'   => 'OpenBSD',
			'qnx'        => 'QNX'
		);

		$current_os = array();

		foreach ( $os_list as $key => $key_val ) {

			$match = preg_match( '/' . $key_val . '/i', $user_agent );

			if ( $match ) {
				array_push( $current_os, $key );

				// We need to remove mac_os if iPhone or iPad is the current OS, and Linux if Android is the current OS
				if ( 'iphone' === $key || 'ipad' === $key ) {
					array_shift( $current_os );
				} elseif ( 'android' === $key ) {
					array_shift( $current_os );
				}
			}
		}

		$result = ! empty( array_intersect( $value, $current_os ) ) ? true : false;

		return self::get_final_result( $result, $operator );
	}

	/**
	 * Compares the given value with the current post ID and returns the result based on the operator.
	 *
	 * @param string $operator The operator to use for comparison.
	 * @param mixed  $value    The value to compare with the current post ID.
	 *
	 * @return bool Whether the comparison result is true or false.
	 */
	public function compare_page_value( $operator, $value ) {
		$current_id = get_the_ID();

		if ( is_array( $value ) && ! empty( $value ) ) {
			foreach ( $value as $page ) {
				if ( intval( $page['value'] ) === $current_id ) {
					if ( 'is' === $operator ) {
						return self::get_final_result( true, $operator );
					}
				}
			}
		}

		return false;
	}

	/**
	 * Compares the post format value with the given value using the specified operator.
	 *
	 * @param string $operator The operator to use for comparison.
	 * @param mixed  $value The value to compare with the post format value.
	 * @return bool The result of the comparison.
	 */
	public function compare_post_format_value( $operator, $value ) {
		$post_format = get_post_format( get_the_ID() ) ? : 'standard';

		$condition_result = is_array( $value ) && ! empty( $value ) && in_array( $post_format, $value, true ) ? true : false;

		return self::get_final_result( $condition_result, $operator );
	}

	/**
	 * Compare the post type value with the given operator and value.
	 *
	 * @param string $operator The operator to use for comparison.
	 * @param mixed  $value The value to compare against.
	 * @return bool Whether the comparison is true or false.
	 */
	public function compare_post_type_value( $operator, $value ) {
		if ( is_array( $value ) && ! empty( $value ) ) {
			foreach ( $value as $type ) {

				if ( is_singular( $type ) ) {
					return self::get_final_result( true, $operator );
				}
			}
		}

		return false;
	}

	/**
	 * Compares the post value with the given operator and value.
	 *
	 * @param string $operator The operator to use for comparison.
	 * @param mixed  $value The value to compare with the post value.
	 * @return bool Whether the comparison is true or false.
	 */
	public function compare_post_value( $operator, $value ) {
		if ( is_array( $value ) && ! empty( $value ) ) {
			foreach ( $value as $post ) {
				$post_id = intval( $post['value'] );
				if ( is_single( $post_id ) || is_singular( $post_id ) ) {
					return self::get_final_result( true, $operator );
				}
			}
		}

		return false;
	}

	/**
	 * Compares the value of the condition with the operator.
	 *
	 * @param string $operator The operator to compare the value with.
	 * @return bool Returns true if the condition is met, false otherwise.
	 */
	public function compare_return_visitor_value( $operator ) {
		$page_id = get_the_ID();

		if ( ! $page_id ) {
			return true;
		}

		$condition_result = isset( $_COOKIE[ 'isReturningVisitor' . $page_id ] );

		return self::get_final_result( $condition_result, $operator );
	}

	/**
	 * Compares the static page value with the given operator and value.
	 *
	 * @param string $operator The operator to use for comparison.
	 * @param string $value The value to compare with.
	 *
	 * @return bool The result of the comparison.
	 */
	public function compare_static_page_value( $operator, $value ) {
		switch ( $value ) {
			case 'home':
				$condition_result = is_front_page() && is_home();
				break;

			case 'static':
				$condition_result = is_front_page() && ! is_home();
				break;

			case 'static':
				$condition_result = ! is_front_page() && is_home();
				break;

			default:
				$condition_result = is_404();
				break;
		}

		return self::get_final_result( $condition_result, $operator );
	}

	/**
	 * Compare time range value based on operator, to and from time, and timezone.
	 *
	 * @param string $operator The operator to use for comparison.
	 * @param string $to The end time of the range to compare.
	 * @param string $from The start time of the range to compare.
	 * @param string $tz The timezone to use for comparison.
	 *
	 * @return bool The final result of the comparison.
	 */
	public function compare_time_range_value( $operator, $to, $from, $tz ) {
		if ( ! empty( $to ) ) {
			$to = strtotime( $to );
		}

		if ( ! empty( $from ) ) {
			$from = strtotime( $from );
		}

		$now = 'local' === $tz ? strtotime( self::get_local_time( 'H:i' ) ) : strtotime( self::get_site_server_time( 'H:i' ) );

		if ( ! empty( $from ) && ! empty( $to ) ) {
			$condition_result = ( ( $now >= $from ) && ( $now <= $to ) );
		} elseif ( empty( $from ) ) {
			$condition_result = $now <= $to;
		} else {
			$condition_result = $now >= $from;
		}

		return self::get_final_result( $condition_result, $operator );
	}

	/**
	 * Compares the user role with the given value using the specified operator.
	 *
	 * @param string $operator The operator to use for comparison.
	 * @param mixed  $value The value to compare against.
	 * @return bool Whether the comparison result is true or false.
	 */
	public function compare_user_role_value( $operator, $value ) {
		if ( ! is_user_logged_in() || empty( $value ) ) {
			return false;
		}

		$value = ! is_array( $value ) ? (array) $value : $value; // temp: to make sure it's an array.

		$user = wp_get_current_user();

		$condition_result = ! empty( array_intersect( $value, $user->roles ) ) ? true : false;

		return self::get_final_result( $condition_result, $operator );
	}


	/**
	 * Get valid date
	 *
	 * @param string $date date.
	 *
	 * @return string
	 */
	public function get_date( $date ) {
		list($month, $day, $year) = explode( '/', $date );
		$value                    = "{$day}-{$month}-{$year}";

		return $value;
	}

	/**
	 * Enqueue Editor Assets
	 */
	public function pbg_editor() {
		global $wp_roles;

		// Global Features.
		$global_features = apply_filters( 'pb_global_features', get_option( 'pbg_global_features', array() ) );

		if ( $global_features['premium-display-conditions'] ?? true ) {
			$asset_file   = PREMIUM_BLOCKS_PATH . 'assets/js/build/display-conditions/index.asset.php';
			$dependencies = file_exists( $asset_file ) ? include $asset_file : array();
			$dependencies = $dependencies['dependencies'] ?? array();

			array_push( $dependencies, 'pbg-settings-js' );
			wp_enqueue_script(
				'pbg-display-conditions',
				PREMIUM_BLOCKS_URL . 'assets/js/build/display-conditions/index.js',
				$dependencies,
				$asset_file['version'] ?? PREMIUM_BLOCKS_VERSION,
				true
			);

			$roles = array();

			foreach ( $wp_roles->get_names()  as $role => $name ) {
				$roles[] = array(
					'label' => $name,
					'value' => $role,
				);
			}

			wp_localize_script(
				'pbg-display-conditions',
				'pbgDisplayConditions',
				array(
					'postTypes' => $this->get_post_types_options(),
					'languages' => $this->get_language_options(),
					'roles'     => $roles,
				)
			);

			wp_enqueue_style(
				'pbg-display-conditions',
				PREMIUM_BLOCKS_URL . 'assets/js/build/display-conditions/style-index.css',
				array(),
				$asset_file['version'] ?? PREMIUM_BLOCKS_VERSION,
				'all'
			);
		}
	}

	/**
	 * Get Post Types Options
	 *
	 * @return array
	 */
	public function get_post_types_options() {
		$post_types = get_post_types( array( 'public' => true ), 'objects' );
		$options    = array();

		foreach ( $post_types as $post_type ) {
			$options[] = array(
				'label' => $post_type->label,
				'value' => $post_type->name,
			);
		}

		return $options;
	}

	/**
	 * Get language options
	 *
	 * @return array
	 */
	public function get_language_options() {
		$languages = require_once PREMIUM_BLOCKS_PATH . 'includes/lang-locale.php';

		$options = array();

		foreach ( $languages as $key => $value ) {
			$options[] = array(
				'label' => $value['name'],
				'value' => $key,
			);
		}

		return $options;
	}
}

PBG_Display_Conditions::get_instance();