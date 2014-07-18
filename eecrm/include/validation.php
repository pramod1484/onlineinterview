<?php
/* rules:{
  first_name : {
  required     : true,
  number       : true,
  charachter   : true,
  alphaNumeric : true,
  maxLength    : 100,
  minLength    : 200
  }
  },
  message : {
  first_name : {
  required     : true,
  number       : true,
  charachter   : true,
  alphaNumeric : true,
  maxlength    : 100,
  minlength    : 200
  }
  } */

class Validation 
{
    /**
     * Posted values by the user
     * 
     * @var array 
     */
    protected static $_values;
    
    /**
     * Rules set for validation
     * 
     * @var array 
     */
    protected static $_rules;
    
    /**
     * Error messages
     * 
     * @var array 
     */
    protected static $_messages;
    
    /**
     * To send response
     * 
     * @var array 
     */
    protected static $_response = array();
    
    /**
     * For storing HTMl objects
     * 
     * @var array 
     */
    protected static $_elements;
    
    /**
     * Html object
     * 
     * @var string 
     */
    protected static $_inputElement;
    
    /**
     * Value of Html object
     * 
     * @var string/boolean/integer/double/float 
     */
    protected static $_elementValue;
    
    /**
     * Name of validation rule
     * 
     * @var string 
     */
    protected static $_validationRule;
    
    /**
     * Value of validation rule
     * 
     * @var string/boolean/integer/double/float 
     */
    protected static $_ruleValue;
    
    /**
     * Initializing class
     * 
     * @param array $inputArray
     * @param array $values
     */
    public static function _initialize(array $inputArray, array $values) {
        self::$_values = $values;
        self::$_response = array();

        self::generateArrays($inputArray);
        return self::applyValidation();
    }
    
    /**
     * Separating rules and values
     * 
     * @param array $input
     */
    public static function generateArrays(array $input) {
        self::$_messages = $input['messages'];
        self::$_rules    = $input['rules'];
    }
    
    /**
     * Applying validation for the form values
     * 
     */
    public static function applyValidation() {
        foreach (self::$_rules as $rk => $rv) {
            $_element = self::$_rules[$rk];
            if (is_array($_element)) {
                foreach ($_element as $key => $ruleValue) {
                    if (!self::$_elements[$rk]['inValid']) {
                        $method = "_" . $key;
                        self::$_inputElement   = $rk;
                        self::$_elementValue   = self::$_values[$rk];
                        self::$_validationRule = $key;
                        self::$_ruleValue      = $ruleValue;

                        self::$method();
                    }
                }
            }
        }

        if (count(self::$_response) == 0) {
            self::$_response['valid'] = true;
        }
        
        return self::$_response;
    }

    /**
     * Method to check wheather the input element holds the value.
     * If not then assingn message which is set by the user.
     *
     */
    protected static function _required() {
        if (self::$_ruleValue) {
            if (trim(self::$_elementValue)   == NULL && 
                strlen(self::$_elementValue) == 0) {
                self::setErrorMessage("Field Required");
                self::setInvalidFlag(true);
            } else {
                self::setInvalidFlag(false);
            }
        }
    }

    /**
     * Maximum length of input
     *
     */
    protected static function _maxLength() {
        if (self::$_ruleValue) {
            if (strlen(trim(self::$_elementValue)) > self::$_ruleValue) {
                self::setErrorMessage("Enter at most " . self::$_ruleValue . " charachters only");
                self::setInvalidFlag(true);
            } else {
                self::setInvalidFlag(false);
            }
        }
    }

    /**
     * Minimum length of input
     * 
     */
    protected static function _minLength() {
        if (self::$_ruleValue) {
            if (self::$_ruleValue > strlen(trim(self::$_elementValue))) {
                self::setErrorMessage("Enter at least " . self::$_ruleValue . " charachters ");
                self::setInvalidFlag(true);
            } else {
                self::setInvalidFlag(false);
            }
        }
    }
    
    /**
     * Allow alphabets only
     * 
     */
    protected static function _number() {
        if (self::$_ruleValue) {
            $str = filter_var(trim(self::$_elementValue), FILTER_SANITIZE_NUMBER_INT);
            if (!preg_match('/[0-9]/', $str)) {
                self:: setErrorMessage("Enter numbers only");
                self::setInvalidFlag(true);
            } else {
                self::setInvalidFlag(false);
            }
        }
    }    
    
    /**
     * Allow alphabets only
     * 
     */
    protected static function _alphabetsOnly() {
        if (self::$_ruleValue) {
            $str = filter_var(trim(self::$_elementValue), FILTER_SANITIZE_STRING);
            if (!preg_match('/[a-zA-z]/', $str)) {
                self:: setErrorMessage("Enter alphabates only");
                self::setInvalidFlag(true);
            } else {
                self::setInvalidFlag(false);
            }
        }
    }
    
    /**
     * Allow alphabets and numbers only 
     * 
     */
    protected static function _alphaNumeric(){
        if (self::$_ruleValue) {
            $str = trim(self::$_elementValue);
            if (!preg_match('/[a-zA-z0-9]/', $str)) {
                self:: setErrorMessage("Alphanumeric only");
                self::setInvalidFlag(true);
            } else {
                self::setInvalidFlag(false);
            }
        }        
    }
    
    /**
     * To check enter email is valid
     * 
     */
    protected static function _email(){
       if (self::$_ruleValue) {
            $str = filter_var(trim(self::$_elementValue), FILTER_VALIDATE_EMAIL);
            if (!$str) {
                self:: setErrorMessage("Enter valid email");
                self::setInvalidFlag(true);
            } else {
                self::setInvalidFlag(false);
            }
        }        
    }
    
    /**
     * To check enter url is valid
     * 
     */
    protected static function _url(){
       if (self::$_ruleValue) {
            $str = filter_var(trim(self::$_elementValue), FILTER_VALIDATE_URL);
            if (!$str) {
                self:: setErrorMessage("Enter valid URL");
                self::setInvalidFlag(true);
            } else {
                self::setInvalidFlag(false);
            }
        }        
    }
    
    /**
     * Setting invalid flag for every element
     * 
     * @param boolean $flag
     */
    private static function setInvalidFlag($flag) {
        self::$_elements[self::$_inputElement]['inValid'] = $flag;
    }
    
    /**
     * Setting error message for the input element
     * 
     * @param string $message
     */
    private static function setErrorMessage($message) {
        if (self::$_messages[self::$_inputElement][self::$_validationRule]) {
            $message = self::$_messages[self::$_inputElement][self::$_validationRule];  
        }
       array_push(self::$_response, ucfirst($message)); 
    }
}
?>


<?php /*
<form name="frmTest" id="frmTest" action="" method="POST">
    <input type="text" name="first_name" id="first_name" value = "" />
    <button name="submit" value="Submit" type="submit" >Submit</button>
</form>

<?php
$array = array('method'   => 'POST',
               'rules'    => array('first_name' => array('required'=> true,
                                                          'url'    => true)),
                'messages' => array('first_name' => array('required' => 'Please enter first name')) 
             );
    $response = Validation::_initialize($array, $_POST);
    
    if (!$response['valid']) {
         echo "<pre>"; print_r($response);
    } else {
       echo "<pre>"; print_r($_POST);
    }
    */
?>