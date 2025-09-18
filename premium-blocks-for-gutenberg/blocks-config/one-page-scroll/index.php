<?php
/**
 * Server-side rendering of the `premium/one-page-scroll` block.
 *
 * @package WordPress
 */
/**
 * Get Dynamic CSS.
 *
 * @param array  $attr
 * @param string $unique_id
 * @return string
 */
function get_premium_one_page_scroll_css( $attr, $unique_id ) {
	$css = new Premium_Blocks_css();

	// Tooltip.
  $css->set_selector( ".{$unique_id} .pbg-one-page-scroll-dot__tooltip" );
  $css->pbg_render_typography($attr, 'tooltipTypography', 'Desktop');
  $css->pbg_render_border($attr, 'tooltipBorder', 'Desktop');
  $css->pbg_render_spacing($attr, 'tooltipPadding', 'padding', 'Desktop');
  $css->pbg_render_spacing($attr, 'tooltipMargin', 'margin', 'Desktop');
  $css->pbg_render_shadow($attr, 'tooltipShadow', 'box-shadow');
  $css->pbg_render_color($attr, 'tooltipColor', 'color');
  $css->pbg_render_color($attr, 'tooltipBackgroundColor', 'background-color');
  $css->pbg_render_color($attr, 'tooltipBackgroundColor', '--tooltip-arrow-color');

	// Dots.
  $css->set_selector(".{$unique_id} .pbg-one-page-scroll-dots .pbg-one-page-scroll-dots-list");
  $css->pbg_render_range($attr, 'dotsSpacing', 'gap', 'Desktop');
  
  $css->set_selector( ".{$unique_id} .pbg-one-page-scroll-dots" );
  $css->pbg_render_border($attr, 'navigationBorder', 'Desktop');
  $css->pbg_render_spacing($attr, 'navigationPadding', 'padding', 'Desktop');
  $css->pbg_render_spacing($attr, 'navigationMargin', 'margin', 'Desktop');
  $css->pbg_render_color($attr, 'navigationBackgroundColor', 'background-color');
  $css->pbg_render_shadow($attr, 'navigationBoxShadow', 'box-shadow');

  // Start of circles and lines styling
  $css->set_selector(".{$unique_id} .pbg-one-page-scroll-dots.circle .pbg-one-page-scroll-dots-list .pbg-one-page-scroll-dot");
  $css->pbg_render_range($attr, 'dotsSize', 'width', 'Desktop');
  $css->pbg_render_range($attr, 'dotsSize', 'height', 'Desktop');
  
  $css->set_selector(".{$unique_id} .pbg-one-page-scroll-dots.lines .pbg-one-page-scroll-dots-list .pbg-one-page-scroll-dot");
  $css->pbg_render_range($attr, 'linesWidth', 'width', 'Desktop');
  $css->pbg_render_range($attr, 'linesHeight', 'height', 'Desktop');

  $css->set_selector(".{$unique_id} .pbg-one-page-scroll-dots .pbg-one-page-scroll-dots-list .pbg-one-page-scroll-dot .pbg-one-page-scroll-dot__inner span");
  $css->pbg_render_color($attr, 'dotsColor', 'background-color');
  $css->pbg_render_border($attr, 'dotsBorder', 'Desktop');

  $css->set_selector(
    ".{$unique_id} .pbg-one-page-scroll-dots .pbg-one-page-scroll-dots-list .pbg-one-page-scroll-dot:hover .pbg-one-page-scroll-dot__inner span, " .
    ".{$unique_id} .pbg-one-page-scroll-dots .pbg-one-page-scroll-dots-list .pbg-one-page-scroll-dot.active .pbg-one-page-scroll-dot__inner span"
  );
  $css->pbg_render_color($attr, 'dotsActiveColor', 'background-color');
  $css->pbg_render_color($attr, 'dotsBorderActiveColor', 'border-color');
  // End of circles and lines styling

	// Menu.
  $css->set_selector( ".{$unique_id} .pbg-one-page-scroll-menu-list .pbg-one-page-scroll-menu-item" );
  $css->pbg_render_typography($attr, 'menuTypography', 'Desktop');
  $css->pbg_render_border($attr, 'menuBorder', 'Desktop');
  $css->pbg_render_spacing($attr, 'menuPadding', 'padding', 'Desktop');
  $css->pbg_render_spacing($attr, 'menuMargin', 'margin', 'Desktop');
  $css->pbg_render_color($attr, 'menuTextColor', 'color');
  $css->pbg_render_color($attr, 'menuBackgroundColor', 'background-color');
  $css->pbg_render_shadow($attr, 'menuBoxShadow', 'box-shadow');

  $css->set_selector( ".{$unique_id} .pbg-one-page-scroll-menu-list" );
  $css->pbg_render_range($attr, 'menuVerticalOffset', 'top', 'Desktop');
  $menu_position = $css->pbg_get_value($attr, 'menuPosition');
  if($menu_position === 'right') {
    $css->pbg_render_range($attr, 'menuHorizontalOffset', 'right', 'Desktop');
  }
  if($menu_position === 'left') {
    $css->pbg_render_range($attr, 'menuHorizontalOffset', 'left', 'Desktop');
  }

  $css->set_selector( ".{$unique_id} .pbg-one-page-scroll-menu-list .pbg-one-page-scroll-menu-item:not(.active):hover" );
  $css->pbg_render_color($attr, 'menuTextHoverColor', 'color');
  $css->pbg_render_color($attr, 'menuBackgroundHoverColor', 'background-color');
  $css->pbg_render_color($attr, 'menuBorderHoverColor', 'border-color');
  $css->pbg_render_shadow($attr, 'menuHoverBoxShadow', 'box-shadow');

  $css->set_selector( ".{$unique_id} .pbg-one-page-scroll-menu-list .pbg-one-page-scroll-menu-item.active" );
  $css->pbg_render_color($attr, 'menuTextActiveColor', 'color');
  $css->pbg_render_color($attr, 'menuBackgroundActiveColor', 'background-color');
  $css->pbg_render_color($attr, 'menuBorderActiveColor', 'border-color');
  $css->pbg_render_shadow($attr, 'menuActiveBoxShadow', 'box-shadow');

  //Arrows
  $arrows_position = $css->pbg_get_value($attr, 'arrowsPosition');
  if($arrows_position && $arrows_position !== "center") {
    $css->set_selector(".{$unique_id} .pbg-one-page-scroll-arrows span");
    if($arrows_position === 'left') {
      $css->pbg_render_range($attr, 'arrowsHorizontalOffset', 'left', 'Desktop');
    }else{
      $css->pbg_render_range($attr, 'arrowsHorizontalOffset', 'right', 'Desktop');
    }
  }

  $css->set_selector(".{$unique_id} .pbg-one-page-scroll-arrows .arrow-top");
  $css->pbg_render_range($attr, 'arrowsVerticalOffset', 'top', 'Desktop');

  $css->set_selector(".{$unique_id} .pbg-one-page-scroll-arrows .arrow-bottom");
  $css->pbg_render_range($attr, 'arrowsVerticalOffset', 'bottom', 'Desktop');
  
  $css->set_selector(".{$unique_id} .pbg-one-page-scroll-arrows span svg");
  $css->pbg_render_range($attr, 'arrowsSize', 'width', 'Desktop');
  $css->pbg_render_range($attr, 'arrowsSize', 'height', 'Desktop');
  $css->pbg_render_color($attr, 'arrowsColor', 'color'); 
  $css->pbg_render_color($attr, 'arrowsColor', 'fill'); 

  $css->set_selector( ".{$unique_id} .pbg-one-page-scroll-arrows span:hover svg" );
  $css->pbg_render_color($attr, 'arrowsHoverColor', 'color'); 
  $css->pbg_render_color($attr, 'arrowsHoverColor', 'fill'); 

	// Tablet.
	$css->start_media_query( 'tablet' );

	// Tooltip.
	$css->set_selector( ".{$unique_id} .pbg-one-page-scroll-dot__tooltip" );
  $css->pbg_render_typography($attr, 'tooltipTypography', 'Tablet');
  $css->pbg_render_border($attr, 'tooltipBorder', 'Tablet');
  $css->pbg_render_spacing($attr, 'tooltipPadding', 'padding', 'Tablet');
  $css->pbg_render_spacing($attr, 'tooltipMargin', 'margin', 'Tablet');

	// Dots.
  $css->set_selector(".{$unique_id} .pbg-one-page-scroll-dots .pbg-one-page-scroll-dots-list");
  $css->pbg_render_range($attr, 'dotsSpacing', 'gap', 'Tablet');
  
  $css->set_selector( ".{$unique_id} .pbg-one-page-scroll-dots" );
  $css->pbg_render_border($attr, 'navigationBorder', 'Tablet');
  $css->pbg_render_spacing($attr, 'navigationPadding', 'padding', 'Tablet');
  $css->pbg_render_spacing($attr, 'navigationMargin', 'margin', 'Tablet');

  // Start of circles and lines styling
  $css->set_selector(".{$unique_id} .pbg-one-page-scroll-dots.circle .pbg-one-page-scroll-dots-list .pbg-one-page-scroll-dot");
  $css->pbg_render_range($attr, 'dotsSize', 'width', 'Tablet');
  $css->pbg_render_range($attr, 'dotsSize', 'height', 'Tablet');
  
  $css->set_selector(".{$unique_id} .pbg-one-page-scroll-dots.lines .pbg-one-page-scroll-dots-list .pbg-one-page-scroll-dot");
  $css->pbg_render_range($attr, 'linesWidth', 'width', 'Tablet');
  $css->pbg_render_range($attr, 'linesHeight', 'height', 'Tablet');

  $css->set_selector(".{$unique_id} .pbg-one-page-scroll-dots .pbg-one-page-scroll-dots-list .pbg-one-page-scroll-dot .pbg-one-page-scroll-dot__inner span");
  $css->pbg_render_border($attr, 'dotsBorder', 'Tablet');
  // End of circles and lines styling

	// Menu.
	$css->set_selector( ".{$unique_id} .pbg-one-page-scroll-menu-list .pbg-one-page-scroll-menu-item" );
  $css->pbg_render_typography($attr, 'menuTypography', 'Tablet');
  $css->pbg_render_border($attr, 'menuBorder', 'Tablet');
  $css->pbg_render_spacing($attr, 'menuPadding', 'padding', 'Tablet');
  $css->pbg_render_spacing($attr, 'menuMargin', 'margin', 'Tablet');

	$css->set_selector( ".{$unique_id} .pbg-one-page-scroll-menu-list" );
  $css->pbg_render_range($attr, 'menuVerticalOffset', 'top', 'Tablet');
  $menu_position = $css->pbg_get_value($attr, 'menuPosition');
  if($menu_position === 'right') {
    $css->pbg_render_range($attr, 'menuHorizontalOffset', 'right', 'Tablet');
  }
  if($menu_position === 'left') {
    $css->pbg_render_range($attr, 'menuHorizontalOffset', 'left', 'Tablet');
  }

  //Arrows
  if($arrows_position && $arrows_position !== "center") {
    $css->set_selector(".{$unique_id} .pbg-one-page-scroll-arrows span");
    if($arrows_position === 'left') {
      $css->pbg_render_range($attr, 'arrowsHorizontalOffset', 'left', 'Tablet');
    }else{
      $css->pbg_render_range($attr, 'arrowsHorizontalOffset', 'right', 'Tablet');
    }
  }

  $css->set_selector(".{$unique_id} .pbg-one-page-scroll-arrows .arrow-top");
  $css->pbg_render_range($attr, 'arrowsVerticalOffset', 'top', 'Tablet');

  $css->set_selector(".{$unique_id} .pbg-one-page-scroll-arrows .arrow-bottom");
  $css->pbg_render_range($attr, 'arrowsVerticalOffset', 'bottom', 'Tablet');

  $css->set_selector(".{$unique_id} .pbg-one-page-scroll-arrows span svg");
  $css->pbg_render_range($attr, 'arrowsSize', 'width', 'Tablet');
  $css->pbg_render_range($attr, 'arrowsSize', 'height', 'Tablet');

	// Stop Tablet Query.
	$css->stop_media_query();

	// Mobile.
	$css->start_media_query( 'mobile' );

	// Tooltip.
	$css->set_selector( ".{$unique_id} .pbg-one-page-scroll-dot__tooltip" );
  $css->pbg_render_typography($attr, 'tooltipTypography', 'Mobile');
  $css->pbg_render_border($attr, 'tooltipBorder', 'Mobile');
  $css->pbg_render_spacing($attr, 'tooltipPadding', 'padding', 'Mobile');
  $css->pbg_render_spacing($attr, 'tooltipMargin', 'margin', 'Mobile');

	// Dots.
  $css->set_selector(".{$unique_id} .pbg-one-page-scroll-dots .pbg-one-page-scroll-dots-list");
  $css->pbg_render_range($attr, 'dotsSpacing', 'gap', 'Mobile');
  
  $css->set_selector( ".{$unique_id} .pbg-one-page-scroll-dots" );
  $css->pbg_render_border($attr, 'navigationBorder', 'Mobile');
  $css->pbg_render_spacing($attr, 'navigationPadding', 'padding', 'Mobile');
  $css->pbg_render_spacing($attr, 'navigationMargin', 'margin', 'Mobile');

  // Start of circles and lines styling
  $css->set_selector(".{$unique_id} .pbg-one-page-scroll-dots.circle .pbg-one-page-scroll-dots-list .pbg-one-page-scroll-dot");
  $css->pbg_render_range($attr, 'dotsSize', 'width', 'Mobile');
  $css->pbg_render_range($attr, 'dotsSize', 'height', 'Mobile');
  
  $css->set_selector(".{$unique_id} .pbg-one-page-scroll-dots.lines .pbg-one-page-scroll-dots-list .pbg-one-page-scroll-dot");
  $css->pbg_render_range($attr, 'linesWidth', 'width', 'Mobile');
  $css->pbg_render_range($attr, 'linesHeight', 'height', 'Mobile');

  $css->set_selector(".{$unique_id} .pbg-one-page-scroll-dots .pbg-one-page-scroll-dots-list .pbg-one-page-scroll-dot .pbg-one-page-scroll-dot__inner span");
  $css->pbg_render_border($attr, 'dotsBorder', 'Mobile');
  // End of circles and lines styling

	// Menu.
	$css->set_selector( ".{$unique_id} .pbg-one-page-scroll-menu-list .pbg-one-page-scroll-menu-item" );
  $css->pbg_render_typography($attr, 'menuTypography', 'Mobile');
  $css->pbg_render_border($attr, 'menuBorder', 'Mobile');
  $css->pbg_render_spacing($attr, 'menuPadding', 'padding', 'Mobile');
  $css->pbg_render_spacing($attr, 'menuMargin', 'margin', 'Mobile');

	$css->set_selector( ".{$unique_id} .pbg-one-page-scroll-menu-list" );
  $css->pbg_render_range($attr, 'menuVerticalOffset', 'top', 'Mobile');
  $menu_position = $css->pbg_get_value($attr, 'menuPosition');
  if($menu_position === 'right') {
    $css->pbg_render_range($attr, 'menuHorizontalOffset', 'right', 'Mobile');
  }
  if($menu_position === 'left') {
    $css->pbg_render_range($attr, 'menuHorizontalOffset', 'left', 'Mobile');
  }

  //Arrows
  if($arrows_position && $arrows_position !== "center") {
    $css->set_selector(".{$unique_id} .pbg-one-page-scroll-arrows span");
    if($arrows_position === 'left') {
      $css->pbg_render_range($attr, 'arrowsHorizontalOffset', 'left', 'Mobile');
    }else{
      $css->pbg_render_range($attr, 'arrowsHorizontalOffset', 'right', 'Mobile');
    }
  }

  $css->set_selector(".{$unique_id} .pbg-one-page-scroll-arrows .arrow-top");
  $css->pbg_render_range($attr, 'arrowsVerticalOffset', 'top', 'Mobile');

  $css->set_selector(".{$unique_id} .pbg-one-page-scroll-arrows .arrow-bottom");
  $css->pbg_render_range($attr, 'arrowsVerticalOffset', 'bottom', 'Mobile');

  $css->set_selector(".{$unique_id} .pbg-one-page-scroll-arrows span svg");
  $css->pbg_render_range($attr, 'arrowsSize', 'width', 'Mobile');
  $css->pbg_render_range($attr, 'arrowsSize', 'height', 'Mobile');

	// Stop Mobile Query.
	$css->stop_media_query();

	return $css->css_output();
}

 /**
  * Render one page scroll block.
  *
  * @param array  $attributes The block attributes.
  * @param string $content The block content.
  * @return string
  */
function render_block_pbg_one_page_scroll( $attributes, $content ) {
  wp_enqueue_script(
    'pbg-smoothscroll',
    PREMIUM_BLOCKS_URL . 'assets/js/lib/smoothscroll.min.js',
    array(),
    PREMIUM_BLOCKS_VERSION,
    true
  );

  wp_enqueue_script(
    'pbg-one-page-scroll',
    PREMIUM_BLOCKS_URL . 'assets/js/minified/one-page-scroll.min.js',
    array('pbg-smoothscroll'),
    PREMIUM_BLOCKS_VERSION,
    true
  );

	add_filter(
		'premium_one_page_scroll_localize_script',
		function ( $data ) use ( $attributes ) {
      $allowed_attributes = array( 
        'scrollSpeed', 
        'scrollOffset', 
        'scrollEffect', 
        'enableDotsTooltip',
        'showTooltipOnScroll',
        'navDots', 
        'fullSectionScroll', 
        'saveToBrowser',
        'enableFitToScreen'
      );
      
      $filtered_attributes = array_intersect_key( $attributes, array_flip($allowed_attributes));

      $data['blocks'][$attributes['blockId']] = array(
        'attributes' => $filtered_attributes,
      );
			return $data;
		}
	);

  $data = apply_filters('premium_one_page_scroll_localize_script', array());

  wp_scripts()->add_data('pbg-one-page-scroll', 'before', array());
    
  wp_add_inline_script(
    'pbg-one-page-scroll',
    'var PBG_OnePageScroll = ' . wp_json_encode($data) . ';',
    'before'
  );

  if(isset($attributes['navigationEntranceAnimation']) && $attributes['navigationEntranceAnimation'] !== "none"){
    if (!wp_style_is('pbg-entrance-animation-css', 'enqueued')) {
      wp_enqueue_style(
        'pbg-entrance-animation-css',
        PREMIUM_BLOCKS_URL . 'assets/js/build/entrance-animation/editor/index.css',
        array(),
        PREMIUM_BLOCKS_VERSION,
        'all'
      );
    }
  }

	return $content;
}

/**
 * Register the Instagram Feed block.
 *
 * @uses render_block_pbg_one_page_scroll()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_one_page_scroll() {
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	register_block_type(
		PREMIUM_BLOCKS_PATH . 'blocks-config/one-page-scroll',
		array(
			'render_callback' => 'render_block_pbg_one_page_scroll',
		)
	);
}

register_block_pbg_one_page_scroll();
