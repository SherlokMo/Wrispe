<?php 
namespace Core;

use App\Applecation;

/**
 * Class Model
 * 
 * @author Mohammad Salah <redmohammad22@gmail.com>
 * @package Core
 */

abstract class Model{

    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = "email";
    public const RULE_MIN = "min";
    public const RULE_MAX = "max";
    public const RULE_MATCH = "match";
    public const RULE_UNIQUE = "unique";

    /**
     * 
     * @param array $data
     * 
     * @return void
     */
    public function loadData(array $data): void
    {
        foreach($data as $key => $value){

            /**
             * to avoid PHP errors in the futuer for example:
             * Somebody sends a parameter that does not exist as a property on the (x) model
             * 
             * @param object | $this is the child class instanse;
             */
            if(property_exists($this,$key)){
                $this->$key = $value;
            }

        }
    }

    abstract public function rules(): array;

    public $errors = [];

    public function validate(): bool
    {
        foreach($this->rules() as $parameter => $rules){ // iterating over every post parameter
            $value = $this->$parameter;
            foreach($rules as $rule){ // iterating over every rule of the rules
                $ruleName = $rule;
                if(!is_string($ruleName)){
                    $ruleName = $rule[0];
                }
                if($ruleName === self::RULE_REQUIRED && !$value){
                    $this->addError($parameter,self::RULE_REQUIRED,['field'=>$parameter]);
                }
                elseif($ruleName === self::RULE_EMAIL && !filter_var($value,FILTER_VALIDATE_EMAIL)){
                    $this->addError($parameter,self::RULE_EMAIL,['field'=>$parameter]);
                }
                elseif($ruleName === self::RULE_MIN && strlen($value) < $rule['min']){
                    $this->addError($parameter,self::RULE_MIN, array_merge(['field'=>$parameter],$rule));
                }
                elseif($ruleName === self::RULE_MAX && strlen($value) > $rule['max']){
                    $this->addError($parameter,self::RULE_MAX,array_merge(['field'=>$parameter],$rule));
                }
                elseif($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']} )
                {
                    $this->addError($parameter,self::RULE_MATCH,array_merge(['field'=>$parameter],$rule));
                } 
                elseif($ruleName === self::RULE_UNIQUE)
                {
                    $className = $rule['class'];
                    $uniqueAtrr = $rule['attribute'] ?? $parameter;
                    $tableName = $className::tablename();
                    $record = Applecation::$app->dbQuery("SELECT id FROM $tableName WHERE $uniqueAtrr=:$uniqueAtrr LIMIT 1",
                    [
                        "$uniqueAtrr"=>$this->{$uniqueAtrr}
                    ]);
                    if($record)
                    {
                        $this->addError($parameter,SELF::RULE_UNIQUE,["field"=>$uniqueAtrr]);
                    }
                }
            }            

        }
        
        return empty($this->errors);
    }

    public function addManualError($error)
    {
        $this->errors['manual'][] = $error;
        return false;
    }

    public function addError($parameter, $rule, $errParams = []): void
    {
        $message = $this->errorMessages()[$rule] ?? '';

        foreach($errParams as $key => $value){
            $message = str_replace("{{$key}}",$value,$message);
        }

        /**
         * empty bracket adds an auto increasment index to the array
         */
        $this->errors[$parameter][] = $message; 
    }

    /**
     * @param string $lang as language base
     * 
     * @return array | error messages
     */
    public function errorMessages(string $lang = "EN"): array
    {
        return [
            self::RULE_REQUIRED => "{field} cannot be blank",
            self::RULE_EMAIL => "{field} must be a valid email address",
            self::RULE_MIN => "{field} must not be less than {min} characters",
            self::RULE_MAX => "{field} must not be larger than {max} characters",
            self::RULE_MATCH => "{field} must match {match}",
            self::RULE_UNIQUE => "This {field} already exist "
        ];
    }

    /**
     * @param string parameter is the attribute
     * 
     * @return bool
     */
    public function hasError($parameter)
    {
        return $this->errors[$parameter] ?? FALSE;
    }

    /**
     * @param string parameter is the attribute
     * @return string
     */
    public function getError($parameter): string
    {
        return $this->hasError($parameter) ? $this->errors[$parameter][0] : "";
    }

    public function firstError()
    {
        if(!empty($this->errors))
        {
            $errors = $this->errors;
            reset($errors);
            $first_key = key($errors);
            return $errors[$first_key][0];
        }
        return "";
    }

}

?>