<?php
class Pages extends Controller {
    public function __construct() {
        $this->userModel = $this->model('User');
    }

    public function index() {
        if(isLoggedIn()) {
            redirect('users/profile');
        }

        $data = [
            'title' => 'Welcome',
            'description' => 'Simple user management system'
        ];

        $this->view('pages/index', $data);
    }
}