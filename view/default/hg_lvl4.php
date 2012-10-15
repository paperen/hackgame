<?php if(!defined('INRUN')) exit(); ?>
<?php if ( $this->isajax ): ?>
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
    timer(function(){$('#passtip').remove();$('#lvl4_form form').fadeIn('fast');}, 2500);
    </script>
    <?php } ?>
<?php else: ?>
<?php $this->need('header'); ?>
        <!-- left box -->
    	<div class="float_left box commonbox lvl4 radius">
        	<h5 class="title b_title">
            	<span class="icon blub_icon"></span>
            	<span class="mission mission4"></span>
                <span id="no_script" class="noscript"></span>
            </h5>
            <div class="box_inner">
                <div class="main_box radius">
                    <blockquote class="quote">
                    	<span class="icon quote_s"></span>
                        <span class="icon quote_e"></span>
                    	<?php echo $this->lvltip[$this->getop()]['tip1']; ?>
                    </blockquote>
                    <div class="main_form lvl4_form" id="lvl4_form">
                    	<form method="post" action="">
                        <p><label for="password">输入通关密码 PassWord</label></p>
                        <p>
                        	<span class="icon key_icon"></span>
                        	<input type="password" name="password" id="password" class="txtbox pwdbox radius" required="true" title="请填写通关密码" />
                            <input type="hidden" name="authkey" id="authkey" required="true" value="<?php echo $this->authcode; ?>" />
                            <input type="button" name="submit" id="submit" class="enter_btn" value="ENTER" onclick="do_submit('#lvl4_form');" />
                        </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- left box -->
	<?php $this->need('sidebar'); ?>
<?php $this->need('footer'); ?>
<?php endif ?>