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
        $this->request = 
            [
                'posted' => $posted,
                'page'     => $this->getRequestVar('page', $posted, 'home')//hier zet je default    
            ];
    }

    function getRequestVar(string $key, bool $frompost, $default="", bool $asnumber=FALSE)
    {
        // var_dump($key);//'page'
        // var_dump($frompost);//'false'
        // var_dump($default);//'home'

        $filter = $asnumber ? FILTER_SANITIZE_NUMBER_FLOAT : /*FILTER_DEFAULT*/FILTER_SANITIZE_STRING; //hier wordt een functie aangeroepen die je niet meer mag gebruiken?
        $result = filter_input(($frompost ? INPUT_POST : INPUT_GET), $key, $filter);
        // (if $frompost is true, then input_post else input_get) input type die gechecked wordt
        // variabele die gechecked wordt, in dit geval de page
        // filter die toegepast wordt.
        // uitkomsten zijn de waarde bij succes, false on failure, en null als niet gezet
        
        // var_dump($result);// NULL
        return ($result===NULL) ? $default : $result; 
// ML test uitbreiden

        // return ($result===FALSE) ? $default : $result;      
        // ML moet false niet null zijn??       
        // in dit geval is $result null dus niet false en geeft hij de result terug? je verwacht een pagina?
    }   
    
    function validateRequest()
    {
        $this->response = $this->request; // getoond == gevraagd
        // var_dump($this->response);
        // posted=true
        // page = page

        require_once "./models/page_info.php";
        require_once "./models/validate_model.php";

        $dataByPage = new PageInfo();
        $this->response['data']=$dataByPage->getData($this->response['page']);
        // var_dump($this->response['data']['fields']);
        if(isset($this->response['data']['fields']))
        {
            $fields=$this->response['data']['fields'];
            // echo' data fields zijn gezet';
            $validateForm = new ValidateForm();
            $this->response['data']['postresult'] = $validateForm->checkFields($fields);
            // var_dump($checkFields);     
        }
        switch($this->request['page'])
        {
            case'contact':
                // var_dump($this->response['data']['postresult']['ok']);
                if( $this->response['data']['postresult']['ok']==true)
                {
                   echo 'Bedankt voor het invullen';
                }
            break;

            // default
            // echo "No process request";

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
                    echo 'checkfields zijn gezet deze waarden invullen';
                }
                else
                {
                    // $dataPage = new PageInfo();           
                    // $dataForm=$dataPage->getData($page);//geeft array
                    // $form = new FormsDoc($page,$dataForm);
                    // $form->show();
                }
                $dataPage = new PageInfo();           
                $dataForm=$dataPage->getData($page);//geeft array
                $form = new FormsDoc($page,$dataForm);
                $form->show();              
            break;
            case 'webshop':
                require_once "./views/ProductDoc.php";
                require_once "./models/products_info.php";
                $productModel = new ProductsModel();
                $productsModel = $productModel->getProducts();
                $products = new ProductDoc($page,$productsModel);
                $products->show();                
            break;
            case 'detail':
                require_once "./views/DetailDoc.php";
                require_once "./models/products_info.php";//ipv database
                $productModel = new ProductsModel();
                $productsModel = $productModel->getProducts();
                // var_dump($productsModel);
                $id=2;
                $product = new DetailDoc($page,$productsModel[$id]);
                $product->show();                
            break;
            case 'cart':
                require_once "./views/CartDoc.php";
                require_once "./models/products_info.php";
                $productModel = new ProductsModel();
                $productsModel = $productModel->getProducts();
                $products = new CartDoc($page,$productsModel);
                $products->show();    

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
            echo 'No process request';            
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