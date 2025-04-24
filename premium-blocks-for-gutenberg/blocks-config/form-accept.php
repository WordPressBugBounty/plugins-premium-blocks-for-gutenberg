<?php
/**
 * Server-side rendering of the `premium/form-accept` block.
 *
 * @package WordPress
 */

/**
 * Renders the `premium/form-accept` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_form_accept( $attributes, $content, $block ) {

	return $content;
}


/**
 * Register the form_accept block.
 *
 * @uses render_block_pbg_form_accept()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_form_accept() {
	register_block_type(
		'premium/form-accept',
		array(
			'render_callback' => 'render_block_pbg_form_accept',
			'editor_style'    => 'premium-blocks-editor-css',
			'editor_script'   => 'pbg-blocks-js',
		)
	);
}

register_block_pbg_form_accept();
