<?php
    /*
        Lớp xử lý kết nối CSDL
        Bao gồm: các thuộc tính và phương thức liên quan
     */
    class Database {
        protected $db_host;
        protected $db_name;
        protected $db_user;
        protected $db_pass;

        public function __construct($host, $name, $user, $pass)
        {
            $this->db_host = $host;
            $this->db_name = $name;
            $this->db_user = $user;
            $this->db_pass = $pass;
        }

        public function getConn()
        {
            // Tạo Datasource name
            $dsn = "mysql:host={$this->db_host}; dbname={$this->db_name};charset=utf8";
            try
            {
                // Connect to database server
                $conn = new PDO($dsn, $this->db_user, $this->db_pass);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $conn;
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
        }
    }
?>
