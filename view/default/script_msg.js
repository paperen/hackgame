function do_msg() {
	var username = $('#username').val();
	var email = $('#email').val();
	var icq = $('#icq').val();
	var message = $('#message').val();
	var authkey = $('#authkey').val();
	if ( '' == username ) {
		notice_me('#username');
	} else if( '' == email ) {
		notice_me('#email');
	} else if( !isEmail( email ) ) {
		notice_me('#email', '邮箱格式不正确');
	} else if( '' == icq ) {
		notice_me('#icq');
	} else if( '' == message ) {
		notice_me('#message');
	} else if( '' == authkey ) {
		window.location.reload();
	} else {
		var data = '&username=' + username + '&email=' + email + '&icq=' + icq + '&message=' + message + '&authkey=' + authkey;
		ajax_post(
			'index.php',
			data,
			function() {
				$('#pass_form form').fadeOut('fast', function(){
					$('#pass_form').append( get_loadinghtml( 'bar' ) );
				});
			},
			function( data ) {
				timer( function(){
					remove_loadinghtml();
					$('#pass_form').append( data );
				}, 1000 );
			}
		);
	}
}
$(document).ready(function(){$('#username').focus();});