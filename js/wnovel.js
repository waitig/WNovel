function changeBackground(){
	if(sessionStorage.getItem('md')=='night'){
		document.body.style.backgroundColor = 'rgb(6, 23, 37)';
        $(".panel-default").css({"background-color":'#252525'});
        $(".breadcrumb").css({"background-color":'#252525'});
        $(".alert-warning").css({"background-color":'#252525'});
        $(".panel-default").css({"color":'#535353'});
        $(".list-charts li").css({"border-bottom":'1px solid #423838'});
	}
	$widthwindow = $(window).width();
	if($widthwindow < 750){
		$(".list-charts li").width($widthwindow-60);
		$("#_17mb_ph .author,#_17mb_ph .lastchapter,#_17mb_ph .visit,#_17mb_ph .fullflag").hide(300);
		$("#_17mb_ph .articlename").width("70%");
		$("#_17mb_ph .lastupdate").width("30%");
		$("#bookcon .lastchapter,#booklast").hide(300);
		$(".navbar-nav li").css({"display":"block","float":"left"});
		$(".myinfo,.bookcase").width("50%").height(60);
		$("#navbar .bookcase").css("top","0px");
		$(".dropdown-menu a").css("color","#fff");
	}
}
function addBookmark(title,url) {
try
    {
        window.external.addFavorite(url, title);
    }
    catch (e)
    {
        try
        {
            window.sidebar.addPanel(title, url, "");
        }
        catch (e)
        {
            alert("加入收藏失败，请使用Ctrl+D进行添加");
        }
    }
}
function gotoP(){
	$('body,html').animate({scrollTop:0},1000);
	$(window).scroll(function(e) {
        //若滚动条离顶部大于100元素
        if($(window).scrollTop()>100)
            $("#gotoP").fadeIn(1000);//以1秒的间隔渐显id=gotop的元素
        else
            $("#gotoP").fadeOut(1000);//以1秒的间隔渐隐id=gotop的元素
    });
}
function darker() {
    if(sessionStorage.getItem('md')=='night'){
       $("body").css({"background-color":'rgb(255, 255, 255)'});
       $(".panel-default").css({"background-color":'#ecf0f1'});
       $(".breadcrumb").css({"background-color":'#ecf0f1'});
       $(".alert-warning").css({"background-color":'#ecf0f1'});
       $(".panel-default").css({"color":'#666666'});
       $(".list-charts li").css({"border-bottom":'1px solid #ddd'});
        sessionStorage.setItem('md', 'day');
    }
    else{
        $("body").css({"background-color":'rgb(6, 23, 37)'});
        $(".panel-default").css({"background-color":'#252525'});
        $(".breadcrumb").css({"background-color":'#252525'});
        $(".alert-warning").css({"background-color":'#252525'});
        $(".panel-default").css({"color":'#535353'});
        $(".list-charts li").css({"border-bottom":'1px solid #423838'});
        sessionStorage.setItem('md', 'night');
    }
}
function insertImage_cat(value_id) {
    var ashu_upload_frame;
    event.preventDefault();
    if (ashu_upload_frame) {
        ashu_upload_frame.open();
        return;
    }
    ashu_upload_frame = wp.media({
        title: '插入图片',
        button: {
            text: '插入'
        },
        multiple: false
    });
    ashu_upload_frame.on('select', function () {
        attachment = ashu_upload_frame.state().get('selection').first().toJSON();
        $('#cat_image').val(attachment.url);
        $('#img_cat_image').attr("src", attachment.url);
    });
    ashu_upload_frame.open();
}
function delHtmlCache(homeUrl,type) {
    if(confirm('你确定要删除此缓存吗？')){
        var cache_id = '';
        if(type==='1'){
            cache_id = $("#waitig_Cache_Del_id").val();
        }
        else{
            cache_id = $("#waitig_Cache_Del_cate_id").val();
        }

        $.ajax({
            url:homeUrl,
            data:{"htmlCacheDelbt":type,"cache_id":cache_id},
            type:'post',
            success:function(result){
                if(type==='1'){
                    $("#waitig_Cache_Del_span").html(result);
                    $("#waitig_Cache_Del_id").val('');
                }
                else{
                    $("#waitig_Cache_Del_Cate_span").html(result);
                    $("#waitig_Cache_Del_cate_id").val('');
                }
            },
            error:function(msg){
                alert("连接网络失败");
            }
        });
    }
    return false;
}
