<?php
/**
 * Server-side rendering of the `pbg/accordion` block.
 *
 * @package WordPress
 */

/**
 * Get Accordion Block CSS
 *
 * Return Frontend CSS for Accordion.
 *
 * @access public
 *
 * @param array  $attr      Block attributes.
 * @param string $unique_id Block ID.
 * @return string Generated CSS.
 */
function get_premium_accordion_css_style( $attr, $unique_id ) {
	$css = new Premium_Blocks_css();

	// Title wrap styles - Desktop
	$css->set_selector( ".{$unique_id} .premium-accordion__title_wrap" );
	$css->pbg_render_color( $attr, 'titleStyles[0].titleBack', 'background-color' );
	$css->pbg_render_spacing( $attr, 'titlePadding', 'padding', 'Desktop' );
	$css->pbg_render_border( $attr, 'titleBorder', 'Desktop' );

	// Title text styles - Normal
	$css->set_selector( ".{$unique_id} .premium-accordion__title_wrap .premium-accordion__title_text" );
	$css->pbg_render_color( $attr, 'titleStyles[0].titleColor', 'color' );
	$css->pbg_render_typography( $attr, 'titleTypography', 'Desktop' );
	$css->pbg_render_shadow( $attr, 'titleTextShadow', 'text-shadow' );

	// Title styles - Hover
	$css->set_selector( ".{$unique_id} .premium-accordion__title_wrap:hover" );
	$css->pbg_render_color( $attr, 'titleHoverBack', 'background-color' );

	$css->set_selector( ".{$unique_id} .premium-accordion__title_wrap:hover .premium-accordion__title_text" );
	$css->pbg_render_color( $attr, 'titleHoverColor', 'color' );

	// Title styles - Active
	$css->set_selector( ".{$unique_id} .is-active .premium-accordion__title_wrap" );
	$css->pbg_render_color( $attr, 'titleActiveBack', 'background-color' );

	$css->set_selector( ".{$unique_id} .is-active .premium-accordion__title_wrap .premium-accordion__title_text" );
	$css->pbg_render_color( $attr, 'titleActiveColor', 'color' );

	// Content wrap margin
	$css->set_selector( ".{$unique_id} .premium-accordion__content_wrap:not(:last-child)" );
	$css->pbg_render_range( $attr, 'titleMargin', 'margin-bottom', 'Desktop', '', '!important' );

	// Arrow/Icon wrap styles
	$css->set_selector( ".{$unique_id} .premium-accordion__title_wrap .premium-accordion__icon_wrap" );
	$css->pbg_render_color( $attr, 'arrowStyles[0].arrowBack', 'background-color' );
	$css->pbg_render_range( $attr, 'arrowStyles[0].arrowPadding', 'padding', '', '', 'px' );
	$css->pbg_render_range( $attr, 'arrowStyles[0].arrowRadius', 'border-radius', '', '', 'px' );
  $css->pbg_render_color( $attr, 'arrowStyles[0].arrowColor', 'fill' );

	// Arrow/Icon - Size
	$css->set_selector( ".{$unique_id} .premium-accordion__title_wrap .premium-accordion__icon_wrap svg.premium-accordion__icon" );
	$css->pbg_render_range( $attr, 'arrowStyles[0].arrowSize', 'width', '', '', 'px' );
	$css->pbg_render_range( $attr, 'arrowStyles[0].arrowSize', 'height', '', '', 'px' );

	// Arrow/Icon - Hover
	$css->set_selector( ".{$unique_id} .premium-accordion__title_wrap:hover .premium-accordion__icon_wrap" );
  $css->pbg_render_color( $attr, 'arrowHoverColor', 'fill' );
	$css->pbg_render_color( $attr, 'arrowHoverBack', 'background-color' );
	
	// Arrow/Icon - Active
	$css->set_selector( ".{$unique_id} .is-active .premium-accordion__title_wrap .premium-accordion__icon_wrap" );
  $css->pbg_render_color( $attr, 'arrowActiveColor', 'fill' );
	$css->pbg_render_color( $attr, 'arrowActiveBack', 'background-color' );

	// Description wrap styles
	$css->set_selector( ".{$unique_id} .premium-accordion__desc_wrap" );
	$css->pbg_render_color( $attr, 'descStyles[0].descBack', 'background-color' );
	$css->pbg_render_spacing( $attr, 'descPadding', 'padding', 'Desktop' );
	$css->pbg_render_border( $attr, 'descBorder', 'Desktop' );
	$css->pbg_render_value( $attr, 'descAlign', 'text-align', 'Desktop' );
	$css->pbg_render_shadow( $attr, 'textShadow', 'text-shadow' );

	// Description text styles
	$css->set_selector( ".{$unique_id} .premium-accordion__desc_wrap .premium-accordion__desc" );
	$css->pbg_render_typography( $attr, 'descTypography', 'Desktop' );
	$css->pbg_render_color( $attr, 'descStyles[0].descColor', 'color' );
	$css->pbg_render_shadow( $attr, 'textShadow', 'text-shadow' );

	// Tablet responsive styles
	$css->start_media_query( 'tablet' );

	// Title text typography
	$css->set_selector( ".{$unique_id} .premium-accordion__title_wrap .premium-accordion__title_text" );
	$css->pbg_render_typography( $attr, 'titleTypography', 'Tablet' );

	// Title wrap padding and margin
	$css->set_selector( ".{$unique_id} .premium-accordion__title_wrap" );
	$css->pbg_render_spacing( $attr, 'titlePadding', 'padding', 'Tablet' );
	$css->pbg_render_border( $attr, 'titleBorder', 'Tablet' );

	$css->set_selector( ".{$unique_id} .premium-accordion__content_wrap" );
	$css->pbg_render_range( $attr, 'titleMargin', 'margin-bottom', 'Tablet', '', '!important' );

  // Description wrap padding and alignment
	$css->set_selector( ".{$unique_id} .premium-accordion__desc_wrap" );
	$css->pbg_render_spacing( $attr, 'descPadding', 'padding', 'Tablet' );
	$css->pbg_render_border( $attr, 'descBorder', 'Tablet' );
	$css->pbg_render_value( $attr, 'descAlign', 'text-align', 'Tablet' );

	// Description text typography
	$css->set_selector( ".{$unique_id} .premium-accordion__desc_wrap .premium-accordion__desc" );
	$css->pbg_render_typography( $attr, 'descTypography', 'Tablet' );

	$css->stop_media_query();
	// Mobile responsive styles
	$css->start_media_query( 'mobile' );

	// Title text typography
	$css->set_selector( ".{$unique_id} .premium-accordion__title_wrap .premium-accordion__title_text" );
	$css->pbg_render_typography( $attr, 'titleTypography', 'Mobile' );

	// Title wrap padding and margin
	$css->set_selector( ".{$unique_id} .premium-accordion__title_wrap" );
	$css->pbg_render_spacing( $attr, 'titlePadding', 'padding', 'Mobile' );
	$css->pbg_render_border( $attr, 'titleBorder', 'Mobile' );

	$css->set_selector( ".{$unique_id} .premium-accordion__content_wrap" );
	$css->pbg_render_range( $attr, 'titleMargin', 'margin-bottom', 'Mobile', '', '!important' );

  // Description wrap padding and alignment
	$css->set_selector( ".{$unique_id} .premium-accordion__desc_wrap" );
	$css->pbg_render_spacing( $attr, 'descPadding', 'padding', 'Mobile' );
	$css->pbg_render_border( $attr, 'descBorder', 'Mobile' );
	$css->pbg_render_value( $attr, 'descAlign', 'text-align', 'Mobile' );

	// Description text typography
	$css->set_selector( ".{$unique_id} .premium-accordion__desc_wrap .premium-accordion__desc" );
	$css->pbg_render_typography( $attr, 'descTypography', 'Mobile' );

	$css->stop_media_query();

	return $css->css_output();
}

/**
 * Renders the `premium/accordion` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_accordion( $attributes, $content, $block ) {
  $block_id          = $attributes['blockId'] ?? '';
	$collapse_others   = isset( $attributes['collapseOthers'] ) ? $attributes['collapseOthers'] : false;
	$expand_first_item = isset( $attributes['expandFirstItem'] ) ? $attributes['expandFirstItem'] : false;
	$block_helpers     = pbg_blocks_helper();

	if ( $block_helpers->it_is_not_amp() ) {
		// Enqueue script only once per page.
		if ( ! wp_script_is( 'pbg-accordion', 'enqueued' ) ) {
			wp_enqueue_script(
				'pbg-accordion',
				PREMIUM_BLOCKS_URL . 'assets/js/minified/accordion.min.js',
				array(),
				PREMIUM_BLOCKS_VERSION,
				true
			);
		}

		// Add this block's settings to the accordion data.
		add_filter(
			'premium_accordion_localize_data',
			function ( $data ) use ( $block_id, $collapse_others, $expand_first_item ) {
				$data[ $block_id ] = array(
					'collapse_others'   => $collapse_others,
					'expand_first_item' => $expand_first_item,
				);
				return $data;
			}
		);

		// Prepare data for inline script.
		$data = apply_filters( 'premium_accordion_localize_data', array() );

    wp_scripts()->add_data('pbg-accordion', 'before', array());

		// Add inline script data (merges with existing data if multiple accordions exist).
		if ( ! empty( $data ) ) {
			wp_add_inline_script(
        'pbg-accordion',
        'pbg_accordion = ' . wp_json_encode($data) . ';',
        'before'
      );
		}
	}

	return $content;
}




/**
 * Register the accordion block.
 *
 * @uses render_block_pbg_accordion()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_accordion() {
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	register_block_type(
		PREMIUM_BLOCKS_PATH . '/blocks-config/accordion',
		array(
			'render_callback' => 'render_block_pbg_accordion',
		)
	);
}

register_block_pbg_accordion();
