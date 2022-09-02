<?php
class PageInfo
{
    public function getData(string $page)//op basis van pagina wordt array gegenereerd     
    {
        $data =[];
        switch($page)
        {
        case 'home':
        $data = array
            (
                'page' => 'home',
                'title' => 'home'
            );
        case 'about':
        $data = array
            (
                'page' => 'about',
                'title' => 'about'
            );
        case 'contact':
        $data['page']= 'contact';
        $data['submit_caption']= 'Versturen';       
        $data['fields']=array
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
                        )                     
            );
            break;
            case 'register':
                $data['page']='register';
                $data['submit_caption']= 'Registreer'; 
                $data['fields']=array
            (
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
            break;
            case 'login':
                $data['page']='login';
                $data['submit_caption']= 'Login'; 
                $data['fields']=array
            (
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
            break;
            default:
                echo 'No process request';              
        }
    return $data;
    }
}
?>