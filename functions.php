<?php
defined('ABSPATH') || exit;


require_once get_template_directory() . '/inc/admin-seed.php';

// ─── Theme Setup ─────────────────────────────────────────────────────────────

function valon2fa_setup() {
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);

    register_nav_menus([
        'primary' => __('Primary Navigation', 'valon2fa'),
    ]);
}
add_action('after_setup_theme', 'valon2fa_setup');

// ─── Enqueue Assets ──────────────────────────────────────────────────────────

function valon2fa_enqueue_assets() {
    // Fonts are self-hosted — no external request, no render-blocking
    $css_file = get_template_directory() . '/assets/css/bundle.css';
    $css_ver  = file_exists($css_file) ? filemtime($css_file) : '1.0.0';
    wp_enqueue_style(
        'valon2fa-main',
        get_template_directory_uri() . '/assets/css/bundle.css',
        [],
        $css_ver
    );

    $js_file = get_template_directory() . '/assets/js/bundle.js';
    $js_ver  = file_exists($js_file) ? filemtime($js_file) : '1.0.0';
    wp_enqueue_script(
        'valon2fa-main',
        get_template_directory_uri() . '/assets/js/bundle.js',
        [],
        $js_ver,
        true
    );
}
add_action('wp_enqueue_scripts', 'valon2fa_enqueue_assets');

// ─── Performance ─────────────────────────────────────────────────────────────

// Remove admin bar — it injects ~300 KB of CSS/JS. Use /wp-admin directly.
add_filter('show_admin_bar', '__return_false');

// Strip junk from <head>
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');

// Remove emoji (~20 KB of JS + inline CSS)
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
add_filter('emoji_svg_url', '__return_false');

// Dequeue everything WordPress loads that this theme does not use
add_action('wp_enqueue_scripts', function () {
    wp_dequeue_script('jquery');
    wp_dequeue_script('jquery-migrate');
    wp_dequeue_script('comment-reply');
    wp_dequeue_script('wp-embed');
    wp_dequeue_script('heartbeat');
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('global-styles');
    wp_dequeue_style('classic-theme-styles');
    wp_dequeue_style('dashicons');
}, 100);

// Preload self-hosted fonts + critical CSS as early as possible
add_action('wp_head', function () {
    $dir = get_template_directory_uri();
    // Font preloads — browser fetches woff2 files before CSS is parsed
    echo '<link rel="preload" href="' . esc_url($dir) . '/assets/fonts/jetbrains-mono-latin.woff2" as="font" type="font/woff2" crossorigin>' . "\n";
    echo '<link rel="preload" href="' . esc_url($dir) . '/assets/fonts/inter-latin.woff2" as="font" type="font/woff2" crossorigin>' . "\n";
    // CSS preload
    $css_file = get_template_directory() . '/assets/css/bundle.css';
    $css_ver  = file_exists($css_file) ? filemtime($css_file) : '1';
    echo '<link rel="preload" href="' . esc_url($dir) . '/assets/css/bundle.css?ver=' . $css_ver . '" as="style">' . "\n";
}, 1);

// ─── Projects CPT ────────────────────────────────────────────────────────────

function valon2fa_register_project_cpt() {
    register_post_type('project', [
        'labels' => [
            'name'               => 'Projects',
            'singular_name'      => 'Project',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Project',
            'edit_item'          => 'Edit Project',
            'new_item'           => 'New Project',
            'view_item'          => 'View Project',
            'search_items'       => 'Search Projects',
            'not_found'          => 'No projects found',
            'not_found_in_trash' => 'No projects found in trash',
        ],
        'public'             => true,
        'has_archive'        => false,
        'show_in_rest'       => false,
        'supports'           => ['title', 'thumbnail', 'page-attributes'],
        'rewrite'            => ['slug' => 'projects'],
        'menu_icon'          => 'dashicons-portfolio',
        'show_in_menu'       => true,
    ]);
}
add_action('init', 'valon2fa_register_project_cpt');

// ─── ACF Field Groups ─────────────────────────────────────────────────────────

function valon2fa_register_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    // ── Hero Section ──────────────────────────────────────────────────────────
    acf_add_local_field_group([
        'key'      => 'group_hero_section',
        'title'    => 'Hero Section',
        'fields'   => [
            [
                'key'   => 'field_hero_name',
                'label' => 'Name',
                'name'  => 'hero_name',
                'type'  => 'text',
            ],
            [
                'key'   => 'field_hero_keywords',
                'label' => 'Keywords / Subtitle',
                'name'  => 'hero_keywords',
                'type'  => 'text',
            ],
            [
                'key'   => 'field_hero_description',
                'label' => 'Description',
                'name'  => 'hero_description',
                'type'  => 'textarea',
                'rows'  => 2,
            ],
            [
                'key'   => 'field_hero_availability_text',
                'label' => 'Availability Text',
                'name'  => 'hero_availability_text',
                'type'  => 'text',
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'page_type',
                    'operator' => '==',
                    'value'    => 'front_page',
                ],
            ],
        ],
        'menu_order'  => 10,
        'style'       => 'default',
        'label_placement' => 'top',
    ]);

    // ── About Section ─────────────────────────────────────────────────────────
    acf_add_local_field_group([
        'key'    => 'group_about_section',
        'title'  => 'About Section',
        'fields' => [
            [
                'key'   => 'field_about_bio',
                'label' => 'Bio',
                'name'  => 'about_bio',
                'type'  => 'textarea',
                'rows'  => 5,
            ],
            [
                'key'        => 'field_about_stack_tags',
                'label'      => 'Stack Tags',
                'name'       => 'about_stack_tags',
                'type'       => 'repeater',
                'layout'     => 'table',
                'button_label' => 'Add Tag',
                'sub_fields' => [
                    [
                        'key'   => 'field_about_tag_name',
                        'label' => 'Tag',
                        'name'  => 'tag_name',
                        'type'  => 'text',
                    ],
                ],
            ],
            [
                'key'           => 'field_about_cv_url',
                'label'         => 'CV File',
                'name'          => 'about_cv_url',
                'type'          => 'file',
                'return_format' => 'url',
                'library'       => 'all',
                'mime_types'    => 'pdf',
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'page_type',
                    'operator' => '==',
                    'value'    => 'front_page',
                ],
            ],
        ],
        'menu_order' => 20,
        'style'      => 'default',
    ]);

    // ── How I Work Section ────────────────────────────────────────────────────
    acf_add_local_field_group([
        'key'    => 'group_how_i_work_section',
        'title'  => 'How I Work Section',
        'fields' => [
            [
                'key'   => 'field_work_paragraph_1',
                'label' => 'Paragraph',
                'name'  => 'work_paragraph_1',
                'type'  => 'textarea',
                'rows'  => 4,
            ],
            [
                'key'        => 'field_work_bullets',
                'label'      => 'Bullet Points',
                'name'       => 'work_bullets',
                'type'       => 'repeater',
                'layout'     => 'table',
                'button_label' => 'Add Bullet',
                'sub_fields' => [
                    [
                        'key'   => 'field_work_bullet_text',
                        'label' => 'Bullet',
                        'name'  => 'bullet_text',
                        'type'  => 'text',
                    ],
                ],
            ],
            [
                'key'   => 'field_work_closing_line',
                'label' => 'Closing Line',
                'name'  => 'work_closing_line',
                'type'  => 'text',
            ],
            [
                'key'        => 'field_work_tools',
                'label'      => 'Tools',
                'name'       => 'work_tools',
                'type'       => 'repeater',
                'layout'     => 'table',
                'button_label' => 'Add Tool',
                'sub_fields' => [
                    [
                        'key'   => 'field_work_tool_name',
                        'label' => 'Tool',
                        'name'  => 'tool_name',
                        'type'  => 'text',
                    ],
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'page_type',
                    'operator' => '==',
                    'value'    => 'front_page',
                ],
            ],
        ],
        'menu_order' => 30,
        'style'      => 'default',
    ]);

    // ── Experience Section ────────────────────────────────────────────────────
    acf_add_local_field_group([
        'key'    => 'group_experience_section',
        'title'  => 'Experience Section',
        'fields' => [
            [
                'key'        => 'field_experience_items',
                'label'      => 'Experience Items',
                'name'       => 'experience_items',
                'type'       => 'repeater',
                'layout'     => 'block',
                'button_label' => 'Add Experience',
                'sub_fields' => [
                    [
                        'key'           => 'field_exp_date_range',
                        'label'         => 'Date Range',
                        'name'          => 'exp_date_range',
                        'type'          => 'text',
                        'placeholder'   => 'e.g. August 2019 — Present',
                        'wrapper'       => ['width' => '50'],
                    ],
                    [
                        'key'     => 'field_exp_is_current',
                        'label'   => 'Current Role',
                        'name'    => 'exp_is_current',
                        'type'    => 'true_false',
                        'message' => 'Mark as current position',
                        'wrapper' => ['width' => '50'],
                    ],
                    [
                        'key'     => 'field_exp_role',
                        'label'   => 'Role / Title',
                        'name'    => 'exp_role',
                        'type'    => 'text',
                        'wrapper' => ['width' => '50'],
                    ],
                    [
                        'key'     => 'field_exp_company',
                        'label'   => 'Company',
                        'name'    => 'exp_company',
                        'type'    => 'text',
                        'wrapper' => ['width' => '50'],
                    ],
                    [
                        'key'        => 'field_exp_bullets',
                        'label'      => 'Bullet Points',
                        'name'       => 'exp_bullets',
                        'type'       => 'repeater',
                        'layout'     => 'table',
                        'button_label' => 'Add Bullet',
                        'sub_fields' => [
                            [
                                'key'   => 'field_bullet_text',
                                'label' => 'Bullet',
                                'name'  => 'bullet_text',
                                'type'  => 'text',
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'page_type',
                    'operator' => '==',
                    'value'    => 'front_page',
                ],
            ],
        ],
        'menu_order' => 40,
        'style'      => 'default',
    ]);

    // ── Contact Section ───────────────────────────────────────────────────────
    acf_add_local_field_group([
        'key'    => 'group_contact_section',
        'title'  => 'Contact Section',
        'fields' => [
            [
                'key'   => 'field_contact_heading',
                'label' => 'Heading',
                'name'  => 'contact_heading',
                'type'  => 'text',
            ],
            [
                'key'   => 'field_contact_description',
                'label' => 'Description',
                'name'  => 'contact_description',
                'type'  => 'textarea',
                'rows'  => 3,
            ],
            [
                'key'   => 'field_contact_email',
                'label' => 'Email',
                'name'  => 'contact_email',
                'type'  => 'email',
            ],
            [
                'key'   => 'field_contact_linkedin_url',
                'label' => 'LinkedIn URL',
                'name'  => 'contact_linkedin_url',
                'type'  => 'url',
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'page_type',
                    'operator' => '==',
                    'value'    => 'front_page',
                ],
            ],
        ],
        'menu_order' => 50,
        'style'      => 'default',
    ]);

    // ── Project Fields (CPT) ──────────────────────────────────────────────────
    acf_add_local_field_group([
        'key'    => 'group_project_fields',
        'title'  => 'Project Fields',
        'fields' => [
            [
                'key'   => 'field_project_tagline',
                'label' => 'Tagline',
                'name'  => 'project_tagline',
                'type'  => 'text',
            ],
            [
                'key'         => 'field_project_tech_stack',
                'label'       => 'Tech Stack',
                'name'        => 'project_tech_stack',
                'type'        => 'textarea',
                'rows'        => 2,
                'placeholder' => 'e.g. WordPress · WooCommerce · AlpineJS · Tailwind',
            ],
            [
                'key'   => 'field_project_live_url',
                'label' => 'Live URL',
                'name'  => 'project_live_url',
                'type'  => 'url',
            ],
            [
                'key'   => 'field_project_github_url',
                'label' => 'GitHub URL',
                'name'  => 'project_github_url',
                'type'  => 'url',
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'project',
                ],
            ],
        ],
        'menu_order' => 0,
        'style'      => 'default',
    ]);
}
add_action('acf/init', 'valon2fa_register_acf_fields');

// ─── ACF JSON Save/Load Point ─────────────────────────────────────────────────

add_filter('acf/settings/save_json', function () {
    return get_stylesheet_directory() . '/acf-json';
});

add_filter('acf/settings/load_json', function ($paths) {
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
});
