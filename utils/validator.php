<?php

    use \Respect\Validation\Validator as v;
    use Respect\Validation\Exceptions\NestedValidationException;
    
    class UserInputValidator 
    {
        private $rules = [];

        private $errors = [];

        public function __construct() 
        {
            $this->initRules();
        }

        private function initRules()
        {
            $this->rules['compulsory'] = v::notEmpty()->setName('compulsory');
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