<?php
    class FieldValidator{
        protected $email;
        protected $password;
        protected $passwordRepeat;

        
        public function checkRegistration($email, $password, $passwordRepeat){
            $errors = array();
           
           if (empty($email) OR empty($password) OR empty($passwordRepeat)) {
            array_push($errors,"All fields are required");
           }
           if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email is not valid");
           }
           if (strlen($password)<8) {
            array_push($errors,"Password must be at least 8 character long");
           }
           if ($password!==$passwordRepeat) {
            array_push($errors,"Password does not match");
           }
            return $errors;
        }

        public function checkLogin($email, $password){
            $errors = array();
           
           if (empty($email) OR empty($password)) {
            array_push($errors,"All fields are required");
           }
           if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email is not valid");
           }
           if (strlen($password)<8) {
            array_push($errors,"Password must be at least 8 character long");
           }
            return $errors;
        }
    }
?>
