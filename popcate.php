<?php
/**
 * Created by PhpStorm.
 * User: lius
 * Date: 2017/2/21
 * Time: 22:53
 */
?>
<div class="col-sm-12 col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            猜你喜欢
        </div>
        <div class="panel-body panel-recommand">
            <ul class="list-group list-charts">
                <?php $args=array(
                    'orderby' => 'name',
                    'order' => 'ASC',
                    'hierarchical'=>0,
                    'child_of'=> 0,
                    'hide_empty'=> 1,
                    'taxonomy'=> 'category',
                    'number'=> waitig_gopt('bottom_cat_num'),
                    'exclude' => waitig_gopt('index_pop_except_id')

                );
                $categories=get_categories($args);
                $number=2;
                foreach($categories as $category) {
                    ?>
                    <li>
                        <a href="<?php echo get_category_link( $category->term_id )?>" title='<?php echo $category->name;?>全文阅读' ><?php echo $category->name;?>(<?php echo waitig_gopt("cat_author_".$category->term_id);?>)            </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div>
        <?php if(wp_is_mobile()){
            echo waitig_gopt('waitig_ad_popcate_mobile');
        }
        else{
            echo waitig_gopt('waitig_ad_popcate_pc');
        }?>
    </div>
</div>