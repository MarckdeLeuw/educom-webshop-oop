<?php
require_once "./models/crud.php";
// ipv extends gebruiken we data injectie
// anders wordt elke keer een andere connectie gemaakt.

class BaseModel
{
    protected $crud;

    public function __construct(Crud $crud)//vergelijkbaar met string 
    {
        $this->crud=$crud;        
    }
}

?>