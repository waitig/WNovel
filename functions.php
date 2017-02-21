<?php
/**
 * Created by PhpStorm.
 * User: lius
 * Date: 2017/2/20
 * Time: 19:49
 */
$dname = 'wait';

include('admin/waitig.php');
function deel_breadcrumbs(){
	if( !is_single() ) return false;
	$categorys = get_the_category();
	$category = $categorys[0];

	return '<ol class="breadcrumb"><li><a title="返回首页" href="'.get_bloginfo('url').'"></a> </li><li> '.get_category_parents($category->term_id, true, ' </li><li> ').'<li class="active">'.get_the_title().'</li></ol>';
}

// 取消原有jQuery
function footerScript() {
	if ( !is_admin() ) {
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery','//libs.baidu.com/jquery/1.8.3/jquery.min.js', false,'1.0');
		wp_enqueue_script( 'jquery' );
		wp_register_script( 'default', get_template_directory_uri() . '/js/jquery.js', false, '1.0', waitig_gopt('d_jquerybom_b') ? true : false );
		wp_enqueue_script( 'default' );
		wp_register_style( 'style', get_template_directory_uri() . '/style.css',false,'1.0' );
		wp_enqueue_style( 'style' );
	}
}
add_action( 'wp_enqueue_scripts', 'footerScript' );

function waitig_gopt($e){
	return stripslashes(get_option($e));
}

