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
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>