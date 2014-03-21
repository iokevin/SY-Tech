//删除弹出框
KindEditor.ready(function(K) {
	K(".del_dai").click(function() {
		url = K(this).attr('rel');
		var dialog = K.dialog({
			width : 300,
			title : '删除',
			body : '<div style="margin:10px;"><div id="domainTip" class="onShow">确定要删除?删除后将不能恢复！</div></div>',
			closeBtn : {
				name : '关闭',
				click : function(e) {
				dialog.remove();
				}
			},
			yesBtn : {
				name : '确定',
				click : function(e) {
				window.location.href=url;
				dialog.remove();
				}
			},
			noBtn : {
				name : '取消',
				click : function(e) {
				dialog.remove();
				}
			}
		});
	});
});