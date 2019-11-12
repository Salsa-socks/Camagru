<?php
    class Images {
        private $_db;
        private $_data;

        public function __construct($user = null) {
            $this->_db = DB::getInstance();
        }


    }