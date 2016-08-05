<div class="cat-blog-cms">
<?php echo get_opt('ads_07_s') ? '<div class="ads aligncenter">'.get_opt('ads_07').'</div>' : '' ?>
<div class="container clearfix">
  <?php 
  $str = get_opt('category-blog'); 
  $display_categories = explode(",",$str);
  foreach ($display_categories as $key=>$cate)
{ 
    $args = array(
      'posts_per_page' => ''.get_opt('category_n_blog').'',
      'tax_query' => array(
        'relation' => 'OR',
        array(
          'taxonomy' => 'category',
          'field' => 'id',
          'terms' => $cate
        ),
      )
    );
   $query = new WP_Query( $args );
   $i=0;
   if ($post->post_type == 'post') {
          	  	$taxonomy = 'category';
          }
          $term = get_term($cate,$taxonomy);
          $cat_name = $term->name;
          $cat_link = get_term_link($term,$taxonomy );
?>
  <div class="col-xs-12 col-md-4 cms-one">
    <div class="cms-title"> <span class="icon"><i class="<?php echo get_opt( 'cat_icon')?>"></i></span>
      <h3><?php echo "$cat_name"; ?></h3>
    <span class="cat-links"><a href="<?php echo $cat_link; ?>">更多</a></span>
	</div>
    <?php 
          while ($query->have_posts()) : $query->the_post();
          $i++;{
      ?>
    <div class="cms-one-list">
      <div class="spost clearfix">
        <div class="entry-image"> <?php plm_thumbnail(60,60); ?> </div>
        <div class="entry-c">
          <div class="entry-title">
            <h4><a title="<?php the_title_attribute(); ?>" href="<?php the_permalink() ?>">
              <?php the_title(); ?>
              </a></h4>
          </div>
          <ul class="entry-meta">
            <li><i class="fa fa-clock-o"></i> <?php echo get_the_time('Y-m-d') ?></li>
            <li><i class="fa fa-comments"></i>
              <?php
				if (comments_open())
					echo '<a href="' . get_comments_link() . '">' . get_comments_number('0', '1', '%') . '评论</a>';
		?>
            </li>
            <li><i class="fa fa-eye"></i>
              <?php dms_views('℃'); ?>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <?php } endwhile; wp_reset_query(); ?>
  </div>
  <?php } ?>
</div>
<?php echo get_opt('ads_08_s') ? '<div class="ads aligncenter">'.get_opt('ads_08').'</div>' : '' ?>
</div>