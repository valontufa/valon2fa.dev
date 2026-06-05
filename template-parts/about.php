<?php
$bio        = get_field('about_bio') ?: '';
$stack_tags = get_field('about_stack_tags') ?: [];
$cv_url     = get_field('about_cv_url') ?: '';
$linkedin   = get_field('contact_linkedin_url') ?: '';
?>
<section id="about">
    <div class="container">

        <div class="section-label">About</div>
        <h2>Who I am.</h2>

        <?php if ($bio) : ?>
            <p class="about-bio"><?php echo nl2br(esc_html($bio)); ?></p>
        <?php endif; ?>

        <?php if ($stack_tags) : ?>
            <div class="stack-tags">
                <?php foreach ($stack_tags as $tag) : ?>
                    <span class="stack-tag"><?php echo esc_html($tag['tag_name']); ?></span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <p class="about-cta">
            Want to know more about my experience?
            <?php if ($linkedin) : ?>
                <a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener">LinkedIn</a>
                <?php if ($cv_url) : ?> or <?php endif; ?>
            <?php endif; ?>
            <?php if ($cv_url) : ?>
                <a href="<?php echo esc_url($cv_url); ?>" target="_blank" rel="noopener">Download CV</a>
            <?php endif; ?>
        </p>

    </div>
</section>
