<?php
/**
 * Server-side rendering of the `pbg/button-group` block.
 *
 * @package WordPress
 */

/**
 * Get Button Group Block CSS
 *
 * Return Frontend CSS for Button Group.
 *
 * @access public
 *
 * @param string $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_button_group_css_style( $attr, $unique_id ) {
	$css = new Premium_Blocks_css();

	if ( isset( $attr['align'] ) ) {
		$content_align      = $css->get_responsive_css( $attr['align'], 'Desktop' );
		$content_flex_align = 'left' === $content_align ? 'flex-start' : 'center';
		$content_flex_align = 'right' === $content_align ? 'flex-end' : $content_flex_align;

		$css->set_selector( $unique_id );
		$css->add_property( 'text-align', $content_align );
        	$css->add_property( 'align-self',  $css->render_align_self($content_align) );

		$css->set_selector( $unique_id . ' > .premium-button-group_wrap.premium-button-group-class-css' );
		$css->add_property( 'justify-content', $content_align );
		$css->add_property( 'align-items',  $css->render_align_self($content_align) );
	}
	if ( isset( $attr['groupAlign'] ) ) {
		$content_align      = $css->get_responsive_css( $attr['groupAlign'], 'Desktop' );
		$content_flex_align = 'horizontal' === $content_align ? 'row' : 'column';

		$css->set_selector( $unique_id . ' > .premium-button-group_wrap' );
		$css->add_property( 'flex-direction', $content_flex_align );
	}
	if ( isset( $attr['buttonGap'] ) ) {
		$css->set_selector( $unique_id . ' > .premium-button-group_wrap' );
		$css->add_property( 'column-gap', $css->get_responsive_css( $attr['buttonGap'], 'Desktop' ) . 'px !important' );
		$css->add_property( 'row-gap', $css->get_responsive_css( $attr['buttonGap'], 'Desktop' ) . 'px !important' );
	}

	if ( isset( $attr['typography'] ) ) {
		$typography = $attr['typography'];
		$css->set_selector( $unique_id . ' .premium-button-text-edit' );
		$css->render_typography( $typography, 'Desktop' );
	}

	if ( isset( $attr['groupPadding'] ) ) {
		$groupPadding = $attr['groupPadding'];
		$css->set_selector( $unique_id . ' .premium-button' );
		$css->add_property( 'padding', $css->render_spacing( $groupPadding['Desktop'], isset($groupPadding['unit']['Desktop'])?$groupPadding['unit']['Desktop']:$groupPadding['unit']  ) );
	}

	if ( isset( $attr['groupMargin'] ) ) {
		$groupMargin = $attr['groupMargin'];
		$css->set_selector( $unique_id . ' .premium-button-group_wrap' );
		$css->add_property( 'margin', $css->render_spacing( $groupMargin['Desktop'], isset($groupMargin['unit']['Desktop'])?$groupMargin['unit']['Desktop']:$groupMargin['unit']  ) );
	}

	$css->start_media_query( 'tablet' );

	if ( isset( $attr['align'] ) ) {
		$content_align      = $css->get_responsive_css( $attr['align'], 'Tablet' );
		$content_flex_align = 'left' === $content_align ? 'flex-start' : 'center';
		$content_flex_align = 'right' === $content_align ? 'flex-end' : $content_flex_align;

		$css->set_selector( $unique_id );
		$css->add_property( 'text-align', $content_align );
   	$css->add_property( 'align-self',  $css->render_align_self($content_align) );
		$css->set_selector( $unique_id . ' > .premium-button-group_wrap.premium-button-group-class-css' );
		$css->add_property( 'justify-content', $content_align );
		$css->add_property( 'align-items',  $css->render_align_self($content_align) );

	}
	if ( isset( $attr['groupAlign'] ) ) {
		$content_align      = $css->get_responsive_css( $attr['groupAlign'], 'Tablet' );
		$content_flex_align = 'horizontal' === $content_align ? 'row' : 'column';

		$css->set_selector( $unique_id . ' > .premium-button-group_wrap' );
		$css->add_property( 'flex-direction', $content_flex_align );
	}
	if ( isset( $attr['buttonGap'] ) ) {
		$css->set_selector( $unique_id . ' > .premium-button-group_wrap' );
		$css->add_property( 'column-gap', $css->get_responsive_css( $attr['buttonGap'], 'Tablet' ) . 'px !important' );
		$css->add_property( 'row-gap', $css->get_responsive_css( $attr['buttonGap'], 'Tablet' ) . 'px !important' );
	}

	if ( isset( $attr['typography'] ) ) {
		$typography = $attr['typography'];
		$css->set_selector( $unique_id . ' .premium-button-text-edit' );
		$css->render_typography( $typography, 'Tablet' );
	}

	if ( isset( $attr['groupPadding'] ) ) {
		$groupPadding = $attr['groupPadding'];
		$css->set_selector( $unique_id . ' .premium-button' );
		$css->add_property( 'padding', $css->render_spacing( $groupPadding['Tablet'], isset($groupPadding['unit']['Tablet'])?$groupPadding['unit']['Tablet']:$groupPadding['unit']  ) );
	}

	if ( isset( $attr['groupMargin'] ) ) {
		$groupMargin = $attr['groupMargin'];
		$css->set_selector( $unique_id . ' .premium-button-group_wrap' );
		$css->add_property( 'margin', $css->render_spacing( $groupMargin['Tablet'], isset($groupMargin['unit']['Tablet'])?$groupMargin['unit']['Tablet']:$groupMargin['unit']  ) );
	}

	$css->stop_media_query();
	$css->start_media_query( 'mobile' );

	if ( isset( $attr['align'] ) ) {
		$content_align      = $css->get_responsive_css( $attr['align'], 'Mobile' );
		$content_flex_align = 'left' === $content_align ? 'flex-start' : 'center';
		$content_flex_align = 'right' === $content_align ? 'flex-end' : $content_flex_align;

		$css->set_selector( $unique_id );
		$css->add_property( 'text-align', $content_align );
   	$css->add_property( 'align-self',  $css->render_align_self($content_align) );
		$css->set_selector( $unique_id . ' > .premium-button-group_wrap.premium-button-group-class-css' );
		$css->add_property( 'justify-content', $content_align );
		$css->add_property( 'align-items',  $css->render_align_self($content_align) );

	}
	if ( isset( $attr['groupAlign'] ) ) {
		$content_align      = $css->get_responsive_css( $attr['groupAlign'], 'Mobile' );
		$content_flex_align = 'horizontal' === $content_align ? 'row' : 'column';

		$css->set_selector( $unique_id . ' > .premium-button-group_wrap' );
		$css->add_property( 'flex-direction', $content_flex_align );
	}
	if ( isset( $attr['buttonGap'] ) ) {
		$css->set_selector( $unique_id . ' > .premium-button-group_wrap' );
		$css->add_property( 'column-gap', $css->get_responsive_css( $attr['buttonGap'], 'Mobile' ) . 'px !important' );
		$css->add_property( 'row-gap', $css->get_responsive_css( $attr['buttonGap'], 'Mobile' ) . 'px !important' );
	}

	if ( isset( $attr['typography'] ) ) {
		$typography = $attr['typography'];
		$css->set_selector( $unique_id . ' .premium-button-text-edit' );
		$css->render_typography( $typography, 'Mobile' );
	}

	if ( isset( $attr['groupPadding'] ) ) {
		$groupPadding = $attr['groupPadding'];
		$css->set_selector( $unique_id . ' .premium-button' );
		$css->add_property( 'padding', $css->render_spacing( $groupPadding['Mobile'], isset($groupPadding['unit']['Mobile'])?$groupPadding['unit']['Mobile']:$groupPadding['unit']  ) );
	}

	if ( isset( $attr['groupMargin'] ) ) {
		$groupMargin = $attr['groupMargin'];
    $css->set_selector( $unique_id . ' .premium-button-group_wrap' );
		$css->add_property( 'margin', $css->render_spacing( $groupMargin['Mobile'], isset($groupMargin['unit']['Mobile'])?$groupMargin['unit']['Mobile']:$groupMargin['unit']  ) );
	}
	$css->stop_media_query();
	return $css->css_output();
}

/**
 * Renders the `premium/button` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_button_group( $attributes, $content, $block ) {
	return $content;
}




/**
 * Register the button block.
 *
 * @uses render_block_pbg_button_group()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_button_group() {
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	register_block_type(
		PREMIUM_BLOCKS_PATH . '/blocks-config/buttons',
		array(
			'render_callback' => 'render_block_pbg_button_group',
		)
	);
}

register_block_pbg_button_group();