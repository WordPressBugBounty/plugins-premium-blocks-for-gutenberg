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

  $opacity_value = $css->pbg_get_value( $attr, 'quoteStyles[0].quotOpacity' );
  $opacity_value =  $opacity_value / 100;
  
  $css->set_selector( $unique_id );
  $css->pbg_render_shadow( $attr, 'boxShadow', 'box-shadow' );
  $css->pbg_render_background( $attr, 'background', 'Desktop' );
  $css->pbg_render_value( $attr, 'align', 'text-align', 'Desktop' );
  $css->pbg_render_spacing( $attr, 'padding', 'padding', 'Desktop' );

  $css->set_selector( $unique_id . ' .premium-text-wrap');
  $css->pbg_render_value( $attr, 'align', 'text-align', 'Desktop' );

  $css->set_selector( $unique_id . ' .premium-icon-container' );
  $css->pbg_render_value( $attr, 'align', 'text-align', 'Desktop' );

  $css->set_selector( $unique_id . ' .premium-image-container' );
  $css->pbg_render_align_self( $attr, 'align', 'justify-content', 'Desktop' );

  $css->set_selector( $unique_id . ' .premium-testimonial__upper svg, ' . $unique_id . ' .premium-testimonial__lower svg' );
  $css->pbg_render_range( $attr, 'quotSize', 'width', 'Desktop' );
  $css->pbg_render_color( $attr, 'quoteStyles[0].quotColor', 'fill' );
  $css->add_property( 'opacity', $opacity_value );
  
  $css->set_selector( $unique_id . ' .premium-testimonial__container .premium-testimonial__upper' );
  $css->pbg_render_spacing( $attr, 'topPosition', 'top', 'Desktop', null, null, 'top');
  $css->pbg_render_spacing( $attr, 'topPosition', 'left', 'Desktop', null, null, 'left');

  $css->set_selector( $unique_id . ' .premium-testimonial__container .premium-testimonial__lower' );
  $css->pbg_render_spacing( $attr, 'bottomPosition', 'bottom', 'Desktop', null, null, 'bottom');
  $css->pbg_render_spacing( $attr, 'bottomPosition', 'right', 'Desktop', null, null, 'right');

	$css->start_media_query( 'tablet' );

	$css->set_selector( $unique_id );
  $css->pbg_render_background( $attr, 'background', 'Tablet' );
  $css->pbg_render_value( $attr, 'align', 'text-align', 'Tablet' );
  $css->pbg_render_spacing( $attr, 'padding', 'padding', 'Tablet' );

  $css->set_selector( $unique_id . ' .premium-text-wrap');
  $css->pbg_render_value( $attr, 'align', 'text-align', 'Tablet' );

  $css->set_selector( $unique_id . ' .premium-icon-container' );
  $css->pbg_render_value( $attr, 'align', 'text-align', 'Tablet' );

  $css->set_selector( $unique_id . ' .premium-image-container' );
  $css->pbg_render_align_self( $attr, 'align', 'justify-content', 'Tablet' );

  $css->set_selector( $unique_id . ' .premium-testimonial__upper svg, ' . $unique_id . ' .premium-testimonial__lower svg' );
  $css->pbg_render_range( $attr, 'quotSize', 'width', 'Tablet' );
  
  $css->set_selector( $unique_id . ' .premium-testimonial__container .premium-testimonial__upper' );
  $css->pbg_render_spacing( $attr, 'topPosition', 'top', 'Tablet', null, null, 'top');
  $css->pbg_render_spacing( $attr, 'topPosition', 'left', 'Tablet', null, null, 'left');

  $css->set_selector( $unique_id . ' .premium-testimonial__container .premium-testimonial__lower' );
  $css->pbg_render_spacing( $attr, 'bottomPosition', 'bottom', 'Tablet', null, null, 'bottom');
  $css->pbg_render_spacing( $attr, 'bottomPosition', 'right', 'Tablet', null, null, 'right');

	$css->stop_media_query();
	$css->start_media_query( 'mobile' );

	$css->set_selector( $unique_id );
  $css->pbg_render_background( $attr, 'background', 'Mobile' );
  $css->pbg_render_value( $attr, 'align', 'text-align', 'Mobile' );
  $css->pbg_render_spacing( $attr, 'padding', 'padding', 'Mobile' );

  $css->set_selector( $unique_id . ' .premium-text-wrap');
  $css->pbg_render_value( $attr, 'align', 'text-align', 'Mobile' );

  $css->set_selector( $unique_id . ' .premium-icon-container' );
  $css->pbg_render_value( $attr, 'align', 'text-align', 'Mobile' );

  $css->set_selector( $unique_id . ' .premium-image-container' );
  $css->pbg_render_align_self( $attr, 'align', 'justify-content', 'Mobile' );

  $css->set_selector( $unique_id . ' .premium-testimonial__upper svg, ' . $unique_id . ' .premium-testimonial__lower svg' );
  $css->pbg_render_range( $attr, 'quotSize', 'width', 'Mobile' );
  
  $css->set_selector( $unique_id . ' .premium-testimonial__container .premium-testimonial__upper' );
  $css->pbg_render_spacing( $attr, 'topPosition', 'top', 'Mobile', null, null, 'top');
  $css->pbg_render_spacing( $attr, 'topPosition', 'left', 'Mobile', null, null, 'left');

  $css->set_selector( $unique_id . ' .premium-testimonial__container .premium-testimonial__lower' );
  $css->pbg_render_spacing( $attr, 'bottomPosition', 'bottom', 'Mobile', null, null, 'bottom');
  $css->pbg_render_spacing( $attr, 'bottomPosition', 'right', 'Mobile', null, null, 'right');

	$css->stop_media_query();
	return $css->css_output();
}

/**
 * Renders the `premium/testimonial` block on server.
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
