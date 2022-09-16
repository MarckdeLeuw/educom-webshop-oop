<?php
 require_once "./models/base_model.php";
class UserModel extends BaseModel
{
    
    public function findUserByEmail($valueEmail)
    {
        $sql = 'SELECT * FROM users WHERE email  = (:email) ';
        $parameter=array(':email'=>$valueEmail);   
        $user=$this->crud->getRowByValue($sql,$parameter);
        if($user==null)
        {
            return false;
        }else
        {
            return $user;
            echo 'email is gevonden';
        }
    }
/*==============================================================
//Zie ook  getRowByValueOld($sql,$value)
    public function findUserByEmailOld($valueEmail)
    {
        $sql = 'SELECT * FROM users WHERE email  = ? ';//Geert:Waarom geen named placeholders gebruiken zoals in addUser? #24
        $user=$this->crud->getRowByValue($sql,$valueEmail);
        if($user==null)
        {
            return false;
        }else
        {
            return $user;
        }
    }
==========================================================*/
    public function authenticateUser($user,$password)
    {       
        if($user[0]['wachtwoord']==$password)//Geert:Waarom $user[0] ? #23
            {
            // echo 'password is correct';
            return $user;
            }else
            {
                // echo 'password is niet correct';
                return false;
            }  
    }

    public function checkRegisterPasswords($password,$password2)
    {
        if($password==$password2)
        {
            echo'passwords are the same';
            return true;
        }
        else
        {
            echo'passwords are not the same';
            return false;
        }
    }

    public function addUser($name,$email,$wachtwoord)
    {
        $sql = 'INSERT INTO users(naam, email, wachtwoord) VALUES (:naam,:email,:wachtwoord) ';
        $parameter=array(':naam'=>$name,':email'=>$email,':wachtwoord'=>$wachtwoord);   
        $result=$this->crud->createRow($sql,$parameter);                    
    }
}
?>