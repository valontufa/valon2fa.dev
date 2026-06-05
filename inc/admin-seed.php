<?php
defined('ABSPATH') || exit;

// ─── Register Tools → Seed Data page ─────────────────────────────────────────

add_action('admin_menu', function () {
    add_submenu_page(
        'tools.php',
        'Seed Data',
        'Seed Data',
        'manage_options',
        'valon2fa-seed',
        'valon2fa_seed_render_page'
    );
});

// ─── Handle form submission ───────────────────────────────────────────────────

function valon2fa_seed_run(): array {
    $log    = [];
    $errors = [];

    // ── Homepage page ────────────────────────────────────────────────────────

    $homepage_id = (int) get_option('page_on_front');

    if (!$homepage_id) {
        $existing = get_posts([
            'post_type'      => 'page',
            'post_status'    => 'publish',
            'title'          => 'Homepage',
            'posts_per_page' => 1,
        ]);
        $homepage_id = $existing ? $existing[0]->ID : 0;
    }

    if (!$homepage_id) {
        $homepage_id = wp_insert_post([
            'post_title'  => 'Homepage',
            'post_status' => 'publish',
            'post_type'   => 'page',
        ]);

        if (is_wp_error($homepage_id)) {
            $errors[] = 'Failed to create Homepage page: ' . $homepage_id->get_error_message();
            return ['log' => $log, 'errors' => $errors];
        }
        $log[] = 'Created Homepage page (ID: ' . $homepage_id . ')';
    } else {
        $log[] = 'Using existing page (ID: ' . $homepage_id . ')';
    }

    update_option('show_on_front', 'page');
    update_option('page_on_front', $homepage_id);
    $log[] = 'Front page set';

    // ── Hero ─────────────────────────────────────────────────────────────────

    update_field('hero_name',              'Valon Tufa',                          $homepage_id);
    update_field('hero_keywords',          'Senior Full Stack Developer & PHP Expert · WordPress · Laravel · WooCommerce', $homepage_id);
    update_field('hero_description',       'Experienced in PHP & its ecosystems — adaptable to any modern stack and always learning.', $homepage_id);
    update_field('hero_availability_text', 'Open to remote opportunities',        $homepage_id);
    $log[] = '✓ Hero fields';

    // ── About ─────────────────────────────────────────────────────────────────

    update_field('about_bio', "Full stack developer and tech lead with 7+ years of experience building, optimizing, and scaling web applications. I've led teams, owned architecture decisions, and shipped production code across e-commerce, iGaming, hospitality, and automotive — at both agency and product level.", $homepage_id);

    update_field('about_stack_tags', [
        ['tag_name' => 'PHP'], ['tag_name' => 'WordPress'], ['tag_name' => 'WooCommerce'],
        ['tag_name' => 'Laravel'], ['tag_name' => 'AlpineJS'], ['tag_name' => 'Tailwind CSS'],
        ['tag_name' => 'MySQL'], ['tag_name' => 'REST APIs'], ['tag_name' => 'JavaScript'],
        ['tag_name' => 'Vue.js'], ['tag_name' => 'Docker'], ['tag_name' => 'Git'],
    ], $homepage_id);

    update_field('about_cv_url', '', $homepage_id);
    $log[] = '✓ About fields';

    // ── How I Work ────────────────────────────────────────────────────────────

    update_field('work_paragraph_1', "I don't just write code — I steer. I use AI tools throughout my entire workflow to move faster, think clearer, and deliver better outcomes. Architecture, planning, implementation, automation — all of it is amplified.", $homepage_id);

    update_field('work_bullets', [
        ['bullet_text' => 'I take ownership and act without waiting for instructions'],
        ['bullet_text' => 'I ship features quickly and with quality'],
        ['bullet_text' => 'I think at scale and spot patterns worth fixing'],
        ['bullet_text' => 'I use Claude, Claude Code, and Cursor Pro as core tools — not as a crutch, but as force multipliers'],
    ], $homepage_id);

    update_field('work_closing_line', "You steer, AI builds. That's how I work.", $homepage_id);

    update_field('work_tools', [
        ['tool_name' => 'Claude'], ['tool_name' => 'Claude Code'],
        ['tool_name' => 'Cursor Pro'], ['tool_name' => 'AI automation pipelines'],
        ['tool_name' => 'AI-assisted workflows'],
    ], $homepage_id);
    $log[] = '✓ How I Work fields';

    // ── Experience ────────────────────────────────────────────────────────────

    update_field('experience_items', [
        [
            'exp_date_range' => 'August 2019 — Present',
            'exp_role'       => 'Tech Lead / Senior Full Stack Developer',
            'exp_company'    => 'Starlabs — Prishtina',
            'exp_is_current' => 1,
            'exp_bullets'    => [
                ['bullet_text' => 'Led a cross-functional team of 7 developers across 15–20 concurrent iGaming web properties'],
                ['bullet_text' => 'Pushed PageSpeed scores from 50–60 to 98–99 across multiple high-traffic sites'],
                ['bullet_text' => 'Reduced LCP from 4–5s to 1–2s, MySQL queries optimized by 30–40%'],
                ['bullet_text' => 'Built custom WordPress themes, WooCommerce solutions, and Laravel microservices features'],
            ],
        ],
        [
            'exp_date_range' => 'March 2018 — September 2019',
            'exp_role'       => 'Junior Software Engineer',
            'exp_company'    => 'Dynamic Spheres LLC — Prishtina',
            'exp_is_current' => 0,
            'exp_bullets'    => [
                ['bullet_text' => 'Developed web applications in .NET Framework Web Forms and WordPress'],
                ['bullet_text' => 'Worked with REST and SOAP APIs for system integrations'],
            ],
        ],
        [
            'exp_date_range' => '2016 — 2019',
            'exp_role'       => 'Bachelor of Computer Science',
            'exp_company'    => 'UBT College — Prishtina',
            'exp_is_current' => 0,
            'exp_bullets'    => [],
        ],
    ], $homepage_id);
    $log[] = '✓ Experience fields';

    // ── Contact ───────────────────────────────────────────────────────────────

    update_field('contact_heading',      "Have a project\nin mind?",           $homepage_id);
    update_field('contact_description',  "I'm open to full-time remote roles, long-term contracts, and freelance projects. Let's talk.", $homepage_id);
    update_field('contact_email',        'valontufa@gmail.com',               $homepage_id);
    update_field('contact_linkedin_url', 'https://www.linkedin.com/in/valon-tufa-b378b9169', $homepage_id);
    $log[] = '✓ Contact fields';

    // ── Projects CPT ──────────────────────────────────────────────────────────

    $projects = [
        [
            'title' => 'Carbon Tattoo Supplies', 'menu_order' => 1,
            'fields' => [
                'project_tagline'    => 'Custom WooCommerce store for professional tattoo equipment with a bold neon brand identity.',
                'project_tech_stack' => 'WordPress · WooCommerce · AlpineJS · Tailwind',
                'project_live_url'   => '',
                'project_github_url' => '',
            ],
        ],
        [
            'title' => 'Easy Order', 'menu_order' => 2,
            'fields' => [
                'project_tagline'    => 'WooCommerce + AlpineJS Kanban order dashboard for restaurant clients. Real-time, white-label ready.',
                'project_tech_stack' => 'WordPress · WooCommerce · AlpineJS · Tailwind',
                'project_live_url'   => '',
                'project_github_url' => '',
            ],
        ],
        [
            'title' => 'KM Auto — Dealer Portal', 'menu_order' => 3,
            'fields' => [
                'project_tagline'    => 'Standalone B2B dealer portal for a Norwegian car dealership. Designed for reuse across dealerships.',
                'project_tech_stack' => 'Laravel · Blade · AlpineJS · Tailwind',
                'project_live_url'   => '',
                'project_github_url' => '',
            ],
        ],
        [
            'title' => 'valon2fa.dev', 'menu_order' => 4,
            'fields' => [
                'project_tagline'    => 'This portfolio. Custom WordPress theme built from scratch — no page builders.',
                'project_tech_stack' => 'WordPress · Tailwind · AlpineJS · ACF',
                'project_live_url'   => '',
                'project_github_url' => '',
            ],
        ],
    ];

    foreach ($projects as $project) {
        $existing = get_posts([
            'post_type'      => 'project',
            'post_status'    => 'publish',
            'title'          => $project['title'],
            'posts_per_page' => 1,
        ]);

        if ($existing) {
            $post_id = $existing[0]->ID;
        } else {
            $post_id = wp_insert_post([
                'post_title'  => $project['title'],
                'post_status' => 'publish',
                'post_type'   => 'project',
                'menu_order'  => $project['menu_order'],
            ]);
        }

        wp_update_post(['ID' => $post_id, 'menu_order' => $project['menu_order']]);

        foreach ($project['fields'] as $field_name => $value) {
            update_field($field_name, $value, $post_id);
        }

        $log[] = '✓ Project: ' . $project['title'];
    }

    return ['log' => $log, 'errors' => $errors];
}

// ─── Render page ──────────────────────────────────────────────────────────────

function valon2fa_seed_render_page(): void {
    if (!current_user_can('manage_options')) {
        wp_die('Not allowed.');
    }

    $result = null;

    if (
        isset($_POST['valon2fa_run_seed']) &&
        check_admin_referer('valon2fa_seed_action', 'valon2fa_seed_nonce')
    ) {
        if (!function_exists('update_field')) {
            $result = ['log' => [], 'errors' => ['ACF Pro is not active. Install and activate it first.']];
        } else {
            $result = valon2fa_seed_run();
        }
    }

    // Check current state for the warning
    $front_page_id  = (int) get_option('page_on_front');
    $already_seeded = $front_page_id > 0 && get_option('show_on_front') === 'page';
    ?>
    <div class="wrap">
        <h1>Seed Data</h1>
        <p style="color:#666;max-width:540px;">
            Populates the Homepage page with all ACF field content and creates the four Projects.
            Run this <strong>once</strong> on a fresh install. Re-running overwrites existing field values.
        </p>

        <?php if ($result !== null) : ?>
            <?php if ($result['errors']) : ?>
                <div class="notice notice-error">
                    <?php foreach ($result['errors'] as $err) : ?>
                        <p>&#10007; <?php echo esc_html($err); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <div class="notice notice-success">
                    <p><strong>Seed complete.</strong></p>
                    <?php foreach ($result['log'] as $line) : ?>
                        <p style="margin:2px 0;"><?php echo esc_html($line); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <?php if ($already_seeded && $result === null) : ?>
            <div class="notice notice-warning inline">
                <p>A front page is already set (ID: <?php echo $front_page_id; ?>). Running the seed will overwrite its ACF field values.</p>
            </div>
        <?php endif; ?>

        <form method="post" style="margin-top:1.5rem;">
            <?php wp_nonce_field('valon2fa_seed_action', 'valon2fa_seed_nonce'); ?>
            <input
                type="submit"
                name="valon2fa_run_seed"
                class="button button-primary"
                value="<?php echo $already_seeded ? 'Re-run Seed (overwrites fields)' : 'Run Seed'; ?>"
                <?php echo $already_seeded && $result === null ? 'onclick="return confirm(\'This will overwrite your ACF field values. Continue?\');"' : ''; ?>
            >
        </form>
    </div>
    <?php
}
