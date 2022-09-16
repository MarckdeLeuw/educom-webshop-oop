<?php
/*
Maak in de folder /views twee abstracte class files 
FormsDoc en ProductDoc aan, 
die overerfen van de BasicDoc en de functies bevatten die 
de classen die hiervan overerven gemeenschappelijk hebben.
*/

require_once "BasicDoc.php";
class DetailDoc extends BasicDoc
{
    protected $fieldinfo;
    public function __construct(string $title, array $product)
    {
        parent::__construct($title);
        $this->product = $product;         
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
        $product = $this->product;        
        echo'
            <div class = "product">
                <ul>
                    <li><img src="./images/'.$product['picture'].'.jpg" style="width:300px;height:300px;"></li>
                    <li>'.$product['name']. '</li>
                    <li>€'.$product['price'].'</li>
                    <li>Vooraad:'.$product['stock'].'</li>
                    <li>Beschrijving:'.$product['details'].'</li>    
                    <li>';                    
                    if(isset($_SESSION["userName"]))
                    {
                    echo '                                        
                    <form action="index.php" method="POST" > 
                    <input type="hidden" name="page" value="cart" />
                    <input type="hidden" name="id" value="'.$product['id'].'">
                    <br><button type="submit" value="submit">Voeg toe aan winkelwagen</button><br>
                    </form>'.PHP_EOL;                      
                }
                    else
                    {
                        echo '<a href="index.php?page=login">Log in om te bestellen</a>';
                    };
                    echo '</li>                        
                </ul>     
            </div>';  
    }
}