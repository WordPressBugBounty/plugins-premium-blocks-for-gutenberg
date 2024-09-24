<?php
// Move this file to "blocks-config" folder with name "instagram-feed-posts.php".

/**
 * Get Dynamic CSS.
 *
 * @param array  $attr
 * @param string $unique_id
 * @return string
 */
function get_premium_instagram_feed_posts_css( $attr, $unique_id ) {
	$css           = new Premium_Blocks_css();
	$images_in_row = ( ! empty( $attr['imagesInRow'] ) ) ? $attr['imagesInRow'] : array(
		'Desktop' => 3,
		'Tablet'  => 2,
		'Mobile'  => 1,
	);

	// Desktop Styles.
	// Container.
	if ( 'grid' === $attr['layoutStyle'] ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-posts-wrap" );
		$css->add_property( 'display', 'grid' );
		$css->add_property( 'grid-template-columns', 'repeat(' . $images_in_row['Desktop'] . ', 1fr)' );
	}
	if ( isset( $attr['containerColor'] ) ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed" );
		$css->add_property( 'color', $attr['containerColor'] );
	}

	if ( isset( $attr['containerShadow'] ) ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed" );
		$css->add_property( 'box-shadow', $css->render_shadow( $attr['containerShadow'] ) );
	}

	if ( isset( $attr['containerBackground'] ) ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed" );
		$css->render_background( $attr['containerBackground'], $css );
	}

	if ( isset( $attr['containerBorder'] ) ) {
		$container_border_width  = $attr['containerBorder']['borderWidth'];
		$container_border_radius = $attr['containerBorder']['borderRadius'];

		$css->set_selector( ".{$unique_id} .pbg-insta-feed" );
		$css->add_property( 'border-style', $attr['containerBorder']['borderType'] );
		$css->add_property( 'border-color', $css->render_color( $attr['containerBorder']['borderColor'] ) );
		$css->add_property( 'border-width', $css->render_spacing( $container_border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $container_border_radius['Desktop'], 'px' ) );
	}

	if ( isset( $attr['containerMargin'] ) ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed" );
		$css->add_property( 'margin', $css->render_spacing( $attr['containerMargin']['Desktop'], isset( $attr['containerMargin']['unit']['Desktop'] ) ? $attr['containerMargin']['unit']['Desktop'] : $attr['containerMargin']['unit'] ) );
	}

	if ( isset( $attr['containerPadding'] ) ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed" );
		$css->add_property( 'padding', $css->render_spacing( $attr['containerPadding']['Desktop'], isset( $attr['containerPadding']['unit']['Desktop'] ) ? $attr['containerPadding']['unit']['Desktop'] : $attr['containerPadding']['unit'] ) );
	}

	// Image.
	if ( 'masonry' !== $attr['layoutStyle'] ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap img" );
		$css->add_property( 'height', $css->render_range( $attr['columnHeight'], 'Desktop' ) );
	}
	$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap" );
	$css->add_property( 'display', 'block' );
	if ( 'masonry' === $attr['layoutStyle'] ) {
		$post_width = ( 100 / $images_in_row['Desktop'] ) . '%';
		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap" );
		$css->add_property( 'width', $post_width );
	} else {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap" );
		$css->add_property( 'width', '100%' );
	}

	if ( 'none' !== $attr['clickAction'] ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap" );
		$css->add_property( 'cursor', 'pointer' );
	}

	if ( isset( $attr['photoShadow'] ) ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap .pbg-insta-feed-media" );
		$css->add_property( 'box-shadow', $css->render_shadow( $attr['photoShadow'] ) );
	}

	if ( isset( $attr['photoFilter'] ) ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap .pbg-insta-feed-media" );
		$css->add_property( 'filter', $css->render_filter( $attr['photoFilter'] ) );
	}

	if ( isset( $attr['photoBorder'] ) ) {
		$container_border_width  = $attr['photoBorder']['borderWidth'];
		$container_border_radius = $attr['photoBorder']['borderRadius'];

		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap .pbg-insta-feed-media" );
		$css->add_property( 'border-style', $attr['photoBorder']['borderType'] );
		$css->add_property( 'border-color', $css->render_color( $attr['photoBorder']['borderColor'] ) );
		$css->add_property( 'border-width', $css->render_spacing( $container_border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $container_border_radius['Desktop'], 'px' ) );
	}

	if ( isset( $attr['photoMargin'] ) ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap .pbg-insta-feed-media" );
		$css->add_property( 'margin', $css->render_spacing( $attr['photoMargin']['Desktop'], isset( $attr['photoMargin']['unit']['Desktop'] ) ? $attr['photoMargin']['unit']['Desktop'] : $attr['photoMargin']['unit'] ) );
	}

	if ( isset( $attr['photoPadding'] ) ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap .pbg-insta-feed-media" );
		$css->add_property( 'padding', $css->render_spacing( $attr['photoPadding']['Desktop'], isset( $attr['photoPadding']['unit']['Desktop'] ) ? $attr['photoPadding']['unit']['Desktop'] : $attr['photoPadding']['unit'] ) );
	}

	if ( isset( $attr['photoHoverShadow'] ) ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap .pbg-insta-feed-media:hover" );
		$css->add_property( 'box-shadow', $css->render_shadow( $attr['photoHoverShadow'] ) );
	}

	if ( isset( $attr['photoHoverFilter'] ) ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap .pbg-insta-feed-media:hover" );
		$css->add_property( 'filter', $css->render_filter( $attr['photoHoverFilter'] ) );
	}

	if ( isset( $attr['photoHoverBorder'] ) ) {
		$container_border_width  = $attr['photoHoverBorder']['borderWidth'];
		$container_border_radius = $attr['photoHoverBorder']['borderRadius'];

		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap .pbg-insta-feed-media:hover" );
		$css->add_property( 'border-style', $attr['photoHoverBorder']['borderType'] );
		$css->add_property( 'border-color', $css->render_color( $attr['photoHoverBorder']['borderColor'] ) );
		$css->add_property( 'border-width', $css->render_spacing( $container_border_width['Desktop'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $container_border_radius['Desktop'], 'px' ) );
	}

	if ( isset( $attr['photoHoverMargin'] ) ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap .pbg-insta-feed-media:hover" );
		$css->add_property( 'margin', $css->render_spacing( $attr['photoHoverMargin']['Desktop'], isset( $attr['photoHoverMargin']['unit']['Desktop'] ) ? $attr['photoHoverMargin']['unit']['Desktop'] : $attr['photoHoverMargin']['unit'] ) );
	}

	if ( isset( $attr['photoBackgroundColor'] ) ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap .pbg-insta-feed-media" );
		$css->add_property( 'background-color', $attr['photoBackgroundColor'] );
	}

	if ( isset( $attr['photoHoverBackgroundColor'] ) ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap .pbg-insta-feed-media:hover" );
		$css->add_property( 'background-color', $attr['photoHoverBackgroundColor'] );
	}

	// Caption.
	if ( isset( $attr['captionColor'] ) ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap .pbg-insta-feed-caption" );
		$css->add_property( 'color', $attr['captionColor'] );
	}

	if ( isset( $attr['captionTypography'] ) ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap .pbg-insta-feed-caption" );
		$css->render_typography( $attr['captionTypography'], 'Desktop' );
	}

	if ( isset( $attr['captionShadow'] ) ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap .pbg-insta-feed-caption" );
		$css->add_property( 'text-shadow', $css->render_shadow( $attr['captionShadow'] ) );
	}

	if ( isset( $attr['captionPadding'] ) ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap .pbg-insta-feed-caption" );
		$css->add_property( 'padding', $css->render_spacing( $attr['captionPadding']['Desktop'], isset( $attr['captionPadding']['unit']['Desktop'] ) ? $attr['captionPadding']['unit']['Desktop'] : $attr['captionPadding']['unit'] ) );
	}

	if ( isset( $attr['overlayColor'] ) ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap.overlay-caption .pbg-insta-feed-caption" );
		$css->add_property( 'background-color', $attr['overlayColor'] );
	}

	// Lightbox.
	if ( isset( $attr['clickAction'] ) && $attr['clickAction'] === 'lightBox' ) {
		if ( isset( $attr['lightBoxOverlayColor'] ) ) {
			$css->set_selector( ".{$unique_id}.wp-block-premium-instagram-feed-posts .pbg-lightbox .pbg-lightbox-overlay" );
			$css->add_property( 'background-color', $attr['lightBoxOverlayColor'] );
		}
		if ( isset( $attr['lightBoxArrowsBorderRadius'] ) ) {
			$css->set_selector( ".{$unique_id}.wp-block-premium-instagram-feed-posts .pbg-lightbox button.pbg-arrow" );
			$css->add_property( 'border-radius', $css->render_range( $attr['lightBoxArrowsBorderRadius'], 'Desktop' ) );
		}
		if ( isset( $attr['lightBoxArrowsPadding'] ) ) {
			$css->set_selector( ".{$unique_id}.wp-block-premium-instagram-feed-posts .pbg-lightbox button.pbg-arrow" );
			$css->add_property( 'padding', $css->render_spacing( $attr['lightBoxArrowsPadding']['Desktop'], isset( $attr['lightBoxArrowsPadding']['unit']['Desktop'] ) ? $attr['lightBoxArrowsPadding']['unit']['Desktop'] : $attr['lightBoxArrowsPadding']['unit'] ) );
		}
		if ( isset( $attr['lightBoxArrowsBackground'] ) ) {
			$css->set_selector( ".{$unique_id}.wp-block-premium-instagram-feed-posts .pbg-lightbox button.pbg-arrow" );
			$css->render_background( $attr['lightBoxArrowsBackground'], $css );
		}
		if ( isset( $attr['lightBoxArrowsHoverBackground'] ) ) {
			$css->set_selector( ".{$unique_id}.wp-block-premium-instagram-feed-posts .pbg-lightbox button.pbg-arrow:hover" );
			$css->render_background( $attr['lightBoxArrowsHoverBackground'], $css );
		}
		if ( isset( $attr['lightBoxArrowsColor'] ) ) {
			$css->set_selector( ".{$unique_id}.wp-block-premium-instagram-feed-posts .pbg-lightbox button.pbg-arrow .dashicons" );
			$css->add_property( 'color', $attr['lightBoxArrowsColor'] );
		}
		if ( isset( $attr['lightBoxArrowsSize'] ) ) {
			$css->set_selector( ".{$unique_id}.wp-block-premium-instagram-feed-posts .pbg-lightbox button.pbg-arrow .dashicons" );
			$css->add_property( 'font-size', $css->render_range( $attr['lightBoxArrowsSize'], 'Desktop' ) );
		}
		if ( isset( $attr['lightBoxArrowsHColor'] ) ) {
			$css->set_selector( ".{$unique_id}.wp-block-premium-instagram-feed-posts .pbg-lightbox button.pbg-arrow:hover .dashicons" );
			$css->add_property( 'color', $attr['lightBoxArrowsHColor'] );
		}
	}

	// Carousel.
	if ( isset( $attr['layoutStyle'] ) && $attr['layoutStyle'] === 'carousel' ) {
		if ( isset( $attr['arrowsBorderRadius'] ) ) {
			$css->set_selector( ".{$unique_id} .pbg-insta-feed .slick-arrow" );
			$css->add_property( 'border-radius', $css->render_range( $attr['arrowsBorderRadius'], 'Desktop' ) );
		}
		if ( isset( $attr['arrowsPadding'] ) ) {
			$css->set_selector( ".{$unique_id} .pbg-insta-feed .slick-arrow" );
			$css->add_property( 'padding', $css->render_spacing( $attr['arrowsPadding']['Desktop'], isset( $attr['arrowsPadding']['unit']['Desktop'] ) ? $attr['arrowsPadding']['unit']['Desktop'] : $attr['arrowsPadding']['unit'] ) );
		}
		if ( isset( $attr['arrowsBackground'] ) ) {
			$css->set_selector( ".{$unique_id} .pbg-insta-feed .slick-arrow" );
			$css->render_background( $attr['arrowsBackground'], $css );
		}
		if ( isset( $attr['arrowsPosition'] ) ) {
			$css->set_selector( ".{$unique_id} .pbg-insta-feed .slick-slider .slick-arrow.slick-next" );
			$css->add_property( 'right', $css->render_range( $attr['arrowsPosition'], 'Desktop' ) );
			$css->set_selector( ".{$unique_id} .pbg-insta-feed .slick-slider .slick-arrow.slick-prev" );
			$css->add_property( 'left', $css->render_range( $attr['arrowsPosition'], 'Desktop' ) );
		}
		if ( isset( $attr['arrowsVerticalPosition'] ) ) {
			$css->set_selector( ".{$unique_id} .pbg-insta-feed .slick-slider .slick-arrow.slick-next" );
			$css->add_property( 'top', $css->render_range( $attr['arrowsVerticalPosition'], 'Desktop' ) );
			$css->set_selector( ".{$unique_id} .pbg-insta-feed .slick-slider .slick-arrow.slick-prev" );
			$css->add_property( 'top', $css->render_range( $attr['arrowsVerticalPosition'], 'Desktop' ) );
		}
		if ( isset( $attr['arrowsHoverBackground'] ) ) {
			$css->set_selector( ".{$unique_id} .pbg-insta-feed .slick-slider .slick-arrow:hover" );
			$css->render_background( $attr['arrowsHoverBackground'], $css );
		}
		if ( isset( $attr['arrowsColor'] ) ) {
			$css->set_selector( ".{$unique_id} .pbg-insta-feed .slick-slider .slick-arrow:before" );
			$css->add_property( 'color', $attr['arrowsColor'] );
		}
		if ( isset( $attr['arrowsSize'] ) ) {
			$css->set_selector( ".{$unique_id} .pbg-insta-feed .slick-slider .slick-arrow:before" );
			$css->add_property( 'font-size', $css->render_range( $attr['arrowsSize'], 'Desktop' ) );
		}
		if ( isset( $attr['arrowsHoverColor'] ) ) {
			$css->set_selector( ".{$unique_id} .pbg-insta-feed .slick-slider .slick-arrow:hover:before" );
			$css->add_property( 'color', $attr['arrowsHoverColor'] );
		}
	}

	$css->start_media_query( 'tablet' );
	// Tablet Styles.
	// Container.
	if ( 'grid' === $attr['layoutStyle'] ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-posts-wrap" );
		$css->add_property( 'display', 'grid' );
		$css->add_property( 'grid-template-columns', 'repeat(' . $images_in_row['Tablet'] . ', 1fr)' );
	}
	if ( isset( $attr['containerBorder'] ) ) {
		$container_border_width  = $attr['containerBorder']['borderWidth'];
		$container_border_radius = $attr['containerBorder']['borderRadius'];

		$css->set_selector( ".{$unique_id} .pbg-insta-feed" );
		$css->add_property( 'border-width', $css->render_spacing( $container_border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $container_border_radius['Tablet'], 'px' ) );
	}

	if ( isset( $attr['containerMargin'] ) ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed" );
		$css->add_property( 'margin', $css->render_spacing( $attr['containerMargin']['Tablet'], isset( $attr['containerMargin']['unit']['Tablet'] ) ? $attr['containerMargin']['unit']['Tablet'] : $attr['containerMargin']['unit'] ) );
	}

	if ( isset( $attr['containerPadding'] ) ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed" );
		$css->add_property( 'padding', $css->render_spacing( $attr['containerPadding']['Tablet'], isset( $attr['containerPadding']['unit']['Tablet'] ) ? $attr['containerPadding']['unit']['Tablet'] : $attr['containerPadding']['unit'] ) );
	}

	// Image.
	if ( 'masonry' === $attr['layoutStyle'] ) {
		$post_width = ( 100 / $images_in_row['Tablet'] ) . '%';
		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap" );
		$css->add_property( 'width', $post_width );
	}
	if ( 'masonry' !== $attr['layoutStyle'] ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap img" );
		$css->add_property( 'height', $css->render_range( $attr['columnHeight'], 'Tablet' ) );
	}
	if ( isset( $attr['photoBorder'] ) ) {
		$container_border_width  = $attr['photoBorder']['borderWidth'];
		$container_border_radius = $attr['photoBorder']['borderRadius'];

		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap .pbg-insta-feed-media" );
		$css->add_property( 'border-width', $css->render_spacing( $container_border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $container_border_radius['Tablet'], 'px' ) );
	}

	if ( isset( $attr['photoMargin'] ) ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap .pbg-insta-feed-media" );
		$css->add_property( 'margin', $css->render_spacing( $attr['photoMargin']['Tablet'], isset( $attr['photoMargin']['unit']['Tablet'] ) ? $attr['photoMargin']['unit']['Tablet'] : $attr['photoMargin']['unit'] ) );
	}

	if ( isset( $attr['photoPadding'] ) ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap .pbg-insta-feed-media" );
		$css->add_property( 'padding', $css->render_spacing( $attr['photoPadding']['Tablet'], isset( $attr['photoPadding']['unit']['Tablet'] ) ? $attr['photoPadding']['unit']['Tablet'] : $attr['photoPadding']['unit'] ) );
	}

	if ( isset( $attr['photoHoverBorder'] ) ) {
		$container_border_width  = $attr['photoHoverBorder']['borderWidth'];
		$container_border_radius = $attr['photoHoverBorder']['borderRadius'];

		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap .pbg-insta-feed-media:hover" );
		$css->add_property( 'border-width', $css->render_spacing( $container_border_width['Tablet'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $container_border_radius['Tablet'], 'px' ) );
	}

	if ( isset( $attr['photoHoverMargin'] ) ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap .pbg-insta-feed-media:hover" );
		$css->add_property( 'margin', $css->render_spacing( $attr['photoHoverMargin']['Tablet'], isset( $attr['photoHoverMargin']['unit']['Tablet'] ) ? $attr['photoHoverMargin']['unit']['Tablet'] : $attr['photoHoverMargin']['unit'] ) );
	}

	// Caption.
	if ( isset( $attr['captionTypography'] ) ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap .pbg-insta-feed-caption" );
		$css->render_typography( $attr['captionTypography'], 'Tablet' );
	}

	if ( isset( $attr['captionPadding'] ) ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap .pbg-insta-feed-caption" );
		$css->add_property( 'padding', $css->render_spacing( $attr['captionPadding']['Tablet'], isset( $attr['captionPadding']['unit']['Tablet'] ) ? $attr['captionPadding']['unit']['Tablet'] : $attr['captionPadding']['unit'] ) );
	}

	// Lightbox.
	if ( isset( $attr['clickAction'] ) && $attr['clickAction'] === 'lightBox' ) {
		if ( isset( $attr['lightBoxArrowsBorderRadius'] ) ) {
			$css->set_selector( ".{$unique_id}.wp-block-premium-instagram-feed-posts .pbg-lightbox button.pbg-arrow" );
			$css->add_property( 'border-radius', $css->render_range( $attr['lightBoxArrowsBorderRadius'], 'Tablet' ) );
		}
		if ( isset( $attr['lightBoxArrowsPadding'] ) ) {
			$css->set_selector( ".{$unique_id}.wp-block-premium-instagram-feed-posts .pbg-lightbox button.pbg-arrow" );
			$css->add_property( 'padding', $css->render_spacing( $attr['lightBoxArrowsPadding']['Tablet'], isset( $attr['lightBoxArrowsPadding']['unit']['Tablet'] ) ? $attr['lightBoxArrowsPadding']['unit']['Tablet'] : $attr['lightBoxArrowsPadding']['unit'] ) );
		}
		if ( isset( $attr['lightBoxArrowsSize'] ) ) {
			$css->set_selector( ".{$unique_id}.wp-block-premium-instagram-feed-posts .pbg-lightbox button.pbg-arrow .dashicons" );
			$css->add_property( 'font-size', $css->render_range( $attr['lightBoxArrowsSize'], 'Tablet' ) );
		}
	}

	// Carousel.
	if ( isset( $attr['layoutStyle'] ) && $attr['layoutStyle'] === 'carousel' ) {
		if ( isset( $attr['arrowsBorderRadius'] ) ) {
			$css->set_selector( ".{$unique_id} .pbg-insta-feed .slick-arrow" );
			$css->add_property( 'border-radius', $css->render_range( $attr['arrowsBorderRadius'], 'Tablet' ) );
		}
		if ( isset( $attr['arrowsPadding'] ) ) {
			$css->set_selector( ".{$unique_id} .pbg-insta-feed .slick-arrow" );
			$css->add_property( 'padding', $css->render_spacing( $attr['arrowsPadding']['Tablet'], isset( $attr['arrowsPadding']['unit']['Tablet'] ) ? $attr['arrowsPadding']['unit']['Tablet'] : $attr['arrowsPadding']['unit'] ) );
		}
		if ( isset( $attr['arrowsPosition'] ) ) {
			$css->set_selector( ".{$unique_id} .pbg-insta-feed .slick-slider .slick-arrow.slick-next" );
			$css->add_property( 'right', $css->render_range( $attr['arrowsPosition'], 'Tablet' ) );
			$css->set_selector( ".{$unique_id} .pbg-insta-feed .slick-slider .slick-arrow.slick-prev" );
			$css->add_property( 'left', $css->render_range( $attr['arrowsPosition'], 'Tablet' ) );
		}
		if ( isset( $attr['arrowsVerticalPosition'] ) ) {
			$css->set_selector( ".{$unique_id} .pbg-insta-feed .slick-slider .slick-arrow.slick-next" );
			$css->add_property( 'top', $css->render_range( $attr['arrowsVerticalPosition'], 'Tablet' ) );
			$css->set_selector( ".{$unique_id} .pbg-insta-feed .slick-slider .slick-arrow.slick-prev" );
			$css->add_property( 'top', $css->render_range( $attr['arrowsVerticalPosition'], 'Tablet' ) );
		}
		if ( isset( $attr['arrowsSize'] ) ) {
			$css->set_selector( ".{$unique_id} .pbg-insta-feed .slick-slider .slick-arrow:before" );
			$css->add_property( 'font-size', $css->render_range( $attr['arrowsSize'], 'Tablet' ) );
		}
	}

	$css->stop_media_query();
	$css->start_media_query( 'mobile' );
	// Mobile Styles.
	// Container.
	if ( 'grid' === $attr['layoutStyle'] ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-posts-wrap" );
		$css->add_property( 'display', 'grid' );
		$css->add_property( 'grid-template-columns', 'repeat(' . $images_in_row['Mobile'] . ', 1fr)' );
	}
	if ( isset( $attr['containerBorder'] ) ) {
		$container_border_width  = $attr['containerBorder']['borderWidth'];
		$container_border_radius = $attr['containerBorder']['borderRadius'];

		$css->set_selector( ".{$unique_id} .pbg-insta-feed" );
		$css->add_property( 'border-width', $css->render_spacing( $container_border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $container_border_radius['Mobile'], 'px' ) );
	}

	if ( isset( $attr['containerMargin'] ) ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed" );
		$css->add_property( 'margin', $css->render_spacing( $attr['containerMargin']['Mobile'], isset( $attr['containerMargin']['unit']['Mobile'] ) ? $attr['containerMargin']['unit']['Mobile'] : $attr['containerMargin']['unit'] ) );
	}

	if ( isset( $attr['containerPadding'] ) ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed" );
		$css->add_property( 'padding', $css->render_spacing( $attr['containerPadding']['Mobile'], isset( $attr['containerPadding']['unit']['Mobile'] ) ? $attr['containerPadding']['unit']['Mobile'] : $attr['containerPadding']['unit'] ) );
	}

	// Image.
	if ( 'masonry' === $attr['layoutStyle'] ) {
		$post_width = ( 100 / $images_in_row['Mobile'] ) . '%';

		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap" );
		$css->add_property( 'width', $post_width );
	}
	if ( 'masonry' !== $attr['layoutStyle'] ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap img" );
		$css->add_property( 'height', $css->render_range( $attr['columnHeight'], 'Mobile' ) );
	}
	if ( isset( $attr['photoBorder'] ) ) {
		$container_border_width  = $attr['photoBorder']['borderWidth'];
		$container_border_radius = $attr['photoBorder']['borderRadius'];

		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap .pbg-insta-feed-media" );
		$css->add_property( 'border-width', $css->render_spacing( $container_border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $container_border_radius['Mobile'], 'px' ) );
	}

	if ( isset( $attr['photoMargin'] ) ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap .pbg-insta-feed-media" );
		$css->add_property( 'margin', $css->render_spacing( $attr['photoMargin']['Mobile'], isset( $attr['photoMargin']['unit']['Mobile'] ) ? $attr['photoMargin']['unit']['Mobile'] : $attr['photoMargin']['unit'] ) );
	}

	if ( isset( $attr['photoPadding'] ) ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap .pbg-insta-feed-media" );
		$css->add_property( 'padding', $css->render_spacing( $attr['photoPadding']['Mobile'], isset( $attr['photoPadding']['unit']['Mobile'] ) ? $attr['photoPadding']['unit']['Mobile'] : $attr['photoPadding']['unit'] ) );
	}

	if ( isset( $attr['photoHoverBorder'] ) ) {
		$container_border_width  = $attr['photoHoverBorder']['borderWidth'];
		$container_border_radius = $attr['photoHoverBorder']['borderRadius'];

		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap .pbg-insta-feed-media:hover" );
		$css->add_property( 'border-width', $css->render_spacing( $container_border_width['Mobile'], 'px' ) );
		$css->add_property( 'border-radius', $css->render_spacing( $container_border_radius['Mobile'], 'px' ) );
	}

	if ( isset( $attr['photoHoverMargin'] ) ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap .pbg-insta-feed-media:hover" );
		$css->add_property( 'margin', $css->render_spacing( $attr['photoHoverMargin']['Mobile'], isset( $attr['photoHoverMargin']['unit']['Mobile'] ) ? $attr['photoHoverMargin']['unit']['Mobile'] : $attr['photoHoverMargin']['unit'] ) );
	}

	// Caption.
	if ( isset( $attr['captionTypography'] ) ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap .pbg-insta-feed-caption" );
		$css->render_typography( $attr['captionTypography'], 'Mobile' );
	}

	if ( isset( $attr['captionPadding'] ) ) {
		$css->set_selector( ".{$unique_id} .pbg-insta-feed-wrap .pbg-insta-feed-caption" );
		$css->add_property( 'padding', $css->render_spacing( $attr['captionPadding']['Mobile'], isset( $attr['captionPadding']['unit']['Mobile'] ) ? $attr['captionPadding']['unit']['Mobile'] : $attr['captionPadding']['unit'] ) );
	}

	// Lightbox.
	if ( isset( $attr['clickAction'] ) && $attr['clickAction'] === 'lightBox' ) {
		if ( isset( $attr['lightBoxArrowsBorderRadius'] ) ) {
			$css->set_selector( ".{$unique_id}.wp-block-premium-instagram-feed-posts .pbg-lightbox button.pbg-arrow" );
			$css->add_property( 'border-radius', $css->render_range( $attr['lightBoxArrowsBorderRadius'], 'Mobile' ) );
		}
		if ( isset( $attr['lightBoxArrowsPadding'] ) ) {
			$css->set_selector( ".{$unique_id}.wp-block-premium-instagram-feed-posts .pbg-lightbox button.pbg-arrow" );
			$css->add_property( 'padding', $css->render_spacing( $attr['lightBoxArrowsPadding']['Mobile'], isset( $attr['lightBoxArrowsPadding']['unit']['Mobile'] ) ? $attr['lightBoxArrowsPadding']['unit']['Mobile'] : $attr['lightBoxArrowsPadding']['unit'] ) );
		}
		if ( isset( $attr['lightBoxArrowsSize'] ) ) {
			$css->set_selector( ".{$unique_id}.wp-block-premium-instagram-feed-posts .pbg-lightbox button.pbg-arrow .dashicons" );
			$css->add_property( 'font-size', $css->render_range( $attr['lightBoxArrowsSize'], 'Mobile' ) );
		}
	}

	// Carousel.
	if ( isset( $attr['layoutStyle'] ) && $attr['layoutStyle'] === 'carousel' ) {
		if ( isset( $attr['arrowsBorderRadius'] ) ) {
			$css->set_selector( ".{$unique_id} .pbg-insta-feed .slick-arrow" );
			$css->add_property( 'border-radius', $css->render_range( $attr['arrowsBorderRadius'], 'Mobile' ) );
		}
		if ( isset( $attr['arrowsPadding'] ) ) {
			$css->set_selector( ".{$unique_id} .pbg-insta-feed .slick-arrow" );
			$css->add_property( 'padding', $css->render_spacing( $attr['arrowsPadding']['Mobile'], isset( $attr['arrowsPadding']['unit']['Mobile'] ) ? $attr['arrowsPadding']['unit']['Mobile'] : $attr['arrowsPadding']['unit'] ) );
		}
		if ( isset( $attr['arrowsPosition'] ) ) {
			$css->set_selector( ".{$unique_id} .pbg-insta-feed .slick-slider .slick-arrow.slick-next" );
			$css->add_property( 'right', $css->render_range( $attr['arrowsPosition'], 'Mobile' ) );
			$css->set_selector( ".{$unique_id} .pbg-insta-feed .slick-slider .slick-arrow.slick-prev" );
			$css->add_property( 'left', $css->render_range( $attr['arrowsPosition'], 'Mobile' ) );
		}
		if ( isset( $attr['arrowsVerticalPosition'] ) ) {
			$css->set_selector( ".{$unique_id} .pbg-insta-feed .slick-slider .slick-arrow.slick-next" );
			$css->add_property( 'top', $css->render_range( $attr['arrowsVerticalPosition'], 'Mobile' ) );
			$css->set_selector( ".{$unique_id} .pbg-insta-feed .slick-slider .slick-arrow.slick-prev" );
			$css->add_property( 'top', $css->render_range( $attr['arrowsVerticalPosition'], 'Mobile' ) );
		}
		if ( isset( $attr['arrowsSize'] ) ) {
			$css->set_selector( ".{$unique_id} .pbg-insta-feed .slick-slider .slick-arrow:before" );
			$css->add_property( 'font-size', $css->render_range( $attr['arrowsSize'], 'Mobile' ) );
		}
	}

	$css->stop_media_query();

	return $css->css_output();
}

/**
 * Get Instagram Posts.
 *
 * @param string $access_token Instagram Access Token.
 *
 * @return array
 */
function pbg_get_instagram_posts( $access_token ) {
	$posts = array();
	if ( $access_token ) {
		$access_token = PBG_Blocks_Integrations::check_instagram_token( $access_token );
		$api_url      = sprintf( 'https://graph.instagram.com/me/media?fields=id,media_type,media_url,username,timestamp,permalink,caption,children,thumbnail_url&limit=200&access_token=%s', $access_token );

		$response = wp_remote_get(
			$api_url,
			array(
				'timeout'   => 60,
				'sslverify' => false,
			)
		);

		if ( ! is_wp_error( $response ) ) {
			$response = wp_remote_retrieve_body( $response );
			$posts    = json_decode( $response, true );
		}
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
	$posts_markup = '';
	$max_posts    = ( ! empty( $attr['maxImageNumbers'] ) ) ? $attr['maxImageNumbers'] : 6;
	$posts        = $posts['data'] ?? array();
	$posts        = array_slice( $posts, 0, $max_posts );
	foreach ( $posts ?? array() as $post ) {
		$media_url     = ( ! empty( $post['media_url'] ) ) ? $post['media_url'] : '';
		$permalink     = ( ! empty( $post['permalink'] ) ) ? $post['permalink'] : '';
		$caption       = ( ! empty( $post['caption'] ) ) ? $post['caption'] : '';
		$media_type    = ( ! empty( $post['media_type'] ) ) ? $post['media_type'] : '';
		$permalink     = ( ! empty( $post['permalink'] ) ) ? $post['permalink'] : '';
		$thumbnail_url = ( ! empty( $post['thumbnail_url'] ) ) ? $post['thumbnail_url'] : '';
		$content       = '';

		if ( 'VIDEO' === $media_type ) {
			$video_markup = sprintf(
				'<video controls>
					<source src="%s" type="video/mp4">
				</video>',
				$media_url
			);
			$content      = sprintf(
				'<img src="%s" alt="%s" />
				%s',
				$thumbnail_url,
				esc_attr( $caption ),
				'redirection' !== $attr['clickAction'] && $attr['displayVideoOnClick'] ? $video_markup : ''
			);
		} else {
			$content = sprintf(
				'<img src="%s" alt="%s" />',
				$media_url,
				esc_attr( $caption )
			);
		}

		if ( 'lightBox' === $attr['clickAction'] ) {
			$content = sprintf(
				'<a href="%s" data-fslightbox="pbg-insta-feed">%s</a>',
				$thumbnail_url ? $thumbnail_url : $media_url,
				$content
			);
		}

		$classes = array(
			'pbg-insta-feed-wrap',
		);

		if ( 'overlay' === $attr['captionStyle'] ) {
			$classes[] = 'overlay-caption';
		}
		$caption_max_words = ( ! empty( $attr['maxWords'] ) ) ? $attr['maxWords'] : false;
		$caption_words     = $caption_max_words ? wp_trim_words( $caption, $caption_max_words ) : $caption;
		$caption_words     = strlen( $caption_words ) === strlen( $caption ) ? $caption : $caption_words . '...';
		$caption_markup    = sprintf(
			'<div class="pbg-insta-feed-caption">%s</div>',
			$caption_words
		);
		$redirect_link     = sprintf( '<a href="%s" target="_blank" rel="noopener noreferrer" class="pbg-insta-feed-link"></a>', $permalink );
		$lowercase_media   = strtolower( $media_type );
		$post_markup       = sprintf(
			'<div class="%1$s">
				<div class="pbg-insta-feed-media %2$s">
					%3$s
					%4$s
					%5$s
					%6$s
				</div>
			</div>',
			implode( ' ', $classes ),
			"pbg-insta-{$lowercase_media}-wrap",
			'top' === $attr['captionStyle'] ? $caption_markup : '',
			$content,
			'redirection' === $attr['clickAction'] ? $redirect_link : '',
			'bottom' === $attr['captionStyle'] || 'overlay' === $attr['captionStyle'] ? $caption_markup : ''
		);

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
	$unique_id    = rand( 100, 10000 );
	$id           = 'premium-instagram-feed-posts-' . esc_attr( $unique_id );
	$block_id     = ( ! empty( $attributes['blockId'] ) ) ? $attributes['blockId'] : $id;
	$access_token = ( ! empty( $block->context['accessToken'] ) ) ? $block->context['accessToken'] : '';
	$layout_style = ( ! empty( $attributes['layoutStyle'] ) ) ? $attributes['layoutStyle'] : 'grid';
	$posts        = apply_filters( 'pbg_instagram_posts', pbg_get_instagram_posts( $access_token ) );
	$image_effect = ( ! empty( $attributes['imageEffect'] ) ) ? $attributes['imageEffect'] : 'none';
	add_filter(
		'premium_instagram_feed_localize_script',
		function ( $data ) use ( $block_id, $posts, $attributes ) {
			$data[ $block_id ] = array(
				'postsLength' => count( $posts['data'] ?? array() ),
				'attributes'  => $attributes
			);
			return $data;
		}
	);

	// Block css file from "assets/css" after run grunt task.
	if ( 'carousel' === $layout_style ) {
		wp_enqueue_style(
			'premium-instagram-feed-carousel',
			PREMIUM_BLOCKS_URL . 'assets/css/minified/carousel.min.css',
			array(),
			PREMIUM_BLOCKS_VERSION,
			'all'
		);
	}
	$classes = array( 'pbg-insta-feed' );
	if ( 'none' !== $image_effect ) {
		$classes[] = 'pbg-image-effect-' . $image_effect;
	}
	$posts_markup = pbg_get_instagram_posts_markup( $posts, $attributes );
	if ( '' === $posts_markup ) {
		return sprintf(
			'<div class="%1$s">
				<p>%2$s</p>
			</div>',
			'pbg-error-notice',
			__( 'Please fill the required fields: Access Token', 'premium-blocks-for-gutenberg' )
		);
	}
	$feed_markup = sprintf(
		'<div class="%1$s">
			%2$s
		</div>',
		implode( ' ', $classes ),
		'masonry' === $layout_style ? '<div class="pbg-masonry-container">' . $posts_markup . '</div>' : '<div class="pbg-insta-posts-wrap">' . $posts_markup . '</div>'
	);

	$container_attributes = get_block_wrapper_attributes(
		array(
			'class'   => $block_id,
			'data-id' => $block_id,
		)
	);

	$feed_markup = sprintf(
		'<div %1$s>%2$s</div>',
		$container_attributes,
		$feed_markup
	);

	return $feed_markup;
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


