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

	if ( isset( $attr['align'] ) ) {
        $content_align      = $css->get_responsive_css( $attr['align'], 'Desktop' );
		$content_flex_align = 'left' === $content_align ? 'flex-start' : 'center';
		$content_flex_align = 'right' === $content_align ? 'flex-end' : $content_flex_align;
		$css->set_selector( $unique_id );
		$css->add_property( 'text-align', $content_align );
        $css->add_property( 'align-self',  $css->render_align_self($content_align) );

	}
	if ( isset( $attr['containerBorder'] ) ) {
		$container_border        = $attr['containerBorder'];
		$container_border_width  = $container_border['borderWidth'];
		$container_border_radius = $container_border['borderRadius'];

		$css->set_selector( $unique_id );
		$css->add_property( 'border-width', $css->render_spacing( $container_border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $container_border_radius['Desktop'], 'px' ) );
	}
	if ( isset( $attr['background'] ) ) {
		$css->set_selector( $unique_id );
		$css->render_background( $attr['background'], 'Desktop' );

	}

	if ( isset( $attr['padding'] ) ) {
		$padding = $attr['padding'];
		$css->set_selector( $unique_id );
		$css->add_property( 'padding', $css->render_spacing( $padding['Desktop'], isset( $padding['unit']['Desktop'])?$padding['unit']['Desktop']:$padding['unit'] ) );
	}

	if ( isset( $attr['margin'] ) ) {
		$margin = $attr['margin'];
		$css->set_selector( $unique_id );
		$css->add_property( 'margin', $css->render_spacing( $margin['Desktop'], isset( $margin['unit']['Desktop'] )?$margin['unit']['Desktop'] :$margin['unit']) );
	}
	if(isset($attr['rotate'])){
		$css->set_selector( $unique_id );
		$css->add_property( 'transform', 'rotate(' .$attr['rotate']. 'deg)'  );

	}
	if(isset($attr['transform_origin_x']) &&isset($attr['transform_origin_x'])){
		$css->set_selector( $unique_id );
		$css->add_property( 'transform-origin', $attr['transform_origin_x'] . ' ' . $attr['transform_origin_y']  );

	}
	if(isset($attr['mask_color'])){
		$css->set_selector( $unique_id . '.premium-mask-yes .premium-dheading-block__title span::after' );
		$css->add_property( 'background', $css->render_color($attr['mask_color'])  );
	}
	if(isset($attr['mask_padding'])){
		$padding = $attr['mask_padding'];

		$css->set_selector( $unique_id . ' .premium-mask-span' );
		$css->add_property( 'padding', $css->render_spacing( $padding['Desktop'], $padding['unit']['Desktop'] ));
	}

	// First Style FontSize.

	if ( isset( $attr['firstTypography'] ) ) {
		$css->set_selector( $unique_id . '> .premium-dheading-block__wrap' . ' > .premium-dheading-block__title' . ' > .premium-dheading-block__first' );
		$css->render_typography( $attr['firstTypography'], 'Desktop' );
	}

	if ( isset( $attr['firstBorder'] ) ) {
		$first_border        = $attr['firstBorder'];
		$first_border_width  = $first_border['borderWidth'];
		$first_border_radius = $first_border['borderRadius'];

		$css->set_selector( $unique_id . '> .premium-dheading-block__wrap' . ' > .premium-dheading-block__title' . ' > .premium-dheading-block__first' );
		$css->add_property( 'border-width', $css->render_spacing( $first_border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $first_border_radius['Desktop'], 'px' ) );
	}

	if ( isset( $attr['firstPadding'] ) ) {
		$first_padding = $attr['firstPadding'];
		$css->set_selector( $unique_id . '> .premium-dheading-block__wrap' . ' > .premium-dheading-block__title' . ' > .premium-dheading-block__first' );
		$css->add_property( 'padding', $css->render_spacing( $first_padding['Desktop'], isset( $first_padding['unit']['Desktop'])?$first_padding['unit']['Desktop']:$first_padding['unit'] ) );
	}
    if(isset($attr['firstBackgroundOptions']) ){
        $css->set_selector( $unique_id . '> .premium-dheading-block__wrap' . ' > .premium-dheading-block__title' . ' > .premium-dheading-block__first' );
        $css->render_background( $attr['firstBackgroundOptions'], 'Desktop' );
    }
	if ( isset( $attr['firstMargin'] ) ) {
		$first_margin = $attr['firstMargin'];
		$css->set_selector( $unique_id . '> .premium-dheading-block__wrap' . ' > .premium-dheading-block__title' . ' > .premium-dheading-block__first' );
		$css->add_property( 'margin', $css->render_spacing( $first_margin['Desktop'], isset( $first_margin['unit']['Desktop'] )?$first_margin['unit']['Desktop'] :$first_margin['unit']) );
	}
	if ( isset( $attr['firstStrokeColor'] ) ) {
		$css->set_selector( $unique_id . ' .premium-dheading-block__title .premium-headingc-true.premium-headings-true.premium-dheading-block__first' );
		$css->add_property( '-webkit-text-stroke-color', $css->render_color( $attr['firstStrokeColor']) );
	}
	if ( isset( $attr['firstStrokeFill'] ) ) {
		$css->set_selector( $unique_id . ' .premium-dheading-block__title .premium-headingc-true.premium-headings-true.premium-dheading-block__first' );
		$css->add_property( '-webkit-text-fill-color', $css->render_color($attr['firstStrokeFill']) );
	}

	// Second Style FontSize.

	if ( isset( $attr['secondTypography'] ) ) {
		$css->set_selector( $unique_id . '> .premium-dheading-block__wrap' . ' > .premium-dheading-block__title' . ' > .premium-dheading-block__second' );
		$css->render_typography( $attr['secondTypography'], 'Desktop' );
	}

	if ( isset( $attr['secondBorder'] ) ) {
		$second_border        = $attr['secondBorder'];
		$second_border_width  = $second_border['borderWidth'];
		$second_border_radius = $second_border['borderRadius'];

		$css->set_selector( $unique_id . '> .premium-dheading-block__wrap' . ' > .premium-dheading-block__title' . ' > .premium-dheading-block__second' );
		$css->add_property( 'border-width', $css->render_spacing( $second_border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $second_border_radius['Desktop'], 'px' ) );
	}
    if(isset($attr['secondBackgroundOptions']) ){
        $css->set_selector( $unique_id . '> .premium-dheading-block__wrap' . ' > .premium-dheading-block__title' . ' > .premium-dheading-block__second' );
        $css->render_background( $attr['secondBackgroundOptions'], 'Desktop' );
    }

	if ( isset( $attr['secondPadding'] ) ) {
		$second_padding = $attr['secondPadding'];
		$css->set_selector( $unique_id . '> .premium-dheading-block__wrap' . ' > .premium-dheading-block__title' . ' > .premium-dheading-block__second' );
		$css->add_property( 'padding', $css->render_spacing( $second_padding['Desktop'], isset( $second_padding['unit']['Desktop'])?$second_padding['unit']['Desktop']:$second_padding['unit'] ) );
	}
  
	if ( isset( $attr['secondMargin'] ) ) {
		$second_margin = $attr['secondMargin'];
		$css->set_selector( $unique_id . '> .premium-dheading-block__wrap' . ' > .premium-dheading-block__title' . ' > .premium-dheading-block__second' );
		$css->add_property( 'margin', $css->render_spacing( $second_margin['Desktop'], isset( $second_margin['unit']['Desktop'])?$second_margin['unit']['Desktop']:$second_margin['unit'] ) );
	}

	if ( isset( $attr['secondStrokeColor'] ) ) {
		$css->set_selector( $unique_id . ' .premium-dheading-block__title .premium-headingc-true.premium-headings-true.premium-dheading-block__second' );
		$css->add_property( '-webkit-text-stroke-color', $css->render_color( $attr['secondStrokeColor']) );
	}
	if ( isset( $attr['secondStrokeFill'] ) ) {
		$css->set_selector( $unique_id . ' .premium-dheading-block__title .premium-headingc-true.premium-headings-true.premium-dheading-block__second' );
		$css->add_property( '-webkit-text-fill-color', $css->render_color($attr['secondStrokeFill']) );
	}

	$css->start_media_query( 'tablet' );

	if ( isset( $attr['align'] ) ) {
        $content_align      = $css->get_responsive_css( $attr['align'], 'Tablet' );
		$content_flex_align = 'left' === $content_align ? 'flex-start' : 'center';
		$content_flex_align = 'right' === $content_align ? 'flex-end' : $content_flex_align;
		$css->set_selector( $unique_id );
		$css->add_property( 'text-align', $content_align );
        $css->add_property( 'align-self',  $css->render_align_self($content_align) );
	
	}

	if ( isset( $attr['containerBorder'] ) ) {
		$container_border        = $attr['containerBorder'];
		$container_border_width  = $container_border['borderWidth'];
		$container_border_radius = $container_border['borderRadius'];

		$css->set_selector( $unique_id );
		$css->add_property( 'border-width', $css->render_spacing( $container_border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $container_border_radius['Tablet'], 'px' ) );
	}

	if ( isset( $attr['background'] ) ) {
		$css->set_selector( $unique_id );
		$css->render_background( $attr['background'], 'Tablet' );

	}
	if ( isset( $attr['padding'] ) ) {
		$padding = $attr['padding'];
		$css->set_selector( $unique_id );
		$css->add_property( 'padding', $css->render_spacing( $padding['Tablet'], isset( $padding['unit']['Tablet'])?$padding['unit']['Tablet']:$padding['unit'] ) );
	}

	if ( isset( $attr['margin'] ) ) {
		$margin = $attr['margin'];
		$css->set_selector( $unique_id );
		$css->add_property( 'margin', $css->render_spacing( $margin['Tablet'], isset( $margin['unit']['Tablet'] )?$margin['unit']['Tablet'] :$margin['unit']) );
	}
	if(isset($attr['mask_padding'])){
		$padding = $attr['mask_padding'];

		$css->set_selector( $unique_id . '.premium-mask-span' );
		$css->add_property( 'padding', $css->render_spacing( $padding['Tablet'], $padding['unit']['Tablet'] ));
	}
	// First Style FontSize.

	if ( isset( $attr['firstTypography'] ) ) {
		$first_typography = $attr['firstTypography'];
		$css->set_selector( $unique_id . '> .premium-dheading-block__wrap' . ' > .premium-dheading-block__title' . ' > .premium-dheading-block__first' );
		$css->render_typography( $first_typography, 'Tablet' );
	}

	if ( isset( $attr['firstBorder'] ) ) {
		$first_border        = $attr['firstBorder'];
		$first_border_width  = $first_border['borderWidth'];
		$first_border_radius = $first_border['borderRadius'];

		$css->set_selector( $unique_id . '> .premium-dheading-block__wrap' . ' > .premium-dheading-block__title' . ' > .premium-dheading-block__first' );
		$css->add_property( 'border-width', $css->render_spacing( $first_border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $first_border_radius['Tablet'], 'px' ) );
	}

	if ( isset( $attr['firstPadding'] ) ) {
		$first_padding = $attr['firstPadding'];
		$css->set_selector( $unique_id . '> .premium-dheading-block__wrap' . ' > .premium-dheading-block__title' . ' > .premium-dheading-block__first' );
		$css->add_property( 'padding', $css->render_spacing( $first_padding['Tablet'], isset( $first_padding['unit']['Tablet'])?$first_padding['unit']['Tablet']:$first_padding['unit'] ) );
	}
    if(isset($attr['firstBackgroundOptions']) ){
        $css->set_selector( $unique_id . '> .premium-dheading-block__wrap' . ' > .premium-dheading-block__title' . ' > .premium-dheading-block__first' );
        $css->render_background( $attr['firstBackgroundOptions'], 'Tablet' );
    }

	if ( isset( $attr['firstMargin'] ) ) {
		$first_margin = $attr['firstMargin'];
		$css->set_selector( $unique_id . '> .premium-dheading-block__wrap' . ' > .premium-dheading-block__title' . ' > .premium-dheading-block__first' );
		$css->add_property( 'margin', $css->render_spacing( $first_margin['Tablet'], isset( $first_margin['unit']['Tablet'] )?$first_margin['unit']['Tablet'] :$first_margin['unit']) );
	}

	// Second Style FontSizeTablet.
	if ( isset( $attr['secondTypography'] ) ) {
		$css->set_selector( $unique_id . '> .premium-dheading-block__wrap' . ' > .premium-dheading-block__title' . ' > .premium-dheading-block__second' );
		$css->render_typography( $attr['secondTypography'], 'Tablet' );
	}

	if ( isset( $attr['secondBorder'] ) ) {
		$second_border        = $attr['secondBorder'];
		$second_border_width  = $second_border['borderWidth'];
		$second_border_radius = $second_border['borderRadius'];

		$css->set_selector( $unique_id . '> .premium-dheading-block__wrap' . ' > .premium-dheading-block__title' . ' > .premium-dheading-block__second' );

		$css->add_property( 'border-width', $css->render_spacing( $second_border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $second_border_radius['Tablet'], 'px' ) );
	}

	if ( isset( $attr['secondPadding'] ) ) {
		$second_padding = $attr['secondPadding'];
		$css->set_selector( $unique_id . '> .premium-dheading-block__wrap' . ' > .premium-dheading-block__title' . ' > .premium-dheading-block__second' );
		$css->add_property( 'padding', $css->render_spacing( $second_padding['Tablet'], isset( $second_padding['unit']['Tablet'])?$second_padding['unit']['Tablet']:$second_padding['unit'] ) );
	}
    if(isset($attr['secondBackgroundOptions']) ){
        $css->set_selector( $unique_id . '> .premium-dheading-block__wrap' . ' > .premium-dheading-block__title' . ' > .premium-dheading-block__second' );
        $css->render_background( $attr['secondBackgroundOptions'], 'Tablet' );
    }


	if ( isset( $attr['secondMargin'] ) ) {
		$second_margin = $attr['secondMargin'];
		$css->set_selector( $unique_id . '> .premium-dheading-block__wrap' . ' > .premium-dheading-block__title' . ' > .premium-dheading-block__second' );
		$css->add_property( 'margin', $css->render_spacing( $second_margin['Tablet'], isset( $second_margin['unit']['Tablet'])?$second_margin['unit']['Tablet']:$second_margin['unit'] ) );
	}
	$css->stop_media_query();
	$css->start_media_query( 'mobile' );

	if ( isset( $attr['align'] ) ) {
		
        $content_align      = $css->get_responsive_css( $attr['align'], 'Mobile' );
		$content_flex_align = 'left' === $content_align ? 'flex-start' : 'center';
		$content_flex_align = 'right' === $content_align ? 'flex-end' : $content_flex_align;
		$css->set_selector( $unique_id );
		$css->add_property( 'text-align', $content_align );
        $css->add_property( 'align-self',  $css->render_align_self($content_align) );
	}

	if ( isset( $attr['containerBorder'] ) ) {
		$container_border        = $attr['containerBorder'];
		$container_border_width  = $container_border['borderWidth'];
		$container_border_radius = $container_border['borderRadius'];

		$css->set_selector( $unique_id );
		$css->add_property( 'border-width', $css->render_spacing( $container_border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $container_border_radius['Mobile'], 'px' ) );
	}

	if ( isset( $attr['background'] ) ) {
		$css->set_selector( $unique_id );
		$css->render_background( $attr['background'], 'Mobile' );

	}

	if ( isset( $attr['padding'] ) ) {
		$padding = $attr['padding'];
		$css->set_selector( $unique_id );
		$css->add_property( 'padding', $css->render_spacing( $padding['Mobile'], isset( $padding['unit']['Mobile'])?$padding['unit']['Mobile']:$padding['unit'] ) );
	}

	if ( isset( $attr['margin'] ) ) {
		$margin = $attr['margin'];
		$css->set_selector( $unique_id );
		$css->add_property( 'margin', $css->render_spacing( $margin['Mobile'], isset( $margin['unit']['Mobile'] )?$margin['unit']['Mobile'] :$margin['unit']) );
	}
	if(isset($attr['mask_padding'])){
		$padding = $attr['mask_padding'];

		$css->set_selector( $unique_id . '.premium-mask-span' );
		$css->add_property( 'padding', $css->render_spacing( $padding['Mobile'], $padding['unit']['Mobile'] ));
	}


	// First Style FontSize.

	if ( isset( $attr['firstTypography'] ) ) {
		$first_typography = $attr['firstTypography'];
		$css->set_selector( $unique_id . '> .premium-dheading-block__wrap' . ' > .premium-dheading-block__title' . ' > .premium-dheading-block__first' );
		$css->render_typography( $first_typography, 'Mobile' );
	}

	if ( isset( $attr['firstBorder'] ) ) {
		$first_border        = $attr['firstBorder'];
		$first_border_width  = $first_border['borderWidth'];
		$first_border_radius = $first_border['borderRadius'];

		$css->set_selector( $unique_id . '> .premium-dheading-block__wrap' . ' > .premium-dheading-block__title' . ' > .premium-dheading-block__first' );
		$css->add_property( 'border-width', $css->render_spacing( $first_border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $first_border_radius['Mobile'], 'px' ) );
	}

	if ( isset( $attr['firstPadding'] ) ) {
		$first_padding = $attr['firstPadding'];
		$css->set_selector( $unique_id . '> .premium-dheading-block__wrap' . ' > .premium-dheading-block__title' . ' > .premium-dheading-block__first' );
		$css->add_property( 'padding', $css->render_spacing( $first_padding['Mobile'], isset( $first_padding['unit']['Mobile'])?$first_padding['unit']['Mobile']:$first_padding['unit'] ) );
	}

    if(isset($attr['firstBackgroundOptions']) ){
        $css->set_selector( $unique_id . '> .premium-dheading-block__wrap' . ' > .premium-dheading-block__title' . ' > .premium-dheading-block__first' );
        $css->render_background( $attr['firstBackgroundOptions'], 'Mobile' );
    }

	if ( isset( $attr['firstMargin'] ) ) {
		$first_margin = $attr['firstMargin'];
		$css->set_selector( $unique_id . '> .premium-dheading-block__wrap' . ' > .premium-dheading-block__title' . ' > .premium-dheading-block__first' );
		$css->add_property( 'margin', $css->render_spacing( $first_margin['Mobile'], isset( $first_margin['unit']['Mobile'] )?$first_margin['unit']['Mobile'] :$first_margin['unit']) );
	}

	// Second Style FontSizeMobil.
	if ( isset( $attr['secondTypography'] ) ) {
		$css->set_selector( $unique_id . '> .premium-dheading-block__wrap' . ' > .premium-dheading-block__title' . ' > .premium-dheading-block__second' );
		$css->render_typography( $attr['secondTypography'], 'Mobile' );
	}

	if ( isset( $attr['secondBorder'] ) ) {
		$second_border        = $attr['secondBorder'];
		$second_border_width  = $second_border['borderWidth'];
		$second_border_radius = $second_border['borderRadius'];

		$css->set_selector( $unique_id . '> .premium-dheading-block__wrap' . ' > .premium-dheading-block__title' . ' > .premium-dheading-block__second' );

		$css->add_property( 'border-width', $css->render_spacing( $second_border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $second_border_radius['Mobile'], 'px' ) );
	}

	if ( isset( $attr['secondPadding'] ) ) {
		$second_padding = $attr['secondPadding'];
		$css->set_selector( $unique_id . '> .premium-dheading-block__wrap' . ' > .premium-dheading-block__title' . ' > .premium-dheading-block__second' );
		$css->add_property( 'padding', $css->render_spacing( $second_padding['Mobile'], isset( $second_padding['unit']['Mobile'])?$second_padding['unit']['Mobile']:$second_padding['unit'] ) );
	}
    if(isset($attr['secondBackgroundOptions']) ){
        $css->set_selector( $unique_id . '> .premium-dheading-block__wrap' . ' > .premium-dheading-block__title' . ' > .premium-dheading-block__second' );
        $css->render_background( $attr['secondBackgroundOptions'], 'Mobile' );
    }

	if ( isset( $attr['secondMargin'] ) ) {
		$second_margin = $attr['secondMargin'];
		$css->set_selector( $unique_id . '> .premium-dheading-block__wrap' . ' > .premium-dheading-block__title' . ' > .premium-dheading-block__second' );
		$css->add_property( 'margin', $css->render_spacing( $second_margin['Mobile'], isset( $second_margin['unit']['Mobile'])?$second_margin['unit']['Mobile']:$second_margin['unit'] ) );
	}
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
