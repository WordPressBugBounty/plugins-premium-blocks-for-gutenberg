<?php

/**
 * Server-side rendering of the `pbg/container` block.
 *
 * @package WordPress
 */

/**
 * Get Container Block CSS
 *
 * Return Frontend CSS for Container.
 *
 * @access public
 *
 * @param string $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_container_css_style( $attr, $unique_id ) {
     $css = new Premium_Blocks_css();

    $css->set_selector( '.wp-block-premium-container.premium-is-root-container.premium-container-' . $unique_id . '>  .premium-container-inner-blocks-wrap , .wp-block-premium-container.premium-is-root-container.premium-block-' . $unique_id . '>  .premium-container-inner-blocks-wrap' );
    if ( isset( $attr['minHeight'] ) ) {
        $css->add_property( 'min-height', $css->render_range( $attr['minHeight'], 'Desktop' ) );
    }
    if ( isset( $attr['direction'] ) ) {
        $css->add_property( 'flex-direction', $css->get_responsive_css( $attr['direction'], 'Desktop' ) );
    }
    if ( isset( $attr['alignItems'] ) ) {
        $css->add_property( 'align-items', $css->get_responsive_css( $attr['alignItems'], 'Desktop' ) );
    }
    if ( isset( $attr['justifyItems'] ) ) {
        $css->add_property( 'justify-content', $css->get_responsive_css( $attr['justifyItems'], 'Desktop' ) );
    }
    if ( isset( $attr['wrapItems'] ) ) {
        $css->add_property( 'flex-wrap', $css->get_responsive_css( $attr['wrapItems'], 'Desktop' ) );
    }
    if ( isset( $attr['alignContent'] ) ) {
        $css->add_property( 'align-content', $css->get_responsive_css( $attr['alignContent'], 'Desktop' ) );
    }

    // $css->add_property( 'row-gap', isset( $attr['rowGutter']['Desktop'] ) ? $attr['rowGutter']['Desktop'] . $attr['rowGutter']['unit'] : '20px' );

    // $css->add_property( 'column-gap', isset( $attr['columnGutter']['Desktop'] ) ? $attr['columnGutter']['Desktop'] . $attr['columnGutter']['unit'] : '20px' );
    $css->add_property( 'row-gap', isset( $attr['rowGutter']['Desktop'] ) ? $css->render_range( $attr['rowGutter'], 'Desktop' ) : '20px' );
    $css->add_property( 'column-gap', isset( $attr['columnGutter']['Desktop'] ) ? $css->render_range( $attr['columnGutter'], 'Desktop' ) : '20px' );

    $css->set_selector( '.wp-block-premium-container.premium-is-root-container  .premium-container-inner-blocks-wrap .premium-container-' . $unique_id . '  > .premium-container-inner-blocks-wrap , .wp-block-premium-container.premium-is-root-container  .premium-container-inner-blocks-wrap .premium-block-' . $unique_id . '  > .premium-container-inner-blocks-wrap , .premium-container-' . $unique_id . ' > .premium-container-inner-blocks-wrap' );

    if ( isset( $attr['minHeight'] ) ) {
        $css->add_property( 'min-height', $css->render_range( $attr['minHeight'], 'Desktop' ) );
    }
    if ( isset( $attr['direction'] ) ) {
        $css->add_property( 'flex-direction', $css->get_responsive_css( $attr['direction'], 'Desktop' ) );
    }
    if ( isset( $attr['alignItems'] ) ) {
        $css->add_property( 'align-items', $css->get_responsive_css( $attr['alignItems'], 'Desktop' ) );
    }
    if ( isset( $attr['justifyItems'] ) ) {
        $css->add_property( 'justify-content', $css->get_responsive_css( $attr['justifyItems'], 'Desktop' ) );
    }
    if ( isset( $attr['wrapItems'] ) ) {
        $css->add_property( 'flex-wrap', $css->get_responsive_css( $attr['wrapItems'], 'Desktop' ) );
    }
    if ( isset( $attr['alignContent'] ) ) {
        $css->add_property( 'align-content', $css->get_responsive_css( $attr['alignContent'], 'Desktop' ) );
    }
    // $css->add_property( 'row-gap', isset( $attr['rowGutter']['Desktop'] ) ? $attr['rowGutter']['Desktop'] . $attr['rowGutter']['unit'] : '20px' );
    $css->add_property( 'row-gap', isset( $attr['rowGutter']['Desktop'] ) ? $css->render_range( $attr['rowGutter'], 'Desktop' ) : '20px' );
    $css->add_property( 'column-gap', isset( $attr['columnGutter']['Desktop'] ) ? $css->render_range( $attr['columnGutter'], 'Desktop' ) : '20px' );

    // $css->add_property( 'column-gap', isset( $attr['columnGutter']['Desktop'] ) ? $attr['columnGutter']['Desktop'] . $attr['columnGutter']['unit'] : '20px' );
    if ( isset( $attr['colWidth'] ) ) {
        $css->set_selector( '.wp-block-premium-container.premium-is-root-container .premium-container-' . $unique_id .' , .wp-block-premium-container.premium-is-root-container .premium-block-' . $unique_id );
        $css->add_property( 'max-width', $css->render_range( $attr['colWidth'], 'Desktop' ) );
        $css->add_property( 'width', '100%' );
    }
    if ( isset( $attr['shapeTop'] ) ) {
        $css->set_selector( '.wp-block-premium-container.premium-container-' . $unique_id . ' > .premium-top-shape svg , .wp-block-premium-container.premium-block-' . $unique_id . ' > .premium-top-shape svg' );
        $css->add_property( 'fill', $css->render_color( $attr['shapeTop']['color'] ) );
        $css->add_property( 'width', $css->render_range( $attr['shapeTop']['width'], 'Desktop' ) );
        $css->add_property( 'height', $css->render_range( $attr['shapeTop']['height'], 'Desktop' ) );
    }
    if ( isset( $attr['shapeBottom'] ) ) {
        $css->set_selector( '.wp-block-premium-container.premium-container-' . $unique_id . ' > .premium-bottom-shape svg , .wp-block-premium-container.premium-block-' . $unique_id . ' > .premium-bottom-shape svg' );
        $css->add_property( 'fill', $css->render_color( $attr['shapeBottom']['color'] ) );

        $css->add_property( 'width', $css->render_range( $attr['shapeBottom']['width'], 'Desktop' ) );
        $css->add_property( 'height', $css->render_range( $attr['shapeBottom']['height'], 'Desktop' ) );
    }
    if ( isset( $attr['padding'] )  ) {
        $padding = $attr['padding'];
        $css->set_selector( '.wp-block-premium-container.premium-container-' . $unique_id . ' , .wp-block-premium-container.premium-block-' . $unique_id );
        $css->add_property( 'padding', $css->render_spacing( $padding['Desktop'], isset($padding['unit']['Desktop']) ?$padding['unit']['Desktop']:$padding['unit'] ) );
    }
  

    if ( isset( $attr['backgroundOptions'] ) ) {
        $css->set_selector( '.wp-block-premium-container.premium-container-' . $unique_id . ' , .wp-block-premium-container.premium-block-' . $unique_id );
        $css->render_background( $attr['backgroundOptions'], 'Desktop' );

    }
    if ( isset( $attr['margin'] ) &&  $attr['isBlockRootParent']===false ) {
        $margin = $attr['margin'];
        $css->set_selector( '.wp-block-premium-container.premium-container-' . $unique_id  . ' , .wp-block-premium-container.premium-block-' . $unique_id );
        $css->add_property( 'margin', $css->render_spacing( $margin['Desktop'], isset($margin['unit']['Desktop'])?$margin['unit']['Desktop']:$margin['unit']  ) );
    }
    if(isset( $attr['rootMarginTop'] ) &&  $attr['isBlockRootParent']===true){
        $css->set_selector( '.wp-block-premium-container.premium-is-root-container.premium-container-' . $unique_id . ' , .wp-block-premium-container.premium-is-root-container.premium-block-' . $unique_id );
        $css->add_property( 'margin-top',$css->render_range( $attr['rootMarginTop'], 'Desktop' ) );
        $css->add_property( 'margin-block-start',$css->render_range( $attr['rootMarginTop'], 'Desktop' ) );

    }


    if(isset( $attr['rootMarginBottom'] ) &&  $attr['isBlockRootParent']===true){
        $css->set_selector( '.wp-block-premium-container.premium-is-root-container.premium-container-' . $unique_id . ' , .wp-block-premium-container.premium-is-root-container.premium-block-' . $unique_id);
        $css->add_property( 'margin-Bottom', $css->render_range( $attr['rootMarginBottom'], 'Desktop' ) );
        $css->add_property( 'margin-Block-end', $css->render_range( $attr['rootMarginBottom'], 'Desktop' ));
  
    }
    if ( isset( $attr['border'] ) ) {
        $border        = $attr['border'];
        $border_width  = $border['borderWidth'];
        $border_radius = $border['borderRadius'];

        $css->set_selector( '.wp-block-premium-container.premium-container-' . $unique_id . ' , .wp-block-premium-container.premium-block-' . $unique_id );
        $css->add_property( 'border-width', $css->render_spacing( $border_width['Desktop'], 'px' ) );
        $css->add_property( 'border-radius', $css->render_spacing( $border_radius['Desktop'], 'px' ) );
        $css->add_property( 'border-color', $css->render_color( $border['borderColor'] ) );
        $css->add_property( 'border-style', $border['borderType']  );


    }
    if ( isset( $attr['borderHover'] )  && $attr['borderHover']['borderType'] !== "none") {
        $border        = $attr['borderHover'];
        $border_width  = $border['borderWidth'];
        $border_radius = $border['borderRadius'];

        $css->set_selector( '.wp-block-premium-container.premium-container-' . $unique_id . ':hover  , .wp-block-premium-container.premium-block-' . $unique_id . ':hover ');
        $css->add_property( 'border-width', $css->render_spacing( $border_width['Desktop'], 'px' ) );
        $css->add_property( 'border-radius', $css->render_spacing( $border_radius['Desktop'], 'px' ) );
        $css->add_property( 'border-color', $css->render_color( $border['borderColor'] ) );
        $css->add_property( 'border-style', $border['borderType']  );

    }
    if ( isset( $attr['backgroundOverlay'] ) ) {
        $css->set_selector( '.premium-container-' . $unique_id . '::before , .premium-block-' . $unique_id . '::before' );
        $css->render_background( $attr['backgroundOverlay'], 'Desktop' );
    }
    if ( isset( $attr['backgroundOverlayHover'] ) ) {
        $css->set_selector( '.premium-container-' . $unique_id . ':hover::before , .premium-block-' . $unique_id . ':hover::before' );
        $css->render_background( $attr['backgroundOverlayHover'], 'Desktop' );
    }
    if ( isset( $attr['overlayOpacity'] ) ) {
        $css->set_selector( '.premium-container-' . $unique_id . '::before , .premium-block-' . $unique_id . '::before ' );
        $css->add_property( 'opacity', isset( $attr['backgroundOverlay'] ) && ( $attr['backgroundOverlay']['backgroundType'] === 'solid' || $attr['backgroundOverlay']['backgroundType'] === 'gradient' ) ? $attr['overlayOpacity'] / 100 : 1 );
    }
    if ( isset( $attr['blend'] ) && ! empty( $attr['blend'] ) ) {
        $css->set_selector( '.premium-container-' . $unique_id . '::before , .premium-block-' . $unique_id . '::before ' );       
         $css->add_property( 'mix-blend-mode', $css->render_string( $attr['blend'], ' !important' ) );
    }
    if ( isset( $attr['overlayFilter'] ) ) {
        $css->set_selector( '.premium-container-' . $unique_id . '::before , .premium-block-' . $unique_id . '::before ' );    
            $css->add_property(
            'filter',
            'brightness(' . $attr['overlayFilter']['bright'] . '%)' . 'contrast(' . $attr['overlayFilter']['contrast'] . '%) ' . 'saturate(' . $attr['overlayFilter']['saturation'] . '%) ' . 'blur(' . $attr['overlayFilter']['blur'] . 'px) ' . 'hue-rotate(' . $attr['overlayFilter']['hue'] . 'deg)'
        );
    }
    if ( isset( $attr['transition'] ) && ! empty( $attr['transition'] ) ) {
        $css->set_selector( '.premium-container-' . $unique_id . '::before , .premium-block-' . $unique_id . '::before ' ); 
               $css->add_property( 'transition', $attr['transition'] . 's' );
        $css->add_property( '-webkit-transition', $attr['transition'] . 's' );
        $css->add_property( '-o-transition', $attr['transition'] . 's' );
    }
    if ( isset( $attr['hoverOverlayFilter'] ) ) {
        $css->set_selector( '.premium-container-' . $unique_id . ':hover::before , .premium-block-' . $unique_id . ':hover::before' );
        $css->add_property(
            'filter',
            'brightness(' . $attr['hoverOverlayFilter']['bright'] . '%)' . 'contrast(' . $attr['hoverOverlayFilter']['contrast'] . '%) ' . 'saturate(' . $attr['hoverOverlayFilter']['saturation'] . '%) ' . 'blur(' . $attr['hoverOverlayFilter']['blur'] . 'px) ' . 'hue-rotate(' . $attr['hoverOverlayFilter']['hue'] . 'deg)'
        );
    }
    if ( isset( $attr['hoverOverlayOpacity'] ) ) {
        $css->set_selector( '.premium-container-' . $unique_id . ':hover::before , .premium-block-' . $unique_id . ':hover::before' );
        $css->add_property( 'opacity', isset( $attr['backgroundOverlayHover'] ) && ( $attr['backgroundOverlayHover']['backgroundType'] === 'solid' || $attr['backgroundOverlayHover']['backgroundType'] === 'gradient' ) ? $attr['hoverOverlayOpacity'] / 100 : 1 );
    }
    $css->set_selector( '.wp-block-premium-container.premium-is-root-container.premium-container-' . $unique_id . ' .premium-container-inner-blocks-wrap , .wp-block-premium-container.premium-is-root-container.premium-block-' . $unique_id . ' .premium-container-inner-blocks-wrap' );
    $css->add_property( 'display', 'flex' );
    if ( isset( $attr['innerWidth'] ) && $attr['innerWidthType'] === 'boxed' ) {
        $css->set_selector( '.wp-block-premium-container.premium-is-root-container.premium-container-' . $unique_id . ' .premium-container-inner-blocks-wrap , .wp-block-premium-container.premium-is-root-container.premium-block-' . $unique_id . ' .premium-container-inner-blocks-wrap' );
        $css->add_property( '--inner-content-custom-width', 'min(100vw,  ' . $attr['innerWidth'] . 'px)' );
        $css->add_property( 'max-width', 'var(--inner-content-custom-width)' );
        $css->add_property( 'margin-left', 'auto' );
        $css->add_property( 'margin-right', 'auto' );

    }

    $css->start_media_query( 'tablet' );

    $css->set_selector( '.wp-block-premium-container.premium-is-root-container.premium-container-' . $unique_id . '>  .premium-container-inner-blocks-wrap , .wp-block-premium-container.premium-is-root-container.premium-block-' . $unique_id . '>  .premium-container-inner-blocks-wrap' );
    if ( isset( $attr['minHeight'] ) ) {
        $css->add_property( 'min-height', $css->render_range( $attr['minHeight'], 'Tablet' ) );
    }
    if ( isset( $attr['direction'] ) ) {
        $css->add_property( 'flex-direction', $css->get_responsive_css( $attr['direction'], 'Tablet' ) );
    }
    if ( isset( $attr['alignItems'] ) ) {
        $css->add_property( 'align-items', $css->get_responsive_css( $attr['alignItems'], 'Tablet' ) );
    }
    if ( isset( $attr['justifyItems'] ) ) {
        $css->add_property( 'justify-content', $css->get_responsive_css( $attr['justifyItems'], 'Tablet' ) );
    }
    if ( isset( $attr['wrapItems'] ) ) {
        $css->add_property( 'flex-wrap', $css->get_responsive_css( $attr['wrapItems'], 'Tablet' ) );
    }
    if ( isset( $attr['alignContent'] ) ) {
        $css->add_property( 'align-content', $css->get_responsive_css( $attr['alignContent'], 'Tablet' ) );
    }
    // $css->add_property( 'row-gap', isset( $attr['rowGutter']['Tablet'] ) ? $attr['rowGutter']['Tablet'] . $attr['rowGutter']['unit'] : '20px' );
    // $css->add_property( 'column-gap', isset( $attr['rowGutter']['Tablet'] ) ? $attr['columnGutter']['Tablet'] . $attr['columnGutter']['unit'] : '20px' );
    $css->add_property( 'row-gap', isset( $attr['rowGutter']['Tablet'] ) ? $css->render_range( $attr['rowGutter'], 'Tablet' ) : '20px' );
    $css->add_property( 'column-gap', isset( $attr['columnGutter']['Tablet'] ) ? $css->render_range( $attr['columnGutter'], 'Tablet' ) : '20px' );

    $css->set_selector( '.wp-block-premium-container.premium-is-root-container  .premium-container-inner-blocks-wrap .premium-container-' . $unique_id . '  > .premium-container-inner-blocks-wrap , .wp-block-premium-container.premium-is-root-container  .premium-container-inner-blocks-wrap .premium-block-' . $unique_id . '  > .premium-container-inner-blocks-wrap , .premium-container-' . $unique_id . ' > .premium-container-inner-blocks-wrap' );
    if ( isset( $attr['minHeight'] ) ) {
        $css->add_property( 'min-height', $css->render_range( $attr['minHeight'], 'Tablet' ) );
    }
    if ( isset( $attr['direction'] ) ) {
        $css->add_property( 'flex-direction', $css->get_responsive_css( $attr['direction'], 'Tablet' ) );
    }
    if ( isset( $attr['alignItems'] ) ) {
        $css->add_property( 'align-items', $css->get_responsive_css( $attr['alignItems'], 'Tablet' ) );
    }
    if ( isset( $attr['justifyItems'] ) ) {
        $css->add_property( 'justify-content', $css->get_responsive_css( $attr['justifyItems'], 'Tablet' ) );
    }
    if ( isset( $attr['wrapItems'] ) ) {
        $css->add_property( 'flex-wrap', $css->get_responsive_css( $attr['wrapItems'], 'Tablet' ) );
    }
    if ( isset( $attr['alignContent'] ) ) {
        $css->add_property( 'align-content', $css->get_responsive_css( $attr['alignContent'], 'Tablet' ) );
    }
    // $css->add_property( 'row-gap', isset( $attr['rowGutter']['Tablet'] ) ? $attr['rowGutter']['Tablet'] . $attr['rowGutter']['unit'] : '20px' );
    // $css->add_property( 'column-gap', isset( $attr['rowGutter']['Tablet'] ) ? $attr['columnGutter']['Tablet'] . $attr['columnGutter']['unit'] : '20px' );
    $css->add_property( 'row-gap', isset( $attr['rowGutter']['Tablet'] ) ? $css->render_range( $attr['rowGutter'], 'Tablet' ) : '20px' );
    $css->add_property( 'column-gap', isset( $attr['columnGutter']['Tablet'] ) ? $css->render_range( $attr['columnGutter'], 'Tablet' ) : '20px' );

    if ( isset( $attr['colWidth'] ) ) {
        $css->set_selector( '.wp-block-premium-container.premium-is-root-container .premium-container-' . $unique_id .' , .wp-block-premium-container.premium-is-root-container .premium-block-' . $unique_id );
        $css->add_property( 'max-width', $css->render_range( $attr['colWidth'], 'Tablet' ) );
        $css->add_property( 'width', '100%' );
    }
    if ( isset( $attr['shapeTop'] ) ) {
        $css->set_selector( '.wp-block-premium-container.premium-container-' . $unique_id . ' > .premium-top-shape svg , .wp-block-premium-container.premium-block-' . $unique_id . ' > .premium-top-shape svg' );
        $css->add_property( 'width', $css->render_range( $attr['shapeTop']['width'], 'Tablet' ) );
        $css->add_property( 'height', $css->render_range( $attr['shapeTop']['height'], 'Tablet' ) );
    }
    if ( isset( $attr['shapeBottom'] ) ) {
        $css->set_selector( '.wp-block-premium-container.premium-container-' . $unique_id . ' > .premium-bottom-shape svg , .wp-block-premium-container.premium-block-' . $unique_id . ' > .premium-bottom-shape svg' );
        $css->add_property( 'width', $css->render_range( $attr['shapeBottom']['width'], 'Tablet' ) );
        $css->add_property( 'height', $css->render_range( $attr['shapeBottom']['height'], 'Tablet' ) );
    }
    if ( isset( $attr['padding'] ) ) {
        $padding = $attr['padding'];
        $css->set_selector( '.wp-block-premium-container.premium-container-' . $unique_id . ' , .wp-block-premium-container.premium-block-' . $unique_id );
        $css->add_property( 'padding', $css->render_spacing( $padding['Tablet'], isset($padding['unit']['Tablet']) ?$padding['unit']['Tablet']:$padding['unit'] ) );
    }


    if ( isset( $attr['boxShadow'] ) ) {
        $css->set_selector( '.wp-block-premium-container.premium-container-' . $unique_id );
        $css->add_property( 'box-shadow', $css->render_shadow( $attr['boxShadow'] ));
    }
    if ( isset( $attr['boxShadowHover'] ) ) {
        $css->set_selector( '.wp-block-premium-container.premium-container-' . $unique_id . ':hover' );
        $css->add_property( 'box-shadow', $css->render_shadow( $attr['boxShadowHover'] ));
    }

    if ( isset( $attr['backgroundOptions'] ) ) {
        $css->set_selector( '.wp-block-premium-container.premium-container-' . $unique_id . ' , .wp-block-premium-container.premium-block-' . $unique_id );
        $css->render_background( $attr['backgroundOptions'], 'Tablet' );

    }
    if ( isset( $attr['margin'] ) &&  $attr['isBlockRootParent']===false ) {
        $margin = $attr['margin'];
        $css->set_selector( '.wp-block-premium-container.premium-is-root-container .premium-container-' . $unique_id . ' ,.wp-block-premium-container.premium-is-root-container .premium-block-' . $unique_id );
        $css->add_property( 'margin', $css->render_spacing( $margin['Tablet'], isset($margin['unit']['Tablet'])?$margin['unit']['Tablet']:$margin['unit']  ) );
    }
    if(isset( $attr['rootMarginTop'] ) &&  $attr['isBlockRootParent']===true){
        $css->set_selector( '.wp-block-premium-container.premium-is-root-container.premium-container-' . $unique_id . ' , .wp-block-premium-container.premium-is-root-container.premium-block-' . $unique_id );
        $css->add_property( 'margin-top',$css->render_range( $attr['rootMarginTop'], 'Tablet' ) );
        $css->add_property( 'margin-block-start',$css->render_range( $attr['rootMarginTop'], 'Tablet' ) );
  
    }
    if(isset( $attr['rootMarginBottom'] ) &&  $attr['isBlockRootParent']===true){
        $css->set_selector( '.wp-block-premium-container.premium-is-root-container.premium-container-' . $unique_id . ' , .wp-block-premium-container.premium-is-root-container.premium-block-' . $unique_id);
        $css->add_property( 'margin-Bottom', $css->render_range( $attr['rootMarginBottom'], 'Tablet' ) );
        $css->add_property( 'margin-Block-end', $css->render_range( $attr['rootMarginBottom'], 'Tablet' ));  
    }
    if ( isset( $attr['border'] ) ) {
        $border        = $attr['border'];
        $border_width  = $border['borderWidth'];
        $border_radius = $border['borderRadius'];

        $css->set_selector( '.wp-block-premium-container.premium-container-' . $unique_id . ' , .wp-block-premium-container.premium-block-' . $unique_id );
        $css->add_property( 'border-width', $css->render_spacing( $border_width['Tablet'], 'px' ) );
        $css->add_property( 'border-radius', $css->render_spacing( $border_radius['Tablet'], 'px' ) );
    }
    if ( isset( $attr['borderHover'] ) && $attr['borderHover']['borderType'] !== "none" ) {
        $border        = $attr['borderHover'];
        $border_width  = $border['borderWidth'];
        $border_radius = $border['borderRadius'];

        $css->set_selector( '.wp-block-premium-container.premium-container-' . $unique_id . ':hover  , .wp-block-premium-container.premium-block-' . $unique_id . ':hover ');
        $css->add_property( 'border-width', $css->render_spacing( $border_width['Tablet'], 'px' ) );
        $css->add_property( 'border-radius', $css->render_spacing( $border_radius['Tablet'], 'px' ) );
    }
    if ( isset( $attr['backgroundOverlay'] ) ) {
        $css->set_selector( '.premium-container-' . $unique_id . '::before , .premium-block-' . $unique_id . '::before ' );        $css->render_background( $attr['backgroundOverlay'], 'Tablet' );
    }
    if ( isset( $attr['backgroundOverlayHover'] ) ) {
        $css->set_selector( '.premium-container-' . $unique_id . ':hover::before , .premium-block-' . $unique_id . ':hover::before' );
        $css->render_background( $attr['backgroundOverlayHover'], 'Tablet' );
    }

    $css->stop_media_query();

    $css->start_media_query( 'mobile' );

    $css->set_selector( '.wp-block-premium-container.premium-is-root-container.premium-container-' . $unique_id . '>  .premium-container-inner-blocks-wrap , .wp-block-premium-container.premium-is-root-container.premium-block-' . $unique_id . '>  .premium-container-inner-blocks-wrap' );
    if ( isset( $attr['minHeight'] ) ) {
        $css->add_property( 'min-height', $css->render_range( $attr['minHeight'], 'Mobile' ) );
    }
    if ( isset( $attr['direction'] ) ) {
        $css->add_property( 'flex-direction', $css->get_responsive_css( $attr['direction'], 'Mobile' ) );
    }
    if ( isset( $attr['alignItems'] ) ) {
        $css->add_property( 'align-items', $css->get_responsive_css( $attr['alignItems'], 'Mobile' ) );
    }
    if ( isset( $attr['justifyItems'] ) ) {
        $css->add_property( 'justify-content', $css->get_responsive_css( $attr['justifyItems'], 'Mobile' ) );
    }
    if ( isset( $attr['wrapItems'] ) ) {
        $css->add_property( 'flex-wrap', $css->get_responsive_css( $attr['wrapItems'], 'Mobile' ) );
    }
    if ( isset( $attr['alignContent'] ) ) {
        $css->add_property( 'align-content', $css->get_responsive_css( $attr['alignContent'], 'Mobile' ) );
    }
    // $css->add_property( 'row-gap', isset( $attr['rowGutter']['Mobile'] ) ? $attr['rowGutter']['Mobile'] . $attr['rowGutter']['unit'] : '20px' );
    // $css->add_property( 'column-gap', isset( $attr['rowGutter']['Mobile'] ) ? $attr['columnGutter']['Mobile'] . $attr['columnGutter']['unit'] : '20px' );
    $css->add_property( 'row-gap', isset( $attr['rowGutter']['Mobile'] ) ? $css->render_range( $attr['rowGutter'], 'Mobile' ) : '20px' );
    $css->add_property( 'column-gap', isset( $attr['columnGutter']['Mobile'] ) ? $css->render_range( $attr['columnGutter'], 'Mobile' ) : '20px' );

    $css->set_selector( '.wp-block-premium-container.premium-is-root-container  .premium-container-inner-blocks-wrap .premium-container-' . $unique_id . '  > .premium-container-inner-blocks-wrap , .wp-block-premium-container.premium-is-root-container  .premium-container-inner-blocks-wrap .premium-block-' . $unique_id . '  > .premium-container-inner-blocks-wrap , .premium-container-' . $unique_id . ' > .premium-container-inner-blocks-wrap' );
    if ( isset( $attr['minHeight'] ) ) {
        $css->add_property( 'min-height', $css->render_range( $attr['minHeight'], 'Mobile' ) );
    }
    if ( isset( $attr['direction'] ) ) {
        $css->add_property( 'flex-direction', $css->get_responsive_css( $attr['direction'], 'Mobile' ) );
    }
    if ( isset( $attr['alignItems'] ) ) {
        $css->add_property( 'align-items', $css->get_responsive_css( $attr['alignItems'], 'Mobile' ) );
    }
    if ( isset( $attr['justifyItems'] ) ) {
        $css->add_property( 'justify-content', $css->get_responsive_css( $attr['justifyItems'], 'Mobile' ) );
    }
    if ( isset( $attr['wrapItems'] ) ) {
        $css->add_property( 'flex-wrap', $css->get_responsive_css( $attr['wrapItems'], 'Mobile' ) );
    }
    if ( isset( $attr['alignContent'] ) ) {
        $css->add_property( 'align-content', $css->get_responsive_css( $attr['alignContent'], 'Mobile' ) );
    }
    // $css->add_property( 'row-gap', isset( $attr['rowGutter']['Mobile'] ) ? $attr['rowGutter']['Mobile'] . $attr['rowGutter']['unit'] : '20px' );
    // $css->add_property( 'column-gap', isset( $attr['rowGutter']['Mobile'] ) ? $attr['columnGutter']['Mobile'] . $attr['columnGutter']['unit'] : '20px' );
    $css->add_property( 'row-gap', isset( $attr['rowGutter']['Mobile'] ) ? $css->render_range( $attr['rowGutter'], 'Mobile' ) : '20px' );
    $css->add_property( 'column-gap', isset( $attr['columnGutter']['Mobile'] ) ? $css->render_range( $attr['columnGutter'], 'Mobile' ) : '20px' );

    if ( isset( $attr['colWidth'] ) ) {
        $css->set_selector( '.wp-block-premium-container.premium-is-root-container .premium-container-' . $unique_id .' , .wp-block-premium-container.premium-is-root-container .premium-block-' . $unique_id );
        $css->add_property( 'max-width', $css->render_range( $attr['colWidth'], 'Mobile' ) );
        $css->add_property( 'width', '100%' );
    }
    if ( isset( $attr['shapeTop'] ) ) {
        $css->set_selector( '.wp-block-premium-container.premium-container-' . $unique_id . ' > .premium-top-shape svg , .wp-block-premium-container.premium-block-' . $unique_id . ' > .premium-top-shape svg' );
        $css->add_property( 'width', $css->render_range( $attr['shapeTop']['width'], 'Mobile' ) );
        $css->add_property( 'height', $css->render_range( $attr['shapeTop']['height'], 'Mobile' ) );
    }
    if ( isset( $attr['shapeBottom'] ) ) {
        $css->set_selector( '.wp-block-premium-container.premium-container-' . $unique_id . ' > .premium-bottom-shape svg , .wp-block-premium-container.premium-block-' . $unique_id . ' > .premium-bottom-shape svg' );
        $css->add_property( 'width', $css->render_range( $attr['shapeBottom']['width'], 'Mobile' ) );
        $css->add_property( 'height', $css->render_range( $attr['shapeBottom']['height'], 'Mobile' ) );
    }
    if ( isset( $attr['padding'] )  ) {
        $padding = $attr['padding'];
        $css->set_selector( '.wp-block-premium-container.premium-container-' . $unique_id . ' , .wp-block-premium-container.premium-block-' . $unique_id );
        $css->add_property( 'padding', $css->render_spacing( $padding['Mobile'], isset($padding['unit']['Mobile']) ?$padding['unit']['Mobile']:$padding['unit'] ) );
    }

    if ( isset( $attr['backgroundOptions'] ) ) {
        $css->set_selector( '.wp-block-premium-container.premium-container-' . $unique_id . ' , .wp-block-premium-container.premium-block-' . $unique_id );
        $css->render_background( $attr['backgroundOptions'], 'Mobile' );

    }
    if ( isset( $attr['margin'] ) &&  $attr['isBlockRootParent']===false ) {
        $margin = $attr['margin'];
        $css->set_selector( '.wp-block-premium-container.premium-container-' . $unique_id  . ' , .wp-block-premium-container.premium-block-' . $unique_id );
        $css->add_property( 'margin', $css->render_spacing( $margin['Mobile'], isset($margin['unit']['Mobile'])?$margin['unit']['Mobile']:$margin['unit']  ) );
    }
    if(isset( $attr['rootMarginTop'] ) &&  $attr['isBlockRootParent']===true){
        $css->set_selector( '.wp-block-premium-container.premium-is-root-container.premium-container-' . $unique_id . ' , .wp-block-premium-container.premium-is-root-container.premium-block-' . $unique_id );
         $css->add_property( 'margin-top',$css->render_range( $attr['rootMarginTop'], 'Mobile' ) );
        $css->add_property( 'margin-block-start',$css->render_range( $attr['rootMarginTop'], 'Mobile' ) );
  
    }
    if(isset( $attr['rootMarginBottom'] ) &&  $attr['isBlockRootParent']===true){
        $css->set_selector( '.wp-block-premium-container.premium-is-root-container.premium-container-' . $unique_id . ' , .wp-block-premium-container.premium-is-root-container.premium-block-' . $unique_id);
        $css->add_property( 'margin-Bottom', $css->render_range( $attr['rootMarginBottom'], 'Mobile' ) );
        $css->add_property( 'margin-Block-end', $css->render_range( $attr['rootMarginBottom'], 'Mobile' ));  
  
    }

    if ( isset( $attr['border'] ) ) {
        $border        = $attr['border'];
        $border_width  = $border['borderWidth'];
        $border_radius = $border['borderRadius'];

        $css->set_selector( '.wp-block-premium-container.premium-container-' . $unique_id . ' , .wp-block-premium-container.premium-block-' . $unique_id );
        $css->add_property( 'border-width', $css->render_spacing( $border_width['Mobile'], 'px' ) );
        $css->add_property( 'border-radius', $css->render_spacing( $border_radius['Mobile'], 'px' ) );
    }
    if ( isset( $attr['borderHover'] )  && $attr['borderHover']['borderType'] !== "none") {
        $border        = $attr['borderHover'];
        $border_width  = $border['borderWidth'];
        $border_radius = $border['borderRadius'];

        $css->set_selector( '.wp-block-premium-container.premium-container-' . $unique_id . ':hover  , .wp-block-premium-container.premium-block-' . $unique_id . ':hover ');
        $css->add_property( 'border-width', $css->render_spacing( $border_width['Mobile'], 'px' ) );
        $css->add_property( 'border-radius', $css->render_spacing( $border_radius['Mobile'], 'px' ) );
    }
    if ( isset( $attr['backgroundOverlay'] ) ) {
        $css->set_selector( '.premium-container-' . $unique_id . '::before , .premium-block-' . $unique_id . '::before ' );  
              $css->render_background( $attr['backgroundOverlay'], 'Mobile' );
    }
    if ( isset( $attr['backgroundOverlayHover'] ) ) {
        $css->set_selector( '.premium-container-' . $unique_id . ':hover::before , .premium-block-' . $unique_id . ':hover::before' );
        $css->render_background( $attr['backgroundOverlayHover'], 'Mobile' );
    }

    $css->stop_media_query();
    return $css->css_output();
}

/**
 * Renders the `premium/container` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_container( $attributes, $content, $block ) {
    $block_helpers   = pbg_blocks_helper();
    $global_features = apply_filters( 'pb_global_features', get_option( 'pbg_global_features', array() ) );

    if ( $global_features['premium-equal-height'] && isset( $attributes['equalHeight'] ) && $attributes['equalHeight'] ) {
        add_filter(
            'premium_equal_height_localize_script',
            function ( $data ) use ( $attributes ) {
                $data[ $attributes['block_id'] ] = array(
                    'attributes' => $attributes,
                );
                return $data;
            }
        );
    }



    return $content;
}




/**
 * Register the container block.
 *
 * @uses render_block_pbg_container()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_container() {
    if ( ! function_exists( 'register_block_type' ) ) {
        return;
    }
    register_block_type(
        PREMIUM_BLOCKS_PATH . '/blocks-config/container',
        array(
            'render_callback' => 'render_block_pbg_container',
        )
    );
}

register_block_pbg_container();

