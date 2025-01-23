<?php
/**
 * Server-side rendering of the `pbg/icon-box` block.
 *
 * @package WordPress
 */

/**
 * Get Icon Box Block CSS
 *
 * Return Frontend CSS for Icon Box.
 *
 * @access public
 *
 * @param string $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_icon_box_css_style( $attr, $unique_id ) {
	$css = new Premium_Blocks_css();

	// container style
	if ( isset( $attr['containerMargin'] ) ) {
		$container_margin = $attr['containerMargin'];
		$container_margin_unit=isset($container_margin['unit']['Desktop'])?$container_margin['unit']['Desktop']:$container_margin['unit'];
		$css->set_selector( '.' . $unique_id . " .premium-icon-box-content");
		$css->add_property( 'margin', $css->render_string($css->render_spacing( $container_margin['Desktop'], $container_margin_unit ) , '!important' ));
	}

	if ( isset( $attr['containerPadding'] ) ) {
		$container_padding = $attr['containerPadding'];
		$container_padding_unit=isset($container_padding['unit']['Desktop'])?$container_padding['unit']['Desktop']:$container_padding['unit'];

		$css->set_selector( '.' . $unique_id . " .premium-icon-box-content");
		$css->add_property( 'padding', $css->render_string( $css->render_spacing( $container_padding['Desktop'], $container_padding_unit ), '!important' ) );
	}
	if ( isset( $attr['containerBackground'] ) ) {
		$css->set_selector( '.' . $unique_id . " .premium-icon-box-content");
		$css->render_background( $attr['containerBackground'], 'Desktop' );

	}
	if ( isset( $attr['containerHoverBackground'] ) ) {
		$css->set_selector( '.' . $unique_id . " .premium-icon-box-content:hover");
		$css->render_background( $attr['containerHoverBackground'], 'Desktop' );

	}

	if ( isset( $attr['align'] ) ) {
		$css->set_selector( '.' . $unique_id . " .premium-icon-box-content");
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['align'], 'Desktop' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-button-group' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['align'], 'Desktop' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-button-group_wrap' );
		$css->add_property( 'justify-content', $css->get_responsive_css( $attr['align'], 'Desktop' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-icon-container' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['align'], 'Desktop' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-text .premium-text-wrap' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['align'], 'Desktop' ) );
	}

	if ( isset( $attr['containerBorder'] ) ) {
		$container_border        = $attr['containerBorder'];
		$container_border_width  = $container_border['borderWidth'];
		$container_border_radius = $container_border['borderRadius'];

		$css->set_selector( '.' . $unique_id . " .premium-icon-box-content");
		$css->add_property( 'border-width', $css->render_spacing( $container_border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $container_border_radius['Desktop'], 'px' ) );
		if(isset($container_border['borderColor'])){
			$css->add_property( 'border-color', $css->render_color( $container_border['borderColor'] ) );
		 }
		$css->add_property( 'border-style', $css->render_string( $container_border['borderType'], '' ) );
	}

	if ( isset( $attr['containerShadow'] ) ) {
		$css->set_selector( '.' . $unique_id . " .premium-icon-box-content");
		$css->add_property( 'box-shadow', $css->render_shadow( $attr['containerShadow'] ) );
	}

	if ( isset( $attr['containerHoverShadow'] )  ) {
		$css->set_selector( '.' . $unique_id . " .premium-icon-box-content:hover");
		$css->add_property( 'box-shadow', $css->render_shadow( $attr['containerHoverShadow'] ) );
	}

	if ( isset( $attr['iconRange'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .is-style-var1-icon' );
		$css->add_property( 'left', $css->render_string( $attr['iconRange'], '% !important' ) );
	}

	if ( isset( $attr['iconHorRange'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .is-style-horizontal1-icon' );
		$css->add_property( 'top', $css->render_string( $attr['iconHorRange'], '% !important' ) );
	}

	$css->start_media_query( 'tablet' );
	// container style
	if ( isset( $attr['containerMargin'] ) ) {
		$container_margin = $attr['containerMargin'];
		$container_margin_unit=isset($container_margin['unit']['Tablet'])?$container_margin['unit']['Tablet']:$container_margin['unit'];
		$css->set_selector( '.' . $unique_id . " .premium-icon-box-content");
		$css->add_property( 'margin', $css->render_string($css->render_spacing( $container_margin['Tablet'], $container_margin_unit ) , '!important' ));
	}

	if ( isset( $attr['containerPadding'] ) ) {
		$container_padding = $attr['containerPadding'];
		$container_padding_unit=isset($container_padding['unit']['Tablet'])?$container_padding['unit']['Tablet']:$container_padding['unit'];

		$css->set_selector( '.' . $unique_id . " .premium-icon-box-content");
		$css->add_property( 'padding', $css->render_string( $css->render_spacing( $container_padding['Tablet'], $container_padding_unit ), '!important' ) );
	}
	if ( isset( $attr['containerBackground'] ) ) {
		$css->set_selector( '.' . $unique_id . " .premium-icon-box-content");
		$css->render_background( $attr['containerBackground'], 'Tablet' );

	}
	if ( isset( $attr['containerHoverBackground'] ) ) {
		$css->set_selector( '.' . $unique_id . " .premium-icon-box-content:hover");
		$css->render_background( $attr['containerHoverBackground'], 'Tablet' );
	}

	if ( isset( $attr['align'] ) ) {
		$css->set_selector( '.' . $unique_id . " .premium-icon-box-content");
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['align'], 'Tablet' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-button-group' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['align'], 'Tablet' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-button-group_wrap' );
		$css->add_property( 'justify-content', $css->get_responsive_css( $attr['align'], 'Tablet' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-icon-container' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['align'], 'Tablet' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-text .premium-text-wrap' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['align'], 'Tablet' ) );
	}

	if ( isset( $attr['containerBorder'] ) ) {
		$container_border        = $attr['containerBorder'];
		$container_border_width  = $container_border['borderWidth'];
		$container_border_radius = $container_border['borderRadius'];

		$css->set_selector( '.' . $unique_id . " .premium-icon-box-content");
		$css->add_property( 'border-width', $css->render_spacing( $container_border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $container_border_radius['Tablet'], 'px' ) );
	}

	$css->stop_media_query();
	$css->start_media_query( 'mobile' );
	// container style
	if ( isset( $attr['containerMargin'] ) ) {
		$container_margin = $attr['containerMargin'];
		$container_margin_unit=isset($container_margin['unit']['Mobile'])?$container_margin['unit']['Mobile']:$container_margin['unit'];
		$css->set_selector( '.' . $unique_id . " .premium-icon-box-content");
		$css->add_property( 'margin', $css->render_string($css->render_spacing( $container_margin['Mobile'], $container_margin_unit ) , '!important' ));
	}

	if ( isset( $attr['containerPadding'] ) ) {
		$container_padding = $attr['containerPadding'];
		$container_padding_unit=isset($container_padding['unit']['Mobile'])?$container_padding['unit']['Mobile']:$container_padding['unit'];

		$css->set_selector( '.' . $unique_id . " .premium-icon-box-content");
		$css->add_property( 'padding', $css->render_string( $css->render_spacing( $container_padding['Mobile'], $container_padding_unit ), '!important' ) );
	}	
	
	if ( isset( $attr['containerBackground'] ) ) {
		$css->set_selector( '.' . $unique_id . " .premium-icon-box-content");
		$css->render_background( $attr['containerBackground'], 'Mobile' );

	}

	if ( isset( $attr['containerHoverBackground'] ) ) {
		$css->set_selector( '.' . $unique_id . " .premium-icon-box-content:hover");
		$css->render_background( $attr['containerHoverBackground'], 'Mobile' );
	}

	if ( isset( $attr['align'] ) ) {
		$css->set_selector( '.' . $unique_id . " .premium-icon-box-content");
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['align'], 'Mobile' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-button-group' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['align'], 'Mobile' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-button-group_wrap' );
		$css->add_property( 'justify-content', $css->get_responsive_css( $attr['align'], 'Mobile' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-icon-container' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['align'], 'Mobile' ) );

		$css->set_selector( '.' . $unique_id . ' .premium-text .premium-text-wrap' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['align'], 'Mobile' ) );
	}

	if ( isset( $attr['containerBorder'] ) ) {
		$container_border        = $attr['containerBorder'];
		$container_border_width  = $container_border['borderWidth'];
		$container_border_radius = $container_border['borderRadius'];

		$css->set_selector( '.' . $unique_id . " .premium-icon-box-content");
		$css->add_property( 'border-width', $css->render_spacing( $container_border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $container_border_radius['Mobile'], 'px' ) );
	}

	$css->stop_media_query();
	return $css->css_output();
}

/**
 * Renders the `premium/icon-box` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_icon_box( $attributes, $content, $block ) {

	return $content;
}




/**
 * Register the icon_box block.
 *
 * @uses render_block_pbg_icon_box()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_icon_box() {
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	register_block_type(
		PREMIUM_BLOCKS_PATH . '/blocks-config/icon-box',
		array(
			'render_callback' => 'render_block_pbg_icon_box',
		)
	);
}

register_block_pbg_icon_box();
