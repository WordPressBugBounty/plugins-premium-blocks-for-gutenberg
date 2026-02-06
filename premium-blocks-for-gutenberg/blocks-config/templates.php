<?php
/**
 * Register the templates block.
 *
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_templates()
{
    if (! function_exists('register_block_type')) {
        return;
    }
    register_block_type(
        PREMIUM_BLOCKS_PATH . 'blocks-config/templates'
    );
}
register_block_pbg_templates();