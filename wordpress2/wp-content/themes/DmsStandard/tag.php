<?php get_header(); ?>
<?php $posts = query_posts($query_string . "&posts_per_page=10"); ?>
<section id="content">
  <div class="content-wrap">
  	<?php get_template_part( '/modules/sign' ); ?>
    <div class="container clearfix">
      <div class="row">
        <div class="col-md-8">
          <?php include 'modules/lists-'.get_opt('blog_style').'.php';?>
        </div>
        <?php get_sidebar(); ?>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>
