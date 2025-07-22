<?php
// Move this file to "blocks-config" folder with name "icon-group.php".

/**
 * Server-side rendering of the `premium/icon group` block.
 *
 * @package WordPress
 */

function get_premium_icon_group_css($attr, $unique_id)
{
	$block_helpers          = pbg_blocks_helper();
	$css                    = new Premium_Blocks_css();
	$media_query            = array();
	$media_query['mobile']  = apply_filters('Premium_BLocks_mobile_media_query', '(max-width: 767px)');
	$media_query['tablet']  = apply_filters('Premium_BLocks_tablet_media_query', '(max-width: 1024px)');
	$media_query['desktop'] = apply_filters('Premium_BLocks_tablet_media_query', '(min-width: 1025px)');

  $css->set_selector('.' . $unique_id);
  $css->pbg_render_value($attr, 'align', 'text-align', 'Desktop');
  $css->pbg_render_align_self($attr, 'align', 'align-self', 'Desktop');

  $css->set_selector('.' . $unique_id . '.wp-block-premium-icon-group .premium-icon-group-horizontal');
  $css->pbg_render_align_self($attr, 'align', 'justify-content', 'Desktop');

  $css->set_selector('.' . $unique_id . '.wp-block-premium-icon-group .premium-icon-group-vertical');
  $css->pbg_render_align_self($attr, 'align', 'align-items', 'Desktop');

  $css->set_selector('.' . $unique_id . ' .premium-icon-group-container');
  $css->pbg_render_range($attr, 'iconsGap', 'gap', 'Desktop');
  
  $css->set_selector(
    ".{$unique_id} .premium-icon-container .premium-icon-type svg, " .
    ".{$unique_id} .premium-icon-container .premium-lottie-animation svg, " .
    ".{$unique_id} .premium-icon-container .premium-icon-svg-class svg"
  );
  $css->pbg_render_range($attr, 'iconsSize', 'width', 'Desktop', null, '!important');
  $css->pbg_render_range($attr, 'iconsSize', 'height', 'Desktop', null, '!important');

  $css->set_selector('.' . $unique_id . ' .premium-icon-container img');
  $css->pbg_render_range($attr, 'iconsSize', 'width', 'Desktop', null, '!important');

  $css->set_selector(
    ".{$unique_id} .premium-icon-container .premium-icon-type, " .
    ".{$unique_id} .premium-icon-container img, " .
    ".{$unique_id} .premium-icon-container .premium-icon-svg-class svg, " .
    ".{$unique_id} .premium-icon-container .premium-lottie-animation svg"
  );
  $css->pbg_render_border($attr, 'groupIconBorder', 'Desktop');
  $css->pbg_render_spacing($attr, 'groupIconPadding', 'padding', "Desktop");
  $css->pbg_render_spacing($attr, 'groupIconMargin', 'margin', 'Desktop');

  $css->set_selector( 
    ".{$unique_id} .premium-icon-container .premium-icon-type, " .
    ".{$unique_id} .premium-icon-container .premium-icon-type:not(.icon-type-fe) svg, " .
    ".{$unique_id} .premium-icon-container .premium-icon-type:not(.icon-type-fe) svg *, " .
    ".{$unique_id} .premium-icon-container .premium-icon-svg-class svg, " .
    ".{$unique_id} .premium-icon-container .premium-icon-svg-class svg *"
  );
  $css->pbg_render_color($attr, 'groupIconColor', 'color');
  $css->pbg_render_color($attr, 'groupIconColor', 'fill');

  $css->set_selector(
    ".{$unique_id} .premium-icon-container .premium-icon-type, " .
    ".{$unique_id} .premium-icon-container .premium-icon-svg-class svg, " .
    ".{$unique_id} .premium-icon-container .premium-lottie-animation svg"
  );
  $css->pbg_render_color($attr, 'groupIconBack', 'background-color');

  $css->set_selector( 
    ".{$unique_id} .premium-icon-container .premium-icon-type:hover, " .
    ".{$unique_id} .premium-icon-container .premium-icon-type:not(.icon-type-fe):hover svg *, " .
    ".{$unique_id} .premium-icon-container .premium-icon-svg-class:hover svg, " .
    ".{$unique_id} .premium-icon-container .premium-icon-svg-class:hover svg *"
  );
  $css->pbg_render_color($attr, 'groupIconHoverColor', 'color');
  $css->pbg_render_color($attr, 'groupIconHoverColor', 'fill');

  $css->set_selector(
    ".{$unique_id} .premium-icon-container .premium-icon-type:hover, " .
    ".{$unique_id} .premium-icon-container .premium-icon-svg-class:hover svg, " .
    ".{$unique_id} .premium-icon-container .premium-lottie-animation:hover svg"
  );
  $css->pbg_render_color($attr, 'groupIconHoverBack', 'background-color');

	$css->start_media_query('tablet');

	// Tablet Styles.
	$css->set_selector('.' . $unique_id);
  $css->pbg_render_value($attr, 'align', 'text-align', 'Tablet');
  $css->pbg_render_align_self($attr, 'align', 'align-self', 'Tablet');

  $css->set_selector('.' . $unique_id . '.wp-block-premium-icon-group .premium-icon-group-horizontal');
  $css->pbg_render_align_self($attr, 'align', 'justify-content', 'Tablet');

  $css->set_selector('.' . $unique_id . '.wp-block-premium-icon-group .premium-icon-group-vertical');
  $css->pbg_render_align_self($attr, 'align', 'align-items', 'Tablet');

  $css->set_selector('.' . $unique_id . ' .premium-icon-group-container');
  $css->pbg_render_range($attr, 'iconsGap', 'gap', 'Tablet');
  
  $css->set_selector(
    ".{$unique_id} .premium-icon-container .premium-icon-type svg, " .
    ".{$unique_id} .premium-icon-container .premium-lottie-animation svg, " .
    ".{$unique_id} .premium-icon-container .premium-icon-svg-class svg"
  );
  $css->pbg_render_range($attr, 'iconsSize', 'width', 'Tablet', null, '!important');
  $css->pbg_render_range($attr, 'iconsSize', 'height', 'Tablet', null, '!important');

  $css->set_selector('.' . $unique_id . ' .premium-icon-container img');
  $css->pbg_render_range($attr, 'iconsSize', 'width', 'Tablet', null, '!important');

  $css->set_selector(
    ".{$unique_id} .premium-icon-container .premium-icon-type, " .
    ".{$unique_id} .premium-icon-container img, " .
    ".{$unique_id} .premium-icon-container .premium-icon-svg-class svg, " .
    ".{$unique_id} .premium-icon-container .premium-lottie-animation svg"
  );
  $css->pbg_render_border($attr, 'groupIconBorder', 'Tablet');
  $css->pbg_render_spacing($attr, 'groupIconPadding', 'padding', "Tablet");
  $css->pbg_render_spacing($attr, 'groupIconMargin', 'margin', 'Tablet');

	$css->stop_media_query();
	$css->start_media_query('mobile');

	// Mobile Styles.
	$css->set_selector('.' . $unique_id);
  $css->pbg_render_value($attr, 'align', 'text-align', 'Mobile');
  $css->pbg_render_align_self($attr, 'align', 'align-self', 'Mobile');

  $css->set_selector('.' . $unique_id . '.wp-block-premium-icon-group .premium-icon-group-horizontal');
  $css->pbg_render_align_self($attr, 'align', 'justify-content', 'Mobile');

  $css->set_selector('.' . $unique_id . '.wp-block-premium-icon-group .premium-icon-group-vertical');
  $css->pbg_render_align_self($attr, 'align', 'align-items', 'Mobile');

  $css->set_selector('.' . $unique_id . ' .premium-icon-group-container');
  $css->pbg_render_range($attr, 'iconsGap', 'gap', 'Mobile');
  
  $css->set_selector(
    ".{$unique_id} .premium-icon-container .premium-icon-type svg, " .
    ".{$unique_id} .premium-icon-container .premium-lottie-animation svg, " .
    ".{$unique_id} .premium-icon-container .premium-icon-svg-class svg"
  );
  $css->pbg_render_range($attr, 'iconsSize', 'width', 'Mobile', null, '!important');
  $css->pbg_render_range($attr, 'iconsSize', 'height', 'Mobile', null, '!important');

  $css->set_selector('.' . $unique_id . ' .premium-icon-container img');
  $css->pbg_render_range($attr, 'iconsSize', 'width', 'Mobile', null, '!important');

  $css->set_selector(
    ".{$unique_id} .premium-icon-container .premium-icon-type, " .
    ".{$unique_id} .premium-icon-container img, " .
    ".{$unique_id} .premium-icon-container .premium-icon-svg-class svg, " .
    ".{$unique_id} .premium-icon-container .premium-lottie-animation svg"
  );
  $css->pbg_render_border($attr, 'groupIconBorder', 'Mobile');
  $css->pbg_render_spacing($attr, 'groupIconPadding', 'padding', "Mobile");
  $css->pbg_render_spacing($attr, 'groupIconMargin', 'margin', 'Mobile');

	$css->stop_media_query();

	return $css->css_output();
}

/**
 * Renders the `premium/image` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_icon_group($attributes, $content, $block)
{

	return $content;
}


/**
 * Register the icon group block.
 *
 * @uses render_block_pbg_icon_group()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_icon_group()
{
	register_block_type(
		'premium/icon-group',
		array(
			'render_callback' => 'render_block_pbg_icon_group',
			'editor_style'    => 'premium-blocks-editor-css',
			'editor_script'   => 'pbg-blocks-js',
		)
	);
}

register_block_pbg_icon_group();
