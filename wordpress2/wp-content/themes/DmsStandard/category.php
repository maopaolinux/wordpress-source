<?php get_header(); ?>
<section id="content">

   <div <?php if ( wp_is_mobile() ){echo 'class="content-nosign"';}else{echo 'class="content-wrap"';} ?>>
    <?php get_template_part( '/modules/sign' ); ?>
    <div class="container clearfix">
      <div class="row">
        <div class="col-md-8">
          <?php if ( wp_is_mobile() ){ echo get_opt('adm_01_s') ? '<div class="adms">'.get_opt('adm_01').'</div>' : '';}else {echo get_opt('ads_01_s') ? '<div class="ads aligncenter">'.get_opt('ads_01').'</div>' : '';} ?>
           <?php
			if ( get_opt('archive_style') == 'big_thumb' || is_category(explode(',', get_opt('big_thumb') )) ) {//大图?>
			<?php include 'modules/mom/lists-two.php';?>
			<?php } elseif ( get_opt('archive_style') == 'ss_thumb' || is_category(explode(',', get_opt('ss_thumb') )) ) { //小图?>
			<?php include 'modules/mom/lists-ss.php';?>
			<?php } else { //默认?>
			<?php include 'modules/mom/lists-one.php';?>
			<?php } ?>
		</div>
        <?php get_sidebar(); ?>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>
