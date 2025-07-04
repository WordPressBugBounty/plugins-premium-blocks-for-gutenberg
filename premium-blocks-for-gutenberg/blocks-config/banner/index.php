<?php
/**
 * Server-side rendering of the `pbg/banner` block.
 *
 * @package WordPress
 */

/**
 * Get Banner Block CSS
 *
 * Return Frontend CSS for Banner.
 *
 * @access public
 *
 * @param string $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_banner_css_style( $attr, $unique_id ) {
	$css = new Premium_Blocks_css();

	if ( isset( $attr['sepColor'] ) ) {
		$css->set_selector( $unique_id . ' .premium-banner__effect3 .premium-banner__title_wrap::after' );
		$css->add_property( 'background-color', $css->render_color( $attr['sepColor'] ) );
	}

	if ( isset( $attr['hoverBackground'] ) ) {
		$css->set_selector( $unique_id . ' .premium-banner__inner:hover .premium-banner__bg-overlay' );
		$css->add_property( 'background-color', $css->render_color( $attr['hoverBackground'] ) );
	}
	// Style.
	if ( isset( $attr['contentAlign'] ) ) {
		$css->set_selector( $unique_id . ' .premium-banner__inner' . ' > .premium-banner__content' . ' > .premium-banner__title_wrap' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['contentAlign'], 'Desktop' ) );
		$css->set_selector( $unique_id . ' .premium-banner__inner' . ' > .premium-banner__content' . ' > .premium-banner__desc_wrap' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['contentAlign'], 'Desktop' ) );
	}

  $css->set_selector( $unique_id . ' .premium-banner__inner' . ' > .premium-banner__content' . ' > .premium-banner__title_wrap' . ' > .premium-banner__title' );
  $css->pbg_render_typography($attr, 'titleTypography', 'Desktop');
	// Desc Style
  $css->set_selector( $unique_id . ' .premium-banner__inner' . ' > .premium-banner__content' . ' > .premium-banner__desc_wrap' . ' > .premium-banner__desc' );
  $css->pbg_render_typography($attr, 'descTypography', 'Desktop');
	// Container Style
	if ( isset( $attr['padding'] ) ) {
		$padding = $attr['padding'];
		$css->set_selector( $unique_id . ' .premium-banner' );
		$css->add_property( 'padding', $css->render_spacing( $padding['Desktop'],isset( $padding['unit']['Desktop'])?$padding['unit']['Desktop']:$padding['unit'] ) );
	}

	if ( isset( $attr['border'] ) ) {
		$border        = $attr['border'];
		$border_width  = $border['borderWidth'];
		$border_radius = $border['borderRadius'];

		$css->set_selector( $unique_id . '  .premium-banner__inner' );
		$css->add_property( 'border-width', $css->render_spacing( $border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $border_radius['Desktop'], 'px' ) );
	}

	$css->start_media_query( 'tablet' );

	if ( isset( $attr['contentAlign'] ) ) {
		$css->set_selector( $unique_id . ' .premium-banner__inner' . ' > .premium-banner__content' . ' > .premium-banner__title_wrap' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['contentAlign'], 'Tablet' ) );
		$css->set_selector( $unique_id . ' .premium-banner__inner' . ' > .premium-banner__content' . ' > .premium-banner__desc_wrap' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['contentAlign'], 'Tablet' ) );
	}

	$css->set_selector( $unique_id . ' .premium-banner__inner' . ' > .premium-banner__content' . ' > .premium-banner__title_wrap' . ' > .premium-banner__title' );
  $css->pbg_render_typography($attr, 'titleTypography', 'Tablet');
	// Desc Style
	$css->set_selector( $unique_id . ' .premium-banner__inner' . ' > .premium-banner__content' . ' > .premium-banner__desc_wrap' . ' > .premium-banner__desc' );
  $css->pbg_render_typography($attr, 'descTypography', 'Tablet');
	// Container Style
	if ( isset( $attr['padding'] ) ) {
		$padding = $attr['padding'];
		$css->set_selector( $unique_id );
		$css->add_property( 'padding', $css->render_spacing( $padding['Tablet'], isset($padding['unit']['Tablet'])?$padding['unit']['Tablet']:$padding['unit'] ) );
	}

	if ( isset( $attr['border'] ) ) {
		$border        = $attr['border'];
		$border_width  = $border['borderWidth'];
		$border_radius = $border['borderRadius'];

		$css->set_selector( $unique_id . ' .premium-banner__inner' );
		$css->add_property( 'border-width', $css->render_spacing( $border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $border_radius['Tablet'], 'px' ) );
	}

	$css->stop_media_query();

	$css->start_media_query( 'mobile' );

	if ( isset( $attr['contentAlign'] ) ) {
		$css->set_selector( $unique_id . ' .premium-banner__inner' . ' > .premium-banner__content' . ' > .premium-banner__title_wrap' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['contentAlign'], 'Mobile' ) );
		$css->set_selector( $unique_id . ' .premium-banner__inner' . ' > .premium-banner__content' . ' > .premium-banner__desc_wrap' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['contentAlign'], 'Mobile' ) );
	}

	$css->set_selector( $unique_id . ' .premium-banner__inner' . ' > .premium-banner__content' . ' > .premium-banner__title_wrap' . ' > .premium-banner__title' );
  $css->pbg_render_typography($attr, 'titleTypography', 'Mobile');
	// Desc Style
	$css->set_selector( $unique_id . ' .premium-banner__inner' . ' > .premium-banner__content' . ' > .premium-banner__desc_wrap' . ' > .premium-banner__desc' );
  $css->pbg_render_typography($attr, 'descTypography', 'Mobile');
	// Container Style
	if ( isset( $attr['padding'] ) ) {
		$padding = $attr['padding'];
		$css->set_selector( $unique_id );
		$css->add_property( 'padding', $css->render_spacing( $padding['Mobile'], isset($padding['unit']['Mobile'])?$padding['unit']['Mobile']:$padding['unit'] ) );
	}

	if ( isset( $attr['border'] ) ) {
		$border        = $attr['border'];
		$border_width  = $border['borderWidth'];
		$border_radius = $border['borderRadius'];

		$css->set_selector( $unique_id . ' .premium-banner__inner' );
		$css->add_property( 'border-width', $css->render_spacing( $border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $border_radius['Mobile'], 'px' ) );
	}

	$css->stop_media_query();
	return $css->css_output();
}

/**
 * Renders the `premium/banner` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_banner( $attributes, $content, $block ) {
  /* 
    Handling new feature of WordPress 6.7.2 --> sizes='auto' for old versions that doesn't contain wp-image-{$id} class.
    This workaround can be omitted after a few subsequent releases around 25/3/2025
  */
  
  if (false === stripos($content, '<img')) {
    return $content;
  }

  if (empty($attributes['imageID'])) {
    return $content;
  }

  $image_id = $attributes['imageID'];
  $image_tag = new WP_HTML_Tag_Processor($content);

  // Find our specific image
  if (!$image_tag->next_tag(['tag_name' => 'img', 'class_name' => "premium-banner__img"])) {
    return $content;
  }

  $image_classnames = $image_tag->get_attribute('class') ?? '';

  // Only process if wp-image class is missing
  if (!str_contains($image_classnames, "wp-image-{$image_id}")) {
    // Clean up responsive attributes
    $image_tag->remove_attribute('srcset');
    $image_tag->remove_attribute('sizes');

    // Add the wp-image class for automatically generate new srcset and sizes attributes
    $image_tag->add_class("wp-image-{$image_id}");
  }

  return $image_tag->get_updated_html();
}




/**
 * Register the banner block.
 *
 * @uses render_block_pbg_banner()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_banner() {
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	register_block_type(
		PREMIUM_BLOCKS_PATH . '/blocks-config/banner',
		array(
			'render_callback' => 'render_block_pbg_banner',
		)
	);
}

register_block_pbg_banner();
