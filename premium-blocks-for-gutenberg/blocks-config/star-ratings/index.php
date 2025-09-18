<?php

/**
 * Server-side rendering of the `pbg/icon` block.
 *
 * @package WordPress
 */

/**
 * Get Icon Block CSS
 *
 * Return Frontend CSS for Icon.
 *
 * @access public
 *
 * @param string $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_star_ratings_css($attr, $unique_id)
{
	$css = new Premium_Blocks_css();

	// Text alignment
	$css->set_selector('.' . $unique_id );
	$css->pbg_render_value($attr, 'rateAlign', 'text-align', 'Desktop');

	// Container flex-direction and gap
	$css->set_selector('.' . $unique_id . ' .premium-star-ratings-container');
	$css->pbg_render_range($attr, 'titleGap', 'gap', 'Desktop');

	// Handle ratePosition for flex-direction
	if (isset($attr['ratePosition'])) {
		$rate_position = isset($attr['ratePosition']['Desktop']) ? $attr['ratePosition']['Desktop'] : 'right';

		$flex_direction = 'row'; // default
		if ($rate_position === 'top') {
			$flex_direction = 'column-reverse';
		} elseif ($rate_position === 'bottom') {
			$flex_direction = 'column';
		} elseif ($rate_position === 'left') {
			$flex_direction = 'row-reverse';
		}
		
		$css->set_selector('.' . $unique_id . ' .premium-star-ratings-container');
		$css->add_property('flex-direction', $flex_direction);
  		$css->pbg_render_align_self($attr, 'rateAlign', 'align-items', 'Desktop'); 
		$css->add_property('align-items', ($rate_position === "left" || $rate_position === "right") ? 'center' : '');
	}

	$css->set_selector('.' . $unique_id . ' .premium-star-ratings-container .premium-star-ratings-icons');
	$css->pbg_render_range($attr, 'rateGap', 'gap', 'Desktop', null, '!important');

	$css->set_selector('.' . $unique_id . ' .premium-star-ratings-container .premium-star-ratings-title');
	$css->pbg_render_typography($attr, 'typography', 'Desktop');
	$css->pbg_render_color($attr, 'textColor', 'color');

	$css->set_selector(".{$unique_id} .premium-star-ratings-container .premium-star-ratings-icons .premium-star-ratings-filled, " .
    ".{$unique_id} .premium-star-ratings-container .premium-star-ratings-icons .premium-star-ratings-filled svg *");
  	$css->pbg_render_color($attr, 'rateColor', 'color', null , '!important');
  	$css->pbg_render_color($attr, 'rateColor', 'fill', null , '!important');

	$css->set_selector(".{$unique_id} .premium-star-ratings-container .premium-star-ratings-icons .premium-star-ratings-empty, " .
    ".{$unique_id} .premium-star-ratings-container .premium-star-ratings-icons .premium-star-ratings-empty svg *");
  	$css->pbg_render_color($attr, 'unmarkedColor', 'color', null , '!important');
  	$css->pbg_render_color($attr, 'unmarkedColor', 'fill', null , '!important');

	$css->set_selector(".{$unique_id} .premium-star-ratings-container .premium-star-ratings-icons .premium-icon-star-ratings, " .
    ".{$unique_id} .premium-star-ratings-container .premium-star-ratings-icons svg");
  	$css->pbg_render_range($attr, 'rateSize', 'width', 'Desktop', null, '!important');
  	$css->pbg_render_range($attr, 'rateSize', 'height', 'Desktop', null, '!important');

	$css->start_media_query('tablet');

	// Tablet responsive values
	$css->set_selector('.' . $unique_id );
	$css->pbg_render_value($attr, 'rateAlign', 'text-align', 'Tablet');

	// Container flex-direction and gap
	$css->set_selector('.' . $unique_id . ' .premium-star-ratings-container');
	$css->pbg_render_range($attr, 'titleGap', 'gap', 'Tablet');

	// Handle ratePosition for flex-direction
	if (isset($attr['ratePosition'])) {
		$rate_position = isset($attr['ratePosition']['Tablet']) ? $attr['ratePosition']['Tablet'] : 'right';

		$flex_direction = 'row'; // default
		if ($rate_position === 'top') {
			$flex_direction = 'column-reverse';
		} elseif ($rate_position === 'bottom') {
			$flex_direction = 'column';
		} elseif ($rate_position === 'left') {
			$flex_direction = 'row-reverse';
		}
		
		$css->set_selector('.' . $unique_id . ' .premium-star-ratings-container');
		$css->add_property('flex-direction', $flex_direction);
		$css->pbg_render_align_self($attr, 'rateAlign', 'align-items', 'Tablet'); 
		$css->add_property('align-items', ($rate_position === "left" || $rate_position === "right") ? 'center' : '');
	}

	$css->set_selector('.' . $unique_id . ' .premium-star-ratings-container .premium-star-ratings-icons');
	$css->pbg_render_range($attr, 'rateGap', 'gap', 'Tablet', null, '!important');

	$css->set_selector('.' . $unique_id . ' .premium-star-ratings-container .premium-star-ratings-title');
	$css->pbg_render_typography($attr, 'typography', 'Tablet');

	$css->set_selector(".{$unique_id} .premium-star-ratings-container .premium-star-ratings-icons .premium-icon-star-ratings, " .
    ".{$unique_id} .premium-star-ratings-container .premium-star-ratings-icons svg");
  	$css->pbg_render_range($attr, 'rateSize', 'width', 'Tablet', null, '!important');
  	$css->pbg_render_range($attr, 'rateSize', 'height', 'Tablet', null, '!important');
	

	$css->stop_media_query();
	$css->start_media_query('mobile');

	// Mobile responsive values
	$css->set_selector('.' . $unique_id );
	$css->pbg_render_value($attr, 'rateAlign', 'text-align', 'Mobile');

	// Container flex-direction and gap
	$css->set_selector('.' . $unique_id . ' .premium-star-ratings-container');
	$css->pbg_render_range($attr, 'titleGap', 'gap', 'Mobile');

	// Handle ratePosition for flex-direction
	if (isset($attr['ratePosition'])) {
		$rate_position = isset($attr['ratePosition']['Mobile']) ? $attr['ratePosition']['Mobile'] : 'right';

		$flex_direction = 'row'; // default
		if ($rate_position === 'top') {
			$flex_direction = 'column-reverse';
		} elseif ($rate_position === 'bottom') {
			$flex_direction = 'column';
		} elseif ($rate_position === 'left') {
			$flex_direction = 'row-reverse';
		}
		
		$css->set_selector('.' . $unique_id . ' .premium-star-ratings-container');
		$css->add_property('flex-direction', $flex_direction);
  		$css->pbg_render_align_self($attr, 'rateAlign', 'align-items', 'Mobile'); 
		$css->add_property('align-items', ($rate_position === "left" || $rate_position === "right") ? 'center' : $attr['rateAlign']['Mobile']);
	}

	$css->set_selector('.' . $unique_id . ' .premium-star-ratings-container .premium-star-ratings-icons');
	$css->pbg_render_range($attr, 'rateGap', 'gap', 'Mobile', null, '!important');

	$css->set_selector('.' . $unique_id . ' .premium-star-ratings-container .premium-star-ratings-title');
	$css->pbg_render_typography($attr, 'typography', 'Mobile');

	$css->set_selector(".{$unique_id} .premium-star-ratings-container .premium-star-ratings-icons .premium-icon-star-ratings, " .
    ".{$unique_id} .premium-star-ratings-container .premium-star-ratings-icons svg");
  	$css->pbg_render_range($attr, 'rateSize', 'width', 'Mobile', null, '!important');
  	$css->pbg_render_range($attr, 'rateSize', 'height', 'Mobile', null, '!important');

	$css->stop_media_query();
	return $css->css_output();
}
/**
 * Renders the `premium/icon` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */
function render_block_pbg_star_ratings($attributes, $content, $block)
{
	$block_helpers = pbg_blocks_helper();

	// Enqueue frontend JS/CSS.
	if ($block_helpers->it_is_not_amp()) {
		wp_enqueue_script(
			'pbg-star-ratings',
			PREMIUM_BLOCKS_URL . 'assets/js/minified/star-ratings.min.js',
			array('jquery'),
			PREMIUM_BLOCKS_VERSION,
			true
		);
	}
  

	return $content;
}




/**
 * Register the icon block.
 *
 * @uses render_block_pbg_star_ratings()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_star_ratings()
{
	if (! function_exists('register_block_type')) {
		return;
	}
	register_block_type(
		PREMIUM_BLOCKS_PATH . '/blocks-config/star-ratings',
		array(
			'render_callback' => 'render_block_pbg_star_ratings',
		)
	);
}

register_block_pbg_star_ratings();