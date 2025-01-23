<?php
// Move this file to "blocks-config" folder with name "text.php".

/**
 * Server-side rendering of the `premium/text` block.
 *
 * @package WordPress
 */

 function get_premium_text_css( $attributes, $unique_id ) {
	$css = new Premium_Blocks_css();

	// Desktop Styles.
	if ( isset( $attributes['color'] ) ) {
		$color = $attributes['color'];

		$css->set_selector( ".{$unique_id} .premium-text-wrap" );
		$css->add_property( 'color', $css->render_color( $color ) );
	}
	if ( isset( $attributes['align'] ) ) {
		$align = $css->render_string($css->get_responsive_css( $attributes['align'], 'Desktop' ), '!important' );

		$css->set_selector( ".{$unique_id} .premium-text-wrap" );
		$css->add_property( 'text-align', $align );
	}

    if ( isset( $attributes['align'] ) ) {
       $content_align      = $css->get_responsive_css( $attributes['align'], 'Desktop' );
		$css->set_selector( ".{$unique_id} .premium-text-wrap" );
        $css->add_property( 'align-self', $css->render_align_self($content_align) );
	}

	if ( isset( $attributes['typography'] ) ) {
		$typography = $attributes['typography'];

		$css->set_selector( ".{$unique_id} .premium-text-wrap" );
		$css->render_typography( $typography, 'Desktop' );
	}

	if ( isset( $attributes['border'] ) ) {
		$border        = $attributes['border'];
		$border_width  = $attributes['border']['borderWidth'];
		$border_radius = $attributes['border']['borderRadius'];

		$css->set_selector( ".{$unique_id} .premium-text-wrap" );
		$css->add_property( 'border-width', $css->render_spacing( $border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $border_radius['Desktop'], 'px' ) );
		$css->add_property( 'border-style', $css->render_string( $border['borderType'] ) );
		if(isset($border['borderColor'])){
			$css->add_property( 'border-color', $css->render_color( $border['borderColor'] ) );
		}

	}

	if ( isset( $attributes['padding'] ) ) {
		$padding = $attributes['padding'];

		$css->set_selector( ".{$unique_id} .premium-text-wrap" );
		$css->add_property( 'padding', $css->render_spacing( $padding['Desktop'], isset($padding['unit']['Desktop'])?$padding['unit']['Desktop']:$padding['unit']  ));
	}
	if ( isset( $attributes['background'] ) ) {
		$css->set_selector( ".{$unique_id} .premium-text-wrap" );
		$css->render_background( $attributes['background'], 'Desktop' );

	}
	if ( isset( $attributes['margin'] ) ) {
		$margin = $attributes['margin'];

		$css->set_selector( ".{$unique_id} .premium-text-wrap" );
		$css->add_property( 'margin', $css->render_spacing( $margin['Desktop'], isset($margin['unit']['Desktop'])?$margin['unit']['Desktop']:$margin['unit'] ));
	}

	if ( isset( $attributes['textShadow'] ) ) {
		$title_shadow = $attributes['textShadow'];
		$css->set_selector( ".{$unique_id} .premium-text-wrap" );
		$css->add_property( 'text-shadow', $css->render_shadow( $title_shadow ) );
	}

	if ( isset( $attributes['rotateText'] ) ) {
		$rotate_text = $attributes['rotateText'];
		$value       = $css->render_range( $rotate_text, 'Desktop' );
		$css->set_selector( ".{$unique_id} .premium-text-wrap" );
		$css->add_property( 'transform', "rotate({$value})!important" );
	}

	$css->start_media_query( 'tablet' );
	// Tablet Styles.
	if ( isset( $attributes['align'] ) ) {
		$align =  $css->render_string($css->get_responsive_css( $attributes['align'], 'Tablet' ), '!important' );
		$css->set_selector( ".{$unique_id} .premium-text-wrap" );
		$css->add_property( 'text-align', $align );
	}

    if ( isset( $attributes['align'] ) ) {
       $content_align      = $css->get_responsive_css( $attributes['align'], 'Tablet' );
		$css->set_selector( ".{$unique_id} .premium-text-wrap" );
        $css->add_property( 'align-self', $css->render_align_self($content_align) );
	}

	if ( isset( $attributes['typography'] ) ) {
		$typography = $attributes['typography'];

		$css->set_selector( ".{$unique_id} .premium-text-wrap" );
		$css->render_typography( $typography, 'Tablet' );
	}

	if ( isset( $attributes['border'] ) ) {
		$border        = $attributes['border'];
		$border_width  = $attributes['border']['borderWidth'];
		$border_radius = $attributes['border']['borderRadius'];

		$css->set_selector( ".{$unique_id} .premium-text-wrap" );
		$css->add_property( 'border-width', $css->render_spacing( $border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $border_radius['Tablet'], 'px' ) );
	}

	if ( isset( $attributes['padding'] ) ) {
		$padding = $attributes['padding'];

		$css->set_selector( ".{$unique_id} .premium-text-wrap" );
		$css->add_property( 'padding', $css->render_spacing( $padding['Tablet'], isset($padding['unit']['Tablet'])?$padding['unit']['Tablet']:$padding['unit'] ));
	}

	if ( isset( $attributes['margin'] ) ) {
		$margin = $attributes['margin'];

		$css->set_selector( ".{$unique_id} .premium-text-wrap" );
		$css->add_property( 'margin', $css->render_spacing( $margin['Tablet'], isset($margin['unit']['Tablet'])?$margin['unit']['Tablet']:$margin['unit'] ));
	}

	if ( isset( $attributes['background'] ) ) {
		$css->set_selector( ".{$unique_id} .premium-text-wrap" );
		$css->render_background( $attributes['background'], 'Tablet' );
	}

	if ( isset( $attributes['rotateText'] ) ) {
		$rotate_text = $attributes['rotateText'];
		$value       = $css->render_range( $rotate_text, 'Tablet' );
		$css->set_selector( ".{$unique_id} .premium-text-wrap" );
		$css->add_property( 'transform', "rotate({$value})!important" );
	}

	$css->stop_media_query();
	$css->start_media_query( 'mobile' );
	// Mobile Styles.
	if ( isset( $attributes['align'] ) ) {
		$align =  $css->render_string($css->get_responsive_css( $attributes['align'], 'Mobile' ), '!important' );

		$css->set_selector( ".{$unique_id} .premium-text-wrap" );
		$css->add_property( 'text-align', $align );
	}

        if ( isset( $attributes['align'] ) ) {
       $content_align      = $css->get_responsive_css( $attributes['align'], 'Mobile' );
		$css->set_selector( ".{$unique_id} .premium-text-wrap" );
        $css->add_property( 'align-self', $css->render_align_self($content_align) );
	}

	if ( isset( $attributes['typography'] ) ) {
		$typography = $attributes['typography'];

		$css->set_selector( ".{$unique_id} .premium-text-wrap" );
		$css->render_typography( $typography, 'Mobile' );
	}

	if ( isset( $attributes['border'] ) ) {
		$border        = $attributes['border'];
		$border_width  = $attributes['border']['borderWidth'];
		$border_radius = $attributes['border']['borderRadius'];

		$css->set_selector( ".{$unique_id} .premium-text-wrap" );
		$css->add_property( 'border-width', $css->render_spacing( $border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $border_radius['Mobile'], 'px' ) );
	}

	if ( isset( $attributes['padding'] ) ) {
		$padding = $attributes['padding'];

		$css->set_selector( ".{$unique_id} .premium-text-wrap" );
		$css->add_property( 'padding', $css->render_spacing( $padding['Mobile'], isset($padding['unit']['Mobile'])?$padding['unit']['Mobile']:$padding['unit'] ));
	}

	if ( isset( $attributes['background'] ) ) {
		$css->set_selector( ".{$unique_id} .premium-text-wrap" );
		$css->render_background( $attributes['background'], 'Mobile' );

	}

	if ( isset( $attributes['margin'] ) ) {
		$margin = $attributes['margin'];

		$css->set_selector( ".{$unique_id} .premium-text-wrap" );
		$css->add_property( 'margin', $css->render_spacing( $margin['Mobile'], isset($margin['unit']['Mobile'])?$margin['unit']['Mobile']:$margin['unit'] ));
	}

	if ( isset( $attributes['rotateText'] ) ) {
		$rotate_text = $attributes['rotateText'];
		$value       = $css->render_range( $rotate_text, 'Mobile' );
		$css->set_selector( ".{$unique_id} .premium-text-wrap" );
		$css->add_property( 'transform', "rotate({$value})!important" );
	}

	$css->stop_media_query();

	return $css->css_output();
}

/**
 * Renders the `premium/text` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_text( $attributes, $content, $block ) {

	return $content;
}


/**
 * Register the Text block.
 *
 * @uses render_block_pbg_text()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_text() {
	register_block_type(
		'premium/text',
		array(
			'render_callback' => 'render_block_pbg_text',
			'editor_style'    => 'premium-blocks-editor-css',
			'editor_script'   => 'pbg-blocks-js',
		)
	);
}

register_block_pbg_text();
