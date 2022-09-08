<?php
/*
Maak in de folder /views twee abstracte class files 
FormsDoc en ProductDoc aan, 
die overerfen van de BasicDoc en de functies bevatten die 
de classen die hiervan overerven gemeenschappelijk hebben.
*/

require_once "BasicDoc.php";
class ProductDoc extends BasicDoc
{
    protected $fieldinfo;
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
        $this->openProducts();
        $this->showProducts();
        $this->closeProducts();
    }

    protected function openProducts()
    {
        echo'<div class="products">'.PHP_EOL; 
    }

    protected function closeProducts()
    {
        echo '</div>'.PHP_EOL;
    }

    protected function showProducts()
    {
        // var_dump($this->products);
        foreach ($this->products as $product)
        {        
        echo'
            <div class = "product">
                <ul>
                    <a href="index.php?page=detail&id='
                    .$product['id']
                    .'">
                    <li><img src="/opdracht_3.1_opzet/images/'.$product['picture'].'.jpg" style="width:300px;height:300px;"></li>
                    <li>'.$product['name']. '</li>
                    <li>€'.$product['price'].'</li>
                    <li>Vooraad:'.$product['stock'].'</li>
                    </a>
                    <li>';
                    if(isset($_SESSION["userName"]))
                    {
                        echo '<button type="hidden" name= "id"value="'.$product['id'].'">Klik voor details</button>';
                    }
                    else
                    {
                        echo '<a href="index.php?page=login">Log in om te bestellen</a>';
                    };
            echo '  </li>                                      
                </ul>     
            </div>';
        }
    }
    
}