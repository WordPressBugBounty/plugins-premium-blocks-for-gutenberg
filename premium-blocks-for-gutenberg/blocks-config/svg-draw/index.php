<?php
/**
 * Server-side rendering of the `pbg/svg-draw` block.
 *
 * @package WordPress
 */

/**
 * Get SVG Draw Block CSS
 *
 * Return Frontend CSS for SVG Draw.
 *
 * @access public
 *
 * @param string $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_svg_draw_css_style( $attr, $unique_id ) {
	$css = new Premium_Blocks_css();

	// Container Styles
	if ( isset( $attr['wrapMargin'] ) ) {
		$wrap_margin = $attr['wrapMargin'];
		$css->set_selector( ".{$unique_id} > .premium-icon-container" );
		$css->add_property( 'margin', $css->render_spacing( $wrap_margin['Desktop'], $wrap_margin['unit']['Desktop'] ) );
	}
	if ( isset( $attr['wrapPadding'] ) ) {
		$wrap_padding = $attr['wrapPadding'];
		$css->set_selector( ".{$unique_id} > .premium-icon-container" );
		$css->add_property( 'padding', $css->render_spacing( $wrap_padding['Desktop'], $wrap_padding['unit']['Desktop'] ) );
	}
	if ( isset( $attr['containerBorder'] ) ) {
		$container_border_width  = $attr['containerBorder']['borderWidth'];
		$container_border_radius = $attr['containerBorder']['borderRadius'];
		$css->set_selector( ".{$unique_id} > .premium-icon-container" );
		$css->add_property( 'border-width', $css->render_spacing( $container_border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $container_border_radius['Desktop'], 'px' ) );
	}
	if ( isset( $attr['containerBackground'] ) ) {
		$css->set_selector( ".{$unique_id} > .premium-icon-container" );
		$css->render_background( $attr['containerBackground'], 'Desktop' );

	}

	if ( isset( $attr['iconAlign'] ) ) {
		$content_align      = $css->get_responsive_css( $attr['iconAlign'], 'Desktop' );
		$css->set_selector( ".{$unique_id}  > .premium-icon-class-css.premium-icon-container" );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['iconAlign'], 'Desktop' ) );
		$css->set_selector( ".{$unique_id}  " );
		$css->add_property( 'align-self', $css->render_align_self($content_align) );
	}

	// icon Styles
	if ( isset( $attr['iconSize'] ) ) {
		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content  > .premium-icon-type" );
		$css->add_property( 'font-size', $css->render_string( $css->render_range( $attr['iconSize'], 'Desktop' ), '!important' ) );

		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content  > .premium-icon-type.dashicons" );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Desktop' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Desktop' ), '!important' ) );

		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content  > .premium-icon-type svg" );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Desktop' ), '!important' ) );

		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Desktop' ), '!important' ) );

		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content .premium-icon-svg-class svg" );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Desktop' ), '!important' ) );

		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Desktop' ), '!important' ) );

	}

	// common icon type style
	if ( isset( $attr['iconMargin'] ) ) {
		$icon_margin = $attr['iconMargin'];
		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content > .premium-icon-type, .{$unique_id} > .premium-icon-container .premium-icon-content > img, .{$unique_id} > .premium-icon-container .premium-icon-content > #premium-icon-svg-{$unique_id} > svg" );
		$css->add_property( 'margin', $css->render_spacing( $icon_margin['Desktop'], $icon_margin['unit']['Desktop'] ) );
	}
	if ( isset( $attr['iconPadding'] ) ) {
		$icon_padding = $attr['iconPadding'];
		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content > .premium-icon-type, .{$unique_id} > .premium-icon-container .premium-icon-content > img, .{$unique_id} > .premium-icon-container .premium-icon-content > #premium-icon-svg-{$unique_id} > svg" );
		$css->add_property( 'padding', $css->render_spacing( $icon_padding['Desktop'], $icon_padding['unit']['Desktop'] ) );
	}
	if ( isset( $attr['iconBorder'] ) ) {
		$icon_border        = $attr['iconBorder'];
		$icon_border_width  = $icon_border['borderWidth'];
		$icon_border_radius = $icon_border['borderRadius'];
		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content > .premium-icon-type, .{$unique_id} > .premium-icon-container .premium-icon-content > img, .{$unique_id} > .premium-icon-container .premium-icon-content > #premium-icon-svg-{$unique_id} > svg" );
		$css->add_property( 'border-width', $css->render_spacing( $icon_border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $icon_border_radius['Desktop'], 'px' ) );
		$css->add_property( 'border-style', $css->render_string( $icon_border['borderType'], '!important' ) );
		$css->add_property( 'border-color', $css->render_color( $icon_border['borderColor'] ) );
	}

	// svg styles
	if ( isset( $attr['iconColor'] ) && ! empty( $attr['iconColor'] ) ) {
		$icon_color = $attr['iconColor'];
		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content .premium-icon-type" );
		$css->add_property( 'fill', $icon_color );
		$css->add_property( 'color', $icon_color );
		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content .premium-icon-type:not(.icon-type-fe) svg" );
		$css->add_property( 'fill', $icon_color );
		$css->add_property( 'color', $icon_color );
		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content > #premium-icon-svg-{$unique_id} > svg" );
		$css->add_property( 'fill', $icon_color );
		$css->add_property( 'color', $icon_color );
		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content > .premium-icon-type:not(.icon-type-fe) > svg *" );
		$css->add_property( 'fill', $icon_color );
		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content > #premium-icon-svg-{$unique_id} > svg *" );
		$css->add_property( 'fill', $icon_color );
	}

	if ( isset( $attr['iconBG'] ) && ! empty( $attr['iconBG'] ) ) {
		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content .premium-icon-type" );
		$css->render_background( $attr['iconBG'], 'Desktop' );
	}

	if ( isset( $attr['iconHoverColor'] ) && ! empty( $attr['iconHoverColor'] ) ) {
		$icon_HoverColor = $attr['iconHoverColor'];
		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content .premium-icon-type:hover" );
		$css->add_property( 'fill', $icon_HoverColor );
		$css->add_property( 'color', $icon_HoverColor );
		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content > #premium-icon-svg-{$unique_id} > svg:hover" );
		$css->add_property( 'fill', $icon_HoverColor );
		$css->add_property( 'color', $icon_HoverColor );
		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content > .premium-icon-type:not(.icon-type-fe) > svg:hover *" );
		$css->add_property( 'fill', $icon_HoverColor );
		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content > #premium-icon-svg-{$unique_id} > svg:hover *" );
		$css->add_property( 'fill', $icon_HoverColor );
	}

	if ( isset( $attr['iconHoverBG'] ) ) {
		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content .premium-icon-type:hover" );
		$css->render_background( $attr['iconHoverBG'], 'Desktop' );
		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content > #premium-icon-svg-{$unique_id} > svg:hover" );
		$css->render_background( $attr['iconHoverBG'], 'Desktop' );
	}

	if ( isset( $attr['borderHoverColor'] ) && ! empty( $attr['borderHoverColor'] ) ) {
		$hover_border = $attr['borderHoverColor'];
		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content .premium-icon-type:hover" );
		$css->add_property( 'border-color', $css->render_string( $hover_border, '!important' ) );

		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content > #premium-icon-svg-{$unique_id} > svg:hover" );
		$css->add_property( 'border-color', $css->render_string( $hover_border, '!important' ) );
	}

	$css->start_media_query( 'tablet' );

	// Container Styles
	if ( isset( $attr['wrapMargin'] ) ) {
		$wrap_margin = $attr['wrapMargin'];
		$css->set_selector( ".{$unique_id} > .premium-icon-container" );
		$css->add_property( 'margin', $css->render_spacing( $wrap_margin['Tablet'], $wrap_margin['unit']['Tablet'] ) );
	}
	if ( isset( $attr['wrapPadding'] ) ) {
		$wrap_padding = $attr['wrapPadding'];
		$css->set_selector( ".{$unique_id} > .premium-icon-container" );
		$css->add_property( 'padding', $css->render_spacing( $wrap_padding['Tablet'], $wrap_padding['unit']['Tablet'] ) );
	}
	if ( isset( $attr['containerBorder'] ) ) {
		$container_border_width  = $attr['containerBorder']['borderWidth'];
		$container_border_radius = $attr['containerBorder']['borderRadius'];
		$css->set_selector( ".{$unique_id} > .premium-icon-container" );
		$css->add_property( 'border-width', $css->render_spacing( $container_border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $container_border_radius['Tablet'], 'px' ) );
	}
	if ( isset( $attr['containerBackground'] ) ) {
		$css->set_selector( ".{$unique_id} > .premium-icon-container" );
		$css->render_background( $attr['containerBackground'], 'Tablet' );

	}
	if ( isset( $attr['iconAlign'] ) ) {
		$content_align      = $css->get_responsive_css( $attr['iconAlign'], 'Tablet' );
		$css->set_selector( ".{$unique_id}  > .premium-icon-class-css.premium-icon-container" );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['iconAlign'], 'Tablet' ) );
		$css->set_selector( ".{$unique_id}  " );
		$css->add_property( 'align-self', $css->render_align_self($content_align) );
	}

	// icon Styles
	if ( isset( $attr['iconSize'] ) ) {
		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content  > .premium-icon-type" );
		$css->add_property( 'font-size', $css->render_string( $css->render_range( $attr['iconSize'], 'Tablet' ), '!important' ) );

		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content  > .premium-icon-type.dashicons" );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Tablet' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Tablet' ), '!important' ) );

		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content  > .premium-icon-type svg" );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Tablet' ), '!important' ) );

		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Tablet' ), '!important' ) );

		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content .premium-icon-svg-class svg" );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Tablet' ), '!important' ) );

		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Tablet' ), '!important' ) );

	}

	// common icon type style
	if ( isset( $attr['iconMargin'] ) ) {
		$icon_margin = $attr['iconMargin'];
		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content > .premium-icon-type, .{$unique_id} > .premium-icon-container .premium-icon-content > img, .{$unique_id} > .premium-icon-container .premium-icon-content > #premium-icon-svg-{$unique_id} > svg" );
		$css->add_property( 'margin', $css->render_spacing( $icon_margin['Tablet'], $icon_margin['unit']['Tablet'] ) );
	}
	if ( isset( $attr['iconPadding'] ) ) {
		$icon_padding = $attr['iconPadding'];
		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content > .premium-icon-type, .{$unique_id} > .premium-icon-container .premium-icon-content > img, .{$unique_id} > .premium-icon-container .premium-icon-content > #premium-icon-svg-{$unique_id} > svg" );
		$css->add_property( 'padding', $css->render_spacing( $icon_padding['Tablet'], $icon_padding['unit']['Tablet'] ) );
	}
	if ( isset( $attr['iconBorder'] ) ) {
		$icon_border        = $attr['iconBorder'];
		$icon_border_width  = $icon_border['borderWidth'];
		$icon_border_radius = $icon_border['borderRadius'];
		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content > .premium-icon-type, .{$unique_id} > .premium-icon-container .premium-icon-content > img, .{$unique_id} > .premium-icon-container .premium-icon-content > #premium-icon-svg-{$unique_id} > svg" );
		$css->add_property( 'border-width', $css->render_spacing( $icon_border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $icon_border_radius['Tablet'], 'px' ) );
	}

	// svg styles

	if ( isset( $attr['iconBG'] ) && ! empty( $attr['iconBG'] ) ) {
		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content .premium-icon-type" );
		$css->render_background( $attr['iconBG'], 'Tablet' );
		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content .premium-icon-type svg" );
		$css->render_background( $attr['iconBG'], 'Tablet' );
	}

	if ( isset( $attr['iconHoverBG'] ) ) {
		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content .premium-icon-type:hover" );
		$css->render_background( $attr['iconHoverBG'], 'Tablet' );
		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content > #premium-icon-svg-{$unique_id} > svg:hover" );
		$css->render_background( $attr['iconHoverBG'], 'Tablet' );
	}

	$css->stop_media_query();
	$css->start_media_query( 'mobile' );

	// Container Styles
	if ( isset( $attr['wrapMargin'] ) ) {
		$wrap_margin = $attr['wrapMargin'];
		$css->set_selector( ".{$unique_id} > .premium-icon-container" );
		$css->add_property( 'margin', $css->render_spacing( $wrap_margin['Mobile'], $wrap_margin['unit']['Mobile'] ) );
	}
	if ( isset( $attr['wrapPadding'] ) ) {
		$wrap_padding = $attr['wrapPadding'];
		$css->set_selector( ".{$unique_id} > .premium-icon-container" );
		$css->add_property( 'padding', $css->render_spacing( $wrap_padding['Mobile'], $wrap_padding['unit']['Mobile'] ) );
	}
	if ( isset( $attr['containerBorder'] ) ) {
		$container_border_width  = $attr['containerBorder']['borderWidth'];
		$container_border_radius = $attr['containerBorder']['borderRadius'];
		$css->set_selector( ".{$unique_id} > .premium-icon-container" );
		$css->add_property( 'border-width', $css->render_spacing( $container_border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $container_border_radius['Mobile'], 'px' ) );
	}
	if ( isset( $attr['containerBackground'] ) ) {
		$css->set_selector( ".{$unique_id} > .premium-icon-container" );
		$css->render_background( $attr['containerBackground'], 'Mobile' );

	}
	
	if ( isset( $attr['iconAlign'] ) ) {
		$content_align      = $css->get_responsive_css( $attr['iconAlign'], 'Mobile' );
		$css->set_selector( ".{$unique_id}  > .premium-icon-class-css.premium-icon-container" );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['iconAlign'], 'Mobile' ) );
		$css->set_selector( ".{$unique_id}  " );
		$css->add_property( 'align-self', $css->render_align_self($content_align) );
	}

	// icon Styles
	if ( isset( $attr['iconSize'] ) ) {
		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content  > .premium-icon-type" );
		$css->add_property( 'font-size', $css->render_string( $css->render_range( $attr['iconSize'], 'Mobile' ), '!important' ) );

		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content  > .premium-icon-type.dashicons" );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Mobile' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Mobile' ), '!important' ) );

		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content  > .premium-icon-type svg" );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Mobile' ), '!important' ) );

		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Mobile' ), '!important' ) );

		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content .premium-icon-svg-class svg" );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Mobile' ), '!important' ) );

		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Mobile' ), '!important' ) );

	}

	// common icon type style
	if ( isset( $attr['iconMargin'] ) ) {
		$icon_margin = $attr['iconMargin'];
		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content > .premium-icon-type, .{$unique_id} > .premium-icon-container .premium-icon-content > img, .{$unique_id} > .premium-icon-container .premium-icon-content > #premium-icon-svg-{$unique_id} > svg" );
		$css->add_property( 'margin', $css->render_spacing( $icon_margin['Mobile'], $icon_margin['unit']['Mobile'] ) );
	}
	if ( isset( $attr['iconPadding'] ) ) {
		$icon_padding = $attr['iconPadding'];
		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content > .premium-icon-type, .{$unique_id} > .premium-icon-container .premium-icon-content > img, .{$unique_id} > .premium-icon-container .premium-icon-content > #premium-icon-svg-{$unique_id} > svg" );
		$css->add_property( 'padding', $css->render_spacing( $icon_padding['Mobile'], $icon_padding['unit']['Mobile'] ) );
	}
	if ( isset( $attr['iconBorder'] ) ) {
		$icon_border        = $attr['iconBorder'];
		$icon_border_width  = $icon_border['borderWidth'];
		$icon_border_radius = $icon_border['borderRadius'];
		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content > .premium-icon-type, .{$unique_id} > .premium-icon-container .premium-icon-content > img, .{$unique_id} > .premium-icon-container .premium-icon-content > #premium-icon-svg-{$unique_id} > svg" );
		$css->add_property( 'border-width', $css->render_spacing( $icon_border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $icon_border_radius['Mobile'], 'px' ) );
	}

	// svg styles

	if ( isset( $attr['iconBG'] ) && ! empty( $attr['iconBG'] ) ) {
		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content .premium-icon-type" );
		$css->render_background( $attr['iconBG'], 'Mobile' );
		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content .premium-icon-type svg" );
		$css->render_background( $attr['iconBG'], 'Mobile' );
	}

	if ( isset( $attr['iconHoverBG'] ) ) {
		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content .premium-icon-type:hover" );
		$css->render_background( $attr['iconHoverBG'], 'Mobile' );
		$css->set_selector( ".{$unique_id} > .premium-icon-container .premium-icon-content > #premium-icon-svg-{$unique_id} > svg:hover" );
		$css->render_background( $attr['iconHoverBG'], 'Mobile' );
	}

	$css->stop_media_query();
	return $css->css_output();
}

/**
 * Renders the `premium/svg-draw` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_svg_draw( $attributes, $content, $block ) {
	$block_helpers = pbg_blocks_helper();

	// Enqueue frontend JS/CSS.
	
	return $content;
}




/**
 * Register the svg draw block.
 *
 * @uses render_block_pbg_svg_draw()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_svg_draw() {
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	register_block_type(
		PREMIUM_BLOCKS_PATH . '/blocks-config/svg-draw',
		array(
			'render_callback' => 'render_block_pbg_svg_draw',
		)
	);
}

register_block_pbg_svg_draw();

