<?php

// Move this file to "blocks-config" folder with name "icon-group.php".

/**
 * Server-side rendering of the `premium/icon group` block.
 *
 * @package WordPress
 */

function get_premium_icon_group_css($attr, $unique_id)
{
    $block_helpers          = pbg_blocks_helper();
    $css                    = new Premium_Blocks_css();

    // Non-responsive color styles.
    $css->set_selector(
        ".{$unique_id} .premium-icon-container .premium-icon-type, " .
    ".{$unique_id} .premium-icon-container .premium-icon-type:not(.icon-type-fe) svg, " .
    ".{$unique_id} .premium-icon-container .premium-icon-type:not(.icon-type-fe) svg *, " .
    ".{$unique_id} .premium-icon-container .premium-icon-svg-class svg, " .
    ".{$unique_id} .premium-icon-container .premium-icon-svg-class svg *"
    );
    $css->pbg_render_color($attr, 'groupIconColor', 'color');
    $css->pbg_render_color($attr, 'groupIconColor', 'fill');

    $css->set_selector(
        ".{$unique_id} .premium-icon-container .premium-icon-type, " .
    ".{$unique_id} .premium-icon-container .premium-icon-svg-class svg, " .
    ".{$unique_id} .premium-icon-container .premium-lottie-animation svg"
    );
    $css->pbg_render_color($attr, 'groupIconBack', 'background-color');

    $css->set_selector(
        ".{$unique_id} .premium-icon-container .premium-icon-type:hover, " .
    ".{$unique_id} .premium-icon-container .premium-icon-type:not(.icon-type-fe):hover svg *, " .
    ".{$unique_id} .premium-icon-container .premium-icon-svg-class:hover svg, " .
    ".{$unique_id} .premium-icon-container .premium-icon-svg-class:hover svg *"
    );
    $css->pbg_render_color($attr, 'groupIconHoverColor', 'color');
    $css->pbg_render_color($attr, 'groupIconHoverColor', 'fill');

    $css->set_selector(
        ".{$unique_id} .premium-icon-container .premium-icon-type:hover, " .
    ".{$unique_id} .premium-icon-container .premium-icon-svg-class:hover svg, " .
    ".{$unique_id} .premium-icon-container .premium-lottie-animation:hover svg"
    );
    $css->pbg_render_color($attr, 'groupIconHoverBack', 'background-color');

    $css->render_responsive(function ($css, $device) use ($attr, $unique_id) {
        $css->set_selector('.' . $unique_id);
        $css->pbg_render_value($attr, 'align', 'text-align', $device);
        $css->pbg_render_align_self($attr, 'align', 'align-self', $device);

        $css->set_selector('.' . $unique_id . '.wp-block-premium-icon-group .premium-icon-group-horizontal');
        $css->pbg_render_align_self($attr, 'align', 'justify-content', $device);

        $css->set_selector('.' . $unique_id . '.wp-block-premium-icon-group .premium-icon-group-vertical');
        $css->pbg_render_align_self($attr, 'align', 'align-items', $device);

        $css->set_selector('.' . $unique_id . ' .premium-icon-group-container');
        $css->pbg_render_range($attr, 'iconsGap', 'gap', $device);

        $css->set_selector(
            ".{$unique_id} .premium-icon-container .premium-icon-type svg, " .
            ".{$unique_id} .premium-icon-container .premium-lottie-animation svg, " .
            ".{$unique_id} .premium-icon-container .premium-icon-svg-class svg"
        );
        $css->pbg_render_range($attr, 'iconsSize', 'width', $device, null, '!important');
        $css->pbg_render_range($attr, 'iconsSize', 'height', $device, null, '!important');

        $css->set_selector('.' . $unique_id . ' .premium-icon-container img');
        $css->pbg_render_range($attr, 'iconsSize', 'width', $device, null, '!important');

        $css->set_selector(
            ".{$unique_id} .premium-icon-container .premium-icon-type, " .
            ".{$unique_id} .premium-icon-container img, " .
            ".{$unique_id} .premium-icon-container .premium-icon-svg-class svg, " .
            ".{$unique_id} .premium-icon-container .premium-lottie-animation svg"
        );
        $css->pbg_render_border($attr, 'groupIconBorder', $device);
        $css->pbg_render_spacing($attr, 'groupIconPadding', 'padding', $device);
        $css->pbg_render_spacing($attr, 'groupIconMargin', 'margin', $device);
    });

    return $css->css_output();
}

/**
 * Renders the `premium/image` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_icon_group($attributes, $content, $block)
{

    return $content;
}


/**
 * Register the icon group block.
 *
 * @uses render_block_pbg_icon_group()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_icon_group()
{
    register_block_type(
        'premium/icon-group',
        array(
            'render_callback' => 'render_block_pbg_icon_group',
            'editor_style'    => 'premium-blocks-editor-css',
            'editor_script'   => 'pbg-blocks-js',
        )
    );
}

register_block_pbg_icon_group();
