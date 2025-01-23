<?php

/**
 * Server-side rendering of the `pbg/maps` block.
 *
 * @package WordPress
 */

/**
 * Get Maps Block CSS
 *
 * Return Frontend CSS for Maps.
 *
 * @access public
 *
 * @param string $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_maps_css_style( $attr, $unique_id ) {
    $css = new Premium_Blocks_css();

    // Map.
    if ( isset( $attr['mapPadding'] ) ) {
        $map_padding = $attr['mapPadding'];
        $css->set_selector( $unique_id );
        $css->add_property( 'padding', $css->render_spacing( $map_padding['Desktop'], isset( $map_padding['unit']['Desktop'] ) ? $map_padding['unit']['Desktop'] : $map_padding['unit'] ) );
    }

    if ( isset( $attr['mapMargin'] ) ) {
        $map_margin = $attr['mapMargin'];
        $css->set_selector( $unique_id . " .map-container");
        $css->add_property( 'margin', $css->render_spacing( $map_margin['Desktop'], isset( $map_margin['unit']['Desktop'] ) ? $map_margin['unit']['Desktop'] : $map_margin['unit'] ) );
    }

    if ( isset( $attr['mapBorder'] ) ) {
        $map_border        = $attr['mapBorder'];
        $map_border_width  = $map_border['borderWidth'];
        $map_border_radius = $map_border['borderRadius'];

        $css->set_selector( $unique_id );
        $css->add_property( 'border-width', $css->render_spacing( $map_border_width['Desktop'], 'px' ) );
        $css->add_property( 'border-radius', $css->render_spacing( $map_border_radius['Desktop'], 'px' ) );
    }
    if ( isset( $attr['mapBorder'] ) ) {
        $map_border        = $attr['mapBorder'];
        $map_border_radius = $map_border['borderRadius'];

        $css->set_selector( $unique_id . ' > .map-container' );
        $css->add_property( 'border-radius', $css->render_spacing( $map_border_radius['Desktop'], 'px' ) );
    }
    // Title.
    if ( isset( $attr['titleTypography'] ) ) {
        $title_typography = $attr['titleTypography'];

        $css->set_selector( $unique_id . ' .premium-maps__wrap__title' );
        $css->render_typography( $title_typography, 'Desktop' );
    }

    if ( isset( $attr['titlePadding'] ) ) {
        $title_padding = $attr['titlePadding'];
        $css->set_selector( $unique_id . ' .premium-maps__wrap__title' );
        $css->add_property( 'padding', $css->render_spacing( $title_padding['Desktop'], isset( $title_padding['unit']['Desktop'] ) ? $title_padding['unit']['Desktop'] : $title_padding['unit'] ) );
    }

    if ( isset( $attr['titleMargin'] ) ) {
        $title_margin = $attr['titleMargin'];
        $css->set_selector( $unique_id . ' .premium-maps__wrap__title' );
        $css->add_property( 'margin', $css->render_spacing( $title_margin['Desktop'], isset( $title_margin['unit']['Desktop'] ) ? $title_margin['unit']['Desktop'] : $title_margin['unit'] ) );
    }
    // Description.
    if ( isset( $attr['descriptionTypography'] ) ) {
        $description_typography = $attr['descriptionTypography'];

        $css->set_selector( $unique_id . ' .premium-maps__wrap__desc' );
        $css->render_typography( $description_typography, 'Desktop' );
    }

    if ( isset( $attr['descriptionPadding'] ) ) {
        $description_padding = $attr['descriptionPadding'];
        $css->set_selector( $unique_id . ' .premium-maps__wrap__desc' );
        $css->add_property( 'padding', $css->render_spacing( $description_padding['Desktop'], isset( $description_padding['unit']['Desktop'] ) ? $description_padding['unit']['Desktop'] : $description_padding['unit'] ) );
    }

    if ( isset( $attr['descriptionMargin'] ) ) {
        $description_margin = $attr['descriptionMargin'];
        $css->set_selector( $unique_id . ' .premium-maps__wrap__desc' );
        $css->add_property( 'margin', $css->render_spacing( $description_margin['Desktop'], isset( $description_margin['unit']['Desktop'] ) ? $description_margin['unit']['Desktop'] : $description_margin['unit'] ) );
    }

    if ( isset( $attr['boxAlign'] ) ) {

        $css->set_selector( $unique_id . ' .premium-maps__wrap__desc' );
        $css->add_property( 'text-align', $css->get_responsive_css( $attr['boxAlign'], 'Desktop' ) );
    }
    $css->start_media_query( 'tablet' );

    // Map.
    if ( isset( $attr['mapPadding'] ) ) {
        $map_padding = $attr['mapPadding'];
        $css->set_selector( $unique_id );
        $css->add_property( 'padding', $css->render_spacing( $map_padding['Tablet'], isset( $map_padding['unit']['Tablet'] ) ? $map_padding['unit']['Tablet'] : $map_padding['unit'] ) );
    }

    if ( isset( $attr['mapMargin'] ) ) {
        $map_margin = $attr['mapMargin'];
        $css->set_selector( $unique_id . " .map-container");
        $css->add_property( 'margin', $css->render_spacing( $map_margin['Tablet'], isset( $map_margin['unit']['Tablet'] ) ? $map_margin['unit']['Tablet'] : $map_margin['unit'] ) );
    }

    if ( isset( $attr['mapBorder'] ) ) {
        $map_border        = $attr['mapBorder'];
        $map_border_width  = $attr['mapBorder']['borderWidth'];
        $map_border_radius = $attr['mapBorder']['borderRadius'];

        $css->set_selector( $unique_id );
        $css->add_property( 'border-width', $css->render_spacing( $map_border_width['Tablet'], 'px' ) );
        $css->add_property( 'border-radius', $css->render_spacing( $map_border_radius['Tablet'], 'px' ) );
    }
    if ( isset( $attr['mapBorder'] ) ) {
        $map_border        = $attr['mapBorder'];
        $map_border_radius = $attr['mapBorder']['borderRadius'];

        $css->set_selector( $unique_id . ' > .map-container' );
        $css->add_property( 'border-radius', $css->render_spacing( $map_border_radius['Tablet'], 'px' ) );
    }
    // Title.
    if ( isset( $attr['titleTypography'] ) ) {
        $title_typography = $attr['titleTypography'];

        $css->set_selector( $unique_id . ' .premium-maps__wrap__title' );
        $css->render_typography( $title_typography, 'Tablet' );
    }

    if ( isset( $attr['titlePadding'] ) ) {
        $title_padding = $attr['titlePadding'];
        $css->set_selector( $unique_id . ' .premium-maps__wrap__title' );
        $css->add_property( 'padding', $css->render_spacing( $title_padding['Tablet'], isset( $title_padding['unit']['Tablet'] ) ? $title_padding['unit']['Tablet'] : $title_padding['unit'] ) );
    }

    if ( isset( $attr['titleMargin'] ) ) {
        $title_margin = $attr['titleMargin'];
        $css->set_selector( $unique_id . ' .premium-maps__wrap__title' );
        $css->add_property( 'margin', $css->render_spacing( $title_margin['Tablet'], isset( $title_margin['unit']['Tablet'] ) ? $title_margin['unit']['Tablet'] : $title_margin['unit'] ) );
    }
    // Description.
    if ( isset( $attr['descriptionTypography'] ) ) {
        $description_typography = $attr['descriptionTypography'];

        $css->set_selector( $unique_id . ' .premium-maps__wrap__desc' );
        $css->render_typography( $description_typography, 'Tablet' );
    }

    if ( isset( $attr['descriptionPadding'] ) ) {
        $description_padding = $attr['descriptionPadding'];
        $css->set_selector( $unique_id . ' .premium-maps__wrap__desc' );
        $css->add_property( 'padding', $css->render_spacing( $description_padding['Tablet'], isset( $description_padding['unit']['Tablet'] ) ? $description_padding['unit']['Tablet'] : $description_padding['unit'] ) );
    }

    if ( isset( $attr['descriptionMargin'] ) ) {
        $description_margin = $attr['descriptionMargin'];
        $css->set_selector( $unique_id . ' .premium-maps__wrap__desc' );
        $css->add_property( 'margin', $css->render_spacing( $description_margin['Tablet'], isset( $description_margin['unit']['Tablet'] ) ? $description_margin['unit']['Tablet'] : $description_margin['unit'] ) );
    }

    if ( isset( $attr['boxAlign'] ) ) {

        $css->set_selector( $unique_id . ' .premium-maps__wrap__desc' );
        $css->add_property( 'text-align', $css->get_responsive_css( $attr['boxAlign'], 'Tablet' ) );
    }
    $css->stop_media_query();
    $css->start_media_query( 'mobile' );

    // Map.
    if ( isset( $attr['mapPadding'] ) ) {
        $map_padding = $attr['mapPadding'];
        $css->set_selector( $unique_id );
        $css->add_property( 'padding', $css->render_spacing( $map_padding['Mobile'], isset( $map_padding['unit']['Mobile'] ) ? $map_padding['unit']['Mobile'] : $map_padding['unit'] ) );
    }

    if ( isset( $attr['mapMargin'] ) ) {
        $map_margin = $attr['mapMargin'];
        $css->set_selector( $unique_id . " .map-container");
        $css->add_property( 'margin', $css->render_spacing( $map_margin['Mobile'], isset( $map_margin['unit']['Mobile'] ) ? $map_margin['unit']['Mobile'] : $map_margin['unit'] ) );
    }

    if ( isset( $attr['mapBorder'] ) ) {
        $map_border        = $attr['mapBorder'];
        $map_border_width  = $attr['mapBorder']['borderWidth'];
        $map_border_radius = $attr['mapBorder']['borderRadius'];

        $css->set_selector( $unique_id );
        $css->add_property( 'border-width', $css->render_spacing( $map_border_width['Mobile'], 'px' ) );
        $css->add_property( 'border-radius', $css->render_spacing( $map_border_radius['Mobile'], 'px' ) );
    }
    if ( isset( $attr['mapBorder'] ) ) {
        $map_border        = $attr['mapBorder'];
        $map_border_radius = $attr['mapBorder']['borderRadius'];

        $css->set_selector( $unique_id . ' > .map-container' );
        $css->add_property( 'border-radius', $css->render_spacing( $map_border_radius['Mobile'], 'px' ) );
    }
    // Title.
    if ( isset( $attr['titleTypography'] ) ) {
        $title_typography = $attr['titleTypography'];

        $css->set_selector( $unique_id . ' .premium-maps__wrap__title' );
        $css->render_typography( $title_typography, 'Mobile' );
    }

    if ( isset( $attr['titlePadding'] ) ) {
        $title_padding = $attr['titlePadding'];
        $css->set_selector( $unique_id . ' .premium-maps__wrap__title' );
        $css->add_property( 'padding', $css->render_spacing( $title_padding['Mobile'], isset( $title_padding['unit']['Mobile'] ) ? $title_padding['unit']['Mobile'] : $title_padding['unit'] ) );
    }

    if ( isset( $attr['titleMargin'] ) ) {
        $title_margin = $attr['titleMargin'];
        $css->set_selector( $unique_id . ' .premium-maps__wrap__title' );
        $css->add_property( 'margin', $css->render_spacing( $title_margin['Mobile'], isset( $title_margin['unit']['Mobile'] ) ? $title_margin['unit']['Mobile'] : $title_margin['unit'] ) );
    }
    // Description.
    if ( isset( $attr['descriptionTypography'] ) ) {
        $description_typography = $attr['descriptionTypography'];

        $css->set_selector( $unique_id . ' .premium-maps__wrap__desc' );
        $css->render_typography( $description_typography, 'Mobile' );
    }

    if ( isset( $attr['descriptionPadding'] ) ) {
        $description_padding = $attr['descriptionPadding'];
        $css->set_selector( $unique_id . ' .premium-maps__wrap__desc' );
        $css->add_property( 'padding', $css->render_spacing( $description_padding['Mobile'], isset( $description_padding['unit']['Mobile'] ) ? $description_padding['unit']['Mobile'] : $description_padding['unit'] ) );
    }

    if ( isset( $attr['descriptionMargin'] ) ) {
        $description_margin = $attr['descriptionMargin'];
        $css->set_selector( $unique_id . ' .premium-maps__wrap__desc' );
        $css->add_property( 'margin', $css->render_spacing( $description_margin['Mobile'], isset( $description_margin['unit']['Mobile'] ) ? $description_margin['unit']['Mobile'] : $description_margin['unit'] ) );
    }

    if ( isset( $attr['boxAlign'] ) ) {

        $css->set_selector( $unique_id . ' .premium-maps__wrap__desc' );
        $css->add_property( 'text-align', $css->get_responsive_css( $attr['boxAlign'], 'Mobile' ) );
    }

    $css->stop_media_query();
    return $css->css_output();
}
    /**
	 * Recursively sanitize each item in the Snazzy styles array.
	 *
	 * @param mixed $item The item to sanitize.
	 * @return mixed The sanitized item.
	 */
	 function sanitize_item( $item ) {
		if ( is_array( $item ) ) {
			$sanitized_item = array();
			foreach ( $item as $key => $value ) {
				$sanitized_key = is_string( $key ) ? sanitize_text_field( $key ) : $key;
				$sanitized_item[ $sanitized_key ] = sanitize_item( $value );
			}
			return $sanitized_item;
		} elseif ( is_string( $item ) ) {
			return sanitize_text_field( $item );
		} elseif ( is_numeric( $item ) ) {
			return $item;
		} elseif ( is_bool( $item ) ) {
			return $item;
		}
		return null;
	}


function sanitize_styles( $input ) {
	if ( ! is_string( $input ) ) {
		return '[]';
	}

	$sanitized_array = array();
	$decoded_input = json_decode( $input, true );

	if ( json_last_error() === JSON_ERROR_NONE && is_array( $decoded_input ) ) {
		foreach ( $decoded_input as $item ) {
			$sanitized_array[] =sanitize_item( $item );
		}
	}

	return wp_json_encode( $sanitized_array );
}
/**
 * Renders the `premium/maps` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_maps( $attributes, $content, $block ) {
    $class_name = 'premium-maps__wrap';

    $attributes['markerIconUrl'] = isset( $attributes['markerIconUrl'] ) ? $attributes['markerIconUrl'] : '';

    $block_helpers = pbg_blocks_helper();

    $config = $block_helpers->export_settings();

    $is_enabled = isset( $config['premium-map-api'] ) ? $config['premium-map-api'] : true;

    $api_key = isset( $config['premium-map-key'] ) ? $config['premium-map-key'] : '';

    if ( $is_enabled ) {
        if ( ! empty( $api_key ) && '1' != $api_key ) {
            wp_enqueue_script(
                'premium-map-block',
                'https://maps.googleapis.com/maps/api/js?key=' . $api_key ,
                array(),
                PREMIUM_BLOCKS_VERSION,
                false
            );

            wp_script_add_data( 'premium-map-block', 'async/defer', true );
        }
    }
    
    $title               = isset( $attributes['markerTitle'] ) ? $attributes['markerTitle'] :"";
    $descrition          = isset( $attributes['markerDesc'] ) ? $attributes['markerDesc'] :"";
    $zoom                = isset( $attributes['zoom'] ) && ! empty( $attributes['zoom'] ) ? $attributes['zoom'] : 8;
    $map_type            = isset( $attributes['mapType'] ) && ! empty( $attributes['mapType'] )  ? $attributes['mapType'] : 'roadmap';
    $map_type_control    = isset( $attributes['mapTypeControl'] ) && ! empty( $attributes['mapTypeControl'] ) ? $attributes['mapTypeControl'] : 0;
    $zoom_control        = isset( $attributes['zoomControl'])&& ! empty( $attributes['zoomControl']) ? $attributes['zoomControl'] : '0';
    $fullscreen_control  = isset( $attributes['fullscreenControl'] )&& ! empty( $attributes['fullscreenControl']) ? $attributes['fullscreenControl'] : 0;
    $street_view_control = isset( $attributes['streetViewControl'] ) && ! empty( $attributes['streetViewControl'] ) ? $attributes['streetViewControl'] : 0;
    $scroll_wheel        = isset( $attributes['scrollwheel'] ) && ! empty( $attributes['scrollwheel'] ) ? $attributes['scrollwheel'] :'false';
    $marker_custom       = isset( $attributes['markerCustom'] ) && ! empty( $attributes['markerCustom'] ) ? $attributes['markerCustom'] : 0;
    $map_marker          = isset( $attributes['mapMarker'] ) && ! empty( $attributes['mapMarker'] ) ? $attributes['mapMarker'] : 0;
    $open_marker         = isset( $attributes['markerOpen'] ) && ! empty( $attributes['markerOpen'] ) ? $attributes['markerOpen'] : 0;
    // Validate and sanitize $map_style
    $map_style = ! empty( $attributes['mapStyle'] ) ?sanitize_styles( $attributes['mapStyle'] ): '[]';
    // Validate and sanitize coordinates
    $center_lat = ! empty( $attributes['centerLat'] ) ? sanitize_text_field( $attributes['centerLat'] ) : '40.7569733';
    if ( ! is_numeric( $center_lat ) || $center_lat < -90 || $center_lat > 90 ) {
        $center_lat = '40.7569733'; // Default latitude
    }

    $center_lng = ! empty( $attributes['centerLng'] ) ? sanitize_text_field( $attributes['centerLng'] ) : '-73.98878250000001';
    if ( ! is_numeric( $center_lng ) || $center_lng < -180 || $center_lng > 180 ) {
        $center_lng = '-73.98878250000001'; // Default longitude
    }

    // Sanitize other values
    $max_width  = ! empty( $attributes['maxWidth'] ) ? intval( $attributes['maxWidth'] ) : 32;
    $marker_url = ! empty( $attributes['markerIconUrl'] ) ? esc_url_raw( $attributes['markerIconUrl'] ) : '';
    $maps_script = "
    document.addEventListener('DOMContentLoaded', function() {

            let mapElem = document.getElementsByClassName('{$attributes['blockId']}')[0];
            mapElem = mapElem.getElementsByClassName('map-container')[0];
            let pin = document.querySelector('.{$class_name}__marker');
            let latlng = new google.maps.LatLng( parseFloat( {$center_lat} ) , parseFloat( {$center_lng} ) );
            let map = new google.maps.Map(mapElem, {
                zoom: {$zoom},
                gestureHandling: 'cooperative',
                mapTypeId: '{$map_type}',
                mapTypeControl: {$map_type_control},
                zoomControl: {$zoom_control},
                fullscreenControl: {$fullscreen_control},
                streetViewControl: {$street_view_control},
                scrollwheel: {$scroll_wheel},
                center: latlng,
                
                styles: {$map_style}
            });
            var contentString = '<div class=premium-maps__wrap__info ><h3 class=premium-maps__wrap__title>{$title}</h3> <div class=premium-maps__wrap__desc>{$descrition}</div> </div>';
            let markerIcon = '{$marker_url}';
            var textNode = document.createElement('div');
            textNode.className = 'premium-maps__wrap__marker';

            textNode.innerHTML = contentString;
                var icon = {
                    url: {$marker_custom} ? markerIcon : 'https://maps.google.com/mapfiles/ms/icons/red-dot.png',
                };

                if ($max_width && $marker_custom) {
                    icon.scaledSize = new google.maps.Size($max_width, $max_width);
                    icon.origin = new google.maps.Point(0, 0);
                    icon.anchor = new google.maps.Point($max_width / 2, $max_width);
                }
                if( {$map_marker} ) {
                    let marker = new google.maps.Marker({
                        position    : latlng,
                        map         : map,
                        icon        :icon
                    });
                    let infowindow = new google.maps.InfoWindow();
                    if('{$title}' !== '' ||'{$descrition}' !== ''){
                        infowindow.setContent( textNode);
                    }
                    if ({$open_marker}) {
                    infowindow.open( map, marker );
                    }
                    google.maps.event.addListener(marker, 'click', function() {
                        infowindow.open( map, marker );
                    });

                }
        });
    ";

    if ( $is_enabled ) {
        if ( ! empty( $api_key ) && '1' != $api_key ) {
            wp_add_inline_script( 'premium-map-block', $maps_script, 'before' );
        }
    }
    if ( $is_enabled ) {
        if ( ! empty( $api_key ) && '1' != $api_key ) {

    $content .= '<script>';
    $content .=$maps_script;
    $content .=  '</script>';
        }
    }

    return $content;
}




/**
 * Register the maps block.
 *
 * @uses render_block_pbg_maps()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_maps() {
    if ( ! function_exists( 'register_block_type' ) ) {
        return;
    }
    register_block_type(
        PREMIUM_BLOCKS_PATH . '/blocks-config/maps',
        array(
            'render_callback' => 'render_block_pbg_maps',
        )
    );
}

register_block_pbg_maps();