<?php
    class User{

        // Class user
        public $id;
        public $username;
        public $password;

        //Constructor

        public function __construct($username = '', $password = ''){
            if ($username != '' && $password != '') {
                $this->username = $username;
                $this->password = $password;
            }
        }

        //Phương thức kiểm tra nhập dữ liệu
        protected function validate(){
            $rs = $this->username != '' && $this->password != '';
            return $rs;
        }

        //Kiểm tra username và pass
        public static function authenticate($conn, $username, $password){
            $sql = "select * from users where username=:username";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);// Liên kết một giá trị với một tham số
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'User'); //Trả về 1 đổi tượng
            $stmt->execute(); // Thực hiện câu lệnh sql
            $user = $stmt->fetch(); // Lấy ra cái đối tượng
            if($user){
                $hash = $user->password;
                return password_verify($password, $hash);
            }
        }

        // Thêm phương thức adduser
        public function addUser($conn){
            if($this->validate()){  
                //Tạo câu lệnh insert chống SQL injection
                $sql = "insert into users(username, password)
                        values(:username, :password);";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':username', $this->username, PDO::PARAM_STR);
                $hash = password_hash($this->password, PASSWORD_DEFAULT);
                $stmt->bindValue(':password', $hash, PDO::PARAM_STR);
                return $stmt->execute();
            }else{
                return false;
            }
        }
    }
?>