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

    public function __construct(string $title, array $data)
    {
        parent::__construct($title);
        $this->page=$data['page'] ;
        $this->fieldinfo = $data['fields']; 
        $this->submit_caption = $data['submit_caption'];
        if (isset($data['postresult']))
            {
                $this->postresult = $data['postresult'];  //16 $postresult is niet gedeclareerd als class-variabele.         
            }else{
                $this->postresult=[];
            }      
    }
    
//======================================================
// PROTECTED METHOD OVERRIDES
//======================================================
protected function showContent() 
{         
    $this->openForm();
    $this->showFields();
    $this->closeForm();
    // var_dump($this->postresult);
}

protected function openForm($method="POST")
{
	echo '<main><form action="index.php" method="'.$method.'" >'.PHP_EOL
    .'		<input type="hidden" name="page" value="'.$this->page.'" />'.PHP_EOL;
}

protected function closeForm()
{
	echo '		<input  type="submit" value="'.$this->submit_caption.'"></input>'.PHP_EOL
		.'	</form></main>'.PHP_EOL;
}

protected function showFields()
{
    
    foreach($this->postresult as $key=>$postedValue)
    {
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
                    '" value="'.$postResult.'" >
                    </div>';
                break;
            
            case "select":
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
}
}
