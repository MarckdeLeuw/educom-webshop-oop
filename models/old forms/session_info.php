<?php
/*
userId          =1
userName        =Marck    
cart_products   =
        array   id      1
                nr      4
        array   id      2        
                nr      1

*/
class SessionModel
{
    public function getProducts() : array
    {
    return	array(		   							
    1 	=> array
    (
        'id' => 1,
        'name' => 'unicorn',
        'price'=> '49.99',
        'stock' => '100',
        'picture' => 'unicorn',
        'details' => 'Mooie tekening van eenhoorn met regenboog'
    ),
    2 	=> array
    (
        'id' => 2,
        'name' => 'draak',
        'price'=> '29.99',
        'stock' => '200',
        'picture' => 'draak',
        'details' => 'Prachtige tekening van een draak'
    ),
    3 	=> array
    (
        'id' => 3,
        'name' => 'family',
        'price'=> '39.99',
        'stock' => '56',
        'picture' => 'family',
        'details' => 'Schitterende tekening van de family'
    ),													
    );
    }
}
?>