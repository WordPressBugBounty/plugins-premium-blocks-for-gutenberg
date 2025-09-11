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
  $css->set_selector( '.' . $unique_id );
  $css->pbg_render_spacing($attr, 'contentPadding', 'padding', 'Desktop', null, '!important');
  $css->pbg_render_value($attr, 'align', 'text-align', 'Desktop');

  $css->set_selector( '.' . $unique_id . ' .premium-icon-group-horizontal' );
  $css->pbg_render_align_self($attr, 'align', 'justify-content', 'Desktop');
	
  $css->set_selector( '.' . $unique_id . ' .premium-icon-group-vertical' );
  $css->pbg_render_align_self($attr, 'align', 'align-items', 'Desktop');

  $css->set_selector( '.' . $unique_id . ' .premium-image-container' );
  $css->pbg_render_align_self($attr, 'align', 'justify-content', 'Desktop');
	
  $css->set_selector( '.' . $unique_id . ' .is-style-style2 .premium-person-overall-container' );
  $css->pbg_render_range($attr, 'bottomOffset', 'bottom', 'Desktop');
	
	$css->start_media_query( 'tablet' );

	// style for container
	$css->set_selector( '.' . $unique_id );
  $css->pbg_render_spacing($attr, 'contentPadding', 'padding', 'Tablet', null, '!important');
  $css->pbg_render_value($attr, 'align', 'text-align', 'Tablet');

  $css->set_selector( '.' . $unique_id . ' .premium-icon-group-horizontal' );
  $css->pbg_render_align_self($attr, 'align', 'justify-content', 'Tablet');
	
  $css->set_selector( '.' . $unique_id . ' .premium-icon-group-vertical' );
  $css->pbg_render_align_self($attr, 'align', 'align-items', 'Tablet');

  $css->set_selector( '.' . $unique_id . ' .premium-image-container' );
  $css->pbg_render_align_self($attr, 'align', 'justify-content', 'Tablet');
	
  $css->set_selector( '.' . $unique_id . ' .is-style-style2 .premium-person-overall-container' );
  $css->pbg_render_range($attr, 'bottomOffset', 'bottom', 'Tablet');

	$css->stop_media_query();
	$css->start_media_query( 'mobile' );

	// style for container
	$css->set_selector( '.' . $unique_id );
  $css->pbg_render_spacing($attr, 'contentPadding', 'padding', 'Mobile', null, '!important');
  $css->pbg_render_value($attr, 'align', 'text-align', 'Mobile');

  $css->set_selector( '.' . $unique_id . ' .premium-icon-group-horizontal' );
  $css->pbg_render_align_self($attr, 'align', 'justify-content', 'Mobile');
	
  $css->set_selector( '.' . $unique_id . ' .premium-icon-group-vertical' );
  $css->pbg_render_align_self($attr, 'align', 'align-items', 'Mobile');

  $css->set_selector( '.' . $unique_id . ' .premium-image-container' );
  $css->pbg_render_align_self($attr, 'align', 'justify-content', 'Mobile');
	
  $css->set_selector( '.' . $unique_id . ' .is-style-style2 .premium-person-overall-container' );
  $css->pbg_render_range($attr, 'bottomOffset', 'bottom', 'Mobile');

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
