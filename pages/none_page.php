<?php
/*
	template name: 空白页面模板
	description:一个空白的页面模板，您可以在此定义您的页面 https://www.waitig.com出品
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
            <?php while (have_posts()) :
                the_post();
            the_content();
            endwhile;
            ?>
        </div>
    </div>
<?php
get_footer();