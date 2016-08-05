<!DOCTYPE html>
<html dir="ltr" lang="zh_CN">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="author" content="damoushi.com" />
<?php include('modules/seo.php'); ?>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/css.css" type="text/css" />
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/default.css" type="text/css" />
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" />
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/font-awesome.min.css" type="text/css" />
<?php if(get_opt('theme_skin') == '1FAEFF') {echo '';}
else {?><link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/colors/<?php echo get_opt('theme_skin')?>.css" type="text/css" /><?php }?>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<!--[if IE]>
<div class="browseupgrade">当前网页 <strong>不支持</strong> 您正在使用的浏览器。为了体验更好的访问效果， 请 <a href="http://browsehappy.com/" target="_blank">升级你的浏览器</a>.</div>
<![endif]-->
<!--[if lte IE 8]><div>请更换IE8以上的浏览器</div><![endif]-->
<!--[if lt IE 9]>
<script src="<?php bloginfo('template_url'); ?>/js/css3-mediaqueries.js"></script>
<![endif]-->
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/plugins.js"></script>
<script>
<?php if (get_opt('lazyload_s')){?>
$(function() {
        $("img").lazyload({
            effect:"fadeIn"
          });
        });
<?php }?>
    paceOptions = {
      elements: true
    };
  </script>
<style><?php echo get_opt('csscode')?></style>
<?php echo get_opt('headcode')?>
<?php wp_head();?>
</head>

<body class="no-transition <?php if (get_opt('head_style')== 'five'){echo 'side-header';}?>" >
 
<div id="wrapper" class="clearfix">
        <?php include('modules/style/head-'.get_opt('head_style').'.php') ;?>