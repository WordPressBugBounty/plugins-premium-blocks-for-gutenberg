<?php


/**
 * Class to create a minified css output.
 */
class Premium_Blocks_css {


	/**
	 * The css selector that you're currently adding rules to
	 *
	 * @access protected
	 * @var string
	 */
	protected $_selector = '';

	/**
	 * Associative array of Google Fonts to load.
	 *
	 * Do not access this property directly, instead use the `get_google_fonts()` method.
	 *
	 * @var array
	 */
	protected static $google_fonts = array();
	public static $footer_gfonts   = array();
	public static $gfonts          = array();


	/**
	 * Stores the final css output with all of its rules for the current selector.
	 *
	 * @access protected
	 * @var string
	 */
	protected $_selector_output = '';

	/**
	 * Can store a list of additional selector states which can be added and removed.
	 *
	 * @access protected
	 * @var array
	 */
	protected $_selector_states = array();



	/**
	 * Stores all of the rules that will be added to the selector
	 *
	 * @access protected
	 * @var string
	 */
	protected $_css = '';

	/**
	 * Stores all of the custom css.
	 *
	 * @access protected
	 * @var string
	 */
	protected $_css_string = '';

	/**
	 * The string that holds all of the css to output
	 *
	 * @access protected
	 * @var array
	 */
	protected $_output = '';

	/**
	 * Stores media queries
	 *
	 * @var null
	 */
	protected $_media_query = null;

	/**
	 * The string that holds all of the css to output inside of the media query
	 *
	 * @access protected
	 * @var string
	 */
	protected $_media_query_output = '';


	public function __construct() {
		add_action( 'wp_head', array( $this, 'frontend_gfonts' ), 90 );
		add_action( 'wp_footer', array( $this, 'frontend_footer_gfonts' ), 90 );
		$this->_output = array(
			'desktop' => '',
			'tablet'  => '',
			'mobile'  => '',
		);
	}


	public function frontend_gfonts() {
		if ( empty( self::$gfonts ) ) {
			return;
		}
		$print_google_fonts = apply_filters( 'pbg_blocks_print_google_fonts', true );
		if ( ! $print_google_fonts ) {
			return;
		}
		// Load Google Fonts.
		PBG_Fonts::set_fonts( self::$gfonts );
		PBG_Fonts::render_fonts();
	}

	/**
	 * Load Google Fonts in Frontend
	 */
	public function frontend_footer_gfonts() {
		if ( empty( self::$footer_gfonts ) ) {
			return;
		}
		$print_google_fonts = apply_filters( 'premium_blocks_print_footer_google_fonts', true );
		if ( ! $print_google_fonts ) {
			return;
		}
		// Load Google Fonts.
		PBG_Fonts::set_fonts( $print_google_fonts );
		PBG_Fonts::render_fonts();
	}

	/**
	 * Sets a selector to the object and changes the current selector to a new one
	 *
	 * @access public
	 * @since  1.0
	 *
	 * @param  string $selector - the css identifier of the html that you wish to target.
	 * @return $this
	 */
	public function set_selector( $selector = '' ) {
		// Render the css in the output string everytime the selector changes.
		if ( '' !== $this->_selector ) {
			$this->add_selector_rules_to_output();
		}
		$this->_selector = $selector;
		return $this;
	}
	/**
	 * Sets css string for final output.
	 *
	 * @param  string $string - the css string.
	 * @return $this
	 */
	public function add_css_string( $string ) {
		$this->_css_string .= $string;
		return $this;
	}

	/**
	 * Wrapper for the set_selector method, changes the selector to add new rules
	 *
	 * @access public
	 * @since  1.0
	 *
	 * @see    set_selector()
	 * @param  string $selector the css selector.
	 * @return $this
	 */
	public function change_selector( $selector = '' ) {
		return $this->set_selector( $selector );
	}

	/**
	 * Adds a pseudo class to the selector ex. :hover, :active, :focus
	 *
	 * @access public
	 * @since  1.0
	 *
	 * @param  $state - the selector state
	 * @param  reset - if true the        $_selector_states variable will be reset
	 * @return $this
	 */
	public function add_selector_state( $state, $reset = true ) {
		if ( $reset ) {
			$this->reset_selector_states();
		}
		$this->_selector_states[] = $state;
		return $this;
	}

	/**
	 * Adds multiple pseudo classes to the selector
	 *
	 * @access public
	 * @since  1.0
	 *
	 * @param  array $states - the states you would like to add
	 * @return $this
	 */
	public function add_selector_states( $states = array() ) {
		$this->reset_selector_states();
		foreach ( $states as $state ) {
			$this->add_selector_state( $state, false );
		}
		return $this;
	}

	/**
	 * Removes the selector's pseudo classes
	 *
	 * @access public
	 * @since  1.0
	 *
	 * @return $this
	 */
	public function reset_selector_states() {
		$this->add_selector_rules_to_output();
		if ( ! empty( $this->_selector_states ) ) {
			$this->_selector_states = array();
		}
		return $this;
	}

	/**
	 * Adds a new rule to the css output
	 *
	 * @access public
	 * @since  1.0
	 *
	 * @param  string $property - the css property.
	 * @param  string $value - the value to be placed with the property.
	 * @param  string $prefix - not required, but allows for the creation of a browser prefixed property.
	 * @return $this
	 */
	public function add_rule( $property, $value, $prefix = null ) {
		$format = is_null( $prefix ) ? '%1$s:%2$s;' : '%3$s%1$s:%2$s;';
		if ( $value && ! empty( $value ) ) {
			$this->_css .= sprintf( $format, $property, $value, $prefix );
		}
		return $this;
	}



	/**
	 * Adds a css property with value to the css output
	 *
	 * @access public
	 * @since  1.0
	 *
	 * @param  string $property - the css property
	 * @param  string $value - the value to be placed with the property
	 * @return $this
	 */
	public function add_property( $property, $value = null ) {
		if ( null === $value ) {
			return $this;
		}

		$this->add_rule( $property, $value );

		return $this;
	}

	/**
	 * Adds multiple properties with their values to the css output
	 *
	 * @access public
	 * @since  1.0
	 *
	 * @param  array $properties - a list of properties and values
	 * @return $this
	 */
	public function add_properties( $properties ) {
		foreach ( (array) $properties as $property => $value ) {
			$this->add_property( $property, $value );
		}
		return $this;
	}

	/**
	 * Sets a media query in the class
	 *
	 * @since  1.1
	 * @param  string $value
	 * @return $this
	 */
	public function start_media_query( $value ) {
		// Add the current rules to the output
		$this->add_selector_rules_to_output();

		// Add any previous media queries to the output
		if ( $this->has_media_query() ) {
			$this->add_media_query_rules_to_output();
		}

		// Set the new media query
		$this->_media_query = $value;
		return $this;
	}

	/**
	 * Stops using a media query.
	 *
	 * @see    start_media_query()
	 *
	 * @since  1.1
	 * @return $this
	 */
	public function stop_media_query() {
		return $this->start_media_query( null );
	}

	/**
	 * Gets the media query if it exists in the class
	 *
	 * @since  1.1
	 * @return string|int|null
	 */
	public function get_media_query() {
		 return $this->_media_query;
	}

	/**
	 * Checks if there is a media query present in the class
	 *
	 * @since  1.1
	 * @return boolean
	 */
	public function has_media_query() {
		if ( ! empty( $this->get_media_query() ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Adds the current media query's rules to the class' output variable
	 *
	 * @since  1.1
	 * @return $this
	 */
	private function add_media_query_rules_to_output() {
		if ( ! empty( $this->_media_query_output ) ) {
			// Add the current media query's rules to the output.
			$media_query_output                   = $this->get_media_query();
			$this->_output[ $media_query_output ] = $this->_media_query_output;

			// Reset the media query output string.
			$this->_media_query_output = '';
		}

		return $this;
	}

	/**
	 * Adds the current selector rules to the output variable
	 *
	 * @access private
	 * @since  1.0
	 *
	 * @return $this
	 */
	private function add_selector_rules_to_output() {
		if ( ! empty( $this->_css ) ) {
			$this->prepare_selector_output();
			$selector_output = sprintf( '%1$s{%2$s}', $this->_selector_output, $this->_css );

			if ( $this->has_media_query() ) {
				// Add the current selector's rules to the media query output.
				$this->_media_query_output .= $selector_output;
				$this->reset_css();
			} else {
				// Add the current selector's rules to the desktop output.
				$this->_output['desktop'] .= $selector_output;
			}

			// Reset the css.
			$this->reset_css();
		}

		return $this;
	}

	public function render_color( $color, $opacity = null ) {
		if ( empty( $color ) || 'px' === $color || 'Default' === $color ) {
			return false;
		}
		return $color;
	}

	/**
	 * Prepares the $_selector_output variable for rendering
	 *
	 * @access private
	 * @since  1.0
	 *
	 * @return $this
	 */
	private function prepare_selector_output() {
		if ( ! empty( $this->_selector_states ) ) {
			// Create a new variable to store all of the states.
			$new_selector = '';

			foreach ( (array) $this->_selector_states as $state ) {
				$format        = end( $this->_selector_states ) === $state ? '%1$s%2$s' : '%1$s%2$s,';
				$new_selector .= sprintf( $format, $this->_selector, $state );
			}
			$this->_selector_output = $new_selector;
		} else {
			$this->_selector_output = $this->_selector;
		}
		return $this;
	}

	/**
	 * Generates the measure output.
	 *
	 * @param array $measure an array of font settings.
	 * @return string
	 */
	public function render_spacing( $measure, $unit = 'px') {

		if ( empty( $measure ) ) {
			return false;
		}
		
		if(is_array($unit)){
			$unit="px";
		}

		if ( ! is_numeric( $measure['top'] ) && ! is_numeric( $measure['right'] ) && ! is_numeric( $measure['bottom'] ) && ! is_numeric( $measure['left'] ) ) {
			return false;
		}

		$size_string = ( is_numeric( $measure['top'] ) ? $measure['top'] : '0' ) . $unit . ' ' . ( is_numeric( $measure['right'] ) ? $measure['right'] : '0' ) . $unit . ' ' . ( is_numeric( $measure['bottom'] ) ? $measure['bottom'] : '0' ) . $unit . ' ' . ( is_numeric( $measure['left'] ) ? $measure['left'] : '0' ) . $unit;

		return $size_string;
	}

	public function add_gfont( $attr ) {

		$defaults = array(
			'googleFont'     => true,
			'loadGoogleFont' => true,
			'fontFamily'     => '',
			'fontVariant'    => '',
		);
		$attr     = wp_parse_args( $attr, $defaults );

		if ( true == $attr['googleFont'] && true == $attr['loadGoogleFont'] && ! empty( $attr['fontFamily'] ) ) {
			// Check if the font has been added yet.
			if ( ! array_key_exists( $attr['fontFamily'], self::$gfonts ) ) {
				$add_font                            = array(
					'fontfamily'   => $attr['fontFamily'],
					'fontvariants' => ( isset( $attr['fontVariant'] ) && ! empty( $attr['fontVariant'] ) ? array( $attr['fontVariant'] ) : array() ),
				);
				self::$gfonts[ $attr['fontFamily'] ] = $add_font;
				// Check if wp_head has already run in which case we need to add to footer fonts.
				if ( did_action( 'wp_body_open' ) >= 1 ) {
					self::$footer_gfonts[ $attr['fontFamily'] ] = $add_font;
				}
			} else {
				if ( isset( $attr['fontVariant'] ) && ! empty( $attr['fontVariant'] ) ) {
					if ( ! in_array( $attr['fontVariant'], self::$gfonts[ $attr['fontFamily'] ]['fontvariants'], true ) ) {
						array_push( self::$gfonts[ $attr['fontFamily'] ]['fontvariants'], $attr['fontVariant'] );
						if ( did_action( 'wp_body_open' ) >= 1 ) {
							if ( ! array_key_exists( $attr['fontFamily'], self::$footer_gfonts ) ) {
								$add_font                                   = array(
									'fontfamily'   => $attr['fontFamily'],
									'fontvariants' => ( isset( $attr['fontVariant'] ) && ! empty( $attr['fontVariant'] ) ? array( $attr['fontVariant'] ) : array() ),
								);
								self::$footer_gfonts[ $attr['fontFamily'] ] = $add_font;
							} else {
								array_push( self::$footer_gfonts[ $attr['fontFamily'] ]['fontvariants'], $attr['fontVariant'] );
							}
						}
					}
				}
			}
		}
	}


	/**
	 * Generates the size output.
	 *
	 * @param array  $size an array of size settings.
	 * @param string $device the device this is showing on.
	 * @param bool   $render_zero if 0 should be rendered or not.
	 * @return string
	 */
	public function render_range( $size, $device ) {
		if ( empty( $size ) ) {
			return false;
		}
		if ( ! isset( $size[ $device ] ) || $size[ $device ] ==="" ) {
			return false;
		}
		$size_type;
		if (isset( $size['unit'][$device] )&& is_array($size['unit'])&& ! empty( $size['unit'][$device]   )) {
			$size_type=$size['unit'][$device];
		} elseif(isset( $size['unit'] )&& is_string($size['unit']) && ! empty( $size['unit'] )) {
			$size_type=$size['unit'];
		}else{
			$size_type='px';
		}
		
		$size_string = $size[ $device ] . $size_type;

		return $size_string;
	}

	/**
	 * Render shadow for an element.
	 *
	 * @param array $shadow An array containing the shadow properties.
	 *                      Properties include: color, horizontal, vertical, blur, position and opacity.
	 *                      All properties are optional.
	 * @return string|bool The rendered shadow string or false if invalid parameters are passed.
	 */
	public function render_shadow( $shadow ) {
		
		if ( empty( $shadow ) ) {
			return false;
		}
		if (  $shadow["color"] === "transparent") {
			return false;
		}
		if ( ! isset( $shadow['horizontal'] ) ) {
			return false;
		}
		if ( ! isset( $shadow['vertical'] ) ) {
			return false;
		}
		if ( ! isset( $shadow['blur'] ) ) {
			return false;
		}
	
		if ( isset($shadow['position'] )  && $shadow['position'] === 'inset' ) {
			$shadow_string = 'inset ' . ( ! empty( $shadow['horizontal'] ) ? $shadow['horizontal'] : '0' ) . 'px ' . ( ! empty( $shadow['vertical'] ) ? $shadow['vertical'] : '0' ) . 'px ' . ( ! empty( $shadow['blur'] ) ? $shadow['blur'] : '0' ) . 'px ' . ( ! empty( $shadow['color'] ) ? $this->render_color( $shadow['color'], $shadow['opacity'] ) : $this->render_color( '#000000' ) );
		} else {
			$shadow_string = ( ! empty( $shadow['horizontal'] ) ? $shadow['horizontal'] : '0' ) . 'px ' . ( ! empty( $shadow['vertical'] ) ? $shadow['vertical'] : '0' ) . 'px ' . ( ! empty( $shadow['blur'] ) ? $shadow['blur'] : '0' ) . 'px ' . ( ! empty( $shadow['color'] ) ? $this->render_color( $shadow['color'] ) : $this->render_color( '#000000' ) );
		}

		return $shadow_string;
	}

	/**
	 * Render a filter based on the given parameters.
	 *
	 * @param array $filter An array of filter parameters.
	 *                      Properties include: bright, contrast, saturation, blur and hue.
	 *                      All properties are optional.
	 * @return string|bool The rendered filter string or false if invalid parameters are passed.
	 */
	public function render_filter( $filter ) {
		if ( empty( $filter ) ) {
			return false;
		}
		if ( ! isset( $filter['bright'] ) || ! isset( $filter['contrast'] )
			|| ! isset( $filter['saturation'] ) || ! isset( $filter['blur'] ) || ! isset( $filter['hue'] ) ) {
			return false;
		}

		$filter_string = 'brightness(' . $filter['bright'] . '%) contrast(' . $filter['contrast'] . '%) saturate(' . $filter['saturation'] . '%) blur(' . $filter['blur'] . 'px) hue-rotate(' . $filter['hue'] . 'deg)';

		return $filter_string;
	}

	public function render_align_self($align){
		$alignSelf="";
		switch ($align) {
			case "left":
				$alignSelf="flex-start";
				break;
				case "right":
					$alignSelf="flex-end";
					break;
					case "center":
						$alignSelf="center";
						break;
			default:
				break;
		}
		return $alignSelf;
	}

	public function render_text_align($align){
		$textAlign="";
		switch ($align) {
			case "flex-start":
				$textAlign="left";
				break;
			case "flex-end":
				$textAlign="right";
				break;
			case "center":
				$textAlign="center";
				break;
			default:
				break;
		}
		return $textAlign;
	}
	/**
	 * Render a background based on the given parameters.
	 *
	 * @param array  $background An array of background parameters.
	 * @param object $css The CSS object to add properties to.
	 *
	 * @return void|false False if no background is specified, otherwise void.
	 */
	public function render_background( $background, $device ) {
		if ( empty( $background ) ) {
			return false;
		}
		if ( ! is_array( $background ) ) {
			return false;
		}
		if ( empty( $background['backgroundType'] ) ) {
			return false;
		}
		$background_string = '';
		$type              = ( isset( $background['backgroundType'] ) && ! empty( $background['backgroundType'] ) ? $background['backgroundType'] : 'transparent' );
		$color_type        = '';
		if($type==='transparent'){
			$this->add_property( 'background-color', "transparent" );

		}
		if ( isset( $background['backgroundColor'] ) && ! empty( $background['backgroundColor'] ) && $type == 'solid' ) {

			$color_type = $background['backgroundColor'];
		}
		if ( 'solid' === $type && isset( $background['backgroundImageURL'] ) ) {
			$image_url = ( isset( $background['backgroundImageURL'] ) && ! empty( $background['backgroundImageURL'] ) ? $background['backgroundImageURL'] : '' );
			if ( ! empty( $image_url ) ) {
				$repeat   = ( isset( $background['backgroundRepeat'] ) && ! empty( $background['backgroundRepeat'][$device] ) ? $background['backgroundRepeat'][$device] : '' );
				$size     = ( isset( $background['backgroundSize'] ) && ! empty( $background['backgroundSize'][$device] ) ? $background['backgroundSize'][$device] : '' );
				$position = ( isset( $background['backgroundPosition'] ) && ! empty( $background['backgroundPosition'][$device] ) ? $background['backgroundPosition'][$device] : 'center center' );
				// $background_string = ( ! empty( $color_type ) ? $color_type . ' ' : '' ) . $image_url . ( ! empty( $repeat ) ? ' ' . $repeat : '' ) . ( ! empty( $position ) ? ' ' . $position : '' ) . ( ! empty( $size ) ? ' ' . $size : '' ) . ( ! empty( $attachement ) ? ' ' . $attachement : '' );
				$this->add_property( 'background-color', $this->render_string($color_type, '!important' ) );
				$this->add_property( 'background-image', 'url(' . $image_url . ')' );
				$this->add_property( 'background-repeat', $this->get_responsive_css( $background['backgroundRepeat'], $device ) );
				$this->add_property( 'background-position', $this->get_responsive_css( $background['backgroundPosition'], $device ) );
				$this->add_property( 'background-size', $this->get_responsive_css( $background['backgroundSize'], $device ) );
			} else {
				if ( ! empty( $color_type ) ) {
					$background_string = $color_type;
					$this->add_property( 'background-color', $this->render_string($color_type, '!important' ) );
				}
			}
		} elseif ( 'gradient' === $type ) {
			$first_grid  = (isset( $background['backgroundColor'] ) && ! empty( $background['backgroundColor']) )? $background['backgroundColor'] : 'rgba(255,255,255,0)';
			$second_grid = (isset( $background['gradientColorTwo'] ) && ! empty( $background['gradientColorTwo']) ) ? $background['gradientColorTwo'] : '#777';
			if ( 'radial' === $background['gradientType'] ) {
				$container_bg = 'radial-gradient(at ' . $background['gradientPosition'] . ', ' . $first_grid . ' ' . $background['gradientLocationOne'] . '%, ' . $second_grid . ' ' . $background['gradientLocationTwo'] . '%)';
			} elseif ( 'radial' !== $background['backgroundType'] ) {
				$container_bg = 'linear-gradient(' . $background['gradientAngle'] . 'deg, ' . $first_grid . ' ' . $background['gradientLocationOne'] . '%, ' . $second_grid . ' ' . $background['gradientLocationTwo'] . '%)';
			}
			$this->add_property( 'background', $container_bg );
		} else {
			if ( ! empty( $color_type ) ) {
				$background_string = $color_type;
				$this->add_property( 'background-color', $this->render_string($color_type, '!important' ) );
			}
		}
	}

	/**
	 * Resets the css variable
	 *
	 * @access private
	 * @since  1.1
	 *
	 * @return void
	 */
	private function reset_css() {
		$this->_css = '';
		return;
	}

	/**
	 * Returns the google fonts array from the compiled css.
	 *
	 * @access public
	 * @since  1.0
	 *
	 * @return string
	 */
	public function fonts_output() {
		return self::$google_fonts;
	}

	/**
	 * Returns the minified css in the $_output variable
	 *
	 * @access public
	 * @since  1.0
	 *
	 * @return string
	 */
	public function css_output() {
		// Add current selector's rules to output
		$this->add_selector_rules_to_output();

		// Output minified css
		return $this->_output;
	}


	public function render_string( $string = null ,$second=null) {
		if ( empty( $string ) ) {
			return false;
		}
		$string = $string . ( isset( $second ) && ! empty( $second ) ? $second : '' );


		return $string;
	}

	public function render_border($border,$device){
		if(empty($border)){
			return false;
		}
		if ( ! is_array( $border ) ) {
			return false;
		}
		if ( isset( $border['borderColor'] ) &&  ! empty( $border['borderColor'] ) ) {
			$this->add_property( 'border-color', $this->render_color( $border['borderColor']) );
		}
		if ( isset( $border['borderType'] ) &&  ! empty( $border['borderType'] ) ) {
			$this->add_property( 'border-style', $border['borderType'] );
		}

		$this->add_property( 'border-width', $this->render_spacing( $border['borderWidth'][$device], 'px' ) );
		$this->add_property( 'border-radius', $this->render_spacing( $border['borderRadius'][$device], 'px' ) );

	}

	public function get_responsive_value( $values, $side = '', $device = 'Desktop', $unit = 'px' ) {
		return isset( $values[ $device ][ $side ] ) && $values[ $device ][ $side ] ? "{$values[$device][$side]}{$unit}" : '';
	}

	public function get_responsive_css( $values, $device = 'Desktop' ) {
		return isset( $values[ $device ] ) && $values[ $device ] ? "{$values[$device]}" : '';
	}

  // New Functions 

  public function pbg_render_value($attributes, $name, $property, $device = '', $prefix = '', $postfix = '') {
    if (empty($attributes) || !is_array($attributes) || empty($name) || empty($property)) {
      return false;
    }

    $value = $this->find_nested_keys($attributes, $name);

    $is_responsive = !empty($device);
    $final_value = '';

    if($is_responsive){
      if (null === $value || !is_array($value) || !isset($value[$device]) || $value[$device] === '') {
        return false;
      }
      $final_value = $value[$device];
    }else{
      if (null === $value || !isset($value) || $value === '') {
        return false;
      }
      $final_value = $value;
    }
    
    $this->add_property($property, $prefix . $final_value . $postfix);
  }

  public function pbg_render_align_self($attributes, $name, $property, $device = '', $prefix = '', $postfix = '') {
    if (empty($attributes) || !is_array($attributes) || empty($name) || empty($property)) {
      return false;
    }

    $value = $this->find_nested_keys($attributes, $name);

    $is_responsive = !empty($device);
    $final_value = '';

    if($is_responsive){
      if (null === $value || !is_array($value) || !isset($value[$device]) || $value[$device] === '') {
        return false;
      }
      switch ($value[$device]) {
        case "left":
          $final_value="flex-start";
          break;
        case "right":
          $final_value="flex-end";
          break;
        case "center":
          $final_value="center";
          break;
        default:
          break;
      }
    }else{
      if (null === $value || !isset($value) || $value === '') {
        return false;
      }
      switch ($value) {
        case "left":
          $final_value="flex-start";
          break;
        case "right":
          $final_value="flex-end";
          break;
        case "center":
          $final_value="center";
          break;
        default:
          break;
      }
    }
    
    $this->add_property($property, $prefix . $final_value . $postfix);
  }

  public function pbg_render_spacing($attributes, $name, $property, $device = '', $prefix = '', $postfix = ''){
    if (empty($attributes) || !is_array($attributes) || empty($name) || empty($property)) {
      return false;
    }

    $value_at_path = $this->find_nested_keys($attributes, $name);

    $is_responsive = !empty($device);
    $device_values = '';
    
    if($is_responsive){
      if (null === $value_at_path || !is_array($value_at_path) || !isset($value_at_path[$device]) || $value_at_path[$device] === "") {
        return false;
      }
      $device_values = $value_at_path[$device];
    }else{
      if (null === $value_at_path || !is_array($value_at_path)) {
        return false;
      }
      $device_values = $value_at_path;
    }
    
    $unit = 'px';
    if (isset($value_at_path['unit'])) {
        $unit_setting = $value_at_path['unit'];
        if (is_array($unit_setting) && isset($unit_setting[$device]) && !empty($unit_setting[$device])) {
            $unit = $unit_setting[$device];
        } elseif (is_string($unit_setting) && !empty($unit_setting)) {
            $unit = $unit_setting;
        }
    }

    if (
        !is_numeric($device_values['top'] ?? "") &&
        !is_numeric($device_values['right'] ?? "") &&
        !is_numeric($device_values['bottom'] ?? "") &&
        !is_numeric($device_values['left'] ?? "")
    ) {
			return false;
		}

    $top    = (isset($device_values['top'])    && is_numeric($device_values['top']))    ? $device_values['top']    : '0';
    $right  = (isset($device_values['right'])  && is_numeric($device_values['right']))  ? $device_values['right']  : '0';
    $bottom = (isset($device_values['bottom']) && is_numeric($device_values['bottom'])) ? $device_values['bottom'] : '0';
    $left   = (isset($device_values['left'])   && is_numeric($device_values['left']))   ? $device_values['left']   : '0';

    $multi_values = "{$top}{$unit} {$right}{$unit} {$bottom}{$unit} {$left}{$unit}";

    $this->add_property( $property, $prefix . $multi_values . $postfix);
  }

  public function pbg_render_border($attributes, $name, $device = '', $prefix = '', $postfix = ''){
    if (empty($attributes) || !is_array($attributes) || empty($name)) {
      return false;
    }

    $value_at_path = $this->find_nested_keys($attributes, $name);

    if (null === $value_at_path || !is_array($value_at_path) || empty($value_at_path)) {
      return false;
    }

		if ( isset( $value_at_path['borderColor'] ) &&  ! empty( $value_at_path['borderColor'] ) && $value_at_path['borderColor'] !== 'Default' ) {
			$this->add_property( 'border-color', $value_at_path['borderColor'] );
		}
		if ( isset( $value_at_path['borderType'] ) &&  ! empty( $value_at_path['borderType'] ) ) {
			$this->add_property( 'border-style', $value_at_path['borderType'] );
		}

    $this->pbg_render_spacing($value_at_path, 'borderWidth', 'border-width', $device);
    $this->pbg_render_spacing($value_at_path, 'borderRadius', 'border-radius', $device);
  }

  public function pbg_render_range($attributes, $name, $property, $device = '', $prefix = '', $postfix = ''){
    if (empty($attributes) || !is_array($attributes) || empty($name) || empty($property)) {
      return false;
    }

    $value = $this->find_nested_keys($attributes, $name);

    $is_responsive = !empty($device);
    $final_value = '';
    
    if($is_responsive){
      if (null === $value || !is_array($value) || !isset($value[$device]) || $value[$device] === "") {
        return false;
      }
      $final_value = $value[$device];
    }else{
      if (null === $value || !isset($value) || $value === '') {
        return false;
      }
      $final_value = $value;
    }

    $unit = '';
		if (isset( $value['unit'][$device] ) && is_array($value['unit']) && ! empty( $value['unit'][$device]   )) {
			$unit=$value['unit'][$device];
		} elseif(isset( $value['unit'] ) && is_string($value['unit']) && ! empty( $value['unit'] )) {
			$unit=$value['unit'];
		}

    $this->add_property($property, $prefix . $final_value . $unit . $postfix);
  }

  public function pbg_render_color($attributes, $name, $property, $postfix = ''){
    if(empty($attributes) || !is_array($attributes) || empty($name) || empty($property)){
      return false;
    }

    $value = $this->find_nested_keys($attributes, $name);

    if ($value === null || $value === '') {
      return false;
    }

    $this->add_property($property, $value . $postfix);
  }

  public function pbg_render_background($attributes, $name, $device = '', $postfix = ''){
    if(empty($attributes) || !is_array($attributes) || empty($name)){
      return false;
    }

    $background = $this->find_nested_keys($attributes, $name);

    if (null === $background || !is_array($background) || empty($background) || empty($background['backgroundType'])) {
      return false;
    }

    $type = $background['backgroundType'] ?? '';

    if($type === 'transparent'){
      $this->add_property( 'background-color', "transparent" );
      return;
    }

    if($type === 'solid'){
      $color = $background['backgroundColor'] ?? '';

      if(!empty($color)){
        $this->add_property('background-color', $color . '!important');
      }

      $image_url = $background['backgroundImageURL'] ?? '';
      if (!empty($image_url)) {
        $this->add_property('background-image', 'url(' . $image_url . ')');
        
        // Add responsive properties if they exist
        $this->pbg_render_value($background, 'backgroundRepeat', 'background-repeat', $device);
        $this->pbg_render_value($background, 'backgroundPosition', 'background-position', $device);
        $this->pbg_render_value($background, 'backgroundSize', 'background-size', $device);
      }
      return;
    }

    if($type === 'gradient'){
      $first_color = $background['backgroundColor'] ?? 'rgba(255,255,255,0)'; // 
      $second_color = $background['gradientColorTwo'] ?? '#777'; // #777
      $location_one = $background['gradientLocationOne'] ?? ''; // 0
      $location_two = $background['gradientLocationTwo'] ?? ''; // 100

      if (isset($background['gradientType']) && !empty($background['gradientType'])){
        if ($background['gradientType'] === 'radial') {
          $position = $background['gradientPosition'] ?? 'center center';
          $gradient = sprintf(
            'radial-gradient(at %s, %s %s%%, %s %s%%)',
            $position,
            $first_color,
            $location_one,
            $second_color,
            $location_two
          );
        } else {
          $angle = $background['gradientAngle'] ?? 90;
          $gradient = sprintf(
            'linear-gradient(%sdeg, %s %s%%, %s %s%%)',
            $angle,
            $first_color,
            $location_one,
            $second_color,
            $location_two
          );
       }
      
       $this->add_property('background-image', $gradient);
      }
    }
  }

  public function pbg_render_typography( $attributes, $name, $device = '', $postfix = '') {
    if(empty($attributes) || !is_array($attributes) || empty($name)){
      return false;
    }

    $font = $this->find_nested_keys($attributes, $name);
    
		if ( empty( $font ) ) {
			return false;
		}
    
    $this->pbg_render_range($font, 'fontSize', 'font-size', $device , null, $postfix);
    $this->pbg_render_range($font, 'lineHeight', 'line-height', $device, null, $postfix);
    $this->pbg_render_range($font, 'letterSpacing', 'letter-spacing', $device, null, $postfix);
		
		if ( isset( $font['textDecoration'] ) && ! empty( $font['textDecoration'] ) ) {
			$this->add_property( 'text-decoration', $font['textDecoration'] . $postfix );
		}
		if ( isset( $font['textTransform'] ) && ! empty( $font['textTransform'] ) ) {
			$this->add_property( 'text-transform', $font['textTransform'] . $postfix );
		}
		if ( isset( $font['fontWeight'] ) && ! empty( $font['fontWeight'] ) && 'Default' !== $font['fontWeight'] ) {
			$this->add_property( 'font-weight', $font['fontWeight'] . $postfix );
		}
		if ( isset( $font['fontStyle'] ) && ! empty( $font['fontStyle'] ) ) {
			$this->add_property( 'font-style', $font['fontStyle'] . $postfix);
		}
		$family = ( isset( $font['fontFamily'] ) && ! empty( $font['fontFamily'] ) && 'Default' !== $font['fontFamily'] ? $font['fontFamily'] : '' );
		if ( ! empty( $family ) ) {
			$font_style  = ( $font['fontStyle'] ?? 'normal' ) === 'italic' ? 'i' : 'n';
			$font_weight = ( $font['fontWeight'] ?? '400' ) !== 'Default' ? intval( $font['fontWeight'] ) / 100 : '4';
			$this->add_gfont(
				array(
					'fontFamily'  => $family,
					'fontVariant' => $font_style . $font_weight,
				)
			);
			$this->add_property( 'font-family', $font['fontFamily'] . $postfix );

		}
	}

  public function pbg_render_shadow( $attributes, $name, $property, $postfix = '') {
    if(empty($attributes) || !is_array($attributes) || empty($name) || empty($property)){
      return false;
    }

    $shadow = $this->find_nested_keys($attributes, $name);
		
		if ( empty( $shadow ) ) {
			return false;
		}
		if ( $shadow["color"] === "transparent" ) {
			return false;
		}
		if ( ! isset( $shadow['horizontal'] ) ) {
			return false;
		}
		if ( ! isset( $shadow['vertical'] ) ) {
			return false;
		}
		if ( ! isset( $shadow['blur'] ) ) {
			return false;
		}
	
		if ( isset($shadow['position'] )  && $shadow['position'] === 'inset' ) {
			$shadow_string = 'inset ' . ( ! empty( $shadow['horizontal'] ) ? $shadow['horizontal'] : '0' ) . 'px ' . ( ! empty( $shadow['vertical'] ) ? $shadow['vertical'] : '0' ) . 'px ' . ( ! empty( $shadow['blur'] ) ? $shadow['blur'] : '0' ) . 'px ' . ( ! empty( $shadow['color'] ) ? $shadow['color'] : "#00000080" );
		} else {
			$shadow_string = ( ! empty( $shadow['horizontal'] ) ? $shadow['horizontal'] : '0' ) . 'px ' . ( ! empty( $shadow['vertical'] ) ? $shadow['vertical'] : '0' ) . 'px ' . ( ! empty( $shadow['blur'] ) ? $shadow['blur'] : '0' ) . 'px ' . ( ! empty( $shadow['color'] ) ? $shadow['color'] : "#00000080" );
		}

    $this->add_property($property, $shadow_string . $postfix);
	}

  public function pbg_render_filters( $attributes, $name, $postfix = '') {
    if(empty($attributes) || !is_array($attributes) || empty($name)){
      return false;
    }

    $filter = $this->find_nested_keys($attributes, $name);
		
		if ( empty( $filter ) ) {
			return false;
		}

    $default_filters = array(
      'contrast' => '100',
      'blur' => '0',
      'bright' => '100',
      'hue' => '0',
      'saturation' => '100');

    if ( $filter == $default_filters){
      return false;
    }
		
    if ( ! isset( $filter['bright']) || ! isset($filter['contrast']) || ! isset($filter['saturation']) || ! isset($filter['blur']) || ! isset($filter['hue'])){
      return false;
    }

    $filter_string = 'brightness(' . $filter['bright'] . '%)' . 'contrast(' . $filter['contrast'] . '%) ' . 'saturate(' . $filter['saturation'] . '%) ' . 'blur(' . $filter['blur'] . 'px) ' . 'hue-rotate(' . $filter['hue'] . 'deg)';

    $this->add_property('filter', $filter_string . $postfix);
	}

  public function pbg_render_normal_value($property, $value, $postfix = '') {
    if (empty($value) || empty($property)) {
      return false;
    }
    
    $this->add_property($property,  $value . $postfix);
  }
  /**
   * Finds the value of a nested key in an array of attributes.
   *
   * This function takes an array of attributes and a nested key name, and returns the value of the nested key if it exists.
   * The nested key name should be in dot notation, e.g. 'parent.child.grandchild'.
   *
   * @param array $attributes The array of attributes to search in.
   * @param string $name The name of the nested key in dot notation.
   * @return mixed|null The value of the nested key if found, or null if the key is not found.
   */
  public function find_nested_keys($attributes, $name){
    $keys = explode('.', $name);

    foreach ($keys as $key) {
        if (!isset($attributes[$key])) {
            return null; // Key not found
        }
        $attributes = $attributes[$key];
    }

    return $attributes;
  }
}
