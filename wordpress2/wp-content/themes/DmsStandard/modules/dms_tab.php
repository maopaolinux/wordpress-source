<div class="tab-site">
	<div id="layout-tab" class="tab-product">
	    <h2 class="tab-hd">
		<span class="tab-hd-con"><a href="javascript:"><?php echo get_opt('tab_a'); ?></a></span>
		<span class="tab-hd-con"><a href="javascript:"><?php echo get_opt('tab_b'); ?></a></span>
		<span class="tab-hd-con"><a href="javascript:"><?php echo get_opt('tab_c'); ?></a></span>
	    </h2>
		<ul class="tab-bd dom-display">
		<div class="tab-bd-con current">
				<?php query_posts('showposts='.get_opt('tabt_n').'&cat='.get_opt('tabt_id')); while (have_posts()) : the_post(); ?>
				<?php the_title( sprintf( '<li class="list-title"><em class="tab-bd-em">'.get_the_time('m-d').'</em><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></li>' ); ?>
				<?php endwhile; ?>
				<?php wp_reset_query(); ?>
		</div>
		<div class="tab-bd-con">
				<?php query_posts('showposts='.get_opt('tabt_n').'&cat='.get_opt('tabz_n')); while (have_posts()) : the_post(); ?>
				<?php the_title( sprintf( '<li class="list-title"><em class="tab-bd-em">'.get_the_time('m-d').'</em><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></li>' ); ?>
				<?php endwhile; ?>
				<?php wp_reset_query(); ?>
		</div>
		<div class="tab-bd-con">
				<?php query_posts('showposts='.get_opt('tabt_n').'&cat='.get_opt('tabz_nn')); while (have_posts()) : the_post(); ?>
				<?php the_title( sprintf( '<li class="list-title"><em class="tab-bd-em">'.get_the_time('m-d').'</em><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></li>' ); ?>
				<?php endwhile; ?>
				<?php wp_reset_query(); ?>
		</div>
		</ul>
	</div>
</div>
<div class="clear"></div>
<script type="text/javascript">
$(document).ready(function(){
	$("#layout-tab span:first").addClass("current");
	$("#layout-tab .tab-bd-con:gt(0)").hide();
	$("#layout-tab span").mouseover(function(){
	$(this).addClass("current").siblings("span").removeClass("current");
	$("#layout-tab .tab-bd-con:eq("+$(this).index()+")").show().siblings(".tab-bd-con").hide().addClass("current");
	});
});
</script> 