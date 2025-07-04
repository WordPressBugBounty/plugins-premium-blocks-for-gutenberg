<?php
// Move this file to "blocks-config" folder with name "price.php".

/**
 * Server-side rendering of the `premium/price` block.
 *
 * @package WordPress
 */

function get_premium_price_css( $attributes, $unique_id ) {
	$css = new Premium_Blocks_css();

	// Desktop Styles.
	// Container.
	if ( isset( $attributes['padding'] ) ) {
		$padding = $attributes['padding'];

		$css->set_selector( ".{$unique_id}" );
		$css->add_property( 'padding', $css->render_spacing( $padding['Desktop'], isset($padding['unit']['Desktop'])?$padding['unit']['Desktop']:$padding['unit']  ) );
	}

	if ( isset( $attributes['margin'] ) ) {
		$margin = $attributes['margin'];

		$css->set_selector( ".{$unique_id}" );
		$css->add_property( 'margin', $css->render_spacing( $margin['Desktop'], isset($margin['unit']['Desktop'])?$margin['unit']['Desktop']:$margin['unit']  ) );
	}
	if ( isset( $attributes['align'] ) ) {
		$align = $css->get_responsive_css( $attributes['align'], 'Desktop' );

		$css->set_selector( ".{$unique_id}" );
		$css->add_property( 'justify-content', $css->render_string( $align, ' !important' ) );
	}
	// Slashed Price.
  $css->set_selector( ".{$unique_id} .premium-pricing-slash" );
  $css->pbg_render_typography($attributes, 'slashedTypography', 'Desktop');

	if ( isset( $attributes['slashedAlign'] ) ) {
		$slashed_align = $attributes['slashedAlign'];

		$css->set_selector( ".{$unique_id} .premium-pricing-slash" );
		$css->add_property( 'align-self', $css->get_responsive_css( $slashed_align, 'Desktop' ) );
	}
	// Currency.
  $css->set_selector( ".{$unique_id} .premium-pricing-currency" );
  $css->pbg_render_typography($attributes, 'currencyTypography', 'Desktop');

	if ( isset( $attributes['currencyAlign'] ) ) {
		$currency_align = $attributes['currencyAlign'];

		$css->set_selector( ".{$unique_id} .premium-pricing-currency" );
		$css->add_property( 'align-self', $css->get_responsive_css( $currency_align, 'Desktop' ) );
	}
	// Price.
  $css->set_selector( ".{$unique_id} .premium-pricing-val" );
  $css->pbg_render_typography($attributes, 'priceTypography', 'Desktop');

	if ( isset( $attributes['priceAlign'] ) ) {
		$price_align = $attributes['priceAlign'];

		$css->set_selector( ".{$unique_id} .premium-pricing-val" );
		$css->add_property( 'align-self', $css->get_responsive_css( $price_align, 'Desktop' ) );
	}
	// Divider.
  $css->set_selector( ".{$unique_id} .premium-pricing-divider" );
  $css->pbg_render_typography($attributes, 'dividerTypography', 'Desktop');

	if ( isset( $attributes['dividerAlign'] ) ) {
		$divider_align = $attributes['dividerAlign'];

		$css->set_selector( ".{$unique_id} .premium-pricing-divider" );
		$css->add_property( 'align-self', $css->get_responsive_css( $divider_align, 'Desktop' ) );
	}
	// Duration.
  $css->set_selector( ".{$unique_id} .premium-pricing-dur" );
  $css->pbg_render_typography($attributes, 'durationTypography', 'Desktop');

	if ( isset( $attributes['durationAlign'] ) ) {
		$duration_align = $attributes['durationAlign'];

		$css->set_selector( ".{$unique_id} .premium-pricing-dur" );
		$css->add_property( 'align-self', $css->get_responsive_css( $duration_align, 'Desktop' ) );
	}

	$css->start_media_query( 'tablet' );
	// Tablet Styles.
	// Container.
	if ( isset( $attributes['padding'] ) ) {
		$padding = $attributes['padding'];

		$css->set_selector( ".{$unique_id}" );
		$css->add_property( 'padding', $css->render_spacing( $padding['Tablet'], isset($padding['unit']['Tablet'])?$padding['unit']['Tablet']:$padding['unit']  ) );
	}

	if ( isset( $attributes['margin'] ) ) {
		$margin = $attributes['margin'];

		$css->set_selector( ".{$unique_id}" );
		$css->add_property( 'margin', $css->render_spacing( $margin['Tablet'], isset($margin['unit']['Tablet'])?$margin['unit']['Tablet']:$margin['unit']  ) );
	}
	if ( isset( $attributes['align'] ) ) {
		$align = $css->get_responsive_css( $attributes['align'], 'Tablet' );

		$css->set_selector( ".{$unique_id}" );
		$css->add_property( 'justify-content', $css->render_string( $align, ' !important' ) );
	}
	// Slashed Price.
	$css->set_selector( ".{$unique_id} .premium-pricing-slash" );
  $css->pbg_render_typography($attributes, 'slashedTypography', 'Tablet');

	if ( isset( $attributes['slashedAlign'] ) ) {
		$slashed_align = $attributes['slashedAlign'];

		$css->set_selector( ".{$unique_id} .premium-pricing-slash" );
		$css->add_property( 'align-self', $css->get_responsive_css( $slashed_align, 'Tablet' ) );
	}
	// Currency.
	$css->set_selector( ".{$unique_id} .premium-pricing-currency" );
  $css->pbg_render_typography($attributes, 'currencyTypography', 'Tablet');

	if ( isset( $attributes['currencyAlign'] ) ) {
		$currency_align = $attributes['currencyAlign'];

		$css->set_selector( ".{$unique_id} .premium-pricing-currency" );
		$css->add_property( 'align-self', $css->get_responsive_css( $currency_align, 'Tablet' ) );
	}
	// Price.
	$css->set_selector( ".{$unique_id} .premium-pricing-val" );
  $css->pbg_render_typography($attributes, 'priceTypography', 'Tablet');

	if ( isset( $attributes['priceAlign'] ) ) {
		$price_align = $attributes['priceAlign'];

		$css->set_selector( ".{$unique_id} .premium-pricing-val" );
		$css->add_property( 'align-self', $css->get_responsive_css( $price_align, 'Tablet' ) );
	}
	// Divider.
	$css->set_selector( ".{$unique_id} .premium-pricing-divider" );
  $css->pbg_render_typography($attributes, 'dividerTypography', 'Tablet');

	if ( isset( $attributes['dividerAlign'] ) ) {
		$divider_align = $attributes['dividerAlign'];

		$css->set_selector( ".{$unique_id} .premium-pricing-divider" );
		$css->add_property( 'align-self', $css->get_responsive_css( $divider_align, 'Tablet' ) );
	}
	// Duration.
	$css->set_selector( ".{$unique_id} .premium-pricing-dur" );
  $css->pbg_render_typography($attributes, 'durationTypography', 'Tablet');

	if ( isset( $attributes['durationAlign'] ) ) {
		$duration_align = $attributes['durationAlign'];

		$css->set_selector( ".{$unique_id} .premium-pricing-dur" );
		$css->add_property( 'align-self', $css->get_responsive_css( $duration_align, 'Tablet' ) );
	}

	$css->stop_media_query();
	$css->start_media_query( 'mobile' );
	// Mobile Styles.
	// Container.
	if ( isset( $attributes['padding'] ) ) {
		$padding = $attributes['padding'];

		$css->set_selector( ".{$unique_id}" );
		$css->add_property( 'padding', $css->render_spacing( $padding['Mobile'], isset( $padding['unit']['Mobile'])? $padding['unit']['Mobile']: $padding['unit'] ) );
	}

	if ( isset( $attributes['margin'] ) ) {
		$margin = $attributes['margin'];

		$css->set_selector( ".{$unique_id}" );
		$css->add_property( 'margin', $css->render_spacing( $margin['Mobile'], isset($margin['unit']['Mobile'])?$margin['unit']['Mobile']:$margin['unit']  ) );
	}
	if ( isset( $attributes['align'] ) ) {
		$align = $css->get_responsive_css( $attributes['align'], 'Mobile' );

		$css->set_selector( ".{$unique_id}" );
		$css->add_property( 'justify-content', $css->render_string( $align, ' !important' ) );
	}
	// Slashed Price.
	$css->set_selector( ".{$unique_id} .premium-pricing-slash" );
  $css->pbg_render_typography($attributes, 'slashedTypography', 'Mobile');

	if ( isset( $attributes['slashedAlign'] ) ) {
		$slashed_align = $attributes['slashedAlign'];

		$css->set_selector( ".{$unique_id} .premium-pricing-slash" );
		$css->add_property( 'align-self', $css->get_responsive_css( $slashed_align, 'Mobile' ) );
	}
	// Currency.
	$css->set_selector( ".{$unique_id} .premium-pricing-currency" );
  $css->pbg_render_typography($attributes, 'currencyTypography', 'Mobile');

	if ( isset( $attributes['currencyAlign'] ) ) {
		$currency_align = $attributes['currencyAlign'];

		$css->set_selector( ".{$unique_id} .premium-pricing-currency" );
		$css->add_property( 'align-self', $css->get_responsive_css( $currency_align, 'Mobile' ) );
	}
	// Price.
	$css->set_selector( ".{$unique_id} .premium-pricing-val" );
  $css->pbg_render_typography($attributes, 'priceTypography', 'Mobile');

	if ( isset( $attributes['priceAlign'] ) ) {
		$price_align = $attributes['priceAlign'];

		$css->set_selector( ".{$unique_id} .premium-pricing-val" );
		$css->add_property( 'align-self', $css->get_responsive_css( $price_align, 'Mobile' ) );
	}
	// Divider.
	$css->set_selector( ".{$unique_id} .premium-pricing-divider" );
  $css->pbg_render_typography($attributes, 'dividerTypography', 'Mobile');

	if ( isset( $attributes['dividerAlign'] ) ) {
		$divider_align = $attributes['dividerAlign'];

		$css->set_selector( ".{$unique_id} .premium-pricing-divider" );
		$css->add_property( 'align-self', $css->get_responsive_css( $divider_align, 'Mobile' ) );
	}
	// Duration.
	$css->set_selector( ".{$unique_id} .premium-pricing-dur" );
  $css->pbg_render_typography($attributes, 'durationTypography', 'Mobile');

	if ( isset( $attributes['durationAlign'] ) ) {
		$duration_align = $attributes['durationAlign'];

		$css->set_selector( ".{$unique_id} .premium-pricing-dur" );
		$css->add_property( 'align-self', $css->get_responsive_css( $duration_align, 'Mobile' ) );
	}

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
