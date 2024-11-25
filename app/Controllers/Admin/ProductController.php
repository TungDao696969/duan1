<?php
class ProductController{
    public function showAllProduct(){
        $productModel = new ProductModel();
        $listProduct = $productModel->getAllProduct();

        include 'app/Views/Admin/products.php';
    }

    public function addProduct(){
        $categoryModel = new CategoryModel();
        $listCategory = $categoryModel->allCategory();
        include 'app/Views/Admin/add-product.php';
    }

    public function checkValidate() {
        $name = $_POST['name'];
        $category = $_POST['category'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];

        if ($name !== "" && $category !== "" && $price !== "" && $stock !== ""){
            return true;
        }else{
            $_SESSION['error'] = "Ban nhap thieu thong tin";
            return false;
        }
    }

    public function addPostProduct(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(!$this->checkValidate()){
                header("Location: " . BASE_URL . "?role=admin&act=add-product");
                exit;
            }
            $uploadDir = 'assets/Admin/upload/';
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $destPath = "";

            if (!empty($_FILES['image_main']['name'])) {
                $fileTmPath = $_FILES['image_main']['tmp_name'];
                $fileType = mime_content_type($fileTmPath);
                $fileName = basename($_FILES['image_main']['name']);
                $fileExtention = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                $newFileName = uniqid() . '.' . $fileExtention;


                if (in_array($fileType, $allowedTypes)){
                    $destPath = $uploadDir . $newFileName;
                    if(!move_uploaded_file($fileTmPath, $destPath)) {
                        $destPath = "";
                    }
                    
                }
            }

            $productModel = new ProductModel();
            $isProduct = $productModel->addProductToDB($destPath);

            if (!$isProduct || !is_numeric($isProduct)) {
                die("Lỗi: Không thể thêm sản phẩm vào cơ sở dữ liệu.");
            }

            if (!$isProduct) {
                $_SESSION['message'] = "Them moi thanh cong";
                    header("location: " . BASE_URL . "?role=admin&act=all-product" );
                    exit;
            }

            // them thu vien anh
            if (isset($_FILES['image'])) {
                foreach ($_FILES['image']['name'] as $key => $name){
                    $destPathImage = "";
                    if (!empty($name)) {
                        $fileTmPath = $_FILES['image']['tmp_name'][$key];
                        $fileType = mime_content_type($fileTmPath);
                        $fileName = basename($name);
                        $fileExtention = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
                        $newFileName = uniqid() . '.' . $fileExtention;
        
                        if (in_array($fileType, $allowedTypes)){
                            $destPathImage = $uploadDir . $newFileName;
                            if(!move_uploaded_file($fileTmPath, $destPathImage)) {
                                $destPathImage = "";
                            }
                            
                        }
                    }
                    if ($destPathImage !== "") {
                        if (!$productModel->addGaryImage($destPathImage, $isProduct)) {
                            die("Lỗi: Không thể thêm ảnh vào cơ sở dữ liệu.");
                        }
                    }
                }
            }
            $_SESSION['message'] = "Them moi thanh cong";
            header("location: " . BASE_URL . "?role=admin&act=all-product" );
            exit;
        }
    }

    public function deleteProduct(){
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            $_SESSION['message'] = "Vui lòng chọn product cần xóa";
            header("location: " . BASE_URL . "?role=admin&act=all-product");
            exit;
        }
        $productModel = new ProductModel();
        // xoa anh
        $product = $productModel->getProductByID();
        if($product->image_main !== null){
            unlink($product->image_main);
        }
        // xoa anh trong product_image
        $listImage = $productModel->getProductImageByID();
        foreach($listImage as $key => $value) {
            if($value->image !== null){
                unlink($value->image);
            }
        }
        $message = $productModel->deleteProductToDB();

        if ($message) {
            $_SESSION['message'] = "Xoa thanh cong";
                header("location: " . BASE_URL . "?role=admin&act=all-product" );
                exit;
        }else {
            $_SESSION['message'] = "Chinh sua khong thanh cong";
            header("location: " . BASE_URL . "?role=admin&act=all-product");
            exit;
        }
    }

    public function updateProduct(){
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            $_SESSION['message'] = "Vui lòng chọn product cần xóa";
            header("location: " . BASE_URL . "?role=admin&act=all-product");
            exit;
        }
        $categoryModel = new CategoryModel();
        $listCategory = $categoryModel->allCategory();

        $productModel = new ProductModel();
        $product = $productModel->getProductByID();
        $listProductImage = $productModel->getProductImageByID();
        include 'app/Views/Admin/update-product.php';

    }

    public function updatePostProduct(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                $_SESSION['message'] = "Vui lòng chọn product cần xóa";
                header("location: " . BASE_URL . "?role=admin&act=all-product");
                exit;
            }
            if(!$this->checkValidate()){
                header("Location: " . BASE_URL . "?role=admin&act=update-product&id=" . $_GET['id']);
                exit;
            }
            $productModel = new ProductModel();
            $product = $productModel->getProductByID();

            $uploadDir = 'assets/Admin/upload/';
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $destPath = $product->image_main;

            if (!empty($_FILES['image_main']['name'])) {
                $fileTmPath = $_FILES['image_main']['tmp_name'];
                $fileType = mime_content_type($fileTmPath);
                $fileName = basename($_FILES['image_main']['name']);
                $fileExtention = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                $newFileName = uniqid() . '.' . $fileExtention;

                if (in_array($fileType, $allowedTypes)){
                    $destPath = $uploadDir . $newFileName;
                    if(!move_uploaded_file($fileTmPath, $destPath)) {
                        $destPath = "";
                    }
                    unlink($product->image_main);
                }
            }

            $productModel = new ProductModel();
            $massage = $productModel->updateProductToDB($destPath);


            if (!$massage) {
                $_SESSION['message'] = "Chinh sua khong thanh cong";
                    header("location: " . BASE_URL . "?role=admin&act=update-product&id=" . $_GET['id'] );
                    exit;
            }

            // them thu vien anh
            if (isset($_FILES['image']) && count($_FILES['image']) > 0) {
                $listImage = $productModel->getProductImageByID();
                foreach ($listImage as $key => $value){
                    if($value->image !== null){
                        unlink($value->image);
                    }
                }
                $productModel->deleteImageGary();

                foreach ($_FILES['image']['name'] as $key => $name){
                    $destPathImage = "";
                    if (!empty($name)) {
                        $fileTmPath = $_FILES['image']['tmp_name'][$key];
                        $fileType = mime_content_type($fileTmPath);
                        $fileName = basename($name);
                        $fileExtention = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
                        $newFileName = uniqid() . '.' . $fileExtention;
        
                        if (in_array($fileType, $allowedTypes)){
                            $destPathImage = $uploadDir . $newFileName;
                            if(!move_uploaded_file($fileTmPath, $destPathImage)) {
                                $destPathImage = "";
                            }
                            
                        }
                    }
                    if ($destPathImage !== "") {
                        if (!$productModel->addGaryImage($destPathImage, $_GET['id'])) {
                            die("Lỗi: Không thể thêm ảnh vào cơ sở dữ liệu.");
                        }
                    }
                }
            }
            $_SESSION['message'] = "Chinh sua thanh cong";
            header("location: " . BASE_URL . "?role=admin&act=all-product");
            exit;
        }
    }

    public function showProduct(){
        if (!isset($_GET['id'])) {
            $_SESSION['message'] = "Vui lòng chọn product cần xem";
            header("location: " . BASE_URL . "?role=admin&act=all-product");
            exit;
        }
        $productModel = new ProductModel();
        $product = $productModel->getProductByID();
        include 'app/Views/Admin/show-product.php';
    }
}