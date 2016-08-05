<div class="col-md-4">
<div id="sidebar" class="sidebar-widgets-wrap clearfix">
<div class="widget clearfix widget_tabs">
<?php if (get_opt('cx_author_s')){?>
<div class="single-author-a">
<?php echo get_avatar( get_the_author_email(), 84 ); ?>
</div><?php }?>
<div class="single-example">
<?php if (get_opt('author_s')){?>
<div class="single-description"><span>作者心情：</span><?php if(get_the_author_meta("description") != ""){the_author_meta("description");
   }else{
	   echo "该作者比较懒，什么也没有留下。";}
	?><?php }?></div>
</div>
<?php if( get_opt('ho2_copyright') ){  dms_copyright();  }  ?>
<?php echo get_opt('single_blog_x') ? '<div class="ads aligncenter">'.get_opt('single_blog_sing').'</div>' : '' ?>
</div>
</div>
