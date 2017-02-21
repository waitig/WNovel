<?php
/**
 * Created by PhpStorm.
 * User: lius
 * Date: 2017/2/20
 * Time: 19:49
 */
?>
<html lang="zh-CN"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title><?php wp_title();?></title>
    <meta name="keywords" content="<?php echo waitig_gopt('keywords'); ?>">
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <meta http-equiv="Cache-Control" content="no-transform ">
    <meta name="robots" content="all">
    <meta property="og:type" content="novel">
    <meta property="og:title" content="<?php wp_title();?>">
    <meta property="og:description" content="<?php bloginfo('description'); ?>">
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
                <span class="sr-only"><?php wp_title();?></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"><?php wp_title();?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="navitem" nav="cat_1" ><a href="/list/1-1.html">玄幻 </a></li>
                <li class="navitem" nav="cat_2" ><a href="/list/2-1.html">仙侠 </a></li>
                <li class="navitem" nav="cat_3" ><a href="/list/3-1.html">言情 </a></li>
                <li class="navitem" nav="cat_4" ><a href="/list/4-1.html">历史 </a></li>
                <li class="navitem" nav="cat_5" ><a href="/list/5-1.html">网游 </a></li>
                <li class="navitem" nav="cat_6" ><a href="/list/6-1.html">科幻 </a></li>
                <li class="navitem" nav="cat_7" ><a href="/list/7-1.html">恐怖 </a></li>
                <li class="navitem" nav="cat_8" ><a href="/list/8-1.html">其他 </a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>


