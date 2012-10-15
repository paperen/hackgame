<?php if(!defined('INRUN')) exit(); ?>
		<!-- sidebar -->
    	<div class="float_right box sidebar passbox">
        	<!-- lvl -->
        	<div class="lvl radius">
                <h5 class="title g_title"><span class="icon bell_icon"></span>通关时间统计</h5>
                <?php
					$op = $this->getop();
					foreach( $this->lvltip as $lvl => $tips ) {
						if ( 'pass' == $lvl ) continue;
				?>
                <h5 class="title lvltitle b_title" id="<?php echo $lvl; ?>"><span class="icon ok_icon"></span><?php echo $tips['title']; ?></h5>
                <div class="lvl_tip nomargin_d" id="<?php echo $lvl; ?>tip">
                    <?php echo '该关使用了 ' . $this->count_lvltime( $lvl ); ?>
                </div>
                <?php
					}
				?>
                <h5 class="title lvltitle b_title total_title" id="total_cost"><span class="icon ok_icon"></span><?php echo '总时间为 ' . $this->count_lvltime( 'total' ); ?></h5>
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