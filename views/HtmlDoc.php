<?php
/*
Maak in de folder /views een class file HtmlDoc aan, 
die een kale HTML pagina kan genereren, 
met maar 1 publieke methode show() die alleen maar private en protected methoden aanroept.

Zie ook
https://cursus.man-kind.nl/PAGE/EXPLAIN/OOP_INTRO
*/

class HtmlDoc
{
    
    protected $title;
    // private $author;
    // private $stylesheet;
    
//======================================================
// PUBLIC
// kan in child class worden overschreven
//======================================================
    
    public function __construct(string $title/*, string $author*/)
    {
        $this->title = $title;
        // $this->author = $author;
    }
    
    // final ervoor, kan je later niet meer overschrijven

    public function show()
    {
        $this->beginDoc();
        $this->beginHead();
        $this->showHeadContent();
        $this->endHead();
        $this->beginBody();
        $this->showBodyContent();
        $this->endBody();
        $this->endDoc();
    }    
//======================================================
// PROTECTED
// kan in child class worden overschreven
//======================================================
    protected function beginDoc() 
    { 
        echo '<!DOCTYPE html>'.PHP_EOL.'<html>'; 
    }

    protected function showHeadContent() 
    { 
        if ($this->title) 
            echo '<title>'.$this->title.'</title>'.PHP_EOL; 
        // if ($this->author) 
        //     echo '<meta name="author" content="'.$this->author.'" />'.PHP_EOL;
        // if ($this->stylesheet) 
            echo '<link href="../css/styles.css" rel="stylesheet">'.PHP_EOL; 
    }
    
    protected function showBodyContent() 
    { 
        if ($this->title) 
            // echo '<title>'.$this->title.'</title>'.PHP_EOL; 
            echo '<h1>'.$this->title.'</h1>'.PHP_EOL; 
    }
//======================================================
// PRIVATE
// kan NIET in child class worden overschreven!
//======================================================
    private function beginHead() 
    { 
        echo '<head>'.PHP_EOL; 
    }

    private function endHead()
    { 
        echo '</head>'.PHP_EOL; 
    }
    
    private function beginBody() 
    { 
        echo '<body>'.PHP_EOL; 
    }

    private function endBody() 
    { 
        echo '</body>'.PHP_EOL; 
    }
    
    private function endDoc() 
    { 
        echo '</html>'.PHP_EOL; 
    }
}

