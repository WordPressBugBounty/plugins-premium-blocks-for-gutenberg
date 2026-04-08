<?php

/**
 * Get Tabs Block CSS
 *
 * Return Frontend CSS for Tabs.
 *
 * @access public
 *
 * @param string $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_tabs_css_style($attr, $unique_id)
{
    $css = new Premium_Blocks_css();

    $tabs_type = $css->pbg_get_value($attr, 'tabsTypes');
    $tabs_style = $css->pbg_get_value($attr, 'tabStyle');
    $title_tabs = $css->pbg_get_value($attr, 'titleTabs');
    $icon_position = $css->pbg_get_value($attr, 'iconPosition');
    $stretch_tabs = $css->pbg_get_value($attr, 'stretchTabs');

    // Non-responsive styles - shadows and colors.
    $css->set_selector($unique_id . ".premium-tabs-style-style2 .premium-tabs-nav li .active-line");
    if ($tabs_style === 'style2') {
        $css->pbg_render_color($attr, 'bottomColor', 'background-color');
    }

    $css->set_selector($unique_id . '.premium-tabs-style-style3 ul.premium-tabs-horizontal li::after, ' . $unique_id . '.premium-tabs-style-style3 ul.premium-tabs-vertical li::after');
    $css->pbg_render_color($attr, 'sepColor', 'background-color');

    $css->set_selector($unique_id . " .premium-tabs-nav ul li .premium-tab-link");
    $css->pbg_render_shadow($attr, 'tabShadow', 'filter', 'drop-shadow(', ')');

    $css->set_selector($unique_id . " .premium-tabs-nav ul li.active .premium-tab-link");
    $css->pbg_render_shadow($attr, 'tabActiveShadow', 'filter', 'drop-shadow(', ')');

    $css->set_selector($unique_id . " .premium-tabs-nav ul li:not(.active):hover .premium-tab-link");
    $css->pbg_render_shadow($attr, 'tabHoverShadow', 'filter', 'drop-shadow(', ')');

    $css->set_selector(
        "{$unique_id} .premium-tabs-nav .premium-tab-link .premium-icon-type, " .
    "{$unique_id} .premium-tabs-nav .premium-tab-link img, " .
    "{$unique_id} .premium-tabs-nav .premium-tab-link .premium-tabs-svg-class svg, " .
    "{$unique_id} .premium-tabs-nav .premium-tab-link .premium-lottie-animation svg"
    );
    $css->pbg_render_shadow($attr, 'iconShadow', 'filter', 'drop-shadow(', ')');

    $css->set_selector(
        "{$unique_id} .premium-tabs-nav .premium-tab-link .premium-icon-type, " .
    "{$unique_id} .premium-tabs-nav .premium-tab-link .premium-icon-type:not(.icon-type-fe) svg, " .
    "{$unique_id} .premium-tabs-nav .premium-tab-link .premium-icon-type:not(.icon-type-fe) svg *, " .
    "{$unique_id} .premium-tabs-nav .premium-tab-link .premium-tabs-svg-class svg, " .
    "{$unique_id} .premium-tabs-nav .premium-tab-link .premium-tabs-svg-class svg *"
    );
    $css->pbg_render_color($attr, 'iconColor', 'color');
    $css->pbg_render_color($attr, 'iconColor', 'fill');

    $css->set_selector(
        "{$unique_id} .premium-tabs-nav .premium-tab-link .premium-icon-type, " .
    "{$unique_id} .premium-tabs-nav .premium-tab-link .premium-tabs-svg-class svg, " .
    "{$unique_id} .premium-tabs-nav .premium-tab-link .premium-lottie-animation svg"
    );
    $css->pbg_render_color($attr, 'iconBackground', 'background-color');

    $css->set_selector(
        "{$unique_id} .premium-tabs-nav li:hover .premium-tab-link .premium-icon-type, " .
    "{$unique_id} .premium-tabs-nav li:hover .premium-tab-link .premium-icon-type:not(.icon-type-fe) svg *, " .
    "{$unique_id} .premium-tabs-nav li:hover .premium-tab-link .premium-tabs-svg-class svg, " .
    "{$unique_id} .premium-tabs-nav li:hover .premium-tab-link .premium-tabs-svg-class svg *"
    );
    $css->pbg_render_color($attr, 'iconHoverColor', 'color');
    $css->pbg_render_color($attr, 'iconHoverColor', 'fill');

    $css->set_selector(
        "{$unique_id} .premium-tabs-nav li:hover .premium-tab-link .premium-icon-type, " .
    "{$unique_id} .premium-tabs-nav li:hover .premium-tab-link .premium-tabs-svg-class svg, " .
    "{$unique_id} .premium-tabs-nav li:hover .premium-tab-link .premium-lottie-animation svg"
    );
    $css->pbg_render_color($attr, 'iconHoverBackground', 'background-color');

    $css->set_selector(
        "{$unique_id} .premium-tabs-nav li.active .premium-tab-link .premium-icon-type, " .
    "{$unique_id} .premium-tabs-nav li.active .premium-tab-link .premium-icon-type:not(.icon-type-fe) svg *, " .
    "{$unique_id} .premium-tabs-nav li.active .premium-tab-link .premium-tabs-svg-class svg, " .
    "{$unique_id} .premium-tabs-nav li.active .premium-tab-link .premium-tabs-svg-class svg *"
    );
    $css->pbg_render_color($attr, 'iconActiveColor', 'color');
    $css->pbg_render_color($attr, 'iconActiveColor', 'fill');

    $css->set_selector(
        "{$unique_id} .premium-tabs-nav li.active .premium-tab-link .premium-icon-type, " .
    "{$unique_id} .premium-tabs-nav li.active .premium-tab-link .premium-tabs-svg-class svg, " .
    "{$unique_id} .premium-tabs-nav li.active .premium-tab-link .premium-lottie-animation svg"
    );
    $css->pbg_render_color($attr, 'iconActiveBackground', 'background-color');

    $css->set_selector($unique_id . " .premium-tabs-nav .premium-tab-link .premium-tab-title-container .premium-tab-title");
    $css->pbg_render_shadow($attr, 'titleShadow', 'text-shadow');
    $css->pbg_render_color($attr, 'titleColor', 'color');

    $css->set_selector($unique_id . " .premium-tabs-nav-list-item:hover  .premium-tab-link .premium-tab-title-container .premium-tab-title");
    $css->pbg_render_color($attr, 'titleHoverColor', 'color');

    $css->set_selector($unique_id . " .active .premium-tab-title");
    $css->pbg_render_color($attr, 'titleActiveColor', 'color', null, '!important');

    $css->set_selector($unique_id . " .premium-tabs-nav .premium-tab-link .premium-tab-title-container .premium-tab-desc");
    $css->pbg_render_shadow($attr, 'subShadow', 'text-shadow');
    $css->pbg_render_color($attr, 'subColor', 'color');

    $css->set_selector($unique_id . " .premium-tabs-nav-list-item:hover .premium-tab-link .premium-tab-title-container .premium-tab-desc");
    $css->pbg_render_color($attr, 'subHoverColor', 'color');

    $css->set_selector($unique_id . " .active .premium-tab-desc");
    $css->pbg_render_color($attr, 'subActiveColor', 'color', null, '!important');

    $css->set_selector($unique_id . " .premium-tab-content");
    $css->pbg_render_shadow($attr, 'descBoxShadow', 'box-shadow');

    if ($tabs_style === 'style3') {
        $css->set_selector($unique_id . ".premium-tabs-style-style3 .premium-tabs-nav ul.premium-tabs-nav-list");
        $css->pbg_render_color($attr, 'wrapBackColor', 'background-color');
        $css->pbg_render_shadow($attr, 'wrapBoxShadow', 'box-shadow');
    }

    $css->set_selector($unique_id);
    $css->pbg_render_color($attr, 'containerBackColor', 'background-color');
    $css->pbg_render_shadow($attr, 'containerBoxShadow', 'box-shadow');

    // Responsive styles.
    $css->render_responsive(function ($css, $device) use ($attr, $unique_id, $tabs_type, $tabs_style, $title_tabs, $icon_position, $stretch_tabs) {
        $tabs_align = $css->pbg_get_value($attr, 'tabsAlign', $device);

        $css->set_selector($unique_id . ' .premium-tabs-nav .premium-tabs-nav-list');
        $css->pbg_render_value($attr, 'menuAlign', 'justify-content', $device);

        $css->set_selector("{$unique_id}:not(.premium-tabs-icon-column) .premium-tab-link");
        if ($stretch_tabs) {
            $css->pbg_render_value($attr, 'menuAlign', 'justify-content', $device);
        } else {
            $css->pbg_render_value($attr, 'tabsAlign', 'justify-content', $device);
        }

        $css->set_selector("{$unique_id}.premium-tabs-icon-column .premium-tab-link");
        if ($stretch_tabs) {
            $css->pbg_render_value($attr, 'menuAlign', 'align-items', $device);
        } else {
            $css->pbg_render_value($attr, 'tabsAlign', 'align-items', $device);
        }

        $css->set_selector("{$unique_id}  .premium-tab-link .premium-tab-title-container");
        if ($stretch_tabs) {
            if (!empty($tabs_align)) {
                if ($tabs_align === 'center') {
                    $css->add_property('align-items', 'center');
                    $css->add_property('text-align', 'center');
                } else {
                    $css->add_property('align-items', $tabs_align);
                    $text_align = ($tabs_align === 'flex-start') ? 'left' : (($tabs_align === 'flex-end') ? 'right' : 'center');
                    $css->add_property('text-align', $text_align);
                }
            } else {
                $css->pbg_render_value($attr, 'tabsAlign', 'align-items', $device);
                if ($icon_position === 'row-reverse') {
                    $align_value = $css->pbg_get_value($attr, 'tabsAlign', $device);
                    if ($align_value === 'flex-start') {
                        $css->add_property('align-items', 'flex-end');
                    } elseif ($align_value === 'flex-end') {
                        $css->add_property('align-items', 'flex-start');
                    } elseif ($align_value === 'center') {
                        $css->add_property('align-items', 'center');
                    }
                }
            }
        } else {
            $css->pbg_render_value($attr, 'tabsAlign', 'align-items', $device);
            if ($icon_position === 'row-reverse') {
                $align_value = $css->pbg_get_value($attr, 'tabsAlign', $device);
                if ($align_value === 'flex-start') {
                    $css->add_property('align-items', 'flex-end');
                } elseif ($align_value === 'flex-end') {
                    $css->add_property('align-items', 'flex-start');
                } elseif ($align_value === 'center') {
                    $css->add_property('align-items', 'center');
                }
            }
        }

        if ($tabs_type === 'vertical') {
            $css->set_selector("{$unique_id} .premium-content-wrap");
            $css->pbg_render_value($attr, 'tabVerticalAlign', 'align-self', $device);
        }

        if ($tabs_style === 'style2') {
            $css->set_selector($unique_id . ".premium-tabs-style-style2 .premium-tabs-nav.horizontal li .active-line");
            $css->pbg_render_range($attr, 'circleSize', 'height', $device);
            $css->set_selector($unique_id . ".premium-tabs-style-style2 .premium-tabs-nav.vertical li .active-line");
            $css->pbg_render_range($attr, 'circleSize', 'width', $device);
        }

        $css->set_selector($unique_id . ".premium-tabs-vertical .premium-tabs-nav");
        $css->pbg_render_range($attr, 'tabsWidth', 'width', $device);

        $css->set_selector($unique_id . ".premium-tabs-vertical .premium-content-wrap");
        $css->pbg_render_range($attr, 'tabsWidth', 'width', $device, 'calc(100% - ', ')');

        $css->set_selector($unique_id . ".premium-tabs-vertical ");
        $css->pbg_render_range($attr, 'tabGap', 'gap', $device);

        $css->set_selector($unique_id . ".premium-tabs-horizontal .premium-tabs-nav ");
        $css->pbg_render_range($attr, 'tabGap', 'margin-bottom', $device);

        $css->set_selector($unique_id . " .premium-tabs-nav ul li .premium-tab-link");
        $css->pbg_render_border($attr, 'tabBorder', $device);
        $css->pbg_render_background($attr, 'backColor', $device);
        $css->pbg_render_spacing($attr, 'tabPadding', 'padding', $device);
        $css->pbg_render_spacing($attr, 'tabMargin', 'margin', $device);

        $css->set_selector($unique_id . " .premium-tabs-nav ul li.active .premium-tab-link");
        $css->pbg_render_border($attr, 'tabActiveBorder', $device);
        $css->pbg_render_background($attr, 'BackActiveColor', $device);
        $css->pbg_render_spacing($attr, 'tabActivePadding', 'padding', $device);
        $css->pbg_render_spacing($attr, 'tabActiveMargin', 'margin', $device);

        $css->set_selector($unique_id . " .premium-tabs-nav ul li:not(.active):hover .premium-tab-link");
        $css->pbg_render_border($attr, 'tabBorderHover', $device);
        $css->pbg_render_background($attr, 'backHover', $device);
        $css->pbg_render_spacing($attr, 'tabHoverPadding', 'padding', $device);
        $css->pbg_render_spacing($attr, 'tabHoverMargin', 'margin', $device);

        // Icon Styles.
        if (is_array($title_tabs)) {
            foreach ($title_tabs as $index => $tab) {
                $css->set_selector("{$unique_id} .premium-tabs-nav #premium-tabs__tab{$index} .premium-tab-link svg");
                $css->pbg_render_range($tab, 'iconSize', 'width', $device, null, '!important');
                $css->pbg_render_range($tab, 'iconSize', 'height', $device, null, '!important');

                $css->set_selector("{$unique_id} .premium-tabs-nav #premium-tabs__tab{$index} .premium-tab-link img");
                $css->pbg_render_range($tab, 'iconSize', 'width', $device, null, '!important');
            }
        }

        $css->set_selector(
            "{$unique_id} .premium-tabs-nav .premium-tab-link .premium-icon-type, " .
      "{$unique_id} .premium-tabs-nav .premium-tab-link img, " .
      "{$unique_id} .premium-tabs-nav .premium-tab-link .premium-tabs-svg-class svg, " .
      "{$unique_id} .premium-tabs-nav .premium-tab-link .premium-lottie-animation svg"
        );
        $css->pbg_render_border($attr, 'iconBorder', $device);
        $css->pbg_render_spacing($attr, 'iconPadding', 'padding', $device);
        $css->pbg_render_spacing($attr, 'iconMargin', 'margin', $device);

        // Icon Hovering Styles.
        $css->set_selector(
            "{$unique_id} .premium-tabs-nav li:hover .premium-tab-link .premium-icon-type, " .
      "{$unique_id} .premium-tabs-nav li:hover .premium-tab-link .premium-tabs-svg-class svg, " .
      "{$unique_id} .premium-tabs-nav li:hover .premium-tab-link .premium-lottie-animation svg, " .
      "{$unique_id} .premium-tabs-nav li:hover .premium-tab-link img"
        );
        $css->pbg_render_border($attr, 'iconHoverBorder', $device);

        // Icon Active Styles.
        $css->set_selector(
            "{$unique_id} .premium-tabs-nav li.active .premium-tab-link .premium-icon-type, " .
      "{$unique_id} .premium-tabs-nav li.active .premium-tab-link .premium-tabs-svg-class svg, " .
      "{$unique_id} .premium-tabs-nav li.active .premium-tab-link .premium-lottie-animation svg, " .
      "{$unique_id} .premium-tabs-nav li.active .premium-tab-link img"
        );
        $css->pbg_render_border($attr, 'iconActiveBorder', $device);

        // Title styling.
        $css->set_selector($unique_id . " .premium-tabs-nav .premium-tab-link .premium-tab-title-container .premium-tab-title");
        $css->pbg_render_typography($attr, 'titleTypography', $device);
        $css->pbg_render_spacing($attr, 'titlePadding', 'padding', $device);
        $css->pbg_render_spacing($attr, 'titleMargin', 'margin', $device);
        $css->pbg_render_border($attr, 'titleBorder', $device);

        // Sub title styling.
        $css->set_selector($unique_id . " .premium-tabs-nav .premium-tab-link .premium-tab-title-container .premium-tab-desc");
        $css->pbg_render_typography($attr, 'subTypography', $device);
        $css->pbg_render_spacing($attr, 'subPadding', 'padding', $device);
        $css->pbg_render_spacing($attr, 'subMargin', 'margin', $device);
        $css->pbg_render_border($attr, 'subBorder', $device);

        // Description styling.
        $css->set_selector($unique_id . " .premium-tab-content");
        $css->pbg_render_background($attr, 'tabContentBackground', $device);
        $css->pbg_render_border($attr, 'descBorder', $device);
        $css->pbg_render_spacing($attr, 'descPadding', 'padding', $device);
        $css->pbg_render_spacing($attr, 'descMargin', 'margin', $device);

        // Tabs Wrap.
        if ($tabs_style === 'style3') {
            $css->set_selector($unique_id . ".premium-tabs-style-style3 .premium-tabs-nav ul.premium-tabs-nav-list");
            $css->pbg_render_border($attr, 'wrapBorder', $device);
            $css->pbg_render_spacing($attr, 'wrapPadding', 'padding', $device);
            $css->pbg_render_spacing($attr, 'wrapMargin', 'margin', $device);
        }

        // Container styling.
        $css->set_selector($unique_id);
        $css->pbg_render_border($attr, 'containerBorder', $device);
        $css->pbg_render_spacing($attr, 'containerPadding', 'padding', $device);

        $css->set_selector("body .entry-content {$unique_id}.premium-blocks-tabs");
        $css->pbg_render_spacing($attr, 'containerMargin', 'margin', $device);
    });

    return $css->css_output();
}

/**
 * Get Media Css.
 *
 * @return array<string, string> The media CSS styles.
 */
function get_premium_tabs_media_css()
{
    $media_css = array('desktop' => '', 'tablet' => '', 'mobile' => '');

    $media_css['tablet'] .= "
    .premium-blocks-tabs.premium-accordion-tabs-tablet .premium-tabs-nav-list {
      -webkit-flex-direction: column;
      -ms-flex-direction: column;
      flex-direction: column;
    }
    .premium-blocks-tabs.premium-accordion-tabs-tablet .premium-accordion-tab-content.inactive {
      display: none;
    }
    .premium-blocks-tabs.premium-accordion-tabs-tablet .premium-tabs-content-section.inactive {
      display: none;
      margin: 0 auto;
    }
    .premium-blocks-tabs.premium-accordion-tabs-tablet .premium-tabs-content-section.active {
      display: block !important;
    }
    .premium-blocks-tabs.premium-accordion-tabs-tablet .premium-accordion-tab-content.active {
      display: block !important;
    }
  ";

    $media_css['mobile'] .= "
    .premium-blocks-tabs.premium-tabs-vertical {
      display: block;
      float: none;
    }
    .premium-blocks-tabs.premium-tabs-vertical .premium-tabs-nav {
      width: 100% !important;
    }
    .premium-blocks-tabs.premium-tabs-vertical .premium-content-wrap {
      width: 100% !important;
    }
    .premium-blocks-tabs .premium-tabs-nav-list {
      flex-direction: column;
    }
    .premium-tabs-style-style3 .premium-tabs-nav-list.premium-tabs-horizontal li.premium-tabs-nav-list-item:not(:last-child):after {
      position: absolute;
      content: '';
      left: 20%;
      bottom: 0;
      top: 100%;
      z-index: 1;
      height: 1px;
      width: 60%;
      content: '';
    }
    .premium-blocks-tabs .premium-content-wrap.premium-tabs-vertical {
      max-width: 100%;
    }
    .premium-blocks-tabs.premium-accordion-tabs-mobile .premium-tabs-nav-list {
      -webkit-flex-direction: column;
      -ms-flex-direction: column;
      flex-direction: column;
    }
    .premium-blocks-tabs.premium-accordion-tabs-mobile .premium-accordion-tab-content.inactive {
      display: none;
    }
    .premium-blocks-tabs.premium-accordion-tabs-mobile .premium-tabs-content-section.inactive {
      display: none;
      margin: 0 auto;
    }
    .premium-blocks-tabs.premium-accordion-tabs-mobile .premium-tabs-content-section.active {
      display: block !important;
    }
    .premium-blocks-tabs.premium-accordion-tabs-mobile .premium-accordion-tab-content.active {
      display: block !important;
    }
  ";

    return $media_css;
}

/**
 * Renders the `premium/tabs` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */

function render_block_pbg_tabs($attributes, $content, $block)
{
    $block_helpers = pbg_blocks_helper();
    if ($block_helpers->it_is_not_amp()) {
        wp_enqueue_script(
            'pbg-tabs',
            PREMIUM_BLOCKS_URL . 'assets/js/minified/tabs.min.js',
            array(),
            PREMIUM_BLOCKS_VERSION,
            true
        );
    }

    $media_query = array();
    $media_query['mobile'] = apply_filters('Premium_BLocks_mobile_media_query', '(max-width: 767px)');
    $media_query['tablet'] = apply_filters('Premium_BLocks_tablet_media_query', '(max-width: 1024px)');
    $media_query['desktop'] = apply_filters('Premium_BLocks_desktop_media_query', '(min-width: 1025px)');

    $data = array(
      'breakPoints' => $media_query,
    );

    wp_scripts()->add_data('pbg-tabs', 'before', array());

    wp_add_inline_script(
        'pbg-tabs',
        'var PBG_TABS = ' . wp_json_encode($data) . ';',
        'before'
    );

    /*
      Handling new feature of WordPress 6.7.2 --> sizes='auto' for old versions that doesn't contain wp-image-{$id} class.
      This workaround can be omitted after a few subsequent releases around 25/3/2025
    */
    if (isset($attributes['titleTabs']) && is_array($attributes['titleTabs'])) {

        $image_tag = new WP_HTML_Tag_Processor($content);

        foreach ($attributes['titleTabs'] as $index => $tab) {
            // Check if this tab uses a lottie icon
            if (isset($tab['icon']['iconTypeSelect']) && $tab['icon']['iconTypeSelect'] === 'lottie') {
                wp_enqueue_script(
                    'pbg-lottie',
                    PREMIUM_BLOCKS_URL . 'assets/js/lib/lottie.min.js',
                    array('jquery'),
                    PREMIUM_BLOCKS_VERSION,
                    true
                );
            }

            // Skip if this tab doesn't use an image icon
            if (!isset($tab['icon']['iconTypeSelect']) || $tab['icon']['iconTypeSelect'] !== 'img') {
                continue;
            }

            // Skip if no image ID is provided
            if (empty($tab['icon']['imageID'])) {
                continue;
            }

            $image_id = $tab['icon']['imageID'];

            if (!$image_tag->next_tag(['tag_name' => 'img'])) {
                return $content;
            }

            $image_classnames = $image_tag->get_attribute('class') ?? '';

            if (!str_contains($image_classnames, "wp-image-{$image_id}")) {
                // Clean up
                $image_tag->remove_attribute('srcset');
                $image_tag->remove_attribute('sizes');
                $image_tag->remove_class('wp-image-undefined');

                // Add the wp-image class for automatically generate new srcset and sizes attributes
                $image_tag->add_class("wp-image-{$image_id}");
            }
        }

        return $image_tag->get_updated_html();
    }

    return $content;
}


/**
 * Register the Tabs block.
 *
 * @uses render_block_pbg_tabs()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_tabs()
{
    if (!function_exists('register_block_type')) {
        return;
    }
    register_block_type(
        PREMIUM_BLOCKS_PATH . '/blocks-config/tabs',
        array(
        'render_callback' => 'render_block_pbg_tabs',

    )
    );
}

register_block_pbg_tabs();
