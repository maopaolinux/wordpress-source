<?php 
/*
	template name: 留言板
	description: template for damoushi.com damoushi theme 
*/
get_header();?>

<section id="content">
  <div class="content-wrap">
    <?php if (get_opt('ho2_sign_s')) {include('modules/sign.php');}?>
    <div class="container clearfix">
      <div class="row">
        <div class="col-md-9 bottommargin">
          <?php while (have_posts()) : the_post() ?>
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
                
              </ul>
			  </div>
              <div id="primary" class="entry-content notopmargin">
				<?php the_content(); ?>
                
<?php
$query="SELECT COUNT(comment_ID) AS cnt, comment_author, comment_author_url, comment_author_email FROM (SELECT * FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->posts.ID=$wpdb->comments.comment_post_ID) WHERE comment_date > date_sub( NOW(), INTERVAL 24 MONTH ) AND user_id='0' AND comment_author_email != '你的邮箱' AND post_password='' AND comment_approved='1' AND comment_type='') 
AS tempcmt GROUP BY comment_author_email ORDER BY cnt DESC LIMIT ".get_opt('book_num'); 
$wall = $wpdb->get_results($query);
$maxNum = $wall[0]->cnt;
foreach ($wall as $comment)
 {
 $width = round(40 / ($maxNum / $comment->cnt),2);//此处是对应的血条的宽度
 if( $comment->comment_author_url )
 $url = $comment->comment_author_url;
 else $url="#";
 $avatar = get_avatar( $comment->comment_author_email, $size = '36', $default=   get_bloginfo('template_directory').'/images/userimg.jpg' );
 $tmp = "<li style=\"width: ".get_opt('book_kd')."px\"><a target=\"_blank\" href=\"".$comment->comment_author_url."\" rel=\"nofollow\">".$avatar."<em>".$comment->comment_author."</em> <strong>+".$comment->cnt."</strong></br>".$comment->comment_author_url."</a></li>";
 $output .= $tmp;
}
 $output = "<ul class=\"readers-list\">".$output."</ul>";
 echo $output ;
?>
                <?php endwhile; ?>
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
            <div class="sigle-other"><?php if ( (!comments_open() && have_comments()) || comments_open() ): //如果评论功能开启则显示评论?>
        <?php comments_template( '', true ); //开启的评论规则?>

<?php else: //否则显示文章评论已关闭?>
<div class="single-comments"><a>此处评论已关闭</a></div>
<?php endif; ?></div>
          </div>
        </div>
        <?php get_template_part( 'sidebar', 'small' ); ?>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>