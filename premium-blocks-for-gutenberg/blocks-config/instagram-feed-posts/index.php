<?php
/**
 * Server-side rendering of the `premium/instagram-feed-posts` block.
 *
 * @package WordPress
 */

/**
 * Instagram Feed Posts Block - Dynamic CSS Generation
 *
 * @param array  $attr Block attributes.
 * @param string $unique_id Unique block ID.
 * @return string Generated CSS.
 */
function get_premium_instagram_feed_posts_css( $attr, $unique_id ) {
	$css          = new Premium_Blocks_css();
	$layout_style = $css->pbg_get_value( $attr, 'layoutStyle' );
	$click_action = $css->pbg_get_value( $attr, 'clickAction' );

	// Non-responsive: shadows, colors, filters.
	$css->set_selector( ".{$unique_id} .pbg-insta-feed" );
	$css->pbg_render_shadow( $attr, 'containerShadow', 'box-shadow' );

	$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap .pbg-insta-feed-media" );
	$css->pbg_render_shadow( $attr, 'photoShadow', 'box-shadow' );
	$css->pbg_render_filters( $attr, 'photoFilter' );

	$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap .pbg-insta-feed-media:hover" );
	$css->pbg_render_shadow( $attr, 'photoHoverShadow', 'box-shadow' );
	$css->pbg_render_filters( $attr, 'photoHoverFilter' );

	// Caption non-responsive.
	$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap .pbg-insta-feed-caption" );
	$css->pbg_render_color( $attr, 'captionColor', 'color' );
	$css->pbg_render_shadow( $attr, 'captionShadow', 'text-shadow' );

	$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap.overlay-caption .pbg-insta-feed-caption" );
	$css->pbg_render_color( $attr, 'overlayColor', 'background-color' );

	// Lightbox non-responsive.
	if ( 'lightBox' === $click_action ) {
		$css->set_selector( ".{$unique_id}.pbg-insta-feed-fslightbox-theme" );
		$css->pbg_render_color( $attr, 'lightBoxOverlayColor', 'background-color' );

		$css->set_selector( ".{$unique_id}.pbg-insta-feed-fslightbox-theme .fslightbox-slide-btn svg path" );
		$css->pbg_render_color( $attr, 'lightBoxArrowsColor', 'fill' );

		$css->set_selector( ".{$unique_id}.pbg-insta-feed-fslightbox-theme .fslightbox-slide-btn:hover svg path" );
		$css->pbg_render_color( $attr, 'lightBoxArrowsHColor', 'fill' );
	}

	// Carousel non-responsive.
	if ( 'carousel' === $layout_style ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed-carousel .splide__arrows .splide__arrow svg" );
		$css->pbg_render_color( $attr, 'arrowsColor', 'fill' );

		$css->set_selector( ".{$unique_id} .pbg-insta-feed-carousel .splide__arrows .splide__arrow:hover svg" );
		$css->pbg_render_color( $attr, 'arrowsHoverColor', 'fill' );
	}

	$css->render_responsive( function( $css, $device ) use ( $attr, $unique_id, $layout_style, $click_action ) {
		// Container.
		$css->set_selector( ".{$unique_id} .pbg-insta-feed" );
		$css->pbg_render_background( $attr, 'containerBackground', $device );
		$css->pbg_render_border( $attr, 'containerBorder', $device );
		$css->pbg_render_spacing( $attr, 'containerMargin', 'margin', $device );
		$css->pbg_render_spacing( $attr, 'containerPadding', 'padding', $device );

		$css->set_selector( ".{$unique_id} .pbg-insta-feed-grid" );
		$css->pbg_render_range( $attr, 'imagesInRow', 'grid-template-columns', $device, 'repeat(', ', 1fr)' );
		$css->pbg_render_range( $attr, 'postsGap', 'gap', $device );

		if ( 'masonry' === $layout_style ) {
			$css->set_selector( ".{$unique_id} .pbg-insta-feed-masonry" );
			$css->pbg_render_range( $attr, 'postsGap', 'margin-right', $device, '-' );
			$css->pbg_render_range( $attr, 'postsGap', 'margin-bottom', $device, '-' );

			$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap" );
			$css->pbg_render_range( $attr, 'imagesInRow', 'width', $device, 'calc(100% / ', ')' );
			$css->pbg_render_range( $attr, 'postsGap', 'padding-right', $device );
			$css->pbg_render_range( $attr, 'postsGap', 'padding-bottom', $device );
		}

		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap .pbg-insta-feed-media" );
		$css->pbg_render_border( $attr, 'photoBorder', $device );
		$css->pbg_render_spacing( $attr, 'photoMargin', 'margin', $device );
		$css->pbg_render_spacing( $attr, 'photoPadding', 'padding', $device );

		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap .pbg-insta-feed-media:hover" );
		$css->pbg_render_border( $attr, 'photoHoverBorder', $device );
		$css->pbg_render_spacing( $attr, 'photoHoverMargin', 'margin', $device );

		// Image Height.
		if ( 'masonry' !== $layout_style ) {
			$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap .pbg-insta-feed-media img" );
			$css->pbg_render_range( $attr, 'columnHeight', 'height', $device );
		}

		// Caption.
		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap .pbg-insta-feed-caption" );
		$css->pbg_render_typography( $attr, 'captionTypography', $device );
		$css->pbg_render_spacing( $attr, 'captionPadding', 'padding', $device );

		// Lightbox.
		if ( 'lightBox' === $click_action ) {
			$css->set_selector( ".{$unique_id}.pbg-insta-feed-fslightbox-theme .fslightbox-slide-btn" );
			$css->pbg_render_range( $attr, 'lightBoxArrowsBorderRadius', 'border-radius', $device );
			$css->pbg_render_spacing( $attr, 'lightBoxArrowsPadding', 'padding', $device );
			$css->pbg_render_background( $attr, 'lightBoxArrowsBackground', $device );

			$css->set_selector( ".{$unique_id}.pbg-insta-feed-fslightbox-theme .fslightbox-slide-btn:hover" );
			$css->pbg_render_background( $attr, 'lightBoxArrowsHoverBackground', $device );

			$css->set_selector( ".{$unique_id}.pbg-insta-feed-fslightbox-theme .fslightbox-slide-btn svg" );
			$css->pbg_render_range( $attr, 'lightBoxArrowsSize', 'width', $device );
			$css->pbg_render_range( $attr, 'lightBoxArrowsSize', 'height', $device );
		}

		// Carousel.
		if ( 'carousel' === $layout_style ) {
			$css->set_selector( ".{$unique_id} .pbg-insta-feed-carousel .splide__arrows .splide__arrow" );
			$css->pbg_render_range( $attr, 'arrowsBorderRadius', 'border-radius', $device );
			$css->pbg_render_spacing( $attr, 'arrowsPadding', 'padding', $device );
			$css->pbg_render_background( $attr, 'arrowsBackground', $device );

			$css->set_selector( ".{$unique_id} .pbg-insta-feed-carousel .splide__arrows .splide__arrow:hover" );
			$css->pbg_render_background( $attr, 'arrowsHoverBackground', $device );

			$css->set_selector( ".{$unique_id} .pbg-insta-feed-carousel .splide__arrows .splide__arrow.splide__arrow--next" );
			$css->pbg_render_range( $attr, 'arrowsPosition', 'right', $device );

			$css->set_selector( ".{$unique_id} .pbg-insta-feed-carousel .splide__arrows .splide__arrow.splide__arrow--prev" );
			$css->pbg_render_range( $attr, 'arrowsPosition', 'left', $device );

			$css->set_selector( ".{$unique_id} .pbg-insta-feed-carousel .splide__arrows .splide__arrow svg" );
			$css->pbg_render_range( $attr, 'arrowsSize', 'width', $device );
			$css->pbg_render_range( $attr, 'arrowsSize', 'height', $device );
		}
	} );

	return $css->css_output();
}

/**
 * Get Instagram Posts.
 *
 * @param string $access_token Instagram Access Token.
 * @param int    $max_posts    Maximum number of posts to retrieve.
 * @return array
 */
function pbg_get_instagram_posts( $access_token, $max_posts ) {
	// Validate access token.
	if ( empty( $access_token ) ) {
		add_filter( 'pbg_instagram_feed_has_error', '__return_true' );
		return array();
	}

	// Check and refresh token if needed.
	$access_token = PBG_Blocks_Integrations::check_instagram_token( $access_token );

	// If token refresh failed, return error.
	if ( false === $access_token ) {
		add_filter( 'pbg_instagram_feed_has_error', '__return_true' );
		return array();
	}

	// Build API URL.
	$api_url = sprintf(
		'https://graph.instagram.com/me/media?fields=id,media_type,media_url,username,timestamp,permalink,caption,children,thumbnail_url&limit=%d&access_token=%s',
		$max_posts,
		$access_token
	);

	// Make API request.
	$response = wp_remote_get(
		$api_url,
		array(
			'timeout'   => 60,
			'sslverify' => false,
		)
	);

	// Handle request errors.
	if ( is_wp_error( $response ) ) {
		add_filter( 'pbg_instagram_feed_has_error', '__return_true' );
		return array();
	}

	// Check response code.
	$response_code = wp_remote_retrieve_response_code( $response );
	if ( 200 !== $response_code ) {
		add_filter( 'pbg_instagram_feed_has_error', '__return_true' );
		return array();
	}

	$body  = wp_remote_retrieve_body( $response );
	$posts = json_decode( $body, true );

	// Validate JSON decode.
	if ( null === $posts ) {
		add_filter( 'pbg_instagram_feed_has_error', '__return_true' );
		return array();
	}

	// Check for Instagram API errors in response.
	if ( isset( $posts['error'] ) ) {
		add_filter( 'pbg_instagram_feed_has_error', '__return_true' );
		return array();
	}

	return $posts;
}

/**
 * Get Instagram Posts markup.
 *
 * @param array $posts Instagram Posts.
 * @param array $attr  Block Attributes.
 *
 * @return string
 */
function pbg_get_instagram_posts_markup( $posts, $attr ) {
	$block_id               = $attr['blockId'] ?? '';
	$posts                  = $posts['data'] ?? array();
	$layout_style           = $attr['layoutStyle'] ?? 'grid';
	$open_new_tab           = $attr['openNewTab'] ?? false;
	$click_action           = $attr['clickAction'] ?? 'none';
	$caption_style          = $attr['captionStyle'] ?? 'none';
	$caption_max_words      = $attr['maxWords'] ?? 10;
	$display_video_on_click = $attr['displayVideoOnClick'] ?? false;
	$posts_markup           = '';

	foreach ( $posts ?? array() as $post ) {
		$media_url     = $post['media_url'] ?? '';
		$permalink     = $post['permalink'] ?? '';
		$caption       = $post['caption'] ?? '';
		$media_type    = $post['media_type'] ?? '';
		$permalink     = $post['permalink'] ?? '';
		$thumbnail_url = $post['thumbnail_url'] ?? '';
		$content       = '';

		if ( 'VIDEO' === $media_type ) {
			ob_start();
			?>
			<img class="no-optimole" data-no-lazy="1" data-opt-lazy-loaded="true" data-opt-optimize="0" data-opt-src="" src="<?php echo esc_url( $thumbnail_url ); ?>" alt="<?php echo esc_attr( $caption ); ?>" referrerpolicy="no-referrer"/>
			<?php
			if ( 'redirection' !== $click_action && $display_video_on_click ) {
				?>
				<video src="<?php echo esc_url( $media_url ); ?>" controls playsinline autoplay muted preload="auto"></video> 
				<?php
			}
			$content = ob_get_clean();
		} else {
			ob_start();
			?>
			<img class="no-optimole" data-no-lazy="1" data-opt-lazy-loaded="true" data-opt-optimize="0" data-opt-src="" src="<?php echo esc_url( $media_url ); ?>" alt="<?php echo esc_attr( $caption ); ?>" referrerpolicy="no-referrer"/>
			<?php
			$content = ob_get_clean();
		}

		if ( 'lightBox' === $click_action ) {
			$lightbox_url = 'VIDEO' !== $media_type ? $media_url : $thumbnail_url;
			ob_start();
			?>
			<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<a href="<?php echo esc_url( $lightbox_url ); ?>" data-fslightbox="<?php echo esc_attr( $block_id ); ?>" data-alt="<?php echo esc_attr( $caption ); ?>"></a>
			<?php
			$content = ob_get_clean();
		}

		$classes = array(
			'pbg-insta-feed-wrap',
		);

		if ( 'overlay' === $caption_style ) {
			$classes[] = 'overlay-caption';
		}

		$caption_words = $caption_max_words ? wp_trim_words( $caption, $caption_max_words ) : $caption;
		$caption_words = strlen( $caption_words ) === strlen( $caption ) ? $caption : $caption_words . '...';

		ob_start();
		?>
		<p class="pbg-insta-feed-caption"><?php echo esc_html( $caption_words ); ?></p>
		<?php
		$caption_markup = ob_get_clean();

		ob_start();
		?>
		<a href="<?php echo esc_url( $permalink ); ?>" <?php echo $open_new_tab ? 'target="_blank"' : ''; ?> rel="noopener noreferrer" class="pbg-insta-feed-link"></a>
		<?php
		$redirect_link = ob_get_clean();

		ob_start();
		if ( 'carousel' === $layout_style ) {
			?>
			<li class="splide__slide">
			<?php
		}
		?>
		<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
			<?php
			if ( 'top' === $caption_style ) {
				echo $caption_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			?>
			<div class="pbg-insta-feed-media pbg-insta-<?php echo esc_attr( strtolower( $media_type ) ); ?>-wrap">
				<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php
				if ( 'redirection' === $click_action ) {
					echo $redirect_link; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				if ( 'overlay' === $caption_style ) {
					echo $caption_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				?>
			</div>
			<?php
			if ( 'bottom' === $caption_style ) {
				echo $caption_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			?>
		</div>
		<?php
		if ( 'carousel' === $layout_style ) {
			?>
			</li>
			<?php
		}

		$post_markup   = ob_get_clean();
		$posts_markup .= $post_markup;
	}

	return $posts_markup;
}

/**
 * Renders the `premium/instagram-feed-posts` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_instagram_feed_posts( $attributes, $content, $block ) {
	$block_id               = $attributes['blockId'] ?? '';
	$access_token           = $block->context['accessToken'] ?? '';
	$access_token           = sanitize_text_field( wp_unslash( $access_token ) );
	$layout_style           = $attributes['layoutStyle'] ?? 'grid';
	$click_action           = $attributes['clickAction'] ?? 'none';
	$max_posts              = $attributes['maxImageNumbers'] ?? 6;
	$posts                  = apply_filters( 'pbg_instagram_posts', pbg_get_instagram_posts( $access_token, $max_posts ) );
	$image_effect           = $attributes['imageEffect'] ?? 'none';
	$media_query            = array();
	$media_query['mobile']  = apply_filters( 'Premium_BLocks_mobile_media_query', '(max-width: 767px)' );
	$media_query['tablet']  = apply_filters( 'Premium_BLocks_tablet_media_query', '(max-width: 1024px)' );
	$media_query['desktop'] = apply_filters( 'Premium_BLocks_desktop_media_query', '(min-width: 1025px)' );
	$deps                   = array( 'jquery' );

	wp_register_script(
		'pbg-fslightbox',
		PREMIUM_BLOCKS_URL . 'assets/js/lib/fslightbox.js',
		array( 'jquery' ),
		PREMIUM_BLOCKS_VERSION,
		true
	);

	wp_register_script(
		'pbg-splide',
		PREMIUM_BLOCKS_URL . 'assets/js/lib/splide.min.js',
		array(),
		PREMIUM_BLOCKS_VERSION,
		true
	);

	wp_register_script(
		'pbg-isotope',
		PREMIUM_BLOCKS_URL . 'assets/js/lib/isotope.pkgd.min.js',
		array(),
		PREMIUM_BLOCKS_VERSION,
		true
	);

	wp_register_script(
		'pbg-images-loaded',
		PREMIUM_BLOCKS_URL . 'assets/js/lib/imageLoaded.min.js',
		array( 'jquery' ),
		PREMIUM_BLOCKS_VERSION,
		true
	);

	wp_register_script(
		'pbg-helpers',
		PREMIUM_BLOCKS_URL . 'assets/js/minified/pbg-helpers.min.js',
		array(),
		PREMIUM_BLOCKS_VERSION,
		true
	);

	if ( 'lightBox' === $click_action ) {
		$deps[] = 'pbg-fslightbox';
	}

	if ( 'carousel' === $layout_style ) {
		$deps[] = 'pbg-splide';
		$deps[] = 'pbg-images-loaded';
		$deps[] = 'pbg-helpers';

		wp_enqueue_style(
			'pbg-splide',
			PREMIUM_BLOCKS_URL . 'assets/css/minified/splide.min.css',
			array(),
			PREMIUM_BLOCKS_VERSION,
			'all'
		);
	}

	if ( 'masonry' === $layout_style ) {
		$deps[] = 'pbg-isotope';
		$deps[] = 'pbg-images-loaded';
	}

	wp_enqueue_script(
		'pbg-instagram-feed',
		PREMIUM_BLOCKS_URL . 'assets/js/minified/instagram-feed-posts.min.js',
		$deps,
		PREMIUM_BLOCKS_VERSION,
		true
	);

	add_filter(
		'premium_instagram_feed_localize_script',
		function ( $data ) use ( $block_id, $posts, $attributes ) {
			$allowed_attributes = array(
				'clickAction',
				'displayVideoOnClick',
				'layoutStyle',
				'autoPlay',
				'imagesInRow',
				'autoPlayTime',
				'postsGap',
			);

			$filtered_attributes = array_intersect_key( $attributes, array_flip( $allowed_attributes ) );

			$data['blocks'][ $block_id ] = array(
				'postsCount' => count( $posts['data'] ?? array() ),
				'attributes' => $filtered_attributes,
			);
			return $data;
		}
	);

	$data = apply_filters(
		'premium_instagram_feed_localize_script',
		array(
			'breakpoints' => $media_query,
		)
	);

	wp_scripts()->add_data( 'pbg-instagram-feed', 'before', array() );

	wp_add_inline_script(
		'pbg-instagram-feed',
		'var PBG_INSTAFEED = ' . wp_json_encode( $data ) . ';',
		'before'
	);

	$classes = array( 'pbg-insta-feed' );

	if ( 'none' !== $image_effect ) {
		$classes[] = 'pbg-image-effect-' . $image_effect;
	}

	$posts_markup = pbg_get_instagram_posts_markup( $posts, $attributes );

	// Check if no posts were returned (empty feed).
	if ( '' === $posts_markup ) {
		add_filter( 'pbg_instagram_feed_has_error', '__return_true' );
		return '';
	}

	$arrow_svg_path = 'M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z';

	ob_start();
	?>
	<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
		<?php if ( 'masonry' === $layout_style ) { ?>
			<div class="pbg-insta-feed-masonry">
				<?php echo $posts_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		<?php } elseif ( 'carousel' === $layout_style ) { ?>
			<section class="pbg-insta-feed-carousel splide" aria-label="pbg-insta-feed-carousel">
				<div class="splide__arrows">
					<button class="splide__arrow splide__arrow--prev">
						<svg width="20" height="20" viewBox="0 0 256 512" class="pbg-insta-feed-carousel-icons">
							<path d="<?php echo esc_attr( $arrow_svg_path ); ?>"></path>
						</svg>
					</button>
					<button class="splide__arrow splide__arrow--next">
						<svg width="20" height="20" viewBox="0 0 256 512" class="pbg-insta-feed-carousel-icons">
							<path d="<?php echo esc_attr( $arrow_svg_path ); ?>"></path>
						</svg>
					</button>
				</div>
				<div class="splide__track">
					<ul class="splide__list">
						<?php echo $posts_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</ul>
				</div>
			</section>
		<?php } else { ?>
			<div class="pbg-insta-feed-grid">
				<?php echo $posts_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		<?php } ?>
	</div>
	<?php
	$feed_markup = ob_get_clean();

	$container_attributes = get_block_wrapper_attributes(
		array(
			'class'   => $block_id,
			'data-id' => $block_id,
		)
	);

	ob_start();
	?>
	<div <?php echo $container_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<?php echo $feed_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>
	<?php
	return ob_get_clean();
}


/**
 * Register the my block block.
 *
 * @uses render_block_pbg_instagram_feed_posts()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_instagram_feed_posts() {
	register_block_type(
		PREMIUM_BLOCKS_PATH . 'blocks-config/instagram-feed-posts',
		array(
			'render_callback' => 'render_block_pbg_instagram_feed_posts',
		)
	);
}


register_block_pbg_instagram_feed_posts();


