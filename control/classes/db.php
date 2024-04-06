<?php

class db {
    public static $_instance = null;
    public $_pdo,
            $_query,
            $_error = false,
            $_results,
            $_bind_param,
            $_count = 0,
            $_last_insert_id ;

    public function __construct() {
        try {
            $this->_pdo = new PDO('mysql:host=' . config_get('mysql/host') . ';dbname=' . config_get('mysql/db'), config_get('mysql/username'), config_get('mysql/password'), 
                array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES latin1, SQL_MODE='NO_BACKSLASH_ESCAPES';"
                ) 
            );
            $this->_pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,FALSE);
            $this->_pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die($e->getMessage());
            exit();
        }
    }
    public static function getInstance() {
        if(!isset(self::$_instance)) {
            self::$_instance = new db();
        }
        return self::$_instance;
    }
    public static function connect() {
        $con = mysqli_connect(config_get('mysql/host'),config_get('mysql/username'), config_get('mysql/password'),config_get('mysql/db'));
        if ($con->connect_error) {
            die('Error : ('. $con->connect_errno .') '. $con->connect_error);
        }
        return $con;
    }
    public function query($sql, $params = array()) {
        $this->_error = false;

        if($this->_query = $this->_pdo->prepare($sql)) {
            $x = 1;
            if(count($params)) {
                foreach($params as $param) {
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }

            if($this->_query->execute()) {
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            } else {
                $this->_error = true;
            }

        }

        return $this;
    }

    public function action($action, $table, $where = array(),$limit = null,$group = null, $d_a='DESC') {
        if(count($where) === 3 || count($where)===7) {
        $operators = array('=', '!=', '>', '<', '>=', '<=', 'LIKE', 'NOT LIKE', 'IN','GROUP BY');
       if($limit != null){
            $limit = ' LIMIT '.$limit;
        }

            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];
  
            if( isset ( $where[3] ) ) {
                $join = $where[3];
                $field2 = $where[4];
                $operator2 = $where[5];
                $value2 = $where[6];
            }

            if( isset ( $where[7]  ) ) {
                $join2     = $where[7];
                $field3    = $where[8];
                $operator3 = $where[9];
                $value3    = $where[10];
                
                $placeIds = str_repeat('?,', count($value) - 1) . '?';
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ($placeIds) ORDER BY id ".$d_a." {$limit}";
                        if(!$this->query($sql, $value )->error()) {
                            return $this;
                        }
                    }
            if(in_array($operator, $operators)  ) {
                if( isset( $where[3] ) ) {
                    $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ? {$join} {$field2} {$operator2} ?  ORDER BY id ".$d_a." {$limit} ";

                    if(!$this->query($sql, array($value, $value2))->error()) {
                        return $this;
                    }
                } else {
                    if( $operator == "IN" ||  $operator == "GROUP BY" ) {
                        $placeIds = str_repeat('?,', count($value) - 1) . '?';

                        $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ($placeIds) ORDER BY id ".$d_a." {$limit}";
                        if(!$this->query($sql, $value )->error()) {
                            return $this;
                        }
                    } else {
                //$placeIds = str_repeat('?,', count($value) - 1) . '?';
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ? ORDER BY id ".$d_a." {$limit}";
                        if(!$this->query($sql, array($value))->error()) {
                            return $this;
                        }
                    }
                }
                
            }

        }

        return false;
    }

    public function insert($table, $fields = array()) {
        $keys = array_keys($fields);
        $values = null;
        $x = 1;

        foreach($fields as $field) {
            $values .= '?';
            if ($x < count($fields)) {
                $values .= ', ';
            }
            $x++;
        }

        $sql = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`) VALUES ({$values})";

        if(!$this->query($sql, $fields)->error()) {
            $this->_last_insert_id = $this->_pdo->lastInsertId();
            return true;
        }

        return false;
    }

    public function change($table, $id, $fields) {
        $set = '';
        $x = 1;

        foreach($fields as $name => $value) {
            $set .= "{$name} = ?";
            if($x < count ($fields)) {
                $set .= ', ';
            }
            $x++;
        }

        $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";

        if(!$this->query($sql, $fields)->error()) {
            return true;
        }

        return false;
    }
    
    public function update($table, $fields = array()) {
        $set = '';
        $x = 1;
        $user = new user();
        $id = $user->data()->id;
        foreach($fields as $name => $value) {
            $set .= "{$name} = ?";
            if($x < count ($fields)) {
                $set .= ', ';
            }
            $x++;
        }

        $sql = "UPDATE {$table} SET {$set} WHERE user_id = {$id}";

        if(!$this->query($sql, $fields)->error()) {
            return true;
        }

        return false;
    }

    public function delete($table, $where) {
        return $this->action('DELETE ', $table, $where);
    }
    public function get($table, $where, $limit=null, $d_a='DESC') {
        return $this->action('SELECT * ', $table, $where, $limit, null, $d_a);
    }

    public function limit($table, $where,$limit=null) {
        return $this->action('SELECT * ', $table, $where,$limit);
    }
    public function results() {
        return $this->_results;
    }

    public function first() {
        $data = $this->results();
        return $data[0];
    }

    public function count() {
        return $this->_count;
    }
    public function bind_param() {
        return $this->_bind_param;
    }
    public function error() {
        return $this->_error;
    }

    public function return_mysql_insert_id() {
        return $this->_last_insert_id;
    }

    public function __destruct() {  
        $this->_pdo = null;
    }
}