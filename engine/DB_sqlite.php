<?php

class DB_sqlite
{
    private $_link;
    private $_sth;
    private $_querynum = 0;
    private $_perfix;

    function  __construct() {
        if ( !$this->is_compatible() ) return false;
    }
    public function add_perfix($table){
        return $this->_perfix.$table;
    }
    public function is_compatible() {
        return class_exists('PDO');
    }
    public function connect( $db_config ) {
        $this->_perfix = isset( $db_config['perfix'] ) ? $db_config['perfix'] : '';
        if ( !$this->_link = new PDO($db_config['file']) ) {
            exit('PDO connect failed');
        } else {
            return $this;
        }
    }
    public function prepare( $sql, array $format ) {
		$format = array( $format );
        $this->_sth = $this->_link->prepare($sql);
		foreach( $format as $single ) {
			$this->_sth->bindValue($single[0], $single[1], $single[2]);
		}
		$result = $this->_sth->execute();
        return $result;
    }
    public function query( $sql ) {
        $this->_querynum++;
        return $this->_link->query( $sql );
    }
    public function get_one( $sql ) {
        $sql = ( strpos(strtolower($sql), 'limit') === false ) ? $sql . ' limit 1 ' : $sql ;
        $result = $this->query($sql);
		if ( empty( $result ) ) return NULL;
        $ret = '';
        foreach( $result as $res ) {
			$ret = $res;
			break;
		}
        return $ret;
    }
    public function select( $sql ) {
        $results = $this->query($sql);
		if ( empty( $results ) ) return NULL;
        $tmp = array();
        foreach( $results as $result ) {
			$tmp[] = $result;
		}
        return $tmp;
    }
    public function result( $result, $index = '' ) {
        foreach( $result as $row )
        if ( $row && $index ) {
            return (isset($row[$index])) ? $row[$index] : $row[0];
        } else {
            return $row[0];
        }
    }
    public function insert( $table, array $datas ) {
        $key_str = $val_str = '';
        foreach($datas as $k => $val) {
            $key_str .= ",`$k`";
            $val_str .= ",'$val'";
        }
        $sql = "insert into `$table` (" .substr($key_str, 1). ") values (". substr($val_str, 1) .")";
        $this->query($sql);
        return $this->insert_id();
    }
    public function update( $table, array $datas, $where = '' ) {
        $tmp = '';
        foreach($datas as $k => $val) {
            $tmp .= ",`$k` = '$val'";
        }
        $sql = "update `$table` set " . substr($tmp, 1);
        if ( $where ) $sql .= ' where ' . $where;
        $this->_querynum++;
        return $this->_link->exec($sql);
    }
    public function get_querynum() {
        return $this->_querynum;
    }
    public function insert_id() {
        return $this->_link->lastInsertId();
    }
	function __destruct() {

	}
}

?>