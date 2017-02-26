<?php
/**
 * Created by PhpStorm.
 * User: lius
 * Date: 2017/2/20
 * Time: 19:50
 */
get_header();
$current_category = get_the_category();//获取当前文章所属分类ID
$prev_post = get_previous_post($current_category,'');//与当前文章同分类的上一篇文章
$next_post = get_next_post($current_category,'');//与当前文章同分类的下一篇文章
$category = $current_category[0];
$cat_id=$category->term_id;
?>
<script type="text/javascript">
    var pre = '<?php if (!empty( $prev_post )):
        echo get_permalink( $prev_post->ID );
        endif; ?>';
    var nex = '<?php if (!empty( $next_post )){
            echo get_permalink( $next_post->ID );
        }
        else {
            echo 'javascript:window.alert(\'下一章：没有了\');';
        }?>';
    var currentpos, timer;
    function initialize() {
        timer = setInterval("scrollwindow()", 20);
    }
    function sc() {
        clearInterval(timer);
    }
    function scrollwindow() {
        window.scrollBy(0, 1);
    }
    $(function () {
        document.onmousedown = sc;
        document.ondblclick = initialize;


        $(window).keydown(function (e) {
            var c = e.keyCode;
            if (c == 37) {
                location.href = pre;
            } else if (c == 39) {
                location.href = nex;
            }
        });
    });
</script>
<div class="container">
    <?php echo deel_breadcrumbs(); ?>
	<!--<script>_17mb_waptop();</script>-->
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div id="gundong" class="alert alert-warning" style="font-size: 12px">
    亲,双击屏幕即可自动滚动
</div>
            <div class="panel panel-default">
                <?php while (have_posts()) : the_post(); ?>
                <div class="panel-heading"><?php the_title(); ?></div>
				<div class="chaptera">
                <div class="clearfix"></div>
            	</div>
		<div class="panel-body content-body content-ext">&nbsp;&nbsp;&nbsp;&nbsp;<?php the_content(); ?></div>
        </div>
    </div>
        </div>
        <?php endwhile;  ?>
    <div class="row"><?php include "popcate.php";?>
        <div class="col-md-12">
            <nav>
                <ul class="pager">
					<li class="previous"><a class="btn btn-info" href="<?php if (!empty( $prev_post )):
                            echo get_permalink( $prev_post->ID );
                        endif; ?>">上一章</a></li>
					<li><a class="btn btn-info" href="<?php echo get_category_link( $category->term_id )?>">返回目录</a></li>
					<li class="next"><a class="btn btn-info" href="<?php if (!empty( $next_post )){
                            echo get_permalink( $next_post->ID );
                        }
                        else {
                            echo 'javascript:window.alert(\'下一章：没有了\');';
                        }?>">下一篇</a></li>
                </ul>
            </nav>
        </div>
    </div>
<?php get_footer();
