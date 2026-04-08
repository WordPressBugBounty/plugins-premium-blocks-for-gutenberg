<?php

/**
 * Server-side rendering of the `pbg/icon` block.
 *
 * @package WordPress
 */

/**
 * Get Star Ratings Block CSS
 *
 * Return Frontend CSS for Star Ratings.
 *
 * @access public
 *
 * @param array  $attr       Option attribute.
 * @param string $unique_id  Option for block ID.
 */
function get_premium_star_ratings_css($attr, $unique_id)
{
    $css = new Premium_Blocks_css();

    // Non-responsive colors
    $css->set_selector('.' . $unique_id . ' .premium-star-ratings-container .premium-star-ratings-title');
    $css->pbg_render_color($attr, 'textColor', 'color');

    $css->set_selector(".{$unique_id} .premium-star-ratings-container .premium-star-ratings-icons .premium-star-ratings-filled, " .
    ".{$unique_id} .premium-star-ratings-container .premium-star-ratings-icons .premium-star-ratings-filled svg *");
    $css->pbg_render_color($attr, 'rateColor', 'color', null, '!important');
    $css->pbg_render_color($attr, 'rateColor', 'fill', null, '!important');

    $css->set_selector(".{$unique_id} .premium-star-ratings-container .premium-star-ratings-icons .premium-star-ratings-empty, " .
    ".{$unique_id} .premium-star-ratings-container .premium-star-ratings-icons .premium-star-ratings-empty svg *");
    $css->pbg_render_color($attr, 'unmarkedColor', 'color', null, '!important');
    $css->pbg_render_color($attr, 'unmarkedColor', 'fill', null, '!important');

    $css->render_responsive(function ($css, $device) use ($attr, $unique_id) {
        // Text alignment
        $css->set_selector('.' . $unique_id);
        $css->pbg_render_value($attr, 'rateAlign', 'text-align', $device);

        // Container flex-direction and gap
        $css->set_selector('.' . $unique_id . ' .premium-star-ratings-container');
        $css->pbg_render_range($attr, 'titleGap', 'gap', $device);

        // Handle ratePosition for flex-direction
        if (isset($attr['ratePosition'])) {
            $rate_position  = isset($attr['ratePosition'][ $device ]) ? $attr['ratePosition'][ $device ] : 'right';
            $flex_direction = 'row';
            if ($rate_position === 'top') {
                $flex_direction = 'column-reverse';
            } elseif ($rate_position === 'bottom') {
                $flex_direction = 'column';
            } elseif ($rate_position === 'left') {
                $flex_direction = 'row-reverse';
            }

            $css->set_selector('.' . $unique_id . ' .premium-star-ratings-container');
            $css->add_property('flex-direction', $flex_direction);
            $css->pbg_render_align_self($attr, 'rateAlign', 'align-items', $device);
            $css->add_property('align-items', ($rate_position === 'left' || $rate_position === 'right') ? 'center' : ($device === 'Mobile' ? $attr['rateAlign']['Mobile'] : ''));
        }

        $css->set_selector('.' . $unique_id . ' .premium-star-ratings-container .premium-star-ratings-icons');
        $css->pbg_render_range($attr, 'rateGap', 'gap', $device, null, '!important');

        $css->set_selector('.' . $unique_id . ' .premium-star-ratings-container .premium-star-ratings-title');
        $css->pbg_render_typography($attr, 'typography', $device);

        $css->set_selector(
            ".{$unique_id} .premium-star-ratings-container .premium-star-ratings-icons .premium-icon-star-ratings, " .
            ".{$unique_id} .premium-star-ratings-container .premium-star-ratings-icons svg"
        );
        $css->pbg_render_range($attr, 'rateSize', 'width', $device, null, '!important');
        $css->pbg_render_range($attr, 'rateSize', 'height', $device, null, '!important');
    });

    return $css->css_output();
}
/**
 * Renders the `premium/icon` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_star_ratings($attributes, $content, $block)
{
    $block_helpers = pbg_blocks_helper();

    // Enqueue frontend JS/CSS.
    if ($block_helpers->it_is_not_amp()) {
        wp_enqueue_script(
            'pbg-star-ratings',
            PREMIUM_BLOCKS_URL . 'assets/js/minified/star-ratings.min.js',
            array('jquery'),
            PREMIUM_BLOCKS_VERSION,
            true
        );
    }


    return $content;
}




/**
 * Register the icon block.
 *
 * @uses render_block_pbg_star_ratings()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_star_ratings()
{
    if (! function_exists('register_block_type')) {
        return;
    }
    register_block_type(
        PREMIUM_BLOCKS_PATH . '/blocks-config/star-ratings',
        array(
            'render_callback' => 'render_block_pbg_star_ratings',
        )
    );
}

register_block_pbg_star_ratings();
