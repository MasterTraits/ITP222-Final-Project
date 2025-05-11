<?php
namespace App\models;

use PDO;

class UserModel
{
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // Find user by email
    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result !== false ? $result : null;
    }

    public function create($email, $given, $surname, $password)
    {
        $stmt = $this->db->prepare("INSERT INTO users (email, given, surname, password) VALUES (:email, :given, :surname, :password)");
        return $stmt->execute([
            'email' => $email,
            'given' => $given,
            'surname' => $surname,
            'password' => password_hash($password, PASSWORD_BCRYPT)
        ]);
    }
}

?>