<?php
/**
 * Created by PhpStorm.
 * User: lius
 * Date: 2017/2/21
 * Time: 22:53
 */
if(waitig_gopt('waitig_flink'))
    {?>
<div class="col-sm-12 col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            友情链接
        </div>
        <div class="panel-body panel-recommand">
            <ul class="list-group list-charts">
            	<?php echo waitig_gopt('waitig_flink');?>
            </ul>
        </div>
    </div>
</div><?php }