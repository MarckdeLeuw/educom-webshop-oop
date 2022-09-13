<?php
class Crud 
{
    private $host="localhost";
    private $user="gebruiker";
    private $pwd="OIT.fxhgeTO6(reM";
    private $dbName="marck_webshop";
    private $pdo;

    public function __construct()
    {
        $dsn = 'mysql:host='.$this->host .';dbname='. $this->dbName;
        $this->pdo = new PDO($dsn, $this->user, $this->pwd);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);//optional
    }

    public function getRowByValue($sql,$value)

    {
        $stmt = $this->pdo->prepare($sql);
        if($stmt==false)
        {
            $results=false;

        }
        else
        {
            if($stmt->execute([$value]))
            {
                $results=$stmt->fetchAll();
            }
            else
            {
                $results=false;
            }        
        }
        return $results;
    }

    /*
    public function getRowByValueOld($sql,$value)

    {
        $stmt = $this->pdo->prepare($sql);//ML prepare geeft een statement terug of de waarde false
        $stmt->execute([$value]);//Geert:Test of statement prepare is gelukt alvorens het uit te voeren! #20
        //ML execute geeft true or false
        $results=$stmt->fetchAll();//Geert:Test of execute gelukt is alvorens met het resultaat te gaan werken! #21
        return $results;
    }
    */
    public function getAllRows($sql)
    {
        $stmt = $this->pdo->prepare($sql);
        if($stmt == false)
        {
            $results = false;
        }
        else
        {
            if($stmt->execute())
            {
                $results=$stmt->fetchAll();
            }
            else
            {
                $results = false;
            }
        }    
        return $results;
    }
    /*
    public function getAllRowsOld($sql)
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        
        $results=$stmt->fetchAll();
        return $results;
    }
    */

    public function createRow($sql, $parameter)
    {
        $result=false;
        $stmt = $this->pdo->prepare($sql);
        if($stmt!==false)
        {
            foreach($parameter as $key=>$value)
            {
                $stmt->bindValue($key,$value);
            }
            $result=$stmt->execute(); 
        }
        return $result;            
    }
}
?>