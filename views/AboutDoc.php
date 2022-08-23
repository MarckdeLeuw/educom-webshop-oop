<?php
/*
Maak nu een HomeDoc, de AboutDoc class aan 
die beide overerven van BasicDoc. 
Maak hier ook voor iedere class een test php bestand aan.
*/
require_once "BasicDoc.php";
class AboutDoc extends BasicDoc
{
//======================================================
// PROTECTED METHOD OVERRIDES
//======================================================
protected function showContent() 
    {         
        $this->showAboutHeader();
        $this->showAboutContent();
    }
protected function showAboutHeader()
    {
    echo'<header><H1>INTRODUCTIE</H1></header>';
    }
    
protected function showAboutContent()
    {
    echo'
    <main>
        <p>
        Ik ben Marck de Leuw. In 1980 geboren in Amsterdam.
        Na het volgen van de studie civiele techniek heb ik 15 jaar als constructeur gewerkt.
        </p>
        <p>
        3 jaar geleden ben ik met mijn vrouw naar het oosten van het land verhuisd om daar 
        een nieuw bestaan op te bouwen.
        </p>
        <p>
        Eind vorig jaar heb ik een bootcamp webdevelopment gevolgd en ik begin nu met een nieuwe opleiding om programmeur te worden.
        </p>
    
        <p>Mijn hobbies zijn:</p>
        <ul>
            <li>Programmeren</li>
            <li>Mediteren</li>
            <li>Lezen</li>
            <li>Koken</li>
            <li>Sporten</li>
        </ul>
    </main>
    ';   
    }
}