<?php

/**
 * Server-side rendering of the `pbg/content-switcher` block.
 *
 * @package WordPress
 */

/**
 * Generate CSS styles for the Content Switcher block
 *
 * @param array  $attributes Block attributes.
 * @param string $unique_id Unique block ID.
 * @return string Generated CSS string
 */
function get_content_switcher_css_style($attributes, $unique_id)
{
    $css       = new Premium_Blocks_css();
    $unique_id = $attributes['blockId'];
    $display   = $attributes['display'] ?? 'inline';

    // Get units for spacing and size for handling backward compatibility. This can be removed within a few versions.
    $label_spacing_unit = $css->pbg_get_value($attributes, 'labelSpacing.unit');
    $switch_size_unit   = $css->pbg_get_value($attributes, 'switchSize.unit');

    // Non-responsive styles - shadows.
    $css->set_selector('.' . $unique_id . ' > .premium-content-switcher');
    $css->pbg_render_shadow($attributes, 'containerBoxShadow', 'box-shadow');

    $css->set_selector('.' . $unique_id . ' .premium-content-switcher-toggle-switch-slider, .' . $unique_id . ' .premium-content-switcher-toggle-wrapper .premium-content-switcher-toggle-btn');
    $css->pbg_render_shadow($attributes, 'switchShadow', 'box-shadow');
    $css->pbg_render_range($attributes, 'switchRadius', 'border-radius', '', '', $attributes['switchRadiusUnit'] ?? 'px');

    $css->set_selector('.' . $unique_id . ' .premium-content-switcher-toggle-switch-slider:before, .' . $unique_id . ' .premium-content-switcher-toggle-wrapper .premium-content-switcher-toggle-btn-active');
    $css->pbg_render_range($attributes, 'containerRadius', 'border-radius', '', '', $attributes['containerRadiusUnit'] ?? 'px');
    $css->pbg_render_shadow($attributes, 'containerShadow', 'box-shadow');

    $css->set_selector('.' . $unique_id . ' .premium-content-switcher-toggle-switch-slider img');
    $css->pbg_render_range($attributes, 'containerRadius', 'border-radius', '', '', $attributes['containerRadiusUnit'] ?? 'px');

    // Non-responsive - active label colors.
    $css->set_selector('.' . $unique_id . " .premium-content-switcher .premium-content-switcher-toggle-wrapper .premium-content-switcher-first-label.premium-content-switcher-toggle-btn-active .premium-content-switcher-{$display}-editing");
    $css->pbg_render_color($attributes, 'labelStyles.firstLabelColor', 'color', '');

    $css->set_selector('.' . $unique_id . " .premium-content-switcher .premium-content-switcher-toggle-wrapper .premium-content-switcher-second-label.premium-content-switcher-toggle-btn-active .premium-content-switcher-{$display}-editing");
    $css->pbg_render_color($attributes, 'labelStyles.secondLabelColor', 'color', '');

    // Non-responsive - first label static styles.
    $css->set_selector('.' . $unique_id . " > .premium-content-switcher .premium-content-switcher-toggle-{$display} .premium-content-switcher-first-label .premium-content-switcher-{$display}-editing");
    $css->add_property('margin', '0');
    $css->pbg_render_color($attributes, 'labelStyles.firstLabelInactiveColor', 'color', '');
    $css->pbg_render_color($attributes, 'labelStyles.firstLabelBGColor', 'background-color', '');
    $css->pbg_render_shadow($attributes, 'firstLabelBoxShadow', 'box-shadow');
    $css->pbg_render_shadow($attributes, 'firstLabelShadow', 'text-shadow');

    $css->set_selector('.' . $unique_id . " > .premium-content-switcher .premium-content-switcher-toggle-{$display} .premium-content-switcher-first-label.premium-content-switcher-first-label-active .premium-content-switcher-{$display}-editing");
    $css->pbg_render_color($attributes, 'labelStyles.firstLabelColor', 'color', '');

    // Non-responsive - second label static styles.
    $css->set_selector('.' . $unique_id . " > .premium-content-switcher .premium-content-switcher-toggle-{$display} .premium-content-switcher-second-label .premium-content-switcher-{$display}-editing");
    $css->add_property('margin', '0');
    $css->pbg_render_color($attributes, 'labelStyles.secondLabelInactiveColor', 'color', '');
    $css->pbg_render_color($attributes, 'labelStyles.secondLabelBGColor', 'background-color', '');
    $css->pbg_render_shadow($attributes, 'secondLabelBoxShadow', 'box-shadow');
    $css->pbg_render_shadow($attributes, 'secondLabelShadow', 'text-shadow');

    $css->set_selector('.' . $unique_id . " > .premium-content-switcher .premium-content-switcher-toggle-{$display} .premium-content-switcher-second-label.premium-content-switcher-second-label-active .premium-content-switcher-{$display}-editing");
    $css->pbg_render_color($attributes, 'labelStyles.secondLabelColor', 'color', '');

    // Non-responsive - button wrapper shadow.
    $css->set_selector('.' . $unique_id . " .premium-content-switcher-toggle-{$display} .premium-content-switcher-toggle-wrapper");
    $css->pbg_render_shadow($attributes, 'boxBoxShadow', 'box-shadow');

    // Non-responsive - icon colors.
    $css->set_selector('.' . $unique_id . ' .premium-content-switcher-icon-first:not(.premium-lottie-animation) svg, .' . $unique_id . ' .premium-content-switcher-icon-first:not(.premium-lottie-animation) svg *, .' . $unique_id . ' .premium-content-switcher-icon-first:not(.icon-type-fe):not(.premium-lottie-animation) svg, .' . $unique_id . ' .premium-content-switcher-icon-first:not(.icon-type-fe):not(.premium-lottie-animation) svg *');
    $css->pbg_render_color($attributes, 'firstIconColor', 'color', '');
    $css->pbg_render_color($attributes, 'firstIconColor', 'fill', '');

    $css->set_selector('.' . $unique_id . ' .premium-content-switcher-icon-second:not(.premium-lottie-animation) svg, .' . $unique_id . ' .premium-content-switcher-icon-second:not(.premium-lottie-animation) svg *, .' . $unique_id . ' .premium-content-switcher-icon-second:not(.icon-type-fe):not(.premium-lottie-animation) svg, .' . $unique_id . ' .premium-content-switcher-icon-second:not(.icon-type-fe):not(.premium-lottie-animation) svg *');
    $css->pbg_render_color($attributes, 'secondIconColor', 'color', '');
    $css->pbg_render_color($attributes, 'secondIconColor', 'fill', '');

    // Responsive styles.
    $css->render_responsive(function ($css, $device) use ($attributes, $unique_id, $display, $label_spacing_unit, $switch_size_unit) {
        // Container alignment.
        $css->set_selector('.' . $unique_id);
        $css->pbg_render_value($attributes, 'align', 'text-align', $device);

        $css->set_selector('.' . $unique_id . ' > .premium-content-switcher');
        $css->pbg_render_value($attributes, 'align', 'text-align', $device);
        $css->pbg_render_spacing($attributes, 'containerPadding', 'padding', $device);
        $css->pbg_render_spacing($attributes, 'containerMargin', 'margin', $device);
        $css->pbg_render_background($attributes, 'containerBackground', $device);
        $css->pbg_render_border($attributes, 'containerborder', $device);

        // Toggle alignment - inline.
        $css->set_selector('.' . $unique_id . ' > .premium-content-switcher > .premium-content-switcher-toggle-inline');
        $css->pbg_render_range($attributes, 'labelSpacing', 'gap', $device, '', $label_spacing_unit ? '' : 'px');
        $css->pbg_render_value($attributes, 'align', 'text-align', $device);
        $css->pbg_render_align_self($attributes, 'align', 'justify-content', $device);

        // Toggle alignment - block.
        $css->set_selector('.' . $unique_id . ' > .premium-content-switcher > .premium-content-switcher-toggle-block');
        $css->pbg_render_range($attributes, 'labelSpacing', 'gap', $device, '', $label_spacing_unit ? '' : 'px');
        $css->pbg_render_value($attributes, 'align', 'text-align', $device);
        $css->pbg_render_align_self($attributes, 'align', 'justify-content', $device);
        $css->pbg_render_align_self($attributes, 'align', 'align-items', $device);

        // Switcher background.
        $css->set_selector('.' . $unique_id . ' .premium-content-switcher-toggle-switch-slider, .' . $unique_id . ' .premium-content-switcher-toggle-wrapper .premium-content-switcher-toggle-btn');
        $css->pbg_render_background($attributes, 'switcherBackground', $device);

        $css->set_selector('.' . $unique_id . ' .premium-content-switcher-toggle-switch-label input:checked+.premium-content-switcher-toggle-switch-slider');
        $css->pbg_render_background($attributes, 'switcherTwoBackground', $device);

        // Controller background.
        $css->set_selector('.' . $unique_id . ' .premium-content-switcher-toggle-switch-slider:before, .' . $unique_id . ' .premium-content-switcher-toggle-wrapper .premium-content-switcher-toggle-btn-active');
        $css->pbg_render_background($attributes, 'controllerOneBackground', $device);

        $css->set_selector('.' . $unique_id . ' .premium-content-switcher-toggle-switch-label input:checked+.premium-content-switcher-toggle-switch-slider::before');
        $css->pbg_render_background($attributes, 'controllerTwoBackground', $device);

        $css->set_selector('.' . $unique_id . ' .premium-content-switcher-toggle-wrapper .premium-content-switcher-first-label.premium-content-switcher-toggle-btn-active');
        $css->pbg_render_background($attributes, 'controllerOneBackground', $device);

        $css->set_selector('.' . $unique_id . ' .premium-content-switcher-toggle-wrapper .premium-content-switcher-second-label.premium-content-switcher-toggle-btn-active');
        $css->pbg_render_background($attributes, 'controllerTwoBackground', $device);

        // First label typography/padding/border.
        $css->set_selector('.' . $unique_id . " > .premium-content-switcher .premium-content-switcher-toggle-{$display} .premium-content-switcher-first-label .premium-content-switcher-{$display}-editing");
        $css->pbg_render_typography($attributes, 'firstLabelTypography', $device);
        $css->pbg_render_spacing($attributes, 'firstLabelPadding', 'padding', $device);
        $css->pbg_render_border($attributes, 'firstLabelborder', $device);

        // Second label typography/padding/border.
        $css->set_selector('.' . $unique_id . " > .premium-content-switcher .premium-content-switcher-toggle-{$display} .premium-content-switcher-second-label .premium-content-switcher-{$display}-editing");
        $css->pbg_render_typography($attributes, 'secondLabelTypography', $device);
        $css->pbg_render_spacing($attributes, 'secondLabelPadding', 'padding', $device);
        $css->pbg_render_border($attributes, 'secondLabelborder', $device);

        // Switch size.
        $css->set_selector(
            '.' . $unique_id . ' > .premium-content-switcher > .premium-content-switcher-toggle-inline > .premium-content-switcher-toggle-switch, ' .
            '.' . $unique_id . ' > .premium-content-switcher > .premium-content-switcher-toggle-block > .premium-content-switcher-toggle-switch, ' .
            '.' . $unique_id . ' .premium-content-switcher-toggle-switch-slider .premium-content-switcher-icon'
        );
        $css->pbg_render_range($attributes, 'switchSize', 'font-size', $device, '', $switch_size_unit ? '' : 'px');

        // Button wrapper styles.
        $css->set_selector('.' . $unique_id . " .premium-content-switcher-toggle-{$display} .premium-content-switcher-toggle-wrapper");
        $css->pbg_render_background($attributes, 'boxBackground', $device);
        $css->pbg_render_spacing($attributes, 'boxPadding', 'padding', $device);
        $css->pbg_render_border($attributes, 'boxBorder', $device);

        $css->set_selector('.' . $unique_id . ' .premium-content-switcher-toggle-wrapper .premium-content-switcher-toggle-btn');
        $css->pbg_render_spacing($attributes, 'switcherPadding', 'padding', $device);
        $css->pbg_render_spacing($attributes, 'switcherMargin', 'margin', $device);

        $css->set_selector('.' . $unique_id . ' .premium-content-switcher-toggle-wrapper .premium-content-switcher-first-label');
        $css->pbg_render_background($attributes, 'switcherBackground', $device);

        $css->set_selector('.' . $unique_id . ' .premium-content-switcher-toggle-wrapper .premium-content-switcher-second-label');
        $css->pbg_render_background($attributes, 'switcherTwoBackground', $device);
    });

    return $css->css_output();
}

function render_block_pbg_content_switcher($attributes, $content)
{
    wp_enqueue_script(
        'content-switcher',
        PREMIUM_BLOCKS_URL . 'assets/js/minified/content-switcher.min.js',
        array(),
        PREMIUM_BLOCKS_VERSION,
        true
    );

    return $content;
}

/**
 * Registers the `pbg/content-switcher` block on the server.
 */
function register_block_pbg_content_switcher()
{
    if (! function_exists('register_block_type')) {
        return;
    }
    register_block_type(
        PREMIUM_BLOCKS_PATH . '/blocks-config/content-switcher',
        array(
            'render_callback' => 'render_block_pbg_content_switcher',
        )
    );
}

register_block_pbg_content_switcher();
