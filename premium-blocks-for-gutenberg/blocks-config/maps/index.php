<?php
/**
 * Server-side rendering of the Maps block.
 *
 * @package WordPress
 */

/**
 * Get Maps Block CSS
 *
 * Return Frontend CSS for Maps.
 *
 * @param array  $attr option attribute.
 * @param string $unique_id option For block ID.
 * @return string Return the CSS style.
 */
function get_premium_maps_css_style( $attr, $unique_id ) {
	$css = new Premium_Blocks_css();

	// Desktop Styles.

	// Map container.
	$css->set_selector( $unique_id . ' .premium-map-container' );
	$css->pbg_render_border( $attr, 'mapBorder', 'Desktop' );
	$css->pbg_render_spacing( $attr, 'mapPadding', 'padding', 'Desktop' );
	$css->pbg_render_spacing( $attr, 'mapMargin', 'margin', 'Desktop' );
	$css->pbg_render_range( $attr, 'height', 'height', '', '', 'px' );
	$css->pbg_render_shadow( $attr, 'mapBoxShadow', 'box-shadow' );

	$css->set_selector( $unique_id . ' .premium-map-container > div, ' . $unique_id . ' .premium-map-container > iframe' );
	$css->pbg_render_spacing( $attr, 'mapBorder.borderRadius', 'border-radius', 'Desktop' );

	// Title styles.
	$css->set_selector( $unique_id . ' .premium-maps__wrap__title' );
	$css->pbg_render_typography( $attr, 'titleTypography', 'Desktop' );
	$css->pbg_render_spacing( $attr, 'titleMargin', 'margin', 'Desktop' );
	$css->pbg_render_spacing( $attr, 'titlePadding', 'padding', 'Desktop' );
	$css->pbg_render_color( $attr, 'titleColor', 'color' );

	// Description styles.
	$css->set_selector( $unique_id . ' .premium-maps__wrap__desc' );
	$css->pbg_render_typography( $attr, 'descriptionTypography', 'Desktop' );
	$css->pbg_render_value( $attr, 'boxAlign', 'text-align', 'Desktop' );
	$css->pbg_render_spacing( $attr, 'descriptionMargin', 'margin', 'Desktop' );
	$css->pbg_render_spacing( $attr, 'descriptionPadding', 'padding', 'Desktop' );
	$css->pbg_render_color( $attr, 'descColor', 'color' );

	// Tablet Responsive Styles.
	$css->start_media_query( 'tablet' );

	// Map container.
	$css->set_selector( $unique_id . ' .premium-map-container' );
	$css->pbg_render_border( $attr, 'mapBorder', 'Tablet' );
	$css->pbg_render_spacing( $attr, 'mapPadding', 'padding', 'Tablet' );
	$css->pbg_render_spacing( $attr, 'mapMargin', 'margin', 'Tablet' );

	$css->set_selector( $unique_id . ' .premium-map-container > div, ' . $unique_id . ' .premium-map-container > iframe' );
	$css->pbg_render_spacing( $attr, 'mapBorder.borderRadius', 'border-radius', 'Tablet' );

	// Title styles.
	$css->set_selector( $unique_id . ' .premium-maps__wrap__title' );
	$css->pbg_render_typography( $attr, 'titleTypography', 'Tablet' );
	$css->pbg_render_spacing( $attr, 'titleMargin', 'margin', 'Tablet' );
	$css->pbg_render_spacing( $attr, 'titlePadding', 'padding', 'Tablet' );

	// Description styles.
	$css->set_selector( $unique_id . ' .premium-maps__wrap__desc' );
	$css->pbg_render_typography( $attr, 'descriptionTypography', 'Tablet' );
	$css->pbg_render_value( $attr, 'boxAlign', 'text-align', 'Tablet' );
	$css->pbg_render_spacing( $attr, 'descriptionMargin', 'margin', 'Tablet' );
	$css->pbg_render_spacing( $attr, 'descriptionPadding', 'padding', 'Tablet' );

	$css->stop_media_query();

	// Mobile Responsive Styles.
	$css->start_media_query( 'mobile' );

	// Map container border radius (needs special handling for each corner).
	$css->set_selector( $unique_id . ' .premium-map-container' );
	$css->pbg_render_border( $attr, 'mapBorder', 'Mobile' );
	$css->pbg_render_spacing( $attr, 'mapPadding', 'padding', 'Mobile' );
	$css->pbg_render_spacing( $attr, 'mapMargin', 'margin', 'Mobile' );

	$css->set_selector( $unique_id . ' .premium-map-container > div, ' . $unique_id . ' .premium-map-container > iframe' );
	$css->pbg_render_spacing( $attr, 'mapBorder.borderRadius', 'border-radius', 'Mobile' );

	// Title styles.
	$css->set_selector( $unique_id . ' .premium-maps__wrap__title' );
	$css->pbg_render_typography( $attr, 'titleTypography', 'Mobile' );
	$css->pbg_render_spacing( $attr, 'titleMargin', 'margin', 'Mobile' );
	$css->pbg_render_spacing( $attr, 'titlePadding', 'padding', 'Mobile' );

	// Description styles.
	$css->set_selector( $unique_id . ' .premium-maps__wrap__desc' );
	$css->pbg_render_typography( $attr, 'descriptionTypography', 'Mobile' );
	$css->pbg_render_value( $attr, 'boxAlign', 'text-align', 'Mobile' );
	$css->pbg_render_spacing( $attr, 'descriptionMargin', 'margin', 'Mobile' );
	$css->pbg_render_spacing( $attr, 'descriptionPadding', 'padding', 'Mobile' );

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
			$sanitized_key                    = is_string( $key ) ? sanitize_text_field( $key ) : $key;
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

/**
 * Sanitize the Snazzy styles JSON string.
 *
 * @param string $input The JSON string to sanitize.
 * @return string The sanitized JSON string.
 */
function sanitize_styles( $input ) {
	if ( ! is_string( $input ) ) {
		return '[]';
	}

	$sanitized_array = array();
	$decoded_input   = json_decode( $input, true );

	if ( json_last_error() === JSON_ERROR_NONE && is_array( $decoded_input ) ) {
		foreach ( $decoded_input as $item ) {
			$sanitized_array[] = sanitize_item( $item );
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
 * @return string Returns the rendered maps block HTML.
 */
function render_block_pbg_maps( $attributes, $content, $block ) {
	$block_helpers = pbg_blocks_helper();
	$config        = $block_helpers->export_settings();

	// Default to false (Embed API) unless explicitly enabled (JS API).
	$load_js_api = (bool) ( $config['premium-load-map-api'] ?? true );
	$use_js_api  = (bool) ( $config['premium-map-api'] ?? false );
	$api_key     = $config['premium-map-key'] ?? '';

	// Validate API key.
	if ( empty( $api_key ) ) {
		return '';
	}

	// Extract and sanitize attributes.
	$block_id   = $attributes['blockId'];
	$center_lat = $attributes['centerLat'] ?? '40.7569733';
	$center_lng = $attributes['centerLng'] ?? '-73.98878250000001';

	// Validate coordinates.
	$center_lat = sanitize_text_field( $center_lat );
	if ( ! is_numeric( $center_lat ) || $center_lat < -90 || $center_lat > 90 ) {
		$center_lat = '40.7569733';
	}

	$center_lng = sanitize_text_field( $center_lng );
	if ( ! is_numeric( $center_lng ) || $center_lng < -180 || $center_lng > 180 ) {
		$center_lng = '-73.98878250000001';
	}

	// Wrapper classes.
	$wrapper_classes = array(
		'premium-maps',
		$block_id,
	);

	$wrapper_attributes = get_block_wrapper_attributes(
		array(
			'class' => implode( ' ', $wrapper_classes ),
		)
	);

	// Render based on API mode.
	if ( $use_js_api ) {
		// JavaScript API rendering.
		return render_js_api_map( $attributes, $wrapper_attributes, $api_key, $block_id, $center_lat, $center_lng, $load_js_api );
	} else {
		// Embed API rendering (default).
		return render_embed_api_map( $attributes, $wrapper_attributes, $api_key, $block_id, $center_lat, $center_lng );
	}
}

/**
 * Render map using Embed API (iframe).
 *
 * @param array  $attributes Block attributes.
 * @param string $wrapper_attributes Wrapper attributes string.
 * @param string $api_key Google Maps API key.
 * @param string $block_id Block ID.
 * @param string $center_lat Validated center latitude.
 * @param string $center_lng Validated center longitude.
 * @return string HTML output.
 */
function render_embed_api_map( $attributes, $wrapper_attributes, $api_key, $block_id, $center_lat, $center_lng ) {
	$zoom     = $attributes['zoom'] ?? 6;
	$map_type = $attributes['mapType'] ?? 'roadmap';

	// Build Embed API URL.
	$embed_params = array(
		'key'     => $api_key,
		'q'       => "{$center_lat},{$center_lng}",
		'center'  => "{$center_lat},{$center_lng}",
		'zoom'    => $zoom,
		'maptype' => $map_type,
	);

	$embed_url = 'https://www.google.com/maps/embed/v1/place?' . http_build_query( $embed_params );

	ob_start();
	?>
	<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<div class="premium-map-container">
			<iframe 
				loading="lazy" 
				width="100%" 
				height="100%" 
				style="border:0;" 
				allowfullscreen 
				src="<?php echo esc_url( $embed_url ); ?>">
			</iframe>
		</div>
	</div>
	<?php
	return ob_get_clean();
}

/**
 * Render map using JavaScript API.
 *
 * @param array  $attributes Block attributes.
 * @param string $wrapper_attributes Wrapper attributes string.
 * @param string $api_key Google Maps API key.
 * @param string $block_id Block ID.
 * @param string $center_lat Validated center latitude.
 * @param string $center_lng Validated center longitude.
 * @param bool   $load_js_api Whether to load the JS API script.
 * @return string HTML output.
 */
function render_js_api_map( $attributes, $wrapper_attributes, $api_key, $block_id, $center_lat, $center_lng, $load_js_api ) {
	$attributes['centerLat']   = $center_lat;
	$attributes['centerLng']   = $center_lng;
	$attributes['markerTitle'] = sanitize_text_field( $attributes['markerTitle'] ?? '' );
	$attributes['markerDesc']  = sanitize_text_field( $attributes['markerDesc'] ?? '' );
	$attributes['mapStyle']    = sanitize_styles( $attributes['mapStyle'] ?? '[]' );

	// Enqueue pbg-google-maps first (must load before Google Maps API calls the callback).
	wp_enqueue_script(
		'pbg-google-maps',
		PREMIUM_BLOCKS_URL . 'assets/js/minified/maps.min.js',
		array(),
		PREMIUM_BLOCKS_VERSION,
		true
	);

	if ( $load_js_api ) {
		$maps_api_url = add_query_arg(
			array(
				'key'      => $api_key,
				'loading'  => 'async',
				'callback' => 'initMapsBlocks',
				'v'        => 'weekly',
			),
			'https://maps.googleapis.com/maps/api/js'
		);

		// Load Google Maps API after pbg-google-maps to ensure callback exists.
		wp_enqueue_script(
			'google-maps-js-api',
			$maps_api_url,
			array( 'pbg-google-maps' ),
			PREMIUM_BLOCKS_VERSION,
			array(
				'strategy'  => 'async',
				'in_footer' => true,
			)
		);
	}

	add_filter(
		'premium_google_maps_localize_script',
		function ( $data ) use ( $block_id, $attributes ) {
			$data['blocks'][ $block_id ] = array(
				'attributes' => $attributes,
			);
			return $data;
		}
	);

	$data = apply_filters(
		'premium_google_maps_localize_script',
		array(
			'loadJsApi' => $load_js_api,
		)
	);

	wp_scripts()->add_data( 'pbg-google-maps', 'before', array() );

	wp_add_inline_script(
		'pbg-google-maps',
		'var PBG_MAPS = ' . wp_json_encode( $data ) . ';',
		'before'
	);

	ob_start();
	?>
	<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<div class="premium-map-container"><div style="height:100%"></div></div>
	</div>
	<?php
	return ob_get_clean();
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
