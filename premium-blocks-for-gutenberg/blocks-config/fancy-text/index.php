<?php

/**
 * Server-side rendering of the `pbg/fancy-text` block.
 *
 * @package WordPress
 */

/**
 * Get Fancy Text Block CSS
 *
 * Return Frontend CSS for Fancy Text.
 *
 * @access public
 *
 * @param array $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_fancy_text_css_style($attr, $unique_id)
{
    $css = new Premium_Blocks_css();

    $css->set_selector(":root:has(.{$unique_id}) .{$unique_id}.wp-block-premium-fancy-text");
    $css->pbg_render_spacing($attr, 'fancyMargin', 'margin', 'Desktop');

    $css->set_selector(".{$unique_id}.wp-block-premium-fancy-text");
    $css->pbg_render_spacing($attr, 'fancyPadding', 'padding', 'Desktop', null, '!important');
    $css->pbg_render_value($attr, 'fancyContentAlign', 'text-align', 'Desktop');

    // FancyText Style
    $css->set_selector('.' . $unique_id . '> .premium-fancy-text > .premium-fancy-text-title-slide li, .' . $unique_id . ' > .premium-fancy-text  > .premium-fancy-text-title-type, .' . $unique_id . ' .premium-fancy-text .premium-fancy-text-title-highlighted');
    $css->pbg_render_typography($attr, 'fancyTextTypography', 'Desktop');

    $css->set_selector('.' . $unique_id . '> .premium-fancy-text > .typed-cursor');
    $css->pbg_render_range($attr, 'fancyTextTypography.fontSize', 'font-size', 'Desktop');
    // Desktop non-responsive color set later...

    // Suffix, Prefix Style
    $css->set_selector('.' . $unique_id . '> .premium-fancy-text' . '> .premium-fancy-text-suffix-prefix');
    $css->pbg_render_typography($attr, 'prefixTypography', 'Desktop');

    $css->set_selector('.' . $unique_id . '> .premium-fancy-text');
    $css->pbg_render_value($attr, 'fancyContentAlign', 'text-align', 'Desktop');

    $css->set_selector('.' . $unique_id . '> .premium-fancy-text' . '> .premium-fancy-text-title-slide');
    $css->pbg_render_value($attr, 'fancyTextAlign', 'text-align', 'Desktop');

    // Non-responsive color styles.
    $css->set_selector('.' . $unique_id . ' .premium-fancy-text .premium-fancy-text-type, .' . $unique_id . ' .premium-fancy-text .premium-fancy-text-title-slide');
    $css->pbg_render_color($attr, 'fancyStyles[0].fancyTextColor', 'color', null, '!important');
    $css->pbg_render_color($attr, 'fancyStyles[0].fancyTextBGColor', 'background-color', null, '!important');

    $css->set_selector('.' . $unique_id . ' .premium-fancy-text .premium-fancy-text-suffix-prefix');
    $css->pbg_render_color($attr, 'PreStyles[0].textColor', 'color', null, '!important');
    $css->pbg_render_color($attr, 'PreStyles[0].textBGColor', 'background-color', null, '!important');

    $css->set_selector('.' . $unique_id . ' .premium-fancy-text-highlighted .premium-fancy-text-title-highlighted svg path');
    $css->pbg_render_color($attr, 'highlightedShapeColor', 'stroke', null, '!important');

    $css->set_selector('.' . $unique_id . '> .premium-fancy-text > .typed-cursor');
    $css->pbg_render_color($attr, 'fancyStyles[0].cursorColor', 'color', null, '!important');

    $css->render_responsive(function ($css, $device) use ($attr, $unique_id) {
        $css->set_selector(":root:has(.{$unique_id}) .{$unique_id}.wp-block-premium-fancy-text");
        $css->pbg_render_spacing($attr, 'fancyMargin', 'margin', $device);

        $css->set_selector(".{$unique_id}.wp-block-premium-fancy-text");
        $css->pbg_render_spacing($attr, 'fancyPadding', 'padding', $device, null, '!important');
        $css->pbg_render_value($attr, 'fancyContentAlign', 'text-align', $device);

        $css->set_selector('.' . $unique_id . '> .premium-fancy-text > .premium-fancy-text-title-slide li, .' . $unique_id . ' > .premium-fancy-text  > .premium-fancy-text-title-type, .' . $unique_id . ' .premium-fancy-text .premium-fancy-text-title-highlighted');
        $css->pbg_render_typography($attr, 'fancyTextTypography', $device);

        $css->set_selector('.' . $unique_id . '> .premium-fancy-text > .typed-cursor');
        $css->pbg_render_range($attr, 'fancyTextTypography.fontSize', 'font-size', $device);

        $css->set_selector('.' . $unique_id . '> .premium-fancy-text > .premium-fancy-text-suffix-prefix');
        $css->pbg_render_typography($attr, 'prefixTypography', $device);

        $css->set_selector('.' . $unique_id . '> .premium-fancy-text');
        $css->pbg_render_value($attr, 'fancyContentAlign', 'text-align', $device);

        $css->set_selector('.' . $unique_id . '> .premium-fancy-text > .premium-fancy-text-title-slide');
        $css->pbg_render_value($attr, 'fancyTextAlign', 'text-align', $device);

        $css->set_selector('.' . $unique_id . ' .premium-fancy-text-highlighted .premium-fancy-text-title-highlighted svg path');
        $css->pbg_render_range($attr, 'highlightedShapeWidth', 'stroke-width', $device, null, '!important');
    });

    return $css->css_output();
}

/**
 * Renders the `premium/fancy-text` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_fancy_text($attributes, $content, $block)
{
    $block_helpers = pbg_blocks_helper();

    // Enqueue required styles and scripts.
    if ($block_helpers->it_is_not_amp()) {
        wp_enqueue_script(
            'pbg-typed',
            PREMIUM_BLOCKS_URL . 'assets/js/lib/typed.js',
            array( 'jquery' ),
            PREMIUM_BLOCKS_VERSION,
            true
        );

        wp_enqueue_script(
            'pbg-fancy-text',
            PREMIUM_BLOCKS_URL . 'assets/js/minified/fancy-text.min.js',
            array( 'jquery', 'pbg-typed' ),
            PREMIUM_BLOCKS_VERSION,
            true
        );

    }

    return $content;
}




/**
 * Register the fancy_text block.
 *
 * @uses render_block_pbg_fancy_text()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_fancy_text()
{
    if (! function_exists('register_block_type')) {
        return;
    }
    register_block_type(
        PREMIUM_BLOCKS_PATH . '/blocks-config/fancy-text',
        array(
            'render_callback' => 'render_block_pbg_fancy_text',
        )
    );
}

register_block_pbg_fancy_text();
