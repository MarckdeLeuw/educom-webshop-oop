<?php 
class Controller
//Zie https://cursus.man-kind.nl/PAGE/EXPLAIN/OOP_INTRO
{
    private $request;
    private $response;

    public function handleRequest()
    {
        session_start();
        $this-> getRequestedPage();
        $this-> validateRequest();
        $this->showResponsePage();//geen $data?

    }
    
    private function getRequestedPage()
    {
        $posted = ($_SERVER['REQUEST_METHOD']==='POST');
        $this->request = 
            [
                'posted' => $posted,
                'page'     => $this->getRequestVar('page', $posted, 'home')    
            ];
    }
    
    function validateRequest()
    {
        $this->response = $this->request; // getoond == gevraagd
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
        var_dump($this->response['page']);
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
    
    function getRequestVar(string $key, bool $frompost, $default="", bool $asnumber=FALSE)
    {
        $filter = $asnumber ? FILTER_SANITIZE_NUMBER_FLOAT : FILTER_SANITIZE_STRING;
        $result = filter_input(($frompost ? INPUT_POST : INPUT_GET), $key, $filter);
        return ($result===FALSE) ? $default : $result;
    }
      
}   
?>