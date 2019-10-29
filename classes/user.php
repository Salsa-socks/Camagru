<?php
    class User {
        private $_db;
        private $_data;
        private $_sessionName;
        private $_isLoggedin;

        public function __construct($user = null) {
            $this->_db = DB::getInstance();
            $this->_sessionName = Config::get('session/session_name');

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
            if (!$this->_db->insert('users', $fields)) {
                throw new Exception('There was a problem creating account');
            }
        }

        public function find($user = null) {
            if ($user) {
                $field = (is_numeric($user)) ? 'id' : 'username';
                $data = $this->_db->get('users', array($field, '=', $user));

                if ($data->count()) {
                    $this->_data = $data->first();
                    return true;
                }
            }
        }

        public function login($username = null, $password = null, $remmeber) {
            $user = $this->find($username);
            if ($user) {
                if($this->data()->password === Hash::make($password, $this->data()->salt)) { 
                    Session::put($this->_sessionName, $this->data()->id);
                    if($remember) {
                        $hash = Hash::unique();
                        $hashcheck = $this->_db->get('users_session', array('user_id', '=', $this->data()->id));

                        if(!$hashcheck->count()) {
                            $this->_db->insert(array(
                                'user_id' => $this->data()->id,
                                'hash' => $hash
                            ));
                        } else {
                            $hash = $hashcheck->first()->hash;
                        }
                    }

                    return true;
                }
            }
            return false;
        }
        public function logout() {
            Session::delete($this->_sessionName);
        }

        public function data() {
            return $this->_data;
        }

        public function isLoggedin() {
            return $this->_isLoggedin;
        }
    }