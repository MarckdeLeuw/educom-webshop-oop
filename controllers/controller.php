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
        // print_r($this->request);
        
        // var_dump($this->request);
        $this-> validateRequest();
        // print_r($this->response);
        $this->showResponsePage();//geen $data?

    }
    
    private function getRequest()
    {
        $posted = ($_SERVER['REQUEST_METHOD']==='POST');//start pagina niet posted dus false
        // var_dump($posted);
        $this->request = 
            [
                'posted' => $posted,
                'page'     => $this->getRequestVar('page', $posted, 'home')//hier zet je default    
            ];
        // var_dump($this->request);
    }

    function getRequestVar(string $key, bool $frompost, $default="", bool $asnumber=FALSE)
    {
        // var_dump($key);//'page'
        // var_dump($frompost);//'false'
        // var_dump($default);//'home'
        // var_dump(INPUT_GET);
        $filter = $asnumber ? FILTER_SANITIZE_NUMBER_FLOAT : FILTER_DEFAULT/*FILTER_SANITIZE_STRING*/; //hier wordt een functie aangeroepen die je niet meer mag gebruiken?
        // $filter = FILTER_DEFAULT;
        $result = filter_input(($frompost ? INPUT_POST : INPUT_GET), $key, $filter);
        // (if $frompost is true, then input_post else input_get) input type die gechecked wordt
        // variabele die gechecked wordt, in dit geval de page
        // filter die toegepast wordt.
        // uitkomsten zijn de waarde bij succes, false on failure, en null als niet gezet
        
        // var_dump($result);// NULL
        // var_dump($filter);

        // return ($result===NULL) ? $default : $result; 
// ML test uitbreiden
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
        // return ($result===FALSE) ? $default : $result;      
        // ML moet false niet null zijn??       
        // in dit geval is $result null dus niet false en geeft hij de result terug? je verwacht een pagina?
    }   
    
    function validateRequest()
    {
        $this->response = $this->request; // getoond == gevraagd
        // var_dump($this->request);
        // posted=true
        // page = page
        if ($this->request['posted'])
        {
        require_once "./models/page_info.php";
        require_once "./models/validate_model.php";
        // var_dump($this->request['page']);
        $dataByPage = new PageInfo();
        $this->response['data']=$dataByPage->getData($this->response['page']);
        // var_dump($this->response['data']);
        if(isset($this->response['data']['fields']))//Geert14 zie opmerking Geert alleen bij POST
        {
            // $fields=$this->response['data']['fields'];
            // echo' data fields zijn gezet';
            $validateForm = new ValidateForm();
            $this->response['data']['postresult'] = $validateForm->checkFields($this->response['data']['fields']);
            // var_dump($this->response['data']['postresult']);   
            // var_dump($this->response);    
        }
        switch($this->request['page'])
        {
            case 'contact':
                // var_dump($this->response['data']['postresult']['ok']);
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
                    // $userModel->findUserByEmail($email);//geeft row uit database of false
                    if($userModel->findUserByEmail($email) == false)
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
                // var_dump($this->response['data']['postresult']['ok']);
                // var_dump($this->response['data']['postresult']['email']);
                // var_dump($this->response['data']['postresult']['password']);

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
                            var_dump($_SESSION); 
                            $this->response['page'] = 'home';                    
                        }            
                    }
                }
            break;

            case 'cart':
                if(isset($_POST['id']))
                {
                    $id=$_POST['id'];
                    require_once "./models/webshop_model.php";
                    $crud = new Crud();
                    $webshopModel = new WebshopModel($crud);
                    $webshopModel->addToCart($id);
                }
                else
                {
                    if(isset($_SESSION['cart_products']))
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


            // else
            // {
            //     switch ($this->request['page'])
            //     {
            //     // get request afhandelingen die meerdere antwoorden kunnen genereren....
            //     // zie uitleg Request-Response overview
            //     }
            // }
    
        }
    }
    
    function showResponsePage() //($data)
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
                // var_dump( $this->response['data']['postresult']);
                // var_dump( $this->response['data']);

                if (isset($this->response['data']['postresult']))
                {
                    $form = new FormsDoc($page,$this->response['data']);
                    $form->show(); 
                    echo 'checkfields zijn gezet deze waarden invullen';
                }
                else
                {
                    $dataPage = new PageInfo();           
                    $dataForm=$dataPage->getData($page);//geeft array
                    $form = new FormsDoc($page,$dataForm);
                    $form->show();
                }
                // $dataPage = new PageInfo();           
                // $dataForm=$dataPage->getData($page);//geeft array
                // // var_dump( $dataForm);
                // $form = new FormsDoc($page,$dataForm);
                // $form->show();              
            break;
            case 'logout':
                session_destroy();
                $_SESSION['userName'] = NULL;
                if($_SESSION['userName']==NULL)
                header('location://localhost/educom-webshop-oop/index.php?page=home');

            case 'webshop':
                require_once "./views/ProductDoc.php";
                /*
                //onderstaande 3 regels halen de productinformatie op uit een array
                // vervangen door DB en CRUD. 

                require_once "./models/products_info.php";
                $productModel = new ProductsModel();//hard code array, vervangen door database query result
                $productsModel = $productModel->getProducts();//hardcode database
                $products = new ProductDoc($page,$productsModel);
                */

                // onderstaand haalt producten met crud uit db

                require_once "./models/crud.php";
                require_once "./models/product_model.php";
                $crud= new Crud();
                $productModel = new ProductModel($crud);
                $productsModel=$productModel->getAllProducts();
                $products = new ProductDoc($page,$productsModel);
                $products->show();
            break;

            case 'detail':

                $this->response['data']['page'] = 'detail';//Bij de post kan de waarde opgevangen worden
                var_dump($this->response['data']['page']);         
                
                // var_dump($_GET);//in principe niet met GET wreken!!
                if (isset ($this->response['data']['id']) )
                {

                }else{
                    $id=$_GET['id'];
                    var_dump($id);  
                    $this->response['data']['id']=$id; 
                }
                                       // var_dump($this->request);//hier moet de id uitkomen.?
                require_once "./views/DetailDoc.php";
                /*
                require_once "./models/products_info.php";//ipv database
                $productModel = new ProductsModel();
                $productsModel = $productModel->getProducts();
                // var_dump($productsModel);
                $id=2;
                $product = new DetailDoc($page,$productsModel[$id]);
                $product->show();
                */  
                require_once "./models/crud.php";
                require_once "./models/product_model.php";
               
                $crud= new Crud();
                $productModel = new ProductModel($crud);
                $product=$productModel->getProductById($this->response['data']['id']);
                // var_dump($product);
                $productDoc = new DetailDoc($page,$product[0]);
                $productDoc->show();
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

                // var_dump($_SESSION['cart_products'][1]); 

                /*
                add id to session=add to cart, niet in view
                    user=id,name
                    products=id, number                
                
                for each id get properties (show)

                total price

                write to orders bij afrekenen
                write to order details                          
                */                
            break;
            // ==================================================================
            
            /*
            case 'webshop, detail, cart':
                require_once "./views/ProductDoc.php";
                require_once "./models/webshop_info.php";
                $fieldsWebshop=getWebshopFields();
                $webshop = new FormsDoc($data,$fieldsWebshop);
                $contact->show();
            break;
            */
            
            // ============================================================
            default:
            // echo 'No process request';            
        }
    }

    function showResponsePageOld() //($data)
    {
        // var_dump($this->response['page']);
        $page=$this->response['page'];
        // switch ($this->response['page'])        
        switch ($page)        
        {
            case 'home':
                require_once "./views/HomeDoc.php";
                // $home = new HomeDoc($this->response['page']);
                $home = new HomeDoc($page);
                $home->show();
            break;
            case 'about':
                require_once "./views/AboutDoc.php";
                // $about = new AboutDoc($this->response['page']);
                $about = new AboutDoc($page);
                $about->show();
            break;
            // ==================================================
            // Contact, register en login kunnen worden samengevoegd, net zoals in eerdere opgave.
            case 'contact':
            case 'register':
            case 'login':
                    /*
                    require_once "./views/FormsDoc.php";
                    require_once "./models/contact_info.php";
                    $fieldsContact=getContactFields();//geeft array
                    $contact = new FormsDoc($this->response['page'],$fieldsContact);
                    $contact->show();
                    */
                    /*
                    require_once "./views/FormsDoc.php";
                    require_once "./models/page_info.php";
                    $dataPage = new PageInfo();           
                    $fieldsContact=$dataPage->getData($this->response['page']);//geeft array
                    // var_dump($fieldsContact['fields']);
                    $contact = new FormsDoc($this->response['page'],$fieldsContact['fields']);
                    $contact->show();
                    */

                require_once "./views/FormsDoc.php";
                require_once "./models/page_info.php";
                $dataPage = new PageInfo();           
                $fieldsForm=$dataPage->getData($page);//geeft array
                // var_dump($fieldsContact['fields']);
                $form = new FormsDoc($page,$fieldsForm['fields']);
                $form->show();

            break;
            /*
            case 'register':
                require_once "./views/FormsDoc.php";
                require_once "./models/register_info.php";
                $fieldsRegister=getRegisterFields();
                $register = new FormsDoc($this->response['page'],$fieldsRegister);
                $register->show();
            break;
            case 'login':
                require_once "./views/FormsDoc.php";
                require_once "./models/login_info.php";
                $fieldsLogin=getLoginFields();
                $login = new FormsDoc($this->response['page'],$fieldsLogin);
                $login->show();
            break;
            */
            // ==================================================================
            
            /*
            case 'webshop, detail, cart':
                require_once "./views/ProductDoc.php";
                require_once "./models/webshop_info.php";
                $fieldsWebshop=getWebshopFields();
                $webshop = new FormsDoc($data,$fieldsWebshop);
                $contact->show();
            break;
            */
            
            // ============================================================
            default:
            echo 'No process request';
            
        }
    }      
}
?>