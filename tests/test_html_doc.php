<?php
/*
Maak in de folder /tests een test_html_doc.php file 
die een instantie van de HtmlDoc maakt 
en deze show() methode aanroept.
*/

require_once "../views/HtmlDoc.php";
$mydoc = new HtmlDoc('TEST HtmlDoc');
$mydoc->show();