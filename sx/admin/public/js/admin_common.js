function confirmurl(url,message)
{
	if(confirm(message)) redirect(url);
}
function redirect(url) {
	//if(url.indexOf('://') == -1 && url.substr(0, 1) != '/' && url.substr(0, 1) != '?') url = $('base').attr('href')+url;
	location.href = url;
}
//滚动条
$(function(){
	//window.onresize = function(){

	//}
	//window.onresize();
	//inputStyle
	$(":text").addClass('input-text');
})

/**
 * 全选checkbox,注意：标识checkbox id固定为为check_box
 * @param string name 列表check名称,如 uid[]
 */
function selectall(name) {
	if ($("#check_box").attr("checked")==false) {
		$("input[name='"+name+"']").each(function() {
			this.checked=false;
		});
	} else {
		$("input[name='"+name+"']").each(function() {
			this.checked=true;
		});
	}
}

function openwinx(url,name,w,h) {
	if(!w) w=screen.width;
	if(!h) h=screen.height-60;
    window.open(url,name,"top=100,left=400,width=" + w + ",height=" + h + ",toolbar=no,menubar=no,scrollbars=yes,resizable=yes,location=no,status=no");
}

//弹出窗口
function urldialog(title,url){
	$.dialog({
	id:'N953',
	lock:'true',
	title:title,
	content: 'url:'+url
	})
}