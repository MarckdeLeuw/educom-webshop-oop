<?php
/*
Maak in de folder /tests een test_basic_doc.php file 
die een instantie van de BasicDoc maakt en de show methode aanroept (zie voorbeeld **).
*/
require_once "../views/HomeDoc.php";
$mydoc = new HomeDoc('TEST HOME DOC');
$mydoc->show();

?>