<?php

//home
if ( isset($_GLOBALS['db']) && $_GLOBALS['db'] && HAS_DB ) {

    //每页显示记录
    $eachpage = 12;

    //get total winner record
    $sql = "select count(*) from ".$_GLOBALS['db']->add_perfix('winner');
    $winner_total = $_GLOBALS['db']->result( $_GLOBALS['db']->query($sql), 0 );

    //获得当前页数与总页数
    $total_page = ($winner_total % $eachpage == 0) ? $winner_total / $eachpage : intval($winner_total / $eachpage) + 1;
    $current_page = isset( $_GET['p'] ) ? intval( $_GET['p'] ) : 1;
    $current_page = ( $current_page > $total_page || $current_page < 1 ) ? 1 : $current_page;
    $offset = ($current_page - 1)*$eachpage;

    //get the winner record
    $sql = "select * from ".$_GLOBALS['db']->add_perfix('winner')." order by id desc limit $offset, $eachpage";
    $winner_record = $_GLOBALS['db']->select($sql);

    //top5
    $sql = "select * from ".$_GLOBALS['db']->add_perfix('winner')." order by timespend asc limit 0,5";
    $winner_top5 = $_GLOBALS['db']->select($sql);

} else {
    $winner_files = HG_Arsenal::sscandir(ROOT . 'data/' .WINNER_DIRECTORY. '/');
    $winner_total = count( $winner_files );
    $winner_record = HG_Arsenal::get_winnerdata( $winner_files );
}


require( HM_ROOT . 'template/hman_home.tpl.php' );

?>
