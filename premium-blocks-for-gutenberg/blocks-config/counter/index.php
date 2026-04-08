<?php

/**
 * Server-side rendering of the `premium/counter` block.
 *
 * @package WordPress
 */

/**
 * Generate CSS for counter block.
 *
 * @param array  $attributes Block attributes.
 * @param string $unique_id  Unique block ID.
 * @return string Generated CSS.
 */
function get_premium_counter_css($attributes, $unique_id)
{
    $css = new Premium_Blocks_css();

    // Non-responsive color styles.
    $css->set_selector('.' . $unique_id . ' > .premium-countup__desc > .premium-countup__increment');
    $css->pbg_render_color($attributes, 'numberStyles[0].numberColor', 'color');

    $css->set_selector('.' . $unique_id . ' > .premium-countup__desc > .premium-countup__prefix');
    $css->pbg_render_color($attributes, 'prefixStyles[0].prefixColor', 'color');

    $css->set_selector('.' . $unique_id . ' > .premium-countup__desc > .premium-countup__suffix');
    $css->pbg_render_color($attributes, 'suffixStyles[0].suffixColor', 'color');

    $css->render_responsive(function ($css, $device) use ($attributes, $unique_id) {
        // Container alignment.
        $css->set_selector('.' . $unique_id);
        $css->pbg_render_align_self($attributes, 'align', 'justify-content', $device, '', $device === 'Desktop' ? '' : '!important');

        // Number styles.
        $css->set_selector('.' . $unique_id . ' > .premium-countup__desc > .premium-countup__increment');
        $css->pbg_render_typography($attributes, 'numberTypography', $device);
        $css->pbg_render_spacing($attributes, 'numberMargin', 'margin', $device);
        $css->pbg_render_spacing($attributes, 'numberPadding', 'padding', $device);

        // Prefix styles.
        $css->set_selector('.' . $unique_id . ' > .premium-countup__desc > .premium-countup__prefix');
        $css->pbg_render_typography($attributes, 'prefixTypography', $device);
        $css->pbg_render_spacing($attributes, 'prefixMargin', 'margin', $device);
        $css->pbg_render_spacing($attributes, 'prefixPadding', 'padding', $device);

        // Suffix styles.
        $css->set_selector('.' . $unique_id . ' > .premium-countup__desc > .premium-countup__suffix');
        $css->pbg_render_typography($attributes, 'suffixTypography', $device);
        $css->pbg_render_spacing($attributes, 'suffixMargin', 'margin', $device);
        $css->pbg_render_spacing($attributes, 'suffixPadding', 'padding', $device);
    });

    return $css->css_output();
}

/**
 * Renders the `premium/counter` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_counter($attributes, $content, $block)
{

    return $content;
}


/**
 * Register the Price block.
 *
 * @uses render_block_pbg_counter()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_counter()
{
    register_block_type(
        'premium/counter',
        array(
            'render_callback' => 'render_block_pbg_counter',
            'editor_style'    => 'premium-blocks-editor-css',
            'editor_script'   => 'pbg-blocks-js',
        )
    );
}

register_block_pbg_counter();
