<?php
/**
 * Server-side rendering of the `pbg/pricing-table` block.
 *
 * @package WordPress
 */

/**
 * Get Pricing Table Block CSS
 *
 * Return Frontend CSS for Pricing Table.
 *
 * @access public
 *
 * @param string $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_pricing_table_css_style( $attr, $unique_id ) {
	$css = new Premium_Blocks_css();

	// Table.

  $css->set_selector( 
    "{$unique_id}:not(:has(.premium-pricing-table)), " .
    "{$unique_id} .premium-pricing-table"
  );
  $css->pbg_render_border($attr, 'tableBorder', 'Desktop');
  $css->pbg_render_spacing($attr, 'tablePadding', 'padding', 'Desktop');
  $css->pbg_render_shadow($attr, 'tableBoxShadow', 'box-shadow');
//   $css->pbg_render_color($attr, 'tableStyles[0].tableBack', 'background-color');
  $css->pbg_render_background($attr, 'background', 'Desktop');

	$css->start_media_query( 'tablet' );

	// Table.
	$css->set_selector( 
    "{$unique_id}:not(:has(.premium-pricing-table)), " .
    "{$unique_id} .premium-pricing-table"
  );
  $css->pbg_render_border($attr, 'tableBorder', 'Tablet');
  $css->pbg_render_spacing($attr, 'tablePadding', 'padding', 'Tablet');
    $css->pbg_render_background($attr, 'background', 'Tablet');


	$css->stop_media_query();
	$css->start_media_query( 'mobile' );

	// Table.
	$css->set_selector( 
    "{$unique_id}:not(:has(.premium-pricing-table)), " .
    "{$unique_id} .premium-pricing-table"
  );
    $css->pbg_render_border($attr, 'tableBorder', 'Mobile');
    $css->pbg_render_spacing($attr, 'tablePadding', 'padding', 'Mobile');
	$css->pbg_render_background($attr, 'background', 'Mobile');


	$css->stop_media_query();
	return $css->css_output();
}

/**
 * Renders the `premium/pricing-table` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_pricing_table( $attributes, $content, $block ) {

	return $content;
}

/**
 * Register the pricing_table block.
 *
 * @uses render_block_pbg_pricing_table()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_pricing_table() {
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	register_block_type(
		PREMIUM_BLOCKS_PATH . '/blocks-config/pricing-table',
		array(
			'render_callback' => 'render_block_pbg_pricing_table',
		)
	);
}

register_block_pbg_pricing_table();
