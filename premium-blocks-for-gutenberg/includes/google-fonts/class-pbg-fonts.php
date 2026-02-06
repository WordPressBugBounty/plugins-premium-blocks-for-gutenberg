<?php
/**
 * Helper class for font settings.
 *
 * @package     PBG
 * @author      PBG
 * @copyright   Copyright (c) 2019, PBG
 * @link        https://pbg.io/
 * @since       PBG 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * PBG Fonts
 */
final class PBG_Fonts {

	/**
	 * Get fonts to generate.
	 *
	 * @var array $fonts
	 */
	private static $fonts = array();

	/**
	 * Performance options.
	 *
	 * @var array $performance
	 */
	private static $performance = array();

	/**
	 * Track if preconnect links have been output.
	 *
	 * @var bool $preconnect_outputted
	 */
	private static $preconnect_outputted = false;

	/**
	 * Adds data to the $fonts array for a font to be rendered.
	 *
	 * @param string $name The name key of the font to add.
	 * @param array  $variants An array of weight variants.
	 * @return void
	 */
	public static function add_font( $name, $variants = array() ) {

		// Trim and validate font name
		$name = trim( $name );
		
		if ( empty( $name ) || 'Default' == $name ) {
			return;
		}

		if ( is_array( $variants ) ) {
			$key = array_search( 'Default', $variants );
			if ( false !== $key ) {

				$variants = array_diff( $variants, array( 'Default' ) );

				if ( ! in_array( 400, $variants ) ) {
					$variants[] = 400;
				}
			}
		} elseif ( 'Default' == $variants ) {
			$variants = 400;
		}

		if ( isset( self::$fonts[ $name ] ) ) {
			foreach ( (array) $variants as $variant ) {
				if ( ! in_array( $variant, self::$fonts[ $name ]['variants'] ) ) {
					self::$fonts[ $name ]['variants'][] = $variant;
				}
			}
		} else {
			self::$fonts[ $name ] = array(
				'variants' => (array) $variants,
			);
		}
	}

	/**
	 * Set Fonts
	 *
	 * @param  array $fonts Fonts.
	 * @return void
	 */
	public static function set_fonts( $fonts ) {
		foreach ( $fonts as $name => $font ) {
			
			$variants = array( 'n1', 'i1', 'n2', 'i2', 'n3', 'i3', 'n4', 'i4', 'n5', 'i5', 'n6', 'i6', 'n7', 'i7', 'n8', 'i8', 'n9', 'i9' );
			if ( is_array( $font ) && isset( $font['fontvariants'] ) && ! empty( $font['fontvariants'] ) ) {
				$variants = $font['fontvariants'];
			}
			
			$font_name = ( is_array( $font ) && isset( $font['fontfamily'] ) && ! empty( $font['fontfamily'] ) ) ? $font['fontfamily'] : $name;
			self::add_font( $font_name, $variants );
		}
	}

	/**
	 * Get Fonts
	 */
	public static function get_fonts() {

		do_action( 'pbg_get_fonts' );
		return apply_filters( 'pbg_add_fonts', self::$fonts );
	}

	/**
	 * Renders the <link> tag for all fonts in the $fonts array.
	 *
	 * @return void
	 */
	public static function render_fonts() {
		self::$performance = apply_filters( 'pb_performance_options', get_option( 'pbg_performance_options', array() ) );
		$font_list         = apply_filters( 'pbg_render_fonts', self::get_fonts() );

		$google_fonts = array();
		$font_subset  = array();

		foreach ( $font_list as $name => $font ) {
			// Trim font name to ensure proper handling of names with numbers
			$name = trim( $name );
			
			if ( ! empty( $name ) && isset( $font['variants'] ) ) {

				// Add font variants.
				$google_fonts[ $name ] = $font['variants'];

				// Add Subset.
				$subset = apply_filters( 'pbg_font_subset', '', $name );
				if ( ! empty( $subset ) ) {
					$font_subset[] = $subset;
				}
			}
		}

		$google_font_url = self::google_fonts_url( $google_fonts, $font_subset );

		$load_fonts = self::$performance['premium-load-fonts-locally'] ?? false;
		
		// Add preconnect links for Google Fonts when not loading locally
		if ( $google_font_url && ! $load_fonts ) {
			self::add_preconnect();
		}
		
		if ( $google_font_url ) {
			if ( $load_fonts && ! is_customize_preview() && ! is_admin() ) {
				$preload_fonts = self::$performance['premium-preload-local-fonts'] ?? false;
				if ( $preload_fonts ) {
					self::load_preload_local_fonts( $google_font_url );
				}
				wp_enqueue_style( 'pbg-google-fonts', pbg_get_webfont_url( $google_font_url ), array(), null );
			} else {
				wp_enqueue_style( 'pbg-google-fonts', $google_font_url, array(), null );
			}
		}
	}

	/**
	 * Get the file preloads.
	 *
	 * @param string $url    The URL of the remote webfont.
	 * @param string $format The font-format. If you need to support IE, change this to "woff".
	 */
	public static function load_preload_local_fonts( $url, $format = 'woff2' ) {
		// Check if the font has already been loaded.
		$font_loaded = self::is_font_loaded($url);
		if ($font_loaded) {
			return;
		}
	
		// Add the font URL to the list of loaded fonts.
		self::add_loaded_font($url);
	
		// Output the preload link tag.
		echo '<link rel="preload" href="' . esc_url( $url ) . '" as="font" type="font/' . esc_attr( $format ) . '" crossorigin>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
	
	/**
	 * Check if the font has already been loaded.
	 *
	 * @param string $font_url The URL of the font to check.
	 * @return bool True if font has already been loaded, false otherwise.
	 */
	public static function is_font_loaded($font_url) {
		$loaded_fonts = get_option('pbg_loaded_fonts', array());
		return in_array($font_url, $loaded_fonts);
	}
	
	/**
 * Add the loaded font to the list of loaded fonts.
 *
 * @param string $font_url The URL of the font that has been loaded.
 */
public static function add_loaded_font($font_url) {
    $loaded_fonts = get_option('pbg_loaded_fonts', array());
    $loaded_fonts[] = $font_url;
    update_option('pbg_loaded_fonts', $loaded_fonts);
}

	/**
	 * Google Font URL
	 * Combine multiple google font in one URL
	 *
	 * @link https://shellcreeper.com/?p=1476
	 * @param array $fonts      Google Fonts array.
	 * @param array $subsets    Font's Subsets array.
	 *
	 * @return string
	 */
	public static function google_fonts_url( $fonts, $subsets = array() ) {

		/* URL */
		$base_url  = 'https://fonts.googleapis.com/css2?';
		$font_args = array();
		$families  = array();
		$weights   = array(
			'italic' => array(),
			'normal' => array(),
		);
		$fonts     = apply_filters( 'pbg_google_fonts', $fonts );

		/* Format Each Font Family in Array */
		foreach ( $fonts as $font_name => $font_weight ) {
			$family      = '';
			// Properly encode font name for Google Fonts API (spaces to +, preserve numbers and other characters)
			$font_name   = str_replace( ' ', '+', trim( $font_name ) );
			$family      = 'family=' . $font_name;
			$weight_text = 'wght@';
			$wghts       = array();
			$weights     = array(
				'italic' => array(),
				'normal' => array(),
			);
			
			// Process font weights if available
			if ( ! empty( $font_weight ) && is_array( $font_weight ) ) {
				foreach ( $font_weight as $weight ) {
					
					if ( is_string( $weight ) && strlen( $weight ) >= 2 ) {
						$weight_val = (int) $weight[1] * 100;
						if ( 'i' === $weight[0] ) {
							$weights['italic'][] = $weight_val;
						} else {
							$weights['normal'][] = $weight_val;
						}
					}
				}
			}
			
			// If no weights specified, use default weight 400
			if ( empty( $weights['normal'] ) && empty( $weights['italic'] ) ) {
				$weights['normal'][] = 400;
			}
			
			// Build weight string
			sort( $weights['italic'] );
			sort( $weights['normal'] );

			if ( ! empty( $weights['normal'] ) ) {
				$weights['normal'] = array_unique( $weights['normal'] );
				foreach ( $weights['normal'] as $wght ) {
					$wghts[] = ! empty( $weights['italic'] ) ? '0,' . $wght : $wght;
				}
			}

			if ( ! empty( $weights['italic'] ) ) {
				$family           .= ':ital,';
				$weights['italic'] = array_unique( $weights['italic'] );
				foreach ( $weights['italic'] as $wght ) {
					$wghts[] = '1,' . $wght;
				}
			} else {
				$weight_text = ':wght@';
			}

			$weight_text .= implode( ';', $wghts );
			$families[]   = $family . $weight_text;
		}

		if ( ! empty( $families ) ) {
			$base_url .= implode( '&', $families );
			$base_url .= '&display=swap';

			return $base_url;
		}

		return false;
	}

	/**
	 * Add preconnect for Google Fonts
	 *
	 * @access public
	 * @since 1.1.0
	 * @return void
	 */
	public static function add_preconnect() {
		// Prevent duplicate output
		if ( self::$preconnect_outputted ) {
			return;
		}

		if ( ! self::using_google_fonts() ) {
			return;
		}

		$html = "<link rel='preconnect' href='https://fonts.googleapis.com'>\n";
		$html .= "<link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>\n";
		
		echo wp_kses(
			$html,
			array(
				'link' => array(
					'rel' => array(),
					'href' => array(),
					'crossorigin' => array(),
				),
			)
		);

		// Mark as outputted to prevent duplicates
		self::$preconnect_outputted = true;
	}

	/**
	 * Check if using Google Fonts
	 *
	 * @access private
	 * @since 1.1.0
	 * @return boolean
	 */
	private static function using_google_fonts() {
		$performance = apply_filters( 'pb_performance_options', get_option( 'pbg_performance_options', array() ) );
		$load_fonts = $performance['premium-load-fonts-locally'] ?? false;
		
		// If loading fonts locally, we don't need preconnect
		return ! $load_fonts;
	}
}
