<?php

function getRegisterFields(): array
{
return array(			   							
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
}
?>