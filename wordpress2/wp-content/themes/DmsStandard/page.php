<?php get_header(); ?>
<section id="content">

  <div class="content-wrap">
   <?php get_template_part( '/modules/sign' ); ?>
    <div class="container clearfix">
      <div class="row">
        <div class="col-md-8 bottommargin">
        
          <?php if(have_posts()) : while (have_posts()) : the_post() ?>
          <div class="single-post nobottommargin">
            <div class="entry clearfix">
              <div class="page-titles">
			  <div class="entry-title">
                <h2>
                  <?php the_title(); ?>
                </h2>
              </div>
              <ul class="entry-meta clearfix">
                <li><i class="fa fa-calendar"></i> <?php echo timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ) ?></li>
                <?php if (get_opt('p_author_s')){?><li><i class="fa fa-user"></i> <?php the_author_posts_link(); ?></li><?php }?>
                 <?php if (get_opt('p_comm_s')){?><li><i class="fa fa-comments-o"></i> <?php if ( comments_open() ) echo '<a href="'.get_comments_link().'">'.get_comments_number('0', '1', '%').'评论</a>';?></li><?php }?>
                <li><i class="fa fa-eye"></i> <?php dms_views('℃'); ?></li>
                <li><?php edit_post_link('<i class="fa fa-edit"></i> 编辑', '  ', '  '); ?></li>
                <li class="fontResizer">
		字体：<a href="javascript:doZoom(<?php echo get_opt('single_fx');?>)" class="btn-xs">小</a><a href="javascript:doZoom(<?php echo get_opt('single_fz');?>)" class="btn-xs">中</a><a href="javascript:doZoom(<?php echo get_opt('single_fd');?>)" class="btn-xs">大</a>
	</li>
              </ul>
</div>
              <?php echo get_opt('ads_03_s') ? '<div class="ads aligncenter">'.get_opt('ads_03').'</div>' : '' ?>
              <div class="entry-content notopmargin">
                <?php the_content(); ?>
                <?php endwhile; endif; ?>
                <?php if( get_opt('ads_post_footer_s') ){ ?>
                <p class="asb-post-footer"><b>AD：</b><strong><a href="<?php echo get_opt('ads_post_footer_link');?>" <?php if( get_opt('ads_post_footer_link_blank') ){  echo 'target="_blank"';  } ?>><?php echo get_opt('ads_post_footer_title');?></a></strong></p>
                <?php } ?>
                
                <?php if( get_opt('ho2_copyright') ){  ho2_copyright();  }  ?>
            <?php if (get_opt('author_s')){?>
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">该文章由 <span>
                  <?php the_author_posts_link(); ?>
                  </span>发布<?php if( get_opt('ho2_share') ){  ho2_share();  }  ?></h3>
                  
              </div>
              <div class="panel-body">
                <div class="author-image"> <?php echo get_avatar( get_the_author_email(), 84 ); ?> </div>
                <?php 
		 			if(get_the_author_meta("description") != ""){
		 				the_author_meta("description");
		 			}else{
		 				echo "这货来去如风，什么鬼都没留下！！！";
		 			}
		 		?>
              </div>
            </div>
            <?php }?>
              </div>
            </div>
            
            
            
            <?php echo get_opt('ads_04_s') ? '<div class="ads aligncenter">'.get_opt('ads_04').'</div>' : '' ?>
            <div class="sigle-other"><?php if ( (!comments_open() && have_comments()) || comments_open() ): //如果评论功能开启则显示评论?>
        <?php comments_template( '', true ); //开启的评论规则?>

<?php else: //否则显示文章评论已关闭?>
<div class="single-comments"><a>此处评论已关闭</a></div>
<?php endif; ?></div>
            <?php echo get_opt('ads_05_s') ? '<div class="ads aligncenter">'.get_opt('ads_05').'</div>' : '' ?> </div>
        </div>
        <?php get_sidebar(); ?>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>
