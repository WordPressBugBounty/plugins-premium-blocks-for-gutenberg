<?php

/**
 * Server-side rendering of the `premium/form` block.
 *
 * @package WordPress
 */

/**
 * Get Form Block CSS
 *
 * Return Frontend CSS for Form.
 *
 * @access public
 *
 * @param array $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_form_css_style($attr, $unique_id)
{
    $css = new Premium_Blocks_css();

    if (isset($attr['labelsColors'])) {
        $css->set_selector(".{$unique_id} .premium-form-input-label");
        $css->add_property('color', $attr['labelsColors']['text'] ?? '');
        // Hover.
        $css->set_selector(".{$unique_id} .premium-form-input-label:hover");
        $css->add_property('color', $attr['labelsColors']['textHover'] ?? '');
    }

    // Inputs.
    if (isset($attr['inputsColors'])) {
        $css->set_selector(".{$unique_id}.premium-form .premium-form-input");
        $css->add_property('color', $attr['inputsColors']['text'] ?? '');
        $css->add_property('background-color', $attr['inputsColors']['background'] ?? '');
        // Placeholder.
        $css->set_selector(".{$unique_id}.premium-form .premium-form-input::placeholder");
        $css->add_property('color', $attr['inputsColors']['placeholder'] ?? '');
        // Hover.
        $css->set_selector(".{$unique_id}.premium-form .premium-form-input:hover");
        $css->add_property('color', $attr['inputsColors']['textHover'] ?? '');
        $css->add_property('background-color', $attr['inputsColors']['hoverBackground'] ?? '');
        $css->add_property('border-color', $attr['inputsColors']['borderHover'] ?? '');
        // Placeholder.
        $css->set_selector(".{$unique_id}.premium-form .premium-form-input:hover::placeholder");
        $css->add_property('color', $attr['inputsColors']['placeholderHover']);
        // Focus.
        $css->set_selector(".{$unique_id}.premium-form .premium-form-input:focus");
        $css->add_property('color', $attr['inputsColors']['textFocus'] ?? '');
        $css->add_property('background-color', $attr['inputsColors']['focusBackground'] ?? '');
        $css->add_property('border-color', $attr['inputsColors']['borderFocus'] ?? '');
        // Placeholder.
        $css->set_selector(".{$unique_id}.premium-form .premium-form-input:focus::placeholder");
        $css->add_property('color', $attr['inputsColors']['placeholderFocus'] ?? '');
    }

    // radioColors.
    if (isset($attr['radioColors'])) {
        $radio_colors = $attr['radioColors'];

        $css->set_selector(".{$unique_id}.premium-form .premium-radio-item .premium-radio-item-input-wrap .premium-radio-item-input-checkmark");
        $css->add_property('background-color', $radio_colors['background'] ?? "");
        // Element color.
        $css->set_selector(".{$unique_id}.premium-form .premium-form-radio-item .premium-radio-item-input-wrap .premium-radio-item-input-checkmark:after");
        $css->add_property('background-color', $radio_colors['element'] ?? "");
        // Focus.
        $css->set_selector(".{$unique_id}.premium-form .premium-radio-item .premium-radio-item-input-wrap input:checked ~ .premium-radio-item-input-checkmark");
        $css->add_property('background-color', $radio_colors['focusBackground'] ?? "");
        // Element color.
        $css->set_selector(".{$unique_id}.premium-form .premium-radio-item .premium-radio-item-input-wrap input:checked ~ .premium-radio-item-input-checkmark:after");
        $css->add_property('background-color', $radio_colors['elementFocus'] ?? "");
    }

    // checkboxColors.
    if (isset($attr['checkboxColors'])) {
        $checkbox_colors = $attr['checkboxColors'];
        $css->set_selector(".{$unique_id}.premium-form .premium-checkbox-item .premium-checkbox-item-input-wrap .premium-checkbox-item-input-checkmark");
        $css->add_property('background-color', $checkbox_colors['background'] ?? '');
        // Element color.
        $css->set_selector(".{$unique_id}.premium-form .premium-form-checkbox-item .premium-checkbox-item-input-wrap .premium-checkbox-item-input-checkmark:after");
        $css->add_property('border-color', $checkbox_colors['element'] ?? '');
        // Focus.
        $css->set_selector(".{$unique_id}.premium-form .premium-checkbox-item .premium-checkbox-item-input-wrap input:checked ~ .premium-checkbox-item-input-checkmark");
        $css->add_property('background-color', $checkbox_colors['focusBackground'] ?? '');
        // Element color.
        $css->set_selector(".{$unique_id}.premium-form .premium-checkbox-item .premium-checkbox-item-input-wrap input:checked ~ .premium-checkbox-item-input-checkmark:after");
        $css->add_property('border-color', $checkbox_colors['elementFocus'] ?? '');
    }

    // buttonColors.
    if (isset($attr['buttonColors'])) {
        $button_colors = $attr['buttonColors'];
        $css->set_selector(".{$unique_id} .wp-block-button__link.premium-form-submit");
        $css->add_property('color', $button_colors['text'] ?? '');
        // Hover.
        $css->set_selector(".{$unique_id} .wp-block-button__link.premium-form-submit:hover");
        $css->add_property('color', $button_colors['textHover'] ?? '');
        $css->add_property('border-color', $button_colors['borderHover'] ?? '');
        $css->add_property('background-color', isset($button_colors['backgroundHover']) && $button_colors['backgroundHover'] ? $button_colors['backgroundHover'] . ' !important' : '');
    }

    // svg/icon non-responsive colors.
    if (isset($attr['iconColor'])) {
        $icon_color = $attr['iconColor'];
        $css->set_selector(".{$unique_id} .premium-form-input__content-icon .premium-form-input-icon");
        $css->add_property('fill', $css->render_color($icon_color));
        $css->add_property('color', $css->render_color($icon_color));
        $css->set_selector(".{$unique_id} .premium-form-input__content-icon .premium-form-input-icon:not(.icon-type-fe) svg");
        $css->add_property('fill', $css->render_color($icon_color));
        $css->add_property('color', $css->render_color($icon_color));
        $css->set_selector(".{$unique_id} .premium-form-input__icon-wrap .premium-form-input-svg-class svg");
        $css->add_property('fill', $css->render_color($icon_color));
        $css->add_property('color', $css->render_color($icon_color));
        $css->set_selector(".{$unique_id} .premium-form-input__content-icon .premium-form-input-icon:not(.icon-type-fe) svg *");
        $css->add_property('fill', $css->render_color($icon_color));
        $css->set_selector(".{$unique_id} .premium-form-input__icon-wrap .premium-form-input-svg-class svg *");
        $css->add_property('fill', $css->render_color($icon_color));
    }

    if (isset($attr['iconHoverColor'])) {
        $icon_HoverColor = $attr['iconHoverColor'];
        $css->set_selector(".{$unique_id} .premium-form-input-wrap:hover .premium-form-input-icon");
        $css->add_property('fill', $css->render_color($icon_HoverColor));
        $css->add_property('color', $css->render_color($icon_HoverColor));
        $css->set_selector(".{$unique_id} .premium-form-input-wrap:hover .premium-form-input-svg-class svg");
        $css->add_property('fill', $css->render_color($icon_HoverColor));
        $css->add_property('color', $css->render_color($icon_HoverColor));
        $css->set_selector(".{$unique_id} .premium-form-input-wrap:hover .premium-form-input-icon:not(.icon-type-fe) svg *");
        $css->add_property('fill', $css->render_color($icon_HoverColor));
        $css->set_selector(".{$unique_id} .premium-form-input-wrap:hover .premium-form-input-svg-class svg *");
        $css->add_property('fill', $css->render_color($icon_HoverColor));
    }

    if (isset($attr['borderHoverColor'])) {
        $hover_border = $attr['borderHoverColor'];
        $css->set_selector(".{$unique_id} .premium-form-input-wrap:hover .premium-form-input-icon");
        $css->add_property('border-color', $css->render_string($css->render_color($hover_border), '!important'));
        $css->set_selector(".{$unique_id} .premium-form-input-wrap:hover .premium-form-input-svg-class svg");
        $css->add_property('border-color', $css->render_string($css->render_color($hover_border), '!important'));
        $css->set_selector(".{$unique_id} .premium-form-input-wrap:hover .premium-lottie-animation svg");
        $css->add_property('border-color', $css->render_string($css->render_color($hover_border), '!important'));
    }

    $css->render_responsive(function ($css, $device) use ($attr, $unique_id) {

        // Align.
        if (isset($attr['align'])) {
            $align           = $css->get_responsive_css($attr['align'], $device);
            $justify_content = '';
            if ('left' === $align) {
                $justify_content = 'flex-start';
            } elseif ('right' === $align) {
                $justify_content = 'flex-end';
            } else {
                $justify_content = 'center';
            }

            $css->set_selector(".{$unique_id}.premium-form *");
            $css->add_property('text-align', "{$align} !important");
            $css->add_property('justify-content', "{$justify_content} !important");
        }

        // Labels.
        $css->set_selector(".{$unique_id}.premium-form .premium-form-input-label");
        $css->pbg_render_typography($attr, 'labelsTypography', $device);

        // Inputs.
        $css->set_selector(".{$unique_id}.premium-form .premium-form-input");
        $css->pbg_render_typography($attr, 'inputsTypography', $device);

        if (isset($attr['inputsBorder'])) {
            $inputs_border = $attr['inputsBorder'];
            $css->set_selector(".{$unique_id}.premium-form .premium-form-input");
            $css->render_border($inputs_border, $device);
        }

        if (isset($attr['inputsPadding'])) {
            $inputs_padding = $attr['inputsPadding'];
            $css->set_selector(".{$unique_id}.premium-form .premium-form-input");
            $css->add_property('padding', $css->render_spacing($inputs_padding[$device], $inputs_padding['unit'][$device]) . "!important");
        }

        if (isset($attr['inputsMargin'])) {
            $inputs_margin = $attr['inputsMargin'];
            $css->set_selector(".{$unique_id}.premium-form .premium-form-input");
            $css->add_property('margin', $css->render_spacing($inputs_margin[$device], $inputs_margin['unit'][$device]));
        }

        // radioBorder.
        if (isset($attr['radioBorder'])) {
            $radio_border = $attr['radioBorder'];
            $css->set_selector(".{$unique_id} .premium-radio-item .premium-radio-item-input-wrap .premium-radio-item-input-checkmark");
            $css->render_border($radio_border, $device);
        }

        // checkboxBorder.
        if (isset($attr['checkboxBorder'])) {
            $checkbox_border = $attr['checkboxBorder'];
            $css->set_selector(".{$unique_id} .premium-checkbox-item .premium-checkbox-item-input-wrap .premium-checkbox-item-input-checkmark");
            $css->render_border($checkbox_border, $device);
        }

        // Button buttonAlign.
        if (isset($attr['buttonAlign'])) {
            $button_align = $css->get_responsive_css($attr['buttonAlign'], $device);
            $css->set_selector(".{$unique_id} .premium-form-submit-wrap, .{$unique_id} .premium-form-submit-wrap .wp-block-button__link");
            $css->add_property('justify-content', "{$button_align} !important");
        }

        // Button buttonTypography.
        $css->set_selector(".{$unique_id}.premium-form .wp-block-button__link.premium-form-submit span");
        $css->pbg_render_typography($attr, 'buttonTypography', $device);

        // buttonBackgroundOptions.
        if (isset($attr['buttonBackgroundOptions'])) {
            $button_background_options = $attr['buttonBackgroundOptions'];
            $css->set_selector(".{$unique_id} .wp-block-button__link.premium-form-submit");
            $css->render_background($button_background_options, $device);
        }

        // buttonBorder.
        if (isset($attr['buttonBorder'])) {
            $button_border = $attr['buttonBorder'];
            $css->set_selector(".{$unique_id} .wp-block-button__link.premium-form-submit");
            $css->render_border($button_border, $device);
        }

        // buttonPadding.
        if (isset($attr['buttonPadding'])) {
            $button_padding = $attr['buttonPadding'];
            $css->set_selector(".{$unique_id} .wp-block-button__link.premium-form-submit");
            $css->add_property('padding', $css->render_spacing($button_padding[$device], $button_padding['unit'][$device]));
        }

        // buttonMargin.
        if (isset($attr['buttonMargin'])) {
            $button_margin = $attr['buttonMargin'];
            $css->set_selector(".{$unique_id} .wp-block-button__link.premium-form-submit");
            $css->add_property('margin', $css->render_spacing($button_margin[$device], $button_margin['unit'][$device]));
        }

        // Style for icon.
        if (isset($attr['iconSize'])) {
            $css->set_selector(".{$unique_id} .premium-form-input__content-icon .premium-form-input-icon");
            $css->add_property('font-size', $css->render_string($css->render_range($attr['iconSize'], $device), '!important'));
            $css->add_property('width', $css->render_string('auto', '!important'));
            $css->add_property('height', $css->render_string('auto', '!important'));

            $css->set_selector(".{$unique_id} .premium-form-input__content-icon .premium-form-input-icon svg");
            $css->add_property('width', $css->render_string($css->render_range($attr['iconSize'], $device), '!important'));
            $css->add_property('height', $css->render_string($css->render_range($attr['iconSize'], $device), '!important'));

            $css->set_selector(".{$unique_id} .premium-form-input__icon-wrap .premium-form-input-svg-class svg");
            $css->add_property('width', $css->render_string($css->render_range($attr['iconSize'], $device), '!important'));
            $css->add_property('height', $css->render_string($css->render_range($attr['iconSize'], $device), '!important'));

            $css->set_selector(".{$unique_id} .premium-form-input__icon-wrap img");
            $css->add_property('width', $css->render_range($attr['iconSize'], $device));

            $css->set_selector(".{$unique_id} .premium-form-input__icon-wrap .premium-lottie-animation svg");
            $css->add_property('width', $css->render_string($css->render_range($attr['iconSize'], $device), '!important'));
            $css->add_property('height', $css->render_string($css->render_range($attr['iconSize'], $device), '!important'));

            $css->set_selector(".{$unique_id}.premium-form .premium-form-input__icon-wrap + .premium-form-input:not(textarea)");
            $css->add_property('height', $css->render_string($css->render_range($attr['iconSize'], $device)));
            $css->add_property('padding-left', $css->render_string('calc(' . $css->render_range($attr['iconSize'], $device) . ' + 15px)'));

            $css->set_selector(".{$unique_id}.premium-form .premium-form-input__icon-wrap + .premium-form-input:is(textarea)");
            $css->add_property('height', $css->render_string('calc(' . $css->render_range($attr['iconSize'], $device) . ' + 50px)'));
            $css->add_property('padding-left', $css->render_string('calc(' . $css->render_range($attr['iconSize'], $device) . ' + 15px)'));
        }

        if (isset($attr['iconMargin'])) {
            $icon_margin = $attr['iconMargin'];
            $css->set_selector(".{$unique_id} .premium-form-input__content-icon .premium-form-input-icon, .{$unique_id} .premium-form-input__icon-wrap img, .{$unique_id} .premium-form-input__icon-wrap .premium-form-input-svg-class svg, .{$unique_id} .premium-form-input__icon-wrap .premium-lottie-animation svg");
            $css->add_property('margin', $css->render_spacing($icon_margin[$device], $icon_margin['unit'][$device]));
        }

        if (isset($attr['iconPadding'])) {
            $icon_padding = $attr['iconPadding'];
            $css->set_selector(".{$unique_id} .premium-form-input__content-icon .premium-form-input-icon, .{$unique_id} .premium-form-input__icon-wrap img, .{$unique_id} .premium-form-input__icon-wrap .premium-form-input-svg-class svg, .{$unique_id} .premium-form-input__icon-wrap .premium-lottie-animation svg");
            $css->add_property('padding', $css->render_spacing($icon_padding[$device], $icon_padding['unit'][$device]));
        }

        if (isset($attr['iconBorder'])) {
            $icon_border = $attr['iconBorder'];
            $css->set_selector(".{$unique_id} .premium-form-input__content-icon .premium-form-input-icon, .{$unique_id} .premium-form-input__icon-wrap img, .{$unique_id} .premium-form-input__icon-wrap .premium-form-input-svg-class svg, .{$unique_id} .premium-form-input__icon-wrap .premium-lottie-animation svg");
            $css->render_border($icon_border, $device);
        }

        if (isset($attr['iconBG'])) {
            $css->set_selector(".{$unique_id} .premium-form-input__content-icon .premium-form-input-icon");
            $css->render_background($attr['iconBG'], $device);
            $css->set_selector(".{$unique_id} .premium-form-input__icon-wrap .premium-form-input-svg-class svg");
            $css->render_background($attr['iconBG'], $device);
            $css->set_selector(".{$unique_id} .premium-form-input__icon-wrap .premium-lottie-animation svg");
            $css->render_background($attr['iconBG'], $device);
        }

        if (isset($attr['iconHoverBG'])) {
            $css->set_selector(".{$unique_id} .premium-form-input-wrap:hover .premium-form-input-icon");
            $css->render_background($attr['iconHoverBG'], $device);
            $css->set_selector(".{$unique_id} .premium-form-input-wrap:hover .premium-form-input-svg-class svg");
            $css->render_background($attr['iconHoverBG'], $device);
            $css->set_selector(".{$unique_id} .premium-form-input-wrap:hover .premium-lottie-animation svg");
            $css->render_background($attr['iconHoverBG'], $device);
        }

    });

    return $css->css_output();
}

/**
 * Render form block.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content The block content.
 * @param WP_Block $block The block.
 * @return string
 */
function render_block_pbg_form($attributes, $content, $block)
{
    $block_helpers = pbg_blocks_helper();
    $unique_id     = rand(100, 10000);
    $id            = 'premium-form-' . esc_attr((string) $unique_id);
    $block_id      = (! empty($attributes['blockId'])) ? $attributes['blockId'] : $id;
    $inner_blocks  = $block_helpers->get_form_inner_blocks($block->parsed_block['innerBlocks']);


    add_filter(
        'premium_form_localize_script',
        function ($data) use ($block_id, $attributes, $inner_blocks) {
            $data['forms'][$block_id] = array(
                'innerBlocks' => $inner_blocks,
                'attributes'  => $attributes,
            );
            return $data;
        }
    );
    $dependencies = array('wp-element', 'wp-i18n');
    // Check if reCAPTCHA is enabled.
    if (isset($attributes['enableRecaptcha']) && $attributes['enableRecaptcha']) {
        if (isset($attributes['recaptchaVersion']) && $attributes['recaptchaVersion'] === 'v3' && $block_helpers->integrations_settings['premium-recaptcha-v3-site-key'] !== '') {
            wp_enqueue_script(
                'premium-recaptcha-v3',
                'https://www.google.com/recaptcha/api.js?render=' . $block_helpers->integrations_settings['premium-recaptcha-v3-site-key'],
                array(),
                PREMIUM_BLOCKS_VERSION,
                true
            );

            $dependencies[] = 'premium-recaptcha-v3';
        } elseif ($block_helpers->integrations_settings['premium-recaptcha-v2-site-key'] !== '') {

            wp_enqueue_script(
                'premium-recaptcha-v2',
                'https://www.google.com/recaptcha/api.js',
                array(),
                PREMIUM_BLOCKS_VERSION,
                true
            );

            $dependencies[] = 'premium-recaptcha-v2';
        }
    }

    wp_enqueue_script(
        'premium-form-view',
        PREMIUM_BLOCKS_URL . 'assets/js/build/form/index.js',
        $dependencies,
        PREMIUM_BLOCKS_VERSION,
        true
    );


    $data = 	apply_filters(
        'premium_form_localize_script',
        array(
            'ajaxurl'   => esc_url(admin_url('admin-ajax.php')),
            'nonce'     => wp_create_nonce('pbg_form_nonce'),
            'recaptcha' => array(
                'v2SiteKey' => $block_helpers->integrations_settings['premium-recaptcha-v2-site-key'],
                'v3SiteKey' => $block_helpers->integrations_settings['premium-recaptcha-v3-site-key'],
            ),
        )
    );

    wp_scripts()->add_data('premium-form-view', 'after', array());

    wp_add_inline_script(
        'premium-form-view',
        'var PBG_Form = ' . wp_json_encode($data) . ';',
        'after'
    );

    return $content;
}

/**
 * Register the Form block.
 *
 * @uses render_block_pbg_form()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_form()
{
    if (! function_exists('register_block_type')) {
        return;
    }
    register_block_type(
        PREMIUM_BLOCKS_PATH . '/blocks-config/form',
        array(
            'render_callback' => 'render_block_pbg_form',
        )
    );
}

register_block_pbg_form();
