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

	if ( isset( $attr['padding'] ) ) {
		$padding = $attr['padding'];
		$css->set_selector( $unique_id );
		$css->add_property( 'padding', $css->render_spacing( $padding['Desktop'], isset( $padding['unit']['Desktop'] ) ? $padding['unit']['Desktop'] : $padding['unit'] ) , '!important' );
	}

	if ( isset( $attr['margin'] ) ) {
		$margin = $attr['margin'];
		$css->set_selector( $unique_id );
		$css->add_property( 'margin', $css->render_spacing( $margin['Desktop'], isset( $margin['unit']['Desktop'] ) ? $margin['unit']['Desktop'] : $margin['unit'] ) );
	}

	if ( isset( $attr['border'] ) ) {
		$border        = $attr['border'];
		$border_width  = $border['borderWidth'];
		$border_radius = $border['borderRadius'];

		$css->set_selector( $unique_id );
		$css->add_property( 'border-width', $css->render_spacing( $border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $border_radius['Desktop'], 'px' ) );
	}
	if ( isset( $attr['horAlign'] ) ) {
        $content_align      = $css->get_responsive_css( $attr['horAlign'], 'Desktop' );
		$content_flex_align = 'left' === $content_align ? 'flex-start' : 'center';
		$content_flex_align = 'right' === $content_align ? 'flex-end' : $content_flex_align;
		$css->set_selector( $unique_id );
		$css->add_property( 'text-align', $content_align );
        $css->add_property( 'align-self',  $css->render_align_self($content_align) );
	}
	if ( isset( $attr['background'] ) ) {
		$css->set_selector( $unique_id );
		$css->render_background( $attr['background'], 'Desktop' );

	}

	$css->start_media_query( 'tablet' );

	if ( isset( $attr['padding'] ) ) {
		$padding = $attr['padding'];
		$css->set_selector( $unique_id );
		$css->add_property( 'padding', $css->render_spacing( $padding['Tablet'], isset( $padding['unit']['Tablet'] ) ? $padding['unit']['Tablet'] : $padding['unit'] ) );
	}

	if ( isset( $attr['margin'] ) ) {
		$margin = $attr['margin'];
		$css->set_selector( $unique_id );
		$css->add_property( 'margin', $css->render_spacing( $margin['Tablet'], isset( $margin['unit']['Tablet'] ) ? $margin['unit']['Tablet'] : $margin['unit'] ) );
	}

	if ( isset( $attr['border'] ) ) {
		$border        = $attr['border'];
		$border_width  = $border['borderWidth'];
		$border_radius = $border['borderRadius'];

		$css->set_selector( $unique_id );
		$css->add_property( 'border-width', $css->render_spacing( $border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $border_radius['Tablet'], 'px' ) );
	}

	if ( isset( $attr['horAlign'] ) ) {
	        $content_align      = $css->get_responsive_css( $attr['horAlign'], 'Tablet' );
		$content_flex_align = 'left' === $content_align ? 'flex-start' : 'center';
		$content_flex_align = 'right' === $content_align ? 'flex-end' : $content_flex_align;
		$css->set_selector( $unique_id );
		$css->add_property( 'text-align', $content_align );
        $css->add_property( 'align-self',  $css->render_align_self($content_align) );
	}
	if ( isset( $attr['background'] ) ) {
		$css->set_selector( $unique_id );
		$css->render_background( $attr['background'], 'Tablet' );

	}
	$css->stop_media_query();

	$css->start_media_query( 'mobile' );

	if ( isset( $attr['padding'] ) ) {
		$padding = $attr['padding'];
		$css->set_selector( $unique_id );
		$css->add_property( 'padding', $css->render_spacing( $padding['Mobile'], isset( $padding['unit']['Mobile'] ) ? $padding['unit']['Mobile'] : $padding['unit'] ) );
	}

	if ( isset( $attr['margin'] ) ) {
		$margin = $attr['margin'];
		$css->set_selector( $unique_id );
		$css->add_property( 'margin', $css->render_spacing( $margin['Mobile'], isset( $margin['unit']['Mobile'] ) ? $margin['unit']['Mobile'] : $margin['unit'] ) );
	}

	if ( isset( $attr['border'] ) ) {
		$border        = $attr['border'];
		$border_width  = $border['borderWidth'];
		$border_radius = $border['borderRadius'];

		$css->set_selector( $unique_id );
		$css->add_property( 'border-width', $css->render_spacing( $border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $border_radius['Mobile'], 'px' ) );
	}

	if ( isset( $attr['horAlign'] ) ) {
        $content_align      = $css->get_responsive_css( $attr['horAlign'], 'Mobile' );
		$content_flex_align = 'left' === $content_align ? 'flex-start' : 'center';
		$content_flex_align = 'right' === $content_align ? 'flex-end' : $content_flex_align;
		$css->set_selector( $unique_id );
		$css->add_property( 'text-align', $content_align );
        $css->add_property( 'align-self',  $css->render_align_self($content_align) );
	}
    
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
