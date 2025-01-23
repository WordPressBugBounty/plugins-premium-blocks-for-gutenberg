<?php
/**
 * Server-side rendering of the `pbg/fancy-text` block.
 *
 * @package WordPress
 */

/**
 * Get Fancy Text Block CSS
 *
 * Return Frontend CSS for Fancy Text.
 *
 * @access public
 *
 * @param string $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_fancy_text_css_style( $attr, $unique_id ) {
	$css = new Premium_Blocks_css();
	if ( isset( $attr['fancyMargin'] ) ) {
		$fancyMargin = $attr['fancyMargin'];

		$css->set_selector( '.' . $unique_id . "> .premium-fancy-text");
		$css->add_property( 'margin', $css->render_spacing( $fancyMargin['Desktop'], isset( $fancyMargin['unit']['Desktop'])?$fancyMargin['unit']['Desktop']:$fancyMargin['unit'] ) );
	}
	if ( isset( $attr['fancyPadding'] ) ) {
		$fancyPadding = $attr['fancyPadding'];

		$css->set_selector( '.' . $unique_id . "> .premium-fancy-text");
		$css->add_property( 'padding', $css->render_spacing( $fancyPadding['Desktop'], isset( $fancyPadding['unit']['Desktop'])?$fancyPadding['unit']['Desktop']:$fancyPadding['unit'] ) );
	}

	// FancyText Style
	if ( isset( $attr['fancyTextTypography'] ) ) {
		$fancy_typography = $attr['fancyTextTypography'];
		$fancy_size       = $fancy_typography['fontSize'];

		$css->set_selector( '.' . $unique_id . '> .premium-fancy-text' . '> .premium-fancy-text-title-slide ul li , .'. $unique_id . ' > .premium-fancy-text  > .premium-fancy-text-title-type' );
		$css->render_typography( $attr['fancyTextTypography'], 'Desktop' );
		$css->set_selector( '.' . $unique_id . '> .premium-fancy-text' . '> .typed-cursor' );
		$css->add_property( 'font-size', $css->render_range( $fancy_size, 'Desktop' ) );
	}
	// Suffix, Prefix Style
	if ( isset( $attr['prefixTypography'] ) ) {
		$css->set_selector( '.' . $unique_id . '> .premium-fancy-text' . '> .premium-fancy-text-suffix-prefix' );
		$css->render_typography( $attr['prefixTypography'], 'Desktop' );
	}

	if ( isset( $attr['fancyContentAlign'] ) ) {
        $content_align      = $css->get_responsive_css( $attr['fancyContentAlign'], 'Desktop' );
		$content_flex_align = 'left' === $content_align ? 'flex-start' : 'center';
		$content_flex_align = 'right' === $content_align ? 'flex-end' : $content_flex_align;
		$css->set_selector( '.' . $unique_id . '> .premium-fancy-text' );
		$css->add_property( 'text-align', $content_align );
        $css->add_property( 'align-self', $css->render_align_self($content_align) );
	}

	if ( isset( $attr['fancyTextAlign'] ) ) {
		$css->set_selector( '.' . $unique_id . '> .premium-fancy-text' . '> .premium-fancy-text-title-slide' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['fancyTextAlign'], 'Desktop' ) );
	}
	if ( isset( $attr['fancyContentAlign'] ) ) {
                $content_align      = $css->get_responsive_css( $attr['fancyContentAlign'], 'Desktop' );
		$content_flex_align = 'left' === $content_align ? 'flex-start' : 'center';
		$content_flex_align = 'right' === $content_align ? 'flex-end' : $content_flex_align;
		$css->set_selector( '.' . $unique_id );
	$css->add_property( 'text-align', $content_align );
        $css->add_property( 'align-self',  $css->render_align_self($content_align) );	}
	if ( isset( $attr['fancyStyles'][0]['fancyTextColor'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-fancy-text-title-type , .' . $unique_id . ' .premium-fancy-text-title-slide' );
		$css->add_property( 'color', $css->render_string( $css->render_color( $attr['fancyStyles'][0]['fancyTextColor'] ), ' !important' ) );
	}
	if ( isset( $attr['fancyStyles'][0]['fancyTextBGColor'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-fancy-text-title-type , .' . $unique_id . ' .premium-fancy-text-title-slide' );
		$css->add_property( 'background-color', $css->render_string( $css->render_color( $attr['fancyStyles'][0]['fancyTextBGColor'] ), ' !important' ) );
	}
	if ( isset( $attr['fancyStyles'][0]['cursorColor'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .typed-cursor' );
		$css->add_property( 'color', $css->render_string( $css->render_color( $attr['fancyStyles'][0]['cursorColor'], ' !important' ) ) );
	}
	if ( isset( $attr['PreStyles'][0]['textColor'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-fancy-text-suffix-prefix' );
		$css->add_property( 'color', $css->render_string( $css->render_color( $attr['PreStyles'][0]['textColor'] ), ' !important' ) );
	}
	if ( isset( $attr['PreStyles'][0]['textBGColor'] ) && ! empty( $attr['PreStyles'][0]['textBGColor'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-fancy-text-suffix-prefix' );
		$css->add_property( 'background-color', $attr['PreStyles'][0]['textBGColor'] . ' !important' );
	}

	$css->start_media_query( 'tablet' );

	if ( isset( $attr['fancyMargin'] ) ) {
		$fancyMargin = $attr['fancyMargin'];

		$css->set_selector( '.' . $unique_id . "> .premium-fancy-text");
		$css->add_property( 'margin', $css->render_spacing( $fancyMargin['Tablet'], isset( $fancyMargin['unit']['Tablet'])?$fancyMargin['unit']['Tablet']:$fancyMargin['unit'] ) );
	}
	if ( isset( $attr['fancyPadding'] ) ) {
		$fancyPadding = $attr['fancyPadding'];

		$css->set_selector( '.' . $unique_id . "> .premium-fancy-text");
		$css->add_property( 'padding', $css->render_spacing( $fancyPadding['Tablet'], isset( $fancyPadding['unit']['Tablet'])?$fancyPadding['unit']['Tablet']:$fancyPadding['unit'] ) );
	}

	if ( isset( $attr['fancyTextTypography'] ) ) {
		$fancy_typography = $attr['fancyTextTypography'];
		$fancy_size       = $fancy_typography['fontSize'];

		$css->set_selector( '.' . $unique_id . '> .premium-fancy-text' . '> .premium-fancy-text-title-slide ul li , .'. $unique_id . ' > .premium-fancy-text  > .premium-fancy-text-title-type' );
		$css->render_typography( $attr['fancyTextTypography'], 'Tablet' );
		$css->set_selector( '.' . $unique_id . '> .premium-fancy-text' . '> .typed-cursor' );
		$css->add_property( 'font-size', $css->render_range( $fancy_size, 'Tablet' ) );
	}

	// Suffix, Prefix Style
	if ( isset( $attr['prefixTypography'] ) ) {
		$css->set_selector( '.' . $unique_id . '> .premium-fancy-text' . '> .premium-fancy-text-suffix-prefix' );
		$css->render_typography( $attr['prefixTypography'], 'Tablet' );
	}

	if ( isset( $attr['fancyContentAlign'] ) ) {
		$css->set_selector( '.' . $unique_id . '> .premium-fancy-text' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['fancyContentAlign'], 'Tablet' ) );
	}

	if ( isset( $attr['fancyTextAlign'] ) ) {
		$css->set_selector( '.' . $unique_id . '> .premium-fancy-text' . '> .premium-fancy-text-title-slide' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['fancyTextAlign'], 'Tablet' ) );
	}
	if ( isset( $attr['fancyContentAlign'] ) ) {
		$css->set_selector( '.' . $unique_id );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['fancyContentAlign'], 'Tablet' ) );
	}

	$css->stop_media_query();
	$css->start_media_query( 'mobile' );


	if ( isset( $attr['fancyMargin'] ) ) {
		$fancyMargin = $attr['fancyMargin'];

		$css->set_selector( '.' . $unique_id . "> .premium-fancy-text");
		$css->add_property( 'margin', $css->render_spacing( $fancyMargin['Mobile'], isset( $fancyMargin['unit']['Mobile'])?$fancyMargin['unit']['Mobile']:$fancyMargin['unit'] ) );
	}
	if ( isset( $attr['fancyPadding'] ) ) {
		$fancyPadding = $attr['fancyPadding'];

		$css->set_selector( '.' . $unique_id . "> .premium-fancy-text");
		$css->add_property( 'padding', $css->render_spacing( $fancyPadding['Mobile'], isset( $fancyPadding['unit']['Mobile'])?$fancyPadding['unit']['Mobile']:$fancyPadding['unit'] ) );
	}

	if ( isset( $attr['fancyTextTypography'] ) ) {
		$fancy_typography = $attr['fancyTextTypography'];
		$fancy_size       = $fancy_typography['fontSize'];

		$css->set_selector( '.' . $unique_id . '> .premium-fancy-text' . '> .premium-fancy-text-title-slide ul li , .'. $unique_id . ' > .premium-fancy-text  > .premium-fancy-text-title-type' );
		$css->render_typography( $attr['fancyTextTypography'], 'Mobile' );
		$css->set_selector( '.' . $unique_id . '> .premium-fancy-text' . '> .typed-cursor' );
		$css->add_property( 'font-size', $css->render_range( $fancy_size, 'Mobile' ) );
	}

	// Suffix, Prefix Style
	if ( isset( $attr['prefixTypography'] ) ) {
		$css->set_selector( '.' . $unique_id . '> .premium-fancy-text' . '> .premium-fancy-text-suffix-prefix' );
		$css->render_typography( $attr['prefixTypography'], 'Mobile' );
	}
	if ( isset( $attr['fancyContentAlign'] ) ) {
		$css->set_selector( '.' . $unique_id . '> .premium-fancy-text' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['fancyContentAlign'], 'Mobile' ) );
	}

	if ( isset( $attr['fancyTextAlign'] ) ) {
		$css->set_selector( '.' . $unique_id . '> .premium-fancy-text' . '> .premium-fancy-text-title-slide' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['fancyTextAlign'], 'Mobile' ) );
	}
	if ( isset( $attr['fancyContentAlign'] ) ) {
		$css->set_selector( '.' . $unique_id );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['fancyContentAlign'], 'Mobile' ) );
	}

	$css->stop_media_query();
	return $css->css_output();
}

/**
 * Renders the `premium/fancy-text` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_fancy_text( $attributes, $content, $block ) {
	$block_helpers = pbg_blocks_helper();

	// Enqueue required styles and scripts.
	if ( $block_helpers->it_is_not_amp() ) {
		wp_enqueue_script(
			'pbg-typed',
			PREMIUM_BLOCKS_URL . 'assets/js/lib/typed.js',
			array( 'jquery' ),
			PREMIUM_BLOCKS_VERSION,
			true
		);
		wp_enqueue_script(
			'pbg-vticker',
			PREMIUM_BLOCKS_URL . 'assets/js/lib/vticker.js',
			array( 'jquery' ),
			PREMIUM_BLOCKS_VERSION,
			true
		);
		wp_enqueue_script(
			'pbg-fancy-text',
			PREMIUM_BLOCKS_URL . 'assets/js/minified/fancy-text.min.js',
			array( 'jquery', 'pbg-typed','pbg-vticker' ),
			PREMIUM_BLOCKS_VERSION,
			true
		);
	
	}

	return $content;
}




/**
 * Register the fancy_text block.
 *
 * @uses render_block_pbg_fancy_text()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_fancy_text() {
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	register_block_type(
		PREMIUM_BLOCKS_PATH . '/blocks-config/fancy-text',
		array(
			'render_callback' => 'render_block_pbg_fancy_text',
		)
	);
}

register_block_pbg_fancy_text();
