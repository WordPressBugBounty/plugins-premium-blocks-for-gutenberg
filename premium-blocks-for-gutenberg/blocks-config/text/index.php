<?php

// Move this file to "blocks-config" folder with name "text.php".

/**
 * Server-side rendering of the `premium/text` block.
 *
 * @package WordPress
 */

function get_premium_text_css($attributes, $unique_id)
{
    $css = new Premium_Blocks_css();

    // Responsive styles — Desktop, Tablet, and Mobile handled in a single pass.
    $css->render_responsive(function ($css, $device) use ($attributes, $unique_id) {
        $css->set_selector(".{$unique_id}");
        $css->pbg_render_border($attributes, 'border', $device);
        $css->pbg_render_background($attributes, 'background', $device);
        $css->pbg_render_range($attributes, 'rotateText', 'transform', $device, 'rotate(', ')!important');

        $css->set_selector(".{$unique_id} .premium-text-wrap");
        $css->pbg_render_value($attributes, 'align', 'text-align', $device, null, '!important');
        $css->pbg_render_typography($attributes, 'typography', $device);

        $css->set_selector(":root:has(.{$unique_id}) .{$unique_id}.wp-block-premium-text");
        $css->pbg_render_spacing($attributes, 'margin', 'margin', $device);
        $css->pbg_render_spacing($attributes, 'padding', 'padding', $device, null, '!important');
    });

    // Non-responsive styles (color and shadow have no device parameter).
    $css->set_selector(".{$unique_id} .premium-text-wrap");
    $css->pbg_render_color($attributes, 'color', 'color');
    $css->pbg_render_shadow($attributes, 'textShadow', 'text-shadow');

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
function render_block_pbg_text($attributes, $content, $block)
{

    return $content;
}


/**
 * Register the Text block.
 *
 * @uses render_block_pbg_text()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_text()
{
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
