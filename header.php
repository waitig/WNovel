<?php
/**
 * Created by PhpStorm.
 * User: lius
 * Date: 2017/2/20
 * Time: 19:49
 */
$cat_id=1;
$right_cat_id=1;
if(is_category()){
    /*$cat_ids = get_the_category();
	$cat_id = $cat_ids[0]->cat_ID;*/
    $cat_id=get_cat_ID( single_cat_title('',false) );
}
elseif(is_home()){
    $cat_id = waitig_gopt('index_cat_id');
}
elseif(is_single()){
    $categorys = get_the_category();
    $category = $categorys[0];
    $cat_id=$category->term_id;
}
$thiscat = get_category($cat_id);
?>
<html lang="zh-CN"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title><?php
        if(is_single()){
            wp_title();
        }
        else{
            echo $thiscat->name;
        }
        echo '_'.$thiscat->name.'最新章节_'.waitig_gopt("ashu_cat_value_".$thiscat->term_id).'新书全文免费阅读_'.get_option('blogname');?></title>
    <meta name="keywords" content="<?php echo waitig_gopt('waitig_keywords'); ?>">
    <meta name="description" content="<?php bloginfo('waitig_description'); ?>">
    <meta http-equiv="Cache-Control" content="no-transform ">
    <meta name="robots" content="all">
    <meta property="og:type" content="novel">
    <meta property="og:title" content="<?php wp_title();?>">
    <meta property="og:description" content="<?php bloginfo('waitig_description'); ?>">
    <meta property="og:image" content="<?php echo waitig_gopt('og_image'); ?>">
    <meta property="og:novel:read_url" content="<?php site_url(); ?>">
    <meta property="og:url" content="<?php site_url(); ?>">
    <meta property="og:novel:status" content="连载">
    <link href="<?php bloginfo('template_url'); ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php bloginfo('template_url'); ?>/css/style.css" rel="stylesheet">
    <link href="<?php bloginfo('template_url'); ?>/css/css.css" rel="stylesheet">
    <?php wp_head();?>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/b.m.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/17mbbase.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/17mb.js"></script>
</head>
<body>
<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only"><?php bloginfo('name');?></span>
            </button>
            <a class="navbar-brand" href="/"><?php bloginfo('name');?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav" style="float:right">
                <?php $args=array(
                'orderby' => 'name',
                'order' => 'ASC',
                    'hierarchical'=>0,
                    'child_of'=> 0,
                    'hide_empty'=> 1,
                    'taxonomy'=> 'category',
                    'number'=> waitig_gopt('nav_novel_number'),

                );
                $categories=get_categories($args);
                foreach($categories as $category) {
                echo '<li class="navitem" nav="cat_'. $category-> slug .'">';
                    echo ' <a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '" ' . '>' . $category->name.' </a>';
                    echo ' </li>';
                }
                ?>
                <li class="dropdown">
                    <a href="/" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">更多 <span class="caret"></span></a>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>


