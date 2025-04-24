<?php
/**
 * Server-side rendering of the `pbg/accordion` block.
 *
 * @package WordPress
 */

/**
 * Get Accordion Block CSS
 *
 * Return Frontend CSS for Accordion.
 *
 * @access public
 *
 * @param string $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_accordion_css_style( $attr, $unique_id ) {
	$css = new Premium_Blocks_css();

	// Style.
	if ( isset( $attr['titleStyles'] ) && isset( $attr['titleStyles'][0] ) ) {
		$title_styles = $attr['titleStyles'][0];
		if(isset($title_styles['titleBack'])){
			$css->set_selector( ".{$unique_id} .premium-accordion__title_wrap" );
			$css->add_property( 'background-color', $css->render_color( $title_styles['titleBack'] ) );
		}
	
if(isset( $title_styles['titleColor'] )){
	$css->set_selector( ".{$unique_id} .premium-accordion__title_wrap .premium-accordion__title_text" );
		$css->add_property( 'color', $css->render_color( $title_styles['titleColor'] ) );
}
	
	}
	if ( isset( $attr['arrowStyles'] ) && isset( $attr['arrowStyles'][0] ) ) {
		$arrows_styles = $attr['arrowStyles'][0];
		$css->set_selector( ".{$unique_id} .premium-accordion__icon_wrap" );
		$css->add_property( 'padding', $css->render_string( $arrows_styles['arrowPadding'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_string( $arrows_styles['arrowRadius'], 'px' ) );
		if(isset($arrows_styles['arrowBack'])){
			$css->add_property( 'background-color', $css->render_color( $arrows_styles['arrowBack'] ) );

		}

		$css->set_selector( ".{$unique_id} .premium-accordion__icon_wrap svg.premium-accordion__icon" );
		if(isset($arrows_styles['arrowColor'])){
			$css->add_property( 'fill', $css->render_color( $arrows_styles['arrowColor'] ) );

		}
		$css->add_property( 'width', $css->render_string( $arrows_styles['arrowSize'], 'px' ) );
		$css->add_property( 'height', $css->render_string( $arrows_styles['arrowSize'], 'px' ) );
	}

	if ( isset( $attr['titleShadow'] ) ) {
		$title_shadow = $attr['titleShadow'];
		$css->set_selector( ".{$unique_id} .premium-accordion__title_wrap .premium-accordion__title_text" );
		$css->add_property( 'text-shadow', $css->render_shadow( $title_shadow ) );
	}

	if ( isset( $attr['titleTypography'] ) ) {
		$title_typography = $attr['titleTypography'];

		$css->set_selector( '.' . $unique_id . '> .premium-accordion__content_wrap' . ' > .premium-accordion__title_wrap' . ' > .premium-accordion__title' . ' > .premium-accordion__title_text' );
		$css->render_typography( $title_typography, 'Desktop' );
	}

	if ( isset( $attr['titlePadding'] ) ) {
		$title_padding = $attr['titlePadding'];
		$css->set_selector( '.' . $unique_id . '> .premium-accordion__content_wrap' . ' > .premium-accordion__title_wrap' );
		$css->add_property( 'padding', $css->render_spacing( $title_padding['Desktop'], isset( $title_padding['unit']['Desktop'] ) ? $title_padding['unit']['Desktop'] : $title_padding['unit'] ) );
	}

	if ( isset( $attr['titleMargin'] ) ) {
		$title_margin = $attr['titleMargin'];
		$css->set_selector( '.' . $unique_id . '> .premium-accordion__content_wrap' );
		$css->add_property( 'margin-bottom', $css->render_range( $title_margin, 'Desktop' ) . '!important' );
	}

	if ( isset( $attr['titleBorder'] ) ) {
		$title_border        = $attr['titleBorder'];
		$title_border_width  = $title_border['borderWidth'];
		$title_border_radius = $title_border['borderRadius'];

		$css->set_selector( '.' . $unique_id . '> .premium-accordion__content_wrap' . ' > .premium-accordion__title_wrap' );
		$css->add_property( 'border-width', $css->render_spacing( $title_border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $title_border_radius['Desktop'], 'px' ) );
		if(isset($title_border['borderColor'] )){
			$css->add_property( 'border-color', $css->render_color( $title_border['borderColor'] ) );
		}
		$css->add_property( 'border-style', $title_border['borderType'] ?? 'none' );
	}

	// Desc Style
	if ( isset( $attr['descStyles'] ) && isset( $attr['descStyles'][0] ) ) {
		$desc_styles = $attr['descStyles'][0];
		if(isset( $desc_styles['descBack'] )){
		$css->set_selector( ".{$unique_id} .premium-accordion__desc_wrap" );

		$css->add_property( 'background-color', $css->render_color( $desc_styles['descBack'] ) );

		}
		if(isset($desc_styles['descColor'])){
		$css->set_selector( ".{$unique_id} .premium-accordion__desc_wrap .premium-accordion__desc" );
		$css->add_property( 'color', $css->render_color( $desc_styles['descColor'] ) );

		}
	}

	if ( isset( $attr['textShadow'] ) ) {
		$text_shadow = $attr['textShadow'];
		$css->set_selector( ".{$unique_id} .premium-accordion__desc_wrap .premium-accordion__desc" );
		$css->add_property( 'text-shadow', $css->render_shadow( $text_shadow ) );

		$css->set_selector( ".{$unique_id} .premium-accordion__desc_wrap" );
		$css->add_property( 'text-shadow', $css->render_shadow( $text_shadow ) );
	}

	if ( isset( $attr['descTypography'] ) ) {
		$desc_typography = $attr['descTypography'];

		$css->set_selector( '.' . $unique_id . '> .premium-accordion__content_wrap' . ' > .premium-accordion__desc_wrap' . ' > .premium-accordion__desc' );
		$css->render_typography( $desc_typography, 'Desktop' );
	}

	if ( isset( $attr['descPadding'] ) ) {
		$desc_padding = $attr['descPadding'];
		$css->set_selector( '.' . $unique_id . '> .premium-accordion__content_wrap' . ' > .premium-accordion__desc_wrap' );
		$css->add_property( 'padding', $css->render_spacing( $desc_padding['Desktop'], isset( $desc_padding['unit']['Desktop'] ) ? $desc_padding['unit']['Desktop'] : $desc_padding['unit'] ) );
	}

	if ( isset( $attr['descBorder'] ) ) {
		$desc_border        = $attr['descBorder'];
		$desc_border_width  = $desc_border['borderWidth'];
		$desc_border_radius = $desc_border['borderRadius'];

		$css->set_selector( '.' . $unique_id . '> .premium-accordion__content_wrap' . ' > .premium-accordion__desc_wrap' );
		$css->add_property( 'border-width', $css->render_spacing( $desc_border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $desc_border_radius['Desktop'], 'px' ) );
		if(isset($desc_border['borderColor'])){
			$css->add_property( 'border-color', $css->render_color( $desc_border['borderColor'] ) );

		}
		$css->add_property( 'border-style', $desc_border['borderType'] ?? 'none' );
	}
	// content.
	if ( isset( $attr['descAlign'] ) ) {
		$align = $attr['descAlign'];

		$css->set_selector( '.' . $unique_id . '> .premium-accordion__content_wrap' . ' > .premium-accordion__desc_wrap' );
		$css->add_property( 'text-align', $css->get_responsive_css( $align, 'Desktop' ) );
	}

	$css->start_media_query( 'tablet' );

	if ( isset( $attr['titleTypography'] ) ) {
		$title_typography = $attr['titleTypography'];

		$css->set_selector( '.' . $unique_id . '> .premium-accordion__content_wrap' . ' > .premium-accordion__title_wrap' . ' > .premium-accordion__title' . ' > .premium-accordion__title_text' );
		$css->render_typography( $title_typography, 'Tablet' );
	}

	if ( isset( $attr['titlePadding'] ) ) {
		$title_padding = $attr['titlePadding'];
		$css->set_selector( '.' . $unique_id . '> .premium-accordion__content_wrap' . ' > .premium-accordion__title_wrap' );
		$css->add_property( 'padding', $css->render_spacing( $title_padding['Tablet'], isset( $title_padding['unit']['Tablet'] ) ? $title_padding['unit']['Tablet'] : $title_padding['unit'] ) );
	}

	if ( isset( $attr['titleMargin'] ) ) {
		$title_margin = $attr['titleMargin'];
		$css->set_selector( '.' . $unique_id . '> .premium-accordion__content_wrap' );
		$css->add_property( 'margin-bottom', $css->render_range( $title_margin, 'Tablet' ) . '!important' );
	}

	if ( isset( $attr['titleBorder'] ) ) {
		$title_border        = $attr['titleBorder'];
		$title_border_width  = $title_border['borderWidth'];
		$title_border_radius = $title_border['borderRadius'];

		$css->set_selector( '.' . $unique_id . '> .premium-accordion__content_wrap' . ' > .premium-accordion__title_wrap' );
		$css->add_property( 'border-width', $css->render_spacing( $title_border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $title_border_radius['Tablet'], 'px' ) );
	}

	// Desc Style
	if ( isset( $attr['descTypography'] ) ) {
		$desc_typography = $attr['descTypography'];

		$css->set_selector( '.' . $unique_id . '> .premium-accordion__content_wrap' . ' > .premium-accordion__desc_wrap' . ' > .premium-accordion__desc' );
		$css->render_typography( $desc_typography, 'Tablet' );
	}

	if ( isset( $attr['descPadding'] ) ) {
		$desc_padding = $attr['descPadding'];
		$css->set_selector( '.' . $unique_id . '> .premium-accordion__content_wrap' . ' > .premium-accordion__desc_wrap' );
		$css->add_property( 'padding', $css->render_spacing( $desc_padding['Tablet'], isset( $desc_padding['unit']['Tablet'] ) ? $desc_padding['unit']['Tablet'] : $desc_padding['unit'] ) );
	}

	if ( isset( $attr['descBorder'] ) ) {
		$desc_border        = $attr['descBorder'];
		$desc_border_width  = $desc_border['borderWidth'];
		$desc_border_radius = $desc_border['borderRadius'];

		$css->set_selector( '.' . $unique_id . '> .premium-accordion__content_wrap' . ' > .premium-accordion__desc_wrap' );
		$css->add_property( 'border-width', $css->render_spacing( $desc_border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $desc_border_radius['Tablet'], 'px' ) );
	}
	// content.
	if ( isset( $attr['descAlign'] ) ) {
		$align = $attr['descAlign'];

		$css->set_selector( '.' . $unique_id . '> .premium-accordion__content_wrap' . ' > .premium-accordion__desc_wrap' );
		$css->add_property( 'text-align', $css->get_responsive_css( $align, 'Tablet' ) );
	}

	$css->stop_media_query();
	$css->start_media_query( 'mobile' );
	if ( isset( $attr['titleTypography'] ) ) {
		$title_typography = $attr['titleTypography'];

		$css->set_selector( '.' . $unique_id . '> .premium-accordion__content_wrap' . ' > .premium-accordion__title_wrap' . ' > .premium-accordion__title' . ' > .premium-accordion__title_text' );
		$css->render_typography( $title_typography, 'Mobile' );
	}

	if ( isset( $attr['titlePadding'] ) ) {
		$title_padding = $attr['titlePadding'];
		$css->set_selector( '.' . $unique_id . '> .premium-accordion__content_wrap' . ' > .premium-accordion__title_wrap' );
		$css->add_property( 'padding', $css->render_spacing( $title_padding['Mobile'], isset( $title_padding['unit']['Mobile'] ) ? $title_padding['unit']['Mobile'] : $title_padding['unit'] ) );
	}

	if ( isset( $attr['titleMargin'] ) ) {
		$title_margin = $attr['titleMargin'];
		$css->set_selector( '.' . $unique_id . '> .premium-accordion__content_wrap' );
		$css->add_property( 'margin-bottom', $css->render_range( $title_margin, 'Mobile' ) . '!important' );
	}

	if ( isset( $attr['titleBorder'] ) ) {
		$title_border        = $attr['titleBorder'];
		$title_border_width  = $title_border['borderWidth'];
		$title_border_radius = $title_border['borderRadius'];

		$css->set_selector( '.' . $unique_id . '> .premium-accordion__content_wrap' . ' > .premium-accordion__title_wrap' );
		$css->add_property( 'border-width', $css->render_spacing( $title_border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $title_border_radius['Mobile'], 'px' ) );
	}

	// Desc Style
	if ( isset( $attr['descTypography'] ) ) {
		$desc_typography = $attr['descTypography'];

		$css->set_selector( '.' . $unique_id . '> .premium-accordion__content_wrap' . ' > .premium-accordion__desc_wrap' . ' > .premium-accordion__desc' );
		$css->render_typography( $desc_typography, 'Mobile' );
	}

	if ( isset( $attr['descPadding'] ) ) {
		$desc_padding = $attr['descPadding'];
		$css->set_selector( '.' . $unique_id . '> .premium-accordion__content_wrap' . ' > .premium-accordion__desc_wrap' );
		$css->add_property( 'padding', $css->render_spacing( $desc_padding['Mobile'], isset( $desc_padding['unit']['Mobile'] ) ? $desc_padding['unit']['Mobile'] : $desc_padding['unit'] ) );
	}

	if ( isset( $attr['descBorder'] ) ) {
		$desc_border        = $attr['descBorder'];
		$desc_border_width  = $desc_border['borderWidth'];
		$desc_border_radius = $desc_border['borderRadius'];

		$css->set_selector( '.' . $unique_id . '> .premium-accordion__content_wrap' . ' > .premium-accordion__desc_wrap' );
		$css->add_property( 'border-width', $css->render_spacing( $desc_border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $desc_border_radius['Mobile'], 'px' ) );
	}
	// content.
	if ( isset( $attr['descAlign'] ) ) {
		$align = $attr['descAlign'];

		$css->set_selector( '.' . $unique_id . '> .premium-accordion__content_wrap' . ' > .premium-accordion__desc_wrap' );
		$css->add_property( 'text-align', $css->get_responsive_css( $align, 'Mobile' ) );
	}

	$css->stop_media_query();
	return $css->css_output();
}

/**
 * Renders the `premium/accordion` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_accordion( $attributes, $content, $block ) {
	$collapse_others   = isset( $attributes['collapseOthers'] ) ? $attributes['collapseOthers'] : false;
	$expand_first_item = isset( $attributes['expandFirstItem'] ) ? $attributes['expandFirstItem'] : false;
	$block_helpers     = pbg_blocks_helper();

	if ( $block_helpers->it_is_not_amp() ) {
		wp_enqueue_script(
			'pbg-accordion',
			PREMIUM_BLOCKS_URL . 'assets/js/minified/accordion.min.js',
			array(),
			PREMIUM_BLOCKS_VERSION,
			true
		);

		wp_localize_script(
			'pbg-accordion',
			'pbg_accordion',
			array(
				'collapse_others'   => $collapse_others,
				'expand_first_item' => $expand_first_item,
			)
		);
	}

	return $content;
}




/**
 * Register the accordion block.
 *
 * @uses render_block_pbg_accordion()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_accordion() {
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	register_block_type(
		PREMIUM_BLOCKS_PATH . '/blocks-config/accordion',
		array(
			'render_callback' => 'render_block_pbg_accordion',
		)
	);
}

register_block_pbg_accordion();
