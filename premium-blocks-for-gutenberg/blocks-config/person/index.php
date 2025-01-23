<?php
/**
 * Server-side rendering of the `pbg/person` block.
 *
 * @package WordPress
 */

/**
 * Get Person Block CSS
 *
 * Return Frontend CSS for Person.
 *
 * @access public
 *
 * @param string $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_person_css_style( $attr, $unique_id ) {
	$css = new Premium_Blocks_css();

	// style for container
	if ( isset( $attr['align'] ) ) {
		$css->set_selector( '.' . $unique_id );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['align'], 'Desktop' ) );
	}

	if ( isset( $attr['align'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-text .premium-text-wrap' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['align'], 'Desktop' ) );
	}

	if ( isset( $attr['align'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-heading');
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['align'], 'Desktop' ) );
	}

	if ( isset( $attr['align'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-icon-group' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['align'], 'Desktop' ) );
	}

	if ( isset( $attr['align'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-icon-group-horizontal' );
		$css->add_property( 'justify-content', $css->get_responsive_css( $attr['align'], 'Desktop' ) );
	}

	if ( isset( $attr['align'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-image .premium-image-container' );
		$css->add_property( 'justify-content', $css->get_responsive_css( $attr['align'], 'Desktop' ) );
	}

	if ( isset( $attr['align'] ) ) {
		$align      = $css->get_responsive_css( $attr['align'], 'Desktop' );
		$flex_align = 'left' === $align ? 'flex-start' : 'center';
		$flex_align = 'right' === $align ? 'flex-end' : $flex_align;

		$css->set_selector( '.' . $unique_id . ' .premium-icon-group-vertical' );
		$css->add_property( 'justify-content', $css->get_responsive_css( $attr['align'], 'Desktop' ) );
		$css->add_property( 'align-items', $flex_align );
	}

	// style for Content
	if ( isset( $attr['contentPadding'] ) ) {
		$content_padding = $attr['contentPadding'];
		$css->set_selector( '.' . $unique_id );
		$css->add_property( 'padding', $css->render_string( $css->render_spacing( $content_padding['Desktop'],isset($content_padding['unit']['Desktop'])?$content_padding['unit']['Desktop']:$content_padding['unit']  ) , '!important' ));
	}
	if ( isset( $attr['bottomOffset'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .is-style-style2 .premium-person-overall-container' );
		$css->add_property( 'bottom', $css->render_range( $attr['bottomOffset'], 'Desktop' ) );
	}

	$css->start_media_query( 'tablet' );

	// style for container
	if ( isset( $attr['align'] ) ) {
		$css->set_selector( '.' . $unique_id );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['align'], 'Tablet' ) );
	}

	if ( isset( $attr['align'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-text .premium-text-wrap' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['align'], 'Tablet' ) );
	}

	if ( isset( $attr['align'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-heading');
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['align'], 'Tablet' ) );
	}

	if ( isset( $attr['align'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-icon-group' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['align'], 'Tablet' ) );
	}

	if ( isset( $attr['align'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-icon-group-horizontal' );
		$css->add_property( 'justify-content', $css->get_responsive_css( $attr['align'], 'Tablet' ) );
	}

	if ( isset( $attr['align'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-image .premium-image-container' );
		$css->add_property( 'justify-content', $css->get_responsive_css( $attr['align'], 'Tablet' ) );
	}

	if ( isset( $attr['align'] ) ) {
		$align      = $css->get_responsive_css( $attr['align'], 'Tablet' );
		$flex_align = 'left' === $align ? 'flex-start' : 'center';
		$flex_align = 'right' === $align ? 'flex-end' : $flex_align;

		$css->set_selector( '.' . $unique_id . ' .premium-icon-group-vertical' );
		$css->add_property( 'justify-content', $css->get_responsive_css( $attr['align'], 'Tablet' ) );
		$css->add_property( 'align-items', $flex_align );
	}

	// style for Content
	if ( isset( $attr['contentPadding'] ) ) {
		$content_padding = $attr['contentPadding'];
		$css->set_selector( '.' . $unique_id );
		$css->add_property( 'padding', $css->render_string( $css->render_spacing( $content_padding['Tablet'], isset($content_padding['unit']['Tablet'])?$content_padding['unit']['Tablet']:$content_padding['unit']  ) , '!important' ));
	}
	if ( isset( $attr['bottomOffset'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .is-style-style2 .premium-person-overall-container' );
		$css->add_property( 'bottom', $css->render_range( $attr['bottomOffset'], 'Tablet' ) );
	}

	$css->stop_media_query();

	$css->start_media_query( 'mobile' );

	// style for container
	if ( isset( $attr['align'] ) ) {
		$css->set_selector( '.' . $unique_id );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['align'], 'Mobile' ) );
	}

	if ( isset( $attr['align'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-text .premium-text-wrap' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['align'], 'Mobile' ) );
	}

	if ( isset( $attr['align'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-heading');
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['align'], 'Mobile' ) );
	}

	if ( isset( $attr['align'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-icon-group' );
		$css->add_property( 'text-align', $css->get_responsive_css( $attr['align'], 'Mobile' ) );
	}

	if ( isset( $attr['align'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-icon-group-horizontal' );
		$css->add_property( 'justify-content', $css->get_responsive_css( $attr['align'], 'Mobile' ) );
	}

	if ( isset( $attr['align'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .premium-image .premium-image-container' );
		$css->add_property( 'justify-content', $css->get_responsive_css( $attr['align'], 'Mobile' ) );
	}

	if ( isset( $attr['align'] ) ) {
		$align      = $css->get_responsive_css( $attr['align'], 'Mobile' );
		$flex_align = 'left' === $align ? 'flex-start' : 'center';
		$flex_align = 'right' === $align ? 'flex-end' : $flex_align;

		$css->set_selector( '.' . $unique_id . ' .premium-icon-group-vertical' );
		$css->add_property( 'justify-content', $css->get_responsive_css( $attr['align'], 'Mobile' ) );
		$css->add_property( 'align-items', $flex_align );
	}

	// style for Content
	if ( isset( $attr['contentPadding'] ) ) {
		$content_padding = $attr['contentPadding'];
		$css->set_selector( '.' . $unique_id );
		$css->add_property( 'padding', $css->render_string( $css->render_spacing( $content_padding['Mobile'], isset($content_padding['unit']['Mobile'])?$content_padding['unit']['Mobile']:$content_padding['unit']  ) , '!important' ));
	}
	if ( isset( $attr['bottomOffset'] ) ) {
		$css->set_selector( '.' . $unique_id . ' .is-style-style2 .premium-person-overall-container' );
		$css->add_property( 'bottom', $css->render_range( $attr['bottomOffset'], 'Mobile' ) );
	}

	$css->stop_media_query();
	return $css->css_output();
}

/**
 * Renders the `premium/person` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_person( $attributes, $content, $block ) {

	return $content;
}




/**
 * Register the person block.
 *
 * @uses render_block_pbg_person()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_person() {
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	register_block_type(
		PREMIUM_BLOCKS_PATH . '/blocks-config/person',
		array(
			'render_callback' => 'render_block_pbg_person',
		)
	);
}

register_block_pbg_person();
