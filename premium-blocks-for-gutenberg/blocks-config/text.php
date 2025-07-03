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
  $css->set_selector( ".{$unique_id}" );
  $css->pbg_render_border($attributes, 'border', 'Desktop');
  $css->pbg_render_background($attributes, 'background', 'Desktop');
  $css->pbg_render_range($attributes, 'rotateText', 'transform', 'Desktop', 'rotate(', ')!important');
  $css->pbg_render_align_self($attributes, 'align', 'align-self', 'Desktop');

  $css->set_selector( ".{$unique_id} .premium-text-wrap" );
  $css->pbg_render_color($attributes, 'color', 'color');
	$css->pbg_render_shadow($attributes, 'textShadow', 'text-shadow');
  $css->pbg_render_value($attributes, 'align', 'text-align', 'Desktop', null, '!important');
	$css->pbg_render_typography($attributes, 'typography', 'Desktop');

  $css->set_selector( ":root:has(.{$unique_id}) .{$unique_id}.wp-block-premium-text" );
  $css->pbg_render_spacing($attributes, 'margin', 'margin', 'Desktop');
  $css->pbg_render_spacing($attributes, 'padding', 'padding', 'Desktop', null, '!important');

	$css->start_media_query( 'tablet' );

	// Tablet Styles.
  $css->set_selector( ".{$unique_id}" );
  $css->pbg_render_border($attributes, 'border', 'Tablet');
  $css->pbg_render_background($attributes, 'background', 'Tablet');
  $css->pbg_render_range($attributes, 'rotateText', 'transform', 'Tablet', 'rotate(', ')!important');
  $css->pbg_render_align_self($attributes, 'align', 'align-self', 'Tablet');

  $css->set_selector( ".{$unique_id} .premium-text-wrap" );
  $css->pbg_render_value($attributes, 'align', 'text-align', 'Tablet', null, '!important');
	$css->pbg_render_typography($attributes, 'typography', 'Tablet');

  $css->set_selector( ":root:has(.{$unique_id}) .{$unique_id}.wp-block-premium-text" );
  $css->pbg_render_spacing($attributes, 'margin', 'margin', 'Tablet');
  $css->pbg_render_spacing($attributes, 'padding', 'padding', 'Tablet', null, '!important');

	$css->stop_media_query();
	$css->start_media_query( 'mobile' );
	// Mobile Styles.
  $css->set_selector( ".{$unique_id}" );
  $css->pbg_render_border($attributes, 'border', 'Mobile');
  $css->pbg_render_background($attributes, 'background', 'Mobile');
  $css->pbg_render_range($attributes, 'rotateText', 'transform', 'Mobile', 'rotate(', ')!important');
  $css->pbg_render_align_self($attributes, 'align', 'align-self', 'Tablet');

  $css->set_selector( ".{$unique_id} .premium-text-wrap" );
  $css->pbg_render_value($attributes, 'align', 'text-align', 'Mobile', null, '!important');
	$css->pbg_render_typography($attributes, 'typography', 'Mobile');

  $css->set_selector( ":root:has(.{$unique_id}) .{$unique_id}.wp-block-premium-text" );
  $css->pbg_render_spacing($attributes, 'margin', 'margin', 'Mobile');
  $css->pbg_render_spacing($attributes, 'padding', 'padding', 'Mobile', null, '!important');

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
