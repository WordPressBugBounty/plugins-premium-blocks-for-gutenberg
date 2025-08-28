<?php

/**
 * Server-side rendering of the `pbg/haeding` block.
 *
 * @package WordPress
 */

/**
 * Get Heading Block CSS
 *
 * Return Frontend CSS for Heading.
 *
 * @access public
 *
 * @param string $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_heading_css_style($attr, $unique_id)
{
	$css = new Premium_Blocks_css();

  $css->set_selector("{$unique_id} .premium-title-style8__wrap .premium-title-text-title[data-animation='shiny']");
  $css->pbg_render_color($attr, 'titleStyles[0].titleColor', '--base-color', null, '!important');
  $css->pbg_render_color($attr, 'titleStyles[0].shinyColor', '--shiny-color', null, '!important');
  $css->pbg_render_range($attr, 'titleStyles[0].animateduration', '--animation-speed', null, null, 's!important');
  
  $css->set_selector("{$unique_id} .premium-title-header");
  $css->pbg_render_color($attr, 'titleStyles[0].blurColor', '--shadow-color', null, '!important');
  $css->pbg_render_range($attr, 'titleStyles[0].blurShadow', '--shadow-value', null, null, 'px!important');

  $css->set_selector( 
    "{$unique_id} .premium-title-style2__wrap, " .
    "{$unique_id} .style3"
  );
  $css->pbg_render_color($attr, 'titleStyles[0].BGColor', 'background-color', null, '!important');

  $css->set_selector( 
    "{$unique_id} .premium-title-style5__wrap, " .
    "{$unique_id} .premium-title-style6__wrap" 
  );
  $css->pbg_render_color($attr, 'titleStyles[0].lineColor', 'border-bottom', '2px solid ', ' !important');

  $css->set_selector($unique_id . ' .premium-title-style6__wrap:before');
  $css->pbg_render_color($attr, 'titleStyles[0].triangleColor', 'border-bottom-color', null, ' !important');

  $css->set_selector( 
    "{$unique_id} .premium-title-style9__wrap .premium-letters-container, " .
    "{$unique_id} .premium-title-text-title" 
  );
  $css->pbg_render_shadow($attr, 'titleShadow', 'text-shadow');
	
	// Align.
  $css->set_selector($unique_id);
  $css->pbg_render_value($attr, 'align', 'text-align', 'Desktop');

  $css->set_selector($unique_id . ' .premium-title-container');
  $css->pbg_render_spacing($attr, 'titleMargin', 'margin', 'Desktop');

  $css->set_selector($unique_id . ' .premium-title-header');
  $css->pbg_render_spacing($attr, 'titlePadding', 'padding', 'Desktop');
  $css->pbg_render_align_self($attr, 'iconAlign', 'align-items', 'Desktop'); 
  $css->pbg_render_align_self($attr, 'align', 'justify-content', 'Desktop');
	
  $css->set_selector($unique_id . ' .premium-title-header .premium-title-text-title, ' . $unique_id . ' .premium-title-header .premium-letters-container');
  $css->pbg_render_typography($attr, 'titleTypography', 'Desktop');

  $title_border_type = $attr['titleBorder']['borderType'] ?? "";
  $css->set_selector($unique_id . ' .default .premium-title-header');
  $css->pbg_render_border($attr, 'titleBorder', 'Desktop');

  $css->set_selector($unique_id . ' .style1 .premium-title-header');
  $css->pbg_render_border($attr, 'titleBorder', 'Desktop');
  $css->add_property('border-left-style', $title_border_type === 'none' ? 'solid' : $title_border_type);

  $css->set_selector($unique_id . ' .style2, ' . $unique_id . ' .style4, ' . $unique_id . ' .style5, ' . $unique_id . ' .style6');
  $css->pbg_render_border($attr, 'titleBorder', 'Desktop');
  $css->add_property('border-bottom-style', $title_border_type === 'none' ? 'solid' : $title_border_type);

	// Style for icon.
  $css->set_selector( 
    "{$unique_id} .premium-title-icon, " .
    "{$unique_id} .premium-lottie-animation svg, " .
    "{$unique_id} .premium-title-svg-class svg"
  );
  $css->pbg_render_background($attr, 'iconBG', 'Desktop');

  $css->set_selector( 
    "{$unique_id} .premium-title-icon, " .
    "{$unique_id} .premium-title-icon:not(.icon-type-fe) svg, " .
    "{$unique_id} .premium-title-icon:not(.icon-type-fe) svg *, " .
    "{$unique_id} .premium-title-svg-class svg, " .
    "{$unique_id} .premium-title-svg-class svg *"
  );
  $css->pbg_render_color($attr, 'iconColor', 'color');
  $css->pbg_render_color($attr, 'iconColor', 'fill');

  $css->set_selector($unique_id . ' .premium-title-style7-inner-title');
  $css->pbg_render_align_self($attr, 'iconAlign', 'align-items', 'Desktop'); 

  $css->set_selector( 
    "{$unique_id} .premium-title-icon, " .
    "{$unique_id} .premium-title-header img, " .
    "{$unique_id} .premium-lottie-animation svg, " .
    "{$unique_id} .premium-title-svg-class svg" 
  );
  $css->pbg_render_spacing($attr, 'iconPadding', 'padding', 'Desktop');
  $css->pbg_render_spacing($attr, 'iconMargin', 'margin', 'Desktop');
  $css->pbg_render_border($attr, 'iconBorder', 'Desktop');

  $css->set_selector( 
    "{$unique_id} .premium-title-icon svg, " .
    "{$unique_id} .premium-title-svg-class svg" 
  );
  $css->pbg_render_range($attr, 'iconSize', 'width', 'Desktop', null, '!important');
  $css->pbg_render_range($attr, 'iconSize', 'height', 'Desktop', null, '!important');

  $css->set_selector( 
    "{$unique_id} .premium-title-icon:hover, " .
    "{$unique_id} .premium-lottie-animation:hover svg, " .
    "{$unique_id} .premium-title-svg-class:hover svg"
  );
  $css->pbg_render_color($attr, 'borderHoverColor', 'border-color');
  $css->pbg_render_background($attr, 'iconHoverBG', 'Desktop');

  $css->set_selector( 
    "{$unique_id} .premium-title-icon:hover, " .
    "{$unique_id} .premium-title-icon:not(.icon-type-fe):hover svg *, " .
    "{$unique_id} .premium-title-svg-class:hover svg, " .
    "{$unique_id} .premium-title-svg-class:hover svg *"
  );
  $css->pbg_render_color($attr, 'iconHoverColor', 'color');
  $css->pbg_render_color($attr, 'iconHoverColor', 'fill');
	// image style
  $css->set_selector($unique_id . ' .premium-title-header img');
  $css->pbg_render_range($attr, 'imgWidth', 'width', 'Desktop', null, '!important');

  $css->set_selector($unique_id . ' .premium-title-header .premium-lottie-animation svg');
  $css->pbg_render_range($attr, 'imgWidth', 'width', 'Desktop', null, '!important');
  $css->pbg_render_range($attr, 'imgWidth', 'height', 'Desktop', null, '!important');

	// stripeStyles
  $css->set_selector($unique_id . ' .premium-title-style7-stripe__wrap');
  $css->pbg_render_range($attr, 'stripeTopSpacing', 'margin-top', 'Desktop');
  $css->pbg_render_range($attr, 'stripeBottomSpacing', 'margin-bottom', 'Desktop');
	$css->pbg_render_align_self($attr, 'stripeAlign', 'justify-content', 'Desktop');

  $css->set_selector($unique_id . ' .premium-title-style7-stripe-span');
  $css->pbg_render_color($attr, 'titleStyles[0].stripeColor', 'background-color', null, ' !important');
  $css->pbg_render_range($attr, 'stripeWidth', 'width', 'Desktop');
  $css->pbg_render_range($attr, 'stripeHeight', 'height', 'Desktop');

	// background text
  $css->set_selector($unique_id . ' .premium-title-bg-text:before');
  $css->pbg_render_color($attr, 'textStyles[0].textBackColor', 'color');
  $css->pbg_render_color($attr, 'strokeStyles[0].strokeColor', '-webkit-text-stroke-color');
  $css->pbg_render_shadow($attr, 'textBackshadow', 'text-shadow', '!important');
  $css->pbg_render_value($attr, 'blend', 'mix-blend-mode');
  $css->pbg_render_range($attr, 'zIndex', 'z-index');
  $css->pbg_render_value($attr, 'textWidth', 'width');
  $css->pbg_render_range($attr, 'verticalText', 'top', 'Desktop');
  $css->pbg_render_range($attr, 'horizontalText', 'left', 'Desktop');
  $css->pbg_render_range($attr, 'rotateText', 'transform', 'Desktop', 'rotate(', ')!important');
  $css->pbg_render_range($attr, 'strokeFull', '-webkit-text-stroke-width', 'Desktop');
  $css->pbg_render_typography($attr, 'textTypography', 'Desktop');

	$css->start_media_query('tablet');

	// Align.
	$css->set_selector($unique_id);
  $css->pbg_render_value($attr, 'align', 'text-align', 'Tablet');

  $css->set_selector($unique_id . ' .premium-title-container');
  $css->pbg_render_spacing($attr, 'titleMargin', 'margin', 'Tablet');

  $css->set_selector($unique_id . ' .premium-title-header');
  $css->pbg_render_spacing($attr, 'titlePadding', 'padding', 'Tablet');
  $css->pbg_render_align_self($attr, 'iconAlign', 'align-items', 'Tablet'); 
  $css->pbg_render_align_self($attr, 'align', 'justify-content', 'Tablet');

	$css->set_selector($unique_id . ' .premium-title-header .premium-title-text-title, ' . $unique_id . ' .premium-title-header .premium-letters-container');
  $css->pbg_render_typography($attr, 'titleTypography', 'Tablet');

  $css->set_selector($unique_id . ' .default .premium-title-header');
  $css->pbg_render_border($attr, 'titleBorder', 'Tablet');

  $css->set_selector($unique_id . ' .style1 .premium-title-header');
  $css->pbg_render_border($attr, 'titleBorder', 'Tablet');

  $css->set_selector($unique_id . ' .style2, ' . $unique_id . ' .style4, ' . $unique_id . ' .style5, ' . $unique_id . ' .style6');
  $css->pbg_render_border($attr, 'titleBorder', 'Tablet');

	// Style for icon.
	$css->set_selector( 
    "{$unique_id} .premium-title-icon, " .
    "{$unique_id} .premium-lottie-animation svg, " .
    "{$unique_id} .premium-title-svg-class svg"
  );
  $css->pbg_render_background($attr, 'iconBG', 'Tablet');

  $css->set_selector($unique_id . ' .premium-title-style7-inner-title');
  $css->pbg_render_align_self($attr, 'iconAlign', 'align-items', 'Tablet'); 

	$css->set_selector( 
    "{$unique_id} .premium-title-icon, " .
    "{$unique_id} .premium-title-header img, " .
    "{$unique_id} .premium-lottie-animation svg, " .
    "{$unique_id} .premium-title-svg-class svg" 
  );
  $css->pbg_render_spacing($attr, 'iconPadding', 'padding', 'Tablet');
  $css->pbg_render_spacing($attr, 'iconMargin', 'margin', 'Tablet');
  $css->pbg_render_border($attr, 'iconBorder', 'Tablet');

  $css->set_selector( 
    "{$unique_id} .premium-title-icon svg, " .
    "{$unique_id} .premium-title-svg-class svg" 
  );
  $css->pbg_render_range($attr, 'iconSize', 'width', 'Tablet', null, '!important');
  $css->pbg_render_range($attr, 'iconSize', 'height', 'Tablet', null, '!important');

  $css->set_selector( 
    "{$unique_id} .premium-title-icon:hover, " .
    "{$unique_id} .premium-lottie-animation:hover svg, " .
    "{$unique_id} .premium-title-svg-class:hover svg"
  );
  $css->pbg_render_background($attr, 'iconHoverBG', 'Tablet');

	// image style
	$css->set_selector($unique_id . ' .premium-title-header img');
  $css->pbg_render_range($attr, 'imgWidth', 'width', 'Tablet', null, '!important');

  $css->set_selector($unique_id . ' .premium-title-header .premium-lottie-animation svg');
  $css->pbg_render_range($attr, 'imgWidth', 'width', 'Tablet', null, '!important');
  $css->pbg_render_range($attr, 'imgWidth', 'height', 'Tablet', null, '!important');

	// stripeStyles
	$css->set_selector($unique_id . ' .premium-title-style7-stripe__wrap');
  $css->pbg_render_range($attr, 'stripeTopSpacing', 'margin-top', 'Tablet');
  $css->pbg_render_range($attr, 'stripeBottomSpacing', 'margin-bottom', 'Tablet');
	$css->pbg_render_align_self($attr, 'stripeAlign', 'justify-content', 'Tablet');

  $css->set_selector($unique_id . ' .premium-title-style7-stripe-span');
  $css->pbg_render_range($attr, 'stripeWidth', 'width', 'Tablet');
  $css->pbg_render_range($attr, 'stripeHeight', 'height', 'Tablet');

	// background text
	$css->set_selector($unique_id . ' .premium-title-bg-text:before');
  $css->pbg_render_range($attr, 'verticalText', 'top', 'Tablet');
  $css->pbg_render_range($attr, 'horizontalText', 'left', 'Tablet');
  $css->pbg_render_range($attr, 'rotateText', 'transform', 'Tablet', 'rotate(', ')!important');
  $css->pbg_render_range($attr, 'strokeFull', '-webkit-text-stroke-width', 'Tablet');
  $css->pbg_render_typography($attr, 'textTypography', 'Tablet');

	$css->stop_media_query();

	$css->start_media_query('mobile');

	// Align.
	$css->set_selector($unique_id);
  $css->pbg_render_value($attr, 'align', 'text-align', 'Mobile');

  $css->set_selector($unique_id . ' .premium-title-container');
  $css->pbg_render_spacing($attr, 'titleMargin', 'margin', 'Mobile');

  $css->set_selector($unique_id . ' .premium-title-header');
  $css->pbg_render_spacing($attr, 'titlePadding', 'padding', 'Mobile');
  $css->pbg_render_align_self($attr, 'iconAlign', 'align-items', 'Mobile'); 
  $css->pbg_render_align_self($attr, 'align', 'justify-content', 'Mobile');

	$css->set_selector($unique_id . ' .premium-title-header .premium-title-text-title, ' . $unique_id . ' .premium-title-header .premium-letters-container');
  $css->pbg_render_typography($attr, 'titleTypography', 'Mobile');

  $css->set_selector($unique_id . ' .default .premium-title-header');
  $css->pbg_render_border($attr, 'titleBorder', 'Mobile');

  $css->set_selector($unique_id . ' .style1 .premium-title-header');
  $css->pbg_render_border($attr, 'titleBorder', 'Mobile');

  $css->set_selector($unique_id . ' .style2, ' . $unique_id . ' .style4, ' . $unique_id . ' .style5, ' . $unique_id . ' .style6');
  $css->pbg_render_border($attr, 'titleBorder', 'Mobile');

	// Style for icon.
	$css->set_selector( 
    "{$unique_id} .premium-title-icon, " .
    "{$unique_id} .premium-lottie-animation svg, " .
    "{$unique_id} .premium-title-svg-class svg"
  );
  $css->pbg_render_background($attr, 'iconBG', 'Mobile');

  $css->set_selector($unique_id . ' .premium-title-style7-inner-title');
  $css->pbg_render_align_self($attr, 'iconAlign', 'align-items', 'Mobile'); 

	$css->set_selector( 
    "{$unique_id} .premium-title-icon, " .
    "{$unique_id} .premium-title-header img, " .
    "{$unique_id} .premium-lottie-animation svg, " .
    "{$unique_id} .premium-title-svg-class svg" 
  );
  $css->pbg_render_spacing($attr, 'iconPadding', 'padding', 'Mobile');
  $css->pbg_render_spacing($attr, 'iconMargin', 'margin', 'Mobile');
  $css->pbg_render_border($attr, 'iconBorder', 'Mobile');

  $css->set_selector( 
    "{$unique_id} .premium-title-icon svg, " .
    "{$unique_id} .premium-title-svg-class svg" 
  );
  $css->pbg_render_range($attr, 'iconSize', 'width', 'Mobile', null, '!important');
  $css->pbg_render_range($attr, 'iconSize', 'height', 'Mobile', null, '!important');

  $css->set_selector( 
    "{$unique_id} .premium-title-icon:hover, " .
    "{$unique_id} .premium-lottie-animation:hover svg, " .
    "{$unique_id} .premium-title-svg-class:hover svg"
  );
  $css->pbg_render_background($attr, 'iconHoverBG', 'Mobile');

	// image style
	$css->set_selector($unique_id . ' .premium-title-header img');
  $css->pbg_render_range($attr, 'imgWidth', 'width', 'Mobile', null, '!important');

  $css->set_selector($unique_id . ' .premium-title-header .premium-lottie-animation svg');
  $css->pbg_render_range($attr, 'imgWidth', 'width', 'Mobile', null, '!important');
  $css->pbg_render_range($attr, 'imgWidth', 'height', 'Mobile', null, '!important');

	// stripeStyles
	$css->set_selector($unique_id . ' .premium-title-style7-stripe__wrap');
  $css->pbg_render_range($attr, 'stripeTopSpacing', 'margin-top', 'Mobile');
  $css->pbg_render_range($attr, 'stripeBottomSpacing', 'margin-bottom', 'Mobile');
	$css->pbg_render_align_self($attr, 'stripeAlign', 'justify-content', 'Mobile');

  $css->set_selector($unique_id . ' .premium-title-style7-stripe-span');
  $css->pbg_render_range($attr, 'stripeWidth', 'width', 'Mobile');
  $css->pbg_render_range($attr, 'stripeHeight', 'height', 'Mobile');

	// background text
	$css->set_selector($unique_id . ' .premium-title-bg-text:before');
  $css->pbg_render_range($attr, 'verticalText', 'top', 'Mobile');
  $css->pbg_render_range($attr, 'horizontalText', 'left', 'Mobile');
  $css->pbg_render_range($attr, 'rotateText', 'transform', 'Mobile', 'rotate(', ')!important');
  $css->pbg_render_range($attr, 'strokeFull', '-webkit-text-stroke-width', 'Mobile');
  $css->pbg_render_typography($attr, 'textTypography', 'Mobile');

	$css->stop_media_query();
	return $css->css_output();
}

/**
 * Renders the `premium/heading` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_heading($attributes, $content)
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

		if ($attributes['iconTypeSelect'] == 'svg' || (isset($attributes['style']) && ($attributes['style'] == 'style8' || $attributes['style'] == 'style9'))) {
			wp_enqueue_script(
				'pbg-heading',
				PREMIUM_BLOCKS_URL . 'assets/js/minified/heading.min.js',
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
 * Register the heading block.
 *
 * @uses render_block_pbg_heading()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_heading()
{
	if (! function_exists('register_block_type')) {
		return;
	}
	register_block_type(
		PREMIUM_BLOCKS_PATH . '/blocks-config/heading',
		array(
			'render_callback' => 'render_block_pbg_heading',
		)
	);
}

register_block_pbg_heading();
