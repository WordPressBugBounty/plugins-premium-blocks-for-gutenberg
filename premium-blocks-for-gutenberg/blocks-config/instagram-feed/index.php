<?php
/**
 * Server-side rendering of the `premium/instagram-feed` block.
 *
 * @package WordPress
 */

/**
 * Renders the Instagram Feed block on the frontend.
 *
 * @param array  $attributes Block attributes.
 * @param string $content    Block content.
 * @return string Rendered block HTML.
 */
function render_block_pbg_instagram_feed( $attributes, $content ) {
	$has_error = apply_filters( 'pbg_instagram_feed_has_error', false );

	if ( $has_error ) return '';

	return $content;
}

/**
 * Registers the Instagram Feed block.
 *
 * @uses render_block_pbg_instagram_feed()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_instagram_feed() {
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	register_block_type(
		PREMIUM_BLOCKS_PATH . 'blocks-config/instagram-feed',
		array(
			'render_callback' => 'render_block_pbg_instagram_feed',
		)
	);
}

register_block_pbg_instagram_feed();
