<?php
/**
 * Server-side rendering of the `pbg/image-separator` block.
 *
 * @package WordPress
 */

/**
 * Get Image Separator Block CSS
 *
 * Return Frontend CSS for Image Separator.
 *
 * @access public
 *
 * @param string $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_image_separator_css_style( $attr, $unique_id ) {
	$css = new Premium_Blocks_css();

	// container style
	if ( isset( $attr['iconAlign'] ) ) {
           $content_align      = $css->get_responsive_css( $attr['iconAlign'], 'Desktop' );
		$content_flex_align = 'left' === $content_align ? 'flex-start' : 'center';
		$content_flex_align = 'right' === $content_align ? 'flex-end' : $content_flex_align;
		$css->set_selector( '.' . $unique_id );
		$css->add_property( 'text-align',$content_align );
        $css->add_property( 'align-self', $css->render_align_self($content_align) );

	}

	if ( isset( $attr['iconAlign'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-image-separator-container' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['iconAlign'], 'Desktop' ) );
	}

	// Icon Style.
	if ( isset( $attr['imgWidth'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-image-separator-container' . ' > .premium-image-separator-icon' );
		$css->add_property( 'font-size', $css->render_string( $css->render_range( $attr['imgWidth'], 'Desktop' ), '!important' ) );

		$css->set_selector( '.' . $unique_id . ' > .premium-image-separator-container' . ' > .premium-image-separator-icon' . ' > svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['imgWidth'], 'Desktop' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['imgWidth'], 'Desktop' ), '!important' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-image-separator-container  .premium-image-separator-svg-class svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['imgWidth'], 'Desktop' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['imgWidth'], 'Desktop' ), '!important' ) );
	}
	if ( isset( $attr['iconMargin'] ) ) {
		$icon_margin = $attr['iconMargin'];
		$css->set_selector( '.' . $unique_id . ' > .premium-image-separator-container' . ' > .premium-image-separator-icon, ' . '.' . $unique_id . ' > .premium-image-separator-container' . ' > img, ' . '.' . $unique_id . ' > .premium-image-separator-container'  . ' > #premium-image-separator-svg-' . $unique_id . ' > svg, ' . '.' . $unique_id . ' > .premium-image-separator-container'  . ' > .premium-lottie-animation' . ' > svg' );
		$css->add_property( 'margin', $css->render_spacing( $icon_margin['Desktop'],isset( $icon_margin['unit']['Desktop'])?$icon_margin['unit']['Desktop']:$icon_margin['unit'] ) );
	}
	if ( isset( $attr['iconPadding'] ) ) {
		$icon_padding = $attr['iconPadding'];
		$css->set_selector( '.' . $unique_id . ' > .premium-image-separator-container' . ' > .premium-image-separator-icon, ' . '.' . $unique_id . ' > .premium-image-separator-container' . ' > img, ' . '.' . $unique_id . ' > .premium-image-separator-container'  . ' > #premium-image-separator-svg-' . $unique_id . ' > svg, ' . '.' . $unique_id . ' > .premium-image-separator-container'  . ' > .premium-lottie-animation' . ' > svg' );
		$css->add_property( 'padding', $css->render_spacing( $icon_padding['Desktop'],isset( $icon_padding['unit']['Desktop'])?$icon_padding['unit']['Desktop']:$icon_padding['unit'] ) );
	}
	if ( isset( $attr['iconBorder'] ) && ( isset( $attr['iconStyles'] ) && ( $attr['iconStyles'][0]['advancedBorder'] ) == false ) ) {
		$icon_border        = $attr['iconBorder'];
		$icon_border_width  = $icon_border['borderWidth'];
		$icon_border_radius = $icon_border['borderRadius'];
		$css->set_selector( '.' . $unique_id . ' .premium-image-separator-container  .premium-image-separator-icon, ' . '.' . $unique_id . ' > .premium-image-separator-container'  . ' > img, ' . '.' . $unique_id . ' > .premium-image-separator-container' . ' > #premium-image-separator-svg-' . $unique_id . ' > svg, ' . '.' . $unique_id . ' > .premium-image-separator-container' . ' > .premium-lottie-animation' . ' > svg' );
		$css->add_property( 'border-width', $css->render_spacing( $icon_border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $icon_border_radius['Desktop'], 'px' ) );
		$css->add_property( 'border-style', $css->render_string( $icon_border['borderType'] ), '!important' );
		$css->add_property( 'border-color', $css->render_color( $icon_border['borderColor'] ) );
	}
	if ( isset( $attr['imgWidth'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-image-separator-container'  . ' > img' );
		$css->add_property( 'width', $css->render_range( $attr['imgWidth'], 'Desktop' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-image-separator-container  .premium-lottie-animation svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['imgWidth'], 'Desktop' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['imgWidth'], 'Desktop' ), '!important' ) );
	}
	if ( isset( $attr['iconColor'] ) && ! empty( $attr['iconColor'] ) ) {
		$icon_color = $attr['iconColor'];
		$css->set_selector( '.' . $unique_id . ' .premium-image-separator-container  .premium-image-separator-icon' );
		$css->add_property( 'fill', $icon_color );
		$css->add_property( 'color', $icon_color );
		$css->set_selector( '.' . $unique_id . ' .premium-image-separator-container  .premium-image-separator-icon:not(.icon-type-fe) svg' );
		$css->add_property( 'fill', $icon_color );
		$css->add_property( 'color', $icon_color );
		$css->set_selector( '.' . $unique_id . ' > .premium-image-separator-container'  . ' > #premium-image-separator-svg-' . $unique_id . ' > svg ' );
		$css->add_property( 'fill', $icon_color );
		$css->add_property( 'color', $icon_color );
		$css->set_selector( '.' . $unique_id . ' > .premium-image-separator-container'  . ' > .premium-image-separator-icon:not(.icon-type-fe)' . ' > svg *' );
		$css->add_property( 'fill', $icon_color );
		$css->set_selector( '.' . $unique_id . ' > .premium-image-separator-container'  . ' > #premium-image-separator-svg-' . $unique_id . ' > svg *' );
		$css->add_property( 'fill', $icon_color );
	}

	if ( isset( $attr['iconBG'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-image-separator-container .premium-image-separator-icon' );
		$css->render_background( $attr['iconBG'], 'Desktop' );
		$css->set_selector( '.' . $unique_id . ' > .premium-image-separator-container'  . ' > #premium-image-separator-svg-' . $unique_id . ' > svg ' );
		$css->render_background( $attr['iconBG'], 'Desktop' );
		$css->set_selector( '.' . $unique_id . ' > .premium-image-separator-container'  . ' > .premium-lottie-animation' . ' > svg ' );
		$css->render_background( $attr['iconBG'], 'Desktop' );
	}

	if ( isset( $attr['iconHoverColor'] ) && ! empty( $attr['iconHoverColor'] ) ) {
		$icon_HoverColor = $attr['iconHoverColor'];
		$css->set_selector( '.' . $unique_id . ' .premium-image-separator-container .premium-image-separator-icon:hover' );
		$css->add_property( 'fill', $icon_HoverColor );
		$css->add_property( 'color', $icon_HoverColor );
		$css->set_selector( '.' . $unique_id . ' > .premium-image-separator-container'  . ' > #premium-image-separator-svg-' . $unique_id . ' > svg:hover' );
		$css->add_property( 'fill', $icon_HoverColor );
		$css->add_property( 'color', $icon_HoverColor );
		$css->set_selector( '.' . $unique_id . ' .premium-image-separator-contai.premium-lottie-animation:hover svg' );
		$css->add_property( 'fill', $icon_HoverColor );
		$css->add_property( 'color', $icon_HoverColor );
		$css->set_selector( '.' . $unique_id . ' > .premium-image-separator-container'  . ' > .premium-image-separator-icon:not(.icon-type-fe)' . ' > svg:hover *' );
		$css->add_property( 'fill', $icon_HoverColor );
		$css->set_selector( '.' . $unique_id . ' > .premium-image-separator-container'  . ' > #premium-image-separator-svg-' . $unique_id . ' > svg:hover *' );
		$css->add_property( 'fill', $icon_HoverColor );
	}

	if ( isset( $attr['iconHoverBG'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-image-separator-container  .premium-image-separator-icon:hover' );
		$css->render_background( $attr['iconHoverBG'], 'Desktop' );
		$css->set_selector( '.' . $unique_id . ' > .premium-image-separator-container'  . ' > #premium-image-separator-svg-' . $unique_id . ' > svg:hover' );
		$css->render_background( $attr['iconHoverBG'], 'Desktop' );
		$css->set_selector( '.' . $unique_id . ' .premium-image-separator-container  .premium-lottie-animation:hover svg' );
		$css->render_background( $attr['iconHoverBG'], 'Desktop' );
	}

	if ( isset( $attr['borderHoverColor'] ) && ! empty( $attr['borderHoverColor'] ) ) {
		$hover_border = $attr['borderHoverColor'];
		$css->set_selector( '.' . $unique_id . ' .premium-image-separator-container  .premium-image-separator-icon:hover' );
		$css->add_property( 'border-color', "{$hover_border}!important" );

		$css->set_selector( '.' . $unique_id . ' > .premium-image-separator-container'  . ' > #premium-image-separator-svg-' . $unique_id . ' > svg:hover' );
		$css->add_property( 'border-color', "{$hover_border}!important" );

		$css->set_selector( '.' . $unique_id . ' .premium-image-separator-container  .premium-lottie-animation:hover svg' );
		$css->add_property( 'border-color', "{$hover_border}!important" );
	}

	if ( isset( $attr['imgHeight'] ) ) {
		$css->set_selector( '.' . $unique_id . '> .premium-image-separator-container' . ' > img' );
		$css->add_property( 'height', $css->render_range( $attr['imgHeight'], 'Desktop' ) );
	}
	if ( isset( $attr['imgFilterHover'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-image-separator-container:hover img' );
		$css->add_property( 'filter', 'brightness(' . $attr['imgFilterHover']['bright'] . '%)' . 'contrast(' . $attr['imgFilterHover']['contrast'] . '%) ' . 'saturate(' . $attr['imgFilterHover']['saturation'] . '%) ' . 'blur(' . $attr['imgFilterHover']['blur'] . 'px) ' . 'hue-rotate(' . $attr['imgFilterHover']['hue'] . 'deg)' );
	}

	if ( isset( $attr['iconStyles'][0]['advancedBorder'] ) ) {
		$css->set_selector( '.' . $unique_id . '> .premium-image-separator-container'   . '> img' );
		$css->add_property( 'border-radius', $attr['iconStyles'][0]['advancedBorder'] ? $attr['iconStyles'][0]['advancedBorderValue'] . '!important' : '' );

		$css->set_selector( '.' . $unique_id . '> .premium-image-separator-container'   . '> .premium-image-separator-icon' );
		$css->add_property( 'border-radius', $attr['iconStyles'][0]['advancedBorder'] ? $attr['iconStyles'][0]['advancedBorderValue'] . '!important' : '' );

		$css->set_selector( '.' . $unique_id . '> .premium-image-separator-container'   . '> .premium-image-separator-svg-class svg' );
		$css->add_property( 'border-radius', $attr['iconStyles'][0]['advancedBorder'] ? $attr['iconStyles'][0]['advancedBorderValue'] . '!important' : '' );

		$css->set_selector( '.' . $unique_id . '> .premium-image-separator-container'  . '> .premium-lottie-animation svg' );
		$css->add_property( 'border-radius', $attr['iconStyles'][0]['advancedBorder'] ? $attr['iconStyles'][0]['advancedBorderValue'] . '!important' : '' );
	}

	$css->start_media_query( 'tablet' );

	// container style
        $content_align      = $css->get_responsive_css( $attr['iconAlign'], 'Tablet' );
		$content_flex_align = 'left' === $content_align ? 'flex-start' : 'center';
		$content_flex_align = 'right' === $content_align ? 'flex-end' : $content_flex_align;
		$css->set_selector( '.' . $unique_id );
		$css->add_property( 'text-align',$content_align );
        $css->add_property( 'align-self', $css->render_align_self($content_align) );


	if ( isset( $attr['iconAlign'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-image-separator-container' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['iconAlign'], 'Tablet' ) );
	}

	// Icon Style.
	if ( isset( $attr['imgWidth'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-image-separator-container'  . ' > .premium-image-separator-icon' );
		$css->add_property( 'font-size', $css->render_string( $css->render_range( $attr['imgWidth'], 'Tablet' ), '!important' ) );

		$css->set_selector( '.' . $unique_id . ' > .premium-image-separator-container'  . ' > .premium-image-separator-icon' . ' > svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['imgWidth'], 'Tablet' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['imgWidth'], 'Tablet' ), '!important' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-image-separator-container  .premium-image-separator-svg-class svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['imgWidth'], 'Tablet' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['imgWidth'], 'Tablet' ), '!important' ) );
	}
	if ( isset( $attr['iconMargin'] ) ) {
		$icon_margin = $attr['iconMargin'];
		$css->set_selector( '.' . $unique_id . ' > .premium-image-separator-container'  . ' > .premium-image-separator-icon, ' . '.' . $unique_id . ' > .premium-image-separator-container'  . ' > img, ' . '.' . $unique_id . ' > .premium-image-separator-container'  . ' > #premium-image-separator-svg-' . $unique_id . ' > svg, ' . '.' . $unique_id . ' > .premium-image-separator-container'  . ' > .premium-lottie-animation' . ' > svg' );
		$css->add_property( 'margin', $css->render_spacing( $icon_margin['Tablet'],isset( $icon_margin['unit']['Tablet'])?$icon_margin['unit']['Tablet']:$icon_margin['unit'] ) );

	}
	if ( isset( $attr['iconPadding'] ) ) {
		$icon_padding = $attr['iconPadding'];
		$css->set_selector( '.' . $unique_id . ' > .premium-image-separator-container'  . ' > .premium-image-separator-icon, ' . '.' . $unique_id . ' > .premium-image-separator-container'  . ' > img, ' . '.' . $unique_id . ' > .premium-image-separator-container'  . ' > #premium-image-separator-svg-' . $unique_id . ' > svg, ' . '.' . $unique_id . ' > .premium-image-separator-container'  . ' > .premium-lottie-animation' . ' > svg' );
		$css->add_property( 'padding', $css->render_spacing( $icon_padding['Tablet'],isset( $icon_padding['unit']['Tablet'])?$icon_padding['unit']['Tablet']:$icon_padding['unit'] ) );
	}
	if ( isset( $attr['iconBorder'] ) && ( isset( $attr['iconStyles'] ) && ( $attr['iconStyles'][0]['advancedBorder'] ) == false ) ) {
		$icon_border        = $attr['iconBorder'];
		$icon_border_width  = $icon_border['borderWidth'];
		$icon_border_radius = $icon_border['borderRadius'];
		$css->set_selector( '.' . $unique_id . ' .premium-image-separator-container  .premium-image-separator-icon, ' . '.' . $unique_id . ' > .premium-image-separator-container'  . ' > img, ' . '.' . $unique_id . ' > .premium-image-separator-container'  . ' > #premium-image-separator-svg-' . $unique_id . ' > svg, ' . '.' . $unique_id . ' > .premium-image-separator-container'  . ' > .premium-lottie-animation' . ' > svg' );
		$css->add_property( 'border-width', $css->render_spacing( $icon_border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $icon_border_radius['Tablet'], 'px' ) );
	}
	if ( isset( $attr['imgWidth'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-image-separator-container'  . ' > img' );
		$css->add_property( 'width', $css->render_range( $attr['imgWidth'], 'Tablet' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-image-separator-container  .premium-lottie-animation svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['imgWidth'], 'Tablet' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['imgWidth'], 'Tablet' ), '!important' ) );
	}

	if ( isset( $attr['imgHeight'] ) ) {
		$css->set_selector( '.' . $unique_id . '> .premium-image-separator-container'  . ' > img' );
		$css->add_property( 'height', $css->render_range( $attr['imgHeight'], 'Tablet' ) );
	}

	if ( isset( $attr['iconBG'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-image-separator-container  .premium-image-separator-icon' );
		$css->render_background( $attr['iconBG'], 'Tablet' );
		$css->set_selector( '.' . $unique_id . ' > .premium-image-separator-container'  . ' > #premium-image-separator-svg-' . $unique_id . ' > svg ' );
		$css->render_background( $attr['iconBG'], 'Tablet' );
		$css->set_selector( '.' . $unique_id . ' > .premium-image-separator-container'  . ' > .premium-lottie-animation' . ' > svg ' );
		$css->render_background( $attr['iconBG'], 'Tablet' );
	}

	if ( isset( $attr['iconHoverBG'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-image-separator-container  .premium-image-separator-icon:hover' );
		$css->render_background( $attr['iconHoverBG'], 'Tablet' );
		$css->set_selector( '.' . $unique_id . ' > .premium-image-separator-container'  . ' > #premium-image-separator-svg-' . $unique_id . ' > svg:hover' );
		$css->render_background( $attr['iconHoverBG'], 'Tablet' );
		$css->set_selector( '.' . $unique_id . ' .premium-image-separator-container  .premium-lottie-animation:hover svg' );
		$css->render_background( $attr['iconHoverBG'], 'Tablet' );
	}

	$css->stop_media_query();
	$css->start_media_query( 'mobile' );

	// container style
	if ( isset( $attr['iconAlign'] ) ) {
        $content_align      = $css->get_responsive_css( $attr['iconAlign'], 'Mobile' );
		$content_flex_align = 'left' === $content_align ? 'flex-start' : 'center';
		$content_flex_align = 'right' === $content_align ? 'flex-end' : $content_flex_align;
		$css->set_selector( '.' . $unique_id );
		$css->add_property( 'text-align',$content_align );
        $css->add_property( 'align-self', $css->render_align_self($content_align) );

	}

	if ( isset( $attr['iconAlign'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-image-separator-container' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['iconAlign'], 'Mobile' ) );
	}

	// Icon Style.
	if ( isset( $attr['imgWidth'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-image-separator-container'  . ' > .premium-image-separator-icon' );
		$css->add_property( 'font-size', $css->render_string( $css->render_range( $attr['imgWidth'], 'Mobile' ), '!important' ) );

		$css->set_selector( '.' . $unique_id . ' > .premium-image-separator-container'  . ' > .premium-image-separator-icon' . ' > svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['imgWidth'], 'Mobile' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['imgWidth'], 'Mobile' ), '!important' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-image-separator-container  .premium-image-separator-svg-class svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['imgWidth'], 'Mobile' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['imgWidth'], 'Mobile' ), '!important' ) );
	}
	if ( isset( $attr['iconMargin'] ) ) {
		$icon_margin = $attr['iconMargin'];
		$css->set_selector( '.' . $unique_id . ' > .premium-image-separator-container'  . ' > .premium-image-separator-icon, ' . '.' . $unique_id . ' > .premium-image-separator-container'  . ' > img, ' . '.' . $unique_id . ' > .premium-image-separator-container'  . ' > #premium-image-separator-svg-' . $unique_id . ' > svg, ' . '.' . $unique_id . ' > .premium-image-separator-container'  . ' > .premium-lottie-animation' . ' > svg' );
		$css->add_property( 'margin', $css->render_spacing( $icon_margin['Mobile'],isset( $icon_margin['unit']['Mobile'])?$icon_margin['unit']['Mobile']:$icon_margin['unit'] ) );
	}
	if ( isset( $attr['iconPadding'] ) ) {
		$icon_padding = $attr['iconPadding'];
		$css->set_selector( '.' . $unique_id . ' > .premium-image-separator-container'  . ' > .premium-image-separator-icon, ' . '.' . $unique_id . ' > .premium-image-separator-container'  . ' > img, ' . '.' . $unique_id . ' > .premium-image-separator-container'  . ' > #premium-image-separator-svg-' . $unique_id . ' > svg, ' . '.' . $unique_id . ' > .premium-image-separator-container'  . ' > .premium-lottie-animation' . ' > svg' );
		$css->add_property( 'padding', $css->render_spacing( $icon_padding['Mobile'],isset( $icon_padding['unit']['Mobile'])?$icon_padding['unit']['Mobile']:$icon_padding['unit'] ) );
	}
	if ( isset( $attr['iconBorder'] ) && ( isset( $attr['iconStyles'] ) && ( $attr['iconStyles'][0]['advancedBorder'] ) == false ) ) {
		$icon_border        = $attr['iconBorder'];
		$icon_border_width  = $icon_border['borderWidth'];
		$icon_border_radius = $icon_border['borderRadius'];
		$css->set_selector( '.' . $unique_id . ' .premium-image-separator-container  .premium-image-separator-icon, ' . '.' . $unique_id . ' > .premium-image-separator-container'  . ' > img, ' . '.' . $unique_id . ' > .premium-image-separator-container'  . ' > #premium-image-separator-svg-' . $unique_id . ' > svg, ' . '.' . $unique_id . ' > .premium-image-separator-container'  . ' > .premium-lottie-animation' . ' > svg' );
		$css->add_property( 'border-width', $css->render_spacing( $icon_border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $icon_border_radius['Mobile'], 'px' ) );
	}
	if ( isset( $attr['imgWidth'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-image-separator-container'  . ' > img' );
		$css->add_property( 'width', $css->render_range( $attr['imgWidth'], 'Mobile' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-image-separator-container  .premium-lottie-animation svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['imgWidth'], 'Mobile' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['imgWidth'], 'Mobile' ), '!important' ) );
	}

	if ( isset( $attr['imgHeight'] ) ) {
		$css->set_selector( '.' . $unique_id . '> .premium-image-separator-container'  . ' > img' );
		$css->add_property( 'height', $css->render_range( $attr['imgHeight'], 'Mobile' ) );
	}

	if ( isset( $attr['iconBG'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-image-separator-container  .premium-image-separator-icon' );
		$css->render_background( $attr['iconBG'], 'Mobile' );
		$css->set_selector( '.' . $unique_id . ' > .premium-image-separator-container'  . ' > #premium-image-separator-svg-' . $unique_id . ' > svg ' );
		$css->render_background( $attr['iconBG'], 'Mobile' );
		$css->set_selector( '.' . $unique_id . ' > .premium-image-separator-container'  . ' > .premium-lottie-animation' . ' > svg ' );
		$css->render_background( $attr['iconBG'], 'Mobile' );
	}

	if ( isset( $attr['iconHoverBG'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-image-separator-contai.premium-image-separator-icon:hover' );
		$css->render_background( $attr['iconHoverBG'], 'Mobile' );
		$css->set_selector( '.' . $unique_id . ' > .premium-image-separator-container'  . ' > #premium-image-separator-svg-' . $unique_id . ' > svg:hover' );
		$css->render_background( $attr['iconHoverBG'], 'Mobile' );
		$css->set_selector( '.' . $unique_id . ' .premium-image-separator-contai.premium-lottie-animation:hover svg' );
		$css->render_background( $attr['iconHoverBG'], 'Mobile' );
	}

	$css->stop_media_query();
	return $css->css_output();
}

/**
 * Renders the `premium/image-separator` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_image_separator( $attributes, $content, $block ) {
	$block_helpers = pbg_blocks_helper();

	// Enqueue frontend JS/CSS.
	if ( $block_helpers->it_is_not_amp() ) {
		wp_enqueue_script(
			'pbg-image-separator',
			PREMIUM_BLOCKS_URL . 'assets/js/minified/image-separator.min.js',
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
 * Register the image_separator block.
 *
 * @uses render_block_pbg_image_separator()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_image_separator() {
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	register_block_type(
		PREMIUM_BLOCKS_PATH . '/blocks-config/image-separator',
		array(
			'render_callback' => 'render_block_pbg_image_separator',
		)
	);
}

register_block_pbg_image_separator();
