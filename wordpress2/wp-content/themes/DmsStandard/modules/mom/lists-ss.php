<div class="postcontent nobottommargin clearfix">
  <div id="posts" class="post-timeline clearfix">
    <div class="timeline-border"></div>
	<?php $posts = query_posts($query_string . "&posts_per_page=10"); ?>
    <?php while ( have_posts() ) : the_post(); ?>
    <div class="entry clearfix" <?php if( get_opt('sliding_s') ){echo 'data-animate="'.get_opt('animation_style').'"';}?>>
      <div class="lists-sky">
        <?php the_time('d'); ?>
        <span><?php echo date('M',get_the_time('U'));?></span>
        <div class="timeline-divider"></div>
      </div>
      <div class="entry-content-ss"> <?php echo wp_trim_words( get_the_content(), 90 ); ?> <a <?php echo p_target_blank() ?> href="<?php the_permalink() ?>" title="<?php the_title(); ?> - <?php bloginfo('name'); ?>" class="more-link-two" rel="nofollow">Read More</a> </div>
    </div>
    <?php endwhile; wp_reset_query(); ?>
  </div>
</div>
<?php dms_paging(); ?>
<?php if ( wp_is_mobile() ){ echo get_opt('adm_02_s') ? '<div class="adms">'.get_opt('adm_02').'</div>' : '';}else {echo get_opt('ads_02_s') ? '<div class="ads aligncenter">'.get_opt('ads_02').'</div>' : '';} ?>