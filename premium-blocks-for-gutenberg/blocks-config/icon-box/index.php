<?php

/**
 * Server-side rendering of the `pbg/icon-box` block.
 *
 * @package WordPress
 */

/**
 * Get Icon Box Block CSS
 *
 * Return Frontend CSS for Icon Box.
 *
 * @access public
 *
 * @param string $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_icon_box_css_style($attr, $unique_id)
{
	$css = new Premium_Blocks_css();

  $variation_name = $css->pbg_get_value($attr, 'variation.name');
  
	// container style
  $css->set_selector('.' . $unique_id . " .premium-icon-box-content");
  $css->pbg_render_background($attr, 'containerBackground', 'Desktop');
  $css->pbg_render_value($attr, 'align', 'text-align', 'Desktop');
  $css->pbg_render_border($attr, 'containerBorder', 'Desktop');
  $css->pbg_render_spacing($attr, 'containerPadding', 'padding', 'Desktop');
  $css->pbg_render_spacing($attr, 'containerMargin', 'margin', 'Desktop');
  $css->pbg_render_shadow($attr, 'containerShadow', 'box-shadow');
  if($variation_name === 'horizontal'){
    $css->pbg_render_value($attr, 'verticalAlign', 'align-items', 'Desktop');
  }

  $css->set_selector('.' . $unique_id . ' .premium-icon-container');
  $css->pbg_render_value($attr, 'align', 'text-align', 'Desktop');
  
  $css->set_selector('.' . $unique_id . ' .premium-button-group_wrap');
  $css->pbg_render_align_self($attr, 'align', 'justify-content', 'Desktop');

  $css->set_selector('.' . $unique_id . " .premium-icon-box-content:hover");
  $css->pbg_render_background($attr, 'containerHoverBackground', 'Desktop');
  $css->pbg_render_border($attr, 'containerHoverBorder', 'Desktop', null, '!important');
  $css->pbg_render_shadow($attr, 'containerHoverShadow', 'box-shadow');

  $css->set_selector('.' . $unique_id . ' .is-style-var1-icon');
  $css->pbg_render_range($attr, 'iconRange', 'left', null, null, '% !important');

  $css->set_selector('.' . $unique_id . ' .is-style-horizontal1-icon');
  $css->pbg_render_range($attr, 'iconHorRange', 'top', null, null, '% !important');

	$css->start_media_query('tablet');

	// container style
	$css->set_selector('.' . $unique_id . " .premium-icon-box-content");
  $css->pbg_render_background($attr, 'containerBackground', 'Tablet');
  $css->pbg_render_value($attr, 'align', 'text-align', 'Tablet');
  $css->pbg_render_border($attr, 'containerBorder', 'Tablet');
  $css->pbg_render_spacing($attr, 'containerPadding', 'padding', 'Tablet');
  $css->pbg_render_spacing($attr, 'containerMargin', 'margin', 'Tablet');
  if($variation_name === 'horizontal'){
    $css->pbg_render_value($attr, 'verticalAlign', 'align-items', 'Tablet');
  }

  $css->set_selector('.' . $unique_id . ' .premium-icon-container');
  $css->pbg_render_value($attr, 'align', 'text-align', 'Tablet');

  $css->set_selector('.' . $unique_id . ' .premium-button-group_wrap');
  $css->pbg_render_align_self($attr, 'align', 'justify-content', 'Tablet');

  $css->set_selector('.' . $unique_id . " .premium-icon-box-content:hover");
  $css->pbg_render_background($attr, 'containerHoverBackground', 'Tablet');
  $css->pbg_render_border($attr, 'containerHoverBorder', 'Tablet');

	$css->stop_media_query();
	$css->start_media_query('mobile');

	// container style
	$css->set_selector('.' . $unique_id . " .premium-icon-box-content");
  $css->pbg_render_background($attr, 'containerBackground', 'Mobile');
  $css->pbg_render_value($attr, 'align', 'text-align', 'Mobile');
  $css->pbg_render_border($attr, 'containerBorder', 'Mobile');
  $css->pbg_render_spacing($attr, 'containerPadding', 'padding', 'Mobile');
  $css->pbg_render_spacing($attr, 'containerMargin', 'margin', 'Mobile');
  if($variation_name === 'horizontal'){
    $css->pbg_render_value($attr, 'verticalAlign', 'align-items', 'Mobile');
  }

  $css->set_selector('.' . $unique_id . ' .premium-icon-container');
  $css->pbg_render_value($attr, 'align', 'text-align', 'Mobile');

  $css->set_selector('.' . $unique_id . ' .premium-button-group_wrap');
  $css->pbg_render_align_self($attr, 'align', 'justify-content', 'Mobile');

  $css->set_selector('.' . $unique_id . " .premium-icon-box-content:hover");
  $css->pbg_render_background($attr, 'containerHoverBackground', 'Mobile');
  $css->pbg_render_border($attr, 'containerHoverBorder', 'Mobile');

	$css->stop_media_query();
	return $css->css_output();
}

/**
 * Renders the `premium/icon-box` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_icon_box($attributes, $content, $block)
{

	return $content;
}




/**
 * Register the icon_box block.
 *
 * @uses render_block_pbg_icon_box()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_icon_box()
{
	if (! function_exists('register_block_type')) {
		return;
	}
	register_block_type(
		PREMIUM_BLOCKS_PATH . '/blocks-config/icon-box',
		array(
			'render_callback' => 'render_block_pbg_icon_box',
		)
	);
}

register_block_pbg_icon_box();
