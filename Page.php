<?php

namespace App;

class Page
{
    private \Twig\Environment $twig;
    private $link;
    public $session;

    function __construct()
    {
        $this->session = new Session();
        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $this->twig = new \Twig\Environment($loader, [
            'cache' => '../var/cache/compilation_cache',
            'debug' => true
        ]);

        $this->link = new \PDO('mysql:host=mysql;dbname=b2-paris', "root", "");
    }

    public function insert(string $table_name, array $data)
    {
        $sql = "INSERT INTO ". $table_name ." (email, password, last_name, first_name, postal_nb,role) VALUES (:email, :password, :last_name, :first_name, :postal_nb, :role)";
        $stmt = $this->link->prepare($sql);
        $stmt->execute($data);
    }

    public function getUserByEmail(string $email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->link->prepare($sql);
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $user;
    }
    public function isConnected()
    {
        return isset($_SESSION['user']);
    }
    public function hasRole(string $role)
    {
        if (!$this->isConnected()) {
            return false;
        }
       // return isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == $role;
    
         return $_SESSION['user']['role'] == $role ? true : false;
    }

    public function render(string $name, array $data) :string
    {
        return $this->twig->render($name, $data);
    }
    // public function getPdo()
    // {
    //     return $this->pdo;
    // }

    public function getAllUsers(){
        $sql = "SELECT * FROM users";
        $stmt = $this->link->prepare($sql);
        $stmt->execute();
        $users = $stmt ->fetchAll(\PDO::FETCH_ASSOC);
        return $users;
    }
    
    public function deleteUser($user_id)
{
    $sql = "DELETE FROM users WHERE user_id = :user_id";
    $stmt = $this->link->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);
}

public function updateUserPassword(array $data) {
    $sql = "UPDATE users SET password = :password WHERE email = :email";
    $stmt = $this->link->prepare($sql);
    return $stmt->execute($data);
}

}