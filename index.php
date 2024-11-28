<?php
session_start();
include 'app/Database/Database.php';

include 'app/Models/Admin/HomeModel.php';
include 'app/Models/Admin/UserModel.php';
include 'app/Models/Admin/CategoryModel.php';
include 'app/Models/Admin/ProductModel.php';
include 'app/Models/Users/CategoryUserModel.php';
include 'app/Models/Users/ProductUserModel.php';

include 'app/Controllers/Admin/ControllerAdmin.php';
include 'app/Controllers/Admin/HomeController.php';
include 'app/Controllers/Admin/LoginController.php';
include 'app/Controllers/Admin/UserController.php';
include 'app/Controllers/Admin/CategoryController.php';
include 'app/Controllers/Admin/ProductController.php';

include 'app/Controllers/Users/LoginUserController.php';
include 'app/Controllers/Users/DasboardController.php';

const BASE_URL = "http://localhost/duan1/";

include 'router/web.php';
// echo password_hash('123456', PASSWORD_BCRYPT);
?>