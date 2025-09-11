<?php
/**
 * Server-side rendering of the `premium/price` block.
 *
 * @package WordPress
 */

function get_premium_price_css( $attributes, $unique_id ) {
	$css = new Premium_Blocks_css();

	// Desktop Styles.

  // Container.
  $css->set_selector( ".{$unique_id}" );
  $css->pbg_render_align_self($attributes, 'align', 'justify-content', 'Desktop');
  $css->pbg_render_spacing($attributes, 'padding', 'padding', 'Desktop');
  $css->pbg_render_spacing($attributes, 'margin', 'margin', 'Desktop');

	// Slashed Price.
  $css->set_selector( ".{$unique_id} .premium-pricing-slash" );
  $css->pbg_render_typography($attributes, 'slashedTypography', 'Desktop');
  $css->pbg_render_value($attributes, 'slashedAlign', 'align-self', 'Desktop');

	// Currency.
  $css->set_selector( ".{$unique_id} .premium-pricing-currency" );
  $css->pbg_render_typography($attributes, 'currencyTypography', 'Desktop');
  $css->pbg_render_value($attributes, 'currencyAlign', 'align-self', 'Desktop');

	// Price.
  $css->set_selector( ".{$unique_id} .premium-pricing-val" );
  $css->pbg_render_typography($attributes, 'priceTypography', 'Desktop');
  $css->pbg_render_value($attributes, 'priceAlign', 'align-self', 'Desktop');

	// Divider.
  $css->set_selector( ".{$unique_id} .premium-pricing-divider" );
  $css->pbg_render_typography($attributes, 'dividerTypography', 'Desktop');
  $css->pbg_render_value($attributes, 'dividerAlign', 'align-self', 'Desktop');
	
	// Duration.
  $css->set_selector( ".{$unique_id} .premium-pricing-dur" );
  $css->pbg_render_typography($attributes, 'durationTypography', 'Desktop');
  $css->pbg_render_value($attributes, 'durationAlign', 'align-self', 'Desktop');

	$css->start_media_query( 'tablet' );
	// Tablet Styles.

	// Container.
  $css->set_selector( ".{$unique_id}" );
  $css->pbg_render_align_self($attributes, 'align', 'justify-content', 'Tablet');
  $css->pbg_render_spacing($attributes, 'padding', 'padding', 'Tablet');
  $css->pbg_render_spacing($attributes, 'margin', 'margin', 'Tablet');

	// Slashed Price.
  $css->set_selector( ".{$unique_id} .premium-pricing-slash" );
  $css->pbg_render_typography($attributes, 'slashedTypography', 'Tablet');
  $css->pbg_render_value($attributes, 'slashedAlign', 'align-self', 'Tablet');

	// Currency.
  $css->set_selector( ".{$unique_id} .premium-pricing-currency" );
  $css->pbg_render_typography($attributes, 'currencyTypography', 'Tablet');
  $css->pbg_render_value($attributes, 'currencyAlign', 'align-self', 'Tablet');

	// Price.
  $css->set_selector( ".{$unique_id} .premium-pricing-val" );
  $css->pbg_render_typography($attributes, 'priceTypography', 'Tablet');
  $css->pbg_render_value($attributes, 'priceAlign', 'align-self', 'Tablet');

	// Divider.
  $css->set_selector( ".{$unique_id} .premium-pricing-divider" );
  $css->pbg_render_typography($attributes, 'dividerTypography', 'Tablet');
  $css->pbg_render_value($attributes, 'dividerAlign', 'align-self', 'Tablet');
	
	// Duration.
  $css->set_selector( ".{$unique_id} .premium-pricing-dur" );
  $css->pbg_render_typography($attributes, 'durationTypography', 'Tablet');
  $css->pbg_render_value($attributes, 'durationAlign', 'align-self', 'Tablet');

	$css->stop_media_query();
	$css->start_media_query( 'mobile' );
	// Mobile Styles.

	// Container.
  $css->set_selector( ".{$unique_id}" );
  $css->pbg_render_align_self($attributes, 'align', 'justify-content', 'Mobile');
  $css->pbg_render_spacing($attributes, 'padding', 'padding', 'Mobile');
  $css->pbg_render_spacing($attributes, 'margin', 'margin', 'Mobile');

	// Slashed Price.
  $css->set_selector( ".{$unique_id} .premium-pricing-slash" );
  $css->pbg_render_typography($attributes, 'slashedTypography', 'Mobile');
  $css->pbg_render_value($attributes, 'slashedAlign', 'align-self', 'Mobile');

	// Currency.
  $css->set_selector( ".{$unique_id} .premium-pricing-currency" );
  $css->pbg_render_typography($attributes, 'currencyTypography', 'Mobile');
  $css->pbg_render_value($attributes, 'currencyAlign', 'align-self', 'Mobile');

	// Price.
  $css->set_selector( ".{$unique_id} .premium-pricing-val" );
  $css->pbg_render_typography($attributes, 'priceTypography', 'Mobile');
  $css->pbg_render_value($attributes, 'priceAlign', 'align-self', 'Mobile');

	// Divider.
  $css->set_selector( ".{$unique_id} .premium-pricing-divider" );
  $css->pbg_render_typography($attributes, 'dividerTypography', 'Mobile');
  $css->pbg_render_value($attributes, 'dividerAlign', 'align-self', 'Mobile');
	
	// Duration.
  $css->set_selector( ".{$unique_id} .premium-pricing-dur" );
  $css->pbg_render_typography($attributes, 'durationTypography', 'Mobile');
  $css->pbg_render_value($attributes, 'durationAlign', 'align-self', 'Mobile');

	$css->stop_media_query();

	return $css->css_output();
}

/**
 * Renders the `premium/price` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_price( $attributes, $content, $block ) {

	return $content;
}


/**
 * Register the Price block.
 *
 * @uses render_block_pbg_price()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_price() {
	register_block_type(
		'premium/price',
		array(
			'render_callback' => 'render_block_pbg_price',
			'editor_style'    => 'premium-blocks-editor-css',
			'editor_script'   => 'pbg-blocks-js',
		)
	);
}

register_block_pbg_price();
