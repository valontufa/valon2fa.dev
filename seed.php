<?php
/**
 * Data seed script — run with: wp eval-file seed.php
 *
 * Creates the Homepage page (with all ACF fields) and all 4 Project CPT
 * entries. Safe to re-run — checks for duplicates before inserting.
 */

if ( ! defined( 'ABSPATH' ) ) {
    die( 'Run via WP-CLI: wp eval-file seed.php' );
}

// ─── 1. Homepage page ─────────────────────────────────────────────────────────

$homepage_id = get_option( 'page_on_front' );

if ( ! $homepage_id ) {
    // Check if a page named "Homepage" already exists
    $existing = get_page_by_title( 'Homepage', OBJECT, 'page' );
    if ( $existing ) {
        $homepage_id = $existing->ID;
    } else {
        $homepage_id = wp_insert_post( [
            'post_title'  => 'Homepage',
            'post_status' => 'publish',
            'post_type'   => 'page',
        ] );
        WP_CLI::log( "Created Homepage page (ID: $homepage_id)" );
    }

    // Set as front page
    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $homepage_id );
    WP_CLI::log( "Set page $homepage_id as front page" );
} else {
    WP_CLI::log( "Front page already set (ID: $homepage_id)" );
}

// ─── 2. Hero Section ACF fields ───────────────────────────────────────────────

update_field( 'hero_name',              'Valon Tufa',                          $homepage_id );
update_field( 'hero_keywords',          'Senior Full Stack Developer & PHP Expert · WordPress · Laravel · WooCommerce', $homepage_id );
update_field( 'hero_description',       'Experienced in PHP & its ecosystems — adaptable to any modern stack and always learning.', $homepage_id );
update_field( 'hero_availability_text', 'Open to remote opportunities',        $homepage_id );

WP_CLI::log( '✓ Hero section fields set' );

// ─── 3. About Section ACF fields ─────────────────────────────────────────────

update_field( 'about_bio', 'Full stack developer and tech lead with 7+ years of experience building, optimizing, and scaling web applications. I\'ve led teams, owned architecture decisions, and shipped production code across e-commerce, iGaming, hospitality, and automotive — at both agency and product level.', $homepage_id );

update_field( 'about_stack_tags', [
    [ 'tag_name' => 'PHP' ],
    [ 'tag_name' => 'WordPress' ],
    [ 'tag_name' => 'WooCommerce' ],
    [ 'tag_name' => 'Laravel' ],
    [ 'tag_name' => 'AlpineJS' ],
    [ 'tag_name' => 'Tailwind CSS' ],
    [ 'tag_name' => 'MySQL' ],
    [ 'tag_name' => 'REST APIs' ],
    [ 'tag_name' => 'JavaScript' ],
    [ 'tag_name' => 'Vue.js' ],
    [ 'tag_name' => 'Docker' ],
    [ 'tag_name' => 'Git' ],
], $homepage_id );

// Leave about_cv_url blank — add when CV is ready
update_field( 'about_cv_url', '', $homepage_id );

WP_CLI::log( '✓ About section fields set' );

// ─── 4. How I Work Section ACF fields ────────────────────────────────────────

update_field( 'work_paragraph_1', "I don't just write code — I steer. I use AI tools throughout my entire workflow to move faster, think clearer, and deliver better outcomes. Architecture, planning, implementation, automation — all of it is amplified.", $homepage_id );

update_field( 'work_bullets', [
    [ 'bullet_text' => 'I take ownership and act without waiting for instructions' ],
    [ 'bullet_text' => 'I ship features quickly and with quality' ],
    [ 'bullet_text' => 'I think at scale and spot patterns worth fixing' ],
    [ 'bullet_text' => 'I use Claude, Claude Code, and Cursor Pro as core tools — not as a crutch, but as force multipliers' ],
], $homepage_id );

update_field( 'work_closing_line', "You steer, AI builds. That's how I work.", $homepage_id );

update_field( 'work_tools', [
    [ 'tool_name' => 'Claude' ],
    [ 'tool_name' => 'Claude Code' ],
    [ 'tool_name' => 'Cursor Pro' ],
    [ 'tool_name' => 'AI automation pipelines' ],
    [ 'tool_name' => 'AI-assisted workflows' ],
], $homepage_id );

WP_CLI::log( '✓ How I Work section fields set' );

// ─── 5. Experience Section ACF fields ────────────────────────────────────────

update_field( 'experience_items', [
    [
        'exp_date_range' => 'August 2019 — Present',
        'exp_role'       => 'Tech Lead / Senior Full Stack Developer',
        'exp_company'    => 'Starlabs — Prishtina',
        'exp_is_current' => 1,
        'exp_bullets'    => [
            [ 'bullet_text' => 'Led a cross-functional team of 7 developers across 15–20 concurrent iGaming web properties' ],
            [ 'bullet_text' => 'Pushed PageSpeed scores from 50–60 to 98–99 across multiple high-traffic sites' ],
            [ 'bullet_text' => 'Reduced LCP from 4–5s to 1–2s, MySQL queries optimized by 30–40%' ],
            [ 'bullet_text' => 'Built custom WordPress themes, WooCommerce solutions, and Laravel microservices features' ],
        ],
    ],
    [
        'exp_date_range' => 'March 2018 — September 2019',
        'exp_role'       => 'Junior Software Engineer',
        'exp_company'    => 'Dynamic Spheres LLC — Prishtina',
        'exp_is_current' => 0,
        'exp_bullets'    => [
            [ 'bullet_text' => 'Developed web applications in .NET Framework Web Forms and WordPress' ],
            [ 'bullet_text' => 'Worked with REST and SOAP APIs for system integrations' ],
        ],
    ],
    [
        'exp_date_range' => '2016 — 2019',
        'exp_role'       => 'Bachelor of Computer Science',
        'exp_company'    => 'UBT College — Prishtina',
        'exp_is_current' => 0,
        'exp_bullets'    => [],
    ],
], $homepage_id );

WP_CLI::log( '✓ Experience section fields set' );

// ─── 6. Contact Section ACF fields ───────────────────────────────────────────

update_field( 'contact_heading',      "Have a project\nin mind?",                                          $homepage_id );
update_field( 'contact_description',  "I'm open to full-time remote roles, long-term contracts, and freelance projects. Let's talk.", $homepage_id );
update_field( 'contact_email',        'valontufa@gmail.com',                                              $homepage_id );
update_field( 'contact_linkedin_url', 'https://www.linkedin.com/in/valon-tufa-b378b9169',                $homepage_id );

WP_CLI::log( '✓ Contact section fields set' );

// ─── 7. Projects CPT ─────────────────────────────────────────────────────────

$projects = [
    [
        'title'      => 'Carbon Tattoo Supplies',
        'menu_order' => 1,
        'fields'     => [
            'project_tagline'    => 'Custom WooCommerce store for professional tattoo equipment with a bold neon brand identity.',
            'project_tech_stack' => 'WordPress · WooCommerce · AlpineJS · Tailwind',
            'project_live_url'   => '',
            'project_github_url' => '',
        ],
    ],
    [
        'title'      => 'Easy Order',
        'menu_order' => 2,
        'fields'     => [
            'project_tagline'    => 'WooCommerce + AlpineJS Kanban order dashboard for restaurant clients. Real-time, white-label ready.',
            'project_tech_stack' => 'WordPress · WooCommerce · AlpineJS · Tailwind',
            'project_live_url'   => '',
            'project_github_url' => '',
        ],
    ],
    [
        'title'      => 'KM Auto — Dealer Portal',
        'menu_order' => 3,
        'fields'     => [
            'project_tagline'    => 'Standalone B2B dealer portal for a Norwegian car dealership. Designed for reuse across dealerships.',
            'project_tech_stack' => 'Laravel · Blade · AlpineJS · Tailwind',
            'project_live_url'   => '',
            'project_github_url' => '',
        ],
    ],
    [
        'title'      => 'valon2fa.dev',
        'menu_order' => 4,
        'fields'     => [
            'project_tagline'    => 'This portfolio. Custom WordPress theme built from scratch — no page builders.',
            'project_tech_stack' => 'WordPress · Tailwind · AlpineJS · ACF',
            'project_live_url'   => '',
            'project_github_url' => '',
        ],
    ],
];

foreach ( $projects as $project ) {
    // Check if a project with this title already exists
    $existing = get_posts( [
        'post_type'      => 'project',
        'post_status'    => 'publish',
        'title'          => $project['title'],
        'posts_per_page' => 1,
    ] );

    if ( $existing ) {
        $post_id = $existing[0]->ID;
        WP_CLI::log( "Project \"{$project['title']}\" already exists (ID: $post_id) — updating fields" );
    } else {
        $post_id = wp_insert_post( [
            'post_title'  => $project['title'],
            'post_status' => 'publish',
            'post_type'   => 'project',
            'menu_order'  => $project['menu_order'],
        ] );
        WP_CLI::log( "Created project \"{$project['title']}\" (ID: $post_id)" );
    }

    // Update menu_order (in case it exists but order changed)
    wp_update_post( [ 'ID' => $post_id, 'menu_order' => $project['menu_order'] ] );

    // Set ACF fields
    foreach ( $project['fields'] as $field_name => $value ) {
        update_field( $field_name, $value, $post_id );
    }

    WP_CLI::log( "  ✓ ACF fields set for \"{$project['title']}\"" );
}

WP_CLI::success( 'Seed complete. Homepage and all projects are ready.' );
