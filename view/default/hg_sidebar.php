<?php if(!defined('INRUN')) exit(); ?>
		<!-- sidebar -->
    	<div class="float_right box sidebar">
        	<!-- lvl -->
        	<div class="lvl radius">
                <h5 class="title b_title"><span class="icon achieve_icon"></span>关卡列表/通关进度</h5>
                <?php
					$op = $this->getop();
					foreach( $this->lvltip as $lvl => $tips ) {
						if ( 'pass' == $lvl ) continue;
				?>
                <h5 class="title lvltitle<?php echo ( $lvl == $op ) ? ' lvlnow' : ' b_title'; ?>" id="<?php echo $lvl; ?>"><span class="icon<?php echo ( $lvl == $op ) ? ' forward_icon' : ' lock_icon'; ?>"></span><?php echo $tips['title']; ?></h5>
                <div class="lvl_tip<?php echo ( $lvl != $op ) ? ' nomargin' : ''; ?>" id="<?php echo $lvl; ?>tip">
                    <span class="icon warning_icon"></span>
                    <?php echo $tips['tip2']; ?>
                </div>
                <?php
					}
				?>
                <h5 class="title w_title"><span class="icon award_icon"></span>荣誉墙</h5>
                <a class="title b_title" href="<?php echo $this->makeurl('ac=restart', $this->siteurl); ?>" title="重新闯关"><span class="icon forward_icon"></span>重新开始</a>
            </div>
            <!-- lvl -->
            <!-- discuss -->
            <div class="discuss radius">
            	<h5 class="title b_title"><span class="icon discuss_icon"></span>到论坛分享通关心得</h5>
                <ul>
                <?php
					$links = $this->links;
					ksort( $links );
					foreach( $links as $link ) {
				?>
                	<li><span class="icon lighten_icon"></span><a href="<?php echo HG_Arsenal::addhttp( $link['url'] ); ?>" target="_blank"><?php echo $link['txt']; ?></a></li>
                <?php
					}
				?>
                </ul>
            </div>
            <!-- discuss -->
        </div>
        <!-- sidebar -->
        <div class="c"></div>