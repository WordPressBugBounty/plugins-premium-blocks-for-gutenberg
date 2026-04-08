<?php

/**
 * Server-side rendering of the `pbg/svg-draw` block.
 *
 * @package WordPress
 */

/**
 * Get SVG Draw Block CSS
 *
 * Return Frontend CSS for SVG Draw.
 *
 * @access public
 *
 * @param array  $attr      Block attributes.
 * @param string $unique_id Block ID.
 *
 * @return string Generated CSS.
 */
function get_premium_svg_draw_css_style($attr, $unique_id)
{
    $css = new Premium_Blocks_css();

    // Desktop Styles.

    // Container Styles
    $css->set_selector('.' . $unique_id . ' .premium-icon-container');
    $css->pbg_render_shadow($attr, 'containerShadow', 'box-shadow');

    // svg styles (non-responsive colors)
    $css->set_selector(
        ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-type, " .
    ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-type:not(.icon-type-fe) svg, " .
    ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-type:not(.icon-type-fe) svg *, " .
    ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-svg-class svg, " .
    ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-svg-class svg *"
    );
    $css->pbg_render_color($attr, 'iconColor', 'color');
    $css->pbg_render_color($attr, 'iconColor', 'fill');

    $css->set_selector(
        ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-type:hover, " .
    ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-type:not(.icon-type-fe):hover svg *, " .
    ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-svg-class:hover svg, " .
    ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-svg-class:hover svg *"
    );
    $css->pbg_render_color($attr, 'iconHoverColor', 'color');
    $css->pbg_render_color($attr, 'iconHoverColor', 'fill');

    $css->set_selector(
        ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-type:hover, " .
    ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-svg-class:hover svg"
    );
    $css->pbg_render_color($attr, 'borderHoverColor', 'border-color');

    $css->set_selector(".{$unique_id} svg *");
    $css->pbg_render_color($attr, 'svgDraw.strokeColor', 'stroke');

    $css->render_responsive(function ($css, $device) use ($attr, $unique_id) {
        // Container Styles
        $css->set_selector('.' . $unique_id . ' .premium-icon-container');
        $css->pbg_render_background($attr, 'containerBackground', $device);
        $css->pbg_render_border($attr, 'containerBorder', $device);
        $css->pbg_render_spacing($attr, 'wrapPadding', 'padding', $device);
        $css->pbg_render_spacing($attr, 'wrapMargin', 'margin', $device);
        $css->pbg_render_value($attr, 'iconAlign', 'text-align', $device);

        // icon Styles
        $css->set_selector(
            ".{$unique_id} > .premium-icon-container .premium-icon-content .premium-icon-type svg, " .
            ".{$unique_id} > .premium-icon-container .premium-icon-content .premium-icon-svg-class svg"
        );
        $css->pbg_render_range($attr, 'iconSize', 'width', $device, null, '!important');
        $css->pbg_render_range($attr, 'iconSize', 'height', $device, null, '!important');

        // common icon type style
        $css->set_selector(
            ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-type, " .
            ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-svg-class svg"
        );
        $css->pbg_render_border($attr, 'iconBorder', $device);
        $css->pbg_render_spacing($attr, 'iconPadding', 'padding', $device);
        $css->pbg_render_spacing($attr, 'iconMargin', 'margin', $device);

        $css->set_selector(
            ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-type, " .
            ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-svg-class svg"
        );
        $css->pbg_render_background($attr, 'iconBG', $device);

        $css->set_selector(
            ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-type:hover, " .
            ".{$unique_id} .premium-icon-container .premium-icon-content .premium-icon-svg-class:hover svg"
        );
        $css->pbg_render_background($attr, 'iconHoverBG', $device);

        $css->set_selector(".{$unique_id} svg *");
        $css->pbg_render_range($attr, 'svgDraw.strokeWidth', 'stroke-width', $device);
    });

    return $css->css_output();
}

/**
 * Renders the `premium/svg-draw` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_svg_draw($attributes, $content, $block)
{
    $block_helpers = pbg_blocks_helper();

    wp_register_script(
        'pbg-gsap-frontend-script',
        PREMIUM_BLOCKS_URL . 'assets/js/lib/gsap.min.js',
        array(),
        PREMIUM_BLOCKS_VERSION,
        true
    );

    wp_register_script(
        'pbg-scroll-trigger-frontend-script',
        PREMIUM_BLOCKS_URL . 'assets/js/lib/ScrollTrigger.min.js',
        array('pbg-gsap-frontend-script'),
        PREMIUM_BLOCKS_VERSION,
        true
    );

    wp_enqueue_script(
        'premium-svg-draw-view',
        PREMIUM_BLOCKS_URL . 'assets/js/build/svg-draw/index.js',
        array('pbg-gsap-frontend-script', 'pbg-scroll-trigger-frontend-script'),
        PREMIUM_BLOCKS_VERSION,
        true
    );

    // Add this block's settings to the accordion data.
    add_filter(
        'premium-svg-draw-localize-data',
        function ($data) use ($attributes) {
            $data[ $attributes['blockId'] ] = $attributes['svgDraw'] ?? array();
            return $data;
        }
    );

    $data = apply_filters('premium-svg-draw-localize-data', array());

    wp_scripts()->add_data('premium-svg-draw-view', 'before', array());

    wp_add_inline_script(
        'premium-svg-draw-view',
        'PBG_SvgDraw = ' . wp_json_encode($data) . ';',
        'before'
    );

    return $content;
}




/**
 * Register the svg draw block.
 *
 * @uses render_block_pbg_svg_draw()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_svg_draw()
{
    if (! function_exists('register_block_type')) {
        return;
    }
    register_block_type(
        PREMIUM_BLOCKS_PATH . '/blocks-config/svg-draw',
        array(
            'render_callback' => 'render_block_pbg_svg_draw',
        )
    );
}

register_block_pbg_svg_draw();
