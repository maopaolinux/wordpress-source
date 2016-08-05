<?php
if (!function_exists('optionsframework_init')){ define('OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri().'/inc/'); require_once dirname(__FILE__).'/inc/options-framework.php'; }
include(TEMPLATEPATH . '/modules/P-widget.php');
include(TEMPLATEPATH . '/modules/better-widget.php');
include_once('modules/class-seo.php');
include_once('functions-theme.php');
include(TEMPLATEPATH . '/functions/categories-images.php');

//SMTP邮箱设置
function mail_smtp( $phpmailer ){
$phpmailer->From = "damoushi.com";//请将damoushi.com替换成你的发件人地址
$phpmailer->FromName = "大谋士";//请将‘大谋士’替换成你的发件人昵称
$phpmailer->Host = "smtp.damoushi.qq.com";//SMTP服务器地址，默认填了QQ的SMTP服务器地址，如果你的不是QQ邮箱，请自行替换
$phpmailer->Port = "25";//SMTP邮件发送端口, 常用端口有：25、465、587, 具体联系邮件服务商
$phpmailer->SMTPSecure = "";//SMTP加密方式(SSL/TLS)没有为空即可，具体联系邮件服务商, 以免设置错误, 无法正常发送邮件
$phpmailer->Username = "damoushi.com";//请将damoushi.com替换成你的邮箱帐号
$phpmailer->Password = "damoushi.com";//请将damoushi.com替换成你的密码
$phpmailer->IsSMTP();
$phpmailer->SMTPAuth = true;//启用SMTPAuth服务
}
add_action('phpmailer_init','mail_smtp');
function get_ssl_avatar($avatar) {
$avatar = preg_replace('/.*\/avatar\/(.*)\?s=([\d]+)&.*/','<img src="https://secure.gravatar.com/avatar/$1?s=$2" class="avatar avatar-$2" height="$2" width="$2">',$avatar);
return $avatar;
}
add_filter('get_avatar', 'get_ssl_avatar');
function get_the_link_items($id = null){
    $bookmarks = get_bookmarks('orderby=date&category=' .$id );
    $output = '';
    if ( !empty($bookmarks) ) {
        $output .= '<ul class="link-items fontSmooth">';
        foreach ($bookmarks as $bookmark) {
            $output .=  '<li class="link-item"><a class="link-item-inner effect-apollo" href="' . $bookmark->link_url . '" title="' . $bookmark->link_description . '" target="_blank" >'. get_avatar($bookmark->link_notes,64) . '<span class="sitename">'. $bookmark->link_name .'</span></a></li>';
        }
        $output .= '</ul>';
    }
    return $output;
}
 
function get_link_items(){
    $linkcats = get_terms( 'link_category' );
    if ( !empty($linkcats) ) {
        foreach( $linkcats as $linkcat){            
            $result .=  '<h3 class="link-title">'.$linkcat->name.'</h3>';
            if( $linkcat->description ) $result .= '<div class="link-description">' . $linkcat->description . '</div>';
            $result .=  get_the_link_items($linkcat->term_id);
        }
    } else {
        $result = get_the_link_items();
    }
    return $result;
}
 
function shortcode_link(){
    return get_link_items();
}
add_shortcode('bigfalink', 'shortcode_link');

//所有设置已完成，如果往后的代码非您手工添加，很可能是因为您的其它主题有恶意代码。您可以定期查看此段代码后面有没有代码。
//所有设置已完成，如果往后的代码非您手工添加，很可能是因为您的其它主题有恶意代码。您可以定期查看此段代码后面有没有代码。
//所有设置已完成，如果往后的代码非您手工添加，很可能是因为您的其它主题有恶意代码。您可以定期查看此段代码后面有没有代码。
//所有设置已完成，如果往后的代码非您手工添加，很可能是因为您的其它主题有恶意代码。您可以定期查看此段代码后面有没有代码。
//所有设置已完成，如果往后的代码非您手工添加，很可能是因为您的其它主题有恶意代码。您可以定期查看此段代码后面有没有代码。

?>



