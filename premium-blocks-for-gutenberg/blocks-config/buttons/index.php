<?php

/**
 * Server-side rendering of the `pbg/button-group` block.
 *
 * @package WordPress
 */

/**
 * Get Button Group Block CSS
 *
 * Return Frontend CSS for Button Group.
 *
 * @access public
 *
 * @param string $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_button_group_css_style($attr, $unique_id)
{
    $css = new Premium_Blocks_css();

    // Responsive styles — Desktop, Tablet, and Mobile handled in a single pass.
    $css->render_responsive(function ($css, $device) use ($attr, $unique_id) {
        $css->set_selector($unique_id);
        $css->pbg_render_value($attr, 'align', 'text-align', $device);

        $css->set_selector($unique_id . '.wp-block-premium-buttons .premium-button-group_wrap');
        $css->pbg_render_range($attr, 'buttonGap', 'column-gap', $device, null, '!important');
        $css->pbg_render_range($attr, 'buttonGap', 'row-gap', $device, null, '!important');
        $css->pbg_render_spacing($attr, 'groupMargin', 'margin', $device);
        $flex_direction = $css->pbg_get_value($attr, 'groupAlign', $device);
        if ($flex_direction) {
            if ($flex_direction === 'horizontal') {
                $css->add_property('flex-direction', 'row');
                $css->pbg_render_align_self($attr, 'align', 'justify-content', $device);
            } else {
                $css->add_property('flex-direction', 'column');
                $css->pbg_render_align_self($attr, 'align', 'align-items', $device);
            }
        }

        $css->set_selector($unique_id . ' .premium-button .premium-button-text-edit');
        $css->pbg_render_typography($attr, 'typography', $device);

        $css->set_selector($unique_id . ' .premium-button');
        $css->pbg_render_spacing($attr, 'groupPadding', 'padding', $device);
    });

    return $css->css_output();
}

/**
 * Renders the `premium/button` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_button_group($attributes, $content, $block)
{
    return $content;
}




/**
 * Register the button block.
 *
 * @uses render_block_pbg_button_group()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_button_group()
{
    if (! function_exists('register_block_type')) {
        return;
    }
    register_block_type(
        PREMIUM_BLOCKS_PATH . '/blocks-config/buttons',
        array(
            'render_callback' => 'render_block_pbg_button_group',
        )
    );
}

register_block_pbg_button_group();
