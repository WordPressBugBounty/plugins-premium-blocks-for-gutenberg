<?php
/**
 * Server-side rendering of the `premium/instagram-feed-header` block.
 *
 * @package WordPress
 */

/**
 * Get CSS styles for Instagram Feed Header block.
 *
 * @param array  $attributes Block attributes.
 * @param string $unique_id  Unique block ID.
 * @return string Generated CSS.
 */
function get_premium_instagram_feed_header_css( $attributes, $unique_id ) {
	$css = new Premium_Blocks_css();

	// Desktop styles.
	$css->set_selector( '.' . $unique_id );
	$css->pbg_render_background( $attributes, 'background', 'Desktop' );
	$css->pbg_render_border( $attributes, 'border', 'Desktop' );
	$css->pbg_render_spacing( $attributes, 'padding', 'padding', 'Desktop' );
	$css->pbg_render_spacing( $attributes, 'margin', 'margin', 'Desktop' );
	$css->pbg_render_shadow( $attributes, 'boxShadow', 'box-shadow' );

	// Tablet responsive styles.
	$css->start_media_query( 'tablet' );
	$css->set_selector( '.' . $unique_id );
	$css->pbg_render_background( $attributes, 'background', 'Tablet' );
	$css->pbg_render_border( $attributes, 'border', 'Tablet' );
	$css->pbg_render_spacing( $attributes, 'padding', 'padding', 'Tablet' );
	$css->pbg_render_spacing( $attributes, 'margin', 'margin', 'Tablet' );
	$css->stop_media_query();

	// Mobile responsive styles.
	$css->start_media_query( 'mobile' );
	$css->set_selector( '.' . $unique_id );
	$css->pbg_render_background( $attributes, 'background', 'Mobile' );
	$css->pbg_render_border( $attributes, 'border', 'Mobile' );
	$css->pbg_render_spacing( $attributes, 'padding', 'padding', 'Mobile' );
	$css->pbg_render_spacing( $attributes, 'margin', 'margin', 'Mobile' );
	$css->stop_media_query();

	return $css->css_output();
}

/**
 * Renders the `premium/instagram-feed-header` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_instagram_feed_header( $attributes, $content, $block ) {
	return $content;
}


/**
 * Register the Instagram Feed Header block.
 *
 * @uses render_block_pbg_instagram_feed_header()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_instagram_feed_header() {
	register_block_type(
		PREMIUM_BLOCKS_PATH . 'blocks-config/instagram-feed-header',
		array(
			'render_callback' => 'render_block_pbg_instagram_feed_header',
		)
	);
}

register_block_pbg_instagram_feed_header();
