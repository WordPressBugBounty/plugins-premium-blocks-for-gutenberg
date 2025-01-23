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

	// Container Style
	if ( isset( $attr['padding'] ) ) {
		$padding = $attr['padding'];
		$css->set_selector( $unique_id );
		$css->add_property( 'padding', $css->render_spacing( $padding['Desktop'], isset( $padding['unit']['Desktop'])?$padding['unit']['Desktop']:$padding['unit'] ) );
	}
	// Border.
	if ( isset( $attr['border'] ) ) {
		$border        = $attr['border'];
		$border_width  = $border['borderWidth'];
		$border_radius = $border['borderRadius'];

		$css->set_selector( $unique_id );
		$css->add_property( 'border-width', $css->render_spacing( $border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $border_radius['Desktop'], 'px' ) );
	}
	if ( isset( $attr['background'] ) ) {
		$css->set_selector( $unique_id );
		$css->render_background( $attr['background'], 'Desktop' );

	}

	$css->start_media_query( 'tablet' );

	// Container Style
	if ( isset( $attr['padding'] ) ) {
		$padding = $attr['padding'];
		$css->set_selector( $unique_id );
		$css->add_property( 'padding', $css->render_spacing( $padding['Tablet'],isset( $padding['unit']['Tablet'] )?$padding['unit']['Tablet']:$padding['unit']) );
	}
	// Border.
	if ( isset( $attr['border'] ) ) {
		$border        = $attr['border'];
		$border_width  = $border['borderWidth'];
		$border_radius = $border['borderRadius'];

		$css->set_selector( $unique_id );
		$css->add_property( 'border-width', $css->render_spacing( $border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $border_radius['Tablet'], 'px' ) );
	}
	if ( isset( $attr['background'] ) ) {
		$css->set_selector( $unique_id );
		$css->render_background( $attr['background'], 'Tablet' );

	}

	$css->stop_media_query();
	$css->start_media_query( 'mobile' );

	// Container Style
	if ( isset( $attr['padding'] ) ) {
		$padding = $attr['padding'];
		$css->set_selector( $unique_id );
		$css->add_property( 'padding', $css->render_spacing( $padding['Mobile'], isset( $padding['unit']['Mobile'] )?$padding['unit']['Mobile']:$padding['unit']) );
	}
	// Border.
	if ( isset( $attr['border'] ) ) {
		$border        = $attr['border'];
		$border_width  = $border['borderWidth'];
		$border_radius = $border['borderRadius'];

		$css->set_selector( $unique_id );
		$css->add_property( 'border-width', $css->render_spacing( $border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $border_radius['Mobile'], 'px' ) );
	}
	if ( isset( $attr['background'] ) ) {
		$css->set_selector( $unique_id );
		$css->render_background( $attr['background'], 'Mobile' );

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
