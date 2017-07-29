<?php
/**
 * Created by PhpStorm.
 * User: lius
 * Date: 2017/2/20
 * Time: 19:49
 */
?>
<!-- Site footer -->
<footer class="footer">
	<p>
		@<?php bloginfo('name');?> .请牢记我们的网址：<a href="<?php bloginfo('url');?>" title="<?php bloginfo('name');?>"><?php bloginfo('url');?></a> ！<?php if(waitig_gopt('waitig_murl')){?>
        手机版地址：<a href="<?php echo waitig_gopt('waitig_murl');?>" title="<?php bloginfo('name');?>"><?php echo waitig_gopt('waitig_murl');?></a>.
        <?php }?><br/>
		本站所有的文章、图片、评论等，均由网友发表或上传并维护或收集自网络，属个人行为，与本站立场无关。<br/>
		如果侵犯了您的权利，请与我们联系，我们将在24小时之内进行处理。任何非本站因素导致的法律后果，本站均不负任何责任。</p>
</footer>
</div> <!-- /container -->
<div id="scroll">
<div id="gotoP"><a onclick="gotoP()"><i class="fa fa-arrow-up fa-2x"></i></a></div>
<!-- <button onclick="darker()"><i class="fa fa-lightbulb-o fa-2x"></i></button> -->
<div id="nightss"><a onclick="darker()"><i class="fa fa-lightbulb-o fa-2x"></i></a></div>
</div>
<?php echo waitig_gopt('waitig_foot_code');?>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"share":{},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='<?php if(!waitig_gopt('https_on')){?>http://bdimg.share.baidu.com<?php }?>/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
    changeBackground();
</script>
</body>
</html>