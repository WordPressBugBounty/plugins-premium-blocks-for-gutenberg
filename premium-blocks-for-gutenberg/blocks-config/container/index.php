<?php

/**
 * Server-side rendering of the `pbg/container` block.
 *
 * @package WordPress
 */

/**
 * Get Container Block CSS
 *
 * Return Frontend CSS for Container.
 *
 * @access public
 *
 * @param string $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_container_css_style($attr, $unique_id)
{
    $css = new Premium_Blocks_css();

    $is_root_container = $css->pbg_get_value($attr, 'isBlockRootParent');
    $inner_width_type = $css->pbg_get_value($attr, 'innerWidthType');
    $inner_width_value = $css->pbg_get_value($attr, 'innerWidth');
    $overlay_background_type = $css->pbg_get_value($attr, 'backgroundOverlay.backgroundType');
    $overlay_background_hover_type = $css->pbg_get_value($attr, 'backgroundOverlayHover.backgroundType');

    // Non-responsive styles.
    $css->set_selector('.wp-block-premium-container.premium-container-' . $unique_id . ' , .wp-block-premium-container.premium-block-' . $unique_id);
    $css->pbg_render_shadow($attr, 'boxShadow', 'box-shadow');

    $css->set_selector('.wp-block-premium-container.premium-container-' . $unique_id . ':hover, .wp-block-premium-container.premium-block-' . $unique_id . ':hover');
    $css->pbg_render_shadow($attr, 'boxShadowHover', 'box-shadow');

    $css->set_selector('.premium-container-' . $unique_id . '::before , .premium-block-' . $unique_id . '::before');
    $css->pbg_render_value($attr, 'transition', 'transition-duration', null, null, 's');
    $css->pbg_render_value($attr, 'transition', '-webkit-transition', null, null, 's');
    $css->pbg_render_value($attr, 'transition', '-o-transition', null, null, 's');
    if ($overlay_background_type === 'solid' || $overlay_background_type === 'gradient') {
        $css->pbg_render_range($attr, 'overlayOpacity', 'opacity', null, 'calc(', ' / 100)');
        $css->pbg_render_filters($attr, 'overlayFilter');
        $css->pbg_render_value($attr, 'blend', 'mix-blend-mode');
    }

    $css->set_selector('.premium-container-' . $unique_id . ':hover::before , .premium-block-' . $unique_id . ':hover::before');
    if ($overlay_background_type === 'solid' || $overlay_background_type === 'gradient' || $overlay_background_hover_type === 'solid' || $overlay_background_hover_type === 'gradient') {
        $css->pbg_render_range($attr, 'hoverOverlayOpacity', 'opacity', null, 'calc(', ' / 100)');
        $css->pbg_render_filters($attr, 'hoverOverlayFilter');
    }

    // Shape colors (non-responsive).
    $css->set_selector('.wp-block-premium-container.premium-container-' . $unique_id . ' > .premium-top-shape svg , .wp-block-premium-container.premium-block-' . $unique_id . ' > .premium-top-shape svg');
    $css->pbg_render_color($attr, 'shapeTop.color', 'fill');

    $css->set_selector('.wp-block-premium-container.premium-container-' . $unique_id . ' > .premium-bottom-shape svg , .wp-block-premium-container.premium-block-' . $unique_id . ' > .premium-bottom-shape svg');
    $css->pbg_render_color($attr, 'shapeBottom.color', 'fill');

    // Static display:flex for root containers (non-responsive).
    $css->set_selector('.wp-block-premium-container.premium-is-root-container.premium-container-' . $unique_id . ' .premium-container-inner-blocks-wrap , .wp-block-premium-container.premium-is-root-container.premium-block-' . $unique_id . ' .premium-container-inner-blocks-wrap');
    $css->add_property('display', 'flex');

    // Responsive styles.
    $css->render_responsive(function ($css, $device) use ($attr, $unique_id, $is_root_container, $inner_width_type, $inner_width_value) {
        $current_direction = explode('-', $css->pbg_get_value($attr, 'direction', $device) ?? '')[0];
        $childsWidthValue = $css->pbg_get_value($attr, 'childsWidth', $device);

        $css->set_selector('.wp-block-premium-container.premium-container-' . $unique_id . ' , .wp-block-premium-container.premium-block-' . $unique_id);
        $css->pbg_render_range($attr, 'minHeight', 'min-height', $device);

        $css->set_selector('.wp-block-premium-container.premium-container-' . $unique_id . ' > .premium-container-inner-blocks-wrap, .wp-block-premium-container.premium-block-' . $unique_id . ' > .premium-container-inner-blocks-wrap');
        $css->pbg_render_value($attr, 'direction', 'flex-direction', $device);
        $css->pbg_render_value($attr, 'alignItems', 'align-items', $device);
        $css->pbg_render_value($attr, 'justifyItems', 'justify-content', $device);
        $css->pbg_render_value($attr, 'wrapItems', 'flex-wrap', $device);
        $css->pbg_render_value($attr, 'alignContent', 'align-content', $device);
        $css->pbg_render_range($attr, 'columnGutter', 'column-gap', $device);
        $css->pbg_render_range($attr, 'rowGutter', 'row-gap', $device);
        if ($inner_width_type === 'boxed') {
            // Handling backward compatibility for innerWidth -- This can be removed after a few releases and keep the responsive line only
            if (is_array($inner_width_value)) {
                $css->pbg_render_range($attr, 'innerWidth', '--inner-content-custom-width', $device, 'min(100vw,', ')');
            } else {
                $css->pbg_render_range($attr, 'innerWidth', '--inner-content-custom-width', null, 'min(100vw,', 'px)');
            }
            $css->add_property('max-width', 'var(--inner-content-custom-width)');
            $css->add_property('margin-left', 'auto');
            $css->add_property('margin-right', 'auto');
        }
        $css->set_selector('.wp-block-premium-container.premium-container-' . $unique_id . ' > .premium-container-inner-blocks-wrap > *, .wp-block-premium-container.premium-block-' . $unique_id . ' > .premium-container-inner-blocks-wrap > *');
        if ($device === 'Desktop') {
            if ($childsWidthValue === "equal" && $current_direction === "row") {
                $css->add_property('flex', '1 1 0%');
            }
        } else {
            if ($childsWidthValue === "equal" && $current_direction === "row") {
                $css->add_property('flex', '1 1 0%');
            } else {
                $css->add_property('flex', 'initial');
            }
        }

        $css->set_selector(
            ".premium-container-{$unique_id}.premium-is-root-container.alignnone, " .
        ".premium-block-{$unique_id}.premium-is-root-container.alignnone, " .
        ".premium-container-{$unique_id}:not(.premium-is-root-container), " .
        ".premium-block-{$unique_id}:not(.premium-is-root-container)"
        );
        $css->pbg_render_range($attr, 'colWidth', 'width', $device, null, '!important');
        if ($device === 'Desktop') {
            $css->add_property('max-width', '100%');
        }

        $css->set_selector('.wp-block-premium-container.premium-container-' . $unique_id . ' > .premium-top-shape svg , .wp-block-premium-container.premium-block-' . $unique_id . ' > .premium-top-shape svg');
        $css->pbg_render_range($attr, 'shapeTop.width', 'width', $device);
        $css->pbg_render_range($attr, 'shapeTop.height', 'height', $device);

        $css->set_selector('.wp-block-premium-container.premium-container-' . $unique_id . ' > .premium-bottom-shape svg , .wp-block-premium-container.premium-block-' . $unique_id . ' > .premium-bottom-shape svg');
        $css->pbg_render_range($attr, 'shapeBottom.width', 'width', $device);
        $css->pbg_render_range($attr, 'shapeBottom.height', 'height', $device);

        $css->set_selector('.wp-block-premium-container.premium-container-' . $unique_id . ' , .wp-block-premium-container.premium-block-' . $unique_id);
        $css->pbg_render_background($attr, 'backgroundOptions', $device);
        $css->pbg_render_border($attr, 'border', $device);
        $css->pbg_render_spacing($attr, 'padding', 'padding', $device);
        if (!$is_root_container) {
            $css->pbg_render_spacing($attr, 'margin', 'margin', $device);
        }

        $css->set_selector('.wp-block-premium-container.premium-is-root-container.premium-container-' . $unique_id . ' , .wp-block-premium-container.premium-is-root-container.premium-block-' . $unique_id);
        $css->pbg_render_range($attr, 'rootMarginTop', 'margin-top', $device);
        $css->pbg_render_range($attr, 'rootMarginTop', 'margin-block-start', $device);
        $css->pbg_render_range($attr, 'rootMarginBottom', 'margin-bottom', $device);
        $css->pbg_render_range($attr, 'rootMarginBottom', 'margin-block-end', $device);

        $css->set_selector('.wp-block-premium-container.premium-container-' . $unique_id . ':hover, .wp-block-premium-container.premium-block-' . $unique_id . ':hover');
        $css->pbg_render_border($attr, 'borderHover', $device);

        $css->set_selector('.premium-container-' . $unique_id . '::before , .premium-block-' . $unique_id . '::before');
        $css->pbg_render_background($attr, 'backgroundOverlay', $device);

        $css->set_selector('.premium-container-' . $unique_id . ':hover::before , .premium-block-' . $unique_id . ':hover::before');
        $css->pbg_render_background($attr, 'backgroundOverlayHover', $device);
    });

    return $css->css_output();
}

/**
 * Renders the `premium/container` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_container($attributes, $content, $block)
{
    $block_helpers   = pbg_blocks_helper();
    $global_features = apply_filters('pb_global_features', get_option('pbg_global_features', array()));

    if ($global_features['premium-equal-height'] && isset($attributes['equalHeight']) && $attributes['equalHeight']) {
        add_filter(
            'premium_equal_height_localize_script',
            function ($data) use ($attributes) {
                $allowedAttributes = ['customSelectors', 'equalHeightBlocks', 'equalHeightDevices'];

                $filteredAttributes = array_intersect_key(
                    $attributes,
                    array_flip($allowedAttributes)
                );

                $data[$attributes['block_id']] = array(
                    'attributes' => $filteredAttributes,
                );
                return $data;
            }
        );

        wp_enqueue_script(
            'premium-equal-height-view',
            PREMIUM_BLOCKS_URL . 'assets/js/build/equal-height/index.js',
            array(),
            PREMIUM_BLOCKS_VERSION,
            true
        );

        $media_query            = array();
        $media_query['mobile']  = apply_filters('Premium_BLocks_mobile_media_query', '(max-width: 767px)');
        $media_query['tablet']  = apply_filters('Premium_BLocks_tablet_media_query', '(max-width: 1024px)');
        $media_query['desktop'] = apply_filters('Premium_BLocks_desktop_media_query', '(min-width: 1025px)');

        $data = apply_filters(
            "premium_equal_height_localize_script",
            array(
            'breakPoints' => $media_query,
        )
        );

        wp_scripts()->add_data('premium-equal-height-view', 'before', array());

        wp_add_inline_script(
            'premium-equal-height-view',
            'var PBG_EqualHeight= ' . wp_json_encode($data) . ';',
            'before'
        );
    }

    return $content;
}




/**
 * Register the container block.
 *
 * @uses render_block_pbg_container()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_container()
{
    if (! function_exists('register_block_type')) {
        return;
    }
    register_block_type(
        PREMIUM_BLOCKS_PATH . '/blocks-config/container',
        array(
            'render_callback' => 'render_block_pbg_container',
        )
    );
}

register_block_pbg_container();
