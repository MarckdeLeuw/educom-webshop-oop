<?php
/*
Maak in de folder /tests een test_basic_doc.php file 
die een instantie van de BasicDoc maakt en de show methode aanroept (zie voorbeeld **).
*/
require_once "../views/AboutDoc.php";
$mydoc = new AboutDoc('TEST ABOUT DOC');
$mydoc->show();

?>