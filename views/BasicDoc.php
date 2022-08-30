<?php
/*
Maak in de folder /views een class file BasicDoc aan, 
die overerft van de HtmlDoc en de gemeenschappelijke zaken neerzet zoals header, menu en footer.
*/

require_once "HtmlDoc.php";
class BasicDoc extends HtmlDoc
{
    // private $stylesheet;
    // parent::$title;
//======================================================
// PUBLIC
//======================================================

// public function __construct(string $title)
// {
//     parent::__construct($title);
//     $this->title = $title; // Dit zou toch eigenlijk niet meer hoeven?

//     // $this-> title= parent::$title;      
//     // ML:deze wordt toch van de parent meegekregen, waarom hier weer?
// }
    
//======================================================
// PROTECTED METHOD OVERRIDES
//======================================================

    final protected function showBodyContent() 
    {         
        $this->showMenu(); 
        $this->showContent(); 
        $this->showFooter(); 
        // ML:moet hier idd de $this-> functie aangeroepen worden?
    }   

    protected function showMenu()
    {
        $menuItems = array('home', 'about','contact', 'webshop','detail','cart','register', 'login');
        $menuItemsLogin = array('home', 'about','contact','webshop','cart');        
        echo 
        '<nav class="menu"><ul >';        
        if (isset($_SESSION["userName"]))
        {        
            foreach ($menuItemsLogin as $value)
                {
                echo '<li class="solid"><a href="index.php?page='.$value.'">'.$value.'</a></li>';
                }
                echo '<li class="solid"><a href="index.php?page=logout"> Logout '.$_SESSION["userName"].' </a></li>';         
        }else
        {        
            foreach ($menuItems as $value)
            {
            echo '<li class="solid"><a href="index.php?page='.$value.'">'.$value.'</a></li>';
            }
        }        
        echo '</ul></nav>'; 
    }

    protected function showContent() 
    {         
        echo '<h1>'.$this->title.'</h1>'.PHP_EOL; 
        // echo '<h1>'.parent::title.'</h1>'.PHP_EOL; 
    }
    
    protected function showFooter()
    {
        echo "<footer> <p>&#169; 2022 M.W. de Leuw</p></footer>";
    }  
}