<?php get_header(); ?>
<?php $posts = query_posts($query_string . "&posts_per_page=10"); ?>
<section id="content">
   <div <?php if ( wp_is_mobile() ){echo 'class="content-nosign"';}else{echo 'class="content-wrap"';} ?>>
    <?php if (get_opt('ho2_sign_s')) {include('modules/sign.php');}?>
    <div class="container clearfix">
      <div class="row">
        <div class="col-md-8">
        <div class="title-block">
                        <h3>关于 "<span><?php echo $s; ?></span>" 的搜索结果</h3>
                        <span><?php
	 global $wp_query;
	 echo '共为您找到 ' . $wp_query->found_posts . ' 篇相关文章';
	 ?></span>
                    </div>
        
        <form action="<?php bloginfo('home'); ?>" method="get" role="form" class="divcenter nobottommargin">
                    <div class="input-group input-group-lg">
                       <form action="<?php bloginfo('home'); ?>" method="get">
            <input type="text" name="s" id="s" class="form-control" placeholder="不如意，重新搜索">
          </form>
                    </div>
                </form>
          <?php if ( wp_is_mobile() ){ echo get_opt('adm_01_s') ? '<div class="adms">'.get_opt('adm_01').'</div>' : '';}else {echo get_opt('ads_01_s') ? '<div class="ads aligncenter">'.get_opt('ads_01').'</div>' : '';} 
		   include 'modules/lists-one.php';?>
        </div>
        <?php get_sidebar(); ?>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>
