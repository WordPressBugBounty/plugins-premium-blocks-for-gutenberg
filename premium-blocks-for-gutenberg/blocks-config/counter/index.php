<?php
/**
 * Server-side rendering of the `premium/counter` block.
 *
 * @package WordPress
 */

/**
 * Generate CSS for counter block.
 *
 * @param array  $attributes Block attributes.
 * @param string $unique_id  Unique block ID.
 * @return string Generated CSS.
 */
function get_premium_counter_css( $attributes, $unique_id ) {
	$css = new Premium_Blocks_css();

	// Container alignment.
	$css->set_selector( '.' . $unique_id );
	$css->pbg_render_align_self( $attributes, 'align', 'justify-content', 'Desktop' );

	// Number styles.
	$css->set_selector( '.' . $unique_id . ' > .premium-countup__desc > .premium-countup__increment' );
	$css->pbg_render_typography( $attributes, 'numberTypography', 'Desktop' );
	$css->pbg_render_spacing( $attributes, 'numberMargin', 'margin', 'Desktop' );
	$css->pbg_render_spacing( $attributes, 'numberPadding', 'padding', 'Desktop' );
  $css->pbg_render_color( $attributes, 'numberStyles[0].numberColor', 'color');

	// Prefix styles.
	$css->set_selector( '.' . $unique_id . ' > .premium-countup__desc > .premium-countup__prefix' );
	$css->pbg_render_typography( $attributes, 'prefixTypography', 'Desktop' );
	$css->pbg_render_spacing( $attributes, 'prefixMargin', 'margin', 'Desktop' );
	$css->pbg_render_spacing( $attributes, 'prefixPadding', 'padding', 'Desktop' );
  $css->pbg_render_color( $attributes, 'prefixStyles[0].prefixColor', 'color');

	// Suffix styles.
	$css->set_selector( '.' . $unique_id . ' > .premium-countup__desc > .premium-countup__suffix' );
	$css->pbg_render_typography( $attributes, 'suffixTypography', 'Desktop' );
	$css->pbg_render_spacing( $attributes, 'suffixMargin', 'margin', 'Desktop' );
	$css->pbg_render_spacing( $attributes, 'suffixPadding', 'padding', 'Desktop' );
  $css->pbg_render_color( $attributes, 'suffixStyles[0].suffixColor', 'color');

	// Tablet styles.
	$css->start_media_query( 'tablet' );

	// Container alignment.
	$css->set_selector( '.' . $unique_id );
	$css->pbg_render_align_self( $attributes, 'align', 'justify-content', 'Tablet', '', '!important' );

	// Number styles.
	$css->set_selector( '.' . $unique_id . ' > .premium-countup__desc > .premium-countup__increment' );
	$css->pbg_render_typography( $attributes, 'numberTypography', 'Tablet' );
	$css->pbg_render_spacing( $attributes, 'numberMargin', 'margin', 'Tablet' );
	$css->pbg_render_spacing( $attributes, 'numberPadding', 'padding', 'Tablet' );

	// Prefix styles.
	$css->set_selector( '.' . $unique_id . ' > .premium-countup__desc > .premium-countup__prefix' );
	$css->pbg_render_typography( $attributes, 'prefixTypography', 'Tablet' );
	$css->pbg_render_spacing( $attributes, 'prefixMargin', 'margin', 'Tablet' );
	$css->pbg_render_spacing( $attributes, 'prefixPadding', 'padding', 'Tablet' );

	// Suffix styles.
	$css->set_selector( '.' . $unique_id . ' > .premium-countup__desc > .premium-countup__suffix' );
	$css->pbg_render_typography( $attributes, 'suffixTypography', 'Tablet' );
	$css->pbg_render_spacing( $attributes, 'suffixMargin', 'margin', 'Tablet' );
	$css->pbg_render_spacing( $attributes, 'suffixPadding', 'padding', 'Tablet' );

	$css->stop_media_query();

	// Mobile styles.
	$css->start_media_query( 'mobile' );

	// Container alignment.
	$css->set_selector( '.' . $unique_id );
	$css->pbg_render_align_self( $attributes, 'align', 'justify-content', 'Mobile', '', '!important' );

	// Number styles.
	$css->set_selector( '.' . $unique_id . ' > .premium-countup__desc > .premium-countup__increment' );
	$css->pbg_render_typography( $attributes, 'numberTypography', 'Mobile' );
	$css->pbg_render_spacing( $attributes, 'numberMargin', 'margin', 'Mobile' );
	$css->pbg_render_spacing( $attributes, 'numberPadding', 'padding', 'Mobile' );

	// Prefix styles.
	$css->set_selector( '.' . $unique_id . ' > .premium-countup__desc > .premium-countup__prefix' );
	$css->pbg_render_typography( $attributes, 'prefixTypography', 'Mobile' );
	$css->pbg_render_spacing( $attributes, 'prefixMargin', 'margin', 'Mobile' );
	$css->pbg_render_spacing( $attributes, 'prefixPadding', 'padding', 'Mobile' );

	// Suffix styles.
	$css->set_selector( '.' . $unique_id . ' > .premium-countup__desc > .premium-countup__suffix' );
	$css->pbg_render_typography( $attributes, 'suffixTypography', 'Mobile' );
	$css->pbg_render_spacing( $attributes, 'suffixMargin', 'margin', 'Mobile' );
	$css->pbg_render_spacing( $attributes, 'suffixPadding', 'padding', 'Mobile' );

	$css->stop_media_query();

	return $css->css_output();
}

/**
 * Renders the `premium/counter` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_counter( $attributes, $content, $block ) {

	return $content;
}


/**
 * Register the Price block.
 *
 * @uses render_block_pbg_counter()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_counter() {
	register_block_type(
		'premium/counter',
		array(
			'render_callback' => 'render_block_pbg_counter',
			'editor_style'    => 'premium-blocks-editor-css',
			'editor_script'   => 'pbg-blocks-js',
		)
	);
}

register_block_pbg_counter();
