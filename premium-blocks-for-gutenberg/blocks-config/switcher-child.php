<?php
/**
 * Server-side rendering of the `premium/switcher-child` block.
 *
 * @package WordPress
 */

/**
 * Generate CSS styles for the Switcher Child block
 *
 * @param array  $attributes Block attributes.
 * @param string $unique_id Unique block ID.
 * @return string Generated CSS string
 */
function get_premium_switcher_child_css( $attributes, $unique_id ) {
	$css       = new Premium_Blocks_css();
	$unique_id = $attributes['blockId'];

	// Desktop styles
	$css->set_selector( '.' . $unique_id );
	$css->pbg_render_spacing( $attributes, 'padding', 'padding', 'Desktop' );
	$css->pbg_render_spacing( $attributes, 'margin', 'margin', 'Desktop' );

	// Tablet styles
	$css->start_media_query( 'tablet' );
	
	$css->set_selector( '.' . $unique_id );
	$css->pbg_render_spacing( $attributes, 'padding', 'padding', 'Tablet' );
	$css->pbg_render_spacing( $attributes, 'margin', 'margin', 'Tablet' );

	$css->stop_media_query();

	// Mobile styles
	$css->start_media_query( 'mobile' );

	$css->set_selector( '.' . $unique_id );
	$css->pbg_render_spacing( $attributes, 'padding', 'padding', 'Mobile' );
	$css->pbg_render_spacing( $attributes, 'margin', 'margin', 'Mobile' );

	$css->stop_media_query();

	return $css->css_output();
}

/**
 * Registers the `premium/switcher-child` block on the server.
 */
function register_block_pbg_switcher_child() {
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	register_block_type(
		'premium/switcher-child',
		array(
			'editor_style'  => 'premium-blocks-editor-css',
			'editor_script' => 'pbg-blocks-js',
		)
	);
}

register_block_pbg_switcher_child();
