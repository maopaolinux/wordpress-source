	<footer id="footer" class="dark">
  <div id="copyrights">
    <div class="container clearfix">
      <div class="col_half"> Copyright &copy; <?php echo date('Y'); ?> <a href="<?php bloginfo('url'); ?>">
        <?php bloginfo('name'); ?>
        </a> All rights reserved.&nbsp;|&nbsp;<?php echo get_opt( 'foot_copy')?></div>
      <div class="col_half col_last tright">
        <div class="fright clearfix"> <?php echo get_opt( 'ho2_icp')?> &nbsp;|&nbsp; <?php echo get_opt('trackcode')?> &nbsp;|&nbsp;
          <?php theme_c(); ?>
        </div>
      </div>
    </div>
  </div>
</footer>
</div>
<div id="gotoTop" class="fa fa-arrow-up"></div>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/functions.js"></script> 
<?php if ( is_single() || is_page()) { ?>
<script type="text/javascript">
window._bd_share_config = {
        common: {
            "bdText": "",
            "bdMini": "2",
            "bdMiniList": false,
            "bdPic": "",
            "bdStyle": "0"
        },
        share: [{
            bdCustomStyle: '<?php bloginfo('template_url');?>/css/share.css'
        }]
    }
    with(document) 0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion=' + ~(-new Date() / 36e5)];
function doZoom(size) {   
        var zoom = document.all ? document.all['primary'] : document.getElementById('primary');   
        zoom.style.fontSize = size + 'px';   
    } 
</script>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/magnific-popup.css" type="text/css" />
<?php } ?>
<?php echo get_opt('footcode')?>
<?php if ( wp_is_mobile() ){ echo get_opt('adm_03_s') ? '<div class="adms">'.get_opt('adm_03').'</div>' : '';} ?>
<?php wp_footer(); ?>
<?php if(get_opt('sideroll_s')){?>
<script type="text/javascript">
jQuery(document).ready(function(a){var c=<?php echo get_opt('sideroll_n_1')?>,d=<?php echo get_opt('sideroll_n_2')?>;(e=a("#sidebar").width(),f=a("#sidebar .widget"),g=f.length,g>=(c>0)&&g>=(d>0)&&a(window).scroll(function(){var b=document.documentElement.scrollTop+document.body.scrollTop;b>f.eq(g-1).offset().top+f.eq(g-1).height()?0==a(".roller").length?(f.parent().append('<div class="roller"></div>'),f.eq(c-1).clone().appendTo(".roller"),c!==d&&f.eq(d-1).clone().appendTo(".roller"),a(".roller").css({position:"fixed",<?php if(get_opt('head_style')=='five'){echo'top:5,';}else{echo'top: 62,';}?>zIndex:0,width:360}),a(".roller").width(e)):a(".roller").fadeIn(300):a(".roller").fadeOut(300)}))});</script><?php }?>
</body></html>