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
  
  $css->set_selector( ".{$unique_id}.wp-block-premium-list-item.premium-bullet-list__wrapper" );
  $css->pbg_render_color($attr, 'itemBackgroundColor', 'background-color');

  $css->set_selector( ".{$unique_id}.wp-block-premium-list-item.premium-bullet-list__wrapper:hover" );
  $css->pbg_render_color($attr, 'itemBackgroundHoverColor', 'background-color', null, '!important');

  $css->set_selector( ".{$unique_id}.wp-block-premium-list-item .premium-bullet-list__label" );
  $css->pbg_render_color($attr, 'titleColor', 'color');

  $css->set_selector( ".{$unique_id}.wp-block-premium-list-item.premium-bullet-list__wrapper:hover .premium-bullet-list__label" );
  $css->pbg_render_color($attr, 'titleHoverColor', 'color', null, '!important');

  $css->set_selector( ".{$unique_id}.wp-block-premium-list-item .premium-bullet-list__description" );
  $css->pbg_render_color($attr, 'descriptionColor', 'color');

  $css->set_selector( ".{$unique_id}.wp-block-premium-list-item.premium-bullet-list__wrapper:hover .premium-bullet-list__description" );
  $css->pbg_render_color($attr, 'descriptionHoverColor', 'color', null, '!important');

  // Style for icon
  $css->set_selector( 
    '.' . $unique_id . '.wp-block-premium-list-item .premium-bullet-list__icon-wrap .premium-bullet-list-icon svg, ' .
    '.' . $unique_id . '.wp-block-premium-list-item .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg' 
  );
  $css->pbg_render_range($attr, 'iconSize', 'width', 'Desktop', null, '!important');
  $css->pbg_render_range($attr, 'iconSize', 'height', 'Desktop', null, '!important');

  $css->set_selector( '.' . $unique_id . '.wp-block-premium-list-item .premium-bullet-list__icon-wrap img' );
  $css->pbg_render_range($attr, 'iconSize', 'width', 'Desktop', null, '!important');

  $css->set_selector( '.' . $unique_id . '.wp-block-premium-list-item .premium-bullet-list__icon-wrap .premium-lottie-animation svg' );
  $css->pbg_render_range($attr, 'iconSize', 'width', 'Desktop', null, '!important');
  $css->pbg_render_range($attr, 'iconSize', 'height', 'Desktop', null, '!important');

  $css->set_selector( 
    '.' . $unique_id . '.wp-block-premium-list-item .premium-bullet-list__icon-wrap .premium-bullet-list-icon, ' .
    '.' . $unique_id . '.wp-block-premium-list-item .premium-bullet-list__icon-wrap .premium-bullet-list-icon:not(.icon-type-fe) svg, ' .
    '.' . $unique_id . '.wp-block-premium-list-item .premium-bullet-list__icon-wrap .premium-bullet-list-icon:not(.icon-type-fe) svg *, ' .
    '.' . $unique_id . '.wp-block-premium-list-item .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg, ' .
    '.' . $unique_id . '.wp-block-premium-list-item .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg *'
  );
  $css->pbg_render_color($attr, 'iconColor', 'color');
  $css->pbg_render_color($attr, 'iconColor', 'fill');

  $css->set_selector( 
    '.' . $unique_id . '.wp-block-premium-list-item.premium-bullet-list__wrapper:hover .premium-bullet-list-icon, ' .
    '.' . $unique_id . '.wp-block-premium-list-item.premium-bullet-list__wrapper:hover .premium-bullet-list-icon:not(.icon-type-fe) svg *, ' .
    '.' . $unique_id . '.wp-block-premium-list-item.premium-bullet-list__wrapper:hover .premium-list-item-svg-class svg, ' .
    '.' . $unique_id . '.wp-block-premium-list-item.premium-bullet-list__wrapper:hover .premium-list-item-svg-class svg *'
  );
  $css->pbg_render_color($attr, 'iconHoverColor', 'color', null, '!important');
  $css->pbg_render_color($attr, 'iconHoverColor', 'fill', null, '!important');

  $css->start_media_query( 'tablet' );

  $css->set_selector( 
    '.' . $unique_id . '.wp-block-premium-list-item .premium-bullet-list__icon-wrap .premium-bullet-list-icon svg, ' .
    '.' . $unique_id . '.wp-block-premium-list-item .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg' 
  );
  $css->pbg_render_range($attr, 'iconSize', 'width', 'Tablet', null, '!important');
  $css->pbg_render_range($attr, 'iconSize', 'height', 'Tablet', null, '!important');

  $css->set_selector( '.' . $unique_id . '.wp-block-premium-list-item .premium-bullet-list__icon-wrap img' );
  $css->pbg_render_range($attr, 'iconSize', 'width', 'Tablet', null, '!important');

  $css->set_selector( '.' . $unique_id . '.wp-block-premium-list-item .premium-bullet-list__icon-wrap .premium-lottie-animation svg' );
  $css->pbg_render_range($attr, 'iconSize', 'width', 'Tablet', null, '!important');
  $css->pbg_render_range($attr, 'iconSize', 'height', 'Tablet', null, '!important');

  $css->stop_media_query();
  $css->start_media_query( 'mobile' );

  $css->set_selector( 
    '.' . $unique_id . '.wp-block-premium-list-item .premium-bullet-list__icon-wrap .premium-bullet-list-icon svg, ' .
    '.' . $unique_id . '.wp-block-premium-list-item .premium-bullet-list__icon-wrap .premium-list-item-svg-class svg' 
  );
  $css->pbg_render_range($attr, 'iconSize', 'width', 'Mobile', null, '!important');
  $css->pbg_render_range($attr, 'iconSize', 'height', 'Mobile', null, '!important');

  $css->set_selector( '.' . $unique_id . '.wp-block-premium-list-item .premium-bullet-list__icon-wrap img' );
  $css->pbg_render_range($attr, 'iconSize', 'width', 'Mobile', null, '!important');

  $css->set_selector( '.' . $unique_id . '.wp-block-premium-list-item .premium-bullet-list__icon-wrap .premium-lottie-animation svg' );
  $css->pbg_render_range($attr, 'iconSize', 'width', 'Mobile', null, '!important');
  $css->pbg_render_range($attr, 'iconSize', 'height', 'Mobile', null, '!important');

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
		if ( isset( $attributes['iconTypeSelect'] ) && $attributes['iconTypeSelect'] === 'lottie' ) {
			wp_enqueue_script(
				'pbg-lottie',
				PREMIUM_BLOCKS_URL . 'assets/js/lib/lottie.min.js',
				array( 'jquery' ),
				PREMIUM_BLOCKS_VERSION,
				true
			);
		}
	}
  
  /* 
    Handling new feature of WordPress 6.7.2 --> sizes='auto' for old versions that doesn't contain wp-image-{$id} class.
    This workaround can be omitted after a few subsequent releases around 25/3/2025
  */
  if ( (isset( $attributes['iconTypeSelect'] ) && $attributes['iconTypeSelect'] === 'img') || (isset( $attributes['parentIconTypeSelect'] ) && $attributes['parentIconTypeSelect'] === 'img') ){    
   
    if (false === stripos($content, '<img')) {
      return $content;
    }

    if(!empty($attributes['imageURL'])){
      $image_url = $attributes['imageURL'];
    }elseif(empty($attributes['imageURL']) && !empty($attributes['parentImageURL'])){
      $image_url = $attributes['parentImageURL'];
    }else{
      return $content;
    }

    $image_id = attachment_url_to_postid($image_url);
  
    if (!$image_id) {
        return $content;
    }
  
    $image_tag = new WP_HTML_Tag_Processor($content);
  
    // Find our specific image
    if (!$image_tag->next_tag(['tag_name' => 'img'])) {
      return $content;
    }
  
    $image_classnames = $image_tag->get_attribute('class') ?? '';
  
    // Only process if wp-image class is missing
    if (!str_contains($image_classnames, "wp-image-{$image_id}")) {
      // Clean up 
      $image_tag->remove_attribute('srcset');
      $image_tag->remove_attribute('sizes');
      $image_tag->remove_class('wp-image-undefined');
      
      // Add the wp-image class for automatically generate new srcset and sizes attributes
      $image_tag->add_class("wp-image-{$image_id}");
    }
  
    return $image_tag->get_updated_html();
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