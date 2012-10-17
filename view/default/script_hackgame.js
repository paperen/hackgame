/** script engine */
function do_submit( form_ID, url ) {
	var form_data = collect_formdata( form_ID );
	if ( form_data ) {
		ajax_post(
			url,
			form_data,
			function() {
				$(form_ID + ' form').fadeOut('fast', function(){
					$(form_ID).append( get_loadinghtml( 'bar' ) );
				});
			},
			function( data ) {
				timer( function(){
					remove_loadinghtml();
					$(form_ID).append( data );
				}, 1000 );
			}
		);
	}
}
function ajax_post( url, data, beforehandle, handle ) {
	$.ajax({
		type: "POST",
		url: url,
		data: "isajax=1" + data,
		beforeSend: beforehandle,
		success: handle
	});
}
function collect_formdata( form_ID ) {
	var name = '';
	var val = '';
	var data = '';
	$( form_ID + ' input[required]' ).each(function(i){
		name = $(this).attr('name');
		if ( true == $(this).attr('required') ) {
			if ( is_empty( '#' + $(this).attr('id') ) ) return false;
		}
		if ( '' != $(this).val() ) data += '&' + name + '=' + $(this).val();
	});
	return data;
}
function is_empty( ID ) {
	if ( '' == $(ID).val() ) {
		notice_me( ID, '' );
		return true;
	}
	return false;
}
function get_loadinghtml( which ) {
	if ( 'bar' == which ) {
		return "<div class=\"loading\" id=\"loading\"><img src=\"image/loader_bar.gif\" title=\"loading\" alt=\"loading\" /></div>";
	} else {
		return "<img src=\"image/loader_c.gif\" title=\"loading\" alt=\"loading\" />";
	}
}
function remove_loadinghtml() {
	$('#loading').remove();
}
function notice_me( ID, tip ) {
	var offset = $(ID).offset();
	var tiptxt = (null == tip) ? $(ID).attr('title') : tip;
	var b_color = $(ID).css('border-color');
	$(ID).css('border-color', '#74BDFA');
	show_warningtip( offset, tiptxt );
	timer(function(){$(ID).css('border-color', b_color);}, 2500);
}
function show_warningtip( offset, tiptxt ) {
	var height = no_px( $('#errortip').css('height') );
	$('#errortip').css('top', ( offset.top - height - 4 ) + 'px');
	$('#errortip').css('left', offset.left + 'px');
	$('#errortip').html( tiptxt );
	$('#errortip').fadeIn('fast', function(){
		timer(function(){$('#errortip').fadeOut('fast', function(){$('#errortip').html('');});}, 3500);
	});
}
function timer(func, time) {
	setTimeout( func, time );
}
function no_px( str ) {
	return str.substring(0, str.indexOf('px') );
}
function isEmail(str){
    var myReg = /^[-_A-Za-z0-9.]+@([_A-Za-z0-9]+\.)+[A-Za-z0-9]{2,3}$/;
    if(myReg.test(str)) return true;
    return false;
}
$(document).ready(function(){
	$('#no_script').css('display', 'none');
	$('#switch_share').click(function(){
		$('#share_box').toggle();
	});
});
function isie6() {
    if ($.browser.msie) {
        if ($.browser.version == "6.0") return true;
    }
    return false;
}