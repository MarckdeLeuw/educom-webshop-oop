<?php
function getContactFields():array
{
return array
(	
'salutation' 	=> array(
        'name' => 'salutation',
        'type' => 'select',
        'label'=> 'Aanhef',
        'options' => array(
                        'Dhr'=>'mister',
                        'Mvr'=>'miss',
                        'nvt'=>'gender_neutral'
                        ),
        'check' => ''
        ),
'firstName'	=> array(
        'name' => 'firstName',
        'type' => 'text', 		
        'label'=> 'Voornaam:',
        'placeholder' => 'Enter your first name',
        'check' => ''
        ),
'lastName'	=> array(
        'name' => 'lastName',
        'type' => 'text', 		
        'label'=> 'Achternaam:',
        'placeholder' => 'Enter your last name',
        'check' => ''
        ),   		   							
'email' 	=> array(
        'name' => 'email',
        'type' => 'email',
        'label'=> 'Emailadres:',
        'placeholder' => 'Enter your email address',
        'check' => 'authenticateUser:password'
        ),
'phoneNr'	=> array(
        'name' => 'phoneNr',
        'type' => 'text', 		
        'label'=> 'Telefoonnnummer',
        'placeholder' => 'Enter your phone nr',
        'check' => ''
        ), 
'comPref'	=> array(
        'name' => 'comPref',
        'type' => 'select', 		
        'label'=> 'Communicatievoorkeur',
        'options' => array(
                        'Email'=> 'email',
                        'Telefoonnummer'=> 'tel'
                        ),
        'check' => ''
        ), 
'message'	=> array(
        'name' => 'message',
        'type' => 'textarea', 		
        'label'=> 'Bericht',
        'placeholder' => 'Enter your message',
        'check' => ''
        ),     			   												
);
}

?>