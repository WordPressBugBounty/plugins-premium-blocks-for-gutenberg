<?php
/**
 * Server-side rendering of the `premium/badge` block.
 *
 * @package WordPress
 */

function get_premium_badge_css( $attributes, $unique_id ) {
	$css = new Premium_Blocks_css();

  $badge_position = $css->pbg_get_value($attributes, 'position');
	// Desktop Styles.
  
	//backgroundColor
  $css->set_selector( ".{$unique_id}.premium-badge-circle .premium-badge-wrap, " . ".{$unique_id}.premium-badge-stripe .premium-badge-wrap, " . ".{$unique_id}.premium-badge-flag .premium-badge-wrap" );
  $css->pbg_render_color($attributes, 'backgroundColor', 'background-color');
  $css->pbg_render_shadow($attributes, 'boxShadow', 'box-shadow');

  $css->set_selector( ".{$unique_id}.premium-badge-flag.premium-badge-right .premium-badge-wrap:before" );
  $css->pbg_render_color($attributes, 'backgroundColor', 'border-left-color');

  $css->set_selector( ".{$unique_id}.premium-badge-flag.premium-badge-left .premium-badge-wrap:before" );
  $css->pbg_render_color($attributes, 'backgroundColor', 'border-right-color');
	
  $css->set_selector( ".{$unique_id} .premium-badge-wrap span" );
  $css->pbg_render_typography($attributes, 'typography', 'Desktop');
	
	//horizontal
  $css->set_selector( 
    ".{$unique_id}.premium-badge-triangle .premium-badge-wrap span, " . 
    ".{$unique_id}.premium-badge-circle" );
  if($badge_position){
    if($badge_position === "left"){
      $css->pbg_render_range($attributes, 'hOffset', 'left', 'Desktop', null, '!important');
    }else{
      $css->pbg_render_range($attributes, 'hOffset', 'right', 'Desktop', null, '!important');
    }
  }
  
	//vertical
  $css->set_selector( 
    ".{$unique_id}.premium-badge-triangle .premium-badge-wrap span, " . 
    ".{$unique_id}.premium-badge-circle, " . 
    ".{$unique_id}.premium-badge-flag" 
  );
  $css->pbg_render_range($attributes, 'vOffset', 'top', 'Desktop', null, '!important');
    
  $css->set_selector( ".{$unique_id}.premium-badge-triangle .premium-badge-wrap span" );
  $css->pbg_render_range($attributes, 'textWidth', 'width', 'Desktop');
	
	//triangle type
  $css->set_selector( ".{$unique_id}.premium-badge-triangle .premium-badge-wrap" );
  $css->pbg_render_range($attributes, 'badgeSize', 'border-right-width', 'Desktop', null, '!important');
  if($badge_position){
    if($badge_position === "left"){
      $css->pbg_render_range($attributes, 'badgeSize', 'border-top-width', 'Desktop', null, '!important');
    }else{
      $css->pbg_render_range($attributes, 'badgeSize', 'border-bottom-width', 'Desktop', null, '!important');
    }
  }
  
	//circle type
  $css->set_selector( ".{$unique_id}.premium-badge-circle .premium-badge-wrap" );
  $css->pbg_render_range($attributes, 'badgeCircleSize', 'min-width', 'Desktop', null, '!important');
  $css->pbg_render_range($attributes, 'badgeCircleSize', 'min-height', 'Desktop', null, '!important');
  $css->pbg_render_range($attributes, 'badgeCircleSize', 'line-height', 'Desktop', null, '!important');

	$css->start_media_query( 'tablet' );

	// Tablet Styles.
	$css->set_selector( ".{$unique_id} .premium-badge-wrap span" );
  $css->pbg_render_typography($attributes, 'typography', 'Tablet');

	//horizontal
  $css->set_selector( 
    ".{$unique_id}.premium-badge-triangle .premium-badge-wrap span, " . 
    ".{$unique_id}.premium-badge-circle" );
  if($badge_position){
    if($badge_position === "left"){
      $css->pbg_render_range($attributes, 'hOffset', 'left', 'Tablet', null, '!important');
    }else{
      $css->pbg_render_range($attributes, 'hOffset', 'right', 'Tablet', null, '!important');
    }
  }
  
	//vertical
  $css->set_selector( 
    ".{$unique_id}.premium-badge-triangle .premium-badge-wrap span, " . 
    ".{$unique_id}.premium-badge-circle, " . 
    ".{$unique_id}.premium-badge-flag" 
  );
  $css->pbg_render_range($attributes, 'vOffset', 'top', 'Tablet', null, '!important');
    
  $css->set_selector( ".{$unique_id}.premium-badge-triangle .premium-badge-wrap span" );
  $css->pbg_render_range($attributes, 'textWidth', 'width', 'Tablet');
	
	//triangle type
  $css->set_selector( ".{$unique_id}.premium-badge-triangle .premium-badge-wrap" );
  $css->pbg_render_range($attributes, 'badgeSize', 'border-right-width', 'Tablet', null, '!important');
  if($badge_position){
    if($badge_position === "left"){
      $css->pbg_render_range($attributes, 'badgeSize', 'border-top-width', 'Tablet', null, '!important');
    }else{
      $css->pbg_render_range($attributes, 'badgeSize', 'border-bottom-width', 'Tablet', null, '!important');
    }
  }
  
	//circle type
  $css->set_selector( ".{$unique_id}.premium-badge-circle .premium-badge-wrap" );
  $css->pbg_render_range($attributes, 'badgeCircleSize', 'min-width', 'Tablet', null, '!important');
  $css->pbg_render_range($attributes, 'badgeCircleSize', 'min-height', 'Tablet', null, '!important');
  $css->pbg_render_range($attributes, 'badgeCircleSize', 'line-height', 'Tablet', null, '!important');

	$css->stop_media_query();
	$css->start_media_query( 'mobile' );

	// Mobile Styles.
	$css->set_selector( ".{$unique_id} .premium-badge-wrap span" );
  $css->pbg_render_typography($attributes, 'typography', 'Mobile');

	//horizontal
  $css->set_selector( 
    ".{$unique_id}.premium-badge-triangle .premium-badge-wrap span, " . 
    ".{$unique_id}.premium-badge-circle" );
  if($badge_position){
    if($badge_position === "left"){
      $css->pbg_render_range($attributes, 'hOffset', 'left', 'Mobile', null, '!important');
    }else{
      $css->pbg_render_range($attributes, 'hOffset', 'right', 'Mobile', null, '!important');
    }
  }
  
	//vertical
  $css->set_selector( 
    ".{$unique_id}.premium-badge-triangle .premium-badge-wrap span, " . 
    ".{$unique_id}.premium-badge-circle, " . 
    ".{$unique_id}.premium-badge-flag" 
  );
  $css->pbg_render_range($attributes, 'vOffset', 'top', 'Mobile', null, '!important');
    
  $css->set_selector( ".{$unique_id}.premium-badge-triangle .premium-badge-wrap span" );
  $css->pbg_render_range($attributes, 'textWidth', 'width', 'Mobile');
	
	//triangle type
  $css->set_selector( ".{$unique_id}.premium-badge-triangle .premium-badge-wrap" );
  $css->pbg_render_range($attributes, 'badgeSize', 'border-right-width', 'Mobile', null, '!important');
  if($badge_position){
    if($badge_position === "left"){
      $css->pbg_render_range($attributes, 'badgeSize', 'border-top-width', 'Mobile', null, '!important');
    }else{
      $css->pbg_render_range($attributes, 'badgeSize', 'border-bottom-width', 'Mobile', null, '!important');
    }
  }
  
	//circle type
  $css->set_selector( ".{$unique_id}.premium-badge-circle .premium-badge-wrap" );
  $css->pbg_render_range($attributes, 'badgeCircleSize', 'min-width', 'Mobile', null, '!important');
  $css->pbg_render_range($attributes, 'badgeCircleSize', 'min-height', 'Mobile', null, '!important');
  $css->pbg_render_range($attributes, 'badgeCircleSize', 'line-height', 'Mobile', null, '!important');

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

