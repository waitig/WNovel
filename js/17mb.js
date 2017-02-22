$(function(){
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
	
})
var _mobile;
UA = navigator.userAgent.toLowerCase();
url = window.location;
url = url.toString();
if((UA.indexOf('iphone') != -1 || UA.indexOf('mobile') != -1 || UA.indexOf('android') != -1 || UA.indexOf('ipad') != -1 || UA.indexOf('windows ce') != -1 || UA.indexOf('ipod') != -1) && UA.indexOf('ipod') == -1) {
	_mobile = 1 ;$(function(){$("#gundong").hide()});
}
else{
	_mobile = null ;
}

//统计代码,PC+WAP
function _17mb_tj(){
	//请不要在这个地方添加类似 if(!_mobile) 代码
	document.writeln("<script src=\'https://s11.cnzz.com/z_stat.php?id=1260950332&web_id=1260950332\' language=\'JavaScript\'></script>");
}
//顶部广告（PC）

function _17mb_pctop(){
	if(!_mobile)
	document.writeln("");
}
//中部广告（PC）
function _17mb_pcmiddle(){
	if(!_mobile)
	document.writeln("");
}
//底部广告（PC）
function _17mb_pcbottom(){
	if(!_mobile)
	document.writeln("");
}
//对联广告(PC)
function _17mb_pcduilian(){
	if(!_mobile)
	document.writeln("");
}
//PC章节页方形广告1
function _17mb_chapter1(){
	if(!_mobile)
	document.writeln("");
}
//PC章节页方形广告2
function _17mb_chapter2(){
	if(!_mobile)
	document.writeln("");
}
//PC章节页方形广告3
function _17mb_chapter3(){
	if(!_mobile)
	document.writeln("");
}
//顶部广告（WAP）
function _17mb_waptop(){
	if(_mobile)
	document.writeln("");
}
//中部广告（WAP）
function _17mb_wapmiddle(){
	if(_mobile)
	document.writeln("");
}
//底部广告（WAP）
function _17mb_wapbottom(){
	if(_mobile)
	document.writeln("");
}