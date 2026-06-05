<?php
/**
 * Homepage template — single page, all sections.
 * Content is managed via ACF fields in wp-admin.
 */
get_header();
?>

<main id="main" role="main">
    <?php get_template_part('template-parts/hero'); ?>
    <?php get_template_part('template-parts/about'); ?>
    <?php get_template_part('template-parts/how-i-work'); ?>
    <?php get_template_part('template-parts/projects'); ?>
    <?php get_template_part('template-parts/experience'); ?>
    <?php get_template_part('template-parts/contact'); ?>
</main>

<?php get_footer(); ?>
