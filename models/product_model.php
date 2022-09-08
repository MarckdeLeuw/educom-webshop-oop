<?php
 require_once "./models/base_model.php";
class ProductModel extends BaseModel
{
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


// ======================================================================================
        //Dit is met prepared statement
    public function addUser($name,$email,$wachtwoord)
    {
        $sql = 'INSERT INTO users(naam, email, wachtwoord) VALUES (:naam,:email,:wachtwoord) ';
        $parameter=array(':naam'=>$name,':email'=>$email,':wachtwoord'=>$wachtwoord);   
        $result=$this->crud->createRow($sql,$parameter);//aanpassen                      
        var_dump($result);
    }
}
?>