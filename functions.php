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
function deel_strimwidth($str ,$start , $width ,$trimmarker ){
    $output = preg_replace('/^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$start.'}((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$width.'}).*/s','\1',$str);
    return $output.$trimmarker;
}
function waitig_gopt($e){
	return stripslashes(get_option($e));
}
if(waitig_gopt('waitig_remove_head_code'))
{
    remove_action( 'wp_head',   'feed_links_extra', 3 );
    remove_action( 'wp_head',   'rsd_link' );
    remove_action( 'wp_head',   'wlwmanifest_link' );
    remove_action( 'wp_head',   'index_rel_link' );
    remove_action( 'wp_head',   'start_post_rel_link', 10, 0 );
    remove_action( 'wp_head',   'wp_generator' );
}
function googlo_remove_open_sans_from_wp_core() {
    wp_deregister_style('open-sans');
    wp_register_style('open-sans', false);
    wp_enqueue_style('open-sans', '');
}
add_action('init', 'googlo_remove_open_sans_from_wp_core');
//获取所有站点分类id
function Bing_show_category() {
    global $wpdb;
    $output = '';
    $request = "SELECT $wpdb->terms.term_id, name FROM $wpdb->terms ";
    $request.= " LEFT JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id ";
    $request.= " WHERE $wpdb->term_taxonomy.taxonomy = 'category' ";
    $request.= " ORDER BY term_id asc";
    $categorys = $wpdb->get_results($request);
    foreach ($categorys as $category) { //调用菜单
        $output .= $category->name . "=(&nbsp;" . $category->term_id . '&nbsp;),&nbsp;&nbsp;';

    }
    return $output;
}
//免插件去除Category
if (waitig_gopt('waitig_uncategroy_en')){
    add_action('load-themes.php', 'no_category_base_refresh_rules');
    add_action('created_category', 'no_category_base_refresh_rules');
    add_action('edited_category', 'no_category_base_refresh_rules');
    add_action('delete_category', 'no_category_base_refresh_rules');

    function no_category_base_refresh_rules() {
        global $wp_rewrite;
        $wp_rewrite->flush_rules();
    }
    // Remove category base
    add_action('init', 'no_category_base_permastruct');
    function no_category_base_permastruct() {
        global $wp_rewrite, $wp_version;
        if (version_compare($wp_version, '3.4', '<')) {
        } else {
            $wp_rewrite->extra_permastructs['category']['struct'] = '%category%';
        }
    }
    // Add our custom category rewrite rules
    add_filter('category_rewrite_rules', 'no_category_base_rewrite_rules');
    function no_category_base_rewrite_rules($category_rewrite) {
        //var_dump($category_rewrite); // For Debugging
        $category_rewrite = array();
        $categories = get_categories(array(
            'hide_empty' => false
        ));
        foreach ($categories as $category) {
            $category_nicename = $category->slug;
            if ($category->parent == $category->cat_ID) // recursive recursion
                $category->parent = 0;
            elseif ($category->parent != 0) $category_nicename = get_category_parents($category->parent, false, '/', true) . $category_nicename;
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
}

//分类参数
function ashu_add_cat_field(){
    echo '<div class="form-field">';
    echo '<label for="cat_author" >分类作者</label>';
    echo '<input type="text" size="" value="" id="cat_author" name="cat_author"/>';
    echo '<p>请输入本分类作者</p>';
    echo '</div>';
    echo '<div class="form-field">';
    echo '<label for="cat_image" >分类图片</label>';
    echo '<input type="text" size="" value="" id="cat_image" name="cat_image"/>';
    echo '<p>请输入本分类图片链接地址</p>';
    echo '</div>';
}
add_action('category_add_form_fields','ashu_add_cat_field', 10, 2);

//分类再编辑需要接受参数
function ashu_edit_cat_field($tag){
    echo '<tr><th>分类作者</th><td><input type="text" size="40" value="'.get_option('cat_author_'.$tag->term_id).'" id="cat_author" name="cat_author"/>请输入本分类作者</td></tr>';
    echo '<tr><th>分类图片地址</th><td><input type="text" size="40" value="'.get_option('cat_image_'.$tag->term_id).'" id="cat_image" name="cat_image"/>请输入本分类图片链接地址</td></tr>';


}
add_action('category_edit_form_fields','ashu_edit_cat_field', 10, 2);


/**************保存数据接受的参数为分类ID*****************/
function ashu_taxonomy_metadata($term_id){
    if(isset($_POST['cat_author'])){
        //判断权限--可改
        if(!current_user_can('manage_categories')){
            return $term_id ;
        }

        $data = $_POST['cat_author'];
        $key = 'cat_author_'.$term_id; //选项名为 ashu_cat_value_1 类型
        update_option( $key, $data ); //更新选项值
    }
    if(isset($_POST['cat_image'])){
        //判断权限--可改
        if(!current_user_can('manage_categories')){
            return $term_id ;
        }

        $data = $_POST['cat_image'];
        $key = 'cat_image_'.$term_id; //选项名为 ashu_cat_value_1 类型
        update_option( $key, $data ); //更新选项值
    }
}
/*******虽然要两个钩子，但是我们可以两个钩子使用同一个函数********/
add_action('created_category', 'ashu_taxonomy_metadata', 10, 1);
add_action('edited_category','ashu_taxonomy_metadata', 10, 1);
//分类参数