<?php
// Move this file to "blocks-config" folder with name "button.php".

/**
 * Server-side rendering of the `premium/button` block.
 *
 * @package WordPress
 */

function get_premium_button_css_style($attr, $unique_id)
{
	$css = new Premium_Blocks_css();

	// Button Style
  $css->set_selector('.' . $unique_id);
  $css->pbg_render_value($attr, 'btnWidth', 'width', 'Desktop');
  $css->pbg_render_spacing($attr, 'margin', 'margin', 'Desktop');

  $css->set_selector('.' . $unique_id . '.premium-button__wrap .premium-button .premium-button-text-edit');
  $css->pbg_render_typography($attr, 'typography', 'Desktop');

  $css->set_selector('.' . $unique_id . '.premium-button__wrap .premium-button');
  $css->pbg_render_background($attr, 'backgroundOptions', 'Desktop');
  $css->pbg_render_border($attr, 'border', 'Desktop');
  $css->pbg_render_spacing($attr, 'padding', 'padding', 'Desktop');
  $css->pbg_render_shadow($attr, 'boxShadow', 'box-shadow');

  $css->set_selector(
    ".{$unique_id}.premium-button__slide .premium-button::before, " .
    ".{$unique_id}.premium-button__shutter .premium-button::before, " .
    ".{$unique_id}.premium-button__radial .premium-button::before"
  );
  $css->pbg_render_background($attr, 'backgroundHoverOptions', 'Desktop');

  $css->set_selector('.' . $unique_id . ' .premium-button:hover');
  $css->pbg_render_background($attr, 'backgroundHoverOptions', 'Desktop');
  $css->pbg_render_shadow($attr, 'boxShadowHover', 'box-shadow');
  $css->pbg_render_color($attr, 'btnStyles[0].borderHoverColor', 'border-color', null, '!important' );

  $css->set_selector('.' . $unique_id . ' .premium-button:hover .premium-button-text-edit');
  $css->pbg_render_color($attr, 'btnStyles[0].textHoverColor', 'color', null, '!important' );
	
	// icon styles
  $css->set_selector(
    ".{$unique_id} .premium-button .premium-button-icon svg, " .
    ".{$unique_id} .premium-button .premium-button-svg-class svg"
  );
  $css->pbg_render_range($attr, 'iconSize', 'width', 'Desktop', null, '!important');
  $css->pbg_render_range($attr, 'iconSize', 'height', 'Desktop', null, '!important');

  $css->set_selector('.' . $unique_id . ' .premium-button img');
  $css->pbg_render_range($attr, 'imgWidth', 'width', 'Desktop', null, '!important');

  $css->set_selector('.' . $unique_id . ' .premium-button .premium-lottie-animation svg');
  $css->pbg_render_range($attr, 'imgWidth', 'width', 'Desktop', null, '!important');
  $css->pbg_render_range($attr, 'imgWidth', 'height', 'Desktop', null, '!important');

  $css->set_selector( 
    ".{$unique_id} .premium-button .premium-button-icon, " .
    ".{$unique_id} .premium-button .premium-button-icon:not(.icon-type-fe) svg, " .
    ".{$unique_id} .premium-button .premium-button-icon:not(.icon-type-fe) svg *, " .
    ".{$unique_id} .premium-button .premium-button-svg-class svg, " .
    ".{$unique_id} .premium-button .premium-button-svg-class svg *"
  );
  $css->pbg_render_color($attr, 'btnStyles[0].textColor', 'color');
  $css->pbg_render_color($attr, 'btnStyles[0].textColor', 'fill');
  $css->pbg_render_color($attr, 'iconColor', 'color');
  $css->pbg_render_color($attr, 'iconColor', 'fill');

  $css->set_selector( 
    ".{$unique_id} .premium-button:hover .premium-button-icon, " .
    ".{$unique_id} .premium-button:hover .premium-button-icon:not(.icon-type-fe) svg *, " .
    ".{$unique_id} .premium-button:hover .premium-button-svg-class svg, " .
    ".{$unique_id} .premium-button:hover .premium-button-svg-class svg *"
  );
  $css->pbg_render_color($attr, 'iconHoverColor', 'color');
  $css->pbg_render_color($attr, 'iconHoverColor', 'fill');
	
  $css->set_selector(
    ".{$unique_id} .premium-button:hover .premium-button-icon, " .
    ".{$unique_id} .premium-button:hover .premium-button-svg-class svg, " .
    ".{$unique_id} .premium-button:hover .premium-lottie-animation svg"
  );
  $css->pbg_render_color($attr, 'borderHoverColor', 'border-color');
  $css->pbg_render_background($attr, 'iconHoverBG', 'Desktop');

  $css->set_selector(
    ".{$unique_id} .premium-button .premium-button-icon, " .
    ".{$unique_id} .premium-button .premium-button-svg-class svg, " .
    ".{$unique_id} .premium-button .premium-lottie-animation svg"
  );
  $css->pbg_render_background($attr, 'iconBG', 'Desktop');

  $css->set_selector(
    ".{$unique_id} .premium-button .premium-button-icon, " .
    ".{$unique_id} .premium-button img, " .
    ".{$unique_id} .premium-button .premium-button-svg-class svg, " .
    ".{$unique_id} .premium-button .premium-lottie-animation svg"
  );
  $css->pbg_render_border($attr, 'iconBorder', 'Desktop');
  $css->pbg_render_spacing($attr, 'iconPadding', 'padding', "Desktop");
  $css->pbg_render_spacing($attr, 'iconMargin', 'margin', 'Desktop');

  $css->set_selector(
    ".{$unique_id} .premium-button .premium-button-icon svg, " .
    ".{$unique_id} .premium-button .premium-button-icon svg *"
  );
  $css->pbg_render_background($attr, 'iconBackground', 'Desktop');

	$css->start_media_query('tablet');

	// Button Style
  $css->set_selector('.' . $unique_id);
  $css->pbg_render_value($attr, 'btnWidth', 'width', 'Tablet');
  $css->pbg_render_spacing($attr, 'margin', 'margin', 'Tablet');

	$css->set_selector('.' . $unique_id . '.premium-button__wrap .premium-button .premium-button-text-edit');
  $css->pbg_render_typography($attr, 'typography', 'Tablet');

	$css->set_selector('.' . $unique_id . '.premium-button__wrap .premium-button');
  $css->pbg_render_background($attr, 'backgroundOptions', 'Tablet');
  $css->pbg_render_border($attr, 'border', 'Tablet');
  $css->pbg_render_spacing($attr, 'padding', 'padding', 'Tablet');

	$css->set_selector(
    ".{$unique_id}.premium-button__slide .premium-button::before, " .
    ".{$unique_id}.premium-button__shutter .premium-button::before, " .
    ".{$unique_id}.premium-button__radial .premium-button::before"
  );
  $css->pbg_render_background($attr, 'backgroundHoverOptions', 'Tablet');

  $css->set_selector('.' . $unique_id . ' .premium-button:hover');
  $css->pbg_render_background($attr, 'backgroundHoverOptions', 'Tablet');

	// icon styles
	$css->set_selector(
    ".{$unique_id} .premium-button .premium-button-icon svg, " .
    ".{$unique_id} .premium-button .premium-button-svg-class svg"
  );
  $css->pbg_render_range($attr, 'iconSize', 'width', 'Tablet', null, '!important');
  $css->pbg_render_range($attr, 'iconSize', 'height', 'Tablet', null, '!important');

	$css->set_selector('.' . $unique_id . ' .premium-button img');
  $css->pbg_render_range($attr, 'imgWidth', 'width', 'Tablet', null, '!important');

  $css->set_selector('.' . $unique_id . ' .premium-button .premium-lottie-animation svg');
  $css->pbg_render_range($attr, 'imgWidth', 'width', 'Tablet', null, '!important');
  $css->pbg_render_range($attr, 'imgWidth', 'height', 'Tablet', null, '!important');

  $css->set_selector(
    ".{$unique_id} .premium-button:hover .premium-button-icon, " .
    ".{$unique_id} .premium-button:hover .premium-button-svg-class svg, " .
    ".{$unique_id} .premium-button:hover .premium-lottie-animation svg"
  );
  $css->pbg_render_background($attr, 'iconHoverBG', 'Tablet');

	$css->set_selector(
    ".{$unique_id} .premium-button .premium-button-icon, " .
    ".{$unique_id} .premium-button .premium-button-svg-class svg, " .
    ".{$unique_id} .premium-button .premium-lottie-animation svg"
  );
  $css->pbg_render_background($attr, 'iconBG', 'Tablet');

  $css->set_selector(
    ".{$unique_id} .premium-button .premium-button-icon, " .
    ".{$unique_id} .premium-button img, " .
    ".{$unique_id} .premium-button .premium-button-svg-class svg, " .
    ".{$unique_id} .premium-button .premium-lottie-animation svg"
  );
  $css->pbg_render_border($attr, 'iconBorder', 'Tablet');
  $css->pbg_render_spacing($attr, 'iconPadding', 'padding', "Tablet");
  $css->pbg_render_spacing($attr, 'iconMargin', 'margin', 'Tablet');
	
	$css->set_selector(
    ".{$unique_id} .premium-button .premium-button-icon svg, " .
    ".{$unique_id} .premium-button .premium-button-icon svg *"
  );
  $css->pbg_render_background($attr, 'iconBackground', 'Tablet');

	$css->stop_media_query();
	$css->start_media_query('mobile');

	// Button Style
  $css->set_selector('.' . $unique_id);
  $css->pbg_render_value($attr, 'btnWidth', 'width', 'Mobile');
  $css->pbg_render_spacing($attr, 'margin', 'margin', 'Mobile');

	$css->set_selector('.' . $unique_id . '.premium-button__wrap .premium-button .premium-button-text-edit');
  $css->pbg_render_typography($attr, 'typography', 'Mobile');
	
  $css->set_selector('.' . $unique_id . '.premium-button__wrap .premium-button');
  $css->pbg_render_background($attr, 'backgroundOptions', 'Mobile');
  $css->pbg_render_border($attr, 'border', 'Mobile');
  $css->pbg_render_spacing($attr, 'padding', 'padding', 'Mobile');

	$css->set_selector(
    ".{$unique_id}.premium-button__slide .premium-button::before, " .
    ".{$unique_id}.premium-button__shutter .premium-button::before, " .
    ".{$unique_id}.premium-button__radial .premium-button::before"
  );
  $css->pbg_render_background($attr, 'backgroundHoverOptions', 'Mobile');

  $css->set_selector('.' . $unique_id . ' .premium-button:hover');
  $css->pbg_render_background($attr, 'backgroundHoverOptions', 'Mobile');

	// icon styles
	$css->set_selector(
    ".{$unique_id} .premium-button .premium-button-icon svg, " .
    ".{$unique_id} .premium-button .premium-button-svg-class svg"
  );
  $css->pbg_render_range($attr, 'iconSize', 'width', 'Mobile', null, '!important');
  $css->pbg_render_range($attr, 'iconSize', 'height', 'Mobile', null, '!important');
	
  $css->set_selector('.' . $unique_id . ' .premium-button img');
  $css->pbg_render_range($attr, 'imgWidth', 'width', 'Mobile', null, '!important');

  $css->set_selector('.' . $unique_id . ' .premium-button .premium-lottie-animation svg');
  $css->pbg_render_range($attr, 'imgWidth', 'width', 'Mobile', null, '!important');
  $css->pbg_render_range($attr, 'imgWidth', 'height', 'Mobile', null, '!important');

	$css->set_selector(
    ".{$unique_id} .premium-button:hover .premium-button-icon, " .
    ".{$unique_id} .premium-button:hover .premium-button-svg-class svg, " .
    ".{$unique_id} .premium-button:hover .premium-lottie-animation svg"
  );
  $css->pbg_render_background($attr, 'iconHoverBG', 'Mobile');
	
  $css->set_selector(
    ".{$unique_id} .premium-button .premium-button-icon, " .
    ".{$unique_id} .premium-button .premium-button-svg-class svg, " .
    ".{$unique_id} .premium-button .premium-lottie-animation svg"
  );
  $css->pbg_render_background($attr, 'iconBG', 'Mobile');

	$css->set_selector(
    ".{$unique_id} .premium-button .premium-button-icon, " .
    ".{$unique_id} .premium-button img, " .
    ".{$unique_id} .premium-button .premium-button-svg-class svg, " .
    ".{$unique_id} .premium-button .premium-lottie-animation svg"
  );
  $css->pbg_render_border($attr, 'iconBorder', 'Mobile');
  $css->pbg_render_spacing($attr, 'iconPadding', 'padding', "Mobile");
  $css->pbg_render_spacing($attr, 'iconMargin', 'margin', 'Mobile');

  $css->set_selector(
    ".{$unique_id} .premium-button .premium-button-icon svg, " .
    ".{$unique_id} .premium-button .premium-button-icon svg *"
  );
  $css->pbg_render_background($attr, 'iconBackground', 'Mobile');

	$css->stop_media_query();
	return $css->css_output();
}

/**
 * Renders the `premium/button` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_button($attributes, $content, $block)
{
	$block_helpers = pbg_blocks_helper();

	// Enqueue frontend JS/CSS.
	if ($block_helpers->it_is_not_amp()) {
		wp_enqueue_script(
			'pbg-button',
			PREMIUM_BLOCKS_URL . 'assets/js/minified/button.min.js',
			array(),
			PREMIUM_BLOCKS_VERSION,
			true
		);
	}

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
 * Register the button block.
 *
 * @uses render_block_pbg_button()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_button()
{
	register_block_type(
		'premium/button',
		array(
			'render_callback' => 'render_block_pbg_button',
			'editor_style'    => 'premium-blocks-editor-css',
			'editor_script'   => 'pbg-blocks-js',
		)
	);
}

register_block_pbg_button();
