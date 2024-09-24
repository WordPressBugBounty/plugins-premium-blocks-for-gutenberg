<?php
/**
 * Server-side rendering of the `pbg/icon` block.
 *
 * @package WordPress
 */

/**
 * Get Icon Block CSS
 *
 * Return Frontend CSS for Icon.
 *
 * @access public
 *
 * @param string $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_icon_css_style( $attr, $unique_id ) {
	$css = new Premium_Blocks_css();

	// Container Styles
	if ( isset( $attr['wrapMargin'] ) ) {
		$wrap_margin = $attr['wrapMargin'];
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' );
		$css->add_property( 'margin', $css->render_spacing( $wrap_margin['Desktop'], isset($wrap_margin['unit']['Desktop'])?$wrap_margin['unit']['Desktop']:$wrap_margin['unit'] ) );
	}
	if ( isset( $attr['wrapPadding'] ) ) {
		$wrap_padding = $attr['wrapPadding'];
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' );
		$css->add_property( 'padding', $css->render_spacing( $wrap_padding['Desktop'],isset( $wrap_padding['unit']['Desktop'])? $wrap_padding['unit']['Desktop']: $wrap_padding['unit'] ) );
	}
	if ( isset( $attr['containerBorder'] ) ) {
		$container_border_width  = $attr['containerBorder']['borderWidth'];
		$container_border_radius = $attr['containerBorder']['borderRadius'];
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' );
		$css->add_property( 'border-width', $css->render_spacing( $container_border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $container_border_radius['Desktop'], 'px' ) );
	}
	if ( isset( $attr['containerBackground'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' );
		 $css->render_background( $attr['containerBackground'], 'Desktop' );

	}
	if ( isset( $attr['iconAlign'] ) ) {
	
        	$content_align      = $css->get_responsive_css( $attr['iconAlign'], 'Desktop' );
		$content_flex_align = 'left' === $content_align ? 'flex-start' : 'center';
		$content_flex_align = 'right' === $content_align ? 'flex-end' : $content_flex_align;

		$css->set_selector( '.' . $unique_id . ' > .premium-icon-class-css.premium-icon-container' );
		$css->add_property( 'text-align', $content_align );
        $css->set_selector( '.' . $unique_id  );
        	$css->add_property( 'align-self',  $css->render_align_self($content_align) );
	}

	// icon Styles
	if ( isset( $attr['iconSize'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > .premium-icon-type' );

		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > .premium-icon-type' . ' > svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Desktop' ), '!important' ) );

		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Desktop' ), '!important' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-content .premium-icon-svg-class svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Desktop' ), '!important' ) );

		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Desktop' ), '!important' ) );

	}

	// common icon type style
	if ( isset( $attr['iconMargin'] ) ) {
		$icon_margin = $attr['iconMargin'];
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > .premium-icon-type, ' . '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > img, ' . '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > #premium-icon-svg-' . $unique_id . ' > svg, ' . '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > .premium-lottie-animation' . ' > svg' );
		$css->add_property( 'margin', $css->render_spacing( $icon_margin['Desktop'],isset($icon_margin['unit']['Desktop']) ?$icon_margin['unit']['Desktop']: $icon_margin['unit']) );
	}
	if ( isset( $attr['iconPadding'] ) ) {
		$icon_padding = $attr['iconPadding'];
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > .premium-icon-type, ' . '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > img, ' . '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > #premium-icon-svg-' . $unique_id . ' > svg, ' . '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > .premium-lottie-animation' . ' > svg' );
		$css->add_property( 'padding', $css->render_spacing( $icon_padding['Desktop'], isset($icon_padding['unit']['Desktop'])?$icon_padding['unit']['Desktop']:$icon_padding['unit']  ) );
	}
	if ( isset( $attr['iconBorder'] ) ) {
		$icon_border        = $attr['iconBorder'];
		$icon_border_width  = $icon_border['borderWidth'];
		$icon_border_radius = $icon_border['borderRadius'];
		$css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-content .premium-icon-type, ' . '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > img, ' . '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > #premium-icon-svg-' . $unique_id . ' > svg, ' . '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > .premium-lottie-animation' . ' > svg' );
		$css->add_property( 'border-width', $css->render_spacing( $icon_border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $icon_border_radius['Desktop'], 'px' ) );
		$css->add_property( 'border-style', $css->render_string( $icon_border['borderType'], '!important' ) );
		$css->add_property( 'border-color', $css->render_color( $icon_border['borderColor'] ) );
	}

	// image style
	if ( isset( $attr['imgWidth'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > img' );
		$css->add_property( 'width', $css->render_range( $attr['imgWidth'], 'Desktop' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-content .premium-lottie-animation svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['imgWidth'], 'Desktop' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['imgWidth'], 'Desktop' ), '!important' ) );
	}

	// svg styles
	if ( isset( $attr['iconColor'] ) && ! empty( $attr['iconColor'] ) ) {
		$icon_color = $attr['iconColor'];
		$css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-content .premium-icon-type' );
		$css->add_property( 'fill', $css->render_string($icon_color, '!important' ) );
		$css->add_property( 'color', $css->render_string($icon_color, '!important' ) );
		$css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-content .premium-icon-type:not(.icon-type-fe) svg' );
		$css->add_property( 'fill', $css->render_string($icon_color, '!important' ) );
		$css->add_property( 'color', $css->render_string($icon_color, '!important' ) );
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > #premium-icon-svg-' . $unique_id . ' > svg ' );
		$css->add_property( 'fill', $css->render_string($icon_color, '!important' ) );
		$css->add_property( 'color', $css->render_string($icon_color, '!important' ) );
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > .premium-icon-type:not(.icon-type-fe)' . ' > svg *' );
		$css->add_property( 'fill', $css->render_string($icon_color, '!important' ) );
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > #premium-icon-svg-' . $unique_id . ' > svg *' );
		$css->add_property( 'fill', $css->render_string($icon_color, '!important' ) );
	}

	if ( isset( $attr['iconBG'] ) && ! empty( $attr['iconBG'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-content .premium-icon-type' );
		$css->render_background( $attr['iconBG'], 'Desktop' );
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > #premium-icon-svg-' . $unique_id . ' > svg ' );
		$css->render_background( $attr['iconBG'], 'Desktop' );
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > .premium-lottie-animation' . ' > svg ' );
		$css->render_background( $attr['iconBG'], 'Desktop' );
	}

	if ( isset( $attr['iconHoverColor'] ) && ! empty( $attr['iconHoverColor'] ) ) {
		$icon_HoverColor = $attr['iconHoverColor'];
		$css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-content .premium-icon-type:hover' );
		$css->add_property( 'fill', $css->render_string($icon_HoverColor, '!important' ) );
		$css->add_property( 'color', $css->render_string($icon_HoverColor, '!important' ) );
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > #premium-icon-svg-' . $unique_id . ' > svg:hover' );
		$css->add_property( 'fill', $css->render_string($icon_HoverColor, '!important' ) );
		$css->add_property( 'color', $css->render_string($icon_HoverColor, '!important' ) );
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > .premium-icon-type:not(.icon-type-fe):hover' . ' > svg *' );
		$css->add_property( 'fill', $css->render_string($icon_HoverColor, '!important' ) );
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > #premium-icon-svg-' . $unique_id . ' > svg:hover *' );
		$css->add_property( 'fill', $css->render_string($icon_HoverColor, '!important' ) );
	}

	if ( isset( $attr['iconHoverBG'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-content .premium-icon-type:hover' );
		$css->render_background( $attr['iconHoverBG'], 'Desktop' );
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > #premium-icon-svg-' . $unique_id . ' > svg:hover' );
		$css->render_background( $attr['iconHoverBG'], 'Desktop' );
		$css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-content .premium-lottie-animation:hover svg' );
		$css->render_background( $attr['iconHoverBG'], 'Desktop' );
	}

	if ( isset( $attr['borderHoverColor'] ) && ! empty( $attr['borderHoverColor'] ) ) {
		$hover_border = $attr['borderHoverColor'];
		$css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-content .premium-icon-type:hover' );
		$css->add_property( 'border-color', $css->render_string( $hover_border, '!important' ) );

		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > #premium-icon-svg-' . $unique_id . ' > svg:hover' );
		$css->add_property( 'border-color', $css->render_string( $hover_border, '!important' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-content .premium-lottie-animation:hover svg' );
		$css->add_property( 'border-color', $css->render_string( $hover_border, '!important' ) );
	}

	$css->start_media_query( 'tablet' );

	// Container Styles
	if ( isset( $attr['wrapMargin'] ) ) {
		$wrap_margin = $attr['wrapMargin'];
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' );
		$css->add_property( 'margin', $css->render_spacing( $wrap_margin['Tablet'], isset($wrap_margin['unit']['Tablet'])?$wrap_margin['unit']['Tablet']:$wrap_margin['unit'] ) );
	}
	if ( isset( $attr['wrapPadding'] ) ) {
		$wrap_padding = $attr['wrapPadding'];
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' );
		$css->add_property( 'padding', $css->render_spacing( $wrap_padding['Tablet'], isset($wrap_padding['unit']['Tablet'])?$wrap_padding['unit']['Tablet']:$wrap_padding['unit'] ) );
	}
	if ( isset( $attr['containerBorder'] ) ) {
		$container_border_width  = $attr['containerBorder']['borderWidth'];
		$container_border_radius = $attr['containerBorder']['borderRadius'];
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' );
		$css->add_property( 'border-width', $css->render_spacing( $container_border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $container_border_radius['Tablet'], 'px' ) );
	}
	if ( isset( $attr['containerBackground'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' );
		$css->render_background( $attr['containerBackground'], 'Tablet' );

	}

	if ( isset( $attr['iconAlign'] ) ) {
	    $content_align      = $css->get_responsive_css( $attr['iconAlign'], 'Tablet' );
		$content_flex_align = 'left' === $content_align ? 'flex-start' : 'center';
		$content_flex_align = 'right' === $content_align ? 'flex-end' : $content_flex_align;

		$css->set_selector( '.' . $unique_id . ' > .premium-icon-class-css.premium-icon-container' );
		$css->add_property( 'text-align', $content_align );
        $css->set_selector( '.' . $unique_id  );
        $css->add_property( 'align-self',  $css->render_align_self($content_align) );
	}

	// icon Styles
	if ( isset( $attr['iconSize'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > .premium-icon-type' );

		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > .premium-icon-type' . ' > svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Tablet' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Tablet' ), '!important' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-content .premium-icon-svg-class svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Tablet' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Tablet' ), '!important' ) );
	}

	// common icon type style
	if ( isset( $attr['iconMargin'] ) ) {
		$icon_margin = $attr['iconMargin'];
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > .premium-icon-type, ' . '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > img, ' . '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > #premium-icon-svg-' . $unique_id . ' > svg, ' . '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > .premium-lottie-animation' . ' > svg' );
		$css->add_property( 'margin', $css->render_spacing( $icon_margin['Tablet'],isset( $icon_margin['unit']['Tablet'])?$icon_margin['unit']['Tablet']:$icon_margin['unit'] ) );
	}
	if ( isset( $attr['iconPadding'] ) ) {
		$icon_padding = $attr['iconPadding'];
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > .premium-icon-type, ' . '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > img, ' . '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > #premium-icon-svg-' . $unique_id . ' > svg, ' . '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > .premium-lottie-animation' . ' > svg' );
		$css->add_property( 'padding', $css->render_spacing( $icon_padding['Tablet'], isset($icon_padding['unit']['Tablet']) ? $icon_padding['unit']['Tablet']:$icon_padding['unit']) );
	}
	if ( isset( $attr['iconBorder'] ) ) {
		$icon_border        = $attr['iconBorder'];
		$icon_border_width  = $icon_border['borderWidth'];
		$icon_border_radius = $icon_border['borderRadius'];
		$css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-content .premium-icon-type, ' . '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > img, ' . '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > #premium-icon-svg-' . $unique_id . ' > svg, ' . '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > .premium-lottie-animation' . ' > svg' );
		$css->add_property( 'border-width', $css->render_spacing( $icon_border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $icon_border_radius['Tablet'], 'px' ) );
	}

	// image style
	if ( isset( $attr['imgWidth'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > img' );
		$css->add_property( 'width', $css->render_range( $attr['imgWidth'], 'Tablet' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-content .premium-lottie-animation svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['imgWidth'], 'Tablet' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['imgWidth'], 'Tablet' ), '!important' ) );
	}

	if ( isset( $attr['iconBG'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-content .premium-icon-type' );
		$css->render_background( $attr['iconBG'], 'Tablet' );
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > #premium-icon-svg-' . $unique_id . ' > svg ' );
		$css->render_background( $attr['iconBG'], 'Tablet' );
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > .premium-lottie-animation' . ' > svg ' );
		$css->render_background( $attr['iconBG'], 'Tablet' );
	}

	if ( isset( $attr['iconHoverBG'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-content .premium-icon-type:hover' );
		$css->render_background( $attr['iconHoverBG'], 'Tablet' );
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > #premium-icon-svg-' . $unique_id . ' > svg:hover' );
		$css->render_background( $attr['iconHoverBG'], 'Tablet' );
		$css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-content .premium-lottie-animation:hover svg' );
		$css->render_background( $attr['iconHoverBG'], 'Tablet' );
	}

	$css->stop_media_query();
	$css->start_media_query( 'mobile' );

	// Container Styles
	if ( isset( $attr['wrapMargin'] ) ) {
		$wrap_margin = $attr['wrapMargin'];
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' );
		$css->add_property( 'margin', $css->render_spacing( $wrap_margin['Mobile'], isset($wrap_margin['unit']['Mobile'])?$wrap_margin['unit']['Mobile']:$wrap_margin['unit'] ) );
	}
	if ( isset( $attr['wrapPadding'] ) ) {
		$wrap_padding = $attr['wrapPadding'];
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' );
		$css->add_property( 'padding', $css->render_spacing( $wrap_padding['Mobile'],isset( $wrap_padding['unit']['Mobile']) ?$wrap_padding['unit']['Mobile']:$wrap_padding['unit'] ) );
	}
	if ( isset( $attr['containerBorder'] ) ) {
		$container_border_width  = $attr['containerBorder']['borderWidth'];
		$container_border_radius = $attr['containerBorder']['borderRadius'];
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' );
		$css->add_property( 'border-width', $css->render_spacing( $container_border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $container_border_radius['Mobile'], 'px' ) );
	}
	if ( isset( $attr['containerBackground'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' );
		$css->render_background( $attr['containerBackground'], 'Mobile' );
	}

	if ( isset( $attr['iconAlign'] ) ) {
        $content_align      = $css->get_responsive_css( $attr['iconAlign'], 'Mobile' );
		$content_flex_align = 'left' === $content_align ? 'flex-start' : 'center';
		$content_flex_align = 'right' === $content_align ? 'flex-end' : $content_flex_align;

		$css->set_selector( '.' . $unique_id . ' > .premium-icon-class-css.premium-icon-container' );
		$css->add_property( 'text-align', $content_align );
        	$css->set_selector( '.' . $unique_id  );
        $css->add_property( 'align-self',  $css->render_align_self($content_align) );
	}

	// icon Styles
	if ( isset( $attr['iconSize'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > .premium-icon-type' );

		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > .premium-icon-type' . ' > svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Mobile' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Mobile' ), '!important' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-content .premium-icon-svg-class svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Mobile' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Mobile' ), '!important' ) );
	}

	// common icon type style
	if ( isset( $attr['iconMargin'] ) ) {
		$icon_margin = $attr['iconMargin'];
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > .premium-icon-type, ' . '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > img, ' . '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > #premium-icon-svg-' . $unique_id . ' > svg, ' . '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > .premium-lottie-animation' . ' > svg' );
		$css->add_property( 'margin', $css->render_spacing( $icon_margin['Mobile'],isset( $icon_margin['unit']['Mobile'])?$icon_margin['unit']['Mobile']:$icon_margin['unit'] ) );
	}
	if ( isset( $attr['iconPadding'] ) ) {
		$icon_padding = $attr['iconPadding'];
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > .premium-icon-type, ' . '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > img, ' . '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > #premium-icon-svg-' . $unique_id . ' > svg, ' . '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > .premium-lottie-animation' . ' > svg' );
		$css->add_property( 'padding', $css->render_spacing( $icon_padding['Mobile'],isset( $icon_padding['unit']['Mobile'])?$icon_padding['unit']['Mobile']:$icon_padding['unit'] ) );
	}
	if ( isset( $attr['iconBorder'] ) ) {
		$icon_border        = $attr['iconBorder'];
		$icon_border_width  = $icon_border['borderWidth'];
		$icon_border_radius = $icon_border['borderRadius'];
		$css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-content .premium-icon-type, ' . '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > img, ' . '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > #premium-icon-svg-' . $unique_id . ' > svg, ' . '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > .premium-lottie-animation' . ' > svg' );
		$css->add_property( 'border-width', $css->render_spacing( $icon_border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $icon_border_radius['Mobile'], 'px' ) );
	}

	// image style
	if ( isset( $attr['imgWidth'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > img' );
		$css->add_property( 'width', $css->render_range( $attr['imgWidth'], 'Mobile' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-content .premium-lottie-animation svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['imgWidth'], 'Mobile' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['imgWidth'], 'Mobile' ), '!important' ) );
	}

	if ( isset( $attr['iconBG'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-content .premium-icon-type' );
		$css->render_background( $attr['iconBG'], 'Mobile' );
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > #premium-icon-svg-' . $unique_id . ' > svg ' );
		$css->render_background( $attr['iconBG'], 'Mobile' );
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > .premium-lottie-animation' . ' > svg ' );
		$css->render_background( $attr['iconBG'], 'Mobile' );
	}

	if ( isset( $attr['iconHoverBG'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-content .premium-icon-type:hover' );
		$css->render_background( $attr['iconHoverBG'], 'Mobile' );
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-container' . ' .premium-icon-content' . ' > #premium-icon-svg-' . $unique_id . ' > svg:hover' );
		$css->render_background( $attr['iconHoverBG'], 'Mobile' );
		$css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-content .premium-lottie-animation:hover svg' );
		$css->render_background( $attr['iconHoverBG'], 'Mobile' );
	}

	$css->stop_media_query();
	return $css->css_output();
}

/**
 * Renders the `premium/icon` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_icon( $attributes, $content, $block ) {
	$block_helpers = pbg_blocks_helper();

	// Enqueue frontend JS/CSS.
	if ( $block_helpers->it_is_not_amp() ) {
		wp_enqueue_script(
			'pbg-icon',
			PREMIUM_BLOCKS_URL . 'assets/js/minified/icon.min.js',
			array( 'jquery' ),
			PREMIUM_BLOCKS_VERSION,
			true
		);
	}

	if ( $block_helpers->it_is_not_amp() ) {
		if ( isset( $attributes['iconTypeSelect'] ) && $attributes['iconTypeSelect'] == 'lottie' ) {
			wp_enqueue_script(
				'pbg-lottie',
				PREMIUM_BLOCKS_URL . 'assets/js/lib/lottie.min.js',
				array( 'jquery' ),
				PREMIUM_BLOCKS_VERSION,
				true
			);
		}
	}

	return $content;
}




/**
 * Register the icon block.
 *
 * @uses render_block_pbg_icon()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_icon() {
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	register_block_type(
		PREMIUM_BLOCKS_PATH . '/blocks-config/icon',
		array(
			'render_callback' => 'render_block_pbg_icon',
		)
	);
}

register_block_pbg_icon();

