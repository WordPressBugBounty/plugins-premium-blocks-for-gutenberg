<?php
/**
 * Server-side rendering of the `pbg/haeding` block.
 *
 * @package WordPress
 */

/**
 * Get Heading Block CSS
 *
 * Return Frontend CSS for Heading.
 *
 * @access public
 *
 * @param string $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_heading_css_style( $attr, $unique_id ) {
	$css = new Premium_Blocks_css();

	if ( isset( $attr['titleStyles'] ) && isset( $attr['titleStyles'][0] ) ) {
		$title_styles = $attr['titleStyles'][0];
		$css->set_selector( "{$unique_id} .premium-title-style8__wrap .premium-title-text-title[data-animation='shiny']" );
		if(isset($title_styles['titleColor'])){
			$css->add_property( '--base-color', $css->render_string( $css->render_color( $title_styles['titleColor'] ), '!important' ) );
		}
		if(isseT( $title_styles['shinyColor'])){
			$css->add_property( '--shiny-color', $css->render_string( $css->render_color( $title_styles['shinyColor'] ), '!important' ) );
		}
		if(isset($title_styles['animateduration'])){
			$css->add_property( '--animation-speed', $css->render_string( $css->render_color( $title_styles['animateduration'] ), 's !important' ) );
		}

		$css->set_selector( "{$unique_id} .premium-title-header" );
		if(isset($title_styles['blurColor'])){
			$css->add_property( '--shadow-color', $css->render_string( $css->render_color( $title_styles['blurColor'] ), '!important' ) );
		}
		if(isset($title_styles['blurShadow'])){
			$css->add_property( '--shadow-value', $css->render_string( $css->render_color( $title_styles['blurShadow'] ), '!important' ) );
		}

		$css->set_selector( $unique_id . ' .premium-title-style2__wrap' );
		$css->add_property( 'background-color', $css->render_string( $css->render_color( $title_styles['BGColor'] ), '!important' ) );

		$css->set_selector( $unique_id . ' .style3' );
		$css->add_property( 'background-color', $css->render_string( $css->render_color( $title_styles['BGColor'] ), '!important' ) );

		$css->set_selector( $unique_id . ' .premium-title-style5__wrap' );
		$css->add_property( 'border-bottom', $css->render_string( '2px solid ' . $title_styles['lineColor'], '!important' ) );

		$css->set_selector( $unique_id . ' .premium-title-style6__wrap' );
		$css->add_property( 'border-bottom', "2px solid {$title_styles['lineColor']}!important" );

		$css->set_selector( $unique_id . ' .premium-title-style6__wrap:before' );
		$css->add_property( 'border-bottom-color', $css->render_string( $css->render_color( $title_styles['triangleColor'] ), '!important' ) );

		$css->set_selector( $unique_id . ' .premium-title-style7-stripe-span' );
		$css->add_property( 'background-color', $css->render_string( $css->render_color( $title_styles['stripeColor'] ), '!important' ) );
	}

	if ( isset( $attr['titleBorder'] ) ) {
		$title_border = $attr['titleBorder'];
		$css->set_selector( $unique_id . ' .default .premium-title-header' );
		$css->add_property( 'border-color', $css->render_color( $title_border['borderColor'] ) );
		$css->add_property( 'border-style', $title_border['borderType'] ?? 'none' );

		$css->set_selector( $unique_id . ' .style1 .premium-title-header' );
		$css->add_property( 'border-color', $css->render_color( $title_border['borderColor'] ) );
		$css->add_property( 'border-style', $title_border['borderType'] ?? 'none' );
		$css->add_property( 'border-left-style', $title_border['borderType'] === 'none' ? 'solid' : $title_border['borderType'] );
		$css->add_property( 'border-left-color', $title_border['borderType'] === 'none' ? 'var(--pbg-global-color1,#0085BA)' : $title_border['borderColor'] );
		$css->add_property( 'border-bottom-width', $title_border['borderType'] === 'none' ? '3px' : '' );

		$css->set_selector( $unique_id . ' .style2' );
		$css->add_property( 'border-color', $css->render_color( $title_border['borderColor'] ) );
		$css->add_property( 'border-style', $title_border['borderType'] ?? 'none' );
		$css->add_property( 'border-bottom-style', $title_border['borderType'] === 'none' ? 'solid' : $title_border['borderType'] );
		$css->add_property( 'border-bottom-color', $title_border['borderType'] === 'none' ? 'var(--pbg-global-color1,#0085BA)' : $title_border['borderColor'] );
		$css->add_property( 'border-bottom-width', $title_border['borderType'] === 'none' ? '3px' : '' );

		$css->set_selector( $unique_id . ' .style4' );
		$css->add_property( 'border-color', $css->render_color( $title_border['borderColor'] ) );
		$css->add_property( 'border-style', $title_border['borderType'] ?? 'none' );
		$css->add_property( 'border-bottom-style', $title_border['borderType'] === 'none' ? 'solid' : $title_border['borderType'] );
		$css->add_property( 'border-bottom-color', $title_border['borderType'] === 'none' ? 'var(--pbg-global-color1,#0085BA)' : $title_border['borderColor'] );
		$css->add_property( 'border-bottom-width', $title_border['borderType'] === 'none' ? '3px' : '' );

		$css->set_selector( $unique_id . ' .style5' );
		$css->add_property( 'border-color', $css->render_color( $title_border['borderColor'] ) );
		$css->add_property( 'border-style', $title_border['borderType'] ?? 'none' );
		$css->add_property( 'border-bottom-style', $title_border['borderType'] === 'none' ? 'solid' : $title_border['borderType'] );
		$css->add_property( 'border-bottom-color', $title_border['borderType'] === 'none' ? 'var(--pbg-global-color1,#0085BA)' : $title_border['borderColor'] );
		$css->add_property( 'border-bottom-width', $title_border['borderType'] === 'none' ? '3px' : '' );

		$css->set_selector( $unique_id . ' .style6' );
		$css->add_property( 'border-color', $css->render_color( $title_border['borderColor'] ) );
		$css->add_property( 'border-style', $title_border['borderType'] ?? 'none' );
		$css->add_property( 'border-bottom-style', $title_border['borderType'] === 'none' ? 'solid' : $title_border['borderType'] );
		$css->add_property( 'border-bottom-color', $title_border['borderType'] === 'none' ? 'var(--pbg-global-color1,#0085BA)' : $title_border['borderColor'] );
		$css->add_property( 'border-bottom-width', $title_border['borderType'] === 'none' ? '3px' : '' );
	}

	if ( isset( $attr['titleShadow'] ) ) {
		$title_shadow = $attr['titleShadow'];
		$css->set_selector( $unique_id . ' .premium-title-style9__wrap .premium-letters-container' );
		$css->add_property( 'text-shadow', $css->render_shadow( $title_shadow ) );

		$css->set_selector( $unique_id . ' .premium-title-text-title' );
		$css->add_property( 'text-shadow', $css->render_shadow( $title_shadow ) );
	}
	// Align.
	if ( isset( $attr['align'] ) ) {
		 $content_align      = $css->get_responsive_css( $attr['align'], 'Desktop' );
		$css->set_selector( $unique_id . ', ' . $unique_id );
		$css->add_property( 'text-align', $content_align );
        $css->add_property( 'align-self', $css->render_align_self($content_align) );
	}

	if ( isset( $attr['titlePadding'] ) ) {
		$title_padding = $attr['titlePadding'];
		$css->set_selector( $unique_id . ' .premium-title-header,' . $unique_id . ' .premium-title-style9__wrap .premium-letters-container, ' . $unique_id . ' .premium-title-header.premium-title-style2__wrap' );
		$css->add_property( 'padding', $css->render_string( $css->render_spacing( $title_padding['Desktop'],isset( $title_padding['unit']['Desktop'])?$title_padding['unit']['Desktop']:$title_padding['unit'] ) ), " !important");
	}

	if ( isset( $attr['titleMargin'] ) ) {
		$title_margin = $attr['titleMargin'];
		$css->set_selector( $unique_id . ' .premium-title-header' );
		$css->add_property( 'margin', $css->render_spacing( $title_margin['Desktop'],isset( $title_margin['unit']['Desktop'] )?$title_margin['unit']['Desktop']:$title_margin['unit']) );
	}

	if ( isset( $attr['titleTypography'] ) ) {
		$typography_title = $attr['titleTypography'];
		$css->set_selector( $unique_id . ' .premium-title-header' );
		$css->render_typography( $typography_title, 'Desktop' );
	}

	if ( isset( $attr['titleBorder'] ) ) {
		$title_border        = $attr['titleBorder'];
		$title_border_width  = $title_border['borderWidth'];
		$title_border_radius = $title_border['borderRadius'];
		$border_left_width   = $css->get_responsive_value( $title_border_width, 'left', 'Desktop', 'px' );
		$border_bottom_width = $css->get_responsive_value( $title_border_width, 'bottom', 'Desktop', 'px' );

		$css->set_selector( $unique_id . ' .style1 .premium-title-header' );
		$css->add_property( 'border-width', $css->render_spacing( $title_border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $title_border_radius['Desktop'], 'px' ) );
		if ( $border_left_width && 1 <= $border_left_width ) {
			$css->add_property( 'border-left', "{$border_left_width} {$title_border['borderType']} {$title_border['borderColor']}!important" );
		}
		$css->set_selector( $unique_id . ' .style2, ' . $unique_id . ' .style4, ' . $unique_id . ' .style5, ' . $unique_id . ' .style6' );
		$css->add_property( 'border-width', $css->render_spacing( $title_border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $title_border_radius['Desktop'], 'px' ) );
		if ( $border_bottom_width && 0 <= $border_bottom_width ) {
			$css->add_property( 'border-bottom', "{$border_bottom_width} {$title_border['borderType']} {$title_border['borderColor']}!important" );
		}
		$css->set_selector( $unique_id . ' > .default .premium-title-header' );
		$css->add_property( 'border-width', $css->render_spacing( $title_border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $title_border_radius['Desktop'], 'px' ) );
	}

	// Style for icon.
	if ( isset( $attr['iconBG'] ) ) {
		$icon_background = $attr['iconBG'];
		$css->set_selector( $unique_id . ' .premium-title-icon' );
		$css->render_background( $icon_background, 'Desktop' );
		$css->set_selector( $unique_id . ' .premium-lottie-animation svg' );
		$css->render_background( $icon_background, 'Desktop' );
		$css->set_selector( $unique_id . ' .premium-title-svg-class svg' );
		$css->render_background( $icon_background, 'Desktop' );
	}

	if ( isset( $attr['iconColor'] ) ) {
		$icon_styles = $attr['iconColor'];
		$css->set_selector( $unique_id . ' .premium-title-icon' );
		$css->add_property( 'color', $css->render_color( $icon_styles ) );
		$css->set_selector( $unique_id . ' .premium-title-icon:not(.icon-type-fe) svg' );
		$css->add_property( 'color', $css->render_color( $icon_styles ) );
		$css->add_property( 'fill', $css->render_color( $icon_styles ) );
		$css->set_selector( $unique_id . ' .premium-title-svg-class svg' );
		$css->add_property( 'color', $css->render_color( $icon_styles ) );
		$css->add_property( 'fill', $css->render_color( $icon_styles ) );
		$css->set_selector( $unique_id . ' .premium-title-icon:not(.icon-type-fe) svg *' );
		$css->add_property( 'fill', $css->render_color( $icon_styles ) );
		$css->set_selector( $unique_id . ' .premium-title-svg-class svg *' );
		$css->add_property( 'fill', $css->render_color( $icon_styles ) );

	}

	if ( isset( $attr['iconHoverBG'] ) ) {
		$icon_backgroundHover = $attr['iconHoverBG'];
		$css->set_selector( $unique_id . ' .premium-title-icon:hover' );
		$css->render_background( $icon_backgroundHover, 'Desktop' );
		$css->set_selector( $unique_id . ' .premium-title-icon:hover svg' );
		$css->render_background( $icon_backgroundHover, 'Desktop' );
		$css->set_selector( $unique_id . ' .premium-title-svg-class:hover svg' );
		$css->render_background( $icon_backgroundHover, 'Desktop' );
		$css->set_selector( $unique_id . ' .premium-lottie-animation:hover svg' );
		$css->render_background( $icon_backgroundHover, 'Desktop' );
	}

	if ( isset( $attr['iconHoverColor'] ) ) {
		$css->set_selector( $unique_id . ' .premium-title-icon:hover' );
		$css->add_property( 'color', $css->render_color( $attr['iconHoverColor'] ) );
		$css->add_property( 'fill', $css->render_color( $attr['iconHoverColor'] ) );
		$css->set_selector( $unique_id . ' .premium-title-icon:not(.icon-type-fe):hover svg' );
		$css->add_property( 'color', $css->render_color( $attr['iconHoverColor'] ) );
		$css->add_property( 'fill', $css->render_color( $attr['iconHoverColor'] ) );
		$css->set_selector( $unique_id . ' .premium-title-icon:not(.icon-type-fe):hover svg *' );
		$css->add_property( 'fill', $css->render_color( $attr['iconHoverColor'] ) );
		$css->set_selector( $unique_id . ' .premium-title-svg-class:hover svg *' );
		$css->add_property( 'fill', $css->render_color( $attr['iconHoverColor'] ) );
		$css->set_selector( $unique_id . ' .premium-title-svg-class:hover svg' );
		$css->add_property( 'color', $css->render_color( $attr['iconHoverColor'] ) );
		$css->add_property( 'fill', $css->render_color( $attr['iconHoverColor'] ) );
	}

	if ( isset( $attr['borderHoverColor'] ) ) {
		$css->set_selector( $unique_id . ' .premium-title-icon:hover' );
		$css->add_property( 'border-color', $css->render_color( $attr['borderHoverColor'] ) );
		$css->set_selector( $unique_id . ' .premium-title-icon:hover svg' );
		$css->add_property( 'border-color', $css->render_color( $attr['borderHoverColor'] ) );
		$css->set_selector( $unique_id . ' .premium-title-svg-class:hover svg' );
		$css->add_property( 'border-color', $css->render_color( $attr['borderHoverColor'] ) );
		$css->set_selector( $unique_id . ' .premium-lottie-animation:hover svg' );
		$css->add_property( 'border-color', $css->render_color( $attr['borderHoverColor'] ) );
	}

	if ( isset( $attr['iconAlign'] ) ) {
		$align      = $css->get_responsive_css( $attr['iconAlign'], 'Desktop' );
		$flex_align = 'left' === $align ? 'flex-start' : 'center';
		$flex_align = 'right' === $align ? 'flex-end' : $flex_align;

		$css->set_selector( $unique_id . ' .premium-title-header' );
		$css->add_property( 'align-items', $flex_align );

		$css->set_selector( $unique_id . ' .premium-title-style7-inner-title' );
		$css->add_property( 'align-items', $flex_align );
	}
	if ( isset( $attr['align'] ) ) {
		$align      = $css->get_responsive_css( $attr['align'], 'Desktop' );
		$flex_align = 'left' === $align ? 'flex-start' : 'center';
		$flex_align = 'right' === $align ? 'flex-end' : $flex_align;

		$css->set_selector( $unique_id . ' .premium-title-header' );
		$css->add_property( 'justify-content', $flex_align );
	}
	if ( isset( $attr['iconPadding'] ) ) {
		$icon_padding = $attr['iconPadding'];
		$css->set_selector( $unique_id . ' .premium-title-header' . ' .premium-title-icon, ' . $unique_id . ' .premium-lottie-animation svg, ' . $unique_id . ' .premium-title-svg-class svg, ' . $unique_id . ' .premium-title-header img' );
		$css->add_property( 'padding', $css->render_spacing( $icon_padding['Desktop'],isset( $icon_padding['unit']['Desktop'])?$icon_padding['unit']['Desktop']:$icon_padding['unit'] ) );
	}

	if ( isset( $attr['iconMargin'] ) ) {
		$icon_margin = $attr['iconMargin'];
		$css->set_selector( $unique_id . ' .premium-title-header' . ' .premium-title-icon, ' . $unique_id . ' .premium-lottie-animation svg, ' . $unique_id . ' .premium-title-svg-class svg, ' . $unique_id . ' .premium-title-header img' );
		$css->add_property( 'margin', $css->render_spacing( $icon_margin['Desktop'],isset( $icon_margin['unit']['Desktop'])?$icon_margin['unit']['Desktop']:$icon_margin['unit'] ) );
	}

	if ( isset( $attr['iconBorder'] ) ) {
		$icon_border        = $attr['iconBorder'];
		$icon_border_width  = $icon_border['borderWidth'];
		$icon_border_radius = $icon_border['borderRadius'];

		$css->set_selector( $unique_id . ' .premium-title-header' . ' .premium-title-icon, ' . $unique_id . ' .premium-lottie-animation svg, ' . $unique_id . ' .premium-title-svg-class svg, ' . $unique_id . ' .premium-title-header img' );
		$css->add_property( 'border-style', $css->render_string( $icon_border['borderType'], '' ) );
		$css->add_property( 'border-color', $css->render_color( $icon_border['borderColor'] ) );
		$css->add_property( 'border-width', $css->render_spacing( $icon_border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $icon_border_radius['Desktop'], 'px' ) );
	}

	if ( isset( $attr['iconSize'] ) ) {
		$icon_size = $attr['iconSize'];
		$css->set_selector( $unique_id . ' .premium-title-icon' );
		$css->add_property( 'font-size', $css->render_string( $css->render_range( $icon_size, 'Desktop' ) ) );
		$css->set_selector( $unique_id . ' .premium-title-icon svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $icon_size, 'Desktop' ) ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $icon_size, 'Desktop' ) ) );
		$css->set_selector( $unique_id . ' .premium-title-header .premium-title-svg-class svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $icon_size, 'Desktop' ) ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $icon_size, 'Desktop' ) ) );
	}

	// image style
	if ( isset( $attr['imgWidth'] ) ) {
		$css->set_selector( $unique_id . ' .premium-title-header img' );
		$css->add_property( 'width', $css->render_range( $attr['imgWidth'], 'Desktop' ) );

		$css->set_selector( $unique_id . ' .premium-title-header .premium-lottie-animation svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['imgWidth'], 'Desktop' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['imgWidth'], 'Desktop' ), '!important' ) );
	}

	// stripeStyles
	if ( isset( $attr['stripeTopSpacing'] ) ) {
		$stripe_top_spacing = $attr['stripeTopSpacing'];
		$css->set_selector( $unique_id . ' .premium-title-style7-stripe__wrap' );
		$css->add_property( 'margin-top', $css->render_range( $stripe_top_spacing, 'Desktop' ) );
	}

	if ( isset( $attr['stripeBottomSpacing'] ) ) {
		$stripe_bottom_spacing = $attr['stripeBottomSpacing'];
		$css->set_selector( $unique_id . ' .premium-title-style7-stripe__wrap' );
		$css->add_property( 'margin-bottom', $css->render_range( $stripe_bottom_spacing, 'Desktop' ) );
	}

	if ( isset( $attr['stripeAlign'] ) ) {
		$align      = $css->get_responsive_css( $attr['stripeAlign'], 'Desktop' );
		$flex_align = 'left' === $align ? 'flex-start' : 'center';
		$flex_align = 'right' === $align ? 'flex-end' : $flex_align;

		$css->set_selector( $unique_id . ' .premium-title-style7-stripe__wrap' );
		$css->add_property( 'justify-content', $flex_align );
	}

	if ( isset( $attr['stripeWidth'] ) ) {
		$stripe_width = $attr['stripeWidth'];
		$css->set_selector( $unique_id . ' .premium-title-style7-stripe__wrap' . ' .premium-title-style7-stripe-span' );
		$css->add_property( 'width', $css->render_range( $stripe_width, 'Desktop' ) );
	}

	if ( isset( $attr['stripeHeight'] ) ) {
		$stripe_height = $attr['stripeHeight'];
		$css->set_selector( $unique_id . ' .premium-title-style7-stripe__wrap' . ' .premium-title-style7-stripe-span' );
		$css->add_property( 'height', $css->render_range( $stripe_height, 'Desktop' ) );
	}

	// background text
	if ( isset( $attr['textStyles'] ) && isset( $attr['textStyles'][0] ) ) {
		$text_styles = $attr['textStyles'][0];
		$css->set_selector( $unique_id . ' .premium-title-bg-text:before' );
		$css->add_property( 'color', $css->render_color( $text_styles['textBackColor'] ) );
	}

	if ( isset( $attr['strokeStyles'] ) && isset( $attr['strokeStyles'][0] ) ) {
		$stroke_styles = $attr['strokeStyles'][0];
		$css->set_selector( $unique_id . ' .premium-title-bg-text:before' );
		$css->add_property( '-webkit-text-stroke-color', $css->render_color( $stroke_styles['strokeColor'] ) );
	}

	if ( isset( $attr['textBackshadow'] ) ) {
		$text_backshadow = $attr['textBackshadow'];
		$css->set_selector( $unique_id . ' .premium-title-bg-text:before' );
		$css->add_property( 'text-shadow', $css->render_string( $css->render_shadow( $attr['textBackshadow'] )," !important") );
	}

	if ( isset( $attr['blend'] ) && ! empty( $attr['blend'] ) ) {
		$blend = $attr['blend'];
		$css->set_selector( $unique_id . ' .premium-title-bg-text:before' );
		$css->add_property( 'mix-blend-mode', $blend );
	}

	if ( isset( $attr['zIndex'] ) && ! empty( $attr['zIndex'] ) ) {
		$zIndex = $attr['zIndex'];
		$css->set_selector( $unique_id . ' .premium-title-bg-text:before' );
		$css->add_property( 'z-index', $zIndex );
	}

	if ( isset( $attr['textWidth'] ) && ! empty( $attr['textWidth'] ) ) {
		$textWidth = $attr['textWidth'];
		$css->set_selector( $unique_id . ' .premium-title-bg-text:before' );
		$css->add_property( 'width', $textWidth );
	}

	if ( isset( $attr['verticalText'] ) ) {
		$vertical_text = $attr['verticalText'];
		$css->set_selector( $unique_id . ' .premium-title-bg-text:before' );
		$css->add_property( 'top', $css->render_range( $vertical_text, 'Desktop' ) );
	}

	if ( isset( $attr['horizontalText'] ) ) {
		$horizontal_text = $attr['horizontalText'];
		$css->set_selector( $unique_id . ' > .premium-title-bg-text:before' );
		$css->add_property( 'left', $css->render_range( $horizontal_text, 'Desktop' ) );
	}

	if ( isset( $attr['rotateText'] ) && $attr['backgroundText'] ) {
		$rotate_text = $attr['rotateText'];
		$value       = $css->render_range( $rotate_text, 'Desktop' );
		$css->set_selector( $unique_id . ' > .premium-title-bg-text:before' );
		$css->add_property( 'transform', "rotate({$value})!important" );
	}

	if ( isset( $attr['strokeFull'] ) ) {
		$stroke_full = $attr['strokeFull'];
		$css->set_selector( $unique_id . ' .premium-title-bg-text:before' );
		$css->add_property( '-webkit-text-stroke-width', $css->render_range( $stroke_full, 'Desktop' ) );
	}

	if ( isset( $attr['textTypography'] ) ) {
		$text_typography = $attr['textTypography'];
		$css->set_selector( $unique_id . ' .premium-title-bg-text:before' );
		$css->render_typography( $text_typography, 'Desktop' );
	}

	$css->start_media_query( 'tablet' );

	// Align.
	if ( isset( $attr['align'] ) ) {
        $content_align      = $css->get_responsive_css( $attr['align'], 'Tablet' );
		$css->set_selector( $unique_id . ', ' . $unique_id );
		$css->add_property( 'text-align', $content_align );
        $css->add_property( 'align-self',  $css->render_align_self($content_align) );
	}

	if ( isset( $attr['titlePadding'] ) ) {
		$title_padding = $attr['titlePadding'];
		$css->set_selector( $unique_id . ' .premium-title-header,' . $unique_id . ' .premium-title-style9__wrap .premium-letters-container, ' . $unique_id . ' .premium-title-header.premium-title-style2__wrap' );
		$css->add_property( 'padding', $css->render_spacing( $title_padding['Tablet'],isset( $title_padding['unit']['Tablet'] )?$title_padding['unit']['Tablet']:$title_padding['unit']) );
	}

	if ( isset( $attr['titleMargin'] ) ) {
		$title_margin = $attr['titleMargin'];
		$css->set_selector( $unique_id . ' .premium-title-text-title, ' . $unique_id . ' .premium-title-style9__wrap .premium-letters-container' );
		$css->add_property( 'margin', $css->render_spacing( $title_margin['Tablet'],isset( $title_margin['unit']['Tablet'] )?$title_margin['unit']['Tablet']:$title_margin['unit']) );
	}

	if ( isset( $attr['titleTypography'] ) ) {
		$typography_title = $attr['titleTypography'];
		$css->set_selector( $unique_id . ' .premium-title-header' );
		$css->render_typography( $typography_title, 'Tablet' );
	}

	if ( isset( $attr['titleBorder'] ) ) {
		$title_border        = $attr['titleBorder'];
		$title_border_width  = $attr['titleBorder']['borderWidth'];
		$title_border_radius = $attr['titleBorder']['borderRadius'];
		$border_left_width   = $css->get_responsive_value( $title_border_width, 'left', 'Tablet', 'px' );
		$border_bottom_width = $css->get_responsive_value( $title_border_width, 'bottom', 'Tablet', 'px' );

		$css->set_selector( $unique_id . ' .style1 .premium-title-header' );
		$css->add_property( 'border-width', $css->render_spacing( $title_border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $title_border_radius['Tablet'], 'px' ) );
		if ( $border_left_width && 1 <= $border_left_width ) {
			$css->add_property( 'border-left', "{$border_left_width} {$title_border['borderType']} {$title_border['borderColor']}!important" );
		}
		$css->set_selector( $unique_id . ' .style2, ' . $unique_id . ' .style4, ' . $unique_id . ' .style5, ' . $unique_id . ' .style6' );
		$css->add_property( 'border-width', $css->render_spacing( $title_border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $title_border_radius['Tablet'], 'px' ) );
		if ( $border_bottom_width && 0 <= $border_bottom_width ) {
			$css->add_property( 'border-bottom', "{$border_bottom_width} {$title_border['borderType']} {$title_border['borderColor']}!important" );
		}
		$css->set_selector( $unique_id . ' .default .premium-title-header' );
		$css->add_property( 'border-width', $css->render_spacing( $title_border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $title_border_radius['Tablet'], 'px' ) );
	}

	// Style for icon.
	if ( isset( $attr['iconBG'] ) ) {
		$icon_background = $attr['iconBG'];
		$css->set_selector( $unique_id . ' .premium-title-icon' );
		$css->render_background( $icon_background, 'Tablet' );
		$css->set_selector( $unique_id . ' .premium-lottie-animation svg' );
		$css->render_background( $icon_background, 'Tablet' );
		$css->set_selector( $unique_id . ' .premium-title-svg-class svg' );
		$css->render_background( $icon_background, 'Tablet' );
	}

	if ( isset( $attr['iconHoverBG'] ) ) {
		$icon_backgroundHover = $attr['iconHoverBG'];
		$css->set_selector( $unique_id . ' .premium-title-icon:hover' );
		$css->render_background( $icon_backgroundHover, 'Tablet' );
		$css->set_selector( $unique_id . ' .premium-title-icon:hover svg' );
		$css->render_background( $icon_backgroundHover, 'Tablet' );
		$css->set_selector( $unique_id . ' .premium-title-svg-class:hover svg' );
		$css->render_background( $icon_backgroundHover, 'Tablet' );
		$css->set_selector( $unique_id . ' .premium-lottie-animation:hover svg' );
		$css->render_background( $icon_backgroundHover, 'Tablet' );
	}

	if ( isset( $attr['iconAlign'] ) ) {
		$align      = $css->get_responsive_css( $attr['iconAlign'], 'Tablet' );
		$flex_align = 'left' === $align ? 'flex-start' : 'center';
		$flex_align = 'right' === $align ? 'flex-end' : $flex_align;

		$css->set_selector( $unique_id . ' .premium-title-header' );
		$css->add_property( 'align-items', $flex_align );

		$css->set_selector( $unique_id . ' .premium-title-style7-inner-title' );
		$css->add_property( 'align-items', $flex_align );
	}
	if ( isset( $attr['align'] ) ) {
		$align      = $css->get_responsive_css( $attr['align'], 'Tablet' );
		$flex_align = 'left' === $align ? 'flex-start' : 'center';
		$flex_align = 'right' === $align ? 'flex-end' : $flex_align;

		$css->set_selector( $unique_id . ' .premium-title-header' );
		$css->add_property( 'justify-content', $flex_align );
	}
	if ( isset( $attr['iconPadding'] ) ) {
		$icon_padding = $attr['iconPadding'];
		$css->set_selector( $unique_id . ' .premium-title-header' . ' .premium-title-icon, ' . $unique_id . ' .premium-lottie-animation svg, ' . $unique_id . ' .premium-title-svg-class svg, ' . $unique_id . ' .premium-title-header img' );
		$css->add_property( 'padding', $css->render_spacing( $icon_padding['Tablet'],isset( $icon_padding['unit']['Tablet'])?$icon_padding['unit']['Tablet']:$icon_padding['unit'] ) );
	}

	if ( isset( $attr['iconMargin'] ) ) {
		$icon_margin = $attr['iconMargin'];
		$css->set_selector( $unique_id . ' .premium-title-header' . ' .premium-title-icon, ' . $unique_id . ' .premium-lottie-animation svg, ' . $unique_id . ' .premium-title-svg-class svg, ' . $unique_id . ' .premium-title-header img' );
		$css->add_property( 'margin', $css->render_spacing( $icon_margin['Tablet'],isset( $icon_margin['unit']['Tablet'])?$icon_margin['unit']['Tablet']:$icon_margin['unit'] ) );

	}

	if ( isset( $attr['iconBorder'] ) ) {
		$icon_border        = $attr['iconBorder'];
		$icon_border_width  = $icon_border['borderWidth'];
		$icon_border_radius = $icon_border['borderRadius'];

		$css->set_selector( $unique_id . ' .premium-title-header' . ' .premium-title-icon, ' . $unique_id . ' .premium-lottie-animation svg, ' . $unique_id . ' .premium-title-svg-class svg, ' . $unique_id . ' .premium-title-header img' );
		$css->add_property( 'border-width', $css->render_spacing( $icon_border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $icon_border_radius['Tablet'], 'px' ) );
	}

	if ( isset( $attr['iconSize'] ) ) {
		$icon_size = $attr['iconSize'];
		$css->set_selector( $unique_id . ' .premium-title-icon' );
		$css->add_property( 'font-size', $css->render_string( $css->render_range( $icon_size, 'Tablet' ) ) );
		$css->set_selector( $unique_id . ' .premium-title-icon svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $icon_size, 'Tablet' ) ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $icon_size, 'Tablet' ) ) );
		$css->set_selector( $unique_id . ' .premium-title-header .premium-title-svg-class svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $icon_size, 'Tablet' ) ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $icon_size, 'Tablet' ) ) );
	}

	// image style
	if ( isset( $attr['imgWidth'] ) ) {
		$css->set_selector( $unique_id . ' .premium-title-header img' );
		$css->add_property( 'width', $css->render_range( $attr['imgWidth'], 'Tablet' ) );

		$css->set_selector( $unique_id . ' .premium-title-header .premium-lottie-animation svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['imgWidth'], 'Tablet' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['imgWidth'], 'Tablet' ), '!important' ) );
	}

	// stripeStyles
	if ( isset( $attr['stripeTopSpacing'] ) ) {
		$stripe_top_spacing = $attr['stripeTopSpacing'];
		$css->set_selector( $unique_id . ' .premium-title-style7-stripe__wrap' );
		$css->add_property( 'margin-top', $css->render_range( $stripe_top_spacing, 'Tablet' ) );
	}

	if ( isset( $attr['stripeBottomSpacing'] ) ) {
		$stripe_bottom_spacing = $attr['stripeBottomSpacing'];
		$css->set_selector( $unique_id . ' .premium-title-style7-stripe__wrap' );
		$css->add_property( 'margin-bottom', $css->render_range( $stripe_bottom_spacing, 'Tablet' ) );
	}

	if ( isset( $attr['stripeAlign'] ) ) {
		$align      = $css->get_responsive_css( $attr['stripeAlign'], 'Tablet' );
		$flex_align = 'left' === $align ? 'flex-start' : 'center';
		$flex_align = 'right' === $align ? 'flex-end' : $flex_align;

		$css->set_selector( $unique_id . ' .premium-title-style7-stripe__wrap' );
		$css->add_property( 'justify-content', $flex_align );
	}

	if ( isset( $attr['stripeWidth'] ) ) {
		$stripe_width = $attr['stripeWidth'];
		$css->set_selector( $unique_id . ' .premium-title-style7-stripe__wrap' . ' > .premium-title-style7-stripe-span' );
		$css->add_property( 'width', $css->render_range( $stripe_width, 'Tablet' ) );
	}

	if ( isset( $attr['stripeHeight'] ) ) {
		$stripe_height = $attr['stripeHeight'];
		$css->set_selector( $unique_id . ' .premium-title-style7-stripe__wrap' . ' > .premium-title-style7-stripe-span' );
		$css->add_property( 'height', $css->render_range( $stripe_height, 'Tablet' ) );
	}

	// background text
	if ( isset( $attr['verticalText'] ) ) {
		$vertical_text = $attr['verticalText'];
		$css->set_selector( $unique_id . ' .premium-title-bg-text:before' );
		$css->add_property( 'top', $css->render_range( $vertical_text, 'Tablet' ) );
	}

	if ( isset( $attr['horizontalText'] ) ) {
		$horizontal_text = $attr['horizontalText'];
		$css->set_selector( $unique_id . ' > .premium-title-bg-text:before' );
		$css->add_property( 'left', $css->render_range( $horizontal_text, 'Tablet' ) );
	}

	if ( isset( $attr['rotateText'] ) && $attr['backgroundText'] ) {
		$rotate_text = $attr['rotateText'];
		$value       = $css->render_range( $rotate_text, 'Tablet' );
		$css->set_selector( $unique_id . ' > .premium-title-bg-text:before' );
		$css->add_property( 'transform', "rotate({$value})!important" );
	}

	if ( isset( $attr['strokeFull'] ) ) {
		$stroke_full = $attr['strokeFull'];
		$css->set_selector( $unique_id . ' .premium-title-bg-text:before' );
		$css->add_property( '-webkit-text-stroke-width', $css->render_range( $stroke_full, 'Tablet' ) );
	}

	if ( isset( $attr['textTypography'] ) ) {
		$text_typography = $attr['textTypography'];
		$css->set_selector( $unique_id . ' .premium-title-bg-text:before' );
		$css->render_typography( $text_typography, 'Tablet' );
	}

	$css->stop_media_query();

	$css->start_media_query( 'mobile' );

	// Align.
	if ( isset( $attr['align'] ) ) {
  $content_align      = $css->get_responsive_css( $attr['align'], 'Mobile' );
		$css->set_selector( $unique_id . ', ' . $unique_id );
		$css->add_property( 'text-align', $content_align );
        $css->add_property( 'align-self',  $css->render_align_self($content_align) );
	}

	if ( isset( $attr['titlePadding'] ) ) {
		$title_padding = $attr['titlePadding'];
		$css->set_selector( $unique_id . ' .premium-title-header,' . $unique_id . ' .premium-title-style9__wrap .premium-letters-container, ' . $unique_id . ' .premium-title-header.premium-title-style2__wrap' );
		$css->add_property( 'padding', $css->render_spacing( $title_padding['Mobile'],isset( $title_padding['unit']['Mobile'] )?$title_padding['unit']['Mobile']:$title_padding['unit']) );
	}

	if ( isset( $attr['titleMargin'] ) ) {
		$title_margin = $attr['titleMargin'];
		$css->set_selector( $unique_id . ' .premium-title-header' . ' .premium-title-text-title, ' . $unique_id . ' .premium-title-style9__wrap .premium-letters-container' );
		$css->add_property( 'margin', $css->render_spacing( $title_margin['Mobile'],isset( $title_margin['unit']['Mobile'] )?$title_margin['unit']['Mobile']:$title_margin['unit']) );
	}

	if ( isset( $attr['titleTypography'] ) ) {
		$typography_title = $attr['titleTypography'];
		$css->set_selector( $unique_id . ' .premium-title-header' );
		$css->render_typography( $typography_title, 'Mobile' );
	}

	if ( isset( $attr['titleBorder'] ) ) {
		$title_border        = $attr['titleBorder'];
		$title_border_width  = $title_border['borderWidth'];
		$title_border_radius = $title_border['borderRadius'];
		$border_left_width   = $css->get_responsive_value( $title_border_width, 'left', 'Mobile', 'px' );
		$border_bottom_width = $css->get_responsive_value( $title_border_width, 'bottom', 'Mobile', 'px' );

		$css->set_selector( $unique_id . ' .style1 .premium-title-header' );
		$css->add_property( 'border-width', $css->render_spacing( $title_border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $title_border_radius['Mobile'], 'px' ) );
		if ( $border_left_width && 1 <= $border_left_width ) {
			$css->add_property( 'border-left', "{$border_left_width} {$title_border['borderType']} {$title_border['borderColor']}!important" );
		}
		$css->set_selector( $unique_id . ' .style2, ' . $unique_id . ' .style4, ' . $unique_id . ' .style5, ' . $unique_id . ' .style6' );
		$css->add_property( 'border-width', $css->render_spacing( $title_border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $title_border_radius['Mobile'], 'px' ) );
		if ( $border_bottom_width && 0 <= $border_bottom_width ) {
			$css->add_property( 'border-bottom', "{$border_bottom_width} {$title_border['borderType']} {$title_border['borderColor']}!important" );
		}
		$css->set_selector( $unique_id . ' .default .premium-title-header' );
		$css->add_property( 'border-width', $css->render_spacing( $title_border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $title_border_radius['Mobile'], 'px' ) );
	}

	// Style for icon.
	if ( isset( $attr['iconBG'] ) ) {
		$icon_background = $attr['iconBG'];
		$css->set_selector( $unique_id . ' .premium-title-icon' );
		$css->render_background( $icon_background, 'Mobile' );
		$css->set_selector( $unique_id . ' .premium-lottie-animation svg' );
		$css->render_background( $icon_background, 'Mobile' );
		$css->set_selector( $unique_id . ' .premium-title-svg-class svg' );
		$css->render_background( $icon_background, 'Mobile' );
	}

	if ( isset( $attr['iconHoverBG'] ) ) {
		$icon_backgroundHover = $attr['iconHoverBG'];
		$css->set_selector( $unique_id . ' .premium-title-icon:hover' );
		$css->render_background( $icon_backgroundHover, 'Mobile' );
		$css->set_selector( $unique_id . ' .premium-title-icon:hover svg' );
		$css->render_background( $icon_backgroundHover, 'Mobile' );
		$css->set_selector( $unique_id . ' .premium-title-svg-class:hover svg' );
		$css->render_background( $icon_backgroundHover, 'Mobile' );
		$css->set_selector( $unique_id . ' .premium-lottie-animation:hover svg' );
		$css->render_background( $icon_backgroundHover, 'Mobile' );
	}

	if ( isset( $attr['iconAlign'] ) ) {
		$align      = $css->get_responsive_css( $attr['iconAlign'], 'Mobile' );
		$flex_align = 'left' === $align ? 'flex-start' : 'center';
		$flex_align = 'right' === $align ? 'flex-end' : $flex_align;

		$css->set_selector( $unique_id . ' .premium-title-header' );
		$css->add_property( 'align-items', $flex_align );

		$css->set_selector( $unique_id . ' .premium-title-style7-inner-title' );
		$css->add_property( 'align-items', $flex_align );
	}
	if ( isset( $attr['align'] ) ) {
		$align      = $css->get_responsive_css( $attr['align'], 'Mobile' );
		$flex_align = 'left' === $align ? 'flex-start' : 'center';
		$flex_align = 'right' === $align ? 'flex-end' : $flex_align;

		$css->set_selector( $unique_id . ' .premium-title-header' );
		$css->add_property( 'justify-content', $flex_align );
	}
	if ( isset( $attr['iconPadding'] ) ) {
		$icon_padding = $attr['iconPadding'];
		$css->set_selector( $unique_id . ' .premium-title-header' . ' .premium-title-icon, ' . $unique_id . ' .premium-lottie-animation svg, ' . $unique_id . ' .premium-title-svg-class svg, ' . $unique_id . ' .premium-title-header img' );
		$css->add_property( 'padding', $css->render_spacing( $icon_padding['Mobile'],isset( $icon_padding['unit']['Mobile'])?$icon_padding['unit']['Mobile']:$icon_padding['unit'] ) );
	}

	if ( isset( $attr['iconMargin'] ) ) {
		$icon_margin = $attr['iconMargin'];
		$css->set_selector( $unique_id . ' .premium-title-header' . ' .premium-title-icon, ' . $unique_id . ' .premium-lottie-animation svg, ' . $unique_id . ' .premium-title-svg-class svg, ' . $unique_id . ' .premium-title-header img' );
		$css->add_property( 'margin', $css->render_spacing( $icon_margin['Mobile'],isset( $icon_margin['unit']['Mobile'] )?$icon_margin['unit']['Mobile']:$icon_margin['unit']) );
	}

	if ( isset( $attr['iconBorder'] ) ) {
		$icon_border        = $attr['iconBorder'];
		$icon_border_width  = $icon_border['borderWidth'];
		$icon_border_radius = $icon_border['borderRadius'];

		$css->set_selector( $unique_id . ' .premium-title-header' . ' .premium-title-icon, ' . $unique_id . ' .premium-lottie-animation svg, ' . $unique_id . ' .premium-title-svg-class svg, ' . $unique_id . ' .premium-title-header img' );
		$css->add_property( 'border-width', $css->render_spacing( $icon_border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $icon_border_radius['Mobile'], 'px' ) );
	}

	if ( isset( $attr['iconSize'] ) ) {
		$icon_size = $attr['iconSize'];
		$css->set_selector( $unique_id . ' .premium-title-icon' );
		$css->add_property( 'font-size', $css->render_string( $css->render_range( $icon_size, 'Mobile' ) ) );
		$css->set_selector( $unique_id . ' .premium-title-icon svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $icon_size, 'Mobile' ) ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $icon_size, 'Mobile' ) ) );
		$css->set_selector( $unique_id . ' .premium-title-header .premium-title-svg-class svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $icon_size, 'Mobile' ) ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $icon_size, 'Mobile' ) ) );
	}

	// image style
	if ( isset( $attr['imgWidth'] ) ) {
		$css->set_selector( $unique_id . ' .premium-title-header img' );
		$css->add_property( 'width', $css->render_range( $attr['imgWidth'], 'Mobile' ) );

		$css->set_selector( $unique_id . ' .premium-title-header .premium-lottie-animation svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['imgWidth'], 'Mobile' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['imgWidth'], 'Mobile' ), '!important' ) );
	}

	// stripeStyles
	if ( isset( $attr['stripeTopSpacing'] ) ) {
		$stripe_top_spacing = $attr['stripeTopSpacing'];
		$css->set_selector( $unique_id . ' .premium-title-header' . ' > .premium-title-style7-stripe__wrap' );
		$css->add_property( 'margin-top', $css->render_range( $stripe_top_spacing, 'Mobile' ) );
	}

	if ( isset( $attr['stripeBottomSpacing'] ) ) {
		$stripe_bottom_spacing = $attr['stripeBottomSpacing'];
		$css->set_selector( $unique_id . ' .premium-title-header' . ' .premium-title-style7-stripe__wrap' );
		$css->add_property( 'margin-bottom', $css->render_range( $stripe_bottom_spacing, 'Mobile' ) );
	}

	if ( isset( $attr['stripeAlign'] ) ) {
		$align      = $css->get_responsive_css( $attr['stripeAlign'], 'Mobile' );
		$flex_align = 'left' === $align ? 'flex-start' : 'center';
		$flex_align = 'right' === $align ? 'flex-end' : $flex_align;

		$css->set_selector( $unique_id . ' .premium-title-style7-stripe__wrap' );
		$css->add_property( 'justify-content', $flex_align );
	}

	if ( isset( $attr['stripeWidth'] ) ) {
		$stripe_width = $attr['stripeWidth'];
		$css->set_selector( $unique_id . ' .premium-title-header' . ' .premium-title-style7-stripe__wrap' . ' .premium-title-style7-stripe-span' );
		$css->add_property( 'width', $css->render_range( $stripe_width, 'Mobile' ) );
	}

	if ( isset( $attr['stripeHeight'] ) ) {
		$stripe_height = $attr['stripeHeight'];
		$css->set_selector( $unique_id . ' .premium-title-header' . ' .premium-title-style7-stripe__wrap' . ' .premium-title-style7-stripe-span' );
		$css->add_property( 'height', $css->render_range( $stripe_height, 'Mobile' ) );
	}

	// background text
	if ( isset( $attr['verticalText'] ) ) {
		$vertical_text = $attr['verticalText'];
		$css->set_selector( $unique_id . ' .premium-title-bg-text:before' );
		$css->add_property( 'top', $css->render_range( $vertical_text, 'Mobile' ) );
	}

	if ( isset( $attr['horizontalText'] ) ) {
		$horizontal_text = $attr['horizontalText'];
		$css->set_selector( $unique_id . ' .premium-title-bg-text:before' );
		$css->add_property( 'left', $css->render_range( $horizontal_text, 'Mobile' ) );
	}

	if ( isset( $attr['rotateText'] ) && $attr['backgroundText'] ) {
		$rotate_text = $attr['rotateText'];
		$value       = $css->render_range( $rotate_text, 'Mobile' );
		$css->set_selector( $unique_id . ' .premium-title-bg-text:before' );
		$css->add_property( 'transform', "rotate({$value})!important" );
	}

	if ( isset( $attr['strokeFull'] ) ) {
		$stroke_full = $attr['strokeFull'];
		$css->set_selector( $unique_id . ' .premium-title-bg-text:before' );
		$css->add_property( '-webkit-text-stroke-width', $css->render_range( $stroke_full, 'Mobile' ) );
	}

	if ( isset( $attr['textTypography'] ) ) {
		$text_typography = $attr['textTypography'];
		$css->set_selector( $unique_id . ' .premium-title-bg-text:before' );
		$css->render_typography( $text_typography, 'Mobile' );
	}

	$css->stop_media_query();
	return $css->css_output();
}

/**
 * Renders the `premium/heading` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_heading( $attributes, $content ) {
	$block_helpers = pbg_blocks_helper();

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

		if ( $attributes['iconTypeSelect'] == 'svg' || ( isset( $attributes['style'] ) && ( $attributes['style'] == 'style8' || $attributes['style'] == 'style9' ) ) ) {
			wp_enqueue_script(
				'pbg-heading',
				PREMIUM_BLOCKS_URL . 'assets/js/minified/heading.min.js',
				array( 'jquery' ),
				PREMIUM_BLOCKS_VERSION,
				true
			);
		}
	}

	return $content;
}




/**
 * Register the heading block.
 *
 * @uses render_block_pbg_heading()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_heading() {
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	register_block_type(
		PREMIUM_BLOCKS_PATH . '/blocks-config/heading',
		array(
			'render_callback' => 'render_block_pbg_heading',
		)
	);
}

register_block_pbg_heading();
