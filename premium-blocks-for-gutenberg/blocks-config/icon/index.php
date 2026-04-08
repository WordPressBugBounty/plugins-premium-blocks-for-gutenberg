<?php

/**
 * Server-side rendering of the `pbg/icon` block.
 *
 * @package WordPress
 */

/**
 * Get Icon Block CSS
 *
 * Return Frontend CSS for Icon.
 *
 * @access public
 *
 * @param string $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_icon_css_style($attr, $unique_id)
{
    $css = new Premium_Blocks_css();

    // Responsive styles — Desktop, Tablet, and Mobile handled in a single pass.
    $css->render_responsive(function ($css, $device) use ($attr, $unique_id) {
        // Container Styles
        $css->set_selector('.' . $unique_id . '.wp-block-premium-icon .premium-icon-container');
        $css->pbg_render_background($attr, 'containerBackground', $device);
        $css->pbg_render_border($attr, 'containerBorder', $device);
        $css->pbg_render_spacing($attr, 'wrapPadding', 'padding', $device);
        $css->pbg_render_spacing($attr, 'wrapMargin', 'margin', $device);
        $css->pbg_render_value($attr, 'iconAlign', 'text-align', $device);

        // Icon SVG size
        $css->set_selector(
            ".{$unique_id} > .premium-icon-container .premium-icon-content .premium-icon-type svg, " .
            ".{$unique_id} > .premium-icon-container .premium-icon-content .premium-icon-svg-class svg"
        );
        $css->pbg_render_range($attr, 'iconSize', 'width', $device, null, '!important');
        $css->pbg_render_range($attr, 'iconSize', 'height', $device, null, '!important');

        // Common icon type style
        $css->set_selector(
            ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-type, " .
            ".{$unique_id} .premium-icon-container .premium-icon-content img, " .
            ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-svg-class svg, " .
            ".{$unique_id} .premium-icon-container .premium-icon-content .premium-lottie-animation svg"
        );
        $css->pbg_render_border($attr, 'iconBorder', $device);
        $css->pbg_render_spacing($attr, 'iconPadding', 'padding', $device);
        $css->pbg_render_spacing($attr, 'iconMargin', 'margin', $device);

        // Image style
        $css->set_selector('.' . $unique_id . ' .premium-icon-container .premium-icon-content img');
        $css->pbg_render_range($attr, 'imgWidth', 'width', $device, null, '!important');

        $css->set_selector('.' . $unique_id . ' .premium-icon-container .premium-icon-content .premium-lottie-animation svg');
        $css->pbg_render_range($attr, 'imgWidth', 'width', $device, null, '!important');
        $css->pbg_render_range($attr, 'imgWidth', 'height', $device, null, '!important');

        // Icon background
        $css->set_selector(
            ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-type, " .
            ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-svg-class svg, " .
            ".{$unique_id} .premium-icon-container .premium-icon-content .premium-lottie-animation svg"
        );
        $css->pbg_render_background($attr, 'iconBG', $device);

        // Hover background
        $css->set_selector(
            ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-type:hover, " .
            ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-svg-class:hover svg, " .
            ".{$unique_id} .premium-icon-container .premium-icon-content .premium-lottie-animation:hover svg"
        );
        $css->pbg_render_background($attr, 'iconHoverBG', $device);
    });

    // Non-responsive styles (colors and shadow do not vary per device).
    $css->set_selector('.' . $unique_id . '.wp-block-premium-icon .premium-icon-container');
    $css->pbg_render_shadow($attr, 'containerShadow', 'box-shadow');

    // SVG / font-icon color
    $css->set_selector(
        ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-type, " .
        ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-type:not(.icon-type-fe) svg, " .
        ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-type:not(.icon-type-fe) svg *, " .
        ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-svg-class svg, " .
        ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-svg-class svg *"
    );
    $css->pbg_render_color($attr, 'iconColor', 'color');
    $css->pbg_render_color($attr, 'iconColor', 'fill');

    // Hover color
    $css->set_selector(
        ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-type:hover, " .
        ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-type:not(.icon-type-fe):hover svg *, " .
        ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-svg-class:hover svg, " .
        ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-svg-class:hover svg *"
    );
    $css->pbg_render_color($attr, 'iconHoverColor', 'color');
    $css->pbg_render_color($attr, 'iconHoverColor', 'fill');

    // Hover border color
    $css->set_selector(
        ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-type:hover, " .
        ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-svg-class:hover svg, " .
        ".{$unique_id} .premium-icon-container .premium-icon-content .premium-lottie-animation:hover svg"
    );
    $css->pbg_render_color($attr, 'borderHoverColor', 'border-color');

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
function render_block_pbg_icon($attributes, $content, $block)
{
    $block_helpers = pbg_blocks_helper();

    // Enqueue frontend JS/CSS.
    if ($block_helpers->it_is_not_amp()) {
        wp_enqueue_script(
            'pbg-icon',
            PREMIUM_BLOCKS_URL . 'assets/js/minified/icon.min.js',
            array('jquery'),
            PREMIUM_BLOCKS_VERSION,
            true
        );
    }

    if ($block_helpers->it_is_not_amp()) {
        if (isset($attributes['iconTypeSelect']) && $attributes['iconTypeSelect'] == 'lottie') {
            wp_enqueue_script(
                'pbg-lottie',
                PREMIUM_BLOCKS_URL . 'assets/js/lib/lottie.min.js',
                array('jquery'),
                PREMIUM_BLOCKS_VERSION,
                true
            );
        }
    }

    /*
    Handling new feature of WordPress 6.7.2 --> sizes='auto' for old versions that doesn't contain wp-image-{$id} class.
    This workaround can be omitted after a few subsequent releases around 25/3/2025
  */
    if (isset($attributes['iconTypeSelect']) && $attributes['iconTypeSelect'] == 'img') {
        if (empty($attributes['imageURL']) || false === stripos($content, '<img')) {
            return $content;
        }

        $image_id = attachment_url_to_postid($attributes['imageURL']);

        if (!$image_id) {
            return $content;
        }

        $image_tag = new WP_HTML_Tag_Processor($content);

        // Find our specific image
        if (!$image_tag->next_tag(['tag_name' => 'img'])) {
            return $content;
        }

        $image_classnames = $image_tag->get_attribute('class') ?? '';

        // Only process if wp-image class is missing
        if (!str_contains($image_classnames, "wp-image-{$image_id}")) {
            // Clean up
            $image_tag->remove_attribute('srcset');
            $image_tag->remove_attribute('sizes');
            $image_tag->remove_class('wp-image-undefined');

            // Add the wp-image class for automatically generate new srcset and sizes attributes
            $image_tag->add_class("wp-image-{$image_id}");
        }

        return $image_tag->get_updated_html();
    }

    return $content;
}




/**
 * Register the icon block.
 *
 * @uses render_block_pbg_icon()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_icon()
{
    if (! function_exists('register_block_type')) {
        return;
    }
    register_block_type(
        PREMIUM_BLOCKS_PATH . '/blocks-config/icon',
        array(
            'render_callback' => 'render_block_pbg_icon',
        )
    );
}

register_block_pbg_icon();
