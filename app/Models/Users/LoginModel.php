<?php
    class LoginModel {
        public $db;
        public function __construct()
        {
            $this->db = new Database();

        }
    
        public function checkLogin() {
            // Kiểm tra xem dữ liệu POST có tồn tại không
            if (empty($_POST['email']) || empty($_POST['password'])) {
                return false;
            }
    
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
    
            $sql = "SELECT * FROM users WHERE email = :email and role = 2";
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

        public function addUsertoDB() {

            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT);
            $now = date('Y-m-d H:i:s');
            $role = 2; // Giá trị cố định

            // check email đã tồn tại hay chưa
            $sqlCheck = "select * from users where email = :email";
            $stmt1 = $this->db->pdo->prepare($sqlCheck);
            $stmt1->bindParam(':email', $email);
            $stmt1->execute();
            if(count($stmt1->fetchAll()) > 0){
                return false;
            }

            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT);
            $now = date('Y-m-d H:i:s');
            $role = 2; // Giá trị cố định
        
            // Chuẩn bị câu lệnh SQL
            $sql = "INSERT INTO users (name, email, password, created_at, updated_at, role) 
                    VALUES (:name, :email, :password, :created_at, :updated_at, :role)";
            
            $stmt = $this->db->pdo->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':created_at', $now);
            $stmt->bindParam(':updated_at', $now);
            $stmt->bindParam(':role', $role);
        
            return $stmt->execute();
        }
        
    }
?>