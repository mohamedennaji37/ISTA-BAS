<?php

class AuthController {

    public function login($username, $password) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $user = Users::findByUsername($username);

        if ($user && password_verify($password, $user->getPassword())) {
            $_SESSION['user_id'] = $user->getUserId();
            $_SESSION['username'] = $user->getUsername();
            $_SESSION['role'] = $user->getRole();
            $_SESSION['blocked'] = $user->isBlocked();

            if ($_SESSION['blocked'] == 0 && $_SESSION['role'] === 'admin') {
                header('Location: /ABS-ISTA/dashboard');
            }elseif($_SESSION['blocked'] == 0 && $_SESSION['role'] === 'gestionnaire'){
                header('Location: /ABS-ISTA/absence/gestionnaireView');
            }
             else {
                header('Location: /ABS-ISTA/blocked?blocked=' . urlencode('Votre compte est bloqué.'));
            }
        } else {
            header('Location: /ABS-ISTA/login?error=' . urlencode('Nom d’utilisateur ou mot de passe invalide.'));
        }
        exit();
    }

    public static function isAuthenticated() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user_id']);
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        require_once __DIR__ . '/../views/auth/login.php'; // Corrected path
        exit();
    }

    public function unauthorizedPage(){
        require_once __DIR__ . '/../views/auth/unauthorized.php'; // Corrected path
        exit();
    }	

    // Redirect to the login view
    public function redirectToLogin($error = null) {
        if (is_array($error)) {
            $error = null; // Handle route calls with no parameters
        }
        if ($error) {
            header('Location: /ABS-ISTA/login?error=' . urlencode($error));
        } else {
            require_once __DIR__ . '/../views/auth/login.php'; // Fixed path
        }
        exit();
    }

    //get gestion users view 
    public function usersView() {
        $users = Users::findAll(); // Fetch all users
        require_once __DIR__ . '/../views/auth/gestion-users.php';
        exit();
    }

    // Render the add user view
    public function addUserView() {
        require_once __DIR__ . '/../views/auth/addUserForm.php';
        exit();
    }

    
    public function createUser() {
        if (Users::findByUsername($_POST['username'])) {
            echo "Error: Username already exists.";
            return;
        }
        $hashedPassword = password_hash($_POST['password'], PASSWORD_BCRYPT); // Fixed extra $
        $user = new Users();
        $user->setUsername($_POST['username']); // Fixed extra $
        $user->setPassword($hashedPassword);
        $user->setRole($_POST['role']); // Fixed extra $
        $user->create($user);
        header('Location: /ABS-ISTA/users?message=' . urlencode('User created successfully.'));
        exit();
    }


    public function toggleAccountStatus() {
        $userId = $_POST['user_id'];
        $blockedNum = $_POST['blockedNum'];
        if ($blockedNum == 0) {
            $user = new Users();
            $newStatus = $user->changeStatustoOne($userId);
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            if ($_SESSION['user_id'] == $userId) {
                $_SESSION['blocked'] = 1; // Update session if the current user is blocked
            }
            header('Location: /ABS-ISTA/users?message=' . urlencode('User blocked successfully.'));
        } else {
            $user = new Users();
            $newStatus = $user->changeStatustoZero($userId);
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            if ($_SESSION['user_id'] == $userId) {
                $_SESSION['blocked'] = 0; // Update session if the current user is unblocked
            }
            header('Location: /ABS-ISTA/users?message=' . urlencode('User unblocked successfully.'));
        }
        exit();
    }

}
