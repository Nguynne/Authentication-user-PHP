<?php
    require "config.php";
    require "classes/database.php";
    require "classes/user.php";
    $conn = require "inc/db.php";

    if($conn){
       echo "Kết nối thành công <br/>";
        $rs = User::authenticate($conn, "sieunhangao@gmail.com", "password");
        if($rs){
            echo "Đăng nhập thành công";
        }else{
            die("Thông tin đăng nhập không đúng");
        }
    }
?>
