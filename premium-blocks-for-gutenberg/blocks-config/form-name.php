<?php
/**
 * Server-side rendering of the `premium/form-name` block.
 *
 * @package WordPress
 */

/**
 * Renders the `premium/form-name` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_form_name( $attributes, $content, $block ) {
  
  if ( (isset( $attributes["iconTypeSelect"] ) && $attributes["iconTypeSelect"] == "lottie")  || (isset($attributes['triggerSettings']) && $attributes['triggerSettings'][0]['triggerType'] =='lottie')) {
    wp_enqueue_script(
      'pbg-lottie',
      PREMIUM_BLOCKS_URL . 'assets/js/lib/lottie.min.js',
      array( 'jquery' ),
      PREMIUM_BLOCKS_VERSION,
      true
    );
  }

  /* 
    Handling new feature of WordPress 6.7.2 --> sizes='auto' for old versions that doesn't contain wp-image-{$id} class.
    This workaround can be omitted after a few subsequent releases around 25/3/2025
  */
  if ( isset( $attributes['iconTypeSelect'] ) && $attributes['iconTypeSelect'] == 'img' ){
    if (empty($attributes['imageURL']) || false === stripos($content, '<img')) {
      return $content;
    }

    $image_id = attachment_url_to_postid($attributes['imageURL']);
  
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


/**
 * Register the form_name block.
 *
 * @uses render_block_pbg_form_name()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_form_name() {
	register_block_type(
		'premium/form-name',
		array(
			'render_callback' => 'render_block_pbg_form_name',
			'editor_style'    => 'premium-blocks-editor-css',
			'editor_script'   => 'pbg-blocks-js',
		)
	);
}

register_block_pbg_form_name();
