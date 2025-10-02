<?php

/**
 * Server-side rendering of the `pbg/section` block.
 *
 * @package WordPress
 */

/**
 * Get Section Block CSS
 *
 * Return Frontend CSS for Section.
 *
 * @access public
 *
 * @param string $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_section_css_style( $attr, $unique_id ) {
	$css = new Premium_Blocks_css();

  $inner_width_type = $css->pbg_get_value($attr, 'innerWidthType');
  $inner_width_value = $css->pbg_get_value($attr, 'innerWidth');
  $min_height_type = $css->pbg_get_value($attr, 'height');
  $min_height_value = $css->pbg_get_value($attr, 'minHeight');
  $is_stretched_section = $css->pbg_get_value($attr, 'stretchSection');
  
  $css->set_selector( $unique_id );
  $css->pbg_render_spacing($attr, 'padding', 'padding', 'Desktop');
  $css->pbg_render_border($attr, 'border', 'Desktop');
  $css->pbg_render_value($attr, 'horAlign', 'text-align', 'Desktop');
  $css->pbg_render_background($attr, 'background', 'Desktop');
  $css->pbg_render_shadow($attr, 'boxShadow', 'box-shadow');
	
  $css->set_selector( "body .entry-content {$unique_id}:not(.alignfull)" );
  $css->pbg_render_spacing($attr, 'margin', 'margin', 'Desktop');  

  $css->set_selector( "body .entry-content {$unique_id}.alignfull" );
  $css->pbg_render_spacing($attr, 'margin', 'margin-top', 'Desktop', null, null, 'top');  
  $css->pbg_render_spacing($attr, 'margin', 'margin-bottom', 'Desktop', null, null, 'bottom');  

  $css->set_selector( $unique_id  . ' .premium-section__content_wrap');
  if($min_height_type === 'min'){
    // Handling backward compatibility for minHeight -- This can be removed after a few releases and keep the responsive line only
    if(is_array($min_height_value)){
      $css->pbg_render_range($attr, 'minHeight', 'min-height', 'Desktop');  
    }else{
      $css->pbg_render_range($attr, 'minHeight', 'min-height', null, null, $css->pbg_get_value($attr, 'minHeightUnit') ?? 'px');
    }
  }elseif($min_height_type === 'fit'){
    $css->add_property( 'min-height', '100vh');
  }
  if($is_stretched_section && $inner_width_type === 'boxed'){
    // Handling backward compatibility for innerWidth -- This can be removed after a few releases and keep the responsive line only
    if(is_array($inner_width_value)){
      $css->pbg_render_range($attr, 'innerWidth', 'max-width', 'Desktop');  
    }else{
      $css->pbg_render_range($attr, 'innerWidth', 'max-width', null, null, 'px');
    }
  }
  
  $css->set_selector( $unique_id  . ' .premium-section__content_wrap .premium-section__content_inner');
  $css->pbg_render_align_self($attr, 'horAlign', 'align-items', 'Desktop');

	$css->start_media_query( 'tablet' );

	$css->set_selector( $unique_id );
  $css->pbg_render_spacing($attr, 'padding', 'padding', 'Tablet');
  $css->pbg_render_border($attr, 'border', 'Tablet');
  $css->pbg_render_value($attr, 'horAlign', 'text-align', 'Tablet');
  $css->pbg_render_background($attr, 'background', 'Tablet');

	$css->set_selector( "body .entry-content {$unique_id}:not(.alignfull)" );
  $css->pbg_render_spacing($attr, 'margin', 'margin', 'Tablet');  

  $css->set_selector( "body .entry-content {$unique_id}.alignfull" );
  $css->pbg_render_spacing($attr, 'margin', 'margin-top', 'Tablet', null, null, 'top');  
  $css->pbg_render_spacing($attr, 'margin', 'margin-bottom', 'Tablet', null, null, 'bottom');  

  $css->set_selector( $unique_id  . ' .premium-section__content_wrap');
  if($min_height_type === 'min'){
    $css->pbg_render_range($attr, 'minHeight', 'min-height', 'Tablet');  
  }
  if($is_stretched_section && $inner_width_type === 'boxed'){
    $css->pbg_render_range($attr, 'innerWidth', 'max-width', 'Tablet');  
  }
  
  $css->set_selector( $unique_id  . ' .premium-section__content_wrap .premium-section__content_inner');
  $css->pbg_render_align_self($attr, 'horAlign', 'align-items', 'Tablet');

	$css->stop_media_query();
	$css->start_media_query( 'mobile' );

	$css->set_selector( $unique_id );
  $css->pbg_render_spacing($attr, 'padding', 'padding', 'Mobile');
  $css->pbg_render_border($attr, 'border', 'Mobile');
  $css->pbg_render_value($attr, 'horAlign', 'text-align', 'Mobile');
  $css->pbg_render_background($attr, 'background', 'Mobile');

	$css->set_selector( "body .entry-content {$unique_id}:not(.alignfull)" );
  $css->pbg_render_spacing($attr, 'margin', 'margin', 'Mobile');  

  $css->set_selector( "body .entry-content {$unique_id}.alignfull" );
  $css->pbg_render_spacing($attr, 'margin', 'margin-top', 'Mobile', null, null, 'top');  
  $css->pbg_render_spacing($attr, 'margin', 'margin-bottom', 'Mobile', null, null, 'bottom');  

  $css->set_selector( $unique_id  . ' .premium-section__content_wrap');
  if($min_height_type === 'min'){
    $css->pbg_render_range($attr, 'minHeight', 'min-height', 'Mobile');  
  }
  if($is_stretched_section && $inner_width_type === 'boxed'){
    $css->pbg_render_range($attr, 'innerWidth', 'max-width', 'Mobile');  
  }
  
  $css->set_selector( $unique_id  . ' .premium-section__content_wrap .premium-section__content_inner');
  $css->pbg_render_align_self($attr, 'horAlign', 'align-items', 'Mobile');
    
	$css->stop_media_query();

	return $css->css_output();
}

/**
 * Renders the `premium/section` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_section( $attributes, $content, $block ) {

	return $content;
}




/**
 * Register the section block.
 *
 * @uses render_block_pbg_section()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_section() {
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	register_block_type(
		PREMIUM_BLOCKS_PATH . '/blocks-config/section',
		array(
			'render_callback' => 'render_block_pbg_section',
		)
	);
}

register_block_pbg_section();
