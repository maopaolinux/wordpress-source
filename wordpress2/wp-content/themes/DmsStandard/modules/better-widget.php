<?php 

class widget_tags extends WP_Widget{
 
    //添加小工具
    function __construct(){
        $this->WP_Widget( 'random_posts', __( 'DmsBetter带序列号的文章列表', 'DmsBetter' ), array( 'description' => __( '显示带序列号/最新/随机/热门的文章列表', 'DmsBetter' ) ) );
    }
     //小工具内容
    function widget( $args, $instance ){
 
        //导入当前侧边栏设置
        extract( $args, EXTR_SKIP );
 
        //输出小工具前代码
        echo $before_widget;
 
            //输出小工具标题
            echo $before_title . $instance['title'] . $after_title; 
            //随机文章
?>
<?php $cmntCnw = 1; 
$args = array(
'order'            => DESC,
'cat'              => $cat,
'orderby'          => $instance['orderby'],
'showposts'        => $instance['number'],
'caller_get_posts' => 1
);
query_posts($args);
while(have_posts()) : the_post();
?> 
<?php if($cmntCnw < 4) { // 每次输出之前都会判断$cmntcmw的值 ，如果当小于4 便执行
$i < 3;
$i++;
$tt = $i;
    if ($i == 1) {
	$tt = "";
	}
	else if ($i == 2) {
	$tt = "";
	}
	else if ($i == 3) {
	$tt = "";
	}
?>
<div class="top-first">
<li>
<span class = "top first item-<?php echo($i);?>"><?php echo($tt);?><?php echo($cmntCnw++);//小于4的时候，输出变量$cmntcmw的值 然后+1?></span> 
<a href="<?php the_permalink() ?>" target="_blank"><?php the_title(); ?></a>
</li>
</div>
<?php } else { // 如果大于4?> 
<div class="top-first">
<li>
<span class = "top first four"><?php echo($cmntCnw++); // 同样输出变量$cmntcnw?></span> 
<a href="<?php the_permalink() ?>" target="_blank"><?php the_title(); ?></a>
</li> 
</div>
<?php } ?><?php endwhile;wp_reset_query() ?>
<?php
 
        //输出小工具后代码
        echo $after_widget;
    }
 
    //更新选项
    function update( $instance, $old_instance ){
        $instance['title'] = strip_tags( $instance['title'] );
        $instance['number'] = (int) strip_tags( $instance['number'] );
        return $instance;
    }
 
    //选项表单
    function form( $instance ){
 
        //添加默认设置
        $instance = wp_parse_args( $instance, array( 
            'title' => __( '随机文章', 'DmsBetter' ),
            'number' => 10
        ) );
 
        //设置表单
?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( '标题', 'DmsBetter' ); ?>：</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>" />
        </p>
		<p>
  <label> 排序：
    <select id="<?php echo $this -> get_field_id('orderby'); ?>" name="<?php echo $this -> get_field_name('orderby'); ?>" style="width:100%;">
      <option value="comment_count" <?php selected('comment_count', $instance['orderby']); ?>>评论数热门</option>
      <option value="date" <?php selected('date', $instance['orderby']); ?>>发布时间</option>
      <option value="rand" <?php selected('rand', $instance['orderby']); ?>>随机</option>
    </select>
  </label>
</p>
        <p>
            <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( '文章数量', 'DmsBetter' ); ?>：</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" value="<?php echo $instance['number']; ?>" />
        </p>
<?php
    }
 
}
function DmsBetter_add_widget_tags(){
    register_widget( 'widget_tags' );
}
add_action( 'widgets_init', 'DmsBetter_add_widget_tags' );
?>