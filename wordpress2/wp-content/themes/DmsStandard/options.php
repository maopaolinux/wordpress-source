<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/options.css" type="text/css" />
	<p class="dms-tabs-general"><i class="fa fa-cog fa-fw"></i>设置界面</p>
	<div class="options-logo">
	<h3>逆水行舟</h3>
	</div>
<?php

function optionsframework_option_name() {
    $themename = wp_get_theme();
    $themename = preg_replace("/\W/", "_", strtolower($themename));
    $optionsframework_settings = get_option('optionsframework');
    $optionsframework_settings['id'] = $themename;
    update_option('optionsframework', $optionsframework_settings);
}
function optionsframework_options() {
    $display = array('0' => 'CMS模式',
		'2' => 'Blog博客模式',
    );
		// 所有分类ID
	$categories = get_categories(); 
	foreach ($categories as $cat) {
	$cats_id .= '<li>'.$cat->cat_name.' [ '.$cat->cat_ID.' ]</li>';
	}
	$head_array = array('one' => __('样式一', 'dms-bzb') ,'two' => __('样式二', 'dms-bzb') ,		
    );
	$foot_style_array = array('one' => __('样式一', 'dms-bzb') ,'two' => __('样式二', 'dms-bzb') ,
    );
	$sticky_array= array('one' => __('样式一', 'dms-bzb') ,'two' => __('样式二', 'dms-bzb') ,
    );
	$dms_d_array= array('one' => __('效果一', 'dms-bzb') ,'two' => __('效果二', 'dms-bzb') ,
    );
	$dms_e_array= array('lefts' => __('左浮动', 'dms-bzb') ,'rights' => __('右浮动', 'dms-bzb') ,
    );
	$cms_array = array('one' => __('样式一', 'dms-bzb') ,'two' => __('样式二', 'dms-bzb') ,'three' => __('样式三', 'dms-bzb') ,
    );
	$silder_array_stt = array('date' => __('按发布日期排序', 'dms-bzb') ,'modified' => __('按修改时间排序', 'dms-bzb') ,'comment_count' => __('按评论最多排序', 'dms-bzb') ,'ID' => __('按文章ID排序', 'dms-bzb') ,
    );
	$animation_array = array('fadeIn' => __('上滑入', 'dms-bzb') ,'fadeInRight' => __('右滑入', 'dms-bzb') ,'fadeInLeft' => __('左滑入', 'dms-bzb') ,'fadeInUp' => __('下滑入', 'dms-bzb') ,
    );
    $bg_repeat_array = array('no-repeat' => __('不重复', 'dms-bzb') ,'repeat' => __('平铺', 'dms-bzb') ,'repeat-x' => __('水平平铺', 'dms-bzb') ,'repeat-y' => __('垂直平铺', 'dms-bzb') ,
    );
    $bg_location_array = array('left' => __('左', 'dms-bzb') ,'center' => __('中', 'dms-bzb') ,'right' => __('右', 'dms-bzb') ,
    );
    $options_categories = array();
    $options_categories_obj = get_categories();
    foreach ($options_categories_obj as $category) {$options_categories[$category->cat_ID] = $category->cat_name;
    }
    $imagepath = get_template_directory_uri() . '/inc/images/';
    $options = array();
    $options[] = array('name' => __('全站设置', 'dms-bzb') ,'type' => 'heading'
    );
    $options[] = array('name' => __('全站logo设置', 'dms-bzb') ,'desc' => __('顶部导航logo，最宽不超过350px,最高不超过100px', 'dms-bzb') ,'id' => 'logo_src',"std" => 'http://www.damoushi.com/wp-content/uploads/2016/02/logo1.png',
		"std" => '' . get_bloginfo('template_directory') . '/images/logo.png','type' => 'upload'
    );
	$options[] = array('name' => __('手机版logo设置', 'dms-bzb') ,'desc' => __('建议logo尺寸250px*200px', 'dms-bzb') ,'id' => 'logo_src_m',"std" => '' . get_bloginfo('template_directory') . '/images/logo@2x.png','type' => 'upload'
    );
	$options[] = array('name' => __('建站日期', 'dms-bzb') ,'desc' => __('格式：2016-02-26。', 'dms-bzb') ,'id' => 'establish_date',
		'std' => '2016-02-26','type' => 'text',
    );
    $options[] = array('name' => __('ICP备案号', 'dms-bzb') ,'desc' => __('请填写你的ICP备案号，不填写清留空', 'dms-bzb') ,'id' => 'ho2_icp','type' => 'text',
    );
    $options[] = array("name" => '站点SEO关键词',"desc" => '输入您的网站关键词，建议不超过10个，每个以英文(,)号分隔。',"id" => 'seo_keywords',"std" => 'DmsStandard主题,大谋士主题',"type" => "textarea"
    );
    $options[] = array('name' => '站点SEO描述','desc' => '输入您的网站描述，建议不超过150个字符。','id' => 'seo_description','std' => '大谋士DmsStandard主题发布','type' => 'textarea'
    );
    $options[] = array('name' => '网站底部信息','desc' => '位于网站底部，可以放置网站地图等各类内容','id' => 'foot_copy','std' => '基于 <a href="https://cn.wordpress.org/" target="_blank" rel="nofollow">WordPress</a> ','type' => 'textarea'
    );
	$options[] = array('name' => '网站页脚文本','desc' => '位于网站底部，可以写一段话，一段声明等，','id' => 'foot_text','std' => '大谋士DmsStandard主题发布，基于GPL开源协议免费开放使用，由DMS大谋士网发布。使用本主题可进行任意形式修改，但使用过程中请保留底部版权（本站链接）。','type' => 'textarea'
    );
	$options[] = array('name' => __('风格', 'dms-bzb') ,'type' => 'heading'
    );
	
	$options[] = array(
		'name'    => __('主题风格', 'dms-bzb'),
		'desc'    => __('3种颜色风格切换', 'dms-bzb'),
		'id'      => 'theme_skin',
		'std'     => '1FAEFF',
		'type'    => 'images',
		'options' => array(
		    // '1FAEFF' => $imagepath . '0.jpg', 
			'hongse' => $imagepath . '1.jpg',
			// '2CDB87' => $imagepath . '2.jpg', 
			// '00D6AC' => $imagepath . '3.jpg', 
			// 'A12ABA' => $imagepath . '4.jpg', 
			// 'FDAC5F' => $imagepath . '5.jpg', 
			// 'FD77B2' => $imagepath . '6.jpg', 
			// '76BDFF' => $imagepath . '7.jpg', 
			// 'C38CFF' => $imagepath . '8.jpg', 
			// 'FD6639' => $imagepath . '9.jpg', 
			// 'B00C00' => $imagepath . '10.jpg', 
			'qingse' => $imagepath . '12.jpg', 
			'lanse' => $imagepath . '0.jpg')
		);
	$options[] = array('name' => __('顶部导航风格', 'dms-bzb') ,'desc' => __('本主题提供两种头部样式。', 'dms-bzb') ,'id' => 'author_five','std' => true,'type' => 'checkbox'
    );
	$options[] = array('desc' => __('样式选择', 'dms-bzb') ,'id' => 'head_style','std' => 'one','type' => 'select','options' => $head_array
    );
    /*分隔	*/
    $options[] = array('name' => '基本设置','type' => 'heading'
    );
	$options[] = array(
	'name' => __('文章信息小部件', 'dms-bzb') ,
	'desc' => __(' 显示作者', 'dms-bzb') ,
	'id' => 'p_author_s',
	'std' => true,
	'type' => 'checkbox'
    );
	$options[] = array(
	'desc' => __(' 显示文章分类。', 'dms-bzb') ,
	'id' => 'dms_cat_s',//判断关键字 
	'std' => true,'type' => 'checkbox'
    );
	$options[] = array('desc' => __(' 显示评论数', 'dms-bzb') ,'id' => 'p_comm_s','std' => true,'type' => 'checkbox'
    );
	$options[] = array('desc' => __(' 显示来源声明', 'dms-bzb') ,'id' => 'source_s','std' => true,'type' => 'checkbox'
    );
    $options[] = array('name' => __('文章页', 'dms-bzb') ,'desc' => __('开启作者信息模块', 'dms-bzb') ,'id' => 'author_s','std' => true,'type' => 'checkbox'
    );
    $options[] = array('desc' => __(' 开启文章页分享', 'dms-bzb') ,'id' => 'baidu_share','std' => true,'type' => 'checkbox'
    );
	$options[] = array('desc' => __(' 开启版权声明', 'dms-bzb') ,'id' => 'ho2_copyright','std' => true,'type' => 'checkbox'
    );
	$options[] = array('desc' => __('版权提示', 'dms-bzb') ,'id' => 'ho2_copyright_title','std' => __('如无特殊说明，文章均为本站原创，转载请注明出处', 'dms-bzb') ,'type' => 'text'
    );
	$options[] = array('name' => __('新窗口打开链接', 'dms-bzb') ,'desc' => __('只在列表及博客首页起作用', 'dms-bzb') ,'id' => 'target_blank','std' => false,'type' => 'checkbox'
    );
	$options[] = array('name' => __('缩略图设置', 'dms-bzb') ,'desc' => __(' 是否使用Timthumb插件自动裁减？默认开启', 'dms-bzb') ,'id' => 'ho2_tim_s','std' => true,'type' => 'checkbox'
    );
	$options[] = array('name' => __('延迟加载设置', 'dms-bzb') ,'desc' => __(' 是否使用基于lazyload的延迟加载功能？默认开启', 'dms-bzb') ,'id' => 'lazyload_s','std' => true,'type' => 'checkbox'
    );
	$options[] = array('name' => __('其他设置', 'dms-bzb') ,'type' => 'heading'
    );
	$options[] = array(
		'name' => __('公告/描述', 'dms-bzb') ,'id' => 'header_dec_s','type' => 'checkbox','std' => true,'desc' => __('开启（分类描述，文章页显示，作者页显示，标签页显示，页面显示）', 'dms-bzb')
    );
	$options[] = array('id' => 'ho2_sign_s','type' => 'checkbox','std' => true,'desc' => __('开启公告栏', 'dms-bzb')
    );
    $options[] = array('desc' => __('公告栏标题', 'dms-bzb') ,'id' => 'ho2_sign_title','std' => __('公告', 'dms-bzb') ,'type' => 'text'
    );
	$options[] = array('desc' => __('公告文本（支持a标签）', 'dms-bzb') ,'id' => 'ho2_sign_text',
		'std' => __('欢迎来访大谋士博客', 'dms-bzb') ,'type' => 'textarea'
    );
    $options[] = array('name' => __('百度主动推送设置', 'dms-bzb') ,
		'id' => 'baidu_site','std' => '','class' => 'mini',
		'desc' => __('百度主动推送网址', 'dms-bzb') ,'type' => 'text'
    );
	$options[] = array(
		'id' => 'baidu_token','std' => '','class' => 'mini',
		'desc' => __('百度主动推送TOKEN', 'dms-bzb') ,'type' => 'text'
    );
	
	
	$options[] = array(
	'name' => __('留言板设置', 'dms-bzb'), 
	'id' => 'book_num', 
	'std' => 10, 
	'class' => 'links', 
	'desc' => __('设置留言板显示的读者数量', 'dms-bzb'), 
	'type' => 'text');
	$options[] = array(
	'id' => 'book_kd', 
	'std' => 190, 
	'class' => 'mini', 
	'desc' => __('留言板宽度，显示宽度默认190px。', 'dms-bzb'), 
	'type' => 'text');
    $options[] = array('name' => __('首页幻灯', 'dms-bzb') ,'type' => 'heading'
    );
    $options[] = array('id' => 'slide_s','std' => true,'desc' => __('开启时（调用自定义幻灯片）', 'dms-bzb') ,'type' => 'checkbox'
    );
	$options[] = array('id' => 'slide_stt_s','std' => false,'desc' => __('开启时（调用幻灯片参数）', 'dms-bzb') ,'type' => 'checkbox'
    );
	$options[] = array('name' => __('幻灯参数', 'dms-bzb') ,'desc' => __('使用参数调用幻灯，请注意你文章是否有大图。', 'dms-bzb') , 'id' => 'slide_stt','std' => 'date','type' => 'radio','options' => $silder_array_stt
    );
	$options[] = array(
	'id' => 'slide_g', 
	'std' => 350, 
	'class' => 'mini', 'desc' => __('幻灯片高度，默认350，对自定义幻灯片无效', 'dms-bzb'), 
	'type' => 'text');
    for ($i = 1; $i <= 6; $i++) {$options[] = array(    'name' => __('幻灯', 'dms-bzb') . $i,    'id' => 'slide_title_' . $i,    'desc' => '标题',    'std' => 'dms-bzb主题 - 大谋士',    'type' => 'text');$options[] = array(    'id' => 'slide_href_' . $i,    'desc' => __('链接', 'dms-bzb') ,    'std' => 'http://www.damoushi.com/dmsStandard',    'type' => 'text');$options[] = array(		'id' => 'slide_miaoshu_' . $i,		'desc' => __('描述', 'dms-bzb') ,		'std' => '《DmsStandard》大谋士博客主题',		'type' => 'textarea');$options[] = array(    'id' => 'slide_blank_' . $i,    'std' => true,    'desc' => __('新窗口打开', 'dms-bzb') ,    'type' => 'checkbox');$options[] = array(    'id' => 'slide_src_' . $i,    'desc' => __('图片，尺寸：', 'dms-bzb') . '自适应图片大小，但需要各个幻灯片图片高宽一致。',    'std' => get_template_directory_uri() .'/images/other/slide.jpg',    'type' => 'upload');
    }
    $options[] = array('name' => __('社交', 'dms-bzb'), 'type' => 'heading');
    $options[] = array('name' => __('新浪微博', 'dms-bzb'), 'id' => 'social_weibo_s', 'std' => true, 'desc' => ' 显示', 'type' => 'checkbox');
    $options[] = array('desc' => '直接填写链接', 'id' => 'social_weibo', 'std' => 'http://weibo.com/', 'type' => 'text');
    

    
    $options[] = array('name' => __('腾讯微博', 'dms-bzb'), 'id' => 'social_tqq_s', 'std' => true, 'desc' => ' 显示', 'type' => 'checkbox');
    $options[] = array('desc' => '直接填写链接', 'id' => 'social_tqq', 'std' => 'http://t.qq.com/', 'type' => 'text');
    


    $options[] = array('name' => __('腾讯QQ', 'dms-bzb'), 'id' => 'social_qq_s', 'std' => true, 'desc' => ' 显示', 'type' => 'checkbox');
    $options[] = array('desc' => '这是一个临时会话的链接，直接填写QQ号码，（请注意查看自己QQ是否允许临时会话）', 'id' => 'social_qq', 'std' => '123456789', 'type' => 'text');
    
    $options[] = array('name' => __('邮箱链接', 'dms-bzb'), 'id' => 'social_mail_s', 'std'=>false, 'desc' => ' 显示', 'type' => 'checkbox');
    $options[] = array('desc' => '填写邮箱地址即可，如：damoushi@qq.com（投稿管理员接收邮箱也是这个）', 'id' => 'social_mail', 'std' => '', 'type' => 'text');
	$options[] = array('name' => __('QQ群链接', 'dms-bzb'), 'id' => 'social_qun_s', 'std'=>false, 'desc' => ' 显示', 'type' => 'checkbox');
	$options[] = array('desc' => '群名称或者其它标题名称', 'id' => 'social_qun_tit', 'std' => '', 'type' => 'text');
    $options[] = array('desc' => '填写加群链接地址即可，如何获取加群链接请点此', 'id' => 'social_qun', 'std' => '', 'type' => 'text');
    
    $options[] = array('name' => __('Facebook', 'dms-bzb'), 'id' => 'social_facebook_s', 'std'=>false, 'desc' => ' 显示', 'type' => 'checkbox');
    $options[] = array('desc' => '填写链接', 'id' => 'social_facebook', 'std' => '', 'type' => 'text');
    
    $options[] = array('name' => __('twitter', 'dms-bzb'), 'id' => 'social_twitter_s', 'std'=>false, 'desc' => ' 显示', 'type' => 'checkbox');
    $options[] = array('desc' => '填写链接', 'id' => 'social_twitter', 'std' => '', 'type' => 'text');
    	
    $options[] = array('name' => __('微信帐号', 'dms-bzb'), 'id' => 'social_wechat_s', 'std' => true, 'desc' => ' 显示', 'type' => 'checkbox');
    $options[] = array('desc' => '填写链接', 'id' => 'social_wechat', 'std' => '大谋士', 'type' => 'text');
    
    $options[] = array('id' => 'social_wechat_qr', 
	'std' => '' . get_bloginfo('template_directory') . '/images/weixin.png', 
	'desc' => __('微信二维码，建议图片尺寸：', 'dms-bzb') . '230x230px', 'type' => 'upload');
    $options[] = array('name' => __('RSS订阅', 'dms-bzb'), 'id' => 'social_feed_s', 'std'=>true, 'desc' => ' 显示', 'type' => 'checkbox');
    $options[] = array( 'id' => 'social_feed', 'std' => get_feed_link(), 'type' => 'text');
    
    $options[] = array('name' => __('广告位', 'dms-bzb') ,'type' => 'heading'
    );
    $options[] = array('name' => __('文章页正文结尾文字广告', 'dms-bzb') ,'id' => 'ads_post_footer_s','std' => true,'desc' => ' 显示','type' => 'checkbox'
    );
    $options[] = array('desc' => '标题','id' => 'ads_post_footer_title','std' => '《DmsStandard》大谋士博客主题','type' => 'text'
    );
    $options[] = array('desc' => '链接（直接填写地址，别忘了http://）','id' => 'ads_post_footer_link','std' => '','type' => 'text'
    );
    $options[] = array('id' => 'ads_post_footer_link_blank','type' => 'checkbox','std'=>false,'desc' => __('开启', 'dms-bzb') . ' (' . __('新窗口打开链接，如果链接没填写请不要开启', 'dms-bzb') . ')'
    );
    $options[] = array('name' => __('AD1首页列表最前，', 'dms-bzb') ,'id' => 'ads_01_s','std' => true,'desc' => __('开启', 'dms-bzb') ,'type' => 'checkbox'
    );
    $options[] = array('desc' => __('最大宽度830px，默认居中', 'dms-bzb') ,'id' => 'ads_01','type' => 'textarea'
    );
    $options[] = array('name' => __('AD2首页及分类列表页分页下', 'dms-bzb') ,'id' => 'ads_02_s','std' => true,'desc' => __('开启', 'dms-bzb') ,'type' => 'checkbox'
    );
    $options[] = array('desc' => __('位于（首页、各类归档页、分类页）的分页标签下，最大宽度830px，默认居中', 'dms-bzb') ,'id' => 'ads_02','type' => 'textarea'
    );
    $options[] = array('name' => __('AD3文章页及页面正文上', 'dms-bzb') ,'id' => 'ads_03_s',
'std' => true,'desc' => __('开启', 'dms-bzb') ,'type' => 'checkbox'
    );
    $options[] = array('desc' => __('位于文章页及页面（默认模版）正文前，最大宽度830px，默认居中', 'dms-bzb') ,'id' => 'ads_03','type' => 'textarea'
    );
    $options[] = array('name' => __('AD4文章结束后', 'dms-bzb') ,'id' => 'ads_04_s','std' => true,'desc' => __('开启', 'dms-bzb') ,'type' => 'checkbox'
    );
    $options[] = array('desc' => __('位于文章内容最后，最大宽度830px，默认居中', 'dms-bzb') ,'id' => 'ads_04','type' => 'textarea'
    );
    $options[] = array('name' => __('AD5文章页及页面评论下', 'dms-bzb') ,'id' => 'ads_05_s','std'=>false,'desc' => __('开启', 'dms-bzb') ,'type' => 'checkbox'
    );
    $options[] = array('desc' => __('位于文章页及页面（默认模版）评论列表下，最大宽度830px，默认居中', 'dms-bzb') ,'id' => 'ads_05','type' => 'textarea'
    );
    $options[] = array('name' => __('AD6首页CMS上', 'dms-bzb') ,'id' => 'ads_07_s','std'=>false,'desc' => __('开启', 'dms-bzb') ,'type' => 'checkbox'
    );
    $options[] = array('desc' => __('CMS模式专用，最大宽度830px，默认居中。', 'dms-bzb') ,'id' => 'ads_07','type' => 'textarea'
    );
    $options[] = array('name' => __('AD7首页CMS下', 'dms-bzb') ,'id' => 'ads_08_s','std'=>false,'desc' => __('开启', 'dms-bzb') ,'type' => 'checkbox'
    );
    $options[] = array('desc' => __('CMS模式专用，最大宽度830px，默认居中', 'dms-bzb') ,'id' => 'ads_08','type' => 'textarea'
    );
	$options[] = array('name' => __('手机模式AD1', 'dms-bzb') ,'id' => 'adm_01_s','std'=>false,'desc' => __('开启', 'dms-bzb') ,'type' => 'checkbox'
    );
    $options[] = array('desc' => __('手机模式下展示的广告，此广告位于：全站列表头部，CMS模式下最开始模块前，文章页标题下', 'dms-bzb') ,'id' => 'adm_01','type' => 'textarea'
    );
	$options[] = array('name' => __('手机模式AD2', 'dms-bzb') ,'id' => 'adm_02_s','std'=>false,'desc' => __('开启', 'dms-bzb') ,'type' => 'checkbox'
    );
    $options[] = array('desc' => __('手机模式下展示的广告，此广告位于：全站列表分页前，CMS模式下最后一个模块后，文章页评论前', 'dms-bzb') ,'id' => 'adm_02','type' => 'textarea'
    );
	$options[] = array('name' => __('手机模式AD3', 'dms-bzb') ,'id' => 'adm_03_s','std'=>false,'desc' => __('开启', 'dms-bzb') ,'type' => 'checkbox'
    );
    $options[] = array('desc' => __('手机模式下展示的广告，此广告位于footer文件里，用于添加百度隐藏悬浮、图+等代码', 'dms-bzb') ,'id' => 'adm_03','type' => 'textarea'
    );
    $options[] = array('name' => __('自定义代码', 'dms-bzb') ,'type' => 'heading'
    );
    $options[] = array('name' => __('自定义CSS样式', 'dms-bzb') ,'desc' => __('位于&lt;/head&gt;之前，直接写样式代码，不需要添加&lt;style&gt;标签', 'dms-bzb') ,'id' => 'csscode','std' => '','type' => 'textarea'
    );
    $options[] = array('name' => __('自定义头部代码', 'dms-bzb') ,'desc' => __('位于&lt;/head&gt;之前，这部分代码是在主要内容显示之前加载，通常是CSS样式、添加&lt;/meta&gt;信息验证网站所有权、全站头部JS等需要提前加载的代码', 'dms-bzb') ,'id' => 'headcode','std' => '','type' => 'textarea'
    );
    $options[] = array('name' => __('自定义底部代码', 'dms-bzb') ,'desc' => __('位于&lt;/body&gt;之前，这部分代码是在主要内容加载完毕加载，通常是JS代码', 'dms-bzb') ,'id' => 'footcode','std' => '','type' => 'textarea'
    );
    $options[] = array('name' => __('网站统计代码', 'dms-bzb') ,'desc' => __('位于底部，用于添加第三方流量数据统计代码，如：Google analytics、百度统计、CNZZ、51la，国内站点推荐使用百度统计，国外站点推荐使用Google analytics', 'dms-bzb') ,'id' => 'trackcode','std' => '','type' => 'textarea'
    );
	$options[] = array('name' => __('存档选项', 'dms-bzb') ,'type' => 'heading'
    );
	$options[] = array('name' => __( '大图+摘要' , 'dms-bzb' ),
		'desc' => __('填写分类ID即可，如果需要为多个分类设置则用英文,进行分隔', 'dms-bzb') ,'id' => 'big_thumb','type' => 'text'
    );
	$options[] = array('name' => __( '说说类' , 'dms-bzb' ),
		'desc' => __('填写分类ID即可，如果需要为多个分类设置则用英文,进行分隔', 'dms-bzb') ,'id' => 'ss_thumb','type' => 'text'
    );
	$options[] = array('name' => __('侧边栏浮动', 'dms-bzb') ,'id' => 'sideroll_s','std' => true,'desc' => __('开启', 'dms-bzb') ,'type' => 'checkbox'
    );
    $options[] = array('id' => 'sideroll_n_1','std' => '1','class' => 'mini','type' => 'text'
    );
    $options[] = array('id' => 'sideroll_n_2','std' => '2','class' => 'mini','desc' => __('设置随动模块，直接输入数字', 'dms-bzb') ,'type' => 'text'
    );
	$options[] = array('name' => __('文章页', 'dms-bzb') ,'type' => 'heading'
    );
	$options[] = array(
	    'name' => __( '缩略图浮动' , 'dms-bzb' ),'desc' => __('文章缩略图左右浮动（图标未调整）', 'dms-bzb') ,'id' => 'thumb_left','std' => 'lefts','type' => 'select','options' => $dms_e_array,
    );
	$options[] = array('name' => __('相关文章', 'dms-bzb') ,'id' => 'ho2_related_s','type' => 'checkbox','std' => true,'desc' => __('相关文章样式', 'dms-bzb')
    );
	$options[] = array(
		'id' => 'rel_type',
		'std' => "two",
		'type' => "radio",
		'options' => array('one' => __('样式一（图文样式）', 'dms-bzb') ,'two' => __('样式二（列表样式）', 'dms-bzb') ,
		)
		);
    $options[] = array('desc' => __('相关文章标题', 'dms-bzb') ,'id' => 'ho2_related_title','std' => __('相关推荐', 'dms-bzb') ,'type' => 'text'
    );
    $options[] = array('desc' => __('相关文章显示数量', 'dms-bzb') ,'id' => 'ho2_related_n','std' => 4,'class' => 'mini','type' => 'text'
    );
	$options[] = array(
		'name' => __('分页模式', 'dms-bzb'),
		'id' => 'paging_type',
		'std' => "next",
		'type' => "images",
		'options' => array(

			'next' => $imagepath.'layout/next.png',
			'multi' => $imagepath.'layout/multi.png'
		)
		);
	$options[] = array('name' => __('CMS设置', 'dms-bzb') ,'type' => 'heading'
    );
	
	$options[] = array(
		'name' => 'Tab切换模块',
		'desc' => '勾选显示',
		'id' => 'tab_h',
		'std' => '1',
		'type' => 'checkbox'
	);

	$options[] = array(
		'desc' => '-----Tab模块显示篇数',
		'id' => 'tabt_n',
		'std' => '8',
		'type' => 'text'
	);

	$options[] = array(
		'name' => '',
		'desc' => '-----Tab模块“推荐文章”设置',
		'id' => 'tab_a',
		'std' => '推荐文章',
		'type' => 'text'
	);
	if ( $options_categories ) {
	$options[] = array(
		'desc' => '-----选择一个分类',
		'id' => 'tabt_id',
		'type' => 'select',
		'options' => $options_categories);
	}
	$options[] = array(
		'name' => '',
		'desc' => '-----Tab模块“专题文章”设置',
		'id' => 'tab_b',
		'std' => '专题文章',
		'type' => 'text'
	);

	if ( $options_categories ) {
	$options[] = array(
		'desc' => '-----选择一个分类',
		'id' => 'tabz_n',
		'type' => 'select',
		'options' => $options_categories);
	}
	$options[] = array(
		'name' => '',
		'desc' => '-----Tab模块“特别推荐”设置',
		'id' => 'tab_c',
		'std' => '特别推荐',
		'type' => 'text'
	);

	if ( $options_categories ) {
	$options[] = array(
		'desc' => '-----选择一个分类',
		'id' => 'tabz_nn',
		'type' => 'select',
		'options' => $options_categories);
	}
	$options[] = array(
	    'name' =>__('开启分类展示', 'dms-bzb') ,'desc' => __(' 开启分类展示一行三组', 'dms-bzb') ,'id' => 'dms_blog_category',//判断关键字'std' => true,'type' => 'checkbox'
    );
	$options[] = array('desc' => __('请输入需要展示的分类，多个分类请以英文（,）逗号分隔。最后请不要加逗号！', 'dms-bzb') ,'id' => 'category-blog','std' => '1','type' => 'text'
    );
	$options[] = array('desc' => __('设置分类图标代码 地址：<a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank" >图标地址</a>', 'dms-bzb') ,'id' => 'cat_icon',//数据获取关键字'std' => __('fa fa-list', 'dms-bzb') ,'type' => 'text'
    );
	$options[] = array('desc' => __('调用数量', 'dms-bzb') ,'id' => 'category_n_blog','std' => '10','type' => 'text'
    );
	$options[] = array(
		'name' => '分类ID对照',
		'desc' => '<ul>'.$cats_id.'</ul>',
		'id' => 'catids',
		'type' => 'info');
	
	return $options;
}
?><?php
add_action('optionsframework_after','options_after', 100);
function options_after() { ?>
	<div class="options-logo">
	<span>提供者：<a href="http://www.damoushi.com/" target="_blank"title="欢迎访问damoushi博客">大谋之士</a></span>
	<span>主题版本：<a href="http://www.damoushi.com/" target="_blank"title="欢迎访问damoushi博客">DmsStandard v1.0</a></span>
	</div>
<?php }	

