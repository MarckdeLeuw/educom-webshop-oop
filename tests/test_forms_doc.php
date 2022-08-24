<?php

require_once "../views/FormsDoc.php";
// $fields = ["textarea","email"];
/*===================
Fields login
======================*/
$fieldsLogin = array(			   							
	'email' 	=> array(
        'name' => 'email',
        'type' => 'email',
        'label'=> 'Emailadres:',
        'placeholder' => 'Enter your email address',
        'check' => 'authenticateUser:password'
	),
	'password'	=> array(
        'name' => 'password',
        'type' => 'text', 		
        'label'=> 'Password1:',
        'placeholder' => 'Enter your password',
	'check' => ''
	),    												
);
$mydoc = new FormsDoc('test', $fieldsLogin);

/*===============================
fields register
===============================*/
$fieldsRegister = array(
        'Name'	=> array(
                'name' => 'Naam',
                'type' => 'text', 		
                'label'=> 'Name:',
                'placeholder' => 'Enter your name',
                'check' => ''
                ),			   							
                'email' 	=> array(
                'name' => 'email',
                'type' => 'email',
                'label'=> 'Emailadres:',
                'placeholder' => 'Enter your email address',
                'check' => 'authenticateUser:password'
                ),
                'password'	=> array(
                'name' => 'password',
                'type' => 'text', 		
                'label'=> 'Password1:',
                'placeholder' => 'Enter your password',
                'check' => ''
                ),
            'password2'	=> array(
                'name' => 'password2',
                'type' => 'text', 		
                'label'=> 'Password2:',
                'placeholder' => 'Verify your password',
                'check' => ''
            )  														
);
// $mydoc = new FormsDoc('test', $fieldsRegister);

// $mydoc = new FieldInfoOld('test');

// $mydoc = new FieldInfo('firstName','text','Voornaam','Vul hier uw naam in');
// $mydoc = new FieldInfo('email','email','Emailadres:','Vul hier uw mailadres in');
// $mydoc = new FieldInfo('message','textarea','Bericht','Enter your message');

/*===================
Fields contact
======================*/
$fieldsContact = array(	
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
// $mydoc = new FormsDoc('contact', $fieldsContact);
$mydoc->show();

?>