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
        var_dump($this->request);
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
        var_dump($key);//'page'
        var_dump($frompost);//'false'
        var_dump($default);//'home'

        $filter = $asnumber ? FILTER_SANITIZE_NUMBER_FLOAT : /*FILTER_DEFAULT*/FILTER_SANITIZE_STRING; //hier wordt een functie aangeroepen die je niet meer mag gebruiken?
        $result = filter_input(($frompost ? INPUT_POST : INPUT_GET), $key, $filter);
        // (if $frompost is true, then input_post else input_get) input type die gechecked wordt
        // variabele die gechecked wordt, in dit geval de page
        // filter die toegepast wordt.
        // uitkomsten zijn de waarde bij succes, false on failure, en null als niet gezet
        var_dump($result);// NULL
        return ($result===/*FALSE*/NULL) ? $default : $result; 
       
        // ML moet false niet null zijn??
       
        // in dit geval is $result null dus niet false en geeft hij de result terug? je verwacht een pagina?
    }   
    
    function validateRequest()
    {
        $this->response = $this->request; // getoond == gevraagd
        // var_dump($this->response);
        if ($this->request['posted'])
        {
            switch ($this->request['page'])
            {
            // post request afhandelingen die meerdere antwoorden kunnen genereren....
            // zie uitleg Request-Response overview
            }
        }
        else
        {
            switch ($this->request['page'])
            {
            // get request afhandelingen die meerdere antwoorden kunnen genereren....
            // zie uitleg Request-Response overview
            }
        }
    }
    
    
    function showResponsePage() //($data)
    {
        // var_dump($this->response['page']);
        switch ($this->response['page'])        
        {
            case 'home':
                require_once "./views/HomeDoc.php";
                $home = new HomeDoc($this->response['page']);
                $home->show();
            break;
            case 'about':
                require_once "./views/AboutDoc.php";
                $about = new AboutDoc($this->response['page']);
                $about->show();
            break;
            // ==================================================
            // Contact, register en login kunnen worden samengevoegd, net zoals in eerdere opgave.
            case 'contact':
                require_once "./views/FormsDoc.php";
                require_once "./models/contact_info.php";
                $fieldsContact=getContactFields();
                $contact = new FormsDoc($this->response['page'],$fieldsContact);
                $contact->show();
            break;
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
    
    
    // function getRequestVar(string $key, bool $frompost, $default="", bool $asnumber=FALSE)//laatste overbodig?
    // {
    //     var_dump($key);
    //     var_dump($frompost);
    //     var_dump($default);
    //     $filter = $asnumber ? FILTER_SANITIZE_NUMBER_FLOAT : FILTER_SANITIZE_STRING;//deprecitated??
    //     // $result = filter_input(($frompost ? INPUT_POST : INPUT_GET), $key, $filter);
    //     $result = [($frompost ? INPUT_POST : INPUT_GET), $key];
    //     return ($result===FALSE) ? $default : $result;
    // }
    
    // private function getRequestVar($page, $posted, $default="")
    // {   
    //     var_dump($posted);     
    //     $result = ($posted ? INPUT_POST : INPUT_GET);
    //     // if $posted is true set result post, if $posted is false set result get
    //     // var_dump($result);        
    //     return ($posted===FALSE) ? $default : $result; 
    //     // if 
    // }          
}
?>