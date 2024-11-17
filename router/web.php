<?php
    $role = isset($_GET['role']) ? $_GET['role'] : 'users';
    $act = isset($_GET['act']) ? $_GET['act'] : "";

    if ($role == "users") {
        echo "Trang user";
    }else{
        switch($act) {
            // http://localhost/duan1/?role=admin&act=home
            case 'home': {
                $homeController = new HomeController();
                $homeController->__dashboard();
    
            }
            // http://localhost/duan1/?role=admin&act=login
            case 'login': {
                $homeController = new HomeController();
                $homeController->login();
    
            }
            // http://localhost/duan1/?role=admin&act=post-login
            case 'post-login': {
                $homeController = new HomeController();
                $homeController->postlogin();
    
            }
            case 'product': {
                break;
            }
            default: {
                $homeController = new HomeController();
                $homeController->__dashboard();
                break;
            }
        }
    }
    
?>