<?php
class DashboardController {
    public function dashboard(){
        $categoryModel = new CategoryUserModel();
        $listCategory = $categoryModel->getCategoryDashboard();

        $productModel = new ProductUserModel();
        $listProduct = $productModel->getProductDashboard();
        include 'app/Views/Users/index.php';
    }
    public function showShop(){
        $productModel = new ProductUserModel();
        $listProduct = $productModel->getDataShop();
        $categoryModel = new CategoryUserModel();
        if (isset($_GET['category_id'])){
            $category =  $categoryModel->getCategoryById($_GET['category_id']);
        }
        $listCategory = $categoryModel->getCategoryDashboard();
        $stock = $productModel->getProductStock();
        if(isset($_GET['instock'])){
            $listProduct = array_filter($listProduct,function($product){
                return $product->stock > 0;
            });
        }
        if(isset($_GET['outstock'])){
            $listProduct = array_filter($listProduct,function($product){
                return $product->stock == 0;
            });  
        }
        if(isset($_GET['min'])){
            $listProduct = array_filter($listProduct, function($product){
                if($product->price_sale !=null){
                    return $product->price_sale > $_GET['min'];
                }
                return $product->price > $_GET['min'];
            });
        }
        if(isset($_GET['max'])){
            $listProduct = array_filter($listProduct, function($product){
                if($product->price_sale !=null){
                    return $product->price_sale < $_GET['max'];
                }
                return $product->price < $_GET['max'];
            });
        }
        if(isset($_GET['product-name'])){
            $listProduct = $productModel->getDataShopName();
        }
        include 'app/Views/Users/shop.php';
    }
    public function productDetail(){
        $productModel = new ProductUserModel();
        $product = $productModel->getProductById();
        $productImage = $productModel->getProductImageById(); 
        include 'app/Views/Users/product-detail.php';
    }
}