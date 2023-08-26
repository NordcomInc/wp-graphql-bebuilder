<?php
/**
 * Plugin Name:                 WPGraphQL BeBuilder
 * Plugin URI:                  https://github.com/NordcomInc/wp-graphql-bebuilder/
 * GitHub Plugin URI:           https://github.com/NordcomInc/wp-graphql-bebuilder
 * Description:                 Expose BeBuilder page objects through WPGraphQL.
 * Version:                     0.1.0
 * Author:                      Nordcom Group Inc.
 * Author URI:                  https://nordcom.io/
 * Tags:                        Headless, BeBuilder, WPGraphQL, GraphQL, Betheme
 * Text Domain:                 wp-graphql-bebuilder
 * Domain Path:                 /languages
 * Tested up to:                6.3
 * Requires PHP:                8.0
 * Requires WP:                 6.0
 * Requires Plugins:            wp-graphql
 * WPGraphQL requires at least: 1.12.0
 * License:                     MIT
 * License URI:                 https://github.com/NordcomInc/wp-graphql-bebuilder/blob/main/LICENSE
 */

// Deny direct access.
if (!defined('ABSPATH')) {
    exit;
}

add_action('admin_init', function () {
    $core_dependencies = [
        'WPGraphQL' => class_exists('WPGraphQL'),
        'BeBuilder' => function_exists('mfn_global'),
    ];

    $missing_dependencies = array_keys(array_diff($core_dependencies, array_filter($core_dependencies)));
    $display_admin_notice = static function() use ($missing_dependencies) {
        ?>
            <div class="notice notice-error">
                <p>
                    <?php esc_html_e(
                        'The WPGraphQL BeBuilder plugin couldn\'t be properly activated because the following dependencies are unavailable or not installed:',
                        'wp-graphql-bebuilder'
                    ); ?>
                </p>
                <ul>
                    <?php foreach ($missing_dependencies as $missing_dependency): ?>
                        <li><?php echo esc_html($missing_dependency); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php
    };

    if (!empty($missing_dependencies)) {
        add_action('network_admin_notices', $display_admin_notice);
        add_action('admin_notices', $display_admin_notice);

        return;
    }
});

add_action('graphql_init', function() {
    add_action('graphql_register_types', function() {
        register_graphql_field('Page', 'mfnItems', [
            'type' => 'String',
            'description' => __('Page Components', 'wp-graphql-bebuilder'),
            'resolve' => function($post) {
                $items = get_post_meta($post->ID, 'mfn-page-items', true);
                return ! empty($items) ? wp_json_encode(unserialize(base64_decode($items))) : '';
            }
        ]);
    
        register_graphql_field('Page', 'mfnItemsSeo', [
            'type' => 'String',
            'description' => __('Page SEO Components', 'wp-graphql-bebuilder'),
            'resolve' => function($post) {
                $items = get_post_meta($post->ID, 'mfn-page-items-seo', true);
                return ! empty($items) ? $items : '';
            }
        ]);
    });    
});
