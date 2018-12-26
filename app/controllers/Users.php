<?php
    class Users extends Controller{
        public function __construct(){
            $this->userModel = $this->model('User');
        }

        public function user(){
            $users = $this->userModel->getUser();
            $data = [
                'name' => $users

            ];
            $this->view('users/user', $data);
        }

        public function register(){
            // check for POST
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // sanitize the post request
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                // process the form
                $data = [
                    'name' => trim($_POST['name']),
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'name_error' => '',
                    'email_error' => '',
                    'password_error' => '',
                    'confirm_password_error' => ''
                ];
                // validate namew
                if(empty($data['name'])){
                    $data['name_error'] = 'Please enter your name';
                }
                // validate email
                if(empty($data['email'])){
                    $data['email_error'] = 'Please enter email';
                } else {
                    // check email
                    if($this->userModel->findUserByEmail($data['email'])){
                        $data['email_error'] = 'Email is already taken';
                    }
                }
                // validate password
                if(empty($data['password'])){
                    $data['password_error'] = 'Please enter your password';
                } else{
                    if(strlen($data['password']) < 6){
                        $data['password_error'] = 'Password must be at least 6 characters';
                    }
                }
                // validate confirm password
                if(empty($data['confirm_password'])){
                    $data['confirm_password_error'] = 'Please confirm your password';
                } else{
                    if($data['password'] != $data['confirm_password']){
                        $data['confirm_password_error'] = 'Password do not match';
                    }
                }
                // make sure no error is empty
                if(empty($data['name_error']) && empty($data['email_error']) && empty($data['password_error']) && empty($data['confirm_password_error'])){
                    // validated
                    // hash password
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                    // register user
                    if($this->userModel->register($data)){
                        flash('register_success', 'You are registered and can logged in');
                        redirect('users/login');
                    } else{
                        die('Something went wrong');
                    }
                } else{
                    // load the view with errors
                    $this->view('users/register', $data);
                }

            } else{
                // init data
                $data = [
                    'name' => '',
                    'email' => '',
                    'password' => '',
                    'confirm_password' => '',
                    'name_error' => '',
                    'email_error' => '',
                    'password_error' => '',
                    'confirm_password_error' => ''
                ];
                // load view
                $this->view('users/register', $data);
            }
        }

        public function login(){
            // check for POST
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // sanitize the post request
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                // process the form
                $data = [
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'email_error' => '',
                    'password_error' => '',
                ];
                // validate email
                if(empty($data['email'])){
                    $data['email_error'] = 'Please enter email';
                }
                // validate password
                if(empty($data['password'])){
                    $data['password_error'] = 'Please enter your password';
                }

                // check for user email
                if($this->userModel->findUserByEmail($data['email'])){
                    // user found
                } else{
                    $data['email_error'] = 'No user found';
                }

                // make sure no error is empty
                if(empty($data['email_error']) && empty($data['password_error'])){
                    // validated
                    $loggedIn = $this->userModel->login($data['email'], $data['password']);

                    if($loggedIn) {
                        // create user session
                        $this->createUserSession($loggedIn);
                    } else{
                        $data['password_error'] = 'Password Incorrect';
                        $this->view('users/login', $data);
                    }
                } else{
                    // load the view with errors
                    $this->view('users/login', $data);
                }
                
            } else{
                // init data
                $data = [
                    'email' => '',
                    'password' => '',
                    'email_error' => '',
                    'password_error' => ''
                ];
                // load view
                $this->view('users/login', $data);
            }
        }

        public function createUserSession($user){
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_email'] = $user->email;
            $_SESSION['user_name'] = $user->name;
            redirect('posts/index');
        }

        public function logout(){
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            session_destroy();
            redirect('users/login');
        }
    }