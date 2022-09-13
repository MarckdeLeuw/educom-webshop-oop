<?php
 require_once "./models/base_model.php";
class WebshopModel extends BaseModel
{
    public function addToCart($id)
    {
        if(isset($_SESSION['cart_products'][$id]['number']))
        {
            $numberOfProducts=$_SESSION['cart_products'][$id]['number'];
            $numberOfProducts=$numberOfProducts+1;
            $_SESSION['cart_products'][$id]['number']=$numberOfProducts;

        }
        else
        {
            $_SESSION['cart_products'][$id]['id']=$id;
            $_SESSION['cart_products'][$id]['number']=1;
        }

    }
    
    public function getProductById($valueId)
    {
        $sql = 'SELECT * FROM products WHERE id = ? ';
        $product=$this->crud->getRowByValue($sql,$valueId);
        if($product==null)
        {
            return false;
        }else
        {
            return $product;
        }
    }

    public function getAllProducts()
    {
        $sql = 'SELECT * FROM products';
        $products=$this->crud->getAllRows($sql);
        if($products==null)
        {
            return false;
        }else
        {
            return $products;
        }
    }

}
?>