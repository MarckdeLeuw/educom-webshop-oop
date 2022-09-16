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
    // ==========================
    // input uit sessie is product(id en aantal)
    // per id worden de aanvullende gegevens van de producten uit de database gehaald
    // totaal wordt berekend
    // ======================================

    public function __construct(string $title, array $data)
    {
        parent::__construct($title);
        $this->data = $data; 
        
        // $this-> title= parent::$title;      
        // ML:deze wordt toch van de parent meegekregen, waarom hier weer?
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
       
        // var_dump($this->data);
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
        // var_dump($total);
        echo 'Totaalprijs is €'.$total;
    }

    protected function openForm($method="POST")
    {
    // $submit_caption=$this->submit_caption;
	echo '<main><form action="index.php" method="'.$method.'" >'.PHP_EOL
    .'		<input type="hidden" name="page" value="cart" />'.PHP_EOL;
    // ML: let op value moet nog afhankelijk gemaakt worden van de de pagina, action ook anders?
    // .'		<input type="hidden" name="page" value="'.$page.'" />'.PHP_EOL;
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
            // echo'id='.$productInCart['id'].'<br>';
            // echo'number='.$productInCart['number'].'<br>';
            // var_dump($product[0]['details']);       
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