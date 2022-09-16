<?php
/*
Maak in de folder /views twee abstracte class files 
FormsDoc en ProductDoc aan, 
die overerfen van de BasicDoc en de functies bevatten die 
de classen die hiervan overerven gemeenschappelijk hebben.
*/

require_once "BasicDoc.php";
class CartDoc extends BasicDoc
{
    protected $fieldinfo;

    public function __construct(string $title, array $data)
    {
        parent::__construct($title);
        $this->data = $data;         
    }
//======================================================
// PROTECTED METHOD OVERRIDES
//======================================================
    protected function showContent() 
    {         
        $this->openTable();
        $this->showProductsCart();
        $this->closeTable();
        $this->total();
        $this->openForm();
        $this->closeForm();       
    }

    protected function openTable()
    {
        echo ' <table>
        <tr>
        <th>id</th>  
        <th>Afbeelding</th> 
        <th>Naam</th> 
        <th>Prijs</th>
        <th>Aantal</th>    
        <th>Subtotaal</th> 
        </tr>';
    }
    
    protected function closeTable()
    {
        echo '</table>'.PHP_EOL;
    }

    protected function total()
    {
        require_once "./models/webshop_model.php";
        $crud = new Crud();
        $webshopModel = new WebshopModel($crud);
        $total= $webshopModel->totalPrice();
        echo 'Totaalprijs is €'.$total;
    }

    protected function openForm($method="POST")
    {
	echo '<main><form action="index.php" method="'.$method.'" >'.PHP_EOL
    .'		<input type="hidden" name="page" value="cart" />'.PHP_EOL;
    }

    protected function closeForm($submit_caption="Afrekenen")
    {
        echo '		<input  type="submit" value="'.$submit_caption.'"></input>'.PHP_EOL
            .'	</form></main>'.PHP_EOL;
    }


    protected function showProductsCart()
    {
        $productsInCart=$this->data['cart_products'];
        foreach ($productsInCart as $productInCart)
        {   
            require_once "./models/webshop_model.php";
            $crud = new Crud();
            $webshopModel = new WebshopModel($crud);
            $product= $webshopModel->getProductById($productInCart['id']);          
        echo'
        <tr>
            <td>'.$productInCart['id'].'</td> 
            <td><img src="./images/'.$product[0]['picture'].'.jpg" style="width:50px;height:50px;"></td>
            <td>'.$product[0]['name'].'</td>
            <td>'.$product[0]['price'].'</td>
            <td>'.$productInCart['number'].'</td> 
            <td>'.$productInCart['number']*$product[0]['price'].'</td>    
        </tr>';       
        }
    }
        
}