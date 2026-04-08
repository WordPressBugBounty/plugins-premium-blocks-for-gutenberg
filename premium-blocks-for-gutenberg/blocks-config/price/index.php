<?php

/**
 * Server-side rendering of the `premium/price` block.
 *
 * @package WordPress
 */

function get_premium_price_css($attributes, $unique_id)
{
    $css = new Premium_Blocks_css();

    // All properties are responsive: Desktop + Tablet + Mobile in one block.
    $css->render_responsive(function ($css, $device) use ($attributes, $unique_id) {
        // Container.
        $css->set_selector(".{$unique_id}");
        $css->pbg_render_align_self($attributes, 'align', 'justify-content', $device);
        $css->pbg_render_spacing($attributes, 'padding', 'padding', $device);
        $css->pbg_render_spacing($attributes, 'margin', 'margin', $device);

        // Slashed Price.
        $css->set_selector(".{$unique_id} .premium-pricing-slash");
        $css->pbg_render_typography($attributes, 'slashedTypography', $device);
        $css->pbg_render_value($attributes, 'slashedAlign', 'align-self', $device);

        // Currency.
        $css->set_selector(".{$unique_id} .premium-pricing-currency");
        $css->pbg_render_typography($attributes, 'currencyTypography', $device);
        $css->pbg_render_value($attributes, 'currencyAlign', 'align-self', $device);

        // Price.
        $css->set_selector(".{$unique_id} .premium-pricing-val");
        $css->pbg_render_typography($attributes, 'priceTypography', $device);
        $css->pbg_render_value($attributes, 'priceAlign', 'align-self', $device);

        // Divider.
        $css->set_selector(".{$unique_id} .premium-pricing-divider");
        $css->pbg_render_typography($attributes, 'dividerTypography', $device);
        $css->pbg_render_value($attributes, 'dividerAlign', 'align-self', $device);

        // Duration.
        $css->set_selector(".{$unique_id} .premium-pricing-dur");
        $css->pbg_render_typography($attributes, 'durationTypography', $device);
        $css->pbg_render_value($attributes, 'durationAlign', 'align-self', $device);
    });

    return $css->css_output();
}

/**
 * Renders the `premium/price` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_price($attributes, $content, $block)
{

    return $content;
}


/**
 * Register the Price block.
 *
 * @uses render_block_pbg_price()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_price()
{
    register_block_type(
        'premium/price',
        array(
            'render_callback' => 'render_block_pbg_price',
            'editor_style'    => 'premium-blocks-editor-css',
            'editor_script'   => 'pbg-blocks-js',
        )
    );
}

register_block_pbg_price();
