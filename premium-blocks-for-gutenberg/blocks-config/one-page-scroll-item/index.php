<?php
/**
 * Renders the `premium/one-page-scroll-item` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */

 function get_premium_one_page_scroll_item_css( $attributes, $unique_id ) {
	$css = new Premium_Blocks_css();
  
  $css->set_selector(".wp-block-premium-one-page-scroll .{$unique_id}.premium-one-page-scroll-item:not(:has(.animation-wrapper)):not(:has(div[id^='scroller-']))");
  $css->pbg_render_background($attributes, 'scrollItemBackground', 'Desktop');
  $css->pbg_render_spacing($attributes, 'scrollItemPadding', 'padding', 'Desktop');
  $css->pbg_render_spacing($attributes, 'scrollItemMargin', 'margin', 'Desktop');

  $css->set_selector(".wp-block-premium-one-page-scroll .{$unique_id}.premium-one-page-scroll-item div[id^='scroller-']:not(:has(.animation-wrapper))");
  $css->pbg_render_background($attributes, 'scrollItemBackground', 'Desktop');
  $css->pbg_render_spacing($attributes, 'scrollItemPadding', 'padding', 'Desktop');
  $css->pbg_render_spacing($attributes, 'scrollItemMargin', 'margin', 'Desktop');

  $css->set_selector(".wp-block-premium-one-page-scroll .{$unique_id}.premium-one-page-scroll-item .animation-wrapper");
  $css->pbg_render_background($attributes, 'scrollItemBackground', 'Desktop');
  $css->pbg_render_spacing($attributes, 'scrollItemPadding', 'padding', 'Desktop');
  $css->pbg_render_spacing($attributes, 'scrollItemMargin', 'margin', 'Desktop');

  $overlay_background = $css->pbg_get_value($attributes, 'scrollItemBackgroundOverlay.backgroundType') ?? '';

  $css->set_selector(
    ".wp-block-premium-one-page-scroll .{$unique_id}.premium-one-page-scroll-item:not(:has(.animation-wrapper)):not(:has(div[id^='scroller-']))::before, " .
    ".wp-block-premium-one-page-scroll .{$unique_id}.premium-one-page-scroll-item div[id^='scroller-']:not(:has(.animation-wrapper))::before, " .
    ".wp-block-premium-one-page-scroll .{$unique_id}.premium-one-page-scroll-item .animation-wrapper::before"
  );
  $css->pbg_render_background($attributes, 'scrollItemBackgroundOverlay', 'Desktop');
  if( $overlay_background === 'solid' || $overlay_background === 'gradient' ) {
    $css->pbg_render_range($attributes, 'overlayOpacity', 'opacity', null, 'calc(', ' / 100)');
    $css->pbg_render_filters($attributes, 'overlayFilter');
    $css->pbg_render_value($attributes, 'overlayBlendMode', 'mix-blend-mode');
  }

	// Tablet.
	$css->start_media_query( 'tablet' );

  $css->set_selector(".wp-block-premium-one-page-scroll .{$unique_id}.premium-one-page-scroll-item:not(:has(.animation-wrapper)):not(:has(div[id^='scroller-']))");
  $css->pbg_render_background($attributes, 'scrollItemBackground', 'Tablet');
  $css->pbg_render_spacing($attributes, 'scrollItemPadding', 'padding', 'Tablet');
  $css->pbg_render_spacing($attributes, 'scrollItemMargin', 'margin', 'Tablet');

  $css->set_selector(".wp-block-premium-one-page-scroll .{$unique_id}.premium-one-page-scroll-item div[id^='scroller-']:not(:has(.animation-wrapper))");
  $css->pbg_render_background($attributes, 'scrollItemBackground', 'Tablet');
  $css->pbg_render_spacing($attributes, 'scrollItemPadding', 'padding', 'Tablet');
  $css->pbg_render_spacing($attributes, 'scrollItemMargin', 'margin', 'Tablet');

  $css->set_selector(".wp-block-premium-one-page-scroll .{$unique_id}.premium-one-page-scroll-item .animation-wrapper");
  $css->pbg_render_background($attributes, 'scrollItemBackground', 'Tablet');
  $css->pbg_render_spacing($attributes, 'scrollItemPadding', 'padding', 'Tablet');
  $css->pbg_render_spacing($attributes, 'scrollItemMargin', 'margin', 'Tablet');

  $css->set_selector(
    ".wp-block-premium-one-page-scroll .{$unique_id}.premium-one-page-scroll-item:not(:has(.animation-wrapper)):not(:has(div[id^='scroller-']))::before, " .
    ".wp-block-premium-one-page-scroll .{$unique_id}.premium-one-page-scroll-item div[id^='scroller-']:not(:has(.animation-wrapper))::before, " .
    ".wp-block-premium-one-page-scroll .{$unique_id}.premium-one-page-scroll-item .animation-wrapper::before"
  );
  $css->pbg_render_background($attributes, 'scrollItemBackgroundOverlay', 'Tablet');
	
	$css->stop_media_query();
	$css->start_media_query( 'mobile' );

  $css->set_selector(".wp-block-premium-one-page-scroll .{$unique_id}.premium-one-page-scroll-item:not(:has(.animation-wrapper)):not(:has(div[id^='scroller-']))");
  $css->pbg_render_background($attributes, 'scrollItemBackground', 'Mobile');
  $css->pbg_render_spacing($attributes, 'scrollItemPadding', 'padding', 'Mobile');
  $css->pbg_render_spacing($attributes, 'scrollItemMargin', 'margin', 'Mobile');

  $css->set_selector(".wp-block-premium-one-page-scroll .{$unique_id}.premium-one-page-scroll-item div[id^='scroller-']:not(:has(.animation-wrapper))");
  $css->pbg_render_background($attributes, 'scrollItemBackground', 'Mobile');
  $css->pbg_render_spacing($attributes, 'scrollItemPadding', 'padding', 'Mobile');
  $css->pbg_render_spacing($attributes, 'scrollItemMargin', 'margin', 'Mobile');

  $css->set_selector(".wp-block-premium-one-page-scroll .{$unique_id}.premium-one-page-scroll-item .animation-wrapper");
  $css->pbg_render_background($attributes, 'scrollItemBackground', 'Mobile');
  $css->pbg_render_spacing($attributes, 'scrollItemPadding', 'padding', 'Mobile');
  $css->pbg_render_spacing($attributes, 'scrollItemMargin', 'margin', 'Mobile');

  $css->set_selector(
    ".wp-block-premium-one-page-scroll .{$unique_id}.premium-one-page-scroll-item:not(:has(.animation-wrapper)):not(:has(div[id^='scroller-']))::before, " .
    ".wp-block-premium-one-page-scroll .{$unique_id}.premium-one-page-scroll-item div[id^='scroller-']:not(:has(.animation-wrapper))::before, " .
    ".wp-block-premium-one-page-scroll .{$unique_id}.premium-one-page-scroll-item .animation-wrapper::before"
  );
  $css->pbg_render_background($attributes, 'scrollItemBackgroundOverlay', 'Mobile');
  
	$css->stop_media_query();

	return $css->css_output();
}

function render_block_pbg_one_page_scroll_item( $attributes, $content, $block ) {
	return $content;
}


function register_block_pbg_one_page_scroll_item() {
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
