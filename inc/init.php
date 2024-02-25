<?php
    /*
        Tự động gọi các class tương ứng
    */
    spl_autoload_register(
        function($className){
            // Tên lớp tương ứng với tên file chứa lớp
            // Ex: user.php -> User  . ".php";
            // Ex: database.php -> Database . ".php";
            $fileName = strtolower($className) . ".php";
            $dirRoot = dirname(__DIR__);
            require $dirRoot . "/classes/{$fileName}";
        }
    );
    require dirname(__DIR__) . "/config.php";
    if(session_id() === '') session_start();
?>