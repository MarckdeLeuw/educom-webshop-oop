<?php

function getLoginFields(): array
{
return array(			   							
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
}
?>