<?php
/**
 * Server-side rendering of the `pbg/content-switcher` block.
 *
 * @package WordPress
 */
function get_premium_switcher_child_css( $attr, $unique_id ) {
	$block_helpers          = pbg_blocks_helper();
	$css                    = new Premium_Blocks_css();

	// icon Size
	if ( isset( $attr['margin'] ) ) {
        $swircherMargin = $attr['margin'];
        $css->set_selector( '.' . $unique_id  );
        $css->add_property( 'margin', $css->render_string( $css->render_spacing( $swircherMargin['Desktop'], isset($swircherMargin['unit']['Desktop'])?$swircherMargin['unit']['Desktop']:$swircherMargin['unit']  ) ));
    }

	if ( isset( $attr['padding'] ) ) {
		$switchPadding = $attr['padding'];
        $css->set_selector( '.' . $unique_id  );
		$css->add_property( 'padding', $css->render_string($css->render_spacing( $switchPadding['Desktop'], isset($switchPadding['unit']['Desktop'])?$switchPadding['unit']['Desktop']:$switchPadding['unit']  ) ));
	}

	$css->start_media_query( 'tablet' );
	// // Tablet Styles.

	if ( isset( $attr['margin'] ) ) {
        $swircherMargin = $attr['margin'];
        $css->set_selector( '.' . $unique_id  );
        $css->add_property( 'margin', $css->render_string( $css->render_spacing( $swircherMargin['Tablet'], isset($swircherMargin['unit']['Tablet'])?$swircherMargin['unit']['Tablet']:$swircherMargin['unit']  ) ));
    }

	if ( isset( $attr['padding'] ) ) {
		$switchPadding = $attr['padding'];
        $css->set_selector( '.' . $unique_id  );
		$css->add_property( 'padding', $css->render_string($css->render_spacing( $switchPadding['Tablet'], isset($switchPadding['unit']['Tablet'])?$switchPadding['unit']['Tablet']:$switchPadding['unit']  ) ));
	}
	$css->stop_media_query();
	$css->start_media_query( 'mobile' );
	// // Mobile Styles.



	if ( isset( $attr['margin'] ) ) {
        $swircherMargin = $attr['margin'];
        $css->set_selector( '.' . $unique_id  );
        $css->add_property( 'margin', $css->render_string( $css->render_spacing( $swircherMargin['Mobile'], isset($swircherMargin['unit']['Mobile'])?$swircherMargin['unit']['Mobile']:$swircherMargin['unit']  ) ));
    }

	if ( isset( $attr['padding'] ) ) {
		$switchPadding = $attr['padding'];
        $css->set_selector( '.' . $unique_id  );
		$css->add_property( 'padding', $css->render_string($css->render_spacing( $switchPadding['Mobile'], isset($switchPadding['unit']['Mobile'])?$switchPadding['unit']['Mobile']:$switchPadding['unit']  ) ));
	}


	$css->stop_media_query();

	return $css->css_output();
}/**
 * Registers the `pbg/content-switcher` block on the server.
 */
function register_block_pbg_switcher_child() {
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	register_block_type(
		'premium/switcher-child',
		array(

			'editor_style'  => 'premium-blocks-editor-css',
			'editor_script' => 'pbg-blocks-js',
		)
	);

}

register_block_pbg_switcher_child();
