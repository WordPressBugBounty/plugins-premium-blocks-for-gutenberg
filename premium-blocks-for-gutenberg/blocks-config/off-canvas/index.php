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
  $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger');
  $css->pbg_render_value($attributes, 'align', 'text-align', 'Desktop');
  $css->pbg_render_spacing($attributes, 'triggerMargin', 'margin', 'Desktop');

  $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn');
  $css->pbg_render_spacing($attributes, 'triggerPadding', 'padding', 'Desktop');
  $css->pbg_render_border($attributes, 'triggerBorder', 'Desktop');
  $css->pbg_render_color($attributes, 'triggerStyles.color', 'color');
  $css->pbg_render_background($attributes, 'triggerStyles.triggerBack', 'Desktop');
  $css->pbg_render_shadow($attributes, 'triggerShadow', 'box-shadow');
  $css->pbg_render_shadow($attributes, 'triggerTextShadow', 'text-shadow');
  $css->pbg_render_typography($attributes, 'triggerTypography', 'Desktop');
  
  $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover');
  $css->pbg_render_color($attributes, 'triggerBorderH', 'border-color');  
  $css->pbg_render_color($attributes, 'triggerStyles.hoverColor', 'color');  
  $css->pbg_render_background($attributes, 'triggerStyles.triggerHoverBack', 'Desktop');
  $css->pbg_render_shadow($attributes, 'triggerShadowHover', 'box-shadow');

  $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-button__slide::before, ' . '.' . $unique_id . ' .premium-off-canvas-trigger .premium-button__shutter::before, ' . '.' . $unique_id . ' .premium-off-canvas-trigger .premium-button__radial::before' );
  $css->pbg_render_background($attributes, 'triggerStyles.triggerHoverBack', 'Desktop');
  // End of Styles for Button Trigger

  // Styles for Icon inside Button Trigger
  $icon_position = $css->pbg_get_value($attributes, 'iconPosition');
  if($icon_position){
    $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn.premium-button__' . $icon_position .' .premium-off-canvas-icon, .'. $unique_id .' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn.premium-button__' . $icon_position . ' img, .'. $unique_id .' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn.premium-button__'. $icon_position .' .premium-off-canvas-svg-class, .'. $unique_id .' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn.premium-button__'. $icon_position .' .premium-off-canvas-lottie-animation');
    if($icon_position === "before"){
      $css->pbg_render_range($attributes, 'triggerSettings.iconSpacing', 'margin-right', null, null, 'px');
    }
    if($icon_position === "after"){
      $css->pbg_render_range($attributes, 'triggerSettings.iconSpacing', 'margin-left', null, null, 'px');
    }
  }
  
  $css->set_selector(
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-icon svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-icon svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-svg-class svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class svg"
  );
  $css->pbg_render_range($attributes, 'iconSize', 'width', 'Desktop', null, '!important');
  $css->pbg_render_range($attributes, 'iconSize', 'height', 'Desktop', null, '!important');

  $css->set_selector(
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-lottie-animation svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-lottie-animation svg"
  );
  $css->pbg_render_range($attributes, 'imgWidth', 'width', 'Desktop', null, '!important');
  $css->pbg_render_range($attributes, 'imgWidth', 'height', 'Desktop', null, '!important');

  $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn img');
  $css->pbg_render_range($attributes, 'imgWidth', 'width', 'Desktop', null, '!important');

  $css->set_selector(
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-icon, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn img, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-svg-class svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-lottie-animation svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-lottie-animation svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-icon"
  );
  $css->pbg_render_border($attributes, 'iconBorder', 'Desktop');
  $css->pbg_render_spacing($attributes, 'iconMargin', 'margin', 'Desktop');
  $css->pbg_render_spacing($attributes, 'iconPadding', 'padding', 'Desktop');

  $css->set_selector(
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-icon, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-svg-class svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-lottie-animation svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-lottie-animation svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-icon"
  );
  $css->pbg_render_background($attributes, 'iconBG', 'Desktop'); 
  
  $css->set_selector(
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-icon, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-icon:not(.icon-type-fe) svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-icon:not(.icon-type-fe) svg *, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-svg-class svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-svg-class svg *, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class svg *, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-icon, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-icon:not(.icon-type-fe) svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-icon:not(.icon-type-fe) svg *"
  );
  $css->pbg_render_color($attributes, 'iconColor', 'color');
  $css->pbg_render_color($attributes, 'iconColor', 'fill');

  $css->set_selector(
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover .premium-off-canvas-icon, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-icon:hover, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover .premium-off-canvas-svg-class svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class:hover svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover .premium-off-canvas-lottie-animation svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-lottie-animation:hover svg"
  );
  $css->pbg_render_color($attributes, 'borderHoverColor', 'border-color', null, '!important');
  $css->pbg_render_background($attributes, 'iconHoverBG', 'Desktop');
  
  $css->set_selector(
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover .premium-off-canvas-icon, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-icon:hover, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover .premium-off-canvas-svg-class svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class:hover svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover .premium-off-canvas-icon:not(.icon-type-fe) svg *, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-icon:not(.icon-type-fe):hover svg *, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover .premium-off-canvas-svg-class svg *, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class:hover svg *"
  );
  $css->pbg_render_color($attributes, 'iconHoverColor', 'color', null, '!important');
  $css->pbg_render_color($attributes, 'iconHoverColor', 'fill', null, '!important');
  // End of  Styles for Icon inside Button Trigger

  // Styles for Trigger Image
  $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-img');
  $css->pbg_render_range($attributes, 'imgWidth', 'width', 'Desktop');
  $css->pbg_render_border($attributes, 'triggerBorder', 'Desktop');
  $css->pbg_render_spacing($attributes, 'triggerPadding', 'padding', 'Desktop');
  $css->pbg_render_shadow($attributes, 'triggerShadow', 'box-shadow');

  $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-img:hover');
  $css->pbg_render_color($attributes, 'triggerBorderH', 'border-color'); 
  $css->pbg_render_shadow($attributes,'triggerShadowHover', 'box-shadow');
  // End of Styles for Trigger Image

  // Styles for Content Panel
  $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content .premium-off-canvas-content-body');
  $css->pbg_render_background($attributes, 'contentBackground', 'Desktop');
  $css->pbg_render_spacing($attributes, 'contentPadding', 'padding', 'Desktop');  
  $css->pbg_render_value($attributes, 'contentVerticalAlign', 'justify-content', 'Desktop');
  $css->pbg_render_border($attributes, 'contentBorder', 'Desktop');
  $css->pbg_render_shadow($attributes, 'contentShadow', 'box-shadow');
  // End of Styles for Content Panel

  // Styles for Close Button  
  $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content-close-button');
  $css->pbg_render_spacing($attributes, 'closeMargin', 'margin', 'Desktop');
  $css->pbg_render_spacing($attributes, 'closePadding', 'padding', 'Desktop');
  $css->pbg_render_range($attributes, 'closeSize', 'width', 'Desktop');
  $css->pbg_render_range($attributes, 'closeSize', 'height', 'Desktop');
  $css->pbg_render_border($attributes, 'closeBorder', 'Desktop');
  $css->pbg_render_color($attributes, 'closeStyles.backColor', 'background-color');
  
  $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content-close-button svg, .'. $unique_id . ' .premium-off-canvas-content-close-button svg *');
  $css->pbg_render_color($attributes, 'closeStyles.color', 'fill');
  
  $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content-close-button:hover');
  $css->pbg_render_color($attributes, 'closeStyles.hoverBackColor', 'background-color');
  $css->pbg_render_color($attributes, 'closeBorderHC', 'border-color');
  
  $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content-close-button:hover svg, .' . $unique_id . ' .premium-off-canvas-content-close-button:hover svg *');
  $css->pbg_render_color($attributes, 'closeStyles.hoverColor', 'fill');
  // End of Styles for Close Button

  if(isset($attributes['contentStyles']['offCanvasType']) && ($attributes['contentStyles']['offCanvasType'] === "slide")){
    $position = $attributes['contentStyles']['position'] ?? null;
    $transition = $attributes['contentStyles']['transition'] ?? null;

    if($position === "left" || $position === "right"){
      $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content');
      $css->pbg_render_range($attributes, 'contentWidth', 'width', 'Desktop', null, '!important');

      if($transition === "push"){
        $css->set_selector('.premium-off-canvas-site-content-wrapper:has(~ .' . $unique_id . '[aria-hidden="false"] .premium-off-canvas-content)');
        $css->pbg_render_range($attributes, 'contentWidth', 'left', 'Desktop', $position === "right" ? "-" : "", '!important');
      }
    }
    if($position === "top" || $position === "bottom"){
      $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content');
      $css->pbg_render_range($attributes, 'contentHeight', 'height', 'Desktop', null, '!important');

      if($transition === "push"){
        $css->set_selector('.premium-off-canvas-site-content-wrapper:has(~ .' . $unique_id . '[aria-hidden="false"] .premium-off-canvas-content)');
        $css->pbg_render_range($attributes, 'contentHeight', 'top', 'Desktop', $position === "bottom" ? "-" : "", '!important');   
      }
    }
  }

  if(isset($attributes['contentStyles']['offCanvasType']) && $attributes['contentStyles']['offCanvasType'] === "corner"){
    $corner_transition = $attributes['contentStyles']['cornerTransition'] ?? null;

    if($corner_transition === "slide"){
      $contentPosition = $attributes['contentStyles']['cornerPosition'];
      $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content.off-canvas-slide.' . $attributes['contentStyles']['cornerPosition']);

      $css->pbg_render_range($attributes, 'contentHeight', $contentPosition === "topleft" || $contentPosition === "topright" ? "top" : "bottom", 'Desktop', '-', null);
      $css->pbg_render_range($attributes, 'contentHeight', 'height', 'Desktop', null, '!important');

      $css->pbg_render_range($attributes, 'contentWidth', $contentPosition === "topleft" || $contentPosition === "bottomleft" ? "left" : "right", 'Desktop', '-', null);
      $css->pbg_render_range($attributes, 'contentWidth', 'width', 'Desktop', null, '!important');
    }

    if($corner_transition === "bounce-in"){
      $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content.off-canvas-bounce-in.panel-active');
      $css->pbg_render_range($attributes, 'contentWidth', 'width', 'Desktop', null, '!important');
    
      $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content.off-canvas-bounce-in.panel-active');
      $css->pbg_render_range($attributes, 'contentHeight', 'height', 'Desktop', null, '!important');
    }
  }
  
  // Tablet Styles.
	$css->start_media_query( 'tablet' );

  // Styles for Button Trigger
  $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger');
  $css->pbg_render_value($attributes, 'align', 'text-align', 'Tablet');
  $css->pbg_render_spacing($attributes, 'triggerMargin', 'margin', 'Tablet');

  $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn');
  $css->pbg_render_spacing($attributes, 'triggerPadding', 'padding', 'Tablet');
  $css->pbg_render_border($attributes, 'triggerBorder', 'Tablet');
  $css->pbg_render_background($attributes, 'triggerStyles.triggerBack', 'Tablet');
  $css->pbg_render_typography($attributes, 'triggerTypography', 'Tablet');

  $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover');
  $css->pbg_render_background($attributes, 'triggerStyles.triggerHoverBack', 'Tablet');

  $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-button__slide::before, ' . '.' . $unique_id . ' .premium-off-canvas-trigger .premium-button__shutter::before, ' . '.' . $unique_id . ' .premium-off-canvas-trigger .premium-button__radial::before' );
  $css->pbg_render_background($attributes, 'triggerStyles.triggerHoverBack', 'Tablet');
  // End of Styles for Button Trigger

  // Styles for Icon inside Button Trigger
  $css->set_selector(
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-icon svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-icon svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-svg-class svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class svg"
  );
  $css->pbg_render_range($attributes, 'iconSize', 'width', 'Tablet', null, '!important');
  $css->pbg_render_range($attributes, 'iconSize', 'height', 'Tablet', null, '!important');

  $css->set_selector(
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-lottie-animation svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-lottie-animation svg"
  );
  $css->pbg_render_range($attributes, 'imgWidth', 'width', 'Tablet', null, '!important');
  $css->pbg_render_range($attributes, 'imgWidth', 'height', 'Tablet', null, '!important');
  
  $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn img');
  $css->pbg_render_range($attributes, 'imgWidth', 'width', 'Tablet', null, '!important');
 
  $css->set_selector(
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-icon, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn img, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-svg-class svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-lottie-animation svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-lottie-animation svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-icon"
  );
  $css->pbg_render_border($attributes, 'iconBorder', 'Tablet');
  $css->pbg_render_spacing($attributes, 'iconMargin', 'margin', 'Tablet');
  $css->pbg_render_spacing($attributes, 'iconPadding', 'padding', 'Tablet');

  $css->set_selector(
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-icon, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-svg-class svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-lottie-animation svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-lottie-animation svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-icon"
  );
  $css->pbg_render_background($attributes, 'iconBG', 'Tablet'); 

  $css->set_selector(
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover .premium-off-canvas-icon, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-icon:hover, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover .premium-off-canvas-svg-class svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class:hover svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover .premium-off-canvas-lottie-animation svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-lottie-animation:hover svg"
  );
  $css->pbg_render_background($attributes, 'iconHoverBG', 'Tablet');
  // End of  Styles for Icon inside Button Trigger

  // Styles for Trigger Image
  $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-img');
  $css->pbg_render_range($attributes, 'imgWidth', 'width', 'Tablet');
  $css->pbg_render_border($attributes, 'triggerBorder', 'Tablet');
  $css->pbg_render_spacing($attributes, 'triggerPadding', 'padding', 'Tablet');
  // End of Styles for Trigger Image

  // Styles for Content Panel
  $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content .premium-off-canvas-content-body');
  $css->pbg_render_background($attributes, 'contentBackground', 'Tablet');
  $css->pbg_render_spacing($attributes, 'contentPadding', 'padding', 'Tablet');  
  $css->pbg_render_value($attributes, 'contentVerticalAlign', 'justify-content', 'Tablet');
  $css->pbg_render_border($attributes, 'contentBorder', 'Tablet');
  // End of Styles for Content Panel

  // Styles for Close Button
  $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content-close-button');
  $css->pbg_render_spacing($attributes, 'closeMargin', 'margin', 'Tablet');
  $css->pbg_render_spacing($attributes, 'closePadding', 'padding', 'Tablet');
  $css->pbg_render_range($attributes, 'closeSize', 'width', 'Tablet');
  $css->pbg_render_range($attributes, 'closeSize', 'height', 'Tablet');
  $css->pbg_render_border($attributes, 'closeBorder', 'Tablet');
  // End of Styles for Close Button

  if(isset($attributes['contentStyles']['offCanvasType']) && ($attributes['contentStyles']['offCanvasType'] === "slide")){
    $position = $attributes['contentStyles']['position'] ?? null;
    $transition = $attributes['contentStyles']['transition'] ?? null;

    if($position === "left" || $position === "right"){
      $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content');
      $css->pbg_render_range($attributes, 'contentWidth', 'width', 'Tablet', null, '!important');

      if($transition === "push"){
        $css->set_selector('.premium-off-canvas-site-content-wrapper:has(~ .' . $unique_id . '[aria-hidden="false"] .premium-off-canvas-content)');
        $css->pbg_render_range($attributes, 'contentWidth', 'left', 'Tablet', $position === "right" ? "-" : "", '!important');
      }
    }
    if($position === "top" || $position === "bottom"){
      $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content');
      $css->pbg_render_range($attributes, 'contentHeight', 'height', 'Tablet', null, '!important');

      if($transition === "push"){
        $css->set_selector('.premium-off-canvas-site-content-wrapper:has(~ .' . $unique_id . '[aria-hidden="false"] .premium-off-canvas-content)');
        $css->pbg_render_range($attributes, 'contentHeight', 'top', 'Tablet', $position === "bottom" ? "-" : "", '!important');   
      }
    }
  }

  if(isset($attributes['contentStyles']['offCanvasType']) && $attributes['contentStyles']['offCanvasType'] === "corner"){
    $corner_transition = $attributes['contentStyles']['cornerTransition'] ?? null;

    if($corner_transition === "slide"){
      $contentPosition = $attributes['contentStyles']['cornerPosition'];
      $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content.off-canvas-slide.' . $attributes['contentStyles']['cornerPosition']);

      $css->pbg_render_range($attributes, 'contentHeight', $contentPosition === "topleft" || $contentPosition === "topright" ? "top" : "bottom", 'Tablet', '-', null);
      $css->pbg_render_range($attributes, 'contentHeight', 'height', 'Tablet', null, '!important');

      $css->pbg_render_range($attributes, 'contentWidth', $contentPosition === "topleft" || $contentPosition === "bottomleft" ? "left" : "right", 'Tablet', '-', null);
      $css->pbg_render_range($attributes, 'contentWidth', 'width', 'Tablet', null, '!important');
    }

    if($corner_transition === "bounce-in"){
      $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content.off-canvas-bounce-in.panel-active');
      $css->pbg_render_range($attributes, 'contentWidth', 'width', 'Tablet', null, '!important');
    
      $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content.off-canvas-bounce-in.panel-active');
      $css->pbg_render_range($attributes, 'contentHeight', 'height', 'Tablet', null, '!important');
    }
  }
	$css->stop_media_query();
  
	// Mobile Styles.
	$css->start_media_query( 'mobile' );
  
  // Styles for Button Trigger
  $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger');
  $css->pbg_render_value($attributes, 'align', 'text-align', 'Mobile');
  $css->pbg_render_spacing($attributes, 'triggerMargin', 'margin', 'Mobile');
  
  $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn');
  $css->pbg_render_spacing($attributes, 'triggerPadding', 'padding', 'Mobile');
  $css->pbg_render_border($attributes, 'triggerBorder', 'Mobile');
  $css->pbg_render_background($attributes, 'triggerStyles.triggerBack', 'Mobile');
  $css->pbg_render_typography($attributes, 'triggerTypography', 'Mobile');

  $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover');
  $css->pbg_render_background($attributes, 'triggerStyles.triggerHoverBack', 'Mobile');

  $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-button__slide::before, ' . '.' . $unique_id . ' .premium-off-canvas-trigger .premium-button__shutter::before, ' . '.' . $unique_id . ' .premium-off-canvas-trigger .premium-button__radial::before' );
  $css->pbg_render_background($attributes, 'triggerStyles.triggerHoverBack', 'Mobile');
  // End of Styles for Button Trigger

  // Styles for Icon inside Button Trigger
  $css->set_selector(
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-icon svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-icon svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-svg-class svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class svg"
  );
  $css->pbg_render_range($attributes, 'iconSize', 'width', 'Mobile', null, '!important');
  $css->pbg_render_range($attributes, 'iconSize', 'height', 'Mobile', null, '!important');

  $css->set_selector(
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-lottie-animation svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-lottie-animation svg"
  );
  $css->pbg_render_range($attributes, 'imgWidth', 'width', 'Mobile', null, '!important');
  $css->pbg_render_range($attributes, 'imgWidth', 'height', 'Mobile', null, '!important');
  
  $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-btn img');
  $css->pbg_render_range($attributes, 'imgWidth', 'width', 'Mobile', null, '!important');
 
  $css->set_selector(
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-icon, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn img, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-svg-class svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-lottie-animation svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-lottie-animation svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-icon"
  );
  $css->pbg_render_border($attributes, 'iconBorder', 'Mobile');
  $css->pbg_render_spacing($attributes, 'iconMargin', 'margin', 'Mobile');
  $css->pbg_render_spacing($attributes, 'iconPadding', 'padding', 'Mobile');

  $css->set_selector(
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-icon, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-svg-class svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn .premium-off-canvas-lottie-animation svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-lottie-animation svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-icon"
  );
  $css->pbg_render_background($attributes, 'iconBG', 'Mobile'); 

  $css->set_selector(
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover .premium-off-canvas-icon, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-icon:hover, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover .premium-off-canvas-svg-class svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-svg-class:hover svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-btn:hover .premium-off-canvas-lottie-animation svg, " .
    ".{$unique_id} .premium-off-canvas-trigger .premium-off-canvas-trigger-lottie-animation:hover svg"
  );
  $css->pbg_render_background($attributes, 'iconHoverBG', 'Mobile');
  // End of  Styles for Icon inside Button Trigger

  // Styles for Trigger Image
  $css->set_selector('.' . $unique_id . ' .premium-off-canvas-trigger .premium-off-canvas-trigger-img');
  $css->pbg_render_range($attributes, 'imgWidth', 'width', 'Mobile');
  $css->pbg_render_border($attributes, 'triggerBorder', 'Mobile');
  $css->pbg_render_spacing($attributes, 'triggerPadding', 'padding', 'Mobile');
  // End of Styles for Trigger Image

  // Styles for Content Panel
  $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content .premium-off-canvas-content-body');
  $css->pbg_render_background($attributes, 'contentBackground', 'Mobile');
  $css->pbg_render_spacing($attributes, 'contentPadding', 'padding', 'Mobile');  
  $css->pbg_render_value($attributes, 'contentVerticalAlign', 'justify-content', 'Mobile');
  $css->pbg_render_border($attributes, 'contentBorder', 'Mobile');
  // End of Styles for Content Panel

  // Styles for Close Button
  $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content-close-button');
  $css->pbg_render_spacing($attributes, 'closeMargin', 'margin', 'Mobile');
  $css->pbg_render_spacing($attributes, 'closePadding', 'padding', 'Mobile');
  $css->pbg_render_range($attributes, 'closeSize', 'width', 'Mobile');
  $css->pbg_render_range($attributes, 'closeSize', 'height', 'Mobile');
  $css->pbg_render_border($attributes, 'closeBorder', 'Mobile');
  // End of Styles for Close Button

  if(isset($attributes['contentStyles']['offCanvasType']) && ($attributes['contentStyles']['offCanvasType'] === "slide")){
    $position = $attributes['contentStyles']['position'] ?? null;
    $transition = $attributes['contentStyles']['transition'] ?? null;

    if($position === "left" || $position === "right"){
      $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content');
      $css->pbg_render_range($attributes, 'contentWidth', 'width', 'Mobile', null, '!important');

      if($transition === "push"){
        $css->set_selector('.premium-off-canvas-site-content-wrapper:has(~ .' . $unique_id . '[aria-hidden="false"] .premium-off-canvas-content)');
        $css->pbg_render_range($attributes, 'contentWidth', 'left', 'Mobile', $position === "right" ? "-" : "", '!important');
      }
    }
    if($position === "top" || $position === "bottom"){
      $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content');
      $css->pbg_render_range($attributes, 'contentHeight', 'height', 'Mobile', null, '!important');

      if($transition === "push"){
        $css->set_selector('.premium-off-canvas-site-content-wrapper:has(~ .' . $unique_id . '[aria-hidden="false"] .premium-off-canvas-content)');
        $css->pbg_render_range($attributes, 'contentHeight', 'top', 'Mobile', $position === "bottom" ? "-" : "", '!important');   
      }
    }
  }

  if(isset($attributes['contentStyles']['offCanvasType']) && $attributes['contentStyles']['offCanvasType'] === "corner"){
    $corner_transition = $attributes['contentStyles']['cornerTransition'] ?? null;

    if($corner_transition === "slide"){
      $contentPosition = $attributes['contentStyles']['cornerPosition'];
      $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content.off-canvas-slide.' . $attributes['contentStyles']['cornerPosition']);

      $css->pbg_render_range($attributes, 'contentHeight', $contentPosition === "topleft" || $contentPosition === "topright" ? "top" : "bottom", 'Mobile', '-', null);
      $css->pbg_render_range($attributes, 'contentHeight', 'height', 'Mobile', null, '!important');

      $css->pbg_render_range($attributes, 'contentWidth', $contentPosition === "topleft" || $contentPosition === "bottomleft" ? "left" : "right", 'Mobile', '-', null);
      $css->pbg_render_range($attributes, 'contentWidth', 'width', 'Mobile', null, '!important');
    }

    if($corner_transition === "bounce-in"){
      $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content.off-canvas-bounce-in.panel-active');
      $css->pbg_render_range($attributes, 'contentWidth', 'width', 'Mobile', null, '!important');

      $css->set_selector('.' . $unique_id . ' .premium-off-canvas-content.off-canvas-bounce-in.panel-active');
      $css->pbg_render_range($attributes, 'contentHeight', 'height', 'Mobile', null, '!important');
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

  if(isset($attributes['contentEntranceAnimation']['contentAnimation']) && $attributes['contentEntranceAnimation']['contentAnimation']){
    if (!wp_style_is('pbg-entrance-animation-css', 'enqueued')) {
      wp_enqueue_style(
        'pbg-entrance-animation-css',
        PREMIUM_BLOCKS_URL . 'assets/js/build/entrance-animation/editor/index.css',
        array(),
        PREMIUM_BLOCKS_VERSION,
        'all'
      );
    }
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


