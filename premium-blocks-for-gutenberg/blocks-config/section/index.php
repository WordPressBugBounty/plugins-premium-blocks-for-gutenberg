<?php

/**
 * Server-side rendering of the `pbg/section` block.
 *
 * @package WordPress
 */

/**
 * Get Section Block CSS
 *
 * Return Frontend CSS for Section.
 *
 * @access public
 *
 * @param string $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_section_css_style($attr, $unique_id)
{
    $css = new Premium_Blocks_css();

    $inner_width_type = $css->pbg_get_value($attr, 'innerWidthType');
    $inner_width_value = $css->pbg_get_value($attr, 'innerWidth');
    $min_height_type = $css->pbg_get_value($attr, 'height');
    $min_height_value = $css->pbg_get_value($attr, 'minHeight');
    $is_stretched_section = $css->pbg_get_value($attr, 'stretchSection');

    $css->pbg_render_shadow($attr, 'boxShadow', 'box-shadow');

    // Backward compatibility for non-array minHeight/innerWidth (Desktop-only).
    if ($min_height_type === 'min' && ! is_array($min_height_value)) {
        $css->set_selector($unique_id . ' .premium-section__content_wrap');
        $css->pbg_render_range($attr, 'minHeight', 'min-height', null, null, $css->pbg_get_value($attr, 'minHeightUnit') ?? 'px');
    }
    if ($min_height_type === 'fit') {
        $css->set_selector($unique_id . ' .premium-section__content_wrap');
        $css->add_property('min-height', '100vh');
    }
    if ($is_stretched_section && $inner_width_type === 'boxed' && ! is_array($inner_width_value)) {
        $css->set_selector($unique_id . ' .premium-section__content_wrap');
        $css->pbg_render_range($attr, 'innerWidth', 'max-width', null, null, 'px');
    }

    $css->render_responsive(function ($css, $device) use ($attr, $unique_id, $min_height_type, $inner_width_type, $is_stretched_section, $min_height_value, $inner_width_value) {
        $css->set_selector($unique_id);
        $css->pbg_render_spacing($attr, 'padding', 'padding', $device);
        $css->pbg_render_border($attr, 'border', $device);
        $css->pbg_render_value($attr, 'horAlign', 'text-align', $device);
        $css->pbg_render_background($attr, 'background', $device);

        $css->set_selector("body .entry-content {$unique_id}:not(.alignfull)");
        $css->pbg_render_spacing($attr, 'margin', 'margin', $device);

        $css->set_selector("body .entry-content {$unique_id}.alignfull");
        $css->pbg_render_spacing($attr, 'margin', 'margin-top', $device, null, null, 'top');
        $css->pbg_render_spacing($attr, 'margin', 'margin-bottom', $device, null, null, 'bottom');

        $css->set_selector($unique_id . ' .premium-section__content_wrap');
        if ($min_height_type === 'min' && is_array($min_height_value)) {
            $css->pbg_render_range($attr, 'minHeight', 'min-height', $device);
        }
        if ($is_stretched_section && $inner_width_type === 'boxed' && is_array($inner_width_value)) {
            $css->pbg_render_range($attr, 'innerWidth', 'max-width', $device);
        }

        $css->set_selector($unique_id . ' .premium-section__content_wrap .premium-section__content_inner');
        $css->pbg_render_align_self($attr, 'horAlign', 'align-items', $device);
    });

    return $css->css_output();
}

/**
 * Renders the `premium/section` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_section($attributes, $content, $block)
{

    return $content;
}




/**
 * Register the section block.
 *
 * @uses render_block_pbg_section()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_section()
{
    if (! function_exists('register_block_type')) {
        return;
    }
    register_block_type(
        PREMIUM_BLOCKS_PATH . '/blocks-config/section',
        array(
            'render_callback' => 'render_block_pbg_section',
        )
    );
}

register_block_pbg_section();
