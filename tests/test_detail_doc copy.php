<?php

require_once "../views/DetailDoc.php";
$product = array
    (			   							
    'unicorn' 	=> array
    (
        'id' => '1',
        'name' => 'unicorn',
        'price'=> '49.99',
        'stock' => '100',
        'picture' => 'unicorn',
        'details' => 'Mooie tekening van eenhoorn met regenboog'
	),
    // 'draak' 	=> array
    // (
    //     'id' => '2',
    //     'name' => 'draa',
    //     'price'=> '29.99',
    //     'stock' => '200',
    //     'picture' => 'draak',
    //     'details' => 'Prachtige tekening van een draak'
	// ),
    // 'family' 	=> array
    // (
    //     'id' => '3',
    //     'name' => 'family',
    //     'price'=> '39.99',
    //     'stock' => '56',
    //     'picture' => 'family',
    //     'details' => 'Schitterende tekening van de family'
	// ),													
    );
$mydoc = new DetailDoc('TEST',$product);
$mydoc->show();
?>