<?php
// Move this file to "blocks-config" folder with name "counter.php".

/**
 * Server-side rendering of the `premium/counter` block.
 *
 * @package WordPress
 */

function get_premium_counter_css( $attributes, $unique_id ) {
	$block_helpers = pbg_blocks_helper();
	$css           = new Premium_Blocks_css();

	// Desktop Styles.
	if ( isset( $attributes['align'] ) ) {
		$css->set_selector( '.' . $unique_id );
		$css->add_property( 'justify-content', $css->get_responsive_css( $attributes['align'], 'Desktop' ) . ' !important' );
	}
	// Number Style
	if ( isset( $attributes['numberTypography'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-countup__desc' . ' > .premium-countup__increment' );
		$css->render_typography( $attributes['numberTypography'], 'Desktop' );
	}
	if ( isset( $attributes['numberMargin'] ) ) {
		$number_margin = $attributes['numberMargin'];
		$css->set_selector( '.' . $unique_id . ' > .premium-countup__desc' . ' > .premium-countup__increment' );
		$css->add_property( 'margin', $css->render_spacing( $number_margin['Desktop'],isset( $number_margin['unit']['Desktop'] )?$number_margin['unit']['Desktop']:$number_margin['unit']) );
	}
	if ( isset( $attributes['numberPadding'] ) ) {
		$number_padding = $attributes['numberPadding'];
		$css->set_selector( '.' . $unique_id . ' > .premium-countup__desc' . ' > .premium-countup__increment' );
		$css->add_property( 'padding', $css->render_spacing( $number_padding['Desktop'], isset( $number_padding['unit']['Desktop'])?$number_padding['unit']['Desktop']:$number_padding['unit'] ) );
	}

	// Prefix Style
	if ( isset( $attributes['prefixTypography'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-countup__desc' . ' > .premium-countup__prefix' );
		$css->render_typography( $attributes['prefixTypography'], 'Desktop' );
	}
	if ( isset( $attributes['prefixMargin'] ) ) {
		$prefix_margin = $attributes['prefixMargin'];
		$css->set_selector( '.' . $unique_id . ' > .premium-countup__desc' . ' > .premium-countup__prefix' );
		$css->add_property( 'margin', $css->render_spacing( $prefix_margin['Desktop'], isset($prefix_margin['unit']['Desktop'] )?$prefix_margin['unit']['Desktop'] :$prefix_margin['unit']) );
	}
	if ( isset( $attributes['prefixPadding'] ) ) {
		$prefix_padding = $attributes['prefixPadding'];
		$css->set_selector( '.' . $unique_id . ' > .premium-countup__desc' . ' > .premium-countup__prefix' );
		$css->add_property( 'padding', $css->render_spacing( $prefix_padding['Desktop'],isset( $prefix_padding['unit']['Desktop'] )?$prefix_padding['unit']['Desktop']:$prefix_padding['unit']) );
	}

	// Suffix Style
	if ( isset( $attributes['suffixTypography'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-countup__desc' . ' > .premium-countup__suffix' );
		$css->render_typography( $attributes['suffixTypography'], 'Desktop' );
	}
	if ( isset( $attributes['suffixMargin'] ) ) {
		$suffix_margin = $attributes['suffixMargin'];
		$css->set_selector( '.' . $unique_id . ' > .premium-countup__desc' . ' > .premium-countup__suffix' );
		$css->add_property( 'margin', $css->render_spacing( $suffix_margin['Desktop'],isset( $suffix_margin['unit']['Desktop'])?$suffix_margin['unit']['Desktop']:$suffix_margin['unit'] ) );
	}
	if ( isset( $attributes['suffixPadding'] ) ) {
		$suffix_padding = $attributes['suffixPadding'];
		$css->set_selector( '.' . $unique_id . ' > .premium-countup__desc' . ' > .premium-countup__suffix' );
		$css->add_property( 'padding', $css->render_spacing( $suffix_padding['Desktop'], isset( $suffix_padding['unit']['Desktop'])?$suffix_padding['unit']['Desktop']:$suffix_padding['unit'] ) );
	}

	$css->start_media_query( 'tablet' );
	// Tablet Styles.
	if ( isset( $attributes['align'] ) ) {
		$css->set_selector( '.' . $unique_id );
		$css->add_property( 'justify-content', $css->get_responsive_css( $attributes['align'], 'Tablet' ) . ' !important' );
	}
	// Number Style
	if ( isset( $attributes['numberTypography'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-countup__desc' . ' > .premium-countup__increment' );
		$css->render_typography( $attributes['numberTypography'], 'Tablet' );
	}
	if ( isset( $attributes['numberMargin'] ) ) {
		$number_margin = $attributes['numberMargin'];
		$css->set_selector( '.' . $unique_id . ' > .premium-countup__desc' . ' > .premium-countup__increment' );
		$css->add_property( 'margin', $css->render_spacing( $number_margin['Tablet'], isset($number_margin['unit']['Tablet'])?$number_margin['unit']['Tablet']:$number_margin['unit'] ) );
	}
	if ( isset( $attributes['numberPadding'] ) ) {
		$number_padding = $attributes['numberPadding'];
		$css->set_selector( '.' . $unique_id . ' > .premium-countup__desc' . ' > .premium-countup__increment' );
		$css->add_property( 'padding', $css->render_spacing( $number_padding['Tablet'], isset($number_padding['unit']['Tablet'])?$number_padding['unit']['Tablet']:$number_padding['unit'] ) );
	}

	// Prefix Style
	if ( isset( $attributes['prefixTypography'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-countup__desc' . ' > .premium-countup__prefix' );
		$css->render_typography( $attributes['prefixTypography'], 'Tablet' );
	}
	if ( isset( $attributes['prefixMargin'] ) ) {
		$prefix_margin = $attributes['prefixMargin'];
		$css->set_selector( '.' . $unique_id . ' > .premium-countup__desc' . ' > .premium-countup__prefix' );
		$css->add_property( 'margin', $css->render_spacing( $prefix_margin['Tablet'], isset( $prefix_margin['unit']['Tablet'] )?$prefix_margin['unit']['Tablet'] :$prefix_margin['unit']) );
	}
	if ( isset( $attributes['prefixPadding'] ) ) {
		$prefix_padding = $attributes['prefixPadding'];
		$css->set_selector( '.' . $unique_id . ' > .premium-countup__desc' . ' > .premium-countup__prefix' );
		$css->add_property( 'padding', $css->render_spacing( $prefix_padding['Tablet'], isset( $prefix_padding['unit']['Tablet'] )?$prefix_padding['unit']['Tablet'] :$prefix_padding['unit'] ) );
	}

	// Suffix Style
	if ( isset( $attributes['suffixTypography'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-countup__desc' . ' > .premium-countup__suffix' );
		$css->render_typography( $attributes['suffixTypography'], 'Tablet' );
	}
	if ( isset( $attributes['suffixMargin'] ) ) {
		$suffix_margin = $attributes['suffixMargin'];
		$css->set_selector( '.' . $unique_id . ' > .premium-countup__desc' . ' > .premium-countup__suffix' );
		$css->add_property( 'margin', $css->render_spacing( $suffix_margin['Tablet'],isset( $suffix_margin['unit']['Tablet'] )?$suffix_margin['unit']['Tablet'] :$suffix_margin['unit']) );
	}
	if ( isset( $attributes['suffixPadding'] ) ) {
		$suffix_padding = $attributes['suffixPadding'];
		$css->set_selector( '.' . $unique_id . ' > .premium-countup__desc' . ' > .premium-countup__suffix' );
		$css->add_property( 'padding', $css->render_spacing( $suffix_padding['Tablet'], isset( $suffix_padding['unit']['Tablet'] )?$suffix_padding['unit']['Tablet'] :$suffix_padding['unit'] ) );
	}

	$css->stop_media_query();
	$css->start_media_query( 'mobile' );
	// Mobile Styles.
	if ( isset( $attributes['align'] ) ) {
		$css->set_selector( '.' . $unique_id );
		$css->add_property( 'justify-content', $css->get_responsive_css( $attributes['align'], 'Mobile' ) . ' !important' );
	}
	// Number Style
	if ( isset( $attributes['numberTypography'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-countup__desc' . ' > .premium-countup__increment' );
		$css->render_typography( $attributes['numberTypography'], 'Mobile' );
	}
	if ( isset( $attributes['numberMargin'] ) ) {
		$number_margin = $attributes['numberMargin'];
		$css->set_selector( '.' . $unique_id . ' > .premium-countup__desc' . ' > .premium-countup__increment' );
		$css->add_property( 'margin', $css->render_spacing( $number_margin['Mobile'], isset( $number_margin['unit']['Mobile'] )?$number_margin['unit']['Mobile'] :$number_margin['unit']) );
	}
	if ( isset( $attributes['numberPadding'] ) ) {
		$number_padding = $attributes['numberPadding'];
		$css->set_selector( '.' . $unique_id . ' > .premium-countup__desc' . ' > .premium-countup__increment' );
		$css->add_property( 'padding', $css->render_spacing( $number_padding['Mobile'],  isset( $number_padding['unit']['Mobile'] )?$number_padding['unit']['Mobile'] :$number_padding['unit'] ) );
	}

	// Prefix Style
	if ( isset( $attributes['prefixTypography'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-countup__desc' . ' > .premium-countup__prefix' );
		$css->render_typography( $attributes['prefixTypography'], 'Mobile' );
	}
	if ( isset( $attributes['prefixMargin'] ) ) {
		$prefix_margin = $attributes['prefixMargin'];
		$css->set_selector( '.' . $unique_id . ' > .premium-countup__desc' . ' > .premium-countup__prefix' );
		$css->add_property( 'margin', $css->render_spacing( $prefix_margin['Mobile'],  isset( $prefix_margin['unit']['Mobile'] )?$prefix_margin['unit']['Mobile'] :$prefix_margin['unit'] ) );
	}
	if ( isset( $attributes['prefixPadding'] ) ) {
		$prefix_padding = $attributes['prefixPadding'];
		$css->set_selector( '.' . $unique_id . ' > .premium-countup__desc' . ' > .premium-countup__prefix' );
		$css->add_property( 'padding', $css->render_spacing( $prefix_padding['Mobile'], isset( $prefix_padding['unit']['Mobile'] )?$prefix_padding['unit']['Mobile'] :$prefix_padding['unit'] ) );
	}

	// Suffix Style
	if ( isset( $attributes['suffixTypography'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-countup__desc' . ' > .premium-countup__suffix' );
		$css->render_typography( $attributes['suffixTypography'], 'Mobile' );
	}
	if ( isset( $attributes['suffixMargin'] ) ) {
		$suffix_margin = $attributes['suffixMargin'];
		$css->set_selector( '.' . $unique_id . ' > .premium-countup__desc' . ' > .premium-countup__suffix' );
		$css->add_property( 'margin', $css->render_spacing( $suffix_margin['Mobile'], isset($suffix_margin['unit']['Mobile'])? $suffix_margin['unit']['Mobile']:$suffix_margin['unit']) );
	}
	if ( isset( $attributes['suffixPadding'] ) ) {
		$suffix_padding = $attributes['suffixPadding'];
		$css->set_selector( '.' . $unique_id . ' > .premium-countup__desc' . ' > .premium-countup__suffix' );
		$css->add_property( 'padding', $css->render_spacing( $suffix_padding['Mobile'],  isset($suffix_padding['unit']['Mobile'])? $suffix_padding['unit']['Mobile']:$suffix_padding['unit'] ) );
	}

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
