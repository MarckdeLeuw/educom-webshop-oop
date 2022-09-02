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
    // public function __construct(string $title, array $fieldinfo)

    public function __construct(string $title, array $data)
    {
        parent::__construct($title);
        // $this->fieldinfo = $fieldinfo;
        $this->page=$data['page'] ;
        $this->fieldinfo = $data['fields']; 
        $this->submit_caption = $data['submit_caption'];
        // $this->postresult=$data['postresult'];
        if (isset($data['postresult']))
            {
                $this->postresult = $data['postresult'];  //16 $postresult is niet gedeclareerd als class-variabele.         
            }else{
                $this->postresult=[];
            }      


        
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
    var_dump($this->postresult);
}

protected function openForm($method="POST")
{
    // $submit_caption=$this->submit_caption;
	echo '<main><form action="index.php" method="'.$method.'" >'.PHP_EOL
    .'		<input type="hidden" name="page" value="'.$this->page.'" />'.PHP_EOL;
    // ML: let op value moet nog afhankelijk gemaakt worden van de de pagina, action ook anders?
    // .'		<input type="hidden" name="page" value="'.$page.'" />'.PHP_EOL;
}

protected function closeForm(/*$submit_caption="Verstuur"*/)
{
	echo '		<input  type="submit" value="'.$this->submit_caption.'"></input>'.PHP_EOL
		.'	</form></main>'.PHP_EOL;
}

protected function showFields(){//Geert 18 waarom public
    // echo'<pre>';// Geert 17 pre - tag wil je enkel rond een schermdump voor een variabele, NIET rond je hele input!!
    // print_r($this->fieldinfo);
    // var_dump( $this->fieldinfo['salutation']['options']);
    
    // var_dump( $this->fieldinfo['salutation']['options_func']);
    // var_dump( $this->$fieldinfo);
    
    foreach($this->postresult as $key=>$postedValue)
    {
        // var_dump($post);
        // var_dump($this->postresult);
        echo $key.'='. $postedValue;
        
    };

    foreach ($this->fieldinfo as $fieldname){

        if(isset($this->postresult[$fieldname['name']]))
        {
            $postResult=$this->postresult[$fieldname['name']];
        }
        else
        { 
            if(isset($this->postresult[$fieldname['name'].'_err']))
            {
                $postResult=$this->postresult[$fieldname['name'].'_err'];
            }
        else
        {
            $postResult='';
        }
        }     
            
        switch($fieldname['type'])
        {
            case "text":
                echo
                    '<div>
                    <label for="'.$fieldname['name'].'">'.$fieldname['label'].'</label>
                    <input type="'.$fieldname['type'].'" name="'.$fieldname['name'].'" placeholder="'
                    .$fieldname['placeholder'].
                    // .$this->postresult['fieldname']['name'].
                    '" value="'.$postResult.'" >
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
                <input type="'.$fieldname['type'].'" name="'.$fieldname['name'].'" placeholder="'.$fieldname['placeholder'].
                '" value="'.$postResult.'" >
                </div>';
        break;
        }
    } 
    // echo'</pre>';    
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

