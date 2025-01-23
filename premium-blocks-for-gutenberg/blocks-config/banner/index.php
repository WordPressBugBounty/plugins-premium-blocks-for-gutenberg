<?php
/**
 * Server-side rendering of the `pbg/banner` block.
 *
 * @package WordPress
 */

/**
 * Get Banner Block CSS
 *
 * Return Frontend CSS for Banner.
 *
 * @access public
 *
 * @param string $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_banner_css_style( $attr, $unique_id ) {
	$css = new Premium_Blocks_css();

	if ( isset( $attr['sepColor'] ) ) {
		$css->set_selector( $unique_id . ' .premium-banner__effect3 .premium-banner__title_wrap::after' );
		$css->add_property( 'background-color', $css->render_color( $attr['sepColor'] ) );
	}

	if ( isset( $attr['hoverBackground'] ) ) {
		$css->set_selector( $unique_id . ' .premium-banner__inner:hover .premium-banner__bg-overlay' );
		$css->add_property( 'background-color', $css->render_color( $attr['hoverBackground'] ) );
	}
	// Style.
	if ( isset( $attr['contentAlign'] ) ) {
		$css->set_selector( $unique_id . ' .premium-banner__inner' . ' > .premium-banner__content' . ' > .premium-banner__title_wrap' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['contentAlign'], 'Desktop' ) );
		$css->set_selector( $unique_id . ' .premium-banner__inner' . ' > .premium-banner__content' . ' > .premium-banner__desc_wrap' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['contentAlign'], 'Desktop' ) );
	}

	if ( isset( $attr['titleTypography'] ) ) {
		$css->set_selector( $unique_id . ' .premium-banner__inner' . ' > .premium-banner__content' . ' > .premium-banner__title_wrap' . ' > .premium-banner__title' );
		$css->render_typography( $attr['titleTypography'], 'Desktop' );
	}

	// Desc Style
	if ( isset( $attr['descTypography'] ) ) {
		$css->set_selector( $unique_id . ' .premium-banner__inner' . ' > .premium-banner__content' . ' > .premium-banner__desc_wrap' . ' > .premium-banner__desc' );
		$css->render_typography( $attr['descTypography'], 'Desktop' );
	}

	// Container Style
	if ( isset( $attr['padding'] ) ) {
		$padding = $attr['padding'];
		$css->set_selector( $unique_id . ' .premium-banner' );
		$css->add_property( 'padding', $css->render_spacing( $padding['Desktop'],isset( $padding['unit']['Desktop'])?$padding['unit']['Desktop']:$padding['unit'] ) );
	}

	if ( isset( $attr['border'] ) ) {
		$border        = $attr['border'];
		$border_width  = $border['borderWidth'];
		$border_radius = $border['borderRadius'];

		$css->set_selector( $unique_id . '  .premium-banner__inner' );
		$css->add_property( 'border-width', $css->render_spacing( $border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $border_radius['Desktop'], 'px' ) );
	}

	$css->start_media_query( 'tablet' );

	if ( isset( $attr['contentAlign'] ) ) {
		$css->set_selector( $unique_id . ' .premium-banner__inner' . ' > .premium-banner__content' . ' > .premium-banner__title_wrap' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['contentAlign'], 'Tablet' ) );
		$css->set_selector( $unique_id . ' .premium-banner__inner' . ' > .premium-banner__content' . ' > .premium-banner__desc_wrap' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['contentAlign'], 'Tablet' ) );
	}

	if ( isset( $attr['titleTypography'] ) ) {
		$css->set_selector( $unique_id . ' .premium-banner__inner' . ' > .premium-banner__content' . ' > .premium-banner__title_wrap' . ' > .premium-banner__title' );
		$css->render_typography( $attr['titleTypography'], 'Tablet' );
	}

	// Desc Style
	if ( isset( $attr['descTypography'] ) ) {
		$css->set_selector( $unique_id . ' .premium-banner__inner' . ' > .premium-banner__content' . ' > .premium-banner__desc_wrap' . ' > .premium-banner__desc' );
		$css->render_typography( $attr['descTypography'], 'Tablet' );
	}

	// Container Style
	if ( isset( $attr['padding'] ) ) {
		$padding = $attr['padding'];
		$css->set_selector( $unique_id );
		$css->add_property( 'padding', $css->render_spacing( $padding['Tablet'], isset($padding['unit']['Tablet'])?$padding['unit']['Tablet']:$padding['unit'] ) );
	}

	if ( isset( $attr['border'] ) ) {
		$border        = $attr['border'];
		$border_width  = $border['borderWidth'];
		$border_radius = $border['borderRadius'];

		$css->set_selector( $unique_id . ' .premium-banner__inner' );
		$css->add_property( 'border-width', $css->render_spacing( $border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $border_radius['Tablet'], 'px' ) );
	}

	$css->stop_media_query();

	$css->start_media_query( 'mobile' );

	if ( isset( $attr['contentAlign'] ) ) {
		$css->set_selector( $unique_id . ' .premium-banner__inner' . ' > .premium-banner__content' . ' > .premium-banner__title_wrap' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['contentAlign'], 'Mobile' ) );
		$css->set_selector( $unique_id . ' .premium-banner__inner' . ' > .premium-banner__content' . ' > .premium-banner__desc_wrap' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['contentAlign'], 'Mobile' ) );
	}

	if ( isset( $attr['titleTypography'] ) ) {
		$css->set_selector( $unique_id . ' .premium-banner__inner' . ' > .premium-banner__content' . ' > .premium-banner__title_wrap' . ' > .premium-banner__title' );
		$css->render_typography( $attr['titleTypography'], 'Mobile' );
	}

	// Desc Style
	if ( isset( $attr['descTypography'] ) ) {
		$css->set_selector( $unique_id . ' .premium-banner__inner' . ' > .premium-banner__content' . ' > .premium-banner__desc_wrap' . ' > .premium-banner__desc' );
		$css->render_typography( $attr['descTypography'], 'Mobile' );
	}

	// Container Style
	if ( isset( $attr['padding'] ) ) {
		$padding = $attr['padding'];
		$css->set_selector( $unique_id );
		$css->add_property( 'padding', $css->render_spacing( $padding['Mobile'], isset($padding['unit']['Mobile'])?$padding['unit']['Mobile']:$padding['unit'] ) );
	}

	if ( isset( $attr['border'] ) ) {
		$border        = $attr['border'];
		$border_width  = $border['borderWidth'];
		$border_radius = $border['borderRadius'];

		$css->set_selector( $unique_id . ' .premium-banner__inner' );
		$css->add_property( 'border-width', $css->render_spacing( $border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $border_radius['Mobile'], 'px' ) );
	}

	$css->stop_media_query();
	return $css->css_output();
}

/**
 * Renders the `premium/banner` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_banner( $attributes, $content, $block ) {
	return $content;
}




/**
 * Register the banner block.
 *
 * @uses render_block_pbg_banner()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_banner() {
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	register_block_type(
		PREMIUM_BLOCKS_PATH . '/blocks-config/banner',
		array(
			'render_callback' => 'render_block_pbg_banner',
		)
	);
}

register_block_pbg_banner();
