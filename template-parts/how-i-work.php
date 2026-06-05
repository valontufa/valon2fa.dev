<?php
$paragraph_1  = get_field('work_paragraph_1') ?: '';
$bullets      = get_field('work_bullets') ?: [];
$closing_line = get_field('work_closing_line') ?: '';
$tools        = get_field('work_tools') ?: [];
?>
<section id="how-i-work">
    <div class="container">

        <div class="section-label">Process</div>
        <h2>How I work.</h2>

        <div class="work-block">

            <?php if ($paragraph_1) : ?>
                <p><?php echo nl2br(esc_html($paragraph_1)); ?></p>
            <?php endif; ?>

            <?php if ($bullets) : ?>
                <ul class="work-bullets">
                    <?php foreach ($bullets as $bullet) : ?>
                        <li><?php echo esc_html($bullet['bullet_text']); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <?php if ($closing_line) : ?>
                <p class="work-closing"><?php echo esc_html($closing_line); ?></p>
            <?php endif; ?>

            <?php if ($tools) : ?>
                <div class="work-tools">
                    <?php foreach ($tools as $tool) : ?>
                        <span class="work-tool"><?php echo esc_html($tool['tool_name']); ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>

    </div>
</section>
