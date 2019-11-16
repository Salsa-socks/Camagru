<?php
    class User {
        private $_db;
        private $_data;
        private $_sessionName;
        private $_cookieName;
        private $_isLoggedin;

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

        public function upload($fields = array()) {
            if (!$this->_db->insert('images', $fields)) {
                throw new Exception('There was a problem uploading your images.');
            }
        }

        public function uploadc($fields = array()) {
            if (!$this->_db->insert('comments', $fields)) {
                throw new Exception('There was a problem uploading your comment.');
            }
        }

        public function update($fields = array(), $id = null) {
            if (!$id && $this->isLoggedin()) {
                $id = $this->data()->$id;
            }
            if(!$this->_db->update('users', $id, $fields)) {
                throw new Exception('There was a problem updating your details.');
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

        public function login($username = null, $password = null, $remember = false) {
            if(!$username && !$password && $this->exists()) {
                Session::put($this->_sessionName, $this->data()->id);
            } else {
                $user = $this->find($username);
                    if ($user) {
                        if($this->data()->password == Hash::make($password, $this->data()->salt)) { 
                            Session::put($this->_sessionName, $this->data()->id);
                            if($remember) {
                                $hash = Hash::unique();
                                $hashcheck = $this->_db->get('users_session', array('user_id', '=', $this->data()->id));

                                if(!$hashcheck->count()) {
                                    $this->_db->insert('users_session', array(
                                        'user_id' => $this->data()->id,
                                        'hash' => $hash
                                    ));
                                } else {
                                    $hash = $hashcheck->first()->hash;
                                }

                                Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
                            }

                            return true;
                        } 
                    } else {
                        Session::flash('home', 'No such User');
                        Redirect::to('../includes/index.php');
                    }
                }
                return false;
        }

        public function exists() {
            return (!empty($this->_data)) ? true : false;
        }

        // public function hasPermission($key) {
        //     $group = $this->_db->get('groups', array('id', '=', $this->data()->group));
        //     if ($group->count()) {
        //         $permissions = json_decode($group->first()->permissions, true);

        //         if($permissions[$key] == true) {
        //             return true;
        //         }
        //     }
        //     return false;
        // }

        public function logout() {
            $this->_db->delete('users_session', array('user_id', '=' , $this->data()->id));
            Session::delete($this->_sessionName);
            Cookie::delete($this->_cookieName);

        }

        public function data() {
            return $this->_data;
        }

        public function isLoggedin() {
            return $this->_isLoggedin;
        }
    }