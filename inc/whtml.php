<?php
/* 给分类目录和单页链接末尾加上斜杠 */
$permalink_structure = get_option('permalink_structure');
if (!$permalink_structure || '/' === substr($permalink_structure, -1))
    return;
add_filter('user_trailingslashit', 'ppm_fixe_trailingslash', 10, 2);
function ppm_fixe_trailingslash($url, $type)
{
    if ('single' === $type)
        return $url;
    return trailingslashit($url);
}

//引入文件
require_once(ABSPATH . 'wp-admin/includes/file.php');

//是否开启首页缓存
$indexOn = waitig_gopt('waitig_Cache_index_on');
define('INDEXON', $indexOn);

//是否开启分类页缓存
$cateOn = waitig_gopt('waitig_Cache_cate_on');
define('CATEON', $cateOn);

//是否开启页面缓存
$PageOn = waitig_gopt('waitig_Cache_page_on');
define('PAGEON', $PageOn);


//请求脚本的网址
$http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
$scriptUrl = rtrim($http_type . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], "/");
define('SCRIPTURL', $scriptUrl);

//网站首页地址
$indexUrl = get_site_url();
define('INDEXURL', $indexUrl);

//网站根路径
$homePath = get_home_path();
define('HOMEPATH', $homePath);

//页脚备注
$footMeta = '<!--您正在浏览的页面是由'. $themename .'主题' . constant('THEMEVERSION') . '版本缓存系统创建的真实HTML文件，缓存创建日期：' . date("Y-m-d H:i:s") . ' -->';
define('FOOTMETA', $footMeta);

define('SAFETAG', '<!--THIS IS A REAL HTML , CREATED BY '. $themename .' THEME.-->');

/**
 * 处理删除文章的请求
 */


/**
 * 删除缓存
 */


/**
 * 根据路径和内容创建HTML文件
 * @param $FilePath
 * @param $Content
 * 等英博客出品 https://www.waitig.com
 */
function CreateHtmlFile($FilePath, $Content)
{
    waitig_logs('开始,FilePath:' . $FilePath);
    $FilePath = preg_replace('/[ <>\'\"\r\n\t\(\)]/', '', $FilePath);

    // if there is http:// $FilePath will return its bas path
    $dir_array = explode("/", $FilePath);

    //split the FilePath
    $max_index = count($dir_array);
    $i = 0;
    $path = $_SERVER['DOCUMENT_ROOT'] . "/";

    while ($i < $max_index) {
        $path .= "/" . $dir_array[$i];
        $path = str_replace("//", "/", $path);
        waitig_logs($path . '--' . $i . '--');
        if ($dir_array[$i] == "") {
            $i++;
            continue;
        }

        if (substr_count($path, '&')) return true;
        if (substr_count($path, '?')) return true;
        if (!substr_count($path, '.htm')) {
            //如果完整路径里没有html，则代表此路径为分类或者文章页
            if (!file_exists($path)) {
                waitig_logs('是目录');
                mkdir($path, 0777);
                chmod($path, 0777);
            }
        }
        $i++;
    }

    waitig_logs($path);
    waitig_logs(is_dir($path));

    if (is_dir($path)) {
        $path = $path . "/index.html";
    }
    if (!strstr(strtolower($Content), '</html>')) return true;

    //if sql error ignore...
    $fp = @fopen($path, "w+");
    if ($fp) {
        @chmod($path, 0666);
        @flock($fp, LOCK_EX);

        // write the file。
        fwrite($fp, $Content);
        @flock($fp, LOCK_UN);
        fclose($fp);
    }
    waitig_logs('结束');
    return true;
}

function checkBuffer()
{
    $needBuffer = false;
    if (substr_count($_SERVER['REQUEST_URI'], '?')) {
        return false;
    }
    if (substr_count($_SERVER['REQUEST_URI'], '../')) {
        return false;
    }
    if (substr_count($_SERVER['REQUEST_URI'], '.php') || substr_count($_SERVER['REQUEST_URI'], 'wp-')) {
        return false;
    }
    //未登录
    if (strlen($_COOKIE['wordpress_logged_in_' . COOKIEHASH]) < 4) {
        //判断首页
        if (is_home() && INDEXON) {
            $needBuffer = true;
            return true;
        } elseif (is_category() && CATEON) {
            $needBuffer = true;
            return true;
        } elseif (is_page() && PAGEON) {
            $needBuffer = true;
            return true;
        } elseif (is_single()) {
            $needBuffer = true;
            return true;
        }
    }
    return false;
}

//缓存钩子函数
function createHtml()
{
    $needBuffer = checkBuffer();
    if ($needBuffer) {
        //将输出缓冲重定向到cos_cache_ob_callback函数中
        ob_start('cos_cache_ob_callback');
        register_shutdown_function('cos_cache_shutdown_callback');
    }
}

/**
 * 处理输出缓存
 * @param $buffer
 * @return mixed
 * 等英博客出品 https://www.waitig.com
 */
function cos_cache_ob_callback($buffer)
{
    $buffer = preg_replace('/(<\s*input[^>]+?(name=["\']author[\'"])[^>]+?value=(["\']))([^"\']+?)\3/i', '\1\3', $buffer);

    $buffer = preg_replace('/(<\s*input[^>]+?value=)([\'"])[^\'"]+\2([^>]+?name=[\'"]author[\'"])/i', '\1""\3', $buffer);

    $buffer = preg_replace('/(<\s*input[^>]+?(name=["\']url[\'"])[^>]+?value=(["\']))([^"\']+?)\3/i', '\1\3', $buffer);

    $buffer = preg_replace('/(<\s*input[^>]+?value=)([\'"])[^\'"]+\2([^>]+?name=[\'"]url[\'"])/i', '\1""\3', $buffer);

    $buffer = preg_replace('/(<\s*input[^>]+?(name=["\']email[\'"])[^>]+?value=(["\']))([^"\']+?)\3/i', '\1\3', $buffer);

    $buffer = preg_replace('/(<\s*input[^>]+?value=)([\'"])[^\'"]+\2([^>]+?name=[\'"]email[\'"])/i', '\1""\3', $buffer);

    if (!substr_count($buffer, SAFETAG)) return $buffer;
    if (substr_count($buffer, 'post_password') > 0) return $buffer;//to check if post password protected
    $wppasscookie = "wp-postpass_" . COOKIEHASH;
    if (strlen($_COOKIE[$wppasscookie]) > 0) return $buffer;//to check if post password protected


    elseif ((SCRIPTURL == INDEXURL) && INDEXON) {// creat homepage
        $fp = @fopen(HOMEPATH . "index.html", "w+");
        if ($fp) {
            @flock($fp, LOCK_EX);
            fwrite($fp, $buffer . FOOTMETA);
            @flock($fp, LOCK_UN);
            fclose($fp);
        }
    } else
        CreateHtmlFile($_SERVER['REQUEST_URI'], $buffer . FOOTMETA);
    return $buffer;
}

/**
 * 获取缓存结束
 * 等英博客出品 https://www.waitig.com
 */
function cos_cache_shutdown_callback()
{
    ob_end_flush();
    flush();
}

/**
 * 根据URL删除缓存
 */
if (!function_exists('DelCacheByUrl')) {
    function DelCacheByUrl($url)
    {
        waitig_logs('开始根据url删除缓存，url：' . $url);
        $url = HOMEPATH . str_replace(INDEXURL, "", $url);
        $url = str_replace("//", "/", $url);
        waitig_logs('真实路径' . $url);
        if (file_exists($url)) {
            waitig_logs('路径存在，开始删除');
            if (is_dir($url)) {
                @unlink($url . "/index.html");
                @rmdir($url);
            } else @unlink($url);
        }
    }
}

if (!function_exists('htmlCacheDel')) {
    /**
     * 根据文章ID删除文章缓存
     * @param $post_ID
     * @return bool
     * 等英博客出品 https://www.waitig.com
     */
    function htmlCacheDel($post_ID)
    {
        if ($post_ID == "") return true;
        $uri = get_permalink($post_ID);
        DelCacheByUrl($uri);
        return true;
    }
}

if (!function_exists('htmlCacheDelNb')) {
    /**
     * 删除相邻的文章
     * @param $post_ID
     * @return bool
     * 等英博客出品 https://www.waitig.com
     */
    function htmlCacheDelNb($post_ID)
    {
        if ($post_ID == "") return true;
        $uri = get_permalink($post_ID);
        DelCacheByUrl($uri);

        //删除同一小说下相邻文章
        global $wpdb;

        $query = "SELECT DISTINCT MAX(a.object_id) AS ID FROM `".$wpdb->term_relationships."` a,`" . $wpdb->posts . "` b WHERE a.term_taxonomy_id IN ( SELECT term_taxonomy_id FROM `".$wpdb->term_relationships."` WHERE `object_id` = '$post_ID' ) AND a.object_id < '$post_ID' AND a.object_id = b.id AND b.post_status = 'publish' AND b.post_type='post' GROUP BY a.term_taxonomy_id UNION SELECT DISTINCT MIN(a.object_id) AS ID FROM `".$wpdb->term_relationships."` a,`" . $wpdb->posts . "` b WHERE a.term_taxonomy_id IN ( SELECT term_taxonomy_id FROM `".$wpdb->term_relationships."` WHERE `object_id` = '$post_ID' ) AND a.object_id > '$post_ID' AND a.object_id = b.id AND b.post_status = 'publish' AND b.post_type='post' GROUP BY a.term_taxonomy_id";
        waitig_logs('查询SQL：'.$query);
        $postRes = $wpdb->get_results($query);
        waitig_logs(json_encode($postRes));
        foreach($postRes as $post){
            if($post->ID != ''){
                $url = get_permalink($post->ID);
                waitig_logs('删除相关文章，相关文章URL：'.$url);
                DelCacheByUrl($url);
            }
        }
        return true;
    }
}

if (!function_exists('createIndexHTML')) {
    /**
     * 更新主页缓存
     * @param $post_ID
     * @return bool
     * 等英博客出品 https://www.waitig.com
     */
    function createIndexHTML($post_ID)
    {
        waitig_logs('删除首页缓存');
        if ($post_ID == "") return true;
        DelCacheByUrl(INDEXURL);
        return true;
    }
}

if (!function_exists('createCateHTML')) {
    /**
     * 更新小说页缓存
     * @param $post_ID
     * @return bool
     * 等英博客出品 https://www.waitig.com
     */
    function createCateHTML($post_ID)
    {
        waitig_logs($post_ID);
        if ($post_ID == "") return true;
        $categroy = get_the_category($post_ID);
        $rootCate = get_root_category($categroy[0]);
        $cateLink = get_category_link($rootCate->term_id);
        DelCacheByUrl($cateLink);
        return true;
    }
}

$is_add_comment_is = true;
/*
 * with ajax comments
 */
if (!function_exists("cos_comments_js")) {
    function cos_comments_js($postID)
    {
        global $is_add_comment_is;
        if ($is_add_comment_is) {
            $is_add_comment_is = false;
            ?>
            <script language="JavaScript" type="text/javascript"
                    src="<?php echo CosSiteHome; ?>/wp-content/plugins/cos-html-cache/common.js.php?hash=<?php echo COOKIEHASH; ?>"></script>
            <script language="JavaScript" type="text/javascript">
                //<![CDATA[
                var hash = "<?php echo COOKIEHASH;?>";
                var author_cookie = "comment_author_" + hash;
                var email_cookie = "comment_author_email_" + hash;
                var url_cookie = "comment_author_url_" + hash;
                var adminmail = "<?php  echo str_replace('@', '{_}', get_option('admin_email'));?>";
                var adminurl = "<?php  echo get_option('siteurl');?>";
                setCommForm();
                //]]>
            </script>
            <?php
        }
    }
}

/**
 * 输出安全标记，防止被二次缓存
 * 等英博客出品 http://www.waitig.com
 */
function CosSafeTag()
{
    if (checkBuffer()) {
        echo SAFETAG;
    }
}

function clearCommentHistory()
{
    global $comment_author_url, $comment_author_email, $comment_author;
    $comment_author_url = '';
    $comment_author_email = '';
    $comment_author = '';
}


function do_del_html_cache_action()
{
    //删除文章页
    if ((!empty($_POST['htmlCacheDelbt'])) && ($_POST['htmlCacheDelbt'] == '1')) {
        @unlink(HOMEPATH . "index.html");
        global $wpdb;
        if ($_POST['cache_id'] * 1 > 0) {
            DelCacheByUrl(get_permalink($_POST['cache_id']));
            $msg = __('删除成功 ID=' . $_POST['cache_id']);
        } else if (strlen($_POST['cache_id']) > 2) {
            $postRes = $wpdb->get_results("SELECT `ID`  FROM `" . $wpdb->posts . "` WHERE post_title LIKE '%" . $_POST['cache_id'] . "%' LIMIT 0,1 ");
            DelCacheByUrl(get_permalink($postRes[0]->ID));
            $msg = __('删除成功 Title=' . $_POST['cache_id']);
        } else {
            $postRes = $wpdb->get_results("SELECT `ID`  FROM `" . $wpdb->posts . "` WHERE post_status = 'publish' AND ( post_type='post' OR  post_type='page' )  ORDER BY post_modified DESC ");
            foreach ($postRes as $post) {
                DelCacheByUrl(get_permalink($post->ID));
            }
            $msg = __('HTML缓存清空成功！');
        }
        if ($msg)
            echo $msg;
        exit;
    } //删除分类
    elseif ((!empty($_POST['htmlCacheDelbt'])) && ($_POST['htmlCacheDelbt'] == '2')) {
        @unlink(HOMEPATH . "index.html");
        $msg = '';
        //根据ID删除分类
        if ($_POST['cache_id'] * 1 > 0) {
            $cateLink = get_category_link($_POST['cache_id'] * 1);
            DelCacheByUrl($cateLink);
            $msg = __('小说页缓存删除成功 ID=' . $_POST['cache_id']);
        } //删除全部分类
        else {
            $args = array(
                'type' => 'post',
                'child_of' => 0,
                'parent' => '0',
                'orderby' => 'ID',
                'order' => 'ASC',
                'hide_empty' => 0,
                'hierarchical' => 0,
                'exclude' => '1',
                'include' => '',
                'number' => '',
                'taxonomy' => 'category',
                'pad_counts' => false);
            $categorys = get_categories($args);
            foreach ($categorys as $category) {
                $cateLink = get_category_link($category->term_id);
                DelCacheByUrl($cateLink);
            }
            $msg = __('小说页HTML缓存清空成功！');
        }
        if ($msg)
            echo $msg;
        exit;
    }
}

add_action('get_header', 'do_del_html_cache_action');

if (waitig_gopt('waitig_Cache_on')):
    add_action('get_header', 'createHtml');
    add_action('get_footer', 'CosSafeTag');
    add_action('publish_post', 'htmlCacheDelNb');
    add_action('wp_insert_post', 'htmlCacheDelNb');
    if (INDEXON) {
        waitig_logs('新增首页更新钩子');
        add_action('publish_post', 'createIndexHTML');
        add_action('delete_post', 'createIndexHTML');
        add_action('edit_post', 'createIndexHTML');
    }

    if (CATEON) {
        waitig_logs('新增分类页更新钩子');
        add_action('publish_post', 'createCateHTML');
        add_action('delete_post', 'createCateHTML');
        add_action('edit_post', 'createCateHTML');
    }
    add_action('delete_post', 'htmlCacheDelNb');
    add_action('edit_post', 'htmlCacheDel');

endif;
