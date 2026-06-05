<?php
$experience_items = get_field('experience_items') ?: [];
?>
<section id="experience">
    <div class="container">

        <div class="section-label">Experience</div>
        <h2>Where I've been.</h2>

        <?php if ($experience_items) : ?>
            <div class="timeline">

                <?php foreach ($experience_items as $item) :
                    $is_current = !empty($item['exp_is_current']);
                    $bullets    = !empty($item['exp_bullets']) ? $item['exp_bullets'] : [];
                ?>
                    <div class="timeline-item<?php echo $is_current ? ' current' : ''; ?>">
                        <div class="timeline-dot"></div>

                        <?php if (!empty($item['exp_date_range'])) : ?>
                            <div class="timeline-meta"><?php echo esc_html($item['exp_date_range']); ?></div>
                        <?php endif; ?>

                        <?php if (!empty($item['exp_role'])) : ?>
                            <div class="timeline-role"><?php echo esc_html($item['exp_role']); ?></div>
                        <?php endif; ?>

                        <?php if (!empty($item['exp_company'])) : ?>
                            <div class="timeline-company"><?php echo esc_html($item['exp_company']); ?></div>
                        <?php endif; ?>

                        <?php if ($bullets) : ?>
                            <ul class="timeline-bullets">
                                <?php foreach ($bullets as $bullet) : ?>
                                    <li><?php echo esc_html($bullet['bullet_text']); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                    </div>
                <?php endforeach; ?>

            </div>
        <?php endif; ?>

    </div>
</section>
