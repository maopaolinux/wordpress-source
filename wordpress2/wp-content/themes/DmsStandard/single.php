<?php get_header(); ?>
<section id="content">
   <div <?php if ( wp_is_mobile() ){echo 'class="content-nosign"';}else{echo 'class="content-wrap"';} ?>>
   <?php get_template_part( '/modules/sign' ); ?>
    <div class="container clearfix">
	<script type="text/javascript">
 var documentHeight = 0;
 var topPadding = 120;
 $(function() {
 var offset = $(".single-post-author").offset();
 documentHeight = $(document).height();
 $(window).scroll(function() {
 var sideBarHeight = $(".single-post-author").height();
 if ($(window).scrollTop() > offset.top) {
 var newPosition = ($(window).scrollTop() - offset.top) + topPadding;
 var maxPosition = documentHeight - (sideBarHeight + 668);
 if (newPosition > maxPosition) {
 newPosition = maxPosition;
 }
 $(".single-post-author").stop().animate({
 marginTop: newPosition
 });
 } else {
 $(".single-post-author").stop().animate({
 marginTop: 0
 });
 };
 });
 });</script>
      <div class="row">
        <div class="col-md-8 bottommargin">
          <?php while (have_posts()) : the_post() ?>
          <div class="single-post nobottommargin">
		  	  <?php if (get_opt('author_five')){?><?php if (get_opt('author_s')){?>
	<div class="single-post-author">
        <?php echo get_avatar( get_the_author_email(), 84 ); ?>
<div class="panel-title"><span>
                  <?php the_author_posts_link(); ?>
                  </span>
				  <?php if (get_opt('p_cat_s')){?><p><?php the_category(', ') ?></p><?php }?>
				  </div>
	</div><?php }?><?php }?>
            <div class="entry clearfix">
			<div class="entry-titles">
              <div class="entry-title">
                <h2><?php the_title(); ?></h2>
              </div>
              <ul class="entry-meta clearfix">
			  <span><?php the_category(', ') ?></span>
                <span><?php echo timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ) ?></span>
                <?php if (get_opt('p_author_s')){?><span><?php the_author_posts_link(); ?></span><?php }?>
                 <?php if (get_opt('p_comm_s')){?><span><?php if ( comments_open() ) echo '<a href="'.get_comments_link().'">'.get_comments_number('0', '1', '%').'评论</a>';?></span>
				 <span><?php dms_views('℃'); ?></span>
				 <?php }?>
                 <?php if (get_opt('source_s')){
                 	echo '<span><i class="fa fa-copyright"></i>来源：';
                 		$come = get_post_meta($post->ID, "_meta_come_value", true);
                 		$curl = get_post_meta($post->ID, '_meta_curl_value', true);
						if($come) {
							echo '<a href="'.$curl.'" target="blank" rel="nofllow">'.$come.'</a>';
						}else {
							echo '本站原创';
						}
                 	echo '</span>';
				 }?>
                 	
                
                <?php edit_post_link('<li class="editor"><i class="fa fa-edit"></i> 编辑</li>', '  ', '  '); ?>
              </ul>
			  </div>
              <div id="primary" class="entry-content notopmargin">
                <?php if ( wp_is_mobile() ){ echo get_opt('adm_01_s') ? '<div class="adms">'.get_opt('adm_01').'</div>' : '';}else {echo get_opt('ads_03_s') ? '<div class="ads aligncenter">'.get_opt('ads_03').'</div>' : '';} ?>
                <?php the_content();?>                     
                <?php wp_link_pages(array('before' => '<div class="fenye">', 'after' => '', 'next_or_number' => 'next', 'previouspagelink' => '<span>上一页</span>', 'nextpagelink' => "")); ?>
                <?php wp_link_pages(array('before' => '', 'after' => '', 'next_or_number' => 'number', 'link_before' =>'<span>', 'link_after'=>'</span>')); ?>   
                <?php wp_link_pages(array('before' => '', 'after' => '</div>', 'next_or_number' => 'next', 'previouspagelink' => '', 'nextpagelink' => "<span>下一页</span>")); ?>
                
                <?php endwhile; ?>
                <?php if( get_opt('ads_post_footer_s') ){ ?>
                <p class="asb-post-footer"><b>推荐：</b><strong><a href="<?php echo get_opt('ads_post_footer_link');?>" <?php if( get_opt('ads_post_footer_link_blank') ){  echo 'target="_blank"';  } ?>><?php echo get_opt('ads_post_footer_title');?></a></strong></p>
                <?php } ?>
				<div class="zdy-menu">
				<?php 
	  if(has_nav_menu('qitanav')){
	  	wp_nav_menu(
		   array(
		    'theme_location'  => 'qitanav',
		    'container' => '',
			'menu_class' => 'sf-js-enabled clearfix',
		   )
	  	);
	  }else {
       echo "文章已完";
   }
	 ?>
				</div>
                  <div class="article-tags">
              <span> 标签:</span><?php the_tags('',''); ?>
            </div>
<div class="single-example">
   <?php if (get_opt('author_s')){?>
<div class="single-description"><span>作者心情：</span><?php if(get_the_author_meta("description") != ""){the_author_meta("description");
   }else{
	   echo "这货来去如风，什么鬼都没留下！！！";}
	?><?php }?></div>
    <?php if (get_opt('baidu_share')){?>
	<?php if( get_opt('baidu_share') ){  dms_share();  }  ?>
	<?php }?>
</div>
<?php if( get_opt('ho2_copyright') ){  ho2_copyright();  }  ?>
</div>
</div>          
<div class="post-navigation">
              			<div class="post-previous"><?php if (get_previous_post()) { previous_post_link('<i class="fa fa-angle-double-left"></i> %link');} else {echo " 已经是最后文章";} ?></div>
              			<div class="post-next"><?php if (get_next_post()) { next_post_link('%link <i class="fa fa-angle-double-right"></i>');} else {echo "已经是最新文章 ";} ?></div>
              		</div>
                        
            <?php if ( wp_is_mobile() ){ echo get_opt('adm_02_s') ? '<div class="adms">'.get_opt('adm_02').'</div>' : '';}else {echo get_opt('ads_04_s') ? '<div class="ads aligncenter">'.get_opt('ads_04').'</div>' : '';} ?>
            
	<?php if (get_opt('rel_type')== 'one'){?>

<?php if( get_opt('ho2_related_s') ){ '<div class="sigle-other">'. dms_posts_related( get_opt('ho2_related_title'), get_opt('ho2_related_n') ).'</div>'; }  ?> 
<?php } else {?>
<ul class="related_post">
<h3><?php echo get_opt('ho2_related_title');?></h3>
<?php
$post_num = get_opt('ho2_related_n');//调用数量函数
$exclude_id = $post->ID;
$posttags = get_the_tags(); $i = 0;
if ( $posttags ) {
	$tags = ''; foreach ( $posttags as $tag ) $tags .= $tag->term_id . ',';
	$args = array(
		'post_status' => 'publish',
		'tag__in' => explode(',', $tags),
		'post__not_in' => explode(',', $exclude_id),
		'caller_get_posts' => 1,
		'orderby' => 'comment_date',
		'posts_per_page' => $post_num,
	);
	query_posts($args);
	while( have_posts() ) { the_post(); ?>
		<li><a rel="bookmark" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" target="_blank"><?php the_title(); ?></a></li>
	<?php
		$exclude_id .= ',' . $post->ID; $i ++;
	} wp_reset_query();
}
if ( $i < $post_num ) {
	$cats = ''; foreach ( get_the_category() as $cat ) $cats .= $cat->cat_ID . ',';
	$args = array(
		'category__in' => explode(',', $cats),
		'post__not_in' => explode(',', $exclude_id),
		'caller_get_posts' => 1,
		'orderby' => 'comment_date',
		'posts_per_page' => $post_num - $i
	);
	query_posts($args);
	while( have_posts() ) { the_post(); ?>
		<li><a rel="bookmark" href="<?php the_permalink(); ?>"  title="<?php the_title(); ?>" target="_blank"><?php the_title(); ?></a></li>
	<?php $i++;
	} wp_reset_query();
}
if ( $i  == 0 )  echo '<li>没有相关文章!</li>';
?>
</ul>
	<?php }?>
			
			
			
			<div class="comments_bg"><?php if ( (!comments_open() && have_comments()) || comments_open() ): //如果评论功能开启则显示评论?>
        <?php comments_template( '', true ); //开启的评论规则?>

<?php else: //否则显示文章评论已关闭?>
<div class="single-comments"><a>文章评论已关闭</a></div>
<?php endif; ?>
            </div>
            <?php echo get_opt('ads_05_s') ? '<div class="ads aligncenter">'.get_opt('ads_05').'</div>' : '' ?> </div>
        </div>
        <?php get_sidebar(); ?>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>
