<?php if (get_opt('header_dec_s')){//判断后台选项是否打开如果打开则显示，反之则否?>
<?php if(is_single()): //如果是文章页则显示《li》的内容?>
		<div class="section header-stick bottommargin-sm clearfix" style="padding: 20px 0;"><div>
             <div class="container clearfix">
		     <span class="label label-danger bnews-title"><i class="fa fa-file-text-o"></i></span>
		     <div class="bnews-slider nobottommargin">
		     <div class="slider-wrap">
		     <div id="code">文章内容</div>
		     </div>
		     </div>
             </div>
             </div>
            </div>
			<?php endif; ?>
			<?php if(is_page())://如果是页面则显示《li》的内容 ?>
			<div class="section header-stick bottommargin-sm clearfix" style="padding: 20px 0;"><div>
             <div class="container clearfix">
		     <span class="label label-danger bnews-title"><i class="fa fa-newspaper-o"></i>
			 </span>
		     <div class="bnews-slider nobottommargin">
		     <div class="container clearfix">
		     <div class="single-menus"><?php wp_nav_menu( array( 'theme_location' => 'pagemenu' ) );//选择菜单的代码 ?>
			 </div>
		     </div>
		     </div>
             </div>
             </div>
            </div>
			<?php endif; ?>
			<?php if(is_category())://如果是分类页则显示《li》的内容?>
			<div class="section header-stick bottommargin-sm clearfix" style="padding: 20px 0;"><div>
             <div class="container clearfix">
		     <span class="the-category">
			      <?php foreach((get_the_category()) as $cat)?>
                  <img src="<?php echo z_taxonomy_image_url($cat->term_id); ?>" />
			 </span>
		     <div class="bnews-slider nobottommargin">
		     <div class="slider-wrap">
		     <div class="category-title"><?php _e( '' );echo ' '; single_cat_title(); ?></div>
			 <div class="category-p"><?php echo category_description(); ?></div>
		     </div>
		     </div>
             </div>
             </div>
            </div>
			<?php endif; ?>
			<?php if(is_tag())://如果是tag页则显示《li》的内容?>
			<div class="section header-stick bottommargin-sm clearfix" style="padding: 20px 0;"><div>
             <div class="container clearfix">
		     <span class="label label-danger bnews-title"><?php single_tag_title(); ?></span>
		     <div class="bnews-slider nobottommargin">
		     <div class="slider-wrap">
		     <div id="code">的相关文章</div>
		     </div>
		     </div>
             </div>
             </div>
            </div>
			<?php endif; ?>
			<?php if(is_author())://如果是tag页则显示《li》的内容?>
			<div class="section header-stick bottommargin-sm clearfix" style="padding: 20px 0;"><div>
             <div class="container clearfix">
		     <span class="label label-danger bnews-title"><i class="fa fa-user"></i></span>
		     <div class="bnews-slider nobottommargin">
		     <div class="slider-wrap">
		     <div id="code">关于作者</div>
		     </div>
		     </div>
             </div>
             </div>
            </div>
			<?php endif; ?><?php }?>