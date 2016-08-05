<header id="header" class="sticky-style-2">
  <div class="container clearfix">
    <div id="logo">
	<a href="<?php bloginfo('url'); ?>" class="standard-logo" data-dark-logo="<?php echo get_opt( 'logo_src'); ?>">
	<img src="<?php echo get_opt( 'logo_src'); ?>" alt="<?php bloginfo('name'); ?>" />	</a>
	<a href="<?php bloginfo('url'); ?>" class="retina-logo" data-dark-logo="<?php echo get_opt( 'logo_src_m'); ?>"><img src="<?php echo get_opt( 'logo_src_m'); ?>" alt="<?php bloginfo('name'); ?>"></a>
	</div>
    <div class="top-advert"> <?php echo get_opt('ads_banner_s') ? ''.get_opt('ads_banner').'' : '' ?> </div>
  </div>
  <div id="header-wrap">
    <nav id="primary-menu" class="style-2">
      <div class="container clearfix">
        <div id="primary-menu-trigger"><i class="fa fa-reorder"></i></div>
        <?php 
	  if(has_nav_menu('nav')){
	  	wp_nav_menu(
		   array(
		    'theme_location'  => 'nav',
		    'container' => '',
			'menu_class' => 'nav navbar-nav',
		   )
	  	);
	  }else{
	  		echo "<ul class='nav-menu pull-left'><li><a href='".get_bloginfo('url')."/wp-admin/nav-menus.php'>还没有设置导航菜单，请到后台 外观->菜单 设置一个导航菜单</a></li></ul>";
	  }
	 ?>
        <div id="top-search"> <a href="#" id="top-search-trigger"><i class="fa fa-search"></i><i class="fa fa-remove"></i></a>
          <form action="<?php bloginfo('home'); ?>" method="get">
            <input type="text" name="s" id="s" class="form-control" placeholder="输入搜索词语，回车确认搜索..">
          </form>
        </div>
      </div>
    </nav>
  </div>
</header>