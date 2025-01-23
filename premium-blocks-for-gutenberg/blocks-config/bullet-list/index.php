<?php
/**
 * Server-side rendering of the `pbg/bullet-list` block.
 *
 * @package WordPress
 */

/**
 * Get Bullet List Block CSS
 *
 * Return Frontend CSS for Bullet List.
 *
 * @access public
 *
 * @param string $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_bullet_list_css_style( $attr, $unique_id ) {
	$css = new Premium_Blocks_css();

	// Style for wrapper.
	if ( isset( $attr['generalStyles'] ) && isset( $attr['generalStyles'][0]['generalBackgroundColor'] ) ) {
		$general_styles = $attr['generalStyles'][0];
		$css->set_selector( ".{$unique_id} > .premium-bullet-list > .premium-bullet-list__wrapper" );
		$css->add_property( 'background-color', $css->render_color( $general_styles['generalBackgroundColor'] ) );

		$css->set_selector( ".{$unique_id} .premium-bullet-list__wrapper:hover" );
		$css->add_property( 'background-color', $css->render_color( $general_styles['generalHoverBackgroundColor'] ) );
	}

	if ( isset( $attr['boxShadow'] ) ) {
		$box_shadow = $attr['boxShadow'];
		$css->set_selector( ".{$unique_id} .premium-bullet-list__wrapper" );
		$css->add_property( 'box-shadow', $css->render_shadow( $box_shadow ) );
	}

	if ( isset( $attr['hoverBoxShadow'] ) ) {
		$hover_box_shadow = $attr['hoverBoxShadow'];
		$css->set_selector( ".{$unique_id} .premium-bullet-list__wrapper:hover" );
		$css->add_property( 'box-shadow', $css->render_shadow( $hover_box_shadow ) );
	}

	// Align.
	if ( isset( $attr['bulletAlign'] ) ) {
		$align      = $css->get_responsive_css( $attr['bulletAlign'], 'Desktop' );
		$flex_align = 'left' === $align ? 'flex-start' : 'center';
		$flex_align = 'right' === $align ? 'flex-end' : $flex_align;

		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__icon-wrap' );
		$css->add_property( 'align-self',  $css->render_align_self($align) );
		$css->add_property( 'text-align', $align );
		$css->add_property( 'justify-content', $align );
		$css->add_property( 'align-items', $align );
		$css->add_property( 'align-self', $align );

	}

	if ( isset( $attr['align'] ) ) {
		$icon_position      = $attr['iconPosition'];
		$content_align      = $css->get_responsive_css( $attr['align'], 'Desktop' );
		$content_flex_align = 'left' === $content_align ? 'flex-start' : 'center';
		$content_flex_align = 'right' === $content_align ? 'flex-end' : $content_flex_align;

		$content_flex_direction = 'right' === $content_align ? 'column' : 'column';
		$content_flex_position  = 'after' === $icon_position ? 'row-reverse' : '';
		$content_flex_direction = 'top' === $icon_position ? $content_flex_direction : $content_flex_position;

		$css->set_selector( '.' . $unique_id );
		$css->add_property( 'text-align', $content_align );
        $css->add_property( 'align-self',  $css->render_align_self($content_align) );
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list' );
		$css->add_property( 'justify-content', $content_flex_align );
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__wrapper' );
		$css->add_property( 'justify-content', $css->render_align_self($content_align) );
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__content-wrap' );
		$css->add_property( 'justify-content', $content_flex_align );
		$css->add_property( 'flex-direction', $content_flex_direction );
	}

	// Style for list.
	if ( isset( $attr['generalpadding'] ) ) {
		$general_padding = $attr['generalpadding'];
		$css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' );
		$css->add_property( 'padding', $css->render_spacing( $general_padding['Desktop'],isset( $general_padding['unit']['Desktop'])?$general_padding['unit']['Desktop']:$general_padding['unit'] ) );
	}

	if ( isset( $attr['generalmargin'] ) ) {
		$general_margin = $attr['generalmargin'];
		$css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' );
		$css->add_property( 'margin', $css->render_spacing( $general_margin['Desktop'],isset( $general_margin['unit']['Desktop'] )?$general_margin['unit']['Desktop']:$general_margin['unit']) );
	}

	if ( isset( $attr['generalBorder'] ) ) {
		$general_border        = $attr['generalBorder'];
		$general_border_width  = $general_border['borderWidth'];
		$general_border_radius = $general_border['borderRadius'];

		$css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' );
		$css->add_property( 'border-width', $css->render_spacing( $general_border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $general_border_radius['Desktop'], 'px' ) );
		$css->add_property( 'border-style', $css->render_color( $general_border['borderType'] ?? 'none' ) );
		if(isset($general_border['borderColor'])){
			$css->add_property( 'border-color', $css->render_color( $general_border['borderColor'] ) );

		}
		$css->add_property( 'overflow', 'hidden' );
	}

	if ( isset( $attr['itempadding'] ) ) {
		$general_padding = $attr['itempadding'];
		$css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' . '> .premium-bullet-list__wrapper' );
		$css->add_property( 'padding', $css->render_spacing( $general_padding['Desktop'],isset( $general_padding['unit']['Desktop'])?$general_padding['unit']['Desktop']:$general_padding['unit'] ) );
	}

	if ( isset( $attr['itemmargin'] ) ) {
		$general_margin = $attr['itemmargin'];
		$css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' . '> .premium-bullet-list__wrapper' );
		$css->add_property( 'margin', $css->render_spacing( $general_margin['Desktop'],isset( $general_margin['unit']['Desktop'] )?$general_margin['unit']['Desktop']:$general_margin['unit']) );
	}

	// Style for icon.
	if ( isset( $attr['iconPosition'] ) ) {
		$icon_position = $attr['iconPosition'];
		$css->set_selector( ".{$unique_id} .premium-bullet-list__content-wrap" );
		$css->add_property( 'display', 'before' === $icon_position ? 'flex' : 'inline-flex' );
	}

	if ( isset( $attr['iconSize'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__content-icon .premium-bullet-list-icon' );
		$css->add_property( 'font-size', $css->render_string( $css->render_range( $attr['iconSize'], 'Desktop' ), '!important' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__content-icon .premium-bullet-list-icon svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Desktop' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Desktop' ), '!important' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Desktop' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Desktop' ), '!important' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__icon-wrap img' );
		$css->add_property( 'width', $css->render_range( $attr['iconSize'], 'Desktop' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-lottie-animation svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Desktop' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Desktop' ), '!important' ) );
	}

	// common icon type style
	if ( isset( $attr['iconMargin'] ) ) {
		$icon_margin = $attr['iconMargin'];
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__content-icon .premium-bullet-list-icon, ' . '.' . $unique_id . ' .premium-bullet-list__icon-wrap img, ' . '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg, ' . '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-lottie-animation svg' );
		$css->add_property( 'margin', $css->render_spacing( $icon_margin['Desktop'], isset($icon_margin['unit']['Desktop'])?$icon_margin['unit']['Desktop']:$icon_margin['unit'] ) );
	}
	if ( isset( $attr['iconPadding'] ) ) {
		$icon_padding = $attr['iconPadding'];
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__content-icon .premium-bullet-list-icon, ' . '.' . $unique_id . ' .premium-bullet-list__icon-wrap img, ' . '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg, ' . '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-lottie-animation svg' );
		$css->add_property( 'padding', $css->render_spacing( $icon_padding['Desktop'],isset( $icon_padding['unit']['Desktop'])?$icon_padding['unit']['Desktop']:$icon_padding['unit'] ) );
	}
	if ( isset( $attr['iconBorder'] ) ) {
		$icon_border        = $attr['iconBorder'];
		$icon_border_width  = $icon_border['borderWidth'];
		$icon_border_radius = $icon_border['borderRadius'];
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__content-icon .premium-bullet-list-icon, ' . '.' . $unique_id . ' .premium-bullet-list__icon-wrap img, ' . '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg, ' . '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-lottie-animation svg' );
		$css->add_property( 'border-width', $css->render_spacing( $icon_border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $icon_border_radius['Desktop'], 'px' ) );
		$css->add_property( 'border-style', $css->render_string( $css->render_color( $icon_border['borderType'] ), '!important' ) );
		if(isset($icon_border['borderColor'])){
			$css->add_property( 'border-color', $css->render_color( $icon_border['borderColor'] ) );
		}
	}

	// svg styles
	if ( isset( $attr['iconColor'] ) ) {
		$icon_color = $attr['iconColor'];
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__content-icon .premium-bullet-list-icon' );
		$css->add_property( 'fill', $css->render_color( $icon_color ) );
		$css->add_property( 'color', $css->render_color( $icon_color ) );
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__content-icon .premium-bullet-list-icon:not(.icon-type-fe) svg' );
		$css->add_property( 'fill', $css->render_color( $icon_color ) );
		$css->add_property( 'color', $css->render_color( $icon_color ) );
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg' );
		$css->add_property( 'fill', $css->render_color( $icon_color ) );
		$css->add_property( 'color', $css->render_color( $icon_color ) );
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__content-icon .premium-bullet-list-icon:not(.icon-type-fe) svg *' );
		$css->add_property( 'fill', $css->render_color( $icon_color ) );
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg *' );
		$css->add_property( 'fill', $css->render_color( $icon_color ) );
	}

	if ( isset( $attr['iconBG'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__content-icon .premium-bullet-list-icon ,' . '.' . $unique_id . ' .premium-bullet-list__icon-wrap img '  );
		$css->render_background( $attr['iconBG'], 'Desktop' );
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg ' );
		$css->render_background( $attr['iconBG'], 'Desktop' );
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-lottie-animation svg' );
		$css->render_background( $attr['iconBG'], 'Desktop' );
	}

	if ( isset( $attr['iconHoverColor'] ) ) {
		$icon_HoverColor = $attr['iconHoverColor'];
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-bullet-list-icon' );
		$css->add_property( 'fill', $css->render_color( $icon_HoverColor ) );
		$css->add_property( 'color', $css->render_color( $icon_HoverColor ) );
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-list-item-svg-class svg' );
		$css->add_property( 'fill', $css->render_color( $icon_HoverColor ) );
		$css->add_property( 'color', $css->render_color( $icon_HoverColor ) );
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-bullet-list-icon:not(.icon-type-fe) svg *' );
		$css->add_property( 'fill', $css->render_color( $icon_HoverColor ) );
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-list-item-svg-class svg *' );
		$css->add_property( 'fill', $css->render_color( $icon_HoverColor ) );
	}

	if ( isset( $attr['iconHoverBG'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-bullet-list-icon' );
		$css->render_background( $attr['iconHoverBG'], 'Desktop' );
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-list-item-svg-class svg' );
		$css->render_background( $attr['iconHoverBG'], 'Desktop' );
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-lottie-animation svg' );
		$css->render_background( $attr['iconHoverBG'], 'Desktop' );
	}

	if ( isset( $attr['borderHoverColor'] ) ) {
		$hover_border = $attr['borderHoverColor'];
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-bullet-list-icon' );
		$css->add_property( 'border-color', $css->render_string( $css->render_color( $hover_border ), '!important' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-list-item-svg-class svg' );
		$css->add_property( 'border-color', $css->render_string( $css->render_color( $hover_border ), '!important' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-lottie-animation svg' );
		$css->add_property( 'border-color', $css->render_string( $css->render_color( $hover_border ), '!important' ) );
	}

	if ( isset( $attr['bulletAlign'] ) ) {
		$align      = $css->get_responsive_css( $attr['bulletAlign'], 'Desktop' );
		$flex_align = 'flex-start' === $align ? 'top' : 'middle';
		$flex_align = $align === 'flex-end' ? 'bottom' : $flex_align;

		$css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' . '> .premium-bullet-list__wrapper' . ' > .premium-bullet-list__content-wrap' . ' > .premium-bullet-list__icon-wrap' . ' > .premium-bullet-list__content-icon' . ' > .premium-bullet-list-icon, ' . $unique_id . ' > .premium-bullet-list' . '> .premium-bullet-list__wrapper' . ' > .premium-bullet-list__content-wrap' . ' > .premium-bullet-list__icon-wrap' . ' > img, ' . $unique_id . ' > .premium-bullet-list' . '> .premium-bullet-list__wrapper' . ' > a' . ' > .premium-bullet-list__content-wrap' . ' > .premium-bullet-list__icon-wrap' . ' > .premium-bullet-list__content-icon' . ' > .premium-bullet-list-icon, ' . $unique_id . ' > .premium-bullet-list' . '> .premium-bullet-list__wrapper' . ' > a' . ' > .premium-bullet-list__content-wrap' . ' > .premium-bullet-list__icon-wrap' . ' > img' );
		$css->add_property( 'vertical-align', $flex_align );
	}

	// Style for title.
	if ( isset( $attr['titleStyles'] ) && isset( $attr['titleStyles'][0] ) ) {
		$title_styles = $attr['titleStyles'][0];
		$css->set_selector( ".{$unique_id} .premium-bullet-list__label" );
		$css->add_property( 'color', $css->render_color( $title_styles['titleColor'] ) );

		$css->set_selector( ".{$unique_id} .premium-bullet-list__wrapper:hover .premium-bullet-list__label-wrap .premium-bullet-list__label" );
		$css->add_property( 'color', $css->render_string( $css->render_color( $title_styles['titleHoverColor'] ), '!important' ) );
	}

	if ( isset( $attr['titlesTextShadow'] ) ) {
		$titles_shadow = $attr['titlesTextShadow'];
		$css->set_selector( ".{$unique_id} .premium-bullet-list__label" );
		$css->add_property( 'text-shadow', $css->render_shadow( $titles_shadow ) );
	}

	if ( isset( $attr['titleTypography'] ) ) {
		$title_typography = $attr['titleTypography'];

		$css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' . '> .premium-bullet-list__wrapper' . ' > .premium-bullet-list__content-wrap' . ' > .premium-bullet-list__label-wrap' );
		$css->render_typography( $title_typography, 'Desktop' );
		$css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' . '> .premium-bullet-list__wrapper' . ' > a' . ' > .premium-bullet-list__content-wrap' . ' > .premium-bullet-list__label-wrap' );
		$css->render_typography( $title_typography, 'Desktop' );
	}

	if ( isset( $attr['titlemargin'] ) ) {
		$title_margin = $attr['titlemargin'];
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__label-wrap');
		$css->add_property( 'margin', $css->render_spacing( $title_margin['Desktop'], isset($title_margin['unit']['Desktop'])?$title_margin['unit']['Desktop']:$title_margin['unit'] ) );
	}

	// style for divider
	if ( isset( $attr['dividerStyle'] ) ) {
		$divider_style = $attr['dividerStyle'];
		$css->set_selector( ".{$unique_id} .premium-bullet-list-divider-block:not(:last-child)::after" );
		$css->add_property( 'border-top-style', $divider_style );

		$css->set_selector( ".{$unique_id} .premium-bullet-list-divider-inline:not(:last-child)::after" );
		$css->add_property( 'border-left-style', $divider_style );
	}

	if ( isset( $attr['dividerStyles'] ) && isset( $attr['dividerStyles'][0] ) ) {
		$divider_styles = $attr['dividerStyles'][0];
		$css->set_selector( ".{$unique_id} .premium-bullet-list-divider-block:not(:last-child)::after" );
		$css->add_property( 'border-top-color', $divider_styles['dividerColor'] );

		$css->set_selector( ".{$unique_id} .premium-bullet-list-divider-inline:not(:last-child)::after" );
		$css->add_property( 'border-left-color', $divider_styles['dividerColor'] );
	}

	if ( isset( $attr['dividerWidth'] ) ) {
		$divider_width = $attr['dividerWidth'];
		$css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' . '> .premium-bullet-list-divider-block:not(:last-child):after' );
		$css->add_property( 'width', $css->render_range( $divider_width, 'Desktop' ) );
	}

	if ( isset( $attr['dividerHeight'] ) ) {
		$divider_height = $attr['dividerHeight'];
		$css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' . '> .premium-bullet-list-divider-block:not(:last-child):after' );
		$css->add_property( 'border-top-width', $css->render_range( $divider_height, 'Desktop' ) );
	}

	if ( isset( $attr['dividerWidth'] ) ) {
		$divider_width = $attr['dividerWidth'];
		$css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' . '> .premium-bullet-list-divider-inline:not(:last-child):after' );
		$css->add_property( 'border-left-width', $css->render_range( $divider_width, 'Desktop' ) );
	}

	if ( isset( $attr['dividerHeight'] ) ) {
		$divider_height = $attr['dividerHeight'];
		$css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' . '> .premium-bullet-list-divider-inline:not(:last-child):after' );
		$css->add_property( 'height', $css->render_range( $divider_height, 'Desktop' ) );
	}

	$css->start_media_query( 'tablet' );

	// Align.
	if ( isset( $attr['bulletAlign'] ) ) {
		$align      = $css->get_responsive_css( $attr['bulletAlign'], 'Tablet' );
		$flex_align = 'left' === $align ? 'flex-start' : 'center';
		$flex_align = 'right' === $align ? 'flex-end' : $flex_align;

		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__icon-wrap' );
		$css->add_property( 'align-self',  $css->render_align_self($align) );
		$css->add_property( 'text-align', $align );
		$css->add_property( 'justify-content', $align );
		$css->add_property( 'align-items', $align );
		$css->add_property( 'align-self', $align );

	}

	if ( isset( $attr['align'] ) ) {
		$content_align      = $css->get_responsive_css( $attr['align'], 'Tablet' );
		$content_flex_align = 'left' === $content_align ? 'flex-start' : 'center';
		$content_flex_align = 'right' === $content_align ? 'flex-end' : $content_flex_align;

		$content_flex_direction = 'right' === $content_align ? 'column' : 'column';
		$content_flex_position  = 'after' === $icon_position ? 'row-reverse' : '';
		$content_flex_direction = 'top' === $icon_position ? $content_flex_direction : $content_flex_position;

		$css->set_selector( '.' . $unique_id );
		$css->add_property( 'text-align', $content_align );
        $css->add_property( 'align-self',  $css->render_align_self($content_align) );
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list' );
		$css->add_property( 'justify-content', $content_flex_align );
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__wrapper' );
		$css->add_property( 'justify-content', $content_flex_align );
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__content-wrap' );
		$css->add_property( 'justify-content', $content_flex_align );
		$css->add_property( 'flex-direction', $content_flex_direction );
	}
	// Style for image.
	if ( isset( $attr['generalpadding'] ) ) {
		$general_padding = $attr['generalpadding'];
		$css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' );
		$css->add_property( 'padding', $css->render_spacing( $general_padding['Tablet'],isset( $general_padding['unit']['Tablet'] )?$general_padding['unit']['Tablet']:$general_padding['unit']) );
	}

	if ( isset( $attr['generalmargin'] ) ) {
		$general_margin = $attr['generalmargin'];
		$css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' );
		$css->add_property( 'margin', $css->render_spacing( $general_margin['Tablet'], isset($general_margin['unit']['Tablet'])?$general_margin['unit']['Tablet']:$general_margin['unit'] ) );
	}

	if ( isset( $attr['generalBorder'] ) ) {
		$general_border        = $attr['generalBorder'];
		$general_border_width  = $general_border['borderWidth'];
		$general_border_radius = $general_border['borderRadius'];

		$css->set_selector( '.' . $unique_id . ' > .premium-bullet-list'  );
		$css->add_property( 'border-width', $css->render_spacing( $general_border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $general_border_radius['Tablet'], 'px' ) );
	}

	if ( isset( $attr['itempadding'] ) ) {
		$general_padding = $attr['itempadding'];
		$css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' . '> .premium-bullet-list__wrapper' );
		$css->add_property( 'padding', $css->render_spacing( $general_padding['Tablet'],isset( $general_padding['unit']['Tablet'])?$general_padding['unit']['Tablet']:$general_padding['unit'] ) );
	}

	if ( isset( $attr['itemmargin'] ) ) {
		$general_margin = $attr['itemmargin'];
		$css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' . '> .premium-bullet-list__wrapper' );
		$css->add_property( 'margin', $css->render_spacing( $general_margin['Tablet'],isset( $general_margin['unit']['Tablet'] )?$general_margin['unit']['Tablet']:$general_margin['unit']) );
	}
	// style for link

	if ( isset( $attr['iconSize'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__content-icon .premium-bullet-list-icon' );
		$css->add_property( 'font-size', $css->render_string( $css->render_range( $attr['iconSize'], 'Tablet' ), '!important' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__content-icon .premium-bullet-list-icon svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Tablet' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Tablet' ), '!important' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Tablet' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Tablet' ), '!important' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__icon-wrap img' );
		$css->add_property( 'width', $css->render_range( $attr['iconSize'], 'Tablet' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-lottie-animation svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Tablet' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Tablet' ), '!important' ) );
	}

	// common icon type style
	if ( isset( $attr['iconMargin'] ) ) {
		$icon_margin = $attr['iconMargin'];
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__content-icon .premium-bullet-list-icon, ' . '.' . $unique_id . ' .premium-bullet-list__icon-wrap img, ' . '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg, ' . '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-lottie-animation svg' );
		$css->add_property( 'margin', $css->render_spacing( $icon_margin['Tablet'], isset($icon_margin['unit']['Tablet']) ?$icon_margin['unit']['Tablet']:$icon_margin['unit']) );
	}
	if ( isset( $attr['iconPadding'] ) ) {
		$icon_padding = $attr['iconPadding'];
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__content-icon .premium-bullet-list-icon, ' . '.' . $unique_id . ' .premium-bullet-list__icon-wrap img, ' . '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg, ' . '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-lottie-animation svg' );
		$css->add_property( 'padding', $css->render_spacing( $icon_padding['Tablet'],isset( $icon_padding['unit']['Tablet'])?$icon_padding['unit']['Tablet']:$icon_padding['unit'] ) );
	}
	if ( isset( $attr['iconBorder'] ) ) {
		$icon_border        = $attr['iconBorder'];
		$icon_border_width  = $icon_border['borderWidth'];
		$icon_border_radius = $icon_border['borderRadius'];
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__content-icon .premium-bullet-list-icon, ' . '.' . $unique_id . ' .premium-bullet-list__icon-wrap img, ' . '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg, ' . '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-lottie-animation svg' );
		$css->add_property( 'border-width', $css->render_spacing( $icon_border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $icon_border_radius['Tablet'], 'px' ) );
	}

	if ( isset( $attr['iconBG'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__content-icon .premium-bullet-list-icon' );
		$css->render_background( $attr['iconBG'], 'Tablet' );
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg ' );
		$css->render_background( $attr['iconBG'], 'Tablet' );
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-lottie-animation svg' );
		$css->render_background( $attr['iconBG'], 'Tablet' );
	}

	if ( isset( $attr['iconHoverBG'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-bullet-list-icon' );
		$css->render_background( $attr['iconHoverBG'], 'Tablet' );
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-list-item-svg-class svg' );
		$css->render_background( $attr['iconHoverBG'], 'Tablet' );
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-lottie-animation svg' );
		$css->render_background( $attr['iconHoverBG'], 'Tablet' );
	}

	if ( isset( $attr['bulletAlign'] ) ) {
		$align      = $css->get_responsive_css( $attr['bulletAlign'], 'Tablet' );
		$flex_align = 'flex-start' === $align ? 'top' : 'middle';
		$flex_align = $align === 'flex-end' ? 'bottom' : $flex_align;

		$css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' . '> .premium-bullet-list__wrapper' . ' > .premium-bullet-list__content-wrap' . ' > .premium-bullet-list__icon-wrap' . ' > .premium-bullet-list__content-icon' . ' > .premium-bullet-list-icon, ' . $unique_id . ' > .premium-bullet-list' . '> .premium-bullet-list__wrapper' . ' > .premium-bullet-list__content-wrap' . ' > .premium-bullet-list__icon-wrap' . ' > img, ' . $unique_id . ' > .premium-bullet-list' . '> .premium-bullet-list__wrapper' . ' > a' . ' > .premium-bullet-list__content-wrap' . ' > .premium-bullet-list__icon-wrap' . ' > .premium-bullet-list__content-icon' . ' > .premium-bullet-list-icon, ' . $unique_id . ' > .premium-bullet-list' . '> .premium-bullet-list__wrapper' . ' > a' . ' > .premium-bullet-list__content-wrap' . ' > .premium-bullet-list__icon-wrap' . ' > img' );
		$css->add_property( 'vertical-align', $flex_align );
	}

	// Style for title.
	if ( isset( $attr['titleTypography'] ) ) {
		$title_typography = $attr['titleTypography'];

		$css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' . '> .premium-bullet-list__wrapper' . ' > .premium-bullet-list__content-wrap' . ' > .premium-bullet-list__label-wrap' );
		$css->render_typography( $title_typography, 'Tablet' );
		$css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' . '> .premium-bullet-list__wrapper' . ' > a' . ' > .premium-bullet-list__content-wrap' . ' > .premium-bullet-list__label-wrap' );
		$css->render_typography( $title_typography, 'Tablet' );
	}

	if ( isset( $attr['titlemargin'] ) ) {
		$title_margin = $attr['titlemargin'];
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__label-wrap');
		$css->add_property( 'margin', $css->render_spacing( $title_margin['Tablet'], isset( $title_margin['unit']['Tablet'])?$title_margin['unit']['Tablet']:$title_margin['unit'] ) );
	}

	// style for divider
	if ( isset( $attr['dividerWidth'] ) ) {
		$divider_width = $attr['dividerWidth'];
		$css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' . '> .premium-bullet-list-divider-block:not(:last-child):after' );
		$css->add_property( 'width', $css->render_range( $divider_width, 'Tablet' ) );
	}

	if ( isset( $attr['dividerHeight'] ) ) {
		$divider_height = $attr['dividerHeight'];
		$css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' . '> .premium-bullet-list-divider-block:not(:last-child):after' );
		$css->add_property( 'border-top-width', $css->render_range( $divider_height, 'Tablet' ) );
	}

	if ( isset( $attr['dividerWidth'] ) ) {
		$divider_width = $attr['dividerWidth'];
		$css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' . '> .premium-bullet-list-divider-inline:not(:last-child):after' );
		$css->add_property( 'border-left-width', $css->render_range( $divider_width, 'Tablet' ) );
	}

	if ( isset( $attr['dividerHeight'] ) ) {
		$divider_height = $attr['dividerHeight'];
		$css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' . '> .premium-bullet-list-divider-inline:not(:last-child):after' );
		$css->add_property( 'height', $css->render_range( $divider_height, 'Tablet' ) );
	}

	$css->stop_media_query();

	$css->start_media_query( 'mobile' );

	// Align.
	if ( isset( $attr['bulletAlign'] ) ) {
		$align      = $css->get_responsive_css( $attr['bulletAlign'], 'Mobile' );
		$flex_align = 'left' === $align ? 'flex-start' : 'center';
		$flex_align = 'right' === $align ? 'flex-end' : $flex_align;

		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__icon-wrap' );
		$css->add_property( 'align-self',  $css->render_align_self($align) );
		$css->add_property( 'text-align', $align );
		$css->add_property( 'justify-content', $align );
		$css->add_property( 'align-items', $align );
		$css->add_property( 'align-self', $align );

	}

	if ( isset( $attr['align'] ) ) {
		$content_align      = $css->get_responsive_css( $attr['align'], 'Mobile' );
		$content_flex_align = 'left' === $content_align ? 'flex-start' : 'center';
		$content_flex_align = 'right' === $content_align ? 'flex-end' : $content_flex_align;

		$content_flex_direction = 'right' === $content_align ? 'column' : 'column';
		$content_flex_position  = 'after' === $icon_position ? 'row-reverse' : '';
		$content_flex_direction = 'top' === $icon_position ? $content_flex_direction : $content_flex_position;

		$css->set_selector( '.' . $unique_id );
		$css->add_property( 'text-align', $content_align );
        $css->add_property( 'align-self', $css->render_align_self($content_align) );
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list' );
		$css->add_property( 'justify-content', $content_flex_align );
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__wrapper' );
		$css->add_property( 'justify-content', $content_flex_align );
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__content-wrap' );
		$css->add_property( 'justify-content', $content_flex_align );
		$css->add_property( 'flex-direction', $content_flex_direction );
	}

	// Style for general setting.
	if ( isset( $attr['generalpadding'] ) ) {
		$general_padding = $attr['generalpadding'];
		$css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' );
		$css->add_property( 'padding', $css->render_spacing( $general_padding['Mobile'], isset( $general_padding['unit']['Mobile'])?$general_padding['unit']['Mobile']:$general_padding['unit'] ) );
	}

	if ( isset( $attr['generalmargin'] ) ) {
		$general_margin = $attr['generalmargin'];
		$css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' );
		$css->add_property( 'margin', $css->render_spacing( $general_margin['Mobile'], isset( $general_margin['unit']['Mobile'])?$general_margin['unit']['Mobile']:$general_margin['unit'] ) );
	}

	if ( isset( $attr['generalBorder'] ) ) {
		$general_border        = $attr['generalBorder'];
		$general_border_width  = $general_border['borderWidth'];
		$general_border_radius = $general_border['borderRadius'];

		$css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' );
		$css->add_property( 'border-width', $css->render_spacing( $general_border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $general_border_radius['Mobile'], 'px' ) );
	}

	if ( isset( $attr['itempadding'] ) ) {
		$general_padding = $attr['itempadding'];
		$css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' . '> .premium-bullet-list__wrapper' );
		$css->add_property( 'padding', $css->render_spacing( $general_padding['Mobile'],isset( $general_padding['unit']['Mobile'])?$general_padding['unit']['Mobile']:$general_padding['unit'] ) );
	}

	if ( isset( $attr['itemmargin'] ) ) {
		$general_margin = $attr['itemmargin'];
		$css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' . '> .premium-bullet-list__wrapper' );
		$css->add_property( 'margin', $css->render_spacing( $general_margin['Mobile'],isset( $general_margin['unit']['Mobile'] )?$general_margin['unit']['Mobile']:$general_margin['unit']) );
	}

	// style for link

	if ( isset( $attr['iconSize'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__content-icon .premium-bullet-list-icon' );
		$css->add_property( 'font-size', $css->render_string( $css->render_range( $attr['iconSize'], 'Mobile' ), '!important' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__content-icon .premium-bullet-list-icon svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Mobile' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Mobile' ), '!important' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Mobile' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Mobile' ), '!important' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__icon-wrap img' );
		$css->add_property( 'width', $css->render_range( $attr['iconSize'], 'Mobile' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-lottie-animation svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Mobile' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Mobile' ), '!important' ) );
	}

	// common icon type style
	if ( isset( $attr['iconMargin'] ) ) {
		$icon_margin = $attr['iconMargin'];
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__content-icon .premium-bullet-list-icon, ' . '.' . $unique_id . ' .premium-bullet-list__icon-wrap img, ' . '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg, ' . '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-lottie-animation svg' );
		$css->add_property( 'margin', $css->render_spacing( $icon_margin['Mobile'], isset( $icon_margin['unit']['Mobile'])?$icon_margin['unit']['Mobile']:$icon_margin['unit'] ) );
	}
	if ( isset( $attr['iconPadding'] ) ) {
		$icon_padding = $attr['iconPadding'];
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__content-icon .premium-bullet-list-icon, ' . '.' . $unique_id . ' .premium-bullet-list__icon-wrap img, ' . '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg, ' . '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-lottie-animation svg' );
		$css->add_property( 'padding', $css->render_spacing( $icon_padding['Mobile'],isset( $icon_padding['unit']['Mobile'])?$icon_padding['unit']['Mobile']:$icon_padding['unit'] ) );
	}
	if ( isset( $attr['iconBorder'] ) ) {
		$icon_border        = $attr['iconBorder'];
		$icon_border_width  = $icon_border['borderWidth'];
		$icon_border_radius = $icon_border['borderRadius'];
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__content-icon .premium-bullet-list-icon, ' . '.' . $unique_id . ' .premium-bullet-list__icon-wrap img, ' . '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg, ' . '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-lottie-animation svg' );
		$css->add_property( 'border-width', $css->render_spacing( $icon_border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $icon_border_radius['Mobile'], 'px' ) );
	}

	// svg styles

	if ( isset( $attr['iconBG'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__content-icon .premium-bullet-list-icon' );
		$css->render_background( $attr['iconBG'], 'Mobile' );
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg ' );
		$css->render_background( $attr['iconBG'], 'Mobile' );
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-lottie-animation svg' );
		$css->render_background( $attr['iconBG'], 'Mobile' );
	}

	if ( isset( $attr['iconHoverBG'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-bullet-list-icon' );
		$css->render_background( $attr['iconHoverBG'], 'Mobile' );
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-list-item-svg-class svg' );
		$css->render_background( $attr['iconHoverBG'], 'Mobile' );
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-lottie-animation svg' );
		$css->render_background( $attr['iconHoverBG'], 'Mobile' );
	}

	if ( isset( $attr['bulletAlign'] ) ) {
		$align      = $css->get_responsive_css( $attr['bulletAlign'], 'Mobile' );
		$flex_align = 'flex-start' === $align ? 'top' : 'middle';
		$flex_align = $align === 'flex-end' ? 'bottom' : $flex_align;

		$css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' . '> .premium-bullet-list__wrapper' . ' > .premium-bullet-list__content-wrap' . ' > .premium-bullet-list__icon-wrap' . ' > .premium-bullet-list__content-icon' . ' > .premium-bullet-list-icon, ' . $unique_id . ' > .premium-bullet-list' . '> .premium-bullet-list__wrapper' . ' > .premium-bullet-list__content-wrap' . ' > .premium-bullet-list__icon-wrap' . ' > img, ' . $unique_id . ' > .premium-bullet-list' . '> .premium-bullet-list__wrapper' . ' > a' . ' > .premium-bullet-list__content-wrap' . ' > .premium-bullet-list__icon-wrap' . ' > .premium-bullet-list__content-icon' . ' > .premium-bullet-list-icon, ' . $unique_id . ' > .premium-bullet-list' . '> .premium-bullet-list__wrapper' . ' > a' . ' > .premium-bullet-list__content-wrap' . ' > .premium-bullet-list__icon-wrap' . ' > img' );
		$css->add_property( 'vertical-align', $flex_align );
	}

	// Style for title.
	if ( isset( $attr['titleTypography'] ) ) {
		$title_typography = $attr['titleTypography'];

		$css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' . '> .premium-bullet-list__wrapper' . ' > .premium-bullet-list__content-wrap' . ' > .premium-bullet-list__label-wrap' );
		$css->render_typography( $title_typography, 'Mobile' );
		$css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' . '> .premium-bullet-list__wrapper' . ' > a' . ' > .premium-bullet-list__content-wrap' . ' > .premium-bullet-list__label-wrap' );
		$css->render_typography( $title_typography, 'Mobile' );
	}

	if ( isset( $attr['titlemargin'] ) ) {
		$title_margin = $attr['titlemargin'];
		$css->set_selector( '.' . $unique_id . ' .premium-bullet-list__label-wrap');
		$css->add_property( 'margin', $css->render_spacing( $title_margin['Mobile'], isset( $title_margin['unit']['Mobile'] )? $title_margin['unit']['Mobile'] : $title_margin['unit']) );
	}

	// style for divider
	if ( isset( $attr['dividerWidth'] ) ) {
		$divider_width = $attr['dividerWidth'];
		$css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' . '> .premium-bullet-list-divider-block:not(:last-child):after' );
		$css->add_property( 'width', $css->render_range( $divider_width, 'Mobile' ) );
	}

	if ( isset( $attr['dividerHeight'] ) ) {
		$divider_height = $attr['dividerHeight'];
		$css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' . '> .premium-bullet-list-divider-block:not(:last-child):after' );
		$css->add_property( 'border-top-width', $css->render_range( $divider_height, 'Mobile' ) );
	}

	if ( isset( $attr['dividerWidth'] ) ) {
		$divider_width = $attr['dividerWidth'];
		$css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' . '> .premium-bullet-list-divider-inline:not(:last-child):after' );
		$css->add_property( 'border-left-width', $css->render_range( $divider_width, 'Mobile' ) );
	}

	if ( isset( $attr['dividerHeight'] ) ) {
		$divider_height = $attr['dividerHeight'];
		$css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' . '> .premium-bullet-list-divider-inline:not(:last-child):after' );
		$css->add_property( 'height', $css->render_range( $divider_height, 'Mobile' ) );
	}

	$css->stop_media_query();
	return $css->css_output();
}

/**
 * Renders the `premium/count-up` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_bullet_list( $attributes, $content, $block ) {
	$block_helpers = pbg_blocks_helper();
	 // Enqueue frontend JS/CSS.
	if ( $block_helpers->it_is_not_amp() ) {
		wp_enqueue_script(
			'pbg-bullet-list',
			PREMIUM_BLOCKS_URL . 'assets/js/minified/bullet-list.min.js',
			array(),
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
 * Register the bullet_list block.
 *
 * @uses render_block_pbg_bullet_list()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_bullet_list() {
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	register_block_type(
		PREMIUM_BLOCKS_PATH . '/blocks-config/bullet-list',
		array(
			'render_callback' => 'render_block_pbg_bullet_list',
		)
	);
}

register_block_pbg_bullet_list();
