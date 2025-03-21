<?php
/**
 * Server-side rendering of the `premium/form-textarea` block.
 *
 * @package WordPress
 */

/**
 * Renders the `premium/form-textarea` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_form_textarea( $attributes, $content, $block ) {
  
  if ( (isset( $attributes["iconTypeSelect"] ) && $attributes["iconTypeSelect"] == "lottie")  || (isset($attributes['triggerSettings']) && $attributes['triggerSettings'][0]['triggerType'] =='lottie')) {
    wp_enqueue_script(
      'pbg-lottie',
      PREMIUM_BLOCKS_URL . 'assets/js/lib/lottie.min.js',
      array( 'jquery' ),
      PREMIUM_BLOCKS_VERSION,
      true
    );
  }

	return $content;
}


/**
 * Register the form_textarea block.
 *
 * @uses render_block_pbg_form_textarea()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_form_textarea() {
	register_block_type(
		'premium/form-textarea',
		array(
			'render_callback' => 'render_block_pbg_form_textarea',
			'editor_style'    => 'premium-blocks-editor-css',
			'editor_script'   => 'pbg-blocks-js',
		)
	);
}

register_block_pbg_form_textarea();
