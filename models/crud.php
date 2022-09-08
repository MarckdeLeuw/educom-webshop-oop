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
        $stmt->execute([$value]);
        
        $results=$stmt->fetchAll();
        return $results;
    }

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