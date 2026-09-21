<?php
/**
 * Premium Blocks CSS Sanitizer
 *
 * Single place for validating values before they are written into generated CSS.
 * Used when global settings are saved, when they are rendered, and as the
 * escaping layer of the CSS builder.
 *
 * @package Premium_Blocks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

if ( ! class_exists( 'PBG_CSS_Sanitizer' ) ) {

	/**
	 * CSS Sanitizer
	 */
	class PBG_CSS_Sanitizer {

		/**
		 * Allowed font-style keywords.
		 */
		const FONT_STYLES = array( 'normal', 'italic', 'oblique' );

		/**
		 * Allowed text-transform keywords.
		 */
		const TEXT_TRANSFORMS = array( 'none', 'capitalize', 'uppercase', 'lowercase' );

		/**
		 * Allowed text-decoration keywords.
		 */
		const TEXT_DECORATIONS = array( 'none', 'underline', 'overline', 'line-through' );

		/**
		 * Allowed font-weight keywords.
		 */
		const FONT_WEIGHTS = array( 'normal', 'bold', 'bolder', 'lighter', '100', '200', '300', '400', '500', '600', '700', '800', '900' );

		/**
		 * Allowed CSS units.
		 */
		const UNITS = array( 'px', 'em', 'rem', '%', 'vw', 'vh', 'vmin', 'vmax', 'pt', 'ch', 'ex' );

		/**
		 * Values the editor stores to mean "not set".
		 */
		const UNSET_VALUES = array( '', 'Default' );

		/**
		 * Typography elements of the global typography option.
		 */
		const TYPOGRAPHY_ELEMENTS = array( 'heading1', 'heading2', 'heading3', 'heading4', 'heading5', 'heading6', 'button', 'paragraph' );

		/**
		 * Devices.
		 */
		const DEVICES = array( 'Desktop', 'Tablet', 'Mobile' );

		/**
		 * Return the value if it is one of the allowed keywords, otherwise the fallback.
		 *
		 * @param mixed  $value    Value.
		 * @param array  $allowed  Allowed keywords.
		 * @param string $fallback Fallback.
		 * @return string
		 */
		public static function keyword( $value, $allowed, $fallback = '' ) {
			if ( ! is_string( $value ) && ! is_int( $value ) ) {
				return $fallback;
			}
			$value = strtolower( trim( (string) $value ) );

			return in_array( $value, $allowed, true ) ? $value : $fallback;
		}

		/**
		 * Font weight: a keyword or a number between 1 and 1000.
		 *
		 * @param mixed  $value    Value.
		 * @param string $fallback Fallback.
		 * @return string
		 */
		public static function font_weight( $value, $fallback = '' ) {
			if ( ( is_int( $value ) || ( is_string( $value ) && ctype_digit( $value ) ) ) && (int) $value >= 1 && (int) $value <= 1000 ) {
				return (string) (int) $value;
			}

			return self::keyword( $value, self::FONT_WEIGHTS, $fallback );
		}

		/**
		 * Same as keyword() but keeps the editor "not set" markers ('' and 'Default') untouched.
		 *
		 * @param mixed $value   Value.
		 * @param array $allowed Allowed keywords.
		 * @return string
		 */
		public static function setting_keyword( $value, $allowed ) {
			if ( is_string( $value ) && in_array( $value, self::UNSET_VALUES, true ) ) {
				return $value;
			}

			return self::keyword( $value, $allowed, '' );
		}

		/**
		 * Validate a font-family list: letters, numbers, spaces, commas, dots, hyphens, underscores and plus.
		 *
		 * Quotes around the names are valid css and are dropped ( the css builder adds its own ). Anything else makes
		 * the whole value invalid: it is rejected instead of cleaned, so a broken name is never rendered or requested
		 * from Google Fonts.
		 *
		 * @param mixed $value Value.
		 * @return string
		 */
		public static function font_family( $value ) {
			if ( ! is_string( $value ) ) {
				return '';
			}
			$value = trim( preg_replace( '/\s+/', ' ', str_replace( array( '"', "'" ), '', $value ) ) );
			if ( strlen( $value ) > 200 ) {
				return '';
			}
			// Some servers run PCRE without UTF-8 support ( the reason core has _wp_can_use_pcre_u() ), there only ascii names can be checked.
			$pattern = self::supports_unicode_regex() ? '/^[\p{L}\p{N} ,._+\-]*$/u' : '/^[a-zA-Z0-9 ,._+\-]*$/';

			return 1 === preg_match( $pattern, $value ) ? $value : '';
		}

		/**
		 * Whether PCRE was compiled with UTF-8 support.
		 *
		 * @return bool
		 */
		private static function supports_unicode_regex() {
			static $supported = null;
			if ( null === $supported ) {
				// phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged -- same check as core's _wp_can_use_pcre_u().
				$supported = 1 === @preg_match( '/^./u', 'a' );
			}

			return $supported;
		}

		/**
		 * Strict color: hex, rgb(), rgba(), hsl(), hsla(). Returns '' when it does not match.
		 *
		 * @param mixed $value Value.
		 * @return string
		 */
		public static function color( $value ) {
			if ( ! is_string( $value ) ) {
				return '';
			}
			$value = trim( $value );

			if ( preg_match( '/^#(?:[0-9a-fA-F]{3,4}|[0-9a-fA-F]{6}|[0-9a-fA-F]{8})$/', $value ) ) {
				return $value;
			}
			if ( preg_match( '/^(?:rgb|hsl)a?\(\s*[0-9.]+(?:%|deg)?(?:\s*[,\s\/]\s*[0-9.]+(?:%|deg)?){2,3}\s*\)$/i', $value ) ) {
				return $value;
			}

			return '';
		}

		/**
		 * Any CSS color a block can legitimately use: strict colors, keywords, CSS variables,
		 * color functions and gradients. Returns '' when it does not match.
		 *
		 * @param mixed $value Value.
		 * @return string
		 */
		public static function css_color( $value ) {
			if ( ! is_string( $value ) ) {
				return '';
			}
			$value = trim( $value );

			if ( '' !== self::color( $value ) ) {
				return $value;
			}
			// Named colors and keywords (transparent, currentColor, inherit...).
			if ( preg_match( '/^[a-zA-Z]{3,30}$/', $value ) ) {
				return $value;
			}
			// CSS variable, with an optional simple fallback.
			if ( preg_match( '/^var\(\s*--[a-zA-Z0-9_-]+\s*(?:,\s*[a-zA-Z0-9#.,%()\s\-]+)?\)$/', $value ) && self::has_balanced_parentheses( $value ) ) {
				return $value;
			}
			// Color functions and gradients.
			if ( preg_match( '/^(?:rgba?|hsla?|hwb|lab|lch|oklab|oklch|color|color-mix|(?:repeating-)?(?:linear|radial|conic)-gradient)\([a-zA-Z0-9#.,%()\s\-+\/]+\)$/i', $value ) && self::has_balanced_parentheses( $value ) ) {
				return $value;
			}

			return '';
		}

		/**
		 * Numeric value as stored by the editor (number or numeric string). '' when not numeric.
		 *
		 * @param mixed $value Value.
		 * @return string|int|float
		 */
		public static function number( $value ) {
			if ( is_int( $value ) || is_float( $value ) ) {
				return $value;
			}
			if ( is_string( $value ) && is_numeric( trim( $value ) ) && preg_match( '/^-?[0-9]*\.?[0-9]+$/', trim( $value ) ) ) {
				return trim( $value );
			}

			return '';
		}

		/**
		 * CSS unit from the allowlist. '' when not allowed.
		 *
		 * @param mixed $value Value.
		 * @return string
		 */
		public static function unit( $value ) {
			return self::keyword( $value, self::UNITS, '' );
		}

		/**
		 * Slug / id like strings.
		 *
		 * @param mixed $value Value.
		 * @return string
		 */
		public static function slug( $value ) {
			return is_string( $value ) ? preg_replace( '/[^a-zA-Z0-9_-]/', '', $value ) : '';
		}

		/**
		 * Sanitize a responsive range control value (fontSize, lineHeight, letterSpacing).
		 *
		 * @param mixed $value Value.
		 * @return array
		 */
		public static function responsive_range( $value ) {
			if ( ! is_array( $value ) ) {
				return array();
			}
			$clean = array();
			foreach ( self::DEVICES as $device ) {
				if ( isset( $value[ $device ] ) ) {
					$clean[ $device ] = (string) self::number( $value[ $device ] );
				}
			}
			if ( isset( $value['unit'] ) ) {
				if ( is_array( $value['unit'] ) ) {
					$clean['unit'] = array();
					foreach ( self::DEVICES as $device ) {
						if ( isset( $value['unit'][ $device ] ) ) {
							$clean['unit'][ $device ] = self::unit( $value['unit'][ $device ] );
						}
					}
				} else {
					$clean['unit'] = self::unit( $value['unit'] );
				}
			}

			return $clean;
		}

		/**
		 * Sanitize one typography group.
		 *
		 * @param mixed $value Value.
		 * @return array
		 */
		public static function typography( $value ) {
			if ( ! is_array( $value ) ) {
				return array();
			}
			$clean = array();
			if ( isset( $value['fontWeight'] ) ) {
				$clean['fontWeight'] = in_array( $value['fontWeight'], self::UNSET_VALUES, true ) ? $value['fontWeight'] : self::font_weight( $value['fontWeight'] );
			}
			if ( isset( $value['fontStyle'] ) ) {
				$clean['fontStyle'] = self::setting_keyword( $value['fontStyle'], self::FONT_STYLES );
			}
			if ( isset( $value['textTransform'] ) ) {
				$clean['textTransform'] = self::setting_keyword( $value['textTransform'], self::TEXT_TRANSFORMS );
			}
			if ( isset( $value['textDecoration'] ) ) {
				$clean['textDecoration'] = self::setting_keyword( $value['textDecoration'], self::TEXT_DECORATIONS );
			}
			if ( isset( $value['fontFamily'] ) ) {
				$clean['fontFamily'] = self::font_family( $value['fontFamily'] );
			}
			foreach ( array( 'fontSize', 'lineHeight', 'letterSpacing' ) as $range ) {
				if ( isset( $value[ $range ] ) ) {
					$clean[ $range ] = self::responsive_range( $value[ $range ] );
				}
			}

			return $clean;
		}

		/**
		 * Sanitize the pbg_global_typography option.
		 *
		 * @param mixed $value Value.
		 * @return array
		 */
		public static function global_typography( $value ) {
			if ( ! is_array( $value ) ) {
				return array();
			}
			$clean = array();
			foreach ( self::TYPOGRAPHY_ELEMENTS as $element ) {
				if ( isset( $value[ $element ] ) ) {
					$clean[ $element ] = self::typography( $value[ $element ] );
				}
			}

			return $clean;
		}

		/**
		 * Sanitize a list of colors ( slug, color, name ).
		 *
		 * @param mixed $value Value.
		 * @return array
		 */
		public static function color_list( $value ) {
			if ( ! is_array( $value ) ) {
				return array();
			}
			$clean = array();
			foreach ( $value as $item ) {
				if ( ! is_array( $item ) ) {
					continue;
				}
				$color = array(
					'slug'  => self::slug( $item['slug'] ?? '' ),
					'color' => self::color( $item['color'] ?? '' ),
				);
				if ( isset( $item['name'] ) ) {
					$color['name'] = sanitize_text_field( $item['name'] );
				}
				$clean[] = $color;
			}

			return $clean;
		}

		/**
		 * Sanitize the pbg_global_colors option.
		 *
		 * @param mixed $value Value.
		 * @return array
		 */
		public static function global_colors( $value ) {
			if ( ! is_array( $value ) ) {
				return array();
			}
			$clean = array();
			if ( isset( $value['colors'] ) ) {
				$clean['colors'] = self::color_list( $value['colors'] );
			}
			if ( isset( $value['current_palette'] ) ) {
				$clean['current_palette'] = self::slug( $value['current_palette'] );
			}
			if ( isset( $value['custom_colors'] ) ) {
				$clean['custom_colors'] = self::color_list( $value['custom_colors'] );
			}

			return $clean;
		}

		/**
		 * Sanitize the pbg_global_color_palettes option.
		 *
		 * @param mixed $value Value.
		 * @return array
		 */
		public static function color_palettes( $value ) {
			if ( ! is_array( $value ) ) {
				return array();
			}
			$clean = array();
			foreach ( $value as $palette ) {
				if ( ! is_array( $palette ) ) {
					continue;
				}
				$clean[] = array(
					'id'     => self::slug( $palette['id'] ?? '' ),
					'name'   => sanitize_text_field( $palette['name'] ?? '' ),
					'active' => ! empty( $palette['active'] ),
					'colors' => self::color_list( $palette['colors'] ?? array() ),
					'type'   => self::slug( $palette['type'] ?? '' ),
					'skin'   => self::slug( $palette['skin'] ?? '' ),
				);
			}

			return $clean;
		}

		/**
		 * Sanitize the pbg_global_color_palette option.
		 *
		 * @param mixed $value Value.
		 * @return string
		 */
		public static function color_palette( $value ) {
			$value = self::slug( $value );

			return '' === $value ? 'theme' : $value;
		}

		/**
		 * Sanitize the pbg_global_layout option.
		 *
		 * @param mixed $value Value.
		 * @return array
		 */
		public static function global_layout( $value ) {
			if ( ! is_array( $value ) ) {
				return array();
			}
			$clean = array();
			foreach ( array( 'block_spacing', 'container_width', 'tablet_breakpoint', 'mobile_breakpoint' ) as $key ) {
				if ( isset( $value[ $key ] ) && is_numeric( $value[ $key ] ) ) {
					$clean[ $key ] = max( 0, $value[ $key ] + 0 );
				}
			}

			return $clean;
		}

		/**
		 * Escaping layer for a CSS property name.
		 *
		 * @param mixed $property Property.
		 * @return string
		 */
		public static function property( $property ) {
			$property = (string) $property;
			if ( strlen( $property ) === strspn( $property, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_' ) ) {
				return $property;
			}

			return preg_replace( '/[^a-zA-Z0-9_-]/', '', $property );
		}

		/**
		 * Escaping layer for a CSS declaration value. Whatever comes in, the result can not leave
		 * its declaration, its rule or the style element it is printed in.
		 *
		 * @param mixed $value Value.
		 * @return mixed
		 */
		public static function declaration_value( $value ) {
			if ( ! is_string( $value ) ) {
				return is_scalar( $value ) ? $value : '';
			}
			// Fast path, nothing structural in the value.
			if ( strlen( $value ) === strcspn( $value, "<{};\\\"'()*\x00\x01\x02\x03\x04\x05\x06\x07\x08\x09\x0A\x0B\x0C\x0D\x0E\x0F\x10\x11\x12\x13\x14\x15\x16\x17\x18\x19\x1A\x1B\x1C\x1D\x1E\x1F\x7F" ) ) {
				return $value;
			}

			$value      = preg_replace( '/[\x00-\x1F\x7F]/', '', $value );
			$length     = strlen( $value );
			$output     = '';
			$quote      = '';
			$depth      = 0;
			$in_url     = false;
			$url_buffer = '';

			for ( $i = 0; $i < $length; $i++ ) {
				$char = $value[ $i ];

				// An unquoted url() is a single token: a quote, a space or a "(" inside it makes the browser
				// throw the whole thing away as a bad url and keep eating until the next ")". Everything up to
				// that ")" is collected here and percent encoded, so the token can never end anywhere else.
				if ( $in_url ) {
					if ( ')' === $char ) {
						$output    .= self::encode_url_token( $url_buffer ) . ')';
						$url_buffer = '';
						$in_url     = false;
						--$depth;
						continue;
					}
					$url_buffer .= $char;
					continue;
				}

				if ( '\\' === $char ) {
					// Keep escape pairs, drop a dangling backslash that would escape what follows the value.
					if ( $i + 1 < $length ) {
						++$i;
						$output .= self::escape_structural( $value[ $i ], true );
					}
					continue;
				}
				if ( '<' === $char || '{' === $char || '}' === $char ) {
					$output .= self::escape_structural( $char, false );
					continue;
				}
				// A comment can never open or close. Checked against what was already written, so removed characters can not bring the delimiter back.
				$previous = substr( $output, -1 );
				if ( ( '*' === $char && '/' === $previous ) || ( '/' === $char && '*' === $previous ) ) {
					continue;
				}
				if ( '' !== $quote ) {
					if ( $char === $quote ) {
						$quote = '';
					}
					$output .= $char;
					continue;
				}
				if ( '"' === $char || "'" === $char ) {
					$quote = $char;
				} elseif ( '(' === $char ) {
					++$depth;
					$in_url = self::opens_url_token( $output, $value, $i, $length );
				} elseif ( ')' === $char ) {
					if ( 0 === $depth ) {
						continue;
					}
					--$depth;
				} elseif ( ';' === $char && 0 === $depth ) {
					// The value ends here.
					break;
				}
				$output .= $char;
			}

			// Close whatever was left open so it can not swallow the rest of the stylesheet.
			if ( $in_url ) {
				$output .= self::encode_url_token( $url_buffer ) . ')';
				--$depth;
			}
			if ( '' !== $quote ) {
				$output .= $quote;
			}
			if ( $depth > 0 ) {
				$output .= str_repeat( ')', $depth );
			}

			return $output;
		}

		/**
		 * Escaping layer for a CSS selector.
		 *
		 * @param mixed $selector Selector.
		 * @return string
		 */
		public static function selector( $selector ) {
			$selector = (string) $selector;
			if ( strlen( $selector ) === strcspn( $selector, "<{}\x00\x0A\x0D" ) ) {
				return $selector;
			}

			return preg_replace( '/[<{}\x00-\x1F\x7F]/', '', $selector );
		}

		/**
		 * Last line of defense before css is printed inside a style element.
		 * Generated css never contains "<", so this only changes malicious input.
		 *
		 * @param mixed $css Css.
		 * @return string
		 */
		public static function style_tag_content( $css ) {
			$css = is_string( $css ) ? $css : '';
			if ( false === strpos( $css, '<' ) ) {
				return $css;
			}

			return str_replace( '<', '', wp_strip_all_tags( $css ) );
		}

		/**
		 * Whether the "(" at $i opens an unquoted url token, which has to be escaped as one unit.
		 *
		 * url( "x" ) and url( 'x' ) are a function plus an ordinary string, which the quote handling
		 * already covers, so those are left alone. An ident that carries a backslash escape is treated
		 * as url on purpose: percent encoding a value that turns out not to be a url is harmless, while
		 * missing one that is would not be.
		 *
		 * @param string $output What has been written so far.
		 * @param string $value  The whole value.
		 * @param int    $i      Position of the "(".
		 * @param int    $length Length of the value.
		 * @return bool
		 */
		private static function opens_url_token( $output, $value, $i, $length ) {
			// The ident written just before the "(", read backwards. Done by hand rather than with a
			// pattern: the character class would need an escaped backslash, which is easy to get wrong.
			$ident_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_-\\';
			$start       = strlen( $output );
			while ( $start > 0 && false !== strpos( $ident_chars, $output[ $start - 1 ] ) ) {
				--$start;
			}
			$ident = substr( $output, $start );
			if ( '' === $ident ) {
				return false;
			}
			if ( 0 !== strcasecmp( $ident, 'url' ) && false === strpos( $ident, '\\' ) ) {
				return false;
			}
			$next = $i + 1;
			while ( $next < $length && ' ' === $value[ $next ] ) {
				++$next;
			}

			return $next >= $length || ( '"' !== $value[ $next ] && "'" !== $value[ $next ] );
		}

		/**
		 * Percent encode everything that can not appear inside an unquoted url token.
		 *
		 * Leading and trailing spaces are not part of the url, so they are dropped rather than encoded:
		 * url( a.png ) and url(a.png) mean the same thing and must keep meaning it.
		 *
		 * "*" is encoded because the token content never reaches the comment check in the main loop, so
		 * a "/*" inside the url would open a comment that swallows the rest of the stylesheet. "/" is
		 * deliberately left alone: every url needs it, and on its own it opens nothing.
		 *
		 * @param string $url Raw token content.
		 * @return string
		 */
		private static function encode_url_token( $url ) {
			$url = trim( $url, ' ' );

			return strtr(
				$url,
				array(
					'"'  => '%22',
					"'"  => '%27',
					'('  => '%28',
					')'  => '%29',
					' '  => '%20',
					'<'  => '%3C',
					'>'  => '%3E',
					'{'  => '%7B',
					'}'  => '%7D',
					'*'  => '%2A',
					'\\' => '%5C',
				)
			);
		}

		/**
		 * Css escape for the characters that have a structural meaning in css or html.
		 *
		 * @param string $char    Character.
		 * @param bool   $escaped Whether the character was preceded by a backslash.
		 * @return string
		 */
		private static function escape_structural( $char, $escaped ) {
			if ( '<' === $char ) {
				return '\\3C ';
			}
			if ( '{' === $char ) {
				return '\\7B ';
			}
			if ( '}' === $char ) {
				return '\\7D ';
			}

			return $escaped ? '\\' . $char : $char;
		}

		/**
		 * Check parentheses are balanced.
		 *
		 * @param string $value Value.
		 * @return bool
		 */
		private static function has_balanced_parentheses( $value ) {
			$depth  = 0;
			$length = strlen( $value );
			for ( $i = 0; $i < $length; $i++ ) {
				if ( '(' === $value[ $i ] ) {
					++$depth;
				} elseif ( ')' === $value[ $i ] ) {
					--$depth;
					if ( $depth < 0 ) {
						return false;
					}
				}
			}

			return 0 === $depth;
		}
	}
}
