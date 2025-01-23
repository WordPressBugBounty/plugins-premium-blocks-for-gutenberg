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

			add_action( 'init', array( $this, 'register_blocks' ) );
			add_action( 'wp_ajax_premium_post_pagination', array( $this, 'post_pagination' ) );
			add_action( 'wp_ajax_nopriv_premium_post_pagination', array( $this, 'post_pagination' ) );

			add_action( 'wp_footer', array( $this, 'add_post_dynamic_script' ), 1000 );
		}

		public function register_blocks() {
			// Check if the register function exists.
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


		public function get_post_grid_content( $attributes, $content, $block ) {
			$page_key = isset( $attributes['queryId'] ) ? 'pbg-query-' . $attributes['queryId'] . '-p' : 'query-page';
			$page     = empty( $_GET[ $page_key ] ) ? 1 : (int) $_GET[ $page_key ];

			$block_helpers = pbg_blocks_helper();
			if ( $block_helpers->it_is_not_amp() ) {
			
				wp_enqueue_script(
					'pbg-image-loaded',
					PREMIUM_BLOCKS_URL . 'assets/js/lib/imageLoaded.min.js',
					array( 'jquery' ),
					PREMIUM_BLOCKS_VERSION,
					true
				);
			
					wp_enqueue_script(
						'PBG_POST_GRID',
						PREMIUM_BLOCKS_URL . 'assets/js/minified/post.min.js',
						array( 'jquery' ),
						PREMIUM_BLOCKS_VERSION,
						true
					);
				
			}
			if ( isset( $attributes['blockId'] ) && ! empty( $attributes['blockId'] ) ) {
				$unique_id = $attributes['blockId'];
			} else {
				$unique_id = rand( 100, 10000 );
			}

			$css = $this->get_premium_post_css_style( $attributes, $unique_id );

			$style_id = 'pbg-blocks-style' . esc_attr( $unique_id );
			if ( ! empty( $css ) ) {
				if ( $block_helpers->should_render_inline( 'post-grid', $unique_id ) ) {
					$block_helpers->add_custom_block_css( $css );
				} else {
					$block_helpers->render_inline_css( $css, $style_id, true );
				}
			}

			 $query = $block_helpers->get_query( $attributes, 'grid', $page );
			self::$settings['grid'][ $attributes['blockId'] ] = $attributes;

			ob_start();
			$this->get_post_html( $attributes, $query, 'grid' );
			// Output the post markup.
			return ob_get_clean();

		}

		public function get_post_carousel_content( $attributes, $content, $block ) {
			$page_key = isset( $attributes['queryId'] ) ? 'pbg-query-' . $attributes['queryId'] . '-p' : 'query-page';
			$page     = empty( $_GET[ $page_key ] ) ? 1 : (int) $_GET[ $page_key ];

			$block_helpers = pbg_blocks_helper();

			if ( $block_helpers->it_is_not_amp() ) {
					wp_enqueue_script(
						'pbg-image-loaded',
						PREMIUM_BLOCKS_URL . 'assets/js/lib/imageLoaded.min.js',
						array( 'jquery' ),
						PREMIUM_BLOCKS_VERSION,
						true
					);
					wp_enqueue_script(
						'pbg-slick',
						PREMIUM_BLOCKS_URL . 'assets/js/lib/slick.min.js',
						array( 'jquery' ),
						PREMIUM_BLOCKS_VERSION,
						true
					);
					wp_enqueue_script(
						'PBG_POST_CAROUSEL',
						PREMIUM_BLOCKS_URL . 'assets/js/minified/post.min.js',
						array( 'jquery' ),
						PREMIUM_BLOCKS_VERSION,
						true
					);
				
			}
			if ( isset( $attributes['blockId'] ) && ! empty( $attributes['blockId'] ) ) {
					 $unique_id = $attributes['blockId'];
			} else {
					$unique_id = rand( 100, 10000 );
			}

			$css = $this->get_premium_post_css_style( $attributes, $unique_id );

			$style_id = 'pbg-blocks-style' . esc_attr( $unique_id );
			if ( ! empty( $css ) ) {
				if ( $block_helpers->should_render_inline( 'post-carousel', $unique_id ) ) {
					$block_helpers->add_custom_block_css( $css );
				} else {
					$block_helpers->render_inline_css( $css, $style_id, true );
				}
			}

			$query = $block_helpers->get_query( $attributes, 'carousel' );
			self::$settings['carousel'][ $attributes['blockId'] ] = $attributes;

			ob_start();
			$this->get_post_html( $attributes, $query, 'carousel' );
			// Output the post markup.
			return ob_get_clean();

		}

				/**
				 * Renders the post grid block on server.
				 *
				 * @param array  $attributes Array of block attributes.
				 *
				 * @param object $query WP_Query object.
				 * @since 0.0.1
				 */
		public function get_post_html( $attributes, $query, $type ) {
        
				$wrap = array(
					'premium-blog-wrap',
					'premium-blog-even',
					'premium-post-' . $type,


				);
					$outerwrap = array(
						'premium-blog',
						$attributes['blockId'],
						'wp-block-premium-post-' . $type,
            isset($attributes['className']) ? $attributes['className'] : '',
					);

					?>

   
			<div class="<?php echo esc_html( implode( ' ', $outerwrap ) ); ?>">
				<div class="<?php echo esc_html( implode( ' ', $wrap ) ); ?>"  >
					<?php
					$this->posts_articles_markup( $query, $attributes );
					?>
			</div>
			<?php

							if ( ( isset( $attributes['pagination'] ) && true === $attributes['pagination'] ) ) {
?>
<div class="premium-blog-pagination-container">
	<?php
										// content already escaped using wp_kses_post.
										echo $this->render_premium_pagination( $query, $attributes ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
								</div>
								<?php
								
							}
			
?>
			</div>
			<?php
		}

				/**
				 * Render Posts HTML
				 *
				 * @param object $query WP_Query object.
				 * @param array  $attributes Array of block attributes.
				 * @since 1.18.1
				 */
		public function posts_articles_markup( $query, $attributes ) {
			if ( ! $query->have_posts() ) {
				return ' ';
			}
				$post_not_found = $query->found_posts;
				$style          = $attributes['style'];
			if ( 0 === $post_not_found ) {
				?>
				<p class="premium-post__no-posts">
					<?php echo esc_html( $attributes['postDisplaytext'] ); ?>
				</p>
				<?php
			}
			$postContainer = array(
				'premium-blog-post-container',
				'premium-blog-skin-' . $style,
			);
			$postOuter     = array( 'premium-blog-post-outer-container' );
			if ( $attributes['equalHeight'] ) {
				array_push( $postOuter, 'premium-post-equal-height' );
			}
			while ( $query->have_posts() ) {
				$query->the_post();

				$thumb = !$attributes['displayPostImage'] ? 'empty-thumb' : '';
				$contentWrap     = array( 'premium-blog-content-wrapper',$thumb);
				// Filter to modify the attributes based on content requirement.
				$attributes = apply_filters( 'premium_post_alter_attributes', $attributes, get_the_ID() );
				?>
				<div class="<?php echo esc_html( implode( ' ', $postOuter ) ); ?>">
					<div class="<?php echo esc_html( implode( ' ', $postContainer ) ); ?>">
						<?php $this->render_image( $attributes ); ?>
						<?php if ( 'cards' === $attributes['style'] ) : ?>

							<?php if ( $attributes['authorImg'] ) : ?>
						<div class="premium-blog-author-thumbnail">
								<?php echo get_avatar( get_the_author_meta( 'ID' ), 128, '', get_the_author_meta( 'display_name' ) ); ?>
						</div>
					<?php endif; ?>
				<?php endif; ?>
				<div class="<?php echo esc_html( implode( ' ', $contentWrap ) ); ?>">
					<div class="premium-blog-content-wrapper-inner">
					<div class="premium-blog-inner-container">
					<?php if ( in_array( $attributes['style'], array( 'banner' ), true ) && $attributes['showCategories'] ) { ?>
							<div class="premium-blog-cats-container">
								<ul class="post-categories">
									<?php
										$post_cats = get_the_category();
									if ( count( $post_cats ) ) {
										foreach ( $post_cats as $index => $cat ) {
											echo wp_kses_post( sprintf( '<li><a href="%s" >%s</a></li>', get_category_link( $cat->cat_ID ), $cat->name ) );
										}
									}

									?>
								</ul>
							</div>
						<?php } ?>
							<?php $this->render_post_title( $attributes ); ?>
							 <?php
								if ( 'cards' !== $attributes['style'] ) {
									$this->render_meta( $attributes );

								}
								?>
						
					</div>
							<?php
							if (  $attributes['showContent'] ) {
								$this->get_post_content( $attributes ); 
							}
							?>
							<?php
							if ( 'cards' === $attributes['style'] ) {
								$this->render_meta( $attributes );

							}
							?>
							</div>
						</div>
					</div>
				</div>
					<?php
			}

			wp_reset_postdata();
		}

		public function render_image( $attributes ) {
			if ( ! $attributes['displayPostImage'] && $attributes['style'] !== "banner" ) {
				return;
			}
	
			$attributes['displayPostImage']
						= array(
							'id' => get_post_thumbnail_id(),
						);
						$wrapImage          = array(
							'premium-blog-thumbnail-container',
							'premium-blog-' .
							$attributes['hoverEffect'] .
						   '-effect',
						);
						$bottomShapeClasses = 'premium-shape-divider premium-bottom-shape';
						if ( isset( $attributes['shapeBottom'] ) && isset( $attributes['shapeBottom']['flipShapeDivider'] ) ) {
							$bottomShapeClasses .= ' premium-shape-flip';
						}
						if ( isset( $attributes['shapeBottom'] ) && isset( $attributes['shapeBottom']['front'] ) ) {
							$bottomShapeClasses .= ' premium-shape-above-content';
						}
						if ( isset( $attributes['shapeBottom'] ) && isset( $attributes['shapeBottom']['invertShapeDivider'] ) ) {
							$bottomShapeClasses .= ' premium-shape__invert';
						}
						$block_helpers = pbg_blocks_helper();

						$shapes = $block_helpers->getSvgShapes();

						?>
			<div class="premium-blog-thumb-effect-wrapper">
				<div class="<?php echo esc_html( implode( ' ', $wrapImage ) ); ?>">
				 <?php
					if ( in_array( $attributes['style'], array( 'modern', 'cards' ), true ) ) {
						?>
              <a href="<?php esc_url(  get_the_permalink() ); ?>" >
            <?php
					}

          if(get_post_thumbnail_id()){
            echo wp_get_attachment_image( get_post_thumbnail_id(), $attributes['imageSize'] );
          }else{
            $default_img = PREMIUM_BLOCKS_URL . 'assets/img/author.jpg';
            ?>  
              <img src="<?php echo esc_url( $default_img ); ?>" />
            <?php
          }

					if ( in_array( $attributes['style'], array( 'modern', 'cards' ), true ) ) {
						?>
				      </a>
						<?php
					}
					?>
				 <?php
					if ( isset( $attributes['shapeBottom'] ) && isset( $attributes['shapeBottom']['style'] ) ) {
						?>
						 <div class="<?php echo ( $bottomShapeClasses ); ?>">
						<?php
						echo ( $shapes[ $attributes['shapeBottom']['style'] ] );
						?>
				</div>
						<?php
					}
					?>
   
				</div>
				 <?php if ( in_array( $attributes['style'], array( 'modern', 'cards' ), true ) ) : ?>
							<div class="premium-blog-effect-container <?php echo esc_attr( 'premium-blog-' . $attributes['overlayEffect'] . '-effect' ); ?>">
								<a class="premium-blog-post-link" href="<?php the_permalink(); ?>" target=""></a>
								<?php if ( 'squares' === $attributes['overlayEffect'] ) { ?>
									<div class="premium-blog-squares-square-container"></div>
								<?php } ?>
							</div>
						<?php else : ?>
							<div class="premium-blog-thumbnail-overlay">
								<a  href="<?php the_permalink(); ?>" target="" ></a>
							</div>
						<?php endif; ?>
			</div>
			<?php
		}


		public function render_premium_pagination($query,$attributes) {
			$block_helpers = pbg_blocks_helper();
      
      $page_key = isset( $attributes['queryId'] ) ? 'pbg-query-' . $attributes['queryId'] . '-p' : 'query-page';
			$paged               =  empty( $_GET[ $page_key ] ) ? 1 : (int) $_GET[ $page_key ];;

			$permalink_structure = get_option( 'permalink_structure' );
			$base                = untrailingslashit( wp_specialchars_decode( get_pagenum_link() ) );
			$base                = $block_helpers->build_base_url( $permalink_structure, $base );
			$p_limit             = $attributes['pageLimit'];
			$page_limit          = min( $p_limit, $query->max_num_pages );
			$page_limit          = isset( $page_limit ) ? $page_limit :  $attributes['query']['perPage'];

			$links = paginate_links(
				array(
					'base'      => $base . '%_%',
					'format'    => "?$page_key=%#%",
					'current'   => ( ! $paged ) ? 1 : $paged,
					'total'     => $page_limit,
					'type'      => 'array',
					'mid_size'  => 4,
					'end_size'  => 4,
					'prev_next' => $attributes['showPrevNext'],
					'prev_text' => $attributes['prevString'],
					'next_text' => $attributes['nextString'],
				)
			);

			if ( isset( $links ) ) {

				return wp_kses_post( implode( PHP_EOL, $links ) );
			}

			return '';

				}


		



		/**
		 * Render Post Meta - Author HTML.
		 *
		 * @param array $attributes Array of block attributes.
		 *
		 * @since 1.14.0
		 */
		public function render_meta_author( $attributes ) {
			if ( ! $attributes['showAuthor'] ) {
				return;
			}
			?>
				<div class="premium-blog-post-author premium-blog-meta-data">
					
					<svg id="Layer_1" xmlns="http://www.w3.org/2000/svg" width="22" height="24" viewBox="0 0 22 24"><defs></defs><path id="Author" class="cls-1" d="m0,20.63c0,2.74,5.72,3.36,11,3.37,5.28,0,11-.62,11-3.37,0-3.63-3.93-4.85-7.25-5.96-.24-.07-1.25-.67-1.25-2.23,1.65-1.56,3.4-4.11,3.4-6.61,0-3.83-2.71-5.84-5.9-5.84s-5.9,2-5.9,5.84c0,2.5,1.75,5.05,3.4,6.61,0,1.56-1.01,2.15-1.25,2.23-3.32,1.11-7.25,2.33-7.25,5.96Z"/></svg>
						 <?php the_author_posts_link(); ?>
			
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
			if ( ! $attributes['showDate'] ) {
				return;
			}
			global $post;

			?>
			
			<span class="premium-blog-meta-separtor"><?php echo (self::$meta_separators[$attributes['metaSeparator']?$attributes['metaSeparator']:'dot' ])?></span>

			<div class="premium-blog-post-time premium-blog-meta-data">

				<svg id="Layer_1" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22"><defs></defs><path id="Date" class="cls-1" d="m20.93,6.54c-.07-.9-.23-1.64-.57-2.32-.56-1.11-1.47-2.01-2.57-2.57-.68-.35-1.42-.5-2.32-.57-.89-.07-1.99-.07-3.41-.07h-2.11c-1.42,0-2.51,0-3.41.07-.9.07-1.64.23-2.32.57-1.11.56-2.01,1.47-2.57,2.57-.35.68-.5,1.42-.57,2.32-.07.89-.07,1.99-.07,3.41v2.11c0,1.42,0,2.51.07,3.41.07.9.23,1.64.57,2.32.56,1.11,1.47,2.01,2.57,2.57.68.35,1.42.5,2.32.57.89.07,1.99.07,3.41.07h2.11c1.42,0,2.51,0,3.41-.07.9-.07,1.64-.23,2.32-.57,1.11-.56,2.01-1.47,2.57-2.57.35-.68.5-1.42.57-2.32.07-.89.07-1.99.07-3.41v-2.11c0-1.42,0-2.51-.07-3.41Zm-4.72,9.92c-.2.19-.45.29-.71.29s-.51-.1-.71-.29l-4.5-4.5c-.18-.19-.29-.44-.29-.71v-5c0-.55.45-1,1-1s1,.45,1,1v4.59l4.21,4.2c.39.39.39,1.03,0,1.42Z"/></svg>  
				<span>	<?php echo esc_html( get_the_date( '', $post->ID ) ); ?> </span>
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
			if ( ! $attributes['showComments'] ) {
				return;
			}
				$comments_strings = array(
				'no-comments'       => __( 'No Comments', 'premium-blocks-for-gutenberg' ),
				'one-comment'       => __( '1 Comment', 'premium-blocks-for-gutenberg' ),
				'multiple-comments' => __( '% Comments', 'premium-blocks-for-gutenberg' ),
			);
			?>
							<span class="premium-blog-meta-separtor"><?php echo( self::$meta_separators[$attributes['metaSeparator']?$attributes['metaSeparator']:'dot' ])?></span>

				<div class='premium-blog-post-comments premium-blog-meta-data'>

					<svg id="Layer_1" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22"><defs></defs><path id="Comments" class="cls-1" d="m11,0C5.03,0,0,4.38,0,10c0,2.63,1.45,5.01,3.48,6.71,1.79,1.49,4.11,2.52,6.52,2.74v1.55c0,.33.16.64.44.83.27.18.62.22.93.1,1.76-.71,4.37-2.14,6.55-4.13,2.17-1.97,4.08-4.64,4.08-7.8C22,4.38,16.97,0,11,0Zm-5,11.5c-.83,0-1.5-.67-1.5-1.5s.67-1.5,1.5-1.5,1.5.67,1.5,1.5-.67,1.5-1.5,1.5Zm5,0c-.83,0-1.5-.67-1.5-1.5s.67-1.5,1.5-1.5,1.5.67,1.5,1.5-.67,1.5-1.5,1.5Zm5,0c-.83,0-1.5-.67-1.5-1.5s.67-1.5,1.5-1.5,1.5.67,1.5,1.5-.67,1.5-1.5,1.5Z"/></svg>
					<?php comments_popup_link( $comments_strings['no-comments'], $comments_strings['one-comment'], $comments_strings['multiple-comments'], '', $comments_strings['no-comments'] ); ?>
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
			if ( ! $attributes['showCategories'] ||   in_array( $attributes['style'], array( 'side', 'banner' ), true ) )  {
				return;
			}
			global $post;

			$terms = get_the_terms( $post->ID, 'category' );
			if ( is_wp_error( $terms ) ) {
				return;
			}
			if ( ! isset( $terms[0] ) ) {
				return;
			}
			?>
				<span class="premium-blog-meta-separtor"><?php echo(self::$meta_separators[$attributes['metaSeparator']?$attributes['metaSeparator']:'dot' ])?></span>

				<div class="premium-blog-post-categories premium-blog-meta-data">

					<svg id="Layer_1" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22"><defs></defs><path id="Categories" class="cls-1" d="m2,4c0,.55.45,1,1,1h16c.55,0,1-.45,1-1s-.45-1-1-1H3c-.55,0-1,.45-1,1Zm0,5c0,.55.45,1,1,1h11c.55,0,1-.45,1-1s-.45-1-1-1H3c-.55,0-1,.45-1,1Zm0,5h0c0-.55.45-1,1-1h16c.55,0,1,.45,1,1h0c0,.55-.45,1-1,1H3c-.55,0-1-.45-1-1Zm1,6c-.55,0-1-.45-1-1s.45-1,1-1h7c.55,0,1,.45,1,1s-.45,1-1,1H3Z"/></svg>

						 <?php the_category( ',' ); ?>
				</div>
			<?php
		}

		/**
		 * Render Post Meta HTML.
		 *
		 * @param array $attributes Array of block attributes.
		 */
		public function render_meta( $attributes ) {
			$meta_content = '';
			global $post;
			$classes            = array();
			$classes[]          = 'premium-blog-entry-meta';
			$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => implode( ' ', $classes ) ) );

			do_action( 'pbg_single_post_before_meta', get_the_ID(), $attributes );
			$meta_sequence = array( 'author', 'date', 'taxonomy', 'comment' );
			?>
				<div class="premium-blog-entry-meta">
					<?php
					foreach ( $meta_sequence as $key => $sequence ) {
						switch ( $sequence ) {
							case 'author':
								$meta_content .= $this->render_meta_author( $attributes );
								break;
							case 'date':
								$meta_content .= $this->render_meta_date( $attributes );
								break;
							case 'comment':
								$meta_content .= $this->render_meta_comment( $attributes );
								break;
							case 'taxonomy':
								$meta_content .= $this->render_meta_taxonomy( $attributes );
								break;
							default:
								break;
						}
					}
					?>
				</div>
				<?php
				return sprintf( '<div %1$s>%2$s</div>', $wrapper_attributes, $meta_content );
				do_action( 'pbg_single_post_after_meta', get_the_ID(), $attributes );
		}

			/****
			 *
			 *
			 * Render The Post Title
			 *
			 * @param array $attributes Array of block attributes.
			 */
		public function render_post_title( $attributes ) {
			$block_helpers = pbg_blocks_helper();

			$target = ( $attributes['newTab'] ) ? '_blank' : '_self';
			$array_of_allowed_HTML = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'span', 'p' );
			$title_tag = $block_helpers -> title_tag_allowed_html( $attributes['level'], $array_of_allowed_HTML, 'h2' );

			?>
				  
			<<?php echo esc_html( $title_tag ); ?> class="premium-blog-entry-title" >
				<a href="<?php the_permalink(); ?>"   target="<?php echo esc_attr( $target ); ?>" rel="bookmark noopener noreferrer" >
					<?php esc_html( the_title() ); ?>
				</a>
			</<?php echo esc_html( $title_tag ); ?>>                   
						  
			<?php
		}

		/**
		 * Render Post Excerpt HTML.
		 *
		 * @param array $attributes Array of block attributes.
		 *
		 * @since 0.0.1
		 */
		public function get_post_content( $attributes ) {
			$show_content=$attributes['showContent'];
			$src          = $attributes['displayPostExcerpt'];
			$excerpt_type = $attributes['excerptTypeLink'];
			$excerpt_text = $attributes['readMoreText'];
			$length       = $attributes['excerptLen'];
			$content      = '';
			$content     .= $show_content?'<p class="premium-blog-post-content">' . $this->render_post_content( $src, $length, $excerpt_type, $excerpt_text ) . '</p>':"";

			if ( $excerpt_type ) {
				if ( empty( $excerpt_text ) ) {
					return;
				}
				$wrapbutton     = 'premium-blog-excerpt-link-wrap';
				$wrapbutton    .= ( isset( $attributes['fullWidth'] ) && $attributes['fullWidth'] ) ? ' premium-blog-full-link' : '';
				$wrapper_class = get_block_wrapper_attributes( array( 'class' => trim( $wrapbutton ) ) );
				$button_content = '<a class="premium-blog-excerpt-link wp-block-button__link" href="' . esc_url( get_the_permalink() ) . '">' . wp_kses_post( $attributes['readMoreText'] ) . '</a>';
				$content       .= sprintf(
					'<div %1$s>%2$s</div>',
					$wrapper_class,
					$button_content
				);
			}
			echo $content;
		}

				/**
				 * Function runder Button
				 *
				 * @param [type] $read_more
				 * @param [type] $attributes
				 * @return void
				 */
		public function render_post_content( $source, $excerpt_length, $cta_type ) {

			$excerpt = '';
			if ( 'Post Full Content' === $source ) {
				// Print post full content.
				$excerpt = get_the_content();
			} else {

				$excerpt = trim( get_the_excerpt() );
				$words   = explode( ' ', $excerpt, $excerpt_length + 1 );
				if ( count( $words ) > $excerpt_length ) {
					if ( ! has_excerpt() ) {
						array_pop( $words );
							array_push( $words, '…' );
						
					}
				}
				$excerpt = implode( ' ', $words );
			}

			return $excerpt;
		}


		public function add_post_dynamic_script() {

			if ( isset( self::$settings['carousel'] ) ) {
				foreach ( self::$settings['carousel'] as $key => $value ) {
				
					$dots         = ( 'dots' === $value['navigationDots'] || 'arrows_dots' === $value['navigationDots'] ) ? true : false;
					$arrows       = ( 'arrows' === $value['navigationArrow'] || 'arrows_dots' === $value['navigationArrow'] ) ? true : false;
					$tcolumns     = ( isset( $value['columns']['Tablet'] ) ) ? $value['columns']['Tablet'] : 2;
					$mcolumns     = ( isset( $value['columns']['Mobile'] ) ) ? $value['columns']['Mobile'] : 1;
					$equal_height = isset( $value['equalHeight'] ) ? $value['equalHeight'] : '';

					$slideToScroll = ( isset( $value['slideToScroll'] ) );
					$is_rtl        = is_rtl();
					?>
								<script type="text/javascript"  id="<?php echo esc_attr( $key ); ?>" >
								
								jQuery( document ).ready( function( $ ) {
									var cols = parseInt( '<?php echo esc_html( $value['columns']['Desktop'] ); ?>' );
									var $scope = $('.<?php   echo esc_html( $key ); ?> ').find( '.premium-post-carousel' );
									if ( cols >= $scope.children().length ) {
										return;
									}
									var setting = {
									'slidesToShow' :cols,
									'slidesToScroll' :<?php echo esc_html( $value['slideToScroll'] ); ?> ,
									'autoplaySpeed' : <?php echo esc_html( $value['autoplaySpeed'] ); ?>,
									'autoplay' : Boolean( '<?php echo esc_html( $value['Autoplay'] ); ?>' ),
									'infinite' : Boolean( '<?php echo esc_html( $value['infiniteLoop'] ); ?>' ),
									'pauseOnHover' : Boolean( '<?php echo esc_html( $value['pauseOnHover'] ); ?>' ),
									'arrows' : Boolean( '<?php echo esc_html( $value['navigationArrow'] ); ?>' ),
									'dots' : Boolean( '<?php echo esc_html( $value['navigationDots'] ); ?>' ),
									'rtl' : Boolean( '<?php echo esc_html( $is_rtl ); ?>' ),
									'prevArrow' : '<button type=\"button\" data-role=\"none\" class=\"slick-prev\" aria-label=\"Previous\" tabindex=\"0\" role=\"button\"><svg width=\"20\" height=\"20\" viewBox=\"0 0 256 512\"><path d=\"M31.7 239l136-136c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L127.9 256l96.4 96.4c9.4 9.4 9.4 24.6 0 33.9L201.7 409c-9.4 9.4-24.6 9.4-33.9 0l-136-136c-9.5-9.4-9.5-24.6-.1-34z\"></path></svg><\/button>',
									'nextArrow' : '<button type=\"button\" data-role=\"none\" class=\"slick-next\" aria-label=\"Next\" tabindex=\"0\" role=\"button\"><svg width=\"20\" height=\"20\" viewBox=\"0 0 256 512\"><path d=\"M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z\"></path></svg><\/button>',
	
									'responsive' : [
										{
											'breakpoint' : 1024,
											'settings' : {
												'slidesToShow' : <?php echo esc_html( $tcolumns ); ?> ,
												'slidesToScroll' : 1,
											}
										},
										{
											'breakpoint' : 767,
											'settings' : {
												'slidesToShow' :<?php echo esc_html( $mcolumns ); ?>,
												'slidesToScroll' : 1,
											}
										}
									]
													};
									$scope.imagesLoaded( function() {
									$scope.not('.slick-initialized').slick(
										setting
									);
									});
									var enableEqualHeight = ( '<?php echo esc_html( $equal_height ); ?>' );
								})
								</script>
				
					<?php
				}
			}
		}


		public function get_premium_post_css_style( $attr, $unique_id ) {
			$css                    = new Premium_Blocks_css();
			$media_query            = array();
			$media_query['mobile']  = apply_filters( 'Premium_BLocks_mobile_media_query', '(max-width: 767px)' );
			$media_query['tablet']  = apply_filters( 'Premium_BLocks_tablet_media_query', '(max-width: 1024px)' );
			$media_query['desktop'] = apply_filters( 'Premium_BLocks_tablet_media_query', '(min-width: 1025px)' );
			if ( isset( $attr['columns'] ) && ! empty( $attr['columns']['Desktop'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-outer-container' );
				$css->add_property( 'width', 'calc(100% / ' . $attr['columns']['Desktop'] . ')' );
			}
			if ( isset( $attr['plusColor'] ) ) {

				$css->set_selector( '.' . $unique_id . ' .premium-blog-thumbnail-container:before , .' . $unique_id . ' .premium-blog-thumbnail-container:after' );
				$css->add_property( 'background-color', $css->render_string( $css->render_color( $attr['plusColor'] ), ' !important' ) );
			}
			if ( isset( $attr['borderedColor'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-link:before ,' . $unique_id . ' .premium-blog-post-link:after' );
				$css->add_property( 'border-color', $css->render_color( $attr['borderedColor'] ) );
			}
			if ( isset( $attr['contentOffset'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-skin-modern .premium-blog-content-wrapper' );
				$css->add_property( 'top', $css->render_string( $attr['contentOffset']['Desktop'], 'px' ) );
			}
			if ( isset( $attr['authorImgPosition'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-author-thumbnail' );
				$css->add_property( 'top', $css->render_string( $attr['authorImgPosition']['Desktop'], 'px' ) );
			}
			if ( isset( $attr['verticalAlign'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-content-wrapper' );
				$css->add_property( 'justify-content', $css->get_responsive_css( $attr['verticalAlign'], 'Desktop'  ) );
			}
			if ( isset( $attr['columnGap'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-outer-container' );
				$css->add_property( 'padding-right','calc(' . $css->render_range( $attr['columnGap'], 'Desktop' ).'/2 )' );
				$css->add_property( 'padding-left','calc(' . $css->render_range( $attr['columnGap'], 'Desktop' ).'/2 )'  );
				
        $css->set_selector( '.' . $unique_id . '.premium-blog-grid .premium-blog-wrap' );
				$css->add_property( 'margin-right','calc(-' . $css->render_range( $attr['columnGap'], 'Desktop' ).'/2 )' );
				$css->add_property( 'margin-left','calc(-' . $css->render_range( $attr['columnGap'], 'Desktop' ).'/2 )'  );
			}
			if ( isset( $attr['rowGap'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-wrap' );
				$css->add_property( 'row-gap', $css->render_range( $attr['rowGap'], 'Desktop' ) );
			}

			if ( isset( $attr['margin'] ) ) {
				$container_margin = $attr['margin'];
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-outer-container' );
				$css->add_property( 'padding', $css->render_spacing( $container_margin['Desktop'], isset($container_margin['unit']['Desktop'])?$container_margin['unit']['Desktop']:$container_margin['unit']  ) );
			}
			if ( isset( $attr['padding'] ) ) {
				$container_padding = $attr['padding'];
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container' );
				$css->add_property( 'padding', $css->render_spacing( $container_padding['Desktop'], isset($container_padding['unit']['Desktop']) ?$container_padding['unit']['Desktop']:$container_padding['unit'] ) );
			}
			if ( isset( $attr['boxShadow'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container' );
				$css->add_property( 'box-shadow', $css->render_shadow( $attr['boxShadow'] ) );
			}
			if ( isset( $attr['ContainerBackground'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container' );
				$css->add_property( 'background-color', $css->render_color( $attr['ContainerBackground'] ) );

			}
			if ( isset( $attr['border'] ) ) {
				$border_width  = $attr['border']['borderWidth'];
				$border_radius = $attr['border']['borderRadius'];
				$border_style  = $attr['border']['borderType'];
				$border_color  = $attr['border']['borderColor'];
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container' );
				$css->add_property( 'border-color', $css->render_color( $border_color ) );
				$css->add_property( 'border-style', $border_style );
				$css->add_property( 'border-width', $css->render_spacing( $border_width['Desktop'], 'px' ) );
				$css->add_property( 'border-radius', $css->render_spacing( $border_radius['Desktop'], 'px' ) );
			}
			if ( isset( $attr['advancedBorder'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container' );
				$css->add_property( 'border-radius', $attr['advancedBorder'] ? $css->render_string( $attr['advancedBorderValue'] , '!important' ): '' );
			}
			if ( isset( $attr['contentBoxMargin'] ) ) {
				$content_margin = $attr['contentBoxMargin'];
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container > .premium-blog-content-wrapper ' );
				$css->add_property( 'margin', $css->render_spacing( $content_margin['Desktop'], isset($content_margin['unit']['Desktop'])?$content_margin['unit']['Desktop']:$content_margin['unit']  ) );
			}
			if ( isset( $attr['contentPadding'] ) ) {
				$content_padding = $attr['contentPadding'];
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container > .premium-blog-content-wrapper ' );
				$css->add_property( 'padding', $css->render_spacing( $content_padding['Desktop'], isset($content_padding['unit']['Desktop'])?$content_padding['unit']['Desktop']:$content_padding['unit']  ) );
			}
			if ( isset( $attr['contentBackground'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container > .premium-blog-content-wrapper ' );
				$css->add_property( 'background-color', $css->render_color( $attr['contentBackground'] ) );
			}
			if ( isset( $attr['align'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container > .premium-blog-content-wrapper ' );
				$css->add_property( 'text-align', $css->get_responsive_css( $attr['align'], 'Desktop' ) );
			}
			if ( isset( $attr['align'] ) ) {
				$content_align      = $css->get_responsive_css( $attr['align'], 'Desktop' );
				$css->set_selector( '.' . $unique_id . ' .post-categories , .'. $unique_id . '  .premium-blog-post-tags-container');
				$css->add_property( 'justify-content', $css->render_align_self($content_align)  );
			}
			if ( isset( $attr['align'] ) ) {
				$content_align      = $css->get_responsive_css( $attr['align'], 'Desktop' );
				$css->set_selector( '.' . $unique_id . ' .premium-blog-inner-container');
				$css->add_property( 'align-items', $css->render_align_self($content_align)  );
			}
			if ( isset( $attr['contentBoxShadow'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container > .premium-blog-content-wrapper ' );
				$css->add_property( 'box-shadow', $css->render_shadow( $attr['contentBoxShadow'] ) );
			}

			if ( isset( $attr['contentColor'] ) && ! empty( $attr['contentColor'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container .premium-blog-content-wrapper-inner p' );
				$css->add_property( 'color',$css->render_string( $css->render_color( $attr['contentColor'] ). '!important' ));
			}
			if ( isset( $attr['contentTypography'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container .premium-blog-content-wrapper-inner p' );
				$css->render_typography( $attr['contentTypography'], 'Desktop' );
			}

			if ( isset( $attr['contentMargin'] ) ) {
				$content_spacing = $attr['contentMargin'];
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container .premium-blog-content-wrapper-inner p' );
				$css->add_property( 'margin', $css->render_spacing( $content_spacing['Desktop'], isset($content_spacing['unit']['Desktop'])?$content_spacing['unit']['Desktop']:$content_spacing['unit']  ) );
			}
			if ( isset( $attr['titleTypography'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container .premium-blog-entry-title , .' . $unique_id . ' .premium-blog-post-container .premium-blog-entry-title >* ' );
				$css->render_typography( $attr['titleTypography'], 'Desktop' );
			}
			if ( isset( $attr['shapeBottom'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container .premium-bottom-shape svg' );
				$css->add_property( 'fill', $css->render_color( $attr['shapeBottom']['color'] ) );
				$css->add_property( 'width', $css->render_range( $attr['shapeBottom']['width'], 'Desktop' ) );
				$css->add_property( 'height', $css->render_range( $attr['shapeBottom']['height'], 'Desktop' ) );
			}
			if ( isset( $attr['titleColor'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container .premium-blog-entry-title >* ' );
				$css->add_property( 'color', $css->render_string( $css->render_color( $attr['titleColor']) , ' !important') );
			}
			if ( isset( $attr['titleBottomSpacing'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container .premium-blog-entry-title' );
				$css->add_property( 'margin-bottom', $css->render_range( $attr['titleBottomSpacing'], 'Desktop' ) );
			}
			if ( isset( $attr['titleHoverColor'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container .premium-blog-entry-title:hover > *' );
				$css->add_property( 'color', $css->render_string( $css->render_color($attr['titleHoverColor'] ), ' !important' ));
			}
			// Meta
			if ( isset( $attr['metaTypography'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-meta-data , .'. $unique_id . ' .premium-blog-meta-data > a' );
				$css->render_typography( $attr['metaTypography'], 'Desktop' );
			}
			if ( isset( $attr['metaTypography'] ) ) {
				$iconSize = $attr['metaTypography'];
				$css->set_selector( '.' . $unique_id . ' .premium-blog-meta-data svg' );
				$css->add_property( 'width', $css->render_range( $iconSize['fontSize'], 'Desktop' ) );
				$css->add_property( 'height', $css->render_range( $iconSize['fontSize'], 'Desktop' ) );

			}
			if ( isset( $attr['metaColor'] ) ) {
				$css->set_selector( '.' . $unique_id . '  .premium-blog-meta-data' );
				$css->add_property( 'color', $css->render_color( $attr['metaColor'] ) );
				$css->set_selector( '.' . $unique_id . '  .premium-blog-meta-data svg' );
				$css->set_selector( '.' . $unique_id . '  .premium-blog-meta-data svg .cls-1' );
				$css->add_property( 'fill', $css->render_color( $attr['metaColor'] ) );

			}
			if ( isset( $attr['metaHoverColor'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-meta-data:hover ' );
				$css->add_property( 'color', $css->render_color( $attr['metaHoverColor'] ) );
				$css->set_selector( '.' . $unique_id . ' .premium-blog-meta-data:hover  svg' );
				$css->set_selector( '.' . $unique_id . ' .premium-blog-meta-data:hover  svg .cls-1' );

				$css->add_property( 'fill', $css->render_color( $attr['metaHoverColor'] ) );

			}

			if ( isset( $attr['sepColor'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-meta-separtor' );
				$css->add_property( 'color', $css->render_string( $css->render_color( $attr['sepColor'] ), '!important' ) );
			}

			// Image

			if ( isset( $attr['thumbnail'] ) && !empty($attr['thumbnail']) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-outer-container img ' );
				$css->add_property( 'object-fit',  $attr['thumbnail'] );
			}
			if ( isset( $attr['height'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-thumbnail-container img' );
				$css->add_property( 'height', $css->render_range( $attr['height'], 'Desktop' ) );
			}
			if(isset($attr['hoverEffect']) &&($attr['hoverEffect']=="zoomin" ||$attr['hoverEffect']=="zoomout"||$attr['hoverEffect']=="scale"||$attr['hoverEffect']=="trans")){
				if ( isset( $attr['filter'] ) ) {
					$css->set_selector( '.' . $unique_id . ' .premium-blog-post-outer-container img' );
					$css->add_property('filter', $css->render_filter($attr['filter'] )		);
	
				}	
			}
			if(isset($attr['hoverEffect']) &&($attr['hoverEffect']=="zoomin" ||$attr['hoverEffect']=="zoomout"||$attr['hoverEffect']=="scale"||$attr['hoverEffect']=="trans")){

        if ( isset( $attr['Hoverfilter'] ) ) {
          $css->set_selector( '.' . $unique_id . ' .premium-blog-post-outer-container:hover img' );
          $css->add_property('filter', $css->render_filter($attr['Hoverfilter'] )		);
        }
		  }
			if ( isset( $attr['colorOverlay'] ) ) {
				$css->set_selector( '.' . $unique_id . '  .premium-blog-thumbnail-overlay  , .' . $unique_id . ' .premium-blog-framed-effect , .' . $unique_id . ' .premium-blog-bordered-effect, .' . $unique_id . ' .premium-blog-squares-effect:before , .' . $unique_id . ' .premium-blog-squares-effect:after , .' . $unique_id . '  .premium-blog-squares-square-container:before, .' . $unique_id . ' .premium-blog-squares-square-container:after' );
				$css->add_property( 'background-color', $css->render_color( $attr['colorOverlay'] ) );
			}
			if ( isset( $attr['colorOverlayHover'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container:hover  .premium-blog-thumbnail-overlay  , .' . $unique_id . ' .premium-blog-post-container:hover  .premium-blog-framed-effect , .' . $unique_id . ' .premium-blog-post-container:hover  .premium-blog-bordered-effect, .' . $unique_id . ' .premium-blog-post-container:hover  .premium-blog-squares-effect:before , .' . $unique_id . ' .premium-blog-post-container:hover  .premium-blog-squares-effect:after , .' . $unique_id . ' .premium-blog-post-container:hover   .premium-blog-squares-square-container:before, .' . $unique_id . ' .premium-blog-post-container:hover  .premium-blog-squares-square-container:after' );
				$css->add_property( 'background-color', $css->render_color( $attr['colorOverlayHover'] ) );
			}
			// excerpt

			if ( isset( $attr['btnTypography'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-excerpt-link' );
				$css->render_typography( $attr['btnTypography'], 'Desktop' );
			}
			if ( isset( $attr['buttonSpacing'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-excerpt-link' );
				$css->add_property( 'margin-top', $css->render_range( $attr['buttonSpacing'], 'Desktop' ) );
			}
			if ( isset( $attr['btnBorder'] ) ) {
				$content_border_width  = $attr['btnBorder']['borderWidth'];
				$content_border_radius = $attr['btnBorder']['borderRadius'];
				$content_border_color  = $attr['btnBorder']['borderColor'];
				$content_border_type   = $attr['btnBorder']['borderType'];

				$css->set_selector( '.' . $unique_id . ' .premium-blog-excerpt-link' );
				$css->add_property( 'border-color', $css->render_color( $content_border_color ) );
				$css->add_property( 'border-style',$css->render_string( $content_border_type ,''));

				$css->add_property( 'border-width', $css->render_spacing( $content_border_width['Desktop'], 'px' ) );
				$css->add_property( 'border-radius', $css->render_spacing( $content_border_radius['Desktop'], 'px' ) );
			}
			if ( isset( $attr['btnBorderHover'] ) ) {
				$content_border_width  = $attr['btnBorderHover']['borderWidth'];
				$content_border_radius = $attr['btnBorderHover']['borderRadius'];
				$content_border_color  = $attr['btnBorderHover']['borderColor'];
				$content_border_type   = $attr['btnBorderHover']['borderType'];

				$css->set_selector( '.' . $unique_id . '  .premium-blog-excerpt-link:hover' );
				if($content_border_type !=="none"){
					$css->add_property( 'border-color', $css->render_color( $content_border_color ) );
					$css->add_property( 'border-style',$css->render_string( $content_border_type ,'' ));
	
					$css->add_property( 'border-width', $css->render_spacing( $content_border_width['Desktop'], 'px' ) );
	
				}
				$css->add_property( 'border-radius', $css->render_spacing( $content_border_radius['Desktop'], 'px' ) );
			}
			if ( isset( $attr['btnPadding'] ) ) {
				$button_padding = $attr['btnPadding'];
				$css->set_selector( '.' . $unique_id . ' .premium-blog-excerpt-link' );
				$css->add_property( 'padding', $css->render_spacing( $button_padding['Desktop'],  isset($button_padding['unit']['Desktop'] )?$button_padding['unit']['Desktop']:$button_padding['unit']) );
			}

			if ( isset( $attr['buttonColor'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-excerpt-link' );
				$css->add_property( 'color', $css->render_color( $attr['buttonColor'] ) );
			}
			if ( isset( $attr['buttonBackground'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-excerpt-link' );
				$css->add_property( 'background-color', $css->render_color( $attr['buttonBackground'] ) );
			}
			if ( isset( $attr['buttonhover'] ) ) {
				$css->set_selector( '.' . $unique_id . '  .premium-blog-excerpt-link:hover' );
				$css->add_property( 'color', $css->render_color( $attr['buttonhover'] ) );
			}
			if ( isset( $attr['hoverBackground'] ) ) {
				$css->set_selector( '.' . $unique_id . '  .premium-blog-excerpt-link:hover' );
				$css->add_property( 'background-color', $css->render_color( $attr['hoverBackground'] ) );
			}
			if ( isset( $attr['arrowSize'] ) ) {
				$css->set_selector( '.' . $unique_id . '   .slick-arrow svg ' );
				$css->add_property( 'width',$css->render_string($attr['arrowSize'], 'px') );
				$css->add_property( 'height',$css->render_string($attr['arrowSize'], 'px') );

			}
			if ( isset( $attr['arrowColor'] ) ) {
				$css->set_selector( '.' . $unique_id . '   .slick-arrow svg' );
				$css->add_property( 'fill',$css->render_color( $attr['arrowColor'] ));
				$css->set_selector( '.' . $unique_id . '   .slick-arrow ' );
				$css->add_property( 'fill',$css->render_color( $attr['arrowColor'] ));
			}
			if ( isset( $attr['arrowPadding'] ) && !empty($attr['arrowPadding']) ) {
				$arrowPadding=$attr['arrowPadding'];
				$css->set_selector( '.' . $unique_id . '   .slick-arrow' );
				$css->add_property( 'padding', $css->render_spacing( $arrowPadding['Desktop'], isset($arrowPadding['unit']['Desktop'])?$arrowPadding['unit']['Desktop']:$arrowPadding['unit']  ) );
			}
			if ( isset( $attr['arrowBack'] ) ) {
				$css->set_selector( '.' . $unique_id . '   .slick-arrow ' );
				$css->add_property( 'background-color', $css->render_color($attr['arrowBack']) );
			}
			if ( isset( $attr['arrowPosition'] ) ) {
				$css->set_selector( '.' . $unique_id . '     .slick-prev' );
				$css->add_property( 'left', $css->render_range( $attr['arrowPosition'], 'Desktop' ) );
				$css->set_selector( '.' . $unique_id . '     .slick-next' );
				$css->add_property( 'right', $css->render_range( $attr['arrowPosition'], 'Desktop' ) );
			}
			if ( isset( $attr['arrowBorderRadius'] ) && !empty($attr['arrowBorderRadius']) ) {
				$css->set_selector( '.' . $unique_id . '   .slick-arrow  ' );
				$css->add_property( 'border-radius', $attr['arrowBorderRadius'] . 'px' );
			}
			if ( isset( $attr['dotsColor'] ) ) {
				$css->set_selector( '.' . $unique_id . '   ul.slick-dots li button:before' );
				$css->add_property( 'color', $css->render_color( $attr['dotsColor'] ));
			}
			if ( isset( $attr['dotMargin'] ) ) {
				$dotMargin=$attr['dotMargin'];
				$css->set_selector( '.' . $unique_id . '   ul.slick-dots ' );
				$css->add_property( 'margin', $css->render_spacing( $dotMargin['Desktop'], isset($dotMargin['unit']['Desktop'])?$dotMargin['unit']['Desktop']:$dotMargin['unit']  ) );
			}
			if ( isset( $attr['dotsActiveColor'] ) ) {
				$css->set_selector( '.' . $unique_id . '   .slick-dots li.slick-active button:before' );
				$css->add_property( 'color',$css->render_color( $attr['dotsActiveColor'] ));
			}

			if ( isset( $attr['catTypography'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-cats-container a' );
				$css->render_typography( $attr['catTypography'], 'Desktop' );
			}
			if ( isset( $attr['catColor'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-cats-container a' );
				$css->add_property( 'color',$css->render_color($attr['catColor']) );
			}
			if ( isset( $attr['backCat'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-cats-container a' );
				$css->add_property( 'background-color',$css->render_color( $attr['backCat']) );
			}
			if ( isset( $attr['hoverCatColor'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-cats-container a:hover' );
				$css->add_property( 'color', $css->render_color($attr['hoverCatColor'] ));
			}
			if ( isset( $attr['backHoverCat'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-cats-container a:hover' );
				$css->add_property( 'background-color', $css->render_color($attr['backHoverCat']) );
			}
			if ( isset( $attr['catBorder'] ) ) {
				$border_width  = $attr['catBorder']['borderWidth'];
				$border_radius = $attr['catBorder']['borderRadius'];
				$border_style  = $attr['catBorder']['borderType'];
				$border_color  = $attr['catBorder']['borderColor'];
				$css->set_selector( '.' . $unique_id . '  .premium-blog-cats-container a' );
				$css->add_property( 'border-style', $border_style );
				$css->add_property( 'border-color',$css->render_color( $border_color) );
				$css->add_property( 'border-width', $css->render_spacing( $border_width['Desktop'], 'px' ) );
				$css->add_property( 'border-radius', $css->render_spacing( $border_radius['Desktop'], 'px' ) );
			}
			if ( isset( $attr['catPadding'] ) ) {
				$category_padding = $attr['catPadding'];
				$css->set_selector( '.' . $unique_id . '  .premium-blog-cats-container a' );
				$css->add_property('padding', $css->render_spacing($category_padding['Desktop'], isset($category_padding['unit']['Desktop'])?$category_padding['unit']['Desktop']:$category_padding['unit'] ));
			}

			if (isset($attr['paginationPosition'])) {
				$css->set_selector( '.' . $unique_id .' .premium-blog-pagination-container');
				$css->add_property('align-items',  $attr['paginationPosition']['Desktop']);
				$css->add_property('justify-content',  $attr['paginationPosition']['Desktop']);

			}
			if (isset($attr['paginationTypography'])) {
				$css->set_selector('.' . $unique_id .' .premium-blog-pagination-container .page-numbers');
				$css->render_typography($attr['paginationTypography'], 'Desktop');
			}
			if (isset($attr['paginationColor'])) {
				$css->set_selector('.' . $unique_id . ' .premium-blog-pagination-container .page-numbers');
				$css->add_property('color',  $css->render_color($attr["paginationColor"]));
			}
			if (isset($attr['paginationBackColor'])) {
				$css->set_selector('.' . $unique_id .' .premium-blog-pagination-container .page-numbers');
				$css->add_property('background-color',  $css->render_color($attr["paginationBackColor"]));
			}
			if (isset($attr['paginationBorder'])) {
				$content_border_width  = $attr['paginationBorder']['borderWidth'];
				$content_border_radius = $attr['paginationBorder']['borderRadius'];
				$content_border_color = $attr['paginationBorder']['borderColor'];
				$content_border_type = $attr['paginationBorder']['borderType'];
		
				$css->set_selector('.' . $unique_id .' .premium-blog-pagination-container .page-numbers');
				$css->add_property('border-color', $css->render_color($content_border_color));
				$css->add_property('border-style', $content_border_type);
				$css->add_property('border-width', $css->render_spacing($content_border_width['Desktop'], 'px'));
				$css->add_property('border-radius', $css->render_spacing($content_border_radius['Desktop'], 'px'));
			}
			if (isset($attr['paginationMargin'])) {
				$content_margin = $attr['paginationMargin'];
				$css->set_selector('.' . $unique_id . ' .premium-blog-pagination-container .page-numbers');
				$css->add_property('margin', $css->render_spacing($content_margin['Desktop'], isset($content_margin['unit']['Desktop'])?$content_margin['unit']['Desktop']:$content_margin['unit'] ));
			}
			if (isset($attr['paginationPadding'])) {
				$content_padding = $attr['paginationPadding'];
				$css->set_selector('.' . $unique_id .' .premium-blog-pagination-container .page-numbers');
				$css->add_property('padding', $css->render_spacing($content_padding['Desktop'], isset($content_padding['unit']['Desktop'])?$content_padding['unit']['Desktop']:$content_padding['unit'] ));
			}
			// hover
			if (isset($attr['paginationHoverColor'])) {
				$css->set_selector('.' . $unique_id . ' .premium-blog-pagination-container .page-numbers:hover');
				$css->add_property('color',  $css->render_color($attr["paginationHoverColor"]));
			}
			if (isset($attr['paginationHoverback'])) {
				$css->set_selector('.' . $unique_id . ' .premium-blog-pagination-container .page-numbers:hover');
				$css->add_property('background-color',  $css->render_color($attr["paginationHoverback"]));
			}
			if (isset($attr['paginationHoverBorder'])) {
				$content_border_width  = $attr['paginationHoverBorder']['borderWidth'];
				$content_border_radius = $attr['paginationHoverBorder']['borderRadius'];
				$content_border_color = $attr['paginationHoverBorder']['borderColor'];
				$content_border_type = $attr['paginationHoverBorder']['borderType'];
		
				$css->set_selector('.' . $unique_id . ' .premium-blog-pagination-container .page-numbers:hover');
				$css->add_property('border-color', $css->render_color($content_border_color));
				$css->add_property('border-style', $content_border_type);
				$css->add_property('border-width', $css->render_spacing($content_border_width['Desktop'], 'px'));
				$css->add_property('border-radius', $css->render_spacing($content_border_radius['Desktop'], 'px'));
			}
			//active
			if (isset($attr['paginationActiveColor'])) {
				$css->set_selector('.' . $unique_id .' .premium-blog-pagination-container span.current');
				$css->add_property('color',  $css->render_color($attr["paginationActiveColor"]));
			}
			if (isset($attr['paginationActiveBack'])) {
				$css->set_selector('.' . $unique_id . ' .premium-blog-pagination-container span.current');
				$css->add_property('background-color',  $css->render_color($attr["paginationActiveBack"]));
			}
			if (isset($attr['paginationActiveBorder'])) {
				$content_border_width  = $attr['paginationActiveBorder']['borderWidth'];
				$content_border_radius = $attr['paginationActiveBorder']['borderRadius'];
				$content_border_color = $attr['paginationActiveBorder']['borderColor'];
				$content_border_type = $attr['paginationActiveBorder']['borderType'];
		
				$css->set_selector('.' . $unique_id . ' .premium-blog-pagination-container span.current');
				$css->add_property('border-color', $css->render_color($content_border_color));
				$css->add_property('border-style', $content_border_type);
				$css->add_property('border-width', $css->render_spacing($content_border_width['Desktop'], 'px'));
				$css->add_property('border-radius', $css->render_spacing($content_border_radius['Desktop'], 'px'));
			}
			$css->start_media_query( 'tablet' );

			// Tablet//////////////////////////////////////
			if ( isset( $attr['contentOffset'] ) && !empty($attr['contentOffset']['Tablet']) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-skin-modern .premium-blog-content-wrapper' );
				$css->add_property( 'top', $attr['contentOffset']['Tablet'] . 'px' );
			}
			if ( isset( $attr['authorImgPosition'] ) && !empty($attr['authorImgPosition']['Tablet'])) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-author-thumbnail' );
				$css->add_property( 'top', $attr['authorImgPosition']['Tablet'] . 'px' );
			}
			if ( isset( $attr['verticalAlign'] ) && !empty($attr['verticalAlign']['Tablet']) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-content-wrapper' );
				$css->add_property( 'justify-content', $attr['verticalAlign']['Tablet'] );
			}
			if ( isset( $attr['columns'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-outer-container' );
				$css->add_property( 'width', 'calc(100% / ' . $attr['columns']['Tablet'] . ')' );

			}
			if ( isset( $attr['columnGap'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-outer-container' );
				$css->add_property( 'padding-right','calc(' . $css->render_range( $attr['columnGap'], 'Tablet' ).'/2 )' );
				$css->add_property( 'padding-left','calc(' . $css->render_range( $attr['columnGap'], 'Tablet' ).'/2 )'  );

        $css->set_selector( '.' . $unique_id . '.premium-blog-grid .premium-blog-wrap' );
				$css->add_property( 'margin-right','calc(-' . $css->render_range( $attr['columnGap'], 'Tablet' ).'/2 )' );
				$css->add_property( 'margin-left','calc(-' . $css->render_range( $attr['columnGap'], 'Tablet' ).'/2 )'  );

			}
			if ( isset( $attr['rowGap'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-wrap' );
				$css->add_property( 'row-gap', $css->render_range( $attr['rowGap'], 'Tablet' ) );
			}

			if ( isset( $attr['margin'] ) ) {
				$container_margin = $attr['margin'];
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-outer-container' );
				$css->add_property( 'padding', $css->render_spacing( $container_margin['Tablet'], isset($container_margin['unit']['Tablet'])?$container_margin['unit']['Tablet']:$container_margin['unit']   ) );
			}
			if ( isset( $attr['padding'] ) ) {
				$container_padding = $attr['padding'];
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container' );
				$css->add_property( 'padding', $css->render_spacing( $container_padding['Tablet'], isset($container_padding['unit']['Tablet'])?$container_padding['unit']['Tablet']:$container_padding['unit']  ) );
			}
			if ( isset( $attr['border'] ) ) {
				$border_width  = $attr['border']['borderWidth'];
				$border_radius = $attr['border']['borderRadius'];
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container' );
				$css->add_property( 'border-width', $css->render_spacing( $border_width['Tablet'], 'px' ) );
				$css->add_property( 'border-radius', $css->render_spacing( $border_radius['Tablet'], 'px' ) );
			}
			if ( isset( $attr['advancedBorder'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container' );
				$css->add_property( 'border-radius', $attr['advancedBorder'] ? $attr['advancedBorderValue'] . '!important' : '' );
			}
			if ( isset( $attr['contentBoxMargin'] ) ) {
				$content_margin = $attr['contentBoxMargin'];
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container > .premium-blog-content-wrapper ' );
				$css->add_property( 'margin', $css->render_spacing( $content_margin['Tablet'], isset($content_margin['unit']['Tablet'])?$content_margin['unit']['Tablet']:$content_margin['unit']  ) );
			}
			if ( isset( $attr['contentPadding'] ) ) {
				$content_padding = $attr['contentPadding'];
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container > .premium-blog-content-wrapper ' );
				$css->add_property( 'padding', $css->render_spacing( $content_padding['Tablet'], isset($content_padding['unit']['Tablet'])?$content_padding['unit']['Tablet']:$content_padding['unit']  ) );
			}
			if ( isset( $attr['align'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container > .premium-blog-content-wrapper ' );
				$css->add_property( 'text-align', $css->get_responsive_css( $attr['align'], 'Tablet' ) );
			}
			if ( isset( $attr['align'] ) ) {
				$content_align      = $css->get_responsive_css( $attr['align'], 'Tablet' );
				$css->set_selector( '.' . $unique_id . ' .post-categories , .'. $unique_id . '  .premium-blog-post-tags-container');
				$css->add_property( 'justify-content', $css->render_align_self($content_align)  );
			}
			if ( isset( $attr['align'] ) ) {
				$content_align      = $css->get_responsive_css( $attr['align'], 'Tablet' );
				$css->set_selector( '.' . $unique_id . ' .premium-blog-inner-container');
				$css->add_property( 'align-items', $css->render_align_self($content_align)  );
			}

			if ( isset( $attr['contentTypography'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container .premium-blog-content-wrapper-inner p' );
				$css->render_typography( $attr['contentTypography'], 'Tablet' );
			}

			if ( isset( $attr['contentMargin'] ) ) {
				$content_spacing = $attr['contentMargin'];
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container .premium-blog-content-wrapper-inner p' );
				$css->add_property( 'margin', $css->render_spacing( $content_spacing['Tablet'], isset($content_spacing['unit']['Tablet'])?$content_spacing['unit']['Tablet']:$content_spacing['unit']  ) );
			}
			if ( isset( $attr['titleTypography'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container .premium-blog-entry-title >* ' );
				$css->render_typography( $attr['titleTypography'], 'Tablet' );
			}
			if ( isset( $attr['shapeBottom'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container .premium-bottom-shape svg' );
				$css->add_property( 'width', $css->render_range( $attr['shapeBottom']['width'], 'Tablet' ) );
				$css->add_property( 'height', $css->render_range( $attr['shapeBottom']['height'], 'Tablet' ) );
			}
			if ( isset( $attr['titleBottomSpacing'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container .premium-blog-entry-title' );
				$css->add_property( 'margin-bottom', $css->render_range( $attr['titleBottomSpacing'], 'Tablet' ) );
			}
			// Meta
			if ( isset( $attr['metaTypography'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-meta-data' );
				$css->render_typography( $attr['metaTypography'], 'Tablet' );
			}
			if ( isset( $attr['metaTypography'] ) ) {
				$iconSize = $attr['metaTypography'];
				$css->set_selector( '.' . $unique_id . ' .premium-blog-meta-data svg' );
				$css->add_property( 'width', $css->render_range( $iconSize['fontSize'], 'Tablet' ) );
				$css->add_property( 'height', $css->render_range( $iconSize['fontSize'], 'Tablet' ) );

			}

			// Image

			if ( isset( $attr['height'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-outer-container  .premium-blog-thumb-effect-wrapper ' );
				$css->add_property( 'height', $css->render_range( $attr['height'], 'Tablet' ) );
			}

			// excerpt

			if ( isset( $attr['btnTypography'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-excerpt-link' );
				$css->render_typography( $attr['btnTypography'], 'Tablet' );
			}
			if ( isset( $attr['buttonSpacing'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-excerpt-link' );
				$css->add_property( 'margin-top', $css->render_range( $attr['buttonSpacing'], 'Tablet' ) );
			}
			if ( isset( $attr['btnBorder'] ) ) {
				$content_border_width  = $attr['btnBorder']['borderWidth'];
				$content_border_radius = $attr['btnBorder']['borderRadius'];
				$content_border_color  = $attr['btnBorder']['borderColor'];
				$content_border_type   = $attr['btnBorder']['borderType'];

				$css->set_selector( '.' . $unique_id . ' .premium-blog-excerpt-link' );
				$css->add_property( 'border-color', $css->render_color( $content_border_color ) );
				$css->add_property( 'border-style', $content_border_type );

				$css->add_property( 'border-width', $css->render_spacing( $content_border_width['Tablet'], 'px' ) );
				$css->add_property( 'border-radius', $css->render_spacing( $content_border_radius['Tablet'], 'px' ) );
			}
			if ( isset( $attr['btnBorderHover'] ) ) {
				$content_border_width  = $attr['btnBorderHover']['borderWidth'];
				$content_border_radius = $attr['btnBorderHover']['borderRadius'];
				$content_border_color  = $attr['btnBorderHover']['borderColor'];
				$content_border_type   = $attr['btnBorderHover']['borderType'];

				$css->set_selector( '.' . $unique_id . ' .premium-blog-excerpt-link:hover' );
				$css->add_property( 'border-color', $css->render_color( $content_border_color ) );
				$css->add_property( 'border-style', $content_border_type );

				$css->add_property( 'border-width', $css->render_spacing( $content_border_width['Tablet'], 'px' ) );
				$css->add_property( 'border-radius', $css->render_spacing( $content_border_radius['Tablet'], 'px' ) );
			}
			if ( isset( $attr['btnPadding'] ) ) {
				$button_padding = $attr['btnPadding'];
				$css->set_selector( '.' . $unique_id . ' .premium-blog-excerpt-link' );
				$css->add_property( 'padding', $css->render_spacing( $button_padding['Tablet'], isset( $button_padding['unit']['Tablet'])? $button_padding['unit']['Tablet']: $button_padding['unit'] ) );
			}
			if ( isset( $attr['catBorder'] ) ) {
				$border_width  = $attr['catBorder']['borderWidth'];
				$border_radius = $attr['catBorder']['borderRadius'];
			
				$css->set_selector( '.' . $unique_id . '  .premium-blog-cats-container a' );
				
				$css->add_property( 'border-width', $css->render_spacing( $border_width['Tablet'], 'px' ) );
				$css->add_property( 'border-radius', $css->render_spacing( $border_radius['Tablet'], 'px' ) );
			}
			if (isset($attr['paginationPosition'])) {
				$css->set_selector( '.' . $unique_id .' .premium-blog-pagination-container');
				$css->add_property('align-items',  $attr['paginationPosition']['Tablet']);
				$css->add_property('justify-content',  $attr['paginationPosition']['Tablet']);

			}
			if (isset($attr['paginationTypography'])) {
				$css->set_selector('.' . $unique_id .' .premium-blog-pagination-container .page-numbers');
				$css->render_typography($attr['paginationTypography'], 'Tablet');
			}

			if (isset($attr['paginationMargin'])) {
				$content_margin = $attr['paginationMargin'];
				$css->set_selector('.' . $unique_id . ' .premium-blog-pagination-container .page-numbers');
				$css->add_property('padding', $css->render_spacing($content_margin['Tablet'], isset($content_margin['unit']['Tablet'])?$content_margin['unit']['Tablet']:$content_margin['unit'] ));
			}
			if (isset($attr['paginationPadding'])) {
				$content_padding = $attr['paginationPadding'];
				$css->set_selector('.' . $unique_id .' .premium-blog-pagination-container .page-numbers');
				$css->add_property('padding', $css->render_spacing($content_padding['Tablet'], isset( $content_padding['unit']['Tablet'])? $content_padding['unit']['Tablet']: $content_padding['unit']));
			}
			if ( isset( $attr['dotMargin'] ) ) {
				$dotMargin=$attr['dotMargin'];
				$css->set_selector( '.' . $unique_id . '   ul.slick-dots ' );
				$css->add_property( 'margin', $css->render_spacing( $dotMargin['Tablet'], isset($dotMargin['unit']['Tablet'])?$dotMargin['unit']['Tablet']:$dotMargin['unit']  ) );
			}
			if ( isset( $attr['arrowPosition'] ) ) {
				$css->set_selector( '.' . $unique_id . '     .slick-prev' );
				$css->add_property( 'left', $css->render_range( $attr['arrowPosition'], 'Tablet' ) );
				$css->set_selector( '.' . $unique_id . '     .slick-next' );
				$css->add_property( 'right', $css->render_range( $attr['arrowPosition'], 'Tablet' ) );
			}

			$css->stop_media_query();

			$css->start_media_query( 'mobile' );

			if ( isset( $attr['contentOffset'] ) && !empty($attr['contentOffset']['Mobile'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-skin-modern .premium-blog-content-wrapper' );
				$css->add_property( 'top', $attr['contentOffset']['Mobile'] . 'px' );
			}
			if ( isset( $attr['authorImgPosition'] ) && !empty($attr['authorImgPosition']['Mobile']) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-author-thumbnail' );
				$css->add_property( 'top', $attr['authorImgPosition']['Mobile'] . 'px' );
			}
			if ( isset( $attr['verticalAlign'] ) && !empty($attr['verticalAlign']['Mobile']) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-content-wrapper' );
				$css->add_property( 'justify-content', $attr['verticalAlign']['Mobile'] );
			}
			if ( isset( $attr['columns'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-outer-container' );
				$css->add_property( 'width', 'calc(100% / ' . $attr['columns']['Mobile'] . ')' );

			}
			if ( isset( $attr['columnGap'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-outer-container' );
				$css->add_property( 'padding-right','calc(' . $css->render_range( $attr['columnGap'], 'Mobile' ).'/2 )' );
				$css->add_property( 'padding-left','calc(' . $css->render_range( $attr['columnGap'], 'Mobile' ).'/2 )'  );

        $css->set_selector( '.' . $unique_id . '.premium-blog-grid .premium-blog-wrap' );
				$css->add_property( 'margin-right','calc(-' . $css->render_range( $attr['columnGap'], 'Mobile' ).'/2 )' );
				$css->add_property( 'margin-left','calc(-' . $css->render_range( $attr['columnGap'], 'Mobile' ).'/2 )'  );
			}
			if ( isset( $attr['rowGap'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-wrap' );
				$css->add_property( 'row-gap', $css->render_range( $attr['rowGap'], 'Mobile' ) );
			}

			if ( isset( $attr['margin'] ) ) {
				$container_margin = $attr['margin'];
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-outer-container' );
				$css->add_property( 'padding', $css->render_spacing( $container_margin['Mobile'],isset($container_margin['unit']['Mobile'])?$container_margin['unit']['Mobile']:$container_margin['unit']  ) );
			}
			if ( isset( $attr['padding'] ) ) {
				$container_padding = $attr['padding'];
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container' );
				$css->add_property( 'padding', $css->render_spacing( $container_padding['Mobile'], isset($container_padding['unit']['Mobile'])?$container_padding['unit']['Mobile']:$container_padding['unit']  ) );
			}
			if ( isset( $attr['border'] ) ) {
				$border_width  = $attr['border']['borderWidth'];
				$border_radius = $attr['border']['borderRadius'];
				
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container' );
				$css->add_property( 'border-width', $css->render_spacing( $border_width['Mobile'], 'px' ) );
				$css->add_property( 'border-radius', $css->render_spacing( $border_radius['Mobile'], 'px' ) );
			}
			if ( isset( $attr['advancedBorder'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container' );
				$css->add_property( 'border-radius', $attr['advancedBorder'] ? $attr['advancedBorderValue'] . '!important' : '' );
			}
			if ( isset( $attr['contentBoxMargin'] ) ) {
				$content_margin = $attr['contentBoxMargin'];
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container > .premium-blog-content-wrapper ' );
				$css->add_property( 'margin', $css->render_spacing( $content_margin['Mobile'], isset($content_margin['unit']['Mobile'])?$content_margin['unit']['Mobile']:$content_margin['unit']  ) );
			}
			if ( isset( $attr['contentPadding'] ) ) {
				$content_padding = $attr['contentPadding'];
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container > .premium-blog-content-wrapper ' );
				$css->add_property( 'padding', $css->render_spacing( $content_padding['Mobile'],isset($content_padding['unit']['Mobile'])?$content_padding['unit']['Mobile']:$content_padding['unit']  ) );
			}
			if ( isset( $attr['align'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container > .premium-blog-content-wrapper ' );
				$css->add_property( 'text-align', $css->get_responsive_css( $attr['align'], 'Mobile' ) );
			}
			if ( isset( $attr['align'] ) ) {
				$content_align      = $css->get_responsive_css( $attr['align'], 'Mobile' );
				$css->set_selector( '.' . $unique_id . ' .post-categories , .'. $unique_id . '  .premium-blog-post-tags-container');
				$css->add_property( 'justify-content', $css->render_align_self($content_align)  );
			}
			if ( isset( $attr['align'] ) ) {
				$content_align      = $css->get_responsive_css( $attr['align'], 'Mobile' );
				$css->set_selector( '.' . $unique_id . ' .premium-blog-inner-container');
				$css->add_property( 'align-items', $css->render_align_self($content_align)  );
			}

			if ( isset( $attr['contentTypography'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container .premium-blog-content-wrapper-inner p' );
				$css->render_typography( $attr['contentTypography'], 'Mobile' );
			}

			if ( isset( $attr['contentMargin'] ) ) {
				$content_spacing = $attr['contentMargin'];
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container .premium-blog-content-wrapper-inner p' );
				$css->add_property( 'margin', $css->render_spacing( $content_spacing['Mobile'],isset($content_spacing['unit']['Mobile'])?$content_spacing['unit']['Mobile']:$content_spacing['unit']  ) );
			}
			if ( isset( $attr['titleTypography'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container .premium-blog-entry-title >* ' );
				$css->render_typography( $attr['titleTypography'], 'Mobile' );
			}
			if ( isset( $attr['shapeBottom'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container .premium-bottom-shape svg' );
				$css->add_property( 'width', $css->render_range( $attr['shapeBottom']['width'], 'Mobile' ) );
				$css->add_property( 'height', $css->render_range( $attr['shapeBottom']['height'], 'Mobile' ) );
			}
			if ( isset( $attr['titleBottomSpacing'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-container .premium-blog-entry-title' );
				$css->add_property( 'margin-bottom', $css->render_range( $attr['titleBottomSpacing'], 'Mobile' ) );
			}
			// Meta
			if ( isset( $attr['metaTypography'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-meta-data' );
				$css->render_typography( $attr['metaTypography'], 'Mobile' );
			}
			if ( isset( $attr['metaTypography'] ) ) {
				$iconSize = $attr['metaTypography'];
				$css->set_selector( '.' . $unique_id . ' .premium-blog-meta-data svg' );
				$css->add_property( 'width', $css->render_range( $iconSize['fontSize'], 'Mobile' ) );
				$css->add_property( 'height', $css->render_range( $iconSize['fontSize'], 'Mobile' ) );

			}

			// Image

			if ( isset( $attr['height'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-post-outer-container  .premium-blog-thumb-effect-wrapper ' );
				$css->add_property( 'height', $css->render_range( $attr['height'], 'Mobile' ) );
			}

			// excerpt

			if ( isset( $attr['btnTypography'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-excerpt-link' );
				$css->render_typography( $attr['btnTypography'], 'Mobile' );
			}
			if ( isset( $attr['buttonSpacing'] ) ) {
				$css->set_selector( '.' . $unique_id . ' .premium-blog-excerpt-link' );
				$css->add_property( 'margin-top', $css->render_range( $attr['buttonSpacing'], 'Mobile' ) );
			}
			if ( isset( $attr['btnBorder'] ) ) {
				$content_border_width  = $attr['btnBorder']['borderWidth'];
				$content_border_radius = $attr['btnBorder']['borderRadius'];
				$content_border_color  = $attr['btnBorder']['borderColor'];
				$content_border_type   = $attr['btnBorder']['borderType'];

				$css->set_selector( '.' . $unique_id . ' .premium-blog-excerpt-link' );
				$css->add_property( 'border-color', $css->render_color( $content_border_color ) );
				$css->add_property( 'border-style', $content_border_type );

				$css->add_property( 'border-width', $css->render_spacing( $content_border_width['Mobile'], 'px' ) );
				$css->add_property( 'border-radius', $css->render_spacing( $content_border_radius['Mobile'], 'px' ) );
			}
			if ( isset( $attr['btnBorderHover'] ) ) {
				$content_border_width  = $attr['btnBorderHover']['borderWidth'];
				$content_border_radius = $attr['btnBorderHover']['borderRadius'];
				$content_border_color  = $attr['btnBorderHover']['borderColor'];
				$content_border_type   = $attr['btnBorderHover']['borderType'];

				$css->set_selector( '.' . $unique_id . ' .premium-blog-excerpt-link:hover' );
				$css->add_property( 'border-color', $css->render_color( $content_border_color ) );
				$css->add_property( 'border-style', $content_border_type );

				$css->add_property( 'border-width', $css->render_spacing( $content_border_width['Mobile'], 'px' ) );
				$css->add_property( 'border-radius', $css->render_spacing( $content_border_radius['Mobile'], 'px' ) );
			}
			if ( isset( $attr['btnPadding'] ) ) {
				$button_padding = $attr['btnPadding'];
				$css->set_selector( '.' . $unique_id . ' .premium-blog-excerpt-link' );
				$css->add_property( 'padding', $css->render_spacing( $button_padding['Mobile'],isset($button_padding['unit']['Mobile'])?$button_padding['unit']['Mobile']:$button_padding['unit']  ) );
			}
			if ( isset( $attr['catBorder'] ) ) {
				$border_width  = $attr['catBorder']['borderWidth'];
				$border_radius = $attr['catBorder']['borderRadius'];
			
				$css->set_selector( '.' . $unique_id . '  .premium-blog-cats-container a' );
				$css->add_property( 'border-width', $css->render_spacing( $border_width['Mobile'], 'px' ) );
				$css->add_property( 'border-radius', $css->render_spacing( $border_radius['Mobile'], 'px' ) );
			}
			if (isset($attr['paginationPosition'])) {
				$css->set_selector( '.' . $unique_id .' .premium-blog-pagination-container');
				$css->add_property('align-items',  $attr['paginationPosition']['Mobile']);
				$css->add_property('justify-content',  $attr['paginationPosition']['Mobile']);

			}
			if (isset($attr['paginationTypography'])) {
				$css->set_selector('.' . $unique_id .' .premium-blog-pagination-container .page-numbers');
				$css->render_typography($attr['paginationTypography'], 'Mobile');
			}
			if (isset($attr['paginationMargin'])) {
				$content_margin = $attr['paginationMargin'];
				$css->set_selector('.' . $unique_id . ' .premium-blog-pagination-container .page-numbers');
				$css->add_property('padding', $css->render_spacing($content_margin['Mobile'], isset($content_margin['unit']['Mobile'])?$content_margin['unit']['Mobile']:$content_margin['unit'] ));
			}
			if (isset($attr['paginationPadding'])) {
				$content_padding = $attr['paginationPadding'];
				$css->set_selector('.' . $unique_id .' .premium-blog-pagination-container .page-numbers');
				$css->add_property('padding', $css->render_spacing($content_padding['Mobile'], isset($content_padding['unit']['Mobile'])?$content_padding['unit']['Mobile']:$content_padding['unit'] ));
			}
			if ( isset( $attr['dotMargin'] ) ) {
				$dotMargin=$attr['dotMargin'];
				$css->set_selector( '.' . $unique_id . '   ul.slick-dots ' );
				$css->add_property( 'margin', $css->render_spacing( $dotMargin['Mobile'], isset($dotMargin['unit']['Mobile'])?$dotMargin['unit']['Mobile']:$dotMargin['unit']  ) );
			}
			if ( isset( $attr['arrowPosition'] ) ) {
				$css->set_selector( '.' . $unique_id . '     .slick-prev' );
				$css->add_property( 'left', $css->render_range( $attr['arrowPosition'], 'Mobile' ) );
				$css->set_selector( '.' . $unique_id . '     .slick-next' );
				$css->add_property( 'right', $css->render_range( $attr['arrowPosition'], 'Mobile' ) );
			}

			$css->stop_media_query();
			return $css->css_output();

		}


	}

	PBG_Post::get_instance();

}




