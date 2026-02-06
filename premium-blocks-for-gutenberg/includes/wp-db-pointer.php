<?php
/**
 * WordPress Admin Pointer for Premium Blocks
 *
 * Displays an admin pointer on the plugin settings page.
 *
 * @package Premium_Blocks_For_Gutenberg
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

add_action(
	'in_admin_header',
	function () {

		if ( ( $GLOBALS["pagenow"] !== 'index.php' && get_current_screen()->id !== 'toplevel_page_pb_panel' ) || get_transient( 'pbg_cm25_pointer_dismiss' ) ) {
			return;
		}

		wp_enqueue_script( 'jquery' );
		wp_enqueue_style( 'wp-pointer' );
		wp_enqueue_script( 'wp-pointer' );

		$pointer_priority = get_option( '_pbg_plugin_pointer_priority' );

		if ( empty( $pointer_priority ) || $pointer_priority > 1 ) {
			update_option( '_pbg_plugin_pointer_priority', 1 );
			$pointer_priority = 1;
		}

		if ( absint( $pointer_priority ) === 1 ) {
			?>
			<script>
                jQuery(
                    function () {
                        jQuery('#toplevel_page_pb_panel').pointer(
                            {
                                content:
                                    "<h3 style='font-weight: 400; margin: 0 0 10px;'>Introducing Free Gutenberg Templates</h3>" +
                                    "<p style='margin: 1em 0;'>Premium Blocks now includes Free Gutenberg templates.</p>" +
                                    "<p><a class='button button-primary' href='https://premiumblocks.io/gutenberg-templates/' target='_blank'>Learn More</a></p>",

                                position:
                                    {
                                        edge: 'left',
                                        align: 'center'
                                    },

                                pointerClass:
                                    'wp-pointer',

                                close: function () {
                                    jQuery.post(
                                        ajaxurl,
                                        {
                                            pointer: 'pbg',
                                            action: 'dismiss-wp-pointer',
                                        }
                                    );
                                },

                            }
                        ).pointer('open');
                    }
                );
			</script>
			<?php
		}
	}
);

add_action(
	'admin_init',
	function () {
		if ( isset( $_POST['action'] ) && 'dismiss-wp-pointer' == $_POST['action'] && isset( $_POST['pointer'] ) && 'pbg' == $_POST['pointer'] ) {
			set_transient( 'pbg_cm25_pointer_dismiss', true, DAY_IN_SECONDS * 30 );
			delete_option( '_pbg_plugin_pointer_priority' );
		}
	}
);
