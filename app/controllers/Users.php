<?php

    class Users extends Controller {
        public $userModel;

        public function __construct() {
            $this->userModel = $this->model('User');
        }

        public function register() {
            // Check for POST
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Process Form

                // Sanitize Inputs in Post[]
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                // Load sanitized data
                $data = [
                    'name' => trim($_POST["name"]),
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm-password']),
                    'name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];

                // Validate Email
                if(empty($data['email'])) {
                    $data['email_err'] = "Please enter your email.";
                } else {
                    if($this->userModel->findUserByEmail($data['email'])) {
                        $data['email_err'] = "An account is already registered using that email.";
                    }
                }

                // Validate Name
                if(empty($data['name'])) {
                    $data['name_err'] = "Please enter your name.";
                }

                // Validate Password
                if(empty($data['password'])) {
                    $data['password_err'] = "Please enter your password.";
                } elseif(strlen($data['password']) < 6) {
                    $data['password_err'] = "Your password must be more than 5 characters.";
                }

                // Validate Confirm Password
                if(empty($data['confirm_password'])) {
                    $data['confirm_password_err'] = "Please confirm your password.";
                } else {
                    if($data['confirm_password'] != $data['password']) {
                        $data['confirm_password_err'] = "Your two passwords don't match.";
                    }
                }

                // Make sure Errors are Empty
                if(empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                    // All fields are valid.

                    // Hash Password
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                    // Send New Account Data to Database
                    if($this->userModel->register($data)) {
                        flash('register_success', "Account registered, congrats! Now you can log in.");
                        redirect('users/login');
                    } else {
                        die("There's an issue somewhere!");
                    }
                } else {
                    // Load view with error mssgs
                    $this->view('users/register', $data);
                }

            } else {
                // Init data
                $data = [
                    'name' => '',
                    'email' => '',
                    'password' => '',
                    'confirm_password' => '',
                    'name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];
                // Validate Email
                if(empty($data['email'])) {
                    $data['email_err'] = "Please enter your email.";
                }
                // Validate Password
                if(empty($data['password'])) {
                    $data['password_err'] = "Please enter your password.";
                } elseif(strlen($data['password']) < 6) {
                    $data['password_err'] = "Your password must be more than 5 characters.";
                }

                // Load view
                $this->view('users/register', $data);
            }
        }

        public function login() {
            // Check for POST
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Process Form
                // Sanitize Inputs in Post[]
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                // Load sanitized data
                $data = [
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'email_err' => '',
                    'password_err' => ''
                ];
                // Validate Email
                if(empty($data['email'])) {
                    $data['email_err'] = "Please enter your email.";
                }

                // Validate Password
                if(empty($data['password'])) {
                    $data['password_err'] = "Please enter your password.";
                } elseif(strlen($data['password']) < 6) {
                    $data['password_err'] = "Your password must be more than 5 characters.";
                }

                // Check for user/email
                if($this->userModel->findUserByEmail($data['email'])){
                    //User found
                } else {
                    $data['email_err'] = "No account found for that email";
                }
                // Make sure Errors are Empty
                if(empty($data['email_err']) && empty($data['password_err'])) {
                    // All fields are valid. Check and Set logged in user
                    $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                    if($loggedInUser) {
                        // Create Session Variables
                        $this->createUserSession($loggedInUser);
                    } else {
                        $data['password_err'] = "Password didn't match. Please try again.";
                        $this->view("users/login", $data);
                    }
                } else {
                    // Load view with error mssgs
                    $this->view('users/login', $data);
                }

            } else {
                // Init data
                $data = [
                    'email' => '',
                    'password' => '',
                    'email_err' => '',
                    'password_err' => '',
                ];

                // Load view
                $this->view('users/login', $data);
            }
        }
        public function createUserSession($user) {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_email'] = $user->email;
            $_SESSION['user_name'] = $user->name;
            redirect("posts/index");
        }

        public function logout() {
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            session_destroy();
            redirect("users/login");
        }


    }

?>