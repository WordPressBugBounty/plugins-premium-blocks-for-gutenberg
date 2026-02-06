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

  $effect = $css->pbg_get_value($attr, 'effect');

  $css->set_selector( $unique_id );
  $css->pbg_render_color( $attr, 'sepColor', '--pbg-banner-sep-color' );
  $css->pbg_render_range( $attr, 'sepSize', '--pbg-banner-sep-size', '', '', 'px' );

	// Separator color for effect3
	$css->set_selector( $unique_id . ' .premium-banner__effect3 .premium-banner__title_wrap::after' );
	$css->pbg_render_color( $attr, 'sepColor', 'background-color' );

	// Background overlay
	$css->set_selector( $unique_id . ' .premium-banner__inner .premium-banner__bg-overlay' );
	$css->pbg_render_color( $attr, 'background', 'background-color' );

	// Hover background overlay
	$css->set_selector( $unique_id . ' .premium-banner__inner:hover .premium-banner__bg-overlay' );
	$css->pbg_render_color( $attr, 'hoverBackground', 'background-color');

	// Banner wrapper - Padding
	$css->set_selector( $unique_id . ' .premium-banner' );
	$css->pbg_render_spacing( $attr, 'padding', 'padding', 'Desktop' );

	// Banner inner container 
	$css->set_selector( $unique_id . ' .premium-banner__inner' );
	$css->pbg_render_border( $attr, 'border', 'Desktop' );
	$css->pbg_render_shadow( $attr, 'containerShadow', 'box-shadow' );

	// Image
	$css->set_selector( $unique_id . ' .premium-banner__img_wrap .premium-banner__img' );
  $css->pbg_render_range( $attr, 'customHeight', 'height', 'Desktop' );
	$css->pbg_render_filters( $attr, 'filter' );

	// Content background
	$css->set_selector( $unique_id . ' .premium-banner__inner .premium-banner__content' );
  if ( $effect === 'effect2' ){
    $css->pbg_render_color( $attr, 'titleStyles[0].titleBack', 'background-color', '', '!important' );
  } else { 
    $css->add_property( 'background-color', 'transparent !important' );
  }
	
	// Title wrapper - Text align
	$css->set_selector( $unique_id . ' .premium-banner__title_wrap' );
	$css->pbg_render_text_align( $attr, 'contentAlign', 'text-align', 'Desktop' );

	// Title - Typography, color, and shadow
	$css->set_selector( $unique_id . ' .premium-banner__title_wrap .premium-banner__title' );
	$css->pbg_render_typography( $attr, 'titleTypography', 'Desktop' );
	$css->pbg_render_color( $attr, 'titleStyles[0].titleColor', 'color' );
	$css->pbg_render_shadow( $attr, 'titleTextShadow', 'text-shadow' );
  $css->pbg_render_spacing( $attr, 'titleMargin', 'margin', 'Desktop' );

	// Description wrapper - Text align
	$css->set_selector( $unique_id . ' .premium-banner__desc_wrap' );
	$css->pbg_render_text_align( $attr, 'contentAlign', 'text-align', 'Desktop' );

	// Description - Typography, color, and shadow
	$css->set_selector( $unique_id . ' .premium-banner__desc_wrap .premium-banner__desc' );
	$css->pbg_render_typography( $attr, 'descTypography', 'Desktop' );
	$css->pbg_render_color( $attr, 'descStyles[0].descColor', 'color' );
	$css->pbg_render_shadow( $attr, 'descTextShadow', 'text-shadow' );
  $css->pbg_render_spacing( $attr, 'descMargin', 'margin', 'Desktop' );

	// Tablet Styles
	$css->start_media_query( 'tablet' );

	// Banner wrapper - Padding
	$css->set_selector( $unique_id . ' .premium-banner' );
	$css->pbg_render_spacing( $attr, 'padding', 'padding', 'Tablet' );

	// Banner inner container
	$css->set_selector( $unique_id . ' .premium-banner__inner' );
	$css->pbg_render_border( $attr, 'border', 'Tablet' );

  // Image
	$css->set_selector( $unique_id . ' .premium-banner__img_wrap .premium-banner__img' );
  $css->pbg_render_range( $attr, 'customHeight', 'height', 'Tablet' );

	// Title wrapper - Text align
	$css->set_selector( $unique_id . ' .premium-banner__title_wrap' );
	$css->pbg_render_text_align( $attr, 'contentAlign', 'text-align', 'Tablet' );

	// Title - Typography
	$css->set_selector( $unique_id . ' .premium-banner__title_wrap .premium-banner__title' );
	$css->pbg_render_typography( $attr, 'titleTypography', 'Tablet' );
  $css->pbg_render_spacing( $attr, 'titleMargin', 'margin', 'Tablet' );

	// Description wrapper - Text align
	$css->set_selector( $unique_id . ' .premium-banner__desc_wrap' );
	$css->pbg_render_text_align( $attr, 'contentAlign', 'text-align', 'Tablet' );

	// Description - Typography
	$css->set_selector( $unique_id . ' .premium-banner__desc_wrap .premium-banner__desc' );
	$css->pbg_render_typography( $attr, 'descTypography', 'Tablet' );
  $css->pbg_render_spacing( $attr, 'descMargin', 'margin', 'Tablet' );

	$css->stop_media_query();

	// Mobile Styles
	$css->start_media_query( 'mobile' );

	// Banner wrapper - Padding
	$css->set_selector( $unique_id . ' .premium-banner' );
	$css->pbg_render_spacing( $attr, 'padding', 'padding', 'Mobile' );

	// Banner inner container
	$css->set_selector( $unique_id . ' .premium-banner__inner' );
	$css->pbg_render_border( $attr, 'border', 'Mobile' );

  // Image
	$css->set_selector( $unique_id . ' .premium-banner__img_wrap .premium-banner__img' );
  $css->pbg_render_range( $attr, 'customHeight', 'height', 'Mobile' );

	// Title wrapper - Text align
	$css->set_selector( $unique_id . ' .premium-banner__title_wrap' );
	$css->pbg_render_text_align( $attr, 'contentAlign', 'text-align', 'Mobile' );

	// Title - Typography
	$css->set_selector( $unique_id . ' .premium-banner__title_wrap .premium-banner__title' );
	$css->pbg_render_typography( $attr, 'titleTypography', 'Mobile' );
  $css->pbg_render_spacing( $attr, 'titleMargin', 'margin', 'Mobile' );

	// Description wrapper - Text align
	$css->set_selector( $unique_id . ' .premium-banner__desc_wrap' );
	$css->pbg_render_text_align( $attr, 'contentAlign', 'text-align', 'Mobile' );

	// Description - Typography
	$css->set_selector( $unique_id . ' .premium-banner__desc_wrap .premium-banner__desc' );
	$css->pbg_render_typography( $attr, 'descTypography', 'Mobile' );
  $css->pbg_render_spacing( $attr, 'descMargin', 'margin', 'Mobile' );

	$css->stop_media_query();

	return $css->css_output();
}

/**
 * Get Media Css.
 *
 * @return void
 */
function get_premium_banner_media_css(){
  $media_css = array('desktop' => '', 'tablet' => '', 'mobile' => '');
  
  $media_css['mobile'] .= "
    .premium-banner__responsive_true .premium-banner__desc_wrap {
      display: none;
    }
  ";

  return $media_css;
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
