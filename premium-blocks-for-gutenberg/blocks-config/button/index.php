<?php
// Move this file to "blocks-config" folder with name "button.php".

/**
 * Server-side rendering of the `premium/button` block.
 *
 * @package WordPress
 */

function get_premium_button_css_style( $attr, $unique_id ) {
	$css = new Premium_Blocks_css();

	// Button Style

	if ( isset( $attr['typography'] ) ) {
		$typography = $attr['typography'];
		$css->set_selector( '.' . $unique_id . '> .premium-button' );
		$css->render_typography( $typography, 'Desktop' );
	}
	if ( isset( $attr['btnWidth'] ) ) {
		$css->set_selector( '.' . $unique_id  );
		$css->add_property('width',$css->get_responsive_css($attr['btnWidth'] , 'Desktop' ));
	}
    if ( isset( $attr['boxShadow'] ) ) {
		$css->set_selector( '.' . $unique_id . '> .premium-button' );
        $css->add_property( 'box-shadow', $css->render_shadow( $attr['boxShadow'] ));
    }
    if ( isset( $attr['boxShadowHover'] ) ) {
		$css->set_selector( '.' . $unique_id . '> .premium-button:hover' );
        $css->add_property( 'box-shadow', $css->render_shadow( $attr['boxShadowHover'] ));
    }


	if ( isset( $attr['padding'] ) ) {
		$padding = $attr['padding'];
		$css->set_selector( '.' . $unique_id . '> .premium-button.wp-block-button__link' );
		$css->add_property( 'padding', $css->render_spacing( $padding['Desktop'], isset( $padding['unit']['Desktop'] ) ? $padding['unit']['Desktop'] : $padding['unit'] ) );
	}

	if ( isset( $attr['margin'] ) ) {
		$margin = $attr['margin'];
		$css->set_selector( '.' . $unique_id );
		$css->add_property( 'margin', $css->render_spacing( $margin['Desktop'], isset( $margin['unit']['Desktop'] ) ? $margin['unit']['Desktop'] : $margin['unit'] ) );
	}

	if ( isset( $attr['border'] ) ) {
		$border        = $attr['border'];
		$border_width  = $border['borderWidth'];
		$border_radius = $border['borderRadius'];

		$css->set_selector( '#' . $unique_id . '> .premium-button' );
		$css->add_property( 'border-width', $css->render_spacing( $border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $border_radius['Desktop'], 'px' ) );
		$css->add_property( 'border-style', "{$border['borderType']}" );
		if ( isset( $border['borderColor'] ) ) {
			$css->add_property( 'border-color', $css->render_string( $css->render_color( $border['borderColor'] ), '!important' ) );
		}
	}
	if ( isset( $attr['backgroundOptions'] ) ) {

		$css->set_selector( '#' . $unique_id . '> .premium-button' );
		$css->render_background( $attr['backgroundOptions'], 'Desktop' );
	}

	// icon styles
	if ( isset( $attr['iconSize'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-button .premium-button-icon' );
		$css->add_property( 'font-size', $css->render_range( $attr['iconSize'], 'Desktop' ) );
		$css->set_selector( '.' . $unique_id . ' .premium-button .premium-button-icon svg' );
		$css->add_property( 'width', $css->render_range( $attr['iconSize'], 'Desktop' ) );
		$css->add_property( 'height', $css->render_range( $attr['iconSize'], 'Desktop' ) );
		$css->set_selector( '.' . $unique_id . ' .premium-button-svg-class svg' );
		$css->add_property( 'width', $css->render_range( $attr['iconSize'], 'Desktop' ) );
		$css->add_property( 'height', $css->render_range( $attr['iconSize'], 'Desktop' ) );
	}
	if ( isset( $attr['imgWidth'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-button img' );
		$css->add_property( 'width', $css->render_range( $attr['imgWidth'], 'Desktop' ) );
		$css->set_selector( '.' . $unique_id . ' .premium-lottie-animation svg' );
		$css->add_property( 'width', $css->render_range( $attr['imgWidth'], 'Desktop' ) . '!important' );
		$css->add_property( 'height', $css->render_range( $attr['imgWidth'], 'Desktop' ) . '!important' );
	}
	if ( isset( $attr['iconColor'] )|| isset($attr['btnStyles'][0]['textColor']) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-button  .premium-button-icon' );
		$css->add_property( 'color', $css->render_color(isset( $attr['iconColor'] )? $attr['iconColor'] :"" ));
		$css->add_property( 'fill', $css->render_color(isset( $attr['iconColor'] )? $attr['iconColor']:"" ));
		$css->set_selector( '.' . $unique_id . ' .premium-button .premium-button-icon:not(.icon-type-fe) svg' );
		$css->add_property( 'color', isset( $attr['iconColor'] )? $attr['iconColor'] : $attr['btnStyles'][0]['textColor'] );
		$css->add_property( 'fill',isset( $attr['iconColor'] )? $attr['iconColor'] : $attr['btnStyles'][0]['textColor'] );
		$css->set_selector( '.' . $unique_id . ' .premium-button  .premium-button-svg-class svg' );
		$css->add_property( 'color', isset( $attr['iconColor'] )? $attr['iconColor'] : $attr['btnStyles'][0]['textColor'] );
		$css->add_property( 'fill',isset( $attr['iconColor'] )? $attr['iconColor'] : $attr['btnStyles'][0]['textColor'] );
		$css->set_selector( '.' . $unique_id . ' .premium-button  .premium-button-icon:not(.icon-type-fe) svg *' );
		$css->add_property( 'fill', isset( $attr['iconColor'] )? $attr['iconColor'] : $attr['btnStyles'][0]['textColor'] );
		$css->set_selector( '.' . $unique_id . ' .premium-button  .premium-button-svg-class svg path' );
		$css->add_property( 'fill',isset( $attr['iconColor'] )? $attr['iconColor'] : $attr['btnStyles'][0]['textColor'] );
	}
	if ( isset( $attr['iconHoverColor'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-button:hover .premium-button-icon' );
		$css->add_property( 'color', $attr['iconHoverColor'] );
		$css->add_property( 'fill', $attr['iconHoverColor'] );
		$css->set_selector( '.' . $unique_id . ' .premium-button:hover .premium-button-svg-class svg' );
		$css->add_property( 'color', $attr['iconHoverColor'] );
		$css->add_property( 'fill', $attr['iconHoverColor'] );
		$css->set_selector( '.' . $unique_id . ' .premium-button:hover .premium-button-icon:not(.icon-type-fe) svg *' );
		$css->add_property( 'color', $attr['iconHoverColor'] );
		$css->add_property( 'fill', $attr['iconHoverColor'] );
		$css->set_selector( '.' . $unique_id . ' .premium-button:hover .premium-button-svg-class svg path' );
		$css->add_property( 'fill', $attr['iconHoverColor'] );
	}
	if ( isset( $attr['iconHoverBG'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-button:hover .premium-button-icon' );
		$css->render_background( $attr['iconHoverBG'], 'Desktop' );
		$css->set_selector( '.' . $unique_id . ' .premium-button:hover .premium-button-svg-class svg' );
		$css->render_background( $attr['iconHoverBG'], 'Desktop' );
		$css->set_selector( '.' . $unique_id . ' .premium-button:hover .premium-lottie-animation svg' );
		$css->render_background( $attr['iconHoverBG'], 'Desktop' );
	}
	if ( isset( $attr['iconBG'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-button .premium-button-icon' );
		$css->render_background( $attr['iconBG'], 'Desktop' );
		$css->set_selector( '.' . $unique_id . ' .premium-button .premium-button-svg-class svg' );
		$css->render_background( $attr['iconBG'], 'Desktop' );
		$css->set_selector( '.' . $unique_id . ' .premium-button .premium-lottie-animation svg' );
		$css->render_background( $attr['iconBG'], 'Desktop' );
	}
	if ( isset( $attr['borderHoverColor'] ) ) {
		$hover_border = $attr['borderHoverColor'];
		$css->set_selector( '.' . $unique_id . ' .premium-button:hover .premium-button-icon' );
		$css->add_property( 'border-color', "{$hover_border}!important" );
		$css->set_selector( '.' . $unique_id . ' .premium-button:hover .premium-button-svg-class svg' );
		$css->add_property( 'border-color', "{$hover_border}!important" );
		// $css->set_selector( '#' . $unique_id . ' > .premium-button:hover' );
		// $css->add_property( 'border-color', "{$hover_border}!important" );
	}
	if ( isset( $attr['backgroundHoverOptions'] ) ) {
		$css->set_selector( '.' . $unique_id . '.premium-button__slide .premium-button::before, ' . '.' . $unique_id . '.premium-button__shutter .premium-button::before, ' . '.' . $unique_id . '.premium-button__radial .premium-button::before' );
		// $css->add_property( 'background-color', $attr['slideColor'] );
		$css->render_background( $attr['backgroundHoverOptions'], 'Desktop' );

	}
	if ( isset( $attr['backgroundHoverOptions'] ) ) {
		$css->set_selector( '#' . $unique_id . ' > .premium-button:hover , #' . $unique_id .'.premium-button:hover'  );
		// $css->add_property( 'background-color', $attr['slideColor'] );
		$css->render_background( $attr['backgroundHoverOptions'], 'Desktop' );
	}
	if ( isset( $attr['btnStyles'] ) && isset( $attr['btnStyles'][0] ) ) {
		$btn_styles = $attr['btnStyles'][0];
		$btn_hColor = $btn_styles['textHoverColor'];
		$css->set_selector( '#' . $unique_id . ' > .premium-button:hover , #'. $unique_id .'premium-button:hover' );
		if(isset($btn_styles['backHoverColor']) && !isset($attr['backgroundHoverOptions']['backgroundColor'])){
			$css->add_property( 'background-color', $css->render_string( $css->render_color( $btn_styles['backHoverColor'] ), '!important ' ) );
		}
		if(isset($btn_styles['borderHoverColor'])){
			$css->add_property( 'border-color', $css->render_string( $css->render_color( $btn_styles['borderHoverColor']), ' !important' ));

		}
		if(isset($btn_hColor)){
			$css->add_property( 'color', $css->render_string( $css->render_color( $btn_hColor ), ' !important' ) );
			$css->set_selector( '.' . $unique_id . ' > .premium-button:hover .premium-button-text-edit' );
			$css->add_property( 'color', $css->render_string( $css->render_color( $btn_hColor ), ' !important' ) );

		}
	}
	

	if ( isset( $attr['iconMargin'] ) ) {
		$icon_spacing = $attr['iconMargin'];
		$css->set_selector( '.' . $unique_id . ' .premium-button .premium-button-icon, ' . '.' . $unique_id . ' .premium-button img,' . '.' . $unique_id . ' .premium-button .premium-button-svg-class svg, ' . '.' . $unique_id . ' .premium-button .premium-lottie-animation svg' );
		$css->add_property( 'margin', $css->render_spacing( $icon_spacing['Desktop'], isset( $icon_spacing['unit']['Desktop'] ) ? $icon_spacing['unit']['Desktop'] : $icon_spacing['unit'] ) );
	}

	if ( isset( $attr['iconPadding'] ) ) {
		$padding = $attr['iconPadding'];
		$css->set_selector( '.' . $unique_id . ' .premium-button .premium-button-icon, ' . '.' . $unique_id . ' .premium-button img,' . '.' . $unique_id . ' .premium-button .premium-button-svg-class svg, ' . '.' . $unique_id . ' .premium-button .premium-lottie-animation svg' );
		$css->add_property( 'padding', $css->render_spacing( $padding['Desktop'], isset( $padding['unit']['Desktop'] ) ? $padding['unit']['Desktop'] : $padding['unit'] ) );
	}

	if ( isset( $attr['iconBorder'] ) ) {
		$icon_border   = $attr['iconBorder'];
		$border_width  = $icon_border['borderWidth'];
		$border_radius = $icon_border['borderRadius'];

		$css->set_selector( '#' . $unique_id . ' .premium-button .premium-button-icon, ' . '.' . $unique_id . ' .premium-button img,' . '.' . $unique_id . ' .premium-button .premium-button-svg-class svg, ' . '.' . $unique_id . ' .premium-button .premium-lottie-animation svg' );
		$css->add_property( 'border-width', $css->render_spacing( $border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $border_radius['Desktop'], 'px' ) );
		$css->add_property( 'border-style', "{$icon_border['borderType']}" );
		$css->add_property( 'border-color', $css->render_color($icon_border['borderColor']) );
	}
	if ( isset( $attr['iconBackground'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-button .premium-button-icon svg' );
		$css->render_background( $attr['iconBackground'], 'Desktop' );
		$css->set_selector( '.' . $unique_id . ' .premium-button .premium-button-icon svg *' );
		$css->render_background( $attr['iconBackground'], 'Desktop' );
	}

	$css->start_media_query( 'tablet' );

	// Button Style
	if ( isset( $attr['typography'] ) ) {
		$typography = $attr['typography'];
		$css->set_selector( '.' . $unique_id . '> .premium-button' );
		$css->render_typography( $typography, 'Tablet' );
	}
	if ( isset( $attr['btnWidth'] ) ) {
		$css->set_selector( '.' . $unique_id  );
		$css->add_property('width',$css->get_responsive_css($attr['btnWidth'] , 'Tablet' ));
	}


	if ( isset( $attr['padding'] ) ) {
		$padding = $attr['padding'];
		$css->set_selector( '.' . $unique_id . '> .premium-button.wp-block-button__link' );
		$css->add_property( 'padding', $css->render_spacing( $padding['Tablet'], isset( $padding['unit']['Tablet'] ) ? $padding['unit']['Tablet'] : $padding['unit'] ) );
	}

	if ( isset( $attr['margin'] ) ) {
		$margin = $attr['margin'];
		$css->set_selector( '.' . $unique_id  );
		$css->add_property( 'margin', $css->render_spacing( $margin['Tablet'], isset( $margin['unit']['Tablet'] ) ? $margin['unit']['Tablet'] : $margin['unit'] ) );
	}

	if ( isset( $attr['border'] ) ) {
		$border        = $attr['border'];
		$border_width  = $border['borderWidth'];
		$border_radius = $border['borderRadius'];

		$css->set_selector( '.' . $unique_id . '> .premium-button' );
		$css->add_property( 'border-width', $css->render_spacing( $border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $border_radius['Tablet'], 'px' ) );
	}
	if ( isset( $attr['backgroundOptions'] ) ) {
		$css->set_selector( '.' . $unique_id . '> .premium-button' );
		$css->render_background( $attr['backgroundOptions'], 'Tablet' );

	}
	if ( isset( $attr['backgroundHoverOptions'] ) ) {
		$css->set_selector( '.' . $unique_id . '.premium-button__slide .premium-button::before, ' . '.' . $unique_id . '.premium-button__shutter .premium-button::before, ' . '.' . $unique_id . '.premium-button__radial .premium-button::before' );
		// $css->add_property( 'background-color', $attr['slideColor'] );
		$css->render_background( $attr['backgroundHoverOptions'], 'Tablet' );

	}
	if ( isset( $attr['backgroundHoverOptions'] ) ) {
		$css->set_selector( '#' . $unique_id . ' > .premium-button:hover , #' . $unique_id .'.premium-button:hover'  );
		// $css->add_property( 'background-color', $attr['slideColor'] );
		$css->render_background( $attr['backgroundHoverOptions'], 'Tablet' );
	}
	// icon styles
	if ( isset( $attr['iconSize'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-button .premium-button-icon' );
		$css->add_property( 'font-size', $css->render_range( $attr['iconSize'], 'Tablet' ) );
		$css->set_selector( '.' . $unique_id . ' .premium-button .premium-button-icon svg' );
		$css->add_property( 'width', $css->render_range( $attr['iconSize'], 'Tablet' ) );
		$css->add_property( 'height', $css->render_range( $attr['iconSize'], 'Tablet' ) );
		$css->set_selector( '.' . $unique_id . ' .premium-button-svg-class svg' );
		$css->add_property( 'width', $css->render_range( $attr['iconSize'], 'Tablet' ) );
		$css->add_property( 'height', $css->render_range( $attr['iconSize'], 'Tablet' ) );
	}
	if ( isset( $attr['imgWidth'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-button img' );
		$css->add_property( 'width', $css->render_range( $attr['imgWidth'], 'Tablet' ) );
		$css->set_selector( '.' . $unique_id . ' .premium-lottie-animation svg' );
		$css->add_property( 'width', $css->render_range( $attr['imgWidth'], 'Tablet' ) . '!important' );
		$css->add_property( 'height', $css->render_range( $attr['imgWidth'], 'Tablet' ) . '!important' );
	}

	if ( isset( $attr['iconHoverBG'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-button:hover .premium-button-icon' );
		$css->render_background( $attr['iconHoverBG'], 'Tablet' );
		$css->set_selector( '.' . $unique_id . ' .premium-button:hover .premium-button-svg-class svg' );
		$css->render_background( $attr['iconHoverBG'], 'Tablet' );
		$css->set_selector( '.' . $unique_id . ' .premium-button:hover .premium-lottie-animation svg' );
		$css->render_background( $attr['iconHoverBG'], 'Tablet' );
	}
	if ( isset( $attr['iconBG'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-button .premium-button-icon' );
		$css->render_background( $attr['iconBG'], 'Tablet' );
		$css->set_selector( '.' . $unique_id . ' .premium-button .premium-button-svg-class svg' );
		$css->render_background( $attr['iconBG'], 'Tablet' );
		$css->set_selector( '.' . $unique_id . ' .premium-button .premium-lottie-animation svg' );
		$css->render_background( $attr['iconBG'], 'Tablet' );
	}

	if ( isset( $attr['iconMargin'] ) ) {
		$icon_spacing = $attr['iconMargin'];
		$css->set_selector( '.' . $unique_id . ' .premium-button .premium-button-icon, ' . '.' . $unique_id . ' .premium-button img,' . '.' . $unique_id . ' .premium-button .premium-button-svg-class svg, ' . '.' . $unique_id . ' .premium-button .premium-lottie-animation svg' );
		$css->add_property( 'margin', $css->render_spacing( $icon_spacing['Tablet'], isset( $icon_spacing['unit']['Tablet'] ) ? $icon_spacing['unit']['Tablet'] : $icon_spacing['unit'] ) );
	}

	if ( isset( $attr['iconPadding'] ) ) {
		$padding = $attr['iconPadding'];
		$css->set_selector( '.' . $unique_id . ' .premium-button .premium-button-icon, ' . '.' . $unique_id . ' .premium-button img,' . '.' . $unique_id . ' .premium-button .premium-button-svg-class svg, ' . '.' . $unique_id . ' .premium-button .premium-lottie-animation svg' );
		$css->add_property( 'padding', $css->render_spacing( $padding['Tablet'], isset( $padding['unit']['Tablet'] ) ? $padding['unit']['Tablet'] : $padding['unit'] ) );
	}

	if ( isset( $attr['iconBorder'] ) ) {
		$icon_border   = $attr['iconBorder'];
		$border_width  = $icon_border['borderWidth'];
		$border_radius = $icon_border['borderRadius'];

		$css->set_selector( '.' . $unique_id . ' .premium-button .premium-button-icon, ' . '.' . $unique_id . ' .premium-button img,' . '.' . $unique_id . ' .premium-button .premium-button-svg-class svg, ' . '.' . $unique_id . ' .premium-button .premium-lottie-animation svg' );
		$css->add_property( 'border-width', $css->render_spacing( $border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $border_radius['Tablet'], 'px' ) );
	}
	if ( isset( $attr['iconBackground'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-button .premium-button-icon svg' );
		$css->render_background( $attr['iconBackground'], 'Tablet' );
		$css->set_selector( '.' . $unique_id . ' .premium-button .premium-button-icon svg *' );
		$css->render_background( $attr['iconBackground'], 'Tablet' );
	}

	$css->stop_media_query();
	$css->start_media_query( 'mobile' );

	// Button Style
	if ( isset( $attr['typography'] ) ) {
		$typography = $attr['typography'];
		$css->set_selector( '.' . $unique_id . '> .premium-button' );
		$css->render_typography( $typography, 'Mobile' );
	}

	if ( isset( $attr['btnWidth'] ) ) {
		$css->set_selector( '.' . $unique_id  );
		$css->add_property('width',$css->get_responsive_css($attr['btnWidth'] , 'Mobile' ));
	}


	if ( isset( $attr['padding'] ) ) {
		$padding = $attr['padding'];
		$css->set_selector( '.' . $unique_id . '> .premium-button.wp-block-button__link' );
		$css->add_property( 'padding', $css->render_spacing( $padding['Mobile'], isset( $padding['unit']['Mobile'] ) ? $padding['unit']['Mobile'] : $padding['unit'] ) );
	}

	if ( isset( $attr['margin'] ) ) {
		$margin = $attr['margin'];
		$css->set_selector( '.' . $unique_id  );
		$css->add_property( 'margin', $css->render_spacing( $margin['Mobile'], isset( $margin['unit']['Mobile'] ) ? $margin['unit']['Mobile'] : $margin['unit'] ) );
	}

	if ( isset( $attr['border'] ) ) {
		$border        = $attr['border'];
		$border_width  = $border['borderWidth'];
		$border_radius = $border['borderRadius'];

		$css->set_selector( '.' . $unique_id . '> .premium-button' );
		$css->add_property( 'border-width', $css->render_spacing( $border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $border_radius['Mobile'], 'px' ) );
	}
	if ( isset( $attr['backgroundOptions'] ) ) {
		$css->set_selector( '.' . $unique_id . '> .premium-button'  );
		$css->render_background( $attr['backgroundOptions'], 'Mobile' );

	}

	if ( isset( $attr['backgroundHoverOptions'] ) ) {
		$css->set_selector( '.' . $unique_id . '.premium-button__slide .premium-button::before, ' . '.' . $unique_id . '.premium-button__shutter .premium-button::before, ' . '.' . $unique_id . '.premium-button__radial .premium-button::before' );
		// $css->add_property( 'background-color', $attr['slideColor'] );
		$css->render_background( $attr['backgroundHoverOptions'], 'Mobile' );

	}
	if ( isset( $attr['backgroundHoverOptions'] ) ) {
		$css->set_selector( '#' . $unique_id . ' > .premium-button:hover , #' . $unique_id .'.premium-button:hover'  );
		// $css->add_property( 'background-color', $attr['slideColor'] );
		$css->render_background( $attr['backgroundHoverOptions'], 'Mobile' );
	}
	// icon styles
	if ( isset( $attr['iconSize'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-button .premium-button-icon' );
		$css->add_property( 'font-size', $css->render_range( $attr['iconSize'], 'Mobile' ) );
		$css->set_selector( '.' . $unique_id . ' .premium-button .premium-button-icon svg' );
		$css->add_property( 'width', $css->render_range( $attr['iconSize'], 'Mobile' ) );
		$css->add_property( 'height', $css->render_range( $attr['iconSize'], 'Mobile' ) );
		$css->set_selector( '.' . $unique_id . ' .premium-button-svg-class svg' );
		$css->add_property( 'width', $css->render_range( $attr['iconSize'], 'Mobile' ) );
		$css->add_property( 'height', $css->render_range( $attr['iconSize'], 'Mobile' ) );
	}
	if ( isset( $attr['imgWidth'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-button img' );
		$css->add_property( 'width', $css->render_range( $attr['imgWidth'], 'Mobile' ) );
		$css->set_selector( '.' . $unique_id . ' .premium-lottie-animation svg' );
		$css->add_property( 'width', $css->render_range( $attr['imgWidth'], 'Mobile' ) . '!important' );
		$css->add_property( 'height', $css->render_range( $attr['imgWidth'], 'Mobile' ) . '!important' );
	}

	if ( isset( $attr['iconHoverBG'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-button:hover .premium-button-icon' );
		$css->render_background( $attr['iconHoverBG'], 'Mobile' );
		$css->set_selector( '.' . $unique_id . ' .premium-button:hover .premium-button-svg-class svg' );
		$css->render_background( $attr['iconHoverBG'], 'Mobile' );
		$css->set_selector( '.' . $unique_id . ' .premium-button:hover .premium-lottie-animation svg' );
		$css->render_background( $attr['iconHoverBG'], 'Mobile' );
	}
	if ( isset( $attr['iconBG'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-button .premium-button-icon' );
		$css->render_background( $attr['iconBG'], 'Mobile' );
		$css->set_selector( '.' . $unique_id . ' .premium-button .premium-button-svg-class svg' );
		$css->render_background( $attr['iconBG'], 'Mobile' );
		$css->set_selector( '.' . $unique_id . ' .premium-button .premium-lottie-animation svg' );
		$css->render_background( $attr['iconBG'], 'Mobile' );
	}

	if ( isset( $attr['iconMargin'] ) ) {
		$icon_spacing = $attr['iconMargin'];
		$css->set_selector( '.' . $unique_id . ' .premium-button .premium-button-icon, ' . '.' . $unique_id . ' .premium-button img,' . '.' . $unique_id . ' .premium-button .premium-button-svg-class svg, ' . '.' . $unique_id . ' .premium-button .premium-lottie-animation svg' );
		$css->add_property( 'margin', $css->render_spacing( $icon_spacing['Mobile'], isset( $icon_spacing['unit']['Mobile'] ) ? $icon_spacing['unit']['Mobile'] : $icon_spacing['unit'] ) );
	}

	if ( isset( $attr['iconPadding'] ) ) {
		$padding = $attr['iconPadding'];
		$css->set_selector( '.' . $unique_id . ' .premium-button .premium-button-icon, ' . '.' . $unique_id . ' .premium-button img,' . '.' . $unique_id . ' .premium-button .premium-button-svg-class svg, ' . '.' . $unique_id . ' .premium-button .premium-lottie-animation svg' );
		$css->add_property( 'padding', $css->render_spacing( $padding['Mobile'], isset( $padding['unit']['Mobile'] ) ? $padding['unit']['Mobile'] : $padding['unit'] ) );
	}

	if ( isset( $attr['iconBorder'] ) ) {
		$icon_border   = $attr['iconBorder'];
		$border_width  = $icon_border['borderWidth'];
		$border_radius = $icon_border['borderRadius'];

		$css->set_selector( '.' . $unique_id . ' .premium-button .premium-button-icon, ' . '.' . $unique_id . ' .premium-button img,' . '.' . $unique_id . ' .premium-button .premium-button-svg-class svg, ' . '.' . $unique_id . ' .premium-button .premium-lottie-animation svg' );
		$css->add_property( 'border-width', $css->render_spacing( $border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $border_radius['Mobile'], 'px' ) );
	}
	if ( isset( $attr['iconBackground'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-button .premium-button-icon svg' );
		$css->render_background( $attr['iconBackground'], 'Mobile' );
		$css->set_selector( '.' . $unique_id . ' .premium-button .premium-button-icon svg *' );
		$css->render_background( $attr['iconBackground'], 'Mobile' );
	}

	$css->stop_media_query();
	return $css->css_output();
}

/**
 * Renders the `premium/button` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_button( $attributes, $content, $block ) {
	$block_helpers = pbg_blocks_helper();

	// Enqueue frontend JS/CSS.
	if ( $block_helpers->it_is_not_amp() ) {
		wp_enqueue_script(
			'pbg-button',
			PREMIUM_BLOCKS_URL . 'assets/js/minified/button.min.js',
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
 * Register the button block.
 *
 * @uses render_block_pbg_button()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_button() {
	register_block_type(
		'premium/button',
		array(
			'render_callback' => 'render_block_pbg_button',
			'editor_style'    => 'premium-blocks-editor-css',
			'editor_script'   => 'pbg-blocks-js',
		)
	);
}

register_block_pbg_button();
