<?php
/**
 * Generator Class
 *
 * @package     Pbg
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Pbg_Assets_Generator' ) ) {

	/**
	 * Pbg_Merged_Style
	 */
	class Pbg_Assets_Generator {


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
		 * Constructor.
		 *
		 * @param string $prefix Prefix for the asset type (e.g., 'editor' or 'frontend').
		 */
		public function __construct( $prefix ) {
			$this->prefix = $prefix;
		}

		/**
		 * Minify css.
		 *
		 * @param string $css Css code to be minified.
		 * @return string
		 */
		public function minify_css( $css ) {
			$css = preg_replace( '/\s+/', ' ', $css ); // Remove extra spaces.
			$css = preg_replace( '/\/\*(.*?)\*\//', '', $css ); // Remove comments.
			$css = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $css ); // Remove newlines and tabs.

			return $css;
		}

		/**
		 * Get inline css
		 *
		 * @return mixed
		 */
		public function get_inline_css() {
			$css_files    = $this->get_css_files();
			$files_count  = count( $css_files );
			$merged_style = '';
      
			/* new */
			if ( $files_count > 0 ) {
				foreach ( $css_files as $k => $file ) {
					require_once ABSPATH . 'wp-admin/includes/file.php'; // We will probably need to load this file.
					global $wp_filesystem;
					WP_Filesystem(); // Initial WP file system.
					if ( ! $wp_filesystem->exists( PREMIUM_BLOCKS_PATH . $file ) ) {
						continue;
					}
					$merged_style .= $wp_filesystem->get_contents( PREMIUM_BLOCKS_PATH . $file );
				}
			}

			// Inline css.
			$merged_style .= $this->inline_css;

			if ( ! empty( $merged_style ) ) {
				return $this->minify_css( $merged_style );
			} else {
				return false;
			}
		}

		/**
		 * Force regeneration of CSS file
		 * Deletes existing file and meta, then generates new file
		 * Useful when triggered by "Regenerate Assets" button
		 * Cache clearing is handled automatically in get_css_url()
		 *
		 * @return string|false CSS file URL or false on failure
		 */
		public function force_rewrite_css_file() {
			// Delete existing CSS file and meta to force regeneration.
			$this->maybe_delete_css_file();

			if ( 'editor' === $this->prefix ) {
				// Clear editor CSS hash to force regeneration.
				delete_option( 'pbg_editor_css_hash' );
				delete_option( 'pbg_editor_css_version' );
			} else {
				// Clear frontend CSS meta.
				delete_post_meta( $this->post_id, '_premium_css_file_name' );
				delete_post_meta( $this->post_id, '_premium_css_version' );
				delete_post_meta( $this->post_id, '_premium_css_content_hash' );
			}

			// Generate new CSS file (cache clearing happens in get_css_url).
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
		public function get_css_url() {
			// Get the CSS content.
			$merged_style = $this->get_inline_css();

			// If no CSS content, delete existing file and meta.
			if ( empty( $merged_style ) ) {
				$this->maybe_delete_css_file();
				delete_post_meta( $this->post_id, '_premium_css_file_name' );
				delete_post_meta( $this->post_id, '_premium_css_version' );
				return false;
			}

			// Initialize WordPress filesystem.
			require_once ABSPATH . 'wp-admin/includes/file.php';
			global $wp_filesystem;

			if ( ! WP_Filesystem() ) {
				return false; // Failed to initialize filesystem.
			}

			// Set up directory paths.
			$upload_dir = wp_upload_dir();

			// Ensure baseurl uses https if site is SSL.
			if ( is_ssl() || 0 === stripos( get_option( 'siteurl' ), 'https://' ) || ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && 'https' === $_SERVER['HTTP_X_FORWARDED_PROTO'] ) ) {
				$upload_dir['baseurl'] = str_ireplace( 'http://', 'https://', $upload_dir['baseurl'] );
			}

			$dir           = trailingslashit( $upload_dir['basedir'] ) . 'premium-blocks-for-gutenberg/';
			$wp_upload_url = trailingslashit( $upload_dir['baseurl'] ) . 'premium-blocks-for-gutenberg/';

			// Create directory if it doesn't exist.
			if ( ! $wp_filesystem->is_dir( $dir ) ) {
				if ( ! $wp_filesystem->mkdir( $dir, FS_CHMOD_DIR ) ) {
					return false; // Failed to create directory.
				}
			}

			// Generate content hash for efficient comparison.
			$content_hash = md5( $merged_style );
			$file_name    = '';
			$file_path    = '';
			$file_url     = '';
			$need_update  = false;

			if ( 'editor' === $this->prefix ) {
				// Editor CSS: Use static filename and option-based hash storage.
				$file_name   = 'premium-editor-style.css';
				$stored_hash = get_option( 'pbg_editor_css_hash', '' );
				$file_path   = $dir . $file_name;
				$file_url    = $wp_upload_url . $file_name;

				// Quick hash comparison first (avoids file I/O).
				if ( $stored_hash === $content_hash && $wp_filesystem->exists( $file_path ) ) {
					return $file_url; // Content unchanged and file exists.
				}

				// Need to update: hash mismatch or file doesn't exist.
				$need_update = true;

				// Delete old file if it exists.
				if ( $wp_filesystem->exists( $file_path ) ) {
					$wp_filesystem->delete( $file_path );
				}
			} else {
				// Frontend CSS: Use post meta for hash storage.
				$stored_hash      = get_post_meta( $this->post_id, '_premium_css_content_hash', true );
				$stored_file_name = get_post_meta( $this->post_id, '_premium_css_file_name', true );

				// Quick hash comparison first (avoids file I/O).
				if ( $stored_hash === $content_hash && ! empty( $stored_file_name ) ) {
					$file_path = $dir . $stored_file_name;
					$file_url  = $wp_upload_url . $stored_file_name;

					// Verify file still exists.
					if ( $wp_filesystem->exists( $file_path ) ) {
						return $file_url; // Content unchanged and file exists.
					}
				}

				// Need to update: hash mismatch, no meta, or file doesn't exist.
				$need_update = true;

				// Delete old file if meta exists.
				if ( ! empty( $stored_file_name ) ) {
					$old_file_path = $dir . $stored_file_name;
					if ( $wp_filesystem->exists( $old_file_path ) ) {
						$wp_filesystem->delete( $old_file_path );
					}
				}
			}
			// Generate new file.
			if ( $need_update ) {
				// Create filename based on context.
				if ( 'editor' === $this->prefix ) {
					// Editor CSS: Static filename with version based on content hash.
					$file_name = 'premium-editor-style.css';
					// Use first 8 chars of hash for shorter version string.
					$css_version = substr( $content_hash, 0, 8 );
				} else {
					// Frontend CSS: Simple filename with post ID only.
					// Use timestamp for version to ensure cache busting on regeneration.
					$css_version = time();
					$file_name   = $this->post_id ? "premium-style-{$this->post_id}.css" : 'premium-style.css';
				}
				$file_path = $dir . $file_name;
				$file_url  = $wp_upload_url . $file_name;

				// Write new CSS content to file.
				$result = $wp_filesystem->put_contents(
					$file_path,
					$merged_style,
					FS_CHMOD_FILE
				);

				if ( $result ) {
					if ( 'editor' === $this->prefix ) {
						// Editor CSS: Store hash in options table.
						update_option( 'pbg_editor_css_hash', $content_hash );
						update_option( 'pbg_editor_css_version', $css_version );
					} else {
						// Frontend CSS: Store in post meta.
						update_post_meta( $this->post_id, '_premium_css_file_name', $file_name );
						update_post_meta( $this->post_id, '_premium_css_version', $css_version );
						update_post_meta( $this->post_id, '_premium_css_content_hash', $content_hash );
					}

					return $file_url;
				}

				// File creation failed.
				return false;
			}

			// This should never be reached, but for safety return false.
			return false;
		}


		/**
		 * Delete CSS file if it exists
		 *
		 * @return bool True if file was deleted or didn't exist, false on failure
		 */
		protected function maybe_delete_css_file() {
			if ( ! $this->post_id ) {
				return false;
			}

			require_once ABSPATH . 'wp-admin/includes/file.php';
			global $wp_filesystem;

			if ( ! WP_Filesystem() ) {
				return false;
			}

			// Get file name from post meta.
			$file_name = get_post_meta( $this->post_id, '_premium_css_file_name', true );
			if ( empty( $file_name ) ) {
				return true; // No file record exists.
			}

			$upload_dir = wp_upload_dir();
			$dir        = trailingslashit( $upload_dir['basedir'] ) . 'premium-blocks-for-gutenberg/';
			$file_path  = $dir . $file_name;

			// If file exists, delete it.
			if ( $wp_filesystem->exists( $file_path ) ) {
				return $wp_filesystem->delete( $file_path );
			}

			return true; // File didn't exist, so consider it "successfully deleted".
		}

		/**
		 * Css files
		 *
		 * @return mixed
		 */
		public function get_css_files() {
			return apply_filters( 'pbg_add_css_file', $this->css_files );
		}

		/**
		 * Add CSS
		 *
		 * @param string  $src source.
		 * @param boolean $handle handle.
		 * @return void
		 */
		public function pbg_add_css( $src = null, $handle = false ) {
			if ( in_array( $src, $this->css_files, true ) ) {
				return;
			}
			if ( false !== $handle ) {
				$this->css_files[ $handle ] = $src;
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
		public function add_inline_css( $css ) {
			$this->inline_css .= $css;
		}

		/**
		 * Get post id
		 *
		 * @param int $post_id post id.
		 * @return void
		 */
		public function set_post_id( $post_id ) {
			$this->post_id = intval( $post_id );
		}
	}
}
