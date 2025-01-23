<?php
// Move this file to "blocks-config" folder with name "image.php".

/**
 * Server-side rendering of the `premium/image` block.
 *
 * @package WordPress
 */

function get_premium_image_css( $attr, $unique_id ) {
	$css = new Premium_Blocks_css();

	// Desktop Styles.
	if ( isset( $attr['imageBorder'] ) ) {
		$image_border        = $attr['imageBorder'];
		$image_border_width  = $image_border['borderWidth'];
		$image_border_radius = $image_border['borderRadius'];

		$css->set_selector( '.' . $unique_id . ' > .premium-image-container' . ' > .premium-image-wrap' );
		$css->add_property( 'border-style', $css->render_string( $image_border['borderType'], ' !important' ) );
		if(isset($image_border['borderColor'])){
			$css->add_property( 'border-color', $css->render_string( $image_border['borderColor'], ' !important' ) );
		}
		$css->add_property( 'border-radius', $css->render_spacing( $image_border_radius['Desktop'], 'px' ) );
		$css->add_property( 'border-width', $css->render_spacing( $image_border_width['Desktop'], 'px' ) );
	}

	if(isset($attr['maskShape']) && $attr['maskShape'] !== "none"){

		$image_path= PREMIUM_BLOCKS_URL . 'assets/icons/masks/'. $attr['maskShape'] . '.svg';
		if($attr['maskShape'] === "custom" && isset($attr['maskCustomShape'])){
			$image_path=$attr['maskCustomShape']['url'];
		}
		$css->set_selector( '.' . $unique_id . ' > .premium-image-container' . ' > .premium-image-wrap  img , ' . '.' . $unique_id . ' > .premium-image-container' . ' .premium-image-overlay');
		
		$css->add_property( 'mask-image','url('. $image_path . ')' );
		$css->add_property( '-webkit-mask-image','url('. $image_path . ')' );

		$css->add_property( 'mask-size',isset($attr['maskSize'])? $attr['maskSize']:"contain" );
		$css->add_property( '-webkit-mask-size',isset($attr['maskSize'])? $attr['maskSize']:"contain");	
	
		$css->add_property( 'mask-repeat',isset($attr['maskRepeat'])?$attr['maskRepeat']:'no-repeat' );
		$css->add_property( '-webkit-mask-repeat', isset($attr['maskRepeat'])?$attr['maskRepeat']:'no-repeat' );	
	
		$css->add_property( 'mask-position',isset($attr['maskPosition'])?$attr['maskPosition']:"center center" );
		$css->add_property( '-webkit-mask-position',isset($attr['maskPosition'])?$attr['maskPosition']:"center center" );	
		
		
	}

	if(isset($attr['imgOpacity'])){
		$css->set_selector( '.' . $unique_id . ' > .premium-image-container' . ' > .premium-image-wrap' . ' > img' );
		$css->add_property( 'opacity', isset( $attr['imgOpacity'] ) ? $attr['imgOpacity'] / 100 : 1 );
	}


	if(isset($attr['overlayColor'])){
		$css->set_selector( '.' . $unique_id . ' > .premium-image-container' . '  .premium-image-overlay' );
		$css->add_property( 'background-color', $css->render_color($attr['overlayColor']) );
	}

	if(isset($attr['overlayColorHover'])){
		$css->set_selector( '.' . $unique_id . ' > .premium-image-container:hover' . '  .premium-image-overlay' );
		$css->add_property( 'background-color', $css->render_color($attr['overlayColorHover']) );
	}

	if(isset($attr['imgOpacityHover'])){
		$css->set_selector( '.' . $unique_id . ' > .premium-image-container' . ' > .premium-image-wrap:hover' . ' > img' );
		$css->add_property( 'opacity', isset( $attr['imgOpacityHover'] ) ? $attr['imgOpacityHover'] / 100 : "" );
	}

	if ( isset( $attr['boxShadow'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-image-container' . ' > .premium-image-wrap'  );
        $css->add_property( 'box-shadow', $css->render_shadow( $attr['boxShadow'] ));
    }
	if ( isset( $attr['imgHeight'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-image-container' . ' > .premium-image-wrap' . ' > img' );
		$css->add_property( 'height', $css->render_range( $attr['imgHeight'], 'Desktop' ) );
	}

	if ( isset( $attr['imgWidth'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-image-container' . ' > .premium-image-wrap' . ' > img' );
		$css->add_property( 'width', $css->render_range( $attr['imgWidth'], 'Desktop' ) );
	}

	if ( isset( $attr['imageFilter'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-image-container' . ' > .premium-image-wrap' . ' > img' );
		$css->add_property( 'filter', $css->render_filter( $attr['imageFilter'] ) );
	}

	if ( isset( $attr['align'] ) ) {
		$css->set_selector( '.' . $unique_id . '.premium-image .premium-image-container' );
		$css->add_property( 'justify-content', $css->get_responsive_css( $attr['align'], 'Desktop' ) );
	}
    if ( isset( $attr['align'] ) ) {
		$css->set_selector( '.' . $unique_id );
		$css->add_property( 'align-self', $css->get_responsive_css( $attr['align'], 'Desktop' ) );
	}

	if ( isset( $attr['captionAlign'] ) ) {
		$css->set_selector( '.' . $unique_id . '  .premium-image-caption' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['captionAlign'], 'Desktop' ) );
	}

	if(isset($attr['captionTypography'])){
		$css->set_selector( '.' . $unique_id . '  .premium-image-caption' );
		$css->render_typography( $attr['captionTypography'], 'Desktop' );
	}
	if(isset($attr['captionColor'])){
		$css->set_selector( '.' . $unique_id . '  .premium-image-caption' );
		$css->add_property( "color",	 $css->render_color( $attr['captionColor']));
	}
	if(isset($attr['captionPadding'])){
		$caption_padding = $attr['captionPadding'];

		$css->set_selector( '.' . $unique_id . '  .premium-image-caption' );
		$css->add_property( 'padding', $css->render_spacing( $caption_padding['Desktop'], $caption_padding['unit']['Desktop'] ) );
	}
	if(isset($attr['captionMargin'])){
		$caption_margin = $attr['captionMargin'];

		$css->set_selector( '.' . $unique_id . '  .premium-image-caption' );
		$css->add_property( 'margin', $css->render_spacing( $caption_margin['Desktop'], $caption_margin['unit']['Desktop'] ) );
	}

	if(isset($attr['padding'])){
		$padding = $attr['padding'];
		$css->set_selector( '.' . $unique_id  );
		$css->add_property( 'padding', $css->render_spacing( $padding['Desktop'], $padding['unit']['Desktop'] ) );
	}
	if(isset($attr['margin'])){
		$margin = $attr['margin'];
		$css->set_selector( '.' . $unique_id  );
		$css->add_property( 'margin', $css->render_spacing( $margin['Desktop'], $margin['unit']['Desktop'] ) );
	}


	$css->start_media_query( 'tablet' );
	// // Tablet Styles.
	if ( isset( $attr['imageBorder'] ) ) {
		$image_border        = $attr['imageBorder'];
		$image_border_width  = $image_border['borderWidth'];
		$image_border_radius = $image_border['borderRadius'];

		$css->set_selector( '.' . $unique_id . ' > .premium-image-container' . ' > .premium-image-wrap'  );
		$css->add_property( 'border-radius', $css->render_spacing( $image_border_radius['Tablet'], 'px' ) );
		$css->add_property( 'border-width', $css->render_spacing( $image_border_width['Tablet'], 'px' ) );
	}
	if ( isset( $attr['imgHeight'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-image-container' . ' > .premium-image-wrap' . ' > img' );
		$css->add_property( 'height', $css->render_range( $attr['imgHeight'], 'Tablet' ) );
	}
	if ( isset( $attr['imgWidth'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-image-container' . ' > .premium-image-wrap' . ' > img' );
		$css->add_property( 'width', $css->render_range( $attr['imgWidth'], 'Tablet' ) );
	}

	if ( isset( $attr['align'] ) ) {
		$css->set_selector( '.' . $unique_id . '.premium-image .premium-image-container' );
		$css->add_property( 'justify-content', $css->get_responsive_css( $attr['align'], 'Tablet' ) );
	}
    if ( isset( $attr['align'] ) ) {
		$css->set_selector( '.' . $unique_id );
		$css->add_property( 'align-self', $css->get_responsive_css( $attr['align'], 'Tablet' ) );
	}

	if(isset($attr['captionTypography'])){
		$css->set_selector( '.' . $unique_id . ' .premium-image-caption' );
		$css->render_typography( $attr['captionTypography'], 'Tablet' );
	}
	if(isset($attr['captionPadding'])){
		$caption_padding = $attr['captionPadding'];

		$css->set_selector( '.' . $unique_id . '  .premium-image-caption' );
		$css->add_property( 'padding', $css->render_spacing( $caption_padding['Tablet'], $caption_padding['unit']['Tablet'] ) );
	}
	if(isset($attr['captionMargin'])){
		$caption_margin = $attr['captionMargin'];

		$css->set_selector( '.' . $unique_id . ' .premium-image-caption' );
		$css->add_property( 'margin', $css->render_spacing( $caption_margin['Tablet'], $caption_margin['unit']['Tablet'] ) );
	}

	if ( isset( $attr['captionAlign'] ) ) {
		$css->set_selector( '.' . $unique_id . '  .premium-image-caption' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['captionAlign'], 'Tablet' ) );
	}

	if(isset($attr['padding'])){
		$padding = $attr['padding'];
		$css->set_selector( '.' . $unique_id  );
		$css->add_property( 'padding', $css->render_spacing( $padding['Tablet'], $padding['unit']['Tablet'] ) );
	}
	if(isset($attr['margin'])){
		$margin = $attr['margin'];
		$css->set_selector( '.' . $unique_id  );
		$css->add_property( 'margin', $css->render_spacing( $margin['Tablet'], $margin['unit']['Tablet'] ) );
	}


	$css->stop_media_query();
	$css->start_media_query( 'mobile' );
	// // Mobile Styles.
	if ( isset( $attr['imageBorder'] ) ) {
		$image_border        = $attr['imageBorder'];
		$image_border_width  = $image_border['borderWidth'];
		$image_border_radius = $image_border['borderRadius'];

		$css->set_selector( '.' . $unique_id . ' > .premium-image-container' . ' > .premium-image-wrap'  );
		$css->add_property( 'border-radius', $css->render_spacing( $image_border_radius['Mobile'], 'px' ) );
		$css->add_property( 'border-width', $css->render_spacing( $image_border_width['Mobile'], 'px' ) );
	}
	if ( isset( $attr['imgHeight'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-image-container' . ' > .premium-image-wrap' . ' > img' );
		$css->add_property( 'height', $css->render_range( $attr['imgHeight'], 'Mobile' ) );
	}
	if ( isset( $attr['imgWidth'] ) ) {
		$css->set_selector( '.' . $unique_id . ' > .premium-image-container' . ' > .premium-image-wrap' . ' > img' );
		$css->add_property( 'width', $css->render_range( $attr['imgWidth'], 'Mobile' ) );
	}

	if ( isset( $attr['align'] ) ) {
		$css->set_selector( '.' . $unique_id . '.premium-image .premium-image-container' );
		$css->add_property( 'justify-content', $css->get_responsive_css( $attr['align'], 'Mobile' ) );
	}

    if ( isset( $attr['align'] ) ) {
		$css->set_selector( '.' . $unique_id );
		$css->add_property( 'align-self', $css->get_responsive_css( $attr['align'], 'Mobile' ) );
	}

	if(isset($attr['captionTypography'])){
		$css->set_selector( '.' . $unique_id . ' .premium-image-caption' );
		$css->render_typography( $attr['captionTypography'], 'Mobile' );
	}
	if(isset($attr['captionPadding'])){
		$caption_padding = $attr['captionPadding'];

		$css->set_selector( '.' . $unique_id . ' .premium-image-caption' );
		$css->add_property( 'padding', $css->render_spacing( $caption_padding['Mobile'], $caption_padding['unit']['Mobile'] ) );
	}
	if(isset($attr['captionMargin'])){
		$caption_margin = $attr['captionMargin'];

		$css->set_selector( '.' . $unique_id . ' .premium-image-caption' );
		$css->add_property( 'margin', $css->render_spacing( $caption_margin['Mobile'], $caption_margin['unit']['Mobile'] ) );
	}

	if ( isset( $attr['captionAlign'] ) ) {
		$css->set_selector( '.' . $unique_id . '  .premium-image-caption' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['captionAlign'], 'Mobile' ) );
	}

	if(isset($attr['padding'])){
		$padding = $attr['padding'];
		$css->set_selector( '.' . $unique_id  );
		$css->add_property( 'padding', $css->render_spacing( $padding['Mobile'], $padding['unit']['Mobile'] ) );
	}
	if(isset($attr['margin'])){
		$margin = $attr['margin'];
		$css->set_selector( '.' . $unique_id  );
		$css->add_property( 'margin', $css->render_spacing( $margin['Mobile'], $margin['unit']['Mobile'] ) );
	}


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
function render_block_pbg_image( $attributes, $content, $block ) {

	return $content;
}


/**
 * Register the Price block.
 *
 * @uses render_block_pbg_image()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_image() {
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
