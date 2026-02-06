<?php

if (! defined('ABSPATH')) {
	exit();
}

/**
 * Define PBG_Blocks_Helper class
 */
class PBG_Blocks_Helper
{

	/**
	 * Class instance
	 *
	 * @var instance
	 */
	private static $instance = null;

	/**
	 * Blocks
	 *
	 * @var blocks
	 */
	public static $blocks;

	/**
	 * Config
	 *
	 * @var config
	 */
	public static $config;

	/**
	 * Global features
	 *
	 * @since 1.8.2
	 *
	 * @var array
	 */
	public $global_features;

	/**
	 * Performance Settings
	 *
	 * @since 2.0.14
	 *
	 * @var array
	 */
	public $performance_settings;

	/**
	 * Blocks Frontend Assets
	 *
	 * @since 2.0.14
	 *
	 * @var Pbg_Assets_Generator
	 */
	public $blocks_frontend_assets;

	/**
	 * Blocks Frontend CSS Deps
	 *
	 * @since 2.0.14
	 *
	 * @var array
	 */
	public $blocks_frontend_css_deps = array();

	/**
	 * Loaded Blocks
	 *
	 * @since 2.0.27
	 *
	 * @var array
	 */
	public $loaded_blocks = array();

	/**
	 * Entrance animation blocks
	 *
	 * @since 2.1.6
	 *
	 * @var array
	 */
	public $entrance_animation_blocks = array();

	/**
	 * Extra options blocks
	 *
	 * @var array
	 */
	public $extra_options_blocks = array();

	/**
	 * Support links blocks
	 *
	 * @var array
	 */
	public $support_links_blocks = array();

  /**
   * Content has premium blocks
   */
  public $has_premium_blocks = false;

	/**
	 * Integrations Settings
	 *
	 * @var array
	 */
	public $integrations_settings;

	public $is_post_revision = false;

	public $preview = false;
	public $file_generation = false;

  private static $pbg_attributes = array(
    'pbgHorizontalOrientation' => array(
      'type'    => 'object',
      'default' => array(
        'Desktop' => 'left',
        'Tablet'  => '',
        'Mobile'  => '',
      ),
    ),
    'pbgHorizontalOffset' => array(
      'type'    => 'object',
      'default' => array(
        'Desktop' => 0,
        'Tablet'  => '',
        'Mobile'  => '',
        'unit'    => array(
          'Desktop' => 'px',
          'Tablet'  => 'px',
          'Mobile'  => 'px',
        ),
      ),
    ),
    'pbgVerticalOrientation' => array(
      'type'    => 'object',
      'default' => array(
        'Desktop' => 'top',
        'Tablet'  => '',
        'Mobile'  => '',
      ),
    ),
    'pbgVerticalOffset' => array(
      'type'    => 'object',
      'default' => array(
        'Desktop' => 0,
        'Tablet'  => '',
        'Mobile'  => '',
        'unit'    => array(
          'Desktop' => 'px',
          'Tablet'  => 'px',
          'Mobile'  => 'px',
        ),
      ),
    ),
  );
  
  /**
	 * Constructor for the class
	 */
	public function __construct()
	{
		// Blocks Frontend Assets.
		$this->blocks_frontend_assets = new Pbg_Assets_Generator('frontend');
		// Global Features.
		$this->global_features = apply_filters('pb_global_features', get_option('pbg_global_features', array()));
		// Performance Settings.
		$this->performance_settings = apply_filters('pb_performance_options', get_option('pbg_performance_options', array()));
		// Gets Active Blocks.
		self::$blocks = apply_filters('pb_options', get_option('pb_options', array()));

		// Conditionally disable templates block based on global features
		$templates_button = $this->global_features['premium-templates-button'] ?? true;
		if (! $templates_button) {
			self::$blocks['templates'] = false;
		}

		$this->preview = isset($_GET['preview']); //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Nonce verification not required.
		if (wp_is_post_revision(get_the_ID())) {
			$this->is_post_revision = true;
		}
		// Support Links Blocks.
		$this->support_links_blocks = array(
			'premium/container',
			'premium/icon-box',
		);
		// Integrations Settings.
		$this->integrations_settings = apply_filters('pb_integrations_options', get_option('pbg_integrations_options', array()));
		// Gets Plugin Admin Settings.

		self::$config = apply_filters('pb_settings', get_option('pbg_blocks_settings', array()));
		$allow_json   = isset(self::$config['premium-upload-json']) ? self::$config['premium-upload-json'] : true;
		if ($allow_json) {
			add_filter('upload_mimes', array($this, 'pbg_mime_types')); // phpcs:ignore WordPressVIPMinimum.Hooks.RestrictedHooks.upload_mimes
			add_filter('wp_check_filetype_and_ext', array($this, 'fix_mime_type_json'), 75, 4);
		}
		add_action('init', array($this, 'on_init'), 20);
		// Enqueue Editor Assets.
		add_action('enqueue_block_editor_assets', array($this, 'pbg_editor'));
		// Enqueue Frontend RTL Styles.
		//add_action('enqueue_block_assets', array($this, 'pbg_frontend_rtl_style'));
		// Enqueue Frontend Styles.
		add_action('enqueue_block_assets', array($this, 'pbg_frontend'));
		// Enqueue Frontend Scripts.
		add_action('wp_enqueue_scripts', array($this, 'add_blocks_frontend_assets'), 10);
		// Register Premium Blocks category.
		add_filter('block_categories_all', array($this, 'register_premium_category'), 9999991, 2);

		add_action('enqueue_block_editor_assets', array($this, 'add_blocks_editor_styles'));

		add_action('wp_head', array($this, 'add_blocks_frontend_inline_styles'), 80);

		add_filter('render_block', array($this, 'add_block_style'), 9, 2);
		// Add custom breakpoints.
		add_filter('Premium_BLocks_mobile_media_query', array($this, 'mobile_breakpoint'), 1);
		add_filter('Premium_BLocks_tablet_media_query', array($this, 'tablet_breakpoint'), 1);
		add_filter('Premium_BLocks_desktop_media_query', array($this, 'desktop_breakpoint'), 1);

		// Add block in template parts in FSE theme styles.
		add_filter('render_block', array($this, 'add_block_style_in_template_parts'), 9, 2);

		// Submit form with ajax.
		add_action('wp_ajax_premium_form_submit', array($this, 'premium_form_submit'));
		add_action('wp_ajax_nopriv_premium_form_submit', array($this, 'premium_form_submit'));

    // Add AJAX handlers for post filtering tabs
    add_action( 'wp_ajax_pbg_filter_posts', array( $this, 'ajax_filter_posts' ) );
    add_action( 'wp_ajax_nopriv_pbg_filter_posts', array( $this, 'ajax_filter_posts' ) );

    // Add AJAX handlers for post pagination
    add_action( 'wp_ajax_pbg_paginate_posts', array( $this, 'ajax_paginate_posts' ) );
    add_action( 'wp_ajax_nopriv_pbg_paginate_posts', array( $this, 'ajax_paginate_posts' ) );

		// Get mailchimp lists.
		add_action('wp_ajax_premium_blocks_get_mailchimp_lists', array($this, 'premium_get_mailchimp_lists'));

		// get mailchimp list merge fields
		add_action('wp_ajax_pbg_editor_get_mailchimp_list_merge_fields', array($this, 'pbg_editor_get_mailchimp_list_merge_fields'));

		// Get mailerlite groups.
		add_action('wp_ajax_premium_blocks_get_mailerlite_groups', array($this, 'premium_get_mailerlite_groups'));

		// After post update, update the _pbg_blocks_version post meta.
		add_action('save_post', array($this, 'update_post_meta'), 10, 3);
		if (is_admin()) {
			add_action('init', array($this, 'init_admin_features'));
		}

    // Check and enqueue global responsive option CSS
    add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_global_responsive_option_css' ), 999 );

    // Enqueues styles that ensure compatibility with other plugins or themes.
    add_action( 'enqueue_block_assets', array( $this, 'enqueue_compatibility_styles' ) );

    // Enqueue assets for the editor content.
    add_action( 'enqueue_block_assets', array( $this, 'enqueue_editor_content_assets' ));
	}

  public function enqueue_editor_content_assets() {
    if ( ! is_admin() ) return;

    wp_enqueue_script(
      'pbg-isotope-editor',
      PREMIUM_BLOCKS_URL . 'assets/js/lib/isotope.pkgd.min.js',
      array(),
      PREMIUM_BLOCKS_VERSION,
      true
    );
  }

  /**
   * Enqueues styles that ensure compatibility with other plugins or themes
   *
   * @since 2.0.0
   * @access public
   * @return void
   */
  public function enqueue_compatibility_styles() {
    if( ! is_admin() ) {
      return;
    }

    $themes_to_check = array( 'Kadence', 'GeneratePress' );
    $compatibility_css = '';
    
    // We adding compatibility styles only in admin area for editor to handle compatibility with GeneratePress Theme.
    if ( in_array( wp_get_theme()->get('Name'), $themes_to_check ) || in_array( get_template(), $themes_to_check ) || in_array( get_stylesheet(), $themes_to_check ) ) {
      $compatibility_css .= "
        html :where(.wp-block[class*='premium-']) {
          margin-top: unset;
          margin-bottom: unset;
        }

        .wp-block[class*='premium-']
        :where( .pbg-content-wrap .block-editor-inner-blocks > .block-editor-block-list__layout > .wp-block ) {
          margin-left: unset;
          margin-right: unset;
        }

        .wp-block[class*='premium-'] :where( .block-editor-block-list__layout .wp-block ){
          max-width: inherit;
        }
        
        .premium-is-root-container.alignfull {
          max-width: none;
        }
      ";
    }

    // Minify CSS if css is not empty and the minify method is available.
    if ( ! empty( $compatibility_css ) && isset( $this->blocks_frontend_assets ) && method_exists( $this->blocks_frontend_assets, 'minify_css' ) ) {
      $compatibility_css = $this->blocks_frontend_assets->minify_css( $compatibility_css );
    }
    
    // If we have compatibility CSS, add it inline
    if ( ! empty( $compatibility_css ) ) {
      wp_register_style( 'pbg-compatibility', false );
      wp_enqueue_style( 'pbg-compatibility' );
      wp_add_inline_style( 'pbg-compatibility', $compatibility_css );
    }
  }

  /**
   * Enqueue global responsive option CSS if premium blocks are present
   */
  public function enqueue_global_responsive_option_css() {
    if ($this->has_premium_blocks || $this->content_has_premium_blocks()) {
      add_action('wp_head', array($this, 'inject_responsive_css'), 100);
    }
  }
  
  /**
   * Check if the current page/post contains premium blocks
   *
   * @return bool True if premium blocks are found, false otherwise.
   */
  private function content_has_premium_blocks() {
    global $post;
      
    // Handle singular posts/pages
    if (is_singular() && $post && has_blocks($post->post_content)) {
      if ($this->parse_blocks_for_premium($post->post_content)) {
        $this->has_premium_blocks = true;
        return true;
      }
    }
      
    // Note: Query loop posts are always excluded (archive/home/search pages)
    // This prevents checking individual posts in blog archives
    
    // Check FSE templates (home, single, archive, etc.)
    if (function_exists('get_block_template')) {
      $template = null;
      
      // Get the appropriate template based on context
      if (is_front_page() || is_home()) {
        $template = get_block_template(get_stylesheet() . '//home');
        if (!$template) {
          $template = get_block_template(get_stylesheet() . '//index');
        }
      } elseif (is_singular()) {
        $template_slug = get_page_template_slug();
        if ($template_slug) {
          $template = get_block_template(get_stylesheet() . '//' . str_replace('.html', '', $template_slug));
        } else {
          $post_type = get_post_type();
          $template = get_block_template(get_stylesheet() . '//single-' . $post_type);
          if (!$template) {
            $template = get_block_template(get_stylesheet() . '//singular');
          }
        }
      } elseif (is_archive()) {
        $template = get_block_template(get_stylesheet() . '//archive');
      }
      
      // Fallback to index template
      if (!$template) {
        $template = get_block_template(get_stylesheet() . '//index');
      }
      
      if ($template && !empty($template->content) && $this->parse_blocks_for_premium($template->content)) {
        $this->has_premium_blocks = true;
        return true;
      }
    }

    $this->has_premium_blocks = false;
    return false;
  }
  
  /**
   * Parse content to detect premium blocks
   *
   * @param string $content The content to parse.
   * @return bool True if premium blocks are found, false otherwise.
   */
  private function parse_blocks_for_premium($content) {
    if (empty($content)) {
      return false;
    }
      
    $blocks = parse_blocks($content);
    return $this->has_premium_block_recursive($blocks);
  }
  
  /**
   * Generic recursive block processor that handles reusable blocks and inner blocks.
	 * Executes a callback function on each block.
	 *
	 * @param array    $blocks   The blocks to traverse.
	 * @param callable $callback Function to execute on each block. Receives ($block) as parameter.
	 *                           Should return true to stop traversal (for search operations).
	 * @param mixed    $context  Optional context to pass to callback (e.g., block_name for searching).
	 *
	 * @return mixed Returns true if callback returns true (for early termination), otherwise void.
	 */
	private function process_blocks_recursive($blocks, $callback, $context = null)
	{
		foreach ($blocks as $block) {
			// Execute callback on current block
			$result = call_user_func($callback, $block, $context);
			
			// early return if callback indicates to stop traversal.
			if ($result === true) {
				return true;
			}

			// Handle reusable blocks/patterns (core/block)
			if ($block['blockName'] === 'core/block' && !empty($block['attrs']['ref'])) {
				$reusable_content = get_post_field('post_content', $block['attrs']['ref']);
				if (!empty($reusable_content)) {
					$reusable_blocks = parse_blocks($reusable_content);
					$result = $this->process_blocks_recursive($reusable_blocks, $callback, $context);
					if ($result === true) {
						return true;
					}
				}
			}

			// Handle template parts (core/template-part)
			if ($block['blockName'] === 'core/template-part') {
				$theme = $block['attrs']['theme'] ?? get_stylesheet();
				$slug = $block['attrs']['slug'] ?? '';
				
				if (!empty($slug)) {
					$template_part = get_block_template($theme . '//' . $slug, 'wp_template_part');
					
					if ($template_part && !empty($template_part->content)) {
						$template_blocks = parse_blocks($template_part->content);
						$result = $this->process_blocks_recursive($template_blocks, $callback, $context);
						if ($result === true) {
							return true;
						}
					}
				}
			}

			// Process inner blocks recursively
			if (!empty($block['innerBlocks'])) {
				$result = $this->process_blocks_recursive($block['innerBlocks'], $callback, $context);
				if ($result === true) {
					return true;
				}
			}
		}

		return false;
	}

	/**
   * Recursively check for premium blocks (handles nested blocks and reusable blocks)
   *
   * @param array $blocks The blocks to check.
   * @return bool True if premium blocks are found, false otherwise.
   */
  private function has_premium_block_recursive($blocks)
  {
    return $this->process_blocks_recursive($blocks, function($block) {
      // Check if block is a premium block
      if (!empty($block['blockName']) && $this->is_premium_block($block['blockName'])) {
        return true;
      }
      return false;
    });
  }
  
  /**
   * Check if a specific block exists in the blocks array.
   *
   * @param string $block_name The block name to search for.
   * @param array  $blocks     The blocks to search in.
   *
   * @return bool True if block is found, false otherwise.
   */
  private function pbg_has_block($block_name, $blocks)
  {
    return $this->process_blocks_recursive($blocks, function($block) use ($block_name) {
      if ($block['blockName'] === $block_name) {
        return true;
      }
      return false;
    });
  }

	/**
   * Inject the responsive CSS
   */
  public function inject_responsive_css() {
    // Prevent duplicate injection
    static $injected = false;

    if ($injected) {
      return;
    }

    $injected = true;
    
    $layout_settings = get_option('pbg_global_layout', array());
    $tablet_bp = $layout_settings['tablet_breakpoint'] ?? 1024;
    $mobile_bp = $layout_settings['mobile_breakpoint'] ?? 767;
    
    $custom_css = "
    @media (min-width: " . ($tablet_bp + 1) . "px) {
        .premium-desktop-hidden { display: none !important; }
    }
    @media (min-width: " . ($mobile_bp + 1) . "px) and (max-width: {$tablet_bp}px) {
        .premium-tablet-hidden { display: none !important; }
    }
    @media (max-width: {$mobile_bp}px) {
        .premium-mobile-hidden { display: none !important; }
    }
    ";

    // Minify CSS if the minify method is available.
		if ( isset( $this->blocks_frontend_assets ) && method_exists( $this->blocks_frontend_assets, 'minify_css' ) ) {
			$custom_css = $this->blocks_frontend_assets->minify_css( $custom_css );
		}

		?>
		<style id="pbg-global-responsive-option-css"><?php echo $custom_css; ?></style>
		<?php
  }

  /**
   * AJAX handler for filtering posts
   */
  public function ajax_filter_posts() {
    // Verify nonce for security
    if ( ! wp_verify_nonce( $_POST['nonce'], 'pbg_filter_posts' ) ) {
      wp_die( 'Security check failed' );
    }

    $attributes = json_decode( stripslashes( $_POST['attributes'] ), true );
    $filter_term = sanitize_text_field( $_POST['filter_term'] );
    $page = intval( $_POST['page'] ) ?: 1;

    if ( $filter_term && $filter_term !== '*' ) {
      $filter_taxonomy = $attributes['filterTaxonomy'] ?? '';
      $filter_query = array(
        'taxonomy' => $filter_taxonomy,
        'terms' => array( intval( $filter_term ) ),
      );

      $attributes['query']['filterQuery'] = $filter_query;
    } else {
      if ( isset( $attributes['query']['filterQuery'] ) ) {
        unset( $attributes['query']['filterQuery'] );
      }
    }

    // Get filtered query
    $query = self::get_query( $attributes, 'grid', $page );

    // Check if PBG_Post class exists (block might be deactivated)
    if ( ! class_exists( 'PBG_Post' ) ) {
      wp_send_json_error( array( 'message' => esc_html__( 'Post block is not available.', 'premium-blocks-for-gutenberg' ) ) );
      return;
    }

    // Generate HTML
    ob_start();
    PBG_Post::get_instance()->posts_articles_markup( $query, $attributes, 'grid' );
    $posts_html = ob_get_clean();
    $pagination_html = PBG_Post::get_instance()->render_pagination( $query, $attributes, $page );

    // Return response
    wp_send_json_success( array(
      'posts_html' => $posts_html,
      'pagination_html' => $pagination_html,
    ) );
  }

  /**
   * AJAX handler for filtering posts
   */
  public function ajax_paginate_posts() {
    // Verify nonce for security
    if ( ! wp_verify_nonce( $_POST['nonce'], 'pbg_paginate_posts' ) ) {
      wp_die( 'Security check failed' );
    }

    $attributes = json_decode( stripslashes( $_POST['attributes'] ), true );
    $page = intval( $_POST['page'] ) ?: 1;

    // Get filtered query
    $query = self::get_query( $attributes, 'grid', $page );

    // Check if PBG_Post class exists (block might be deactivated)
    if ( ! class_exists( 'PBG_Post' ) ) {
      wp_send_json_error( array( 'message' => esc_html__( 'Post block is not available.', 'premium-blocks-for-gutenberg' ) ) );
      return;
    }

    // Generate HTML
    ob_start();
    PBG_Post::get_instance()->posts_articles_markup( $query, $attributes, 'grid' );
    $posts_html = ob_get_clean();
    $pagination_html = PBG_Post::get_instance()->render_pagination( $query, $attributes, $page );

    // Return response
    wp_send_json_success( array(
      'posts_html' => $posts_html,
      'pagination_html' => $pagination_html,
    ) );
  }

	/**
	 * Update post meta
	 *
	 * @param int     $post_id Post ID.
	 * @param WP_Post $post Post object.
	 * @param bool    $update Whether this is an existing post being updated or not.
	 *
	 * @return void
	 */
	public function update_post_meta($post_id, $post, $update)
	{
		$new_version = time();
		update_post_meta($post_id, '_pbg_blocks_version', $new_version);
	}

	/**
	 * Get mailerlite groups
	 *
	 * @access public
	 * @return void
	 */
	public function premium_get_mailerlite_groups()
	{
		// Check if nonce is set.
		check_ajax_referer('pa-blog-block-nonce', 'nonce');

		// Check if api key is set.
		if (! isset($_POST['api_key'])) {
			wp_send_json_error(array('message' => esc_html__('API key is not set.', 'premium-blocks-for-gutenberg')));
		}

		// Get mailerlite groups.
		$mailerlite_groups = PBG_Blocks_Integrations::get_instance()->get_mailerlite_groups($_POST['api_key']);

		// Check if mailerlite groups is empty.
		if (empty($mailerlite_groups)) {
			wp_send_json_error(array('message' => esc_html__('No groups found.', 'premium-blocks-for-gutenberg')));
		}

		// Send mailerlite groups.
		wp_send_json_success(array('groups' => $mailerlite_groups));
	}

	/**
	 * Checks user credentials for specific action
	 *
	 * @since 2.6.8
	 *
	 * @param string $action action.
	 *
	 * @return boolean
	 */
	public static function check_user_can($action)
	{
		return current_user_can($action);
	}

	/**
	 * Get mailchimp lists
	 *
	 * @access public
	 * @return void
	 */
	public function premium_get_mailchimp_lists()
	{
		// Check if nonce is set.
		check_ajax_referer('pa-blog-block-nonce', 'nonce');

		// Check if api key is set.
		if (! isset($_POST['api_key'])) {
			wp_send_json_error(array('message' => esc_html__('API key is not set.', 'premium-blocks-for-gutenberg')));
		}

		// Get mailchimp lists.
		$mailchimp_lists = PBG_Blocks_Integrations::get_instance()->get_mailchimp_lists($_POST['api_key']);

		// Check if mailchimp lists is empty.
		if (empty($mailchimp_lists)) {
			wp_send_json_error(array('message' => esc_html__('No lists found.', 'premium-blocks-for-gutenberg')));
		}

		// Send mailchimp lists.
		wp_send_json_success(array('mailchimp_lists' => $mailchimp_lists));
	}

	/**
	 * Retrieves the merge fields for a Mailchimp list.
	 *
	 * @return void.
	 */
	public function pbg_editor_get_mailchimp_list_merge_fields()
	{
		// Check if nonce is set.
		check_ajax_referer('pa-blog-block-nonce', 'nonce');

		// Check if api key is set.
		if (! isset($_POST['api_key'])) {
			wp_send_json_error(array('message' => esc_html__('API key is not set.', 'premium-blocks-for-gutenberg')));
		}

		if (! isset($_POST['list_id'])) {
			wp_send_json_error(array('message' => esc_html__('List ID is not set.', 'premium-blocks-for-gutenberg')));
		}

		$list_merge_fields = PBG_Blocks_Integrations::get_instance()->get_mailchimp_list_merge_fields($_POST['api_key'], $_POST['list_id']);

		if (empty($list_merge_fields)) {
			wp_send_json_error(array('message' => esc_html__('No merge fields found.', 'premium-blocks-for-gutenberg')));
		}

		wp_send_json_success(array('list_merge_fields' => $list_merge_fields));
	}

	/**
	 * Premium Form Submit
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function premium_form_submit()
	{
		// Check if nonce is set.
		check_ajax_referer('pbg_form_nonce', 'nonce');
		// Check if form id is set.
		if (! isset($_POST['form_id'])) {
			wp_send_json_error(array('message' => esc_html__('Form id is not set.', 'premium-blocks-for-gutenberg')));
		}

		// reCAPTCHA settings.
		$recaptcha_settings      = json_decode(wp_unslash($_POST['recaptcha_settings']), true);
		$recaptcha_enabled       = isset($recaptcha_settings['enabled']) ? $recaptcha_settings['enabled'] : false;
		$recaptcha_version       = isset($recaptcha_settings['version']) ? $recaptcha_settings['version'] : '';
		$recaptcha_response      = isset($recaptcha_settings['response']) ? $recaptcha_settings['response'] : '';
		$recaptcha_v2_secret_key = $this->integrations_settings['premium-recaptcha-v2-secret'];
		$recaptcha_v3_secret_key = $this->integrations_settings['premium-recaptcha-v3-secret'];

		// Check if reCAPTCHA is enabled.
		if ($recaptcha_enabled) {
			// Check if reCAPTCHA version is v2.
			if ($recaptcha_version == 'v2') {
				// Check if reCAPTCHA response is empty.
				if (empty($recaptcha_response)) {
					wp_send_json_error(array('message' => esc_html__('Please verify reCAPTCHA.', 'premium-blocks-for-gutenberg')));
				}
				// Verify reCAPTCHA.
				$recaptcha_response = wp_remote_get(
					'https://www.google.com/recaptcha/api/siteverify',
					array(
						'body' => array(
							'secret'   => $recaptcha_v2_secret_key,
							'response' => $recaptcha_response,
							'remoteip' => $_SERVER['REMOTE_ADDR'],
						),
					)
				);
				$recaptcha_response = json_decode(wp_remote_retrieve_body($recaptcha_response));
				// Check if reCAPTCHA response is success.
				if (! $recaptcha_response->success) {
					wp_send_json_error(array('message' => esc_html__('reCAPTCHA verification failed.', 'premium-blocks-for-gutenberg')));
				}
			}
			// Check if reCAPTCHA version is v3.
			if ($recaptcha_version == 'v3') {
				// Check if reCAPTCHA response is empty.
				if (empty($recaptcha_response)) {
					wp_send_json_error(array('message' => esc_html__('Please verify reCAPTCHA.', 'premium-blocks-for-gutenberg')));
				}
				// Verify reCAPTCHA.
				$recaptcha_response = wp_remote_get(
					'https://www.google.com/recaptcha/api/siteverify',
					array(
						'body' => array(
							'secret'   => $recaptcha_v3_secret_key,
							'response' => $recaptcha_response,
							'remoteip' => $_SERVER['REMOTE_ADDR'],
						),
					)
				);
				$recaptcha_response = json_decode(wp_remote_retrieve_body($recaptcha_response));
				// Check if reCAPTCHA response is success.
				if (! $recaptcha_response->success) {
					wp_send_json_error(array('message' => esc_html__('reCAPTCHA verification failed.', 'premium-blocks-for-gutenberg')));
				}
			}
		}
		// Get submit actions.
		$submit_actions = json_decode(wp_unslash($_POST['submit_actions']), true);
		foreach ($submit_actions as $action => $value) {
			if (! $value) {
				continue;
			}
			switch ($action) {
				case 'sendEmail':
					$email_response = $this->send_email();
					if (! $email_response['success']) {
						wp_send_json_error(array('message' => $email_response['message']));
					}
					break;
				case 'mailchimp':
					$mailchimp_response = $this->mailchimp_subscribe();
					if (! $mailchimp_response['success']) {
						wp_send_json_error(array('message' => $mailchimp_response['message']));
					}
					break;
				case 'mailerlite':
					$mailerlite_response = $this->mailerlite_subscribe();
					if (! $mailerlite_response['success']) {
						wp_send_json_error(array('message' => $mailerlite_response['message']));
					}
					break;
				case 'fluentcrm':
					$fluentcrm_response = $this->fluentcrm_subscribe();
					if (! $fluentcrm_response['success']) {
						wp_send_json_error(array('message' => $fluentcrm_response['message']));
					}
					break;
			}
		}

		// Test send success.
		wp_send_json_success(array('message' => esc_html__('Form submitted successfully.', 'premium-blocks-for-gutenberg')));
	}

	/**
	 * FluentCRM Subscribe
	 */
	function fluentcrm_subscribe()
	{
		// Check if fluentcrm plugin is active.
		if (! function_exists('FluentCrm')) {
			wp_send_json_error(array('message' => esc_html__('FluentCRM plugin is not active.', 'premium-blocks-for-gutenberg')));
		}

		// Check if fluentcrm settings is set.
		if (! isset($_POST['fluentcrm_settings'])) {
			wp_send_json_error(array('message' => esc_html__('FluentCRM settings is not set.', 'premium-blocks-for-gutenberg')));
		}

		// FluentCRM settings.
		$fluentcrm_settings = json_decode(wp_unslash($_POST['fluentcrm_settings']), true);
		$email              = $fluentcrm_settings['email'] ?? '';
		$first_name         = $fluentcrm_settings['firstName'] ?? '';
		$last_name          = $fluentcrm_settings['lastName'] ?? '';
		$lists              = $fluentcrm_settings['lists'] ?? '';
		$tags               = $fluentcrm_settings['tags'] ?? '';

		// Check if email is empty.
		if (empty($email)) {
			wp_send_json_error(array('message' => esc_html__('Email is required.', 'premium-blocks-for-gutenberg')));
		}

		$contact_data = array(
			'email'      => $email,
			'first_name' => $first_name,
			'last_name'  => $last_name,
			'lists'      => $lists,
		);

		if (! empty($tags)) {
			$contact_data['tags'] = $tags;
		}

		$result = FluentCrmApi('contacts')->createOrUpdate($contact_data);

		if ($result['id']) {
			return array(
				'success' => true,
				'message' => esc_html__('FluentCRM subscribed successfully.', 'premium-blocks-for-gutenberg'),
			);
		}

		return array(
			'success' => false,
			'message' => esc_html__('FluentCRM subscription failed.', 'premium-blocks-for-gutenberg'),
		);
	}

	public function init_admin_features()
	{
		if (self::check_user_can('install_plugins')) {
			Feedback::get_instance();
		}
	}
	/**
	 * Mailerlite Subscribe
	 */
	function mailerlite_subscribe()
	{
		// Check if mailerlite settings is set.
		if (! isset($_POST['mailerlite_settings'])) {
			wp_send_json_error(array('message' => esc_html__('Mailerlite settings is not set.', 'premium-blocks-for-gutenberg')));
		}

		// Mailerlite settings.
		$mailerlite_settings = json_decode(wp_unslash($_POST['mailerlite_settings']), true);
		$api_token           = $this->integrations_settings['premium-mailerlite-api-token'] ?? '';
		$api_token_type      = $mailerlite_settings['apiToken'] ?? '';
		$group_id            = $mailerlite_settings['groupId'] ?? '';
		$email               = $mailerlite_settings['email'] ?? '';
		$name                = $mailerlite_settings['name'] ?? '';

		if ('custom' === $api_token_type) {
			$api_token = $mailerlite_settings['apiToken'] ?? '';
		}

		// Check if API token is empty.
		if (empty($api_token)) {
			wp_send_json_error(array('message' => esc_html__('Mailerlite API token is empty.', 'premium-blocks-for-gutenberg')));
		}

		// Check if email is empty.
		if (empty($email)) {
			wp_send_json_error(array('message' => esc_html__('Email is empty.', 'premium-blocks-for-gutenberg')));
		}

		$response = PBG_Blocks_Integrations::get_instance()->add_mailerlite_subscriber($api_token, $email, $name, $group_id);

		return $response;
	}

	/**
	 * Mailchimp Subscribe
	 */
	function mailchimp_subscribe()
	{
		// Check if mailchimp settings is set.
		if (! isset($_POST['mailchimp_settings'])) {
			wp_send_json_error(array('message' => esc_html__('Mailchimp settings is not set.', 'premium-blocks-for-gutenberg')));
		}

		// Mailchimp settings.
		$mailchimp_settings = json_decode(wp_unslash($_POST['mailchimp_settings']), true);
		$api_key            = $this->integrations_settings['premium-mailchimp-api-key'] ?? '';
		$api_key_type       = $mailchimp_settings['apiKeyType'] ?? '';
		$list_id            = $mailchimp_settings['listId'] ?? '';
		$mapped_fields      = $mailchimp_settings['mappedFields'] ?? array();
		$email              = $mailchimp_settings['email'] ?? '';

		if ('custom' === $api_key_type) {
			$api_key = $mailchimp_settings['apiKey'] ?? '';
		}

		// Check if API key is empty.
		if (empty($api_key)) {
			wp_send_json_error(array('message' => esc_html__('Mailchimp API key is empty.', 'premium-blocks-for-gutenberg')));
		}

		// Check if list ID is empty.
		if (empty($list_id)) {
			wp_send_json_error(array('message' => esc_html__('Mailchimp list ID is empty.', 'premium-blocks-for-gutenberg')));
		}

		// Check if email is empty.
		if (empty($email)) {
			wp_send_json_error(array('message' => esc_html__('Email is empty.', 'premium-blocks-for-gutenberg')));
		}

		// Mailchimp API URL.
		$response = PBG_Blocks_Integrations::get_instance()->add_mailchimp_subscriber($mailchimp_settings, $api_key, $list_id, $mapped_fields, $email);

		return $response;
	}

	/**
	 * Sent Email
	 */
	function send_email()
	{
		// Check if form data is set.
		if (! isset($_POST['form_data'])) {
			wp_send_json_error(array('message' => esc_html__('Form data is not set.', 'premium-blocks-for-gutenberg')));
		}

		// Check if email settings is set.
		if (! isset($_POST['email_settings'])) {
			wp_send_json_error(array('message' => esc_html__('Email settings is not set.', 'premium-blocks-for-gutenberg')));
		}

		// Email settings.
		$email_settings = json_decode(wp_unslash($_POST['email_settings']), true);
		$to_email       = isset($email_settings['to']) ? $email_settings['to'] : '';
		$subject        = isset($email_settings['subject']) ? $email_settings['subject'] : '';
		$reply_to       = isset($email_settings['replyTo']) ? $email_settings['replyTo'] : '';
		$cc             = isset($email_settings['cc']) ? $email_settings['cc'] : '';
		$bcc            = isset($email_settings['bcc']) ? $email_settings['bcc'] : '';
		$from_name      = isset($email_settings['fromName']) ? $email_settings['fromName'] : '';

		// Get form data.
		$form_data = json_decode(wp_unslash($_POST['form_data']), true);

		// Mail body.
		$mail_body = '<div style="width: 100%;"><table style="width: 100%; border: 1px solid #ddd; border-collapse: collapse;"><tbody>';
		// Map form data.
		foreach ($form_data as $key => $value) {
			// Check if value is array.
			if (is_array($value)) {
				$value = implode(', ', $value);
			}
			$mail_body .= '<tr><td style="border: 1px solid #ddd; padding: 10px;">' . esc_html($key) . '</td><td style="border: 1px solid #ddd; padding: 10px;">' . esc_html($value) . '</td></tr>';
		}
		$mail_body .= '</tbody></table></div>';

		// Headers.
		$headers = array(
			'Content-Type: text/html; charset=UTF-8',
		);

		// Check if from name is set.
		if (! empty($from_name)) {
			$headers[] = 'From: ' . $from_name . ' <' . get_option('admin_email') . '>';
		}

		// Check if reply to is set.
		if (! empty($reply_to)) {
			$headers[] = 'Reply-To: ' . get_bloginfo('name') . ' <' . $reply_to . '>';
		}

		// Check if cc is set.
		if (! empty($cc)) {
			$headers[] = 'Cc: ' . $cc;
		}

		// Check if bcc is set.
		if (! empty($bcc)) {
			$headers[] = 'Bcc: ' . $bcc;
		}

		// Send mail.
		$mail = wp_mail($to_email, $subject, $mail_body, $headers);

		// Check if mail is sent.
		if ($mail) {
			return array(
				'success' => true,
				'message' => esc_html__('Email sent successfully.', 'premium-blocks-for-gutenberg'),
			);
		} else {
			return array(
				'success' => false,
				'message' => esc_html__('Email sending failed.', 'premium-blocks-for-gutenberg'),
			);
		}
	}


	/**
	 * Get Form Inner Blocks
	 *
	 * Get all inner blocks of form block.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array
	 */
	public function get_form_inner_blocks($inner_blocks)
	{
		$form_fields_blocks = array(
			'premium/form-checkbox',
			'premium/form-email',
			'premium/form-name',
			'premium/form-toggle',
			'premium/form-radio',
			'premium/form-accept',
			'premium/form-phone',
			'premium/form-date',
			'premium/form-textarea',
			'premium/form-select',
			'premium/form-url',
			'premium/form-hidden',
		);

		$form_blocks = array();
		
		$this->process_blocks_recursive($inner_blocks, function($block) use ($form_fields_blocks, &$form_blocks) {
			// Check if block is form field block
			if (in_array($block['blockName'], $form_fields_blocks, true)) {
				$form_blocks[$block['attrs']['blockId']] = array(
					'blockName' => $block['blockName'],
					'attrs'     => $this->get_block_attributes($block),
				);
			}
		});

		return $form_blocks;
	}

	/**
	 * Add block style in template parts.
	 *
	 * @since 2.0.14
	 *
	 * @param string $content Block content.
	 * @param array  $block Block attributes.
	 *
	 * @return string
	 */
	public function add_block_style_in_template_parts($content, $block)
	{
		$this->add_blocks_assets(array($block));
		return $content;
	}

	/**
	 * Get Premium Blocks Names
	 *
	 * @return array
	 */
	public function get_premium_blocks_names()
	{
		$blocks_array = array(
			'premium/accordion'             => array(
				'name'       => 'accordion',
				'style_func' => 'get_premium_accordion_css_style',
			),
			'premium/accordion-item'        => array(
				'name'       => 'accordion-item',
				'style_func' => null,
			),
			'premium/banner'                => array(
				'name'       => 'banner',
				'style_func' => 'get_premium_banner_css_style',
        'media_style_func' => 'get_premium_banner_media_css',
			),
			'premium/bullet-list'           => array(
				'name'       => 'bullet-list',
				'style_func' => 'get_premium_bullet_list_css_style',
			),
			'premium/list-item'             => array(
				'name'       => 'list-item',
				'style_func' => 'get_premium_bullet_list_item_css_style',
			),
			'premium/countup'               => array(
				'name'       => 'count-up',
				'style_func' => 'get_premium_count_up_css_style',
			),
			'premium/counter'               => array(
				'name'       => 'counter',
				'style_func' => 'get_premium_counter_css',
			),
			'premium/dheading-block'        => array(
				'name'       => 'dual-heading',
				'style_func' => 'get_premium_dual_heading_css_style',
			),
			'premium/heading'               => array(
				'name'       => 'heading',
				'style_func' => 'get_premium_heading_css_style',
			),
			'premium/icon'                  => array(
				'name'       => 'icon',
				'style_func' => 'get_premium_icon_css_style',
			),
			'premium/icon-box'              => array(
				'name'       => 'icon-box',
				'style_func' => 'get_premium_icon_box_css_style',
			),
			'premium/maps'                  => array(
				'name'       => 'maps',
				'style_func' => 'get_premium_maps_css_style',
			),
			'premium/pricing-table'         => array(
				'name'       => 'pricing-table',
				'style_func' => 'get_premium_pricing_table_css_style',
			),
			'premium/section'               => array(
				'name'       => 'section',
				'style_func' => 'get_premium_section_css_style',
			),
			'premium/testimonial'           => array(
				'name'       => 'testimonials',
				'style_func' => 'get_premium_testimonials_css_style',
			),
			'premium/video-box'             => array(
				'name'       => 'video-box',
				'style_func' => 'get_premium_video_box_css_style',
			),
			'premium/fancy-text'            => array(
				'name'       => 'fancy-text',
				'style_func' => 'get_premium_fancy_text_css_style',
			),
			'premium/lottie'                => array(
				'name'       => 'lottie',
				'style_func' => 'get_premium_lottie_css_style',
			),
			'premium/modal'                 => array(
				'name'       => 'Modal',
				'style_func' => 'get_premium_modal_css_style',
        'media_style_func' => 'get_premium_modal_media_css',
			),
			'premium/image-separator'       => array(
				'name'       => 'image-separator',
				'style_func' => 'get_premium_image_separator_css_style',
			),
			'premium/person'                => array(
				'name'       => 'person',
				'style_func' => 'get_premium_person_css_style',
			),
			'premium/container'             => array(
				'name'       => 'container',
				'style_func' => 'get_premium_container_css_style',
			),
			'premium/content-switcher'      => array(
				'name'       => 'content-switcher',
				'style_func' => 'get_content_switcher_css_style',
			),
			'premium/buttons'               => array(
				'name'       => 'buttons',
				'style_func' => 'get_premium_button_group_css_style',
			),

			'premium/badge'                 => array(
				'name'       => 'badge',
				'style_func' => 'get_premium_badge_css',
			),
			'premium/button'                => array(
				'name'       => 'button',
				'style_func' => 'get_premium_button_css_style',
			),
			'premium/icon-group'            => array(
				'name'       => 'icon-group',
				'style_func' => 'get_premium_icon_group_css',
			),
			'premium/image'                 => array(
				'name'       => 'image',
				'style_func' => 'get_premium_image_css',
			),
			'premium/price'                 => array(
				'name'       => 'price',
				'style_func' => 'get_premium_price_css',
			),
			'premium/switcher-child'        => array(
				'name'       => 'switcher-child',
				'style_func' => 'get_premium_switcher_child_css',
			),
			'premium/text'                  => array(
				'name'       => 'text',
				'style_func' => 'get_premium_text_css',
			),
			'premium/instagram-feed'        => array(
				'name'       => 'instagram-feed',
				'style_func' => null,
			),
			'premium/instagram-feed-header' => array(
				'name'       => 'instagram-feed-header',
				'style_func' => 'get_premium_instagram_feed_header_css',
			),
			'premium/instagram-feed-posts'  => array(
				'name'       => 'instagram-feed-posts',
				'style_func' => 'get_premium_instagram_feed_posts_css',
			),
			'premium/post-carousel'         => array(
				'name'       => 'post-carousel',
				'style_func' => array('PBG_Post', 'get_premium_post_css_style'),
        'media_style_func' => array('PBG_Post', 'get_premium_post_media_css'),
			),
			'premium/post-grid'             => array(
				'name'       => 'post-grid',
				'style_func' => array('PBG_Post', 'get_premium_post_css_style'),
        'media_style_func' => array('PBG_Post', 'get_premium_post_media_css'),
			),
		
			'premium/svg-draw'              => array(
				'name'       => 'svg-draw',
				'style_func' => 'get_premium_svg_draw_css_style',
			),
			'premium/form'                  => array(
				'name'       => 'form',
				'style_func' => 'get_premium_form_css_style',
			),
			'premium/form-checkbox'         => array(
				'name'       => 'form-checkbox',
				'style_func' => null,
			),
			'premium/form-email'            => array(
				'name'       => 'form-email',
				'style_func' => null,
			),
			'premium/form-name'             => array(
				'name'       => 'form-name',
				'style_func' => null,
			),
			'premium/form-toggle'           => array(
				'name'       => 'form-toggle',
				'style_func' => null,
			),
			'premium/form-radio'            => array(
				'name'       => 'form-radio',
				'style_func' => null,
			),
			'premium/form-accept'           => array(
				'name'       => 'form-accept',
				'style_func' => null,
			),
			'premium/form-phone'            => array(
				'name'       => 'form-phone',
				'style_func' => null,
			),
			'premium/form-date'             => array(
				'name'       => 'form-date',
				'style_func' => null,
			),
			'premium/form-textarea'         => array(
				'name'       => 'form-textarea',
				'style_func' => null,
			),
			'premium/form-select'           => array(
				'name'       => 'form-select',
				'style_func' => null,
			),
			'premium/form-url'              => array(
				'name'       => 'form-url',
				'style_func' => null,
			),
			'premium/form-hidden'           => array(
				'name'       => 'form-hidden',
				'style_func' => null,
			),
			'premium/gallery'           => array(
				'name'       => 'gallery',
				'style_func' => null,
			),
			'premium/tabs'           => array(
				'name'       => 'tabs',
				'style_func' => 'get_premium_tabs_css_style',
        'media_style_func' => 'get_premium_tabs_media_css',
			),
			'premium/tab-item'           => array(
				'name'       => 'tab-item',
				'style_func' => '',
			),
			'premium/off-canvas'        => array(
				'name'       => 'off-canvas',
				'style_func' => 'get_premium_off_canvas_css',
			),
      'premium/one-page-scroll'        => array(
				'name'       => 'one-page-scroll',
				'style_func' => 'get_premium_one_page_scroll_css',
        'media_style_func' => 'get_premium_one_page_scroll_media_css',
			),
			'premium/one-page-scroll-item'   => array(
				'name'       => 'one-page-scroll-item',
				'style_func' => 'get_premium_one_page_scroll_item_css',
			),
			'premium/star-ratings'        => array(
				'name'       => 'star-ratings',
				'style_func' => 'get_premium_star_ratings_css',
			),
			'premium/templates'        => array(
				'name'       => 'templates',
				'style_func' => '',
			),
		);

		return $blocks_array;
	}

	/**
	 * Mobile breakpoint
	 *
	 * @param  string $breakpoint
	 * @return string
	 */
	public function mobile_breakpoint($breakpoint)
	{
		$layout_settings = get_option('pbg_global_layout', array());
		$breakpoint      = isset($layout_settings['mobile_breakpoint']) ? '(max-width: ' . $layout_settings['mobile_breakpoint'] . 'px)' : $breakpoint;

		return $breakpoint;
	}

	/**
	 * Tablet breakpoint
	 *
	 * @param  string $breakpoint
	 * @return string
	 */
	public function tablet_breakpoint($breakpoint)
	{
		$layout_settings = get_option('pbg_global_layout', array());
		$breakpoint      = isset($layout_settings['tablet_breakpoint']) ? '(max-width: ' . $layout_settings['tablet_breakpoint'] . 'px)' : $breakpoint;
		return $breakpoint;
	}

	/**
	 * Desktop breakpoint
	 *
	 * @param  string $breakpoint
	 * @return string
	 */
	public function desktop_breakpoint($breakpoint)
	{
		$layout_settings = get_option('pbg_global_layout', array());
		$breakpoint      = isset($layout_settings['tablet_breakpoint']) ? '(min-width: ' . ($layout_settings['tablet_breakpoint'] + 1) . 'px)' : $breakpoint;
		return $breakpoint;
	}

	/**
	 * Generate assets files feature.
	 *
	 * @return bool
	 */
	public function generate_assets_files()

	{

		if ($this->preview ||  $this->is_post_revision) {
			$this->file_generation              = false;
		} else {

			$this->file_generation =  isset(self::$config['generate-assets-files']) ? self::$config['generate-assets-files'] : true;
		}
		return $this->file_generation;
	}


	public function regenerate_assets_files()
	{
		$global_settings = apply_filters('pb_settings', get_option('pbg_blocks_settings', array()));
		
		// Only force regeneration if user clicked "Regenerate Assets" button
		// Otherwise, get_css_url() handles everything with smart hash comparison
		return isset($global_settings['premium-regenrate-assets']) && $global_settings['premium-regenrate-assets'];
	}

	/**
	 * Add block css file to the frontend assets.
	 * 
	 * @param string $src The css file url.
	 */
	public function add_block_css($src, $dependencies = array())
	{
		$this->blocks_frontend_assets->pbg_add_css($src);
		if (! empty($dependencies)) {
			$this->blocks_frontend_css_deps = array_merge($this->blocks_frontend_css_deps, $dependencies);
		}
	}

	/**
	 * Add inline css to the frontend assets.
	 */
	public function add_blocks_frontend_inline_styles()
	{

		if ($this->generate_assets_files()) {
			return;
		}

		$this->add_blocks_assets();
		$this->blocks_frontend_assets->add_inline_css($this->get_custom_block_css());
		$inline_css = $this->blocks_frontend_assets->get_inline_css();
		if (! empty($inline_css)) {
			echo '<style id="pbg-blocks-frontend-inline-css">' . $inline_css . '</style>';
		}
	}

	/**
	 * Add css.
	 *
	 * @param array $blocks The blocks array.
	 *
	 * @return void
	 */
	public function add_css($blocks)
	{
		// Add block css file to the frontend assets.
		$blocks_names = $this->get_premium_blocks_names();
		foreach ($blocks_names as $name => $block) {
			$slug = $block['name'];
			if (! $this->pbg_has_block($name, $blocks)) {
				continue;
			}

			if (! file_exists(PREMIUM_BLOCKS_PATH . "assets/css/minified/{$slug}.min.css")) {
        if ($slug === 'post-grid' || $slug=== 'post-carousel') {
			    $this->add_block_css("assets/css/minified/post.min.css");
        }else{
			    continue;
		    }
			}

      if ($slug !== 'post-grid' && $slug !== 'post-carousel') {
			  $this->add_block_css("assets/css/minified/{$slug}.min.css");
      }
		}
	}

	/**
	 * Register blocks animation.
	 *
	 * @param array $blocks.
	 *
	 * @return void
	 */
	private function register_animation_blocks($blocks)
	{
		$this->process_blocks_recursive($blocks, function($block) {
			$this->register_block_data($block);
		});
	}

	/**
	 * Enqueue frontend assets.
	 */
	public function add_blocks_frontend_assets()
	{
		if (! $this->generate_assets_files()) {
			return;
		}
		$this->add_blocks_assets();
		$this->blocks_frontend_assets->set_post_id(get_the_ID());
		$this->blocks_frontend_assets->add_inline_css($this->get_custom_block_css());
		
		// Check if assets need to be regenerated (user clicked button or smart detection)
		if ($this->regenerate_assets_files()) {
			// Force regeneration (either by user request or smart detection)
			$css_url = $this->blocks_frontend_assets->force_rewrite_css_file();
			
			// Reset the regeneration flag if it was set by user clicking "Regenerate Assets" button
			$global_settings = apply_filters('pb_settings', get_option('pbg_blocks_settings', array()));
			if (isset($global_settings['premium-regenrate-assets']) && $global_settings['premium-regenrate-assets']) {
				// Reset the flag after regeneration so it doesn't run on every page load
				static $flag_reset = false;
				if (!$flag_reset) {
					$global_settings['premium-regenrate-assets'] = false;
					update_option('pbg_blocks_settings', $global_settings);
					$flag_reset = true;
				}
			}
		} else {
			// Normal operation - use smart hash-based regeneration
			$css_url = $this->blocks_frontend_assets->get_css_url();
		}
		
		if (! empty($css_url)) {
			$version = get_post_meta(get_the_ID(), '_premium_css_version', true);

			if (! $version) {
				$version = PREMIUM_BLOCKS_VERSION;
			}

			wp_enqueue_style('pbg-blocks-frontend-assets', $css_url, array_values($this->blocks_frontend_css_deps), $version);
		}
	}

	/**
	 * Add blocks assets.
	 *
	 * @param array $blocks The blocks array.
	 *
	 * @return void
	 */
	public function add_blocks_assets($blocks = array())
	{
		if (empty($blocks)) {
			$post_id = get_the_ID();
			$post_content = get_post_field('post_content', $post_id);
			$blocks = parse_blocks($post_content);

			// Include Widget Blocks for CSS generation (only active sidebars)
			$widget_blocks = $this->get_widget_blocks();
			if (!empty($widget_blocks)) {
				$blocks = array_merge($blocks, $widget_blocks);
			}
		}
		$this->add_css($blocks);
		$this->add_blocks_dynamic_css($blocks);
		$this->register_animation_blocks($blocks);
		$this->enqueue_features_script();
	}

	/**
	 * Get blocks from active widgets.
	 * 
	 * Only processes widgets that are assigned to active sidebars,
	 * excluding inactive widgets to improve performance.
	 *
	 * @return array Array of parsed blocks from active widgets.
	 */
	private function get_widget_blocks()
	{
		$active_blocks = array();
		$sidebars_widgets = get_option('sidebars_widgets');
		$widget_block_instances = get_option('widget_block');

		if (!is_array($sidebars_widgets) || !is_array($widget_block_instances)) {
			return $active_blocks;
		}

		foreach ($sidebars_widgets as $sidebar => $widgets) {
			// Skip inactive widgets, empty sidebars, and array_version key
			if ($sidebar === 'wp_inactive_widgets' || $sidebar === 'array_version' || empty($widgets) || !is_array($widgets)) {
				continue;
			}
			
			foreach ($widgets as $widget_id) {
				// Check if this is a block widget
				if (strpos($widget_id, 'block-') === 0) {
					$id = str_replace('block-', '', $widget_id);
					if (isset($widget_block_instances[$id]['content'])) {
						$parsed = parse_blocks($widget_block_instances[$id]['content']);
						if (!empty($parsed)) {
							$active_blocks = array_merge($active_blocks, $parsed);
						}
					}
				}
			}
		}
		
		return $active_blocks;
	}

	/**
	 * Get block unique id.
	 *
	 * @param  string $block_name The block name.
	 * @param  array  $attributes The block attributes.
	 * @return string
	 */
	public function get_block_unique_id($block_name, $attributes)
	{
		$unique_id    = '';
		$blocks_names = $this->get_premium_blocks_names();
		$block_data   = $blocks_names[$block_name] ?? array();
		switch ($block_name) {
			case 'premium/banner':
			case 'premium/countup':
			case 'premium/lottie':
			case 'premium/pricing-table':
			case 'premium/testimonial':
				$unique_name = explode('/', $block_data['name']);
				$unique_name = end($unique_name);
				if (isset($attributes['block_id']) && ! empty($attributes['block_id'])) {
					$unique_id = "#premium-{$unique_name}-{$attributes['block_id']}";
				}
				if (isset($attributes['blockId']) && ! empty($attributes['blockId'])) {
					$unique_id = ".{$attributes['blockId']}";
				}
				break;
			case 'premium/buttons':
			case 'premium/maps':
				if (isset($attributes['blockId']) && ! empty($attributes['blockId'])) {
					$unique_id = ".{$attributes['blockId']}";
				}
				break;
			case 'premium/container':
				if (isset($attributes['block_id']) && ! empty($attributes['block_id'])) {
					$unique_id = $attributes['block_id'];
				}
				break;
			case 'premium/dheading-block':
				if (isset($attributes['block_id']) && ! empty($attributes['block_id'])) {
					$unique_id = "#premium-dheading-block-{$attributes['block_id']}";
				}

				if (isset($attributes['blockId']) && ! empty($attributes['blockId'])) {
					$unique_id = ".{$attributes['blockId']}";
				}
				break;
			case 'premium/heading':
				if (isset($attributes['block_id']) && ! empty($attributes['block_id'])) {
					$unique_id = "#premium-title-{$attributes['block_id']}";
				}

				if (isset($attributes['blockId']) && ! empty($attributes['blockId'])) {
					$unique_id = ".{$attributes['blockId']}";
				}
				break;
			case 'premium/section':
				if (isset($attributes['block_id']) && ! empty($attributes['block_id'])) {
					$unique_id = '.premium-container';
				}

				if (isset($attributes['blockId']) && ! empty($attributes['blockId'])) {
					$unique_id = ".{$attributes['blockId']}";
				}
				break;
			case 'premium/tabs':
				if (isset($attributes['blockId']) && ! empty($attributes['blockId'])) {

					$unique_id = ".{$attributes['blockId']}";
				}
				break;
			default:
				$unique_id = (! empty($attributes['blockId'])) ? $attributes['blockId'] : '';
				break;
		}
		return $unique_id;
	}

	/**
	 * Get extra options css.
	 *
	 * @param string $block_id The block id.
	 * @param string $block_name The block name.
	 * @param array  $attrs The block attributes.
	 *
	 * @return array
	 */
	public function get_extra_options_css($block_id, $block_name, $attrs)
	{
		$css = new Premium_Blocks_css();
		if ('.' === substr($block_id, 0, 1)) {
			$block_id = substr($block_id, 1);
		}

		if ('premium/container' === $block_name) {
			$block_id = 'premium-container-' . $block_id;
		}

		if (in_array($block_name, $this->support_links_blocks, true)) {
			$link_settings = $attrs['pbgLinkSettings'] ?? array();
			if (isset($link_settings['enable']) && ! empty($link_settings['enable'])) {
				$css->set_selector(".{$block_id}");
				$css->add_property('cursor', 'pointer');
			}
		}

    $pbg_width_type = $css->pbg_get_value($attrs, 'pbgWidthType', 'Desktop');
    $pbg_position = $css->pbg_get_value($attrs, 'pbgPosition', 'Desktop');
    $pbg_horizontal_orientation = $css->pbg_get_value($attrs, 'pbgHorizontalOrientation', 'Desktop');
    $pbg_vertical_orientation = $css->pbg_get_value($attrs, 'pbgVerticalOrientation', 'Desktop');

    $pbg_width_migrated = $css->pbg_get_value($attrs, 'pbgWidthMigrated');
    
    /**
     * Only use custom width if explicitly set to "custom" or if it's an old block (no migration flag) and has custom width (backward compatibility).
    */
    $pbg_custom_width = $css->pbg_get_value($attrs, 'pbgWidth', 'Desktop');
    $should_use_custom_width = ($pbg_width_type === 'custom') || (!$pbg_width_migrated && empty($pbg_width_type) && !empty($pbg_custom_width));

		$css->set_selector(".{$block_id}");
		$css->pbg_render_spacing($attrs, 'blockPadding', 'padding', 'Desktop', null, '!important');
    if( in_array( $pbg_width_type, array('100%','auto') ) ){
      $css->pbg_render_value($attrs, 'pbgWidthType', 'width', 'Desktop', null, '!important');
    }
    if( $should_use_custom_width ){
      $css->pbg_render_range($attrs, 'pbgWidth', 'width', 'Desktop', null, '!important');
      $align = $css->pbg_get_value($attrs, 'align', 'Desktop');
      if ( $align === 'center' ) {
          $css->add_property('margin-left', 'auto !important');
          $css->add_property('margin-right', 'auto !important');
      } elseif ( $align === 'right' ) {
          $css->add_property('margin-left', 'auto !important');
          $css->add_property('margin-right', '0 !important');
      } elseif ( $align === 'left' ) {
          $css->add_property('margin-left', '0 !important');
          $css->add_property('margin-right', 'auto !important');
      }
    }
    $css->pbg_render_value($attrs, 'pbgPosition', 'position', 'Desktop', null, '!important');
    if( $pbg_position === 'absolute' || $pbg_position === 'fixed' ){
      $css->pbg_render_range($attrs, 'pbgHorizontalOffset', $pbg_horizontal_orientation, 'Desktop', null, '!important');
      $css->pbg_render_range($attrs, 'pbgVerticalOffset', $pbg_vertical_orientation, 'Desktop', null, '!important');
    }
		$css->pbg_render_value($attrs, 'pbgzIndex', 'z-index', null, null, '!important');

		$css->set_selector(":root:has(.{$block_id}) .{$block_id}");
		$css->pbg_render_spacing($attrs, 'blockMargin', 'margin', 'Desktop');

		// Tablet.
		$css->start_media_query('tablet');

    $pbg_width_type = $css->pbg_get_value($attrs, 'pbgWidthType', 'Tablet', true);
    $pbg_position = $css->pbg_get_value($attrs, 'pbgPosition', 'Tablet', true);
    $pbg_horizontal_orientation = $css->pbg_get_value($attrs, 'pbgHorizontalOrientation', 'Tablet', true);
    $pbg_vertical_orientation = $css->pbg_get_value($attrs, 'pbgVerticalOrientation', 'Tablet', true);

    // Backward compatibility: Only apply custom width for old blocks (before migration flag existed)
    $pbg_custom_width = $css->pbg_get_value($attrs, 'pbgWidth', 'Tablet');
    $should_use_custom_width = ($pbg_width_type === 'custom') || (!$pbg_width_migrated && empty($pbg_width_type) && !empty($pbg_custom_width));

		$css->set_selector(".{$block_id}");
		$css->pbg_render_spacing($attrs, 'blockPadding', 'padding', 'Tablet', null, '!important');
		if( in_array( $pbg_width_type, array('100%','auto') ) ){
      $css->pbg_render_value($attrs, 'pbgWidthType', 'width', 'Tablet', null, '!important');
    }
    if( $should_use_custom_width ){
      $css->pbg_render_range($attrs, 'pbgWidth', 'width', 'Tablet', null, '!important');
      $align = $css->pbg_get_value($attrs, 'align', 'Tablet', true);
      if ( $align === 'center' ) {
          $css->add_property('margin-left', 'auto !important');
          $css->add_property('margin-right', 'auto !important');
      } elseif ( $align === 'right' ) {
          $css->add_property('margin-left', 'auto !important');
          $css->add_property('margin-right', '0 !important');
      } elseif ( $align === 'left' ) {
          $css->add_property('margin-left', '0 !important');
          $css->add_property('margin-right', 'auto !important');
      }
    }
    $css->pbg_render_value($attrs, 'pbgPosition', 'position', 'Tablet', null, '!important');
    if( $pbg_position === 'absolute' || $pbg_position === 'fixed' ){
      if($pbg_horizontal_orientation === 'left'){
        $css->add_property('right', 'auto !important');
      }else{
        $css->add_property('left', 'auto !important');
      }

      if($pbg_vertical_orientation === 'top'){
        $css->add_property('bottom', 'auto !important');
      }else{
        $css->add_property('top', 'auto !important');
      }
      $css->pbg_render_range($attrs, 'pbgHorizontalOffset', $pbg_horizontal_orientation, 'Tablet', null, '!important', true);
      $css->pbg_render_range($attrs, 'pbgVerticalOffset', $pbg_vertical_orientation, 'Tablet', null, '!important', true);
    }

		$css->set_selector(":root:has(.{$block_id}) .{$block_id}");
		$css->pbg_render_spacing($attrs, 'blockMargin', 'margin', 'Tablet');

		$css->stop_media_query();

		// Mobile.
		$css->start_media_query('mobile');

    $pbg_width_type = $css->pbg_get_value($attrs, 'pbgWidthType', 'Mobile', true);
    $pbg_position = $css->pbg_get_value($attrs, 'pbgPosition', 'Mobile', true);
		$pbg_horizontal_orientation = $css->pbg_get_value($attrs, 'pbgHorizontalOrientation', 'Mobile', true);
    $pbg_vertical_orientation = $css->pbg_get_value($attrs, 'pbgVerticalOrientation', 'Mobile', true);

    // Backward compatibility: Only apply custom width for old blocks (before migration flag existed)
    $pbg_custom_width = $css->pbg_get_value($attrs, 'pbgWidth', 'Mobile');
    $should_use_custom_width = ($pbg_width_type === 'custom') || (!$pbg_width_migrated && empty($pbg_width_type) && !empty($pbg_custom_width));

		$css->set_selector(".{$block_id}");
		$css->pbg_render_spacing($attrs, 'blockPadding', 'padding', 'Mobile', null, '!important');
		if( in_array( $pbg_width_type, array('100%','auto') ) ){
      $css->pbg_render_value($attrs, 'pbgWidthType', 'width', 'Mobile', null, '!important');
    }
    if( $should_use_custom_width ){
      $css->pbg_render_range($attrs, 'pbgWidth', 'width', 'Mobile', null, '!important');
      $align = $css->pbg_get_value($attrs, 'align', 'Mobile', true);
      if ( $align === 'center' ) {
          $css->add_property('margin-left', 'auto !important');
          $css->add_property('margin-right', 'auto !important');
      } elseif ( $align === 'right' ) {
          $css->add_property('margin-left', 'auto !important');
          $css->add_property('margin-right', '0 !important');
      } elseif ( $align === 'left' ) {
          $css->add_property('margin-left', '0 !important');
          $css->add_property('margin-right', 'auto !important');
      }
    }
    $css->pbg_render_value($attrs, 'pbgPosition', 'position', 'Mobile', null, '!important');
    if( $pbg_position === 'absolute' || $pbg_position === 'fixed' ){
      if($pbg_horizontal_orientation === 'left'){
        $css->add_property('right', 'auto !important');
      }else{
        $css->add_property('left', 'auto !important');
      }

      if($pbg_vertical_orientation === 'top'){
        $css->add_property('bottom', 'auto !important');
      }else{
        $css->add_property('top', 'auto !important');
      }
      $css->pbg_render_range($attrs, 'pbgHorizontalOffset', $pbg_horizontal_orientation, 'Mobile', null, '!important', true);
      $css->pbg_render_range($attrs, 'pbgVerticalOffset', $pbg_vertical_orientation, 'Mobile', null, '!important', true);
    }

		$css->set_selector(":root:has(.{$block_id}) .{$block_id}");
		$css->pbg_render_spacing($attrs, 'blockMargin', 'margin', 'Mobile');

		$css->stop_media_query();
		return $css->css_output();
	}

	public function export_settings()
	{
		return self::$config;
	}
	/**
	 * Add block dynamic css.
	 *
	 * @param array  $block The block data.
	 * @param string $block_name The block name.
	 *
	 * @return void
	 */
	function add_block_dynamic_css($block, $block_name)
	{
		$unique_id = $this->get_block_unique_id($block_name, $block['attrs']);
		if (in_array($unique_id, $this->loaded_blocks)) {
			return;
		}
		$this->loaded_blocks[] = $unique_id;

		$blocks_names = $this->get_premium_blocks_names();
		if (! isset($blocks_names[$block_name])) {
			return;
		}
		$block_data = $blocks_names[$block_name];
		$style_func = $block_data['style_func'];
    $media_style_func = $block_data['media_style_func'] ?? null;

		$attr       = $this->get_block_attributes($block);
    
		if (! empty($style_func)) {
			$unique_id = $this->get_block_unique_id($block_name, $attr);
			if (is_array($style_func)) {
				$class = $style_func[0];
				// Check if class exists before trying to instantiate (block might be deactivated)
				if (! is_string($class) || ! class_exists($class)) {
					return;
				}
				$instance   = $class::get_instance();
				$style_func = array($instance, $style_func[1]);
			}

			if (! is_callable($style_func)) {
				return;
			}

			$css = call_user_func($style_func, $attr, $unique_id);

			if (apply_filters('Premium_BLocks_blocks_render_inline_css', true, $block_data['name'], $unique_id)) {
				if (! empty($css)) {
					$this->add_custom_block_css($css);
				}
			}
		}

    if( ! empty($media_style_func) ){
      // Handle class-based callbacks (e.g., array('PBG_Post', 'method'))
      if (is_array($media_style_func)) {
        $class = $media_style_func[0];
        // Check if class exists before trying to use it (block might be deactivated)
        if (! is_string($class) || ! class_exists($class)) {
          return;
        }
        $instance = $class::get_instance();
        $media_style_func = array($instance, $media_style_func[1]);
      }
      
      if( is_callable($media_style_func) ){
        $media_css = call_user_func( $media_style_func );
        if( ! empty( $media_css ) ){
          $this->add_custom_block_css( $media_css );
        }
      }
    }

		$extra_options_css = $this->get_extra_options_css($unique_id, $block_name, $attr);
		if (! empty($extra_options_css)) {
			$this->add_custom_block_css($extra_options_css);
		}
	}

	/**
	 * Add block dynamic css.
	 *
	 * @param array $blocks The blocks data.
	 *
	 * @return void
	 */
	public function add_blocks_dynamic_css($blocks)
	{
		$this->process_blocks_recursive($blocks ?? array(), function($block) {
			// Check if premium block by block name.
			$block_name = $block['blockName'];

			if ($this->is_premium_block($block_name)) {
				$this->add_block_dynamic_css($block, $block_name);
			}
		});
	}

	/**
	 * Add the clientId attribute to the block element.
	 *
	 * @param string $block_content The HTML content of the block.
	 * @param array  $block The block data.
	 *
	 * @return string The updated HTML content of the block.
	 */
	public function add_block_style($block_content, $block)
	{
		if ($this->is_premium_block($block['blockName'])) {
			// Find the style tag and its contents.
			preg_match('/<style(?:\s+(?:class|id)="[^"]*")*>(.*?)<\/style>/s', $block_content, $matches);

			// If a style tag was found, store its contents.
			if (! empty($matches)) {
				$style_content = $matches[1];
				$this->add_custom_block_css($style_content);
				// Remove all style tags and their contents from the block content.
				$block_content = preg_replace('/<style(?:\s+(?:class|id)="[^"]*")*>(.*?)<\/style>/s', '', $block_content);
			}
		}

		return $block_content;
	}

	/**
	 * Check if any value in an array is not empty.
	 *
	 * @param array $array An array of key-value pairs to check for non-empty values.
	 * @return bool Whether any of the values in the array are not empty.
	 */
	public function check_if_any_value_not_empty($array)
	{
		if (! is_array($array)) {
			return false;
		}
		foreach ($array as $key => $value) {
			if (! empty($value)) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Check if a block name is a premium block.
	 *
	 * @param string $block_name The name of the block to check.
	 *
	 * @return bool True if the block name starts with "premium/", false otherwise.
	 */
	public function is_premium_block($block_name)
	{
		if ($block_name !== null && strpos($block_name, 'premium/') !== false) {
			return true;
		} else {
			return false;
		}
	}


	/**
	 * Registers blocks with features.
	 *
	 * @param array $block         The block attributes.
	 *
	 * @return string $block_content The block content.
	 */
	public function register_block_data($block)
	{
		$attrs = $block['attrs'] ?? array();
		if ($this->is_premium_block($block['blockName'])) {
			$attrs = $this->get_block_attributes($block);
		}

		if (! $this->global_features['premium-entrance-animation-all-blocks'] && ! $this->is_premium_block($block['blockName'])) {
			return;
		}

    if ($this->global_features['premium-entrance-animation'] && isset($attrs['entranceAnimation']) && isset($attrs['entranceAnimation']['animation']) && $this->check_if_any_value_not_empty($attrs['entranceAnimation']['animation'])) {
			$this->entrance_animation_blocks[$attrs['entranceAnimation']['clientId']] = $attrs['entranceAnimation'];
		}

		if (in_array($block['blockName'], $this->support_links_blocks, true)) {
			$link_settings = $attrs['pbgLinkSettings'] ?? array();
			if (isset($link_settings['enable']) && $link_settings['enable']) {
				$link_id = $this->get_block_unique_id($block['blockName'], $attrs);
				if ('.' === substr($link_id, 0, 1)) {
					$link_id = substr($link_id, 1);
				}

				if ('premium/container' === $block['blockName']) {
					$link_id = 'premium-block-' . $link_id;
				}

				if ($link_id) {
					$this->extra_options_blocks[$link_id]['link'] = $link_settings;
				}
			}
		}
	}

	/**
	 * Get block attributes.
	 *
	 * @param array $block The block data
	 *
	 * @return array
	 */
	public function get_block_attributes($block)
	{
		$blocks_names = $this->get_premium_blocks_names();
		$block_data   = $blocks_names[$block['blockName']] ?? array();
		if (empty($block_data)) {
			return array();
		}
		// Get default attributes from block.json.
		$default_attrs = array();
		// Check if block.json file exists.
		$json_file = PREMIUM_BLOCKS_PATH . "blocks-config/{$block_data['name']}/block.json";
		if (file_exists($json_file)) {
			require_once ABSPATH . 'wp-admin/includes/file.php'; // We will probably need to load this file.
			global $wp_filesystem;
			WP_Filesystem(); // Initial WP file system.
			$default_attributes = $wp_filesystem->get_contents($json_file);
			$default_attributes = json_decode($default_attributes, true);
			$default_attributes = $default_attributes['attributes'];
			// Get default for each attribute.
			foreach ($default_attributes as $key => $value) {
				if (isset($value['default'])) {
					$default_attrs[$key] = $value['default'];
				}
			}
		}

    // Append pbg attributes to default attributes.
    foreach (self::$pbg_attributes as $key => $value) {
      if (isset($value['default'])) {
					$default_attrs[$key] = $value['default'];
      }
    }

		// Merge default attributes with block attributes.
		$attr = wp_parse_args($block['attrs'], $default_attrs);

		return $attr;
	}

	/**
	 * Enqueues features scripts.
	 */
	public function enqueue_features_script()
	{
		$media_query            = array();
		$media_query['mobile']  = apply_filters('Premium_BLocks_mobile_media_query', '(max-width: 767px)');
		$media_query['tablet']  = apply_filters('Premium_BLocks_tablet_media_query', '(max-width: 1024px)');
		$media_query['desktop'] = apply_filters('Premium_BLocks_desktop_media_query', '(min-width: 1025px)');

		if (! empty($this->entrance_animation_blocks)) {
			$this->entrance_animation_blocks['breakPoints'] = $media_query;
			wp_enqueue_script(
				'premium-entrance-animation-view',
				PREMIUM_BLOCKS_URL . 'assets/js/build/entrance-animation/frontend/index.js',
				array(),
				PREMIUM_BLOCKS_VERSION,
				true
			);

			wp_enqueue_style(
				'pbg-entrance-animation-css',
				PREMIUM_BLOCKS_URL . 'assets/js/build/entrance-animation/editor/index.css',
				array(),
				PREMIUM_BLOCKS_VERSION,
				'all'
			);
			wp_scripts()->add_data('premium-entrance-animation-view', 'after', array());

			wp_add_inline_script(
				'premium-entrance-animation-view',
				'var PBG_EntranceAnimation = ' . wp_json_encode($this->entrance_animation_blocks) . ';',
				'after'
			);
		}

		if (! empty($this->extra_options_blocks)) {

			wp_localize_script(
				'pbg-blocks-wrapper-link',
				'PBG_WrapperLink',
				apply_filters(
					'pbg_wrapper_link_localize_script',
					array(
						'blocks' => $this->extra_options_blocks,
					)
				)
			);
		}
	}


	/**
	 * Add blocks editor style
	 *
	 * @return void
	 */
	public function add_blocks_editor_styles()
	{
		$generate_css = new Pbg_Assets_Generator('editor');


		$generate_css->pbg_add_css('assets/js/build/entrance-animation/editor/index.css');
		$generate_css->pbg_add_css('assets/css/minified/blockseditor.min.css');
		$generate_css->pbg_add_css('assets/css/minified/editorpanel.min.css');
		$generate_css->pbg_add_css( 'assets/css/minified/template.min.css' );
		$is_rtl = is_rtl() ? true : false;
		$is_rtl ? $generate_css->pbg_add_css('assets/css/minified/style-blocks-rtl.min.css') : '';

		if (is_array(self::$blocks) && ! empty(self::$blocks)) {
			foreach (self::$blocks as $slug => $value) {

				if (false === $value) {
					continue;
				}

				if ('buttons' === $slug) {
					$this->blocks_frontend_assets->pbg_add_css('assets/css/minified/button.min.css');
				}

				if ('pricing-table' === $slug) {
					$generate_css->pbg_add_css('assets/css/minified/price.min.css');
					$generate_css->pbg_add_css('assets/css/minified/badge.min.css');
				}
				if ('pricing-table' === $slug || 'icon-box' === $slug || 'person' === $slug) {
					$generate_css->pbg_add_css('assets/css/minified/text.min.css');
				}
				if ('pricing-table' === $slug || 'icon-box' === $slug) {
					$generate_css->pbg_add_css('assets/css/minified/button.min.css');
				}
				if ('person' === $slug) {
					$generate_css->pbg_add_css('assets/css/minified/image.min.css');
					$generate_css->pbg_add_css('assets/css/minified/icon-group.min.css');
				}
				if ('content-switcher' === $slug) {
					$generate_css->pbg_add_css('assets/css/minified/switcher-child.min.css');
				}
				if ('count-up' === $slug) {
					$generate_css->pbg_add_css('assets/css/minified/counter.min.css');
				}


				if ('instagram-feed' === $slug) {
					$generate_css->pbg_add_css('assets/css/minified/instagram-feed-header.min.css');
					$generate_css->pbg_add_css('assets/css/minified/instagram-feed-posts.min.css');
				}
				if ('post-carousel' === $slug || 'post-grid' === $slug ) {
					$generate_css->pbg_add_css('assets/css/minified/post.min.css');
				} 
				if('post-carousel'=== $slug){
				$generate_css->pbg_add_css('assets/css/minified/splide.min.css');

				}
				elseif ('form' === $slug) {
					$generate_css->pbg_add_css('assets/css/minified/form-toggle.min.css');
					$generate_css->pbg_add_css('assets/css/minified/form-checkbox.min.css');
					$generate_css->pbg_add_css('assets/css/minified/form-radio.min.css');
					$generate_css->pbg_add_css('assets/css/minified/form-accept.min.css');
					$generate_css->pbg_add_css('assets/css/minified/form-phone.min.css');
					$generate_css->pbg_add_css('assets/css/minified/form-select.min.css');
				}

        
        if( $slug !== 'post-grid' && $slug !== 'post-carousel' ){
          $generate_css->pbg_add_css("assets/css/minified/{$slug}.min.css");
        }
			}
		}

		// Add dynamic css.
		$css_url = $generate_css->get_css_url();
		// Enqueue editor styles.
		if (false != $css_url) {
			wp_register_style('premium-blocks-editor-css', $css_url, array(), PREMIUM_BLOCKS_VERSION, 'all');
			wp_add_inline_style('premium-blocks-editor-css', apply_filters('pbg_dynamic_css', ''));
		}
	}

	/**
	 * Load Json Files
	 */
	public function pbg_mime_types($mimes)
	{
		$mimes['json'] = 'application/json';
		$mimes['svg']  = 'image/svg+xml';
		return $mimes;
	}
	//////////////////////////////////////////////////////////////////
	// Get WP fonts
	//////////////////////////////////////////////////////////////////

	public function premium_get_wp_local_fonts()
	{
		$fonts = [];
		$query = get_posts(
			array(
				'post_type'              => 'wp_font_face',
				'posts_per_page'         => 99,
				'update_post_meta_cache' => false,
				'update_post_term_cache' => false,
			)
		);
		if (!empty($query)) {
			foreach ($query as $font) {
				$font_content = json_decode($font->post_content, true);
				if ($font_content['fontFamily']) {
					$fonts[] = $font_content['fontFamily'];
				}
			}
		}
		return $fonts;
	}
	/**
	 * Load SvgShapes
	 *
	 * @since 1.0.0
	 */
	public function getSvgShapes()
	{
		$shape_path = PREMIUM_BLOCKS_PATH . 'assets/icons/shape';
		$shapes     = glob($shape_path . '/*.svg');
		$shapeArray = array();

		if (count($shapes)) {
			if (! defined('GLOB_BRACE')) {
				define('GLOB_BRACE', 1024);
			}

			foreach ($shapes as $shape) {
				$shapeArray[str_replace(array('.svg', $shape_path . '/'), '', $shape)] = file_get_contents($shape);
			}
		}

		return $shapeArray;
	}


	/**
	 * Fix File Of type JSON
	 */
	public function fix_mime_type_json($data = null, $file = null, $filename = null, $mimes = null)
	{
		$ext = isset($data['ext']) ? $data['ext'] : '';
		if (1 > strlen($ext)) {
			$exploded = explode('.', $filename);
			$ext      = strtolower(end($exploded));
		}
		if ('json' === $ext) {
			$data['type'] = 'application/json';
			$data['ext']  = 'json';
		}
		return $data;
	}
	
	/**
	 * Get authors
	 *
	 * Get posts author array
	 *
	 * @since 3.20.3
	 * @access public
	 *
	 * @return array
	 */
	public static function get_authors()
	{
		$users = get_users(array('role__in' => array('administrator', 'editor', 'author', 'contributor')));

		$options = array();

		if (! empty($users) && ! is_wp_error($users)) {
			foreach ($users as $user) {
				if ('wp_update_service' !== $user->display_name) {
					$options[$user->ID] = $user->display_name;
				}
			}
		}

		return $options;
	}


	/**
	 * Enqueue Editor CSS/JS for Premium Blocks
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function pbg_editor()
	{
		$allow_json           = isset(self::$config['premium-upload-json']) ? self::$config['premium-upload-json'] : true;
		$is_fa_enabled        = isset(self::$config['premium-fa-css']) ? self::$config['premium-fa-css'] : true;
		$mailchimp_api_key    = $this->integrations_settings['premium-mailchimp-api-key'];
		$mailerlite_api_token = $this->integrations_settings['premium-mailerlite-api-token'];

		$settings_data = array(
			'ajaxurl'           => esc_url(admin_url('admin-ajax.php')),
			'nonce'             => wp_create_nonce('pa-blog-block-nonce'),
			'settingPath'       => admin_url('admin.php?page=pb_panel&path=settings'),
			'defaultAuthImg'    => PREMIUM_BLOCKS_URL . 'assets/img/author.jpg',
			"defaultImage"		=> PREMIUM_BLOCKS_URL . 'assets/img/a-woman-working-on-laptop.jpg',
			'activeBlocks'      => self::$blocks,
			'tablet_breakpoint' => PBG_TABLET_BREAKPOINT,
			'mobile_breakpoint' => PBG_MOBILE_BREAKPOINT,
			'shapes'            => $this->getSvgShapes(),
			'localFonts'		=> $this->premium_get_wp_local_fonts(),
			'masks'             => PREMIUM_BLOCKS_URL . 'assets/icons/masks',
			'plugin_url'		=> PREMIUM_BLOCKS_URL,
			'admin_url'         => admin_url(),
			'all_taxonomy'      => $this->get_all_taxonomy(),
			'image_sizes'       => $this->get_image_sizes(),
			'get_authors'       => $this->get_authors(),
			'post_type'         => $this->get_post_types(),
			'globalFeatures'    => $this->global_features,
			'performance'       => $this->performance_settings,
			'socialNonce'       => wp_create_nonce('pbg-social'),
			'recaptcha'         => array(
				'v2SiteKey' => $this->integrations_settings['premium-recaptcha-v2-site-key'],
				'v3SiteKey' => $this->integrations_settings['premium-recaptcha-v3-site-key'],
			),
			'mailchimp'         => array(
				'apiKey' => $mailchimp_api_key,
				'lists'  => PBG_Blocks_Integrations::get_instance()->get_mailchimp_lists($mailchimp_api_key),
			),
			'mailerlite'        => array(
				'apiToken' => $mailerlite_api_token,
				'groups'   => PBG_Blocks_Integrations::get_instance()->get_mailerlite_groups($mailerlite_api_token),
			),
			'fluentCRM'         => array(
				'is_active' => function_exists('FluentCrm'),
				'lists'     => PBG_Blocks_Integrations::get_instance()->get_fluentcrm_lists(),
				'tags'      => PBG_Blocks_Integrations::get_instance()->get_fluentcrm_tags(),
			),
			'theme_version'        => esc_html(PREMIUM_BLOCKS_VERSION),
			'FontAwesomeEnabled' => $is_fa_enabled,
			'JsonUploadEnabled' => $allow_json,
		);

    $is_maps_enabled = self::$blocks['maps'];
		$api_key         = isset(self::$config['premium-map-key']) ? self::$config['premium-map-key'] : '';
		$use_js_api      = isset(self::$config['premium-map-api']) ? self::$config['premium-map-api'] : true;

		if ($is_maps_enabled ) {
			$settings_data['googleMaps'] = array(
        'apiKey'    => $api_key,
        'useJsApi'  => $use_js_api,
      );
		}

		// PBG.
		$pbg_asset_file   = PREMIUM_BLOCKS_PATH . 'assets/js/build/pbg/index.asset.php';
		$pbg_dependencies = file_exists($pbg_asset_file) ? include $pbg_asset_file : array();
		$pbg_dependencies = $pbg_dependencies['dependencies'] ?? array();
		// Blocks.
		$blocks_asset_file   = PREMIUM_BLOCKS_PATH . 'assets/js/build/blocks/index.asset.php';
		$blocks_dependencies = file_exists($blocks_asset_file) ? include $blocks_asset_file : array();
		$blocks_dependencies = $blocks_dependencies['dependencies'] ?? array();
		// Entrance Animation.
		$entrance_animation_asset_file   = PREMIUM_BLOCKS_PATH . 'assets/js/build/entrance-animation/editor/index.asset.php';
		$entrance_animation_dependencies = file_exists($entrance_animation_asset_file) ? include $entrance_animation_asset_file : array();
		$entrance_animation_dependencies = $entrance_animation_dependencies['dependencies'] ?? array();
		// PBG deps.
		array_push($blocks_dependencies, 'pbg-settings-js');
		array_push($entrance_animation_dependencies, 'pbg-settings-js');

		wp_register_script(
			'pbg-settings-js',
			PREMIUM_BLOCKS_URL . 'assets/js/build/pbg/index.js',
			$pbg_dependencies,
			PREMIUM_BLOCKS_VERSION,
			true
		);

		wp_register_script(
			'pbg-blocks-js',
			PREMIUM_BLOCKS_URL . 'assets/js/build/blocks/index.js',
			$blocks_dependencies,
			PREMIUM_BLOCKS_VERSION,
			true
		);

		wp_localize_script(
			'pbg-settings-js',
			'PremiumBlocksSettings',
			$settings_data
		);

		if ($this->global_features['premium-entrance-animation']) {
			wp_enqueue_script(
				'pbg-entrance-animation',
				PREMIUM_BLOCKS_URL . 'assets/js/build/entrance-animation/editor/index.js',
				$entrance_animation_dependencies,
				PREMIUM_BLOCKS_VERSION,
				true
			);
			wp_localize_script(
				'pbg-entrance-animation',
				'PremiumAnimation',
				array(
					'allBlocks' => $this->global_features['premium-entrance-animation-all-blocks'],
				)
			);
		}

		if ($this->global_features['premium-copy-paste-styles'] ?? true) {
			wp_enqueue_script(
				'pbg-copy-paste-style',
				PREMIUM_BLOCKS_URL . 'assets/js/build/copy-paste-style/index.js',
				array('wp-block-editor', 'wp-blocks', 'wp-components', 'wp-compose', 'wp-data', 'wp-element', 'wp-hooks', 'wp-i18n', 'wp-notices', 'pbg-settings-js'),
				PREMIUM_BLOCKS_VERSION,
				true
			);
		}
	}


	/**
	 * PBG Frontend
	 *
	 * Enqueue Frontend Assets for Premium Blocks.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function pbg_frontend()
	{
		$is_fa_enabled = isset(self::$config['premium-fa-css']) ? self::$config['premium-fa-css'] : true;

		$is_rtl = is_rtl() ? true : false;

		if ($is_rtl && ( $this->has_premium_blocks || $this->content_has_premium_blocks() )) {
			wp_enqueue_style(
				'pbg-style',
				PREMIUM_BLOCKS_URL . 'assets/css/minified/style-blocks-rtl.min.css',
				array(),
				PREMIUM_BLOCKS_VERSION,
				'all'
			);
		}
	}

	/**
	 * On init startup.
	 */
	public function on_init()
	{
		if (! function_exists('register_block_type')) {
			return;
		}

		foreach (self::$blocks as $slug => $value) {
			if (false === $value) {
				continue;
			}
			if (file_exists(PREMIUM_BLOCKS_PATH . "blocks-config/{$slug}/index.php")) {
				require_once PREMIUM_BLOCKS_PATH . "blocks-config/{$slug}/index.php";
			}
			if ('pricing-table' === $slug || 'icon-box' === $slug || 'person' === $slug) {
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/text/index.php';
				if ('pricing-table' === $slug) {
					require_once PREMIUM_BLOCKS_PATH . 'blocks-config/price/index.php';
					require_once PREMIUM_BLOCKS_PATH . 'blocks-config/badge/index.php';
				}
				if ('pricing-table' === $slug || 'icon-box' === $slug || 'count-up' === $slug) {
					require_once PREMIUM_BLOCKS_PATH . 'blocks-config/buttons/index.php';
					require_once PREMIUM_BLOCKS_PATH . 'blocks-config/button/index.php';
					require_once PREMIUM_BLOCKS_PATH . 'blocks-config/bullet-list/index.php';
					require_once PREMIUM_BLOCKS_PATH . 'blocks-config/section/index.php';
					require_once PREMIUM_BLOCKS_PATH . 'blocks-config/icon/index.php';
				}
				if ('person' === $slug) {
					require_once PREMIUM_BLOCKS_PATH . 'blocks-config/image.php';
					require_once PREMIUM_BLOCKS_PATH . 'blocks-config/icon-group.php';
					require_once PREMIUM_BLOCKS_PATH . 'blocks-config/section/index.php';
					require_once PREMIUM_BLOCKS_PATH . 'blocks-config/icon/index.php';
					require_once PREMIUM_BLOCKS_PATH . 'blocks-config/buttons/index.php';
				}
			} elseif ($slug === 'content-switcher') {
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/switcher-child.php';
			} elseif ($slug === 'count-up') {
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/counter/index.php';
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/icon/index.php';
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/text/index.php';
			} elseif ($slug === 'testimonials') {
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/image.php';
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/text/index.php';
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/star-ratings/index.php';
			} elseif ($slug === 'buttons') {
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/button/index.php';
			} elseif ($slug === 'instagram-feed') {
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/instagram-feed-header/index.php';
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/instagram-feed-posts/index.php';
			} elseif ($slug === 'bullet-list') {
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/list-item/index.php';
			} elseif ($slug === 'tabs') {
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/tab-item/index.php';
			} elseif ($slug === 'form') {
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/form-email.php';
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/form-name.php';
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/form-checkbox.php';
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/form-toggle.php';
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/form-radio.php';
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/form-hidden.php';
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/form-accept.php';
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/form-phone.php';
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/form-url.php';
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/form-date.php';
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/form-textarea.php';
				require_once PREMIUM_BLOCKS_PATH . 'blocks-config/form-select.php';
			} elseif ($slug === 'one-page-scroll') {
        require_once PREMIUM_BLOCKS_PATH . 'blocks-config/one-page-scroll-item/index.php';
      } elseif ($slug === 'post-carousel' || $slug === 'post-grid') {
        require_once PREMIUM_BLOCKS_PATH . 'blocks-config/post.php';
      }
		}
	}

	/**
	 * Add Premium Blocks category to Blocks Categories
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @param array $categories blocks categories.
	 */
	public function register_premium_category($categories)
	{
		return array_merge(
			array(
				array(
					'slug'  => 'premium-blocks',
					'title' => __('Premium Blocks', 'premium-blocks-for-gutenberg'),
				),
			),
			$categories
		);
	}

	/**
	 * Render Boolean is amp or Not
	 */
	public function it_is_not_amp()
	{
		$not_amp = true;
		if (function_exists('is_amp_endpoint') && is_amp_endpoint()) {
			$not_amp = false;
		}
		return $not_amp;
	}

	/**
	 * Get Post Types.
	 *
	 * @since 1.11.0
	 * @access public
	 */
	public static function get_post_types()
	{

		$post_types = get_post_types(
			array(
				'public'       => true,
				'show_in_rest' => true,
			),
			'objects'
		);

		$options = array();

		foreach ($post_types as $post_type) {

			if ('attachment' === $post_type->name) {
				continue;
			}

			$options[] = array(
				'value' => $post_type->name,
				'label' => $post_type->label,
			);
		}

		return apply_filters('pbg_loop_post_types', $options);
	}

	public function get_all_taxonomy()
	{

		$post_types = self::get_post_types();

		$return_array = array();

		foreach ($post_types as $key => $value) {
			$post_type = $value['value'];

			$taxonomies = get_object_taxonomies($post_type, 'objects');
			$data       = array();

			foreach ($taxonomies as $tax_slug => $tax) {
				if (! $tax->public || ! $tax->show_ui || ! $tax->show_in_rest) {
					continue;
				}

				$data = array_merge($data, [$tax]);

        $terms = get_terms( array(
            'taxonomy' => $tax_slug,
            'hide_empty' => true,
        ) );

				$related_tax = array();

				if (! empty($terms)) {
					foreach ($terms as $t_index => $t_obj) {
						$related_tax[] = array(
							'id'    => $t_obj->term_id,
							'name'  => $t_obj->name,
							'child' => get_term_children($t_obj->term_id, $tax_slug),
              'count' => $t_obj->count,
						);
					}
					$return_array[$post_type]['terms'][$tax_slug] = $related_tax;
				}
			}

			$return_array[$post_type]['taxonomies'] = $data;
		}

		return apply_filters('pbg_post_loop_taxonomies', $return_array);
	}


	/**
	 * Get size information for all currently-registered image sizes.
	 *
	 * @global $_wp_additional_image_sizes
	 * @uses   get_intermediate_image_sizes()
	 * @link   https://codex.wordpress.org/Function_Reference/get_intermediate_image_sizes
	 * @since  1.9.0
	 * @return array $sizes Data for all currently-registered image sizes.
	 */
	public static function get_image_sizes()
	{

		global $_wp_additional_image_sizes;

		$sizes       = get_intermediate_image_sizes();
		$image_sizes = array();

		$image_sizes[] = array(
			'value' => 'full',
			'label' => esc_html__('Full', 'premium-blocks-for-gutenberg'),
		);

		foreach ($sizes as $size) {
			if (in_array($size, array('thumbnail', 'medium', 'medium_large', 'large'), true)) {
				$image_sizes[] = array(
					'value' => $size,
					'label' => ucwords(trim(str_replace(array('-', '_'), array(' ', ' '), $size))),
				);
			} else {
				$image_sizes[] = array(
					'value' => $size,
					'label' => sprintf(
						'%1$s (%2$sx%3$s)',
						ucwords(trim(str_replace(array('-', '_'), array(' ', ' '), $size))),
						$_wp_additional_image_sizes[$size]['width'],
						$_wp_additional_image_sizes[$size]['height']
					),
				);
			}
		}

		$image_sizes = apply_filters('pbg_post_featured_image_sizes', $image_sizes);

		return $image_sizes;
	}

	/**
	 * Builds the base url.
	 *
	 * @param string $permalink_structure Premalink Structure.
	 * @param string $base Base.
	 * @since 1.14.9
	 */
	public static function build_base_url($permalink_structure, $base)
	{
		// Check to see if we are using pretty permalinks.
		if (! empty($permalink_structure)) {

			if (strrpos($base, 'paged-')) {
				$base = substr_replace($base, '', strrpos($base, 'paged-'), strlen($base));
			}

			// Remove query string from base URL since paginate_links() adds it automatically.
			// This should also fix the WPML pagination issue that was added since 1.10.2.
			if (count($_GET) > 0) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				$base = strtok($base, '?');
			}

			// Add trailing slash when necessary.
			if ('/' === substr($permalink_structure, -1)) {
				$base = trailingslashit($base);
			} else {
				$base = untrailingslashit($base);
			}
		} else {
			$url_params = wp_parse_url($base, PHP_URL_QUERY);

			if (empty($url_params)) {
				$base = trailingslashit($base);
			}

			if (count($_GET) > 0) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				$base = explode("?", $base)[0];
			}
		}

		return $base;
	}

	/**
	 * Returns Query.
	 *
	 * @param array  $attributes The block attributes.
	 * @param string $block_type The Block Type.
	 * @since 1.8.2
	 */
	public static function get_query($attributes, $block_type, $page = 1)
	{
		// Block type is grid/masonry/carousel/timeline.
		$query_args     = array(
			'posts_per_page' => (isset($attributes['query']['perPage'])) ? $attributes['query']['perPage'] : 6,
			'post_status'    => 'publish',
			'post_type'      => (isset($attributes['query']['postType'])) ? $attributes['query']['postType'] : 'post',
			'order'          => (isset($attributes['query']['order'])) ? $attributes['query']['order'] : 'desc',
			'orderby'        => (isset($attributes['query']['orderBy'])) ? $attributes['query']['orderBy'] : 'date',
			'paged'          => 1,
		);
		$excluded_posts = array();
		if (! empty($attributes['query']['exclude'])) {
			if ($attributes['postFilterRule'] === 'post__in') {
				$query_args['post__in'] = $attributes['query']['exclude'];
			} else {
				$excluded_posts = $attributes['query']['exclude'];
			}
		}

		if ( isset($attributes['query']['offset']) && 0 !== $attributes['query']['offset'] ) {
			$query_args['offset'] = $attributes['query']['offset'];
		}
		if ($attributes['query']['sticky']) {
			$excluded_posts = array_merge($excluded_posts, get_option('sticky_posts'));
		}

		if ($attributes['currentPost']) {
			array_push($excluded_posts, get_the_id());
		}

		$query_args['post__not_in'] = $excluded_posts;

		if (! empty($attributes['query']['author'])) {

			$query_args[$attributes['authorFilterRule']] = $attributes['query']['author'];
		}

    /**
     * Backwards compatibility for older versions.
     * handling categories filter. 
     * This can be removed after few releases as we have added this in taxQuery.
     */
		if (isset($attributes['categories']) && ! empty(array_filter($attributes['categories']))) {
			$query_args['tax_query'][] = array(
				'taxonomy' => 'category',
				'field'    => 'term_id',
				'terms'    => array_filter($attributes['categories']),
				'operator' => str_replace("'", '', $attributes['categoryFilterRule'] ?? "'IN'"),
			);
		}

		// Handle taxonomy queries
		if (isset($attributes['query']['taxQuery']) && !empty($attributes['query']['taxQuery'])) {
			foreach ($attributes['query']['taxQuery'] as $taxonomy => $tax_data) {		
        if (!empty($tax_data) && is_array($tax_data) && isset($tax_data['terms']) && ! empty($tax_data['terms'])) {
          $query_args['tax_query'][] = array(
            'taxonomy' => $taxonomy,
            'field'    => 'term_id',
            'terms'    => $tax_data['terms'],
            'operator' => $tax_data['operator'] ?? 'IN',
          );
        }
			}
		}

    // Handle filter query
    if (isset($attributes['query']['filterQuery']) && !empty($attributes['query']['filterQuery'])) {
      $filter_query = $attributes['query']['filterQuery'];
      $filter_taxonomy = $filter_query['taxonomy'] ?? '';
      $filter_terms = $filter_query['terms'] ?? array();
      if (!empty($filter_terms) && is_array($filter_terms)) {
        $query_args['tax_query'][] = array(
          'taxonomy' => $filter_taxonomy,
          'field'    => 'term_id',
          'terms'    => $filter_terms,
          'operator' => 'IN',
        );
      }
		}

		if (isset($attributes['pagination']) && true === $attributes['pagination']) {
			$query_args['posts_per_page'] = $attributes['query']['perPage'];
			$query_args['paged']          = $page;
		}

		$query_args = apply_filters("pbg_post_query_args_{$block_type}", $query_args, $attributes);
		return new WP_Query($query_args);
	}

	public function add_custom_block_css($css)
	{
		// Generate a unique ID for the style tag
		$unique_id = uniqid();

		// Add the CSS code to the global array
		global $custom_block_css;
		$custom_block_css[$unique_id] = $css;

		// Register a function to output the CSS code in the head of the page
	}

	public function get_custom_block_css()
	{

		global $custom_block_css;
		// Get the media queries.
		$media_query            = array();
		$media_query['mobile']  = apply_filters('Premium_BLocks_mobile_media_query', '(max-width: 767px)');
		$media_query['tablet']  = apply_filters('Premium_BLocks_tablet_media_query', '(max-width: 1024px)');
		$media_query['desktop'] = apply_filters('Premium_BLocks_desktop_media_query', '(min-width: 1025px)');

		// Combine all CSS code into one string
		$combined_css_array = array(
			'desktop' => '',
			'tablet'  => '',
			'mobile'  => '',
		);

		$combined_css = '';

		if (is_array($custom_block_css) && ! empty($custom_block_css)) {
			foreach ($custom_block_css as $unique_id => $css) {
				if (! is_array($css)) {
					$combined_css_array['desktop'] .= $css;
					continue;
				}
				$combined_css_array['desktop'] .= $css['desktop'];
				$combined_css_array['tablet']  .= $css['tablet'];
				$combined_css_array['mobile']  .= $css['mobile'];
			}
		}

		if (! empty($combined_css_array['desktop'])) {
			$combined_css .= $combined_css_array['desktop'];
		}

		if (! empty($combined_css_array['tablet'])) {
			$combined_css .= "@media all and {$media_query['tablet']} {" . $combined_css_array['tablet'] . '}';
		}

		if (! empty($combined_css_array['mobile'])) {
			$combined_css .= "@media all and {$media_query['mobile']} {" . $combined_css_array['mobile'] . '}';
		}

		// Output the combined CSS code in a single style tag
		return $combined_css;
	}

	/**
	 * Creates and returns an instance of the class
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return object
	 */
	public static function get_instance()
	{
		if (! isset(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}
if (! function_exists('pbg_blocks_helper')) {

	/**
	 * Returns an instance of the plugin class.
	 *
	 * @since  1.0.0
	 *
	 * @return object
	 */
	function pbg_blocks_helper()
	{
		return pbg_blocks_helper::get_instance();
	}
}
pbg_blocks_helper();