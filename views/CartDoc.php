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

    public function __construct(string $title, array $products)
    {
        parent::__construct($title);
        $this->products = $products; 
        
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
        echo 'Totaalprijs is €'/*.totalPrice()*/;
    }

    protected function openForm($method="POST")
    {
    // $submit_caption=$this->submit_caption;
	echo '<main><form action="index.php" method="'.$method.'" >'.PHP_EOL
    .'		<input type="hidden" name="page" value="page" />'.PHP_EOL;
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
        // foreach($this->products as $product)
        {
        // var_dump($this->products);           
        echo'
        <tr>
            <td>id uit session</td> 
            <td>afbeelding ahv id product</td>
            <td>name ahv id product</td>
            <td>prijs ahv id product</td>
            <td>aantal uit session</td> 
            <td>prijs*aantal producten</td>    
        </tr>';       
        }
    }
        
}