<?php

/**
 * Server-side rendering of the `pbg/accordion` block.
 *
 * @package WordPress
 */

/**
 * Get Accordion Block CSS
 *
 * Return Frontend CSS for Accordion.
 *
 * @access public
 *
 * @param array  $attr      Block attributes.
 * @param string $unique_id Block ID.
 * @return string Generated CSS.
 */
function get_premium_accordion_css_style($attr, $unique_id)
{
    $css = new Premium_Blocks_css();

    // Non-responsive styles (color, shadow, and fixed-unit ranges have no device parameter).
    $css->set_selector(".{$unique_id} .premium-accordion__title_wrap");
    $css->pbg_render_color($attr, 'titleStyles[0].titleBack', 'background-color');

    $css->set_selector(".{$unique_id} .premium-accordion__title_wrap .premium-accordion__title_text");
    $css->pbg_render_color($attr, 'titleStyles[0].titleColor', 'color');
    $css->pbg_render_shadow($attr, 'titleTextShadow', 'text-shadow');

    $css->set_selector(".{$unique_id} .premium-accordion__title_wrap:hover");
    $css->pbg_render_color($attr, 'titleHoverBack', 'background-color');

    $css->set_selector(".{$unique_id} .premium-accordion__title_wrap:hover .premium-accordion__title_text");
    $css->pbg_render_color($attr, 'titleHoverColor', 'color');

    $css->set_selector(".{$unique_id} .is-active .premium-accordion__title_wrap");
    $css->pbg_render_color($attr, 'titleActiveBack', 'background-color');

    $css->set_selector(".{$unique_id} .is-active .premium-accordion__title_wrap .premium-accordion__title_text");
    $css->pbg_render_color($attr, 'titleActiveColor', 'color');

    // Arrow/Icon wrap - fixed-unit styles.
    $css->set_selector(".{$unique_id} .premium-accordion__title_wrap .premium-accordion__icon_wrap");
    $css->pbg_render_color($attr, 'arrowStyles[0].arrowBack', 'background-color');
    $css->pbg_render_range($attr, 'arrowStyles[0].arrowPadding', 'padding', '', '', 'px');
    $css->pbg_render_range($attr, 'arrowStyles[0].arrowRadius', 'border-radius', '', '', 'px');
    $css->pbg_render_color($attr, 'arrowStyles[0].arrowColor', 'fill');

    $css->set_selector(".{$unique_id} .premium-accordion__title_wrap .premium-accordion__icon_wrap svg.premium-accordion__icon");
    $css->pbg_render_range($attr, 'arrowStyles[0].arrowSize', 'width', '', '', 'px');
    $css->pbg_render_range($attr, 'arrowStyles[0].arrowSize', 'height', '', '', 'px');

    $css->set_selector(".{$unique_id} .premium-accordion__title_wrap:hover .premium-accordion__icon_wrap");
    $css->pbg_render_color($attr, 'arrowHoverColor', 'fill');
    $css->pbg_render_color($attr, 'arrowHoverBack', 'background-color');

    $css->set_selector(".{$unique_id} .is-active .premium-accordion__title_wrap .premium-accordion__icon_wrap");
    $css->pbg_render_color($attr, 'arrowActiveColor', 'fill');
    $css->pbg_render_color($attr, 'arrowActiveBack', 'background-color');

    $css->set_selector(".{$unique_id} .premium-accordion__desc_wrap");
    $css->pbg_render_color($attr, 'descStyles[0].descBack', 'background-color');
    $css->pbg_render_shadow($attr, 'textShadow', 'text-shadow');

    $css->set_selector(".{$unique_id} .premium-accordion__desc_wrap .premium-accordion__desc");
    $css->pbg_render_color($attr, 'descStyles[0].descColor', 'color');
    $css->pbg_render_shadow($attr, 'textShadow', 'text-shadow');

    // Responsive styles — Desktop, Tablet, and Mobile handled in a single pass.
    $css->render_responsive(function ($css, $device) use ($attr, $unique_id) {
        // Title wrap.
        $css->set_selector(".{$unique_id} .premium-accordion__title_wrap");
        $css->pbg_render_spacing($attr, 'titlePadding', 'padding', $device);
        $css->pbg_render_border($attr, 'titleBorder', $device);

        // Title text typography.
        $css->set_selector(".{$unique_id} .premium-accordion__title_wrap .premium-accordion__title_text");
        $css->pbg_render_typography($attr, 'titleTypography', $device);

        // Content wrap margin (note: :not(:last-child) only needed on desktop, content_wrap used for tablet/mobile parity).
        $css->set_selector(".{$unique_id} .premium-accordion__content_wrap");
        $css->pbg_render_range($attr, 'titleMargin', 'margin-bottom', $device, '', '!important');

        // Description wrap.
        $css->set_selector(".{$unique_id} .premium-accordion__desc_wrap");
        $css->pbg_render_spacing($attr, 'descPadding', 'padding', $device);
        $css->pbg_render_border($attr, 'descBorder', $device);
        $css->pbg_render_value($attr, 'descAlign', 'text-align', $device);

        // Description text typography.
        $css->set_selector(".{$unique_id} .premium-accordion__desc_wrap .premium-accordion__desc");
        $css->pbg_render_typography($attr, 'descTypography', $device);
    });

    return $css->css_output();
}

/**
 * Renders the `premium/accordion` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_accordion($attributes, $content, $block)
{
    $block_id          = $attributes['blockId'] ?? '';
    $collapse_others   = isset($attributes['collapseOthers']) ? $attributes['collapseOthers'] : false;
    $expand_first_item = isset($attributes['expandFirstItem']) ? $attributes['expandFirstItem'] : false;
    $block_helpers     = pbg_blocks_helper();

    if ($block_helpers->it_is_not_amp()) {
        // Enqueue script only once per page.
        if (! wp_script_is('pbg-accordion', 'enqueued')) {
            wp_enqueue_script(
                'pbg-accordion',
                PREMIUM_BLOCKS_URL . 'assets/js/minified/accordion.min.js',
                array(),
                PREMIUM_BLOCKS_VERSION,
                true
            );
        }

        // Add this block's settings to the accordion data.
        add_filter(
            'premium_accordion_localize_data',
            function ($data) use ($block_id, $collapse_others, $expand_first_item) {
                $data[ $block_id ] = array(
                    'collapse_others'   => $collapse_others,
                    'expand_first_item' => $expand_first_item,
                );
                return $data;
            }
        );

        // Prepare data for inline script.
        $data = apply_filters('premium_accordion_localize_data', array());

        wp_scripts()->add_data('pbg-accordion', 'before', array());

        // Add inline script data (merges with existing data if multiple accordions exist).
        if (! empty($data)) {
            wp_add_inline_script(
                'pbg-accordion',
                'pbg_accordion = ' . wp_json_encode($data) . ';',
                'before'
            );
        }
    }

    return $content;
}




/**
 * Register the accordion block.
 *
 * @uses render_block_pbg_accordion()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_accordion()
{
    if (! function_exists('register_block_type')) {
        return;
    }
    register_block_type(
        PREMIUM_BLOCKS_PATH . '/blocks-config/accordion',
        array(
            'render_callback' => 'render_block_pbg_accordion',
        )
    );
}

register_block_pbg_accordion();
