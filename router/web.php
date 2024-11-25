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
                $loginController = new LoginController();
                $loginController->login();
    
            }
            // http://localhost/duan1/?role=admin&act=post-login
            case 'post-login': {
                $loginController = new LoginController();
                $loginController->postlogin();
    
            }
            case 'logout': {
                $loginController = new LoginController();
                $loginController->logout();
    
            }
            case 'all-user': {
                $userController = new UserController();
                $userController->getAllUser();
    
            }
            case 'add-user': {
                $userController = new UserController();
                $userController->addUser();
    
            }
            case 'post-add-user': {
                $userController = new UserController();
                $userController->addPostUser();
    
            }
            case 'update-user': {
                $userController = new UserController();
                $userController->updateUser();
    
            }
            case 'update-post-user': {
                $userController = new UserController();
                $userController->updatePostUser();
    
            }
            case 'delete-user': {
                $userController = new UserController();
                $userController->deleteUser();
    
            }
            case 'show-user': {
                $userController = new UserController();
                $userController->showUser();
    
            }
            case 'all-category': {
                $categoryController = new CategoryController();
                $categoryController->getAllCategory();
    
            }
            case 'add-category': {
                $categoryController = new CategoryController();
                $categoryController->addCategory();
    
            }
            case 'add-post-category': {
                $categoryController = new CategoryController();
                $categoryController->addPostCategory();
    
            }
            case 'delete-category': {
                $categoryController = new CategoryController();
                $categoryController->deleteCategory();
    
            }
            case 'update-category': {
                $categoryController = new CategoryController();
                $categoryController->updateCategory();
    
            }
            case 'update-post-category': {
                $categoryController = new CategoryController();
                $categoryController->updatePostCategory();
    
            }
            case 'show-category': {
                $categoryController = new CategoryController();
                $categoryController->showCategory();
    
            }
            case 'all-product': {
                $productController = new ProductController();
                $productController->showAllProduct();
                break;
            }
            case 'add-product': {
                $productController = new ProductController();
                $productController->addProduct();
                break;
            }
            case 'add-post-product': {
                $productController = new ProductController();
                $productController->addPostProduct();
                break;
            }
            case 'delete-product': {
                $productController = new ProductController();
                $productController->deleteProduct();
                break;
            }
            case 'update-product': {
                $productController = new ProductController();
                $productController->updateProduct();
                break;
            }
            case 'update-post-product': {
                $productController = new ProductController();
                $productController->updatePostProduct();
                break;
            }
            case 'show-product': {
                $productController = new ProductController();
                $productController->showProduct();
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