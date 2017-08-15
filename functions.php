<?php
/**
 * Created by PhpStorm.
 * User: lius
 * Date: 2017/2/20
 * Time: 19:49
 */
$dname = 'WNovel';
$themename = 'WNovel';
$themeDir = get_stylesheet_directory_uri();
include('admin/waitig.php');
function deel_breadcrumbs()
{
    if (!is_single()) return false;
    $categorys = get_the_category();
    $category = $categorys[0];

    return '<ol class="breadcrumb"><li><a title="返回首页" href="' . get_bloginfo('url') . '"></a> </li><li> ' . get_category_parents($category->term_id, true, ' </li><li> ') . '<li class="active">' . get_the_title() . '</li></ol>';
}

// 取消原有jQuery
function footerScript()
{
    if (!is_admin()) {
        wp_deregister_script('jquery');
        wp_register_script('jquery', '//libs.baidu.com/jquery/1.8.3/jquery.min.js', false, '1.0');
        wp_enqueue_script('jquery');
        wp_register_style('style', get_template_directory_uri() . '/style.css', false, '1.10');
        wp_enqueue_style('style');
    }
}

add_action('wp_enqueue_scripts', 'footerScript');
function deel_strimwidth($str, $start, $width, $trimmarker)
{
    $output = preg_replace('/^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $start . '}((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $width . '}).*/s', '\1', $str);
    return $output . $trimmarker;
}

function waitig_gopt($e)
{
    return stripslashes(get_option($e));
}

if (waitig_gopt('waitig_remove_head_code')) {
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'index_rel_link');
    remove_action('wp_head', 'start_post_rel_link', 10, 0);
    remove_action('wp_head', 'wp_generator');
}
function googlo_remove_open_sans_from_wp_core()
{
    wp_deregister_style('open-sans');
    wp_register_style('open-sans', false);
    wp_enqueue_style('open-sans', '');
}

add_action('init', 'googlo_remove_open_sans_from_wp_core');
//获取所有站点分类id
function Bing_show_category()
{
    global $wpdb;
    $output = '';
    $request = "SELECT $wpdb->terms.term_id, name FROM $wpdb->terms ";
    $request .= " LEFT JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id ";
    $request .= " WHERE $wpdb->term_taxonomy.taxonomy = 'category' ";
    $request .= " ORDER BY term_id asc";
    $categorys = $wpdb->get_results($request);
    foreach ($categorys as $category) { //调用菜单
        $output .= $category->name . "&nbsp;&nbsp;[&nbsp" . $category->term_id . '&nbsp;]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

    }
    return $output;
}

//免插件去除Category
if (waitig_gopt('waitig_uncategroy_en')) {
    add_action('load-themes.php', 'no_category_base_refresh_rules');
    add_action('created_category', 'no_category_base_refresh_rules');
    add_action('edited_category', 'no_category_base_refresh_rules');
    add_action('delete_category', 'no_category_base_refresh_rules');

    function no_category_base_refresh_rules()
    {
        global $wp_rewrite;
        $wp_rewrite->flush_rules();
    }

    // Remove category base
    add_action('init', 'no_category_base_permastruct');
    function no_category_base_permastruct()
    {
        global $wp_rewrite, $wp_version;
        if (version_compare($wp_version, '3.4', '<')) {
        } else {
            $wp_rewrite->extra_permastructs['category']['struct'] = '%category%';
        }
    }

    // Add our custom category rewrite rules
    add_filter('category_rewrite_rules', 'no_category_base_rewrite_rules');
    function no_category_base_rewrite_rules($category_rewrite)
    {
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
    function no_category_base_query_vars($public_query_vars)
    {
        $public_query_vars[] = 'category_redirect';
        return $public_query_vars;
    }

    // Redirect if 'category_redirect' is set
    add_filter('request', 'no_category_base_request');
    function no_category_base_request($query_vars)
    {
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
function ashu_add_cat_field()
{
    global $themeDir;
    echo '<div class="form-field">';
    echo '<label for="cat_author" >小说作者</label>';
    echo '<input type="text" size="" value="" id="cat_author" name="cat_author"/>';
    echo '<p>请输入本小说作者</p>';
    echo '</div>';
    echo '<div class="form-field">';
    echo '<label for="cat_image" >小说图片</label>';
    echo '<input type="text" size="" value="" id="cat_image" name="cat_image" style="width:80%"/>';
    echo '<input type="button" class="button button-primary" onclick="insertImage_cat()" value="上传图片"/>';
    echo '<p>请输入本小说图片链接地址</p>';
    echo '<br/>';
    echo '<img id="img_cat_image" style="max-width:80%;" src="">';
    echo '</div>';
    echo '<div class="form-field">';
    echo '<label for="cat_novel_about" >作品相关</label>';
    echo '<textarea type="textarea" rows="5" cols="40" class="large-text code" value="" id="cat_novel_about" name="cat_novel_about"/></textarea>';
    echo '<p>请输入作品相关</p>';
    echo '</div>';
    echo '<div class="form-field">';
    echo '<label for="cat_other_novel" >本作者其他小说</label>';
    echo '<textarea type="textarea" rows="5" cols="40" class="large-text code" value="" id="cat_other_novel" name="cat_other_novel"/></textarea>';
    echo '<p>请输入本作者其他小说名称及链接（HTML格式，每个项目用li标签包裹）</p>';
    echo '</div>';
    echo '<div class="form-field">';
    echo '<label for="cat_download_url" >小说TXT下载地址</label>';
    echo '<input type="text" size="" value="" id="cat_download_url" name="cat_download_url"/>';
    echo '<p>请输入本小说TXT文件下载地址</p>';
    echo '</div>';
    echo "<script type='application/javascript' src='$themeDir/js/jquery.min.js'></script>";
    echo "<script type='application/javascript' src='$themeDir/js/wnovel.js'></script>";
    wp_enqueue_media();//加载媒体中心
}

add_action('category_add_form_fields', 'ashu_add_cat_field', 10, 2);

//分类再编辑需要接受参数
function ashu_edit_cat_field($tag)
{
    global $themeDir;
    echo '<tr class="form-field"><th>小说作者</th><td><input type="text" size="40" value="' . get_option('cat_author_' . $tag->term_id) . '" id="cat_author" name="cat_author"/><p class="description">请输入本小说作者</p></td></tr>';
    echo '<tr><th>小说图片地址</th><td><input type="text" style="width:60%" size="40" value="' . get_option('cat_image_' . $tag->term_id) . '" id="cat_image" name="cat_image"/><input type="button" class="button button-primary" onclick="insertImage_cat()" value="上传图片"/>&nbsp;&nbsp;&nbsp;&nbsp;请输入本小说图片链接地址';
    echo '<p class="description"><img style="max-width:80%" id="img_cat_image" src="' . get_option('cat_image_' . $tag->term_id) . '"/></p>';
    echo '</td></tr>';
    echo '<tr class="form-field"><th>本小说的作品相关内容</th><td><textarea type="textarea" rows="5" cols="40" class="large-text code" value="" id="cat_novel_about" name="cat_novel_about"/>' . stripslashes(get_option('cat_novel_about_' . $tag->term_id)) . '</textarea><br/>请输入作品相关</td></tr>';
    echo '<tr class="form-field"><th>本作者其他小说</th><td><textarea type="textarea" rows="5" cols="40" class="large-text code" value="" id="cat_other_novel" name="cat_other_novel"/>' . stripslashes(get_option('cat_other_novel_' . $tag->term_id)) . '</textarea><br/>请输入本作者其他小说名称及链接（HTML格式，每个项目用li标签包裹）</td></tr>';
    echo '<tr class="form-field"><th>小说TXT下载地址</th><td><input type="text" size="40" value="' . get_option('cat_download_url_' . $tag->term_id) . '" id="cat_download_url" name="cat_download_url"/>请输入本小说TXT文件下载地址</td></tr>';
    echo "<script type='application/javascript' src='$themeDir/js/jquery.min.js'></script>";
    echo "<script type='application/javascript' src='$themeDir/js/wnovel.js'></script>";
    wp_enqueue_media();//加载媒体中心
}
add_action('category_edit_form_fields', 'ashu_edit_cat_field', 10, 2);

if (function_exists(theme_check) == null) {
    echo "Theme check ERROR";
    exit;
}
/**************保存数据接受的参数为分类ID*****************/
function ashu_taxonomy_metadata($term_id)
{
    if (isset($_POST['cat_author'])) {
        //判断权限--可改
        if (!current_user_can('manage_categories')) {
            return $term_id;
        }

        $data = $_POST['cat_author'];
        $key = 'cat_author_' . $term_id; //选项名为 ashu_cat_value_1 类型
        update_option($key, $data); //更新选项值
    }
    if (isset($_POST['cat_image'])) {
        //判断权限--可改
        if (!current_user_can('manage_categories')) {
            return $term_id;
        }

        $data = $_POST['cat_image'];
        $key = 'cat_image_' . $term_id; //选项名为 ashu_cat_value_1 类型
        update_option($key, $data); //更新选项值
    }
    if (isset($_POST['cat_novel_about'])) {
        //判断权限--可改
        if (!current_user_can('manage_categories')) {
            return $term_id;
        }

        $data = $_POST['cat_novel_about'];
        $key = 'cat_novel_about_' . $term_id; //选项名为 ashu_cat_value_1 类型
        update_option($key, $data); //更新选项值
    }
    if (isset($_POST['cat_other_novel'])) {
        //判断权限--可改
        if (!current_user_can('manage_categories')) {
            return $term_id;
        }

        $data = $_POST['cat_other_novel'];
        $key = 'cat_other_novel_' . $term_id; //选项名为 ashu_cat_value_1 类型
        update_option($key, $data); //更新选项值
    }
    if (isset($_POST['cat_download_url'])) {
        //判断权限--可改
        if (!current_user_can('manage_categories')) {
            return $term_id;
        }

        $data = $_POST['cat_download_url'];
        $key = 'cat_download_url_' . $term_id; //选项名为 ashu_cat_value_1 类型
        update_option($key, $data); //更新选项值
    }
}
/*******虽然要两个钩子，但是我们可以两个钩子使用同一个函数********/
add_action('created_category', 'ashu_taxonomy_metadata', 10, 1);
add_action('edited_category', 'ashu_taxonomy_metadata', 10, 1);
//分类参数

//隐藏admin Bar
add_filter('show_admin_bar', 'hide_admin_bar');
function hide_admin_bar($flag)
{
    return false;
}

//主题自动更新
if (!waitig_gopt('waitig_updates_un')):
    require 'updates.php';
$example_update_checker = new ThemeUpdateChecker('WNovel', 'http://www.waitig.com/themes/WNovel/info.json'
    //此处链接不可改
    );
endif;

function get_alert()
{
    $url = "http://img.waitig.com/themes/WNovel/alert.html";
    @$fp = fopen($url, 'r');
    if (!$fp) {
        return '无网络连接！';
        //exit;
    }
    //stream_get_meta_data($fp);
    $result = "";
    while (!feof($fp)) {
        $result .= fgets($fp, 1024);
    }
    fclose($fp);
    return $result;
}

//注册菜单
register_nav_menus(array(
    'header_menu' => __('顶部全站菜单')
    ));


/**
 * Class BS_Walker_Nav_Menu
 * 使菜单使用Boostrap
 * From: 等英博客出品 http://www.waitig.com
 */
require_once 'wp-bootstrap-navwalker.php';

add_action('admin_menu', 'register_my_custom_submenu_page');
function register_my_custom_submenu_page() {
    add_submenu_page( 'waitig.php', '主题使用手册', '主题使用手册', 'manage_options', 'my-custom-submenu-page', 'my_custom_submenu_page_callback');
}

function my_custom_submenu_page_callback() {
    echo '<iframe src="https://www.waitig.com/wnovel-theme-user-manual.html" width="100%"  height="800px" frameborder="0"></iframe>';
}

