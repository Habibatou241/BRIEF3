<?php
class User {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function register($data) {
        $this->db->query('INSERT INTO users (username, email, password, role_id) VALUES (:username, :email, :password, :role_id)');
        
        // Bind values
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        $this->db->bind(':role_id', 2); // Default role is client

        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function login($email, $password) {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        if($row) {
            $hashed_password = $row->password;
            if(password_verify($password, $hashed_password)) {
                return $row;
            }
        }
        return false;
    }

    public function loginWithRole($email, $password, $role) {
        $this->db->query('SELECT * FROM users WHERE email = :email AND role_id = :role');
        $this->db->bind(':email', $email);
        $this->db->bind(':role', $role);

        $row = $this->db->single();

        if($row) {
            $hashed_password = $row->password;
            if(password_verify($password, $hashed_password)) {
                return $row;
            }
        }
        return false;
    }

    public function findUserByEmail($email) {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        return ($row) ? true : false;
    }

    public function findUserByEmailExceptId($email, $id) {
        $this->db->query('SELECT * FROM users WHERE email = :email AND id != :id');
        $this->db->bind(':email', $email);
        $this->db->bind(':id', $id);

        $row = $this->db->single();
        return $this->db->rowCount() > 0;
    }

    public function verifyPassword($id, $password) {
        $this->db->query('SELECT password FROM users WHERE id = :id');
        $this->db->bind(':id', $id);

        $row = $this->db->single();
        return password_verify($password, $row->password);
    }

   

    public function getAllUsers() {
        $this->db->query('SELECT users.*, roles.name as role_name 
                         FROM users 
                         JOIN roles ON users.role_id = roles.id 
                         ORDER BY users.username');
        return $this->db->resultSet();
    }

    public function searchUsers($search, $status, $role) {
        $sql = 'SELECT users.*, roles.name as role_name 
                FROM users 
                JOIN roles ON users.role_id = roles.id 
                WHERE 1=1';
        
        if($search) {
            $sql .= ' AND (users.username LIKE :search OR users.email LIKE :search)';
        }
        if($status) {
            $sql .= ' AND users.status = :status';
        }
        if($role) {
            $sql .= ' AND users.role_id = :role';
        }
        
        $sql .= ' ORDER BY users.username';
        
        $this->db->query($sql);
        
        if($search) {
            $this->db->bind(':search', '%' . $search . '%');
        }
        if($status) {
            $this->db->bind(':status', $status);
        }
        if($role) {
            $this->db->bind(':role', $role);
        }
        
        return $this->db->resultSet();
    }

    public function getUserById($id) {
        $this->db->query('SELECT users.*, roles.name as role_name 
                         FROM users 
                         JOIN roles ON users.role_id = roles.id 
                         WHERE users.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function updateUserByAdmin($data) {
        $this->db->query('UPDATE users SET username = :username, email = :email, 
                         role_id = :role_id, status = :status WHERE id = :id');
        
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':role_id', $data['role_id']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':id', $data['id']);
        
        return $this->db->execute();
    }

    public function toggleStatus($userId) {
        $this->db->query('UPDATE users SET status = CASE 
                         WHEN status = "active" THEN "inactive" 
                         ELSE "active" END 
                         WHERE id = :id');
        $this->db->bind(':id', $userId);
        return $this->db->execute();
    }

    public function logLogin($userId) {
        $this->db->query('INSERT INTO sessions (user_id) VALUES (:user_id)');
        $this->db->bind(':user_id', $userId);
        return $this->db->execute();
    }

    public function logLogout($userId) {
        $this->db->query('UPDATE sessions 
                         SET logout_time = CURRENT_TIMESTAMP 
                         WHERE user_id = :user_id 
                         AND logout_time IS NULL');
        $this->db->bind(':user_id', $userId);
        return $this->db->execute();
    }

    public function createUser($data) {
        $this->db->query('INSERT INTO users (username, email, password, role_id, status) 
                         VALUES (:username, :email, :password, :role_id, :status)');
        
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        $this->db->bind(':role_id', $data['role_id']);
        $this->db->bind(':status', $data['status']);

        return $this->db->execute();
    }

    public function getLoginHistory($userId) {
        $this->db->query('SELECT * FROM sessions 
                          WHERE user_id = :userId 
                          ORDER BY login_time DESC 
                          LIMIT 10');
        $this->db->bind(':userId', $userId);
        return $this->db->resultSet();
    }

    public function getAllRoles() {
        $this->db->query('SELECT * FROM roles ORDER BY name');
        return $this->db->resultSet();
    }

    public function updateUser($data) {
        $user = $this->getUserById($data['id']);
        
        // If changing password, verify current password
        if(!empty($data['new_password'])) {
            if(!password_verify($data['current_password'], $user->password)) {
                return false;
            }
            $password = password_hash($data['new_password'], PASSWORD_DEFAULT);
            
            $this->db->query('UPDATE users SET username = :username, email = :email, password = :password WHERE id = :id');
            $this->db->bind(':password', $password);
        } else {
            $this->db->query('UPDATE users SET username = :username, email = :email WHERE id = :id');
        }
        
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':id', $data['id']);
    
        return $this->db->execute();
    }

    public function getAllLoginHistory() {
        $this->db->query('SELECT sessions.*, users.username, users.email 
                          FROM sessions 
                          JOIN users ON sessions.user_id = users.id 
                          ORDER BY login_time DESC');
        return $this->db->resultSet();
    }

    public function deleteUser($id) {
        // First, delete related sessions
        $this->db->query('DELETE FROM sessions WHERE user_id = :id');
        $this->db->bind(':id', $id);
        $this->db->execute();

        // Then delete the user
        $this->db->query('DELETE FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}