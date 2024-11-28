<?php
    class CategoryController{
        public function getAllCategory(){
            $categoryModel = new CategoryModel();
            $listCategori = $categoryModel->allCategory();
            include 'app/Views/Admin/categories.php';
        }

        public function addCategory() {
            include 'app/Views/Admin/add-category.php';
        }
    
        public function addPostCategory() {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Đảm bảo xử lý trước khi xuất HTML
                $categoryModel = new CategoryModel();
                $message = $categoryModel->addCategory();

                if ($message) {
                    $_SESSION['message'] = "Thêm mới thành công";
                    header("Location: " . BASE_URL . "?role=admin&act=all-category");
                    exit;
                } else {
                    $_SESSION['message'] = "Thêm mới không thành công";
                    header("Location: " . BASE_URL . "?role=admin&act=add-category");
                    exit;
                }
            }else {
                header("Location: " . BASE_URL . "?role=admin&act=add-category");
                exit;
            }
        }
        
        public function deleteCategory() {
            if(!isset($_GET['id'])){
                $_SESSION['message'] = "Vui long chon category can xoa";
                header("location: " . BASE_URL . "?role=admin&act=all-category" );
                exit;
            }
            $categoryModel = new CategoryModel();
            $message = $categoryModel->deleteCategory();
            if ($message) {
                $_SESSION['message'] = "Xoa thành công";
                header("Location: " . BASE_URL . "?role=admin&act=all-category");
                exit;
            } else {
                $_SESSION['message'] = "Xoa không thành công";
                header("Location: " . BASE_URL . "?role=admin&act=all-category");
                exit;
            }
        }

        public function updateCategory() {
            
            if(!isset($_GET['id'])){
                $_SESSION['message'] = "Vui long chon category can sua";
                header("location: " . BASE_URL . "?role=admin&act=all-category" );
                exit;
            }
            $categoryModel = new CategoryModel();
            $category = $categoryModel->getCategoryByID();

            include 'app/Views/Admin/update-category.php';
        }

        public function updatePostCategory() {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if(!isset($_GET['id'])){
                    $_SESSION['message'] = "Vui long chon category can sua";
                    header("location: " . BASE_URL . "?role=admin&act=all-category" );
                    exit;
                }
                // Đảm bảo xử lý trước khi xuất HTML
                $categoryModel = new CategoryModel();
                $message = $categoryModel->updateCategoryToDB();

                if ($message) {
                    $_SESSION['message'] = "Chinh sua thành công";
                    header("Location: " . BASE_URL . "?role=admin&act=all-category");
                    exit;
                } else {
                    $_SESSION['message'] = "chinh sua không thành công";
                    header("Location: " . BASE_URL . "?role=admin&act=add-category");
                    exit;
                }
            } else {
                header("Location: " . BASE_URL . "?role=admin&act=update-category&id=" . $_GET['id']);
                exit;
            }
        }

        public function showCategory(){
            if(!isset($_GET['id'])){
                $_SESSION['message'] = "Vui long chon category can xem";
                header("location: " . BASE_URL . "?role=admin&act=all-category" );
                exit;
            }
            $categoryModel = new CategoryModel();
            $category = $categoryModel->getCategoryByID();

            include 'app/Views/Admin/show-category.php';
        }
    }
?>