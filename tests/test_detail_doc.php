<?php

require_once "../views/DetailDoc.php";
require_once "../models/products_info.php";
$productModel = new ProductsModel();
$productsModel = $productModel->getProducts();
// var_dump($productsModel);
$id=1;
// var_dump($productsModel[$id]);

/*
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
    */
$mydoc = new DetailDoc('TEST',$productsModel[$id]);
$mydoc->show();
?>