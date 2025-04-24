<?php
// Move this file to "blocks-config" folder with name "badge.php".

/**
 * Server-side rendering of the `premium/badge` block.
 *
 * @package WordPress
 */

function get_premium_badge_css( $attributes, $unique_id ) {
	$css = new Premium_Blocks_css();

	// Desktop Styles.
	if ( isset( $attributes['typography'] ) ) {
		$typography = $attributes['typography'];
		$css->set_selector( ".{$unique_id} span" );
		$css->render_typography( $typography, 'Desktop' );

	}
	if ( isset( $attributes['textWidth'] ) ) {
		$css->set_selector( ".{$unique_id} span" );
		$css->add_property( 'width', $css->get_responsive_css( $attributes['textWidth'] , 'Desktop' ) . 'px ' );
	}
	if ( isset( $attributes['badgeSize'] ) ) {
		$css->set_selector( ".{$unique_id} .premium-badge-wrap" );
	
		if(isset($attributes['position'] ) && $attributes["position"] ==="left"){
			$css->add_property( 'border-top-width', $css->get_responsive_css( $attributes['badgeSize'] , 'Desktop' ) . 'px !important' );
		}else{
			$css->add_property( 'border-bottom-width', $css->get_responsive_css( $attributes['badgeSize'] , 'Desktop' ) . 'px !important ' );

		}
		$css->add_property( 'border-right-width', $css->get_responsive_css( $attributes['badgeSize'] , 'Desktop' ) . 'px !important' );
	}
	$css->start_media_query( 'tablet' );
	// Tablet Styles.
	if ( isset( $attributes['typography'] ) ) {
		$typography = $attributes['typography'];

		$css->set_selector( ".{$unique_id} span" );
		$css->render_typography( $typography, 'Tablet' );
	}

	if ( isset( $attributes['textWidth'] ) ) {
		$css->set_selector( ".{$unique_id} span" );
		$css->add_property( 'width', $css->get_responsive_css( $attributes['textWidth'] , 'Tablet' ) . 'px ' );
	}
	if ( isset( $attributes['badgeSize'] ) ) {
		$css->set_selector( ".{$unique_id} .premium-badge-wrap" );
	
		if(isset($attributes['position'] ) && $attributes["position"] ==="left"){
			$css->add_property( 'border-top-width', $css->get_responsive_css( $attributes['badgeSize'] , 'Tablet' ) . 'px !important' );
		}else{
			$css->add_property( 'border-bottom-width', $css->get_responsive_css( $attributes['badgeSize'] , 'Tablet' ) . 'px !important ' );
		}
		$css->add_property( 'border-right-width', $css->get_responsive_css( $attributes['badgeSize'] , 'Tablet' ) . 'px !important' );
	}


	$css->stop_media_query();
	$css->start_media_query( 'mobile' );
	// Mobile Styles.
	if ( isset( $attributes['typography'] ) ) {
		$typography = $attributes['typography'];

		$css->set_selector( ".{$unique_id} span" );
		$css->render_typography( $typography, 'Mobile' );
	}

	if ( isset( $attributes['textWidth'] ) ) {
		$css->set_selector( ".{$unique_id} span" );
		$css->add_property( 'width', $css->get_responsive_css( $attributes['textWidth'] , 'Mobile' ) . 'px ' );

	}

	if ( isset( $attributes['badgeSize'] ) ) {
		$css->set_selector( ".{$unique_id} .premium-badge-wrap" );
	
		if(isset($attributes['position'] ) && $attributes["position"] ==="left"){
			$css->add_property( 'border-top-width', $css->get_responsive_css( $attributes['badgeSize'] , 'Mobile' ) . 'px !important' );
		}else{
			$css->add_property( 'border-bottom-width', $css->get_responsive_css( $attributes['badgeSize'] , 'Mobile' ) . 'px !important ' );

		}
		$css->add_property( 'border-right-width', $css->get_responsive_css( $attributes['badgeSize'] , 'Mobile' ) . 'px !important' );
	}

	$css->stop_media_query();

	return $css->css_output();
}

/**
 * Renders the `premium/badge` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_badge( $attributes, $content, $block ) {

	return $content;
}


/**
 * Register the Badge block.
 *
 * @uses render_block_pbg_badge()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_badge() {
	register_block_type(
		'premium/badge',
		array(
			'render_callback' => 'render_block_pbg_badge',
			'editor_style'    => 'premium-blocks-editor-css',
			'editor_script'   => 'pbg-blocks-js',
		)
	);
}

register_block_pbg_badge();

