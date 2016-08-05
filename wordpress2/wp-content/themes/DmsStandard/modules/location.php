<section id="page-title">
  <div class="container clearfix">
    <h1 data-animate="fadeInUp" class="fadeInUp animated">
      <?php 
	  if (is_author ()){
                	the_author(); echo "发布的文章";
                } else{
					single_cat_title();}
                 ?></h1>
    <ol class="breadcrumb fadeInUp animated" data-animate="fadeInUp" data-delay="300">
      <li><a href="<?php bloginfo('url'); ?>">首 页</a></li>
      <li>
        <?php
        if( is_single() ){
            $categorys = get_the_category();
            $category = $categorys[0];
            echo( get_category_parents($category->term_id,true,' >') );echo $s.' 查看文章';
        } elseif ( is_home() ){
            
        } elseif ( is_page() ){
            the_title();
        } elseif ( is_category() ){
            single_cat_title();
        } elseif ( is_tag() ){
            single_tag_title();
        } elseif ( is_day() ){
            the_time('Y年Fj日');
        } elseif ( is_month() ){
            the_time('Y年F');
        } elseif ( is_year() ){
            the_time('Y年');
        } elseif ( is_search() ){
            echo $s.' 的搜索结果';
        } elseif ( is_author() ){
        	the_author_posts_link(); ?>
        <?php echo '发表的所有文章';
        }
    ?></li>
    </ol>
  </div>
</section>
