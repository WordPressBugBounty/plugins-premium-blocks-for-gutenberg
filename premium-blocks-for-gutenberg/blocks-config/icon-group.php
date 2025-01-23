<?php
// Move this file to "blocks-config" folder with name "icon-group.php".

/**
 * Server-side rendering of the `premium/icon group` block.
 *
 * @package WordPress
 */

function get_premium_icon_group_css( $attr, $unique_id ) {
	$block_helpers          = pbg_blocks_helper();
	$css                    = new Premium_Blocks_css();
	$media_query            = array();
	$media_query['mobile']  = apply_filters( 'Premium_BLocks_mobile_media_query', '(max-width: 767px)' );
	$media_query['tablet']  = apply_filters( 'Premium_BLocks_tablet_media_query', '(max-width: 1024px)' );
	$media_query['desktop'] = apply_filters( 'Premium_BLocks_tablet_media_query', '(min-width: 1025px)' );

	// icon Size
	if ( isset( $attr['iconsSize']['Desktop'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-icon__container .premium-icon-type' );

		$css->set_selector( '.' . $unique_id . ' .premium-icon__container .premium-icon-type svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconsSize'], 'Desktop' ) ));
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconsSize'], 'Desktop' ) ));

		$css->set_selector( '.' . $unique_id . ' .premium-icon__container .premium-icon-svg-class svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconsSize'], 'Desktop' ) ));
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconsSize'], 'Desktop' ) ));

		$css->set_selector( '.' . $unique_id . ' .premium-icon__container img' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconsSize'], 'Desktop' ) ));

		$css->set_selector( '.' . $unique_id . ' .premium-icon__container .premium-lottie-animation svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconsSize'], 'Desktop' ) ));
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconsSize'], 'Desktop' ) ));
	}
	if ( isset( $attr['iconsGap']['Desktop'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-icon-group-container ' );
		$css->add_property( 'gap', $css->render_string( $css->render_range( $attr['iconsGap'], 'Desktop' ) ));
	}

	// Desktop Styles.
	if ( isset( $attr['groupIconBorder'] ) ) {
		$icon_border        = $attr['groupIconBorder'];
		$icon_border_width  = $icon_border['borderWidth'];
		$icon_border_radius = $icon_border['borderRadius'];

		$css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-type, ' . '.' . $unique_id . ' .premium-icon-container' . ' > img, ' . '.' . $unique_id . ' .premium-icon-container' . ' > .premium-icon-svg-class' . ' > svg, ' . '.' . $unique_id . ' .premium-icon-container' . ' > .premium-lottie-animation' . ' > svg' );
		$css->add_property( 'border-radius', $css->render_string( $css->render_spacing( $icon_border_radius['Desktop'], 'px' ) ));
		$css->add_property( 'border-width', $css->render_string( $css->render_spacing( $icon_border_width['Desktop'], 'px' ) ));
		$css->add_property( 'border-style', "{$icon_border['borderType']}" );
		$css->add_property( 'border-color', $css->render_color($icon_border['borderColor']) );
	}

	if ( isset( $attr['groupIconMargin'] ) ) {
        $groupIconMargin = $attr['groupIconMargin'];
        $css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-type, ' . '.' . $unique_id . ' .premium-icon-container' . ' > img, ' . '.' . $unique_id . ' .premium-icon-container' . ' > .premium-icon-svg-class' . ' > svg, ' . '.' . $unique_id . ' .premium-icon-container' . ' > .premium-lottie-animation' . ' > svg' );
        $css->add_property( 'margin', $css->render_string( $css->render_spacing( $groupIconMargin['Desktop'], isset($groupIconMargin['unit']['Desktop'])?$groupIconMargin['unit']['Desktop']:$groupIconMargin['unit']  ) ));
    }

	if ( isset( $attr['groupIconPadding'] ) ) {
		$groupIconPadding = $attr['groupIconPadding'];
		$css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-type, ' . '.' . $unique_id . ' .premium-icon-container' . ' > img, ' . '.' . $unique_id . ' .premium-icon-container' . ' > .premium-icon-svg-class' . ' > svg, ' . '.' . $unique_id . ' .premium-icon-container' . ' > .premium-lottie-animation' . ' > svg' );
		$css->add_property( 'padding', $css->render_string( $css->render_spacing( $groupIconPadding['Desktop'], isset($groupIconPadding['unit']['Desktop'])?$groupIconPadding['unit']['Desktop']:$groupIconPadding['unit']  ) ));
	}

	if ( isset( $attr['align'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-group-horizontal' );
		$css->add_property( 'justify-content', $css->render_string($css->get_responsive_css( $attr['align'], 'Desktop' ), '!important' ) );
	}

	if ( isset( $attr['align'] ) ) {
		$content_align      = $css->get_responsive_css( $attr['align'], 'Desktop');
		$content_flex_align = 'left' === $content_align ? 'flex-start' : 'center';
		$content_flex_align = 'right' === $content_align ? 'flex-end' : $content_flex_align;

		$css->set_selector( '.' . $unique_id . ' > .premium-icon-group-vertical' );
		$css->add_property( 'align-items', $css->render_string($content_flex_align, '!important' ) );
		$css->add_property( 'justify-content', $css->render_string($content_flex_align, '!important' ) );
	}

	if ( isset( $attr['groupIconColor'] ) && ! empty( $attr['groupIconColor'] ) ) {
		$icon_color = $attr['groupIconColor'];
		$css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-content .premium-icon-type' );
		$css->add_property( 'fill', $css->render_color($icon_color ));
		$css->add_property( 'color', $css->render_color($icon_color ));
		$css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-content .premium-icon-type:not(.icon-type-fe) svg' );
		$css->add_property( 'fill', $css->render_color($icon_color ));
		$css->add_property( 'color', $css->render_color($icon_color ));
		$css->set_selector( '.' . $unique_id . ' .premium-icon-container' . ' .premium-icon-content' . ' > .premium-icon-svg-class' . ' > svg ' );
		$css->add_property( 'fill', $css->render_color($icon_color ));
		$css->add_property( 'color', $css->render_color($icon_color ));
		$css->set_selector( '.' . $unique_id . ' .premium-icon-container' . ' .premium-icon-content' . ' > .premium-icon-type:not(.icon-type-fe)' . ' > svg *' );
		$css->add_property( 'fill', $css->render_color($icon_color ));
		$css->set_selector( '.' . $unique_id . ' .premium-icon-container' . ' .premium-icon-content' . ' > .premium-icon-svg-class' . ' > svg *' );
		$css->add_property( 'fill', $css->render_color($icon_color ));
	}

	if ( isset( $attr['groupIconBack'] ) && ! empty( $attr['groupIconBack'] ) ) {
		$icon_color = $attr['groupIconBack'];
		$css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-content .premium-icon-type' );
		$css->add_property( 'background-color', $css->render_color($icon_color ));
		$css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-content .premium-lottie-animation svg ' );
		$css->add_property( 'background-color', $css->render_color($icon_color ));
		$css->set_selector( '.' . $unique_id . ' .premium-icon-container' . ' .premium-icon-content' . ' > .premium-icon-svg-class' . ' > svg ' );
		$css->add_property( 'background-color', $css->render_color($icon_color ));
	}

	if ( isset( $attr['groupIconHoverBack'] ) && ! empty( $attr['groupIconHoverBack'] ) ) {
		$icon_color = $attr['groupIconHoverBack'];
		$css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-content .premium-icon-type:hover' );
		$css->add_property( 'background-color', $css->render_color($icon_color ));
		$css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-content .premium-lottie-animation:hover svg ' );
		$css->add_property( 'background-color', $css->render_color($icon_color ));
		$css->set_selector( '.' . $unique_id . ' .premium-icon-container' . ' .premium-icon-content' . ' > .premium-icon-svg-class' . ' > svg:hover ' );
		$css->add_property( 'background-color', $css->render_color($icon_color ));
	}

	if ( isset( $attr['groupIconHoverColor'] ) && ! empty( $attr['groupIconHoverColor'] ) ) {
		$icon_HoverColor = $attr['groupIconHoverColor'];
		$css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-content .premium-icon-type:hover' );
		$css->add_property( 'fill', $css->render_color($icon_HoverColor ));
		$css->add_property( 'color', $css->render_color($icon_HoverColor ));
		$css->set_selector( '.' . $unique_id . ' .premium-icon-container' . ' .premium-icon-content' . ' > .premium-icon-svg-class' . ' > svg:hover' );
		$css->add_property( 'fill', $css->render_color($icon_HoverColor ));
		$css->add_property( 'color', $css->render_color($icon_HoverColor ));
		$css->set_selector( '.' . $unique_id . ' .premium-icon-container' . ' .premium-icon-content' . ' > .premium-icon-type:not(.icon-type-fe):hover' . ' > svg *' );
		$css->add_property( 'fill', $css->render_color($icon_HoverColor ));
		$css->set_selector( '.' . $unique_id . ' .premium-icon-container' . ' .premium-icon-content' . ' > .premium-icon-svg-class' . ' > svg:hover *' );
		$css->add_property( 'fill', $css->render_color($icon_HoverColor ));
	}

	$css->start_media_query( 'tablet' );
	// // Tablet Styles.
	// icon Size
	if ( isset( $attr['iconsSize']['Tablet'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-icon__container .premium-icon-type' );

		$css->set_selector( '.' . $unique_id . ' .premium-icon__container .premium-icon-type svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconsSize'], 'Tablet' ) ));
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconsSize'], 'Tablet' ) ));

		$css->set_selector( '.' . $unique_id . ' .premium-icon__container .premium-icon-svg-class svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconsSize'], 'Tablet' ) ));
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconsSize'], 'Tablet' ) ));

		$css->set_selector( '.' . $unique_id . ' .premium-icon__container img' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconsSize'], 'Tablet' ) ));

		$css->set_selector( '.' . $unique_id . ' .premium-icon__container .premium-lottie-animation svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconsSize'], 'Tablet' ) ));
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconsSize'], 'Tablet' ) ));
	}

	if ( isset( $attr['iconsGap']['Tablet'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-icon-group-container ' );
		$css->add_property( 'gap', $css->render_string( $css->render_range( $attr['iconsGap'], 'Tablet' ) ));
	}
	if ( isset( $attr['groupIconBorder'] ) ) {
		$icon_border        = $attr['groupIconBorder'];
		$icon_border_width  = $icon_border['borderWidth'];
		$icon_border_radius = $icon_border['borderRadius'];

		$css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-type, ' . '.' . $unique_id . ' .premium-icon-container' . ' > img, ' . '.' . $unique_id . ' .premium-icon-container' . ' > .premium-icon-svg-class' . ' > svg, ' . '.' . $unique_id . ' .premium-icon-container' . ' > .premium-lottie-animation' . ' > svg' );
		$css->add_property( 'border-radius', $css->render_string( $css->render_spacing( $icon_border_radius['Tablet'], 'px' ) ));
		$css->add_property( 'border-width', $css->render_string( $css->render_spacing( $icon_border_width['Tablet'], 'px' ) ));
	}


	if ( isset( $attr['groupIconMargin'] ) ) {
        $groupIconMargin = $attr['groupIconMargin'];
        $css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-type, ' . '.' . $unique_id . ' .premium-icon-container' . ' > img, ' . '.' . $unique_id . ' .premium-icon-container' . ' > .premium-icon-svg-class' . ' > svg, ' . '.' . $unique_id . ' .premium-icon-container' . ' > .premium-lottie-animation' . ' > svg' );
        $css->add_property( 'margin', $css->render_string($css->render_spacing( $groupIconMargin['Tablet'], isset($groupIconMargin['unit']['Tablet'])?$groupIconMargin['unit']['Tablet']:$groupIconMargin['unit']  ) ));
    }

	if ( isset( $attr['groupIconPadding'] ) ) {
		$groupIconPadding = $attr['groupIconPadding'];
		$css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-type, ' . '.' . $unique_id . ' .premium-icon-container' . ' > img, ' . '.' . $unique_id . ' .premium-icon-container' . ' > .premium-icon-svg-class' . ' > svg, ' . '.' . $unique_id . ' .premium-icon-container' . ' > .premium-lottie-animation' . ' > svg' );
		$css->add_property( 'padding', $css->render_string( $css->render_spacing( $groupIconPadding['Tablet'], isset($groupIconPadding['unit']['Tablet'])?$groupIconPadding['unit']['Tablet']:$groupIconPadding['unit']  ) ));
	}

	if ( isset( $attr['align'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-group-horizontal' );
		$css->add_property( 'justify-content', $css->render_string($css->get_responsive_css( $attr['align'], 'Tablet' ), '!important' ) );
	}

	if ( isset( $attr['align'] ) ) {
		$content_align      = $css->get_responsive_css( $attr['align'], 'Tablet' );
		$content_flex_align = 'left' === $content_align ? 'flex-start' : 'center';
		$content_flex_align = 'right' === $content_align ? 'flex-end' : $content_flex_align;

		$css->set_selector( '.' . $unique_id . ' > .premium-icon-group-vertical' );
		$css->add_property( 'align-items', $css->render_string($content_flex_align, '!important' ) );
		$css->add_property( 'justify-content', $css->render_string($content_flex_align, '!important' ) );
	}

	$css->stop_media_query();
	$css->start_media_query( 'mobile' );
	// // Mobile Styles.
	// icon Size
	if ( isset( $attr['iconsSize']['Mobile'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-icon__container .premium-icon-type' );

		$css->set_selector( '.' . $unique_id . ' .premium-icon__container .premium-icon-type svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconsSize'], 'Mobile' ) ));
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconsSize'], 'Mobile' ) ));

		$css->set_selector( '.' . $unique_id . ' .premium-icon__container .premium-icon-svg-class svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconsSize'], 'Mobile' ) ));
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconsSize'], 'Mobile' ) ));

		$css->set_selector( '.' . $unique_id . ' .premium-icon__container img' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconsSize'], 'Mobile' ) ));

		$css->set_selector( '.' . $unique_id . ' .premium-icon__container .premium-lottie-animation svg' );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconsSize'], 'Mobile' ) ));
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconsSize'], 'Mobile' ) ));
	}

	if ( isset( $attr['iconsGap']['Mobile'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-icon-group-container ' );
		$css->add_property( 'gap', $css->render_string( $css->render_range( $attr['iconsGap'], 'Mobile' ) ));
	}

	if ( isset( $attr['groupIconBorder'] ) ) {
		$icon_border        = $attr['groupIconBorder'];
		$icon_border_width  = $icon_border['borderWidth'];
		$icon_border_radius = $icon_border['borderRadius'];

		$css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-type, ' . '.' . $unique_id . ' .premium-icon-container' . ' > img, ' . '.' . $unique_id . ' .premium-icon-container' . ' > .premium-icon-svg-class' . ' > svg, ' . '.' . $unique_id . ' .premium-icon-container' . ' > .premium-lottie-animation' . ' > svg' );
		$css->add_property( 'border-radius', $css->render_string( $css->render_spacing( $icon_border_radius['Mobile'], 'px' ) ));
		$css->add_property( 'border-width', $css->render_string( $css->render_spacing( $icon_border_width['Mobile'], 'px' ) ));
	}

	if ( isset( $attr['groupIconMargin'] ) ) {
        $groupIconMargin = $attr['groupIconMargin'];
        $css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-type, ' . '.' . $unique_id . ' .premium-icon-container' . ' > img, ' . '.' . $unique_id . ' .premium-icon-container' . ' > .premium-icon-svg-class' . ' > svg, ' . '.' . $unique_id . ' .premium-icon-container' . ' > .premium-lottie-animation' . ' > svg' );
        $css->add_property( 'margin', $css->render_string( $css->render_spacing( $groupIconMargin['Mobile'], isset($groupIconMargin['unit']['Mobile'])?$groupIconMargin['unit']['Mobile']:$groupIconMargin['unit']  ) ));
    }

	if ( isset( $attr['groupIconPadding'] ) ) {
		$groupIconPadding = $attr['groupIconPadding'];
		$css->set_selector( '.' . $unique_id . ' .premium-icon-container .premium-icon-type, ' . '.' . $unique_id . ' .premium-icon-container' . ' > img, ' . '.' . $unique_id . ' .premium-icon-container' . ' > .premium-icon-svg-class' . ' > svg, ' . '.' . $unique_id . ' .premium-icon-container' . ' > .premium-lottie-animation' . ' > svg' );
		$css->add_property( 'padding', $css->render_string($css->render_spacing( $groupIconPadding['Mobile'], isset($groupIconPadding['unit']['Mobile'])?$groupIconPadding['unit']['Mobile']:$groupIconPadding['unit']  ) ));
	}

	if ( isset( $attr['align'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-icon-group-horizontal' );
		$css->add_property( 'justify-content', $css->render_string($css->get_responsive_css( $attr['align'], 'Mobile' ) , '!important' ));
	}

	if ( isset( $attr['align'] ) ) {
		$content_align      = $css->get_responsive_css( $attr['align'], 'Mobile' );
		$content_flex_align = 'left' === $content_align ? 'flex-start' : 'center';
		$content_flex_align = 'right' === $content_align ? 'flex-end' : $content_flex_align;

		$css->set_selector( '.' . $unique_id . ' > .premium-icon-group-vertical' );
		$css->add_property( 'align-items', $css->render_string($content_flex_align, '!important' ) );
		$css->add_property( 'justify-content', $css->render_string($content_flex_align, '!important' ) );
	}

	$css->stop_media_query();

	return $css->css_output();
}

/**
 * Renders the `premium/image` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_icon_group( $attributes, $content, $block ) {

	return $content;
}


/**
 * Register the icon group block.
 *
 * @uses render_block_pbg_icon_group()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_icon_group() {
	register_block_type(
		'premium/icon-group',
		array(
			'render_callback' => 'render_block_pbg_icon_group',
			'editor_style'    => 'premium-blocks-editor-css',
			'editor_script'   => 'pbg-blocks-js',
		)
	);
}

register_block_pbg_icon_group();
