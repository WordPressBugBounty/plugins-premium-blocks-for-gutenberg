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

	$css->render_responsive( function( $css, $device ) use ( $attributes, $unique_id ) {
		$css->set_selector( '.' . $unique_id );
		$css->pbg_render_spacing( $attributes, 'padding', 'padding', $device );
		$css->pbg_render_spacing( $attributes, 'margin', 'margin', $device );
	} );

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
