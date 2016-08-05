<?php 
/*
	template name: 分类链接
	description: template for slmwp.com slmwp theme 
*/
get_header();?>

<section id="content">
  <div class="content-wrap">
<div class="section header-stick bottommargin-sm clearfix" style="padding: 20px 0;"><div>
             <div class="container clearfix">
		     <span class="label label-danger bnews-title"><?php the_title(); ?></span>
		     <div class="bnews-slider nobottommargin">
		     <div class="slider-wrap">
		     <div id="code"><ul class="entry-meta-pagas">
                <li><i class="fa fa-calendar"></i> <?php echo timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ) ?></li>
                <?php if (get_opt('p_author_s')){?>
                <li><i class="fa fa-user"></i>
                  <?php the_author_posts_link(); ?>
                </li>
                <?php }?>
                <?php if (get_opt('p_comm_s')){?>
                <li><i class="fa fa-comments-o"></i>
                  <?php if ( comments_open() ) echo '<a href="'.get_comments_link().'">'.get_comments_number('0', '1', '%').'评论</a>';?>
                </li>
                <?php }?>
                <li><i class="fa fa-eye"></i>
                  <?php dms_views('℃'); ?>
                </li>
                <li>
                  <?php edit_post_link('<i class="fa fa-edit"></i> 编辑', '  ', '  '); ?>
                </li>
              </ul></div>
		     </div>
		     </div>
             </div>
             </div>
            </div>
    <div class="container clearfix">
      <div class="row">
        <div class="col-md-9 bottommargin">
          <?php while (have_posts()) : the_post() ?>
          <div class="single-post nobottommargin">
            <div class="entry clearfix">
              <div id="primary" class="entry-content notopmargin">
                <?php the_content(); ?>
				<?php echo get_link_items(); ?>
                <?php endwhile; ?>
              </div>
            </div>
            <div class="sigle-other">
           <?php if ( (!comments_open() && have_comments()) || comments_open() ): //如果评论功能开启则显示评论?>
        <?php comments_template( '', true ); //开启的评论规则?>

<?php else: //否则显示文章评论已关闭?>
<div class="single-comments"><a>此处评论已关闭</a></div>
<?php endif; ?>
            </div>
          </div>
        </div>
        <?php get_template_part( 'widget_tao', 'small' ); ?>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>
