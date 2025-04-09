<?php
// Move this file to "blocks-config" folder with name "my-block.php".

/**
 * Server-side rendering of the `premium/my-block` block.
 *
 * @package WordPress
 */

function get_premium_off_canvas_css( $attributes, $unique_id ) {
	$css                    = new Premium_Blocks_css();

	// Desktop Styles.

  // Styles for Button Trigger
  if(isset($attributes['align']['Desktop'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger');
    $css->add_property('text-align', $css->get_responsive_css($attributes['align'], 'Desktop'));
  }

  if(isset($attributes['triggerTypography'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn');
    $css->render_typography($attributes['triggerTypography'], 'Desktop');
  }

  if(isset($attributes['triggerMargin'])){
    $trigger_margin = $attributes['triggerMargin'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn');
    $css->add_property('margin', $css->render_spacing($trigger_margin['Desktop'], $trigger_margin['unit']['Desktop']));
  }

  if(isset($attributes['triggerPadding'])){
    $trigger_padding = $attributes['triggerPadding'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn');
    $css->add_property('padding', $css->render_spacing($trigger_padding['Desktop'], $trigger_padding['unit']['Desktop']));
  }

  if(isset($attributes['triggerBorder'])){
    $trigger_border = $attributes['triggerBorder'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn');
    $css->render_border($trigger_border, 'Desktop');
  }

  if(isset($attributes['triggerStyles']['color'])){
    $trigger_color = $attributes['triggerStyles']['color'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn');
    $css->add_property('color', $css->render_color($trigger_color));
  }

  if(isset($attributes['triggerStyles']['triggerBack'])){
    $trigger_backColor = $attributes['triggerStyles']['triggerBack'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn');
    $css->render_background( $trigger_backColor, 'Desktop' );
  }

  if(isset($attributes['triggerShadow'])){
    $trigger_shadow = $attributes['triggerShadow'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn');
    $css->add_property( 'box-shadow', $css->render_shadow( $trigger_shadow ));
  }

  if(isset($attributes['triggerTextShadow'])){
    $trigger_textShadow = $attributes['triggerTextShadow'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn');
    $css->add_property( 'text-shadow', $css->render_shadow( $trigger_textShadow ));
  }

  if(isset($attributes['triggerBorderH'])){
    $trigger_borderH = $attributes['triggerBorderH'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover');
    $css->add_property('border-color', $css->render_color($trigger_borderH));
  }

  if(isset($attributes['triggerStyles']['hoverColor'])){
    $trigger_hoverColor = $attributes['triggerStyles']['hoverColor'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover');
    $css->add_property('color', $css->render_color($trigger_hoverColor));
  }

  if(isset($attributes['triggerStyles']['triggerHoverBack'])){
    $trigger_hoverBack = $attributes['triggerStyles']['triggerHoverBack'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover');
    $css->render_background( $trigger_hoverBack, 'Desktop' );

    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-button__slide::before, ' . '.' . $unique_id . ' .premium-off-canvas-trigger .premium-button__shutter::before, ' . '.' . $unique_id . ' .premium-off-canvas-trigger .premium-button__radial::before' );
		$css->render_background( $trigger_hoverBack, 'Desktop' );
  }

  if(isset($attributes['triggerShadowHover'])){
    $trigger_hoverShadow = $attributes['triggerShadowHover'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover');
    $css->add_property( 'box-shadow', $css->render_shadow( $trigger_hoverShadow ));
  }
  // End of Styles for Button Trigger

  // Styles for Icon inside Button Trigger
  if(isset($attributes['iconPosition'])){
    $icon_position = $attributes['iconPosition'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn.premium-button__' . $icon_position .' .premium-off-canvas-icon, .'. $unique_id .' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn.premium-button__' . $icon_position . ' img, .'. $unique_id .' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn.premium-button__'. $icon_position .' .premium-off-canvas-svg-class, .'. $unique_id .' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn.premium-button__'. $icon_position .' .premium-off-canvas-lottie-animation');
    if($icon_position === "before"){
      $css->add_property('margin-right', $css->render_string($attributes['triggerSettings']['iconSpacing'], 'px'));
    }
    if($icon_position === "after"){
      $css->add_property('margin-left', $css->render_string($attributes['triggerSettings']['iconSpacing'], 'px'));
    }
  }

  if(isset($attributes['iconSize'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-icon svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-icon svg');
    $css->add_property( 'width', $css->render_string( $css->render_range( $attributes['iconSize'], 'Desktop' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attributes['iconSize'], 'Desktop' ), '!important' ) );
    
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-icon:not(.icon-type-fe) svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-icon:not(.icon-type-fe) svg');
    $css->add_property( 'width', $css->render_string( $css->render_range( $attributes['iconSize'], 'Desktop' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attributes['iconSize'], 'Desktop' ), '!important' ) );
    
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-svg-class svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class svg');
    $css->add_property( 'width', $css->render_string( $css->render_range( $attributes['iconSize'], 'Desktop' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attributes['iconSize'], 'Desktop' ), '!important' ) );
  }

  if(isset($attributes['imgWidth'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn img');
    $css->add_property( 'width', $css->render_string( $css->render_range( $attributes['imgWidth'], 'Desktop' ), '!important' ) );
    
		$css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-lottie-animation svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-lottie-animation svg');
    $css->add_property( 'width', $css->render_string( $css->render_range( $attributes['imgWidth'], 'Desktop' ), '!important' ) );
    $css->add_property( 'height', $css->render_string( $css->render_range( $attributes['imgWidth'], 'Desktop' ), '!important' ) );
  }

  if(isset($attributes['iconBorder'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-icon, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn img, .'. $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-svg-class svg, .'. $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-lottie-animation svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-lottie-animation svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-icon svg');
    $css->render_border($attributes['iconBorder'], 'Desktop'); 
  }

  if(isset($attributes['iconBG'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-icon, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn img, .'. $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-svg-class svg, .'. $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-lottie-animation svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-lottie-animation svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-icon svg');
    $css->render_background($attributes['iconBG'], 'Desktop'); 
  }

  if(isset($attributes['iconMargin'])){
    $icon_margin = $attributes['iconMargin'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-icon, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn img, .'. $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-svg-class svg, .'. $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-lottie-animation svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-lottie-animation svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-icon svg');
    $css->add_property('margin', $css->render_spacing($icon_margin['Desktop'], $icon_margin['unit']['Desktop']));
  }

  if(isset($attributes['iconPadding'])){
    $icon_padding = $attributes['iconPadding'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-icon, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn img, .'. $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-svg-class svg, .'. $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-lottie-animation svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-lottie-animation svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-icon svg');
    $css->add_property('padding', $css->render_spacing($icon_padding['Desktop'], $icon_padding['unit']['Desktop']));
  }

  if(isset($attributes['iconColor'])){
    $icon_color = $attributes['iconColor'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-icon, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-svg-class svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-icon svg');
    $css->add_property('fill', $css->render_color($icon_color));
    $css->add_property('color', $css->render_color($icon_color));
    
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-svg-class svg *, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class svg *');
    $css->add_property('fill', $css->render_color($icon_color));
  }

  if(isset($attributes['iconHoverBG'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover .premium-off-canvas-icon, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover .premium-off-canvas-svg-class svg, .'. $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover .premium-off-canvas-lottie-animation svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class:hover svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-lottie-animation:hover svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-icon:hover svg');
    $css->render_background($attributes['iconHoverBG'], 'Desktop'); 
  }

  if(isset($attributes['borderHoverColor'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover .premium-off-canvas-icon, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover .premium-off-canvas-svg-class svg, .'. $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover .premium-off-canvas-lottie-animation svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class:hover svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-lottie-animation:hover svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-icon:hover svg');
    $css->add_property('border-color', $css->render_string($css->render_color($attributes['borderHoverColor']), '!important')); 
  }

  if(isset($attributes['iconHoverColor'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover .premium-off-canvas-icon, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover .premium-off-canvas-svg-class svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover .premium-off-canvas-svg-class svg *, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class:hover svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class:hover svg *, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-icon:hover svg');
		$css->add_property( 'fill', $css->render_string( $css->render_color( $attributes['iconHoverColor'] ), '!important' ) );
		$css->add_property( 'color', $css->render_string( $css->render_color( $attributes['iconHoverColor'] ), '!important' ) );
  }
  // End of  Styles for Icon inside Button Trigger

  // Styles for Trigger Image
  if(isset($attributes['imgWidth']['Desktop'])){
    $css->set_selector( '.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-img' );
		$css->add_property( 'width', $css->render_range( $attributes['imgWidth'], 'Desktop' ) );
  }

  if(isset($attributes['triggerBorder'])){
    $trigger_border = $attributes['triggerBorder'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-img');
    $css->render_border($trigger_border, 'Desktop');
  }

  if(isset($attributes['triggerShadow'])){
    $trigger_shadow = $attributes['triggerShadow'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-img');
    $css->add_property('box-shadow', $css->render_shadow( $trigger_shadow ));
  }

  if(isset($attributes['triggerBorderH'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-img:hover');
    $css->add_property('border-color', $css->render_color($attributes['triggerBorderH']));
  }

  if(isset($attributes['triggerShadowHover'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-img:hover');
    $css->add_property('box-shadow', $css->render_shadow( $attributes['triggerShadowHover'] ));
  }
  // End of Styles for Trigger Image

  // Styles for Content Panel
  if(isset($attributes['contentBackground'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content .premium-off-canvas-content-body');
    $css->render_background($attributes['contentBackground'], 'Desktop'); 
  }

  if(isset($attributes['contentBorder'])){
    $content_border = $attributes['contentBorder'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content .premium-off-canvas-content-body');
    $css->render_border($content_border, 'Desktop');
  }

  if(isset($attributes['contentShadow'])){
    $content_shadow = $attributes['contentShadow'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content .premium-off-canvas-content-body');
    $css->add_property('box-shadow', $css->render_shadow( $content_shadow ));
  }

  if(isset($attributes['contentPadding'])){
    $content_padding = $attributes['contentPadding'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content .premium-off-canvas-content-body');
    $css->add_property('padding', $css->render_spacing($content_padding['Desktop'], $content_padding['unit']['Desktop']));
  }

  if(isset($attributes['contentVerticalAlign'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content .premium-off-canvas-content-body');
    $css->add_property('justify-content', $css->get_responsive_css($attributes['contentVerticalAlign'], 'Desktop'));
  }
  // End of Styles for Content Panel

  // Styles for Close Button
  if(isset($attributes['closeStyles']['backColor'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content-close-button');
    $css->add_property('background-color', $css->render_color($attributes['closeStyles']['backColor']));
  }
  if(isset($attributes['closeMargin'])){
    $close_margin = $attributes['closeMargin'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content-close-button');
    $css->add_property('margin', $css->render_spacing($close_margin['Desktop'], $close_margin['unit']['Desktop']));
  }
  if(isset($attributes['closePadding'])){
    $close_padding = $attributes['closePadding'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content-close-button');
    $css->add_property('padding', $css->render_spacing($close_padding['Desktop'], $close_padding['unit']['Desktop']));
  }
  if(isset($attributes['closeBorder'])){
    $close_border = $attributes['closeBorder'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content-close-button');
    $css->render_border($close_border, 'Desktop');
  }
  if(isset($attributes['closeSize'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content-close-button');
    $css->add_property('width', $css->render_range($attributes['closeSize'], 'Desktop'));
    $css->add_property('height', $css->render_range($attributes['closeSize'], 'Desktop'));
  }
  if(isset($attributes['closeStyles']['color'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content-close-button svg, .'. $unique_id . ' .premium-off-canvas-content-close-button svg *');
    $css->add_property('fill', $css->render_color($attributes['closeStyles']['color']));
  }
  if(isset($attributes['closeStyles']['hoverBackColor'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content-close-button:hover');
    $css->add_property('background-color', $css->render_color($attributes['closeStyles']['hoverBackColor']));
  }
  if(isset($attributes['closeStyles']['hoverColor'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content-close-button:hover svg, .' . $unique_id . ' .premium-off-canvas-content-close-button:hover svg *');
    $css->add_property('fill', $css->render_color($attributes['closeStyles']['hoverColor']));
  }
  if(isset($attributes['closeBorderHC'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content-close-button:hover');
    $css->add_property('border-color', $css->render_color($attributes['closeBorderHC']));
  }
  // End of Styles for Close Button

  if(isset($attributes['contentStyles']['offCanvasType']) && $attributes['contentStyles']['offCanvasType'] === "corner"){
    if(isset($attributes['contentStyles']['cornerTransition']) && $attributes['contentStyles']['cornerTransition'] === "slide"){
      $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content.off-canvas-slide.' . $attributes['contentStyles']['cornerPosition']);
      $contentPosition = $attributes['contentStyles']['cornerPosition'];
      if(isset($attributes['contentHeight']['Desktop']) && $attributes['contentHeight']['Desktop'] !== ""){
        $css->add_property($contentPosition === "topleft" || $contentPosition === "topright" ? "top" : "bottom", $css->render_string("-",$css->render_range($attributes['contentHeight'], 'Desktop')));
        $css->add_property('height', $css->render_string( $css->render_range( $attributes['contentHeight'], 'Desktop'), '!important'));
      }
      if(isset($attributes['contentWidth']['Desktop']) && $attributes['contentWidth']['Desktop'] !== ""){
        $css->add_property($contentPosition === "topleft" || $contentPosition === "bottomleft" ? "left" : "right", $css->render_string("-",$css->render_range($attributes['contentWidth'], 'Desktop')));
        $css->add_property('width', $css->render_string( $css->render_range( $attributes['contentWidth'], 'Desktop'), '!important'));
      }
    }
  }

  if(isset($attributes['contentStyles']['offCanvasType']) && ($attributes['contentStyles']['offCanvasType'] === "slide")){
    if(isset($attributes['contentStyles']['position']) && ($attributes['contentStyles']['position'] === "left" || $attributes['contentStyles']['position'] === "right")){
      if(isset($attributes['contentWidth'])){
        $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content');
        $css->add_property('width', $css->render_string( $css->render_range( $attributes['contentWidth'], 'Desktop'), '!important'));
      }
    }
    if(isset($attributes['contentStyles']['position']) && ($attributes['contentStyles']['position'] === "top" || $attributes['contentStyles']['position'] === "bottom")){
      if(isset($attributes['contentHeight'])){
        $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content');
        $css->add_property('height', $css->render_string( $css->render_range( $attributes['contentHeight'], 'Desktop'), '!important'));
      }
    }
  }

  if(isset($attributes['contentStyles']['offCanvasType']) && ($attributes['contentStyles']['offCanvasType'] === "slide")){
    if(isset($attributes['contentStyles']['cornerTransition']) && $attributes['contentStyles']['transition'] === "push"){
      if(isset($attributes['contentStyles']['position']) && ($attributes['contentStyles']['position'] === "left" || $attributes['contentStyles']['position'] === "right")){
        if(isset($attributes['contentWidth'])){
          $css->set_selector('.premium-off-canvas-site-content-wrapper:has(~ .' . $unique_id . '[aria-hidden="false"] .premium-off-canvas-content.push-content)');
          $css->add_property('left', $css->render_string( ($attributes['contentStyles']['position'] === "right" ? "-" : "") . $css->render_range( $attributes['contentWidth'], 'Desktop'), '!important'));
        }
      }
      if(isset($attributes['contentStyles']['position']) && ($attributes['contentStyles']['position'] === "top" || $attributes['contentStyles']['position'] === "bottom")){
        if(isset($attributes['contentHeight'])){
          $css->set_selector('.premium-off-canvas-site-content-wrapper:has(~ .' . $unique_id . '[aria-hidden="false"] .premium-off-canvas-content.push-content)');
          $css->add_property('top', $css->render_string( ($attributes['contentStyles']['position'] === "bottom" ? "-" : "") . $css->render_range( $attributes['contentHeight'], 'Desktop'), '!important'));
        }
      }
    }
  }

  if(isset($attributes['contentStyles']['offCanvasType']) && $attributes['contentStyles']['offCanvasType'] === "corner"){
    if(isset($attributes['contentStyles']['cornerTransition']) && $attributes['contentStyles']['cornerTransition'] === "bounce-in"){
      if(isset($attributes['contentWidth'])){
        $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content.off-canvas-bounce-in.bounce-in-active');
        $css->add_property('width', $css->render_string( $css->render_range( $attributes['contentWidth'], 'Desktop'), '!important'));
      }
      if(isset($attributes['contentHeight'])){
        $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content.off-canvas-bounce-in.bounce-in-active');
        $css->add_property('height', $css->render_string( $css->render_range( $attributes['contentHeight'], 'Desktop'), '!important'));
      }
    }
  }
  
  if(isset($attributes['contentBackground']['backgroundColor'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content .premium-off-canvas-divider');
    $css->add_property('fill', $css->render_color($attributes['contentBackground']['backgroundColor'])); 
  }

	$css->start_media_query( 'tablet' );

  // Tablet Styles.

  // Styles for Button Trigger
  if(isset($attributes['align']['Tablet'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger');
    $css->add_property('text-align', $css->get_responsive_css($attributes['align'], 'Tablet'));
  }

  if(isset($attributes['triggerTypography'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn');
    $css->render_typography($attributes['triggerTypography'], 'Tablet');
  }

  if(isset($attributes['triggerMargin'])){
    $trigger_margin = $attributes['triggerMargin'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn');
    $css->add_property('margin', $css->render_spacing($trigger_margin['Tablet'], $trigger_margin['unit']['Tablet']));
  }

  if(isset($attributes['triggerPadding'])){
    $trigger_padding = $attributes['triggerPadding'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn');
    $css->add_property('padding', $css->render_spacing($trigger_padding['Tablet'], $trigger_padding['unit']['Tablet']));
  }

  if(isset($attributes['triggerBorder'])){
    $trigger_border = $attributes['triggerBorder'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn');
    $css->render_border($trigger_border, 'Tablet');
  }

  if(isset($attributes['triggerStyles']['triggerBack'])){
    $trigger_backColor = $attributes['triggerStyles']['triggerBack'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn');
    $css->render_background( $trigger_backColor, 'Tablet' );
  }

  if(isset($attributes['triggerStyles']['triggerHoverBack'])){
    $trigger_hoverBack = $attributes['triggerStyles']['triggerHoverBack'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover');
    $css->render_background( $trigger_hoverBack, 'Tablet' );

    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-button__slide::before, ' . '.' . $unique_id . ' .premium-off-canvas-trigger .premium-button__shutter::before, ' . '.' . $unique_id . ' .premium-off-canvas-trigger .premium-button__radial::before' );
		$css->render_background( $trigger_hoverBack, 'Tablet' );
  }
  // End of Styles for Button Trigger

  // Styles for Icon inside Button Trigger
  if(isset($attributes['iconSize'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-icon svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-icon svg');
    $css->add_property( 'width', $css->render_string( $css->render_range( $attributes['iconSize'], 'Tablet' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attributes['iconSize'], 'Tablet' ), '!important' ) );
    
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-icon:not(.icon-type-fe) svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-icon:not(.icon-type-fe) svg');
    $css->add_property( 'width', $css->render_string( $css->render_range( $attributes['iconSize'], 'Tablet' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attributes['iconSize'], 'Tablet' ), '!important' ) );
    
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-svg-class svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class svg');
    $css->add_property( 'width', $css->render_string( $css->render_range( $attributes['iconSize'], 'Tablet' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attributes['iconSize'], 'Tablet' ), '!important' ) );
  }

  if(isset($attributes['imgWidth'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn img');
    $css->add_property( 'width', $css->render_string( $css->render_range( $attributes['imgWidth'], 'Tablet' ), '!important' ) );
    
		$css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-lottie-animation svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-lottie-animation svg');
    $css->add_property( 'width', $css->render_string( $css->render_range( $attributes['imgWidth'], 'Tablet' ), '!important' ) );
    $css->add_property( 'height', $css->render_string( $css->render_range( $attributes['imgWidth'], 'Tablet' ), '!important' ) );
  }
 
  if(isset($attributes['iconBorder'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-icon, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn img, .'. $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-svg-class svg, .'. $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-lottie-animation svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-lottie-animation svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-icon svg');
    $css->render_border($attributes['iconBorder'], 'Tablet'); 
  }

  if(isset($attributes['iconBG'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-icon, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn img, .'. $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-svg-class svg, .'. $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-lottie-animation svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-lottie-animation svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-icon svg');
    $css->render_background($attributes['iconBG'], 'Tablet'); 
  }

  if(isset($attributes['iconMargin'])){
    $icon_margin = $attributes['iconMargin'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-icon, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn img, .'. $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-svg-class svg, .'. $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-lottie-animation svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-lottie-animation svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-icon svg');
    $css->add_property('margin', $css->render_spacing($icon_margin['Tablet'], $icon_margin['unit']['Tablet']));
  }

  if(isset($attributes['iconPadding'])){
    $icon_padding = $attributes['iconPadding'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-icon, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn img, .'. $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-svg-class svg, .'. $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-lottie-animation svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-lottie-animation svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-icon svg');
    $css->add_property('padding', $css->render_spacing($icon_padding['Tablet'], $icon_padding['unit']['Tablet']));
  }

  if(isset($attributes['iconHoverBG'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover .premium-off-canvas-icon, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover .premium-off-canvas-svg-class svg, .'. $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover .premium-off-canvas-lottie-animation svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class:hover svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-lottie-animation:hover svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-icon:hover svg');
    $css->render_background($attributes['iconHoverBG'], 'Tablet'); 
  }
  // End of  Styles for Icon inside Button Trigger

  // Styles for Trigger Image
  if(isset($attributes['imgWidth']['Tablet'])){
    $css->set_selector( '.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-img' );
		$css->add_property( 'width', $css->render_range( $attributes['imgWidth'], 'Tablet' ) );
  }

  if(isset($attributes['triggerBorder'])){
    $trigger_border = $attributes['triggerBorder'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-img');
    $css->render_border($trigger_border, 'Tablet');
  }
  // End of Styles for Trigger Image

  // Styles for Content Panel
  if(isset($attributes['contentBackground'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content .premium-off-canvas-content-body');
    $css->render_background($attributes['contentBackground'], 'Tablet'); 
  }

  if(isset($attributes['contentBorder'])){
    $content_border = $attributes['contentBorder'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content .premium-off-canvas-content-body');
    $css->render_border($content_border, 'Tablet');
  }

  if(isset($attributes['contentPadding'])){
    $content_padding = $attributes['contentPadding'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content .premium-off-canvas-content-body');
    $css->add_property('padding', $css->render_spacing($content_padding['Tablet'], $content_padding['unit']['Tablet']));
  }
  
  if(isset($attributes['contentVerticalAlign'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content .premium-off-canvas-content-body');
    $css->add_property('justify-content', $css->get_responsive_css($attributes['contentVerticalAlign'], 'Tablet'));
  }
  // End of Styles for Content Panel

  // Styles for Close Button
  if(isset($attributes['closeMargin'])){
    $close_margin = $attributes['closeMargin'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content-close-button');
    $css->add_property('margin', $css->render_spacing($close_margin['Tablet'], $close_margin['unit']['Tablet']));
  }
  if(isset($attributes['closePadding'])){
    $close_padding = $attributes['closePadding'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content-close-button');
    $css->add_property('padding', $css->render_spacing($close_padding['Tablet'], $close_padding['unit']['Tablet']));
  }
  if(isset($attributes['closeBorder'])){
    $close_border = $attributes['closeBorder'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content-close-button');
    $css->render_border($close_border, 'Tablet');
  }
  if(isset($attributes['closeSize'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content-close-button');
    $css->add_property('width', $css->render_range($attributes['closeSize'], 'Tablet'));
    $css->add_property('height', $css->render_range($attributes['closeSize'], 'Tablet'));
  }
  // End of Styles for Close Button

  if(isset($attributes['contentStyles']['offCanvasType']) && $attributes['contentStyles']['offCanvasType'] === "corner"){
    if(isset($attributes['contentStyles']['cornerTransition']) && $attributes['contentStyles']['cornerTransition'] === "slide"){
      $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content.off-canvas-slide.' . $attributes['contentStyles']['cornerPosition']);
      $contentPosition = $attributes['contentStyles']['cornerPosition'];
      if(isset($attributes['contentHeight']['Tablet']) && $attributes['contentHeight']['Tablet'] !== ""){
        $css->add_property($contentPosition === "topleft" || $contentPosition === "topright" ? "top" : "bottom", $css->render_string("-",$css->render_range($attributes['contentHeight'], 'Tablet')));
        $css->add_property('height', $css->render_string( $css->render_range( $attributes['contentHeight'], 'Tablet'), '!important'));
      }
      if(isset($attributes['contentWidth']['Tablet']) && $attributes['contentWidth']['Tablet'] !== ""){
        $css->add_property($contentPosition === "topleft" || $contentPosition === "bottomleft" ? "left" : "right", $css->render_string("-",$css->render_range($attributes['contentWidth'], 'Tablet')));
        $css->add_property('width', $css->render_string( $css->render_range( $attributes['contentWidth'], 'Tablet'), '!important'));
      }
    }
  }

  if(isset($attributes['contentStyles']['offCanvasType']) && ($attributes['contentStyles']['offCanvasType'] === "slide")){
    if(isset($attributes['contentStyles']['position']) && ($attributes['contentStyles']['position'] === "left" || $attributes['contentStyles']['position'] === "right")){
      if(isset($attributes['contentWidth'])){
        $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content');
        $css->add_property('width', $css->render_string( $css->render_range( $attributes['contentWidth'], 'Tablet'), '!important'));
      }
    }
    if(isset($attributes['contentStyles']['position']) && ($attributes['contentStyles']['position'] === "top" || $attributes['contentStyles']['position'] === "bottom")){
      if(isset($attributes['contentHeight'])){
        $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content');
        $css->add_property('height', $css->render_string( $css->render_range( $attributes['contentHeight'], 'Tablet'), '!important'));
      }
    }
  }

  if(isset($attributes['contentStyles']['offCanvasType']) && ($attributes['contentStyles']['offCanvasType'] === "slide")){
    if(isset($attributes['contentStyles']['cornerTransition']) && $attributes['contentStyles']['transition'] === "push"){
      if(isset($attributes['contentStyles']['position']) && ($attributes['contentStyles']['position'] === "left" || $attributes['contentStyles']['position'] === "right")){
        if(isset($attributes['contentWidth'])){
          $css->set_selector('.premium-off-canvas-site-content-wrapper:has(~ .' . $unique_id . '[aria-hidden="false"] .premium-off-canvas-content.push-content)');
          $css->add_property('left', $css->render_string( ($attributes['contentStyles']['position'] === "right" ? "-" : "") . $css->render_range( $attributes['contentWidth'], 'Tablet'), '!important'));
        }
      }
      if(isset($attributes['contentStyles']['position']) && ($attributes['contentStyles']['position'] === "top" || $attributes['contentStyles']['position'] === "bottom")){
        if(isset($attributes['contentHeight'])){
          $css->set_selector('.premium-off-canvas-site-content-wrapper:has(~ .' . $unique_id . '[aria-hidden="false"] .premium-off-canvas-content.push-content)');
          $css->add_property('top', $css->render_string( ($attributes['contentStyles']['position'] === "bottom" ? "-" : "") . $css->render_range( $attributes['contentHeight'], 'Tablet'), '!important'));
        }
      }
    }
  }

  if(isset($attributes['contentStyles']['offCanvasType']) && $attributes['contentStyles']['offCanvasType'] === "corner"){
    if(isset($attributes['contentStyles']['cornerTransition']) && $attributes['contentStyles']['cornerTransition'] === "bounce-in"){
      if(isset($attributes['contentWidth'])){
        $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content.off-canvas-bounce-in.bounce-in-active');
        $css->add_property('width', $css->render_string( $css->render_range( $attributes['contentWidth'], 'Tablet'), '!important'));
      }
      if(isset($attributes['contentHeight'])){
        $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content.off-canvas-bounce-in.bounce-in-active');
        $css->add_property('height', $css->render_string( $css->render_range( $attributes['contentHeight'], 'Tablet'), '!important'));
      }
    }
  }

	$css->stop_media_query();
	$css->start_media_query( 'mobile' );

	// Mobile Styles.
  
  // Styles for Button Trigger
  if(isset($attributes['align']['Mobile'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger');
    $css->add_property('text-align', $css->get_responsive_css($attributes['align'], 'Mobile'));
  }

  if(isset($attributes['triggerTypography'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn');
    $css->render_typography($attributes['triggerTypography'], 'Mobile');
  }

  if(isset($attributes['triggerMargin'])){
    $trigger_margin = $attributes['triggerMargin'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn');
    $css->add_property('margin', $css->render_spacing($trigger_margin['Mobile'], $trigger_margin['unit']['Mobile']));
  }

  if(isset($attributes['triggerPadding'])){
    $trigger_padding = $attributes['triggerPadding'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn');
    $css->add_property('padding', $css->render_spacing($trigger_padding['Mobile'], $trigger_padding['unit']['Mobile']));
  }

  if(isset($attributes['triggerBorder'])){
    $trigger_border = $attributes['triggerBorder'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn');
    $css->render_border($trigger_border, 'Mobile');
  }

  if(isset($attributes['triggerStyles']['triggerBack'])){
    $trigger_backColor = $attributes['triggerStyles']['triggerBack'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn');
    $css->render_background( $trigger_backColor, 'Mobile' );
  }

  if(isset($attributes['triggerStyles']['triggerHoverBack'])){
    $trigger_hoverBack = $attributes['triggerStyles']['triggerHoverBack'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover');
    $css->render_background( $trigger_hoverBack, 'Mobile' );

    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-button__slide::before, ' . '.' . $unique_id . ' .premium-off-canvas-trigger .premium-button__shutter::before, ' . '.' . $unique_id . ' .premium-off-canvas-trigger .premium-button__radial::before' );
		$css->render_background( $trigger_hoverBack, 'Mobile' );
  }
  // End of Styles for Button Trigger

  // Styles for Icon inside Button Trigger
  if(isset($attributes['iconSize'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-icon svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-icon svg');
    $css->add_property( 'width', $css->render_string( $css->render_range( $attributes['iconSize'], 'Mobile' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attributes['iconSize'], 'Mobile' ), '!important' ) );
    
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-icon:not(.icon-type-fe) svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-icon:not(.icon-type-fe) svg');
    $css->add_property( 'width', $css->render_string( $css->render_range( $attributes['iconSize'], 'Mobile' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attributes['iconSize'], 'Mobile' ), '!important' ) );
    
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-svg-class svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class svg');
    $css->add_property( 'width', $css->render_string( $css->render_range( $attributes['iconSize'], 'Mobile' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attributes['iconSize'], 'Mobile' ), '!important' ) );
  }

  if(isset($attributes['imgWidth'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn img');
    $css->add_property( 'width', $css->render_string( $css->render_range( $attributes['imgWidth'], 'Mobile' ), '!important' ) );
    
		$css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-lottie-animation svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-lottie-animation svg');
    $css->add_property( 'width', $css->render_string( $css->render_range( $attributes['imgWidth'], 'Mobile' ), '!important' ) );
    $css->add_property( 'height', $css->render_string( $css->render_range( $attributes['imgWidth'], 'Mobile' ), '!important' ) );
  }
 
  if(isset($attributes['iconBorder'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-icon, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn img, .'. $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-svg-class svg, .'. $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-lottie-animation svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-lottie-animation svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-icon svg');
    $css->render_border($attributes['iconBorder'], 'Mobile'); 
  }

  if(isset($attributes['iconBG'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-icon, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn img, .'. $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-svg-class svg, .'. $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-lottie-animation svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-lottie-animation svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-icon svg');
    $css->render_background($attributes['iconBG'], 'Mobile'); 
  }

  if(isset($attributes['iconMargin'])){
    $icon_margin = $attributes['iconMargin'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-icon, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn img, .'. $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-svg-class svg, .'. $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-lottie-animation svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-lottie-animation svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-icon svg');
    $css->add_property('margin', $css->render_spacing($icon_margin['Mobile'], $icon_margin['unit']['Mobile']));
  }

  if(isset($attributes['iconPadding'])){
    $icon_padding = $attributes['iconPadding'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-icon, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn img, .'. $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-svg-class svg, .'. $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-lottie-animation svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-lottie-animation svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-icon svg');
    $css->add_property('padding', $css->render_spacing($icon_padding['Mobile'], $icon_padding['unit']['Mobile']));
  }

  if(isset($attributes['iconHoverBG'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover .premium-off-canvas-icon, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover .premium-off-canvas-svg-class svg, .'. $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover .premium-off-canvas-lottie-animation svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class:hover svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-lottie-animation:hover svg, .' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-icon:hover svg');
    $css->render_background($attributes['iconHoverBG'], 'Mobile'); 
  }
  // End of  Styles for Icon inside Button Trigger

  // Styles for Trigger Image
  if(isset($attributes['imgWidth']['Mobile'])){
    $css->set_selector( '.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-img' );
		$css->add_property( 'width', $css->render_range( $attributes['imgWidth'], 'Mobile' ) );
  }

  if(isset($attributes['triggerBorder'])){
    $trigger_border = $attributes['triggerBorder'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-img');
    $css->render_border($trigger_border, 'Mobile');
  }
  // End of Styles for Trigger Image

  // Styles for Content Panel
  if(isset($attributes['contentBackground'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content .premium-off-canvas-content-body');
    $css->render_background($attributes['contentBackground'], 'Mobile'); 
  }

  if(isset($attributes['contentBorder'])){
    $content_border = $attributes['contentBorder'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content .premium-off-canvas-content-body');
    $css->render_border($content_border, 'Mobile');
  }

  if(isset($attributes['contentPadding'])){
    $content_padding = $attributes['contentPadding'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content .premium-off-canvas-content-body');
    $css->add_property('padding', $css->render_spacing($content_padding['Mobile'], $content_padding['unit']['Mobile']));
  }
  
  if(isset($attributes['contentVerticalAlign'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content .premium-off-canvas-content-body');
    $css->add_property('justify-content', $css->get_responsive_css($attributes['contentVerticalAlign'], 'Mobile'));
  }
  // End of Styles for Content Panel

  // Styles for Close Button
  if(isset($attributes['closeMargin'])){
    $close_margin = $attributes['closeMargin'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content-close-button');
    $css->add_property('margin', $css->render_spacing($close_margin['Mobile'], $close_margin['unit']['Mobile']));
  }
  if(isset($attributes['closePadding'])){
    $close_padding = $attributes['closePadding'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content-close-button');
    $css->add_property('padding', $css->render_spacing($close_padding['Mobile'], $close_padding['unit']['Mobile']));
  }
  if(isset($attributes['closeBorder'])){
    $close_border = $attributes['closeBorder'];
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content-close-button');
    $css->render_border($close_border, 'Mobile');
  }
  if(isset($attributes['closeSize'])){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content-close-button');
    $css->add_property('width', $css->render_range($attributes['closeSize'], 'Mobile'));
    $css->add_property('height', $css->render_range($attributes['closeSize'], 'Mobile'));
  }
  // End of Styles for Close Button


  if(isset($attributes['contentStyles']['offCanvasType']) && $attributes['contentStyles']['offCanvasType'] === "corner"){
    if(isset($attributes['contentStyles']['cornerTransition']) && $attributes['contentStyles']['cornerTransition'] === "slide"){
      $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content.off-canvas-slide.' . $attributes['contentStyles']['cornerPosition']);
      $contentPosition = $attributes['contentStyles']['cornerPosition'];
      if(isset($attributes['contentHeight']['Mobile']) && $attributes['contentHeight']['Mobile'] !== ""){
        $css->add_property($contentPosition === "topleft" || $contentPosition === "topright" ? "top" : "bottom", $css->render_string("-",$css->render_range($attributes['contentHeight'], 'Mobile')));
        $css->add_property('height', $css->render_string( $css->render_range( $attributes['contentHeight'], 'Mobile'), '!important'));
      }
      if(isset($attributes['contentWidth']['Mobile']) && $attributes['contentWidth']['Mobile'] !== ""){
        $css->add_property($contentPosition === "topleft" || $contentPosition === "bottomleft" ? "left" : "right", $css->render_string("-",$css->render_range($attributes['contentWidth'], 'Mobile')));
        $css->add_property('width', $css->render_string( $css->render_range( $attributes['contentWidth'], 'Mobile'), '!important'));
      }
    }
  }

  if(isset($attributes['contentStyles']['offCanvasType']) && ($attributes['contentStyles']['offCanvasType'] === "slide")){
    if(isset($attributes['contentStyles']['position']) && ($attributes['contentStyles']['position'] === "left" || $attributes['contentStyles']['position'] === "right")){
      if(isset($attributes['contentWidth'])){
        $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content');
        $css->add_property('width', $css->render_string( $css->render_range( $attributes['contentWidth'], 'Mobile'), '!important'));
      }
    }
    if(isset($attributes['contentStyles']['position']) && ($attributes['contentStyles']['position'] === "top" || $attributes['contentStyles']['position'] === "bottom")){
      if(isset($attributes['contentHeight'])){
        $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content');
        $css->add_property('height', $css->render_string( $css->render_range( $attributes['contentHeight'], 'Mobile'), '!important'));
      }
    }
  }

  if(isset($attributes['contentStyles']['offCanvasType']) && ($attributes['contentStyles']['offCanvasType'] === "slide")){
    if(isset($attributes['contentStyles']['cornerTransition']) && $attributes['contentStyles']['transition'] === "push"){
      if(isset($attributes['contentStyles']['position']) && ($attributes['contentStyles']['position'] === "left" || $attributes['contentStyles']['position'] === "right")){
        if(isset($attributes['contentWidth'])){
          $css->set_selector('.premium-off-canvas-site-content-wrapper:has(~ .' . $unique_id . '[aria-hidden="false"] .premium-off-canvas-content.push-content)');
          $css->add_property('left', $css->render_string( ($attributes['contentStyles']['position'] === "right" ? "-" : "") . $css->render_range( $attributes['contentWidth'], 'Mobile'), '!important'));
        }
      }
      if(isset($attributes['contentStyles']['position']) && ($attributes['contentStyles']['position'] === "top" || $attributes['contentStyles']['position'] === "bottom")){
        if(isset($attributes['contentHeight'])){
          $css->set_selector('.premium-off-canvas-site-content-wrapper:has(~ .' . $unique_id . '[aria-hidden="false"] .premium-off-canvas-content.push-content)');
          $css->add_property('top', $css->render_string( ($attributes['contentStyles']['position'] === "bottom" ? "-" : "") . $css->render_range( $attributes['contentHeight'], 'Mobile'), '!important'));
        }
      }
    }
  }

  if(isset($attributes['contentStyles']['offCanvasType']) && $attributes['contentStyles']['offCanvasType'] === "corner"){
    if(isset($attributes['contentStyles']['cornerTransition']) && $attributes['contentStyles']['cornerTransition'] === "bounce-in"){
      if(isset($attributes['contentWidth'])){
        $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content.off-canvas-bounce-in.bounce-in-active');
        $css->add_property('width', $css->render_string( $css->render_range( $attributes['contentWidth'], 'Mobile'), '!important'));
      }
      if(isset($attributes['contentHeight'])){
        $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content.off-canvas-bounce-in.bounce-in-active');
        $css->add_property('height', $css->render_string( $css->render_range( $attributes['contentHeight'], 'Mobile'), '!important'));
      }
    }
  }

	$css->stop_media_query();

	return $css->css_output();
}

/**
 * Renders the `premium/my-block` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_off_canvas( $attributes, $content, $block ) {
  wp_enqueue_script(
    'pbg-off-canvas',
    PREMIUM_BLOCKS_URL . 'assets/js/minified/off-canvas.min.js',
    array(),
    PREMIUM_BLOCKS_VERSION,
    true  
  );
  
  if ( (isset( $attributes["iconTypeSelect"] ) && $attributes["iconTypeSelect"] == "lottie")  || (isset($attributes['triggerSettings']) && $attributes['triggerSettings']['trigger'] =='lottie')) {
    if (!wp_script_is('pbg-lottie', 'enqueued')) {
      wp_enqueue_script(
        'pbg-lottie',
        PREMIUM_BLOCKS_URL . 'assets/js/lib/lottie.min.js',
        array( 'jquery' ),
        PREMIUM_BLOCKS_VERSION,
        true
      );
    }
  }

  if (!wp_style_is('pbg-entrance-animation-css', 'enqueued')) {
    wp_enqueue_style(
      'pbg-entrance-animation-css',
      PREMIUM_BLOCKS_URL . 'assets/js/build/entrance-animation/editor/index.css',
      array(),
      PREMIUM_BLOCKS_VERSION,
      'all'
    );
  }
  
	return $content;
}


/**
 * Register the my block block.
 *
 * @uses render_block_pbg_my_block()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_off_canvas() {
	register_block_type(
		PREMIUM_BLOCKS_PATH . '/blocks-config/off-canvas',
		array(
			'render_callback' => 'render_block_pbg_off_canvas',
		)
	);
}

register_block_pbg_off_canvas();


