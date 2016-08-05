<?php get_header(); ?>
<section id="content">

  <div class="content-wrap">
    <?php if (get_opt('ho2_sign_s')) {include('modules/sign.php');}?>
    <div class="container clearfix">

                    <div class="col_half nobottommargin">
                        <div class="error404 center">404</div>
                    </div>

                    <div class="col_half nobottommargin col_last">

                        <div class="heading-block nobottomborder">
                            <h4>抱歉，页面找不到了。</h4>
                            <span>搜索试试</span>
                        </div>

                        <form action="<?php bloginfo('home'); ?>" method="get" role="form" class="nobottommargin">
                            <div class="input-group input-group-lg">
                                <input type="text" class="form-control" name="s" id="s" placeholder="输入关键词搜索...">
                                <span class="input-group-btn">
                                    <button class="btn btn-danger" type="button">搜索</button>
                                </span>
                            </div>
                        </form>
                    </div>

                </div>
  </div>
</section>
<?php get_footer(); ?>
