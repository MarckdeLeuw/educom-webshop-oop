<?php
 require_once "./models/base_model.php";
class WebshopModel extends BaseModel
{
    // public function __construct(array $data)
    // { 
    //     $this->data = $data; 
    // }
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

    public function totalPrice()
    {
        if(isset($_SESSION['cart_products']))
        {
            // var_dump($_SESSION);
            $totalPrice = 0;
            $productsInCart=$_SESSION['cart_products'];
            foreach ($productsInCart as $productInCart)
            {
                $product=$this->getProductById($productInCart['id']);
                
                // echo'id='.$productInCart['id'].'<br>';
                // echo'number='.$productInCart['number'].'<br>';
                // echo'price='.$product[0]['price'].'<br>';
                
                $subTotal = $productInCart['number']*$product[0]['price'];
                $totalPrice += $subTotal;
            }
            return $totalPrice;
        }
        else
        {
            return false;
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

    public function createOrderNr()
    {
        $sql = "SELECT max(id) FROM orders";
        $id=$this->crud->getAllRows($sql);
        if($id==null)
        {
            $id = 1;
        }else
        {
            $id=($id[0]['max(id)']);
            $id=$id+1;
        }
        return $id;
    }

    public function writeToOrders() 
    {
        $orderNumber = $this->createOrderNr();
        $userId = $_SESSION["userid"];
        
        $sql = 'INSERT INTO orders(id, user_id) VALUES (:id,:user_id) ';
        $parameter=array(':id'=>$orderNumber,':user_id'=>$userId);   
        $result=$this->crud->createRow($sql,$parameter);
        return $orderNumber;                       
    }
  
    public function createOrderDetails($data)
    {        
        $productsInCart=$data['cart_products'];
        foreach ($productsInCart as $productInCart)
        {   
            // echo 'ordernumber =' .$data['orderNumber'].'<br>';
            // echo'id='.$productInCart['id'].'<br>';
            // echo'number='.$productInCart['number'].'<br>';

            $sql = 'INSERT INTO order_details(order_id, product_id, amount) VALUES (:order_id,:product_id, :amount) ';
            $parameter=array(':order_id'=>$data['orderNumber'],':product_id'=>$productInCart['id'],':amount'=>$productInCart['number']);   
            $result=$this->crud->createRow($sql,$parameter);
        }         
    }

    public function updateProductInventory($data)
    {
        $productsInCart=$data['cart_products'];
        foreach ($productsInCart as $productInCart)
        {   
            $productInventory=$this->getProductById($productInCart['id']);
            // echo'id='.$productInCart['id'].'<br>';
            // echo'number in cart='.$productInCart['number'].'<br>';
            // echo'number in shop='.$productInventory[0]['stock'].'<br>';
        
            if($productInventory[0]['stock'] > $productInCart['number'])
            {
                $productStock = $productInventory[0]['stock'] - $productInCart['number'];
                // echo'nieuw number in shop='.$productStock.'<br>';
                $sql = 'UPDATE products SET stock = (:stock) WHERE id = (:id) ';
                $parameter=array(':stock'=>$productStock,':id'=>$productInCart['id']);   
                $result=$this->crud->updateRow($sql,$parameter);
    
            }else
            {
                echo 'Voorraad is niet voldoende';
            }
        }     
    }
    
}
?>