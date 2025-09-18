<?php
/**
 * Server-side rendering of the `pbg/bullet-list` block.
 *
 * @package WordPress
 */

/**
 * Get Bullet List Block CSS
 *
 * Return Frontend CSS for Bullet List.
 *
 * @access public
 *
 * @param string $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_bullet_list_css_style( $attr, $unique_id ) {
	$css = new Premium_Blocks_css();

  $icon_position = $css->pbg_get_value($attr, 'iconPosition');
  $flex_direction = $icon_position === 'top' ? 'column' : ($icon_position === 'after' ? 'row-reverse' : '');

	// Align.
  $css->set_selector( '.' . $unique_id . ' .premium-bullet-list__icon-wrap' );
  $css->pbg_render_value($attr, 'bulletAlign', 'align-self', 'Desktop');

  $css->set_selector( '.' . $unique_id );
  $css->pbg_render_value($attr, 'align', 'text-align', 'Desktop');
  
  $css->set_selector( '.' . $unique_id . ' .premium-bullet-list__content-wrap' );
  $css->pbg_render_align_self($attr, 'align', 'justify-content', 'Desktop');
  $css->add_property( 'flex-direction', $flex_direction );

	// Style for list.
  $css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' );
  $css->pbg_render_align_self($attr, 'align', 'justify-content', 'Desktop');
  $css->pbg_render_border($attr, 'generalBorder', 'Desktop');
  $css->pbg_render_spacing($attr, 'generalpadding', 'padding', 'Desktop');
  $css->pbg_render_spacing($attr, 'generalmargin', 'margin', 'Desktop');

  // Style for list item.
  $css->set_selector( '.' . $unique_id . ' .premium-bullet-list__wrapper' );
  $css->pbg_render_color($attr, 'generalStyles[0].generalBackgroundColor', 'background-color');
  $css->pbg_render_shadow($attr, 'boxShadow', 'box-shadow');
  $css->pbg_render_align_self($attr, 'align', 'justify-content', 'Desktop');
  $css->pbg_render_border($attr, 'itemBorder', 'Desktop');
  $css->pbg_render_spacing($attr, 'itempadding', 'padding', 'Desktop');
  $css->pbg_render_spacing($attr, 'itemmargin', 'margin', 'Desktop');

  $css->set_selector( '.' . $unique_id . ' .premium-bullet-list__wrapper:hover' );
  $css->pbg_render_color($attr, 'generalStyles[0].generalHoverBackgroundColor', 'background-color', null, '!important');
  $css->pbg_render_color($attr, 'itemHoverBorderColor', 'border-color');
  $css->pbg_render_shadow($attr, 'hoverBoxShadow', 'box-shadow');

	// Style for icons.
  $css->set_selector( 
    '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-bullet-list-icon svg, ' .
    '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg' 
  );
  $css->pbg_render_range($attr, 'iconSize', 'width', 'Desktop', null, '!important');
  $css->pbg_render_range($attr, 'iconSize', 'height', 'Desktop', null, '!important');

  $css->set_selector( 
    '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-bullet-list-icon, ' .
    '.' . $unique_id . ' .premium-bullet-list__icon-wrap img,' .
    '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg, ' .
    '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-lottie-animation svg'
  );
  $css->pbg_render_border($attr, 'iconBorder', 'Desktop');
  $css->pbg_render_spacing($attr, 'iconPadding', 'padding', "Desktop");
  $css->pbg_render_spacing($attr, 'iconMargin', 'margin', 'Desktop');

  $css->set_selector( '.' . $unique_id . ' .premium-bullet-list__icon-wrap img' );
  $css->pbg_render_range($attr, 'iconSize', 'width', 'Desktop', null, '!important');

  $css->set_selector( '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-lottie-animation svg' );
  $css->pbg_render_range($attr, 'iconSize', 'width', 'Desktop', null, '!important');
  $css->pbg_render_range($attr, 'iconSize', 'height', 'Desktop', null, '!important');

  $css->set_selector( 
    '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-bullet-list-icon, ' .
    '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-bullet-list-icon:not(.icon-type-fe) svg, ' .
    '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-bullet-list-icon:not(.icon-type-fe) svg *, ' .
    '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg, ' .
    '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg *'
  );
  $css->pbg_render_color($attr, 'iconColor', 'color');
  $css->pbg_render_color($attr, 'iconColor', 'fill');

  $css->set_selector( 
    '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-bullet-list-icon, ' .
    '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg, ' .
    '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-lottie-animation svg'
  );
  $css->pbg_render_background($attr, 'iconBG', 'Desktop');

  $css->set_selector( 
    '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-bullet-list-icon, ' .
    '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-bullet-list-icon:not(.icon-type-fe) svg *, ' .
    '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-list-item-svg-class svg, ' .
    '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-list-item-svg-class svg *'
  );
  $css->pbg_render_color($attr, 'iconHoverColor', 'color', null, '!important');
  $css->pbg_render_color($attr, 'iconHoverColor', 'fill', null , '!important');

  $css->set_selector( 
    '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-bullet-list-icon, ' .
    '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-list-item-svg-class svg, ' .
    '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-lottie-animation svg'
  );
  $css->pbg_render_color($attr, 'borderHoverColor', 'border-color');
  $css->pbg_render_background($attr, 'iconHoverBG', 'Desktop');

	// Style for title.
  $css->set_selector( ".{$unique_id} .premium-bullet-list__label" );
  $css->pbg_render_color($attr, 'titleStyles[0].titleColor', 'color');
  $css->pbg_render_shadow($attr, 'titlesTextShadow', 'text-shadow');
  $css->pbg_render_typography($attr, 'titleTypography', 'Desktop');
  $css->pbg_render_spacing($attr, 'titlemargin', 'margin', 'Desktop');

  $css->set_selector( ".{$unique_id} .premium-bullet-list__wrapper:hover .premium-bullet-list__label" );
  $css->pbg_render_color($attr, 'titleStyles[0].titleHoverColor', 'color', null, '!important');

  // style for description
  $css->set_selector( ".{$unique_id} .premium-bullet-list__description" );
  $css->pbg_render_color($attr, 'descriptionStyles.color', 'color');
  $css->pbg_render_typography($attr, 'descriptionTypography', 'Desktop');
  $css->pbg_render_spacing($attr, 'descriptionMargin', 'margin', 'Desktop');

  $css->set_selector( ".{$unique_id} .premium-bullet-list__wrapper:hover .premium-bullet-list__description" );
  $css->pbg_render_color($attr, 'descriptionStyles.hoverColor', 'color', null, '!important');

	// style for divider
  $css->set_selector( ".{$unique_id} .premium-bullet-list-divider-block:not(:last-child)::after" );
  $css->pbg_render_value($attr, 'dividerStyle', 'border-top-style');
  $css->pbg_render_color($attr, 'dividerStyles[0].dividerColor', 'border-top-color');
  $css->pbg_render_range($attr, 'dividerWidth', 'width', 'Desktop');
  $css->pbg_render_range($attr, 'dividerHeight', 'border-top-width', 'Desktop');

  $css->set_selector( ".{$unique_id} .premium-bullet-list-divider-inline:not(:last-child)::after" );
  $css->pbg_render_value($attr, 'dividerStyle', 'border-left-style');
  $css->pbg_render_color($attr, 'dividerStyles[0].dividerColor', 'border-left-color');
  $css->pbg_render_range($attr, 'dividerWidth', 'border-left-width', 'Desktop');
  $css->pbg_render_range($attr, 'dividerHeight', 'height', 'Desktop');

	$css->start_media_query( 'tablet' );

  // Align.
  $css->set_selector( '.' . $unique_id . ' .premium-bullet-list__icon-wrap' );
  $css->pbg_render_value($attr, 'bulletAlign', 'align-self', 'Tablet');

  $css->set_selector( '.' . $unique_id );
  $css->pbg_render_value($attr, 'align', 'text-align', 'Tablet');

  $css->set_selector( '.' . $unique_id . ' .premium-bullet-list__content-wrap' );
  $css->pbg_render_align_self($attr, 'align', 'justify-content', 'Tablet');

	// Style for list.
  $css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' );
  $css->pbg_render_align_self($attr, 'align', 'justify-content', 'Tablet');
  $css->pbg_render_border($attr, 'generalBorder', 'Tablet');
  $css->pbg_render_spacing($attr, 'generalpadding', 'padding', 'Tablet');
  $css->pbg_render_spacing($attr, 'generalmargin', 'margin', 'Tablet');

  // Style for list item.
  $css->set_selector( '.' . $unique_id . ' .premium-bullet-list__wrapper' );
  $css->pbg_render_align_self($attr, 'align', 'justify-content', 'Tablet');
  $css->pbg_render_border($attr, 'itemBorder', 'Tablet');
  $css->pbg_render_spacing($attr, 'itempadding', 'padding', 'Tablet');
  $css->pbg_render_spacing($attr, 'itemmargin', 'margin', 'Tablet');

	// Style for icons.
  $css->set_selector( 
    '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-bullet-list-icon svg, ' .
    '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg' 
  );
  $css->pbg_render_range($attr, 'iconSize', 'width', 'Tablet', null, '!important');
  $css->pbg_render_range($attr, 'iconSize', 'height', 'Tablet', null, '!important');

  $css->set_selector( 
    '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-bullet-list-icon, ' .
    '.' . $unique_id . ' .premium-bullet-list__icon-wrap img,' .
    '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg, ' .
    '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-lottie-animation svg'
  );
  $css->pbg_render_border($attr, 'iconBorder', 'Tablet');
  $css->pbg_render_spacing($attr, 'iconPadding', 'padding', "Tablet");
  $css->pbg_render_spacing($attr, 'iconMargin', 'margin', 'Tablet');

  $css->set_selector( '.' . $unique_id . ' .premium-bullet-list__icon-wrap img' );
  $css->pbg_render_range($attr, 'iconSize', 'width', 'Tablet', null, '!important');

  $css->set_selector( '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-lottie-animation svg' );
  $css->pbg_render_range($attr, 'iconSize', 'width', 'Tablet', null, '!important');
  $css->pbg_render_range($attr, 'iconSize', 'height', 'Tablet', null, '!important');

  $css->set_selector( 
    '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-bullet-list-icon, ' .
    '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg, ' .
    '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-lottie-animation svg'
  );
  $css->pbg_render_background($attr, 'iconBG', 'Tablet');

  $css->set_selector( 
    '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-bullet-list-icon, ' .
    '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-list-item-svg-class svg, ' .
    '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-lottie-animation svg'
  );
  $css->pbg_render_background($attr, 'iconHoverBG', 'Tablet');

	// Style for title.
  $css->set_selector( ".{$unique_id} .premium-bullet-list__label" );
  $css->pbg_render_typography($attr, 'titleTypography', 'Tablet');
  $css->pbg_render_spacing($attr, 'titlemargin', 'margin', 'Tablet');

  // style for description
  $css->set_selector( ".{$unique_id} .premium-bullet-list__description" );
  $css->pbg_render_typography($attr, 'descriptionTypography', 'Tablet');
  $css->pbg_render_spacing($attr, 'descriptionMargin', 'margin', 'Tablet');

	// style for divider
  $css->set_selector( ".{$unique_id} .premium-bullet-list-divider-block:not(:last-child)::after" );
  $css->pbg_render_range($attr, 'dividerWidth', 'width', 'Tablet');
  $css->pbg_render_range($attr, 'dividerHeight', 'border-top-width', 'Tablet');

  $css->set_selector( ".{$unique_id} .premium-bullet-list-divider-inline:not(:last-child)::after" );
  $css->pbg_render_range($attr, 'dividerWidth', 'border-left-width', 'Tablet');
  $css->pbg_render_range($attr, 'dividerHeight', 'height', 'Tablet');

	$css->stop_media_query();

	$css->start_media_query( 'mobile' );

	// Align.
  $css->set_selector( '.' . $unique_id . ' .premium-bullet-list__icon-wrap' );
  $css->pbg_render_value($attr, 'bulletAlign', 'align-self', 'Mobile');

  $css->set_selector( '.' . $unique_id );
  $css->pbg_render_value($attr, 'align', 'text-align', 'Mobile');
  
  $css->set_selector( '.' . $unique_id . ' .premium-bullet-list__content-wrap' );
  $css->pbg_render_align_self($attr, 'align', 'justify-content', 'Mobile');

  // Style for list.
  $css->set_selector( '.' . $unique_id . ' > .premium-bullet-list' );
  $css->pbg_render_align_self($attr, 'align', 'justify-content', 'Mobile');
  $css->pbg_render_border($attr, 'generalBorder', 'Mobile');
  $css->pbg_render_spacing($attr, 'generalpadding', 'padding', 'Mobile');
  $css->pbg_render_spacing($attr, 'generalmargin', 'margin', 'Mobile');

  // Style for list item.
  $css->set_selector( '.' . $unique_id . ' .premium-bullet-list__wrapper' );
  $css->pbg_render_align_self($attr, 'align', 'justify-content', 'Mobile');
  $css->pbg_render_border($attr, 'itemBorder', 'Mobile');
  $css->pbg_render_spacing($attr, 'itempadding', 'padding', 'Mobile');
  $css->pbg_render_spacing($attr, 'itemmargin', 'margin', 'Mobile');

	// Style for icons.
  $css->set_selector( 
    '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-bullet-list-icon svg, ' .
    '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg' 
  );
  $css->pbg_render_range($attr, 'iconSize', 'width', 'Mobile', null, '!important');
  $css->pbg_render_range($attr, 'iconSize', 'height', 'Mobile', null, '!important');

  $css->set_selector( 
    '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-bullet-list-icon, ' .
    '.' . $unique_id . ' .premium-bullet-list__icon-wrap img,' .
    '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg, ' .
    '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-lottie-animation svg'
  );
  $css->pbg_render_border($attr, 'iconBorder', 'Mobile');
  $css->pbg_render_spacing($attr, 'iconPadding', 'padding', "Mobile");
  $css->pbg_render_spacing($attr, 'iconMargin', 'margin', 'Mobile');

  $css->set_selector( '.' . $unique_id . ' .premium-bullet-list__icon-wrap img' );
  $css->pbg_render_range($attr, 'iconSize', 'width', 'Mobile', null, '!important');

  $css->set_selector( '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-lottie-animation svg' );
  $css->pbg_render_range($attr, 'iconSize', 'width', 'Mobile', null, '!important');
  $css->pbg_render_range($attr, 'iconSize', 'height', 'Mobile', null, '!important');

  $css->set_selector( 
    '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-bullet-list-icon, ' .
    '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg, ' .
    '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-lottie-animation svg'
  );
  $css->pbg_render_background($attr, 'iconBG', 'Mobile');

  $css->set_selector( 
    '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-bullet-list-icon, ' .
    '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-list-item-svg-class svg, ' .
    '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-lottie-animation svg'
  );
  $css->pbg_render_background($attr, 'iconHoverBG', 'Mobile');

	// Style for title.
  $css->set_selector( ".{$unique_id} .premium-bullet-list__label" );
  $css->pbg_render_typography($attr, 'titleTypography', 'Mobile');
  $css->pbg_render_spacing($attr, 'titlemargin', 'margin', 'Mobile');

  // style for description
	$css->set_selector( ".{$unique_id} .premium-bullet-list__description" );
  $css->pbg_render_typography($attr, 'descriptionTypography', 'Mobile');
  $css->pbg_render_spacing($attr, 'descriptionMargin', 'margin', 'Mobile');

	// style for divider
  $css->set_selector( ".{$unique_id} .premium-bullet-list-divider-block:not(:last-child)::after" );
  $css->pbg_render_range($attr, 'dividerWidth', 'width', 'Mobile');
  $css->pbg_render_range($attr, 'dividerHeight', 'border-top-width', 'Mobile');

  $css->set_selector( ".{$unique_id} .premium-bullet-list-divider-inline:not(:last-child)::after" );
  $css->pbg_render_range($attr, 'dividerWidth', 'border-left-width', 'Mobile');
  $css->pbg_render_range($attr, 'dividerHeight', 'height', 'Mobile');

	$css->stop_media_query();
	return $css->css_output();
}

/**
 * Renders the `premium/count-up` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_bullet_list( $attributes, $content, $block ) {
	$block_helpers = pbg_blocks_helper();
	 // Enqueue frontend JS/CSS.
	if ( $block_helpers->it_is_not_amp() ) {
		wp_enqueue_script(
			'pbg-bullet-list',
			PREMIUM_BLOCKS_URL . 'assets/js/minified/bullet-list.min.js',
			array(),
			PREMIUM_BLOCKS_VERSION,
			true
		);
	}

	if ( $block_helpers->it_is_not_amp() ) {
		if ( isset( $attributes['iconTypeSelect'] ) && $attributes['iconTypeSelect'] === 'lottie' ) {
			wp_enqueue_script(
				'pbg-lottie',
				PREMIUM_BLOCKS_URL . 'assets/js/lib/lottie.min.js',
				array( 'jquery' ),
				PREMIUM_BLOCKS_VERSION,
				true
			);
		}
	}

	return $content;
}




/**
 * Register the bullet_list block.
 *
 * @uses render_block_pbg_bullet_list()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_bullet_list() {
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	register_block_type(
		PREMIUM_BLOCKS_PATH . '/blocks-config/bullet-list',
		array(
			'render_callback' => 'render_block_pbg_bullet_list',
		)
	);
}

register_block_pbg_bullet_list();
