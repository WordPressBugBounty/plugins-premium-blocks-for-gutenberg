<?php

$isotope_js = PREMIUM_BLOCKS_URL . 'assets/js/lib/isotope.pkgd.min.js';
//Frontend Style

$images_loaded_js = PREMIUM_BLOCKS_URL . 'assets/js/lib/imageLoaded.min.js';
$images_lightbox_js = PREMIUM_BLOCKS_URL . 'assets/js/lib/fslightbox.js';


$style_css = PREMIUM_BLOCKS_URL . 'assets/css/minified/gallery.min.css';

wp_register_style(
    'create-block-imagegallery-block-frontend-style',
    $style_css,
    array(),
    PREMIUM_BLOCKS_VERSION,
);

wp_register_script(
    'image-gallery-images-loaded-js',
    $images_loaded_js,
    array('jquery'),
    PREMIUM_BLOCKS_VERSION,
    true
);

wp_register_script(
    'image-gallery-fslightbox-js',
    $images_lightbox_js,
    array('jquery'),
    PREMIUM_BLOCKS_VERSION,
    true
);

wp_register_script(
    'image-gallery-isotope-js',
    $isotope_js,
    array('jquery'),
    PREMIUM_BLOCKS_VERSION,
    true
);



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
                wp_enqueue_script('image-gallery-isotope-js');
                wp_enqueue_script('image-gallery-images-loaded-js');
                wp_enqueue_style('create-block-imagegallery-block-frontend-style');
                wp_enqueue_script('image-gallery-fslightbox-js');
                wp_enqueue_style('create-block-imagegallery-fslightbox-style');
                wp_enqueue_script(
                    'premium-gallery-view',
                    PREMIUM_BLOCKS_URL . 'assets/js/build/gallery/index.js',
                    array('wp-element', 'wp-i18n', 'image-gallery-isotope-js', "image-gallery-images-loaded-js"),
                    PREMIUM_BLOCKS_VERSION,
                    true
                );

                $media_query            = array();
                $media_query['mobile']  = apply_filters('Premium_BLocks_mobile_media_query', '(max-width: 767px)');
                $media_query['tablet']  = apply_filters('Premium_BLocks_tablet_media_query', '(max-width: 1024px)');
                $media_query['desktop'] = apply_filters('Premium_BLocks_tablet_media_query', '(min-width: 1025px)');
                $data =             apply_filters(
                    'premium_gallery_localize_script',
                    array(
                        'ajaxurl'     => esc_url(admin_url('admin-ajax.php')),
                        'breakPoints' => $media_query,
                        'pluginURL'   => PREMIUM_BLOCKS_URL,
                        'PremiumBlocksSettings' => array(
                            array(
                                'defaultAuthImg'    =>  PREMIUM_BLOCKS_URL . 'assets/img/author.jpg'
                            )
                        )

                    )
                );

                wp_scripts()->add_data('premium-gallery-view', 'after', array());

                wp_add_inline_script(
                    'premium-gallery-view',
                    'var PBGPRO_Gallery = ' . wp_json_encode($data) . ';',
                    'after'
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
