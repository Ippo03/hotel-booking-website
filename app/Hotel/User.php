<?php

/**
 * The User class provides functionality related to user management, such as user retrieval, insertion, and authentication.
 */

namespace Hotel;

use PDO;
use Hotel\BaseService;

class User extends BaseService
{   
    const TOKEN_KEY = 'asfdhkgjlr;ofijhgbfdklfsadf';
    
    private static $currentUserId;

    public function getByUserId($userId)
    {   
        // Prepare parameters
        $parameters = [
            ':user_id' => $userId
        ];

        return $this->fetch('SELECT * FROM user WHERE user_id = :user_id', $parameters);
    }

    public function getByEmail($email)
    {
        // Prepare parameters
        $parameters = [
            ':email' => $email
        ];
        
        return $this->fetch('SELECT * FROM user WHERE email = :email', $parameters);
    }

    public function getList()
    {
        return $this->fetchAll('SELECT * FROM user');
    }

    public function insert($name, $email, $password)
    {
        // Hash password
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        // Prepare parameters
        $parameters = [
            ':name' => $name,
            ':email' => $email,
            ':password' => $passwordHash
        ];
        $rows = $this->execute('INSERT INTO user (name, email, password) VALUES (:name, :email, :password)', 
            $parameters);

        return $rows == 1;
    }

    public function verify($email, $password) 
    {
        // Step 1 - Retrieve user by email
        $user = $this->getByEmail($email);

        // Step 2 - Verify password
        return password_verify($password, $user['password']);
    }

    public function getUserToken($userId)
    {
        // Create token payload
        $payload = [
            'user_id' => $userId,
            'csrf' => md5(time()),
        ];
        $payloadEncoded = base64_encode(json_encode($payload));
        $signature = hash_hmac('sha256', $payloadEncoded, self::TOKEN_KEY);

        return sprintf('%s.%s', $payloadEncoded, $signature);
    }

    public function getTokenPayload($token)
    {
        // Get payload and signature
        [$payloadEncoded] = explode('.', $token);

        // Get payload
        return json_decode(base64_decode($payloadEncoded), true);
    }

    public function verifyToken($token)
    {
        // Get payload
        $payload = $this->getTokenPayload($token);
        $userId = $payload['user_id'];
        $csrf = $payload['csrf'];

        // Generate signature and verify
        return $this->getUserToken($userId, $csrf) == $token;
    }

    public static function verifyCsrf($csrf)
    {
        return self::getCsrf() == $csrf;
    }

    public static function getCsrf()
    {
        // Get token payload
        $token = $_COOKIE['user_token'];
        $user = new self(); 
        $payload = $user->getTokenPayload($token); 

        return $payload['csrf'];
    }
}