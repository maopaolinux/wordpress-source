<div class="container clearfix"><div class="row">
  <div class="col-md-8">
    <?php if( get_opt('slide_s') ){ include('silder-dms.php'); }?>
    <?php if( get_opt('ho2_toplists') ){ include('top.php'); }?>
    <?php 
		if( $paged && $paged > 1 ){
			printf('<div class="heading-block"><h2>最新发布 <span>第'.$paged.'页</span></h2></div>');
		}else{			
		printf('<div class="heading-block"><h2>最新发布</h2></div>');
		}
		if ( wp_is_mobile() ){ echo get_opt('adm_01_s') ? '<div class="adms">'.get_opt('adm_01').'</div>' : '';}else {echo get_opt('ads_01_s') ? '<div class="ads aligncenter">'.get_opt('ads_01').'</div>' : '';} 

		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$args = array(
		    'caller_get_posts' => 1,
		    'paged' => $paged
		);
		query_posts($args);
		include 'lists-one.php'; 
	?>
	<?php if (get_opt('tab_h')) { ?>
	<?php get_template_part( '/modules/dms_tab' ); ?>
	<?php } ?>
  </div>
  <?php get_sidebar(); ?>
</div></div>
<div id="content">
	<?php if (get_opt('dms_blog_category')){?>
    <?php include(TEMPLATEPATH . '/table/blog_cms_ca.php' ); ?>
    <?php }?>
</div>