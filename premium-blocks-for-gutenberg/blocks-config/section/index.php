<?php

/**
 * Server-side rendering of the `pbg/section` block.
 *
 * @package WordPress
 */

/**
 * Get Section Block CSS
 *
 * Return Frontend CSS for Section.
 *
 * @access public
 *
 * @param string $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_section_css_style( $attr, $unique_id ) {
	$css = new Premium_Blocks_css();

  $css->set_selector( $unique_id );
  $css->pbg_render_spacing($attr, 'padding', 'padding', 'Desktop', null, '!important');
	
  $css->set_selector( "body .entry-content {$unique_id}.premium-section" );
  $css->pbg_render_spacing($attr, 'margin', 'margin', 'Desktop');
	
	if ( isset( $attr['border'] ) ) {
		$border        = $attr['border'];
		$border_width  = $border['borderWidth'];
		$border_radius = $border['borderRadius'];

		$css->set_selector( $unique_id );
		$css->add_property( 'border-width', $css->render_spacing( $border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $border_radius['Desktop'], 'px' ) );
	}

  $css->set_selector( $unique_id );
  $css->pbg_render_value($attr, 'horAlign', 'text-align', 'Desktop');
  
  $css->set_selector( $unique_id  . ' .premium-section__content_wrap .premium-section__content_inner');
  $css->pbg_render_align_self($attr, 'horAlign', 'align-items', 'Desktop');

	if ( isset( $attr['background'] ) ) {
		$css->set_selector( $unique_id );
		$css->render_background( $attr['background'], 'Desktop' );

	}

	$css->start_media_query( 'tablet' );

	$css->set_selector( $unique_id );
  $css->pbg_render_spacing($attr, 'padding', 'padding', 'Tablet', null, '!important');

	$css->set_selector( "body .entry-content {$unique_id}.premium-section" );
  $css->pbg_render_spacing($attr, 'margin', 'margin', 'Tablet');

	if ( isset( $attr['border'] ) ) {
		$border        = $attr['border'];
		$border_width  = $border['borderWidth'];
		$border_radius = $border['borderRadius'];

		$css->set_selector( $unique_id );
		$css->add_property( 'border-width', $css->render_spacing( $border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $border_radius['Tablet'], 'px' ) );
	}

	$css->set_selector( $unique_id );
  $css->pbg_render_value($attr, 'horAlign', 'text-align', 'Tablet');
  
  $css->set_selector( $unique_id  . ' .premium-section__content_wrap .premium-section__content_inner');
  $css->pbg_render_align_self($attr, 'horAlign', 'align-items', 'Tablet');

	if ( isset( $attr['background'] ) ) {
		$css->set_selector( $unique_id );
		$css->render_background( $attr['background'], 'Tablet' );

	}
	$css->stop_media_query();

	$css->start_media_query( 'mobile' );

	$css->set_selector( $unique_id );
  $css->pbg_render_spacing($attr, 'padding', 'padding', 'Mobile', null, '!important');

	$css->set_selector( "body .entry-content {$unique_id}.premium-section" );
  $css->pbg_render_spacing($attr, 'margin', 'margin', 'Mobile');

	if ( isset( $attr['border'] ) ) {
		$border        = $attr['border'];
		$border_width  = $border['borderWidth'];
		$border_radius = $border['borderRadius'];

		$css->set_selector( $unique_id );
		$css->add_property( 'border-width', $css->render_spacing( $border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $border_radius['Mobile'], 'px' ) );
	}

	$css->set_selector( $unique_id );
  $css->pbg_render_value($attr, 'horAlign', 'text-align', 'Mobile');
  
  $css->set_selector( $unique_id  . ' .premium-section__content_wrap .premium-section__content_inner');
  $css->pbg_render_align_self($attr, 'horAlign', 'align-items', 'Mobile');
    
	if ( isset( $attr['background'] ) ) {
		$css->set_selector( $unique_id );
		$css->render_background( $attr['background'], 'Mobile' );

	}
	$css->stop_media_query();
	return $css->css_output();
}

/**
 * Renders the `premium/section` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_section( $attributes, $content, $block ) {

	return $content;
}




/**
 * Register the section block.
 *
 * @uses render_block_pbg_section()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_section() {
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	register_block_type(
		PREMIUM_BLOCKS_PATH . '/blocks-config/section',
		array(
			'render_callback' => 'render_block_pbg_section',
		)
	);
}

register_block_pbg_section();
