<?php

namespace App\models;

use PDO;
use PHPMailer\PHPMailer\Exception;

class UserModel
{
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

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

    public function resetPassword($email, $reset_token_hash, $reset_token_expires_at)
    {
        $stmt = $this->db->prepare("UPDATE users SET reset_token_hash = :reset_token_hash, reset_token_expires_at = :reset_token_expires_at WHERE email = :email");
        $stmt->execute([
            'reset_token_hash' => $reset_token_hash,
            'reset_token_expires_at' => $reset_token_expires_at,
            'email' => $email
        ]);

        if ($stmt->rowCount() > 0) {
            $mail = require __DIR__ . "/mailer.php";
            $mail->setFrom('noreply@example.com');
            $mail->addAddress($email);
            $mail->Subject = 'Password Reset Request';
            $mail->Body = "Click the link to reset your password: <a href='http://localhost:3000/reset?token=$reset_token_hash'>Reset Password</a>";

            try {
                $mail->send();
                $_SESSION['success'] = "Password reset link sent to your email.";
                return true;
            } catch (Exception $e) {
                error_log("Failed to send password reset email: " . $e->getMessage());
                return false;
            }
        }

        return false;
    }

    public function updatePassword($token, $new_password)
    {
        $stmt = $this->db->prepare("UPDATE users SET password = :password WHERE reset_token_hash = :reset_token_hash");
        $stmt->execute([
            'password' => password_hash($new_password, PASSWORD_BCRYPT),
            'reset_token_hash' => $token
        ]);

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }   
}
