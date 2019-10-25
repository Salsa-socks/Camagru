<?php
    class Validate{
        private $_passed = false;
        private $_errors = array();
        private $_db = null;

        public function __construct(){
            $this->_db = DB::getInstance();
        }

        public function check($source, $items = array()) {
            foreach($items as $item => $rules){
                foreach($rules as $rule => $rule_value) {

                    $value = trim($source[$item]);
                    
                    if ($rule == 'required' && empty($value)){
                        $this->addError("{$item} is required");
                    } else if (!empty($value)) {
                        switch($rule) {
                            case 'min':
                                if (strlen($value) < ($rule_value)) {
                                    $this->addError("{$item} must be minimum of {$rule_value} characters");
                                }
                            break;
                            case 'max':

                            break;
                            case 'matches':

                            break;
                            case 'unique':

                            break;

                        }
                    }
                }
            }
            if (empty($this->_errors)) {
                $this->_passed = true;
            }
            return $this;
        }

        private function addError($error) {
            $this->_errors[] = $error;
        }

        public function errors() {
            return $this->_errors;
        }

        public function passed(){
            return $this->_passed;
        }
    }
?>