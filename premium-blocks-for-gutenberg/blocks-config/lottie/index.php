<?php

/**
 * Server-side rendering of the `pbg/lottie` block.
 *
 * @package WordPress
 */

/**
 * Get Lottie Block CSS
 *
 * Return Frontend CSS for Lottie.
 *
 * @access public
 *
 * @param string $attributes Block attributes.
 * @param string $unique_id Block ID.
 */
function get_premium_lottie_css_style($attributes, $unique_id)
{
    $css = new Premium_Blocks_css();

    // Non-responsive: same value on all devices.
    $css->set_selector($unique_id . ' .premium-lottie-animation');
    $css->pbg_render_color($attributes, 'lottieStyles[0].backColor', 'background-color');
    $css->pbg_render_filters($attributes, 'filter');
    $css->pbg_render_value($attributes, 'rotate', 'transform', null, 'rotate(', 'deg) !important');

    $css->set_selector($unique_id . ' .premium-lottie-animation:hover');
    $css->pbg_render_color($attributes, 'lottieStyles[0].backHColor', 'background-color');
    $css->pbg_render_filters($attributes, 'filterHover');

    // Responsive: Desktop + Tablet + Mobile in one block.
    $css->render_responsive(function ($css, $device) use ($attributes, $unique_id) {
        $css->set_selector($unique_id);
        $css->pbg_render_value($attributes, 'lottieAlign', 'text-align', $device);

        $css->set_selector($unique_id . ' .premium-lottie-animation');
        $css->pbg_render_range($attributes, 'size', 'width', $device, '', '!important');
        $css->pbg_render_range($attributes, 'size', 'height', $device, '', '!important');
        $css->pbg_render_spacing($attributes, 'padding', 'padding', $device);
        $css->pbg_render_border($attributes, 'border', $device);

        $css->set_selector(":root:has({$unique_id}) {$unique_id}.wp-block-premium-lottie");
        $css->pbg_render_spacing($attributes, 'margin', 'margin', $device);
    });

    return $css->css_output();
}

/**
 * Renders the `premium/lottie` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_lottie($attributes, $content, $block)
{
    $block_helpers = pbg_blocks_helper();

    // Enqueue frontend JavaScript and CSS.
    if ($block_helpers->it_is_not_amp()) {
        wp_enqueue_script(
            'pbg-lottie',
            PREMIUM_BLOCKS_URL . 'assets/js/lib/lottie.min.js',
            array('jquery'),
            PREMIUM_BLOCKS_VERSION,
            true
        );
    }

    return $content;
}




/**
 * Register the lottie block.
 *
 * @uses render_block_pbg_lottie()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_lottie()
{
    if (! function_exists('register_block_type')) {
        return;
    }
    register_block_type(
        PREMIUM_BLOCKS_PATH . '/blocks-config/lottie',
        array(
            'render_callback' => 'render_block_pbg_lottie',
        )
    );
}

register_block_pbg_lottie();
