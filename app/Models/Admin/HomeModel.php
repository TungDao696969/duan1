<?php
    class HomeModel {
        public $db;
        public function __construct()
        {
            $this->db = new Database();

        }

       

        // public function checkLogin() {
        //     $email = $_POST ['email'];
        //     $password = $_POST['password'];
        //     $sql = "SELECT * FROM users WHERE email = :email and role = 1";
        //     $stmt = $this->db->pdo->prepare($sql);
        //     $stmt->bindParam(':email', $email);
        //     $stmt->execute();

        //     $result = $stmt->fetch();
        //     if ($result && password_verify($password, $result->password)) {
        //         return $result;
        //     }
        //     return false;
            
        // }

        public function checkLogin() {
            // Kiểm tra xem dữ liệu POST có tồn tại không
            if (!isset($_POST['email']) || !isset($_POST['password'])) {
                return false;
            }
        
            $email = trim($_POST['email']); // Loại bỏ khoảng trắng
            $password = trim($_POST['password']); // Loại bỏ khoảng trắng
        
            $sql = "SELECT * FROM users WHERE email = :email and role = 1";
            $stmt = $this->db->pdo->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
        
            $result = $stmt->fetch();
        
            // Kiểm tra mật khẩu
            if ($result && password_verify($password, $result->password)) {
                return $result;
            }
            return false;
        }
    }
?>