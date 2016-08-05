<?php get_header(); ?>
<section id="content">
<div <?php if ( wp_is_mobile() ){echo 'class="content-nosign"';}else{echo 'class="content-wrap"';} ?>>
<?php get_template_part( '/modules/sign' ); ?>
<?php	include('modules/blog.php');?>
</div>
</section>
<?php get_footer(); ?>
