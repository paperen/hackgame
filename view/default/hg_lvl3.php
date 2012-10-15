<?php if(!defined('INRUN')) exit(); ?>
<?php if ( $this->isajax ): ?>
	<?php if( 'check' == $this->do ): ?>
    	<script type="text/javascript">
		<?php if( 1 == $this->check_state ) : ?>
			$('#wkey_tip .icon').removeClass('denied_icon');
			$('#wkey_tip .icon').addClass('key_icon');
			$('#wkey_tip .inner').html('<?php echo $this->lvltip[$this->getop()]['wkey']; ?>');
        	$('#wkey_tip').fadeIn('fast');
        <?php elseif( 2 == $this->check_state ) : ?>
			$('#lkey_tip .icon').removeClass('denied_icon');
			$('#lkey_tip .icon').addClass('key_icon');
			$('#lkey_tip .inner').html('<?php echo $this->lvltip[$this->getop()]['lkey']; ?>');
        	$('#lkey_tip').fadeIn('fast');
        <?php elseif( -1 == $this->check_state ) : ?>
			$('#wkey_tip .icon').removeClass('key_icon');
			$('#wkey_tip .icon').addClass('denied_icon');
			$('#wkey_tip .inner').html('您确定Windows密码是存放在该路径么？');
        	$('#wkey_tip').fadeIn('fast');
		<?php elseif( -2 == $this->check_state ) : ?>
			$('#lkey_tip .icon').removeClass('key_icon');
			$('#lkey_tip .icon').addClass('denied_icon');
			$('#lkey_tip .inner').html('您确定Linux密码是存放在该路径么？');
        	$('#lkey_tip').fadeIn('fast');
		<?php endif; ?>
		<?php if( 0 > $this->check_state ){ ?>
		timer(function(){$('#wkey_tip').fadeOut('fast');$('#lkey_tip').fadeOut('fast');}, 4000);
		<?php } ?>
		</script>
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
        timer(function(){$('#passtip').remove();$('#lvl3_form form').fadeIn('fast');}, 2500);
        </script>
        <?php } ?>
    <?php endif; ?>
<?php else: ?>
<?php $this->need('header'); ?>
        <!-- left box -->
    	<div class="float_left box commonbox lvl3 radius">
        	<h5 class="title b_title">
            	<span class="icon blub_icon"></span>
            	<span class="mission mission3"></span>
                <span id="no_script" class="noscript"></span>
            </h5>
            <div class="box_inner">
                <div class="main_box radius">
                    <blockquote class="quote">
                    	<span class="icon quote_s"></span>
                        <span class="icon quote_e"></span>
                    	<?php echo $this->lvltip[$this->getop()]['tip1']; ?>
                    </blockquote>
                    <div class="main_form lvl3_form">
                    	<p><label for="winkey">Windows 密码存放路径</label> <span id="wkey_l"></span></p>
                        <p class="key_p" id="wkey_p">
                        <input type="text" name="winkey" id="wkey" class="txtbox" required="true" title="Windows密码存放在" />
                        <a href="javascript:void(0);" class="icon shortcut_icon" title="确定" onclick="check_key('wkey');"></a>
                        </p>
                        <p class="key_tip radius hide" id="wkey_tip">
                        	<span class="icon"></span>
                        	<span class="inner"></span>
                        </p>
                        
                        <p><label for="linuxkey">Linux 密码存放路径</label> <span id="lkey_l"></span></p>
                        
                        <p class="key_p" id="lkey_p">
                        <input type="text" name="linuxkey" id="lkey" class="txtbox" required="true" title="linux密码存放在" />
                        <a href="javascript:void(0);" class="icon shortcut_icon" title="确定" onclick="check_key('lkey');"></a>
                        </p>
                        <p class="key_tip radius hide" id="lkey_tip">
                        	<span class="icon"></span>
                            <span class="inner">您确定Linux密码是存放在这里？</span>
                        </p>
                    </div>
                    <div class="main_form lvl3_form" id="lvl3_form">
                    	<form method="post" action="">
                        <p><label for="password">输入通关密码 PassWord</label></p>
                        <p>
                        	<span class="icon key_icon"></span>
                        	<input type="password" name="password" id="password" class="txtbox pwdbox radius" required="true" title="请填写通关密码" />
                            <input type="hidden" name="authkey" id="authkey" required="true" value="<?php echo $this->authcode; ?>" />
                            <input type="button" name="submit" id="submit" class="enter_btn" value="ENTER" onclick="do_submit('#lvl3_form');" />
                        </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<script type="text/javascript">
function check_key( key ) {
	var k_id = '#' + key;
	var p_id = k_id + '_p';
	var l_id = k_id + '_l';
	var t_id = k_id + '_tip';
	if ( '' == $(k_id).val() ) {
		notice_me( k_id, '不能为空' );
	} else {
		var data = '&do=check&k=' + key + '&val=' + $(k_id).val();
		ajax_post(
			'<?php echo $this->siteurl; ?>',
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
</script>
<div id="ret"></div>
        <!-- left box -->
	<?php $this->need('sidebar'); ?>
<?php $this->need('footer'); ?>
<?php endif ?>