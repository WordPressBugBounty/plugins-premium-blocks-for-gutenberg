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
	if ( isset( $attr['tableBorder'] ) ) {
		$table_border        = $attr['tableBorder'];
		$table_border_width  = $table_border['borderWidth'];
		$table_border_radius = $table_border['borderRadius'];

		$css->set_selector( $unique_id );
		$css->add_property( 'border-width', $css->render_spacing( $table_border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $table_border_radius['Desktop'], 'px' ) );
	}

	if ( isset( $attr['tablePadding'] ) ) {
		$table_padding = $attr['tablePadding'];
		$css->set_selector( $unique_id );
		$css->add_property( 'padding', $css->render_spacing( $table_padding['Desktop'],isset($table_padding['unit']['Desktop'])?$table_padding['unit']['Desktop']:$table_padding['unit']  ) );
	}

	$css->start_media_query( 'tablet' );

	// Table.
	if ( isset( $attr['tableBorder'] ) ) {
		$table_border        = $attr['tableBorder'];
		$table_border_width  = $table_border['borderWidth'];
		$table_border_radius = $table_border['borderRadius'];

		$css->set_selector( $unique_id );
		$css->add_property( 'border-width', $css->render_spacing( $table_border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $table_border_radius['Tablet'], 'px' ) );
	}

	if ( isset( $attr['tablePadding'] ) ) {
		$table_padding = $attr['tablePadding'];
		$css->set_selector( $unique_id );
		$css->add_property( 'padding', $css->render_spacing( $table_padding['Tablet'], isset($table_padding['unit']['Tablet']) ?$table_padding['unit']['Tablet']:$table_padding['unit'] ) );
	}

	$css->stop_media_query();
	$css->start_media_query( 'mobile' );

	// Table.
	if ( isset( $attr['tableBorder'] ) ) {
		$table_border        = $attr['tableBorder'];
		$table_border_width  = $table_border['borderWidth'];
		$table_border_radius = $table_border['borderRadius'];

		$css->set_selector( $unique_id );
		$css->add_property( 'border-width', $css->render_spacing( $table_border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $table_border_radius['Mobile'], 'px' ) );
	}

	if ( isset( $attr['tablePadding'] ) ) {
		$table_padding = $attr['tablePadding'];
		$css->set_selector( $unique_id );
		$css->add_property( 'padding', $css->render_spacing( $table_padding['Mobile'], isset( $table_padding['unit']['Mobile'])? $table_padding['unit']['Mobile']: $table_padding['unit'] ) );
	}

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
