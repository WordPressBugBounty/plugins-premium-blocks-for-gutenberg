<?php

/**
 * Server-side rendering of the `premium/one-page-scroll` block.
 *
 * @package WordPress
 */
/**
 * Get Dynamic CSS.
 *
 * @param array  $attr
 * @param string $unique_id
 * @return string
 */
function get_premium_one_page_scroll_css($attr, $unique_id)
{
    $css = new Premium_Blocks_css();

    // Non-responsive styles (colors, shadows, active/hover states).

    // Tooltip (non-responsive)
    $css->set_selector(".{$unique_id} .pbg-one-page-scroll-dot__tooltip");
    $css->pbg_render_shadow($attr, 'tooltipShadow', 'box-shadow');
    $css->pbg_render_color($attr, 'tooltipColor', 'color');
    $css->pbg_render_color($attr, 'tooltipBackgroundColor', 'background-color');
    $css->pbg_render_color($attr, 'tooltipBackgroundColor', '--tooltip-arrow-color');

    // Dots (non-responsive)
    $css->set_selector(".{$unique_id} .pbg-one-page-scroll-dots");
    $css->pbg_render_color($attr, 'navigationBackgroundColor', 'background-color');
    $css->pbg_render_shadow($attr, 'navigationBoxShadow', 'box-shadow');

    $css->set_selector(".{$unique_id} .pbg-one-page-scroll-dots .pbg-one-page-scroll-dots-list .pbg-one-page-scroll-dot .pbg-one-page-scroll-dot__inner span");
    $css->pbg_render_color($attr, 'dotsColor', 'background-color');

    $css->set_selector(
        ".{$unique_id} .pbg-one-page-scroll-dots .pbg-one-page-scroll-dots-list .pbg-one-page-scroll-dot:hover .pbg-one-page-scroll-dot__inner span, " .
    ".{$unique_id} .pbg-one-page-scroll-dots .pbg-one-page-scroll-dots-list .pbg-one-page-scroll-dot.active .pbg-one-page-scroll-dot__inner span"
    );
    $css->pbg_render_color($attr, 'dotsActiveColor', 'background-color');
    $css->pbg_render_color($attr, 'dotsBorderActiveColor', 'border-color');

    // Menu (non-responsive)
    $css->set_selector(".{$unique_id} .pbg-one-page-scroll-menu-list .pbg-one-page-scroll-menu-item");
    $css->pbg_render_color($attr, 'menuTextColor', 'color');
    $css->pbg_render_color($attr, 'menuBackgroundColor', 'background-color');
    $css->pbg_render_shadow($attr, 'menuBoxShadow', 'box-shadow');

    $css->set_selector(".{$unique_id} .pbg-one-page-scroll-menu-list .pbg-one-page-scroll-menu-item:not(.active):hover");
    $css->pbg_render_color($attr, 'menuTextHoverColor', 'color');
    $css->pbg_render_color($attr, 'menuBackgroundHoverColor', 'background-color');
    $css->pbg_render_color($attr, 'menuBorderHoverColor', 'border-color');
    $css->pbg_render_shadow($attr, 'menuHoverBoxShadow', 'box-shadow');

    $css->set_selector(".{$unique_id} .pbg-one-page-scroll-menu-list .pbg-one-page-scroll-menu-item.active");
    $css->pbg_render_color($attr, 'menuTextActiveColor', 'color');
    $css->pbg_render_color($attr, 'menuBackgroundActiveColor', 'background-color');
    $css->pbg_render_color($attr, 'menuBorderActiveColor', 'border-color');
    $css->pbg_render_shadow($attr, 'menuActiveBoxShadow', 'box-shadow');

    // Arrows (non-responsive)
    $css->set_selector(".{$unique_id} .pbg-one-page-scroll-arrows span svg");
    $css->pbg_render_color($attr, 'arrowsColor', 'color');
    $css->pbg_render_color($attr, 'arrowsColor', 'fill');

    $css->set_selector(".{$unique_id} .pbg-one-page-scroll-arrows span:hover svg");
    $css->pbg_render_color($attr, 'arrowsHoverColor', 'color');
    $css->pbg_render_color($attr, 'arrowsHoverColor', 'fill');

    $css->render_responsive(function ($css, $device) use ($attr, $unique_id) {
        // Tooltip.
        $css->set_selector(".{$unique_id} .pbg-one-page-scroll-dot__tooltip");
        $css->pbg_render_typography($attr, 'tooltipTypography', $device);
        $css->pbg_render_border($attr, 'tooltipBorder', $device);
        $css->pbg_render_spacing($attr, 'tooltipPadding', 'padding', $device);
        $css->pbg_render_spacing($attr, 'tooltipMargin', 'margin', $device);

        // Dots.
        $css->set_selector(".{$unique_id} .pbg-one-page-scroll-dots .pbg-one-page-scroll-dots-list");
        $css->pbg_render_range($attr, 'dotsSpacing', 'gap', $device);

        $css->set_selector(".{$unique_id} .pbg-one-page-scroll-dots");
        $css->pbg_render_border($attr, 'navigationBorder', $device);
        $css->pbg_render_spacing($attr, 'navigationPadding', 'padding', $device);
        $css->pbg_render_spacing($attr, 'navigationMargin', 'margin', $device);

        // Start of circles and lines styling
        $css->set_selector(".{$unique_id} .pbg-one-page-scroll-dots.circle .pbg-one-page-scroll-dots-list .pbg-one-page-scroll-dot");
        $css->pbg_render_range($attr, 'dotsSize', 'width', $device);
        $css->pbg_render_range($attr, 'dotsSize', 'height', $device);

        $css->set_selector(".{$unique_id} .pbg-one-page-scroll-dots.lines .pbg-one-page-scroll-dots-list .pbg-one-page-scroll-dot");
        $css->pbg_render_range($attr, 'linesWidth', 'width', $device);
        $css->pbg_render_range($attr, 'linesHeight', 'height', $device);

        $css->set_selector(".{$unique_id} .pbg-one-page-scroll-dots .pbg-one-page-scroll-dots-list .pbg-one-page-scroll-dot .pbg-one-page-scroll-dot__inner span");
        $css->pbg_render_border($attr, 'dotsBorder', $device);
        // End of circles and lines styling

        // Menu.
        $css->set_selector(".{$unique_id} .pbg-one-page-scroll-menu-list .pbg-one-page-scroll-menu-item");
        $css->pbg_render_typography($attr, 'menuTypography', $device);
        $css->pbg_render_border($attr, 'menuBorder', $device);
        $css->pbg_render_spacing($attr, 'menuPadding', 'padding', $device);
        $css->pbg_render_spacing($attr, 'menuMargin', 'margin', $device);

        $css->set_selector(".{$unique_id} .pbg-one-page-scroll-menu-list");
        $css->pbg_render_range($attr, 'menuVerticalOffset', 'top', $device);
        $menu_position = $css->pbg_get_value($attr, 'menuPosition');
        if ($menu_position === 'right') {
            $css->pbg_render_range($attr, 'menuHorizontalOffset', 'right', $device);
        }
        if ($menu_position === 'left') {
            $css->pbg_render_range($attr, 'menuHorizontalOffset', 'left', $device);
        }

        // Arrows
        $arrows_position = $css->pbg_get_value($attr, 'arrowsPosition');
        if ($arrows_position && $arrows_position !== 'center') {
            $css->set_selector(".{$unique_id} .pbg-one-page-scroll-arrows span");
            if ($arrows_position === 'left') {
                $css->pbg_render_range($attr, 'arrowsHorizontalOffset', 'left', $device);
            } else {
                $css->pbg_render_range($attr, 'arrowsHorizontalOffset', 'right', $device);
            }
        }

        $css->set_selector(".{$unique_id} .pbg-one-page-scroll-arrows .arrow-top");
        $css->pbg_render_range($attr, 'arrowsVerticalOffset', 'top', $device);

        $css->set_selector(".{$unique_id} .pbg-one-page-scroll-arrows .arrow-bottom");
        $css->pbg_render_range($attr, 'arrowsVerticalOffset', 'bottom', $device);

        $css->set_selector(".{$unique_id} .pbg-one-page-scroll-arrows span svg");
        $css->pbg_render_range($attr, 'arrowsSize', 'width', $device);
        $css->pbg_render_range($attr, 'arrowsSize', 'height', $device);
    });

    return $css->css_output();
}

/**
 * Get Media Css.
 *
 * @return array
 */
function get_premium_one_page_scroll_media_css()
{
    $media_css = array('desktop' => '', 'tablet' => '', 'mobile' => '');

    $media_css['desktop'] .= "
    .dots-hidden-desktop,
    .menu-hidden-desktop,
    .arrows-hidden-desktop {
        display: none !important;
    }
  ";

    $media_css['tablet'] .= "
    .dots-hidden-tablet,
    .menu-hidden-tablet,
    .arrows-hidden-tablet {
        display: none !important;
    }
  ";

    $media_css['mobile'] .= "
    .dots-hidden-mobile,
    .menu-hidden-mobile,
    .arrows-hidden-mobile {
        display: none !important;
    }
  ";

    return $media_css;
}

/**
 * Render one page scroll block.
 *
 * @param array  $attributes The block attributes.
 * @param string $content The block content.
 * @return string
 */
function render_block_pbg_one_page_scroll($attributes, $content)
{
    wp_enqueue_script(
        'pbg-smoothscroll',
        PREMIUM_BLOCKS_URL . 'assets/js/lib/smoothscroll.min.js',
        array(),
        PREMIUM_BLOCKS_VERSION,
        true
    );

    wp_enqueue_script(
        'pbg-one-page-scroll',
        PREMIUM_BLOCKS_URL . 'assets/js/minified/one-page-scroll.min.js',
        array('pbg-smoothscroll'),
        PREMIUM_BLOCKS_VERSION,
        true
    );

    add_filter(
        'premium_one_page_scroll_localize_script',
        function ($data) use ($attributes) {
            $allowed_attributes = array(
              'scrollSpeed',
              'scrollOffset',
              'scrollEffect',
              'enableDotsTooltip',
              'showTooltipOnScroll',
              'navDots',
              'fullSectionScroll',
              'saveToBrowser',
              'enableFitToScreen'
            );

            $filtered_attributes = array_intersect_key($attributes, array_flip($allowed_attributes));

            $data['blocks'][$attributes['blockId']] = array(
              'attributes' => $filtered_attributes,
            );
            return $data;
        }
    );

    $data = apply_filters('premium_one_page_scroll_localize_script', array());

    wp_scripts()->add_data('pbg-one-page-scroll', 'before', array());

    wp_add_inline_script(
        'pbg-one-page-scroll',
        'var PBG_OnePageScroll = ' . wp_json_encode($data) . ';',
        'before'
    );

    if (isset($attributes['navigationEntranceAnimation']) && $attributes['navigationEntranceAnimation'] !== "none") {
        if (!wp_style_is('pbg-entrance-animation-css', 'enqueued')) {
            wp_enqueue_style(
                'pbg-entrance-animation-css',
                PREMIUM_BLOCKS_URL . 'assets/js/build/entrance-animation/editor/index.css',
                array(),
                PREMIUM_BLOCKS_VERSION,
                'all'
            );
        }
    }

    return $content;
}

/**
 * Register the Instagram Feed block.
 *
 * @uses render_block_pbg_one_page_scroll()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_one_page_scroll()
{
    if (! function_exists('register_block_type')) {
        return;
    }

    register_block_type(
        PREMIUM_BLOCKS_PATH . 'blocks-config/one-page-scroll',
        array(
            'render_callback' => 'render_block_pbg_one_page_scroll',
        )
    );
}

register_block_pbg_one_page_scroll();
