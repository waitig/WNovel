<?php
/*
	template name: 所有小说
	description:显示网站所有小说的页面模板 https://www.waitig.com出品
*/
get_header();
$blogUrl = get_bloginfo('url');
$blogName = get_bloginfo('name');
$themeUrl = get_template_directory_uri();
?>
    <div class="clear"></div>
    <div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div id="gundong" class="alert alert-warning" style="padding:50px;font-size:25px;">
                抱歉，您浏览的页面不存在！<br/>本站还有以下小说，感谢您的阅读！
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"><?= $blogName ?>推荐小说列表</h2></div>
                <div class="details">
                    <div class="panel-body">
                        <ul class="item-qb">
                            <?php
                            $args2 = array(
                                'type' => 'post',
                                'child_of' => 0,
                                'parent' => '0',
                                'orderby' => 'ID',
                                'order' => 'DESC',
                                'hide_empty' => 0,
                                'hierarchical' => 0,
                                'exclude' => '1',
                                'include' => '',
                                'number' => -1,
                                'taxonomy' => 'category',
                                'pad_counts' => false);
                            $categories = get_categories($args2);
                            //foreach ($categories as $category) {
                            for($i = 0; ($i<6&&$i<count($categories));$i++){
                                $category = $categories[$i];
                                $catLink = get_category_link($category->term_id);
                                $catName = $category->name;
                                $catAuth = waitig_gopt("cat_author_" . $category->term_id);
                                $catImg = waitig_gopt("cat_image_" . $category->term_id);
                                $catDesc = wpautop($category->description);
                                ?>
                                <li>
                                    <div class="item-qb-img">
                                        <img src="<?= $catImg ?>" alt="<?= $catName ?>在线阅读"
                                             onerror='this.src="<?= $themeUrl ?>/img/noimg.jpg"'/>
                                    </div>
                                    <div class="item-qb-container">
                                        <div class="item-qb-title">
                                            <a href="<?= $catLink ?>" title="<?= $catName ?>在线阅读"
                                               target="_blank"><?= $catName ?></a>
                                        </div>
                                        <div class="item-qb-auth">
                                            <span>作者：<?= $catAuth ?></span>
                                        </div>
                                        <div class="item-qb-desc">
                                            <span>简介：<?= $catDesc ?></span>
                                        </div>
                                    </div>
                                </li>
                            <?php }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
get_footer();