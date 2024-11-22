<?php
/**
 * Server-side rendering of the `pbg/modal` block.
 *
 * @package WordPress
 */

/**
 * Get Modal Block CSS
 *
 * Return Frontend CSS for Modal.
 *
 * @access public
 *
 * @param string $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_modal_css_style( $attr, $unique_id ) {
	$css = new Premium_Blocks_css();

  $css->set_selector( '.' . $unique_id . '.premium-popup__modal_wrap');
  $css->add_property('padding', "0 !important");
  $css->add_property('margin', "0 !important");

	if ( isset( $attr['align']['Desktop'] ) ) {

        $content_align      = $css->get_responsive_css( $attr['align'], 'Desktop' );
		$content_flex_align = 'left' === $content_align ? 'flex-start' : 'center';
		$content_flex_align = 'right' === $content_align ? 'flex-end' : $content_flex_align;

		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container' );
		$css->add_property( 'text-align', $css->render_string( $content_align, '!important' ) );
        $css->set_selector( '.' . $unique_id  );
        $css->add_property( 'align-self', $css->render_string(  $css->render_align_self($content_align), '!important' ) );

	}

	// svg Style
	if ( isset( $attr['iconSize'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-modal-trigger-container' . ' .premium-modal-trigger-btn .premium-modal-box-icon' );
		$css->add_property( 'font-size', $css->render_string( $css->render_range( $attr['iconSize'], 'Desktop' ), '!important' ) );

		$css->set_selector( '.' . $unique_id . ' > .premium-modal-trigger-container' . ' .premium-modal-trigger-btn .premium-modal-box-icon svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Desktop' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Desktop' ), '!important' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container .premium-modal-trigger-btn .premium-modal-svg-class svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Desktop' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Desktop' ), '!important' ) );
	}
	// image style
	if ( isset( $attr['imgWidth'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-modal-trigger-container' . ' .premium-modal-trigger-btn' . ' > img' );
		$css->add_property( 'width', $css->render_range( $attr['imgWidth'], 'Desktop' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container .premium-modal-trigger-btn .premium-lottie-animation svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['imgWidth'], 'Desktop' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['imgWidth'], 'Desktop' ), '!important' ) );
	}
	if ( isset( $attr['iconColor'] ) ) {
		$icon_color = $attr['iconColor'];
		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container .premium-modal-trigger-btn .premium-modal-box-icon' );
		$css->add_property( 'fill', $css->render_color( $icon_color ) );
		$css->add_property( 'color', $css->render_color( $icon_color ) );
		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container .premium-modal-trigger-btn .premium-modal-box-icon:not(.icon-type-fe) svg' );
		$css->add_property( 'fill', $css->render_color( $icon_color ) );
		$css->add_property( 'color', $css->render_color( $icon_color ) );
		$css->set_selector( '.' . $unique_id . ' > .premium-modal-trigger-container .premium-modal-trigger-btn #premium-modal-svg-' . $unique_id . ' > svg ' );
		$css->add_property( 'fill', $css->render_color( $icon_color ) );
		$css->add_property( 'color', $css->render_color( $icon_color ) );
		$css->set_selector( '.' . $unique_id . ' > .premium-modal-trigger-container .premium-modal-trigger-btn .premium-modal-box-icon:not(.icon-type-fe) svg *' );
		$css->add_property( 'fill', $css->render_color( $icon_color ) );
		$css->set_selector( '.' . $unique_id . ' > .premium-modal-trigger-container .premium-modal-trigger-btn #premium-modal-svg-' . $unique_id . ' > svg *' );
		$css->add_property( 'fill', $css->render_color( $icon_color ) );
	}
	if ( isset( $attr['triggerStyles'][0]['hoverColor'] ) ) {
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container' . ' > .premium-modal-trigger-btn:hover , .' . $unique_id . '> .premium-modal-trigger-container' . ' > .premium-modal-trigger-btn:hover span , .' . $unique_id . '  .premium-modal-trigger-container:hover .premium-modal-trigger-text' );
		$css->add_property( 'color', $css->render_string( $css->render_color( $attr['triggerStyles'][0]['hoverColor'] ), '!important' ) );
	}
	if ( isset( $attr['triggerStyles'][0]['triggerHoverBack'] ) ) {
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container' . ' > .premium-modal-trigger-btn:hover' );
		$css->add_property( 'background-color', $css->render_string( $css->render_color( $attr['triggerStyles'][0]['triggerHoverBack'] ), '!important' ) );
	}
	if ( isset( $attr['triggerBorderH'] ) ) {
		$trigger_border_width  = $attr['triggerBorderH']['borderWidth'];
		$trigger_border_radius = $attr['triggerBorderH']['borderRadius'];
		$trigger_border_style  = $attr['triggerBorderH']['borderType'];
		$trigger_border_color  = $attr['triggerBorderH']['borderColor'];
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container' . ' > .premium-modal-trigger-btn:hover' );
		$css->add_property( 'border-color', $css->render_string( $css->render_color( $trigger_border_color ), '!important' ) );
		$css->add_property( 'border-style', $css->render_string( $css->render_color( $trigger_border_style ), '!important' ) );
		$css->add_property( 'border-width', $css->render_string( $css->render_spacing( $trigger_border_width['Desktop'], 'px' ), '!important' ) );
		$css->add_property( 'border-radius', $css->render_string( $css->render_spacing( $trigger_border_radius['Desktop'], 'px' ), '!important' ) );
	}
	if ( isset( $attr['iconBorder'] ) ) {
		$icon_border        = $attr['iconBorder'];
		$icon_border_width  = $icon_border['borderWidth'];
		$icon_border_radius = $icon_border['borderRadius'];
		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-modal-box-icon, ' . '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn img, ' . '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-modal-svg-class svg, ' . '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-lottie-animation svg' );
		$css->add_property( 'border-width', $css->render_spacing( $icon_border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $icon_border_radius['Desktop'], 'px' ) );
		$css->add_property( 'border-style', $css->render_string( $icon_border['borderType'] ), '!important' );
		$css->add_property( 'border-color', $css->render_color( $icon_border['borderColor'] ) );
	}

	if ( isset( $attr['iconMargin'] ) ) {
		$icon_margin = $attr['iconMargin'];
		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-modal-box-icon, ' . '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn img, ' . '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-modal-svg-class svg, ' . '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-lottie-animation svg' );
		$css->add_property( 'margin', $css->render_string( $css->render_spacing( $icon_margin['Desktop'], isset($icon_margin['unit']['Desktop'])?$icon_margin['unit']['Desktop']:$icon_margin['unit']  ), '!important' ) );
	}
	if ( isset( $attr['iconPadding'] ) ) {
		$icon_padding = $attr['iconPadding'];
		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-modal-box-icon, ' . '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn img, ' . '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-modal-svg-class svg, ' . '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-lottie-animation svg' );
		$css->add_property( 'padding', $css->render_spacing( $icon_padding['Desktop'], isset($icon_padding['unit']['Desktop'])?$icon_padding['unit']['Desktop']:$icon_padding['unit']  ) );
	}

	if ( isset( $attr['iconBG'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-modal-box-icon' );
		$css->render_background( $attr['iconBG'], 'Desktop' );
		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-modal-svg-class svg' );
		$css->render_background( $attr['iconBG'], 'Desktop' );
		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-lottie-animation svg' );
		$css->render_background( $attr['iconBG'], 'Desktop' );
	}

	if ( isset( $attr['iconHoverBG'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn:hover .premium-modal-box-icon' );
		$css->render_background( $attr['iconHoverBG'], 'Desktop' );
		$css->set_selector( '.' . $unique_id . ' > .premium-modal-trigger-container button.premium-modal-trigger-btn:hover .premium-modal-svg-class svg' );
		$css->render_background( $attr['iconHoverBG'], 'Desktop' );
		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn:hover .premium-lottie-animation svg' );
		$css->render_background( $attr['iconHoverBG'], 'Desktop' );
	}

	if ( isset( $attr['iconHoverColor'] ) ) {
		$icon_HoverColor = $attr['iconHoverColor'];
		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn:hover .premium-modal-box-icon' );
		$css->add_property( 'fill', $css->render_string( $css->render_color( $icon_HoverColor ), '!important' ) );
		$css->add_property( 'color', $css->render_color( $icon_HoverColor ) );
		$css->set_selector( '.' . $unique_id . ' > .premium-modal-trigger-container button.premium-modal-trigger-btn:hover .premium-modal-svg-class svg' );
		$css->add_property( 'fill', $css->render_string( $css->render_color( $icon_HoverColor ), '!important' ) );
		$css->add_property( 'color', $css->render_string( $css->render_color( $icon_HoverColor ), '!important' ) );
		$css->set_selector( '.' . $unique_id . ' > .premium-modal-trigger-container button.premium-modal-trigger-btn:hover .premium-modal-box-icon:not(.icon-type-fe) svg *' );
		$css->add_property( 'fill', $css->render_string( $css->render_color( $icon_HoverColor ), '!important' ) );
		$css->set_selector( '.' . $unique_id . ' > .premium-modal-trigger-container button.premium-modal-trigger-btn:hover .premium-modal-svg-class svg *' );
		$css->add_property( 'fill', $css->render_string( $css->render_color( $icon_HoverColor ), '!important' ) );
	}

	if ( isset( $attr['triggerSettings'] ) && isset( $attr['triggerSettings'][0] ) ) {
		$icon_styles = $attr['triggerSettings'][0];
		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-modal-box-icon' );
		$css->add_property( 'margin-right', $css->render_string( $icon_styles['iconSpacing'], 'px' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn img' );
		$css->add_property( 'margin-right', $css->render_string( $icon_styles['iconSpacing'], 'px' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-modal-svg-class svg' );
		$css->add_property( 'margin-right', $css->render_string( $icon_styles['iconSpacing'], 'px' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-lottie-animation svg' );
		$css->add_property( 'margin-right', $css->render_string( $icon_styles['iconSpacing'], 'px' ) );
	}

	if ( isset( $attr['borderHoverColor'] ) ) {
		$hover_border = $attr['borderHoverColor'];
		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn:hover .premium-modal-box-icon' );
		$css->add_property( 'border-color', $css->render_string( $css->render_color( $hover_border ), '!important' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn:hover .premium-modal-svg-class svg' );
		$css->add_property( 'border-color', $css->render_string( $css->render_color( $hover_border ), '!important' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn:hover .premium-lottie-animation svg' );
		$css->add_property( 'border-color', $css->render_string( $css->render_color( $hover_border ), '!important' ) );
	}

	// Trigger Style for Image/Lottie
	if ( isset( $attr['imageWidth']['Desktop'] ) ) {
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container img' );
		$css->add_property( 'width', $css->render_range( $attr['imageWidth'], 'Desktop' ) );

		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container ' . '> .premium-lottie-animation' );
		$css->add_property( 'width', $css->render_range( $attr['imageWidth'], 'Desktop' ) );
	}
	if ( isset( $attr['triggerFilter'] ) ) {
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container ' . '> .premium-lottie-animation' );
		$css->add_property(
			'filter',
			'brightness(' . $attr['triggerFilter']['bright'] . '%)' . 'contrast(' . $attr['triggerFilter']['contrast'] . '%) ' . 'saturate(' . $attr['triggerFilter']['saturation'] . '%) ' . 'blur(' . $attr['triggerFilter']['blur'] . 'px) ' . 'hue-rotate(' . $attr['triggerFilter']['hue'] . 'deg)'
		);
	}
	if ( isset( $attr['triggerHoverFilter'] ) ) {
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container:hover ' . '> .premium-lottie-animation' );
		$css->add_property(
			'filter',
			'brightness(' . $attr['triggerHoverFilter']['bright'] . '%)' . 'contrast(' . $attr['triggerHoverFilter']['contrast'] . '%) ' . 'saturate(' . $attr['triggerHoverFilter']['saturation'] . '%) ' . 'blur(' . $attr['triggerHoverFilter']['blur'] . 'px) ' . 'hue-rotate(' . $attr['triggerHoverFilter']['hue'] . 'deg)'
		);
	}
	// Style For Button Trigger
	if ( isset( $attr['triggerTypography'] ) ) {
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container' . ' > button' . '> span' );
		$css->render_typography( $attr['triggerTypography'], 'Desktop' );
	}
	if ( isset( $attr['triggerPadding'] ) ) {
		$trigger_padding = $attr['triggerPadding'];
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container' . ' > button' );
		$css->add_property( 'padding', $css->render_spacing( $trigger_padding['Desktop'], isset($trigger_padding['unit']['Desktop'])?$trigger_padding['unit']['Desktop']:$trigger_padding['unit']  ) );
	}
	if ( isset( $attr['triggerBorder'] ) ) {
		$trigger_border_width  = $attr['triggerBorder']['borderWidth'];
		$trigger_border_radius = $attr['triggerBorder']['borderRadius'];
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container' . ' > button' );
		$css->add_property( 'border-width', $css->render_spacing( $trigger_border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $trigger_border_radius['Desktop'], 'px' ) );
	}
	// border Image
	if ( isset( $attr['triggerBorder'] ) ) {
		$trigger_border_width  = $attr['triggerBorder']['borderWidth'];
		$trigger_border_radius = $attr['triggerBorder']['borderRadius'];

		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container' . ' > img' );
		$css->add_property( 'border-width', $css->render_spacing( $trigger_border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $trigger_border_radius['Desktop'], 'px' ) );
	}
	// border text
	if ( isset( $attr['triggerBorder'] ) ) {
		$trigger_border_width  = $attr['triggerBorder']['borderWidth'];
		$trigger_border_radius = $attr['triggerBorder']['borderRadius'];
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container' . ' > .premium-modal-trigger-text' );
		$css->add_property( 'border-width', $css->render_spacing( $trigger_border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $trigger_border_radius['Desktop'], 'px' ) );
	}
	if ( isset( $attr['triggerTypography'] ) ) {
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container' . ' > .premium-modal-trigger-text' );
		$css->render_typography( $attr['triggerTypography'], 'Desktop' );
	}
	if ( isset( $attr['triggerPadding'] ) ) {
		$trigger_padding = $attr['triggerPadding'];
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container' . ' > .premium-modal-trigger-text' );
		$css->add_property( 'padding', $css->render_spacing( $trigger_padding['Desktop'], isset($trigger_padding['unit']['Desktop'])?$trigger_padding['unit']['Desktop']:$trigger_padding['unit']  ) );
	}
	// hover border
	if ( isset( $attr['triggerBorderH'] ) ) {
		$trigger_border_width  = $attr['triggerBorderH']['borderWidth'];
		$trigger_border_radius = $attr['triggerBorderH']['borderRadius'];
		$trigger_border_style  = $attr['triggerBorderH']['borderType'];
		$trigger_border_color  = $attr['triggerBorderH']['borderColor'];
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container' . ' > img:hover' );
		$css->add_property( 'border-color', $css->render_color( $trigger_border_color ) );
		$css->add_property( 'border-style', $css->render_string( $trigger_border_style, '' ) );

		$css->add_property( 'border-width', $css->render_spacing( $trigger_border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $trigger_border_radius['Desktop'], 'px' ) );
	}
	// hover border text
	if ( isset( $attr['triggerBorderH'] ) ) {
		$trigger_border_width  = $attr['triggerBorderH']['borderWidth'];
		$trigger_border_radius = $attr['triggerBorderH']['borderRadius'];
		$trigger_border_style  = $attr['triggerBorderH']['borderType'];
		$trigger_border_color  = $attr['triggerBorderH']['borderColor'];
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container:hover' . ' > .premium-modal-trigger-text' );
		$css->add_property( 'border-color', $css->render_color( $trigger_border_color ) );
		$css->add_property( 'border-style', $css->render_string( $trigger_border_style, '' ) );
		$css->add_property( 'border-width', $css->render_spacing( $trigger_border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $trigger_border_radius['Desktop'], 'px' ) );
	}

	// style for header
	// style for upper close button
	if ( isset( $attr['upperPadding'] ) ) {
		$upper_padding = $attr['upperPadding'];
		$css->set_selector( '.' . $unique_id . '.premium-popup__modal_wrap' . ' > .premium-popup__modal_content' .  '> .premium-modal-box-close-button-container' );
		$css->add_property( 'padding', $css->render_spacing( $upper_padding['Desktop'], isset($upper_padding['unit']['Desktop'])?$upper_padding['unit']['Desktop']:$upper_padding['unit']  ) );
	}
	if ( isset( $attr['upperBorder'] ) ) {
		$upper_border_width  = $attr['upperBorder']['borderWidth'];
		$upper_border_radius = $attr['upperBorder']['borderRadius'];
		$css->set_selector( '.' . $unique_id . '.premium-popup__modal_wrap' . ' > .premium-popup__modal_content' .  '> .premium-modal-box-close-button-container' );
		$css->add_property( 'border-width', $css->render_spacing( $upper_border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $upper_border_radius['Desktop'], 'px' ) );
	}
	if ( isset( $attr['upperStyles'][0]['hoverBackColor'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-modal-box-close-button-container:hover' );
		$css->add_property( 'background-color', $css->render_string( $css->render_color( $attr['upperStyles'][0]['hoverBackColor'] ), '!important' ) );
	}
	if ( isset( $attr['upperStyles'][0]['hoverColor'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-modal-box-close-button-container .premium-modal-box-modal-close' );
		$css->add_property( 'color', $css->render_color( $attr['upperStyles'][0]['color'] ) );

	}
	if ( isset( $attr['upperStyles'][0]['hoverColor'] ) ) {
		$css->set_selector( '.' . $unique_id . '  .premium-modal-box-close-button-container:hover .premium-modal-box-modal-close' );
		$css->add_property( 'color', $css->render_color( $attr['upperStyles'][0]['hoverColor'] ) );

	}

	if ( isset( $attr['upperIconWidth'] ) ) {
		$css->set_selector( '.' . $unique_id . '.premium-popup__modal_wrap' . ' > .premium-popup__modal_content' .  '> .premium-modal-box-close-button-container button' );
		$css->add_property( 'font-size', $css->render_range( $attr['upperIconWidth'], 'Desktop' ) );
	}
	if(isset($attr['closePosition'])){
		
		$css->set_selector( '.' . $unique_id . '.premium-popup__modal_wrap' . ' > .premium-popup__modal_content' . '> .premium-modal-box-close-button-container ' );
		if($attr['closePosition']== "top-left"){
		$css->add_property( 'top', '-'. $attr['upperIconWidth'][ 'Desktop']  .'px' );
		$css->add_property( 'left', '-'. $attr['upperIconWidth'][ 'Desktop']  .'px' );
		}
		if($attr['closePosition']== "top-right"){
		$css->add_property( 'top', '-'. $attr['upperIconWidth'][ 'Desktop']  .'px' );
		$css->add_property( 'right', '-'. $attr['upperIconWidth'][ 'Desktop']  .'px' );
		}
	}

	// Width & Height for Modal
	if ( isset( $attr['modalWidth'] ) ) {
		$css->set_selector( '.' . $unique_id . '.premium-popup__modal_wrap' . ' > .premium-popup__modal_content' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['modalWidth'], 'Desktop' ), '!important' ) );
	}

	if ( isset( $attr['modalBorder'] ) ) {
		$modal_border_width  = $attr['modalBorder']['borderWidth'];
		$modal_border_radius = $attr['modalBorder']['borderRadius'];
		$css->set_selector( '.' . $unique_id . '.premium-popup__modal_wrap' . ' > .premium-popup__modal_content' );
		$css->add_property( 'border-width', $css->render_spacing( $modal_border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $modal_border_radius['Desktop'], 'px' ) );
	}
	if ( isset( $attr['modalBackground'] ) ) {
		$css->set_selector( '.' . $unique_id . '.premium-popup__modal_wrap' . ' > .premium-popup__modal_wrap_overlay' );
		$css->render_background( $attr['modalBackground'], 'Desktop' );

	}
	if ( isset( $attr['modalPadding'] ) ) {
		$modal_padding = $attr['modalPadding'];
		$css->set_selector( '.' . $unique_id . '.premium-popup__modal_wrap' . ' > .premium-popup__modal_content' . '> .premium-modal-box-modal-body' . '> .premium-modal-box-modal-body-content' );
		$css->add_property( 'padding', $css->render_spacing( $modal_padding['Desktop'],isset( $modal_padding['unit']['Desktop'])? $modal_padding['unit']['Desktop']: $modal_padding['unit'] ) );
	}
	if ( isset( $attr['modalHeight'] ) ) {
		$css->set_selector( '.' . $unique_id . '.premium-popup__modal_wrap' . ' > .premium-popup__modal_content' );
		$css->add_property( 'max-height', $css->render_string( $css->render_range( $attr['modalHeight'], 'Desktop' ), '!important' ) );
	}
	if ( isset( $attr['containerBackground'] ) ) {
		$css->set_selector( '.' . $unique_id . '.premium-popup__modal_wrap' . ' > .premium-popup__modal_content' . '> .premium-modal-box-modal-body' );
		$css->render_background( $attr['containerBackground'], 'Desktop' );
	}

	$css->start_media_query( 'tablet' );

	if ( isset( $attr['align']['Tablet'] ) ) {
       $content_align      = $css->get_responsive_css( $attr['align'], 'Tablet' );
		$content_flex_align = 'left' === $content_align ? 'flex-start' : 'center';
		$content_flex_align = 'right' === $content_align ? 'flex-end' : $content_flex_align;

		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container' );
		$css->add_property( 'text-align', $css->render_string( $content_align, '!important' ) );
        $css->set_selector( '.' . $unique_id  );
        $css->add_property( 'align-self', $css->render_string(  $css->render_align_self($content_align), '!important' ) );
	}

	if ( isset( $attr['iconSize'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-modal-trigger-container' . ' .premium-modal-trigger-btn .premium-modal-box-icon' );
		$css->add_property( 'font-size', $css->render_string( $css->render_range( $attr['iconSize'], 'Tablet' ), '!important' ) );

		$css->set_selector( '.' . $unique_id . ' > .premium-modal-trigger-container' . ' .premium-modal-trigger-btn .premium-modal-box-icon svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Tablet' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Tablet' ), '!important' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container .premium-modal-trigger-btn .premium-modal-svg-class svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Tablet' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Tablet' ), '!important' ) );
	}
	// image style
	if ( isset( $attr['imgWidth'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-modal-trigger-container' . ' .premium-modal-trigger-btn' . ' > img' );
		$css->add_property( 'width', $css->render_range( $attr['imgWidth'], 'Tablet' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container .premium-modal-trigger-btn .premium-lottie-animation svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['imgWidth'], 'Tablet' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['imgWidth'], 'Tablet' ), '!important' ) );
	}

	if ( isset( $attr['iconBorder'] ) ) {
		$icon_border        = $attr['iconBorder'];
		$icon_border_width  = $icon_border['borderWidth'];
		$icon_border_radius = $icon_border['borderRadius'];
		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-modal-box-icon, ' . '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn img, ' . '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-modal-svg-class svg, ' . '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-lottie-animation svg' );
		$css->add_property( 'border-width', $css->render_spacing( $icon_border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $icon_border_radius['Tablet'], 'px' ) );
	}

	if ( isset( $attr['iconMargin'] ) ) {
		$icon_margin = $attr['iconMargin'];
		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-modal-box-icon, ' . '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn img, ' . '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-modal-svg-class svg, ' . '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-lottie-animation svg' );
		$css->add_property( 'margin', $css->render_string( $css->render_spacing( $icon_margin['Tablet'], isset($icon_margin['unit']['Tablet'])?$icon_margin['unit']['Tablet']:$icon_margin['unit']  ), '!important' ) );
	}
	if ( isset( $attr['iconPadding'] ) ) {
		$icon_padding = $attr['iconPadding'];
		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-modal-box-icon, ' . '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn img, ' . '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-modal-svg-class svg, ' . '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-lottie-animation svg' );
		$css->add_property( 'padding', $css->render_spacing( $icon_padding['Tablet'], isset($icon_padding['unit']['Tablet'])?$icon_padding['unit']['Tablet']:$icon_padding['unit']  ) );
	}

	if ( isset( $attr['iconBG'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-modal-box-icon' );
		$css->render_background( $attr['iconBG'], 'Tablet' );
		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-modal-svg-class svg' );
		$css->render_background( $attr['iconBG'], 'Tablet' );
		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-lottie-animation svg' );
		$css->render_background( $attr['iconBG'], 'Tablet' );
	}

	if ( isset( $attr['iconHoverBG'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn:hover .premium-modal-box-icon' );
		$css->render_background( $attr['iconHoverBG'], 'Tablet' );
		$css->set_selector( '.' . $unique_id . ' > .premium-modal-trigger-container button.premium-modal-trigger-btn:hover .premium-modal-svg-class svg' );
		$css->render_background( $attr['iconHoverBG'], 'Tablet' );
		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn:hover .premium-lottie-animation svg' );
		$css->render_background( $attr['iconHoverBG'], 'Tablet' );
	}

	if ( isset( $attr['triggerBorderH'] ) ) {
		$trigger_border_width  = $attr['triggerBorderH']['borderWidth'];
		$trigger_border_radius = $attr['triggerBorderH']['borderRadius'];
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container' . ' > .premium-modal-trigger-btn:hover' );
		$css->add_property( 'border-width', $css->render_spacing( $trigger_border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $trigger_border_radius['Tablet'], 'px' ) );
	}

	// Trigger Style for Image/Lottie
	if ( isset( $attr['imageWidth']['Tablet'] ) ) {
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container img' );
		$css->add_property( 'width', $css->render_range( $attr['imageWidth'], 'Tablet' ) );

		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container ' . '> .premium-lottie-animation' );
		$css->add_property( 'width', $css->render_range( $attr['imageWidth'], 'Tablet' ) );
	}

	// Style For Button Trigger
	if ( isset( $attr['triggerTypography'] ) ) {
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container' . ' > button' . ' > span' );
		$css->render_typography( $attr['triggerTypography'], 'Tablet' );
	}
	if ( isset( $attr['triggerPadding'] ) ) {
		$trigger_padding = $attr['triggerPadding'];
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container' . ' > button' );
		$css->add_property( 'padding', $css->render_spacing( $trigger_padding['Tablet'], isset($trigger_padding['unit']['Tablet']) ?$trigger_padding['unit']['Tablet']:$trigger_padding['unit'] ) );
	}
	if ( isset( $attr['triggerBorder'] ) ) {
		$trigger_border_width  = $attr['triggerBorder']['borderWidth'];
		$trigger_border_radius = $attr['triggerBorder']['borderRadius'];
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container' . ' > button' );
		$css->add_property( 'border-width', $css->render_spacing( $trigger_border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $trigger_border_radius['Tablet'], 'px' ) );
	}
	// border Image
	if ( isset( $attr['triggerBorder'] ) ) {
		$trigger_border_width  = $attr['triggerBorder']['borderWidth'];
		$trigger_border_radius = $attr['triggerBorder']['borderRadius'];
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container' . ' > img' );
		$css->add_property( 'border-width', $css->render_spacing( $trigger_border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $trigger_border_radius['Tablet'], 'px' ) );
	}
	// border text
	if ( isset( $attr['triggerBorder'] ) ) {
		$trigger_border_width  = $attr['triggerBorder']['borderWidth'];
		$trigger_border_radius = $attr['triggerBorder']['borderRadius'];
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container' . ' > .premium-modal-trigger-text' );
		$css->add_property( 'border-width', $css->render_spacing( $trigger_border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $trigger_border_radius['Tablet'], 'px' ) );
	}
	if ( isset( $attr['triggerTypography'] ) ) {
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container' . ' > .premium-modal-trigger-text' );
		$css->render_typography( $attr['triggerTypography'], 'Tablet' );
	}
	if ( isset( $attr['triggerPadding'] ) ) {
		$trigger_padding = $attr['triggerPadding'];
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container' . ' > .premium-modal-trigger-text' );
		$css->add_property( 'padding', $css->render_spacing( $trigger_padding['Tablet'], isset($trigger_padding['unit']['Tablet']) ?$trigger_padding['unit']['Tablet']:$trigger_padding['unit'] ) );
	}
	// hover border
	if ( isset( $attr['triggerBorderH'] ) ) {
		$trigger_border_width  = $attr['triggerBorderH']['borderWidth'];
		$trigger_border_radius = $attr['triggerBorderH']['borderRadius'];
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container' . ' > img:hover' );
		$css->add_property( 'border-width', $css->render_spacing( $trigger_border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $trigger_border_radius['Tablet'], 'px' ) );
	}
	// hover border text
	if ( isset( $attr['triggerBorderH'] ) ) {
		$trigger_border_width  = $attr['triggerBorderH']['borderWidth'];
		$trigger_border_radius = $attr['triggerBorderH']['borderRadius'];
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container:hover' . ' > .premium-modal-trigger-text' );
		$css->add_property( 'border-width', $css->render_spacing( $trigger_border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $trigger_border_radius['Tablet'], 'px' ) );
	}

	// style for upper close button
	if ( isset( $attr['upperPadding'] ) ) {
		$upper_padding = $attr['upperPadding'];
		$css->set_selector( '.' . $unique_id . '.premium-popup__modal_wrap' . ' > .premium-popup__modal_content' .  '> .premium-modal-box-close-button-container' );
		$css->add_property( 'padding', $css->render_spacing( $upper_padding['Tablet'], isset( $upper_padding['unit']['Tablet'])? $upper_padding['unit']['Tablet']: $upper_padding['unit'] ) );
	}
	if ( isset( $attr['upperBorder'] ) ) {
		$upper_border_width  = $attr['upperBorder']['borderWidth'];
		$upper_border_radius = $attr['upperBorder']['borderRadius'];
		$css->set_selector( '.' . $unique_id . '.premium-popup__modal_wrap' . ' > .premium-popup__modal_content' .  '> .premium-modal-box-close-button-container' );
		$css->add_property( 'border-width', $css->render_spacing( $upper_border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $upper_border_radius['Tablet'], 'px' ) );
	}

	if ( isset( $attr['upperIconWidth'] ) ) {
		$css->set_selector( '.' . $unique_id . '.premium-popup__modal_wrap' . ' > .premium-popup__modal_content' .  '> .premium-modal-box-close-button-container button' );
		$css->add_property( 'font-size', $css->render_range( $attr['upperIconWidth'], 'Tablet' ) );
	}

	// Width & Height for Modal
	if ( isset( $attr['modalWidth'] ) ) {
		$css->set_selector( '.' . $unique_id . '.premium-popup__modal_wrap' . ' > .premium-popup__modal_content' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['modalWidth'], 'Tablet' ), '!important' ) );
	}
	if ( isset( $attr['modalBackground'] ) ) {
		$css->set_selector( '.' . $unique_id . '.premium-popup__modal_wrap' . ' > .premium-popup__modal_wrap_overlay' );
		$css->render_background( $attr['modalBackground'], 'Tablet' );

	}
	if ( isset( $attr['modalBorder'] ) ) {
		$modal_border_width  = $attr['modalBorder']['borderWidth'];
		$modal_border_radius = $attr['modalBorder']['borderRadius'];
		$css->set_selector( '.' . $unique_id . '.premium-popup__modal_wrap' . ' > .premium-popup__modal_content' );
		$css->add_property( 'border-width', $css->render_spacing( $modal_border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $modal_border_radius['Tablet'], 'px' ) );
	}

	if ( isset( $attr['modalPadding'] ) ) {
		$modal_padding = $attr['modalPadding'];
		$css->set_selector( '.' . $unique_id . '.premium-popup__modal_wrap' . ' > .premium-popup__modal_content' . '> .premium-modal-box-modal-body' . '> .premium-modal-box-modal-body-content' );
		$css->add_property( 'padding', $css->render_spacing( $modal_padding['Tablet'], isset($modal_padding['unit']['Tablet'])?$modal_padding['unit']['Tablet']:$modal_padding['unit']  ) );
	}
	if ( isset( $attr['modalHeight'] ) ) {
		$css->set_selector( '.' . $unique_id . '.premium-popup__modal_wrap' . ' > .premium-popup__modal_content' );
		$css->add_property( 'max-height', $css->render_string( $css->render_range( $attr['modalHeight'], 'Tablet' ), '!important' ) );
	}
	if ( isset( $attr['containerBackground'] ) ) {
		$css->set_selector( '.' . $unique_id . '.premium-popup__modal_wrap' . ' > .premium-popup__modal_content' . '> .premium-modal-box-modal-body' );
		$css->render_background( $attr['containerBackground'], 'Tablet' );
	}
	$css->stop_media_query();
	$css->start_media_query( 'mobile' );

	if ( isset( $attr['align']['Mobile'] ) ) {
       $content_align      = $css->get_responsive_css( $attr['align'], 'Desktop' );
		$content_flex_align = 'left' === $content_align ? 'flex-start' : 'center';
		$content_flex_align = 'right' === $content_align ? 'flex-end' : $content_flex_align;
	
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container' );
		$css->add_property( 'text-align', $css->render_string( $content_align, '!important' ) );
        $css->set_selector( '.' . $unique_id  );
        $css->add_property( 'align-self', $css->render_string(  $css->render_align_self($content_align), '!important' ) );
	}

	if ( isset( $attr['iconSize'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-modal-trigger-container' . ' .premium-modal-trigger-btn .premium-modal-box-icon' );
		$css->add_property( 'font-size', $css->render_string( $css->render_range( $attr['iconSize'], 'Mobile' ), '!important' ) );

		$css->set_selector( '.' . $unique_id . ' > .premium-modal-trigger-container' . ' .premium-modal-trigger-btn .premium-modal-box-icon svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Mobile' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Mobile' ), '!important' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container .premium-modal-trigger-btn .premium-modal-svg-class svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Mobile' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Mobile' ), '!important' ) );
	}
	// image style
	if ( isset( $attr['imgWidth'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-modal-trigger-container' . ' .premium-modal-trigger-btn' . ' > img' );
		$css->add_property( 'width', $css->render_range( $attr['imgWidth'], 'Mobile' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container .premium-modal-trigger-btn .premium-lottie-animation svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['imgWidth'], 'Mobile' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['imgWidth'], 'Mobile' ), '!important' ) );
	}

	if ( isset( $attr['iconBorder'] ) ) {
		$icon_border        = $attr['iconBorder'];
		$icon_border_width  = $icon_border['borderWidth'];
		$icon_border_radius = $icon_border['borderRadius'];
		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-modal-box-icon, ' . '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn img, ' . '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-modal-svg-class svg, ' . '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-lottie-animation svg' );
		$css->add_property( 'border-width', $css->render_spacing( $icon_border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $icon_border_radius['Mobile'], 'px' ) );
	}

	if ( isset( $attr['iconMargin'] ) ) {
		$icon_margin = $attr['iconMargin'];
		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-modal-box-icon, ' . '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn img, ' . '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-modal-svg-class svg, ' . '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-lottie-animation svg' );
		$css->add_property( 'margin', $css->render_string( $css->render_spacing( $icon_margin['Mobile'], isset($icon_margin['unit']['Mobile'])?$icon_margin['unit']['Mobile']:$icon_margin['unit']  ), '!important' ) );
	}
	if ( isset( $attr['iconPadding'] ) ) {
		$icon_padding = $attr['iconPadding'];
		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-modal-box-icon, ' . '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn img, ' . '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-modal-svg-class svg, ' . '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-lottie-animation svg' );
		$css->add_property( 'padding', $css->render_spacing( $icon_padding['Mobile'], isset($icon_padding['unit']['Mobile']) ?$icon_padding['unit']['Mobile']:$icon_padding['unit'] ) );
	}

	if ( isset( $attr['iconBG'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-modal-box-icon' );
		$css->render_background( $attr['iconBG'], 'Mobile' );
		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-modal-svg-class svg' );
		$css->render_background( $attr['iconBG'], 'Mobile' );
		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-lottie-animation svg' );
		$css->render_background( $attr['iconBG'], 'Mobile' );
	}

	if ( isset( $attr['iconHoverBG'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn:hover .premium-modal-box-icon' );
		$css->render_background( $attr['iconHoverBG'], 'Mobile' );
		$css->set_selector( '.' . $unique_id . ' > .premium-modal-trigger-container button.premium-modal-trigger-btn:hover .premium-modal-svg-class svg' );
		$css->render_background( $attr['iconHoverBG'], 'Mobile' );
		$css->set_selector( '.' . $unique_id . ' .premium-modal-trigger-container button.premium-modal-trigger-btn:hover .premium-lottie-animation svg' );
		$css->render_background( $attr['iconHoverBG'], 'Mobile' );
	}

	if ( isset( $attr['triggerBorderH'] ) ) {
		$trigger_border_width  = $attr['triggerBorderH']['borderWidth'];
		$trigger_border_radius = $attr['triggerBorderH']['borderRadius'];
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container' . ' > .premium-modal-trigger-btn:hover' );
		$css->add_property( 'border-width', $css->render_spacing( $trigger_border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $trigger_border_radius['Mobile'], 'px' ) );
	}

	// Trigger Style for Image/Lottie
	if ( isset( $attr['imageWidth']['Mobile'] ) ) {
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container img' );
		$css->add_property( 'width', $css->render_range( $attr['imageWidth'], 'Mobile' ) );

		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container ' . '> .premium-lottie-animation' );
		$css->add_property( 'width', $css->render_range( $attr['imageWidth'], 'Mobile' ) );
	}

	// Style For Button Trigger
	if ( isset( $attr['triggerTypography'] ) ) {
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container' . ' > button' . ' > span' );
		$css->render_typography( $attr['triggerTypography'], 'Mobile' );
	}
	if ( isset( $attr['triggerPadding'] ) ) {
		$trigger_padding = $attr['triggerPadding'];
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container' . ' > button' );
		$css->add_property( 'padding', $css->render_spacing( $trigger_padding['Mobile'] , isset($trigger_padding['unit']['Mobile'])?$trigger_padding['unit']['Mobile']:$trigger_padding['unit']  ) );
	}
	if ( isset( $attr['triggerBorder'] ) ) {
		$trigger_border_width  = $attr['triggerBorder']['borderWidth'];
		$trigger_border_radius = $attr['triggerBorder']['borderRadius'];
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container' . ' > button' );
		$css->add_property( 'border-width', $css->render_spacing( $trigger_border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $trigger_border_radius['Mobile'], 'px' ) );
	}
	// border Image
	if ( isset( $attr['triggerBorder'] ) ) {
		$trigger_border_width  = $attr['triggerBorder']['borderWidth'];
		$trigger_border_radius = $attr['triggerBorder']['borderRadius'];
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container' . ' > img' );
		$css->add_property( 'border-width', $css->render_spacing( $trigger_border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $trigger_border_radius['Mobile'], 'px' ) );
	}
	// border text
	if ( isset( $attr['triggerBorder'] ) ) {
		$trigger_border_width  = $attr['triggerBorder']['borderWidth'];
		$trigger_border_radius = $attr['triggerBorder']['borderRadius'];
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container' . ' > .premium-modal-trigger-text' );
		$css->add_property( 'border-width', $css->render_spacing( $trigger_border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $trigger_border_radius['Mobile'], 'px' ) );
	}
	if ( isset( $attr['triggerTypography'] ) ) {
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container' . ' > .premium-modal-trigger-text' );
		$css->render_typography( $attr['triggerTypography'], 'Mobile' );
	}
	if ( isset( $attr['triggerPadding'] ) ) {
		$trigger_padding = $attr['triggerPadding'];
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container' . ' > .premium-modal-trigger-text' );
		$css->add_property( 'padding', $css->render_spacing( $trigger_padding['Mobile'], isset($trigger_padding['unit']['Mobile'])?$trigger_padding['unit']['Mobile']:$trigger_padding['unit']  ) );
	}
	// hover border
	if ( isset( $attr['triggerBorderH'] ) ) {
		$trigger_border_width  = $attr['triggerBorderH']['borderWidth'];
		$trigger_border_radius = $attr['triggerBorderH']['borderRadius'];
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container' . ' > img:hover' );
		$css->add_property( 'border-width', $css->render_spacing( $trigger_border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $trigger_border_radius['Mobile'], 'px' ) );
	}
	// hover border text
	if ( isset( $attr['triggerBorderH'] ) ) {
		$trigger_border_width  = $attr['triggerBorderH']['borderWidth'];
		$trigger_border_radius = $attr['triggerBorderH']['borderRadius'];
		$css->set_selector( '.' . $unique_id . '> .premium-modal-trigger-container:hover' . ' > .premium-modal-trigger-text' );
		$css->add_property( 'border-width', $css->render_spacing( $trigger_border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $trigger_border_radius['Mobile'], 'px' ) );
	}

	// style for upper close button
	if ( isset( $attr['upperPadding'] ) ) {
		$upper_padding = $attr['upperPadding'];
		$css->set_selector( '.' . $unique_id . '.premium-popup__modal_wrap' . ' > .premium-popup__modal_content' .  '> .premium-modal-box-close-button-container' );
		$css->add_property( 'padding', $css->render_spacing( $upper_padding['Mobile'], isset($upper_padding['unit']['Mobile'])?$upper_padding['unit']['Mobile']:$upper_padding['unit']  ) );
	}
	if ( isset( $attr['upperBorder'] ) ) {
		$upper_border_width  = $attr['upperBorder']['borderWidth'];
		$upper_border_radius = $attr['upperBorder']['borderRadius'];
		$css->set_selector( '.' . $unique_id . '.premium-popup__modal_wrap' . ' > .premium-popup__modal_content' .  '> .premium-modal-box-close-button-container' );
		$css->add_property( 'border-width', $css->render_spacing( $upper_border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $upper_border_radius['Mobile'], 'px' ) );
	}

	if ( isset( $attr['upperIconWidth'] ) ) {
		$css->set_selector( '.' . $unique_id . '.premium-popup__modal_wrap' . ' > .premium-popup__modal_content' .  '> .premium-modal-box-close-button-container button' );
		$css->add_property( 'font-size', $css->render_range( $attr['upperIconWidth'], 'Mobile' ) );
	}

	// Width & Height for Modal
	if ( isset( $attr['modalWidth'] ) ) {
		$css->set_selector( '.' . $unique_id . '.premium-popup__modal_wrap' . ' > .premium-popup__modal_content' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['modalWidth'], 'Mobile' ), '!important' ) );
	}

	if ( isset( $attr['modalBackground'] ) ) {
		$css->set_selector( '.' . $unique_id . '.premium-popup__modal_wrap' . ' > .premium-popup__modal_wrap_overlay' );
		$css->render_background( $attr['modalBackground'], 'Mobile' );

	}
	if ( isset( $attr['modalBorder'] ) ) {
		$modal_border_width  = $attr['modalBorder']['borderWidth'];
		$modal_border_radius = $attr['modalBorder']['borderRadius'];
		$css->set_selector( '.' . $unique_id . '.premium-popup__modal_wrap' . ' > .premium-popup__modal_content' );
		$css->add_property( 'border-width', $css->render_spacing( $modal_border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $modal_border_radius['Mobile'], 'px' ) );
	}

	if ( isset( $attr['modalPadding'] ) ) {
		$modal_padding = $attr['modalPadding'];
		$css->set_selector( '.' . $unique_id . '.premium-popup__modal_wrap' . ' > .premium-popup__modal_content' . '> .premium-modal-box-modal-body' . '> .premium-modal-box-modal-body-content' );
		$css->add_property( 'padding', $css->render_spacing( $modal_padding['Mobile'], isset($modal_padding['unit']['Mobile'])?$modal_padding['unit']['Mobile']:$modal_padding['unit']  ) );
	}
	if ( isset( $attr['modalHeight'] ) ) {
		$css->set_selector( '.' . $unique_id . '.premium-popup__modal_wrap' . ' > .premium-popup__modal_content');
		$css->add_property( 'max-height', $css->render_string( $css->render_range( $attr['modalHeight'], 'Mobile' ), '!important' ) );
	}
	if ( isset( $attr['containerBackground'] ) ) {
		$css->set_selector( '.' . $unique_id . '.premium-popup__modal_wrap' . ' > .premium-popup__modal_content' . '> .premium-modal-box-modal-body' );
		$css->render_background( $attr['containerBackground'], 'Mobile' );
	}
	$css->stop_media_query();
	return $css->css_output();
}

/**
 * Renders the `premium/modal` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_modal( $attributes, $content, $block ) {
	$block_helpers = pbg_blocks_helper();
	// Enqueue frontend JavaScript and CSS
	if ( $block_helpers->it_is_not_amp() ) {
		if ( (isset( $attributes["iconTypeSelect"] ) && $attributes["iconTypeSelect"] == "lottie")  || (isset($attributes['triggerSettings']) && $attributes['triggerSettings'][0]['triggerType'] =='lottie')) {
			wp_enqueue_script(
				'pbg-lottie',
				PREMIUM_BLOCKS_URL . 'assets/js/lib/lottie.min.js',
				array( 'jquery' ),
				PREMIUM_BLOCKS_VERSION,
				true
			);
		}
		wp_enqueue_script(
			'pbg-modal-box',
			PREMIUM_BLOCKS_URL . 'assets/js/minified/modal-box.min.js',
			array('jquery'),
			PREMIUM_BLOCKS_VERSION,
			true
		);
	}

	return $content;
}




/**
 * Register the modal block.
 *
 * @uses render_block_pbg_modal()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_modal() {
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	register_block_type(
		PREMIUM_BLOCKS_PATH . '/blocks-config/Modal',
		array(
			'render_callback' => 'render_block_pbg_modal',
		)
	);
}

register_block_pbg_modal();
