<?php
/**
 * Created by PhpStorm.
 * User: lius
 * Date: 2017/2/20
 * Time: 19:49
 */
$cat_id = 1;
$right_cat_id = 1;
if (is_category()) {
    $cat_id = get_cat_ID(single_cat_title('', false));
} elseif (is_home()) {
    $cat_id = waitig_gopt('index_cat_id');
} elseif (is_single()) {
    $categorys = get_the_category();
    $thiscat = $categorys[0];
    $cat_id = $thiscat->term_id;
}
$thiscat = get_category($cat_id);
/**
 * 标题
 */
$title = '';
if (is_home()) {
    $title = waitig_gopt('waitig_title');
} else {
    if (is_single()) {
        $title = $thiscat->name . '-' . the_title('', '', false);;
    } else {
        $title = $thiscat->name;
    }
    $title .= '_' . $thiscat->name . '最新章节_' . $thiscat->name . 'TXT下载_' . waitig_gopt("cat_author_" . $thiscat->term_id) . '新书全文免费阅读_' . get_option('blogname');
}
/**
 * 关键词
 */
$keyWords = '';
if (is_home()) {
    $keyWords = waitig_gopt('waitig_keywords');
} else {
    $keyWords = $thiscat->name . ',' . $thiscat->name . '吧,' . waitig_gopt("cat_author_" . $thiscat->term_id) . ',' . $thiscat->name . '小说,' . $thiscat->name . '最新章节,' . $thiscat->name . '无弹窗,' . $thiscat->name . '全文阅读,' . $thiscat->name . '免费阅读,' . $thiscat->name . 'TXT下载';
}
/**
 * 描述
 */
$description = '';
if (is_home()) {
    $description = waitig_gopt('waitig_description');
} else {
    $description = $thiscat->name . '是' . waitig_gopt("cat_author_" . $thiscat->term_id) . '创作的全新精彩小说，' . $thiscat->name . '最新章节来源于互联网网友,' . get_option('blogname') . '提供' . $thiscat->name . '全文在线免费阅读，及' . $thiscat->name . 'TXT下载，并且无任何弹窗广告。';
}
/**
 * base url
 */
$baseUrl = str_replace('', '/', dirname($_SERVER['SCRIPT_NAME']));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="zh-CN">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <title><?=$title?></title>
    <meta name="keywords" content="<?=$keyWords?>"/>
    <meta name="description" content="<?=$description?>"/>
    <meta name="applicable-device" content="pc,mobile"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <meta http-equiv="Cache-Control" content="no-transform"/>
    <meta property="og:type" content="novel"/>
    <meta property="og:title" content="<?=$thiscat->name?>"/>
    <meta property="og:description" content="<?=$thiscat->description?>"/>
    <meta property="og:image" content="<?=waitig_gopt("cat_image_" . $thiscat->term_id)?>"/>
    <meta property="og:url" content="<?=get_category_link($thiscat->term_id) ?>"/>
    <meta property="og:novel:status" content="连载"/>
    <meta property="og:novel:author" content="<?=waitig_gopt("cat_author_" . $thiscat->term_id)?>"/>
    <meta property="og:novel:book_name" content="<?=$thiscat->name?>"/>
    <meta property="og:novel:read_url" content="<?=get_category_link($thiscat->term_id)?>"/>
    <?php query_posts("posts_per_page=1&cat=" . $thiscat->term_id) ?>
    <?php while (have_posts()) : the_post(); ?>
        <meta property="og:novel:update_time" content="<?=the_time('Y-m-d H:i')?>"/>
        <meta property="og:novel:latest_chapter_name" content="<?=the_title()?>"/>
        <meta property="og:novel:latest_chapter_url" content="<?=the_permalink()?>"/>
    <?php endwhile;
    wp_reset_query(); ?>
    <link href="<?php bloginfo('template_url'); ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php bloginfo('template_url'); ?>/css/style.css?ver=0.12" rel="stylesheet">
    <link href="<?php bloginfo('template_url'); ?>/css/css.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="canonical" href="<?php echo get_category_link($thiscat->term_id) ?>">
    <?php wp_head(); ?>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/b.m.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/wnovel.js"></script>
    <?php echo waitig_gopt('waitig_head_code'); ?>
    <style type="text/css">
        <?=getStyles()?>
    </style>
</head>
<body style="background-color: rgb(255, 255, 255);">
<!-- Fixed navbar -->
<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid container ">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo home_url(); ?>">
                <?php bloginfo('name'); ?>
            </a>
        </div>
        <?php if (waitig_gopt('nav_auto_set')) { ?>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav" style="float:right">
                    <?php $args = array(
                        'orderby' => 'name',
                        'order' => 'ASC',
                        'hierarchical' => 0,
                        'child_of' => 0,
                        'hide_empty' => 1,
                        'taxonomy' => 'category',
                        'exclude' => waitig_gopt('index_nav_except_id')
                    );
                    $cat_number = 1;
                    $categories = get_categories($args);
                    foreach ($categories as $category) {
                        if ($cat_number <= waitig_gopt('nav_novel_number')) {
                            echo '<li class="navitem" nav="cat_' . $category->slug . '">';
                            echo ' <a href="' . get_category_link($category->term_id) . '" title="' . sprintf(__("《%s》在线阅读"), $category->name) . '" ' . '>' . $category->name . ' </a>';
                            echo ' </li>';
                            $cat_number += 1;
                        } else {
                            break;
                        }
                    }
                    ?>
                    <li class="dropdown">
                        <a href="/" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">更多 <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <?php
                            $categories = get_categories($args);
                            $cat_number = 1;
                            foreach ($categories as $category) {
                                //echo $cat_number;
                                if ($cat_number > waitig_gopt('nav_novel_number')) {
                                    //echo 'aaa';
                                    echo '<li><a href="' . get_category_link($category->term_id) . '" title="' . sprintf(__("《%s》在线阅读"), $category->name) . '" ' . '>' . $category->name . ' </a></li>';
                                }
                                $cat_number += 1;
                            }
                            ?>
                        </ul>
                </ul>
            </div><!--/.nav-collapse -->
            <?php
        } else {
            wp_nav_menu(array(
                    'menu' => '',
                    'theme_location' => 'header_menu',
                    'depth' => 2,
                    'container' => 'div',
                    'container_class' => 'collapse navbar-collapse',
                    'container_id' => 'bs-example-navbar-collapse-1',
                    'menu_class' => 'nav navbar-nav',
                    'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
                    'walker' => new WP_Bootstrap_Navwalker())
            );
        }
        ?>
    </div>
</nav>