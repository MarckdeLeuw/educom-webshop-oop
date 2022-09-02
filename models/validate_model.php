<?php
class ValidateForm
{
    public function checkFields($fields)
    {
        $result = array();
        $result['ok']=true;
        // return $result;
        // echo 'validateForm wordt aangeroepn';
        foreach ($fields as $fieldName => $fieldInfo)
        {
            // $check = $this->checkField($fieldName, $fieldInfo);
            $check = $this->checkField($fieldName, $fieldInfo);
            // var_dump($this->check);
            if($check['ok']===true)
                {
                    $result[$fieldName]=$check[$fieldName];
                }
                else
                {
                    $result['ok']=false;
                    $result[$fieldName.'_err']=$check[$fieldName.'_err'];
                }

        }
        // var_dump($result);
        return $result;
    }

    public function checkField (string $fieldName, array $fieldInfo) : array
    {
        $result = array();
        $result['ok']=false;
        if (isset($_POST[$fieldName]))
            {
                $value = $_POST[$fieldName];
                // $value = trim($value); 
                // $value = stripslashes($value); 
                // $value = htmlspecialchars($value); 
                $result[$fieldName]=$value;
                // $result['ok']=true;
            }if(empty($value))
            {
                $result[$fieldName.'_err'] = $fieldName.' is verplicht in te vullen.';
            }
            else
            {
            $result['ok']=true;
            }                   
        return $result;
        // var_dump($result);
    }





}
?>