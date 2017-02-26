<?php
/**
 * File: content.php.
 * User: LiuS
 * Date: 2017/2/21
 * Time: 15:10
 * Index:http://www.waitig.com
 * Theme:WBetter Theme
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
$right_cat_id = waitig_gopt('right_cat_id');?>
<div class="container">
		<?php echo deel_breadcrumbs(); ?>
	<!--<script>_17mb_pctop();_17mb_waptop();</script>-->
	<div class="row">
		<div class="col-sm-8 col-md-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					《<?php $thiscat = get_category($cat_id); echo $thiscat ->name;?>》精彩介绍
				</div>
				<div class="pannel-body info">
					<div class="info1">
						<img src=":<?php echo waitig_gopt("cat_image_".$thiscat->term_id);?>" height="130" width="100" onerror="this.src='<?php echo waitig_gopt("cat_image_".$thiscat->term_id);?>'" /><br/><br/>
						<a href="javascript:;" rel="nofollow"  class="btn btn-danger">推荐本书</a><br/><br/>
						<a href="javascript:;" class="btn btn-primary">加入书架</a>
					</div>
					<div class="info2">
						<h1 class="text-center"><?php $thiscat = get_category($cat_id); echo $thiscat ->name;?></h1>
						<h3 class="text-center">作者:<?php echo waitig_gopt("cat_author_".$thiscat->term_id);?></h3>
						<div>
							<p><!--关于--><?php /*$thiscat = get_category($cat_id); echo $thiscat ->name;：*/?>&nbsp;&nbsp;&nbsp;<?php echo $thiscat ->description;?></p>
						</div>
					</div>
					<div style="clear:both"></div>
				</div>

				<div class="panel-body text-center info3">
					<p>小说类别：科幻小说 / 写作状态：连载中</p>
					<p>最新章节：<?php query_posts("posts_per_page=1&cat=".$cat_id)?>
						<?php while (have_posts()) : the_post(); ?>
						<a href="<?php the_permalink() ?>"  target="_blank">
							<?php the_title(); ?>
						</a></p>
					<p>最后更新：<font color="red"><?php the_time('Y年m月d日 H:i'); ?></font></p>
				<?php endwhile;wp_reset_query(); ?>
				</div>
			</div>
		</div>


        <div class="col-md-4 col-sm-4 hidden-xs hidden-sm">
            <div class="panel panel-default">
                <div class="panel-heading">精彩小说推荐</div>
                <div class="panel-body" >
                    <ul class="list-group list-group-ext">
                        <?php $thiscat = get_category($right_cat_id);?>
                        <div class="media" style="border:none;margin-bottom: 0;padding-bottom: 0">
                            <div class="media-left media-heading">
                                <a href="<?php echo get_category_link( $thiscat->term_id )?>" title='<?php echo $thiscat ->name;?>全文阅读' >
                                    <img title='<?php echo $thiscat ->name;?>全文阅读' src="<?php waitig_gopt('right_novel_image');?>" class="img" width="90" height="110" />
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading book-title"><a href="<?php echo get_category_link( $thiscat->term_id )?>" title='<?php echo $thiscat ->name;?>全文阅读' ><?php echo $thiscat ->name;?></a></h4>
                                <p class="book_author">
                                    全部文章数：<?php echo $thiscat ->count;?></p>
                                <p class='cat-book-intro'><?php echo deel_strimwidth($thiscat ->description, 0, 60, '...'); ?><a style="color:red" href="<?php echo get_category_link( $thiscat->term_id )?>">[点击阅读]</a></p>
                            </div>
                        </div>

                        <?php $args=array(
                            'orderby' => 'name',
                            'order' => 'ASC',
                            'hierarchical'=>0,
                            'child_of'=> 0,
                            'hide_empty'=> 1,
                            'taxonomy'=> 'category',
                            'number'=> '7',
                            'exclude'=>$right_cat_id

                        );
                        $categories=get_categories($args);
                        $number=2;
                        foreach($categories as $category) {
                            ?>
                            <li class="list-group-item nowrap px13 ">
                                <span class="badge"><?php echo $category ->count;?></span>
                                <font class='id_sequence'><?php echo $number;$number+=1;?>.</font>
                                <a href="<?php echo get_category_link( $category->term_id )?>" title='<?php echo $category->name;?>全文阅读' ><?php echo $category->name;?>            </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
	</div>
	<!--<script>_17mb_pcmiddle();_17mb_wapmiddle();</script>-->
	<div class="row">
		<div class="col-sm-12 col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading"><?php $thiscat = get_category($cat_id); echo $thiscat ->name;?>全部章节</div>
				<div class="panel-body">
					<ul class="list-group list-charts">
                        <?php query_posts("posts_per_page=-1&cat=".$cat_id."&order=ASC")?>
                        <?php while (have_posts()) : the_post(); ?>
                        <li><a href="<?php the_permalink() ?>"  target="_blank">
                                <?php the_title(); ?>
                            </a></li>
                        <?php endwhile;wp_reset_query(); ?>
					</ul>
				</div>
			</div>

		</div>
	</div>
	<div class='row'>
		<div class="col-sm-12 col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
                    <?php $thiscat = get_category($cat_id); echo $thiscat ->name;?>说明
				</div>
				<div class="panel-body book-ext-info">
					1.<?php bloginfo('name');?>提供<?php $thiscat = get_category($cat_id); echo $thiscat ->name;?>无弹窗阅读，让读者享受干净，清静的阅读环境,我们的口号——“<?php bloginfo('name');?>真正的无弹窗小说网”<br/>

					2.我们将日新月新更新本书，但如果您发现本小说<?php echo $thiscat ->name;?>最新章节，而<?php bloginfo('name');?>阅读网又没有更新，请通知<?php bloginfo('name');?>,您的支持是我们最大的动力。<br/>
					3.读者在阅读中如发现内容有与法律抵触之处，请马上向本站举报。希望您多多支持本站，非常感谢您的支持!<br/>
					4.本小说《<?php echo $thiscat ->name;?>》是本好看的言情小说，但其内容仅代表作者本人的观点，与<?php bloginfo('name');?>网的立场无关。<br/>
					5.如果如果读者在阅读<?php echo $thiscat ->name;?>时对作品内容、版权等方面有质疑，或对本站有意见建议请联系管理员处理。<br/>
					6.《<?php echo $thiscat ->name;?>》是一本优秀小说,为了让作者:花都大少能提供更多更好崭新的作品，请您购买本书的VIP或极品全能学生完本、全本、完结版实体小说及多多宣传本书和推荐，也是对作者的一种另种支持!小说的未来，是需要您我共同的努力!
				</div>
			</div>
		</div>
        <?php include "popcate.php";?>
	</div>
