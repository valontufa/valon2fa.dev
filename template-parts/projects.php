<?php
$projects = new WP_Query([
    'post_type'      => 'project',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
]);
?>
<section id="projects">
    <div class="container">

        <div class="section-label">Projects</div>
        <h2>What I've built.</h2>

        <?php if ($projects->have_posts()) : ?>
            <div class="projects-grid">

                <?php while ($projects->have_posts()) : $projects->the_post();
                    $live_url       = get_field('project_live_url');
                    $github_url     = get_field('project_github_url');
                    $github_label   = get_field('project_github_label');
                    $github_url_2   = get_field('project_github_url_2');
                    $github_label_2 = get_field('project_github_label_2');
                    $tagline        = get_field('project_tagline');
                    $tech_stack     = get_field('project_tech_stack');
                ?>
                    <div class="project-card">

                        <div class="project-img">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('large', ['alt' => esc_attr(get_the_title())]); ?>
                            <?php else : ?>
                                screenshot
                            <?php endif; ?>
                        </div>

                        <div class="project-body">
                            <div class="project-name"><?php the_title(); ?></div>

                            <?php if ($tagline) : ?>
                                <div class="project-tagline"><?php echo esc_html($tagline); ?></div>
                            <?php endif; ?>

                            <?php if ($tech_stack) : ?>
                                <div class="project-stack"><?php echo esc_html($tech_stack); ?></div>
                            <?php endif; ?>

                            <div class="project-links">

                                <?php if ($live_url) : ?>
                                    <a href="<?php echo esc_url($live_url); ?>" target="_blank" rel="noopener" class="btn-demo">Live Demo</a>
                                <?php else : ?>
                                    <span class="btn-demo btn-demo--disabled" aria-disabled="true">Live Demo</span>
                                <?php endif; ?>

                                <?php if ($github_url || $github_url_2) : ?>
                                    <div class="github-links">
                                        <?php if ($github_url) : ?>
                                            <a href="<?php echo esc_url($github_url); ?>" target="_blank" rel="noopener" class="btn-github"><?php echo esc_html($github_label ?: 'GitHub'); ?></a>
                                        <?php endif; ?>
                                        <?php if ($github_url_2) : ?>
                                            <a href="<?php echo esc_url($github_url_2); ?>" target="_blank" rel="noopener" class="btn-github"><?php echo esc_html($github_label_2 ?: 'GitHub'); ?></a>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>

                    </div>
                <?php endwhile; wp_reset_postdata(); ?>

            </div>
        <?php endif; ?>

        <div class="nda-block">
            <h3>Professional Work</h3>
            <p>During my career I've worked as Tech Lead and Senior Developer across 15–20 web properties for major clients in iGaming, automotive, and beyond. Due to NDA agreements I'm unable to share URLs or project details publicly — but I'm happy to discuss the work, technical decisions, and outcomes in detail on a call.</p>
        </div>

    </div>
</section>
