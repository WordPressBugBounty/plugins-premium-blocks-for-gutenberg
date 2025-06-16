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
	//backgroundColor
	if ( isset( $attributes['backgroundColor']) && ! empty($attributes['backgroundColor'])  ) {
		$css->set_selector( ".{$unique_id}.premium-badge-circle .premium-badge-wrap, " . ".{$unique_id}.premium-badge-stripe .premium-badge-wrap, " . ".{$unique_id}.premium-badge-flag .premium-badge-wrap" );
		$css->add_property('background-color', $css->render_string($attributes['backgroundColor'], '!important'));
		$css->set_selector( ".{$unique_id}.premium-badge-flag.premium-badge-right .premium-badge-wrap:before" );
		$css->add_property('border-left-color', $css->render_string($attributes['backgroundColor'], '!important'));
		$css->set_selector( ".{$unique_id}.premium-badge-flag.premium-badge-left .premium-badge-wrap:before" );
		$css->add_property('border-right-color', $css->render_string($attributes['backgroundColor'], '!important'));
	}

	//shadow
	if (isset($attributes['boxShadow'])) {
		$css->set_selector( ".{$unique_id}.premium-badge-circle .premium-badge-wrap, " . ".{$unique_id}.premium-badge-stripe .premium-badge-wrap, " . ".{$unique_id}.premium-badge-flag .premium-badge-wrap" );
		$css->add_property('box-shadow', $css->render_shadow($attributes['boxShadow']));
	}
	
  $css->set_selector( ".{$unique_id} .premium-badge-wrap span" );
  $css->pbg_render_typography($attributes, 'typography', 'Desktop');
	
	//horizontal
	if ( isset( $attributes['hOffset'] ) ) {
		$css->set_selector( ".{$unique_id}.premium-badge-triangle .premium-badge-wrap span, " . ".{$unique_id}.premium-badge-circle" );

		if(isset($attributes['position'] ) && $attributes["position"] ==="left"){
			$css->add_property('left', $css->render_string($css->render_range($attributes['hOffset'], 'Desktop'),'!important'));
		}
		else {
			$css->add_property('right', $css->render_string($css->render_range($attributes['hOffset'], 'Desktop'),'!important'));
		}
	}
	//vertical
	if ( isset( $attributes['vOffset'] ) ) {
		$css->set_selector( ".{$unique_id}.premium-badge-triangle .premium-badge-wrap span, " . ".{$unique_id}.premium-badge-circle, " . ".{$unique_id}.premium-badge-flag" );
		$css->add_property('top', $css->render_string($css->render_range($attributes['vOffset'], 'Desktop'),'!important'));
	}

	if ( isset( $attributes['textWidth'] ) ) {
		$css->set_selector( ".{$unique_id}.premium-badge-triangle .premium-badge-wrap span" );
		$css->add_property( 'width', $css->get_responsive_css( $attributes['textWidth'] , 'Desktop' ) . 'px ' );
	}
	//triangle type
	if ( isset( $attributes['badgeSize'] ) ) {
		$css->set_selector( ".{$unique_id}.premium-badge-triangle .premium-badge-wrap" );
	
		if(isset($attributes['position'] ) && $attributes["position"] ==="left"){
			$css->add_property( 'border-top-width', $css->get_responsive_css( $attributes['badgeSize'] , 'Desktop' ) . 'px !important' );
		}else{
			$css->add_property( 'border-bottom-width', $css->get_responsive_css( $attributes['badgeSize'] , 'Desktop' ) . 'px !important ' );

		}
		$css->add_property( 'border-right-width', $css->get_responsive_css( $attributes['badgeSize'] , 'Desktop' ) . 'px !important' );
	}
	
	//circle type
	if ( isset( $attributes['badgeCircleSize'] ) ) {
		$css->set_selector( ".{$unique_id}.premium-badge-circle .premium-badge-wrap" );
		$css->add_property( 'min-width', $css->get_responsive_css( $attributes['badgeCircleSize'] , 'Desktop' ) . 'em !important' );
		$css->add_property( 'min-height', $css->get_responsive_css( $attributes['badgeCircleSize'] , 'Desktop' ) . 'em !important' );
		$css->add_property( 'line-height', $css->get_responsive_css( $attributes['badgeCircleSize'] , 'Desktop' ) . ' !important' );
	}

	$css->start_media_query( 'tablet' );
	// Tablet Styles.
	$css->set_selector( ".{$unique_id} .premium-badge-wrap span" );
  $css->pbg_render_typography($attributes, 'typography', 'Tablet');
	//horizontal
	if ( isset( $attributes['hOffset'] ) ) {
		$css->set_selector( ".{$unique_id}.premium-badge-triangle .premium-badge-wrap span, " . ".{$unique_id}.premium-badge-circle" );

		if(isset($attributes['position'] ) && $attributes["position"] ==="left"){
			$css->add_property('left', $css->render_string($css->render_range($attributes['hOffset'], 'Tablet'),'!important'));
		}
		else {
			$css->add_property('right', $css->render_string($css->render_range($attributes['hOffset'], 'Tablet'),'!important'));
		}
	}
	//vertical
	if ( isset( $attributes['vOffset'] ) ) {
		$css->set_selector( ".{$unique_id}.premium-badge-triangle .premium-badge-wrap span, " . ".{$unique_id}.premium-badge-circle, " . ".{$unique_id}.premium-badge-flag" );
		$css->add_property('top', $css->render_string($css->render_range($attributes['vOffset'], 'Tablet'),'!important'));
	}

	if ( isset( $attributes['textWidth'] ) ) {
		$css->set_selector( ".{$unique_id}.premium-badge-triangle .premium-badge-wrap span" );
		$css->add_property( 'width', $css->get_responsive_css( $attributes['textWidth'] , 'Tablet' ) . 'px ' );
	}
	//triangle type
	if ( isset( $attributes['badgeSize'] ) ) {
		$css->set_selector( ".{$unique_id}.premium-badge-triangle .premium-badge-wrap" );
	
		if(isset($attributes['position'] ) && $attributes["position"] ==="left"){
			$css->add_property( 'border-top-width', $css->get_responsive_css( $attributes['badgeSize'] , 'Tablet' ) . 'px !important' );
		}else{
			$css->add_property( 'border-bottom-width', $css->get_responsive_css( $attributes['badgeSize'] , 'Tablet' ) . 'px !important ' );

		}
		$css->add_property( 'border-right-width', $css->get_responsive_css( $attributes['badgeSize'] , 'Tablet' ) . 'px !important' );
	}
	
	//circle type
	if ( isset( $attributes['badgeCircleSize'] ) ) {
		$css->set_selector( ".{$unique_id}.premium-badge-circle .premium-badge-wrap" );
		$css->add_property( 'min-width', $css->get_responsive_css( $attributes['badgeCircleSize'] , 'Tablet' ) . 'em !important' );
		$css->add_property( 'min-height', $css->get_responsive_css( $attributes['badgeCircleSize'] , 'Tablet' ) . 'em !important' );
		$css->add_property( 'line-height', $css->get_responsive_css( $attributes['badgeCircleSize'] , 'Tablet' ) . ' !important' );
	}


	$css->stop_media_query();
	$css->start_media_query( 'mobile' );
	// Mobile Styles.
	$css->set_selector( ".{$unique_id} .premium-badge-wrap span" );
  $css->pbg_render_typography($attributes, 'typography', 'Mobile');
	//horizontal
	if ( isset( $attributes['hOffset'] ) ) {
		$css->set_selector( ".{$unique_id}.premium-badge-triangle .premium-badge-wrap span, " . ".{$unique_id}.premium-badge-circle" );

		if(isset($attributes['position'] ) && $attributes["position"] ==="left"){
			$css->add_property('left', $css->render_string($css->render_range($attributes['hOffset'], 'Mobile'),'!important'));
		}
		else {
			$css->add_property('right', $css->render_string($css->render_range($attributes['hOffset'], 'Mobile'),'!important'));
		}
	}
	//vertical
	if ( isset( $attributes['vOffset'] ) ) {
		$css->set_selector( ".{$unique_id}.premium-badge-triangle .premium-badge-wrap span, " . ".{$unique_id}.premium-badge-circle, " . ".{$unique_id}.premium-badge-flag" );
		$css->add_property('top', $css->render_string($css->render_range($attributes['vOffset'], 'Mobile'),'!important'));
	}

	if ( isset( $attributes['textWidth'] ) ) {
		$css->set_selector( ".{$unique_id}.premium-badge-triangle .premium-badge-wrap span" );
		$css->add_property( 'width', $css->get_responsive_css( $attributes['textWidth'] , 'Mobile' ) . 'px ' );

	}

	//triangle type
	if ( isset( $attributes['badgeSize'] ) ) {
		$css->set_selector( ".{$unique_id}.premium-badge-triangle .premium-badge-wrap" );
	
		if(isset($attributes['position'] ) && $attributes["position"] ==="left"){
			$css->add_property( 'border-top-width', $css->get_responsive_css( $attributes['badgeSize'] , 'Mobile' ) . 'px !important' );
		}else{
			$css->add_property( 'border-bottom-width', $css->get_responsive_css( $attributes['badgeSize'] , 'Mobile' ) . 'px !important ' );

		}
		$css->add_property( 'border-right-width', $css->get_responsive_css( $attributes['badgeSize'] , 'Mobile' ) . 'px !important' );
	}
	
	//circle type
	if ( isset( $attributes['badgeCircleSize'] ) ) {
		$css->set_selector( ".{$unique_id}.premium-badge-circle .premium-badge-wrap" );
		$css->add_property( 'min-width', $css->get_responsive_css( $attributes['badgeCircleSize'] , 'Mobile' ) . 'em !important' );
		$css->add_property( 'min-height', $css->get_responsive_css( $attributes['badgeCircleSize'] , 'Mobile' ) . 'em !important' );
		$css->add_property( 'line-height', $css->get_responsive_css( $attributes['badgeCircleSize'] , 'Mobile' ) . ' !important' );
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

