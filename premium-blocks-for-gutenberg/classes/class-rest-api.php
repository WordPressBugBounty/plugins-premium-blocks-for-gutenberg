<?php
/**
 * PBG Rest API.
 *
 * @package PBG
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'PBG_Rest_API' ) ) {

    /**
     * Class PBG_Rest_API.
     */
    final class PBG_Rest_API {

        /**
         * Member Variable
         *
         * @var instance
         */
        private static $instance;

        /**
         *  Initiator
         */
        public static function get_instance() {
            if ( ! isset( self::$instance ) ) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        /**
         * Constructor
         */
        public function __construct() {

            // Activation hook.
            add_action( 'rest_api_init', array( $this, 'blocks_register_rest_fields' ) );
            add_action( 'init', array( $this, 'register_rest_orderby_fields' ) );
            add_filter( 'register_post_type_args', array( $this, 'add_cpts_to_api' ), 10, 2 );

        

        }



        /**
         * Create API fields for additional info
         *
         * @since 0.0.1
         */
        public function blocks_register_rest_fields() {
            $post_type = PBG_Blocks_Helper::get_post_types();

            foreach ( $post_type as $key => $value ) {
                // Add featured image source.
                register_rest_field(
                    $value['value'],
                    'pbg_featured_image_src',
                    array(
                        'get_callback'    => array( $this, 'get_image_src' ),
                        'update_callback' => null,
                        'schema'          => null,
                    )
                );

                // Add author info.
                register_rest_field(
                    $value['value'],
                    'pbg_author_info',
                    array(
                        'get_callback'    => array( $this, 'get_author_info' ),
                        'update_callback' => null,
                        'schema'          => null,
                    )
                );

                // Add comment info.
                register_rest_field(
                    $value['value'],
                    'pbg_comment_info',
                    array(
                        'get_callback'    => array( $this, 'get_comment_info' ),
                        'update_callback' => null,
                        'schema'          => null,
                    )
                );

                // Add excerpt info.
                register_rest_field(
                    $value['value'],
                    'pbg_excerpt',
                    array(
                        'get_callback'    => array( $this, 'get_excerpt' ),
                        'update_callback' => null,
                        'schema'          => null,
                    )
                );

            }

            register_rest_route(
                'premium-blocks-for-gutenberg/v1',
                'all_taxonomy',
                array(
                    array(
                        'methods'             => 'GET',
                        'callback'            => array( $this, 'get_related_taxonomy' ),
                        'permission_callback' => array( $this, 'get_items_permissions_check' ),
                        'args'                => array(),
                    ),
                )
            );
        }

        /**
         * Get all taxonomies.
         *
         * @since 1.11.0
         * @access public
         */
        public function get_related_taxonomy() {

            $post_types = self::get_post_types();

            $return_array = array();

            foreach ( $post_types as $key => $value ) {
                $post_type = $value['value'];

                $taxonomies = get_object_taxonomies( $post_type, 'objects' );
                $data       = array();

                foreach ( $taxonomies as $tax_slug => $tax ) {
                    if ( ! $tax->public || ! $tax->show_ui || ! $tax->show_in_rest ) {
                        continue;
                    }

                    $data[ $tax_slug ] = $tax;

                    $terms = get_terms( $tax_slug );

                    $related_tax = array();

                    if ( ! empty( $terms ) ) {
                        foreach ( $terms as $t_index => $t_obj ) {
                            $related_tax[] = array(
                                'id'    => $t_obj->term_id,
                                'name'  => $t_obj->name,
                                'child' => get_term_children( $t_obj->term_id, $tax_slug ),
                            );
                        }
                        $return_array[ $post_type ]['terms'][ $tax_slug ] = $related_tax;
                    }
                }

                $return_array[ $post_type ]['taxonomy'] = $data;

            }

            return apply_filters( 'pbg_post_loop_taxonomies', $return_array );
        }

        /**
         * Get Post Types.
         *
         * @since 1.11.0
         * @access public
         */
        public static function get_post_types() {

            $post_types = get_post_types(
                array(
                    'public'       => true,
                    'show_in_rest' => true,
                ),
                'objects'
            );

            $options = array();

            foreach ( $post_types as $post_type ) {

                if ( 'attachment' === $post_type->name ) {
                    continue;
                }

                $options[] = array(
                    'value' => $post_type->name,
                    'label' => $post_type->label,
                );
            }

            return apply_filters( 'pbg_loop_post_types', $options );
        }
        /**
         * Check whether a given request has permission to read notes.
         *
         * @param  WP_REST_Request $request Full details about the request.
         * @return WP_Error|boolean
         */
        public function get_items_permissions_check( $request ) {

            if ( ! current_user_can( 'manage_options' ) ) {
                return new \WP_Error( 'uag_rest_cannot_view', __( 'Sorry, you cannot list resources.', 'premium-blocks-for-gutenberg' ), array( 'status' => rest_authorization_required_code() ) );
            }

            return true;
        }

        /**
         * Get featured image source for the rest field as per size
         *
         * @param object $object Post Object.
         * @param string $field_name Field name.
         * @param object $request Request Object.
         * @since 0.0.1
         */
        public function get_image_src( $object, $field_name, $request ) {
            $image_sizes = PBG_Blocks_Helper::get_image_sizes();

            $featured_images = array();

            if ( ! isset( $object['featured_media'] ) ) {
                return $featured_images;
            }

            foreach ( $image_sizes as $key => $value ) {
                $size = $value['value'];

                $featured_images[ $size ] = wp_get_attachment_image_src(
                    $object['featured_media'],
                    $size,
                    false
                );
            }

            return $featured_images;
        }

        /**
         * Get author info for the rest field
         *
         * @param object $object Post Object.
         * @param string $field_name Field name.
         * @param object $request Request Object.
         * @since 0.0.1
         */
        public function get_author_info( $object, $field_name, $request ) {

            $author = ( isset( $object['author'] ) ) ? $object['author'] : '';

            // Get the author name.
            $author_data['display_name'] = get_the_author_meta( 'display_name', $author );

            // Get the author link.
            $author_data['author_link'] = get_author_posts_url( $author );
$author_data['author_img']=get_avatar( get_the_author_meta( 'ID' ), 128, '', get_the_author_meta( 'display_name' ) );
            // Return the author data.
            return $author_data;
        }

        /**
         * Get comment info for the rest field
         *
         * @param object $object Post Object.
         * @param string $field_name Field name.
         * @param object $request Request Object.
         * @since 0.0.1
         */
        public function get_comment_info( $object, $field_name, $request ) {
            // Get the comments link.
            $comments_count = wp_count_comments( $object['id'] );
            if($comments_count->total_comments === 0){
                return sprintf( __( ' No Comments', 'premium-blocks-for-gutenberg'));

            }
            
            // translators: %d is the number of comments.
            return sprintf( __( '%d comment', 'premium-blocks-for-gutenberg', $comments_count->total_comments ), $comments_count->total_comments );

        }

        /**
         * Get excerpt for the rest field
         *
         * @param object $object Post Object.
         * @param string $field_name Field name.
         * @param object $request Request Object.
         * @since 0.0.1
         */
        public function get_excerpt( $object, $field_name, $request ) {
            $excerpt = wp_trim_words( get_the_excerpt( $object['id'] ) );
            if ( ! $excerpt ) {
                $excerpt = null;
            }
            return $excerpt;
        }

        /**
         * Create API Order By Fields
         *
         * @since 1.12.0
         */
        public function register_rest_orderby_fields() {
            $post_type = PBG_Blocks_Helper::get_post_types();

            foreach ( $post_type as $key => $type ) {
                add_filter( "rest_{$type['value']}_collection_params", array( $this, 'add_orderby' ), 10, 1 );
            }
        }

        /**
         * Adds Order By values to Rest API
         *
         * @param object $params Parameters.
         * @since 1.12.0
         */
        public function add_orderby( $params ) {

            $params['orderby']['enum'][] = 'rand';
            $params['orderby']['enum'][] = 'menu_order';

            return $params;
        }

        /**
         * Adds the Contect Form 7 Custom Post Type to REST.
         *
         * @param array  $args Array of arguments.
         * @param string $post_type Post Type.
         * @since 1.10.0
         */
        public function add_cpts_to_api( $args, $post_type ) {
            if ( 'wpcf7_contact_form' === $post_type ) {
                $args['show_in_rest'] = true;
            }

            return $args;
        }
    }

    /**
     *  Prepare if class 'PBG_Rest_API' exist.
     *  Kicking this off by calling 'get_instance()' method
     */
    PBG_Rest_API::get_instance();
}
