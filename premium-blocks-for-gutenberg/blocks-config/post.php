<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
if ( ! class_exists( 'PBG_Post' ) ) {
	/**
	 * Class PBG_Post.
	 */
	class PBG_Post {
		/**
		 * Member Variable
		 *
		 * @since 1.18.1
		 * @var instance
		 */
		private static $instance;

		private static $settings;

    private static $block_helpers = null;

		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		private static $meta_separators = array(
			'dot' => '•',
			'space' => ' ',
			'comma' => ',',
			'dash' => '—',
			'pipe' => '|',
		);

		/**
		 * Constructor
		 */
		public function __construct() {
      self::$block_helpers = pbg_blocks_helper();
      $this->register_blocks();
		}

    /**
     * Registers the block types.
     */
		public function register_blocks() {
			if ( ! function_exists( 'register_block_type' ) ) {
				return;
			}

			register_block_type_from_metadata(
				PREMIUM_BLOCKS_PATH . '/blocks-config/post-carousel/block.json',
				array(
					'render_callback' => array( $this, 'get_post_carousel_content' ),
					'editor_style'    => 'premium-blocks-editor-css',
					'editor_script'   => 'pbg-blocks-js',
				)
			);

			register_block_type_from_metadata(
				PREMIUM_BLOCKS_PATH . '/blocks-config/post-grid/block.json',
				array(
					'render_callback' => array( $this, 'get_post_grid_content' ),
					'editor_style'    => 'premium-blocks-editor-css',
					'editor_script'   => 'pbg-blocks-js',
				)
			);
		}

    /**
     * Renders the post grid block on server.
     * @param array  $attributes Array of block attributes.
     * @param string $content Block content.
     * @param object $block Block instance.
     */
		public function get_post_grid_content( $attributes, $content, $block ) {
      $page_key = ! empty( $attributes['queryId'] ) 
        ? 'pbg-query-' . sanitize_key( $attributes['queryId'] ) . '-p' 
        : 'query-page';
      
      $paged = ! empty( $_GET[ $page_key ] ) ? max( 1, (int) $_GET[ $page_key ] ) : 1;

      $query = self::$block_helpers->get_query( $attributes, 'grid', $paged );

			ob_start();
			$this->get_post_html( $attributes, $query, 'grid' );
			return ob_get_clean();
		}

    /**
     * Renders the post carousel block on server.
     * @param array  $attributes Array of block attributes.
     * @param string $content Block content.
     * @param object $block Block instance.
     */
		public function get_post_carousel_content( $attributes, $content, $block ) {
      self::$settings['carousel'][ $attributes['blockId'] ] = $attributes;
      
			if ( self::$block_helpers->it_is_not_amp() ) {
        wp_register_script(
          'pbg-image-loaded',
          PREMIUM_BLOCKS_URL . 'assets/js/lib/imageLoaded.min.js',
          array( 'jquery' ),
          PREMIUM_BLOCKS_VERSION,
          true
        );
        wp_enqueue_style(
          'pbg-splide',
          PREMIUM_BLOCKS_URL . 'assets/css/minified/splide.min.css',
          array(),
          PREMIUM_BLOCKS_VERSION,
        );
        wp_register_script(
          'pbg-splide',
          PREMIUM_BLOCKS_URL . 'assets/js/lib/splide.min.js',
          array( 'jquery' ),
          PREMIUM_BLOCKS_VERSION,
          true
        );

        wp_register_script(
          'pbg-post-carousel',
          '',
          array('pbg-image-loaded', 'pbg-splide'),
          PREMIUM_BLOCKS_VERSION,
          true,
        );

        wp_enqueue_script('pbg-post-carousel');

        wp_scripts()->add_data('pbg-post-carousel', 'after', array());
        wp_add_inline_script('pbg-post-carousel', $this->add_post_dynamic_script());
			}

			$query = self::$block_helpers->get_query( $attributes, 'carousel' );

			ob_start();
			$this->get_post_html( $attributes, $query, 'carousel' );
			return ob_get_clean();
		}

    /**
     * Renders the post grid block on server.
     *
     * @param array  $attributes Array of block attributes.
     * @param object $query WP_Query object.
     * @param string $type Type of post display (carousel or grid).
     * @since 0.0.1
     */
		public function get_post_html( $attributes, $query, $type ) {
			if ( ! $query->have_posts() ) return;

			$is_carousel = 'carousel' === $type;
			$show_pagination = $attributes['pagination'] ?? false;
			$show_arrows = $is_carousel && $attributes['navigationArrow'] ;

			$wrap_classes = array(
				$is_carousel ? 'splide' : '',
				'premium-blog-wrap',
				'premium-blog-even',
				'premium-post-' . $type,
			);

			$outer_wrap_classes = array(
				'premium-blog',
				$attributes['blockId'],
				'wp-block-premium-post-' . $type,
				$attributes['className'] ?? '',
			);

			$arrow_svg_path = 'M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z';

			?>
			<div class="<?php echo esc_attr( implode( ' ', $outer_wrap_classes ) ); ?>">
				<section class="<?php echo esc_attr( implode( ' ', $wrap_classes ) ); ?>" aria-label="<?php echo esc_attr( 'premium-blog-carousel' ); ?>">
					<?php if ( $show_arrows ) : ?>
						<div class="splide__arrows">
							<button class="splide__arrow splide__arrow--prev">
								<svg width="20" height="20" viewBox="0 0 256 512" class="pbg-post-carousel-icons">
									<path d="<?php echo esc_attr( $arrow_svg_path ); ?>"></path>
								</svg>
							</button>
							<button class="splide__arrow splide__arrow--next">
								<svg width="20" height="20" viewBox="0 0 256 512" class="pbg-post-carousel-icons">
									<path d="<?php echo esc_attr( $arrow_svg_path ); ?>"></path>
								</svg>
							</button>
						</div>
					<?php endif; ?>

					<?php if ( $is_carousel ) : ?>
						<div class="splide__track">
							<ul class="splide__list">
					<?php endif; ?>

					<?php $this->posts_articles_markup( $query, $attributes, $type ); ?>

					<?php if ( $is_carousel ) : ?>
							</ul>
						</div>
					<?php endif; ?>
				</section>

				<?php if ( $show_pagination ) : ?>
					<div class="premium-blog-pagination-container">
						<?php echo $this->render_pagination( $query, $attributes ); ?>
					</div>
				<?php endif; ?>
			</div>
			<?php
		}

    /**
     * Render Posts HTML
     *
     * @param object $query WP_Query object.
     * @param array  $attributes Array of block attributes.
     * @param string $type Type of post display (carousel or grid).
     * @since 1.18.1
     */
    public function posts_articles_markup( $query, $attributes, $type ) {
      $post_count = $query->found_posts;
      $style = $attributes['style'] ?? 'classic';

      if ( 0 === $post_count ) {
        ?>
          <p class="premium-post__no-posts">
            <?php echo esc_html( $attributes['postDisplaytext'] ?? 'No Posts Found!' ); ?>
          </p>
				<?php
        return;
      }

      static $base_classes = null;
      if ( null === $base_classes ) {
        $base_classes = array(
          'container' => array( 'premium-blog-post-container' ),
          'outer' => array( 'premium-blog-post-outer-container' ),
          'content' => array( 'premium-blog-content-wrapper' ),
        );
      }

      $is_carousel = ( 'carousel' === $type );
      $is_cards_style = ( 'cards' === $style );
      $is_banner_style = ( 'banner' === $style );
      $show_image = $attributes['displayPostImage'];
      $post_container = array_merge( $base_classes['container'], array( 'premium-blog-skin-' . $style ) );
      $post_outer = $base_classes['outer'];
      $content_wrap = $base_classes['content'];
      $meta_taxonomies = is_array( $attributes['metaTaxonomies'] ) ? $attributes['metaTaxonomies'] : array();
      
      /**
       *  Backward compatibility: if showCategories is false, empty the meta_taxonomies
       *  Can be removed after few versions
       */
      if ( isset($attributes['showCategories']) && $attributes['showCategories'] === false ) {
        $meta_taxonomies = array();
      }

      while ( $query->have_posts() ) {
        $query->the_post();

        if ( $attributes['equalHeight']) {
          $post_outer[] = 'premium-post-equal-height';
        }

        if ( ! $show_image ) {
          $content_wrap[] = 'empty-thumb';
        }

        // Output carousel wrapper if needed
        if ( $is_carousel ) {
          ?>    
            <li class="splide__slide">
          <?php
        }

        $terms = array();
        foreach ( $meta_taxonomies as $taxonomy ) {
          $post_terms = get_the_term_list( $query->post->ID, $taxonomy, '<li>', '</li><li>', '</li>' );
          if ( ! is_wp_error( $post_terms ) && ! empty( $post_terms ) ) {
            $terms[] = $post_terms;
          }
        }

        ?>
          <div class="<?php echo esc_attr( implode( ' ', $post_outer ) ); ?>">
            <div class="<?php echo esc_attr( implode( ' ', $post_container ) ); ?>">
              <?php
              // Render post image
              $this->render_image( $attributes );

              // Render author thumbnail for cards style
              if ( $is_cards_style && $attributes['authorImg'] ) : ?>
                <div class="premium-blog-author-thumbnail">
                    <?php echo get_avatar( get_the_author_meta( 'ID' ), 128, '', get_the_author_meta( 'display_name' ) ); ?>
                </div>
              <?php endif; ?>

              <div class="<?php echo esc_attr( implode( ' ', $content_wrap ) ); ?>">
                <div class="premium-blog-content-wrapper-inner">
                  <div class="premium-blog-inner-container">
                    <?php
                    // Render taxonomies for banner style
                    if ( $is_banner_style && ! empty( $meta_taxonomies ) ) :
                      ?>
                      <div class="premium-blog-cats-container">
                        <ul class="post-categories">
                          <?php echo wp_kses_post( implode( $terms ) ); ?>
                        </ul>
                      </div>
                      <?php
                    endif;

                    // Render post title
                    $this->render_post_title( $attributes );

                    // Render meta for non-cards style
                    if ( ! $is_cards_style ) {
                      $this->render_meta( $attributes );
                    }
                    ?>
                  </div>
                  <?php
                  // Render post content
                  if ( $attributes['showContent'] ) {
                      $this->render_post_content( $attributes );
                  }

                  // Render meta for cards style
                  if ( $is_cards_style ) {
                      $this->render_meta( $attributes );
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
          <?php
          // Close carousel wrapper if needed
          if ( $is_carousel ) {
            ?>    
              </li>
            <?php
          }
          ?>
        <?php

      }

      wp_reset_postdata();
    }

    /**
     * Render The Post Image
     *
     * @param array $attributes Array of block attributes.
     */
    public function render_image( $attributes ) {
      $style = $attributes['style'] ?? 'classic';
      $target = $attributes['newTab'] ? '_blank' : '_self';
      
      if ( empty( $attributes['displayPostImage'] ) && $style !== 'banner' ) {
        return;
      }

      $thumbnail_id = get_post_thumbnail_id();
      $permalink = get_the_permalink();
      $is_modern_or_cards = in_array( $style, array( 'modern', 'cards' ), true );
      
      $wrap_image_classes = array(
        'premium-blog-thumbnail-container',
        'premium-blog-' . ( $attributes['hoverEffect'] ?? 'none' ) . '-effect',
      );

      $bottom_shape_classes = array( 'premium-shape-divider', 'premium-bottom-shape' );
      if ( ! empty( $attributes['shapeBottom']['flipShapeDivider'] ) ) {
        $bottom_shape_classes[] = 'premium-shape-flip';
      }
      if ( ! empty( $attributes['shapeBottom']['front'] ) ) {
        $bottom_shape_classes[] = 'premium-shape-above-content';
      }
      if ( ! empty( $attributes['shapeBottom']['invertShapeDivider'] ) ) {
        $bottom_shape_classes[] = 'premium-shape__invert';
      }

      $has_shape = ! empty( $attributes['shapeBottom']['openShape'] ) && ! empty( $attributes['shapeBottom']['style'] ) && ! empty( self::$block_helpers->getSvgShapes()[ $attributes['shapeBottom']['style'] ] );

      ?>
      <div class="premium-blog-thumb-effect-wrapper">
        <div class="<?php echo esc_attr( implode( ' ', $wrap_image_classes ) ); ?>">
          <?php if ( $is_modern_or_cards ) : ?>
            <a href="<?php echo esc_url( $permalink ); ?>" target="<?php echo esc_attr( $target ); ?>">
          <?php endif; ?>

          <?php if ( $thumbnail_id ) : ?>
            <?php echo wp_get_attachment_image( $thumbnail_id, $attributes['imageSize'] ); ?>
          <?php else : ?>
            <img src="<?php echo esc_url( PREMIUM_BLOCKS_URL . 'assets/img/author.jpg' ); ?>" alt="<?php echo esc_attr( get_the_title() ?? 'Post Featured Image' ); ?>" />
          <?php endif; ?>

          <?php if ( $is_modern_or_cards ) : ?>
            </a>
          <?php endif; ?>

          <?php if ( $has_shape ) : ?>
            <div class="<?php echo esc_attr( implode( ' ', $bottom_shape_classes ) ); ?>">
              <?php echo self::$block_helpers->getSvgShapes()[ $attributes['shapeBottom']['style'] ]; ?>
            </div>
          <?php endif; ?>
        </div>

        <?php if ( $is_modern_or_cards ) : ?>
          <div class="premium-blog-effect-container <?php echo esc_attr( 'premium-blog-' . $attributes['overlayEffect'] . '-effect' ); ?>">
            <a class="premium-blog-post-link" href="<?php echo esc_url( $permalink ); ?>" target="<?php echo esc_attr( $target ); ?>"></a>
            <?php if ( 'squares' === $attributes['overlayEffect'] ) : ?>
              <div class="premium-blog-squares-square-container"></div>
            <?php endif; ?>
          </div>
        <?php else : ?>
          <div class="premium-blog-thumbnail-overlay">
            <a href="<?php echo esc_url( $permalink ); ?>" target="<?php echo esc_attr( $target ); ?>"></a>
          </div>
        <?php endif; ?>
      </div>
      <?php
    }

    /**
     * Render The Post Title
     * 
     * @param object $query WP_Query object.
     * @param array $attributes Array of block attributes.
     */
    public function render_pagination( $query, $attributes ) {
      if ( empty( $query ) || ! $query->max_num_pages || $query->max_num_pages <= 1 ) {
        return '';
      }

      $page_key = ! empty( $attributes['queryId'] ) 
        ? 'pbg-query-' . sanitize_key( $attributes['queryId'] ) . '-p' 
        : 'query-page';
      
      $paged = ! empty( $_GET[ $page_key ] ) ? max( 1, (int) $_GET[ $page_key ] ) : 1;

      static $permalink_structure = null;
      if ( null === $permalink_structure ) {
        $permalink_structure = get_option( 'permalink_structure' );
      }

      $base = self::$block_helpers->build_base_url( 
        $permalink_structure, 
        untrailingslashit( wp_specialchars_decode( get_pagenum_link() ) ) 
      );

      $page_limit = isset( $attributes['pageLimit'] ) && $attributes['pageLimit'] > 0
        ? min( $attributes['pageLimit'], $query->max_num_pages )
        : $query->max_num_pages;

      // Prepare pagination arguments
      $pagination_args = array(
        'base'      => $base . '%_%',
        'format'    => "?$page_key=%#%",
        'current'   => $paged,
        'total'     => $page_limit,
        'type'      => 'array',
        'mid_size'  => 4,
        'end_size'  => 4,
        'prev_next' => ! empty( $attributes['showPrevNext'] ),
        'prev_text' => $attributes['prevString'],
        'next_text' => $attributes['nextString'],
      );

      $links = paginate_links( $pagination_args );

      return ! empty( $links ) ? wp_kses_post( implode( PHP_EOL, $links ) ) : '';
    }

    /**
     * Render The Post Title
     *
     * @param array $attributes Array of block attributes.
     */
    public function render_post_title( $attributes ) {
      $target = ( $attributes['newTab'] ?? false ) ? '_blank' : '_self';
      $allowed_title_tags = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' );
      $title_tag = $attributes['level'] ?? 'h2';
      $title_tag = in_array($title_tag, $allowed_title_tags, true) ? sanitize_key($title_tag) : 'h2';

      ?>
        <<?php echo esc_html( $title_tag ); ?> class="premium-blog-entry-title">
          <a href="<?php the_permalink(); ?>" target="<?php echo esc_attr( $target ); ?>" rel="bookmark noopener noreferrer">
            <?php echo esc_html( get_the_title() ); ?>
          </a>
        </<?php echo esc_html( $title_tag ); ?>>
      <?php
    }

    /**
     * Render Post Meta - Author HTML.
     *
     * @param array $attributes Array of block attributes.
     *
     * @since 1.14.0
     */
    public function render_meta_author( $attributes ) {
      if ( empty( $attributes['showAuthor'] ) ) {
        return;
      }

      ?>
        <div class="premium-blog-post-author premium-blog-meta-data">
            <svg id="Layer_1" xmlns="http://www.w3.org/2000/svg" width="22" height="24" viewBox="0 0 22 24" aria-hidden="true"><path id="Author" class="cls-1" d="m0,20.63c0,2.74,5.72,3.36,11,3.37,5.28,0,11-.62,11-3.37,0-3.63-3.93-4.85-7.25-5.96-.24-.07-1.25-.67-1.25-2.23,1.65-1.56,3.4-4.11,3.4-6.61,0-3.83-2.71-5.84-5.9-5.84s-5.9,2-5.9,5.84c0,2.5,1.75,5.05,3.4,6.61,0,1.56-1.01,2.15-1.25,2.23-3.32,1.11-7.25,2.33-7.25,5.96Z"/></svg>
            <?php echo get_the_author_posts_link(); ?>
        </div>
      <?php
    }

    /**
     * Render Post Meta - Date HTML.
     *
     * @param array $attributes Array of block attributes.
     *
     * @since 1.14.0
     */
    public function render_meta_date( $attributes ) {
      if ( empty( $attributes['showDate'] ) ) {
        return;
      }

      if( ! empty ( $attributes['showAuthor'] ) ) {
        ?>
          <span class="premium-blog-meta-separator">
            <?php echo esc_html( self::$meta_separators[ $attributes['metaSeparator'] ] ); ?>
          </span>
        <?php
      }

      ?>
        <div class="premium-blog-post-time premium-blog-meta-data">
          <svg id="Layer_1" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" aria-hidden="true"><path id="Date" class="cls-1" d="m20.93,6.54c-.07-.9-.23-1.64-.57-2.32-.56-1.11-1.47-2.01-2.57-2.57-.68-.35-1.42-.5-2.32-.57-.89-.07-1.99-.07-3.41-.07h-2.11c-1.42,0-2.51,0-3.41.07-.9.07-1.64.23-2.32.57-1.11.56-2.01,1.47-2.57,2.57-.35.68-.5,1.42-.57,2.32-.07.89-.07,1.99-.07,3.41v2.11c0,1.42,0,2.51.07,3.41.07.9.23,1.64.57,2.32.56,1.11,1.47,2.01,2.57,2.57.68.35,1.42.5,2.32.57.89.07,1.99.07,3.41.07h2.11c1.42,0,2.51,0,3.41-.07.9-.07,1.64-.23,2.32-.57,1.11-.56,2.01-1.47,2.57-2.57.35-.68.5-1.42.57-2.32.07-.89.07-1.99.07-3.41v-2.11c0-1.42,0-2.51-.07-3.41Zm-4.72,9.92c-.2.19-.45.29-.71.29s-.51-.1-.71-.29l-4.5-4.5c-.18-.19-.29-.44-.29-.71v-5c0-.55.45-1,1-1s1,.45,1,1v4.59l4.21,4.2c.39.39.39,1.03,0,1.42Z"/></svg>
          <span><?php echo esc_html( get_the_date() ); ?></span>
        </div>
      <?php
    }

    /**
		 * Render Post Meta - Comment HTML.
		 *
		 * @param array $attributes Array of block attributes.
		 *
		 * @since 1.14.0
		 */
		public function render_meta_taxonomy( $attributes ) {
			// Check for both new metaTaxonomies and old showCategories for backward compatibility
			if ( ( empty( $attributes['metaTaxonomies'] ) && empty( $attributes['showCategories'] ) ) || $attributes['style'] === 'banner' ) {
				return;
			}

			global $post;

			$meta_taxonomies = is_array( $attributes['metaTaxonomies'] ) ? $attributes['metaTaxonomies'] : array();
			
			/**
       *  Backward compatibility: if showCategories is false, empty the meta_taxonomies
       *  Can be removed after few versions
       */
			if ( isset($attributes['showCategories']) && $attributes['showCategories'] === false ) {
        $meta_taxonomies = array();
      }

      $terms = array();
      foreach ( $meta_taxonomies as $taxonomy ) {
        $post_terms = get_the_term_list( $post->ID, $taxonomy, '', ',&nbsp;' );
        if ( ! is_wp_error( $post_terms ) && ! empty( $post_terms ) ) {
          $terms[] = $post_terms;
        }
      }

      if ( is_wp_error( $terms ) || empty( $terms ) ) {
				return;
			}

      if( ! empty ( $attributes['showAuthor'] ) || ! empty ( $attributes['showDate'] ) ) {
        ?>
          <span class="premium-blog-meta-separator">
            <?php echo esc_html( self::$meta_separators[ $attributes['metaSeparator'] ] ); ?>
          </span>
        <?php
      }

      ?>
        <div class="premium-blog-post-categories premium-blog-meta-data">
          <svg id="Layer_1" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" aria-hidden="true"><path id="Categories" class="cls-1" d="m2,4c0,.55.45,1,1,1h16c.55,0,1-.45,1-1s-.45-1-1-1H3c-.55,0-1,.45-1,1Zm0,5c0,.55.45,1,1,1h11c.55,0,1-.45,1-1s-.45-1-1-1H3c-.55,0-1,.45-1,1Zm0,5h0c0-.55.45-1,1-1h16c.55,0,1,.45,1,1h0c0,.55-.45,1-1,1H3c-.55,0-1-.45-1-1Zm1,6c-.55,0-1-.45-1-1s.45-1,1-1h7c.55,0,1,.45,1,1s-.45,1-1,1H3Z"/></svg>
          <?php echo wp_kses_post( implode( ',&nbsp;', $terms ) ); ?>
        </div>
      <?php
		}

		/**
		 * Render Post Meta - Comment HTML.
		 *
		 * @param array $attributes Array of block attributes.
		 *
		 * @since 1.14.0
		 */
    public function render_meta_comment( $attributes ) {
      if ( empty( $attributes['showComments'] ) ) {
        return;
      }

      static $comments_strings = null;
      if ( null === $comments_strings ) {
        $comments_strings = array(
          'no-comments'       => __( 'No Comments', 'premium-blocks-for-gutenberg' ),
          'one-comment'       => __( '1 Comment', 'premium-blocks-for-gutenberg' ),
          'multiple-comments' => __( '% Comments', 'premium-blocks-for-gutenberg' ),
        );
      }

      $meta_taxonomies = is_array( $attributes['metaTaxonomies'] ) ? $attributes['metaTaxonomies'] : array();
      
      /**
       *  Backward compatibility: if showCategories is false, empty the meta_taxonomies
       *  Can be removed after few versions
       */
      if ( isset($attributes['showCategories']) && $attributes['showCategories'] === false ) {
        $meta_taxonomies = array();
      }

      if( ! empty ( $attributes['showAuthor'] ) || ! empty ( $attributes['showDate'] ) || ! empty ( $meta_taxonomies ) ) {
        ?>
          <span class="premium-blog-meta-separator">
            <?php echo esc_html( self::$meta_separators[ $attributes['metaSeparator'] ] ); ?>
          </span>
        <?php
      }

      ?>
        <div class="premium-blog-post-comments premium-blog-meta-data">
          <svg id="Layer_1" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" aria-hidden="true"><path id="Comments" class="cls-1" d="m11,0C5.03,0,0,4.38,0,10c0,2.63,1.45,5.01,3.48,6.71,1.79,1.49,4.11,2.52,6.52,2.74v1.55c0,.33.16.64.44.83.27.18.62.22.93.1,1.76-.71,4.37-2.14,6.55-4.13,2.17-1.97,4.08-4.64,4.08-7.8C22,4.38,16.97,0,11,0Zm-5,11.5c-.83,0-1.5-.67-1.5-1.5s.67-1.5,1.5-1.5,1.5.67,1.5,1.5-.67,1.5-1.5,1.5Zm5,0c-.83,0-1.5-.67-1.5-1.5s.67-1.5,1.5-1.5,1.5.67,1.5,1.5-.67,1.5-1.5,1.5Zm5,0c-.83,0-1.5-.67-1.5-1.5s.67-1.5,1.5-1.5,1.5.67,1.5,1.5-.67,1.5-1.5,1.5Z"/></svg>
          <?php 
            comments_popup_link( 
              $comments_strings['no-comments'], 
              $comments_strings['one-comment'], 
              $comments_strings['multiple-comments'], 
              '', 
              $comments_strings['no-comments'] 
            ); 
          ?>
        </div>
      <?php
    }

		/**
		 * Render Post Meta HTML.
		 *
		 * @param array $attributes Array of block attributes.
		 */
		public function render_meta( $attributes ) {	
      ?>
        <div class="premium-blog-entry-meta">
          <?php
            static $meta_sequence = array( 'author', 'date', 'taxonomy', 'comment' );

            foreach ( $meta_sequence as $sequence ) {
              switch ( $sequence ) {
                  case 'author':
                      $this->render_meta_author( $attributes );
                      break;
                  case 'date':
                      $this->render_meta_date( $attributes );
                      break;
                  case 'taxonomy':
                      $this->render_meta_taxonomy( $attributes );
                      break;
                  case 'comment':
                      $this->render_meta_comment( $attributes );
                      break;
              }
            }
          ?>
        </div>
      <?php
		}

		/**
		 * Render Post Excerpt HTML.
		 *
		 * @param array $attributes Array of block attributes.
		 *
		 * @since 0.0.1
		 */
		public function render_post_content( $attributes ) {
			$show_content = $attributes['showContent'];
			$post_content_type = $attributes['displayPostExcerpt'];
			$excerpt_type = $attributes['excerptTypeLink'];
			$excerpt_text = $attributes['readMoreText'];
			$length       = $attributes['excerptLen'];

      if( ! $show_content ) {
        return '';
      }

      if ( 'Post Full Content' === $post_content_type && ! empty ( get_the_content() ) ) {
        ?>
        <div class="premium-blog-post-content">
          <?php the_content() ?>
        </div>
        <?php
			} elseif ( 'Post Excerpt' === $post_content_type && ! empty ( get_the_excerpt() ) ) {
        $excerpt = wp_strip_all_tags( get_the_excerpt() );
			  $excerpt = wp_trim_words( $excerpt, $length, ' ...' );
        ?>
        <p class="premium-blog-post-content">
          <?php echo esc_html( $excerpt ); ?>
        </p>
        <?php
			}

			if ( $excerpt_type && ! empty( $excerpt_text ) ) {
        ?>
          <div class="premium-blog-excerpt-link-wrap">
            <a class="premium-blog-excerpt-link wp-block-button__link <?php echo esc_attr( $attributes['fullWidth'] ? 'premium-blog-full-link' : '' ); ?>" href="<?php echo esc_url( get_the_permalink() ); ?>">
              <?php echo esc_html( $excerpt_text ); ?>
            </a>
          </div>
        <?php
			}
		}

    /**
     * Add Dynamic JS for Post Carousel
     */
		public function add_post_dynamic_script() {
			if ( empty( self::$settings['carousel'] ) || ! is_array( self::$settings['carousel'] ) ) {
				return '';
			}

			$css = new Premium_Blocks_css();
			$is_rtl = is_rtl();
			$carousel_configs = array();

			foreach ( self::$settings['carousel'] as $key => $value ) {
				if ( empty( $value ) || ! is_array( $value ) ) {
					continue;
				}

				$desktop_gap = $css->pbg_render_range( $value, 'columnGap', 'gap', 'Desktop' );
				$tablet_gap = $css->pbg_render_range( $value, 'columnGap', 'gap', 'Tablet' );
				$mobile_gap = $css->pbg_render_range( $value, 'columnGap', 'gap', 'Mobile' );
				
				$desktop_width = $css->pbg_render_range( $value, 'slidesWidth', 'width', 'Desktop' );
				$tablet_width = $css->pbg_render_range( $value, 'slidesWidth', 'width', 'Tablet' );
				$mobile_width = $css->pbg_render_range( $value, 'slidesWidth', 'width', 'Mobile' );

				// Prepare configuration data
				$carousel_configs[ $key ] = array(
					'desktop_cols' => intval( $value['columns']['Desktop'] ?? 2 ),
					'tablet_cols' => intval( $value['columns']['Tablet'] ?? 2 ),
					'mobile_cols' => intval( $value['columns']['Mobile'] ?? 1 ),
					'per_page' => intval( $value['query']['perPage'] ?? 1 ),
					'slide_to_scroll' => intval( $value['slideToScroll'] ?? 1 ),
					'infinite_loop' => !empty( $value['infiniteLoop'] ),
					'autoplay' => !empty( $value['Autoplay'] ),
					'pause_on_hover' => !empty( $value['pauseOnHover'] ),
					'navigation_arrow' => !empty( $value['navigationArrow'] ),
					'navigation_dots' => !empty( $value['navigationDots'] ),
					'autoplay_speed' => intval( $value['autoplaySpeed'] ?? 3000 ),
					'fixed_width' => !empty( $value['fixedWidth'] ),
					'gaps' => array(
						'desktop' => $desktop_gap,
						'tablet' => $tablet_gap,
						'mobile' => $mobile_gap,
					),
					'widths' => array(
						'desktop' => $desktop_width,
						'tablet' => $tablet_width,
						'mobile' => $mobile_width,
					),
				);
			}

			if ( empty( $carousel_configs ) ) {
				return;
			}

      ob_start();
			?>
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          const carouselConfigs = <?php echo wp_json_encode( $carousel_configs ); ?>;
          const isRTL = <?php echo wp_json_encode( $is_rtl ); ?>;

          function initCarousel(blockClass, config) {
            const scope = document.querySelector('.' + blockClass + ' .splide .splide__track .splide__list');
            if (!scope) return;

            let desktopCols = config.desktop_cols;
            if (desktopCols > scope.children.length) {
              desktopCols = Math.min(scope.children.length, 1);
            }

            const carouselSettings = {
              type: config.infinite_loop ? 'loop' : 'slide',
              perPage: desktopCols,
              perMove: config.slide_to_scroll,
              autoplay: config.autoplay,
              pauseOnHover: config.pause_on_hover,
              arrows: config.navigation_arrow,
              pagination: config.navigation_dots,
              interval: config.autoplay_speed,
              speed: 500,
              direction: isRTL ? 'rtl' : 'ltr',
              gap: config.gaps.desktop,
              breakpoints: {
                1024: {
                  perPage: Math.min(config.tablet_cols, config.per_page, scope.children.length) || 1,
                  perMove: 1,
                  focus: 0,
                  omitEnd: true,
                  ...(config.gaps.tablet && { gap: config.gaps.tablet }),
                  ...(config.fixed_width && config.widths.tablet && { fixedWidth: config.widths.tablet }),
                },
                767: {
                  perPage: Math.min(config.mobile_cols, config.per_page, scope.children.length) || 1,
                  perMove: 1,
                  focus: 0,
                  omitEnd: true,
                  ...(config.gaps.mobile && { gap: config.gaps.mobile }),
                  ...(config.fixed_width && config.widths.mobile && { fixedWidth: config.widths.mobile }),
                }
              }
            };

            if (config.slide_to_scroll === 1) {
              carouselSettings.focus = 0;
              carouselSettings.omitEnd = true;
            }

            if (config.fixed_width && config.widths.desktop) {
              carouselSettings.fixedWidth = config.widths.desktop;
            }

            if (typeof imagesLoaded === 'function') {
              imagesLoaded(scope, function() {
                const splide = new Splide('.' + blockClass + ' .splide', carouselSettings);
                splide.mount();
              });
            } else {
              const splide = new Splide('.' + blockClass + ' .splide', carouselSettings);
              splide.mount();
            }
          }

          Object.keys(carouselConfigs).forEach(function(blockClass) {
            initCarousel(blockClass, carouselConfigs[blockClass]);
          });
        });
      </script>
			<?php

      return strip_tags( ob_get_clean() );
		}

    /**
     * Generate the CSS for Post Block
     * @param array  $attr Array of block attributes.
     * @param string $unique_id Unique ID of the block.
     */
		public function get_premium_post_css_style( $attr, $unique_id ) {
			$css                    = new Premium_Blocks_css();
			
      $is_advanced_border = $css->pbg_get_value($attr, 'advancedBorder');
      
      $css->set_selector( '.' . $unique_id . ' .premium-post-grid .premium-blog-post-outer-container' );
      $css->pbg_render_value($attr, 'columns', 'width', 'Desktop', 'calc(100% / ', ')');
      $css->pbg_render_range($attr, 'columnGap', 'padding-right', 'Desktop', 'calc( ', ' / 2 )');
      $css->pbg_render_range($attr, 'columnGap', 'padding-left', 'Desktop', 'calc( ', ' / 2 )');
      $css->pbg_render_spacing($attr, 'margin', 'padding', 'Desktop');

      $css->set_selector( '.' . $unique_id . ' .premium-post-grid.premium-blog-wrap' );
      $css->pbg_render_range($attr, 'columnGap', 'margin-right', 'Desktop', 'calc( -', ' / 2 )');
      $css->pbg_render_range($attr, 'columnGap', 'margin-left', 'Desktop', 'calc( -', ' / 2 )');
      $css->pbg_render_range($attr, 'rowGap', 'row-gap', 'Desktop');
			
      $css->set_selector( '.' . $unique_id . ' .premium-blog-thumbnail-container:before , .' . $unique_id . ' .premium-blog-thumbnail-container:after' );
      $css->pbg_render_color($attr, 'plusColor', 'background-color');
			
      $css->set_selector( '.' . $unique_id . ' .premium-blog-post-link:before, .' . $unique_id . ' .premium-blog-post-link:after' );
      $css->pbg_render_color($attr, 'borderedColor', 'border-color');
		
      $css->set_selector( '.' . $unique_id . ' .premium-blog-skin-modern .premium-blog-content-wrapper' );
      $css->pbg_render_range($attr, 'contentOffset', 'top', 'Desktop');
			
      $css->set_selector( '.' . $unique_id . ' .premium-blog-author-thumbnail' );
      $css->pbg_render_range($attr, 'authorImgPosition', 'top', 'Desktop');
			
      $css->set_selector( '.' . $unique_id . ' .premium-blog-post-container.premium-blog-skin-banner .premium-blog-content-wrapper' );
      $css->pbg_render_value($attr, 'verticalAlign', 'justify-content', 'Desktop');
			
      $css->set_selector( '.' . $unique_id . ' .premium-blog-post-container' );
      $css->pbg_render_shadow($attr, 'boxShadow', 'box-shadow');
      $css->pbg_render_color($attr, 'ContainerBackground', 'background-color');
      $css->pbg_render_border($attr, 'border', 'Desktop');
      $css->pbg_render_spacing($attr, 'padding', 'padding', 'Desktop');
			if ( $is_advanced_border ) {
        $css->pbg_render_value($attr, 'advancedBorderValue', 'border-radius', null, null, '!important');
			}
		
      $css->set_selector( '.' . $unique_id . ' .post-categories , .'. $unique_id . '  .premium-blog-post-tags-container, .' . $unique_id . ' .premium-blog-entry-meta');
      $css->pbg_render_align_self($attr, 'align', 'justify-content', 'Desktop');

      $css->set_selector( '.' . $unique_id . ' .premium-blog-inner-container');
      $css->pbg_render_align_self($attr, 'align', 'align-items', 'Desktop');

      $css->set_selector( '.' . $unique_id . ' .premium-blog-post-container > .premium-blog-content-wrapper ' );
      $css->pbg_render_color($attr, 'contentBackground', 'background-color');
      $css->pbg_render_shadow($attr, 'contentBoxShadow', 'box-shadow');
      $css->pbg_render_value($attr, 'align', 'text-align', 'Desktop');
      $css->pbg_render_spacing($attr, 'contentPadding', 'padding', 'Desktop');
      $css->pbg_render_spacing($attr, 'contentBoxMargin', 'margin', 'Desktop');

      $css->set_selector( '.' . $unique_id . ' .premium-blog-post-container .premium-blog-content-wrapper-inner p' );
      $css->pbg_render_typography( $attr, 'contentTypography', 'Desktop' );
      $css->pbg_render_spacing($attr, 'contentMargin', 'margin', 'Desktop');
      $css->pbg_render_color($attr, 'contentColor', 'color');
      
      // Title Styles
      $css->set_selector( '.' . $unique_id . ' .premium-blog-post-container .premium-blog-entry-title' );
      $css->pbg_render_typography($attr, 'titleTypography', 'Desktop');
      $css->pbg_render_range($attr, 'titleBottomSpacing', 'margin-bottom', 'Desktop');
      $css->pbg_render_color($attr, 'titleColor', 'color');

      $css->set_selector( '.' . $unique_id . ' .premium-blog-post-container .premium-blog-entry-title > *' );
      $css->pbg_render_typography($attr, 'titleTypography', 'Desktop');

      $css->set_selector( '.' . $unique_id . ' .premium-blog-post-container .premium-blog-entry-title:hover' );
      $css->pbg_render_color($attr, 'titleHoverColor', 'color');

      // Shape Styles
      $css->set_selector( '.' . $unique_id . ' .premium-blog-post-container .premium-bottom-shape svg' );
      $css->pbg_render_range($attr, 'shapeBottom.width', 'width', 'Desktop');
      $css->pbg_render_range($attr, 'shapeBottom.height', 'height', 'Desktop');
      $css->pbg_render_color($attr, 'shapeBottom.color', 'fill');

			// Meta
      $css->set_selector( '.' . $unique_id . ' .premium-blog-meta-data, .' . $unique_id . ' .premium-blog-meta-data a' );
      $css->pbg_render_typography( $attr, 'metaTypography', 'Desktop' );

      $css->set_selector( '.' . $unique_id . ' .premium-blog-meta-data' );
      $css->pbg_render_color($attr, 'metaColor', 'color');
      $css->pbg_render_color($attr, 'metaColor', 'fill');

      $css->set_selector( '.' . $unique_id . ' .premium-blog-meta-data :is(svg, svg .cls-1)');
      $css->pbg_render_range($attr, 'metaTypography.fontSize', 'width', 'Desktop');
      $css->pbg_render_range($attr, 'metaTypography.fontSize', 'height', 'Desktop');

      $css->set_selector( '.' . $unique_id . ' .premium-blog-meta-data:has(a):hover' );
      $css->pbg_render_color($attr, 'metaHoverColor', 'color');
      $css->pbg_render_color($attr, 'metaHoverColor', 'fill');

      $css->set_selector( '.' . $unique_id . ' .premium-blog-entry-meta .premium-blog-meta-separator' );
      $css->pbg_render_color($attr, 'sepColor', 'color');
      
			// Image
      $hover_effect = $css->pbg_get_value($attr, 'hoverEffect');

      $css->set_selector( '.' . $unique_id . ' .premium-blog-post-outer-container img' );
      $css->pbg_render_value($attr, 'thumbnail', 'object-fit');
      if(in_array($hover_effect, ['zoomin', 'zoomout', 'scale' , 'trans'])){
        $css->pbg_render_filters($attr, 'filter');

        $css->set_selector( '.' . $unique_id . ' .premium-blog-post-outer-container:hover img' );
        $css->pbg_render_filters($attr, 'Hoverfilter');
      }

      $css->set_selector( '.' . $unique_id . ' .premium-blog-thumbnail-container img');
      $css->pbg_render_range($attr, 'height', 'height', 'Desktop', null, '!important');

      $css->set_selector( '.' . $unique_id . ' .premium-blog-thumbnail-overlay  , .' . $unique_id . ' .premium-blog-framed-effect , .' . $unique_id . ' .premium-blog-bordered-effect, .' . $unique_id . ' .premium-blog-squares-effect:before , .' . $unique_id . ' .premium-blog-squares-effect:after , .' . $unique_id . '  .premium-blog-squares-square-container:before, .' . $unique_id . ' .premium-blog-squares-square-container:after' );
      $css->pbg_render_color($attr, 'colorOverlay', 'background-color');

      $css->set_selector( '.' . $unique_id . ' .premium-blog-post-container:hover  .premium-blog-thumbnail-overlay  , .' . $unique_id . ' .premium-blog-post-container:hover  .premium-blog-framed-effect , .' . $unique_id . ' .premium-blog-post-container:hover  .premium-blog-bordered-effect, .' . $unique_id . ' .premium-blog-post-container:hover  .premium-blog-squares-effect:before , .' . $unique_id . ' .premium-blog-post-container:hover  .premium-blog-squares-effect:after , .' . $unique_id . ' .premium-blog-post-container:hover   .premium-blog-squares-square-container:before, .' . $unique_id . ' .premium-blog-post-container:hover  .premium-blog-squares-square-container:after' );
      $css->pbg_render_color($attr, 'colorOverlayHover', 'background-color');
			
			// Excerpt Link Styles
      $css->set_selector( '.' . $unique_id . ' .premium-blog-content-wrapper .premium-blog-excerpt-link' );
      $css->pbg_render_color($attr, 'buttonColor', 'color');
      $css->pbg_render_color($attr, 'buttonBackground', 'background-color');
      $css->pbg_render_range($attr, 'buttonSpacing', 'margin-top', 'Desktop');
      $css->pbg_render_typography( $attr, 'btnTypography', 'Desktop' );
      $css->pbg_render_border($attr, 'btnBorder', 'Desktop');
      $css->pbg_render_spacing($attr, 'btnPadding', 'padding', 'Desktop');

      $css->set_selector( '.' . $unique_id . ' .premium-blog-content-wrapper .premium-blog-excerpt-link:hover' );
      $css->pbg_render_color($attr, 'buttonhover', 'color');
      $css->pbg_render_color($attr, 'hoverBackground', 'background-color');
      $css->pbg_render_border($attr, 'btnBorderHover', 'Desktop');

      // Carousel Styles
      $css->set_selector( '.' . $unique_id . ' .splide .splide__arrows .splide__arrow' );
      $css->pbg_render_color($attr, 'arrowBack', 'background-color');
      $css->pbg_render_range($attr, 'borderRadius', 'border-radius', null, null, 'px');
      $css->pbg_render_spacing($attr, 'arrowPadding', 'padding', 'Desktop');
			
      $css->set_selector( '.' . $unique_id . ' .splide .splide__arrows .splide__arrow svg' );
      $css->pbg_render_range($attr, 'arrowSize', 'width', null, null, 'px');
      $css->pbg_render_range($attr, 'arrowSize', 'height', null, null, 'px');
      $css->pbg_render_color($attr, 'arrowColor', 'fill');

      $css->set_selector( '.' . $unique_id . ' .splide .splide__arrows.splide__arrows--ltr .splide__arrow--prev, .' . $unique_id . ' .splide .splide__arrows.splide__arrows--rtl .splide__arrow--next');
      $css->pbg_render_range($attr, 'arrowPosition', 'left', 'Desktop');
			
      $css->set_selector( '.' . $unique_id . ' .splide .splide__arrows.splide__arrows--ltr .splide__arrow--next, .' . $unique_id . ' .splide .splide__arrows.splide__arrows--rtl .splide__arrow--prev');
      $css->pbg_render_range($attr, 'arrowPosition', 'right', 'Desktop');
      
      $css->set_selector( '.' . $unique_id . ' .splide .splide__pagination .splide__pagination__page' );
      $css->pbg_render_color($attr, 'dotsColor', 'background-color');
      $css->pbg_render_spacing($attr, 'dotMargin', 'margin', 'Desktop');
      
			$css->set_selector( '.' . $unique_id . ' .splide .splide__pagination .splide__pagination__page.is-active' );
      $css->pbg_render_color($attr, 'dotsActiveColor', 'background-color');

      // Categories Styles For Banner
      $css->set_selector( '.' . $unique_id . ' .premium-blog-cats-container a' );
      $css->pbg_render_color($attr, 'catColor', 'color');
      $css->pbg_render_color($attr, 'backCat', 'background-color');
      $css->pbg_render_typography( $attr, 'catTypography', 'Desktop' );
      $css->pbg_render_border($attr, 'catBorder', 'Desktop');
      $css->pbg_render_spacing($attr, 'catPadding', 'padding', 'Desktop');

      // Categories Hover Styles For Banner
      $css->set_selector( '.' . $unique_id . ' .premium-blog-cats-container a:hover' );
      $css->pbg_render_color($attr, 'hoverCatColor', 'color');
      $css->pbg_render_color($attr, 'backHoverCat', 'background-color');
      
      // Pagination
      $css->set_selector( '.' . $unique_id .' .premium-blog-pagination-container');
      $css->pbg_render_align_self($attr, 'paginationPosition', 'justify-content', 'Desktop');

      $css->set_selector('.' . $unique_id . ' .premium-blog-pagination-container .page-numbers');
      $css->pbg_render_color($attr, 'paginationColor', 'color');
      $css->pbg_render_color($attr, 'paginationBackColor', 'background-color');
      $css->pbg_render_border($attr, 'paginationBorder', 'Desktop');
      $css->pbg_render_typography( $attr, 'paginationTypography', 'Desktop' );
      $css->pbg_render_spacing($attr, 'paginationPadding', 'padding', 'Desktop');
      $css->pbg_render_spacing($attr, 'paginationMargin', 'margin', 'Desktop');
			
			// Pagination Hover
      $css->set_selector('.' . $unique_id . ' .premium-blog-pagination-container .page-numbers:hover');
      $css->pbg_render_color($attr, 'paginationHoverColor', 'color');
      $css->pbg_render_color($attr, 'paginationHoverback', 'background-color');
      $css->pbg_render_border($attr, 'paginationHoverBorder', 'Desktop');
			
			// Pagination Active
      $css->set_selector('.' . $unique_id . ' .premium-blog-pagination-container span.page-numbers.current');
      $css->pbg_render_color($attr, 'paginationActiveColor', 'color');
      $css->pbg_render_color($attr, 'paginationActiveBack', 'background-color');
      $css->pbg_render_border($attr, 'paginationActiveBorder', 'Desktop');
			
      // Tablet
			$css->start_media_query( 'tablet' );
			
      $css->set_selector( '.' . $unique_id . ' .premium-blog-skin-modern .premium-blog-content-wrapper' );
      $css->pbg_render_range($attr, 'contentOffset', 'top', 'Tablet');

      $css->set_selector( '.' . $unique_id . ' .premium-blog-author-thumbnail' );
      $css->pbg_render_range($attr, 'authorImgPosition', 'top', 'Tablet');
			
      $css->set_selector( '.' . $unique_id . ' .premium-blog-post-container.premium-blog-skin-banner .premium-blog-content-wrapper' );
      $css->pbg_render_value($attr, 'verticalAlign', 'justify-content', 'Tablet');

      $css->set_selector( '.' . $unique_id . ' .premium-post-grid .premium-blog-post-outer-container' );
      $css->pbg_render_value($attr, 'columns', 'width', 'Tablet', 'calc(100% / ', ')');
      $css->pbg_render_range($attr, 'columnGap', 'padding-right', 'Tablet', 'calc( ', ' / 2 )');
      $css->pbg_render_range($attr, 'columnGap', 'padding-left', 'Tablet', 'calc( ', ' / 2 )');
      $css->pbg_render_spacing($attr, 'margin', 'padding', 'Tablet');

      $css->set_selector( '.' . $unique_id . ' .premium-post-grid.premium-blog-wrap' );
      $css->pbg_render_range($attr, 'columnGap', 'margin-right', 'Tablet', 'calc( -', ' / 2 )');
      $css->pbg_render_range($attr, 'columnGap', 'margin-left', 'Tablet', 'calc( -', ' / 2 )');
      $css->pbg_render_range($attr, 'rowGap', 'row-gap', 'Tablet');

      $css->set_selector( '.' . $unique_id . ' .premium-blog-post-container' );
      $css->pbg_render_border($attr, 'border', 'Tablet');
      $css->pbg_render_spacing($attr, 'padding', 'padding', 'Tablet');
			
      $css->set_selector( '.' . $unique_id . ' .post-categories , .'. $unique_id . '  .premium-blog-post-tags-container, .' . $unique_id . ' .premium-blog-entry-meta');
      $css->pbg_render_align_self($attr, 'align', 'justify-content', 'Tablet');

      $css->set_selector( '.' . $unique_id . ' .premium-blog-inner-container');
      $css->pbg_render_align_self($attr, 'align', 'align-items', 'Tablet');

      $css->set_selector( '.' . $unique_id . ' .premium-blog-post-container > .premium-blog-content-wrapper ' );
      $css->pbg_render_value($attr, 'align', 'text-align', 'Tablet');
      $css->pbg_render_spacing($attr, 'contentPadding', 'padding', 'Tablet');
      $css->pbg_render_spacing($attr, 'contentBoxMargin', 'margin', 'Tablet');

      $css->set_selector( '.' . $unique_id . ' .premium-blog-post-container .premium-blog-content-wrapper-inner p' );
      $css->pbg_render_typography( $attr, 'contentTypography', 'Tablet' );
      $css->pbg_render_spacing($attr, 'contentMargin', 'margin', 'Tablet');

			// Title Styles
      $css->set_selector( '.' . $unique_id . ' .premium-blog-post-container .premium-blog-entry-title' );
      $css->pbg_render_typography($attr, 'titleTypography', 'Tablet');
      $css->pbg_render_range($attr, 'titleBottomSpacing', 'margin-bottom', 'Tablet');

      $css->set_selector( '.' . $unique_id . ' .premium-blog-post-container .premium-blog-entry-title > *' );
      $css->pbg_render_typography($attr, 'titleTypography', 'Tablet');

      // Shape Styles
      $css->set_selector( '.' . $unique_id . ' .premium-blog-post-container .premium-bottom-shape svg' );
      $css->pbg_render_range($attr, 'shapeBottom.width', 'width', 'Tablet');
      $css->pbg_render_range($attr, 'shapeBottom.height', 'height', 'Tablet');

			// Meta
      $css->set_selector( '.' . $unique_id . ' .premium-blog-meta-data, .' . $unique_id . ' .premium-blog-meta-data a' );
      $css->pbg_render_typography( $attr, 'metaTypography', 'Tablet' );

      $css->set_selector( '.' . $unique_id . ' .premium-blog-meta-data :is(svg, svg .cls-1)');
      $css->pbg_render_range($attr, 'metaTypography.fontSize', 'width', 'Tablet');
      $css->pbg_render_range($attr, 'metaTypography.fontSize', 'height', 'Tablet');
			
			// Image
			$css->set_selector( '.' . $unique_id . ' .premium-blog-thumbnail-container img');
      $css->pbg_render_range($attr, 'height', 'height', 'Tablet', null, '!important');

      // Excerpt Link Styles
			$css->set_selector( '.' . $unique_id . ' .premium-blog-content-wrapper .premium-blog-excerpt-link' );
      $css->pbg_render_range($attr, 'buttonSpacing', 'margin-top', 'Tablet');
      $css->pbg_render_typography( $attr, 'btnTypography', 'Tablet' );
      $css->pbg_render_border($attr, 'btnBorder', 'Tablet');
      $css->pbg_render_spacing($attr, 'btnPadding', 'padding', 'Tablet');

      $css->set_selector( '.' . $unique_id . ' .premium-blog-content-wrapper .premium-blog-excerpt-link:hover' );
      $css->pbg_render_border($attr, 'btnBorderHover', 'Tablet');

      // Categories Styles For Banner
      $css->set_selector( '.' . $unique_id . ' .premium-blog-cats-container a' );
      $css->pbg_render_typography( $attr, 'catTypography', 'Tablet' );
      $css->pbg_render_border($attr, 'catBorder', 'Tablet');
      $css->pbg_render_spacing($attr, 'catPadding', 'padding', 'Tablet');

      // Pagination
      $css->set_selector( '.' . $unique_id .' .premium-blog-pagination-container');
      $css->pbg_render_align_self($attr, 'paginationPosition', 'justify-content', 'Tablet');

      $css->set_selector('.' . $unique_id . ' .premium-blog-pagination-container .page-numbers');
      $css->pbg_render_border($attr, 'paginationBorder', 'Tablet');
      $css->pbg_render_typography( $attr, 'paginationTypography', 'Tablet' );
      $css->pbg_render_spacing($attr, 'paginationPadding', 'padding', 'Tablet');
      $css->pbg_render_spacing($attr, 'paginationMargin', 'margin', 'Tablet');
			
			// Pagination Hover
      $css->set_selector('.' . $unique_id . ' .premium-blog-pagination-container .page-numbers:hover');
      $css->pbg_render_border($attr, 'paginationHoverBorder', 'Tablet');
			
			// Pagination Active
      $css->set_selector('.' . $unique_id . ' .premium-blog-pagination-container span.page-numbers.current');
      $css->pbg_render_border($attr, 'paginationActiveBorder', 'Tablet');
			
      // Carousel Styles
      $css->set_selector( '.' . $unique_id . ' .splide .splide__arrows .splide__arrow' );
      $css->pbg_render_spacing($attr, 'arrowPadding', 'padding', 'Tablet');
			
      $css->set_selector( '.' . $unique_id . ' .splide .splide__arrows.splide__arrows--ltr .splide__arrow--prev, .' . $unique_id . ' .splide .splide__arrows.splide__arrows--rtl .splide__arrow--next');
      $css->pbg_render_range($attr, 'arrowPosition', 'left', 'Tablet');
			
      $css->set_selector( '.' . $unique_id . ' .splide .splide__arrows.splide__arrows--ltr .splide__arrow--next, .' . $unique_id . ' .splide .splide__arrows.splide__arrows--rtl .splide__arrow--prev');
      $css->pbg_render_range($attr, 'arrowPosition', 'right', 'Tablet');

      $css->set_selector( '.' . $unique_id . ' .splide .splide__pagination .splide__pagination__page' );
      $css->pbg_render_spacing($attr, 'dotMargin', 'margin', 'Tablet');

      // Mobile
			$css->stop_media_query();
			$css->start_media_query( 'mobile' );

      $css->set_selector( '.' . $unique_id . ' .premium-blog-skin-modern .premium-blog-content-wrapper' );
      $css->pbg_render_range($attr, 'contentOffset', 'top', 'Mobile');
			
      $css->set_selector( '.' . $unique_id . ' .premium-blog-author-thumbnail' );
      $css->pbg_render_range($attr, 'authorImgPosition', 'top', 'Mobile');
			
			$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container.premium-blog-skin-banner .premium-blog-content-wrapper' );
      $css->pbg_render_value($attr, 'verticalAlign', 'justify-content', 'Mobile');

      $css->set_selector( '.' . $unique_id . ' .premium-post-grid .premium-blog-post-outer-container' );
      $css->pbg_render_value($attr, 'columns', 'width', 'Mobile', 'calc(100% / ', ')');
      $css->pbg_render_range($attr, 'columnGap', 'padding-right', 'Mobile', 'calc( ', ' / 2 )');
      $css->pbg_render_range($attr, 'columnGap', 'padding-left', 'Mobile', 'calc( ', ' / 2 )');
      $css->pbg_render_spacing($attr, 'margin', 'padding', 'Mobile');

      $css->set_selector( '.' . $unique_id . ' .premium-post-grid.premium-blog-wrap' );
      $css->pbg_render_range($attr, 'columnGap', 'margin-right', 'Mobile', 'calc( -', ' / 2 )');
      $css->pbg_render_range($attr, 'columnGap', 'margin-left', 'Mobile', 'calc( -', ' / 2 )');
      $css->pbg_render_range($attr, 'rowGap', 'row-gap', 'Mobile');   

			$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container' );
      $css->pbg_render_border($attr, 'border', 'Tablet');
      $css->pbg_render_spacing($attr, 'padding', 'padding', 'Tablet');
			
      $css->set_selector( '.' . $unique_id . ' .post-categories , .'. $unique_id . '  .premium-blog-post-tags-container, .' . $unique_id . ' .premium-blog-entry-meta');
      $css->pbg_render_align_self($attr, 'align', 'justify-content', 'Mobile');

      $css->set_selector( '.' . $unique_id . ' .premium-blog-inner-container');
      $css->pbg_render_align_self($attr, 'align', 'align-items', 'Mobile');

			$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container > .premium-blog-content-wrapper ' );
      $css->pbg_render_value($attr, 'align', 'text-align', 'Mobile');
      $css->pbg_render_spacing($attr, 'contentPadding', 'padding', 'Mobile');
      $css->pbg_render_spacing($attr, 'contentBoxMargin', 'margin', 'Mobile');

      $css->set_selector( '.' . $unique_id . ' .premium-blog-post-container .premium-blog-content-wrapper-inner p' );
      $css->pbg_render_typography( $attr, 'contentTypography', 'Mobile' );
      $css->pbg_render_spacing($attr, 'contentMargin', 'margin', 'Mobile');

      // Title Styles
      $css->set_selector( '.' . $unique_id . ' .premium-blog-post-container .premium-blog-entry-title' );
      $css->pbg_render_typography($attr, 'titleTypography', 'Mobile');
      $css->pbg_render_range($attr, 'titleBottomSpacing', 'margin-bottom', 'Mobile');

      $css->set_selector( '.' . $unique_id . ' .premium-blog-post-container .premium-blog-entry-title > *' );
      $css->pbg_render_typography($attr, 'titleTypography', 'Mobile');

      // Shape Styles
      $css->set_selector( '.' . $unique_id . ' .premium-blog-post-container .premium-bottom-shape svg' );
      $css->pbg_render_range($attr, 'shapeBottom.width', 'width', 'Mobile');
      $css->pbg_render_range($attr, 'shapeBottom.height', 'height', 'Mobile');
			
			// Meta
      $css->set_selector( '.' . $unique_id . ' .premium-blog-meta-data, .' . $unique_id . ' .premium-blog-meta-data a' );
      $css->pbg_render_typography( $attr, 'metaTypography', 'Mobile' );

      $css->set_selector( '.' . $unique_id . ' .premium-blog-meta-data :is(svg, svg .cls-1)');
      $css->pbg_render_range($attr, 'metaTypography.fontSize', 'width', 'Mobile');
      $css->pbg_render_range($attr, 'metaTypography.fontSize', 'height', 'Mobile');

			// Image
			$css->set_selector( '.' . $unique_id . ' .premium-blog-thumbnail-container img');
      $css->pbg_render_range($attr, 'height', 'height', 'Mobile', null, '!important');

      // Excerpt Link Styles
			$css->set_selector( '.' . $unique_id . ' .premium-blog-content-wrapper .premium-blog-excerpt-link' );
      $css->pbg_render_range($attr, 'buttonSpacing', 'margin-top', 'Mobile');
      $css->pbg_render_typography( $attr, 'btnTypography', 'Mobile' );
      $css->pbg_render_border($attr, 'btnBorder', 'Mobile');
      $css->pbg_render_spacing($attr, 'btnPadding', 'padding', 'Mobile');

      $css->set_selector( '.' . $unique_id . ' .premium-blog-content-wrapper .premium-blog-excerpt-link:hover' );
      $css->pbg_render_border($attr, 'btnBorderHover', 'Mobile');

      // Categories Styles For Banner
      $css->set_selector( '.' . $unique_id . ' .premium-blog-cats-container a' );
      $css->pbg_render_typography( $attr, 'catTypography', 'Mobile' );
      $css->pbg_render_border($attr, 'catBorder', 'Mobile');
      $css->pbg_render_spacing($attr, 'catPadding', 'padding', 'Mobile');
      
      // Pagination
      $css->set_selector( '.' . $unique_id .' .premium-blog-pagination-container');
      $css->pbg_render_align_self($attr, 'paginationPosition', 'justify-content', 'Mobile');

      $css->set_selector('.' . $unique_id . ' .premium-blog-pagination-container .page-numbers');
      $css->pbg_render_border($attr, 'paginationBorder', 'Mobile');
      $css->pbg_render_typography( $attr, 'paginationTypography', 'Mobile' );
      $css->pbg_render_spacing($attr, 'paginationPadding', 'padding', 'Mobile');
      $css->pbg_render_spacing($attr, 'paginationMargin', 'margin', 'Mobile');
			
			// Pagination Hover
      $css->set_selector('.' . $unique_id . ' .premium-blog-pagination-container .page-numbers:hover');
      $css->pbg_render_border($attr, 'paginationHoverBorder', 'Mobile');
			
			// Pagination Active
      $css->set_selector('.' . $unique_id . ' .premium-blog-pagination-container span.page-numbers.current');
      $css->pbg_render_border($attr, 'paginationActiveBorder', 'Mobile');
			
      // Carousel Styles
      $css->set_selector( '.' . $unique_id . ' .splide .splide__arrows .splide__arrow' );
      $css->pbg_render_spacing($attr, 'arrowPadding', 'padding', 'Mobile');
			
      $css->set_selector( '.' . $unique_id . ' .splide .splide__arrows.splide__arrows--ltr .splide__arrow--prev, .' . $unique_id . ' .splide .splide__arrows.splide__arrows--rtl .splide__arrow--next');
      $css->pbg_render_range($attr, 'arrowPosition', 'left', 'Mobile');
			
      $css->set_selector( '.' . $unique_id . ' .splide .splide__arrows.splide__arrows--ltr .splide__arrow--next, .' . $unique_id . ' .splide .splide__arrows.splide__arrows--rtl .splide__arrow--prev');
      $css->pbg_render_range($attr, 'arrowPosition', 'right', 'Mobile');

      $css->set_selector( '.' . $unique_id . ' .splide .splide__pagination .splide__pagination__page' );
      $css->pbg_render_spacing($attr, 'dotMargin', 'margin', 'Mobile');

			$css->stop_media_query();
			return $css->css_output();
		}
	}

	PBG_Post::get_instance();
}




