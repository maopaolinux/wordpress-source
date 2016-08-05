<section id="slider" class="boxed-slider">

    <div class="fslider" data-easing="easeInQuad">
      <div class="flexslider">
        <div class="slider-wrap">
        <?php if (get_opt('slide_stt_s')) {
$args = array(
      'post_password' => '',
          'post_status' => 'publish', 
          'post__not_in' => array($post->ID),
          'caller_get_posts' => 1, 
          'orderby' => get_opt("slide_stt"), 
          'posts_per_page' => 6
);
        $query_posts = new WP_Query();
        $query_posts->query($args);
        while( $query_posts->have_posts() ) { $query_posts->the_post();?> 
        <div class="slide"> <a href="<?php the_permalink() ?>"> <img src="<?php plm_thumsrc(830,get_opt("slide_g")); ?>">
            <div class="flex-caption slider-caption-bg">
              <div class="text-overlay-title">
                <h3><?php the_title(); ?></h3>
              </div>
              <div class="text-overlay-meta"> <span><?php echo wp_trim_words( get_the_content(), 120 ); ?></span> </div></div>
            </a> </div>
          <?php } wp_reset_query();}else {for ($i=1; $i <=6 ; $i++) { ?>
          <div class="slide"> <a href="<?php echo get_opt('slide_href_'.$i.''); ?>"> <img src="<?php echo get_opt('slide_src_'.$i.''); ?>">
            <div class="flex-caption slider-caption-bg">
              <div class="text-overlay-title">
                <h3><?php echo get_opt('slide_title_'.$i.''); ?></h3>
              </div>
              <div class="text-overlay-meta"> <span><?php echo get_opt('slide_miaoshu_'.$i.''); ?></span> </div></div>
            </a> </div>
          <?php }}?>
        </div>
      </div>
    </div>

</section>
