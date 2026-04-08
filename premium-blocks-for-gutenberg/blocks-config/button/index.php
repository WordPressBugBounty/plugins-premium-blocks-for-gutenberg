<?php

// Move this file to "blocks-config" folder with name "button.php".

/**
 * Server-side rendering of the `premium/button` block.
 *
 * @package WordPress
 */

function get_premium_button_css_style($attr, $unique_id)
{
    $css = new Premium_Blocks_css();

    // Non-responsive styles (color and shadow have no device parameter).
    $css->set_selector('.' . $unique_id . '.premium-button__wrap .premium-button');
    $css->pbg_render_shadow($attr, 'boxShadow', 'box-shadow');

    $css->set_selector('.' . $unique_id . ' .premium-button:hover');
    $css->pbg_render_shadow($attr, 'boxShadowHover', 'box-shadow');
    $css->pbg_render_color($attr, 'btnStyles[0].borderHoverColor', 'border-color', null, '!important');

    $css->set_selector('.' . $unique_id . ' .premium-button:hover .premium-button-text-edit');
    $css->pbg_render_color($attr, 'btnStyles[0].textHoverColor', 'color', null, '!important');

    $css->set_selector(
        ".{$unique_id} .premium-button .premium-button-icon, " .
        ".{$unique_id} .premium-button .premium-button-icon:not(.icon-type-fe) svg, " .
        ".{$unique_id} .premium-button .premium-button-icon:not(.icon-type-fe) svg *, " .
        ".{$unique_id} .premium-button .premium-button-svg-class svg, " .
        ".{$unique_id} .premium-button .premium-button-svg-class svg *"
    );
    $css->pbg_render_color($attr, 'btnStyles[0].textColor', 'color');
    $css->pbg_render_color($attr, 'btnStyles[0].textColor', 'fill');
    $css->pbg_render_color($attr, 'iconColor', 'color');
    $css->pbg_render_color($attr, 'iconColor', 'fill');

    $css->set_selector(
        ".{$unique_id} .premium-button:hover .premium-button-icon, " .
        ".{$unique_id} .premium-button:hover .premium-button-icon:not(.icon-type-fe) svg *, " .
        ".{$unique_id} .premium-button:hover .premium-button-svg-class svg, " .
        ".{$unique_id} .premium-button:hover .premium-button-svg-class svg *"
    );
    $css->pbg_render_color($attr, 'iconHoverColor', 'color');
    $css->pbg_render_color($attr, 'iconHoverColor', 'fill');

    $css->set_selector(
        ".{$unique_id} .premium-button:hover .premium-button-icon, " .
        ".{$unique_id} .premium-button:hover .premium-button-svg-class svg, " .
        ".{$unique_id} .premium-button:hover .premium-lottie-animation svg"
    );
    $css->pbg_render_color($attr, 'borderHoverColor', 'border-color');

    // Responsive styles — Desktop, Tablet, and Mobile handled in a single pass.
    $css->render_responsive(function ($css, $device) use ($attr, $unique_id) {
        // Button wrapper width and margin.
        $css->set_selector('.' . $unique_id);
        $css->pbg_render_value($attr, 'btnWidth', 'width', $device);
        $css->pbg_render_spacing($attr, 'margin', 'margin', $device);

        // Button text typography.
        $css->set_selector('.' . $unique_id . '.premium-button__wrap .premium-button .premium-button-text-edit');
        $css->pbg_render_typography($attr, 'typography', $device);

        // Button background, border, and padding.
        $css->set_selector('.' . $unique_id . '.premium-button__wrap .premium-button');
        $css->pbg_render_background($attr, 'backgroundOptions', $device);
        $css->pbg_render_border($attr, 'border', $device);
        $css->pbg_render_spacing($attr, 'padding', 'padding', $device);

        // Hover effect pseudo-element background.
        $css->set_selector(
            ".{$unique_id}.premium-button__slide .premium-button::before, " .
            ".{$unique_id}.premium-button__shutter .premium-button::before, " .
            ".{$unique_id}.premium-button__radial .premium-button::before"
        );
        $css->pbg_render_background($attr, 'backgroundHoverOptions', $device);

        $css->set_selector('.' . $unique_id . ' .premium-button:hover');
        $css->pbg_render_background($attr, 'backgroundHoverOptions', $device);

        // Icon SVG size.
        $css->set_selector(
            ".{$unique_id} .premium-button .premium-button-icon svg, " .
            ".{$unique_id} .premium-button .premium-button-svg-class svg"
        );
        $css->pbg_render_range($attr, 'iconSize', 'width', $device, null, '!important');
        $css->pbg_render_range($attr, 'iconSize', 'height', $device, null, '!important');

        $css->set_selector('.' . $unique_id . ' .premium-button img');
        $css->pbg_render_range($attr, 'imgWidth', 'width', $device, null, '!important');

        $css->set_selector('.' . $unique_id . ' .premium-button .premium-lottie-animation svg');
        $css->pbg_render_range($attr, 'imgWidth', 'width', $device, null, '!important');
        $css->pbg_render_range($attr, 'imgWidth', 'height', $device, null, '!important');

        // Icon hover background.
        $css->set_selector(
            ".{$unique_id} .premium-button:hover .premium-button-icon, " .
            ".{$unique_id} .premium-button:hover .premium-button-svg-class svg, " .
            ".{$unique_id} .premium-button:hover .premium-lottie-animation svg"
        );
        $css->pbg_render_background($attr, 'iconHoverBG', $device);

        // Icon normal background.
        $css->set_selector(
            ".{$unique_id} .premium-button .premium-button-icon, " .
            ".{$unique_id} .premium-button .premium-button-svg-class svg, " .
            ".{$unique_id} .premium-button .premium-lottie-animation svg"
        );
        $css->pbg_render_background($attr, 'iconBG', $device);

        // Icon border, padding, margin.
        $css->set_selector(
            ".{$unique_id} .premium-button .premium-button-icon, " .
            ".{$unique_id} .premium-button img, " .
            ".{$unique_id} .premium-button .premium-button-svg-class svg, " .
            ".{$unique_id} .premium-button .premium-lottie-animation svg"
        );
        $css->pbg_render_border($attr, 'iconBorder', $device);
        $css->pbg_render_spacing($attr, 'iconPadding', 'padding', $device);
        $css->pbg_render_spacing($attr, 'iconMargin', 'margin', $device);

        // Icon SVG background.
        $css->set_selector(
            ".{$unique_id} .premium-button .premium-button-icon svg, " .
            ".{$unique_id} .premium-button .premium-button-icon svg *"
        );
        $css->pbg_render_background($attr, 'iconBackground', $device);
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
function render_block_pbg_button($attributes, $content, $block)
{
    $block_helpers = pbg_blocks_helper();

    // Enqueue frontend JS/CSS.
    if ($block_helpers->it_is_not_amp()) {
        wp_enqueue_script(
            'pbg-button',
            PREMIUM_BLOCKS_URL . 'assets/js/minified/button.min.js',
            array(),
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
 * Register the button block.
 *
 * @uses render_block_pbg_button()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_button()
{
    register_block_type(
        'premium/button',
        array(
            'render_callback' => 'render_block_pbg_button',
            'editor_style'    => 'premium-blocks-editor-css',
            'editor_script'   => 'pbg-blocks-js',
        )
    );
}

register_block_pbg_button();
