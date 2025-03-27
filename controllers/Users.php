<?php
class Users extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = $this->model('User');
    }

    public function register() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            if(empty($data['username'])) {
                $data['username_err'] = 'Please enter username';
            }

            if(empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } elseif($this->userModel->findUserByEmail($data['email'])) {
                $data['email_err'] = 'Email is already taken';
            }

            if(empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            } elseif(strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be at least 6 characters';
            }

            if(empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm password';
            } else {
                if($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passwords do not match';
                }
            }

            if(empty($data['username_err']) && empty($data['email_err']) && 
               empty($data['password_err']) && empty($data['confirm_password_err'])) {
                if($this->userModel->register($data)) {
                    flash('register_success', 'You are registered and can log in');
                    redirect('users/login');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('users/register', $data);
            }
        } else {
            $data = [
                'username' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            $this->view('users/register', $data);
        }
    }

    public function login() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'role' => trim($_POST['role']),
                'email_err' => '',
                'password_err' => '',
                'role_err' => ''
            ];

            // Validation
            if(empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            }
            if(empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            }

            if(empty($data['email_err']) && empty($data['password_err'])) {
                $loggedInUser = $this->userModel->loginWithRole($data['email'], $data['password'], $data['role']);
                
                if($loggedInUser) {
                    $this->createUserSession($loggedInUser);
                    
                    // Log the login
                    $this->userModel->logLogin($loggedInUser->id);
                    
                    // Redirect based on role
                    if($data['role'] == 1) {
                        redirect('admin/dashboard');
                    } else {
                        redirect('users/profile');
                    }
                } else {
                    $data['password_err'] = 'Invalid credentials or incorrect role';
                    $this->view('users/login', $data);
                }
            } else {
                $this->view('users/login', $data);
            }
        } else {
            $data = [
                'email' => '',
                'password' => '',
                'role' => '',
                'email_err' => '',
                'password_err' => '',
                'role_err' => ''
            ];
            $this->view('users/login', $data);
        }
    }

    public function dashboard() {
        if(!isLoggedIn()) {
            redirect('users/login');
        }

        // Get user data
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        $loginHistory = $this->userModel->getLoginHistory($_SESSION['user_id']);

        $data = [
            'user' => $user,
            'loginHistory' => $loginHistory
        ];

        $this->view('users/dashboard', $data);
    }

    public function createUserSession($user) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->username;
        $_SESSION['user_role'] = $user->role_id;
        $this->userModel->logLogin($user->id);
        redirect('pages/index');
    }

    public function logout() {
        if(isset($_SESSION['user_id'])) {
            $this->userModel->logLogout($_SESSION['user_id']);
        }
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_role']);
        session_destroy();
        redirect('users/login');
    }

    public function profile() {
        if(!isLoggedIn()) {
            redirect('users/login');
        }

        $userDetails = $this->userModel->getUserById($_SESSION['user_id']);
        $loginHistory = $this->userModel->getLoginHistory($_SESSION['user_id']);

        $data = [
            'user' => $userDetails,
            'loginHistory' => $loginHistory
        ];

        $this->view('users/profile', $data);
    }

    public function edit($id = null) {
        if(!isLoggedIn()) {
            redirect('users/login');
        }

        // Make sure users can only edit their own profile
        if($id != $_SESSION['user_id']) {
            redirect('users/profile');
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => $id,
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'current_password' => trim($_POST['current_password']),
                'new_password' => trim($_POST['new_password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'username_err' => '',
                'email_err' => '',
                'current_password_err' => '',
                'new_password_err' => '',
                'confirm_password_err' => ''
            ];

            // Validate username
            if(empty($data['username'])) {
                $data['username_err'] = 'Please enter username';
            }

            // Validate email
            if(empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } else {
                if($this->userModel->findUserByEmailExceptId($data['email'], $id)) {
                    $data['email_err'] = 'Email is already taken';
                }
            }

            // Validate password if being changed
            if(!empty($data['current_password']) || !empty($data['new_password']) || !empty($data['confirm_password'])) {
                if(empty($data['current_password'])) {
                    $data['current_password_err'] = 'Please enter current password';
                } elseif(!$this->userModel->verifyPassword($id, $data['current_password'])) {
                    $data['current_password_err'] = 'Current password is incorrect';
                }

                if(empty($data['new_password'])) {
                    $data['new_password_err'] = 'Please enter new password';
                } elseif(strlen($data['new_password']) < 6) {
                    $data['new_password_err'] = 'Password must be at least 6 characters';
                }

                if(empty($data['confirm_password'])) {
                    $data['confirm_password_err'] = 'Please confirm new password';
                } else {
                    if($data['new_password'] != $data['confirm_password']) {
                        $data['confirm_password_err'] = 'Passwords do not match';
                    }
                }
            }

            if(empty($data['username_err']) && empty($data['email_err']) && 
               empty($data['current_password_err']) && empty($data['new_password_err']) && 
               empty($data['confirm_password_err'])) {
                
                if($this->userModel->updateUser($data)) {
                    flash('profile_message', 'Profile updated successfully');
                    redirect('users/profile');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('users/edit', $data);
            }
        } else {
            $user = $this->userModel->getUserById($id);
            
            $data = [
                'id' => $id,
                'username' => $user->username,
                'email' => $user->email,
                'current_password' => '',
                'new_password' => '',
                'confirm_password' => '',
                'username_err' => '',
                'email_err' => '',
                'current_password_err' => '',
                'new_password_err' => '',
                'confirm_password_err' => ''
            ];

            $this->view('users/edit', $data);
        }
    }

    public function clearHistory() {
        if(!isLoggedIn()) {
            redirect('users/login');
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($this->userModel->clearLoginHistory($_SESSION['user_id'])) {
                flash('profile_message', 'Login history cleared successfully');
            } else {
                flash('profile_message', 'Something went wrong', 'alert alert-danger');
            }
        }
        
        redirect('users/profile');
    }
}