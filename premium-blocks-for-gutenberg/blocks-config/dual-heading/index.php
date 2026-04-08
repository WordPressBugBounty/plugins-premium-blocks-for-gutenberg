<?php

/**
 * Server-side rendering of the `pbg/dual-heading` block.
 *
 * @package WordPress
 */

/**
 * Get Dual Heading Block CSS
 *
 * Return Frontend CSS for Dual Heading.
 *
 * @access public
 *
 * @param array $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_dual_heading_css_style($attr, $unique_id)
{
    $css = new Premium_Blocks_css();

    $css->set_selector($unique_id);
    $css->pbg_render_value($attr, 'align', 'text-align', 'Desktop');
    $css->pbg_render_border($attr, 'containerBorder', 'Desktop');
    $css->pbg_render_background($attr, 'background', 'Desktop');
    $css->pbg_render_spacing($attr, 'padding', 'padding', 'Desktop');
    $css->pbg_render_range($attr, 'rotate', 'transform', 'Desktop', 'rotate(', ')');
    if (isset($attr['rotate']) && !empty($attr['rotate'])) {
        $css->add_property('transform-origin', ($attr['transform_origin_x'] ?? '') . ' ' . ($attr['transform_origin_y'] ?? ''));
    }

    // Non-responsive color/stroke styles.
    $css->set_selector($unique_id . '.premium-mask-yes .premium-dheading-block__title span::after');
    $css->pbg_render_color($attr, 'mask_color', 'background-color');

    $css->set_selector($unique_id . ' .premium-dheading-block__title .premium-headingc-true.premium-headings-true.premium-dheading-block__first');
    $css->pbg_render_color($attr, 'firstStrokeColor', '-webkit-text-stroke-color');
    $css->pbg_render_color($attr, 'firstStrokeFill', '-webkit-text-fill-color');

    $css->set_selector($unique_id . ' .premium-dheading-block__title .premium-headingc-true.premium-headinga-true.premium-dheading-block__first');
    $css->pbg_render_range($attr, 'firstStyles[0].firstAnimGradientSpeed', 'animation-duration', null, null, 's');

    $css->set_selector($unique_id . ' .premium-dheading-first-noise-true.premium-dheading-block__first:before');
    $css->pbg_render_range($attr, 'firstNoiseColor1', 'text-shadow', null, '1px 0');

    $css->set_selector($unique_id . ' .premium-dheading-first-noise-true.premium-dheading-block__first:after');
    $css->pbg_render_range($attr, 'firstNoiseColor2', 'text-shadow', null, '-1px 0');

    $css->set_selector($unique_id . ' .premium-dheading-block__title .premium-headingc-true.premium-headings-true.premium-dheading-block__second');
    $css->pbg_render_color($attr, 'secondStrokeColor', '-webkit-text-stroke-color');
    $css->pbg_render_color($attr, 'secondStrokeFill', '-webkit-text-fill-color');

    $css->set_selector($unique_id . ' .premium-dheading-block__title .premium-headingc-true.premium-headinga-true.premium-dheading-block__second');
    $css->pbg_render_range($attr, 'secondStyles[0].secondAnimGradientSpeed', 'animation-duration', null, null, 's');

    $css->set_selector($unique_id . ' .premium-dheading-second-noise-true.premium-dheading-block__second:before');
    $css->pbg_render_range($attr, 'secondNoiseColor1', 'text-shadow', null, '1px 0');

    $css->set_selector($unique_id . ' .premium-dheading-second-noise-true.premium-dheading-block__second:after');
    $css->pbg_render_range($attr, 'secondNoiseColor2', 'text-shadow', null, '-1px 0');

    $css->render_responsive(function ($css, $device) use ($attr, $unique_id) {
        $css->set_selector($unique_id);
        $css->pbg_render_value($attr, 'align', 'text-align', $device);
        $css->pbg_render_border($attr, 'containerBorder', $device);
        $css->pbg_render_background($attr, 'background', $device);
        $css->pbg_render_spacing($attr, 'padding', 'padding', $device);
        $css->pbg_render_range($attr, 'rotate', 'transform', $device, 'rotate(', ')');

        $css->set_selector("body .entry-content {$unique_id}.premium-dheading-block__container");
        $css->pbg_render_spacing($attr, 'margin', 'margin', $device);

        $css->set_selector($unique_id . ' .premium-mask-span');
        $css->pbg_render_spacing($attr, 'mask_padding', 'padding', $device);

        // First part.
        $css->set_selector($unique_id . '> .premium-dheading-block__wrap > .premium-dheading-block__title > .premium-dheading-block__first');
        $css->pbg_render_typography($attr, 'firstTypography', $device);
        $css->pbg_render_border($attr, 'firstBorder', $device);
        $css->pbg_render_spacing($attr, 'firstPadding', 'padding', $device);
        $css->pbg_render_spacing($attr, 'firstMargin', 'margin', $device);

        $css->set_selector($unique_id . ' .premium-dheading-block__wrap .premium-dheading-block__title .premium-dheading-block__first:not(.premium-headinga-true)');
        $css->pbg_render_background($attr, 'firstBackgroundOptions', $device);

        // Second part.
        $css->set_selector($unique_id . '> .premium-dheading-block__wrap > .premium-dheading-block__title > .premium-dheading-block__second');
        $css->pbg_render_typography($attr, 'secondTypography', $device);
        $css->pbg_render_border($attr, 'secondBorder', $device);
        $css->pbg_render_spacing($attr, 'secondPadding', 'padding', $device);
        $css->pbg_render_spacing($attr, 'secondMargin', 'margin', $device);

        $css->set_selector($unique_id . ' .premium-dheading-block__wrap .premium-dheading-block__title .premium-dheading-block__second:not(.premium-headinga-true)');
        $css->pbg_render_background($attr, 'secondBackgroundOptions', $device);
    });

    return $css->css_output();
}

/**
 * Renders the `premium/dual-heading` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_dual_heading($attributes, $content, $block)
{
    $block_helpers = pbg_blocks_helper();

    // Enqueue required styles and scripts.
    if ($block_helpers->it_is_not_amp()) {
        // Load Waypoints library
        wp_enqueue_script(
            'pbg-waypoints-heading',
            PREMIUM_BLOCKS_URL . 'assets/js/lib/jquery.waypoints.js',
            array( 'jquery' ),
            PREMIUM_BLOCKS_VERSION,
            true
        );

        // Load custom JavaScript without jQuery as a dependency
        wp_enqueue_script(
            'pbg-dual-heading',
            PREMIUM_BLOCKS_URL . 'assets/js/minified/dual-heading.min.js',
            array( 'pbg-waypoints-heading' ), // Remove 'jquery' from here
            PREMIUM_BLOCKS_VERSION,
            true
        );
    }

    return $content;
}





/**
 * Register the dual_heading block.
 *
 * @uses render_block_pbg_dual_heading()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_dual_heading()
{
    if (! function_exists('register_block_type')) {
        return;
    }
    register_block_type(
        PREMIUM_BLOCKS_PATH . '/blocks-config/dual-heading',
        array(
            'render_callback' => 'render_block_pbg_dual_heading',
        )
    );
}

register_block_pbg_dual_heading();
