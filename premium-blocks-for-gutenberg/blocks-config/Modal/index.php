<?php

/**
 * Server-side rendering of the `pbg/modal` block.
 *
 * @package WordPress
 */

/**
 * Get Modal Block CSS
 *
 * Return Frontend CSS for Modal.
 *
 * @access public
 *
 * @param array  $attr      Block attributes.
 * @param string $unique_id Block ID.
 */
function get_premium_modal_css_style($attr, $unique_id)
{
	$css = new Premium_Blocks_css();

	// Trigger Container Alignment
	$css->set_selector('.' . $unique_id . ' > .premium-modal-trigger-container');
	$css->pbg_render_value($attr, 'align', 'text-align', 'Desktop');

  $css->set_selector('.' . $unique_id . ' > .premium-modal-trigger-container .premium-modal-trigger-btn');
  $css->pbg_render_color( $attr, 'triggerStyles[0].color', 'color' );
  $css->pbg_render_color( $attr, 'triggerStyles[0].triggerBack', 'background-color' );
  $css->pbg_render_shadow( $attr, 'triggerShadow', 'box-shadow' );
  $css->pbg_render_border( $attr, 'triggerBorder', 'Desktop' );
  $css->pbg_render_spacing( $attr, 'triggerPadding', 'padding', "Desktop" );
  $css->pbg_render_typography( $attr, 'triggerTypography', 'Desktop' );

  $css->set_selector('.' . $unique_id . ' > .premium-modal-trigger-container .premium-modal-trigger-btn:hover');
  $css->pbg_render_color( $attr, 'triggerStyles[0].hoverColor', 'color', '', '!important' ); // important to override inline style -- backward compatibility
  $css->pbg_render_color( $attr, 'triggerStyles[0].triggerHoverBack', 'background-color', '', '!important' ); // important to override inline style -- backward compatibility
  $css->pbg_render_border( $attr, 'triggerBorderH', 'Desktop' );

  // icon Styles
  $css->set_selector(
    ".{$unique_id} > .premium-modal-trigger-container .premium-modal-trigger-btn .premium-modal-box-icon svg, " .
    ".{$unique_id} > .premium-modal-trigger-container .premium-modal-trigger-btn .premium-modal-svg-class svg"
  );
  $css->pbg_render_range($attr, 'iconSize', 'width', 'Desktop', null, '!important');
  $css->pbg_render_range($attr, 'iconSize', 'height', 'Desktop', null, '!important');

	// common icon type style
  $css->set_selector(
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn .premium-modal-box-icon, " .
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn img, " .
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn .premium-modal-svg-class svg, " .
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn .premium-lottie-animation svg"
  );
  $css->pbg_render_border($attr, 'iconBorder', 'Desktop');
  $css->pbg_render_spacing($attr, 'iconPadding', 'padding', "Desktop");
  $css->pbg_render_spacing($attr, 'iconMargin', 'margin', 'Desktop');

	// image style
  $css->set_selector('.' . $unique_id . ' .premium-modal-trigger-container .premium-modal-trigger-btn img');
  $css->pbg_render_range($attr, 'imgWidth', 'width', 'Desktop', null, '!important');

  $css->set_selector('.' . $unique_id . ' .premium-modal-trigger-container .premium-modal-trigger-btn .premium-lottie-animation svg');
  $css->pbg_render_range($attr, 'imgWidth', 'width', 'Desktop', null, '!important');
  $css->pbg_render_range($attr, 'imgWidth', 'height', 'Desktop', null, '!important');

	// svg styles
  $css->set_selector( 
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn .premium-modal-box-icon, " .
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn .premium-modal-box-icon:not(.icon-type-fe) svg, " .
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn .premium-modal-box-icon:not(.icon-type-fe) svg *, " .
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn .premium-modal-svg-class svg, " .
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn .premium-modal-svg-class svg *"
  );
  $css->pbg_render_color($attr, 'iconColor', 'color');
  $css->pbg_render_color($attr, 'iconColor', 'fill');

  $css->set_selector(
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn .premium-modal-box-icon, " .
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn .premium-modal-svg-class svg, " .
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn .premium-lottie-animation svg"
  );
  $css->pbg_render_background($attr, 'iconBG', 'Desktop');

  $css->set_selector( 
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn:hover .premium-modal-box-icon, " .
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn:hover .premium-modal-box-icon:not(.icon-type-fe) svg *, " .
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn:hover .premium-modal-svg-class svg, " .
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn:hover .premium-modal-svg-class svg *"
  );
  $css->pbg_render_color($attr, 'iconHoverColor', 'color');
  $css->pbg_render_color($attr, 'iconHoverColor', 'fill');

  $css->set_selector(
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn:hover .premium-modal-box-icon, " .
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn:hover .premium-modal-svg-class svg, " .
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn:hover .premium-lottie-animation svg"
  );
  $css->pbg_render_color($attr, 'borderHoverColor', 'border-color');
  $css->pbg_render_background($attr, 'iconHoverBG', 'Desktop');

  // Icon Spacing
  $css->set_selector(
    ".{$unique_id} .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-modal-box-icon, " .
    ".{$unique_id} .premium-modal-trigger-container button.premium-modal-trigger-btn img, " .
    ".{$unique_id} .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-modal-svg-class svg, " .
    ".{$unique_id} .premium-modal-trigger-container button.premium-modal-trigger-btn .premium-lottie-animation svg"
  );
  $icon_position = $css->pbg_get_value($attr, 'triggerSettings[0].iconPosition');
  $css->pbg_render_range($attr, 'triggerSettings[0].iconSpacing', $icon_position === "before" ? 'margin-right' : 'margin-left', '', '', 'px');

  // Trigger Image
  $css->set_selector('.' . $unique_id . ' > .premium-modal-trigger-container .premium-modal-trigger-img');
  $css->pbg_render_shadow($attr, 'triggerShadow', 'box-shadow');
  $css->pbg_render_range($attr, 'imageWidth', 'width', 'Desktop');
  $css->pbg_render_border($attr, 'triggerBorder', 'Desktop');

  // Trigger Image Hover
  $css->set_selector('.' . $unique_id . ' > .premium-modal-trigger-container .premium-modal-trigger-img:hover');
  $css->pbg_render_border($attr, 'triggerBorderH', 'Desktop');
  
  // Trigger Text
  $css->set_selector('.' . $unique_id . ' > .premium-modal-trigger-container .premium-modal-trigger-text');
  $css->pbg_render_border($attr, 'triggerBorder', 'Desktop');
  $css->pbg_render_spacing($attr, 'triggerPadding', 'padding', 'Desktop');
  $css->pbg_render_typography($attr, 'triggerTypography', 'Desktop');
  $css->pbg_render_color($attr, 'triggerStyles[0].color', 'color');
  $css->pbg_render_shadow($attr, 'triggerTextShadow', 'text-shadow');

  // Trigger Text Hover
  $css->set_selector('.' . $unique_id . ' > .premium-modal-trigger-container .premium-modal-trigger-text:hover');
  $css->pbg_render_border($attr, 'triggerBorderH', 'Desktop');
  $css->pbg_render_color($attr, 'triggerStyles[0].hoverColor', 'color', '', '!important'); // important to override inline style -- backward compatibility

  // Trigger Lottie
  $css->set_selector('.' . $unique_id . ' > .premium-modal-trigger-container > .premium-lottie-animation svg');
  $css->pbg_render_range($attr, 'imageWidth', 'width', 'Desktop');
  $css->pbg_render_range($attr, 'imageWidth', 'height', 'Desktop');

  // Trigger Lottie Filter
  $css->set_selector('.' . $unique_id . ' > .premium-modal-trigger-container > .premium-lottie-animation');
  $css->pbg_render_filters($attr, 'triggerFilter');

  // Trigger Lottie Filter
  $css->set_selector('.' . $unique_id . ' > .premium-modal-trigger-container > .premium-lottie-animation:hover');
  $css->pbg_render_filters($attr, 'triggerHoverFilter');

  // Close Button
  $css->set_selector('.' . $unique_id . ' .premium-modal-box-close-button-container .premium-modal-box-modal-close');
  $css->pbg_render_color($attr, 'upperStyles[0].color', 'color');
  $css->pbg_render_color($attr, 'upperStyles[0].color', 'fill');
  $css->pbg_render_color($attr, 'upperStyles[0].backColor', 'background-color');
  $css->pbg_render_border($attr, 'upperBorder', 'Desktop');
  $css->pbg_render_spacing($attr, 'upperPadding', 'padding', 'Desktop');

  $css->set_selector('.' . $unique_id . ' .premium-modal-box-close-button-container .premium-modal-box-modal-close svg');
  $css->pbg_render_range($attr, 'upperIconWidth', 'width', 'Desktop');
  $css->pbg_render_range($attr, 'upperIconWidth', 'height', 'Desktop');

  $css->set_selector('.' . $unique_id . ' .premium-modal-box-close-button-container:hover .premium-modal-box-modal-close');
  $css->pbg_render_color($attr, 'upperStyles[0].hoverColor', 'color', '', '!important'); // important to override inline style -- backward compatibility
  $css->pbg_render_color($attr, 'upperStyles[0].hoverColor', 'fill', '', '!important'); // important to override inline style -- backward compatibility
  $css->pbg_render_color($attr, 'upperStyles[0].hoverBackColor', 'background-color', '', '!important'); // important to override inline style -- backward compatibility

  // Modal Wrapper
  $css->set_selector('.' . $unique_id . '.premium-popup__modal_wrap .premium-popup__modal_content');
  $css->pbg_render_border($attr, 'modalBorder', 'Desktop');
  $css->pbg_render_range($attr, 'modalWidth', 'width', 'Desktop');
  $css->pbg_render_range($attr, 'modalHeight', 'max-height', 'Desktop');
  $css->pbg_render_shadow($attr, 'modalShadow', 'box-shadow');
  $css->pbg_render_background($attr, 'containerBackground', 'Desktop');

  // Modal Body
  // $css->set_selector('.' . $unique_id . '.premium-popup__modal_wrap .premium-modal-box-modal-body');
  // $css->pbg_render_background($attr, 'containerBackground', 'Desktop');

  // Modal Body Padding
  $css->set_selector('.' . $unique_id . '.premium-popup__modal_wrap .premium-modal-box-modal-body .premium-modal-box-modal-body-content');
  $css->pbg_render_spacing($attr, 'modalPadding', 'padding', 'Desktop');

  // Modal Overlay
  $css->set_selector('.' . $unique_id . '.premium-popup__modal_wrap .premium-popup__modal_wrap_overlay');
  $css->pbg_render_background($attr, 'modalBackground', 'Desktop');

  // Close Button Position
  $close_button_position = $css->pbg_get_value($attr, 'closePosition');
  $css->set_selector('.' . $unique_id . '.premium-popup__modal_wrap .premium-popup__modal_content .premium-modal-box-close-button-container');
  if ($close_button_position === 'top-right'){
    $css->add_property( 'left', '100%');
  } elseif ($close_button_position === 'top-left'){
    $css->add_property( 'right', '100%');
  }

	$css->start_media_query('tablet');

  // Trigger Container Alignment
	$css->set_selector('.' . $unique_id . ' > .premium-modal-trigger-container');
	$css->pbg_render_value($attr, 'align', 'text-align', 'Tablet');

  $css->set_selector('.' . $unique_id . ' > .premium-modal-trigger-container .premium-modal-trigger-btn');
  $css->pbg_render_border( $attr, 'triggerBorder', 'Tablet' );
  $css->pbg_render_spacing( $attr, 'triggerPadding', 'padding', "Tablet" );
  $css->pbg_render_typography( $attr, 'triggerTypography', 'Tablet' );

  $css->set_selector('.' . $unique_id . ' > .premium-modal-trigger-container .premium-modal-trigger-btn:hover');
  $css->pbg_render_border( $attr, 'triggerBorderH', 'Tablet' );

  // icon Styles
  $css->set_selector(
    ".{$unique_id} > .premium-modal-trigger-container .premium-modal-trigger-btn .premium-modal-box-icon svg, " .
    ".{$unique_id} > .premium-modal-trigger-container .premium-modal-trigger-btn .premium-modal-svg-class svg"
  );
  $css->pbg_render_range($attr, 'iconSize', 'width', 'Tablet', null, '!important');
  $css->pbg_render_range($attr, 'iconSize', 'height', 'Tablet', null, '!important');

	// common icon type style
  $css->set_selector(
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn .premium-modal-box-icon, " .
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn img, " .
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn .premium-modal-svg-class svg, " .
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn .premium-lottie-animation svg"
  );
  $css->pbg_render_border($attr, 'iconBorder', 'Tablet');
  $css->pbg_render_spacing($attr, 'iconPadding', 'padding', "Tablet");
  $css->pbg_render_spacing($attr, 'iconMargin', 'margin', 'Tablet');

	// image style
  $css->set_selector('.' . $unique_id . ' .premium-modal-trigger-container .premium-modal-trigger-btn img');
  $css->pbg_render_range($attr, 'imgWidth', 'width', 'Tablet', null, '!important');

  $css->set_selector('.' . $unique_id . ' .premium-modal-trigger-container .premium-modal-trigger-btn .premium-lottie-animation svg');
  $css->pbg_render_range($attr, 'imgWidth', 'width', 'Tablet', null, '!important');
  $css->pbg_render_range($attr, 'imgWidth', 'height', 'Tablet', null, '!important');

	// svg styles
  $css->set_selector(
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn .premium-modal-box-icon, " .
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn .premium-modal-svg-class svg, " .
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn .premium-lottie-animation svg"
  );
  $css->pbg_render_background($attr, 'iconBG', 'Tablet');

  $css->set_selector(
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn:hover .premium-modal-box-icon, " .
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn:hover .premium-modal-svg-class svg, " .
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn:hover .premium-lottie-animation svg"
  );
  $css->pbg_render_background($attr, 'iconHoverBG', 'Tablet');

  // Trigger Image
  $css->set_selector('.' . $unique_id . ' > .premium-modal-trigger-container .premium-modal-trigger-img');
  $css->pbg_render_range($attr, 'imageWidth', 'width', 'Tablet');
  $css->pbg_render_border($attr, 'triggerBorder', 'Tablet');

  // Trigger Image Hover
  $css->set_selector('.' . $unique_id . ' > .premium-modal-trigger-container .premium-modal-trigger-img:hover');
  $css->pbg_render_border($attr, 'triggerBorderH', 'Tablet');

  // Trigger Text
  $css->set_selector('.' . $unique_id . ' > .premium-modal-trigger-container .premium-modal-trigger-text');
  $css->pbg_render_border($attr, 'triggerBorder', 'Tablet');
  $css->pbg_render_spacing($attr, 'triggerPadding', 'padding', 'Tablet');
  $css->pbg_render_typography($attr, 'triggerTypography', 'Tablet');

  // Trigger Text Hover
  $css->set_selector('.' . $unique_id . ' > .premium-modal-trigger-container .premium-modal-trigger-text:hover');
  $css->pbg_render_border($attr, 'triggerBorderH', 'Tablet');

  // Trigger Lottie
  $css->set_selector('.' . $unique_id . ' > .premium-modal-trigger-container > .premium-lottie-animation svg');
  $css->pbg_render_range($attr, 'imageWidth', 'width', 'Tablet');
  $css->pbg_render_range($attr, 'imageWidth', 'height', 'Tablet');

  // Close Button
  $css->set_selector('.' . $unique_id . ' .premium-modal-box-close-button-container .premium-modal-box-modal-close');
  $css->pbg_render_border($attr, 'upperBorder', 'Tablet');
  $css->pbg_render_spacing($attr, 'upperPadding', 'padding', 'Tablet');

  $css->set_selector('.' . $unique_id . ' .premium-modal-box-close-button-container .premium-modal-box-modal-close svg');
  $css->pbg_render_range($attr, 'upperIconWidth', 'width', 'Tablet');
  $css->pbg_render_range($attr, 'upperIconWidth', 'height', 'Tablet');

  // Modal Wrapper
  $css->set_selector('.' . $unique_id . '.premium-popup__modal_wrap .premium-popup__modal_content');
  $css->pbg_render_border($attr, 'modalBorder', 'Tablet');
  $css->pbg_render_range($attr, 'modalWidth', 'width', 'Tablet');
  $css->pbg_render_range($attr, 'modalHeight', 'max-height', 'Tablet');
  $css->pbg_render_background($attr, 'containerBackground', 'Tablet');

  // Modal Body
  // $css->set_selector('.' . $unique_id . '.premium-popup__modal_wrap .premium-modal-box-modal-body');
  // $css->pbg_render_background($attr, 'containerBackground', 'Tablet');

  // Modal Body Padding
  $css->set_selector('.' . $unique_id . '.premium-popup__modal_wrap .premium-modal-box-modal-body .premium-modal-box-modal-body-content');
  $css->pbg_render_spacing($attr, 'modalPadding', 'padding', 'Tablet');

  // Modal Overlay
  $css->set_selector('.' . $unique_id . '.premium-popup__modal_wrap .premium-popup__modal_wrap_overlay');
  $css->pbg_render_background($attr, 'modalBackground', 'Tablet');

	$css->stop_media_query();
	$css->start_media_query('mobile');

  // Trigger Container Alignment
	$css->set_selector('.' . $unique_id . ' > .premium-modal-trigger-container');
	$css->pbg_render_value($attr, 'align', 'text-align', 'Mobile');

  $css->set_selector('.' . $unique_id . ' > .premium-modal-trigger-container .premium-modal-trigger-btn');
  $css->pbg_render_border( $attr, 'triggerBorder', 'Mobile' );
  $css->pbg_render_spacing( $attr, 'triggerPadding', 'padding', "Mobile" );
  $css->pbg_render_typography( $attr, 'triggerTypography', 'Mobile' );

  $css->set_selector('.' . $unique_id . ' > .premium-modal-trigger-container .premium-modal-trigger-btn:hover');
  $css->pbg_render_border( $attr, 'triggerBorderH', 'Mobile' );

  // icon Styles
  $css->set_selector(
    ".{$unique_id} > .premium-modal-trigger-container .premium-modal-trigger-btn .premium-modal-box-icon svg, " .
    ".{$unique_id} > .premium-modal-trigger-container .premium-modal-trigger-btn .premium-modal-svg-class svg"
  );
  $css->pbg_render_range($attr, 'iconSize', 'width', 'Mobile', null, '!important');
  $css->pbg_render_range($attr, 'iconSize', 'height', 'Mobile', null, '!important');

	// common icon type style
  $css->set_selector(
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn .premium-modal-box-icon, " .
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn img, " .
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn .premium-modal-svg-class svg, " .
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn .premium-lottie-animation svg"
  );
  $css->pbg_render_border($attr, 'iconBorder', 'Mobile');
  $css->pbg_render_spacing($attr, 'iconPadding', 'padding', "Mobile");
  $css->pbg_render_spacing($attr, 'iconMargin', 'margin', 'Mobile');

	// image style
  $css->set_selector('.' . $unique_id . ' .premium-modal-trigger-container .premium-modal-trigger-btn img');
  $css->pbg_render_range($attr, 'imgWidth', 'width', 'Mobile', null, '!important');

  $css->set_selector('.' . $unique_id . ' .premium-modal-trigger-container .premium-modal-trigger-btn .premium-lottie-animation svg');
  $css->pbg_render_range($attr, 'imgWidth', 'width', 'Mobile', null, '!important');
  $css->pbg_render_range($attr, 'imgWidth', 'height', 'Mobile', null, '!important');

	// svg styles
  $css->set_selector(
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn .premium-modal-box-icon, " .
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn .premium-modal-svg-class svg, " .
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn .premium-lottie-animation svg"
  );
  $css->pbg_render_background($attr, 'iconBG', 'Mobile');

  $css->set_selector(
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn:hover .premium-modal-box-icon, " .
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn:hover .premium-modal-svg-class svg, " .
    ".{$unique_id} .premium-modal-trigger-container .premium-modal-trigger-btn:hover .premium-lottie-animation svg"
  );
  $css->pbg_render_background($attr, 'iconHoverBG', 'Mobile');

  // Trigger Image
  $css->set_selector('.' . $unique_id . ' > .premium-modal-trigger-container .premium-modal-trigger-img');
  $css->pbg_render_range($attr, 'imageWidth', 'width', 'Mobile');
  $css->pbg_render_border($attr, 'triggerBorder', 'Mobile');

  // Trigger Image Hover
  $css->set_selector('.' . $unique_id . ' > .premium-modal-trigger-container .premium-modal-trigger-img:hover');
  $css->pbg_render_border($attr, 'triggerBorderH', 'Mobile');

  // Trigger Text
  $css->set_selector('.' . $unique_id . ' > .premium-modal-trigger-container .premium-modal-trigger-text');
  $css->pbg_render_border($attr, 'triggerBorder', 'Mobile');
  $css->pbg_render_spacing($attr, 'triggerPadding', 'padding', 'Mobile');
  $css->pbg_render_typography($attr, 'triggerTypography', 'Mobile');

  // Trigger Text Hover
  $css->set_selector('.' . $unique_id . ' > .premium-modal-trigger-container .premium-modal-trigger-text:hover');
  $css->pbg_render_border($attr, 'triggerBorderH', 'Mobile');

  // Trigger Lottie
  $css->set_selector('.' . $unique_id . ' > .premium-modal-trigger-container > .premium-lottie-animation svg');
  $css->pbg_render_range($attr, 'imageWidth', 'width', 'Mobile');
  $css->pbg_render_range($attr, 'imageWidth', 'height', 'Mobile');

  // Close Button
  $css->set_selector('.' . $unique_id . ' .premium-modal-box-close-button-container .premium-modal-box-modal-close');
  $css->pbg_render_border($attr, 'upperBorder', 'Mobile');
  $css->pbg_render_spacing($attr, 'upperPadding', 'padding', 'Mobile');

  $css->set_selector('.' . $unique_id . ' .premium-modal-box-close-button-container .premium-modal-box-modal-close svg');
  $css->pbg_render_range($attr, 'upperIconWidth', 'width', 'Mobile');
  $css->pbg_render_range($attr, 'upperIconWidth', 'height', 'Mobile');

  // Modal Wrapper
  $css->set_selector('.' . $unique_id . '.premium-popup__modal_wrap .premium-popup__modal_content');
  $css->pbg_render_border($attr, 'modalBorder', 'Mobile');
  $css->pbg_render_range($attr, 'modalWidth', 'width', 'Mobile');
  $css->pbg_render_range($attr, 'modalHeight', 'max-height', 'Mobile');
  $css->pbg_render_background($attr, 'containerBackground', 'Mobile');

  // Modal Body
  // $css->set_selector('.' . $unique_id . '.premium-popup__modal_wrap .premium-modal-box-modal-body');
  // $css->pbg_render_background($attr, 'containerBackground', 'Mobile');

  // Modal Body Padding
  $css->set_selector('.' . $unique_id . '.premium-popup__modal_wrap .premium-modal-box-modal-body .premium-modal-box-modal-body-content');
  $css->pbg_render_spacing($attr, 'modalPadding', 'padding', 'Mobile');

  // Modal Overlay
  $css->set_selector('.' . $unique_id . '.premium-popup__modal_wrap .premium-popup__modal_wrap_overlay');
  $css->pbg_render_background($attr, 'modalBackground', 'Mobile');

	$css->stop_media_query();
	return $css->css_output();
}

/**
 * Get Media Css.
 *
 * @return void
 */
function get_premium_modal_media_css(){
  $media_css = array('desktop' => '', 'tablet' => '', 'mobile' => '');

  $media_css['mobile'] .= "
    .premium-popup__modal_content {
      overflow: auto;
    }
  ";

  return $media_css;
}

/**
 * Renders the `premium/modal` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_modal($attributes, $content, $block)
{
	$block_helpers = pbg_blocks_helper();
	// Enqueue frontend JavaScript and CSS
	if ($block_helpers->it_is_not_amp()) {
		if ((isset($attributes["iconTypeSelect"]) && $attributes["iconTypeSelect"] == "lottie")  || (isset($attributes['triggerSettings']) && $attributes['triggerSettings'][0]['triggerType'] == 'lottie')) {
			wp_enqueue_script(
				'pbg-lottie',
				PREMIUM_BLOCKS_URL . 'assets/js/lib/lottie.min.js',
				array('jquery'),
				PREMIUM_BLOCKS_VERSION,
				true
			);
		}
		wp_enqueue_script(
			'pbg-modal-box',
			PREMIUM_BLOCKS_URL . 'assets/js/minified/modal-box.min.js',
			array(),
			PREMIUM_BLOCKS_VERSION,
			true
		);

    if(isset($attributes['contentStyles'][0]['animationType'])){
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
	}

	/* 
    Handling new feature of WordPress 6.7.2 --> sizes='auto' for old versions that doesn't contain wp-image-{$id} class.
    This workaround can be omitted after a few subsequent releases around 25/3/2025
  */
	if ((isset($attributes["iconTypeSelect"]) && $attributes["iconTypeSelect"] == "img")  || (isset($attributes['triggerSettings']) && $attributes['triggerSettings'][0]['triggerType'] == 'image')) {

		if (false === stripos($content, '<img')) {
			return $content;
		}

		if (!empty($attributes['imageURL'])) {
			$image_url = $attributes['imageURL'];
		} elseif (empty($attributes['imageURL']) && !empty($attributes['triggerSettings'][0]['triggerImgURL'])) {
			$image_url = $attributes['triggerSettings'][0]['triggerImgURL'];
		} else {
			return $content;
		}

		$image_id = attachment_url_to_postid($image_url);

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
 * Register the modal block.
 *
 * @uses render_block_pbg_modal()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_modal()
{
	if (! function_exists('register_block_type')) {
		return;
	}
	register_block_type(
		PREMIUM_BLOCKS_PATH . '/blocks-config/Modal',
		array(
			'render_callback' => 'render_block_pbg_modal',
		)
	);
}

register_block_pbg_modal();
