<div class="postcontent nobottommargin clearfix">
  <div id="posts" class="post-timeline clearfix">
	<?php $posts = query_posts($query_string . "&posts_per_page=10"); ?>
    <?php while ( have_posts() ) : the_post(); ?>
    <div class="entry-image-big">
      <div class="entry-image">
        <?php if( get_opt('list_pic_s') ){plm_thumbnail(780,300);}else {plm_thumbnail(780,300);} ?>
      </div>
      <div class="entry-title">
        <h2><a <?php echo p_target_blank() ?> href="<?php the_permalink() ?>" title="<?php the_title(); ?> - <?php bloginfo('name'); ?>" data-toggle="tooltip" data-placement="top">
          <?php if (is_sticky()) { ?>
          <img src="<?php bloginfo('template_url'); ?>/images/sticky.gif"/>
          <?php } ?>
          <?php the_title(); ?>
          </a><span class="title-ts"><?php if ( get_post_meta($post->ID, 'tixing', true) ) : ?>
	<?php $copy = get_post_meta($post->ID, 'tixing', true); ?>
	<?php echo $copy ?>
	<?php else: ?>
	<?php endif; ?></span></h2>
      </div>
      <ul class="entry-meta clearfix">
        <li><i class="fa fa-clock-o"></i> <?php echo timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ) ?></li>
        <?php if (get_opt('p_author_s')){?><li><a <?php echo p_target_blank() ?> href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ) ?>" rel="nofollow"><i class="fa fa-user"></i> <?php echo get_the_author() ?></a></li><?php }?>
                 <?php if (get_opt('p_cat_s')){?><li><i class="fa fa-folder-open-o"></i><?php the_category(', ') ?></li><?php }?>
                 <?php if (get_opt('p_comm_s')){?><li><i class="fa fa-comments-o"></i><?php if ( comments_open() ) echo '<a href="'.get_comments_link().'">'.get_comments_number('0', '1', '%').'评论</a>';?></li><?php }?>
<li><i class="fa fa-eye"></i> <?php dms_views('℃'); ?></li>
      </ul>
      <div class="entry-content"> <?php echo wp_trim_words( get_the_content(), 80 ); ?> <a <?php echo p_target_blank() ?> href="<?php the_permalink() ?>" title="<?php the_title(); ?> - <?php bloginfo('name'); ?>" class="more-link-two" rel="nofollow">Read More</a> </div>
    </div>
    <?php endwhile; wp_reset_query(); ?>
  </div>
</div>
<?php dms_paging(); ?>
<?php if ( wp_is_mobile() ){ echo get_opt('adm_02_s') ? '<div class="adms">'.get_opt('adm_02').'</div>' : '';}else {echo get_opt('ads_02_s') ? '<div class="ads aligncenter">'.get_opt('ads_02').'</div>' : '';} ?>