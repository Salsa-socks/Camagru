<?php
    class validate{
        private $_passed = false;
        private $_errors = array();
        private $_db = null;

        public function __construct(){
            $this->_db = DB::getInstance();
        }

        public function check($source, $items = array()) {
            foreach($items as $item => $rules){
                foreach($rules as $rule => $rule_value) {
                    
                }
            }
        }
    }
?>