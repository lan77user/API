<?php

class DB {

    public static $_instance;
    public static $_dbConnect;
    private $_dbConfig = [
        'host' => 'localhost',
        'user' => 'root',
        'pass' => '123456',
        'dbname' => 'movie',
        'port' => '3306',
    ];

    private function __construct() {
        
    }

    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * mysqli方式连接数据库
     * @return type
     */
    public function mysqliConnect() {

        //如果这个资源不存在，才进行此链接操作
        if (!self::$_dbConnect) {
            self::$_dbConnect = new mysqli($this->_dbConfig['host'], $this->_dbConfig['user'], $this->_dbConfig['pass'], $this->_dbConfig['dbname']);
//            判断数据库是否连接上
            if (self::$_dbConnect->connect_error) {
                throw new Exception('mysql connect error : '. self::$_dbConnect->connect_error);
                var_dump(mysqli_connect_error());
            }

            self::$_dbConnect->select_db($this->_dbConfig['dbname']);
            self::$_dbConnect->set_charset("utf8");
            return self::$_dbConnect;
        }
    }

    
    /**
     * PDO方式连接数据库
     */
    public function pdoConnect() {

        $dsn = sprintf("mysql:dbname=%s;host=%s", $this->_dbConfig['dbname'], $this->_dbConfig['host']);

         if (!self::$_dbConnect) {
            self::$_dbConnect = new PDO($dsn, $this->_dbConfig['user'], $this->_dbConfig['pass']);
            if (!self::$_dbConnect) {
                die("没有连接到这样的主机");
            }
            self::$_dbConnect->select_db($this->_dbConfig['dbname']);
            self::$_dbConnect->set_charset("utf8");
            return self::$_dbConnect;
        }
       
    }

}
