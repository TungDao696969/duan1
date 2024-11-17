<?php
class HomeController {
    public function __dashboard()
    {
        $homeModel = new HomeModel();
        $dataUsers = $homeModel->getUsers();
        include 'app/Views/Admin/index.php';
    }

    public function login() {
        include 'app/Views/Admin/login.php';
    }
    public function postlogin() {
        // $_POST['email'];
        // $_POST['password'];
        $homeModel = new HomeModel();
        $dataUsers = $homeModel->checkLogin();
        // var_dump($dataUsers);
        if ($dataUsers) {
            header("location: " . BASE_URL . "?role=admin&act=home" );
            exit;
        }else{
            header("location: " . BASE_URL . "?role=admin&act=login" );
            exit;
        }
    }
} 
