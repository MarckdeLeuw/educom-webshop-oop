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
            $check = $this->checkField($fieldName, $fieldInfo);
            if($check['ok']===true)
                {
                    $result[$fieldName]=$check[$fieldName];
                }
                else
                {
                    $result['ok']=false;
                    $result[$fieldName.'_error']=$check[$fieldName.'_error'];
                }

        }
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
            }else
            {
                $result[$fieldName.'_error'] = $fieldName. ' is verplicht in te vullen.';
            }  
        return $result;
        
    }





}
?>