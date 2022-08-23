<?php
/*
Maak nu een HomeDoc, de AboutDoc class aan 
die beide overerven van BasicDoc. 
Maak hier ook voor iedere class een test php bestand aan.
*/
require_once "BasicDoc.php";
class HomeDoc extends BasicDoc
{
    //======================================================
// PROTECTED METHOD OVERRIDES
//======================================================
protected function showContent() 
    {         
        $this->showHomeHeader();
        $this->showHomeContent();
    }
protected function showHomeHeader()
    {
    echo'<header><H1>INTRO</H1></header>';
    }
    
protected function showHomeContent()
    {
    echo'
    <main>
    <h2>Welkom! Dit is de eerste oefening van mijn Educom opleiding!</h2>
    </main>';    
    }

}