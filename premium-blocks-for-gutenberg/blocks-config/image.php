<?php
// Move this file to "blocks-config" folder with name "image.php".

/**
 * Server-side rendering of the `premium/image` block.
 *
 * @package WordPress
 */

function get_premium_image_css($attr, $unique_id)
{
	$css = new Premium_Blocks_css();

	// Desktop Styles.
  $mask_shape = $css->pbg_get_value($attr, 'maskShape');
  if($mask_shape && $mask_shape !== "none"){
    $image_path = PREMIUM_BLOCKS_URL . 'assets/icons/masks/' . $mask_shape . '.svg';
		if ($mask_shape === "custom") {
			$image_path = $css->pbg_get_value($attr, 'maskCustomShape.url') ?? '';
		}
		$css->set_selector('.' . $unique_id . ' > .premium-image-container' . ' > .premium-image-wrap');
		$css->add_property('mask-image', 'url(' . $image_path . ')');
		$css->add_property('-webkit-mask-image', 'url(' . $image_path . ')');
		$css->add_property('mask-size', $attr['maskSize'] ?? "contain");
		$css->add_property('-webkit-mask-size', $attr['maskSize'] ?? "contain");
		$css->add_property('mask-repeat', $attr['maskRepeat'] ?? 'no-repeat');
		$css->add_property('-webkit-mask-repeat', $attr['maskRepeat'] ?? 'no-repeat');
		$css->add_property('mask-position', $attr['maskPosition'] ?? "center center");
		$css->add_property('-webkit-mask-position', $attr['maskPosition'] ?? "center center");
  }
  $css->set_selector('.' . $unique_id . ' > .premium-image-container' . ' > .premium-image-wrap');
  $css->pbg_render_border($attr, 'imageBorder', 'Desktop');
  $css->pbg_render_shadow($attr, 'boxShadow', 'box-shadow');
  
  $css->set_selector('.' . $unique_id . ' > .premium-image-container' . ' .premium-image-overlay');
  $css->pbg_render_color($attr, 'overlayColor', 'background-color');

  $css->set_selector('.' . $unique_id . ' > .premium-image-container:hover' . ' .premium-image-overlay');
  $css->pbg_render_color($attr, 'overlayColorHover', 'background-color');

  $css->set_selector('.' . $unique_id . ' > .premium-image-container' . ' > .premium-image-wrap' . ' > img');
  $css->pbg_render_range($attr, 'imgWidth', 'width', 'Desktop');
  $css->pbg_render_range($attr, 'imgHeight', 'height', 'Desktop');
  $css->pbg_render_range($attr, 'imgOpacity', 'opacity', null, 'calc(', ' / 100)');
  $css->pbg_render_filters($attr, 'imageFilter');
  $css->pbg_render_value($attr, 'objectFit', 'object-fit');

  $css->set_selector('.' . $unique_id . ' > .premium-image-container' . ' > .premium-image-wrap:hover' . ' > img');
  $css->pbg_render_range($attr, 'imgOpacityHover', 'opacity', null, 'calc(', ' / 100)');

  $css->set_selector('.' . $unique_id . '.premium-image .premium-image-container');
  $css->pbg_render_value($attr, 'align', 'justify-content', 'Desktop');

  $css->set_selector('.' . $unique_id . ' .premium-image-caption');
  $css->pbg_render_typography($attr, 'captionTypography', 'Desktop');
  $css->pbg_render_value($attr, 'captionAlign', 'text-align', 'Desktop');
  $css->pbg_render_spacing($attr, 'captionPadding', 'padding', 'Desktop');
  $css->pbg_render_spacing($attr, 'captionMargin', 'margin', 'Desktop');
  $css->pbg_render_color($attr, 'captionColor', 'color');

  $css->set_selector( ":root:has(.{$unique_id}) .{$unique_id}.premium-image");
  $css->pbg_render_spacing($attr, 'padding', 'padding', 'Desktop', null, '!important');
  $css->pbg_render_spacing($attr, 'margin', 'margin', 'Desktop');

	$css->start_media_query('tablet');
	// // Tablet Styles.
	$css->set_selector('.' . $unique_id . ' > .premium-image-container' . ' > .premium-image-wrap');
  $css->pbg_render_border($attr, 'imageBorder', 'Tablet');

	$css->set_selector('.' . $unique_id . ' > .premium-image-container' . ' > .premium-image-wrap' . ' > img');
  $css->pbg_render_range($attr, 'imgWidth', 'width', 'Tablet');
  $css->pbg_render_range($attr, 'imgHeight', 'height', 'Tablet');

  $css->set_selector('.' . $unique_id . '.premium-image .premium-image-container');
  $css->pbg_render_value($attr, 'align', 'justify-content', 'Tablet');

	$css->set_selector('.' . $unique_id . ' .premium-image-caption');
  $css->pbg_render_typography($attr, 'captionTypography', 'Tablet');
  $css->pbg_render_value($attr, 'captionAlign', 'text-align', 'Tablet');
  $css->pbg_render_spacing($attr, 'captionPadding', 'padding', 'Tablet');
  $css->pbg_render_spacing($attr, 'captionMargin', 'margin', 'Tablet');

	$css->set_selector( ":root:has(.{$unique_id}) .{$unique_id}.premium-image");
  $css->pbg_render_spacing($attr, 'padding', 'padding', 'Tablet', null, '!important');
  $css->pbg_render_spacing($attr, 'margin', 'margin', 'Tablet');

	$css->stop_media_query();
	$css->start_media_query('mobile');
	// // Mobile Styles.
	$css->set_selector('.' . $unique_id . ' > .premium-image-container' . ' > .premium-image-wrap');
  $css->pbg_render_border($attr, 'imageBorder', 'Mobile');
	
  $css->set_selector('.' . $unique_id . ' > .premium-image-container' . ' > .premium-image-wrap' . ' > img');
  $css->pbg_render_range($attr, 'imgWidth', 'width', 'Mobile');
  $css->pbg_render_range($attr, 'imgHeight', 'height', 'Mobile');

  $css->set_selector('.' . $unique_id . '.premium-image .premium-image-container');
  $css->pbg_render_value($attr, 'align', 'justify-content', 'Mobile');

	$css->set_selector('.' . $unique_id . ' .premium-image-caption');
  $css->pbg_render_typography($attr, 'captionTypography', 'Mobile');
  $css->pbg_render_value($attr, 'captionAlign', 'text-align', 'Mobile');
  $css->pbg_render_spacing($attr, 'captionPadding', 'padding', 'Mobile');
  $css->pbg_render_spacing($attr, 'captionMargin', 'margin', 'Mobile');

	$css->set_selector( ":root:has(.{$unique_id}) .{$unique_id}.premium-image");
  $css->pbg_render_spacing($attr, 'padding', 'padding', 'Mobile', null, '!important');
  $css->pbg_render_spacing($attr, 'margin', 'margin', 'Mobile');

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
function render_block_pbg_image($attributes, $content, $block)
{

	/* 
    Handling new feature of WordPress 6.7.2 --> sizes='auto' for old versions that doesn't contain wp-image-{$id} class.
    This workaround can be omitted after a few subsequent releases around 25/3/2025
  */

	if (false === stripos($content, '<img')) {
		return $content;
	}

	if (empty($attributes['id'])) {
		return $content;
	}

	$image_id = $attributes['id'];
	$image_tag = new WP_HTML_Tag_Processor($content);

	// Find our specific image
	if (!$image_tag->next_tag(['tag_name' => 'img', 'class_name' => "pbg-image-{$image_id}"])) {
		return $content;
	}

	$image_classnames = $image_tag->get_attribute('class') ?? '';

	// Only process if wp-image class is missing
	if (!str_contains($image_classnames, "wp-image-{$image_id}")) {
		$image_metadata = wp_get_attachment_metadata($image_id);

		// Set dimensions if available
		if ($image_metadata && isset($image_metadata['width'], $image_metadata['height'])) {
			$image_tag->set_attribute('width', $image_metadata['width']);
			$image_tag->set_attribute('height', $image_metadata['height']);
		}

		// Clean up responsive attributes
		$image_tag->remove_attribute('srcset');
		$image_tag->remove_attribute('sizes');

		// Add the wp-image class for automatically generate new srcset and sizes attributes
		$image_tag->add_class("wp-image-{$image_id}");
	}

	return $image_tag->get_updated_html();
}


/**
 * Register the Price block.
 *
 * @uses render_block_pbg_image()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_image()
{
	register_block_type(
		'premium/image',
		array(
			'render_callback' => 'render_block_pbg_image',
			'editor_style'    => 'premium-blocks-editor-css',
			'editor_script'   => 'pbg-blocks-js',
		)
	);
}

register_block_pbg_image();
