<?php


/**
 * Renders the `premium/image` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_tab_item( $attributes, $content, $block ) {

	return $content;
}

/**
 * Register the tab item block.
 *
 * @uses render_block_pbg_tab_item()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_tab_item() {
	register_block_type(
		PREMIUM_BLOCKS_PATH . '/blocks-config/tab-item',
		array(
			'render_callback' => 'render_block_pbg_tab_item',
			'editor_style'    => 'premium-blocks-editor-css',
			'editor_script'   => 'pbg-blocks-js',
		)
	);
}

register_block_pbg_tab_item();
