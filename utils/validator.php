<?php

    use \Respect\Validation\Validator as v;
    use Respect\Validation\Exceptions\NestedValidationException;
    
    class UserInputValidator 
    {

        private $rules = [];

        private $messages = [];

        private $errors = [];

        public function __construct() 
        {
            $this->initRules();
            $this->initMessages();
        }

        private function initRules()
        {
            $this->rules['compulsory'] = v::notEmpty()->setName('compulsory');
        }

        private function initMessages() 
        {
            $this->messages = [
                'alpha'         => '{{name}} must only contain alphabetic characters.',
                'alnum'         => '{{name}} must only contain alpha numeric characters and dashes.',
                'numeric'       => '{{name}} must only contain numeric characters.',
                'noWhitespace'  => '{{name}} must not contain white spaces.',
                'length'        => '{{name}} must length between {{minValue}} and {{maxValue}}.',
                'email'         => 'Please make sure you typed a correct email address.',
                'creditCard'    => 'Please make sure you typed a valid card number.',
                'date'          => 'Make sure you typed a valid date for the {{name}} ({{format}}).',
                'password_confirmation' => 'Password confirmation doesn\'t match.'
            ];
        }

        public function assert($inputs) 
        {
            foreach($inputs as $key => $value) {
                try {
                    $this->rules[$key]->assert($value);
                } catch (NestedValidationException $ex) {
                    $this->errors = $ex->getMessages();
                    return 0;
                }
            }
            return 1;
        }

        public function getErrors() 
        {
            return $this->errors;
        }

        
    }

?>