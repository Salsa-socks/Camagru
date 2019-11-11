<?php
    class Images {
        private $_db;
        private $_sessionName;
        private $_cookieName;

        public function __construct($user = null) {
            $this->_db = DB::getInstance();
            $this->_sessionName = Config::get('session/session_name');
            $this->_cookieName = Config::get('remember/cookie_name');

            if(!$user) {
                if(Session::exists($this->_sessionName)) {
                    $user = Session::get($this->_sessionName);

                    if($this->find($user)) {
                        $this->_isLoggedin = true;
                    } else {
                        //logout
                    }
                }
            } else {
                $this->find($user);
            }
        }

        public function create($fields = array()) {
            if (!$this->_db->insert('images', $fields)) {
                throw new Exception('There was a problem creating account');
            }
        }


    }
?>