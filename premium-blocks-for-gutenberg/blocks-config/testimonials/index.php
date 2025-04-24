<?php
/**
 * Server-side rendering of the `pbg/testimonials` block.
 *
 * @package WordPress
 */

/**
 * Get Testimonials Block CSS
 *
 * Return Frontend CSS for Testimonials.
 *
 * @access public
 *
 * @param string $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_testimonials_css_style( $attr, $unique_id ) {
	$css = new Premium_Blocks_css();

	// Container Style
	if ( isset( $attr['padding'] ) ) {
		$padding = $attr['padding'];
		$css->set_selector( $unique_id );
		$css->add_property( 'padding', $css->render_spacing( $padding['Desktop'], isset( $padding['unit']['Desktop'] ) ? $padding['unit']['Desktop'] : $padding['unit'] ) );
	}

	if ( isset( $attr['background'] ) ) {
		$css->set_selector( $unique_id );
		$css->render_background( $attr['background'], 'Desktop' );

	}

	if ( isset( $attr['align'] ) ) {
		$css->set_selector( $unique_id );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['align'], 'Desktop' ) );

		$css->set_selector( $unique_id . ' .premium-image-container' );
		$css->add_property( 'justify-content', $css->get_responsive_css( $attr['align'], 'Desktop' ) );
	}

	if ( isset( $attr['quotSize'] ) ) {
		$css->set_selector( $unique_id . ' .premium-testimonial__container svg' );
		$css->add_property( 'width', $css->render_range( $attr['quotSize'], 'Desktop' ) );
	}

	if ( isset( $attr['topPosition'] ) ) {
		$top_position = $attr['topPosition'];
		$css->set_selector( $unique_id . ' .premium-testimonial__container .premium-testimonial__upper' );
		$css->add_property( 'top', $css->render_string( $top_position['Desktop']['top'], isset( $top_position['unit']['Desktop'] ) ? $top_position['unit']['Desktop'] : $top_position['unit'] ) );
		$css->add_property( 'left', $css->render_string( $top_position['Desktop']['left'], isset( $top_position['unit']['Desktop'] ) ? $top_position['unit']['Desktop'] : $top_position['unit'] ) );
	}

	if ( isset( $attr['bottomPosition'] ) ) {
		$bottom_position = $attr['bottomPosition'];
		$css->set_selector( $unique_id . ' .premium-testimonial__container .premium-testimonial__lower' );
		$css->add_property( 'right', $css->render_string( $bottom_position['Desktop']['right'], isset( $bottom_position['unit']['Desktop'] ) ? $bottom_position['unit']['Desktop'] : $bottom_position['unit'] ) );
		$css->add_property( 'bottom', $css->render_string( $bottom_position['Desktop']['bottom'], isset( $bottom_position['unit']['Desktop'] ) ? $bottom_position['unit']['Desktop'] : $bottom_position['unit'] ) );
	}

	$css->start_media_query( 'tablet' );

	// Container Style
	if ( isset( $attr['padding'] ) ) {
		$padding = $attr['padding'];
		$css->set_selector( $unique_id );
		$css->add_property( 'padding', $css->render_spacing( $padding['Tablet'], isset( $padding['unit']['Tablet'] ) ? $padding['unit']['Tablet'] : $padding['unit'] ) );
	}
	if ( isset( $attr['background'] ) ) {
		$css->set_selector( $unique_id );
		$css->render_background( $attr['background'], 'Tablet' );
	}
	if ( isset( $attr['align'] ) ) {
		$css->set_selector( $unique_id );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['align'], 'Tablet' ) );

		$css->set_selector( $unique_id . ' .premium-image-container' );
		$css->add_property( 'justify-content', $css->get_responsive_css( $attr['align'], 'Tablet' ) );
	}

	if ( isset( $attr['quotSize'] ) ) {
		$css->set_selector( $unique_id . ' .premium-testimonial__container svg' );
		$css->add_property( 'width', $css->render_range( $attr['quotSize'], 'Tablet' ) );
	}
	if ( isset( $attr['topPosition'] ) ) {
		$top_position = $attr['topPosition'];
		$css->set_selector( $unique_id . ' .premium-testimonial__container .premium-testimonial__upper' );
		$css->add_property( 'top', $css->render_string( $top_position['Tablet']['top'], isset( $top_position['unit']['Tablet'] ) ? $top_position['unit']['Tablet'] : $top_position['unit'] ) );
		$css->add_property( 'left', $css->render_string( $top_position['Tablet']['left'], isset( $top_position['unit']['Tablet'] ) ? $top_position['unit']['Tablet'] : $top_position['unit'] ) );
	}
	if ( isset( $attr['bottomPosition'] ) ) {
		$bottom_position = $attr['bottomPosition'];
		$css->set_selector( $unique_id . ' .premium-testimonial__container .premium-testimonial__lower' );
		$css->add_property( 'right', $css->render_string( $bottom_position['Tablet']['right'], isset( $bottom_position['unit']['Tablet'] ) ? $bottom_position['unit']['Tablet'] : $bottom_position['unit'] ) );
		$css->add_property( 'bottom', $css->render_string( $bottom_position['Tablet']['bottom'], isset( $bottom_position['unit']['Tablet'] ) ? $bottom_position['unit']['Tablet'] : $bottom_position['unit'] ) );
	}

	$css->stop_media_query();
	$css->start_media_query( 'mobile' );

	// Container Style
	if ( isset( $attr['padding'] ) ) {
		$padding = $attr['padding'];
		$css->set_selector( $unique_id );
		$css->add_property( 'padding', $css->render_spacing( $padding['Mobile'], isset( $padding['unit']['Mobile'] ) ? $padding['unit']['Mobile'] : $padding['unit'] ) );
	}
	if ( isset( $attr['background'] ) ) {
		$css->set_selector( $unique_id );
		$css->render_background( $attr['background'], 'Mobile' );
	}
	if ( isset( $attr['align'] ) ) {
		$css->set_selector( $unique_id );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['align'], 'Mobile' ) );

		$css->set_selector( $unique_id . ' .premium-image-container' );
		$css->add_property( 'justify-content', $css->get_responsive_css( $attr['align'], 'Mobile' ) );
	}

	if ( isset( $attr['quotSize'] ) ) {
		$css->set_selector( $unique_id . ' .premium-testimonial__container svg' );
		$css->add_property( 'width', $css->render_range( $attr['quotSize'], 'Mobile' ) );
	}
	if ( isset( $attr['topPosition'] ) ) {
		$top_position = $attr['topPosition'];
		$css->set_selector( $unique_id . ' .premium-testimonial__container .premium-testimonial__upper' );
		$css->add_property( 'top', $css->render_string( $top_position['Mobile']['top'], isset( $top_position['unit']['Mobile'] ) ? $top_position['unit']['Mobile'] : $top_position['unit'] ) );
		$css->add_property( 'left', $css->render_string( $top_position['Mobile']['left'], isset( $top_position['unit']['Mobile'] ) ? $top_position['unit']['Mobile'] : $top_position['unit'] ) );
	}
	if ( isset( $attr['bottomPosition'] ) ) {
		$bottom_position = $attr['bottomPosition'];
		$css->set_selector( $unique_id . ' .premium-testimonial__container .premium-testimonial__lower' );
		$css->add_property( 'right', $css->render_string( $bottom_position['Mobile']['right'], isset( $bottom_position['unit']['Mobile'] ) ? $bottom_position['unit']['Mobile'] : $bottom_position['unit'] ) );
		$css->add_property( 'bottom', $css->render_string( $bottom_position['Mobile']['bottom'], isset( $bottom_position['unit']['Mobile'] ) ? $bottom_position['unit']['Mobile'] : $bottom_position['unit'] ) );
	}

	$css->stop_media_query();
	return $css->css_output();
}

/**
 * Renders the `premium/testimonials` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_testimonials( $attributes, $content, $block ) {

	return $content;
}




/**
 * Register the testimonials block.
 *
 * @uses render_block_pbg_testimonials()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_testimonials() {
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	register_block_type(
		PREMIUM_BLOCKS_PATH . '/blocks-config/testimonials',
		array(
			'render_callback' => 'render_block_pbg_testimonials',
		)
	);
}

register_block_pbg_testimonials();
