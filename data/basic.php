<?php

/**
 *
 * HackGame 基本数据
 *
 */

$settings = array(
    'sitename' => '黑客游戏',
    'siteurl' => 'http://localhost/hackgame2/',
    'keywords' => '黑客游戏，HackGame，模拟入侵，安全攻防，习科，电脑报',
    'description' => '黑客游戏2，HackGame，模拟黑客入侵',
    'foottxt' => '<p>主办方 电脑报</p><p>方案策划 Smart Cool</p><p>设计与程序 Paperen</p><p>但这仅仅是一个游戏</p>',
    'copration' => '2012 HackGame3',
    'skin' => 'default',
    'charset' => 'utf-8',
    'links' => array(
        '1' => array('txt' => '电脑报瓢虫论坛', 'url' => 'bbs.icpcw.com'),
        '2' => array('txt' => '习科交流论坛', 'url' => 'bbs.blackbap.org'),
    ),
    'lvlsession' => array(
        'welcome' => 'stER2V32ui98',
        'first' => 'ewQd54-2Kx3G',
        'second' => 'UYSd+3iop62i',
        'third' => 'Xzs48*3ikLM0',
        'fourth' => '#DTkls74Po1S',
        'fifth' => 'R3@dxMiJ+32U',
        'pass' => 'VGs4-dPs9t31',
    ),
	'default_controller' => 'welcome',
	'default_method' => 'index',
	'db_type' => 'sqlite',
	'db_config' => array(),
	'title' => array(
		'first' => '第一关',
		'second' => '第二关',
		'third' => '第三关',
		'fourth' => '第四关',
		'fifth' => '第五关',
		'pass' => '恭喜 闯关完成',
	),
);

?>