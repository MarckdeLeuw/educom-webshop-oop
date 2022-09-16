<?php 
class Controller
{
    private $request;
    private $response;
    
    public function handleRequest(){
        session_start();
        $this-> getRequest();
        var_dump($this-> request);
        $this-> validateRequest();
        $this-> showResponse();
    }

    function getRequest()
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
    
    
    function showResponse()
    {
        // var_dump($this->response['page']);
        switch ($this->response['page'])
        {
            // Toon resultaat pagina
        }
    }
    // onderstaande doet het bij mij niet
    /*private function getRequestVar(string $key, bool $frompost, $default="", bool $asnumber=FALSE)
    { 
        $filter = $asnumber ? FILTER_SANITIZE_NUMBER_FLOAT : FILTER_SANITIZE_STRING;
        $result = filter_input(($frompost ? INPUT_POST : INPUT_GET), $key, $filter);
        return ($result===FALSE) ? $default : $result; 
    } */
    private function getRequestVar($page, $posted, $default="")
    {   
        var_dump($posted);     
        $result = ($posted ? INPUT_POST : INPUT_GET);
        // if $posted is true set result post, if $posted is false set result get
        var_dump($result);        
        return ($posted===FALSE) ? $default : $result; 
        // if 
    } 

}     