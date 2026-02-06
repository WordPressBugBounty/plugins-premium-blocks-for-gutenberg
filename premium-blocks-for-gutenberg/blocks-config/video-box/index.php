<?php
/**
 * Server-side rendering of the `pbg/video-box` block.
 *
 * @package WordPress
 */

/**
 * Get Video Box Block CSS
 *
 * Return Frontend CSS for Video Box.
 *
 * @access public
 *
 * @param string $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_video_box_css_style( $attr, $unique_id ) {
	$css = new Premium_Blocks_css();

	// Desktop Styles

	// Video Box Container
	$css->set_selector( '.' . $unique_id );
	$css->pbg_render_border( $attr, 'boxBorder', 'Desktop' );
	$css->pbg_render_shadow( $attr, 'boxShadow', 'box-shadow' );

	// Play Icon Container
	$css->set_selector( '.' . $unique_id . ' .premium-video-box__play' );
	$css->pbg_render_border( $attr, 'playBorder', 'Desktop' );
	$css->pbg_render_spacing( $attr, 'playPadding', 'padding', 'Desktop' );
	$css->pbg_render_range( $attr, 'playStyles[0].playTop', 'top', '', '', '%' );
	$css->pbg_render_color( $attr, 'playStyles[0].playBack', 'background-color' );

	// Play Icon SVG
	$css->set_selector( '.' . $unique_id . ' .premium-video-box__play svg' );
	$css->pbg_render_range( $attr, 'playStyles[0].playSize', 'width', '', '', 'px' );
	$css->pbg_render_range( $attr, 'playStyles[0].playSize', 'height', '', '', 'px' );
	$css->pbg_render_color( $attr, 'playStyles[0].playColor', 'color' );
	$css->pbg_render_color( $attr, 'playStyles[0].playColor', 'fill' );

	// Play Icon Hover
	$css->set_selector( '.' . $unique_id . ' .premium-video-box__play:hover' );
	$css->pbg_render_color( $attr, 'playStyles[0].playHoverBackColor', 'background-color' );

	$css->set_selector( '.' . $unique_id . ' .premium-video-box__play:hover svg' );
	$css->pbg_render_color( $attr, 'playStyles[0].playHoverColor', 'color' );
	$css->pbg_render_color( $attr, 'playStyles[0].playHoverColor', 'fill' );

	// Overlay
	$css->set_selector( '.' . $unique_id . ' .premium-video-box__overlay, .' . $unique_id . ' .premium-video-box-image-container-block' );
	$css->pbg_render_filters( $attr, 'overlayFilter' );

	// Overlay with custom image
	$overlay_img_url = $css->pbg_get_value( $attr, 'overlayStyles[0].overlayImgURL' );
	if ( $overlay_img_url ) {
		$css->set_selector( '.' . $unique_id . ' .premium-video-box__overlay:not(.premium-video-box__overlay-image)' );
		$css->add_property( 'background-image', 'url(' . $overlay_img_url . ')' );
	}

	// Overlay with thumbnail (fallback)
	$thumbnail_src = $css->pbg_get_value( $attr, 'thumbnailSrc' );
	if ( $thumbnail_src ) {
		$css->set_selector( '.' . $unique_id . ' .premium-video-box__overlay-image' );
		$css->add_property( 'background-image', 'url(' . $thumbnail_src . ')' );
	}

	// Video Description Container
	$css->set_selector( '.' . $unique_id . ' .premium-video-box__desc' );
	$css->pbg_render_color( $attr, 'descStyles[0].videoDescBack', 'background-color' );
  $css->pbg_render_range( $attr, 'verticalPos', 'top', 'Desktop' );
	$css->pbg_render_spacing( $attr, 'descPadding', 'padding', 'Desktop' );

	// Video Description Text
	$css->set_selector( '.' . $unique_id . ' .premium-video-box__desc .premium-video-box__desc_text' );
	$css->pbg_render_typography( $attr, 'videoDescTypography', 'Desktop' );
	$css->pbg_render_color( $attr, 'descStyles[0].videoDescColor', 'color' );
	$css->pbg_render_shadow( $attr, 'descShadow', 'text-shadow' );

	// Video Caption Container
	$css->set_selector( '.' . $unique_id . ' .premium-video-box__caption' );
	$css->pbg_render_spacing( $attr, 'captionPadding', 'padding', 'Desktop' );
	$css->pbg_render_color( $attr, 'captionBackColor', 'background-color' );

	// Video Caption Text
	$css->set_selector( '.' . $unique_id . ' .premium-video-box__caption .premium-video-box__caption_text' );
	$css->pbg_render_typography( $attr, 'videoCaptionTypography', 'Desktop' );
	$css->pbg_render_color( $attr, 'captionColor', 'color' );
	$css->pbg_render_shadow( $attr, 'captionShadow', 'text-shadow' );

	// Tablet Styles
	$css->start_media_query( 'tablet' );

	// Video Box Container
	$css->set_selector( '.' . $unique_id );
	$css->pbg_render_border( $attr, 'boxBorder', 'Tablet' );

	// Play Icon
	$css->set_selector( '.' . $unique_id . ' .premium-video-box__play' );
	$css->pbg_render_border( $attr, 'playBorder', 'Tablet' );
	$css->pbg_render_spacing( $attr, 'playPadding', 'padding', 'Tablet' );

	// Video Description
	$css->set_selector( '.' . $unique_id . ' .premium-video-box__desc' );
  $css->pbg_render_range( $attr, 'verticalPos', 'top', 'Tablet' );
	$css->pbg_render_spacing( $attr, 'descPadding', 'padding', 'Tablet' );

	$css->set_selector( '.' . $unique_id . ' .premium-video-box__desc .premium-video-box__desc_text' );
	$css->pbg_render_typography( $attr, 'videoDescTypography', 'Tablet' );

	// Video Caption
	$css->set_selector( '.' . $unique_id . ' .premium-video-box__caption' );
	$css->pbg_render_spacing( $attr, 'captionPadding', 'padding', 'Tablet' );

	$css->set_selector( '.' . $unique_id . ' .premium-video-box__caption .premium-video-box__caption_text' );
	$css->pbg_render_typography( $attr, 'videoCaptionTypography', 'Tablet' );

	$css->stop_media_query();

	// Mobile Styles
	$css->start_media_query( 'mobile' );

	// Video Box Container
	$css->set_selector( '.' . $unique_id );
	$css->pbg_render_border( $attr, 'boxBorder', 'Mobile' );

	// Play Icon
	$css->set_selector( '.' . $unique_id . ' .premium-video-box__play' );
	$css->pbg_render_border( $attr, 'playBorder', 'Mobile' );
	$css->pbg_render_spacing( $attr, 'playPadding', 'padding', 'Mobile' );

	// Video Description
	$css->set_selector( '.' . $unique_id . ' .premium-video-box__desc' );
  $css->pbg_render_range( $attr, 'verticalPos', 'top', 'Mobile' );
	$css->pbg_render_spacing( $attr, 'descPadding', 'padding', 'Mobile' );

	$css->set_selector( '.' . $unique_id . ' .premium-video-box__desc .premium-video-box__desc_text' );
	$css->pbg_render_typography( $attr, 'videoDescTypography', 'Mobile' );

	// Video Caption
	$css->set_selector( '.' . $unique_id . ' .premium-video-box__caption' );
	$css->pbg_render_spacing( $attr, 'captionPadding', 'padding', 'Mobile' );

	$css->set_selector( '.' . $unique_id . ' .premium-video-box__caption .premium-video-box__caption_text' );
	$css->pbg_render_typography( $attr, 'videoCaptionTypography', 'Mobile' );

	$css->stop_media_query();
	return $css->css_output();
}

/**
 * Renders the `premium/video-box` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_video_box( $attributes, $content, $block ) {
	$block_helpers = pbg_blocks_helper();

	if ( $block_helpers->it_is_not_amp() ) {
		wp_enqueue_script(
			'pbg-video-box',
			PREMIUM_BLOCKS_URL . 'assets/js/minified/video-box.min.js',
			array(),
			PREMIUM_BLOCKS_VERSION,
			true
		);
	}

	return $content;
}

/**
 * Register the video_box block.
 *
 * @uses render_block_pbg_video_box()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_video_box() {
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	register_block_type(
		PREMIUM_BLOCKS_PATH . '/blocks-config/video-box',
		array(
			'render_callback' => 'render_block_pbg_video_box',
		)
	);
}

register_block_pbg_video_box();