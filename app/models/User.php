<?php
    class User{
        private $db;

        public function __construct(){
            $this->db = new Database;
        }

        public function getUser(){
            $sql = 'SELECT * FROM users';
            $this->db->query($sql);
            return $this->db->resultSet();
        }

        public function register($data){
            $this->db->query('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
            // bind values
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':password', $data['password']);
            // execute
            if($this->db->execute()){
                return true;
            } else{
                return false;
            }
        }

        public function findUserByEmail($email){
            $this->db->query('SELECT * FROM users WHERE email = :email');
            $this->db->bind(':email', $email);

            $row = $this->db->single();

            // check row
            if($this->db->rowCount() > 0){
                return true;
            } else{
                return false;
            }
        }

        public function login($email, $pass){
            $this->db->query('SELECT * FROM users WHERE email = :email');
            $this->db->bind(':email', $email);

            $row = $this->db->single();
            
            $hashed_password = $row->password;
            // check row
            if(password_verify($pass, $hashed_password)){
                return $row;
            }
            else{
                return false;
            }
        }

        public function getUserById($id){
            $this->db->query('SELECT * FROM users WHERE id = :id');
            $this->db->bind(':id', $id);

            $row = $this->db->single();

            return $row;
        }
    }