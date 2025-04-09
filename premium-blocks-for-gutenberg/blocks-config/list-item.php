<?php

/**
 * Retrieves the CSS style for the premium bullet list item.
 *
 * @param array $attr The attributes for the bullet list item.
 * @param string $unique_id The unique ID for the bullet list item.
 * @return void
 */
function get_premium_bullet_list_item_css_style( $attr, $unique_id ) {
	$css = new Premium_Blocks_css();
  
  if(isset($attr['itemBackgroundColor'])){
    $css->set_selector( ".{$unique_id}.premium-bullet-list__wrapper" );
    $css->add_property( 'background-color', $css->render_string($css->render_color( $attr['itemBackgroundColor'] ), '!important') );  
  }

  if(isset($attr['itemBackgroundHoverColor'])){
    $css->set_selector( ".{$unique_id}.premium-bullet-list__wrapper:hover" );
    $css->add_property( 'background-color', $css->render_string($css->render_color( $attr['itemBackgroundHoverColor'] ), '!important') );  
  }

  if( isset($attr['titleColor'])){
    $css->set_selector( ".{$unique_id} .premium-bullet-list__label-wrap .premium-bullet-list__label" );
    $css->add_property( 'color', $css->render_color( $attr['titleColor'] ) );
  }

  if( isset($attr['titleHoverColor'])){
    $css->set_selector( ".{$unique_id}.premium-bullet-list__wrapper:hover .premium-bullet-list__label-wrap .premium-bullet-list__label" );
    $css->add_property( 'color', $css->render_color( $attr['titleHoverColor'] ) );
  }

  if( isset($attr['descriptionColor'])){
    $css->set_selector( ".{$unique_id} .premium-bullet-list__label-wrap .premium-bullet-list__description" );
    $css->add_property( 'color', $css->render_color( $attr['descriptionColor'] ) );
  }

  if( isset($attr['descriptionHoverColor'])){
    $css->set_selector( ".{$unique_id}.premium-bullet-list__wrapper:hover .premium-bullet-list__label-wrap .premium-bullet-list__description" );
    $css->add_property( 'color', $css->render_color( $attr['descriptionHoverColor'] ) );
  }

  if (isset($attr['iconSize'])){
    $css->set_selector( ".{$unique_id} .premium-bullet-list__icon-wrap .premium-bullet-list__content-icon .premium-bullet-list-icon" );
		$css->add_property( 'font-size', $css->render_string( $css->render_range( $attr['iconSize'], 'Desktop' ), '!important' ) );

		$css->set_selector( ".{$unique_id} .premium-bullet-list__icon-wrap .premium-bullet-list__content-icon .premium-bullet-list-icon svg" );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Desktop' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Desktop' ), '!important' ) );

		$css->set_selector( ".{$unique_id} .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg.premium-list-item-type-svg" );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Desktop' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Desktop' ), '!important' ) );

		$css->set_selector( ".{$unique_id} .premium-bullet-list__icon-wrap img" );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Desktop' ), '!important' ) );

		$css->set_selector( ".{$unique_id} .premium-bullet-list__icon-wrap span.premium-lottie-animation svg" );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Desktop' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Desktop' ), '!important' ) );
  }

  if ( isset( $attr['iconColor'] ) ) {
		$icon_color = $attr['iconColor'];
		$css->set_selector( ".{$unique_id} .premium-bullet-list__icon-wrap .premium-bullet-list__content-icon .premium-bullet-list-icon" );
		$css->add_property( 'fill', $css->render_string($css->render_color( $icon_color )), '!important' );
		$css->add_property( 'color', $css->render_string($css->render_color( $icon_color )), '!important' );
		$css->set_selector( ".{$unique_id} .premium-bullet-list__icon-wrap .premium-bullet-list__content-icon .premium-bullet-list-icon:not(.icon-type-fe) svg" );
		$css->add_property( 'fill', $css->render_string($css->render_color( $icon_color )), '!important' );
		$css->add_property( 'color', $css->render_string($css->render_color( $icon_color )), '!important' );
		$css->set_selector( ".{$unique_id} .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg.premium-list-item-type-svg" );
		$css->add_property( 'fill', $css->render_string($css->render_color( $icon_color )), '!important' );
		$css->add_property( 'color', $css->render_string($css->render_color( $icon_color )), '!important' );
		$css->set_selector( ".{$unique_id} .premium-bullet-list__icon-wrap .premium-bullet-list__content-icon .premium-bullet-list-icon:not(.icon-type-fe) svg *" );
		$css->add_property( 'fill', $css->render_string($css->render_color( $icon_color )), '!important' );
		$css->set_selector( ".{$unique_id} .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg.premium-list-item-type-svg *" );
    $css->add_property( 'fill', $css->render_string($css->render_color( $icon_color )), '!important' );
	}

  if ( isset( $attr['iconHoverColor'] ) ) {
		$icon_HoverColor = $attr['iconHoverColor'];
		$css->set_selector( ".{$unique_id}.premium-bullet-list__wrapper:hover .premium-bullet-list__icon-wrap .premium-bullet-list-icon" );
		$css->add_property( 'fill', $css->render_color( $icon_HoverColor ) );
		$css->add_property( 'color', $css->render_color( $icon_HoverColor ) );
		$css->set_selector( ".{$unique_id}.premium-bullet-list__wrapper:hover .premium-list-item-svg-class svg.premium-list-item-type-svg" );
		$css->add_property( 'fill', $css->render_color( $icon_HoverColor ) );
		$css->add_property( 'color', $css->render_color( $icon_HoverColor ) );
		$css->set_selector( ".{$unique_id}.premium-bullet-list__wrapper:hover .premium-bullet-list__icon-wrap .premium-bullet-list-icon:not(.icon-type-fe) svg *" );
		$css->add_property( 'fill', $css->render_color( $icon_HoverColor ) );
		$css->set_selector( ".{$unique_id}.premium-bullet-list__wrapper:hover .premium-list-item-svg-class svg.premium-list-item-type-svg*" );
		$css->add_property( 'fill', $css->render_color( $icon_HoverColor ) );
	}

  $css->start_media_query( 'tablet' );

  if (isset($attr['iconSize'])){
    $css->set_selector( ".{$unique_id} .premium-bullet-list__icon-wrap .premium-bullet-list__content-icon .premium-bullet-list-icon" );
		$css->add_property( 'font-size', $css->render_string( $css->render_range( $attr['iconSize'], 'Tablet' ), '!important' ) );

		$css->set_selector( ".{$unique_id} .premium-bullet-list__icon-wrap .premium-bullet-list__content-icon .premium-bullet-list-icon svg" );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Tablet' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Tablet' ), '!important' ) );

		$css->set_selector( ".{$unique_id} .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg.premium-list-item-type-svg" );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Tablet' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Tablet' ), '!important' ) );

		$css->set_selector( ".{$unique_id} .premium-bullet-list__icon-wrap img" );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Tablet' ), '!important' ) );

		$css->set_selector( ".{$unique_id} .premium-bullet-list__icon-wrap span.premium-lottie-animation svg" );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Tablet' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Tablet' ), '!important' ) );
  }

  $css->stop_media_query();

  $css->start_media_query( 'mobile' );

  if (isset($attr['iconSize'])){
    $css->set_selector( ".{$unique_id} .premium-bullet-list__icon-wrap .premium-bullet-list__content-icon .premium-bullet-list-icon" );
		$css->add_property( 'font-size', $css->render_string( $css->render_range( $attr['iconSize'], 'Mobile' ), '!important' ) );

		$css->set_selector( ".{$unique_id} .premium-bullet-list__icon-wrap .premium-bullet-list__content-icon .premium-bullet-list-icon svg" );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Mobile' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Mobile' ), '!important' ) );

		$css->set_selector( ".{$unique_id} .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg.premium-list-item-type-svg" );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Mobile' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Mobile' ), '!important' ) );

		$css->set_selector( ".{$unique_id} .premium-bullet-list__icon-wrap img" );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Mobile' ), '!important' ) );

		$css->set_selector( ".{$unique_id} .premium-bullet-list__icon-wrap span.premium-lottie-animation svg" );
		$css->add_property( 'width', $css->render_string( $css->render_range( $attr['iconSize'], 'Mobile' ), '!important' ) );
		$css->add_property( 'height', $css->render_string( $css->render_range( $attr['iconSize'], 'Mobile' ), '!important' ) );
  }
  $css->stop_media_query();

  return $css->css_output();
}

/**
 * Renders the `premium/list-item` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_item( $attributes, $content, $block ) {
    $block_helpers = pbg_blocks_helper();

	if ( $block_helpers->it_is_not_amp() ) {
		if ( isset( $attributes['iconTypeSelect'] ) && $attributes['iconTypeSelect'] == 'lottie' ) {
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


function register_block_pbg_item() {
	register_block_type(
		'premium/list-item',
		array(
			'render_callback' => 'render_block_pbg_item',
			'editor_style'    => 'premium-blocks-editor-css',
			'editor_script'   => 'pbg-blocks-js',
		)
	);
}

register_block_pbg_item();