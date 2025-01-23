<?php
/**
 * Server-side rendering of the `pbg/lottie` block.
 *
 * @package WordPress
 */

/**
 * Get Lottie Block CSS
 *
 * Return Frontend CSS for Lottie.
 *
 * @access public
 *
 * @param string $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_lottie_css_style( $attr, $unique_id ) {
	$css = new Premium_Blocks_css();

	if ( isset( $attr['lottieAlign'] ) ) {
        $content_align      = $css->get_responsive_css( $attr['lottieAlign'], 'Desktop' );
		$content_flex_align = 'left' === $content_align ? 'flex-start' : 'center';
		$content_flex_align = 'right' === $content_align ? 'flex-end' : $content_flex_align;
		$css->set_selector( $unique_id );
		$css->add_property( 'text-align',$content_align );
        $css->add_property( 'align-self', $css->render_align_self($content_align) );
	}

	if ( isset( $attr['size'] ) ) {
		$css->set_selector( $unique_id . '> .premium-lottie-svg svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['size'], 'Desktop' ) ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['size'], 'Desktop' ) ));
		$css->set_selector( '#premium-lottie-' . $unique_id . '> .premium-lottie-canvas' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['size'], 'Desktop' ) ));
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['size'], 'Desktop' ) ));
	}

	if ( isset( $attr['padding'] ) ) {
		$css->set_selector( $unique_id . ' .premium-lottie-animation' );
		$css->add_property( 'padding', $css->render_spacing( $attr['padding']['Desktop'], isset( $attr['padding']['unit']['Desktop'])?$attr['padding']['unit']['Desktop']:$attr['padding']['unit'] ) );
	}
	if ( isset( $attr['margin'] ) ) {
		$css->set_selector( $unique_id . ' .premium-lottie-animation' );
		$css->add_property( 'margin', $css->render_spacing( $attr['margin']['Desktop'], isset( $attr['margin']['unit']['Desktop'])?$attr['margin']['unit']['Desktop']:$attr['margin']['unit'] ) );
	}

	if ( isset( $attr['border'] ) ) {
		$lottie_border        = $attr['border'];
		$lottie_border_width  = $lottie_border['borderWidth'];
		$lottie_border_radius = $lottie_border['borderRadius'];
		$lottie_border_style  = $lottie_border['borderType'];
		$lottie_border_color  = $lottie_border['borderColor'];
		$css->set_selector( $unique_id . ' .premium-lottie-animation' );
		$css->add_property( 'border-style', $lottie_border_style );
		$css->add_property( 'border-color', $css->render_color( $lottie_border_color ) );
		$css->add_property( 'border-width', $css->render_spacing( $lottie_border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $lottie_border_radius['Desktop'], 'px' ) );
	}
	if ( isset( $attr['lottieStyles'] ) ) {
		$css->set_selector( $unique_id . ' .premium-lottie-animation' );
		$css->add_property( 'background-color', $css->render_color( $attr['lottieStyles'][0]['backColor'] ) );
	}
	if ( isset( $attr['rotate'] ) ) {
		$css->set_selector( $unique_id . ' .premium-lottie-animation' );
		$css->add_property( 'transform', 'rotate(' . $attr['rotate'] . 'deg) !important' );
	}

	if ( isset( $attr['filter'] ) ) {
		$css->set_selector( $unique_id . ' .premium-lottie-animation' );
		$css->add_property(
			'filter',
			'brightness(' . $attr['filter']['bright'] . '%)' . 'contrast(' . $attr['filter']['contrast'] . '%) ' . 'saturate(' . $attr['filter']['saturation'] . '%) ' . 'blur(' . $attr['filter']['blur'] . 'px) ' . 'hue-rotate(' . $attr['filter']['hue'] . 'deg)'
		);
	}
	if ( isset( $attr['filterHover'] ) ) {
		$css->set_selector( $unique_id . ' .premium-lottie-animation:hover' );
		$css->add_property(
			'filter',
			'brightness(' . $attr['filterHover']['bright'] . '%)' . 'contrast(' . $attr['filterHover']['contrast'] . '%) ' . 'saturate(' . $attr['filterHover']['saturation'] . '%) ' . 'blur(' . $attr['filterHover']['blur'] . 'px) ' . 'hue-rotate(' . $attr['filterHover']['hue'] . 'deg)'
		);
	}
	if ( isset( $attr['lottieStyles'] ) ) {
		$css->set_selector( $unique_id . ' .premium-lottie-animation:hover' );
		$css->add_property( 'background-color', $css->render_color( $attr['lottieStyles'][0]['backHColor'] ) );
	}
	$css->start_media_query( 'tablet' );
	if ( isset( $attr['lottieAlign'] ) ) {
        $content_align      = $css->get_responsive_css( $attr['lottieAlign'], 'Tablet' );
		$content_flex_align = 'left' === $content_align ? 'flex-start' : 'center';
		$content_flex_align = 'right' === $content_align ? 'flex-end' : $content_flex_align;
		$css->set_selector( $unique_id );
		$css->add_property( 'text-align',$content_align );
        $css->add_property( 'align-self', $css->render_align_self($content_align) );
	}

	if ( isset( $attr['size'] ) ) {
		 $css->set_selector( $unique_id . '> .premium-lottie-svg svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['size'], 'Tablet' ) ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['size'], 'Tablet' ) ));
		$css->set_selector( '#premium-lottie-' . $unique_id . '> .premium-lottie-canvas' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['size'], 'Tablet' ) ));
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['size'], 'Tablet' ) ));
	}

	if ( isset( $attr['padding'] ) ) {
		$css->set_selector( $unique_id . ' .premium-lottie-animation' );
		$css->add_property( 'padding', $css->render_spacing( $attr['padding']['Tablet'], isset( $attr['padding']['unit']['Tablet'])?$attr['padding']['unit']['Tablet']:$attr['padding']['unit'] ) );
	}

	if ( isset( $attr['margin'] ) ) {
		$css->set_selector( $unique_id . ' .premium-lottie-animation' );
		$css->add_property( 'margin', $css->render_spacing( $attr['margin']['Tablet'], isset( $attr['margin']['unit']['Tablet'])?$attr['margin']['unit']['Tablet']:$attr['margin']['unit'] ) );
	}

	if ( isset( $attr['border'] ) ) {
		$lottie_border        = $attr['border'];
		$lottie_border_width  = $lottie_border['borderWidth'];
		$lottie_border_radius = $lottie_border['borderRadius'];
		$css->set_selector( $unique_id . ' .premium-lottie-animation' );
		$css->add_property( 'border-width', $css->render_spacing( $lottie_border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $lottie_border_radius['Tablet'], 'px' ) );
	}
	$css->stop_media_query();
	$css->start_media_query( 'mobile' );
	if ( isset( $attr['lottieAlign'] ) ) {
        $content_align      = $css->get_responsive_css( $attr['lottieAlign'], 'Mobile' );
		$content_flex_align = 'left' === $content_align ? 'flex-start' : 'center';
		$content_flex_align = 'right' === $content_align ? 'flex-end' : $content_flex_align;
		$css->set_selector( $unique_id );
		$css->add_property( 'text-align',$content_align );
        $css->add_property( 'align-self', $css->render_align_self($content_align) );
	}

	if ( isset( $attr['size'] ) ) {
		$css->set_selector( $unique_id . '> .premium-lottie-svg svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['size'], 'Mobile' ) ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['size'], 'Mobile' ) ));
		$css->set_selector( '#premium-lottie-' . $unique_id . '> .premium-lottie-canvas' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['size'], 'Mobile' ) ));
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['size'], 'Mobile' ) ));
	}

	if ( isset( $attr['padding'] ) ) {
		$css->set_selector( $unique_id . ' .premium-lottie-animation' );
		$css->add_property( 'padding', $css->render_spacing( $attr['padding']['Mobile'], isset( $attr['padding']['unit']['Mobile'] )?$attr['padding']['unit']['Mobile']:$attr['padding']['unit']) );
	}

	if ( isset( $attr['margin'] ) ) {
		$css->set_selector( $unique_id . ' .premium-lottie-animation' );
		$css->add_property( 'margin', $css->render_spacing( $attr['margin']['Mobile'], isset( $attr['margin']['unit']['Mobile'] )?$attr['margin']['unit']['Mobile']:$attr['margin']['unit']) );
	}


	if ( isset( $attr['border'] ) ) {
		$lottie_border        = $attr['border'];
		$lottie_border_width  = $lottie_border['borderWidth'];
		$lottie_border_radius = $lottie_border['borderRadius'];
		$css->set_selector( $unique_id . ' .premium-lottie-animation' );
		$css->add_property( 'border-width', $css->render_spacing( $lottie_border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $lottie_border_radius['Mobile'], 'px' ) );
	}
	$css->stop_media_query();
	return $css->css_output();
}

/**
 * Renders the `premium/lottie` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_lottie( $attributes, $content, $block ) {
	$block_helpers = pbg_blocks_helper();

	// Enqueue frontend JavaScript and CSS.
	if ( $block_helpers->it_is_not_amp() ) {
		wp_enqueue_script(
			'pbg-lottie',
			PREMIUM_BLOCKS_URL . 'assets/js/lib/lottie.min.js',
			array( 'jquery' ),
			PREMIUM_BLOCKS_VERSION,
			true
		);
	}

	return $content;
}




/**
 * Register the lottie block.
 *
 * @uses render_block_pbg_lottie()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_lottie() {
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	register_block_type(
		PREMIUM_BLOCKS_PATH . '/blocks-config/lottie',
		array(
			'render_callback' => 'render_block_pbg_lottie',
		)
	);
}

register_block_pbg_lottie();
