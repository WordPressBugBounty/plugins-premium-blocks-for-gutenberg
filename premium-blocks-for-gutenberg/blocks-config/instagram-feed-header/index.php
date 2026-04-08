<?php

/**
 * Server-side rendering of the `premium/instagram-feed-header` block.
 *
 * @package WordPress
 */

/**
 * Get CSS styles for Instagram Feed Header block.
 *
 * @param array  $attributes Block attributes.
 * @param string $unique_id  Unique block ID.
 * @return string Generated CSS.
 */
function get_premium_instagram_feed_header_css($attributes, $unique_id)
{
    $css = new Premium_Blocks_css();

    $css->pbg_render_shadow($attributes, 'boxShadow', 'box-shadow');

    $css->render_responsive(function ($css, $device) use ($attributes, $unique_id) {
        $css->set_selector('.' . $unique_id);
        $css->pbg_render_background($attributes, 'background', $device);
        $css->pbg_render_border($attributes, 'border', $device);
        $css->pbg_render_spacing($attributes, 'padding', 'padding', $device);
        $css->pbg_render_spacing($attributes, 'margin', 'margin', $device);
    });

    return $css->css_output();
}

/**
 * Renders the `premium/instagram-feed-header` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_instagram_feed_header($attributes, $content, $block)
{
    if (strpos($content, 'cdninstagram.com') !== false || strpos($content, 'instagram.com') !== false) {
        if (strpos($content, 'no-optimole') === false) {
            $content = preg_replace_callback(
                '/<img ([^>]+)>/i',
                function ($matches) {
                    $attrs = $matches[1];
                    if (strpos($attrs, 'cdninstagram.com') !== false || strpos($attrs, 'instagram.com') !== false) {
                        if (strpos($attrs, 'no-optimole') === false) {
                            if (preg_match('/class=["\']([^"\']+)["\']/i', $attrs, $class_matches)) {
                                $attrs = str_replace($class_matches[0], 'class="' . $class_matches[1] . ' no-optimole"', $attrs);
                            } else {
                                $attrs .= ' class="no-optimole"';
                            }
                            $attrs .= ' data-no-lazy="1" data-opt-lazy-loaded="true" data-opt-optimize="0" data-opt-src=""';
                        }
                    }
                    return '<img ' . $attrs . '>';
                },
                $content
            );
        }
    }
    return $content;
}


/**
 * Register the Instagram Feed Header block.
 *
 * @uses render_block_pbg_instagram_feed_header()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_instagram_feed_header()
{
    register_block_type(
        PREMIUM_BLOCKS_PATH . 'blocks-config/instagram-feed-header',
        array(
            'render_callback' => 'render_block_pbg_instagram_feed_header',
        )
    );
}

register_block_pbg_instagram_feed_header();
