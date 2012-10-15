<?php if(!defined('INRUN')) exit(); ?>
<?php if( $this->isajax ) : ?>
	<?php if( $this->msg_state > 0 ) : ?>
    <script type="text/javascript">
	$('#msg_tip').removeClass('msg_failed');
	$('#msg_tip').addClass('msg_success');
	$('#msg_tip #icon').removeClass('warning_icon');
	$('#msg_tip #icon').addClass('ok_icon');
	$('#msg_tip #inner').html('<?php echo $this->msg_tip; ?>');
	$('#msg_tip').fadeIn('fast');
	timer(function(){window.location.reload();}, 3500);
	</script>
    <?php else:	?>
    <script type="text/javascript">
	$('#msg_tip').removeClass('msg_success');
    $('#msg_tip').addClass('msg_failed');
	$('#msg_tip #icon').removeClass('ok_icon');
	$('#msg_tip #icon').addClass('warning_icon');
	$('#msg_tip #inner').html('<?php echo $this->msg_tip; ?>');
	$('#msg_tip').fadeIn('fast');
	timer(function(){$('#msg_tip').fadeOut('fast', function(){$('#pass_form form').fadeIn('fast');});}, 3500);
	</script>
    <?php endif; ?>
<?php else : ?>
	<?php $this->need('header'); ?>
            <!-- left box -->
            <div class="float_left">
                <div class="box commonbox passbox radius">
                    <h5 class="title g_title">
                        <span class="icon achieve_icon"></span>
                        <span class="mission pass"></span>
                        <span id="no_script" class="noscript"></span>
                    </h5>
                    <div class="box_inner">
                        <div class="main_box radius">
                            <span class="icon ok_icon"></span>
                            <?php echo $this->lvltip[$this->getop()]['tip1']; ?>
                        </div>
                    </div>
                </div>
                <?php if( !$this->done_msg ) : ?>
                <div class="box commonbox guestbook radius">
                    <h5 class="title g_title">
                        <span class="icon addressbook_icon"></span>
                        <span class="mission message"></span>
                    </h5>
                    <div class="box_inner">
                        <div class="main_box radius">
                            <div class="main_form pass_form" id="pass_form">
                                <div class="msg_tip radius" id="msg_tip">
                                	<span class="icon" id="icon"></span>
                                    <span id="inner"></span>
                                </div>
                                <form method="post" action="">
                                <span class="icon avatar_icon"></span>
                                <p class="each">
                                    <label for="username">昵称</label>
                                    <span class="icon user_icon"></span>
                                    <input type="text" name="username" id="username" class="txtbox radius" required="true" title="请填写昵称" maxlength="50" />
                                </p>
                                <p class="each">
                                    <label for="email">邮箱</label>
                                    <span class="icon email_icon"></span>
                                    <input type="text" name="email" id="email" class="txtbox radius" required="true" title="请填写邮箱" maxlength="50" />
                                </p>
                                <p class="each">
                                    <label for="icq">ICQ&nbsp;</label>
                                    <span class="icon qq_icon"></span>
                                    <input type="text" name="icq" id="icq" class="txtbox radius" required="true" title="请填写ICQ" maxlength="50" />
                                </p>
                                <p>
                                    <label for="message">我想说</label>
                                </p>
                                <p>
                                    <textarea name="message" id="message" title="您的意见or感受" required="true" class="txtbox radius tarea"></textarea>
                                </p>
                                <p>
                                    <input type="hidden" name="authkey" id="authkey" required="true" value="<?php echo $this->authcode; ?>" />
                                    <input type="button" name="submit" id="submit" class="finish_btn" value="FINISH" onclick="do_msg();" title="提交" />
                                </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $this->import('script_msg', 'js'); ?>
                <?php else : ?>
                <div class="box commonbox recommendbox radius">
                    <h5 class="title g_title">
                        <span class="icon blub_icon"></span>
                        <span class="mission share"></span>
                    </h5>
                    <div class="box_inner">
                        <div class="main_box radius">
                            <div class="main_form recommend_form" id="recommend_form">
                                不如也推荐给好友玩玩吧
                                <p class="link"><?php echo $this->siteurl; ?></p>
                                <input type="button" id="again" class="finish_btn" value="再玩一次" onclick="window.location.href='<?php echo $this->makeurl('ac=restart', $this->siteurl); ?>';" title="再玩一次" />
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <!-- left box -->
        <?php $this->need('sidebar_pass'); ?>
    <?php $this->need('footer'); ?>
<?php endif; ?>