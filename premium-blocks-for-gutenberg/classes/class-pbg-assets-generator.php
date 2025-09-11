<?php

/**
 * Generator Class
 *
 * @package     Pbg
 */

if (! defined('ABSPATH')) {
	exit;
}

if (! class_exists('Pbg_Assets_Generator')) {

	/**
	 * Pbg_Merged_Style
	 */
	class Pbg_Assets_Generator
	{

		/**
		 * Css files
		 *
		 * @var array
		 */
		protected $css_files = array();

		/**
		 * Inline css
		 *
		 * @var string
		 */
		protected $inline_css = '';

		/**
		 * Merged style
		 *
		 * @var string
		 */
		protected $merged_style = '';

		/**
		 * Prefix
		 *
		 * @var string
		 */
		protected $prefix = '';

		/**
		 * Post id
		 *
		 * @var string
		 */
		protected $post_id = '';

		/**
		 * Constructor
		 */
		public function __construct($prefix)
		{
			$this->prefix = $prefix;
		}

		/**
		 * Mifiy css
		 *
		 * @param string $css
		 * @return string
		 */
		function minify_css($css)
		{
			$css = preg_replace('/\s+/', ' ', $css); // Remove extra spaces
			$css = preg_replace('/\/\*(.*?)\*\//', '', $css); // Remove comments
			$css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css); // Remove newlines and tabs

			return $css;
		}

		/**
		 * Get inline css
		 *
		 * @return mixed
		 */
		public function get_inline_css()
		{
			$css_files    = $this->get_css_files();
			$files_count  = count($css_files);
			$merged_style = '';

			/* new */
			if ($files_count > 0) {
				foreach ($css_files as $k => $file) {
					require_once ABSPATH . 'wp-admin/includes/file.php'; // We will probably need to load this file.
					global $wp_filesystem;
					WP_Filesystem(); // Initial WP file system.
					$merged_style .= $wp_filesystem->get_contents(PREMIUM_BLOCKS_PATH . $file);
				}
			}

			// Inline css.
			$merged_style .= $this->inline_css;

			if (! empty($merged_style)) {
				return $this->minify_css($merged_style);
			} else {
				return false;
			}
		}
		public function force_rewrite_css_file()
		{

			// Delete existing CSS file and meta to force regeneration
			$this->maybe_delete_css_file();
			delete_post_meta($this->post_id, '_premium_css_file_name');
			delete_post_meta($this->post_id, '_premium_css_version');

			// Generate new CSS file
			$css_url = $this->get_css_url();
			return $css_url;
		}

		/**
		 * Generate, update or return CSS file URL
		 * Only creates/updates file when content has changed
		 * Updates post meta with latest file information
		 *
		 * @return string|false CSS file URL or false on failure
		 */
		public function get_css_url()
		{
			// Ensure post ID is valid


			// Get the CSS content
			$merged_style = $this->get_inline_css();

			// If no CSS content, delete existing file and meta
			if (empty($merged_style)) {
				$this->maybe_delete_css_file();
				delete_post_meta($this->post_id, '_premium_css_file_name');
				delete_post_meta($this->post_id, '_premium_css_version');
				return false;
			}

			// Initialize WordPress filesystem
			require_once ABSPATH . 'wp-admin/includes/file.php';
			global $wp_filesystem;

			if (!WP_Filesystem()) {
				return false; // Failed to initialize filesystem
			}

			// Set up directory paths
			$upload_dir = wp_upload_dir();
      
      // Ensure baseurl uses https if site is SSL
      if (is_ssl() || stripos(get_option('siteurl'), 'https://') === 0 || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')) {
				$upload_dir['baseurl'] = str_ireplace('http://', 'https://', $upload_dir['baseurl']);
			}

			$dir = trailingslashit($upload_dir['basedir']) . 'premium-blocks-for-gutenberg/';
			$wp_upload_url = trailingslashit($upload_dir['baseurl']) . 'premium-blocks-for-gutenberg/';

			// Create directory if it doesn't exist
			if (!$wp_filesystem->is_dir($dir)) {
				if (!$wp_filesystem->mkdir($dir, FS_CHMOD_DIR)) {
					return false; // Failed to create directory
				}
			}

			// Check for existing file name in post meta
			$file_name = get_post_meta($this->post_id, '_premium_css_file_name', true);
			$file_path = '';
			$file_url = '';
			$need_update = false;
			if (!empty($file_name)) {
				// We have an existing file, check if it needs updating
				$file_path = $dir . $file_name;
				$file_url = $wp_upload_url . $file_name;

				if ($wp_filesystem->exists($file_path)) {
					// Get existing file content
					$existing_content = $wp_filesystem->get_contents($file_path);

					// Compare with new content
					if ($existing_content !== $merged_style) {
						// Content is different, need to update
						$need_update = true;
						$wp_filesystem->delete($file_path);
					} else {
						// Content is the same, no need to update
						return $file_url;
					}
				} else {
					// File doesn't exist but we have a record, need to recreate
					$need_update = true;
				}
			} else {
				// No record of this file, need to create new
				$need_update = true;
			}

			// Generate new file if needed
			if ($need_update) {
				// Create timestamp-based unique filename
				$css_version = time();
				$file_name = $this->post_id ? "premium-style-{$this->post_id}-{$css_version}.css" : "editor-style.css";
				$file_path = $dir . $file_name;
				$file_url = $wp_upload_url . $file_name;

				// Write new CSS content to file
				$result = $wp_filesystem->put_contents(
					$file_path,
					$merged_style,
					FS_CHMOD_FILE
				);

				if ($result) {
					// Update post meta with new file info
					update_post_meta($this->post_id, '_premium_css_file_name', $file_name);
					update_post_meta($this->post_id, '_premium_css_version', $css_version);

					// Clean up old CSS files for this post
					$this->clean_old_css_files($file_name);

					return $file_url;
				} else {
					return false;
				}
			}

			return $file_url;
		}


		/**
		 * Delete CSS file if it exists
		 *
		 * @return bool True if file was deleted or didn't exist, false on failure
		 */
		protected function maybe_delete_css_file()
		{
			if (!$this->post_id) {
				return false;
			}

			require_once ABSPATH . 'wp-admin/includes/file.php';
			global $wp_filesystem;

			if (!WP_Filesystem()) {
				return false;
			}

			// Get file name from post meta
			$file_name = get_post_meta($this->post_id, '_premium_css_file_name', true);
			if (empty($file_name)) {
				return true; // No file record exists
			}

			$upload_dir = wp_upload_dir();
			$dir = trailingslashit($upload_dir['basedir']) . 'premium-blocks-for-gutenberg/';
			$file_path = $dir . $file_name;

			// If file exists, delete it
			if ($wp_filesystem->exists($file_path)) {
				return $wp_filesystem->delete($file_path);
			}

			return true; // File didn't exist, so consider it "successfully deleted"
		}

		/**
		 * Clean up old CSS files for this post
		 * 
		 * @param string $current_file_name Current file name to keep
		 * @return void
		 */
		protected function clean_old_css_files($current_file_name)
		{
			if (!$this->post_id) {
				return;
			}

			require_once ABSPATH . 'wp-admin/includes/file.php';
			global $wp_filesystem;

			if (!WP_Filesystem()) {
				return;
			}

			$upload_dir = wp_upload_dir();
			$dir = trailingslashit($upload_dir['basedir']) . 'premium-blocks-for-gutenberg/';

			// Skip if directory doesn't exist
			if (!$wp_filesystem->is_dir($dir)) {
				return;
			}

			// Get list of files
			$files = $wp_filesystem->dirlist($dir);
			if (!$files) {
				return;
			}

			// Current file pattern to match other versions for this post
			$file_pattern = "premium-style-{$this->post_id}-";

			foreach ($files as $file) {
				$filename = $file['name'];

				// Skip current file and files that don't match our pattern
				if ($filename === $current_file_name || strpos($filename, $file_pattern) === false) {
					continue;
				}

				// Delete old file for this post
				$wp_filesystem->delete($dir . $filename);
			}
		}
		/**
		 * Css files
		 *
		 * @return mixed
		 */
		public function get_css_files()
		{
			return apply_filters('pbg_add_css_file', $this->css_files);
		}

		/**
		 * Add css
		 *
		 * @param string  $src source.
		 * @param boolean $handle handle.
		 * @return void
		 */
		public function pbg_add_css($src = null, $handle = false)
		{
			if (in_array($src, $this->css_files)) {
				return;
			}
			if (false != $handle) {
				$this->css_files[$handle] = $src;
			} else {
				$this->css_files[] = $src;
			}
		}

		/**
		 * Add inline css
		 *
		 * @param string $css css.
		 * @return void
		 */
		public function add_inline_css($css)
		{
			$this->inline_css .= $css;
		}

		/**
		 * Get post id
		 *
		 * @return int
		 */
		public function set_post_id($post_id)
		{
			$this->post_id = intval($post_id);
		}
	}
}
