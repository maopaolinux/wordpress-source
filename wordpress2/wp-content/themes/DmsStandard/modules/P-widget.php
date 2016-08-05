<?php 
/*
	DmsStandard Widget 
	
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	
	Copyright: (c) 2015 大谋士 - http://www.damoushi.com
	
		@package DmsStandard
		@version 1.0
*/ 
if (function_exists('register_sidebar')){
	register_sidebar(array(
		'name'          => '全站侧栏',
		'id'            => 'widget_sitesidebar',
		'before_widget' => '<div class="widget clearfix %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="fancy-title title-dotted-border"><h3>',
		'after_title'   => '</h3></div>'
	));
	register_sidebar(array(
		'name'          => '首页侧栏',
		'id'            => 'widget_sidebar',
		'before_widget' => '<div class="widget clearfix %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="fancy-title title-dotted-border"><h3>',
		'after_title'   => '</h3></div>'
	));
	register_sidebar(array(
		'name'          => '分类/标签/搜索页侧栏',
		'id'            => 'widget_othersidebar',
		'before_widget' => '<div class="widget clearfix %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="fancy-title title-dotted-border"><h3>',
		'after_title'   => '</h3></div>'
	));
	register_sidebar(array(
		'name'          => '文章页/页面侧栏',
		'id'            => 'widget_postsidebar',
		'before_widget' => '<div class="widget clearfix %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="fancy-title title-dotted-border"><h3>',
		'after_title'   => '</h3></div>'
	));

}
/*DmsStandard-广告*/ 
add_action( 'widgets_init', 'plm_banners' );

function plm_banners() {
	register_widget( 'plm_banner' );
}

class plm_banner extends WP_Widget {
	function plm_banner() {
		$widget_ops = array( 'classname' => 'plm_banner', 'description' => '显示一个广告(包括富媒体)，或者是其它的html代码' );
		$this->WP_Widget( 'plm_banner', 'DmsStandard-广告', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_name', $instance['title']);
		$code = $instance['code'];

		echo $before_widget;
		echo '<div class="adhtml">'.$code.'</div>';
		echo $after_widget;
	}

	function form($instance) {
?>

<p>
  <label> 标题：
    <input id="<?php echo $this -> get_field_id('title'); ?>" name="<?php echo $this -> get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" class="widefat" />
  </label>
</p>
<p>
  <label> 代码：
    <textarea id="<?php echo $this -> get_field_id('code'); ?>" name="<?php echo $this -> get_field_name('code'); ?>" class="widefat" rows="12" style="font-family:Courier New;"><?php echo $instance['code']; ?></textarea>
  </label>
</p>
<?php
}
}
/*DmsStandard-最新评论*/
add_action( 'widgets_init', 'plm_comments' );
function plm_comments() {
register_widget( 'plm_comment' );
}

class plm_comment extends WP_Widget {
function plm_comment() {
$widget_ops = array( 'classname' => 'plm_comment', 'description' => '显示网友最新评论（头像+名称+评论）' );
$this->WP_Widget( 'plm_comment', 'DmsStandard-最新评论', $widget_ops, $control_ops );
}
function widget( $args, $instance ) {
extract( $args );

$title = apply_filters('widget_name', $instance['title']);
$limit = $instance['limit'];
$outer = $instance['outer'];
$outpost = $instance['outpost'];

$mo='';

echo $before_widget;
echo $before_title.$mo.$title.$after_title;
echo '<div id="recent-post-list-sidebar">';
echo mod_newcomments( $limit,$outpost,$outer );
echo '</div>';
echo $after_widget;
}

function form($instance) {
	$instance = wp_parse_args((array)$instance,array(   
    'title'=>'最新评论','limit'=>10,'outer'=>1   
    ));
?>
		<p>
			<label>
				标题：
				<input class="widefat" id="<?php echo $this -> get_field_id('title'); ?>" name="<?php echo $this -> get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" />
			</label>
		</p>
		<p>
			<label>
				显示数目：
				<input class="widefat" id="<?php echo $this -> get_field_id('limit'); ?>" name="<?php echo $this -> get_field_name('limit'); ?>" type="number" value="<?php echo $instance['limit']; ?>" />
			</label>
		</p>
		<p>
			<label>
				排除某用户ID：
				<input class="widefat" id="<?php echo $this -> get_field_id('outer'); ?>" name="<?php echo $this -> get_field_name('outer'); ?>" type="number" value="<?php echo $instance['outer']; ?>" />
			</label>
		</p>
		<p>
			<label>
				排除某文章ID：
				<input class="widefat" id="<?php echo $this -> get_field_id('outpost'); ?>" name="<?php echo $this -> get_field_name('outpost'); ?>" type="text" value="<?php echo $instance['outpost']; ?>" />
			</label>
		</p>

<?php
}
}

function mod_newcomments( $limit,$outpost,$outer ){
global $wpdb;
$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved,comment_author_email, comment_type,comment_author_url, SUBSTRING(comment_content,1,40) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_post_ID!='".$outpost."' AND user_id!='".$outer."' AND comment_approved = '1' AND comment_type = '' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT $limit";
$comments = $wpdb->get_results($sql);
foreach ( $comments as $comment ) {
$output = convert_smilies($output);
$output .= '<div class="spost clearfix">
<div class="entry-image">'.get_avatar( $comment, 21,"",$comment->comment_author).' </div>
<div class="entry-c"><strong>'.strip_tags($comment->comment_author).'</strong> 评论文章 ：<br/><a href="' . esc_url(get_comment_link($comment->comment_ID)) . '">《 ' . get_the_title($comment->comment_post_ID) . ' 》</a>
</div>
<div class="entry-com">
<i class="fa fa-quote-left"></i> <a href="'. get_permalink($comment->ID) .'#comment-' . $comment->comment_ID . '" title="《'.$comment->post_title . '》上的评论">'. strip_tags($comment->com_excerpt).'</a><i class="fa fa-quote-right"></i>
</div>
</div>';
}

echo $output;
};



/*DmsStandard-邮件订阅*/
class plmsubscribe extends WP_Widget {
/*  Widget
/* ------------------------------------ */
function __construct(){
parent::__construct(false,'DmsStandard-邮件订阅',array( 'description' => 'DmsStandard-展示邮件订阅部件' ,'classname' => 'subscribe-widget'));
}

function widget($args,$instance){
extract($args);
$title = apply_filters('widget_name', $instance['title']);
$emaildy_id = $instance['emaildy_id'];
	?>
		<?php echo $before_widget; ?>
        <?php
			if ($instance['title'])
				echo $before_title . $instance['title'] . $after_title;
 ?>
		<form id="widget-subscribe-form" action="http://list.qq.com/cgi-bin/qf_compose_send" role="form" method="post" class="nobottommargin" novalidate="novalidate">
            <div class="input-group divcenter"> <span class="input-group-addon"><i class="fa fa-paper-plane"></i></span>
              <input type="hidden" name="t" value="qf_booked_feedback">
              <input type="hidden" name="id" value="<?php echo $emaildy_id; ?>">
              <input type="email" id="to" name="to" class="form-control required email" placeholder="订阅本站,获取更多精彩" aria-required="true">
              <span class="input-group-btn">
              <button class="btn btn-success" type="submit">订阅</button>
              </span> </div>
          </form>
		<?php echo $after_widget; ?>
	<?php }

			function update($new_instance,$old_instance){
			return $new_instance;
			}

			function form($instance){
			$title = esc_attr($instance['title']);
			$emaildy_id = esc_attr($instance['emaildy_id']);
		?>
		<p><label for="<?php echo $this -> get_field_id('title'); ?>"><?php _e('标题：', 'DmsStandard'); ?><input class="widefat" id="<?php echo $this -> get_field_id('title'); ?>" name="<?php echo $this -> get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
        <p>
  <label> 邮箱订阅ID： <a style="font-weight:bold;color:#f60;text-decoration:none;" href="javascript:;" title="详情请访问www.damoushi.com检索">？</a>
    <input style="width:100%;" id="<?php echo $this -> get_field_id('emaildy_id'); ?>" name="<?php echo $this -> get_field_name('emaildy_id'); ?>" type="text" value="<?php echo $instance['emaildy_id']; ?>" size="24" />
  </label>
</p>
	<?php
	}
	}
	add_action('widgets_init',create_function('', 'return register_widget("plmsubscribe");'));
	
	
	/*DmsStandard-友链*/
	class plmbookmarkh extends WP_Widget {
/*  Widget
/* ------------------------------------ */
	function __construct(){
		parent::__construct(false,'DmsStandard-友情链接',array( 'description' => 'DmsStandard-单横栏显示友情链接' ,'classname' => 'widget_plmbookmarkh'));
	}

	function widget($args,$instance){
		extract($args);
	?>
		<?php echo $before_widget; ?>
        <?php if($instance['title'])echo $before_title.$instance['title'].'<a target="_blank" href="'.get_bloginfo('url').'/links">'.__("申请","tinection").'</a>'. $after_title; ?>
		<?php
			global $wpdb;
			$limit = $instance['links_num'];
			$orderby = $instance['links_orderby'];
			if($orderby=='rand'){$bookmarks = $wpdb -> get_results("SELECT * FROM $wpdb->links ORDER BY RAND() LIMIT $limit");}else
			{$bookmarks = $wpdb -> get_results("SELECT * FROM $wpdb->links ORDER BY $orderby DESC LIMIT $limit");}
			echo '<div class="you_links">';
			foreach ( $bookmarks as $bookmark) {
				echo '<a href="'.$bookmark->link_url.'" title="'.$bookmark->link_name.'" target="_blank">'.$bookmark->link_name.'</a>';
			}
			echo '</div>';
		?>
		<?php echo $after_widget; ?>

	<?php }

	function update($new,$old){
		$instance = $old;
		$instance['link_num'] = strip_tags($new['link_num']);
		$instance['links_orderby'] = strip_tags($new['links_orderby']);
		return $new;
	}

	function form($instance){
		$title = esc_attr($instance['title']);
		$num = absint($instance['links_num']);
		// Default widget settings
		$defaults = array(
		// Links
			'links_orderby' 	=> 'link_id',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('标题：','tinection'); ?><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id('links_num'); ?>"><?php _e('数量：','tinection'); ?></label><input class="widefat" id="<?php echo $this->get_field_id('links_num'); ?>" name="<?php echo $this->get_field_name('links_num'); ?>" type="text"  value="<?php echo $num; ?>" /></p>
		<p style="padding-top: 0.3em;">
			<label style="width: 100%; display: inline-block;" for="<?php echo $this->get_field_id("links_orderby"); ?>"><?php _e('排序：','tinection'); ?></label>
			<select style="width: 100%;" id="<?php echo $this->get_field_id("links_orderby"); ?>" name="<?php echo $this->get_field_name("links_orderby"); ?>">
			  <option value="link_id"<?php selected( $instance["links_orderby"], "link_id" ); ?>>ID</option>
			  <option value="link_name"<?php selected( $instance["links_orderby"], "link_name" ); ?>><?php _e('名称','tinection'); ?></option>
			  <option value="link_rating"<?php selected( $instance["links_orderby"], "link_rating" ); ?>><?php _e('评分','tinection'); ?></option>
			  <option value="rand"<?php selected( $instance["links_orderby"], "rand" ); ?>><?php _e('随机','tinection'); ?></option>
			</select>	
		</p>
	<?php
	}
}
/*  Register widget
/* ------------------------------------ */
if ( ! function_exists( 'plm_register_widget_bookmarks_h' ) ) {

	function plm_register_widget_bookmarks_h() { 
		register_widget( 'plmbookmarkh' );
	}	
}
add_action( 'widgets_init', 'plm_register_widget_bookmarks_h' );
	/*DmsStandard-聚合文章*/
	add_action( 'widgets_init', 'e_postlists' );

	function e_postlists() {
	register_widget( 'e_postlist' );
	}

	class e_postlist extends WP_Widget {
	function e_postlist() {
	$widget_ops = array( 'classname' => 'e_postlist', 'description' => '图文展示（最新文章or热门文章or随机文章）' );
	$this->WP_Widget( 'e_postlist', 'DmsStandard-聚合文章', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
	extract( $args );

	$title        = apply_filters('widget_name', $instance['title']);
	$limit        = $instance['limit'];
	$cat          = $instance['cat'];
	$orderby      = $instance['orderby'];
	$img = $instance['img'];

	$mo='';
	$style='';
	if( !$img ) $style = 'nopic';
	echo $before_widget;
	echo $before_title.$mo.$title.$after_title;
	echo '<div class="juhe'.$style.'">';
	echo enews_posts_list( $orderby,$limit,$cat,$img );
	echo '</div>';
	echo $after_widget;
	}

	function form( $instance ) {
?>

<p>
  <label> 标题：
    <input style="width:100%;" id="<?php echo $this -> get_field_id('title'); ?>" name="<?php echo $this -> get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" />
  </label>
</p>
<p>
  <label> 排序：
    <select id="<?php echo $this -> get_field_id('orderby'); ?>" name="<?php echo $this -> get_field_name('orderby'); ?>" style="width:100%;">
      <option value="comment_count" <?php selected('comment_count', $instance['orderby']); ?>>评论数</option>
      <option value="date" <?php selected('date', $instance['orderby']); ?>>发布时间</option>
      <option value="rand" <?php selected('rand', $instance['orderby']); ?>>随机</option>
    </select>
  </label>
</p>
<p>
  <label> 分类限制： <a style="font-weight:bold;color:#f60;text-decoration:none;" href="javascript:;" title="格式：1,2 &nbsp;表限制ID为1,2分类的文章&#13;格式：-1,-2 &nbsp;表排除分类ID为1,2的文章&#13;也可直接写1或者-1；注意逗号须是英文的">？</a>
    <input style="width:100%;" id="<?php echo $this -> get_field_id('cat'); ?>" name="<?php echo $this -> get_field_name('cat'); ?>" type="text" value="<?php echo $instance['cat']; ?>" size="24" />
  </label>
</p>
<p>
  <label> 显示数目：
    <input style="width:100%;" id="<?php echo $this -> get_field_id('limit'); ?>" name="<?php echo $this -> get_field_name('limit'); ?>" type="number" value="<?php echo $instance['limit']; ?>" size="24" />
  </label>
</p>
<p>
  <label>
    <input style="vertical-align:-3px;margin-right:4px;" class="checkbox" type="checkbox" <?php checked($instance['img'], 'on'); ?> id="<?php echo $this -> get_field_id('img'); ?>" name="<?php echo $this -> get_field_name('img'); ?>">
    显示图片 </label>
</p>
<?php
}
}

function enews_posts_list($orderby,$limit,$cat,$img) {
$args = array(
'order'            => DESC,
'cat'              => $cat,
'orderby'          => $orderby,
'showposts'        => $limit,
'caller_get_posts' => 1
);
query_posts($args);
while (have_posts()) : the_post();
?>

  <div class="spost clearfix">
    
      <?php
		if ($img) {echo '<div class="entry-image"><img src="';
			echo plm_thumsrc(48,48);
			echo '" /></div>';
		} else {$img = '';
		}
 ?>
    
    <div class="entry-c">
      <div class="entry-title">
        <h4>
         <a href="<?php the_permalink(); ?>"> <?php the_title(); ?>  </a>
        </h4>
      </div>
      <ul class="entry-meta">
        <li><i class="fa fa-comments"></i>
          <?php comments_number('0', '1评论', '%评论'); ?>
        </li>
        <li><i class="fa fa-clock-o"></i>
          <?php the_time('Y-m-d'); ?>
        </li>
      </ul>
    </div>
  </div>

<?php

endwhile; wp_reset_query();
}


	/*DmsStandard-站点统计*/

	class plmsitestatistic extends WP_Widget {
	/*  Widget
	/* ------------------------------------ */
	function __construct(){
	parent::__construct(false,'DmsStandard-站点统计',array( 'description' => 'DmsStandard-站点统计' ,'classname' => 'widget_plmsitestatistic'));
	}

	function widget($args,$instance){
	extract($args);
	?>
		<?php echo $before_widget; ?>
        <?php
			if ($instance['title'])
				echo $before_title . $instance['title'] . $after_title;
 ?>
		<ul class="col-md-6">
			<?php
			global $wpdb;
 ?>
			<li><?php _e('日志总数：', 'DmsStandard'); ?><span><?php $count_posts = wp_count_posts();
				echo $published_posts = $count_posts -> publish;
 ?></span> <?php _e(' 篇', 'DmsStandard'); ?></li>
			<li><?php _e(' 评论总数：', 'DmsStandard'); ?><span><?php echo $wpdb -> get_var("SELECT COUNT(*) FROM $wpdb->comments"); ?></span><?php _e(' 条', 'DmsStandard'); ?></li>
			<li><?php _e('标签数量：', 'DmsStandard'); ?><span><?php echo $count_tags = wp_count_terms('post_tag'); ?></span><?php _e(' 个', 'DmsStandard'); ?></li>
            </ul><ul class="col-md-6">
			<li><?php _e('友链总数：', 'DmsStandard'); ?><span><?php $link = $wpdb -> get_var("SELECT COUNT(*) FROM $wpdb->links WHERE link_visible = 'Y'");
				echo $link;
 ?></span><?php _e(' 个', 'DmsStandard'); ?></li>
			<li><?php _e('运行天数：', 'DmsStandard'); ?><span><?php echo floor((time() - strtotime(get_opt('establish_date'))) / 86400); ?></span><?php _e(' 天', 'DmsStandard'); ?></li>
			<li><?php _e('最后更新：', 'DmsStandard'); ?><span><?php $last = $wpdb -> get_results("SELECT MAX(post_modified) AS MAX_m FROM $wpdb->posts WHERE (post_type = 'post' OR post_type = 'page') AND (post_status = 'publish' OR post_status = 'private')");
				$last = date('Y-n-j', strtotime($last[0] -> MAX_m));
				echo $last;
 ?></span></li>
		</ul>
<div class="clear"></div>		
		
		
		
		<?php echo $after_widget; ?>

	<?php }

	function update($new_instance,$old_instance){
	return $new_instance;
	}

	function form($instance){
	$title = esc_attr($instance['title']);
		?>
		<p><label for="<?php echo $this -> get_field_id('title'); ?>"><?php _e('标题：', 'DmsStandard'); ?><input class="widefat" id="<?php echo $this -> get_field_id('title'); ?>" name="<?php echo $this -> get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
	<?php
	}
	}
	add_action('widgets_init',create_function('', 'return register_widget("plmsitestatistic");'));
	/*DmsStandard-社交*/
	add_action( 'widgets_init', 'plm_socials' );

	function plm_socials() {
	register_widget( 'plm_social' );
	}

	class plm_social extends WP_Widget {
	function plm_social() {
	$widget_ops = array( 'classname' => 'plm_social', 'description' => '社交类按钮' );
	$this->WP_Widget( 'plm_social', 'DmsStandard-社交', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
	extract( $args );

	echo $before_widget;
	echo '<div class="social">';
	echo get_opt('social_qq_s') ? '<a href="'.get_opt('social_qq').'" rel="external nofollow" target="_blank" title="点击QQ联系" data-toggle="tooltip" data-placement="top"><i class="qq fa fa-qq"></i></a>' : '';
	echo get_opt('social_weibo_s') ? '<a href="'.get_opt('social_weibo').'" target="_blank" title="关注新浪微博" data-toggle="tooltip" data-placement="top"><i class="sinaweibo fa fa-weibo"></i></a>' : '';
	echo get_opt('social_tqq_s') ? '<a href="'.get_opt('social_tqq').'" target="_blank" title="关注腾讯微博" data-toggle="tooltip" data-placement="top"><i class="tencentweibo fa fa-tencent-weibo"></i></a>' : '';
	echo get_opt('social_facebook_s') ? '<a href="'.get_opt('social_facebook').'" target="_blank" title="关注Facebook" data-toggle="tooltip" data-placement="top"><i class="facebook fa fa-facebook-official"></i></a>' : '';
	echo get_opt('social_twitter_s') ? '<a href="'.get_opt('social_twitter').'" target="_blank" title="关注Twitter" data-toggle="tooltip" data-placement="top"><i class="twitter fa fa-twitter"></i></a>' : '';
	echo get_opt('social_wechat_s') ? '<a class="weixin"><i class="weixins fa fa-weixin"></i>
	<div class="weixin-popover">
	<div class="popover bottom in">
	<div class="arrow"></div>
	<div class="popover-title">扫描关注&quot;'.get_opt('social_wechat').'&quot;微信</div>
	<div class="popover-content"><img src="'.get_opt('social_wechat_qr').'"></div>
	</div>
	</div></a>' : '';
	echo get_opt('social_mail_s') ? '<a href="http://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&email='.get_opt('social_mail').'" target="_blank" title="发送邮件" data-toggle="tooltip" data-placement="top"><i class="emails fa fa-envelope-o"></i></a>' : '';
	echo get_opt('social_qun_s') ? '<a target="_blank" href="'.get_opt('social_qun').'" title="'.get_opt('social_qun_tit').'" data-toggle="tooltip" data-placement="top"><i class="qun fa fa-users"></i></a>' : '';

	echo '</div>';
	echo $after_widget;
	}

	function form($instance) {
?>

<p>
  <label> 唔...没有设置项，共享主题设置的设置项，建立此小工具的原因是考虑到有童鞋不开启顶栏。BUT、该小工具仅支持6个社交按钮。当然你可以开启更多，不过如果出现错位了，自负！ 
  </label>
</p>

<?php
}
}

/*DmsStandard-Tabs选项卡*/
class PlmTabs extends WP_Widget {
function PlmTabs() {
parent::__construct( false, 'DmsStandard-Tabs选项卡', array('description' => 'DmsStandard-以Tabs选项卡式显示最新文章、随即文章、热门文章三个栏目', 'classname' => 'widget_tabs') );;
}
function widget( $args, $instance ) {
extract( $args );

$linum        = $instance['linum'];

echo $before_widget;
echo '<div class="tabs nobottommargin clearfix" id="sidebar-tabs">';
echo plm_tabs_list( $linum);
echo '</div>';
echo $after_widget;
}
public function update($new,$old) {
$instance = $old;
$instance['linum'] = strip_tags($new['linum']);

return $instance;
}
function form( $instance ) {
?>
<p>
  <label> 显示数目：
    <input style="width:100%;" id="<?php echo $this -> get_field_id('linum'); ?>" name="<?php echo $this -> get_field_name('linum'); ?>" type="number" value="<?php echo $instance['linum']; ?>" size="24" />
  </label>
</p>
<?php
}
}
function plm_tabs_list($linum) {
?>
<ul class="tab-nav clearfix">
  <li><a href="#tabs-1">最新文章<?php echo $img ?></a></li>
  <li><a href="#tabs-2">随机文章</a></li>
  <li><a href="#tabs-3">热门文章</a></li>
</ul>
<div class="tab-container">
  <div class="tab-content clearfix" id="tabs-1">
    <div id="popular-post-list-sidebar">
      <?php
$post_num = $linum; 
$args = array(
      'post_password' => '',
          'post_status' => 'publish', 
          'post__not_in' => array($post->ID),
          'caller_get_posts' => 1, 
          'orderby' => 'date', 
          'posts_per_page' => $post_num
);
        $query_posts = new WP_Query();
        $query_posts->query($args);
        while( $query_posts->have_posts() ) { $query_posts->the_post(); ?>
      <div class="spost clearfix">
        <div class="entry-image">
          <?php plm_thumyuan(70, 70); ?>
        </div>
        <div class="entry-c">
          <div class="entry-title">
            <h4><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
              <?php the_title(); ?>
              </a></h4>
          </div>
          <ul class="entry-meta">
            <li><i class="fa fa-eye"></i> <?php dms_views('℃'); ?></li>
            <li><i class="fa fa-clock-o"></i> <?php echo timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ) ?></li>
          </ul>
        </div>
      </div>
      <?php } wp_reset_query(); ?>
    </div>
  </div>
  <div class="tab-content clearfix" id="tabs-2">
    <div id="recent-post-list-sidebar">
      <?php
$post_num = $linum; 
$args = array(
      'post_password' => '',
          'post_status' => 'publish', 
          'post__not_in' => array($post->ID),
          'caller_get_posts' => 1, 
          'orderby' => 'rand', 
          'posts_per_page' => $post_num
);
        $query_posts = new WP_Query();
        $query_posts->query($args);
        while( $query_posts->have_posts() ) { $query_posts->the_post(); ?>
      <div class="spost clearfix">
        <div class="entry-image">
          <?php plm_thumyuan(70, 70); ?>
        </div>
        <div class="entry-c">
          <div class="entry-title">
            <h4><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
              <?php the_title(); ?>
              </a></h4>
          </div>
          <ul class="entry-meta">
            <li><i class="fa fa-eye"></i> <?php dms_views('℃'); ?></li>
            <li><i class="fa fa-clock-o"></i> <?php echo timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ) ?></li>
          </ul>
        </div>
      </div>
      <?php } wp_reset_query(); ?>
    </div>
  </div>
  <div class="tab-content clearfix" id="tabs-3">
    <div id="recent-post-list-sidebar">
      <?php
$post_num = $linum; 
$args = array(
      'post_password' => '',
          'post_status' => 'publish', 
          'post__not_in' => array($post->ID),
          'caller_get_posts' => 1, 
          'orderby' => 'comment_count', 
          'posts_per_page' => $post_num
);
        $query_posts = new WP_Query();
        $query_posts->query($args);
        while( $query_posts->have_posts() ) { $query_posts->the_post(); ?>
      <div class="spost clearfix">
        <div class="entry-image">
          <?php plm_thumyuan(70, 70); ?>
        </div>
        <div class="entry-c">
          <div class="entry-title">
            <h4><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
              <?php the_title(); ?>
              </a></h4>
          </div>
          <ul class="entry-meta">
            <li><i class="fa fa-eye"></i> <?php dms_views('℃'); ?></li>
            <li><i class="fa fa-clock-o"></i> <?php echo timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ) ?></li>
          </ul>
        </div>
      </div>
      <?php } wp_reset_query(); ?>
    </div>
  </div>
</div>
<?php
}
if ( ! function_exists( 'plm_register_widget_tabs' ) ) {
function plm_register_widget_tabs() {
register_widget( 'PlmTabs' );
}
}
add_action( 'widgets_init', 'plm_register_widget_tabs' );
/*DmsStandard-标签云*/
add_action( 'widgets_init', 'plm_tags' );

function plm_tags() {
register_widget( 'plm_tag' );
}

class plm_tag extends WP_Widget {
function plm_tag() {
$widget_ops = array( 'classname' => 'plm_tag', 'description' => '显示热门标签' );
$this->WP_Widget( 'plm_tag', 'DmsStandard-标签云', $widget_ops, $control_ops );
}

function widget( $args, $instance ) {
extract( $args );

$title = apply_filters('widget_name', $instance['title']);
$count = $instance['count'];
$offset = $instance['offset'];
$more = $instance['more'];
$link = $instance['link'];

$mo='';
if( $more!='' && $link!='' ) $mo='<a class="btn btn-primary" href="'.$link.'">'.$more.'</a>';

echo $before_widget;
echo $before_title.$mo.$title.$after_title;
echo '<div class="p_tags">';
$tags_list = get_tags('orderby=count&order=DESC&number='.$count.'&offset='.$offset);
if ($tags_list) {
foreach($tags_list as $tag) {
echo '<a href="'.get_tag_link($tag).'" data-toggle="tooltip" data-placement="top" title="'. $tag->count .' 个相关话题" >'. $tag->name .' ('. $tag->count .')</a>';
}
}else{
echo '暂无标签！';
}
echo '</div>';
echo $after_widget;
}

function form($instance) {
?>

<p>
  <label> 名称：
    <input id="<?php echo $this -> get_field_id('title'); ?>" name="<?php echo $this -> get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" class="widefat" />
  </label>
</p>
<p>
  <label> 显示数量：
    <input id="<?php echo $this -> get_field_id('count'); ?>" name="<?php echo $this -> get_field_name('count'); ?>" type="number" value="<?php echo $instance['count']; ?>" class="widefat" />
  </label>
</p>
<p>
  <label> 去除前几个：
    <input id="<?php echo $this -> get_field_id('offset'); ?>" name="<?php echo $this -> get_field_name('offset'); ?>" type="number" value="<?php echo $instance['offset']; ?>" class="widefat" />
  </label>
</p>
<?php
}
}

/*DmsStandard-特别推荐*/
add_action( 'widgets_init', 'e_textbanners' );

function e_textbanners() {
register_widget( 'e_textbanner' );
}

class e_textbanner extends WP_Widget {
function e_textbanner() {
$widget_ops = array( 'classname' => 'e_textbanner', 'description' => '显示一个文本特别推荐，或者是一个网站告示' );
$this->WP_Widget( 'e_textbanner', 'DmsStandard-特别推荐', $widget_ops, $control_ops );
}

function widget( $args, $instance ) {
extract( $args );

$title = apply_filters('widget_name', $instance['title']);
$content = $instance['content'];
$link = $instance['link'];
$style = $instance['style'];
$blank = $instance['blank'];

$lank = '';
if( $blank ) $lank = ' target="_blank"';

echo $before_widget;
echo '<dd><a class="'.$style.'" href="'.$link.'"'.$lank.'>';
echo '<h2>'.$title.'</h2>';
echo '<p>'.$content.'</p>';
echo '</a></dd>';
echo $after_widget;
}

function form($instance) {
?>

<p>
  <label> 标题：
    <input id="<?php echo $this -> get_field_id('title'); ?>" name="<?php echo $this -> get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" class="widefat" />
  </label>
</p>
<p>
  <label> 描述：
    <textarea id="<?php echo $this -> get_field_id('content'); ?>" name="<?php echo $this -> get_field_name('content'); ?>" class="widefat" rows="3"><?php echo $instance['content']; ?></textarea>
  </label>
</p>
<p>
  <label> 链接：
    <input style="width:100%;" id="<?php echo $this -> get_field_id('link'); ?>" name="<?php echo $this -> get_field_name('link'); ?>" type="url" value="<?php echo $instance['link']; ?>" size="24" />
  </label>
</p>

<p>
  <label>
    <input style="vertical-align:-3px;margin-right:4px;" class="checkbox" type="checkbox" <?php checked($instance['blank'], 'on'); ?> id="<?php echo $this -> get_field_id('blank'); ?>" name="<?php echo $this -> get_field_name('blank'); ?>">
    新打开浏览器窗口 </label>
</p>
<?php
}
}
?>
