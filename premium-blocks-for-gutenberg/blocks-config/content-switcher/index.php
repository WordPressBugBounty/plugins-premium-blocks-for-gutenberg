<?php

/**
 * Server-side rendering of the `pbg/content-switcher` block.
 *
 * @package WordPress
 */

/**
 * Generate CSS styles for the Content Switcher block
 *
 * @param array  $attributes Block attributes.
 * @param string $unique_id Unique block ID.
 * @return string Generated CSS string
 */
function get_content_switcher_css_style( $attributes, $unique_id ) {
	$css       = new Premium_Blocks_css();
	$unique_id = $attributes['blockId'];
	$display   = $attributes['display'] ?? 'inline';

  // Get units for spacing and size for handling backward compatibility. This can be removed within a few versions.
  $label_spacing_unit = $css->pbg_get_value( $attributes, 'labelSpacing.unit');
  $switch_size_unit = $css->pbg_get_value( $attributes, 'switchSize.unit');

	// Desktop styles - Container alignment
	$css->set_selector( '.' . $unique_id );
	$css->pbg_render_value( $attributes, 'align', 'text-align', 'Desktop' );

	$css->set_selector( '.' . $unique_id . ' > .premium-content-switcher' );
	$css->pbg_render_value( $attributes, 'align', 'text-align', 'Desktop' );
	$css->pbg_render_spacing( $attributes, 'containerPadding', 'padding', 'Desktop' );
	$css->pbg_render_spacing( $attributes, 'containerMargin', 'margin', 'Desktop' );
	$css->pbg_render_background( $attributes, 'containerBackground', 'Desktop' );
	$css->pbg_render_border( $attributes, 'containerborder', 'Desktop' );
	$css->pbg_render_shadow( $attributes, 'containerBoxShadow', 'box-shadow' );

	// Toggle alignment - inline
	$css->set_selector( '.' . $unique_id . ' > .premium-content-switcher > .premium-content-switcher-toggle-inline' );
  $css->pbg_render_range($attributes, 'labelSpacing', 'gap', 'Desktop', '', $label_spacing_unit ? '' : 'px');
	$css->pbg_render_value( $attributes, 'align', 'text-align', 'Desktop' );
	$css->pbg_render_align_self( $attributes, 'align', 'justify-content', 'Desktop' );

	// Toggle alignment - block
	$css->set_selector( '.' . $unique_id . ' > .premium-content-switcher > .premium-content-switcher-toggle-block' );
  $css->pbg_render_range($attributes, 'labelSpacing', 'gap', 'Desktop', '', $label_spacing_unit ? '' : 'px');
	$css->pbg_render_value( $attributes, 'align', 'text-align', 'Desktop');
	$css->pbg_render_align_self( $attributes, 'align', 'justify-content', 'Desktop' );
	$css->pbg_render_align_self( $attributes, 'align', 'align-items', 'Desktop' );

	// Switcher background
	$css->set_selector( '.' . $unique_id . ' .premium-content-switcher-toggle-switch-slider, .' . $unique_id . ' .premium-content-switcher-toggle-wrapper .premium-content-switcher-toggle-btn' );
	$css->pbg_render_shadow( $attributes, 'switchShadow', 'box-shadow' );
	$css->pbg_render_background( $attributes, 'switcherBackground', 'Desktop' );
	$css->pbg_render_range( $attributes, 'switchRadius', 'border-radius', '', '', $attributes['switchRadiusUnit'] ?? 'px' );

	$css->set_selector( '.' . $unique_id . ' .premium-content-switcher-toggle-switch-label input:checked+.premium-content-switcher-toggle-switch-slider' );
	$css->pbg_render_background( $attributes, 'switcherTwoBackground', 'Desktop' );

	// Controller background
	$css->set_selector( '.' . $unique_id . ' .premium-content-switcher-toggle-switch-slider:before, .' . $unique_id . ' .premium-content-switcher-toggle-wrapper .premium-content-switcher-toggle-btn-active' );
	$css->pbg_render_background( $attributes, 'controllerOneBackground', 'Desktop' );
	$css->pbg_render_range( $attributes, 'containerRadius', 'border-radius', '', '', $attributes['containerRadiusUnit'] ?? 'px');
	$css->pbg_render_shadow( $attributes, 'containerShadow', 'box-shadow' );

	$css->set_selector( '.' . $unique_id . ' .premium-content-switcher-toggle-switch-slider img' );
	$css->pbg_render_range( $attributes, 'containerRadius', 'border-radius', '', '', $attributes['containerRadiusUnit'] ?? 'px');	

	$css->set_selector( '.' . $unique_id . ' .premium-content-switcher-toggle-switch-label input:checked+.premium-content-switcher-toggle-switch-slider::before' );
	$css->pbg_render_background( $attributes, 'controllerTwoBackground', 'Desktop' );

	$css->set_selector( '.' . $unique_id . ' .premium-content-switcher-toggle-wrapper .premium-content-switcher-first-label.premium-content-switcher-toggle-btn-active' );
	$css->pbg_render_background( $attributes, 'controllerOneBackground', 'Desktop' );

	$css->set_selector( '.' . $unique_id . " .premium-content-switcher .premium-content-switcher-toggle-wrapper .premium-content-switcher-first-label.premium-content-switcher-toggle-btn-active .premium-content-switcher-{$display}-editing" );
	$css->pbg_render_color( $attributes, 'labelStyles.firstLabelColor', 'color', '' );

	$css->set_selector( '.' . $unique_id . ' .premium-content-switcher-toggle-wrapper .premium-content-switcher-second-label.premium-content-switcher-toggle-btn-active' );
	$css->pbg_render_background( $attributes, 'controllerTwoBackground', 'Desktop' );

	$css->set_selector( '.' . $unique_id . " .premium-content-switcher .premium-content-switcher-toggle-wrapper .premium-content-switcher-second-label.premium-content-switcher-toggle-btn-active .premium-content-switcher-{$display}-editing" );
	$css->pbg_render_color( $attributes, 'labelStyles.secondLabelColor', 'color', '' );	

	// First Label spacing and styles
	$css->set_selector( '.' . $unique_id . " > .premium-content-switcher .premium-content-switcher-toggle-{$display} .premium-content-switcher-first-label .premium-content-switcher-{$display}-editing" );
  	$css->pbg_render_typography( $attributes, 'firstLabelTypography', 'Desktop' );
	$css->add_property( 'margin', '0' );
	$css->pbg_render_color( $attributes, 'labelStyles.firstLabelInactiveColor', 'color', '' );
	$css->pbg_render_color( $attributes, 'labelStyles.firstLabelBGColor', 'background-color', '' );
	$css->pbg_render_spacing( $attributes, 'firstLabelPadding', 'padding', 'Desktop' );
	$css->pbg_render_border( $attributes, 'firstLabelborder', 'Desktop' );
	$css->pbg_render_shadow( $attributes, 'firstLabelBoxShadow', 'box-shadow' );
	$css->pbg_render_shadow( $attributes, 'firstLabelShadow', 'text-shadow' );

	$css->set_selector( '.' . $unique_id . " > .premium-content-switcher .premium-content-switcher-toggle-{$display} .premium-content-switcher-first-label.premium-content-switcher-first-label-active .premium-content-switcher-{$display}-editing" );
	$css->pbg_render_color( $attributes, 'labelStyles.firstLabelColor', 'color', '' );

	// Second Label spacing and styles
	$css->set_selector( '.' . $unique_id . " > .premium-content-switcher .premium-content-switcher-toggle-{$display} .premium-content-switcher-second-label .premium-content-switcher-{$display}-editing" );
  	$css->pbg_render_typography( $attributes, 'secondLabelTypography', 'Desktop' );
	$css->add_property( 'margin', '0' );
	$css->pbg_render_color( $attributes, 'labelStyles.secondLabelInactiveColor', 'color', '' );
	$css->pbg_render_color( $attributes, 'labelStyles.secondLabelBGColor', 'background-color', '' );
	$css->pbg_render_spacing( $attributes, 'secondLabelPadding', 'padding', 'Desktop' );
	$css->pbg_render_border( $attributes, 'secondLabelborder', 'Desktop' );
	$css->pbg_render_shadow( $attributes, 'secondLabelBoxShadow', 'box-shadow' );
	$css->pbg_render_shadow( $attributes, 'secondLabelShadow', 'text-shadow' );

	$css->set_selector( '.' . $unique_id . " > .premium-content-switcher .premium-content-switcher-toggle-{$display} .premium-content-switcher-second-label.premium-content-switcher-second-label-active .premium-content-switcher-{$display}-editing" );
	$css->pbg_render_color( $attributes, 'labelStyles.secondLabelColor', 'color', '' );

	// Switch size for inline/display display
	$css->set_selector( 
    '.' . $unique_id . ' > .premium-content-switcher > .premium-content-switcher-toggle-inline > .premium-content-switcher-toggle-switch, ' .
    '.' . $unique_id . ' > .premium-content-switcher > .premium-content-switcher-toggle-block > .premium-content-switcher-toggle-switch, ' .
    '.' . $unique_id . ' .premium-content-switcher-toggle-switch-slider .premium-content-switcher-icon'
  );
	$css->pbg_render_range( $attributes, 'switchSize', 'font-size', 'Desktop', '', $switch_size_unit ? '' : 'px' );

	//button styles
	$css->set_selector( '.' . $unique_id . " .premium-content-switcher-toggle-{$display} .premium-content-switcher-toggle-wrapper" );
	$css->pbg_render_background( $attributes, 'boxBackground', 'Desktop' );
	$css->pbg_render_spacing( $attributes, 'boxPadding', 'padding', 'Desktop' );
	$css->pbg_render_border( $attributes, 'boxBorder', 'Desktop' );
	$css->pbg_render_shadow( $attributes, 'boxBoxShadow', 'box-shadow' );

	$css->set_selector( '.' . $unique_id . ' .premium-content-switcher-toggle-wrapper .premium-content-switcher-toggle-btn' );
  	$css->pbg_render_spacing( $attributes, 'switcherPadding', 'padding', 'Desktop' );
	$css->pbg_render_spacing( $attributes, 'switcherMargin', 'margin', 'Desktop' );

	$css->set_selector( '.' . $unique_id . ' .premium-content-switcher-toggle-wrapper .premium-content-switcher-first-label' );
	$css->pbg_render_background( $attributes, 'switcherBackground', 'Desktop' );

	$css->set_selector( '.' . $unique_id . ' .premium-content-switcher-toggle-wrapper .premium-content-switcher-second-label' );
	$css->pbg_render_background( $attributes, 'switcherTwoBackground', 'Desktop' );

	//icon styles
	$css->set_selector( '.' . $unique_id . ' .premium-content-switcher-icon-first:not(.premium-lottie-animation) svg, .' . $unique_id . ' .premium-content-switcher-icon-first:not(.premium-lottie-animation) svg *, .' . $unique_id . ' .premium-content-switcher-icon-first:not(.icon-type-fe):not(.premium-lottie-animation) svg, .' . $unique_id . ' .premium-content-switcher-icon-first:not(.icon-type-fe):not(.premium-lottie-animation) svg *' );
	$css->pbg_render_color( $attributes, 'firstIconColor', 'color', '' );
	$css->pbg_render_color( $attributes, 'firstIconColor', 'fill', '' );

	$css->set_selector( '.' . $unique_id . ' .premium-content-switcher-icon-second:not(.premium-lottie-animation) svg, .' . $unique_id . ' .premium-content-switcher-icon-second:not(.premium-lottie-animation) svg *, .' . $unique_id . ' .premium-content-switcher-icon-second:not(.icon-type-fe):not(.premium-lottie-animation) svg, .' . $unique_id . ' .premium-content-switcher-icon-second:not(.icon-type-fe):not(.premium-lottie-animation) svg *' );
	$css->pbg_render_color( $attributes, 'secondIconColor', 'color', '' );
	$css->pbg_render_color( $attributes, 'secondIconColor', 'fill', '' );

	// Tablet styles
	$css->start_media_query( 'tablet' );

	// Container alignment - Tablet
	$css->set_selector( '.' . $unique_id );
	$css->pbg_render_value( $attributes, 'align', 'text-align', 'Tablet' );

	$css->set_selector( '.' . $unique_id . ' > .premium-content-switcher' );
	$css->pbg_render_value( $attributes, 'align', 'text-align', 'Tablet' );
	$css->pbg_render_spacing( $attributes, 'containerPadding', 'padding', 'Tablet' );
	$css->pbg_render_spacing( $attributes, 'containerMargin', 'margin', 'Tablet' );
	$css->pbg_render_background( $attributes, 'containerBackground', 'Tablet' );
	$css->pbg_render_border( $attributes, 'containerborder', 'Tablet' );

	// Toggle alignment - inline - Tablet
	$css->set_selector( '.' . $unique_id . ' > .premium-content-switcher > .premium-content-switcher-toggle-inline' );
  $css->pbg_render_range($attributes, 'labelSpacing', 'gap', 'Tablet', '', $label_spacing_unit ? '' : 'px');
	$css->pbg_render_value( $attributes, 'align', 'text-align', 'Tablet' );
	$css->pbg_render_align_self( $attributes, 'align', 'justify-content', 'Tablet' );

	// Toggle alignment - block - Tablet
	$css->set_selector( '.' . $unique_id . ' > .premium-content-switcher > .premium-content-switcher-toggle-block' );
  $css->pbg_render_range($attributes, 'labelSpacing', 'gap', 'Tablet', '', $label_spacing_unit ? '' : 'px');
	$css->pbg_render_value( $attributes, 'align', 'text-align', 'Tablet' );
	$css->pbg_render_align_self( $attributes, 'align', 'justify-content', 'Tablet' );
	$css->pbg_render_align_self( $attributes, 'align', 'align-items', 'Tablet' );

	// Switcher background - Tablet
	$css->set_selector( '.' . $unique_id . ' .premium-content-switcher-toggle-switch-slider, .' . $unique_id . ' .premium-content-switcher-toggle-wrapper .premium-content-switcher-toggle-btn' );
	$css->pbg_render_background( $attributes, 'switcherBackground', 'Tablet' );

	$css->set_selector( '.' . $unique_id . ' .premium-content-switcher-toggle-switch-label input:checked+.premium-content-switcher-toggle-switch-slider' );
	$css->pbg_render_background( $attributes, 'switcherTwoBackground', 'Tablet' );

	// Controller background - Tablet
	$css->set_selector( '.' . $unique_id . ' .premium-content-switcher-toggle-switch-slider:before, .' . $unique_id . ' .premium-content-switcher-toggle-wrapper .premium-content-switcher-toggle-btn-active' );
	$css->pbg_render_background( $attributes, 'controllerOneBackground', 'Tablet' );

	$css->set_selector( '.' . $unique_id . ' .premium-content-switcher-toggle-switch-label input:checked+.premium-content-switcher-toggle-switch-slider::before' );
	$css->pbg_render_background( $attributes, 'controllerTwoBackground', 'Tablet' );

	$css->set_selector( '.' . $unique_id . ' .premium-content-switcher-toggle-wrapper .premium-content-switcher-first-label.premium-content-switcher-toggle-btn-active' );
	$css->pbg_render_background( $attributes, 'controllerOneBackground', 'Tablet' );

	$css->set_selector( '.' . $unique_id . ' .premium-content-switcher-toggle-wrapper .premium-content-switcher-second-label.premium-content-switcher-toggle-btn-active' );
	$css->pbg_render_background( $attributes, 'controllerTwoBackground', 'Tablet' );

	// First Label - Tablet
	$css->set_selector( '.' . $unique_id . " > .premium-content-switcher .premium-content-switcher-toggle-{$display} .premium-content-switcher-first-label .premium-content-switcher-{$display}-editing" );
	$css->pbg_render_typography( $attributes, 'firstLabelTypography', 'Tablet' );
	$css->pbg_render_spacing( $attributes, 'firstLabelPadding', 'padding', 'Tablet' );
	$css->pbg_render_border( $attributes, 'firstLabelborder', 'Tablet' );

	// Second Label - Tablet
	$css->set_selector( '.' . $unique_id . " > .premium-content-switcher .premium-content-switcher-toggle-{$display} .premium-content-switcher-second-label .premium-content-switcher-{$display}-editing" );
	$css->pbg_render_typography( $attributes, 'secondLabelTypography', 'Tablet' );
	$css->pbg_render_spacing( $attributes, 'secondLabelPadding', 'padding', 'Tablet' );
	$css->pbg_render_border( $attributes, 'secondLabelborder', 'Tablet' );

	// Switch size - Tablet inline/display
	$css->set_selector( 
    '.' . $unique_id . ' > .premium-content-switcher > .premium-content-switcher-toggle-inline > .premium-content-switcher-toggle-switch, ' .
    '.' . $unique_id . ' > .premium-content-switcher > .premium-content-switcher-toggle-block > .premium-content-switcher-toggle-switch, ' .
    '.' . $unique_id . ' .premium-content-switcher-toggle-switch-slider .premium-content-switcher-icon'
  );
	$css->pbg_render_range( $attributes, 'switchSize', 'font-size', 'Tablet', '', $switch_size_unit ? '' : 'px' );

	//button styles
	$css->set_selector( '.' . $unique_id . " .premium-content-switcher-toggle-{$display} .premium-content-switcher-toggle-wrapper" );
	$css->pbg_render_background( $attributes, 'boxBackground', 'Tablet' );
	$css->pbg_render_spacing( $attributes, 'boxPadding', 'padding', 'Tablet' );
	$css->pbg_render_border( $attributes, 'boxBorder', 'Tablet' );

	$css->set_selector( '.' . $unique_id . ' .premium-content-switcher-toggle-wrapper .premium-content-switcher-toggle-btn' );
  	$css->pbg_render_spacing( $attributes, 'switcherPadding', 'padding', 'Tablet' );
	$css->pbg_render_spacing( $attributes, 'switcherMargin', 'margin', 'Tablet' );

	$css->set_selector( '.' . $unique_id . ' .premium-content-switcher-toggle-wrapper .premium-content-switcher-first-label' );
	$css->pbg_render_background( $attributes, 'switcherBackground', 'Tablet' );

	$css->set_selector( '.' . $unique_id . ' .premium-content-switcher-toggle-wrapper .premium-content-switcher-second-label' );
	$css->pbg_render_background( $attributes, 'switcherTwoBackground', 'Tablet' );

	$css->stop_media_query();

	// Mobile styles
	$css->start_media_query( 'mobile' );

	// Container alignment - Mobile
	$css->set_selector( '.' . $unique_id );
	$css->pbg_render_value( $attributes, 'align', 'text-align', 'Mobile' );

	$css->set_selector( '.' . $unique_id . ' > .premium-content-switcher' );
	$css->pbg_render_value( $attributes, 'align', 'text-align', 'Mobile' );
	$css->pbg_render_spacing( $attributes, 'containerPadding', 'padding', 'Mobile' );
	$css->pbg_render_spacing( $attributes, 'containerMargin', 'margin', 'Mobile' );
	$css->pbg_render_background( $attributes, 'containerBackground', 'Mobile' );
	$css->pbg_render_border( $attributes, 'containerborder', 'Mobile' );

	// Toggle alignment - inline - Mobile
	$css->set_selector( '.' . $unique_id . ' > .premium-content-switcher > .premium-content-switcher-toggle-inline' );
  $css->pbg_render_range($attributes, 'labelSpacing', 'gap', 'Mobile', '', $label_spacing_unit ? '' : 'px');
	$css->pbg_render_value( $attributes, 'align', 'text-align', 'Mobile' );
	$css->pbg_render_align_self( $attributes, 'align', 'justify-content', 'Mobile' );

	// Toggle alignment - block - Mobile
	$css->set_selector( '.' . $unique_id . ' > .premium-content-switcher > .premium-content-switcher-toggle-block' );
  $css->pbg_render_range($attributes, 'labelSpacing', 'gap', 'Mobile', '', $label_spacing_unit ? '' : 'px');
	$css->pbg_render_value( $attributes, 'align', 'text-align', 'Mobile' );
	$css->pbg_render_align_self( $attributes, 'align', 'justify-content', 'Mobile' );
	$css->pbg_render_align_self( $attributes, 'align', 'align-items', 'Mobile' );

	// Switcher background - Mobile
	$css->set_selector( '.' . $unique_id . ' .premium-content-switcher-toggle-switch-slider, .' . $unique_id . ' .premium-content-switcher-toggle-wrapper .premium-content-switcher-toggle-btn' );
	$css->pbg_render_background( $attributes, 'switcherBackground', 'Mobile' );

	$css->set_selector( '.' . $unique_id . ' .premium-content-switcher-toggle-switch-label input:checked+.premium-content-switcher-toggle-switch-slider' );
	$css->pbg_render_background( $attributes, 'switcherTwoBackground', 'Mobile' );

	// Controller background - Mobile
	$css->set_selector( '.' . $unique_id . ' .premium-content-switcher-toggle-switch-slider:before, .' . $unique_id . ' .premium-content-switcher-toggle-wrapper .premium-content-switcher-toggle-btn-active' );
	$css->pbg_render_background( $attributes, 'controllerOneBackground', 'Mobile' );

	$css->set_selector( '.' . $unique_id . ' .premium-content-switcher-toggle-switch-label input:checked+.premium-content-switcher-toggle-switch-slider::before' );
	$css->pbg_render_background( $attributes, 'controllerTwoBackground', 'Mobile' );

	$css->set_selector( '.' . $unique_id . ' .premium-content-switcher-toggle-wrapper .premium-content-switcher-first-label.premium-content-switcher-toggle-btn-active' );
	$css->pbg_render_background( $attributes, 'controllerOneBackground', 'Mobile' );

	$css->set_selector( '.' . $unique_id . ' .premium-content-switcher-toggle-wrapper .premium-content-switcher-second-label.premium-content-switcher-toggle-btn-active' );
	$css->pbg_render_background( $attributes, 'controllerTwoBackground', 'Mobile' );

	// First Label - Mobile
	$css->set_selector( '.' . $unique_id . " > .premium-content-switcher .premium-content-switcher-toggle-{$display} .premium-content-switcher-first-label .premium-content-switcher-{$display}-editing" );
	$css->pbg_render_typography( $attributes, 'firstLabelTypography', 'Mobile' );
	$css->pbg_render_spacing( $attributes, 'firstLabelPadding', 'padding', 'Mobile' );
	$css->pbg_render_border( $attributes, 'firstLabelborder', 'Mobile' );

	// Second Label - Mobile
	$css->set_selector( '.' . $unique_id . " > .premium-content-switcher .premium-content-switcher-toggle-{$display} .premium-content-switcher-second-label .premium-content-switcher-{$display}-editing" );
	$css->pbg_render_typography( $attributes, 'secondLabelTypography', 'Mobile' );
	$css->pbg_render_spacing( $attributes, 'secondLabelPadding', 'padding', 'Mobile' );
	$css->pbg_render_border( $attributes, 'secondLabelborder', 'Mobile' );

	// Switch size - Mobile inline/display
  $css->set_selector( 
    '.' . $unique_id . ' > .premium-content-switcher > .premium-content-switcher-toggle-inline > .premium-content-switcher-toggle-switch, ' .
    '.' . $unique_id . ' > .premium-content-switcher > .premium-content-switcher-toggle-block > .premium-content-switcher-toggle-switch, ' .
    '.' . $unique_id . ' .premium-content-switcher-toggle-switch-slider .premium-content-switcher-icon'
  );
	$css->pbg_render_range( $attributes, 'switchSize', 'font-size', 'Mobile', '', $switch_size_unit ? '' : 'px' );

	//button styles
	$css->set_selector( '.' . $unique_id . " .premium-content-switcher-toggle-{$display} .premium-content-switcher-toggle-wrapper" );
	$css->pbg_render_background( $attributes, 'boxBackground', 'Mobile' );
	$css->pbg_render_spacing( $attributes, 'boxPadding', 'padding', 'Mobile' );
	$css->pbg_render_border( $attributes, 'boxBorder', 'Mobile' );

	$css->set_selector( '.' . $unique_id . ' .premium-content-switcher-toggle-wrapper .premium-content-switcher-toggle-btn' );
  	$css->pbg_render_spacing( $attributes, 'switcherPadding', 'padding', 'Mobile' );
	$css->pbg_render_spacing( $attributes, 'switcherMargin', 'margin', 'Mobile' );

	$css->set_selector( '.' . $unique_id . ' .premium-content-switcher-toggle-wrapper .premium-content-switcher-first-label' );
	$css->pbg_render_background( $attributes, 'switcherBackground', 'Mobile' );

	$css->set_selector( '.' . $unique_id . ' .premium-content-switcher-toggle-wrapper .premium-content-switcher-second-label' );
	$css->pbg_render_background( $attributes, 'switcherTwoBackground', 'Mobile' );

	$css->stop_media_query();

	return $css->css_output();
}

function render_block_pbg_content_switcher( $attributes, $content ) {
	wp_enqueue_script(
		'content-switcher',
		PREMIUM_BLOCKS_URL . 'assets/js/minified/content-switcher.min.js',
		array(),
		PREMIUM_BLOCKS_VERSION,
		true
	);

	return $content;
}

/**
 * Registers the `pbg/content-switcher` block on the server.
 */
function register_block_pbg_content_switcher() {
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	register_block_type(
		PREMIUM_BLOCKS_PATH . '/blocks-config/content-switcher',
		array(
			'render_callback' => 'render_block_pbg_content_switcher',
		)
	);
}

register_block_pbg_content_switcher();
