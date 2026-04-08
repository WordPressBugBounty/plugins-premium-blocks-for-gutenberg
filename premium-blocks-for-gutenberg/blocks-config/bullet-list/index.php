<?php

/**
 * Server-side rendering of the `pbg/bullet-list` block.
 *
 * @package WordPress
 */

/**
 * Get Bullet List Block CSS
 *
 * Return Frontend CSS for Bullet List.
 *
 * @access public
 *
 * @param string $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_bullet_list_css_style($attr, $unique_id)
{
    $css = new Premium_Blocks_css();

    $icon_position = $css->pbg_get_value($attr, 'iconPosition');
    $flex_direction = $icon_position === 'top' ? 'column' : ($icon_position === 'after' ? 'row-reverse' : '');

    // Non-responsive styles.
    $css->set_selector('.' . $unique_id . ' .premium-bullet-list__content-wrap');
    $css->add_property('flex-direction', $flex_direction);

    $css->set_selector('.' . $unique_id . ' .premium-bullet-list__wrapper');
    $css->pbg_render_color($attr, 'generalStyles[0].generalBackgroundColor', 'background-color');
    $css->pbg_render_shadow($attr, 'boxShadow', 'box-shadow');

    $css->set_selector('.' . $unique_id . ' .premium-bullet-list__wrapper:hover');
    $css->pbg_render_color($attr, 'generalStyles[0].generalHoverBackgroundColor', 'background-color', null, '!important');
    $css->pbg_render_color($attr, 'itemHoverBorderColor', 'border-color');
    $css->pbg_render_shadow($attr, 'hoverBoxShadow', 'box-shadow');

    $css->set_selector(
        '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-bullet-list-icon, ' .
    '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-bullet-list-icon:not(.icon-type-fe) svg, ' .
    '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-bullet-list-icon:not(.icon-type-fe) svg *, ' .
    '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg, ' .
    '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg *'
    );
    $css->pbg_render_color($attr, 'iconColor', 'color');
    $css->pbg_render_color($attr, 'iconColor', 'fill');

    $css->set_selector(
        '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-bullet-list-icon, ' .
    '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-bullet-list-icon:not(.icon-type-fe) svg *, ' .
    '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-list-item-svg-class svg, ' .
    '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-list-item-svg-class svg *'
    );
    $css->pbg_render_color($attr, 'iconHoverColor', 'color', null, '!important');
    $css->pbg_render_color($attr, 'iconHoverColor', 'fill', null, '!important');

    $css->set_selector(
        '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-bullet-list-icon, ' .
    '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-list-item-svg-class svg, ' .
    '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-lottie-animation svg'
    );
    $css->pbg_render_color($attr, 'borderHoverColor', 'border-color');

    // Style for title.
    $css->set_selector(".{$unique_id} .premium-bullet-list__label");
    $css->pbg_render_color($attr, 'titleStyles[0].titleColor', 'color');
    $css->pbg_render_shadow($attr, 'titlesTextShadow', 'text-shadow');

    $css->set_selector(".{$unique_id} .premium-bullet-list__wrapper:hover .premium-bullet-list__label");
    $css->pbg_render_color($attr, 'titleStyles[0].titleHoverColor', 'color', null, '!important');

    // style for description
    $css->set_selector(".{$unique_id} .premium-bullet-list__description");
    $css->pbg_render_color($attr, 'descriptionStyles.color', 'color');

    $css->set_selector(".{$unique_id} .premium-bullet-list__wrapper:hover .premium-bullet-list__description");
    $css->pbg_render_color($attr, 'descriptionStyles.hoverColor', 'color', null, '!important');

    // style for divider
    $css->set_selector(".{$unique_id} .premium-bullet-list-divider-block:not(:last-child)::after");
    $css->pbg_render_value($attr, 'dividerStyle', 'border-top-style');
    $css->pbg_render_color($attr, 'dividerStyles[0].dividerColor', 'border-top-color');

    $css->set_selector(".{$unique_id} .premium-bullet-list-divider-inline:not(:last-child)::after");
    $css->pbg_render_value($attr, 'dividerStyle', 'border-left-style');
    $css->pbg_render_color($attr, 'dividerStyles[0].dividerColor', 'border-left-color');

    // Responsive styles.
    $css->render_responsive(function ($css, $device) use ($attr, $unique_id) {
        // Align.
        $css->set_selector('.' . $unique_id . ' .premium-bullet-list__icon-wrap');
        $css->pbg_render_value($attr, 'bulletAlign', 'align-self', $device);

        $css->set_selector('.' . $unique_id);
        $css->pbg_render_value($attr, 'align', 'text-align', $device);

        $css->set_selector('.' . $unique_id . ' .premium-bullet-list__content-wrap');
        $css->pbg_render_align_self($attr, 'align', 'justify-content', $device);

        // Style for list.
        $css->set_selector('.' . $unique_id . ' > .premium-bullet-list');
        $css->pbg_render_align_self($attr, 'align', 'justify-content', $device);
        $css->pbg_render_border($attr, 'generalBorder', $device);
        $css->pbg_render_spacing($attr, 'generalpadding', 'padding', $device);
        $css->pbg_render_spacing($attr, 'generalmargin', 'margin', $device);

        // Style for list item.
        $css->set_selector('.' . $unique_id . ' .premium-bullet-list__wrapper');
        $css->pbg_render_align_self($attr, 'align', 'justify-content', $device);
        $css->pbg_render_border($attr, 'itemBorder', $device);
        $css->pbg_render_spacing($attr, 'itempadding', 'padding', $device);
        $css->pbg_render_spacing($attr, 'itemmargin', 'margin', $device);

        // Style for icons.
        $css->set_selector(
            '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-bullet-list-icon svg, ' .
      '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg'
        );
        $css->pbg_render_range($attr, 'iconSize', 'width', $device, null, '!important');
        $css->pbg_render_range($attr, 'iconSize', 'height', $device, null, '!important');

        $css->set_selector(
            '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-bullet-list-icon, ' .
      '.' . $unique_id . ' .premium-bullet-list__icon-wrap img,' .
      '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg, ' .
      '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-lottie-animation svg'
        );
        $css->pbg_render_border($attr, 'iconBorder', $device);
        $css->pbg_render_spacing($attr, 'iconPadding', 'padding', $device);
        $css->pbg_render_spacing($attr, 'iconMargin', 'margin', $device);

        $css->set_selector('.' . $unique_id . ' .premium-bullet-list__icon-wrap img');
        $css->pbg_render_range($attr, 'iconSize', 'width', $device, null, '!important');

        $css->set_selector('.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-lottie-animation svg');
        $css->pbg_render_range($attr, 'iconSize', 'width', $device, null, '!important');
        $css->pbg_render_range($attr, 'iconSize', 'height', $device, null, '!important');

        $css->set_selector(
            '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-bullet-list-icon, ' .
      '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg, ' .
      '.' . $unique_id . ' .premium-bullet-list__icon-wrap .premium-lottie-animation svg'
        );
        $css->pbg_render_background($attr, 'iconBG', $device);

        $css->set_selector(
            '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-bullet-list-icon, ' .
      '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-list-item-svg-class svg, ' .
      '.' . $unique_id . ' .premium-bullet-list__wrapper:hover .premium-lottie-animation svg'
        );
        $css->pbg_render_background($attr, 'iconHoverBG', $device);

        // Style for title.
        $css->set_selector(".{$unique_id} .premium-bullet-list__label");
        $css->pbg_render_typography($attr, 'titleTypography', $device);
        $css->pbg_render_spacing($attr, 'titlemargin', 'margin', $device);

        // style for description
        $css->set_selector(".{$unique_id} .premium-bullet-list__description");
        $css->pbg_render_typography($attr, 'descriptionTypography', $device);
        $css->pbg_render_spacing($attr, 'descriptionMargin', 'margin', $device);

        // style for divider
        $css->set_selector(".{$unique_id} .premium-bullet-list-divider-block:not(:last-child)::after");
        $css->pbg_render_range($attr, 'dividerWidth', 'width', $device);
        $css->pbg_render_range($attr, 'dividerHeight', 'border-top-width', $device);

        $css->set_selector(".{$unique_id} .premium-bullet-list-divider-inline:not(:last-child)::after");
        $css->pbg_render_range($attr, 'dividerWidth', 'border-left-width', $device);
        $css->pbg_render_range($attr, 'dividerHeight', 'height', $device);
    });
    return $css->css_output();
}

/**
 * Renders the `premium/count-up` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_bullet_list($attributes, $content, $block)
{
    $block_helpers = pbg_blocks_helper();
    // Enqueue frontend JS/CSS.
    if ($block_helpers->it_is_not_amp()) {
        wp_enqueue_script(
            'pbg-bullet-list',
            PREMIUM_BLOCKS_URL . 'assets/js/minified/bullet-list.min.js',
            array(),
            PREMIUM_BLOCKS_VERSION,
            true
        );
    }

    if ($block_helpers->it_is_not_amp()) {
        if (isset($attributes['iconTypeSelect']) && $attributes['iconTypeSelect'] === 'lottie') {
            wp_enqueue_script(
                'pbg-lottie',
                PREMIUM_BLOCKS_URL . 'assets/js/lib/lottie.min.js',
                array( 'jquery' ),
                PREMIUM_BLOCKS_VERSION,
                true
            );
        }
    }

    return $content;
}




/**
 * Register the bullet_list block.
 *
 * @uses render_block_pbg_bullet_list()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_bullet_list()
{
    if (! function_exists('register_block_type')) {
        return;
    }
    register_block_type(
        PREMIUM_BLOCKS_PATH . '/blocks-config/bullet-list',
        array(
            'render_callback' => 'render_block_pbg_bullet_list',
        )
    );
}

register_block_pbg_bullet_list();
