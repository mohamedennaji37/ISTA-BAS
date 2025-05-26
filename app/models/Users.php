<?php

class Users
{
    private $user_id;
    private $username;
    private $password;
    private $role;
    private $blocked;

    public function create($user)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        return $stmt->execute([$user->getUsername(), $user->getPassword(), $user->getRole()]);
    }

    public function read($id)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function findAll()
    {
        $db = Database::getInstance()->getConnection();
        $query = $db->query("SELECT * FROM users where user_id != 1 and user_id != 2");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findByUsername($username)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $user = new Users();
            $user->setUserId($data['user_id']);
            $user->setUsername($data['username']);
            $user->setPassword($data['password']);
            $user->setRole($data['role']);
            $user->blocked = $data['blocked'];
            return $user;
        }
        return null;
    }

    public function update($id, $data)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE users SET username = ?, password = ?, role = ? WHERE user_id = ?");
        return $stmt->execute([$data['username'], $data['password'], $data['role'], $id]);
    }

    // Bloquer un compte par ID
    public function blockAccount($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE accounts SET blocked = 1 WHERE id = ?");
        $stmt->execute([$id]);
    }

    // Toggle the is_blocked status in the database
    public function changeStatustoOne($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE users SET blocked = 1 WHERE user_id = ?");
        $stmt->execute([$id]);

        $stmt = $db->prepare("SELECT blocked FROM users WHERE user_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchColumn();
    }
    public function changeStatustoZero($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE users SET blocked = 0 WHERE user_id = ?");
        $stmt->execute([$id]);

        $stmt = $db->prepare("SELECT blocked FROM users WHERE user_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchColumn();
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }
    public function isBlocked()
    {
        return $this->blocked;
    }

    
}
