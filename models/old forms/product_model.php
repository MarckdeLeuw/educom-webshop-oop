<?php
 require_once "./models/base_model.php";
class ProductModel extends BaseModel
{
    public function getProductById($valueId)
    {
        $sql = 'SELECT * FROM products WHERE id  = (:id) ';
        $parameter=array(':id'=>$valueId);   
        $product=$this->crud->getRowByValue($sql,$parameter);
        if($product==null)
        {
            return false;
        }else
        {
            return $product;
        }
    }
/* 
        //Zie ook  getRowByValueOld($sql,$value)
        
        public function getProductByIdOld($valueId)
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
*/
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