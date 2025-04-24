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

  if ( isset( $attr['tableStyles'][0]['tableBack'])){
    $table_bg_color = $attr['tableStyles'][0]['tableBack'];

    $css->set_selector( "{$unique_id}:not(:has(.premium-pricing-table))" );
    $css->add_property( 'background-color' , $css->render_color($table_bg_color));

    $css->set_selector( "{$unique_id} .premium-pricing-table" );
    $css->add_property( 'background-color' , $css->render_color($table_bg_color));
  }

  if ( isset( $attr['tableBoxShadow'] ) ) {
    $table_box_shadow = $attr['tableBoxShadow'];
		$css->set_selector( "{$unique_id}:not(:has(.premium-pricing-table))" );
		$css->add_property( 'box-shadow', $css->render_shadow( $table_box_shadow ) );

		$css->set_selector( "{$unique_id} .premium-pricing-table" );
		$css->add_property( 'box-shadow', $css->render_shadow( $table_box_shadow ) );
	}

  if ( isset( $attr['tableBorder'] ) ) {
		$css->set_selector( "{$unique_id}:not(:has(.premium-pricing-table))" );
		$css->render_border( $attr['tableBorder'], 'Desktop' );

		$css->set_selector( "{$unique_id} .premium-pricing-table" );
		$css->render_border( $attr['tableBorder'], 'Desktop' );
	}

	if ( isset( $attr['tablePadding'] ) ) {
		$table_padding = $attr['tablePadding'];
		$css->set_selector( "{$unique_id}:not(:has(.premium-pricing-table))" );
		$css->add_property( 'padding', $css->render_spacing( $table_padding['Desktop'],isset($table_padding['unit']['Desktop'])?$table_padding['unit']['Desktop']:$table_padding['unit']  ) );
		
    $css->set_selector( "{$unique_id} .premium-pricing-table" );
		$css->add_property( 'padding', $css->render_spacing( $table_padding['Desktop'],isset($table_padding['unit']['Desktop'])?$table_padding['unit']['Desktop']:$table_padding['unit']  ) );
	}

	$css->start_media_query( 'tablet' );

	// Table.
	if ( isset( $attr['tableBorder'] ) ) {
		$css->set_selector( "{$unique_id}:not(:has(.premium-pricing-table))" );
		$css->render_border( $attr['tableBorder'], 'Tablet' );

		$css->set_selector( "{$unique_id} .premium-pricing-table" );
		$css->render_border( $attr['tableBorder'], 'Tablet' );
	}

	if ( isset( $attr['tablePadding'] ) ) {
		$table_padding = $attr['tablePadding'];
		$css->set_selector( "{$unique_id}:not(:has(.premium-pricing-table))" );
		$css->add_property( 'padding', $css->render_spacing( $table_padding['Tablet'], isset($table_padding['unit']['Tablet']) ?$table_padding['unit']['Tablet']:$table_padding['unit'] ) );
		
    $css->set_selector( "{$unique_id} .premium-pricing-table" );
		$css->add_property( 'padding', $css->render_spacing( $table_padding['Tablet'], isset($table_padding['unit']['Tablet']) ?$table_padding['unit']['Tablet']:$table_padding['unit'] ) );
	}

	$css->stop_media_query();
	$css->start_media_query( 'mobile' );

	// Table.
	if ( isset( $attr['tableBorder'] ) ) {
		$css->set_selector( "{$unique_id}:not(:has(.premium-pricing-table))" );
		$css->render_border( $attr['tableBorder'], 'Mobile' );

		$css->set_selector( "{$unique_id} .premium-pricing-table" );
		$css->render_border( $attr['tableBorder'], 'Mobile' );
	}

	if ( isset( $attr['tablePadding'] ) ) {
		$table_padding = $attr['tablePadding'];
		$css->set_selector( "{$unique_id}:not(:has(.premium-pricing-table))" );
		$css->add_property( 'padding', $css->render_spacing( $table_padding['Mobile'], isset( $table_padding['unit']['Mobile'])? $table_padding['unit']['Mobile']: $table_padding['unit'] ) );
		
    $css->set_selector( "{$unique_id} .premium-pricing-table" );
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
