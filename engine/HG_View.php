<?php

/**
 * View视图类
 */
class HG_View
{

	private $_skin = 'default';
	private $_skin_path;
	private $_view_url;
	private $_hg_setting;
	private $_data = array();

	function __construct() {
		$this->_hg_setting = HG_Arsenal::load_engine( 'HG_Setting' );
	}

	public function set_skin( $skin ) {
		$this->_skin = $skin;
		$this->_skin_path = VIEW . $this->_skin . DIRECTORY_SEPARATOR;
		$this->_view_url = trim( $this->_hg_setting->siteurl, '/' ) . '/view/' . $this->_skin . '/';
	}

	private function _merge_data( $data ) {
		$this->_data = array_merge( $this->_data, $data );
	}

	public function load( $view, $data = array( ) ) {
		$this->_merge_data( $data );
		$view_file = $this->_skin_path . strtolower( $view ) . '.php';
		if ( !file_exists( $view_file ) ) exit( "{$view}视图文件不存在" );
		extract( $this->_data );
		require( $view_file );
	}

	public function css( $css ) {
		$css = $this->_view_url . $css;
		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$css}\" media=\"all\" />";
	}

	public function js( $js ) {
		$js = $this->_view_url . $js;
		echo "<script type=\"text/javascript\" src=\"{$js}\"></script>";
	}

}

?>