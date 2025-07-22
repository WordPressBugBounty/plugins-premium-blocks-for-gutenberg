<?php
/**
 * Server-side rendering of the `pbg/dual-heading` block.
 *
 * @package WordPress
 */

/**
 * Get Dual Heading Block CSS
 *
 * Return Frontend CSS for Dual Heading.
 *
 * @access public
 *
 * @param string $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_dual_heading_css_style( $attr, $unique_id ) {
	$css = new Premium_Blocks_css();

  $css->set_selector( $unique_id );
  $css->pbg_render_value($attr, 'align', 'text-align', 'Desktop');
  $css->pbg_render_border($attr, 'containerBorder', 'Desktop');
  $css->pbg_render_background($attr, 'background', 'Desktop');
  $css->pbg_render_spacing($attr, 'padding', 'padding', 'Desktop');
  $css->pbg_render_range($attr, 'rotate', 'transform', null, 'rotate(', 'deg)');
  if(isset($attr['rotate']) && !empty($attr['rotate'])){
		$css->add_property( 'transform-origin', ($attr['transform_origin_x'] ?? '') . ' ' . ($attr['transform_origin_y'] ?? ''));
	}
  
  $css->set_selector( "body .entry-content {$unique_id}.premium-dheading-block__container" );
  $css->pbg_render_spacing($attr, 'margin', 'margin', 'Desktop');

	$css->set_selector( $unique_id . '.premium-mask-yes .premium-dheading-block__title span::after' );
  $css->pbg_render_color($attr, 'mask_color', 'background-color');
	
  $css->set_selector( $unique_id . ' .premium-mask-span' );
  $css->pbg_render_spacing($attr, 'mask_padding', 'padding', 'Desktop');

	// First Style FontSize.
  $css->set_selector( $unique_id . '> .premium-dheading-block__wrap' . ' > .premium-dheading-block__title' . ' > .premium-dheading-block__first' );
  $css->pbg_render_typography( $attr, 'firstTypography', 'Desktop');
  $css->pbg_render_border($attr, 'firstBorder', 'Desktop');
  $css->pbg_render_background($attr, 'firstBackgroundOptions', 'Desktop');
  $css->pbg_render_spacing($attr, 'firstPadding', 'padding', 'Desktop');
  $css->pbg_render_spacing($attr, 'firstMargin', 'margin', 'Desktop');

  $css->set_selector( $unique_id . ' .premium-dheading-block__title .premium-headingc-true.premium-headings-true.premium-dheading-block__first' );
  $css->pbg_render_color($attr, 'firstStrokeColor', '-webkit-text-stroke-color');
  $css->pbg_render_color($attr, 'firstStrokeFill', '-webkit-text-fill-color');

	// Second Style FontSize.
  $css->set_selector( $unique_id . '> .premium-dheading-block__wrap' . ' > .premium-dheading-block__title' . ' > .premium-dheading-block__second' );
  $css->pbg_render_typography($attr, 'secondTypography', 'Desktop');
  $css->pbg_render_border($attr, 'secondBorder', 'Desktop');
  $css->pbg_render_background($attr, 'secondBackgroundOptions', 'Desktop');
  $css->pbg_render_spacing($attr, 'secondPadding', 'padding', 'Desktop');
  $css->pbg_render_spacing($attr, 'secondMargin', 'margin', 'Desktop');

  $css->set_selector( $unique_id . ' .premium-dheading-block__title .premium-headingc-true.premium-headings-true.premium-dheading-block__second' );
  $css->pbg_render_color($attr, 'secondStrokeColor', '-webkit-text-stroke-color');
  $css->pbg_render_color($attr, 'secondStrokeFill', '-webkit-text-fill-color');

	$css->start_media_query( 'tablet' );

	$css->set_selector( $unique_id );
  $css->pbg_render_value($attr, 'align', 'text-align', 'Tablet');
  $css->pbg_render_border($attr, 'containerBorder', 'Tablet');
  $css->pbg_render_background($attr, 'background', 'Tablet');
  $css->pbg_render_spacing($attr, 'padding', 'padding', 'Tablet');
  
  $css->set_selector( "body .entry-content {$unique_id}.premium-dheading-block__container" );
  $css->pbg_render_spacing($attr, 'margin', 'margin', 'Tablet');

	$css->set_selector( $unique_id . ' .premium-mask-span' );
  $css->pbg_render_spacing($attr, 'mask_padding', 'padding', 'Tablet');

	// First Style FontSize.
  $css->set_selector( $unique_id . '> .premium-dheading-block__wrap' . ' > .premium-dheading-block__title' . ' > .premium-dheading-block__first' );
  $css->pbg_render_typography( $attr, 'firstTypography', 'Tablet');
  $css->pbg_render_border($attr, 'firstBorder', 'Tablet');
  $css->pbg_render_background($attr, 'firstBackgroundOptions', 'Tablet');
  $css->pbg_render_spacing($attr, 'firstPadding', 'padding', 'Tablet');
  $css->pbg_render_spacing($attr, 'firstMargin', 'margin', 'Tablet');

	// Second Style FontSizeTablet.
	$css->set_selector( $unique_id . '> .premium-dheading-block__wrap' . ' > .premium-dheading-block__title' . ' > .premium-dheading-block__second' );
  $css->pbg_render_typography($attr, 'secondTypography', 'Tablet');
  $css->pbg_render_border($attr, 'secondBorder', 'Tablet');
  $css->pbg_render_background($attr, 'secondBackgroundOptions', 'Tablet');
  $css->pbg_render_spacing($attr, 'secondPadding', 'padding', 'Tablet');
  $css->pbg_render_spacing($attr, 'secondMargin', 'margin', 'Tablet');

	$css->stop_media_query();
	$css->start_media_query( 'mobile' );

	$css->set_selector( $unique_id );
  $css->pbg_render_value($attr, 'align', 'text-align', 'Mobile');
  $css->pbg_render_border($attr, 'containerBorder', 'Mobile');
  $css->pbg_render_background($attr, 'background', 'Mobile');
  $css->pbg_render_spacing($attr, 'padding', 'padding', 'Mobile');
  
  $css->set_selector( "body .entry-content {$unique_id}.premium-dheading-block__container" );
  $css->pbg_render_spacing($attr, 'margin', 'margin', 'Mobile');
	
  $css->set_selector( $unique_id . ' .premium-mask-span' );
  $css->pbg_render_spacing($attr, 'mask_padding', 'padding', 'Mobile');

	// First Style FontSize.
  $css->set_selector( $unique_id . '> .premium-dheading-block__wrap' . ' > .premium-dheading-block__title' . ' > .premium-dheading-block__first' );
  $css->pbg_render_typography( $attr, 'firstTypography', 'Mobile');
  $css->pbg_render_border($attr, 'firstBorder', 'Mobile');
  $css->pbg_render_background($attr, 'firstBackgroundOptions', 'Mobile');
  $css->pbg_render_spacing($attr, 'firstPadding', 'padding', 'Mobile');
  $css->pbg_render_spacing($attr, 'firstMargin', 'margin', 'Mobile');

	// Second Style FontSizeMobil.
	$css->set_selector( $unique_id . '> .premium-dheading-block__wrap' . ' > .premium-dheading-block__title' . ' > .premium-dheading-block__second' );
  $css->pbg_render_typography($attr, 'secondTypography', 'Mobile');
  $css->pbg_render_border($attr, 'secondBorder', 'Mobile');
  $css->pbg_render_background($attr, 'secondBackgroundOptions', 'Mobile');
  $css->pbg_render_spacing($attr, 'secondPadding', 'padding', 'Mobile');
  $css->pbg_render_spacing($attr, 'secondMargin', 'margin', 'Mobile');

	$css->stop_media_query();
	return $css->css_output();
}

/**
 * Renders the `premium/dual-heading` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_dual_heading( $attributes, $content, $block ) {
    $block_helpers = pbg_blocks_helper();

    // Enqueue required styles and scripts.
    if ( $block_helpers->it_is_not_amp() ) {
        // Load Waypoints library
        wp_enqueue_script(
            'pbg-waypoints-heading',
            PREMIUM_BLOCKS_URL . 'assets/js/lib/jquery.waypoints.js',
            array( 'jquery' ),
            PREMIUM_BLOCKS_VERSION,
            true
        );
        
        // Load custom JavaScript without jQuery as a dependency
        wp_enqueue_script(
            'pbg-dual-heading',
            PREMIUM_BLOCKS_URL . 'assets/js/minified/dual-heading.min.js',
            array( 'pbg-waypoints-heading' ), // Remove 'jquery' from here
            PREMIUM_BLOCKS_VERSION,
            true
        );
    }

    return $content;
}





/**
 * Register the dual_heading block.
 *
 * @uses render_block_pbg_dual_heading()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_dual_heading() {
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	register_block_type(
		PREMIUM_BLOCKS_PATH . '/blocks-config/dual-heading',
		array(
			'render_callback' => 'render_block_pbg_dual_heading',
		)
	);
}

register_block_pbg_dual_heading();
