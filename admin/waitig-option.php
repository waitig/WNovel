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
        'title'	=>	'网站设置',
        'id'	=>	'webseting',
        'type'	=>	'panelstart'		//panel代表是顶部标签
    ),
    array(
        'title'	=>	'在此设置您网站的基本信息',
        'type'	=>	'sutitle'	//sutitle代表顶部标签介绍信息
    ),
    array(
        'name'	=>	'网站描述',
        'desc'	=>	'用简洁的文字描述您的站点，字数建议在120个字以内',
        'id'	=>	"waitig_description",
        'type'	=>	'text',
        'std'	=>	''
    ),
    array(
        'type'	=>	'panelend'
    ),
    //标签页‘网站设置’结束
    //
    //标签页‘个性设置’开始
    array(
        'title'	=>	'个性设置',
        'id'	=>	'personsetting',
        'type'	=>	'panelstart'
    ),
    array(
        'title' => '丰富的个性话设置，使你的网站更加个性！',
        'type'  => 'subtitle'
    ),
    array(
        'type'	=>	'panelend'
    ),

);