<?php
class Admin extends Controller {
    private $userModel;

    public function __construct() {
        if(!isLoggedIn() || $_SESSION['user_role'] != 1) {
            redirect('users/login');
        }
        $this->userModel = $this->model('User');
    }

    public function dashboard() {
        $users = $this->userModel->getAllUsers();
        $roles = $this->userModel->getAllRoles();
        $totalUsers = count($users);
        $activeUsers = count(array_filter($users, function($user) {
            return $user->status == 'active';
        }));

        $data = [
            'users' => $users,
            'roles' => $roles,
            'totalUsers' => $totalUsers,
            'activeUsers' => $activeUsers
        ];

        $this->view('admin/dashboard', $data);
    }

    public function users() {
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $status = isset($_GET['status']) ? $_GET['status'] : '';
        $role = isset($_GET['role']) ? $_GET['role'] : '';

        $users = $this->userModel->searchUsers($search, $status, $role);
        $roles = $this->userModel->getAllRoles();

        $data = [
            'users' => $users,
            'roles' => $roles,
            'search' => $search,
            'status' => $status,
            'role' => $role
        ];

        $this->view('admin/users', $data);
    }

    public function toggleUserStatus($userId) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($this->userModel->toggleStatus($userId)) {
                flash('admin_message', 'User status updated successfully');
            } else {
                flash('admin_message', 'Something went wrong', 'alert alert-danger');
            }
        }
        redirect('admin/users');
    }

    public function logs() {
        $userId = isset($_GET['user_id']) ? $_GET['user_id'] : null;
        $logs = $userId ? 
            $this->userModel->getLoginHistory($userId) : 
            $this->userModel->getAllLoginHistory();
        
        $users = $this->userModel->getAllUsers();
        
        $data = [
            'logs' => $logs,
            'users' => $users,
            'selectedUser' => $userId
        ];

        $this->view('admin/logs', $data);
    }

    public function createUser() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'role_id' => trim($_POST['role_id']),
                'status' => 'active',
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'role_err' => ''
            ];

            // Validation
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

            if(empty($data['role_id'])) {
                $data['role_err'] = 'Please select a role';
            }

            if(empty($data['username_err']) && empty($data['email_err']) && 
               empty($data['password_err']) && empty($data['role_err'])) {
                
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                if($this->userModel->createUser($data)) {
                    flash('admin_message', 'User created successfully');
                    redirect('admin/users');
                } else {
                    die('Something went wrong');
                }
            } else {
                $data['roles'] = $this->userModel->getAllRoles();
                $this->view('admin/create_user', $data);
            }
        } else {
            $data = [
                'username' => '',
                'email' => '',
                'password' => '',
                'role_id' => '',
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'role_err' => '',
                'roles' => $this->userModel->getAllRoles()
            ];

            $this->view('admin/create_user', $data);
        }
    }

    public function editUser($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => $id,
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'role_id' => trim($_POST['role_id']),
                'status' => trim($_POST['status']),
                'username_err' => '',
                'email_err' => '',
                'role_err' => ''
            ];

            if(empty($data['username'])) {
                $data['username_err'] = 'Please enter username';
            }

            if(empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } elseif($this->userModel->findUserByEmailExceptId($data['email'], $id)) {
                $data['email_err'] = 'Email is already taken';
            }

            if(empty($data['role_id'])) {
                $data['role_err'] = 'Please select a role';
            }

            if(empty($data['username_err']) && empty($data['email_err']) && empty($data['role_err'])) {
                if($this->userModel->updateUserByAdmin($data)) {
                    flash('admin_message', 'User updated successfully');
                    redirect('admin/users');
                } else {
                    die('Something went wrong');
                }
            } else {
                $data['roles'] = $this->userModel->getAllRoles();
                $this->view('admin/edit_user', $data);
            }
        } else {
            $user = $this->userModel->getUserById($id);
            
            if(!$user) {
                redirect('admin/users');
            }

            $data = [
                'id' => $id,
                'username' => $user->username,
                'email' => $user->email,
                'role_id' => $user->role_id,
                'status' => $user->status,
                'username_err' => '',
                'email_err' => '',
                'role_err' => '',
                'roles' => $this->userModel->getAllRoles()
            ];

            $this->view('admin/edit_user', $data);
        }
    }

    public function deleteUser($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($this->userModel->deleteUser($id)) {
                flash('admin_message', 'User removed successfully');
            } else {
                flash('admin_message', 'Something went wrong', 'alert alert-danger');
            }
        }
        redirect('admin/users');
    }
}