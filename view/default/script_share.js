var share_list = {
	'sina' : 'http://v.t.sina.com.cn/share/share.php',
	'renren' : 'http://share.renren.com/share/buttonshare.do',
	'douban' : 'http://www.douban.com/recommend/',
	'qq' : 'http://v.t.qq.com/share/share.php',
	'twitter' : 'http://twitter.com/home?status=Reading:'
};
function do_share( type, url ) {
	if ( 'renren' == type ) {
		window.open(url + '?title='+encodeURIComponent(document.title.substring(0,76))+'&link='+encodeURIComponent(location.href),'_blank','scrollbars=no');
	} else if( 'twitter' == type ) {
		window.open(url + encodeURIComponent(document.title.substring(0,76))+' '+encodeURIComponent(location.href),'_blank','scrollbars=no');
	} else {
		window.open(url + '?title='+encodeURIComponent(document.title.substring(0,76))+'&url='+encodeURIComponent(location.href),'_blank','scrollbars=no');
	}
}
$(document).ready(function(){
	$('#share_box a').click(function(){
		var tag = $(this).attr('id').substring( $(this).attr('id').indexOf('_') + 1 );
		do_share(tag, share_list[tag]);
	});
});