<?php
// Move this file to "blocks-config" folder with name "instagram-feed-header.php".

/**
 * Server-side rendering of the `premium/instagram-feed-header` block.
 *
 * @package WordPress
 */

function get_premium_instagram_feed_header_css( $attributes, $unique_id ) {
	$css = new Premium_Blocks_css();

	// Desktop Styles.
	if ( isset( $attributes['border'] ) ) {
		$border        = $attributes['border'];
		$border_width  = $attributes['border']['borderWidth'];
		$border_radius = $attributes['border']['borderRadius'];

		$css->set_selector( '.' . $unique_id );
		$css->add_property( 'border-width', $css->render_spacing( $border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $border_radius['Desktop'], 'px' ) );
		$css->add_property( 'border-style', $css->render_string( $border['borderType'] ) );
		$css->add_property( 'border-color', $css->render_color( $border['borderColor'] ) );
	}

	if ( isset( $attributes['padding'] ) ) {
		$padding = $attributes['padding'];

		$css->set_selector( '.' . $unique_id );
		$css->add_property( 'padding', $css->render_spacing( $padding['Desktop'], isset($padding['unit']['Desktop'])? $padding['unit']['Desktop']:$padding['unit'] ) );
	}

	if ( isset( $attributes['margin'] ) ) {
		$margin = $attributes['margin'];

		$css->set_selector( '.' . $unique_id );
		$css->add_property( 'margin', $css->render_spacing( $margin['Desktop'], isset($margin['unit']['Desktop'])? $margin['unit']['Desktop']:$margin['unit']) );
	}

	if ( isset( $attributes['background'] ) ) {
		$css->set_selector( '.' . $unique_id );
	    $css->render_background( $attributes['background'], 'Desktop' );

    }

	$css->start_media_query( 'tablet' );
	// Tablet Styles.
	if ( isset( $attributes['border'] ) ) {
		$border        = $attributes['border'];
		$border_width  = $attributes['border']['borderWidth'];
		$border_radius = $attributes['border']['borderRadius'];

		$css->set_selector( '.' . $unique_id );
		$css->add_property( 'border-width', $css->render_spacing( $border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $border_radius['Tablet'], 'px' ) );
	}

	if ( isset( $attributes['padding'] ) ) {
		$padding = $attributes['padding'];

		$css->set_selector( '.' . $unique_id );
		$css->add_property( 'padding', $css->render_spacing( $padding['Tablet'], isset($padding['unit']['Tablet'])? $padding['unit']['Tablet']:$padding['unit'] ) );
	}

	if ( isset( $attributes['margin'] ) ) {
		$margin = $attributes['margin'];

		$css->set_selector( '.' . $unique_id );
		$css->add_property( 'margin', $css->render_spacing( $margin['Tablet'], isset($margin['unit']['Tablet'])? $margin['unit']['Tablet']:$margin['unit'] ) );
	}

	$css->stop_media_query();
	$css->start_media_query( 'mobile' );
	// Mobile Styles.
	if ( isset( $attributes['border'] ) ) {
		$border        = $attributes['border'];
		$border_width  = $attributes['border']['borderWidth'];
		$border_radius = $attributes['border']['borderRadius'];

		$css->set_selector( '.' . $unique_id );
		$css->add_property( 'border-width', $css->render_spacing( $border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $border_radius['Mobile'], 'px' ) );
	}

	if ( isset( $attributes['padding'] ) ) {
		$padding = $attributes['padding'];

		$css->set_selector( '.' . $unique_id );
		$css->add_property( 'padding', $css->render_spacing( $padding['Mobile'],isset($padding['unit']['Mobile'])? $padding['unit']['Mobile']:$padding['unit'] ) );
	}

	if ( isset( $attributes['margin'] ) ) {
		$margin = $attributes['margin'];

		$css->set_selector( '.' . $unique_id );
		$css->add_property( 'margin', $css->render_spacing( $margin['Mobile'], isset($margin['unit']['Mobile'])? $margin['unit']['Mobile']:$margin['unit'] ) );
	}

	$css->stop_media_query();

	return $css->css_output();
}

/**
 * Renders the `premium/instagram-feed-header` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_instagram_feed_header( $attributes, $content, $block ) {

	return $content;
}


/**
 * Register the Instagram Feed Header block.
 *
 * @uses render_block_pbg_instagram_feed_header()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_instagram_feed_header() {
	register_block_type(
		PREMIUM_BLOCKS_PATH . 'blocks-config/instagram-feed-header',
		array(
			'render_callback' => 'render_block_pbg_instagram_feed_header',
		)
	);
}

register_block_pbg_instagram_feed_header();


