<?php
    mysqli_report(MYSQLI_REPORT_STRICT);

    class AbstractDAO{
        protected $mysqli;
        private $dbError;
        
        protected static $DB_HOST = 'localhost:3306';
        protected static $DB_USERNAME = 'wp_eatery';
        protected static $DB_PASSWORD = 'password';
        protected static $DB_DATABASE = 'wp_eatery';

        function __construct(){
            try{
                $this->mysqli = new mysqli(self::$DB_HOST, self::$DB_USERNAME, self::$DB_PASSWORD, self::$DB_DATABASE);
            }catch(mysqli_sql_exception $e){
                throw $e;
            }
            if(mysqli_connect_error()){
                $this->dbError = true;
                die("Connection failed". mysqli_connect_error());      
            }else{
                $this->dbError = false;
                echo "Connection established; <br>";
            }
        }

        public function getMysqli(){
            return $this->mysqli; 
        }

        public function hasDbError(){
            return $this->dbError;
        }
    }


?>