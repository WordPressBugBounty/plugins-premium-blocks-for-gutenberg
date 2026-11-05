<?php
/**
 * Query arguments for the Post Grid and Post Carousel blocks.
 *
 * Block attributes come from the block editor, where any user who can publish a post writes them, and for
 * AJAX pagination and filter tabs from the visitor's browser. Every value is checked here before it reaches
 * WP_Query, and only published posts of public post types are ever queried.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class PBG_Post_Query
 */
class PBG_Post_Query {

	/**
	 * Upper bound for posts per page, the same as the REST API's. Filterable with pbg_post_query_max_per_page.
	 */
	const MAX_PER_PAGE = 100;

	/**
	 * The orderings the editor offers, plus the other plain WP_Query orderings.
	 */
	const ORDER_BY = array( 'date', 'modified', 'title', 'menu_order', 'rand', 'ID', 'author', 'name', 'comment_count', 'relevance' );

	const TAX_OPERATORS = array( 'IN', 'NOT IN', 'AND' );

	/**
	 * Build the WP_Query arguments for a block.
	 *
	 * @param array  $attributes Block attributes.
	 * @param string $block_type grid or carousel.
	 * @param int    $page       Page number, used when the block paginates.
	 *
	 * @return array
	 */
	public static function build_args( array $attributes, $block_type, $page = 1 ) {
		$query = isset( $attributes['query'] ) && is_array( $attributes['query'] ) ? $attributes['query'] : array();

		$args = array(
			'posts_per_page' => self::per_page( $query['perPage'] ?? 6 ),
			'post_type'      => self::post_type( $query['postType'] ?? 'post' ),
			'order'          => self::order( $query['order'] ?? 'desc' ),
			'orderby'        => self::order_by( $query['orderBy'] ?? 'date' ),
			'paged'          => empty( $attributes['pagination'] ) ? 1 : max( 1, self::int( $page ) ),
		);

		if ( 'inherit' === ( $attributes['queryType'] ?? '' ) ) {
			$args = self::inherit_args( $args );
		} else {
			$args = self::custom_args( $args, $attributes, $query );
		}

		// Set last, so nothing built from the attributes can change it.
		$args['post_status'] = 'publish';

		return apply_filters( "pbg_post_query_args_{$block_type}", $args, $attributes );
	}

	/**
	 * The post types the editor offers: public, in the REST API, and not attachments.
	 *
	 * @return array Each entry has a value and a label.
	 */
	public static function allowed_post_types() {
		$options = array();

		foreach ( get_post_types(
			array(
				'public'       => true,
				'show_in_rest' => true,
			),
			'objects'
		) as $post_type ) {
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
	 * The attributes as printed for the frontend script, with the signature it must send back with them.
	 *
	 * @param array $attributes Block attributes.
	 *
	 * @return array attributes ( JSON string ) and signature.
	 */
	public static function signed_attributes( array $attributes ) {
		$json = wp_json_encode( $attributes );

		return array(
			'attributes' => $json,
			'signature'  => self::sign( $json ),
		);
	}

	/**
	 * Sign the attributes JSON with a secret only this site has.
	 *
	 * @param string $json Attributes JSON, exactly as printed.
	 *
	 * @return string
	 */
	public static function sign( $json ) {
		return hash_hmac( 'sha256', (string) $json, wp_salt( 'nonce' ) );
	}

	/**
	 * Whether this site printed these attributes.
	 *
	 * @param mixed $json      Attributes JSON sent back by the browser.
	 * @param mixed $signature Signature sent with it.
	 *
	 * @return bool
	 */
	public static function verify( $json, $signature ) {
		return is_string( $json ) && '' !== $json && is_string( $signature ) && hash_equals( self::sign( $json ), $signature );
	}

	/**
	 * Arguments derived from the archive or single page the block is on, not from the attributes.
	 *
	 * @param array $args Arguments so far.
	 *
	 * @return array
	 */
	private static function inherit_args( array $args ) {
		$queried_object = get_queried_object();

		if ( is_category() || is_tag() || is_tax() ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => $queried_object->taxonomy,
					'field'    => 'term_id',
					'terms'    => (int) $queried_object->term_id,
				),
			);
			// Use the post types registered for this taxonomy, not the block default.
			$taxonomy = get_taxonomy( $queried_object->taxonomy );
			if ( $taxonomy && ! empty( $taxonomy->object_type ) ) {
				$args['post_type'] = self::viewable_post_types( $taxonomy->object_type, $args['post_type'] );
			}
		} elseif ( is_post_type_archive() ) {
			$args['post_type'] = self::viewable_post_types( get_query_var( 'post_type' ), $args['post_type'] );
		} elseif ( is_author() ) {
			$args['author'] = (int) $queried_object->ID;
		} elseif ( is_day() ) {
			$args['year']     = self::int( get_query_var( 'year' ) );
			$args['monthnum'] = self::int( get_query_var( 'monthnum' ) );
			$args['day']      = self::int( get_query_var( 'day' ) );
		} elseif ( is_month() ) {
			$args['year']     = self::int( get_query_var( 'year' ) );
			$args['monthnum'] = self::int( get_query_var( 'monthnum' ) );
		} elseif ( is_year() ) {
			$args['year'] = self::int( get_query_var( 'year' ) );
		} elseif ( is_search() ) {
			$args['s'] = get_search_query();
		} elseif ( is_singular() ) {
			// On a single post/product/CPT page, show only the current item.
			$args['post_type']      = self::viewable_post_types( get_post_type(), $args['post_type'] );
			$args['post__in']       = array( get_the_ID() );
			$args['posts_per_page'] = 1;
		}

		return $args;
	}

	/**
	 * Arguments from the block's own query settings.
	 *
	 * @param array $args       Arguments so far.
	 * @param array $attributes Block attributes.
	 * @param array $query      The query attribute.
	 *
	 * @return array
	 */
	private static function custom_args( array $args, array $attributes, array $query ) {
		$excluded = array();
		$chosen   = self::ids( $query['exclude'] ?? array() );

		if ( $chosen ) {
			if ( 'post__in' === ( $attributes['postFilterRule'] ?? '' ) ) {
				$args['post__in'] = $chosen;
			} else {
				$excluded = $chosen;
			}
		}

		$offset = self::int( $query['offset'] ?? 0 );
		if ( $offset ) {
			$args['offset'] = $offset;
		}

		if ( ! empty( $query['sticky'] ) ) {
			$excluded = array_merge( $excluded, self::ids( get_option( 'sticky_posts', array() ) ) );
		}

		if ( ! empty( $attributes['currentPost'] ) && get_the_ID() ) {
			$excluded[] = (int) get_the_ID();
		}

		$args['post__not_in'] = array_values( array_unique( $excluded ) );

		$authors = self::ids( $query['author'] ?? array() );
		if ( $authors ) {
			$rule          = 'author__not_in' === ( $attributes['authorFilterRule'] ?? '' ) ? 'author__not_in' : 'author__in';
			$args[ $rule ] = $authors;
		}

		$tax_query = array();

		// Older blocks saved their categories outside taxQuery.
		$categories = self::ids( $attributes['categories'] ?? array() );
		if ( $categories ) {
			$tax_query[] = self::tax_clause( 'category', $categories, $attributes['categoryFilterRule'] ?? 'IN', $args['post_type'] );
		}

		if ( ! empty( $query['taxQuery'] ) && is_array( $query['taxQuery'] ) ) {
			foreach ( $query['taxQuery'] as $taxonomy => $data ) {
				if ( is_array( $data ) ) {
					$tax_query[] = self::tax_clause( $taxonomy, self::ids( $data['terms'] ?? array() ), $data['operator'] ?? 'IN', $args['post_type'] );
				}
			}
		}

		// The filter tab a visitor clicked.
		if ( ! empty( $query['filterQuery'] ) && is_array( $query['filterQuery'] ) ) {
			$tax_query[] = self::tax_clause( $query['filterQuery']['taxonomy'] ?? '', self::ids( $query['filterQuery']['terms'] ?? array() ), 'IN', $args['post_type'] );
		}

		$tax_query = array_values( array_filter( $tax_query ) );
		if ( $tax_query ) {
			$args['tax_query'] = $tax_query;
		}

		return $args;
	}

	/**
	 * One tax_query clause, or null when the taxonomy is unknown, not public, or not registered for the post type.
	 *
	 * @param mixed        $taxonomy  Taxonomy name.
	 * @param array        $terms     Term IDs.
	 * @param mixed        $operator  IN, NOT IN or AND.
	 * @param string|array $post_type Post type(s) being queried.
	 *
	 * @return array|null
	 */
	private static function tax_clause( $taxonomy, array $terms, $operator, $post_type ) {
		if ( ! $terms || ! is_string( $taxonomy ) ) {
			return null;
		}

		$object = get_taxonomy( $taxonomy );
		if ( ! $object || ! is_taxonomy_viewable( $object ) || ! array_intersect( (array) $post_type, (array) $object->object_type ) ) {
			return null;
		}

		$operator = is_string( $operator ) ? strtoupper( trim( str_replace( "'", '', $operator ) ) ) : 'IN';

		return array(
			'taxonomy' => $taxonomy,
			'field'    => 'term_id',
			'terms'    => $terms,
			'operator' => in_array( $operator, self::TAX_OPERATORS, true ) ? $operator : 'IN',
		);
	}

	/**
	 * @param mixed $value Requested posts per page.
	 *
	 * @return int Between 1 and the maximum.
	 */
	private static function per_page( $value ) {
		$max   = max( 1, (int) apply_filters( 'pbg_post_query_max_per_page', self::MAX_PER_PAGE ) );
		$value = self::int( $value );

		return min( $value ? $value : 6, $max );
	}

	/**
	 * @param mixed $type Requested post type.
	 *
	 * @return string A post type the editor offers and visitors can view, or post.
	 */
	private static function post_type( $type ) {
		if ( is_string( $type ) && in_array( $type, array_column( self::allowed_post_types(), 'value' ), true ) && is_post_type_viewable( $type ) ) {
			return $type;
		}

		return 'post';
	}

	/**
	 * @param mixed        $types    Post type name(s) derived from the current page.
	 * @param string|array $fallback Used when none of them is viewable.
	 *
	 * @return string|array
	 */
	private static function viewable_post_types( $types, $fallback ) {
		$types = array_filter( array_filter( (array) $types, 'is_string' ), 'is_post_type_viewable' );

		return $types ? array_values( $types ) : $fallback;
	}

	/**
	 * @param mixed $order Requested order.
	 *
	 * @return string ASC or DESC.
	 */
	private static function order( $order ) {
		return is_string( $order ) && 'asc' === strtolower( $order ) ? 'ASC' : 'DESC';
	}

	/**
	 * @param mixed $order_by Requested ordering.
	 *
	 * @return string A known ordering, or date.
	 */
	private static function order_by( $order_by ) {
		return is_string( $order_by ) && in_array( $order_by, self::ORDER_BY, true ) ? $order_by : 'date';
	}

	/**
	 * @param mixed $values IDs as sent.
	 *
	 * @return int[] Positive integers only.
	 */
	private static function ids( $values ) {
		$values = is_array( $values ) ? $values : array( $values );

		return array_values( array_filter( array_map( array( __CLASS__, 'int' ), $values ) ) );
	}

	/**
	 * @param mixed $value Any value.
	 *
	 * @return int A non-negative integer; 0 for anything that is not a number.
	 */
	private static function int( $value ) {
		return is_scalar( $value ) ? absint( $value ) : 0;
	}
}
