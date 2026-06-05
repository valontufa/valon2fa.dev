<?php
$name              = get_field('hero_name') ?: 'Valon Tufa';
$keywords          = get_field('hero_keywords') ?: '';
$description       = get_field('hero_description') ?: '';
$availability_text = get_field('hero_availability_text') ?: '';

// Social/contact links from contact section (reused in hero)
$email         = get_field('contact_email') ?: '';
$linkedin_url  = get_field('contact_linkedin_url') ?: '';
?>
<section id="hero">
    <div class="container">

        <h1 class="fade-in">
            <?php echo esc_html($name); ?><span class="accent">.</span>
        </h1>

        <?php if ($keywords) : ?>
            <p class="hero-keywords fade-in fade-in-delay-1"><?php echo esc_html($keywords); ?></p>
        <?php endif; ?>

        <?php if ($description) : ?>
            <p class="hero-desc fade-in fade-in-delay-2"><?php echo esc_html($description); ?></p>
        <?php endif; ?>

        <?php if ($availability_text) : ?>
            <div class="availability-badge fade-in fade-in-delay-3">
                <?php echo esc_html($availability_text); ?>
            </div>
        <?php endif; ?>

        <div class="social-links fade-in fade-in-delay-4">

            <?php if ($linkedin_url) : ?>
                <a href="<?php echo esc_url($linkedin_url); ?>" target="_blank" rel="noopener" class="social-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6z"/>
                        <rect x="2" y="9" width="4" height="12"/>
                        <circle cx="4" cy="4" r="2"/>
                    </svg>
                    LinkedIn
                </a>
            <?php endif; ?>

            <a href="https://github.com/valontufa" target="_blank" rel="noopener" class="social-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 00-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0020 4.77 5.07 5.07 0 0019.91 1S18.73.65 16 2.48a13.38 13.38 0 00-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 005 4.77a5.44 5.44 0 00-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 009 18.13V22"/>
                </svg>
                GitHub
            </a>

            <?php if ($email) : ?>
                <a href="mailto:<?php echo esc_attr($email); ?>" class="social-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                    Email
                </a>
            <?php endif; ?>

        </div>

    </div>
</section>
