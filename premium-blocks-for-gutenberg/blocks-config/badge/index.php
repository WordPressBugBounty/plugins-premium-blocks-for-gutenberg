<?php

/**
 * Server-side rendering of the `premium/badge` block.
 *
 * @package WordPress
 */

function get_premium_badge_css($attributes, $unique_id)
{
    $css = new Premium_Blocks_css();

    $badge_position = $css->pbg_get_value($attributes, 'position');

    // Non-responsive styles (color and shadow have no device parameter).
    $css->set_selector(".{$unique_id}.premium-badge-circle .premium-badge-wrap, " . ".{$unique_id}.premium-badge-stripe .premium-badge-wrap, " . ".{$unique_id}.premium-badge-flag .premium-badge-wrap");
    $css->pbg_render_color($attributes, 'backgroundColor', 'background-color');
    $css->pbg_render_shadow($attributes, 'boxShadow', 'box-shadow');

    $css->set_selector(".{$unique_id}.premium-badge-flag.premium-badge-right .premium-badge-wrap:before");
    $css->pbg_render_color($attributes, 'backgroundColor', 'border-left-color');

    $css->set_selector(".{$unique_id}.premium-badge-flag.premium-badge-left .premium-badge-wrap:before");
    $css->pbg_render_color($attributes, 'backgroundColor', 'border-right-color');

    // Responsive styles — Desktop, Tablet, and Mobile handled in a single pass.
    $css->render_responsive(function ($css, $device) use ($attributes, $unique_id, $badge_position) {
        $css->set_selector(".{$unique_id} .premium-badge-wrap span");
        $css->pbg_render_typography($attributes, 'typography', $device);

        // Horizontal offset.
        $css->set_selector(
            ".{$unique_id}.premium-badge-triangle .premium-badge-wrap span, " .
            ".{$unique_id}.premium-badge-circle"
        );
        if ($badge_position) {
            if ($badge_position === 'left') {
                $css->pbg_render_range($attributes, 'hOffset', 'left', $device, null, '!important');
            } else {
                $css->pbg_render_range($attributes, 'hOffset', 'right', $device, null, '!important');
            }
        }

        // Vertical offset.
        $css->set_selector(
            ".{$unique_id}.premium-badge-triangle .premium-badge-wrap span, " .
            ".{$unique_id}.premium-badge-circle, " .
            ".{$unique_id}.premium-badge-flag"
        );
        $css->pbg_render_range($attributes, 'vOffset', 'top', $device, null, '!important');

        $css->set_selector(".{$unique_id}.premium-badge-triangle .premium-badge-wrap span");
        $css->pbg_render_range($attributes, 'textWidth', 'width', $device);

        // Triangle type.
        $css->set_selector(".{$unique_id}.premium-badge-triangle .premium-badge-wrap");
        $css->pbg_render_range($attributes, 'badgeSize', 'border-right-width', $device, null, '!important');
        if ($badge_position) {
            if ($badge_position === 'left') {
                $css->pbg_render_range($attributes, 'badgeSize', 'border-top-width', $device, null, '!important');
            } else {
                $css->pbg_render_range($attributes, 'badgeSize', 'border-bottom-width', $device, null, '!important');
            }
        }

        // Circle type.
        $css->set_selector(".{$unique_id}.premium-badge-circle .premium-badge-wrap");
        $css->pbg_render_range($attributes, 'badgeCircleSize', 'min-width', $device, null, '!important');
        $css->pbg_render_range($attributes, 'badgeCircleSize', 'min-height', $device, null, '!important');
        $css->pbg_render_range($attributes, 'badgeCircleSize', 'line-height', $device, null, '!important');
    });

    return $css->css_output();
}

/**
 * Renders the `premium/badge` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_badge($attributes, $content, $block)
{

    return $content;
}


/**
 * Register the Badge block.
 *
 * @uses render_block_pbg_badge()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_badge()
{
    register_block_type(
        'premium/badge',
        array(
            'render_callback' => 'render_block_pbg_badge',
            'editor_style'    => 'premium-blocks-editor-css',
            'editor_script'   => 'pbg-blocks-js',
        )
    );
}

register_block_pbg_badge();
