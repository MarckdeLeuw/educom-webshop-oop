<?php
/*
Maak in de folder /views twee abstracte class files 
FormsDoc en ProductDoc aan, 
die overerfen van de BasicDoc en de functies bevatten die 
de classen die hiervan overerven gemeenschappelijk hebben.
*/

require_once "BasicDoc.php";

class FormsDoc extends BasicDoc // let op abstract!
{
    protected $fieldinfo;
    public function __construct(string $title, array $fieldinfo)
    {
        parent::__construct($title);
        $this->fieldinfo = $fieldinfo; 
        
        // $this-> title= parent::$title;      
        // ML:deze wordt toch van de parent meegekregen, waarom hier weer?
    }
//======================================================
// PROTECTED METHOD OVERRIDES
//======================================================
protected function showContent() 
{         
    $this->openForm();
    // zie TestAbstract.php wordt later gevuld door children
    // $this->showFields();
    $this->showFields();
    $this->closeForm();
}

protected function openForm($method="POST")
{
	echo '<main><form action="index.php" method="'.$method.'" >'.PHP_EOL
    .'		<input type="hidden" name="page" value="page" />'.PHP_EOL;
    // ML: let op value moet nog afhankelijk gemaakt worden van de de pagina, action ook anders?
    // .'		<input type="hidden" name="page" value="'.$page.'" />'.PHP_EOL;
}

protected function closeForm($submit_caption="Verstuur")
{
	echo '		<input  type="submit" value="'.$submit_caption.'"></input>'.PHP_EOL
		.'	</form></main>'.PHP_EOL;
}

public function showFields(){
    echo'<pre>';
    // print_r($this->fieldinfo);
    // var_dump( $this->fieldinfo['salutation']['options']);
    
    // var_dump( $this->fieldinfo['salutation']['options_func']);
    
    foreach ($this->fieldinfo as $fieldname){
        // var_dump( $fieldname['options']);

        switch($fieldname['type'])
        {
            case "text":
                echo
                    '<div>
                    <label for="'.$fieldname['name'].'">'.$fieldname['label'].'</label>
                    <input type="'.$fieldname['type'].'" name="'.$fieldname['name'].'" placeholder="'.$fieldname['placeholder'].'" value="" >
                    </div>';
                break;
            
            case "select":
                /*foreach($fieldname['options'] as $key=> $value)
                {
                    var_dump($key);
                    var_dump($value);
                }*/
                echo
                    '<div>
                    <label for="'.$fieldname['name'].'">'.$fieldname['label'].'</label>'.PHP_EOL;
                    echo'<select name ="'.$fieldname['name'].'">';

                foreach($fieldname['options'] as $key=> $value)
                {
                echo                        
                    '<option value="'.$value.'">'.$key.'</option>'.PHP_EOL;
                }  
                echo 
                    '</select>
                    </div>';
                break;
            
            default:
                echo
                '<div>
                <label for="'.$fieldname['name'].'">'.$fieldname['label'].'</label>
                <input type="'.$fieldname['type'].'" name="'.$fieldname['name'].'" placeholder="'.$fieldname['placeholder'].'" value="" >
                </div>';
        break;
        }
    } 
    echo'</pre>';    
}
}

/* =================================================================================
Onderstaand wordt niet meer gebruikt nu
====================================================================================*/


// $fieldInfo = array($textarea,$email, $radio,$input,$checkbox, etc)
// In bv een array wordt aangegeven welke waarde in het formulier moeten komen.


// class FieldInfoOld extends FormsDoc {
//     public function showFields() {
//         // Hier moet je de $title meegevevn.
//         echo 
//         '<div>
//             <label for="email">Emailadres:</label>
//             <input type="email" name="email" placeholder="Enter your email address" value="" >
//         </div>
//         <div>
//             <label for="password">Password1:</label>
//             <input type="text" name="password" placeholder="Enter your password" value="" >
//         </div>';
//     }
// }

// // interface Field{
// //     public function(){
// //     echo
// //         '<div>
// //             <label for="'.$this->type.'">'.$this->$fieldName.'</label>
// //             <input type="email" name="email" placeholder="Enter your email address" value="" >
// //         </div>';
// //     }

// // }

// class FieldInfo extends FormsDoc{
    
//     // parent::__construct($title);
//     // Moet hier ook de $title niet aangeroepen worden
//     private $fieldName;
//     private $type;
//     private $label;
//     private $placeholder;

//     public function __construct(
//                                 string $fieldName,
//                                 string $type, 
//                                 string $label, 
//                                 string $placeholder) 
//     {
//         $this->fieldName=$fieldName;
//         $this->type = $type;
//         $this->label = $label;
//         $this->placeholder=$placeholder;
//     }   
//     public function showFields() {
//         echo
//         '<div>
//             <label for="'.$this->fieldName.'">'.$this->label.'</label>
//             <input type="'.$this->type.'" name="'.$this->fieldName.'" placeholder="'.$this->placeholder.'" value="" >
//         </div>';
//     }
// }

// // op basis van onderstaande array kan een object gecreeerd worden, 
// // die bovenstaande class kan kaan aanvullen

