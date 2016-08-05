<?php get_header(); ?>
<section id="content">

   <div <?php if ( wp_is_mobile() ){echo 'class="content-nosign"';}else{echo 'class="content-wrap"';} ?>>
  <?php get_template_part( '/modules/sign' ); ?>
    <div class="container clearfix">
      <div class="row">
        <div class="col-md-8">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">以下文章由 <span>
                <?php the_author_posts_link(); ?>
                </span>发布</h3>
            </div>
            <div class="panel-body">
              <div class="author-image"> <?php echo get_avatar( get_the_author_email(), 84 ); ?> </div>
              <?php 
		 			if(get_the_author_meta("description") != ""){
		 				the_author_meta("description");
		 			}else{
		 				echo "这家伙很懒，什么都没写！";
		 			}
		 		?>
            </div>
          </div>
          <?php if ( wp_is_mobile() ){ echo get_opt('adm_01_s') ? '<div class="adms">'.get_opt('adm_01').'</div>' : '';}else {echo get_opt('ads_01_s') ? '<div class="ads aligncenter">'.get_opt('ads_01').'</div>' : '';} 
		   include 'modules/lists-'.get_opt('blog_style').'.php';?>
        </div>
        <?php get_sidebar(); ?>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>
