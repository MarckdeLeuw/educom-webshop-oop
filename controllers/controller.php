<?php 
class Controller
//Zie https://cursus.man-kind.nl/PAGE/EXPLAIN/OOP_INTRO
{
    private $request;
    private $response;

    public function handleRequest()
    {
        session_start();
        $this-> getRequest();
        $this-> validateRequest();
        $this->showResponsePage();

    }
    /*======================================
    ML:
    Bij een post, wordt posted true
    als posted false of null is, wordt de default waarde gegeven voor de page(home)
    als posted true is wordt de invoer gefilterd en de waarde wordt als resultaat meegegven aan de page(gepost)
    =========================================*/
    private function getRequest()
    {
        $posted = ($_SERVER['REQUEST_METHOD']==='POST');//start pagina niet posted dus false
        $this->request = 
            [
                'posted' => $posted,
                'page'     => $this->getRequestVar('page', $posted, 'home')//home is default waarde voor page    
            ];
    }

    function getRequestVar(string $key, bool $frompost, $default="", bool $asnumber=FALSE)
    {
        $filter = $asnumber ? FILTER_SANITIZE_NUMBER_FLOAT : FILTER_DEFAULT/*FILTER_SANITIZE_STRING*/; //hier wordt een functie aangeroepen die je niet meer mag gebruiken?
        $result = filter_input(($frompost ? INPUT_POST : INPUT_GET), $key, $filter);
        // (if $frompost is true, then input_post else input_get) input type die gechecked wordt
        // variabele die gechecked wordt, in dit geval de page
        // filter die toegepast wordt.
        // uitkomsten zijn de waarde bij succes, false on failure, en null als niet gezet        
        if ($result===NULL)
        {
            return $default;
        }else
        {
            if ($result===FALSE)
            {
                return $default;
            }else
            {
                return $result;
            }
        }
    }   
    
    function validateRequest()
    {
        $this->response = $this->request; // getoond == gevraagd
        if ($this->request['posted'])//ML:Validatie wordt dus alleen na post gedaan.
        {
        require_once "./models/page_info.php";
        require_once "./models/validate_model.php";
        $dataByPage = new PageInfo();
        $this->response['data']=$dataByPage->getData($this->response['page']);
        /*
        ML:Bij elke pagina worden de te valideren velden in de $data gezet        
        als er fields (van een formulier) op een pagina zijn aangemaakt, wordt de formulier validatie aangesproken
        Deze geeft aan of een formulier leeg is, het een geldig adres is en  meerdere validaties
        Bij correct invullen van de velden:
        $this->response['data']['postresult']['ok']==true
        met de geposte waarden in [postresult]
        of de incorrect waarden krijgen:
        [postresult][..._error]
        Als alle velden correct zijn ingvuld, kan de volgende validatie stap (inhoudelijk) worden gedaan 
        Zie:    
        */
        if(isset($this->response['data']['fields']))//Geert14 zie opmerking Geert alleen bij POST
        {
            $validateForm = new ValidateForm();
            $this->response['data']['postresult'] = $validateForm->checkFields($this->response['data']['fields']);
        }
        switch($this->request['page'])
        {
            case 'contact':
                if( $this->response['data']['postresult']['ok']==true)
                {
                    echo 'Bedankt voor het invullen';
                }
                break;

            case 'register':
                $name=$this->response['data']['postresult']['name'];                
                $email=$this->response['data']['postresult']['email'];
                $password=$this->response['data']['postresult']['password'];
                $password2=$this->response['data']['postresult']['password2'];

                if(($this->response['data']['postresult']['ok']))
                { 
                    require_once "./models/crud.php";
                    require_once "./models/user_model.php";
                    $crud= new Crud();
                    $userModel = new UserModel($crud);
                    if($userModel->findUserByEmail($email) == false)//Niet gevonden in DB dus vrij om te gebruiken
                    {
                        if($userModel->checkRegisterPasswords($password,$password2) == false)
                        {
                        $this->response['data']['postresult']['password_err'] = 'De door u ingevulde passwords komen niet overeen'.PHP_EOL;
                        }else
                        {
                            $userModel->addUser($name,$email,$password);
                            header('location://localhost/educom-webshop-oop/index.php?page=login');
                        }
                    }
                    else
                    {
                        $this->response['data']['postresult']['email_err'] = 'Uw emailadres is al geregistreerd. Log <a href="index.php?page=login"> hier </a> in'.PHP_EOL;
                    }
                }
                break;

            case 'login':
                $email=$this->response['data']['postresult']['email'];
                $password=$this->response['data']['postresult']['password'];
              
                if(($this->response['data']['postresult']['ok']))
                {
                    require_once "./models/crud.php";
                    require_once "./models/user_model.php";
                    $crud= new Crud();
                    $userModel = new UserModel($crud);
                    $user=$userModel->findUserByEmail($email);//geeft row uit database of false
                    if ($user==false)
                    {
                        $this->response['data']['postresult']['email_err'] = ' Email niet bekend.';
                    }
                    else
                    {
                        $authenticate=$userModel->authenticateUser($user,$password);//geeft true of false
                        if($authenticate==false)
                        {
                            $this->response['data']['postresult']['password_err'] = 'Voer het juiste wachtwoord in.';
                        }
                        else
                        {
                            $_SESSION['userName'] = $user[0]['naam'];
                            $_SESSION['userid'] =  $user[0]['id']; 
                            $this->response['page'] = 'home';                    
                        }            
                    }
                }
            break;

            case 'cart':
                if(isset($_POST['id']))//wort meegeven bij webshop bij post
                {
                    $id=$_POST['id'];
                    require_once "./models/webshop_model.php";
                    $crud = new Crud();
                    $webshopModel = new WebshopModel($crud);
                    $webshopModel->addToCart($id);
/*
TO DO
in het WebshopModel->addToCart moet nog een validatie worden meegegeven 
die controleert of het aantal items in de cart het aantal in de db niet overschrijdt
*/
                }
                else
                {
                    if(isset($_SESSION['cart_products']))//wordt meegegeven bij cart bij post
                    {
                        require_once "./models/webshop_model.php";
                        $crud = new Crud();
                        $webshopModel = new WebshopModel($crud);
                                                
                        $_SESSION['orderNumber']=$webshopModel->writeToOrders();
                        $webshopModel->createOrderDetails($_SESSION);
                        $webshopModel->updateProductInventory($_SESSION);
                        $_SESSION['cart_products'] = NULL;
                        $this->response['page'] = 'home';
                    }
                }
            break;
        }

        if ($this->request['posted'])
        {
            switch ($this->request['page'])
            {
            // post request afhandelingen die meerdere antwoorden kunnen genereren....
            // zie uitleg Request-Response overview
            }
        }    
        }
    }
    
    function showResponsePage() 
    {
        $page=$this->response['page'];
        switch ($page)        
        {
            case 'home':
                require_once "./views/HomeDoc.php";
                $home = new HomeDoc($page);
                $home->show();
            break;
            case 'about':
                require_once "./views/AboutDoc.php";
                $about = new AboutDoc($page);
                $about->show();
            break;
            // ==================================================
            // Contact, register en login kunnen worden samengevoegd, net zoals in eerdere opgave.
            case 'contact':
            case 'register':
            case 'login':
                require_once "./views/FormsDoc.php";
                require_once "./models/page_info.php";

                if (isset($this->response['data']['postresult']))
                {
                    $form = new FormsDoc($page,$this->response['data']);
                    $form->show(); 
                }
                else
                {
                    $dataPage = new PageInfo();           
                    $dataForm=$dataPage->getData($page);//geeft array
                    $form = new FormsDoc($page,$dataForm);
                    $form->show();
                }
            break;
            case 'logout':
                session_destroy();
                $_SESSION['userName'] = NULL;
                if($_SESSION['userName']==NULL)
                header('location://localhost/educom-webshop-oop/index.php?page=home');

            case 'webshop':
                require_once "./views/ProductDoc.php";
                require_once "./models/crud.php";
                require_once "./models/webshop_model.php";//staan zelfde functies als webshop
                $crud= new Crud();
                $webshopModel = new WebshopModel($crud);
                $products=$webshopModel->getAllProducts();
                $showProducts = new ProductDoc($page,$products);
                $showProducts->show();
            break;

            case 'detail':

                $this->response['data']['page'] = 'detail';
                if (isset ($this->response['data']['id']) )
                {
                }
                else
                {
                    $id=$_GET['id'];
                    $this->response['data']['id']=$id; 
                }
                require_once "./views/DetailDoc.php"; 
                require_once "./models/crud.php";
                require_once "./models/webshop_model.php";//staan zelfde functies als webshop
                
                $crud= new Crud();
                $webshopModel = new WebshopModel($crud);
                $product=$webshopModel->getProductById($this->response['data']['id']);

                $showProduct = new DetailDoc($page,$product[0]);
                $showProduct->show();
            break;

            case 'cart':
                
                if(isset($_SESSION['cart_products']))
                {
                    $data = $_SESSION;
                    require_once "./views/CartDoc.php";
                    $products = new CartDoc($page,$data);
                    $products->show();  
                }
                else
                {
                    echo 'Nog geen items toegevoegd';
                }               
            break;
            default:
            // echo 'No process request';            
        }
    }
}
?>