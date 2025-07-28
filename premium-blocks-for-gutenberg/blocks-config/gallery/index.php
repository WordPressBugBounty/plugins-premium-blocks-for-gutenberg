<?php
/**
 * Register the icon block.
 *
 * @uses render_block_pbg_icon()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_gallery()
{
    if (! function_exists('register_block_type')) {
        return;
    }
    register_block_type(
        PREMIUM_BLOCKS_PATH . 'blocks-config/gallery',
        array(
            'render_callback' => function ($attributes, $content) {

                wp_register_script(
                  'image-gallery-isotope-js',
                  PREMIUM_BLOCKS_URL . 'assets/js/lib/isotope.pkgd.min.js',
                  array('jquery'),
                  PREMIUM_BLOCKS_VERSION,
                  true
                );

                wp_register_script(
                  'image-gallery-images-loaded-js',
                  PREMIUM_BLOCKS_URL . 'assets/js/lib/imageLoaded.min.js',
                  array('jquery'),
                  PREMIUM_BLOCKS_VERSION,
                  true
                );

                if(isset($attributes['enableLightbox']) && $attributes['enableLightbox']){
                    wp_register_script(
                      'image-gallery-fslightbox-js',
                      PREMIUM_BLOCKS_URL . 'assets/js/lib/fslightbox.js',
                      array('jquery'),
                      PREMIUM_BLOCKS_VERSION,
                      true
                    );
                }else{
                    wp_register_script(
                      'image-gallery-fslightbox-js',
                      false,
                    );
                }
               
                wp_enqueue_script(
                  'premium-gallery-view',
                  PREMIUM_BLOCKS_URL . 'assets/js/build/gallery/index.js',
                  array('wp-element', 'wp-i18n', 'image-gallery-images-loaded-js', 'image-gallery-isotope-js', 'image-gallery-fslightbox-js'),
                  PREMIUM_BLOCKS_VERSION,
                  true
                );


                $unique_id     = rand(100, 10000);
                $id            = 'premium-galley-' . esc_attr($unique_id);
                $block_id      = (! empty($attributes['blockId'])) ? $attributes['blockId'] : $id;

                add_filter(
                    'premium_gallery_localize_script',
                    function ($data) use ($block_id, $attributes) {
                        $data[$block_id] = array(
                            'attributes' => $attributes,
                        );
                        return $data;
                    }
                );

                $media_query            = array();
                $media_query['mobile']  = apply_filters('Premium_BLocks_mobile_media_query', '(max-width: 767px)');
                $media_query['tablet']  = apply_filters('Premium_BLocks_tablet_media_query', '(max-width: 1024px)');
                $media_query['desktop'] = apply_filters('Premium_BLocks_tablet_media_query', '(min-width: 1025px)');
                
                $data =             apply_filters(
                    'premium_gallery_localize_script',
                    array(
                        'breakPoints' => $media_query,
                    )
                );

                wp_scripts()->add_data('premium-gallery-view', 'before', array());

                wp_add_inline_script(
                    'premium-gallery-view',
                    'var PBGPRO_Gallery = ' . wp_json_encode($data) . ';',
                    'before'
                );

                /* 
                  Handling new feature of WordPress 6.7.2 --> sizes='auto' for old versions that doesn't contain wp-image-{$id} class.
                  This workaround can be omitted after a few subsequent releases around 25/3/2025
                */
                if(isset($attributes['repeaterMedia']) && is_array($attributes['repeaterMedia'])){

                  if ( false === strpos( $content, '<img' ) ) {
                    return $content;
                  }

                  $image_tag =  new WP_HTML_Tag_Processor($content);

                  foreach ($attributes['repeaterMedia'] as $index => $media_item){
                    // Skip if no image ID is provided
                    if (! isset( $media_item['media']['id'] ) || empty($media_item['media']['id'])) {
                      continue;
                    }
                    
                    $image_id = $media_item['media']['id'];
              
                    if (!$image_tag->next_tag(['tag_name' => 'img'])) {
                      return $content;
                    }  
              
                    $image_classnames = $image_tag->get_attribute('class') ?? '';
              
                    if (!str_contains($image_classnames, "wp-image-{$image_id}")) {
                      // Clean up 
                      $image_tag->remove_attribute('srcset');
                      $image_tag->remove_attribute('sizes');
                      
                      // Add the wp-image class for automatically generate new srcset and sizes attributes
                      $image_tag->add_class("wp-image-{$image_id}");
                    }
                  }
              
                  return $image_tag->get_updated_html();
                }

                return $content;
            }
        )
    );
}
register_block_pbg_gallery();
