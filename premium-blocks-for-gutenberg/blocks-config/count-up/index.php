<?php
/**
 * Server-side rendering of the `pbg/count-up` block.
 *
 * @package WordPress
 */

/**
 * Get Count Up Block CSS
 *
 * Return Frontend CSS for Count Up.
 *
 * @access public
 *
 * @param string $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_count_up_css_style( $attr, $unique_id ) {
	$css = new Premium_Blocks_css();

	$icon_position = $css->pbg_get_value( $attr, 'iconPosition' );

	// Desktop Styles
	$css->set_selector( $unique_id );
	$css->pbg_render_spacing( $attr, 'padding', 'padding', 'Desktop' );
	$css->pbg_render_border( $attr, 'border', 'Desktop' );
	$css->pbg_render_background( $attr, 'background', 'Desktop' );
  $css->pbg_render_shadow( $attr, 'boxShadow', 'box-shadow' );

	if ( $icon_position !== 'top' ) {
		$css->set_selector( $unique_id . ' .premium-countup-content-wrapper' );
		$css->pbg_render_value( $attr, 'contentAlign', 'justify-content', 'Desktop' );

		$css->set_selector( $unique_id . ' .premium-countup-content-wrapper .wp-block-premium-icon' );
		$css->pbg_render_value( $attr, 'iconVerticalAlign', 'align-self', 'Desktop' );
	}

	// Tablet Styles
	$css->start_media_query( 'tablet' );

	$css->set_selector( $unique_id );
	$css->pbg_render_spacing( $attr, 'padding', 'padding', 'Tablet' );
	$css->pbg_render_border( $attr, 'border', 'Tablet' );
	$css->pbg_render_background( $attr, 'background', 'Tablet' );

	if ( $icon_position !== 'top' ) {
		$css->set_selector( $unique_id . ' .premium-countup-content-wrapper' );
		$css->pbg_render_value( $attr, 'contentAlign', 'justify-content', 'Tablet' );

		$css->set_selector( $unique_id . ' .premium-countup-content-wrapper .wp-block-premium-icon' );
		$css->pbg_render_value( $attr, 'iconVerticalAlign', 'align-self', 'Tablet' );
	}

	$css->stop_media_query();

	// Mobile Styles
	$css->start_media_query( 'mobile' );

	$css->set_selector( $unique_id );
	$css->pbg_render_spacing( $attr, 'padding', 'padding', 'Mobile' );
	$css->pbg_render_border( $attr, 'border', 'Mobile' );
	$css->pbg_render_background( $attr, 'background', 'Mobile' );

	if ( $icon_position !== 'top' ) {
		$css->set_selector( $unique_id . ' .premium-countup-content-wrapper' );
		$css->pbg_render_value( $attr, 'contentAlign', 'justify-content', 'Mobile' );

		$css->set_selector( $unique_id . ' .premium-countup-content-wrapper .wp-block-premium-icon' );
		$css->pbg_render_value( $attr, 'iconVerticalAlign', 'align-self', 'Mobile' );
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
function render_block_pbg_count_up( $attributes, $content, $block ) {
	$block_helpers = pbg_blocks_helper();

	// Enqueue frontend JS/CSS.
	if ( $block_helpers->it_is_not_amp() ) {
		wp_enqueue_script(
			'pbg-counter',
			PREMIUM_BLOCKS_URL . 'assets/js/lib/countUp.umd.js',
			array(),
			PREMIUM_BLOCKS_VERSION,
			true
		);
		wp_enqueue_script(
			'pbg-countup',
			PREMIUM_BLOCKS_URL . 'assets/js/minified/countup.min.js',
			array(),
			PREMIUM_BLOCKS_VERSION,
			true
		);
	}

	return $content;
}




/**
 * Register the count_up block.
 *
 * @uses render_block_pbg_count_up()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_count_up() {
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	register_block_type(
		PREMIUM_BLOCKS_PATH . '/blocks-config/count-up',
		array(
			'render_callback' => 'render_block_pbg_count_up',
		)
	);
}

register_block_pbg_count_up();
