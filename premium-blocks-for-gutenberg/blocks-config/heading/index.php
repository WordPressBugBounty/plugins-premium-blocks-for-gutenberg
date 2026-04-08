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
  $css->pbg_render_color($attr, 'titleStyles[0].titleColor', 'color');
  $css->pbg_render_shadow($attr, 'titleShadow', 'text-shadow');

  $css->set_selector($unique_id . ' .premium-title-style9-letter');
  $css->pbg_render_color($attr, 'titleStyles[0].titleColor', 'color');
	
  $title_border_type = $attr['titleBorder']['borderType'] ?? "";

  // Non-responsive icon/hover colors.
  $css->set_selector( 
    "{$unique_id} .premium-title-icon, " .
    "{$unique_id} .premium-title-icon:not(.icon-type-fe) svg, " .
    "{$unique_id} .premium-title-icon:not(.icon-type-fe) svg *, " .
    "{$unique_id} .premium-title-svg-class svg, " .
    "{$unique_id} .premium-title-svg-class svg *"
  );
  $css->pbg_render_color($attr, 'iconColor', 'color');
  $css->pbg_render_color($attr, 'iconColor', 'fill');

  $css->set_selector( 
    "{$unique_id} .premium-title-icon:hover, " .
    "{$unique_id} .premium-lottie-animation:hover svg, " .
    "{$unique_id} .premium-title-svg-class:hover svg"
  );
  $css->pbg_render_color($attr, 'borderHoverColor', 'border-color');

  $css->set_selector( 
    "{$unique_id} .premium-title-icon:hover, " .
    "{$unique_id} .premium-title-icon:not(.icon-type-fe):hover svg *, " .
    "{$unique_id} .premium-title-svg-class:hover svg, " .
    "{$unique_id} .premium-title-svg-class:hover svg *"
  );
  $css->pbg_render_color($attr, 'iconHoverColor', 'color');
  $css->pbg_render_color($attr, 'iconHoverColor', 'fill');

  // Non-responsive stripe color.
  $css->set_selector($unique_id . ' .premium-title-style7-stripe-span');
  $css->pbg_render_color($attr, 'titleStyles[0].stripeColor', 'background-color', null, ' !important');

  // Non-responsive background text styles.
  $css->set_selector($unique_id . ' .premium-title-bg-text:before');
  $css->pbg_render_color($attr, 'textStyles[0].textBackColor', 'color');
  $css->pbg_render_color($attr, 'strokeStyles[0].strokeColor', '-webkit-text-stroke-color');
  $css->pbg_render_shadow($attr, 'textBackshadow', 'text-shadow', '!important');
  $css->pbg_render_value($attr, 'blend', 'mix-blend-mode');
  $css->pbg_render_range($attr, 'zIndex', 'z-index');
  $css->pbg_render_value($attr, 'textWidth', 'width');

  $css->set_selector($unique_id . ' .premium-title-container .premium-title-header .premium-headingc-true.premium-headings-true' );
  $css->pbg_render_color($attr, 'titleStyles[0].strokeColor', '-webkit-text-stroke-color');
  $css->pbg_render_color($attr, 'titleStyles[0].strokeFill', '-webkit-text-fill-color');

  $css->set_selector($unique_id . ' .premium-title-container-noise-true .premium-title-text-title:before' );
  $css->pbg_render_range($attr, 'noiseColor1', 'text-shadow', null, '1px 0');

  $css->set_selector($unique_id . ' .premium-title-container-noise-true .premium-title-text-title:after' );
  $css->pbg_render_range($attr, 'noiseColor2', 'text-shadow', null, '-1px 0');

	// Align.
  $css->set_selector($unique_id . ' .style1 .premium-title-header');
  $css->add_property('border-left-style', $title_border_type === 'none' ? 'solid' : $title_border_type);

  $css->set_selector($unique_id . ' .style2, ' . $unique_id . ' .style3, ' . $unique_id . ' .style4, ' . $unique_id . ' .style5, ' . $unique_id . ' .style6');
  $css->add_property('border-bottom-style', $title_border_type === 'none' ? 'solid' : $title_border_type);

  // Responsive styles.
  $css->render_responsive( function( $css, $device ) use ( $attr, $unique_id, $title_border_type ) {
    $css->set_selector($unique_id);
    $css->pbg_render_value($attr, 'align', 'text-align', $device);
    $css->pbg_render_range($attr, 'rotateHeading', 'transform', $device, 'rotate(', ')');

    $css->set_selector($unique_id . ' .premium-title-container');
    $css->pbg_render_spacing($attr, 'titleMargin', 'margin', $device);

    $css->set_selector($unique_id . ' .premium-title-container .premium-title-header');
    $css->pbg_render_spacing($attr, 'titlePadding', 'padding', $device);
    $css->pbg_render_align_self($attr, 'align', 'justify-content', $device);

    $css->set_selector($unique_id . ' .premium-title-header.top');
    $css->pbg_render_align_self($attr, 'iconAlign', 'align-items', $device);

    $css->set_selector($unique_id . ' .premium-title-header .premium-title-text-title, ' . $unique_id . ' .premium-title-header .premium-letters-container');
    $css->pbg_render_typography($attr, 'titleTypography', $device);

    $css->set_selector($unique_id . ' .default .premium-title-header');
    $css->pbg_render_border($attr, 'titleBorder', $device);

    $css->set_selector($unique_id . ' .style1 .premium-title-header');
    $css->pbg_render_border($attr, 'titleBorder', $device);

    $css->set_selector($unique_id . ' .style2, ' . $unique_id . ' .style3, ' . $unique_id . ' .style4, ' . $unique_id . ' .style5, ' . $unique_id . ' .style6');
    $css->pbg_render_border($attr, 'titleBorder', $device);

    // Style for icon.
    $css->set_selector( 
      "{$unique_id} .premium-title-icon, " .
      "{$unique_id} .premium-lottie-animation svg, " .
      "{$unique_id} .premium-title-svg-class svg"
    );
    $css->pbg_render_background($attr, 'iconBG', $device);

    $css->set_selector($unique_id . ' .premium-title-style7-inner-title');
    $css->pbg_render_align_self($attr, 'iconAlign', 'align-items', $device);

    $css->set_selector( 
      "{$unique_id} .premium-title-icon, " .
      "{$unique_id} .premium-title-header img, " .
      "{$unique_id} .premium-lottie-animation svg, " .
      "{$unique_id} .premium-title-svg-class svg" 
    );
    $css->pbg_render_spacing($attr, 'iconPadding', 'padding', $device);
    $css->pbg_render_spacing($attr, 'iconMargin', 'margin', $device);
    $css->pbg_render_border($attr, 'iconBorder', $device);

    $css->set_selector( 
      "{$unique_id} .premium-title-icon svg, " .
      "{$unique_id} .premium-title-svg-class svg" 
    );
    $css->pbg_render_range($attr, 'iconSize', 'width', $device, null, '!important');
    $css->pbg_render_range($attr, 'iconSize', 'height', $device, null, '!important');

    $css->set_selector( 
      "{$unique_id} .premium-title-icon:hover, " .
      "{$unique_id} .premium-lottie-animation:hover svg, " .
      "{$unique_id} .premium-title-svg-class:hover svg"
    );
    $css->pbg_render_background($attr, 'iconHoverBG', $device);

    // image style
    $css->set_selector($unique_id . ' .premium-title-header img');
    $css->pbg_render_range($attr, 'imgWidth', 'width', $device, null, '!important');

    $css->set_selector($unique_id . ' .premium-title-header .premium-lottie-animation svg');
    $css->pbg_render_range($attr, 'imgWidth', 'width', $device, null, '!important');
    $css->pbg_render_range($attr, 'imgWidth', 'height', $device, null, '!important');

    // stripeStyles
    $css->set_selector($unique_id . ' .premium-title-style7-stripe__wrap');
    $css->pbg_render_range($attr, 'stripeTopSpacing', 'margin-top', $device);
    $css->pbg_render_range($attr, 'stripeBottomSpacing', 'margin-bottom', $device);
    $css->pbg_render_align_self($attr, 'stripeAlign', 'justify-content', $device);

    $css->set_selector($unique_id . ' .premium-title-style7-stripe-span');
    $css->pbg_render_range($attr, 'stripeWidth', 'width', $device);
    $css->pbg_render_range($attr, 'stripeHeight', 'height', $device);

    // background text
    $css->set_selector($unique_id . ' .premium-title-bg-text:before');
    $css->pbg_render_range($attr, 'verticalText', 'top', $device);
    $css->pbg_render_range($attr, 'horizontalText', 'left', $device);
    $css->pbg_render_range($attr, 'rotateText', 'transform', $device, 'rotate(', ')!important');
    $css->pbg_render_range($attr, 'strokeFull', '-webkit-text-stroke-width', $device);
    $css->pbg_render_typography($attr, 'textTypography', $device);

    $css->set_selector($unique_id . ' .premium-title-container:not(.style8) .premium-title-header .premium-title-text-title:not(.premium-headinga-true)' );
    $css->pbg_render_background($attr, 'clipBackground', $device);
  } );

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
