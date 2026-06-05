<?php
$heading     = get_field('contact_heading') ?: '';
$description = get_field('contact_description') ?: '';
$email       = get_field('contact_email') ?: '';
$linkedin    = get_field('contact_linkedin_url') ?: '';
?>
<section id="contact">
    <div class="container">

        <div class="section-label" style="justify-content: center;">Contact</div>

        <?php if ($heading) : ?>
            <h2 style="text-align: center;"><?php echo nl2br(esc_html($heading)); ?></h2>
        <?php endif; ?>

        <?php if ($description) : ?>
            <p class="contact-line"><?php echo nl2br(esc_html($description)); ?></p>
        <?php endif; ?>

        <div class="contact-links">

            <?php if ($email) : ?>
                <a href="mailto:<?php echo esc_attr($email); ?>" class="contact-link primary">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                    <?php echo esc_html($email); ?>
                </a>
            <?php endif; ?>

            <?php if ($linkedin) : ?>
                <a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener" class="contact-link">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6z"/>
                        <rect x="2" y="9" width="4" height="12"/>
                        <circle cx="4" cy="4" r="2"/>
                    </svg>
                    LinkedIn
                </a>
            <?php endif; ?>

        </div>

    </div>
</section>
