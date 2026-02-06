<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define class 'PBG_Pattern' if not Exists
if ( ! class_exists( 'PBG_Pattern' ) ) {

	/**
	 * Define PBG_Pattern class
	 */
	class PBG_Pattern {

		/**
		 * Member Variable
		 *
		 * @var object instance
		 */
		private static $instance = null;
		/**
		 * Premium Blocks Pattern Categories
		 *
		 * @var pattern_categories
		 */
		public static $pattern_categories = array();
		
    	/**
		 * Premium Blocks Pattern blocks
		 *
		 * @var pattern_blocks
		 */
		public static $pattern_blocks = array();

		/**
		 * Premium Blocks Patterns
		 *
		 * @var pattern_templates
		 */
		public static $pattern_templates = array();

		public static $contents = array();

		/**
		 * Premium Blocks Pages
		 *
		 * @var pages
		 */
		public static $pages = array();

		public static $pattern_content = array();

		/**
		 * Post id
		 *
		 * @var string
		 */
		protected $post_id = '';

		public $namespace;

		public $rest_base;

		public $reset;

		protected $api_url_cat = 'https://premiumtemplates.io/wp-json/pbtemp/v2/categories/premium_pattern';
		protected $api_url_blocks = 'https://premiumtemplates.io/wp-json/pbtemp/v2/keywords/premium_pattern';
		protected $api_url_templates = 'https://premiumtemplates.io/wp-json/pbtemp/v2/templates/premium_pattern';
		protected $api_url_pattern_content = 'https://premiumtemplates.io/wp-json/pbtemp/v2/template/';

		/**
		 * Patterns category
		 *
		 * @var string
		 */
		private $category = 'premium-blocks';

		/**
		 * Constructor for the class
		 */
		public function __construct() {

			$this->namespace           = 'pbg-templates/v2';
			$this->rest_base           = 'get';
			$this->reset               = 'reset';

			 // Enqueue the required files
			add_action('admin_init',array( $this,'gutenberg_register_gutenberg_patterns'));

			add_action( 'rest_api_init', array( $this, 'register_templates_routes' ) );

			add_action( 'enqueue_block_editor_assets', array( $this, 'script_enqueue' ) );

			// Clean up orphaned image meta once per day
			if ( is_admin() && ! get_transient( 'pbg_cleanup_done' ) ) {
				$this->cleanup_orphaned_image_meta();
				set_transient( 'pbg_cleanup_done', true, DAY_IN_SECONDS );
			}

			if ( ! $this->is_gutenberg_active() ) {
				return;
			}
		}

		/**
		 * Setup the post select API endpoint.
		 *
		 * @return void
		 */
		public function is_gutenberg_active() {
			return function_exists( 'register_block_type' );
	   	}

		/**
		 * Clean up the list of favorite templates to remove any non-existent ones.
		 * * @return void
		 */
		public function cleanup_favorite_templates() {
			// Get the current list of favorite IDs from the database
			$favorites = get_option( 'pbg_favorite_templates', array() );

			// If no favorites, nothing to clean
            if ( empty( $favorites ) || ! is_array( $favorites ) ) {
                return;
            }
			// Get the list of all available template IDs
			// This assumes 'pattern_templates' transient is already set
			$templates = get_transient('pattern_templates');
			$template_ids = array();
			if (!empty($templates['templates']) && is_array($templates['templates'])) {
				$template_ids = array_map(function($template) {
					return $template['template_id'];
				}, $templates['templates']);
			}

			// Filter out any favorite IDs that are not in the list of available templates
			$cleaned_favorites = array_filter($favorites, function($id) use ($template_ids) {
				return in_array($id, $template_ids);
			});

			 // Only update if favorites changed
            if ( count( $cleaned_favorites ) !== count( $favorites ) ) {
                update_option( 'pbg_favorite_templates', array_values( $cleaned_favorites ) );
            }
		}

		/**
		 * Clean up orphaned image meta for premium blocks images.
		 * Removes meta entries where the associated post no longer exists.
		 * Processes in batches to avoid loading all results into memory at once.
		 *
		 * @return void
		 */
		public function cleanup_orphaned_image_meta() {
			global $wpdb;

			$batch_size = 1000;

			// Process _premium_blocks_image_hash in batches
			$offset = 0;
			while ( true ) {
				$orphaned_meta = $wpdb->get_results(
					$wpdb->prepare(
						"SELECT meta_id, post_id FROM {$wpdb->postmeta} WHERE meta_key = '_premium_blocks_image_hash' LIMIT %d OFFSET %d",
						$batch_size,
						$offset
					)
				);

				if ( empty( $orphaned_meta ) ) {
					break;
				}

				foreach ( $orphaned_meta as $meta ) {
					// Check if the post still exists
					if ( ! get_post( $meta->post_id ) ) {
						// Delete the orphaned meta
						delete_metadata_by_mid( 'post', $meta->meta_id );
					}
				}

				$offset += $batch_size;
			}

			// Process _premium_blocks_local_image_hash in batches
			$offset = 0;
			while ( true ) {
				$orphaned_local_meta = $wpdb->get_results(
					$wpdb->prepare(
						"SELECT meta_id, post_id FROM {$wpdb->postmeta} WHERE meta_key = '_premium_blocks_local_image_hash' LIMIT %d OFFSET %d",
						$batch_size,
						$offset
					)
				);

				if ( empty( $orphaned_local_meta ) ) {
					break;
				}

				foreach ( $orphaned_local_meta as $meta ) {
					// Check if the post still exists
					if ( ! get_post( $meta->post_id ) ) {
						// Delete the orphaned meta
						delete_metadata_by_mid( 'post', $meta->meta_id );
					}
				}

				$offset += $batch_size;
			}
		}

		public function gutenberg_register_gutenberg_patterns() {
			if ( current_user_can( 'edit_posts' ) ) {
				$this->cleanup_favorite_templates();
			}
		}
			
		public function register_templates_routes() {

			register_rest_route(
				$this->namespace,
				'/get_categories',
				array(
					array(
						'methods'             => WP_REST_Server::READABLE,
						'callback'            => array( $this, 'get_categories' ),
						'permission_callback' => array( $this, 'get_items_permission_check' ),
					),
				)
			);

			register_rest_route(
				$this->namespace,
				'/get_blocks',
				array(
					array(
						'methods'             => WP_REST_Server::READABLE,
						'callback'            => array( $this, 'get_blocks' ),
						'permission_callback' => array( $this, 'get_items_permission_check' ),
					),
				)
			);

			register_rest_route(
				$this->namespace,
				'/process_pattern',
				array(
					array(
						'methods'             => WP_REST_Server::CREATABLE,
						'callback'            => array( $this, 'process_pattern' ),
						'permission_callback' => array( $this, 'get_items_permission_check' ),
					),
				)
			);

			register_rest_route(
				$this->namespace,
				'/get_pattern',
				array(
					array(
						'methods'             => WP_REST_Server::READABLE,
						'callback'            => array( $this, 'get_pattern' ),
						'permission_callback' => array( $this, 'get_items_permission_check' ),
					),
				)
			);

			register_rest_route(
				$this->namespace,
				'/favorite',
				array(
					array(
						'methods'             => WP_REST_Server::EDITABLE,
						'callback'            => array( $this, 'favorite' ),
						'permission_callback' => array( $this, 'get_items_permission_check' ),
						
					),
				)
			);

			register_rest_route(
				$this->namespace,
				'/get_save_favorite',
				array(
					array(
						'methods'             => WP_REST_Server::READABLE,
						'callback'            => array( $this, 'get_save_favorite' ),
						'permission_callback' => array( $this, 'get_items_permission_check' ),
						
					),
				)
			);

			register_rest_route(
				$this->namespace,
				'/get_pattern_content/(?P<templateId>\d+)',
				array(
					array(
						'methods'             => WP_REST_Server::READABLE,
						'callback'            => array( $this, 'get_pattern_content' ),
						'permission_callback' => array( $this, 'get_items_permission_check' ),
						'args'                => array( // Define the 'id' argument for documentation/validation
							'templateId' => array(
								'validate_callback' => function( $param, $request, $key ) {
									return is_numeric( $param ); // Ensure the ID is a number
								},
								'required' => true,
								'description' => __( 'Numeric ID of the template.', 'your-textdomain' ),
							),
						),
					),
				)
			);

		}

		/**
		 * Checks if a given request has access to search content.
		 *
		 *
		 * @param WP_REST_Request $request Full details about the request.
		 * @return true|WP_Error True if the request has search access, WP_Error object otherwise.
		*/
		public function get_items_permission_check( $request ) {
			return current_user_can( 'edit_posts' );
		}

		/**
		 * Retrieves a collection of objects.
		 *
		 * @param WP_REST_Request $request Full details about the request.
		 * @return WP_REST_Response Response object on success, or WP_Error object on failure.
		 */
		public function get_categories( WP_REST_Request $request ) {
			// Fetch and register pattern categories
			$pattern_categories = get_transient('pattern_categories');
			if (!$pattern_categories) {
				$response = wp_remote_get($this->api_url_cat, array('timeout' => 60, 'sslverify' => false));
				if (is_wp_error($response)) {
					return;
				}

				$raw_response_body = wp_remote_retrieve_body($response);

				// 4. Decode the JSON from the external API
				$pattern_categories = json_decode($raw_response_body, true);
				set_transient('pattern_categories', $pattern_categories, 3 * DAY_IN_SECONDS); // Expire every second
			}

			if (!empty($pattern_categories['terms']) && is_array($pattern_categories['terms'])) {
				self::$pattern_categories = [];
				self::$pattern_categories[] = $pattern_categories;
			}
			return self::$pattern_categories;
		}

		public function get_blocks( WP_REST_Request $request ) {
			// Fetch and register pattern blocks
			$pattern_blocks = get_transient('pattern_blocks');
			if (!$pattern_blocks) {
				$response = wp_remote_get($this->api_url_blocks, array('timeout' => 60, 'sslverify' => false));
				if (is_wp_error($response)) {
					return;
				}
				$pattern_blocks = json_decode(wp_remote_retrieve_body($response), true);
				set_transient('pattern_blocks', $pattern_blocks, 3 * DAY_IN_SECONDS); // Expire every second
			}

			if (!empty($pattern_blocks['terms']) && is_array($pattern_blocks['terms'])) {
				self::$pattern_blocks[] = $pattern_blocks;

			}
			return self::$pattern_blocks;
		}

		public function get_pattern( WP_REST_Request $request ) {
			$templates = get_transient('pattern_templates');
			if (!$templates) {
				$response = wp_remote_get($this->api_url_templates, array('timeout' => 60, 'sslverify' => false));
				if (is_wp_error($response)) {
					return;
				}
				$templates = json_decode(wp_remote_retrieve_body($response), true);
				set_transient('pattern_templates', $templates, 3 * DAY_IN_SECONDS);
			}

			if (!empty($templates['templates']) && is_array($templates['templates'])) {
				foreach ($templates['templates'] as $template) {
					self::$pattern_templates[] = $template;
				}
			}
			return self::$pattern_templates;
		}

		public function get_pattern_content (WP_REST_Request $request) {

			$id = $request->get_param( 'templateId' );
			if ( empty( $id ) ) {
				if (is_wp_error($id)) {
					return;
				}
			}

			$external_url = $this->api_url_pattern_content . $id;

			$response = wp_remote_get($external_url, array('timeout' => 60, 'sslverify' => false));
			if (is_wp_error($response)) {
				return;
			}
			$content = json_decode(wp_remote_retrieve_body($response), true);
			self::$pattern_content[] = $content;
			
			return self::$pattern_content;
		}

		/**
	 * Get Favorite.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return mixed
	 */
		public function get_save_favorite( WP_REST_Request $request ) {
			$favorites = get_option( 'pbg_favorite_templates', array() );
		
			return $favorites;
		}

		/**
		 * Retrieves a collection of objects.
		 *
		 * @param WP_REST_Request $request Full details about the request.
		 * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
		 */
		public function favorite( WP_REST_Request $request ) {

			$parameters = $request->get_json_params();

			if ( empty( $parameters['block_id'] ) ) {
				return rest_ensure_response( 'failed' );
			}

			$favorites = get_option( 'pbg_favorite_templates', array() );
			$id = $parameters['block_id'];
			$status = $parameters['status'];
			$block_type = $parameters['type'];

			// Empty favorite then add favorite in respective array tye and early return.
			if ( empty( $favorites ) && $status ) {
				$favorites[] = $id;
			}

			if ( $status ) {
				// Insert the block-id/page-id if it doesn't already exist.
				if ( !in_array( $id, $favorites ) ) {
					$favorites[] = $id;
				}
			} else {
				// Remove the block-id/page-id if it exists.
				if ( isset( $favorites ) && is_array( $favorites ) ) {
					$key = array_search( $id, $favorites );
					if ( false !== $key ) {
						unset( $favorites[ $key ] );
						$favorites = array_values( $favorites );
					}
				}
			}

			$update_status = update_option( 'pbg_favorite_templates', $favorites );

			return $favorites;
		}

		/**
		* Retrieves a collection of objects.
		*
		* @param WP_REST_Request $request Full details about the request.
		* @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
		*/
		public function process_pattern( WP_REST_Request $request ) {
			$parameters = $request->get_json_params();
			if ( empty( $parameters['content'] ) ) {
				return rest_ensure_response( 'failed' );
			}
			$content = $parameters['content'];
			$forms = isset( $parameters['forms'] ) ? $parameters['forms'] : array();
			$image_library = $parameters['image_library'];

			if ( ! empty( $forms ) ) {
				// $content = $this->process_forms( $content, $forms );
			}
			
			$content =$this->extract_unique_urls( $content );
			return $content;
		}

		public function extract_unique_urls( $content, $match = array() , $image_library = array() ) {
			// Find all urls.
			preg_match_all( '/https?:\/\/[^\'" ]+/i', $content, $match );
			$all_urls = array_unique( $match[0] );

			$all_urls = array_unique( $all_urls );

			if ( empty( $all_urls ) ) {
				return $content;
			}
			$map_urls    = array();
			$image_urls  = array();
			$lottie_urls = array();
			// Find all the images.
			foreach ( $all_urls as $key => $link ) {
				if ( $this->check_for_image( $link ) ) {
					$image_urls[] = $link;
				} elseif ( $this->check_for_lottie( $link ) ) {
					$lottie_urls[] = $link;
				}
			}
			// Process images.
			if ( ! empty( $image_urls ) ) {
				foreach ( $image_urls as $key => $image_url ) {
					// Download remote image.
					$image_data            = array(
						'url' => $image_url,
						'id'  => 0,
					);
					// If it's a pexels image, get the data.
					// If Pexels image, get metadata.
				if ( substr( $image_url, 0, strlen( 'https://images.pexels.com' ) ) === 'https://images.pexels.com' ) {
					$pexels_data = $this->get_image_info( $image_library, $image_url );
					if ( $pexels_data ) {
						$alt = ! empty( $pexels_data['alt'] ) ? $pexels_data['alt'] : '';
						$image_data['filename'] = ! empty( $pexels_data['filename'] ) ? $pexels_data['filename'] : $this->create_filename_from_alt( $alt );
						$image_data['photographer'] = ! empty( $pexels_data['photographer'] ) ? $pexels_data['photographer'] : '';
						$image_data['photographer_url'] = ! empty( $pexels_data['photographer_url'] ) ? $pexels_data['photographer_url'] : '';
						$image_data['photograph_url'] = ! empty( $pexels_data['url'] ) ? $pexels_data['url'] : '';
						$image_data['alt'] = $alt;
						$image_data['title'] = __( 'Photo by', 'premium-blocks' ) . ' ' . $image_data['photographer'];
					}
				}

					$downloaded_image       = $this->import_image( $image_data );
					$title = get_the_title($downloaded_image['id']);
					$alt = get_post_meta($downloaded_image['id'], '_wp_attachment_image_alt', true);
					if ( empty( $alt ) ) {
						$alt = $title;
					}
					$map_urls[ $image_url ] = array(
						'url' => $downloaded_image['url'],
						'id'  => $downloaded_image['id'],
						'title' => $title,
						'alt' => $alt,
					);
				}
			}
			 // Process Lottie animations.
			 if ( ! empty( $lottie_urls ) ) {
				foreach ( $lottie_urls as $key => $lottie_url ) {
					$lottie_file = $this->import_lottie( $lottie_url );
					$map_urls[ $lottie_url ] = array(
						'url' => $lottie_file['url'],
						'id'  => $lottie_file['id'],
					);
				}
			}
			// Replace the rest of images in content.
			foreach ( $map_urls as $old_url => $new_image ) {
				$content = str_replace( $old_url, $new_image['url'], $content );
				// Replace the slashed URLs if any exist.
				$old_url_slashed = str_replace( '/', '\/', $old_url );
				$new_url_slashed = str_replace( '/', '\/', $new_image['url'] );
				$content = str_replace( $old_url_slashed, $new_url_slashed, $content );
			}

			// Add pbg-image-* and wp-image-* classes to img tags in premium/image blocks based on the block's id attribute, removing old ones.
			// Also update the id in block attributes to the correct imported image ID.
			$content = preg_replace_callback(
				'/<!-- wp:premium\/image ([^>]+)-->(.*?)<!-- \/wp:premium\/image -->/s',
				function($matches) use ($map_urls) {
					$block_attrs = $matches[1];
					$block_content = $matches[2];
					// Find img src to match with map_urls
					if (preg_match('/<img[^>]+src="([^"]+)"/', $block_content, $img_match)) {
						$src = $img_match[1];
						foreach ($map_urls as $old_url => $new_data) {
							if ($src === $new_data['url']) {
								$new_id = $new_data['id'];
								// Update id in block_attrs
								$block_attrs = preg_replace('/"id":\d+/', '"id":' . $new_id, $block_attrs);
								break;
							}
						}
					}
					// Find id in the block attributes and update classes
					if (preg_match('/"id":(\d+)/', $block_attrs, $id_match)) {
						$id = $id_match[1];
						// Replace img tag to update classes, removing old pbg-image-* and wp-image-* and adding new ones
						$block_content = preg_replace_callback(
							'/<img([^>]+)>/',
							function($img_matches) use ($id) {
								$attrs = $img_matches[1];
								// Check for existing class attribute
								if (preg_match('/class="([^"]*)"/', $attrs, $class_match)) {
									$classes = explode(' ', $class_match[1]);
									// Remove old pbg-image-* and wp-image-* classes
									$classes = array_filter($classes, function($class) {
										return !preg_match('/^(pbg-image|wp-image)-\d+$/', $class);
									});
									// Add new classes
									$classes[] = 'pbg-image-' . $id;
									$classes[] = 'wp-image-' . $id;
									$new_class = implode(' ', array_unique($classes));
									$attrs = preg_replace('/class="[^"]*"/', 'class="' . $new_class . '"', $attrs);
								} else {
									// No class attribute, add one
									$attrs .= ' class="pbg-image-' . $id . ' wp-image-' . $id . '"';
								}
								return '<img' . $attrs . '>';
							},
							$block_content
						);
					}
					return '<!-- wp:premium/image ' . $block_attrs . '-->' . $block_content . '<!-- /wp:premium/image -->';
				},
				$content
			);

			// Add pbg-image-* and wp-image-* classes to img tags in premium/icon blocks when iconTypeSelect is 'img', based on the block's imageID attribute, removing old ones.
			// Also update the imageID and imageURL in block attributes to the correct imported image ID and URL.
			$content = preg_replace_callback(
				'/<!-- wp:premium\/icon ([^>]+)-->(.*?)<!-- \/wp:premium\/icon -->/s',
				function($matches) use ($map_urls) {
					$block_attrs = $matches[1];
					$block_content = $matches[2];
					// Check if iconTypeSelect is 'img'
					if (preg_match('/"iconTypeSelect":"img"/', $block_attrs)) {
						// Find img src to match with map_urls
						if (preg_match('/<img[^>]+src="([^"]+)"/', $block_content, $img_match)) {
							$src = $img_match[1];
							foreach ($map_urls as $old_url => $new_data) {
								if ($src === $new_data['url']) {
									$new_id = $new_data['id'];
									$new_url = $new_data['url'];
									// Update imageID in block_attrs
									$block_attrs = preg_replace('/"imageID":\d+/', '"imageID":' . $new_id, $block_attrs);
									// Update imageURL in block_attrs
									$block_attrs = preg_replace('/"imageURL":"[^"]*"/', '"imageURL":"' . addslashes($new_url) . '"', $block_attrs);
									break;
								}
							}
						}
						// Find imageID in the block attributes and update classes
						if (preg_match('/"imageID":(\d+)/', $block_attrs, $id_match)) {
							$id = $id_match[1];
							// Replace img tag to update classes, removing old pbg-image-* and wp-image-* and adding new ones
							$block_content = preg_replace_callback(
								'/<img([^>]+)>/',
								function($img_matches) use ($id) {
									$attrs = $img_matches[1];
									// Check for existing class attribute
									if (preg_match('/class="([^"]*)"/', $attrs, $class_match)) {
										$classes = explode(' ', $class_match[1]);
										// Remove old pbg-image-* and wp-image-* classes
										$classes = array_filter($classes, function($class) {
											return !preg_match('/^(pbg-image|wp-image)-\d+$/', $class);
										});
									// Add new classes
									$classes[] = 'wp-image-' . $id;
									$new_class = implode(' ', array_unique($classes));
									$attrs = preg_replace('/class="[^"]*"/', 'class="' . $new_class . '"', $attrs);
								} else {
									// No class attribute, add one
									$attrs .= ' class="wp-image-' . $id . '"';
								}
									return '<img' . $attrs . '>';
								},
								$block_content
							);
						}
					}
					return '<!-- wp:premium/icon ' . $block_attrs . '-->' . $block_content . '<!-- /wp:premium/icon -->';
				},
				$content
			);

			// Add wp-image-* classes to img tags in premium/list-item blocks when iconTypeSelect is 'img', based on the block's imageID attribute, removing old ones.
			// Also update the imageID and imageURL in block attributes to the correct imported image ID and URL.
			$content = preg_replace_callback(
				'/<!-- wp:premium\/list-item ([^>]+)-->(.*?)<!-- \/wp:premium\/list-item -->/s',
				function($matches) use ($map_urls) {
					$block_attrs = $matches[1];
					$block_content = $matches[2];
					// Check if iconTypeSelect is 'img'
					if (preg_match('/"iconTypeSelect":"img"/', $block_attrs)) {
						// Find img src to match with map_urls
						if (preg_match('/<img[^>]+src="([^"]+)"/', $block_content, $img_match)) {
							$src = $img_match[1];
							foreach ($map_urls as $old_url => $new_data) {
								if ($src === $new_data['url']) {
									$new_id = $new_data['id'];
									$new_url = $new_data['url'];
									// Update imageID in block_attrs
									$block_attrs = preg_replace('/"imageID":\d+/', '"imageID":' . $new_id, $block_attrs);
									// Update imageURL in block_attrs
									$block_attrs = preg_replace('/"imageURL":"[^"]*"/', '"imageURL":"' . addslashes($new_url) . '"', $block_attrs);
									break;
								}
							}
						}
						// Find imageID in the block attributes and update classes
						if (preg_match('/"imageID":(\d+)/', $block_attrs, $id_match)) {
							$id = $id_match[1];
							// Replace img tag to update classes, removing old wp-image-* classes and adding new ones
							$block_content = preg_replace_callback(
								'/<img([^>]+)>/',
								function($img_matches) use ($id) {
									$attrs = $img_matches[1];
									// Check for existing class attribute
									if (preg_match('/class="([^"]*)"/', $attrs, $class_match)) {
										$classes = explode(' ', $class_match[1]);
										// Remove old wp-image-* classes
										$classes = array_filter($classes, function($class) {
											return !preg_match('/^wp-image-\d+$/', $class);
										});
										// Add new class
										$classes[] = 'wp-image-' . $id;
										$new_class = implode(' ', array_unique($classes));
										$attrs = preg_replace('/class="[^"]*"/', 'class="' . $new_class . '"', $attrs);
									} else {
										// No class attribute, add one
										$attrs .= ' class="wp-image-' . $id . '"';
									}
									return '<img' . $attrs . '>';
								},
								$block_content
							);
						}
					}
					return '<!-- wp:premium/list-item ' . $block_attrs . '-->' . $block_content . '<!-- /wp:premium/list-item -->';
				},
				$content
			);

			// Add pbg-image-* and wp-image-* classes to img tags in premium/banner blocks, based on the block's imageID attribute, removing old ones.
			// Also update the imageID and imageURL in block attributes to the correct imported image ID and URL.
			$content = preg_replace_callback(
				'/<!-- wp:premium\/banner ([^>]+)-->(.*?)<!-- \/wp:premium\/banner -->/s',
				function($matches) use ($map_urls) {
					$block_attrs = $matches[1];
					$block_content = $matches[2];
					// Find img src to match with map_urls
					if (preg_match('/<img[^>]+src="([^"]+)"/', $block_content, $img_match)) {
						$src = $img_match[1];
						foreach ($map_urls as $old_url => $new_data) {
							if ($src === $new_data['url']) {
								$new_id = $new_data['id'];
								$new_url = $new_data['url'];
								// Update imageID in block_attrs
								$block_attrs = preg_replace('/"imageID":\d+/', '"imageID":' . $new_id, $block_attrs);
								// Update imageURL in block_attrs
								$block_attrs = preg_replace('/"imageURL":"[^"]*"/', '"imageURL":"' . addslashes($new_url) . '"', $block_attrs);
								break;
							}
						}
					}
					// Find imageID in the block attributes and update classes
					if (preg_match('/"imageID":(\d+)/', $block_attrs, $id_match)) {
						$id = $id_match[1];
						// Replace img tag to update classes, removing old pbg-image-* and wp-image-* and adding new ones
						$block_content = preg_replace_callback(
							'/<img([^>]+)>/',
							function($img_matches) use ($id) {
								$attrs = $img_matches[1];
								// Check for existing class attribute
								if (preg_match('/class="([^"]*)"/', $attrs, $class_match)) {
									$classes = explode(' ', $class_match[1]);
									// Remove old pbg-image-* and wp-image-* classes
									$classes = array_filter($classes, function($class) {
										return !preg_match('/^(pbg-image|wp-image)-\d+$/', $class);
									});
									// Add new classes
									$classes[] = 'wp-image-' . $id;
									$new_class = implode(' ', array_unique($classes));
									$attrs = preg_replace('/class="[^"]*"/', 'class="' . $new_class . '"', $attrs);
								} else {
									// No class attribute, add one
									$attrs .= ' class="wp-image-' . $id . '"';
								}
								return '<img' . $attrs . '>';
							},
							$block_content
						);
					}
					return '<!-- wp:premium/banner ' . $block_attrs . '-->' . $block_content . '<!-- /wp:premium/banner -->';
				},
				$content
			);

			// Update overlayStyles array in premium/video-box blocks to use new imported image IDs and URLs
			$content = preg_replace_callback(
				'/<!-- wp:premium\/video-box ([^>]+)-->(.*?)<!-- \/wp:premium\/video-box -->/s',
				function ($matches) use ($map_urls) {
					$block_attrs_str = $matches[1];
					$block_content   = $matches[2];

					// Handle overlayStyles JSON in block attributes
					if (preg_match('/"overlayStyles":(\[[^\]]*\])/', $block_attrs_str, $overlay_match)) {
						$overlay_str = $overlay_match[1];
						$overlay_array = json_decode($overlay_str, true);

						if (is_array($overlay_array)) {
							// Update IDs based on map_urls (URLs are already replaced in content)
							foreach ($overlay_array as &$item) {
								if (isset($item['overlayImgURL'])) {
									foreach ($map_urls as $old_url => $new_data) {
										if ($item['overlayImgURL'] === $new_data['url']) {
											$item['overlayImgID'] = (string) $new_data['id'];
											break;
										}
									}
									// Fallback for local URLs
									if (strpos($item['overlayImgURL'], get_site_url()) === 0 && (!isset($item['overlayImgID']) || $item['overlayImgID'] == 0)) {
										$found_id = attachment_url_to_postid($item['overlayImgURL']);
										if ($found_id) {
											$item['overlayImgID'] = (string) $found_id;
											$item['overlayImgURL'] = wp_get_attachment_url($found_id);
										}
									}
								}
							}

							$overlay_str = wp_json_encode($overlay_array);
							$block_attrs_str = preg_replace('/"overlayStyles":\[[^\]]*\]/', '"overlayStyles":' . $overlay_str, $block_attrs_str);
						}
					}

					return '<!-- wp:premium/video-box ' . $block_attrs_str . '-->' . $block_content . '<!-- /wp:premium/video-box -->';
				},
				$content
			);

			// Update repeaterMedia array in premium/gallery blocks to use new imported image IDs and URLs
			$content = preg_replace_callback(
				'/<!-- wp:premium\/gallery ([^>]+)-->(.*?)<!-- \/wp:premium\/gallery -->/s',
				function ($matches) use ($map_urls) {

					$block_attrs_str = html_entity_decode($matches[1]);
					$block_content   = $matches[2];

					// Decode attributes
					$block_attrs = json_decode($block_attrs_str, true);
					if (!is_array($block_attrs)) {
						// Try to clean malformed JSON if needed
						$block_attrs_str = stripslashes($block_attrs_str);
						$block_attrs = json_decode($block_attrs_str, true);
					}

					// Ensure blockId
					if (empty($block_attrs['blockId'])) {
						$block_attrs['blockId'] = 'premium-gallery-' . wp_generate_uuid4();
					}

					// === Handle repeaterMedia ===
					if (!empty($block_attrs['repeaterMedia']) && is_array($block_attrs['repeaterMedia'])) {
						$seen_urls = [];
						$unique_repeater = [];

						foreach ($block_attrs['repeaterMedia'] as $item) {
							if (!empty($item['media']['url'])) {
								$updated_item = $item;

								// Replace old → new URLs from map
								foreach ($map_urls as $old_url => $new_data) {
									if ($item['media']['url'] === $old_url) {
										$updated_item['media']['url'] = $new_data['url'];
										$updated_item['media']['id']  = $new_data['id'];
										break;
									}
								}

								// Local check: update to real attachment
								$found_id = attachment_url_to_postid($updated_item['media']['url']);
								if ($found_id) {
									$updated_item['media']['id'] = $found_id;
									$updated_item['media']['url'] = wp_get_attachment_url($found_id);
								}

								// Avoid duplicates
								if (!in_array($updated_item['media']['url'], $seen_urls)) {
									$seen_urls[] = $updated_item['media']['url'];
									$unique_repeater[] = $updated_item;
								}
							}
						}

						$block_attrs['repeaterMedia'] = array_values($unique_repeater);
					}

					// Encode back clean JSON (no control chars)
					$encoded_attrs = wp_json_encode($block_attrs, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

					$block_content = preg_replace_callback(
						'/(<img[^>]+>|<a[^>]+>)/i',
						function ($tag_match) use ($map_urls, $unique_repeater) {
							$tag = $tag_match[0];
							$is_img = stripos($tag, '<img') !== false;
							$attr_name = $is_img ? 'src' : 'href';

							if (preg_match('/' . $attr_name . '="([^"]+)"/', $tag, $src_match)) {
								$src = $src_match[1];
								$new_id = null;
								$new_url = null;

								// Logic to find new_url / new_id from unique_repeater
								foreach ($unique_repeater as $item) {
									if (isset($item['media']['url']) && $item['media']['url'] === $src) {
										$new_id = $item['media']['id'];
										$new_url = $item['media']['url'];
										break;
									}
								}

								// Replace URL if needed
								if ($new_url && $new_url !== $src) {
									$tag = preg_replace('/' . $attr_name . '="[^"]+"/', $attr_name . '="' . esc_url($new_url) . '"', $tag);
								}

								// If image, fix class wp-image-*
								if ($is_img && $new_id) {
									if (preg_match('/class="([^"]*)"/', $tag, $class_match)) {
										$classes = explode(' ', $class_match[1]);
										$classes = array_filter($classes, function($c){ return !preg_match('/^(wp-image|pbg-image)-\d+$/', $c); });
										$classes[] = 'wp-image-' . $new_id;
										$tag = preg_replace('/class="[^"]*"/', 'class="' . esc_attr(implode(' ', array_unique($classes))) . '"', $tag);
									} else {
										$tag .= ' class="wp-image-' . $new_id . '"';
									}
								}
							}

							return $tag;
						},
						$block_content
					);


					// Return cleaned block markup
					return sprintf(
						'<!-- wp:premium/gallery %s -->%s<!-- /wp:premium/gallery -->',
						$encoded_attrs,
						$block_content
					);
				},
				$content
			);

			return $content;
		}

		public function check_for_lottie( $link = '' ) {
			if ( empty( $link ) ) {
				return false;
			}
			return preg_match( '/^((https?:\/\/)|(www\.))([a-z0-9-].?)+(:[0-9]+)?\/[\w\-]+\.json\/?$/i', $link );
		}

		public function import_lottie( $lottie_url ) {
			$filename   = basename( $lottie_url );
			$lottie_path = $lottie_url;
			$info = wp_check_filetype( $lottie_path );
			$ext  = empty( $info['ext'] ) ? '' : $info['ext'];
			$type = empty( $info['type'] ) ? '' : $info['type'];
			// If we don't allow uploading the file type or ext, return.
			if ( ! $type || ! $ext ) {
				return array(
					'id'  => 0,
					'url' => $lottie_url,
				);
			}
			// Custom filename if passed as data.
			$filename = ! empty( $filename ) ? $this->sanitize_filename( $filename, $ext ) : $filename;
			// Get the file content.
			$file_content = wp_remote_retrieve_body(
				wp_safe_remote_get(
					$lottie_url,
					array(
						'timeout'   => '60',
						'sslverify' => false,
					)
				)
			);
			// Empty file content?
			if ( empty( $file_content ) ) {
				return array(
					'id'  => 0,
					'url' => $lottie_url,
				);
			}
		
			$upload = wp_upload_bits( $filename, null, $file_content );
			$post = array(
				'post_title' => ( ! empty( $filename ) ? $filename : '' ),
				'guid'       => $upload['url'],
			);
			$post['post_mime_type'] = $type;
			if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) {
				include( ABSPATH . 'wp-admin/includes/image.php' );
			}
			$post_id = wp_insert_attachment( $post, $upload['file'] );
			wp_update_attachment_metadata(
				$post_id,
				wp_generate_attachment_metadata( $post_id, $upload['file'] )
			);
		
			return array(
				'id'  => $post_id,
				'url' => $upload['url'],
			);
		}

		/**
		 * Check if link is for an image.
		 *
		 * @param string $link url possibly to an image.
		 */
		public function check_for_image( $link = '' ) {
			if ( empty( $link ) ) {
				return false;
			}
			if ( substr( $link, 0, strlen( 'https://images.pexels.com' ) ) === 'https://images.pexels.com' ) {
				return true;
			}
			return preg_match( '/^((https?:\/\/)|(www\.))([a-z0-9-].?)+(:[0-9]+)?\/[\w\-]+\.(jpg|png|gif|webp|jpeg)\/?$/i', $link );
		}

		/**
		* Get information for our image.
		*
		* @param array $images the image url.
		* @param string $target_src the image url.
		*/
		public function get_image_info( $images, $target_src ) {
			if ( isset( $images['data'] ) && is_array( $images['data'] ) ) {
				foreach ( $images['data'] as $image_group ) {
					foreach ( $image_group['images'] as $image ) {
						foreach ( $image['sizes'] as $size ) {
							if ( $size['src'] === $target_src ) {
								return array(
									'alt'              => ! empty( $image['alt'] ) ? $image['alt'] : '',
									'photographer'     => ! empty( $image['photographer'] ) ? $image['photographer'] : '',
									'url'              => ! empty( $image['url'] ) ? $image['url'] : '',
									'photographer_url' => ! empty( $image['photographer_url'] ) ? $image['photographer_url'] : '',
								);
							}
						}
					}
				}
			}
			return false;
		}

		/**
		* Create a filename from alt text.
		*/
		public function create_filename_from_alt( $alt ) {
			if ( empty( $alt ) ) {
				return '';
			}
			// Split the string into words.
			$words = explode( ' ', strtolower( $alt ) );
			// Limit to the first 7 words.
			$limited_words = array_slice( $words, 0, 7 );
			// Join the words with dashes.
			return implode( '-', $limited_words );
		}

		/**
		 * Import an image for the design library/patterns.
		 *
		 * @param array $image_data the image data to import.
		 */
		public function import_image( $image_data ) {
			static $imported_images = array(); // ✅ Prevent duplicate imports during same run

			// Normalize the key
			$key = sha1( $image_data['url'] );

			// If already imported in this process, just return cached
			if ( isset( $imported_images[ $key ] ) ) {
				return $imported_images[ $key ];
			}

			// Check if already imported in DB (existing feature)
			$local_image = $this->check_for_local_image( $image_data );
			if ( $local_image['status'] ) {
				$imported_images[ $key ] = $local_image['image']; // Cache it
				return $local_image['image'];
			}

			// Otherwise import normally (your existing logic)
			$filename   = basename( $image_data['url'] );
			$image_path = $image_data['url'];

			if ( substr( $image_data['url'], 0, strlen( 'https://images.pexels.com' ) ) === 'https://images.pexels.com' ) {
				$image_path = parse_url( $image_data['url'], PHP_URL_PATH );
				$filename = basename( $image_path );
			}

			$info = wp_check_filetype( $image_path );
			$ext  = empty( $info['ext'] ) ? '' : $info['ext'];
			$type = empty( $info['type'] ) ? '' : $info['type'];

			if ( ! $type || ! $ext ) {
				return $image_data;
			}

			$filename = ! empty( $image_data['filename'] ) ? $this->sanitize_filename( $image_data['filename'], $ext ) : $filename;

			$file_content = wp_remote_retrieve_body(
				wp_safe_remote_get(
					$image_data['url'],
					array(
						'timeout'   => '60',
						'sslverify' => false,
					)
				)
			);

			if ( empty( $file_content ) ) {
				return $image_data;
			}

			$upload = wp_upload_bits( $filename, null, $file_content );
			$post = array(
				'post_title'     => ( ! empty( $image_data['title'] ) ? $image_data['title'] : $filename ),
				'guid'           => $upload['url'],
				'post_mime_type' => $type,
			);

			if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) {
				include( ABSPATH . 'wp-admin/includes/image.php' );
			}

			$post_id = wp_insert_attachment( $post, $upload['file'] );
			wp_update_attachment_metadata(
				$post_id,
				wp_generate_attachment_metadata( $post_id, $upload['file'] )
			);

			// Meta
			if ( ! empty( $image_data['alt'] ) ) {
				update_post_meta( $post_id, '_wp_attachment_image_alt', $image_data['alt'] );
			}

			update_post_meta( $post_id, '_premium_blocks_image_hash', $key );
			update_post_meta( $post_id, '_premium_blocks_local_image_hash', sha1( $upload['url'] ) );

			$result = array(
				'id'  => $post_id,
				'url' => $upload['url'],
			);

			// ✅ Cache for rest of import
			$imported_images[ $key ] = $result;

			return $result;
		}

		/**
		* Check if image is already imported.
		*
		* @param array $image_data the image data to import.
		*/
		public function check_for_local_image( $image_data ) {
			global $wpdb;
			$image_id = '';

			// Check if the URL is local
			if ( strpos( $image_data['url'], get_site_url() ) !== false ) {
				// For local URLs, prioritize checking the local image hash first
				$image_id = $wpdb->get_var(
					$wpdb->prepare(
						'SELECT `post_id` FROM `' . $wpdb->postmeta . '`
							WHERE `meta_key` = \'_premium_blocks_local_image_hash\'
								AND `meta_value` = %s
						;',
						sha1( $image_data['url'] )
					)
				);

				if ( empty( $image_id ) ) {
					// Fallback to attachment_url_to_postid
					$image_id = attachment_url_to_postid( $image_data['url'] );
				}
			} else {
				// For remote URLs, check the image hash
				$image_id = $wpdb->get_var(
					$wpdb->prepare(
						'SELECT `post_id` FROM `' . $wpdb->postmeta . '`
							WHERE `meta_key` = \'_premium_blocks_image_hash\'
								AND `meta_value` = %s
						;',
						sha1( $image_data['url'] )
					)
				);
			}

			if ( ! empty( $image_id ) && ! get_post( $image_id ) ) {
				// Clean up orphaned meta if it exists (though WP should delete it on post deletion)
				delete_post_meta( $image_id, '_premium_blocks_image_hash' );
				delete_post_meta( $image_id, '_premium_blocks_local_image_hash' );
				$image_id = '';
			}
			if ( ! empty( $image_id ) ) {
				$local_image = array(
					'id'  => $image_id,
					'url' => ( ! empty( $image_data['url'] ) && strpos( $image_data['url'], get_site_url() ) !== false ) ? $image_data['url'] : wp_get_attachment_url( $image_id ),
				);
				return array(
					'status' => true,
					'image'  => $local_image,
				);
			}
			return array(
				'status' => false,
				'image'  => $image_data,
			);
		}

		/**
		* Sanitizes a string for a filename.
		*
		* @param string $filename The filename.
		* @return string a sanitized filename.
		*/
		public function sanitize_filename( $filename, $ext ) {
			return sanitize_file_name( $filename ) . '.' . $ext;
		}


		/**
		 * Get post id
		 *
		 * @return int
		 */
		public function set_post_id( $post_id ) {
			$this->post_id = $post_id;
		}

		/**
		 * Enqueue Script for Meta options
		 */
		public function script_enqueue() {

			$asset_file   = PREMIUM_BLOCKS_PATH . "templates/build/templates/index.asset.php";
			$dependencies = file_exists( $asset_file ) ? include $asset_file : array();
			$dependencies = $dependencies['dependencies'] ?? array();
			array_push( $dependencies, 'pbg-settings-js' );

			wp_enqueue_script(
				"pbg-templates-templates-js",
				PREMIUM_BLOCKS_URL . "templates/build/templates/index.js",
				$dependencies,
				PREMIUM_BLOCKS_VERSION,
				true
			);

			wp_enqueue_style(
				'pbg-templates-templates-css',
				PREMIUM_BLOCKS_URL . 'templates/build/templates/index.css',
				array(),
				$asset_file['version'] ?? PREMIUM_BLOCKS_VERSION,
				'all'
			);

			wp_localize_script(
                'pbg-templates-templates-js',
                'PremiumBlocksTemplates',
                array(
                    'favorites'          => apply_filters( 'pb_favorite', get_option( 'pbg_favorite_templates', array() ) ),
                    'nonce'              => wp_create_nonce( 'pb-template' ),
                    'ajaxurl'            => admin_url( 'admin-ajax.php' ),
                )
            );

			wp_enqueue_style(
				'pbg-global-settings-css',
				PREMIUM_BLOCKS_URL . "global-settings/build/post-editor-sidebar/index.css",
				array(),
				PREMIUM_BLOCKS_VERSION,
				'all'
			);
		}

		/**
		 * Creates and returns an instance of the class
		 *
		 * @since 1.0.0
		 * @access public
		 * return object
		 */
		public static function get_instance() {
			if ( self::$instance == null ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
	}
}

if ( ! function_exists( 'PBG_Pattern' ) ) {

	/**
	 * Returns an instance of the plugin class.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	function PBG_Pattern() {
		 return PBG_Pattern::get_instance();
	}
}

PBG_Pattern();