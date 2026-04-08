<?php

/**
 * Server-side rendering of the `pbg/testimonials` block.
 *
 * @package WordPress
 */

/**
 * Get Testimonials Block CSS
 *
 * Return Frontend CSS for Testimonials.
 *
 * @access public
 *
 * @param string $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_testimonials_css_style($attr, $unique_id)
{
    $css = new Premium_Blocks_css();

    // Non-responsive: same value on all devices.
    $opacity_value = $css->pbg_get_value($attr, 'quoteStyles[0].quotOpacity');
    $opacity_value = $opacity_value / 100;

    $css->set_selector($unique_id);
    $css->pbg_render_shadow($attr, 'boxShadow', 'box-shadow');

    $css->set_selector($unique_id . ' .premium-testimonial__upper svg, ' . $unique_id . ' .premium-testimonial__lower svg');
    $css->pbg_render_color($attr, 'quoteStyles[0].quotColor', 'fill');
    $css->add_property('opacity', $opacity_value);

    // Responsive: Desktop + Tablet + Mobile in one block.
    $css->render_responsive(function ($css, $device) use ($attr, $unique_id) {
        $css->set_selector($unique_id);
        $css->pbg_render_background($attr, 'background', $device);
        $css->pbg_render_value($attr, 'align', 'text-align', $device);
        $css->pbg_render_spacing($attr, 'padding', 'padding', $device);
        $css->pbg_render_border($attr, 'containerBorder', $device);

        $css->set_selector($unique_id . ' .premium-text-wrap');
        $css->pbg_render_value($attr, 'align', 'text-align', $device);

        $css->set_selector($unique_id . ' .premium-icon-container');
        $css->pbg_render_value($attr, 'align', 'text-align', $device);

        $css->set_selector($unique_id . ' .premium-image-container');
        $css->pbg_render_align_self($attr, 'align', 'justify-content', $device);

        $css->set_selector($unique_id . ' .premium-testimonial__upper svg, ' . $unique_id . ' .premium-testimonial__lower svg');
        $css->pbg_render_range($attr, 'quotSize', 'width', $device);

        $css->set_selector($unique_id . ' .premium-testimonial__container .premium-testimonial__upper');
        $css->pbg_render_spacing($attr, 'topPosition', 'top', $device, null, null, 'top');
        $css->pbg_render_spacing($attr, 'topPosition', 'left', $device, null, null, 'left');

        $css->set_selector($unique_id . ' .premium-testimonial__container .premium-testimonial__lower');
        $css->pbg_render_spacing($attr, 'bottomPosition', 'bottom', $device, null, null, 'bottom');
        $css->pbg_render_spacing($attr, 'bottomPosition', 'right', $device, null, null, 'right');
    });

    return $css->css_output();
}

/**
 * Renders the `premium/testimonial` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_testimonials($attributes, $content, $block)
{

    return $content;
}




/**
 * Register the testimonials block.
 *
 * @uses render_block_pbg_testimonials()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_testimonials()
{
    if (! function_exists('register_block_type')) {
        return;
    }
    register_block_type(
        PREMIUM_BLOCKS_PATH . '/blocks-config/testimonials',
        array(
            'render_callback' => 'render_block_pbg_testimonials',
        )
    );
}

register_block_pbg_testimonials();
