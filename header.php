<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Senior Full Stack Developer &amp; Tech Lead with 7+ years of experience in PHP, WordPress, Laravel and WooCommerce. Open to remote roles.">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<nav role="navigation" aria-label="Primary navigation">
    <a href="<?php echo esc_url(home_url('/')); ?>#hero" class="nav-logo">
        V<span class="twofa">2FA</span>.
    </a>
    <ul class="nav-links">
        <li><a href="#about">About</a></li>
        <li><a href="#how-i-work">Process</a></li>
        <li><a href="#projects">Projects</a></li>
        <li><a href="#experience">Experience</a></li>
        <li><a href="#contact">Contact</a></li>
    </ul>
</nav>
