<?php

/**
 * Server-side rendering of the `pbg/svg-draw` block.
 *
 * @package WordPress
 */

/**
 * Get SVG Draw Block CSS
 *
 * Return Frontend CSS for SVG Draw.
 *
 * @access public
 *
 * @param array  $attributes Block attributes.
 * @param string $unique_id  Block ID.
 *
 * @return string Generated CSS.
 */
function get_premium_svg_draw_css_style( $attr, $unique_id ) {
	$css = new Premium_Blocks_css();

	// Desktop Styles.

	// Container Styles
  $css->set_selector('.' . $unique_id . ' .premium-icon-container');
  $css->pbg_render_background($attr, 'containerBackground', 'Desktop');
  $css->pbg_render_border($attr, 'containerBorder', 'Desktop');
  $css->pbg_render_spacing($attr, 'wrapPadding', 'padding', 'Desktop');
  $css->pbg_render_spacing($attr, 'wrapMargin', 'margin', 'Desktop');
  $css->pbg_render_value($attr, 'iconAlign', 'text-align', 'Desktop');
  $css->pbg_render_shadow($attr, 'containerShadow', 'box-shadow');

	// icon Styles
  $css->set_selector(
    ".{$unique_id} > .premium-icon-container .premium-icon-content .premium-icon-type svg, " .
    ".{$unique_id} > .premium-icon-container .premium-icon-content .premium-icon-svg-class svg"
  );
  $css->pbg_render_range($attr, 'iconSize', 'width', 'Desktop', null, '!important');
  $css->pbg_render_range($attr, 'iconSize', 'height', 'Desktop', null, '!important');

	// common icon type style
  $css->set_selector(
    ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-type, " .
    ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-svg-class svg" 
  );
  $css->pbg_render_border($attr, 'iconBorder', 'Desktop');
  $css->pbg_render_spacing($attr, 'iconPadding', 'padding', "Desktop");
  $css->pbg_render_spacing($attr, 'iconMargin', 'margin', 'Desktop');

	// svg styles
  $css->set_selector( 
    ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-type, " .
    ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-type:not(.icon-type-fe) svg, " .
    ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-type:not(.icon-type-fe) svg *, " .
    ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-svg-class svg, " .
    ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-svg-class svg *"
  );
  $css->pbg_render_color($attr, 'iconColor', 'color');
  $css->pbg_render_color($attr, 'iconColor', 'fill');

  $css->set_selector(
    ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-type, " .
    ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-svg-class svg"
  );
  $css->pbg_render_background($attr, 'iconBG', 'Desktop');

  $css->set_selector( 
    ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-type:hover, " .
    ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-type:not(.icon-type-fe):hover svg *, " .
    ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-svg-class:hover svg, " .
    ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-svg-class:hover svg *"
  );
  $css->pbg_render_color($attr, 'iconHoverColor', 'color');
  $css->pbg_render_color($attr, 'iconHoverColor', 'fill');

  $css->set_selector(
    ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-type:hover, " .
    ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-svg-class:hover svg"
  );
  $css->pbg_render_color($attr, 'borderHoverColor', 'border-color');
  $css->pbg_render_background($attr, 'iconHoverBG', 'Desktop');

  $css->set_selector(".{$unique_id} svg *");
  $css->pbg_render_color($attr, 'svgDraw.strokeColor', 'stroke');
  $css->pbg_render_range($attr, 'svgDraw.strokeWidth', 'stroke-width', 'Desktop');

	$css->start_media_query('tablet');

	// Container Styles
	$css->set_selector('.' . $unique_id . ' .premium-icon-container');
  $css->pbg_render_background($attr, 'containerBackground', 'Tablet');
  $css->pbg_render_border($attr, 'containerBorder', 'Tablet');
  $css->pbg_render_spacing($attr, 'wrapPadding', 'padding', 'Tablet');
  $css->pbg_render_spacing($attr, 'wrapMargin', 'margin', 'Tablet');
  $css->pbg_render_value($attr, 'iconAlign', 'text-align', 'Tablet');

	// icon Styles
  $css->set_selector(
    ".{$unique_id} > .premium-icon-container .premium-icon-content .premium-icon-type svg, " .
    ".{$unique_id} > .premium-icon-container .premium-icon-content .premium-icon-svg-class svg"
  );
  $css->pbg_render_range($attr, 'iconSize', 'width', 'Tablet', null, '!important');
  $css->pbg_render_range($attr, 'iconSize', 'height', 'Tablet', null, '!important');

	// common icon type style
  $css->set_selector(
    ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-type, " .
    ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-svg-class svg"
  );
  $css->pbg_render_border($attr, 'iconBorder', 'Tablet');
  $css->pbg_render_spacing($attr, 'iconPadding', 'padding', "Tablet");
  $css->pbg_render_spacing($attr, 'iconMargin', 'margin', 'Tablet');

	$css->set_selector(
    ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-type, " .
    ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-svg-class svg"
  );
  $css->pbg_render_background($attr, 'iconBG', 'Tablet');

	$css->set_selector(
    ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-type:hover, " .
    ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-svg-class:hover svg"
  );
  $css->pbg_render_background($attr, 'iconHoverBG', 'Tablet');

  $css->set_selector(".{$unique_id} svg *");
  $css->pbg_render_range($attr, 'svgDraw.strokeWidth', 'stroke-width', 'Tablet');

	$css->stop_media_query();
	$css->start_media_query('mobile');

	// Container Styles
  $css->set_selector('.' . $unique_id . ' .premium-icon-container');
  $css->pbg_render_background($attr, 'containerBackground', 'Mobile');
  $css->pbg_render_border($attr, 'containerBorder', 'Mobile');
  $css->pbg_render_spacing($attr, 'wrapPadding', 'padding', 'Mobile');
  $css->pbg_render_spacing($attr, 'wrapMargin', 'margin', 'Mobile');
  $css->pbg_render_value($attr, 'iconAlign', 'text-align', 'Mobile');

	// icon Styles
  $css->set_selector(
    ".{$unique_id} > .premium-icon-container .premium-icon-content .premium-icon-type svg, " .
    ".{$unique_id} > .premium-icon-container .premium-icon-content .premium-icon-svg-class svg"
  );
  $css->pbg_render_range($attr, 'iconSize', 'width', 'Mobile', null, '!important');
  $css->pbg_render_range($attr, 'iconSize', 'height', 'Mobile', null, '!important');

	// common icon type style
  $css->set_selector(
    ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-type, " .
    ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-svg-class svg"
  );
  $css->pbg_render_border($attr, 'iconBorder', 'Mobile');
  $css->pbg_render_spacing($attr, 'iconPadding', 'padding', "Mobile");
  $css->pbg_render_spacing($attr, 'iconMargin', 'margin', 'Mobile');

	$css->set_selector(
    ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-type, " .
    ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-svg-class svg" 
  );
  $css->pbg_render_background($attr, 'iconBG', 'Mobile');

	$css->set_selector(
    ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-type:hover, " .
    ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-svg-class:hover svg"
  );
  $css->pbg_render_background($attr, 'iconHoverBG', 'Mobile');

  $css->set_selector(".{$unique_id} svg *");
  $css->pbg_render_range($attr, 'svgDraw.strokeWidth', 'stroke-width', 'Mobile');

	$css->stop_media_query();
	return $css->css_output();
}

/**
 * Renders the `premium/svg-draw` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_svg_draw($attributes, $content, $block)
{
	$block_helpers = pbg_blocks_helper();

	wp_register_script(
    'pbg-gsap-frontend-script',
    PREMIUM_BLOCKS_URL . 'assets/js/lib/gsap.min.js',
    array(),
    PREMIUM_BLOCKS_VERSION,
    true
  );

  wp_register_script(
    'pbg-scroll-trigger-frontend-script',
    PREMIUM_BLOCKS_URL . 'assets/js/lib/ScrollTrigger.min.js',
    array('pbg-gsap-frontend-script'),
    PREMIUM_BLOCKS_VERSION,
    true
  );

  wp_enqueue_script(
    'premium-svg-draw-view',
    PREMIUM_BLOCKS_URL . 'assets/js/build/svg-draw/index.js',
    array('pbg-gsap-frontend-script', 'pbg-scroll-trigger-frontend-script'),
    PREMIUM_BLOCKS_VERSION,
    true
  );

  // Add this block's settings to the accordion data.
  add_filter(
    'premium-svg-draw-localize-data',
    function ( $data ) use ( $attributes ) {
      $data[ $attributes['blockId'] ] = $attributes['svgDraw'] ?? array();
      return $data;
    }
  );

  $data = apply_filters( 'premium-svg-draw-localize-data', array());

  wp_scripts()->add_data('premium-svg-draw-view', 'before', array());

  wp_add_inline_script(
    'premium-svg-draw-view',
    'PBG_SvgDraw = ' . wp_json_encode($data) . ';',
    'before'
  );

	return $content;
}




/**
 * Register the svg draw block.
 *
 * @uses render_block_pbg_svg_draw()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_svg_draw()
{
	if (! function_exists('register_block_type')) {
		return;
	}
	register_block_type(
		PREMIUM_BLOCKS_PATH . '/blocks-config/svg-draw',
		array(
			'render_callback' => 'render_block_pbg_svg_draw',
		)
	);
}

register_block_pbg_svg_draw();
