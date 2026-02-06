<?php

/**
 * Server-side rendering of the `pbg/image-separator` block.
 *
 * @package WordPress
 */

/**
 * Get Image Separator Block CSS
 *
 * Return Frontend CSS for Image Separator.
 *
 * @access public
 *
 * @param string $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_image_separator_css_style($attr, $unique_id)
{
	$css = new Premium_Blocks_css();
  
  $icon_type_select = $css->pbg_get_value($attr, 'iconTypeSelect');
  $advanced_border = $css->pbg_get_value($attr, 'iconStyles[0].advancedBorder');

  // Container
  $css->set_selector(".{$unique_id}");
  $css->pbg_render_value($attr, 'iconAlign', 'text-align', 'Desktop');

  $css->set_selector(".{$unique_id} > .premium-image-separator-container");
  $css->pbg_render_value($attr, 'iconAlign', 'text-align', 'Desktop');
  $css->pbg_render_range($attr, 'gutter', 'transform', '', 'translateY(', '%)');
  if($icon_type_select === 'img'){
    $css->pbg_render_filters($attr, 'imgFilter');
  }

  if($icon_type_select === 'img'){
    $css->set_selector(".{$unique_id} > .premium-image-separator-container:hover");
    $css->pbg_render_filters($attr, 'imgFilterHover');
  }

	// icon Styles
  $css->set_selector(
    ".{$unique_id} > .premium-image-separator-container .premium-image-separator-icon svg, " .
    ".{$unique_id} > .premium-image-separator-container .premium-image-separator-svg-class svg"
  );
  $css->pbg_render_range($attr, 'imgWidth', 'width', 'Desktop', null, '!important');
  $css->pbg_render_range($attr, 'imgWidth', 'height', 'Desktop', null, '!important');

	// common icon type style
  $css->set_selector(
    ".{$unique_id} .premium-image-separator-container .premium-image-separator-icon, " .
    ".{$unique_id} .premium-image-separator-container img, " .
    ".{$unique_id} .premium-image-separator-container .premium-image-separator-svg-class svg, " .
    ".{$unique_id} .premium-image-separator-container .premium-lottie-animation svg"
  );
  $css->pbg_render_border($attr, 'iconBorder', 'Desktop');
  $css->pbg_render_spacing($attr, 'iconPadding', 'padding', "Desktop");
  $css->pbg_render_spacing($attr, 'iconMargin', 'margin', 'Desktop');
  if ( $advanced_border ) {
    $css->pbg_render_value( $attr, 'iconStyles[0].advancedBorderValue', 'border-radius', '', '', '!important' );
  }

	// image style
  $css->set_selector('.' . $unique_id . ' .premium-image-separator-container img');
  $css->pbg_render_range($attr, 'imgWidth', 'width', 'Desktop', null, '!important');
  $css->pbg_render_range($attr, 'imgHeight', 'height', 'Desktop', null, '!important');
  $css->pbg_render_value($attr, 'maskSize', 'mask-size');
  $css->pbg_render_value($attr, 'maskSize', '-webkit-mask-size');
  $css->pbg_render_value($attr, 'maskPosition', 'mask-position');
  $css->pbg_render_value($attr, 'maskPosition', '-webkit-mask-position');
  $css->pbg_render_value($attr, 'imgMaskURL', 'mask-image', '', 'url("', '")');
  $css->pbg_render_value($attr, 'imgMaskURL', '-webkit-mask-image', '', 'url("', '")');
  $css->pbg_render_value($attr, 'imgFit', 'object-fit');

  $css->set_selector('.' . $unique_id . ' .premium-image-separator-container .premium-lottie-animation svg');
  $css->pbg_render_range($attr, 'imgWidth', 'width', 'Desktop', null, '!important');
  $css->pbg_render_range($attr, 'imgWidth', 'height', 'Desktop', null, '!important');

	// svg styles
  $css->set_selector( 
    ".{$unique_id} .premium-image-separator-container .premium-image-separator-icon, " .
    ".{$unique_id} .premium-image-separator-container .premium-image-separator-icon:not(.icon-type-fe) svg, " .
    ".{$unique_id} .premium-image-separator-container .premium-image-separator-icon:not(.icon-type-fe) svg *, " .
    ".{$unique_id} .premium-image-separator-container .premium-image-separator-svg-class svg, " .
    ".{$unique_id} .premium-image-separator-container .premium-image-separator-svg-class svg *"
  );
  $css->pbg_render_color($attr, 'iconColor', 'color');
  $css->pbg_render_color($attr, 'iconColor', 'fill');

  $css->set_selector(
    ".{$unique_id} .premium-image-separator-container .premium-image-separator-icon, " .
    ".{$unique_id} .premium-image-separator-container .premium-image-separator-svg-class svg, " .
    ".{$unique_id} .premium-image-separator-container .premium-lottie-animation svg"
  );
  $css->pbg_render_background($attr, 'iconBG', 'Desktop');

  $css->set_selector( 
    ".{$unique_id} .premium-image-separator-container .premium-image-separator-icon:hover, " .
    ".{$unique_id} .premium-image-separator-container .premium-image-separator-icon:not(.icon-type-fe):hover svg *, " .
    ".{$unique_id} .premium-image-separator-container .premium-image-separator-svg-class:hover svg, " .
    ".{$unique_id} .premium-image-separator-container .premium-image-separator-svg-class:hover svg *"
  );
  $css->pbg_render_color($attr, 'iconHoverColor', 'color');
  $css->pbg_render_color($attr, 'iconHoverColor', 'fill');

  $css->set_selector(
    ".{$unique_id} .premium-image-separator-container .premium-image-separator-icon:hover, " .
    ".{$unique_id} .premium-image-separator-container .premium-image-separator-svg-class:hover svg, " .
    ".{$unique_id} .premium-image-separator-container .premium-lottie-animation:hover svg"
  );
  $css->pbg_render_color($attr, 'borderHoverColor', 'border-color');
  $css->pbg_render_background($attr, 'iconHoverBG', 'Desktop');

	$css->start_media_query('tablet');

  // Container
  $css->set_selector(".{$unique_id}");
  $css->pbg_render_value($attr, 'iconAlign', 'text-align', 'Tablet');

  $css->set_selector(".{$unique_id} > .premium-image-separator-container");
  $css->pbg_render_value($attr, 'iconAlign', 'text-align', 'Tablet');

	// icon Styles
  $css->set_selector(
    ".{$unique_id} > .premium-image-separator-container .premium-image-separator-icon svg, " .
    ".{$unique_id} > .premium-image-separator-container .premium-image-separator-svg-class svg"
  );
  $css->pbg_render_range($attr, 'imgWidth', 'width', 'Tablet', null, '!important');
  $css->pbg_render_range($attr, 'imgWidth', 'height', 'Tablet', null, '!important');

	// common icon type style
  $css->set_selector(
    ".{$unique_id} .premium-image-separator-container .premium-image-separator-icon, " .
    ".{$unique_id} .premium-image-separator-container img, " .
    ".{$unique_id} .premium-image-separator-container .premium-image-separator-svg-class svg, " .
    ".{$unique_id} .premium-image-separator-container .premium-lottie-animation svg"
  );
  $css->pbg_render_border($attr, 'iconBorder', 'Tablet');
  $css->pbg_render_spacing($attr, 'iconPadding', 'padding', "Tablet");
  $css->pbg_render_spacing($attr, 'iconMargin', 'margin', 'Tablet');

	// image style
	$css->set_selector('.' . $unique_id . ' .premium-image-separator-container img');
  $css->pbg_render_range($attr, 'imgWidth', 'width', 'Tablet', null, '!important');
  $css->pbg_render_range($attr, 'imgHeight', 'height', 'Tablet', null, '!important');

  $css->set_selector('.' . $unique_id . ' .premium-image-separator-container .premium-lottie-animation svg');
  $css->pbg_render_range($attr, 'imgWidth', 'width', 'Tablet', null, '!important');
  $css->pbg_render_range($attr, 'imgWidth', 'height', 'Tablet', null, '!important');

	$css->set_selector(
    ".{$unique_id} .premium-image-separator-container .premium-image-separator-icon, " .
    ".{$unique_id} .premium-image-separator-container .premium-image-separator-svg-class svg, " .
    ".{$unique_id} .premium-image-separator-container .premium-lottie-animation svg"
  );
  $css->pbg_render_background($attr, 'iconBG', 'Tablet');

	$css->set_selector(
    ".{$unique_id} .premium-image-separator-container .premium-image-separator-icon:hover, " .
    ".{$unique_id} .premium-image-separator-container .premium-image-separator-svg-class:hover svg, " .
    ".{$unique_id} .premium-image-separator-container .premium-lottie-animation:hover svg"
  );
  $css->pbg_render_background($attr, 'iconHoverBG', 'Tablet');

	$css->stop_media_query();
	$css->start_media_query('mobile');

  // Container
  $css->set_selector(".{$unique_id}");
  $css->pbg_render_value($attr, 'iconAlign', 'text-align', 'Mobile');

  $css->set_selector(".{$unique_id} > .premium-image-separator-container");
  $css->pbg_render_value($attr, 'iconAlign', 'text-align', 'Mobile');

	// icon Styles
  $css->set_selector(
    ".{$unique_id} > .premium-image-separator-container .premium-image-separator-icon svg, " .
    ".{$unique_id} > .premium-image-separator-container .premium-image-separator-svg-class svg"
  );
  $css->pbg_render_range($attr, 'imgWidth', 'width', 'Mobile', null, '!important');
  $css->pbg_render_range($attr, 'imgWidth', 'height', 'Mobile', null, '!important');

	// common icon type style
  $css->set_selector(
    ".{$unique_id} .premium-image-separator-container .premium-image-separator-icon, " .
    ".{$unique_id} .premium-image-separator-container img, " .
    ".{$unique_id} .premium-image-separator-container .premium-image-separator-svg-class svg, " .
    ".{$unique_id} .premium-image-separator-container .premium-lottie-animation svg"
  );
  $css->pbg_render_border($attr, 'iconBorder', 'Mobile');
  $css->pbg_render_spacing($attr, 'iconPadding', 'padding', "Mobile");
  $css->pbg_render_spacing($attr, 'iconMargin', 'margin', 'Mobile');

	// image style
	$css->set_selector('.' . $unique_id . ' .premium-image-separator-container img');
  $css->pbg_render_range($attr, 'imgWidth', 'width', 'Mobile', null, '!important');
  $css->pbg_render_range($attr, 'imgHeight', 'height', 'Mobile', null, '!important');

  $css->set_selector('.' . $unique_id . ' .premium-image-separator-container .premium-lottie-animation svg');
  $css->pbg_render_range($attr, 'imgWidth', 'width', 'Mobile', null, '!important');
  $css->pbg_render_range($attr, 'imgWidth', 'height', 'Mobile', null, '!important');

	$css->set_selector(
    ".{$unique_id} .premium-image-separator-container .premium-image-separator-icon, " .
    ".{$unique_id} .premium-image-separator-container .premium-image-separator-svg-class svg, " .
    ".{$unique_id} .premium-image-separator-container .premium-lottie-animation svg"
  );
  $css->pbg_render_background($attr, 'iconBG', 'Mobile');

	$css->set_selector(
    ".{$unique_id} .premium-image-separator-container .premium-image-separator-icon:hover, " .
    ".{$unique_id} .premium-image-separator-container .premium-image-separator-svg-class:hover svg, " .
    ".{$unique_id} .premium-image-separator-container .premium-lottie-animation:hover svg"
  );
  $css->pbg_render_background($attr, 'iconHoverBG', 'Mobile');

	$css->stop_media_query();
	return $css->css_output();
}

/**
 * Renders the `premium/image-separator` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_image_separator($attributes, $content, $block)
{
	$block_helpers = pbg_blocks_helper();

	if ($block_helpers->it_is_not_amp()) {
		if (isset($attributes['iconTypeSelect']) && $attributes['iconTypeSelect'] == 'lottie') {
			wp_enqueue_script(
				'pbg-lottie',
				PREMIUM_BLOCKS_URL . 'assets/js/lib/lottie.min.js',
				array('jquery'),
				PREMIUM_BLOCKS_VERSION,
				true
			);
		}
	}

	/* 
    Handling new feature of WordPress 6.7.2 --> sizes='auto' for old versions that doesn't contain wp-image-{$id} class.
    This workaround can be omitted after a few subsequent releases around 25/3/2025
  */
	if (isset($attributes['iconTypeSelect']) && $attributes['iconTypeSelect'] == 'img') {
		if (empty($attributes['imageURL']) || false === stripos($content, '<img')) {
			return $content;
		}

		$image_id = attachment_url_to_postid($attributes['imageURL']);

		if (!$image_id) {
			return $content;
		}

		$image_tag = new WP_HTML_Tag_Processor($content);

		// Find our specific image
		if (!$image_tag->next_tag(['tag_name' => 'img'])) {
			return $content;
		}

		$image_classnames = $image_tag->get_attribute('class') ?? '';

		// Only process if wp-image class is missing
		if (!str_contains($image_classnames, "wp-image-{$image_id}")) {
			// Clean up 
			$image_tag->remove_attribute('srcset');
			$image_tag->remove_attribute('sizes');
			$image_tag->remove_class('wp-image-undefined');

			// Add the wp-image class for automatically generate new srcset and sizes attributes
			$image_tag->add_class("wp-image-{$image_id}");
		}

		return $image_tag->get_updated_html();
	}

	return $content;
}




/**
 * Register the image_separator block.
 *
 * @uses render_block_pbg_image_separator()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_image_separator()
{
	if (! function_exists('register_block_type')) {
		return;
	}
	register_block_type(
		PREMIUM_BLOCKS_PATH . '/blocks-config/image-separator',
		array(
			'render_callback' => 'render_block_pbg_image_separator',
		)
	);
}

register_block_pbg_image_separator();
