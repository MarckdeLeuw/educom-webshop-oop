<?php
/*
Maak in de folder /tests een test_basic_doc.php file 
die een instantie van de BasicDoc maakt en de show methode aanroept (zie voorbeeld **).
*/
require_once "../views/BasicDoc.php";
$mydoc = new BasicDoc('TEST BASISI DOC');
$mydoc->show();

?>