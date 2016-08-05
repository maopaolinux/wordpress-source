<?php
//短代码内链
function fa_insert_posts( $atts, $content = null ){
    extract( shortcode_atts( array(

        'ids' => ''

    ),
        $atts ) );
    global $post;
    $content = '';
    $postids =  explode(',', $ids);
    $inset_posts = get_posts(array('post__in'=>$postids));
    foreach ($inset_posts as $key => $post) {
		setup_postdata( $post );
        $content .=  
		'
		<div class="dmsembed">
<a>'.get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'MFW_author_bio_avatar_size', 64 ) ).'</a>
		<h10><a target="_blank" href="' . get_permalink() . '">' . get_the_title() . '</a></h10>
		<div class="dmsembed-p">'.wp_trim_words( get_the_content(), 80 ).'</div>
		<div class="dms-meta">
		<span>作者：<a href="'.get_author_posts_url( get_the_author_meta( 'ID' ) ).'">' . get_the_author(). '&nbsp;&nbsp;</a></span>
		<span>来自：' . get_the_category_list( ', ' ). '&nbsp;&nbsp;</span>
		<span>' . get_comments_number(). '&nbsp;&nbsp;<i class="icon-comments"></i></span>
		
</div>

		</div>';
    }
    wp_reset_postdata();
    return $content;
	
}
add_shortcode('fa_insert_post', 'fa_insert_posts');
add_action( 'after_setup_theme', 'ho2_setup' );
function ho2_setup(){
	//去除头部冗余代码
	remove_filter( 'the_content', array( $GLOBALS['wp_embed'], 'autoembed' ), 8 );
	remove_action( 'wp_head',   'feed_links_extra', 3 ); 
	remove_action( 'wp_head',   'rsd_link' ); 
	remove_action( 'wp_head',   'wlwmanifest_link' ); 
	remove_action( 'wp_head',   'index_rel_link' ); 
	remove_action( 'wp_head',   'start_post_rel_link', 10, 0 ); 
	
	add_filter('xmlrpc_enabled', '__return_false');
	//添加背景按钮
	//add_theme_support( 'custom-background' );
	//隐藏admin Bar
	add_filter('show_admin_bar','hide_admin_bar');
	//自动勾选评论回复邮件通知，不勾选则注释掉 
	add_action('comment_form','ho2_add_checkbox');
	//添加文档类型
    add_theme_support( 'post-formats', array(
	 'video','gallery', 'audio','link',
	) );
	//评论回复邮件通知
	add_action('comment_post','comment_mail_notify'); 
    //默认表情添加nofollow
    add_filter('wp_tag_cloud','tag_cloud_nofollow');
    //评论表情改造，如需更换表情，images/smilies/下替换
	add_filter('smilies_src','ho2_smilies_src',1,10);
	//去除自带js
	wp_deregister_script( 'l10n' ); 
	//修改默认发信地址
	add_filter('wp_mail_from', 'ho2_res_from_email');
	add_filter('wp_mail_from_name', 'ho2_res_from_name');
	add_action( 'pre_ping', 'ho2_noself_ping' ); 
	add_filter( 'pre_option_link_manager_enabled', '__return_true' );
	//定义菜单
	if (function_exists('register_nav_menus')){
		register_nav_menus( array(
			'nav' => __('网站导航'),
			'pagemenu' => __('页面导航'),
			'topnav' => __('顶部导航'),
			'qitanav' => __('文章页结束导航'),
		));
	}
}

// 添加特色图像功能
add_theme_support('post-thumbnails');
set_post_thumbnail_size(280, 150, true); // 图片宽度与高度
//修改默认发信地址
function ho2_res_from_email($email) {
	$wp_from_email = get_option('admin_email');
	return $wp_from_email;
}
function ho2_res_from_name($email){
	$wp_from_name = get_option('blogname');
	return $wp_from_name;
}
 // Remove Open Sans that WP adds from frontend 
if (!function_exists('remove_wp_open_sans')) : 
function remove_wp_open_sans() { 
wp_deregister_style( 'open-sans' ); 
wp_register_style( 'open-sans', false ); 
}
// 前台删除Google字体CSS 
add_action('wp_enqueue_scripts', 'remove_wp_open_sans');
// 后台删除Google字体CSS 
add_action('admin_enqueue_scripts', 'remove_wp_open_sans'); 
endif;
function hide_admin_bar($flag) {
	return false;
}
//baidu分享
function dms_share(){
  echo '<div class="share noborder clearfix"><div class="bdsharebuttonbox"><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_sqq" data-cmd="sqq" title="分享到QQ好友"></a><a href="#" class="bds_bdhome" data-cmd="bdhome" title="分享到百度新首页"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a></a><a href="#" class="bds_kaixin001" data-cmd="kaixin001" title="分享到开心网"></a><a href="#" class="bds_taobao" data-cmd="taobao" title="分享到我的淘宝"></a><a href="#" class="bds_douban" data-cmd="douban" title="分享到豆瓣网"></a><a href="#" class="bds_mail" data-cmd="mail" title="分享到邮件分享"></a><a href="#" class="bds_copy" data-cmd="copy" title="分享到复制网址"></a><a class="bds_more" data-cmd="more"><span>更多</span></a> <a href="#" class="bds_more" data-cmd="more"></a></div></div>
';
}
//文章（包括feed）末尾加版权说明
function ho2_copyright() {
 echo '<div class="style-msg2 sigle_copy" ><div class="msgtitle">'.get_opt('ho2_copyright_title').'</div><div class="sb-msg"><ul> <li>转载请注明来源：<a title="'.get_the_title().'" data-toggle="tooltip" data-placement="top" data-hover="'.get_the_title().'" href="'.get_permalink().'">'.get_the_title().'</a></li><li>本文永久链接地址：'.get_permalink().'</li></ul></div></div>';
}
function ludou_remove_wp_version() {
  return '';
}
add_filter('the_generator', 'ludou_remove_wp_version');
//文章（包括feed）末尾加版权说明
function dms_copyright() {
 echo '<div class="style-msg3 sigle_copy" ><div class="msgtitle">'.get_opt('ho2_copyright_title').'</div><div class="sb-msg"><ul> <li>转载请注明来源：<a title="'.get_the_title().'" data-toggle="tooltip" data-placement="top" data-hover="'.get_the_title().'" href="'.get_permalink().'">'.get_the_title().'</a></li><li>本文永久链接地址：'.get_permalink().'</li></ul></div></div>';
}

// 隐藏js/css附加的WP版本号
function plm_remove_wp_version_strings( $src ) {
  global $wp_version;
  parse_str(parse_url($src, PHP_URL_QUERY), $query);
  if ( !empty($query['ver']) && $query['ver'] === $wp_version ) {
    $src = str_replace($wp_version, $wp_version + 1.8, $src);
  }
  return $src;
}
add_filter( 'script_loader_src', 'plm_remove_wp_version_strings' );
add_filter( 'style_loader_src', 'plm_remove_wp_version_strings' );
//移除菜单的多余CSS选择器
add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1);
add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1);
add_filter('page_css_class', 'my_css_attributes_filter', 100, 1);
function my_css_attributes_filter($var) {
	return is_array($var) ? array_intersect($var, array('current-menu-item','current-post-ancestor','current-menu-ancestor','current-menu-parent')) : '';
}
//时间显示方式'xx以前'
function time_ago( $type = 'commennt', $day = 7 ) {
  $d = $type == 'post' ? 'get_post_time' : 'get_comment_time';
  if (time() - $d('U') > 60*60*24*$day) return;
  echo ' (', human_time_diff($d('U'), strtotime(current_time('mysql', 0))), '前)';
}
//修改评论表情调用路径
function ho2_smilies_src ($img_src, $img, $siteurl){
	return get_bloginfo('template_directory').'/images/smilies/'.$img;
}

//评论添加表情
function wp_smilies() {
	global $wpsmiliestrans;
	if ( !get_option('use_smilies') or (empty($wpsmiliestrans))) return;
	$smilies = array_unique($wpsmiliestrans);
	$link='';
	foreach ($smilies as $key => $smile) {
		$file = get_bloginfo('template_directory').'/images/smilies/'.$smile;
		$value = " ".$key." ";
		$img = "<img src=\"{$file}\" alt=\"{$smile}\" />";
		$imglink = htmlspecialchars($img);
		$link .= "<a href=\"#commentform\" title=\"{$smile}\" onclick=\"document.getElementById('comment').value += '{$value}'\">{$img}</a>&nbsp;";
	}
	echo '<div id="smilelink">'.$link.'</div>';
}

    //图片添加alt属性
    function image_alt( $imgalt ){
            global $post;
            $title = $post->post_title;
            $imgUrl = "<img\s[^>]*src=(\"??)([^\" >]*?)\\1[^>]*>";
            if(preg_match_all("/$imgUrl/siU",$imgalt,$matches,PREG_SET_ORDER)){
                    if( !empty($matches) ){
                            for ($i=0; $i < count($matches); $i++){
                                    $tag = $url = $matches[$i][0];
                                    $judge = '/alt=/';
                                    preg_match($judge,$tag,$match,PREG_OFFSET_CAPTURE);
                                    if( count($match) < 1 )
                                    $altURL = ' alt="'.$title.'" ';
                                    $url = rtrim($url,'>');
                                    $url .= $altURL.'>';
                                    $imgalt = str_replace($tag,$url,$imgalt);
                            }
                    }
            }
            return $imgalt;
    }
    add_filter( 'the_content','image_alt');
//自动勾选 
function ho2_add_checkbox() {
}
function timeago( $ptime ) {
    $ptime = strtotime($ptime);
    $etime = time() - $ptime;
    if($etime < 1) return '刚刚';
    $interval = array (
        12 * 30 * 24 * 60 * 60  =>  '年前 ('.date('Y-m-d', $ptime).')',
        30 * 24 * 60 * 60       =>  '个月前 ('.date('m-d', $ptime).')',
        7 * 24 * 60 * 60        =>  '周前 ('.date('m-d', $ptime).')',
        24 * 60 * 60            =>  '天前',
        60 * 60                 =>  '小时前',
        60                      =>  '分钟前',
        1                       =>  '秒前'
    );
    foreach ($interval as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . $str;
        }
    };
}
//阻止站内文章Pingback 
function ho2_noself_ping( &$links ) {
  $home = get_option( 'home' );
  foreach ( $links as $l => $link )
  if ( 0 === strpos( $link, $home ) )
  unset($links[$l]);
}
function seo_post($post_id){
    global $post;
     $description = get_post_meta($post_id, 'description_value', true);
     $keywords = get_post_meta($post_id, 'keywords_value', true);
     if (empty($description)) {
        if(preg_match('/<p>(.*)<\/p>/iU',trim(strip_tags($post->post_content,"<p>")),$result)){
            $post_content = $result['1'];
        }else {
            $post_content_r = explode("\n",trim(strip_tags($post->post_content)));
            $post_content = $post_content_r['0'];
        }
        $description = utf8Substr($post_content,0,220); 
        update_post_meta($post_id,"description_value",$description); 
     }
     if (empty($keywords)) {
        $post_type = $post->post_type;
        if ($post_type == 'post') {
            $tax = 'post_tag';
        }
        $tags = wp_get_object_terms($post_id, $tax);
        foreach ($tags as $tag ) {
            $keywords = $keywords . $tag->name . ",";
        }
        update_post_meta($post_id,"keywords_value",$keywords);
     }
}
add_action('save_post', 'seo_post');
//添加文章编辑页选项

function deletehtml($description) {
    $description = trim($description);
    $description = strip_tags($description,"");
    return ($description);
}
add_filter('category_description', 'deletehtml');
function utf8Substr($str, $from, $len){
    return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'.
    '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s',
    '$1',$str);
}
/* 搜索结果排除所有页面
/* --------------------- */
function search_filter_page($query) {
	if ($query->is_search) {
		$query->set('post_type', 'post');
	}
	return $query;
}
add_filter('pre_get_posts','search_filter_page');


//移除自动保存
function ho2_disable_autosave() {
  wp_deregister_script('autosave');
}
//禁止加载默认jq库
if ( !is_admin() ) { // 后台不禁止
function my_init_method() {
wp_deregister_script( 'jquery' ); // 取消原有的 jquery 定义
}
add_action('init', 'my_init_method');
}
wp_deregister_script( 'l10n' );
function custom_headerurl( $url ) {
return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'custom_headerurl' );

//列出所有图片
function all_img($content){
   $pattern = '/<img[^>]*src=\"([^\"]+)\"[^>]*\/?>/si';
   $matches = array();
   if (preg_match_all($pattern, $content, $matches)) {
       if (count($matches[1] > 1)) {
           foreach ($matches[1] as $index => $imgUrl) {
               echo '<div class="slide"><img src="'.get_bloginfo('template_directory').'/timthumb.php?src='.urlencode($imgUrl).'&h=200&w=280&zc=1" alt="' . get_the_title() . '"/></div>'; // 显示图片）
               if ($index >= 3) {
                   break;
               }
           }
       }
   } else {
       echo "没有图片";
   }
}
function catch_first_image($size = 'full') {
    global $post;
    $first_img = '';
    if (has_post_thumbnail($post->ID)) {
        $first_img = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),$size);
        $first_img = $first_img[0];
    }else{
        ob_start();
        ob_end_clean();
        $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
        $first_img = $matches [1] [0];
        if(empty($first_img)){
            $random = mt_rand(1, 7);
            $first_img = get_bloginfo('template_directory').'/images/random/tp'.$random.'.jpg';
        }
    }
    return $first_img;
}
if ( function_exists('add_theme_support') )add_theme_support('post-thumbnails');
function ho2_thumbnail_src(){ 
    global $post; 
    if( $values = get_post_custom_values("thumb") ) {    //输出自定义域图片地址 
        $values = get_post_custom_values("thumb"); 
        $post_thumbnail_src = $values [0]; 
    } elseif( has_post_thumbnail() ){    //如果有特色缩略图，则输出缩略图地址 
        $thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full'); 
        $post_thumbnail_src = $thumbnail_src [0]; 
    } else { 
        $post_thumbnail_src = ''; 
        ob_start(); 
        ob_end_clean(); 
        $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
        $post_thumbnail_src = $matches [1] [0];   //获取该图片 src 
        if(empty($post_thumbnail_src)){    //如果日志中没有图片，则显示thumbnail/random下的随机图片 
            $random = mt_rand(1, 7); 
            echo get_bloginfo('template_url'); 
            echo '/images/random/tp'.$random.'.jpg'; 
        } 
    }; 
    echo $post_thumbnail_src; 
} 
//定义 
function dmsadmin($price){ 
$price = get_post_meta($post->ID, 'product', true);{ echo $price; }
 } 
function plm_thumbnail($timthumb_w,$timthumb_h){ 

    echo '<a href="'.get_permalink().'" title="'.get_the_title().'">'; 
    if( get_opt('ho2_tim_s') ){
		echo '<img ';
		if (get_opt('lazyload_s')){
			echo 'src="'.get_bloginfo('template_directory').'/images/loading.gif" data-original';
		}else{
			echo 'src';
		}
		echo '="'.get_template_directory_uri().'/timthumb.php?src=';
		echo ho2_thumbnail_src();
		echo '&h='.$timthumb_h.'&w='.$timthumb_w.'&zc=1" alt="'.get_the_title().'" title="'.get_the_title().'" />';}
		else {
			echo '<img ';
			if (get_opt('lazyload_s')){
				echo 'src="'.get_bloginfo('template_directory').'/images/loading.gif" data-original='; 
			}else{
				echo 'src';
			}
			echo '="';
			echo ho2_thumbnail_src();
			echo '" alt="'.get_the_title().'" title="'.get_the_title().'" />';}
	echo '</a>';
 }  
function plm_thumsrc($timthumb_w,$timthumb_h){ 
    if( get_opt('ho2_tim_s') ){
		echo get_template_directory_uri().'/timthumb.php?src=';
		echo ho2_thumbnail_src();
		echo '&h='.$timthumb_h.'&w='.$timthumb_w.'&zc=1';}
		else {
			echo ho2_thumbnail_src();}
 } 
/* 中文名图片上传改名
/* ------------------- */
function tin_custom_upload_name($file){
	if(preg_match('/[一-龥]/u',$file['name'])):
	$ext=ltrim(strrchr($file['name'],'.'),'.');
	$file['name']=preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME'])).'_'.date('Y-m-d_H-i-s').'.'.$ext;
	endif;
	return $file;
}
add_filter('wp_handle_upload_prefilter','tin_custom_upload_name',5,1);


/* 摘要去除短代码
/* ----------------- */
function tin_excerpt_delete_shortcode($excerpt){
	$r = "'\[dl(.*?)+\](.*?)\[\/dl]|\[gt(.*?)+\](.*?)\[\/gt]|\[v_notice(.*?)+\](.*?)\[\/v_notice]|\[v_error(.*?)+\](.*?)\[\/v_error]|\[v_warn(.*?)+\](.*?)\[\/v_warn]|\[v_tips(.*?)+\](.*?)\[\/v_tips]|\[v_blue(.*?)+\](.*?)\[\/v_blue]|\[v_act(.*?)+\](.*?)\[\/v_act]|\[v_organge(.*?)+\](.*?)\[\/v_organge]|\[dm(.*?)+\](.*?)\[\/dm]|\[v_qing(.*?)+\](.*?)\[\/v_qing]|\[v_red(.*?)+\](.*?)\[\/v_red]|\[wb(.*?)+\](.*?)\[\/wb]|\[bb(.*?)+\](.*?)\[\/bb]|\[lb(.*?)+\](.*?)\[\/lb]|\[qb(.*?)+\](.*?)\[\/qb]|\[rb(.*?)+\](.*?)\[\/rb]|\[yb(.*?)+\](.*?)\[\/yb]|\[3dgb(.*?)+\](.*?)\[\/3dgb]|\[3dbb(.*?)+\](.*?)\[\/3dbb]|\[3dyb(.*?)+\](.*?)\[\/3dyb]|\[3dhb(.*?)+\](.*?)\[\/3dhb]|\[3dfb(.*?)+\](.*?)\[\/3dfb]|\[3dqlb(.*?)+\](.*?)\[\/3dqlb]|\[collapse(.*?)+\](.*?)\[\/collapse]|\[reply(.*?)+\](.*?)\[\/reply]|\[caption(.*?)+\](.*?)\[\/caption]'";
	return preg_replace($r, '', $excerpt);
}
add_filter( 'wp_trim_words', 'tin_excerpt_delete_shortcode', 999 );
/* 去除摘要P标签包裹 */
remove_filter( 'wp_trim_words', 'wpautop' );

if ( ! function_exists( 'dms_views' ) ) :
function ho2_record_visitors(){
	if (is_singular()) 
	{
	  global $post;
	  $post_ID = $post->ID;
	  if($post_ID) 
	  {
		  $post_views = (int)get_post_meta($post_ID, 'views', true);
		  if(!update_post_meta($post_ID, 'views', ($post_views+1))) 
		  {
			add_post_meta($post_ID, 'views', 1, true);
		  }
	  }
	}
}
add_action('wp_head', 'ho2_record_visitors');  
function dms_views($after=''){
  global $post;
  $post_ID = $post->ID;
  $views = (int)get_post_meta($post_ID, 'views', true);
  echo $views, $after;
}
endif;


/* 
 * 分类样式
 * ====================================================
*/

if ( ! function_exists( 'dms_paging' ) ) :
function dms_paging() {
    $p = 3;
    if ( is_singular() ) return;
    global $wp_query, $paged;
    $max_page = $wp_query->max_num_pages;
    if ( $max_page == 1 ) return; 
    echo '<div class="pagination'.( get_opt('paging_type') == 'multi'?' pagination-multi':'').'"><ul>';
    if ( empty( $paged ) ) $paged = 1;
    if( get_opt('paging_type') == 'multi' && $paged !== 1 ) p_links(0);
    // echo '<span class="pages">Page: ' . $paged . ' of ' . $max_page . ' </span> '; 
    echo '<li class="prev-page">'; previous_posts_link(__('上一页', 'dms')); echo '</li>';

    if( get_opt('paging_type') == 'multi' ){
        if ( $paged > $p + 1 ) p_links( 1, '<li>'.__('第一页', 'dms').'</li>' );
        if ( $paged > $p + 2 ) echo "<li><span>···</span></li>";
        for( $i = $paged - $p; $i <= $paged + $p; $i++ ) { 
            if ( $i > 0 && $i <= $max_page ) $i == $paged ? print "<li class=\"active\"><span>{$i}</span></li>" : p_links( $i );
        }
        if ( $paged < $max_page - $p - 1 ) echo "<li><span> ... </span></li>";
    }
    //if ( $paged < $max_page - $p ) p_links( $max_page, '&raquo;' );
    echo '<li class="next-page">'; next_posts_link(__('下一页', 'dms')); echo '</li>';
    if( get_opt('paging_type') == 'multi' && $paged < $max_page ) p_links($max_page, '', 1);
    if( get_opt('paging_type') == 'multi' ) echo '<li><span>'.__('共', 'dms').' '.$max_page.' '.__('页', 'dms').'</span></li>';

    echo '</ul></div>';
}
function p_links( $i, $title = '', $w='' ) {
    if ( $title == '' ) $title = __('页', 'dms')." {$i}";
    $itext = $i;
    if( $i == 0 ){
        $itext = __('首页', 'dms');
    }
    if( $w ){
        $itext = __('尾页', 'dms');
    }
    echo "<li><a href='", esc_html( get_pagenum_link( $i ) ), "'>{$itext}</a></li>";
}
endif;
/* 相关阅读*/
function dms_posts_related($title='相关阅读', $limit=8){
    global $post;
    $exclude_id = $post->ID; 
    $posttags = get_the_tags(); 
    $i = 0;
    echo '<div class="related-posts clearfix"><h3>'.$title.'</h3><div class="row">';
    if ( $posttags ) { 
        $tags = ''; foreach ( $posttags as $tag ) $tags .= $tag->name . ',';
        $args = array(
            'post_status' => 'publish',
            'tag_slug__in' => explode(',', $tags), 
            'post__not_in' => explode(',', $exclude_id), 
            'caller_get_posts' => 1, 
            'orderby' => 'comment_date', 
            'posts_per_page' => $limit
        );
        query_posts($args); 
        while( have_posts() ) { the_post();
            echo "<div class='col-xs-6 col-md-3 bottommargin-mini'><div class='ih-item square effect6 from_top_and_bottom'><a href=".get_permalink()." title=".get_the_title()." data-toggle='tooltip' data-placement='top'><div class='img'><img src='".get_template_directory_uri()."/timthumb.php?src=".catch_first_image()."&h=125&w=180&zc=1' /></div><div class='info'><h3>".get_the_title()."</h3></div></a></div></div>";
	  
            $exclude_id .= ',' . $post->ID; $i ++;
        };
        wp_reset_query();
    }
    if ( $i < $limit ) { 
        $cats = ''; foreach ( get_the_category() as $cat ) $cats .= $cat->cat_ID . ',';
        $args = array(
            'category__in' => explode(',', $cats), 
            'post__not_in' => explode(',', $exclude_id),
            'caller_get_posts' => 1,
            'orderby' => 'comment_date',
            'posts_per_page' => $limit - $i
        );
        query_posts($args);
        while( have_posts() ) { the_post();
            echo "<div class='col-xs-6 col-md-3 bottommargin-mini'><div class='ih-item square effect6 from_top_and_bottom'><a href=".get_permalink()." title=".get_the_title()." data-toggle='tooltip' data-placement='top'><div class='img'><img src='".get_template_directory_uri()."/timthumb.php?src=".catch_first_image()."&h=125&w=180&zc=1' /></div><div class='info'><h3>".get_the_title()."</h3></div></a></div></div>";
            $i ++;
        };
        wp_reset_query();
    }   
    echo '</div></div>';
}

function p_target_blank(){
return get_opt('target_blank') ? ' target="_blank"' : '';}
//添加钮Download
function DownloadUrl($atts, $content = null) {
	extract(shortcode_atts(array("href" => 'http://'), $atts));
	return '<a href="'.$href.'" class="button button-rounded button-reveal button-large button-red tright" target="_blank" rel="nofollow"><i class="fa fa-cloud-download"></i><span>'.$content.'</span></a>';
	}
add_shortcode("dl", "DownloadUrl");
//添加钮git
function GithubUrl($atts, $content=null) {
   extract(shortcode_atts(array("href" => 'http://'), $atts));
	return '<a class="dl" href="'.$href.'" target="_blank" rel="nofollow"><i class="fa fa-github-alt"></i>'.$content.'</a>';
}
add_shortcode('gt' , 'GithubUrl' );
//添加钮Demo
function DemoUrl($atts, $content=null) {
   extract(shortcode_atts(array("href" => 'http://'), $atts));
	return '<a class="dl" href="'.$href.'" target="_blank" rel="nofollow"><i class="fa fa-external-link"></i>'.$content.'</a>';
}
add_shortcode('dm' , 'DemoUrl' );

//添加编辑器快捷按钮
add_action('admin_print_scripts', 'my_quicktags');
function my_quicktags() {
    wp_enqueue_script(
        'my_quicktags',
        get_stylesheet_directory_uri().'/js/my_quicktags.js',
        array('quicktags')
    );
    }; 
//输出WordPress表情
function fa_get_wpsmiliestrans(){
    global $wpsmiliestrans;
    $wpsmilies = array_unique($wpsmiliestrans);
    foreach($wpsmilies as $alt => $src_path){
        $output .= '<a class="add-smily" data-smilies="'.$alt.'"><img class="wp-smiley" src="'.get_bloginfo('template_directory').'/images/smilies/'.rtrim($src_path, "gif").'gif" /></a>';
    }
    return $output;
}

add_action('media_buttons_context', 'fa_smilies_custom_button');
function fa_smilies_custom_button($context) {
    $context .= '<style>.smilies-wrap{background:#fff;border: 1px solid #ccc;box-shadow: 2px 2px 3px rgba(0, 0, 0, 0.24);padding: 10px;position: absolute;top: 60px;width: 375px;display:none}.smilies-wrap img{height:24px;width:24px;cursor:pointer;margin-bottom:5px} .is-active.smilies-wrap{display:block}</style><a id="insert-media-button" style="position:relative" class="button insert-smilies add_smilies" title="添加表情" data-editor="content" href="javascript:;">添加表情</a><div class="smilies-wrap">'. fa_get_wpsmiliestrans() .'</div><script>jQuery(document).ready(function(){jQuery(document).on("click", ".insert-smilies",function() { if(jQuery(".smilies-wrap").hasClass("is-active")){jQuery(".smilies-wrap").removeClass("is-active");}else{jQuery(".smilies-wrap").addClass("is-active");}});jQuery(document).on("click", ".add-smily",function() { send_to_editor(" " + jQuery(this).data("smilies") + " ");jQuery(".smilies-wrap").removeClass("is-active");return false;});});</script>';
    return $context;
}

//使用短代码添加回复后可见内容开始
function reply_to_read($atts, $content=null){
	extract(shortcode_atts(array("notice" => '<blockquote><p class="reply-to-read" style="color: blue;">注意：本段内容须成功"<a href="'. get_permalink().'#respond" title="回复本文">回复本文</a>"后"<a href="javascript:window.location.reload();" title="刷新本页">刷新本页</a>"方可查看！</p></blockquote>'), $atts));
	if(is_super_admin()){
		return $content;	//如果用户是管理员则直接显示内容
	}
	$email = null;
	$user_ID = (int)wp_get_current_user()->ID;
	if($user_ID > 0){
		$email = get_userdata($user_ID)->user_email;	//如果用户已经登入则从用户信息中取得邮箱
	}else if(isset($_COOKIE['comment_author_email_'.COOKIEHASH])){
		$email = str_replace('%40', '@', $_COOKIE['comment_author_email_'.COOKIEHASH]);		//如果用户尚未登入但COOKIE内储存有邮箱信息
	}else{
		return $notice;		//如无法获取邮箱则返回提示信息
	}
	if(empty($email)){
		return $notice;		//如邮箱为空则返回提示信息
	}
	global $wpdb;
	$post_id = get_the_ID();	//获取文章的ID
	$query = "SELECT `comment_ID` FROM {$wpdb->comments} WHERE `comment_post_ID`={$post_id} and `comment_approved`='1' and `comment_author_email`='{$email}' LIMIT 1";
	if($wpdb->get_results($query)){
		return $content;		//查询到对应的评论即正常显示内容
	}else{
		return $notice;			//否则返回提示信息
	}
}
add_shortcode('reply', 'reply_to_read');

//编辑器添加框架按钮
function GenerateIframe( $atts ) {
    extract( shortcode_atts( array(
        'href' => '',
        'height' => '650px',
        'width' => '700px',
    ), $atts ) );

    return '<iframe src="'.$href.'" width="'.$width.'" height="'.$height.'"> <p>您的浏览器不支持框架</p></iframe>';
}
add_shortcode('iframe', 'GenerateIframe');


//内链
function neibox($atts, $content=null, $code="") {
 $return = '<div class="card-today-history">';
 $return .= $content;
 $return .= '</div>';
 return $return;
}

//为WordPress添加展开收缩功能
function xcollapse($atts, $content = null){extract(shortcode_atts(array("title"=>""),$atts));return '<div class="toggle toggle-border"><div class="togglet"><i class="toggle-closed icon-ok-circle"></i><i class="toggle-open icon-remove-circle"></i>展开/收缩▼</div><div class="togglec" style="display: none;">'.$content.'</div></div>';}
add_shortcode('collapse', 'xcollapse');

function keep_id_continuous(){
  global $wpdb;

  // 删掉自动草稿和修订版
  $wpdb->query("DELETE FROM `$wpdb->posts` WHERE `post_status` = 'auto-draft' OR `post_type` = 'revision'");

  // 自增值小于现有最大ID，MySQL会自动设置正确的自增值
  $wpdb->query("ALTER TABLE `$wpdb->posts` AUTO_INCREMENT = 1");  
}

add_filter( 'load-post-new.php', 'keep_id_continuous' );
add_filter( 'load-media-new.php', 'keep_id_continuous' );
add_filter( 'load-nav-menus.php', 'keep_id_continuous' );


//评论样式
function ho2_comment_list($comment, $args, $depth) {
    echo'<li ';comment_class();echo' id="comment-'.get_comment_ID().'"><div id="comment-'.get_comment_ID().'" class="comment-wrap clearfix">';
    //头像
    echo'<div class="c-avatar"><div class="comment-author vcard"><span class="comment-avatar clearfix"><img class="avatar" ';
    if (get_opt('lazyload_s')){
    	echo 'src="'.get_bloginfo('template_directory').'/images/loading.gif" alt="'.get_comment_author_link().'" data-original';
    }else{
    	echo 'src';
    }
    echo '="'.preg_replace(array('/^.+(src=)(\"|\')/i','/(\"|\')\sclass=(\"|\').+$/i'),array('',''),get_avatar($comment,'60')).'" /></span></div></div>';
    //内容
    echo'<div class="c-main" id="div-comment-'.get_comment_ID().'">';
    echo str_replace(' src=', ' src=', convert_smilies(get_comment_text()));
    if($comment->user_id=='1')echo'<img src="'.get_bloginfo('template_directory').'/images/master.png">';
    echo get_author_class($comment->comment_author_email,$comment->user_id);
    if($comment->comment_approved=='0'){echo'<span class="c-approved">您的评论正在排队审核中，请稍后！</span><br />';}
    //信息
    echo '<div class="c-meta">';
    echo'<span class="c-author">'.get_comment_author_link().'</span>';
    echo get_comment_time('Y-m-d H:i ');
    echo time_ago();
    if($comment->comment_approved!=='0'){echo comment_reply_link(array_merge($args,array('add_below'=>'div-comment','depth'=>$depth,'max_depth'=>$args['max_depth'])));echo edit_comment_link(__('(编辑)'),' - ','');}
    echo '</div></div>';
}
//获取访客VIP样式  
function get_author_class($comment_author_email,$user_id){  
global $wpdb;  
$author_count = count($wpdb->get_results(  
"SELECT comment_ID as author_count FROM $wpdb->comments WHERE comment_author_email = '$comment_author_email' "));  
$adminEmail = get_option('admin_email');if($comment_author_email ==$adminEmail) return;  
if($author_count>=1 && $author_count<3)  
echo '<a class="vip1" title="评论达人 LV.1"></a>';  
else if($author_count>=3 && $author_count<5)   
echo '<a class="vip2" title="评论达人 LV.2"></a>';  
else if($author_count>=5 && $author_count<10)  
echo '<a class="vip3" title="评论达人 LV.3"></a>';   
else if($author_count>=10 && $author_count<20)   
echo '<a class="vip4" title="评论达人 LV.4"></a>';   
else if($author_count>=20 &&$author_count<50)   
echo '<a class="vip5" title="评论达人 LV.5"></a>';   
else if($author_count>=50 && $author_count<100)   
echo '<a class="vip6" title="评论达人 LV.6"></a>';   
else if($author_count>=100)   
echo '<a class="vip7" title="评论达人 LV.7"></a>';   
} 

if ( ! function_exists( 'ho2_paging' ) ) :
function ho2_paging() {
    $p = 4;
    if ( is_singular() ) return;
    global $wp_query, $paged;
    $max_page = $wp_query->max_num_pages;
    if ( $max_page == 1 ) return; 
    echo '<div class="pagination"><ul>';
    if ( empty( $paged ) ) $paged = 1;
    // echo '<span class="pages">Page: ' . $paged . ' of ' . $max_page . ' </span> '; 
    echo '<li class="prev-page">'; previous_posts_link('上一页'); echo '</li>';

    if ( $paged > $p + 1 ) p_link( 1, '<li>第一页</li>' );
    if ( $paged > $p + 2 ) echo "<li><span>···</span></li>";
    for( $i = $paged - $p; $i <= $paged + $p; $i++ ) { 
        if ( $i > 0 && $i <= $max_page ) $i == $paged ? print "<li class=\"active\"><span>{$i}</span></li>" : p_link( $i );
    }
    if ( $paged < $max_page - $p - 1 ) echo "<li><span> ... </span></li>";
    //if ( $paged < $max_page - $p ) p_link( $max_page, '&raquo;' );
    echo '<li class="next-page">'; next_posts_link('下一页'); echo '</li>';
    // echo '<li><span>共 '.$max_page.' 页</span></li>';
    echo '</ul></div>';
}
function p_link( $i, $title = '' ) {
    if ( $title == '' ) $title = "第 {$i} 页";
    echo "<li><a href='", esc_html( get_pagenum_link( $i ) ), "'>{$i}</a></li>";
}
endif;

function theme_c() {
    echo 'Theme BY <a href="http://www.damoushi.com" target="_blank">大谋士网</a>';   }
/* comment_mail_notify v1.0 by willin kan. (有勾選欄, 由訪客決定) */
function comment_mail_notify($comment_id) {
  $admin_notify = '1'; // admin 要不要收回覆通知 ( '1'=要 ; '0'=不要 )
  $admin_email = get_bloginfo ('admin_email'); // $admin_email 可改為你指定的 e-mail.
  $comment = get_comment($comment_id);
  $comment_author_email = trim($comment->comment_author_email);
  $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
  global $wpdb;
  if ($wpdb->query("Describe {$wpdb->comments} comment_mail_notify") == '')
    $wpdb->query("ALTER TABLE {$wpdb->comments} ADD COLUMN comment_mail_notify TINYINT NOT NULL DEFAULT 0;");
  if (($comment_author_email != $admin_email && isset($_POST['comment_mail_notify'])) || ($comment_author_email == $admin_email && $admin_notify == '1'))
    $wpdb->query("UPDATE {$wpdb->comments} SET comment_mail_notify='1' WHERE comment_ID='$comment_id'");
  $notify = $parent_id ? get_comment($parent_id)->comment_mail_notify : '0';
  $spam_confirmed = $comment->comment_approved;
  if ($parent_id != '' && $spam_confirmed != 'spam' && $notify == '1') {
    $wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME'])); // e-mail 發出點, no-reply 可改為可用的 e-mail.
    $to = trim(get_comment($parent_id)->comment_author_email);
    $subject = '您在 [' . get_option("blogname") . '] 的留言有了回应';
    $message = '
    <div style="background-color:#eef2fa; border:1px solid #d8e3e8; color:#111; padding:0 15px; -moz-border-radius:5px; -webkit-border-radius:5px; -khtml-border-radius:5px; border-radius:5px;">
      <p>' . trim(get_comment($parent_id)->comment_author) . ', 您好!</p>
      <p>您曾在《' . get_the_title($comment->comment_post_ID) . '》的留言:<br />'
       . trim(get_comment($parent_id)->comment_content) . '</p>
      <p>' . trim($comment->comment_author) . ' 给您的回应:<br />'
       . trim($comment->comment_content) . '<br /></p>
      <p>您可以点此 <a href="' . htmlspecialchars(get_comment_link($parent_id)) . '">查看该回复的完整内容</a></p>
      <p>欢迎您再度访问 <a href="' . get_option('home') . '">' . get_option('blogname') . '</a></p>
      <p>(此邮件由系统发出，请勿直接回复.)</p>
    </div>';
    $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
    $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
    wp_mail( $to, $subject, $message, $headers );
    //echo 'mail to ', $to, '<br/> ' , $subject, $message; // for testing
  }
}
add_action('comment_post', 'comment_mail_notify');

/* 自動加勾選欄 */
function add_checkbox() {
  echo '<input type="checkbox" name="comment_mail_notify" id="comment_mail_notify" value="comment_mail_notify" checked="checked" style="margin-left:20px;" /><label for="comment_mail_notify">有人回复时邮件通知我</label>';
}
add_action('comment_form', 'add_checkbox');
function tag_cloud_nofollow($cloud){
	$cloud=preg_replace('/<a /','<a rel="nofollow" ',$cloud);
	return $cloud;
}

if (get_opt('lazyload_s')){
add_filter ('the_content', 'lazyload');
function lazyload($content) {
    $loadimg_url=get_bloginfo('template_directory').'/images/loading.gif';
    if(!is_feed()||!is_robots) {
        $content=preg_replace('/<img(.+)src=[\'"]([^\'"]+)[\'"](.*)>/i',"<img\$1data-original=\"\$2\" src=\"$loadimg_url\"\$3>\n<noscript>\$0</noscript>",$content);
    }
    return $content;
}
}
//灯箱
//fancybox 自动对图片链接添加rel=fancybox属性
add_filter('the_content', 'pirobox_gall_replace');
function pirobox_gall_replace ($content){
global $post;
$pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
$replacement = '<a$1href=$2$3.$4$5 data-lightbox="image"$6>$7</a>';
$content = preg_replace($pattern, $replacement, $content);
return $content;
}


if(get_option('upload_path')=='wp-content/uploads' || get_option('upload_path')==null) {
	update_option('upload_path',WP_CONTENT_DIR.'/uploads');
}

function disable_emoji9s_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

//返回当前主题下img\smilies\下表情图片路径
function custom_smilie9s_src( $old, $img ) {
    return get_stylesheet_directory_uri().'/images/smilies/'.$img;
}

function init_smilie9s(){
	global $wpsmiliestrans;
	//默认表情文本与表情图片的对应关系(可自定义修改)
	$wpsmiliestrans = array(
		':mrgreen:' => 'icon_mrgreen.gif',
		':neutral:' => 'icon_neutral.gif',
		':twisted:' => 'icon_twisted.gif',
		  ':arrow:' => 'icon_arrow.gif',
		  ':shock:' => 'icon_eek.gif',
		  ':smile:' => 'icon_smile.gif',
		    ':???:' => 'icon_confused.gif',
		   ':cool:' => 'icon_cool.gif',
		   ':evil:' => 'icon_evil.gif',
		   ':grin:' => 'icon_biggrin.gif',
		   ':idea:' => 'icon_idea.gif',
		   ':oops:' => 'icon_redface.gif',
		   ':razz:' => 'icon_razz.gif',
		   ':roll:' => 'icon_rolleyes.gif',
		   ':wink:' => 'icon_wink.gif',
		    ':cry:' => 'icon_cry.gif',
		    ':eek:' => 'icon_surprised.gif',
		    ':lol:' => 'icon_lol.gif',
		    ':mad:' => 'icon_mad.gif',
		    ':sad:' => 'icon_sad.gif',
		      '8-)' => 'icon_cool.gif',
		      '8-O' => 'icon_eek.gif',
		      ':-(' => 'icon_sad.gif',
		      ':-)' => 'icon_smile.gif',
		      ':-?' => 'icon_confused.gif',
		      ':-D' => 'icon_biggrin.gif',
		      ':-P' => 'icon_razz.gif',
		      ':-o' => 'icon_surprised.gif',
		      ':-x' => 'icon_mad.gif',
		      ':-|' => 'icon_neutral.gif',
		      ';-)' => 'icon_wink.gif',
		       '8O' => 'icon_eek.gif',
		       ':(' => 'icon_sad.gif',
		       ':)' => 'icon_smile.gif',
		       ':?' => 'icon_confused.gif',
		       ':D' => 'icon_biggrin.gif',
		       ':P' => 'icon_razz.gif',
		       ':o' => 'icon_surprised.gif',
		       ':x' => 'icon_mad.gif',
		       ':|' => 'icon_neutral.gif',
		       ';)' => 'icon_wink.gif',
		      ':!:' => 'icon_exclaim.gif',
		      ':?:' => 'icon_question.gif',
	);
	//移除WordPress4.2版本更新所带来的Emoji前后台钩子同时挂上主题自带的表情路径
	remove_action( 'wp_head' , 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts' , 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles' , 'print_emoji_styles' );
	remove_action( 'admin_print_styles' , 'print_emoji_styles' );
	remove_filter( 'the_content_feed' , 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss' , 'wp_staticize_emoji' );
	remove_filter( 'wp_mail' , 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins' , 'disable_emoji9s_tinymce' );

	add_filter( 'smilies_src' , 'custom_smilie9s_src' , 10 , 2 );
}

add_action( 'init', 'init_smilie9s', 5 );





function cfpf_add_meta_boxes($post_type) {
	if (post_type_supports($post_type, 'post-formats') && current_theme_supports('post-formats')) {
		// assets
		wp_enqueue_script('cf-post-formats', get_template_directory_uri().'/inc/js/admin.js', array('jquery'));
		wp_enqueue_style('cf-post-formats', get_template_directory_uri().'/inc/css/admin.css', array(), 'screen');

		wp_localize_script(
			'cf-post-formats',
			'cfpf_post_format',
			array(
				'loading' => __('Loading...', 'cf-post-formats'),
				'wpspin_light' => admin_url('images/wpspin_light.gif')
			)
		);

		add_action('edit_form_after_title', 'cfpf_post_admin_setup');
	}
}



/* 后台编辑器强化
/* --------------- */
function add_more_buttons($buttons){  
	$buttons[] = 'fontsizeselect';  
	$buttons[] = 'styleselect';   
	$buttons[] = 'cleanup';  
	$buttons[] = 'image';  
	$buttons[] = 'code';  
	$buttons[] = 'media';  
	$buttons[] = 'backcolor';  
	$buttons[] = 'wp_page'; 
	return $buttons;  
}  
add_filter("mce_buttons_3", "add_more_buttons");

//文章主动推送到百度
if(!function_exists('Baidu_Submit') && function_exists('curl_init')) {
    function Baidu_Submit($post_ID) {
        $WEB_SITE=get_opt('baidu_site'); //这里换成你的首选域名
        $WEB_TOKEN=get_opt('baidu_token');  //这里换成你的网站的百度主动推送的token值
        //已成功推送的文章不再推送
        if(get_post_meta($post_ID,'Baidusubmit',true) == 1) return;
        $url = get_permalink($post_ID);
        $api = 'http://data.zz.baidu.com/urls?site='.$WEB_SITE.'&token='.$WEB_TOKEN;
        $ch  = curl_init();
        $options =  array(
            CURLOPT_URL => $api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => $url,
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        $result = json_decode(curl_exec($ch),true);
        if (array_key_exists('success',$result)) {
            add_post_meta($post_ID, 'Baidusubmit', 1, true);
        }
    }
    add_action('publish_post', 'Baidu_Submit', 0);
}

$new_meta_boxes =    
array(   
    
    "come" => array(   
        "name" => "_meta_come",   
        "std" => "",      
        "title" => "来源站点名",   
        "type"=>"text"), 
	"curl" => array(   
        "name" => "_meta_curl",   
        "std" => "",      
        "title" => "来源网址",   
        "type"=>"text"), 
		"tx" => array(
		"name" => "tixing",
		"std" => "",
		"title" => "文章提醒",
		"type"=>"text"),
		"tgzz" => array(
		"name" => "tgzz",
		"std" => "",
		"title" => "投稿作者，在前加投稿：为好！",
		"type"=>"text"),
);  
function new_meta_boxes() {   
    global $post, $new_meta_boxes;   
    foreach($new_meta_boxes as $meta_box) {   
        //获取保存的是   
        $meta_box_value = get_post_meta($post->ID, $meta_box['name'].'_value', true);   
        if($meta_box_value != "")      
            $meta_box['std'] = $meta_box_value;
           
        echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';     
        switch ( $meta_box['type'] ){   
            case 'text':   
                echo'<h4>'.$meta_box['title'].'</h4>';   
                echo '<input type="text"  name="'.$meta_box['name'].'_value" value="'.$meta_box['std'].'" /><br />';   
                break;    
        }             
    }      
}  

function create_meta_box() {      
    global $theme_name;      
     
    if ( function_exists('add_meta_box') ) {      
        add_meta_box( 'new-meta-boxes', '文章设置', 'new_meta_boxes', 'post', 'side', 'high' );      
    }      
}   

function save_postdata( $post_id ) {      
    global $post, $new_meta_boxes;      
     
    foreach($new_meta_boxes as $meta_box) {      
        if ( !wp_verify_nonce( $_POST[$meta_box['name'].'_noncename'], plugin_basename(__FILE__) ))  {      
            return $post_id;      
        }      
     
        if ( 'page' == $_POST['post_type'] ) {      
            if ( !current_user_can( 'edit_page', $post_id ))      
                return $post_id;      
        }       
        else {      
            if ( !current_user_can( 'edit_post', $post_id ))      
                return $post_id;      
        }      
     
        $data = $_POST[$meta_box['name'].'_value'];      
     
        if(get_post_meta($post_id, $meta_box['name'].'_value') == "")      
            add_post_meta($post_id, $meta_box['name'].'_value', $data, true);      
        elseif($data != get_post_meta($post_id, $meta_box['name'].'_value', true))      
            update_post_meta($post_id, $meta_box['name'].'_value', $data);      
        elseif($data == "")      
            delete_post_meta($post_id, $meta_box['name'].'_value', get_post_meta($post_id, $meta_box['name'].'_value', true));      
    }      
}  
add_action('admin_menu', 'create_meta_box');      
add_action('save_post', 'save_postdata');

//去除分类标志代码
add_action( 'load-themes.php',  'no_category_base_refresh_rules');
add_action('created_category', 'no_category_base_refresh_rules');
add_action('edited_category', 'no_category_base_refresh_rules');
add_action('delete_category', 'no_category_base_refresh_rules');
function no_category_base_refresh_rules() {
	global $wp_rewrite;
	$wp_rewrite -> flush_rules();
}

// register_deactivation_hook(__FILE__, 'no_category_base_deactivate');
// function no_category_base_deactivate() {
// 	remove_filter('category_rewrite_rules', 'no_category_base_rewrite_rules');
// 	// We don't want to insert our custom rules again
// 	no_category_base_refresh_rules();
// }

// Remove category base
add_action('init', 'no_category_base_permastruct');
function no_category_base_permastruct() {
	global $wp_rewrite, $wp_version;
	if (version_compare($wp_version, '3.4', '<')) {
		// For pre-3.4 support
		$wp_rewrite -> extra_permastructs['category'][0] = '%category%';
	} else {
		$wp_rewrite -> extra_permastructs['category']['struct'] = '%category%';
	}
}

// Add our custom category rewrite rules
add_filter('category_rewrite_rules', 'no_category_base_rewrite_rules');
function no_category_base_rewrite_rules($category_rewrite) {
	//var_dump($category_rewrite); // For Debugging

	$category_rewrite = array();
	$categories = get_categories(array('hide_empty' => false));
	foreach ($categories as $category) {
		$category_nicename = $category -> slug;
		if ($category -> parent == $category -> cat_ID)// recursive recursion
			$category -> parent = 0;
		elseif ($category -> parent != 0)
			$category_nicename = get_category_parents($category -> parent, false, '/', true) . $category_nicename;
		$category_rewrite['(' . $category_nicename . ')/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?category_name=$matches[1]&feed=$matches[2]';
		$category_rewrite['(' . $category_nicename . ')/page/?([0-9]{1,})/?$'] = 'index.php?category_name=$matches[1]&paged=$matches[2]';
		$category_rewrite['(' . $category_nicename . ')/?$'] = 'index.php?category_name=$matches[1]';
	}
	// Redirect support from Old Category Base
	global $wp_rewrite;
	$old_category_base = get_option('category_base') ? get_option('category_base') : 'category';
	$old_category_base = trim($old_category_base, '/');
	$category_rewrite[$old_category_base . '/(.*)$'] = 'index.php?category_redirect=$matches[1]';

	//var_dump($category_rewrite); // For Debugging
	return $category_rewrite;
}


// Add 'category_redirect' query variable
add_filter('query_vars', 'no_category_base_query_vars');
function no_category_base_query_vars($public_query_vars) {
	$public_query_vars[] = 'category_redirect';
	return $public_query_vars;
}

// Redirect if 'category_redirect' is set
add_filter('request', 'no_category_base_request');
function no_category_base_request($query_vars) {
	//print_r($query_vars); // For Debugging
	if (isset($query_vars['category_redirect'])) {
		$catlink = trailingslashit(get_option('home')) . user_trailingslashit($query_vars['category_redirect'], 'category');
		status_header(301);
		header("Location: $catlink");
		exit();
	}
	return $query_vars;
}
//=====================================

//所有设置已完成，如果往后的代码非您手工添加，很可能是因为您的其它主题有恶意代码。您可以定期查看此段代码后面有没有代码。
//所有设置已完成，如果往后的代码非您手工添加，很可能是因为您的其它主题有恶意代码。您可以定期查看此段代码后面有没有代码。
//所有设置已完成，如果往后的代码非您手工添加，很可能是因为您的其它主题有恶意代码。您可以定期查看此段代码后面有没有代码。
//所有设置已完成，如果往后的代码非您手工添加，很可能是因为您的其它主题有恶意代码。您可以定期查看此段代码后面有没有代码。
//所有设置已完成，如果往后的代码非您手工添加，很可能是因为您的其它主题有恶意代码。您可以定期查看此段代码后面有没有代码。
?>