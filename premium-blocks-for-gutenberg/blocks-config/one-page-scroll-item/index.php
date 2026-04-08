<?php

/**
 * Get One Page Scroll Item Block CSS
 *
 * Return Frontend CSS for One Page Scroll Item.
 *
 * @param array  $attributes The block attributes.
 * @param string $unique_id  The block ID.
 *
 * @return string Returns the CSS styles.
 */

function get_premium_one_page_scroll_item_css($attributes, $unique_id)
{
    $css = new Premium_Blocks_css();

    $overlay_background = $css->pbg_get_value($attributes, 'scrollItemBackgroundOverlay.backgroundType') ?? '';

    // Non-responsive overlay opacity/filters stay outside (Desktop-only).
    if ($overlay_background === 'solid' || $overlay_background === 'gradient') {
        $css->set_selector(
            ".wp-block-premium-one-page-scroll .{$unique_id}.premium-one-page-scroll-item:not(:has(.animation-wrapper)):not(:has(div[id^='scroller-']))::before, " .
      ".wp-block-premium-one-page-scroll .{$unique_id}.premium-one-page-scroll-item div[id^='scroller-']:not(:has(.animation-wrapper))::before, " .
      ".wp-block-premium-one-page-scroll .{$unique_id}.premium-one-page-scroll-item .animation-wrapper::before"
        );
        $css->pbg_render_range($attributes, 'overlayOpacity', 'opacity', null, 'calc(', ' / 100)');
        $css->pbg_render_filters($attributes, 'overlayFilter');
        $css->pbg_render_value($attributes, 'overlayBlendMode', 'mix-blend-mode');
    }

    // Responsive styles.
    $css->render_responsive(function ($css, $device) use ($attributes, $unique_id) {
        $css->set_selector(".wp-block-premium-one-page-scroll .{$unique_id}.premium-one-page-scroll-item:not(:has(.animation-wrapper)):not(:has(div[id^='scroller-']))");
        $css->pbg_render_background($attributes, 'scrollItemBackground', $device);
        $css->pbg_render_spacing($attributes, 'scrollItemPadding', 'padding', $device);
        $css->pbg_render_spacing($attributes, 'scrollItemMargin', 'margin', $device);

        $css->set_selector(".wp-block-premium-one-page-scroll .{$unique_id}.premium-one-page-scroll-item div[id^='scroller-']:not(:has(.animation-wrapper))");
        $css->pbg_render_background($attributes, 'scrollItemBackground', $device);
        $css->pbg_render_spacing($attributes, 'scrollItemPadding', 'padding', $device);
        $css->pbg_render_spacing($attributes, 'scrollItemMargin', 'margin', $device);

        $css->set_selector(".wp-block-premium-one-page-scroll .{$unique_id}.premium-one-page-scroll-item .animation-wrapper");
        $css->pbg_render_background($attributes, 'scrollItemBackground', $device);
        $css->pbg_render_spacing($attributes, 'scrollItemPadding', 'padding', $device);
        $css->pbg_render_spacing($attributes, 'scrollItemMargin', 'margin', $device);

        $css->set_selector(
            ".wp-block-premium-one-page-scroll .{$unique_id}.premium-one-page-scroll-item:not(:has(.animation-wrapper)):not(:has(div[id^='scroller-']))::before, " .
      ".wp-block-premium-one-page-scroll .{$unique_id}.premium-one-page-scroll-item div[id^='scroller-']:not(:has(.animation-wrapper))::before, " .
      ".wp-block-premium-one-page-scroll .{$unique_id}.premium-one-page-scroll-item .animation-wrapper::before"
        );
        $css->pbg_render_background($attributes, 'scrollItemBackgroundOverlay', $device);
    });

    return $css->css_output();
}

function render_block_pbg_one_page_scroll_item($attributes, $content, $block)
{
    return $content;
}


function register_block_pbg_one_page_scroll_item()
{
    register_block_type(
        'premium/one-page-scroll-item',
        array(
            'render_callback' => 'render_block_pbg_one_page_scroll_item',
            'editor_style'    => 'premium-blocks-editor-css',
            'editor_script'   => 'pbg-blocks-js',
        )
    );
}

register_block_pbg_one_page_scroll_item();
