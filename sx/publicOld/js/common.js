//绑定表格隔行变色
function livetable() {
    $('.table_list tr:odd').addClass('odd');
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