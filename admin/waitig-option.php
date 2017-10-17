<?php
/**
 * Created by PhpStorm.
 * User: lius
 * Date: 2017/2/20
 * Time: 19:56
 */
$options = array(
    //将选项放入数组中，管理更加方便
    //
    //标签页‘网站设置’开始
    array(
        'title' => '基本设置',
        'id' => 'webseting',
        'type' => 'panelstart'        //panel代表是顶部标签
    ),
    array(
        'title' => '在此设置您网站的基本信息',
        'type' => 'sutitle'    //sutitle代表顶部标签介绍信息
    ),//
    array(
        'name' => '网站名称',
        'desc' => '网站首页的SEO名称',
        'id' => "waitig_title",
        'type' => 'text',
        'std' => ''
    ),

    array(
        'name' => '网站描述',
        'desc' => '用简洁的文字描述您的站点，字数建议在120个字以内',
        'id' => "waitig_description",
        'type' => 'textarea',
        'std' => ''
    ),
    array(
        'name' => '网站关键字',//选项显示的文字，选填
        'desc' => '各关键字间用半角逗号","分割，数量在6个以内最佳。',//选项显示的一段描述文字，选填
        'id' => "waitig_keywords",//选项的id，必须是唯一，后面根据这个获取值，必填
        'type' => 'text',//种类，这个是普通的文字输入，必填
        'std' => ''//选项的默认值，选填
    ),
    array(
        'name' => '网站手机版地址',//选项显示的文字，选填
        'desc' => '网站的手机站地址',//选项显示的一段描述文字，选填
        'id' => "waitig_murl",//选项的id，必须是唯一，后面根据这个获取值，必填
        'type' => 'text',//种类，这个是普通的文字输入，必填
        'std' => ''//选项的默认值，选填
    ),
    array(
        'name' => '网站缩略图',//选项显示的文字，选填
        'desc' => '网站og:image标签图片地址',//选项显示的一段描述文字，选填
        'id' => "waitig_og_image",//选项的id，必须是唯一，后面根据这个获取值，必填
        'type' => 'images',//种类，这个是普通的文字输入，必填
        'std' => ''//选项的默认值，选填
    ),
    array(
        'name' => '网站主色调',//选项显示的文字，选填
        'desc' => '网站的主色调,请输入颜色代码，参考：#1ABC9C(淡雅绿),#3e3d43(深邃黑),#e0e262(魔力黄)',//选项显示的一段描述文字，选填
        'id' => "waitig_main_color",//选项的id，必须是唯一，后面根据这个获取值，必填
        'type' => 'smalltext',//种类，这个是普通的文字输入，必填
        'std' => '#1ABC9C'//选项的默认值，选填
    ),
    array(
        'name' => '去除头部多余代码',
        'desc' => '如果不用wlw发布博客，则建议开启',
        'id' => 'waitig_remove_head_code',
        'type' => 'checkbox'
    ),
    array(
        'name' => '头部公共代码',
        'desc' => '网站头部公共代码',
        'id' => 'waitig_head_code',
        'type' => 'textarea'
    ),
    array(
        'name' => '页脚公共代码',
        'desc' => '网站页脚公共代码',
        'id' => 'waitig_foot_code',
        'type' => 'textarea'
    ),
    array(
        'name' => '免插件去除category',
        'desc' => '免插件去除链接中的category',
        'id' => 'waitig_uncategroy_en',
        'type' => 'checkbox'
    ),
    array(
        'name' => '禁止主题自动更新',
        'desc' => '禁止自动更新 【不推荐】',
        'id' => "waitig_updates_un",
        'type' => 'checkbox'
    ),
    array(
        'name' => '是否开启HTTPS',
        'desc' => '开启后，系统分享将会失效',
        'id' => "https_on",
        'type' => 'checkbox',
        'std' => '1'
    ),
    array(
        'name' => '开启自动导航',
        'desc' => '开启后，系统会自动扫描网站中现有的小说，并显示在导航栏中，如果不开启此功能请在菜单栏中管理你的导航',
        'id' => "nav_auto_set",
        'type' => 'checkbox',
        'std' => '1'
    ),
    array(
        'name' => '网站导航显示小说数量',
        'desc' => '如果您开启了自动导航栏，请在此定义你想在导航栏显示的小说数量！',
        'id' => "nav_novel_number",
        'type' => 'number',
        'std' => '8'
    ),
    array(
        'type' => 'panelend'
    ),
    //标签页‘网站设置’结束
    //
    //标签页‘首页设置’开始
    array(
        'title' => '首页设置',
        'id' => 'personsetting',
        'type' => 'panelstart'
    ),
    array(
        'title' => '网站首页小说情况设置！',
        'type' => 'subtitle'
    ),
    array(
        'name' => '您的网站现有分类ID为：',
        'desc' => Bing_show_category(),
        'type' => 'text_show'
    ),
    array(
        'name' => '首页小说ID',
        'desc' => '首页小说ID',
        'id' => "index_cat_id",
        'type' => 'number',
        'std' => '2'
    ),
    array(
        'name' => '导航栏排除小说ID',
        'desc' => '不想显示在导航栏的小说ID，不同ID之间使用英文半角逗号分割',
        'id' => "index_nav_except_id",
        'type' => 'text',
        'std' => '1'
    ),
    array(
        'name' => '猜您喜欢板块排除小说ID',
        'desc' => '不想显示在猜您喜欢板块的小说ID，不同ID之间使用英文半角逗号分割',
        'id' => "index_pop_except_id",
        'type' => 'text',
        'std' => '1'
    ),
    array(
        'name' => '首页右侧精彩推荐小说ID',
        'desc' => '右侧精彩推荐小说ID',
        'id' => "right_cat_id",
        'type' => 'number',
        'std' => '2'
    ),
    array(
        'name' => '底部为你推荐显示小说数',
        'desc' => '为你推荐显示小说的数量',
        'id' => "bottom_cat_num",
        'type' => 'number',
        'std' => '9'
    ),
    array(
        'type' => 'panelend'
    ),
    //标签页‘其他设置’开始
    array(
        'title' => '其他设置',
        'id' => 'othersetting',
        'type' => 'panelstart'
    ),
    array(
        'title' => '网站其他情况设置！',
        'type' => 'subtitle'
    ),
    array(
        'name' => '网站友情链接',
        'desc' => '友情链接的HTML代码，每个链接需要用li标签包裹',
        'id' => 'waitig_flink',
        'type' => 'textarea'
    ),
    array(
        'name' => '本站强推',
        'desc' => '本站强推的HTML代码',
        'id' => 'waitig_tui',
        'type' => 'textarea'
    ),
    array(
        'type' => 'panelend'
    ),
    //标签页‘广告设置’开始
    array(
        'title' => '广告设置',
        'id' => 'adsetting',
        'type' => 'panelstart'
    ),
    array(
        'name' => 'PC端-首页-章节列表上',
        'desc' => '广告HTML代码，支持js',
        'id' => 'waitig_ad_content1_pc',
        'type' => 'textarea'
    ),
    array(
        'name' => 'PC端-首页-章节列表下',
        'desc' => '广告HTML代码，支持js',
        'id' => 'waitig_ad_content_pc',
        'type' => 'textarea'
    ),
    array(
        'name' => 'PC端-全站-猜你喜欢下',
        'desc' => '广告HTML代码，支持js',
        'id' => 'waitig_ad_popcate_pc',
        'type' => 'textarea'
    ),
    array(
        'name' => 'PC端-文章页-正文开头',
        'desc' => '广告HTML代码，支持js',
        'id' => 'waitig_ad_single_pc',
        'type' => 'textarea'
    ),
    array(
        'name' => 'PC端-文章页-正文结尾',
        'desc' => '广告HTML代码，支持js',
        'id' => 'waitig_ad_single2_pc',
        'type' => 'textarea'
    ),
    array(
        'name' => 'PC端-文章页-上/下一篇下',
        'desc' => '广告HTML代码，支持js',
        'id' => 'waitig_ad_single3_pc',
        'type' => 'textarea'
    ),
    array(
        'name' => '手机端-首页-章节列表上',
        'desc' => '广告HTML代码，支持js',
        'id' => 'waitig_ad_content1_mobile',
        'type' => 'textarea'
    ),
    array(
        'name' => '手机端-首页-章节列表下',
        'desc' => '广告HTML代码，支持js',
        'id' => 'waitig_ad_content_mobile',
        'type' => 'textarea'
    ),
    array(
        'name' => '手机端-全站-猜你喜欢下',
        'desc' => '广告HTML代码，支持js',
        'id' => 'waitig_ad_popcate_mobile',
        'type' => 'textarea'
    ),
    array(
        'name' => '手机端-文章页-正文开头',
        'desc' => '广告HTML代码，支持js',
        'id' => 'waitig_ad_single_mobile',
        'type' => 'textarea'
    ),
    array(
        'name' => '手机端-文章页-正文结尾',
        'desc' => '广告HTML代码，支持js',
        'id' => 'waitig_ad_single2_mobile',
        'type' => 'textarea'
    ),
    array(
        'name' => '手机端-文章页-上/下一篇下',
        'desc' => '广告HTML代码，支持js',
        'id' => 'waitig_ad_single3_mobile',
        'type' => 'textarea'
    ),
    array(
        'type' => 'panelend'
    ),
);
$notice = array(
    //将选项放入数组中，管理更加方便
    //
    //右侧公告
    array(
        'name' => '赞助作者',
        'desc' => '欢迎您使用<a href="http://www.waitig.com">WNovel主题</a>！，如果您感觉这款主题给您带来了方便，可以通过支付宝对作者进行赞助，我将万分感谢！<br/>支付宝账号：waitig@hotmail.com，<br/>二维码：<img src="http://img.waitig.com/img/alipay.gif"/>',
    ),
);