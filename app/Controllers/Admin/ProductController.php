<?php
class ProductController{
    public function showAllProduct(){
        $productModel = new ProductModel();
        $listProduct = $productModel->getAllProduct();

        include 'app/Views/Admin/products.php';
    }

    public function addProduct(){
        include 'app/Views/Admin/add-product.php';
    }
}