<?php
session_start();
$data = getRequestedPage();
var_dump($data);
// $result = processRequest($page);
showResponsePage($data);

function getRequestedPage() 
{     
    $requested_type = $_SERVER['REQUEST_METHOD']; 
    if ($requested_type == 'POST') 
    { 
        $requested_page = getPostVar('page','home'); 
    } 
    else 
    { 
        $requested_page = getUrlVar('page','home'); 
    } 
    return $requested_page; 
}

function getArrayVal($array, $key, $default='') 
{ 
    return isset($array[$key]) ? $array[$key] : $default; 
} 
function getPostVar($key, $default='') 
{ 
       return getArrayVal($_GET, $key, $default);
} 
function getUrlVar($key, $default='') 
{ 
    return getArrayVal($_GET, $key, $default);
}

function processRequest($page)
{

}
/*
input is $data
Dit is een array met de voorwaarden die  nodig zijn om te pagina te tonen

*/
function showResponsePage($data)
{
    switch($data)
    {
        case 'home':
            require_once "./views/HomeDoc.php";
            $home = new HomeDoc($data);
            $home->show();
        break;
        case 'about':
            require_once "./views/AboutDoc.php";
            $about = new AboutDoc($data);
            $about->show();
        break;
        // ==================================================
        // Contact, register en login kunnen worden samengevoegd, net zoals in eerdere opgave.
        case 'contact':
            require_once "./views/FormsDoc.php";
            require_once "./models/contact_info.php";
            $fieldsContact=getContactFields();
            $contact = new FormsDoc($data,$fieldsContact);
            $contact->show();
        break;
        case 'register':
            require_once "./views/FormsDoc.php";
            require_once "./models/register_info.php";
            $fieldsRegister=getRegisterFields();
            $register = new FormsDoc($data,$fieldsRegister);
            $register->show();
        break;
        case 'login':
            require_once "./views/FormsDoc.php";
            require_once "./models/login_info.php";
            $fieldsLogin=getLoginFields();
            $login = new FormsDoc($data,$fieldsLogin);
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

?>