<?php if(!defined('INRUN')) exit(); ?>
<?php if ( $this->isajax ): ?>
	<?php if( 'check' == $this->do ): ?>
    	<?php if( 'getpwd' == $this->extra ): ?>
        <script type="text/javascript">
			$('#try_tip .icon').addClass('key_icon');
			$('#try_tip .inner').html('<?php echo $this->lvlpwd; ?>');
        	$('#try_tip').fadeIn('fast');
		</script>
        <?php else: ?>
    	<script type="text/javascript">
			$('#try_tip .icon').addClass('key_icon');
			$('#try_tip .inner').html('<?php echo $this->xss; ?>有时候需要发挥您的想象力与观察力');
        	$('#try_tip').fadeIn('fast');
		</script>
        <?php endif; ?>
    <?php else: ?>
		<?php if( $this->success ) { ?>
        <div class="passtip radius" id="passtip">
            <div class="success"></div>
            <p class="innertxt">“恭喜！口令正确，通关”</p>
        </div>
        <script type="text/javascript">
        timer(function(){window.location.reload();}, 2500);
        </script>
        <?php } else { ?>
        <div class="passtip radius" id="passtip">
            <div class="failed"></div>
            <p class="innertxt">“抱歉！口令错误，请再试试”</p>
        </div>
        <script type="text/javascript">
        timer(function(){$('#passtip').remove();$('#lvl5_form form').fadeIn('fast');}, 2500);
        </script>
        <?php } ?>
    <?php endif; ?>
<?php else: ?>
<?php $this->need('header'); ?>
        <!-- left box -->
    	<div class="float_left box commonbox lvl5 radius">
        	<h5 class="title b_title">
            	<span class="icon blub_icon"></span>
            	<span class="mission mission5"></span>
                <span id="no_script" class="noscript"></span>
            </h5>
            <div class="box_inner">
                <div class="main_box radius">
                    <blockquote class="quote">
                    	<span class="icon quote_s"></span>
                        <span class="icon quote_e"></span>
                    	<?php echo $this->lvltip[$this->getop()]['tip1']; ?>
                    </blockquote>
                    <div  class="main_form lvl5_form">
                    	<p><label for="try">尝试一下 Have A Try</label> <span id="try_l"></span></p>
                        <p class="key_p" id="try_p">
                        <input type="text" name="try" id="try" class="txtbox" required="true" title="script" value='<script>alert("something strange");<\/script>' />
                        <a href="javascript:void(0);" class="icon shortcut_icon" title="确定" onclick="do_try();"></a>
                        </p>
                        <p class="key_tip radius hide" id="try_tip">
                        	<span class="icon"></span>
                        	<span class="inner"></span>
                        </p>
                    </div>
                    <div class="main_form lvl5_form" id="lvl5_form">
                    	<form method="post" action="">
                        <p><label for="password">输入通关密码 PassWord</label></p>
                        <p>
                        	<span class="icon key_icon"></span>
                        	<input type="password" name="password" id="password" class="txtbox pwdbox radius" required="true" title="请填写通关密码" />
                            <input type="hidden" name="authkey" id="authkey" required="true" value="<?php echo $this->authcode; ?>" />
                            <input type="button" name="submit" id="submit" class="enter_btn" value="ENTER" onclick="do_submit('#lvl5_form');" />
                        </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<script type="text/javascript">
function do_try() {
	var k_id = '#try';
	var p_id = k_id + '_p';
	var l_id = k_id + '_l';
	var t_id = k_id + '_tip';
	if ( '' == $(k_id).val() ) {
		notice_me( k_id, 'script' );
	} else {
		var data = '&do=check&val=' + $(k_id).val();
		ajax_post(
			'index.php',
			data,
			function() {
				$( l_id ).html( get_loadinghtml('c') );
				$( l_id ).show();
			},
			function( ret ) {
				$( l_id ).hide();
				$('#ret').html( ret );
			}
		);
	}
}
function do_other( extra ) {
	//getpwd
	var k_id = '#try';
	var l_id = k_id + '_l';
	var t_id = k_id + '_tip';
	var data = '&do=check&val=&extra=' + extra;
	ajax_post(
		'index.php',
		data,
		function() {
			$( l_id ).html( get_loadinghtml('c') );
			$( l_id ).show();
		},
		function( ret ) {
			$( l_id ).hide();
			$('#ret').html( ret );
		}
	);
}
</script>
<div id="ret" class="hide"></div>
        <!-- left box -->
	<?php $this->need('sidebar'); ?>
<?php $this->need('footer'); ?>
<?php endif ?>