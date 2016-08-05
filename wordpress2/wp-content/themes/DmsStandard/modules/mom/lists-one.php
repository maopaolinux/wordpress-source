<div id="posts" class="small-thumbs">
  <?php while ( have_posts() ) : the_post(); ?>
  <div class="entry entry-links clearfix" <?php if( get_opt('sliding_s') ){echo 'data-animate="'.get_opt('animation_style').'"';}?>>
      <?php if (has_post_format ('gallery')){ echo'<div class="entry-image"><div class="fslider" data-arrows="false"><div class="flexslider"><div class="slider-wrap">';
          all_img($post->post_content);
          echo'</div></div></div></div>';
       }else { 
	          echo '<div class="entry-image '.get_opt('thumb_left').'">';
			  if( get_opt('list_pic_s') ){plm_thumbnail(200,120);}else {plm_thumbnail(200,120);}
			  echo '</div>'; }?>
    <div class="entry-c">
	 <div class="entry-title"><h2>
 <?php if (get_opt('dms_cat_s')){?><div class="pos-tag"><?php the_category(', ') ?></div><?php }?>
		<a <?php echo p_target_blank() ?> href="<?php the_permalink() ?>" title="<?php the_title(); ?> - <?php bloginfo('name'); ?>" data-toggle="tooltip" data-placement="top"><?php the_title(); ?> <?php if (is_sticky()) { ?><img src="<?php bloginfo('template_url'); ?>/images/sticky.gif"/><?php } ?>
          </a><span class="title-ts"><?php $price = get_post_meta($post->ID, 'tixing_value', true);{ echo $price; }?></span></h2>
      </div>
      <ul class="entry-meta clearfix">
        <li><i class="fa fa-clock-o"></i> <?php echo timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ) ?></li>
        <?php if (get_opt('p_author_s')){?><li><a <?php echo p_target_blank() ?> href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ) ?>" rel="nofollow"><?php echo get_the_author() ?></a></li><?php }?>
                 <?php if (get_opt('p_comm_s')){?><li><?php if ( comments_open() ) echo '<a href="'.get_comments_link().'">'.get_comments_number('0', '1', '%').'评论</a>';?></li><?php }?>
<li><?php dms_views('℃'); ?></li>
<li><?php $price = get_post_meta($post->ID, 'tgzz_value', true);{echo $price; }?></li>
      </ul>
      <div class="entry-content">
        <p><?php if ( wp_is_mobile() ){echo wp_trim_words( get_the_content(), 40 );}else{echo wp_trim_words( get_the_content(), 70 );} ?></p>
		</div>
    </div>

  </div>
  <?php endwhile; wp_reset_query(); ?>
</div>
<?php dms_paging(); ?>
<?php if ( wp_is_mobile() ){ echo get_opt('adm_02_s') ? '<div class="adms">'.get_opt('adm_02').'</div>' : '';}else {echo get_opt('ads_02_s') ? '<div class="ads aligncenter">'.get_opt('ads_02').'</div>' : '';} ?>
