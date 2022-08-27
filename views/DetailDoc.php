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
        foreach($this->product as $product)
        {
        var_dump($this->product);           
        echo'
            <div class = "product">
                <ul>
                    <li><img src="/opdracht_3.1_opzet/images/'.$product['picture'].'.jpg" style="width:300px;height:300px;"></li>
                    <li>'.$product['name']. '</li>
                    <li>€'.$product['price'].'</li>
                    <li>Vooraad:'.$product['stock'].'</li>
                    <li>Beschrijving:'.$product['details'].'</li>    
                    <li>';
                    /*
                    if(checkSession()){
                        require_once('showForm.php');
                        openForm('detail','');
                        echo '<input type = "hidden" name="id"value ="'.$product['id'].'">';
                        closeForm("Voeg toe aan winkelwagen");                    
                        // echo '<button type="submit" name= "id" value="'.$product['id'].'">Voeg toe aan winkelwagen</button>';
                    }else{
                        echo '<a href="index.php?page=login">Log in om te bestellen</a>';
                    };*/
                    echo '</li>                        
                </ul>     
            </div>';
    
        }
    }
        
}