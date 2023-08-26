<?php
/**
 * WP GraphQL BeBuilder
 * 
 * @package @nordcom/wp-graphql-bebuilder
 * @author Nordcom Group Inc.
 * @license MIT
 * @version 0.1.0
 * 
 * @wordpress-plugin
 * Plugin Name:                 WP GraphQL BeBuilder
 * Plugin URI:                  https://github.com/NordcomInc/wp-graphql-bebuilder/
 * GitHub Plugin URI:           https://github.com/NordcomInc/wp-graphql-bebuilder/
 * Description:                 A WordPress plugin to expose BeBuilder page objects through WPGraphQL.
 * Version:                     0.1.0
 * Author:                      Nordcom Group Inc.
 * Author URI:                  https://nordcom.io/
 * Text Domain:                 wp-graphql-bebuilder
 * Domain Path:                 /languages/
 * Tested up to:                6.3
 * Requires PHP:                8.0
 * Requires WP:                 6.0
 * Requires Plugins:            wp-graphql
 * WPGraphQL requires at least: 1.12.0
 * License:                     MIT
 * License URI:                 https://github.com/NordcomInc/wp-graphql-bebuilder/blob/main/LICENSE
 */

namespace WPGraphQL\Extensions;

// Deny direct access.
if (!defined( 'ABSPATH' ) ) {
    exit;
}

add_action('graphql_register_types', function() {
    register_graphql_field( 'Page', 'mfnItems', [
        'type' => 'String',
        'description' => __( 'Page items', 'wp-graphql' ),
        'resolve' => function( $post ) {
            $items = get_post_meta( $post->ID, 'mfn-page-items', true );
            return ! empty( $items ) ? json_encode(unserialize(base64_decode($items))) : '';
        }
    ] );
});
add_action('graphql_register_types', function() {
    register_graphql_field( 'Page', 'mfnItemsSeo', [
        'type' => 'String',
        'description' => __( 'Page items\' SEO', 'wp-graphql' ),
        'resolve' => function( $post ) {
            $items = get_post_meta( $post->ID, 'mfn-page-items-seo', true );
            return ! empty( $items ) ? $items : '';
        }
    ] );
});
