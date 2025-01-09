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
        array( 'jquery' ),
        PREMIUM_BLOCKS_VERSION,
        true
    );

    wp_register_script(
        'image-gallery-fslightbox-js',
        $images_lightbox_js,
        array( 'jquery' ),
        PREMIUM_BLOCKS_VERSION,
        true
    );

    wp_register_script(
        'image-gallery-isotope-js',
        $isotope_js,
        array( 'jquery' ),
        PREMIUM_BLOCKS_VERSION,
        true
    );



/**
 * Register the icon block.
 *
 * @uses render_block_pbg_icon()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_gallery() {
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	register_block_type(
		PREMIUM_BLOCKS_PATH . 'blocks-config/gallery',
		array(

			'render_callback' => function ( $attributes, $content ) {
                                    $unique_id     = rand( 100, 10000 );
                    $id            = 'premium-galley-' . esc_attr( $unique_id );
                    $block_id      = ( ! empty( $attributes['blockId'] ) ) ? $attributes['blockId'] : $id;
                        add_filter(
                        'premium_gallery_localize_script',
                            function ( $data ) use ( $block_id, $attributes ) {
                                $data[ $block_id ] = array(
                                    'attributes' => $attributes,
                                );
                                return $data;
                            }
                    );
                    wp_enqueue_script( 'image-gallery-isotope-js' );
                    wp_enqueue_script( 'image-gallery-images-loaded-js' );
                    wp_enqueue_style( 'create-block-imagegallery-block-frontend-style' );
                    wp_enqueue_script( 'image-gallery-fslightbox-js' );
                    wp_enqueue_style( 'create-block-imagegallery-fslightbox-style' );
                    wp_enqueue_script(
                        'premium-gallery-view',
                        PREMIUM_BLOCKS_URL . 'assets/js/build/gallery/index.js',
                        array( 'wp-element', 'wp-i18n' ,'image-gallery-isotope-js',"image-gallery-images-loaded-js"),
                        PREMIUM_BLOCKS_VERSION,
                        true
                    );
            

                            return $content;
                }
		)
	);
}
register_block_pbg_gallery();